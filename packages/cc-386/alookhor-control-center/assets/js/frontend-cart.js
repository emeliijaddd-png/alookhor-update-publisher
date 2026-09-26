/* ALOOKHOR CART v3.10.419 — Cart UX v2 + route normalization + Woo session bridge */
(function(){
'use strict';
const ROOT='#alookhor-cart', cfg=window.ALOOKHOR_CART_CONFIG||{}, API=String(cfg.cartApi||'/wp-json/alookhor-cart/v4/').replace(/\/+$/,'');
const apiPath=path=>'/'+String(path||'').replace(/^\/+/,'');
const state={items:[],totals:{},coupons:[],nonce:cfg.nonce||'',busy:false,lastRemoved:null};
const q=(s,r=document)=>r.querySelector(s), qa=(s,r=document)=>Array.from(r.querySelectorAll(s));
const fa=n=>(Number(n)||0).toLocaleString('fa-IR'), fp=n=>String(n).replace(/[0-9]/g,d=>'۰۱۲۳۴۵۶۷۸۹'[d]);
const esc=s=>String(s??'').replace(/[&<>"']/g,m=>({'&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;',"'":'&#039;'}[m]));
function error(msg){const e=q('.cart-error',q(ROOT));if(e){e.textContent=msg||'';e.hidden=!msg;}}
function toast(msg){let t=q('.ac-toast');if(!t){t=document.createElement('div');t.className='ac-toast';t.setAttribute('role','status');document.body.appendChild(t);}t.textContent=msg;t.classList.add('show');clearTimeout(t._h);t._h=setTimeout(()=>t.classList.remove('show'),2600);}
async function api(path,opt={}){
 // فقط نانس سفارشی خودمان؛ ارسال آن به‌صورت X-WP-Nonce باعث 403 «Cookie check failed» هسته می‌شد.
 const h={'Accept':'application/json','Content-Type':'application/json'};
 if(state.nonce)h['X-ALOOKHOR-CART-NONCE']=state.nonce;
 const bust=(apiPath(path).indexOf('?')>-1?'&':'?')+'_='+Date.now(); // کش‌شکن: LiteSpeed/کش‌های میانی نباید پاسخ سبد را کش کنند
 const res=await fetch(API+apiPath(path)+bust,{method:opt.method||'GET',headers:h,credentials:'include',cache:'no-store',body:opt.body?JSON.stringify(opt.body):undefined});
 const rn=res.headers.get('X-ALOOKHOR-CART-NONCE');if(rn)state.nonce=rn;
 const raw=await res.text();let data={};try{data=raw?JSON.parse(raw):{};}catch(e){data={};}
 if(!res.ok)throw new Error(data.message||data.code||('خطای سبد خرید '+res.status));
 if(data.nonce)state.nonce=data.nonce;return data;
}
function linesCount(){return state.items.length;}
function rowHTML(i){
 const img=i.image||'',price=Number(i.price)||0,line=Number(i.line_total)||0,key=String(i.key||''),name=String(i.name||'محصول'),pid=Number(i.id)||0;
 const desc=String(i.short_desc||''),variant=(i.variation||[]).map(v=>esc(v.value)).filter(Boolean).join(' / ')||'بسته استاندارد';
 const badges=(i.featured?'<span class="c-badge c-badge-premium">♛ ممتاز</span>':'')+(i.on_sale?'<span class="c-badge c-badge-sale">تخفیف</span>':'');
 const trash='<svg viewBox="0 0 24 24" aria-hidden="true"><path d="M3 6h18M8 6V4a1 1 0 0 1 1-1h6a1 1 0 0 1 1 1v2m3 0v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6h13ZM10 11v6m4-6v6"/></svg>';
 const heart='<svg viewBox="0 0 24 24" aria-hidden="true"><path d="M12 21s-7.5-4.7-9.8-9C.7 9.2 2.3 5.5 5.8 4.7c2-.5 4 .3 5.2 1.9 1.2-1.6 3.2-2.4 5.2-1.9 3.5.8 5.1 4.5 3.6 7.3-2.3 4.3-9.8 9-9.8 9Z"/></svg>';
 return '<article class="cart-row" data-key="'+esc(key)+'">'
 +'<div class="c-prod"><span class="c-thumb"><img src="'+esc(img)+'" alt="'+esc(name)+'" loading="lazy" decoding="async"></span><span class="c-meta"><a class="c-name" href="'+esc(i.permalink||'#')+'">'+esc(name)+'</a>'+(desc?'<small class="c-desc">'+esc(desc)+'</small>':'')+(badges?'<span class="c-badges">'+badges+'</span>':'')+'</span></div>'
 +'<span class="c-variant">'+variant+'</span>'
 +'<span class="c-price">'+fa(price)+'<small>تومان</small></span>'
 +'<span class="c-qty"><button type="button" data-cart-qty="-" data-key="'+esc(key)+'" aria-label="کاهش تعداد">−</button><b>'+fp(i.quantity||1)+'</b><button class="c-plus" type="button" data-cart-qty="+" data-key="'+esc(key)+'" aria-label="افزایش تعداد">+</button></span>'
 +'<span class="c-total">'+fa(line)+'<small>تومان</small></span>'
 +'<span class="c-ops"><button type="button" class="c-op c-del" data-cart-remove="'+esc(key)+'" aria-label="حذف '+esc(name)+'">'+trash+'</button><button type="button" class="c-op c-wish" data-wish="'+esc(pid)+'" aria-label="افزودن به علاقه‌مندی">'+heart+'</button></span>'
 +'</article>';
}
function emptyHTML(){
 const cart='<svg viewBox="0 0 24 24" aria-hidden="true"><path d="M6 6h15l-1.5 9.5a2 2 0 0 1-2 1.5H9.7a2 2 0 0 1-2-1.6L6 3H3"/><circle cx="10" cy="21" r="1.4"/><circle cx="18" cy="21" r="1.4"/></svg>';
 return '<div class="alookhor-cart-empty"><span class="ace-ico">'+cart+'</span><strong>سبد خرید شما خالی است</strong><p>محصول موردنظر خود را از فروشگاه انتخاب کنید.</p><a href="'+esc(cfg.shopUrl||'/shop/')+'">رفتن به فروشگاه</a></div>';
}
const WISH={key:'alookhor_wishlist',get(){try{return new Set(JSON.parse(localStorage.getItem(this.key)||'[]'));}catch(e){return new Set();}},toggle(id){const s=this.get();s.has(id)?s.delete(id):s.add(id);try{localStorage.setItem(this.key,JSON.stringify([...s]));}catch(e){}return s.has(id);}};
function paintWish(){const s=WISH.get();qa('[data-wish]',q(ROOT)).forEach(b=>b.classList.toggle('on',s.has(Number(b.dataset.wish))));}
function render(){
 const r=q(ROOT),box=q('.cart-items',r);if(!r||!box)return;
 const lines=linesCount(),ce=q('.cart-items-count',r);if(ce)ce.textContent='('+fp(lines)+' کالا)';
 box.innerHTML=lines?state.items.map(rowHTML).join(''):emptyHTML();
 renderSummary();syncCount();bindRows();paintWish();hideLegacy();const mb=q('.ac-mobile-checkout',r);if(mb)mb.classList.toggle('is-visible',window.innerWidth<=760&&state.items.length>0);
}
function applyPayload(d){
 if(!d||typeof d!=='object'||!Array.isArray(d.items)||!d.totals)return false;
 state.items=d.items;state.totals=d.totals||{};state.coupons=Array.isArray(d.coupons)?d.coupons:[];if(d.nonce)state.nonce=d.nonce;render();return true;
}
function renderSummary(){
 const r=q(ROOT),t=state.totals||{},v=k=>(Number(t[k])||0);if(!r)return;
 const set=(sel,txt)=>{const el=q(sel+' .value',r);if(el)el.textContent=txt;};
 set('.sr-sub',fa(v('subtotal'))+' تومان');
 set('.sr-disc',v('discount_total')?'−'+fa(v('discount_total'))+' تومان':'۰ تومان');
 set('.sr-ship',v('shipping_total')?fa(v('shipping_total'))+' تومان':'محاسبه در تسویه‌حساب');
 set('.sr-total',fa(v('total'))+' تومان');
 const mt=q('.mobile-total',r);if(mt)mt.textContent=fa(v('total'))+' تومان';
}
function syncCount(){const n=linesCount();qa('.wd-cart-number,.ak-cart-badge,.alookhor-header-cart-count,.cart-count,[data-cart-count]').forEach(el=>{el.textContent=fp(n);el.style.display=n?'':'none';});}
async function load(tryNo){
 const r=q(ROOT);if(!r)return;hideLegacy();
 try{const d=await api('/cart');if(!applyPayload(d))throw new Error('پاسخ سبد ناقص است');error('');}
 catch(e){if((tryNo||0)<1){setTimeout(()=>load(1),1200);return;}error('بارگذاری سبد خرید انجام نشد. لطفاً دوباره تلاش کنید.');console.error(e);}
}
async function update(key,qty){
 if(state.busy)return;state.busy=true;
 try{const d=await api('/cart/update',{method:'POST',body:{key,quantity:qty}});applyPayload(d);error('');}
 catch(e){error(e.message||'تغییر تعداد انجام نشد.');}
 finally{state.busy=false;renderSummary();}
}
async function remove(key){
 if(state.busy)return;state.busy=true;const old=state.items.find(x=>String(x.key)===String(key));if(old)state.lastRemoved=JSON.parse(JSON.stringify(old));
 try{const d=await api('/cart/remove',{method:'POST',body:{key}});applyPayload(d);error('');showUndo();toast('محصول از سبد حذف شد');}
 catch(e){error(e.message||'حذف محصول انجام نشد.');}
 finally{state.busy=false;}
}
async function coupon(code){
 const b=q('.ac-coupon button',q(ROOT));if(b)b.disabled=true;
 try{const d=await api('/cart/coupon',{method:'POST',body:{code}});applyPayload(d);error('');toast('کد تخفیف اعمال شد');}
 catch(e){error(e.message||'کد تخفیف قابل اعمال نیست.');}
 finally{renderSummary();}
}
async function removeCoupon(){
 if(state.busy)return;state.busy=true;
 try{const d=await api('/cart/coupon/remove',{method:'POST',body:{}});applyPayload(d);toast('کد تخفیف حذف شد');}
 catch(e){error(e.message||'حذف کد تخفیف انجام نشد.');}
 finally{state.busy=false;renderSummary();}
}
async function undoRemove(){
 const x=state.lastRemoved;if(!x||state.busy)return;state.busy=true;
 try{const d=await api('/cart/add',{method:'POST',body:{product_id:Number(x.id)||0,variation_id:Number(x.variation_id)||0,variation:x.variation_attributes||{},quantity:Number(x.quantity)||1}});applyPayload(d);state.lastRemoved=null;hideUndo();toast('محصول به سبد بازگردانده شد');}
 catch(e){error(e.message||'بازگردانی محصول انجام نشد.');}
 finally{state.busy=false;}
}
function showUndo(){const e=q('.ac-undo',q(ROOT));if(!e)return;e.hidden=false;clearTimeout(e._t);e._t=setTimeout(()=>{state.lastRemoved=null;hideUndo();},7000);}
function hideUndo(){const e=q('.ac-undo',q(ROOT));if(e)e.hidden=true;}
function enhanceCartUX(){const r=q(ROOT);if(!r)return;const u=q('[data-cart-undo]',r);if(u)u.onclick=undoRemove;const bar=q('.ac-mobile-checkout',r);if(bar){const update=()=>bar.classList.toggle('is-visible',window.innerWidth<=760&&state.items.length>0);update();window.addEventListener('resize',update,{passive:true});}}
function bindRows(){
 const r=q(ROOT);if(!r)return;
 qa('[data-cart-qty]',r).forEach(b=>b.onclick=()=>{const i=state.items.find(x=>String(x.key)===String(b.dataset.key));if(i)update(b.dataset.key,b.dataset.cartQty==='+'?Number(i.quantity)+1:Math.max(1,Number(i.quantity)-1));});
 qa('[data-cart-remove]',r).forEach(b=>b.onclick=()=>remove(b.dataset.cartRemove));
}
function bindStatics(){
 const r=q(ROOT);if(!r)return;
 const cb=q('.ac-coupon button',r),ci=q('.ac-coupon input',r);
 if(cb&&ci){cb.onclick=()=>{const code=ci.value.trim();if(code)coupon(code);};ci.oninput=()=>{cb.disabled=!ci.value.trim()||state.busy;};ci.onkeydown=e=>{if(e.key==='Enter'){e.preventDefault();if(!cb.disabled)cb.click();}};}
 const share=q('[data-ac-share]',r);
 if(share)share.onclick=async()=>{const url=location.href.split('#')[0];try{await navigator.clipboard.writeText(url);toast('لینک سبد خرید کپی شد');}catch(e){const ta=document.createElement('textarea');ta.value=url;document.body.appendChild(ta);ta.select();try{document.execCommand('copy');toast('لینک سبد خرید کپی شد');}catch(x){toast('کپی لینک انجام نشد');}ta.remove();}};
 qa('.faq-q',r).forEach(btn=>btn.onclick=()=>{const it=btn.closest('.faq-item');const open=it.classList.toggle('open');const a=q('.faq-a',it);if(a)a.style.maxHeight=open?(a.scrollHeight+24)+'px':'0px';});
 document.addEventListener('click',ev=>{const w=ev.target.closest&&ev.target.closest('[data-wish]');if(!w||!w.closest(ROOT))return;const on=WISH.toggle(Number(w.dataset.wish));w.classList.toggle('on',on);toast(on?'به علاقه‌مندی‌ها اضافه شد':'از علاقه‌مندی‌ها حذف شد');});
}
function cardHTML(p){
 const img=p.image||'',name=String(p.name||''),id=Number(p.id)||0,price=Number(p.price)||0,regular=Number(p.regular_price)||0,percent=Number(p.percent)||0;
 const vid=Number(p.variation_id)||0;
 const badge=(p.on_sale&&percent>0)?'<span class="sg-badge sg-badge-sale">٪'+fp(percent)+' تخفیف</span>':'<span class="sg-badge sg-badge-special">پیشنهاد ویژه</span>';
 const heart='<svg viewBox="0 0 24 24" aria-hidden="true"><path d="M12 21s-7.5-4.7-9.8-9C.7 9.2 2.3 5.5 5.8 4.7c2-.5 4 .3 5.2 1.9 1.2-1.6 3.2-2.4 5.2-1.9 3.5.8 5.1 4.5 3.6 7.3-2.3 4.3-9.8 9-9.8 9Z"/></svg>';
 const cart='<svg viewBox="0 0 24 24" aria-hidden="true"><path d="M3 3h2l2.4 12.2A2 2 0 0 0 9.4 17H18a2 2 0 0 0 2-1.6L21.6 8H6"/><circle cx="10" cy="21" r="1.4"/><circle cx="18" cy="21" r="1.4"/></svg>';
 const at=(p.variations_label&&typeof p.variations_label==='object')?Object.keys(p.variations_label).map(k=>String(k)+': '+p.variations_label[k]).join(' · '):((p.variations&&typeof p.variations==='object')?Object.keys(p.variations).map(k=>String(k).replace(/^attribute_/,'')+': '+p.variations[k]).join(' · '):'');
 const attrsLine=at?('<span class="sg-attrs">'+esc(at)+'</span>'):'';
 const priceHtml=(p.on_sale&&regular>price&&regular>0)?('<del>'+fa(regular)+'</del>'+fa(price)+'<small>تومان</small>'):(fa(price)+'<small>تومان</small>');
 return '<article class="sg-card"><span class="sg-img"><img src="'+esc(img)+'" alt="'+esc(name)+'" loading="lazy" decoding="async">'+badge+'<button type="button" class="c-op c-wish sg-wish" data-wish="'+esc(id)+'" aria-label="افزودن به علاقه‌مندی">'+heart+'</button></span><strong class="sg-name">'+esc(name)+'</strong>'+attrsLine+'<span class="sg-price">'+priceHtml+'</span><button type="button" class="sg-add" data-add-id="'+esc(id)+'"'+(vid?' data-add-variation="'+vid+'"':'')+'>'+cart+' افزودن</button></article>';
}
async function recommend(){
 const grid=q('.suggested-grid',q(ROOT));if(!grid)return;
 try{
  const res=await fetch(API+'/recommendations?_='+Date.now(),{credentials:'include',cache:'no-store',headers:{'Accept':'application/json'}});
  if(!res.ok)return;const data=await res.json();
  if(Array.isArray(data)&&data.length){grid.innerHTML=data.slice(0,4).map(cardHTML).join('');
   qa('[data-add-id]',grid).forEach(b=>b.onclick=async()=>{if(b.disabled)return;b.disabled=true;const v0=Number(b.dataset.addVariation)||0;try{const d=await api('/cart/add',{method:'POST',body:(v0?{product_id:Number(b.dataset.addId),variation_id:v0,quantity:1}:{product_id:Number(b.dataset.addId),quantity:1})});applyPayload(d);toast('محصول به سبد اضافه شد');}catch(e){error(e.message||'افزودن محصول انجام نشد.');}finally{b.disabled=false;}});
   paintWish();
  }
 }catch(e){console.error(e);}
}
function hideLegacy(){const root=q(ROOT);if(!root)return;qa('.woocommerce-cart-form,.cart-collaterals,.shop_table,.wd-cart,.wd-empty-cart,.return-to-shop,.cross-sells,.wd-cross-sells,.elementor-widget-woocommerce-cart').forEach(el=>{if(!el.closest(ROOT)&&!el.closest('footer'))el.style.setProperty('display','none','important');});}
function init(){const r=q(ROOT);if(!r)return;
 /* 3.10.405 — خودترمیم‌گری کش کهنه: اگر HTML صفحه با بیلد این فایل JS جفت نباشد
    (کش مرورگر/LiteSpeed نسخهٔ قدیمی را سرو کرده)، یک‌بار با پارامتر کش‌شکن ریلود می‌کنیم. */
 try{const BUILD='3.10.419';const mb=r.getAttribute('data-ac-build')||'';
  if(mb&&mb!==BUILD){const k='ac_heal_'+BUILD;let done=false;try{done=sessionStorage.getItem(k)==='1';}catch(e){}
   if(!done){try{sessionStorage.setItem(k,'1');}catch(e){}
    const u=new URL(location.href);u.searchParams.set('ac_b',BUILD);location.replace(u.toString());return;}
   error('نسخهٔ این صفحه از کش قدیمی است. لطفاً یک‌بار با Ctrl+F5 (یا Cmd+Shift+R) صفحه را کاملاً تازه کنید.');}
 }catch(e){}
 document.body.classList.add('alookhor-cart-active');hideLegacy();
 try{const j=q('#alookhor-cart-initial');if(j){const d=JSON.parse(j.textContent||'{}');if(d&&Array.isArray(d.items)){state.items=d.items;state.totals=d.totals||{};render();}}}catch(err){console.error(err);}
 bindStatics();enhanceCartUX();load();recommend();}
if(document.readyState==='loading')document.addEventListener('DOMContentLoaded',init);else init();
})();
