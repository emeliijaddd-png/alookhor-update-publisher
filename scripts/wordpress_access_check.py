#!/usr/bin/env python3
from pathlib import Path
from urllib.request import Request, urlopen
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
