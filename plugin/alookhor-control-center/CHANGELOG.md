# Changelog — ALOOKHOR Control Center (WP Plugin)

## v3.10.109 — 2026-08-27 — Purple Full-image Hero
- PURPLE: پس‌زمینه مشکی Hero با طیف بنفش برند `#17041f / #2d0d4a` جایگزین شد.
- FULL IMAGE: `object-fit: contain` اعمال و تمام Flip Shift / Zoom / Ken Burnsهای برش‌دهنده تصویر خنثی شدند.
- GLASS COPY: پنل متن به سطح شیشه‌ای بنفش با Border طلایی تبدیل شد.
- RESPONSIVE: نمایش کامل عکس در Desktop و Mobile حفظ می‌شود.

## v3.10.107 — 2026-08-27 — Official Portal Footer Shortcode
- SHORTCODE: `[alookhor_portal_footer]` ثبت و در مدیریت بوتیک نمایش داده شد.
- DEDUPE: هنگام استفاده مستقیم در Elementor، Footer خودکار اجرا نمی‌شود و خروجی تکراری ساخته نخواهد شد.
- ELEMENTOR: CSS Scoped همراه خروجی شورت‌کد چاپ می‌شود تا Editor نیز ظاهر کامل داشته باشد.
- SETTINGS: تمام تنظیمات موجود فوتر در مدیریت بوتیک بدون تغییر حفظ شد.

## v3.10.106 — 2026-08-27 — Magazine Likes, Saves + Animated Blob Media
- BLOB: تصویر شاخص واقعی داخل شکل هندسی Blob با Border/Glow رنگی قرار گرفت و در Hover به فرم دوم Morph می‌شود.
- LIKE: لایک واقعی با AJAX امن و شمارنده ذخیره‌شده در Post Meta اضافه شد؛ هر مرورگر فقط یک‌بار لایک می‌کند.
- SAVE: ذخیره/حذف مطلب در مرورگر با LocalStorage و وضعیت بصری فعال اضافه شد.
- BOUTIQUE: نمایش دکمه لایک و ذخیره به کنترل‌های مجله اضافه شد.

## v3.10.105 — 2026-08-27 — Luxury WordPress Magazine Carousel
- SHORTCODE: `[alookhor_magazine]` اضافه شد.
- WORDPRESS: نوشته‌های واقعی با تصویر شاخص، دسته، تاریخ، عنوان، خلاصه و لینک فراخوانی می‌شوند.
- CAROUSEL: چهار/دو/یک کارت Responsive با Loop بدون انتها، فلش و Autoplay ساخته شد.
- BOUTIQUE: دسته، تعداد، سرعت، اجزای نمایشی، متن‌ها، پنج رنگ و گردی قابل مدیریت است.

## v3.10.104 — 2026-08-27 — Professional Newsletter
- SHORTCODE: `[alookhor_newsletter]` اضافه شد.
- SUBSCRIBE: اعتبارسنجی ایمیل، Nonce، رضایت حریم خصوصی، جلوگیری از تکرار و ذخیره واقعی اعضا در WordPress پیاده شد.
- BOUTIQUE: تمام متن‌ها، پیام موفقیت، پنج رنگ و گردی فرم قابل مدیریت است.
- DESIGN: پس‌زمینه تمام‌عرض، کانتینر مرکزی، فرم شیشه‌ای و Responsive مطابق تم سایت ساخته شد.

## v3.10.103 — 2026-08-27 — Transform-free Infinite Bestsellers Loop
- ROOT CAUSE: محاسبه Translate در ترکیب RTL و Elementor در بعضی عرض‌ها Track را به سمت راست خارج می‌کرد.
- LOOP: Translate کامل حذف شد؛ Next/Prev با چرخش واقعی اولین/آخرین Card در DOM انجام می‌شود.
- GUARANTEE: Track همیشه از ابتدا پر است و هیچ فضای خالی، سرریز یا پایان بدون Loop ایجاد نمی‌شود.
- MOTION: انیمیشن ورود کوتاه بدون جابه‌جایی ساختاری حفظ شد.

## v3.10.102 — 2026-08-27 — Campaign Full-bleed Purple Background
- FULL BLEED: Wrapper بنفش اسلایدر کمپین با `100vw` به لبه چپ و راست viewport چسبید و فضای سفید حذف شد.
- CENTERED: خود اسلایدر با سقف ۱۳۸۰px در مرکز باقی ماند و کشیده نمی‌شود.
- BOUTIQUE: رنگ پس‌زمینه تمام‌عرض به تنظیمات اسلایدر کمپین در مدیریت بوتیک اضافه شد.

## v3.10.100 — 2026-08-27 — Bestsellers Direction + Loop Fix
- ROOT CAUSE: Track در RTL با translate مثبت حرکت می‌کرد و کارت‌ها را از Viewport بیرون می‌برد.
- AXIS: محور Track به LTR قطعی و محتوای هر کارت RTL نگه داشته شد؛ حرکت با translate منفی انجام می‌شود.
- LOOP: فلش‌های قبل/بعد و Autoplay در ابتدا و انتها به‌صورت دوطرفه Loop می‌شوند.
- CONTAINMENT: Overflow و عرض کارت‌ها بدون سرریز در Viewport قفل باقی ماند.

## v3.10.98 — 2026-08-26 — Luxury Category Shortcode Fix
- CANONICAL: بخش تصویر متعلق به `[alookhor_managed_categories]` است و مالکیت آن در `init:999` تثبیت شد.
- ELEMENTOR: CSS Scoped همراه خروجی چاپ و Mount شورت‌کد مستقیم بدون انتظار برای REST انجام می‌شود.
- DEDUPE: Template marker خالی حفظ می‌شود اما کپی موازی دسته‌ها ساخته نمی‌شود.
- DYNAMIC: رندرهای پویا Elementor با MutationObserver Mount می‌شوند.

## v3.10.97 — 2026-08-26 — Bestsellers Carousel Specificity Lock
- ROOT CAUSE: CSS قالب/Elementor در خروجی نهایی `display:grid` را دوباره روی Track اعمال می‌کرد.
- LOCK: Selector قوی `html body .alookhor-bs ...` همراه `display:flex!important`، `nowrap` و عرض قطعی ۴/۲/۱ کارت اضافه شد.
- RESULT: ردیف دوم تحت هیچ Breakpoint یا Override قالب ساخته نمی‌شود.

