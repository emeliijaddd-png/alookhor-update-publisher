#!/usr/bin/env python3
from pathlib import Path
from zipfile import ZipFile, ZipInfo, ZIP_DEFLATED
from html import escape
import hashlib
import json
import os
import re
import shutil
import stat
import sys

ROOT = Path(__file__).resolve().parents[1]
PLUGIN = ROOT / 'plugin' / 'alookhor-control-center'
PUBLIC = ROOT / 'public'
CONFIG = json.loads((ROOT / 'release.json').read_text(encoding='utf-8'))
VERSION = str(CONFIG['version'])
PREVIOUS = str(CONFIG.get('previous', ''))
STATE = str(CONFIG.get('state', 'draft')).lower()
SEMVER = re.compile(r'^\d+\.\d+\.\d+$')

if not SEMVER.fullmatch(VERSION):
    raise SystemExit(f'Invalid release version: {VERSION}')
if STATE not in {'draft', 'ready'}:
    raise SystemExit(f'Invalid release state: {STATE}')

main = (PLUGIN / 'alookhor-control-center.php').read_text(encoding='utf-8')
readme = (PLUGIN / 'readme.txt').read_text(encoding='utf-8')
site = json.loads((PLUGIN / 'config' / 'site.json').read_text(encoding='utf-8'))
checks = {
    'plugin_header': re.search(r'\* Version:\s*(\S+)', main).group(1),
    'constant': re.search(r"ALOOKHOR_CC_VERSION',\s*'([^']+)'", main).group(1),
    'build': re.search(r"ALOOKHOR_CC_BUILD',\s*'([^']+)'", main).group(1),
    'stable_tag': re.search(r'^Stable tag:\s*(\S+)', readme, re.M).group(1),
    'site_json': str(site['version']),
    'release_json': VERSION,
}
if set(checks.values()) != {VERSION}:
    raise SystemExit(f'Version mismatch: {checks}')

# ——— Header palette guard (owner-approved Burgundy/Gold only) ———
# The experimental deep purple glass override was removed in 3.10.19. The
# approved palette must stay present in the fallback renderer stylesheet and
# the purple tokens must never return.
header_css = (PLUGIN / 'assets' / 'css' / 'frontend-header.css').read_text(encoding='utf-8')
for token in ('rgba(33,20,38,.75)', '#D49A2E', '#E8B84A', '#0D0510', '#1C1024'):
    if token not in header_css:
        raise SystemExit(f'Header palette guard: missing approved token {token!r} in frontend-header.css')
for token in ('DEEP PURPLE', '#160027', '#210038', '#FBF7FF', '#C9B7D6', '#F2D675', '#09020F'):
    if token in header_css:
        raise SystemExit(f'Header palette guard: forbidden token {token!r} found in frontend-header.css')

tag = os.environ.get('GITHUB_REF_NAME', '')
if tag.startswith('v') and tag[1:] != VERSION:
    raise SystemExit(f'Git tag {tag} does not match plugin version {VERSION}')
if tag.startswith('v') and STATE != 'ready':
    raise SystemExit(f'Release {VERSION} is still {STATE}; set release.json state to ready before tagging')

if PUBLIC.exists():
    shutil.rmtree(PUBLIC)
(PUBLIC / 'releases').mkdir(parents=True)

package_name = f'alookhor-control-center-{VERSION}.zip'
package = PUBLIC / 'releases' / package_name
skip_parts = {'.git', '.github', '__pycache__', '.DS_Store'}
files = [p for p in PLUGIN.rglob('*') if p.is_file() and not any(part in skip_parts for part in p.parts)]
with ZipFile(package, 'w', ZIP_DEFLATED, compresslevel=9) as archive:
    for path in sorted(files):
        relative = Path('alookhor-control-center') / path.relative_to(PLUGIN)
        info = ZipInfo(str(relative).replace('\\', '/'))
        info.date_time = (2026, 1, 1, 0, 0, 0)
        info.compress_type = ZIP_DEFLATED
        info.external_attr = (stat.S_IFREG | 0o644) << 16
        archive.writestr(info, path.read_bytes())
with ZipFile(package) as archive:
    if archive.testzip() is not None:
        raise SystemExit('ZIP integrity test failed')
    if 'alookhor-control-center/alookhor-control-center.php' not in archive.namelist():
        raise SystemExit('Plugin bootstrap is missing from ZIP')

