(()=>{'use strict';
const $=(s,r=document)=>r.querySelector(s);
const $$=(s,r=document)=>Array.from(r.querySelectorAll(s));
const FA='۰۱۲۳۴۵۶۷۸۹';
const faNum=v=>String(v).replace(/\d/g,x=>FA[+x]);
/* toast (mockup style) */
let toastTimer=0;
function toast(msg){
 const t=$('[data-toast]');if(!t)return;
 const m=$('[data-toast-msg]',t);if(m)m.textContent=msg;
 t.hidden=false;
 const box=t.querySelector('.alpm-toast-in');
 if(box){box.style.animation='none';void box.offsetWidth;box.style.animation='';}
 clearTimeout(toastTimer);
 toastTimer=setTimeout(()=>{t.hidden=true},2800);
}
/* gallery: thumbs, arrows, counter */
function gallery(){
 const stage=$('#alpMain');
 const thumbs=$$('.alpm-thumbs button');
 if(!stage||!thumbs.length)return;
 const num=$('[data-gal-num]');
 let idx=0;
 const show=i=>{
  idx=(i+thumbs.length)%thumbs.length;
  const t=thumbs[idx];if(!t)return;
  thumbs.forEach(b=>b.classList.remove('is-on'));
  t.classList.add('is-on');
  const src=t.dataset.src||'';
  if(src&&src!==stage.getAttribute('src')){
   stage.classList.add('is-changing');
   setTimeout(()=>{stage.setAttribute('src',src);stage.classList.remove('is-changing')},160);
  }
  if(num)num.textContent=faNum(idx+1);
 };
 thumbs.forEach((t,i)=>t.addEventListener('click',()=>show(i)));
 $$('[data-gal-prev]').forEach(b=>b.addEventListener('click',()=>show(idx-1)));
 $$('[data-gal-next]').forEach(b=>b.addEventListener('click',()=>show(idx+1)));
}
/* fullscreen (mockup expand button) */
function fullscreen(){
 const btn=$('[data-fs]'),frame=$('[data-stage]');
 if(!btn||!frame)return;
 btn.addEventListener('click',()=>{
  if(document.fullscreenElement){(document.exitFullscreen()||Promise.resolve()).catch(()=>{});return;}
  if(!frame.requestFullscreen){toast('مرورگر شما از حالت تمام‌صفحه پشتیبانی نمی‌کند');return;}
  frame.requestFullscreen().catch(()=>toast('مرورگر شما از حالت تمام‌صفحه پشتیبانی نمی‌کند'));
 });
}
/* accordions */
function accordions(){
 $$('[data-acc-t]').forEach(t=>{
  t.addEventListener('click',()=>{
   const body=t.parentElement.querySelector('.alp-acc-b');
   const open=t.classList.toggle('is-open');
   if(body)body.classList.toggle('is-open',open);
  });
 });
}
/* gift options */
function giftOpts(){
 $$('[data-opt]').forEach(o=>o.addEventListener('click',()=>o.classList.toggle('is-on')));
}
/* quantity (Persian digits, 1..10) + add-to-cart urls */
function quantity(){
 const q=$('#alpQty');if(!q)return;
 let n=1;const min=1,max=10;
 const apply=()=>{q.textContent=faNum(n);
  $$('[data-base]').forEach(a=>{
   let url=a.dataset.base||a.getAttribute('href')||'';
   url=url.replace(/([?&])quantity=\d*/,'$1quantity='+n);
   if(!/[?&]quantity=/.test(url))url+=(url.includes('?')?'&':'?')+'quantity='+n;
   a.setAttribute('href',url);
  });
 };
 $$('[data-q]').forEach(b=>b.addEventListener('click',()=>{
  n=Math.min(max,Math.max(min,n+(parseInt(b.dataset.q,10)||0)));apply();
 }));
 apply();
}
/* weight chips -> price + variation id */
function weights(){
 const buttons=$$('.alpm-wchips button, .alp-weights button');if(!buttons.length)return;
 const priceEl=$('.alp-price-now');const single=priceEl?priceEl.dataset.single||'':'';
 buttons.forEach(b=>b.addEventListener('click',()=>{
  buttons.forEach(x=>{x.classList.remove('is-on');x.setAttribute('aria-checked','false')});
  b.classList.add('is-on');b.setAttribute('aria-checked','true');
  if(priceEl)priceEl.innerHTML=b.dataset.price?b.dataset.price:(single||priceEl.innerHTML);
  const vid=parseInt(b.dataset.vid,10);
  if(vid>0)$$('[data-base]').forEach(a=>{
   a.dataset.base=a.dataset.base.replace(/add-to-cart=\d+/,'add-to-cart='+vid);
   a.setAttribute('href',a.dataset.base);
  });
 }));
}
/* wishlist (heart + label + toast) + share */
function wishlistShare(){
 $$('[data-wish]').forEach(b=>{
  const lab=b.querySelector('[data-wish-label]');
  let pid='';
  try{pid=String(($('#alpAdd')?.getAttribute('href')||'').match(/add-to-cart=(\d+)/)?.[1]||document.body.dataset.pdpId||'');}catch(e){}
  try{
   const list=JSON.parse(localStorage.getItem('alookhor_wishlist')||'[]');
   if(pid&&list.includes(pid)){b.classList.add('is-on');b.setAttribute('aria-pressed','true');if(lab)lab.textContent='در علاقه‌مندی‌های شما';}
  }catch(e){}
  b.addEventListener('click',()=>{
   try{
    const set=new Set(JSON.parse(localStorage.getItem('alookhor_wishlist')||'[]'));
    const on=!b.classList.contains('is-on');
    b.classList.toggle('is-on',on);b.setAttribute('aria-pressed',on?'true':'false');
    if(pid){if(on)set.add(pid);else set.delete(pid);localStorage.setItem('alookhor_wishlist',JSON.stringify(Array.from(set)));}
    if(lab)lab.textContent=on?'در علاقه‌مندی‌های شما':'افزودن به علاقه‌مندی‌ها';
    toast(on?'به علاقه‌مندی‌های شما اضافه شد':'از علاقه‌مندی‌ها حذف شد');
   }catch(e){}
  });
 });
 $$('[data-share]').forEach(b=>b.addEventListener('click',async()=>{
  const data={title:b.dataset.name||document.title,url:b.dataset.url||location.href};
  try{
   if(navigator.share){await navigator.share(data);return}
   await navigator.clipboard.writeText(data.url);
   const s=b.querySelector('span');if(s){s.textContent='پیام کپی شد';setTimeout(()=>s.textContent='اشتراک‌گذاری',2000)}
  }catch(e){}
 }));
}
/* bundle add-all */
function bundle(){
 const btn=$('[data-addall]');if(!btn)return;
 btn.addEventListener('click',async()=>{
  let ids=[];try{ids=JSON.parse(btn.dataset.addall)}catch(e){}
  if(!ids.length)return;
  btn.disabled=true;const cart=$('#alookhor-pdp')?.dataset.cart||'/cart/';
  try{
   for(const id of ids){
    const body=new URLSearchParams({product_id:String(id),quantity:'1'});
    await fetch(location.origin+'/?wc-ajax=add_to_cart',{method:'POST',credentials:'same-origin',headers:{'Content-Type':'application/x-www-form-urlencoded'},body});
   }
   location.href=cart;
  }catch(e){location.href=cart+'?add-to-cart='+ids[0];}
 });
}
/* recently viewed */
function viewed(){
 const sec=$('#alpViewed'),rail=$('#alpViewedRail');if(!sec||!rail)return;
 let list=[];try{list=JSON.parse(localStorage.getItem('alookhor_rv')||'[]')}catch(e){}
 const name=$('.alpm-title')?.textContent||document.title;
 const img=$('#alpMain')?.src||'';
 const price=$('.alp-price-now')?.dataset?.single||'';
 const href=location.href;
 list=list.filter(v=>v&&v.u!==href);
 const html=(v)=>`<article class="alp-card"><a class="alp-card-img" href="${v.u}"><img src="${v.i}" alt="" loading="lazy"></a><div class="alp-card-body"><h3><a href="${v.u}">${v.n}</a></h3>${v.p?`<span class="alp-card-price">${v.p}</span>`:''}</div></article>`;
 if(list.length){sec.hidden=false;rail.innerHTML=list.map(html).join('')}
 if(name&&img)list.unshift({n:name,u:href,i:img,p:price});
 localStorage.setItem('alookhor_rv',JSON.stringify(list.slice(0,8)));
}
function boot(){gallery();fullscreen();accordions();giftOpts();quantity();weights();wishlistShare();bundle();viewed()}
document.readyState==='loading'?document.addEventListener('DOMContentLoaded',boot):boot();
})();
