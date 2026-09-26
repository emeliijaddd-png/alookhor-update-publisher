/* ALOOKHOR CART v3.10.412 — Woo session + SSR, explicit variant selection */
(function(){
'use strict';
const ROOT='#alookhor-cart', cfg=window.ALOOKHOR_CART_CONFIG||{};
const API=String(cfg.cartApi||'/wp-json/alookhor-cart/v4/').replace(/\/+$/,'')+'/';
const state={items:[],totals:{},nonce:cfg.nonce||'',busy:false,verified:false,revision:0,requestId:0};
const q=(s,r=document)=>r.querySelector(s), qa=(s,r=document)=>Array.from(r.querySelectorAll(s));
const fa=n=>(Number(n)||0).toLocaleString('fa-IR'), fp=n=>String(n).replace(/[0-9]/g,d=>'۰۱۲۳۴۵۶۷۸۹'[d]);
const esc=s=>String(s??'').replace(/[&<>"']/g,m=>({'&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;',"'":'&#039;'}[m]));
const route=path=>API+String(path).replace(/^\/+/, ''); // always /v4/cart, never /v4cart
const units=()=>state.items.reduce((n,i)=>n+(Number(i.quantity)||0),0);
function error(msg){const el=q('.cart-error',q(ROOT));if(el){el.textContent=msg||'';el.hidden=!msg;}}
function toast(msg){let t=q('.ac-toast');if(!t){t=document.createElement('div');t.className='ac-toast';t.setAttribute('role','status');document.body.appendChild(t);}t.textContent=msg;t.classList.add('show');clearTimeout(t._h);t._h=setTimeout(()=>t.classList.remove('show'),2600);}
function setCheckout(ready){const link=q('.ac-checkout',q(ROOT));if(!link)return;link.setAttribute('aria-disabled',ready?'false':'true');link.classList.toggle('ac-disabled',!ready);link.onclick=ready?null:(event=>event.preventDefault());}
async function api(path,opt={}){
 const method=String(opt.method||'GET').toUpperCase();
 const h={'Accept':'application/json','Cache-Control':'no-store','Pragma':'no-cache'};
 if(method!=='GET')h['Content-Type']='application/json';
 // A custom cart nonce is NOT a WordPress REST cookie nonce. X-WP-Nonce here causes 403.
 if(state.nonce)h['X-ALOOKHOR-CART-NONCE']=state.nonce;
 const url=route(path)+(path.includes('?')?'&':'?')+'_='+Date.now()+'-'+(++state.requestId);
 const res=await fetch(url,{method,headers:h,credentials:'include',cache:'no-store',body:opt.body?JSON.stringify(opt.body):undefined});
 const rn=res.headers.get('X-ALOOKHOR-CART-NONCE');if(rn)state.nonce=rn;
 const raw=await res.text();let data={};try{data=raw?JSON.parse(raw):{};}catch(e){data={};}
 if(!res.ok)throw new Error(data.message||data.code||('خطای سبد خرید '+res.status));
 if(data.nonce)state.nonce=data.nonce;
 return data;
}
function rowHTML(i){
 const img=i.image||'',price=Number(i.price)||0,line=Number(i.line_total)||0,key=String(i.key||''),name=String(i.name||'محصول'),pid=Number(i.id)||0;
 const desc=String(i.short_desc||''),variant=(i.variation||[]).map(v=>esc(v.value)).filter(Boolean).join(' / ')||'بسته استاندارد';
 const badges=(i.featured?'<span class="c-badge c-badge-premium">♛ ممتاز</span>':'')+(i.on_sale?'<span class="c-badge c-badge-sale">تخفیف</span>':'');
 const trash='<svg viewBox="0 0 24 24" aria-hidden="true"><path d="M3 6h18M8 6V4a1 1 0 0 1 1-1h6a1 1 0 0 1 1 1v2m3 0v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6h13ZM10 11v6m4-6v6"/></svg>';
 const heart='<svg viewBox="0 0 24 24" aria-hidden="true"><path d="M12 21s-7.5-4.7-9.8-9C.7 9.2 2.3 5.5 5.8 4.7c2-.5 4 .3 5.2 1.9 1.2-1.6 3.2-2.4 5.2-1.9 3.5.8 5.1 4.5 3.6 7.3-2.3 4.3-9.8 9-9.8 9Z"/></svg>';
 return '<article class="cart-row" data-key="'+esc(key)+'">'
 +'<div class="c-prod"><span class="c-thumb"><img src="'+esc(img)+'" alt="'+esc(name)+'" loading="lazy" decoding="async"></span><span class="c-meta"><a class="c-name" href="'+esc(i.permalink||'#')+'">'+esc(name)+'</a>'+(desc?'<small class="c-desc">'+esc(desc)+'</small>':'')+(badges?'<span class="c-badges">'+badges+'</span>':'')+'</span></div>'
 +'<span class="c-variant">'+variant+'</span><span class="c-price">'+fa(price)+'<small>تومان</small></span>'
 +'<span class="c-qty"><button type="button" data-cart-qty="-" data-key="'+esc(key)+'" aria-label="کاهش تعداد">−</button><b>'+fp(i.quantity||1)+'</b><button class="c-plus" type="button" data-cart-qty="+" data-key="'+esc(key)+'" aria-label="افزایش تعداد">+</button></span>'
 +'<span class="c-total">'+fa(line)+'<small>تومان</small></span>'
 +'<span class="c-ops"><button type="button" class="c-op c-del" data-cart-remove="'+esc(key)+'" aria-label="حذف '+esc(name)+'">'+trash+'</button><button type="button" class="c-op c-wish" data-wish="'+esc(pid)+'" aria-label="افزودن به علاقه‌مندی">'+heart+'</button></span></article>';
}
function emptyHTML(){return '<div class="alookhor-cart-empty"><strong>سبد خرید شما خالی است</strong><p>محصول موردنظر خود را از فروشگاه انتخاب کنید.</p><a href="'+esc(cfg.shopUrl||'/shop/')+'">رفتن به فروشگاه</a></div>';}
const WISH={key:'alookhor_wishlist',get(){try{return new Set(JSON.parse(localStorage.getItem(this.key)||'[]'));}catch(e){return new Set();}},toggle(id){const s=this.get();s.has(id)?s.delete(id):s.add(id);try{localStorage.setItem(this.key,JSON.stringify([...s]));}catch(e){}return s.has(id);}};
function paintWish(){const s=WISH.get();qa('[data-wish]',q(ROOT)).forEach(b=>b.classList.toggle('on',s.has(Number(b.dataset.wish))));}
function hideLegacy(){const root=q(ROOT);if(!root)return;qa('.woocommerce-cart-form,.cart-collaterals,.shop_table,.wd-cart,.wd-empty-cart,.return-to-shop,.cross-sells,.wd-cross-sells,.elementor-widget-woocommerce-cart').forEach(el=>{if(!el.closest(ROOT)&&!el.closest('footer'))el.style.setProperty('display','none','important');});}
function renderSummary(){
 const r=q(ROOT),t=state.totals||{},v=k=>(Number(t[k])||0);if(!r)return;
 const set=(sel,txt)=>{const el=q(sel+' .value',r);if(el)el.textContent=txt;};
 set('.sr-sub',fa(v('subtotal'))+' تومان');
 set('.sr-disc',v('discount_total')?'−'+fa(v('discount_total'))+' تومان':'۰ تومان');
 set('.sr-ship',v('shipping_total')?fa(v('shipping_total'))+' تومان':'رایگان');
 set('.sr-total',fa(v('total'))+' تومان');
}
function syncCount(){const n=units();qa('.wd-cart-number,.ak-cart-badge,.alookhor-header-cart-count,.cart-count,[data-cart-count]').forEach(el=>{el.textContent=fp(n);el.style.display=n?'':'none';});}
function render(){
 const r=q(ROOT),box=q('.cart-items',r);if(!r||!box)return;
 const lines=state.items.length,ce=q('.cart-items-count',r);if(ce)ce.textContent='('+fp(lines)+' نوع، '+fp(units())+' عدد)';
 box.innerHTML=lines?state.items.map(rowHTML).join(''):emptyHTML();
 renderSummary();syncCount();bindRows();paintWish();hideLegacy();
}
function applyPayload(d){
 if(!d||!Array.isArray(d.items)||!d.totals||typeof d.totals!=='object')throw new Error('پاسخ سبد خرید معتبر نیست.');
 state.items=d.items;state.totals=d.totals;state.verified=true;
 if(d.nonce)state.nonce=d.nonce;
 render();setCheckout(true);error('');
}
function lostSSRItem(d){
 if(state.verified||!state.items.length)return false;
 if(!Array.isArray(d.items))return true;
 // Catch a partially cached/stale GET as well as a completely empty response.
 return state.items.some(old=>!d.items.some(next=>String(next.key)===String(old.key)&&Number(next.quantity)>=Number(old.quantity)));
}
async function load(){
 const ticket=state.revision;
 try{
  let d=await api('cart');if(ticket!==state.revision)return;
  if(!Array.isArray(d.items))throw new Error('پاسخ سبد خرید معتبر نیست.');
  if(lostSSRItem(d)){
   // SSR has more items than the guest GET: never silently erase them or permit checkout.
   // A second independent no-store request rules out a transient cached response.
   d=await api('cart');if(ticket!==state.revision)return;
   if(lostSSRItem(d)){
    setCheckout(false);error('نشست سبد خرید با صفحه هماهنگ نیست. اقلام قبلی نمایش داده شده‌اند، اما برای پرداخت ابتدا صفحه را تازه‌سازی کنید.');return;
   }
  }
  applyPayload(d);
 }catch(e){if(ticket!==state.revision)return;setCheckout(false);error('بارگذاری سبد خرید انجام نشد. صفحه را تازه‌سازی کنید.');console.error(e);}
}
async function mutate(path,body,success){
 if(state.busy)return false;
 state.busy=true;state.revision++;
 try{
  const d=await api(path,{method:'POST',body});
  if(path==='cart/add' && !d.items?.some(i=>Number(i.id)===Number(body.product_id)||(body.variation_id&&Number(i.variation_id)===Number(body.variation_id)))){
   throw new Error('افزودن تأیید نشد؛ لطفاً سبد را تازه‌سازی کنید.');
  }
  applyPayload(d);if(success)toast(success);return true;
 }catch(e){error(e.message||'تغییر سبد خرید انجام نشد.');return false;}
 finally{state.busy=false;}
}
function bindRows(){
 const r=q(ROOT);if(!r)return;
 qa('[data-cart-qty]',r).forEach(b=>b.onclick=()=>{const i=state.items.find(x=>String(x.key)===String(b.dataset.key));if(i)mutate('cart/update',{key:i.key,quantity:b.dataset.cartQty==='+'?Number(i.quantity)+1:Math.max(0,Number(i.quantity)-1)});});
 qa('[data-cart-remove]',r).forEach(b=>b.onclick=()=>mutate('cart/remove',{key:b.dataset.cartRemove},'محصول از سبد حذف شد'));
}
function bindStatics(){
 const r=q(ROOT);if(!r)return;
 const cb=q('.ac-coupon button',r),ci=q('.ac-coupon input',r);
 if(cb&&ci){cb.onclick=async()=>{const code=ci.value.trim();if(!code||state.busy)return;cb.disabled=true;try{await mutate('cart/coupon',{code},'کد تخفیف اعمال شد');}finally{cb.disabled=false;}};ci.onkeydown=e=>{if(e.key==='Enter'){e.preventDefault();cb.click();}};}
 const share=q('[data-ac-share]',r);
 if(share)share.onclick=async()=>{const url=location.href.split('#')[0];try{await navigator.clipboard.writeText(url);toast('لینک صفحهٔ سبد کپی شد؛ اقلام سبد شخصی‌اند و با لینک منتقل نمی‌شوند.');}catch(e){toast('کپی لینک انجام نشد');}};
 qa('.faq-q',r).forEach(btn=>btn.onclick=()=>{const it=btn.closest('.faq-item');const open=it.classList.toggle('open');const a=q('.faq-a',it);if(a)a.style.maxHeight=open?(a.scrollHeight+24)+'px':'0px';});
 document.addEventListener('click',ev=>{const w=ev.target.closest&&ev.target.closest('[data-wish]');if(!w||!w.closest(ROOT))return;const on=WISH.toggle(Number(w.dataset.wish));w.classList.toggle('on',on);toast(on?'به علاقه‌مندی‌ها اضافه شد':'از علاقه‌مندی‌ها حذف شد');});
}
function cardHTML(p){
 const id=Number(p.id)||0,price=Number(p.price)||0,percent=Number(p.percent)||0,opts=Array.isArray(p.options)?p.options:[];
 const badge=(p.on_sale&&percent>0)?'<span class="sg-badge sg-badge-sale">٪'+fp(percent)+' تخفیف</span>':'<span class="sg-badge sg-badge-special">پیشنهاد ویژه</span>';
 const heart='<svg viewBox="0 0 24 24" aria-hidden="true"><path d="M12 21s-7.5-4.7-9.8-9C.7 9.2 2.3 5.5 5.8 4.7c2-.5 4 .3 5.2 1.9 1.2-1.6 3.2-2.4 5.2-1.9 3.5.8 5.1 4.5 3.6 7.3-2.3 4.3-9.8 9-9.8 9Z"/></svg>';
 const cart='<svg viewBox="0 0 24 24" aria-hidden="true"><path d="M3 3h2l2.4 12.2A2 2 0 0 0 9.4 17H18a2 2 0 0 0 2-1.6L21.6 8H6"/><circle cx="10" cy="21" r="1.4"/><circle cx="18" cy="21" r="1.4"/></svg>';
 const select=p.type==='variable'&&opts.length?'<label class="sg-choose">وزن / بسته‌بندی<select class="sg-variant" aria-label="انتخاب گزینه برای '+esc(p.name)+'"><option value="">انتخاب کنید</option>'+opts.map(o=>'<option value="'+esc(o.variation_id)+'" data-attributes="'+esc(JSON.stringify(o.attributes||{}))+'" data-price="'+esc(o.price)+'">'+esc(o.label)+' — '+fa(o.price)+' تومان</option>').join('')+'</select></label>':'';
 const add=p.type==='variable'&&!opts.length?'<a class="sg-add" href="'+esc(p.permalink||'#')+'">انتخاب گزینه‌ها در صفحه محصول</a>':'<button type="button" class="sg-add" data-add-id="'+esc(id)+'">'+cart+' افزودن</button>';
 const more=p.more_options?'<a class="sg-more" href="'+esc(p.permalink||'#')+'">گزینه‌های بیشتر</a>':'';
 return '<article class="sg-card" data-base-price="'+esc(price)+'"><span class="sg-img"><img src="'+esc(p.image||'')+'" alt="'+esc(p.name||'')+'" loading="lazy" decoding="async">'+badge+'<button type="button" class="c-op c-wish sg-wish" data-wish="'+esc(id)+'" aria-label="افزودن به علاقه‌مندی">'+heart+'</button></span><strong class="sg-name">'+esc(p.name||'')+'</strong><span class="sg-price">'+fa(price)+'<small>تومان</small></span>'+select+add+more+'</article>';
}
function bindSuggestions(){
 const grid=q('.suggested-grid',q(ROOT));if(!grid)return;
 grid.addEventListener('click',async ev=>{
  const button=ev.target.closest&&ev.target.closest('button[data-add-id]');if(!button||!grid.contains(button)||state.busy)return;
  const card=button.closest('.sg-card'),select=q('.sg-variant',card);
  const body={product_id:Number(button.dataset.addId),quantity:1};
  if(select){
   if(!select.value){select.focus();toast('ابتدا وزن و بسته‌بندی محصول را انتخاب کنید.');return;}
   const opt=select.selectedOptions[0];body.variation_id=Number(select.value);
   try{body.variation=JSON.parse(opt.dataset.attributes||'{}');}catch(e){error('گزینهٔ محصول نامعتبر است؛ صفحه را تازه‌سازی کنید.');return;}
  }
  button.disabled=true;try{await mutate('cart/add',body,'محصول به سبد اضافه شد');}finally{button.disabled=false;}
 });
 grid.addEventListener('change',ev=>{const select=ev.target.closest&&ev.target.closest('select.sg-variant');if(!select)return;const card=select.closest('.sg-card'),price=q('.sg-price',card),chosen=select.selectedOptions[0];if(price)price.innerHTML=fa(chosen?.dataset.price||card.dataset.basePrice)+'<small>تومان</small>';});
}
async function recommend(){
 const grid=q('.suggested-grid',q(ROOT));if(!grid)return;
 try{const data=await api('recommendations');if(Array.isArray(data)&&data.length){
  // Do not reset an option a customer has already chosen while the GET was in flight.
  if(qa('.sg-variant',grid).some(sel=>sel.value||sel===document.activeElement))return;
  grid.innerHTML=data.slice(0,4).map(cardHTML).join('');paintWish();
 }}
 catch(e){console.error(e);} // keep SSR cards and their already bound click handler
}
function init(){
 const r=q(ROOT);if(!r)return;
 // One cache-busted reload when old HTML and the installed script have different builds.
 try{const BUILD='3.10.412',mb=r.getAttribute('data-ac-build')||'';
  if(mb&&mb!==BUILD){const k='ac_heal_'+BUILD;let done=false;try{done=sessionStorage.getItem(k)==='1';}catch(e){}
   if(!done){try{sessionStorage.setItem(k,'1');}catch(e){}const u=new URL(location.href);u.searchParams.set('ac_b',BUILD);location.replace(u.toString());return;}
   setCheckout(false);
   error('نسخهٔ این صفحه از کش قدیمی است. لطفاً یک‌بار با Ctrl+F5 (یا Cmd+Shift+R) صفحه را کاملاً تازه کنید.');
   return; // never hydrate stale HTML with a newer cart script
  }
 }catch(e){}
 document.body.classList.add('alookhor-cart-active');hideLegacy();
 try{const j=q('#alookhor-cart-initial');if(j){const d=JSON.parse(j.textContent||'{}');if(d&&Array.isArray(d.items)){state.items=d.items;state.totals=d.totals||{};render();}}}catch(err){console.error(err);}
 setCheckout(false); // Verify the real Woo session before permitting checkout of hydrated SSR items.
 bindStatics();bindSuggestions();load();recommend();
}
if(document.readyState==='loading')document.addEventListener('DOMContentLoaded',init);else init();
})();
