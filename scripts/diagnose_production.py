#!/usr/bin/env python3
"""Read-only production diagnosis. Never logs response bodies or credentials.

Authenticated Application Password requests call ONLY two read-only GET
endpoints: WordPress' own /users/me and ALOOKHOR's /status.
Requests made by this script originate from the GitHub runner, not WordPress.
Only the authenticated status response can describe a request made by WordPress.
"""

import base64
import json
import os
import re
import socket
import ssl
import sys
from pathlib import Path
from urllib.error import HTTPError, URLError
from urllib.parse import urlsplit
from urllib.request import HTTPRedirectHandler, HTTPSHandler, Request, build_opener

SITE = 'https://alookhor.ir'
PUBLIC_STATUS = SITE + '/wp-json/alookhor-cc/v1/topbar'
PRIVATE_STATUS = SITE + '/wp-json/alookhor-cc/v1/status'
PRIVATE_IDENTITY = SITE + '/wp-json/wp/v2/users/me?context=edit'
CHANNEL = 'https://updates.alookhor.ir/manifest.json'
MIRROR = 'https://raw.githubusercontent.com/emeliijaddd-png/alookhor-update-publisher/main/public/manifest.json'
ALLOWED_HOSTS = {'alookhor.ir', 'updates.alookhor.ir', 'raw.githubusercontent.com'}
MAX_BODY = 256 * 1024


class NoRedirects(HTTPRedirectHandler):
    """Never forward an Application Password to a redirect destination."""

    def redirect_request(self, request, fp, code, msg, headers, newurl):
        return None


def safe_base_url(url):
    """A mistake in a secret must never send Basic Auth to a different host."""
    parsed = urlsplit(url.rstrip('/'))
    if (parsed.scheme, parsed.hostname, parsed.port, parsed.path, parsed.query, parsed.fragment) != (
        'https', 'alookhor.ir', None, '', '', ''
    ) or parsed.username or parsed.password:
        raise ValueError('WP_BASE_URL must be exactly https://alookhor.ir')
    return SITE


def error_type(reason):
    if isinstance(reason, ssl.SSLError):
        return 'tls_error'
    if isinstance(reason, socket.gaierror):
        return 'dns_error'
    if isinstance(reason, (TimeoutError, socket.timeout)):
        return 'timeout'
    if isinstance(reason, ConnectionError):
        return 'connection_error'
    return 'network_error'


def fetch_json(url, auth=None):
    parsed = urlsplit(url)
    if parsed.scheme != 'https' or parsed.hostname not in ALLOWED_HOSTS or parsed.username or parsed.password:
        raise ValueError('Disallowed probe URL')
    headers = {
        'Accept': 'application/json',
        'Cache-Control': 'no-cache',
        'User-Agent': 'ALOOKHOR-ReadOnly-Diagnostic/1.0',
    }
    if auth is not None:
        if parsed.hostname != 'alookhor.ir':
            raise ValueError('Authentication is restricted to alookhor.ir')
        username, password = auth
        headers['Authorization'] = 'Basic ' + base64.b64encode(f'{username}:{password}'.encode()).decode()
    opener = build_opener(HTTPSHandler(context=ssl.create_default_context()), NoRedirects())
    try:
        with opener.open(Request(url, headers=headers, method='GET'), timeout=20) as response:
            data = response.read(MAX_BODY + 1)
            if len(data) > MAX_BODY:
                return {'http': response.status, 'error': 'response_too_large'}
            payload = json.loads(data)
            return {'http': response.status, 'data': payload if isinstance(payload, dict) else {}}
    except HTTPError as exc:
        return {'http': exc.code, 'error': 'http_error'}
    except URLError as exc:
        return {'http': None, 'error': error_type(exc.reason)}
    except (ValueError, UnicodeError):
        return {'http': 200, 'error': 'invalid_json'}
    except OSError as exc:
        return {'http': None, 'error': error_type(exc)}


def public_summary(result, version_key='version'):
    summary = {'http': result.get('http')}
    if 'error' in result:
        summary['error'] = result['error']
    if result.get('http') == 200:
        version = result.get('data', {}).get(version_key)
        if isinstance(version, str) and re.fullmatch(r'\d+\.\d+\.\d+', version):
            summary['version'] = version
    return summary


def private_summary(result):
    summary = public_summary(result)
    if result.get('http') != 200 or 'error' in result:
        return summary
    data = result.get('data', {})
    summary['active'] = data.get('active') is True
    configured_url = data.get('manifest_url', '')
    if isinstance(configured_url, str):
        host = urlsplit(configured_url).hostname or 'invalid'
        summary['manifest_host'] = host if host in ALLOWED_HOSTS | {'cdn.jsdelivr.net'} else 'other'
    manifest = data.get('manifest', {})
    if isinstance(manifest, dict):
        summary['manifest'] = {'ok': manifest.get('ok') is True}
        if manifest.get('ok') is True:
            candidate = manifest.get('version', '')
            summary['manifest']['version'] = candidate if isinstance(candidate, str) and re.fullmatch(r'\d+\.\d+\.\d+', candidate) else 'invalid'
            package_host = str(manifest.get('package_host', '')).lower()
            summary['manifest']['package_host'] = package_host if package_host in ALLOWED_HOSTS | {'cdn.jsdelivr.net'} else 'other'
        else:
            code = str(manifest.get('error', 'unknown'))
            summary['manifest']['error_code'] = code if re.fullmatch(r'[a-zA-Z0-9_-]{1,60}', code) else 'other'
            # Show only a numeric HTTP/cURL code, never the raw error message.
            message = str(manifest.get('message', ''))
            for label, pattern in [('http_code', r'\bHTTP\s+(\d{3})\b'), ('curl_code', r'\bcURL error\s+(\d+)\b')]:
                match = re.search(pattern, message, re.I)
                if match:
                    summary['manifest'][label] = int(match.group(1))
    return summary


