# سند انتقال کامل — پروژه ALOOKHOR (صفر تا صد برای چت جدید)

> این سند طوری نوشته شده که در چت جدیدِ هر عامل هوش مصنوعی کپی شود و همان عامل بتواند بدون هیچ گمانه‌زنی کار را ادامه دهد. همه‌ی دستورات، مسیرها، قوانین، و روش‌های دسترسی اینجاست.
> **استثنا یگانه:** رمزها/توکن‌ها هیچ‌وقت در این سند نوشته نمی‌شوند (اصلاً به آنها دسترسی نداریم) — فقط محل نگهداری‌شان مستند شده است. آدرس دسترسی زنده در انتهای سند آمده.

---

## ۱. شناسنامه‌ی پروژه

| مورد | مقدار |
|---|---|
| سایت | https://alookhor.ir |
| هاست آپدیت‌ها | https://updates.alookhor.ir (منیفست: `/manifest.json`) |
| مخزن گیت‌هاب | `emeliijaddd-png/alookhor-update-publisher` (PRIVATE) |
| پلاگین اصلی | `plugin/alookhor-control-center/` (یک پلاگینِ تک‌ماژوله که کل سایت را مدیریت می‌کند) |
| وردپرس Production | نسخه‌ی 7.1 روی PHP 8.1 |
| فریم‌ورک صفحه‌ساز | Elementor (صفحه‌ی محصول تکی به‌صورت **کامل** با فیلتر `template_include` توسط پلاگین بازنویسی می‌شود — تمپلیت: `templates/single-product.php`) |
| WooCommerce | فعال؛ فرم بومی `.cart` آن همیشه در DOM باقی می‌ماند |
| زبان/نوشتار | fa-IR، RTL، ارقام فارسی |

---

## ۲. معماری انتشار (مهم‌ترین بخش — «چطور کد به سایت می‌رسد»)

```
edit code → commit → bump version → git tag vX.Y.Z → push tag
   → GitHub Action «Build and Publish ALOOKHOR Release» (`.github/workflows/publish.yml`)
   → build_release.py اعتبارسنجی + ساخت ZIP و امضای SHA-256
   → آپلود روی updates.alookhor.ir از طریق FTPS صریح (Explicit FTPS با پین گواهی)
   → انتشار اتمیک manifest.json (put موقت → mv)
   → فراخوانی REST وردپرس: POST /wp-json/alookhor-cc/v1/install-update
   → پلاگین آنلاین ZIP را دانلود/تأیید/نصب می‌کند و خودش را RE-ACTIVATE می‌کند
   → مجموعه‌ی تست‌های پس‌از‌آپدیت (version, active, manifest, hero, categories, footer, feature, topbar, PDP …)
   → نوشتن ریپورت پاک‌سازی‌شده در برنچ `publisher-status` (فایل `latest.json`)
   → گام نهایی `Enforce successful atomic deployment` فقط وقتی سبز می‌شود که هر ۶ مرحله success باشد
```

**قانون کلیدی:** تغییر کد در ریپو روی سایت اثر ندارد؛ تنها روش انتشار، پوش تگ `v*.*.*` است. هر انتشار به‌صورت اتمیک روی میزبان کلید می‌خورد.

### ۲.۱. نسخه‌بندی — قانون مبارزه با نبرد عددی
- نسخه در **چهار فایل** هم‌گام می‌شود: `release.json` (کلید `version`)، `plugin/…/alookhor-control-center.php` (هدر `Version:` + `ALOOKHOR_CC_VERSION` + `ALOOKHOR_CC_BUILD`)، `plugin/…/readme.txt` (`Stable tag:`)، `plugin/…/config/site.json` (کلید `version`).
- `build_release.py` تگ را با `release.json` مقایسه می‌کند؛ مغایرت = شکست. برای انتشارات state باید `ready` باشد.
- **نکته‌ی بحرانی این دوره:** یک جریان انتشار موازی همزمان تگ می‌زند. قبل از ساختن شماره‌ی جدید، همیشه این را اجرا کن و بعد برو یکی بالاتر:

```bash
NEXT=$(($(git ls-remote --tags origin | grep -o "v3\.10\.[0-9]*$" | grep -o "[0-9]*$" | sort -n | tail -1) + 1)); echo $NEXT
```

### ۲.۲. مانیتورینگ و تأیید نصب
```bash
gh run watch <RUN_ID> --repo emeliijaddd-png/alookhor-update-publisher --exit-status
# گزارش نهاییِ نصب (منبع حقیقت وضعیت پروداکشن):
git fetch origin publisher-status:refs/remotes/origin/publisher-status --force
git show origin/publisher-status:latest.json   # توش: install.response.updated / version / failed_checks
```

