/**
 * ALOOKHOR Legacy Top Bar Manager — v3.8.7
 * Preserves the legacy header/mega-menu HTML and synchronizes managed Top Bar
 * values from a fresh read-only REST endpoint, even when the page HTML is cached.
 */
(() => {
  'use strict';

  const cfg = {...(window.ALOOKHOR_TOPBAR || {})};
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

  function manage(root, force = false) {
    if (!root || (!force && root.dataset.topbarManaged === '3.8.7')) return;

    const phone = root.querySelector('a[href^="tel:"]');
    const email = root.querySelector('a[href^="mailto:"]');
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

    if (phone) {
      phone.href = `tel:${phoneHref(cfg.phone)}`;
      phone.textContent = cfg.phone || '';
      setVisible(closestItem(phone), asBool(cfg.show_phone) && Boolean(cfg.phone));
    }
    if (email) {
      email.href = `mailto:${cfg.email || ''}`;
      email.textContent = cfg.email || '';
      setVisible(closestItem(email), asBool(cfg.show_email) && Boolean(cfg.email));
    }
    if (whatsapp) {
      whatsapp.href = whatsappHref(cfg.whatsapp);
      setVisible(closestItem(whatsapp), asBool(cfg.show_whatsapp) && Boolean(cfg.whatsapp));
    }
    if (wholesale) {
      const textTarget = [...wholesale.querySelectorAll('span,b,strong')]
        .sort((a,b) => a.textContent.length - b.textContent.length)
        .find(el => el.textContent.includes('خرید عمده'));
      if (textTarget) textTarget.textContent = cfg.wholesale_text || '';
      else wholesale.textContent = cfg.wholesale_text || '';
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
      const height = Math.max(30, Math.min(60, Number(cfg.topbar_height) || 38));
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
    }

    if (cfg.top_logo_url) {
      const logo = topbar?.querySelector('[class*="logo" i] img,img[alt*="لوگو"],img[alt*="alookhor" i]')
        || root.querySelector('[class*="top-logo" i] img');
      if (logo) {
        logo.src = cfg.top_logo_url;
        logo.alt = cfg.top_logo_alt || 'ALOOKHOR';
        logo.style.setProperty('max-width', `${Math.max(50, Math.min(180, Number(cfg.top_logo_width) || 96))}px`, 'important');
        const logoLink = logo.closest('a');
        if (logoLink && cfg.top_logo_link) logoLink.href = cfg.top_logo_link;
      }
    }

    root.dataset.topbarManaged = '3.8.7';
    root.dispatchEvent(new CustomEvent('alookhor:topbar-managed', {bubbles:true, detail:{version:'3.8.7'}}));
  }

  function init(scope = document, force = false) {
    scope.querySelectorAll('.alookhor-managed-legacy-header').forEach(root => manage(root, force));
    if (scope instanceof Element) {
      const owner = scope.closest('.alookhor-managed-legacy-header');
      if (owner) manage(owner, force);
    }
  }

  async function refreshFromWordPress() {
    if (!cfg.endpoint) return;
    try {
      const endpoint = new URL(cfg.endpoint, window.location.href);
      if (endpoint.origin !== window.location.origin) return;
      endpoint.searchParams.set('_alookhor', String(Date.now()));
      const response = await fetch(endpoint.href, {
        cache: 'no-store',
        credentials: 'same-origin',
        headers: {'Accept': 'application/json'}
      });
      if (!response.ok) throw new Error(`HTTP ${response.status}`);
      Object.assign(cfg, await response.json());
      init(document, true);
    } catch (error) {
      console.warn('ALOOKHOR Top Bar refresh failed; localized settings remain active.', error);
    }
  }

  const start = () => {
    init();
    refreshFromWordPress();
  };
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
