(()=>{'use strict';
const $=(s,r=document)=>r.querySelector(s);
const $$=(s,r=document)=>Array.from(r.querySelectorAll(s));
const FA='۰۱۲۳۴۵۶۷۸۹';
const faNum=v=>String(v).replace(/\d/g,x=>FA[+x]);

let toastTimer=0;
function toast(msg){
 const t=$('[data-toast]'); if(!t) return;
 const m=$('[data-toast-msg]',t); if(m) m.textContent=msg;
 t.hidden=false;
 const box=t.querySelector('.alpm-toast-in')||t.firstElementChild;
 if(box){box.style.animation='none';void box.offsetWidth;box.style.animation='';}
 clearTimeout(toastTimer);
 toastTimer=setTimeout(()=>{t.hidden=true},3000);
}

/* gallery: support both old .alpm-thumbs and new .gallery-thumbs */
function gallery(){
 const stage=$('#alpMain');
 const thumbs=$$('.gallery-thumbs button, .alpm-thumbs button, .gallery-thumb');
 if(!stage||!thumbs.length) return;
 const num=$('[data-gal-num]');
 let idx=0;
 const show=i=>{
  idx=(i+thumbs.length)%thumbs.length;
  const t=thumbs[idx]; if(!t) return;
  thumbs.forEach(b=>{b.classList.remove('is-on'); b.classList.remove('border-gold-400'); b.classList.add('border-white/10');});
  t.classList.add('is-on');
  // new design active styles
  t.classList.add('border-gold-400');
  t.classList.remove('border-white/10');
  t.classList.add('shadow-[0_0_0_3px_rgba(247,179,43,0.25)]');
  const src=t.dataset.src||t.querySelector('img')?.src||'';
  if(src && src!==stage.getAttribute('src')){
   stage.classList.add('is-changing');
   setTimeout(()=>{stage.setAttribute('src',src); stage.classList.remove('is-changing');},160);
  }
  if(num) num.textContent=faNum(idx+1);
 };
 thumbs.forEach((t,i)=>t.addEventListener('click',()=>show(i)));
 $$('[data-gal-prev]').forEach(b=>b.addEventListener('click',()=>show(idx-1)));
 $$('[data-gal-next]').forEach(b=>b.addEventListener('click',()=>show(idx+1)));
}

function fullscreen(){
 const btn=$('[data-fs]'), frame=$('[data-stage]');
 if(!btn||!frame) return;
 btn.addEventListener('click',()=>{
  if(document.fullscreenElement){(document.exitFullscreen()||Promise.resolve()).catch(()=>{});return;}
  if(!frame.requestFullscreen){toast('مرورگر شما از حالت تمام‌صفحه پشتیبانی نمی‌کند');return;}
  frame.requestFullscreen().catch(()=>toast('مرورگر شما از حالت تمام‌صفحه پشتیبانی نمی‌کند'));
 });
}

/* FAQ accordion for both old and new */
function accordions(){
 // old
 $$('[data-acc-t]').forEach(t=>{
  t.addEventListener('click',()=>{
   const body=t.parentElement.querySelector('.alp-acc-b');
   const open=t.classList.toggle('is-open');
   if(body) body.classList.toggle('is-open',open);
  });
 });
 // new React style
 $$('[data-faq] button').forEach(btn=>{
  btn.addEventListener('click',()=>{
   const item=btn.closest('[data-faq]');
   const ans=item.querySelector('.faq-answer');
   const isOpen=item.classList.contains('is-open');
   // close others
   $$('[data-faq]').forEach(i=>{
    i.classList.remove('is-open');
    const a=i.querySelector('.faq-answer'); if(a){a.classList.remove('faq-answer-open'); a.style.gridTemplateRows='0fr'; a.style.opacity='0';}
    const plus=i.querySelector('.icon-plus'); const minus=i.querySelector('.icon-minus');
    if(plus) plus.classList.remove('hidden'); if(minus) minus.classList.add('hidden');
    const b=i.querySelector('button'); if(b) b.setAttribute('aria-expanded','false');
   });
   if(!isOpen){
    item.classList.add('is-open');
    if(ans){ans.classList.add('faq-answer-open'); ans.style.gridTemplateRows='1fr'; ans.style.opacity='1';}
    const plus=item.querySelector('.icon-plus'); const minus=item.querySelector('.icon-minus');
    if(plus) plus.classList.add('hidden'); if(minus) minus.classList.remove('hidden');
    btn.setAttribute('aria-expanded','true');
   }
  });
 });
}

function giftOpts(){
 $$('[data-opt]').forEach(o=>o.addEventListener('click',()=>o.classList.toggle('is-on')));
}

function quantity(){
 const q=$('#alpQty'); if(!q) return;
 let n=1; const min=1,max=10;
 const apply=()=>{
  q.textContent=faNum(n);
  $$('[data-base]').forEach(a=>{
   let url=a.dataset.base||a.getAttribute('href')||'';
   url=url.replace(/([?&])quantity=\d*/,'$1quantity='+n);
   if(!/[?&]quantity=/.test(url)) url+=(url.includes('?')?'&':'?')+'quantity='+n;
   a.setAttribute('href',url);
  });
 };
 $$('[data-q]').forEach(b=>b.addEventListener('click',()=>{
  const dir=parseInt(b.dataset.q,10)||0;
  // note: in new design + is first button, - is last, but we support both
  // original had + as +1, - as -1; we keep same
  n=Math.min(max,Math.max(min,n+dir)); apply();
 }));
 apply();
}

function weights(){
 const buttons=$$('.weight-option, .alpm-wchips button, .alp-weights button'); if(!buttons.length) return;
 const priceEl=$('.alp-price-now, .alpm-pnow'); const single=priceEl?priceEl.dataset.single||'':'';
 buttons.forEach(b=>b.addEventListener('click',()=>{
  buttons.forEach(x=>{x.classList.remove('is-on'); x.classList.remove('border-gold-400','bg-gold-400/10','text-gold-300','shadow-[0_0_0_3px_rgba(247,179,43,0.15)]'); x.classList.add('border-white/10','bg-plum-900/60','text-lav'); x.setAttribute('aria-checked','false');});
  b.classList.add('is-on'); b.classList.add('border-gold-400','bg-gold-400/10','text-gold-300','shadow-[0_0_0_3px_rgba(247,179,43,0.15)]'); b.classList.remove('border-white/10','bg-plum-900/60','text-lav'); b.setAttribute('aria-checked','true');
  if(priceEl){
   const newPrice=b.dataset.price||'';
   if(newPrice) priceEl.innerHTML=newPrice;
   else if(single) priceEl.innerHTML=single;
  }
  const vid=parseInt(b.dataset.vid,10);
  if(vid>0)$$('[data-base]').forEach(a=>{
   let base=a.dataset.base||a.getAttribute('href')||'';
   base=base.replace(/add-to-cart=\d+/,'add-to-cart='+vid);
   a.dataset.base=base; a.setAttribute('href',base);
  });
 }));
}

function wishlistShare(){
 $$('[data-wish]').forEach(b=>{
  const lab=b.querySelector('[data-wish-label]');
  let pid=''; try{pid=String(($('#alpAdd')?.getAttribute('href')||'').match(/add-to-cart=(\d+)/)?.[1]||'');}catch(e){}
  try{
   const list=JSON.parse(localStorage.getItem('alookhor_wishlist')||'[]');
   if(pid&&list.includes(pid)){b.classList.add('is-on'); b.setAttribute('aria-pressed','true'); if(lab)lab.textContent='در علاقه‌مندی‌های شما';}
  }catch(e){}
  b.addEventListener('click',()=>{
   try{
    const set=new Set(JSON.parse(localStorage.getItem('alookhor_wishlist')||'[]'));
    const on=!b.classList.contains('is-on');
    b.classList.toggle('is-on',on); b.setAttribute('aria-pressed',on?'true':'false');
    if(pid){if(on)set.add(pid);else set.delete(pid); localStorage.setItem('alookhor_wishlist',JSON.stringify(Array.from(set)));}
    if(lab)lab.textContent=on?'در علاقه‌مندی‌های شما':'افزودن به علاقه‌مندی‌ها';
    toast(on?'به علاقه‌مندی‌های شما اضافه شد':'از علاقه‌مندی‌ها حذف شد');
   }catch(e){}
  });
 });
 $$('[data-compare]').forEach(b=>b.addEventListener('click',()=>toast('به لیست مقایسه اضافه شد')));
 $$('[data-share]').forEach(b=>b.addEventListener('click',async()=>{
  const data={title:b.dataset.name||document.title,url:b.dataset.url||location.href};
  try{
   if(navigator.share){await navigator.share(data);return;}
   await navigator.clipboard.writeText(data.url);
   toast('لینک محصول کپی شد');
  }catch(e){toast('لینک کپی شد');}
 }));
}

function sliders(){
 const bind=(trackSel,prevSel,nextSel)=>{
  const track=$(trackSel); if(!track) return;
  const prev=$(prevSel), next=$(nextSel);
  const step=310;
  if(prev) prev.addEventListener('click',()=>track.scrollBy({left:-step,behavior:'smooth'}));
  if(next) next.addEventListener('click',()=>track.scrollBy({left:step,behavior:'smooth'}));
 };
 bind('[data-htrack]','[data-hprev]','[data-hnext]');
 bind('[data-ptrack]','[data-pprev]','[data-pnext]');
 bind('[data-rtrack]','[data-rprev]','[data-rnext]');
}

function newsletter(){
 const form=$('[data-newsletter]'); if(!form) return;
 form.addEventListener('submit',e=>{
  e.preventDefault();
  const input=form.querySelector('input[type=email]'); const val=input?input.value.trim():'';
  if(!val||!val.includes('@')||!val.includes('.')){toast('لطفاً یک ایمیل معتبر وارد کنید');return;}
  if(input) input.value='';
  toast('عضویت شما در خبرنامه الخور با موفقیت انجام شد');
 });
 const cta=$('[data-review-cta]'); if(cta) cta.addEventListener('click',()=>toast('فرم ثبت نظر به‌زودی برای شما فعال می‌شود'));
}

function viewed(){
 const sec=$('#alpViewed'),rail=$('#alpViewedRail'); if(!sec||!rail) return;
 let list=[]; try{list=JSON.parse(localStorage.getItem('alookhor_rv')||'[]')}catch(e){}
 const name=$('.product-title-copy h1')?.textContent||$('.alpm-title')?.textContent||document.title;
 const img=$('#alpMain')?.src||'';
 const price=$('.alp-price-now')?.dataset?.single||'';
 const href=location.href;
 list=list.filter(v=>v&&v.u!==href);
 const html=(v)=>`<article class="alp-card"><a class="alp-card-img" href="${v.u}"><img src="${v.i}" alt="" loading="lazy"></a><div class="alp-card-body"><h3><a href="${v.u}">${v.n}</a></h3>${v.p?`<span class="alp-card-price">${v.p}</span>`:''}</div></article>`;
 if(list.length){sec.hidden=false;rail.innerHTML=list.map(html).join('');}
 if(name&&img) list.unshift({n:name,u:href,i:img,p:price});
 localStorage.setItem('alookhor_rv',JSON.stringify(list.slice(0,8)));
}

function boot(){gallery();fullscreen();accordions();giftOpts();quantity();weights();wishlistShare();sliders();newsletter();viewed();}
document.readyState==='loading'?document.addEventListener('DOMContentLoaded',boot):boot();
})();

