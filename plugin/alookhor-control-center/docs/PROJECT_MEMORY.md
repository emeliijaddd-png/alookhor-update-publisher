# ALOOKHOR Control Center — Project Memory

> این فایل مرجع تداوم پروژه است. هنگام ادامه توسعه، ابتدا این سند، `CHANGELOG.md` و نسخه داخل `alookhor-control-center.php` بررسی شوند.

## Snapshot

- **نام افزونه:** ALOOKHOR Control Center
- **نسخه پایه بازیابی‌شده:** `3.8.4`
- **Production پیش از این Release:** `3.9.2` (فوتر مدیریت‌شده و UI پنل تأییدشده)
- **Release آماده انتشار اتمی:** `3.10.0` (فاز Desktop دسته‌بندی واقعی محصولات WooCommerce)
- **تاریخ بازیابی:** 2026-08-11
- **منبع بازیابی:** ZIP واقعی افزونه `alookhor-control-center (5).zip`
- **حداقل WordPress:** 6.0
- **حداقل PHP:** 8.0
- **Text domain:** `alookhor-cc`
- **گزینه اصلی:** `alookhor_cc_settings`
- **گزینه هدر:** `alookhor_header_settings`
- **شورت‌کد فرانت:** `[alookhor_portal_header]`

## آخرین نقطه توقف قطعی

آخرین مرحله قابل اثبات از روی کد، **Hotfix نسخه 3.8.4 برای خالی‌ماندن بخش «تنظیمات بوتیک»** است.

در این مرحله موارد زیر انجام شده بودند:

1. Guard برای `cfg.modules`، `cfg.system`، `cfg.site`، `cfg.header_settings` و `cfg.ai_assistant` در `assets/js/modules/settings.js`.
2. Guard برای `Config.apply()` جهت جلوگیری از خطای `Cannot read properties of undefined`.
3. حذف enqueue مستقیم `config.js` به‌عنوان اسکریپت معمولی و لود آن فقط به‌صورت ES Module از `app.js`.
4. انتقال URL فایل تنظیمات در محیط WordPress به `ALOOKHOR_CC.site_json_url`.
5. قرار دادن تمام دسترسی‌های مهم `localStorage` داخل `try/catch` برای Safari/Tracking Prevention.
6. افزودن داشبورد PHP Fallback در صورت لودنشدن ES Modules.

آخرین خطاهای ثبت‌شده در پروژه:

- `SyntaxError: Unexpected token 'export'`
- `TypeError: Cannot read properties of undefined at config.js`
- مسدودشدن Storage توسط Tracking Prevention
- 404 شدن `./config/site.json` در مسیر `/wp-admin/`
- خالی‌ماندن سه پنل تنظیمات بوتیک
- نمایش `0 / 0` برای ماژول‌ها و پنل AI خالی، ناشی از `wp_options` ناقص

در ادامه بازیابی، حافظه ناقص با `config/site.json` به‌صورت Defaults-first ادغام شد. داده‌های موجود کاربر روی Defaults قرار می‌گیرند؛ بنابراین مقادیر سفارشی حذف نمی‌شوند، اما تعریف ماژول‌ها و پیشنهادهای گمشده بازسازی می‌شوند. Config ناقص ذخیره‌شده در Local Storage نیز دیگر مانع بازیابی فایل Defaults نمی‌شود.

## معماری فعلی

```text
alookhor-control-center/
├── alookhor-control-center.php       # Bootstrap، ثابت‌ها، Activation و includeها
├── includes/
│   ├── admin.php                     # منوی مدیریت، enqueue و صفحات مدیریت
│   ├── ajax.php                      # AJAX ذخیره/خواندن تنظیمات و Toggleها
│   ├── updater.php                   # اتصال آپدیت خصوصی به هسته WordPress
│   └── shortcode-header.php          # شورت‌کد هدر فرانت
├── templates/
│   └── admin-control-center.php      # Shell، Sidebar، Fallback و Update Modal
├── assets/
│   ├── css/luxury.css                # Design System و Responsive پنل مدیریت
│   ├── css/frontend-header.css       # هدر دو‌ردیفه و Drawer، کاملاً Scoped
│   └── js/
│       ├── frontend-header.js        # Hamburger، Accordion و Focus Trap
│       ├── app.js                    # Registry و Router ماژول‌ها
│       ├── admin-wp.js               # Bridge محیط wp-admin
│       ├── core/
│       │   ├── config.js             # State، WP AJAX و حافظه محلی
│       │   ├── responsive.js         # Breakpoint/Drawer engine
│       │   └── updateSystem.js       # UI/state سیستم آپدیت
│       └── modules/
│           ├── dashboard.js
│           ├── orders.js
│           ├── inventory.js
│           ├── users.js
│           ├── analytics.js
│           └── settings.js
├── config/site.json                  # Defaults و fallback اولیه
├── docs/PROJECT_MEMORY.md            # همین سند
├── CHANGELOG.md
└── uninstall.php                     # حفظ داده هنگام Uninstall
```

## قانون پنل اصلی