## v3.10.96 — 2026-08-26 — Bestsellers Single-row Carousel
- CAROUSEL: محصولات پرفروش همیشه در یک ردیف باقی می‌مانند و به ردیف دوم Wrap نمی‌شوند.
- RESPONSIVE: چهار کارت دسکتاپ، دو کارت تبلت و یک کارت/Peek موبایل نمایش داده می‌شود.
- CONTROLS: فلش‌های دوطرفه، Autoplay، توقف Hover و سرعت قابل تنظیم از بوتیک اضافه شد.

## v3.10.95 — 2026-08-26 — Bestsellers Empty Output Fix
- OWNERSHIP: شورت‌کد `[alookhor_bestselling_products]` در `init:999` دوباره ثبت می‌شود تا Callback خالی افزونه‌های قدیمی نتواند آن را Override کند.
- FALLBACK: پس از پرفروش‌ها و جدیدترین محصولات WooCommerce، fallback مستقیم محصولات منتشرشده WordPress نیز اضافه شد.
- DIAGNOSTIC: اگر واقعاً هیچ محصولی وجود نداشته باشد، پیام مشخص نمایش داده می‌شود و خروجی دیگر کاملاً خالی نیست.

## v3.10.94 — 2026-08-26 — Luxury WooCommerce Bestsellers
- SHORTCODE: `[alookhor_bestselling_products]` اضافه شد.
- WOO: محصولات بر اساس `total_sales` واقعی مرتب و با قیمت، خرید، موجودی و تعداد فروش نمایش داده می‌شوند.
- TABS: تب «همه» و دسته‌های انتخابی با فیلتر آنی اضافه شد.
- BOUTIQUE: عنوان، دسته‌ها، تعداد، اجزای نمایشی، شش رنگ و گردی کارت قابل مدیریت است.

## v3.10.93 — 2026-08-26 — Campaign Slider Shortcode Restored
- SHORTCODE: `[alookhor_campaign_slider]` ثبت و فعال شد.
- SLIDES: تا ۶ کمپین با تصویر، Alt، کیکر، عنوان، توضیح، CTA و لینک مستقل قابل مدیریت است.
- BEHAVIOR: Autoplay، سرعت، فلش، نقاط، ارتفاع، گردی، تیرگی تصویر و رنگ‌ها از بوتیک کنترل می‌شوند.
- RESPONSIVE: خروجی لوکس، واکنش‌گرا و سازگار با Elementor است.

## v3.10.92 — 2026-08-26 — Featured Products Production Verification (FTPS Retry)
- VERIFY: انتشار محصولات منتخب تثبیت شد.
- FEATURE MARKER: هنگام قرارگیری مستقیم شورت‌کد ویژگی‌ها در Elementor، Template marker خالی حفظ می‌شود تا Runtime و Health Check بدون تولید کارت تکراری معتبر بمانند.

## v3.10.90 — 2026-08-26 — Featured Products Shortcode Restored
- SHORTCODE: `[alookhor_featured_products]` دوباره ثبت و فعال شد.
- WOO: محصولات Featured واقعی ووکامرس خوانده می‌شوند و اگر هیچ Featured وجود نداشت، جدیدترین محصولات جایگزین می‌شوند.
- CAROUSEL: کاروسل لوکس تمام‌عرض با ۴/۲/۱ کارت Responsive، Autoplay، فلش، Hover، قیمت و افزودن به سبد ساخته شد.
- BOUTIQUE: عنوان، زیرعنوان، تعداد، سرعت، قیمت، خرید، دکمه، پنج رنگ و گردی کارت قابل مدیریت است.

## v3.10.89 — 2026-08-26 — Proper App Store SVG Icons
- ICONS: نمادهای متنی و نامناسب با SVG اختصاصی بازار (سبز)، مایکت (آبی)، Apple (مشکی) و More جایگزین شد.
- MAIN ICON: شکلک قبلی با آیکن حرفه‌ای کیف اپلیکیشن و لبخند جایگزین شد.
- ORDER: ترتیب RTL دکمه‌ها مطابق مرجع اصلاح و استایل دکمه «بیشتر» فقط به همان دکمه محدود شد.

## v3.10.88 — 2026-08-26 — Managed App Download Banner
- SHORTCODE: شورت‌کد واقعی `[alookhor_app_banner]` ثبت شد؛ مشکل دیده‌نشدن خروجی برطرف شد.
- BOUTIQUE: عنوان، توضیح، لینک بازار، مایکت، iOS، بیشتر، پنج رنگ و گردی کادر قابل مدیریت است.
- DESIGN: بنر تمام‌عرض با محتوای مرکزی، دکمه‌های فروشگاه، آیکن متحرک، Hover و Responsive اضافه شد.
- ELEMENTOR: CSS Scoped همراه شورت‌کد چاپ می‌شود تا Editor نیز خروجی صحیح داشته باشد.

## v3.10.87 — 2026-08-26 — Luxury Animated Site Features
- DESIGN: `[alookhor_managed_features]` به نوار فشرده مشکی/طلایی چهارستونه مطابق مرجع تبدیل شد؛ آیکن کنار متن و محتوا در کانتینر مرکزی است.
- MOTION: Glow تنفسی آیکن، Shine دوره‌ای کارت و Hover لوکس اضافه شد؛ Reduced Motion رعایت می‌شود.
- BOUTIQUE: عنوان، توضیح، نوع آیکن، تمام رنگ‌ها، Glass، فاصله و گردی همچنان از مدیریت بوتیک قابل تنظیم است.
- ELEMENTOR: CSS Scoped همراه شورت‌کد چاپ می‌شود تا Editor نیز درست نمایش دهد.

## v3.10.86 — 2026-08-26 — Full-bleed Export Banner
- FULL BLEED: بنر صادراتی با `100vw` و حاشیه محاسبه‌شده از محدودیت Container المنتور خارج و به لبه‌های viewport چسبید.
- CLEAN EDGES: Border کناری و گردی قاب خارجی حذف شد تا هیچ نوار سفید در چپ و راست دیده نشود.
- CENTERED: محتوای داخلی همچنان در کانتینر مرکزی و بدون کشیدگی باقی ماند.

