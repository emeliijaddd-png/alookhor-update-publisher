/**
 * ALOOKHOR Export Banner — entrance animation helper for [alookhor_export_banner].
 * Fully scoped to .alookhor-xb elements; touches nothing else on the page.
 * If JavaScript is unavailable the banner simply renders statically (the
 * `will-animate` hidden state is only ever applied from this file).
 */
(function () {
    'use strict';

    function arm(banner) {
        banner.classList.add('will-animate');
        if (!('IntersectionObserver' in window)) {
            banner.classList.add('is-visible');
            return;
        }
        var observer = new IntersectionObserver(function (entries) {
            entries.forEach(function (entry) {
                if (!entry.isIntersecting) return;
                entry.target.classList.add('is-visible');
                observer.unobserve(entry.target);
            });
        }, { threshold: 0.18, rootMargin: '0px 0px -8% 0px' });
        observer.observe(banner);
    }

    function boot() {
        var banners = document.querySelectorAll('.alookhor-xb');
        if (!banners.length) return;
        banners.forEach(arm);
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', boot, { once: true });
    } else {
        boot();
    }
})();
