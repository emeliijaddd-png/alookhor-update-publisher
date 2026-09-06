=== ALOOKHOR Control Center ===
Contributors: alookhor
Tags: control center, luxury, alookhor, admin, dashboard
Requires at least: 6.0
Tested up to: 7.0
Requires PHP: 8.0
Stable tag: 3.10.326
License: Private
License URI: https://alookhor.ir

کنترل سنتر لوکس و ماژولار آلوخور — مدیریت کامل سایت با آپدیت آنی بدون رفرش

== Description ==

**ALOOKHOR Control Center** پنل مدیریت لوکس بوتیک آلو بخارا است که تمام بخش‌های سایت شما (هدر، اسلایدر، سورت، محصولات، مشتریان VIP، مالی، آنالیتیکس) را در یک داشبورد Dark Glass + Gold مدیریت می‌کند.

*   **هدر حرفه‌ای با شورت‌کد:** هدر دو‌ردیفه Luxury با Top Bar، منوی شیشه‌ای، حساب کاربری و CTA عمده — فقط `[alookhor_portal_header]`
*   **جایگاه دسته‌بندی در Elementor:** بخش واقعی WooCommerce را با `[alookhor_managed_categories]` در هر محل دلخواه قرار دهید
*   **Hero چهاراسلایدی مدیریت‌شده:** تصویر Media Library، نوشته‌ها، ویژگی‌ها و CTAهای مستقل با `[alookhor_managed_hero]` و جایگزینی خودکار Slider قدیمی
*   **ویژگی‌های چهارکارته سایت:** `[alookhor_managed_features]` با جایگزینی خودکار Trust Bar، چهار کارت یک‌ردیفه و پالت Burgundy/Gold قابل مدیریت
*   **فهرست‌های خودکار WordPress:** فهرست اصلی از جایگاه Primary/Header و تمام فهرست‌ها داخل Hamburger حرفه‌ای فراخوانی می‌شوند
*   **آپدیت آنی (Hot-Swap):** هر تغییری بدون رفرش ذخیره و روی سایت اعمال می‌شود (AJAX + LocalStorage)
*   **سایدبار PRO فشرده:** ۶ دسته جمع‌شونده، بدون لیست طولانی، با جستجوی زنده
*   **حافظه پایدار:** تمام تنظیمات چت قبلی در `wp_options` ذخیره می‌شود (alookhor_cc_settings)
*   **Responsive 5 مرحله‌ای:** 320 تا 1920px بدون overflow
*   **سازگار:** ووکامرس، وودمارت پلاس، المنتور پرو، PHP 8.1.6

کنترل سنتر قبلاً به صورت استاتیک ساخته شده بود — اکنون به افزونه وردپرس تبدیل شد تا با زدن «ذخیره» مستقیماً روی وردپرس اعمال شود.

== Installation ==

1. نسخه‌های جدید فقط از کانال خصوصی `updates.alookhor.ir` منتشر می‌شوند.
2. در **ALOOKHOR Center → Update Center** نسخه موجود را بررسی و نصب کنید؛ افزونه را حذف یا Upload مجدد نکنید.
3. منوی **ALOOKHOR Center** و تمام تنظیمات فعلی پس از بروزرسانی حفظ می‌شوند.
4. برای هدر: المنتور → Header → المان Shortcode → `[alookhor_portal_header]`

== Frequently Asked Questions ==

= آیا هدر قبلی من پاک می‌شود؟ =
خیر. همین شورت‌کد `[alookhor_portal_header]` که قبلاً ساخته بودید حفظ شد — فقط حالا از کنترل سنتر مدیریت می‌شود.

= آپدیت آنی یعنی چه؟ =
وقتی در کنترل سنتر یک Toggle می‌زنید یا لوگو را عوض می‌کنید، با AJAX بدون رفرش در `wp_options` ذخیره و بلافاصله روی فرانت اعمال می‌شود.

= تنظیمات قبلی کجا بود؟ =
در `config/site.json` و `wp_options: alookhor_cc_settings` — همان حافظه واقعی که در چت قبلی ویرایش می‌شد.

== Changelog ==

= 3.10.326 =
* Mobile product page rebuilt per the two owner mockups (top + bottom): edge-to-edge image with thumb strip, breadcrumb, panel (badge, title, rating + wishlist, 4 features in one row, price, weight chips, qty pill + gold cart on one line, delivery line), guarantees 2x2, banner, tabs bar, description, suggested products 2-col, curated 2-col, usage, FAQ 1-col, reviews stacked, newsletter.
* Every rule lives inside @media(max-width:1279px) (+ 640px / 641-1279px bands): desktop >=1280 is pixel-identical to 3.10.310 (verified 0 differing pixels at 1440x4186, including the 3.10.310 buy-box tweaks).
* Tablet 641-1279px: same stacked order, framed 16/10 gallery, guarantees 4-col, 3-col product grids.
* JS: quantity +/- buttons now work (markup uses data-q="+"/"-", parseInt returned NaN); "مشاهده بیشتر" button (data-desc-toggle) now expands the description; on <=1279px the usage/FAQ/reviews tabs scroll to their always-visible sections (desktop tab behaviour unchanged).

= 3.10.252 =
* Fix slider title visibility: عنوان گزیده‌ای از بهترین آلو بخارایی در اسکرین‌شات image-1.png تیره و نامرئی بود — حالا #fbf3e2 کرم روشن + #f7b32b طلایی با !important + opacity:1 visibility:visible
* Ensure tab content visible: کاربر گفت چرا توضیحات و نظرات و.. حذف شد و چیزی مشاهده نمیکنم — تب‌ها محتوا را hide/show می‌کنند per درخواست، اما تضمین شد .pdp-pane .below-section display:block + sliders خارج تب‌ها همیشه visible — محتوا حذف نشده، داخل تب‌هاست
* CSS v3.10.252 MOCKUP PDP — فیکس رنگ عناوین اسلایدر، highlight-card کرم/لاوندری visible، تضمین نمایش tab panes — حفظ تب‌ها و مشاهده بیشتر 3.10.247 + تک فوتر و وسط‌چین 3.10.246



= 3.10.245 =
* Rating one row: ستاره و علاقه‌مندی دقیقا در یک ردیف کنار هم (flex-nowrap) + اشتراک‌گذاری ردیف جدا — Desktop و Mobile بدون overflow
* Price per ref image-2: قیمت وسط‌چین، قرص تخفیف #e42a68، قیمت خط‌خورده 12px و قیمت طلایی 28px luminous gold وسط‌چین
* Qty right of cart: [تعداد: + کنترل] سمت راست سبد خرید، سبد max-w 200px h-10 text 13px کوچک‌تر ولی خوانا
* Compact: product-panel gap-6→gap-4، فاصله ردیف‌ها کمتر، لوکس حفظ
* Guarantees above banner: ترتیب gallery → guarantees → banner، حذف -mt-8 و pb-24، ضمانت بالای بنر خوشمزه زندگی کن
* CSS v3.10.245 MOCKUP PDP — شامل MOCKUP PDP برای CI