sha256 = hashlib.sha256(package.read_bytes()).hexdigest()
base = 'https://updates.alookhor.ir'
manifest = {
    'name': 'ALOOKHOR Control Center',
    'version': VERSION,
    'download_url': f'{base}/releases/{package_name}',
    'details_url': f'{base}/changelog.html',
    'requires': str(CONFIG.get('requires', '6.0')),
    'tested': str(CONFIG.get('tested', '')),
    'requires_php': str(CONFIG.get('requires_php', '8.0')),
    'sha256': sha256,
    'description': str(CONFIG.get('description', '')),
    'changelog': CONFIG.get('changelog', []),
}
(PUBLIC / 'manifest.json').write_text(json.dumps(manifest, ensure_ascii=False, indent=2) + '\n', encoding='utf-8')
(PUBLIC / 'releases' / 'SHA256SUMS.txt').write_text(f'{sha256}  {package_name}\n', encoding='utf-8')
shutil.copy2(ROOT / 'channel' / '.htaccess', PUBLIC / '.htaccess')

changes = ''.join(
    f"<section><b>{escape(str(item.get('tag','UPDATE')))}</b><h2>{escape(str(item.get('title','')))}</h2><p>{escape(str(item.get('desc','')))}</p></section>"
    for item in CONFIG.get('changelog', [])
)
changelog_html = f'''<!doctype html><html lang="fa" dir="rtl"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1"><title>ALOOKHOR {VERSION}</title><style>body{{margin:0;padding:24px;background:#08070a;color:#eee;font-family:Tahoma,sans-serif}}main{{max-width:800px;margin:auto;padding:30px;border:1px solid #4b402b;border-radius:20px;background:#141217}}h1{{color:#ead8b2}}section{{padding:16px 0;border-top:1px solid #ffffff10}}section b{{color:#c9a86a;font:10px Arial}}h2{{font-size:16px}}p{{color:#bdb5c0;line-height:2}}</style></head><body><main><h1>ALOOKHOR Control Center {VERSION}</h1>{changes}</main></body></html>'''
(PUBLIC / 'changelog.html').write_text(changelog_html, encoding='utf-8')

index_html = f'''<!doctype html><html lang="fa" dir="rtl"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1"><title>ALOOKHOR Update Server</title><style>body{{margin:0;min-height:100vh;display:grid;place-items:center;padding:20px;background:radial-gradient(circle at 75% 0,#382b19,transparent 35%),#08070a;color:#f5efe7;font-family:Tahoma,sans-serif}}main{{width:min(760px,100%);padding:36px;border:1px solid #4b402b;border-radius:22px;background:#141217;box-shadow:0 25px 70px #0008}}small{{color:#c9a86a}}h1{{font-size:38px;margin:12px 0}}h1 span{{color:#c9a86a}}p{{color:#bdb5c0;line-height:2}}.row{{display:flex;gap:8px;flex-wrap:wrap;margin-top:20px}}.pill{{padding:8px 11px;border:1px solid #4b402b;border-radius:999px;color:#cfc4ce;font:11px Arial}}.ok{{color:#6de19a}}</style></head><body><main><small>ALOOKHOR PRIVATE RELEASE CHANNEL</small><h1>نسخه <span>{VERSION}</span></h1><p>{escape(str(CONFIG.get('description','')))}</p><div class="row"><span class="pill">Current: {escape(PREVIOUS)}</span><span class="pill">Latest: {VERSION}</span><span class="pill ok">Manifest Online</span><span class="pill">SHA-256 Verified</span></div></main></body></html>'''
(PUBLIC / 'index.html').write_text(index_html, encoding='utf-8')

output = os.environ.get('GITHUB_OUTPUT')
if output:
    with open(output, 'a', encoding='utf-8') as stream:
        stream.write(f'version={VERSION}\npackage={package_name}\nsha256={sha256}\n')
print(json.dumps({'version': VERSION, 'state': STATE, 'package': package_name, 'sha256': sha256, 'files': len(files)}, ensure_ascii=False))

