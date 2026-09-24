#!/usr/bin/env python3
"""Read-only explicit FTPS audit of the existing ALOOKHOR publisher root.

Uses the already configured GitHub production secrets. It NEVER writes, moves,
deletes or prints files, host paths, login names or secret values. Only a small
allowlisted metadata summary is exposed as a GitHub Actions annotation.
"""

from ftplib import FTP_TLS, all_errors, error_perm
import json
import os
import re
import ssl
import sys
from pathlib import PurePosixPath
from urllib.parse import urlsplit

MAX_MANIFEST = 256 * 1024
ZIP_NAME = re.compile(r'^alookhor-control-center-(\d+\.\d+\.\d+)\.zip$')
SEMVER = re.compile(r'^\d+\.\d+\.\d+$')
SHA256 = re.compile(r'^[a-f0-9]{64}$')
REQUIRED = ('FTP_SERVER', 'FTP_PORT', 'FTP_USERNAME', 'FTP_PASSWORD')
COMMON_ROOT_DIRS = {'public_html', 'httpdocs', 'htdocs', 'www', 'public', 'updates',
                    'domains', 'subdomains', 'updates.alookhor.ir'}
# Fixed, bounded read-only paths. Never enumerate or log arbitrary server paths.
MANIFEST_DIRS = (
    'public_html', 'httpdocs', 'htdocs', 'www', 'public', 'updates',
    'updates.alookhor.ir', 'public_html/updates', 'public_html/updates.alookhor.ir',
    'domains/updates.alookhor.ir/public_html',
)


def ftp_error_code(exc):
    match = re.match(r'^(\d{3})\b', str(exc))
    return int(match.group(1)) if match else None


def inspect_manifest(ftp, path):
    """Read only a bounded manifest and emit allowlisted metadata, never file bytes."""
    content = bytearray()

    def receive(chunk):
        if len(content) + len(chunk) > MAX_MANIFEST:
            raise ValueError('Manifest exceeds size limit')
        content.extend(chunk)

    try:
        ftp.retrbinary('RETR ' + path, receive)
        data = json.loads(content)
        if not isinstance(data, dict):
            raise ValueError('Manifest is not a JSON object')
        version = data.get('version')
        download_url = data.get('download_url')
        package_host = urlsplit(download_url).hostname if isinstance(download_url, str) else None
        return {
            'present': True,
            'version': version if isinstance(version, str) and SEMVER.fullmatch(version) else 'invalid',
            'download_host': package_host if package_host in {'updates.alookhor.ir', 'raw.githubusercontent.com', 'cdn.jsdelivr.net'} else 'other',
            'sha256_well_formed': isinstance(data.get('sha256'), str) and bool(SHA256.fullmatch(data['sha256'].lower())),
        }
    except error_perm as exc:
        return {'present': False, 'ftp_code': ftp_error_code(exc)}
    except (UnicodeError, ValueError):
        return {'present': True, 'valid_json': False}


def inspect_root(ftp):
    report = {'ftp_connected': True, 'tls_certificate_verified': True}
    listed = set()
    try:
        names = ftp.nlst()
        listed = {PurePosixPath(name.rstrip('/')).name for name in names}
        report['root_listing_available'] = True
        report['root_entry_count'] = len(names)
        report['known_root_entries'] = sorted(listed & COMMON_ROOT_DIRS)
        report['manifest_listed'] = 'manifest.json' in listed
        report['releases_listed'] = 'releases' in listed
    except error_perm as exc:
        report['root_listing_available'] = False
        report['root_listing_ftp_code'] = ftp_error_code(exc)

    report['manifest'] = inspect_manifest(ftp, 'manifest.json')
    if report['root_listing_available'] and not report['manifest']['present']:
        # Search common web roots only when their first segment was actually
        # listed. Do not recursively traverse arbitrary directories or filenames.
        report['known_subdirectory_manifest'] = None
        for directory in MANIFEST_DIRS:
            if directory.split('/')[0] not in listed:
                continue
            found = inspect_manifest(ftp, directory + '/manifest.json')
            if found['present']:
                report['known_subdirectory_manifest'] = {'directory': directory, **found}
                break

    try:
        names = ftp.nlst('releases')
        versions = set()
        for name in names:
            match = ZIP_NAME.fullmatch(PurePosixPath(name).name)
            if match:
                versions.add(match.group(1))
        report['release_listing_available'] = True
        report['release_versions'] = sorted(versions, key=lambda v: tuple(map(int, v.split('.'))))[-20:]
    except error_perm as exc:
        report['release_listing_available'] = False
        report['release_listing_ftp_code'] = ftp_error_code(exc)
    return report


def run_probe(env=None, ftp_class=FTP_TLS):
    env = os.environ if env is None else env
    missing = [name for name in REQUIRED if not env.get(name)]
    if missing:
        return {'scope': 'read_only_ftps', 'state': 'not_configured', 'missing_secret_names': missing}
    server = env['FTP_SERVER'].strip()
    port = env['FTP_PORT'].strip()
    if not re.fullmatch(r'[a-zA-Z0-9.-]{1,253}', server) or not port.isdigit() or not 1 <= int(port) <= 65535:
        return {'scope': 'read_only_ftps', 'state': 'invalid_server_configuration'}
    ftp = ftp_class(context=ssl.create_default_context(), timeout=25)
    try:
        ftp.connect(server, int(port))
        ftp.login(env['FTP_USERNAME'].strip(), env['FTP_PASSWORD'])
        ftp.prot_p()  # TLS protects the data channel as well as the login.
        return {'scope': 'read_only_ftps', **inspect_root(ftp)}
    finally:
        try:
            ftp.quit()
        except all_errors:
            pass


def main():
    try:
        report = run_probe()
    except all_errors as exc:
        report = {'scope': 'read_only_ftps', 'ftp_connected': False,
                  'error_type': type(exc).__name__, 'ftp_code': ftp_error_code(exc)}
    except ValueError:
        report = {'scope': 'read_only_ftps', 'ftp_connected': False, 'error_type': 'InvalidResponse'}
    print(json.dumps(report, ensure_ascii=False, sort_keys=True))
    if os.environ.get('GITHUB_ACTIONS') == 'true':
        print('::notice title=ALOOKHOR read-only FTPS diagnosis::' + json.dumps(report, separators=(',', ':')))
    if os.environ.get('GITHUB_STEP_SUMMARY'):
        with open(os.environ['GITHUB_STEP_SUMMARY'], 'a', encoding='utf-8') as stream:
            stream.write('## Read-only FTPS root audit\n\n```json\n' + json.dumps(report, indent=2) + '\n```\n')
    return 0 if report.get('ftp_connected') else 1


if __name__ == '__main__':
    sys.exit(main())
