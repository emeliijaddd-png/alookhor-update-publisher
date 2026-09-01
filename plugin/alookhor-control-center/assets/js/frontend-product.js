(()=>{'use strict';
const $=(s,r=document)=>r.querySelector(s);
const $$=(s,r=document)=>Array.from(r.querySelectorAll(s));
/* gallery */
function gallery(){
 const main=$('#alpMain');if(!main)return;
 const badge=$('.alp-badge-shot b');
 $$('.alp-thumbs button').forEach(btn=>{
  btn.addEventListener('click',()=>{
   $$('.alp-thumbs button').forEach(b=>b.classList.remove('is-on'));
   btn.classList.add('is-on');
   main.src=btn.dataset.src||main.src;
   const lb=$('[data-lb]');if(lb)lb.querySelector('img').src=btn.dataset.src||main.src;
   if(badge&&btn.dataset.label)badge.textContent=btn.dataset.label;
  const cap=$('[data-gal-label]');if(cap&&btn.dataset.label)cap.textContent=btn.dataset.label;
   const wrap=main.closest('.alp-gallery');if(wrap)wrap.dataset.label=btn.dataset.label||'';
  });
 });
}
/* lightbox */
function lightbox(){
 const lb=$('[data-lb]');if(!lb)return;
 $$('[data-zoom]').forEach(btn=>btn.addEventListener('click',()=>{lb.hidden=false;document.body.style.overflow='hidden'}));
 const close=()=>{lb.hidden=true;document.body.style.overflow=''};
 lb.querySelector('[data-lb-close]').addEventListener('click',close);
 lb.addEventListener('click',e=>{if(e.target===lb)close()});
 document.addEventListener('keydown',e=>{if(e.key==='Escape'&&!lb.hidden)close()});
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
/* quantity + add-to-cart urls */
function quantity(){
 const q=$('#alpQty');if(!q)return;
 let n=1;const min=1,max=99;
 const apply=()=>{q.textContent=String(n);
  $$('[data-base]').forEach(a=>{
   let url=a.dataset.base||a.getAttribute('href')||'';
   url=url.replace(/([?&])quantity=\d*/,'$1quantity='+n).replace(/([?&])add-to-cart=(\d+)/,(m,s,id)=>s+'add-to-cart='+id);
   if(!/[?&]quantity=/.test(url))url+=(url.includes('?')?'&':'?')+'quantity='+n;
   a.setAttribute('href',url);
  });
 };
 $$('[data-q]').forEach(b=>b.addEventListener('click',()=>{
  n=Math.min(max,Math.max(min,n+parseInt(b.dataset.q,10)||0));apply();
 }));
 apply();
}
/* weights */
function weights(){
 const buttons=$$('.alp-weights button');if(!buttons.length)return;
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
/* wishlist + share */
function wishlistShare(){
 $$('[data-wish]').forEach(b=>{
  try{
   const list=JSON.parse(localStorage.getItem('alookhor_wishlist')||'[]');
   const pid=String($('#alpAdd')?.getAttribute('href').match(/add-to-cart=(\d+)/)?.[1]||document.body.dataset.pdpId||'');
   if(pid&&list.includes(pid))b.classList.add('is-on');
   b.addEventListener('click',()=>{
    const set=new Set(JSON.parse(localStorage.getItem('alookhor_wishlist')||'[]'));
    if(!pid)return;
    if(set.has(pid)){set.delete(pid);b.classList.remove('is-on')}else{set.add(pid);b.classList.add('is-on')}
    localStorage.setItem('alookhor_wishlist',JSON.stringify(Array.from(set)));
   });
  }catch(e){}
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
 const name=sec.previousElementSibling?.querySelector('h1')?.textContent||document.title;
 const img=$('#alpMain')?.src||'';
 const price=$('.alp-price-now')?.dataset?.single||'';
 const href=location.href;
 list=list.filter(v=>v&&v.u!==href);
 const html=(v)=>`<article class="alp-card"><a class="alp-card-img" href="${v.u}"><img src="${v.i}" alt="" loading="lazy"></a><div class="alp-card-body"><h3><a href="${v.u}">${v.n}</a></h3>${v.p?`<span class="alp-card-price">${v.p}</span>`:''}</div></article>`;
 if(list.length){sec.hidden=false;rail.innerHTML=list.map(html).join('')}
 if(name&&img)list.unshift({n:name,u:href,i:img,p:price});
 localStorage.setItem('alookhor_rv',JSON.stringify(list.slice(0,8)));
}
function boot(){gallery();lightbox();accordions();giftOpts();quantity();weights();wishlistShare();bundle();viewed()}
document.readyState==='loading'?document.addEventListener('DOMContentLoaded',boot):boot();
})();
