// ALOOKHOR Update System — WordPress-native private updater
// UI/state remain modular; version discovery and installation are delegated to WordPress.

const runtimeConfig = window.ALOOKHOR_CC || {};
const runtimeVersion = String(runtimeConfig.version || '3.9.0');

function normalizeResult(data = {}) {
  const current = String(data.current || runtimeVersion);
  const latest = String(data.latest || current);
  return {
    configured: Boolean(data.configured),
    hasUpdate: Boolean(data.available),
    installable: Boolean(data.installable),
    current,
    latest,
    message: String(data.message || ''),
    errorCode: String(data.error_code || ''),
    changelog: Array.isArray(data.changelog) ? data.changelog : []
  };
}

async function postUpdateCheck(force = false) {
  if (!runtimeConfig.ajax_url || !runtimeConfig.nonce) {
    return normalizeResult({
      configured: false,
      current: runtimeVersion,
      latest: runtimeVersion,
      message: 'پل WordPress برای بررسی آپدیت در دسترس نیست.'
    });
  }

  const form = new FormData();
  form.append('action', 'alookhor_check_updates');
  form.append('nonce', runtimeConfig.nonce);
  form.append('force', force ? '1' : '0');

  const response = await fetch(runtimeConfig.ajax_url, {
    method: 'POST',
    body: form,
    credentials: 'same-origin',
    headers: { 'X-Requested-With': 'XMLHttpRequest' }
  });

  if (!response.ok) throw new Error(`HTTP ${response.status}`);
  const json = await response.json();
  if (!json || !json.success) {
    const message = typeof json?.data === 'string' ? json.data : 'پاسخ بررسی آپدیت معتبر نیست.';
    throw new Error(message);
  }
  return normalizeResult(json.data);
}

