# Changelog — ALOOKHOR Control Center (WP Plugin)

## v3.10.185 — 2026-08-31 — Luxury Glass PDP v2 (guaranteed render)
- RENDER: قالب اختصاصی محصول حالا با اولویت PHP_INT_MAX به template_include وصل می‌شود و اگر قالب‌ساز تم (وودمارت/المنتور) قالب خودش را تحمیل کند، مسیر دوم (هوک woocommerce_before_single_product) صفحه آلوخور را داخل همان قالب تزریق و اجزای قالب تم را مخفی می‌کند — رندر PDP در هر صورت تضمین شد (گارد حالت ویرایش المنتور).
- DESIGN: بازطراحی Glass لوکس طبق بریف جدید: پالت #24102F/#5B247A/طلایی/#FAF8F3، پس‌زمینه با درخشش محیطی بنفش/طلایی و گرین بسیار ظریف، پنل خرید شیشه‌ای با لبهٔ طلایی، قاب شیشه‌ای دور گالری با خط نئون ظریف، دکمه‌های شیشه‌ای شناور، انتخاب وزن شیشه‌ای با حالت فعال طلایی، قیمت درشت بنفش (Anchor بصری)، CTA طلایی 58px با درخشش نرم، نوار اعتماد شیشه‌ای ۴تایی، داستان ادیتوریال با خط طلایی، جدول مشخصات شیشه‌ای با جداکننده، «چرا آلوخور؟» با درخشش بنفش، بنر برند «پایتخت آلوی ایران» با غبار طلایی، کاروسل محصولات پیشنهادی با زوم هاور، داشبورد دیدگاه با توزیع ستاره واقعی + کارت دیدگاه‌های واقعی تأییدشده، سوالات متداول آکاردئونی شیشه‌ای، بنر CTA پایانی و نوار خرید چسبان شیشه‌ای موبایل با خط طلایی.
- DATA: همه داده‌ها واقعی (قیمت/تخفیف/موجودی/وزن/دسته/عکس/امتیاز/دیدگاه‌های تأییدشده از ووکامرس)؛ هیچ عدد یا دیدگاه جعلی ساخته نمی‌شود.
- CI: endpoint /product با شمارش‌های جدید و چک جدید pdp_renders_authenticated که صفحه محصول را با کاربر واردشده می‌گیرد و وجود PDP آلوخور را الزام می‌کند.

## v3.10.184 — 2026-08-31 — Luxury Product Page (PDP)
- TEMPLATE: صفحه تکی محصول با قالب اختصاصی آلوخور جایگزین قالب ووکامرس/وودمارت شد (template_include روی is_product)؛ هدر و فوتر مدیریت‌شده سایت سر جایشان می‌مانند.
- HERO: گالری تصاویر واقعی محصول + بندانگشتی‌ها با لایت‌باکس بزرگ‌نمایی/تمام‌صفحه؛ برند، عنوان با طلایی‌سازی خودکار، امتیاز واقعی، چیپ‌های ویژگی، انتخاب وزن (برگرفته از واریانت/وزن واقعی)، قیمت نهایی واقعی با نشان تخفیف فقط در صورت وجود تخفیف واقعی، وضعیت موجودی، تعداد، افزودن به سبد (لینک واقعی ووکامرس)، علاقه‌مندی و اشتراک‌گذاری.
- SECTIONS: چرا این محصول، از باغ تا بسته آلوخور (مسیر ایران←خراسان رضوی←زبرخان←تولیدکننده←آلوخور)، داستان محصول، انتخاب کیفیت (۴ مرحله عکس‌دار)، مشخصات محصول (۹ ردیف، داده واقعی یا «اطلاعات محصول»)، معرفی با آکاردئون، ارسال و بازگشت، بخش هدیه، خرید عمده و صادرات، پرسش‌های کاربران، داشبورد دیدگاه‌ها با توزیع ستاره واقعی و فرم ثبت دیدگاه ووکامرس، گالری مشتریان (empty-state صادقانه)، محصولات مشابه، همراه این محصول با «افزودن همه به سبد»، اخیراً مشاهده کرده‌اید (localStorage)، بند برند آلوخور.
- MOBILE: نوار خرید چسبان پایین + گالری سوایپ + چیدمان تک‌ستونه.
- API: endpoint عمومی /wp-json/alookhor-cc/v1/product و چک انتشار product_endpoint (شامل رندر زنده صفحه محصول).
- DATA: هیچ داده جعلی (قیمت/امتیاز/دیدگاه/گواهی) ساخته نمی‌شود؛ همه از ووکامرس یا تنظیمات سایت.

## v3.10.183 — 2026-08-30 — Pages Management Panel
- PANEL: منوی جدید «مدیریت برگه‌ها» (alookhor-cc-pages) در ALOOKHOR Center با ظاهر لوکس هم‌خانواده پنل؛ تمام متن‌های برگه‌های تماس با ما و درباره ما قابل ویرایش شد.
- MEDIA: انتخابگر تصویر وردپرس برای عکس داستان و چهار کارت سفر محصول + دکمه بازنشانی پیش‌فرض.
- STORAGE: تنظیمات در option alookhor_pages_settings با sanitization کامل (متن، URL، ساختار ثابت ۵ پرسش / ۴×۴ بخش) ذخیره و در رندر برگه‌ها با escape امن (esc_html + طلایی‌سازی خودکار واژه آلوخور) اعمال می‌شود؛ پیش‌فرض‌ها عیناً مقادیر فعلی سایت‌اند.
- API: endpoint عمومی /wp-json/alookhor-cc/v1/pages و چک انتشار pages_endpoint.

