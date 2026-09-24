/* ALOOKHOR CART v3.10.397 — resilient Store API client */
(function(){
'use strict';
const ROOT='#alookhor-cart', API='/wp-json/wc/store/v1', cfg=window.ALOOKHOR_CART_CONFIG||{};
const state={items:[],totals:{},nonce:cfg.nonce||'',busy:false};
const q=(s,r=document)=>r.querySelector(s), qa=(s,r=document)=>Array.from(r.querySelectorAll(s));
const fa=n=>(Number(n)||0).toLocaleString('fa-IR'), fp=n=>String(n).replace(/[0-9]/g,d=>'۰۱۲۳۴۵۶۷۸۹'[d]);
const esc=s=>String(s??'').replace(/[&<>"']/g,m=>({'&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;',"'":'&#039;'}[m]));
function error(msg){const e=q('.cart-error',q(ROOT));if(e){e.textContent=msg||'';e.hidden=!msg;}}
function getNonce(){return state.nonce||window.wcStoreApiNonce||q('meta[name="wc-store-api-nonce"]')?.content||window.wpApiSettings?.nonce||'';}
async function api(path,opt={}){
 const n=getNonce(),h={'Accept':'application/json','Content-Type':'application/json'};
 if(n){h.Nonce=n;h['X-WC-Store-API-Nonce']=n;}
 const res=await fetch(API+path,{method:opt.method||'GET',headers:h,credentials:'include',body:opt.body?JSON.stringify(opt.body):undefined});
 const rn=res.headers.get('Nonce')||res.headers.get('X-WC-Store-API-Nonce');if(rn)state.nonce=rn;
 const raw=await res.text();let data={};try{data=raw?JSON.parse(raw):{};}catch(e){data={};}
 if(!res.ok)throw new Error(data.message||data.code||('خطای سبد خرید '+res.status));
 if(data.nonce)state.nonce=data.nonce;return data;
}
function hideLegacy(){const root=q(ROOT);if(!root)return;qa('.woocommerce-cart-form,.cart-collaterals,.shop_table,.wd-cart,.wd-empty-cart,.return-to-shop,.cross-sells,.wd-cross-sells,.elementor-widget-woocommerce-cart,.elementor-widget-wd_products,.wd-products-element').forEach(el=>{if(!el.closest(ROOT)&&!el.closest('footer'))el.style.setProperty('display','none','important');});}
function render(){
 const r=q(ROOT),box=q('.cart-items',r);if(!r||!box)return;
 const count=state.items.reduce((n,i)=>n+(Number(i.quantity)||0),0),ce=q('.cart-items-count',r);if(ce)ce.textContent=count?fp(count)+' قلم':'سبد خالی است';
 if(!state.items.length){box.innerHTML='<div class="alookhor-cart-empty"><strong>سبد خرید شما خالی است</strong><p>محصول موردنظر خود را از فروشگاه انتخاب کنید.</p><a href="'+esc(cfg.shopUrl||'/shop/')+'">رفتن به فروشگاه</a></div>';}
 else{box.innerHTML=state.items.map(i=>{
  const img=i.images?.[0]?.thumbnail||i.images?.[0]?.src||'',price=(Number(i.prices?.price)||0)/100,line=(Number(i.totals?.line_total)||0)/100,key=String(i.key||''),name=String(i.name||'محصول'),variant=(i.variation||[]).map(v=>esc(v.value)).join(' / ')||'بسته استاندارد';
  return '<article class="cart-item" data-key="'+esc(key)+'"><div class="cart-item-prod"><img src="'+esc(img)+'" alt="'+esc(name)+'" loading="lazy" decoding="async"><div><a href="'+esc(i.permalink||'#')+'">'+esc(name)+'</a></div></div><div class="cart-item-variant">'+variant+'</div><div class="price">'+fa(price)+' تومان</div><div><div class="cart-qty" aria-label="تعداد '+esc(name)+'"><button type="button" data-cart-qty="-" data-key="'+esc(key)+'" aria-label="کاهش تعداد">−</button><span>'+fp(i.quantity||1)+'</span><button type="button" data-cart-qty="+" data-key="'+esc(key)+'" aria-label="افزایش تعداد">+</button></div></div><div class="price-total">'+fa(line)+' تومان</div><div class="cart-actions"><button type="button" data-cart-remove="'+esc(key)+'" aria-label="حذف '+esc(name)+'">حذف</button></div></article>';
 }).join('');}
 renderSummary();syncCount(count);bind();hideLegacy();
}
function renderSummary(){
 const r=q(ROOT),t=state.totals||{},v=k=>(Number(t[k])||0)/100;if(!r)return;
 const rows=qa('.summary-row .value',r);
 if(rows[0])rows[0].textContent=fa(v('total_items'))+' تومان';
 if(rows[1])rows[1].textContent=fa(v('total_discount'))+' تومان';
 if(rows[2])rows[2].textContent=v('total_shipping')?fa(v('total_shipping'))+' تومان':'رایگان';
 const total=q('.summary-total .value',r);if(total)total.textContent=fa(v('total_price'))+' تومان';
 const mobile=q('.mobile-checkout',r);if(mobile)mobile.setAttribute('aria-label','ادامه تا تسویه‌حساب؛ '+fa(v('total_price'))+' تومان');
}
function syncCount(n){qa('.wd-cart-number,.ak-cart-badge,.alookhor-header-cart-count,.cart-count,[data-cart-count]').forEach(el=>{el.textContent=fp(n);el.style.display=n?'':'none';});}
async function load(){
 const r=q(ROOT);if(!r)return;hideLegacy();
 try{const d=await api('/cart');state.items=d.items||[];state.totals=d.totals||{};if(d.nonce)state.nonce=d.nonce;render();error('');}
 catch(e){error('بارگذاری سبد خرید انجام نشد. لطفاً دوباره تلاش کنید.');console.error(e);}
}
async function update(key,qty){
 if(state.busy)return;state.busy=true;
 try{await api('/cart/update-item',{method:'POST',body:{key,quantity:qty}});await load();}
 catch(e){error(e.message||'تغییر تعداد انجام نشد.');}
 finally{state.busy=false;}
}
async function remove(key){
 if(state.busy)return;state.busy=true;
 try{await api('/cart/remove-item',{method:'POST',body:{key}});await load();recommend();}
 catch(e){error(e.message||'حذف محصول انجام نشد.');}
 finally{state.busy=false;}
}
async function coupon(code){
 const b=q('.coupon-box button',q(ROOT));if(b)b.disabled=true;
 try{await api('/cart/apply-coupon',{method:'POST',body:{code}});await load();}
 catch(e){error(e.message||'کد تخفیف قابل اعمال نیست.');}
 finally{if(b)b.disabled=false;}
}
function bind(){
 const r=q(ROOT);if(!r)return;
 qa('[data-cart-qty]',r).forEach(b=>b.onclick=()=>{const i=state.items.find(x=>String(x.key)===String(b.dataset.key));if(i)update(b.dataset.key,b.dataset.cartQty==='+'?Number(i.quantity)+1:Math.max(1,Number(i.quantity)-1));});
 qa('[data-cart-remove]',r).forEach(b=>b.onclick=()=>remove(b.dataset.cartRemove));
 const cb=q('.coupon-box button',r),ci=q('.coupon-box input',r);if(cb&&ci){cb.onclick=()=>{const code=ci.value.trim();if(code)coupon(code);};ci.onkeydown=e=>{if(e.key==='Enter'){e.preventDefault();cb.click();}};}
}
async function recommend(){
 const grid=q('.suggested-grid',q(ROOT));if(!grid)return;
 try{const res=await fetch('/wp-json/alookhor-cart/v3/recommendations',{credentials:'include',cache:'no-store'});if(!res.ok)return;const data=await res.json();
  grid.innerHTML=(data||[]).slice(0,4).map(p=>'<article class="suggested-card"><div class="img-wrap"><img src="'+esc(p.image||'')+'" alt="'+esc(p.name||'')+'" loading="lazy" decoding="async">'+(p.on_sale?'<span class="discount">تخفیف</span>':'')+'</div><div class="info"><span class="name">'+esc(p.name||'')+'</span><span class="price">'+fa(p.price)+' تومان</span><button class="add-btn" type="button" data-add-id="'+esc(p.id)+'">افزودن به سبد</button></div></article>').join('');
  qa('[data-add-id]',grid).forEach(b=>b.onclick=async()=>{if(b.disabled)return;b.disabled=true;try{await api('/cart/add-item',{method:'POST',body:{id:Number(b.dataset.addId),quantity:1}});await load();recommend();}catch(e){error(e.message||'افزودن محصول انجام نشد.');}finally{b.disabled=false;}});
 }catch(e){console.error(e);}
}
function init(){const r=q(ROOT);if(!r)return;document.body.classList.add('alookhor-cart-active');hideLegacy();load();recommend();}
if(document.readyState==='loading')document.addEventListener('DOMContentLoaded',init);else init();
})();