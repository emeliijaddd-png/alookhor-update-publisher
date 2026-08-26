#!/usr/bin/env python3
from pathlib import Path
from urllib.request import Request, urlopen
from urllib.parse import urljoin
from html import unescape
import base64
import json
import os
import re
import time

ROOT = Path(__file__).resolve().parents[1]
report_path = Path(os.environ.get('WP_REPORT_PATH', '/tmp/wordpress-access.json'))
report = {'ok': False, 'checks': {}}


def authenticated_request(base, auth, path, accept='application/json'):
    return Request(base + path, headers={
        'Authorization': f'Basic {auth}',
        'Accept': accept,
        'User-Agent': 'ALOOKHOR-GitHub-Publisher/1.0',
    })


def version_tuple(value):
    return tuple(int(part) for part in str(value).split('.'))


try:
    base = os.environ.get('WP_BASE_URL', '').strip().rstrip('/')
    username = os.environ.get('WP_USERNAME', '').strip()
    app_password = os.environ.get('WP_APP_PASSWORD', '').strip()
    source_version = str(json.loads((ROOT / 'release.json').read_text())['version'])

    report['source_version'] = source_version
    report['checks']['secrets_present'] = bool(base and username and app_password)
    if not report['checks']['secrets_present']:
        raise RuntimeError('Required WordPress GitHub Secrets are missing')
    if base != 'https://alookhor.ir':
        raise RuntimeError('WP_BASE_URL must be https://alookhor.ir')

    production_url = 'https://updates.alookhor.ir/manifest.json?access_audit=' + str(int(time.time()))
    with urlopen(Request(production_url, headers={'Accept': 'application/json', 'User-Agent': 'ALOOKHOR-GitHub-Publisher/1.0'}), timeout=30) as response:
        production = json.load(response)
    production_version = str(production.get('version', ''))
    production_sha = str(production.get('sha256', ''))
    report['production'] = {'version': production_version, 'sha256': production_sha}
    report['checks']['production_manifest'] = (
        bool(re.fullmatch(r'\d+\.\d+\.\d+', production_version))
        and bool(re.fullmatch(r'[a-f0-9]{64}', production_sha))
        and production.get('download_url') == f'https://updates.alookhor.ir/releases/alookhor-control-center-{production_version}.zip'
    )

    auth = base64.b64encode(f'{username}:{app_password}'.encode()).decode()
    transition_required = (
        version_tuple(production_version) < version_tuple('3.8.7')
        and version_tuple(source_version) >= version_tuple('3.8.7')
    )
    report['transition_bridge_required'] = transition_required
    if transition_required:
        try:
            with urlopen(authenticated_request(base, auth, '/wp-json/alookhor-ci/v1/bridge-status'), timeout=30) as response:
                bridge = json.load(response)
            report['transition_bridge'] = bridge
            caps = bridge.get('capabilities', {})
            report['checks']['transition_bridge'] = (
                bridge.get('version') == '2026.08.11-reactivation-v1'
                and bridge.get('activation_guard') is True
                and bridge.get('plugin_active') is True
                and caps.get('read') is True
                and caps.get('update_plugins') is True
                and caps.get('activate_plugins') is False
            )
        except Exception as error:
            report['transition_bridge'] = {'ok': False, 'error': str(error)}
            report['checks']['transition_bridge'] = False

    errors = []
    status = None
    source = None
    for candidate, path in [
        ('native', '/wp-json/alookhor-cc/v1/status'),
        ('bootstrap', '/wp-json/alookhor-ci/v1/status'),
    ]:
        try:
            with urlopen(authenticated_request(base, auth, path), timeout=30) as response:
                status = json.load(response)
            source = candidate
            break
        except Exception as error:
            errors.append(f'{candidate}: {error}')
    if status is None:
        raise RuntimeError('No authenticated status endpoint: ' + '; '.join(errors))

    report['source'] = source
    report['status'] = status
    settings = status.get('settings', {})
    manifest = status.get('manifest', {})
    report['checks']['authenticated'] = True
    report['checks']['native_api'] = source == 'native'
    report['checks']['version'] = str(status.get('version')) == production_version
    report['checks']['active'] = status.get('active') is True
    report['checks']['manifest'] = (
        manifest.get('ok') is True
        and str(manifest.get('version')) == production_version
        and manifest.get('sha256') == production_sha
        and manifest.get('package_host') == 'updates.alookhor.ir'
    )
    report['checks']['main_option'] = settings.get('main_option') is True
    report['checks']['header_option'] = settings.get('header_option') is True
    report['checks']['module_count'] = int(settings.get('module_count', 0)) >= 8
    report['checks']['shortcode'] = settings.get('header_shortcode') is True
    production_parts = tuple(int(part) for part in production_version.split('.'))
    report['checks']['category_shortcode'] = settings.get('category_shortcode') is True if production_parts >= (3, 10, 3) else True
    if production_parts >= (3, 10, 6):
        migration = settings.get('header_brand_migration')
        report['checks']['header_brand_migration'] = (
            isinstance(migration, dict) and migration.get('ok') is True
            and str(migration.get('version')) == '3.10.6'
            and bool(migration.get('before_hash')) and bool(migration.get('after_hash'))
        )
    if production_parts >= (3, 10, 7):
        layout_migration = settings.get('header_layout_migration')
        report['checks']['header_layout_migration'] = (
            isinstance(layout_migration, dict) and layout_migration.get('ok') is True
            and str(layout_migration.get('version')) == '3.10.7'
            and layout_migration.get('search_removed') is True
            and layout_migration.get('mobile_extra_stage_removed') is True
        )
    if production_parts >= (3, 10, 19):
        reference_migration=settings.get('header_reference_migration')
        report['checks']['header_reference_migration']=(isinstance(reference_migration,dict) and reference_migration.get('ok') is True and str(reference_migration.get('version'))=='3.10.19' and bool(reference_migration.get('before_hash')) and bool(reference_migration.get('after_hash')))
    if production_parts >= (3, 10, 13):
        report['checks']['hero_runtime'] = (
            settings.get('hero_shortcode') is True
            and settings.get('hero_settings') is True
            and settings.get('hero_enabled') is True
            and int(settings.get('hero_slide_count', 0)) == 4
            and settings.get('hero_module') is True
        )
    if production_parts >= (3, 10, 16):
        report['checks']['feature_runtime']=(
            settings.get('feature_shortcode') is True
            and settings.get('feature_settings') is True
            and settings.get('feature_enabled') is True
            and int(settings.get('feature_item_count',0))==4
            and settings.get('feature_module') is True
        )

    public_url = base + '/?alookhor_access_audit=' + production_version.replace('.', '')
    with urlopen(Request(public_url, headers={'User-Agent': 'ALOOKHOR-GitHub-Publisher/1.0'}), timeout=30) as response:
        homepage = response.read().decode(errors='replace')
        report['checks']['homepage_http'] = response.status == 200
    report['checks']['header_content'] = (('خرید عمده' in homepage and ('ALOOKHOR' in homepage or 'آلوخور' in homepage)) or ('ak-topbar' in homepage and 'ak-navbar' in homepage and ('0915' in homepage or '09159513173' in homepage)))
    report['checks']['header_scroll_asset'] = (
        ('frontend-header-scroll.css' in homepage and 'alookhor-managed-legacy-header' in homepage)
        or ('frontend-header.css' in homepage and 'alookhor-portal-header' in homepage)
        or ('ak-topbar' in homepage and 'ak-navbar' in homepage)
        if version_tuple(production_version) >= version_tuple('3.10.5')
        else True
    )

    localized = {}
    localized_match = re.search(r'var\s+ALOOKHOR_TOPBAR\s*=\s*(\{.*?\});', homepage, re.S)
    if localized_match:
        try:
            raw_topbar = json.loads(localized_match.group(1))
            for key in [
                'topbar_bg', 'topbar_text_color', 'topbar_border_color',
                'topbar_button_bg', 'topbar_button_text', 'topbar_height',
                'show_topbar', 'show_wholesale',
            ]:
                localized[key] = raw_topbar.get(key)
        except Exception as error:
            localized = {'parse_error': str(error)}
    class_names = sorted({
        name
        for value in re.findall(r'class=["\']([^"\']+)["\']', homepage, re.I)
        for name in value.split()
        if any(token in name.lower() for token in ['top', 'bar', 'header', 'trade', 'contact', 'wholesale'])
    })
    # Capture only selector/declaration pairs relevant to the recovered legacy
    # Header. This makes sticky conflicts auditable without exporting unrelated
    # page CSS or relying on screenshots.
    style_blocks = re.findall(r'<style[^>]*>(.*?)</style>', homepage, re.I | re.S)
    legacy_header_rules = []
    selector_tokens = ('alookhor-topbar-wrapper', 'alookhor-header', 'header-capsule', 'header-nav-center', 'nav-menu', 'ak-topbar', 'ak-navbar')
    for block in style_blocks:
        for selector, declarations in re.findall(r'([^{}]+)\{([^{}]*)\}', block):
            clean_selector = re.sub(r'\s+', ' ', selector).strip()
            if any(token in clean_selector for token in selector_tokens):
                legacy_header_rules.append({
                    'selector': clean_selector[:500],
                    'declarations': re.sub(r'\s+', ' ', declarations).strip()[:1400],
                })
    topbar_markers=['alookhor-topbar-wrapper','alookhor-portal-header','ak-topbar-wrapper','ak-topbar']
    topbar_positions=[(homepage.find(marker),marker) for marker in topbar_markers if homepage.find(marker)>=0]
    topbar_index,topbar_provider=min(topbar_positions,key=lambda item:item[0]) if topbar_positions else (-1,None)
    topbar_fragment = ''
    if topbar_index >= 0:
        fragment_start = homepage.rfind('<div', 0, topbar_index)
        topbar_fragment = re.sub(r'\s+', ' ', homepage[max(0, fragment_start):topbar_index + 26000]).strip()
    report['public_topbar'] = {
        'provider':topbar_provider,
        'managed_wrapper': 'alookhor-managed-legacy-header' in homepage,
        'portal_wrapper':'alookhor-portal-header' in homepage,
        'ak_wrapper':'ak-topbar' in homepage and 'ak-navbar' in homepage,
        'manager_script': 'frontend-topbar-manager.js' in homepage,
        'localized': localized,
        'relevant_classes': class_names[:100],
        'markup_fragment': topbar_fragment,
        'legacy_header_rules': legacy_header_rules[:160],
    }

    hero_index = homepage.find('slide1.jpg')
    hero_fragment = ''
    if hero_index >= 0:
        hero_start = homepage.rfind('<', 0, max(0, hero_index - 5000))
        hero_fragment = re.sub(r'\s+', ' ', homepage[max(0, hero_start):hero_index + 12000]).strip()
    hero_classes = sorted({
        name
        for value in re.findall(r'class=["\']([^"\']+)["\']', hero_fragment, re.I)
        for name in value.split()
    })
    hero_assets = sorted(set(re.findall(r'https?://[^"\'\s>]+alookhor-categories-manager/[^"\'\s<]+', homepage, re.I)))
    widget_tag = ''
    if hero_index >= 0:
        widget_type_index = homepage.rfind('data-widget_type=', 0, hero_index)
        if widget_type_index >= 0:
            widget_start = homepage.rfind('<div', 0, widget_type_index)
            widget_end = homepage.find('>', widget_type_index)
            if widget_start >= 0 and widget_end >= 0:
                widget_tag = re.sub(r'\s+', ' ', homepage[widget_start:widget_end + 1]).strip()
    report['legacy_hero'] = {
        'found': hero_index >= 0,
        'root_selector': '.alookhor-hero-slider-wrapper' if 'alookhor-hero-slider-wrapper' in hero_fragment else None,
        'slider_id': 'alookhorHeroSlider' if 'id="alookhorHeroSlider"' in hero_fragment else None,
        'elementor_widget_tag': widget_tag,
        'classes': hero_classes[:160],
        'fragment': hero_fragment,
        'assets': hero_assets[:80],
    }

    feature_index=homepage.find('alookhor-trustbar-container')
    feature_fragment='';feature_widget_tag=''
    if feature_index>=0:
        feature_start=homepage.rfind('<div class="elementor-element',0,feature_index)
        feature_fragment=re.sub(r'\s+',' ',homepage[max(0,feature_start):feature_index+9000]).strip()
        widget_type_index=homepage.rfind('data-widget_type=',0,feature_index)
        if widget_type_index>=0:
            widget_start=homepage.rfind('<div',0,widget_type_index);widget_end=homepage.find('>',widget_type_index)
            if widget_start>=0 and widget_end>=0:feature_widget_tag=re.sub(r'\s+',' ',homepage[widget_start:widget_end+1]).strip()
    feature_classes=sorted({name for value in re.findall(r'class=["\']([^"\']+)["\']',feature_fragment,re.I) for name in value.split()})
    report['legacy_features']={
        'found':feature_index>=0,
        'root_selector':'.alookhor-trustbar-container' if feature_index>=0 else None,
        'elementor_widget_tag':feature_widget_tag,
        'classes':feature_classes[:80],
        'fragment':feature_fragment,
    }

    collection_index=homepage.find('ALOOKHOR PREMIUM COLLECTION')
    collection_fragment='';collection_widget_tag=''
    if collection_index>=0:
        collection_start=homepage.rfind('<div class="elementor-element',0,collection_index)
        collection_fragment=re.sub(r'\s+',' ',homepage[max(0,collection_start):collection_index+30000]).strip()
        widget_type_index=homepage.rfind('data-widget_type=',0,collection_index)
        if widget_type_index>=0:
            widget_start=homepage.rfind('<div',0,widget_type_index);widget_end=homepage.find('>',widget_type_index)
            if widget_start>=0 and widget_end>=0:collection_widget_tag=re.sub(r'\s+',' ',homepage[widget_start:widget_end+1]).strip()
    collection_classes=sorted({name for value in re.findall(r'class=["\']([^"\']+)["\']',collection_fragment,re.I) for name in value.split()})
    collection_products=[]
    for href,image,title in re.findall(r'<a[^>]+href=["\']([^"\']*/product/[^"\']*)["\'][^>]*>.*?<img[^>]+src=["\']([^"\']+)["\'][^>]*alt=["\']([^"\']*)["\']',collection_fragment,re.I|re.S):
        collection_products.append({'url':unescape(href),'image':unescape(image),'image_alt':unescape(title)})
    report['legacy_collection']={
        'found':collection_index>=0,
        'elementor_widget_tag':collection_widget_tag,
        'classes':collection_classes[:140],
        'product_links':collection_products[:12],
        'fragment':collection_fragment,
    }

    # Authenticated, non-mutating lookup of the real WordPress front-page record.
    # Elementor may keep its source in private post meta, so record only exposed
    # page identity and shortcode tokens rather than guessing unavailable data.
    try:
        with urlopen(authenticated_request(base, auth, '/wp-json/wp/v2/settings?context=edit'), timeout=30) as response:
            wp_settings = json.load(response)
        front_id = int(wp_settings.get('page_on_front') or 0)
        page_record = {}
        if front_id:
            with urlopen(authenticated_request(base, auth, f'/wp-json/wp/v2/pages/{front_id}?context=edit'), timeout=30) as response:
                page_record = json.load(response)
        raw_content = str((page_record.get('content') or {}).get('raw') or '')
        shortcode_tokens = sorted(set(re.findall(r'\[[^\]]*(?:hero|slider)[^\]]*\]', raw_content, re.I)))
        report['front_page_source'] = {
            'id': front_id,
            'slug': page_record.get('slug'),
            'template': page_record.get('template'),
            'raw_content_length': len(raw_content),
            'hero_shortcode_tokens': shortcode_tokens[:20],
            'exposed_meta_keys': sorted((page_record.get('meta') or {}).keys())[:80],
        }
    except Exception as error:
        report['front_page_source'] = {'available': False, 'error': str(error)}

    footer_classes = sorted({
        name
        for value in re.findall(r'class=["\']([^"\']+)["\']', homepage, re.I)
        for name in value.split()
        if any(token in name.lower() for token in [
            'footer', 'newsletter', 'social', 'payment', 'trust', 'license',
            'contact', 'app-download', 'copyright', 'guarantee',
        ])
    })
    footer_index = homepage.rfind('alookhor-footer-system')
    footer_fragment = ''
    if footer_index >= 0:
        style_start = homepage.rfind('<style', 0, footer_index)
        markup_start = homepage.rfind('<div', 0, footer_index)
        footer_start = style_start if style_start >= 0 and footer_index - style_start < 30000 else markup_start
        footer_fragment = re.sub(r'\s+', ' ', homepage[max(0, footer_start):footer_index + 50000]).strip()
    else:
        footer_positions = [homepage.rfind(marker) for marker in ['<footer', 'site-footer', 'main-footer', 'footer-container']]
        footer_index = max(footer_positions)
        if footer_index >= 0:
            footer_start = homepage.rfind('<', 0, footer_index + 1)
            footer_fragment = re.sub(r'\s+', ' ', homepage[max(0, footer_start - 3000):footer_index + 18000]).strip()
    report['public_footer'] = {
        'relevant_classes': footer_classes[:160],
        'markup_fragment': footer_fragment,
    }
    manager_match = re.search(r'<script[^>]+src=["\']([^"\']*frontend-topbar-manager\.js[^"\']*)["\']', homepage, re.I)
    if manager_match:
        try:
            manager_url = urljoin(base + '/', unescape(manager_match.group(1)))
            separator = '&' if '?' in manager_url else '?'
            with urlopen(Request(manager_url + separator + 'audit=' + str(int(time.time())), headers={'User-Agent': 'ALOOKHOR-GitHub-Publisher/1.0'}), timeout=30) as response:
                manager_source = response.read().decode(errors='replace')
            report['public_topbar']['manager_asset'] = manager_url
            report['checks']['manager_contact_span'] = (
                '.topbar-contact-txt' in manager_source
                and 'contactTexts.find' in manager_source
                and f"=== '{production_version}'" in manager_source
                and (
                    version_tuple(production_version) < version_tuple('3.10.5')
                    or (
                        all(token in manager_source for token in ['setupHeaderBehavior', 'data-alookhor-navigation', 'header.after(marker, stage)'])
                        and (
                            version_tuple(production_version) < version_tuple('3.10.7')
                            or ('alookhor-header-cart-link' in manager_source and 'alookhor-legacy-main-search' not in manager_source)
                        )
                    )
                )
            )
        except Exception as error:
            report['public_topbar']['manager_asset_error'] = str(error)
            report['checks']['manager_contact_span'] = False
    elif version_tuple(production_version) >= version_tuple('3.8.9'):
        # Internal shortcode renderer owns its contact markup directly and does
        # not enqueue the Legacy compatibility manager.
        report['checks']['manager_contact_span'] = (('alookhor-portal-header' in homepage and 'frontend-header.js' in homepage) or ('ak-topbar' in homepage and 'ak-navbar' in homepage))

    if version_tuple(production_version) >= version_tuple('3.8.7'):
        topbar_url = base + '/wp-json/alookhor-cc/v1/topbar?access_audit=' + str(int(time.time()))
        try:
            with urlopen(Request(topbar_url, headers={'Accept': 'application/json', 'Cache-Control': 'no-cache', 'User-Agent': 'ALOOKHOR-GitHub-Publisher/1.0'}), timeout=30) as response:
                topbar_state = json.load(response)
                cache_control = response.headers.get('Cache-Control', '')
            report['public_topbar']['fresh_endpoint'] = topbar_state
            report['checks']['topbar_endpoint'] = (
                str(topbar_state.get('version')) == production_version
                and all(bool(re.fullmatch(r'#[a-fA-F0-9]{6}', str(topbar_state.get(key, '')))) for key in [
                    'topbar_bg', 'topbar_text_color', 'topbar_border_color',
                    'topbar_button_bg', 'topbar_button_text',
                ])
                and (
                    version_tuple(production_version) < version_tuple('3.10.5')
                    or (
                        all(bool(re.fullmatch(r'#[a-fA-F0-9]{6}', str(topbar_state.get(key, '')))) for key in ['header_surface','header_text_color','header_muted_color','gold'])
                        and isinstance(topbar_state.get('sticky'), bool)
                        and isinstance(topbar_state.get('show_search'), bool)
                        and isinstance(topbar_state.get('search_placeholder'), str)
                        and 70 <= int(topbar_state.get('header_logo_desktop_width', 0)) <= 220
                        and 42 <= int(topbar_state.get('header_logo_mobile_width', 0)) <= 110
                    )
                )
            )
            report['checks']['topbar_no_store'] = 'no-store' in cache_control.lower()
            if version_tuple(production_version)>=version_tuple('3.10.19'):
                report['checks']['header_brand_palette']=(topbar_state.get('phone')=='09159513176' and str(topbar_state.get('gold','')).upper()=='#D49A2E' and str(topbar_state.get('topbar_bg','')).upper()=='#1C1024' and str(topbar_state.get('topbar_text_color','')).upper()=='#F5F3F0' and str(topbar_state.get('topbar_border_color','')).upper()=='#D49A2E' and str(topbar_state.get('topbar_button_bg','')).upper()=='#D49A2E' and str(topbar_state.get('topbar_button_text','')).upper()=='#0D0510' and str(topbar_state.get('header_surface','')).upper()=='#0D0510' and str(topbar_state.get('header_text_color','')).upper()=='#F5F3F0' and str(topbar_state.get('header_muted_color','')).upper()=='#C8C2C9' and topbar_state.get('sticky') is True and topbar_state.get('show_search') is False)
            elif version_tuple(production_version) >= version_tuple('3.10.6'):
                report['checks']['header_brand_palette'] = (
                    topbar_state.get('phone') == '09159513176'
                    and str(topbar_state.get('gold','')).upper() == '#C9A86A'
                    and str(topbar_state.get('topbar_bg','')).upper() == '#11091D'
                    and str(topbar_state.get('topbar_text_color','')).upper() == '#E8D5B5'
                    and str(topbar_state.get('topbar_button_bg','')).upper() == '#C9A86A'
                    and str(topbar_state.get('topbar_button_text','')).upper() == '#1A1206'
                    and str(topbar_state.get('header_surface','')).upper() == '#0D0916'
                    and str(topbar_state.get('header_text_color','')).upper() == '#F7F2EA'
                    and str(topbar_state.get('header_muted_color','')).upper() == '#B8B0BD'
                    and topbar_state.get('sticky') is True
                    and topbar_state.get('show_search') is (False if version_tuple(production_version) >= version_tuple('3.10.7') else True)
                )
            if version_tuple(production_version)>=version_tuple('3.10.18'):
                report['checks']['header_capsule_palette']=(
                    str(topbar_state.get('capsule_background','')).upper()=='#0D0510'
                    and str(topbar_state.get('capsule_card','')).upper()=='#1C1024'
                    and topbar_state.get('capsule_glass')=='rgba(33,20,38,.75)'
                    and str(topbar_state.get('capsule_gold','')).upper()=='#D49A2E'
                    and str(topbar_state.get('capsule_gold_light','')).upper()=='#E8B84A'
                    and str(topbar_state.get('capsule_text','')).upper()=='#F5F3F0'
                    and str(topbar_state.get('capsule_muted','')).upper()=='#C8C2C9'
                    and int(topbar_state.get('capsule_blur',0))==24
                )
        except Exception as error:
            report['public_topbar']['fresh_endpoint_error'] = str(error)
            report['checks']['topbar_endpoint'] = False
            report['checks']['topbar_no_store'] = False
            if version_tuple(production_version) >= version_tuple('3.10.6'):
                report['checks']['header_brand_palette'] = False
            if version_tuple(production_version)>=version_tuple('3.10.18'):
                report['checks']['header_capsule_palette']=False

    if version_tuple(production_version) >= version_tuple('3.9.0'):
        footer_url = base + '/wp-json/alookhor-cc/v1/footer?access_audit=' + str(int(time.time()))
        try:
            with urlopen(Request(footer_url, headers={'Accept':'application/json','Cache-Control':'no-cache','User-Agent':'ALOOKHOR-GitHub-Publisher/1.0'}), timeout=30) as response:
                footer_state = json.load(response)
                footer_cache = response.headers.get('Cache-Control','')
            footer_html = str(footer_state.get('html',''))
            report['managed_footer'] = {'version':footer_state.get('version'),'enabled':footer_state.get('enabled'),'html_length':len(footer_html),'html':footer_html}
            report['checks']['footer_endpoint'] = (
                str(footer_state.get('version')) == production_version and footer_state.get('enabled') is True
                and 'id="alookhor-managed-footer"' in footer_html
                and 'alookhor-mf-main-grid' in footer_html and 'alookhor-mf-news-social' in footer_html
            )
            report['checks']['footer_no_store'] = 'no-store' in footer_cache.lower()
            report['checks']['footer_homepage'] = (
                'id="alookhor-managed-footer"' in homepage
                and 'alookhor-mf-hide-legacy' in homepage
                and 'frontend-footer.js' in homepage
            )
        except Exception as error:
            report['managed_footer'] = {'error':str(error)}
            report['checks']['footer_endpoint'] = False
            report['checks']['footer_no_store'] = False
            report['checks']['footer_homepage'] = False

    if version_tuple(production_version) >= version_tuple('3.10.0'):
        category_url=base+'/wp-json/alookhor-cc/v1/product-categories?access_audit='+str(int(time.time()))
        try:
            with urlopen(Request(category_url,headers={'Accept':'application/json','Cache-Control':'no-cache','User-Agent':'ALOOKHOR-GitHub-Publisher/1.0'}),timeout=30) as response:
                category_state=json.load(response);category_cache=response.headers.get('Cache-Control','')
            category_html=str(category_state.get('html',''));report['managed_categories']={'version':category_state.get('version'),'enabled':category_state.get('enabled'),'count':category_state.get('count'),'term_ids':category_state.get('term_ids'),'html_length':len(category_html),'html':category_html}
            report['checks']['category_endpoint']=(str(category_state.get('version'))==production_version and category_state.get('enabled') is True and int(category_state.get('count',0))>=4 and 'id="alookhor-managed-categories"' in category_html and 'alookhor-mc-card' in category_html)
            report['checks']['category_no_store']='no-store' in category_cache.lower()
            report['checks']['category_homepage']=('alookhor-managed-categories-template' in homepage and 'frontend-categories.js' in homepage and 'alookhor-mc-hide-legacy' in homepage)
        except Exception as error:
            report['managed_categories']={'error':str(error)};report['checks']['category_endpoint']=False;report['checks']['category_no_store']=False;report['checks']['category_homepage']=False

    if version_tuple(production_version) >= version_tuple('3.10.13'):
        hero_url=base+'/wp-json/alookhor-cc/v1/hero?access_audit='+str(int(time.time()))
        try:
            with urlopen(Request(hero_url,headers={'Accept':'application/json','Cache-Control':'no-cache','User-Agent':'ALOOKHOR-GitHub-Publisher/1.0'}),timeout=30) as response:
                hero_state=json.load(response);hero_cache=response.headers.get('Cache-Control','')
            hero_html=str(hero_state.get('html',''))
            report['managed_hero']={'version':hero_state.get('version'),'enabled':hero_state.get('enabled'),'slide_count':hero_state.get('slide_count'),'html_length':len(hero_html),'html':hero_html}
            report['checks']['hero_endpoint']=(
                str(hero_state.get('version'))==production_version and hero_state.get('enabled') is True
                and int(hero_state.get('slide_count',0))==4
                and 'id="alookhor-managed-hero"' in hero_html
                and len(re.findall(r'<article class="alookhor-mh-slide(?: |")',hero_html))==4
            )
            report['checks']['hero_no_store']='no-store' in hero_cache.lower()
            report['checks']['hero_homepage']=(
                ('alookhor-managed-hero-template' in homepage or 'id="alookhor-managed-hero"' in homepage)
                and 'frontend-hero.js' in homepage
                and 'alookhor-mh-hide-legacy' in homepage
            )
        except Exception as error:
            report['managed_hero']={'error':str(error)}
            report['checks']['hero_endpoint']=False
            report['checks']['hero_no_store']=False
            report['checks']['hero_homepage']=False

    if version_tuple(production_version)>=version_tuple('3.10.16'):
        feature_url=base+'/wp-json/alookhor-cc/v1/site-features?access_audit='+str(int(time.time()))
        try:
            with urlopen(Request(feature_url,headers={'Accept':'application/json','Cache-Control':'no-cache','User-Agent':'ALOOKHOR-GitHub-Publisher/1.0'}),timeout=30) as response:
                feature_state=json.load(response);feature_cache=response.headers.get('Cache-Control','')
            feature_html=str(feature_state.get('html',''))
            report['managed_features']={'version':feature_state.get('version'),'enabled':feature_state.get('enabled'),'item_count':feature_state.get('item_count'),'html_length':len(feature_html),'html':feature_html}
            report['checks']['feature_endpoint']=(str(feature_state.get('version'))==production_version and feature_state.get('enabled') is True and int(feature_state.get('item_count',0))==4 and 'id="alookhor-managed-features"' in feature_html and len(re.findall(r'<article class="alookhor-sf-card"',feature_html))==4)
            report['checks']['feature_no_store']='no-store' in feature_cache.lower()
            report['checks']['feature_homepage']=('alookhor-managed-features-template' in homepage and 'frontend-features.js' in homepage and 'alookhor-sf-hide-legacy' in homepage and '.alookhor-trustbar-container' in homepage)
            report['checks']['feature_palette']=all(token in feature_html for token in ['--sf-bg:#0D0510','--sf-card:#1C1024','--sf-glass:rgba(33,20,38,.75)','--sf-gold:#D49A2E','--sf-gold-light:#E8B84A','--sf-text:#F5F3F0','--sf-muted:#C8C2C9'])
        except Exception as error:
            report['managed_features']={'error':str(error)};report['checks']['feature_endpoint']=False;report['checks']['feature_no_store']=False;report['checks']['feature_homepage']=False;report['checks']['feature_palette']=False

    # Non-mutating feasibility probe. Application Passwords are expected to be
    # REST-only on this site; never record a nonce or any authenticated HTML.
    try:
        with urlopen(authenticated_request(base, auth, '/wp-admin/index.php', 'text/html'), timeout=30) as response:
            admin_html = response.read().decode(errors='replace')
            admin_url = response.geturl()
        report['admin_probe'] = {
            'http_status': response.status,
            'final_path': re.sub(r'^https?://[^/]+', '', admin_url).split('?', 1)[0],
            'authenticated': '/wp-admin/' in admin_url and 'loginform' not in admin_html,
            'updates_nonce_present': bool(re.search(r'["\']ajax_nonce["\']\s*:\s*["\'][^"\']+', admin_html)),
        }
    except Exception as error:
        report['admin_probe'] = {'authenticated': False, 'updates_nonce_present': False, 'error': str(error)}

    failed = [name for name, value in report['checks'].items() if value is not True]
    report['failed_checks'] = failed
    report['ok'] = not failed
    if failed:
        raise RuntimeError('Access checks failed: ' + ', '.join(failed))
except Exception as error:
    report['error'] = str(error)
    report_path.write_text(json.dumps(report, ensure_ascii=False, indent=2) + '\n')
    print(json.dumps(report, ensure_ascii=False, indent=2))
    raise
else:
    report_path.write_text(json.dumps(report, ensure_ascii=False, indent=2) + '\n')
    print(json.dumps(report, ensure_ascii=False, indent=2))