### ۲.۳. وضعیت شناخته‌شده
- تست `pdp_renders_authenticated` برای **سشن‌های لاگین‌شده** FAIL می‌شود — یعنی مهمان‌ها طرح جدید را می‌بینند و ادمین ممکنه نسخه‌ی قدیمی را ببیند. اگر کاربر «هیچ فرقی نمی‌بیند»، با Incognito تست کنید.

---

## ۳. دسترسی‌ها و محل امن اسرار

| چی | کجا | توضیح |
|---|---|---|
| گیت‌هاب | این سشن Arena احرازِ `gh`/`git` را دارد | پوش فقط به برنچ سشن: `arena/<id>-alookhor-update-publisher`; دیپلوی فقط با پوش تگ |
| FTPS هاست | GitHub Secrets: `FTP_SERVER`,`FTP_PORT`,`FTP_USERNAME`,`FTP_PASSWORD` | پین گواهی TLS در `publish.yml` صریح چک می‌شود |
| وردپرس Application Password | GitHub Secrets: `WP_BASE_URL`,`WP_USERNAME`,`WP_APP_PASSWORD` | همین برای `install-update` استفاده می‌شود |
| داشبورد وردپرس | https://alookhor.ir/wp-admin | ورود دستی توسط مالک |
| cPanel / هاست | از سمت مالک | از این محیط به آن دسترسی نیست |
| **هرگز** | رمز/توکن را در کد، چت، یا سند ننویسید؛ جایی ذخیره نکنید که در git کامیت شود. | |

---

## ۴. نقشه‌ی کامل فایل‌های پلاگین

### ۴.۱. ریشه
| فایل | کار |
|---|---|
| `plugin/alookhor-control-center/alookhor-control-center.php` | بوت‌استرپ: ثابت‌های نسخه، `require` ماژول‌ها به ترتیب، خواندن تنظیمات با `alookhor_cc_settings()` |
| `plugin/alookhor-control-center/readme.txt` | `Stable tag: X.Y.Z` |
| `plugin/alookhor-control-center/config/site.json` | نسخه‌ی نصب‌شده + چک‌لیست URLها |
| `release.json` (ریشه‌ی ریپو) | نسخه‌ی جاری، previous, state=ready, changelog |

### ۴.۲. ماژول‌ها (`includes/`) و شورت‌کدها
| ماژول | شورت‌کد | نکته |
|---|---|---|
| `shortcode-header.php` | `[alookhor_portal_header]` | هدر لوکس + کپسول شیشه‌ای |
| `hero.php` | `[alookhor_managed_hero]` | اسلایدر هیرو (اسلاید VIP به خالی برمی‌گردد) |
| `product-categories.php` | `[alookhor_managed_categories]` | دسته‌ها — refork با `remove_shortcode` در init:999 |
| `footer.php` | `[alookhor_portal_footer]` | فوتر مدیرشده + گارد دوبل (Globals) |
| `site-features.php` | `[alookhor_managed_features]` | ۴ فیچر کارت |
| `product-page.php` | (بدون شورت‌کد) | **PDP کامل صفحه‌ی محصول — همین‌که عکس‌های توی چت را تشکیل می‌دهد.** با `template_include` کل صفحه را می‌رباید و با `alookhor_cc_pdp_markup()` رندر می‌کند؛ تابع واحد اصلی `alookhor_cc_pdp_markup()`؛ آیکون‌ها `alookhor_cc_pdp_icon()` CSS: `assets/css/frontend-product.css` |
| `cart-page.php` | بازنویسی `[woocommerce_cart]` | صفحه‌ی سبد خرید لوکس (template_include برای cart) |
| `about-page.php` | `[alookhor_about_page]` |
| `contact-page.php` | `[alookhor_contact_page]` |
| `app-banner.php` | `[alookhor_app_banner]` |
| `bestselling-products.php` | `[alookhor_bestselling_products]` |
| `campaign-slider.php` | `[alookhor_campaign_slider]` |
| `featured-products.php` | `[alookhor_featured_products]` |
| `newsletter.php` | `[alookhor_newsletter]` |
| `magazine.php` | `[alookhor_magazine]` |
| `international-standards.php` | `[alookhor_international_standards]` |
| `why-alookhor.php` | `[alookhor_why_alookhor]` |
| `shortcode-export-banner.php` | `[alookhor_export_banner]` |
| `updater.php` | — | منیفست آپدیت + Restore Activation بعد از خود-بازنویسی |
| `rest-api.php` | — | endpointهای `alookhor-cc/v1/*` (topbar hero site-features footer contact about pages product **install-update** …) |
| `ajax.php`, `admin.php`, `admin-pages.php`, `pages-settings.php`, `admin-export-banner.php`, `product-seeder.php`, `seo-cleaner.php`, `seo-meta.php`, `responsive-v2.php`, `sort-center.php` | — | بقیه‌ی ماژول‌ها |

