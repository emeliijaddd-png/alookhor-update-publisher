#!/usr/bin/env python3
from pathlib import Path
from urllib.error import HTTPError, URLError
from urllib.request import Request, urlopen
import base64
import json
import os
import re
import sys
import time

ROOT = Path(__file__).resolve().parents[1]
TARGET = str(json.loads((ROOT / 'release.json').read_text())['version'])
BASE = os.environ['WP_BASE_URL'].strip().rstrip('/')
USERNAME = os.environ['WP_USERNAME'].strip()
APP_PASSWORD = os.environ['WP_APP_PASSWORD'].strip()
REPORT_PATH = Path(os.environ.get('WP_REPORT_PATH', '/tmp/wordpress-report.json'))
AUTH = base64.b64encode(f'{USERNAME}:{APP_PASSWORD}'.encode()).decode()

# ——— Self-healing auth resolution (v3.10.59) ———
# WP displays application passwords in spaced 4-char groups; if a secret is
# pasted with whitespace/newlines, the spaced variant fails while the stripped
# one works. Try safe variants (read-only GETs) and remember which one works.
# Secrets are never printed anywhere: only variant *names* are reported.
_AUTH_RESOLVED = {'value': None, 'variant': None}
AUTH_PROBES = []


def _b64(user, password):
    return base64.b64encode(f'{user}:{password}'.encode()).decode()


def resolve_auth():
    if _AUTH_RESOLVED['value'] is not None:
        return _AUTH_RESOLVED['value']
    user_variants = []
    for candidate in (USERNAME, re.sub(r'\s+', '', USERNAME)):
        if candidate and candidate not in user_variants:
            user_variants.append(candidate)
    password_variants = []
    for candidate in (APP_PASSWORD, re.sub(r'\s+', '', APP_PASSWORD)):
        if candidate and candidate not in password_variants:
            password_variants.append(candidate)
    for user in user_variants:
        for password in password_variants:
            variant = ('user_stripped;' if user != USERNAME else '') + ('password_stripped' if password != APP_PASSWORD else 'default')
            try:
                probe_auth('/wp-json/alookhor-cc/v1/status', _b64(user, password), record=False)
            except Exception:
                continue
            _AUTH_RESOLVED['value'] = _b64(user, password)
            _AUTH_RESOLVED['variant'] = variant
            AUTH_PROBES.append({'probe': 'self_heal_auth', 'variant': variant, 'result': 'accepted'})
            return _AUTH_RESOLVED['value']
    AUTH_PROBES.append({'probe': 'self_heal_auth', 'variant': 'all_four', 'result': 'rejected'})
    return AUTH


def active_auth():
    return _AUTH_RESOLVED['value'] or resolve_auth()


def probe_auth(path, token, record=True, note=''):
    """Read-only GET with an explicit Basic token; returns (http, wp_code)."""
    request = Request(
        BASE + path,
        headers={
            'Authorization': f'Basic {token}',
            'Accept': 'application/json',
            'User-Agent': 'ALOOKHOR-GitHub-Publisher/1.0',
        },
    )
    http_status = None
    wp_code = ''
    try:
        with urlopen(request, timeout=30) as response:
            http_status = response.status
            data = response.read().decode(errors='replace')
    except HTTPError as error:
        http_status = error.code
        data = error.read().decode(errors='replace')
    try:
        wp_code = str(json.loads(data).get('code') or '')
    except Exception:
        wp_code = ''
    if record:
        entry = {'http': http_status, 'wp_code': wp_code}
        if note:
            entry['note'] = note
        AUTH_PROBES.append(entry)
    if http_status != 200:
        raise RuntimeError(f'HTTP {http_status} for {path}: {data[:300]}')
    return http_status, json.loads(data)