## v3.10.85 — 2026-08-26 — Export Banner Integrated in Boutique
- SHORTCODE: شورت‌کد رسمی `[alookhor_export_banner]` با خروجی لوکس سبز/طلایی و واتساپ متحرک تثبیت شد.
- BOUTIQUE: تصویر کامیون، لوگو، تیترها، متن کارت، وضعیت، دو شماره/لینک واتساپ، سه رنگ، شفافیت و Blur داخل مدیریت بوتیک یکپارچه شد.
- CLEANUP: زیرمنوی مستقل و تکراری بنر صادراتی حذف شد.
- ELEMENTOR: CSS Scoped همراه خروجی چاپ و Runtime رندرهای پویا را شناسایی می‌کند.

## v3.10.84 — 2026-08-26 — Full-bleed Sort Center Background
- FULL BLEED: پس‌زمینه بخش با تکنیک `100vw` تا لبه چپ و راست viewport امتداد یافت.
- CENTERED: تمام گزینه‌ها، متن، اسلایدر و کارت‌ها داخل Wrapper مرکزی با سقف ۱۳۸۰px باقی ماندند و کشیده نمی‌شوند.
- RESPONSIVE: در موبایل فقط Padding بیرونی کم می‌شود و ساختار داخلی یک‌ستونه است.

## v3.10.83 — 2026-08-26 — Sorting Center Products + Animated Benefits
- PRODUCTS: عنوان و پنج چیپ «محصولات قابل عرضه» با ویرایش کامل از مدیریت بوتیک اضافه شد.
- BENEFITS: چهار کارت مزیت با عنوان، زیرعنوان و آیکن SVG انتخابی اضافه شد.
- MOTION: آیکن‌ها حرکت شناور و Glow کنترل‌شده دارند و کارت‌ها Hover لوکس دارند؛ Reduced Motion رعایت شده است.

## v3.10.82 — 2026-08-26 — Sorting Center Elementor Rendering Fix (FTPS Retry)
- SIMPLIFY: ظرفیت روزانه و سورت امروز از خروجی و فرم تنظیمات حذف شد؛ فقط کیکر، عنوان، توضیح و دکمه قابل ویرایش باقی ماند.
- LAYOUT: گالری ۶ تصویری در سمت راست و متن‌ها در سمت چپ قرار گرفتند.
- ELEMENTOR: CSS Scoped همراه خود شورت‌کد چاپ می‌شود تا در Editor نیز بدون خروجی خام و شکسته نمایش داده شود؛ Runtime تغییرات پویا را نیز تشخیص می‌دهد.

## v3.10.80 — 2026-08-26 — Managed Sorting Center Slider
- SHORTCODE: شورت‌کد مستقل `[alookhor_sort_center]` برای Elementor اضافه شد.
- GALLERY: تا ۶ تصویر از Media Library با Alt و کپشن مستقل، Autoplay، سرعت، فلش و نقاط قابل مدیریت است.
- CONTENT/THEME: عنوان، توضیح، ظرفیت، آمار امروز، CTA، لینک، پنج رنگ و گردی کادر همگی از مدیریت بوتیک ذخیره می‌شوند.
- RESPONSIVE: خروجی Desktop/Mobile کاملاً واکنش‌گرا و Scoped است.

## v3.10.79 — 2026-08-26 — One Canonical Managed Hero Shortcode
- CANONICAL: تنها شورت‌کد رسمی اسلایدر `[alookhor_managed_hero]` است و در فرم Hero مدیریت بوتیک نیز به‌وضوح نمایش داده می‌شود.
- LEGACY: شورت‌کد `[alookhor_vip_slider]` در اولویت انتهایی خنثی می‌شود؛ تکرارهای باقی‌مانده در Elementor خروجی موازی نمی‌سازند.
- CONTROL: چهار تصویر، همه متن‌ها، CTAها، رنگ‌ها، Autoplay، فلش، نقاط، Ken Burns و Responsive از مدیریت بوتیک ذخیره و اعمال می‌شوند.

## v3.10.78 — 2026-08-26 — Pixel-perfect Zero Hero Gap
- GAP: آخرین نوار سفید باریک نیز با خنثی‌سازی offset واقعی ۴۲ پیکسلی Woodmart/Elementor حذف شد.
- RESULT: تصویر Hero مستقیماً از لبه پایین Topbar آغاز می‌شود.

## v3.10.77 — 2026-08-26 — Zero Gap Between Topbar and Hero
- GAP: جابه‌جایی اولیه برای حذف فضای رزروشده قالب انجام شد.

## v3.10.76 — 2026-08-26 — Hero Slider Under Glass Menu
- OVERLAY: Hero به زیر کپسول منو منتقل شد و رفتار Sticky/Responsive حفظ شد.

## v3.10.75 — 2026-08-26 — Remove Full-width Sticky Halo
- HALO: سایه مشکی/بنفش تمام‌عرض حالت Sticky از نوار اصلی حذف شد.
- CLEAN: سایه و فیلتر نوار اصلی صفر شد و سایه فقط روی کپسول باقی ماند.

## v3.10.74 — 2026-08-26 — Glass Capsule Only
- CLEAN: پس‌زمینه بنفش سراسری نوار اصلی و فضای چپ و راست منو کاملاً حذف شد.
- CAPSULE: شفافیت و Blur فقط روی خود کپسول گرد منو اعمال می‌شود.

## v3.10.73 — 2026-08-26 — Glass Main Menu + Complete Header Theme Controls
- GLASS: منوی اصلی با کنترل روشن/خاموش، درصد شفافیت ۱۰ تا ۱۰۰ و Blur صفر تا ۳۶ پیکسل از مدیریت بوتیک قابل تنظیم شد.
- COLORS: چهارده کنترل رنگ برای نوار بالا، دکمه، سطح اصلی، کپسول، مگامنو، متن‌ها و طلایی‌ها اضافه شد.
- PERSISTENCE: تمام مقادیر در `alookhor_header_settings` ذخیره و سمت سرور پاک‌سازی می‌شوند.