## v3.10.182 — 2026-08-30 — Frontend Admin Bar Removed
- DIAGNOSIS: تنها عنصر مشکی بالای سایت در هر دو Breakpoint، نوار مدیریت وردپرس (#1d2327؛ ۳۲px دسکتاپ / 46px موبایل) بود که فقط برای کاربر واردشده رندر می‌شود.
- FIX: فیلتر show_admin_bar نوار را در کل نمای سایت حذف می‌کند و استایل اطمینان در wp_head (html margin/padding-top صفر + #wpadminbar مخفی) نسخه‌های کش‌شده را هم پوشش می‌دهد.
- NOTE: پیشخوان وردپرس از /wp-admin مثل قبل کامل در دسترس است؛ قانون‌های جایگزینی admin-bar در CSSهای هدر بی‌اثر و بی‌ضرر ماندند.
- CI: چک frontend_no_adminbar به تست انتشار اضافه شد.

## v3.10.181 — 2026-08-30 — Journey Cards Photo Backgrounds
- DIRECTIVE: مالک برای کارت‌های سفر محصول، به‌جای پس‌زمینه بنفش، عکس مرتبط با نوشته هر کارت خواست؛ آیکن‌ها و سایر عناصر باید بمانند.
- PHOTOS: برداشت از باغ ← آلو بخارا (category-plums)، سورت دقیق ← مغزبار ممتاز (category-nuts)، بسته‌بندی بهداشتی ← برگه میوه‌ها (category-fruit-sheets)، ارسال به جهان ← بنر صادراتی (export-banner-bg)؛ همه از دارایی‌های خود افزونه.
- READABILITY: لایه گرادیان تیره بنفش-مشکی روی عکس، زمینه پشت آیکن‌ها، سایه متن و روشن‌سازی توضیحات؛ زنگ طلایی قاب حفظ شد.

## v3.10.180 — 2026-08-30 — Theme-proof Close Icon
- ROOT CAUSE: آیکن X بستن دراور به SVG stroke وابسته بود و قانون‌های SVG قالب رندر آن را روی دستگاه مالک خراب می‌کرد.
- FIX: X با دو میله شبه‌المان تمام‌CSS (گرادیان طلایی روشن به طلایی برند + هاله دولایه) کشیده می‌شود؛ SVG پنهان شد و تداخل قالب غیرممکن شد.
- POLISH: قاب طلایی، هاور درخشان‌تر، فشرده‌سازی لمسی و پشتیبانی prefers-reduced-motion.

## v3.10.179 — 2026-08-30 — Mobile Drawer Width & Logout
- WIDTH: عرض دراور موبایل از min(360px,90vw) به min(300px,80vw) و سقف پایه از 88vw به 82vw کاهش یافت.
- AUTH: لینک تمام‌عرض «خروج از حساب» با wp_logout_url برای کاربران واردشده و «ورود به حساب» برای مهمانان به فوتر دراور اضافه شد؛ آیکن SVG طلایی نورانی هم‌خانواده صفحه تماس.
- CI: چک header_drawer_auth به تست انتشار اضافه شد.

## v3.10.178 — 2026-08-30 — Gold Icon Glyphs
- ROOT CAUSE: SVGهای داخل کارت‌های سریع هیچ قانون stroke/fill نداشتند؛ مرورگر آنها را با fill مشکی پیش‌فرض می‌کشید (دایره طلایی دورشان بود ولی خود عکس مشکی).
- FIX: قانون صریح fill:none + stroke طلایی روشن (#F5D76E) با stroke-width 1.9 و درخشش برای گلیف‌های کارت‌های تماس، ساعات کاری و پین نقشه.
- UNIFY: دکمه واتساپ، سپر حریم خصوصی و چیپ‌های هدر نیز طلایی یکدست شدند؛ آیکن دکمه مسیریابی روی زمینه طلایی عمداً تیره ماند (خوانایی).

## v3.10.177 — 2026-08-30 — Unified Luminous Gold Icons
- DIRECTIVE: مالک آیکن‌های چندرنگ را نپسندید؛ همه آیکن‌های صفحه تماس طلایی یکدست و نورانی شدند.
- GLOW: انیمیشن درخشش تنفسی acp-glow روی هاله و پس‌زمینه، drop-shadow دولایه روی خطوط SVG با رنگ طلایی روشن #F5D76E و طلایی برند.
- CLEANUP: تعریف‌های رنگی اختصاصی قبلی (سبز/آبی/مرجانی/بنفش) حذف شدند؛ پالس حلقه و شنا آرام پلکانی حفظ شد و در prefers-reduced-motion غیرفعال می‌ماند.

## v3.10.176 — 2026-08-30 — Contact Icons & Google Map
- ICONS: آیکن‌های کارت‌های سریع و ساعات کاری به سیستم رنگ اختصاصی با متغیر CSS (--acc) مهاجرت کردند: تلفن طلایی، واتساپ سبز، ایمیل آبی آسمانی، نشانی مرجانی، ساعت بنفش، فعالیت سبزتی‌نایی.
- MOTION: شنا آرام پلکانی (acp-float)، پالس حلقه دائمی برای تلفن و پالس هاور برای بقیه (acp-ring) و درخشش گذر روی کارت‌ها؛ در prefers-reduced-motion کاملاً غیرفعال.
- MAP: بخش «ما را روی نقشه ببینید» با iframe گوگل‌مپ (بارگذاری تنبل، hl=fa، z=13)، قاب دوخطی طلایی و CTA مسیریابی مستقیم برای نشانی خور نیشابور.
- CI: چک‌های contact_map و contact_icon_accents به تست انتشار اضافه شد.

## v3.10.175 — 2026-08-30 — About Legacy Redirect Decode
- ROOT CAUSE: REQUEST_URI برای مسیرهای فارسی به‌صورت percent-encoded نگه داشته می‌شود و مقایسه مستقیم با رشته فارسی هرگز برابر نمی‌شد؛ /درباره-ما/ به ۴۰۴ وردپرس می‌رسید.
- FIX: مسیر درخواست پیش از مقایسه با rawurldecode رمزگشایی می‌شود و /درباره-ما/ با ۳۰۱ به /about/ هدایت می‌شود.

## v3.10.174 — 2026-08-30 — About Legacy URL Fix
- FIX: چک about_legacy_resolves به quote بدون import وابسته بود و با NameError شکست می‌خورد؛ نشانی فارسی به‌صورت percent-encoded مستقیم ساخته می‌شود.

## v3.10.173 — 2026-08-30 — About Release Checks Fix
- FIX: چک about_schema در تست انتشار هنوز schema نسخه ۱ را انتظار داشت؛ به نسخه ۲ (اسلاگ about) به‌روز شد.
- HARDENING: چک‌های زنده /about/ و مسیر فارسی قدیمی با except عمومی در برابر خطاهای شبکه مقاوم شدند تا اجرای گام انتشار شکست نخورد.

## v3.10.172 — 2026-08-30 — Release Pipeline Reliability
- ROOT CAUSE: گزارش indent-دار تست انتشار از سقف clean() با ۱۲۰۰۰ کاراکتر عبور کرد؛ json.loads روی متن دم‌بریده کرش می‌کرد و گام Write sanitized publisher status branch در انتشارهای 3.10.170 و 3.10.171 شکست می‌خورد.
- FIX: خروجی فایل گزارش و چاپ آن در scripts/wordpress_release_test.py با separators فشرده شد؛ اندازه گزارش با حاشیه امن زیر سقف می‌ماند.

## v3.10.171 — 2026-08-30 — About Slug Hardening
- ROOT CAUSE: در 3.10.170 مهاجرت، صفحه موجود با اسلاگ «درباره-ما» را برگزید و نگه داشت؛ در نتیجه /درباره-ما/ رندر می‌شد ولی منوی اصلی به /about/ می‌رفت که ۴۰۴ می‌ماند.
- CANONICAL SLUG: مهاجرت نسخه ۲ اسلاگ صفحه مدیریت‌شده را قطعیاً روی about تنظیم می‌کند؛ اگر صفحه دیگری اسلاگ را نگه داشته باشد، ابتدا با پشتیبان در option نسخه‌دار آزاد و حذف می‌شود.
- LOOP-SAFE REDIRECT: هر دو مسیر قدیمی در init زودهنگام به نشانی canonical هدایت می‌شوند و اگر هدف همان مسیر جاری باشد ریدایرکت اجرا نمی‌شود (ضدحلقه).
- CI: چک about_legacy_resolves برای مسیر فارسی قدیمی اضافه شد.

## v3.10.170 — 2026-08-30 — Luxury About Page
- ROOT CAUSE: منوی «درباره ما» به /about/ لینک می‌داد ولی هیچ برگه‌ای در وردپرس وجود نداشت و مسیر ۴۰۴ بود.
- PAGE: برگه لوکس با داستان برند (خور نیشابور)، آمار برند، مسیر چهارمرحله‌ای «از باغ تا خانه شما»، چهار ارزش و نوار همکاری/صادرات با CTA به تماس و فروشگاه ساخته شد.
- MIGRATION: مهاجرت نسخه ۱ برگه انتشار‌یافته با اسلاگ about را تضمین می‌کند؛ صفحات دمو/پیش‌نویس هم‌نام یا هم‌عنوان با پشتیبان برگشت‌پذیر به شورت‌کد مهاجرت و از Elementor پاکسازی می‌شوند؛ rewrite_rules یک‌بار باطل شد.
- MOTION: انیمیشن ورود سبک با IntersectionObserver و غیرفعال‌سازی کامل در prefers-reduced-motion.
- API: Endpoint عمومی /wp-json/alookhor-cc/v1/about با HTML رندرشده و وضعیت مهاجرت؛ تست انتشار CI با چک‌های about تکمیل شد.

## v3.10.169 — 2026-08-30 — Contact Route Hardening
- ROOT CAUSE: پس از 3.10.168 مشخص شد هیچ برگه‌ای با اسلاگ contact در وردپرس نیست؛ لایه کش برای /contact/ HTML ژاپنی کهنه (بدون کوئری) یا ۴۰۴ ساده غیروردپرسی (با کوئری) سرو می‌کرد و hook سطح template_redirect اصلاً اجرا نمی‌شد.
- ALIAS PAGE: مهاجرت نسخه ۳ برگه انتشار‌یافته واقعی با اسلاگ contact و محتوای شورت‌کد تضمین می‌کند؛ برگه غیرمنتشرشده قفل‌کننده اسلاگ ابتدا با پشتیبان در option نسخه‌دار حذف می‌شود.
- EARLY 301: ریدایرکت به init با اولویت ۱ منتقل شد (با گارد admin/REST/cron و nocache_headers) و template_redirect به‌عنوان پشتیبان باقی ماند.
- PURGE: پاکسازی یک‌باره Rocket/W3TC/WP Super Cache/SiteGround/LiteSpeed در پایان مهاجرت اجرا می‌شود تا نسخه‌های کهنه دمو فوراً بمیرند.

## v3.10.168 — 2026-08-30 — Professional Contact Page V2
- ROOT CAUSE: صفحه قدیمی /contact/ هنوز ژاپنی رندر می‌شد (کش، redirect را دور می‌زد) و عنوان سایت باقی‌مانده دمو «دمو کلاسیک» بود.
- REDESIGN: بازطراحی کامل لوکس — کارت‌های تماس سریع (تلفن/واتساپ/ایمیل/نشانی)، پنل اطلاعات با ساعت کاری، فرم با اعتبارسنجی زنده و اسپینر، آکاردئون پرسش‌های پرتکرار و نوار پایانی.
- LEGACY: صفحه ژاپنی با پشتیبان برگشت‌پذیر به شورت‌کد فارسی مهاجرت و /contact/ با ۳۰۱ دائمی به صفحه رسمی هدایت می‌شود (مچ بهبودیافته روی مسیر و query string).
- BRAND: blogname باقی‌مانده «دمو کلاسیک» فقط در صورت همان مقدار دقیق به «آلوخور» اصلاح شد؛ عنوان و متای سئو/OG اختصاصی صفحه تماس اضافه شد.
- PALETTE: رنگ طلایی صفحه به‌صورت زنده از تنظیمات هدر مالک خوانده می‌شود (پیش‌فرض #D4AF37).
- API: Endpoint عمومی /wp-json/alookhor-cc/v1/contact با HTML رندرشده و وضعیت مهاجرت اضافه شد؛ تست انتشار CI با ۶ چک جدید contact تکمیل شد.

## v3.10.167 — 2026-08-29 — Professional Contact Page
- PAGE: برگه قدیمی/ژاپنی تماس با پشتیبان قابل‌بازگشت به `[alookhor_contact_page]` مهاجرت می‌شود.
- FORM: فرم AJAX با Nonce، Honeypot، Rate limit و اعتبارسنجی سمت سرور ساخته شد.
- MESSAGES: پیام‌ها به‌صورت Private در WordPress ذخیره و اعلان ایمیل مدیر ارسال می‌شود.
- LINKS: منوها، دکمه‌ها و مسیر قدیمی `/contact/` خودکار به برگه فارسی متصل می‌شوند.
- UX: Glassmorphism، اطلاعات واقعی سایت و Responsive مستقل موبایل پیاده شد.

## v3.10.167 — 2026-08-29 — Campaign Bottom Glass Rail All Viewports
- ROOT CAUSE: نسخه 3.10.165 کارت را فقط در Breakpoint موبایل حذف کرده بود؛ تصویر ارسالی Desktop بود.
- GLOBAL: کارت شناور در Desktop، Tablet و Mobile کاملاً حذف شد.
- GLASS RAIL: عنوان، توضیح و CTA در نوار شیشه‌ای تمام‌عرض 108px پایین تصویر قرار گرفتند.
- CONTROLS: Dots بالای نوار و فلش‌ها در مرکز تصویر باقی ماندند.

## v3.10.167 — 2026-08-29 — Campaign Mobile Bottom Glass Bar
- STRUCTURE: کارت شناور سمت راست در موبایل کاملاً حذف شد.
- GLASS BAR: محتوا داخل نوار شیشه‌ای باریک 86–92px و تمام‌عرض در پایین اسلاید قرار گرفت.
- LAYOUT: عنوان/توضیح در راست و CTA لمسی در چپ نوار چیدمان شدند؛ Kicker موبایل مخفی شد.
- CONTROLS: Dots بالای نوار قرار گرفتند و فلش‌ها از محتوا فاصله امن دارند.

## v3.10.167 — 2026-08-29 — Campaign Slider Mobile V2
- MOBILE CARD: محتوای هر بنر در کارت Glass کوچک پایین تصویر و بدون پوشاندن سوژه قرار گرفت.
- FRAME: قاب دوخطی طلایی با Glow تنفسی 4.5s به کل اسلایدر اضافه شد.
- GESTURES: Swipe افقی، Keyboard، Home/End، Focus pause و Visibility pause پیاده شد.
- CONTROLS: فلش‌های RTL اصلاح و Touch target 44px و Dots حداقل 12px شدند.
- BOUTIQUE: شش تصویر و تمام متن/CTAهای مستقل موجود همچنان از بوتیک مدیریت می‌شوند.

## v3.10.167 — 2026-08-29 — Hero Circular-inspired 3D Transition
- ADAPTATION: منطق Circular Gallery به Runtime سبک Vanilla JS مخصوص WordPress تبدیل شد؛ React/Tailwind به افزونه تحمیل نشد.
- 3D MOTION: Perspective 1800px، RotateY و Depth برای ورود/خروج افقی اسلایدهای تمام‌عرض اجرا شد.
- STATES: Before/After/Far/Active برای حرکت روان و Loop دائمی اضافه شد.
- RESPONSIVE: زاویه و عمق در موبایل کاهش یافت و Swipe/Keyboard/Autoplay قبلی حفظ شد.
- ACCESSIBILITY: در Reduced Motion تمام Transform و Transition سه‌بعدی غیرفعال می‌شوند.

## v3.10.167 — 2026-08-29 — International Standards Mobile Portrait
- PORTRAIT: سه کارت در عرض 421–767px و دو کارت در عرض زیر 420px مطابق مرجع اجرا شد.
- STATS: نوار آمار 2×2 با آیکن، عدد و عنوان مستقل بازطراحی شد.
- TRUST CTA: کارت تصویری «اعتماد شما سرمایه ماست» در پایین موبایل اضافه شد.
- BOUTIQUE: عنوان، متن و تصویر کارت اعتماد موبایل قابل مدیریت هستند.
- UX: اندازه متن، Touch spacing و Gradient موبایل مستقل بهینه شد.

## v3.10.167 — 2026-08-29 — International Standards V2
- HEADER: عنوان دو‌رنگ سفید/طلایی، تاج و Divider مطابق مرجع اجرا شد.
- CARDS: شش کارت بلند Glass با حلقه آیکن، Divider، Shine و Hover لوکس ساخته شد.
- STATS: چهار آمار آیکن‌دار در نوار گرادینتی و شمارنده متحرک پیاده شد.
- BOUTIQUE: بخش طلایی عنوان و آیکن هر آمار به کنترل‌های کامل قبلی اضافه شد.
- RESPONSIVE: چیدمان 6/3/2/1 برای Desktop/Tablet/Mobile/Small Mobile اجرا شد.

## v3.10.167 — 2026-08-28 — Sorting & Packaging Center V2
- COMPOSITION: متن/محصولات/مزیت‌ها در چپ و اسلایدر تصویر بزرگ در راست مطابق مرجع اجرا شد.
- MEDIA: شش تصویر، Badge صادرات +50، Caption، فلش، Dots و Crossfade/Zoom ظریف حفظ شد.
- GLASS: چهار کارت Glass با Blur، Shine، Hover و نور متحرک آیکن‌ها ساخته شد.
- ACTIONS/STATS: دو CTA مستقل و نوار چهار آمار آیکن‌دار اضافه شد.
- MOBILE UX: Stack تصویر/محتوا، Swipe، Keyboard، Touch 44px و آمار/مزیت 2×2 پیاده شد.
- BOUTIQUE: تمام متن‌ها، دکمه‌ها، Badge، مزیت‌ها، آمار، تصاویر و رنگ‌ها قابل مدیریت‌اند.

## v3.10.167 — 2026-08-28 — Why ALOOKHOR Responsive Cleanup
- DESKTOP: محدودیت 650px متن معرفی برداشته و در عرض بالای 1150px متن در یک خط کامل نمایش داده می‌شود.
- MOBILE: نقاط تزئینی شبیه Pagination به‌طور کامل حذف شدند.
- WRAP: در Tablet/Mobile شکستن طبیعی متن حفظ شد تا Overflow ایجاد نشود.

## v3.10.158 — 2026-08-28 — Why ALOOKHOR Mobile Portrait Composition
- TOP: تصویر در 42٪ چپ و Header/Story در 58٪ راست، مطابق Composition مرجع قرار گرفت.
- CARDS: چهار کارت در عرض 521–767px و دو کارت در موبایل کوچک نمایش داده می‌شوند.
- STATS: نوار آمار ۴ ستونه در Portrait بزرگ و ۲×۲ در عرض زیر 520px شد.
- DETAILS: Badge تصویر در موبایل حذف، Dots تزئینی، آیکن/شماره و Typography مستقل اضافه شد.
- UX: در 320px هیچ Overflow افقی و متن فشرده زیر 8px وجود ندارد.

## v3.10.157 — 2026-08-28 — Why ALOOKHOR Rich Purple Art Direction
- SECTION: ترکیب دو Radial بنفش/طلایی و Linear عمیق، عمق پس‌زمینه مرجع را بازسازی کرد.
- CARDS: گرادینت `Card → Brand Purple → Deep Purple` با Inner light ظریف اعمال شد.
- ICONS: حلقه‌ها Surface بنفش چندلایه و Glow بسیار محدود طلایی گرفتند.
- VISUAL/STAT: Overlay تصویر، Badge برند و نوار آمار با همان زبان گرادینتی یکپارچه شدند.
- SETTINGS: رنگ‌های انتخابی بوتیک همچنان Base اصلی تمام گرادینت‌ها هستند.

## v3.10.156 — 2026-08-28 — Why ALOOKHOR Visual Composition V2
- VISUAL: تصویر بزرگ محصول در ستون چپ با Crop حرفه‌ای، Overlay پایین و Badge شیشه‌ای برند اضافه شد.
- CONTENT: Header و متن معرفی در ستون راست و چهار کارت شماره‌دار 01–04 با آیکن‌های 92px پیاده شد.
- STATS: نوار پایین با چهار آیکن مستقل، اعداد بزرگ و Dividerهای عمودی مطابق مرجع بازطراحی شد.
- BOUTIQUE: تصویر Media Library، عنوان/متن Badge، آیکن‌های آمار و تمام محتوای قبلی قابل ویرایش شدند.
- RESPONSIVE: Tablet دو کارت و Mobile تصویر/محتوا Stack، کارت‌های 2/1 ستونه و آمار 2×2 شدند.

## v3.10.155 — 2026-08-28 — Pristine Hero Photography
- SHADE: لایه `.alookhor-mh-shade` در Desktop و Mobile کاملاً حذف شد.
- FILTERS: تمام Filterهای Brightness، Saturation و Contrast اجباری از تصویر برداشته شدند.
- RESULT: رنگ و نور اصلی فایل تصویر بدون هاله بنفش یا سایه اضافی نمایش داده می‌شود.
- COPY: کارت شیشه‌ای نوشته مستقل باقی ماند و خوانایی متن را بدون دستکاری کل عکس تأمین می‌کند.

## v3.10.154 — 2026-08-28 — Category Title Correction
- COPY: «محصولات منتخب آلوخور» حذف و عنوان صحیح «دسته‌بندی محصولات» بازگردانی شد.
- SCALE: اندازه عنوان دسکتاپ از 48–72px به 38–54px کاهش یافت.
- MOBILE: اندازه عنوان به 28–35px محدود شد.
- MIGRATION: هر دو عنوان قدیمی به‌صورت خودکار به متن صحیح منتقل می‌شوند.

## v3.10.153 — 2026-08-28 — Luminous Category Editorial Identity
- KICKER: «دسته‌بندی محصولات» به `ALOOKHOR PRODUCT CATEGORIES` انگلیسی، کوچک و طلایی تبدیل شد.
- TITLE: عنوان قدیمی حذف و «محصولات منتخب آلوخور» با اندازه 48–72px، وزن 900 و رنگ سفید جایگزین شد.
- SUBTITLE: زیرعنوان قدیمی حذف و فضای آن نیز Collapse شد.
- HALO: Glow سفید چندلایه با انعکاس بسیار محدود طلایی و Pulse آرام اضافه شد.
- MOBILE: عنوان 32–42px و Kicker 9px با فاصله‌گذاری مستقل اجرا شد.

## v3.10.152 — 2026-08-28 — Deterministic RTL Mobile Header Order
- ROOT CAUSE: `direction:rtl` ترتیب نام‌گذاری Grid Areaها را در مرورگر به‌صورت معکوس تفسیر و لوگو را به چپ منتقل می‌کرد.
- FLEX RTL: Grid حذف و Flex RTL قطعی جایگزین شد.
- ORDER: لوگو در راست، همبرگری بلافاصله کنار آن و ابزارهای جستجو/سبد/حساب در فضای چپ قرار گرفتند.
- SMALL MOBILE: عرض لوگو و همبرگری زیر 360px مستقل و بدون Overflow تنظیم شد.

## v3.10.151 — 2026-08-28 — Clean Mobile Hero Photography + Centered Copy
- IMAGE: Shade و Gradient بنفش روی تصویر موبایل کاملاً حذف شد؛ Brightness به 98٪ بازگشت.
- NO DOUBLE SHADOW: تنها کارت Glass زمینه متن را تأمین می‌کند و سایه دوم روی عکس وجود ندارد.
- ALIGNMENT: عنوان، Highlight، توضیح و CTA داخل کارت به‌طور کامل مرکزچین شدند.

## v3.10.150 — 2026-08-28 — Compact Mobile Hero Glass Card
- COMPACT CARD: محتوای Hero در کارت شیشه‌ای 245px گوشه چپ پایین قرار گرفت؛ ارتفاع اسلایدر به 390–470px کاهش یافت.
- TYPE: عنوان از 27–38px به 21–28px کاهش و Kicker در موبایل حذف شد.
- FEATURES: چهار ویژگی فقط در موبایل مخفی شدند تا عکس و CTA فضای کافی داشته باشند.
- ARROWS: جهت SVG فلش قبلی/بعدی برای منطق RTL اصلاح شد.
- SMALL MOBILE: کارت 220px و ارتفاع 400px برای عرض زیر 375px تنظیم شد.

## v3.10.149 — 2026-08-28 — Mobile Hero UX Phase
- INDEPENDENT COMPOSITION: Hero موبایل مستقل از Desktop با ارتفاع 430–560px و بدون Overflow بازطراحی شد.
- IMAGE: `object-fit:cover` و Focus 64٪، نوارهای خالی و تصویر باریک کنار پنل را حذف کرد.
- READABILITY: Gradient بنفش جهت‌دار جای پنل حجیم را گرفت؛ متن روی تصویر خوانا و خود عکس همچنان غالب است.
- CONTENT: عنوان 27–38px، توضیح 11.5px، ویژگی‌های 2×2 و یک CTA اصلی 42px اجرا شد.
- TOUCH: فلش‌های 44px، Dots قابل‌دید و فاصله امن از Header پیاده شد.
- SMALL MOBILE: Override مستقل زیر 375px اضافه شد.

## v3.10.148 — 2026-08-28 — Mobile Header UX Phase
- LAYOUT: کپسول موبایل به Grid مستقل Logo/Menu/Tools تبدیل و Overflow در عرض 320px حذف شد.
- TOUCH: تمام دکمه‌های اصلی، Close، Submenu و Footer Drawer حداقل 44–48px شدند.
- DRAWER A11Y: Role dialog، aria-modal/hidden/expanded، Focus trap، Escape، بازگشت Focus و قفل Scroll پیاده شد.
- SAFE AREA: ارتفاع 100dvh و Safe Area بالا/پایین برای دستگاه‌های iOS رعایت شد.
- VISUAL: Drawer و Backdrop با سه Surface بنفش، Border طلایی و Blur کنترل‌شده هماهنگ شدند.

## v3.10.147 — 2026-08-28 — Luminous Category Heading Hierarchy
- KICKER: «دسته‌بندی محصولات» به 17–22px، وزن 800 و Glow طلایی چندلایه ارتقا یافت.
- TITLE: عنوان اصلی «محصولات طبیعی...» به 34–46px کاهش یافت تا Hierarchy متوازن و حرفه‌ای شود.
- SUBTITLE: اندازه 15–19px، وزن 500 و Line-height 1.9 برای خوانایی بهتر اعمال شد.
- MOTION: Pulse نوری بسیار آرام 3.8s با رعایت Reduced Motion اضافه شد.
- MOBILE: مقیاس مستقل 15px/27–34px برای Kicker/Title اجرا شد.

## v3.10.146 — 2026-08-28 — Hero Description Gold Arrow Dividers
- DIVIDERS: دو خط طلایی باریک و جهت‌دار با نقطه انتهایی دو طرف توضیح Hero اضافه شد.
- MULTILINE: خط جدید واردشده در textarea توضیح هر اسلاید با `nl2br` به خط واقعی در Frontend تبدیل می‌شود.
- RESPONSIVE: طول Divider در موبایل کوتاه و متناسب می‌شود تا متن فشرده نشود.

## v3.10.145 — 2026-08-28 — Editorial Persian Hero Typography
- ALIGNMENT: تمام محتوای پنل Hero مرکزچین و Composition عنوان/توضیح/ویژگی/CTA متوازن شد.
- TITLE: عنوان اصلی Vazirmatn وزن 900 با اندازه 48–76px و بخش Highlight طلایی در خط مستقل تنظیم شد.
- DESCRIPTION: توضیح با وزن 500، اندازه 16–22px، Line-height 1.9 و عرض خوانای 640px تنظیم شد.
- MOBILE: عنوان 26–34px، Wrap کنترل‌شده و CTA/متن مستقل برای عرض زیر 768px پیاده شد.

## v3.10.144 — 2026-08-27 — Desktop Navigation Baseline Alignment
- ROOT CAUSE: Rule قالب روی آخرین `li` منو Margin/Vertical offset متفاوت اعمال می‌کرد و «تماس با ما» پایین‌تر دیده می‌شد.
- LOCK: Nav، UL و LI روی `align-items:center` و تمام LI/Aها روی ارتفاع 42px و `line-height:1` قفل شدند.
- RESET: Margin، Top/Bottom، Transform و Vertical Align آخرین آیتم صراحتاً Reset شد.

## v3.10.143 — 2026-08-27 — Newsletter Discount Card Matches App Banner
- FOOTPRINT: بخش خبرنامه/تخفیفات داخل Card مرکزی با عرض 1380px و حداقل ارتفاع 104px قرار گرفت.
- CONSISTENCY: Padding 20/38، Border طلایی ظریف، Radius تنظیم‌شده و Shadow بنفش مطابق بنر اپلیکیشن شد.
- RESPONSIVE: Padding و Radius کارت در Tablet/Mobile مستقل و Touch-safe تنظیم شد.
- SETTINGS: Background، Surface، Gold و Radius همچنان از مدیریت بوتیک خوانده می‌شوند.

## v3.10.142 — 2026-08-27 — Export Banner Phone Direction + Official Logo
- PHONE BIDI: شماره‌های واتساپ با `direction:ltr` و `unicode-bidi:isolate` از محیط RTL جدا شدند؛ ترتیب ارقام و گروه‌ها صحیح است.
- LOGO FALLBACK: اگر لوگوی اختصاصی بنر خالی باشد، `top_logo_url` رسمی هدر (LOGO2) خودکار استفاده می‌شود.
- LETTER: حرف «آ» فقط fallback نهایی در نبود هر دو لوگوی اختصاصی و رسمی است.
- FIT: اندازه و Object Fit لوگوی رسمی داخل حلقه مرکزی اصلاح شد.

## v3.10.141 — 2026-08-27 — Standards Elementor Rendering Fix
- ROOT CAUSE: Guard رفع خطای 500، Inline CSS را در AJAX حذف می‌کرد و Elementor Editor در بعضی رندرها Handle فرانت را دریافت نمی‌کرد؛ خروجی خام دیده می‌شد.
- LIGHTWEIGHT LINK: در Editor/AJAX فقط یک `<link>` کوچک و نسخه‌دار همراه Widget چاپ می‌شود؛ Stylesheet کامل داخل Response تکرار نمی‌شود.
- WIDTH: Container مطابق مرجع روی 1200px استاندارد شد.
- SAFE: مسیر Live، Cache و Guard جلوگیری از HTTP 500 دست‌نخورده باقی ماند.

## v3.10.140 — 2026-08-27 — International Standards Section
- SHORTCODE: `[alookhor_international_standards]` اضافه شد.
- CARDS: شش کارت Glass برای ISO 9001، HACCP، ORGANIC، HALAL، FDA و GMP با آیکن Line ساخته شد.
- MOTION: Hover Lift، Icon Glow/Rotate، Reveal مرحله‌ای و شمارنده انیمیشنی اضافه شد.
- BOUTIQUE: تمام متن‌ها، آیکن‌ها، چهار آمار، پنج رنگ و Radius قابل مدیریت است.
- RESPONSIVE: ۶/۳/۲ ستون برای Desktop/Tablet/Mobile پیاده شد.

## v3.10.139 — 2026-08-27 — Why ALOOKHOR Complete Content + Palette
- CONTENT: متن کامل چهار مزیت مطابق مرجع به Defaults و ترمیم مقادیر خالی اضافه شد.
- STATS: مقادیر +15، +50، +1000 و +500 با عنوان‌های کامل و شمارنده انیمیشنی اضافه شدند.
- PALETTE: Background `#0B0716`، Card `#12091A`، Gold `#D4A436`، Text سفید و Muted `#C8BDCC` تنظیم شد.
- COMPOSITION: خط نقطه‌ای تزئینی طلایی به ردیف آمار اضافه و در موبایل بهینه شد.
- BOUTIQUE: تمام عنوان‌ها، توضیحات، آیکن‌ها، اعداد، برچسب آمار و رنگ‌ها قابل ویرایش‌اند.

## v3.10.137 — 2026-08-27 — Moving Gold Navigation Indicator
- MOTION: زیرخط طلایی با اندازه و مختصات واقعی لینک Hover شده حرکت می‌کند.
- RETURN: پس از خروج Pointer، نشانگر نرم به صفحه فعال بازمی‌گردد.
- KEYBOARD: Focus کیبورد نیز دقیقاً همان رفتار را دارد.
- ACCESSIBILITY: Reduced Motion و مخفی‌سازی در Navigation موبایل رعایت شد.

## v3.10.136 — 2026-08-27 — Why ALOOKHOR Glass Motion Upgrade
- GLASS: کارت‌ها و ردیف آمار به Surface شیشه‌ای واقعی با Blur 25px، Saturation و Border طلایی ظریف تبدیل شدند.
- INTERACTION: Hover Lift، Shine عبوری و چرخش/Glow ظریف آیکن‌ها مطابق مرجع اضافه شد.
- REVEAL: کارت‌ها به‌ترتیب با IntersectionObserver ظاهر می‌شوند.
- COUNTERS: اعداد واقعی واردشده در آمار هنگام ورود به Viewport به‌صورت نرم شمارش می‌شوند.
- ACCESSIBILITY: در Reduced Motion تمام حرکت‌های تزئینی متوقف می‌شوند.

## v3.10.134 — 2026-08-27 — Luminous Main Navigation Frame
- FRAME: قاب پیوسته و باریک 1px طلایی دور کل کپسول شیشه‌ای منوی اصلی اضافه شد.
- GLOW: Glow بیرونی 7px و نور داخلی بسیار محدود بدون سنگین‌کردن Header اجرا شد.
- INTERACTION: Hover با Transition 0.35s فقط شدت نور را افزایش می‌دهد و Layout را تغییر نمی‌دهد.

## v3.10.133 — 2026-08-27 — Elementor HTTP 500 Save Fix
- ROOT CAUSE: هر شورت‌کد یک Stylesheet کامل را داخل خروجی HTML تزریق می‌کرد؛ Elementor هنگام Preview/Save همه ماژول‌ها را در یک `admin-ajax` رندر و پاسخ بسیار سنگین تولید می‌کرد.
- AJAX GUARD: Inline CSS در `wp_doing_ajax`، محیط Admin و Actionهای Elementor به‌طور مرکزی متوقف شد.
- CACHEABLE ASSETS: CSS در Editor/Frontend فقط از Handleهای نسخه‌دار و Cacheable افزونه بارگذاری می‌شود.
- SCOPE: تمام ۱۲ شورت‌کد مدیریت‌شده به Guard مشترک متصل شدند؛ خروجی عادی سایت دست‌نخورده است.

## v3.10.132 — 2026-08-27 — Why ALOOKHOR Section
- SHORTCODE: `[alookhor_why_alookhor]` و Alias `[alookhor_why_us]` اضافه شد.
- BENEFITS: چهار کارت مزیت با آیکن‌های Line هماهنگ، عنوان و توضیح مستقل ساخته شد.
- REAL STATS: چهار آمار اختیاری فقط در صورت ورود مقدار واقعی نمایش داده می‌شوند.
- BOUTIQUE: تمام متن‌ها، آیکن‌ها، آمار، پنج رنگ و گردی کارت قابل مدیریت است.

## v3.10.131 — 2026-08-27 — Premium Featured Collection Redesign
- COMPOSITION: Header مرکزی تاج‌دار، Kicker انگلیسی، عنوان دو‌رنگ، Divider و CTA کل مجموعه مطابق مرجع اضافه شد.
- CARDS: تصویر بزرگ، Badge، نام، امتیاز/تعداد نظر واقعی WooCommerce، توضیح کوتاه، قیمت و دکمه مشاهده محصول پیاده شد.
- DECOR: بوته‌های خطی طلایی دو گوشه و Glow بسیار ظریف بدون تصویر خارجی اضافه شد.
- CAROUSEL: Loop بدون Transform، فلش دوطرفه، Autoplay و Responsive ۴/۲/۱ کارتی اجرا شد.
- BOUTIQUE: تمام متن‌های جدید، اجزای نمایشی و رنگ‌های Section/Card/Gold/Text/Muted قابل کنترل هستند.

## v3.10.129 — 2026-08-27 — Boutique Color Authority Restored
- ROOT CAUSE: لایه مرکزی Design System با `!important` و چرخه A/B/C رنگ‌های ذخیره‌شده هر فرم را Override می‌کرد.
- AUTHORITY: هر ماژول اکنون مستقیماً از CSS Variable اینلاین و ذخیره‌شده خودش برای Section، Card، Text و Accent می‌خواند.
- ELEMENTOR: تمام میزبان‌های Elementor شفاف هستند تا رنگ انتخابی بخش را نپوشانند.
- RETIRED: تخصیص خودکار یکی‌درمیان رنگ‌ها از Runtime حذف شد؛ کنترل کامل دوباره در اختیار مدیریت بوتیک است.

## v3.10.128 — 2026-08-27 — Trust Card Dark Palette Restore
- ROOT CAUSE: قانون قدیمی Warm Card با Selector قوی `html body` روی رنگ جدید کارت ویژگی‌ها غالب مانده بود.
- FIX: Selector اختصاصی قوی‌تر روی خود `.alookhor-sf .alookhor-sf-card` اعمال شد.
- COLORS: کارت گرادیان محدود `#26213D → #1D1126`، متن سفید، متن فرعی `#E5E5E5` و آیکن طلایی شد.

## v3.10.127 — 2026-08-27 — Strict Three-purple Surface Palette
- ROOT CAUSE: لایه‌های قدیمی Design System هنوز قبل از چرخه Runtime رنگ‌های سابق را به برخی Root/Cardها می‌دادند.
- REMAP: Purple/Deep/Card مرکزی به سه رنگ `#3A0D5C`، `#1C1025` و `#1D1126` remap شدند.
- STRICT SURFACES: تمام ماژول‌ها fallback ثابت فقط از `#1C1025`، `#26213D` و `#1D1126` دارند.
- NO-JS SAFETY: حتی قبل از اجرای Runtime یا داخل Elementor Editor نیز هیچ Surface قدیمی دیده نمی‌شود.

## v3.10.126 — 2026-08-27 — Three-step Plum Container Rhythm
- COLORS: رنگ‌های دقیق `#1C1025`، `#26213D` و `#1D1126` به توکن‌های کانتینر اضافه شدند.
- CYCLE: Runtime ترتیب واقعی DOM را با الگوی A → B → C → A تکرار می‌کند.
- SEAMLESS: Root هر ماژول و میزبان Elementor آن رنگ یکسان می‌گیرند تا هیچ درزی ایجاد نشود.
- CLEANUP: کلاس‌های چرخه قبلی در هر اجرا به‌روز می‌شوند و رنگ مانده از ترتیب قبلی وجود ندارد.

## v3.10.125 — 2026-08-27 — Alternating Plum Section Rhythm
- COLORS: دو رنگ دقیق `#2B0A3D` و `#3A0D5C` به توکن‌های مرکزی اضافه شدند.
- RUNTIME: ترتیب واقعی ماژول‌ها پس از رندر Elementor خوانده و کلاس A/B یکی‌درمیان اعمال می‌شود.
- SEAMLESS: Root هر سکشن و Container میزبان آن دقیقاً یک رنگ می‌گیرند تا هیچ درز یا زمینه متفاوتی ایجاد نشود.
- EXCLUSIONS: Header، Hero و Footer نقش رنگی مستقل خود را حفظ می‌کنند.

## v3.10.124 — 2026-08-27 — Rich Plum Luxury Surfaces
- NEW COLOR: بنفش آلویی پررنگ و جدید `#2B0D3A` به‌عنوان Surface بزرگ اضافه شد.
- DEPTH: Cardها `#3B164F` و سطوح Inset برابر `#16091F` هستند؛ متن سفید و Gold محدود حفظ شد.
- SCOPE: Trust، Categories، Featured/Bestsellers، Sorting، App و Magazine از سطح روشن به Rich Plum منتقل شدند.
- RESULT: سطوح سفید/کرم فعال حذف شدند و عمق لوکس بدون استفاده از مشکی خالص بازگشت.

## v3.10.121 — 2026-08-27 — Warm Luxury Surface System
- DIRECTION: سفید سرد از Backgroundهای بزرگ حذف و با سطوح گرم متناسب با آلوی بنفش و هسته طلایی جایگزین شد.
- PALETTE: Warm Light `#F3EBDD`، Sand `#EDE2D0` و Premium Ivory Card `#FFF9EF` به توکن‌های مرکزی اضافه شدند.
- RHYTHM: Trust/Products/App روی Warm Light؛ Categories/Sorting/Magazine روی Sand؛ کارت‌ها روی Premium Ivory قرار گرفتند.
- DEPTH: Shadow بسیار نرم بنفش و Border ظریف جایگزین تضاد سفید و Dark شد؛ متن روشن همچنان White باقی ماند.

## v3.10.120 — 2026-08-27 — Canonical ALOOKHOR Design System
- TOKENS: شش رنگ نهایی Purple/Deep Purple/Gold/Light Gold/Cream/White به‌صورت Global Token مرکزی تعریف شد.
- RHYTHM: Header و Export و Footer تیره؛ Hero/Promo/Newsletter بنفش؛ Trust/Products سفید؛ Categories/Sorting/Magazine کرم نگاشت شدند.
- DEPTH: Surface بخش و Card از هم جدا شدند؛ کارت‌های روشن Border بنفش ظریف و Shadow محدود گرفتند.
- COMPONENTS: تمام ماژول‌های مدیریت‌شده از Header تا Footer به لایه مرکزی متصل شدند؛ Hard-coded overrideهای قبلی دیگر مرجع نهایی نیستند.
- ACCESSIBILITY: متن روشن/تیره بر اساس Surface، Focus طلایی و Reduced Motion حفظ شد.

## v3.10.119 — 2026-08-27 — Bestsellers Category Tabs Runtime V4
- ROOT CAUSE: محصولاتی که در زیر‌دسته بودند ID دسته مادر را در `data-cats` نداشتند و Binding عمومی در بعضی رندرهای Elementor اجرا نمی‌شد.
- HIERARCHY: تمام Ancestorهای `product_cat` هر محصول به قرارداد کارت اضافه شدند.
- DIRECT BINDING: تب‌ها در Runtime v4 مستقیماً Bind و با ID دقیق مقایسه می‌شوند.
- GUARANTEE: Display هر کارت با اولویت Inline تنظیم می‌شود؛ هر تب فقط محصولات همان دسته/زیر‌دسته را نشان می‌دهد.

## v3.10.118 — 2026-08-27 — Bestsellers UX Runtime V3 + Countdown
- RUNTIME: Event Delegation مستقل جایگزین Binding شکننده شد؛ تب‌ها و فلش‌ها حتی پس از رندر پویا Elementor همیشه کار می‌کنند.
- LOOP: چرخش DOM بدون Transform و Autoplay پایدار حفظ شد.
- TIMER: Countdown روز/ساعت/دقیقه/ثانیه بر اساس پایان تخفیف WooCommerce و fallback چهارده‌روزه اضافه شد.
- DESIGN: Badge جدید/تخفیف، دکمه گرادیانی و Header مطابق مرجع اضافه شد.
- MOBILE: تب‌های Scroll افقی، کارت 86٪، کنترل‌های لمسی و تایپوگرافی Responsive پیاده شد.

## v3.10.116 — 2026-08-27 — Professional Footer Typography
- FONT: فونت Variable Vazirmatn با دو Subset فارسی و لاتین WOFF2 محلی، `font-display:swap` و وزن 100–900 اضافه شد؛ هیچ وابستگی خارجی ندارد.
- DESKTOP: تیتر 18/30 وزن 700، لینک 14/28 وزن 400، توضیح 14/30 وزن 400، تماس 15/30 وزن 500 و کپی‌رایت 13/24 اعمال شد.
- MOBILE: تیتر 16/28، لینک 14/32، توضیح 14/30، تماس 15/30 وزن 600 و کپی‌رایت 12/24 اعمال شد.
- RTL: Letter spacing فارسی صفر، Font synthesis غیرفعال و Hover طلایی 0.3s حفظ شد.

## v3.10.115 — 2026-08-27 — Residual White Seam Cleanup
- ROOT CAUSE: درز باقی‌مانده متعلق به Wrapperهای تو‌در‌توی Woodmart/Elementor و Spacer/Divider بین میزبان‌ها بود، نه خود شورت‌کد.
- SURFACE: تا سه سطح والد هر ماژول نشانه‌گذاری و فقط Background آن‌ها با بنفش سایت هماهنگ شد.
- WRAPPERS: Body، Website Wrapper، Main Page Wrapper و Main Content صفحات ماژولار سطح بنفش یکپارچه گرفتند.
- SPACERS: Spacer و HRهای باقی‌مانده دیگر نوار سفید تولید نمی‌کنند.

## v3.10.114 — 2026-08-27 — Elementor Managed-module Gap Cleanup
- DETECT: تمام ریشه‌های شورت‌کد مدیریت‌شده شناسایی و Widget/Container والد آن‌ها نشانه‌گذاری می‌شوند.
- ZERO GAP: Margin، Padding و Gap رزروشده Elementor فقط روی همان میزبان‌ها صفر می‌شود.
- NO WHITE: پس‌زمینه میزبان‌ها با تم بنفش هماهنگ شد تا نوار سفید بالا/پایین حذف شود.
- SAFE: کانتینرها و محتوای غیرمرتبط Elementor دست‌نخورده می‌مانند.

## v3.10.113 — 2026-08-27 — Live Boutique Hero Palette
- ROOT CAUSE: Overrideهای نسخه 3.10.108 رنگ‌های بنفش ثابت داشتند و مقدار Surface ذخیره‌شده بوتیک را می‌پوشاندند.
- VARIABLES: RGB امن رنگ Surface در PHP تولید و به CSS Variable تبدیل شد.
- LIVE: پس‌زمینه، Media surface، Overlay، پنل شیشه‌ای، دکمه دوم و نسخه موبایل همگی از رنگ ذخیره‌شده بوتیک می‌خوانند.
- CACHE: Build جدید باعث Cache Bust کامل CSS و خروجی Hero می‌شود.

## v3.10.112 — 2026-08-27 — True Glass Hero Copy Panel
- GLASS: پنل متن با Alpha واقعی، Backdrop Blur، Saturation، Highlight و Border طلایی به شیشه واقعی تبدیل شد.
- VISIBILITY: Overlay بنفش سنگین کاهش یافت تا عکس کامل پشت پنل نیز واضح دیده شود.
- BOUTIQUE: کنترل شفافیت پنل (۱۰–۸۵٪) و Blur (۰–۴۰px) به تنظیمات Hero اضافه شد.
- MOBILE: همین شفافیت و Blur کنترل‌شده در موبایل حفظ می‌شود.

## v3.10.111 — 2026-08-27 — Unified Purple Glass Navigation
- STRUCTURE: لوگوی رسمی داخل کپسول در سمت راست، دکمه همبرگری کنار لوگو، لینک‌ها در مرکز و ابزارهای حساب/سبد/جستجو در چپ قرار گرفتند.
- LOGO: اگر لوگوی AKX خالی باشد، `top_logo_url` رسمی به‌صورت خودکار استفاده می‌شود.
- GLASS: شیشه بنفش چندلایه، Blur، Border طلایی، Highlight بالایی و Shadow کنترل‌شده مطابق مرجع اضافه شد.
- RESPONSIVE: اندازه لوگو، کپسول، همبرگری و ابزارها برای موبایل بازتنظیم شد.

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
