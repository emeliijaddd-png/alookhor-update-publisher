#!/usr/bin/env python3
"""Deterministic, network-free repository integrity checks for the publisher.

The CI build job already runs the inline managed-module contracts. This script
adds the repository-level invariants that must hold *before* a release is
published and that are cheap enough to run on every push:

  1. Version consistency across release.json, the plugin bootstrap, readme.txt
     and config/site.json (the same rule build_release.py enforces at build time).
  2. Every path listed in release.json `files` exists and is non-empty.
  3. release.json schema/state sanity (SemVer, state, changelog shape).
  4. Every required managed-module source file exists and is non-empty.
  5. The generated code registry is fresh
     (same contract as `generate_code_registry.py --check`).
  6. No secret material is tracked in the working tree (fail-closed scan).

It never reads, prints or exports credentials; the secret scan only reports file
names and rule identifiers. Exit code 0 means all checks passed.
"""
from __future__ import annotations

from hashlib import sha256
from pathlib import Path
import argparse
import json
import re
import sys

ROOT = Path(__file__).resolve().parents[1]
PLUGIN = ROOT / 'plugin' / 'alookhor-control-center'
SEMVER = re.compile(r'^\d+\.\d+\.\d+$')

REQUIRED_SOURCES = [
    'plugin/alookhor-control-center/alookhor-control-center.php',
    'plugin/alookhor-control-center/includes/footer.php',
    'plugin/alookhor-control-center/includes/hero.php',
    'plugin/alookhor-control-center/includes/site-features.php',
    'plugin/alookhor-control-center/includes/product-categories.php',
    'plugin/alookhor-control-center/includes/shortcode-header.php',
    'plugin/alookhor-control-center/includes/rest-api.php',
    'plugin/alookhor-control-center/includes/ajax.php',
    'plugin/alookhor-control-center/includes/updater.php',
    'plugin/alookhor-control-center/assets/css/frontend-header.css',
    'plugin/alookhor-control-center/assets/css/frontend-header-scroll.css',
    'plugin/alookhor-control-center/assets/js/frontend-header.js',
    'plugin/alookhor-control-center/assets/js/frontend-topbar-manager.js',
    'scripts/build_release.py',
    'scripts/generate_code_registry.py',
    'ops/wordpress-ci-bootstrap.php',
]

# Only unambiguous, high-signal shapes: a literal assignment of a long secret to
# a credential-looking key. Placeholder CI references (${{ secrets.X }}), shell
# variables and getenv() reads are explicitly allowed.
SECRET_PATTERNS = [
    ('github_pat', re.compile(r'\bgithub_pat_[A-Za-z0-9_]{20,}')),
    ('ghp_token', re.compile(r'\bgh[pousr]_[A-Za-z0-9]{20,}\b')),
    ('aws_key', re.compile(r'\bAKIA[0-9A-Z]{16}\b')),
    ('private_key_block', re.compile(r'-----BEGIN [A-Z ]*PRIVATE KEY-----')),
]

SECRET_KEY = ('ftp_password|wp_app_password|app_password|access_token|api_key|'
              'secret_key|private_key|client_secret')
LITERAL_ASSIGNMENT = re.compile(
    r'''(?ix)\b(?:''' + SECRET_KEY + r''')\b\s*[:=]\s*(["\'])(.+?)\1''')
INTERPOLATION = re.compile(r'''\$\{\{|\$\{?[A-Za-z_]\w*\}?|\{\{|<\s*MASKED|your[-_]?|example|placeholder|changeme''')

# user:password@host URL form, but only when the password is a literal —
# interpolated CI secrets (`${{ secrets.X }}`) and shell vars are legitimate.
BASIC_AUTH_URL = re.compile(r'''(?:https?|ftps?)://([^\s/:@"']{1,64}):([^\s@"']{8,})@''')

SKIP_DIRS = {'.git', 'node_modules', '__pycache__', 'public', '.pytest_cache', 'dist', 'build'}
SCAN_SUFFIXES = {'.php', '.js', '.css', '.json', '.py', '.yml', '.yaml', '.md', '.txt', '.html', '.ini', '.env'}


def relative(path: Path) -> str:
    return path.relative_to(ROOT).as_posix()


def tracked_text_files() -> list[Path]:
    files: list[Path] = []
    for path in ROOT.rglob('*'):
        if not path.is_file():
            continue
        if any(part in SKIP_DIRS for part in path.parts):
            continue
        if path.suffix.lower() not in SCAN_SUFFIXES and path.name not in {'.env', '.htaccess'}:
            continue
        files.append(path)
    return sorted(files, key=lambda p: str(p))


def check_release_config(failures: list[str]) -> tuple[str, dict]:
    config_path = ROOT / 'release.json'
    if not config_path.is_file():
        failures.append('release.json is missing')
        return '', {}
    try:
        config = json.loads(config_path.read_text(encoding='utf-8'))
    except json.JSONDecodeError as error:
        failures.append(f'release.json is not valid JSON: {error}')
        return '', {}
    version = str(config.get('version', ''))
    if not SEMVER.fullmatch(version):
        failures.append(f'release.json version is not SemVer: {version!r}')
    if str(config.get('state', '')).lower() not in {'draft', 'ready'}:
        failures.append(f"release.json state must be draft or ready: {config.get('state')!r}")
    changelog = config.get('changelog')
    if not isinstance(changelog, list) or not changelog:
        failures.append('release.json changelog must be a non-empty list')
    else:
        for index, item in enumerate(changelog):
            if not isinstance(item, dict) or not {'tag', 'title', 'desc'} <= set(item):
                failures.append(f'changelog[{index}] must contain tag, title and desc')
    if not str(config.get('description', '')).strip():
        failures.append('release.json description must be non-empty')
    return version, config