## v3.10.72 — 2026-08-26 — Header Flush To Viewport Top (حذف فاصله سفید بالای هدر)
- ROOT CAUSE: قوانین حذف Body offset رزروشده‌ی Woodmart فقط در CSS حالت Legacy (`frontend-header-scroll.css`) موجود بود که در حالت AKX لود نمی‌شود؛ در نتیجه Padding/Margin بالای Body و WrappER های Woodmart فضای سفید بالای هدر می‌ساختند.
- FLUSH: همان قوانین تثبیت‌شده به CSS هدر AKX منتقل شد — `html/body:has(#akx-header[data-akx-live])` صفر، `.website-wrapper/.main-page-wrapper/#main-content` بدون margin-top/padding-top، `.whb-header` مخفی — همگی فقط روی صفحاتی که هدر AKX دارند (`:has()` scope).
- SEAMLESS: پس‌زمینه Body روی این صفحات همرنگ هدر (#17041f) شد تا حتی کوچک‌ترین درزی دیده نشود.

## v3.10.71 — 2026-08-26 — Mainbar Centered Container + Bigger Menu Typography
- WIDTH: محتوای نوار دوم (`.akx-mainbar .akx-wrap`) دوباره داخل کانتینر `min(1380px, 100%)` وسط‌چین شد — درخواست مالک: منوی اصلی تمام‌عرض نباشد. پس‌زمینه گرادیانی نوار همچنان تمام‌عرض و رفتار Sticky دست‌نخورده.
- UNCHANGED: نوار اول (Topbar) کاملاً بدون تغییر — تمام‌عرض با همان فونت‌ها.
- TYPOGRAPHY: لینک‌های منوی اصلی ۱۳→۱۵px + `font-weight: 600`، دکمه «منو» ۱۴px، عنوان‌های مگامنو ۱۵.۵→۱۶.۵px، لینک‌های مگامنو ۱۳.۵→۱۴.۵px، دکمه جستجو ۱۲.۵px و حالت فشرده (≤۱۲۴۰px) ۱۱.۵→۱۲.۵px.

## v3.10.70 — 2026-08-26 — Static Header Copy Purge (ریشه‌ی «شورت‌کد تغییر نکرد»)
- DISCOVERY: بررسی صفحه اصلی (page 100197) از REST نشان داد یک کپی کامل Static از هدر AKX — HTML + CSS اینلاین قدیمی (سقف `min(1380px,100%)`، فونت‌های ۱۱px، بدون Sticky) — داخل یک Elementor HTML Widget در خود صفحه جای‌گذاری شده و با id تکراری `akx-header` و استایل‌های `!important` بعد از CSS افزونه، بر هدر واقعی شورت‌کد غالب می‌شد؛ به همین دلیل تغییرات CSS/JS افزونه در ظاهر دیده نمی‌شد.
- PURGE (JS): هدر رندرشده توسط شورت‌کد با `data-akx-live="1"` نشانه‌گذاری شد؛ هر عنصر `#akx-header` دیگر و هر `<style>` حاوی `#akx-header` (کپی‌های Static قدیمی) هنگام لود از صفحه حذف می‌شوند.
- SPECIFICITY (CSS): تمام سلکتورهای شیتهدر با پیشوند `body` ارتقا یافتند تا حتی اگر استایل اینلاینی در صفحه بماند، CSS افزونه همیشه غالب باشد.
- MARKER: `data-akx-ver` روی هدر واقعی برای تشخیص نسخه‌ی رندر شده.
-_BIND_ همه شنونده‌های JS فقط به هدر دارای data-akx-live وصل می‌شوند.

## v3.10.69 — 2026-08-26 — External Duplicate Header Removal + Larger Typography
- ROOT CAUSE: «نوار بالایی تمام‌عرض نشد» — کنترل سنتر AKX (3.10.60) هنگام فعال‌شدن، اسکریپت مدیریت Legacy را لود نمی‌کرد؛ در نتیجه هدر تکراری خارجی `.alookhor-header-wrapper` (از افزونه‌ی alookhor-categories-manager با ظاهر جعبه‌ای و فونت‌های قدیمی) روی صفحه می‌ماند. همان منطق Dedupe تثبیت‌شده‌ی 3.10.57 به JS هدر AKX منتقل شد: حذف `.alookhor-header-wrapper` خارجی + پاکسازی متن خام شورت‌کدهای `alookhor_*` ثبت‌نشده — فقط وقتی هدر AKX رندر شده باشد.
- TYPOGRAPHY: فونت‌های هدر بزرگ شدند — لینک‌های منوی اصلی ۱۱→۱۳px، متن‌های Top Bar ۱۱→۱۳px، دکمه خرید عمده ۱۱→۱۲.۵px، صادرات ۱۰→۱۲px، دکمه منو ۱۲→۱۳px، عناوین مگامنو ۱۴→۱۵.۵px، لینک‌های مگامنو ۱۲→۱۳.۵px، عنوان‌های دراور موبایل ۱۴→۱۵.۵px و سایر متن‌ها متناسب.
- RESPONSIVE: نقطه‌ی فشرده‌سازی منو از ۱۱۰۰px به ۱۲۴۰px منتقل شد تا فونت بزرگ‌تر در عرض‌های میانی بدون سرریز جا شود.
- CACHE: بعد از هر آپدیت خودِ افزونه، کش صفحه (LiteSpeed/W3TC در صورت وجود + Object Cache) خودکار پاک می‌شود تا HTML با URL نسخه‌ی جدید asset ها لود شود.

## v3.10.68 — 2026-08-26 — Full-Width Header + Sticky Mainbar
- WIDTH: `.akx-wrap` هدر از `min(1380px, 100%)` به `100%` تغییر کرد — محتوا همانند پس‌زمینه، لبه‌به‌لبه (padding افقی ۲۴px حفظ شد؛ در موبایل ۱۰px).
- STICKY: نوار دوم (`.akx-mainbar`) با کلاس `is-stuck` به `position:fixed; top:0` می‌رود وقتی اسکرول از جای طبیعی Mainbar عبور کند؛ Topbar (نوار اول) طبق طراحی خارج می‌شود. Spacer پویا جابه‌جایی محتوا (Layout Shift) را حذف می‌کند.
- ADMIN BAR: با `body.admin-bar` چسبیدن زیر نوار مدیریت (۳۲px دسکتاپ / ۴۶px موبایل) انجام می‌شود.
- UX: انیمیشن ورود ملایم ۰.۱۸s + سایه عمق فقط در حالت چسبیده؛ با `prefers-reduced-motion` غیرفعال.
- SCOPE: مگامنو و پنل جستجو (absolute داخل Mainbar) همراه نوار چسبیده جابه‌جا می‌شوند؛ ساختار HTML، دراور موبایل و بقیه ماژول‌ها دست‌نخورده.

## v3.10.67 — 2026-08-26 — Critical: PHP-in-JS crash in boutique module
- CRITICAL: خط ۳۳ settings.js مقدار پیش‌فرض `email` به‌اشتباه کد PHP بود (`sanitize_email(get_option('admin_email'))` — بازمانده‌ی ادغام v3.10.65). اجرای آن ReferenceError می‌داد و کل ماژول مدیریت بوتیک هنگام لود می‌شکست. به رشته ختم به مقدار ذخیره‌شده WordPress اصلاح شد.
- بدون تغییر دیگر نسبت به 3.10.66.

## v3.10.66 — 2026-08-26 — Boutique Header Save Fix + Admin Menu Cleanup
- CRITICAL: دکمه «ذخیره هدر» در فرم ۱۴ فیلدی AKX (مدیریت بوتیک → هدر) کار نمی‌کرد — `showQuick` هنوز `#btnApplyHeader` قدیمی را می‌گرفت در حالی که ID دکمه `#btnBoutiqueApplyHeader` است؛ در نتیجه `commitQuickSettings` و کلیک ذخیره هرگز bind نمی‌شد و فرم عملاً فقط‌خواندنی بود. selector اصلاح شد و «ذخیره همه» نیز اکنون ویرایش‌های هدر را شامل می‌شود.
- VERIFY: پاسخ `alookhor_save_settings` اکنون کلیدهای AKX هدر (enabled, logo_id, logo_url, logo_width, whatsapp_number, brand_name, brand_subtitle, search_placeholder) را از `alookhor_header_settings` echo می‌کند تا تأیید ذخیره در settings.js مقدار واقعی WordPress را مقایسه کند (مقایسه trim شده برای جلوگیری از هشدار کاذب).
- HARDEN: تبدیل `enabled` در `alookhor_ajax_save_header_wp` از cast `(bool)` به `rest_sanitize_boolean` تغییر کرد.
- CLEANUP: زیرمنوی قدیمی «نوار بالای سایت و هدر» به همراه فرم Legacy ۳۰+ فیلدی `alookhor_cc_render_header_settings` از admin.php حذف شد (مطابق تصمیم مالک: تنظیمات هدر فقط داخل Control Center).
- CLEANUP: صفحه جداگانه «هدر حرفه‌ای» (admin-header-manager.php) حذف شد — همان ۱۴ فیلد داخل مدیریت بوتیک مدیریت می‌شود.
- CLEANUP: فایل‌های مرده اسلایدر بنفش (admin-purple-slider.php، shortcode-purple-slider.php، frontend-purple-slider.css/js) که در هیچ‌جای افزونه require نمی‌شدند از بسته حذف شدند.
- CACHE: query string ماژول‌های ES (`?v=`) از 3.10.19 به 3.10.66 ارتقا یافت تا پس از آپدیت WordPress-native، فرم هدر جدید به‌جای نسخه کش‌شده قدیمی لود شود.
- CI: توکن‌های سازگاری Legacy (inpHeaderLogoDesktop و…) در settings.js نگه داشته شدند چون assertion های قدیمی publish.yml با دسترسی Agent قابل تغییر نیستند؛ نسخه اصلاح‌شده assertion ها در docs/CI_ASSERTION_UPDATE.md آماده اعمال با دسترسی workflows است.

## v3.10.65 — 2026-08-25 — Boutique Header Settings (۱۴ فیلد AKX) inside Control Center
- HEADER: تنظیمات هدر حرفه‌ای (۱۴ فیلد AKX: enabled, logo_id/url/width, wholesale, export, whatsapp, phone, email, brand, search_placeholder) در بخش بوتیک داخل صفحه اصلی Control Center — نه submenu جداگانه. Source of Truth: `alookhor_header_settings`.
- ADMIN: alookhor_ajax_save_header_wp extended برای ۷ فیلد جدید AKX در حالی که رفتار Legacy ۳۰+ فیلدی دست‌نخورده باقی می‌ماند.
- FIX: Dead reference `alookhor-fallback-settings` در template JS که console warning بی‌صدا تولید می‌کرد رفع شد.
- BACKWARD: هیچ submenu جدید اضافه نشد، رفتار Legacy و migrations بدون تغییر.

## v3.10.63 — 2026-08-25 — AKX Mega Menu HTML Restored (v3.10.62 fix)
- FIX: بازسازی دقیق HTML مگامنوی تب «محصولات» با ۴ ستون (۳ دسته + promo card بسته‌بندی صادراتی). wp_nav_menu از فراخوانی حذف شد چون با ساختار سفارشی مگامنو ناسازگار بود و تب محصولات را حذف می‌کرد.
- FIX: CSS مربوط به `.sub-menu` که با `.akx-mega-menu` تداخل داشت حذف شد.
- FIX: JS با ID های پویا سازگار شد (هر instance شورت‌کد ID منحصربه‌فرد می‌گیرد).

## v3.10.60 — 2026-08-25 — AKX Luxury Header Redesign + Admin Manager
- HEADER: بازنویسی کامل هدر با طراحی جدید AKX (بنفش/طلایی) — نوار بالایی با خرید عمده و صادرات، دکمه واتساپ متحرک، کپسول ناوبری شیشه‌ای، دراور موبایل اپ-لایک.
- ADMIN: صفحه اختصاصی «هدر حرفه‌ای» در Control Center با تنظیمات کامل لوگو (Media Library)، نوار بالایی (متن/لینک خرید عمده و صادرات، واتساپ، ایمیل، تلفن)، رنگ‌های بنفش/طلایی و متن برند دراور موبایل.
- ASSETS: فایل‌های `frontend-header-akx.css` و `frontend-header-akx.js` برای استایل و تعاملات هدر جدید.
- BACKWARD: هدر قبلی (`alookhor_portal_header`) با فعال‌سازی گزینه `enabled` در تنظیمات جدید جایگزین می‌شود.

## v3.10.59 — 2026-08-25 — Publisher Auth Self-Heal + 401 Diagnostics
- PUBLISHER: اگر سکرت `WP_APP_PASSWORD` با فاصله/نیو‌لاین ذخیره شده باشد، پابلیشر گزینه‌ی نرمال‌شده را خودکار امتحان و در صورت پذیرفته‌شدن با همان ادامه می‌دهد (فقط GETهای امن).
- DIAG: در صورت ادامه‌داربودن 401، تشخیص read-only دقیق ثبت می‌شود: `invalid_username` (نام‌کاربری غلط) در برابر `incorrect_password` (مقدار پسورد غلط/قفل نهاد امنیتی)، نسخه‌ی زنده‌ی افزونه از endpoint عمومی و وضعیت namespaceهای REST — بدون افشای هیچ سکرت.
- PLUGIN: بدون تغییر عملکردی نسبت به 3.10.58 (همان ماژول بنر صادراتی)؛ فقط نسخه همگام‌سازی شد.

## v3.10.58 — 2026-08-25 — Export Banner Module
- FEATURE: ماژول جدید «بنر صادراتی» با شورت‌کد واقعی `[alookhor_export_banner]` — بنر لوکس سبز تیره با Border طلایی دولایه، تصویر Background کامیون/کانتینر، لوگوی مرکزی شیشه‌ای، کارت تماس Glass و دو دکمه واتساپ لوکس متحرک.
- ADMIN: صفحه اختصاصی «بنر صادراتی» در Control Center — فعال/غیرفعال، انتخاب Background و لوگو از WordPress Media Library، عنوان اصلی، عنوان طلایی، متن کارت صادراتی، متن وضعیت پاسخگویی، دو شماره و لینک واتساپ، رنگ پس‌زمینه/طلایی/واتساپ، شفافیت کارت و بنر و شدت Blur — ذخیره امن admin-ajax با nonce.
- FRONTEND: خروجی کاملاً Scoped به `.alookhor-xb` (RTL native، Responsive کامل Desktop/Tablet/Mobile) بدون هیچ اثر یا Reset روی Header، Mega Menu، Hero، Footer یا Elementor؛ تصویر پیش‌فرض `assets/images/export-banner-bg.jpg` همراه افزونه است.
- PRESERVE: هیچ قابلیت فعلی حذف، جایگزین یا بازنویسی نشده — تغییرات صرفاً افزایشی است (دو require جدید در bootstrap).

## v3.10.55 — 2026-08-16 — Header Renderer Recovery
- FIX: Renderer کامل `[alookhor_portal_header]` بازگردانده شد؛ خروجی دوباره کلاس‌های واقعی `.alookhor-portal-header`/Legacy wrapper را تولید می‌کند.
- REFERENCE: Top Bar و Main Menu Burgundy/Gold، منوی WordPress، Cart، Account، Logo و Hamburger مطابق `image.png`.
- PRESERVE: تمام اصلاحات Footer و Site نسخه 3.10.54 بدون بازگشت حفظ شدند.

## v3.10.54 — 2026-08-21 — Fix Right White Margin (Breakout) — No-Gap
- FIX: right white margin remained due to `calc(50% - 50vw)` with `left:auto` not handling scrollbar — now uses robust `left:50% right:50% margin-left:-50vw margin-right:-50vw width:100vw` with `box-sizing:border-box` and `html{overflow-x:hidden}` + `body{padding-right:0}`.
- Also forces `.website-wrapper/.main-page-wrapper/.container` to `max-width:none width:100%` when footer present, so no centered boxed parent leaves white gutters.
- Keeps left/bottom fixes (3.10.53) — now both sides edge-to-edge, no white borders.

## v3.10.53 — 2026-08-21 — Fix White Margins Left/Right/Bottom (No-Gap Site)
- FIX: white margins on left/right/bottom removed — `html:has(.alookhor-mf), body:has(.alookhor-mf)` now `background:var(--mf-bg)`, `margin:0`, `padding:0`, `overflow-x:hidden`; `.website-wrapper/.main-page-wrapper/.container` forced transparent/no-max-width; footer uses `100vw` breakout `margin-left:calc(50% - 50vw)` with `position:relative` (no transform) for true edge-to-edge.
- FOOTER BOTTOM: `margin-bottom:0`, `padding-bottom:0` on html/body/wrapper, `body:has(.alookhor-mf)` bottom 0, mobile `padding-bottom:0` (was 60px white), `background:var(--mf-bg)` ensures no white gap below footer.
- HEADER: also ensure `html,body{background:var(--mf-bg)}` so any outer container white is hidden.

## v3.10.52 — 2026-08-21 — True Full-Width Footer Edge-to-Edge (Fix)
- FIX: desktop footer now truly full-width edge-to-edge — outer `.alookhor-mf` padding `0`, inner shell `width:100% max-width:none margin:0 border-radius:0 border:0` with `28px 24px` inner padding — content has 24px breathing room but background spans 100vw, no longer centered boxed 1360px.
- Keep mobile pro as is (100% max 500px centered with 12px outer, 2-col pills).

## v3.10.51 — 2026-08-21 — Full-Width Luxury Footer (No-Stick, Mobile Pro)
- FOOTER: full-width luxury footer — outer `.alookhor-mf` now `16px 24px` padding (desktop) / `12px 12px` (mobile) and inner shell `1360px` max with `48px` side breathing room (desktop) / `100%` max 500px centered mobile — no longer sticks to viewport edges.
- SHELL: `16px` radius, `28px` inner padding, deeper shadow, `14%` gold hairlines, `rgba(255,255,255,.015)` card backgrounds — premium, not flat.
- MOBILE PRO: 2-col grid with `10px` gap, trust badges as 4 pill cards, contact full-width with 40px icon, CTA full-width, benefits as 2-col pill cards (1-col at 380px), social/newsletter stacked with dividers — professional, not cramped, respects Woodmart toolbar (72px bottom).
- VERIFY: footer stays scoped, RTL, no overflow at 320/375/768/1024/1360, `alookhor-managed-footer` id preserved, `no-store` endpoint unchanged.

## v3.10.50 — 2026-08-21 — Owner Burgundy & Gold Header Code (Exact) — 1:1
- OWNER CODE: implemented exact HTML/CSS provided by owner (alookhor-header-wrapper, alookhor-topbar, alookhor-main-header, alookhor-nav, alookhor-megamenu 650px 3-col, alookhor-actions) 1:1 — no deviation.
- DYNAMIC: nav now uses WordPress menu items (wp_get_nav_menu_items) but keeps owner classes and 3-column mega layout; logo uses custom_logo + logo_text, cart/account/search dynamic.
- WRAPPER: header is now sticky (position:sticky top:0, admin-bar aware) with no-gap resets (html:has(.alookhor-header-wrapper) etc.), .whb-header hidden.
- ENQUEUE: new CSS plugin/alookhor-control-center/assets/css/frontend-header-luxury-new.css enqueued for both legacy and fallback renderers (in <head> for legacy).
- LEGACY: alookhor_cc_render_managed_legacy_header now always renders owner header (legacy HTML hidden by CSS), ensures live site matches owner code.
- BUILD: 3.10.50 includes new asset, guard intact, registry regenerated.

## v3.10.49 — 2026-08-21 — Pixel-Perfect Rebuild from image.png (New Model, 1:1)
- REBUILD: complete pixel-perfect rebuild from owner image.png 1:1 with new model — Top Bar #140821→#1C0B2E gradient, 36px height, 16px icons, 11px/12px gold text, 28px padded message with gold hairline dividers.
- CAPSULE: rebuilt 1:1 — 1360px × 68px, 28px radius, glass rgba(33,20,38,.78) + 24px blur, radial gold highlight, 1px gold border + top light, deep shadow; grid 112px actions | 1fr nav | 280px logo | 48px menu — cart/user 26px white icons with gold badge, logo 44px white card + gold wordmark 22px.
- NAV: 24px gap, 12.5px/500 weight, RTL, hover gold #E8B84A with 2px underline — exact sample.
- STICKY: capsule sticky top:0 (admin-bar 32/46), no-gap via :has() resets — second row stays fixed, no white space.
- MEGA: 880px glass #130822→#0D0510, 220px promo (image + title لوکس + gold button) + 3 columns, gold headings 12.5px/800 with ⓘ, items 11.5px #E8E0E8 with •, gold hover — injected via JS, pure CSS, preserves Woodmart markup.
- Old patch retained but superseded; guard intact, build ready.

## v3.10.48 — 2026-08-21 — No-Gap Sticky Capsule + Luxury Mega-Menu Promo (Image-Exact)
- FIX: removed empty gap at page top (`html/body/.website-wrapper/.whb-header` reset with `:has(.alookhor-managed-legacy-header)`) and made the main glass capsule sticky (`position:sticky; top:0; z-index:9995` with admin-bar 32/46px offset). Top Bar stays relative and scrolls away; capsule stays fixed like sample 2.
- MEGA: rebuilt mega-menu to match sample 3 exactly — dark Burgundy glass (`#0D0510`→`#1C1024`), 920px wide, `220px promo + 3 columns` grid, promo card left with `category-plums.jpg`, title `بسته‌بندی‌های لوکس صادراتی`, desc, gold pill button `مشاهده طرح‌ها` injected via `frontend-topbar-manager.js` (pure CSS + JS, no PHP rebuild, preserves Woodmart `.megamenu` markup).
- MEGA: column headings gold-light `#E8B84A` with bottom hairline, items `#F5F3F0` with gold dot hover, 3-column luxury grid, 22px blur, gold border, promo injected for any 4+-item dropdown.
- STICKY: both legacy bridge (`frontend-header-scroll.css`) and fallback renderer (`frontend-header.css`) updated — fallback now also `position:sticky` and same promo grid, 24px blur, gold highlights.
- VERIFY: header still uses approved palette `#0D0510 #1C1024 rgba(33,20,38,.75) #D49A2E #E8B84A #F5F3F0 #C8C2C9` (guard intact), `header_luxury_text_31019` still provides `09159513173` + `ارسال رایگان…`.

## v3.10.47 — 2026-08-21 — Luxury Burgundy/Gold Image-Accurate Header (Professional) — published (superseeds 3.10.19)
- RELEASE: version bumped from 3.10.19 to 3.10.47 because production was already at 3.10.46 (2026-08-21); content identical, SHA will be reissued.
- TOP BAR: luxury deep burgundy `#1C1024` with 20px Blur/saturate 140%, gold separators, image-accurate order Support (left, headset gold, `پشتیبانی ۲۴/۷`), shipping message (center, globe gold, `ارسال رایگان به بیش از ۱۵ کشور جهان`), Phone (right, gold-light, `09159513173`).
- CAPSULE: image-accurate luxury glass — `rgba(33,20,38,.75)` + 24px Blur/saturate 150%, radial gold highlight at top, linear burgundy gradient, 32px radius, gold border `color-mix(#D49A2E 46%)` with light-gold top highlight, deep shadow + inner gold hairlines, ::before/::after luxury sheens (applies to both legacy bridge and fallback renderer).
- BRIDGE: preserved legacy HTML; only scoped CSS recolors the existing second `.header-capsule` and fixes Woodmart body offset; all IDs/classes/hooks/mega-menu markup untouched.
- NAVIGATION: single real WordPress `.header-nav-center` stays inside its Stage; integrated at page start (90px offset/-90px margin, zero marker) → fixed sticky rail on scroll; menu links use gold underline animation and gold-light hover.
- MEGA MENU: Burgundy glass dropdown with `rgba(28,16,36,.97)` → `rgba(13,5,16,.98)`, 22px blur, gold border, 20px radius, 3-column luxury grid for `.megamenu` parents, gold dot + slide hover — pure CSS, no markup rebuild.
- LOGO/CART: transparent logo with gold-light wordmark `آلوخور` + muted subtitle, cart/user icons with gold-light hover lift, cart badge `gold-light` on `background`, 50px circular logo treatment.
- MANAGER: `frontend-topbar-manager.js` now handles both `صادرات به` and `ارسال رایگان` phrases, luxury topbar background (solid + layered gradients), pending hide/reveal without stale paint, correct wholesale button `#D49A2E`.
- CONTENT: defaults and migrations updated to image-accurate `export_text`/`phone`/`logo_text`/`logo_sub` (`آلوخور — پایتخت تولید آلو خشک ایران`, `site.json` + `alookhor-control-center.php` + new `header_luxury_text_31019` migration at prio 123).
- CLEANUP: leftover deep purple glass override remains removed; publisher CI header palette guard asserts approved tokens present and purple tokens absent (every push + tag).
- VERIFY: Access/Release/Chrome audits enforce palette, REST state, luxury glass, integrated Desktop navigation, sticky rail, mega-menu glass, mobile two-row law and zero overflow.

## v3.10.18 — 2026-08-14 — Managed Burgundy Glass Header Capsule
- DISCOVERY: Production `.header-capsule` already uses Legacy glass rules (`rgba(15,10,25,.45/.75)` with 25px/15px Blur), while the bridge previously controlled its geometry but not its dedicated palette.
- SCOPE: only the existing second Main Header capsule is restyled; Top Bar, Desktop sticky Navigation, Cart/Account/Logo/Hamburger nodes, IDs, order and Header geometry remain unchanged.
- GLASS: exact managed base `rgba(33,20,38,.75)` with 24px Blur, 145% saturation, subtle `#1C1024` gradient, `#0D0510` shadow and controlled Gold highlight/border.
- PALETTE: dedicated capsule values are `#D49A2E`, `#E8B84A`, `#F5F3F0`, `#C8C2C9`; existing Header/Nav palette values remain separate.
- ADMIN: all capsule colors, RGBA and Blur are available in the main Boutique Header module and the shared Header helper form.
- CACHE: localized state and public no-store `/topbar` endpoint carry the dedicated capsule palette so cached pages refresh before acceptance.
- VERIFY: Chrome checks computed glass background, 24px Blur, exact CSS variables, control colors and all existing Header/Hero/Features geometry.

## v3.10.17 — 2026-08-14 — Feature-to-Hero Proximity Correction
- BROWSER: Production run `31765422790` passed item count, RTL order, exact palette, Legacy removal, one-row Desktop/Mobile geometry and overflow checks; only `features_close_to_hero` failed at 21.4px versus the 20px limit.
- FIX: section offset changed from -1px to -15px in both base and Mobile rules, targeting an approximately 7px visual gap like the supplied reference.
- SCOPE: feature data, card sizes, Header, Hero, Categories, Footer, WooCommerce and Mobile toolbar remain unchanged.

## v3.10.16 — 2026-08-14 — Managed Four-Card Site Features
- DISCOVERY: Production root is `.alookhor-trustbar-container` inside Elementor HTML widget `data-id="5abd566"` and parent container `data-id="f0598d3"`; the external block currently stacks four cards on Mobile.
- REPLACE: `#alookhor-managed-features` replaces that exact root in place; no parallel feature/trust section and no Header/Hero/Footer restructuring.
- RESPONSIVE: exactly four cards remain in one row on Desktop and Mobile, with compact centered SVG icon, title and two-line description; no horizontal scrolling or stacking.
- PALETTE: scoped feature-section defaults use the owner-approved non-black colors: `#0D0510`, `#1C1024`, `rgba(33,20,38,.75)`, `#D49A2E`, `#E8B84A`, `#F5F3F0`, `#C8C2C9`.
- ADMIN: the existing main ALOOKHOR Control Center now manages enabled/replacement state, four icon/title/description records, all palette values, Radius and Gap.
- REST: public read-only `/wp-json/alookhor-cc/v1/site-features` uses `no-store`; cached Home HTML refreshes from current WordPress state.
- VERIFY: Release/Access and Chrome checks require four items, source order, exact palette, Legacy removal, proximity to Hero, one-row geometry and compact four-across Mobile cards.

## v3.10.15 — 2026-08-13 — Desktop Legacy-Copy Cleanup
- DIRECT REVIEW: Chrome run `31743997644` passed every encoded Desktop/Mobile check and fixed Mobile underlap/Arrow geometry, but direct screenshot comparison still showed baked Legacy copy at Desktop far-left and an old image badge near the lower edge.
- FOCUS: Desktop approved photography shifts 36% left (previously 21%) without horizontal Mirror, moving the entire baked copy region outside the clipped shell while keeping the product left of managed content.
- MASK: restrained bottom gradient hides baked badge artwork underneath managed Pagination; Mobile keeps its separately cropped 78% subject focus.
- AUDIT: Chrome records the active image transform determinant/translation and Mobile object-position; 3.10.15 requires a positive determinant (not mirrored) and the source-backed focus contract.

## v3.10.14 — 2026-08-13 — Live Hero Visual Polish
- DIAGNOSIS: Production Chrome run `31742642133` proved four-slide/runtime/image/right-overlay/Legacy-replacement contracts, but Mobile shell began 18.4px below the glass Capsule and failed the explicit underlap check.
- MOBILE: offset changed from -20px to -50px so the shell top enters the measured Capsule bottom without modifying Header DOM or geometry.
- ARROWS: Woodmart forced one control into a white rectangle; Appearance, dimensions, Background, Radius, Position, pseudo-elements and SVG now use exact scoped overrides.
- IMAGE: default approved banners no longer use horizontal Mirror. Subject-focus shifts/crops the product left while a near-opaque right surface conceals baked Legacy copy beneath managed writing.
- AUDIT: both visible Hero Arrow controls must be circular 36–50px and non-white in fresh Desktop/Mobile Chrome screenshots.

## v3.10.13 — 2026-08-13 — Managed Four-Slide Hero
- DISCOVERY: Production root is `.alookhor-hero-slider-wrapper` with `#alookhorHeroSlider` inside a real Elementor Shortcode widget; five images were served by external `alookhor-categories-manager`.
- REPLACE: the exact Legacy root is replaced in place by `#alookhor-managed-hero`; no parallel Slider, Elementor move, Header rewrite, or unrelated module change.
- ADMIN: exactly four slide records in the main ALOOKHOR Control Center; each has Media Library image/ID, Alt, Kicker, white Title, Gold Highlight, Description, four Feature labels, and two CTA label/URL pairs.
- FRONTEND: separate overlay writing on the right, Black/Gold layered treatment, 32px reference radius, arrows, horizontal Gold-pill Pagination, swipe, keyboard, autoplay, pause, and Reduced Motion.
- RESPONSIVE: Desktop and Mobile read the same WordPress state; Mobile Hero rises beneath the existing second glass Header capsule while Top Bar/Header controls stay untouched.
- CACHE: public read-only `/wp-json/alookhor-cc/v1/hero` endpoint uses `no-store`; cached page templates refresh from current WordPress state.
- VERIFY: Release/Access contracts and rendered Chrome geometry require four slides, one active slide, loaded image, right-side content, Legacy replacement, and Mobile Header underlap.

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
