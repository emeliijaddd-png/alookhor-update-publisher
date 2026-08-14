// ALOOKHOR Update System — WordPress-native private updater
// UI/state remain modular; version discovery and installation are delegated to WordPress.

const runtimeConfig = window.ALOOKHOR_CC || {};
const runtimeVersion = String(runtimeConfig.version || '3.10.16');

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
    { tag: 'SITE FEATURES', title: 'v3.10.16 — ویژگی‌های چهارکارته مرجع', desc: 'بخش Trust قدیمی با چهار کارت یک‌ردیفه Responsive و پالت Burgundy/Gold مدیریت‌شده جایگزین شد.' },
    { tag: 'IMAGE CLEANUP', title: 'v3.10.15 — حذف کامل نوشته قدیمی بنر', desc: 'فوکوس Desktop عمیق‌تر و ماسک پایین، Copy و Badgeهای baked تصویر قبلی را از ترکیب جدید خارج می‌کند.' },
    { tag: 'HERO POLISH', title: 'v3.10.14 — اتصال Mobile و کنترل‌های ایزوله', desc: 'Hero زیر کپسول شیشه‌ای قرار گرفت، Arrow سفید قالب مهار شد و فوکوس عکس بدون Mirror اصلاح شد.' },
    { tag: 'MANAGED HERO', title: 'v3.10.13 — اسلایدر چهاراسلایدی مدیریت‌شده', desc: 'چهار تصویر Media Library، متن‌های مستقل، CTA و جایگزینی خودکار Hero قدیمی در Desktop/Mobile.' },
    { tag: 'LOGO ALIGN', title: 'v3.10.12 — تراز عمودی نهایی', desc: 'Symbol لوگوی Desktop شش پیکسل بالا رفت تا Geometry کپسول کاملاً پاس شود.' },
    { tag: 'LOGO GEOMETRY', title: 'v3.10.11 — مهار لوگوی Desktop', desc: 'Symbol لوگوی افقی به 50px محدود شد تا داخل Capsule باقی بماند.' },
    { tag: 'ACCOUNT ICON', title: 'v3.10.10 — تکمیل کنترل حساب', desc: 'SVG حساب به لینک متنی Legacy اضافه شد تا کنار Cart در Mobile دیده شود.' },
    { tag: 'MOBILE MATCH', title: 'v3.10.9 — تطبیق نهایی با مرجع', desc: 'لوگوی افقی، Account آیکنی، Cart چپ، Hamburger راست و Top Bar سه‌بخشی اجرا شد.' },
    { tag: 'LIVE BROWSER', title: 'v3.10.8 — رفع Offset و Sticky واقعی', desc: 'فضای خالی بالای سایت حذف، Navigation Desktop واقعاً ثابت و لوگو داخل کپسول مهار شد.' },
    { tag: 'HEADER FIX', title: 'v3.10.7 — کپسول Mobile مطابق مرجع', desc: 'Search و ردیف اضافه حذف؛ Hamburger راست، لوگو وسط و حساب/سبد چپ قرار گرفتند.' },
    { tag: 'BRAND STATE', title: 'v3.10.6 — پالت واقعی Black/Gold', desc: 'رنگ‌های مرجع Orange/Green حذف و شماره تأییدشده 3173 با مهاجرت محدود بازیابی شد.' },
    { tag: 'HEADER UX', title: 'v3.10.5 — Sticky فقط برای Navigation', desc: 'Top Bar و Header اصلی در جریان صفحه‌اند؛ منوی اصلی بدون پرش محتوا به بالای viewport می‌چسبد.' },
    { tag: 'ADMIN UX', title: 'v3.10.4 — بوتیک اصلی و Workspace وسیع', desc: 'بوتیک به بالای پنل منتقل شد؛ فضای مدیریت عریض و AI/سلامت سیستم فقط مخصوص Dashboard شدند.' },
    { tag: 'ELEMENTOR', title: 'v3.10.3 — جایگاه مستقیم دسته‌بندی‌ها', desc: 'شورت‌کد مدیریت‌شده Elementor، فلش Desktop ایزوله و کنترل‌های تک‌صفحه هوشمند شدند.' },
    { tag: 'MOBILE UI', title: 'v3.10.2 — حذف Arrow و Pagination مرجع', desc: 'فلش‌های موبایل حذف و Dotها به Active pill طلایی + circle خاکستری تبدیل شدند.' },
    { tag: 'MOBILE UX', title: 'v3.10.1 — Carousel حرفه‌ای موبایل', desc: 'کارت کوتاه‌تر، Centered Peek، Infinite loop، فلش SVG و Dotهای پویا.' },
    { tag: 'WOOCOMMERCE', title: 'v3.10.0 — دسته‌بندی محصولات Desktop', desc: 'Carousel واقعی product_cat ووکامرس با تنظیمات کامل در پنل اصلی.' },
    { tag: 'ADMIN UI', title: 'v3.9.2 — فرم منظم تنظیمات فوتر', desc: 'تمام فیلدها، انتخاب رسانه، رنگ‌ها و منوها با Grid Responsive و بدون هم‌پوشانی نمایش داده می‌شوند.' },
    { tag: 'FOOTER', title: 'v3.9.1 — تطبیق نهایی Desktop', desc: 'ترتیب خبرنامه، تصویر، اجتماعی، مجوزها و Copyright مطابق تصویر مرجع نهایی شد.' },
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
