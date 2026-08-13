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

    public_url = base + '/?alookhor_access_audit=' + production_version.replace('.', '')
    with urlopen(Request(public_url, headers={'User-Agent': 'ALOOKHOR-GitHub-Publisher/1.0'}), timeout=30) as response:
        homepage = response.read().decode(errors='replace')
        report['checks']['homepage_http'] = response.status == 200
    report['checks']['header_content'] = 'خرید عمده' in homepage and ('ALOOKHOR' in homepage or 'آلوخور' in homepage)

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
    topbar_index = homepage.find('alookhor-topbar-wrapper')
    topbar_fragment = ''
    if topbar_index >= 0:
        fragment_start = homepage.rfind('<', 0, topbar_index)
        topbar_fragment = re.sub(r'\s+', ' ', homepage[max(0, fragment_start):topbar_index + 6000]).strip()
    report['public_topbar'] = {
        'managed_wrapper': 'alookhor-managed-legacy-header' in homepage,
        'manager_script': 'frontend-topbar-manager.js' in homepage,
        'localized': localized,
        'relevant_classes': class_names[:100],
        'markup_fragment': topbar_fragment,
    }

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
            )
        except Exception as error:
            report['public_topbar']['manager_asset_error'] = str(error)
            report['checks']['manager_contact_span'] = False
    elif version_tuple(production_version) >= version_tuple('3.8.9'):
        report['checks']['manager_contact_span'] = False

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
            )
            report['checks']['topbar_no_store'] = 'no-store' in cache_control.lower()
        except Exception as error:
            report['public_topbar']['fresh_endpoint_error'] = str(error)
            report['checks']['topbar_endpoint'] = False
            report['checks']['topbar_no_store'] = False

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