= 3.10.244 =
* Guarantees bigger on banner per photo: guarantee-item text-xs font-black px-4 py-4 h-6 w-6 min-height 76px، slot -mt-8 روی بنر خوشمزه زندگی کن، banner-slot pb-24

= 3.10.225 =
* Exact React port — product page now 100% matches the 5 reference screenshots: plum canvas #170a20 + 3 radials, flat panel gradient plum-700/800, gallery with gold gradient ribbon -3deg + Nastaliq caption + counter + arrows + fullscreen, vertical thumb rail 96px desktop / horizontal mobile, banner with gradient overlay, pricebox with berry badge + gold price with drop-shadow, weight chips with gold ring, qty stepper, gold CTA gradient, mint stock pulse, 3 guarantees, below sections: about story, specs, highlight slider 4, suggested products (Samsung demo filtered out), dark FAQ accordion (white bug fixed), reviews glass slider, newsletter. Assets: bowl, single, sack, pack, banner, about, assortment, newsletter images + full React CSS (63KB) as frontend-product-react.css. JS rewritten for new classes.

= 3.10.224 =
* Design delta 2: page canvas now uses the exact app-bg from the owner design (#170a20 + three radial glows — was hidden behind the old royal gradient), gold tone corrected to #f7b32b/#ffd37a, gallery ribbon changed from berry to the gold gradient with -3deg tilt exactly like the reference. Everything already deployed; this makes the design visibly different.

= 3.10.223 =
* DESIGN CONVERSION (Phase A, approved scope): product page adopts the owner's React design exactly — dark plum canvas (radial gradient bg), flat plum-gradient panel, vertical gallery thumb rail on desktop, berry discount badge, gold gradient CTA, mint stock pulse, Noto Nastaliq gallery caption, unified dark below-section surfaces. Header and footer untouched; all class names and behavior preserved.

= 3.10.222 =
* Responsive: dedicated tablet / small-laptop band (768-1100px) — PDP buy box, thumbs, stats and managed grids stop overflowing between mobile and laptop; plus global horizontal-overflow armor (overflow-x:clip, sticky-safe) and table/image containment. Loaded as the last stylesheet so nothing has to be edited destructively.

= 3.10.221 =
* Fix: mega-menu promo card logo pointed to the old migration path /uploads/2026/06/LOGO2.png (404) — now the real /uploads/2026/08/LOGO2.png. No layout change; only the broken image request is fixed.

= 3.10.220 =
* SEO SPRINT 1 (Technical): single Product schema on PDP (WooCommerce core schema dequeued there), richer factual schema (description, itemCondition, URL, AggregateRating only when REAL reviews exist); Organization+WebSite(SearchAction) fallback schema when Yoast is absent; automatic alt text for product images; lightweight 404 logging shown in the SEO Cleanup tool with a purge button; technical probes (indexability, permalinks, Woo pages, Yoast presence).

= 3.10.219 =
* Security: the SEO Cleanup tool gains a read-only Server Intrusion Monitor — it audits .htaccess for injected redirect rules, flags changed core files, lists mu-plugins and any PHP files inside uploads. Use it BEFORE manual deletion so evidence stays intact. Nothing here deletes anything.

= 3.10.218 =
* SEO SPRINT 0 (Emergency): old spam doorway URLs /item/<id> now return 410 Gone; the admin gets a new "SEO Cleanup" tool (acc-admin → پاک‌سازی SEO) that finds poisoned sitemap*.xml / robots.txt files on the server, deletes only /item/-signed files, lists demo template products (soft-trash, reversible) and products without images. Cleanup requires your confirmation in admin; nothing is deleted silently.

= 3.10.217 =
* Fix: toman prices + discount badge now render with Persian digits and the Persian thousand separator (۱٬۳۰۰ تومان / ٪۸۹) exactly like the mockup; no logic change.

= 3.10.216 =
* Fix: toman display now triggers for the IRR store currency as well (rial ÷10 → toman label); IRT stores stay as-is (×1). Weights-hide and qty alignment from 3.10.214 carried over.

= 3.10.215 =
* Fix: release-test product_endpoint assertion no longer requires the weight-chooser text (that section is now intentionally hidden for products without weight options); no visual change.

= 3.10.214 =
* Fix (owner live review): price now displays in toman on the product page (site unit is rial; value ÷10, only for simple products); empty single "standard package" weight chip hidden when the product has no weight options; quantity label vs stepper alignment fixed; price-box rhythm tightened to the mockup; aria price text guaranteed invisible.

= 3.10.213 =
* Fix: release-test text assertions aligned to the new mockup markup (product-endpoint + authenticated-PDP checks read the new price label); no visual change.

= 3.10.212 =
* New: single-product page fully redesigned to the owner mockup (panel right / gallery left, vertical thumbnails, gold ribbon, handwritten tagline, banner under gallery, rating + features + price box + weight chips + qty + gold CTA + guarantees; toast notifications, fullscreen gallery, Persian digits). Header/footer unchanged.

= 3.10.211 =
* Fix: corrected 210 overshoot — frames anchored to the sticky menu line so no strip appears at load or scroll, while the photo/texts keep their exact positions; mobile restored to the proven layout.

= 3.10.210 =
* Fix: the leftover strip (white, later purple) between the menu and the product boxes is gone for good — frames now anchor to the sticky main menu bar itself, so no gap appears at load or while scrolling; one continuous page background.

= 3.10.209 =
* Tweak: photo box and info card frames now start flush under the main menu (bigger backdrops); the image, texts and buttons keep their exact position.

= 3.10.208 =
* Fix: white strip above the product hero — body and theme wrappers on the product page now painted the same deep purple as the page background.

= 3.10.207 =
* Fix: live-measured — theme pulls product content under the in-flow header; padding-top now calibrated (152px desktop / 90px mobile) so the photo & info box clear the main menu with a visible gap.

= 3.10.206 =
* Tweak: restored clear breathing room under the main menu — 32px desktop / 20px mobile (owner feedback; content was flush against the header).
* Kept: hidden breadcrumbs, dominant product photo (94/95%), aligned desktop columns, 64px mobile sticky bar.

= 3.10.205 =
* Fix: desktop gallery sticky offset removed — hero columns now perfectly aligned top & bottom (browser-render verified).
* Fix: mobile sticky bar selectors corrected (element sits outside plugin section) — height now exactly 64px instead of 97px.
* Fix: sticky price single-line with ellipsis; sticky CTA 46px.

= 3.10.204 =

* اصلاح: برگشت برچسب «قیمت نهایی» بالای قیمت در هیروی جدید (الزام بند ۲۵ بریف و چک انتشار).

= 3.10.194 =

* بهبود: بازسازی بخش هیرو صفحه محصول (گالری و پنل خرید) مطابق کد مرجع مالک — صحنهٔ شیشه‌ای ۶۵۰px با لبهٔ نئونی، درخشش و انعکاس محصول، فلش و شمارندهٔ گالری، پنل خرید با هایلایت‌های آیکونی و نوار قیمت جدید؛ رنگ‌بندی بنفش.

= 3.10.193 =

* بهبود: کل صفحهٔ محصول به تم بنفش سلطنتی شیشه‌ای با جزئیات طلایی تبدیل شد (مطابق موکاپ)؛ هدر و فوتر سایت حفظ شد.

= 3.10.192 =

* بهبود: مهر نسخه در ابتدای سورس صفحه محصول (<!-- ALOOKHOR-PDP v... -->) برای تشخیص فوری نسخهٔ زنده از طریق View Source.

= 3.10.191 =

* بهبود: تطبیق کامل صفحه محصول با موکاپ لوکس — نشان شیشه‌ای محصول، زیرنویس گالری، CTA طلایی تخت، کاروسل ۴ محصولی و جزئیات ریز؛ هدر و فوتر سایت حفظ شد.

= 3.10.190 =

* بهبود: حذف نوار تیرهٔ اضافهٔ بالای صفحه محصول؛ به‌جای هدر تم، همان منوی اصلی سایت (هدر پورتال) و فوتر مدیریت‌شده در صفحهٔ محصول رندر می‌شوند.

= 3.10.189 =

* اصلاح: فرم ثبت دیدگاه صفحه محصول با comment_form هسته (بدون قالب دیدگاه تم) رندر می‌شود؛ خطای احتمالی ۵۰۰ صفحه در رندر مستقیم رفع و گزارش تست مقاوم شد.

= 3.10.188 =

* اصلاح: صفحه محصول مستقیماً در template_redirect رندر و خاتمه می‌یابد؛ صفحه قدیمی قالب، تکرار محتوا و چسبیدن صفحه جدید بعد از فوتر حذف شد. چک CI حالا وجود مارک‌آپ قالب قدیمی را هم رد می‌کند.

= 3.10.187 =

* بهبود: آزمون تشخیصی CI — صفحه محصول علاوه بر UA ربات، با UA مرورگر دسکتاپ و موبایل هم گرفته و نتیجه رندر در گزارش انتشار ثبت می‌شود.

= 3.10.186 =

* اصلاح: بعد از آپدیت، کش همه افزونه‌های کش صفحه رایج (WP Rocket و…) هم پاک می‌شود تا HTML جدید برای همه بازدیدکنندگان دیده شود.

= 3.10.185 =

* بهبود: صفحه محصول با رندر تضمینی دو‌مسیری (قالب اختصاصی + هوک ووکامرس) و طراحی Glass لوکس جدید؛ چک CI احراز‌شده برای رندر واقعی صفحه افزوده شد.

= 3.10.184 =

* بهبود: بازطراحی کامل صفحه تکی محصول (PDP) با استاندارد لوکس آلوخور — گالری، پنل خرید، مشخصات، دیدگاه‌ها، محصولات مشابه و همراه؛ داده‌ها مستقیم از ووکامرس.

= 3.10.183 =

* منوی جدید «مدیریت برگه‌ها» در ALOOKHOR Center: ویرایش متن‌ها (عنوان‌ها، معرفی، پرسش‌های پرتکرار، داستان، آمار، سفر محصول، ارزش‌ها، همکاری، امضا) و تصاویر (داستان و چهار کارت سفر) برگه‌های تماس با ما و درباره ما.
* انتخاب عکس از رسانه وردپرس، بازنشانی به پیش‌فرض و ذخیره واقعی در دیتابیس؛ endpoint پایش /pages و چک انتشار pages_endpoint اضافه شد.

= 3.10.182 =

* نوار مدیریت وردپرس (نوار تقریباً مشکی بالای صفحه در موبایل و دسکتاپ برای کاربر واردشده) در نمای سایت مخفی شد؛ پیشخوان از wp-admin کامل در دسترس است.

= 3.10.181 =

* کارت‌های «از باغ تا خانه شما» در صفحه درباره ما به‌جای پس‌زمینه بنفش، عکس مرتبط خود را دارند (آلو بخارا، مغزبار، برگه میوه، صادرات)؛ آیکن‌ها، اعداد و متن‌ها حفظ و با لایه تیره گرادیانی خوانا شدند.

= 3.10.180 =

* آیکن بستن منوی موبایل با X تمام‌CSS (دو میله گرادیان طلایی نورانی) بازطراحی شد و SVG شکننده آن حذف شد؛ دیگر توسط قانون‌های قالب خراب نمی‌شود.

= 3.10.179 =

* عرض منوی کناری موبایل از ۹۰vw/۳۶۰px به حداکثر ۳۰۰px (۸۰vw) کاهش یافت.
* دکمه تمام‌عرض طلایی «خروج از حساب» برای کاربران واردشده و «ورود به حساب» برای مهمانان با آیکن SVG نورانی به پایین دراور اضافه شد.

= 3.10.178 =

* خطوط خود آیکن‌های کارت‌های تماس که با پیش‌فرض مشکی رندر می‌شدند صریحاً طلایی روشن با درخشش شدند (fill:none + stroke طلایی).
* آیکن واتساپ، سپر حریم خصوصی و چیپ‌های بالای صفحه نیز طلایی یکدست شدند.

= 3.10.177 =

* همه آیکن‌های صفحه تماس طلایی یکدست و نورانی شدند: درخشش تنفسی، هاله دو لایه، حلقه پالس طلایی و شنا آرام؛ رنگ‌های چندرنگ حذف شدند.

= 3.10.176 =

* آیکن‌های کارت‌های تماس و ساعات کاری رنگ اختصاصی (طلایی، سبز واتساپ، آبی ایمیل، مرجانی نشانی، بنفش ساعت، سبزتی‌نایی فعالیت) با انیمیشن شنا آرام، پالس حلقه و درخشش هاور گرفتند.
* بخش نقشه گوگل با قاب لوکس طلایی، بارگذاری تنبل و دکمه «مسیریابی مستقیم در گوگل‌مپ» برای موقعیت خور نیشابور اضافه شد.

= 3.10.175 =

* مسیر درخواست در ریدایرکت درباره ما پیش از مقایسه با rawurldecode رمزگشایی می‌شود؛ /درباره-ما/ حالا ۳۰۱ به /about/ می‌رود.

= 3.10.174 =

* نشانی فارسی قدیمی «درباره-ما» در تست انتشار به‌صورت percent-encoded مستقیم ساخته می‌شود.

= 3.10.173 =

* چک انتشار about_schema به نسخه ۲ مهاجرت درباره ما به‌روز شد و چک‌های زنده مسیرهای درباره ما در برابر خطاهای شبکه مقاوم شدند.

= 3.10.172 =

* گزارش JSON تست انتشار فشرده شد تا از سقف ۱۲هزار کاراکتری خوانده‌شده در workflow عبور نکند و نوشتن شاخه وضعیت انتشار (publisher-status) سلامت بماند.

= 3.10.171 =

* اسلاگ صفحه «درباره ما» قطعیاً روی about (هدف منوی اصلی) تنظیم می‌شود؛ صفحه قفل‌کننده اسلاگ با پشتیبان نسخه‌دار آزاد و حذف می‌شود.
* هر دو مسیر قدیمی (about و درباره-ما) با گارد ضدحلقه به نشانی canonical هدایت می‌شوند؛ ریدایرکت به خودش هرگز رخ نمی‌دهد.

= 3.10.170 =

* برگه لوکس «درباره ما» با شورت‌کد [alookhor_about_page] ساخته شد: داستان برند، آمار، مسیر «از باغ تا خانه شما»، ارزش‌ها و بخش همکاری با CTA.
* منوی «درباره ما» که به /about/ و صفحه ۴۰۴ می‌رفت اصلاح شد؛ برگه انتشار‌یافته با اسلاگ about تضمین می‌شود و صفحات دموی هم‌نام با پشتیبان برگشت‌پذیر به ماژول مهاجرت می‌کنند.
* عنوان و متای سئو/OG اختصاصی، انیمیشن ورود سبک با IntersectionObserver و پشتیبانی prefers-reduced-motion اضافه شد.
* Endpoint عمومی /wp-json/alookhor-cc/v1/about با HTML رندرشده برای پایش انتشار اضافه شد.

= 3.10.169 =

* برگه انتشار‌یافته واقعی با اسلاگ contact ساخته شد تا مسیر قدیمی هرگز ۴۰۴ یا ژاپنی سرو نشود (برگه قفل‌شده روی اسلاگ با پشتیبان نسخه‌دار حذف می‌شود).
* ریدایرکت ۳۰۱ دائمی به init زودهنگام منتقل شد تا قبل از هر short-circuit تم/۴۰۴ اجرا شود؛ template_redirect به‌عنوان پشتیبان ماند.
* کش‌های شناخته‌شده (Rocket، W3TC، WP Super Cache، SiteGround، LiteSpeed) یک‌بار در پایان مهاجرت پاکسازی شدند.

= 3.10.168 =

* بازطراحی کامل حرفه‌ای صفحه تماس با ما (نسخه ۲): کارت‌های تماس سریع، پنل اطلاعات، فرم با اعتبارسنجی زنده و پرسش‌های پرتکرار.
* صفحه ژاپنی قدیمی /contact/ با پشتیبان‌گذاری برگشت‌پذیر به ماژول فارسی مهاجرت و مسیر آن ۳۰۱ به صفحه رسمی هدایت می‌شود.
* عنوان «دمو کلاسیک» باقی‌مانده از دمو قالب به نام برند «آلوخور» اصلاح و عنوان و متای سئوی صفحه تماس اضافه شد.
* رنگ طلایی صفحه به‌صورت زنده از تنظیمات هدر مالک خوانده می‌شود.
* Endpoint استاندارد /wp-json/alookhor-cc/v1/contact برای پایش انتشار اضافه شد.

= 3.10.167 =
* برگه حرفه‌ای تماس با فرم امن و اتصال خودکار تمام لینک‌های تماس

= 3.10.167 =
* حذف کارت شناور کمپین در همه نمایشگرها و انتقال متن به نوار Glass پایین

= 3.10.167 =
* تبدیل کارت متن کمپین موبایل به نوار شیشه‌ای باریک تمام‌عرض پایین اسلاید

= 3.10.167 =
* بازطراحی موبایل کمپین با قاب نورانی، Glass، Swipe و شش بنر

= 3.10.167 =
* انتقال افقی سه‌بعدی Hero با Perspective و Loop، بدون افزودن React سنگین

= 3.10.167 =
* طراحی Portrait استانداردها با 3/2 ستون، آمار 2×2 و کارت اعتماد موبایل

= 3.10.167 =
* بازطراحی کامل استانداردهای بین‌المللی با Glass، آمار آیکن‌دار و Responsive

= 3.10.167 =
* بازطراحی کامل مرکز سورت با اسلایدر، Glass، آمار، CTA و Mobile UX

= 3.10.137 =
* افزودن زیرخط طلایی متحرک Hover/Focus به منوی اصلی

= 3.10.167 =
* تک‌خطی‌شدن توضیح دسکتاپ و حذف نقاط تزئینی موبایل «چرا آلوخور»

= 3.10.158 =
* بازطراحی مستقل موبایل «چرا آلوخور» مطابق مرجع Portrait

= 3.10.157 =
* افزودن گرادینت بنفش چندلایه و لوکس به تمام سطوح «چرا آلوخور»

= 3.10.156 =
* بازطراحی صفر تا صد «چرا آلوخور» با تصویر بزرگ، Badge، کارت‌های شماره‌دار و آمار آیکن‌دار

= 3.10.155 =
* حذف کامل Gradient، Shade و Filter بنفش از تصویر Hero در دسکتاپ و موبایل

= 3.10.154 =
* بازگردانی عنوان «دسته‌بندی محصولات» و کاهش اندازه فونت دسکتاپ و موبایل

= 3.10.153 =
* Kicker انگلیسی و عنوان بزرگ سفید نورانی «محصولات منتخب آلوخور»

= 3.10.152 =
* اصلاح ترتیب هدر موبایل: لوگو و همبرگری سمت راست، ابزارها سمت چپ

= 3.10.151 =
* حذف Gradient بنفش روی عکس موبایل و مرکزچین‌کردن متن کارت Hero

= 3.10.150 =
* کارت شیشه‌ای کوچک موبایل، حذف ویژگی‌های Hero و اصلاح جهت فلش‌ها

= 3.10.149 =
* فاز دوم Mobile UX: بازطراحی مستقل Hero بدون Overflow و نوار خالی

= 3.10.148 =
* فاز اول Mobile UX: هدر بدون Overflow، Touch target استاندارد و Drawer کاملاً دسترس‌پذیر

= 3.10.147 =
* بزرگ‌تر و نورانی‌شدن «دسته‌بندی محصولات» و کوچک‌ترشدن عنوان اصلی

= 3.10.146 =
* افزودن دو فلش جداکننده طلایی و پشتیبانی توضیحات چندخطی در Hero

= 3.10.145 =
* بازطراحی چیدمان و تایپوگرافی متن اسلایدر Hero مطابق نمونه Editorial فارسی

= 3.10.144 =
* هم‌ترازسازی دقیق گزینه تماس با ما و تمام لینک‌های منوی اصلی

= 3.10.143 =
* قرارگیری بخش تخفیفات/خبرنامه داخل کادر لوکس هم‌اندازه بنر اپلیکیشن

= 3.10.142 =
* اصلاح جهت شماره‌های واتساپ و جایگزینی حرف آ با لوگوی رسمی در بنر صادراتی

= 3.10.141 =
* رفع نمایش خراب `[alookhor_international_standards]` در Elementor با CSS سبک Editor

= 3.10.140 =
* افزودن `[alookhor_international_standards]`` با شش کارت شیشه‌ای و آمار متحرک

= 3.10.139 =
* تکمیل تمام متن‌ها، آمار، رنگ‌ها و ترکیب بصری «چرا آلوخور» مطابق مرجع

= 3.10.136 =
* ارتقای «چرا آلوخور» با Glass، Shine، Reveal و شمارنده انیمیشنی

= 3.10.134 =
* افزودن قاب باریک و نورانی طلایی دور کپسول شیشه‌ای منوی اصلی

= 3.10.133 =
* رفع خطای 500 ذخیره Elementor با حذف Inline CSS تکراری از درخواست‌های AJAX

= 3.10.132 =
* افزودن `[alookhor_why_alookhor]`` با چهار مزیت و آمار واقعی قابل مدیریت

= 3.10.131 =
* بازطراحی کامل `[alookhor_featured_products]` مطابق مجموعه منتخب لوکس مرجع

= 3.10.129 =
* حذف Override مرکزی و اعمال واقعی هر رنگ انتخابی از مدیریت بوتیک روی بخش مربوطه

= 3.10.128 =
* بازگردانی کارت‌های ویژگی از سفید به بنفش تیره با متن سفید و آیکن طلایی

= 3.10.127 =
* حذف قطعی رنگ‌های قدیمی و محدودسازی تمام Surfaceها به #1C1025، #26213D و #1D1126

= 3.10.126 =
* اجرای چرخه #1C1025، #26213D و #1D1126 روی کانتینرهای Homepage

= 3.10.125 =
* اجرای یکی‌درمیان #2B0A3D و #3A0D5C روی کانتینرهای ماژولار Homepage

= 3.10.124 =
* جایگزینی سطوح روشن با بنفش آلویی جدید #2B0D3A و کارت‌های #3B164F

= 3.10.121 =
* جایگزینی زمینه‌های سفید با سطوح گرم #F3EBDD و #EDE2D0 و کارت‌های #FFF9EF

= 3.10.120 =
* اجرای پالت مرکزی و ریتم روشن/تیره MASTER DESIGN DIRECTIVE روی تمام ماژول‌های Homepage

= 3.10.119 =
* رفع قطعی تب‌های پرفروش؛ هر تب فقط محصولات همان دسته و زیر‌دسته را نمایش می‌دهد

= 3.10.118 =
* رفع تب و حرکت پرفروش‌ها، افزودن Countdown و UX کامل موبایل مطابق مرجع

= 3.10.116 =
* تایپوگرافی حرفه‌ای فوتر با Vazirmatn WOFF2 محلی و اندازه‌های استاندارد Desktop/Mobile

= 3.10.115 =
* حذف آخرین درزهای سفید Wrapper، Spacer و Divider میان بخش‌های ماژولار

= 3.10.114 =
* حذف خودکار فاصله و نوار سفید کانتینرهای Elementor میزبان شورت‌کدها

= 3.10.113 =
* رفع رنگ ثابت Hero و اعمال واقعی رنگ‌های انتخابی مدیریت بوتیک روی سایت

= 3.10.112 =
* تبدیل پنل Hero به شیشه واقعی و افزودن کنترل شفافیت و Blur در بوتیک

= 3.10.111 =
* بازطراحی منوی اصلی به کپسول شیشه‌ای یکپارچه با لوگوی رسمی و چیدمان صحیح همبرگری

= 3.10.109 =
* تغییر Hero به تم بنفش و نمایش کامل تصاویر بدون برش و Zoom

= 3.10.107 =
* ثبت `[alookhor_portal_footer]`` با جلوگیری از فوتر تکراری و نمایش صحیح Elementor

= 3.10.106 =
* افزودن لایک واقعی، ذخیره مطلب و تصاویر Blob هندسی متحرک به `[alookhor_magazine]`

= 3.10.105 =
* افزودن `[alookhor_magazine]`` با نوشته‌های واقعی وردپرس و کاروسل Loop

= 3.10.104 =
* افزودن `[alookhor_newsletter]`` با عضویت واقعی، حریم خصوصی و تنظیمات کامل بوتیک

= 3.10.103 =
* بازنویسی Loop پرفروش‌ها بدون Transform؛ حذف قطعی خروج کارت و فضای خالی

= 3.10.102 =
* حذف فضای سفید اطراف اسلایدر کمپین و افزودن پس‌زمینه بنفش تمام‌عرض قابل تنظیم

= 3.10.100 =
* رفع خروج کارت‌های پرفروش از کادر و افزودن Loop دوطرفه فلش و Autoplay

= 3.10.98 =
* رفع کامل `[alookhor_managed_categories]` برای بخش دسته‌بندی لوکس داخل Elementor

= 3.10.97 =
* قفل تک‌ردیفه پرفروش‌ها در برابر Override قالب و حذف قطعی ردیف دوم

= 3.10.96 =
* تبدیل پرفروش‌ها به اسلایدر تک‌ردیفه با فلش و Autoplay؛ حذف کامل ردیف دوم

= 3.10.95 =
* رفع خروجی خالی `[alookhor_bestselling_products]` و جلوگیری از Override توسط افزونه قدیمی

= 3.10.94 =
* افزودن `[alookhor_bestselling_products]` با تب دسته‌ها و مدیریت کامل بوتیک

= 3.10.93 =
* بازیابی `[alookhor_campaign_slider]` با ۶ کمپین و تنظیمات کامل بوتیک

= 3.10.92 =
* تثبیت انتشار محصولات منتخب و سازگاری تست ویژگی‌ها با شورت‌کد مستقیم Elementor

= 3.10.90 =
* بازیابی `[alookhor_featured_products]` با محصولات واقعی ووکامرس و تنظیمات کامل بوتیک

= 3.10.89 =
* جایگزینی نمادهای نامناسب با SVGهای استاندارد بازار، مایکت، Apple و More

= 3.10.88 =
* فعال‌سازی `[alookhor_app_banner]` و مدیریت کامل لینک‌ها، متن و رنگ‌ها از بوتیک

= 3.10.87 =
* بازطراحی `[alookhor_managed_features]` به نوار مشکی/طلایی لوکس با آیکن‌ها و افکت‌های متحرک

= 3.10.86 =
* پس‌زمینه بنر صادراتی به لبه‌های چپ و راست صفحه چسبید و فضای سفید حذف شد

= 3.10.85 =
* مدیریت کامل `[alookhor_export_banner]` داخل بوتیک: تصویر، لوگو، متن، واتساپ، رنگ، شفافیت و Blur

= 3.10.84 =
* پس‌زمینه مرکز سورت تمام‌عرض و محتوای داخلی در کانتینر ۱۳۸۰px وسط‌چین شد

= 3.10.83 =
* افزودن محصولات قابل عرضه و چهار کارت مزیت با آیکن‌های متحرک و تنظیم کامل از بوتیک

= 3.10.82 =
* حذف آمار ظرفیت و ساده‌سازی خروجی به متن‌های قابل ویرایش، دکمه و ۶ تصویر
* رفع لود استایل در Elementor و قرارگیری تصاویر در سمت راست

= 3.10.80 =
* شورت‌کد `[alookhor_sort_center]` با گالری ۶ تصویری و مدیریت کامل از بوتیک اضافه شد
* متن، آمار، CTA، رنگ، Autoplay، فلش، نقاط و Responsive قابل تنظیم است

= 3.10.79 =
* تنها شورت‌کد اسلایدر `[alookhor_managed_hero]` است و تمام تنظیمات آن از مدیریت بوتیک انجام می‌شود
* `[alookhor_vip_slider]` قدیمی خنثی شد تا تکرارهای موجود اسلایدر اضافی نسازند

= 3.10.78 =
* آخرین نوار سفید باریک حذف شد و Hero دقیقاً به Topbar چسبید

= 3.10.77 =
* جابه‌جایی اولیه اسلایدر برای خنثی‌سازی فاصله قالب

= 3.10.76 =
* اسلایدر از زیر کپسول شیشه‌ای منو شروع می‌شود

= 3.10.75 =
* هاله و سایه تمام‌عرض منوی Sticky حذف شد

= 3.10.74 =
* پس‌زمینه رنگی سراسری حذف و افکت شیشه‌ای فقط روی خود کپسول منو اعمال شد

= 3.10.73 =
* کنترل شیشه‌ای و چهارده کنترل رنگ برای تمام اجزای هدر، کپسول و مگامنو

= 3.10.72 =
* هدر کاملاً به بالای صفحه چسبید — فاصله سفید بالای هدر حذف شد
* پس‌زمینه Body همرنگ هدر شد تا هیچ درز سفیدی دیده نشود

= 3.10.71 =
* نوار دوم (منوی اصلی): محتوا دوباره داخل کانتینر وسط‌چین (حداکثر ۱۳۸۰px) — دیگر تمام‌عرض نیست؛ پس‌زمینه و چسبندگی همان می‌ماند
* نوار اول (Topbar): بدون هیچ تغییری — همان تمام‌عرض با همان فونت‌ها
* متن‌های منوی اصلی بزرگ‌تر و خواناتر: لینک‌ها ۱۳→۱۵px با وزن ۶۰۰، دکمه منو ۱۴px، مگامنو ۱۴.۵/۱۶.۵px


= 3.10.70 =
* ریشه‌ی واقعی «تغییر نکردن شورت‌کد»: یک کپی Static قدیمی از هدر (HTML + CSS اینلاین با سقف ۱۳۸۰px و فونت‌های ریز و id تکراری akx-header) داخل HTML خود صفحه جای‌گذاری شده بود و استایل‌های قدیمی‌اش روی هدر واقعی غالب می‌شد
* کپی Static هدر و <style> های اینلاین قدیمی #akx-header از صفحه حذف می‌شوند (فقط هدر دارای نشان data-akx-live باقی می‌ماند)
* تمام سلکتورهای CSS هدر با پیشوند body ارتقای Specificity گرفتند تا همیشه بر استایل‌های اینلاین صفحه غالب شوند
* نشان تشخیصی data-akx-ver روی هدر واقعی اضافه شد


= 3.10.69 =
* حذف هدر تکراری خارجی (alookhor-categories-manager) از صفحه — علت دیده‌شدن «نوار بالایی غیر تمام‌عرض» با ظاهر قدیمی
* پاکسازی متن خام شورت‌کدهای ثبت‌نشده alookhor_* از صفحه
* فونت‌های هدر بزرگ‌تر شدند (منوی اصلی ۱۱→۱۳px، نوار بالایی ۱۱→۱۳px، مگامنو و دراور موبایل متناسب)
* فشرده‌سازی منو از عرض ۱۲۴۰px (به‌جای ۱۱۰۰px) برای جا شدن فونت بزرگ‌تر
* پاکسازی خودکار کش صفحه (LiteSpeed/W3TC/Object Cache) بعد از هر آپدیت افزونه


= 3.10.68 =
* هدر تمام‌عرض شد — سقف ۱۳۸۰px محتوای هدر برداشته شد (پس‌زمینه و محتوا هر دو لبه‌به‌لبه)
* نوار دوم (Mainbar کپسول منو) چسبان شد — با اسکرول به بالای صفحه می‌چسبد، Topbar طبیعی خارج می‌شود و بدون پرش محتوا (Spacer پویا)
* سازگار با نوار مدیریت وردپرس (admin-bar) و حالت Reduced Motion


= 3.10.67 =
* رفع خطای ReferenceError در ماژول مدیریت بوتیک: مقدار پیش‌فرض email به اشتباه کد PHP (sanitize_email(get_option(...))) در JS بود و کل ماژول را هنگام لود می‌شکست
* بدون هیچ تغییر دیگر — همان 3.10.66 با این فیکس بحرانی


= 3.10.66 =
* دکمه «ذخیره هدر» فرم ۱۴ فیلدی AKX داخل مدیریت بوتیک فعال شد (قبلاً به selector قدیمی وصل بود و ذخیره انجام نمی‌شد)
* پاسخ ذخیره تنظیمات اکنون کلیدهای AKX (enabled، logo، brand، whatsapp_number و …) را هم برمی‌گرداند تا تأیید ذخیره واقعی باشد
* زیرمنوی قدیمی «نوار بالای سایت و هدر» و صفحه جداگانه «هدر حرفه‌ای» حذف شدند — تنها مرجع: ALOOKHOR Center → مدیریت بوتیک → هدر
* فایل‌های مرده اسلایدر بنفش (که هیچ‌جا require نمی‌شدند) از بسته حذف شدند
* نسخه‌گذاری کش ماژول‌های JS به v3.10.66 ارتقا یافت تا بعد از آپدیت، فرم جدید لود شود

= 3.10.57 =
* حذف قطعی Header خارجی
* حفظ Portal Header واقعی با Logo و Menu اصلی و حذف shortcode خام
* Mobile فشرده و Responsive

= 3.10.56 =
* حذف Header تکراری و متن shortcode خام
* تطبیق Top Bar و Main Menu با image.png
* حفظ منوی WordPress و Drawer واقعی

= 3.10.55 =
* بازیابی Renderer کامل `[alookhor_portal_header]`
* Top Bar و Main Menu مطابق مرجع Burgundy/Gold
* حفظ منوی واقعی WordPress و Hamburger/Drawer
* حفظ Footer edge-to-edge و تمام بخش‌های 3.10.54

= 3.10.19 =
* Top Bar شیشه‌ای Burgundy/Gold با ترتیب پشتیبانی، پیام و تلفن مطابق مرجع
* ادغام بصری Node واقعی منوی WordPress داخل کپسول Desktop بدون Clone
* بازگشت همان Navigation به Sticky rail هنگام Scroll
* کپسول عریض‌تر، لوگوی جابه‌جاشده به چپ و حفظ Cart/Account/Hamburger
* Mobile دو‌ردیفه، بدون Navigation اضافه و با Hero underlap قبلی
* Migration محدود Palette و Chrome audit برای Glass، ترتیب، Geometry و Sticky

= 3.10.18 =
* اعمال Glass واقعی روی همان `.header-capsule` ردیف دوم
* حفظ Cart، Account، Logo، Hamburger، IDها و ترتیب فعلی
* پالت مستقل `#0D0510`، `#1C1024`، `rgba(33,20,38,.75)`، `#D49A2E`، `#E8B84A`، `#F5F3F0` و `#C8C2C9`
* کنترل Glass RGBA، Blur و رنگ‌ها از ماژول Header پنل اصلی
* حفظ Palette مستقل Top Bar و Navigation و تمام Geometry قبلی

= 3.10.17 =
* کاهش فاصله زنده Hero و ویژگی‌ها از 21.4px به حدود 7px
* اتصال نزدیک چهار کارت به Hero مطابق تصویر مرجع
* تغییر فقط Offset بخش؛ محتوا، Palette و Responsive چهارستونه بدون تغییر

= 3.10.16 =
* جایگزینی دقیق `.alookhor-trustbar-container` در همان Widget HTML المنتور
* چهار کارت ویژگی در یک ردیف Desktop و Mobile بدون Stack یا Overflow
* آیکون، عنوان و توضیح مستقل برای هر کارت در پنل اصلی ALOOKHOR
* پالت تأییدشده `#0D0510`، `#1C1024`، `rgba(33,20,38,.75)`، `#D49A2E`، `#E8B84A`، `#F5F3F0` و `#C8C2C9`
* REST no-store و Chrome audit برای تعداد، ترتیب، Palette، فاصله Hero و Geometry موبایل

= 3.10.15 =
* خروج کامل ناحیه نوشته baked بنر Legacy از کادر Desktop
* ماسک پایین برای پنهان‌کردن Badgeهای قدیمی و حفظ Dots مدیریت‌شده
* حفظ سوژه محصول در نیمه چپ بدون Mirror شدن لوگو و متن تصویر
* کنترل Chrome برای Transform مثبت و Focus مستقل Desktop/Mobile

= 3.10.14 =
* حذف فاصله Mobile و عبور واقعی Hero زیر کپسول شیشه‌ای Header
* ایزوله‌سازی کامل Arrowها در برابر Background/Appearance سفید Woodmart
* انتقال سوژه بنرهای قبلی به سمت چپ بدون Mirror شدن لوگو و نوشته تصویر
* سطح تیره‌تر سمت راست برای جداسازی قطعی نوشته‌های مدیریت‌شده از تصویر
* افزودن Geometry و Style check برای Arrowها به Chrome audit

= 3.10.13 =
* Hero چهاراسلایدی مدیریت‌شده با تصویر Media Library و نوشته‌های مستقل
* عنوان، Highlight، توضیح، چهار ویژگی و دو CTA برای هر اسلاید
* جایگزینی خودکار ریشه واقعی Slider قدیمی در همان جایگاه Elementor
* متن سمت راست، Black/Gold، Ken Burns و کنترل‌های Accessible
* داده مشترک Desktop/Mobile و هم‌پوشانی کنترل‌شده زیر Header شیشه‌ای Mobile
* REST no-store و ممیزی Chrome برای چهار اسلاید، تصویر، محتوا و Header

= 3.10.12 =
* تراز عمودی نهایی Logo Symbol در Desktop
* انتقال Scope‌شده 6px بدون تغییر Mobile
* الزام Pass هم‌زمان Desktop/Mobile visual audit

= 3.10.11 =
* مهار Symbol لوگوی Desktop داخل Capsule
* اندازه یکسان 50px در Desktop/Mobile
* الزام containment در Chrome visual audit

= 3.10.10 =
* افزودن SVG واقعی Account به Link متنی Legacy
* حفظ URL و رفتار ورود فعلی
* الزام Account icon در ممیزی Chrome Mobile

= 3.10.9 =
* لوگوی افقی بزرگ و شفاف در مرکز Mobile
* Account آیکنی بدون متن/Pill
* Cart واقعی در چپ و Hamburger ساده در راست
* Top Bar سه‌بخشی تلفن، پیام مرکزی و پشتیبانی
* ممیزی تصویری تطبیق اجزای مرجع

= 3.10.8 =
* حذف Offset واقعی 135px Desktop و 100px Mobile بالای سایت
* Sticky قطعی Navigation Desktop با Spacer ضد Layout Shift
* حذف لوگوی تکراری Top Bar
* مهار کامل لوگوی اصلی داخل کپسول
* Top Bar فشرده 34px در Mobile
* ممیزی تصویری Chrome واقعی در Pipeline

= 3.10.7 =
* حذف کامل Search از Header
* حذف ردیف اضافه و فضای خالی Mobile
* Hamburger راست، لوگو وسط، حساب و سبد چپ
* حفظ همان Drawer ID و Event اصلی
* Cart و Count واقعی WooCommerce
* حفظ Sticky Navigation فقط در Desktop

= 3.10.6 =
* حذف رنگ‌های Orange/Green تصویر مرجع از State هدر
* بازیابی پالت واقعی Black/Gold آلوخور
* بازیابی شماره صحیح 09159513173
* مهاجرت محدود و ثبت‌شده بدون تغییر سایر تنظیمات
* ممیزی خودکار Palette، Contact و Migration marker

= 3.10.5 =
* Top Bar و Header اصلی در جریان عادی صفحه و غیر Sticky
* Sticky فقط برای Navigation اصلی موجود WordPress
* انتقال بدون بازسازی DOM منو، Mega Menu و Drawer
* جلوگیری از Layout Shift با Stage ثابت و Marker صفرارتفاع
* Glass/Blur ظریف Black + Gold فقط هنگام Stuck
* لوگوی شفاف مشترک Desktop/Mobile با کنترل عرض مستقل
* جستجوی واقعی محصولات و تنظیمات کامل در مدیریت بوتیک

= 3.10.4 =
* مدیریت بوتیک به‌عنوان آیتم اصلی و صفحه پیش‌فرض پنل
* انتقال بخش‌های فروش و آزمایشی به پایین Navigation
* Workspace عریض برای فرم کامل ماژول انتخاب‌شده
* استفاده از کل عرض امن صفحه مدیریت WordPress
* نمایش AI Assistant و System Status فقط در Dashboard
* حفظ Sidebar و فرم‌های Responsive در Tablet و Mobile

= 3.10.3 =
* شورت‌کد اختصاصی Elementor: `[alookhor_managed_categories]`
* جلوگیری از خروجی تکراری هنگام استفاده از شورت‌کد مدیریت‌شده
* ایزوله‌سازی کامل فلش‌های Desktop در برابر Woodmart
* مخفی‌سازی هوشمند فلش و Pagination در Desktop تک‌صفحه
* راهنمای جایگاه Elementor داخل تنظیمات اصلی دسته‌بندی‌ها

= 3.10.2 =
* حذف کامل فلش‌های Carousel در موبایل
* خارج‌کردن Arrowها از Tab order و Accessibility tree موبایل
* Pagination افقی: Active pill طلایی + inactive dot خاکستری
* ایزوله‌سازی ابعاد Dotها در برابر CSS قالب Woodmart

= 3.10.1 =
* کاهش ارتفاع و اصلاح تناسب کارت موبایل
* Centered Peek متقارن بدون بریدگی چپ
* Carousel حلقه‌ای Infinite با Clone امن
* فلش‌های SVG Glass Gold حرفه‌ای
* Dotهای پویا با Active Pill طلایی
* کنترل عرض، Peek، ارتفاع، Gap و Radius موبایل در پنل

= 3.10.0 =
* فاز Desktop دسته‌بندی محصولات واقعی WooCommerce
* Carousel چهارکارته با فلش، Dot، Autoplay و Hover لوکس
* انتخاب دسته و Image/Description override در پنل اصلی
* جایگزینی خودکار section قدیمی بدون Elementor
* Mobile baseline ایمن؛ طراحی کامل موبایل در فاز بعد

= 3.9.2 =
* سامان‌دهی کامل فرم تنظیمات فوتر در پنل اصلی
* Grid استاندارد برای Label/Input/Select/Textarea و Media Picker
* چیدمان Responsive پنل بدون هم‌پوشانی یا متن‌های چسبیده
* انتقال Styles مشترک Quick Settings به Stylesheet اصلی Admin

= 3.9.1 =
* تطبیق ترتیب نوار خبرنامه Desktop با تصویر مرجع
* اجتماعی چپ، خبرنامه مرکز و تصویر محصول راست
* مجوزها چپ، پرداخت مرکز و Copyright راست
* حفظ کامل طراحی موبایل و تنظیمات 3.9.0

= 3.9.0 =
* فوتر حرفه‌ای Luxury مطابق تصاویر Desktop و Mobile
* اتصال لوگو، منو، تلفن، ایمیل، Home URL و سال به WordPress
* ماژول تنظیمات کامل فوتر داخل پنل اصلی ALOOKHOR
* جایگزینی خودکار فوتر Legacy بدون ویرایش Elementor
* خبرنامه داخلی Rate-limited و تنظیمات شبکه‌های اجتماعی/مجوزها
* Responsive واقعی 320 تا 1920px و حفظ نوار ابزار موبایل Woodmart

= 3.8.9 =
* شناسایی و همگام‌سازی تلفن plain-text در `topbar-contact-txt`
* شناسایی و همگام‌سازی ایمیل بدون نیاز به لینک `mailto`
* حفظ SVG و ساختار دکمه هنگام جایگزینی متن خرید عمده
* آزمون Selectorها با DOM واقعی استخراج‌شده از Production

= 3.8.8 =
* حذف نمایش لحظه‌ای رنگ‌ها و محتوای قدیمی هنگام بارگذاری Top Bar
* شروع خواندن State تازه REST از head و پیش از Paint هدر Legacy
* Reveal فقط پس از اعمال رنگ، تلفن، ایمیل، متن‌ها و ارتفاع تازه
* Fallback خودکار 2.5 ثانیه‌ای بدون خطر مخفی‌ماندن هدر
* حفظ کامل DOM، Mega Menu، Hamburger و Responsive قبلی

= 3.8.7 =
* ذخیره واقعی رنگ‌ها و کنترل‌های باز Top Bar با هر دو دکمه ذخیره
* نمایش پیام موفقیت فقط پس از تأیید پاسخ WordPress
* خواندن تازه تنظیمات عمومی Top Bar از REST برای عبور از Cache صفحه
* اعمال مقاوم رنگ پس‌زمینه، متن، حاشیه، دکمه و ارتفاع روی هدر Legacy
* بازیابی خودکار وضعیت فعال افزونه پس از Core Upgrader
* حفظ اصل حداقل دسترسی؛ Reactivation فقط برای افزونه‌ای که قبلاً فعال بوده است
* ثبت وضعیت ماشین‌خوان Reactivation برای تست Production
* حفظ معماری ماژولار و تمام قواعد Responsive

= 3.8.6 =
* مدیریت کامل تمام گزینه‌های Top Bar از پیشخوان
* کنترل مستقل نمایش تلفن، ایمیل، WhatsApp، صادرات و CTA عمده
* انتخاب لوگوی مرکزی و مدیریت رنگ‌ها و ارتفاع نوار
* سازگاری با هدر حرفه‌ای قدیمی بدون بازطراحی Mega Menu

= 3.8.5 =
* بازیابی هدر دو‌ردیفه Luxury مطابق هویت اصلی ALOOKHOR
* واکشی خودکار فهرست اصلی و تمام فهرست‌ها در Hamburger حرفه‌ای
* تنظیمات کامل Top Bar، تماس، WhatsApp، CTA، منو و حساب کاربری
* انتشار و نصب مستقیم از Update Center بدون حذف یا Upload مجدد افزونه
* حفظ Callback قدیمی شورت‌کد در صورت وجود

= 3.8.4 =
* رفع خالی‌ماندن تنظیمات بوتیک با Guard کامل داده‌ها
* Migration خودکار حافظه ناقص؛ ترمیم ماژول‌های 0/0 و پیشنهادهای AI بدون حذف تنظیمات کاربر
* بازیابی هدر دو‌ردیفه Luxury و Hamburger حرفه‌ای با تمام فهرست‌های WordPress
* داشبورد PHP Fallback در صورت لودنشدن ES Modules
* همگام‌سازی نسخه کنترل سنتر با نسخه واقعی افزونه
* زیرساخت آپدیت خصوصی و WordPress-native با Manifest قابل تنظیم

= 3.8.3 =
* رفع خطاهای کنسول و محدودیت Tracking Prevention

= 3.8.2 =
* رفع خطای ES Module و مسیر اشتباه site.json در wp-admin

= 3.8.0 =
* تبدیل به افزونه وردپرس با آپدیت آنی
* حافظه پایدار WP Options
* شورت‌کد [alookhor_portal_header] حرفه‌ای با Glass + Gold
* سایدبار PRO فشرده ۶ دسته
* تنظیمات پیشرفته: دستیار هوشمند + سلامت سیستم + ماژول‌ها

= 3.7.2 =
* نسخه استاتیک لوکس
