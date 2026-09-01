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
const legacyRoot=one('.alookhor-managed-legacy-header'),portalRoot=one('.alookhor-portal-header'),root=portalRoot||legacyRoot;
const topbar=portalRoot?.querySelector('.alookhor-topbar')||legacyRoot?.querySelector('.alookhor-topbar-wrapper');
const header=portalRoot?.querySelector('.alookhor-nav-stage')||legacyRoot?.querySelector('.alookhor-header');
const stage=portalRoot?.querySelector('.alookhor-nav-stage')||legacyRoot?.querySelector('.alookhor-legacy-nav-stage');
const capsule=portalRoot?.querySelector('.alookhor-nav-shell')||legacyRoot?.querySelector('.header-capsule');
const navigation=portalRoot?.querySelector('.alookhor-desktop-nav')||legacyRoot?.querySelector('.alookhor-legacy-nav-stage .header-nav-center');
const navShell=portalRoot?.querySelector('.alookhor-nav-shell')||legacyRoot?.querySelector('.alookhor-legacy-nav-shell');
const logoBox=portalRoot?.querySelector('.alookhor-nav-logo')||legacyRoot?.querySelector('.header-capsule-logo');
const topbarPhone=portalRoot?.querySelector('.alookhor-contact-link[href^="tel:"]')||legacyRoot?.querySelector('.alookhor-managed-phone');
const topbarSupport=portalRoot?.querySelector('.alookhor-fallback-support')||legacyRoot?.querySelector('.alookhor-topbar-support');
const topbarMessage=portalRoot?.querySelector('.alookhor-export-note')||legacyRoot?.querySelector('.topbar-export-badge');
const hero=one('#alookhor-managed-hero'),heroShell=hero?.querySelector('.alookhor-mh-shell'),heroContent=hero?.querySelector('.alookhor-mh-slide.is-active .alookhor-mh-content'),heroImage=hero?.querySelector('.alookhor-mh-slide.is-active img');
const features=one('#alookhor-managed-features'),featureGrid=features?.querySelector('.alookhor-sf-grid'),featureCards=features?all('#alookhor-managed-features .alookhor-sf-card'):[];
const main=one('#main-content')||one('.main-page-wrapper')||one('main');
const visibleBottom=[topbar,header,stage].filter(visible).map(e=>e.getBoundingClientRect().bottom);
const footprintBottom=visibleBottom.length?Math.max(...visibleBottom):0;
return {
  viewport:{width:innerWidth,height:innerHeight,dpr:devicePixelRatio},runtime_version:String(window.ALOOKHOR_TOPBAR?.version||''),
  root:!!root,header_mode:portalRoot?'portal':(legacyRoot?'legacy':'none'),topbar:rect(topbar),header:rect(header),stage:rect(stage),capsule:rect(capsule),main:rect(main),logo:rect(root?.querySelector('.header-capsule-logo img,.alookhor-nav-logo img')),logo_box:rect(logoBox),
  navigation:rect(navigation),navigation_display:navigation?getComputedStyle(navigation).display:null,nav_shell:rect(navShell),stage_integrated:portalRoot?true:(legacyRoot?(stage?.classList.contains('is-capsule-integrated')||false):false),
  topbar_phone:rect(topbarPhone),topbar_support:rect(topbarSupport),topbar_message:rect(topbarMessage),
  topbar_style:topbar?{background_color:getComputedStyle(topbar).backgroundColor,background_image:getComputedStyle(topbar).backgroundImage,backdrop_filter:getComputedStyle(topbar).backdropFilter||getComputedStyle(topbar).webkitBackdropFilter,border_color:getComputedStyle(topbar).borderBottomColor}:null,
  topbar_role_colors:{phone:topbarPhone?getComputedStyle(topbarPhone).color:null,support:topbarSupport?getComputedStyle(topbarSupport).color:null,message:topbarMessage?getComputedStyle(topbarMessage).color:null},
  capsule_style:capsule?{background_color:getComputedStyle(capsule).backgroundColor,background_image:getComputedStyle(capsule).backgroundImage,backdrop_filter:getComputedStyle(capsule).backdropFilter||getComputedStyle(capsule).webkitBackdropFilter,border_color:getComputedStyle(capsule).borderColor,box_shadow:getComputedStyle(capsule).boxShadow}:null,
  capsule_palette:root?Object.fromEntries(['--alookhor-capsule-background','--alookhor-capsule-card','--alookhor-capsule-glass','--alookhor-capsule-gold','--alookhor-capsule-gold-light','--alookhor-capsule-text','--alookhor-capsule-muted','--alookhor-capsule-blur'].map(k=>[k,getComputedStyle(root).getPropertyValue(k).trim()])):{},
  capsule_control_colors:(()=>{const menu=root?.querySelector('.header-capsule .alookhor-main-menu-toggle,.alookhor-nav-shell .alookhor-menu-toggle'),account=root?.querySelector('.header-capsule .header-login-btn svg,.alookhor-nav-shell .alookhor-account-link svg'),cart=root?.querySelector('.header-capsule .alookhor-header-cart-link,.alookhor-nav-shell .alookhor-fallback-cart');return {menu:menu?getComputedStyle(menu).color:null,account:account?getComputedStyle(account).color:null,cart:cart?getComputedStyle(cart).color:null}})(),
  hero:rect(hero),hero_shell:rect(heroShell),hero_content:rect(heroContent),hero_image:rect(heroImage),hero_mounted:hero?.dataset.mounted==='1',
  hero_slide_count:hero?all('#alookhor-managed-hero .alookhor-mh-slide').length:0,hero_active_count:hero?all('#alookhor-managed-hero .alookhor-mh-slide.is-active').length:0,
  hero_feature_count:hero?all('#alookhor-managed-hero .alookhor-mh-slide.is-active .alookhor-mh-feature').length:0,hero_cta_count:hero?all('#alookhor-managed-hero .alookhor-mh-slide.is-active .alookhor-mh-cta').length:0,
  hero_legacy_visible:all('.alookhor-hero-slider-wrapper').filter(visible).length,hero_old_slider_id_count:all('#alookhorHeroSlider').length,
  hero_content_align:heroContent?getComputedStyle(heroContent).textAlign:null,hero_overflow:heroShell?getComputedStyle(heroShell).overflow:null,
  hero_image_loaded:!!heroImage&&heroImage.complete&&heroImage.naturalWidth>0,hero_image_natural:heroImage?{width:heroImage.naturalWidth,height:heroImage.naturalHeight}:null,
  hero_image_focus_class:heroImage?.closest('.alookhor-mh-slide')?.classList.contains('is-image-flipped')||false,
  hero_image_object_position:heroImage?getComputedStyle(heroImage).objectPosition:null,
  hero_image_transform:(()=>{if(!heroImage)return null;const m=new DOMMatrix(getComputedStyle(heroImage).transform);return {a:m.a,b:m.b,c:m.c,d:m.d,e:m.e,f:m.f,det:m.a*m.d-m.b*m.c}})(),
  hero_arrows:hero?all('#alookhor-managed-hero .alookhor-mh-arrow').filter(visible).map(e=>({rect:rect(e),background:getComputedStyle(e).backgroundColor,border_radius:getComputedStyle(e).borderRadius,appearance:getComputedStyle(e).appearance})):[],
  features:rect(features),feature_grid:rect(featureGrid),feature_mounted:features?.dataset.mounted==='1',feature_count:featureCards.length,
  feature_cards:featureCards.map(e=>({rect:rect(e),title:e.querySelector('h3')?.textContent.trim()||'',description:e.querySelector('p')?.textContent.trim()||'',background:getComputedStyle(e).backgroundColor,border_radius:getComputedStyle(e).borderRadius})),
  feature_legacy_visible:all('.alookhor-trustbar-container').filter(visible).length,
  feature_palette:features?Object.fromEntries(['--sf-bg','--sf-card','--sf-glass','--sf-gold','--sf-gold-light','--sf-text','--sf-muted'].map(k=>[k,getComputedStyle(features).getPropertyValue(k).trim()])):{},
  feature_to_hero_gap:(features&&hero)?Math.round((features.getBoundingClientRect().top-hero.getBoundingClientRect().bottom)*10)/10:null,
  topbar_center_display:(()=>{const e=portalRoot?.querySelector('.alookhor-top-logo')||legacyRoot?.querySelector('.topbar-center');return e?getComputedStyle(e).display:null})(),
  stage_display:stage?getComputedStyle(stage).display:null,stage_position:stage?getComputedStyle(stage).position:null,stage_stuck:portalRoot?(['sticky','fixed'].includes(getComputedStyle(stage).position)&&Math.abs(stage.getBoundingClientRect().top)<=50):(legacyRoot?(stage?.classList.contains('is-stuck')||false):false),
  search_count:all('.alookhor-legacy-main-search').length,mobile_extra_toggle_count:all('.alookhor-mobile-sticky-toggle').length,
  original_drawer_id_count:root?root.querySelectorAll('#openDrawer').length:0,generated_drawer_count:portalRoot?portalRoot.querySelectorAll('.alookhor-menu-drawer').length:0,cart_count:root?root.querySelectorAll('.alookhor-header-cart-link,.alookhor-fallback-cart').length:0,
  main_toggle_count:root?root.querySelectorAll('.alookhor-main-menu-toggle,.alookhor-menu-toggle').length:0,logo_count:root?root.querySelectorAll('.header-capsule-logo img,.alookhor-nav-logo img').length:0,logo_copy_count:root?root.querySelectorAll('.alookhor-logo-copy,.alookhor-nav-logo-copy').length:0,topbar_support_count:root?root.querySelectorAll('.alookhor-topbar-support,.alookhor-fallback-support').length:0,
  account_font_size:root?.querySelector('.header-login-btn')?getComputedStyle(root.querySelector('.header-login-btn')).fontSize:null,account_icon_count:root?root.querySelectorAll('.header-login-btn .alookhor-account-icon,.alookhor-account-link svg').length:0,account_text_display:root?.querySelector('.alookhor-account-link span')?getComputedStyle(root.querySelector('.alookhor-account-link span')).display:null,
  duplicate_visible_headers:all('.alookhor-header-wrapper,.alookhor-portal-header').filter(visible).length,raw_premium_shortcode:(document.body?.innerText||'').includes('[alookhor_premium_header]'),
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
        WebDriverWait(driver, 40).until(lambda d: d.execute_script("return !!document.querySelector('.alookhor-managed-legacy-header .header-capsule,.alookhor-portal-header .alookhor-nav-shell')"))
        runtime_version = driver.execute_script("return String(window.ALOOKHOR_TOPBAR?.version||'0.0.0')")
        runtime_parts = tuple(int(part) for part in runtime_version.split('.') if part.isdigit())
        hero_expected = runtime_parts >= (3, 10, 13)
        hero_polish_expected = runtime_parts >= (3, 10, 14)
        hero_image_polish_expected = runtime_parts >= (3, 10, 15)
        feature_expected = runtime_parts >= (3, 10, 16)
        feature_proximity_expected = runtime_parts >= (3, 10, 17)
        capsule_glass_expected = runtime_parts >= (3, 10, 18)
        header_reference_expected = runtime_parts >= (3, 10, 19)
        single_header_expected = runtime_parts >= (3, 10, 56)
        if hero_expected:
            WebDriverWait(driver, 40).until(lambda d: d.execute_script("return document.querySelector('#alookhor-managed-hero')?.dataset.mounted==='1' && document.querySelectorAll('#alookhor-managed-hero .alookhor-mh-slide').length===4"))
        if feature_expected:
            WebDriverWait(driver,40).until(lambda d:d.execute_script("return document.querySelector('#alookhor-managed-features')?.dataset.mounted==='1' && document.querySelectorAll('#alookhor-managed-features .alookhor-sf-card').length===4"))
        time.sleep(4)
        before = driver.execute_script(JS_METRICS)
        driver.save_screenshot(str(SHOT_DIR / f'{label}-before.png'))
        if feature_expected:
            driver.execute_script("const e=document.querySelector('#alookhor-managed-features');if(e)window.scrollTo(0,Math.max(0,e.getBoundingClientRect().top+scrollY-innerHeight*.35));")
            time.sleep(.7)
            driver.save_screenshot(str(SHOT_DIR / f'{label}-features.png'))
            driver.execute_script('window.scrollTo(0,0)');time.sleep(.4)
        driver.execute_script('window.scrollTo(0, Math.min(900, document.documentElement.scrollHeight-innerHeight));')
        time.sleep(1.2)
        after = driver.execute_script(JS_METRICS)
        driver.save_screenshot(str(SHOT_DIR / f'{label}-after.png'))
        expected_mobile = width <= 1023
        checks = {
            'root': before['root'] is True,
            'single_visible_header': before['duplicate_visible_headers']==1 if single_header_expected else True,
            'raw_premium_shortcode_removed': before['raw_premium_shortcode'] is False if single_header_expected else True,
            'search_removed': before['search_count'] == 0,
            'no_rejected_mobile_toggle': before['mobile_extra_toggle_count'] == 0,
            'drawer_id_unique': (before['original_drawer_id_count'] == 1 if before['header_mode']=='legacy' else before['generated_drawer_count']==1),
            'cart_present': before['cart_count'] == 1,
            'main_toggle_present': before['main_toggle_count'] == 1,
            'logo_present': before['logo_count'] == 1,
            'horizontal_wordmark_present': before['logo_copy_count'] == 1,
            'topbar_support_present': before['topbar_support_count'] == 1,
            'mobile_account_icon_only': ((before['account_font_size'] == '0px' and before['account_icon_count'] == 1) if before['header_mode']=='legacy' else (before['account_text_display']=='none' and before['account_icon_count']==1)) if expected_mobile else True,
            'no_horizontal_overflow': before['horizontal_overflow'] <= 2,
            'mobile_stage_hidden': ((before['stage_display']=='none') if before['header_mode']=='legacy' else before['navigation_display']=='none') if expected_mobile else True,
            'desktop_stage_visible': before['stage_display'] != 'none' if not expected_mobile else True,
            'desktop_nav_sticky': (after['stage_position'] in {'sticky','fixed'} and after['stage_stuck'] is True and abs(after['stage']['top']) <= 2) if not expected_mobile else True,
            'header_starts_near_viewport_top': before['topbar'] is not None and before['topbar']['top'] <= 25,
            'topbar_duplicate_logo_hidden': before['topbar_center_display'] == 'none',
            'logo_contained_in_capsule': before['logo'] is not None and before['capsule'] is not None and before['logo']['top'] >= before['capsule']['top']-1 and before['logo']['bottom'] <= before['capsule']['bottom']+1,
            'capsule_glass_palette_exact': (before['capsule_palette']=={'--alookhor-capsule-background':'#0D0510','--alookhor-capsule-card':'#1C1024','--alookhor-capsule-glass':'rgba(33,20,38,.75)','--alookhor-capsule-gold':'#D49A2E','--alookhor-capsule-gold-light':'#E8B84A','--alookhor-capsule-text':'#F5F3F0','--alookhor-capsule-muted':'#C8C2C9','--alookhor-capsule-blur':'24px'}) if capsule_glass_expected else True,
            'capsule_glass_rendered': (before['capsule_style'] is not None and before['capsule_style']['background_image']!='none' and (('blur(22px)' in before['capsule_style']['backdrop_filter']) if before['header_mode']=='portal' else (before['capsule_style']['background_color']=='rgba(33, 20, 38, 0.75)' and 'blur(24px)' in before['capsule_style']['backdrop_filter']))) if capsule_glass_expected else True,
            'capsule_control_palette': ((before['capsule_control_colors']['account']=='rgb(255, 255, 255)' and before['capsule_control_colors']['menu'] in {'rgb(230, 202, 101)','rgb(243, 229, 171)'}) if before['header_mode']=='portal' else before['capsule_control_colors']=={'menu':'rgb(212, 154, 46)','account':'rgb(245, 243, 240)','cart':'rgb(245, 243, 240)'}) if capsule_glass_expected else True,
            'topbar_reference_glass': (before['topbar_style'] is not None and before['topbar_style']['background_image']!='none' and (before['header_mode']=='portal' or 'blur(18px)' in before['topbar_style']['backdrop_filter'])) if header_reference_expected else True,
            'topbar_reference_order': (before['topbar_support'] is not None and before['topbar_message'] is not None and before['topbar_phone'] is not None and before['topbar_support']['left'] < before['topbar_message']['left'] < before['topbar_phone']['left']) if header_reference_expected else True,
            'topbar_reference_colors': ((before['topbar_role_colors']['phone'] in {'rgb(243, 229, 171)','rgb(230, 202, 101)'} and before['topbar_role_colors']['support'] in {'rgb(243, 229, 171)','rgb(230, 202, 101)'}) if before['header_mode']=='portal' else before['topbar_role_colors']=={'phone':'rgb(232, 184, 74)','support':'rgb(232, 184, 74)','message':'rgb(245, 243, 240)'}) if header_reference_expected else True,
            'desktop_navigation_integrated_in_capsule': (before['stage_integrated'] is True and before['stage'] is not None and before['capsule'] is not None and before['navigation'] is not None and before['stage']['top'] <= before['capsule']['top']+2 and before['stage']['bottom'] >= before['capsule']['bottom']-2 and before['navigation']['left'] > before['logo_box']['right']-20) if header_reference_expected and not expected_mobile else True,
            'mobile_navigation_not_duplicated': ((before['stage_integrated'] is False and before['stage_display']=='none') if before['header_mode']=='legacy' else before['navigation_display']=='none') if header_reference_expected and expected_mobile else True,
            'upper_rows_leave_viewport': ((after['topbar']['bottom'] < 2 and after['header']['bottom'] < 2) if before['header_mode']=='legacy' else after['topbar']['bottom']<2) if not expected_mobile else True,
            'no_large_header_gap': before['header_to_main_gap'] is None or before['header_to_main_gap'] <= 100,
            'hero_mounted': before['hero_mounted'] is True if hero_expected else True,
            'hero_exactly_four_slides': before['hero_slide_count'] == 4 if hero_expected else True,
            'hero_single_active_slide': before['hero_active_count'] == 1 if hero_expected else True,
            'hero_replaces_legacy': (before['hero_legacy_visible'] == 0 and before['hero_old_slider_id_count'] == 0) if hero_expected else True,
            'hero_image_loaded': before['hero_image_loaded'] is True if hero_expected else True,
            'hero_image_subject_focus_non_mirrored': (
                before['hero_image_focus_class'] is True
                and before['hero_image_transform'] is not None and before['hero_image_transform']['det'] > 0
                and ((before['hero_image_object_position'].startswith('78%') if expected_mobile else before['hero_image_transform']['e'] < -300))
            ) if hero_image_polish_expected else True,
            'hero_layered_content': (before['hero_feature_count'] == 4 and before['hero_cta_count'] >= 1) if hero_expected else True,
            'hero_arrows_isolated': (
                len(before['hero_arrows']) == 2
                and all(36 <= arrow['rect']['width'] <= 50 and 36 <= arrow['rect']['height'] <= 50
                        and arrow['border_radius'] == '50%'
                        and arrow['background'] not in {'rgb(255, 255, 255)', 'rgba(255, 255, 255, 1)'}
                        for arrow in before['hero_arrows'])
            ) if hero_polish_expected else True,
            'hero_content_on_right': (
                before['hero_content'] is not None and before['hero_shell'] is not None
                and before['hero_content']['left'] + before['hero_content']['width'] / 2 > before['hero_shell']['left'] + before['hero_shell']['width'] / 2
                and before['hero_content_align'] == 'right'
            ) if hero_expected else True,
            'mobile_hero_under_glass_capsule': (
                before['hero_shell'] is not None and before['capsule'] is not None
                and before['capsule']['top'] < before['hero_shell']['top'] < before['capsule']['bottom']
            ) if hero_polish_expected and expected_mobile else True,
            'features_mounted': before['feature_mounted'] is True if feature_expected else True,
            'features_exactly_four': before['feature_count'] == 4 if feature_expected else True,
            'features_replace_legacy': before['feature_legacy_visible'] == 0 if feature_expected else True,
            'features_reference_order': ([card['title'] for card in before['feature_cards']]==['ارسال سریع','محصولات ارگانیک','پشتیبانی ۲۴/۷','ضمانت کیفیت']) if feature_expected else True,
            'features_single_row': (len(before['feature_cards'])==4 and max(card['rect']['top'] for card in before['feature_cards'])-min(card['rect']['top'] for card in before['feature_cards'])<=2) if feature_expected else True,
            'features_rtl_reference_order': (len(before['feature_cards'])==4 and all(before['feature_cards'][i]['rect']['left']>before['feature_cards'][i+1]['rect']['left'] for i in range(3))) if feature_expected else True,
            'features_close_to_hero': (before['feature_to_hero_gap'] is not None and -3<=before['feature_to_hero_gap']<=20) if feature_proximity_expected else True,
            'features_mobile_four_across': (all(70<=card['rect']['width']<=110 and card['rect']['height']<=135 for card in before['feature_cards'])) if feature_expected and expected_mobile else True,
            'features_palette_exact': (before['feature_palette']=={'--sf-bg':'#0D0510','--sf-card':'#1C1024','--sf-glass':'rgba(33,20,38,.75)','--sf-gold':'#D49A2E','--sf-gold-light':'#E8B84A','--sf-text':'#F5F3F0','--sf-muted':'#C8C2C9'}) if feature_expected else True,
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

# ---- PDP (product page) audit: informational only, never affects ok ----
PDP_JS = r"""
const one=s=>document.querySelector(s);
const rect=e=>e?Object.fromEntries(['top','bottom','left','width','height'].map(k=>[k,Math.round(e.getBoundingClientRect()[k]*10)/10])):null;
const akx=one('#akx-header'), mainbar=one('#akx-header .akx-mainbar'), topbar=one('#akx-header .akx-topbar,#akx-header .akx-top-bar');
const alp=one('.alookhor-alp'), band=one('.alp-hero-band'), gal=one('.alp-gallery'), info=one('.alp-info'), stage=one('.alp-stage');
const themeHeader=one('.whb-header, header.site-header, header#header');
let pdpVersion=null; const w=document.createTreeWalker(document.documentElement,NodeFilter.SHOW_COMMENT); let n;
while((n=w.nextNode())){const m=/ALOOKHOR-PDP\s+v([\d.]+)/.exec(n.nodeValue||''); if(m){pdpVersion=m[1];break;}}
let cssHref=null; for(const sh of document.styleSheets){ if(sh.href&&sh.href.includes('frontend-product')){cssHref=sh.href;break;} }
const parts=[akx,topbar,mainbar].filter(Boolean);
const headerBottom=parts.length?Math.max(...parts.map(e=>e.getBoundingClientRect().bottom)):0;
const g=(e)=>e?Math.round((e.getBoundingClientRect().top-headerBottom)*10)/10:null;
return {
  viewport:{width:innerWidth,height:innerHeight}, pdpVersion,
  akx:rect(akx), topbar:rect(topbar), mainbar:rect(mainbar), theme_header:rect(themeHeader),
  mainbar_position:mainbar?getComputedStyle(mainbar).position:null,
  mainbar_z:mainbar?getComputedStyle(mainbar).zIndex:null,
  mainbar_stuck:mainbar?mainbar.classList.contains('is-stuck'):null,
  header_classes:akx?String(akx.className):'',
  alp:rect(alp), alp_padding_top:alp?getComputedStyle(alp).paddingTop:null,
  band:rect(band), gallery:rect(gal), info:rect(info), stage:rect(stage),
  gap_alp_below_header:g(alp), gap_band_below_header:g(band), gap_gallery_below_header:g(gal), gap_info_below_header:g(info),
  cssHref, scrollY:scrollY, scrollW:document.documentElement.scrollWidth,
  body_classes:document.body.className
};
"""

def pdp_audit(width: int, height: int, label: str) -> dict:
    import urllib.request
    options = Options()
    options.add_argument('--headless=new'); options.add_argument('--no-sandbox'); options.add_argument('--disable-dev-shm-usage')
    options.add_argument('--disable-gpu'); options.add_argument(f'--window-size={width},{height}')
    options.add_argument('--hide-scrollbars'); options.add_argument('--force-device-scale-factor=1')
    driver = webdriver.Chrome(options=options)
    try:
        api_version = None; url = f'{BASE}/product/%d8%a7%d9%84%d8%a8%d8%a7%d9%84%d9%88-%d8%ae%d8%b4%da%a9/'
        try:
            data = json.loads(urllib.request.urlopen(f'{BASE}/wp-json/alookhor-cc/v1/product', timeout=30).read().decode())
            api_version = data.get('version'); url = data.get('product', {}).get('url') or url
        except Exception as error:
            pass
        driver.get(url)
        WebDriverWait(driver, 40).until(lambda d: d.execute_script("return !!document.querySelector('.alookhor-alp')"))
        time.sleep(4)
        before = driver.execute_script(PDP_JS)
        css = {}
        href = before.get('cssHref')
        if href:
            try:
                fresh = href + ('&' if '?' in href else '?') + 'audit=' + str(int(time.time()))
                txt = urllib.request.urlopen(fresh, timeout=30).read().decode('utf-8', 'replace')
                css = {'has_206_breathing_room': 'BREATHING ROOM' in txt,
                       'has_205_render_fixes': 'RENDER-TESTED FIXES' in txt,
                       'has_204_flush': 'FLUSH TO MENU' in txt,
                       'length': len(txt)}
            except Exception as error:
                css = {'error': str(error)[:160]}
        driver.save_screenshot(str(SHOT_DIR / f'pdp-{label}-top.png'))
        driver.execute_script('window.scrollTo(0, 500)'); time.sleep(1.2)
        after = driver.execute_script(PDP_JS)
        driver.save_screenshot(str(SHOT_DIR / f'pdp-{label}-scrolled.png'))
        return {'label': label, 'api_version': api_version, 'url': url, 'before': before, 'after': after, 'css': css}
    finally:
        driver.quit()

report['pdp'] = {}
for label, width, height in (('desktop', 1614, 900), ('mobile', 390, 844)):
    try:
        report['pdp'][label] = pdp_audit(width, height, label)
    except Exception as error:
        report['pdp'][label] = {'error': f'{type(error).__name__}: {error}'}

OUT.write_text(json.dumps(report,ensure_ascii=False,indent=2)+'\n')
print(json.dumps(report,ensure_ascii=False,indent=2))
if not report['ok']: raise SystemExit(1)
