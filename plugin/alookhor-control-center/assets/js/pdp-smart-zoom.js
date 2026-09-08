(()=>{'use strict';
const init=()=>{
  const frames=Array.from(document.querySelectorAll('.gallery-frame[data-stage], .gallery-frame'));
  if(!frames.length) return;
  const finePointer=window.matchMedia && window.matchMedia('(pointer:fine)').matches;
  const clamp=(v,min,max)=>Math.max(min,Math.min(max,v));
  frames.forEach(frame=>{
    if(frame.dataset.alookhorSmartZoom==='1') return;
    const img=frame.querySelector('#alpMain, img');
    if(!img) return;
    frame.dataset.alookhorSmartZoom='1';
    let zoom=1;
    let active=false;
    let touchZoom=false;
    let lastTouchDistance=0;
    const setOrigin=(clientX,clientY)=>{
      const r=frame.getBoundingClientRect();
      const x=clamp(((clientX-r.left)/r.width)*100,0,100);
      const y=clamp(((clientY-r.top)/r.height)*100,0,100);
      img.style.transformOrigin=`${x.toFixed(2)}% ${y.toFixed(2)}%`;
    };
    const render=()=>{
      if(zoom<=1.01){
        active=false; touchZoom=false;
        frame.classList.remove('alookhor-zoom-active');
        img.style.transform='';
        img.style.transformOrigin='';
        img.style.cursor=finePointer?'zoom-in':'';
        return;
      }
      active=true;
      frame.classList.add('alookhor-zoom-active');
      img.style.transform=`scale(${zoom.toFixed(2)})`;
      img.style.cursor='zoom-out';
    };
    const enter=()=>{
      if(!finePointer) return;
      zoom=2.8;
      render();
    };
    const move=e=>{
      if(!active) return;
      if(e.pointerType==='mouse' || e.pointerType==='pen') setOrigin(e.clientX,e.clientY);
    };
    const leave=()=>{
      if(!finePointer) return;
      zoom=1;
      render();
    };
    frame.addEventListener('mouseenter',enter);
    frame.addEventListener('mousemove',move);
    frame.addEventListener('mouseleave',leave);
    frame.addEventListener('wheel',e=>{
      if(!finePointer) return;
      const target=e.target;
      if(target.closest && target.closest('button')) return;
      e.preventDefault();
      if(!active) { zoom=2.8; render(); }
      zoom=clamp(zoom+(e.deltaY<0?.35:-.35),1,4.6);
      setOrigin(e.clientX,e.clientY);
      render();
    },{passive:false});
    frame.addEventListener('pointerdown',e=>{
      if(e.target.closest && e.target.closest('button')) return;
      if(e.pointerType==='touch'){
        if(!touchZoom){
          touchZoom=true; zoom=2.8; render(); setOrigin(e.clientX,e.clientY);
        }
      }
    });
    frame.addEventListener('pointermove',e=>{
      if(e.pointerType==='touch' && touchZoom){
        setOrigin(e.clientX,e.clientY);
      }
    });
    frame.addEventListener('pointerup',e=>{
      if(e.pointerType==='touch' && touchZoom){
        // A short second tap resets; normal touch movement stays zoomed for inspection.
        if(e.target===img && Math.abs(e.movementX||0)<3 && Math.abs(e.movementY||0)<3){
          zoom=1; render();
        }
      }
    });
    frame.addEventListener('pointercancel',()=>{if(touchZoom){zoom=1;render();}});
    frame.addEventListener('touchstart',e=>{
      if(e.touches.length===2){
        lastTouchDistance=Math.hypot(e.touches[0].clientX-e.touches[1].clientX,e.touches[0].clientY-e.touches[1].clientY);
        touchZoom=true; if(zoom<2.2) zoom=2.8; render();
      }
    },{passive:true});
    frame.addEventListener('touchmove',e=>{
      if(e.touches.length===2){
        const d=Math.hypot(e.touches[0].clientX-e.touches[1].clientX,e.touches[0].clientY-e.touches[1].clientY);
        if(lastTouchDistance){zoom=clamp(zoom+(d-lastTouchDistance)*.012,1,4.6);render();}
        lastTouchDistance=d;
      }
    },{passive:true});
    frame.addEventListener('touchend',()=>{lastTouchDistance=0;});
    img.style.willChange='transform';
    img.style.transformOrigin='50% 50%';
    img.style.transition='transform .16s cubic-bezier(.2,.7,.2,1)';
    img.style.cursor=finePointer?'zoom-in':'';
  });
};
if(document.readyState==='loading') document.addEventListener('DOMContentLoaded',init); else init();
})();