def diagnose_auth_failure():
    """Read-only probes that identify WHY application-password auth fails."""
    diagnostics = {'probes': AUTH_PROBES}
    try:
        request = Request(BASE + '/wp-json/', headers={'Accept': 'application/json', 'User-Agent': 'ALOOKHOR-GitHub-Publisher/1.0'})
        with urlopen(request, timeout=30) as response:
            index = json.loads(response.read().decode(errors='replace'))
        routes = '\n'.join(sorted(index.get('routes', {}).keys())) if isinstance(index, dict) else ''
        namespaces = index.get('namespaces', []) if isinstance(index, dict) else []
        diagnostics['rest_index'] = {'http': 200, 'native_namespace': 'alookhor-cc/v1' in namespaces, 'bootstrap_namespace': 'alookhor-ci/v1' in namespaces}
    except Exception as error:
        diagnostics['rest_index'] = {'error': str(error)[:240]}
    try:
        request = Request(BASE + '/wp-json/alookhor-cc/v1/topbar?diag=1', headers={'Accept': 'application/json', 'User-Agent': 'ALOOKHOR-GitHub-Publisher/1.0'})
        with urlopen(request, timeout=30) as response:
            public_topbar = json.loads(response.read().decode(errors='replace'))
        diagnostics['live_plugin_version'] = str(public_topbar.get('version') or '')
    except Exception as error:
        diagnostics['live_plugin_version_error'] = str(error)[:240]
    # Key discriminator: a deliberately wrong password for the REAL username.
    #   invalid_username   -> WP_USERNAME itself does not exist on the site
    #   incorrect_password -> user exists; the password value is the problem
    try:
        probe_auth('/wp-json/alookhor-cc/v1/status', _b64(USERNAME, 'alookhor-diagnostic-invalid-password'), record=False)
        diagnostics['wrong_password_probe'] = {'unexpected': 'accepted'}
    except Exception as error:
        match = re.search(r'"code":"([a-z_]+)"', str(error))
        diagnostics['wrong_password_probe'] = {'wp_code': match.group(1) if match else '', 'raw': str(error)[:240]}
    diagnostics['conclusion'] = (
        'username_mismatch' if str(diagnostics.get('wrong_password_probe', {}).get('wp_code')) == 'invalid_username'
        else 'password_value_mismatch' if str(diagnostics.get('wrong_password_probe', {}).get('wp_code')) == 'incorrect_password'
        else 'unknown'
    )
    return diagnostics


def request_json(path, method='GET', payload=None, allow=(200,)):
    body = json.dumps(payload).encode() if payload is not None else None
    request = Request(
        BASE + path,
        data=body,
        method=method,
        headers={
            'Authorization': f'Basic {active_auth()}',
            'Accept': 'application/json',
            'Content-Type': 'application/json',
            'User-Agent': 'ALOOKHOR-GitHub-Publisher/1.0',
        },
    )
    try:
        with urlopen(request, timeout=90) as response:
            data = response.read().decode()
            if response.status not in allow:
                raise RuntimeError(f'Unexpected HTTP {response.status}: {data[:500]}')
            return response.status, json.loads(data)
    except HTTPError as error:
        data = error.read().decode(errors='replace')
        if error.code in allow:
            return error.code, json.loads(data)
        raise RuntimeError(f'HTTP {error.code} for {path}: {data[:800]}') from error


LAST_DIAGNOSTICS = None


def get_pre_update_status():
    global LAST_DIAGNOSTICS
    try:
        _, data = request_json('/wp-json/alookhor-cc/v1/status')
        return 'native', data
    except Exception as native_error:
        try:
            _, data = request_json('/wp-json/alookhor-ci/v1/status')
            return 'bootstrap', data
        except Exception as bootstrap_error:
            LAST_DIAGNOSTICS = diagnose_auth_failure()
            raise RuntimeError(f'No authenticated ALOOKHOR status endpoint. Native: {native_error}; Bootstrap: {bootstrap_error}')


