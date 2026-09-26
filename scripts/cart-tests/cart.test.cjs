const {test} = require('node:test');
const assert = require('node:assert/strict');
const fs = require('node:fs');
const path = require('node:path');
const {JSDOM, VirtualConsole} = require('jsdom');

const source = fs.readFileSync(path.join(__dirname, '../../plugin/alookhor-control-center/assets/js/frontend-cart.js'), 'utf8');
const endpoint = '/wp-json/alookhor-cart/v4/';
const option = {variation_id: 150, label: 'وزن: ۵۰۰ گرم', price: 1635000, attributes: {'attribute_pa_weight': '500g'}};
const variable = {id: 148, type: 'variable', name: 'آلو متغیر', price: 1635000, permalink: '/product/plum/', image: '/plum.jpg', options: [option]};
const item = (id, qty = 1, variant = 0) => ({
  key: 'key' + id, id: variant || id, variation_id: variant, name: 'محصول ' + id,
  price: 1000, line_total: 1000 * qty, quantity: qty, permalink: '/product/' + id,
  image: '/img.jpg', variation: variant ? [{value: '۵۰۰ گرم'}] : []
});
const payload = (items) => ({items, count: items.reduce((n, i) => n + i.quantity, 0), lines: items.length,
  totals: {subtotal: items.reduce((n, i) => n + i.line_total, 0), discount_total: 0, shipping_total: 0,
    total: items.reduce((n, i) => n + i.line_total, 0)}});
const tick = (ms = 20) => new Promise(resolve => setTimeout(resolve, ms));

async function mount(handler, initial = payload([]), suggestions = '', build = '3.10.412', beforeEval = null) {
  const html = '<!doctype html><html><body><section id="alookhor-cart" data-ac-build="'+build+'">'
    + '<div class="cart-error" hidden></div><div class="cart-items"></div><span class="cart-items-count"></span>'
    + '<a class="ac-checkout" href="/checkout/">checkout</a><span class="ak-cart-badge">0</span>'
    + '<div class="sr-sub"><span class="value"></span></div><div class="sr-disc"><span class="value"></span></div>'
    + '<div class="sr-ship"><span class="value"></span></div><div class="sr-total"><span class="value"></span></div>'
    + '<div class="ac-coupon"><input><button>coupon</button></div><div class="suggested-grid">' + suggestions + '</div>'
    + '</section><script id="alookhor-cart-initial" type="application/json">' + JSON.stringify(initial) + '</script></body></html>';
  const dom = new JSDOM(html, {url:'https://alookhor.ir/cart/',runScripts:'outside-only',virtualConsole:new VirtualConsole()});
  await new Promise(resolve => dom.window.addEventListener('load', resolve, {once:true}));
  const {window} = dom, calls = [];
  window.ALOOKHOR_CART_CONFIG = {cartApi:'https://alookhor.ir' + endpoint, nonce:'cart-nonce', shopUrl:'/shop/'};
  window.fetch = async (url, options) => {
    const parsed = new URL(url, window.location.href);
    calls.push({parsed, options});
    const result = await handler(parsed, options, calls.length);
    return {ok:result.status === undefined || result.status < 400, status:result.status || 200,
      headers:{get:()=>null}, text:async()=>JSON.stringify(result.body === undefined ? result : result.body)};
  };
  if(beforeEval)beforeEval(window);
  window.eval(source);
  await tick();
  return {window, document:window.document, calls, close:()=>dom.window.close()};
}
const pathIs = (call, name) => call.parsed.pathname === endpoint + name;

