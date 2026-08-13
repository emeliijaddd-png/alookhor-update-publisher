/**
 * ALOOKHOR Legacy Top Bar Manager — v3.10.14
 * Preserves the legacy header/mega-menu HTML and synchronizes managed Top Bar
 * values from a fresh read-only REST endpoint, even when the page HTML is cached.
 */
(() => {
  'use strict';

  const cfg = {...(window.ALOOKHOR_TOPBAR || {})};
  let freshState = cfg.endpoint ? 'pending' : 'fallback';
  const asBool = value => value === true || value === 1 || value === '1' || value === 'true';
  const digits = value => String(value || '')
    .replace(/[۰-۹]/g, d => String('۰۱۲۳۴۵۶۷۸۹'.indexOf(d)))
    .replace(/[٠-٩]/g, d => String('٠١٢٣٤٥٦٧٨٩'.indexOf(d)));
  const phoneHref = value => digits(value).replace(/[^0-9+]/g, '');
  const whatsappHref = value => {
    let number = digits(value).replace(/\D/g, '');
    if (number.startsWith('0')) number = `98${number.slice(1)}`;
    return number ? `https://wa.me/${number}` : '';
  };
  const setVisible = (element, visible) => {
    if (!element) return;
    element.hidden = !visible;
    element.style.setProperty('display', visible ? '' : 'none', visible ? '' : 'important');
    element.setAttribute('aria-hidden', visible ? 'false' : 'true');
  };
  const smallestTextMatch = (root, phrase) => {
    const matches = [...root.querySelectorAll('a,span,p,div')]
      .filter(el => (el.textContent || '').includes(phrase));
    return matches.sort((a, b) => a.textContent.trim().length - b.textContent.trim().length)[0] || null;
  };
  const replaceVisibleText = (element, value, matcher = () => true) => {
    if (!element) return;
    const direct = [...element.childNodes].find(node =>
      node.nodeType === Node.TEXT_NODE && node.textContent.trim() && matcher(node.textContent)
    );
    if (direct) {
      direct.textContent = element.children.length ? ` ${value || ''} ` : (value || '');
      return;
    }
    const target = [...element.querySelectorAll('span,b,strong')]
      .find(node => matcher(node.textContent || ''));
    if (target) target.textContent = value || '';
    else element.appendChild(document.createTextNode(` ${value || ''} `));
  };
  const closestItem = element => element?.closest('a,button,li,[class*="item"],[class*="contact"]') || element;
  const commonAncestor = (elements, boundary) => {
    const valid = elements.filter(Boolean);
    if (!valid.length) return null;
    let current = valid[0];
    while (current && current !== boundary) {
      if (valid.every(el => current.contains(el))) return current;
      current = current.parentElement;
    }
    return null;
  };
  const topbarSelector = '[class*="topbar" i],[class*="top-bar" i],[class*="top_bar" i]';
  const clamp = (value, min, max, fallback) => Math.max(min, Math.min(max, Number(value) || fallback));

  function setupHeaderBehavior(root) {
    const topbar = root.querySelector('.alookhor-topbar-wrapper');
    const header = root.querySelector('.alookhor-header');
    const capsule = header?.querySelector('.header-capsule');
    const navigation = header?.querySelector('.header-nav-center') || root.querySelector('.alookhor-legacy-nav-shell .header-nav-center');
    if (!topbar || !header || !capsule || !navigation) return;

    const nativeHeader = document.querySelector('.whb-header');
    if (nativeHeader && getComputedStyle(nativeHeader).display === 'none') {
      document.body.style.setProperty('padding-top', '0px', 'important');
      const mainContent = root.closest('#main-content');
      if (mainContent) mainContent.style.setProperty('padding-top', '0px', 'important');
    }

    const system = root.querySelector('.alookhor-header-system') || root.closest('.alookhor-header-system');
    if (system) {
      system.style.setProperty('height', 'auto', 'important');
      system.style.setProperty('min-height', '0', 'important');
      system.style.setProperty('margin-bottom', '0', 'important');
      system.style.setProperty('overflow', 'visible', 'important');
    }
    [topbar, header].forEach(element => {
      element.style.setProperty('position', 'relative', 'important');
      element.style.setProperty('top', 'auto', 'important');
      element.style.setProperty('left', 'auto', 'important');
      element.style.setProperty('right', 'auto', 'important');
      element.style.setProperty('transform', 'none', 'important');
      element.style.setProperty('width', '100%', 'important');
    });
    header.style.setProperty('height', 'auto', 'important');

    root.style.setProperty('--alookhor-header-gold', cfg.gold || '#D4A436');
    root.style.setProperty('--alookhor-header-surface', cfg.header_surface || '#0D0916');
    root.style.setProperty('--alookhor-header-text', cfg.header_text_color || '#F7F2EA');
    root.style.setProperty('--alookhor-header-muted', cfg.header_muted_color || '#B8B0BD');
    root.style.setProperty('--alookhor-mobile-logo-width', `${clamp(cfg.header_logo_mobile_width, 42, 110, 58)}px`);

    const mainToggle = root.querySelector('#openDrawer,.alookhor-hamburger-btn');
    if (mainToggle) {
      mainToggle.classList.add('alookhor-main-menu-toggle');
      if (mainToggle.parentElement !== capsule) capsule.append(mainToggle);
    }
    const logoBox = capsule.querySelector('.header-capsule-logo');
    if (logoBox && !logoBox.querySelector('.alookhor-logo-copy')) {
      const copy = document.createElement('span');
      copy.className = 'alookhor-logo-copy';
      copy.innerHTML = '<b>آلوخور</b><small>پایتخت آلوی ایران</small>';
      logoBox.append(copy);
    }
    const topbarContainer = topbar.querySelector('.alookhor-topbar-container');
    if (topbarContainer && !topbarContainer.querySelector('.alookhor-topbar-support')) {
      const support = document.createElement('span');
      support.className = 'alookhor-topbar-support';
      support.innerHTML = '<span aria-hidden="true">◉</span><b>پشتیبانی ۲۴/۷</b>';
      topbarContainer.append(support);
    }

    const actions = capsule.querySelector('.header-capsule-left');
    const account = actions?.querySelector('.header-login-btn');
    if (account && !account.querySelector('.alookhor-account-icon')) {
      account.insertAdjacentHTML('afterbegin','<svg class="alookhor-account-icon" viewBox="0 0 24 24" aria-hidden="true"><circle cx="12" cy="7" r="4"/><path d="M4.5 21c.7-4.7 3.2-7 7.5-7s6.8 2.3 7.5 7"/></svg>');
    }
    if (actions && !actions.querySelector('.alookhor-header-cart-link')) {
      const cart = document.createElement('a');
      cart.className = 'alookhor-header-cart-link';
      cart.href = cfg.cart_url || '/cart/';
      cart.setAttribute('aria-label', 'سبد خرید');
      cart.innerHTML = `<svg viewBox="0 0 24 24" aria-hidden="true"><path d="M3 4h2l2 11h10l3-8H6M9 20a1 1 0 1 0 0-2 1 1 0 0 0 0 2Zm8 0a1 1 0 1 0 0-2 1 1 0 0 0 0 2Z"/></svg><span class="alookhor-cart-count">${Math.max(0,Number(cfg.cart_count)||0)}</span>`;
      actions.prepend(cart);
    }

    let stage = root.querySelector('.alookhor-legacy-nav-stage');
    if (!stage) {
      stage = document.createElement('div');
      stage.className = 'alookhor-legacy-nav-stage';
      stage.setAttribute('data-alookhor-navigation', 'primary');
      const shell = document.createElement('div');
      shell.className = 'alookhor-legacy-nav-shell';
      navigation.before(document.createComment('ALOOKHOR primary navigation moved intact to sticky stage'));
      shell.append(navigation);

      stage.append(shell);
      const marker = document.createElement('span');
      marker.className = 'alookhor-legacy-nav-marker';
      marker.setAttribute('aria-hidden', 'true');
      header.after(marker, stage);

      let stageTop = 0;
      let ticking = false;
      const measure = () => {
        stageTop = marker.getBoundingClientRect().top + window.scrollY;
      };
      const update = () => {
        ticking = false;
        const desktop = window.innerWidth >= 1024;
        const adminOffset = document.body.classList.contains('admin-bar') ? (window.innerWidth <= 782 ? 46 : 32) : 0;
        const shouldStick = desktop && stage.classList.contains('is-enabled') && window.scrollY + adminOffset >= stageTop - 1;
        if (shouldStick !== stage.classList.contains('is-stuck')) {
          marker.style.setProperty('height', shouldStick ? `${stage.offsetHeight}px` : '0px', 'important');
          stage.classList.toggle('is-stuck', shouldStick);
        }
      };
      const requestUpdate = () => {
        if (ticking) return;
        ticking = true;
        window.requestAnimationFrame(update);
      };
      window.addEventListener('scroll', requestUpdate, {passive:true});
      window.addEventListener('resize', () => { measure(); requestUpdate(); }, {passive:true});
      window.addEventListener('load', () => { measure(); requestUpdate(); }, {once:true});
      window.requestAnimationFrame(() => { measure(); update(); });
    }

    stage.classList.toggle('is-enabled', asBool(cfg.sticky));
    if (!asBool(cfg.sticky) || window.innerWidth < 1024) {
      stage.classList.remove('is-stuck');
      root.querySelector('.alookhor-legacy-nav-marker')?.style.setProperty('height', '0px', 'important');
    }

    const headerLogo = header.querySelector('.header-capsule-logo img');
    if (headerLogo) {
      const setLogoSize = () => {
        const size = 50;
        headerLogo.style.setProperty('width', `${size}px`, 'important');
        headerLogo.style.setProperty('max-width', `${size}px`, 'important');
        headerLogo.style.setProperty('height', `${size}px`, 'important');
        headerLogo.style.setProperty('max-height', `${size}px`, 'important');
        headerLogo.style.setProperty('object-fit', 'cover', 'important');
        headerLogo.style.setProperty('object-position', 'top center', 'important');
        headerLogo.style.setProperty('border-radius', '50%', 'important');
        headerLogo.style.setProperty('background', 'transparent', 'important');
      };
      setLogoSize();
      if (root.dataset.headerLogoResize !== '1') {
        root.dataset.headerLogoResize = '1';
        window.addEventListener('resize', setLogoSize, {passive:true});
      }
    }
    root.dataset.headerBehaviorReady = '1';
  }

  function manage(root, force = false) {
    if (!root || (!force && root.dataset.topbarManaged === '3.10.14')) return;

    const contactTexts = [...root.querySelectorAll('.topbar-contact-txt,[class*="contact-txt" i]')];
    const phone = root.querySelector('a[href^="tel:"]') || contactTexts.find(element => {
      const text = element.textContent || '';
      const number = digits(text).replace(/\D/g, '');
      return !text.includes('@') && number.length >= 7 && number.length <= 15;
    });
    const email = root.querySelector('a[href^="mailto:"]') || contactTexts.find(element => (element.textContent || '').includes('@'));
    phone?.classList.add('alookhor-managed-phone');
    email?.classList.add('alookhor-managed-email');
    const wholesale = smallestTextMatch(root, 'خرید عمده')?.closest('a,button') || root.querySelector('a[href*="b2b"],a[href*="wholesale"]');
    const exportNote = smallestTextMatch(root, 'صادرات به');

    const explicitCandidates = [...root.querySelectorAll(topbarSelector)];
    const primaryItems = [phone, email, wholesale, exportNote].filter(Boolean);
    const candidateScore = element => primaryItems.filter(item => element.contains(item)).length;
    explicitCandidates.sort((a, b) => candidateScore(b) - candidateScore(a));
    const explicitTopbar = explicitCandidates.find(element => candidateScore(element) >= 2) || explicitCandidates[0] || null;
    const inferredTopbar = commonAncestor(primaryItems, root);
    const topbar = explicitTopbar || inferredTopbar;

    // Limit WhatsApp lookup to the selected Top Bar first. Legacy headers often
    // contain a second WhatsApp link in a drawer, which must not distort Top Bar
    // ancestor detection.
    const whatsapp = topbar?.querySelector('a[href*="wa.me"],a[href*="whatsapp.com"],a[aria-label*="WhatsApp" i]')
      || root.querySelector('a[href*="wa.me"],a[href*="whatsapp.com"],a[aria-label*="WhatsApp" i]');

    // Establish the three-row in-flow layout immediately when the legacy DOM
    // arrives, before paint. Fresh REST values can update colors/content later.
    setupHeaderBehavior(root);

    // A cached legacy header can contain old text/colors. Reserve its layout but
    // never paint stale content while the fresh same-origin REST read is pending.
    if (topbar && freshState === 'pending') {
      const pendingHeight = window.innerWidth <= 767 ? 34 : Math.max(30, Math.min(60, Number(cfg.topbar_height) || 38));
      topbar.style.setProperty('min-height', `${pendingHeight}px`, 'important');
      topbar.style.setProperty('height', `${pendingHeight}px`, 'important');
      topbar.style.setProperty('visibility', 'hidden', 'important');
      topbar.style.setProperty('opacity', '0', 'important');
      root.dataset.topbarManaged = 'pending';
      return;
    }

    if (phone) {
      if (phone.matches('a')) phone.href = `tel:${phoneHref(cfg.phone)}`;
      replaceVisibleText(phone, cfg.phone);
      setVisible(closestItem(phone), asBool(cfg.show_phone) && Boolean(cfg.phone));
    }
    if (email) {
      if (email.matches('a')) email.href = `mailto:${cfg.email || ''}`;
      replaceVisibleText(email, cfg.email);
      setVisible(closestItem(email), asBool(cfg.show_email) && Boolean(cfg.email));
    }
    if (whatsapp) {
      whatsapp.href = whatsappHref(cfg.whatsapp);
      setVisible(closestItem(whatsapp), asBool(cfg.show_whatsapp) && Boolean(cfg.whatsapp));
    }
    if (wholesale) {
      replaceVisibleText(wholesale, cfg.wholesale_text, text => text.includes('خرید عمده'));
      if (cfg.wholesale_url) wholesale.href = cfg.wholesale_url;
      wholesale.target = asBool(cfg.wholesale_new_tab) ? '_blank' : '_self';
      if (wholesale.target === '_blank') wholesale.rel = 'noopener';
      else wholesale.removeAttribute('rel');
      wholesale.style.setProperty('background', cfg.topbar_button_bg || '#C9A86A', 'important');
      wholesale.style.setProperty('color', cfg.topbar_button_text || '#1A1206', 'important');
      wholesale.querySelectorAll('span,b,strong,i').forEach(element => {
        element.style.setProperty('color', cfg.topbar_button_text || '#1A1206', 'important');
      });
      setVisible(closestItem(wholesale), asBool(cfg.show_wholesale) && Boolean(cfg.wholesale_text));
    }
    if (exportNote) {
      const textNode = [...exportNote.childNodes].find(node => node.nodeType === Node.TEXT_NODE && node.textContent.includes('صادرات'));
      if (textNode) textNode.textContent = ` ${cfg.export_text || ''} `;
      else exportNote.textContent = cfg.export_text || '';
      const exportLink = exportNote.closest('a') || exportNote.querySelector?.('a');
      if (exportLink && cfg.export_url) exportLink.href = cfg.export_url;
      setVisible(closestItem(exportNote), asBool(cfg.show_export) && Boolean(cfg.export_text));
    }

    if (topbar) {
      setVisible(topbar, asBool(cfg.show_topbar));
      const color = cfg.topbar_text_color || '#E8D5B5';
      const background = cfg.topbar_bg || '#11091D';
      const border = cfg.topbar_border_color || '#3A2C20';
      const height = window.innerWidth <= 767 ? 34 : Math.max(30, Math.min(60, Number(cfg.topbar_height) || 38));
      const layers = explicitCandidates.filter(element => {
        const score = candidateScore(element);
        return element === topbar || (score >= 2 && (element.contains(topbar) || topbar.contains(element)));
      });
      if (!layers.includes(topbar)) layers.unshift(topbar);
      layers.forEach(element => {
        element.style.setProperty('--alookhor-topbar-bg', background);
        element.style.setProperty('--alookhor-topbar-text', color);
        element.style.setProperty('--alookhor-topbar-border', border);
        element.style.setProperty('background', background, 'important');
        element.style.setProperty('color', color, 'important');
        element.style.setProperty('border-bottom-color', border, 'important');
        element.style.setProperty('min-height', `${height}px`, 'important');
        element.style.setProperty('height', `${height}px`, 'important');
      });
      topbar.querySelectorAll('a,span,p,b,strong,i').forEach(element => {
        if (wholesale && (element === wholesale || wholesale.contains(element))) return;
        element.style.setProperty('color', color, 'important');
      });
      topbar.style.setProperty('visibility', 'visible', 'important');
      topbar.style.setProperty('opacity', '1', 'important');
    }

    if (cfg.top_logo_url) {
      const logos = [
        topbar?.querySelector('[class*="logo" i] img,img[alt*="لوگو"],img[alt*="alookhor" i]'),
        root.querySelector('.header-capsule-logo img')
      ].filter(Boolean);
      logos.forEach(logo => {
        logo.src = cfg.top_logo_url;
        logo.alt = cfg.top_logo_alt || 'ALOOKHOR';
        logo.style.setProperty('background', 'transparent', 'important');
        const logoLink = logo.closest('a');
        if (logoLink && cfg.top_logo_link) logoLink.href = cfg.top_logo_link;
      });
      const topLogo = logos[0];
      if (topLogo) topLogo.style.setProperty('max-width', `${Math.max(50, Math.min(180, Number(cfg.top_logo_width) || 96))}px`, 'important');
    }

    setupHeaderBehavior(root);
    root.dataset.topbarManaged = '3.10.14';
    root.dispatchEvent(new CustomEvent('alookhor:topbar-managed', {bubbles:true, detail:{version:'3.10.14'}}));
  }

  function init(scope = document, force = false) {
    scope.querySelectorAll('.alookhor-managed-legacy-header').forEach(root => manage(root, force));
    if (scope instanceof Element) {
      const owner = scope.closest('.alookhor-managed-legacy-header');
      if (owner) manage(owner, force);
    }
  }

  async function refreshFromWordPress() {
    if (!cfg.endpoint) {
      freshState = 'fallback';
      return;
    }
    const controller = new AbortController();
    const timeout = window.setTimeout(() => controller.abort(), 2500);
    try {
      const endpoint = new URL(cfg.endpoint, window.location.href);
      if (endpoint.origin !== window.location.origin) throw new Error('Top Bar endpoint origin mismatch');
      endpoint.searchParams.set('_alookhor', String(Date.now()));
      const response = await fetch(endpoint.href, {
        cache: 'no-store',
        credentials: 'same-origin',
        headers: {'Accept': 'application/json'},
        signal: controller.signal
      });
      if (!response.ok) throw new Error(`HTTP ${response.status}`);
      Object.assign(cfg, await response.json());
      freshState = 'ready';
    } catch (error) {
      freshState = 'fallback';
      console.warn('ALOOKHOR Top Bar refresh failed; localized settings remain active.', error);
    } finally {
      window.clearTimeout(timeout);
      init(document, true);
    }
  }

  // Begin the fresh read while <head> is still being parsed. MutationObserver
  // hides any stale legacy Top Bar that arrives before this promise resolves.
  refreshFromWordPress();
  const start = () => init();
  if (document.readyState === 'loading') document.addEventListener('DOMContentLoaded', start, {once:true});
  else start();

  new MutationObserver(mutations => {
    for (const mutation of mutations) {
      for (const node of mutation.addedNodes) {
        if (!(node instanceof Element)) continue;
        if (node.matches?.('.alookhor-managed-legacy-header')) manage(node);
        else init(node);
      }
    }
  }).observe(document.documentElement, {childList:true, subtree:true});
})();