def identity_summary(result):
    """Only whether Basic Auth works and whether update_plugins is granted."""
    summary = {'http': result.get('http')}
    if 'error' in result:
        summary['error'] = result['error']
    if result.get('http') == 200 and isinstance(result.get('data'), dict):
        capabilities = result['data'].get('capabilities')
        if isinstance(capabilities, dict):
            summary['update_plugins'] = capabilities.get('update_plugins') is True
    return summary


def run_probe(env=None):
    env = os.environ if env is None else env
    safe_base_url(env.get('WP_BASE_URL') or SITE)
    from time import time
    query = '?diagnostic=' + str(int(time()))
    report = {
        'scope': 'read_only',
        'probe_origin': 'github_runner_except_authenticated_status',
        'repository_release': json.loads((Path(__file__).resolve().parents[1] / 'release.json').read_text(encoding='utf-8'))['version'],
        'site': public_summary(fetch_json(PUBLIC_STATUS + query)),
        'update_channel': public_summary(fetch_json(CHANNEL + query)),
        'github_mirror': public_summary(fetch_json(MIRROR + query)),
    }
    username, password = env.get('WP_USERNAME', ''), env.get('WP_APP_PASSWORD', '')
    if username and password:
        report['wordpress_auth'] = identity_summary(fetch_json(PRIVATE_IDENTITY, (username, password)))
        report['wordpress'] = private_summary(fetch_json(PRIVATE_STATUS, (username, password)))
    else:
        report['wordpress_auth'] = {'state': 'not_checked'}
        report['wordpress'] = {'state': 'not_authenticated', 'required_secret_names': [
            name for name, value in [('WP_USERNAME', username), ('WP_APP_PASSWORD', password)] if not value
        ]}
    return report


def render_summary(report):
    lines = ['## ALOOKHOR read-only production diagnostic', '',
             '> GitHub runner probes are NOT proof of outbound connectivity from the WordPress host.',
             '> No installation, settings change, or credential disclosure was performed.', '',
             f"- Repository release: `{report['repository_release']}`",
             f"- Live public plugin version: `{report['site'].get('version', 'unavailable')}`",
             f"- Public update manifest: HTTP `{report['update_channel'].get('http', 'network error')}`",
             f"- GitHub mirror manifest: version `{report['github_mirror'].get('version', 'unavailable')}`", '']
    wp = report['wordpress']
    if wp.get('state') == 'not_authenticated':
        lines.append('WordPress authenticated status: not checked; add the named GitHub Actions secrets and rerun.')
    else:
        lines += [f"Application Password identity: `{json.dumps(report['wordpress_auth'], ensure_ascii=False)}`",
                  f"WordPress status: HTTP `{wp.get('http', 'network error')}`; plugin `{wp.get('version', 'unavailable')}`",
                  f"WordPress-configured manifest host: `{wp.get('manifest_host', 'unavailable')}`",
                  f"WordPress manifest result: `{json.dumps(wp.get('manifest', {}), ensure_ascii=False)}`"]
    return '\n'.join(lines) + '\n'


def annotation_summary(report):
    """Public, small GitHub annotation for when runner log downloads are blocked."""
    wp = report['wordpress']
    return json.dumps({
        'repository_release': report['repository_release'],
        'site': report['site'],
        'update_channel': report['update_channel'],
        'github_mirror': report['github_mirror'],
        'wordpress_auth': report['wordpress_auth'],
        'wordpress': wp,
    }, ensure_ascii=False, separators=(',', ':'))


def main():
    try:
        report = run_probe()
    except (ValueError, OSError, KeyError) as exc:
        # Only our own fixed diagnostic errors are printed; never print env data.
        print('Diagnostic configuration error:', type(exc).__name__)
        return 2
    print(json.dumps(report, ensure_ascii=False, sort_keys=True))
    if os.environ.get('GITHUB_ACTIONS') == 'true':
        print('::notice title=ALOOKHOR read-only diagnostic::' + annotation_summary(report))
    if os.environ.get('GITHUB_STEP_SUMMARY'):
        with open(os.environ['GITHUB_STEP_SUMMARY'], 'a', encoding='utf-8') as stream:
            stream.write(render_summary(report))
    # A missing public manifest or a version ahead of the tracked source is a
    # diagnostic failure, not a reason to install the repository package.
    return 0 if report['update_channel'].get('http') == 200 and report['site'].get('version') == report['repository_release'] else 1


if __name__ == '__main__':
    sys.exit(main())
