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

/* gallery: support both old .alpm-thumbs and new .gallery-thumbs — v3.10.357 zoom on hover + auto-rotate every 4s */
function gallery(){
 const stage=$('#alpMain');
 const frame=$('[data-stage]') || (stage ? stage.closest('[data-stage], .gallery-frame') : null) || $('.gallery-frame');
 const thumbs=$$('.gallery-thumbs button, .alpm-thumbs button, .gallery-thumb');
 if(!stage||!thumbs.length) return;
 const num=$('[data-gal-num]');
 let idx=0;
 const AUTOPLAY_MS=4000;
 const RESUME_AFTER=6000;
 let autoTimer=0;
 let autoPausedUntil=0;
 const pauseAuto=()=>{ autoPausedUntil=Date.now()+RESUME_AFTER; };
 const show=i=>{
  idx=(i+thumbs.length)%thumbs.length;
  const t=thumbs[idx]; if(!t) return;
  thumbs.forEach(b=>{b.classList.remove('is-on'); b.classList.remove('border-gold-400'); b.classList.add('border-white/10'); b.classList.remove('shadow-[0_0_0_3px_rgba(247,179,43,0.25)]');});
  t.classList.add('is-on');
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
 const tick=()=>{
  if(Date.now()<autoPausedUntil) return;
  if(document.hidden) return;
  if(frame && frame.matches && frame.matches(':hover')) return;
  show(idx+1);
 };
 const startAuto=()=>{ stopAuto(); if(thumbs.length>1) autoTimer=setInterval(tick, AUTOPLAY_MS); };
 const stopAuto=()=>{ if(autoTimer){ clearInterval(autoTimer); autoTimer=0; } };
 thumbs.forEach((t,i)=>t.addEventListener('click',()=>{ pauseAuto(); show(i); }));
 $$('[data-gal-prev]').forEach(b=>b.addEventListener('click',()=>{ pauseAuto(); show(idx-1); }));
 $$('[data-gal-next]').forEach(b=>b.addEventListener('click',()=>{ pauseAuto(); show(idx+1); }));
 // zoom on hover — desktop only
 if(frame && stage){
  let isZooming=false;
  const mqTouch=window.matchMedia && window.matchMedia('(max-width:1024px)');
  const isTouchDevice = mqTouch ? mqTouch.matches : false;
  if(!isTouchDevice){
   frame.addEventListener('mouseenter',()=>{
    frame.classList.add('is-zooming');
    stage.style.transform='scale(2)';
    pauseAuto();
    isZooming=true;
   });
   frame.addEventListener('mousemove',(e)=>{
    if(!isZooming) return;
    const rect=frame.getBoundingClientRect();
    const x=((e.clientX-rect.left)/rect.width)*100;
    const y=((e.clientY-rect.top)/rect.height)*100;
    stage.style.transformOrigin=x.toFixed(2)+'% '+y.toFixed(2)+'%';
   });
   frame.addEventListener('mouseleave',()=>{
    frame.classList.remove('is-zooming');
    stage.style.transform='';
    stage.style.transformOrigin='';
    isZooming=false;
   });
  }
  ['pointerdown','wheel','touchstart'].forEach(ev=>frame.addEventListener(ev, pauseAuto, {passive:true}));
 }
 document.addEventListener('visibilitychange',()=>{
  if(document.hidden) stopAuto(); else startAuto();
 });
 startAuto();
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

/* v3.10.354: quantity + cart URL builder - preserves variation */
let _alpQty=1;
let _alpCurrent={vid:0,parent:'',attrKey:'',attrVal:''};
function _alpBuildUrl(qty){
  qty = qty || _alpQty || 1;
  const cur = _alpCurrent;
  const vid = parseInt(cur.vid||0,10);
  const parent = cur.parent||'';
  const attrKey = cur.attrKey||'';
  const attrVal = cur.attrVal||'';
  // If variable with vid+parent, build proper Woo URL
  if(vid>0 && parent){
    const basePath = (location.pathname || '/');
    const params = new URLSearchParams();
    params.set('add-to-cart', parent);
    params.set('variation_id', String(vid));
    if(attrKey && attrVal){
      let k = attrKey;
      if(k.indexOf('attribute_')!==0) k='attribute_'+k;
      params.set(k, attrVal);
    }
    params.set('quantity', String(qty));
    return basePath + '?' + params.toString();
  } else if(vid>0){
    const basePath = (location.pathname || '/');
    const params = new URLSearchParams();
    params.set('add-to-cart', String(vid));
    params.set('quantity', String(qty));
    return basePath + '?' + params.toString();
  } else {
    // simple: use data-base
    const a0 = document.querySelector('[data-base]');
    let url = (a0 && (a0.dataset.base||a0.getAttribute('href')))||location.href;
    // strip existing quantity and rebuild
    url = url.replace(/([?&])quantity=\d*/,'$1').replace(/[?&]$/,'').replace(/\?$/,'');
    // also keep add-to-cart if present
    if(qty){
      if(/[?&]quantity=\d+/.test(url)) url=url.replace(/([?&])quantity=\d+/, '$1quantity='+qty);
      else url+=(url.indexOf('?')>-1?'&':'?')+'quantity='+qty;
    }
    return url;
  }
}
function _alpApplyQty(){
  const q=$('#alpQty'); if(q) q.textContent=faNum(_alpQty);
  const url = _alpBuildUrl(_alpQty);
  $$('[data-base]').forEach(a=>{
    // keep base for reference but href is built
    a.setAttribute('href',url);
  });
}
function quantity(){
 const q=$('#alpQty'); if(!q) return;
 const min=1,max=10;
 _alpQty=1;
 const apply=()=>{ _alpApplyQty(); };
 $$('[data-q]').forEach(b=>b.addEventListener('click',()=>{
  const raw=String(b.dataset.q||'').trim(); const dir=raw==='+'?1:(raw==='-'||raw==='\u2212')?-1:(parseInt(raw,10)||0);
  _alpQty=Math.min(max,Math.max(min,_alpQty+dir)); apply();
 }));
 apply();
}

function weights(){
 const buttons=$$('.weight-option, .alpm-wchips button, .alp-weights button'); if(!buttons.length) return;
 const priceEl=$('.alp-price-now, .alpm-pnow'); const single=priceEl?priceEl.dataset.single||'':'';
 const priceBox=priceEl?priceEl.closest('.price-box'):null;
 const oldEl=priceBox?priceBox.querySelector('.line-through'):null;
 const select=(b,init)=>{
  if(!b) return;
  buttons.forEach(x=>{x.classList.remove('is-on'); x.classList.remove('border-gold-400','bg-gold-400/10','text-gold-300','shadow-[0_0_0_3px_rgba(247,179,43,0.15)]'); x.classList.add('border-white/10','bg-plum-900/60','text-lav'); x.setAttribute('aria-checked','false');});
  b.classList.add('is-on'); b.classList.add('border-gold-400','bg-gold-400/10','text-gold-300','shadow-[0_0_0_3px_rgba(247,179,43,0.15)]'); b.classList.remove('border-white/10','bg-plum-900/60','text-lav'); b.setAttribute('aria-checked','true');
  if(priceEl){
   const newPrice=b.dataset.price||'';
   if(newPrice) priceEl.innerHTML=newPrice;
   else if(single) priceEl.innerHTML=single;
   if(oldEl){
     const reg=b.dataset.regular||'';
     if(reg){ oldEl.innerHTML=reg; oldEl.style.display=''; }
     else { oldEl.innerHTML=''; oldEl.style.display='none'; }
   }
  }
  const vid=parseInt(b.dataset.vid||b.dataset.id||'0',10);
  const parent=b.dataset.parent||b.getAttribute('data-parent')||'';
  const attrKey=b.dataset.attrKey||b.dataset.attrkey||b.getAttribute('data-attr-key')||'';
  const attrVal=b.dataset.attrVal||b.dataset.attrval||b.getAttribute('data-attr-val')||'';
  _alpCurrent={vid:vid,parent:parent,attrKey:attrKey,attrVal:attrVal};
  // update data-base to keep reference but href is built via _alpBuildUrl
  const newUrl=_alpBuildUrl(_alpQty);
  $$('[data-base]').forEach(a=>{
    // store the clean base without quantity for future
    let baseForStore = newUrl.replace(/([?&])quantity=\d+/,'').replace(/[?&]$/,'');
    a.dataset.base=baseForStore;
    a.setAttribute('href',newUrl);
  });
 };
 buttons.forEach(b=>b.addEventListener('click',()=>select(b,false)));
 // v3.10.354: auto-init first weight on load so add-to-cart works without extra click
 let first = buttons.find(x=>x.getAttribute('aria-checked')==='true') || buttons[0];
 if(first){ select(first,true); }
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
  /* v3.10.318: arrows follow the writing direction (RTL: "next" = scroll left, "prev" = scroll right; before, both
     were inverted on RTL rails) and on phones (<=640px, where the rails are 1-card sliders) step = one card + gap. */
  const phone=window.matchMedia?window.matchMedia('(max-width:640px)'):null;
  const stepOf=()=>{ if(phone&&phone.matches){ const c=track.firstElementChild; if(c){ const g=parseFloat(getComputedStyle(track).columnGap)||10; return c.getBoundingClientRect().width+g; } } return 310; };
  const sign=()=>getComputedStyle(track).direction==='rtl'?-1:1;
  if(prev) prev.addEventListener('click',()=>track.scrollBy({left:-stepOf()*sign(),behavior:'smooth'}));
  if(next) next.addEventListener('click',()=>track.scrollBy({left:stepOf()*sign(),behavior:'smooth'}));
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

/* ===== v3.10.311 — MOBILE (<=1279px) ONLY: usage / FAQ / reviews are always-visible standalone sections on phones
   (mockup-2), so their tab buttons scroll to them; description <-> specs still swap. Guarded by matchMedia — on
   desktop this listener returns before the original tab handler runs, so desktop behaviour is untouched. ===== */
(function(){
  if(!window.matchMedia) return;
  var mq=window.matchMedia('(max-width:1279px)');
  var wrap=document.querySelector('[data-pdp-tabs]'); if(!wrap) return;
  var tabs=Array.prototype.slice.call(wrap.querySelectorAll('[data-pdp-tab]'));
  var panes=Array.prototype.slice.call(wrap.querySelectorAll('[data-pdp-pane]'));
  if(!tabs.length||!panes.length) return;
  var STANDALONE={usage:1,faq:1,reviews:1};
  function paneOf(id){ return wrap.querySelector('[data-pdp-pane="'+id+'"]'); }
  function mobileSync(){ panes.forEach(function(p){ if(STANDALONE[p.getAttribute('data-pdp-pane')]) p.hidden=false; }); }
  function restore(){
    var act=tabs.filter(function(t){ return t.classList.contains('is-active'); })[0];
    var id=act?act.getAttribute('data-pdp-tab'):panes[0].getAttribute('data-pdp-pane');
    panes.forEach(function(p){ var on=p.getAttribute('data-pdp-pane')===id; p.classList.toggle('is-active',on); p.hidden=!on; });
  }
  tabs.forEach(function(t){
    t.addEventListener('click',function(e){
      if(!mq.matches) return;
      e.stopImmediatePropagation();
      var id=t.getAttribute('data-pdp-tab');
      if(STANDALONE[id]){
        var p=paneOf(id);
        if(p){ p.hidden=false; if(p.scrollIntoView) p.scrollIntoView({behavior:'smooth',block:'start'}); }
        return;
      }
      tabs.forEach(function(x){ if(STANDALONE[x.getAttribute('data-pdp-tab')]) return; var on=x===t; x.classList.toggle('is-active',on); x.setAttribute('aria-selected',on?'true':'false'); });
      panes.forEach(function(p){ if(STANDALONE[p.getAttribute('data-pdp-pane')]) return; var on=p.getAttribute('data-pdp-pane')===id; p.classList.toggle('is-active',on); p.hidden=!on; });
    },true);
  });
  function sync(){ if(mq.matches) mobileSync(); else restore(); }
  if(document.readyState==='loading') document.addEventListener('DOMContentLoaded',function(){ setTimeout(sync,0); }); else setTimeout(sync,0);
  if(mq.addEventListener) mq.addEventListener('change',sync); else if(mq.addListener) mq.addListener(sync);
})();

/* ===== v3.10.311 — make the existing "مشاهده بیشتر" button work: markup uses data-desc-toggle while descExpand()
   only knows data-desc-more, so the button did nothing. Behaviour only — nothing changes until it is clicked. ===== */
(function(){
  var btn=document.querySelector('[data-desc-toggle]'), wrap=document.querySelector('[data-desc-wrap]');
  if(!btn||!wrap) return;
  btn.addEventListener('click',function(){
    var on=wrap.classList.toggle('is-expanded');
    btn.textContent=on?'مشاهده کمتر':'مشاهده بیشتر';
    btn.setAttribute('aria-expanded',on?'true':'false');
  });
})();


/* ===== v3.10.323 — PHONE (<=640px) ONLY: the two product rails («محصولات پیشنهادی», «گزیده‌ای از بهترین…») auto-advance
   one card every second (owner request). Pauses while the user touches/drags the rail or taps an arrow (resumes 3 s
   later), while the rail is off-screen and while the tab is hidden; loops back to the first card at the end.
   Desktop/tablet: nothing runs (their rails are static grids). ===== */
(function(){
 if(!window.matchMedia) return;
 var mq=window.matchMedia('(max-width:640px)');
 var INTERVAL=1000, RESUME_AFTER=3000;
 var tracks=Array.prototype.slice.call(document.querySelectorAll('[data-htrack],[data-ptrack]'));
 if(!tracks.length) return;
 tracks.forEach(function(track){
  var timer=0, holdUntil=0, touching=false, visible=true;
  var shell=track.closest?track.closest('.slider-shell'):track.parentElement;
  function step(){
   var c=track.firstElementChild; if(!c) return;
   var gap=parseFloat(getComputedStyle(track).columnGap)||10;
   var w=c.getBoundingClientRect().width+gap;
   var max=track.scrollWidth-track.clientWidth;
   var pos=Math.abs(track.scrollLeft);
   var rtl=getComputedStyle(track).direction==='rtl';
   if(pos>=max-2){ track.scrollTo({left:0,behavior:'smooth'}); return; }
   track.scrollBy({left:(rtl?-1:1)*w,behavior:'smooth'});
  }
  function tick(){
   if(!mq.matches||touching||!visible||document.hidden||Date.now()<holdUntil) return;
   if(track.scrollWidth<=track.clientWidth+2) return;
   step();
  }
  function start(){ if(!timer) timer=setInterval(tick,INTERVAL); }
  function stop(){ if(timer){ clearInterval(timer); timer=0; } }
  function hold(){ holdUntil=Date.now()+RESUME_AFTER; }
  track.addEventListener('touchstart',function(){ touching=true; hold(); },{passive:true});
  track.addEventListener('touchend',function(){ touching=false; hold(); },{passive:true});
  track.addEventListener('touchcancel',function(){ touching=false; hold(); },{passive:true});
  track.addEventListener('pointerdown',hold,{passive:true});
  track.addEventListener('wheel',hold,{passive:true});
  if(shell){ Array.prototype.forEach.call(shell.querySelectorAll('.slider-control'),function(b){ b.addEventListener('click',hold); }); }
  if('IntersectionObserver' in window){
   try{ new IntersectionObserver(function(es){ es.forEach(function(e){ visible=e.isIntersecting; }); },{threshold:0.3}).observe(track); }catch(e){}
  }
  function sync(){ if(mq.matches) start(); else stop(); }
  sync();
  if(mq.addEventListener) mq.addEventListener('change',sync); else if(mq.addListener) mq.addListener(sync);
 });
})();
