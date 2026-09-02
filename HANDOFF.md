# 📦 سند جامع انتقال — پروژهٔ آلوخور (به‌روز: v3.10.217)

> کل این فایل را در چت جدید کپی کنید. همهٔ زمینه، کدها، دستورات، قوانین، اندازه‌گیری‌ها و وضعیت فعلی داخل همین سند است.

---

## ۱) شناسنامهٔ پروژه

- **مخزن:** `emeliijaddd-png/alookhor-update-publisher` (خصوصی، گیت‌هاب)
- **برنچ کاری:** `arena/01a053d1-alookhor-update-publisher` — کامیت/پوش فقط روی همین برنچ
- **سایت زنده:** `https://alookhor.ir` (وردپرس + ووکامرس، قالب Woodmart، کش Cloudflare/هاست)
- **افزونه:** `plugin/alookhor-control-center/` — نسخهٔ فعلی **3.10.217** (زنده و تأییدشده — PDP کاملاً به موکاپ جدید مالک بازطراحی شده؛ بصری کامل = 3.10.212 + پولیش ۳.10.214/۲۱۶/۲۱۷ (تومان، مخفی بودن وزنِ خالی، تراز تعداد، ارقام فارسی)؛ ۲۱۳/۲۱۵ فقط CI)
- **انتشار خودکار:** پوش تگ `vX.Y.Z` → GitHub Actions: build → FTPS آپلود → به‌روزرسانی خودکار WP → تست پس از انتشار + ممیزی مرورگر واقعی
- مالک فارسی‌زبان، عجول، پاسخ کوتاه/فارسی/با عدد و جدول. کد در گیت‌هاب، کش سایت جای دیگر — همیشه جدا توضیح بده.

## ۲) هدف محصول (موکاپ #4 مالک)

- **موبایل:** گالری اول، عکس بزرگ، CTA طلایی پهن تمام‌عرض، نوار چسبان پایین (قیمت + CTA، ۶۴px)
- **دسکتاپ:** ستون عکس/خرید هم‌ارتفاع و هم‌تراز بالا و پایین
- پالت ۷رنگ بنفش تیره/طلایی؛ کادرها با ابعاد ثابت
- **خواستهٔ نهایی (حل‌شده در ۲۱۱):** کادر عکس و کادر توضیحات چسبیده به منو و بزرگ‌تر؛ محتوا (عکس/متن/دکمه) سر جایشان؛ هیچ نوار سفید/بنفش/دورنگی بین منو و محتوا در هیچ موقعیت اسکرول.

## ۳) نقشهٔ فایل‌های مهم

| مسیر | نقش |
|---|---|
| `plugin/.../assets/css/frontend-product.css` | CSS کامل PDP (~۱۰۴۰ خط). بلاک‌های نسخه‌ای پشت سر هم تا انتهای فایل؛ آخرین‌ها: 204(FLUSH)→…→211(FINAL GEOMETRY)→**212(MOCKUP PDP: کل هیرو با کلاس‌های جدید `.alpm-*` بازنویسی شد؛ بلوک‌های هیروی قدیمی مرده‌اند ولی فایل حذف نشده‌است)** |
| `plugin/.../includes/product-page.php` | مارک‌آپ PDP + enqueue خط 397 (نسخهٔ `ALOOKHOR_CC_BUILD`). مارکر `<!-- ALOOKHOR-PDP v3.10.x -->` همینجاست |
| `plugin/.../assets/css/frontend-header-akx.css` | هدر `#akx-header` مال خودِ افزونه: topbar 44px + `.akx-mainbar` 78px (min-height)؛ با اسکرول mainbar با کلاس `is-stuck` می‌شود `position:fixed; top:0; z-index:99990` |
| `plugin/.../alookhor-control-center.php` | خط 20: `define('ALOOKHOR_CC_BUILD','3.10.211')` |
| `scripts/build_release.py` | بیلد + چک نسخه در **۶جا**: plugin_header / constant / build / **Stable tag در readme.txt** / site_json / release_json |
| `scripts/generate_code_registry.py` | تولید `docs/MASTER_CODE_REGISTRY.md` — **بعد از هر تغییر سورس اجباری**، وگرنه CI می‌میرد |
| `scripts/wordpress_release_test.py` | تست پس از انتشار + `_pdp_browser_audit()`: سلکتورها از ۲۱۲ به `.alpm-*` تغییر کرده‌اند؛ چک‌های متنی به «قیمت محصول» وابسته‌اند — **اگر برچسب‌های مارک‌آپ PDP عوض شوند این چک‌ها هم به‌روز شوند («قیمت محصول» + «alpm-panel» + «افزودن به سبد خرید»). **واحد فروشگاه = IRR (نماد ﷼)**؛ نمایش PDP خودکار تومان می‌شود (÷۱۰ فقط محصول ساده؛ متغیر ریال می‌ماند) |** | |
| `.github/workflows/publish.yml` | تنها ورک‌فلو — deploy فقط روی تگ `v*.*.*`، access_audit فقط روی push به main |
| `release.json` / `readme.txt` / `CHANGELOG.md` | متادیتای انتشار (باید با هم هم‌نسخه شوند) |
| `HANDOFF.md` | همین سند (روی برنچ کامیت شده) |

