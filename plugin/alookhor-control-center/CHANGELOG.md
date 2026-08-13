# Changelog — ALOOKHOR Control Center (WP Plugin)

## v3.10.12 — 2026-08-13 — Final Desktop Logo Y Alignment
- BROWSER: Geometry زنده 3.10.11 فقط 5px خروج Symbol از پایین Capsule را ثبت کرد.
- FIX: `translateY(-6px)` فقط در `min-width:1024px`؛ هیچ تغییری در Mobile ندارد.
- ACCEPTANCE: Desktop و Mobile باید هم‌زمان تمام Visual checks را Pass کنند.

## v3.10.11 — 2026-08-13 — Desktop Logo Containment
- BROWSER: Chrome audit 3.10.10 تمام Mobile checks را پاس کرد و تنها بیرون‌زدگی 11px Symbol در Desktop را یافت.
- FIX: Symbol در هر دو viewport به 50px محدود شد؛ Wordmark افقی بدون تغییر باقی ماند.
- VERIFY: شرط `logo_contained_in_capsule` باید در Desktop و Mobile هم‌زمان Pass شود.

## v3.10.10 — 2026-08-13 — Mobile Account Icon Completion
- DETECT: Screenshot زنده نشان داد `.header-login-btn` در Source Legacy فقط Text دارد و هیچ SVG ندارد.
- FIX: SVG دسترس‌پذیر Account داخل همان Link موجود اضافه شد؛ URL، Class و عملکرد Login حفظ شدند.
- MOBILE: Text مخفی و Icon با اندازه 27px کنار Cart نمایش داده می‌شود.
- VISUAL CI: وجود دقیق یک `.alookhor-account-icon` در Chrome Mobile audit الزامی شد.

## v3.10.9 — 2026-08-13 — Exact Mobile Header Reference Match
- ACCOUNT: حذف متن و Pill بزرگ ورود در Mobile؛ فقط Icon استاندارد باقی ماند.
- CART: Cart واقعی WooCommerce در چپ‌ترین موقعیت با Badge پویا قرار گرفت.
- LOGO: تصویر موجود به Symbol دایره‌ای محدود و Wordmark «آلوخور» + زیرعنوان در ترکیب افقی شفاف افزوده شد.
- MENU: Hamburger ساده و بدون حلقه سنگین در سمت راست کپسول قرار گرفت؛ همان `#openDrawer` حفظ شد.
- TOPBAR: سه ناحیه Phone، پیام صادرات/ارسال مرکزی و پشتیبانی ۲۴/۷؛ لوگو و CTA تکراری حذف شدند.
- VISUAL CI: وجود Wordmark، Support و Account icon-only به Browser audit اضافه شد.

## v3.10.8 — 2026-08-13 — Live Browser Header Geometry Fix
- BROWSER: ممیزی Chrome واقعی Production در 1440×1050 و 430×932 همراه Screenshot و Geometry اجرا شد.
- OFFSET: تشخیص Padding رزروشده 135px Desktop و 100px Mobile روی Body و Padding داخلی 40px؛ Collapse فقط هنگام وجود Header مدیریت‌شده.
- STICKY: Elementor containing block مانع `position:sticky` بود؛ Navigation با Fixed rail و Marker هم‌اندازه در بالای viewport باقی می‌ماند.
- CLS: Marker هنگام Fixed شدن دقیقاً ارتفاع Stage را رزرو می‌کند و با بازگشت Stage صفر می‌شود.
- MOBILE: Fixed rail در ≤1023px غیرفعال و Stage/Marker کاملاً مخفی است.
- TOPBAR: لوگوی تکراری وسط Top Bar حذف و چیدمان Contact/Export فشرده شد؛ ارتفاع Mobile برابر 34px.
- LOGO: ارتفاع لوگوی اصلی Desktop/Mobile محدود و Wrapper دارای overflow امن شد تا از کپسول خارج نشود.
- AUDIT: Selenium Chrome screenshots/metrics به publisher-status اضافه شد تا Visual regressions قبل از تأیید شناسایی شوند.

## v3.10.7 — 2026-08-13 — Header Mobile Reference Correction
- REGRESSION: حذف کامل فرم Search ناخواسته از PHP/JS/CSS و پنل مدیریت.
- MOBILE: حذف Stage چسبان جداگانه در ≤1023px؛ فضای خالی و ردیف سوم Mobile دیگر تولید/نمایش نمی‌شود.
- LAYOUT: کپسول اصلی با Grid قطعی: Hamburger موجود در راست، لوگوی شفاف در مرکز، حساب و سبد خرید در چپ.
- DRAWER: همان Node و ID اصلی `#openDrawer` جابه‌جا شد؛ Clone، ID تکراری یا Drawer دوم ساخته نشد.
- WOO: افزودن لینک واقعی Cart و Count جاری WooCommerce به کپسول.
- DESKTOP: Navigation مستقل و Sticky فقط در Desktop حفظ شد؛ Search در Desktop نیز حذف شد.
- MIGRATION: `show_search=false` و Marker اصلاح Layout ثبت می‌شوند.

