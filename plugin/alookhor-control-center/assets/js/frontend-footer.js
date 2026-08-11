/** ALOOKHOR managed footer runtime. */
(() => {
  'use strict';
  const cfg = window.ALOOKHOR_FOOTER || {};
  document.body?.classList.add('alookhor-mf-enabled');

  function bindFooter(root = document){
    const footer = root.querySelector?.('#alookhor-managed-footer') || (root.matches?.('#alookhor-managed-footer') ? root : null);
    if (!footer || footer.dataset.bound === '1') return;
    footer.dataset.bound = '1';
    footer.querySelectorAll('.alookhor-mf-links a').forEach(link => {
      link.addEventListener('focus', () => link.closest('.alookhor-mf-menu-card')?.classList.add('is-focused'));
      link.addEventListener('blur', () => link.closest('.alookhor-mf-menu-card')?.classList.remove('is-focused'));
    });
    const form = footer.querySelector('.alookhor-mf-newsletter-form');
    if (form && cfg.subscribe_endpoint) {
      form.addEventListener('submit', async event => {
        event.preventDefault();
        const message = footer.querySelector('.alookhor-mf-form-msg');
        const button = form.querySelector('button');
        button.disabled = true;
        if (message) message.textContent = 'در حال ثبت…';
        try {
          const response = await fetch(cfg.subscribe_endpoint, {
            method:'POST', credentials:'same-origin', cache:'no-store',
            headers:{'Content-Type':'application/json','Accept':'application/json'},
            body:JSON.stringify({
              email:form.elements.namedItem('email')?.value || '',
              company:form.elements.namedItem('company')?.value || ''
            })
          });
          const data = await response.json();
          if (!response.ok || data.code) throw new Error(data.message || `HTTP ${response.status}`);
          if (message) message.textContent = data.message || 'عضویت شما ثبت شد.';
          form.reset();
        } catch (error) {
          if (message) message.textContent = `ثبت انجام نشد: ${error.message}`;
        } finally { button.disabled = false; }
      });
    }
  }

  async function refresh(){
    if (!cfg.endpoint) return;
    try {
      const url = new URL(cfg.endpoint, location.href);
      if (url.origin !== location.origin) return;
      url.searchParams.set('_alookhor', Date.now());
      const response = await fetch(url, {cache:'no-store', credentials:'same-origin', headers:{'Accept':'application/json'}});
      if (!response.ok) throw new Error(`HTTP ${response.status}`);
      const data = await response.json();
      if (!data.html || String(data.version) !== String(cfg.version)) throw new Error('Footer state mismatch');
      const current = document.querySelector('#alookhor-managed-footer');
      if (!current) return;
      const template = document.createElement('template');
      template.innerHTML = data.html.trim();
      const fresh = template.content.firstElementChild;
      if (!fresh?.matches('#alookhor-managed-footer')) throw new Error('Footer markup invalid');
      current.replaceWith(fresh);
      bindFooter(fresh);
    } catch (error) {
      console.warn('ALOOKHOR footer refresh failed; server-rendered footer remains active.', error);
    }
  }

  const start = () => {
    document.body.classList.add('alookhor-mf-enabled');
    if (cfg.hide_legacy) document.body.classList.add('alookhor-mf-hide-legacy');
    if (cfg.hide_old_newsletter) document.body.classList.add('alookhor-mf-hide-old-sections');
    bindFooter();
    refresh();
  };
  if (document.readyState === 'loading') document.addEventListener('DOMContentLoaded', start, {once:true});
  else start();
})();
