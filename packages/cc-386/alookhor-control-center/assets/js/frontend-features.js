/** ALOOKHOR managed four-card site-features runtime. */
(()=>{
  'use strict';
  const cfg=window.ALOOKHOR_FEATURES||{};
  const legacySelector=cfg.legacy_selector||'.alookhor-trustbar-container';

  function mount(section){
    if(!section||section.dataset.mounted==='1')return;
    if(section.querySelectorAll('.alookhor-sf-card').length!==4)return;
    section.dataset.mounted='1';
  }
  function markSlot(node){
    const slot=node.closest('.elementor-widget-html,.elementor-widget')||node.parentElement;
    slot?.classList.add('alookhor-managed-features-slot');
    slot?.closest('.e-con')?.classList.add('alookhor-managed-features-host');
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
    return section?.matches?.('#alookhor-managed-features')&&section.querySelectorAll('.alookhor-sf-card').length===4?section:null;
  }
  async function refresh(){
    if(!cfg.endpoint)return;
    try{
      const url=new URL(cfg.endpoint,location.href);
      if(url.origin!==location.origin)throw Error('Feature endpoint origin mismatch');
      url.searchParams.set('_alookhor',Date.now());
      const response=await fetch(url,{cache:'no-store',credentials:'same-origin',headers:{Accept:'application/json'}});
      if(!response.ok)throw Error(`HTTP ${response.status}`);
      const data=await response.json();
      if(String(data.version)!==String(cfg.version)||data.item_count!==4)throw Error('Feature state mismatch');
      const fresh=parseMarkup(data.html);
      if(!fresh)throw Error('Feature markup invalid');
      const current=document.querySelector('#alookhor-managed-features');
      if(current){markSlot(current);current.replaceWith(fresh);mount(fresh)}
      else place(fresh);
    }catch(error){
      console.warn('ALOOKHOR site-feature refresh failed; server template remains active.',error);
    }
  }
  function start(){
    document.body?.classList.add('alookhor-sf-enabled');
    if(cfg.hide_legacy)document.body?.classList.add('alookhor-sf-hide-legacy');
    const template=document.querySelector('#alookhor-managed-features-template');
    const current=document.querySelector('#alookhor-managed-features');
    if(current){markSlot(current);mount(current)}
    else if(template){const section=template.content.firstElementChild?.cloneNode(true);if(section)place(section)}
    template?.remove();
    refresh();
  }
  if(document.body)start();
  else document.addEventListener('DOMContentLoaded',start,{once:true});
})();