## v3.10.6 — 2026-08-13 — Header Brand-State Correction
- PALETTE: حذف رنگ‌های ذخیره‌شده Orange/Green مرجع و بازیابی Black/Gold واقعی ALOOKHOR برای Top Bar و Navigation.
- CONTACT: بازیابی شماره قطعی `09159513173` در Header Option و State اصلی؛ Footer مشترک نیز همین منبع را می‌خواند.
- MIGRATION: تغییر فقط ۱۵ فیلد مصوب Header با Marker دائمی، Before/After hash و فهرست دقیق Fields؛ سایر تنظیمات دست‌نخورده می‌مانند.
- VERIFY: REST Status مهاجرت را گزارش می‌کند و Release/Access audit پالت، تلفن، Sticky، Search و Marker را الزام می‌کنند.
- ADMIN: Defaults کامل تنظیمات Header برای رنگ‌های Navigation، Search و عرض لوگوی Desktop/Mobile در Mirror نیز تکمیل شد.

## v3.10.5 — 2026-08-13 — Navigation-Only Sticky Header
- DETECT: ممیزی CSS واقعی Production ثابت کرد Top Bar و `.alookhor-header` با `position:fixed!important` قفل شده بودند و Wrapper ارتفاع صفر داشت.
- COMPAT: همان DOM، Shortcode، WordPress Menu، Mega Menu، Drawer ID و کلاس‌های Legacy حفظ شدند؛ `.header-nav-center` موجود بدون بازسازی به Stage مستقل منتقل شد.
- FLOW: Top Bar و Header اصلی به جریان عادی صفحه بازگشتند و هنگام Scroll همراه صفحه حرکت می‌کنند.
- STICKY: فقط Navigation اصلی با `position:sticky` و Offset صحیح WordPress Admin Bar در بالای viewport باقی می‌ماند.
- CLS: Marker صفرارتفاع و Stage دارای Footprint ثابت از Layout Shift هنگام Sticky شدن جلوگیری می‌کنند.
- BRAND: سطح، متن، رنگ فرعی و Gold Navigation از تنظیمات ALOOKHOR خوانده می‌شوند؛ Blur فقط در حالت Stuck و به‌صورت ظریف فعال است.
- LOGO: همان تصویر شفاف برای Desktop/Mobile استفاده می‌شود و عرض هر حالت از پنل اصلی قابل تنظیم است.
- SEARCH: جستجوی واقعی WooCommerce به Header اصلی اضافه شد؛ وضعیت نمایش و Placeholder داخل مدیریت بوتیک قرار گرفت.
- MOBILE: Navigation چسبان Mobile با لوگوی مشترک و Trigger همان Drawer موجود ساخته شد؛ Event/ID اصلی Hamburger تغییر نکرد.
- SETTINGS: تنظیمات Sticky Navigation، Search، رنگ‌های Navigation و عرض لوگوی Desktop/Mobile به پنل اصلی و Mirror هدر اضافه شدند.
- FALLBACK: رفتار Sticky کل Wrapper در Renderer داخلی نیز به Sticky فقط برای `.alookhor-nav-stage` اصلاح شد.

## v3.10.4 — 2026-08-13 — Boutique-First Admin Workspace
- NAVIGATION: انتقال «مدیریت بوتیک» به آیتم اصلی بالای Sidebar و انتخاب آن به‌عنوان صفحه پیش‌فرض پنل.
- PRIORITY: انتقال گروه‌های فروش، مشتریان، مالی و گزارش‌های آزمایشی به پایین Navigation و بسته‌بودن پیش‌فرض آن‌ها.
- WORKSPACE: حذف محدودیت 1440px از Header/Shell پنل و استفاده از کل عرض امن WordPress برای فرم‌های مدیریتی.
- BOUTIQUE: ستون ماژول‌ها در کنار Workspace وسیع قرار گرفت و تنظیمات کامل ماژول انتخاب‌شده در همان فضای بزرگ باز می‌شود.
- DASHBOARD: انتقال AI Assistant و System Status شامل WooCommerce، Woodmart، Elementor، PHP، Memory و SSL به Dashboard.
- ISOLATION: AI و سلامت سیستم دیگر داخل «مدیریت بوتیک» رندر نمی‌شوند و فقط با انتخاب Dashboard دیده می‌شوند.
- RESPONSIVE: Workspace در عرض‌های محدود تک‌ستونه می‌شود و Sidebar موبایل/Tablet قبلی حفظ شده است.

