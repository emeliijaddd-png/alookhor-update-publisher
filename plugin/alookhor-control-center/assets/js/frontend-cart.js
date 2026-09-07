/* ALOOKHOR CART — v3.10.348 - kill white top bar "سبد خرید" */
(function(){
  function killWhite(){
    var lux=document.getElementById("alookhor-cart");
    if(!lux) return;
    var sels=[".wd-page-title",".wd-page-title.wd-style-default",".wd-page-title.wd-style-centered",".page-title",".entry-header",".wd-page-heading",".page-heading",".wd-checkout-steps",".wd-checkout-steps-wrapper",".wd-entities-title",".title-design-default",".title-design-centered",".whb-page-title",".woocommerce-breadcrumb",".wd-breadcrumbs",".woocommerce-cart-form",".cart-collaterals",".shop_table",".wd-cart",".wd-empty-cart",".cart-empty",".return-to-shop","[class*=\"wd-empty\"]"];
    sels.forEach(function(sel){
      document.querySelectorAll(sel).forEach(function(el){
        if(el.closest("#alookhor-cart")||el.closest("header")||el.closest("footer")||el.closest(".whb-header"))return;
        el.style.setProperty("display","none","important");
        el.style.setProperty("visibility","hidden","important");
        el.style.setProperty("height","0","important");
        el.style.setProperty("margin","0","important");
        el.style.setProperty("padding","0","important");
      });
    });
    document.querySelectorAll("div,section,h1,h2").forEach(function(el){
      if(el.closest("#alookhor-cart")||el.closest("header")||el.closest("footer"))return;
      var txt=(el.innerText||el.textContent||"").trim();
      if(txt==="سبد خرید"){
        el.style.setProperty("display","none","important");
        var p=el.parentElement;
        for(var i=0;i<4&&p;i++){
          if(p.closest("#alookhor-cart"))break;
          var pcs=window.getComputedStyle(p);
          if(pcs.backgroundColor==="rgb(255, 255, 255)"||p.className.indexOf("page-title")>-1||p.className.indexOf("wd-page")>-1||p.className.indexOf("whb-page")>-1){
            p.style.setProperty("display","none","important");
          }
          p=p.parentElement;
        }
      }
    });
    document.body.style.setProperty("background","#0d0510","important");
    var wrappers=document.querySelectorAll(".main-page-wrapper, .site-content, .wd-page-content, .container, .wd-content-area, .woocommerce");
    wrappers.forEach(function(w){
      if(w.closest("#alookhor-cart"))return;
      w.style.setProperty("background","transparent","important");
    });
  }
  killWhite();
  document.addEventListener("DOMContentLoaded",killWhite);
  window.addEventListener("load",killWhite);
  new MutationObserver(killWhite).observe(document.body,{childList:true,subtree:true});
  setTimeout(killWhite,100);
  setTimeout(killWhite,500);
  setTimeout(killWhite,1500);
  setTimeout(killWhite,3000);
})();

