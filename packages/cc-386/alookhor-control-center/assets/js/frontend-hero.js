/** ALOOKHOR managed Hero — four-slide responsive runtime and legacy replacement. */
(()=>{
  'use strict';
  const cfg=window.ALOOKHOR_HERO||{};
  const legacySelector=cfg.legacy_selector||'.alookhor-hero-slider-wrapper';
  const reduceMotion=window.matchMedia?.('(prefers-reduced-motion: reduce)');

  function mount(section){
    if(!section||section.dataset.mounted==='1')return;
    const slides=[...section.querySelectorAll('.alookhor-mh-slide')];
    const dots=[...section.querySelectorAll('.alookhor-mh-dots button')];
    const prev=section.querySelector('.alookhor-mh-arrow.is-prev');
    const next=section.querySelector('.alookhor-mh-arrow.is-next');
    const status=section.querySelector('.alookhor-mh-status');
    if(slides.length!==4)return;
    section.dataset.mounted='1';
    slides.forEach(slide=>slide.querySelector('img')?.setAttribute('draggable','false'));
    let index=Math.max(0,slides.findIndex(slide=>slide.classList.contains('is-active')));
    let timer=null,startX=0,startY=0;
    const interval=Math.max(3000,Math.min(15000,Number(section.dataset.interval)||5500));
    const canAuto=()=>section.dataset.autoplay==='1'&&!reduceMotion?.matches&&!document.hidden;

    function render(target,announce=false){
      index=(target+slides.length)%slides.length;
      slides.forEach((slide,i)=>{
        const active=i===index;
        slide.classList.toggle('is-active',active);
        slide.setAttribute('aria-hidden',active?'false':'true');
        slide.querySelectorAll('a,button').forEach(control=>control.tabIndex=active?0:-1);
      });
      dots.forEach((dot,i)=>{
        const active=i===index;
        dot.classList.toggle('is-active',active);
        dot.setAttribute('aria-selected',active?'true':'false');
        dot.tabIndex=active?0:-1;
      });
      if(announce&&status)status.textContent=`اسلاید ${index+1} از ۴`;
    }
    function stop(){if(timer){window.clearInterval(timer);timer=null}}
    function start(){
      stop();
      if(canAuto())timer=window.setInterval(()=>render(index+1),interval);
    }
    function go(target,announce=true){render(target,announce);start()}
    prev?.addEventListener('click',()=>go(index-1));
    next?.addEventListener('click',()=>go(index+1));
    dots.forEach((dot,i)=>dot.addEventListener('click',()=>go(i)));
    section.addEventListener('keydown',event=>{
      if(event.key==='ArrowLeft'){event.preventDefault();go(index+1)}
      if(event.key==='ArrowRight'){event.preventDefault();go(index-1)}
      if(event.key==='Home'){event.preventDefault();go(0)}
      if(event.key==='End'){event.preventDefault();go(3)}
    });
    section.addEventListener('pointerdown',event=>{startX=event.clientX;startY=event.clientY},{passive:true});
    section.addEventListener('pointerup',event=>{
      const dx=event.clientX-startX,dy=event.clientY-startY;
      if(Math.abs(dx)>45&&Math.abs(dx)>Math.abs(dy)*1.25)go(index+(dx<0?1:-1));
    },{passive:true});
    if(section.dataset.pauseHover==='1'){
      section.addEventListener('mouseenter',stop);
      section.addEventListener('mouseleave',start);
      section.addEventListener('focusin',stop);
      section.addEventListener('focusout',event=>{if(!section.contains(event.relatedTarget))start()});
    }
    const visibility=()=>document.hidden?stop():start();
    document.addEventListener('visibilitychange',visibility);
    reduceMotion?.addEventListener?.('change',start);
    section._alookhorHeroCleanup=()=>{stop();document.removeEventListener('visibilitychange',visibility);reduceMotion?.removeEventListener?.('change',start)};
    render(index);
    start();
  }

  function markSlot(node){
    const slot=node.closest('.elementor-widget-shortcode,.elementor-widget')||node.parentElement;
    slot?.classList.add('alookhor-managed-hero-slot');
  }
  function place(section){
    const legacy=document.querySelector(legacySelector);
    if(!legacy)return false;
    markSlot(legacy);
    legacy.replaceWith(section);
    mount(section);
    return true;
  }
  function parseMarkup(html){
    const template=document.createElement('template');
    template.innerHTML=String(html||'').trim();
    const section=template.content.firstElementChild;
    return section?.matches?.('#alookhor-managed-hero')&&section.querySelectorAll('.alookhor-mh-slide').length===4?section:null;
  }
  async function refresh(){
    if(!cfg.endpoint)return;
    try{
      const url=new URL(cfg.endpoint,location.href);
      if(url.origin!==location.origin)throw Error('Hero endpoint origin mismatch');
      url.searchParams.set('_alookhor',Date.now());
      const response=await fetch(url,{cache:'no-store',credentials:'same-origin',headers:{Accept:'application/json'}});
      if(!response.ok)throw Error(`HTTP ${response.status}`);
      const data=await response.json();
      if(String(data.version)!==String(cfg.version)||data.slide_count!==4)throw Error('Hero state mismatch');
      const fresh=parseMarkup(data.html);
      if(!fresh)throw Error('Hero markup invalid');
      const current=document.querySelector('#alookhor-managed-hero');
      if(current){
        markSlot(current);
        current._alookhorHeroCleanup?.();
        current.replaceWith(fresh);
        mount(fresh);
      }else{
        place(fresh);
      }
    }catch(error){
      console.warn('ALOOKHOR Hero refresh failed; server template remains active.',error);
    }
  }
  function start(){
    document.body?.classList.add('alookhor-mh-enabled');
    if(cfg.hide_legacy)document.body?.classList.add('alookhor-mh-hide-legacy');
    const template=document.querySelector('#alookhor-managed-hero-template');
    const current=document.querySelector('#alookhor-managed-hero');
    if(current){markSlot(current);mount(current)}
    else if(template){
      const section=template.content.firstElementChild?.cloneNode(true);
      if(section)place(section);
    }
    template?.remove();
    refresh();
  }
  // The footer script runs after Elementor Home markup and the managed template,
  // so replacement can happen immediately without waiting for window.load.
  if(document.body)start();
  else document.addEventListener('DOMContentLoaded',start,{once:true});
})();
