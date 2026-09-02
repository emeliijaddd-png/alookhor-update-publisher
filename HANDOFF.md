# 📦 سند جامع انتقال — پروژهٔ آلوخور (alookhor-update-publisher)

> این فایل را کپی کنید در چت جدید. همهٔ زمینهٔ کار، قوانین، دستورات، یافته‌ها و وضعیت فعلی داخل همین سند است.

---

## ۱) شناسنامهٔ پروژه

- **مخزن گیت‌هاب:** `emeliijaddd-png/alookhor-update-publisher` (خصوصی)
- **برنچ کاری نشست:** `arena/01a053d1-alookhor-update-publisher` — همهٔ کار/کامیت/پوش فقط روی همین برنچ. پوش دیگر برنچ‌ها ممنوع.
- **سایت زنده:** `https://alookhor.ir` (وردپرس + ووکامرس، قالب Woodmart)
- **افزونه:** `plugin/alookhor-control-center/` — نسخهٔ فعلی **3.10.207**
- **انتشار خودکار:** تگ `vX.Y.Z` پوش شود → GitHub Actions ساخته، آپلود FTPS، به‌روزرسانی خودکار وردپرس و تست پس از انتشار اجرا می‌شود.
- **مالک** سایت را در مرورگر خودش می‌بیند (نه LocalWP). کد در گیت‌هاب، کش سایت در Cloudflare/هاست/افزونهٔ WP — این دو همیشه جدا توضیح داده شوند.
- مالک فارسی‌زبان است، گاهی فقط «؟» می‌فرستد؛ پاسخ‌ها کوتاه، فارسی، با جدول و اسکرین‌شات/عدد باشد.

## ۲) هدف محصول (معیار پذیرش مالک)

صفحهٔ محصول (PDP) مطابق **موکاپ #4 مالک**:
- **موبایل:** گالری اول، عکس بزرگ، CTA طلایی پهن تمام‌عرض، نوار چسبان پایین (قیمت + CTA)
- **دسکتاپ:** ستون عکس/ستون خرید هم‌ارتفاع و هم‌تراز (بالا و پایین)
- پالت ۷رنگ بنفش/طلایی، کادرها (frames) با ابعاد ثابت
- **موضع فعلی مالک (آخرین بازخورد):** «محتوا زیر منوی اصلی رفته، باید فاصله داشته باشد» — در دسکتاپ و موبایل.

## ۳) نقشهٔ فایل‌های مهم

| مسیر | نقش |
|---|---|
| `plugin/alookhor-control-center/assets/css/frontend-product.css` | CSS کامل PDP (~۱۰۰۰ خط). انتهای فایل بلاک‌های نسخه‌ای به ترتیب: …→v3.10.203→v3.10.204(FLUSH)→v3.10.205(RENDER-TESTED)→v3.10.206(BREATHING)→v3.10.207(CALIBRATED آخرین خط) |
| `plugin/alookhor-control-center/includes/product-page.php` | مارک‌آپ PDP + enqueue (خط 397: `frontend-product.css` با نسخهٔ `ALOOKHOR_CC_BUILD`). کامنت مارکر `<!-- ALOOKHOR-PDP v3.10.x -->` همین‌جاست |
| `plugin/alookhor-control-center/assets/css/frontend-header-akx.css` | هدر سایت `#akx-header` خودِ همین افزونه است؛ نوار اصلی `.akx-mainbar` با اسکرول `position:fixed; top:0` می‌شود (کلاس `is-stuck`، z-index:99990) |
| `plugin/alookhor-control-center/alookhor-control-center.php` | خط 20: `define('ALOOKHOR_CC_BUILD','3.10.207')` |
| `scripts/build_release.py` | بیلد ZIP + اعتبارسنجی نسخه‌ها (نسخه در **۶جا** باید یکی باشد: plugin_header/constant/build/stable_tag/site_json/release_json) |
| `scripts/generate_code_registry.py` | تولید `docs/MASTER_CODE_REGISTRY.md` — **بعد از هر تغییر سورس باید اجرا شود** وگرنه CI می‌میرد (`--check` برای تست) |
| `scripts/wordpress_release_test.py` | تست پس از انتشار (داخل job deploy روی تگ اجرا می‌شود). از v206 انتهایش تابع `_pdp_browser_audit()` اضافه شده: مرورگر واقعی Chrome/Selenium صفحهٔ محصول زنده را می‌سنجد و در `publisher-status/latest.json` می‌نویسد |
| `scripts/header_visual_audit.py` | ممیزی هدر صفحهٔ اصلی (Selenium). از v206+ یک `pdp_audit` اطلاعاتی هم دارد ولی فقط در job `access_audit` اجرا می‌شود که **فقط روی push به main** می‌رود (نه تگ) |
| `.github/workflows/publish.yml` | تنها ورک‌فلو: build → deploy (فقط تگ `v*.*.*`) → access_audit (فقط main) |
| `release.json` | نسخه/previous/توضیح/changelog انتشار |
| `plugin/alookhor-control-center/readme.txt` + `CHANGELOG.md` | ورودی نسخه + `Stable tag:` (جا بماند build_release خطا می‌دهد) |
| `/home/user/uploads/view203.png` | اسکرین‌شات دسکتاپ مالک (مرجع تحلیل پیکسلی) |