هر قابلیت جدید باید کنترل کامل خود را داخل صفحه اصلی ALOOKHOR Control Center و ماژول مرتبط داشته باشد. صفحه‌های فرعی فقط Mirror/دسترسی کمکی هستند و نباید تنها محل تنظیم قابلیت باشند. State پنل اصلی و صفحه فرعی باید به Option مشترک متصل باشد.

## قرارداد ماژول‌ها

هر ماژول مستقل باید این رابط را حفظ کند:

```js
export const exampleModule = {
  meta: { id: 'example', title: 'عنوان ماژول' },
  init(container) {
    container.innerHTML = '...';
    // event binding
  },
  destroy() {
    // پاک‌سازی listener/timer در صورت نیاز
  }
};
```

برای افزودن ماژول جدید:

1. فایل مستقل در `assets/js/modules/` ساخته شود.
2. در `assets/js/app.js` import شود.
3. به registry با نام ثابت اضافه شود.
4. آیتم دارای `data-module="module-id"` در قالب Sidebar اضافه شود.
5. داده تنظیمات ماژول، در صورت نیاز، زیر `modules.<id>` قرار گیرد.
6. ماژول نباید مستقیماً ساختار Shell، Sidebar یا Responsive Engine را بازنویسی کند.
7. Timer و listenerهای سراسری باید در `destroy()` پاک شوند.

## قابلیت‌های پیاده‌سازی‌شده

### هسته WordPress

- نصب و Activation افزونه با بارگذاری defaults از `config/site.json`.
- ذخیره State در `wp_options`.
- خواندن و ذخیره تنظیمات با AJAX، Nonce و دسترسی `manage_options`.
- حفظ داده هنگام حذف افزونه.
- صفحه اختصاصی ALOOKHOR Center در wp-admin.

### UI و ماژول‌ها

- داشبورد Luxury با KPI، جدول/کارت و نمودار نمایشی.
- Sidebar فشرده شش‌گروهی با Accordion و جستجوی زنده.
- ماژول‌های مستقل Dashboard، Orders، Inventory، Users، Analytics و Settings.
- Placeholder لوکس برای منوهای برنامه‌ریزی‌شده.
- پنل تنظیمات سه‌بخشی: دستیار هوشمند، سلامت سیستم و ماژول‌ها.
- Export تنظیمات به JSON.
- Toggle ماژول‌ها و ذخیره بدون Refresh.
- PHP Fallback Dashboard.

### هدر فرانت

- شورت‌کد `[alookhor_portal_header]`.
- هدر دو‌ردیفه مطابق طرح اصلی: Top Bar و نوار شیشه‌ای شناور.
- استفاده خودکار از Custom Logo و Site Icon وردپرس.
- تشخیص خودکار فهرست Primary/Header و نمایش آن در Desktop Navigation.
- واکشی تمام فهرست‌های WordPress در Hamburger Drawer گروه‌بندی‌شده.
- Dropdown چندسطحی، Drawer Accordion، Search، Account، Cart و CTA خرید عمده.
- مدیریت کامل Top Bar از پیشخوان: تلفن، ایمیل، WhatsApp، متن/لینک صادرات و CTA عمده.
- نمایش مستقل هر آیتم، انتخاب لوگو از Media Library، Alt/Link/Width و کنترل رنگ‌ها و ارتفاع.
- حفظ Callback قدیمی شورت‌کد در صورت وجود؛ Wrapper خنثی + Compatibility Manager بدون بازطراحی Mega Menu.
- دسترس‌پذیری: ARIA، Focus Trap، Escape، Backdrop و Reduced Motion.

## قوانین Responsive — نباید شکسته شوند

Breakpointهای رسمی:

| نام | حداقل عرض |
|---|---:|
| xs | 0px |
| sm | 375px |
| md | 768px |
| lg | 1024px |
| xl | 1440px |
| xxl | 1920px |

قوانین ثابت:

1. هیچ صفحه‌ای نباید `overflow-x` در viewport ایجاد کند.
2. در کمتر از `1024px`، Sidebar به Drawer با Backdrop تبدیل می‌شود.
3. Drawer با Hamburger، کلیک Backdrop، Escape و انتخاب ماژول بسته می‌شود.
4. KPI: یک ستون در موبایل، دو ستون از `560px` و چهار ستون از `1024px`.
5. جدول‌ها زیر `768px` مخفی و با Card List جایگزین می‌شوند.
6. Header Search زیر `1024px` مخفی می‌شود.
7. مقادیر `min-width:0` و محدودیت‌های flex/grid برای جلوگیری از overflow حفظ شوند.
8. تست هدف: عرض‌های 320، 375، 768، 1024، 1440 و 1920 پیکسل.

## هویت بصری Luxury — نباید بازطراحی شود

- پس‌زمینه اصلی: `#070708`
- پنل‌ها: `#111113` و `#151518`
- طلایی اصلی: `#C9A86A`
- طلایی روشن: `#E8D5B5`
- متن اصلی: `#F5F1E9`
- موفقیت: `#3DD68C`
- خطر: `#FF5A5F`
- Radiusها: 12، 16 و 20 پیکسل
- سبک: Dark Glass + Gold، Border کم‌رنگ، Blur کنترل‌شده و Shadow عمیق
- فونت نمایشی: Cormorant Garamond؛ فونت UI: Inter/System