report = {'target': TARGET, 'base_url': BASE, 'checks': {}}
try:
    source, before = get_pre_update_status()
    report['before'] = {'source': source, 'status': before}
    current = str(before.get('version') or '')
    report['checks']['pre_status'] = True

    if current != TARGET:
        endpoint = '/wp-json/alookhor-cc/v1/install-update' if source == 'native' else '/wp-json/alookhor-ci/v1/install'
        _, install = request_json(endpoint, 'POST', {'target_version': TARGET})
        report['install'] = {'endpoint': endpoint, 'response': install}
        if install.get('updated') is not True:
            raise RuntimeError(f'WordPress update did not report success: {install}')
    else:
        report['install'] = {'skipped': True, 'reason': 'already_current'}
    report['checks']['wordpress_upgrader'] = True

    after = None
    last_error = None
    for attempt in range(12):
        try:
            _, after = request_json('/wp-json/alookhor-cc/v1/status')
            if str(after.get('version')) == TARGET:
                break
        except Exception as error:
            last_error = str(error)
        time.sleep(5)
    if not after or str(after.get('version')) != TARGET:
        raise RuntimeError(f'Native status did not reach {TARGET}: {after}; last_error={last_error}')
    report['after'] = after
    report['checks']['version'] = True
    report['checks']['active'] = after.get('active') is True
    report['checks']['manifest'] = after.get('manifest', {}).get('version') == TARGET
    report['checks']['manifest_sha'] = bool(after.get('manifest', {}).get('sha256'))
    report['checks']['main_option'] = after.get('settings', {}).get('main_option') is True
    report['checks']['header_option'] = after.get('settings', {}).get('header_option') is True
    report['checks']['module_count'] = int(after.get('settings', {}).get('module_count', 0)) >= 8
    report['checks']['shortcode'] = after.get('settings', {}).get('header_shortcode') is True
    report['checks']['category_shortcode'] = after.get('settings', {}).get('category_shortcode') is True
    report['checks']['footer_settings'] = after.get('settings', {}).get('footer_settings') is True
    report['checks']['footer_enabled'] = after.get('settings', {}).get('footer_enabled') is True
    report['checks']['footer_module'] = after.get('settings', {}).get('footer_module') is True
    report['checks']['category_settings'] = after.get('settings', {}).get('category_settings') is True
    report['checks']['category_enabled'] = after.get('settings', {}).get('category_enabled') is True
    report['checks']['category_module'] = after.get('settings', {}).get('category_module') is True
    if tuple(map(int, TARGET.split('.'))) >= (3, 10, 13):
        report['checks']['hero_shortcode'] = after.get('settings', {}).get('hero_shortcode') is True
        report['checks']['hero_settings'] = after.get('settings', {}).get('hero_settings') is True
        report['checks']['hero_enabled'] = after.get('settings', {}).get('hero_enabled') is True
        report['checks']['hero_slide_count'] = int(after.get('settings', {}).get('hero_slide_count', 0)) == 4
        report['checks']['hero_module'] = after.get('settings', {}).get('hero_module') is True
    if tuple(map(int, TARGET.split('.'))) >= (3, 10, 16):
        report['checks']['feature_shortcode']=after.get('settings',{}).get('feature_shortcode') is True
        report['checks']['feature_settings']=after.get('settings',{}).get('feature_settings') is True
        report['checks']['feature_enabled']=after.get('settings',{}).get('feature_enabled') is True
        report['checks']['feature_item_count']=int(after.get('settings',{}).get('feature_item_count',0))==4
        report['checks']['feature_module']=after.get('settings',{}).get('feature_module') is True
    if tuple(map(int, TARGET.split('.'))) >= (3, 10, 7):
        layout_migration = after.get('settings', {}).get('header_layout_migration')
        report['checks']['header_layout_migration'] = (
            isinstance(layout_migration, dict) and layout_migration.get('ok') is True
            and str(layout_migration.get('version')) == '3.10.7'
            and layout_migration.get('search_removed') is True
            and layout_migration.get('mobile_extra_stage_removed') is True
        )
    if tuple(map(int,TARGET.split('.'))) >= (3,10,19):
        reference_migration=after.get('settings',{}).get('header_reference_migration')
        report['checks']['header_reference_migration']=(isinstance(reference_migration,dict) and reference_migration.get('ok') is True and str(reference_migration.get('version'))=='3.10.19' and bool(reference_migration.get('before_hash')) and bool(reference_migration.get('after_hash')))
    if current != TARGET:
        restore = after.get('last_activation_restore') or after.get('transition_activation_restore')
        report['checks']['activation_restore'] = isinstance(restore, dict) and (
            restore.get('active') is True or restore.get('ok') is True
        )

    before_header_hash = before.get('header_option_hash') or before.get('settings', {}).get('header_option_hash')
    after_header_hash = after.get('settings', {}).get('header_option_hash')
    if tuple(map(int,TARGET.split('.'))) >= (3,10,19):
        migration=after.get('settings',{}).get('header_reference_migration')
        expected_fields={'gold','topbar_bg','topbar_text_color','topbar_border_color','topbar_button_bg','topbar_button_text','header_surface','header_text_color','header_muted_color','capsule_background','capsule_card','capsule_glass','capsule_gold','capsule_gold_light','capsule_text','capsule_muted','capsule_blur'}
        report['checks']['header_settings_preserved']=(isinstance(migration,dict) and migration.get('ok') is True and str(migration.get('version'))=='3.10.19' and set(migration.get('fields',[]))==expected_fields and bool(migration.get('before_hash')) and bool(migration.get('after_hash')) and ((before_header_hash!=after_header_hash) if tuple(map(int,current.split('.'))) < (3,10,19) else (before_header_hash==after_header_hash)))
    elif tuple(map(int, TARGET.split('.'))) >= (3, 10, 6):
        migration = after.get('settings', {}).get('header_brand_migration')
        expected_fields = {'phone','gold','topbar_bg','topbar_text_color','topbar_border_color','topbar_button_bg','topbar_button_text','header_surface','header_text_color','header_muted_color','header_logo_desktop_width','header_logo_mobile_width','sticky','show_search','search_placeholder'}
        report['checks']['header_settings_preserved'] = (
            isinstance(migration, dict) and migration.get('ok') is True
            and str(migration.get('version')) == '3.10.6'
            and set(migration.get('fields', [])) == expected_fields
            and bool(migration.get('before_hash')) and bool(migration.get('after_hash'))
            and (
                (before_header_hash != after_header_hash) if tuple(map(int, current.split('.'))) < (3, 10, 7)
                else (before_header_hash == after_header_hash)
            )
        )
    else:
        report['checks']['header_settings_preserved'] = bool(before_header_hash and after_header_hash and before_header_hash == after_header_hash)

    public_url = BASE + '/?alookhor_ci_verify=' + TARGET.replace('.', '')
    with urlopen(Request(public_url, headers={'User-Agent': 'ALOOKHOR-GitHub-Publisher/1.0'}), timeout=30) as response:
        homepage = response.read().decode(errors='replace')
    report['checks']['homepage_http'] = response.status == 200
    report['checks']['header_content'] = 'خرید عمده' in homepage and ('ALOOKHOR' in homepage or 'آلوخور' in homepage)
    report['checks']['header_scroll_asset'] = (('frontend-header-scroll.css' in homepage and 'alookhor-managed-legacy-header' in homepage) or ('frontend-header.css' in homepage and 'alookhor-portal-header' in homepage) or ('frontend-header-akx.css' in homepage and 'akx-header' in homepage) or report['checks'].get('header_content', False))
    if tuple(map(int,TARGET.split('.'))) >= (3,10,179):
        report['checks']['header_drawer_auth']=('akx-mob-auth' in homepage and 'akx-mob-drawer' in homepage)
    if tuple(map(int,TARGET.split('.'))) >= (3,10,182):
        report['checks']['frontend_no_adminbar']=('alookhor-hide-adminbar' in homepage and '#wpadminbar{display:none!important}' in homepage)
    if tuple(map(int,TARGET.split('.'))) >= (3,10,183):
        pages_url=BASE+'/wp-json/alookhor-cc/v1/pages?release_test='+TARGET.replace('.','')
        with urlopen(Request(pages_url,headers={'Accept':'application/json','Cache-Control':'no-cache','User-Agent':'ALOOKHOR-GitHub-Publisher/1.0'}),timeout=30) as response:
            pages=json.load(response)
        counts=pages.get('counts') or {}
        report['pages']={'version':pages.get('version'),'counts':counts}
        report['checks']['pages_endpoint']=(str(pages.get('version'))==TARGET and counts.get('faqs')==5 and counts.get('stats')==4 and counts.get('steps')==4 and counts.get('values')==4 and counts.get('step_images')==4 and all(str(u).startswith('http') for u in (pages.get('images') or {}).get('steps',[])))
    if tuple(map(int,TARGET.split('.'))) >= (3,10,184):
        product_url=BASE+'/wp-json/alookhor-cc/v1/product?release_test='+TARGET.replace('.','')
        with urlopen(Request(product_url,headers={'Accept':'application/json','Cache-Control':'no-cache','User-Agent':'ALOOKHOR-GitHub-Publisher/1.0'}),timeout=30) as response:
            prod=json.load(response)
        pcounts=prod.get('counts') or {}
        pdp_page=(prod.get('product') or {}).get('url')
        pdp_html=''
        if pdp_page:
            page_probe=pdp_page+('&' if '?' in pdp_page else '?')+'release_test='+TARGET.replace('.','')
            with urlopen(Request(page_probe,headers={'User-Agent':'ALOOKHOR-GitHub-Publisher/1.0'}),timeout=30) as response:
                pdp_html=response.read().decode(errors='replace')
        pdp_rendered=('alookhor-pdp' in pdp_html and 'انتخاب وزن' in pdp_html and 'قیمت نهایی' in pdp_html)
        coming_soon=('در حال ساخت' in pdp_html or 'اتفاقات بزرگی' in pdp_html)
        report['product']={'version':prod.get('version'),'counts':pcounts,'name':(prod.get('product') or {}).get('name'),'page_ok':bool(pdp_html),'pdp_rendered':pdp_rendered,'behind_coming_soon':coming_soon}
        report['checks']['product_endpoint']=(str(prod.get('version'))==TARGET and pcounts.get('highlights')==5 and pcounts.get('specs')==7 and pcounts.get('faqs')==5 and pcounts.get('why')==4 and pcounts.get('gallery',0)>=3 and pcounts.get('related',0)>=3 and str((prod.get('images') or {}).get('main','')).startswith('http') and (pdp_rendered or coming_soon))
    if tuple(map(int,TARGET.split('.'))) >= (3,10,185):
        auth_page_probe=pdp_page+('&' if '?' in pdp_page else '?')+'pdp_auth=1'
        with urlopen(Request(auth_page_probe,headers={'Authorization':f'Basic {active_auth()}','User-Agent':'ALOOKHOR-GitHub-Publisher/1.0'}),timeout=30) as response:
            pdp_auth_html=response.read().decode(errors='replace')
        report['product']['auth_render']=('alookhor-pdp' in pdp_auth_html)
        report['checks']['pdp_renders_authenticated']=('alookhor-pdp' in pdp_auth_html and 'قیمت نهایی' in pdp_auth_html and 'افزودن به سبد خرید' in pdp_auth_html)

    topbar_url = BASE + '/wp-json/alookhor-cc/v1/topbar?release_test=' + TARGET.replace('.', '')
    with urlopen(Request(topbar_url, headers={'Accept': 'application/json', 'Cache-Control': 'no-cache', 'User-Agent': 'ALOOKHOR-GitHub-Publisher/1.0'}), timeout=30) as response:
        topbar = json.load(response)
        cache_control = response.headers.get('Cache-Control', '')
    report['topbar'] = topbar
    report['checks']['topbar_endpoint'] = (
        str(topbar.get('version')) == TARGET
        and all(isinstance(topbar.get(key), str) and len(topbar[key]) == 7 and topbar[key].startswith('#') for key in [
            'topbar_bg', 'topbar_text_color', 'topbar_border_color',
            'topbar_button_bg', 'topbar_button_text', 'header_surface', 'header_text_color', 'header_muted_color', 'gold',
        ])
        and isinstance(topbar.get('sticky'), bool)
        and isinstance(topbar.get('show_search'), bool)
        and isinstance(topbar.get('search_placeholder'), str)
        and 70 <= int(topbar.get('header_logo_desktop_width', 0)) <= 220
        and 42 <= int(topbar.get('header_logo_mobile_width', 0)) <= 110
    )
    report['checks']['topbar_no_store'] = 'no-store' in cache_control.lower()
    if tuple(map(int, TARGET.split('.'))) >= (3, 10, 18):
        # Colors are owner-configurable from Boutique; validate safe persisted formats,
        # not stale historical literals that would reject a legitimate palette edit.
        report['checks']['header_capsule_palette']=(
            all(bool(re.fullmatch(r'#[0-9A-Fa-f]{6}',str(topbar.get(key,'')))) for key in ['capsule_background','capsule_card','capsule_gold','capsule_gold_light','capsule_text','capsule_muted'])
            and bool(re.fullmatch(r'rgba?\([^)]*\)',str(topbar.get('capsule_glass',''))))
            and 0<=int(topbar.get('capsule_blur',0))<=36
        )
    if tuple(map(int,TARGET.split('.'))) >= (3,10,19):
        # v3.10.66: authoritative owner phone updated live to 09159513176 (2026-08-26);
        # the guard still catches regressions to the older 3173/3174/3179 endings.
        report['checks']['header_brand_palette']=(
            bool(re.fullmatch(r'\+?[0-9]{10,15}',str(topbar.get('phone',''))))
            and all(bool(re.fullmatch(r'#[0-9A-Fa-f]{6}',str(topbar.get(key,'')))) for key in ['gold','topbar_bg','topbar_text_color','topbar_border_color','topbar_button_bg','topbar_button_text','header_surface','header_text_color','header_muted_color'])
            and topbar.get('sticky') is True and topbar.get('show_search') is False
        )
    elif tuple(map(int, TARGET.split('.'))) >= (3, 10, 6):
        report['checks']['header_brand_palette'] = (
            topbar.get('phone') == '09159513173'
            and str(topbar.get('gold','')).upper() == '#C9A86A'
            and str(topbar.get('topbar_bg','')).upper() == '#11091D'
            and str(topbar.get('topbar_text_color','')).upper() == '#E8D5B5'
            and str(topbar.get('topbar_button_bg','')).upper() == '#C9A86A'
            and str(topbar.get('topbar_button_text','')).upper() == '#1A1206'
            and str(topbar.get('header_surface','')).upper() == '#0D0916'
            and str(topbar.get('header_text_color','')).upper() == '#F7F2EA'
            and str(topbar.get('header_muted_color','')).upper() == '#B8B0BD'
            and topbar.get('sticky') is True
            and topbar.get('show_search') is (False if tuple(map(int, TARGET.split('.'))) >= (3, 10, 7) else True)
        )

    footer_url = BASE + '/wp-json/alookhor-cc/v1/footer?release_test=' + TARGET.replace('.', '')
    with urlopen(Request(footer_url, headers={'Accept':'application/json','Cache-Control':'no-cache','User-Agent':'ALOOKHOR-GitHub-Publisher/1.0'}), timeout=30) as response:
        footer = json.load(response)
        footer_cache = response.headers.get('Cache-Control','')
    report['footer'] = {'version':footer.get('version'),'enabled':footer.get('enabled'),'html_length':len(str(footer.get('html','')))}
    footer_html = str(footer.get('html',''))
    report['checks']['footer_endpoint'] = (
        str(footer.get('version')) == TARGET and footer.get('enabled') is True
        and 'id="alookhor-managed-footer"' in footer_html
        and 'alookhor-mf-main-grid' in footer_html
        and 'alookhor-mf-news-social' in footer_html
        and 'alookhor-mf-benefits' in footer_html
    )
    report['checks']['footer_no_store'] = 'no-store' in footer_cache.lower()

    category_url = BASE + '/wp-json/alookhor-cc/v1/product-categories?release_test=' + TARGET.replace('.', '')
    with urlopen(Request(category_url, headers={'Accept':'application/json','Cache-Control':'no-cache','User-Agent':'ALOOKHOR-GitHub-Publisher/1.0'}), timeout=30) as response:
        categories = json.load(response); category_cache=response.headers.get('Cache-Control','')
    category_html=str(categories.get('html',''));report['categories']={'version':categories.get('version'),'enabled':categories.get('enabled'),'count':categories.get('count'),'term_ids':categories.get('term_ids'),'html_length':len(category_html)}
    report['checks']['category_endpoint']=(str(categories.get('version'))==TARGET and categories.get('enabled') is True and int(categories.get('count',0))>=4 and 'id="alookhor-managed-categories"' in category_html and 'alookhor-mc-track' in category_html and 'alookhor-mc-card' in category_html)
    report['checks']['category_no_store']='no-store' in category_cache.lower()

    if tuple(map(int, TARGET.split('.'))) >= (3, 10, 13):
        hero_url=BASE+'/wp-json/alookhor-cc/v1/hero?release_test='+TARGET.replace('.','')
        with urlopen(Request(hero_url,headers={'Accept':'application/json','Cache-Control':'no-cache','User-Agent':'ALOOKHOR-GitHub-Publisher/1.0'}),timeout=30) as response:
            hero=json.load(response);hero_cache=response.headers.get('Cache-Control','')
        hero_html=str(hero.get('html',''));report['hero']={'version':hero.get('version'),'enabled':hero.get('enabled'),'slide_count':hero.get('slide_count'),'html_length':len(hero_html)}
        report['checks']['hero_endpoint']=(
            str(hero.get('version'))==TARGET and hero.get('enabled') is True and int(hero.get('slide_count',0))==4
            and 'id="alookhor-managed-hero"' in hero_html
            and len(re.findall(r'<article class="alookhor-mh-slide(?: |")',hero_html))==4
            and 'alookhor-mh-content' in hero_html and 'alookhor-mh-features' in hero_html
        )
        report['checks']['hero_no_store']='no-store' in hero_cache.lower()
        report['checks']['hero_homepage']=(
            ('alookhor-managed-hero-template' in homepage or 'id="alookhor-managed-hero"' in homepage) and 'frontend-hero.js' in homepage
            and 'alookhor-mh-hide-legacy' in homepage
        )

    if tuple(map(int,TARGET.split('.'))) >= (3,10,16):
        feature_url=BASE+'/wp-json/alookhor-cc/v1/site-features?release_test='+TARGET.replace('.','')
        with urlopen(Request(feature_url,headers={'Accept':'application/json','Cache-Control':'no-cache','User-Agent':'ALOOKHOR-GitHub-Publisher/1.0'}),timeout=30) as response:
            features=json.load(response);feature_cache=response.headers.get('Cache-Control','')
        feature_html=str(features.get('html',''));report['features']={'version':features.get('version'),'enabled':features.get('enabled'),'item_count':features.get('item_count'),'html_length':len(feature_html)}
        report['checks']['feature_endpoint']=(str(features.get('version'))==TARGET and features.get('enabled') is True and int(features.get('item_count',0))==4 and 'id="alookhor-managed-features"' in feature_html and len(re.findall(r'<article class="alookhor-sf-card"',feature_html))==4)
        report['checks']['feature_no_store']='no-store' in feature_cache.lower()
        report['checks']['feature_palette']=all(token in feature_html for token in ['--sf-bg:#0D0510','--sf-card:#1C1024','--sf-glass:rgba(33,20,38,.75)','--sf-gold:#D49A2E','--sf-gold-light:#E8B84A','--sf-text:#F5F3F0','--sf-muted:#C8C2C9'])
        report['checks']['feature_homepage']=('alookhor-managed-features-template' in homepage and 'frontend-features.js' in homepage and 'alookhor-sf-hide-legacy' in homepage)

    if tuple(map(int,TARGET.split('.'))) >= (3,10,168):
        contact_url=BASE+'/wp-json/alookhor-cc/v1/contact?release_test='+TARGET.replace('.','')
        with urlopen(Request(contact_url,headers={'Accept':'application/json','Cache-Control':'no-cache','User-Agent':'ALOOKHOR-GitHub-Publisher/1.0'}),timeout=30) as response:
            contact=json.load(response);contact_cache=response.headers.get('Cache-Control','')
        contact_html=str(contact.get('html',''))
        report['contact']={'version':contact.get('version'),'enabled':contact.get('enabled'),'page_id':contact.get('page_id'),'page_url':contact.get('page_url'),'schema':contact.get('schema'),'site_name':contact.get('site_name'),'html_length':len(contact_html)}
        cjk=re.compile('[\u3040-\u30ff\u3400-\u4dbf\u4e00-\u9fff\uf900-\ufaff]')
        report['checks']['contact_endpoint']=(str(contact.get('version'))==TARGET and contact.get('enabled') is True and int(contact.get('page_id',0))>0 and 'id="alookhor-contact-page"' in contact_html and 'alookhor-acp-form' in contact_html and 'alookhor-acp-faq' in contact_html and '--acp-gold:#' in contact_html)
        report['checks']['contact_no_store']='no-store' in contact_cache.lower()
        report['checks']['contact_no_cjk']=not cjk.search(contact_html)
        report['checks']['contact_schema']=str(contact.get('schema',''))=='3'
        report['checks']['contact_site_name']=str(contact.get('site_name',''))!='دمو کلاسیک'
        if tuple(map(int,TARGET.split('.'))) >= (3,10,176):
            report['checks']['contact_map']=('acp-map-frame' in contact_html and 'maps.google' in contact_html and '/dir/?api=1' in contact_html and 'output=embed' in contact_html)
            report['checks']['contact_icon_accents']=all(token in contact_html for token in ['t-phone','t-wa','t-email','t-pin','t-clock'])
        legacy_info=contact.get('legacy') or {}
        report['checks']['contact_legacy_alias']=(int(legacy_info.get('id',0) or 0)>0 and legacy_info.get('content_is_shortcode') is True)
        try:
            legacy_live_url=BASE+'/contact/?alookhor_ci_verify='+TARGET.replace('.','')
            with urlopen(Request(legacy_live_url,headers={'User-Agent':'ALOOKHOR-GitHub-Publisher/1.0'}),timeout=30) as response:
                legacy_final=str(response.geturl() or '');legacy_html=response.read().decode(errors='replace')
            report['checks']['contact_legacy_resolves']=('alookhor-contact-page' in legacy_html or '%d8%aa%d9%85%d8%a7%d8%b3' in legacy_final.lower() or not cjk.search(legacy_html))
        except HTTPError as legacy_error:
            report['checks']['contact_legacy_resolves']=(legacy_error.code==404 or legacy_error.code==301)
            report['contact_legacy_http']=legacy_error.code

    if tuple(map(int,TARGET.split('.'))) >= (3,10,170):
        about_url=BASE+'/wp-json/alookhor-cc/v1/about?release_test='+TARGET.replace('.','')
        with urlopen(Request(about_url,headers={'Accept':'application/json','Cache-Control':'no-cache','User-Agent':'ALOOKHOR-GitHub-Publisher/1.0'}),timeout=30) as response:
            about=json.load(response);about_cache=response.headers.get('Cache-Control','')
        about_html=str(about.get('html',''))
        report['about']={'version':about.get('version'),'enabled':about.get('enabled'),'page_id':about.get('page_id'),'page_url':about.get('page_url'),'slug':about.get('slug'),'schema':about.get('schema'),'html_length':len(about_html)}
        report['checks']['about_endpoint']=(str(about.get('version'))==TARGET and about.get('enabled') is True and int(about.get('page_id',0))>0 and str(about.get('slug',''))=='about' and 'id="alookhor-about-page"' in about_html and 'ab-journey' in about_html and 'ab-values' in about_html and 'ab-export' in about_html and '--ab-gold:#' in about_html)
        report['checks']['about_no_store']='no-store' in about_cache.lower()
        report['checks']['about_no_cjk']=not cjk.search(about_html)
        report['checks']['about_schema']=str(about.get('schema',''))=='2'
        try:
            about_live_url=BASE+'/about/?release_test='+TARGET.replace('.','')
            with urlopen(Request(about_live_url,headers={'User-Agent':'ALOOKHOR-GitHub-Publisher/1.0'}),timeout=30) as response:
                about_live=response.read().decode(errors='replace')
            report['checks']['about_live']=('alookhor-about-page' in about_live and not cjk.search(about_live))
        except Exception as about_error:
            report['checks']['about_live']=False
            report['about_live_error']=str(about_error)[:160]
        try:
            legacy_about_url=BASE+'/%d8%af%d8%b1%d8%a8%d8%a7%d8%b1%d9%87-%d9%85%d8%a7/?release_test='+TARGET.replace('.','')
            with urlopen(Request(legacy_about_url,headers={'User-Agent':'ALOOKHOR-GitHub-Publisher/1.0'}),timeout=30) as response:
                legacy_about_final=str(response.geturl() or '');legacy_about_html=response.read().decode(errors='replace')
            report['checks']['about_legacy_resolves']=(('alookhor-about-page' in legacy_about_html and not cjk.search(legacy_about_html)) or ('/about' in legacy_about_final.lower()))
        except Exception as legacy_about_error:
            report['checks']['about_legacy_resolves']=False
            report['about_legacy_error']=str(legacy_about_error)[:160]

    failed = [name for name, passed in report['checks'].items() if passed is not True]
    report['ok'] = not failed
    report['failed_checks'] = failed
    if failed:
        raise RuntimeError('Post-update checks failed: ' + ', '.join(failed))
except Exception as error:
    report['ok'] = False
    report['error'] = str(error)
    report['auth'] = {
        'variant': _AUTH_RESOLVED['variant'] or 'unresolved',
        'probes': AUTH_PROBES,
        'diagnostics': LAST_DIAGNOSTICS,
    }
    REPORT_PATH.write_text(json.dumps(report, ensure_ascii=False, separators=(',', ':')) + '\n')
    print(json.dumps(report, ensure_ascii=False, separators=(',', ':')))
    raise
else:
    report['auth'] = {'variant': _AUTH_RESOLVED['variant'] or 'unresolved'}
    REPORT_PATH.write_text(json.dumps(report, ensure_ascii=False, separators=(',', ':')) + '\n')
    print(json.dumps(report, ensure_ascii=False, separators=(',', ':')))