## v3.10.3 — 2026-08-13 — Elementor Placement & Desktop Controls
- ELEMENTOR: افزودن شورت‌کد اختصاصی `[alookhor_managed_categories]` برای قرار دادن مستقیم بخش مدیریت‌شده در Widget نوع Shortcode.
- DEDUPLICATION: وقتی شورت‌کد رندر می‌شود، Template خودکار Footer تولید نمی‌شود و فقط یک نمونه در DOM باقی می‌ماند.
- ADMIN: نمایش شورت‌کد و راهنمای تفاوت آن با `[alookhor_categories_carousel]` قدیمی داخل تنظیمات اصلی دسته‌بندی‌ها.
- DESKTOP: ایزوله‌سازی کامل Arrow در برابر CSS عمومی Woodmart با ابعاد، Appearance، Background، Position، Padding و SVG صریح.
- PAGING: مخفی‌شدن خودکار Arrow و Pagination در Desktop تک‌صفحه؛ در چندصفحه و Mobile رفتار Carousel حفظ می‌شود.
- VERIFY: وضعیت ثبت شورت‌کد جدید به REST runtime و آزمون‌های Release/Production اضافه شد.

## v3.10.2 — 2026-08-13 — Mobile Controls & Pagination Match
- MOBILE: حذف کامل `.alookhor-mc-arrow` در ≤767px؛ Swipe، Drag، Autoplay و Infinite loop حفظ شدند.
- A11Y: Arrowهای مخفی `aria-hidden=true` و `tabIndex=-1` می‌گیرند.
- PAGINATION: Active pill افقی طلایی و inactive circle خاکستری مطابق Crop مرجع.
- ISOLATION: `width/min/max-width`، `height/min/max-height`، `flex-basis`، `appearance`، `padding` و `background` با Scope و `!important` تثبیت شدند تا Woodmart آن‌ها را عمودی نکند.

## v3.10.1 — 2026-08-13 — Professional Mobile Category Carousel
- FIX: کارت موبایل از 100%/310px به Width/Peek/Image Height مستقل و قابل تنظیم منتقل شد.
- FIX: Padding هندسی Track و محاسبه دقیق Card width مانع بریدگی کارت فعال در سمت چپ می‌شود.
- ADD: Clone ابتدا/انتها و Snap بدون Animation برای Infinite loop نرم.
- UI: فلش‌های SVG با Glass/Gold double ring، Blur، Glow و Touch target 46px.
- UI: Dotهای پویا بر اساس Page واقعی هر Breakpoint؛ Active pill طلایی و inactive circle.
- UX: کارت فعال `is-active` کامل، Neighborها با Scale/Opacity و Peek متقارن.
- ADMIN: Mobile width، Peek، Image height، Gap و Radius به پنل اصلی اضافه شدند.
- TEST: JSDOM در عرض 430px، Clone=2، Width=361.2px، Dots=4 و Transform centered پاس شد.

## v3.10.0 — 2026-08-13 — WooCommerce Category Showcase Desktop
- ADD: بخش مدیریت‌شده دسته‌بندی واقعی WooCommerce با `get_terms(product_cat)` و URL/Count/Thumbnail واقعی.
- DESKTOP: Carousel چهارکارته، تصویر 4:3، Icon medallion، Hover، CTA، Arrow، Dots و Autoplay مطابق تصویر مرجع.
- ADMIN: ماژول `product_categories` در تنظیمات سریع؛ انتخاب Termها، Image/Description override، متن‌ها، رفتار، ابعاد و Theme colors.
- ASSET: چهار تصویر بهینه‌شده و هماهنگ برای دسته‌های بدون Thumbnail در WooCommerce.
- MIGRATION: جایگزینی خودکار `.category-carousel-section` از Template موجود بدون ویرایش Elementor.
- REST: endpoint عمومی `product-categories` با `no-store` و گزارش term IDs واقعی.
- RELEASE: Build، PHP/JS/CSS validation، Woo contract و Carousel DOM test موفق شدند؛ Desktop آماده انتشار اتمی است.
- PHASE: Desktop کامل؛ Mobile baseline ایمن است و فاز Mobile پس از تأیید Desktop انجام می‌شود.

