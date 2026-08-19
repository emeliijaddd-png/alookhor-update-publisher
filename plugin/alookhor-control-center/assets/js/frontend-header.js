/**
 * ALOOKHOR Portal Header — accessible drawer and menu accordions.
 * No dependencies; exits immediately when the recovered shortcode is absent.
 */
(() => {
  'use strict';

  const focusableSelector = [
    'a[href]', 'button:not([disabled])', 'input:not([disabled])',
    'select:not([disabled])', 'textarea:not([disabled])', '[tabindex]:not([tabindex="-1"])'
  ].join(',');

  function initHeader(root) {
    if (root.dataset.alookhorReady === '1') return;
    root.dataset.alookhorReady = '1';

    // Remove only the two source-backed Elementor header drafts that precede
    // the managed shortcode (`.ak-topbar-wrapper` and `.alu-header`). Their
    // dedicated widgets/containers otherwise reserve 221px Desktop / 292px
    // Mobile and paint two duplicate headers above the real WordPress Header.
    const managedWidget=root.closest('.elementor-widget-shortcode');
    const managedHost=managedWidget?.closest('.e-con')||root.closest('.e-con');
    const elementorRoot=root.closest('.elementor');
    elementorRoot?.querySelectorAll('.ak-topbar-wrapper,.alu-header').forEach(draft=>{
      if(draft.contains(root)||root.contains(draft))return;
      const draftWidget=draft.closest('.elementor-widget');
      if(draftWidget){draftWidget.dataset.alookhorDuplicateHeader='1';draftWidget.style.setProperty('display','none','important');draftWidget.style.setProperty('height','0px','important');draftWidget.style.setProperty('min-height','0px','important');draftWidget.style.setProperty('margin','0px','important');draftWidget.style.setProperty('padding','0px','important')}
      const draftHost=draftWidget?.closest('.e-con');
      if(draftHost&&draftHost!==managedHost){draftHost.dataset.alookhorDuplicateHeaderHost='1';draftHost.style.setProperty('display','none','important');draftHost.style.setProperty('height','0px','important');draftHost.style.setProperty('min-height','0px','important');draftHost.style.setProperty('margin','0px','important');draftHost.style.setProperty('padding','0px','important')}
    });

    // Elementor's page-level Header host carries provider-specific flex
    // distribution. Inline-important normalization is limited to the exact
    // container that owns the managed Header shortcode.
    const host=managedHost;
    if(host){['margin','margin-top','margin-bottom','margin-block','padding','padding-top','padding-bottom','padding-block','min-height','height','gap'].forEach(property=>host.style.setProperty(property,(property==='height'?'auto':property==='min-height'?'0':'0px'),'important'));host.style.setProperty('justify-content','flex-start','important');host.style.setProperty('align-content','flex-start','important');host.style.setProperty('--justify-content','flex-start','important');host.style.setProperty('--padding-top','0px','important');host.style.setProperty('--padding-bottom','0px','important');host.style.setProperty('--margin-top','0px','important');host.style.setProperty('--margin-bottom','0px','important')}
    if(elementorRoot){elementorRoot.style.setProperty('margin-top','0px','important');elementorRoot.style.setProperty('padding-top','0px','important')}

    // v3.10.37 — Mobile RTL geometry repair. The Elementor widget chain that
    // owns the managed shortcode can collapse to a zero-width point inside
    // row-flex containers; the header full-bleed margins then anchor to the
    // container's right edge in RTL and push the whole header outside the
    // viewport (measured on live: left=207.5/right=637.5 in a 430px viewport).
    // Stretch every link between the shortcode node and its host container so
    // the full-bleed math is computed against a real, centred width.
    (function repairWidthChain(){
      let node = root.parentElement;
      for (let depth = 0; node && node !== host && !node.classList.contains('elementor') && node.tagName !== 'BODY' && depth < 6; depth++) {
        const parentDisplay = node.parentElement ? getComputedStyle(node.parentElement).display : '';
        if (parentDisplay.includes('flex')) node.style.setProperty('flex', '1 1 100%', 'important');
        node.style.setProperty('width', '100%', 'important');
        node.style.setProperty('max-width', '100%', 'important');
        node.style.setProperty('margin-left', '0px', 'important');
        node.style.setProperty('margin-right', '0px', 'important');
        node = node.parentElement;
      }
    })();

    const toggle = root.querySelector('.alookhor-menu-toggle');
    const drawer = root.querySelector('.alookhor-menu-drawer');
    const closeButtons = root.querySelectorAll('[data-alookhor-close]');
    if (!toggle || !drawer) return;

    let previousFocus = null;

    function closeMega(except) {
      root.querySelectorAll('.alookhor-primary-menu > .menu-item-has-children').forEach((item) => {
        if (item === except) return;
        item.classList.remove('is-mega-open');
        item.querySelector(':scope > a')?.setAttribute('aria-expanded', 'false');
      });
    }

    if (root.classList.contains('alookhor-mega-menu')) {
      const triggers = [...root.querySelectorAll('.alookhor-primary-menu > .menu-item-has-children')];
      const canHover = () => window.matchMedia('(hover: hover) and (pointer: fine)').matches;
      triggers.forEach((item) => {
        const link = item.querySelector(':scope > a');
        if (!link) return;
        link.setAttribute('aria-haspopup', 'true');
        if (!link.hasAttribute('aria-expanded')) link.setAttribute('aria-expanded', 'false');
        link.addEventListener('click', (event) => {
          if (window.innerWidth < 1024 || canHover()) return;
          if (!item.classList.contains('is-mega-open')) {
            event.preventDefault();
            closeMega(item);
            item.classList.add('is-mega-open');
            link.setAttribute('aria-expanded', 'true');
          }
        });
        item.addEventListener('mouseenter', () => {
          if (window.innerWidth < 1024) return;
          closeMega(item);
          item.classList.add('is-mega-open');
          link.setAttribute('aria-expanded', 'true');
        });
        item.addEventListener('mouseleave', () => {
          item.classList.remove('is-mega-open');
          link.setAttribute('aria-expanded', 'false');
        });
      });
      root.addEventListener('keydown', (event) => {
        if (event.key !== 'Escape') return;
        const open = triggers.find((item) => item.classList.contains('is-mega-open'));
        if (!open) return;
        event.preventDefault();
        closeMega();
        open.querySelector(':scope > a')?.focus({ preventScroll: true });
      });
    }

    const navStage=root.querySelector('.alookhor-nav-stage');
    if(navStage&&root.classList.contains('is-sticky')){
      const marker=document.createElement('span');marker.className='alookhor-internal-nav-marker';marker.setAttribute('aria-hidden','true');navStage.before(marker);
      let stageTop=0,ticking=false;
      const measure=()=>{stageTop=marker.getBoundingClientRect().top+window.scrollY};
      const update=()=>{ticking=false;const desktop=window.innerWidth>=1024;const adminOffset=document.body.classList.contains('admin-bar')?(window.innerWidth<=782?46:32):0;const stuck=desktop&&window.scrollY+adminOffset>=stageTop-1;navStage.classList.toggle('is-stuck',stuck);marker.style.setProperty('height',stuck?`${navStage.offsetHeight}px`:'0px','important')};
      const requestUpdate=()=>{if(ticking)return;ticking=true;requestAnimationFrame(update)};
      window.addEventListener('scroll',requestUpdate,{passive:true});window.addEventListener('resize',()=>{if(navStage.classList.contains('is-stuck'))navStage.classList.remove('is-stuck');measure();requestUpdate()},{passive:true});
      requestAnimationFrame(()=>{measure();update()});
    }

    function setOpen(open) {
      root.classList.toggle('menu-open', open);
      toggle.setAttribute('aria-expanded', open ? 'true' : 'false');
      drawer.setAttribute('aria-hidden', open ? 'false' : 'true');
      document.body.classList.toggle('alookhor-menu-open', open);
      if (open) closeMega();

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

  // Elementor can inject templates after DOMContentLoaded.
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