**شورتکد/صفحات شناخته‌شده:** هدر پریمیوم `[alookhor_premium_header]` (در ممیزی چک می‌شود که raw باقی نمانده)، صفحات about/contact توسط افزونه ساخته می‌شوند (`/wp-json/alookhor-cc/v1/about` و مشابه). PDP با فیلتر روی ووکامرس جایگزین می‌شود، نه شورتکد.

## ۴) دستورالعمل انتشار (دقیقاً به همین ترتیب — هرگز کم نکنید)

```bash
cd /home/user/alookhor-update-publisher
# 1) تغییر CSS/کد + بامپ نسخه در ۶ فایل (جایگزینی رشته‌ای 3.10.20X→3.10.20Y):
#    alookhor-control-center.php / assets/js/app.js / assets/js/core/updateSystem.js
#    assets/js/modules/dashboard.js / assets/js/modules/settings.js / config/site.json
# 2) readme.txt: Stable tag + بلاک changelog انگلیسی | CHANGELOG.md: ورودی فارسی
# 3) release.json: version/previous/description/changelog[0]
python3 scripts/generate_code_registry.py          # الزامی
python3 scripts/generate_code_registry.py --check
python3 -m py_compile scripts/*.py
node --check plugin/alookhor-control-center/assets/js/app.js
python3 scripts/build_release.py                   # باید JSON ready بدهد
rm -f alookhor-control-center-*.zip                # خروجی محلی را کامیت نکن
git add -A && git -c user.name="Arena Agent" -c user.email="agent@arena.ai" \
  commit -m "vX.Y.Z: ..." --quiet
git push origin arena/01a053d1-alookhor-update-publisher
git tag vX.Y.Z && git push origin vX.Y.Z           # تگ = اجرای CI انتشار
```

**چک‌های CI (build job) که کار را کشته‌اند — همیشه رعایت شود:**
- `MASTER_CODE_REGISTRY.md` باید با اسکریپت تولید شده باشد (ویرایش دستی + sed نسخه، کهنه‌اش می‌کند → بازتولید کن)
- `Stable tag:` در readme.txt باید با نسخه یکی باشد
- بدون CJK در CSS، بدون کلمهٔ کلیدی ممنوعه، `node --check` همهٔ JSها، `php -l` همهٔ PHPها (در CI؛ محلی php نداریم — از `npm i php-parser` در `/tmp/render` استفاده کن)

**پیگیری ران:**
```bash
gh run list --limit 3 --json databaseId,headBranch,status,conclusion
gh run watch <ID> --exit-status --interval 25
# اگر شکست خورد و دانلود لاگ EOF داد (محیط سندباکس بلاک است):
gh api repos/emeliijaddd-png/alookhor-update-publisher/actions/runs/<ID>/jobs \
  --jq '.jobs[] | {name, conclusion, bad: [.steps[] | select(.conclusion=="failure") | .name]}'
```

**تأیید زنده:** `fetch_page` روی `https://alookhor.ir/wp-json/alookhor-cc/v1/product` → باید `"version":"X.Y.Z"` باشد. (curl مستقیم در سندباکس بلاک است؛ fetch_page جواب می‌دهد.)

## ۵) یافته‌های کلیدی اندازه‌گیری زنده (مهم‌ترین بخش فنی)

ممیزی مرورگر واقعی روی سایت زنده (در CI، از داخل `wordpress_release_test.py`) این اعداد را داد — **عریض‌ترین دلیل باگ «زیر منو رفتن»**:

| | دسکتاپ 1614×900 | موبایل 390×844 (innerWidth 375) |
|---|---|---|
| هدر `#akx-header` (in-flow) | 0 → پایین **122px** (topbar 44 + mainbar 78) | 0 → **66px** (topbar مخفی) |
| بالای سکشن `.alookhor-alp` | **2px** (یعنی ۱۲۰px زیر لبهٔ هدر!) | **−4px** |
| بالای band/گالری/info | 34px → گپ واقعی با منو **−88px** | 16px → گپ **−50px** |
| CSS سرو‌شده (bypass کش) | هر سه مارکر v204/205/206 موجود، len 79280 → **کش مشکل نیست** | همان |
| بعد اسکرول 500px | mainbar `is-stuck=true`، top=0 (fixed می‌شود) | stuck=false (هدر اسکرول می‌خورد) |

