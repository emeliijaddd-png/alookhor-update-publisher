/**
 * ALOOKHOR AKX Header — Mobile drawer + search toggle
 */
(function () {
  'use strict';

  function init() {
    const root = document.querySelector('.akx-header');
    if (!root) return;
    if (root.dataset.akxReady === '1') return;
    root.dataset.akxReady = '1';

    const menuBtn = root.querySelector('.akx-menu-button');
    const backdrop = root.querySelector('.akx-mob-backdrop');
    const drawer = root.querySelector('.akx-mob-drawer');
    const closeBtns = root.querySelectorAll('[data-akx-close]');
    const searchBtn = root.querySelector('.akx-search-button');
    const searchPanel = root.querySelector('.akx-search-panel');

    // === Mobile Drawer ===
    function openDrawer() {
      if (drawer) drawer.classList.add('is-open');
      if (backdrop) backdrop.classList.add('is-open');
    }

    function closeDrawer() {
      if (drawer) drawer.classList.remove('is-open');
      if (backdrop) backdrop.classList.remove('is-open');
    }

    if (menuBtn && drawer) {
      menuBtn.addEventListener('click', openDrawer);
    }

    if (closeBtns) {
      closeBtns.forEach(function(el) {
        el.addEventListener('click', closeDrawer);
      });
    }

    if (backdrop) {
      backdrop.addEventListener('click', closeDrawer);
    }

    // === Mobile Sub-menu Accordion ===
    var mobToggles = root.querySelectorAll('.akx-mob-toggle');
    mobToggles.forEach(function(toggle) {
      toggle.addEventListener('click', function(e) {
        e.preventDefault();
        this.parentElement.classList.toggle('is-open');
      });
    });

    // === Search Panel Toggle ===
    if (searchBtn && searchPanel) {
      searchBtn.addEventListener('click', function(e) {
        e.stopPropagation();
        searchPanel.classList.toggle('is-open');
        if (searchPanel.classList.contains('is-open')) {
          var input = searchPanel.querySelector('input');
          if (input) input.focus();
        }
      });
    }

    // === Close on outside click ===
    document.addEventListener('click', function(event) {
      if (!root.contains(event.target)) {
        closeDrawer();
        if (searchPanel) searchPanel.classList.remove('is-open');
      }
    });
  }

  // Run on DOMContentLoaded
  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', init, { once: true });
  } else {
    init();
  }

  // Watch for dynamically added headers
  var observer = new MutationObserver(function() {
    var el = document.querySelector('.akx-header:not([data-akx-ready])');
    if (el) init();
  });
  observer.observe(document.documentElement, { childList: true, subtree: true });
})();