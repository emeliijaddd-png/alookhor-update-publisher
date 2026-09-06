# فوری: بازیابی سایت alookhor.ir از خطای 500 (v3.10.225)

## علت
در v3.10.225 تابع `alookhor_cc_goldify()` دوباره در `includes/product-page.php` تعریف شد در حالی که قبلاً در `includes/pages-settings.php:98` وجود داشت.
→ Fatal: Cannot redeclare → همه درخواست‌ها 500 → آپدیت خودکار قفل شد.

## نسخه امن آماده
- v3.10.227 (sha `c74bbfb421cad35db02a49befbcbb593ae0fbb81fba3a76caad39754994b6677`) در `https://updates.alookhor.ir/releases/alookhor-control-center-3.10.227.zip`
- فایل تنها: `plugin/alookhor-control-center/includes/product-page.php` در همین ریپو (شاخه arena) - همه توابع با `if(!function_exists)` ایمن شده‌اند.

## راه حل سریع (یکی را انجام دهید)

### A) از طریق هاست cPanel / DirectAdmin File Manager (سریع‌ترین)
1. وارد File Manager شوید
2. بروید به `/home/tdwdwhzq/public_html/wp-content/plugins/alookhor-control-center/includes/`
3. فایل `product-page.php` فعلی را به `product-page.php.bak-225` تغییر نام دهید (بکاپ)
4. فایل جدید را آپلود کنید:
   - دانلود از: `https://updates.alookhor.ir/releases/alookhor-control-center-3.10.227.zip` → داخل zip مسیر `alookhor-control-center/includes/product-page.php`
   - یا از ریپو: `plugin/alookhor-control-center/includes/product-page.php` (همین شاخه)
5. سایت را رفرش کنید: `https://alookhor.ir/` باید 200 شود
6. سپس `https://alookhor.ir/wp-json/alookhor-cc/v1/status` باید version 3.10.227 یا 3.10.225 را بدون 500 برگرداند
7. اگر درست شد، از پیشخوان وردپرس > افزونه‌ها > آپلود افزونه، فایل `alookhor-control-center-3.10.227.zip` را نصب کنید (جایگزینی)

### B) از طریق FTPS به هاست وردپرس (اگر دسترسی دارید)
```bash
lftp -e "set ftp:ssl-force true; open -p 21 ftp://USER:PASS@alookhor.ir; put plugin/alookhor-control-center/includes/product-page.php -o /wp-content/plugins/alookhor-control-center/includes/product-page.php; bye"
```

### C) از طریق ایمیل بازیابی وردپرس
- وردپرس بعد از Fatal یک ایمیل با عنوان "سایت شما دچار مشکل فنی شده" به ادمین فرستاده (احتمالاً spam)
- لینک داخل ایمیل با `action=enter_recovery_mode` را باز کنید، وارد شوید، افزونه ALOOKHOR Control Center را غیرفعال کنید، سپس نسخه 3.10.227 را دوباره فعال کنید.

### D) از طریق WP-CLI (اگر SSH دارید)
```bash
wp plugin deactivate alookhor-control-center --skip-plugins --skip-themes
wp plugin install https://updates.alookhor.ir/releases/alookhor-control-center-3.10.227.zip --force --activate
```

## بعد از بازیابی
1. بررسی کنید:
   - `https://alookhor.ir/` → 200
   - `https://alookhor.ir/wp-json/alookhor-cc/v1/status` → `{"version":"3.10.227"}`
   - PDP: `https://alookhor.ir/product/%D8%A7%D9%84%D8%A8%D8%A7%D9%84%D9%88-%D8%AE%D8%B4%DA%A9/` → باید `alookhor-pdp` + `alpm-panel` + `قیمت محصول` داشته باشد
   - FAQ تیره (نه سفید)، بدون محصولات سامسونگ در ریل پیشنهادی
2. سپس CI خودکار دوباره کار می‌کند و manifest آخرین نسخه را نصب می‌کند.

## فایل‌های مرتبط
- فیکس شده: `plugin/alookhor-control-center/includes/product-page.php` (همین ریپو)
- ریلیز: `public/releases/alookhor-control-center-3.10.227.zip`
- مانیتور: `https://updates.alookhor.ir/manifest.json` باید version 3.10.227 شود بعد از CI run 33661318094
- لاگ CI: `publisher-status/latest.json` (در همین ریپو یا updates)

## پیشگیری
- همه توابع PDP با `if(!function_exists(...))` محافظت شدند تا redeclaration دیگر Fatal ندهد.
- تست محلی: `php -l includes/product-page.php` و `php -r "require 'pages-settings.php'; require 'product-page.php'; echo 'ok';"` قبل از تگ.
