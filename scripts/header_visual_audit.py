#!/usr/bin/env python3
"""Rendered Production Header audit using Chrome/Selenium."""
from __future__ import annotations
import json, os, time
from pathlib import Path
from selenium import webdriver
from selenium.webdriver.chrome.options import Options
from selenium.webdriver.support.ui import WebDriverWait

BASE = os.environ.get('WP_BASE_URL', 'https://alookhor.ir').rstrip('/')
OUT = Path(os.environ.get('HEADER_VISUAL_REPORT', '/tmp/header-visual.json'))
SHOT_DIR = Path(os.environ.get('HEADER_VISUAL_SHOTS', '/tmp/header-shots'))
SHOT_DIR.mkdir(parents=True, exist_ok=True)

JS_METRICS = r"""
const one=s=>document.querySelector(s), all=s=>[...document.querySelectorAll(s)];
const rect=e=>e?Object.fromEntries(['top','right','bottom','left','width','height'].map(k=>[k,Math.round(e.getBoundingClientRect()[k]*10)/10])):null;
const visible=e=>!!e&&getComputedStyle(e).display!=='none'&&getComputedStyle(e).visibility!=='hidden'&&e.getBoundingClientRect().height>0;
const root=one('.alookhor-managed-legacy-header'),topbar=one('.alookhor-topbar-wrapper'),header=one('.alookhor-header'),stage=one('.alookhor-legacy-nav-stage'),capsule=one('.header-capsule');
const main=one('#main-content')||one('.main-page-wrapper')||one('main');
const visibleBottom=[topbar,header,stage].filter(visible).map(e=>e.getBoundingClientRect().bottom);
const footprintBottom=visibleBottom.length?Math.max(...visibleBottom):0;
return {
  viewport:{width:innerWidth,height:innerHeight,dpr:devicePixelRatio},
  root:!!root,topbar:rect(topbar),header:rect(header),stage:rect(stage),capsule:rect(capsule),main:rect(main),
  stage_display:stage?getComputedStyle(stage).display:null,stage_position:stage?getComputedStyle(stage).position:null,stage_stuck:stage?.classList.contains('is-stuck')||false,
  search_count:all('.alookhor-legacy-main-search').length,mobile_extra_toggle_count:all('.alookhor-mobile-sticky-toggle').length,
  original_drawer_id_count:all('#openDrawer').length,cart_count:all('.alookhor-header-cart-link').length,
  main_toggle_count:all('.alookhor-main-menu-toggle').length,logo_count:all('.header-capsule-logo img').length,
  body_scroll_width:document.documentElement.scrollWidth,body_client_width:document.documentElement.clientWidth,
  horizontal_overflow:Math.max(0,document.documentElement.scrollWidth-document.documentElement.clientWidth),
  header_to_main_gap:main?Math.round((main.getBoundingClientRect().top-footprintBottom)*10)/10:null,
  body_classes:document.body.className,
  ancestors:root?[...function*(){let n=root.parentElement,i=0;while(n&&i++<8){yield {tag:n.tagName,id:n.id||'',class:n.className||'',rect:rect(n),display:getComputedStyle(n).display,position:getComputedStyle(n).position,min_height:getComputedStyle(n).minHeight,height:getComputedStyle(n).height};n=n.parentElement}}()]:[],
  woodmart_headers:['.whb-header','.whb-main-header','.whb-general-header','.whb-general-header-inner','.whb-header_816684'].map(selector=>({selector,count:all(selector).length,items:all(selector).slice(0,3).map(e=>({rect:rect(e),display:getComputedStyle(e).display,position:getComputedStyle(e).position,height:getComputedStyle(e).height,min_height:getComputedStyle(e).minHeight}))})),
  body_children:[...document.body.children].slice(0,20).map(e=>({tag:e.tagName,id:e.id||'',class:e.className||'',rect:rect(e),display:getComputedStyle(e).display,position:getComputedStyle(e).position,margin_top:getComputedStyle(e).marginTop,padding_top:getComputedStyle(e).paddingTop,top:getComputedStyle(e).top,transform:getComputedStyle(e).transform})),
  wrapper_style:(()=>{const e=one('.website-wrapper');const c=e?getComputedStyle(e):null;return c?{margin_top:c.marginTop,padding_top:c.paddingTop,top:c.top,transform:c.transform}:null})()
};
"""

def audit(width: int, height: int, label: str) -> dict:
    options = Options()
    options.add_argument('--headless=new'); options.add_argument('--no-sandbox'); options.add_argument('--disable-dev-shm-usage')
    options.add_argument('--disable-gpu'); options.add_argument(f'--window-size={width},{height}')
    options.add_argument('--hide-scrollbars'); options.add_argument('--force-device-scale-factor=1')
    driver = webdriver.Chrome(options=options)
    try:
        driver.set_window_size(width, height)
        driver.get(f'{BASE}/?rendered_header_audit=3107-{label}-{int(time.time())}')
        WebDriverWait(driver, 40).until(lambda d: d.execute_script("return !!document.querySelector('.alookhor-managed-legacy-header .header-capsule')"))
        time.sleep(4)
        before = driver.execute_script(JS_METRICS)
        driver.save_screenshot(str(SHOT_DIR / f'{label}-before.png'))
        driver.execute_script('window.scrollTo(0, Math.min(900, document.documentElement.scrollHeight-innerHeight));')
        time.sleep(1.2)
        after = driver.execute_script(JS_METRICS)
        driver.save_screenshot(str(SHOT_DIR / f'{label}-after.png'))
        expected_mobile = width <= 1023
        checks = {
            'root': before['root'] is True,
            'search_removed': before['search_count'] == 0,
            'no_rejected_mobile_toggle': before['mobile_extra_toggle_count'] == 0,
            'drawer_id_unique': before['original_drawer_id_count'] == 1,
            'cart_present': before['cart_count'] == 1,
            'main_toggle_present': before['main_toggle_count'] == 1,
            'logo_present': before['logo_count'] == 1,
            'no_horizontal_overflow': before['horizontal_overflow'] <= 2,
            'mobile_stage_hidden': before['stage_display'] == 'none' if expected_mobile else True,
            'desktop_stage_visible': before['stage_display'] != 'none' if not expected_mobile else True,
            'desktop_nav_sticky': (after['stage_position'] == 'sticky' and after['stage_stuck'] is True and abs(after['stage']['top']) <= 2) if not expected_mobile else True,
            'upper_rows_leave_viewport': (after['topbar']['bottom'] < 2 and after['header']['bottom'] < 2) if not expected_mobile else True,
            'no_large_header_gap': before['header_to_main_gap'] is None or before['header_to_main_gap'] <= 100,
        }
        return {'label':label,'before':before,'after':after,'checks':checks,'ok':all(checks.values())}
    finally:
        driver.quit()

report={'url':BASE,'created_at':int(time.time()),'views':{},'ok':False}
try:
    report['views']['desktop']=audit(1440,1050,'desktop')
    report['views']['mobile']=audit(430,932,'mobile')
    report['ok']=all(v['ok'] for v in report['views'].values())
except Exception as error:
    report['error']=f'{type(error).__name__}: {error}'
OUT.write_text(json.dumps(report,ensure_ascii=False,indent=2)+'\n')
print(json.dumps(report,ensure_ascii=False,indent=2))
if not report['ok']: raise SystemExit(1)
