(()=>{'use strict';
function rewrite(){const target=window.ALOOKHOR_ABOUT?.about_url;if(!target)return;document.querySelectorAll('a[href]').forEach(link=>{const text=(link.textContent||'').replace(/\s+/g,' ').trim(),href=link.getAttribute('href')||'';let path='';try{path=trim(new URL(href,location.href).pathname)}catch(error){path=''}if(text.includes('درباره ما')||text.includes('درباره آلوخور')||path==='about'||path==='درباره-ما')link.href=target})}
function trim(value){return String(value||'').replace(/^\/+|\/+$/g,'')}
function reveal(root){if(root.dataset.revealReady)return;root.dataset.revealReady='1';const items=root.querySelectorAll('.ab-reveal:not(.is-visible)');if(!('IntersectionObserver' in window)){items.forEach(el=>el.classList.add('is-visible'));return}const io=new IntersectionObserver(entries=>{entries.forEach(entry=>{if(entry.isIntersecting){entry.target.classList.add('is-visible');io.unobserve(entry.target)}})},{threshold:.14,rootMargin:'0px 0px -6% 0px'});items.forEach(el=>io.observe(el))}
function boot(){rewrite();document.querySelectorAll('.alookhor-ab').forEach(reveal)}
document.readyState==='loading'?document.addEventListener('DOMContentLoaded',boot):boot();new MutationObserver(boot).observe(document.documentElement,{childList:true,subtree:true})
})();