// These tests use the real browser client, a DOM, and fake HTTP responses. They never call production.
test('SSR three lines/five units stay visible while delayed empty cart GET is inconsistent', async () => {
  const original = payload([item(1, 1), item(2, 1), item(3, 3)]);
  const ctx = await mount(async url => pathIs({parsed:url}, 'cart') ? payload([]) : [], original);
  try {
    await tick();
    assert.equal(ctx.document.querySelectorAll('.cart-row').length, 3);
    assert.match(ctx.document.querySelector('.cart-items-count').textContent, /۳ نوع، ۵ عدد/);
    assert.equal(ctx.document.querySelector('.ak-cart-badge').textContent, '۵');
    assert.equal(ctx.calls.filter(c=>pathIs(c, 'cart')).length, 2, 'must retry once with no-store');
    assert.equal(ctx.document.querySelector('.ac-checkout').getAttribute('aria-disabled'), 'true');
    assert.match(ctx.document.querySelector('.cart-error').textContent, /نشست سبد خرید/);
    assert.ok(ctx.calls.every(c=>!c.parsed.pathname.includes('v4cart')));
    assert.ok(ctx.calls.every(c=>c.options.cache === 'no-store' && c.options.credentials === 'include'));
  } finally {ctx.close();}
});

test('a partially stale GET with only two of three SSR products cannot silently hide the third', async () => {
  const original=payload([item(1,1),item(2,1),item(3,3)]);
  const partial=payload(original.items.slice(0,2));
  const ctx=await mount(async url=>pathIs({parsed:url},'cart')?partial:[],original);
  try {
    await tick();
    assert.equal(ctx.calls.filter(c=>pathIs(c,'cart')).length,2);
    assert.equal(ctx.document.querySelectorAll('.cart-row').length,3);
    assert.equal(ctx.document.querySelector('.ak-cart-badge').textContent,'۵');
    assert.equal(ctx.document.querySelector('.ac-checkout').getAttribute('aria-disabled'),'true');
    assert.match(ctx.document.querySelector('.cart-error').textContent,/نشست سبد خرید/);
  } finally {ctx.close();}
});

test('a transient stale GET recovers all SSR products on the retry', async () => {
  const original=payload([item(1,1),item(2,1),item(3,3)]);
  let cartReads=0;
  const ctx=await mount(async url=>pathIs({parsed:url},'cart')
    ? (++cartReads===1?payload(original.items.slice(0,2)):original) : [],original);
  try {
    await tick();
    assert.equal(cartReads,2);
    assert.equal(ctx.document.querySelectorAll('.cart-row').length,3);
    assert.equal(ctx.document.querySelector('.ac-checkout').getAttribute('aria-disabled'),'false');
    assert.equal(ctx.document.querySelector('.cart-error').textContent,'');
  } finally {ctx.close();}
});

test('stale cart HTML cannot hydrate after one attempted build repair', async () => {
  const ctx=await mount(async()=>{throw new Error('No request should be made with stale markup');},
    payload([item(1,1)]),'','3.10.405',win=>win.sessionStorage.setItem('ac_heal_3.10.412','1'));
  try {
    assert.equal(ctx.calls.length,0);
    assert.equal(ctx.document.querySelector('.ac-checkout').getAttribute('aria-disabled'),'true');
    assert.match(ctx.document.querySelector('.cart-error').textContent,/کش قدیمی/);
  } finally {ctx.close();}
});

test('session cart with three distinct items loads; count is units, not lines', async () => {
  const three = payload([item(1, 1), item(2, 1), item(3, 4)]);
  const ctx = await mount(async url => pathIs({parsed:url,}, 'cart') ? three : []);
  try {
    assert.equal(ctx.document.querySelectorAll('.cart-row').length, 3);
    assert.match(ctx.document.querySelector('.cart-items-count').textContent, /۳ نوع، ۶ عدد/);
    assert.equal(ctx.document.querySelector('.ak-cart-badge').textContent, '۶');
    assert.equal(ctx.document.querySelector('.ac-checkout').getAttribute('aria-disabled'), 'false');
  } finally {ctx.close();}
});