رنگ‌ها، Radiusها و Shadowها باید از CSS Variables موجود استفاده کنند. افزونه نباید به UI روشن، Material عمومی یا Bootstrap بازطراحی شود.

## سیستم آپدیت داخلی WordPress

در Snapshot اولیه، Update Center فقط نصب را در `localStorage` شبیه‌سازی می‌کرد و نسخه داخلی آن `3.8.3` بود؛ در حالی که نسخه واقعی افزونه `3.8.4` بود. این ناسازگاری در مرحله ادامه بازیابی اصلاح شد.

ساختار فعلی:

- PHP: `includes/updater.php`
- JS: `assets/js/core/updateSystem.js`
- نصب واقعی: URL امن و nonceدار `wp-admin/update.php?action=upgrade-plugin` (Core Upgrader، مستقل از DOM صفحه Plugins)
- کش Manifest: Site Transient به مدت شش ساعت
- بررسی دسترسی: `manage_options` + Nonce
- دریافت امن: `wp_safe_remote_get`
- الزام Package Host امن: `https://updates.alookhor.ir`
- بررسی SHA-256 بسته در `upgrader_pre_download` قبل از Extract/Install
- REST API مدیریتی: `/wp-json/alookhor-cc/v1/status|check-update|install-update`
- احراز هویت REST فقط با WordPress Application Password و capability `update_plugins`
- قفل هم‌زمانی و الزام WordPress 6.3+ برای Core Rollback در بروزرسانی خودکار

کانال Production از نسخه `3.8.5` به بعد به‌صورت پیش‌فرض روی این آدرس است:

```text
https://updates.alookhor.ir/manifest.json
```

برای اتصال یک‌باره نسخه نصب‌شده `3.8.4`، فیلتر زیر در Code Snippets فعال می‌شود؛ پس از ارتقا، endpoint در خود افزونه وجود دارد:

```php
add_filter('alookhor_cc_update_manifest_url', function () {
    return 'https://updates.alookhor.ir/manifest.json';
});
```

در صورت نیاز، ثابت `ALOOKHOR_CC_UPDATE_MANIFEST_URL` در `wp-config.php` همچنان endpoint پیش‌فرض را Override می‌کند.

Schema حداقلی Manifest:

```json
{
  "version": "3.10.0",
  "download_url": "https://updates.alookhor.ir/releases/alookhor-control-center-3.10.0.zip",
  "details_url": "https://alookhor.ir/changelog",
  "requires": "6.0",
  "tested": "7.0",
  "requires_php": "8.0",
  "changelog": [
    {
      "tag": "FIX",
      "title": "عنوان تغییر",
      "desc": "شرح تغییر"
    }
  ]
}
```

## قابلیت‌های ناقص یا نمایشی

موارد زیر هنوز به API/داده واقعی متصل نیستند یا فقط UI دارند:

- Dashboard KPIs و Chartها
- Orders و Users data
- Inventory data و فیلتر واقعی
- Analytics data
- Invoices، Quotes، Returns، Products، Categories، Collections
- Club، Tickets، Reviews
- Transactions، Gold Price، Accounting
- Sales/Stock Reports، Roles و Logs
- پیشنهادهای AI (در حال حاضر داده تنظیماتی هستند، نه سرویس AI واقعی)
- System Health (در حال حاضر بیشتر مقادیر از config خوانده می‌شوند)
- خروجی Excel و ایجاد سفارش

همچنین محتوای برخی ماژول‌ها هنوز مربوط به نمونه جواهر/طلا است، در حالی که `site.json` کسب‌وکار آلو بخارا، سورت و بسته‌بندی را تعریف می‌کند. این محتوا نباید بدون تأیید محصول به‌صورت حدسی بازنویسی شود.

## ترتیب ادامه توسعه

1. تأیید پیش‌نمایش و انتشار نسخه 3.8.5 از Update Center روی محیط Staging.
2. انتقال Manifest موقت به دامنه دائمی Update Server و ثبت کانال Production.
3. اتصال Inventory به داده واقعی WooCommerce و افزودن Search/Filter بدون تغییر قرارداد ماژول.
4. جایگزینی KPIهای نمایشی با داده واقعی WooCommerce.
5. تکمیل ماژول‌های Placeholder به‌ترتیب اولویت کسب‌وکار.
6. تست Responsive در شش عرض رسمی.
7. تست امنیتی AJAX، Sanitization و Escaping.

## قانون نسخه

نسخه فقط هنگام ساخت Release قابل نصب تغییر کند. از نسخه `3.8.5` به بعد، انتشار رسمی صرفاً از Update Center انجام می‌شود و نصب با حذف/Upload مجدد افزونه ممنوع است. نسخه PHP، `site.json`، Readme، Changelog، ES Modules و نمایش نسخه در UI باید هم‌زمان تغییر کنند.