### ۴.۳. CSS قوانین سیستم طراحی
- توکن‌ها: طلایی `#D49A2E` / `#f7b32b`, سطوح `#0D0510` (بن) / `#1C1024`, متن `#f5f3f0`, لوندر `#c8c2c9`
- فونت: **Vazirmatn** (+ `assets/fonts/*.woff2`)
- همه‌ی overrideهای صفحه‌ی محصول با `#alookhor-pdp` پرچم می‌شوند و دائماً `!important` دارند
- نکته‌ی بسیار مهم عربده‌ی bidi (این چت را نجات داد): **ارقام فارسی با جداکننده‌ی هزارگان «٬» (U+066C) در کانتینر RTL به‌صورت بصری به‌هم می‌ریزند** — همیشه روی قیمت‌ها:

```css
.price{ direction:ltr !important; unicode-bidi:isolate !important; display:inline-flex !important; }
```

### ۴.۴. متغیرهای تنظیمات (Database options)
- `alookhor_cc_settings` (main), `alookhor_header_settings` (header)
- ماژول‌ها پرچم enable/disable در admin دارند (17 ماژول)

---

## ۵. آناتومی دقیق جعبه‌ی خرید (PDP) — هر چیزی که در این چت ساخته شد

### ۵.۱. ساختار نهایی HTML (خروجی `alookhor_cc_pdp_markup()`)
```
<div class="product-panel">  (پنل راست)
  product-heading (h1 + متن)
  rating-row  (ستاره‌ها + علاقه‌مندی + اشتراک خطی)
  product-features (۴ کارت گرایینتی)
  price-box:
    ردیف اول: «قیمت محصول:» راست | نشان «XX٪ تخفیف» صورتی چپ
    ردیف دوم: قیمت طلایی بزرگ (وسط) + قیمت قدیمی خط‌خورده زیرش
  weight-qty-box / weight-picker: ۳ Pill برای وزن‌ها (فقط گرم/کیلو، بدون قیمت — per Screenshot 204335)
  purchase-actions:
    quantity-row  همه‌عرض: «تعداد :» راست / Stepper چپ
    cart-row: دکمه‌ی طلایی (flex-grow) سمت چپ + [قلب][مقایسه][اشتراک] مربع ۴۶px
    shipping-line: «موجود در انبار» چپ با نقطه‌ی سبز ضربان‌دار / «ارسال از ۱ روز کاری آینده» راست
  below-product: تب‌ها (توضیحات/مشخصات/روش مصرف/نظرات/سوالات) + پیشنهادها + خبرنامه
  alp-sticky: نوار چسبان پایین با قیمت + CTA
```

### ۵.۲. هر تغییری که این دوره اعمال شد (به ترتیب زمانی)
| تغییر | کجا | وضعیت لایو |
|---|---|---|
| کارت قیمت با نشان صورتی + قیمت طلایی ۳۴px + قدیم خط‌خورده راست | `frontend-product.css`→ rules زیر `#alookhor-pdp .price-box*` | ✅ |
| استپر سه‌تکه منسجم | `.quantity-control` pill | ✅ |
| CTA بزرگ طلایی + سه آیکون ۴۶px سمت راست آن (قلب-مقایسه-اشتراک) | بلوک `/* ===== OWNER FINAL LAYOUT …` انتهای `frontend-product.css` | ✅ |
| ردیف تعداد بالای دکمه، لیبل راست/استپر چپ در همان ردیف | همان بلوک | ✅ |
| «موجود در انبار» نقطه‌سبز **چپ** + ارسال **راست** | هم CSS (`.shipping-line{direction:ltr}` + order) و هم تعویض DOM در PHP (خط ۴۲۸ `product-page.php`) | ✅ |
| فیکس قاطع bidi برای قیمت‌ها | بلوک v3.10.303 انتهای همان CSS | ✅ |
| موبایل | سیستم قبلی فول‌ریسپانسیو است؛ icons در ≤640px از «display:none» احیای اکسیژن شدند | ✅ |

### ۵.۳. روش سریع برای هر تغییر آینده‌ی ظاهری روی PDO
۱) شات/لایو را بخوان ۲) فقط `plugin/alookhor-control-center/assets/css/frontend-product.css` را **در انتها** بلوک جدید بزن (با `!important` و سلکتورهای `#alookhor-pdp …`) — بازنویسی قابل‌مقایسه و برگشت‌پذیر است ۳) برای تغییر ترتیب DOM، `includes/product-page.php` را ویرایش کن ۴) QA: `generate_code_registry.py && --check` + `node --check assets/js/*` ۵) bump + tag + `gh run watch` + `publisher-status`.

