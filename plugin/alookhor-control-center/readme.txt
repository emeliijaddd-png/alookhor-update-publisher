=== ALOOKHOR Control Center ===
Contributors: alookhor
Tags: control center, luxury, alookhor, admin, dashboard
Requires at least: 6.0
Tested up to: 7.0
Requires PHP: 8.0
Stable tag: 3.10.9
License: Private
License URI: https://alookhor.ir

کنترل سنتر لوکس و ماژولار آلوخور — مدیریت کامل سایت با آپدیت آنی بدون رفرش

== Description ==

**ALOOKHOR Control Center** پنل مدیریت لوکس بوتیک آلو بخارا است که تمام بخش‌های سایت شما (هدر، اسلایدر، سورت، محصولات، مشتریان VIP، مالی، آنالیتیکس) را در یک داشبورد Dark Glass + Gold مدیریت می‌کند.

*   **هدر حرفه‌ای با شورت‌کد:** هدر دو‌ردیفه Luxury با Top Bar، منوی شیشه‌ای، حساب کاربری و CTA عمده — فقط `[alookhor_portal_header]`
*   **جایگاه دسته‌بندی در Elementor:** بخش واقعی WooCommerce را با `[alookhor_managed_categories]` در هر محل دلخواه قرار دهید
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
