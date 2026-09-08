/* ALOOKHOR CART — v3.10.361 — aggressive white hide, footer safe */
(function(){
  function hideOld(){
    try{
      var sels=[".wd-page-title",".whb-page-title",".wd-entities-title",".wd-page-title.wd-style-default",".wd-page-title.wd-style-centered",".whb-page-title .container",".wd-page-title .container",".page-title",".entry-header",".wd-page-heading",".page-heading",".title-design-default",".title-design-centered",".wd-checkout-steps",".wd-checkout-steps-wrapper",".woocommerce-breadcrumb",".wd-breadcrumbs",".breadcrumbs",".wd-title","[class*=\"page-title\"]","[class*=\"wd-entities\"]"];
      sels.forEach(function(sel){
        document.querySelectorAll(sel).forEach(function(el){
          if(el.closest('#alookhor-cart')||el.closest('header')||el.closest('footer')||el.closest('.whb-header')||el.closest('#alookhor-cart-main')) return;
          el.style.setProperty('display','none','important');
          el.style.setProperty('visibility','hidden','important');
          el.style.setProperty('height','0','important');
          el.style.setProperty('overflow','hidden','important');
          el.style.setProperty('margin','0','important');
          el.style.setProperty('padding','0','important');
        });
      });
      // hide any element with exact text سبد خرید that is white pill
      document.querySelectorAll('div,section,header,main').forEach(function(el){
        if(el.closest('#alookhor-cart')||el.closest('header')||el.closest('footer')||el.closest('.whb-header')||el.closest('#alookhor-cart-main')) return;
        var t=(el.textContent||'').trim();
        if(t==='سبد خرید' && el.children.length<=3){
          el.style.setProperty('display','none','important');
          if(el.parentElement && !el.parentElement.closest('#alookhor-cart')) el.parentElement.style.setProperty('display','none','important');
        }
        try{
          var bg=getComputedStyle(el).backgroundColor||'';
          if((bg.indexOf('255, 255, 255')!==-1||bg==='rgb(255, 255, 255)'||bg==='white') && t.indexOf('سبد خرید')>-1){
            if(!el.closest('#alookhor-cart')) el.style.setProperty('display','none','important');
          }
          // white rect 150-500 width
          if(el.offsetWidth>=150 && el.offsetWidth<=500 && el.offsetHeight>=20 && el.offsetHeight<=300){
            if((bg==='rgb(255, 255, 255)'||bg==='white'||bg.indexOf('255, 255, 255')!==-1) && t.length<100){
              if(!el.closest('#alookhor-cart')&&!el.closest('header')&&!el.closest('footer')){
                el.style.setProperty('display','none','important');
              }
            }
          }
        }catch(e){}
      });
      document.body.style.background='#0d0510';
      document.documentElement.style.background='#0d0510';
    }catch(e){}
  }
  document.addEventListener('DOMContentLoaded',function(){
    console.log('ALOOKHOR Cart v3.10.361 loaded');
    hideOld();
    setTimeout(hideOld,200);
    setTimeout(hideOld,600);
    setTimeout(hideOld,1500);
    setTimeout(hideOld,3000);
    new MutationObserver(hideOld).observe(document.body,{childList:true,subtree:true});
  });
})();
