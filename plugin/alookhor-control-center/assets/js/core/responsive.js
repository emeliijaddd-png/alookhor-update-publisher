// Responsive Engine — قوانین طلایی
export const Breakpoints = {
  xs: 0,
  sm: 375,
  md: 768,
  lg: 1024,
  xl: 1440,
  xxl: 1920
};

export function getBreakpoint(w = window.innerWidth) {
  if (w >= 1920) return 'xxl';
  if (w >= 1440) return 'xl';
  if (w >= 1024) return 'lg';
  if (w >= 768) return 'md';
  if (w >= 375) return 'sm';
  return 'xs';
}

export function initResponsive() {
  const indicator = document.getElementById('bpIndicator');
  const sidebar = document.getElementById('sidebar');
  const backdrop = document.getElementById('backdrop');
  const hamburger = document.getElementById('hamburger');

  function update() {
    const bp = getBreakpoint();
    if (indicator) indicator.textContent = `${bp} • ${window.innerWidth}px`;
    document.documentElement.dataset.bp = bp;
  }
  update();
  window.addEventListener('resize', update);

  function openDrawer() {
    sidebar?.classList.add('open');
    backdrop?.classList.add('show');
    document.body.style.overflow = 'hidden';
  }
  function closeDrawer() {
    sidebar?.classList.remove('open');
    backdrop?.classList.remove('show');
    document.body.style.overflow = '';
  }
  hamburger?.addEventListener('click', () => {
    if (sidebar?.classList.contains('open')) closeDrawer(); else openDrawer();
  });
  backdrop?.addEventListener('click', closeDrawer);
  // بستن با انتخاب ماژول در موبایل
  document.addEventListener('alookhor:module-switched', closeDrawer);
  // ESC
  document.addEventListener('keydown', e => { if (e.key === 'Escape') closeDrawer(); });
}