test('recommended variable product requires an explicit option; valid add returns stable cart', async () => {
  const cart = payload([item(1, 1), item(2, 1), item(3, 1)]);
  let getCount=0, addBody;
  const ctx = await mount(async (url, opts) => {
    if (url.pathname === endpoint + 'cart') {getCount++;return cart;}
    if (url.pathname === endpoint + 'recommendations') return [variable];
    if (url.pathname === endpoint + 'cart/add') {
      addBody = JSON.parse(opts.body);cart.items.push(item(148,1,150));cart.count=4;cart.lines=4;return cart;
    }
    throw new Error('Unexpected cart URL: ' + url.pathname);
  });
  try {
    const button = ctx.document.querySelector('button[data-add-id="148"]');
    assert.ok(button, 'option selector and add button rendered');
    button.click();await tick();
    assert.equal(ctx.calls.filter(c=>c.options.method === 'POST').length, 0, 'do not silently choose a weight');
    const select = ctx.document.querySelector('.sg-variant');
    select.value = '150';select.dispatchEvent(new ctx.window.Event('change', {bubbles:true}));
    assert.match(ctx.document.querySelector('.sg-price').textContent,/۱/);
    button.click();await tick();
    assert.deepEqual(addBody, {product_id:148,quantity:1,variation_id:150,variation:{'attribute_pa_weight':'500g'}});
    assert.equal(ctx.document.querySelectorAll('.cart-row').length, 4, 'fourth line is visible');
    assert.equal(ctx.document.querySelector('.ak-cart-badge').textContent, '۴');
    assert.equal(getCount, 1, 'do not re-read cached empty JSON after a successful POST');
    assert.ok(ctx.calls.every(c=>!('X-WP-Nonce' in c.options.headers)), 'custom nonce must not become a WP cookie nonce');
    assert.equal(ctx.calls.find(c=>pathIs(c,'cart/add')).options.headers['X-ALOOKHOR-CART-NONCE'],'cart-nonce');
  } finally {ctx.close();}
});

test('SSR suggestions stay clickable if their GET fails, and never POST a parent without a variation', async () => {
  const card = '<article class="sg-card"><label><select class="sg-variant"><option value="">انتخاب</option>'
    +'<option value="150" data-attributes="{&quot;attribute_pa_weight&quot;:&quot;500g&quot;}">۵۰۰ گرم</option></select></label>'
    +'<button type="button" data-add-id="148">افزودن</button></article>';
  let added = false;
  const ctx = await mount(async (url, opts) => {
    if (url.pathname === endpoint + 'cart') return payload([]);
    if (url.pathname === endpoint + 'recommendations') return {status:404,body:{message:'offline'}};
    if (url.pathname === endpoint + 'cart/add') {added=true;assert.equal(JSON.parse(opts.body).variation_id,150);return payload([item(148,1,150)]);}
    throw new Error(url.pathname);
  }, payload([]), card);
  try {
    const button=ctx.document.querySelector('[data-add-id]');
    button.click();await tick();assert.equal(added,false);
    ctx.document.querySelector('.sg-variant').value='150';button.click();await tick();
    assert.equal(added,true);
    assert.equal(ctx.document.querySelectorAll('.cart-row').length,1);
  } finally {ctx.close();}
});