## v3.9.2 — 2026-08-11 — Managed Footer Admin Form Layout
- FIX: انتقال قواعد مشترک `.qh-*` از Template موقت Header به `luxury.css` اصلی Admin.
- UI: Grid دو‌ستونه فرم، Grid چهار‌ستونه رنگ‌ها، Labelهای مستقل و Fieldهای تمام‌عرض.
- UI: Checkbox pill، Media picker، Select، Textarea و Action bar با هویت Luxury هماهنگ شدند.
- RESPONSIVE: در ≤900px رنگ‌ها دو‌ستونه و در ≤700px تمام فرم تک‌ستونه می‌شود.
- FIX: حذف هم‌پوشانی عنوان/فیلد و نمایش به‌هم‌ریخته‌ای که هنگام انتخاب ماژول Footer رخ می‌داد.

## v3.9.1 — 2026-08-11 — Desktop Footer Direction Polish
- FIX: نوار میانی با Direction مستقل: Social چپ، Newsletter مرکز و Product Image راست.
- FIX: نوار اعتماد: Licenses چپ، Payments مرکز و Copyright راست.
- RESPONSIVE: قواعد Mobile 3.9.0 بدون تغییر حفظ شدند.
- TEST: Screenshot محلی 1440px و 430px بدون horizontal overflow تولید و با مراجع مقایسه شد.

## v3.9.0 — 2026-08-11 — Managed Responsive Footer
- ADD: فوتر مدیریت‌شده با چیدمان پنج‌ستونه Desktop و کارت‌های دو‌ستونه Mobile مطابق تصاویر مرجع.
- WP: خواندن لوگو/Media، فهرست‌های انتخابی، Home URL، سال جاری و Contact مشترک با Header از WordPress.
- ADMIN: افزودن ماژول «فوتر حرفه‌ای و اعتمادساز» به تنظیمات سریع پنل اصلی؛ محتوا، منوها، رسانه‌ها، مجوزها، شبکه‌ها، خبرنامه، رنگ و ابعاد قابل مدیریت‌اند.
- MIGRATION: مخفی‌سازی `.alookhor-footer-system` و بخش‌های Newsletter/App قدیمی و رندر خودکار فوتر جدید بدون تغییر Elementor/Code Snippets.
- REST: endpoint عمومی `footer` با `no-store` برای عبور از Page Cache و endpoint خبرنامه با Honeypot و Rate Limit.
- RESPONSIVE: تطبیق 320–1920px، ترتیب برند/تماس/کارت‌ها/شبکه‌ها در موبایل، بدون overflow و با حفظ Toolbar موبایل Woodmart.
- ASSET: تصویر اختصاصی کاسه آلو برای نوار خبرنامه Desktop داخل بسته افزونه.
- RELEASE: Build، PHP/JS/CSS validation، Footer contract، REST runtime و Responsive DOM tests موفق شدند؛ Release آماده انتشار اتمی است.

## v3.8.9 — 2026-08-11 — Legacy Contact Span Synchronization
- FIX: تلفن هدر واقعی داخل `span.topbar-contact-txt` است، نه `a[href^="tel:"]`؛ Selector مطابق DOM Production اصلاح شد.
- FIX: ایمیل plain-text داخل `span.topbar-contact-txt` بدون وابستگی به `mailto:` همگام می‌شود.
- COMPAT: جایگزینی متن مستقیم دکمه خرید عمده، SVG و ساختار DOM قدیمی را حفظ می‌کند.
- TEST: DOM واقعی Production برای تلفن `۰۹۱۵۹۵۱۳۱۷۹` و ایمیل Legacy در آزمون JSDOM بازسازی شد؛ مقدار REST تلفن `09159513173` و ایمیل تازه با موفقیت اعمال شدند.
- RELEASE: Build، PHP/JS parse، آزمون Atomic Paint/Fallback و آزمون دقیق Legacy Span موفق شدند.

## v3.8.8 — 2026-08-11 — Atomic First Paint for Legacy Top Bar
- FIX: بارگذاری Manager در `head` تا MutationObserver پیش از Paint هدر Legacy آماده باشد.
- FIX: شروع فوری درخواست REST با `no-store` و Cache-buster، بدون انتظار برای `DOMContentLoaded`.
- UX: Top Bar کش‌شده با حفظ ارتفاع مخفی می‌ماند و فقط پس از اعمال State تازه Reveal می‌شود؛ رنگ/تلفن قدیمی دیگر لحظه‌ای دیده نمی‌شوند.
- FAILSAFE: Abort خودکار پس از 2.5 ثانیه و Reveal داده Localized؛ Header در خطای شبکه مخفی باقی نمی‌ماند.
- COMPAT: ساختار DOM، Mega Menu، Hamburger، هویت Luxury و تمام قواعد Responsive بدون بازطراحی حفظ شدند.
- RELEASE: آزمون DOM برای Pending/Success/Failure، Build و Access Audit موفق شدند؛ Release آماده انتشار اتمی است.

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