**نتیجه:** قالب (Woodmart) وقتی عنوان صفحه با CSS ما `display:none` می‌شود، محتوا را با مارجن منفی به زیر هدرِ in-flow می‌کشد (دمای دسکتاپ 88px، موبایل 50px). برای همین پدینگ‌های قبلی (32/20px) اثر بصری نداشتند.

**اصلاح v3.10.207 (فعلی):**
```css
.alookhor-alp{padding-top:152px}                 /* دسکتاپ: 122+88+32−88 ≈ band 30px زیر منو */
@media(max-width:1023px){.alookhor-alp{padding-top:90px}}  /* موبایل: 66+50+20−50 ≈ band 20px زیر منو */
```
> اگر مالک باز گفت فاصله کم/زیاد است، فقط همین دو عدد را جابه‌جا کنید (فرمول: `پدینگ = ارتفاع هدر + 88 (یا 50 موبایل) + فاصلهٔ مطلوب مالک − 88`). اگر گفت «از پایین افتاده» یعنی theme ارتفاع هدر را تغییر داده → اعداد ممیزی جدید را از `publisher-status` بگیرید.

## ۶) تاریخچهٔ نسخه‌ها (خلاصهٔ چه کرد و چه شد)

| نسخه | تغییر | نتیجه |
|---|---|---|
| 199–202 | بازسازی هیرو، رفع آبشار موبایل، موکاپ موبایل | 202 فقط موبایلی بود → مالک «فرقی نکرد» |
| 203 | چسبیده به منو + ستون‌های هم‌ارتفاع | تغییر دسکتاپی ظریف؛ مالک باز «فرقی نکرد» |
| 204 | حذف breadcrumbs + عکس 94/95٪ + حاشیه 16/10px | سبز؛ کش مالک مشکلی نبود (view-source تأیید) |
| 205 | رفع دو باگ واقعی با رندر تست: حذف `position:sticky` گالری (آفست 96px دسکتاپ)؛ **انتخابگر نوار چسبان غلط بود** (المان بیرون از `<section>` است → پیشوند درست: `body.alookhor-pdp-body .alp-sticky`) ارتفاع 97→64px | سبز |
| 206 | تلاش برای فاصله: padding-top 32/20px + جاسازی ممیزی زنده در خط انتشار | **بی‌اثر** چون قالب محتوا را 88/50px زیر هدر می‌کشد (یافتهٔ ممیزی) |
| **207** | پدینگ کالیبره 152/90px بر اساس اندازه‌گیری زنده | تگ زده شد؛ **وضعیت ران CI نامعلوم** (کاربر وسط watch قطعش کرد) ← اول این را چک کنید |

**زنجیرهٔ کامیت (قدیم→جدید):** `884cd8a`→`888cac0`→`ce9b1b0`→`b1d8b1f`→`a8b100b`→`3acdf7e`→`e90b1e6`→`1ba58bb`(204)→`3930f7a`(205 سبز)→`e5145b8`(206)→`8b34532`(206+ممیزی نهایی، ران سبز 33542080104)→**`3e4fe79` (v3.10.207 = HEAD)**. تگ‌های تمیز: v3.10.200 روی کامیت تحلیل موقت نشسته (پاک‌سازی اختیاری).

## ۷) زیرساخت ممیزی که ساخته شد (بعداً هم استفاده کنید)

**الف) ممیزی زندهٔ هنگام انتشار (خودکار):** انتهای `scripts/wordpress_release_test.py` تابع `_pdp_browser_audit()` هست — Chrome/Selenium در رانر CI صفحهٔ محصول زنده را در 2 ویوپورت می‌سنجد (هندسهٔ هدر/گپ/پدینگ/CSS تازه/اسکرول). خروجی فوق‌فشرده زیر کلید `wordpress.pdp_browser_audit` در برنچ `publisher-status` فایل `latest.json`. خواندن:
```bash
gh api 'repos/emeliijaddd-png/alookhor-update-publisher/contents/latest.json?ref=publisher-status' \
  --jq .content | base64 -d | python3 -m json.tool
```
قیود: گام status لاگ‌ها را به ۱۲۰۰۰ کاراکتر می‌برد → payload ممیزی باید < ~1600B بماند (گارد `too_big` دارد). نصب selenium در رانر: فقط `pip install --target /tmp/pdp_deps --break-system-packages selenium` + `sys.path.insert(0,...)` جواب داد (PEP 668).

