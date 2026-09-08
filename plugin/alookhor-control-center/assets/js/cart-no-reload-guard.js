/* ALOOKHOR Cart Guard v3.10.371 — block legacy reload-based cart handlers before they register. */
(function(){
  'use strict';
  var OLD_MARKERS=['wc-ajax=update_cart','wc-ajax=remove_from_cart','location.reload()'];
  function isLegacy(fn){
    if(typeof fn!=='function') return false;
    var src='';
    try{src=Function.prototype.toString.call(fn);}catch(e){}
    return OLD_MARKERS.some(function(marker){return src.indexOf(marker)!==-1;});
  }
  var nativeAdd=EventTarget.prototype.addEventListener;
  EventTarget.prototype.addEventListener=function(type,listener,options){
    if(type==='DOMContentLoaded' && isLegacy(listener)) return;
    return nativeAdd.call(this,type,listener,options);
  };
  function cleanup(){
    document.querySelectorAll('script').forEach(function(script){
      var text=script.textContent||'';
      if(text.indexOf('wc-ajax=update_cart')!==-1 || text.indexOf('wc-ajax=remove_from_cart')!==-1) script.remove();
    });
    var inline=document.getElementById('alookhor-cart-inline');
    if(inline && document.querySelector('link[href*="frontend-cart.css"]')) inline.remove();
  }
  if(document.readyState==='loading') nativeAdd.call(document,'DOMContentLoaded',cleanup,{once:true});
  else cleanup();
})();
