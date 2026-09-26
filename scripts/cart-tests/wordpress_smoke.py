#!/usr/bin/env python3
"""Guest cart smoke through real WP/Woo HTTP, isolated to localhost in CI.

This script cannot contact or change alookhor.ir. It creates no orders.
JS hydration is covered separately by cart.test.cjs; the live theme/cache and
WordPress updater still require independent validation before publication.
"""
import http.cookiejar
import json
import os
import re
import time
from pathlib import Path
from urllib.error import HTTPError, URLError
from urllib.parse import urlsplit
from urllib.request import HTTPCookieProcessor, Request, build_opener

ORIGIN = 'http://127.0.0.1:8099'
assert os.environ.get('GITHUB_ACTIONS') == 'true', 'CI runner only'
ids_path = Path(os.environ['WP_SMOKE_IDS'])
ids = json.loads(ids_path.read_text())
opener = build_opener(HTTPCookieProcessor(http.cookiejar.CookieJar()))


def request(path, method='GET', body=None, nonce=None, expected=200):
    url = ORIGIN + path
    if urlsplit(url).scheme != 'http' or urlsplit(url).netloc != '127.0.0.1:8099':
        raise AssertionError('Only the isolated localhost test site may be called')
    headers = {'Accept': 'application/json' if '/wp-json/' in path else 'text/html'}
    if method == 'POST':
        headers['Content-Type'] = 'application/json'
        headers['X-ALOOKHOR-CART-NONCE'] = nonce or ''
    req = Request(url, method=method, headers=headers,
                  data=json.dumps(body).encode() if body is not None else None)
    try:
        with opener.open(req, timeout=40) as response:
            status, payload = response.status, response.read().decode('utf-8')
    except HTTPError as err:
        status, payload = err.code, err.read().decode('utf-8', errors='replace')
    if status != expected:
        raise AssertionError(f'{method} {path} returned HTTP {status}, expected {expected}: {payload[:500]}')
    if '/wp-json/' in path:
        return json.loads(payload)
    return payload


for attempt in range(30):
    try:
        page = request('/cart/')
        break
    except (URLError, TimeoutError) as exc:
        if attempt == 29:
            raise AssertionError('Local WordPress web server did not start') from exc
        time.sleep(1)
assert 'id="alookhor-cart"' in page and 'data-ac-build="3.10.412"' in page, 'Actual cart page/renderer did not load'
config_match = re.search(r'var ALOOKHOR_CART_CONFIG = (\{[^;]+\});', page)
assert config_match, 'The cart page did not localize its nonce and REST root'
config = json.loads(config_match.group(1))
assert config['cartApi'] == ORIGIN + '/wp-json/alookhor-cart/v4/', config['cartApi']
nonce = config['nonce']
assert nonce and isinstance(nonce, str)


def api(route, method='GET', body=None, expected=200, sent_nonce=None):
    return request('/wp-json/alookhor-cart/v4/' + route, method, body,
                   nonce if sent_nonce is None else sent_nonce, expected)


def verified_cart(expected_lines, expected_units):
    cart = api('cart')
    assert len(cart['items']) == expected_lines and cart['count'] == expected_units, cart
    assert cart['lines'] == expected_lines, cart
    return cart


verified_cart(0, 0)
for n, product_id in enumerate(ids['simple'], start=1):
    result = api('cart/add', 'POST', {'product_id': product_id, 'quantity': 1})
    assert result['lines'] == n and result['count'] == n, result
    verified_cart(n, n)  # separate request, same real Woo guest cookie
print('REAL WP/WOO: three separate POSTs and GETs kept all three products')

bad_nonce = api('cart/add', 'POST', {'product_id': ids['parent'], 'quantity': 1}, expected=403, sent_nonce='forged')
assert bad_nonce['code'] == 'invalid_cart_nonce', bad_nonce
missing = api('cart/add', 'POST', {'product_id': ids['parent'], 'quantity': 1}, expected=400)
assert missing['code'] == 'variation_required', missing
verified_cart(3, 3)

recs = api('recommendations')
recommended = next((p for p in recs if p['id'] == ids['parent']), None)
assert recommended and recommended['type'] == 'variable', recs
option = next((v for v in recommended['options'] if v['variation_id'] == ids['variation']), None)
assert option and option['attributes']['attribute_weight'] == '500g', recommended
result = api('cart/add', 'POST', {'product_id': ids['parent'], 'variation_id': ids['variation'],
                                  'quantity': 2, 'variation': option['attributes']})
assert result['count'] == 5 and result['lines'] == 4, result
cart = verified_cart(4, 5)
assert any(row['variation_id'] == ids['variation'] for row in cart['items']), cart
page = request('/cart/')
initial = re.search(r'<script id="alookhor-cart-initial"[^>]*>(.*?)</script>', page, re.S)
assert initial and len(json.loads(initial.group(1))['items']) == 4, 'SSR does not match the real guest cart'
assert page.count('class="cart-row"') >= 4, 'SSR cart rows disappeared'
print('REAL WP/WOO: recommended variable option, cookie persistence and SSR kept four rows')

first = next(row for row in cart['items'] if row['id'] == ids['simple'][0])
updated = api('cart/update', 'POST', {'key': first['key'], 'quantity': 4})
assert updated['count'] == 8 and updated['lines'] == 4, updated
cart = verified_cart(4, 8)
second = next(row for row in cart['items'] if row['id'] == ids['simple'][1])
removed = api('cart/remove', 'POST', {'key': second['key']})
assert removed['count'] == 7 and removed['lines'] == 3, removed
verified_cart(3, 7)
print('REAL WP/WOO: quantity above two and removal persisted across new requests')
print('WORDPRESS/WOO GUEST CART SMOKE: GREEN (no orders, no production requests)')