def check_version_consistency(version: str, failures: list[str]) -> None:
    main = (PLUGIN / 'alookhor-control-center.php')
    readme = (PLUGIN / 'readme.txt')
    site = (PLUGIN / 'config' / 'site.json')
    missing = [relative(path) for path in (main, readme, site) if not path.is_file()]
    if missing:
        failures.append('required version source(s) missing: ' + ', '.join(missing))
        return
    main_text = main.read_text(encoding='utf-8')
    readme_text = readme.read_text(encoding='utf-8')
    try:
        site_version = str(json.loads(site.read_text(encoding='utf-8'))['version'])
    except (json.JSONDecodeError, KeyError) as error:
        failures.append(f'config/site.json version unreadable: {error}')
        site_version = '<unreadable>'
    def first(pattern: str, text: str, flags: int = 0) -> str:
        match = re.search(pattern, text, flags)
        return match.group(1) if match else '<missing>'

    found = {
        'release_json': version,
        'plugin_header': first(r'\* Version:\s*(\S+)', main_text),
        'constant': first(r"ALOOKHOR_CC_VERSION',\s*'([^']+)'", main_text),
        'build': first(r"ALOOKHOR_CC_BUILD',\s*'([^']+)'", main_text),
        'stable_tag': first(r'^Stable tag:\s*(\S+)', readme_text, re.M),
        'site_json': site_version,
    }
    unique = set(found.values())
    if unique != {version}:
        failures.append(f'version mismatch across release sources: {found}')


def check_declared_files(config: dict, failures: list[str]) -> None:
    declared = config.get('files')
    if not isinstance(declared, list) or not declared:
        failures.append('release.json files must be a non-empty list')
        return
    for entry in declared:
        path = ROOT / str(entry)
        if not path.is_file():
            failures.append(f'release.json declares a missing file: {entry}')
        elif path.stat().st_size == 0:
            failures.append(f'release.json declares an empty file: {entry}')


def check_required_sources(failures: list[str]) -> None:
    for entry in REQUIRED_SOURCES:
        path = ROOT / entry
        if not path.is_file():
            failures.append(f'required managed source is missing: {entry}')
        elif path.stat().st_size == 0:
            failures.append(f'required managed source is empty: {entry}')


def check_registry_freshness(failures: list[str]) -> None:
    registry = ROOT / 'docs' / 'MASTER_CODE_REGISTRY.md'
    script = ROOT / 'scripts' / 'generate_code_registry.py'
    if not script.is_file():
        failures.append('scripts/generate_code_registry.py is missing')
        return
    sys.path.insert(0, str(ROOT / 'scripts'))
    try:
        import importlib
        module = importlib.import_module('generate_code_registry')
        expected = module.render()
    except Exception as error:  # pragma: no cover - surfaced as a failure
        failures.append(f'registry generator could not run: {error}')
        return
    if not registry.is_file():
        failures.append('docs/MASTER_CODE_REGISTRY.md is missing')
        return
    if registry.read_text(encoding='utf-8') != expected:
        failures.append('docs/MASTER_CODE_REGISTRY.md is stale; run '
                        'python3 scripts/generate_code_registry.py')


def check_no_secrets(failures: list[str]) -> list[str]:
    """Return sanitized findings. Secret *values* are never printed or stored."""
    hits: list[str] = []
    for path in tracked_text_files():
        try:
            text = path.read_text(encoding='utf-8')
        except (UnicodeDecodeError, OSError):
            continue
        rel = relative(path)
        for rule, pattern in SECRET_PATTERNS:
            if pattern.search(text):
                hits.append(f'{rel} [{rule}]')
        for match in LITERAL_ASSIGNMENT.finditer(text):
            value = match.group(2)
            if len(value) >= 12 and not INTERPOLATION.search(value):
                hits.append(f'{rel} [literal_secret_assignment:len={len(value)}]')
        for match in BASIC_AUTH_URL.finditer(text):
            password = match.group(2)
            if not INTERPOLATION.search(password):
                hits.append(f'{rel} [basic_auth_url:len={len(password)}]')
    if hits:
        failures.append('possible committed secret material (values not shown): ' + ', '.join(sorted(set(hits))))
    return sorted(set(hits))


def main() -> int:
    parser = argparse.ArgumentParser(description='Run deterministic publisher repository integrity checks.')
    parser.add_argument('--quiet', action='store_true', help='only print the summary line')
    args = parser.parse_args()

    failures: list[str] = []
    version, config = check_release_config(failures)
    if version:
        check_version_consistency(version, failures)
        check_declared_files(config, failures)
    check_required_sources(failures)
    check_registry_freshness(failures)
    check_no_secrets(failures)

    package_note = ''
    manifest_sha = ROOT / 'public' / 'releases' / 'SHA256SUMS.txt'
    if manifest_sha.is_file():
        package_note = f' | last built SHA-256 {manifest_sha.read_text(encoding="utf-8").split()[0]}'

    if failures:
        for failure in failures:
            print(f'FAIL  {failure}')
        print(f'\n{len(failures)} repository integrity check(s) failed (version {version or "unknown"}).')
        return 1
    if not args.quiet:
        print(f'PASS  release.json version {version} is consistent across bootstrap, readme and site.json')
        print(f'PASS  {len(config.get("files", []))} declared files and {len(REQUIRED_SOURCES)} required sources present')
        print(f'PASS  generated code registry is fresh')
        print(f'PASS  no secret patterns found in {len(tracked_text_files())} scanned text files{package_note}')
    print(f'\nRepository integrity checks passed for {version}.')
    return 0


if __name__ == '__main__':
    raise SystemExit(main())