export const Updater = {
  current: runtimeVersion,
  latest: runtimeVersion,
  lastCheck: null,
  changelog: [
    { tag: 'FOOTER', title: 'v3.9.0 — فوتر حرفه‌ای مدیریت‌شده', desc: 'فوتر Luxury مستقل Desktop/Mobile با تنظیمات کامل در پنل اصلی ALOOKHOR.' },
    { tag: 'CONTACT', title: 'v3.8.9 — اتصال مستقیم تلفن و ایمیل Legacy', desc: 'spanهای واقعی تماس در هدر قدیمی از State تازه WordPress همگام می‌شوند.' },
    { tag: 'NO FLASH', title: 'v3.8.8 — نمایش اتمی Top Bar', desc: 'ظاهر و محتوای قدیمی هنگام بارگذاری دیده نمی‌شوند؛ Header پس از اعمال State تازه نمایش داده می‌شود.' },
    { tag: 'ACTIVATION', title: 'v3.8.7 — بازیابی خودکار وضعیت فعال', desc: 'افزونه‌ای که پیش از بروزرسانی فعال بوده، پس از Core Upgrader به‌صورت محدود و ایمن دوباره فعال می‌شود.' },
    { tag: 'TOP BAR', title: 'v3.8.6 — مدیریت کامل نوار بالای سایت', desc: 'تمام متن‌ها، لینک‌ها، نمایش آیتم‌ها، لوگو، رنگ‌ها و ارتفاع Top Bar از پیشخوان.' },
    { tag: 'HEADER', title: 'v3.8.5 — بازیابی هدر حرفه‌ای', desc: 'هدر دو‌ردیفه، فهرست‌های خودکار WordPress، Hamburger حرفه‌ای، Top Bar و تنظیمات کامل هدر.' },
    { tag: 'UPDATE', title: 'انتشار از Update Center', desc: 'ارتقا مستقیم از داخل ALOOKHOR بدون حذف افزونه یا Upload مجدد در صفحه افزونه‌ها.' },
    { tag: 'HOTFIX', title: 'v3.8.4 — Fix Boutique Empty', desc: 'Guard کامل برای داده‌های system و modules؛ سه پنل تنظیمات بوتیک دوباره پایدار رندر می‌شوند.' },
    { tag: 'HOTFIX', title: 'v3.8.3 — Fix Console Errors', desc: 'رفع خطای ES Module، Object.values و محدودیت Tracking Prevention.' },
    { tag: 'RESPONSIVE', title: 'Drawer لوکس تا 320px', desc: 'سایدبار موبایل، جدول‌های Card View و جلوگیری از overflow-x حفظ شده‌اند.' }
  ],

  async check({ force = false } = {}) {
    try {
      const result = await postUpdateCheck(force);
      this.current = result.current;
      this.latest = result.latest;
      this.lastCheck = result;
      if (result.changelog.length) this.changelog = result.changelog;
      return result;
    } catch (error) {
      const result = normalizeResult({
        configured: Boolean(runtimeConfig.updater_configured),
        current: this.current,
        latest: this.current,
        message: `بررسی آپدیت انجام نشد: ${error.message}`,
        error_code: 'request_failed'
      });
      this.lastCheck = result;
      return result;
    }
  },

  async install(version) {
    const state = this.lastCheck;
    if (!state?.hasUpdate) throw new Error('هیچ نسخه جدیدی برای نصب ثبت نشده است.');
    if (!state.installable) throw new Error('نسخه جدید فاقد لینک بسته نصب معتبر است.');
    if (!runtimeConfig.native_update_url) {
      throw new Error('آدرس امن Core Upgrader وردپرس در دسترس نیست.');
    }

    // Installer AJAX صفحه Plugins به DOM همان جدول وابسته است و در صفحات
    // سفارشی خطای reading html می‌دهد. مسیر nonceدار Core Upgrader مستقل،
    // رسمی و سازگار با روش‌های مختلف WordPress Filesystem است.
    const target = new URL(runtimeConfig.native_update_url, window.location.href);
    if (target.origin !== window.location.origin) {
      throw new Error('آدرس نصب WordPress معتبر نیست.');
    }
    try{
      sessionStorage.setItem('alookhor_update_pending', JSON.stringify({version, startedAt:Date.now()}));
    }catch(e){}
    window.location.assign(target.href);

    // Navigation replaces this page; keep the promise pending to prevent the
    // click handler from rendering a false success/error before WordPress runs.
    return new Promise(() => {});
  }
};

// Check once on page load, then every six hours while the panel remains open.
export function initUpdater({ onAvailable, onChecked } = {}) {
  let state = {
    configured: Boolean(runtimeConfig.updater_configured),
    hasUpdate: false,
    installable: false,
    pendingVersion: null,
    message: 'در حال بررسی...'
  };

  async function runCheck(force = false) {
    const result = await Updater.check({ force });
    state = {
      configured: result.configured,
      hasUpdate: result.hasUpdate,
      installable: result.installable,
      pendingVersion: result.hasUpdate ? result.latest : null,
      message: result.message
    };

    const badge = document.getElementById('updateBadge');
    const button = document.getElementById('btnUpdateCenter');
    if (badge) {
      badge.style.display = result.hasUpdate ? 'inline-flex' : 'none';
      badge.textContent = result.hasUpdate ? `v${result.latest} آماده` : '';
    }
    button?.classList.toggle('has-update', result.hasUpdate);

    onChecked?.(result);
    if (result.hasUpdate) {
      onAvailable?.(result);
      window.ALOOKHOR?.toast?.(`آپدیت v${result.latest} آماده نصب است`, 'update');
    }
    return result;
  }

  runCheck(false);
  const timer = window.setInterval(() => runCheck(false), 6 * 60 * 60 * 1000);

  return {
    get pending() { return state.pendingVersion; },
    get hasUpdate() { return state.hasUpdate; },
    get configured() { return state.configured; },
    get installable() { return state.installable; },
    get message() { return state.message; },
    check(force = true) { return runCheck(force); },
    destroy() { window.clearInterval(timer); }
  };
}