---

## ۶. جریان کاری اتمی که خراب نشود (چک‌لیست برای چت بعدی)

```bash
cd /home/user/alookhor-update-publisher
# الف) همیشه از آخرین لایو شروع کن:
git fetch origin --tags
LATEST=$(git ls-remote --tags origin | grep -o "v3\.10\.[0-9]*$" | sort -V | tail -1)
git checkout $LATEST -- plugin release.json     # سوار شدن روی آخرین درختِ ریلیزشده
# ب) ویرایش‌ها
vim plugin/alookhor-control-center/assets/css/frontend-product.css
# ج) QA
python3 scripts/generate_code_registry.py && python3 scripts/generate_code_registry.py --check
for f in plugin/alookhor-control-center/assets/js/*.js; do node --check "$f"; done
# د) نسخه‌بندی در ۴ فایل + build
NEXT=$(($(git ls-remote --tags origin|grep -o "v3\.10\.[0-9]*$"|grep -o "[0-9]*$"|sort -n|tail -1)+1))
# → 3.10.$NEXT را در release.json / readme.txt / bootstrap php / config/site.json همان‌طور که در §۲.۱ گفته شد بنویس
python3 scripts/build_release.py && rm -rf public
# ه) کامیت+پوش+تگ
git add -A && git commit -m "…"
git push origin arena/<branch> --force-with-lease
git tag -a v3.10.$NEXT -m "…" && git push origin v3.10.$NEXT
# و) مانیتور
gh run watch … 
git fetch origin publisher-status && git show origin/publisher-status:latest.json
```

**قانون طلایی نبرد تگ:** برنچ‌ها را هرگز به برنچ دیگر merge/rebase نکنید برای انتشار؛ همیشه از تگِ آخرین نسخه‌یِ لایو شروع کنید و فقط «افزودنی» جلو بروید، تا هر دو جریانِ فعال هم‌پوشان شوند.

---

## ۷. قوانین غیرقابل‌نقض که در این چت از کاربر گرفته شد

1. **هیچ‌وقت** بدون اجازه‌ی صریح تگ/ریلیز نزنید (اما وقتی کاربر گفت «اعمال کن» — اعمال شد).
2. **هیچ‌وقت** رمز/توکن در کد/چت ذخیره نشود؛ Secrets = تنها مکان امن در GitHub → repo → Settings → Secrets → Actions.
3. هر تغییر PHP/CSS/JS نیازمند بازتولید `docs/MASTER_CODE_REGISTRY.md` است (`generate_code_registry.py` + `--check`) و گرنه CI registry-sync.
4. همیشه درخت را از آخرین تگ لایو سوار کن — **از صفر بازسازی ممنوع** (مگر کاربر بگوید «از صفر بساز»).
5. کاربر فارسی صحبت می‌کند → پاسخ فارسی؛ کامنت‌های کد انگلیسی حرفه‌ای.
6. قوانین طراحی Luxury Black/Gold (`#D49A2E`, سطوح `#0D0510/#1C1024`).
7. برای فایده‌ی واقعی کاربر: **پیش‌نمایش Arena ≠ پروداکشن**. پروداکشن فقط با ریلیز. هر بار بعد از دیپلوی بگو «Ctrl+Shift+R بزن چون کش هست».
8. اگر دو عامل موازی تگ می‌زنند، همیشه برنده عمومی = یک ابزار انتشار. به کاربر گوشزد شود جریان دوم را توقف کند.

---

## ۸. وضعیت فعلی (لحظه‌ی تحویل این سند)
- آخرین نسخه‌ی نصب‌شده و فعال روی alookhor.ir: **v3.10.312** (تأیید اتمیک از `publisher-status:latest.json`: `updated:true, active:true`)
- تکلیف‌مانده‌ی شناخته‌شده: تست `pdp_renders_authenticated` در فلوی نشر قرمز است (PDP برای یوزر لاگین‌شده همیشه رندر نمی‌شود) — اولویت بعدی.
- منبع حقیقت برای «الان سایت چی ران می‌شود»: برنچ `publisher-status` → `latest.json`.

---

## ۹. اسم کامل چیزهایی که هرگز به آنها دست نمی‌زنید مگر صریح گفته شود
- مسیرهای FTPS/پین گواهی در `publish.yml`
- منیفست فرمت (`public/manifest.json` توسط `build_release.py`)
- upgrader self-target در `updater.php` (Re-activation post-update)
- remove_shortcode های init:999 (الگوی refork برای ادعای ماژول‌های ما)