**شورتکدها/ساختار سایت:** هدر پریمیوم `[alookhor_premium_header]` (ممیزی چک می‌کند raw نمانده)، صفحات about/contact توسط افزونه (`/wp-json/alookhor-cc/v1/about` و مشابه_product). PDP با فیلتر روی ووکامرس جایگزین می‌شود نه شورتکد. نوار چسبان موبایل `.alp-sticky` **بیرون از** `<section class="alookhor-alp">` رندر می‌شود → انتخابگرش باید `body.alookhor-pdp-body .alp-sticky` باشد.

## ۴) دستورالعمل انتشار (دقیق و بی‌کم‌وکاست)

```bash
cd /home/user/alookhor-update-publisher
# 1) تغییر کد/CSS (فقط append بلاک نسخه‌دار در انتهای frontend-product.css)
# 2) بامپ نسخه با جایگزینی رشته‌ای 3.10.21X→3.10.21Y در ۶ فایل:
#    alookhor-control-center.php / assets/js/app.js / assets/js/core/updateSystem.js
#    assets/js/modules/dashboard.js / assets/js/modules/settings.js / config/site.json
# 3) readme.txt: Stable tag + بلاک «= X =» | CHANGELOG.md: ورودی فارسی | release.json: version/previous/desc/changelog[0]
python3 scripts/generate_code_registry.py && python3 scripts/generate_code_registry.py --check
python3 -m py_compile scripts/*.py
node --check plugin/alookhor-control-center/assets/js/app.js
python3 scripts/build_release.py        # باید {"state": "ready", ...} بدهد
rm -f alookhor-control-center-*.zip     # خروجی محلی را کامیت نکن
git add -A && git -c user.name="Arena Agent" -c user.email="agent@arena.ai" commit -m "vX.Y.Z: ..." --quiet
git push origin arena/01a053d1-alookhor-update-publisher
git tag vX.Y.Z && git push origin vX.Y.Z          # تگ = اجرای انتشار
# پیگیری:
ID=$(gh run list --limit 1 --json databaseId --jq '.[0].databaseId')
gh run watch $ID --exit-status --interval 25
```

**چک‌های CI که قبلاً کار را کشته‌اند:** رجیستری کهنه (راه‌حل: بازتولید)، Stable tag جاافتاده، CJK در CSS، `node --check` همهٔ JS، `php -l` همهٔ PHP (در CI؛ محلی php نیست → `npm i php-parser`).

**تأیید زنده:** `fetch_page` روی `https://alookhor.ir/wp-json/alookhor-cc/v1/product` → `"version"` باید نسخهٔ جدید باشد. curl مستقیم از سندباکس بلاک است.

## ۵) هندسهٔ اندازه‌گیری‌شدهٔ زنده (قلب فنی ماجرا)

ثابت‌های سایت (ممیزی مرورگر واقعی در CI):

| کمیت | دسکتاپ 1614×900 | موبایل ~390 |
|---|---|---|
| هدر در جریان `#akx-header` | 0→122px (topbar 44 + mainbar 78) | 0→66px (topbar مخفی) |
| کشش منفی قالب (چون عنوان صفحه hidden است) | `.alookhor-alp` در top=+2 (یعنی ۱۲۰ زیر هدر) | top=−4 (۷۰ زیر هدر) |
| منوی چسبان هنگام اسکرول | mainbar `is-stuck`، fixed، 0→78px | هدر اسکرول می‌خورد، stuck نمی‌شود |

