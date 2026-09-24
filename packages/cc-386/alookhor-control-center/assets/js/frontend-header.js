/**
 * ALOOKHOR Portal Header — accessible drawer + dynamic WordPress Mega Menu.
 * No dependencies. Menu data remains WordPress wp_nav_menu output.
 */
(() => {
  'use strict';

  const focusableSelector = [
    'a[href]', 'button:not([disabled])', 'input:not([disabled])',
    'select:not([disabled])', 'textarea:not([disabled])', '[tabindex]:not([tabindex="-1"])'
  ].join(',');

  function injectMegaMenuStyles() {
    if (document.getElementById('alookhor-mega-menu-runtime')) return;
    const style = document.createElement('style');
    style.id = 'alookhor-mega-menu-runtime';
    style.textContent = `
      .alookhor-primary-menu > li.menu-item-has-children > .sub-menu {
        width: min(760px, calc(100vw - 40px));
        min-width: 430px;
        padding: 18px !important;
        display: grid;
        grid-template-columns: repeat(3, minmax(0, 1fr));
        gap: 8px 10px;
        right: 50%;
        transform: translate(50%, 8px);
        background: linear-gradient(145deg, rgba(28,16,36,.98), rgba(10,6,15,.98));
        border-color: rgba(212,154,46,.34);
        border-radius: 22px;
        box-shadow: 0 28px 70px rgba(0,0,0,.58), inset 0 1px 0 rgba(255,255,255,.045), 0 0 36px rgba(212,154,46,.06);
      }
      .alookhor-primary-menu > li.menu-item-has-children:hover > .sub-menu,
      .alookhor-primary-menu > li.menu-item-has-children:focus-within > .sub-menu {
        transform: translate(50%, 0);
      }
      .alookhor-primary-menu > li.menu-item-has-children > .sub-menu > li {
        min-width: 0;
      }
      .alookhor-primary-menu > li.menu-item-has-children > .sub-menu > li > a {
        min-height: 44px;
        align-items: center;
        padding: 11px 13px;
        border: 1px solid transparent;
        background: rgba(255,255,255,.018);
        border-radius: 12px;
        font-weight: 700;
      }
      .alookhor-primary-menu > li.menu-item-has-children > .sub-menu > li > a:hover {
        border-color: rgba(212,154,46,.22);
        background: linear-gradient(90deg, rgba(212,154,46,.12), rgba(255,255,255,.025));
      }
      .alookhor-primary-menu > li.menu-item-has-children > .sub-menu > li.menu-item-has-children > .sub-menu {
        position: static;
        width: auto;
        min-width: 0;
        margin: 2px 4px 4px !important;
        padding: 3px !important;
        opacity: 1;
        visibility: visible;
        transform: none;
        display: block;
        background: transparent;
        border: 0;
        box-shadow: none;
        backdrop-filter: none;
      }
      .alookhor-primary-menu > li.menu-item-has-children > .sub-menu > li.menu-item-has-children > .sub-menu a {
        padding: 7px 10px;
        font-size: 10.5px;
        color: var(--alookhor-capsule-muted, #c8c2c9) !important;
      }
      .alookhor-primary-menu > li.menu-item-has-children > .sub-menu > li.menu-item-has-children > .sub-menu a:hover {
        color: var(--alookhor-capsule-gold-light, #e8b84a) !important;
        background: rgba(212,154,46,.07);
      }
      @media (max-width: 1050px) {
        .alookhor-primary-menu > li.menu-item-has-children > .sub-menu {
          grid-template-columns: repeat(2, minmax(0, 1fr));
          min-width: 390px;
          width: min(620px, calc(100vw - 32px));
        }
      }
      @media (max-width: 760px) {
        .alookhor-primary-menu > li.menu-item-has-children > .sub-menu {
          display: block;
          min-width: 0;
          width: min(330px, calc(100vw - 28px));
          padding: 12px !important;
        }
      }
    `;
    document.head.appendChild(style);
  }

  function initHeader(root) {
    if (root.dataset.alookhorReady === '1') return;
    root.dataset.alookhorReady = '1';

    const toggle = root.querySelector('.alookhor-menu-toggle');
    const drawer = root.querySelector('.alookhor-menu-drawer');
    const closeButtons = root.querySelectorAll('[data-alookhor-close]');
    if (!toggle || !drawer) return;

    let previousFocus = null;

    function setOpen(open) {
      root.classList.toggle('menu-open', open);
      toggle.setAttribute('aria-expanded', open ? 'true' : 'false');
      drawer.setAttribute('aria-hidden', open ? 'false' : 'true');
      document.body.classList.toggle('alookhor-menu-open', open);

      if (open) {
        previousFocus = document.activeElement;
        window.requestAnimationFrame(() => {
          drawer.querySelector('.alookhor-drawer-close')?.focus({ preventScroll: true });
        });
      } else if (previousFocus && typeof previousFocus.focus === 'function') {
        previousFocus.focus({ preventScroll: true });
      }
    }

    toggle.addEventListener('click', () => setOpen(!root.classList.contains('menu-open')));
    closeButtons.forEach(button => button.addEventListener('click', () => setOpen(false)));

    drawer.querySelectorAll('.alookhor-drawer-menu-title').forEach(button => {
      button.addEventListener('click', () => {
        const group = button.closest('.alookhor-drawer-menu-group');
        const panelId = button.getAttribute('aria-controls');
        const panel = panelId ? document.getElementById(panelId) : null;
        const willOpen = button.getAttribute('aria-expanded') !== 'true';
        button.setAttribute('aria-expanded', willOpen ? 'true' : 'false');
        group?.classList.toggle('is-open', willOpen);
        if (panel) panel.hidden = !willOpen;
      });
    });

    drawer.addEventListener('click', event => {
      const link = event.target.closest('a[href]');
      if (link) setOpen(false);
    });

    root.addEventListener('keydown', event => {
      if (!root.classList.contains('menu-open')) return;
      if (event.key === 'Escape') {
        event.preventDefault();
        setOpen(false);
        return;
      }
      if (event.key !== 'Tab') return;

      const focusable = [...drawer.querySelectorAll(focusableSelector)].filter(element => {
        return !element.hidden && element.offsetParent !== null;
      });
      if (!focusable.length) return;
      const first = focusable[0];
      const last = focusable[focusable.length - 1];
      if (event.shiftKey && document.activeElement === first) {
        event.preventDefault();
        last.focus();
      } else if (!event.shiftKey && document.activeElement === last) {
        event.preventDefault();
        first.focus();
      }
    });
  }

  function cleanDuplicateReferenceHeader(scope=document){
    if(document.querySelector('.alookhor-portal-header')){
      scope.querySelectorAll?.('.alookhor-header-wrapper').forEach(node=>{node.hidden=true;node.setAttribute('aria-hidden','true')});
    }
    const root=scope===document?document.body:scope;
    if(!root)return;
    const walker=document.createTreeWalker(root,NodeFilter.SHOW_TEXT);
    const nodes=[];while(walker.nextNode())nodes.push(walker.currentNode);
    nodes.forEach(node=>{if(/\[\s*alookhor_premium_header\s*\]/i.test(node.nodeValue||''))node.nodeValue=(node.nodeValue||'').replace(/\[\s*alookhor_premium_header\s*\]/ig,'')});
  }

  function initAll(scope = document) {
    injectMegaMenuStyles();
    cleanDuplicateReferenceHeader(scope);
    scope.querySelectorAll('.alookhor-portal-header').forEach(initHeader);
  }

  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', () => initAll(), { once: true });
  } else {
    initAll();
  }

  const observer = new MutationObserver(mutations => {
    for (const mutation of mutations) {
      for (const node of mutation.addedNodes) {
        if (!(node instanceof Element)) continue;
        if (node.matches?.('.alookhor-portal-header')) initHeader(node);
        else initAll(node);
      }
    }
  });
  observer.observe(document.documentElement, { childList: true, subtree: true });
})();