/* ===== v3.10.247 — TABS + DESC EXPAND ===== */
function pdpTabs(){
  const wrap=document.querySelector('[data-pdp-tabs]'); if(!wrap) return;
  const tabs=Array.from(wrap.querySelectorAll('[data-pdp-tab]'));
  const panes=Array.from(wrap.querySelectorAll('[data-pdp-pane]'));
  if(!tabs.length||!panes.length) return;
  const activate=(id)=>{
    tabs.forEach(t=>{
      const on=t.dataset.pdpTab===id;
      t.classList.toggle('is-active',on);
      t.setAttribute('aria-selected',on?'true':'false');
    });
    panes.forEach(p=>{
      const on=p.dataset.pdpPane===id;
      p.classList.toggle('is-active',on);
      p.hidden=!on;
    });
    // scroll into view of tabs wrapper if needed (smooth)
    // wrap.scrollIntoView({behavior:'smooth',block:'start'});
  };
  tabs.forEach(t=>{
    t.addEventListener('click',()=>{
      const id=t.dataset.pdpTab;
      if(id) activate(id);
    });
  });
  // init hidden attr
  panes.forEach(p=>{ if(!p.classList.contains('is-active')) p.hidden=true; });
}

function descExpand(){
  const wrap=document.querySelector('[data-desc-wrap]');
  const content=document.querySelector('[data-desc-content]');
  const btn=document.querySelector('[data-desc-more]');
  if(!wrap||!content||!btn) return;
  // If content short, hide button
  const check=()=>{
    if(content.scrollHeight<=340){ btn.style.display='none'; wrap.classList.add('is-expanded'); }
  };
  check();
  btn.addEventListener('click',()=>{
    const expanded=wrap.classList.toggle('is-expanded');
    const label=btn.querySelector('.more-label');
    if(label) label.textContent=expanded?'مشاهده کمتر':'مشاهده بیشتر';
    if(expanded){
      // optional: scroll a bit
    }
  });
}

// extend boot
const _origBoot = typeof boot==='function'?boot:null;
if(typeof boot==='function'){
  const oldBoot=boot;
  // we already have boot defined above, so we hook via DOMContentLoaded again
}
document.addEventListener('DOMContentLoaded',()=>{ pdpTabs(); descExpand(); });
// also run immediately if DOM already loaded
if(document.readyState!=='loading'){ pdpTabs(); descExpand(); }
