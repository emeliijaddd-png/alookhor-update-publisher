/* ALOOKHOR CART — v3.10.362 — minimal white pill hide, cart always visible */
(function(){
  function hideWhitePill(){
    try{
      // Only hide small white pill with exact text سبد خرید
      document.querySelectorAll('.wd-page-title,.whb-page-title,.page-title,.entry-header,.wd-page-heading,.wd-checkout-steps').forEach(function(el){
        if(el.closest('#alookhor-cart')||el.closest('header')||el.closest('footer')||el.closest('.whb-header')) return;
        // hide only if it's white bar or checkout steps
        el.style.setProperty('display','none','important');
      });
      // Hide any div with exact text سبد خرید and white bg and small size
      document.querySelectorAll('div,section').forEach(function(el){
        if(el.closest('#alookhor-cart')||el.closest('header')||el.closest('footer')||el.closest('.whb-header')||el.id==='alookhor-cart'||el.id==='alookhor-cart-main') return;
        var t=(el.textContent||'').trim();
        if(t==='سبد خرید' && el.offsetWidth>100 && el.offsetWidth<600 && el.offsetHeight<200){
          el.style.setProperty('display','none','important');
        }
        try{
          var bg=getComputedStyle(el).backgroundColor||'';
          if(bg.indexOf('255, 255, 255')!==-1 && t==='سبد خرید' && !el.closest('#alookhor-cart')){
            el.style.setProperty('display','none','important');
          }
        }catch(e){}
      });
      // Ensure cart visible
      var cart=document.getElementById('alookhor-cart');
      if(cart){
        cart.style.setProperty('display','block','important');
        cart.style.setProperty('visibility','visible','important');
        cart.style.setProperty('opacity','1','important');
      }
      document.body.style.background='#0d0510';
    }catch(e){}
  }
  document.addEventListener('DOMContentLoaded',function(){
    console.log('ALOOKHOR Cart v3.10.362 loaded');
    hideWhitePill();
    setTimeout(hideWhitePill,300);
    setTimeout(hideWhitePill,1000);
  });
})();
