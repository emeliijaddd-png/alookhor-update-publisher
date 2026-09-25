/* ALOOKHOR CART v3.10.406 — Store API single-source cart client */
(function(){
'use strict';
const ROOT='#alookhor-cart',cfg=window.ALOOKHOR_CART_CONFIG||{};
const API=String(cfg.cartApi||'/wp-json/alookhor-cart/v4/').replace(/\/+$/,'');
const REC=String(cfg.recommendationsApi||'/wp-json/alookhor-cart/v4/recommendations');
const state={cart:null,token:'',nonce:'',busy:new Set()};
const q=(s,r=document)=>r.querySelector(s),qa=(s,r=document)=>Array.from(r.querySelectorAll(s));
const fa=n=>(Number(n)||0).toLocaleString('fa-IR'),fp=n=>String(n).replace(/[0-9]/g,d=>'۰۱۲۳۴۵۶۷۸۹'[d]);
const esc=s=>String(s??'').replace(/[&<>"']/g,m=>({'&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;',"'":'&#039;'}[m]));
function err(msg){const e=q('.cart-error',q(ROOT));if(e){e.textContent=msg||'';e.hidden=!msg;}}
function setBusy(key,on){qa('[data-key="'+CSS.escape(String(key))+'"]',q(ROOT)||document).forEach(el=>el.toggleAttribute('aria-busy',on));}
function capture(res){const t=res.headers.get('Cart-Token');if(t)state.token=t;const n=res.headers.get('Nonce');if(n)state.nonce=n;}
async function api(path,method='GET',body){
 const h={'Accept':'application/json','Content-Type':'application/json'};
 const n=state.nonce||window.wcStoreApiNonce||q('meta[name="wc-store-api-nonce"]')?.content||'';
 if(state.token)h['Cart-Token']=state.token; else if(cfg.cartNonce)h['X-ALOOKHOR-CART-NONCE']=cfg.cartNonce; else if(n)h['Nonce']=n;
 const res=await fetch(API+'/'+String(path).replace(/^\/+/,''),{method,headers:h,credentials:'include',cache:'no-store',body:body===undefined?undefined:JSON.stringify(body)});
 capture(res);
 const raw=await res.text();let data={};try{data=raw?JSON.parse(raw):{};}catch(e){}
 if(!res.ok)throw new Error(data.message||data.code||('خطای سبد خرید '+res.status));
 return data;
}
function normalize(c){
 const items=(c.items||[]).map(i=>({key:i.key,id:Number(i.id),name:i.name,quantity:Number(i.quantity)||1,permalink:i.permalink||'#',image:i.images?.[0]?.thumbnail||i.images?.[0]?.src||'',variation:(i.variation||[]).map(v=>({name:v.attribute||v.raw_attribute||'',value:v.value||''})),price:Number(i.prices?.price)||0,line_total:Number(i.totals?.line_total)||0,limits:i.quantity_limits||{minimum:1,maximum:9999,multiple_of:1}}));
 const t=c.totals||{};
 return {items,count:Number(c.items_count)||items.reduce((n,i)=>n+i.quantity,0),totals:{subtotal:Number(t.total_items)||0,discount_total:Number(t.total_discount)||0,shipping_total:Number(t.total_shipping)||0,total:Number(t.total_price)||0},coupons:c.coupons||[]};
}
function render(){
 const r=q(ROOT);if(!r||!state.cart)return;
 const c=state.cart,box=q('.cart-items',r),count=q('.cart-items-count',r);
 if(count)count.textContent=c.count?'('+fp(c.count)+' کالا)':'(سبد خالی است)';
 if(!c.items.length){box.innerHTML='<div class="alookhor-cart-empty"><strong>سبد خرید شما خالی است</strong><p>محصول موردنظر خود را از فروشگاه انتخاب کنید.</p><a href="'+esc(cfg.shopUrl||'/shop/')+'">رفتن به فروشگاه</a></div>';}
 else box.innerHTML=c.items.map(i=>{const variant=i.variation.map(v=>esc(v.value)).join(' / ')||'بسته استاندارد';return '<article class="ac-item" data-key="'+esc(i.key)+'"><div class="ac-item-product"><img src="'+esc(i.image)+'" alt="'+esc(i.name)+'" loading="lazy" decoding="async"><a href="'+esc(i.permalink)+'">'+esc(i.name)+'</a></div><div class="ac-item-variant">'+variant+'</div><div class="ac-price">'+fa(i.price)+' تومان</div><div class="ac-qty"><button type="button" data-action="minus" data-key="'+esc(i.key)+'" aria-label="کاهش تعداد">−</button><span>'+fp(i.quantity)+'</span><button type="button" data-action="plus" data-key="'+esc(i.key)+'" aria-label="افزایش تعداد">+</button></div><div class="ac-price ac-line-total">'+fa(i.line_total)+' تومان</div><div><button type="button" class="ac-remove" data-action="remove" data-key="'+esc(i.key)+'">حذف</button></div></article>';}).join('');
 const t=c.totals,rows=qa('.sum-row .value',r);
 if(rows[0])rows[0].textContent=fa(t.subtotal)+' تومان';
 if(rows[1])rows[1].textContent=fa(t.discount_total)+' تومان';
 if(rows[2])rows[2].textContent=t.shipping_total?fa(t.shipping_total)+' تومان':'رایگان';
 const total=q('.sum-total .value',r);if(total)total.textContent=fa(t.total)+' تومان';
 const mobile=q('.mobile-checkout',r);if(mobile)mobile.textContent='ادامه و ثبت سفارش · '+fa(t.total)+' تومان';
 syncCount(c.count);bindFaq();
}
function syncCount(n){qa('.wd-cart-number,.ak-cart-badge,.alookhor-header-cart-count,.cart-count,[data-cart-count]').forEach(el=>{el.textContent=fp(n);el.style.display=n?'':'none';});}
async function load(){try{const c=await api('cart');state.cart=normalize(c);render();err('');}catch(e){err('سبد خرید بارگذاری نشد: '+(e.message||'خطای ناشناخته'));}}
async function mutate(key,fn){
 if(state.busy.has(key))return;state.busy.add(key);setBusy(key,true);err('');
 try{await fn();await load();}catch(e){err(e.message||'عملیات سبد خرید انجام نشد.');}finally{state.busy.delete(key);setBusy(key,false);}
}
function bind(){
 const r=q(ROOT);if(!r)return;
 qa('[data-action]',r).forEach(b=>{b.onclick=()=>{const key=b.dataset.key,i=state.cart.items.find(x=>String(x.key)===String(key));if(!i)return;
  if(b.dataset.action==='remove')mutate(key,()=>api('cart/remove','POST',{key}));
  else {let qty=b.dataset.action==='plus'?i.quantity+1:i.quantity-1;qty=Math.max(i.limits.minimum||1,Math.min(i.limits.maximum||9999,qty));if(qty!==i.quantity)mutate(key,()=>api('cart/update','POST',{key,quantity:qty}));}
 };});
 const cb=q('.ac-coupon button',r),ci=q('.ac-coupon input',r),fb=q('.coupon-feedback',r);
 if(cb&&ci){cb.onclick=async()=>{const code=ci.value.trim();if(!code)return;cb.disabled=true;if(fb)fb.textContent='در حال بررسی…';try{await api('cart/coupon','POST',{code});ci.value='';if(fb)fb.textContent='کد تخفیف اعمال شد.';await load();}catch(e){if(fb)fb.textContent=e.message||'کد تخفیف قابل اعمال نیست.';}finally{cb.disabled=false;}};ci.onkeydown=e=>{if(e.key==='Enter'){e.preventDefault();cb.click();}};}
}
function bindFaq(){qa('.faq-q',q(ROOT)||document).forEach(b=>{if(b.dataset.bound)return;b.dataset.bound='1';b.onclick=()=>{const a=b.nextElementSibling;b.parentElement.classList.toggle('open');if(a)a.style.maxHeight=b.parentElement.classList.contains('open')?a.scrollHeight+'px':'0';};});}
async function recommend(){
 const grid=q('.suggested-grid',q(ROOT));if(!grid)return;
 try{const res=await fetch(REC,{credentials:'include',cache:'no-store'});const data=await res.json();if(!res.ok)throw new Error(data.message||'پیشنهادها دریافت نشد');
  if(!Array.isArray(data)||!data.length){grid.innerHTML='<div class="suggest-empty">در حال حاضر پیشنهاد مرتبطی موجود نیست.</div>';return;}
  grid.innerHTML=data.slice(0,4).map(p=>'<article class="sg-card"><a class="sg-img" href="'+esc(p.permalink||'#')+'"><img src="'+esc(p.image||'')+'" alt="'+esc(p.name||'')+'" loading="lazy" decoding="async">'+(p.on_sale?'<span class="sg-badge">تخفیف ویژه</span>':'')+'</a><strong class="sg-name">'+esc(p.name||'')+'</strong><span class="sg-price">'+fa(p.price)+'<small>تومان</small></span><button type="button" class="sg-add" data-add-id="'+esc(p.id)+'" data-has-options="'+(p.has_options?'1':'0')+'">'+(p.has_options?'انتخاب گزینه‌ها':'افزودن')+'</button></article>').join('');
  qa('.sg-add',grid).forEach(b=>b.onclick=async()=>{const p=data.find(x=>String(x.id)===String(b.dataset.addId));if(!p)return;if(b.dataset.hasOptions==='1'){window.location.href=p.permalink;return;}b.disabled=true;try{await api('cart/add','POST',{product_id:Number(p.id),quantity:1});await load();}catch(e){err(e.message||'افزودن محصول انجام نشد.');}finally{b.disabled=false;}});
 }catch(e){grid.innerHTML='<div class="suggest-empty">پیشنهادها فعلاً در دسترس نیستند.</div>';console.error(e);}
}
function init(){if(!q(ROOT))return;document.body.classList.add('alookhor-cart-active');load();recommend();bindFaq();}
if(document.readyState==='loading')document.addEventListener('DOMContentLoaded',init);else init();
})();