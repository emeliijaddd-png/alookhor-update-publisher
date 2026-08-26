/** ALOOKHOR purple glass slider — scoped runtime for .alookhor-ps */
(() => {
  'use strict';

  const reduceMotion = window.matchMedia?.('(prefers-reduced-motion: reduce)');

  function mount(root) {
    if (!root || root.dataset.mounted === '1' || !root.classList.contains('alookhor-ps')) return;
    const slides = [...root.querySelectorAll('.alookhor-ps-slide')];
    if (!slides.length) return;
    root.dataset.mounted = '1';
    const dots = [...root.querySelectorAll('.alookhor-ps-dots button')];
    const prev = root.querySelector('.alookhor-ps-arrow.is-prev');
    const next = root.querySelector('.alookhor-ps-arrow.is-next');
    const status = root.querySelector('.alookhor-ps-status');
    slides.forEach((slide) => slide.querySelector('img')?.setAttribute('draggable', 'false'));
    let index = Math.max(0, slides.findIndex((slide) => slide.classList.contains('is-active')));
    let timer = null;
    let startX = 0;
    let startY = 0;
    const interval = Math.max(3000, Math.min(15000, Number(root.dataset.autoplay) || 5500));
    const canAuto = () => slides.length > 1 && !reduceMotion?.matches && !document.hidden;

    function render(target, announce = false) {
      index = (target + slides.length) % slides.length;
      slides.forEach((slide, i) => {
        const active = i === index;
        slide.classList.toggle('is-active', active);
        slide.setAttribute('aria-hidden', active ? 'false' : 'true');
        slide.querySelectorAll('a,button').forEach((control) => {
          control.tabIndex = active ? 0 : -1;
        });
      });
      dots.forEach((dot, i) => {
        const active = i === index;
        dot.classList.toggle('is-active', active);
        dot.setAttribute('aria-selected', active ? 'true' : 'false');
        dot.tabIndex = active ? 0 : -1;
      });
      if (announce && status) status.textContent = `اسلاید ${index + 1} از ${slides.length}`;
    }

    function stop() {
      if (timer) {
        window.clearInterval(timer);
        timer = null;
      }
    }

    function start() {
      stop();
      if (canAuto()) timer = window.setInterval(() => render(index + 1), interval);
    }

    function go(target, announce = true) {
      render(target, announce);
      start();
    }

    prev?.addEventListener('click', () => go(index - 1));
    next?.addEventListener('click', () => go(index + 1));
    dots.forEach((dot, i) => dot.addEventListener('click', () => go(i)));
    root.addEventListener('keydown', (event) => {
      if (event.key === 'ArrowLeft') {
        event.preventDefault();
        go(index + 1);
      }
      if (event.key === 'ArrowRight') {
        event.preventDefault();
        go(index - 1);
      }
      if (event.key === 'Home') {
        event.preventDefault();
        go(0);
      }
      if (event.key === 'End') {
        event.preventDefault();
        go(slides.length - 1);
      }
    });
    root.addEventListener('pointerdown', (event) => {
      startX = event.clientX;
      startY = event.clientY;
    }, { passive: true });
    root.addEventListener('pointerup', (event) => {
      const dx = event.clientX - startX;
      const dy = event.clientY - startY;
      if (Math.abs(dx) > 45 && Math.abs(dx) > Math.abs(dy) * 1.25) go(index + (dx < 0 ? 1 : -1));
    }, { passive: true });
    root.addEventListener('mouseenter', stop);
    root.addEventListener('mouseleave', start);
    root.addEventListener('focusin', stop);
    root.addEventListener('focusout', (event) => {
      if (!root.contains(event.relatedTarget)) start();
    });
    const visibility = () => (document.hidden ? stop() : start());
    document.addEventListener('visibilitychange', visibility);
    reduceMotion?.addEventListener?.('change', start);
    root._alookhorPurpleSliderCleanup = () => {
      stop();
      document.removeEventListener('visibilitychange', visibility);
      reduceMotion?.removeEventListener?.('change', start);
    };
    render(index);
    start();
  }

  function mountAll(scope = document) {
    scope.querySelectorAll?.('.alookhor-ps').forEach(mount);
    if (scope instanceof Element && scope.matches?.('.alookhor-ps')) mount(scope);
  }

  function start() {
    mountAll(document);
  }

  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', start, { once: true });
  } else {
    start();
  }

  const observer = new MutationObserver((mutations) => {
    for (const mutation of mutations) {
      for (const node of mutation.addedNodes) {
        if (!(node instanceof Element)) continue;
        mountAll(node);
      }
    }
  });
  observer.observe(document.documentElement, { childList: true, subtree: true });
})();
