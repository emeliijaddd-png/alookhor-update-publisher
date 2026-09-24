#!/usr/bin/env python3
"""Fail closed when a WordPress release is incomplete or older than production.

This checker never installs or publishes a release. Run after build_release.py.
"""

import argparse
import hashlib
import json
import re
import ssl
import sys
from time import time_ns
from pathlib import Path
from urllib.parse import urlsplit
from urllib.request import Request, urlopen
from zipfile import ZipFile, BadZipFile

ROOT = Path(__file__).resolve().parents[1]
PLUGIN = ROOT / 'plugin/alookhor-control-center'
PUBLIC = ROOT / 'public'
PREFIX = 'alookhor-control-center/'
VERSION = re.compile(r'^\d+\.\d+\.\d+$')
PHP_INCLUDE = re.compile(rb"ALOOKHOR_CC_DIR\s*\.\s*['\"]([^'\"]+\.php)['\"]")
ASSET_URL = re.compile(rb"ALOOKHOR_CC_URL\s*\.\s*['\"](assets/[^'\"]+\.(?:css|js|png|jpe?g|webp|svg|woff2?))['\"]")
SKIP_PARTS = {'.git', '.github', '__pycache__', '.DS_Store'}


def version_tuple(text):
    if not isinstance(text, str) or not VERSION.fullmatch(text):
        raise ValueError('Invalid semantic version')
    return tuple(map(int, text.split('.')))


def source_problems(plugin, package):
    """All required static files must be inside the ZIP with their real source."""
    problems = []
    files = {
        path.relative_to(plugin).as_posix(): path.read_bytes()
        for path in plugin.rglob('*')
        if path.is_file() and not any(part in SKIP_PARTS for part in path.parts)
    }
    with ZipFile(package) as archive:
        if archive.testzip() is not None:
            problems.append('ZIP CRC verification failed')
        names = set(archive.namelist())
        expected = {PREFIX + name for name in files}
        for name in sorted(expected - names):
            problems.append('Missing from ZIP: ' + name)
        for name in sorted(names - expected):
            problems.append('Unexpected ZIP entry: ' + name)
        for relative, data in files.items():
            if PREFIX + relative in names and archive.read(PREFIX + relative) != data:
                problems.append('ZIP differs from source: ' + relative)
        # Check statically declared bootstrap requirements and enqueue paths.
        for relative, data in files.items():
            if not relative.endswith('.php'):
                continue
            for match in PHP_INCLUDE.findall(data):
                requirement = match.decode('utf-8')
                if requirement not in files:
                    problems.append('Missing required PHP source: ' + requirement + ' (from ' + relative + ')')
            for match in ASSET_URL.findall(data):
                asset = match.decode('utf-8')
                if asset not in files:
                    problems.append('Missing enqueued asset: ' + asset + ' (from ' + relative + ')')
            if b'Compatibility stub:' in data and relative.startswith('includes/'):
                problems.append('Implementation replaced by compatibility stub: ' + relative)
    return sorted(set(problems))


def check_release(root=ROOT):
    errors = []
    config = json.loads((root / 'release.json').read_text(encoding='utf-8'))
    manifest = json.loads((root / 'public/manifest.json').read_text(encoding='utf-8'))
    version = str(config['version'])
    version_tuple(version)
    expected_name = f'alookhor-control-center-{version}.zip'
    url = urlsplit(str(manifest.get('download_url', '')))
    if (url.scheme, url.hostname, url.port, url.username, url.password, url.path, url.query, url.fragment) != (
        'https', 'updates.alookhor.ir', None, None, None, '/releases/' + expected_name, '', ''
    ):
        errors.append('Manifest download URL must point to the versioned HTTPS update channel')
    if manifest.get('version') != version:
        errors.append('Manifest version differs from release.json')
    package = root / 'public/releases' / expected_name
    if not package.is_file():
        errors.append('Versioned release ZIP is missing')
    else:
        actual = hashlib.sha256(package.read_bytes()).hexdigest()
        if actual != manifest.get('sha256'):
            errors.append('Package SHA-256 differs from manifest')
        try:
            errors.extend(source_problems(root / 'plugin/alookhor-control-center', package))
        except (BadZipFile, OSError, ValueError) as exc:
            errors.append('Invalid release ZIP: ' + type(exc).__name__)
    return version, errors


def check_live_version(candidate, site='https://alookhor.ir'):
    """Read-only no-cache production version probe; never allow a downgrade."""
    if site != 'https://alookhor.ir':
        raise ValueError('Unexpected production host')
    # Production's rewrite serves this custom REST route with a trailing slash;
    # the slashless form currently returns rest_no_route despite an active plugin.
    request = Request(site + '/wp-json/alookhor-cc/v1/topbar/?release_gate=' + str(time_ns()), headers={
        'Accept': 'application/json', 'Cache-Control': 'no-cache',
        'User-Agent': 'ALOOKHOR-Release-Gate/1.0',
    }, method='GET')
    with urlopen(request, timeout=20, context=ssl.create_default_context()) as response:
        if response.status != 200 or urlsplit(response.geturl()).hostname != 'alookhor.ir':
            raise ValueError('Could not verify the production version')
        data = json.loads(response.read(65536))
    live = data.get('version')
    if version_tuple(candidate) <= version_tuple(live):
        raise ValueError(f'Candidate {candidate} is not newer than live {live}; refusing production deployment')
    return live


def main():
    parser = argparse.ArgumentParser()
    parser.add_argument('--live', action='store_true', help='Fail if the public site already runs this version or newer')
    args = parser.parse_args()
    try:
        version, errors = check_release()
        if errors:
            for error in errors:
                print('RELEASE BLOCKED:', error)
            return 1
        if args.live:
            state = json.loads((ROOT / 'release.json').read_text(encoding='utf-8')).get('state')
            if state != 'ready':
                raise ValueError('release.json is not ready')
            live = check_live_version(version)
            print('Production version gate passed:', live, '->', version)
        print('Release package gate passed:', version)
        return 0
    except (ValueError, OSError, KeyError, BadZipFile, json.JSONDecodeError) as exc:
        print('RELEASE BLOCKED:', str(exc)[:180])
        return 1


if __name__ == '__main__':
    sys.exit(main())
