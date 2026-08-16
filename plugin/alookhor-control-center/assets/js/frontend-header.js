/**
 * ALOOKHOR Portal Header — accessible drawer + dynamic WordPress Mega Menu.
 * No dependencies. The menu data itself remains WordPress wp_nav_menu output.
 */
(() => {
  'use strict';

  const focusableSelector = [
    'a[href]', 'button:not([disabled])', 'input:not([disabled])',
    'select:not([disabled])', 'textarea:not([disabled])', '[tabindex]:not([tabindex="-1"])'
  ].join(',');

  function injectMegaMenuStyles() {
    if (document.getElementById('alookhor-mega-menu-runtime-style')) return;
    const style = document.createElement('style');
    style.id = 'alookhor-mega-menu-runtime-style';
    style.textContent = `
      .alookhor-portal-header .alookhor-primary-menu > li.menu-item-has-children > .sub-menu {
        width:min(920px,calc(100vw - 70px));
        min-height:110px;
        display:grid;
        grid-template-columns:repeat(4,minmax(0,1fr));
        gap:8px 14px;
        padding:18px!important;
        border-radius:22px;
        background:
          radial-gradient(520px 180px at 50% 0,rgba(212,154,46,.10),transparent 70%),
          linear-gradient(180deg,rgba(27,17,34,.98),rgba(12,7,17,.98));
        box-shadow:0 28px 70px rgba(0,0,0,.58),inset 0 1px 0 rgba(255,255,255,.05);
        border-color:rgba(212,154,46,.30);
      }
      .alookhor-portal-header .alookhor-primary-menu > li.menu-item-has-children > .sub-menu > li {
        min-width:0;
        padding:4px!important;
        border-inline-start:1px solid rgba(212,154,46,.10);
      }
      .alookhor-portal-header .alookhor-primary-menu > li.menu-item-has-children > .sub-menu > li:first-child {border-inline-start:0}
      .alookhor-portal-header .alookhor-primary-menu > li.menu-item-has-children > .sub-menu > li > a {
        display:flex;
        align-items:center;
        min-height:40px;
        margin-bottom:4px;
        padding:10px 12px;
        color:var(--alookhor-capsule-gold-light,var(--alookhor-gold-soft,#E8B84A))!important;
        font-size:12px;
        font-weight:800;
        border-radius:12px;
        background:rgba(212,154,46,.045);
      }
      .alookhor-portal-header .alookhor-primary-menu > li.menu-item-has-children > .sub-menu > li > a:hover {
        background:rgba(212,154,46,.11);
        color:#fff!important;
      }
      .alookhor-portal-header .alookhor-primary-menu > li.menu-item-has-children > .sub-menu > li > .sub-menu {
        position:static!important;
        width:auto!important;
        margin:0!important;
        padding:0 3px!important;
        display:block!important;
        opacity:1!important;
        visibility:visible!important;
        transform:none!important;
        border:0!important;
        background:transparent!important;
        box-shadow:none!important;
        backdrop-filter:none!important;
      }
      .alookhor-portal-header .alookhor-primary-menu > li.menu-item-has-children > .sub-menu > li > .sub-menu > li > a {
        padding:7px 9px;
        border-radius:9px;
        color:var(--alookhor-capsule-muted,#C8C2C9)!important;
        font-size:11px;
      }
      .alookhor-portal-header .alookhor-primary-menu > li.menu-item-has-children > .sub-menu > li > .sub-menu > li > a:hover {
        background:rgba(255,255,255,.045);
        color:#fff!important;
      }
      .alookhor-portal-header .alookhor-primary-menu > li.menu-item-has-children > a::before {transition:transform .2s ease}
      .alookhor-portal-header .alookhor-primary-menu > li.menu-item-has-children:hover > a::before,
      .alookhor-portal-header .alookhor-primary-menu > li.menu-item-has-children:focus-within > a::before {
        transform:translateY(-35%) rotate(135deg);
      }
      .alookhor-portal-header .alookhor-primary-menu > li.menu-item-has-children > .sub-menu::before {
        content:"";
        position:absolute;
        top:-6px;
        right:38px;
        width:12px;
        height:12px;
        transform:rotate(45deg);
        background:#1b1122;
        border-top:1px solid rgba(212,154,46,.30);
        border-right:1px solid rgba(212,154,46,.30);
      }
      @media (max-width:1100px) and (min-width:861px) {
        .alookhor-portal-header .alookhor-primary-menu > li.menu-item-has-children > .sub-menu {
          width:min(760px,calc(100vw - 50px));
          grid-template-columns:repeat(3,minmax(0,1fr));
        }
        .alookhor-portal-header .alookhor-primary-menu > li > a {padding-inline:11px}
      }
      @media (max-width:860px) {
        .alookhor-portal-header .alookhor-desktop-nav {display:none!important}
        .alookhor-portal-header .alookhor-nav-shell {border-radius:26px}
      }
    `;
    document.head.appendChild(style);
  }

  function initHeader(root) {
    if (root.dataset.alookhorReady === '1') return;
    root.dataset.alookhorReady = '1';
    injectMegaMenuStyles();

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

  function initAll(scope = document) {
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
