#!/usr/bin/env python3
from pathlib import Path
from urllib.error import HTTPError, URLError
from urllib.request import Request, urlopen
import base64
import json
import os
import sys
import time

ROOT = Path(__file__).resolve().parents[1]
TARGET = str(json.loads((ROOT / 'release.json').read_text())['version'])
BASE = os.environ['WP_BASE_URL'].strip().rstrip('/')
USERNAME = os.environ['WP_USERNAME'].strip()
APP_PASSWORD = os.environ['WP_APP_PASSWORD'].strip()
REPORT_PATH = Path(os.environ.get('WP_REPORT_PATH', '/tmp/wordpress-report.json'))
AUTH = base64.b64encode(f'{USERNAME}:{APP_PASSWORD}'.encode()).decode()


def request_json(path, method='GET', payload=None, allow=(200,)):
    body = json.dumps(payload).encode() if payload is not None else None
    request = Request(
        BASE + path,
        data=body,
        method=method,
        headers={
            'Authorization': f'Basic {AUTH}',
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


def get_pre_update_status():
    try:
        _, data = request_json('/wp-json/alookhor-cc/v1/status')
        return 'native', data
    except Exception as native_error:
        try:
            _, data = request_json('/wp-json/alookhor-ci/v1/status')
            return 'bootstrap', data
        except Exception as bootstrap_error:
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
    if tuple(map(int, TARGET.split('.'))) >= (3, 10, 7):
        layout_migration = after.get('settings', {}).get('header_layout_migration')
        report['checks']['header_layout_migration'] = (
            isinstance(layout_migration, dict) and layout_migration.get('ok') is True
            and str(layout_migration.get('version')) == '3.10.7'
            and layout_migration.get('search_removed') is True
            and layout_migration.get('mobile_extra_stage_removed') is True
        )
    if current != TARGET:
        restore = after.get('last_activation_restore') or after.get('transition_activation_restore')
        report['checks']['activation_restore'] = isinstance(restore, dict) and (
            restore.get('active') is True or restore.get('ok') is True
        )

    before_header_hash = before.get('header_option_hash') or before.get('settings', {}).get('header_option_hash')
    after_header_hash = after.get('settings', {}).get('header_option_hash')
    if tuple(map(int, TARGET.split('.'))) >= (3, 10, 6):
        migration = after.get('settings', {}).get('header_brand_migration')
        expected_fields = {'phone','gold','topbar_bg','topbar_text_color','topbar_border_color','topbar_button_bg','topbar_button_text','header_surface','header_text_color','header_muted_color','header_logo_desktop_width','header_logo_mobile_width','sticky','show_search','search_placeholder'}
        report['checks']['header_settings_preserved'] = (
            isinstance(migration, dict) and migration.get('ok') is True
            and str(migration.get('version')) == '3.10.6'
            and set(migration.get('fields', [])) == expected_fields
            and bool(migration.get('before_hash')) and bool(migration.get('after_hash'))
            and before_header_hash != after_header_hash
        )
    else:
        report['checks']['header_settings_preserved'] = bool(before_header_hash and after_header_hash and before_header_hash == after_header_hash)

    public_url = BASE + '/?alookhor_ci_verify=' + TARGET.replace('.', '')
    with urlopen(Request(public_url, headers={'User-Agent': 'ALOOKHOR-GitHub-Publisher/1.0'}), timeout=30) as response:
        homepage = response.read().decode(errors='replace')
    report['checks']['homepage_http'] = response.status == 200
    report['checks']['header_content'] = 'خرید عمده' in homepage and ('ALOOKHOR' in homepage or 'آلوخور' in homepage)
    report['checks']['header_scroll_asset'] = 'frontend-header-scroll.css' in homepage

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
    if tuple(map(int, TARGET.split('.'))) >= (3, 10, 6):
        report['checks']['header_brand_palette'] = (
            topbar.get('phone') == '09159513173'
            and topbar.get('gold') == '#C9A86A'
            and topbar.get('topbar_bg') == '#11091D'
            and topbar.get('topbar_text_color') == '#E8D5B5'
            and topbar.get('topbar_button_bg') == '#C9A86A'
            and topbar.get('topbar_button_text') == '#1A1206'
            and topbar.get('header_surface') == '#0D0916'
            and topbar.get('header_text_color') == '#F7F2EA'
            and topbar.get('header_muted_color') == '#B8B0BD'
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

    failed = [name for name, passed in report['checks'].items() if passed is not True]
    report['ok'] = not failed
    report['failed_checks'] = failed
    if failed:
        raise RuntimeError('Post-update checks failed: ' + ', '.join(failed))
except Exception as error:
    report['ok'] = False
    report['error'] = str(error)
    REPORT_PATH.write_text(json.dumps(report, ensure_ascii=False, indent=2) + '\n')
    print(json.dumps(report, ensure_ascii=False, indent=2))
    raise
else:
    REPORT_PATH.write_text(json.dumps(report, ensure_ascii=False, indent=2) + '\n')
    print(json.dumps(report, ensure_ascii=False, indent=2))