**قانون طلایی (درس ۲۰۸→۲۱۱):** کادرها باید به **خط منوی چسبان (78px دسکتاپ)** لنگر شوند نه کل هدر (122px). آن‌وقت: در لود اول، ۴۴px بالای کادر پشت topbar مخفی می‌شود و کادر «دقیقاً از لبهٔ منو» پیدا می‌شود؛ هنگام اسکرول کادر دقیقاً به منوی چسبان می‌چسبد → **در هیچ موقعیتی نوار باقی نمی‌ماند.**

**مقادیر نهایی v3.10.211 (آخر بلاک‌های CSS):**
```css
.alookhor-alp{padding-top:76px}                    /* دسکتاپ: کادر top=78 = خط منوی چسبان */
.alookhor-alp .alp-info{padding-top:110px}         /* متن اول: 78+110=188px (همان جای همیشگی) */
.alookhor-alp .alp-stage-in{inset:134px 12px 46px} /* عکس: 78+134=212px (همان جای همیشگی) */
@media(max-width:1023px){                          /* موبایل = هندسهٔ اثبات‌شدهٔ 209 */
 .alookhor-alp{padding-top:70px}                   /* کادر top=66 = لبهٔ منو، گپ 0 */
 .alookhor-alp .alp-info{padding-top:66px}
 .alookhor-alp .alp-stage{height:clamp(330px,calc(62vw + 20px),420px);min-height:330px}
 .alookhor-alp .alp-stage-in{top:46px}             /* عکس 132px، متن 100px */
}
/* از 208: body.alookhor-pdp-body{background:#24102F!important} + رپرها transparent — سفیدی قالب مرده */
```
**تأیید زندهٔ ۲۱۱:** دسکتاپ gal/info top=78 (نسبت به هدر کامل گپ −44 = چسبیده به لبهٔ منو)؛ موبایل گپ 0. عکس ۲۱۲px و متن ۱۸۸px = دقیقاً مثل قبل از بزرگ‌شدن کادرها.

**فرمول تغییر فاصله (اگر مالبعداً خواست):** `پدینگ alp = خط لنگر موردنظر − 2 (کشش قالب)` و برای پین‌ماندن محتوا، پدینگ داخلی به همان اندازه کم/زیاد شود (عکس: stage-in.top ، متن: info.padding-top).

## ۶) تاریخچهٔ کامل نسخه‌ها

