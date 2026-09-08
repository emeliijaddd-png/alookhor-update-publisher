/* ALOOKHOR CART — v3.10.360 — hide old white Woodmart bars, keep luxury cart */
(function(){
  function hideOld(){
    try{
      var sel=[
        '.wd-page-title',' .whb-page-title','.wd-entities-title',
        '.wd-page-title.wd-style-default','.wd-page-title.wd-style-centered',
        '.page-title','.entry-header','.wd-page-heading','.page-heading',
        '.title-design-default','.title-design-centered',
        '.wd-checkout-steps','.wd-checkout-steps-wrapper',
        '.woocommerce-breadcrumb','.wd-breadcrumbs','.breadcrumbs','.wd-title'
      ];
      // hide only if contains سبد خرید or is white rounded bar
      document.querySelectorAll('.wd-page-title,.whb-page-title,.page-title,.entry-header,.wd-page-heading').forEach(function(el){
        if(!el) return;
        if(el.closest('#alookhor-cart')) return;
        var t=(el.textContent||'').trim();
        var bg=getComputedStyle(el).backgroundColor||'';
        var isWhite = bg.indexOf('255, 255, 255')!==-1 || bg==='rgb(255, 255, 255)' || bg==='white';
        var isCartTitle = t==='سبد خرید' || t.indexOf('سبد خرید')!==-1;
        var w=el.offsetWidth||0;
        var isSmallWhite = isWhite && w>150 && w<600;
        if(isCartTitle || isSmallWhite){
          el.style.display='none';
          el.style.visibility='hidden';
          el.style.height='0';
          el.style.overflow='hidden';
          el.style.margin='0';
          el.style.padding='0';
        }
      });
      // hide any white rect 150-500px width that is not our cart
      document.querySelectorAll('div,section').forEach(function(el){
        if(!el || el.closest('#alookhor-cart') || el.id==='alookhor-cart' || el.id==='alookhor-cart-main') return;
        var bg=getComputedStyle(el).backgroundColor||'';
        if((bg==='rgb(255, 255, 255)'||bg==='white') && el.offsetWidth>=150 && el.offsetWidth<=500 && el.offsetHeight>=30 && el.offsetHeight<=200){
          var t=(el.textContent||'').trim();
          if(t.length<50){
            el.style.display='none';
          }
        }
      });
    }catch(e){}
  }
  document.addEventListener('DOMContentLoaded',function(){
    console.log('ALOOKHOR Cart v3.10.360 loaded');
    hideOld();
    setTimeout(hideOld,300);
    setTimeout(hideOld,1000);
  });
})();
