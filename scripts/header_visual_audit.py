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
const hero=one('#alookhor-managed-hero'),heroShell=hero?.querySelector('.alookhor-mh-shell'),heroContent=hero?.querySelector('.alookhor-mh-slide.is-active .alookhor-mh-content'),heroImage=hero?.querySelector('.alookhor-mh-slide.is-active img');
const main=one('#main-content')||one('.main-page-wrapper')||one('main');
const visibleBottom=[topbar,header,stage].filter(visible).map(e=>e.getBoundingClientRect().bottom);
const footprintBottom=visibleBottom.length?Math.max(...visibleBottom):0;
return {
  viewport:{width:innerWidth,height:innerHeight,dpr:devicePixelRatio},runtime_version:String(window.ALOOKHOR_TOPBAR?.version||''),
  root:!!root,topbar:rect(topbar),header:rect(header),stage:rect(stage),capsule:rect(capsule),main:rect(main),logo:rect(one('.header-capsule-logo img')),
  hero:rect(hero),hero_shell:rect(heroShell),hero_content:rect(heroContent),hero_image:rect(heroImage),hero_mounted:hero?.dataset.mounted==='1',
  hero_slide_count:hero?all('#alookhor-managed-hero .alookhor-mh-slide').length:0,hero_active_count:hero?all('#alookhor-managed-hero .alookhor-mh-slide.is-active').length:0,
  hero_feature_count:hero?all('#alookhor-managed-hero .alookhor-mh-slide.is-active .alookhor-mh-feature').length:0,hero_cta_count:hero?all('#alookhor-managed-hero .alookhor-mh-slide.is-active .alookhor-mh-cta').length:0,
  hero_legacy_visible:all('.alookhor-hero-slider-wrapper').filter(visible).length,hero_old_slider_id_count:all('#alookhorHeroSlider').length,
  hero_content_align:heroContent?getComputedStyle(heroContent).textAlign:null,hero_overflow:heroShell?getComputedStyle(heroShell).overflow:null,
  hero_image_loaded:!!heroImage&&heroImage.complete&&heroImage.naturalWidth>0,hero_image_natural:heroImage?{width:heroImage.naturalWidth,height:heroImage.naturalHeight}:null,
  hero_arrows:hero?all('#alookhor-managed-hero .alookhor-mh-arrow').filter(visible).map(e=>({rect:rect(e),background:getComputedStyle(e).backgroundColor,border_radius:getComputedStyle(e).borderRadius,appearance:getComputedStyle(e).appearance})):[],
  topbar_center_display:one('.topbar-center')?getComputedStyle(one('.topbar-center')).display:null,
  stage_display:stage?getComputedStyle(stage).display:null,stage_position:stage?getComputedStyle(stage).position:null,stage_stuck:stage?.classList.contains('is-stuck')||false,
  search_count:all('.alookhor-legacy-main-search').length,mobile_extra_toggle_count:all('.alookhor-mobile-sticky-toggle').length,
  original_drawer_id_count:all('#openDrawer').length,cart_count:all('.alookhor-header-cart-link').length,
  main_toggle_count:all('.alookhor-main-menu-toggle').length,logo_count:all('.header-capsule-logo img').length,logo_copy_count:all('.alookhor-logo-copy').length,topbar_support_count:all('.alookhor-topbar-support').length,
  account_font_size:one('.header-login-btn')?getComputedStyle(one('.header-login-btn')).fontSize:null,account_icon_count:all('.header-login-btn .alookhor-account-icon').length,
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
        runtime_version = driver.execute_script("return String(window.ALOOKHOR_TOPBAR?.version||'0.0.0')")
        runtime_parts = tuple(int(part) for part in runtime_version.split('.') if part.isdigit())
        hero_expected = runtime_parts >= (3, 10, 13)
        if hero_expected:
            WebDriverWait(driver, 40).until(lambda d: d.execute_script("return document.querySelector('#alookhor-managed-hero')?.dataset.mounted==='1' && document.querySelectorAll('#alookhor-managed-hero .alookhor-mh-slide').length===4"))
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
            'horizontal_wordmark_present': before['logo_copy_count'] == 1,
            'topbar_support_present': before['topbar_support_count'] == 1,
            'mobile_account_icon_only': (before['account_font_size'] == '0px' and before['account_icon_count'] == 1) if expected_mobile else True,
            'no_horizontal_overflow': before['horizontal_overflow'] <= 2,
            'mobile_stage_hidden': before['stage_display'] == 'none' if expected_mobile else True,
            'desktop_stage_visible': before['stage_display'] != 'none' if not expected_mobile else True,
            'desktop_nav_sticky': (after['stage_position'] in {'sticky','fixed'} and after['stage_stuck'] is True and abs(after['stage']['top']) <= 2) if not expected_mobile else True,
            'header_starts_near_viewport_top': before['topbar'] is not None and before['topbar']['top'] <= 25,
            'topbar_duplicate_logo_hidden': before['topbar_center_display'] == 'none',
            'logo_contained_in_capsule': before['logo'] is not None and before['capsule'] is not None and before['logo']['top'] >= before['capsule']['top']-1 and before['logo']['bottom'] <= before['capsule']['bottom']+1,
            'upper_rows_leave_viewport': (after['topbar']['bottom'] < 2 and after['header']['bottom'] < 2) if not expected_mobile else True,
            'no_large_header_gap': before['header_to_main_gap'] is None or before['header_to_main_gap'] <= 100,
            'hero_mounted': before['hero_mounted'] is True if hero_expected else True,
            'hero_exactly_four_slides': before['hero_slide_count'] == 4 if hero_expected else True,
            'hero_single_active_slide': before['hero_active_count'] == 1 if hero_expected else True,
            'hero_replaces_legacy': (before['hero_legacy_visible'] == 0 and before['hero_old_slider_id_count'] == 0) if hero_expected else True,
            'hero_image_loaded': before['hero_image_loaded'] is True if hero_expected else True,
            'hero_layered_content': (before['hero_feature_count'] == 4 and before['hero_cta_count'] >= 1) if hero_expected else True,
            'hero_arrows_isolated': (
                len(before['hero_arrows']) == 2
                and all(36 <= arrow['rect']['width'] <= 50 and 36 <= arrow['rect']['height'] <= 50
                        and arrow['border_radius'] == '50%'
                        and arrow['background'] not in {'rgb(255, 255, 255)', 'rgba(255, 255, 255, 1)'}
                        for arrow in before['hero_arrows'])
            ) if hero_expected else True,
            'hero_content_on_right': (
                before['hero_content'] is not None and before['hero_shell'] is not None
                and before['hero_content']['left'] + before['hero_content']['width'] / 2 > before['hero_shell']['left'] + before['hero_shell']['width'] / 2
                and before['hero_content_align'] == 'right'
            ) if hero_expected else True,
            'mobile_hero_under_glass_capsule': (
                before['hero_shell'] is not None and before['capsule'] is not None
                and before['capsule']['top'] < before['hero_shell']['top'] < before['capsule']['bottom']
            ) if hero_expected and expected_mobile else True,
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
