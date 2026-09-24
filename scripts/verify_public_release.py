#!/usr/bin/env python3
"""Read back a freshly uploaded release over public HTTPS, before advancing it."""

import argparse
import hashlib
import json
import os
import ssl
import sys
import time
from pathlib import Path
from urllib.parse import urlsplit
from urllib.request import Request, urlopen

ROOT = Path(__file__).resolve().parents[1]
HOST = 'updates.alookhor.ir'


def verified_get(url, max_bytes=75 * 1024 * 1024):
    parsed = urlsplit(url)
    if parsed.scheme != 'https' or parsed.hostname != HOST or parsed.port is not None or parsed.username or parsed.password:
        raise ValueError('Unexpected public update server')
    req = Request(url, headers={'Cache-Control': 'no-cache', 'User-Agent': 'ALOOKHOR-Publisher-Readback/1.0'}, method='GET')
    with urlopen(req, timeout=45, context=ssl.create_default_context()) as response:
        if response.status != 200 or urlsplit(response.geturl()).hostname != HOST:
            raise ValueError('Public release URL did not return HTTP 200 from the update server')
        chunks = []
        total = 0
        while True:
            chunk = response.read(1024 * 1024)
            if not chunk:
                break
            total += len(chunk)
            if total > max_bytes:
                raise ValueError('Public response exceeds size limit')
            chunks.append(chunk)
        return b''.join(chunks)


def verify(mode, manifest):
    if mode == 'package':
        body = verified_get(manifest['download_url'])
        if hashlib.sha256(body).hexdigest() != manifest['sha256']:
            raise ValueError('Public package SHA-256 does not match the built package')
        return 'Public package SHA-256 verified before manifest promotion'
    if mode == 'manifest':
        # Cache-busting makes a stale manifest visible as a mismatch.
        url = f'https://{HOST}/manifest.json?github_run={os.environ.get("GITHUB_RUN_ID", "local")}'
        published = json.loads(verified_get(url, 256 * 1024))
        for key in ('version', 'sha256', 'download_url'):
            if published.get(key) != manifest.get(key):
                raise ValueError('Public manifest differs from the built release: ' + key)
        return 'Public manifest version and SHA-256 verified after atomic rename'
    raise ValueError('Unknown verification phase')


def main():
    parser = argparse.ArgumentParser()
    parser.add_argument('phase', choices=['package', 'manifest'])
    args = parser.parse_args()
    expected = json.loads((ROOT / 'public/manifest.json').read_text(encoding='utf-8'))
    for attempt in range(3):
        try:
            print(verify(args.phase, expected))
            return 0
        except (ValueError, OSError, json.JSONDecodeError) as exc:
            if attempt == 2:
                print('PUBLIC VERIFICATION FAILED:', type(exc).__name__, str(exc)[:160])
                return 1
            time.sleep(2 * (attempt + 1))
    return 1


if __name__ == '__main__':
    sys.exit(main())