test('quantity, remove, and coupon all address registered routes; minus at one removes', async () => {
  let cart = payload([item(11,1),item(22,2),item(33,1)]);
  const ctx = await mount(async (url,opts) => {
    const route=url.pathname.removeprefix ? url.pathname.removeprefix(endpoint) : url.pathname.slice(endpoint.length);
    if(route==='cart')return cart;
    if(route==='recommendations')return [];
    if(route==='cart/update'){
      const body=JSON.parse(opts.body), i=cart.items.find(x=>x.key===body.key);
      if(body.quantity===0)cart.items=cart.items.filter(x=>x.key!==body.key);
      else i.quantity=body.quantity;
    } else if(route==='cart/remove')cart.items=cart.items.filter(x=>x.key!==JSON.parse(opts.body).key);
    else if(route!=='cart/coupon')throw new Error('Unexpected: '+route);
    cart=payload(cart.items);return cart;
  });
  try {
    assert.equal(ctx.document.querySelectorAll('.cart-row').length,3);
    ctx.document.querySelector('[data-key="key11"][data-cart-qty="+"]').click();await tick();
    assert.equal(ctx.document.querySelector('.ak-cart-badge').textContent, '۵');
    ctx.document.querySelector('[data-key="key33"][data-cart-qty="-"]').click();await tick();
    assert.equal(ctx.document.querySelectorAll('.cart-row').length,2);
    ctx.document.querySelector('[data-cart-remove="key22"]').click();await tick();
    assert.equal(ctx.document.querySelectorAll('.cart-row').length,1);
    ctx.document.querySelector('.ac-coupon input').value='SAVE10';ctx.document.querySelector('.ac-coupon button').click();await tick();
    assert.deepEqual(ctx.calls.filter(c=>c.options.method==='POST').map(c=>c.parsed.pathname),[
      endpoint+'cart/update',endpoint+'cart/update',endpoint+'cart/remove',endpoint+'cart/coupon'
    ]);
  } finally {ctx.close();}
});

test('slow empty GET cannot erase the result of a successful mutation', async () => {
  let replyGet;
  const ctx = await mount(async url => {
    if (url.pathname === endpoint + 'cart')return await new Promise(resolve=>{replyGet=resolve;});
    if (url.pathname === endpoint + 'recommendations')return [variable];
    if (url.pathname === endpoint + 'cart/add')return payload([item(10,1),item(20,1),item(30,1),item(148,1,150)]);
    throw new Error(url.pathname);
  }, payload([item(10,1),item(20,1),item(30,1)]));
  try {
    const select=ctx.document.querySelector('.sg-variant');select.value='150';
    ctx.document.querySelector('button[data-add-id="148"]').click();await tick();
    assert.equal(ctx.document.querySelectorAll('.cart-row').length,4);
    replyGet(payload([]));await tick();
    assert.equal(ctx.document.querySelectorAll('.cart-row').length,4);
    assert.equal(ctx.document.querySelector('.ac-checkout').getAttribute('aria-disabled'),'false');
  } finally {ctx.close();}
});

test('slow recommendations refresh preserves a variation chosen in SSR', async () => {
  let finish;
  const card = '<article class="sg-card"><select class="sg-variant"><option value="">انتخاب</option>'
    +'<option value="150" data-attributes="{&quot;attribute_pa_weight&quot;:&quot;500g&quot;}">۵۰۰ گرم</option></select>'
    +'<button type="button" data-add-id="148">افزودن</button></article>';
  const ctx = await mount(async url => url.pathname === endpoint+'recommendations'
    ? await new Promise(resolve=>{finish=resolve;}) : payload([]), payload([]), card);
  try {
    const selected=ctx.document.querySelector('.sg-variant');selected.value='150';
    finish([variable]);await tick();
    assert.equal(ctx.document.querySelector('.sg-variant'),selected,'user selection must not be replaced');
    assert.equal(selected.value,'150');
  } finally {ctx.close();}
});

test('REST recommendation cards escape untrusted names and do not expose add for variable with no options', async () => {
  const dangerous={...variable,name:'<img src=x onerror=alert(1)>', options:[],permalink:'/product/plum/'};
  const ctx = await mount(async url => url.pathname === endpoint+'recommendations' ? [dangerous] : payload([]));
  try {
    assert.equal(ctx.document.querySelectorAll('.sg-card img').length,1);
    assert.equal(ctx.document.querySelectorAll('.sg-add[data-add-id]').length,0);
    assert.equal(ctx.document.querySelector('.sg-card .sg-add').getAttribute('href'),'/product/plum/');
    assert.match(ctx.document.querySelector('.sg-name').textContent,/onerror/);
  } finally {ctx.close();}
});
