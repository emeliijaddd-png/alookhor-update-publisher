/* Real Chromium + isolated WP/Woo integration. This never visits production. */
'use strict';
const assert = require('node:assert/strict');
const fs = require('node:fs');
const {execFileSync} = require('node:child_process');
const {chromium} = require('playwright-core');

const BASE='http://127.0.0.1:8099';
assert.equal(process.env.GITHUB_ACTIONS,'true','this test is restricted to the CI runner');
const ids=JSON.parse(fs.readFileSync(process.env.WP_SMOKE_IDS,'utf8'));
let executable=process.env.CHROME_BIN;
if (!executable) {
  for(const path of ['/usr/bin/google-chrome','/usr/bin/google-chrome-stable','/usr/bin/chromium','/usr/bin/chromium-browser']) {
    if(fs.existsSync(path)){executable=path;break;}
  }
}
if(!executable){
  for(const candidate of ['google-chrome','chromium']){
    try{executable=execFileSync('which',[candidate],{encoding:'utf8'}).trim();break;}catch(_){}
  }
}
assert.ok(executable,'Chromium/Google Chrome is not installed on the isolated runner');

(async()=>{
 const browser=await chromium.launch({executablePath:executable,headless:true,args:['--no-sandbox','--disable-dev-shm-usage']});
 try{
  const context=await browser.newContext({locale:'fa-IR'});
  const page=await context.newPage();
  page.setDefaultTimeout(30000);
  // Real WooCommerce renders a session cart server-side; a busy CI runner can
  // take over 20s on full-page reloads even when every route is healthy.
  page.setDefaultNavigationTimeout(60000);
  await page.goto(BASE+'/cart/',{waitUntil:'domcontentloaded'});
  await page.locator('#alookhor-cart').waitFor();
  const api=async(route,method='GET',data)=>page.evaluate(async({route,method,data})=>{
    const root=window.ALOOKHOR_CART_CONFIG.cartApi.replace(/\/+$/,'')+'/';
    if(!root.startsWith('http://127.0.0.1:8099/'))throw Error('unsafe API root: '+root);
    const response=await fetch(root+route,{
      method,credentials:'include',cache:'no-store',
      headers:{'Content-Type':'application/json','X-ALOOKHOR-CART-NONCE':window.ALOOKHOR_CART_CONFIG.nonce},
      body:data?JSON.stringify(data):undefined,
    });
    const json=await response.json();
    if(!response.ok)throw Error('HTTP '+response.status+': '+JSON.stringify(json));
    return json;
  },{route,method,data});
  const expectRows=async(count)=>{
    await page.waitForFunction(expected=>{
      const root=document.querySelector('#alookhor-cart');
      return root?.querySelectorAll('.cart-row').length===expected &&
        root.querySelector('.ac-checkout')?.getAttribute('aria-disabled')==='false';
    },count);
    assert.equal(await page.locator('#alookhor-cart .cart-row').count(),count);
  };

  for(let n=0;n<3;n++){
    const result=await api('cart/add','POST',{product_id:ids.simple[n],quantity:1});
    assert.equal(result.lines,n+1);
  }
  await page.reload({waitUntil:'domcontentloaded'});
  await expectRows(3);
  await page.waitForTimeout(3000); // a late GET must not erase the SSR rows
  await expectRows(3);
  console.log('REAL CHROMIUM: three separately added products remain visible after hydration');

  const card=page.locator('.sg-card').filter({has:page.locator('button[data-add-id="'+ids.parent+'"]')});
  await card.locator('.sg-variant').selectOption(String(ids.variation));
  await card.locator('button[data-add-id]').click();
  await expectRows(4);
  await page.waitForTimeout(3000);
  await expectRows(4);
  assert.equal((await api('cart')).count,4);
  console.log('REAL CHROMIUM: chosen variable suggestion is the fourth Woo cart row');

  const first=page.locator('.cart-row').filter({hasText:'CI simple 1'});
  await first.locator('button[data-cart-qty="+"]').click();
  await page.waitForFunction(()=>document.querySelector('.cart-items-count')?.textContent.includes('۵ عدد'));
  await page.reload({waitUntil:'domcontentloaded'});
  await expectRows(4);
  assert.equal((await api('cart')).count,5);
  const second=page.locator('.cart-row').filter({hasText:'CI simple 2'});
  await second.locator('[data-cart-remove]').click();
  await expectRows(3);
  await page.reload({waitUntil:'domcontentloaded'});
  await expectRows(3);
  assert.equal((await api('cart')).count,4);
  console.log('REAL CHROMIUM: quantity and removal survive navigation with same guest cookie');
  await context.close();
 }finally{await browser.close();}
})().then(()=>console.log('WORDPRESS/WOO REAL BROWSER CART: GREEN (isolated runner, no orders)'))
 .catch(err=>{console.error(err);process.exitCode=1;});
