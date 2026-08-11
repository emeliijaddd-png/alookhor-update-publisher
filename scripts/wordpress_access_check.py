#!/usr/bin/env python3
from pathlib import Path
from urllib.error import HTTPError
from urllib.request import Request, urlopen
import base64
import json
import os

report_path = Path(os.environ.get('WP_REPORT_PATH', '/tmp/wordpress-access.json'))
report = {'ok': False, 'checks': {}}

try:
    base = os.environ.get('WP_BASE_URL', '').strip().rstrip('/')
    username = os.environ.get('WP_USERNAME', '').strip()
    app_password = os.environ.get('WP_APP_PASSWORD', '').strip()
    report['checks']['secrets_present'] = bool(base and username and app_password)
    if not report['checks']['secrets_present']:
        raise RuntimeError('Required WordPress GitHub Secrets are missing')
    if base != 'https://alookhor.ir':
        raise RuntimeError('WP_BASE_URL must be https://alookhor.ir')

    auth = base64.b64encode(f'{username}:{app_password}'.encode()).decode()
    errors = []
    status = None
    source = None
    for candidate, path in [
        ('native', '/wp-json/alookhor-cc/v1/status'),
        ('bootstrap', '/wp-json/alookhor-ci/v1/status'),
    ]:
        request = Request(base + path, headers={
            'Authorization': f'Basic {auth}',
            'Accept': 'application/json',
            'User-Agent': 'ALOOKHOR-GitHub-Publisher/1.0',
        })
        try:
            with urlopen(request, timeout=30) as response:
                status = json.load(response)
            source = candidate
            break
        except Exception as error:
            errors.append(f'{candidate}: {error}')
    if status is None:
        raise RuntimeError('No authenticated status endpoint: ' + '; '.join(errors))

    report['source'] = source
    report['status'] = status
    report['checks']['authenticated'] = True
    report['checks']['version'] = str(status.get('version')) == '3.8.5'
    report['checks']['active'] = status.get('active') is True
    report['checks']['header_option'] = bool(status.get('header_option_hash') or status.get('settings', {}).get('header_option'))
    report['checks']['shortcode'] = bool(status.get('shortcode') or status.get('settings', {}).get('header_shortcode'))
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
