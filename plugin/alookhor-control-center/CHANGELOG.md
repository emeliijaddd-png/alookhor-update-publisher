# Changelog — ALOOKHOR Control Center (WP Plugin)

## v3.8.7 — 2026-08-11 — Top Bar Persistence & Activation-State Recovery
- FIX: هر دو دکمه ذخیره پنل اصلی ابتدا کنترل‌های باز Top Bar را به State منتقل و سپس در WordPress ذخیره می‌کنند.
- FIX: Toast موفقیت فقط پس از پاسخ موفق واقعی AJAX نمایش داده می‌شود؛ شکست ذخیره دیگر به‌اشتباه Success نشان نمی‌دهد.
- FIX: نرمال‌سازی سروری رنگ‌ها، URLها، Booleanها و اندازه‌های Top Bar در مسیر ذخیره پنل اصلی.
- CACHE: endpoint عمومی و فقط‌خواندنی برای مقادیر از قبل عمومی Top Bar؛ Manager با `no-store` مقدار تازه را روی HTML کش‌شده اعمال می‌کند.
- COMPAT: تشخیص مقاوم لایه واقعی Top Bar در هدر Legacy و اعمال رنگ روی Wrapper/Container و فرزندان متنی بدون بازطراحی DOM.
- FIX: ثبت وضعیت Active/Network Active پیش از `Plugin_Upgrader` و بازیابی محدود آن پس از جایگزینی موفق فایل‌ها.
- SECURITY: Reactivation فقط برای همین افزونه و فقط در صورت فعال‌بودن پیش از بروزرسانی انجام می‌شود؛ Capability تازه‌ای به Publisher داده نمی‌شود.
- API: مسیر نصب REST پس از Upgrader وضعیت Activation را صریحاً بررسی می‌کند و در صورت شکست، گزارش خطای واقعی می‌دهد.
- CI: وضعیت آخرین Activation Restore در REST Status ثبت می‌شود تا تست Production قابل اثبات باشد.
- COMPAT: هدر، Top Bar، تنظیمات، ساختار ماژولار و تمام قواعد Responsive بدون تغییر حفظ می‌شوند.
- RELEASE: Bridge انتقال 3.8.6 → 3.8.7 و Access Audit موفق شدند؛ Release برای انتشار اتمی آماده است.

## v3.8.6 — 2026-08-11 — Managed Top Bar
- ADD: کنترل کامل Top Bar داخل پنل اصلی: «تنظیمات پیشرفته → تنظیمات سریع هر ماژول → هدر و لوگوها».
- ADD: صفحه فرعی «نوار بالای سایت و هدر» به‌عنوان Mirror کمکی با همان Option مشترک.
- ADD: ویرایش تلفن، ایمیل، WhatsApp، متن/لینک صادرات و متن/لینک CTA خرید عمده.
- ADD: نمایش/عدم نمایش مستقل تلفن، ایمیل، WhatsApp، صادرات، خرید عمده و کل Top Bar.
- ADD: انتخاب لوگوی مرکزی از Media Library، لینک، Alt و عرض لوگو.
- ADD: کنترل رنگ پس‌زمینه، متن، حاشیه، دکمه CTA و ارتفاع Top Bar.
- COMPAT: Wrapper خنثی و Manager سازگار برای کنترل هدر قدیمی بدون بازطراحی Mega Menu یا حذف قابلیت‌های آن.
- RESPONSIVE: حفظ کامل رفتار فعلی هدر و اعمال تنظیمات بدون تغییر ساختار DOM اصلی.
- STATUS: تا تأیید معماری Publisher و تست کامل روی کانال Production منتشر نمی‌شود.
- SECURITY: الزام SHA-256 معتبر در Manifest و بررسی بسته دانلودشده قبل از Core Upgrader.
- SECURITY: محدودکردن Package Host به HTTPS و `updates.alookhor.ir`.
- API: افزودن REST API احراز هویت‌شده با WordPress Application Password برای Status، Check و Install.
- SAFETY: قفل هم‌زمانی Update و الزام WordPress 6.3+ برای پشتیبانی Core Rollback در بروزرسانی خودکار.