| نسخه | تغییر | نتیجه |
|---|---|---|
| 199–202 | بازسازی هیرو، رفع آبشار موبایل، موکاپ موبایل | 202 فقط موبایلی؛ مالک: «فرقی نکرد» |
| 203 | چسبیده به منو + ستون هم‌ارتفاع | ظریف بود؛ دوباره «فرقی نکرد» |
| 204 | حذف breadcrumbs + عکس 94/95٪ | سبز؛ کشِ مالک مشکلی نبود (view-source تأیید شد) |
| 205 | دو باگ رندر-تست: حذف sticky گالری (آفست 96px)؛ انتخابگر واقعی نوار چسبان (97→64px) | سبز |
| 206 | padding 32/20px + جاسازی ممیزی زنده در خط انتشار | بی‌اثر — قالب محتوا را 88/50px زیر هدر می‌کشد |
| 207 | پدینگ کالیبره 152/90px | فاصله درست (+32/+20) ولی **نوار سفید** قالب در گپ دیده شد |
| 208 | body + رپرهای قالب بنفش تیره `#24102F` / transparent | سفیدی حذف؛ مالک نوارِ بنفش را دید و گفت کلاً باید نباشد |
| 209 | کادرها چسبیده به منو (120/70px) + پدینگ جبرانی (66/58/46) | گپ 0 ✓ ولی در اسکرولِ دسکتاپ 44px نوار می‌ماند (فروپاشی topbar) |
| 210 | آزمایش padding:0 + margin:-10 | اشتباه — کادرها پشت کل هدر (گپ −120)؛ کنار گذاشته شد |
| **211** | لنگر = منوی چسبان 78px + پدینگ‌های جبرانی 110/134؛ موبایل به هندسهٔ 209 | سبز؛ هندسه حفظ شد (padding 76/70 همچنان حاکم) |
| **212** | بازطراحی کامل هیروی PDP طبق موکاپ React مالک: پنل راست (۴۴٪) + گالری چپ، بندانگشتی عمودی، روبان طلایی، متن دست‌نویس، شمارنده، تمام‌صفحه، Toast؛ پالت دقیق موکاپ (#170a20/#f7b32b/#e42a68/#3bd684)؛ کلاس‌های `.alpm-*`، JS بازنویسی (ارقام فارسی، حداکثر تعداد ۱۰) | زنده؛ ممیزی سبز: دسکتاپ gal/panel top=78 گپ −44، موبایل گالری اول گپ 0؛ ولی ۲ چک CI به رشتهٔ «قیمت نهایی» وابسته بود → 213 |
| **213** | فقط اصلاح چک‌های CI به «قیمت محصول» | سبز |
| **214** | قیمت تومانی در PDP (فقط محصول ساده) + مخفی شدن چیپ «بستهٔ استاندارد» تک‌تایی + تراز ردیف تعداد | زنده درست، CI به «انتخاب وزن» وابسته بود → 215 |
| **215/216** | 215: چک CI به alpm-panel — 216: تومان برای واحد IRR (ریال ÷۱۰) هم | 216 زنده و سبز |
| **217** | ارقام فارسی قیمت/تخفیف («۱٬۳۰۰ تومان» «٪۸۹») | **زنده و سبز کامل** |

زنجیرهٔ کامیت‌های کلیدی (تا ۲۱۱): `1ba58bb`(204)→`3930f7a`(205)→`e5145b8`(206)→`3e4fe79`(207)→`5773641`(208)→`9b0390a`(209)→`d566f29`(210)→**`8423b24`(211=HEAD فعلی)**. ران‌های سبز مهم: 33537486867(205)، 33542647254(207)، 33601170738(208)، 33601888371(209)، 33603480390(210)، **33603927802(211)**.

## ۷) زیرساخت ممیزی زنده (استفادهٔ مجدد)

- **خودکار هنگام هر انتشار:** انتهای `scripts/wordpress_release_test.py` تابع `_pdp_browser_audit()` — Chrome/Selenium در رانر، 2 ویوپورت، هندسهٔ هدر/کادرها/گپ/CSS تازه/اسکرول. خروجی فشرده (<1.6KB؛ گارد `too_big`) زیر کلید `wordpress.pdp_browser_audit`.
- **خواندن:**
```bash
gh api 'repos/emeliijaddd-png/alookhor-update-publisher/contents/latest.json?ref=publisher-status' \
  --jq .content | base64 -d | python3 -m json.tool
# کلیدهای هر ویو: gal/info/band (top/bottom/height) + gap (نسبت به هدر) + pt (پدینگ alp) + css + scr
```
- قیود: گام status لاگ را ۱۲۰۰۰ کاراکتر می‌برد (payload کوچک بماند)؛ نصب selenium فقط با `pip install --target /tmp/pdp_deps --break-system-packages selenium` + `sys.path.insert` (PEP 668).
- **رندر محلی سریع** (بدون سایت): `/tmp/render` با puppeteer + @sparticuz/chromium (`inflate` به `/tmp/al2023`، launch با `env:{LD_LIBRARY_PATH:'/tmp/al2023/lib'}` + `--no-sandbox`) و صفحهٔ تست `pdp.html` — برای چک تراز/سرریز؛ حقیقت نهایی فقط ممیزی زنده است (هدر/مارجن منفی قالب را ندارد).

## ۸) قوانین محیط (تکرار ممنوع)

1. پوش **فایل ورک‌فلوی جدید ممنوع** (توکن sandbox بدون `workflows` permission) — فقط فایل‌های موجود را ویرایش کن.
2. دانلود لاگ ران (`.../logs`) در sandbox خطای EOF می‌دهد → از jobs API نام قدم شکست‌خورده را بگیر و محلی بازتولید کن.
3. curl به alookhor.ir بلاک؛ `fetch_page` جواب می‌دهد؛ رانرهای CI دسترسی کامل دارند.
4. `php` محلی نیست → php-parserِ npm برای lint.
5. Chrome فقط از @sparticuz (CDN گوگل و apt بلاک/ناقص).
6. CSS جدید همیشه با پیشوند `.alookhor-alp`؛ **استثنا:** نوار چسبان `body.alookhor-pdp-body` (المان بیرون سکشن است — این باگ ۴ نسخه طول کشید!).
7. `MASTER_CODE_REGISTRY.md` هرگز دستی — همیشه `generate_code_registry.py`.
8. rename/delete فایل‌های CSS ممنوع؛ بدون CJK؛ بودجهٔ تصویر ≤8100B.
9. `/tmp` با ریست پاک می‌شود؛ پیوست چت به workspace نمی‌رسد (URL بخواه یا از CI بگیر).
10. deploy فقط روی تگ، access_audit فقط روی main — طراحی را حول همین ببند.
11. اگر برنچ محلی عقب افتاد/به‌هم رفت: `git fetch origin <branch>` بعد مقایسه و در صورت نیاز `git reset --hard FETCH_HEAD` (یک‌بار اتفاق افتاد؛ همهٔ کارها روی remote سالم بودند).
12. اسم فایل سند را تغییر نده: `HANDOFF.md` روی برنچ است و دستور فراخوانی به آن اشاره دارد.

## ۹) وضعیت همین لحظه

- **v3.10.217 زنده، سبز و تأییدشده** — PDP جدید = موکاپ مالک (ران 33613266714 سبز کامل). هندسهٔ ۲۱۱ حفظ شده؛ بلوک‌های CSS قدیمی هیرو (۱۹۹–۲۱۱) مرده‌اند و بدرد پاک‌سازی می‌خورند.
- از ۲۱۲ مارک‌آپ PHP و JS هم تغییر کرده (فقط append CSS نیست)؛ کلاس‌های هیرو = `.alpm-*`؛ آیکن‌های جدید در `alookhor_cc_pdp_icon`؛ idهای حیاتی برای JS: ‎#alpMain ‎#alpQty .alp-price-now [data-base] [data-wish-label] [data-toast] [data-stage] [data-fs].
- **برنچ کاری این جلسه:** `arena/01a0610f-alookhor-update-publisher` (ریست روی ردهٔ ۲۱۱ انجام شد، بعد روی همان ادامه یافت)؛ برنچ قبلی `arena/01a053d1-...` دیگر به‌روز نمی‌شود.
- **گام‌های بعدی پیشنهادی:** (۱) بازخورد مالک بعد از Ctrl+F5 — اگر فاصله/چسبندگی می‌خواهد تغییر کند فقط اعداد بلاک ۲۱۱ طبق فرمول بخش ۵. (۲) اختیاری: پاک‌سازی تگ قدیمی `v3.10.200` (روی کامیت تحلیل موقت نشسته) و حذف بلاک‌های CSS نسخه‌های ۱۹۹–۲۰۳ برای سبک‌شدن (~۱۵KB). (۳) اگر مالک اسکرین‌شات داد، اول ممیزی زنده با اعداد مقایسه کن بعد نظر بده.

## ۱۰) فرمان شروع چت جدید

```
فایل سند انتقال پروژهٔ آلوخور را کامل بخوان و به‌عنوان زمینهٔ کاری همین چت در نظر بگیر، بعد وضعیت فعلی را در ۵ خط خلاصه کن. اگر فایل محلی نبود از گیت‌هاب بگیر:

cat /home/user/alookhor-update-publisher/HANDOFF.md 2>/dev/null || gh api "repos/emeliijaddd-png/alookhor-update-publisher/contents/HANDOFF.md?ref=arena/01a053d1-alookhor-update-publisher" --jq .content | base64 -d
```

## ۱۱) نکات ارتباط با مالک

- پاسخ کوتاه، فارسی، با جدول/عدد؛ بدون توضیح فنی اضافه.
- مالک فایل می‌فرستد: پیوست چت فقط برای عکس خوب است؛ برای کد/ZIP از «پنل آپلود فایل آلوخور» (پورت 8080، `/home/user/upload-panel/server.py`) استفاده کن — ZIP خودکار باز می‌شود و نام فارسی هم سالم می‌ماند.
- چک‌های متنی انتشار به برچسب‌های فارسی مارک‌آپ حساس‌اند («قیمت محصول»، «انتخاب وزن»، «افزودن به سبد خرید») — هنگام تغییر متن‌های PDP هر دو را با هم به‌روز کن.
- قبل از خبر «انجام شد»، همیشه ممیزی زنده بگیر (publish-status) — حدس CSS بدون اندازه‌گیری ۷ بار اشتباه بود در این پروژه.
- محل کد (گیت‌هاب) و کش سایت (Cloudflare/هاست) جدا توضیح داده شود؛ «سرور تازه است» کافی نیست، مالک باید در مرورگر خودش ببیند (Ctrl+F5).