**ب) رندر محلی (تست سریع CSS پیش از انتشار):** در `/tmp/render` (با ریست پاک می‌شود):
```bash
cd /tmp/render && npm i puppeteer @sparticuz/chromium php-parser
node -e "const c=require('@sparticuz/chromium').default; c.inflate('node_modules/@sparticuz/chromium/bin/al2023.tar.br','/tmp/al2023').then(()=>console.log('ok'))"
# سپس launch با: executablePath=await chromium.executablePath(), args:[...chromium.args,'--no-sandbox'],
#                env:{LD_LIBRARY_PATH:'/tmp/al2023/lib'}
```
صفحهٔ تست `/tmp/render/pdp.html` (بازسازی از `includes/product-page.php` + هدر فیک 120px + CSS واقعی با file://). مفید برای چک تراز/سرریز، ولی **هدر/مارجن منفی قالب را ندارد** — حقیقت نهایی فقط ممیزی زندهٔ بخش (الف).

## ۸) قوانین/محدودیت‌های محیط (تکرار نکنید این اشتباهات را)

1. **پوش فایل ورک‌فلوی جدید ممنوع** — توکن GitHub App سندباکس `workflows` permission ندارد. فقط فایل‌های موجود قابل ویرایش‌اند. (پوش `live-audit.yml` رد شد.)
2. دانلود لاگ ران با `gh api .../logs` در سندباکس **EOF** می‌دهد → از jobs API برای نام قدم شکست‌خورده استفاده کن، بعد محلی بازتولید کن.
3. curl به alookhor.ir از سندباکس بلاک؛ `fetch_page` جواب می‌دهد؛ رانرهای CI دسترسی کامل دارند.
4. `php` باینری محلی نیست → php-parserِ npm برای lint PHP.
5. Chrome از CDN گوگل نصب نمی‌شود؛ apt ناقص → راه @sparticuz (بالا).
6. بلاک‌های CSS جدید همیشه با پیشوند `.alookhor-alp`؛ به‌جز نوار چسبان که **بیرون سکشن** است → `body.alookhor-pdp-body` (این باگ یک‌بار ۴ نسخه طول کشید!).
7. `MASTER_CODE_REGISTRY.md` دستی ویرایش نشود؛ همیشه `generate_code_registry.py` بعد از تغییر سورس.
8. rename/delete فایل CSS ممنوع؛ بودجهٔ تصویر ≤8100B؛ بدون نویسهٔ CJK.
9. `/tmp` با ریست پاک می‌شود؛ پیوست‌های چت به workspace نمی‌رسد (از مالک بخواهید URL بدهد یا در CI بگیرید).
10. ورک‌فلو: deploy فقط روی تگ، access_audit فقط روی main (تغییردادن‌شان نیاز به workflows permission دارد که نداریم — طراحی را حول همین ببند).

## ۹) وضعیت این لحظه و گام‌های بعدی

1. **v3.10.207 کامیت/تگ/پوش شده (`3e4fe79`)** ولی وضعیت ران CI نامعلوم است (watch قطع شد):
   ```bash
   gh run list --limit 2 --json databaseId,headBranch,status,conclusion
   # سبز شد؟ → fetch_page روی /wp-json/alookhor-cc/v1/product باید 3.10.207 بدهد
   # قرمز شد؟ → jobs API بگیر؛ محتمل‌ترین: registry (بازتولید) یا Stable tag
   ```
2. بعد از سبزی، `publisher-status/latest.json` را بخوان و مطمئن شو `gap.band` دسکتاپ ≈ +30 و موبایل ≈ +20 است.
3. به مالک خبر بده: «الان با Ctrl+F5 چک کن — عکس و کادر توضیح باید با فاصلهٔ مشخص (~۳۰px دسکتاپ / ~۲۰px موبایل) زیر منو بیایند؛ اگر کم/زیاد است بگو چه مقدار».
4. اختیاری: پاک‌سازی تگ `v3.10.200` از کامیت تحلیل موقت؛ حذف بلاک‌های CSS نسخه‌های قدیمی برای کاهش حجم.

## ۱۰) نکات ارتباط با مالک

- مالک عصبی/عجول است؛ پاسخ کوتاه، فارسی، بدون عذرپذیری اضافه، با عدد/جدول.
- هر تغییر باید «در مرورگر خود مالک» دیده شود؛ قبل از خبر دادن، ممیزی زنده بگیر.
- محل کد (GitHub) و کش سایت (Cloudflare/هاست/LiteSpeed) را همیشه جدا نگویید.
- تجربهٔ ثابت شده: بدون اندازه‌گیری زنده، حدس CSS همیشه بخشی از حقیقت (مارجن منفی قالب) را از دست می‌دهد — **اول اندازه بگیر، بعد CSS بنویس.**