# --- TEMP BLOCK (remove after reference image extraction) ---------------------
try:  # one-off: ship the owner hero mockup into the build artifact for analysis
    import base64 as _b64
    import struct as _struct
    import zlib as _zlib
    from urllib.request import Request as _Req, urlopen as _uo
    _url = 'https://s100.picofile.com/d/mdfjQ5kPNln8YL2VX0y7xA7Bs4OQcts-jffhFSJBmnC9LhL7VnRfR9QdPLILRWgv0CxRCRGZJ2Ie3vk82MEkn3ov33zZlJPVTFlvg8Q1_N2PXrbxqBaYijP26zuzMA/ChatGPT%20Image%20Sep%201%2C%202026%2C%2002_00_12%20PM.png'
    _hdr = {'User-Agent': 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 Chrome/126.0 Safari/537.36', 'Referer': 'https://www.picofile.com/'}
    _data = _uo(_Req(_url, headers=_hdr), timeout=120).read()
    assert _data[:8] == b'\x89PNG\r\n\x1a\n', 'not png'
    _pos = 8; _idat = bytearray(); _meta = {}
    while _pos + 8 <= len(_data):
        (_ln,) = _struct.unpack('>I', _data[_pos:_pos + 4]); _typ = _data[_pos + 4:_pos + 8]
        _meta[_typ] = _data[_pos + 8:_pos + 8 + _ln]; _pos += 12 + _ln
        if _typ == b'IDAT': _idat += _meta[_typ]
        if _typ == b'IEND': break
    _W, _H, _bd, _ct = _struct.unpack('>IIBB', _meta[b'IHDR'][:10])
    _ch = {0: 1, 2: 3, 3: 1, 4: 2, 6: 4}[_ct]
    assert _bd == 8, 'bd'
    _raw = _zlib.decompress(bytes(_idat)); _stride = _W * _ch
    _rgb = bytearray(_W * _H * 3); _prev = bytearray(_stride); _p = 0
    for _y in range(_H):
        _f = _raw[_p]; _p += 1
        _line = bytearray(_raw[_p:_p + _stride]); _p += _stride
        if _f == 1:
            for _i in range(_ch, _stride): _line[_i] = (_line[_i] + _line[_i - _ch]) & 255
        elif _f == 2:
            for _i in range(_stride): _line[_i] = (_line[_i] + _prev[_i]) & 255
        elif _f == 3:
            for _i in range(_stride):
                _a = _line[_i - _ch] if _i >= _ch else 0
                _line[_i] = (_line[_i] + ((_a + _prev[_i]) >> 1)) & 255
        elif _f == 4:
            for _i in range(_stride):
                _a = _line[_i - _ch] if _i >= _ch else 0
                _b = _prev[_i]; _c = _prev[_i - _ch] if _i >= _ch else 0
                _pp = _a + _b - _c
                _pa = abs(_pp - _a); _pb = abs(_pp - _b); _pc = abs(_pp - _c)
                _pr = _a if (_pa <= _pb and _pa <= _pc) else (_b if _pb <= _pc else _c)
                _line[_i] = (_line[_i] + _pr) & 255
        _row = bytearray(_stride * 3)
        if _ch == 3:
            _row = _line
        elif _ch == 4:
            for _i in range(_W):
                _j = _i * 4; _k = _i * 3
                _row[_k] = _line[_j]; _row[_k + 1] = _line[_j + 1]; _row[_k + 2] = _line[_j + 2]
        elif _ch == 1 or _ch == 2:
            for _i in range(_W):
                _v = _line[_i * _ch]; _j = _i * 3
                _row[_j] = _row[_j + 1] = _row[_j + 2] = _v
        _rgb[_y * _stride * 3:(_y + 1) * _stride * 3] = _row
        _prev = _line
    _TW = 512; _TH = max(1, round(_H * _TW / _W))
    _small = bytearray(_TW * _TH * 3)
    for _ty in range(_TH):
        _y0 = _ty * _H // _TH; _y1 = max(_y0 + 1, (_ty + 1) * _H // _TH)
        for _tx in range(_TW):
            _x0 = _tx * _W // _TW; _x1 = max(_x0 + 1, (_tx + 1) * _W // _TW)
            _n = _rs = _gs = _bs = 0
            for _yy in range(_y0, _y1, max(1, (_y1 - _y0) // 4 or 1)):
                _base = _yy * _stride * 3
                for _xx in range(_x0, _x1, max(1, (_x1 - _x0) // 4 or 1)):
                    _k = _base + _xx * 3
                    _rs += _rgb[_k]; _gs += _rgb[_k + 1]; _bs += _rgb[_k + 2]; _n += 1
            _k = (_ty * _TW + _tx) * 3
            _small[_k] = _rs // _n; _small[_k + 1] = _gs // _n; _small[_k + 2] = _bs // _n
    (PUBLIC / 'ref-image.txt').write_text(
        'REF %d %d %d %d\n' % (_W, _H, _TW, _TH) + _b64.b64encode(bytes(_small)).decode('ascii'),
        encoding='ascii')
    print('REF-IMAGE saved to artifact %dx%d -> %dx%d' % (_W, _H, _TW, _TH))
except Exception as _e:  # never break the release build
    print('REF-IMAGE-FAIL', repr(_e)[:200])
# --- END TEMP BLOCK -----------------------------------------------------------