## v3.8.5 — 2026-08-11 — Header Recovery & Native Update Release
- RECOVERY: ثبت `docs/PROJECT_MEMORY.md` شامل معماری، قوانین Responsive، قرارداد ماژول و نقطه توقف واقعی.
- FIX: Migration ایمن برای ادغام حافظه ناقص `wp_options` با `config/site.json`؛ مقادیر کاربر حفظ و تعریف ۸ ماژول و پیشنهادهای AI گمشده ترمیم می‌شوند.
- FIX: Cache ناقص دیگر مانع بارگذاری Defaults نمی‌شود و منبع واقعی Config در پنل نمایش داده می‌شود.
- RESTORE: بازیابی هدر دو‌ردیفه Luxury مطابق هویت اصلی: Top Bar، لوگوی WordPress، CTA خرید عمده، اطلاعات تماس، حساب کاربری و نوار شیشه‌ای شناور.
- RESTORE: تشخیص خودکار فهرست Primary/Header از WordPress و نمایش تمام فهرست‌ها در Hamburger حرفه‌ای Accordion.
- COMPAT: اگر پیاده‌سازی قدیمی `[alookhor_portal_header]` هنوز در Code Snippets یا قالب فعال باشد، افزونه آن را Override نمی‌کند.
- RESPONSIVE: Drawer دسترس‌پذیر با Focus Trap، Escape، Backdrop، Body Lock و پشتیبانی 320 تا 1920px.
- FIX: ذخیره سریع Config دیگر تنظیمات Top Bar/Menu/Contact را از Option هدر حذف نمی‌کند.
- BUILD: نسخه‌بندی همه ES Modules و Front assets با `3.8.5` برای جلوگیری از اجرای Cache قدیمی پس از آپدیت.
- FIX: همگام‌سازی Update Center با نسخه واقعی افزونه؛ نسخه UI دیگر از `3.8.3` به‌صورت Hard-code خوانده نمی‌شود.
- UPDATE: جایگزینی آپدیت نمایشی `localStorage` با زیرساخت خصوصی و WordPress-native (`wp_safe_remote_get` + update transient + `wp.updates.updatePlugin`).
- SECURITY: اعتبارسنجی Manifest، Nonce و `manage_options` برای بررسی آپدیت.
- SECURITY: پاک‌سازی بازگشتی State قبل از ذخیره در `wp_options` و استفاده از `wp_unslash` به‌جای `stripslashes`.
- FIX: ذخیره تنظیمات هدر دیگر رنگ، Sticky، Search و CTA موجود را حذف نمی‌کند.
- FIX: اصلاح لینک شکسته «حافظه پروژه» و حذف متن `\\n` ناخواسته از قالب.
- RESPONSIVE: جایگزینی enqueue سراسری `luxury.css` در فرانت با `frontend-header.css` کاملاً Scoped تا قالب WordPress/Elementor/Woodmart override نشود.
- RELEASE: ارتقا `3.8.4` → `3.8.5` برای انتشار مستقیم از Update Center؛ هیچ حذف یا Upload مجددی لازم نیست.
- CHANNEL: ثبت endpoint دائمی `https://updates.alookhor.ir/manifest.json` در هسته نسخه 3.8.5.
- FIX: حذف وابستگی Installer پرتال به `wp.updates.updatePlugin()` و DOM صفحه Plugins؛ نصب اکنون از URL امن و nonceدار Core Upgrader انجام می‌شود.

## v3.8.4 — 2026-08-11 — Fix Boutique Empty
- FIX: جلوگیری از خالی‌ماندن بخش «تنظیمات بوتیک» با Guard کامل برای `cfg.system`، `cfg.modules`، `cfg.site`، `cfg.header_settings` و `cfg.ai_assistant`.
- FIX: سه پنل دستیار هوشمند، سلامت سیستم و ماژول‌ها حتی با داده ناقص رندر می‌شوند.
- ADD: PHP Fallback Dashboard برای حالتی که ES Modules لود نمی‌شوند.

## v3.8.3 — 2026-08-10 — Console & Storage Hotfix
- FIX: خطاهای `Object.values` روی config ناقص.
- FIX: مدیریت محدودیت Tracking Prevention برای Local Storage.
- ADD: Fallback محافظتی برای خطاهای Client-side.

## v3.8.2 — 2026-08-10 — Hotfix Critical
- FIX: `SyntaxError: Unexpected token 'export'` در `config.js`؛ حذف enqueue اشتباه به عنوان اسکریپت معمولی و لود فقط به صورت ES Module از `app.js`.
- FIX: `TypeError: Cannot read properties of undefined` در `Config.apply()`؛ افزودن Guard برای `d.modules` و `d.site`.
- FIX: قراردادن دسترسی‌های `localStorage` داخل `try/catch` برای Safari ITP.
- FIX: استفاده از `site_json_url` مطلق در WP Admin به‌جای `./config/site.json`.
- Version bump `3.8.1` → `3.8.2`.
