// ALOOKHOR Update System — WordPress-native private updater
// UI/state remain modular; version discovery and installation are delegated to WordPress.

const runtimeConfig = window.ALOOKHOR_CC || {};
const runtimeVersion = String(runtimeConfig.version || '3.10.139');

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
    { tag: 'NAV INDICATOR', title: 'v3.10.137 — زیرخط متحرک منو', desc: 'نشانگر طلایی با Hover و Focus بین لینک‌ها حرکت و به صفحه فعال بازمی‌گردد.' },
    { tag: 'WHY COMPLETE', title: 'v3.10.139 — محتوای کامل چرا آلوخور', desc: 'تمام متن‌ها، آمار، رنگ‌ها و ترکیب بصری مطابق مرجع اضافه و در بوتیک قابل ویرایش شد.' },
    { tag: 'WHY MOTION', title: 'v3.10.136 — چرا آلوخور شیشه‌ای و متحرک', desc: 'Glass، Shine، Hover، Reveal مرحله‌ای و شمارنده پویا اضافه شد.' },
    { tag: 'NAV FRAME', title: 'v3.10.134 — قاب نورانی منوی اصلی', desc: 'نوار طلایی باریک و پیوسته با Glow کنترل‌شده دور کپسول منو اضافه شد.' },
    { tag: 'ELEMENTOR FIX', title: 'v3.10.133 — رفع خطای 500 Elementor', desc: 'CSS تکراری سنگین از AJAX ذخیره حذف و شورت‌کدها به دارایی‌های Cacheable متصل شدند.' },
    { tag: 'WHY ALOOKHOR', title: 'v3.10.132 — چرا آلوخور؟', desc: 'بخش مزیت‌ها و آمار واقعی با شورت‌کد و تنظیمات کامل بوتیک اضافه شد.' },
    { tag: 'PREMIUM COLLECTION', title: 'v3.10.131 — مجموعه منتخب لوکس', desc: 'کارت‌های کامل WooCommerce، بوته طلایی، امتیاز، توضیح و CTA مطابق مرجع اضافه شد.' },
    { tag: 'COLOR AUTHORITY', title: 'v3.10.129 — اختیار کامل رنگ در بوتیک', desc: 'Override مرکزی حذف شد و هر بخش مستقیماً رنگ ذخیره‌شده خودش را اعمال می‌کند.' },
    { tag: 'TRUST CARDS', title: 'v3.10.128 — بازگشت کارت‌های تیره ویژگی', desc: 'قانون سفید قدیمی خنثی و کارت‌ها به بنفش تیره انتخابی بازگشتند.' },
    { tag: 'STRICT PALETTE', title: 'v3.10.127 — فقط سه بنفش نهایی', desc: 'تمام رنگ‌های سطح قدیمی حذف و ماژول‌ها به سه کد انتخابی محدود شدند.' },
    { tag: 'THREE PLUM', title: 'v3.10.126 — چرخه سه‌رنگ کانتینرها', desc: 'سه رنگ انتخابی مالک به ترتیب واقعی بخش‌ها تکرار می‌شوند.' },
    { tag: 'PLUM RHYTHM', title: 'v3.10.125 — بنفش‌های یکی‌درمیان', desc: 'کانتینرهای Homepage به‌ترتیب بین #2B0A3D و #3A0D5C جابه‌جا می‌شوند.' },
    { tag: 'RICH PLUM', title: 'v3.10.124 — بنفش آلویی پررنگ', desc: 'سطوح روشن با رنگ جدید #2B0D3A و کارت‌های بنفش برند جایگزین شدند.' },
    { tag: 'WARM LUXURY', title: 'v3.10.121 — سطوح گرم لوکس', desc: 'سفید سرد با Warm Light، Sand و Premium Ivory هماهنگ با بنفش/طلایی برند جایگزین شد.' },
    { tag: 'DESIGN SYSTEM', title: 'v3.10.120 — پالت مرکزی ALOOKHOR', desc: 'ریتم White/Cream/Purple/Deep Purple و شش توکن نهایی روی تمام ماژول‌ها اعمال شد.' },
    { tag: 'CATEGORY TABS', title: 'v3.10.119 — فیلتر واقعی تب‌های پرفروش', desc: 'Runtime v4 و دسته‌های والد اضافه شد تا هر تب فقط محصولات مرتبط را نشان دهد.' },
    { tag: 'BESTSELLERS UX', title: 'v3.10.118 — تب، Loop و تایمر پرفروش‌ها', desc: 'Runtime تب‌ها و اسلایدر بازنویسی و Countdown و Responsive حرفه‌ای اضافه شد.' },
    { tag: 'FOOTER TYPE', title: 'v3.10.116 — تایپوگرافی حرفه‌ای فوتر', desc: 'Vazirmatn WOFF2 محلی و مقیاس استاندارد تیتر، لینک، توضیح، تماس و کپی‌رایت اعمال شد.' },
    { tag: 'NO WHITE SEAMS', title: 'v3.10.115 — حذف کامل درزهای سفید', desc: 'Wrapperهای تو در تو و Spacerهای Elementor/Woodmart با سطح بنفش یکپارچه شدند.' },
    { tag: 'ZERO WHITE GAPS', title: 'v3.10.114 — حذف فاصله سفید شورت‌کدها', desc: 'فاصله و پس‌زمینه سفید کانتینرهای Elementor میزبان ماژول‌ها به‌صورت Scoped حذف شد.' },
    { tag: 'LIVE HERO COLOR', title: 'v3.10.113 — اعمال واقعی رنگ Hero', desc: 'رنگ‌های ثابت حذف و تمام سطوح اسلایدر به رنگ ذخیره‌شده بوتیک متصل شدند.' },
    { tag: 'TRUE GLASS HERO', title: 'v3.10.112 — پنل شیشه‌ای واقعی Hero', desc: 'Overlay سنگین حذف و کنترل شفافیت و Blur پنل Hero به بوتیک اضافه شد.' },
    { tag: 'GLASS NAV', title: 'v3.10.111 — منوی شیشه‌ای یکپارچه', desc: 'لوگوی رسمی، همبرگری، لینک‌ها و ابزارها در کپسول بنفش/طلایی مطابق مرجع یکپارچه شدند.' },
    { tag: 'PURPLE HERO', title: 'v3.10.109 — هیروی بنفش با تصویر کامل', desc: 'پس‌زمینه Hero بنفش شد و تصاویر بدون برش، Shift یا Zoom کامل نمایش داده می‌شوند.' },
    { tag: 'FOOTER SHORTCODE', title: 'v3.10.107 — شورت‌کد رسمی فوتر', desc: '[alookhor_portal_footer] با جلوگیری از خروجی تکراری و پشتیبانی Elementor ثبت شد.' },
    { tag: 'MAGAZINE ACTIONS', title: 'v3.10.106 — لایک، ذخیره و Blob متحرک', desc: 'تصاویر هندسی متحرک و دکمه‌های واقعی لایک و ذخیره به مجله اضافه شد.' },
    { tag: 'MAGAZINE', title: 'v3.10.105 — مجله لوکس آلوخور', desc: 'نوشته‌های WordPress در کاروسل حرفه‌ای با تنظیمات کامل بوتیک نمایش داده می‌شوند.' },
    { tag: 'NEWSLETTER', title: 'v3.10.104 — خبرنامه حرفه‌ای', desc: 'فرم عضویت واقعی و امن با طراحی تمام‌عرض و تنظیمات کامل بوتیک اضافه شد.' },
    { tag: 'INFINITE LOOP', title: 'v3.10.103 — Loop بدون خروج پرفروش‌ها', desc: 'Translate حذف و Loop با چرخش کارت‌ها پیاده شد؛ هیچ فضای خالی یا سرریز باقی نمی‌ماند.' },
    { tag: 'CAMPAIGN FULL BLEED', title: 'v3.10.102 — پس‌زمینه تمام‌عرض کمپین', desc: 'فضای سفید حذف و پس‌زمینه بنفش قابل تنظیم تا لبه‌های صفحه کشیده شد.' },
    { tag: 'LOOP FIX', title: 'v3.10.100 — رفع جهت و Loop پرفروش‌ها', desc: 'کارت‌ها دیگر از Viewport خارج نمی‌شوند و فلش‌ها و Autoplay به‌صورت دوطرفه Loop می‌شوند.' },
    { tag: 'CATEGORY FIX', title: 'v3.10.98 — رفع شورت‌کد دسته‌بندی لوکس', desc: '[alookhor_managed_categories] در Elementor تثبیت و Runtime آن اصلاح شد.' },
    { tag: 'CAROUSEL LOCK', title: 'v3.10.97 — حذف قطعی ردیف دوم', desc: 'Flex و عرض کارت‌ها با specificity بالا در برابر Woodmart/Elementor قفل شد.' },
    { tag: 'BESTSELLERS CAROUSEL', title: 'v3.10.96 — پرفروش‌های تک‌ردیفه', desc: 'محصولات به اسلایدر یک‌ردیفه با فلش و Autoplay تبدیل شدند و ردیف دوم حذف شد.' },
    { tag: 'BESTSELLERS FIX', title: 'v3.10.95 — رفع خروجی خالی پرفروش‌ها', desc: 'مالکیت شورت‌کد تثبیت و fallback چندمرحله‌ای محصولات اضافه شد.' },
    { tag: 'BESTSELLERS', title: 'v3.10.94 — پرفروش‌ترین محصولات', desc: 'بخش پرفروش‌ها با تب دسته، آمار فروش و تنظیمات کامل بوتیک اضافه شد.' },
    { tag: 'CAMPAIGN SLIDER', title: 'v3.10.93 — بازیابی اسلایدر کمپین', desc: '[alookhor_campaign_slider] با ۶ اسلاید و تنظیم کامل بوتیک فعال شد.' },
    { tag: 'FEATURED VERIFIED', title: 'v3.10.92 — تثبیت محصولات منتخب', desc: 'محصولات منتخب فعال و سازگاری Health Check با شورت‌کد مستقیم Elementor اصلاح شد.' },
    { tag: 'FEATURED PRODUCTS', title: 'v3.10.90 — بازیابی محصولات منتخب', desc: '[alookhor_featured_products] با کاروسل WooCommerce و تنظیمات کامل بوتیک فعال شد.' },
    { tag: 'APP ICONS', title: 'v3.10.89 — آیکن‌های استاندارد فروشگاه‌ها', desc: 'نمادهای قبلی با SVGهای رنگی بازار، مایکت، Apple و More جایگزین شدند.' },
    { tag: 'APP BANNER', title: 'v3.10.88 — فعال‌سازی بنر اپلیکیشن', desc: '[alookhor_app_banner] با لینک فروشگاه‌ها، طراحی تمام‌عرض و تنظیمات کامل بوتیک فعال شد.' },
    { tag: 'LUXURY FEATURES', title: 'v3.10.87 — ویژگی‌های لوکس متحرک', desc: 'نوار چهارستونه مشکی/طلایی با Glow آیکن، Shine کارت و تنظیم کامل بوتیک برای [alookhor_managed_features] اضافه شد.' },
    { tag: 'EXPORT FULL BLEED', title: 'v3.10.86 — بنر صادراتی تمام‌عرض', desc: 'پس‌زمینه بنر به لبه‌های چپ و راست صفحه چسبید و فضای سفید جانبی حذف شد.' },
    { tag: 'EXPORT BANNER', title: 'v3.10.85 — بنر صادراتی در مدیریت بوتیک', desc: 'تصویر، لوگو، متن‌ها، دو واتساپ، رنگ‌ها و افکت‌های [alookhor_export_banner] داخل بوتیک یکپارچه شد.' },
    { tag: 'FULL BLEED', title: 'v3.10.84 — پس‌زمینه تمام‌عرض مرکز سورت', desc: 'پس‌زمینه تا لبه‌های صفحه کشیده شد اما همه گزینه‌ها داخل کانتینر ۱۳۸۰px وسط‌چین ماندند.' },
    { tag: 'SORT ICONS', title: 'v3.10.83 — محصولات و مزیت‌های متحرک', desc: 'چیپ محصولات و ۴ کارت مزیت با آیکن SVG متحرک و مدیریت کامل به مرکز سورت اضافه شد.' },
    { tag: 'SORT FIX', title: 'v3.10.82 — رفع نمایش مرکز سورت', desc: 'آمار اضافی حذف، تصاویر سمت راست و بارگذاری داخل Elementor اصلاح شد.' },
    { tag: 'SORT CENTER', title: 'v3.10.80 — مرکز سورت اسلایدی', desc: '[alookhor_sort_center] با ۶ تصویر و تنظیمات کامل محتوا، رنگ و حرکت به مدیریت بوتیک اضافه شد.' },
    { tag: 'ONE HERO SHORTCODE', title: 'v3.10.79 — یک شورت‌کد رسمی اسلایدر', desc: '[alookhor_managed_hero] تنها اسلایدر فعال است؛ نسخه VIP قدیمی خنثی و همه تنظیمات در بوتیک یکپارچه شد.' },
    { tag: 'PIXEL PERFECT GAP', title: 'v3.10.78 — حذف کامل نوار سفید اسلایدر', desc: 'Hero بدون فاصله از لبه پایین Topbar آغاز می‌شود.' },
    { tag: 'ZERO HERO GAP', title: 'v3.10.77 — جابه‌جایی اسلایدر به نوار بالا', desc: 'فضای رزروشده اولیه قالب از بالای Hero حذف شد.' },
    { tag: 'HERO UNDER MENU', title: 'v3.10.76 — اسلایدر زیر منوی شیشه‌ای', desc: 'اسلایدر از زیر کپسول منوی اصلی شروع می‌شود و Sticky حفظ شده است.' },
    { tag: 'NO HALO', title: 'v3.10.75 — حذف هاله سراسری زیر منو', desc: 'سایه مشکی/بنفش تمام‌عرض حذف شد و سایه فقط روی کپسول باقی ماند.' },
    { tag: 'CAPSULE ONLY', title: 'v3.10.74 — شیشه فقط روی کپسول منو', desc: 'پس‌زمینه بنفش سراسری چپ و راست منو حذف شد؛ شفافیت و Blur فقط روی خود کپسول گرد منو اعمال می‌شود.' },
    { tag: 'GLASS THEME', title: 'v3.10.73 — کنترل شیشه و رنگ‌بندی کامل هدر', desc: 'فعال‌سازی شیشه‌ای، درصد شفافیت، شدت Blur و ۱۴ رنگ اجزای هدر از مدیریت بوتیک قابل تنظیم شد.' },
    { tag: 'FLUSH TOP', title: 'v3.10.72 — هدر چسبیده به بالای صفحه', desc: 'فاصله سفید بالای هدر حذف شد: Body offset رزروشده Woodmart صفر، Header آن مخفی و پس‌زمینه Body همرنگ هدر شد — فقط روی صفحات دارای هدر AKX.' },
    { tag: 'MENU TYPOGRAPHY', title: 'v3.10.71 — منوی اصلی وسط‌چین + فونت خواناتر', desc: 'محتوای نوار منو دوباره داخل کانتینر ۱۳۸۰px وسط‌چین شد (تمام‌عرض فقط برای نوار بالا)؛ لینک‌های منو ۱۵px با وزن ۶۰۰ و مگامنو خواناتر شد.' },
    { tag: 'STATIC COPY PURGE', title: 'v3.10.70 — حذف کپی Static قدیمی هدر از صفحه', desc: 'روی صفحه اصلی یک کپی قدیمی HTML هدر با CSS اینلاین (۱۳۸۰px و فونت ریز) داخل ویجت HTML المنتور بود که ظاهر هدر واقعی را override می‌کرد؛ حالا خودکار حذف می‌شود و CSS افزونه همیشه غالب است.' },
    { tag: 'DEDUPE + TYPO', title: 'v3.10.69 — حذف هدر تکراری + فونت بزرگ‌تر', desc: 'هدر خارجی تکراری (نوار بالایی غیر تمام‌عرض با ظاهر قدیمی) حذف شد؛ فونت‌های هدر بزرگ‌تر شدند و کش صفحه بعد از آپدیت خودکار پاک می‌شود.' },
    { tag: 'FULL-WIDTH + STICKY', title: 'v3.10.68 — هدر تمام‌عرض و نوار دوم چسبان', desc: 'سقف عرض ۱۳۸۰px حذف شد و Mainbar کپسول منو هنگام اسکرول به بالای صفحه می‌چسبد؛ Topbar عادی خارج می‌شود و هیچ پرش محتوایی رخ نمی‌دهد.' },
    { tag: 'CRITICAL FIX', title: 'v3.10.67 — رفع کرش ماژول مدیریت بوتیک', desc: 'مقدار پیش‌فرض email به اشتباه کد PHP در JS بود و ReferenceError می‌داد؛ ماژول بوتیک هنگام لود می‌شکست.' },
    { tag: 'HEADER FIX', title: 'v3.10.66 — دکمه ذخیره هدر AKX فعال شد', desc: 'فرم ۱۴ فیلدی هدر داخل مدیریت بوتیک قبلاً فقط‌خواندنی بود (selector اشتباه)؛ حالا «ذخیره هدر» واقعاً در WordPress ذخیره و تأیید می‌شود.' },
    { tag: 'HEADER DEDUPE', title: 'v3.10.57 — حذف قطعی Header دوم', desc: 'Header مرجع مالک تنها خروجی قابل مشاهده است؛ Header خارجی و shortcode خام حذف شد؛ Portal واقعی با Logo و Menu اصلی حفظ شد.' },
    { tag: 'SINGLE HEADER', title: 'v3.10.56 — حذف Header تکراری و تطبیق مرجع', desc: 'فقط Header مدیریت‌شده باقی می‌ماند؛ Top Bar، Logo، منوی واقعی، Cart/Account و Hamburger مطابق image.png.' },
    { tag: 'HEADER REFERENCE', title: 'v3.10.19 — Top Bar و منوی اصلی مرجع', desc: 'Top Bar شیشه‌ای، ترتیب Support/Message/Phone و ادغام Node واقعی منوی WordPress داخل کپسول Desktop اجرا شد.' },
    { tag: 'GLASS CAPSULE', title: 'v3.10.18 — کپسول شیشه‌ای ردیف دوم', desc: 'همان Main Header Capsule با Glass RGBA و پالت Burgundy/Gold جدید، بدون تغییر ساختار یا کنترل‌ها.' },
    { tag: 'FEATURE GAP', title: 'v3.10.17 — اتصال دقیق ویژگی‌ها به Hero', desc: 'فاصله زنده 21.4px به حدود 7px کاهش یافت تا چهار کارت مانند مرجع بلافاصله زیر Hero قرار گیرند.' },
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
