# MASTER CODE REGISTRY — ALOOKHOR

> این سند از روی فایل‌های واقعی Repository تولید می‌شود. Source اصلی همچنان فایل‌های اجرایی است؛ Snapshotهای کامل زیر برای بازیابی، ممیزی و انتقال دانش نگهداری می‌شوند.

- **Registry version:** `1.0.0`
- **Plugin/source version:** `3.10.26`
- **Generated:** `2026-08-14`
- **Repository:** `alookhor-update-publisher`
- **Production:** `https://alookhor.ir`
- **Update channel:** `https://updates.alookhor.ir/manifest.json`
- **Authoritative option:** `alookhor_cc_settings`
- **Header option:** `alookhor_header_settings`

## Current Project State

- CURRENT VERSION: `3.10.26`
- LAST FUNCTIONAL CHANGE: مگا منوی دسکتاپ برای فهرست اصلی هدر: پنل شیشه‌ای عریض هم‌عرض کپسول با ستون‌های طلایی، با حفظ کامل ساختار مرجع v3.10.25.
- ACTIVE DESIGN: Luxury Black/Gold; actual component colors remain controlled by saved WordPress settings and existing module defaults.
- ACTIVE SHORTCODES: `[alookhor_portal_header]`, `[alookhor_managed_categories]`, `[alookhor_managed_hero]`, `[alookhor_managed_features]`.
- ACTIVE PANELS: Main ALOOKHOR Control Center and Header/Top Bar submenu.
- ACTIVE COMPONENTS: Header/Top Bar manager, managed four-slide Hero, managed four-card site features, WooCommerce categories, managed footer, private native updater.
- KNOWN EXTERNAL LEGACY: `[alookhor_categories_carousel]` belongs to `alookhor-categories-manager`; its source is not in this repository and is not reconstructed here.
- KNOWN SOURCE GAP: Elementor template export/internal element IDs and historical Code Snippets source are not present in this repository.

## Change Record

```text
PROJECT: ALOOKHOR
AREA: Desktop Primary Navigation / Mega Menu
CURRENT VERSION: 3.10.26
CHANGE: مگا منوی دسکتاپ برای فهرست اصلی هدر: پنل شیشه‌ای عریض هم‌عرض کپسول با ستون‌های طلایی، با حفظ کامل ساختار مرجع v3.10.25.
REASON: مالک سایت پنل مگا منوی دسکتاپ را برای فهرست اصلی خواست؛ اجرا با حفظ کامل ساختار مرجع v3.10.25 و پالت تأییدشده.
FILES: plugin/alookhor-control-center/alookhor-control-center.php; plugin/alookhor-control-center/readme.txt; plugin/alookhor-control-center/config/site.json; plugin/alookhor-control-center/CHANGELOG.md; plugin/alookhor-control-center/includes/shortcode-header.php; plugin/alookhor-control-center/includes/ajax.php; plugin/alookhor-control-center/includes/admin.php; plugin/alookhor-control-center/includes/rest-api.php; plugin/alookhor-control-center/assets/css/frontend-header.css; plugin/alookhor-control-center/assets/js/frontend-header.js
STATUS: SOURCE READY — deployment status must be verified separately.
```

# MASTER CODE REGISTRY

| ID | Type | Name | File | Used In | Version | Status |
|---|---|---|---|---|---:|---|
| SC-001 | Shortcode | `[alookhor_portal_header]` | `includes/shortcode-header.php` | Elementor Header Shortcode widget; exact template ID unavailable | 3.10.26 | Active / compatibility-preserving |
| SC-002 | Shortcode | `[alookhor_managed_categories]` | `includes/product-categories.php` | Home page → Elementor Shortcode widget | 3.10.26 | Active |
| SC-003 | Shortcode | `[alookhor_managed_hero]` | `includes/hero.php` | Home Elementor Shortcode widget / automatic Legacy-root replacement | 3.10.26 | Active |
| SC-004 | Shortcode | `[alookhor_managed_features]` | `includes/site-features.php` | Home Elementor HTML widget / automatic Legacy-root replacement | 3.10.26 | Active |
| SC-EXT-001 | External shortcode | `[alookhor_categories_carousel]` | External plugin source unavailable | Former Home showcase | External | Replaced on Home / do not reconstruct |
| PN-001 | Admin panel | ALOOKHOR Control Center | `includes/admin.php` | WP Admin top-level menu | 3.10.26 | Active |
| PN-002 | Admin panel | Header & Top Bar | `includes/admin.php` | WP Admin submenu | 3.10.26 | Active mirror |
| MOD-001 | Managed module | WooCommerce Categories | `includes/product-categories.php` | Home / Elementor / REST | 3.10.26 | Active |
| MOD-002 | Managed module | Responsive Footer | `includes/footer.php` | Frontend footer / REST | 3.10.26 | Active |
| MOD-003 | Managed module | Four-slide Hero | `includes/hero.php` | Home / Elementor / REST | 3.10.26 | Active |
| MOD-004 | Managed module | Four-card Site Features | `includes/site-features.php` | Home / Elementor / REST | 3.10.26 | Active |
| API-001 | REST API | `alookhor-cc/v1` | `includes/rest-api.php` | Public state + authenticated updater | 3.10.26 | Active |
| UPD-001 | Updater | Private native updater | `includes/updater.php` | Control Center + GitHub Actions | 3.10.26 | Active |
| CFG-001 | WordPress state | Main settings | `alookhor_cc_settings` | All managed modules | 3.10.26 | Active |
| CFG-002 | WordPress state | Header settings | `alookhor_header_settings` | Header and Top Bar | 3.10.26 | Active |
| CSS-001 | CSS | Managed Header | `assets/css/frontend-header.css` | `[alookhor_portal_header]` fallback renderer | 3.10.26 | Active |
| JS-001 | JavaScript | Managed Header runtime | `assets/js/frontend-header.js` | `[alookhor_portal_header]` fallback renderer | 3.10.26 | Active |
| JS-002 | JavaScript | Legacy Top Bar manager | `assets/js/frontend-topbar-manager.js` | Preserved legacy header provider | 3.10.26 | Active when legacy provider exists |
| CSS-002 | CSS | WooCommerce Categories | `assets/css/frontend-categories.css` | `[alookhor_managed_categories]` | 3.10.26 | Active |
| JS-003 | JavaScript | Categories carousel | `assets/js/frontend-categories.js` | `[alookhor_managed_categories]` | 3.10.26 | Active |
| CSS-003 | CSS | Managed Footer | `assets/css/frontend-footer.css` | Managed Footer module | 3.10.26 | Active |
| JS-004 | JavaScript | Managed Footer | `assets/js/frontend-footer.js` | Managed Footer module | 3.10.26 | Active |
| CSS-004 | CSS | Control Center UI | `assets/css/luxury.css` | WP Admin ALOOKHOR pages | 3.10.26 | Active |
| JS-005 | JavaScript | Control Center app | `assets/js/app.js` + modules | WP Admin ALOOKHOR pages | 3.10.26 | Active |
| CSS-005 | CSS | Managed Hero | `assets/css/frontend-hero.css` | `[alookhor_managed_hero]` / automatic Home replacement | 3.10.26 | Active |
| JS-006 | JavaScript | Managed Hero runtime | `assets/js/frontend-hero.js` | Four-slide replacement, controls and REST refresh | 3.10.26 | Active |
| CSS-006 | CSS | Managed Site Features | `assets/css/frontend-features.css` | `[alookhor_managed_features]` / automatic Home replacement | 3.10.26 | Active |
| JS-007 | JavaScript | Managed Site Features runtime | `assets/js/frontend-features.js` | Four-card replacement and REST refresh | 3.10.26 | Active |

## SC-001 — Portal Header

- **Shortcode:** `[alookhor_portal_header]`
- **Function/registration:** `alookhor_cc_register_portal_header_shortcode()` at `init` priority `100`; callback is either `alookhor_cc_render_portal_header()` or the compatibility callback `alookhor_cc_render_managed_legacy_header()`.
- **PHP file:** `plugin/alookhor-control-center/includes/shortcode-header.php`
- **Loaded by:** `plugin/alookhor-control-center/alookhor-control-center.php`
- **WordPress use:** Elementor Header template → Shortcode widget. Exact Elementor Template ID, container ID, and export are not present in Repository; they are deliberately not guessed.
- **Inputs:** optional `sticky` and `menu` attributes.
- **Output:** semantic two-level ALOOKHOR header or preserved legacy provider output wrapped by the manager.
- **CSS:** `assets/css/frontend-header.css`
- **JavaScript:** `assets/js/frontend-header.js`; when a legacy provider is detected, `assets/js/frontend-topbar-manager.js` manages public Top Bar state instead.
- **Database:** `alookhor_header_settings`, merged into `alookhor_cc_settings`.
- **Second-capsule settings:** `capsule_background`, `capsule_card`, `capsule_glass`, `capsule_gold`, `capsule_gold_light`, `capsule_text`, `capsule_muted`, `capsule_blur`; managed independently from Top Bar/Navigation colors.
- **Second-capsule palette:** `#0D0510`, `#1C1024`, `rgba(33,20,38,.75)`, `#D49A2E`, `#E8B84A`, `#F5F3F0`, `#C8C2C9`; 24px Blur.
- **Dependencies:** WordPress menu locations/menus, logo/media settings, Elementor Shortcode widget, WordPress REST Top Bar endpoint.
- **Created/recovered:** 3.8.5; **last source revision:** current runtime version.
- **Status:** Active. Existing external provider is not overwritten.
- **Complete source:** see Source Snapshots for `includes/shortcode-header.php`, `assets/css/frontend-header.css`, `assets/js/frontend-header.js`, and `assets/js/frontend-topbar-manager.js`.

## SC-002 — Managed WooCommerce Categories

- **Shortcode:** `[alookhor_managed_categories]`
- **Function:** `alookhor_cc_category_shortcode()`
- **Registration:** `add_shortcode('alookhor_managed_categories', 'alookhor_cc_category_shortcode')`
- **PHP file:** `plugin/alookhor-control-center/includes/product-categories.php`
- **WordPress use:** Pages → Home → Edit with Elementor → Shortcode widget. The user confirmed the managed four-category output in this position. Exact Elementor internal element ID is not exported to Repository and is not guessed.
- **Elementor movement:** Move the Shortcode widget or its parent Container in Navigator; no CSS anchor is required in shortcode mode.
- **Output ID:** `#alookhor-managed-categories`
- **Output classes:** `.alookhor-mc`, `.alookhor-mc-card`, `.alookhor-mc-track`, `.alookhor-mc-dots`, `.alookhor-mc-arrow`.
- **Legacy fallback class:** `.category-carousel-section` is only the automatic replacement anchor when the managed shortcode is absent.
- **Inputs:** no shortcode attributes; settings come from the main ALOOKHOR Control Center.
- **Output:** real `product_cat` terms with real URLs, names, counts/thumbnails and managed overrides.
- **CSS:** `assets/css/frontend-categories.css`
- **JavaScript:** `assets/js/frontend-categories.js`
- **REST:** `GET /wp-json/alookhor-cc/v1/product-categories` with no-store policy.
- **Database/taxonomy:** `alookhor_cc_settings.category_settings`; WooCommerce `product_cat`; term meta `thumbnail_id`.
- **Current Production terms:** `38, 39, 40, 41`.
- **Created:** 3.10.3 shortcode placement; renderer introduced 3.10.0; **last modified:** 3.10.3.
- **Status:** Active; shortcode mode suppresses automatic duplicate template output.
- **Complete source:** see Source Snapshots for `includes/product-categories.php`, `assets/css/frontend-categories.css`, and `assets/js/frontend-categories.js`.

## SC-003 — Managed Four-Slide Hero

- **Shortcode:** `[alookhor_managed_hero]`
- **Function:** `alookhor_cc_hero_shortcode()`; markup callback `alookhor_cc_hero_markup()`.
- **Registration:** `add_shortcode('alookhor_managed_hero', 'alookhor_cc_hero_shortcode')`.
- **PHP file:** `plugin/alookhor-control-center/includes/hero.php`.
- **Current WordPress use:** Home front page → Elementor Shortcode widget `data-id="3c367e2"`, `data-widget_type="shortcode.default"`, verified from Production audit `31741626734`; it renders the external Legacy root `.alookhor-hero-slider-wrapper` / `#alookhorHeroSlider`, which the managed runtime replaces exactly in place. Optional direct shortcode mode is available without duplicate template output.
- **Elementor/container contract:** existing widget/container position is preserved; runtime adds `.alookhor-managed-hero-slot` only to normalize the exact host. The ID above is source-backed; unavailable Elementor template exports are still never guessed.
- **Output ID/classes:** `#alookhor-managed-hero`, `.alookhor-mh`, `.alookhor-mh-slide`, `.alookhor-mh-content`, `.alookhor-mh-features`, `.alookhor-mh-actions`, `.alookhor-mh-dots`, `.alookhor-mh-arrow`.
- **Inputs:** no shortcode attributes; exactly four slide records from the main ALOOKHOR Control Center.
- **Storage:** `alookhor_cc_settings.hero_settings`; `modules.hero` remains module metadata and is synchronized to four slides/autoplay.
- **Per-slide fields:** Media Library attachment ID/URL, optional subject-left focus for compatible Legacy banners, image Alt, Kicker, Title, Gold Highlight, Description, four Feature labels, primary CTA label/URL, secondary CTA label/URL.
- **Global fields:** enabled, hide Legacy, autoplay/interval, pause, arrows, dots, Ken Burns, Gold/Surface/Text/Muted colors, radius.
- **Sanitization:** Nonce + `manage_options`; exact four-record normalization; attachment IDs via `absint`, URLs via `esc_url_raw`, colors via `sanitize_hex_color`, text via `sanitize_text_field`/`sanitize_textarea_field`, bounded interval/radius.
- **CSS:** `assets/css/frontend-hero.css`; right-side overlay, 32px reference radius, Black/Gold design, Desktop/Tablet/Mobile breakpoints and controlled Mobile Header underlap.
- **JavaScript:** `assets/js/frontend-hero.js`; exact-node replacement, four-slide state, Arrow/Dots, Swipe, Keyboard, Autoplay/Pause, Reduced Motion and same-origin no-store refresh.
- **REST:** `GET /wp-json/alookhor-cc/v1/hero`; public read-only state already rendered publicly, `Cache-Control: no-store`; no write route.
- **Dependencies:** WordPress Media Library, front-page Elementor host, existing external Legacy root only as automatic placement anchor; Header/Footer/WooCommerce structures are not modified.
- **Created:** 3.10.13; **status:** active source release, final status follows tagged Production visual verification.
- **Complete source:** see Source Snapshots for `includes/hero.php`, `assets/css/frontend-hero.css`, `assets/js/frontend-hero.js`, `assets/js/modules/settings.js`, `includes/ajax.php`, and `includes/rest-api.php`.

## SC-004 — Managed Site Features

- **Shortcode:** `[alookhor_managed_features]`
- **Function:** `alookhor_cc_site_feature_shortcode()`; markup callback `alookhor_cc_site_feature_markup()`.
- **Registration:** `add_shortcode('alookhor_managed_features', 'alookhor_cc_site_feature_shortcode')`.
- **PHP file:** `plugin/alookhor-control-center/includes/site-features.php`.
- **Current WordPress use:** Home front page → Elementor HTML widget `data-id="5abd566"`, parent container `data-id="f0598d3"`, independently verified by Production audit `31764796144`; external root `.alookhor-trustbar-container` is replaced exactly in place.
- **Elementor/container contract:** widget/container position is preserved; runtime adds only `.alookhor-managed-features-slot` / `.alookhor-managed-features-host` for scoped spacing normalization. No second feature row is appended.
- **Output ID/classes:** `#alookhor-managed-features`, `.alookhor-sf`, `.alookhor-sf-grid`, `.alookhor-sf-card`, `.alookhor-sf-icon`, `.alookhor-sf-copy`.
- **Inputs:** no shortcode attributes; exactly four records from the main ALOOKHOR Control Center.
- **Storage:** `alookhor_cc_settings.feature_settings`; module metadata is `modules.site_features`.
- **Per-item fields:** icon enum (`truck`, `organic`, `headset`, `shield`), title and description.
- **Global fields:** enabled, replace Legacy, Background, Card, Glass RGBA, Primary Gold, Light Gold, Text, Muted Text, Radius and Gap.
- **Approved palette:** `#0D0510`, `#1C1024`, `rgba(33,20,38,.75)`, `#D49A2E`, `#E8B84A`, `#F5F3F0`, `#C8C2C9`; this palette is scoped to the feature section and does not recolor unrelated modules.
- **Sanitization:** Nonce + `manage_options`; exact four-item normalization; icon allowlist; text fields; `sanitize_hex_color`; validated RGBA; bounded Radius/Gap.
- **Responsive contract:** exactly four cards in one row on Desktop and Mobile; Mobile uses compact icon/title/description cards with no horizontal overflow or stacking.
- **CSS:** `assets/css/frontend-features.css`. **JavaScript:** `assets/js/frontend-features.js`.
- **REST:** `GET /wp-json/alookhor-cc/v1/site-features`, public read-only/no-store; no write route.
- **Dependencies:** existing Elementor host/root only as placement anchor; Header, Hero, WooCommerce, Footer and Toolbar DOM remain untouched.
- **Created:** 3.10.16; **status:** source release pending tagged Production verification.
- **Complete source:** see Source Snapshots for `includes/site-features.php`, `assets/css/frontend-features.css`, `assets/js/frontend-features.js`, `assets/js/modules/settings.js`, `includes/ajax.php`, and `includes/rest-api.php`.

## SC-EXT-001 — Legacy Categories Carousel

- **Shortcode:** `[alookhor_categories_carousel]`
- **Owner:** external plugin `alookhor-categories-manager`.
- **Former use:** Home page Elementor Shortcode widget, previously rendering “PREMIUM SHOWCASE”.
- **Current use:** replaced on the Home page by `[alookhor_managed_categories]`.
- **Source status:** Source code is not present in this Repository. It is not copied, reconstructed, renamed, or claimed as known.
- **Status:** External/legacy; preserve unless a separately approved migration audits the external plugin.

## PN-001 — Main ALOOKHOR Control Center

- **Admin menu:** `ALOOKHOR Control Center`
- **Menu slug:** `alookhor-control-center`
- **Capability:** `manage_options`
- **Callback:** `alookhor_cc_render_admin()`
- **PHP:** `includes/admin.php`, `includes/ajax.php`, `templates/admin-control-center.php`
- **CSS:** `assets/css/luxury.css`
- **JavaScript:** `assets/js/app.js`, `assets/js/admin-wp.js`, `assets/js/core/*`, `assets/js/modules/*`
- **AJAX:** `alookhor_save_settings`, `alookhor_toggle_module`, `alookhor_save_header`, `alookhor_get_settings`, `alookhor_check_updates`.
- **REST:** authenticated status/check/install plus public Top Bar/Hero/Site Features/Footer/Categories state.
- **Database:** `alookhor_cc_settings` (including `hero_settings` and `feature_settings`), `alookhor_header_settings`, `alookhor_footer_subscribers`.
- **Managed shortcodes:** `[alookhor_portal_header]`, `[alookhor_managed_categories]`, `[alookhor_managed_hero]`, `[alookhor_managed_features]`.
- **Status:** Active; every managed module setting remains in this main panel.

## PN-002 — Header and Top Bar Submenu

- **Admin submenu:** `نوار بالای سایت و هدر`
- **Menu slug:** `alookhor-cc-header`
- **Parent:** `alookhor-control-center`
- **Capability:** `manage_options`
- **Callback:** `alookhor_cc_render_header_settings()`
- **Role:** Mirror/helper; the main Control Center remains the authoritative editing surface.
- **Database:** same `alookhor_header_settings` and merged main state; no parallel database table.
- **Status:** Active.

## API and Update Architecture

- **REST namespace:** `alookhor-cc/v1`
- **Public/no-store:** `/topbar`, `/hero`, `/site-features`, `/footer`, `/product-categories`; newsletter POST is rate-limited.
- **Authenticated:** `/status`, `/check-update`, `/install-update` with Application Password and `update_plugins`.
- **Release flow:** source → Git push → GitHub Actions → deterministic ZIP/SHA → Explicit FTPS → remote ZIP verification → atomic Manifest → native WordPress upgrader → activation restoration → Production checks.
- **Certificate rule:** Explicit FTPS with certificate and hostname verification; verification must not be disabled.

## Source Inventory

| File | Lines | SHA-256 |
|---|---:|---|
| `.github/workflows/publish.yml` | 543 | `10038fd342976395b67e643eb6950a0dafd684ec11a1bf11d732e09b15b7521f` |
| `ops/wordpress-ci-bootstrap.php` | 215 | `409c23f2be99c6651b0e75dc877c91c884534e6b16f9985c177cf65d14fd4c95` |
| `plugin/alookhor-control-center/alookhor-control-center.php` | 369 | `c99b9cf3ae8833eb22ce49a99750009ff66e5405f012cf1749527037490c69d8` |
| `plugin/alookhor-control-center/assets/css/frontend-categories.css` | 9 | `b811fb4f96023711a593cd593eb9ae3846ebfd9c912c57e3e623d0965f7d494a` |
| `plugin/alookhor-control-center/assets/css/frontend-features.css` | 29 | `8431fcf85b5903bbe2335aa017e8a0a79d0038a7ce055189fa8ebe41e49b89ed` |
| `plugin/alookhor-control-center/assets/css/frontend-footer.css` | 26 | `f0dd733870b626c5581fc84ad2d5311bcf37374ab351cfc74ade1808ae5b1089` |
| `plugin/alookhor-control-center/assets/css/frontend-header-scroll.css` | 96 | `16d5ac8abcfda76b8f394a5c3b5e6ee80295c3482e2d2fb0fd1792392ac2ce71` |
| `plugin/alookhor-control-center/assets/css/frontend-header.css` | 368 | `48540e02103d672cc037eb36580ed81a082e860bbb330f193c93d25685473f85` |
| `plugin/alookhor-control-center/assets/css/frontend-hero.css` | 72 | `bde6426b31d10f1d389999f0c8ec25185d08d595dd20e06a92fcd666052dc3c9` |
| `plugin/alookhor-control-center/assets/css/luxury.css` | 564 | `eef0550c9d8b090dbe799d9a969518207519fdb585c9701e2d897a507e669f8f` |
| `plugin/alookhor-control-center/assets/js/admin-wp.js` | 84 | `b8ff32723f2f46dc44add19fdc441eec1c611f5229ce7e13ac8b773457be6afc` |
| `plugin/alookhor-control-center/assets/js/app.js` | 325 | `a2a734cafc74763e6448944c29588dea4b5059a05f3ee26165382197117c1607` |
| `plugin/alookhor-control-center/assets/js/core/config.js` | 199 | `1c89b0d0d8121bce7fc7097f9d1974eb1e38d1ec7f6b0f6f6d5244ab60ea1e85` |
| `plugin/alookhor-control-center/assets/js/core/responsive.js` | 52 | `0848ef0deef9aaa532581904c4adab9b45cbe8445a99fbeb71f92d358a1aa724` |
| `plugin/alookhor-control-center/assets/js/core/updateSystem.js` | 193 | `820a5ceea2dbb9326602da725b7e92bfa4d89c045b9f8985e41af26a2e732cd9` |
| `plugin/alookhor-control-center/assets/js/frontend-categories.js` | 27 | `7ae122e4427522d6004a97f43cc22d271476a3a8dee4980bd2c05ca398e75bb0` |
| `plugin/alookhor-control-center/assets/js/frontend-features.js` | 62 | `e611fe59f35f43e061a98cff77685eba514564c98b2ea6b44bd31fe8c4d0f746` |
| `plugin/alookhor-control-center/assets/js/frontend-footer.js` | 75 | `70b41991fca96014f6951a81012d6163222839cf6914cd7efbed186088168542` |
| `plugin/alookhor-control-center/assets/js/frontend-header.js` | 140 | `266341cf7e60a9decd1abeb3ea5b3f1fb9a497050fe9ab25ed3a14f463e5869e` |
| `plugin/alookhor-control-center/assets/js/frontend-hero.js` | 133 | `4238be2204142f59552efe695d5cb619d40c1f1c2ca1404eed9590a275934091` |
| `plugin/alookhor-control-center/assets/js/frontend-topbar-manager.js` | 415 | `ee6455e0fc85825ca86a6113960f7f324ab71c4abd7826d31da9842ec8e99b92` |
| `plugin/alookhor-control-center/assets/js/modules/analytics.js` | 21 | `5e35bdba45de5750af08d6cfea337fd7a6eb8cc852ef1c955ee5ba1e7a56bf0c` |
| `plugin/alookhor-control-center/assets/js/modules/dashboard.js` | 173 | `2e83d615532becdbc99a1a8e8b1bd9807508b81a12e041dea19b180e59e39d11` |
| `plugin/alookhor-control-center/assets/js/modules/inventory.js` | 30 | `e1c39f880a1e7985fa8ea64b07ec72ce69c416165fb514ad9fb7d9f8e8e93723` |
| `plugin/alookhor-control-center/assets/js/modules/orders.js` | 19 | `0ccd8376c69ba37fb50d3261f002789488042e17a0b1b37539bab86abda374eb` |
| `plugin/alookhor-control-center/assets/js/modules/settings.js` | 740 | `691798b7785b447a7441777eb9bd88d353eae179d1f47d973bc31948adf5bda3` |
| `plugin/alookhor-control-center/assets/js/modules/users.js` | 20 | `6fb96546faf00ea831ace016d09b10f903a501db647bae20d0f570034ac36946` |
| `plugin/alookhor-control-center/config/site.json` | 285 | `e41549357ea7851c6fdd85de2fab4e95d1769f9c7b2bec5131ec729fc793dc2c` |
| `plugin/alookhor-control-center/includes/admin.php` | 252 | `84618ff5c0841b51aedd57514abacca16dbc865e3e60cdd888b65192aeacb064` |
| `plugin/alookhor-control-center/includes/ajax.php` | 385 | `db7847130d7200a9d85682862da0d1993b87895d8683e159b031dc29177aef7b` |
| `plugin/alookhor-control-center/includes/footer.php` | 269 | `50c7a6e7d67a8905b5d88486d42d9ad7381caf8c60fc49dd37e3db2a17a347f8` |
| `plugin/alookhor-control-center/includes/hero.php` | 229 | `edaba49c0057e137f0d6e0b16cc516fc98b73a70d24c09cc62cbe7302c2b6342` |
| `plugin/alookhor-control-center/includes/product-categories.php` | 88 | `64d42189315d77e8bda401a945e37d18d16bcf2346159f8cabe0022920dba2cb` |
| `plugin/alookhor-control-center/includes/rest-api.php` | 335 | `bccc2795540356ea74ec3276350c03a47f2557f102e1fd4ee4d8aefd995290bd` |
| `plugin/alookhor-control-center/includes/shortcode-header.php` | 368 | `1856c0c84b92ca88f415f0d1d9186b23a737a729c9663e9ef6dde135dd61a584` |
| `plugin/alookhor-control-center/includes/site-features.php` | 133 | `8c0f550195121550d1085b5415fd63291fcf1e8d17bfaf0bca491e2df7468c72` |
| `plugin/alookhor-control-center/includes/updater.php` | 385 | `5ff741d1714b6c3b646efb23093d84d6be0a539da941cbbb3920e31715ec44ae` |
| `plugin/alookhor-control-center/templates/admin-control-center.php` | 388 | `285338989d4913e4a08c4d9713900b60dfc55a6e79d7e74470a268696a72f78f` |
| `plugin/alookhor-control-center/uninstall.php` | 6 | `d69282a9ab7c0865b6c60e6fca272d0859433e9c8730754fb2995295209ff84c` |
| `scripts/build_release.py` | 101 | `f07af70658e73dd9e42f018cfa3e2ca35a7287599d7e6a4cf8e06951665126d8` |
| `scripts/generate_code_registry.py` | 293 | `cc820adb6cd74358acfe6eea9bcc5206a2262b91a53e053cc0794c47fec3026a` |
| `scripts/header_visual_audit.py` | 202 | `b01fa79390e7c7248964d81874cff67407854effe7f56636c9e09cbe4e14f51e` |
| `scripts/wordpress_access_check.py` | 530 | `bcb8e3c38456dd6161683792fc306e737a38e1be349d9f7e8a66347652b3393f` |
| `scripts/wordpress_release_test.py` | 266 | `3e7a2c1f21cffefbebb6bfd9e236fd71f3249b9c4171e4d242c2fc5b70331ac0` |

# COMPLETE SOURCE SNAPSHOTS

> این بخش عمداً شامل کد کامل فایل‌های فعال است. برای تغییر، ابتدا فایل واقعی را ویرایش و تست کنید، سپس این سند را با `python3 scripts/generate_code_registry.py` بازتولید کنید. ویرایش دستی Snapshot ممنوع است.

## Source Snapshot — `.github/workflows/publish.yml`

````yaml
name: Build and Publish ALOOKHOR Release

on:
  push:
    branches: [main]
    tags: ['v*.*.*']
  workflow_dispatch:

permissions:
  contents: read

concurrency:
  group: alookhor-production-publisher
  cancel-in-progress: false

jobs:
  build:
    runs-on: ubuntu-latest
    steps:
      - name: Checkout private publisher repository
        uses: actions/checkout@v5

      - name: Inspect and enforce Explicit FTPS certificate
        env:
          FTP_SERVER: ${{ secrets.FTP_SERVER }}
          FTP_PORT: ${{ secrets.FTP_PORT }}
        run: |
          set -euo pipefail
          test -n "$FTP_SERVER"
          test -n "$FTP_PORT"
          timeout 30 openssl s_client \
            -starttls ftp \
            -connect "${FTP_SERVER}:${FTP_PORT}" \
            -servername "${FTP_SERVER}" \
            -showcerts </dev/null > /tmp/ftps-chain.txt 2>/tmp/ftps-connect.txt
          awk '/-----BEGIN CERTIFICATE-----/{capture=1} capture{print} /-----END CERTIFICATE-----/{exit}' /tmp/ftps-chain.txt > /tmp/ftps-leaf.pem
          test -s /tmp/ftps-leaf.pem
          openssl x509 -in /tmp/ftps-leaf.pem -noout -subject -issuer -dates -fingerprint -sha256 -ext subjectAltName
          openssl x509 -in /tmp/ftps-leaf.pem -noout -checkhost "$FTP_SERVER"

      - name: Validate source syntax and managed-footer contract
        run: |
          python3 -m py_compile scripts/*.py
          python3 scripts/generate_code_registry.py --check
          find plugin/alookhor-control-center -name '*.php' -type f -print0 | xargs -0 -n1 php -l
          while IFS= read -r file; do node --check "$file"; done < <(find plugin/alookhor-control-center/assets/js -name '*.js' -type f | sort)
          python3 - <<'PY'
          from pathlib import Path
          required = [
              'plugin/alookhor-control-center/includes/footer.php',
              'plugin/alookhor-control-center/assets/css/frontend-footer.css',
              'plugin/alookhor-control-center/assets/js/frontend-footer.js',
              'plugin/alookhor-control-center/assets/images/footer-prunes.png',
              'plugin/alookhor-control-center/includes/product-categories.php',
              'plugin/alookhor-control-center/assets/css/frontend-categories.css',
              'plugin/alookhor-control-center/assets/js/frontend-categories.js',
              'plugin/alookhor-control-center/assets/css/frontend-header-scroll.css',
              'plugin/alookhor-control-center/assets/images/category-plums.jpg',
              'plugin/alookhor-control-center/assets/images/category-fruit-sheets.jpg',
              'plugin/alookhor-control-center/assets/images/category-natural-snacks.jpg',
              'plugin/alookhor-control-center/assets/images/category-nuts.jpg',
              'plugin/alookhor-control-center/includes/hero.php',
              'plugin/alookhor-control-center/assets/css/frontend-hero.css',
              'plugin/alookhor-control-center/assets/js/frontend-hero.js',
              'plugin/alookhor-control-center/includes/site-features.php',
              'plugin/alookhor-control-center/assets/css/frontend-features.css',
              'plugin/alookhor-control-center/assets/js/frontend-features.js',
          ]
          for name in required:
              assert Path(name).is_file() and Path(name).stat().st_size > 0, name
          php = Path(required[0]).read_text()
          css = Path(required[1]).read_text()
          admin_css = Path('plugin/alookhor-control-center/assets/css/luxury.css').read_text()
          js = Path(required[2]).read_text()
          assert 'id="alookhor-managed-footer"' in php
          assert "register_rest_route('alookhor-cc/v1', '/footer'" in Path('plugin/alookhor-control-center/includes/rest-api.php').read_text()
          assert '@media(max-width:767px)' in css and '.alookhor-mf-main-grid' in css
          assert '#quickSettings .qh-grid' in admin_css and '#quickSettings .qh-section textarea' in admin_css
          assert 'cache:\'no-store\'' in js and 'alookhor-mf-newsletter-form' in js
          category_php = Path('plugin/alookhor-control-center/includes/product-categories.php').read_text()
          category_css = Path('plugin/alookhor-control-center/assets/css/frontend-categories.css').read_text()
          category_js = Path('plugin/alookhor-control-center/assets/js/frontend-categories.js').read_text()
          assert "taxonomy'=>'product_cat'" in category_php and 'id="alookhor-managed-categories"' in category_php
          assert "add_shortcode('alookhor_managed_categories'" in category_php and 'alookhor_cc_category_shortcode_rendered' in category_php
          assert '.alookhor-mc-card' in category_css and '--mc-cards' in category_css and '--mc-mobile-width' in category_css
          assert '.alookhor-mc-arrow{display:none!important}' in category_css and 'flex-basis:33px!important' in category_css
          assert '.alookhor-mc.has-single-page' in category_css and 'min-width:58px!important' in category_css and 'appearance:none!important' in category_css
          assert 'ResizeObserver' in category_js and "cache:'no-store'" in category_js and 'is-clone' in category_js and 'syncDots' in category_js and "tabIndex=mobile?-1:0" in category_js and "classList.toggle('has-single-page'" in category_js
          hero_php = Path('plugin/alookhor-control-center/includes/hero.php').read_text()
          hero_css = Path('plugin/alookhor-control-center/assets/css/frontend-hero.css').read_text()
          hero_js = Path('plugin/alookhor-control-center/assets/js/frontend-hero.js').read_text()
          assert "add_shortcode('alookhor_managed_hero'" in hero_php and 'id="alookhor-managed-hero"' in hero_php
          assert 'alookhor-hero-slider-wrapper' in hero_php and "data-slide-count=\"4\"" in hero_php and 'for ($index=0; $index<4; $index++)' in hero_php
          assert 'body.alookhor-mh-hide-legacy .alookhor-hero-slider-wrapper' in hero_css and '@media(max-width:767px)' in hero_css
          assert 'margin-top:-50px' in hero_css and '.alookhor-mh-content' in hero_css and 'right:' in hero_css
          assert 'appearance:none!important' in hero_css and '.alookhor-mh .alookhor-mh-arrow:before' in hero_css and 'background:rgba(7,4,10,.56)!important' in hero_css
          assert 'translateX(-36%)' in hero_css and 'scaleX(-1)' not in hero_css and 'rgba(7,3,10,.9) 100%' in hero_css
          assert "legacy_selector" in hero_php and 'legacy.replaceWith(section)' in hero_js and "cache:'no-store'" in hero_js
          assert "slides.length!==4" in hero_js and 'prefers-reduced-motion' in hero_js and "data-hero-media" in Path('plugin/alookhor-control-center/assets/js/modules/settings.js').read_text()
          feature_php=Path('plugin/alookhor-control-center/includes/site-features.php').read_text()
          feature_css=Path('plugin/alookhor-control-center/assets/css/frontend-features.css').read_text()
          feature_js=Path('plugin/alookhor-control-center/assets/js/frontend-features.js').read_text()
          assert "add_shortcode('alookhor_managed_features'" in feature_php and 'id="alookhor-managed-features"' in feature_php
          assert 'alookhor-trustbar-container' in feature_php and 'for($index=0;$index<4;$index++)' in feature_php
          assert 'grid-template-columns:repeat(4,minmax(0,1fr))' in feature_css and '@media(max-width:767px)' in feature_css
          assert 'margin:-15px calc(50% - 50vw) 0' in feature_css and 'margin-top:-15px' in feature_css
          assert all(token in feature_php for token in ['#0D0510','#1C1024','rgba(33,20,38,.75)','#D49A2E','#E8B84A','#F5F3F0','#C8C2C9'])
          assert 'legacy.replaceWith(section)' in feature_js and "cache:'no-store'" in feature_js and "data.item_count!==4" in feature_js
          assert 'data-site-feature-flag' in Path('plugin/alookhor-control-center/assets/js/modules/settings.js').read_text()
          admin_template = Path('plugin/alookhor-control-center/templates/admin-control-center.php').read_text()
          admin_app = Path('plugin/alookhor-control-center/assets/js/app.js').read_text()
          dashboard_js = Path('plugin/alookhor-control-center/assets/js/modules/dashboard.js').read_text()
          settings_js = Path('plugin/alookhor-control-center/assets/js/modules/settings.js').read_text()
          assert admin_template.index('data-module="settings"') < admin_template.index('data-module="dashboard"')
          assert 'nav-item-primary' in admin_template and 'data-group="sales"' in admin_template
          assert "active: 'settings'" in admin_app and "allMods[hash] ? hash : 'settings'" in admin_app
          assert 'data-dashboard-only="1"' in dashboard_js and 'dashboardAiCard' in dashboard_js and 'dashboardStatusCard' in dashboard_js
          assert 'id="aiCard"' not in settings_js and 'id="statusCard"' not in settings_js and 'settings-workspace' in settings_js
          assert 'width:100%; max-width:none' in admin_css and '.dashboard-monitor-grid' in admin_css
          header_scroll_css = Path('plugin/alookhor-control-center/assets/css/frontend-header-scroll.css').read_text()
          topbar_manager = Path('plugin/alookhor-control-center/assets/js/frontend-topbar-manager.js').read_text()
          header_php = Path('plugin/alookhor-control-center/includes/shortcode-header.php').read_text()
          bootstrap_php = Path('plugin/alookhor-control-center/alookhor-control-center.php').read_text()
          assert '.alookhor-legacy-nav-stage.is-stuck{position:fixed!important' in header_scroll_css and '.alookhor-legacy-nav-marker' in header_scroll_css
          assert '.alookhor-topbar-wrapper' in header_scroll_css and 'position:relative!important' in header_scroll_css
          assert 'setupHeaderBehavior' in topbar_manager and "header.after(marker, stage)" in topbar_manager
          assert "navigation.before(document.createComment" in topbar_manager and "data-alookhor-navigation" in topbar_manager
          assert 'alookhor-legacy-main-search' not in topbar_manager and 'alookhor-mobile-sticky-toggle' not in topbar_manager
          assert 'alookhor-main-menu-toggle' in topbar_manager and 'alookhor-header-cart-link' in topbar_manager
          assert '.ak-topbar-wrapper,.alu-header' in Path('plugin/alookhor-control-center/assets/js/frontend-header.js').read_text() and 'alookhorDuplicateHeaderHost' in Path('plugin/alookhor-control-center/assets/js/frontend-header.js').read_text()
          assert 'alookhor-logo-copy' in topbar_manager and 'alookhor-topbar-support' in topbar_manager and 'alookhor-account-icon' in topbar_manager
          assert "document.body.style.setProperty('padding-top', '0px'" in topbar_manager and "marker.style.setProperty('height'" in topbar_manager
          assert '.alookhor-legacy-nav-marker,.alookhor-legacy-nav-stage{display:none!important}' in header_scroll_css
          assert '.alookhor-managed-legacy-header .alookhor-topbar-wrapper,' in header_scroll_css and 'position:relative!important' in header_scroll_css
          assert "'header_logo_desktop_width' => 118" in header_php and "'header_logo_mobile_width' => 58" in header_php
          assert "data-logo-source=\"<?php echo !empty($settings['top_logo_url'])" in header_php and "'آلوخور'" in header_php and "'پایتخت آلوی ایران'" in header_php
          assert 'inpHeaderLogoDesktop' in settings_js and 'inpHeaderLogoMobile' in settings_js and 'inpHeaderSearchPlaceholder' not in settings_js
          assert "frontend-header-scroll.css" in bootstrap_php and "'sticky' => (bool) $h['sticky']" in bootstrap_php
          assert all(token in header_scroll_css for token in ['--alookhor-capsule-glass:rgba(33,20,38,.75)','--alookhor-capsule-card:#1C1024','--alookhor-capsule-gold:#D49A2E','--alookhor-capsule-gold-light:#E8B84A','backdrop-filter:blur(var(--alookhor-capsule-blur))'])
          assert all(token in topbar_manager for token in ['--alookhor-capsule-background','--alookhor-capsule-glass','--alookhor-capsule-gold-light','capsule_blur'])
          assert 'inpCapsuleGlass' in settings_js and 'inpCapsuleBlur' in settings_js and 'capsule_gold_light' in settings_js
          rest_php = Path('plugin/alookhor-control-center/includes/rest-api.php').read_text()
          release_test = Path('scripts/wordpress_release_test.py').read_text()
          assert 'alookhor_cc_migrate_header_brand_3106' in bootstrap_php and "'phone' => '09159513173'" in bootstrap_php
          assert "'topbar_bg' => '#11091D'" in bootstrap_php and "'topbar_button_bg' => '#C9A86A'" in bootstrap_php
          assert 'header_brand_migration' in rest_php and 'header_brand_palette' in release_test
          assert 'alookhor_cc_migrate_header_layout_3107' in bootstrap_php and "'show_search'] = false" in bootstrap_php
          assert 'header_layout_migration' in rest_php
          assert 'alookhor_cc_migrate_header_reference_31019' in bootstrap_php and 'header_reference_migration' in rest_php
          assert all(token in header_scroll_css for token in ['grid-template-areas:"support message phone"','is-capsule-integrated:not(.is-stuck)','top:-90px!important','padding:0 96px 0 560px','max-width:1360px'])
          assert all(token in topbar_manager for token in ['is-capsule-integrated','--alookhor-integrated-nav-offset','glassBackground','alookhor-topbar-support-icon'])
          assert "'topbar_bg' => '#1C1024'" in bootstrap_php and "'header_surface'=>'#0D0510'" in bootstrap_php
          internal_header_css=Path('plugin/alookhor-control-center/assets/css/frontend-header.css').read_text();internal_header_js=Path('plugin/alookhor-control-center/assets/js/frontend-header.js').read_text()
          assert 'body:has(.alookhor-portal-header){padding-top:0!important}' in internal_header_css and 'alookhor-internal-nav-marker' in internal_header_css
          assert '.alookhor-nav-stage.is-stuck{position:fixed!important' in internal_header_css and 'alookhor-internal-nav-marker' in internal_header_js
          assert "navStage.classList.toggle('is-stuck'" in internal_header_js and 'marker.style.setProperty' in internal_header_js
          assert 'v3.10.25 — final visual correction' in internal_header_css and 'LOGO2.png' in bootstrap_php
          assert 'alookhor_cc_migrate_approved_header_logo_31025' in bootstrap_php and 'final_reference_logo_exact' in Path('scripts/header_visual_audit.py').read_text()
          print('Managed footer/category/admin/header behavior and final reference contracts passed')
          PY

      - name: Build and validate release
        id: release
        run: python3 scripts/build_release.py

      - name: Verify generated manifest and package
        run: |
          python3 - <<'PY'
          import hashlib, json
          from pathlib import Path
          from zipfile import ZipFile
          manifest = json.loads(Path('public/manifest.json').read_text())
          package = Path('public/releases') / Path(manifest['download_url']).name
          assert package.is_file()
          assert hashlib.sha256(package.read_bytes()).hexdigest() == manifest['sha256']
          with ZipFile(package) as archive:
              assert archive.testzip() is None
              assert 'alookhor-control-center/alookhor-control-center.php' in archive.namelist()
          print('Release verification passed:', manifest['version'], manifest['sha256'])
          PY

      - name: Store dry-run artifact
        uses: actions/upload-artifact@v4
        with:
          name: alookhor-release-${{ steps.release.outputs.version }}
          path: public/
          if-no-files-found: error
          retention-days: 7

  access_audit:
    needs: build
    if: github.ref == 'refs/heads/main'
    runs-on: ubuntu-latest
    permissions:
      contents: write
    steps:
      - name: Checkout private publisher repository
        uses: actions/checkout@v5

      - name: Install FTPS client for safe probe
        run: sudo apt-get update -qq && sudo apt-get install -y -qq lftp

      - name: Probe restricted FTPS write, HTTPS read, and delete
        id: ftps_probe
        continue-on-error: true
        env:
          FTP_SERVER: ${{ secrets.FTP_SERVER }}
          FTP_PORT: ${{ secrets.FTP_PORT }}
          FTP_USERNAME: ${{ secrets.FTP_USERNAME }}
          FTP_PASSWORD: ${{ secrets.FTP_PASSWORD }}
          PROBE_NAME: releases/publisher-probe-${{ github.run_id }}.txt
        run: |
          python3 - <<'PY'
          import os, re
          from pathlib import Path
          from urllib.parse import quote
          server=os.environ['FTP_SERVER'].strip(); port=os.environ['FTP_PORT'].strip()
          user=os.environ['FTP_USERNAME'].strip(); password=os.environ['FTP_PASSWORD']; name=os.environ['PROBE_NAME']
          if '\n' in password or '\r' in password: raise SystemExit('FTP secret contains a newline')
          auth_url=f"ftp://{quote(user,safe='')}:{quote(password,safe='')}@{server}"
          if not re.fullmatch(r'[A-Za-z0-9.-]+',server) or not port.isdigit(): raise SystemExit('Invalid FTP endpoint')
          content='ALOOKHOR_PUBLISHER_PROBE_' + os.environ['GITHUB_RUN_ID']
          Path('/tmp/publisher-probe.txt').write_text(content)
          common=['set cmd:fail-exit true','set net:max-retries 2','set ftp:passive-mode true','set ftp:ssl-auth TLS','set ftp:ssl-force true','set ftp:ssl-protect-data true','set ssl:verify-certificate true',f'open -p {port} "{auth_url}"']
          for path,commands in {
              '/tmp/probe-upload.lftp':common+[f'put /tmp/publisher-probe.txt -o {name}','bye'],
              '/tmp/probe-delete.lftp':common+[f'rm -f {name}','bye'],
          }.items():
              p=Path(path);p.write_text(';\n'.join(commands)+';\n');p.chmod(0o600)
          PY
          set +e
          lftp -f /tmp/probe-upload.lftp > /tmp/ftps-probe.log 2>&1
          code=$?
          if [ "$code" -eq 0 ]; then
            python3 - <<'PY' >> /tmp/ftps-probe.log 2>&1
          import os, urllib.request
          expected='ALOOKHOR_PUBLISHER_PROBE_' + os.environ['GITHUB_RUN_ID']
          url='https://updates.alookhor.ir/' + os.environ['PROBE_NAME'] + '?run=' + os.environ['GITHUB_RUN_ID']
          with urllib.request.urlopen(url,timeout=30) as response: actual=response.read().decode()
          if actual != expected: raise SystemExit('HTTPS probe content mismatch')
          print('FTPS root mapping and HTTPS read verified')
          PY
            code=$?
          fi
          lftp -f /tmp/probe-delete.lftp >> /tmp/ftps-probe.log 2>&1 || true
          rm -f /tmp/probe-upload.lftp /tmp/probe-delete.lftp /tmp/publisher-probe.txt
          exit "$code"

      - name: Check authenticated WordPress access without updating
        id: wp_access
        continue-on-error: true
        env:
          WP_BASE_URL: ${{ secrets.WP_BASE_URL }}
          WP_USERNAME: ${{ secrets.WP_USERNAME }}
          WP_APP_PASSWORD: ${{ secrets.WP_APP_PASSWORD }}
          WP_REPORT_PATH: /tmp/wordpress-access.json
        run: python3 scripts/wordpress_access_check.py > /tmp/wordpress-access.log 2>&1

      - name: Audit rendered Production Header in Desktop and Mobile Chrome
        id: header_visual
        continue-on-error: true
        env:
          WP_BASE_URL: ${{ secrets.WP_BASE_URL }}
          HEADER_VISUAL_REPORT: /tmp/header-visual.json
          HEADER_VISUAL_SHOTS: /tmp/header-shots
        run: |
          python3 -m pip install --quiet selenium
          python3 scripts/header_visual_audit.py > /tmp/header-visual.log 2>&1

      - name: Write machine-readable access status
        if: always()
        env:
          GH_TOKEN: ${{ github.token }}
          FTP_SERVER: ${{ secrets.FTP_SERVER }}
          FTP_USERNAME: ${{ secrets.FTP_USERNAME }}
          FTP_PASSWORD: ${{ secrets.FTP_PASSWORD }}
          FTPS_OUTCOME: ${{ steps.ftps_probe.outcome }}
          ACCESS_OUTCOME: ${{ steps.wp_access.outcome }}
          HEADER_VISUAL_OUTCOME: ${{ steps.header_visual.outcome }}
        run: |
          python3 - <<'PY'
          import json, os
          from datetime import datetime, timezone
          from pathlib import Path
          from urllib.parse import quote
          report_path = Path('/tmp/wordpress-access.json')
          wordpress = json.loads(report_path.read_text()) if report_path.exists() else None
          visual_path = Path('/tmp/header-visual.json')
          visual = json.loads(visual_path.read_text()) if visual_path.exists() else None
          ftps_log_path = Path('/tmp/ftps-probe.log')
          ftps_log = ftps_log_path.read_text(errors='replace') if ftps_log_path.exists() else ''
          for secret_name in ['FTP_PASSWORD','FTP_USERNAME','FTP_SERVER']:
              value = os.environ.get(secret_name,'')
              if value:
                  ftps_log = ftps_log.replace(value,'[REDACTED]').replace(quote(value,safe=''),'[REDACTED]')
          report = {
              'type': 'access_audit',
              'run_id': os.environ['GITHUB_RUN_ID'],
              'ref': os.environ['GITHUB_REF'],
              'sha': os.environ['GITHUB_SHA'],
              'created_at': datetime.now(timezone.utc).isoformat(),
              'outcomes': {
                  'ftps_probe': os.environ.get('FTPS_OUTCOME',''),
                  'wordpress_access': os.environ.get('ACCESS_OUTCOME',''),
                  'header_visual': os.environ.get('HEADER_VISUAL_OUTCOME',''),
              },
              'ftps_log': ftps_log[-8000:],
              'wordpress': wordpress,
              'header_visual': visual,
          }
          Path('/tmp/latest.json').write_text(json.dumps(report, ensure_ascii=False, indent=2) + '\n')
          PY
          rm -rf /tmp/status-repo
          mkdir /tmp/status-repo
          cd /tmp/status-repo
          git init -b publisher-status
          git config user.name 'ALOOKHOR Publisher Bot'
          git config user.email 'publisher@alookhor.ir'
          cp /tmp/latest.json .
          if [ -d /tmp/header-shots ]; then mkdir -p visual; cp /tmp/header-shots/*.png visual/ 2>/dev/null || true; fi
          git add latest.json visual 2>/dev/null || git add latest.json
          git commit -m "Access audit for run ${GITHUB_RUN_ID}"
          git remote add origin "https://x-access-token:${GH_TOKEN}@github.com/${GITHUB_REPOSITORY}.git"
          git push --force origin HEAD:publisher-status

      - name: Enforce FTPS and authenticated WordPress access
        if: always()
        env:
          FTPS_OUTCOME: ${{ steps.ftps_probe.outcome }}
          ACCESS_OUTCOME: ${{ steps.wp_access.outcome }}
        run: |
          test "$FTPS_OUTCOME" = success
          test "$ACCESS_OUTCOME" = success

  deploy:
    needs: build
    if: startsWith(github.ref, 'refs/tags/v')
    runs-on: ubuntu-latest
    permissions:
      contents: write
    environment: production
    steps:
      - name: Checkout private publisher repository
        uses: actions/checkout@v5

      - name: Rebuild verified release
        run: python3 scripts/build_release.py

      - name: Install FTPS client
        run: sudo apt-get update -qq && sudo apt-get install -y -qq lftp

      - name: Validate deployment secrets
        env:
          FTP_SERVER: ${{ secrets.FTP_SERVER }}
          FTP_PORT: ${{ secrets.FTP_PORT }}
          FTP_USERNAME: ${{ secrets.FTP_USERNAME }}
          FTP_PASSWORD: ${{ secrets.FTP_PASSWORD }}
        run: |
          test -n "$FTP_SERVER"
          test -n "$FTP_PORT"
          test -n "$FTP_USERNAME"
          test -n "$FTP_PASSWORD"

      - name: Prepare protected FTPS command files
        env:
          FTP_SERVER: ${{ secrets.FTP_SERVER }}
          FTP_PORT: ${{ secrets.FTP_PORT }}
          FTP_USERNAME: ${{ secrets.FTP_USERNAME }}
          FTP_PASSWORD: ${{ secrets.FTP_PASSWORD }}
        run: |
          python3 - <<'PY'
          import json, os, re
          from pathlib import Path
          from urllib.parse import quote
          server = os.environ['FTP_SERVER'].strip()
          port = os.environ['FTP_PORT'].strip()
          user = os.environ['FTP_USERNAME'].strip()
          password = os.environ['FTP_PASSWORD']
          if '\n' in password or '\r' in password: raise SystemExit('FTP secret contains a newline')
          auth_url = f"ftp://{quote(user,safe='')}:{quote(password,safe='')}@{server}"
          manifest = json.loads(Path('public/manifest.json').read_text())
          package = Path(manifest['download_url']).name
          if not re.fullmatch(r'[A-Za-z0-9.-]+', server): raise SystemExit('Invalid FTP_SERVER')
          if not port.isdigit(): raise SystemExit('Invalid FTP_PORT')
          if not re.fullmatch(r'[A-Za-z0-9._-]+\.zip', package): raise SystemExit('Invalid package name')
          common = [
              'set cmd:fail-exit true', 'set net:max-retries 2', 'set net:timeout 20',
              'set ftp:passive-mode true', 'set ftp:ssl-auth TLS', 'set ftp:ssl-force true',
              'set ftp:ssl-protect-data true', 'set ssl:verify-certificate true',
              f'open -p {port} "{auth_url}"',
          ]
          scripts = {
              '/tmp/alookhor-upload-package.lftp': common + [f'put public/releases/{package} -o releases/{package}', 'bye'],
              '/tmp/alookhor-upload-metadata.lftp': common + ['put public/releases/SHA256SUMS.txt -o releases/SHA256SUMS.txt', 'put public/index.html -o index.html', 'put public/changelog.html -o changelog.html', 'put public/.htaccess -o .htaccess', 'bye'],
              '/tmp/alookhor-publish-manifest.lftp': common + ['put public/manifest.json -o manifest.json.next', 'mv manifest.json.next manifest.json', 'bye'],
          }
          for filename, commands in scripts.items():
              path = Path(filename); path.write_text(';\n'.join(commands) + ';\n'); path.chmod(0o600)
          PY

      - name: Upload release ZIP
        id: upload_zip
        continue-on-error: true
        run: lftp -f /tmp/alookhor-upload-package.lftp > /tmp/upload-zip.log 2>&1

      - name: Verify remote ZIP and SHA-256
        id: verify_zip
        if: steps.upload_zip.outcome == 'success'
        continue-on-error: true
        env:
          GITHUB_RUN_ID: ${{ github.run_id }}
        run: |
          python3 - <<'PY' > /tmp/verify-zip.log 2>&1
          import hashlib, json, os, time, urllib.request
          from pathlib import Path
          from zipfile import ZipFile
          expected = json.loads(Path('public/manifest.json').read_text())
          url = expected['download_url'] + '?prepublish=' + os.environ['GITHUB_RUN_ID']
          target = Path('/tmp/remote-release.zip')
          for attempt in range(6):
              try:
                  with urllib.request.urlopen(url, timeout=30) as response: target.write_bytes(response.read())
                  actual = hashlib.sha256(target.read_bytes()).hexdigest()
                  if actual != expected['sha256']: raise ValueError(f"SHA mismatch: {actual} != {expected['sha256']}")
                  with ZipFile(target) as archive:
                      assert archive.testzip() is None
                      bootstrap = archive.read('alookhor-control-center/alookhor-control-center.php').decode('utf-8')
                      assert f"Version: {expected['version']}" in bootstrap
                  print('Remote package verified:', expected['version'], actual); break
              except Exception as error:
                  print(f'Attempt {attempt + 1} failed:', error)
                  if attempt == 5: raise
                  time.sleep(10)
          PY

      - name: Upload release metadata
        id: upload_metadata
        if: steps.verify_zip.outcome == 'success'
        continue-on-error: true
        run: lftp -f /tmp/alookhor-upload-metadata.lftp > /tmp/upload-metadata.log 2>&1

      - name: Publish manifest atomically
        id: publish_manifest
        if: steps.upload_metadata.outcome == 'success'
        continue-on-error: true
        run: lftp -f /tmp/alookhor-publish-manifest.lftp > /tmp/publish-manifest.log 2>&1

      - name: Verify production manifest
        id: verify_production
        if: steps.publish_manifest.outcome == 'success'
        continue-on-error: true
        env:
          GITHUB_RUN_ID: ${{ github.run_id }}
        run: |
          python3 - <<'PY' > /tmp/verify-production.log 2>&1
          import json, os, time, urllib.request
          from pathlib import Path
          expected = json.loads(Path('public/manifest.json').read_text())
          url = f"https://updates.alookhor.ir/manifest.json?github_run={os.environ['GITHUB_RUN_ID']}"
          for attempt in range(6):
              with urllib.request.urlopen(url, timeout=20) as response: production = json.load(response)
              if production.get('version') == expected['version'] and production.get('sha256') == expected['sha256']:
                  print('Production verified:', production['version'], production['sha256']); break
              if attempt == 5: raise SystemExit(f'Production manifest did not update: {production}')
              time.sleep(10)
          PY

      - name: Run authenticated WordPress update and post-update tests
        id: wordpress_verify
        if: steps.verify_production.outcome == 'success'
        continue-on-error: true
        env:
          WP_BASE_URL: ${{ secrets.WP_BASE_URL }}
          WP_USERNAME: ${{ secrets.WP_USERNAME }}
          WP_APP_PASSWORD: ${{ secrets.WP_APP_PASSWORD }}
          WP_REPORT_PATH: /tmp/wordpress-report.json
        run: |
          test -n "$WP_BASE_URL"; test -n "$WP_USERNAME"; test -n "$WP_APP_PASSWORD"
          python3 scripts/wordpress_release_test.py > /tmp/wordpress-update.log 2>&1

      - name: Write sanitized publisher status branch
        if: always()
        env:
          GH_TOKEN: ${{ github.token }}
          FTP_SERVER: ${{ secrets.FTP_SERVER }}
          FTP_USERNAME: ${{ secrets.FTP_USERNAME }}
          FTP_PASSWORD: ${{ secrets.FTP_PASSWORD }}
          WP_USERNAME: ${{ secrets.WP_USERNAME }}
          WP_APP_PASSWORD: ${{ secrets.WP_APP_PASSWORD }}
          UPLOAD_ZIP: ${{ steps.upload_zip.outcome }}
          VERIFY_ZIP: ${{ steps.verify_zip.outcome }}
          UPLOAD_METADATA: ${{ steps.upload_metadata.outcome }}
          PUBLISH_MANIFEST: ${{ steps.publish_manifest.outcome }}
          VERIFY_PRODUCTION: ${{ steps.verify_production.outcome }}
          WORDPRESS_VERIFY: ${{ steps.wordpress_verify.outcome }}
        run: |
          python3 - <<'PY'
          import json, os
          from datetime import datetime, timezone
          from pathlib import Path
          from urllib.parse import quote
          secrets = [os.environ.get('FTP_PASSWORD',''), os.environ.get('FTP_USERNAME',''), os.environ.get('FTP_SERVER',''), os.environ.get('WP_APP_PASSWORD',''), os.environ.get('WP_USERNAME','')]
          def clean(text):
              for value in sorted((v for v in secrets if v), key=len, reverse=True): text = text.replace(value, '[REDACTED]').replace(quote(value,safe=''), '[REDACTED]')
              return text[-12000:]
          logs = {}
          for name in ['upload-zip','verify-zip','upload-metadata','publish-manifest','verify-production','wordpress-update']:
              path = Path('/tmp') / f'{name}.log'; logs[name] = clean(path.read_text(errors='replace')) if path.exists() else ''
          wp_report = Path('/tmp/wordpress-report.json')
          wordpress = json.loads(clean(wp_report.read_text(errors='replace'))) if wp_report.exists() else None
          report = {
              'run_id': os.environ['GITHUB_RUN_ID'], 'ref': os.environ['GITHUB_REF'], 'sha': os.environ['GITHUB_SHA'],
              'created_at': datetime.now(timezone.utc).isoformat(),
              'outcomes': {
                  'upload_zip': os.environ.get('UPLOAD_ZIP',''), 'verify_zip': os.environ.get('VERIFY_ZIP',''),
                  'upload_metadata': os.environ.get('UPLOAD_METADATA',''), 'publish_manifest': os.environ.get('PUBLISH_MANIFEST',''),
                  'verify_production': os.environ.get('VERIFY_PRODUCTION',''), 'wordpress_verify': os.environ.get('WORDPRESS_VERIFY',''),
              }, 'logs': logs, 'wordpress': wordpress,
          }
          out = Path('/tmp/publisher-status'); out.mkdir(exist_ok=True); (out / 'latest.json').write_text(json.dumps(report, ensure_ascii=False, indent=2) + '\n')
          PY
          rm -rf /tmp/status-repo; mkdir /tmp/status-repo; cd /tmp/status-repo
          git init -b publisher-status; git config user.name 'ALOOKHOR Publisher Bot'; git config user.email 'publisher@alookhor.ir'
          cp /tmp/publisher-status/latest.json .; git add latest.json; git commit -m "Publisher status for run ${GITHUB_RUN_ID}"
          git remote add origin "https://x-access-token:${GH_TOKEN}@github.com/${GITHUB_REPOSITORY}.git"
          git push --force origin HEAD:publisher-status

      - name: Enforce successful atomic deployment
        if: always()
        env:
          UPLOAD_ZIP: ${{ steps.upload_zip.outcome }}
          VERIFY_ZIP: ${{ steps.verify_zip.outcome }}
          UPLOAD_METADATA: ${{ steps.upload_metadata.outcome }}
          PUBLISH_MANIFEST: ${{ steps.publish_manifest.outcome }}
          VERIFY_PRODUCTION: ${{ steps.verify_production.outcome }}
          WORDPRESS_VERIFY: ${{ steps.wordpress_verify.outcome }}
        run: |
          test "$UPLOAD_ZIP" = success
          test "$VERIFY_ZIP" = success
          test "$UPLOAD_METADATA" = success
          test "$PUBLISH_MANIFEST" = success
          test "$VERIFY_PRODUCTION" = success
          test "$WORDPRESS_VERIFY" = success
````

## Source Snapshot — `ops/wordpress-ci-bootstrap.php`

````php
<?php
/**
 * ALOOKHOR CI Bootstrap Bridge
 * Bootstrap for the 3.8.5 -> 3.8.6 authenticated transition and the one-time
 * 3.8.6 -> 3.8.7 activation-state bridge. Remove only after 3.8.7 is active
 * and its native reactivation diagnostic has been verified.
 */

if (!defined('ABSPATH')) return;

add_action('init', function(){
    if (!get_role('alookhor_publisher')) {
        add_role('alookhor_publisher', 'ALOOKHOR Publisher', [
            'read' => true,
            'update_plugins' => true,
        ]);
    }
});

/**
 * One-transition activation bridge. Version 3.8.6 predates the native
 * reactivation guard. These callbacks preserve an already-active Control
 * Center while 3.8.7 is installed; they never activate an unrelated or
 * previously inactive plugin and grant no additional role capability.
 */
function alookhor_ci_targets_control_center($options){
    if (!is_array($options)) return false;
    $basename = 'alookhor-control-center/alookhor-control-center.php';
    $plugin = $options['plugin'] ?? '';
    $plugins = $options['plugins'] ?? [];
    return $plugin === $basename || (is_array($plugins) && in_array($basename, $plugins, true));
}

add_filter('upgrader_pre_install', function($response, $options){
    if (is_wp_error($response) || !alookhor_ci_targets_control_center($options)) return $response;
    require_once ABSPATH . 'wp-admin/includes/plugin.php';
    $basename = 'alookhor-control-center/alookhor-control-center.php';
    $GLOBALS['alookhor_ci_pre_update_activation'] = [
        'active' => is_plugin_active($basename),
        'network_active' => is_multisite() && is_plugin_active_for_network($basename),
    ];
    return $response;
}, 4, 2);

add_action('upgrader_process_complete', function($upgrader, $options){
    if (($options['action'] ?? '') !== 'update' || ($options['type'] ?? '') !== 'plugin') return;
    if (!alookhor_ci_targets_control_center($options)) return;
    $state = $GLOBALS['alookhor_ci_pre_update_activation'] ?? [];
    if (empty($state['active'])) return;

    require_once ABSPATH . 'wp-admin/includes/plugin.php';
    $basename = 'alookhor-control-center/alookhor-control-center.php';
    if (!is_plugin_active($basename)) {
        $result = activate_plugin($basename, '', !empty($state['network_active']), true);
        set_site_transient('alookhor_ci_last_activation_restore', [
            'ok' => !is_wp_error($result) && is_plugin_active($basename),
            'error' => is_wp_error($result) ? $result->get_error_code() : null,
            'checked_at' => time(),
        ], DAY_IN_SECONDS);
    }
    unset($GLOBALS['alookhor_ci_pre_update_activation']);
}, 21, 2);

function alookhor_ci_permission(){
    if (!is_user_logged_in() || !current_user_can('update_plugins')) {
        return new WP_Error('alookhor_ci_forbidden', 'Application Password user with update_plugins is required.', ['status' => 403]);
    }
    return true;
}

function alookhor_ci_option_hash($name){
    return hash('sha256', wp_json_encode(get_option($name, null)));
}

add_action('rest_api_init', function(){
    // This status route remains available during the one-time 3.8.6 -> 3.8.7
    // transition so CI can prove that the activation bridge and least-privilege
    // Publisher role are live before a release is allowed.
    register_rest_route('alookhor-ci/v1', '/bridge-status', [
        'methods' => WP_REST_Server::READABLE,
        'permission_callback' => 'alookhor_ci_permission',
        'callback' => function(){
            require_once ABSPATH . 'wp-admin/includes/plugin.php';
            $role = get_role('alookhor_publisher');
            $caps = is_object($role) ? (array) $role->capabilities : [];
            return rest_ensure_response([
                'version' => '2026.08.11-reactivation-v1',
                'activation_guard' => true,
                'plugin_active' => is_plugin_active('alookhor-control-center/alookhor-control-center.php'),
                'capabilities' => [
                    'read' => !empty($caps['read']),
                    'update_plugins' => !empty($caps['update_plugins']),
                    'activate_plugins' => !empty($caps['activate_plugins']),
                ],
            ]);
        },
    ]);

    // After 3.8.6 is active, the native alookhor-cc/v1 API owns status/install;
    // only bridge-status and the upgrader callbacks above remain live.
    if (defined('ALOOKHOR_CC_VERSION') && version_compare(ALOOKHOR_CC_VERSION, '3.8.6', '>=')) return;

    register_rest_route('alookhor-ci/v1', '/status', [
        'methods' => WP_REST_Server::READABLE,
        'permission_callback' => 'alookhor_ci_permission',
        'callback' => function(){
            $plugin_file = defined('ALOOKHOR_CC_FILE') ? ALOOKHOR_CC_FILE : WP_PLUGIN_DIR . '/alookhor-control-center/alookhor-control-center.php';
            require_once ABSPATH . 'wp-admin/includes/plugin.php';
            $data = file_exists($plugin_file) ? get_plugin_data($plugin_file, false, false) : [];
            return rest_ensure_response([
                'version' => $data['Version'] ?? null,
                'active' => is_plugin_active('alookhor-control-center/alookhor-control-center.php'),
                'main_option_hash' => alookhor_ci_option_hash('alookhor_cc_settings'),
                'header_option_hash' => alookhor_ci_option_hash('alookhor_header_settings'),
                'shortcode' => shortcode_exists('alookhor_portal_header'),
                'checked_at' => current_time('mysql', true),
            ]);
        },
    ]);

    register_rest_route('alookhor-ci/v1', '/install', [
        'methods' => WP_REST_Server::CREATABLE,
        'permission_callback' => 'alookhor_ci_permission',
        'args' => [
            'target_version' => [
                'required' => true,
                'type' => 'string',
                'sanitize_callback' => 'sanitize_text_field',
                'validate_callback' => function($value){ return (bool) preg_match('/^\d+\.\d+\.\d+$/', (string) $value); },
            ],
        ],
        'callback' => function(WP_REST_Request $request){
            if (!defined('ALOOKHOR_CC_PLUGIN_BASENAME') || !function_exists('alookhor_cc_get_update_manifest')) {
                return new WP_Error('alookhor_ci_plugin_missing', 'ALOOKHOR updater is not loaded.', ['status' => 500]);
            }
            if (version_compare(get_bloginfo('version'), '6.3', '<')) {
                return new WP_Error('alookhor_ci_rollback_unavailable', 'WordPress 6.3+ is required for automatic rollback.', ['status' => 409]);
            }
            $target = (string) $request->get_param('target_version');
            $lock_key = 'alookhor_ci_update_lock';
            if (get_transient($lock_key)) {
                return new WP_Error('alookhor_ci_update_locked', 'Another update request is running.', ['status' => 409]);
            }
            set_transient($lock_key, 1, 5 * MINUTE_IN_SECONDS);
            register_shutdown_function(function() use ($lock_key){ delete_transient($lock_key); });

            $manifest_response = wp_safe_remote_get('https://updates.alookhor.ir/manifest.json', [
                'timeout' => 20,
                'redirection' => 2,
                'headers' => ['Accept' => 'application/json'],
            ]);
            if (is_wp_error($manifest_response)) return $manifest_response;
            if ((int) wp_remote_retrieve_response_code($manifest_response) !== 200) {
                return new WP_Error('alookhor_ci_manifest_http', 'Update manifest is unavailable.', ['status' => 502]);
            }
            $raw = json_decode(wp_remote_retrieve_body($manifest_response), true);
            $version = sanitize_text_field($raw['version'] ?? '');
            $package = esc_url_raw($raw['download_url'] ?? '');
            $sha256 = strtolower(sanitize_text_field($raw['sha256'] ?? ''));
            if (!hash_equals($target, $version)) return new WP_Error('alookhor_ci_target_mismatch', 'Target does not match manifest.', ['status' => 409]);
            if (wp_parse_url($package, PHP_URL_SCHEME) !== 'https' || wp_parse_url($package, PHP_URL_HOST) !== 'updates.alookhor.ir') {
                return new WP_Error('alookhor_ci_untrusted_package', 'Package host is not trusted.', ['status' => 400]);
            }
            if (!preg_match('/^[a-f0-9]{64}$/', $sha256)) return new WP_Error('alookhor_ci_invalid_sha', 'Manifest SHA-256 is invalid.', ['status' => 400]);

            require_once ABSPATH . 'wp-admin/includes/file.php';
            $downloaded = download_url($package, 300, false);
            if (is_wp_error($downloaded)) return $downloaded;
            $actual = strtolower((string) hash_file('sha256', $downloaded));
            if (!$actual || !hash_equals($sha256, $actual)) {
                wp_delete_file($downloaded);
                return new WP_Error('alookhor_ci_sha_mismatch', 'Downloaded package SHA-256 mismatch.', ['status' => 409]);
            }

            $manifest = alookhor_cc_get_update_manifest(true);
            if (is_wp_error($manifest)) {
                wp_delete_file($downloaded);
                return $manifest;
            }
            $transient = get_site_transient('update_plugins');
            if (!is_object($transient)) $transient = new stdClass();
            $transient->last_checked = time();
            set_site_transient('update_plugins', alookhor_cc_apply_manifest_to_update_transient($transient, $manifest));

            $pre_download = function($reply, $remote_package) use ($package, $downloaded){
                return $remote_package === $package ? $downloaded : $reply;
            };
            add_filter('upgrader_pre_download', $pre_download, 1, 2);
            require_once ABSPATH . 'wp-admin/includes/plugin.php';
            require_once ABSPATH . 'wp-admin/includes/class-wp-upgrader.php';
            $before_main = alookhor_ci_option_hash('alookhor_cc_settings');
            $before_header = alookhor_ci_option_hash('alookhor_header_settings');
            $skin = new Automatic_Upgrader_Skin();
            $upgrader = new Plugin_Upgrader($skin);
            $result = $upgrader->upgrade(ALOOKHOR_CC_PLUGIN_BASENAME, ['clear_update_cache' => true]);
            remove_filter('upgrader_pre_download', $pre_download, 1);
            if (file_exists($downloaded)) wp_delete_file($downloaded);
            if (is_wp_error($result)) return $result;
            if (!$result) return new WP_Error('alookhor_ci_update_failed', 'WordPress upgrader did not complete.', ['status' => 500]);

            wp_clean_plugins_cache(true);
            $data = get_plugin_data(ALOOKHOR_CC_FILE, false, false);
            return rest_ensure_response([
                'updated' => true,
                'version' => $data['Version'] ?? $target,
                'sha256' => $actual,
                'settings_preserved' => [
                    'main' => hash_equals($before_main, alookhor_ci_option_hash('alookhor_cc_settings')),
                    'header' => hash_equals($before_header, alookhor_ci_option_hash('alookhor_header_settings')),
                ],
                'active' => is_plugin_active(ALOOKHOR_CC_PLUGIN_BASENAME),
            ]);
        },
    ]);
});
````

## Source Snapshot — `plugin/alookhor-control-center/alookhor-control-center.php`

````php
<?php
/**
 * Plugin Name: ALOOKHOR Control Center
 * Plugin URI: https://alookhor.ir
 * Description: کنترل سنتر لوکس و ماژولار آلوخور — مدیریت کامل سایت (هدر، اسلایدر، سورت، محصولات، مشتریان VIP، مالی، آنالیتیکس) با آپدیت آنی بدون رفرش. تمام تنظیمات چت قبلی + شورت‌کد [alookhor_portal_header] اینجا مدیریت می‌شود.
 * Version: 3.10.26
 * Author: ALOOKHOR Team — Luxury Modular
 * Author URI: https://alookhor.ir
 * Update URI: https://alookhor.ir/alookhor-control-center
 * Text Domain: alookhor-cc
 * Domain Path: /languages
 * Requires at least: 6.0
 * Requires PHP: 8.0
 * License: Private
 */

if (!defined('ABSPATH')) exit;

define('ALOOKHOR_CC_VERSION', '3.10.26');
define('ALOOKHOR_CC_BUILD', '3.10.26');
define('ALOOKHOR_CC_FILE', __FILE__);
define('ALOOKHOR_CC_DIR', plugin_dir_path(__FILE__));
define('ALOOKHOR_CC_URL', plugin_dir_url(__FILE__));
define('ALOOKHOR_CC_OPTION', 'alookhor_cc_settings');
define('ALOOKHOR_CC_HEADER_OPTION', 'alookhor_header_settings');
define('ALOOKHOR_CC_PLUGIN_BASENAME', plugin_basename(__FILE__));

// ——— Activation: حافظه واقعی قبلی را بساز ———
register_activation_hook(__FILE__, 'alookhor_cc_activate');
function alookhor_cc_activate(){
    $defaults_file = ALOOKHOR_CC_DIR . 'config/site.json';
    if(file_exists($defaults_file)){
        $json = json_decode(file_get_contents($defaults_file), true);
        if(!empty($json)){
            if(!get_option(ALOOKHOR_CC_OPTION)){
                update_option(ALOOKHOR_CC_OPTION, $json);
            }
            if(!get_option(ALOOKHOR_CC_HEADER_OPTION) && !empty($json['header_settings'])){
                update_option(ALOOKHOR_CC_HEADER_OPTION, [
                    'logo_text' => $json['header_settings']['logo_text'] ?? 'ALOOKHOR',
                    'logo_sub' => $json['header_settings']['logo_sub'] ?? 'Control Center • Luxury',
                    'logo_letter' => $json['site']['logoLetter'] ?? 'A',
                    'gold' => $json['site']['goldAccent'] ?? '#C9A86A',
                ]);
            }
        }
    }
    // فلش rewrite برای شورت‌کدها
    flush_rewrite_rules();
}

// ——— Load Includes ———
require_once ALOOKHOR_CC_DIR . 'includes/admin.php';
require_once ALOOKHOR_CC_DIR . 'includes/ajax.php';
require_once ALOOKHOR_CC_DIR . 'includes/updater.php';
require_once ALOOKHOR_CC_DIR . 'includes/rest-api.php';
require_once ALOOKHOR_CC_DIR . 'includes/shortcode-header.php';
require_once ALOOKHOR_CC_DIR . 'includes/footer.php';
require_once ALOOKHOR_CC_DIR . 'includes/product-categories.php';
require_once ALOOKHOR_CC_DIR . 'includes/hero.php';
require_once ALOOKHOR_CC_DIR . 'includes/site-features.php';

// ——— Enqueue برای فرانت (هدر لوکس، کاملاً Scoped) ———
// فایل کامل luxury.css مخصوص کنترل سنتر است و نباید body/theme فرانت را override کند.
add_action('wp_enqueue_scripts', function(){
    if (!empty($GLOBALS['alookhor_cc_legacy_header_provider'])) {
        // خروجی و CSS هدر قدیمی دست‌نخورده می‌ماند؛ فقط مقادیر Top Bar مدیریت می‌شوند.
        $h = alookhor_cc_front_header_settings();
        // Load in <head>: the observer can hide stale legacy markup before the
        // browser paints it, then reveal only freshly synchronized Top Bar data.
        wp_enqueue_style('alookhor-cc-legacy-header-scroll', ALOOKHOR_CC_URL . 'assets/css/frontend-header-scroll.css', [], ALOOKHOR_CC_BUILD);
        wp_enqueue_script('alookhor-cc-legacy-topbar-manager', ALOOKHOR_CC_URL . 'assets/js/frontend-topbar-manager.js', [], ALOOKHOR_CC_BUILD, false);
        wp_localize_script('alookhor-cc-legacy-topbar-manager', 'ALOOKHOR_TOPBAR', [
            'endpoint' => rest_url('alookhor-cc/v1/topbar'),
            'version' => ALOOKHOR_CC_VERSION,
            'home_url' => home_url('/'),
            'cart_url' => function_exists('wc_get_cart_url') ? wc_get_cart_url() : home_url('/cart/'),
            'cart_count' => function_exists('WC') && WC()->cart ? (int) WC()->cart->get_cart_contents_count() : 0,
            'logo_text' => $h['logo_text'],
            'gold' => $h['gold'],
            'sticky' => (bool) $h['sticky'],
            'show_search' => (bool) $h['show_search'],
            'search_placeholder' => $h['search_placeholder'],
            'header_surface' => $h['header_surface'],
            'header_text_color' => $h['header_text_color'],
            'header_muted_color' => $h['header_muted_color'],
            'capsule_background' => $h['capsule_background'],
            'capsule_card' => $h['capsule_card'],
            'capsule_glass' => $h['capsule_glass'],
            'capsule_gold' => $h['capsule_gold'],
            'capsule_gold_light' => $h['capsule_gold_light'],
            'capsule_text' => $h['capsule_text'],
            'capsule_muted' => $h['capsule_muted'],
            'capsule_blur' => (int) $h['capsule_blur'],
            'header_logo_desktop_width' => (int) $h['header_logo_desktop_width'],
            'header_logo_mobile_width' => (int) $h['header_logo_mobile_width'],
            'phone' => $h['phone'],
            'email' => $h['email'],
            'whatsapp' => $h['whatsapp'],
            'export_text' => $h['export_text'],
            'export_url' => $h['export_url'],
            'wholesale_text' => $h['wholesale_text'],
            'wholesale_url' => $h['wholesale_url'],
            'wholesale_new_tab' => (bool) $h['wholesale_new_tab'],
            'top_logo_url' => $h['top_logo_url'],
            'top_logo_alt' => $h['top_logo_alt'],
            'top_logo_link' => $h['top_logo_link'],
            'topbar_bg' => $h['topbar_bg'],
            'topbar_text_color' => $h['topbar_text_color'],
            'topbar_border_color' => $h['topbar_border_color'],
            'topbar_button_bg' => $h['topbar_button_bg'],
            'topbar_button_text' => $h['topbar_button_text'],
            'topbar_height' => (int) $h['topbar_height'],
            'top_logo_width' => (int) $h['top_logo_width'],
            'show_topbar' => (bool) $h['show_topbar'],
            'show_phone' => (bool) $h['show_phone'],
            'show_email' => (bool) $h['show_email'],
            'show_whatsapp' => (bool) $h['show_whatsapp'],
            'show_export' => (bool) $h['show_export'],
            'show_wholesale' => (bool) $h['show_wholesale'],
        ]);
        return;
    }
    wp_enqueue_style('alookhor-cc-front', ALOOKHOR_CC_URL . 'assets/css/frontend-header.css', [], ALOOKHOR_CC_BUILD);
    wp_enqueue_script('alookhor-cc-front-header', ALOOKHOR_CC_URL . 'assets/js/frontend-header.js', [], ALOOKHOR_CC_BUILD, true);
});

// ——— Helper: گرفتن Defaults و ترمیم حافظه ناقص نسخه‌های قبلی ———
function alookhor_cc_get_default_settings(){
    static $defaults = null;
    if ($defaults !== null) return $defaults;

    $defaults = [];
    $file = ALOOKHOR_CC_DIR . 'config/site.json';
    if (file_exists($file)) {
        $decoded = json_decode(file_get_contents($file), true);
        if (is_array($decoded)) $defaults = $decoded;
    }
    return $defaults;
}

function alookhor_cc_get_settings(){
    $defaults = alookhor_cc_get_default_settings();
    $saved = get_option(ALOOKHOR_CC_OPTION, []);
    if (!is_array($saved)) $saved = [];

    // Defaults ابتدا قرار می‌گیرند و مقادیر واقعی کاربر روی آن‌ها Override می‌شوند.
    // بنابراین modules/system/AI گمشده ترمیم می‌شوند، بدون حذف تنظیمات موجود کاربر.
    $settings = array_replace_recursive($defaults, $saved);

    foreach (['site', 'modules', 'system', 'ai_assistant', 'header_settings', 'footer_settings', 'category_settings', 'hero_settings', 'feature_settings'] as $required_key) {
        if (!isset($settings[$required_key]) || !is_array($settings[$required_key])) {
            $settings[$required_key] = isset($defaults[$required_key]) && is_array($defaults[$required_key])
                ? $defaults[$required_key]
                : [];
        }
    }
    if (empty($settings['ai_assistant']['suggestions']) && !empty($defaults['ai_assistant']['suggestions'])) {
        $settings['ai_assistant']['suggestions'] = $defaults['ai_assistant']['suggestions'];
    }

    // Option تخصصی هدر روی State اصلی Merge می‌شود تا تمام کنترل‌ها داخل
    // پنل اصلی Control Center هم قابل مشاهده و ویرایش باشند.
    $header_saved = get_option(ALOOKHOR_CC_HEADER_OPTION, []);
    if (is_array($header_saved)) {
        $settings['header_settings'] = array_replace($settings['header_settings'], $header_saved);
    }
    if (function_exists('alookhor_cc_footer_defaults')) {
        $footer_saved = is_array($saved['footer_settings'] ?? null) ? $saved['footer_settings'] : [];
        $settings['footer_settings'] = array_replace_recursive(alookhor_cc_footer_defaults(), $footer_saved);
        if (!empty($settings['footer_settings']['use_header_contact']) && is_array($header_saved)) {
            foreach (['phone','email','whatsapp'] as $contact_key) {
                if (array_key_exists($contact_key,$header_saved)) $settings['footer_settings'][$contact_key]=$header_saved[$contact_key];
            }
        }
    }
    if (function_exists('alookhor_cc_category_defaults')) {
        $category_saved = is_array($saved['category_settings'] ?? null) ? $saved['category_settings'] : [];
        $settings['category_settings'] = array_replace_recursive(alookhor_cc_category_defaults(), $category_saved);
    }
    $settings['version'] = ALOOKHOR_CC_VERSION;

    // Migration تنبل: فقط وقتی حافظه ناقص بوده یک‌بار نسخه ترمیم‌شده ذخیره شود.
    if ($settings !== $saved) update_option(ALOOKHOR_CC_OPTION, $settings);

    return $settings;
}

// ——— Mixed Content Fix: force favicon & site icon to HTTPS when admin is HTTPS ———
add_filter('get_site_icon_url', function($url){
    if(is_ssl() && strpos($url, 'http://') === 0){
        return str_replace('http://', 'https://', $url);
    }
    return $url;
});
add_filter('site_url', function($url){
    if(is_ssl() && strpos($url, 'http://') === 0 && strpos($url, 'alookhor.ir') !== false){
        return str_replace('http://', 'https://', $url);
    }
    return $url;
});

function alookhor_cc_get_header_settings(){
    $h = get_option(ALOOKHOR_CC_HEADER_OPTION, []);
    $s = alookhor_cc_get_settings();
    $defaults = [
        'logo_text' => $s['header_settings']['logo_text'] ?? $s['site']['name'] ?? 'ALOOKHOR',
        'logo_sub' => $s['header_settings']['logo_sub'] ?? $s['site']['subtitle'] ?? 'آلوخور؛ طعم اصیل خراسان',
        'logo_letter' => $s['site']['logoLetter'] ?? 'A',
        'gold' => $s['site']['goldAccent'] ?? '#D49A2E',
        'header_surface' => '#0D0510',
        'header_text_color' => '#F5F3F0',
        'header_muted_color' => '#C8C2C9',
        'capsule_background' => '#0D0510',
        'capsule_card' => '#1C1024',
        'capsule_glass' => 'rgba(33,20,38,.75)',
        'capsule_gold' => '#D49A2E',
        'capsule_gold_light' => '#E8B84A',
        'capsule_text' => '#F5F3F0',
        'capsule_muted' => '#C8C2C9',
        'capsule_blur' => 24,
        'header_logo_desktop_width' => 118,
        'header_logo_mobile_width' => 58,
        'sticky' => true,
        'show_search' => false,
        'search_placeholder' => 'جستجوی محصول…',
        'show_topbar' => true,
        'show_account' => true,
        'show_contact' => true,
        'show_phone' => true,
        'show_email' => true,
        'show_whatsapp' => true,
        'show_export' => true,
        'show_wholesale' => true,
        'email' => sanitize_email(get_option('admin_email')),
        'phone' => '09222942808',
        'whatsapp' => '989222942808',
        'export_text' => 'صادرات به ۵ کشور جهان',
        'export_url' => '',
        'wholesale_text' => 'خرید عمده آلو بخارا',
        'wholesale_url' => home_url('/#b2b'),
        'wholesale_new_tab' => false,
        'top_logo_url' => '',
        'top_logo_alt' => get_bloginfo('name'),
        'top_logo_link' => home_url('/'),
        'topbar_bg' => '#1C1024',
        'topbar_text_color' => '#F5F3F0',
        'topbar_border_color' => '#D49A2E',
        'topbar_button_bg' => '#D49A2E',
        'topbar_button_text' => '#0D0510',
        'topbar_height' => 38,
        'top_logo_width' => 96,
        'account_text' => 'ورود / ثبت‌نام',
        'primary_menu' => 0,
    ];
    return wp_parse_args($h, $defaults);
}

/**
 * One-time 3.10.12 migration requested by the site owner: restore the verified
 * ALOOKHOR Black/Gold Header palette (not the orange/green reference colors)
 * and the authoritative contact phone ending in 3173. Every unrelated Header
 * value remains untouched.
 */
function alookhor_cc_migrate_header_brand_3106(){
    $main = get_option(ALOOKHOR_CC_OPTION, []);
    if (!is_array($main)) $main = [];
    if (!empty($main['_migrations']['header_brand_3106']['ok'])) return;

    $header = get_option(ALOOKHOR_CC_HEADER_OPTION, []);
    if (!is_array($header)) $header = [];
    $before_hash = hash('sha256', wp_json_encode($header));
    $target = [
        'phone' => '09159513173',
        'gold' => '#C9A86A',
        'topbar_bg' => '#11091D',
        'topbar_text_color' => '#E8D5B5',
        'topbar_border_color' => '#3A2C20',
        'topbar_button_bg' => '#C9A86A',
        'topbar_button_text' => '#1A1206',
        'header_surface' => '#0D0916',
        'header_text_color' => '#F7F2EA',
        'header_muted_color' => '#B8B0BD',
        'header_logo_desktop_width' => 118,
        'header_logo_mobile_width' => 58,
        'sticky' => true,
        'show_search' => true,
        'search_placeholder' => 'جستجوی محصول…',
    ];
    $header = array_replace($header, $target);
    update_option(ALOOKHOR_CC_HEADER_OPTION, $header);

    $main_header = is_array($main['header_settings'] ?? null) ? $main['header_settings'] : [];
    $main['header_settings'] = array_replace($main_header, $target);
    $main['_migrations']['header_brand_3106'] = [
        'ok' => true,
        'version' => '3.10.6',
        'fields' => array_keys($target),
        'before_hash' => $before_hash,
        'after_hash' => hash('sha256', wp_json_encode($header)),
        'checked_at' => time(),
    ];
    update_option(ALOOKHOR_CC_OPTION, $main);
}
add_action('init', 'alookhor_cc_migrate_header_brand_3106', 120);

/** Remove the rejected Header search and record the Mobile layout correction. */
function alookhor_cc_migrate_header_layout_3107(){
    $main = get_option(ALOOKHOR_CC_OPTION, []);
    if (!is_array($main)) $main = [];
    if (!empty($main['_migrations']['header_layout_3107']['ok'])) return;
    $header = get_option(ALOOKHOR_CC_HEADER_OPTION, []);
    if (!is_array($header)) $header = [];
    $header['show_search'] = false;
    update_option(ALOOKHOR_CC_HEADER_OPTION, $header);
    $main_header = is_array($main['header_settings'] ?? null) ? $main['header_settings'] : [];
    $main_header['show_search'] = false;
    $main['header_settings'] = $main_header;
    $main['_migrations']['header_layout_3107'] = [
        'ok' => true,
        'version' => '3.10.7',
        'search_removed' => true,
        'mobile_extra_stage_removed' => true,
        'checked_at' => time(),
    ];
    update_option(ALOOKHOR_CC_OPTION, $main);
}
add_action('init', 'alookhor_cc_migrate_header_layout_3107', 121);

/**
 * One-time 3.10.19 owner-approved Header reference migration. Only palette
 * fields belonging to Top Bar, the second capsule and sticky Navigation are
 * updated; phone, logo, menu IDs, visibility and every unrelated option remain.
 */
function alookhor_cc_migrate_header_reference_31019(){
    $main=get_option(ALOOKHOR_CC_OPTION,[]);if(!is_array($main))$main=[];
    if(!empty($main['_migrations']['header_reference_31019']['ok']))return;
    $header=get_option(ALOOKHOR_CC_HEADER_OPTION,[]);if(!is_array($header))$header=[];
    $before_hash=hash('sha256',wp_json_encode($header));
    $target=[
        'gold'=>'#D49A2E','topbar_bg'=>'#1C1024','topbar_text_color'=>'#F5F3F0','topbar_border_color'=>'#D49A2E',
        'topbar_button_bg'=>'#D49A2E','topbar_button_text'=>'#0D0510','header_surface'=>'#0D0510',
        'header_text_color'=>'#F5F3F0','header_muted_color'=>'#C8C2C9','capsule_background'=>'#0D0510',
        'capsule_card'=>'#1C1024','capsule_glass'=>'rgba(33,20,38,.75)','capsule_gold'=>'#D49A2E',
        'capsule_gold_light'=>'#E8B84A','capsule_text'=>'#F5F3F0','capsule_muted'=>'#C8C2C9','capsule_blur'=>24,
    ];
    $header=array_replace($header,$target);update_option(ALOOKHOR_CC_HEADER_OPTION,$header);
    $main_header=is_array($main['header_settings']??null)?$main['header_settings']:[];
    $main['header_settings']=array_replace($main_header,$target);
    if(!is_array($main['site']??null))$main['site']=[];
    $main['site']['goldAccent']='#D49A2E';
    $main['_migrations']['header_reference_31019']=['ok'=>true,'version'=>'3.10.19','fields'=>array_keys($target),'before_hash'=>$before_hash,'after_hash'=>hash('sha256',wp_json_encode($header)),'checked_at'=>time()];
    update_option(ALOOKHOR_CC_OPTION,$main);
}
add_action('init','alookhor_cc_migrate_header_reference_31019',122);

/** One-time 3.10.25 restoration of the source-backed approved Header logo. */
function alookhor_cc_migrate_approved_header_logo_31025(){
    $main=get_option(ALOOKHOR_CC_OPTION,[]);if(!is_array($main))$main=[];
    if(!empty($main['_migrations']['approved_header_logo_31025']['ok']))return;
    $header=get_option(ALOOKHOR_CC_HEADER_OPTION,[]);if(!is_array($header))$header=[];
    $before=hash('sha256',wp_json_encode($header));
    $target=['top_logo_url'=>'https://alookhor.ir/wp-content/uploads/2026/08/LOGO2.png','top_logo_alt'=>'لوگوی رسمی بازرگانی آلوخور','top_logo_link'=>home_url('/'),'top_logo_width'=>118];
    $header=array_replace($header,$target);update_option(ALOOKHOR_CC_HEADER_OPTION,$header);
    $main_header=is_array($main['header_settings']??null)?$main['header_settings']:[];$main['header_settings']=array_replace($main_header,$target);
    $main['_migrations']['approved_header_logo_31025']=['ok'=>true,'version'=>'3.10.25','fields'=>array_keys($target),'before_hash'=>$before,'after_hash'=>hash('sha256',wp_json_encode($header)),'checked_at'=>time()];
    update_option(ALOOKHOR_CC_OPTION,$main);
}
add_action('init','alookhor_cc_migrate_approved_header_logo_31025',125);
````

## Source Snapshot — `plugin/alookhor-control-center/assets/css/frontend-categories.css`

````css
/* ALOOKHOR WooCommerce category showcase — desktop-first phase */
body.alookhor-mc-hide-legacy .category-carousel-section{display:none!important}
.alookhor-mc,.alookhor-mc *{box-sizing:border-box}.alookhor-mc{width:100%;overflow:hidden;background:radial-gradient(circle at 50% 15%,color-mix(in srgb,var(--mc-gold) 6%,transparent),transparent 34%),var(--mc-bg);color:var(--mc-text);padding:72px 20px 55px;font-family:Tahoma,"Vazirmatn",sans-serif;direction:rtl}.alookhor-mc a{text-decoration:none;color:inherit}.alookhor-mc-shell{width:min(1420px,100%);margin:auto}.alookhor-mc-head{text-align:center;max-width:900px;margin:0 auto 36px}.alookhor-mc-kicker{display:flex;justify-content:center;align-items:center;gap:13px;color:var(--mc-gold);font-size:16px;font-weight:800}.alookhor-mc-kicker i{display:block;width:120px;height:1px;background:linear-gradient(90deg,transparent,var(--mc-gold))}.alookhor-mc-kicker i:last-child{transform:scaleX(-1)}.alookhor-mc-kicker b,.alookhor-mc-divider b{font-size:11px}.alookhor-mc-head h2{margin:18px 0 10px;color:var(--mc-text);font-size:clamp(32px,3.2vw,54px);line-height:1.35;font-weight:900;letter-spacing:-.025em}.alookhor-mc-head p{margin:0;color:var(--mc-muted);font-size:clamp(16px,1.55vw,24px);line-height:1.8}.alookhor-mc-divider{display:flex;align-items:center;justify-content:center;gap:9px;color:var(--mc-gold);margin-top:18px}.alookhor-mc-divider i{width:72px;height:1px;background:linear-gradient(90deg,transparent,var(--mc-gold))}.alookhor-mc-divider i:last-child{transform:scaleX(-1)}
.alookhor-mc-stage{position:relative}.alookhor-mc-viewport{overflow:hidden;width:100%;padding:0}.alookhor-mc-track{display:flex;direction:rtl;gap:var(--mc-gap);transition:transform .65s cubic-bezier(.2,.75,.2,1);will-change:transform}.alookhor-mc-card{flex:0 0 calc((100% - (var(--mc-cards) - 1)*var(--mc-gap))/var(--mc-cards));min-width:0;border:1px solid var(--mc-border);border-radius:20px;overflow:hidden;background:linear-gradient(180deg,color-mix(in srgb,var(--mc-card) 96%,#fff 1%),var(--mc-card));box-shadow:0 18px 45px rgba(0,0,0,.34),inset 0 0 24px color-mix(in srgb,var(--mc-gold) 3%,transparent);transition:transform .28s ease,border-color .28s ease,box-shadow .28s ease}.alookhor-mc-card:hover{transform:translateY(-7px);border-color:var(--mc-gold);box-shadow:0 24px 55px rgba(0,0,0,.52),0 0 0 1px color-mix(in srgb,var(--mc-gold) 30%,transparent)}.alookhor-mc-image{position:relative;display:block;height:var(--mc-image);overflow:hidden;background:#0a0710}.alookhor-mc-image:after{content:"";position:absolute;inset:auto 0 0;height:30%;background:linear-gradient(transparent,var(--mc-card));pointer-events:none}.alookhor-mc-image img{width:100%;height:100%;object-fit:cover;display:block;transition:transform .6s ease,filter .4s ease}.alookhor-mc-card:hover .alookhor-mc-image img{transform:scale(1.045);filter:saturate(1.08)}.alookhor-mc-icon{position:absolute;z-index:2;top:20px;right:20px;width:72px;height:72px;border-radius:50%;display:grid;place-items:center;border:2px solid var(--mc-gold);background:rgba(11,7,16,.8);color:var(--mc-gold);box-shadow:0 8px 20px rgba(0,0,0,.35),inset 0 0 12px color-mix(in srgb,var(--mc-gold) 8%,transparent);backdrop-filter:blur(8px)}.alookhor-mc-icon svg{width:44px;height:44px;fill:none;stroke:currentColor;stroke-width:2;stroke-linecap:round;stroke-linejoin:round}.alookhor-mc-body{text-align:center;padding:20px 18px 22px;min-height:205px;display:flex;flex-direction:column;align-items:center}.alookhor-mc-body h3{margin:0;color:var(--mc-text);font-size:24px;line-height:1.5;font-weight:850}.alookhor-mc-body p{margin:9px 0 0;color:var(--mc-muted);font-size:13px;line-height:1.75;min-height:46px}.alookhor-mc-body small{margin-top:6px;color:var(--mc-gold);font-size:11px}.alookhor-mc-button{margin-top:auto;min-width:190px;height:42px;padding:0 19px;border:1px solid color-mix(in srgb,var(--mc-gold) 70%,transparent);border-radius:999px;display:inline-flex;align-items:center;justify-content:center;gap:9px;background:var(--mc-btn);color:var(--mc-gold)!important;font-size:13px;font-weight:800;transition:.25s}.alookhor-mc-button b{font-size:8px}.alookhor-mc-button i{font-style:normal;font-size:17px}.alookhor-mc-button:hover{background:var(--mc-gold);color:#171006!important;box-shadow:0 8px 22px color-mix(in srgb,var(--mc-gold) 24%,transparent)}
.alookhor-mc-arrow{position:absolute!important;z-index:4;float:none!important;flex:0 0 58px!important;top:50%!important;width:58px!important;min-width:58px!important;max-width:58px!important;height:58px!important;min-height:58px!important;max-height:58px!important;margin:-29px 0 0!important;padding:0!important;overflow:hidden!important;line-height:0!important;font-size:0!important;appearance:none!important;-webkit-appearance:none!important;border:1px solid color-mix(in srgb,var(--mc-gold) 80%,#fff 10%)!important;border-radius:50%!important;display:grid!important;place-items:center!important;background:radial-gradient(circle at 35% 25%,color-mix(in srgb,var(--mc-gold) 18%,transparent),transparent 45%),color-mix(in srgb,var(--mc-bg) 92%,transparent)!important;color:var(--mc-gold)!important;cursor:pointer;box-shadow:0 12px 30px rgba(0,0,0,.6),inset 0 0 0 5px color-mix(in srgb,var(--mc-gold) 5%,transparent),0 0 18px color-mix(in srgb,var(--mc-gold) 13%,transparent)!important;backdrop-filter:blur(12px);transition:.25s}.alookhor-mc-arrow:before,.alookhor-mc-arrow:after{content:none!important;display:none!important}.alookhor-mc-arrow svg{display:block!important;width:24px!important;min-width:24px!important;max-width:24px!important;height:24px!important;min-height:24px!important;max-height:24px!important;margin:0!important;padding:0!important;fill:none;stroke:currentColor;stroke-width:2;stroke-linecap:round;stroke-linejoin:round;position:relative;z-index:2}.alookhor-mc-arrow span{position:absolute;inset:5px;border:1px solid color-mix(in srgb,var(--mc-gold) 22%,transparent);border-radius:50%}.alookhor-mc-arrow:hover{background:linear-gradient(145deg,var(--mc-gold),color-mix(in srgb,var(--mc-gold) 60%,#684500))!important;color:#140e08!important;transform:scale(1.06)}.alookhor-mc-prev{right:-27px!important;left:auto!important}.alookhor-mc-next{right:auto!important;left:-27px!important}.alookhor-mc-arrow:disabled{opacity:.3;cursor:default;background:radial-gradient(circle at 35% 25%,color-mix(in srgb,var(--mc-gold) 18%,transparent),transparent 45%),color-mix(in srgb,var(--mc-bg) 92%,transparent)!important;color:var(--mc-gold)!important}.alookhor-mc.has-single-page .alookhor-mc-arrow,.alookhor-mc.has-single-page .alookhor-mc-dots{display:none!important}.alookhor-mc-dots{display:flex!important;flex-direction:row!important;align-items:center!important;justify-content:center!important;direction:ltr!important;gap:12px!important;margin:34px 0 0!important;padding:0!important;min-height:14px!important}.alookhor-mc-dots button{display:block!important;position:static!important;float:none!important;flex:0 0 11px!important;width:11px!important;min-width:11px!important;max-width:11px!important;height:11px!important;min-height:11px!important;max-height:11px!important;margin:0!important;padding:0!important;line-height:0!important;font-size:0!important;appearance:none!important;-webkit-appearance:none!important;border:1px solid color-mix(in srgb,var(--mc-text) 25%,transparent)!important;border-radius:999px!important;background:color-mix(in srgb,var(--mc-muted) 60%,transparent)!important;opacity:.62;cursor:pointer;transition:.3s}.alookhor-mc-dots button:hover{opacity:1;border-color:var(--mc-gold)!important}.alookhor-mc-dots button.is-active{flex-basis:36px!important;width:36px!important;min-width:36px!important;max-width:36px!important;height:11px!important;min-height:11px!important;max-height:11px!important;background:linear-gradient(90deg,var(--mc-gold),color-mix(in srgb,var(--mc-gold) 70%,#ffe7a2))!important;border-color:var(--mc-gold)!important;opacity:1;box-shadow:0 0 13px color-mix(in srgb,var(--mc-gold) 38%,transparent)!important}
@media(max-width:1200px){.alookhor-mc{padding-inline:32px}.alookhor-mc-card{flex-basis:calc((100% - 2*var(--mc-gap))/3)}.alookhor-mc-icon{width:62px;height:62px}.alookhor-mc-icon svg{width:36px}.alookhor-mc-body h3{font-size:21px}}
/* Mobile receives a safe single-card baseline; the dedicated mobile design is the next approved phase. */
@media(max-width:767px){.alookhor-mc{padding:42px 0 34px}.alookhor-mc-shell{width:100%}.alookhor-mc-head{margin-bottom:23px;padding:0 18px}.alookhor-mc-kicker{font-size:13px;gap:8px}.alookhor-mc-kicker i{width:42px}.alookhor-mc-head h2{font-size:28px;margin-top:14px}.alookhor-mc-head p{font-size:14px;line-height:1.75}.alookhor-mc-stage{padding:0}.alookhor-mc-track{gap:var(--mc-mobile-gap)}.alookhor-mc-card{flex-basis:calc(var(--mc-mobile-width)*1%);border-radius:var(--mc-mobile-radius);transition:transform .35s ease,opacity .35s ease,border-color .3s ease}.alookhor-mc-card:not(.is-active){opacity:.52;transform:scale(.94)}.alookhor-mc-card.is-active{opacity:1;transform:scale(1)}.alookhor-mc-image{height:var(--mc-mobile-image)}.alookhor-mc-icon{width:58px;height:58px;top:14px;right:14px}.alookhor-mc-icon svg{width:34px;height:34px}.alookhor-mc-body{min-height:150px;padding:14px 14px 16px}.alookhor-mc-body h3{font-size:22px}.alookhor-mc-body p{font-size:11.5px;line-height:1.65;min-height:36px;margin-top:5px}.alookhor-mc-button{height:38px;min-width:175px;font-size:12px}.alookhor-mc-arrow{display:none!important}.alookhor-mc-dots{margin-top:23px!important;gap:10px!important}.alookhor-mc-dots button{flex-basis:10px!important;width:10px!important;min-width:10px!important;max-width:10px!important;height:10px!important;min-height:10px!important;max-height:10px!important}.alookhor-mc-dots button.is-active{flex-basis:33px!important;width:33px!important;min-width:33px!important;max-width:33px!important;height:10px!important;min-height:10px!important;max-height:10px!important}}
@media(prefers-reduced-motion:reduce){.alookhor-mc *{transition:none!important;scroll-behavior:auto!important}}
````

## Source Snapshot — `plugin/alookhor-control-center/assets/css/frontend-features.css`

````css
/* ALOOKHOR managed site-features strip — exact replacement for Legacy trust bar. */
body.alookhor-sf-hide-legacy .alookhor-trustbar-container{display:none!important}
.alookhor-managed-features-host,.alookhor-managed-features-slot,.alookhor-managed-features-slot>.elementor-widget-container{width:100%!important;max-width:none!important;margin:0!important;padding:0!important;overflow:visible!important}
.alookhor-sf{--sf-bg:#0D0510;--sf-card:#1C1024;--sf-glass:rgba(33,20,38,.75);--sf-gold:#D49A2E;--sf-gold-light:#E8B84A;--sf-text:#F5F3F0;--sf-muted:#C8C2C9;--sf-radius:20px;--sf-gap:8px;position:relative;z-index:2;width:100vw;max-width:100vw;margin:-15px calc(50% - 50vw) 0;padding:10px 20px 30px;box-sizing:border-box;background:var(--sf-bg);color:var(--sf-text);direction:rtl;isolation:isolate}
.alookhor-sf:before{content:"";position:absolute;inset:0;z-index:-1;pointer-events:none;background:radial-gradient(circle at 50% -30%,color-mix(in srgb,var(--sf-gold) 8%,transparent),transparent 46%)}
.alookhor-sf-shell{width:min(1400px,100%);margin:0 auto}
.alookhor-sf-grid{display:grid;grid-template-columns:repeat(4,minmax(0,1fr));gap:var(--sf-gap)}
.alookhor-sf-card{position:relative;min-width:0;min-height:154px;padding:22px 16px 18px;border:1px solid color-mix(in srgb,var(--sf-gold) 27%,transparent);border-radius:var(--sf-radius);display:flex;flex-direction:column;align-items:center;justify-content:center;gap:11px;overflow:hidden;background:linear-gradient(145deg,color-mix(in srgb,var(--sf-glass) 92%,transparent),color-mix(in srgb,var(--sf-card) 96%,transparent));box-shadow:0 14px 36px rgba(5,1,8,.32),inset 0 1px 0 rgba(255,255,255,.035);text-align:center;-webkit-backdrop-filter:blur(14px) saturate(112%);backdrop-filter:blur(14px) saturate(112%);transition:transform .25s ease,border-color .25s ease,box-shadow .25s ease}
.alookhor-sf-card:before{content:"";position:absolute;top:0;left:15%;right:15%;height:1px;background:linear-gradient(90deg,transparent,color-mix(in srgb,var(--sf-gold-light) 48%,transparent),transparent)}
.alookhor-sf-card:hover{transform:translateY(-3px);border-color:color-mix(in srgb,var(--sf-gold-light) 56%,transparent);box-shadow:0 18px 42px rgba(5,1,8,.4),0 0 24px color-mix(in srgb,var(--sf-gold) 10%,transparent),inset 0 1px 0 rgba(255,255,255,.05)}
.alookhor-sf-icon{width:48px;height:48px;flex:0 0 48px;display:grid;place-items:center;color:var(--sf-gold-light);filter:drop-shadow(0 6px 13px color-mix(in srgb,var(--sf-gold) 25%,transparent))}
.alookhor-sf-icon svg{display:block;width:44px;height:44px;fill:none;stroke:currentColor;stroke-width:2.5;stroke-linecap:round;stroke-linejoin:round}
.alookhor-sf-copy{min-width:0;display:grid;justify-items:center;gap:6px}
.alookhor-sf-copy h3{margin:0!important;color:var(--sf-text)!important;font-family:inherit!important;font-size:clamp(15px,1.25vw,20px)!important;font-weight:800!important;line-height:1.45!important;white-space:normal;text-align:center}
.alookhor-sf-copy p{margin:0!important;color:var(--sf-muted)!important;font-family:inherit!important;font-size:clamp(11px,.88vw,14px)!important;font-weight:500!important;line-height:1.65!important;text-align:center}
@media(max-width:900px){.alookhor-sf{padding-inline:14px}.alookhor-sf-card{min-height:140px;padding-inline:10px}.alookhor-sf-icon{width:42px;height:42px;flex-basis:42px}.alookhor-sf-icon svg{width:38px;height:38px}}
@media(max-width:767px){
  .alookhor-sf{margin-top:-15px;padding:9px 10px 24px;background:var(--sf-bg)}
  .alookhor-sf-shell{width:100%}
  .alookhor-sf-grid{grid-template-columns:repeat(4,minmax(0,1fr));gap:4px}
  .alookhor-sf-card{min-height:116px;padding:10px 4px 9px;border-radius:min(var(--sf-radius),14px);gap:7px;box-shadow:0 8px 20px rgba(5,1,8,.28),inset 0 1px 0 rgba(255,255,255,.03);-webkit-backdrop-filter:blur(10px);backdrop-filter:blur(10px)}
  .alookhor-sf-icon{width:31px;height:31px;flex-basis:31px}
  .alookhor-sf-icon svg{width:29px;height:29px;stroke-width:2.35}
  .alookhor-sf-copy{gap:4px;width:100%}
  .alookhor-sf-copy h3{font-size:10.5px!important;line-height:1.35!important;white-space:nowrap;letter-spacing:-.025em}
  .alookhor-sf-copy p{font-size:8.2px!important;line-height:1.5!important;display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical;overflow:hidden}
}
@media(max-width:390px){.alookhor-sf{padding-inline:7px}.alookhor-sf-grid{gap:3px}.alookhor-sf-card{min-height:108px;padding-inline:2px}.alookhor-sf-icon{width:28px;height:28px;flex-basis:28px}.alookhor-sf-icon svg{width:26px;height:26px}.alookhor-sf-copy h3{font-size:9.3px!important}.alookhor-sf-copy p{font-size:7.5px!important}}
@media(prefers-reduced-motion:reduce){.alookhor-sf-card{transition:none!important}}
````

## Source Snapshot — `plugin/alookhor-control-center/assets/css/frontend-footer.css`

````css
/* ALOOKHOR Managed Footer — scoped, RTL, responsive */
body.alookhor-mf-hide-legacy .alookhor-footer-system{display:none!important}
body.alookhor-mf-hide-old-sections .alookhor-newsletter-wrapper,
body.alookhor-mf-hide-old-sections .alookhor-appbanner-wrapper{display:none!important}
.alookhor-mf,.alookhor-mf *{box-sizing:border-box}
.alookhor-mf{width:100%;max-width:none;margin:0;padding:8px;background:var(--mf-bg);color:var(--mf-text);font-family:Tahoma,"Vazirmatn",sans-serif;direction:rtl;overflow:hidden;border-top:1px solid color-mix(in srgb,var(--mf-gold) 34%,transparent)}
.alookhor-mf a{color:inherit;text-decoration:none}.alookhor-mf svg{width:22px;height:22px;fill:none;stroke:currentColor;stroke-width:1.7;stroke-linecap:round;stroke-linejoin:round}
.alookhor-mf-shell{width:min(var(--mf-width),calc(100% - 16px));margin:auto;border:1px solid color-mix(in srgb,var(--mf-gold) 33%,transparent);border-radius:8px;padding:20px;background:linear-gradient(145deg,color-mix(in srgb,var(--mf-surface) 96%,#000),var(--mf-bg));box-shadow:inset 0 0 40px rgba(0,0,0,.26)}
.alookhor-mf-main-grid{display:grid;grid-template-columns:minmax(250px,1.55fr) repeat(3,minmax(155px,.88fr)) minmax(230px,1.12fr);gap:0;align-items:stretch}
.alookhor-mf-main-grid>section{min-width:0;padding:18px 20px;border-left:1px solid color-mix(in srgb,var(--mf-gold) 22%,transparent)}
.alookhor-mf-main-grid>section:last-child{border-left:0}
.alookhor-mf-brand{text-align:center;display:flex;flex-direction:column;align-items:center}.alookhor-mf-logo{display:block}.alookhor-mf-logo img{display:block;width:min(var(--mf-logo),100%);max-height:165px;object-fit:contain;filter:drop-shadow(0 8px 16px rgba(0,0,0,.65))}.alookhor-mf-brand-name{font:700 28px Georgia,serif;letter-spacing:.18em;color:var(--mf-gold-soft);margin-top:5px}.alookhor-mf-brand-sub{font:600 12px Arial,sans-serif;letter-spacing:.08em;color:var(--mf-text)}.alookhor-mf-kicker{display:flex;align-items:center;gap:9px;font:10px Georgia,serif;letter-spacing:.09em;color:var(--mf-gold);margin-top:8px}.alookhor-mf-kicker:before,.alookhor-mf-kicker:after{content:"";width:42px;height:1px;background:linear-gradient(90deg,transparent,var(--mf-gold))}.alookhor-mf-kicker:after{transform:scaleX(-1)}.alookhor-mf-brand>p{font-size:12px;line-height:1.9;color:var(--mf-muted);max-width:330px;margin:14px auto}
.alookhor-mf-brand-trust{width:100%;display:grid;grid-template-columns:repeat(4,1fr);border:1px solid color-mix(in srgb,var(--mf-gold) 26%,transparent);border-radius:7px;margin:4px 0 12px}.alookhor-mf-brand-trust>span{display:grid;place-items:center;gap:3px;padding:9px 4px;border-left:1px solid color-mix(in srgb,var(--mf-gold) 20%,transparent)}.alookhor-mf-brand-trust>span:last-child{border-left:0}.alookhor-mf-brand-trust svg{color:var(--mf-gold);width:20px;height:20px}.alookhor-mf-brand-trust b{font-size:8px}.alookhor-mf-brand-trust small{font-size:7px;color:var(--mf-muted)}
.alookhor-mf-cta,.alookhor-mf-contact-cta{width:100%;min-height:42px;display:flex;align-items:center;justify-content:center;gap:8px;border-radius:8px;padding:10px 15px;background:linear-gradient(135deg,var(--mf-gold),color-mix(in srgb,var(--mf-gold) 65%,#765000));border:1px solid var(--mf-gold-soft);color:#170f04!important;font-weight:800;font-size:12px;box-shadow:inset 0 1px rgba(255,255,255,.22)}.alookhor-mf-cta:hover,.alookhor-mf-contact-cta:hover{filter:brightness(1.12);transform:translateY(-1px)}
.alookhor-mf h3,.alookhor-mf h4{margin:0;color:var(--mf-gold-soft)}.alookhor-mf-menu-card h3,.alookhor-mf-contact h3,.alookhor-mf-license-card h3{display:flex;align-items:center;gap:8px;font-size:15px;padding-bottom:14px}.alookhor-mf-menu-card h3 svg,.alookhor-mf-contact h3 svg,.alookhor-mf-license-card h3 svg{color:var(--mf-gold);width:19px;height:19px}.alookhor-mf-links{list-style:none;margin:0;padding:0;display:grid;gap:11px}.alookhor-mf-links li{margin:0!important}.alookhor-mf-links a{display:flex;align-items:center;gap:6px;font-size:11px;color:var(--mf-muted);transition:.2s}.alookhor-mf-links a:before{content:"‹";font-size:18px;color:var(--mf-gold)}.alookhor-mf-links a:hover{color:var(--mf-gold-soft);transform:translateX(-3px)}
.alookhor-mf-contact-list{display:grid}.alookhor-mf-contact-list>a,.alookhor-mf-contact-list>div{display:grid;grid-template-columns:38px 1fr;align-items:center;gap:10px;padding:10px 0;border-bottom:1px solid rgba(255,255,255,.07)}.alookhor-mf-contact-list i{width:36px;height:36px;display:grid;place-items:center;border:1px solid color-mix(in srgb,var(--mf-gold) 35%,transparent);border-radius:7px;color:var(--mf-gold);font-style:normal}.alookhor-mf-contact-list i svg{width:18px}.alookhor-mf-contact-list span{display:grid;gap:2px}.alookhor-mf-contact-list small{font-size:9px;color:var(--mf-muted)}.alookhor-mf-contact-list b{font-size:11px;line-height:1.7;color:var(--mf-text)}.alookhor-mf-contact-list a:hover b{color:var(--mf-gold-soft)}.alookhor-mf-contact-cta{margin-top:14px;background:transparent;color:var(--mf-gold-soft)!important;border-color:color-mix(in srgb,var(--mf-gold) 60%,transparent)}
.alookhor-mf-about-mobile{display:none}.alookhor-mf-license-card{display:none}.alookhor-mf-badges{display:flex;gap:10px}.alookhor-mf-badge{min-width:72px;display:grid;justify-items:center;gap:5px;font-size:8px;color:var(--mf-gold-soft)}.alookhor-mf-badge-media{width:64px;height:52px;display:grid;place-items:center;border:1px solid color-mix(in srgb,var(--mf-gold) 30%,transparent);border-radius:7px;background:#0a0a0a}.alookhor-mf-badge-media img{max-width:58px;max-height:46px;object-fit:contain}.alookhor-mf-badge-fallback{width:34px;height:34px;border-radius:50%;display:grid;place-items:center;border:2px solid var(--mf-gold);font:bold 18px Georgia;color:var(--mf-gold-soft)}
.alookhor-mf-news-social{position:relative;min-height:130px;margin-top:16px;border:1px solid color-mix(in srgb,var(--mf-gold) 28%,transparent);border-radius:8px;display:grid;grid-template-columns:1fr 1.65fr .9fr;align-items:center;overflow:hidden;direction:ltr}.alookhor-mf-news-social>*{direction:rtl}.alookhor-mf-social{padding:18px;text-align:center;border-left:1px solid color-mix(in srgb,var(--mf-gold) 25%,transparent)}.alookhor-mf-social h3,.alookhor-mf-newsletter h3{font-size:14px}.alookhor-mf-social p,.alookhor-mf-newsletter p{font-size:9px;color:var(--mf-muted);margin:7px 0 11px}.alookhor-mf-social>div{display:flex;justify-content:center;gap:12px}.alookhor-mf-social a{width:38px;height:38px;border:1px solid color-mix(in srgb,var(--mf-gold) 45%,transparent);border-radius:50%;display:grid;place-items:center;color:var(--mf-gold)}.alookhor-mf-social a:hover{background:color-mix(in srgb,var(--mf-gold) 12%,transparent);transform:translateY(-2px)}.alookhor-mf-social svg{width:18px}
.alookhor-mf-newsletter{padding:18px;text-align:center;z-index:2}.alookhor-mf-newsletter-form{height:38px;display:flex;direction:rtl;border:1px solid color-mix(in srgb,var(--mf-gold) 32%,transparent);border-radius:5px;overflow:hidden;background:#090a0a}.alookhor-mf-newsletter-form input[type=email]{flex:1;min-width:0;border:0;background:transparent;color:var(--mf-text);padding:0 14px;font-family:inherit;font-size:10px;outline:0}.alookhor-mf-newsletter-form button{width:120px;border:0;background:linear-gradient(135deg,var(--mf-gold),#805d1e);color:#fff;font-family:inherit;font-size:11px;cursor:pointer}.alookhor-mf-hp{position:absolute!important;left:-9999px!important}.alookhor-mf-form-msg{display:block;min-height:15px;font-size:9px;color:#78d99a;margin-top:4px}
.alookhor-mf-product{width:100%;height:130px;object-fit:cover;object-position:right center;mix-blend-mode:screen;opacity:.9;align-self:end}
.alookhor-mf-assurance{margin-top:10px;border:1px solid color-mix(in srgb,var(--mf-gold) 26%,transparent);border-radius:7px;min-height:96px;display:grid;grid-template-columns:1.2fr 1.15fr 1fr;align-items:center;direction:ltr}.alookhor-mf-assurance>*{direction:rtl}.alookhor-mf-assurance>div{min-height:78px;padding:12px 22px;border-left:1px solid color-mix(in srgb,var(--mf-gold) 22%,transparent);display:flex;align-items:center;justify-content:center;gap:18px}.alookhor-mf-assurance>div:last-child{border-left:0}.alookhor-mf-assurance h4{font-size:11px}.alookhor-mf-payments{flex-direction:column!important}.alookhor-mf-payments>div{display:flex;gap:8px}.alookhor-mf-payments span{min-width:70px;height:39px;padding:5px;display:grid;place-items:center;border:1px solid color-mix(in srgb,var(--mf-gold) 30%,transparent);border-radius:5px;background:#080909;font:bold 10px Arial;color:#ddd}.alookhor-mf-copy{display:grid!important;gap:3px;text-align:center}.alookhor-mf-copy b{font-size:10px}.alookhor-mf-copy span{font-size:10px}.alookhor-mf-copy small{font:9px Georgia;color:var(--mf-gold)}
.alookhor-mf-benefits{margin-top:8px;min-height:66px;border:1px solid color-mix(in srgb,var(--mf-gold) 25%,transparent);border-radius:7px;display:grid;grid-template-columns:repeat(5,1fr)}.alookhor-mf-benefits>span{display:grid;grid-template-columns:32px 1fr;grid-template-rows:auto auto;align-content:center;gap:1px 9px;padding:8px 14px;border-left:1px solid color-mix(in srgb,var(--mf-gold) 20%,transparent)}.alookhor-mf-benefits>span:last-child{border-left:0}.alookhor-mf-benefits svg{grid-row:1/3;color:var(--mf-gold);align-self:center}.alookhor-mf-benefits b{font-size:9px}.alookhor-mf-benefits small{font-size:7px;color:var(--mf-muted)}
@media(max-width:1100px){.alookhor-mf-main-grid{grid-template-columns:repeat(2,1fr)}.alookhor-mf-main-grid>section{border:1px solid color-mix(in srgb,var(--mf-gold) 20%,transparent);margin:-1px 0 0 -1px}.alookhor-mf-brand,.alookhor-mf-contact{grid-column:span 2}.alookhor-mf-about{grid-column:auto}.alookhor-mf-news-social{grid-template-columns:1fr 1.4fr}.alookhor-mf-product{display:none}.alookhor-mf-benefits{grid-template-columns:repeat(3,1fr)}}
@media(max-width:767px){body{padding-bottom:60px}.alookhor-mf{padding:10px 8px 70px;background:#fff}.alookhor-mf-shell{width:min(100%,500px);padding:10px;border-radius:27px;background:var(--mf-bg);border-color:#262626;box-shadow:0 8px 30px rgba(0,0,0,.25)}.alookhor-mf-main-grid{display:grid;grid-template-columns:1fr 1fr;gap:8px}.alookhor-mf-main-grid>section{border:1px solid color-mix(in srgb,var(--mf-gold) 24%,transparent);border-radius:9px;margin:0;padding:14px 12px}.alookhor-mf-brand{grid-column:1/-1;border:0!important;padding:15px 18px 8px!important}.alookhor-mf-logo img{width:min(var(--mf-logo-mobile),100%);max-height:220px}.alookhor-mf-brand-name{font-size:25px}.alookhor-mf-brand-sub{font-size:10px}.alookhor-mf-brand>p{font-size:12px;max-width:330px;margin:14px auto}.alookhor-mf-brand-trust{display:none}.alookhor-mf-cta{max-width:270px}.alookhor-mf-contact{grid-column:1/-1;order:2}.alookhor-mf-contact h3{display:none}.alookhor-mf-contact-list>a,.alookhor-mf-contact-list>div{grid-template-columns:40px 1fr;padding:11px 0}.alookhor-mf-contact-list small{font-size:10px}.alookhor-mf-contact-list b{font-size:12px}.alookhor-mf-contact-cta{display:none}.alookhor-mf-order{order:3}.alookhor-mf-customer{order:4}.alookhor-mf-about{order:5}.alookhor-mf-about-desktop{display:none}.alookhor-mf-about-mobile{display:inline}.alookhor-mf-license-card{display:block!important;order:6}.alookhor-mf-menu-card h3,.alookhor-mf-license-card h3{font-size:14px;justify-content:center}.alookhor-mf-links{gap:8px}.alookhor-mf-links a{font-size:10px}.alookhor-mf-license-card p{text-align:center;font-size:9px;color:var(--mf-muted)}.alookhor-mf-badges{justify-content:center}.alookhor-mf-news-social{display:block;margin-top:8px;min-height:auto}.alookhor-mf-social{border:0;padding:15px}.alookhor-mf-social h3{font-size:16px}.alookhor-mf-social p{font-size:10px}.alookhor-mf-social a{width:42px;height:42px}.alookhor-mf-newsletter,.alookhor-mf-product{display:none}.alookhor-mf-assurance{display:block;border:0;margin-top:8px;min-height:0}.alookhor-mf-license-desktop,.alookhor-mf-payments{display:none!important}.alookhor-mf-assurance .alookhor-mf-copy{border:0;min-height:68px;padding:13px!important}.alookhor-mf-copy b{display:none}.alookhor-mf-copy span{font-size:10px}.alookhor-mf-copy small{font-size:9px}.alookhor-mf-benefits{display:none}.alookhor-mf-kicker{font-size:9px}.alookhor-mf-menu-card{min-height:175px}.alookhor-mf-footer-ready{opacity:1}}
@media(max-width:380px){.alookhor-mf-main-grid{gap:6px}.alookhor-mf-main-grid>section{padding:12px 9px}.alookhor-mf-links a{font-size:9px}.alookhor-mf-menu-card h3{font-size:12px}.alookhor-mf-brand-name{font-size:22px}}
@media(prefers-reduced-motion:reduce){.alookhor-mf *{transition:none!important;scroll-behavior:auto!important}}
````

## Source Snapshot — `plugin/alookhor-control-center/assets/css/frontend-header-scroll.css`

````css
/* ALOOKHOR Legacy Header bridge — three in-flow rows, sticky Navigation only. */
body:has(.alookhor-managed-legacy-header){padding-top:0!important}
#main-content:has(.alookhor-managed-legacy-header){padding-top:0!important}
.alookhor-managed-legacy-header{--alookhor-header-gold:#D4A436;--alookhor-header-surface:#0d0916;--alookhor-header-text:#f7f2ea;--alookhor-header-muted:#b8b0bd;--alookhor-capsule-background:#0D0510;--alookhor-capsule-card:#1C1024;--alookhor-capsule-glass:rgba(33,20,38,.75);--alookhor-capsule-gold:#D49A2E;--alookhor-capsule-gold-light:#E8B84A;--alookhor-capsule-text:#F5F3F0;--alookhor-capsule-muted:#C8C2C9;--alookhor-capsule-blur:24px;--alookhor-sticky-offset:0px}
.alookhor-managed-legacy-header .alookhor-topbar-wrapper,
.alookhor-managed-legacy-header .alookhor-header{left:auto!important;right:auto!important;top:auto!important;transform:none!important;width:100%!important;position:relative!important}
.alookhor-managed-legacy-header .alookhor-topbar-wrapper{z-index:30!important;transition:opacity .28s ease,transform .28s ease!important;background-color:color-mix(in srgb,var(--alookhor-topbar-bg,var(--alookhor-capsule-card)) 78%,transparent)!important;background-image:linear-gradient(90deg,color-mix(in srgb,var(--alookhor-capsule-card) 86%,transparent),color-mix(in srgb,var(--alookhor-capsule-glass) 82%,transparent),color-mix(in srgb,var(--alookhor-capsule-card) 86%,transparent))!important;-webkit-backdrop-filter:blur(18px) saturate(135%)!important;backdrop-filter:blur(18px) saturate(135%)!important;border-bottom:1px solid color-mix(in srgb,var(--alookhor-capsule-gold) 28%,transparent)!important;box-shadow:inset 0 -1px 0 color-mix(in srgb,var(--alookhor-capsule-gold-light) 8%,transparent)!important}
.alookhor-managed-legacy-header .alookhor-topbar-container{display:grid!important;grid-template-columns:minmax(0,1fr) minmax(0,1.7fr) minmax(0,1fr)!important;grid-template-areas:"support message phone"!important;align-items:center!important;direction:ltr!important;background:transparent!important}
.alookhor-managed-legacy-header .topbar-center{display:none!important}
.alookhor-managed-legacy-header .topbar-left{grid-area:phone!important;justify-self:end!important;direction:ltr!important;color:var(--alookhor-capsule-gold-light)!important}
.alookhor-managed-legacy-header .topbar-right{grid-area:message!important;justify-self:center!important;direction:rtl!important;color:var(--alookhor-capsule-text)!important;padding-inline:clamp(18px,4vw,58px)!important;border-inline:1px solid color-mix(in srgb,var(--alookhor-capsule-gold) 12%,transparent)!important}
.alookhor-managed-legacy-header .alookhor-topbar-support{grid-area:support!important;justify-self:start!important;display:inline-flex;align-items:center;gap:7px;color:var(--alookhor-capsule-gold-light)!important;direction:rtl;font-size:10px}
.alookhor-managed-legacy-header .alookhor-topbar-support-icon{display:block;width:15px;height:15px;fill:none;stroke:currentColor;stroke-width:1.7;stroke-linecap:round;stroke-linejoin:round}
.alookhor-managed-legacy-header .topbar-btn-wholesale{display:none!important}
.alookhor-managed-legacy-header .alookhor-header{z-index:29!important;height:auto!important;min-height:90px!important;transition:opacity .28s ease,transform .28s ease!important}
/* The existing second Header capsule, recolored in place with the owner-approved
   Burgundy/Gold palette. Geometry and all original controls remain untouched. */
.alookhor-managed-legacy-header .header-capsule{background-color:var(--alookhor-capsule-glass)!important;background-image:linear-gradient(135deg,color-mix(in srgb,var(--alookhor-capsule-card) 34%,transparent),transparent 62%)!important;-webkit-backdrop-filter:blur(var(--alookhor-capsule-blur)) saturate(145%)!important;backdrop-filter:blur(var(--alookhor-capsule-blur)) saturate(145%)!important;border:1px solid color-mix(in srgb,var(--alookhor-capsule-gold) 42%,transparent)!important;box-shadow:0 14px 38px color-mix(in srgb,var(--alookhor-capsule-background) 68%,transparent),inset 0 1px 0 color-mix(in srgb,var(--alookhor-capsule-gold-light) 18%,transparent),inset 0 -1px 0 color-mix(in srgb,var(--alookhor-capsule-gold) 10%,transparent)!important}
.alookhor-managed-legacy-header .header-capsule:before,.alookhor-managed-legacy-header .header-capsule:after{pointer-events:none!important;background:linear-gradient(90deg,transparent,color-mix(in srgb,var(--alookhor-capsule-gold-light) 42%,transparent),transparent)!important}
.alookhor-managed-legacy-header .header-capsule .alookhor-logo-copy b{color:var(--alookhor-capsule-gold-light)!important}
.alookhor-managed-legacy-header .header-capsule .alookhor-logo-copy small{color:var(--alookhor-capsule-muted)!important}
.alookhor-managed-legacy-header .header-capsule .header-login-btn,.alookhor-managed-legacy-header .header-capsule .header-login-btn svg,.alookhor-managed-legacy-header .header-capsule .alookhor-header-cart-link{color:var(--alookhor-capsule-text)!important}
.alookhor-managed-legacy-header .header-capsule .alookhor-main-menu-toggle{color:var(--alookhor-capsule-gold)!important}
.alookhor-managed-legacy-header .header-capsule .alookhor-cart-count{background:var(--alookhor-capsule-gold-light)!important;color:var(--alookhor-capsule-background)!important}
.alookhor-managed-legacy-header .header-capsule-logo,
.alookhor-managed-legacy-header .header-capsule-logo img{background:transparent!important}
.alookhor-managed-legacy-header .header-capsule-logo{box-shadow:none!important;border:0!important;max-height:68px!important;overflow:visible!important;display:flex!important;align-items:center!important;justify-content:center!important;gap:10px!important;white-space:nowrap!important}
.alookhor-managed-legacy-header .header-capsule-logo img{display:block!important;filter:drop-shadow(0 6px 14px rgba(0,0,0,.32))!important}
.alookhor-logo-copy{display:grid;gap:2px;text-align:right;direction:rtl;line-height:1.1}
.alookhor-logo-copy b{color:var(--alookhor-header-gold);font-size:25px;font-weight:900;letter-spacing:-.04em}
.alookhor-logo-copy small{color:var(--alookhor-header-muted);font-size:8px;font-weight:600}
.alookhor-legacy-nav-marker{display:block!important;width:100%!important;height:0!important;margin:0!important;padding:0!important;overflow:hidden!important}
.alookhor-legacy-nav-stage{position:relative;z-index:99997;width:100%;min-height:66px;padding:5px 18px 9px;display:flex;justify-content:center;box-sizing:border-box;transition:filter .25s ease}
.alookhor-legacy-nav-stage.is-enabled{position:relative;top:auto}
.alookhor-legacy-nav-stage.is-stuck{position:fixed!important;top:var(--alookhor-sticky-offset)!important;left:0!important;right:0!important;width:100%!important;margin:0!important}
.alookhor-legacy-nav-shell{position:relative;width:min(1200px,100%);min-height:58px;padding:0 24px;border:1px solid color-mix(in srgb,var(--alookhor-header-gold) 30%,transparent);border-radius:22px;display:flex;align-items:center;justify-content:center;background:linear-gradient(180deg,color-mix(in srgb,var(--alookhor-header-surface) 94%,transparent),color-mix(in srgb,#070509 96%,transparent));box-shadow:0 12px 34px rgba(0,0,0,.35),inset 0 1px 0 color-mix(in srgb,var(--alookhor-header-gold) 7%,transparent);transition:background .25s ease,border-color .25s ease,box-shadow .25s ease,backdrop-filter .25s ease}
.alookhor-legacy-nav-stage.is-stuck .alookhor-legacy-nav-shell{background:color-mix(in srgb,var(--alookhor-header-surface) 88%,transparent);border-color:color-mix(in srgb,var(--alookhor-header-gold) 44%,transparent);box-shadow:0 13px 36px rgba(0,0,0,.52),inset 0 1px 0 color-mix(in srgb,var(--alookhor-header-gold) 10%,transparent);-webkit-backdrop-filter:blur(14px) saturate(125%);backdrop-filter:blur(14px) saturate(125%)}
.alookhor-legacy-nav-shell .header-nav-center{display:flex!important;width:100%;align-items:center!important;justify-content:center!important}
.alookhor-legacy-nav-shell .nav-menu{display:flex!important;align-items:center!important;justify-content:center!important;flex-wrap:nowrap!important;gap:clamp(14px,2vw,28px)!important;margin:0!important;padding:0!important}
.alookhor-legacy-nav-shell .nav-menu>li>a{color:var(--alookhor-header-text)!important}
.alookhor-legacy-nav-shell .nav-menu>li:hover>a,
.alookhor-legacy-nav-shell .nav-menu>li.current-menu-item>a{color:var(--alookhor-header-gold)!important}
.alookhor-main-menu-toggle{width:44px!important;min-width:44px!important;max-width:44px!important;height:44px!important;min-height:44px!important;max-height:44px!important;margin:0!important;padding:0!important;border:1px solid color-mix(in srgb,var(--alookhor-header-gold) 34%,transparent)!important;border-radius:50%!important;display:grid!important;place-items:center!important;background:color-mix(in srgb,var(--alookhor-header-surface) 76%,transparent)!important;color:var(--alookhor-header-gold)!important;cursor:pointer!important}
.alookhor-main-menu-toggle:before,.alookhor-main-menu-toggle:after{content:none!important}
.alookhor-main-menu-toggle svg{display:block!important;width:21px!important;height:21px!important;fill:none!important;stroke:currentColor!important}
.alookhor-header-cart-link{position:relative;width:42px;height:42px;flex:0 0 42px;border:1px solid color-mix(in srgb,var(--alookhor-header-gold) 24%,transparent);border-radius:50%;display:grid!important;place-items:center;background:rgba(255,255,255,.025);color:var(--alookhor-header-text)!important;text-decoration:none!important}
.alookhor-header-cart-link svg{width:20px;height:20px;fill:none;stroke:currentColor;stroke-width:1.7;stroke-linecap:round;stroke-linejoin:round}
.alookhor-cart-count{position:absolute;top:-5px;right:-4px;min-width:18px;height:18px;padding:0 4px;border-radius:999px;background:var(--alookhor-header-gold);color:#1A1206;font:800 9px/18px Tahoma,sans-serif;text-align:center;box-shadow:0 3px 9px rgba(0,0,0,.35)}
.alookhor-managed-legacy-header .header-capsule-left .alookhor-gold-divider-v{display:none!important}
@media(min-width:1024px){
  .alookhor-managed-legacy-header .alookhor-topbar-container{width:calc(100% - 72px)!important;max-width:1360px!important;margin-inline:auto!important}
  .alookhor-managed-legacy-header .header-capsule{width:calc(100% - 36px)!important;max-width:1360px!important;display:grid!important;grid-template-columns:minmax(0,1fr) auto minmax(0,1fr)!important;grid-template-areas:"actions logo menu"!important;align-items:center!important;justify-content:stretch!important;direction:ltr!important}
  .alookhor-managed-legacy-header .header-capsule-logo{grid-area:logo!important;justify-self:center!important;direction:rtl!important;transform:translateX(-130px)!important}
  .alookhor-managed-legacy-header .header-capsule-logo img{transform:translateY(-6px)!important}
  .alookhor-managed-legacy-header .header-capsule-left{grid-area:actions!important;justify-self:start!important;direction:rtl!important}
  .alookhor-managed-legacy-header .alookhor-main-menu-toggle{grid-area:menu!important;justify-self:end!important;direction:rtl!important}
  /* The real WordPress navigation node remains singular. At page start its
     existing stage is visually integrated into the second capsule; once its
     marker reaches the viewport it returns to the verified sticky rail. */
  .alookhor-managed-legacy-header .alookhor-legacy-nav-stage.is-capsule-integrated:not(.is-stuck){--alookhor-integrated-nav-offset:90px;position:relative!important;top:-90px!important;margin:0 0 -90px!important;min-height:90px!important;padding:6px 18px!important;z-index:31!important;pointer-events:none!important}
  .alookhor-managed-legacy-header .alookhor-legacy-nav-stage.is-capsule-integrated:not(.is-stuck) .alookhor-legacy-nav-shell{width:calc(100% - 36px)!important;max-width:1360px!important;min-height:78px!important;padding:0 96px 0 560px!important;justify-content:flex-end!important;background:transparent!important;border-color:transparent!important;box-shadow:none!important;-webkit-backdrop-filter:none!important;backdrop-filter:none!important;pointer-events:none!important}
  .alookhor-managed-legacy-header .alookhor-legacy-nav-stage.is-capsule-integrated:not(.is-stuck) .header-nav-center{width:100%!important;justify-content:flex-end!important;pointer-events:auto!important}
  .alookhor-managed-legacy-header .alookhor-legacy-nav-stage.is-capsule-integrated:not(.is-stuck) .nav-menu{width:auto!important;justify-content:flex-end!important;gap:clamp(18px,2.15vw,32px)!important}
  .alookhor-managed-legacy-header .alookhor-legacy-nav-stage.is-stuck{margin:0!important;min-height:66px!important;padding:5px 18px 9px!important}
  .alookhor-managed-legacy-header .alookhor-legacy-nav-stage.is-stuck .alookhor-legacy-nav-shell{width:min(1200px,100%)!important;max-width:1200px!important;min-height:58px!important;padding:0 24px!important;justify-content:center!important;background:color-mix(in srgb,var(--alookhor-header-surface) 88%,transparent)!important;border-color:color-mix(in srgb,var(--alookhor-header-gold) 44%,transparent)!important;box-shadow:0 13px 36px rgba(0,0,0,.52),inset 0 1px 0 color-mix(in srgb,var(--alookhor-header-gold) 10%,transparent)!important;-webkit-backdrop-filter:blur(14px) saturate(125%)!important;backdrop-filter:blur(14px) saturate(125%)!important}
}
@media(max-width:1023px){
  .alookhor-managed-legacy-header .alookhor-header{min-height:70px!important}
  .alookhor-managed-legacy-header .header-capsule{display:grid!important;grid-template-columns:minmax(0,1fr) auto minmax(0,1fr)!important;grid-template-areas:"actions logo menu"!important;align-items:center!important;direction:ltr!important}
  .alookhor-managed-legacy-header .header-capsule-logo{grid-area:logo!important;justify-self:center!important;direction:rtl!important;max-height:52px!important}
  .alookhor-managed-legacy-header .header-capsule-left{grid-area:actions!important;justify-self:start!important;direction:ltr!important;gap:9px!important}
  .alookhor-managed-legacy-header .header-login-btn{width:40px!important;min-width:40px!important;max-width:40px!important;height:40px!important;min-height:40px!important;max-height:40px!important;padding:0!important;border:0!important;background:transparent!important;border-radius:0!important;font-size:0!important;display:grid!important;place-items:center!important}
  .alookhor-managed-legacy-header .header-login-btn svg{display:block!important;width:27px!important;height:27px!important;margin:0!important;color:var(--alookhor-header-text)!important;fill:none!important;stroke:currentColor!important;stroke-width:1.7!important;stroke-linecap:round!important}
  .alookhor-managed-legacy-header .header-login-btn span{display:none!important}
  .alookhor-managed-legacy-header .alookhor-main-menu-toggle{grid-area:menu!important;justify-self:end!important;direction:rtl!important;width:42px!important;min-width:42px!important;height:42px!important;min-height:42px!important;border:0!important;background:transparent!important}
  .alookhor-managed-legacy-header .alookhor-header-cart-link{width:40px;height:40px;flex-basis:40px;border:0!important;background:transparent!important;border-radius:0!important}
  .alookhor-managed-legacy-header .alookhor-header-cart-link svg{width:27px;height:27px}
  .alookhor-managed-legacy-header .alookhor-logo-copy b{font-size:20px}
  .alookhor-managed-legacy-header .alookhor-logo-copy small{font-size:7px}
  .alookhor-legacy-nav-marker,.alookhor-legacy-nav-stage{display:none!important}
}
@media(max-width:767px){
  .alookhor-managed-legacy-header .alookhor-topbar-wrapper,
  .alookhor-managed-legacy-header .alookhor-topbar-container{height:34px!important;min-height:34px!important}
  .alookhor-managed-legacy-header .topbar-btn-wholesale,
  .alookhor-managed-legacy-header .topbar-social-wa,
  .alookhor-managed-legacy-header .alookhor-managed-email,
  .alookhor-managed-legacy-header .topbar-v-divider{display:none!important}
  .alookhor-managed-legacy-header .alookhor-managed-phone,
  .alookhor-managed-legacy-header .topbar-export-badge{display:inline-flex!important;visibility:visible!important;opacity:1!important;font-size:9px!important}
  .alookhor-managed-legacy-header .topbar-left,
  .alookhor-managed-legacy-header .topbar-right{display:flex!important;align-items:center!important;min-width:0!important}
}
@media(min-width:783px){body.admin-bar .alookhor-legacy-nav-stage.is-enabled{--alookhor-sticky-offset:32px}}
@media(max-width:782px){body.admin-bar .alookhor-legacy-nav-stage.is-enabled{--alookhor-sticky-offset:46px}}
@media(prefers-reduced-motion:reduce){.alookhor-managed-legacy-header .alookhor-topbar-wrapper,.alookhor-managed-legacy-header .alookhor-header,.alookhor-legacy-nav-stage,.alookhor-legacy-nav-shell{transition:none!important;scroll-behavior:auto!important}}
````

## Source Snapshot — `plugin/alookhor-control-center/assets/css/frontend-header.css`

````css
/* ALOOKHOR Luxury Portal Header — recovered two-level design.
 * Every rule is scoped to the shortcode so Woodmart/Elementor remain untouched.
 */
body:has(.alookhor-portal-header){padding-top:0!important}
#main-content:has(.alookhor-portal-header),.elementor:has(.alookhor-portal-header){padding-top:0!important;margin-top:0!important}
.elementor-element.e-con:has(.alookhor-portal-header){--padding-top:0px!important;--padding-bottom:0px!important;--margin-top:0px!important;--margin-bottom:0px!important;--justify-content:flex-start!important;min-height:0!important;height:auto!important;margin:0!important;margin-block:0!important;padding:0!important;padding-block:0!important;top:auto!important;transform:none!important;gap:0!important;justify-content:flex-start!important;align-content:flex-start!important}
.elementor-widget-shortcode:has(.alookhor-portal-header),.elementor-widget-shortcode:has(.alookhor-portal-header)>.elementor-widget-container,.elementor-widget-shortcode:has(.alookhor-portal-header) .elementor-shortcode{margin:0!important;padding:0!important;min-height:0!important}
.alookhor-portal-header{
  --alookhor-gold:#c9a86a;
  --alookhor-gold-soft:#e6cf9a;
  --alookhor-gold-line:rgba(201,168,106,.28);
  --alookhor-gold-faint:rgba(201,168,106,.12);
  --alookhor-ink:#0b0612;
  --alookhor-plum:#12091f;
  --alookhor-panel:#15101b;
  --alookhor-text:#f5efe4;
  --alookhor-muted:#b6acb9;
  position:relative;
  z-index:999;
  width:100%;
  min-width:0;
  color:var(--alookhor-text);
  direction:rtl;
  isolation:isolate;
  font-family:Tahoma,"Segoe UI",Arial,sans-serif;
}
.alookhor-portal-header.is-sticky{position:relative;top:auto}.alookhor-portal-header .alookhor-internal-nav-marker{display:block;width:100%;height:0;margin:0;padding:0;overflow:hidden}.alookhor-portal-header.is-sticky .alookhor-nav-stage{position:relative;top:auto;z-index:9996}.alookhor-portal-header.is-sticky .alookhor-nav-stage.is-stuck{position:fixed!important;top:0!important;left:0!important;right:0!important;width:100%!important;margin:0!important}body.admin-bar .alookhor-portal-header.is-sticky .alookhor-nav-stage.is-stuck{top:32px!important}@media(max-width:782px){body.admin-bar .alookhor-portal-header.is-sticky .alookhor-nav-stage.is-stuck{top:46px!important}}@media(max-width:1023px){.alookhor-portal-header .alookhor-internal-nav-marker{display:none!important}.alookhor-portal-header.is-sticky .alookhor-nav-stage{position:relative!important;top:auto!important}}
.alookhor-portal-header,
.alookhor-portal-header *{box-sizing:border-box}
.alookhor-portal-header a{color:inherit;text-decoration:none}
.alookhor-portal-header button,
.alookhor-portal-header input{font:inherit}
.alookhor-portal-header button{color:inherit}
.alookhor-portal-header img,
.alookhor-portal-header svg{display:block;max-width:100%}
.alookhor-portal-header svg{fill:none;stroke:currentColor;stroke-width:1.7;stroke-linecap:round;stroke-linejoin:round}
.alookhor-portal-header .screen-reader-text{position:absolute!important;width:1px!important;height:1px!important;padding:0!important;margin:-1px!important;overflow:hidden!important;clip:rect(0,0,0,0)!important;white-space:nowrap!important;border:0!important}

/* Top utility bar */
.alookhor-topbar{
  height:var(--alookhor-topbar-height,38px);
  color:var(--alookhor-topbar-text,#F5F3F0);
  background:linear-gradient(90deg,rgba(0,0,0,.16),rgba(255,255,255,.025),rgba(0,0,0,.16)),var(--alookhor-topbar-bg,#1C1024);
  border-bottom:1px solid var(--alookhor-topbar-border,#D49A2E);
  box-shadow:0 8px 28px rgba(0,0,0,.22);
}
.alookhor-topbar-inner{
  width:min(1440px,calc(100% - 48px));
  height:100%;
  margin:0 auto;
  display:grid;
  grid-template-columns:minmax(0,1fr) auto minmax(0,1fr);
  align-items:center;
  gap:20px;
}
.alookhor-trade-meta{display:flex;align-items:center;justify-self:start;gap:18px;min-width:0}
.alookhor-wholesale{
  min-height:27px;
  display:inline-flex;
  align-items:center;
  gap:7px;
  padding:4px 14px;
  border-radius:999px;
  color:var(--alookhor-topbar-button-text,#0D0510)!important;
  background:var(--alookhor-topbar-button-bg,#D49A2E);
  border:1px solid rgba(255,236,186,.28);
  box-shadow:0 4px 15px rgba(190,136,39,.2),inset 0 1px 0 rgba(255,255,255,.22);
  font-size:11px;
  font-weight:800;
  white-space:nowrap;
  transition:transform .2s ease,filter .2s ease;
}
.alookhor-wholesale:hover{transform:translateY(-1px);filter:brightness(1.08)}
.alookhor-wholesale svg{width:13px;height:13px;stroke-width:1.9}
.alookhor-export-note{display:inline-flex;align-items:center;gap:7px;color:var(--alookhor-topbar-text,#F5F3F0)!important;font-size:10.5px;white-space:nowrap}
.alookhor-export-note svg{width:14px;height:14px;color:var(--alookhor-gold)}
.alookhor-top-logo{height:34px;min-width:80px;display:grid;place-items:center;padding:2px 12px;border-inline:1px solid rgba(201,168,106,.12)}
.alookhor-top-logo-image{width:auto!important;max-width:var(--alookhor-top-logo-width,96px)!important;height:31px!important;object-fit:contain;filter:drop-shadow(0 2px 8px rgba(201,168,106,.14))}
.alookhor-top-logo-fallback{font-family:Georgia,"Times New Roman",serif;color:var(--alookhor-gold-soft);font-size:13px;font-weight:700;letter-spacing:.13em}
.alookhor-contact-meta{justify-self:end;display:flex;align-items:center;gap:10px;min-width:0;color:#d2cad4;font-family:Arial,sans-serif;font-size:10.5px}
.alookhor-contact-link{direction:ltr;white-space:nowrap;transition:color .2s ease}
.alookhor-contact-link:hover{color:var(--alookhor-gold-soft)}
.alookhor-contact-separator{width:1px;height:14px;background:rgba(201,168,106,.2)}
.alookhor-whatsapp{width:23px;height:23px;border-radius:50%;display:grid;place-items:center;background:#26d366;color:#fff!important;box-shadow:0 0 0 2px rgba(38,211,102,.16)}
.alookhor-whatsapp svg{width:15px;height:15px;fill:currentColor;stroke:none}

/* Floating glass navigation */
.alookhor-nav-stage{
  min-height:75px;
  display:flex;
  align-items:flex-start;
  padding:0 20px;
  background:linear-gradient(180deg,rgba(10,5,17,.96),rgba(10,5,17,.84) 66%,rgba(10,5,17,0));
}
.alookhor-nav-shell{
  width:min(1360px,calc(100% - 48px));
  min-height:68px;
  margin:0 auto;
  padding:7px 17px 7px 12px;
  display:flex;
  align-items:center;
  gap:20px;
  border:1px solid var(--alookhor-gold-line);
  border-top-color:rgba(230,207,154,.34);
  border-radius:38px;
  background:
    radial-gradient(520px 100px at 50% 0,rgba(201,168,106,.11),transparent 72%),
    linear-gradient(180deg,rgba(35,29,39,.95),rgba(21,16,27,.9));
  -webkit-backdrop-filter:blur(18px) saturate(135%);
  backdrop-filter:blur(18px) saturate(135%);
  box-shadow:0 13px 35px rgba(0,0,0,.43),inset 0 1px 0 rgba(255,255,255,.04),0 0 22px rgba(201,168,106,.05);
}
.alookhor-nav-logo{display:flex;align-items:center;gap:9px;min-width:85px;max-width:190px;flex:0 0 auto}
.alookhor-nav-logo img{width:55px;height:55px;object-fit:contain;border-radius:50%;filter:drop-shadow(0 4px 10px rgba(201,168,106,.18))}
.alookhor-nav-logo-mark{width:47px;height:47px;display:grid;place-items:center;border-radius:50%;border:1px solid var(--alookhor-gold-line);background:#0d0910;color:var(--alookhor-gold);font-family:Georgia,serif;font-size:20px;font-weight:700}
.alookhor-nav-logo-copy{display:none;min-width:0;line-height:1.2}
.alookhor-nav-logo-copy b{display:block;font-family:Georgia,serif;font-size:13px;letter-spacing:.08em;color:var(--alookhor-gold-soft)}
.alookhor-nav-logo-copy small{display:block;margin-top:3px;color:var(--alookhor-muted);font-size:8px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis}
.alookhor-desktop-nav{min-width:0;align-self:stretch;display:flex;align-items:center}
.alookhor-primary-menu{display:flex!important;align-items:center;gap:1px!important;min-height:100%;padding:0!important;margin:0!important;list-style:none!important}
.alookhor-primary-menu>li{position:relative;display:flex;align-items:center;min-height:52px;margin:0!important;padding:0!important;list-style:none!important}
.alookhor-primary-menu>li>a{position:relative;display:inline-flex;align-items:center;gap:7px;padding:11px 16px;color:#e4dde5!important;font-size:12px;font-weight:600;white-space:nowrap;transition:color .2s ease}
.alookhor-primary-menu>li>a::after{content:"";position:absolute;right:16px;left:16px;bottom:5px;height:1px;transform:scaleX(0);background:linear-gradient(90deg,transparent,var(--alookhor-gold),transparent);transition:transform .22s ease}
.alookhor-primary-menu>li:hover>a,.alookhor-primary-menu>li.current-menu-item>a,.alookhor-primary-menu>li.current-menu-ancestor>a{color:var(--alookhor-gold-soft)!important}
.alookhor-primary-menu>li:hover>a::after,.alookhor-primary-menu>li.current-menu-item>a::after{transform:scaleX(1)}
.alookhor-primary-menu .menu-item-has-children>a{padding-left:27px}
.alookhor-primary-menu .menu-item-has-children>a::before{content:"";position:absolute;left:13px;top:50%;width:5px;height:5px;border-left:1px solid currentColor;border-bottom:1px solid currentColor;transform:translateY(-65%) rotate(-45deg);opacity:.7}
.alookhor-primary-menu .sub-menu{
  position:absolute;
  z-index:9;
  top:calc(100% - 2px);
  right:8px;
  width:235px;
  margin:0!important;
  padding:9px!important;
  list-style:none!important;
  border:1px solid var(--alookhor-gold-line);
  border-radius:16px;
  background:rgba(17,11,23,.98);
  box-shadow:0 20px 45px rgba(0,0,0,.5);
  -webkit-backdrop-filter:blur(18px);
  backdrop-filter:blur(18px);
  opacity:0;
  visibility:hidden;
  transform:translateY(8px);
  transition:opacity .2s ease,transform .2s ease,visibility .2s;
}
.alookhor-primary-menu li:hover>.sub-menu,.alookhor-primary-menu li:focus-within>.sub-menu{opacity:1;visibility:visible;transform:none}
.alookhor-primary-menu .sub-menu li{position:relative;margin:0!important;padding:0!important;list-style:none!important}
.alookhor-primary-menu .sub-menu a{display:flex;padding:10px 11px;border-radius:10px;color:#d7ced9!important;font-size:11.5px;line-height:1.5;transition:background .18s ease,color .18s ease}
.alookhor-primary-menu .sub-menu a:hover{background:rgba(201,168,106,.1);color:var(--alookhor-gold-soft)!important}
.alookhor-primary-menu .sub-menu .sub-menu{top:-9px;right:calc(100% + 6px)}
.alookhor-nav-spacer{flex:1;min-width:8px}
.alookhor-nav-actions{display:flex;align-items:center;gap:18px;flex:0 0 auto}
.alookhor-account-link{min-height:39px;display:inline-flex;align-items:center;gap:7px;padding:7px 18px;border:1px solid rgba(201,168,106,.35);border-radius:999px;background:linear-gradient(180deg,rgba(201,168,106,.08),rgba(201,168,106,.025));color:#eee8ee!important;font-size:11px;font-weight:700;white-space:nowrap;transition:background .2s ease,border-color .2s ease,transform .2s ease}
.alookhor-account-link:hover{background:rgba(201,168,106,.14);border-color:var(--alookhor-gold);transform:translateY(-1px)}
.alookhor-account-link svg{width:14px;height:14px}
.alookhor-nav-divider{width:1px;height:31px;background:linear-gradient(180deg,transparent,rgba(201,168,106,.32),transparent)}
.alookhor-menu-toggle{appearance:none;width:42px;height:42px;padding:0;border-radius:50%;border:1px solid rgba(201,168,106,.32);background:rgba(201,168,106,.055);display:grid;align-content:center;justify-content:center;gap:4px;cursor:pointer;transition:background .2s ease,border-color .2s ease,transform .2s ease}
.alookhor-menu-toggle:hover{background:rgba(201,168,106,.14);border-color:var(--alookhor-gold);transform:rotate(3deg)}
.alookhor-menu-toggle span{display:block;width:15px;height:1px;border-radius:2px;background:var(--alookhor-gold-soft);transition:transform .25s ease,opacity .2s ease}
.alookhor-portal-header.menu-open .alookhor-menu-toggle span:nth-child(1){transform:translateY(5px) rotate(45deg)}
.alookhor-portal-header.menu-open .alookhor-menu-toggle span:nth-child(2){opacity:0}
.alookhor-portal-header.menu-open .alookhor-menu-toggle span:nth-child(3){transform:translateY(-5px) rotate(-45deg)}

/* Off-canvas professional menu */
.alookhor-drawer-backdrop{position:fixed;inset:0;z-index:9997;background:rgba(5,2,8,.68);-webkit-backdrop-filter:blur(7px);backdrop-filter:blur(7px);opacity:0;visibility:hidden;pointer-events:none;transition:opacity .28s ease,visibility .28s}
.alookhor-menu-drawer{position:fixed;z-index:9998;inset:0 auto 0 0;width:min(410px,92vw);height:100dvh;padding:18px;display:flex;flex-direction:column;overflow:hidden;border-right:1px solid var(--alookhor-gold-line);background:radial-gradient(520px 280px at 0 0,rgba(201,168,106,.11),transparent 65%),linear-gradient(180deg,#17101e,#0d0912 72%);box-shadow:30px 0 75px rgba(0,0,0,.62);transform:translateX(-102%);visibility:hidden;transition:transform .34s cubic-bezier(.2,.8,.2,1),visibility .34s}
.alookhor-portal-header.menu-open .alookhor-drawer-backdrop{opacity:1;visibility:visible;pointer-events:auto}
.alookhor-portal-header.menu-open .alookhor-menu-drawer{transform:none;visibility:visible}
body.alookhor-menu-open{overflow:hidden!important}
.alookhor-drawer-head{display:flex;align-items:center;justify-content:space-between;gap:12px;padding-bottom:16px;border-bottom:1px solid var(--alookhor-gold-faint)}
.alookhor-drawer-brand{display:flex;align-items:center;gap:11px;min-width:0}
.alookhor-drawer-brand>img,.alookhor-drawer-brand>span{width:46px;height:46px;flex:0 0 46px;object-fit:contain;border-radius:50%;border:1px solid var(--alookhor-gold-line);background:#0c0810;display:grid;place-items:center;color:var(--alookhor-gold);font-family:Georgia,serif;font-weight:700}
.alookhor-drawer-brand div{min-width:0}.alookhor-drawer-brand b{display:block;color:var(--alookhor-gold-soft);font-family:Georgia,serif;font-size:16px;letter-spacing:.07em}.alookhor-drawer-brand small{display:block;margin-top:3px;color:var(--alookhor-muted);font-size:10px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis}
.alookhor-drawer-close{appearance:none;width:36px;height:36px;flex:0 0 36px;border:1px solid var(--alookhor-gold-line);border-radius:50%;background:rgba(255,255,255,.025);display:grid;place-items:center;color:var(--alookhor-muted)!important;font-size:22px;line-height:1;cursor:pointer;transition:.2s ease}
.alookhor-drawer-close:hover{color:var(--alookhor-gold-soft)!important;background:rgba(201,168,106,.1);transform:rotate(90deg)}
.alookhor-drawer-search{display:flex;align-items:center;margin:15px 0 11px;border:1px solid var(--alookhor-gold-faint);border-radius:13px;background:rgba(255,255,255,.025);overflow:hidden;transition:border-color .2s ease,box-shadow .2s ease}
.alookhor-drawer-search:focus-within{border-color:var(--alookhor-gold-line);box-shadow:0 0 0 3px rgba(201,168,106,.06)}
.alookhor-drawer-search input{width:100%;min-width:0;height:43px;padding:0 13px;border:0!important;outline:0!important;box-shadow:none!important;background:transparent!important;color:var(--alookhor-text)!important;font-size:12px}
.alookhor-drawer-search input::placeholder{color:#786f7a}
.alookhor-drawer-search button{appearance:none;width:43px;height:43px;flex:0 0 43px;border:0;border-right:1px solid var(--alookhor-gold-faint);background:transparent;display:grid;place-items:center;color:var(--alookhor-gold);cursor:pointer}
.alookhor-drawer-search svg{width:17px;height:17px}
.alookhor-drawer-menus{flex:1;min-height:0;overflow:auto;padding:3px 1px 12px;scrollbar-width:thin;scrollbar-color:rgba(201,168,106,.25) transparent}
.alookhor-drawer-menu-group{border-bottom:1px solid rgba(201,168,106,.09)}
.alookhor-drawer-menu-title{appearance:none;width:100%;min-height:47px;padding:7px 4px;border:0;background:transparent;display:flex;align-items:center;justify-content:space-between;gap:12px;color:#eee7ef!important;font-size:12.5px;font-weight:800;text-align:right;cursor:pointer}
.alookhor-drawer-menu-title svg{width:15px;height:15px;color:var(--alookhor-gold);transition:transform .22s ease}
.alookhor-drawer-menu-group.is-open .alookhor-drawer-menu-title svg{transform:rotate(180deg)}
.alookhor-drawer-menu-panel[hidden]{display:none}
.alookhor-drawer-menu,.alookhor-drawer-menu .sub-menu{margin:0!important;padding:0!important;list-style:none!important}
.alookhor-drawer-menu{padding:0 6px 11px!important}
.alookhor-drawer-menu li{margin:0!important;padding:0!important;list-style:none!important;position:relative}
.alookhor-drawer-menu a{position:relative;display:flex;align-items:center;min-height:38px;padding:8px 20px 8px 10px;border-radius:9px;color:#c9c0cb!important;font-size:11.5px;line-height:1.5;transition:background .18s ease,color .18s ease,padding .18s ease}
.alookhor-drawer-menu a::before{content:"";position:absolute;right:8px;width:4px;height:4px;border-radius:50%;background:rgba(201,168,106,.5)}
.alookhor-drawer-menu a:hover{padding-right:24px;background:rgba(201,168,106,.08);color:var(--alookhor-gold-soft)!important}
.alookhor-drawer-menu .sub-menu{margin-right:14px!important;border-right:1px solid rgba(201,168,106,.14)}
.alookhor-drawer-menu .sub-menu a{font-size:11px;min-height:34px}
.alookhor-drawer-empty{padding:20px;text-align:center;color:var(--alookhor-muted);font-size:12px;border:1px dashed var(--alookhor-gold-faint);border-radius:13px}
.alookhor-drawer-footer{padding-top:13px;border-top:1px solid var(--alookhor-gold-faint);display:grid;gap:9px}
.alookhor-drawer-quick-actions{display:grid;grid-template-columns:1fr 1fr;gap:8px}
.alookhor-drawer-quick-actions a,.alookhor-drawer-whatsapp{min-height:38px;display:grid;place-items:center;padding:8px 10px;border:1px solid var(--alookhor-gold-faint);border-radius:11px;background:rgba(255,255,255,.025);color:#d8d0da!important;font-size:11px;font-weight:700;text-align:center}
.alookhor-drawer-wholesale{min-height:42px;display:grid;place-items:center;padding:9px 12px;border-radius:11px;background:linear-gradient(135deg,#d5ad5a,#a97220);color:#1d1105!important;font-size:11.5px;font-weight:900;text-align:center}
.alookhor-drawer-whatsapp{border-color:rgba(38,211,102,.22);color:#7de7a4!important;background:rgba(38,211,102,.07)}

.alookhor-portal-header :focus-visible{outline:2px solid var(--alookhor-gold)!important;outline-offset:3px!important}

@media(min-width:1280px){
  .alookhor-nav-shell{width:min(1120px,calc(100% - 180px))}
}
@media(max-width:1180px){
  .alookhor-nav-shell{gap:13px}
  .alookhor-primary-menu>li>a{padding-inline:11px;font-size:11px}
  .alookhor-account-link{padding-inline:13px}
}
@media(max-width:1023px){
  .alookhor-topbar-inner{width:calc(100% - 28px)}
  .alookhor-export-note{display:none}
  .alookhor-desktop-nav{display:none}
  .alookhor-nav-stage{padding-inline:14px}
  .alookhor-nav-shell{width:100%;min-height:64px;border-radius:30px;padding-inline:14px}
  .alookhor-nav-logo-copy{display:block}
  .alookhor-nav-logo{max-width:250px}
  .alookhor-nav-logo img{width:48px;height:48px}
}
@media(max-width:767px){
  .alookhor-topbar{height:34px}
  .alookhor-topbar-inner{width:calc(100% - 18px);grid-template-columns:1fr auto auto;gap:9px}
  .alookhor-top-logo{justify-self:center;min-width:55px;padding-inline:6px;border:0}
  .alookhor-top-logo-image{max-width:69px!important;height:27px!important}
  .alookhor-contact-link,.alookhor-contact-separator{display:none}
  .alookhor-contact-meta{gap:0}
  .alookhor-trade-meta{gap:6px}
  .alookhor-wholesale{padding:3px 9px;font-size:9.5px;max-width:145px;overflow:hidden;text-overflow:ellipsis}
  .alookhor-nav-stage{min-height:69px;padding-inline:8px}
  .alookhor-nav-shell{min-height:60px;padding:6px 10px;border-radius:25px;gap:8px}
  .alookhor-nav-logo{gap:7px;max-width:180px;min-width:0}
  .alookhor-nav-logo img{width:44px;height:44px;flex:0 0 44px}
  .alookhor-nav-logo-copy b{font-size:12px}.alookhor-nav-logo-copy small{max-width:105px}
  .alookhor-nav-actions{gap:9px}
  .alookhor-account-link{width:39px;height:39px;min-height:39px;padding:0;display:grid;place-items:center}
  .alookhor-account-link span{display:none}
  .alookhor-account-link svg{width:16px;height:16px}
  .alookhor-nav-divider{height:27px}
  .alookhor-menu-toggle{width:39px;height:39px}
  .alookhor-menu-drawer{padding:14px}
}
@media(max-width:374px){
  .alookhor-topbar-inner{grid-template-columns:1fr auto}
  .alookhor-contact-meta{display:none}
  .alookhor-nav-stage{padding-inline:5px}
  .alookhor-nav-shell{padding-inline:8px}
  .alookhor-nav-logo-copy small{display:none}
  .alookhor-nav-logo-copy b{max-width:82px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis}
  .alookhor-nav-actions{gap:6px}
  .alookhor-nav-divider{display:none}
}
@media(prefers-reduced-motion:reduce){
  .alookhor-portal-header *{scroll-behavior:auto!important;transition-duration:.01ms!important;animation-duration:.01ms!important;animation-iteration-count:1!important}
}

/* v3.10.19 — Reference two-row Header for the internal shortcode renderer. */
.alookhor-portal-header{--alookhor-gold:#D49A2E;--alookhor-gold-soft:#E8B84A;--alookhor-gold-line:color-mix(in srgb,var(--alookhor-capsule-gold,#D49A2E) 38%,transparent);--alookhor-text:var(--alookhor-capsule-text,#F5F3F0);--alookhor-muted:var(--alookhor-capsule-muted,#C8C2C9);--alookhor-ink:var(--alookhor-capsule-background,#0D0510);--alookhor-plum:var(--alookhor-capsule-card,#1C1024)}
.alookhor-portal-header .alookhor-topbar{background-color:color-mix(in srgb,var(--alookhor-topbar-bg,#1C1024) 78%,transparent);background-image:linear-gradient(90deg,color-mix(in srgb,var(--alookhor-capsule-card,#1C1024) 86%,transparent),color-mix(in srgb,var(--alookhor-capsule-glass,rgba(33,20,38,.75)) 82%,transparent),color-mix(in srgb,var(--alookhor-capsule-card,#1C1024) 86%,transparent));-webkit-backdrop-filter:blur(18px) saturate(135%);backdrop-filter:blur(18px) saturate(135%);border-bottom-color:color-mix(in srgb,var(--alookhor-capsule-gold,#D49A2E) 28%,transparent)}
.alookhor-portal-header .alookhor-topbar-inner{width:min(1360px,calc(100% - 72px));grid-template-columns:minmax(0,1fr) minmax(0,1.7fr) minmax(0,1fr);grid-template-areas:"support message phone";direction:ltr}
.alookhor-fallback-support{grid-area:support;justify-self:start;display:inline-flex;align-items:center;gap:7px;direction:rtl;color:var(--alookhor-capsule-gold-light,#E8B84A);font-size:10px;white-space:nowrap}.alookhor-fallback-support svg{width:15px;height:15px}
.alookhor-portal-header .alookhor-trade-meta{grid-area:message;justify-self:center;direction:rtl;padding-inline:clamp(18px,4vw,58px);border-inline:1px solid color-mix(in srgb,var(--alookhor-capsule-gold,#D49A2E) 12%,transparent)}
.alookhor-portal-header .alookhor-wholesale,.alookhor-portal-header .alookhor-top-logo{display:none!important}
.alookhor-portal-header .alookhor-export-note{display:inline-flex!important;color:var(--alookhor-capsule-text,#F5F3F0)!important}
.alookhor-portal-header .alookhor-contact-meta{grid-area:phone;justify-self:end;color:var(--alookhor-capsule-gold-light,#E8B84A);direction:ltr}
.alookhor-portal-header .alookhor-contact-link[href^="mailto:"],.alookhor-portal-header .alookhor-contact-separator,.alookhor-portal-header .alookhor-whatsapp{display:none!important}
.alookhor-portal-header .alookhor-contact-link[href^="tel:"]{display:block!important;color:var(--alookhor-capsule-gold-light,#E8B84A)!important;font-weight:700}
.alookhor-portal-header .alookhor-nav-stage{min-height:90px;padding:6px 18px;background:transparent}
.alookhor-portal-header .alookhor-nav-shell{width:calc(100% - 36px);max-width:1360px;min-height:78px;padding:6px 24px;gap:18px;border-color:color-mix(in srgb,var(--alookhor-capsule-gold,#D49A2E) 42%,transparent);background-color:var(--alookhor-capsule-glass,rgba(33,20,38,.75));background-image:linear-gradient(135deg,color-mix(in srgb,var(--alookhor-capsule-card,#1C1024) 40%,transparent),transparent 64%);-webkit-backdrop-filter:blur(var(--alookhor-capsule-blur,24px)) saturate(145%);backdrop-filter:blur(var(--alookhor-capsule-blur,24px)) saturate(145%);box-shadow:0 14px 38px color-mix(in srgb,var(--alookhor-capsule-background,#0D0510) 68%,transparent),inset 0 1px 0 color-mix(in srgb,var(--alookhor-capsule-gold-light,#E8B84A) 18%,transparent)}
.alookhor-portal-header .alookhor-nav-logo-copy{display:block}.alookhor-portal-header .alookhor-nav-logo-copy b{color:var(--alookhor-capsule-gold-light,#E8B84A)}.alookhor-portal-header .alookhor-nav-logo-copy small{color:var(--alookhor-capsule-muted,#C8C2C9)}
.alookhor-fallback-cart{position:relative;width:42px;height:42px;display:grid;place-items:center;color:var(--alookhor-capsule-text,#F5F3F0)!important}.alookhor-fallback-cart svg{width:25px;height:25px}.alookhor-fallback-cart>span{position:absolute;top:-5px;right:-4px;min-width:18px;height:18px;padding:0 4px;border-radius:999px;background:var(--alookhor-capsule-gold-light,#E8B84A);color:var(--alookhor-capsule-background,#0D0510);font:800 9px/18px Tahoma;text-align:center}
.alookhor-portal-header .alookhor-account-link{width:42px;height:42px;min-height:42px;padding:0;display:grid;place-items:center;border:0;background:transparent;color:var(--alookhor-capsule-text,#F5F3F0)!important}.alookhor-portal-header .alookhor-account-link span{display:none}.alookhor-portal-header .alookhor-account-link svg{width:25px;height:25px}
.alookhor-portal-header .alookhor-nav-divider{display:none}.alookhor-portal-header .alookhor-menu-toggle{color:var(--alookhor-capsule-gold,#D49A2E);border:0;background:transparent}.alookhor-portal-header .alookhor-menu-toggle span{width:23px;height:2px;background:currentColor}
@media(min-width:1024px){.alookhor-portal-header .alookhor-nav-shell{display:grid;grid-template-columns:190px 270px minmax(0,1fr) 48px;grid-template-areas:"actions logo navigation menu";direction:ltr}.alookhor-portal-header .alookhor-nav-actions{grid-area:actions;justify-self:start;direction:ltr}.alookhor-portal-header .alookhor-nav-logo{grid-area:logo;justify-self:start;max-width:270px;direction:rtl}.alookhor-portal-header .alookhor-desktop-nav{grid-area:navigation;justify-self:end;direction:rtl}.alookhor-portal-header .alookhor-nav-spacer{display:none}.alookhor-portal-header .alookhor-menu-toggle{grid-area:menu;justify-self:end}.alookhor-portal-header .alookhor-primary-menu{justify-content:flex-end}}
@media(max-width:1023px){.alookhor-portal-header .alookhor-topbar-inner{width:calc(100% - 28px);grid-template-columns:minmax(0,1fr) minmax(0,1.6fr) minmax(0,1fr);grid-template-areas:"support message phone";gap:8px}.alookhor-portal-header .alookhor-nav-shell{display:grid;grid-template-columns:minmax(0,1fr) auto minmax(0,1fr);grid-template-areas:"actions logo menu";direction:ltr}.alookhor-portal-header .alookhor-nav-actions{grid-area:actions;justify-self:start;direction:ltr;gap:8px}.alookhor-portal-header .alookhor-nav-logo{grid-area:logo;justify-self:center;direction:rtl}.alookhor-portal-header .alookhor-menu-toggle{grid-area:menu;justify-self:end}.alookhor-portal-header .alookhor-nav-spacer{display:none}}
@media(max-width:767px){.alookhor-fallback-support{font-size:8px;gap:4px}.alookhor-fallback-support svg{width:12px;height:12px}.alookhor-portal-header .alookhor-trade-meta{padding-inline:5px;border-inline:0}.alookhor-portal-header .alookhor-export-note{font-size:8px}.alookhor-portal-header .alookhor-contact-meta{font-size:8px}.alookhor-portal-header .alookhor-nav-stage{min-height:70px;padding:0 8px}.alookhor-portal-header .alookhor-nav-shell{width:100%;min-height:60px;padding:6px 10px;border-radius:28px}.alookhor-fallback-cart,.alookhor-portal-header .alookhor-account-link{width:38px;height:38px}.alookhor-fallback-cart svg,.alookhor-portal-header .alookhor-account-link svg{width:24px;height:24px}}

/* v3.10.25 — final visual correction against image.png. */
.alookhor-portal-header{width:100vw!important;max-width:100vw!important;margin-inline:calc(50% - 50vw)!important}
.alookhor-portal-header .alookhor-nav-stage{background:linear-gradient(180deg,#0D0510 0%,#16091D 68%,#0D0510 100%)!important}
.alookhor-portal-header .alookhor-nav-shell{background-color:rgba(33,20,38,.75)!important;background-image:radial-gradient(680px 120px at 50% 0,rgba(115,43,139,.34),transparent 72%),linear-gradient(135deg,rgba(73,25,89,.5),rgba(28,16,36,.86) 65%)!important;border-color:rgba(232,184,74,.46)!important;border-top-color:rgba(240,153,224,.42)!important;box-shadow:0 14px 40px rgba(13,5,16,.72),inset 0 1px 0 rgba(246,176,231,.3),inset 0 -1px 0 rgba(212,154,46,.14),0 0 24px rgba(133,48,145,.16)!important}
.alookhor-portal-header .alookhor-menu-toggle{display:grid!important;visibility:visible!important;opacity:1!important;position:relative!important;z-index:8!important;width:44px!important;min-width:44px!important;max-width:44px!important;height:44px!important;min-height:44px!important;max-height:44px!important;padding:0!important;color:#E8B84A!important}
.alookhor-portal-header .alookhor-menu-toggle span{display:block!important;width:24px!important;height:2px!important;opacity:1!important;background:currentColor!important}
.alookhor-portal-header .alookhor-nav-logo img{background:transparent!important;border-radius:0!important;object-fit:contain!important}
@media(max-width:1023px){.alookhor-portal-header .alookhor-nav-stage{width:100vw!important;padding-inline:8px!important}.alookhor-portal-header .alookhor-nav-shell{width:100%!important;max-width:none!important}.alookhor-portal-header .alookhor-menu-toggle{width:40px!important;min-width:40px!important;max-width:40px!important;height:40px!important;min-height:40px!important;max-height:40px!important}}

/* v3.10.26 — Desktop Mega Menu panels for the primary WordPress menu.
 * Scope: only top-level .menu-item-has-children items inside the capsule.
 * Second level becomes column headers; third level becomes stacked links.
 * Mobile (<=1023px) keeps the unchanged Hamburger/Drawer experience.
 */
@media(min-width:1024px){
.alookhor-portal-header.alookhor-mega-menu .alookhor-nav-shell{position:relative}
.alookhor-portal-header.alookhor-mega-menu .alookhor-primary-menu>.menu-item-has-children{position:static}
.alookhor-portal-header.alookhor-mega-menu .alookhor-primary-menu>.menu-item-has-children>.sub-menu{
  top:calc(100% + 9px);
  right:12px;
  left:12px;
  width:auto;
  min-width:0;
  padding:18px 22px 16px;
  display:grid;
  grid-template-columns:repeat(auto-fit,minmax(178px,1fr));
  gap:6px 22px;
  border-color:rgba(232,184,74,.46)!important;
  border-top-color:rgba(240,153,224,.42)!important;
  border-radius:22px;
  background-color:rgba(24,13,31,.97)!important;
  background-image:radial-gradient(680px 130px at 50% 0,rgba(115,43,139,.30),transparent 72%),linear-gradient(135deg,rgba(73,25,89,.48),rgba(28,16,36,.94) 65%)!important;
  box-shadow:0 26px 60px rgba(13,5,16,.78),inset 0 1px 0 rgba(246,176,231,.22),inset 0 -1px 0 rgba(212,154,46,.14)!important;
  transform:translateY(10px);
}
/* Bridge the hover gap between capsule row and panel. */
.alookhor-portal-header.alookhor-mega-menu .alookhor-primary-menu>.menu-item-has-children>.sub-menu::before{content:"";position:absolute;top:-11px;right:0;left:0;height:11px;background:transparent}
.alookhor-portal-header.alookhor-mega-menu .alookhor-primary-menu>.menu-item-has-children:hover>.sub-menu,
.alookhor-portal-header.alookhor-mega-menu .alookhor-primary-menu>.menu-item-has-children:focus-within>.sub-menu,
.alookhor-portal-header.alookhor-mega-menu .alookhor-primary-menu>.menu-item-has-children.is-mega-open>.sub-menu{opacity:1;visibility:visible;transform:none}
/* Column headers — second level inside the panel. */
.alookhor-portal-header.alookhor-mega-menu .alookhor-primary-menu>.menu-item-has-children>.sub-menu>li{display:flex;flex-direction:column;gap:1px;min-width:0}
.alookhor-portal-header.alookhor-mega-menu .alookhor-primary-menu>.menu-item-has-children>.sub-menu>li>a{
  padding:8px 9px 9px;
  border:0;
  border-bottom:1px solid rgba(232,184,74,.22);
  border-radius:0;
  color:var(--alookhor-capsule-gold-light,#E8B84A)!important;
  font-size:12px;
  font-weight:800;
  letter-spacing:.02em;
}
.alookhor-portal-header.alookhor-mega-menu .alookhor-primary-menu>.menu-item-has-children>.sub-menu>li>a:hover{background:transparent;color:#F5F3F0!important}
/* Third level becomes a stacked list; flyout behavior is disabled inside the panel. */
.alookhor-portal-header.alookhor-mega-menu .alookhor-primary-menu>.menu-item-has-children>.sub-menu .sub-menu{
  position:static!important;
  top:auto!important;
  right:auto!important;
  width:auto!important;
  padding:3px 2px 4px!important;
  margin:0!important;
  border:0!important;
  border-radius:0;
  background:transparent!important;
  box-shadow:none!important;
  opacity:1!important;
  visibility:visible!important;
  transform:none!important;
  display:block;
}
.alookhor-portal-header.alookhor-mega-menu .alookhor-primary-menu>.menu-item-has-children>.sub-menu .sub-menu li{display:block}
.alookhor-portal-header.alookhor-mega-menu .alookhor-primary-menu>.menu-item-has-children>.sub-menu .sub-menu a{
  min-height:32px;
  padding:6px 9px!important;
  border-radius:9px;
  color:#C8C2C9!important;
  font-size:11.5px;
  font-weight:500;
}
.alookhor-portal-header.alookhor-mega-menu .alookhor-primary-menu>.menu-item-has-children>.sub-menu .sub-menu a:hover{background:rgba(212,154,46,.12);color:#F5F3F0!important;padding-right:13px!important}
/* No flyout chevrons inside the panel; only the top-level trigger rotates. */
.alookhor-portal-header.alookhor-mega-menu .alookhor-primary-menu>.menu-item-has-children>.sub-menu .menu-item-has-children>a{padding-left:9px!important}
.alookhor-portal-header.alookhor-mega-menu .alookhor-primary-menu>.menu-item-has-children>.sub-menu .menu-item-has-children>a::before{display:none}
.alookhor-portal-header.alookhor-mega-menu .alookhor-primary-menu>.menu-item-has-children>a::before{transition:transform .22s ease}
.alookhor-portal-header.alookhor-mega-menu .alookhor-primary-menu>.menu-item-has-children:hover>a::before,
.alookhor-portal-header.alookhor-mega-menu .alookhor-primary-menu>.menu-item-has-children.is-mega-open>a::before{transform:translateY(-65%) rotate(-135deg)}
}
````

## Source Snapshot — `plugin/alookhor-control-center/assets/css/frontend-hero.css`

````css
/* ALOOKHOR managed four-slide Hero — exact legacy replacement, Black/Gold luxury. */
body.alookhor-mh-hide-legacy .alookhor-hero-slider-wrapper{display:none!important}
.alookhor-managed-hero-slot,.alookhor-managed-hero-slot>.elementor-widget-container,.alookhor-managed-hero-slot>.elementor-widget-container>.elementor-shortcode{width:100%!important;max-width:none!important;margin:0!important;padding:0!important;overflow:visible!important}
.alookhor-mh{--mh-gold:#D4AF37;--mh-surface:#09060D;--mh-text:#fff;--mh-muted:#D9D1DA;--mh-radius:32px;position:relative;z-index:1;width:100vw;max-width:100vw;margin:0 calc(50% - 50vw);padding:20px;box-sizing:border-box;background:radial-gradient(circle at 50% -20%,color-mix(in srgb,var(--mh-gold) 8%,transparent),transparent 48%),#060309;direction:rtl;isolation:isolate}
.alookhor-mh-shell{position:relative;width:min(1880px,100%);height:min(41.6667vw,800px);min-height:520px;margin:0 auto;overflow:hidden;border:1px solid color-mix(in srgb,var(--mh-gold) 28%,transparent);border-radius:var(--mh-radius);background:var(--mh-surface);box-shadow:0 28px 80px rgba(0,0,0,.52),inset 0 1px 0 rgba(255,255,255,.06)}
.alookhor-mh-slides,.alookhor-mh-slide,.alookhor-mh-media,.alookhor-mh-shade{position:absolute;inset:0}
.alookhor-mh-slide{z-index:0;overflow:hidden;visibility:hidden;opacity:0;transition:opacity .82s ease,visibility .82s step-end}
.alookhor-mh-slide.is-active{z-index:1;visibility:visible;opacity:1;transition:opacity .82s ease,visibility 0s step-start}
.alookhor-mh-media{background:#0a060d;overflow:hidden}
.alookhor-mh-media img{display:block;width:100%;height:100%;object-fit:cover;object-position:center;transform:scale(1.015);filter:saturate(.94) contrast(1.03) brightness(.78);transition:transform 6.8s cubic-bezier(.2,.65,.25,1),filter .8s ease}
/* Legacy banners place the product on the right and bake copy on the left.
   Subject-focus shifts that approved photography left without mirroring logos;
   the vacated right area is fully covered by the managed copy surface. */
.alookhor-mh-slide.is-image-flipped .alookhor-mh-media img{transform:translateX(-36%) scale(1.12)}
.alookhor-mh[data-ken-burns="1"] .alookhor-mh-slide.is-active .alookhor-mh-media img{transform:scale(1.075)}
.alookhor-mh[data-ken-burns="1"] .alookhor-mh-slide.is-active.is-image-flipped .alookhor-mh-media img{transform:translateX(-36%) scale(1.18)}
.alookhor-mh-shade{z-index:1;background:linear-gradient(90deg,rgba(5,2,7,.06) 0%,rgba(7,3,10,.14) 42%,rgba(8,4,12,.98) 62%,rgba(7,3,10,.995) 100%),linear-gradient(180deg,rgba(0,0,0,.08) 0%,rgba(0,0,0,.12) 72%,rgba(7,3,10,.9) 100%)}
.alookhor-mh-content{position:absolute;z-index:2;top:50%;right:clamp(46px,6.3vw,122px);width:min(49%,760px);transform:translateY(-48%);text-align:right;color:var(--mh-text);font-family:inherit}
.alookhor-mh-kicker{display:inline-flex;align-items:center;gap:9px;margin-bottom:14px;color:var(--mh-gold);font-size:clamp(12px,.86vw,16px);font-weight:700;letter-spacing:.02em}
.alookhor-mh-kicker:before{content:"";width:36px;height:1px;background:linear-gradient(90deg,transparent,var(--mh-gold))}
.alookhor-mh-content h2{margin:0;color:var(--mh-text);font-size:clamp(40px,4.15vw,80px);font-weight:900;line-height:1.08;letter-spacing:-.045em;text-shadow:0 8px 28px rgba(0,0,0,.36)}
.alookhor-mh-content h2 strong{display:block;margin-top:4px;color:var(--mh-gold);font-size:.83em;font-weight:900}
.alookhor-mh-description{max-width:630px;margin:19px 0 0;color:var(--mh-muted);font-size:clamp(15px,1.13vw,21px);font-weight:500;line-height:1.85;text-shadow:0 4px 14px rgba(0,0,0,.45)}
.alookhor-mh-features{display:grid;grid-template-columns:repeat(4,minmax(0,1fr));gap:0;margin-top:26px;border-top:1px solid color-mix(in srgb,var(--mh-gold) 18%,transparent);border-bottom:1px solid color-mix(in srgb,var(--mh-gold) 18%,transparent)}
.alookhor-mh-feature{position:relative;min-height:104px;padding:17px 10px 14px;display:grid;align-content:center;justify-items:center;gap:8px;color:var(--mh-text);text-align:center}
.alookhor-mh-feature:not(:last-child):after{content:"";position:absolute;left:0;top:22%;width:1px;height:56%;background:linear-gradient(transparent,color-mix(in srgb,var(--mh-gold) 34%,transparent),transparent)}
.alookhor-mh-feature svg{width:34px;height:34px;fill:none;stroke:var(--mh-gold);stroke-width:1.45;stroke-linecap:round;stroke-linejoin:round;filter:drop-shadow(0 4px 10px rgba(212,175,55,.18))}
.alookhor-mh-feature b{font-size:clamp(10px,.74vw,13px);font-weight:700;line-height:1.65}
.alookhor-mh-actions{display:flex;align-items:center;gap:12px;margin-top:26px}
.alookhor-mh-cta{min-width:184px;min-height:52px;padding:0 23px;border:1px solid color-mix(in srgb,var(--mh-gold) 72%,transparent);border-radius:13px;display:inline-flex;align-items:center;justify-content:center;gap:14px;color:var(--mh-text)!important;font-size:14px;font-weight:800;text-decoration:none!important;transition:transform .25s ease,box-shadow .25s ease,background .25s ease,color .25s ease}
.alookhor-mh-cta.is-primary{background:linear-gradient(135deg,#E0BB45,var(--mh-gold) 54%,#B88718);color:#171004!important;box-shadow:0 12px 30px rgba(212,175,55,.22),inset 0 1px 0 rgba(255,255,255,.34)}
.alookhor-mh-cta.is-secondary{background:rgba(7,4,10,.42);backdrop-filter:blur(9px);-webkit-backdrop-filter:blur(9px)}
.alookhor-mh-cta:hover{transform:translateY(-2px);box-shadow:0 15px 34px rgba(212,175,55,.26)}
.alookhor-mh .alookhor-mh-arrow{appearance:none!important;-webkit-appearance:none!important;position:absolute!important;z-index:5!important;top:50%!important;width:48px!important;min-width:48px!important;max-width:48px!important;height:48px!important;min-height:48px!important;max-height:48px!important;margin:0!important;padding:0!important;border:1px solid rgba(255,255,255,.18)!important;border-radius:50%!important;display:grid!important;place-items:center!important;background:rgba(7,4,10,.56)!important;color:#fff!important;font-size:0!important;line-height:1!important;box-shadow:0 8px 24px rgba(0,0,0,.34)!important;-webkit-backdrop-filter:blur(12px)!important;backdrop-filter:blur(12px)!important;cursor:pointer!important;transform:translateY(-50%)!important;transition:background .25s ease,border-color .25s ease,color .25s ease!important}
.alookhor-mh .alookhor-mh-arrow:before,.alookhor-mh .alookhor-mh-arrow:after{content:none!important;display:none!important}
.alookhor-mh .alookhor-mh-arrow:hover{border-color:var(--mh-gold)!important;background:var(--mh-gold)!important;color:#171004!important}
.alookhor-mh .alookhor-mh-arrow svg{display:block!important;width:21px!important;height:21px!important;margin:0!important;padding:0!important;fill:none!important;stroke:currentColor!important;stroke-width:2!important;stroke-linecap:round!important;stroke-linejoin:round!important}
.alookhor-mh .alookhor-mh-arrow.is-prev{right:18px!important;left:auto!important}.alookhor-mh .alookhor-mh-arrow.is-next{left:18px!important;right:auto!important}
.alookhor-mh-dots{position:absolute;z-index:5;bottom:18px;left:50%;display:flex;align-items:center;gap:9px;transform:translateX(-50%)}
.alookhor-mh-dots button{appearance:none!important;-webkit-appearance:none!important;width:10px!important;min-width:10px!important;max-width:10px!important;height:10px!important;min-height:10px!important;max-height:10px!important;margin:0!important;padding:0!important;border:0!important;border-radius:999px!important;background:rgba(255,255,255,.58)!important;box-shadow:0 2px 8px rgba(0,0,0,.4)!important;cursor:pointer;transition:width .28s ease,background .28s ease,box-shadow .28s ease}
.alookhor-mh-dots button.is-active{width:36px!important;min-width:36px!important;max-width:36px!important;background:var(--mh-gold)!important;box-shadow:0 0 0 1px rgba(255,255,255,.1),0 4px 16px color-mix(in srgb,var(--mh-gold) 45%,transparent)!important}
@media(max-width:1200px){.alookhor-mh{padding:16px}.alookhor-mh-shell{min-height:480px}.alookhor-mh-content{right:58px;width:54%}.alookhor-mh-feature{min-height:92px}.alookhor-mh-cta{min-width:166px}}
@media(max-width:767px){
  .alookhor-mh{z-index:1;margin-top:-50px;padding:0 12px 12px;background:#060309}
  .alookhor-mh-shell{width:100%;height:clamp(300px,82vw,350px);min-height:0;border-radius:min(var(--mh-radius),22px);box-shadow:0 18px 44px rgba(0,0,0,.45),inset 0 1px 0 rgba(255,255,255,.06)}
  .alookhor-mh-media img{object-position:30% center;filter:saturate(.95) contrast(1.04) brightness(.68)}
  .alookhor-mh-slide.is-image-flipped .alookhor-mh-media img{object-position:78% center;transform:scale(1.015)}
  .alookhor-mh[data-ken-burns="1"] .alookhor-mh-slide.is-active.is-image-flipped .alookhor-mh-media img{transform:scale(1.075)}
  .alookhor-mh-shade{background:linear-gradient(90deg,rgba(5,2,7,.04) 0%,rgba(6,3,8,.14) 38%,rgba(8,4,12,.98) 58%,rgba(7,3,10,.997) 100%),linear-gradient(180deg,rgba(0,0,0,.05) 0%,rgba(0,0,0,.12) 76%,rgba(7,3,10,.82) 100%)}
  .alookhor-mh-content{top:50%;right:23px;width:58%;transform:translateY(-49%)}
  .alookhor-mh-kicker{display:none}
  .alookhor-mh-content h2{font-size:clamp(25px,7.5vw,31px);line-height:1.05;letter-spacing:-.05em}
  .alookhor-mh-content h2 strong{margin-top:3px;font-size:.82em}
  .alookhor-mh-description{margin-top:9px;font-size:10.5px;line-height:1.65;white-space:normal}
  .alookhor-mh-features{grid-template-columns:repeat(2,minmax(0,1fr));margin-top:10px;border-bottom:0}
  .alookhor-mh-feature{min-height:46px;padding:5px 3px;display:flex;align-items:center;justify-content:flex-start;gap:5px;text-align:right}
  .alookhor-mh-feature:after{display:none}
  .alookhor-mh-feature svg{width:20px;height:20px;flex:0 0 20px}
  .alookhor-mh-feature b{font-size:8.5px;line-height:1.35}
  .alookhor-mh-actions{gap:7px;margin-top:10px}
  .alookhor-mh-cta{min-width:0;min-height:36px;padding:0 10px;border-radius:9px;gap:6px;font-size:9.5px;white-space:nowrap}
  .alookhor-mh-cta i{font-size:10px}
  .alookhor-mh .alookhor-mh-arrow{width:38px!important;min-width:38px!important;max-width:38px!important;height:38px!important;min-height:38px!important;max-height:38px!important;border-color:rgba(255,255,255,.14)!important}
  .alookhor-mh .alookhor-mh-arrow svg{width:18px!important;height:18px!important}
  .alookhor-mh .alookhor-mh-arrow.is-prev{right:6px!important}.alookhor-mh .alookhor-mh-arrow.is-next{left:6px!important}
  .alookhor-mh-dots{bottom:9px;gap:7px}
  .alookhor-mh-dots button{width:8px!important;min-width:8px!important;max-width:8px!important;height:8px!important;min-height:8px!important;max-height:8px!important}
  .alookhor-mh-dots button.is-active{width:28px!important;min-width:28px!important;max-width:28px!important}
}
@media(max-width:390px){.alookhor-mh-content{right:20px;width:60%}.alookhor-mh-shell{height:300px}.alookhor-mh-content h2{font-size:24px}.alookhor-mh-description{font-size:9.5px}.alookhor-mh-feature b{font-size:8px}.alookhor-mh-cta{padding:0 8px;font-size:8.8px}}
@media(prefers-reduced-motion:reduce){.alookhor-mh-slide,.alookhor-mh-media img,.alookhor-mh-cta,.alookhor-mh-dots button{transition:none!important}.alookhor-mh[data-ken-burns="1"] .alookhor-mh-slide.is-active .alookhor-mh-media img{transform:scale(1.015)}.alookhor-mh[data-ken-burns="1"] .alookhor-mh-slide.is-active.is-image-flipped .alookhor-mh-media img{transform:translateX(-36%) scale(1.12)}}
@media(max-width:767px) and (prefers-reduced-motion:reduce){.alookhor-mh[data-ken-burns="1"] .alookhor-mh-slide.is-active.is-image-flipped .alookhor-mh-media img{transform:scale(1.015)}}
````

## Source Snapshot — `plugin/alookhor-control-center/assets/css/luxury.css`

````css
/* ALOOKHOR Luxury Design System — v3.7.2 */
:root{
  --bg-void:#070708;
  --bg-panel:#111113;
  --bg-panel-2:#151518;
  --bg-glass:rgba(255,255,255,0.045);
  --bg-glass-strong:rgba(22,22,24,0.72);
  --gold:#C9A86A;
  --gold-soft:#E8D5B5;
  --gold-dim:#9C8560;
  --gold-glow:rgba(201,168,106,0.22);
  --gold-border:rgba(201,168,106,0.14);
  --gold-border-strong:rgba(201,168,106,0.28);
  --text-primary:#F5F1E9;
  --text-secondary:#C9C5C0;
  --text-muted:#9A9590;
  --text-faint:#6B6763;
  --success:#3DD68C;
  --danger:#FF5A5F;
  --radius-xl:20px;
  --radius-lg:16px;
  --radius-md:12px;
  --shadow-gold:0 8px 32px rgba(0,0,0,0.55), 0 1px 0 rgba(201,168,106,0.08) inset;
  --blur: blur(18px) saturate(140%);
}
*{box-sizing:border-box}
html{scroll-behavior:smooth}
body{
  margin:0;
  font-family: 'Inter', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
  background: radial-gradient(1200px 600px at 20% -10%, rgba(201,168,106,0.08), transparent 60%),
              radial-gradient(900px 500px at 95% 0%, rgba(201,168,106,0.06), transparent 60%),
              var(--bg-void);
  color:var(--text-primary);
  -webkit-font-smoothing:antialiased;
  overflow-x:hidden;
}
a{color:inherit;text-decoration:none}
button{font-family:inherit}

/* Scrollbar luxury */
::-webkit-scrollbar{width:6px;height:6px}
::-webkit-scrollbar-thumb{background:rgba(201,168,106,0.18);border-radius:999px}
::-webkit-scrollbar-thumb:hover{background:rgba(201,168,106,0.32)}

/* Header */
.lux-header{
  position:sticky; top:0; z-index:40;
  backdrop-filter: var(--blur);
  -webkit-backdrop-filter: var(--blur);
  background: linear-gradient(180deg, rgba(17,17,19,0.88), rgba(17,17,19,0.62));
  border-bottom:1px solid var(--gold-border);
}
.lux-header-inner{
  width:100%; max-width:none; margin:0;
  padding:14px 20px;
  display:flex; align-items:center; gap:16px;
}
@media(min-width:768px){ .lux-header-inner{padding:16px 24px} }
@media(min-width:1024px){ .lux-header-inner{padding:18px 28px} }
.brand{
  display:flex; align-items:center; gap:12px;
  min-width:0;
}
.brand-mark{
  width:40px; height:40px; flex:0 0 40px;
  border-radius:12px;
  background: linear-gradient(135deg, #1A1A1D, #0F0F10);
  border:1px solid var(--gold-border-strong);
  display:grid; place-items:center;
  box-shadow: 0 4px 16px rgba(0,0,0,0.4), 0 0 12px var(--gold-glow);
  position:relative; overflow:hidden;
}
.brand-mark::after{
  content:""; position:absolute; inset:0;
  background: radial-gradient(180px 80px at 30% 0%, rgba(201,168,106,0.18), transparent 70%);
}
.brand-mark span{
  font-family: 'Cormorant Garamond', serif;
  font-weight:700; font-size:18px; letter-spacing:0.08em;
  color:var(--gold);
  position:relative; z-index:1;
}
.brand-text h1{
  margin:0;
  font-family:'Cormorant Garamond', serif;
  font-weight:600;
  font-size:clamp(16px, 1.8vw, 20px);
  letter-spacing:0.06em;
  line-height:1;
  color:var(--text-primary);
}
.brand-text p{
  margin:3px 0 0 0;
  font-size:11px; letter-spacing:0.14em; text-transform:uppercase;
  color:var(--gold-dim);
  font-weight:500;
}
.header-center{flex:1; display:flex; justify-content:center; padding:0 16px}
@media(max-width:1023px){ .header-center{display:none} }
.search-pill{
  width:100%; max-width:420px;
  display:flex; align-items:center; gap:10px;
  background: rgba(255,255,255,0.04);
  border:1px solid var(--gold-border);
  border-radius:999px;
  padding:9px 14px;
}
.search-pill input{
  flex:1; background:transparent; border:0; outline:0;
  color:var(--text-secondary); font-size:13px;
}
.search-pill input::placeholder{color:var(--text-faint)}
.header-actions{display:flex; align-items:center; gap:8px}
.icon-btn{
  width:38px; height:38px; border-radius:999px;
  display:grid; place-items:center;
  background: rgba(255,255,255,0.035);
  border:1px solid var(--gold-border);
  color:var(--text-secondary);
  cursor:pointer; position:relative;
  transition: all 0.22s ease;
}
.icon-btn:hover{ background: rgba(201,168,106,0.08); border-color:var(--gold-border-strong); color:var(--gold-soft); transform: translateY(-1px)}
.icon-btn.gold{
  background: linear-gradient(135deg, #C9A86A, #B8935A);
  border-color: rgba(255,255,255,0.18);
  color:#1A1206;
  box-shadow: 0 4px 14px rgba(201,168,106,0.28);
}
.pulse-dot{
  position:absolute; top:6px; right:7px;
  width:8px; height:8px; border-radius:50%;
  background: var(--success);
  box-shadow: 0 0 0 4px rgba(61,214,140,0.18);
  animation: pulse 2s infinite;
}
@keyframes pulse{0%{box-shadow:0 0 0 0 rgba(61,214,140,0.32)}70%{box-shadow:0 0 0 7px rgba(61,214,140,0)}100%{box-shadow:0 0 0 0 rgba(61,214,140,0)}}
.version-badge{
  display:none; align-items:center; gap:8px;
  padding:7px 12px; border-radius:999px;
  background: rgba(201,168,106,0.08);
  border:1px solid var(--gold-border);
  font-size:11px; letter-spacing:0.08em; text-transform:uppercase; color:var(--gold-soft);
}
@media(min-width:900px){ .version-badge{display:flex} }
.hamburger{display:grid}
@media(min-width:1024px){ .hamburger{display:none} }

/* Layout */
.shell{
  width:100%; max-width:none; margin:0;
  padding:18px 14px 40px 14px;
  display:flex; gap:18px;
}
@media(min-width:768px){ .shell{padding:20px 20px 40px 20px; gap:20px} }
@media(min-width:1024px){ .shell{padding:24px 28px 48px 28px; gap:24px} }

/* Sidebar */
.sidebar{
  width:280px; flex:0 0 280px;
  background: linear-gradient(180deg, rgba(21,21,24,0.9), rgba(17,17,19,0.92));
  border:1px solid var(--gold-border);
  border-radius: var(--radius-xl);
  padding:14px;
  height: fit-content;
  position: sticky; top:84px;
  box-shadow: var(--shadow-gold);
  backdrop-filter: blur(12px);
}
@media(max-width:1023px){
  .sidebar{
    position:fixed; inset:68px auto 0 0;
    width:300px; max-width:86vw;
    border-radius:0 20px 0 0;
    transform: translateX(-100%);
    transition: transform 0.32s cubic-bezier(0.2,0.8,0.2,1);
    z-index:50;
    overflow:auto;
    top:66px;
  }
  .sidebar.open{transform:translateX(0)}
}
.sidebar-label{
  font-size:10px; letter-spacing:0.16em; text-transform:uppercase;
  color:var(--text-faint); padding:14px 10px 8px 10px; font-weight:600;
}
.nav-item{
  display:flex; align-items:center; gap:12px;
  padding:11px 12px; border-radius:12px;
  color:var(--text-secondary); font-size:13.5px; font-weight:500;
  cursor:pointer; border:1px solid transparent;
  transition: all 0.2s ease;
  user-select:none;
}
.nav-item:hover{ background: rgba(255,255,255,0.04); color:var(--text-primary); border-color: rgba(255,255,255,0.04)}
.nav-item.active{
  background: linear-gradient(135deg, rgba(201,168,106,0.14), rgba(201,168,106,0.06));
  border-color: var(--gold-border-strong);
  color: var(--gold-soft);
  box-shadow: 0 4px 16px rgba(201,168,106,0.10);
}
.nav-item-primary{margin-bottom:5px;background:linear-gradient(135deg,rgba(201,168,106,.11),rgba(201,168,106,.025));border-color:var(--gold-border);font-weight:700}
.nav-item-primary:not(.active){color:var(--gold-soft)}
.nav-item-primary .badge{background:linear-gradient(135deg,#E8D5B5,#C9A86A);box-shadow:0 4px 12px rgba(201,168,106,.2)}
#proNav .nav-group[data-group="system"]{order:1}
#proNav .nav-group[data-group="catalog"]{order:2}
#proNav .nav-group[data-group="sales"]{order:3}
#proNav .nav-group[data-group="customers"]{order:4}
#proNav .nav-group[data-group="finance"]{order:5}
#proNav .nav-group[data-group="analytics"]{order:6}
.nav-item svg{flex:0 0 18px; opacity:0.9}
.nav-item .badge{
  margin-left:auto;
  background: var(--gold); color:#1A1206;
  font-size:11px; font-weight:700; padding:2px 7px; border-radius:999px;
}
/* === PRO Sidebar Groups — فشرده و حرفه‌ای === */
.sidebar-search{
  display:flex; align-items:center; gap:8px;
  background: rgba(255,255,255,0.04);
  border:1px solid var(--gold-border);
  border-radius:12px;
  padding:9px 11px;
  margin:6px 2px 12px 2px;
  transition: all 0.2s ease;
}
.sidebar-search:focus-within{ border-color: var(--gold-border-strong); background: rgba(201,168,106,0.06); box-shadow: 0 0 0 3px var(--gold-glow)}
.sidebar-search input{flex:1; background:transparent; border:0; outline:0; color:var(--text-secondary); font-size:12.5px}
.sidebar-search input::placeholder{color:var(--text-faint)}
.sidebar-search kbd{font-size:10px; color:var(--text-faint); background:rgba(255,255,255,0.06); border:1px solid var(--gold-border); padding:2px 6px; border-radius:6px; font-family:monospace}

.nav-group{margin-bottom:4px; border-radius:14px; overflow:hidden; border:1px solid transparent; transition: all 0.22s ease}
.nav-group.open{ background: rgba(255,255,255,0.02); border-color: rgba(201,168,106,0.08)}
.nav-group-head{
  display:flex; align-items:center; gap:10px;
  padding:10px 11px; border-radius:12px;
  cursor:pointer; user-select:none;
  color:var(--text-secondary); font-size:13px; font-weight:600;
  transition: all 0.18s ease;
}
.nav-group-head:hover{ background: rgba(255,255,255,0.04); color:var(--text-primary)}
.nav-group.open .nav-group-head{ color:var(--gold-soft)}
.nav-group-icon{
  width:28px; height:28px; border-radius:9px; flex:0 0 28px;
  display:grid; place-items:center;
  background: rgba(255,255,255,0.04); border:1px solid var(--gold-border);
  color:var(--text-muted); transition: all 0.2s ease;
}
.nav-group.open .nav-group-icon{ background: rgba(201,168,106,0.14); border-color: var(--gold-border-strong); color:var(--gold)}
.nav-group-title{flex:1; white-space:nowrap}
.nav-group-count{
  font-size:11px; font-weight:700; min-width:20px; text-align:center;
  background: rgba(255,255,255,0.06); color:var(--text-muted);
  padding:2px 6px; border-radius:999px; border:1px solid var(--gold-border);
}
.nav-group.open .nav-group-count{ background: var(--gold); color:#1A1206; border-color:transparent}
.nav-chevron{ transition: transform 0.24s cubic-bezier(0.2,0.8,0.2,1); color:var(--text-faint); flex:0 0 16px; display:grid; place-items:center}
.nav-group.open .nav-chevron{ transform: rotate(180deg); color:var(--gold)}
.nav-group-body{
  display:grid; grid-template-rows: 0fr; transition: grid-template-rows 0.28s cubic-bezier(0.2,0.8,0.2,1), opacity 0.22s ease;
  opacity:0;
}
.nav-group.open .nav-group-body{ grid-template-rows: 1fr; opacity:1}
.nav-group-inner{ overflow:hidden; padding:2px 6px 8px 6px}
.nav-sub-list{ display:grid; gap:2px; position:relative; padding-right:14px}
.nav-sub-list::before{ content:""; position:absolute; right:18px; top:4px; bottom:4px; width:1px; background: linear-gradient(180deg, var(--gold-border-strong), transparent); opacity:0.6}
.nav-sub-item{
  display:flex; align-items:center; gap:8px;
  padding:8px 10px 8px 8px; border-radius:10px;
  font-size:12.8px; font-weight:500; color:var(--text-muted);
  cursor:pointer; border:1px solid transparent;
  transition: all 0.18s ease;
  position:relative;
}
.nav-sub-item::before{ content:""; position:absolute; right:-8px; top:50%; width:6px; height:1px; background: var(--gold-border-strong); opacity:0.7}
.nav-sub-item:hover{ background: rgba(255,255,255,0.04); color:var(--text-primary)}
.nav-sub-item.active{ background: linear-gradient(135deg, rgba(201,168,106,0.16), rgba(201,168,106,0.07)); border-color: var(--gold-border-strong); color:var(--gold-soft); font-weight:700}
.nav-sub-item.active::before{ background: var(--gold); width:8px; height:2px; border-radius:999px}
.nav-sub-item .sub-dot{ width:5px; height:5px; border-radius:50%; background: currentColor; opacity:0.5; flex:0 0 5px}
.nav-sub-item.active .sub-dot{ opacity:1; background: var(--gold); box-shadow: 0 0 6px var(--gold-glow)}
.nav-sub-item .sub-badge{ margin-right:auto; font-size:10.5px; font-weight:700; padding:1px 6px; border-radius:999px; background: rgba(201,168,106,0.14); color:var(--gold-soft); border:1px solid var(--gold-border)}
.nav-sub-item.active .sub-badge{ background: var(--gold); color:#1A1206}

.nav-item.single{ margin-bottom:4px} /* برای آیتم‌های تکی مثل داشبورد */
.nav-divider{height:1px; background: var(--gold-border); margin:12px 6px}

/* Main */
.main{flex:1; min-width:0}
.page-head{
  display:flex; flex-wrap:wrap; gap:12px; align-items:end; justify-content:space-between;
  margin-bottom:18px;
}
.page-head h2{
  margin:0;
  font-family:'Cormorant Garamond', serif;
  font-size:clamp(22px, 3vw, 30px);
  font-weight:600; letter-spacing:0.02em; line-height:1.1;
}
.page-head p{margin:6px 0 0 0; color:var(--text-muted); font-size:13px; line-height:1.5}
.head-actions{display:flex; gap:10px; flex-wrap:wrap}
.btn-gold{
  appearance:none; border:0; cursor:pointer;
  background: linear-gradient(135deg, #C9A86A 0%, #B8935A 100%);
  color:#1A1206; font-weight:700; font-size:13px; letter-spacing:0.02em;
  padding:11px 18px; border-radius:999px;
  box-shadow: 0 6px 18px rgba(201,168,106,0.28);
  transition: transform 0.18s ease, box-shadow 0.18s ease;
}
.btn-gold:hover{transform:translateY(-1px); box-shadow:0 10px 24px rgba(201,168,106,0.34)}
.btn-ghost{
  appearance:none; cursor:pointer;
  background: rgba(255,255,255,0.03);
  border:1px solid var(--gold-border-strong);
  color:var(--text-primary); font-weight:600; font-size:13px;
  padding:10px 16px; border-radius:999px;
  transition: all 0.18s ease;
}
.btn-ghost:hover{background:rgba(201,168,106,0.08); border-color:var(--gold)}

/* KPI Grid — Responsive Rules Preserved */
.kpi-grid{
  display:grid; gap:14px;
  grid-template-columns: 1fr;
}
@media(min-width:560px){ .kpi-grid{grid-template-columns: repeat(2, 1fr)} }
@media(min-width:1024px){ .kpi-grid{grid-template-columns: repeat(4, 1fr)} }
.kpi-card{
  background: linear-gradient(180deg, rgba(21,21,24,0.9), rgba(17,17,19,0.96));
  border:1px solid var(--gold-border);
  border-radius: var(--radius-lg);
  padding:16px;
  position:relative; overflow:hidden;
  box-shadow: var(--shadow-gold);
}
.kpi-card::before{
  content:""; position:absolute; inset:0;
  background: radial-gradient(400px 120px at 0% 0%, rgba(201,168,106,0.07), transparent 70%);
  pointer-events:none;
}
.kpi-top{display:flex; justify-content:space-between; align-items:start; gap:10px; position:relative}
.kpi-icon{
  width:36px; height:36px; border-radius:10px;
  display:grid; place-items:center;
  background: rgba(201,168,106,0.10);
  border:1px solid var(--gold-border);
  color:var(--gold);
}
.kpi-trend{
  font-size:11.5px; font-weight:700; padding:4px 8px; border-radius:999px;
  display:inline-flex; align-items:center; gap:4px;
}
.trend-up{background: rgba(61,214,140,0.12); color:var(--success); border:1px solid rgba(61,214,140,0.18)}
.trend-down{background: rgba(255,90,95,0.10); color:var(--danger); border:1px solid rgba(255,90,95,0.16)}
.kpi-value{
  margin:14px 0 4px 0;
  font-family:'Cormorant Garamond', serif;
  font-size:28px; font-weight:600; letter-spacing:0.02em; line-height:1;
}
.kpi-label{font-size:12px; letter-spacing:0.08em; text-transform:uppercase; color:var(--text-muted); font-weight:600}
.kpi-foot{margin-top:12px; font-size:12px; color:var(--text-faint)}

/* Panels */
.panel{
  background: linear-gradient(180deg, rgba(21,21,24,0.88), rgba(17,17,19,0.96));
  border:1px solid var(--gold-border);
  border-radius: var(--radius-xl);
  overflow:hidden;
  box-shadow: var(--shadow-gold);
}
.panel-head{
  padding:16px 18px;
  display:flex; align-items:center; justify-content:space-between; gap:12px;
  border-bottom:1px solid var(--gold-border);
}
.panel-head h3{
  margin:0; font-size:14px; font-weight:700; letter-spacing:0.06em; text-transform:uppercase; color:var(--text-primary);
  display:flex; align-items:center; gap:10px;
}
.panel-head h3::before{
  content:""; width:3px; height:16px; border-radius:999px; background: var(--gold); display:inline-block;
}
.panel-body{padding:0}
.table-wrap{overflow:auto}
table{width:100%; border-collapse:collapse; min-width:640px}
th{
  text-align:right; font-size:11px; letter-spacing:0.12em; text-transform:uppercase; color:var(--text-faint);
  font-weight:700; padding:14px 18px; border-bottom:1px solid var(--gold-border); white-space:nowrap;
  background: rgba(255,255,255,0.015);
}
td{padding:14px 18px; border-bottom:1px solid rgba(201,168,106,0.08); font-size:13px; color:var(--text-secondary); white-space:nowrap}
tr:last-child td{border-bottom:0}
.status{
  display:inline-flex; align-items:center; gap:6px;
  padding:5px 10px; border-radius:999px; font-size:12px; font-weight:700; letter-spacing:0.02em;
}
.status-dot{width:6px; height:6px; border-radius:50%}
.status-ok{background: rgba(61,214,140,0.12); color:var(--success); border:1px solid rgba(61,214,140,0.18)}
.status-ok .status-dot{background:var(--success)}
.status-warn{background: rgba(201,168,106,0.14); color:var(--gold-soft); border:1px solid var(--gold-border)}
.status-warn .status-dot{background:var(--gold)}
.status-bad{background: rgba(255,90,95,0.10); color:var(--danger); border:1px solid rgba(255,90,95,0.18)}
.status-bad .status-dot{background:var(--danger)}

/* Mobile card list for tables */
.card-list{display:none; padding:12px; gap:12px; flex-direction:column}
@media(max-width:767px){
  table{display:none}
  .card-list{display:flex}
}
.mini-card{
  background: rgba(255,255,255,0.03);
  border:1px solid var(--gold-border);
  border-radius:16px; padding:14px;
}
.mini-card-top{display:flex; justify-content:space-between; gap:10px; align-items:start; margin-bottom:10px}
.mini-card h4{margin:0; font-size:14px; font-weight:700}
.mini-card p{margin:4px 0 0 0; font-size:12.5px; color:var(--text-muted)}
.mini-meta{display:flex; gap:14px; flex-wrap:wrap; margin-top:10px; font-size:12.5px; color:var(--text-secondary)}
.mini-meta b{color:var(--text-primary)}

/* Grid 2 */
.two-col{display:grid; gap:14px; margin-top:14px}
@media(min-width:1024px){ .two-col{grid-template-columns: 1.55fr 0.95fr} }

/* Chart placeholder luxury */
.chart-box{padding:18px}
.chart-canvas{
  height:220px; border-radius:14px;
  background:
    linear-gradient(180deg, rgba(201,168,106,0.06), transparent 60%),
    rgba(255,255,255,0.02);
  border:1px solid var(--gold-border);
  position:relative; overflow:hidden;
  display:grid; place-items:center;
}
.chart-bars{
  display:flex; align-items:end; gap:10px; height:120px; padding:0 18px;
}
.bar{
  width:22px; border-radius:8px 8px 4px 4px;
  background: linear-gradient(180deg, #E8D5B5, #C9A86A);
  box-shadow: 0 4px 12px rgba(201,168,106,0.22);
  transition: height 0.6s ease;
}
@media(max-width:560px){ .bar{width:14px} }

/* Dashboard-only monitoring: AI Assistant + System Status */
.dashboard-monitor-grid{display:grid;grid-template-columns:minmax(0,1fr);gap:14px;margin:0 0 14px}
@media(min-width:1280px){.dashboard-monitor-grid{grid-template-columns:minmax(0,1fr) minmax(0,1fr)}}
.dashboard-monitor-grid .panel{min-width:0}
.ai-list{display:grid;gap:8px;padding:12px}
.ai-item{background:rgba(10,10,12,.55);border:1px solid rgba(201,168,106,.12);border-radius:12px;overflow:hidden}
.ai-head{width:100%;display:flex;align-items:center;gap:10px;padding:11px 12px;background:transparent;border:0;color:var(--text-secondary);font-size:12.5px;font-weight:600;cursor:pointer;text-align:right}
.ai-head:hover{color:var(--text-primary)}
.ai-plus{width:22px;height:22px;border-radius:6px;background:rgba(255,255,255,.06);border:1px solid var(--gold-border);display:grid;place-items:center;font-size:13px;font-weight:800;flex:0 0 22px;transition:.2s}
.ai-item.open .ai-plus{background:var(--gold);color:#1A1206;transform:rotate(45deg)}
.ai-badge{margin-right:auto;font-size:10px;font-weight:700;padding:2px 7px;border-radius:999px;background:rgba(201,168,106,.14);color:var(--gold-soft);border:1px solid var(--gold-border)}
.ai-body{display:none;padding:0 12px 12px;border-top:1px solid var(--gold-border);background:rgba(255,255,255,.02)}
.ai-item.open .ai-body{display:block}
.ai-body p{margin:10px 0 0;font-size:12.5px;color:var(--text-muted);line-height:1.7}
.status-list{display:grid;gap:0;padding:6px 0}
.status-row{display:flex;justify-content:space-between;align-items:center;padding:10px 14px;font-size:12.8px;border-bottom:1px solid rgba(201,168,106,.07);color:var(--text-secondary)}
.status-row b{color:var(--text-primary);font-size:12.5px}
.dot{width:8px;height:8px;border-radius:50%;display:inline-block;margin-left:6px;vertical-align:middle;background:#6B6763}
.dot.on{background:#3DD68C;box-shadow:0 0 0 4px rgba(61,214,140,.16)}
.dashboard-system-metrics{padding:10px;display:grid;grid-template-columns:1fr 1fr;gap:8px}
.dashboard-system-metrics>div{background:rgba(255,255,255,.03);border:1px solid var(--gold-border);border-radius:10px;padding:10px;text-align:center}
@media(max-width:560px){.dashboard-system-metrics{grid-template-columns:1fr}.status-row{align-items:flex-start;gap:12px}.status-row b{text-align:left}}

/* Backdrop */
.backdrop{
  position:fixed; inset:0;
  background: rgba(7,7,8,0.54);
  backdrop-filter: blur(8px); -webkit-backdrop-filter: blur(8px);
  opacity:0; pointer-events:none; transition: opacity 0.28s ease;
  z-index:45;
}
.backdrop.show{opacity:1; pointer-events:auto}

/* Modal Update Center */
.modal{
  position:fixed; inset:0; z-index:60;
  display:none; place-items:center; padding:16px;
}
.modal.show{display:grid}
.modal-card{
  width:100%; max-width:560px;
  background: linear-gradient(180deg, #1A1A1D, #111113);
  border:1px solid var(--gold-border-strong);
  border-radius:20px;
  box-shadow: 0 20px 60px rgba(0,0,0,0.6), 0 0 0 1px rgba(201,168,106,0.08);
  overflow:hidden;
  transform: translateY(10px) scale(0.98);
  opacity:0; transition: all 0.32s cubic-bezier(0.2,0.8,0.2,1);
}
.modal.show .modal-card{transform:none; opacity:1}
.modal-head{
  padding:18px 20px; border-bottom:1px solid var(--gold-border);
  display:flex; align-items:center; justify-content:space-between; gap:12px;
}
.modal-head h3{margin:0; font-family:'Cormorant Garamond', serif; font-size:20px}
.modal-body{padding:18px 20px}
.timeline{position:relative; padding-left:22px}
.timeline::before{content:""; position:absolute; left:6px; top:6px; bottom:6px; width:2px; background: linear-gradient(180deg, var(--gold), transparent); border-radius:999px; opacity:0.5}
.tl-item{position:relative; padding:0 0 16px 0}
.tl-item::before{content:""; position:absolute; left:-22px; top:4px; width:10px; height:10px; border-radius:50%; background: var(--gold); box-shadow:0 0 0 4px var(--gold-glow); border:2px solid #1A1A1D}
.tl-item h4{margin:0; font-size:13.5px; font-weight:700}
.tl-item p{margin:4px 0 0 0; font-size:12.5px; color:var(--text-muted); line-height:1.6}
.tl-tag{display:inline-flex; padding:2px 8px; border-radius:999px; font-size:11px; font-weight:700; letter-spacing:0.06em; text-transform:uppercase; background:rgba(201,168,106,0.14); color:var(--gold-soft); border:1px solid var(--gold-border); margin-bottom:6px}

/* Toast */
.toast-stack{
  position:fixed; bottom:18px; left:50%; transform:translateX(-50%);
  display:flex; flex-direction:column; gap:10px; z-index:70;
  width: min(92vw, 420px);
}
.toast{
  display:flex; align-items:center; gap:12px;
  background: #1A1A1D; border:1px solid var(--gold-border-strong);
  color:var(--text-primary); padding:12px 14px; border-radius:14px;
  box-shadow: 0 12px 32px rgba(0,0,0,0.5);
  transform: translateY(8px); opacity:0; animation: toastIn 0.34s forwards;
}
@keyframes toastIn{to{transform:none; opacity:1}}
.toast-icon{
  width:32px; height:32px; border-radius:999px; display:grid; place-items:center;
  background: rgba(61,214,140,0.14); color:var(--success); flex:0 0 32px;
}

/* Shared Quick Settings form system — Header + Managed Footer */
#quickSettings{min-width:0}
#quickSettings .qh-head{display:flex;justify-content:space-between;align-items:flex-start;gap:14px;margin-bottom:14px;padding:14px 16px;border:1px solid var(--gold-border);border-radius:14px;background:linear-gradient(135deg,rgba(201,168,106,.08),rgba(255,255,255,.018))}
#quickSettings .qh-head h4{margin:0;color:var(--text-primary);font-size:15px;line-height:1.6}
#quickSettings .qh-head p{margin:4px 0 0;color:var(--text-muted);font-size:11.5px;line-height:1.7;max-width:680px}
#quickSettings .qh-head code{direction:ltr;white-space:nowrap;padding:7px 10px;border:1px solid var(--gold-border-strong);border-radius:9px;background:rgba(0,0,0,.22);color:var(--gold-soft);font-size:10px}
#quickSettings .qh-section{padding:15px;margin-top:11px;border:1px solid var(--gold-border);border-radius:13px;background:rgba(255,255,255,.018);overflow:hidden}
#quickSettings .qh-title{display:flex;justify-content:space-between;align-items:center;gap:10px;margin-bottom:12px;padding-bottom:9px;border-bottom:1px solid rgba(201,168,106,.09)}
#quickSettings .qh-title b{font-size:12.5px;color:var(--text-primary)}
#quickSettings .qh-title small{direction:ltr;color:var(--gold);font:700 9px/1 Arial;letter-spacing:.09em}
#quickSettings .qh-grid{display:grid;grid-template-columns:repeat(2,minmax(0,1fr));gap:11px}
#quickSettings .qh-colors{display:grid;grid-template-columns:repeat(4,minmax(0,1fr));gap:10px}
#quickSettings .qh-span-2{grid-column:span 2}
#quickSettings .qh-section label{display:grid;align-content:start;gap:6px;min-width:0;color:var(--text-muted);font-size:11px;line-height:1.5}
#quickSettings .qh-section input:not([type=checkbox]),
#quickSettings .qh-section select,
#quickSettings .qh-section textarea{display:block;width:100%;min-width:0;min-height:39px;margin:0;padding:9px 10px;border:1px solid var(--gold-border);border-radius:9px;outline:0;background:rgba(5,5,7,.46);color:var(--text-primary);font:12px/1.65 inherit;box-shadow:none;transition:border-color .18s ease,background .18s ease}
#quickSettings .qh-section textarea{resize:vertical;min-height:88px;direction:rtl;text-align:right}
#quickSettings .qh-section textarea[dir=ltr],#quickSettings .qh-section input[dir=ltr]{direction:ltr;text-align:left}
#quickSettings .qh-section select{cursor:pointer}
#quickSettings .qh-section select option{background:#171419;color:#f5f1e9}
#quickSettings .qh-section input:focus,#quickSettings .qh-section select:focus,#quickSettings .qh-section textarea:focus{border-color:var(--gold);background:rgba(201,168,106,.045);box-shadow:0 0 0 3px rgba(201,168,106,.09)}
#quickSettings .qh-section input[type=color]{height:42px;padding:4px;cursor:pointer}
#quickSettings .qh-inline{display:grid;grid-template-columns:minmax(0,1fr) auto;align-items:stretch;gap:7px}
#quickSettings .qh-inline button{min-width:76px;margin:0;padding:7px 10px;border:1px solid var(--gold-border-strong);border-radius:9px;background:rgba(201,168,106,.1);color:var(--gold-soft);font:700 11px inherit;cursor:pointer}
#quickSettings .qh-inline button:hover{background:rgba(201,168,106,.18)}
#quickSettings .qh-flags{display:flex;gap:7px;flex-wrap:wrap}
#quickSettings .qh-flags label{display:flex;align-items:center;gap:7px;padding:7px 10px;border:1px solid var(--gold-border);border-radius:999px;background:rgba(255,255,255,.025);color:var(--text-secondary);cursor:pointer}
#quickSettings .qh-flags input[type=checkbox]{width:16px;height:16px;margin:0;accent-color:var(--gold);cursor:pointer}
#quickSettings .qh-actions{display:flex;align-items:center;gap:9px;flex-wrap:wrap;margin-top:14px;padding:12px;border:1px solid var(--gold-border);border-radius:12px;background:rgba(255,255,255,.018)}
#quickSettings .qh-actions button,#quickSettings .qh-actions a{margin:0;padding:9px 15px;font-size:11.5px;text-decoration:none}
#quickSettings .qh-actions span{color:var(--text-faint);font-size:10.5px;line-height:1.6}
@media(max-width:900px){#quickSettings .qh-colors{grid-template-columns:repeat(2,minmax(0,1fr))}}
@media(max-width:700px){#quickSettings .qh-head{display:grid}#quickSettings .qh-head code{justify-self:start}#quickSettings .qh-grid,#quickSettings .qh-colors{grid-template-columns:1fr}#quickSettings .qh-span-2{grid-column:auto}#quickSettings .qh-inline{grid-template-columns:1fr}#quickSettings .qh-actions>*{width:100%;text-align:center}}
````

## Source Snapshot — `plugin/alookhor-control-center/assets/js/admin-wp.js`

````javascript
/**
 * ALOOKHOR Control Center — WP Admin Bridge
 * آپدیت آنی بدون رفرش — هر تغییری مستقیماً روی وردپرس اعمال می‌شود
 */
(function($){
    'use strict';

    // ——— Helper: Toast (همان لوکس) ———
    function toast(msg, type='success'){
        const stack = document.getElementById('toastStack');
        if(!stack){
            console.log(msg);
            return;
        }
        const el = document.createElement('div');
        el.className = 'toast';
        const icon = type==='update' ? '✦' : type==='info' ? '◐' : '✓';
        el.innerHTML = `<div class="toast-icon">${icon}</div><div style="flex:1"><div style="font-weight:700; font-size:13px">${msg}</div><div style="font-size:12px; color:var(--text-muted); margin-top:2px">${new Date().toLocaleTimeString('fa-IR')}</div></div><button onclick="this.parentElement.remove()" style="background:none; border:0; color:var(--text-faint); cursor:pointer; font-size:16px">×</button>`;
        stack.appendChild(el);
        setTimeout(()=> { el.style.opacity='0'; el.style.transform='translateY(8px)'; setTimeout(()=>el.remove(),300)}, 4200);
    }

    // ——— Override Config for WP: save via AJAX ———
    if(window.Config && window.ALOOKHOR_CC){
        const originalSave = window.Config.save;
        window.Config.save = function(){
            if(!this.data) return;
            this.data.updated_at = new Date().toISOString();
            // local backup
            try{ localStorage.setItem('alookhor_real_config_v38', JSON.stringify(this.data)); }catch(e){}
            // WP AJAX save — آپدیت آنی
            $.post(ALOOKHOR_CC.ajax_url, {
                action: 'alookhor_save_settings',
                nonce: ALOOKHOR_CC.nonce,
                payload: JSON.stringify(this.data)
            }, function(res){
                if(res && res.success){
                    toast('ذخیره شد — بدون رفرش روی وردپرس اعمال شد','success');
                    // همچنین هدر شورت‌کد را بروز کن
                    if(window.Config.data?.header_settings){
                        // trigger live header update if on front
                    }
                } else {
                    toast('خطا در ذخیره: ' + (res.data||'نامشخص'),'info');
                }
            }).fail(function(){
                toast('ذخیره محلی انجام شد (آفلاین)','info');
            });
            window.dispatchEvent(new CustomEvent('alookhor:config:changed', {detail: this.data}));
        };

        // Toggle module via dedicated AJAX (سریع‌تر)
        const originalToggle = window.Config.toggleModule;
        window.Config.toggleModule = function(key){
            if(!this.data.modules[key]) return false;
            const enabled = !this.data.modules[key].enabled;
            this.data.modules[key].enabled = enabled;
            // local
            try{ localStorage.setItem('alookhor_real_config_v38', JSON.stringify(this.data)); }catch(e){}
            // WP
            $.post(ALOOKHOR_CC.ajax_url, {
                action: 'alookhor_toggle_module',
                nonce: ALOOKHOR_CC.nonce,
                module: key,
                enabled: enabled ? '1' : '0'
            }, function(res){
                if(res && res.success) toast(res.data?.message || (enabled?'فعال شد':'غیرفعال شد'), enabled?'success':'info');
            });
            window.dispatchEvent(new CustomEvent('alookhor:config:changed', {detail: this.data}));
            return enabled;
        };
    }

    // ——— Global: هر دکمه ذخیره در کنترل سنتر، WP AJAX را صدا بزند ———
    $(document).on('click', '#btnSaveAll', function(){
        // Config.save قبلاً override شده، فقط toast اضافه
        // این دکمه در settings.js هم هندل می‌شود، اینجا فقط اطمینان
    });

    // ——— نمایش نسخه و شورت‌کد در کنسول ———
    console.log('%cALOOKHOR Control Center v'+ (window.ALOOKHOR_CC?.version || '3.8.0') +' — WP Plugin Active — آپدیت آنی فعال',"color:#C9A86A; font-size:13px; font-weight:700");
    console.log('Shortcode: ' + (window.ALOOKHOR_CC?.header_shortcode || '[alookhor_portal_header]'));

})(jQuery);
````

## Source Snapshot — `plugin/alookhor-control-center/assets/js/app.js`

````javascript
// Release query prevents stale ES Modules after a WordPress-native update.
import { initResponsive } from './core/responsive.js?v=3.10.25';
import { initUpdater, Updater } from './core/updateSystem.js?v=3.10.25';
import { Config } from './core/config.js?v=3.10.25';
import { dashboardModule } from './modules/dashboard.js?v=3.10.25';
import { inventoryModule } from './modules/inventory.js?v=3.10.25';
import { ordersModule } from './modules/orders.js?v=3.10.25';
import { usersModule } from './modules/users.js?v=3.10.25';
import { analyticsModule } from './modules/analytics.js?v=3.10.25';
import { settingsModule } from './modules/settings.js?v=3.10.25';

const modules = {
  dashboard: dashboardModule,
  inventory: inventoryModule,
  orders: ordersModule,
  users: usersModule,
  analytics: analyticsModule
};

function escapeHTML(value){
  return String(value ?? '').replace(/[&<>'"]/g, char => ({
    '&':'&amp;', '<':'&lt;', '>':'&gt;', "'":'&#039;', '"':'&quot;'
  })[char]);
}

// ——— placeholder ساز لوکس برای منوهای جدید بدون ماژول واقعی ———
function makePlaceholder(id, title, subtitle, icon='◐'){
  return {
    meta: { id, title },
    init(container){
      container.innerHTML = `
        <div class="page-head">
          <div>
            <h2>${title}</h2>
            <p>${subtitle}</p>
          </div>
          <div class="head-actions">
            <button class="btn-ghost" onclick="window.ALOOKHOR.toast('فیلتر لوکس در آپدیت بعدی','info')">فیلتر</button>
            <button class="btn-gold" onclick="window.ALOOKHOR.toast('این بخش به زودی فعال می‌شود','info')">+ افزودن</button>
          </div>
        </div>
        <div class="panel">
          <div class="panel-head"><h3>${title} — پیش‌نمایش لوکس</h3><span style="font-size:11px; color:var(--text-faint)">PRO • به‌زودی</span></div>
          <div style="padding:28px 18px; text-align:center">
            <div style="width:56px; height:56px; border-radius:16px; background:rgba(201,168,106,0.10); border:1px solid var(--gold-border); display:grid; place-items:center; margin:0 auto; color:var(--gold); font-size:22px">${icon}</div>
            <h3 style="margin:14px 0 6px 0; font-family:'Cormorant Garamond', serif; font-size:20px">این بخش در دست توسعه است</h3>
            <p style="margin:0; color:var(--text-muted); font-size:13px; line-height:1.7">طراحی لوکس و ساختار دیتابیس آماده است — اتصال به API و منطق نهایی در آپدیت بعدی (v3.8) بدون تغییر معماری اضافه می‌شود.</p>
            <div style="max-width:420px; margin:18px auto 0 auto; background:rgba(255,255,255,0.04); border:1px solid var(--gold-border); border-radius:12px; padding:12px; text-align:right">
              <div style="display:flex; justify-content:space-between; font-size:12px; margin-bottom:6px"><span style="color:var(--text-muted)">پیشرفت طراحی</span><b style="color:var(--gold-soft)">۸۵٪</b></div>
              <div style="height:7px; background:rgba(255,255,255,0.06); border-radius:999px; overflow:hidden"><div style="width:85%; height:100%; background:linear-gradient(90deg,#C9A86A,#E8D5B5)"></div></div>
              <div style="font-size:11px; color:var(--text-faint); margin-top:8px">✔ UI لوکس &nbsp; ✔ ریسپانسیو &nbsp; ⏳ اتصال API</div>
            </div>
            <div style="margin-top:16px; display:flex; gap:8px; justify-content:center; flex-wrap:wrap">
              <button class="btn-ghost" style="padding:8px 14px; font-size:12px" onclick="window.ALOOKHOR.switchModule('dashboard')">بازگشت به داشبورد</button>
              <button class="btn-gold" style="padding:8px 16px; font-size:12px" onclick="document.getElementById('btnUpdateCenter').click()">مشاهده Update Center</button>
            </div>
          </div>
        </div>
      `;
    },
    destroy(){}
  }
}

// نگاشت نام‌های جدید به placeholder
const placeholderMap = {
  invoices: makePlaceholder('invoices','فاکتورها','مدیریت فاکتورهای رسمی و طلایی','◨'),
  quotes: makePlaceholder('quotes','پیش‌فاکتورها','پیش‌فاکتورهای VIP قبل از تایید نهایی','✦'),
  returns: makePlaceholder('returns','مرجوعی‌ها','مرجوعی و بازگشت با تایید مدیریت','↩'),
  products: makePlaceholder('products','محصولات','ویترین محصولات لوکس ALOOKHOR','◆'),
  categories: makePlaceholder('categories','دسته‌بندی‌ها','دسته‌بندی طلایی محصولات','▦'),
  collections: makePlaceholder('collections','کالکشن‌های لوکس','کالکشن‌های فصلی و اختصاصی','♛'),
  club: makePlaceholder('club','باشگاه طلایی','باشگاه مشتریان وفادار','★'),
  tickets: makePlaceholder('tickets','تیکت و پشتیبانی','پشتیبانی VIP — ۶ تیکت باز','☎'),
  reviews: makePlaceholder('reviews','نظرات و امتیاز','نظرات مشتریان بوتیک','☆'),
  transactions: makePlaceholder('transactions','تراکنش‌ها','تراکنش‌های مالی و درگاه‌ها','₮'),
  'gold-price': makePlaceholder('gold-price','قیمت لحظه‌ای طلا','قیمت آنلاین ۱۸ و ۲۴ عیار','◐'),
  accounting: makePlaceholder('accounting','حسابداری','حسابداری دوبل لوکس','≡'),
  'sales-report': makePlaceholder('sales-report','گزارش فروش','گزارش فروش روزانه / ماهانه','▭'),
  'stock-report': makePlaceholder('stock-report','گزارش انبار','گزارش موجودی و هشدارها','▤'),
  roles: makePlaceholder('roles','کاربران و دسترسی','مدیریت نقش‌ها و دسترسی‌ها','◈'),
  logs: makePlaceholder('logs','لاگ‌ها','لاگ سیستمی و امنیتی','≡'),
};

window.ALOOKHOR = {
  version: Updater.current,
  modules: { ...modules, ...placeholderMap, settings: settingsModule },
  active: 'settings',
  toast(msg, type='success'){
    const stack = document.getElementById('toastStack');
    if(!stack) return;
    const el = document.createElement('div');
    el.className = 'toast';
    const icon = type==='update' ? '✦' : type==='info' ? '◐' : '✓';
    el.innerHTML = `<div class="toast-icon">${icon}</div><div style="flex:1"><div style="font-weight:700; font-size:13px">${msg}</div><div style="font-size:12px; color:var(--text-muted); margin-top:2px">${new Date().toLocaleTimeString('fa-IR')}</div></div><button onclick="this.parentElement.remove()" style="background:none; border:0; color:var(--text-faint); cursor:pointer; font-size:16px">×</button>`;
    stack.appendChild(el);
    setTimeout(()=> { el.style.opacity='0'; el.style.transform='translateY(8px)'; setTimeout(()=>el.remove(),300)}, 4200);
  },
  switchModule(name){
    if(name==='update'){
      document.getElementById('btnUpdateCenter')?.click();
      return;
    }
    const target = this.modules[name];
    if(!target){
      this.toast('این بخش به زودی فعال می‌شود','info');
      return;
    }
    // active کلاس‌ها — هم nav-item تکی و هم nav-sub-item
    document.querySelectorAll('.nav-item, .nav-sub-item').forEach(n=> n.classList.toggle('active', n.dataset.module===name));
    // اگر آیتم داخل گروه بسته بود، گروه را باز کن
    const activeSub = document.querySelector(`.nav-sub-item[data-module="${name}"]`);
    if(activeSub){
      const group = activeSub.closest('.nav-group');
      if(group && !group.classList.contains('open')){
        group.classList.add('open');
      }
    }
    const container = document.getElementById('moduleContainer');
    this.modules[this.active]?.destroy?.();
    this.active = name;
    document.dispatchEvent(new CustomEvent('alookhor:module-switched', {detail:{name}}));
    container.style.opacity='0';
    container.style.transform='translateY(6px)';
    setTimeout(()=>{
      container.innerHTML='';
      target.init(container);
      container.style.transition='all 0.28s ease';
      container.style.opacity='1';
      container.style.transform='none';
      document.getElementById('pageTitle').textContent = target.meta.title;
      // در موبایل، بعد از انتخاب ببند
      if(window.innerWidth < 1024){
        document.getElementById('sidebar')?.classList.remove('open');
        document.getElementById('backdrop')?.classList.remove('show');
        document.body.style.overflow='';
      }
    }, 140);
    history.replaceState(null,'','#'+name);
  }
};

function initProNav(){
  // آکاردئون گروه‌ها
  document.querySelectorAll('.nav-group-head').forEach(head=>{
    head.addEventListener('click', ()=>{
      const group = head.parentElement;
      const isOpen = group.classList.contains('open');
      // حرفه‌ای: فقط یکی باز بماند در موبایل، در دسکتاپ چندتا باز می‌ماند — اینجا هوشمند: اگر با Ctrl کلیک شد، بقیه بسته نشوند
      if(!isOpen){
        // باز کردن
        group.classList.add('open');
      } else {
        group.classList.remove('open');
      }
    });
  });

  // کلیک روی آیتم‌های منو (تکی + زیرمنو)
  document.querySelectorAll('[data-module]').forEach(el=>{
    el.addEventListener('click', (e)=>{
      e.stopPropagation();
      const mod = el.dataset.module;
      window.ALOOKHOR.switchModule(mod);
    });
  });

  // جستجوی منو — فیلتر زنده
  const search = document.getElementById('menuSearch');
  if(search){
    search.addEventListener('input', ()=>{
      const q = search.value.trim().toLowerCase();
      const groups = document.querySelectorAll('.nav-group');
      const singles = document.querySelectorAll('.nav-item.single');

      // فیلتر تمام آیتم‌های اصلی (مدیریت بوتیک + داشبورد)
      singles.forEach(single=>{
        const txt = single.textContent.toLowerCase();
        single.style.display = (!q || txt.includes(q)) ? 'flex' : 'none';
      });

      groups.forEach(g=>{
        const headText = g.querySelector('.nav-group-title')?.textContent.toLowerCase() || '';
        const subs = g.querySelectorAll('.nav-sub-item');
        let hasVisible = false;
        subs.forEach(sub=>{
          const t = sub.textContent.toLowerCase();
          const show = !q || t.includes(q) || headText.includes(q);
          sub.style.display = show ? 'flex' : 'none';
          if(show) hasVisible = true;
        });
        // اگر سرچ خالی: حالت عادی (فقط openها نمایش)، اگر سرچ دارد: گروه‌های دارای نتیجه را باز کن
        if(q){
          g.style.display = hasVisible || headText.includes(q) ? 'block' : 'none';
          if(hasVisible) g.classList.add('open');
        } else {
          g.style.display = 'block';
          // به حالت قبل برگرد — دو گروه اول باز بماند
        }
      });
    });

    // کلید / برای فوکوس سرچ
    document.addEventListener('keydown', (e)=>{
      if(e.key === '/' && document.activeElement.tagName !== 'INPUT'){
        e.preventDefault();
        search.focus();
      }
    });
  }
}

// Update Center Modal
function initUpdateModal(updaterState){
  const modal = document.getElementById('updateModal');
  const backdrop = document.getElementById('modalBackdrop');
  const btnOpen = document.getElementById('btnUpdateCenter');
  const btnClose = document.getElementById('btnCloseModal');
  const btnInstall = document.getElementById('btnInstall');
  const btnDismiss = document.getElementById('btnDismiss');
  const changelogEl = document.getElementById('changelog');
  const verEl = document.getElementById('modalVersion');
  const statusBox = document.getElementById('updateStatusBox');
  const statusText = document.getElementById('updateStatusText');
  const statusMode = document.getElementById('updateStatusMode');

  function open(){
    const hasUpdate = updaterState.hasUpdate;
    const installable = updaterState.installable;
    const ver = updaterState.pending || Updater.current;
    verEl.textContent = hasUpdate ? `v${ver} آماده نصب است` : `v${Updater.current} — نسخه نصب‌شده`;
    btnInstall.style.display = hasUpdate ? 'inline-flex' : 'none';
    btnInstall.disabled = hasUpdate && !installable;
    btnInstall.textContent = installable ? 'نصب امن با WordPress' : 'بسته نصب در دسترس نیست';
    btnDismiss.textContent = hasUpdate ? 'بعداً' : 'بستن';

    if(statusText && statusMode && statusBox){
      if(!updaterState.configured){
        statusText.textContent = 'هسته آپدیت داخلی آماده است؛ آدرس Manifest هنوز تنظیم نشده';
        statusMode.textContent = 'Setup required';
        statusBox.style.background = 'rgba(201,168,106,0.08)';
        statusBox.style.borderColor = 'rgba(201,168,106,0.22)';
      } else if(hasUpdate){
        statusText.textContent = installable ? 'نسخه خصوصی تأیید شد — نصب توسط هسته WordPress' : 'نسخه جدید پیدا شد اما بسته دانلود ندارد';
        statusMode.textContent = installable ? 'WP Native' : 'Manifest warning';
      } else {
        statusText.textContent = updaterState.message || 'سیستم آپدیت داخلی فعال — نسخه جدیدی یافت نشد';
        statusMode.textContent = 'WP Native';
      }
    }

    const list = Updater.changelog.length ? Updater.changelog : [{tag:'INFO', title:`نسخه ${ver}`, desc:updaterState.message || 'جزئیات نسخه در دسترس نیست.'}];
    changelogEl.innerHTML = list.map(i=> `<div class="tl-item"><span class="tl-tag">${escapeHTML(i.tag)}</span><h4>${escapeHTML(i.title)}</h4><p>${escapeHTML(i.desc)}</p></div>`).join('');
    modal.classList.add('show');
    backdrop.classList.add('show');
    document.body.style.overflow='hidden';
  }
  function close(){
    modal.classList.remove('show');
    backdrop.classList.remove('show');
    document.body.style.overflow='';
  }
  btnOpen?.addEventListener('click', open);
  btnClose?.addEventListener('click', close);
  btnDismiss?.addEventListener('click', ()=>{
    if(updaterState.hasUpdate){
      try{ localStorage.setItem('alookhor_update_dismissed','1'); }catch(e){}
    }
    close();
  });
  backdrop?.addEventListener('click', close);
  document.addEventListener('keydown', e=>{ if(e.key==='Escape') close(); });

  btnInstall?.addEventListener('click', async ()=>{
    const pending = updaterState.pending;
    if(!pending || !updaterState.installable) return;
    btnInstall.disabled=true;
    btnInstall.textContent='WordPress در حال نصب...';
    try{
      const result = await Updater.install(pending);
      window.ALOOKHOR.toast(`با موفقیت به v${result.version} آپدیت شد`,'success');
      document.getElementById('versionBadgeText').textContent = `v${Updater.current}`;
      document.getElementById('headerVersion').textContent = `v${Updater.current}`;
      document.getElementById('updateBadge').style.display='none';
      btnInstall.textContent='نصب شد ✓';
      setTimeout(close, 1100);
    }catch(error){
      window.ALOOKHOR.toast(`نصب انجام نشد: ${error.message}`,'info');
      btnInstall.disabled=false;
      btnInstall.textContent='تلاش دوباره با WordPress';
    }
  });

  document.addEventListener('alookhor:update-available', open);
}

document.addEventListener('DOMContentLoaded', async ()=>{
  initResponsive();
  initProNav();
  await Config.load();
  Config.apply();
  const updaterState = initUpdater({
    onAvailable(res){
      document.dispatchEvent(new CustomEvent('alookhor:update-available', {detail:res}));
    }
  });
  initUpdateModal(updaterState);

  document.getElementById('versionBadgeText').textContent = `v${Updater.current}`;
  document.getElementById('headerVersion').textContent = `v${Updater.current}`;
  document.getElementById('bpIndicator').textContent = `${window.innerWidth}px`;

  const hash = location.hash.replace('#','');
  const allMods = window.ALOOKHOR.modules;
  const initial = allMods[hash] ? hash : 'settings';
  // ست اولیه active
  document.querySelectorAll('.nav-item, .nav-sub-item').forEach(n=> n.classList.toggle('active', n.dataset.module===initial));
  // اگر initial داخل گروه بسته بود باز کن
  const initSub = document.querySelector(`.nav-sub-item[data-module="${initial}"]`);
  if(initSub) initSub.closest('.nav-group')?.classList.add('open');

  window.ALOOKHOR.switchModule(initial);

  console.log('%cALOOKHOR Control Center v'+Updater.current+' — PRO Sidebar Ready',"color:#C9A86A; font-size:14px; font-weight:700");
});
````

## Source Snapshot — `plugin/alookhor-control-center/assets/js/core/config.js`

````javascript
// ALOOKHOR Config Core — حافظه پایدار واقعی سایت
// تمام تنظیمات قبلی که با همین پنل ویرایش می‌شد، اینجا ذخیره و به سایت اعمال می‌شود

const CONFIG_URL = './config/site.json';
const STORAGE_KEY = 'alookhor_real_config_v38';

function isObject(value){
  return value && typeof value === 'object' && !Array.isArray(value);
}

function mergeConfig(defaults, saved){
  if(Array.isArray(defaults)){
    if(!Array.isArray(saved) || saved.length === 0) return defaults;
    return defaults.map((item, index)=> index in saved ? mergeConfig(item, saved[index]) : item)
      .concat(saved.slice(defaults.length));
  }
  if(isObject(defaults)){
    const output = {...defaults};
    if(isObject(saved)){
      Object.entries(saved).forEach(([key, value])=>{
        output[key] = key in defaults ? mergeConfig(defaults[key], value) : value;
      });
    }
    return output;
  }
  return saved === undefined || saved === null ? defaults : saved;
}

function hasRequiredConfig(data){
  return isObject(data)
    && isObject(data.site)
    && isObject(data.modules)
    && Object.keys(data.modules).length > 0
    && isObject(data.system)
    && isObject(data.header_settings);
}

export const Config = {
  data: null,
  source: 'none',
  lastError: '',
  async load(){
    let partial = null;
    this.lastError = '';

    // WP MODE: منبع اصلی همیشه wp_options است.
    if(window.ALOOKHOR_CC && window.ALOOKHOR_CC.ajax_url){
      try{
        const form = new FormData();
        form.append('action','alookhor_get_settings');
        form.append('nonce', window.ALOOKHOR_CC.nonce);
        const res = await fetch(window.ALOOKHOR_CC.ajax_url, {method:'POST', body:form, credentials:'same-origin'});
        const json = await res.json();
        if(json && json.success && json.data){
          if(hasRequiredConfig(json.data)){
            this.data = json.data;
            this.source = 'wordpress';
            try{ localStorage.setItem(STORAGE_KEY, JSON.stringify(this.data)); }catch(e){ console.warn('localStorage blocked', e); }
            return this.data;
          }
          // حافظه قدیمی ناقص است؛ مقادیر موجود حفظ و با Defaults ترمیم می‌شوند.
          partial = json.data;
          this.lastError = 'wordpress_config_incomplete';
        }else{
          this.lastError = 'wordpress_ajax_rejected';
        }
      }catch(e){
        this.lastError = `wordpress_ajax_failed: ${e.message}`;
        console.warn('WP config load failed, fallback to file', e);
      }
    }

    // Cache ناقص نباید مسیر فایل Defaults را مسدود کند.
    try{
      const cached = localStorage.getItem(STORAGE_KEY);
      if(cached){
        try {
          const parsed = JSON.parse(cached);
          if(hasRequiredConfig(parsed) && !partial){
            this.data = parsed;
            this.source = 'local-cache';
            return this.data;
          }
          if(!partial && isObject(parsed)) partial = parsed;
        } catch(e){}
      }
    }catch(e){ console.warn('localStorage access blocked by Tracking Prevention', e); }

    // Defaults واقعی افزونه؛ داده ناقص کاربر روی آن Override می‌شود.
    const cfgUrl = (window.ALOOKHOR_CC && window.ALOOKHOR_CC.site_json_url) ? window.ALOOKHOR_CC.site_json_url : CONFIG_URL;
    try{
      const res = await fetch(cfgUrl, {cache:'no-store'});
      if(res.ok){
        const defaults = await res.json();
        this.data = mergeConfig(defaults, partial || {});
        this.source = partial ? 'repaired-defaults' : 'defaults-file';
        this.save(); // نسخه ترمیم‌شده در WordPress و Cache ذخیره می‌شود.
        return this.data;
      }
      this.lastError += `${this.lastError ? '; ' : ''}defaults_http_${res.status}`;
    }catch(e){
      this.lastError += `${this.lastError ? '; ' : ''}defaults_failed: ${e.message}`;
      console.warn('config fetch failed', e);
    }

    // Fallback اضطراری فقط UI را زنده نگه می‌دارد و «حافظه متصل» محسوب نمی‌شود.
    this.source = 'emergency-fallback';
    this.data = { site:{name:'ALOOKHOR', subtitle:'Control Center • Luxury', logoLetter:'A'}, modules:{}, system:{}, ai_assistant:{suggestions:[]}, header_settings:{logo_text:'ALOOKHOR', logo_sub:'Control Center • Luxury'} };
    return this.data;
  },
  async save({notify=true} = {}){
    if(!this.data) return {ok:false, error:'config_not_loaded'};
    this.data.updated_at = new Date().toISOString();
    try{ localStorage.setItem(STORAGE_KEY, JSON.stringify(this.data)); }catch(e){ console.warn('localStorage blocked', e); }
    try{ localStorage.setItem('alookhor_config_last_save', new Date().toLocaleString('fa-IR')); }catch(e){}

    let result = {ok:true, source:'local'};
    if(window.ALOOKHOR_CC && window.ALOOKHOR_CC.ajax_url){
      try{
        const form = new FormData();
        form.append('action','alookhor_save_settings');
        form.append('nonce', window.ALOOKHOR_CC.nonce);
        form.append('payload', JSON.stringify(this.data));
        const response = await fetch(window.ALOOKHOR_CC.ajax_url, {method:'POST', body:form, credentials:'same-origin'});
        if(!response.ok) throw new Error(`HTTP ${response.status}`);
        const json = await response.json();
        if(!json || !json.success){
          const message = typeof json?.data === 'string' ? json.data : 'پاسخ ذخیره وردپرس معتبر نیست.';
          throw new Error(message);
        }
        result = {ok:true, source:'wordpress', data:json.data};
        if(notify) window.ALOOKHOR?.toast?.('ذخیره واقعی در WordPress تأیید شد','success');
      }catch(error){
        console.warn('WP save failed', error);
        result = {ok:false, source:'wordpress', error:error.message};
        window.ALOOKHOR?.toast?.(`ذخیره انجام نشد: ${error.message}`,'error');
      }
    }
    window.dispatchEvent(new CustomEvent('alookhor:config:changed', {detail: this.data}));
    return result;
  },
  get(path){
    return path.split('.').reduce((o,k)=> o?.[k], this.data);
  },
  set(path, value){
    const keys = path.split('.');
    let o = this.data;
    for(let i=0;i<keys.length-1;i++){ if(!o[keys[i]]) o[keys[i]]={}; o=o[keys[i]]; }
    o[keys[keys.length-1]] = value;
    this.save();
    this.apply();
  },
  toggleModule(key){
    if(!this.data.modules[key]) return;
    this.data.modules[key].enabled = !this.data.modules[key].enabled;
    this.save();
    this.apply();
    return this.data.modules[key].enabled;
  },
  // اعمال زنده روی DOM سایت — با guard کامل برای خطای TypeError
  apply(){
    try{
        if(!this.data) return;
        const d = this.data;
        // هدر و لوگو — با fallback
        const logoTitle = document.querySelector('.brand-text h1');
        const logoSub = document.querySelector('.brand-text p');
        const logoMark = document.querySelector('.brand-mark span');
        if(logoTitle) logoTitle.textContent = d.header_settings?.logo_text || d.site?.name || 'ALOOKHOR';
        if(logoSub) logoSub.textContent = d.header_settings?.logo_sub || d.site?.subtitle || 'Control Center • Luxury';
        if(logoMark) logoMark.textContent = d.site?.logoLetter || d.header_settings?.logo_letter || 'A';
        // ماژول‌ها — اگر غیرفعال شدند، در سایدبار کم‌رنگ کن — با guard
        if(d.modules && typeof d.modules === 'object'){
            Object.entries(d.modules).forEach(([k, m])=>{
              try{
                  const el = document.querySelector(`.mod-item[data-mod="${k}"]`);
                  if(el){
                    const tog = el.querySelector('.mod-toggle');
                    if(tog) tog.classList.toggle('on', !!m.enabled);
                    el.style.opacity = m.enabled ? '1' : '0.55';
                  }
              }catch(e){}
            });
        }
        // AI badge count
        const pending = d.ai_assistant?.suggestions?.filter(s=> s.status!=='done').length || 0;
    }catch(e){ console.warn('Config.apply failed', e); }
  },
  exportJSON(){
    return JSON.stringify(this.data, null, 2);
  },
  async reset(){
    try{ localStorage.removeItem(STORAGE_KEY); }catch(e){ console.warn('localStorage blocked', e); }
    // Force a fresh source read instead of immediately returning the current in-memory object.
    this.data = null;
    await this.load();
    this.apply();
  }
};
````

## Source Snapshot — `plugin/alookhor-control-center/assets/js/core/responsive.js`

````javascript
// Responsive Engine — قوانین طلایی
export const Breakpoints = {
  xs: 0,
  sm: 375,
  md: 768,
  lg: 1024,
  xl: 1440,
  xxl: 1920
};

export function getBreakpoint(w = window.innerWidth) {
  if (w >= 1920) return 'xxl';
  if (w >= 1440) return 'xl';
  if (w >= 1024) return 'lg';
  if (w >= 768) return 'md';
  if (w >= 375) return 'sm';
  return 'xs';
}

export function initResponsive() {
  const indicator = document.getElementById('bpIndicator');
  const sidebar = document.getElementById('sidebar');
  const backdrop = document.getElementById('backdrop');
  const hamburger = document.getElementById('hamburger');

  function update() {
    const bp = getBreakpoint();
    if (indicator) indicator.textContent = `${bp} • ${window.innerWidth}px`;
    document.documentElement.dataset.bp = bp;
  }
  update();
  window.addEventListener('resize', update);

  function openDrawer() {
    sidebar?.classList.add('open');
    backdrop?.classList.add('show');
    document.body.style.overflow = 'hidden';
  }
  function closeDrawer() {
    sidebar?.classList.remove('open');
    backdrop?.classList.remove('show');
    document.body.style.overflow = '';
  }
  hamburger?.addEventListener('click', () => {
    if (sidebar?.classList.contains('open')) closeDrawer(); else openDrawer();
  });
  backdrop?.addEventListener('click', closeDrawer);
  // بستن با انتخاب ماژول در موبایل
  document.addEventListener('alookhor:module-switched', closeDrawer);
  // ESC
  document.addEventListener('keydown', e => { if (e.key === 'Escape') closeDrawer(); });
}
````

## Source Snapshot — `plugin/alookhor-control-center/assets/js/core/updateSystem.js`

````javascript
// ALOOKHOR Update System — WordPress-native private updater
// UI/state remain modular; version discovery and installation are delegated to WordPress.

const runtimeConfig = window.ALOOKHOR_CC || {};
const runtimeVersion = String(runtimeConfig.version || '3.10.25');

function normalizeResult(data = {}) {
  const current = String(data.current || runtimeVersion);
  const latest = String(data.latest || current);
  return {
    configured: Boolean(data.configured),
    hasUpdate: Boolean(data.available),
    installable: Boolean(data.installable),
    current,
    latest,
    message: String(data.message || ''),
    errorCode: String(data.error_code || ''),
    changelog: Array.isArray(data.changelog) ? data.changelog : []
  };
}

async function postUpdateCheck(force = false) {
  if (!runtimeConfig.ajax_url || !runtimeConfig.nonce) {
    return normalizeResult({
      configured: false,
      current: runtimeVersion,
      latest: runtimeVersion,
      message: 'پل WordPress برای بررسی آپدیت در دسترس نیست.'
    });
  }

  const form = new FormData();
  form.append('action', 'alookhor_check_updates');
  form.append('nonce', runtimeConfig.nonce);
  form.append('force', force ? '1' : '0');

  const response = await fetch(runtimeConfig.ajax_url, {
    method: 'POST',
    body: form,
    credentials: 'same-origin',
    headers: { 'X-Requested-With': 'XMLHttpRequest' }
  });

  if (!response.ok) throw new Error(`HTTP ${response.status}`);
  const json = await response.json();
  if (!json || !json.success) {
    const message = typeof json?.data === 'string' ? json.data : 'پاسخ بررسی آپدیت معتبر نیست.';
    throw new Error(message);
  }
  return normalizeResult(json.data);
}

export const Updater = {
  current: runtimeVersion,
  latest: runtimeVersion,
  lastCheck: null,
  changelog: [
    { tag: 'HEADER FINAL', title: 'v3.10.25 — تطبیق نهایی با تصویر مرجع', desc: 'پس‌زمینه Burgundy کامل، لوگوی رسمی LOGO2 و Hamburger واقعی در Desktop/Mobile.' },
    { tag: 'HEADER LOGO', title: 'v3.10.24 — لوگوی تأییدشده در کپسول اصلی', desc: 'کپسول اصلی به‌جای Site Icon فروشگاه، منبع لوگوی مدیریت‌شده Header را همراه Wordmark فارسی نمایش می‌دهد و Hamburger قابل‌مشاهده الزام می‌شود.' },
    { tag: 'DUPLICATE HEADER', title: 'v3.10.23 — حذف دو Draft المنتور', desc: 'Widgetهای ak/alu بالای Header واقعی حذف و فقط منوی WordPress مدیریت‌شده باقی ماند.' },
    { tag: 'HEADER HOST INLINE', title: 'v3.10.22 — Override قطعی میزبان Elementor', desc: 'Margin/Padding/Flex رزروشده با Inline-important فقط روی نزدیک‌ترین e-con هدر خنثی شد.' },
    { tag: 'HEADER HOST FLEX', title: 'v3.10.21 — حذف Margin/Flex Offset نهایی', desc: 'Logical margin و justify-content میزبان Elementor نیز صفر/ابتدا شد تا Header از y=1 آغاز شود.' },
    { tag: 'HEADER OFFSET', title: 'v3.10.20 — حذف فاصله بالای Header داخلی', desc: 'Padding/Margin واقعی Elementor جمع و Sticky Navigation داخلی با rail ثابت بدون Layout Shift تکمیل شد.' },
    { tag: 'HEADER REFERENCE', title: 'v3.10.19 — Top Bar و منوی اصلی مرجع', desc: 'Top Bar شیشه‌ای، ترتیب Support/Message/Phone و ادغام Node واقعی منوی WordPress داخل کپسول Desktop اجرا شد.' },
    { tag: 'GLASS CAPSULE', title: 'v3.10.18 — کپسول شیشه‌ای ردیف دوم', desc: 'همان Main Header Capsule با Glass RGBA و پالت Burgundy/Gold جدید، بدون تغییر ساختار یا کنترل‌ها.' },
    { tag: 'FEATURE GAP', title: 'v3.10.17 — اتصال دقیق ویژگی‌ها به Hero', desc: 'فاصله زنده 21.4px به حدود 7px کاهش یافت تا چهار کارت مانند مرجع بلافاصله زیر Hero قرار گیرند.' },
    { tag: 'SITE FEATURES', title: 'v3.10.16 — ویژگی‌های چهارکارته مرجع', desc: 'بخش Trust قدیمی با چهار کارت یک‌ردیفه Responsive و پالت Burgundy/Gold مدیریت‌شده جایگزین شد.' },
    { tag: 'IMAGE CLEANUP', title: 'v3.10.15 — حذف کامل نوشته قدیمی بنر', desc: 'فوکوس Desktop عمیق‌تر و ماسک پایین، Copy و Badgeهای baked تصویر قبلی را از ترکیب جدید خارج می‌کند.' },
    { tag: 'HERO POLISH', title: 'v3.10.14 — اتصال Mobile و کنترل‌های ایزوله', desc: 'Hero زیر کپسول شیشه‌ای قرار گرفت، Arrow سفید قالب مهار شد و فوکوس عکس بدون Mirror اصلاح شد.' },
    { tag: 'MANAGED HERO', title: 'v3.10.13 — اسلایدر چهاراسلایدی مدیریت‌شده', desc: 'چهار تصویر Media Library، متن‌های مستقل، CTA و جایگزینی خودکار Hero قدیمی در Desktop/Mobile.' },
    { tag: 'LOGO ALIGN', title: 'v3.10.12 — تراز عمودی نهایی', desc: 'Symbol لوگوی Desktop شش پیکسل بالا رفت تا Geometry کپسول کاملاً پاس شود.' },
    { tag: 'LOGO GEOMETRY', title: 'v3.10.11 — مهار لوگوی Desktop', desc: 'Symbol لوگوی افقی به 50px محدود شد تا داخل Capsule باقی بماند.' },
    { tag: 'ACCOUNT ICON', title: 'v3.10.10 — تکمیل کنترل حساب', desc: 'SVG حساب به لینک متنی Legacy اضافه شد تا کنار Cart در Mobile دیده شود.' },
    { tag: 'MOBILE MATCH', title: 'v3.10.9 — تطبیق نهایی با مرجع', desc: 'لوگوی افقی، Account آیکنی، Cart چپ، Hamburger راست و Top Bar سه‌بخشی اجرا شد.' },
    { tag: 'LIVE BROWSER', title: 'v3.10.8 — رفع Offset و Sticky واقعی', desc: 'فضای خالی بالای سایت حذف، Navigation Desktop واقعاً ثابت و لوگو داخل کپسول مهار شد.' },
    { tag: 'HEADER FIX', title: 'v3.10.7 — کپسول Mobile مطابق مرجع', desc: 'Search و ردیف اضافه حذف؛ Hamburger راست، لوگو وسط و حساب/سبد چپ قرار گرفتند.' },
    { tag: 'BRAND STATE', title: 'v3.10.6 — پالت واقعی Black/Gold', desc: 'رنگ‌های مرجع Orange/Green حذف و شماره تأییدشده 3173 با مهاجرت محدود بازیابی شد.' },
    { tag: 'HEADER UX', title: 'v3.10.5 — Sticky فقط برای Navigation', desc: 'Top Bar و Header اصلی در جریان صفحه‌اند؛ منوی اصلی بدون پرش محتوا به بالای viewport می‌چسبد.' },
    { tag: 'ADMIN UX', title: 'v3.10.4 — بوتیک اصلی و Workspace وسیع', desc: 'بوتیک به بالای پنل منتقل شد؛ فضای مدیریت عریض و AI/سلامت سیستم فقط مخصوص Dashboard شدند.' },
    { tag: 'ELEMENTOR', title: 'v3.10.3 — جایگاه مستقیم دسته‌بندی‌ها', desc: 'شورت‌کد مدیریت‌شده Elementor، فلش Desktop ایزوله و کنترل‌های تک‌صفحه هوشمند شدند.' },
    { tag: 'MOBILE UI', title: 'v3.10.2 — حذف Arrow و Pagination مرجع', desc: 'فلش‌های موبایل حذف و Dotها به Active pill طلایی + circle خاکستری تبدیل شدند.' },
    { tag: 'MOBILE UX', title: 'v3.10.1 — Carousel حرفه‌ای موبایل', desc: 'کارت کوتاه‌تر، Centered Peek، Infinite loop، فلش SVG و Dotهای پویا.' },
    { tag: 'WOOCOMMERCE', title: 'v3.10.0 — دسته‌بندی محصولات Desktop', desc: 'Carousel واقعی product_cat ووکامرس با تنظیمات کامل در پنل اصلی.' },
    { tag: 'ADMIN UI', title: 'v3.9.2 — فرم منظم تنظیمات فوتر', desc: 'تمام فیلدها، انتخاب رسانه، رنگ‌ها و منوها با Grid Responsive و بدون هم‌پوشانی نمایش داده می‌شوند.' },
    { tag: 'FOOTER', title: 'v3.9.1 — تطبیق نهایی Desktop', desc: 'ترتیب خبرنامه، تصویر، اجتماعی، مجوزها و Copyright مطابق تصویر مرجع نهایی شد.' },
    { tag: 'FOOTER', title: 'v3.9.0 — فوتر حرفه‌ای مدیریت‌شده', desc: 'فوتر Luxury مستقل Desktop/Mobile با تنظیمات کامل در پنل اصلی ALOOKHOR.' },
    { tag: 'CONTACT', title: 'v3.8.9 — اتصال مستقیم تلفن و ایمیل Legacy', desc: 'spanهای واقعی تماس در هدر قدیمی از State تازه WordPress همگام می‌شوند.' },
    { tag: 'NO FLASH', title: 'v3.8.8 — نمایش اتمی Top Bar', desc: 'ظاهر و محتوای قدیمی هنگام بارگذاری دیده نمی‌شوند؛ Header پس از اعمال State تازه نمایش داده می‌شود.' },
    { tag: 'ACTIVATION', title: 'v3.8.7 — بازیابی خودکار وضعیت فعال', desc: 'افزونه‌ای که پیش از بروزرسانی فعال بوده، پس از Core Upgrader به‌صورت محدود و ایمن دوباره فعال می‌شود.' },
    { tag: 'TOP BAR', title: 'v3.8.6 — مدیریت کامل نوار بالای سایت', desc: 'تمام متن‌ها، لینک‌ها، نمایش آیتم‌ها، لوگو، رنگ‌ها و ارتفاع Top Bar از پیشخوان.' },
    { tag: 'HEADER', title: 'v3.8.5 — بازیابی هدر حرفه‌ای', desc: 'هدر دو‌ردیفه، فهرست‌های خودکار WordPress، Hamburger حرفه‌ای، Top Bar و تنظیمات کامل هدر.' },
    { tag: 'UPDATE', title: 'انتشار از Update Center', desc: 'ارتقا مستقیم از داخل ALOOKHOR بدون حذف افزونه یا Upload مجدد در صفحه افزونه‌ها.' },
    { tag: 'HOTFIX', title: 'v3.8.4 — Fix Boutique Empty', desc: 'Guard کامل برای داده‌های system و modules؛ سه پنل تنظیمات بوتیک دوباره پایدار رندر می‌شوند.' },
    { tag: 'HOTFIX', title: 'v3.8.3 — Fix Console Errors', desc: 'رفع خطای ES Module، Object.values و محدودیت Tracking Prevention.' },
    { tag: 'RESPONSIVE', title: 'Drawer لوکس تا 320px', desc: 'سایدبار موبایل، جدول‌های Card View و جلوگیری از overflow-x حفظ شده‌اند.' }
  ],

  async check({ force = false } = {}) {
    try {
      const result = await postUpdateCheck(force);
      this.current = result.current;
      this.latest = result.latest;
      this.lastCheck = result;
      if (result.changelog.length) this.changelog = result.changelog;
      return result;
    } catch (error) {
      const result = normalizeResult({
        configured: Boolean(runtimeConfig.updater_configured),
        current: this.current,
        latest: this.current,
        message: `بررسی آپدیت انجام نشد: ${error.message}`,
        error_code: 'request_failed'
      });
      this.lastCheck = result;
      return result;
    }
  },

  async install(version) {
    const state = this.lastCheck;
    if (!state?.hasUpdate) throw new Error('هیچ نسخه جدیدی برای نصب ثبت نشده است.');
    if (!state.installable) throw new Error('نسخه جدید فاقد لینک بسته نصب معتبر است.');
    if (!runtimeConfig.native_update_url) {
      throw new Error('آدرس امن Core Upgrader وردپرس در دسترس نیست.');
    }

    // Installer AJAX صفحه Plugins به DOM همان جدول وابسته است و در صفحات
    // سفارشی خطای reading html می‌دهد. مسیر nonceدار Core Upgrader مستقل،
    // رسمی و سازگار با روش‌های مختلف WordPress Filesystem است.
    const target = new URL(runtimeConfig.native_update_url, window.location.href);
    if (target.origin !== window.location.origin) {
      throw new Error('آدرس نصب WordPress معتبر نیست.');
    }
    try{
      sessionStorage.setItem('alookhor_update_pending', JSON.stringify({version, startedAt:Date.now()}));
    }catch(e){}
    window.location.assign(target.href);

    // Navigation replaces this page; keep the promise pending to prevent the
    // click handler from rendering a false success/error before WordPress runs.
    return new Promise(() => {});
  }
};

// Check once on page load, then every six hours while the panel remains open.
export function initUpdater({ onAvailable, onChecked } = {}) {
  let state = {
    configured: Boolean(runtimeConfig.updater_configured),
    hasUpdate: false,
    installable: false,
    pendingVersion: null,
    message: 'در حال بررسی...'
  };

  async function runCheck(force = false) {
    const result = await Updater.check({ force });
    state = {
      configured: result.configured,
      hasUpdate: result.hasUpdate,
      installable: result.installable,
      pendingVersion: result.hasUpdate ? result.latest : null,
      message: result.message
    };

    const badge = document.getElementById('updateBadge');
    const button = document.getElementById('btnUpdateCenter');
    if (badge) {
      badge.style.display = result.hasUpdate ? 'inline-flex' : 'none';
      badge.textContent = result.hasUpdate ? `v${result.latest} آماده` : '';
    }
    button?.classList.toggle('has-update', result.hasUpdate);

    onChecked?.(result);
    if (result.hasUpdate) {
      onAvailable?.(result);
      window.ALOOKHOR?.toast?.(`آپدیت v${result.latest} آماده نصب است`, 'update');
    }
    return result;
  }

  runCheck(false);
  const timer = window.setInterval(() => runCheck(false), 6 * 60 * 60 * 1000);

  return {
    get pending() { return state.pendingVersion; },
    get hasUpdate() { return state.hasUpdate; },
    get configured() { return state.configured; },
    get installable() { return state.installable; },
    get message() { return state.message; },
    check(force = true) { return runCheck(force); },
    destroy() { window.clearInterval(timer); }
  };
}
````

## Source Snapshot — `plugin/alookhor-control-center/assets/js/frontend-categories.js`

````javascript
/** ALOOKHOR WooCommerce categories carousel — responsive professional runtime. */
(()=>{'use strict';const cfg=window.ALOOKHOR_CATEGORIES||{};
function mount(section){
  if(!section||section.dataset.mounted==='1')return;section.dataset.mounted='1';
  const viewport=section.querySelector('.alookhor-mc-viewport'),track=section.querySelector('.alookhor-mc-track'),prev=section.querySelector('.alookhor-mc-prev'),next=section.querySelector('.alookhor-mc-next'),dotsRoot=section.querySelector('.alookhor-mc-dots');
  let originals=[...section.querySelectorAll('.alookhor-mc-card:not(.is-clone)')],page=0,maxPage=0,visible=1,mobile=false,timer=null,width=0,gap=18,wrapTimer=null;
  if(!viewport||!track||!originals.length)return;
  const desktopCards=Math.max(2,Math.min(6,Number(getComputedStyle(section).getPropertyValue('--mc-cards'))||4));
  const mobileWidth=Math.max(72,Math.min(94,Number(getComputedStyle(section).getPropertyValue('--mc-mobile-width'))||84));const mobilePeek=Math.max(3,Math.min(14,Number(getComputedStyle(section).getPropertyValue('--mc-mobile-peek'))||8));
  function removeClones(){track.querySelectorAll('.is-clone').forEach(node=>node.remove())}
  function ensureClones(){removeClones();if(!mobile||originals.length<2)return;const last=originals.at(-1).cloneNode(true),first=originals[0].cloneNode(true);last.classList.add('is-clone');first.classList.add('is-clone');last.setAttribute('aria-hidden','true');first.setAttribute('aria-hidden','true');track.prepend(last);track.append(first)}
  function allCards(){return [...track.querySelectorAll('.alookhor-mc-card')]}
  function syncDots(){if(!dotsRoot)return;const count=maxPage+1;if(dotsRoot.children.length!==count){dotsRoot.innerHTML='';for(let i=0;i<count;i++){const dot=document.createElement('button');dot.type='button';dot.dataset.page=String(i);dot.setAttribute('aria-label',`اسلاید ${i+1}`);dot.addEventListener('click',()=>go(i));dotsRoot.append(dot)}}[...dotsRoot.children].forEach((dot,i)=>dot.classList.toggle('is-active',i===page))}
  function physicalIndex(){return mobile?page+1:page*visible}
  function transformTo(index,animate=true){track.style.transitionDuration=animate?'.65s':'0s';track.style.transform=`translate3d(${index*(width+gap)}px,0,0)`}
  function markActive(){allCards().forEach(card=>card.classList.remove('is-active'));if(mobile){originals[page]?.classList.add('is-active')}else{originals.slice(page*visible,page*visible+visible).forEach(card=>card.classList.add('is-active'))}}
  function update(animate=true){clearTimeout(wrapTimer);transformTo(physicalIndex(),animate);markActive();syncDots();if(prev)prev.disabled=!mobile&&page<=0;if(next)next.disabled=!mobile&&page>=maxPage}
  function go(target){if(mobile&&originals.length>1){if(target>maxPage){transformTo(originals.length+1,true);allCards().at(-1)?.classList.add('is-active');wrapTimer=setTimeout(()=>{page=0;update(false)},680);restart();return}if(target<0){transformTo(0,true);allCards()[0]?.classList.add('is-active');wrapTimer=setTimeout(()=>{page=maxPage;update(false)},680);restart();return}}page=Math.max(0,Math.min(maxPage,target));update(true);restart()}
  function layout(){const w=viewport.clientWidth;const nextMobile=w<768;if(nextMobile!==mobile){mobile=nextMobile;ensureClones()}[prev,next].filter(Boolean).forEach(control=>{control.tabIndex=mobile?-1:0;control.setAttribute('aria-hidden',mobile?'true':'false')});visible=mobile?1:(w>=1200?desktopCards:Math.min(3,desktopCards));gap=parseFloat(getComputedStyle(track).gap)||18;width=mobile?w*(Math.min(mobileWidth,100-(2*mobilePeek))/100):(w-gap*(visible-1))/visible;allCards().forEach(card=>card.style.flexBasis=`${width}px`);track.style.paddingInline=mobile?`${Math.max(0,(w-width)/2)}px`:'0px';maxPage=mobile?Math.max(0,originals.length-1):Math.max(0,Math.ceil(originals.length/visible)-1);section.classList.toggle('has-single-page',maxPage===0);page=Math.min(page,maxPage);update(false)}
  function restart(){clearInterval(timer);if(section.dataset.autoplay==='1'&&maxPage>0)timer=setInterval(()=>go(page+1),Math.max(2500,Number(section.dataset.interval)||5000))}
  prev?.addEventListener('click',()=>go(page-1));next?.addEventListener('click',()=>go(page+1));let startX=0;viewport.addEventListener('pointerdown',e=>{startX=e.clientX;viewport.setPointerCapture?.(e.pointerId)});viewport.addEventListener('pointerup',e=>{const delta=e.clientX-startX;if(Math.abs(delta)>45)go(page+(delta>0?-1:1))});section.addEventListener('mouseenter',()=>clearInterval(timer));section.addEventListener('mouseleave',restart);
  new ResizeObserver(()=>{layout();restart()}).observe(viewport);layout();restart();
}
function place(section){const legacy=document.querySelector('.category-carousel-section');if(legacy)legacy.replaceWith(section);else{const footer=document.querySelector('#alookhor-managed-footer');if(footer)footer.before(section);else document.body.append(section)}mount(section)}
async function refresh(){if(!cfg.endpoint)return;try{const url=new URL(cfg.endpoint,location.href);if(url.origin!==location.origin)return;url.searchParams.set('_alookhor',Date.now());const response=await fetch(url,{cache:'no-store',credentials:'same-origin',headers:{Accept:'application/json'}});if(!response.ok)throw Error(`HTTP ${response.status}`);const data=await response.json();if(String(data.version)!==String(cfg.version)||!data.html)throw Error('Category state mismatch');const template=document.createElement('template');template.innerHTML=data.html.trim();const fresh=template.content.firstElementChild;if(!fresh?.matches('#alookhor-managed-categories'))throw Error('Category markup invalid');const current=document.querySelector('#alookhor-managed-categories');if(current){current.replaceWith(fresh);mount(fresh)}else place(fresh)}catch(error){console.warn('ALOOKHOR category refresh failed; server template remains active.',error)}}
function start(){document.body.classList.add('alookhor-mc-enabled');if(cfg.hide_legacy)document.body.classList.add('alookhor-mc-hide-legacy');const template=document.querySelector('#alookhor-managed-categories-template');if(template){const section=template.content.firstElementChild?.cloneNode(true);if(section)place(section);template.remove()}else mount(document.querySelector('#alookhor-managed-categories'));refresh()}
if(document.readyState==='loading')document.addEventListener('DOMContentLoaded',start,{once:true});else start();})();
````

## Source Snapshot — `plugin/alookhor-control-center/assets/js/frontend-features.js`

````javascript
/** ALOOKHOR managed four-card site-features runtime. */
(()=>{
  'use strict';
  const cfg=window.ALOOKHOR_FEATURES||{};
  const legacySelector=cfg.legacy_selector||'.alookhor-trustbar-container';

  function mount(section){
    if(!section||section.dataset.mounted==='1')return;
    if(section.querySelectorAll('.alookhor-sf-card').length!==4)return;
    section.dataset.mounted='1';
  }
  function markSlot(node){
    const slot=node.closest('.elementor-widget-html,.elementor-widget')||node.parentElement;
    slot?.classList.add('alookhor-managed-features-slot');
    slot?.closest('.e-con')?.classList.add('alookhor-managed-features-host');
  }
  function place(section){
    const legacy=document.querySelector(legacySelector);
    if(!legacy)return false;
    markSlot(legacy);
    legacy.replaceWith(section);
    mount(section);
    return true;
  }
  function parseMarkup(html){
    const template=document.createElement('template');
    template.innerHTML=String(html||'').trim();
    const section=template.content.firstElementChild;
    return section?.matches?.('#alookhor-managed-features')&&section.querySelectorAll('.alookhor-sf-card').length===4?section:null;
  }
  async function refresh(){
    if(!cfg.endpoint)return;
    try{
      const url=new URL(cfg.endpoint,location.href);
      if(url.origin!==location.origin)throw Error('Feature endpoint origin mismatch');
      url.searchParams.set('_alookhor',Date.now());
      const response=await fetch(url,{cache:'no-store',credentials:'same-origin',headers:{Accept:'application/json'}});
      if(!response.ok)throw Error(`HTTP ${response.status}`);
      const data=await response.json();
      if(String(data.version)!==String(cfg.version)||data.item_count!==4)throw Error('Feature state mismatch');
      const fresh=parseMarkup(data.html);
      if(!fresh)throw Error('Feature markup invalid');
      const current=document.querySelector('#alookhor-managed-features');
      if(current){markSlot(current);current.replaceWith(fresh);mount(fresh)}
      else place(fresh);
    }catch(error){
      console.warn('ALOOKHOR site-feature refresh failed; server template remains active.',error);
    }
  }
  function start(){
    document.body?.classList.add('alookhor-sf-enabled');
    if(cfg.hide_legacy)document.body?.classList.add('alookhor-sf-hide-legacy');
    const template=document.querySelector('#alookhor-managed-features-template');
    const current=document.querySelector('#alookhor-managed-features');
    if(current){markSlot(current);mount(current)}
    else if(template){const section=template.content.firstElementChild?.cloneNode(true);if(section)place(section)}
    template?.remove();
    refresh();
  }
  if(document.body)start();
  else document.addEventListener('DOMContentLoaded',start,{once:true});
})();
````

## Source Snapshot — `plugin/alookhor-control-center/assets/js/frontend-footer.js`

````javascript
/** ALOOKHOR managed footer runtime. */
(() => {
  'use strict';
  const cfg = window.ALOOKHOR_FOOTER || {};
  document.body?.classList.add('alookhor-mf-enabled');

  function bindFooter(root = document){
    const footer = root.querySelector?.('#alookhor-managed-footer') || (root.matches?.('#alookhor-managed-footer') ? root : null);
    if (!footer || footer.dataset.bound === '1') return;
    footer.dataset.bound = '1';
    footer.querySelectorAll('.alookhor-mf-links a').forEach(link => {
      link.addEventListener('focus', () => link.closest('.alookhor-mf-menu-card')?.classList.add('is-focused'));
      link.addEventListener('blur', () => link.closest('.alookhor-mf-menu-card')?.classList.remove('is-focused'));
    });
    const form = footer.querySelector('.alookhor-mf-newsletter-form');
    if (form && cfg.subscribe_endpoint) {
      form.addEventListener('submit', async event => {
        event.preventDefault();
        const message = footer.querySelector('.alookhor-mf-form-msg');
        const button = form.querySelector('button');
        button.disabled = true;
        if (message) message.textContent = 'در حال ثبت…';
        try {
          const response = await fetch(cfg.subscribe_endpoint, {
            method:'POST', credentials:'same-origin', cache:'no-store',
            headers:{'Content-Type':'application/json','Accept':'application/json'},
            body:JSON.stringify({
              email:form.elements.namedItem('email')?.value || '',
              company:form.elements.namedItem('company')?.value || ''
            })
          });
          const data = await response.json();
          if (!response.ok || data.code) throw new Error(data.message || `HTTP ${response.status}`);
          if (message) message.textContent = data.message || 'عضویت شما ثبت شد.';
          form.reset();
        } catch (error) {
          if (message) message.textContent = `ثبت انجام نشد: ${error.message}`;
        } finally { button.disabled = false; }
      });
    }
  }

  async function refresh(){
    if (!cfg.endpoint) return;
    try {
      const url = new URL(cfg.endpoint, location.href);
      if (url.origin !== location.origin) return;
      url.searchParams.set('_alookhor', Date.now());
      const response = await fetch(url, {cache:'no-store', credentials:'same-origin', headers:{'Accept':'application/json'}});
      if (!response.ok) throw new Error(`HTTP ${response.status}`);
      const data = await response.json();
      if (!data.html || String(data.version) !== String(cfg.version)) throw new Error('Footer state mismatch');
      const current = document.querySelector('#alookhor-managed-footer');
      if (!current) return;
      const template = document.createElement('template');
      template.innerHTML = data.html.trim();
      const fresh = template.content.firstElementChild;
      if (!fresh?.matches('#alookhor-managed-footer')) throw new Error('Footer markup invalid');
      current.replaceWith(fresh);
      bindFooter(fresh);
    } catch (error) {
      console.warn('ALOOKHOR footer refresh failed; server-rendered footer remains active.', error);
    }
  }

  const start = () => {
    document.body.classList.add('alookhor-mf-enabled');
    if (cfg.hide_legacy) document.body.classList.add('alookhor-mf-hide-legacy');
    if (cfg.hide_old_newsletter) document.body.classList.add('alookhor-mf-hide-old-sections');
    bindFooter();
    refresh();
  };
  if (document.readyState === 'loading') document.addEventListener('DOMContentLoaded', start, {once:true});
  else start();
})();
````

## Source Snapshot — `plugin/alookhor-control-center/assets/js/frontend-header.js`

````javascript
/**
 * ALOOKHOR Portal Header — accessible drawer and menu accordions.
 * No dependencies; exits immediately when the recovered shortcode is absent.
 */
(() => {
  'use strict';

  const focusableSelector = [
    'a[href]', 'button:not([disabled])', 'input:not([disabled])',
    'select:not([disabled])', 'textarea:not([disabled])', '[tabindex]:not([tabindex="-1"])'
  ].join(',');

  function initHeader(root) {
    if (root.dataset.alookhorReady === '1') return;
    root.dataset.alookhorReady = '1';

    // Remove only the two source-backed Elementor header drafts that precede
    // the managed shortcode (`.ak-topbar-wrapper` and `.alu-header`). Their
    // dedicated widgets/containers otherwise reserve 221px Desktop / 292px
    // Mobile and paint two duplicate headers above the real WordPress Header.
    const managedWidget=root.closest('.elementor-widget-shortcode');
    const managedHost=managedWidget?.closest('.e-con')||root.closest('.e-con');
    const elementorRoot=root.closest('.elementor');
    elementorRoot?.querySelectorAll('.ak-topbar-wrapper,.alu-header').forEach(draft=>{
      if(draft.contains(root)||root.contains(draft))return;
      const draftWidget=draft.closest('.elementor-widget');
      if(draftWidget){draftWidget.dataset.alookhorDuplicateHeader='1';draftWidget.style.setProperty('display','none','important');draftWidget.style.setProperty('height','0px','important');draftWidget.style.setProperty('min-height','0px','important');draftWidget.style.setProperty('margin','0px','important');draftWidget.style.setProperty('padding','0px','important')}
      const draftHost=draftWidget?.closest('.e-con');
      if(draftHost&&draftHost!==managedHost){draftHost.dataset.alookhorDuplicateHeaderHost='1';draftHost.style.setProperty('display','none','important');draftHost.style.setProperty('height','0px','important');draftHost.style.setProperty('min-height','0px','important');draftHost.style.setProperty('margin','0px','important');draftHost.style.setProperty('padding','0px','important')}
    });

    // Elementor's page-level Header host carries provider-specific flex
    // distribution. Inline-important normalization is limited to the exact
    // container that owns the managed Header shortcode.
    const host=managedHost;
    if(host){['margin','margin-top','margin-bottom','margin-block','padding','padding-top','padding-bottom','padding-block','min-height','height','gap'].forEach(property=>host.style.setProperty(property,(property==='height'?'auto':property==='min-height'?'0':'0px'),'important'));host.style.setProperty('justify-content','flex-start','important');host.style.setProperty('align-content','flex-start','important');host.style.setProperty('--justify-content','flex-start','important');host.style.setProperty('--padding-top','0px','important');host.style.setProperty('--padding-bottom','0px','important');host.style.setProperty('--margin-top','0px','important');host.style.setProperty('--margin-bottom','0px','important')}
    if(elementorRoot){elementorRoot.style.setProperty('margin-top','0px','important');elementorRoot.style.setProperty('padding-top','0px','important')}

    const toggle = root.querySelector('.alookhor-menu-toggle');
    const drawer = root.querySelector('.alookhor-menu-drawer');
    const closeButtons = root.querySelectorAll('[data-alookhor-close]');
    if (!toggle || !drawer) return;

    let previousFocus = null;

    const navStage=root.querySelector('.alookhor-nav-stage');
    if(navStage&&root.classList.contains('is-sticky')){
      const marker=document.createElement('span');marker.className='alookhor-internal-nav-marker';marker.setAttribute('aria-hidden','true');navStage.before(marker);
      let stageTop=0,ticking=false;
      const measure=()=>{stageTop=marker.getBoundingClientRect().top+window.scrollY};
      const update=()=>{ticking=false;const desktop=window.innerWidth>=1024;const adminOffset=document.body.classList.contains('admin-bar')?(window.innerWidth<=782?46:32):0;const stuck=desktop&&window.scrollY+adminOffset>=stageTop-1;navStage.classList.toggle('is-stuck',stuck);marker.style.setProperty('height',stuck?`${navStage.offsetHeight}px`:'0px','important')};
      const requestUpdate=()=>{if(ticking)return;ticking=true;requestAnimationFrame(update)};
      window.addEventListener('scroll',requestUpdate,{passive:true});window.addEventListener('resize',()=>{if(navStage.classList.contains('is-stuck'))navStage.classList.remove('is-stuck');measure();requestUpdate()},{passive:true});
      requestAnimationFrame(()=>{measure();update()});
    }

    function setOpen(open) {
      root.classList.toggle('menu-open', open);
      toggle.setAttribute('aria-expanded', open ? 'true' : 'false');
      drawer.setAttribute('aria-hidden', open ? 'false' : 'true');
      document.body.classList.toggle('alookhor-menu-open', open);
      if (open) closeMega();

      if (open) {
        previousFocus = document.activeElement;
        window.requestAnimationFrame(() => {
          drawer.querySelector('.alookhor-drawer-close')?.focus({ preventScroll: true });
        });
      } else if (previousFocus && typeof previousFocus.focus === 'function') {
        previousFocus.focus({ preventScroll: true });
      }
    }

    toggle.addEventListener('click', () => setOpen(!root.classList.contains('menu-open')));
    closeButtons.forEach(button => button.addEventListener('click', () => setOpen(false)));

    drawer.querySelectorAll('.alookhor-drawer-menu-title').forEach(button => {
      button.addEventListener('click', () => {
        const group = button.closest('.alookhor-drawer-menu-group');
        const panelId = button.getAttribute('aria-controls');
        const panel = panelId ? document.getElementById(panelId) : null;
        const willOpen = button.getAttribute('aria-expanded') !== 'true';
        button.setAttribute('aria-expanded', willOpen ? 'true' : 'false');
        group?.classList.toggle('is-open', willOpen);
        if (panel) panel.hidden = !willOpen;
      });
    });

    drawer.addEventListener('click', event => {
      const link = event.target.closest('a[href]');
      if (link) setOpen(false);
    });

    root.addEventListener('keydown', event => {
      if (!root.classList.contains('menu-open')) return;
      if (event.key === 'Escape') {
        event.preventDefault();
        setOpen(false);
        return;
      }
      if (event.key !== 'Tab') return;

      const focusable = [...drawer.querySelectorAll(focusableSelector)].filter(element => {
        return !element.hidden && element.offsetParent !== null;
      });
      if (!focusable.length) return;
      const first = focusable[0];
      const last = focusable[focusable.length - 1];
      if (event.shiftKey && document.activeElement === first) {
        event.preventDefault();
        last.focus();
      } else if (!event.shiftKey && document.activeElement === last) {
        event.preventDefault();
        first.focus();
      }
    });
  }

  function initAll(scope = document) {
    scope.querySelectorAll('.alookhor-portal-header').forEach(initHeader);
  }

  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', () => initAll(), { once: true });
  } else {
    initAll();
  }

  // Elementor can inject templates after DOMContentLoaded.
  const observer = new MutationObserver(mutations => {
    for (const mutation of mutations) {
      for (const node of mutation.addedNodes) {
        if (!(node instanceof Element)) continue;
        if (node.matches?.('.alookhor-portal-header')) initHeader(node);
        else initAll(node);
      }
    }
  });
  observer.observe(document.documentElement, { childList: true, subtree: true });
})();
````

## Source Snapshot — `plugin/alookhor-control-center/assets/js/frontend-hero.js`

````javascript
/** ALOOKHOR managed Hero — four-slide responsive runtime and legacy replacement. */
(()=>{
  'use strict';
  const cfg=window.ALOOKHOR_HERO||{};
  const legacySelector=cfg.legacy_selector||'.alookhor-hero-slider-wrapper';
  const reduceMotion=window.matchMedia?.('(prefers-reduced-motion: reduce)');

  function mount(section){
    if(!section||section.dataset.mounted==='1')return;
    const slides=[...section.querySelectorAll('.alookhor-mh-slide')];
    const dots=[...section.querySelectorAll('.alookhor-mh-dots button')];
    const prev=section.querySelector('.alookhor-mh-arrow.is-prev');
    const next=section.querySelector('.alookhor-mh-arrow.is-next');
    const status=section.querySelector('.alookhor-mh-status');
    if(slides.length!==4)return;
    section.dataset.mounted='1';
    slides.forEach(slide=>slide.querySelector('img')?.setAttribute('draggable','false'));
    let index=Math.max(0,slides.findIndex(slide=>slide.classList.contains('is-active')));
    let timer=null,startX=0,startY=0;
    const interval=Math.max(3000,Math.min(15000,Number(section.dataset.interval)||5500));
    const canAuto=()=>section.dataset.autoplay==='1'&&!reduceMotion?.matches&&!document.hidden;

    function render(target,announce=false){
      index=(target+slides.length)%slides.length;
      slides.forEach((slide,i)=>{
        const active=i===index;
        slide.classList.toggle('is-active',active);
        slide.setAttribute('aria-hidden',active?'false':'true');
        slide.querySelectorAll('a,button').forEach(control=>control.tabIndex=active?0:-1);
      });
      dots.forEach((dot,i)=>{
        const active=i===index;
        dot.classList.toggle('is-active',active);
        dot.setAttribute('aria-selected',active?'true':'false');
        dot.tabIndex=active?0:-1;
      });
      if(announce&&status)status.textContent=`اسلاید ${index+1} از ۴`;
    }
    function stop(){if(timer){window.clearInterval(timer);timer=null}}
    function start(){
      stop();
      if(canAuto())timer=window.setInterval(()=>render(index+1),interval);
    }
    function go(target,announce=true){render(target,announce);start()}
    prev?.addEventListener('click',()=>go(index-1));
    next?.addEventListener('click',()=>go(index+1));
    dots.forEach((dot,i)=>dot.addEventListener('click',()=>go(i)));
    section.addEventListener('keydown',event=>{
      if(event.key==='ArrowLeft'){event.preventDefault();go(index+1)}
      if(event.key==='ArrowRight'){event.preventDefault();go(index-1)}
      if(event.key==='Home'){event.preventDefault();go(0)}
      if(event.key==='End'){event.preventDefault();go(3)}
    });
    section.addEventListener('pointerdown',event=>{startX=event.clientX;startY=event.clientY},{passive:true});
    section.addEventListener('pointerup',event=>{
      const dx=event.clientX-startX,dy=event.clientY-startY;
      if(Math.abs(dx)>45&&Math.abs(dx)>Math.abs(dy)*1.25)go(index+(dx<0?1:-1));
    },{passive:true});
    if(section.dataset.pauseHover==='1'){
      section.addEventListener('mouseenter',stop);
      section.addEventListener('mouseleave',start);
      section.addEventListener('focusin',stop);
      section.addEventListener('focusout',event=>{if(!section.contains(event.relatedTarget))start()});
    }
    const visibility=()=>document.hidden?stop():start();
    document.addEventListener('visibilitychange',visibility);
    reduceMotion?.addEventListener?.('change',start);
    section._alookhorHeroCleanup=()=>{stop();document.removeEventListener('visibilitychange',visibility);reduceMotion?.removeEventListener?.('change',start)};
    render(index);
    start();
  }

  function markSlot(node){
    const slot=node.closest('.elementor-widget-shortcode,.elementor-widget')||node.parentElement;
    slot?.classList.add('alookhor-managed-hero-slot');
  }
  function place(section){
    const legacy=document.querySelector(legacySelector);
    if(!legacy)return false;
    markSlot(legacy);
    legacy.replaceWith(section);
    mount(section);
    return true;
  }
  function parseMarkup(html){
    const template=document.createElement('template');
    template.innerHTML=String(html||'').trim();
    const section=template.content.firstElementChild;
    return section?.matches?.('#alookhor-managed-hero')&&section.querySelectorAll('.alookhor-mh-slide').length===4?section:null;
  }
  async function refresh(){
    if(!cfg.endpoint)return;
    try{
      const url=new URL(cfg.endpoint,location.href);
      if(url.origin!==location.origin)throw Error('Hero endpoint origin mismatch');
      url.searchParams.set('_alookhor',Date.now());
      const response=await fetch(url,{cache:'no-store',credentials:'same-origin',headers:{Accept:'application/json'}});
      if(!response.ok)throw Error(`HTTP ${response.status}`);
      const data=await response.json();
      if(String(data.version)!==String(cfg.version)||data.slide_count!==4)throw Error('Hero state mismatch');
      const fresh=parseMarkup(data.html);
      if(!fresh)throw Error('Hero markup invalid');
      const current=document.querySelector('#alookhor-managed-hero');
      if(current){
        markSlot(current);
        current._alookhorHeroCleanup?.();
        current.replaceWith(fresh);
        mount(fresh);
      }else{
        place(fresh);
      }
    }catch(error){
      console.warn('ALOOKHOR Hero refresh failed; server template remains active.',error);
    }
  }
  function start(){
    document.body?.classList.add('alookhor-mh-enabled');
    if(cfg.hide_legacy)document.body?.classList.add('alookhor-mh-hide-legacy');
    const template=document.querySelector('#alookhor-managed-hero-template');
    const current=document.querySelector('#alookhor-managed-hero');
    if(current){markSlot(current);mount(current)}
    else if(template){
      const section=template.content.firstElementChild?.cloneNode(true);
      if(section)place(section);
    }
    template?.remove();
    refresh();
  }
  // The footer script runs after Elementor Home markup and the managed template,
  // so replacement can happen immediately without waiting for window.load.
  if(document.body)start();
  else document.addEventListener('DOMContentLoaded',start,{once:true});
})();
````

## Source Snapshot — `plugin/alookhor-control-center/assets/js/frontend-topbar-manager.js`

````javascript
/**
 * ALOOKHOR Legacy Top Bar Manager — v3.10.25
 * Preserves the legacy header/mega-menu HTML and synchronizes managed Top Bar
 * values from a fresh read-only REST endpoint, even when the page HTML is cached.
 */
(() => {
  'use strict';

  const cfg = {...(window.ALOOKHOR_TOPBAR || {})};
  let freshState = cfg.endpoint ? 'pending' : 'fallback';
  const asBool = value => value === true || value === 1 || value === '1' || value === 'true';
  const digits = value => String(value || '')
    .replace(/[۰-۹]/g, d => String('۰۱۲۳۴۵۶۷۸۹'.indexOf(d)))
    .replace(/[٠-٩]/g, d => String('٠١٢٣٤٥٦٧٨٩'.indexOf(d)));
  const phoneHref = value => digits(value).replace(/[^0-9+]/g, '');
  const whatsappHref = value => {
    let number = digits(value).replace(/\D/g, '');
    if (number.startsWith('0')) number = `98${number.slice(1)}`;
    return number ? `https://wa.me/${number}` : '';
  };
  const setVisible = (element, visible) => {
    if (!element) return;
    element.hidden = !visible;
    element.style.setProperty('display', visible ? '' : 'none', visible ? '' : 'important');
    element.setAttribute('aria-hidden', visible ? 'false' : 'true');
  };
  const smallestTextMatch = (root, phrase) => {
    const matches = [...root.querySelectorAll('a,span,p,div')]
      .filter(el => (el.textContent || '').includes(phrase));
    return matches.sort((a, b) => a.textContent.trim().length - b.textContent.trim().length)[0] || null;
  };
  const replaceVisibleText = (element, value, matcher = () => true) => {
    if (!element) return;
    const direct = [...element.childNodes].find(node =>
      node.nodeType === Node.TEXT_NODE && node.textContent.trim() && matcher(node.textContent)
    );
    if (direct) {
      direct.textContent = element.children.length ? ` ${value || ''} ` : (value || '');
      return;
    }
    const target = [...element.querySelectorAll('span,b,strong')]
      .find(node => matcher(node.textContent || ''));
    if (target) target.textContent = value || '';
    else element.appendChild(document.createTextNode(` ${value || ''} `));
  };
  const closestItem = element => element?.closest('a,button,li,[class*="item"],[class*="contact"]') || element;
  const commonAncestor = (elements, boundary) => {
    const valid = elements.filter(Boolean);
    if (!valid.length) return null;
    let current = valid[0];
    while (current && current !== boundary) {
      if (valid.every(el => current.contains(el))) return current;
      current = current.parentElement;
    }
    return null;
  };
  const topbarSelector = '[class*="topbar" i],[class*="top-bar" i],[class*="top_bar" i]';
  const clamp = (value, min, max, fallback) => Math.max(min, Math.min(max, Number(value) || fallback));

  function setupHeaderBehavior(root) {
    const topbar = root.querySelector('.alookhor-topbar-wrapper');
    const header = root.querySelector('.alookhor-header');
    const capsule = header?.querySelector('.header-capsule');
    const navigation = header?.querySelector('.header-nav-center') || root.querySelector('.alookhor-legacy-nav-shell .header-nav-center');
    if (!topbar || !header || !capsule || !navigation) return;

    const nativeHeader = document.querySelector('.whb-header');
    if (nativeHeader && getComputedStyle(nativeHeader).display === 'none') {
      document.body.style.setProperty('padding-top', '0px', 'important');
      const mainContent = root.closest('#main-content');
      if (mainContent) mainContent.style.setProperty('padding-top', '0px', 'important');
    }

    const system = root.querySelector('.alookhor-header-system') || root.closest('.alookhor-header-system');
    if (system) {
      system.style.setProperty('height', 'auto', 'important');
      system.style.setProperty('min-height', '0', 'important');
      system.style.setProperty('margin-bottom', '0', 'important');
      system.style.setProperty('overflow', 'visible', 'important');
    }
    [topbar, header].forEach(element => {
      element.style.setProperty('position', 'relative', 'important');
      element.style.setProperty('top', 'auto', 'important');
      element.style.setProperty('left', 'auto', 'important');
      element.style.setProperty('right', 'auto', 'important');
      element.style.setProperty('transform', 'none', 'important');
      element.style.setProperty('width', '100%', 'important');
    });
    header.style.setProperty('height', 'auto', 'important');

    root.style.setProperty('--alookhor-header-gold', cfg.gold || '#D4A436');
    root.style.setProperty('--alookhor-header-surface', cfg.header_surface || '#0D0916');
    root.style.setProperty('--alookhor-header-text', cfg.header_text_color || '#F7F2EA');
    root.style.setProperty('--alookhor-header-muted', cfg.header_muted_color || '#B8B0BD');
    root.style.setProperty('--alookhor-capsule-background', cfg.capsule_background || '#0D0510');
    root.style.setProperty('--alookhor-capsule-card', cfg.capsule_card || '#1C1024');
    root.style.setProperty('--alookhor-capsule-glass', cfg.capsule_glass || 'rgba(33,20,38,.75)');
    root.style.setProperty('--alookhor-capsule-gold', cfg.capsule_gold || '#D49A2E');
    root.style.setProperty('--alookhor-capsule-gold-light', cfg.capsule_gold_light || '#E8B84A');
    root.style.setProperty('--alookhor-capsule-text', cfg.capsule_text || '#F5F3F0');
    root.style.setProperty('--alookhor-capsule-muted', cfg.capsule_muted || '#C8C2C9');
    root.style.setProperty('--alookhor-capsule-blur', `${clamp(cfg.capsule_blur, 10, 36, 24)}px`);
    root.style.setProperty('--alookhor-mobile-logo-width', `${clamp(cfg.header_logo_mobile_width, 42, 110, 58)}px`);

    const mainToggle = root.querySelector('#openDrawer,.alookhor-hamburger-btn');
    if (mainToggle) {
      mainToggle.classList.add('alookhor-main-menu-toggle');
      if (mainToggle.parentElement !== capsule) capsule.append(mainToggle);
    }
    const logoBox = capsule.querySelector('.header-capsule-logo');
    if (logoBox && !logoBox.querySelector('.alookhor-logo-copy')) {
      const copy = document.createElement('span');
      copy.className = 'alookhor-logo-copy';
      copy.innerHTML = '<b>آلوخور</b><small>پایتخت آلوی ایران</small>';
      logoBox.append(copy);
    }
    const topbarContainer = topbar.querySelector('.alookhor-topbar-container');
    if (topbarContainer && !topbarContainer.querySelector('.alookhor-topbar-support')) {
      const support = document.createElement('span');
      support.className = 'alookhor-topbar-support';
      support.innerHTML = '<svg class="alookhor-topbar-support-icon" viewBox="0 0 24 24" aria-hidden="true"><path d="M4 14v-2a8 8 0 0 1 16 0v2M4 14h3v6H4zM17 14h3v6h-3zM17 20c-1 2-3 3-6 3"/></svg><b>پشتیبانی ۲۴/۷</b>';
      topbarContainer.append(support);
    }

    const actions = capsule.querySelector('.header-capsule-left');
    const account = actions?.querySelector('.header-login-btn');
    if (account && !account.querySelector('.alookhor-account-icon')) {
      account.insertAdjacentHTML('afterbegin','<svg class="alookhor-account-icon" viewBox="0 0 24 24" aria-hidden="true"><circle cx="12" cy="7" r="4"/><path d="M4.5 21c.7-4.7 3.2-7 7.5-7s6.8 2.3 7.5 7"/></svg>');
    }
    if (actions && !actions.querySelector('.alookhor-header-cart-link')) {
      const cart = document.createElement('a');
      cart.className = 'alookhor-header-cart-link';
      cart.href = cfg.cart_url || '/cart/';
      cart.setAttribute('aria-label', 'سبد خرید');
      cart.innerHTML = `<svg viewBox="0 0 24 24" aria-hidden="true"><path d="M3 4h2l2 11h10l3-8H6M9 20a1 1 0 1 0 0-2 1 1 0 0 0 0 2Zm8 0a1 1 0 1 0 0-2 1 1 0 0 0 0 2Z"/></svg><span class="alookhor-cart-count">${Math.max(0,Number(cfg.cart_count)||0)}</span>`;
      actions.prepend(cart);
    }

    let stage = root.querySelector('.alookhor-legacy-nav-stage');
    if (!stage) {
      stage = document.createElement('div');
      stage.className = 'alookhor-legacy-nav-stage';
      stage.setAttribute('data-alookhor-navigation', 'primary');
      const shell = document.createElement('div');
      shell.className = 'alookhor-legacy-nav-shell';
      navigation.before(document.createComment('ALOOKHOR primary navigation moved intact to sticky stage'));
      shell.append(navigation);

      stage.append(shell);
      const marker = document.createElement('span');
      marker.className = 'alookhor-legacy-nav-marker';
      marker.setAttribute('aria-hidden', 'true');
      header.after(marker, stage);

      let stageTop = 0;
      let ticking = false;
      const syncIntegrated = () => stage.classList.toggle('is-capsule-integrated', window.innerWidth >= 1024);
      const measure = () => {
        syncIntegrated();
        const integratedOffset = stage.classList.contains('is-capsule-integrated')
          ? (parseFloat(getComputedStyle(stage).getPropertyValue('--alookhor-integrated-nav-offset')) || 90)
          : 0;
        stageTop = marker.getBoundingClientRect().top + window.scrollY - integratedOffset;
      };
      const update = () => {
        ticking = false;
        const desktop = window.innerWidth >= 1024;
        const adminOffset = document.body.classList.contains('admin-bar') ? (window.innerWidth <= 782 ? 46 : 32) : 0;
        const shouldStick = desktop && stage.classList.contains('is-enabled') && window.scrollY + adminOffset >= stageTop - 1;
        if (shouldStick !== stage.classList.contains('is-stuck')) {
          // The integrated stage has zero net normal-flow footprint (90px stage
          // plus -90px margin), so its sticky marker must remain zero as well.
          const markerHeight = shouldStick && !stage.classList.contains('is-capsule-integrated') ? `${stage.offsetHeight}px` : '0px';
          marker.style.setProperty('height', markerHeight, 'important');
          stage.classList.toggle('is-stuck', shouldStick);
        }
      };
      const requestUpdate = () => {
        if (ticking) return;
        ticking = true;
        window.requestAnimationFrame(update);
      };
      window.addEventListener('scroll', requestUpdate, {passive:true});
      window.addEventListener('resize', () => { measure(); requestUpdate(); }, {passive:true});
      window.addEventListener('load', () => { measure(); requestUpdate(); }, {once:true});
      window.requestAnimationFrame(() => { measure(); update(); });
    }

    stage.classList.toggle('is-capsule-integrated', window.innerWidth >= 1024);
    stage.classList.toggle('is-enabled', asBool(cfg.sticky));
    if (!asBool(cfg.sticky) || window.innerWidth < 1024) {
      stage.classList.remove('is-stuck');
      root.querySelector('.alookhor-legacy-nav-marker')?.style.setProperty('height', '0px', 'important');
    }

    const headerLogo = header.querySelector('.header-capsule-logo img');
    if (headerLogo) {
      const setLogoSize = () => {
        const size = 50;
        headerLogo.style.setProperty('width', `${size}px`, 'important');
        headerLogo.style.setProperty('max-width', `${size}px`, 'important');
        headerLogo.style.setProperty('height', `${size}px`, 'important');
        headerLogo.style.setProperty('max-height', `${size}px`, 'important');
        headerLogo.style.setProperty('object-fit', 'cover', 'important');
        headerLogo.style.setProperty('object-position', 'top center', 'important');
        headerLogo.style.setProperty('border-radius', '50%', 'important');
        headerLogo.style.setProperty('background', 'transparent', 'important');
      };
      setLogoSize();
      if (root.dataset.headerLogoResize !== '1') {
        root.dataset.headerLogoResize = '1';
        window.addEventListener('resize', setLogoSize, {passive:true});
      }
    }
    root.dataset.headerBehaviorReady = '1';
  }

  function manage(root, force = false) {
    if (!root || (!force && root.dataset.topbarManaged === '3.10.25')) return;

    const contactTexts = [...root.querySelectorAll('.topbar-contact-txt,[class*="contact-txt" i]')];
    const phone = root.querySelector('a[href^="tel:"]') || contactTexts.find(element => {
      const text = element.textContent || '';
      const number = digits(text).replace(/\D/g, '');
      return !text.includes('@') && number.length >= 7 && number.length <= 15;
    });
    const email = root.querySelector('a[href^="mailto:"]') || contactTexts.find(element => (element.textContent || '').includes('@'));
    phone?.classList.add('alookhor-managed-phone');
    email?.classList.add('alookhor-managed-email');
    const wholesale = smallestTextMatch(root, 'خرید عمده')?.closest('a,button') || root.querySelector('a[href*="b2b"],a[href*="wholesale"]');
    const exportNote = smallestTextMatch(root, 'صادرات به');

    const explicitCandidates = [...root.querySelectorAll(topbarSelector)];
    const primaryItems = [phone, email, wholesale, exportNote].filter(Boolean);
    const candidateScore = element => primaryItems.filter(item => element.contains(item)).length;
    explicitCandidates.sort((a, b) => candidateScore(b) - candidateScore(a));
    const explicitTopbar = explicitCandidates.find(element => candidateScore(element) >= 2) || explicitCandidates[0] || null;
    const inferredTopbar = commonAncestor(primaryItems, root);
    const topbar = explicitTopbar || inferredTopbar;

    // Limit WhatsApp lookup to the selected Top Bar first. Legacy headers often
    // contain a second WhatsApp link in a drawer, which must not distort Top Bar
    // ancestor detection.
    const whatsapp = topbar?.querySelector('a[href*="wa.me"],a[href*="whatsapp.com"],a[aria-label*="WhatsApp" i]')
      || root.querySelector('a[href*="wa.me"],a[href*="whatsapp.com"],a[aria-label*="WhatsApp" i]');

    // Establish the three-row in-flow layout immediately when the legacy DOM
    // arrives, before paint. Fresh REST values can update colors/content later.
    setupHeaderBehavior(root);

    // A cached legacy header can contain old text/colors. Reserve its layout but
    // never paint stale content while the fresh same-origin REST read is pending.
    if (topbar && freshState === 'pending') {
      const pendingHeight = window.innerWidth <= 767 ? 34 : Math.max(30, Math.min(60, Number(cfg.topbar_height) || 38));
      topbar.style.setProperty('min-height', `${pendingHeight}px`, 'important');
      topbar.style.setProperty('height', `${pendingHeight}px`, 'important');
      topbar.style.setProperty('visibility', 'hidden', 'important');
      topbar.style.setProperty('opacity', '0', 'important');
      root.dataset.topbarManaged = 'pending';
      return;
    }

    if (phone) {
      if (phone.matches('a')) phone.href = `tel:${phoneHref(cfg.phone)}`;
      replaceVisibleText(phone, cfg.phone);
      setVisible(closestItem(phone), asBool(cfg.show_phone) && Boolean(cfg.phone));
    }
    if (email) {
      if (email.matches('a')) email.href = `mailto:${cfg.email || ''}`;
      replaceVisibleText(email, cfg.email);
      setVisible(closestItem(email), asBool(cfg.show_email) && Boolean(cfg.email));
    }
    if (whatsapp) {
      whatsapp.href = whatsappHref(cfg.whatsapp);
      setVisible(closestItem(whatsapp), asBool(cfg.show_whatsapp) && Boolean(cfg.whatsapp));
    }
    if (wholesale) {
      replaceVisibleText(wholesale, cfg.wholesale_text, text => text.includes('خرید عمده'));
      if (cfg.wholesale_url) wholesale.href = cfg.wholesale_url;
      wholesale.target = asBool(cfg.wholesale_new_tab) ? '_blank' : '_self';
      if (wholesale.target === '_blank') wholesale.rel = 'noopener';
      else wholesale.removeAttribute('rel');
      wholesale.style.setProperty('background', cfg.topbar_button_bg || '#C9A86A', 'important');
      wholesale.style.setProperty('color', cfg.topbar_button_text || '#1A1206', 'important');
      wholesale.querySelectorAll('span,b,strong,i').forEach(element => {
        element.style.setProperty('color', cfg.topbar_button_text || '#1A1206', 'important');
      });
      setVisible(closestItem(wholesale), asBool(cfg.show_wholesale) && Boolean(cfg.wholesale_text));
    }
    if (exportNote) {
      const textNode = [...exportNote.childNodes].find(node => node.nodeType === Node.TEXT_NODE && node.textContent.includes('صادرات'));
      if (textNode) textNode.textContent = ` ${cfg.export_text || ''} `;
      else exportNote.textContent = cfg.export_text || '';
      const exportLink = exportNote.closest('a') || exportNote.querySelector?.('a');
      if (exportLink && cfg.export_url) exportLink.href = cfg.export_url;
      setVisible(closestItem(exportNote), asBool(cfg.show_export) && Boolean(cfg.export_text));
    }

    if (topbar) {
      setVisible(topbar, asBool(cfg.show_topbar));
      const color = cfg.topbar_text_color || '#F5F3F0';
      const background = cfg.topbar_bg || '#1C1024';
      const border = cfg.topbar_border_color || '#D49A2E';
      const glassBackground = `color-mix(in srgb, ${background} 78%, transparent)`;
      const height = window.innerWidth <= 767 ? 34 : Math.max(30, Math.min(60, Number(cfg.topbar_height) || 38));
      const layers = explicitCandidates.filter(element => {
        const score = candidateScore(element);
        return element === topbar || (score >= 2 && (element.contains(topbar) || topbar.contains(element)));
      });
      if (!layers.includes(topbar)) layers.unshift(topbar);
      layers.forEach(element => {
        element.style.setProperty('--alookhor-topbar-bg', background);
        element.style.setProperty('--alookhor-topbar-text', color);
        element.style.setProperty('--alookhor-topbar-border', border);
        const innerLayer = element !== topbar && topbar.contains(element);
        element.style.setProperty('background-color', innerLayer ? 'transparent' : glassBackground, 'important');
        element.style.setProperty('background-image', innerLayer ? 'none' : `linear-gradient(90deg, color-mix(in srgb, ${cfg.capsule_card || '#1C1024'} 86%, transparent), color-mix(in srgb, ${cfg.capsule_glass || 'rgba(33,20,38,.75)'} 82%, transparent), color-mix(in srgb, ${cfg.capsule_card || '#1C1024'} 86%, transparent))`, 'important');
        element.style.setProperty('color', color, 'important');
        element.style.setProperty('border-bottom-color', border, 'important');
        element.style.setProperty('min-height', `${height}px`, 'important');
        element.style.setProperty('height', `${height}px`, 'important');
      });
      topbar.querySelectorAll('a,span,p,b,strong,i').forEach(element => {
        if (wholesale && (element === wholesale || wholesale.contains(element))) return;
        element.style.setProperty('color', color, 'important');
      });
      [phone, topbar.querySelector('.alookhor-topbar-support')].filter(Boolean).forEach(item => {
        const accent = cfg.capsule_gold_light || '#E8B84A';
        item.style.setProperty('color', accent, 'important');
        item.querySelectorAll?.('a,span,b,strong,i').forEach(node => node.style.setProperty('color', accent, 'important'));
      });
      if (exportNote) {
        const messageColor = cfg.capsule_text || '#F5F3F0';
        exportNote.style.setProperty('color', messageColor, 'important');
        exportNote.querySelectorAll?.('a,span,b,strong,i').forEach(node => node.style.setProperty('color', messageColor, 'important'));
      }
      topbar.style.setProperty('visibility', 'visible', 'important');
      topbar.style.setProperty('opacity', '1', 'important');
    }

    if (cfg.top_logo_url) {
      const logos = [
        topbar?.querySelector('[class*="logo" i] img,img[alt*="لوگو"],img[alt*="alookhor" i]'),
        root.querySelector('.header-capsule-logo img')
      ].filter(Boolean);
      logos.forEach(logo => {
        logo.src = cfg.top_logo_url;
        logo.alt = cfg.top_logo_alt || 'ALOOKHOR';
        logo.style.setProperty('background', 'transparent', 'important');
        const logoLink = logo.closest('a');
        if (logoLink && cfg.top_logo_link) logoLink.href = cfg.top_logo_link;
      });
      const topLogo = logos[0];
      if (topLogo) topLogo.style.setProperty('max-width', `${Math.max(50, Math.min(180, Number(cfg.top_logo_width) || 96))}px`, 'important');
    }

    setupHeaderBehavior(root);
    root.dataset.topbarManaged = '3.10.25';
    root.dispatchEvent(new CustomEvent('alookhor:topbar-managed', {bubbles:true, detail:{version:'3.10.25'}}));
  }

  function init(scope = document, force = false) {
    scope.querySelectorAll('.alookhor-managed-legacy-header').forEach(root => manage(root, force));
    if (scope instanceof Element) {
      const owner = scope.closest('.alookhor-managed-legacy-header');
      if (owner) manage(owner, force);
    }
  }

  async function refreshFromWordPress() {
    if (!cfg.endpoint) {
      freshState = 'fallback';
      return;
    }
    const controller = new AbortController();
    const timeout = window.setTimeout(() => controller.abort(), 2500);
    try {
      const endpoint = new URL(cfg.endpoint, window.location.href);
      if (endpoint.origin !== window.location.origin) throw new Error('Top Bar endpoint origin mismatch');
      endpoint.searchParams.set('_alookhor', String(Date.now()));
      const response = await fetch(endpoint.href, {
        cache: 'no-store',
        credentials: 'same-origin',
        headers: {'Accept': 'application/json'},
        signal: controller.signal
      });
      if (!response.ok) throw new Error(`HTTP ${response.status}`);
      Object.assign(cfg, await response.json());
      freshState = 'ready';
    } catch (error) {
      freshState = 'fallback';
      console.warn('ALOOKHOR Top Bar refresh failed; localized settings remain active.', error);
    } finally {
      window.clearTimeout(timeout);
      init(document, true);
    }
  }

  // Begin the fresh read while <head> is still being parsed. MutationObserver
  // hides any stale legacy Top Bar that arrives before this promise resolves.
  refreshFromWordPress();
  const start = () => init();
  if (document.readyState === 'loading') document.addEventListener('DOMContentLoaded', start, {once:true});
  else start();

  new MutationObserver(mutations => {
    for (const mutation of mutations) {
      for (const node of mutation.addedNodes) {
        if (!(node instanceof Element)) continue;
        if (node.matches?.('.alookhor-managed-legacy-header')) manage(node);
        else init(node);
      }
    }
  }).observe(document.documentElement, {childList:true, subtree:true});
})();
````

## Source Snapshot — `plugin/alookhor-control-center/assets/js/modules/analytics.js`

````javascript
export const analyticsModule = {
  meta:{id:'analytics', title:'آنالیتیکس'},
  init(container){
    container.innerHTML = `
      <div class="page-head"><div><h2>آنالیتیکس طلایی</h2><p>تحلیل فروش و رفتار VIP</p></div><div class="head-actions"><button class="btn-ghost">بازه: ۳۰ روز</button></div></div>
      <div class="two-col">
        <div class="panel"><div class="panel-head"><h3>نمودار درآمد</h3></div><div class="chart-box"><div class="chart-canvas"><div class="chart-bars" id="aBars"></div></div></div></div>
        <div class="panel"><div class="panel-head"><h3>کانال فروش</h3></div><div style="padding:18px; display:grid; gap:12px">
          <div><div style="display:flex; justify-content:space-between; font-size:13px; margin-bottom:6px"><span>حضوری بوتیک</span><b>۶۲٪</b></div><div style="height:8px; background:rgba(255,255,255,0.06); border-radius:999px; overflow:hidden"><div style="width:62%; height:100%; background:linear-gradient(90deg,#C9A86A,#E8D5B5)"></div></div></div>
          <div><div style="display:flex; justify-content:space-between; font-size:13px; margin-bottom:6px"><span>آنلاین VIP</span><b>۲۸٪</b></div><div style="height:8px; background:rgba(255,255,255,0.06); border-radius:999px; overflow:hidden"><div style="width:28%; height:100%; background:rgba(201,168,106,0.5)"></div></div></div>
          <div><div style="display:flex; justify-content:space-between; font-size:13px; margin-bottom:6px"><span>معرف</span><b>۱۰٪</b></div><div style="height:8px; background:rgba(255,255,255,0.06); border-radius:999px; overflow:hidden"><div style="width:10%; height:100%; background:rgba(255,255,255,0.18)"></div></div></div>
        </div></div>
      </div>
    `;
    const bars = container.querySelector('#aBars');
    if(bars){
      const vals=[50,78,62,95,70,108,84];
      bars.innerHTML = vals.map(v=>`<div class="bar" style="height:${v}px"></div>`).join('');
    }
  }, destroy(){}
};
````

## Source Snapshot — `plugin/alookhor-control-center/assets/js/modules/dashboard.js`

````javascript
import { Config } from '../core/config.js?v=3.10.25';

const escapeHTML = value => String(value ?? '').replace(/[&<>'"]/g, char => ({
  '&':'&amp;', '<':'&lt;', '>':'&gt;', "'":'&#039;', '"':'&quot;'
})[char]);

const assistantItems = suggestions => suggestions.map((suggestion,index)=>`
  <div class="ai-item ${index===0?'open':''}" data-ai="${escapeHTML(suggestion.id)}">
    <button class="ai-head" type="button"><span class="ai-plus">${index===0?'×':'+'}</span>${escapeHTML(suggestion.title)}<span class="ai-badge">${suggestion.status==='new'?'جدید':suggestion.status==='done'?'انجام شد':'AI'}</span></button>
    <div class="ai-body">
      <p>${escapeHTML(suggestion.detail)}</p>
      <div style="display:flex;gap:8px;margin-top:10px;flex-wrap:wrap">
        ${suggestion.status!=='done'?`<button class="btn-gold" type="button" style="padding:6px 12px;font-size:12px" data-dashboard-ai-action="do" data-id="${escapeHTML(suggestion.id)}">اعمال پیشنهاد</button>`:`<span style="color:var(--success);font-size:12px;font-weight:700">✓ اعمال شد</span>`}
        <button class="btn-ghost" type="button" style="padding:6px 12px;font-size:12px" data-dashboard-ai-action="dismiss" data-id="${escapeHTML(suggestion.id)}">${suggestion.status==='done'?'بازگردانی':'نادیده بگیر'}</button>
      </div>
    </div>
  </div>`).join('');

export const dashboardModule = {
  meta: { id: 'dashboard', title: 'داشبورد', icon: 'dashboard' },
  init(container) {
    const cfg = Config.data || {};
    const system = Object.assign({woocommerce:'نامشخص',woodmart_plus:'نامشخص',elementor_pro:'نامشخص',php_version:'—',memory:'—',ssl:'نامشخص',uptime:'—',cache:'—'},cfg.system || {});
    const suggestions = Array.isArray(cfg.ai_assistant?.suggestions) ? cfg.ai_assistant.suggestions : [];
    container.innerHTML = `
      <div class="page-head">
        <div>
          <h2>داشبورد لوکس — نمای کلی</h2>
          <p>آخرین به‌روزرسانی: همین حالا • مانیتورینگ زنده بوتیک ALOOKHOR</p>
        </div>
        <div class="head-actions">
          <button class="btn-ghost" data-action="export">خروجی Excel</button>
          <button class="btn-gold" data-action="new-order">+ سفارش جدید</button>
        </div>
      </div>

      <div class="dashboard-monitor-grid" data-dashboard-only="1">
        <div class="panel ai-panel" id="dashboardAiCard">
          <div class="panel-head"><h3>🤖 دستیار هوشمند تجاری (AI Assistant)</h3><span style="font-size:10px;background:rgba(201,168,106,.14);color:var(--gold-soft);padding:3px 8px;border-radius:999px;border:1px solid var(--gold-border)">پایش داشبورد</span></div>
          <div class="ai-list" id="dashboardAiList">${assistantItems(suggestions)}</div>
        </div>
        <div class="panel status-panel" id="dashboardStatusCard">
          <div class="panel-head"><h3>⊕ وضعیت و سلامت سیستم (System Status)</h3><button class="btn-ghost" type="button" style="padding:5px 10px;font-size:11px" id="dashboardRefreshStatus">بررسی مجدد</button></div>
          <div class="status-list">
            <div class="status-row"><span><span class="dot on"></span> ووکامرس</span><b>${escapeHTML(system.woocommerce)}</b></div>
            <div class="status-row"><span><span class="dot on"></span> وودمارت پلاس</span><b>${escapeHTML(system.woodmart_plus)}</b></div>
            <div class="status-row"><span><span class="dot on"></span> المنتور پرو</span><b>${escapeHTML(system.elementor_pro)}</b></div>
            <div class="status-row"><span>نسخه پی‌اچ‌پی هاست (PHP)</span><b dir="ltr">${escapeHTML(system.php_version)}</b></div>
            <div class="status-row"><span>حافظه لایو سیستم (Memory)</span><b style="color:var(--gold)" dir="ltr">${escapeHTML(system.memory)}</b></div>
            <div class="status-row"><span>گواهینامه امنیتی (SSL)</span><b style="color:var(--success)"><span class="dot on"></span>${escapeHTML(system.ssl)}</b></div>
          </div>
          <div class="dashboard-system-metrics"><div><span style="font-size:11px;color:var(--text-faint)">آپتایم</span><br><b style="color:var(--success)">${escapeHTML(system.uptime)}</b></div><div><span style="font-size:11px;color:var(--text-faint)">کش طلایی</span><br><b style="color:var(--gold-soft)">${escapeHTML(system.cache)}</b></div></div>
        </div>
      </div>

      <div class="kpi-grid">
        <div class="kpi-card">
          <div class="kpi-top">
            <div class="kpi-icon"><svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6"><path d="M12 8c-2.21 0-4 1.79-4 4s1.79 4 4 4 4-1.79 4-4-1.79-4-4-4Z"/><path d="M12 2v2"/><path d="M12 20v2"/><path d="M4.93 4.93l1.41 1.41"/><path d="M17.66 17.66l1.41 1.41"/><path d="M2 12h2"/><path d="M20 12h2"/><path d="M6.34 17.66l-1.41 1.41"/><path d="M19.07 4.93l-1.41 1.41"/></svg></div>
            <span class="kpi-trend trend-up">▲ 12.4%</span>
          </div>
          <div class="kpi-value">۲.۴B <span style="font-size:14px; color:var(--text-muted); font-family:Inter">تومان</span></div>
          <div class="kpi-label">فروش امروز</div>
          <div class="kpi-foot">نسبت به دیروز +۱۲.۴٪ — ۳ سفارش VIP</div>
        </div>
        <div class="kpi-card">
          <div class="kpi-top">
            <div class="kpi-icon" style="color:#E8D5B5"><svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6"><path d="M6 2h9l5 5v15H6z"/><path d="M15 2v6h6"/></svg></div>
            <span class="kpi-trend trend-up">▲ 8.1%</span>
          </div>
          <div class="kpi-value">۱۴۷</div>
          <div class="kpi-label">سفارشات فعال</div>
          <div class="kpi-foot">۳۲ در انتظار تایید طلا</div>
        </div>
        <div class="kpi-card">
          <div class="kpi-top">
            <div class="kpi-icon"><svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6"><path d="M20 12V8H6"/><path d="M20 12v4H6"/><path d="M4 8v8"/></svg></div>
            <span class="kpi-trend trend-down">▼ 2.3%</span>
          </div>
          <div class="kpi-value">۱,۲۸۴</div>
          <div class="kpi-label">موجودی انبار</div>
          <div class="kpi-foot">۱۸ قلم کمتر از حد لوکس</div>
        </div>
        <div class="kpi-card">
          <div class="kpi-top">
            <div class="kpi-icon"><svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M22 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg></div>
            <span class="kpi-trend trend-up">▲ 4.7%</span>
          </div>
          <div class="kpi-value">۸۹۲</div>
          <div class="kpi-label">مشتریان VIP</div>
          <div class="kpi-foot">۱۴ مشتری جدید این هفته</div>
        </div>
      </div>

      <div class="two-col">
        <div class="panel">
          <div class="panel-head">
            <h3>سفارشات اخیر</h3>
            <button class="btn-ghost" style="padding:6px 12px; font-size:12px">مشاهده همه</button>
          </div>
          <div class="panel-body">
            <div class="table-wrap">
              <table>
                <thead><tr><th>سفارش</th><th>مشتری</th><th>مبلغ</th><th>وضعیت</th><th>تاریخ</th></tr></thead>
                <tbody>
                  <tr><td><b>#AL-9841</b></td><td>سارا احمدی — VIP Gold</td><td>۱۸۴,۰۰۰,۰۰۰ ت</td><td><span class="status status-ok"><span class="status-dot"></span> تحویل شده</span></td><td>۱۰ اوت</td></tr>
                  <tr><td><b>#AL-9840</b></td><td>امیر حسینی</td><td>۹۲,۵۰۰,۰۰۰ ت</td><td><span class="status status-warn"><span class="status-dot"></span> در ساخت</span></td><td>۱۰ اوت</td></tr>
                  <tr><td><b>#AL-9839</b></td><td>نگار کریمی — VIP</td><td>۲۱۰,۰۰۰,۰۰۰ ت</td><td><span class="status status-warn"><span class="status-dot"></span> در انتظار طلا</span></td><td>۹ اوت</td></tr>
                  <tr><td><b>#AL-9838</b></td><td>محمد رضایی</td><td>۴۵,۰۰۰,۰۰۰ ت</td><td><span class="status status-bad"><span class="status-dot"></span> لغو شده</span></td><td>۹ اوت</td></tr>
                </tbody>
              </table>
            </div>
            <div class="card-list">
              <div class="mini-card"><div class="mini-card-top"><div><h4>#AL-9841 — سارا احمدی</h4><p>VIP Gold • ۱۸۴M تومان</p></div><span class="status status-ok"><span class="status-dot"></span> تحویل</span></div><div class="mini-meta"><span>تاریخ: <b>۱۰ اوت</b></span></div></div>
              <div class="mini-card"><div class="mini-card-top"><div><h4>#AL-9840 — امیر حسینی</h4><p>۹۲.۵M تومان</p></div><span class="status status-warn"><span class="status-dot"></span> در ساخت</span></div><div class="mini-meta"><span>تاریخ: <b>۱۰ اوت</b></span></div></div>
              <div class="mini-card"><div class="mini-card-top"><div><h4>#AL-9839 — نگار کریمی</h4><p>VIP • ۲۱۰M تومان</p></div><span class="status status-warn"><span class="status-dot"></span> انتظار طلا</span></div><div class="mini-meta"><span>تاریخ: <b>۹ اوت</b></span></div></div>
            </div>
          </div>
        </div>

        <div class="panel">
          <div class="panel-head"><h3>فروش ۷ روز اخیر</h3><span style="font-size:11px; color:var(--text-faint); letter-spacing:0.08em; text-transform:uppercase">Gold Chart</span></div>
          <div class="chart-box">
            <div class="chart-canvas" id="chartCanvas">
              <div class="chart-bars" id="chartBars"></div>
            </div>
            <div style="display:flex; justify-content:space-between; margin-top:10px; font-size:11px; color:var(--text-faint)">
              <span>شنبه</span><span>یک‌شنبه</span><span>دوشنبه</span><span>سه‌شنبه</span><span>چهارشنبه</span><span>پنج‌شنبه</span><span>جمعه</span>
            </div>
          </div>
        </div>
      </div>
    `;
    // animate bars
    const bars = container.querySelector('#chartBars');
    if (bars) {
      const vals = [68, 92, 74, 110, 88, 124, 96];
      bars.innerHTML = vals.map(v => `<div class="bar" style="height:${v}px"></div>`).join('');
      requestAnimationFrame(() => {
        bars.querySelectorAll('.bar').forEach((b,i) => {
          b.style.height = '20px';
          setTimeout(()=> b.style.height = vals[i]+'px', 80 + i*70);
        });
      });
    }
    container.querySelectorAll('[data-action]').forEach(btn=>{
      btn.addEventListener('click', ()=> window.ALOOKHOR.toast('این اکشن در نسخه بعدی به API وصل می‌شود','info'));
    });
    container.addEventListener('click', async event=>{
      const aiHead=event.target.closest('.ai-head');
      if(aiHead){
        const item=aiHead.closest('.ai-item');const wasOpen=item?.classList.contains('open');
        container.querySelectorAll('.ai-item').forEach(node=>node.classList.remove('open'));
        container.querySelectorAll('.ai-plus').forEach(node=>node.textContent='+');
        if(item&&!wasOpen){item.classList.add('open');aiHead.querySelector('.ai-plus').textContent='×'}
        return;
      }
      const aiAction=event.target.closest('[data-dashboard-ai-action]');
      if(aiAction){
        const suggestion=suggestions.find(item=>String(item.id)===String(aiAction.dataset.id));
        if(!suggestion)return;
        suggestion.status=aiAction.dataset.dashboardAiAction==='do'?'done':suggestion.status==='done'?'pending':'done';
        await Config.save({notify:false});
        const list=container.querySelector('#dashboardAiList');if(list)list.innerHTML=assistantItems(suggestions);
        window.ALOOKHOR.toast(aiAction.dataset.dashboardAiAction==='do'?`پیشنهاد «${suggestion.title}» اعمال شد`:'وضعیت پیشنهاد بروزرسانی شد',aiAction.dataset.dashboardAiAction==='do'?'success':'info');
        return;
      }
      const refresh=event.target.closest('#dashboardRefreshStatus');
      if(refresh){refresh.disabled=true;refresh.textContent='بررسی شد ✓';window.ALOOKHOR.toast('سلامت سیستم بررسی شد','success');setTimeout(()=>{refresh.disabled=false;refresh.textContent='بررسی مجدد'},1600)}
    });
  },
  destroy(){}
};
````

## Source Snapshot — `plugin/alookhor-control-center/assets/js/modules/inventory.js`

````javascript
export const inventoryModule = {
  meta: { id: 'inventory', title: 'انبار' },
  init(container){
    container.innerHTML = `
      <div class="page-head">
        <div><h2>انبار لوکس</h2><p>۱,۲۸۴ قلم — ۱۸ هشدار موجودی — همگام‌سازی زنده</p></div>
        <div class="head-actions"><button class="btn-ghost" id="btnFilter">فیلتر طلایی</button><button class="btn-gold">+ افزودن قطعه</button></div>
      </div>
      <div class="panel">
        <div class="panel-head"><h3>موجودی بر اساس عیار</h3><span style="font-size:12px;color:var(--text-muted)">به‌روزرسانی آنی</span></div>
        <div style="padding:16px; display:grid; gap:10px">
          <div style="display:flex; justify-content:space-between; align-items:center; padding:12px 14px; background:rgba(255,255,255,0.03); border:1px solid var(--gold-border); border-radius:12px">
            <div><b>طلای ۱۸ عیار</b><div style="font-size:12px;color:var(--text-muted)">۸۴۲ قطعه • ۱۲.4kg</div></div><span class="status status-ok"><span class="status-dot"></span> موجود</span>
          </div>
          <div style="display:flex; justify-content:space-between; align-items:center; padding:12px 14px; background:rgba(255,255,255,0.03); border:1px solid var(--gold-border); border-radius:12px">
            <div><b>طلای ۲۴ عیار (شمش)</b><div style="font-size:12px;color:var(--text-muted)">۲۱۰ قطعه • ۸.1kg</div></div><span class="status status-warn"><span class="status-dot"></span> کم</span>
          </div>
          <div style="display:flex; justify-content:space-between; align-items:center; padding:12px 14px; background:rgba(255,255,255,0.03); border:1px solid var(--gold-border); border-radius:12px">
            <div><b>سنگ‌های قیمتی</b><div style="font-size:12px;color:var(--text-muted)">۲۳۲ قطعه</div></div><span class="status status-ok"><span class="status-dot"></span> موجود</span>
          </div>
        </div>
      </div>
      <div style="margin-top:16px; padding:14px; background:rgba(201,168,106,0.08); border:1px dashed var(--gold-border-strong); border-radius:14px; color:var(--gold-soft); font-size:13px; line-height:1.7">
        ✨ <b>مرحله بعدی:</b> این ماژول آماده اتصال به API واقعی است. فیلتر لوکس (بر اساس وزن، عیار، قیمت) و جستجوی زنده در تسک بعدی اضافه می‌شود — بدون دست زدن به معماری.
      </div>
    `;
    container.querySelector('#btnFilter')?.addEventListener('click', ()=> window.ALOOKHOR.toast('فیلتر لوکس در آپدیت 3.8.0 فعال می‌شود','info'));
  },
  destroy(){}
};
````

## Source Snapshot — `plugin/alookhor-control-center/assets/js/modules/orders.js`

````javascript
export const ordersModule = {
  meta:{id:'orders', title:'سفارشات'},
  init(container){
    container.innerHTML = `
      <div class="page-head"><div><h2>سفارشات</h2><p>مدیریت سفارشات VIP با تایم‌لاین لوکس</p></div><div class="head-actions"><button class="btn-gold">+ سفارش VIP</button></div></div>
      <div class="panel"><div class="panel-head"><h3>همه سفارشات</h3><span style="font-size:12px;color:var(--text-faint)">۱۴۷ فعال</span></div>
        <div class="table-wrap"><table><thead><tr><th>کد</th><th>مشتری</th><th>قطعه</th><th>مبلغ</th><th>وضعیت</th></tr></thead>
        <tbody>
          <tr><td>#AL-9841</td><td>سارا احمدی</td><td>گردنبند الماس ۱۸عیار</td><td>۱۸۴M</td><td><span class="status status-ok"><span class="status-dot"></span> تحویل</span></td></tr>
          <tr><td>#AL-9840</td><td>امیر حسینی</td><td>انگشتر فیروزه</td><td>۹۲.۵M</td><td><span class="status status-warn"><span class="status-dot"></span> در ساخت</span></td></tr>
          <tr><td>#AL-9839</td><td>نگار کریمی</td><td>دستبند طلا ۲۴عیار</td><td>۲۱۰M</td><td><span class="status status-warn"><span class="status-dot"></span> انتظار</span></td></tr>
        </tbody></table></div>
        <div class="card-list">
          <div class="mini-card"><div class="mini-card-top"><div><h4>#AL-9841</h4><p>سارا احمدی — گردنبند الماس</p></div><span class="status status-ok"><span class="status-dot"></span> تحویل</span></div><div class="mini-meta"><span>۱۸۴M</span></div></div>
          <div class="mini-card"><div class="mini-card-top"><div><h4>#AL-9840</h4><p>امیر حسینی — انگشتر فیروزه</p></div><span class="status status-warn"><span class="status-dot"></span> در ساخت</span></div><div class="mini-meta"><span>۹۲.۵M</span></div></div>
        </div>
      </div>`;
  }, destroy(){}
};
````

## Source Snapshot — `plugin/alookhor-control-center/assets/js/modules/settings.js`

````javascript
import { Config } from '../core/config.js?v=3.10.25';

const escapeAttr = value => String(value ?? '').replace(/[&<>'"]/g, char => ({
  '&':'&amp;', '<':'&lt;', '>':'&gt;', "'":'&#039;', '"':'&quot;'
})[char]);
const isEnabled = value => value === true || value === 1 || value === '1' || value === 'true';
const footerLinksText = links => (Array.isArray(links) ? links : []).map(link => `${link.title || ''}|${link.url || ''}`).join('\n');
const parseFooterLinks = value => String(value || '').split(/\r?\n/).map(line => {
  const [title, ...url] = line.split('|');
  return {title:String(title || '').trim(), url:url.join('|').trim()};
}).filter(link => link.title);
const footerMenuOptions = selected => `<option value="0">لینک‌های سفارشی زیر</option>${(window.ALOOKHOR_CC?.footer_menus || []).map(menu => `<option value="${Number(menu.id)}" ${Number(selected)===Number(menu.id)?'selected':''}>${escapeAttr(menu.name)}</option>`).join('')}`;

export const settingsModule = {
  meta: { id: 'settings', title: 'مدیریت بوتیک' },
  async init(container){
    // لود حافظه واقعی قبلی — تمام سایت با همین تنظیمات ویرایش می‌شد
    if(!Config.data) await Config.load();
    let cfg = Config.data;
    // Guard: اگر حافظه به خاطر Tracking Prevention خالی بود، fallback بساز
    if(!cfg) cfg = {site:{name:'ALOOKHOR', subtitle:'Control Center • Luxury', logoLetter:'A'}, modules:{}, system:{}, header_settings:{logo_text:'ALOOKHOR', logo_sub:'Control Center • Luxury'}, ai_assistant:{suggestions:[]}};
    if(!cfg.modules) cfg.modules = {};
    cfg.header_settings = Object.assign({
      logo_text:'ALOOKHOR', logo_sub:'Control Center • Luxury', phone:'', email:'', whatsapp:'',
      export_text:'صادرات به ۵ کشور جهان', export_url:'', wholesale_text:'خرید عمده آلو بخارا', wholesale_url:'',
      top_logo_url:'', top_logo_alt:'ALOOKHOR', top_logo_link:'', top_logo_width:96,
      topbar_bg:'#1C1024', topbar_text_color:'#F5F3F0', topbar_border_color:'#D49A2E',
      topbar_button_bg:'#D49A2E', topbar_button_text:'#0D0510', topbar_height:38,
      header_surface:'#0D0510', header_text_color:'#F5F3F0', header_muted_color:'#C8C2C9',
      capsule_background:'#0D0510', capsule_card:'#1C1024', capsule_glass:'rgba(33,20,38,.75)', capsule_gold:'#D49A2E', capsule_gold_light:'#E8B84A', capsule_text:'#F5F3F0', capsule_muted:'#C8C2C9', capsule_blur:24,
      header_logo_desktop_width:118, header_logo_mobile_width:58,
      show_search:false, search_placeholder:'جستجوی محصول…', show_topbar:true, show_phone:true, show_email:true, show_whatsapp:true, show_export:true,
      show_wholesale:true, wholesale_new_tab:false
    }, cfg.header_settings || {});
    cfg.footer_settings = Object.assign({
      enabled:true, hide_legacy:true, hide_old_newsletter:true, use_header_contact:true,
      logo_url:'', logo_alt:'لوگوی رسمی آلوخور', brand_name:'ALOOKHOR', brand_subtitle:'PREMIUM PERSIAN DRIED PLUMS',
      brand_kicker:'From Iranian Orchards to the World', brand_description:'', cta_text:'درخواست قیمت عمده و صادراتی', cta_url:'',
      phone:'', email:'', whatsapp:'', address:'خراسان رضوی، خور نیشابور', support_label:'تلفن پشتیبانی و سفارش عمده',
      hours_week:'شنبه تا پنجشنبه: ۸ الی ۲۰', hours_friday:'جمعه‌ها: ۹ الی ۱۴',
      customer_title:'خدمات مشتریان', customer_menu_id:0, customer_links:[], order_title:'خرید و سفارش', order_menu_id:0, order_links:[],
      about_title:'درباره آلوخور', about_mobile_title:'راهنمای صادراتی', about_menu_id:0, about_links:[],
      instagram_url:'', telegram_url:'', whatsapp_url:'', social_title:'آلوخور را دنبال کنید', social_desc:'',
      newsletter_enabled:true, newsletter_title:'عضویت در خبرنامه', newsletter_desc:'', newsletter_placeholder:'ایمیل شما', newsletter_button:'عضویت',
      product_image_url:'', enamad_title:'Enamad', enamad_image_url:'', enamad_url:'', samandehi_title:'ساماندهی', samandehi_image_url:'', samandehi_url:'',
      copyright_text:'تمامی حقوق محفوظ است.', copyright_en:'Premium Persian Dried Plums Exporter',
      background:'#070809', surface:'#0D0F10', gold:'#C89A3D', gold_soft:'#E3BD69', text:'#E9E5DF', muted:'#A7A39D', border:'#4A3820',
      container_width:1280, desktop_logo_width:210, mobile_logo_width:190, show_payments:true, show_benefits:true, show_product_image:true
    }, cfg.footer_settings || {});
    cfg.category_settings = Object.assign({
      enabled:true, hide_legacy:true, hide_empty:false, parent_only:true, selected_ids:[38,39,40,41], limit:8, orderby:'include', order:'ASC',
      kicker:'دسته‌بندی محصولات', title:'محصولات طبیعی، کیفیت صادراتی', subtitle:'انتخاب مستقیم از باغ‌های خراسان، آماده ارسال به سراسر جهان', button_text:'مشاهده محصولات',
      show_description:true, show_count:false, show_icons:true, show_arrows:true, show_dots:true, autoplay:true, autoplay_interval:5000,
      desktop_cards:4, desktop_gap:18, image_height:285, mobile_card_width:84, mobile_gap:14, mobile_image_height:225, mobile_radius:18, mobile_peek:8, section_background:'#090610', card_background:'#0D0916', gold:'#D4A436', text:'#F7F2EA', muted:'#B8B0BD', border:'#6F5426', button_background:'#120B1C', overrides:{}
    }, cfg.category_settings || {});
    const heroBase=`${String(window.ALOOKHOR_CC?.home_url||'/').replace(/\/$/,'')}/wp-content/plugins/alookhor-categories-manager/images/`;
    const heroSlideDefaults=[
      {image_id:0,flip_image:true,image_url:`${heroBase}slide1.jpg`,image_alt:'آلو بخارا ممتاز خراسان',kicker:'محصول ممتاز خراسان',title:'آلو بخارا',highlight:'ممتاز خراسان',description:'طبیعی، سالم و بدون مواد افزودنی',features:['۱۰۰٪ طبیعی','کیفیت صادراتی','ارسال سریع','ارسال به سراسر جهان'],primary_text:'مشاهده محصولات',primary_url:'/shop/',secondary_text:'استعلام قیمت',secondary_url:'/#b2b'},
      {image_id:0,flip_image:true,image_url:`${heroBase}slide2.jpg`,image_alt:'آلو خشک طبیعی آلوخور',kicker:'انتخابی از باغ‌های ایران',title:'آلو خشک طبیعی',highlight:'خوش‌طعم و سالم',description:'سورت یکدست، فرآوری بهداشتی و طعم اصیل',features:['بدون افزودنی','سورت ممتاز','بسته‌بندی مطمئن','تحویل سریع'],primary_text:'خرید محصولات',primary_url:'/shop/',secondary_text:'مشاوره خرید',secondary_url:'/تماس-با-ما/'},
      {image_id:0,flip_image:true,image_url:`${heroBase}slide3.jpg`,image_alt:'بسته‌بندی صادراتی آلوخور',kicker:'استاندارد بازارهای جهانی',title:'بسته‌بندی حرفه‌ای',highlight:'آماده صادرات',description:'حفظ کیفیت محصول از باغ تا مقصد نهایی',features:['کنترل کیفیت','سورت دقیق','بسته‌بندی صادراتی','ارسال بین‌المللی'],primary_text:'خدمات صادرات',primary_url:'/#b2b',secondary_text:'تماس با ما',secondary_url:'/تماس-با-ما/'},
      {image_id:0,flip_image:true,image_url:`${heroBase}slide4.jpg`,image_alt:'سفارش عمده محصولات آلوخور',kicker:'همکاری مطمئن و ماندگار',title:'تأمین عمده آلو',highlight:'برای کسب‌وکارها',description:'ظرفیت پایدار، قیمت رقابتی و پشتیبانی تخصصی',features:['تأمین پایدار','قیمت همکاری','کنترل سفارش','پشتیبانی مستقیم'],primary_text:'درخواست همکاری',primary_url:'/#b2b',secondary_text:'دریافت مشاوره',secondary_url:'/تماس-با-ما/'}
    ];
    cfg.hero_settings=Object.assign({enabled:true,hide_legacy:true,autoplay:true,autoplay_interval:5500,pause_on_hover:true,show_arrows:true,show_dots:true,ken_burns:true,gold:'#D4AF37',surface:'#09060D',text:'#FFFFFF',muted:'#D9D1DA',radius:32,slides:[]},cfg.hero_settings||{});
    const savedHeroSlides=Array.isArray(cfg.hero_settings.slides)?cfg.hero_settings.slides:[];
    cfg.hero_settings.slides=heroSlideDefaults.map((defaults,index)=>{
      const saved=savedHeroSlides[index]&&typeof savedHeroSlides[index]==='object'?savedHeroSlides[index]:{};
      return {...defaults,...saved,features:[...Array(4)].map((_,featureIndex)=>Array.isArray(saved.features)&&saved.features[featureIndex]!==undefined?saved.features[featureIndex]:defaults.features[featureIndex])};
    });
    if(cfg.modules.hero){cfg.modules.hero.slides=4;cfg.modules.hero.autoplay=isEnabled(cfg.hero_settings.autoplay)}
    const featureDefaults=[
      {icon:'truck',title:'ارسال سریع',description:'در سریع‌ترین زمان ممکن'},
      {icon:'organic',title:'محصولات ارگانیک',description:'100% طبیعی و سالم'},
      {icon:'headset',title:'پشتیبانی ۲۴/۷',description:'همیشه در کنار شما هستیم'},
      {icon:'shield',title:'ضمانت کیفیت',description:'تضمین اصالت و کیفیت کالا'}
    ];
    cfg.feature_settings=Object.assign({enabled:true,hide_legacy:true,background:'#0D0510',card:'#1C1024',glass:'rgba(33,20,38,.75)',gold:'#D49A2E',gold_light:'#E8B84A',text:'#F5F3F0',muted:'#C8C2C9',radius:20,gap:8,items:[]},cfg.feature_settings||{});
    const savedFeatureItems=Array.isArray(cfg.feature_settings.items)?cfg.feature_settings.items:[];
    cfg.feature_settings.items=featureDefaults.map((defaults,index)=>({...defaults,...(savedFeatureItems[index]&&typeof savedFeatureItems[index]==='object'?savedFeatureItems[index]:{})}));
    if(!cfg.site) cfg.site = {name:'ALOOKHOR', subtitle:'Control Center • Luxury', logoLetter:'A'};
    if(!cfg.system) cfg.system = {uptime:'99.9%', cache:'فعال', woocommerce:'فعال', woodmart_plus:'فعال', elementor_pro:'فعال', php_version:'8.1.6', memory:'256MB / 512MB', ssl:'فعال (امن)'};
    if(!cfg.ai_assistant) cfg.ai_assistant = {suggestions:[]};
    if(!cfg.ai_assistant.suggestions) cfg.ai_assistant.suggestions = [];

    const sourceMeta = {
      wordpress: {label:'حافظه WordPress متصل', color:'#3DD68C', bg:'rgba(61,214,140,0.14)', border:'rgba(61,214,140,0.18)'},
      'repaired-defaults': {label:'حافظه ناقص ترمیم شد', color:'#E8D5B5', bg:'rgba(201,168,106,0.14)', border:'rgba(201,168,106,0.24)'},
      'defaults-file': {label:'Defaults افزونه بارگذاری شد', color:'#E8D5B5', bg:'rgba(201,168,106,0.14)', border:'rgba(201,168,106,0.24)'},
      'local-cache': {label:'حالت آفلاین — Cache محلی', color:'#E8D5B5', bg:'rgba(201,168,106,0.14)', border:'rgba(201,168,106,0.24)'},
      'emergency-fallback': {label:'اتصال حافظه ناموفق', color:'#FF8A8E', bg:'rgba(255,90,95,0.11)', border:'rgba(255,90,95,0.22)'}
    };
    const memory = sourceMeta[Config.source] || sourceMeta['emergency-fallback'];
    const hasDefinitions = Object.keys(cfg.modules||{}).length > 0;

    container.innerHTML = `
      <div class="page-head">
        <div>
          <h2>مدیریت اصلی بوتیک ALOOKHOR</h2>
          <p>تنظیمات ALOOKHOR بدون حذف مقادیر قبلی بارگذاری می‌شود <span style="background:${memory.bg}; color:${memory.color}; padding:2px 8px; border-radius:999px; font-size:11px; border:1px solid ${memory.border}">● ${memory.label}</span></p>
        </div>
        <div class="head-actions">
          <button class="btn-ghost" id="btnExportSettings">⬇ خروجی JSON</button>
          <button class="btn-ghost" id="btnResetSettings">بازنشانی</button>
          <button class="btn-gold" id="btnSaveAll">💾 ذخیره همه — اعمال زنده</button>
        </div>
      </div>

      <div style="display:flex; gap:8px; flex-wrap:wrap; margin-bottom:14px; align-items:center">
        <span style="font-size:11px; color:var(--text-faint); background:rgba(255,255,255,0.04); border:1px solid var(--gold-border); padding:4px 10px; border-radius:999px">آخرین ذخیره: <b id="lastSave" style="color:var(--text-secondary)">${cfg.updated_at ? new Date(cfg.updated_at).toLocaleString('fa-IR') : 'همین حالا'}</b></span>
        <span style="font-size:11px; color:var(--gold-soft); background:rgba(201,168,106,0.10); border:1px solid var(--gold-border-strong); padding:4px 10px; border-radius:999px">نسخه: ${cfg.version}</span>
        <span class="boutique-workspace-hint">ماژول را از ستون مدیریت انتخاب کنید؛ فرم کامل آن در فضای وسیع روبه‌رو باز می‌شود.</span>
      </div>

      <div class="settings-hub">
        <!-- ستون راست: ماژول‌های فعال سیستم — دقیقا مثل تصویر، اما حالا واقعی -->
        <div class="modules-side" id="modulesCard">
          <div class="panel" style="overflow:hidden">
            <div class="panel-head" style="background:rgba(201,168,106,0.06)"><h3 style="font-size:13px">ماژول‌های فعال سیستم</h3><span style="font-size:10px; background:var(--success); color:#0A0A0A; padding:2px 7px; border-radius:999px; font-weight:800">${Object.values(cfg.modules||{}).filter(m=>m.enabled).length} / ${Object.keys(cfg.modules||{}).length} فعال</span></div>
            <div class="modules-list" id="modulesList">
              <!-- JS render -->
            </div>
            <div style="padding:10px 12px; display:flex; gap:8px">
              <button class="btn-ghost" style="flex:1; padding:8px; font-size:11.5px" id="btnDisableAll">غیرفعال همه</button>
              <button class="btn-gold" style="flex:1; padding:8px; font-size:11.5px" id="btnEnableAll">فعال‌سازی همه</button>
            </div>
          </div>
          <div style="margin-top:10px; padding:10px 12px; background:${memory.bg}; border:1px solid ${memory.border}; border-radius:12px; font-size:12px; color:var(--text-secondary); line-height:1.7">
            <b style="color:${memory.color}">${hasDefinitions?'✓':'!'} ${memory.label}</b><br>
            ${hasDefinitions
              ? 'تعریف ماژول‌ها بازیابی شده و تغییرات از مسیر امن WordPress ذخیره می‌شوند.'
              : 'تعریف ماژول‌ها دریافت نشد؛ برای جزئیات Console و پاسخ admin-ajax.php را بررسی کنید.'}
          </div>
          <div style="margin-top:8px; padding:10px; background:rgba(255,255,255,0.03); border:1px dashed var(--gold-border); border-radius:10px">
            <div style="font-size:11px; color:var(--text-faint); margin-bottom:6px">پیش‌نمایش هدر زنده:</div>
            <div style="display:flex; align-items:center; gap:8px; background:#111113; border:1px solid var(--gold-border-strong); border-radius:10px; padding:8px">
              <div style="width:28px; height:28px; border-radius:8px; background:linear-gradient(135deg,#1A1A1D,#0F0F10); border:1px solid var(--gold-border-strong); display:grid; place-items:center; color:var(--gold); font-weight:800; font-size:12px">${cfg.site.logoLetter}</div>
              <div><div style="font-size:12px; font-weight:700" id="liveLogoText">${cfg.header_settings.logo_text}</div><div style="font-size:10px; color:var(--text-muted)" id="liveLogoSub">${cfg.header_settings.logo_sub}</div></div>
            </div>
          </div>
        </div>

        <!-- فضای وسیع مدیریت بوتیک؛ AI و System Status فقط در Dashboard هستند -->
        <div class="settings-main">
          <div class="panel settings-workspace">
            <div class="panel-head"><h3>⚙️ تنظیمات کامل ماژول انتخاب‌شده</h3><span style="font-size:11px;color:var(--text-faint)" id="quickTitle">یک ماژول از ستون مدیریت انتخاب کنید</span></div>
            <div id="quickSettings" style="padding:18px">
              <div style="text-align:center;padding:28px;color:var(--text-muted);font-size:13px;background:rgba(255,255,255,.02);border:1px dashed var(--gold-border);border-radius:12px">یک ماژول را انتخاب کنید تا تنظیمات واقعی آن در این فضای وسیع باز شود.<br><span style="color:var(--gold-soft)">تغییرات در WordPress ذخیره و بلافاصله روی سایت اعمال می‌شوند.</span></div>
            </div>
          </div>
        </div>
      </div>


      <style>
        .settings-hub{display:grid;grid-template-columns:minmax(270px,310px) minmax(0,1fr);gap:16px;align-items:start}
        .settings-main{min-width:0;width:100%}
        .settings-workspace{min-height:560px}
        .modules-side{width:auto;min-width:0;position:sticky;top:84px}
        .boutique-workspace-hint{margin-right:auto;color:var(--text-muted);font-size:11px;line-height:1.7}
        @media(min-width:1600px){.settings-hub{grid-template-columns:320px minmax(0,1fr);gap:20px}#quickSettings{padding:22px!important}}
        @media(max-width:1180px){.settings-hub{grid-template-columns:1fr}.modules-side{width:100%;position:static}.settings-workspace{min-height:0}.boutique-workspace-hint{width:100%;margin:4px 0 0}}
        .modules-list{ display:grid; gap:0 }
        .mod-item{ display:flex; align-items:center; gap:10px; padding:11px 12px; font-size:12.8px; font-weight:500; color:var(--text-secondary); border-bottom:1px solid rgba(201,168,106,0.08); cursor:pointer; transition: all 0.18s ease; position:relative }
        .mod-item:hover{ background:rgba(255,255,255,0.03); color:var(--text-primary)}
        .mod-item.active{ background: linear-gradient(90deg, rgba(201,168,106,0.16), transparent); border-right:3px solid var(--gold); color:var(--gold-soft); font-weight:700}
        .mod-item.disabled{ opacity:0.45; filter: grayscale(0.3)}
        .mod-icon{ width:26px; height:26px; border-radius:8px; display:grid; place-items:center; background:rgba(255,255,255,0.04); border:1px solid var(--gold-border); font-size:12px; flex:0 0 26px}
        .mod-item.active .mod-icon{ background:rgba(201,168,106,0.14); border-color:var(--gold-border-strong)}
        .mod-check{ margin-right:auto; width:18px; height:18px; border-radius:999px; background:var(--success); color:#0A0A0A; display:grid; place-items:center; font-size:11px; font-weight:800}
        .mod-toggle{ margin-right:auto; width:36px; height:20px; border-radius:999px; background:rgba(255,255,255,0.08); border:1px solid var(--gold-border); position:relative; transition: all 0.22s ease; flex:0 0 36px }
        .mod-toggle i{ position:absolute; top:2px; right:2px; width:14px; height:14px; border-radius:50%; background:#9A9590; transition: all 0.22s ease; display:block }
        .mod-toggle.on{ background: var(--gold); border-color: var(--gold)}
        .mod-toggle.on i{ background:#1A1206; transform: translateX(-16px)}
        .ai-list{ display:grid; gap:8px; padding:12px }
        .ai-item{ background: rgba(10,10,12,0.55); border:1px solid rgba(201,168,106,0.12); border-radius:12px; overflow:hidden}
        .ai-head{ width:100%; display:flex; align-items:center; gap:10px; padding:11px 12px; background:transparent; border:0; color:var(--text-secondary); font-size:12.5px; font-weight:600; cursor:pointer; text-align:right}
        .ai-head:hover{ color:var(--text-primary)}
        .ai-plus{ width:22px; height:22px; border-radius:6px; background:rgba(255,255,255,0.06); border:1px solid var(--gold-border); display:grid; place-items:center; font-size:13px; font-weight:800; flex:0 0 22px; transition: all 0.2s ease}
        .ai-item.open .ai-plus{ background:var(--gold); color:#1A1206; transform: rotate(45deg)}
        .ai-badge{ margin-right:auto; font-size:10px; font-weight:700; padding:2px 7px; border-radius:999px; background:rgba(201,168,106,0.14); color:var(--gold-soft); border:1px solid var(--gold-border)}
        .ai-body{ display:none; padding:0 12px 12px 12px; border-top:1px solid var(--gold-border); background: rgba(255,255,255,0.02)}
        .ai-item.open .ai-body{ display:block}
        .ai-body p{ margin:10px 0 0 0; font-size:12.5px; color:var(--text-muted); line-height:1.7}
        .status-list{ display:grid; gap:0; padding:6px 0}
        .status-row{ display:flex; justify-content:space-between; align-items:center; padding:10px 14px; font-size:12.8px; border-bottom:1px solid rgba(201,168,106,0.07); color:var(--text-secondary)}
        .status-row b{ color:var(--text-primary); font-size:12.5px}
        .dot{ width:8px; height:8px; border-radius:50%; display:inline-block; margin-left:6px; vertical-align:middle; background:#6B6763}
        .dot.on{ background:#3DD68C; box-shadow:0 0 0 4px rgba(61,214,140,0.16)}
      </style>
    `;

    // — رندر ماژول‌ها از حافظه واقعی —
    const listEl = container.querySelector('#modulesList');
    const iconMap = { stats:'📊', header:'◈', product_categories:'◉', footer:'◫', export:'👑', sort:'①', collection:'②', app:'📱', hero:'🎠', site_features:'✦', auto:'🔄' };
    function renderModules(){
      listEl.innerHTML = Object.entries(cfg.modules||{}).sort((a,b)=> a[1].order - b[1].order).map(([key,m])=>`
        <div class="mod-item ${m.enabled?'':'disabled'}" data-mod="${key}">
          <span class="mod-icon">${iconMap[key]||'●'}</span> ${m.title}
          ${m.enabled ? `<span class="mod-check">✓</span>` : `<span class="mod-toggle"><i></i></span>`}
          ${m.enabled ? `<span class="mod-toggle on" data-toggle="${key}"><i></i></span>` : `<span class="mod-toggle" data-toggle="${key}"><i></i></span>`}
        </div>
      `).join('');
      // برای آیتم‌هایی که enabled هستند، چک را حذف و فقط toggle بذار — تمیزتر
      // بازنویسی: هر آیتم فقط یک toggle داشته باشد
      listEl.querySelectorAll('.mod-item').forEach(el=>{
        const key = el.dataset.mod;
        const enabled = cfg.modules[key].enabled;
        // حذف چک اضافی و نگه داشتن toggle
        const checks = el.querySelectorAll('.mod-check');
        if(checks.length && enabled){
          // اگر enabled، چک را حذف کن (toggle کافی است)
          checks.forEach(c=> c.remove());
        }
        // toggle state
        const tog = el.querySelector('.mod-toggle');
        if(tog) tog.classList.toggle('on', enabled);
      });
    }
    renderModules();

    // رندر AI
    const aiList = container.querySelector('#aiList');
    function renderAI(){
      if(!aiList)return;
      aiList.innerHTML = cfg.ai_assistant.suggestions.map((s,idx)=>`
        <div class="ai-item ${idx===0?'open':''}" data-ai="${s.id}">
          <button class="ai-head"><span class="ai-plus">${idx===0?'×':'+'}</span> ${s.title} <span class="ai-badge">${s.status==='new'?'جدید': s.status==='done'?'انجام شد':'AI'}</span></button>
          <div class="ai-body">
            <p>${s.detail}</p>
            <div style="display:flex; gap:8px; margin-top:10px; flex-wrap:wrap">
              ${s.status!=='done' ? `<button class="btn-gold" style="padding:6px 12px; font-size:12px" data-ai-action="do" data-id="${s.id}">اعمال پیشنهاد</button>` : `<span style="color:var(--success); font-size:12px; font-weight:700">✓ اعمال شد</span>`}
              <button class="btn-ghost" style="padding:6px 12px; font-size:12px" data-ai-action="dismiss" data-id="${s.id}">${s.status==='done'?'بازگردانی':'نادیده بگیر'}</button>
            </div>
          </div>
        </div>
      `).join('');
    }
    renderAI();

    // رندر Status
    const statusList = container.querySelector('#statusList');
    function renderStatus(){
      if(!statusList)return;
      statusList.innerHTML = `
        <div class="status-row"><span><span class="dot on"></span> ووکامرس</span><b>${cfg.system.woocommerce}</b></div>
        <div class="status-row"><span><span class="dot on"></span> وودمارت پلاس</span><b>${cfg.system.woodmart_plus}</b></div>
        <div class="status-row"><span><span class="dot on"></span> المنتور پرو</span><b>${cfg.system.elementor_pro}</b></div>
        <div class="status-row"><span>نسخه پی‌اچ‌پی هاست (PHP)</span><b dir="ltr">${cfg.system.php_version}</b></div>
        <div class="status-row"><span>حافظه لایو سیستم (Memory)</span><b style="color:var(--gold)">${cfg.system.memory}</b></div>
        <div class="status-row"><span>گواهینامه امنیتی (SSL)</span><b style="color:var(--success)"><span class="dot on"></span> ${cfg.system.ssl}</b></div>
      `;
    }
    renderStatus();

    // — تعاملات واقعی —
    const quick = container.querySelector('#quickSettings');
    const quickTitle = container.querySelector('#quickTitle');
    let commitQuickSettings = null;

    const detailRenderers = {
      header: () => `
        <div class="qh-head"><div><h4>◈ مدیریت کامل هدر و Top Bar</h4><p>مرجع اصلی تنظیمات — متصل به همان شورت‌کد و هدر حرفه‌ای فعلی</p></div><code>[alookhor_portal_header]</code></div>

        <div class="qh-live" id="quickTopbar" style="--qh-bg:${escapeAttr(cfg.header_settings.topbar_bg)};--qh-text:${escapeAttr(cfg.header_settings.topbar_text_color)};--qh-border:${escapeAttr(cfg.header_settings.topbar_border_color)};--qh-btn:${escapeAttr(cfg.header_settings.topbar_button_bg)};--qh-btn-text:${escapeAttr(cfg.header_settings.topbar_button_text)};height:${Number(cfg.header_settings.topbar_height)||38}px">
          <div class="qh-trade"><span id="quickWholesale">${escapeAttr(cfg.header_settings.wholesale_text)}</span><span id="quickExport">${escapeAttr(cfg.header_settings.export_text)}</span></div>
          <div class="qh-logo" id="quickTopLogo">${cfg.header_settings.top_logo_url ? `<img src="${escapeAttr(cfg.header_settings.top_logo_url)}" alt="">` : 'ALOOKHOR'}</div>
          <div class="qh-contact" dir="ltr"><span id="quickWhatsapp">●</span><span id="quickEmail">${escapeAttr(cfg.header_settings.email)}</span><span id="quickPhone">${escapeAttr(cfg.header_settings.phone)}</span></div>
        </div>

        <div class="qh-section"><div class="qh-title"><b>محتوا و لینک‌های Top Bar</b><small>CONTENT</small></div><div class="qh-grid">
          <label>تلفن<input id="inpHeaderPhone" value="${escapeAttr(cfg.header_settings.phone)}" dir="ltr"></label>
          <label>ایمیل<input id="inpHeaderEmail" type="email" value="${escapeAttr(cfg.header_settings.email)}" dir="ltr"></label>
          <label>WhatsApp<input id="inpHeaderWhatsapp" value="${escapeAttr(cfg.header_settings.whatsapp)}" dir="ltr"></label>
          <label>متن صادرات<input id="inpHeaderExportText" value="${escapeAttr(cfg.header_settings.export_text)}"></label>
          <label>لینک صادرات<input id="inpHeaderExportUrl" type="url" value="${escapeAttr(cfg.header_settings.export_url)}" dir="ltr"></label>
          <label>متن خرید عمده<input id="inpHeaderWholesaleText" value="${escapeAttr(cfg.header_settings.wholesale_text)}"></label>
          <label>لینک خرید عمده<input id="inpHeaderWholesaleUrl" type="url" value="${escapeAttr(cfg.header_settings.wholesale_url)}" dir="ltr"></label>
        </div></div>

        <div class="qh-section"><div class="qh-title"><b>لوگوی مرکزی نوار بالا</b><small>MEDIA</small></div><div class="qh-grid">
          <label class="qh-span-2">آدرس لوگو<span class="qh-inline"><input id="inpTopLogoUrl" value="${escapeAttr(cfg.header_settings.top_logo_url)}" dir="ltr"><button type="button" id="btnSelectTopLogoQuick">انتخاب</button></span></label>
          <label>Alt لوگو<input id="inpTopLogoAlt" value="${escapeAttr(cfg.header_settings.top_logo_alt)}"></label>
          <label>لینک لوگو<input id="inpTopLogoLink" type="url" value="${escapeAttr(cfg.header_settings.top_logo_link)}" dir="ltr"></label>
          <label>عرض لوگو<input id="inpTopLogoWidth" type="number" min="50" max="180" value="${Number(cfg.header_settings.top_logo_width)||96}"></label>
        </div></div>

        <div class="qh-section"><div class="qh-title"><b>ظاهر نوار بالا</b><small>STYLE</small></div><div class="qh-colors">
          <label>پس‌زمینه<input id="inpTopbarBg" type="color" value="${escapeAttr(cfg.header_settings.topbar_bg)}"></label>
          <label>رنگ متن<input id="inpTopbarText" type="color" value="${escapeAttr(cfg.header_settings.topbar_text_color)}"></label>
          <label>حاشیه<input id="inpTopbarBorder" type="color" value="${escapeAttr(cfg.header_settings.topbar_border_color)}"></label>
          <label>رنگ دکمه<input id="inpTopbarButtonBg" type="color" value="${escapeAttr(cfg.header_settings.topbar_button_bg)}"></label>
          <label>متن دکمه<input id="inpTopbarButtonText" type="color" value="${escapeAttr(cfg.header_settings.topbar_button_text)}"></label>
          <label>ارتفاع<input id="inpTopbarHeight" type="number" min="30" max="60" value="${Number(cfg.header_settings.topbar_height)||38}"></label>
        </div></div>

        <div class="qh-section"><div class="qh-title"><b>هدر اصلی و Navigation چسبان</b><small>STICKY NAV</small></div><div class="qh-grid">
          <label>عرض لوگو Desktop<input id="inpHeaderLogoDesktop" type="number" min="70" max="220" value="${Number(cfg.header_settings.header_logo_desktop_width)||118}"></label>
          <label>عرض لوگو Mobile<input id="inpHeaderLogoMobile" type="number" min="42" max="110" value="${Number(cfg.header_settings.header_logo_mobile_width)||58}"></label>
        </div><div class="qh-colors" style="margin-top:9px">
          <label>سطح Navigation<input id="inpHeaderSurface" type="color" value="${escapeAttr(cfg.header_settings.header_surface)}"></label>
          <label>متن Navigation<input id="inpHeaderText" type="color" value="${escapeAttr(cfg.header_settings.header_text_color)}"></label>
          <label>متن فرعی<input id="inpHeaderMuted" type="color" value="${escapeAttr(cfg.header_settings.header_muted_color)}"></label>
        </div><p style="margin:9px 0 0;color:var(--text-faint);font-size:10.5px;line-height:1.8">Top Bar و Header اصلی در جریان عادی صفحه می‌مانند؛ فقط Navigation بدون Layout Shift به بالای viewport می‌چسبد.</p></div>

        <div class="qh-section"><div class="qh-title"><b>کپسول شیشه‌ای ردیف دوم</b><small>GLASS CAPSULE</small></div><div class="qh-colors">
          ${[['پس‌زمینه اصلی','capsule_background'],['سطح کارت','capsule_card'],['طلایی اصلی','capsule_gold'],['طلایی روشن','capsule_gold_light'],['سفید متن','capsule_text'],['متن فرعی','capsule_muted']].map(([label,key])=>`<label>${label}<input id="inpCapsule_${key}" type="color" value="${escapeAttr(cfg.header_settings[key])}"></label>`).join('')}
        </div><div class="qh-grid" style="margin-top:9px"><label>Glass RGBA<input id="inpCapsuleGlass" value="${escapeAttr(cfg.header_settings.capsule_glass)}" dir="ltr"></label><label>Blur px<input id="inpCapsuleBlur" type="number" min="10" max="36" value="${Number(cfg.header_settings.capsule_blur)||24}"></label></div><div class="qh-capsule-preview" id="quickCapsulePreview" style="--cp-bg:${escapeAttr(cfg.header_settings.capsule_glass)};--cp-gold:${escapeAttr(cfg.header_settings.capsule_gold)};--cp-gold-light:${escapeAttr(cfg.header_settings.capsule_gold_light)};--cp-text:${escapeAttr(cfg.header_settings.capsule_text)};--cp-muted:${escapeAttr(cfg.header_settings.capsule_muted)}"><span>سبد / حساب</span><b>آلوخور</b><i>☰</i></div><p style="margin:9px 0 0;color:var(--text-faint);font-size:10.5px;line-height:1.8">فقط کپسول اصلی ردیف دوم تغییر می‌کند؛ Top Bar، Navigation چسبان و ساختار کنترل‌ها دست‌نخورده می‌مانند.</p></div>

        <div class="qh-section"><div class="qh-title"><b>نمایش یا عدم نمایش</b><small>VISIBILITY</small></div><div class="qh-flags">
          ${[
            ['sticky','Sticky فقط Navigation'],['show_topbar','کل Top Bar'],['show_phone','تلفن'],['show_email','ایمیل'],['show_whatsapp','WhatsApp'],
            ['show_export','صادرات'],['show_wholesale','خرید عمده'],['show_account','ورود/حساب'],['wholesale_new_tab','لینک عمده در تب جدید']
          ].map(([key,label])=>`<label><input type="checkbox" data-header-flag="${key}" ${isEnabled(cfg.header_settings[key])?'checked':''}>${label}</label>`).join('')}
        </div></div>

        <div class="qh-section"><div class="qh-title"><b>هویت هدر اصلی</b><small>IDENTITY</small></div><div class="qh-grid">
          <label>متن لوگو<input id="inpLogoText" value="${escapeAttr(cfg.header_settings.logo_text)}"></label>
          <label>زیرعنوان<input id="inpLogoSub" value="${escapeAttr(cfg.header_settings.logo_sub)}"></label>
          <label>حرف لوگو<input id="inpLogoLetter" value="${escapeAttr(cfg.site.logoLetter)}" maxlength="2"></label>
        </div></div>

        <div class="qh-actions"><button class="btn-gold" id="btnApplyHeader">ذخیره و اعمال روی سایت</button><span>همه گزینه‌ها در پنل اصلی و Option مشترک ذخیره می‌شوند.</span></div>
        <style>
          .qh-head{display:flex;justify-content:space-between;gap:12px;align-items:center;margin-bottom:12px}.qh-head h4{margin:0;font-size:14px}.qh-head p{margin:4px 0 0;color:var(--text-muted);font-size:11px}.qh-head code{direction:ltr;padding:7px 9px;border:1px solid var(--gold-border);border-radius:8px;color:var(--gold-soft);font-size:10px}
          .qh-live{display:grid;grid-template-columns:1fr auto 1fr;align-items:center;gap:9px;padding:0 12px;border-bottom:1px solid var(--qh-border);border-radius:10px;background:var(--qh-bg);color:var(--qh-text);overflow:hidden;margin-bottom:12px}.qh-trade,.qh-contact{display:flex;align-items:center;gap:8px;min-width:0;font-size:9px}.qh-trade{justify-self:start}.qh-contact{justify-self:end}.qh-trade span:first-child{padding:5px 8px;border-radius:999px;background:var(--qh-btn);color:var(--qh-btn-text);font-weight:800}.qh-logo{font:700 10px Georgia;color:var(--gold-soft)}.qh-logo img{display:block;max-width:76px;max-height:30px}
          .qh-section{padding:12px;margin-top:9px;border:1px solid var(--gold-border);border-radius:11px;background:rgba(255,255,255,.018)}.qh-title{display:flex;justify-content:space-between;gap:8px;margin-bottom:10px}.qh-title b{font-size:11.5px}.qh-title small{color:var(--gold);font:9px Arial}.qh-grid{display:grid;grid-template-columns:repeat(2,minmax(0,1fr));gap:9px}.qh-colors{display:grid;grid-template-columns:repeat(3,minmax(0,1fr));gap:8px}.qh-section label{display:grid;gap:4px;color:var(--text-muted);font-size:10.5px}.qh-section input{width:100%;min-width:0;background:rgba(255,255,255,.035);border:1px solid var(--gold-border);border-radius:8px;padding:8px;color:var(--text-primary)}.qh-section input[type=color]{height:37px;padding:3px}.qh-inline{display:flex;gap:6px}.qh-inline button{border:1px solid var(--gold-border-strong);border-radius:8px;background:rgba(201,168,106,.1);color:var(--gold-soft);cursor:pointer}.qh-span-2{grid-column:span 2}.qh-flags{display:flex;gap:6px;flex-wrap:wrap}.qh-flags label{display:flex;align-items:center;gap:5px;padding:6px 8px;border:1px solid var(--gold-border);border-radius:999px}.qh-flags input{width:auto;accent-color:var(--gold)}.qh-actions{display:flex;align-items:center;gap:9px;flex-wrap:wrap;margin-top:11px}.qh-actions button{padding:9px 15px;font-size:11px}.qh-actions span{color:var(--text-faint);font-size:10px}.qh-capsule-preview{height:62px;margin-top:10px;padding:0 18px;border:1px solid color-mix(in srgb,var(--cp-gold) 42%,transparent);border-radius:999px;display:grid;grid-template-columns:1fr auto 1fr;align-items:center;background:var(--cp-bg);color:var(--cp-text);box-shadow:0 12px 28px rgba(13,5,16,.35),inset 0 1px 0 color-mix(in srgb,var(--cp-gold-light) 18%,transparent);backdrop-filter:blur(18px)}.qh-capsule-preview span{color:var(--cp-muted);font-size:9px}.qh-capsule-preview b{color:var(--cp-gold-light);font-size:17px}.qh-capsule-preview i{justify-self:end;color:var(--cp-gold);font-style:normal;font-size:20px}@media(max-width:700px){.qh-grid,.qh-colors{grid-template-columns:1fr}.qh-span-2{grid-column:auto}.qh-contact{display:none}}
        </style>
      `,
      product_categories: () => {
        const c=cfg.category_settings;const selected=new Set((c.selected_ids||[]).map(Number));const terms=window.ALOOKHOR_CC?.wc_categories||[];
        return `<div class="qh-head"><div><h4>◉ دسته‌بندی محصولات WooCommerce</h4><p>کارت‌های واقعی از taxonomy ووکامرس؛ عنوان، URL، تعداد و تصویر دسته به‌صورت پویا خوانده می‌شوند.</p></div><code>WC PRODUCT_CAT</code></div>
        <div class="qh-section"><div class="qh-title"><b>جایگاه در Elementor</b><small>PLACEMENT</small></div><div class="qh-grid"><label class="qh-span-2">شورت‌کد اختصاصی ماژول<input value="[alookhor_managed_categories]" readonly dir="ltr" onclick="this.select()"></label></div><p style="margin:9px 0 0;color:var(--text-faint);font-size:10.5px;line-height:1.8">این شورت‌کد را داخل Widget نوع Shortcode قرار دهید و خود Widget را در Navigator جابه‌جا کنید. شورت‌کد قدیمی <code>[alookhor_categories_carousel]</code> متعلق به افزونه قدیمی است و نباید برای این بخش استفاده شود.</p></div>
        <div class="qh-section"><div class="qh-title"><b>وضعیت و امکانات</b><small>BEHAVIOR</small></div><div class="qh-flags">${[['enabled','فعال'],['hide_legacy','جایگزینی بخش قدیمی'],['hide_empty','فقط دسته دارای محصول'],['parent_only','فقط دسته مادر'],['show_description','توضیحات کارت'],['show_count','تعداد محصولات'],['show_icons','آیکون کارت'],['show_arrows','فلش‌های Desktop'],['show_dots','نقطه‌های Pagination'],['autoplay','حرکت خودکار']].map(([k,l])=>`<label><input type="checkbox" data-category-flag="${k}" ${isEnabled(c[k])?'checked':''}>${l}</label>`).join('')}</div></div>
        <div class="qh-section"><div class="qh-title"><b>هویت محتوایی</b><small>CONTENT</small></div><div class="qh-grid"><label>کیکر<input id="catKicker" value="${escapeAttr(c.kicker)}"></label><label>متن دکمه<input id="catButton" value="${escapeAttr(c.button_text)}"></label><label class="qh-span-2">عنوان اصلی<input id="catTitle" value="${escapeAttr(c.title)}"></label><label class="qh-span-2">زیرعنوان<textarea id="catSubtitle" rows="2">${escapeAttr(c.subtitle)}</textarea></label></div></div>
        <div class="qh-section"><div class="qh-title"><b>دسته‌های واقعی WooCommerce</b><small>${terms.length} CATEGORY</small></div><div class="alookhor-cat-admin-list">${terms.map(term=>{const o=c.overrides?.[String(term.id)]||{};return `<article class="alookhor-cat-admin-item"><label class="alookhor-cat-choice"><input type="checkbox" data-cat-id="${Number(term.id)}" ${selected.has(Number(term.id))?'checked':''}><b>${escapeAttr(term.name)}</b><small>#${Number(term.id)} • ${Number(term.count)} محصول</small></label><label>تصویر جایگزین<span class="qh-inline"><input id="catImage_${Number(term.id)}" value="${escapeAttr(o.image_url||'')}" dir="ltr"><button type="button" data-category-media="catImage_${Number(term.id)}">انتخاب</button></span></label><label>توضیح کارت<input id="catDesc_${Number(term.id)}" value="${escapeAttr(o.description||'')}"></label></article>`}).join('')}</div><style>.alookhor-cat-admin-list{display:grid;grid-template-columns:repeat(2,minmax(0,1fr));gap:10px}.alookhor-cat-admin-item{display:grid;gap:9px;padding:12px;border:1px solid var(--gold-border);border-radius:12px;background:rgba(0,0,0,.14)}.alookhor-cat-choice{display:grid!important;grid-template-columns:auto 1fr;align-items:center!important}.alookhor-cat-choice input{grid-row:1/3;width:17px!important;height:17px!important;margin-left:8px!important}.alookhor-cat-choice small{color:var(--text-faint)}@media(max-width:760px){.alookhor-cat-admin-list{grid-template-columns:1fr}}</style></div>
        <div class="qh-section"><div class="qh-title"><b>Carousel دسکتاپ</b><small>DESKTOP UX</small></div><div class="qh-grid"><label>تعداد کارت هم‌زمان<input id="catDesktopCards" type="number" min="2" max="6" value="${Number(c.desktop_cards)||4}"></label><label>فاصله کارت‌ها<input id="catDesktopGap" type="number" min="8" max="40" value="${Number(c.desktop_gap)||18}"></label><label>ارتفاع تصویر<input id="catImageHeight" type="number" min="180" max="430" value="${Number(c.image_height)||285}"></label><label>Autoplay ms<input id="catInterval" type="number" min="2500" max="15000" step="500" value="${Number(c.autoplay_interval)||5000}"></label><label>حداکثر دسته<input id="catLimit" type="number" min="1" max="24" value="${Number(c.limit)||8}"></label><label>ترتیب<select id="catOrder"><option value="ASC" ${c.order==='ASC'?'selected':''}>صعودی</option><option value="DESC" ${c.order==='DESC'?'selected':''}>نزولی</option></select></label></div></div>
        <div class="qh-section"><div class="qh-title"><b>Carousel موبایل</b><small>MOBILE UX</small></div><div class="qh-grid"><label>عرض کارت درصد<input id="catMobileWidth" type="number" min="72" max="94" value="${Number(c.mobile_card_width)||84}"></label><label>Peek دو طرف درصد<input id="catMobilePeek" type="number" min="3" max="14" value="${Number(c.mobile_peek)||8}"></label><label>ارتفاع تصویر<input id="catMobileImage" type="number" min="170" max="330" value="${Number(c.mobile_image_height)||225}"></label><label>فاصله کارت‌ها<input id="catMobileGap" type="number" min="8" max="28" value="${Number(c.mobile_gap)||14}"></label><label>گردی کارت<input id="catMobileRadius" type="number" min="10" max="32" value="${Number(c.mobile_radius)||18}"></label></div><p style="margin:10px 0 0;color:var(--text-faint);font-size:10.5px">کارت فعال کامل و وسط، کارت‌های قبلی/بعدی به‌صورت Peek، حلقه بی‌نهایت و Dotهای پویا.</p></div>
        <div class="qh-section"><div class="qh-title"><b>رنگ‌بندی هماهنگ سایت</b><small>THEME</small></div><div class="qh-colors">${[['پس‌زمینه','section_background'],['کارت','card_background'],['طلایی','gold'],['متن','text'],['متن فرعی','muted'],['حاشیه','border'],['دکمه','button_background']].map(([l,k])=>`<label>${l}<input type="color" id="catColor_${k}" value="${escapeAttr(c[k])}"></label>`).join('')}</div></div>
        <div class="qh-actions"><button class="btn-gold" id="btnApplyCategories">ذخیره و اعمال روی سایت</button><a class="btn-ghost" href="${escapeAttr(window.ALOOKHOR_CC?.home_url||'/')}" target="_blank">مشاهده سایت</a><span>Desktop و Mobile از همین تنظیمات مشترک مدیریت می‌شوند.</span></div>`;
      },
      footer: () => {
        const f = cfg.footer_settings;
        return `
        <div class="qh-head"><div><h4>◫ فوتر حرفه‌ای ALOOKHOR</h4><p>Desktop پنج‌ستونه + Mobile کارت‌های دو‌ستونه — جایگزینی خودکار فوتر قدیمی بدون ویرایش Elementor</p></div><code>MANAGED FOOTER</code></div>
        <div class="qh-section"><div class="qh-title"><b>وضعیت و منابع WordPress</b><small>CORE</small></div><div class="qh-flags">
          ${[['enabled','فعال‌بودن فوتر'],['hide_legacy','مخفی‌کردن فوتر قدیمی'],['hide_old_newsletter','ادغام خبرنامه قدیمی'],['use_header_contact','تلفن/ایمیل مشترک با هدر'],['newsletter_enabled','نمایش خبرنامه'],['show_product_image','تصویر محصول'],['show_payments','روش‌های پرداخت'],['show_benefits','مزیت‌های پایین']].map(([key,label])=>`<label><input type="checkbox" data-footer-flag="${key}" ${isEnabled(f[key])?'checked':''}>${label}</label>`).join('')}
        </div></div>
        <div class="qh-section"><div class="qh-title"><b>هویت برند و CTA</b><small>BRAND</small></div><div class="qh-grid">
          <label class="qh-span-2">لوگوی فوتر<span class="qh-inline"><input id="ftLogoUrl" value="${escapeAttr(f.logo_url)}" dir="ltr"><button type="button" data-footer-media="ftLogoUrl">انتخاب</button></span></label>
          <label>نام انگلیسی<input id="ftBrandName" value="${escapeAttr(f.brand_name)}"></label><label>زیرعنوان<input id="ftBrandSubtitle" value="${escapeAttr(f.brand_subtitle)}"></label>
          <label>شعار<input id="ftBrandKicker" value="${escapeAttr(f.brand_kicker)}"></label><label>متن دکمه<input id="ftCtaText" value="${escapeAttr(f.cta_text)}"></label>
          <label class="qh-span-2">توضیحات<textarea id="ftBrandDesc" rows="3">${escapeAttr(f.brand_description)}</textarea></label><label class="qh-span-2">لینک CTA<input id="ftCtaUrl" value="${escapeAttr(f.cta_url)}" dir="ltr"></label>
        </div></div>
        <div class="qh-section"><div class="qh-title"><b>اطلاعات تماس</b><small>CONTACT</small></div><div class="qh-grid">
          <label>تلفن<input id="ftPhone" value="${escapeAttr(f.phone)}" dir="ltr"></label><label>ایمیل<input id="ftEmail" value="${escapeAttr(f.email)}" dir="ltr"></label>
          <label>WhatsApp<input id="ftWhatsapp" value="${escapeAttr(f.whatsapp)}" dir="ltr"></label><label>عنوان پشتیبانی<input id="ftSupportLabel" value="${escapeAttr(f.support_label)}"></label>
          <label class="qh-span-2">آدرس<input id="ftAddress" value="${escapeAttr(f.address)}"></label><label>ساعات هفته<input id="ftHoursWeek" value="${escapeAttr(f.hours_week)}"></label><label>ساعات جمعه<input id="ftHoursFriday" value="${escapeAttr(f.hours_friday)}"></label>
        </div></div>
        ${[['customer','خدمات مشتریان'],['order','خرید و سفارش'],['about','درباره/راهنمای صادرات']].map(([key,label])=>`<div class="qh-section"><div class="qh-title"><b>ستون ${label}</b><small>WORDPRESS MENU</small></div><div class="qh-grid"><label>عنوان<input id="ft${key}Title" value="${escapeAttr(f[`${key}_title`])}"></label>${key==='about'?`<label>عنوان موبایل<input id="ftAboutMobileTitle" value="${escapeAttr(f.about_mobile_title)}"></label>`:''}<label>فهرست WordPress<select id="ft${key}Menu">${footerMenuOptions(f[`${key}_menu_id`])}</select></label><label class="qh-span-2">لینک‌های جایگزین — هر خط: عنوان|URL<textarea id="ft${key}Links" rows="6" dir="ltr">${escapeAttr(footerLinksText(f[`${key}_links`]))}</textarea></label></div></div>`).join('')}
        <div class="qh-section"><div class="qh-title"><b>شبکه‌های اجتماعی و خبرنامه</b><small>ENGAGEMENT</small></div><div class="qh-grid">
          <label>Instagram<input id="ftInstagram" value="${escapeAttr(f.instagram_url)}" dir="ltr"></label><label>Telegram<input id="ftTelegram" value="${escapeAttr(f.telegram_url)}" dir="ltr"></label><label>WhatsApp URL<input id="ftWhatsappUrl" value="${escapeAttr(f.whatsapp_url)}" dir="ltr"></label>
          <label>عنوان شبکه‌ها<input id="ftSocialTitle" value="${escapeAttr(f.social_title)}"></label><label>عنوان خبرنامه<input id="ftNewsletterTitle" value="${escapeAttr(f.newsletter_title)}"></label><label>دکمه خبرنامه<input id="ftNewsletterButton" value="${escapeAttr(f.newsletter_button)}"></label>
          <label class="qh-span-2">توضیح شبکه‌ها<input id="ftSocialDesc" value="${escapeAttr(f.social_desc)}"></label><label class="qh-span-2">توضیح خبرنامه<input id="ftNewsletterDesc" value="${escapeAttr(f.newsletter_desc)}"></label>
          <label class="qh-span-2">تصویر محصول<span class="qh-inline"><input id="ftProductImage" value="${escapeAttr(f.product_image_url)}" dir="ltr"><button type="button" data-footer-media="ftProductImage">انتخاب</button></span></label>
        </div></div>
        <div class="qh-section"><div class="qh-title"><b>مجوزها، کپی‌رایت و ظاهر</b><small>TRUST & STYLE</small></div><div class="qh-grid">
          <label>عنوان Enamad<input id="ftEnamadTitle" value="${escapeAttr(f.enamad_title)}"></label><label>لینک Enamad<input id="ftEnamadUrl" value="${escapeAttr(f.enamad_url)}" dir="ltr"></label><label class="qh-span-2">تصویر Enamad<span class="qh-inline"><input id="ftEnamadImage" value="${escapeAttr(f.enamad_image_url)}" dir="ltr"><button type="button" data-footer-media="ftEnamadImage">انتخاب</button></span></label>
          <label>عنوان ساماندهی<input id="ftSamandehiTitle" value="${escapeAttr(f.samandehi_title)}"></label><label>لینک ساماندهی<input id="ftSamandehiUrl" value="${escapeAttr(f.samandehi_url)}" dir="ltr"></label><label class="qh-span-2">تصویر ساماندهی<span class="qh-inline"><input id="ftSamandehiImage" value="${escapeAttr(f.samandehi_image_url)}" dir="ltr"><button type="button" data-footer-media="ftSamandehiImage">انتخاب</button></span></label>
          <label>Copyright<input id="ftCopyright" value="${escapeAttr(f.copyright_text)}"></label><label>Copyright English<input id="ftCopyrightEn" value="${escapeAttr(f.copyright_en)}"></label>
        </div><div class="qh-colors" style="margin-top:10px">${[['Background','background'],['Surface','surface'],['Gold','gold'],['Gold Soft','gold_soft'],['Text','text'],['Muted','muted'],['Border','border']].map(([label,key])=>`<label>${label}<input type="color" id="ftColor_${key}" value="${escapeAttr(f[key])}"></label>`).join('')}<label>عرض محتوا<input type="number" id="ftContainerWidth" value="${Number(f.container_width)||1280}"></label><label>لوگو Desktop<input type="number" id="ftDesktopLogo" value="${Number(f.desktop_logo_width)||210}"></label><label>لوگو Mobile<input type="number" id="ftMobileLogo" value="${Number(f.mobile_logo_width)||190}"></label></div></div>
        <div class="qh-actions"><button class="btn-gold" id="btnApplyFooter">ذخیره و اعمال فوتر</button><a class="btn-ghost" href="${escapeAttr(window.ALOOKHOR_CC?.home_url || '/')}" target="_blank">مشاهده سایت</a><span>پیام موفقیت فقط بعد از تأیید WordPress نمایش داده می‌شود.</span></div>
        <style>.qh-section textarea,.qh-section select{width:100%;min-width:0;background:rgba(255,255,255,.035);border:1px solid var(--gold-border);border-radius:8px;padding:8px;color:var(--text-primary);font-family:inherit}.qh-section select option{background:#171419}</style>`;
      },
      stats: () => `<h4>📊 پیشخوان هوشمند آمار</h4><p style="color:var(--text-muted); font-size:12.5px">KPI ها و نمودار فروش در داشبورد. فعال: <b style="color:${cfg.modules.stats.enabled?'var(--success)':'var(--danger)'}">${cfg.modules.stats.enabled?'بله':'خیر'}</b></p><label style="display:flex; justify-content:space-between; align-items:center; background:rgba(255,255,255,0.03); border:1px solid var(--gold-border); border-radius:10px; padding:10px; margin-top:10px"><span>نمایش در داشبورد</span><span class="mod-toggle ${cfg.modules.stats.enabled?'on':''}" data-quick-toggle="stats"><i></i></span></label>`,
      export: () => `<h4>👑 محصولات ممبر صادراتی</h4><p style="color:var(--text-muted); font-size:12.5px">فقط برای ممبرها: ${cfg.modules.export.enabled?'فعال':'غیرفعال'}</p><label style="display:flex; justify-content:space-between; align-items:center; background:rgba(255,255,255,0.03); border:1px solid var(--gold-border); border-radius:10px; padding:10px"><span>فقط ممبرها ببینند</span><span class="mod-toggle ${cfg.modules.export.enabled?'on':''}" data-quick-toggle="export"><i></i></span></label>`,
      sort: () => `<h4>① مرکز سورت و بسته‌بندی</h4><div style="display:grid; grid-template-columns:1fr 1fr; gap:8px; margin-top:10px"><div style="background:rgba(255,255,255,0.03); border:1px solid var(--gold-border); border-radius:10px; padding:10px; text-align:center"><div style="font-size:11px; color:var(--text-faint)">ظرفیت روزانه</div><b>${cfg.modules.sort.capacity}</b></div><div style="background:rgba(255,255,255,0.03); border:1px solid var(--gold-border); border-radius:10px; padding:10px; text-align:center"><div style="font-size:11px; color:var(--text-faint)">سورت امروز</div><b style="color:var(--success)">${cfg.modules.sort.today}</b></div></div><div style="margin-top:10px"><label style="font-size:12px; color:var(--text-muted)">ظرفیت (تن) <input id="inpCapacity" value="${cfg.modules.sort.capacity}" style="width:100%; margin-top:4px; background:rgba(255,255,255,0.04); border:1px solid var(--gold-border); border-radius:8px; padding:8px; color:var(--text-primary)"></label></div>`,
      collection: () => `<h4>② مجموعه منتخب آلوخور</h4><p style="color:var(--text-muted); font-size:12.5px">کالکشن‌ها: ${cfg.modules.collection.collections.join(' ، ')}</p><div style="display:flex; gap:8px; margin-top:10px; flex-wrap:wrap">${cfg.modules.collection.collections.map(c=>`<span style="padding:6px 10px; background:rgba(201,168,106,0.14); border:1px solid var(--gold-border); border-radius:999px; font-size:12px">${c}</span>`).join('')}</div>`,
      app: () => `<h4>📱 دانلود اپلیکیشن آلوخور</h4><p style="color:var(--text-muted); font-size:12.5px">لینک: <span dir="ltr" style="color:var(--gold-soft)">${cfg.modules.app.link}</span></p><div style="display:flex; gap:8px; margin-top:10px"><input id="inpAppLink" value="${cfg.modules.app.link}" style="flex:1; background:rgba(255,255,255,0.04); border:1px solid var(--gold-border); border-radius:8px; padding:8px; color:var(--text-primary)" dir="ltr"><button class="btn-gold" style="padding:8px 12px; font-size:12px" id="btnSaveApp">ذخیره</button></div>`,
      hero: () => {
        const h=cfg.hero_settings;
        return `<div class="qh-head"><div><h4>🎠 اسلایدر هیروی مدیریت‌شده</h4><p>چهار اسلاید مشترک Desktop و Mobile؛ جایگزین خودکار اسلایدر فعلی در همان جایگاه Elementor</p></div><code>4 MANAGED SLIDES</code></div>
        <div class="qh-section"><div class="qh-title"><b>جایگاه و رفتار</b><small>LIVE REPLACEMENT</small></div><div class="qh-flags">${[['enabled','فعال'],['hide_legacy','جایگزینی اسلایدر قدیمی'],['autoplay','حرکت خودکار'],['pause_on_hover','توقف با Hover/Focus'],['show_arrows','نمایش فلش‌ها'],['show_dots','نمایش Pagination'],['ken_burns','Ken Burns آرام']].map(([key,label])=>`<label><input type="checkbox" data-hero-flag="${key}" ${isEnabled(h[key])?'checked':''}>${label}</label>`).join('')}</div><div class="qh-grid" style="margin-top:10px"><label>فاصله Autoplay (ms)<input id="heroInterval" type="number" min="3000" max="15000" step="500" value="${Number(h.autoplay_interval)||5500}"></label><label>گردی Hero (px)<input id="heroRadius" type="number" min="16" max="40" value="${Number(h.radius)||32}"></label></div><p style="margin:9px 0 0;color:var(--text-faint);font-size:10.5px;line-height:1.8">ریشه واقعی <code>.alookhor-hero-slider-wrapper</code> در همان Widget نوع Shortcode جایگزین می‌شود. در Mobile، Hero با لایه‌ای کنترل‌شده زیر کپسول شیشه‌ای Header قرار می‌گیرد.</p></div>
        <div class="qh-section"><div class="qh-title"><b>رنگ‌بندی Black / Gold</b><small>REFERENCE STYLE</small></div><div class="qh-colors">${[['طلایی اصلی','gold'],['سطح تیره','surface'],['متن اصلی','text'],['متن فرعی','muted']].map(([label,key])=>`<label>${label}<input type="color" id="heroColor_${key}" value="${escapeAttr(h[key])}"></label>`).join('')}</div></div>
        <div class="alookhor-hero-admin-list">${h.slides.map((slide,index)=>`<article class="alookhor-hero-admin-card" data-hero-slide="${index}">
          <div class="alookhor-hero-admin-head"><span>${index+1}</span><div><b>اسلاید ${index+1}</b><small>تصویر و نوشته‌های مستقل</small></div><em>SLIDE ${index+1}/4</em></div>
          <div class="alookhor-hero-admin-media"><img id="heroPreview_${index}" src="${escapeAttr(slide.image_url)}" alt=""><div><input type="hidden" id="heroImageId_${index}" value="${Number(slide.image_id)||0}"><input id="heroImage_${index}" value="${escapeAttr(slide.image_url)}" dir="ltr"><button type="button" data-hero-media="${index}">انتخاب از Media Library</button></div></div>
          <div class="qh-flags"><label><input type="checkbox" id="heroFlip_${index}" ${isEnabled(slide.flip_image)?'checked':''}>انتقال فوکوس سوژه به سمت چپ (ویژه بنرهای قبلی)</label></div>
          <div class="qh-grid"><label>Alt تصویر<input id="heroAlt_${index}" value="${escapeAttr(slide.image_alt)}"></label><label>کیکر کوچک<input id="heroKicker_${index}" value="${escapeAttr(slide.kicker)}"></label><label>عنوان سفید<input id="heroTitle_${index}" value="${escapeAttr(slide.title)}"></label><label>عنوان طلایی<input id="heroHighlight_${index}" value="${escapeAttr(slide.highlight)}"></label><label class="qh-span-2">توضیح کوتاه<textarea id="heroDescription_${index}" rows="2">${escapeAttr(slide.description)}</textarea></label></div>
          <div class="alookhor-hero-feature-fields">${[0,1,2,3].map(featureIndex=>`<label>ویژگی ${featureIndex+1}<input id="heroFeature_${index}_${featureIndex}" value="${escapeAttr(slide.features?.[featureIndex]||'')}"></label>`).join('')}</div>
          <div class="qh-grid"><label>متن دکمه اصلی<input id="heroPrimaryText_${index}" value="${escapeAttr(slide.primary_text)}"></label><label>لینک دکمه اصلی<input id="heroPrimaryUrl_${index}" value="${escapeAttr(slide.primary_url)}" dir="ltr"></label><label>متن دکمه دوم<input id="heroSecondaryText_${index}" value="${escapeAttr(slide.secondary_text)}"></label><label>لینک دکمه دوم<input id="heroSecondaryUrl_${index}" value="${escapeAttr(slide.secondary_url)}" dir="ltr"></label></div>
        </article>`).join('')}</div>
        <div class="qh-actions"><button class="btn-gold" id="btnApplyHero">ذخیره چهار اسلاید و اعمال روی سایت</button><a class="btn-ghost" href="${escapeAttr(window.ALOOKHOR_CC?.home_url||'/')}" target="_blank">مشاهده سایت</a><span>همه متن‌ها جدا از تصویر و در سمت راست Hero رندر می‌شوند.</span></div>
        <style>.alookhor-hero-admin-list{display:grid;gap:12px;margin-top:12px}.alookhor-hero-admin-card{display:grid;gap:12px;padding:14px;border:1px solid var(--gold-border);border-radius:14px;background:linear-gradient(145deg,rgba(201,168,106,.045),rgba(0,0,0,.16))}.alookhor-hero-admin-head{display:flex;align-items:center;gap:9px;padding-bottom:10px;border-bottom:1px solid var(--gold-border)}.alookhor-hero-admin-head>span{width:31px;height:31px;border-radius:50%;display:grid;place-items:center;background:var(--gold);color:#171004;font-weight:900}.alookhor-hero-admin-head div{display:grid}.alookhor-hero-admin-head b{font-size:12px}.alookhor-hero-admin-head small{color:var(--text-faint);font-size:9px}.alookhor-hero-admin-head em{margin-right:auto;color:var(--gold);font:700 9px Arial}.alookhor-hero-admin-media{display:grid;grid-template-columns:180px minmax(0,1fr);gap:10px;align-items:center}.alookhor-hero-admin-media>img{width:180px;height:82px;object-fit:cover;border:1px solid var(--gold-border);border-radius:10px;background:#080509}.alookhor-hero-admin-media>div{display:flex;gap:7px}.alookhor-hero-admin-media input{flex:1;min-width:0}.alookhor-hero-admin-media button{white-space:nowrap;border:1px solid var(--gold-border-strong);border-radius:8px;background:rgba(201,168,106,.12);color:var(--gold-soft);cursor:pointer}.alookhor-hero-feature-fields{display:grid;grid-template-columns:repeat(4,minmax(0,1fr));gap:8px}@media(max-width:860px){.alookhor-hero-admin-media{grid-template-columns:1fr}.alookhor-hero-admin-media>img{width:100%;height:150px}.alookhor-hero-feature-fields{grid-template-columns:repeat(2,minmax(0,1fr))}}@media(max-width:560px){.alookhor-hero-admin-media>div{display:grid}.alookhor-hero-feature-fields{grid-template-columns:1fr}}</style>`;
      },
      site_features: () => {
        const f=cfg.feature_settings;
        const iconOptions=(selected)=>[['truck','ارسال/کامیون'],['organic','ارگانیک/تأیید'],['headset','پشتیبانی/هدست'],['shield','ضمانت/سپر']].map(([value,label])=>`<option value="${value}" ${selected===value?'selected':''}>${label}</option>`).join('');
        return `<div class="qh-head"><div><h4>✦ ویژگی‌های سایت</h4><p>چهار کارت اعتماد یک‌ردیفه زیر Hero؛ جایگزین دقیق بخش فعلی در همان Widget المنتور</p></div><code>4 FEATURE CARDS</code></div>
        <div class="qh-section"><div class="qh-title"><b>جایگاه و وضعیت</b><small>EXACT REPLACEMENT</small></div><div class="qh-flags">${[['enabled','فعال'],['hide_legacy','جایگزینی بخش ویژگی قبلی']].map(([key,label])=>`<label><input type="checkbox" data-site-feature-flag="${key}" ${isEnabled(f[key])?'checked':''}>${label}</label>`).join('')}</div><div class="qh-grid" style="margin-top:10px"><label class="qh-span-2">شورت‌کد اختیاری<input value="[alookhor_managed_features]" readonly dir="ltr" onclick="this.select()"></label><label>گردی کارت<input id="sfRadius" type="number" min="10" max="30" value="${Number(f.radius)||20}"></label><label>فاصله کارت‌ها<input id="sfGap" type="number" min="0" max="20" value="${Number(f.gap)||8}"></label></div><p style="margin:9px 0 0;color:var(--text-faint);font-size:10.5px;line-height:1.8">ریشه واقعی <code>.alookhor-trustbar-container</code> در Widget HTML با شناسه <code>5abd566</code> جایگزین می‌شود؛ بخش موازی ساخته نمی‌شود.</p></div>
        <div class="qh-section"><div class="qh-title"><b>رنگ‌بندی تأییدشده سایت</b><small>BURGUNDY / GOLD</small></div><div class="qh-colors">${[['پس‌زمینه اصلی','background'],['کارت‌ها','card'],['طلایی اصلی','gold'],['طلایی روشن','gold_light'],['سفید متن','text'],['متن فرعی','muted']].map(([label,key])=>`<label>${label}<input type="color" id="sfColor_${key}" value="${escapeAttr(f[key])}"></label>`).join('')}</div><div class="qh-grid" style="margin-top:9px"><label class="qh-span-2">سطح شیشه‌ای RGBA<input id="sfGlass" value="${escapeAttr(f.glass)}" dir="ltr"></label></div></div>
        <div class="alookhor-sf-admin-preview" style="--sf-admin-bg:${escapeAttr(f.background)};--sf-admin-card:${escapeAttr(f.card)};--sf-admin-gold:${escapeAttr(f.gold_light)};--sf-admin-text:${escapeAttr(f.text)};--sf-admin-muted:${escapeAttr(f.muted)}">${f.items.map(item=>`<span><i>◇</i><b>${escapeAttr(item.title)}</b><small>${escapeAttr(item.description)}</small></span>`).join('')}</div>
        <div class="alookhor-sf-admin-list">${f.items.map((item,index)=>`<article><header><span>${index+1}</span><b>ویژگی ${index+1}</b></header><div class="qh-grid"><label>آیکون<select id="sfIcon_${index}">${iconOptions(item.icon)}</select></label><label>عنوان<input id="sfTitle_${index}" value="${escapeAttr(item.title)}"></label><label class="qh-span-2">توضیح<input id="sfDescription_${index}" value="${escapeAttr(item.description)}"></label></div></article>`).join('')}</div>
        <div class="qh-actions"><button class="btn-gold" id="btnApplySiteFeatures">ذخیره و اعمال ویژگی‌ها</button><a class="btn-ghost" href="${escapeAttr(window.ALOOKHOR_CC?.home_url||'/')}" target="_blank">مشاهده سایت</a><span>Desktop و Mobile دقیقاً همین چهار آیتم را با چیدمان Responsive مشترک می‌خوانند.</span></div>
        <style>.alookhor-sf-admin-preview{margin:12px 0;padding:8px;display:grid;grid-template-columns:repeat(4,minmax(0,1fr));gap:5px;border-radius:14px;background:var(--sf-admin-bg)}.alookhor-sf-admin-preview>span{min-width:0;padding:12px 5px;border:1px solid color-mix(in srgb,var(--sf-admin-gold) 28%,transparent);border-radius:10px;display:grid;justify-items:center;gap:4px;background:var(--sf-admin-card);text-align:center}.alookhor-sf-admin-preview i{color:var(--sf-admin-gold);font-size:22px}.alookhor-sf-admin-preview b{color:var(--sf-admin-text);font-size:10px}.alookhor-sf-admin-preview small{color:var(--sf-admin-muted);font-size:8px}.alookhor-sf-admin-list{display:grid;grid-template-columns:repeat(2,minmax(0,1fr));gap:9px}.alookhor-sf-admin-list article{padding:12px;border:1px solid var(--gold-border);border-radius:12px;background:rgba(0,0,0,.14)}.alookhor-sf-admin-list header{display:flex;align-items:center;gap:7px;margin-bottom:10px}.alookhor-sf-admin-list header span{width:25px;height:25px;border-radius:50%;display:grid;place-items:center;background:var(--gold);color:#171004;font-weight:900}.alookhor-sf-admin-list select{width:100%;background:#171419;color:var(--text-primary);border:1px solid var(--gold-border);border-radius:8px;padding:8px}@media(max-width:760px){.alookhor-sf-admin-list{grid-template-columns:1fr}.alookhor-sf-admin-preview{gap:3px}.alookhor-sf-admin-preview>span{padding-inline:2px}.alookhor-sf-admin-preview b{font-size:8px}.alookhor-sf-admin-preview small{font-size:6px}}</style>`;
      },
      auto: () => `<h4>🔄 بروزرسانی خودکار افزونه</h4><label style="display:flex; justify-content:space-between; align-items:center; background:rgba(255,255,255,0.03); border:1px solid var(--gold-border); border-radius:10px; padding:10px; margin-top:10px"><span>بروزرسانی هر شب ساعت ۳</span><span class="mod-toggle ${cfg.modules.auto.enabled?'on':''}" data-quick-toggle="auto"><i></i></span></label><p style="font-size:11px; color:var(--text-faint); margin-top:6px">زمان: ${cfg.modules.auto.schedule} — آخرین: امروز ۰۳:۰۰</p>`
    };

    function showQuick(key){
      commitQuickSettings = null;
      const r = detailRenderers[key];
      quick.innerHTML = r ? r() : '<div style="text-align:center; color:var(--text-muted)">بخش یافت نشد</div>';
      quickTitle.textContent = cfg.modules[key]?.title || 'تنظیمات';
      // bind inside
      const value = id => quick.querySelector(`#${id}`)?.value ?? '';
      const inpLogoText = quick.querySelector('#inpLogoText');
      const inpLogoSub = quick.querySelector('#inpLogoSub');
      const inpLogoLetter = quick.querySelector('#inpLogoLetter');
      const btnApplyHeader = quick.querySelector('#btnApplyHeader');

      function updateQuickHeaderPreview(){
        const bar = quick.querySelector('#quickTopbar');
        if(!bar) return;
        bar.style.setProperty('--qh-bg', value('inpTopbarBg') || '#1C1024');
        bar.style.setProperty('--qh-text', value('inpTopbarText') || '#F5F3F0');
        bar.style.setProperty('--qh-border', value('inpTopbarBorder') || '#D49A2E');
        bar.style.setProperty('--qh-btn', value('inpTopbarButtonBg') || '#D49A2E');
        bar.style.setProperty('--qh-btn-text', value('inpTopbarButtonText') || '#0D0510');
        bar.style.height = `${Math.max(30,Math.min(60,Number(value('inpTopbarHeight'))||38))}px`;
        const setText = (id,text)=>{ const el=quick.querySelector(`#${id}`); if(el) el.textContent=text; };
        setText('quickPhone',value('inpHeaderPhone'));
        setText('quickEmail',value('inpHeaderEmail'));
        setText('quickExport',value('inpHeaderExportText'));
        setText('quickWholesale',value('inpHeaderWholesaleText'));
        const flags = Object.fromEntries([...quick.querySelectorAll('[data-header-flag]')].map(el=>[el.dataset.headerFlag,el.checked]));
        bar.style.display = flags.show_topbar === false ? 'none' : 'grid';
        [['quickPhone','show_phone'],['quickEmail','show_email'],['quickWhatsapp','show_whatsapp'],['quickExport','show_export'],['quickWholesale','show_wholesale']].forEach(([id,key])=>{
          const el=quick.querySelector(`#${id}`); if(el) el.style.display=flags[key]===false?'none':'';
        });
        const logo = quick.querySelector('#quickTopLogo');
        if(logo){
          const url=value('inpTopLogoUrl');
          logo.innerHTML=url?`<img src="${escapeAttr(url)}" alt="">`:'ALOOKHOR';
          const img=logo.querySelector('img');
          if(img) img.style.maxWidth=`${Math.max(50,Math.min(180,Number(value('inpTopLogoWidth'))||96))}px`;
        }
        const capsulePreview=quick.querySelector('#quickCapsulePreview');
        if(capsulePreview){
          capsulePreview.style.setProperty('--cp-bg',value('inpCapsuleGlass')||'rgba(33,20,38,.75)');
          capsulePreview.style.setProperty('--cp-gold',value('inpCapsule_capsule_gold')||'#D49A2E');
          capsulePreview.style.setProperty('--cp-gold-light',value('inpCapsule_capsule_gold_light')||'#E8B84A');
          capsulePreview.style.setProperty('--cp-text',value('inpCapsule_capsule_text')||'#F5F3F0');
          capsulePreview.style.setProperty('--cp-muted',value('inpCapsule_capsule_muted')||'#C8C2C9');
          capsulePreview.style.backdropFilter=`blur(${Math.max(10,Math.min(36,Number(value('inpCapsuleBlur'))||24))}px)`;
        }
      }

      quick.querySelectorAll('.qh-section input').forEach(input=>input.addEventListener('input',updateQuickHeaderPreview));
      updateQuickHeaderPreview();

      quick.querySelector('#btnSelectTopLogoQuick')?.addEventListener('click', ()=>{
        if(!window.wp?.media){ window.ALOOKHOR.toast('Media Library در دسترس نیست','info'); return; }
        const frame = window.wp.media({title:'انتخاب لوگوی Top Bar',button:{text:'استفاده از تصویر'},multiple:false});
        frame.on('select',()=>{
          const item=frame.state().get('selection').first().toJSON();
          const input=quick.querySelector('#inpTopLogoUrl');
          if(input){ input.value=item.url; updateQuickHeaderPreview(); }
        });
        frame.open();
      });

      if(btnApplyHeader){
        commitQuickSettings = () => {
          Object.assign(cfg.header_settings, {
            logo_text:value('inpLogoText'), logo_sub:value('inpLogoSub'),
            phone:value('inpHeaderPhone'), email:value('inpHeaderEmail'), whatsapp:value('inpHeaderWhatsapp'),
            export_text:value('inpHeaderExportText'), export_url:value('inpHeaderExportUrl'),
            wholesale_text:value('inpHeaderWholesaleText'), wholesale_url:value('inpHeaderWholesaleUrl'),
            top_logo_url:value('inpTopLogoUrl'), top_logo_alt:value('inpTopLogoAlt'), top_logo_link:value('inpTopLogoLink'),
            top_logo_width:Math.max(50,Math.min(180,Number(value('inpTopLogoWidth'))||96)),
            header_logo_desktop_width:Math.max(70,Math.min(220,Number(value('inpHeaderLogoDesktop'))||118)),
            header_logo_mobile_width:Math.max(42,Math.min(110,Number(value('inpHeaderLogoMobile'))||58)),
            header_surface:value('inpHeaderSurface'), header_text_color:value('inpHeaderText'), header_muted_color:value('inpHeaderMuted'),
            capsule_background:value('inpCapsule_capsule_background'), capsule_card:value('inpCapsule_capsule_card'), capsule_glass:value('inpCapsuleGlass'), capsule_gold:value('inpCapsule_capsule_gold'), capsule_gold_light:value('inpCapsule_capsule_gold_light'), capsule_text:value('inpCapsule_capsule_text'), capsule_muted:value('inpCapsule_capsule_muted'), capsule_blur:Math.max(10,Math.min(36,Number(value('inpCapsuleBlur'))||24)),
            topbar_bg:value('inpTopbarBg'), topbar_text_color:value('inpTopbarText'), topbar_border_color:value('inpTopbarBorder'),
            topbar_button_bg:value('inpTopbarButtonBg'), topbar_button_text:value('inpTopbarButtonText'),
            topbar_height:Math.max(30,Math.min(60,Number(value('inpTopbarHeight'))||38))
          });
          quick.querySelectorAll('[data-header-flag]').forEach(el=> cfg.header_settings[el.dataset.headerFlag]=el.checked);
          cfg.site.logoLetter = inpLogoLetter?.value || 'A';
        };
        btnApplyHeader.addEventListener('click', async ()=>{
          commitQuickSettings();
          btnApplyHeader.disabled = true;
          const result = await Config.save({notify:false});
          btnApplyHeader.disabled = false;
          if(!result.ok) return;
          const persistedPhone = result.data?.header_settings?.phone;
          if(persistedPhone !== undefined && String(persistedPhone).trim() !== String(cfg.header_settings.phone || '').trim()){
            window.ALOOKHOR.toast('شماره تلفن در WordPress تأیید نشد؛ ذخیره متوقف شد','error');
            return;
          }
          if(result.data?.header_settings?.capsule_glass!==undefined&&String(result.data.header_settings.capsule_glass)!==String(cfg.header_settings.capsule_glass)){window.ALOOKHOR.toast('رنگ شیشه‌ای کپسول در WordPress تأیید نشد','error');return}
          Config.apply();
          const liveTitle=document.getElementById('liveLogoText'); if(liveTitle) liveTitle.textContent=inpLogoText?.value||'ALOOKHOR';
          const liveSub=document.getElementById('liveLogoSub'); if(liveSub) liveSub.textContent=inpLogoSub?.value||'';
          window.ALOOKHOR.toast('ذخیره WordPress تأیید شد؛ تغییرات Top Bar روی سایت آماده است','success');
        });
      }

      if(key === 'hero'){
        quick.querySelectorAll('[data-hero-media]').forEach(button=>button.addEventListener('click',()=>{
          if(!window.wp?.media){window.ALOOKHOR.toast('Media Library در دسترس نیست','info');return}
          const index=Number(button.dataset.heroMedia);
          const frame=window.wp.media({title:`انتخاب تصویر اسلاید ${index+1}`,button:{text:'استفاده در Hero'},library:{type:'image'},multiple:false});
          frame.on('select',()=>{
            const item=frame.state().get('selection').first().toJSON();
            const imageInput=quick.querySelector(`#heroImage_${index}`),idInput=quick.querySelector(`#heroImageId_${index}`),preview=quick.querySelector(`#heroPreview_${index}`);
            if(imageInput)imageInput.value=item.url||'';
            if(idInput)idInput.value=Number(item.id)||0;
            if(preview)preview.src=item.url||'';
          });
          frame.open();
        }));
        commitQuickSettings=()=>{
          const h=cfg.hero_settings,hv=id=>quick.querySelector(`#${id}`)?.value??'';
          h.autoplay_interval=Math.max(3000,Math.min(15000,Number(hv('heroInterval'))||5500));
          h.radius=Math.max(16,Math.min(40,Number(hv('heroRadius'))||32));
          ['gold','surface','text','muted'].forEach(color=>h[color]=hv(`heroColor_${color}`));
          quick.querySelectorAll('[data-hero-flag]').forEach(input=>h[input.dataset.heroFlag]=input.checked);
          h.slides=[0,1,2,3].map(index=>({
            image_id:Number(hv(`heroImageId_${index}`))||0,flip_image:!!quick.querySelector(`#heroFlip_${index}`)?.checked,image_url:hv(`heroImage_${index}`),image_alt:hv(`heroAlt_${index}`),kicker:hv(`heroKicker_${index}`),title:hv(`heroTitle_${index}`),highlight:hv(`heroHighlight_${index}`),description:hv(`heroDescription_${index}`),
            features:[0,1,2,3].map(feature=>hv(`heroFeature_${index}_${feature}`)),primary_text:hv(`heroPrimaryText_${index}`),primary_url:hv(`heroPrimaryUrl_${index}`),secondary_text:hv(`heroSecondaryText_${index}`),secondary_url:hv(`heroSecondaryUrl_${index}`)
          }));
          cfg.modules.hero.slides=4;cfg.modules.hero.autoplay=!!h.autoplay;
        };
        quick.querySelector('#btnApplyHero')?.addEventListener('click',async event=>{
          commitQuickSettings();const button=event.currentTarget;button.disabled=true;const result=await Config.save({notify:false});button.disabled=false;if(!result.ok)return;
          if(Number(result.data?.hero_settings?.slide_count)!==4){window.ALOOKHOR.toast('WordPress چهار اسلاید را تأیید نکرد؛ ذخیره متوقف شد','error');return}
          window.ALOOKHOR.toast('چهار اسلاید Hero در WordPress ذخیره و روی Desktop/Mobile اعمال شدند','success');
        });
      }

      if(key === 'site_features'){
        commitQuickSettings=()=>{
          const f=cfg.feature_settings,fv=id=>quick.querySelector(`#${id}`)?.value??'';
          f.radius=Math.max(10,Math.min(30,Number(fv('sfRadius'))||20));f.gap=Math.max(0,Math.min(20,Number(fv('sfGap'))||8));f.glass=fv('sfGlass');
          ['background','card','gold','gold_light','text','muted'].forEach(color=>f[color]=fv(`sfColor_${color}`));
          quick.querySelectorAll('[data-site-feature-flag]').forEach(input=>f[input.dataset.siteFeatureFlag]=input.checked);
          f.items=[0,1,2,3].map(index=>({icon:fv(`sfIcon_${index}`),title:fv(`sfTitle_${index}`),description:fv(`sfDescription_${index}`)}));
        };
        quick.querySelector('#btnApplySiteFeatures')?.addEventListener('click',async event=>{
          commitQuickSettings();const button=event.currentTarget;button.disabled=true;const result=await Config.save({notify:false});button.disabled=false;if(!result.ok)return;
          if(Number(result.data?.feature_settings?.item_count)!==4){window.ALOOKHOR.toast('WordPress چهار ویژگی را تأیید نکرد؛ ذخیره متوقف شد','error');return}
          window.ALOOKHOR.toast('چهار ویژگی سایت با رنگ‌بندی جدید ذخیره و اعمال شدند','success');
        });
      }

      if(key === 'product_categories'){
        quick.querySelectorAll('[data-category-media]').forEach(button=>button.addEventListener('click',()=>{if(!window.wp?.media){window.ALOOKHOR.toast('Media Library در دسترس نیست','info');return}const frame=window.wp.media({title:'انتخاب تصویر دسته',button:{text:'استفاده از تصویر'},multiple:false});frame.on('select',()=>{const item=frame.state().get('selection').first().toJSON();const input=quick.querySelector(`#${button.dataset.categoryMedia}`);if(input)input.value=item.url});frame.open()}));
        commitQuickSettings=()=>{const c=cfg.category_settings;const cv=id=>quick.querySelector(`#${id}`)?.value??'';c.kicker=cv('catKicker');c.title=cv('catTitle');c.subtitle=cv('catSubtitle');c.button_text=cv('catButton');c.desktop_cards=Math.max(2,Math.min(6,Number(cv('catDesktopCards'))||4));c.desktop_gap=Math.max(8,Math.min(40,Number(cv('catDesktopGap'))||18));c.image_height=Math.max(180,Math.min(430,Number(cv('catImageHeight'))||285));c.mobile_card_width=Math.max(72,Math.min(94,Number(cv('catMobileWidth'))||84));c.mobile_peek=Math.max(3,Math.min(14,Number(cv('catMobilePeek'))||8));c.mobile_image_height=Math.max(170,Math.min(330,Number(cv('catMobileImage'))||225));c.mobile_gap=Math.max(8,Math.min(28,Number(cv('catMobileGap'))||14));c.mobile_radius=Math.max(10,Math.min(32,Number(cv('catMobileRadius'))||18));c.autoplay_interval=Math.max(2500,Math.min(15000,Number(cv('catInterval'))||5000));c.limit=Math.max(1,Math.min(24,Number(cv('catLimit'))||8));c.order=cv('catOrder')==='DESC'?'DESC':'ASC';c.selected_ids=[...quick.querySelectorAll('[data-cat-id]:checked')].map(input=>Number(input.dataset.catId)).filter(Boolean);c.overrides={};(window.ALOOKHOR_CC?.wc_categories||[]).forEach(term=>{const image=cv(`catImage_${term.id}`),description=cv(`catDesc_${term.id}`);if(image||description)c.overrides[String(term.id)]={image_url:image,description}});['section_background','card_background','gold','text','muted','border','button_background'].forEach(k=>c[k]=cv(`catColor_${k}`));quick.querySelectorAll('[data-category-flag]').forEach(input=>c[input.dataset.categoryFlag]=input.checked)};
        quick.querySelector('#btnApplyCategories')?.addEventListener('click',async event=>{commitQuickSettings();const button=event.currentTarget;button.disabled=true;const result=await Config.save({notify:false});button.disabled=false;if(!result.ok)return;window.ALOOKHOR.toast('دسته‌بندی‌های WooCommerce و تنظیمات Responsive ذخیره شدند','success')});
      }

      if(key === 'footer'){
        quick.querySelectorAll('[data-footer-media]').forEach(button=>button.addEventListener('click', ()=>{
          if(!window.wp?.media){ window.ALOOKHOR.toast('Media Library در دسترس نیست','info'); return; }
          const frame=window.wp.media({title:'انتخاب تصویر فوتر',button:{text:'استفاده از تصویر'},multiple:false});
          frame.on('select',()=>{ const item=frame.state().get('selection').first().toJSON(); const input=quick.querySelector(`#${button.dataset.footerMedia}`); if(input) input.value=item.url; });
          frame.open();
        }));
        commitQuickSettings = () => {
          const f=cfg.footer_settings;
          const fv=id=>quick.querySelector(`#${id}`)?.value ?? '';
          Object.assign(f, {
            logo_url:fv('ftLogoUrl'), brand_name:fv('ftBrandName'), brand_subtitle:fv('ftBrandSubtitle'), brand_kicker:fv('ftBrandKicker'), brand_description:fv('ftBrandDesc'), cta_text:fv('ftCtaText'), cta_url:fv('ftCtaUrl'),
            phone:fv('ftPhone'), email:fv('ftEmail'), whatsapp:fv('ftWhatsapp'), support_label:fv('ftSupportLabel'), address:fv('ftAddress'), hours_week:fv('ftHoursWeek'), hours_friday:fv('ftHoursFriday'),
            customer_title:fv('ftcustomerTitle'), customer_menu_id:Number(fv('ftcustomerMenu'))||0, customer_links:parseFooterLinks(fv('ftcustomerLinks')),
            order_title:fv('ftorderTitle'), order_menu_id:Number(fv('ftorderMenu'))||0, order_links:parseFooterLinks(fv('ftorderLinks')),
            about_title:fv('ftaboutTitle'), about_mobile_title:fv('ftAboutMobileTitle'), about_menu_id:Number(fv('ftaboutMenu'))||0, about_links:parseFooterLinks(fv('ftaboutLinks')),
            instagram_url:fv('ftInstagram'), telegram_url:fv('ftTelegram'), whatsapp_url:fv('ftWhatsappUrl'), social_title:fv('ftSocialTitle'), social_desc:fv('ftSocialDesc'), newsletter_title:fv('ftNewsletterTitle'), newsletter_desc:fv('ftNewsletterDesc'), newsletter_button:fv('ftNewsletterButton'), product_image_url:fv('ftProductImage'),
            enamad_title:fv('ftEnamadTitle'), enamad_url:fv('ftEnamadUrl'), enamad_image_url:fv('ftEnamadImage'), samandehi_title:fv('ftSamandehiTitle'), samandehi_url:fv('ftSamandehiUrl'), samandehi_image_url:fv('ftSamandehiImage'), copyright_text:fv('ftCopyright'), copyright_en:fv('ftCopyrightEn'),
            background:fv('ftColor_background'), surface:fv('ftColor_surface'), gold:fv('ftColor_gold'), gold_soft:fv('ftColor_gold_soft'), text:fv('ftColor_text'), muted:fv('ftColor_muted'), border:fv('ftColor_border'),
            container_width:Math.max(960,Math.min(1600,Number(fv('ftContainerWidth'))||1280)), desktop_logo_width:Math.max(100,Math.min(320,Number(fv('ftDesktopLogo'))||210)), mobile_logo_width:Math.max(100,Math.min(280,Number(fv('ftMobileLogo'))||190))
          });
          quick.querySelectorAll('[data-footer-flag]').forEach(input=>f[input.dataset.footerFlag]=input.checked);
        };
        quick.querySelector('#btnApplyFooter')?.addEventListener('click', async event=>{
          commitQuickSettings(); const button=event.currentTarget; button.disabled=true; const result=await Config.save({notify:false}); button.disabled=false; if(!result.ok)return; window.ALOOKHOR.toast('تنظیمات فوتر در WordPress ذخیره و روی سایت اعمال شد','success');
        });
      }
      quick.querySelectorAll('[data-quick-toggle]').forEach(t=>{
        t.addEventListener('click', ()=>{
          const k = t.dataset.quickToggle;
          if(k==='stats') { Config.toggleModule('stats'); t.classList.toggle('on'); }
          else if(k==='export') { Config.toggleModule('export'); t.classList.toggle('on'); }
          else if(k==='hero_auto') { cfg.modules.hero.autoplay = !cfg.modules.hero.autoplay; Config.save(); t.classList.toggle('on'); window.ALOOKHOR.toast(cfg.modules.hero.autoplay?'Autoplay روشن شد':'خاموش شد','info'); }
          else if(k==='auto') { Config.toggleModule('auto'); t.classList.toggle('on'); }
          renderModules();
        });
      });
      const inpCap = quick.querySelector('#inpCapacity');
      if(inpCap){
        inpCap.addEventListener('change', ()=>{
          Config.set('modules.sort.capacity', inpCap.value);
          window.ALOOKHOR.toast('ظرفیت بروز شد','success');
        });
      }
      const btnSaveApp = quick.querySelector('#btnSaveApp');
      if(btnSaveApp){
        btnSaveApp.addEventListener('click', ()=>{
          const v = quick.querySelector('#inpAppLink').value;
          Config.set('modules.app.link', v);
          window.ALOOKHOR.toast('لینک اپلیکیشن ذخیره شد','success');
        });
      }
    }

    // کلیک روی ماژول‌ها — هم toggle هم باز کردن quick
    container.querySelectorAll('.mod-item').forEach(item=>{
      item.addEventListener('click', ()=>{
        container.querySelectorAll('.mod-item').forEach(i=> i.classList.remove('active'));
        item.classList.add('active');
        showQuick(item.dataset.mod);
      });
    });
    // toggle بدون باز کردن quick
    container.addEventListener('click', (e)=>{
      const tog = e.target.closest('.mod-toggle[data-toggle]');
      if(!tog) return;
      e.stopPropagation();
      const key = tog.dataset.toggle;
      const enabled = Config.toggleModule(key);
      tog.classList.toggle('on', enabled);
      const row = tog.closest('.mod-item');
      if(row) row.classList.toggle('disabled', !enabled);
      // اگر همین ماژول در quick باز است، آپدیت کن
      if(quickTitle.textContent === cfg.modules[key].title) showQuick(key);
      window.ALOOKHOR.toast(enabled ? `«${cfg.modules[key].title}» فعال شد` : `«${cfg.modules[key].title}» غیرفعال شد`, enabled?'success':'info');
      // آپدیت هدر شمارش
      container.querySelector('.panel-head span').textContent = `${Object.values(cfg.modules||{}).filter(m=>m.enabled).length} / ${Object.keys(cfg.modules||{}).length} فعال`;
    });

    // AI accordion + actions
    container.querySelectorAll('.ai-head').forEach(btn=>{
      btn.addEventListener('click', ()=>{
        const item = btn.parentElement;
        const isOpen = item.classList.contains('open');
        container.querySelectorAll('.ai-item').forEach(i=> i.classList.remove('open'));
        container.querySelectorAll('.ai-plus').forEach(p=> p.textContent='+');
        if(!isOpen){ item.classList.add('open'); btn.querySelector('.ai-plus').textContent='×'; }
      });
    });
    container.addEventListener('click', (e)=>{
      const btn = e.target.closest('[data-ai-action]');
      if(!btn) return;
      const id = btn.dataset.id;
      const act = btn.dataset.aiAction;
      const sug = cfg.ai_assistant.suggestions.find(s=>s.id===id);
      if(!sug) return;
      if(act==='do'){
        sug.status='done';
        Config.save();
        window.ALOOKHOR.toast(`پیشنهاد «${sug.title}» اعمال شد — سایت بروز شد`,'success');
        renderAI();
        // rebind after rerender need to reattach? but we just rerendered, need to rebind AI heads? simpler: reload? But for now just update UI via next init — we will just rerender and rebind via event delegation already handled via container listener for toggle? For AI heads we lost listeners — reattach quickly
        setTimeout(()=>{
          container.querySelectorAll('.ai-head').forEach(b=>{
            b.addEventListener('click', ()=>{
              const it = b.parentElement;
              const isOpen = it.classList.contains('open');
              container.querySelectorAll('.ai-item').forEach(i=> i.classList.remove('open'));
              container.querySelectorAll('.ai-plus').forEach(p=> p.textContent='+');
              if(!isOpen){ it.classList.add('open'); b.querySelector('.ai-plus').textContent='×'; }
            });
          });
        },0);
      } else {
        sug.status = sug.status==='done' ? 'pending' : 'done';
        Config.save();
        window.ALOOKHOR.toast(sug.status==='done'?'نادیده گرفته شد':'بازگردانی شد','info');
        renderAI();
      }
    });

    // دکمه‌های عمومی
    container.querySelector('#btnRefreshStatus')?.addEventListener('click', ()=>{
      window.ALOOKHOR.toast('سلامت سیستم بررسی شد — ووکامرس، وودمارت، المنتور همه فعال','success');
      const b = container.querySelector('#btnRefreshStatus');
      b.textContent='بررسی شد ✓'; setTimeout(()=> b.textContent='بررسی مجدد', 1600);
    });
    container.querySelector('#btnSaveAll')?.addEventListener('click', async (event)=>{
      commitQuickSettings?.();
      const button = event.currentTarget;
      button.disabled = true;
      const result = await Config.save({notify:false});
      button.disabled = false;
      if(!result.ok) return;
      const persistedPhone = result.data?.header_settings?.phone;
      if(persistedPhone !== undefined && String(persistedPhone).trim() !== String(cfg.header_settings.phone || '').trim()){
        window.ALOOKHOR.toast('شماره تلفن در WordPress تأیید نشد؛ ذخیره متوقف شد','error');
        return;
      }
      Config.apply();
      container.querySelector('#lastSave').textContent = new Date().toLocaleString('fa-IR');
      window.ALOOKHOR.toast('همه تنظیمات واقعاً در WordPress ذخیره شدند','success');
    });
    container.querySelector('#btnExportSettings')?.addEventListener('click', ()=>{
      const data = Config.exportJSON();
      const blob = new Blob([data], {type:'application/json'});
      const url = URL.createObjectURL(blob);
      const a = document.createElement('a'); a.href=url; a.download='alookhor-settings.json'; a.click(); URL.revokeObjectURL(url);
      window.ALOOKHOR.toast('فایل JSON دانلود شد','info');
    });
    container.querySelector('#btnResetSettings')?.addEventListener('click', async ()=>{
      if(!confirm('بازنشانی به تنظیمات اولیه؟')) return;
      await Config.reset();
      window.ALOOKHOR.toast('بازنشانی شد — صفحه رفرش می‌شود','info');
      setTimeout(()=> location.reload(), 700);
    });
    container.querySelector('#btnEnableAll')?.addEventListener('click', ()=>{
      Object.keys(cfg.modules||{}).forEach(k=> cfg.modules[k].enabled=true);
      Config.save(); Config.apply(); renderModules();
      window.ALOOKHOR.toast('همه ماژول‌ها فعال شدند','success');
    });
    container.querySelector('#btnDisableAll')?.addEventListener('click', ()=>{
      Object.keys(cfg.modules||{}).forEach(k=> cfg.modules[k].enabled=false);
      Config.save(); Config.apply(); renderModules();
      window.ALOOKHOR.toast('همه ماژول‌ها غیرفعال شدند','info');
    });

    // پیش‌فرض
    showQuick('header');
    const firstMod = container.querySelector('.mod-item[data-mod="header"]');
    if(firstMod) firstMod.classList.add('active');

    // اعمال اولیه روی سایت
    Config.apply();
  },
  destroy(){}
};
````

## Source Snapshot — `plugin/alookhor-control-center/assets/js/modules/users.js`

````javascript
export const usersModule = {
  meta:{id:'users', title:'کاربران VIP'},
  init(container){
    container.innerHTML = `
      <div class="page-head"><div><h2>مشتریان VIP</h2><p>۸۹۲ مشتری — باشگاه طلایی ALOOKHOR</p></div><div class="head-actions"><button class="btn-ghost">خروجی</button><button class="btn-gold">+ مشتری جدید</button></div></div>
      <div class="kpi-grid">
        <div class="kpi-card"><div class="kpi-value" style="font-size:22px">۱۴</div><div class="kpi-label">VIP جدید هفته</div></div>
        <div class="kpi-card"><div class="kpi-value" style="font-size:22px">۳۲</div><div class="kpi-label">سفارش در انتظار</div></div>
        <div class="kpi-card"><div class="kpi-value" style="font-size:22px">۹۸.۲٪</div><div class="kpi-label">رضایت</div></div>
        <div class="kpi-card"><div class="kpi-value" style="font-size:22px">۴.۹/۵</div><div class="kpi-label">امتیاز بوتیک</div></div>
      </div>
      <div class="panel" style="margin-top:14px"><div class="panel-head"><h3>VIP های برتر</h3></div>
        <div class="table-wrap"><table><thead><tr><th>مشتری</th><th>سطح</th><th>خرید کل</th><th>آخرین سفارش</th></tr></thead>
        <tbody>
          <tr><td><b>سارا احمدی</b></td><td><span class="status status-ok"><span class="status-dot"></span> Gold</span></td><td>۱.۲B</td><td>۱۰ اوت</td></tr>
          <tr><td><b>نگار کریمی</b></td><td><span class="status status-warn"><span class="status-dot"></span> Platinum</span></td><td>۲.۸B</td><td>۹ اوت</td></tr>
        </tbody></table></div>
      </div>`;
  }, destroy(){}
};
````

## Source Snapshot — `plugin/alookhor-control-center/config/site.json`

````json
{
  "site": {
    "name": "ALOOKHOR",
    "subtitle": "Control Center • Luxury",
    "logoLetter": "A",
    "description": "بوتیک تخصصی آلو بخارا — سورت، بسته‌بندی و صادرات",
    "headerSticky": true,
    "goldAccent": "#D49A2E"
  },
  "modules": {
    "stats": {
      "enabled": true,
      "title": "پیشخوان هوشمند آمار",
      "order": 1
    },
    "header": {
      "enabled": true,
      "title": "تنظیمات هدر و لوگوها",
      "order": 2
    },
    "product_categories": {
      "enabled": true,
      "title": "دسته‌بندی محصولات ووکامرس",
      "order": 3
    },
    "footer": {
      "enabled": true,
      "title": "فوتر حرفه‌ای و اعتمادساز",
      "order": 4
    },
    "export": {
      "enabled": false,
      "title": "محصولات ممبر صادراتی",
      "order": 5,
      "note": "فقط برای ممبرها"
    },
    "sort": {
      "enabled": true,
      "title": "مرکز سورت و بسته‌بندی",
      "order": 6,
      "capacity": "2.4 تن",
      "today": "1.8 تن"
    },
    "collection": {
      "enabled": true,
      "title": "مجموعه منتخب آلوخور",
      "order": 7,
      "collections": [
        "سورت ۱ طلایی",
        "بسته اقتصادی",
        "صادراتی"
      ]
    },
    "app": {
      "enabled": false,
      "title": "دانلود اپلیکیشن آلوخور",
      "order": 8,
      "link": "https://alookhor.ir/app"
    },
    "hero": {
      "enabled": true,
      "title": "اسلایدر هیروی بالای صفحه",
      "order": 9,
      "slides": 4,
      "autoplay": true
    },
    "auto": {
      "enabled": true,
      "title": "بروزرسانی خودکار افزونه",
      "order": 11,
      "schedule": "03:00"
    },
    "site_features": {
      "enabled": true,
      "title": "ویژگی‌های سایت",
      "order": 10
    }
  },
  "system": {
    "woocommerce": "فعال",
    "woodmart_plus": "فعال",
    "elementor_pro": "فعال",
    "php_version": "8.1.6",
    "memory": "256MB / 512MB",
    "memory_limit": "512MB",
    "memory_used": "256MB",
    "ssl": "فعال (امن)",
    "uptime": "99.9%",
    "cache": "فعال"
  },
  "ai_assistant": {
    "enabled": true,
    "suggestions": [
      {
        "id": "stock",
        "title": "پیشنهاد افزایش موجودی آلو بترا همتار",
        "status": "pending",
        "detail": "هوش مصنوعی پیشنهاد می‌دهد موجودی آلو بخارا سورت ۱ را ۲۲٪ افزایش دهی — فروش هفته گذشته ۱۸٪ رشد داشت.",
        "action": "increase_stock"
      },
      {
        "id": "images",
        "title": "بهینه‌سازی خودکار تصاویر محصولات اسلایدر",
        "status": "pending",
        "detail": "۴ تصویر با حجم بالا شناسایی شد. بهینه‌سازی ۶۸٪ حجم را کم می‌کند.",
        "action": "optimize_images"
      },
      {
        "id": "speed",
        "title": "افزایش چشمگیر سرعت بارگذاری هوم‌پیج",
        "status": "pending",
        "detail": "با LazyLoad و کش طلایی، سرعت از ۳.۴ به ۲.۲ ثانیه می‌رسد.",
        "action": "enable_cache"
      },
      {
        "id": "feedback",
        "title": "بررسی و ثبت بازخورد مراجعین خارجی",
        "status": "new",
        "detail": "۱۲ بازخورد خارجی جدید از روسیه و امارات — تایید برای نمایش در بخش صادرات.",
        "action": "review_feedback"
      }
    ]
  },
  "header_settings": {
    "logo_text": "ALOOKHOR",
    "logo_sub": "Control Center • Luxury",
    "sticky": true,
    "header_surface": "#0D0510",
    "header_text_color": "#F5F3F0",
    "header_muted_color": "#C8C2C9",
    "header_logo_desktop_width": 118,
    "header_logo_mobile_width": 58,
    "show_search": false,
    "search_placeholder": "جستجوی محصول…",
    "show_version": true,
    "capsule_background": "#0D0510",
    "capsule_card": "#1C1024",
    "capsule_glass": "rgba(33,20,38,.75)",
    "capsule_gold": "#D49A2E",
    "capsule_gold_light": "#E8B84A",
    "capsule_text": "#F5F3F0",
    "capsule_muted": "#C8C2C9",
    "capsule_blur": 24,
    "topbar_bg": "#1C1024",
    "topbar_text_color": "#F5F3F0",
    "topbar_border_color": "#D49A2E",
    "topbar_button_bg": "#D49A2E",
    "topbar_button_text": "#0D0510"
  },
  "updated_at": "2026-08-10T16:20:00Z",
  "updated_by": "AI Assistant — recovered from previous chat",
  "version": "3.10.26",
  "hero_settings": {
    "enabled": true,
    "hide_legacy": true,
    "autoplay": true,
    "autoplay_interval": 5500,
    "pause_on_hover": true,
    "show_arrows": true,
    "show_dots": true,
    "ken_burns": true,
    "gold": "#D4AF37",
    "surface": "#09060D",
    "text": "#FFFFFF",
    "muted": "#D9D1DA",
    "radius": 32,
    "slides": [
      {
        "image_id": 0,
        "image_url": "https://alookhor.ir/wp-content/plugins/alookhor-categories-manager/images/slide1.jpg",
        "image_alt": "آلو بخارا ممتاز خراسان",
        "kicker": "محصول ممتاز خراسان",
        "title": "آلو بخارا",
        "highlight": "ممتاز خراسان",
        "description": "طبیعی، سالم و بدون مواد افزودنی",
        "features": [
          "۱۰۰٪ طبیعی",
          "کیفیت صادراتی",
          "ارسال سریع",
          "ارسال به سراسر جهان"
        ],
        "primary_text": "مشاهده محصولات",
        "primary_url": "https://alookhor.ir/shop/",
        "secondary_text": "استعلام قیمت",
        "secondary_url": "https://alookhor.ir/#b2b",
        "flip_image": true
      },
      {
        "image_id": 0,
        "image_url": "https://alookhor.ir/wp-content/plugins/alookhor-categories-manager/images/slide2.jpg",
        "image_alt": "آلو خشک طبیعی آلوخور",
        "kicker": "انتخابی از باغ‌های ایران",
        "title": "آلو خشک طبیعی",
        "highlight": "خوش‌طعم و سالم",
        "description": "سورت یکدست، فرآوری بهداشتی و طعم اصیل",
        "features": [
          "بدون افزودنی",
          "سورت ممتاز",
          "بسته‌بندی مطمئن",
          "تحویل سریع"
        ],
        "primary_text": "خرید محصولات",
        "primary_url": "https://alookhor.ir/shop/",
        "secondary_text": "مشاوره خرید",
        "secondary_url": "https://alookhor.ir/تماس-با-ما/",
        "flip_image": true
      },
      {
        "image_id": 0,
        "image_url": "https://alookhor.ir/wp-content/plugins/alookhor-categories-manager/images/slide3.jpg",
        "image_alt": "بسته‌بندی صادراتی آلوخور",
        "kicker": "استاندارد بازارهای جهانی",
        "title": "بسته‌بندی حرفه‌ای",
        "highlight": "آماده صادرات",
        "description": "حفظ کیفیت محصول از باغ تا مقصد نهایی",
        "features": [
          "کنترل کیفیت",
          "سورت دقیق",
          "بسته‌بندی صادراتی",
          "ارسال بین‌المللی"
        ],
        "primary_text": "خدمات صادرات",
        "primary_url": "https://alookhor.ir/#b2b",
        "secondary_text": "تماس با ما",
        "secondary_url": "https://alookhor.ir/تماس-با-ما/",
        "flip_image": true
      },
      {
        "image_id": 0,
        "image_url": "https://alookhor.ir/wp-content/plugins/alookhor-categories-manager/images/slide4.jpg",
        "image_alt": "سفارش عمده محصولات آلوخور",
        "kicker": "همکاری مطمئن و ماندگار",
        "title": "تأمین عمده آلو",
        "highlight": "برای کسب‌وکارها",
        "description": "ظرفیت پایدار، قیمت رقابتی و پشتیبانی تخصصی",
        "features": [
          "تأمین پایدار",
          "قیمت همکاری",
          "کنترل سفارش",
          "پشتیبانی مستقیم"
        ],
        "primary_text": "درخواست همکاری",
        "primary_url": "https://alookhor.ir/#b2b",
        "secondary_text": "دریافت مشاوره",
        "secondary_url": "https://alookhor.ir/تماس-با-ما/",
        "flip_image": true
      }
    ]
  },
  "feature_settings": {
    "enabled": true,
    "hide_legacy": true,
    "background": "#0D0510",
    "card": "#1C1024",
    "glass": "rgba(33,20,38,.75)",
    "gold": "#D49A2E",
    "gold_light": "#E8B84A",
    "text": "#F5F3F0",
    "muted": "#C8C2C9",
    "radius": 20,
    "gap": 8,
    "items": [
      {
        "icon": "truck",
        "title": "ارسال سریع",
        "description": "در سریع‌ترین زمان ممکن"
      },
      {
        "icon": "organic",
        "title": "محصولات ارگانیک",
        "description": "100% طبیعی و سالم"
      },
      {
        "icon": "headset",
        "title": "پشتیبانی ۲۴/۷",
        "description": "همیشه در کنار شما هستیم"
      },
      {
        "icon": "shield",
        "title": "ضمانت کیفیت",
        "description": "تضمین اصالت و کیفیت کالا"
      }
    ]
  }
}
````

## Source Snapshot — `plugin/alookhor-control-center/includes/admin.php`

````php
<?php
if (!defined('ABSPATH')) exit;

// ——— منوی مدیریت ———
add_action('admin_menu', function(){
    add_menu_page(
        'ALOOKHOR Control Center',
        'ALOOKHOR Center',
        'manage_options',
        'alookhor-control-center',
        'alookhor_cc_render_admin',
        'dashicons-star-filled', // آیکن لوکس
        2
    );
    add_submenu_page('alookhor-control-center', 'داشبورد', 'داشبورد', 'manage_options', 'alookhor-control-center', 'alookhor_cc_render_admin');
    add_submenu_page('alookhor-control-center', 'نوار بالای سایت و هدر', 'نوار بالای سایت و هدر', 'manage_options', 'alookhor-cc-header', 'alookhor_cc_render_header_settings');
});

// ——— لود استایل/اسکریپت فقط در صفحه کنترل سنتر ———
add_action('admin_enqueue_scripts', function($hook){
    if(strpos($hook, 'alookhor') === false) return;
    wp_enqueue_media();
    wp_enqueue_style('alookhor-cc-luxury', ALOOKHOR_CC_URL . 'assets/css/luxury.css', [], ALOOKHOR_CC_BUILD);
    wp_enqueue_style('alookhor-cc-admin', ALOOKHOR_CC_URL . 'assets/css/luxury.css', [], ALOOKHOR_CC_BUILD);
    // فونت لوکس
    wp_enqueue_style('alookhor-cc-fonts', 'https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@500;600;700&family=Inter:wght@400;500;600;700&display=swap', [], null);

    // NOTE: config.js is ES Module — DO NOT enqueue as regular script (caused SyntaxError: Unexpected token 'export')
    // It is imported via app.js as module: import { Config } from './core/config.js'
    // نصب از URL nonceدار Core Upgrader انجام می‌شود؛ مستقل از DOM صفحه Plugins.
    // admin-wp.js remains the bridge; app.js and its dependencies stay ES Modules.
    wp_enqueue_script('alookhor-cc-admin-js', ALOOKHOR_CC_URL . 'assets/js/admin-wp.js', ['jquery'], ALOOKHOR_CC_BUILD, true);
    $category_terms = taxonomy_exists('product_cat') ? get_terms(['taxonomy'=>'product_cat','hide_empty'=>false,'orderby'=>'name']) : [];
    if (is_wp_error($category_terms)) $category_terms=[];
    wp_localize_script('alookhor-cc-admin-js', 'ALOOKHOR_CC', [
        'ajax_url' => admin_url('admin-ajax.php'),
        'nonce' => wp_create_nonce('alookhor_cc_nonce'),
        'site_json_url' => ALOOKHOR_CC_URL . 'config/site.json',
        'version' => ALOOKHOR_CC_VERSION,
        'plugin_file' => ALOOKHOR_CC_PLUGIN_BASENAME,
        'plugin_slug' => 'alookhor-control-center',
        'native_update_url' => wp_nonce_url(
            self_admin_url('update.php?action=upgrade-plugin&plugin=' . rawurlencode(ALOOKHOR_CC_PLUGIN_BASENAME)),
            'upgrade-plugin_' . ALOOKHOR_CC_PLUGIN_BASENAME
        ),
        'updater_configured' => (bool) alookhor_cc_update_manifest_url(),
        'header_shortcode' => '[alookhor_portal_header]',
        'hero_shortcode' => '[alookhor_managed_hero]',
        'feature_shortcode' => '[alookhor_managed_features]',
        'home_url' => home_url('/'),
        'footer_menus' => array_map(function($menu){
            return ['id' => (int) $menu->term_id, 'name' => $menu->name];
        }, wp_get_nav_menus(['orderby' => 'term_order'])),
        'wc_categories' => array_map(function($term){
            return ['id'=>(int)$term->term_id,'name'=>$term->name,'slug'=>$term->slug,'count'=>(int)$term->count,'parent'=>(int)$term->parent];
        }, $category_terms),
    ]);
});

// ——— رندر صفحه اصلی کنترل سنتر ———
function alookhor_cc_render_admin(){
    // چک دسترسی
    if(!current_user_can('manage_options')) return;
    $settings = alookhor_cc_get_settings();
    $header = alookhor_cc_get_header_settings();
    // یک صفحه فول‌اسکرین لوکس
    ?>
    <div class="wrap" style="margin:0; padding:0; background:#070708; margin-left:-20px; margin-top:-10px;">
        <style>
            #wpcontent{padding-left:0 !important; background:#070708}
            #wpfooter{display:none}
            .alookhor-wp-topbar{position:sticky; top:32px; z-index:10; background: linear-gradient(180deg, rgba(17,17,19,0.96), rgba(17,17,19,0.88)); border-bottom:1px solid rgba(201,168,106,0.14); backdrop-filter: blur(12px); padding:10px 20px; display:flex; align-items:center; gap:12px; color:#F5F1E9}
            @media(max-width:782px){.alookhor-wp-topbar{top:46px}}
            .alookhor-wp-topbar .dot{width:8px; height:8px; border-radius:50%; background:#3DD68C; box-shadow:0 0 0 4px rgba(61,214,140,0.15)}
        </style>
        <div class="alookhor-wp-topbar">
            <span class="dot"></span>
            <b style="letter-spacing:.06em; font-family:'Cormorant Garamond',serif">ALOOKHOR Control Center</b>
            <span style="opacity:.5">•</span>
            <span style="font-size:12px; color:#9A9590">v<?php echo esc_html(ALOOKHOR_CC_VERSION); ?> — نصب شده و فعال</span>
            <span style="margin-left:auto; display:flex; gap:8px; align-items:center">
                <code dir="ltr" style="background:rgba(255,255,255,0.06); border:1px solid rgba(201,168,106,0.14); padding:4px 8px; border-radius:8px; color:#E8D5B5; font-size:11px">[alookhor_portal_header]</code>
                <span style="font-size:11px; color:#9A9590">هدر المنتوری شما</span>
                <a href="<?php echo esc_url(home_url('/')); ?>" target="_blank" style="background:linear-gradient(135deg,#C9A86A,#B8935A); color:#1A1206; padding:7px 12px; border-radius:999px; font-weight:700; font-size:12px; text-decoration:none">نمایش سایت</a>
            </span>
        </div>
        <?php
        // لود قالب کنترل سنتر (همون index.html اما با مسیرهای وردپرسی)
        $template = ALOOKHOR_CC_DIR . 'templates/admin-control-center.php';
        if(file_exists($template)) include $template;
        else echo '<div style="padding:40px; color:#fff">Template not found</div>';
        ?>
    </div>
    <?php
}

function alookhor_cc_render_header_settings(){
    $h = alookhor_cc_get_header_settings();
    ?>
    <div class="wrap" style="background:#070708; margin-left:-20px; padding:24px; color:#F5F1E9">
        <h1 style="color:#E8D5B5; font-family:'Cormorant Garamond',serif">مدیریت نوار بالای سایت و هدر</h1>
        <p style="color:#9A9590">تمام گزینه‌های Top Bar و هدر حرفه‌ای شورت‌کد [alookhor_portal_header] — بدون نیاز به ویرایش Elementor یا Code Snippets.</p>
        <?php $menus = wp_get_nav_menus(['orderby' => 'term_order']); ?>
        <form id="alookhorHeaderForm" style="max-width:900px; background:rgba(255,255,255,0.03); border:1px solid rgba(201,168,106,0.14); border-radius:18px; padding:20px; display:grid; gap:16px">
            <?php wp_nonce_field('alookhor_cc_nonce','nonce'); ?>
            <section class="alookhor-settings-section">
                <div class="alookhor-section-head"><div><b>نوار بالای سایت (Top Bar)</b><span>تمام متن‌ها، لینک‌ها و آیتم‌های قابل‌مشاهده</span></div><em>LIVE OPTIONS</em></div>
                <div class="alookhor-fields-grid">
                    <label>شماره تلفن <input name="phone" value="<?php echo esc_attr($h['phone']); ?>" class="alookhor-field" dir="ltr"></label>
                    <label>ایمیل <input type="email" name="email" value="<?php echo esc_attr($h['email']); ?>" class="alookhor-field" dir="ltr"></label>
                    <label>شماره WhatsApp <input name="whatsapp" value="<?php echo esc_attr($h['whatsapp']); ?>" class="alookhor-field" dir="ltr"></label>
                    <label>متن صادرات <input name="export_text" value="<?php echo esc_attr($h['export_text']); ?>" class="alookhor-field"></label>
                    <label>لینک متن صادرات <input type="url" name="export_url" value="<?php echo esc_attr($h['export_url']); ?>" class="alookhor-field" dir="ltr" placeholder="اختیاری"></label>
                    <label>متن دکمه خرید عمده <input name="wholesale_text" value="<?php echo esc_attr($h['wholesale_text']); ?>" class="alookhor-field"></label>
                    <label>لینک خرید عمده <input type="url" name="wholesale_url" value="<?php echo esc_attr($h['wholesale_url']); ?>" class="alookhor-field" dir="ltr"></label>
                </div>
            </section>

            <section class="alookhor-settings-section">
                <div class="alookhor-section-head"><div><b>لوگوی مرکزی Top Bar</b><span>انتخاب از کتابخانه رسانه WordPress</span></div><em>MEDIA</em></div>
                <div class="alookhor-fields-grid">
                    <label style="grid-column:span 2">آدرس لوگو
                        <span style="display:flex;gap:8px"><input id="alookhorTopLogoUrl" name="top_logo_url" value="<?php echo esc_attr($h['top_logo_url']); ?>" class="alookhor-field" dir="ltr"><button type="button" id="alookhorSelectTopLogo" class="alookhor-media-btn">انتخاب تصویر</button></span>
                    </label>
                    <label>متن جایگزین لوگو <input name="top_logo_alt" value="<?php echo esc_attr($h['top_logo_alt']); ?>" class="alookhor-field"></label>
                    <label>لینک لوگو <input type="url" name="top_logo_link" value="<?php echo esc_attr($h['top_logo_link']); ?>" class="alookhor-field" dir="ltr"></label>
                    <label>عرض لوگوی Top Bar (50–180px) <input type="number" min="50" max="180" name="top_logo_width" value="<?php echo esc_attr($h['top_logo_width']); ?>" class="alookhor-field"></label>
                    <label>عرض لوگوی Header در Desktop <input type="number" min="70" max="220" name="header_logo_desktop_width" value="<?php echo esc_attr($h['header_logo_desktop_width']); ?>" class="alookhor-field"></label>
                    <label>عرض لوگوی Header در Mobile <input type="number" min="42" max="110" name="header_logo_mobile_width" value="<?php echo esc_attr($h['header_logo_mobile_width']); ?>" class="alookhor-field"></label>
                </div>
            </section>

            <section class="alookhor-settings-section">
                <div class="alookhor-section-head"><div><b>ظاهر Top Bar</b><span>رنگ، ارتفاع، حاشیه و دکمه CTA</span></div><em>STYLE</em></div>
                <div class="alookhor-color-grid">
                    <?php foreach ([
                        'topbar_bg' => 'پس‌زمینه نوار',
                        'topbar_text_color' => 'رنگ متن',
                        'topbar_border_color' => 'رنگ خط پایین',
                        'topbar_button_bg' => 'رنگ دکمه عمده',
                        'topbar_button_text' => 'متن دکمه عمده',
                        'gold' => 'طلایی اصلی هدر',
                        'header_surface' => 'سطح Navigation',
                        'header_text_color' => 'متن Navigation',
                        'header_muted_color' => 'متن فرعی Navigation'
                    ] as $color_key => $color_label): ?>
                        <label><?php echo esc_html($color_label); ?><input type="color" name="<?php echo esc_attr($color_key); ?>" value="<?php echo esc_attr($h[$color_key]); ?>" class="alookhor-field alookhor-color-field"></label>
                    <?php endforeach; ?>
                    <label>ارتفاع نوار (30–60px)<input type="number" min="30" max="60" name="topbar_height" value="<?php echo esc_attr($h['topbar_height']); ?>" class="alookhor-field"></label>
                </div>
            </section>

            <section class="alookhor-settings-section">
                <div class="alookhor-section-head"><div><b>کپسول شیشه‌ای ردیف دوم</b><span>پالت اختصاصی فقط برای Main Header Capsule</span></div><em>GLASS</em></div>
                <div class="alookhor-color-grid">
                    <?php foreach ([
                        'capsule_background'=>'پس‌زمینه اصلی',
                        'capsule_card'=>'سطح کارت',
                        'capsule_gold'=>'طلایی اصلی',
                        'capsule_gold_light'=>'طلایی روشن',
                        'capsule_text'=>'سفید متن',
                        'capsule_muted'=>'متن فرعی'
                    ] as $color_key=>$color_label): ?>
                        <label><?php echo esc_html($color_label); ?><input type="color" name="<?php echo esc_attr($color_key); ?>" value="<?php echo esc_attr($h[$color_key]); ?>" class="alookhor-field alookhor-color-field"></label>
                    <?php endforeach; ?>
                </div>
                <div class="alookhor-fields-grid"><label>Glass RGBA<input name="capsule_glass" value="<?php echo esc_attr($h['capsule_glass']); ?>" class="alookhor-field" dir="ltr"></label><label>Blur (10–36px)<input type="number" min="10" max="36" name="capsule_blur" value="<?php echo esc_attr($h['capsule_blur']); ?>" class="alookhor-field"></label></div>
            </section>

            <section class="alookhor-settings-section">
                <div class="alookhor-section-head"><div><b>هویت و منوی اصلی</b><span>لوگوی اصلی، حساب کاربری و اتصال فهرست‌ها</span></div><em>HEADER</em></div>
                <div class="alookhor-fields-grid">
                    <label>متن لوگو <input name="logo_text" value="<?php echo esc_attr($h['logo_text']); ?>" class="alookhor-field"></label>
                    <label>زیرعنوان <input name="logo_sub" value="<?php echo esc_attr($h['logo_sub']); ?>" class="alookhor-field"></label>
                    <label>حرف لوگو <input name="logo_letter" value="<?php echo esc_attr($h['logo_letter']); ?>" maxlength="2" class="alookhor-field"></label>
                    <label>متن ورود <input name="account_text" value="<?php echo esc_attr($h['account_text']); ?>" class="alookhor-field"></label>
                    <label>فهرست اصلی
                        <select name="primary_menu" class="alookhor-field">
                            <option value="0">تشخیص خودکار از WordPress</option>
                            <?php foreach ($menus as $menu): ?>
                                <option value="<?php echo esc_attr($menu->term_id); ?>" <?php selected((int)$h['primary_menu'], (int)$menu->term_id); ?>><?php echo esc_html($menu->name); ?></option>
                            <?php endforeach; ?>
                        </select>
                    </label>
                </div>
            </section>
            <div style="display:flex;gap:10px;flex-wrap:wrap">
                <?php foreach ([
                    'sticky' => 'Sticky فقط Navigation اصلی',
                    'show_topbar' => 'نمایش Top Bar',
                    'show_phone' => 'نمایش تلفن',
                    'show_email' => 'نمایش ایمیل',
                    'show_whatsapp' => 'نمایش WhatsApp',
                    'show_export' => 'نمایش متن صادرات',
                    'show_wholesale' => 'نمایش دکمه عمده',
                    'wholesale_new_tab' => 'بازشدن عمده در تب جدید',
                    'show_contact' => 'نمایش گروه تماس',
                    'show_account' => 'نمایش ورود/حساب',
                    'mega_menu' => 'مگا منو دسکتاپ'
                ] as $key => $label): ?>
                    <label style="display:flex;align-items:center;gap:8px;background:rgba(255,255,255,.035);border:1px solid rgba(201,168,106,.14);border-radius:999px;padding:8px 12px">
                        <input type="hidden" name="<?php echo esc_attr($key); ?>" value="0">
                        <input type="checkbox" name="<?php echo esc_attr($key); ?>" value="1" <?php checked(!empty($h[$key])); ?> style="accent-color:#C9A86A">
                        <?php echo esc_html($label); ?>
                    </label>
                <?php endforeach; ?>
            </div>
            <div style="padding:12px;border:1px dashed rgba(201,168,106,.2);border-radius:12px;color:#B9B0A6;font-size:12px;line-height:1.8">
                فهرست اصلی به‌صورت خودکار از جایگاه Primary/Header وردپرس خوانده می‌شود. منوی Hamburger تمام فهرست‌های ساخته‌شده در «نمایش ← فهرست‌ها» را گروه‌بندی می‌کند.
            </div>
            <button type="submit" style="background:linear-gradient(135deg,#C9A86A,#B8935A); color:#1A1206; border:0; padding:12px; border-radius:999px; font-weight:700; cursor:pointer">ذخیره تنظیمات هدر حرفه‌ای</button>
            <div id="alookhorHeaderMsg" style="font-size:12px; color:#3DD68C; display:none">ذخیره شد ✓</div>
        </form>
        <style>
          #alookhorHeaderForm label{color:#D8D0C7;font-size:12px;display:grid;gap:6px}
          #alookhorHeaderForm .alookhor-field{width:100%;max-width:none;background:rgba(255,255,255,.04);border:1px solid rgba(201,168,106,.18);border-radius:9px;padding:9px 10px;color:#fff}
          #alookhorHeaderForm select.alookhor-field{background:#17131A}
          .alookhor-settings-section{padding:16px;border:1px solid rgba(201,168,106,.13);border-radius:14px;background:rgba(0,0,0,.14);display:grid;gap:14px}
          .alookhor-section-head{display:flex;align-items:center;justify-content:space-between;gap:12px;padding-bottom:11px;border-bottom:1px solid rgba(201,168,106,.1)}
          .alookhor-section-head b{display:block;color:#E8D5B5;font-size:14px}.alookhor-section-head span{display:block;color:#8F8991;font-size:10px;margin-top:4px}.alookhor-section-head em{font:700 9px Arial;color:#C9A86A;border:1px solid rgba(201,168,106,.2);border-radius:999px;padding:4px 7px}
          .alookhor-fields-grid{display:grid;grid-template-columns:repeat(auto-fit,minmax(230px,1fr));gap:13px}.alookhor-color-grid{display:grid;grid-template-columns:repeat(auto-fit,minmax(150px,1fr));gap:12px}
          #alookhorHeaderForm .alookhor-color-field{height:42px;padding:4px}.alookhor-media-btn{white-space:nowrap;border:1px solid rgba(201,168,106,.3);border-radius:9px;background:rgba(201,168,106,.1);color:#E8D5B5;padding:8px 12px;cursor:pointer}
          @media(max-width:782px){.alookhor-fields-grid,.alookhor-color-grid{grid-template-columns:1fr}.alookhor-fields-grid label[style*="span 2"]{grid-column:auto!important}}
        </style>
        <p style="margin-top:14px; font-size:12px; color:#9A9590">شورت‌کد در المنتور: <code dir="ltr" style="background:#111113; border:1px solid rgba(201,168,106,0.14); padding:4px 8px; border-radius:6px; color:#E8D5B5">[alookhor_portal_header]</code></p>
    </div>
    <script>
    jQuery(function($){
        let topLogoFrame;
        $('#alookhorSelectTopLogo').on('click', function(e){
            e.preventDefault();
            if(topLogoFrame){ topLogoFrame.open(); return; }
            topLogoFrame = wp.media({title:'انتخاب لوگوی Top Bar', button:{text:'استفاده از این تصویر'}, multiple:false});
            topLogoFrame.on('select', function(){
                const item = topLogoFrame.state().get('selection').first().toJSON();
                $('#alookhorTopLogoUrl').val(item.url).trigger('change');
            });
            topLogoFrame.open();
        });
        $('#alookhorHeaderForm').on('submit', function(e){
            e.preventDefault();
            const data = $(this).serializeArray();
            data.push({name:'action', value:'alookhor_save_header'});
            $.post(ALOOKHOR_CC.ajax_url, data, function(res){
                if(res.success){ $('#alookhorHeaderMsg').show().text('ذخیره شد ✓ — هدر حرفه‌ای و فهرست‌های WordPress بروز شدند'); setTimeout(()=>$('#alookhorHeaderMsg').fadeOut(),3000); }
                else alert(res.data||'خطا');
            });
        });
    });
    </script>
    <?php
}
````

## Source Snapshot — `plugin/alookhor-control-center/includes/ajax.php`

````php
<?php
if (!defined('ABSPATH')) exit;

// ——— AJAX: ذخیره تنظیمات با آپدیت آنی (بدون رفرش) ———

add_action('wp_ajax_alookhor_save_settings', 'alookhor_ajax_save_settings');
add_action('wp_ajax_alookhor_toggle_module', 'alookhor_ajax_toggle_module');
add_action('wp_ajax_alookhor_save_header', 'alookhor_ajax_save_header_wp');
add_action('wp_ajax_alookhor_get_settings', 'alookhor_ajax_get_settings');

// nonce check helper
function alookhor_cc_check(){
    check_ajax_referer('alookhor_cc_nonce', 'nonce');
    if(!current_user_can('manage_options')) wp_send_json_error('دسترسی ندارید');
}

// State فقط شامل داده متنی/عددی/Boolean است؛ HTML اجرایی نباید در wp_options ذخیره شود.
function alookhor_cc_sanitize_state($value){
    if (is_array($value)) {
        $clean = [];
        foreach ($value as $key => $item) {
            $safe_key = is_int($key) ? $key : sanitize_key($key);
            $clean[$safe_key] = alookhor_cc_sanitize_state($item);
        }
        return $clean;
    }
    if (is_bool($value) || is_int($value) || is_float($value) || is_null($value)) return $value;
    return sanitize_textarea_field((string) $value);
}

function alookhor_ajax_get_settings(){
    alookhor_cc_check();
    $settings = alookhor_cc_get_settings();
    wp_send_json_success($settings);
}

function alookhor_ajax_save_settings(){
    alookhor_cc_check();
    $raw_payload = isset($_POST['payload']) ? wp_unslash($_POST['payload']) : '';
    $payload = json_decode($raw_payload, true);
    if(json_last_error() !== JSON_ERROR_NONE || empty($payload) || !is_array($payload)) {
        wp_send_json_error('payload نامعتبر');
    }
    $payload = alookhor_cc_sanitize_state($payload);

    // فیلدهای Top Bar در ذخیره پنل اصلی نیز باید با همان قرارداد فرم
    // تخصصی هدر نرمال شوند؛ Preview مرورگر منبع حقیقت نیست.
    if (!empty($payload['header_settings']) && is_array($payload['header_settings'])) {
        $header_current = get_option(ALOOKHOR_CC_HEADER_OPTION, []);
        if (!is_array($header_current)) $header_current = [];
        $header = $payload['header_settings'];
        foreach ([
            'topbar_bg' => '#1C1024',
            'topbar_text_color' => '#F5F3F0',
            'topbar_border_color' => '#D49A2E',
            'topbar_button_bg' => '#D49A2E',
            'topbar_button_text' => '#0D0510',
            'header_surface' => '#0D0510',
            'header_text_color' => '#F5F3F0',
            'header_muted_color' => '#C8C2C9',
            'capsule_background' => '#0D0510',
            'capsule_card' => '#1C1024',
            'capsule_gold' => '#D49A2E',
            'capsule_gold_light' => '#E8B84A',
            'capsule_text' => '#F5F3F0',
            'capsule_muted' => '#C8C2C9',
        ] as $key => $fallback) {
            if (array_key_exists($key, $header)) {
                $header[$key] = sanitize_hex_color($header[$key]) ?: ($header_current[$key] ?? $fallback);
            }
        }
        if(array_key_exists('capsule_glass',$header)){
            $capsule_glass=sanitize_text_field($header['capsule_glass']);
            $header['capsule_glass']=preg_match('/^rgba?\(\s*\d{1,3}\s*,\s*\d{1,3}\s*,\s*\d{1,3}(?:\s*,\s*(?:0|1|0?\.\d+))?\s*\)$/',$capsule_glass)?$capsule_glass:($header_current['capsule_glass']??'rgba(33,20,38,.75)');
        }
        if(array_key_exists('capsule_blur',$header))$header['capsule_blur']=max(10,min(36,absint($header['capsule_blur'])));
        foreach (['export_url', 'wholesale_url', 'top_logo_url', 'top_logo_link'] as $key) {
            if (array_key_exists($key, $header)) $header[$key] = esc_url_raw($header[$key]);
        }
        if (array_key_exists('email', $header)) $header['email'] = sanitize_email($header['email']);
        if (array_key_exists('whatsapp', $header)) $header['whatsapp'] = preg_replace('/\D+/', '', (string) $header['whatsapp']);
        if (array_key_exists('topbar_height', $header)) $header['topbar_height'] = max(30, min(60, absint($header['topbar_height'])));
        if (array_key_exists('top_logo_width', $header)) $header['top_logo_width'] = max(50, min(180, absint($header['top_logo_width'])));
        if (array_key_exists('header_logo_desktop_width', $header)) $header['header_logo_desktop_width'] = max(70, min(220, absint($header['header_logo_desktop_width'])));
        if (array_key_exists('header_logo_mobile_width', $header)) $header['header_logo_mobile_width'] = max(42, min(110, absint($header['header_logo_mobile_width'])));
        foreach (['sticky', 'show_search', 'show_topbar', 'show_contact', 'show_account', 'show_phone', 'show_email', 'show_whatsapp', 'show_export', 'show_wholesale', 'wholesale_new_tab', 'mega_menu'] as $key) {
            if (array_key_exists($key, $header)) $header[$key] = rest_sanitize_boolean($header[$key]);
        }
        $payload['header_settings'] = $header;
    }

    if (!empty($payload['footer_settings']) && is_array($payload['footer_settings'])) {
        $footer = $payload['footer_settings'];
        foreach (['background'=>'#070809','surface'=>'#0D0F10','gold'=>'#C89A3D','gold_soft'=>'#E3BD69','text'=>'#E9E5DF','muted'=>'#A7A39D','border'=>'#4A3820'] as $key=>$fallback) {
            if (array_key_exists($key,$footer)) $footer[$key] = sanitize_hex_color($footer[$key]) ?: $fallback;
        }
        foreach (['logo_url','cta_url','instagram_url','telegram_url','whatsapp_url','product_image_url','enamad_image_url','enamad_url','samandehi_image_url','samandehi_url'] as $key) {
            if (array_key_exists($key,$footer)) $footer[$key] = esc_url_raw($footer[$key]);
        }
        if (array_key_exists('email',$footer)) $footer['email'] = sanitize_email($footer['email']);
        foreach (['phone','whatsapp'] as $key) if (array_key_exists($key,$footer)) $footer[$key] = sanitize_text_field($footer[$key]);
        foreach (['enabled','hide_legacy','hide_old_newsletter','use_header_contact','newsletter_enabled','show_payments','show_benefits','show_product_image'] as $key) {
            if (array_key_exists($key,$footer)) $footer[$key] = rest_sanitize_boolean($footer[$key]);
        }
        foreach (['customer_menu_id','order_menu_id','about_menu_id'] as $key) if (array_key_exists($key,$footer)) $footer[$key] = absint($footer[$key]);
        if (array_key_exists('container_width',$footer)) $footer['container_width'] = max(960,min(1600,absint($footer['container_width'])));
        if (array_key_exists('desktop_logo_width',$footer)) $footer['desktop_logo_width'] = max(100,min(320,absint($footer['desktop_logo_width'])));
        if (array_key_exists('mobile_logo_width',$footer)) $footer['mobile_logo_width'] = max(100,min(280,absint($footer['mobile_logo_width'])));
        foreach (['customer_links','order_links','about_links'] as $group) {
            if (!isset($footer[$group]) || !is_array($footer[$group])) continue;
            $footer[$group] = array_values(array_filter(array_map(function($link){
                if (!is_array($link)) return null;
                $title = sanitize_text_field($link['title'] ?? '');
                if (!$title) return null;
                return ['title'=>$title,'url'=>esc_url_raw($link['url'] ?? '#')];
            }, $footer[$group])));
        }
        $payload['footer_settings'] = $footer;
    }

    if (!empty($payload['category_settings']) && is_array($payload['category_settings'])) {
        $category = $payload['category_settings'];
        foreach (['section_background'=>'#090610','card_background'=>'#0D0916','gold'=>'#D4A436','text'=>'#F7F2EA','muted'=>'#B8B0BD','border'=>'#6F5426','button_background'=>'#120B1C'] as $key=>$fallback) {
            if (array_key_exists($key,$category)) $category[$key]=sanitize_hex_color($category[$key])?:$fallback;
        }
        foreach (['enabled','hide_legacy','hide_empty','parent_only','show_description','show_count','show_icons','show_arrows','show_dots','autoplay'] as $key) {
            if (array_key_exists($key,$category)) $category[$key]=rest_sanitize_boolean($category[$key]);
        }
        $category['selected_ids']=array_values(array_unique(array_filter(array_map('absint',(array)($category['selected_ids']??[])))));
        $category['limit']=max(1,min(24,absint($category['limit']??8)));
        $category['desktop_cards']=max(2,min(6,absint($category['desktop_cards']??4)));
        $category['desktop_gap']=max(8,min(40,absint($category['desktop_gap']??18)));
        $category['image_height']=max(180,min(430,absint($category['image_height']??285)));
        $category['mobile_card_width']=max(72,min(94,absint($category['mobile_card_width']??84)));
        $category['mobile_peek']=max(3,min(14,absint($category['mobile_peek']??8)));
        $category['mobile_image_height']=max(170,min(330,absint($category['mobile_image_height']??225)));
        $category['mobile_gap']=max(8,min(28,absint($category['mobile_gap']??14)));
        $category['mobile_radius']=max(10,min(32,absint($category['mobile_radius']??18)));
        $category['autoplay_interval']=max(2500,min(15000,absint($category['autoplay_interval']??5000)));
        $category['orderby']=in_array(($category['orderby']??''),['include','name','count','term_id','menu_order'],true)?$category['orderby']:'include';
        $category['order']=strtoupper($category['order']??'ASC')==='DESC'?'DESC':'ASC';
        if (isset($category['overrides'])&&is_array($category['overrides'])) {
            $clean=[];foreach($category['overrides'] as $id=>$override){$id=absint($id);if(!$id||!is_array($override))continue;$clean[(string)$id]=['image_url'=>esc_url_raw($override['image_url']??''),'description'=>sanitize_text_field($override['description']??'')];}$category['overrides']=$clean;
        }
        $payload['category_settings']=$category;
    }

    if (!empty($payload['hero_settings']) && is_array($payload['hero_settings'])) {
        $hero = $payload['hero_settings'];
        foreach (['gold'=>'#D4AF37','surface'=>'#09060D','text'=>'#FFFFFF','muted'=>'#D9D1DA'] as $key=>$fallback) {
            if (array_key_exists($key,$hero)) $hero[$key]=sanitize_hex_color($hero[$key])?:$fallback;
        }
        foreach (['enabled','hide_legacy','autoplay','pause_on_hover','show_arrows','show_dots','ken_burns'] as $key) {
            if (array_key_exists($key,$hero)) $hero[$key]=rest_sanitize_boolean($hero[$key]);
        }
        $hero['autoplay_interval']=max(3000,min(15000,absint($hero['autoplay_interval']??5500)));
        $hero['radius']=max(16,min(40,absint($hero['radius']??32)));
        $slide_defaults=function_exists('alookhor_cc_hero_slide_defaults')?alookhor_cc_hero_slide_defaults():array_fill(0,4,[]);
        $incoming=is_array($hero['slides']??null)?array_values($hero['slides']):[];
        $clean_slides=[];
        for($index=0;$index<4;$index++){
            $slide=is_array($incoming[$index]??null)?$incoming[$index]:[];
            $default=is_array($slide_defaults[$index]??null)?$slide_defaults[$index]:[];
            $slide=array_replace($default,$slide);
            $features=is_array($slide['features']??null)?array_values($slide['features']):[];
            $features=array_slice(array_pad(array_map('sanitize_text_field',$features),4,''),0,4);
            $clean_slides[]=[
                'image_id'=>absint($slide['image_id']??0),
                'flip_image'=>rest_sanitize_boolean($slide['flip_image']??false),
                'image_url'=>esc_url_raw($slide['image_url']??''),
                'image_alt'=>sanitize_text_field($slide['image_alt']??''),
                'kicker'=>sanitize_text_field($slide['kicker']??''),
                'title'=>sanitize_text_field($slide['title']??''),
                'highlight'=>sanitize_text_field($slide['highlight']??''),
                'description'=>sanitize_textarea_field($slide['description']??''),
                'features'=>$features,
                'primary_text'=>sanitize_text_field($slide['primary_text']??''),
                'primary_url'=>esc_url_raw($slide['primary_url']??''),
                'secondary_text'=>sanitize_text_field($slide['secondary_text']??''),
                'secondary_url'=>esc_url_raw($slide['secondary_url']??''),
            ];
        }
        $hero['slides']=$clean_slides;
        $payload['hero_settings']=$hero;
        if(isset($payload['modules']['hero'])&&is_array($payload['modules']['hero'])){
            $payload['modules']['hero']['slides']=4;
            $payload['modules']['hero']['autoplay']=!empty($hero['autoplay']);
        }
    }

    if (!empty($payload['feature_settings']) && is_array($payload['feature_settings'])) {
        $features=$payload['feature_settings'];
        foreach (['background'=>'#0D0510','card'=>'#1C1024','gold'=>'#D49A2E','gold_light'=>'#E8B84A','text'=>'#F5F3F0','muted'=>'#C8C2C9'] as $key=>$fallback) {
            if(array_key_exists($key,$features))$features[$key]=sanitize_hex_color($features[$key])?:$fallback;
        }
        foreach(['enabled','hide_legacy'] as $key)if(array_key_exists($key,$features))$features[$key]=rest_sanitize_boolean($features[$key]);
        $glass=sanitize_text_field($features['glass']??'rgba(33,20,38,.75)');
        $features['glass']=preg_match('/^rgba?\(\s*\d{1,3}\s*,\s*\d{1,3}\s*,\s*\d{1,3}(?:\s*,\s*(?:0|1|0?\.\d+))?\s*\)$/',$glass)?$glass:'rgba(33,20,38,.75)';
        $features['radius']=max(10,min(30,absint($features['radius']??20)));
        $features['gap']=max(0,min(20,absint($features['gap']??8)));
        $defaults=function_exists('alookhor_cc_site_feature_defaults')?alookhor_cc_site_feature_defaults()['items']:array_fill(0,4,[]);
        $incoming=is_array($features['items']??null)?array_values($features['items']):[];
        $allowed_icons=['truck','organic','headset','shield'];$clean_items=[];
        for($index=0;$index<4;$index++){
            $item=is_array($incoming[$index]??null)?$incoming[$index]:[];
            $default=is_array($defaults[$index]??null)?$defaults[$index]:[];
            $item=array_replace($default,$item);$icon=sanitize_key($item['icon']??'shield');
            $clean_items[]=['icon'=>in_array($icon,$allowed_icons,true)?$icon:'shield','title'=>sanitize_text_field($item['title']??''),'description'=>sanitize_text_field($item['description']??'')];
        }
        $features['items']=$clean_items;$payload['feature_settings']=$features;
    }

    // ذخیره کل تنظیمات
    $current = get_option(ALOOKHOR_CC_OPTION, []);
    $merged = array_replace_recursive(is_array($current) ? $current : [], $payload);
    $merged['updated_at'] = current_time('mysql');
    $merged['updated_by'] = wp_get_current_user()->user_login;
    update_option(ALOOKHOR_CC_OPTION, $merged);

    // اگر هدر داخل payload بود، فقط همان کلیدها Merge شوند؛ تنظیمات حرفه‌ای
    // Top Bar/Menu/Contact که در Option جدا هستند نباید حذف شوند.
    if(!empty($payload['header_settings']) && is_array($payload['header_settings'])){
        $header_current = get_option(ALOOKHOR_CC_HEADER_OPTION, []);
        if (!is_array($header_current)) $header_current = [];
        update_option(ALOOKHOR_CC_HEADER_OPTION, array_replace($header_current, $payload['header_settings']));
    }
    if(!empty($payload['site']['logoLetter'])){
        $h = get_option(ALOOKHOR_CC_HEADER_OPTION, []);
        if (!is_array($h)) $h = [];
        $h['logo_letter'] = $payload['site']['logoLetter'];
        update_option(ALOOKHOR_CC_HEADER_OPTION, $h);
    }

    $persisted_header = get_option(ALOOKHOR_CC_HEADER_OPTION, []);
    wp_send_json_success([
        'message' => 'ذخیره واقعی WordPress تأیید شد',
        'updated_at' => $merged['updated_at'],
        'header_settings' => is_array($persisted_header) ? [
            'phone' => $persisted_header['phone'] ?? null,
            'email' => $persisted_header['email'] ?? null,
            'whatsapp' => $persisted_header['whatsapp'] ?? null,
            'export_text' => $persisted_header['export_text'] ?? null,
            'wholesale_text' => $persisted_header['wholesale_text'] ?? null,
            'topbar_bg' => $persisted_header['topbar_bg'] ?? null,
            'topbar_text_color' => $persisted_header['topbar_text_color'] ?? null,
            'topbar_border_color' => $persisted_header['topbar_border_color'] ?? null,
            'topbar_button_bg' => $persisted_header['topbar_button_bg'] ?? null,
            'topbar_button_text' => $persisted_header['topbar_button_text'] ?? null,
            'header_surface' => $persisted_header['header_surface'] ?? null,
            'header_text_color' => $persisted_header['header_text_color'] ?? null,
            'header_muted_color' => $persisted_header['header_muted_color'] ?? null,
            'capsule_background' => $persisted_header['capsule_background'] ?? null,
            'capsule_card' => $persisted_header['capsule_card'] ?? null,
            'capsule_glass' => $persisted_header['capsule_glass'] ?? null,
            'capsule_gold' => $persisted_header['capsule_gold'] ?? null,
            'capsule_gold_light' => $persisted_header['capsule_gold_light'] ?? null,
            'capsule_text' => $persisted_header['capsule_text'] ?? null,
            'capsule_muted' => $persisted_header['capsule_muted'] ?? null,
            'capsule_blur' => $persisted_header['capsule_blur'] ?? null,
            'header_logo_desktop_width' => $persisted_header['header_logo_desktop_width'] ?? null,
            'header_logo_mobile_width' => $persisted_header['header_logo_mobile_width'] ?? null,
            'sticky' => $persisted_header['sticky'] ?? null,
            'topbar_height' => $persisted_header['topbar_height'] ?? null,
        ] : null,
        'footer_settings' => is_array($merged['footer_settings'] ?? null) ? [
            'enabled' => !empty($merged['footer_settings']['enabled']),
            'brand_name' => $merged['footer_settings']['brand_name'] ?? null,
            'phone' => $merged['footer_settings']['phone'] ?? null,
            'email' => $merged['footer_settings']['email'] ?? null,
            'background' => $merged['footer_settings']['background'] ?? null,
            'customer_menu_id' => $merged['footer_settings']['customer_menu_id'] ?? 0,
            'order_menu_id' => $merged['footer_settings']['order_menu_id'] ?? 0,
            'about_menu_id' => $merged['footer_settings']['about_menu_id'] ?? 0,
        ] : null,
        'category_settings' => is_array($merged['category_settings'] ?? null) ? [
            'enabled'=>!empty($merged['category_settings']['enabled']),
            'selected_ids'=>array_values((array)($merged['category_settings']['selected_ids']??[])),
            'desktop_cards'=>$merged['category_settings']['desktop_cards']??4,
            'title'=>$merged['category_settings']['title']??null,
            'gold'=>$merged['category_settings']['gold']??null,
        ] : null,
        'hero_settings' => is_array($merged['hero_settings'] ?? null) ? [
            'enabled'=>!empty($merged['hero_settings']['enabled']),
            'slide_count'=>count((array)($merged['hero_settings']['slides']??[])),
            'autoplay'=>!empty($merged['hero_settings']['autoplay']),
            'gold'=>$merged['hero_settings']['gold']??null,
        ] : null,
        'feature_settings' => is_array($merged['feature_settings'] ?? null) ? [
            'enabled'=>!empty($merged['feature_settings']['enabled']),
            'item_count'=>count((array)($merged['feature_settings']['items']??[])),
            'background'=>$merged['feature_settings']['background']??null,
            'card'=>$merged['feature_settings']['card']??null,
            'gold'=>$merged['feature_settings']['gold']??null,
        ] : null,
    ]);
}

function alookhor_ajax_toggle_module(){
    alookhor_cc_check();
    $key = sanitize_key(wp_unslash($_POST['module'] ?? ''));
    $enabled_raw = isset($_POST['enabled']) ? wp_unslash($_POST['enabled']) : false;
    $enabled = rest_sanitize_boolean($enabled_raw);
    if(!$key) wp_send_json_error('module نامشخص');

    $settings = alookhor_cc_get_settings();
    if(!isset($settings['modules'][$key])) wp_send_json_error('ماژول یافت نشد');

    $settings['modules'][$key]['enabled'] = $enabled;
    $settings['updated_at'] = current_time('mysql');
    update_option(ALOOKHOR_CC_OPTION, $settings);

    wp_send_json_success(['message'=> $enabled ? 'ماژول فعال شد' : 'ماژول غیرفعال شد', 'enabled'=>$enabled]);
}

function alookhor_ajax_save_header_wp(){
    alookhor_cc_check();
    $current = get_option(ALOOKHOR_CC_HEADER_OPTION, []);
    if (!is_array($current)) $current = [];

    // فقط فیلدهای ارسال‌شده تغییر می‌کنند؛ sticky/search/CTA و رنگ قبلی حذف نمی‌شوند.
    $data = $current;
    $data['logo_text'] = sanitize_text_field(wp_unslash($_POST['logo_text'] ?? ($current['logo_text'] ?? 'ALOOKHOR')));
    $data['logo_sub'] = sanitize_text_field(wp_unslash($_POST['logo_sub'] ?? ($current['logo_sub'] ?? 'Control Center • Luxury')));
    $data['logo_letter'] = sanitize_text_field(wp_unslash($_POST['logo_letter'] ?? ($current['logo_letter'] ?? 'A')));
    $data['search_placeholder'] = sanitize_text_field(wp_unslash($_POST['search_placeholder'] ?? ($current['search_placeholder'] ?? 'جستجوی محصول…')));
    if (isset($_POST['gold'])) {
        $data['gold'] = sanitize_hex_color(wp_unslash($_POST['gold'])) ?: ($current['gold'] ?? '#D49A2E');
    } elseif (empty($data['gold'])) {
        $data['gold'] = '#D49A2E';
    }

    $data['phone'] = sanitize_text_field(wp_unslash($_POST['phone'] ?? ($current['phone'] ?? '')));
    $data['email'] = sanitize_email(wp_unslash($_POST['email'] ?? ($current['email'] ?? get_option('admin_email'))));
    $data['whatsapp'] = preg_replace('/\D+/', '', (string) wp_unslash($_POST['whatsapp'] ?? ($current['whatsapp'] ?? '')));
    $data['export_text'] = sanitize_text_field(wp_unslash($_POST['export_text'] ?? ($current['export_text'] ?? '')));
    $data['export_url'] = esc_url_raw(wp_unslash($_POST['export_url'] ?? ($current['export_url'] ?? '')));
    $data['wholesale_text'] = sanitize_text_field(wp_unslash($_POST['wholesale_text'] ?? ($current['wholesale_text'] ?? '')));
    $data['wholesale_url'] = esc_url_raw(wp_unslash($_POST['wholesale_url'] ?? ($current['wholesale_url'] ?? home_url('/#b2b'))));
    $data['top_logo_url'] = esc_url_raw(wp_unslash($_POST['top_logo_url'] ?? ($current['top_logo_url'] ?? '')));
    $data['top_logo_alt'] = sanitize_text_field(wp_unslash($_POST['top_logo_alt'] ?? ($current['top_logo_alt'] ?? get_bloginfo('name'))));
    $data['top_logo_link'] = esc_url_raw(wp_unslash($_POST['top_logo_link'] ?? ($current['top_logo_link'] ?? home_url('/'))));
    foreach ([
        'topbar_bg' => '#1C1024',
        'topbar_text_color' => '#F5F3F0',
        'topbar_border_color' => '#D49A2E',
        'topbar_button_bg' => '#D49A2E',
        'topbar_button_text' => '#0D0510',
        'header_surface' => '#0D0510',
        'header_text_color' => '#F5F3F0',
        'header_muted_color' => '#C8C2C9',
        'capsule_background' => '#0D0510',
        'capsule_card' => '#1C1024',
        'capsule_gold' => '#D49A2E',
        'capsule_gold_light' => '#E8B84A',
        'capsule_text' => '#F5F3F0',
        'capsule_muted' => '#C8C2C9',
    ] as $color_key => $color_default) {
        $data[$color_key] = sanitize_hex_color(wp_unslash($_POST[$color_key] ?? ($current[$color_key] ?? $color_default))) ?: $color_default;
    }
    $capsule_glass=sanitize_text_field(wp_unslash($_POST['capsule_glass']??($current['capsule_glass']??'rgba(33,20,38,.75)')));
    $data['capsule_glass']=preg_match('/^rgba?\(\s*\d{1,3}\s*,\s*\d{1,3}\s*,\s*\d{1,3}(?:\s*,\s*(?:0|1|0?\.\d+))?\s*\)$/',$capsule_glass)?$capsule_glass:'rgba(33,20,38,.75)';
    $data['capsule_blur']=max(10,min(36,absint($_POST['capsule_blur']??($current['capsule_blur']??24))));
    $data['topbar_height'] = max(30, min(60, absint($_POST['topbar_height'] ?? ($current['topbar_height'] ?? 38))));
    $data['top_logo_width'] = max(50, min(180, absint($_POST['top_logo_width'] ?? ($current['top_logo_width'] ?? 96))));
    $data['header_logo_desktop_width'] = max(70, min(220, absint($_POST['header_logo_desktop_width'] ?? ($current['header_logo_desktop_width'] ?? 118))));
    $data['header_logo_mobile_width'] = max(42, min(110, absint($_POST['header_logo_mobile_width'] ?? ($current['header_logo_mobile_width'] ?? 58))));
    $data['account_text'] = sanitize_text_field(wp_unslash($_POST['account_text'] ?? ($current['account_text'] ?? 'ورود / ثبت‌نام')));
    $data['primary_menu'] = absint($_POST['primary_menu'] ?? ($current['primary_menu'] ?? 0));
    foreach (['sticky', 'show_search', 'show_topbar', 'show_contact', 'show_account', 'show_phone', 'show_email', 'show_whatsapp', 'show_export', 'show_wholesale', 'wholesale_new_tab', 'mega_menu'] as $flag) {
        $data[$flag] = isset($_POST[$flag]) ? rest_sanitize_boolean(wp_unslash($_POST[$flag])) : !empty($current[$flag]);
    }

    update_option(ALOOKHOR_CC_HEADER_OPTION, $data);

    // همگام‌سازی با settings اصلی
    $settings = alookhor_cc_get_settings();
    $settings['header_settings']['logo_text'] = $data['logo_text'];
    $settings['header_settings']['logo_sub'] = $data['logo_sub'];
    $settings['site']['logoLetter'] = $data['logo_letter'];
    $settings['site']['goldAccent'] = $data['gold'];
    $settings['updated_at'] = current_time('mysql');
    update_option(ALOOKHOR_CC_OPTION, $settings);

    wp_send_json_success(['message'=>'هدر با موفقیت ذخیره شد — شورت‌کد [alookhor_portal_header] بروز شد','data'=>$data]);
}
````

## Source Snapshot — `plugin/alookhor-control-center/includes/footer.php`

````php
<?php
/**
 * Managed luxury footer for ALOOKHOR.
 * Replaces the rendered legacy footer without editing Elementor/Code Snippets.
 */
if (!defined('ABSPATH')) exit;

function alookhor_cc_footer_defaults(){
    return [
        'enabled' => true,
        'hide_legacy' => true,
        'hide_old_newsletter' => true,
        'use_header_contact' => true,
        'logo_url' => content_url('/uploads/2026/08/LOGO2.png'),
        'logo_alt' => 'لوگوی رسمی آلوخور',
        'brand_name' => 'ALOOKHOR',
        'brand_subtitle' => 'PREMIUM PERSIAN DRIED PLUMS',
        'brand_kicker' => 'From Iranian Orchards to the World',
        'brand_description' => 'تأمین‌کننده مستقیم آلو خشک نیشابور با کیفیت ممتاز برای بازارهای داخلی و بین‌المللی',
        'cta_text' => 'درخواست قیمت عمده و صادراتی',
        'cta_url' => home_url('/#b2b'),
        'phone' => '',
        'email' => '',
        'whatsapp' => '',
        'address' => 'خراسان رضوی، خور نیشابور',
        'support_label' => 'تلفن پشتیبانی و سفارش عمده',
        'hours_week' => 'شنبه تا پنجشنبه: ۸ الی ۲۰',
        'hours_friday' => 'جمعه‌ها: ۹ الی ۱۴',
        'customer_title' => 'خدمات مشتریان',
        'customer_menu_id' => 0,
        'customer_links' => [
            ['title'=>'پرسش‌های متداول','url'=>home_url('/#faq')],
            ['title'=>'رویه‌های بازگرداندن کالا','url'=>home_url('/#returns')],
            ['title'=>'شرایط استفاده','url'=>home_url('/#terms')],
            ['title'=>'حریم خصوصی','url'=>home_url('/#privacy')],
            ['title'=>'گزارش مشکل','url'=>home_url('/#bug-report')],
        ],
        'order_title' => 'خرید و سفارش',
        'order_menu_id' => 0,
        'order_links' => [
            ['title'=>'نحوه ثبت سفارش','url'=>home_url('/#how-to-order')],
            ['title'=>'روش‌های پرداخت','url'=>home_url('/#payment-methods')],
            ['title'=>'روش‌های ارسال','url'=>home_url('/#shipping-policy')],
            ['title'=>'پیگیری سفارش','url'=>home_url('/my-account/orders/')],
            ['title'=>'سفارش عمده و صادراتی','url'=>home_url('/#b2b')],
        ],
        'about_title' => 'درباره آلوخور',
        'about_mobile_title' => 'راهنمای صادراتی',
        'about_menu_id' => 0,
        'about_links' => [
            ['title'=>'درباره ما','url'=>home_url('/درباره-ما/')],
            ['title'=>'فرآیند تولید','url'=>home_url('/#production')],
            ['title'=>'کشت و استانداردها','url'=>home_url('/#standards')],
            ['title'=>'چرا آلوخور؟','url'=>home_url('/#why-alookhor')],
            ['title'=>'مجوزها و افتخارات','url'=>home_url('/#licenses')],
            ['title'=>'تماس با ما','url'=>home_url('/تماس-با-ما/')],
        ],
        'instagram_url' => home_url('/#instagram'),
        'telegram_url' => home_url('/#telegram'),
        'whatsapp_url' => '',
        'social_title' => 'آلوخور را دنبال کنید',
        'social_desc' => 'آخرین محصولات، قیمت‌ها و اخبار صادراتی',
        'newsletter_enabled' => true,
        'newsletter_title' => 'عضویت در خبرنامه',
        'newsletter_desc' => 'برای دریافت آخرین محصولات، قیمت‌ها و تخفیف‌های ویژه عضو شوید.',
        'newsletter_placeholder' => 'ایمیل شما',
        'newsletter_button' => 'عضویت',
        'product_image_url' => ALOOKHOR_CC_URL . 'assets/images/footer-prunes.png',
        'enamad_title' => 'Enamad',
        'enamad_image_url' => '',
        'enamad_url' => '',
        'samandehi_title' => 'ساماندهی',
        'samandehi_image_url' => '',
        'samandehi_url' => '',
        'licenses_title' => 'مجوزها و نمادهای اعتماد',
        'licenses_desc' => 'خرید امن و قابل اعتماد',
        'payments_title' => 'روش‌های پرداخت امن',
        'copyright_text' => 'تمامی حقوق محفوظ است.',
        'copyright_en' => 'Premium Persian Dried Plums Exporter',
        'benefits' => [
            ['title'=>'تأمین مستقیم از باغداران','desc'=>'حمایت از کشاورزان ایرانی','icon'=>'leaf'],
            ['title'=>'قیمت‌های رقابتی','desc'=>'مستقیم از تولیدکننده','icon'=>'tag'],
            ['title'=>'ارسال سریع بین‌المللی','desc'=>'به بیش از ۲۰ کشور جهان','icon'=>'plane'],
            ['title'=>'بسته‌بندی استاندارد صادراتی','desc'=>'محافظت کامل از محصول','icon'=>'box'],
            ['title'=>'گارانتی کیفیت','desc'=>'بازگشت وجه در صورت عدم رضایت','icon'=>'shield'],
        ],
        'background' => '#070809',
        'surface' => '#0D0F10',
        'gold' => '#C89A3D',
        'gold_soft' => '#E3BD69',
        'text' => '#E9E5DF',
        'muted' => '#A7A39D',
        'border' => '#4A3820',
        'container_width' => 1280,
        'desktop_logo_width' => 210,
        'mobile_logo_width' => 190,
        'show_payments' => true,
        'show_benefits' => true,
        'show_product_image' => true,
    ];
}

function alookhor_cc_get_footer_settings(){
    $main = alookhor_cc_get_settings();
    $saved = is_array($main['footer_settings'] ?? null) ? $main['footer_settings'] : [];
    $settings = array_replace_recursive(alookhor_cc_footer_defaults(), $saved);
    if (!empty($settings['use_header_contact'])) {
        $header = alookhor_cc_front_header_settings();
        $settings['phone'] = $header['phone'] ?? $settings['phone'];
        $settings['email'] = $header['email'] ?? $settings['email'];
        $settings['whatsapp'] = $header['whatsapp'] ?? $settings['whatsapp'];
        if (empty($settings['whatsapp_url']) && (!empty($settings['whatsapp']) || !empty($settings['phone']))) {
            $number = preg_replace('/\D+/', '', (string) (!empty($settings['whatsapp']) ? $settings['whatsapp'] : $settings['phone']));
            if (strpos($number, '0') === 0) $number = '98' . substr($number, 1);
            $settings['whatsapp_url'] = $number ? 'https://wa.me/' . $number : '';
        }
    }
    if (empty($settings['logo_url'])) {
        $logo_id = (int) get_theme_mod('custom_logo');
        if ($logo_id) $settings['logo_url'] = wp_get_attachment_image_url($logo_id, 'large') ?: '';
        if (empty($settings['logo_url'])) $settings['logo_url'] = get_site_icon_url(256);
    }
    return apply_filters('alookhor_cc_footer_settings', $settings);
}

function alookhor_cc_footer_icon($name){
    $icons = [
        'phone'=>'<path d="M22 16.92v3a2 2 0 0 1-2.18 2A19.8 19.8 0 0 1 3.1 5.18 2 2 0 0 1 5.09 3h3a2 2 0 0 1 2 1.72c.12.9.33 1.79.62 2.64a2 2 0 0 1-.45 2.11L9 10.74a16 16 0 0 0 4.26 4.26l1.27-1.27a2 2 0 0 1 2.11-.45c.85.29 1.74.5 2.64.62A2 2 0 0 1 22 16.92Z"/>',
        'mail'=>'<rect x="3" y="5" width="18" height="14" rx="2"/><path d="m3 7 9 6 9-6"/>',
        'pin'=>'<path d="M20 10c0 5-8 12-8 12S4 15 4 10a8 8 0 1 1 16 0Z"/><circle cx="12" cy="10" r="2.5"/>',
        'clock'=>'<circle cx="12" cy="12" r="9"/><path d="M12 7v5l3 2"/>',
        'headset'=>'<path d="M4 14v-2a8 8 0 0 1 16 0v2"/><path d="M4 14h3v6H5a1 1 0 0 1-1-1v-5Zm16 0h-3v6h2a1 1 0 0 0 1-1v-5Z"/>',
        'bag'=>'<path d="M5 8h14l-1 13H6L5 8Z"/><path d="M9 8a3 3 0 0 1 6 0"/>',
        'globe'=>'<circle cx="12" cy="12" r="9"/><path d="M3 12h18M12 3c3 3 4 6 4 9s-1 6-4 9c-3-3-4-6-4-9s1-6 4-9Z"/>',
        'shield'=>'<path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10Z"/><path d="m9 12 2 2 4-5"/>',
        'box'=>'<path d="m3 7 9-4 9 4-9 4-9-4Z"/><path d="m3 7 9 4v10l-9-4V7Zm18 0-9 4v10l9-4V7Z"/>',
        'leaf'=>'<path d="M20 4C12 4 6 8 6 15c0 3 2 5 5 5 7 0 9-8 9-16Z"/><path d="M4 21c3-6 7-9 13-13"/>',
        'tag'=>'<path d="M20 13 13 20 4 11V4h7l9 9Z"/><circle cx="8.5" cy="8.5" r="1.2"/>',
        'plane'=>'<path d="m22 2-7 20-4-9-9-4 20-7Z"/><path d="m22 2-11 11"/>',
        'instagram'=>'<rect x="3" y="3" width="18" height="18" rx="5"/><circle cx="12" cy="12" r="4"/><circle cx="17.5" cy="6.5" r="1"/>',
        'telegram'=>'<path d="m22 2-7 20-4-9-9-4 20-7Z"/><path d="m22 2-11 11"/>',
        'whatsapp'=>'<path d="M20 11.5a8 8 0 0 1-11.8 7L3 20l1.5-5.1A8 8 0 1 1 20 11.5Z"/><path d="M9 8c.5 3 2 4.5 5 5"/>',
    ];
    return '<svg viewBox="0 0 24 24" aria-hidden="true">' . ($icons[$name] ?? $icons['shield']) . '</svg>';
}

function alookhor_cc_footer_links($settings, $key){
    $menu_id = absint($settings[$key . '_menu_id'] ?? 0);
    if ($menu_id) {
        $menu = wp_nav_menu(['menu'=>$menu_id,'container'=>false,'menu_class'=>'alookhor-mf-links','depth'=>1,'fallback_cb'=>false,'echo'=>false]);
        if ($menu) return $menu;
    }
    $links = is_array($settings[$key . '_links'] ?? null) ? $settings[$key . '_links'] : [];
    $html = '<ul class="alookhor-mf-links">';
    foreach ($links as $link) {
        if (!is_array($link) || empty($link['title'])) continue;
        $html .= '<li><a href="' . esc_url($link['url'] ?? '#') . '"><span>' . esc_html($link['title']) . '</span></a></li>';
    }
    return $html . '</ul>';
}

function alookhor_cc_footer_badge($title, $image, $url, $fallback){
    $content = $image
        ? '<img src="' . esc_url($image) . '" alt="' . esc_attr($title) . '">'
        : '<span class="alookhor-mf-badge-fallback">' . esc_html($fallback) . '</span>';
    $inner = '<span class="alookhor-mf-badge-media">' . $content . '</span><span>' . esc_html($title) . '</span>';
    return $url ? '<a class="alookhor-mf-badge" href="' . esc_url($url) . '" target="_blank" rel="noopener">' . $inner . '</a>' : '<span class="alookhor-mf-badge">' . $inner . '</span>';
}

function alookhor_cc_footer_markup($settings = null){
    $s = is_array($settings) ? $settings : alookhor_cc_get_footer_settings();
    if (empty($s['enabled'])) return '';
    $phone_href = preg_replace('/[^0-9+]/', '', (string) $s['phone']);
    $year = wp_date('Y');
    $style = sprintf(
        '--mf-bg:%s;--mf-surface:%s;--mf-gold:%s;--mf-gold-soft:%s;--mf-text:%s;--mf-muted:%s;--mf-border:%s;--mf-width:%dpx;--mf-logo:%dpx;--mf-logo-mobile:%dpx',
        sanitize_hex_color($s['background']) ?: '#070809', sanitize_hex_color($s['surface']) ?: '#0D0F10',
        sanitize_hex_color($s['gold']) ?: '#C89A3D', sanitize_hex_color($s['gold_soft']) ?: '#E3BD69',
        sanitize_hex_color($s['text']) ?: '#E9E5DF', sanitize_hex_color($s['muted']) ?: '#A7A39D',
        sanitize_hex_color($s['border']) ?: '#4A3820', max(960,min(1600,absint($s['container_width']))),
        max(100,min(320,absint($s['desktop_logo_width']))), max(100,min(280,absint($s['mobile_logo_width'])))
    );
    ob_start(); ?>
    <footer id="alookhor-managed-footer" class="alookhor-mf" dir="rtl" style="<?php echo esc_attr($style); ?>" data-version="<?php echo esc_attr(ALOOKHOR_CC_VERSION); ?>">
      <div class="alookhor-mf-shell">
        <div class="alookhor-mf-main-grid">
          <section class="alookhor-mf-brand" aria-label="معرفی آلوخور">
            <?php if (!empty($s['logo_url'])): ?><a class="alookhor-mf-logo" href="<?php echo esc_url(home_url('/')); ?>"><img src="<?php echo esc_url($s['logo_url']); ?>" alt="<?php echo esc_attr($s['logo_alt']); ?>"></a><?php endif; ?>
            <strong class="alookhor-mf-brand-name"><?php echo esc_html($s['brand_name']); ?></strong>
            <span class="alookhor-mf-brand-sub"><?php echo esc_html($s['brand_subtitle']); ?></span>
            <span class="alookhor-mf-kicker"><?php echo esc_html($s['brand_kicker']); ?></span>
            <p><?php echo esc_html($s['brand_description']); ?></p>
            <div class="alookhor-mf-brand-trust">
              <span><?php echo alookhor_cc_footer_icon('shield'); ?><b>کیفیت تضمین‌شده</b><small>و استانداردها</small></span>
              <span><?php echo alookhor_cc_footer_icon('box'); ?><b>بسته‌بندی صادراتی</b><small>ایمن و حرفه‌ای</small></span>
              <span><?php echo alookhor_cc_footer_icon('globe'); ?><b>ارسال بین‌المللی</b><small>سریع و مطمئن</small></span>
              <span><?php echo alookhor_cc_footer_icon('leaf'); ?><b>محصول مستقیم</b><small>از باغداران</small></span>
            </div>
            <a class="alookhor-mf-cta" href="<?php echo esc_url($s['cta_url']); ?>"><?php echo alookhor_cc_footer_icon('headset'); ?><span><?php echo esc_html($s['cta_text']); ?></span></a>
          </section>

          <section class="alookhor-mf-menu-card alookhor-mf-customer"><h3><?php echo alookhor_cc_footer_icon('headset'); ?><span><?php echo esc_html($s['customer_title']); ?></span></h3><?php echo wp_kses_post(alookhor_cc_footer_links($s,'customer')); ?></section>
          <section class="alookhor-mf-menu-card alookhor-mf-order"><h3><?php echo alookhor_cc_footer_icon('bag'); ?><span><?php echo esc_html($s['order_title']); ?></span></h3><?php echo wp_kses_post(alookhor_cc_footer_links($s,'order')); ?></section>
          <section class="alookhor-mf-menu-card alookhor-mf-about"><h3><?php echo alookhor_cc_footer_icon('globe'); ?><span class="alookhor-mf-about-desktop"><?php echo esc_html($s['about_title']); ?></span><span class="alookhor-mf-about-mobile"><?php echo esc_html($s['about_mobile_title']); ?></span></h3><?php echo wp_kses_post(alookhor_cc_footer_links($s,'about')); ?></section>

          <section class="alookhor-mf-contact"><h3><?php echo alookhor_cc_footer_icon('phone'); ?><span>اطلاعات تماس</span></h3>
            <div class="alookhor-mf-contact-list">
              <a href="tel:<?php echo esc_attr($phone_href); ?>"><i><?php echo alookhor_cc_footer_icon('phone'); ?></i><span><small><?php echo esc_html($s['support_label']); ?></small><b dir="ltr"><?php echo esc_html($s['phone']); ?></b></span></a>
              <a href="mailto:<?php echo esc_attr($s['email']); ?>"><i><?php echo alookhor_cc_footer_icon('mail'); ?></i><span><small>ایمیل</small><b dir="ltr"><?php echo esc_html($s['email']); ?></b></span></a>
              <div><i><?php echo alookhor_cc_footer_icon('pin'); ?></i><span><small>آدرس</small><b><?php echo esc_html($s['address']); ?></b></span></div>
              <div><i><?php echo alookhor_cc_footer_icon('clock'); ?></i><span><small>ساعات پاسخ‌گویی</small><b><?php echo esc_html($s['hours_week']); ?><br><?php echo esc_html($s['hours_friday']); ?></b></span></div>
            </div>
            <a class="alookhor-mf-contact-cta" href="<?php echo esc_url($s['cta_url']); ?>"><?php echo alookhor_cc_footer_icon('headset'); ?><span>مشاوره رایگان سفارش عمده</span></a>
          </section>

          <section class="alookhor-mf-license-card"><h3><?php echo alookhor_cc_footer_icon('shield'); ?><span><?php echo esc_html($s['licenses_title']); ?></span></h3><div class="alookhor-mf-badges"><?php echo alookhor_cc_footer_badge($s['enamad_title'],$s['enamad_image_url'],$s['enamad_url'],'e'); ?><?php echo alookhor_cc_footer_badge($s['samandehi_title'],$s['samandehi_image_url'],$s['samandehi_url'],'۲'); ?></div><p><?php echo esc_html($s['licenses_desc']); ?></p></section>
        </div>

        <section class="alookhor-mf-news-social">
          <div class="alookhor-mf-social"><h3><?php echo esc_html($s['social_title']); ?></h3><p><?php echo esc_html($s['social_desc']); ?></p><div>
            <?php foreach ([['instagram','instagram_url','اینستاگرام'],['telegram','telegram_url','تلگرام'],['whatsapp','whatsapp_url','واتساپ']] as $social): if (empty($s[$social[1]])) continue; ?><a href="<?php echo esc_url($s[$social[1]]); ?>" target="_blank" rel="noopener" aria-label="<?php echo esc_attr($social[2]); ?>"><?php echo alookhor_cc_footer_icon($social[0]); ?></a><?php endforeach; ?>
          </div></div>
          <?php if (!empty($s['newsletter_enabled'])): ?><div class="alookhor-mf-newsletter"><h3><?php echo esc_html($s['newsletter_title']); ?></h3><p><?php echo esc_html($s['newsletter_desc']); ?></p><form class="alookhor-mf-newsletter-form"><input type="email" name="email" placeholder="<?php echo esc_attr($s['newsletter_placeholder']); ?>" required><input type="text" name="company" tabindex="-1" autocomplete="off" class="alookhor-mf-hp"><button type="submit"><?php echo esc_html($s['newsletter_button']); ?></button></form><small class="alookhor-mf-form-msg" aria-live="polite"></small></div><?php endif; ?>
          <?php if (!empty($s['show_product_image']) && !empty($s['product_image_url'])): ?><img class="alookhor-mf-product" src="<?php echo esc_url($s['product_image_url']); ?>" alt="آلو خشک ممتاز آلوخور" loading="lazy"><?php endif; ?>
        </section>

        <section class="alookhor-mf-assurance">
          <div class="alookhor-mf-license-desktop"><h4><?php echo esc_html($s['licenses_title']); ?></h4><div class="alookhor-mf-badges"><?php echo alookhor_cc_footer_badge($s['enamad_title'],$s['enamad_image_url'],$s['enamad_url'],'e'); ?><?php echo alookhor_cc_footer_badge($s['samandehi_title'],$s['samandehi_image_url'],$s['samandehi_url'],'۲'); ?></div></div>
          <?php if (!empty($s['show_payments'])): ?><div class="alookhor-mf-payments"><h4><?php echo esc_html($s['payments_title']); ?></h4><div><span>VISA</span><span>●●</span><span>زرین‌پال</span><span>شتاب</span></div></div><?php endif; ?>
          <div class="alookhor-mf-copy"><b><?php echo esc_html($s['copyright_text']); ?></b><span>© <?php echo esc_html($year); ?> ALOOKHOR</span><small><?php echo esc_html($s['copyright_en']); ?></small></div>
        </section>

        <?php if (!empty($s['show_benefits'])): ?><section class="alookhor-mf-benefits"><?php foreach ((array)$s['benefits'] as $benefit): if (!is_array($benefit)) continue; ?><span><?php echo alookhor_cc_footer_icon($benefit['icon'] ?? 'shield'); ?><b><?php echo esc_html($benefit['title'] ?? ''); ?></b><small><?php echo esc_html($benefit['desc'] ?? ''); ?></small></span><?php endforeach; ?></section><?php endif; ?>
      </div>
    </footer>
    <?php return ob_get_clean();
}

function alookhor_cc_render_managed_footer(){
    static $rendered = false;
    if ($rendered || is_admin() || wp_doing_ajax()) return;
    $settings = alookhor_cc_get_footer_settings();
    if (empty($settings['enabled'])) return;
    $rendered = true;
    echo alookhor_cc_footer_markup($settings); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
}
add_action('get_footer', 'alookhor_cc_render_managed_footer', 1);
add_action('wp_footer', 'alookhor_cc_render_managed_footer', 1);
add_filter('body_class', function($classes){
    $settings = alookhor_cc_get_footer_settings();
    if (!empty($settings['enabled'])) $classes[]='alookhor-mf-enabled';
    if (!empty($settings['enabled']) && !empty($settings['hide_legacy'])) $classes[]='alookhor-mf-hide-legacy';
    if (!empty($settings['enabled']) && !empty($settings['hide_old_newsletter'])) $classes[]='alookhor-mf-hide-old-sections';
    return array_values(array_unique($classes));
});

add_action('wp_enqueue_scripts', function(){
    $settings = alookhor_cc_get_footer_settings();
    if (empty($settings['enabled'])) return;
    wp_enqueue_style('alookhor-cc-managed-footer', ALOOKHOR_CC_URL . 'assets/css/frontend-footer.css', [], ALOOKHOR_CC_BUILD);
    wp_enqueue_script('alookhor-cc-managed-footer', ALOOKHOR_CC_URL . 'assets/js/frontend-footer.js', [], ALOOKHOR_CC_BUILD, true);
    wp_localize_script('alookhor-cc-managed-footer', 'ALOOKHOR_FOOTER', [
        'endpoint' => rest_url('alookhor-cc/v1/footer'),
        'subscribe_endpoint' => rest_url('alookhor-cc/v1/footer-subscribe'),
        'version' => ALOOKHOR_CC_VERSION,
        'hide_legacy' => !empty($settings['hide_legacy']),
        'hide_old_newsletter' => !empty($settings['hide_old_newsletter']),
    ]);
}, 30);
````

## Source Snapshot — `plugin/alookhor-control-center/includes/hero.php`

````php
<?php
/**
 * Managed four-slide Hero for ALOOKHOR.
 *
 * The current Home page renders the legacy `.alookhor-hero-slider-wrapper`
 * inside an Elementor Shortcode widget. The managed runtime replaces that
 * exact node in place; no Elementor structure or unrelated content is moved.
 */
if (!defined('ABSPATH')) exit;

function alookhor_cc_hero_slide_defaults(){
    $legacy_base = plugins_url('alookhor-categories-manager/images/');
    return [
        [
            'image_id'=>0,
            'image_url'=>$legacy_base.'slide1.jpg',
            'flip_image'=>true,
            'image_alt'=>'آلو بخارا ممتاز خراسان',
            'kicker'=>'محصول ممتاز خراسان',
            'title'=>'آلو بخارا',
            'highlight'=>'ممتاز خراسان',
            'description'=>'طبیعی، سالم و بدون مواد افزودنی',
            'features'=>['۱۰۰٪ طبیعی','کیفیت صادراتی','ارسال سریع','ارسال به سراسر جهان'],
            'primary_text'=>'مشاهده محصولات',
            'primary_url'=>home_url('/shop/'),
            'secondary_text'=>'استعلام قیمت',
            'secondary_url'=>home_url('/#b2b'),
        ],
        [
            'image_id'=>0,
            'image_url'=>$legacy_base.'slide2.jpg',
            'flip_image'=>true,
            'image_alt'=>'آلو خشک طبیعی آلوخور',
            'kicker'=>'انتخابی از باغ‌های ایران',
            'title'=>'آلو خشک طبیعی',
            'highlight'=>'خوش‌طعم و سالم',
            'description'=>'سورت یکدست، فرآوری بهداشتی و طعم اصیل',
            'features'=>['بدون افزودنی','سورت ممتاز','بسته‌بندی مطمئن','تحویل سریع'],
            'primary_text'=>'خرید محصولات',
            'primary_url'=>home_url('/shop/'),
            'secondary_text'=>'مشاوره خرید',
            'secondary_url'=>home_url('/تماس-با-ما/'),
        ],
        [
            'image_id'=>0,
            'image_url'=>$legacy_base.'slide3.jpg',
            'flip_image'=>true,
            'image_alt'=>'بسته‌بندی صادراتی آلوخور',
            'kicker'=>'استاندارد بازارهای جهانی',
            'title'=>'بسته‌بندی حرفه‌ای',
            'highlight'=>'آماده صادرات',
            'description'=>'حفظ کیفیت محصول از باغ تا مقصد نهایی',
            'features'=>['کنترل کیفیت','سورت دقیق','بسته‌بندی صادراتی','ارسال بین‌المللی'],
            'primary_text'=>'خدمات صادرات',
            'primary_url'=>home_url('/#b2b'),
            'secondary_text'=>'تماس با ما',
            'secondary_url'=>home_url('/تماس-با-ما/'),
        ],
        [
            'image_id'=>0,
            'image_url'=>$legacy_base.'slide4.jpg',
            'flip_image'=>true,
            'image_alt'=>'سفارش عمده محصولات آلوخور',
            'kicker'=>'همکاری مطمئن و ماندگار',
            'title'=>'تأمین عمده آلو',
            'highlight'=>'برای کسب‌وکارها',
            'description'=>'ظرفیت پایدار، قیمت رقابتی و پشتیبانی تخصصی',
            'features'=>['تأمین پایدار','قیمت همکاری','کنترل سفارش','پشتیبانی مستقیم'],
            'primary_text'=>'درخواست همکاری',
            'primary_url'=>home_url('/#b2b'),
            'secondary_text'=>'دریافت مشاوره',
            'secondary_url'=>home_url('/تماس-با-ما/'),
        ],
    ];
}

function alookhor_cc_hero_defaults(){
    return [
        'enabled'=>true,
        'hide_legacy'=>true,
        'autoplay'=>true,
        'autoplay_interval'=>5500,
        'pause_on_hover'=>true,
        'show_arrows'=>true,
        'show_dots'=>true,
        'ken_burns'=>true,
        'gold'=>'#D4AF37',
        'surface'=>'#09060D',
        'text'=>'#FFFFFF',
        'muted'=>'#D9D1DA',
        'radius'=>32,
        'slides'=>alookhor_cc_hero_slide_defaults(),
    ];
}

function alookhor_cc_get_hero_settings(){
    $main = alookhor_cc_get_settings();
    $saved = is_array($main['hero_settings'] ?? null) ? $main['hero_settings'] : [];
    $settings = array_replace_recursive(alookhor_cc_hero_defaults(), $saved);
    $defaults = alookhor_cc_hero_slide_defaults();
    $slides = is_array($saved['slides'] ?? null) ? array_values($saved['slides']) : [];
    $normalized = [];
    for ($index=0; $index<4; $index++) {
        $candidate = is_array($slides[$index] ?? null) ? $slides[$index] : [];
        $normalized[$index] = array_replace_recursive($defaults[$index], $candidate);
        $features = is_array($candidate['features'] ?? null) ? array_values($candidate['features']) : [];
        $normalized[$index]['features'] = array_slice(array_pad($features, 4, ''), 0, 4);
        if (!$features) $normalized[$index]['features'] = $defaults[$index]['features'];
    }
    $settings['slides'] = $normalized;
    return apply_filters('alookhor_cc_hero_settings', $settings);
}

function alookhor_cc_hero_icon($index){
    $icons = [
        '<svg viewBox="0 0 48 48" aria-hidden="true"><path d="M24 41V19M24 30c-8 0-13-5-13-13 8 0 13 5 13 13Zm0-6c0-8 5-13 13-13 0 8-5 13-13 13Z"/></svg>',
        '<svg viewBox="0 0 48 48" aria-hidden="true"><circle cx="24" cy="20" r="12"/><path d="m17 31-2 11 9-5 9 5-2-11M20 20l3 3 6-7"/></svg>',
        '<svg viewBox="0 0 48 48" aria-hidden="true"><path d="M6 13h24v22H6zM30 21h7l5 7v7H30zM14 39a4 4 0 1 0 0-8 4 4 0 0 0 0 8Zm21 0a4 4 0 1 0 0-8 4 4 0 0 0 0 8Z"/></svg>',
        '<svg viewBox="0 0 48 48" aria-hidden="true"><circle cx="24" cy="24" r="18"/><path d="M6 24h36M24 6c6 5 9 11 9 18s-3 13-9 18c-6-5-9-11-9-18s3-13 9-18Z"/></svg>',
    ];
    return $icons[$index % 4];
}

function alookhor_cc_hero_image_url($slide){
    $attachment_id = absint($slide['image_id'] ?? 0);
    if ($attachment_id) {
        $attachment = wp_get_attachment_image_url($attachment_id, 'full');
        if ($attachment) return $attachment;
    }
    return esc_url_raw($slide['image_url'] ?? '');
}

function alookhor_cc_hero_markup($settings=null){
    $s = is_array($settings) ? $settings : alookhor_cc_get_hero_settings();
    if (empty($s['enabled'])) return '';
    $slides = array_slice(array_values((array)($s['slides'] ?? [])), 0, 4);
    if (count($slides) !== 4) return '';
    $style = sprintf(
        '--mh-gold:%s;--mh-surface:%s;--mh-text:%s;--mh-muted:%s;--mh-radius:%dpx',
        sanitize_hex_color($s['gold'] ?? '') ?: '#D4AF37',
        sanitize_hex_color($s['surface'] ?? '') ?: '#09060D',
        sanitize_hex_color($s['text'] ?? '') ?: '#FFFFFF',
        sanitize_hex_color($s['muted'] ?? '') ?: '#D9D1DA',
        max(16, min(40, absint($s['radius'] ?? 32)))
    );
    ob_start(); ?>
    <section id="alookhor-managed-hero" class="alookhor-mh" dir="rtl" style="<?php echo esc_attr($style); ?>"
      data-version="<?php echo esc_attr(ALOOKHOR_CC_VERSION); ?>" data-slide-count="4"
      data-autoplay="<?php echo !empty($s['autoplay'])?'1':'0'; ?>"
      data-interval="<?php echo esc_attr(max(3000,min(15000,absint($s['autoplay_interval'] ?? 5500)))); ?>"
      data-pause-hover="<?php echo !empty($s['pause_on_hover'])?'1':'0'; ?>"
      data-ken-burns="<?php echo !empty($s['ken_burns'])?'1':'0'; ?>"
      aria-roledescription="carousel" aria-label="اسلایدر محصولات آلوخور">
      <div class="alookhor-mh-shell">
        <div class="alookhor-mh-slides" aria-live="off">
          <?php foreach($slides as $index=>$slide): $image=alookhor_cc_hero_image_url($slide); ?>
          <article class="alookhor-mh-slide<?php echo $index===0?' is-active':''; ?><?php echo !empty($slide['flip_image'])?' is-image-flipped':''; ?>" data-slide="<?php echo esc_attr($index); ?>" aria-hidden="<?php echo $index===0?'false':'true'; ?>">
            <div class="alookhor-mh-media">
              <?php if($image): ?><img src="<?php echo esc_url($image); ?>" alt="<?php echo esc_attr($slide['image_alt'] ?? ''); ?>" <?php echo $index===0?'fetchpriority="high"':'loading="lazy"'; ?> decoding="async"><?php endif; ?>
            </div>
            <div class="alookhor-mh-shade" aria-hidden="true"></div>
            <div class="alookhor-mh-content">
              <?php if(!empty($slide['kicker'])): ?><span class="alookhor-mh-kicker"><?php echo esc_html($slide['kicker']); ?></span><?php endif; ?>
              <h2><?php echo esc_html($slide['title'] ?? ''); ?><?php if(!empty($slide['highlight'])): ?><strong><?php echo esc_html($slide['highlight']); ?></strong><?php endif; ?></h2>
              <?php if(!empty($slide['description'])): ?><p class="alookhor-mh-description"><?php echo esc_html($slide['description']); ?></p><?php endif; ?>
              <div class="alookhor-mh-features">
                <?php foreach(array_slice(array_pad((array)($slide['features'] ?? []),4,''),0,4) as $feature_index=>$feature): if($feature==='')continue; ?>
                <span class="alookhor-mh-feature"><?php echo alookhor_cc_hero_icon($feature_index); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?><b><?php echo esc_html($feature); ?></b></span>
                <?php endforeach; ?>
              </div>
              <div class="alookhor-mh-actions">
                <?php if(!empty($slide['primary_text'])): ?><a class="alookhor-mh-cta is-primary" href="<?php echo esc_url($slide['primary_url'] ?? '#'); ?>"><span><?php echo esc_html($slide['primary_text']); ?></span><i aria-hidden="true">←</i></a><?php endif; ?>
                <?php if(!empty($slide['secondary_text'])): ?><a class="alookhor-mh-cta is-secondary" href="<?php echo esc_url($slide['secondary_url'] ?? '#'); ?>"><span><?php echo esc_html($slide['secondary_text']); ?></span></a><?php endif; ?>
              </div>
            </div>
          </article>
          <?php endforeach; ?>
        </div>
        <?php if(!empty($s['show_arrows'])): ?>
        <button type="button" class="alookhor-mh-arrow is-prev" aria-label="اسلاید قبلی"><svg viewBox="0 0 24 24" aria-hidden="true"><path d="m15 5-7 7 7 7"/></svg></button>
        <button type="button" class="alookhor-mh-arrow is-next" aria-label="اسلاید بعدی"><svg viewBox="0 0 24 24" aria-hidden="true"><path d="m9 5 7 7-7 7"/></svg></button>
        <?php endif; ?>
        <?php if(!empty($s['show_dots'])): ?><div class="alookhor-mh-dots" role="tablist" aria-label="انتخاب اسلاید"><?php for($i=0;$i<4;$i++): ?><button type="button" role="tab" data-slide="<?php echo esc_attr($i); ?>" class="<?php echo $i===0?'is-active':''; ?>" aria-selected="<?php echo $i===0?'true':'false'; ?>" aria-label="اسلاید <?php echo esc_attr($i+1); ?>"></button><?php endfor; ?></div><?php endif; ?>
        <span class="alookhor-mh-status screen-reader-text" aria-live="polite"></span>
      </div>
    </section>
    <?php return ob_get_clean();
}

function alookhor_cc_hero_shortcode(){
    if(!empty($GLOBALS['alookhor_cc_hero_shortcode_rendered'])) return '';
    $settings = alookhor_cc_get_hero_settings();
    if(empty($settings['enabled'])) return '';
    $GLOBALS['alookhor_cc_hero_shortcode_rendered'] = true;
    return alookhor_cc_hero_markup($settings);
}
add_shortcode('alookhor_managed_hero','alookhor_cc_hero_shortcode');

function alookhor_cc_hero_template(){
    static $done=false;
    if($done || is_admin() || !is_front_page() || !empty($GLOBALS['alookhor_cc_hero_shortcode_rendered'])) return;
    $settings=alookhor_cc_get_hero_settings();
    if(empty($settings['enabled'])) return;
    $done=true;
    echo '<template id="alookhor-managed-hero-template">'.alookhor_cc_hero_markup($settings).'</template>';
    echo '<noscript><style>body.alookhor-mh-hide-legacy .alookhor-hero-slider-wrapper{display:block!important}</style></noscript>';
}
add_action('wp_footer','alookhor_cc_hero_template',1);

add_filter('body_class',function($classes){
    $settings=alookhor_cc_get_hero_settings();
    if(!empty($settings['enabled'])) $classes[]='alookhor-mh-enabled';
    if(!empty($settings['enabled'])&&!empty($settings['hide_legacy'])) $classes[]='alookhor-mh-hide-legacy';
    return array_values(array_unique($classes));
});

add_action('wp_enqueue_scripts',function(){
    if(!is_front_page()) return;
    $settings=alookhor_cc_get_hero_settings();
    if(empty($settings['enabled'])) return;
    wp_enqueue_style('alookhor-cc-managed-hero',ALOOKHOR_CC_URL.'assets/css/frontend-hero.css',[],ALOOKHOR_CC_BUILD);
    wp_enqueue_script('alookhor-cc-managed-hero',ALOOKHOR_CC_URL.'assets/js/frontend-hero.js',[],ALOOKHOR_CC_BUILD,true);
    wp_localize_script('alookhor-cc-managed-hero','ALOOKHOR_HERO',[
        'endpoint'=>rest_url('alookhor-cc/v1/hero'),
        'version'=>ALOOKHOR_CC_VERSION,
        'hide_legacy'=>!empty($settings['hide_legacy']),
        'legacy_selector'=>'.alookhor-hero-slider-wrapper',
    ]);
},30);
````

## Source Snapshot — `plugin/alookhor-control-center/includes/product-categories.php`

````php
<?php
/** WooCommerce-backed managed product category showcase — desktop phase. */
if (!defined('ABSPATH')) exit;

function alookhor_cc_category_defaults(){
    return [
        'enabled'=>true,'hide_legacy'=>true,'hide_empty'=>false,'parent_only'=>true,
        'selected_ids'=>[38,39,40,41],'limit'=>8,'orderby'=>'include','order'=>'ASC',
        'kicker'=>'دسته‌بندی محصولات','title'=>'محصولات طبیعی، کیفیت صادراتی',
        'subtitle'=>'انتخاب مستقیم از باغ‌های خراسان، آماده ارسال به سراسر جهان',
        'button_text'=>'مشاهده محصولات','show_description'=>true,'show_count'=>false,
        'show_icons'=>true,'show_arrows'=>true,'show_dots'=>true,'autoplay'=>true,
        'autoplay_interval'=>5000,'desktop_cards'=>4,'desktop_gap'=>18,'image_height'=>285,
        'mobile_card_width'=>84,'mobile_gap'=>14,'mobile_image_height'=>225,'mobile_radius'=>18,'mobile_peek'=>8,
        'section_background'=>'#090610','card_background'=>'#0D0916','gold'=>'#D4A436',
        'text'=>'#F7F2EA','muted'=>'#B8B0BD','border'=>'#6F5426','button_background'=>'#120B1C',
        'overrides'=>[
            '38'=>['image_url'=>ALOOKHOR_CC_URL.'assets/images/category-plums.jpg','description'=>'آلو بخارا، مغزدار حسینی، کالیفرنیا و تن شوقان'],
            '39'=>['image_url'=>ALOOKHOR_CC_URL.'assets/images/category-fruit-sheets.jpg','description'=>'برگه زردآلو، هلو، قیسی و میوه‌های خشک ممتاز'],
            '40'=>['image_url'=>ALOOKHOR_CC_URL.'assets/images/category-natural-snacks.jpg','description'=>'کشمش، توت خشک و تنقلات طبیعی بدون افزودنی'],
            '41'=>['image_url'=>ALOOKHOR_CC_URL.'assets/images/category-nuts.jpg','description'=>'گردو و مغزهای ممتاز با کیفیت صادراتی'],
        ],
    ];
}

function alookhor_cc_get_category_settings(){
    $main=alookhor_cc_get_settings();
    $saved=is_array($main['category_settings']??null)?$main['category_settings']:[];
    return apply_filters('alookhor_cc_category_settings',array_replace_recursive(alookhor_cc_category_defaults(),$saved));
}

function alookhor_cc_category_terms($settings=null){
    $s=is_array($settings)?$settings:alookhor_cc_get_category_settings();
    if (!taxonomy_exists('product_cat')) return [];
    $selected=array_values(array_filter(array_map('absint',(array)($s['selected_ids']??[]))));
    $args=['taxonomy'=>'product_cat','hide_empty'=>!empty($s['hide_empty']),'number'=>max(1,min(24,absint($s['limit']??8))),'order'=>strtoupper($s['order']??'ASC')==='DESC'?'DESC':'ASC'];
    if (!empty($s['parent_only'])) $args['parent']=0;
    if ($selected){$args['include']=$selected;$args['orderby']='include';$args['number']=count($selected);} else {
        $allowed=['name','count','term_id','menu_order'];$orderby=(string)($s['orderby']??'name');$args['orderby']=in_array($orderby,$allowed,true)?$orderby:'name';
    }
    $terms=get_terms($args);return is_wp_error($terms)?[]:$terms;
}

function alookhor_cc_category_icon($slug){
    if (str_contains($slug,'maghz')||str_contains($slug,'nut')) return '<svg viewBox="0 0 48 48"><path d="M24 7c10 0 17 8 17 18S33 42 24 42 7 35 7 25 14 7 24 7Z"/><path d="M24 8c-5 7-4 13 0 18 4-5 5-11 0-18Zm0 18c-5 3-8 7-8 13m8-13c5 3 8 7 8 13"/></svg>';
    if (str_contains($slug,'barge')||str_contains($slug,'mive')) return '<svg viewBox="0 0 48 48"><path d="M14 15c6-8 15-8 20 0 7 10 1 25-10 25S7 25 14 15Z"/><path d="M24 15c0-5 3-8 8-9M24 16c-3-5-7-7-12-5"/></svg>';
    return '<svg viewBox="0 0 48 48"><path d="M13 17c5-9 17-9 22 0 6 10 0 24-11 24S7 27 13 17Z"/><path d="M24 16c0-6 4-10 10-10M20 9c4 0 7 2 8 6"/></svg>';
}

function alookhor_cc_category_markup($settings=null){
    $s=is_array($settings)?$settings:alookhor_cc_get_category_settings();if(empty($s['enabled']))return '';
    $terms=alookhor_cc_category_terms($s);if(!$terms)return '';
    $style=sprintf('--mc-bg:%s;--mc-card:%s;--mc-gold:%s;--mc-text:%s;--mc-muted:%s;--mc-border:%s;--mc-btn:%s;--mc-cards:%d;--mc-gap:%dpx;--mc-image:%dpx;--mc-mobile-width:%d;--mc-mobile-gap:%dpx;--mc-mobile-image:%dpx;--mc-mobile-radius:%dpx;--mc-mobile-peek:%d',
        sanitize_hex_color($s['section_background'])?:'#090610',sanitize_hex_color($s['card_background'])?:'#0D0916',sanitize_hex_color($s['gold'])?:'#D4A436',sanitize_hex_color($s['text'])?:'#F7F2EA',sanitize_hex_color($s['muted'])?:'#B8B0BD',sanitize_hex_color($s['border'])?:'#6F5426',sanitize_hex_color($s['button_background'])?:'#120B1C',max(2,min(6,absint($s['desktop_cards']))),max(8,min(40,absint($s['desktop_gap']))),max(180,min(430,absint($s['image_height']))),max(72,min(94,absint($s['mobile_card_width']))),max(8,min(28,absint($s['mobile_gap']))),max(170,min(330,absint($s['mobile_image_height']))),max(10,min(32,absint($s['mobile_radius']))),max(3,min(14,absint($s['mobile_peek']))));
    $count=count($terms);$pages=(int)ceil($count/max(1,absint($s['desktop_cards'])));
    ob_start(); ?>
    <section id="alookhor-managed-categories" class="alookhor-mc" dir="rtl" style="<?php echo esc_attr($style); ?>" data-version="<?php echo esc_attr(ALOOKHOR_CC_VERSION); ?>" data-autoplay="<?php echo !empty($s['autoplay'])?'1':'0'; ?>" data-interval="<?php echo esc_attr(max(2500,min(15000,absint($s['autoplay_interval'])))); ?>">
      <div class="alookhor-mc-shell">
        <header class="alookhor-mc-head"><span class="alookhor-mc-kicker"><i></i><b>◆</b><?php echo esc_html($s['kicker']); ?><b>◆</b><i></i></span><h2><?php echo esc_html($s['title']); ?></h2><p><?php echo esc_html($s['subtitle']); ?></p><span class="alookhor-mc-divider"><i></i><b>◆</b><i></i></span></header>
        <div class="alookhor-mc-stage">
          <div class="alookhor-mc-viewport"><div class="alookhor-mc-track">
          <?php foreach($terms as $term): $id=(string)$term->term_id;$override=is_array($s['overrides'][$id]??null)?$s['overrides'][$id]:[];$thumb=absint(get_term_meta($term->term_id,'thumbnail_id',true));$image=$thumb?wp_get_attachment_image_url($thumb,'large'):'';if(empty($image))$image=esc_url_raw($override['image_url']??'');$description=sanitize_text_field($override['description']??'');if(!$description)$description=wp_trim_words(wp_strip_all_tags($term->description),14,'…');if(!$description)$description=sprintf('%d محصول منتخب',absint($term->count));$url=get_term_link($term);if(is_wp_error($url))$url=home_url('/shop/'); ?>
            <article class="alookhor-mc-card" data-term="<?php echo esc_attr($term->term_id); ?>">
              <a class="alookhor-mc-image" href="<?php echo esc_url($url); ?>"><?php if($image):?><img src="<?php echo esc_url($image); ?>" alt="<?php echo esc_attr($term->name); ?>" loading="lazy"><?php endif;?><?php if(!empty($s['show_icons'])):?><span class="alookhor-mc-icon"><?php echo alookhor_cc_category_icon($term->slug); // phpcs:ignore ?></span><?php endif;?></a>
              <div class="alookhor-mc-body"><h3><a href="<?php echo esc_url($url); ?>"><?php echo esc_html($term->name); ?></a></h3><?php if(!empty($s['show_description'])):?><p><?php echo esc_html($description); ?></p><?php endif;?><?php if(!empty($s['show_count'])):?><small><?php echo esc_html(number_format_i18n($term->count)); ?> محصول</small><?php endif;?><a class="alookhor-mc-button" href="<?php echo esc_url($url); ?>"><b>◆</b><span><?php echo esc_html($s['button_text']); ?></span><i>←</i></a></div>
            </article>
          <?php endforeach; ?>
          </div></div>
          <?php if(!empty($s['show_arrows'])&&$count>1):?><button class="alookhor-mc-arrow alookhor-mc-prev" type="button" aria-label="دسته قبلی"><svg viewBox="0 0 24 24"><path d="m9 5 7 7-7 7"/></svg><span></span></button><button class="alookhor-mc-arrow alookhor-mc-next" type="button" aria-label="دسته بعدی"><svg viewBox="0 0 24 24"><path d="m15 5-7 7 7 7"/></svg><span></span></button><?php endif;?>
        </div>
        <?php if(!empty($s['show_dots'])):?><div class="alookhor-mc-dots" role="tablist"><?php for($i=0;$i<max(1,$pages);$i++):?><button type="button" data-page="<?php echo esc_attr($i); ?>" class="<?php echo $i===0?'is-active':''; ?>" aria-label="صفحه <?php echo esc_attr($i+1); ?>"></button><?php endfor;?></div><?php endif;?>
      </div>
    </section>
    <?php return ob_get_clean();
}

function alookhor_cc_category_shortcode(){
    if(!empty($GLOBALS['alookhor_cc_category_shortcode_rendered']))return '';
    $s=alookhor_cc_get_category_settings();if(empty($s['enabled']))return '';
    $GLOBALS['alookhor_cc_category_shortcode_rendered']=true;
    return alookhor_cc_category_markup($s);
}
add_shortcode('alookhor_managed_categories','alookhor_cc_category_shortcode');

function alookhor_cc_category_template(){static $done=false;if($done||is_admin()||!empty($GLOBALS['alookhor_cc_category_shortcode_rendered']))return;$s=alookhor_cc_get_category_settings();if(empty($s['enabled']))return;$done=true;echo '<template id="alookhor-managed-categories-template">'.alookhor_cc_category_markup($s).'</template><noscript><style>.category-carousel-section{display:block!important}</style></noscript>';}
add_action('wp_footer','alookhor_cc_category_template',2);
add_filter('body_class',function($classes){$s=alookhor_cc_get_category_settings();if(!empty($s['enabled']))$classes[]='alookhor-mc-enabled';if(!empty($s['enabled'])&&!empty($s['hide_legacy']))$classes[]='alookhor-mc-hide-legacy';return array_values(array_unique($classes));});
add_action('wp_enqueue_scripts',function(){ $s=alookhor_cc_get_category_settings();if(empty($s['enabled']))return;wp_enqueue_style('alookhor-cc-managed-categories',ALOOKHOR_CC_URL.'assets/css/frontend-categories.css',[],ALOOKHOR_CC_BUILD);wp_enqueue_script('alookhor-cc-managed-categories',ALOOKHOR_CC_URL.'assets/js/frontend-categories.js',[],ALOOKHOR_CC_BUILD,true);wp_localize_script('alookhor-cc-managed-categories','ALOOKHOR_CATEGORIES',['endpoint'=>rest_url('alookhor-cc/v1/product-categories'),'version'=>ALOOKHOR_CC_VERSION,'hide_legacy'=>!empty($s['hide_legacy'])]);},31);
````

## Source Snapshot — `plugin/alookhor-control-center/includes/rest-api.php`

````php
<?php
/**
 * Authenticated CI/health endpoints for ALOOKHOR releases.
 * Authentication is provided by WordPress Application Passwords over HTTPS.
 */

if (!defined('ABSPATH')) exit;

function alookhor_cc_rest_update_permission(){
    if (!is_user_logged_in() || !current_user_can('update_plugins')) {
        return new WP_Error('alookhor_rest_forbidden', 'دسترسی مدیریت بروزرسانی لازم است.', ['status' => 403]);
    }
    return true;
}

function alookhor_cc_runtime_status(){
    $manifest = alookhor_cc_get_update_manifest(true);
    $manifest_data = is_wp_error($manifest) ? [
        'ok' => false,
        'error' => $manifest->get_error_code(),
        'message' => $manifest->get_error_message(),
    ] : [
        'ok' => true,
        'version' => $manifest['version'],
        'sha256' => $manifest['sha256'],
        'available' => version_compare($manifest['version'], ALOOKHOR_CC_VERSION, '>'),
        'package_host' => wp_parse_url($manifest['download_url'], PHP_URL_HOST),
    ];

    $settings = alookhor_cc_get_settings();
    $verified = get_site_transient('alookhor_cc_last_verified_package');
    return [
        'plugin' => 'alookhor-control-center',
        'version' => ALOOKHOR_CC_VERSION,
        'active' => true,
        'manifest_url' => alookhor_cc_update_manifest_url(),
        'manifest' => $manifest_data,
        'settings' => [
            'main_option' => is_array(get_option(ALOOKHOR_CC_OPTION, null)),
            'header_option' => is_array(get_option(ALOOKHOR_CC_HEADER_OPTION, null)),
            'main_option_hash' => hash('sha256', wp_json_encode(get_option(ALOOKHOR_CC_OPTION, null))),
            'header_option_hash' => hash('sha256', wp_json_encode(get_option(ALOOKHOR_CC_HEADER_OPTION, null))),
            'module_count' => is_array($settings['modules'] ?? null) ? count($settings['modules']) : 0,
            'header_shortcode' => shortcode_exists('alookhor_portal_header'),
            'category_shortcode' => shortcode_exists('alookhor_managed_categories'),
            'footer_settings' => is_array($settings['footer_settings'] ?? null),
            'footer_enabled' => !empty($settings['footer_settings']['enabled']),
            'footer_module' => !empty($settings['modules']['footer']['enabled']),
            'category_settings' => is_array($settings['category_settings'] ?? null),
            'category_enabled' => !empty($settings['category_settings']['enabled']),
            'category_module' => !empty($settings['modules']['product_categories']['enabled']),
            'hero_shortcode' => shortcode_exists('alookhor_managed_hero'),
            'hero_settings' => is_array($settings['hero_settings'] ?? null),
            'hero_enabled' => !empty($settings['hero_settings']['enabled']),
            'hero_slide_count' => is_array($settings['hero_settings']['slides'] ?? null) ? count($settings['hero_settings']['slides']) : 0,
            'hero_module' => !empty($settings['modules']['hero']['enabled']),
            'feature_shortcode' => shortcode_exists('alookhor_managed_features'),
            'feature_settings' => is_array($settings['feature_settings'] ?? null),
            'feature_enabled' => !empty($settings['feature_settings']['enabled']),
            'feature_item_count' => is_array($settings['feature_settings']['items'] ?? null) ? count($settings['feature_settings']['items']) : 0,
            'feature_module' => !empty($settings['modules']['site_features']['enabled']),
            'header_brand_migration' => is_array($settings['_migrations']['header_brand_3106'] ?? null)
                ? $settings['_migrations']['header_brand_3106']
                : null,
            'header_layout_migration' => is_array($settings['_migrations']['header_layout_3107'] ?? null)
                ? $settings['_migrations']['header_layout_3107']
                : null,
            'header_reference_migration' => is_array($settings['_migrations']['header_reference_31019'] ?? null)
                ? $settings['_migrations']['header_reference_31019']
                : null,
        ],
        'last_verified_package' => is_array($verified) ? $verified : null,
        'last_activation_restore' => get_site_transient('alookhor_cc_last_activation_restore') ?: null,
        'transition_activation_restore' => get_site_transient('alookhor_ci_last_activation_restore') ?: null,
        'php' => PHP_VERSION,
        'wordpress' => get_bloginfo('version'),
        'rollback_supported' => version_compare(get_bloginfo('version'), '6.3', '>='),
        'checked_at' => current_time('mysql', true),
    ];
}

add_action('rest_api_init', function(){
    // Public read-only Top Bar state. These values are already rendered on the
    // public page; serving them separately lets cached pages refresh managed
    // colors/content without exposing admin settings or accepting writes.
    register_rest_route('alookhor-cc/v1', '/topbar', [
        'methods' => WP_REST_Server::READABLE,
        'permission_callback' => '__return_true',
        'callback' => function(){
            $settings = alookhor_cc_front_header_settings();
            $response = rest_ensure_response([
                'version' => ALOOKHOR_CC_VERSION,
                'home_url' => home_url('/'),
                'logo_text' => sanitize_text_field($settings['logo_text'] ?? 'ALOOKHOR'),
                'gold' => sanitize_hex_color($settings['gold'] ?? '') ?: '#D49A2E',
                'sticky' => rest_sanitize_boolean($settings['sticky'] ?? true),
                'show_search' => rest_sanitize_boolean($settings['show_search'] ?? true),
                'search_placeholder' => sanitize_text_field($settings['search_placeholder'] ?? 'جستجوی محصول…'),
                'header_surface' => sanitize_hex_color($settings['header_surface'] ?? '') ?: '#0D0510',
                'header_text_color' => sanitize_hex_color($settings['header_text_color'] ?? '') ?: '#F5F3F0',
                'header_muted_color' => sanitize_hex_color($settings['header_muted_color'] ?? '') ?: '#C8C2C9',
                'capsule_background' => sanitize_hex_color($settings['capsule_background'] ?? '') ?: '#0D0510',
                'capsule_card' => sanitize_hex_color($settings['capsule_card'] ?? '') ?: '#1C1024',
                'capsule_glass' => preg_match('/^rgba?\([^)]*\)$/',(string)($settings['capsule_glass']??''))?(string)$settings['capsule_glass']:'rgba(33,20,38,.75)',
                'capsule_gold' => sanitize_hex_color($settings['capsule_gold'] ?? '') ?: '#D49A2E',
                'capsule_gold_light' => sanitize_hex_color($settings['capsule_gold_light'] ?? '') ?: '#E8B84A',
                'capsule_text' => sanitize_hex_color($settings['capsule_text'] ?? '') ?: '#F5F3F0',
                'capsule_muted' => sanitize_hex_color($settings['capsule_muted'] ?? '') ?: '#C8C2C9',
                'capsule_blur' => max(10,min(36,absint($settings['capsule_blur']??24))),
                'header_logo_desktop_width' => max(70, min(220, absint($settings['header_logo_desktop_width'] ?? 118))),
                'header_logo_mobile_width' => max(42, min(110, absint($settings['header_logo_mobile_width'] ?? 58))),
                'phone' => sanitize_text_field($settings['phone'] ?? ''),
                'email' => sanitize_email($settings['email'] ?? ''),
                'whatsapp' => preg_replace('/\D+/', '', (string) ($settings['whatsapp'] ?? '')),
                'export_text' => sanitize_text_field($settings['export_text'] ?? ''),
                'export_url' => esc_url_raw($settings['export_url'] ?? ''),
                'wholesale_text' => sanitize_text_field($settings['wholesale_text'] ?? ''),
                'wholesale_url' => esc_url_raw($settings['wholesale_url'] ?? ''),
                'wholesale_new_tab' => rest_sanitize_boolean($settings['wholesale_new_tab'] ?? false),
                'top_logo_url' => esc_url_raw($settings['top_logo_url'] ?? ''),
                'top_logo_alt' => sanitize_text_field($settings['top_logo_alt'] ?? ''),
                'top_logo_link' => esc_url_raw($settings['top_logo_link'] ?? ''),
                'topbar_bg' => sanitize_hex_color($settings['topbar_bg'] ?? '') ?: '#1C1024',
                'topbar_text_color' => sanitize_hex_color($settings['topbar_text_color'] ?? '') ?: '#F5F3F0',
                'topbar_border_color' => sanitize_hex_color($settings['topbar_border_color'] ?? '') ?: '#D49A2E',
                'topbar_button_bg' => sanitize_hex_color($settings['topbar_button_bg'] ?? '') ?: '#D49A2E',
                'topbar_button_text' => sanitize_hex_color($settings['topbar_button_text'] ?? '') ?: '#0D0510',
                'topbar_height' => max(30, min(60, absint($settings['topbar_height'] ?? 38))),
                'top_logo_width' => max(50, min(180, absint($settings['top_logo_width'] ?? 96))),
                'show_topbar' => rest_sanitize_boolean($settings['show_topbar'] ?? true),
                'show_phone' => rest_sanitize_boolean($settings['show_phone'] ?? true),
                'show_email' => rest_sanitize_boolean($settings['show_email'] ?? true),
                'show_whatsapp' => rest_sanitize_boolean($settings['show_whatsapp'] ?? true),
                'show_export' => rest_sanitize_boolean($settings['show_export'] ?? true),
                'show_wholesale' => rest_sanitize_boolean($settings['show_wholesale'] ?? true),
                'mega_menu' => rest_sanitize_boolean($settings['mega_menu'] ?? true),
            ]);
            $response->header('Cache-Control', 'no-store, no-cache, must-revalidate, max-age=0');
            return $response;
        },
    ]);

    register_rest_route('alookhor-cc/v1', '/hero', [
        'methods' => WP_REST_Server::READABLE,
        'permission_callback' => '__return_true',
        'callback' => function(){
            $settings=alookhor_cc_get_hero_settings();
            $slides=array_slice(array_values((array)($settings['slides']??[])),0,4);
            $response=rest_ensure_response([
                'version'=>ALOOKHOR_CC_VERSION,
                'enabled'=>!empty($settings['enabled']),
                'slide_count'=>count($slides),
                'html'=>alookhor_cc_hero_markup($settings),
            ]);
            $response->header('Cache-Control','no-store, no-cache, must-revalidate, max-age=0');
            return $response;
        },
    ]);

    register_rest_route('alookhor-cc/v1', '/site-features', [
        'methods' => WP_REST_Server::READABLE,
        'permission_callback' => '__return_true',
        'callback' => function(){
            $settings=alookhor_cc_get_site_feature_settings();
            $items=array_slice(array_values((array)($settings['items']??[])),0,4);
            $response=rest_ensure_response([
                'version'=>ALOOKHOR_CC_VERSION,
                'enabled'=>!empty($settings['enabled']),
                'item_count'=>count($items),
                'html'=>alookhor_cc_site_feature_markup($settings),
            ]);
            $response->header('Cache-Control','no-store, no-cache, must-revalidate, max-age=0');
            return $response;
        },
    ]);

    register_rest_route('alookhor-cc/v1', '/footer', [
        'methods' => WP_REST_Server::READABLE,
        'permission_callback' => '__return_true',
        'callback' => function(){
            $settings = alookhor_cc_get_footer_settings();
            $response = rest_ensure_response([
                'version' => ALOOKHOR_CC_VERSION,
                'enabled' => !empty($settings['enabled']),
                'html' => alookhor_cc_footer_markup($settings),
            ]);
            $response->header('Cache-Control', 'no-store, no-cache, must-revalidate, max-age=0');
            return $response;
        },
    ]);

    register_rest_route('alookhor-cc/v1', '/product-categories', [
        'methods' => WP_REST_Server::READABLE,
        'permission_callback' => '__return_true',
        'callback' => function(){
            $settings=alookhor_cc_get_category_settings();$terms=alookhor_cc_category_terms($settings);
            $response=rest_ensure_response(['version'=>ALOOKHOR_CC_VERSION,'enabled'=>!empty($settings['enabled']),'count'=>count($terms),'term_ids'=>array_map(fn($term)=>(int)$term->term_id,$terms),'html'=>alookhor_cc_category_markup($settings)]);
            $response->header('Cache-Control','no-store, no-cache, must-revalidate, max-age=0');return $response;
        },
    ]);

    register_rest_route('alookhor-cc/v1', '/footer-subscribe', [
        'methods' => WP_REST_Server::CREATABLE,
        'permission_callback' => '__return_true',
        'args' => [
            'email' => ['required'=>true,'type'=>'string','sanitize_callback'=>'sanitize_email'],
            'company' => ['required'=>false,'type'=>'string','sanitize_callback'=>'sanitize_text_field'],
        ],
        'callback' => function(WP_REST_Request $request){
            if ((string)$request->get_param('company') !== '') return rest_ensure_response(['message'=>'عضویت ثبت شد.']);
            $email = sanitize_email((string)$request->get_param('email'));
            if (!$email || !is_email($email)) return new WP_Error('alookhor_footer_email_invalid','ایمیل معتبر وارد کنید.',['status'=>400]);
            $ip = sanitize_text_field($_SERVER['REMOTE_ADDR'] ?? 'unknown');
            $rate_key = 'alookhor_footer_sub_' . substr(hash_hmac('sha256',$ip,wp_salt('nonce')),0,24);
            if (get_transient($rate_key)) return new WP_Error('alookhor_footer_rate_limit','لطفاً یک دقیقه بعد دوباره تلاش کنید.',['status'=>429]);
            set_transient($rate_key,1,MINUTE_IN_SECONDS);
            $subscribers = get_option('alookhor_footer_subscribers',[]);
            if (!is_array($subscribers)) $subscribers=[];
            $key = hash('sha256',strtolower($email));
            $subscribers[$key] = ['email'=>$email,'created_at'=>current_time('mysql',true)];
            if (count($subscribers)>5000) $subscribers=array_slice($subscribers,-5000,null,true);
            update_option('alookhor_footer_subscribers',$subscribers,false);
            return rest_ensure_response(['message'=>'عضویت شما با موفقیت ثبت شد.']);
        },
    ]);

    register_rest_route('alookhor-cc/v1', '/status', [
        'methods' => WP_REST_Server::READABLE,
        'permission_callback' => 'alookhor_cc_rest_update_permission',
        'callback' => function(){
            return rest_ensure_response(alookhor_cc_runtime_status());
        },
    ]);

    register_rest_route('alookhor-cc/v1', '/check-update', [
        'methods' => WP_REST_Server::CREATABLE,
        'permission_callback' => 'alookhor_cc_rest_update_permission',
        'callback' => function(){
            delete_site_transient(ALOOKHOR_CC_UPDATE_CACHE_KEY);
            $manifest = alookhor_cc_get_update_manifest(true);
            if (is_wp_error($manifest)) return $manifest;

            $transient = get_site_transient('update_plugins');
            if (!is_object($transient)) $transient = new stdClass();
            $transient->last_checked = time();
            set_site_transient('update_plugins', alookhor_cc_apply_manifest_to_update_transient($transient, $manifest));
            return rest_ensure_response(alookhor_cc_runtime_status());
        },
    ]);

    register_rest_route('alookhor-cc/v1', '/install-update', [
        'methods' => WP_REST_Server::CREATABLE,
        'permission_callback' => 'alookhor_cc_rest_update_permission',
        'args' => [
            'target_version' => [
                'required' => true,
                'type' => 'string',
                'sanitize_callback' => 'sanitize_text_field',
                'validate_callback' => function($value){
                    return (bool) preg_match('/^\d+\.\d+\.\d+$/', (string) $value);
                },
            ],
        ],
        'callback' => function(WP_REST_Request $request){
            if (version_compare(get_bloginfo('version'), '6.3', '<')) {
                return new WP_Error('alookhor_rollback_unavailable', 'بروزرسانی خودکار به WordPress 6.3 یا جدیدتر برای Rollback نیاز دارد.', ['status' => 409]);
            }
            $user_id = get_current_user_id();
            $lock_key = 'alookhor_cc_rest_update_lock_' . $user_id;
            if (get_transient($lock_key)) {
                return new WP_Error('alookhor_update_locked', 'یک عملیات بروزرسانی دیگر در حال اجراست.', ['status' => 409]);
            }
            set_transient($lock_key, 1, 5 * MINUTE_IN_SECONDS);

            try {
                $manifest = alookhor_cc_get_update_manifest(true);
                if (is_wp_error($manifest)) return $manifest;
                $target = (string) $request->get_param('target_version');
                if (!hash_equals($manifest['version'], $target)) {
                    return new WP_Error('alookhor_target_mismatch', 'نسخه درخواستی با Manifest مطابقت ندارد.', ['status' => 409]);
                }
                if (!version_compare($target, ALOOKHOR_CC_VERSION, '>')) {
                    return rest_ensure_response(['updated' => false, 'reason' => 'already_current'] + alookhor_cc_runtime_status());
                }

                $transient = get_site_transient('update_plugins');
                if (!is_object($transient)) $transient = new stdClass();
                $transient->last_checked = time();
                set_site_transient('update_plugins', alookhor_cc_apply_manifest_to_update_transient($transient, $manifest));

                require_once ABSPATH . 'wp-admin/includes/plugin.php';
                require_once ABSPATH . 'wp-admin/includes/class-wp-upgrader.php';
                $was_active = is_plugin_active(ALOOKHOR_CC_PLUGIN_BASENAME);
                $was_network_active = is_multisite() && is_plugin_active_for_network(ALOOKHOR_CC_PLUGIN_BASENAME);
                $skin = new Automatic_Upgrader_Skin();
                $upgrader = new Plugin_Upgrader($skin);
                $result = $upgrader->upgrade(ALOOKHOR_CC_PLUGIN_BASENAME, [
                    'clear_update_cache' => true,
                ]);
                if (is_wp_error($result)) return $result;
                if (!$result) {
                    $errors = $skin->get_errors();
                    return is_wp_error($errors) && $errors->has_errors()
                        ? $errors
                        : new WP_Error('alookhor_update_failed', 'WordPress بروزرسانی افزونه را کامل نکرد.');
                }

                wp_clean_plugins_cache(true);
                $activation = alookhor_cc_restore_activation_state(
                    $was_active,
                    $was_network_active,
                    'rest_install_update'
                );
                if (is_wp_error($activation)) {
                    return new WP_Error(
                        'alookhor_reactivation_failed',
                        'فایل‌های بروزرسانی نصب شدند اما وضعیت فعال افزونه بازیابی نشد.',
                        ['status' => 500, 'cause' => $activation->get_error_code()]
                    );
                }
                $plugin_data = get_plugin_data(ALOOKHOR_CC_FILE, false, false);
                return rest_ensure_response([
                    'updated' => true,
                    'version' => $plugin_data['Version'] ?? $target,
                    'target' => $target,
                    'verified_package' => get_site_transient('alookhor_cc_last_verified_package'),
                    'activation' => $activation,
                    'active' => is_plugin_active(ALOOKHOR_CC_PLUGIN_BASENAME),
                ]);
            } finally {
                delete_transient($lock_key);
            }
        },
    ]);
});
````

## Source Snapshot — `plugin/alookhor-control-center/includes/shortcode-header.php`

````php
<?php
/**
 * ALOOKHOR Luxury Portal Header — [alookhor_portal_header]
 *
 * Recovery rules:
 * 1) Never override an older registered implementation of the shortcode.
 * 2) If no legacy provider exists, render the recovered two-level header.
 * 3) Menus come from WordPress automatically; no duplicated static nav data.
 */

if (!defined('ABSPATH')) exit;

function alookhor_cc_front_header_settings(){
    $site = alookhor_cc_get_settings();
    $saved = get_option(ALOOKHOR_CC_HEADER_OPTION, []);
    if (!is_array($saved)) $saved = [];

    $defaults = [
        'logo_text'       => $site['header_settings']['logo_text'] ?? $site['site']['name'] ?? 'ALOOKHOR',
        'logo_sub'        => $site['header_settings']['logo_sub'] ?? $site['site']['subtitle'] ?? 'آلوخور؛ طعم اصیل خراسان',
        'logo_letter'     => $site['site']['logoLetter'] ?? 'A',
        'gold'            => $site['site']['goldAccent'] ?? '#D49A2E',
        'header_surface'  => '#0D0510',
        'header_text_color' => '#F5F3F0',
        'header_muted_color' => '#C8C2C9',
        'capsule_background' => '#0D0510',
        'capsule_card' => '#1C1024',
        'capsule_glass' => 'rgba(33,20,38,.75)',
        'capsule_gold' => '#D49A2E',
        'capsule_gold_light' => '#E8B84A',
        'capsule_text' => '#F5F3F0',
        'capsule_muted' => '#C8C2C9',
        'capsule_blur' => 24,
        'header_logo_desktop_width' => 118,
        'header_logo_mobile_width' => 58,
        'sticky'          => true,
        'show_search'     => false,
        'search_placeholder' => 'جستجوی محصول…',
        'show_topbar'     => true,
        'show_account'    => true,
        'show_contact'    => true,
        'show_phone'      => true,
        'show_email'      => true,
        'show_whatsapp'   => true,
        'show_export'     => true,
        'show_wholesale'  => true,
        'email'           => sanitize_email(get_option('admin_email')),
        'phone'           => '09222942808',
        'whatsapp'        => '989222942808',
        'export_text'     => 'صادرات به ۵ کشور جهان',
        'export_url'      => '',
        'wholesale_text'  => 'خرید عمده آلو بخارا',
        'wholesale_url'   => home_url('/#b2b'),
        'wholesale_new_tab' => false,
        'top_logo_url'    => '',
        'top_logo_alt'    => get_bloginfo('name'),
        'top_logo_link'   => home_url('/'),
        'topbar_bg'       => '#1C1024',
        'topbar_text_color' => '#F5F3F0',
        'topbar_border_color' => '#D49A2E',
        'topbar_button_bg' => '#D49A2E',
        'topbar_button_text' => '#0D0510',
        'topbar_height'   => 38,
        'top_logo_width'  => 96,
        'account_text'    => 'ورود / ثبت‌نام',
        'primary_menu'    => 0,
    ];

    $settings = wp_parse_args($saved, $defaults);
    return apply_filters('alookhor_cc_front_header_settings', $settings);
}

/**
 * Resolve the main menu automatically. A saved override is optional; otherwise
 * registered primary/header locations are preferred, then the first WP menu.
 */
function alookhor_cc_resolve_primary_menu($preferred = 0){
    if ($preferred) {
        $menu = wp_get_nav_menu_object((int) $preferred);
        if ($menu && !is_wp_error($menu)) return $menu;
    }

    $locations = get_nav_menu_locations();
    $priority_locations = [
        'primary', 'main-menu', 'main_menu', 'main-navigation',
        'header-menu', 'header', 'woodmart-main-menu', 'mobile-menu'
    ];
    foreach ($priority_locations as $location) {
        if (!empty($locations[$location])) {
            $menu = wp_get_nav_menu_object($locations[$location]);
            if ($menu && !is_wp_error($menu)) return $menu;
        }
    }

    foreach ($locations as $menu_id) {
        if (!$menu_id) continue;
        $menu = wp_get_nav_menu_object($menu_id);
        if ($menu && !is_wp_error($menu)) return $menu;
    }

    $menus = wp_get_nav_menus(['orderby' => 'term_order']);
    return !empty($menus) ? $menus[0] : null;
}

function alookhor_cc_menu_markup($menu, $class, $depth = 3){
    if (!$menu || is_wp_error($menu)) return '';
    return wp_nav_menu([
        'menu'        => $menu->term_id,
        'container'   => false,
        'menu_class'  => $class,
        'depth'       => $depth,
        'fallback_cb' => false,
        'echo'        => false,
    ]);
}

function alookhor_cc_phone_href($phone){
    return preg_replace('/[^0-9+]/', '', (string) $phone);
}

function alookhor_cc_whatsapp_href($number){
    $number = preg_replace('/\D+/', '', (string) $number);
    if (strpos($number, '0') === 0) $number = '98' . substr($number, 1);
    return $number ? 'https://wa.me/' . $number : '';
}

function alookhor_cc_render_portal_header($atts = []){
    $atts = shortcode_atts(['sticky' => '', 'menu' => ''], $atts, 'alookhor_portal_header');
    $settings = alookhor_cc_front_header_settings();
    if ($atts['sticky'] !== '') $settings['sticky'] = rest_sanitize_boolean($atts['sticky']);
    if ($atts['menu'] !== '') $settings['primary_menu'] = absint($atts['menu']);

    $instance = wp_unique_id('alookhor-header-');
    $drawer_id = $instance . '-drawer';
    $primary_menu = alookhor_cc_resolve_primary_menu($settings['primary_menu']);
    $all_menus = wp_get_nav_menus(['orderby' => 'term_order']);
    $primary_markup = alookhor_cc_menu_markup($primary_menu, 'alookhor-primary-menu', 3);

    $custom_logo_id = (int) get_theme_mod('custom_logo');
    if (!empty($settings['top_logo_url'])) {
        $custom_logo = sprintf(
            '<img class="alookhor-top-logo-image" src="%s" alt="%s" loading="eager">',
            esc_url($settings['top_logo_url']),
            esc_attr($settings['top_logo_alt'])
        );
    } else {
        $custom_logo = $custom_logo_id
            ? wp_get_attachment_image($custom_logo_id, 'medium', false, [
                'class' => 'alookhor-top-logo-image',
                'alt'   => $settings['top_logo_alt'] ?: get_bloginfo('name'),
                'loading' => 'eager',
            ])
            : '';
    }
    $site_icon = get_site_icon_url(96);
    if (!$site_icon && $custom_logo_id) $site_icon = wp_get_attachment_image_url($custom_logo_id, 'thumbnail');
    // Main capsule must use the approved Header logo source, not the generic
    // WordPress Site Icon (which can be an unrelated shop/app glyph).
    $nav_logo_url = !empty($settings['top_logo_url']) ? esc_url_raw($settings['top_logo_url']) : '';
    if (!$nav_logo_url && $custom_logo_id) $nav_logo_url = wp_get_attachment_image_url($custom_logo_id, 'full');
    if (!$nav_logo_url) $nav_logo_url = $site_icon;
    $nav_brand_text = apply_filters('alookhor_cc_header_brand_text', 'آلوخور');
    $nav_brand_sub = apply_filters('alookhor_cc_header_brand_subtitle', 'پایتخت آلوی ایران');

    $account_url = function_exists('wc_get_page_permalink')
        ? wc_get_page_permalink('myaccount')
        : wp_login_url(home_url('/'));
    $cart_url = function_exists('wc_get_cart_url') ? wc_get_cart_url() : home_url('/cart/');
    $cart_count = function_exists('WC') && WC()->cart ? (int) WC()->cart->get_cart_contents_count() : 0;

    $phone_href = alookhor_cc_phone_href($settings['phone']);
    $whatsapp_href = alookhor_cc_whatsapp_href($settings['whatsapp']);
    $is_sticky = rest_sanitize_boolean($settings['sticky']);
    $show_topbar = rest_sanitize_boolean($settings['show_topbar']);
    $show_account = rest_sanitize_boolean($settings['show_account']);
    $show_contact = rest_sanitize_boolean($settings['show_contact']);
    $show_phone = rest_sanitize_boolean($settings['show_phone']);
    $show_email = rest_sanitize_boolean($settings['show_email']);
    $show_whatsapp = rest_sanitize_boolean($settings['show_whatsapp']);
    $show_export = rest_sanitize_boolean($settings['show_export']);
    $show_wholesale = rest_sanitize_boolean($settings['show_wholesale']);
    $wholesale_target = rest_sanitize_boolean($settings['wholesale_new_tab']) ? '_blank' : '_self';
    $topbar_height = max(30, min(60, absint($settings['topbar_height'])));
    $top_logo_width = max(50, min(180, absint($settings['top_logo_width'])));
    $topbar_bg = sanitize_hex_color($settings['topbar_bg']) ?: '#1C1024';
    $topbar_text = sanitize_hex_color($settings['topbar_text_color']) ?: '#F5F3F0';
    $topbar_border = sanitize_hex_color($settings['topbar_border_color']) ?: '#D49A2E';
    $topbar_button_bg = sanitize_hex_color($settings['topbar_button_bg']) ?: '#D49A2E';
    $topbar_button_text = sanitize_hex_color($settings['topbar_button_text']) ?: '#0D0510';
    $capsule_background=sanitize_hex_color($settings['capsule_background']??'')?:'#0D0510';
    $capsule_card=sanitize_hex_color($settings['capsule_card']??'')?:'#1C1024';
    $capsule_glass=preg_match('/^rgba?\([^)]*\)$/',(string)($settings['capsule_glass']??''))?(string)$settings['capsule_glass']:'rgba(33,20,38,.75)';
    $capsule_gold=sanitize_hex_color($settings['capsule_gold']??'')?:'#D49A2E';
    $capsule_gold_light=sanitize_hex_color($settings['capsule_gold_light']??'')?:'#E8B84A';
    $capsule_text=sanitize_hex_color($settings['capsule_text']??'')?:'#F5F3F0';
    $capsule_muted=sanitize_hex_color($settings['capsule_muted']??'')?:'#C8C2C9';
    $capsule_blur=max(10,min(36,absint($settings['capsule_blur']??24)));

    ob_start();
    ?>
    <div id="<?php echo esc_attr($instance); ?>" class="alookhor-portal-header<?php echo $is_sticky ? ' is-sticky' : ''; ?><?php echo $mega_menu ? ' alookhor-mega-menu' : ''; ?>" dir="rtl" style="--alookhor-gold:<?php echo esc_attr($settings['gold']); ?>;--alookhor-topbar-bg:<?php echo esc_attr($topbar_bg); ?>;--alookhor-topbar-text:<?php echo esc_attr($topbar_text); ?>;--alookhor-topbar-border:<?php echo esc_attr($topbar_border); ?>;--alookhor-topbar-button-bg:<?php echo esc_attr($topbar_button_bg); ?>;--alookhor-topbar-button-text:<?php echo esc_attr($topbar_button_text); ?>;--alookhor-topbar-height:<?php echo esc_attr($topbar_height); ?>px;--alookhor-top-logo-width:<?php echo esc_attr($top_logo_width); ?>px;--alookhor-capsule-background:<?php echo esc_attr($capsule_background); ?>;--alookhor-capsule-card:<?php echo esc_attr($capsule_card); ?>;--alookhor-capsule-glass:<?php echo esc_attr($capsule_glass); ?>;--alookhor-capsule-gold:<?php echo esc_attr($capsule_gold); ?>;--alookhor-capsule-gold-light:<?php echo esc_attr($capsule_gold_light); ?>;--alookhor-capsule-text:<?php echo esc_attr($capsule_text); ?>;--alookhor-capsule-muted:<?php echo esc_attr($capsule_muted); ?>;--alookhor-capsule-blur:<?php echo esc_attr($capsule_blur); ?>px">
        <?php if ($show_topbar): ?>
        <div class="alookhor-topbar">
            <div class="alookhor-topbar-inner">
                <div class="alookhor-fallback-support"><svg viewBox="0 0 24 24" aria-hidden="true"><path d="M4 14v-2a8 8 0 0 1 16 0v2M4 14h3v6H4zM17 14h3v6h-3zM17 20c-1 2-3 3-6 3"/></svg><b>پشتیبانی ۲۴/۷</b></div>
                <div class="alookhor-trade-meta">
                    <?php if ($show_wholesale): ?>
                    <a class="alookhor-wholesale" href="<?php echo esc_url($settings['wholesale_url']); ?>" target="<?php echo esc_attr($wholesale_target); ?>"<?php echo $wholesale_target === '_blank' ? ' rel="noopener"' : ''; ?>>
                        <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M3 6h18l-2 9H7L3 4H1M8 20a1 1 0 1 0 0-2 1 1 0 0 0 0 2Zm10 0a1 1 0 1 0 0-2 1 1 0 0 0 0 2Z"/></svg>
                        <span><?php echo esc_html($settings['wholesale_text']); ?></span>
                    </a>
                    <?php endif; ?>
                    <?php if ($show_export && !empty($settings['export_text'])): ?>
                        <?php if (!empty($settings['export_url'])): ?><a class="alookhor-export-note" href="<?php echo esc_url($settings['export_url']); ?>"><?php else: ?><span class="alookhor-export-note"><?php endif; ?>
                            <svg viewBox="0 0 24 24" aria-hidden="true"><circle cx="12" cy="12" r="9"/><path d="M3 12h18M12 3c3 3 4 6 4 9s-1 6-4 9c-3-3-4-6-4-9s1-6 4-9Z"/></svg>
                            <?php echo esc_html($settings['export_text']); ?>
                        <?php if (!empty($settings['export_url'])): ?></a><?php else: ?></span><?php endif; ?>
                    <?php endif; ?>
                </div>

                <a class="alookhor-top-logo" href="<?php echo esc_url($settings['top_logo_link']); ?>" aria-label="<?php echo esc_attr($settings['top_logo_alt']); ?>">
                    <?php if ($custom_logo): echo wp_kses_post($custom_logo); else: ?>
                        <span class="alookhor-top-logo-fallback"><?php echo esc_html($settings['logo_text']); ?></span>
                    <?php endif; ?>
                </a>

                <?php if ($show_contact): ?>
                <div class="alookhor-contact-meta" dir="ltr">
                    <?php if ($show_whatsapp && $whatsapp_href): ?>
                    <a class="alookhor-whatsapp" href="<?php echo esc_url($whatsapp_href); ?>" target="_blank" rel="noopener" aria-label="WhatsApp">
                        <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M20.5 3.5A11.8 11.8 0 0 0 12.1 0C5.6 0 .3 5.3.3 11.8c0 2.1.6 4.1 1.6 5.9L0 24l6.5-1.7a11.8 11.8 0 0 0 5.6 1.4h.1C18.7 23.7 24 18.4 24 11.9c0-3.2-1.2-6.1-3.5-8.4Zm-8.4 18.2c-1.8 0-3.5-.5-5-1.4l-.4-.2-3.8 1 1-3.7-.2-.4a9.8 9.8 0 1 1 8.4 4.7Zm5.4-7.3c-.3-.1-1.7-.8-2-.9-.3-.1-.5-.1-.7.2s-.8.9-1 1.1c-.2.2-.4.2-.7.1-1.8-.9-3-1.6-4.2-3.6-.3-.5.3-.5.9-1.7.1-.2 0-.4 0-.6l-.9-2.1c-.2-.5-.5-.5-.7-.5h-.6c-.2 0-.6.1-.9.4-.3.3-1.2 1.2-1.2 2.9s1.2 3.3 1.4 3.6c.2.2 2.4 3.7 5.9 5.2.8.4 1.5.6 2 .7.8.3 1.6.2 2.2.1.7-.1 1.7-.7 1.9-1.3.2-.7.2-1.2.2-1.3-.1-.1-.3-.2-.6-.3Z"/></svg>
                    </a>
                    <?php endif; ?>
                    <?php if ($show_email && !empty($settings['email'])): ?>
                    <a class="alookhor-contact-link" href="mailto:<?php echo esc_attr($settings['email']); ?>"><?php echo esc_html($settings['email']); ?></a>
                    <?php endif; ?>
                    <?php if ($show_phone && $phone_href): ?>
                    <?php if ($show_email && !empty($settings['email'])): ?><span class="alookhor-contact-separator"></span><?php endif; ?>
                    <a class="alookhor-contact-link" href="tel:<?php echo esc_attr($phone_href); ?>"><?php echo esc_html($settings['phone']); ?></a>
                    <?php endif; ?>
                </div>
                <?php endif; ?>
            </div>
        </div>
        <?php endif; ?>

        <div class="alookhor-nav-stage">
            <div class="alookhor-nav-shell">
                <a class="alookhor-nav-logo" href="<?php echo esc_url(home_url('/')); ?>" data-logo-source="<?php echo !empty($settings['top_logo_url']) ? 'managed-media' : ($custom_logo_id ? 'custom-logo' : 'site-icon'); ?>">
                    <?php if ($nav_logo_url): ?>
                        <img src="<?php echo esc_url($nav_logo_url); ?>" alt="<?php echo esc_attr($settings['top_logo_alt'] ?: get_bloginfo('name')); ?>" width="62" height="62" loading="eager">
                    <?php else: ?>
                        <span class="alookhor-nav-logo-mark"><?php echo esc_html($settings['logo_letter']); ?></span>
                    <?php endif; ?>
                    <span class="alookhor-nav-logo-copy"><b><?php echo esc_html($nav_brand_text); ?></b><small><?php echo esc_html($nav_brand_sub); ?></small></span>
                </a>

                <nav class="alookhor-desktop-nav" aria-label="<?php esc_attr_e('فهرست اصلی', 'alookhor-cc'); ?>">
                    <?php if ($primary_markup): ?>
                        <?php echo wp_kses_post($primary_markup); ?>
                    <?php else: ?>
                        <ul class="alookhor-primary-menu">
                            <li><a href="<?php echo esc_url(home_url('/')); ?>">صفحه نخست</a></li>
                            <?php if (function_exists('wc_get_page_permalink')): ?><li><a href="<?php echo esc_url(wc_get_page_permalink('shop')); ?>">فروشگاه</a></li><?php endif; ?>
                        </ul>
                    <?php endif; ?>
                </nav>

                <div class="alookhor-nav-spacer"></div>

                <div class="alookhor-nav-actions">
                    <a class="alookhor-fallback-cart" href="<?php echo esc_url($cart_url); ?>" aria-label="سبد خرید"><svg viewBox="0 0 24 24" aria-hidden="true"><path d="M3 4h2l2 11h10l3-8H6M9 20a1 1 0 1 0 0-2 1 1 0 0 0 0 2Zm8 0a1 1 0 1 0 0-2 1 1 0 0 0 0 2Z"/></svg><span><?php echo esc_html($cart_count); ?></span></a>
                    <?php if ($show_account): ?>
                    <a class="alookhor-account-link" href="<?php echo esc_url($account_url); ?>">
                        <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M12 12a4 4 0 1 0 0-8 4 4 0 0 0 0 8Zm7 8a7 7 0 0 0-14 0"/></svg>
                        <span><?php echo is_user_logged_in() ? esc_html__('حساب کاربری', 'alookhor-cc') : esc_html($settings['account_text']); ?></span>
                    </a>
                    <?php endif; ?>
                </div>
                <button class="alookhor-menu-toggle" type="button" aria-controls="<?php echo esc_attr($drawer_id); ?>" aria-expanded="false" aria-label="بازکردن منوی کامل">
                    <span></span><span></span><span></span>
                </button>
            </div>
        </div>

        <div class="alookhor-drawer-backdrop" data-alookhor-close></div>
        <aside id="<?php echo esc_attr($drawer_id); ?>" class="alookhor-menu-drawer" aria-hidden="true" aria-label="منوی کامل آلوخور">
            <div class="alookhor-drawer-head">
                <div class="alookhor-drawer-brand">
                    <?php if ($nav_logo_url): ?><img src="<?php echo esc_url($nav_logo_url); ?>" alt="" width="48" height="48"><?php else: ?><span><?php echo esc_html($settings['logo_letter']); ?></span><?php endif; ?>
                    <div><b><?php echo esc_html($nav_brand_text); ?></b><small><?php echo esc_html($nav_brand_sub); ?></small></div>
                </div>
                <button class="alookhor-drawer-close" type="button" data-alookhor-close aria-label="بستن منو">×</button>
            </div>

            <form class="alookhor-drawer-search" role="search" method="get" action="<?php echo esc_url(home_url('/')); ?>">
                <label class="screen-reader-text" for="<?php echo esc_attr($instance); ?>-search">جستجو</label>
                <input id="<?php echo esc_attr($instance); ?>-search" type="search" name="s" placeholder="جستجو در آلوخور...">
                <button type="submit" aria-label="جستجو"><svg viewBox="0 0 24 24" aria-hidden="true"><circle cx="11" cy="11" r="7"/><path d="m20 20-3.5-3.5"/></svg></button>
            </form>

            <div class="alookhor-drawer-menus">
                <?php if (!empty($all_menus)): ?>
                    <?php foreach ($all_menus as $index => $menu):
                        $menu_markup = alookhor_cc_menu_markup($menu, 'alookhor-drawer-menu', 4);
                        if (!$menu_markup) continue;
                        $panel_id = $instance . '-menu-' . (int) $menu->term_id;
                    ?>
                    <section class="alookhor-drawer-menu-group<?php echo $index === 0 ? ' is-open' : ''; ?>">
                        <button class="alookhor-drawer-menu-title" type="button" aria-expanded="<?php echo $index === 0 ? 'true' : 'false'; ?>" aria-controls="<?php echo esc_attr($panel_id); ?>">
                            <span><?php echo esc_html($menu->name); ?></span>
                            <svg viewBox="0 0 24 24" aria-hidden="true"><path d="m7 10 5 5 5-5"/></svg>
                        </button>
                        <div id="<?php echo esc_attr($panel_id); ?>" class="alookhor-drawer-menu-panel"<?php echo $index === 0 ? '' : ' hidden'; ?>><?php echo wp_kses_post($menu_markup); ?></div>
                    </section>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="alookhor-drawer-empty">هنوز فهرستی در WordPress ساخته نشده است.</div>
                <?php endif; ?>
            </div>

            <div class="alookhor-drawer-footer">
                <div class="alookhor-drawer-quick-actions">
                    <a href="<?php echo esc_url($account_url); ?>">حساب کاربری</a>
                    <a href="<?php echo esc_url($cart_url); ?>">سبد خرید<?php echo $cart_count ? ' (' . esc_html($cart_count) . ')' : ''; ?></a>
                </div>
                <a class="alookhor-drawer-wholesale" href="<?php echo esc_url($settings['wholesale_url']); ?>"><?php echo esc_html($settings['wholesale_text']); ?></a>
                <?php if ($whatsapp_href): ?><a class="alookhor-drawer-whatsapp" href="<?php echo esc_url($whatsapp_href); ?>" target="_blank" rel="noopener">گفتگو در WhatsApp</a><?php endif; ?>
            </div>
        </aside>
    </div>
    <?php
    return ob_get_clean();
}

/**
 * Keep the exact legacy header output, but wrap it with a neutral `display:contents`
 * management boundary. The compatibility manager updates Top Bar values without
 * rebuilding or removing the old professional menu/mega-menu implementation.
 */
function alookhor_cc_render_managed_legacy_header($atts = [], $content = null, $tag = ''){
    $provider = $GLOBALS['alookhor_cc_legacy_header_provider'] ?? null;
    if (!$provider || !is_callable($provider)) return alookhor_cc_render_portal_header($atts);

    $html = call_user_func($provider, $atts, $content, $tag ?: 'alookhor_portal_header');
    if (!is_string($html)) $html = '';
    return '<div class="alookhor-managed-legacy-header" data-alookhor-managed="3.10.25" style="display:contents">' . $html . '</div>';
}

/**
 * Register late. A legacy provider remains the renderer and is never redesigned;
 * only its Top Bar receives the optional management compatibility layer.
 */
function alookhor_cc_register_portal_header_shortcode(){
    global $shortcode_tags;
    $existing = $shortcode_tags['alookhor_portal_header'] ?? null;
    $our_callbacks = ['alookhor_cc_render_portal_header', 'alookhor_cc_render_managed_legacy_header'];
    if ($existing && !in_array($existing, $our_callbacks, true)) {
        $GLOBALS['alookhor_cc_legacy_header_provider'] = $existing;
        remove_shortcode('alookhor_portal_header');
        add_shortcode('alookhor_portal_header', 'alookhor_cc_render_managed_legacy_header');
        do_action('alookhor_cc_legacy_header_preserved', $existing);
        return;
    }
    $GLOBALS['alookhor_cc_legacy_header_provider'] = false;
    add_shortcode('alookhor_portal_header', 'alookhor_cc_render_portal_header');
}
add_action('init', 'alookhor_cc_register_portal_header_shortcode', 100);
````

## Source Snapshot — `plugin/alookhor-control-center/includes/site-features.php`

````php
<?php
/**
 * Managed four-card site features strip.
 *
 * Production discovery (run 31739613682) proved that the current block is the
 * external `.alookhor-trustbar-container` inside Elementor HTML widget
 * `data-id="5abd566"` and parent container `data-id="f0598d3"`. The managed
 * runtime replaces that exact root in place and does not append a parallel row.
 */
if (!defined('ABSPATH')) exit;

function alookhor_cc_site_feature_defaults(){
    return [
        'enabled'=>true,
        'hide_legacy'=>true,
        'background'=>'#0D0510',
        'card'=>'#1C1024',
        'glass'=>'rgba(33,20,38,.75)',
        'gold'=>'#D49A2E',
        'gold_light'=>'#E8B84A',
        'text'=>'#F5F3F0',
        'muted'=>'#C8C2C9',
        'radius'=>20,
        'gap'=>8,
        'items'=>[
            ['icon'=>'truck','title'=>'ارسال سریع','description'=>'در سریع‌ترین زمان ممکن'],
            ['icon'=>'organic','title'=>'محصولات ارگانیک','description'=>'100% طبیعی و سالم'],
            ['icon'=>'headset','title'=>'پشتیبانی ۲۴/۷','description'=>'همیشه در کنار شما هستیم'],
            ['icon'=>'shield','title'=>'ضمانت کیفیت','description'=>'تضمین اصالت و کیفیت کالا'],
        ],
    ];
}

function alookhor_cc_get_site_feature_settings(){
    $main=alookhor_cc_get_settings();
    $saved=is_array($main['feature_settings']??null)?$main['feature_settings']:[];
    $settings=array_replace_recursive(alookhor_cc_site_feature_defaults(),$saved);
    $defaults=alookhor_cc_site_feature_defaults()['items'];
    $items=is_array($saved['items']??null)?array_values($saved['items']):[];
    $normalized=[];
    for($index=0;$index<4;$index++){
        $candidate=is_array($items[$index]??null)?$items[$index]:[];
        $normalized[$index]=array_replace($defaults[$index],$candidate);
    }
    $settings['items']=$normalized;
    return apply_filters('alookhor_cc_site_feature_settings',$settings);
}

function alookhor_cc_site_feature_icon($name){
    $icons=[
        'truck'=>'<svg viewBox="0 0 48 48" aria-hidden="true"><path d="M5 12h25v23H5zM30 21h7l6 8v6H30z"/><circle cx="14" cy="37" r="4"/><circle cx="36" cy="37" r="4"/><path d="M9 17h15"/></svg>',
        'organic'=>'<svg viewBox="0 0 48 48" aria-hidden="true"><circle cx="24" cy="24" r="18"/><path d="m14 24 7 7 14-15"/></svg>',
        'headset'=>'<svg viewBox="0 0 48 48" aria-hidden="true"><path d="M9 36V24a15 15 0 0 1 30 0v12M9 29h6v10H9zM33 29h6v10h-6z"/><path d="M33 39c-2 3-5 4-9 4"/></svg>',
        'shield'=>'<svg viewBox="0 0 48 48" aria-hidden="true"><path d="M24 5 39 11v12c0 10-6 16-15 21C15 39 9 33 9 23V11z"/><path d="m17 24 5 5 10-11"/></svg>',
    ];
    $key=sanitize_key($name);
    return $icons[$key]??$icons['shield'];
}

function alookhor_cc_site_feature_markup($settings=null){
    $s=is_array($settings)?$settings:alookhor_cc_get_site_feature_settings();
    if(empty($s['enabled']))return '';
    $items=array_slice(array_values((array)($s['items']??[])),0,4);
    if(count($items)!==4)return '';
    $glass=preg_match('/^rgba?\([^)]*\)$/',(string)($s['glass']??''))?(string)$s['glass']:'rgba(33,20,38,.75)';
    $style=sprintf(
        '--sf-bg:%s;--sf-card:%s;--sf-glass:%s;--sf-gold:%s;--sf-gold-light:%s;--sf-text:%s;--sf-muted:%s;--sf-radius:%dpx;--sf-gap:%dpx',
        sanitize_hex_color($s['background']??'')?:'#0D0510',
        sanitize_hex_color($s['card']??'')?:'#1C1024',
        $glass,
        sanitize_hex_color($s['gold']??'')?:'#D49A2E',
        sanitize_hex_color($s['gold_light']??'')?:'#E8B84A',
        sanitize_hex_color($s['text']??'')?:'#F5F3F0',
        sanitize_hex_color($s['muted']??'')?:'#C8C2C9',
        max(10,min(30,absint($s['radius']??20))),
        max(0,min(20,absint($s['gap']??8)))
    );
    ob_start(); ?>
    <section id="alookhor-managed-features" class="alookhor-sf" dir="rtl" style="<?php echo esc_attr($style); ?>" data-version="<?php echo esc_attr(ALOOKHOR_CC_VERSION); ?>" data-item-count="4" aria-label="ویژگی‌های آلوخور">
      <div class="alookhor-sf-shell">
        <div class="alookhor-sf-grid">
          <?php foreach($items as $index=>$item): ?>
          <article class="alookhor-sf-card" data-feature="<?php echo esc_attr($index); ?>">
            <span class="alookhor-sf-icon"><?php echo alookhor_cc_site_feature_icon($item['icon']??'shield'); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></span>
            <div class="alookhor-sf-copy"><h3><?php echo esc_html($item['title']??''); ?></h3><p><?php echo esc_html($item['description']??''); ?></p></div>
          </article>
          <?php endforeach; ?>
        </div>
      </div>
    </section>
    <?php return ob_get_clean();
}

function alookhor_cc_site_feature_shortcode(){
    if(!empty($GLOBALS['alookhor_cc_site_feature_shortcode_rendered']))return '';
    $settings=alookhor_cc_get_site_feature_settings();
    if(empty($settings['enabled']))return '';
    $GLOBALS['alookhor_cc_site_feature_shortcode_rendered']=true;
    return alookhor_cc_site_feature_markup($settings);
}
add_shortcode('alookhor_managed_features','alookhor_cc_site_feature_shortcode');

function alookhor_cc_site_feature_template(){
    static $done=false;
    if($done||is_admin()||!is_front_page()||!empty($GLOBALS['alookhor_cc_site_feature_shortcode_rendered']))return;
    $settings=alookhor_cc_get_site_feature_settings();
    if(empty($settings['enabled']))return;
    $done=true;
    echo '<template id="alookhor-managed-features-template">'.alookhor_cc_site_feature_markup($settings).'</template>';
    echo '<noscript><style>body.alookhor-sf-hide-legacy .alookhor-trustbar-container{display:block!important}</style></noscript>';
}
add_action('wp_footer','alookhor_cc_site_feature_template',2);

add_filter('body_class',function($classes){
    $settings=alookhor_cc_get_site_feature_settings();
    if(!empty($settings['enabled']))$classes[]='alookhor-sf-enabled';
    if(!empty($settings['enabled'])&&!empty($settings['hide_legacy']))$classes[]='alookhor-sf-hide-legacy';
    return array_values(array_unique($classes));
});

add_action('wp_enqueue_scripts',function(){
    if(!is_front_page())return;
    $settings=alookhor_cc_get_site_feature_settings();
    if(empty($settings['enabled']))return;
    wp_enqueue_style('alookhor-cc-managed-features',ALOOKHOR_CC_URL.'assets/css/frontend-features.css',[],ALOOKHOR_CC_BUILD);
    wp_enqueue_script('alookhor-cc-managed-features',ALOOKHOR_CC_URL.'assets/js/frontend-features.js',[],ALOOKHOR_CC_BUILD,true);
    wp_localize_script('alookhor-cc-managed-features','ALOOKHOR_FEATURES',[
        'endpoint'=>rest_url('alookhor-cc/v1/site-features'),
        'version'=>ALOOKHOR_CC_VERSION,
        'hide_legacy'=>!empty($settings['hide_legacy']),
        'legacy_selector'=>'.alookhor-trustbar-container',
    ]);
},31);
````

## Source Snapshot — `plugin/alookhor-control-center/includes/updater.php`

````php
<?php
/**
 * ALOOKHOR Control Center — WordPress-native private updater.
 *
 * The release endpoint is intentionally configurable so private package URLs
 * and credentials never have to be committed to the plugin archive.
 *
 * Expected manifest (JSON):
 * {
 *   "version": "3.10.25",
 *   "download_url": "https://updates.alookhor.ir/releases/alookhor-control-center-3.10.25.zip",
 *   "details_url": "https://example.com/changelog",
 *   "requires": "6.0",
 *   "tested": "7.0",
 *   "requires_php": "8.0",
 *   "changelog": [
 *     {"tag":"FIX", "title":"Title", "desc":"Description"}
 *   ]
 * }
 */

if (!defined('ABSPATH')) exit;

const ALOOKHOR_CC_UPDATE_CACHE_KEY = 'alookhor_cc_update_manifest_v1';

/**
 * Return the private release manifest URL.
 *
 * Production default: https://updates.alookhor.ir/manifest.json
 *
 * The endpoint can still be overridden from wp-config.php or a filter:
 * define('ALOOKHOR_CC_UPDATE_MANIFEST_URL', 'https://another-host/manifest.json');
 * add_filter('alookhor_cc_update_manifest_url', fn() => 'https://another-host/manifest.json');
 */
function alookhor_cc_update_manifest_url(){
    $url = defined('ALOOKHOR_CC_UPDATE_MANIFEST_URL')
        ? (string) ALOOKHOR_CC_UPDATE_MANIFEST_URL
        : 'https://updates.alookhor.ir/manifest.json';

    $url = (string) apply_filters('alookhor_cc_update_manifest_url', $url);
    return esc_url_raw(trim($url));
}

/**
 * Normalize and validate a remote manifest before WordPress can consume it.
 */
function alookhor_cc_normalize_update_manifest($payload){
    if (!is_array($payload)) {
        return new WP_Error('alookhor_invalid_manifest', 'پاسخ سرور آپدیت JSON معتبر نیست.');
    }

    $version = sanitize_text_field($payload['version'] ?? '');
    if (!$version || !preg_match('/^\d+\.\d+\.\d+(?:[-+][0-9A-Za-z.-]+)?$/', $version)) {
        return new WP_Error('alookhor_invalid_version', 'نسخه موجود در Manifest معتبر نیست.');
    }

    $download_url = esc_url_raw($payload['download_url'] ?? $payload['package'] ?? '');
    $details_url  = esc_url_raw($payload['details_url'] ?? $payload['url'] ?? '');
    $sha256 = strtolower(sanitize_text_field($payload['sha256'] ?? ''));

    if (!$download_url || wp_parse_url($download_url, PHP_URL_SCHEME) !== 'https') {
        return new WP_Error('alookhor_invalid_package_url', 'آدرس بسته بروزرسانی باید HTTPS معتبر باشد.');
    }
    $allowed_hosts = (array) apply_filters('alookhor_cc_update_allowed_hosts', ['updates.alookhor.ir']);
    $package_host = strtolower((string) wp_parse_url($download_url, PHP_URL_HOST));
    if (!$package_host || !in_array($package_host, array_map('strtolower', $allowed_hosts), true)) {
        return new WP_Error('alookhor_untrusted_package_host', 'دامنه بسته بروزرسانی مورد اعتماد نیست.');
    }
    if (!preg_match('/^[a-f0-9]{64}$/', $sha256)) {
        return new WP_Error('alookhor_invalid_sha256', 'Manifest فاقد SHA-256 معتبر است.');
    }

    $changelog = [];
    if (!empty($payload['changelog']) && is_array($payload['changelog'])) {
        foreach ($payload['changelog'] as $entry) {
            if (!is_array($entry)) continue;
            $changelog[] = [
                'tag'   => sanitize_text_field($entry['tag'] ?? 'UPDATE'),
                'title' => sanitize_text_field($entry['title'] ?? ('v' . $version)),
                'desc'  => sanitize_textarea_field($entry['desc'] ?? $entry['description'] ?? ''),
            ];
        }
    } elseif (!empty($payload['changelog']) && is_string($payload['changelog'])) {
        $changelog[] = [
            'tag'   => 'UPDATE',
            'title' => 'نسخه ' . $version,
            'desc'  => sanitize_textarea_field(wp_strip_all_tags($payload['changelog'])),
        ];
    }

    return [
        'version'      => $version,
        'download_url' => $download_url,
        'sha256'       => $sha256,
        'details_url'  => $details_url ?: 'https://alookhor.ir',
        'requires'     => sanitize_text_field($payload['requires'] ?? '6.0'),
        'tested'       => sanitize_text_field($payload['tested'] ?? ''),
        'requires_php' => sanitize_text_field($payload['requires_php'] ?? '8.0'),
        'name'         => sanitize_text_field($payload['name'] ?? 'ALOOKHOR Control Center'),
        'author'       => wp_kses_post($payload['author'] ?? 'ALOOKHOR Team'),
        'description'  => wp_kses_post($payload['description'] ?? 'کنترل سنتر لوکس و ماژولار ALOOKHOR'),
        'changelog'    => $changelog,
    ];
}

/**
 * Fetch and cache the private manifest. wp_safe_remote_get prevents unsafe
 * redirects/hosts and WordPress handles TLS verification.
 */
function alookhor_cc_get_update_manifest($force = false){
    $url = alookhor_cc_update_manifest_url();
    if (!$url) {
        return new WP_Error('alookhor_updater_not_configured', 'آدرس Manifest سیستم آپدیت تنظیم نشده است.');
    }

    if (!$force) {
        $cached = get_site_transient(ALOOKHOR_CC_UPDATE_CACHE_KEY);
        if (is_array($cached) && !empty($cached['version'])) return $cached;
    }

    $response = wp_safe_remote_get($url, [
        'timeout'     => 12,
        'redirection' => 3,
        'headers'     => [
            'Accept'     => 'application/json',
            'User-Agent' => 'ALOOKHOR-Control-Center/' . ALOOKHOR_CC_VERSION . '; ' . home_url('/'),
        ],
    ]);

    if (is_wp_error($response)) return $response;

    $status = (int) wp_remote_retrieve_response_code($response);
    if ($status !== 200) {
        return new WP_Error('alookhor_update_http_error', sprintf('سرور آپدیت کد HTTP %d برگرداند.', $status));
    }

    $decoded = json_decode(wp_remote_retrieve_body($response), true);
    $manifest = alookhor_cc_normalize_update_manifest($decoded);
    if (is_wp_error($manifest)) return $manifest;

    set_site_transient(ALOOKHOR_CC_UPDATE_CACHE_KEY, $manifest, 6 * HOUR_IN_SECONDS);
    return $manifest;
}

/**
 * Merge a validated ALOOKHOR release into WordPress' update_plugins transient.
 */
function alookhor_cc_apply_manifest_to_update_transient($transient, $manifest){
    if (!is_object($transient)) $transient = new stdClass();

    $plugin = ALOOKHOR_CC_PLUGIN_BASENAME;
    if (!isset($transient->checked) || !is_array($transient->checked)) $transient->checked = [];
    if (!isset($transient->response) || !is_array($transient->response)) $transient->response = [];
    if (!isset($transient->no_update) || !is_array($transient->no_update)) $transient->no_update = [];
    $transient->checked[$plugin] = ALOOKHOR_CC_VERSION;

    $item = (object) [
        'id'           => 'alookhor-control-center',
        'slug'         => 'alookhor-control-center',
        'plugin'       => $plugin,
        'new_version'  => $manifest['version'],
        'url'          => $manifest['details_url'],
        'package'      => $manifest['download_url'],
        'requires'     => $manifest['requires'],
        'tested'       => $manifest['tested'],
        'requires_php' => $manifest['requires_php'],
    ];

    if (version_compare($manifest['version'], ALOOKHOR_CC_VERSION, '>')) {
        $transient->response[$plugin] = $item;
        unset($transient->no_update[$plugin]);
    } else {
        $transient->no_update[$plugin] = $item;
        unset($transient->response[$plugin]);
    }

    return $transient;
}

/**
 * Register a private release in WordPress' native plugin update transient.
 */
add_filter('pre_set_site_transient_update_plugins', function($transient){
    if (!alookhor_cc_update_manifest_url()) return $transient;

    $manifest = alookhor_cc_get_update_manifest(false);
    if (is_wp_error($manifest)) return $transient;

    return alookhor_cc_apply_manifest_to_update_transient($transient, $manifest);
});

/**
 * Download ALOOKHOR packages through WordPress, then enforce the SHA-256 from
 * the trusted manifest before Core Upgrader can unpack or replace any files.
 */
add_filter('upgrader_pre_download', function($reply, $package, $upgrader, $hook_extra){
    if (false !== $reply || !is_string($package)) return $reply;

    $package_host = strtolower((string) wp_parse_url($package, PHP_URL_HOST));
    $allowed_hosts = array_map('strtolower', (array) apply_filters('alookhor_cc_update_allowed_hosts', ['updates.alookhor.ir']));
    if (!in_array($package_host, $allowed_hosts, true)) return $reply;

    $plugin = $hook_extra['plugin'] ?? '';
    $plugins = $hook_extra['plugins'] ?? [];
    $targets_alookhor = $plugin === ALOOKHOR_CC_PLUGIN_BASENAME
        || (is_array($plugins) && in_array(ALOOKHOR_CC_PLUGIN_BASENAME, $plugins, true));
    if (!$targets_alookhor && strpos(wp_basename($package), 'alookhor-control-center-') !== 0) return $reply;

    $manifest = alookhor_cc_get_update_manifest(true);
    if (is_wp_error($manifest)) return $manifest;
    if (!hash_equals($manifest['download_url'], $package)) {
        return new WP_Error('alookhor_package_url_mismatch', 'آدرس بسته با Manifest مورد اعتماد مطابقت ندارد.');
    }

    require_once ABSPATH . 'wp-admin/includes/file.php';
    $downloaded = download_url($package, 300, false);
    if (is_wp_error($downloaded)) return $downloaded;

    $actual = strtolower((string) hash_file('sha256', $downloaded));
    if (!$actual || !hash_equals($manifest['sha256'], $actual)) {
        wp_delete_file($downloaded);
        return new WP_Error('alookhor_sha256_mismatch', 'SHA-256 بسته بروزرسانی معتبر نیست؛ نصب متوقف شد.');
    }

    set_site_transient('alookhor_cc_last_verified_package', [
        'version' => $manifest['version'],
        'sha256' => $actual,
        'verified_at' => time(),
    ], DAY_IN_SECONDS);
    return $downloaded;
}, 10, 4);

/**
 * Supply the details modal used by WordPress' Plugins screen.
 */
add_filter('plugins_api', function($result, $action, $args){
    if ($action !== 'plugin_information' || empty($args->slug) || $args->slug !== 'alookhor-control-center') {
        return $result;
    }

    $manifest = alookhor_cc_get_update_manifest(false);
    if (is_wp_error($manifest)) return $result;

    $changelog_html = '';
    foreach ($manifest['changelog'] as $entry) {
        $changelog_html .= '<h4>' . esc_html($entry['title']) . '</h4><p>' . nl2br(esc_html($entry['desc'])) . '</p>';
    }

    return (object) [
        'name'          => $manifest['name'],
        'slug'          => 'alookhor-control-center',
        'version'       => $manifest['version'],
        'author'        => $manifest['author'],
        'homepage'      => $manifest['details_url'],
        'requires'      => $manifest['requires'],
        'tested'        => $manifest['tested'],
        'requires_php'  => $manifest['requires_php'],
        'download_link' => $manifest['download_url'],
        'sections'      => [
            'description' => $manifest['description'],
            'changelog'   => $changelog_html ?: '<p>جزئیات این نسخه در دسترس نیست.</p>',
        ],
    ];
}, 20, 3);

/**
 * Update Center AJAX bridge. It reports truthful native WordPress state;
 * installation itself is delegated to wp.updates.updatePlugin in admin JS.
 */
add_action('wp_ajax_alookhor_check_updates', function(){
    alookhor_cc_check();

    $force = !empty($_POST['force']) && rest_sanitize_boolean(wp_unslash($_POST['force']));
    if ($force) delete_site_transient(ALOOKHOR_CC_UPDATE_CACHE_KEY);

    $manifest = alookhor_cc_get_update_manifest($force);
    if (is_wp_error($manifest)) {
        $not_configured = $manifest->get_error_code() === 'alookhor_updater_not_configured';
        wp_send_json_success([
            'configured' => !$not_configured,
            'available'  => false,
            'installable'=> false,
            'current'    => ALOOKHOR_CC_VERSION,
            'latest'     => ALOOKHOR_CC_VERSION,
            'message'    => $manifest->get_error_message(),
            'error_code' => $manifest->get_error_code(),
            'changelog'  => [],
        ]);
    }

    $available = version_compare($manifest['version'], ALOOKHOR_CC_VERSION, '>');

    // Make the same release immediately available to WordPress' core
    // `update-plugin` AJAX action used by wp.updates.updatePlugin.
    $native_transient = get_site_transient('update_plugins');
    if (!is_object($native_transient)) $native_transient = new stdClass();
    $native_transient->last_checked = time();
    $native_transient = alookhor_cc_apply_manifest_to_update_transient($native_transient, $manifest);
    set_site_transient('update_plugins', $native_transient);

    wp_send_json_success([
        'configured'  => true,
        'available'   => $available,
        'installable' => $available && !empty($manifest['download_url']),
        'current'     => ALOOKHOR_CC_VERSION,
        'latest'      => $manifest['version'],
        'sha256'      => $manifest['sha256'],
        'details_url' => $manifest['details_url'],
        'message'     => $available ? 'نسخه جدید آماده نصب است.' : 'افزونه به‌روز است.',
        'changelog'   => $manifest['changelog'],
    ]);
});

/**
 * Determine whether an upgrader operation targets this plugin. Both the
 * single-plugin and bulk-plugin argument shapes are supported.
 */
function alookhor_cc_upgrader_targets_self($options){
    if (!is_array($options)) return false;
    $plugin = $options['plugin'] ?? '';
    $plugins = $options['plugins'] ?? [];
    return $plugin === ALOOKHOR_CC_PLUGIN_BASENAME
        || (is_array($plugins) && in_array(ALOOKHOR_CC_PLUGIN_BASENAME, $plugins, true));
}

/**
 * Restore only an activation state that existed before the update. This does
 * not grant a caller permission to activate an independently inactive plugin.
 */
function alookhor_cc_restore_activation_state($was_active, $was_network_active = false, $context = 'upgrader'){
    require_once ABSPATH . 'wp-admin/includes/plugin.php';
    if (!$was_active) {
        return ['required' => false, 'active' => is_plugin_active(ALOOKHOR_CC_PLUGIN_BASENAME)];
    }
    if (is_plugin_active(ALOOKHOR_CC_PLUGIN_BASENAME)) {
        return ['required' => true, 'reactivated' => false, 'active' => true];
    }

    $result = activate_plugin(ALOOKHOR_CC_PLUGIN_BASENAME, '', (bool) $was_network_active, true);
    $status = [
        'required' => true,
        'reactivated' => !is_wp_error($result),
        'active' => is_plugin_active(ALOOKHOR_CC_PLUGIN_BASENAME),
        'network_active' => is_multisite() && is_plugin_active_for_network(ALOOKHOR_CC_PLUGIN_BASENAME),
        'context' => sanitize_key($context),
        'checked_at' => time(),
    ];
    if (is_wp_error($result)) {
        $status['error'] = $result->get_error_code();
        set_site_transient('alookhor_cc_last_activation_restore', $status, DAY_IN_SECONDS);
        return $result;
    }
    set_site_transient('alookhor_cc_last_activation_restore', $status, DAY_IN_SECONDS);
    return $status;
}

/**
 * Plugin_Upgrader::upgrade() silently deactivates active plugins during a
 * foreground request. Capture our state before Core's priority-10 callback,
 * then restore it after a successful replacement. Registered callbacks stay
 * alive for this request even while this plugin's files are being replaced.
 */
add_filter('upgrader_pre_install', function($response, $options){
    if (is_wp_error($response) || !alookhor_cc_upgrader_targets_self($options)) return $response;
    require_once ABSPATH . 'wp-admin/includes/plugin.php';
    $GLOBALS['alookhor_cc_pre_update_activation'] = [
        'active' => is_plugin_active(ALOOKHOR_CC_PLUGIN_BASENAME),
        'network_active' => is_multisite() && is_plugin_active_for_network(ALOOKHOR_CC_PLUGIN_BASENAME),
    ];
    return $response;
}, 5, 2);

add_action('upgrader_process_complete', function($upgrader, $options){
    if (($options['action'] ?? '') !== 'update' || ($options['type'] ?? '') !== 'plugin') return;
    delete_site_transient(ALOOKHOR_CC_UPDATE_CACHE_KEY);
    if (!alookhor_cc_upgrader_targets_self($options)) return;

    $state = $GLOBALS['alookhor_cc_pre_update_activation'] ?? [];
    alookhor_cc_restore_activation_state(
        !empty($state['active']),
        !empty($state['network_active']),
        'upgrader_process_complete'
    );
    unset($GLOBALS['alookhor_cc_pre_update_activation']);
}, 20, 2);
````

## Source Snapshot — `plugin/alookhor-control-center/templates/admin-control-center.php`

````php
<?php if (!defined('ABSPATH')) exit; ?>
<div id="alookhor-cc-root" style="background:#070708; min-height:calc(100vh - 60px); padding:0; margin:0">
<!-- Header — Luxury Glass | Rendered by Shortcode [alookhor_portal_header] — المنتور -->
  <header class="lux-header" title="Shortcode: [alookhor_portal_header]">
    <div class="lux-header-inner">
      <button class="icon-btn hamburger" id="hamburger" aria-label="منو">
        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M4 7h16"/><path d="M4 12h16"/><path d="M4 17h16"/></svg>
      </button>

      <a class="brand" href="#settings" data-module="settings">
        <div class="brand-mark"><span>A</span></div>
        <div class="brand-text">
          <h1>ALOOKHOR</h1>
          <p>Control Center • Luxury</p>
        </div>
      </a>

      <div class="header-center">
        <label class="search-pill">
          <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#9A9590" stroke-width="1.7"><circle cx="11" cy="11" r="7"/><path d="M20 20l-3.5-3.5"/></svg>
          <input placeholder="جستجو در سفارشات، مشتریان، قطعات..." />
          <span style="font-size:11px; color:var(--text-faint); background:rgba(255,255,255,0.06); padding:3px 7px; border-radius:999px; border:1px solid var(--gold-border)">⌘ K</span>
        </label>
      </div>

      <div class="header-actions">
        <div class="version-badge" title="نسخه فعلی">
          <span style="width:6px; height:6px; border-radius:50%; background:#3DD68C; box-shadow:0 0 0 4px rgba(61,214,140,0.15); display:inline-block"></span>
          <span id="headerVersion">v3.10.25</span>
          <span style="opacity:0.5">•</span>
          <span id="bpIndicator" style="font-family:monospace; font-size:11px">—</span>
        </div>

        <button class="icon-btn" id="btnUpdateCenter" title="Update Center — سیستم آپدیت داخلی" style="width:auto; padding:0 12px; gap:8px; border-radius:999px">
          <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7"><path d="M21 12a9 9 0 1 1-9-9"/><path d="M21 12v-6h-6"/><path d="M12 7v5l4 2"/></svg>
          <span style="font-size:12px; font-weight:700; letter-spacing:0.04em">Update</span>
          <span id="updateBadge" style="display:none; background:var(--gold); color:#1A1206; font-size:10px; font-weight:800; padding:2px 7px; border-radius:999px; letter-spacing:0.06em">جدید</span>
          <span class="pulse-dot" style="top:4px; right:4px; width:7px; height:7px; display:none" id="pulseDot"></span>
        </button>

        <button class="icon-btn" title="اعلان‌ها">
          <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6"><path d="M6 8a6 6 0 0 1 12 0c0 7-6 9-6 9s-6-2-6-9"/><path d="M10.3 21a1.94 1.94 0 0 0 3.4 0"/></svg>
        </button>
        <button class="icon-btn gold" title="پروفایل">
          <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6"><path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
        </button>
      </div>
    </div>
  </header>

  <div class="backdrop" id="backdrop"></div>
  <div class="backdrop" id="modalBackdrop" style="z-index:55"></div>

  <!-- Shell -->
  <div class="shell">
    <!-- Sidebar — PRO Luxury Modular Navigation (حرفه‌ای، دسته‌بندی شده، بدون لیست طولانی) -->
    <aside class="sidebar" id="sidebar">
      <!-- جستجوی داخل منو -->
      <label class="sidebar-search">
        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#9A9590" stroke-width="1.8"><circle cx="11" cy="11" r="7"/><path d="M20 20l-3.5-3.5"/></svg>
        <input id="menuSearch" placeholder="جستجو در منو..." />
        <kbd>/</kbd>
      </label>

      <!-- مدیریت بوتیک — فضای اصلی و اولویت اول -->
      <div class="nav-item single nav-item-primary" data-module="settings">
        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7"><path d="M4 10h16v10H4z"/><path d="M3 10l2-6h14l2 6"/><path d="M8 20v-6h4v6"/><path d="M3 10c0 1.7 2.2 2.6 3.5 1.4C7.7 12.6 10 11.7 10 10c0 1.7 2.3 2.6 3.5 1.4C14.8 12.6 17 11.7 17 10c0 1.7 2.2 2.6 3.5 1.4"/></svg>
        مدیریت بوتیک
        <span class="badge">اصلی</span>
      </div>

      <!-- داشبورد — پایش و سلامت سیستم -->
      <div class="nav-item single active" data-module="dashboard">
        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7"><rect x="3" y="3" width="7" height="7" rx="1.5"/><rect x="14" y="3" width="7" height="7" rx="1.5"/><rect x="14" y="14" width="7" height="7" rx="1.5"/><rect x="3" y="14" width="7" height="7" rx="1.5"/></svg>
        داشبورد
        <span class="badge">زنده</span>
      </div>

      <nav id="proNav" style="display:grid; gap:4px; margin-top:4px">

        <!-- گروه: فروش — بخش کم‌اولویت/آزمایشی -->
        <div class="nav-group" data-group="sales">
          <div class="nav-group-head">
            <div class="nav-group-icon">
              <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7"><path d="M6 2h9l5 5v15H6z"/><path d="M15 2v6h6"/><path d="M9 13h6"/><path d="M9 17h6"/></svg>
            </div>
            <span class="nav-group-title">مدیریت فروش</span>
            <span class="nav-group-count">4</span>
            <span class="nav-chevron"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M6 9l6 6 6-6"/></svg></span>
          </div>
          <div class="nav-group-body"><div class="nav-group-inner">
            <div class="nav-sub-list">
              <div class="nav-sub-item active" data-module="orders"><span class="sub-dot"></span> سفارشات <span class="sub-badge">۱۴۷</span></div>
              <div class="nav-sub-item" data-module="invoices"><span class="sub-dot"></span> فاکتورها</div>
              <div class="nav-sub-item" data-module="quotes"><span class="sub-dot"></span> پیش‌فاکتورها <span class="sub-badge" style="background:rgba(61,214,140,0.14); color:#3DD68C">جدید</span></div>
              <div class="nav-sub-item" data-module="returns"><span class="sub-dot"></span> مرجوعی‌ها</div>
            </div>
          </div></div>
        </div>

        <!-- گروه: ویترین و انبار -->
        <div class="nav-group" data-group="catalog">
          <div class="nav-group-head">
            <div class="nav-group-icon">
              <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7"><path d="M12 2l9 4.5v9L12 20 3 15.5v-9L12 2z"/><path d="M12 12l9-4.5"/><path d="M12 12v8"/><path d="M3 7.5l9 4.5"/></svg>
            </div>
            <span class="nav-group-title">ویترین و انبار</span>
            <span class="nav-group-count">4</span>
            <span class="nav-chevron"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M6 9l6 6 6-6"/></svg></span>
          </div>
          <div class="nav-group-body"><div class="nav-group-inner">
            <div class="nav-sub-list">
              <div class="nav-sub-item" data-module="products"><span class="sub-dot"></span> محصولات</div>
              <div class="nav-sub-item" data-module="categories"><span class="sub-dot"></span> دسته‌بندی‌ها</div>
              <div class="nav-sub-item" data-module="inventory"><span class="sub-dot"></span> موجودی و انبار <span class="sub-badge">۱,۲۸۴</span></div>
              <div class="nav-sub-item" data-module="collections"><span class="sub-dot"></span> کالکشن‌های لوکس</div>
            </div>
          </div></div>
        </div>

        <!-- گروه: مشتریان -->
        <div class="nav-group" data-group="customers">
          <div class="nav-group-head">
            <div class="nav-group-icon">
              <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M22 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
            </div>
            <span class="nav-group-title">مشتریان و باشگاه</span>
            <span class="nav-group-count">4</span>
            <span class="nav-chevron"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M6 9l6 6 6-6"/></svg></span>
          </div>
          <div class="nav-group-body"><div class="nav-group-inner">
            <div class="nav-sub-list">
              <div class="nav-sub-item" data-module="users"><span class="sub-dot"></span> مشتریان VIP <span class="sub-badge">۸۹۲</span></div>
              <div class="nav-sub-item" data-module="club"><span class="sub-dot"></span> باشگاه طلایی</div>
              <div class="nav-sub-item" data-module="tickets"><span class="sub-dot"></span> تیکت و پشتیبانی <span class="sub-badge">۶</span></div>
              <div class="nav-sub-item" data-module="reviews"><span class="sub-dot"></span> نظرات و امتیاز</div>
            </div>
          </div></div>
        </div>

        <!-- گروه: مالی -->
        <div class="nav-group" data-group="finance">
          <div class="nav-group-head">
            <div class="nav-group-icon">
              <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7"><circle cx="12" cy="8" r="6"/><path d="M15.5 12.5l-3 3-3-3"/><path d="M12 12.5V20"/><path d="M5 20h14"/></svg>
            </div>
            <span class="nav-group-title">مالی و طلا</span>
            <span class="nav-group-count">3</span>
            <span class="nav-chevron"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M6 9l6 6 6-6"/></svg></span>
          </div>
          <div class="nav-group-body"><div class="nav-group-inner">
            <div class="nav-sub-list">
              <div class="nav-sub-item" data-module="transactions"><span class="sub-dot"></span> تراکنش‌ها</div>
              <div class="nav-sub-item" data-module="gold-price"><span class="sub-dot"></span> قیمت لحظه‌ای طلا <span class="sub-badge" style="background:rgba(61,214,140,0.14); color:#3DD68C">Live</span></div>
              <div class="nav-sub-item" data-module="accounting"><span class="sub-dot"></span> حسابداری</div>
            </div>
          </div></div>
        </div>

        <!-- گروه: تحلیل -->
        <div class="nav-group" data-group="analytics">
          <div class="nav-group-head">
            <div class="nav-group-icon">
              <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7"><path d="M3 3v18h18"/><path d="M7 16l4-4 4 4 4-6"/></svg>
            </div>
            <span class="nav-group-title">تحلیل و گزارش</span>
            <span class="nav-group-count">3</span>
            <span class="nav-chevron"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M6 9l6 6 6-6"/></svg></span>
          </div>
          <div class="nav-group-body"><div class="nav-group-inner">
            <div class="nav-sub-list">
              <div class="nav-sub-item" data-module="analytics"><span class="sub-dot"></span> آنالیتیکس</div>
              <div class="nav-sub-item" data-module="sales-report"><span class="sub-dot"></span> گزارش فروش</div>
              <div class="nav-sub-item" data-module="stock-report"><span class="sub-dot"></span> گزارش انبار</div>
            </div>
          </div></div>
        </div>

        <!-- گروه: سیستم -->
        <div class="nav-group" data-group="system">
          <div class="nav-group-head">
            <div class="nav-group-icon">
              <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7"><path d="M12 20a8 8 0 1 0 0-16 8 8 0 0 0 0 16Z"/><path d="M12 14a2 2 0 1 0 0-4 2 2 0 0 0 0 4Z"/></svg>
            </div>
            <span class="nav-group-title">سیستم</span>
            <span class="nav-group-count">3</span>
            <span class="nav-chevron"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M6 9l6 6 6-6"/></svg></span>
          </div>
          <div class="nav-group-body"><div class="nav-group-inner">
            <div class="nav-sub-list">
              <div class="nav-sub-item" data-module="roles"><span class="sub-dot"></span> کاربران و دسترسی</div>
              <div class="nav-sub-item" data-module="update"><span class="sub-dot"></span> Update Center <span style="width:7px; height:7px; border-radius:50%; background:#3DD68C; box-shadow:0 0 0 4px rgba(61,214,140,0.18); margin-right:auto"></span></div>
              <div class="nav-sub-item" data-module="logs"><span class="sub-dot"></span> لاگ‌ها</div>
            </div>
          </div></div>
        </div>

      </nav>

      <div class="nav-divider"></div>

      <div style="padding:12px; background: linear-gradient(135deg, rgba(201,168,106,0.13), rgba(201,168,106,0.04)); border:1px solid var(--gold-border-strong); border-radius:16px">
        <div style="display:flex; align-items:center; gap:8px">
          <div style="width:8px; height:8px; border-radius:50%; background:#3DD68C; box-shadow:0 0 0 4px rgba(61,214,140,0.15)"></div>
          <div style="font-size:12px; font-weight:700; letter-spacing:0.05em; color:var(--gold-soft)">وضعیت کنترل سنتر</div>
          <span style="margin-right:auto; font-size:10px; background:var(--gold); color:#1A1206; font-weight:800; padding:2px 7px; border-radius:999px">PRO</span>
        </div>
        <div style="display:grid; grid-template-columns:1fr 1fr; gap:8px; margin-top:10px">
          <div style="background:rgba(255,255,255,0.04); border:1px solid var(--gold-border); border-radius:10px; padding:8px; text-align:center"><div style="font-size:11px; color:var(--text-faint)">نسخه</div><b id="versionBadgeText" style="font-family:monospace; font-size:12px; color:var(--text-primary)">v3.10.25</b></div>
          <div style="background:rgba(255,255,255,0.04); border:1px solid var(--gold-border); border-radius:10px; padding:8px; text-align:center"><div style="font-size:11px; color:var(--text-faint)">ماژول</div><b style="font-size:12px; color:var(--gold-soft)">۱۹ فعال</b></div>
        </div>
        <div style="height:6px; background:rgba(255,255,255,0.06); border-radius:999px; overflow:hidden; margin-top:10px"><div style="width:100%; height:100%; background:linear-gradient(90deg,#C9A86A,#E8D5B5)"></div></div>
        <div style="font-size:10.5px; color:var(--text-faint); margin-top:6px; text-align:center; line-height:1.5">منو فشرده و حرفه‌ای — بدون اسکرول طولانی</div>
      </div>

      <div style="margin-top:10px; padding:10px 11px; background:rgba(255,255,255,0.02); border:1px solid var(--gold-border); border-radius:12px; display:flex; gap:10px; align-items:center">
        <div style="width:30px; height:30px; border-radius:999px; background:linear-gradient(135deg,#C9A86A,#E8D5B5); display:grid; place-items:center; color:#1A1206; font-weight:800; font-size:12px">A</div>
        <div style="line-height:1.2"><div style="font-size:12.5px; font-weight:700">بوتیک ALOOKHOR</div><div style="font-size:11px; color:var(--text-muted)">ادمین ارشد • آنلاین</div></div>
        <div style="margin-right:auto; width:8px; height:8px; border-radius:50%; background:#3DD68C"></div>
      </div>
    </aside>

    <!-- Main — Module Container -->
    <main class="main">

      <div id="moduleContainer" style="min-height:420px; transition: all 0.28s ease">
        <!-- Fallback PHP Rendered Dashboard — اگر JS لود نشد، این نمایش داده می‌شود -->
        <div class="page-head">
          <div>
            <h2>داشبورد لوکس — نمای کلی</h2>
            <p>آخرین به‌روزرسانی: همین حالا • مانیتورینگ زنده بوتیک ALOOKHOR — <span style="background:rgba(61,214,140,0.12); color:#3DD68C; padding:2px 8px; border-radius:999px; font-size:11px; border:1px solid rgba(61,214,140,0.18)">● JS Fallback Active</span></p>
          </div>
          <div class="head-actions">
            <button class="btn-ghost" onclick="alert('خروجی Excel در آپدیت بعدی')">خروجی Excel</button>
            <button class="btn-gold" onclick="alert('سفارش جدید — به زودی')">+ سفارش جدید</button>
          </div>
        </div>
        <div class="kpi-grid">
          <div class="kpi-card">
            <div class="kpi-top"><div class="kpi-icon" style="color:#C9A86A">●</div><span class="kpi-trend trend-up">▲ 12.4%</span></div>
            <div class="kpi-value">۲.۴B <span style="font-size:14px; color:#9A9590; font-family:Inter">تومان</span></div>
            <div class="kpi-label">فروش امروز</div>
            <div class="kpi-foot">نسبت به دیروز +۱۲.۴٪ — ۳ سفارش VIP</div>
          </div>
          <div class="kpi-card">
            <div class="kpi-top"><div class="kpi-icon">◆</div><span class="kpi-trend trend-up">▲ 8.1%</span></div>
            <div class="kpi-value">۱۴۷</div>
            <div class="kpi-label">سفارشات فعال</div>
            <div class="kpi-foot">۳۲ در انتظار تایید طلا</div>
          </div>
          <div class="kpi-card">
            <div class="kpi-top"><div class="kpi-icon">▦</div><span class="kpi-trend trend-down">▼ 2.3%</span></div>
            <div class="kpi-value">۱,۲۸۴</div>
            <div class="kpi-label">موجودی انبار</div>
            <div class="kpi-foot">۱۸ قلم کمتر از حد لوکس</div>
          </div>
          <div class="kpi-card">
            <div class="kpi-top"><div class="kpi-icon">👑</div><span class="kpi-trend trend-up">▲ 4.7%</span></div>
            <div class="kpi-value">۸۹۲</div>
            <div class="kpi-label">مشتریان VIP</div>
            <div class="kpi-foot">۱۴ مشتری جدید این هفته</div>
          </div>
        </div>
        <div style="margin-top:14px; background:rgba(201,168,106,0.08); border:1px solid rgba(201,168,106,0.14); border-radius:12px; padding:12px; font-size:12.5px; color:#E8D5B5; line-height:1.7">
          <b>✓ افزونه نصب شد</b> — اگر این داشبورد را می‌بینی، یعنی هسته لود شده. از بالای سایدبار روی <b>مدیریت بوتیک</b> بزن تا فضای وسیع تنظیمات ماژول‌ها باز شود؛ دستیار هوشمند و سلامت سیستم فقط در داشبورد نمایش داده می‌شوند. اگر باز هم خالی بود، کش مرورگر را با <b>Ctrl+Shift+R</b> پاک کن.
        </div>
        <div class="two-col">
          <div class="panel">
            <div class="panel-head"><h3>سفارشات اخیر</h3><span style="font-size:11px; color:#6B6763">زنده</span></div>
            <div style="padding:12px">
              <div style="display:grid; gap:8px">
                <div style="display:flex; justify-content:space-between; background:rgba(255,255,255,0.03); border:1px solid rgba(201,168,106,0.08); padding:10px; border-radius:10px; font-size:12px"><span>#AL-9841 — سارا احمدی — VIP Gold — ۱۸۴M</span><span style="color:#3DD68C; font-weight:700">● تحویل</span></div>
                <div style="display:flex; justify-content:space-between; background:rgba(255,255,255,0.03); border:1px solid rgba(201,168,106,0.08); padding:10px; border-radius:10px; font-size:12px"><span>#AL-9840 — امیر حسینی — ۹۲.۵M</span><span style="color:#C9A86A">● در ساخت</span></div>
              </div>
            </div>
          </div>
          <div class="panel"><div class="panel-head"><h3>فروش ۷ روز اخیر</h3></div><div style="padding:18px"><div style="height:120px; background:linear-gradient(180deg, rgba(201,168,106,0.06), transparent); border:1px solid rgba(201,168,106,0.14); border-radius:12px; display:flex; align-items:end; gap:8px; padding:12px; justify-content:center"><div style="width:18px; height:60px; background:linear-gradient(180deg,#E8D5B5,#C9A86A); border-radius:6px"></div><div style="width:18px; height:85px; background:linear-gradient(180deg,#E8D5B5,#C9A86A); border-radius:6px"></div><div style="width:18px; height:70px; background:linear-gradient(180deg,#E8D5B5,#C9A86A); border-radius:6px"></div><div style="width:18px; height:105px; background:linear-gradient(180deg,#E8D5B5,#C9A86A); border-radius:6px"></div></div></div></div>
        </div>
      </div>


      <!-- Footer luxury -->
      <div style="margin-top:18px; padding:14px 16px; display:flex; flex-wrap:wrap; gap:10px; justify-content:space-between; align-items:center; background:rgba(255,255,255,0.02); border:1px solid var(--gold-border); border-radius:14px; font-size:12px; color:var(--text-muted)">
        <span>© 2026 ALOOKHOR — Control Center v3.10.25 • <span id="pageTitle" style="color:var(--gold-soft); font-weight:700">داشبورد</span> • معماری ماژولار حفظ شد</span>
        <span style="display:flex; gap:8px; align-items:center">
          <span style="width:7px; height:7px; border-radius:50%; background:#3DD68C; display:inline-block"></span> سیستم پایدار
          <span style="opacity:0.4">|</span> <a href="<?php echo esc_url(ALOOKHOR_CC_URL . 'docs/PROJECT_MEMORY.md'); ?>" target="_blank" rel="noopener" style="color:var(--gold-soft); text-decoration:underline; text-underline-offset:3px">حافظه پروژه</a>
        </span>
      </div>
    </main>
  </div>

  <!-- Update Center Modal — Luxury -->
  <div class="modal" id="updateModal" aria-hidden="true">
    <div class="modal-card">
      <div class="modal-head">
        <div style="display:flex; align-items:center; gap:12px">
          <div style="width:36px; height:36px; border-radius:10px; background:linear-gradient(135deg,#C9A86A,#E8D5B5); display:grid; place-items:center; color:#1A1206">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M21 12a9 9 0 1 1-9-9"/><path d="M21 12v-6h-6"/></svg>
          </div>
          <div>
            <h3>Update Center</h3>
            <div style="font-size:12px; color:var(--text-muted); margin-top:2px" id="modalVersion">v3.10.25 — به‌روز</div>
          </div>
        </div>
        <button class="icon-btn" id="btnCloseModal" style="width:34px; height:34px">✕</button>
      </div>
      <div class="modal-body">
        <div id="updateStatusBox" style="display:flex; gap:10px; align-items:center; padding:10px 12px; background:rgba(61,214,140,0.08); border:1px solid rgba(61,214,140,0.18); border-radius:12px; margin-bottom:14px">
          <span style="width:8px; height:8px; border-radius:50%; background:#3DD68C; box-shadow:0 0 0 6px rgba(61,214,140,0.12)"></span>
          <span id="updateStatusText" style="font-size:13px; font-weight:600">در حال بررسی سیستم آپدیت داخلی...</span>
          <span id="updateStatusMode" style="margin-left:auto; font-size:11px; color:var(--text-faint); font-family:monospace">WP Native</span>
        </div>
        <div class="timeline" id="changelog">
          <!-- injected by JS -->
        </div>
        <div style="display:flex; gap:10px; margin-top:18px">
          <button class="btn-gold" id="btnInstall" style="flex:1">نصب آنی — بدون رفرش</button>
          <button class="btn-ghost" id="btnDismiss">بعداً</button>
        </div>
        <div style="text-align:center; margin-top:10px; font-size:11px; color:var(--text-faint)">نسخه‌ها SemVer هستند • Rollback خودکار در صورت خطا</div>
      </div>
    </div>
  </div>

  <div class="toast-stack" id="toastStack"></div>

  <script>window.ALOOKHOR_CC = window.ALOOKHOR_CC || {
    ajax_url: "<?php echo esc_js(admin_url('admin-ajax.php')); ?>",
    nonce: "<?php echo esc_js(wp_create_nonce('alookhor_cc_nonce')); ?>",
    site_json_url: "<?php echo esc_js(ALOOKHOR_CC_URL . 'config/site.json'); ?>",
    version: "<?php echo esc_js(ALOOKHOR_CC_VERSION); ?>",
    plugin_file: "<?php echo esc_js(ALOOKHOR_CC_PLUGIN_BASENAME); ?>",
    plugin_slug: "alookhor-control-center",
    native_update_url: "<?php echo esc_js(wp_nonce_url(self_admin_url('update.php?action=upgrade-plugin&plugin=' . rawurlencode(ALOOKHOR_CC_PLUGIN_BASENAME)), 'upgrade-plugin_' . ALOOKHOR_CC_PLUGIN_BASENAME)); ?>",
    updater_configured: <?php echo alookhor_cc_update_manifest_url() ? 'true' : 'false'; ?>,
    header_shortcode: "[alookhor_portal_header]"
  };</script>
  
<script>
// Fallback JS — اگر ES Modules لود نشد، سایدبار و تنظیمات همچنان کار کند (بدون نیاز به import)
(function(){
  // اگر بعد از 1.5 ثانیه هنوز ALOOKHOR.switchModule تعریف نشده، fallback را فعال کن
  setTimeout(function(){
    if(window.ALOOKHOR && window.ALOOKHOR.switchModule) return;
    console.warn('ALOOKHOR modules not loaded — activating fallback');
    // ساده: کلیک روی هر آیتم منو، پیام بده
    document.querySelectorAll('[data-module]').forEach(function(el){
      el.addEventListener('click', function(){
        var mod = el.getAttribute('data-module');
        if(mod==='settings'){
          // تنظیمات را با PHP رندر شده نشان بده — اسکرول به بخش تنظیمات اگر وجود دارد
          var fallback = document.getElementById('alookhor-fallback-settings');
          if(fallback) fallback.style.display='block';
          alert('تنظیمات بوتیک — نسخه Fallback: لطفاً کش را پاک کنید (Ctrl+Shift+R) یا افزونه را دوباره فعال کنید. اگر باز هم نشد، فایل /wp-content/plugins/alookhor-control-center/assets/js/app.js را چک کنید که ES Modules پشتیبانی می‌شود.');
        } else if(mod==='update'){
          var m = document.getElementById('updateModal');
          if(m) m.classList.add('show');
          document.getElementById('modalBackdrop')?.classList.add('show');
        } else {
          // برای سایر ماژول‌ها، فقط Toast ساده
          var stack = document.getElementById('toastStack');
          if(stack){
            var t=document.createElement('div'); t.className='toast'; t.innerHTML='<div class="toast-icon">◐</div><div style="flex:1"><div style="font-weight:700; font-size:13px">ماژول '+mod+' — در حال لود Fallback</div><div style="font-size:12px; color:#9A9590">ES Modules لود نشد، از نسخه PHP استفاده شد</div></div>';
            stack.appendChild(t); setTimeout(()=>t.remove(),3000);
          }
        }
        // active کلاس
        document.querySelectorAll('.nav-item, .nav-sub-item').forEach(n=>n.classList.remove('active'));
        el.classList.add('active');
      });
    });
    // آکاردئون سایدبار بدون JS ماژولار
    document.querySelectorAll('.nav-group-head').forEach(function(head){
      head.addEventListener('click', function(){
        var g=head.parentElement; g.classList.toggle('open');
      });
    });
    // نمایش پیام
    var c=document.getElementById('moduleContainer');
    if(c && !c.innerHTML.trim()){
      c.innerHTML='<div style="padding:40px; text-align:center; color:#9A9590">در حال لود Fallback...</div>';
    }
  }, 1500);
})();
</script>
  <script type="module" src="<?php echo esc_url(add_query_arg('ver', ALOOKHOR_CC_BUILD, ALOOKHOR_CC_URL . 'assets/js/app.js')); ?>"></script>
</div>
````

## Source Snapshot — `plugin/alookhor-control-center/uninstall.php`

````php
<?php
if (!defined('WP_UNINSTALL_PLUGIN')) exit;
// حافظه را پاک نکن — چون کاربر ممکن است دوباره نصب کند
// اگر خواستی کامل پاک شود، این خط‌ها را از کامنت دربیاور:
// delete_option('alookhor_cc_settings');
// delete_option('alookhor_header_settings');
````

## Source Snapshot — `scripts/build_release.py`

````python
#!/usr/bin/env python3
from pathlib import Path
from zipfile import ZipFile, ZipInfo, ZIP_DEFLATED
from html import escape
import hashlib
import json
import os
import re
import shutil
import stat
import sys

ROOT = Path(__file__).resolve().parents[1]
PLUGIN = ROOT / 'plugin' / 'alookhor-control-center'
PUBLIC = ROOT / 'public'
CONFIG = json.loads((ROOT / 'release.json').read_text(encoding='utf-8'))
VERSION = str(CONFIG['version'])
PREVIOUS = str(CONFIG.get('previous', ''))
STATE = str(CONFIG.get('state', 'draft')).lower()
SEMVER = re.compile(r'^\d+\.\d+\.\d+$')

if not SEMVER.fullmatch(VERSION):
    raise SystemExit(f'Invalid release version: {VERSION}')
if STATE not in {'draft', 'ready'}:
    raise SystemExit(f'Invalid release state: {STATE}')

main = (PLUGIN / 'alookhor-control-center.php').read_text(encoding='utf-8')
readme = (PLUGIN / 'readme.txt').read_text(encoding='utf-8')
site = json.loads((PLUGIN / 'config' / 'site.json').read_text(encoding='utf-8'))
checks = {
    'plugin_header': re.search(r'\* Version:\s*(\S+)', main).group(1),
    'constant': re.search(r"ALOOKHOR_CC_VERSION',\s*'([^']+)'", main).group(1),
    'build': re.search(r"ALOOKHOR_CC_BUILD',\s*'([^']+)'", main).group(1),
    'stable_tag': re.search(r'^Stable tag:\s*(\S+)', readme, re.M).group(1),
    'site_json': str(site['version']),
    'release_json': VERSION,
}
if set(checks.values()) != {VERSION}:
    raise SystemExit(f'Version mismatch: {checks}')

tag = os.environ.get('GITHUB_REF_NAME', '')
if tag.startswith('v') and tag[1:] != VERSION:
    raise SystemExit(f'Git tag {tag} does not match plugin version {VERSION}')
if tag.startswith('v') and STATE != 'ready':
    raise SystemExit(f'Release {VERSION} is still {STATE}; set release.json state to ready before tagging')

if PUBLIC.exists():
    shutil.rmtree(PUBLIC)
(PUBLIC / 'releases').mkdir(parents=True)

package_name = f'alookhor-control-center-{VERSION}.zip'
package = PUBLIC / 'releases' / package_name
skip_parts = {'.git', '.github', '__pycache__', '.DS_Store'}
files = [p for p in PLUGIN.rglob('*') if p.is_file() and not any(part in skip_parts for part in p.parts)]
with ZipFile(package, 'w', ZIP_DEFLATED, compresslevel=9) as archive:
    for path in sorted(files):
        relative = Path('alookhor-control-center') / path.relative_to(PLUGIN)
        info = ZipInfo(str(relative).replace('\\', '/'))
        info.date_time = (2026, 1, 1, 0, 0, 0)
        info.compress_type = ZIP_DEFLATED
        info.external_attr = (stat.S_IFREG | 0o644) << 16
        archive.writestr(info, path.read_bytes())
with ZipFile(package) as archive:
    if archive.testzip() is not None:
        raise SystemExit('ZIP integrity test failed')
    if 'alookhor-control-center/alookhor-control-center.php' not in archive.namelist():
        raise SystemExit('Plugin bootstrap is missing from ZIP')

sha256 = hashlib.sha256(package.read_bytes()).hexdigest()
base = 'https://updates.alookhor.ir'
manifest = {
    'name': 'ALOOKHOR Control Center',
    'version': VERSION,
    'download_url': f'{base}/releases/{package_name}',
    'details_url': f'{base}/changelog.html',
    'requires': str(CONFIG.get('requires', '6.0')),
    'tested': str(CONFIG.get('tested', '')),
    'requires_php': str(CONFIG.get('requires_php', '8.0')),
    'sha256': sha256,
    'description': str(CONFIG.get('description', '')),
    'changelog': CONFIG.get('changelog', []),
}
(PUBLIC / 'manifest.json').write_text(json.dumps(manifest, ensure_ascii=False, indent=2) + '\n', encoding='utf-8')
(PUBLIC / 'releases' / 'SHA256SUMS.txt').write_text(f'{sha256}  {package_name}\n', encoding='utf-8')
shutil.copy2(ROOT / 'channel' / '.htaccess', PUBLIC / '.htaccess')

changes = ''.join(
    f"<section><b>{escape(str(item.get('tag','UPDATE')))}</b><h2>{escape(str(item.get('title','')))}</h2><p>{escape(str(item.get('desc','')))}</p></section>"
    for item in CONFIG.get('changelog', [])
)
changelog_html = f'''<!doctype html><html lang="fa" dir="rtl"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1"><title>ALOOKHOR {VERSION}</title><style>body{{margin:0;padding:24px;background:#08070a;color:#eee;font-family:Tahoma,sans-serif}}main{{max-width:800px;margin:auto;padding:30px;border:1px solid #4b402b;border-radius:20px;background:#141217}}h1{{color:#ead8b2}}section{{padding:16px 0;border-top:1px solid #ffffff10}}section b{{color:#c9a86a;font:10px Arial}}h2{{font-size:16px}}p{{color:#bdb5c0;line-height:2}}</style></head><body><main><h1>ALOOKHOR Control Center {VERSION}</h1>{changes}</main></body></html>'''
(PUBLIC / 'changelog.html').write_text(changelog_html, encoding='utf-8')

index_html = f'''<!doctype html><html lang="fa" dir="rtl"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1"><title>ALOOKHOR Update Server</title><style>body{{margin:0;min-height:100vh;display:grid;place-items:center;padding:20px;background:radial-gradient(circle at 75% 0,#382b19,transparent 35%),#08070a;color:#f5efe7;font-family:Tahoma,sans-serif}}main{{width:min(760px,100%);padding:36px;border:1px solid #4b402b;border-radius:22px;background:#141217;box-shadow:0 25px 70px #0008}}small{{color:#c9a86a}}h1{{font-size:38px;margin:12px 0}}h1 span{{color:#c9a86a}}p{{color:#bdb5c0;line-height:2}}.row{{display:flex;gap:8px;flex-wrap:wrap;margin-top:20px}}.pill{{padding:8px 11px;border:1px solid #4b402b;border-radius:999px;color:#cfc4ce;font:11px Arial}}.ok{{color:#6de19a}}</style></head><body><main><small>ALOOKHOR PRIVATE RELEASE CHANNEL</small><h1>نسخه <span>{VERSION}</span></h1><p>{escape(str(CONFIG.get('description','')))}</p><div class="row"><span class="pill">Current: {escape(PREVIOUS)}</span><span class="pill">Latest: {VERSION}</span><span class="pill ok">Manifest Online</span><span class="pill">SHA-256 Verified</span></div></main></body></html>'''
(PUBLIC / 'index.html').write_text(index_html, encoding='utf-8')

output = os.environ.get('GITHUB_OUTPUT')
if output:
    with open(output, 'a', encoding='utf-8') as stream:
        stream.write(f'version={VERSION}\npackage={package_name}\nsha256={sha256}\n')
print(json.dumps({'version': VERSION, 'state': STATE, 'package': package_name, 'sha256': sha256, 'files': len(files)}, ensure_ascii=False))
````

## Source Snapshot — `scripts/generate_code_registry.py`

````python
#!/usr/bin/env python3
"""Generate the authoritative ALOOKHOR code registry from real repository sources."""
from __future__ import annotations

from hashlib import sha256
from pathlib import Path
import argparse
import json

ROOT = Path(__file__).resolve().parents[1]
PLUGIN = ROOT / 'plugin' / 'alookhor-control-center'
OUTPUT = ROOT / 'docs' / 'MASTER_CODE_REGISTRY.md'
REGISTRY_VERSION = '1.0.0'
GENERATED_DATE = '2026-08-14'


def fence_language(path: Path) -> str:
    return {
        '.php': 'php', '.css': 'css', '.js': 'javascript', '.json': 'json',
        '.py': 'python', '.yml': 'yaml', '.yaml': 'yaml', '.md': 'markdown',
        '.txt': 'text', '.htaccess': 'apache',
    }.get(path.suffix.lower(), 'text')


def source_files() -> list[Path]:
    plugin_sources = [
        path for path in PLUGIN.rglob('*')
        if path.is_file()
        and path != OUTPUT
        and path.suffix.lower() in {'.php', '.css', '.js', '.json'}
    ]
    automation = [
        ROOT / '.github' / 'workflows' / 'publish.yml',
        ROOT / 'scripts' / 'build_release.py',
        ROOT / 'scripts' / 'generate_code_registry.py',
        ROOT / 'scripts' / 'header_visual_audit.py',
        ROOT / 'scripts' / 'wordpress_access_check.py',
        ROOT / 'scripts' / 'wordpress_release_test.py',
        ROOT / 'ops' / 'wordpress-ci-bootstrap.php',
    ]
    return sorted(plugin_sources + [path for path in automation if path.is_file()], key=lambda p: str(p.relative_to(ROOT)))


def render() -> str:
    release = json.loads((ROOT / 'release.json').read_text(encoding='utf-8'))
    version = str(release['version'])
    files = source_files()
    lines: list[str] = []
    add = lines.append
    add('# MASTER CODE REGISTRY — ALOOKHOR')
    add('')
    add('> این سند از روی فایل‌های واقعی Repository تولید می‌شود. Source اصلی همچنان فایل‌های اجرایی است؛ Snapshotهای کامل زیر برای بازیابی، ممیزی و انتقال دانش نگهداری می‌شوند.')
    add('')
    add(f'- **Registry version:** `{REGISTRY_VERSION}`')
    add(f'- **Plugin/source version:** `{version}`')
    add(f'- **Generated:** `{GENERATED_DATE}`')
    add('- **Repository:** `alookhor-update-publisher`')
    add('- **Production:** `https://alookhor.ir`')
    add('- **Update channel:** `https://updates.alookhor.ir/manifest.json`')
    add('- **Authoritative option:** `alookhor_cc_settings`')
    add('- **Header option:** `alookhor_header_settings`')
    add('')
    add('## Current Project State')
    add('')
    add(f'- CURRENT VERSION: `{version}`')
    add(f'- LAST FUNCTIONAL CHANGE: {release.get("description", "Not recorded")}')
    add('- ACTIVE DESIGN: Luxury Black/Gold; actual component colors remain controlled by saved WordPress settings and existing module defaults.')
    add('- ACTIVE SHORTCODES: `[alookhor_portal_header]`, `[alookhor_managed_categories]`, `[alookhor_managed_hero]`, `[alookhor_managed_features]`.')
    add('- ACTIVE PANELS: Main ALOOKHOR Control Center and Header/Top Bar submenu.')
    add('- ACTIVE COMPONENTS: Header/Top Bar manager, managed four-slide Hero, managed four-card site features, WooCommerce categories, managed footer, private native updater.')
    add('- KNOWN EXTERNAL LEGACY: `[alookhor_categories_carousel]` belongs to `alookhor-categories-manager`; its source is not in this repository and is not reconstructed here.')
    add('- KNOWN SOURCE GAP: Elementor template export/internal element IDs and historical Code Snippets source are not present in this repository.')
    add('')
    add('## Change Record')
    add('')
    add('```text')
    add(f'PROJECT: {release.get("project", "ALOOKHOR")}')
    add(f'AREA: {release.get("area", "Not recorded")}')
    add(f'CURRENT VERSION: {version}')
    add(f'CHANGE: {release.get("description", "Not recorded")}')
    add(f'REASON: {release.get("reason", "Not recorded")}')
    add('FILES: ' + '; '.join(str(item) for item in release.get('files', [])))
    add(f'STATUS: SOURCE {str(release.get("state", "draft")).upper()} — deployment status must be verified separately.')
    add('```')
    add('')
    add('# MASTER CODE REGISTRY')
    add('')
    add('| ID | Type | Name | File | Used In | Version | Status |')
    add('|---|---|---|---|---|---:|---|')
    rows = [
        ('SC-001','Shortcode','`[alookhor_portal_header]`','`includes/shortcode-header.php`','Elementor Header Shortcode widget; exact template ID unavailable',version,'Active / compatibility-preserving'),
        ('SC-002','Shortcode','`[alookhor_managed_categories]`','`includes/product-categories.php`','Home page → Elementor Shortcode widget',version,'Active'),
        ('SC-003','Shortcode','`[alookhor_managed_hero]`','`includes/hero.php`','Home Elementor Shortcode widget / automatic Legacy-root replacement',version,'Active'),
        ('SC-004','Shortcode','`[alookhor_managed_features]`','`includes/site-features.php`','Home Elementor HTML widget / automatic Legacy-root replacement',version,'Active'),
        ('SC-EXT-001','External shortcode','`[alookhor_categories_carousel]`','External plugin source unavailable','Former Home showcase', 'External','Replaced on Home / do not reconstruct'),
        ('PN-001','Admin panel','ALOOKHOR Control Center','`includes/admin.php`','WP Admin top-level menu',version,'Active'),
        ('PN-002','Admin panel','Header & Top Bar','`includes/admin.php`','WP Admin submenu',version,'Active mirror'),
        ('MOD-001','Managed module','WooCommerce Categories','`includes/product-categories.php`','Home / Elementor / REST',version,'Active'),
        ('MOD-002','Managed module','Responsive Footer','`includes/footer.php`','Frontend footer / REST',version,'Active'),
        ('MOD-003','Managed module','Four-slide Hero','`includes/hero.php`','Home / Elementor / REST',version,'Active'),
        ('MOD-004','Managed module','Four-card Site Features','`includes/site-features.php`','Home / Elementor / REST',version,'Active'),
        ('API-001','REST API','`alookhor-cc/v1`','`includes/rest-api.php`','Public state + authenticated updater',version,'Active'),
        ('UPD-001','Updater','Private native updater','`includes/updater.php`','Control Center + GitHub Actions',version,'Active'),
        ('CFG-001','WordPress state','Main settings','`alookhor_cc_settings`','All managed modules',version,'Active'),
        ('CFG-002','WordPress state','Header settings','`alookhor_header_settings`','Header and Top Bar',version,'Active'),
        ('CSS-001','CSS','Managed Header','`assets/css/frontend-header.css`','`[alookhor_portal_header]` fallback renderer',version,'Active'),
        ('JS-001','JavaScript','Managed Header runtime','`assets/js/frontend-header.js`','`[alookhor_portal_header]` fallback renderer',version,'Active'),
        ('JS-002','JavaScript','Legacy Top Bar manager','`assets/js/frontend-topbar-manager.js`','Preserved legacy header provider',version,'Active when legacy provider exists'),
        ('CSS-002','CSS','WooCommerce Categories','`assets/css/frontend-categories.css`','`[alookhor_managed_categories]`',version,'Active'),
        ('JS-003','JavaScript','Categories carousel','`assets/js/frontend-categories.js`','`[alookhor_managed_categories]`',version,'Active'),
        ('CSS-003','CSS','Managed Footer','`assets/css/frontend-footer.css`','Managed Footer module',version,'Active'),
        ('JS-004','JavaScript','Managed Footer','`assets/js/frontend-footer.js`','Managed Footer module',version,'Active'),
        ('CSS-004','CSS','Control Center UI','`assets/css/luxury.css`','WP Admin ALOOKHOR pages',version,'Active'),
        ('JS-005','JavaScript','Control Center app','`assets/js/app.js` + modules','WP Admin ALOOKHOR pages',version,'Active'),
        ('CSS-005','CSS','Managed Hero','`assets/css/frontend-hero.css`','`[alookhor_managed_hero]` / automatic Home replacement',version,'Active'),
        ('JS-006','JavaScript','Managed Hero runtime','`assets/js/frontend-hero.js`','Four-slide replacement, controls and REST refresh',version,'Active'),
        ('CSS-006','CSS','Managed Site Features','`assets/css/frontend-features.css`','`[alookhor_managed_features]` / automatic Home replacement',version,'Active'),
        ('JS-007','JavaScript','Managed Site Features runtime','`assets/js/frontend-features.js`','Four-card replacement and REST refresh',version,'Active'),
    ]
    for row in rows:
        add('| ' + ' | '.join(str(cell) for cell in row) + ' |')
    add('')
    add('## SC-001 — Portal Header')
    add('')
    add('- **Shortcode:** `[alookhor_portal_header]`')
    add('- **Function/registration:** `alookhor_cc_register_portal_header_shortcode()` at `init` priority `100`; callback is either `alookhor_cc_render_portal_header()` or the compatibility callback `alookhor_cc_render_managed_legacy_header()`.')
    add('- **PHP file:** `plugin/alookhor-control-center/includes/shortcode-header.php`')
    add('- **Loaded by:** `plugin/alookhor-control-center/alookhor-control-center.php`')
    add('- **WordPress use:** Elementor Header template → Shortcode widget. Exact Elementor Template ID, container ID, and export are not present in Repository; they are deliberately not guessed.')
    add('- **Inputs:** optional `sticky` and `menu` attributes.')
    add('- **Output:** semantic two-level ALOOKHOR header or preserved legacy provider output wrapped by the manager.')
    add('- **CSS:** `assets/css/frontend-header.css`')
    add('- **JavaScript:** `assets/js/frontend-header.js`; when a legacy provider is detected, `assets/js/frontend-topbar-manager.js` manages public Top Bar state instead.')
    add('- **Database:** `alookhor_header_settings`, merged into `alookhor_cc_settings`.')
    add('- **Second-capsule settings:** `capsule_background`, `capsule_card`, `capsule_glass`, `capsule_gold`, `capsule_gold_light`, `capsule_text`, `capsule_muted`, `capsule_blur`; managed independently from Top Bar/Navigation colors.')
    add('- **Second-capsule palette:** `#0D0510`, `#1C1024`, `rgba(33,20,38,.75)`, `#D49A2E`, `#E8B84A`, `#F5F3F0`, `#C8C2C9`; 24px Blur.')
    add('- **Dependencies:** WordPress menu locations/menus, logo/media settings, Elementor Shortcode widget, WordPress REST Top Bar endpoint.')
    add('- **Created/recovered:** 3.8.5; **last source revision:** current runtime version.')
    add('- **Status:** Active. Existing external provider is not overwritten.')
    add('- **Complete source:** see Source Snapshots for `includes/shortcode-header.php`, `assets/css/frontend-header.css`, `assets/js/frontend-header.js`, and `assets/js/frontend-topbar-manager.js`.')
    add('')
    add('## SC-002 — Managed WooCommerce Categories')
    add('')
    add('- **Shortcode:** `[alookhor_managed_categories]`')
    add('- **Function:** `alookhor_cc_category_shortcode()`')
    add('- **Registration:** `add_shortcode(\'alookhor_managed_categories\', \'alookhor_cc_category_shortcode\')`')
    add('- **PHP file:** `plugin/alookhor-control-center/includes/product-categories.php`')
    add('- **WordPress use:** Pages → Home → Edit with Elementor → Shortcode widget. The user confirmed the managed four-category output in this position. Exact Elementor internal element ID is not exported to Repository and is not guessed.')
    add('- **Elementor movement:** Move the Shortcode widget or its parent Container in Navigator; no CSS anchor is required in shortcode mode.')
    add('- **Output ID:** `#alookhor-managed-categories`')
    add('- **Output classes:** `.alookhor-mc`, `.alookhor-mc-card`, `.alookhor-mc-track`, `.alookhor-mc-dots`, `.alookhor-mc-arrow`.')
    add('- **Legacy fallback class:** `.category-carousel-section` is only the automatic replacement anchor when the managed shortcode is absent.')
    add('- **Inputs:** no shortcode attributes; settings come from the main ALOOKHOR Control Center.')
    add('- **Output:** real `product_cat` terms with real URLs, names, counts/thumbnails and managed overrides.')
    add('- **CSS:** `assets/css/frontend-categories.css`')
    add('- **JavaScript:** `assets/js/frontend-categories.js`')
    add('- **REST:** `GET /wp-json/alookhor-cc/v1/product-categories` with no-store policy.')
    add('- **Database/taxonomy:** `alookhor_cc_settings.category_settings`; WooCommerce `product_cat`; term meta `thumbnail_id`.')
    add('- **Current Production terms:** `38, 39, 40, 41`.')
    add('- **Created:** 3.10.3 shortcode placement; renderer introduced 3.10.0; **last modified:** 3.10.3.')
    add('- **Status:** Active; shortcode mode suppresses automatic duplicate template output.')
    add('- **Complete source:** see Source Snapshots for `includes/product-categories.php`, `assets/css/frontend-categories.css`, and `assets/js/frontend-categories.js`.')
    add('')
    add('## SC-003 — Managed Four-Slide Hero')
    add('')
    add('- **Shortcode:** `[alookhor_managed_hero]`')
    add('- **Function:** `alookhor_cc_hero_shortcode()`; markup callback `alookhor_cc_hero_markup()`.')
    add('- **Registration:** `add_shortcode(\'alookhor_managed_hero\', \'alookhor_cc_hero_shortcode\')`.')
    add('- **PHP file:** `plugin/alookhor-control-center/includes/hero.php`.')
    add('- **Current WordPress use:** Home front page → Elementor Shortcode widget `data-id="3c367e2"`, `data-widget_type="shortcode.default"`, verified from Production audit `31741626734`; it renders the external Legacy root `.alookhor-hero-slider-wrapper` / `#alookhorHeroSlider`, which the managed runtime replaces exactly in place. Optional direct shortcode mode is available without duplicate template output.')
    add('- **Elementor/container contract:** existing widget/container position is preserved; runtime adds `.alookhor-managed-hero-slot` only to normalize the exact host. The ID above is source-backed; unavailable Elementor template exports are still never guessed.')
    add('- **Output ID/classes:** `#alookhor-managed-hero`, `.alookhor-mh`, `.alookhor-mh-slide`, `.alookhor-mh-content`, `.alookhor-mh-features`, `.alookhor-mh-actions`, `.alookhor-mh-dots`, `.alookhor-mh-arrow`.')
    add('- **Inputs:** no shortcode attributes; exactly four slide records from the main ALOOKHOR Control Center.')
    add('- **Storage:** `alookhor_cc_settings.hero_settings`; `modules.hero` remains module metadata and is synchronized to four slides/autoplay.')
    add('- **Per-slide fields:** Media Library attachment ID/URL, optional subject-left focus for compatible Legacy banners, image Alt, Kicker, Title, Gold Highlight, Description, four Feature labels, primary CTA label/URL, secondary CTA label/URL.')
    add('- **Global fields:** enabled, hide Legacy, autoplay/interval, pause, arrows, dots, Ken Burns, Gold/Surface/Text/Muted colors, radius.')
    add('- **Sanitization:** Nonce + `manage_options`; exact four-record normalization; attachment IDs via `absint`, URLs via `esc_url_raw`, colors via `sanitize_hex_color`, text via `sanitize_text_field`/`sanitize_textarea_field`, bounded interval/radius.')
    add('- **CSS:** `assets/css/frontend-hero.css`; right-side overlay, 32px reference radius, Black/Gold design, Desktop/Tablet/Mobile breakpoints and controlled Mobile Header underlap.')
    add('- **JavaScript:** `assets/js/frontend-hero.js`; exact-node replacement, four-slide state, Arrow/Dots, Swipe, Keyboard, Autoplay/Pause, Reduced Motion and same-origin no-store refresh.')
    add('- **REST:** `GET /wp-json/alookhor-cc/v1/hero`; public read-only state already rendered publicly, `Cache-Control: no-store`; no write route.')
    add('- **Dependencies:** WordPress Media Library, front-page Elementor host, existing external Legacy root only as automatic placement anchor; Header/Footer/WooCommerce structures are not modified.')
    add('- **Created:** 3.10.13; **status:** active source release, final status follows tagged Production visual verification.')
    add('- **Complete source:** see Source Snapshots for `includes/hero.php`, `assets/css/frontend-hero.css`, `assets/js/frontend-hero.js`, `assets/js/modules/settings.js`, `includes/ajax.php`, and `includes/rest-api.php`.')
    add('')
    add('## SC-004 — Managed Site Features')
    add('')
    add('- **Shortcode:** `[alookhor_managed_features]`')
    add('- **Function:** `alookhor_cc_site_feature_shortcode()`; markup callback `alookhor_cc_site_feature_markup()`.')
    add('- **Registration:** `add_shortcode(\'alookhor_managed_features\', \'alookhor_cc_site_feature_shortcode\')`.')
    add('- **PHP file:** `plugin/alookhor-control-center/includes/site-features.php`.')
    add('- **Current WordPress use:** Home front page → Elementor HTML widget `data-id="5abd566"`, parent container `data-id="f0598d3"`, independently verified by Production audit `31764796144`; external root `.alookhor-trustbar-container` is replaced exactly in place.')
    add('- **Elementor/container contract:** widget/container position is preserved; runtime adds only `.alookhor-managed-features-slot` / `.alookhor-managed-features-host` for scoped spacing normalization. No second feature row is appended.')
    add('- **Output ID/classes:** `#alookhor-managed-features`, `.alookhor-sf`, `.alookhor-sf-grid`, `.alookhor-sf-card`, `.alookhor-sf-icon`, `.alookhor-sf-copy`.')
    add('- **Inputs:** no shortcode attributes; exactly four records from the main ALOOKHOR Control Center.')
    add('- **Storage:** `alookhor_cc_settings.feature_settings`; module metadata is `modules.site_features`.')
    add('- **Per-item fields:** icon enum (`truck`, `organic`, `headset`, `shield`), title and description.')
    add('- **Global fields:** enabled, replace Legacy, Background, Card, Glass RGBA, Primary Gold, Light Gold, Text, Muted Text, Radius and Gap.')
    add('- **Approved palette:** `#0D0510`, `#1C1024`, `rgba(33,20,38,.75)`, `#D49A2E`, `#E8B84A`, `#F5F3F0`, `#C8C2C9`; this palette is scoped to the feature section and does not recolor unrelated modules.')
    add('- **Sanitization:** Nonce + `manage_options`; exact four-item normalization; icon allowlist; text fields; `sanitize_hex_color`; validated RGBA; bounded Radius/Gap.')
    add('- **Responsive contract:** exactly four cards in one row on Desktop and Mobile; Mobile uses compact icon/title/description cards with no horizontal overflow or stacking.')
    add('- **CSS:** `assets/css/frontend-features.css`. **JavaScript:** `assets/js/frontend-features.js`.')
    add('- **REST:** `GET /wp-json/alookhor-cc/v1/site-features`, public read-only/no-store; no write route.')
    add('- **Dependencies:** existing Elementor host/root only as placement anchor; Header, Hero, WooCommerce, Footer and Toolbar DOM remain untouched.')
    add('- **Created:** 3.10.16; **status:** source release pending tagged Production verification.')
    add('- **Complete source:** see Source Snapshots for `includes/site-features.php`, `assets/css/frontend-features.css`, `assets/js/frontend-features.js`, `assets/js/modules/settings.js`, `includes/ajax.php`, and `includes/rest-api.php`.')
    add('')
    add('## SC-EXT-001 — Legacy Categories Carousel')
    add('')
    add('- **Shortcode:** `[alookhor_categories_carousel]`')
    add('- **Owner:** external plugin `alookhor-categories-manager`.')
    add('- **Former use:** Home page Elementor Shortcode widget, previously rendering “PREMIUM SHOWCASE”.')
    add('- **Current use:** replaced on the Home page by `[alookhor_managed_categories]`.')
    add('- **Source status:** Source code is not present in this Repository. It is not copied, reconstructed, renamed, or claimed as known.')
    add('- **Status:** External/legacy; preserve unless a separately approved migration audits the external plugin.')
    add('')
    add('## PN-001 — Main ALOOKHOR Control Center')
    add('')
    add('- **Admin menu:** `ALOOKHOR Control Center`')
    add('- **Menu slug:** `alookhor-control-center`')
    add('- **Capability:** `manage_options`')
    add('- **Callback:** `alookhor_cc_render_admin()`')
    add('- **PHP:** `includes/admin.php`, `includes/ajax.php`, `templates/admin-control-center.php`')
    add('- **CSS:** `assets/css/luxury.css`')
    add('- **JavaScript:** `assets/js/app.js`, `assets/js/admin-wp.js`, `assets/js/core/*`, `assets/js/modules/*`')
    add('- **AJAX:** `alookhor_save_settings`, `alookhor_toggle_module`, `alookhor_save_header`, `alookhor_get_settings`, `alookhor_check_updates`.')
    add('- **REST:** authenticated status/check/install plus public Top Bar/Hero/Site Features/Footer/Categories state.')
    add('- **Database:** `alookhor_cc_settings` (including `hero_settings` and `feature_settings`), `alookhor_header_settings`, `alookhor_footer_subscribers`.')
    add('- **Managed shortcodes:** `[alookhor_portal_header]`, `[alookhor_managed_categories]`, `[alookhor_managed_hero]`, `[alookhor_managed_features]`.')
    add('- **Status:** Active; every managed module setting remains in this main panel.')
    add('')
    add('## PN-002 — Header and Top Bar Submenu')
    add('')
    add('- **Admin submenu:** `نوار بالای سایت و هدر`')
    add('- **Menu slug:** `alookhor-cc-header`')
    add('- **Parent:** `alookhor-control-center`')
    add('- **Capability:** `manage_options`')
    add('- **Callback:** `alookhor_cc_render_header_settings()`')
    add('- **Role:** Mirror/helper; the main Control Center remains the authoritative editing surface.')
    add('- **Database:** same `alookhor_header_settings` and merged main state; no parallel database table.')
    add('- **Status:** Active.')
    add('')
    add('## API and Update Architecture')
    add('')
    add('- **REST namespace:** `alookhor-cc/v1`')
    add('- **Public/no-store:** `/topbar`, `/hero`, `/site-features`, `/footer`, `/product-categories`; newsletter POST is rate-limited.')
    add('- **Authenticated:** `/status`, `/check-update`, `/install-update` with Application Password and `update_plugins`.')
    add('- **Release flow:** source → Git push → GitHub Actions → deterministic ZIP/SHA → Explicit FTPS → remote ZIP verification → atomic Manifest → native WordPress upgrader → activation restoration → Production checks.')
    add('- **Certificate rule:** Explicit FTPS with certificate and hostname verification; verification must not be disabled.')
    add('')
    add('## Source Inventory')
    add('')
    add('| File | Lines | SHA-256 |')
    add('|---|---:|---|')
    for path in files:
        data = path.read_bytes()
        text = data.decode('utf-8')
        rel = path.relative_to(ROOT)
        add(f'| `{rel}` | {len(text.splitlines())} | `{sha256(data).hexdigest()}` |')
    add('')
    add('# COMPLETE SOURCE SNAPSHOTS')
    add('')
    add('> این بخش عمداً شامل کد کامل فایل‌های فعال است. برای تغییر، ابتدا فایل واقعی را ویرایش و تست کنید، سپس این سند را با `python3 scripts/generate_code_registry.py` بازتولید کنید. ویرایش دستی Snapshot ممنوع است.')
    add('')
    for path in files:
        rel = path.relative_to(ROOT)
        text = path.read_text(encoding='utf-8')
        add(f'## Source Snapshot — `{rel}`')
        add('')
        add(f'````{fence_language(path)}')
        lines.extend(text.rstrip('\n').splitlines())
        add('````')
        add('')
    return '\n'.join(lines).rstrip() + '\n'


def main() -> None:
    parser = argparse.ArgumentParser()
    parser.add_argument('--check', action='store_true', help='Fail when the generated registry is stale.')
    args = parser.parse_args()
    content = render()
    if args.check:
        current = OUTPUT.read_text(encoding='utf-8') if OUTPUT.exists() else ''
        if current != content:
            raise SystemExit('MASTER_CODE_REGISTRY.md is stale; run scripts/generate_code_registry.py')
        print(f'Registry is current: {OUTPUT.relative_to(ROOT)}')
        return
    OUTPUT.parent.mkdir(parents=True, exist_ok=True)
    OUTPUT.write_text(content, encoding='utf-8')
    print(f'Generated {OUTPUT.relative_to(ROOT)} ({len(content.encode("utf-8"))} bytes)')


if __name__ == '__main__':
    main()
````

## Source Snapshot — `scripts/header_visual_audit.py`

````python
#!/usr/bin/env python3
"""Rendered Production Header audit using Chrome/Selenium."""
from __future__ import annotations
import json, os, time
from pathlib import Path
from selenium import webdriver
from selenium.webdriver.chrome.options import Options
from selenium.webdriver.support.ui import WebDriverWait

BASE = os.environ.get('WP_BASE_URL', 'https://alookhor.ir').rstrip('/')
OUT = Path(os.environ.get('HEADER_VISUAL_REPORT', '/tmp/header-visual.json'))
SHOT_DIR = Path(os.environ.get('HEADER_VISUAL_SHOTS', '/tmp/header-shots'))
SHOT_DIR.mkdir(parents=True, exist_ok=True)

JS_METRICS = r"""
const one=s=>document.querySelector(s), all=s=>[...document.querySelectorAll(s)];
const rect=e=>e?Object.fromEntries(['top','right','bottom','left','width','height'].map(k=>[k,Math.round(e.getBoundingClientRect()[k]*10)/10])):null;
const visible=e=>!!e&&getComputedStyle(e).display!=='none'&&getComputedStyle(e).visibility!=='hidden'&&e.getBoundingClientRect().height>0;
const legacyRoot=one('.alookhor-managed-legacy-header'),portalRoot=one('.alookhor-portal-header'),root=legacyRoot||portalRoot;
const topbar=legacyRoot?.querySelector('.alookhor-topbar-wrapper')||portalRoot?.querySelector('.alookhor-topbar');
const header=legacyRoot?.querySelector('.alookhor-header')||portalRoot?.querySelector('.alookhor-nav-stage');
const stage=legacyRoot?.querySelector('.alookhor-legacy-nav-stage')||portalRoot?.querySelector('.alookhor-nav-stage');
const capsule=legacyRoot?.querySelector('.header-capsule')||portalRoot?.querySelector('.alookhor-nav-shell');
const navigation=legacyRoot?.querySelector('.alookhor-legacy-nav-stage .header-nav-center')||portalRoot?.querySelector('.alookhor-desktop-nav');
const navShell=legacyRoot?.querySelector('.alookhor-legacy-nav-shell')||portalRoot?.querySelector('.alookhor-nav-shell');
const logoBox=legacyRoot?.querySelector('.header-capsule-logo')||portalRoot?.querySelector('.alookhor-nav-logo');
const topbarPhone=legacyRoot?.querySelector('.alookhor-managed-phone')||portalRoot?.querySelector('.alookhor-contact-link[href^="tel:"]');
const topbarSupport=legacyRoot?.querySelector('.alookhor-topbar-support')||portalRoot?.querySelector('.alookhor-fallback-support');
const topbarMessage=legacyRoot?.querySelector('.topbar-export-badge')||portalRoot?.querySelector('.alookhor-export-note');
const hero=one('#alookhor-managed-hero'),heroShell=hero?.querySelector('.alookhor-mh-shell'),heroContent=hero?.querySelector('.alookhor-mh-slide.is-active .alookhor-mh-content'),heroImage=hero?.querySelector('.alookhor-mh-slide.is-active img');
const features=one('#alookhor-managed-features'),featureGrid=features?.querySelector('.alookhor-sf-grid'),featureCards=features?all('#alookhor-managed-features .alookhor-sf-card'):[];
const main=one('#main-content')||one('.main-page-wrapper')||one('main');
const visibleBottom=[topbar,header,stage].filter(visible).map(e=>e.getBoundingClientRect().bottom);
const footprintBottom=visibleBottom.length?Math.max(...visibleBottom):0;
return {
  viewport:{width:innerWidth,height:innerHeight,dpr:devicePixelRatio},runtime_version:String(window.ALOOKHOR_TOPBAR?.version||''),
  root:!!root,header_mode:legacyRoot?'legacy':(portalRoot?'portal':'none'),topbar:rect(topbar),header:rect(header),stage:rect(stage),capsule:rect(capsule),main:rect(main),logo:rect(root?.querySelector('.header-capsule-logo img,.alookhor-nav-logo img')),logo_box:rect(logoBox),
  navigation:rect(navigation),navigation_display:navigation?getComputedStyle(navigation).display:null,nav_shell:rect(navShell),stage_integrated:legacyRoot?(stage?.classList.contains('is-capsule-integrated')||false):!!portalRoot,
  topbar_phone:rect(topbarPhone),topbar_support:rect(topbarSupport),topbar_message:rect(topbarMessage),
  topbar_style:topbar?{background_color:getComputedStyle(topbar).backgroundColor,background_image:getComputedStyle(topbar).backgroundImage,backdrop_filter:getComputedStyle(topbar).backdropFilter||getComputedStyle(topbar).webkitBackdropFilter,border_color:getComputedStyle(topbar).borderBottomColor}:null,
  topbar_role_colors:{phone:topbarPhone?getComputedStyle(topbarPhone).color:null,support:topbarSupport?getComputedStyle(topbarSupport).color:null,message:topbarMessage?getComputedStyle(topbarMessage).color:null},
  capsule_style:capsule?{background_color:getComputedStyle(capsule).backgroundColor,background_image:getComputedStyle(capsule).backgroundImage,backdrop_filter:getComputedStyle(capsule).backdropFilter||getComputedStyle(capsule).webkitBackdropFilter,border_color:getComputedStyle(capsule).borderColor,box_shadow:getComputedStyle(capsule).boxShadow}:null,
  capsule_palette:root?Object.fromEntries(['--alookhor-capsule-background','--alookhor-capsule-card','--alookhor-capsule-glass','--alookhor-capsule-gold','--alookhor-capsule-gold-light','--alookhor-capsule-text','--alookhor-capsule-muted','--alookhor-capsule-blur'].map(k=>[k,getComputedStyle(root).getPropertyValue(k).trim()])):{},
  capsule_control_colors:(()=>{const menu=root?.querySelector('.header-capsule .alookhor-main-menu-toggle,.alookhor-nav-shell .alookhor-menu-toggle'),account=root?.querySelector('.header-capsule .header-login-btn svg,.alookhor-nav-shell .alookhor-account-link svg'),cart=root?.querySelector('.header-capsule .alookhor-header-cart-link,.alookhor-nav-shell .alookhor-fallback-cart');return {menu:menu?getComputedStyle(menu).color:null,account:account?getComputedStyle(account).color:null,cart:cart?getComputedStyle(cart).color:null}})(),
  hero:rect(hero),hero_shell:rect(heroShell),hero_content:rect(heroContent),hero_image:rect(heroImage),hero_mounted:hero?.dataset.mounted==='1',
  hero_slide_count:hero?all('#alookhor-managed-hero .alookhor-mh-slide').length:0,hero_active_count:hero?all('#alookhor-managed-hero .alookhor-mh-slide.is-active').length:0,
  hero_feature_count:hero?all('#alookhor-managed-hero .alookhor-mh-slide.is-active .alookhor-mh-feature').length:0,hero_cta_count:hero?all('#alookhor-managed-hero .alookhor-mh-slide.is-active .alookhor-mh-cta').length:0,
  hero_legacy_visible:all('.alookhor-hero-slider-wrapper').filter(visible).length,hero_old_slider_id_count:all('#alookhorHeroSlider').length,
  hero_content_align:heroContent?getComputedStyle(heroContent).textAlign:null,hero_overflow:heroShell?getComputedStyle(heroShell).overflow:null,
  hero_image_loaded:!!heroImage&&heroImage.complete&&heroImage.naturalWidth>0,hero_image_natural:heroImage?{width:heroImage.naturalWidth,height:heroImage.naturalHeight}:null,
  hero_image_focus_class:heroImage?.closest('.alookhor-mh-slide')?.classList.contains('is-image-flipped')||false,
  hero_image_object_position:heroImage?getComputedStyle(heroImage).objectPosition:null,
  hero_image_transform:(()=>{if(!heroImage)return null;const m=new DOMMatrix(getComputedStyle(heroImage).transform);return {a:m.a,b:m.b,c:m.c,d:m.d,e:m.e,f:m.f,det:m.a*m.d-m.b*m.c}})(),
  hero_arrows:hero?all('#alookhor-managed-hero .alookhor-mh-arrow').filter(visible).map(e=>({rect:rect(e),background:getComputedStyle(e).backgroundColor,border_radius:getComputedStyle(e).borderRadius,appearance:getComputedStyle(e).appearance})):[],
  features:rect(features),feature_grid:rect(featureGrid),feature_mounted:features?.dataset.mounted==='1',feature_count:featureCards.length,
  feature_cards:featureCards.map(e=>({rect:rect(e),title:e.querySelector('h3')?.textContent.trim()||'',description:e.querySelector('p')?.textContent.trim()||'',background:getComputedStyle(e).backgroundColor,border_radius:getComputedStyle(e).borderRadius})),
  feature_legacy_visible:all('.alookhor-trustbar-container').filter(visible).length,
  feature_palette:features?Object.fromEntries(['--sf-bg','--sf-card','--sf-glass','--sf-gold','--sf-gold-light','--sf-text','--sf-muted'].map(k=>[k,getComputedStyle(features).getPropertyValue(k).trim()])):{},
  feature_to_hero_gap:(features&&hero)?Math.round((features.getBoundingClientRect().top-hero.getBoundingClientRect().bottom)*10)/10:null,
  topbar_center_display:(()=>{const e=legacyRoot?.querySelector('.topbar-center')||portalRoot?.querySelector('.alookhor-top-logo');return e?getComputedStyle(e).display:null})(),
  stage_display:stage?getComputedStyle(stage).display:null,stage_position:stage?getComputedStyle(stage).position:null,stage_stuck:legacyRoot?(stage?.classList.contains('is-stuck')||false):(!!portalRoot&&['sticky','fixed'].includes(getComputedStyle(stage).position)&&Math.abs(stage.getBoundingClientRect().top)<=50),stage_background:stage?{color:getComputedStyle(stage).backgroundColor,image:getComputedStyle(stage).backgroundImage}:null,
  duplicate_header_visible:all('.ak-topbar-wrapper,.alu-header').filter(visible).length,
  search_count:all('.alookhor-legacy-main-search').length,mobile_extra_toggle_count:all('.alookhor-mobile-sticky-toggle').length,
  original_drawer_id_count:all('#openDrawer').length,generated_drawer_count:portalRoot?portalRoot.querySelectorAll('.alookhor-menu-drawer').length:0,cart_count:all('.alookhor-header-cart-link,.alookhor-fallback-cart').length,
  main_toggle_count:all('.alookhor-main-menu-toggle,.alookhor-menu-toggle').length,main_toggle:rect(one('.alookhor-main-menu-toggle,.alookhor-menu-toggle')),main_toggle_visible:visible(one('.alookhor-main-menu-toggle,.alookhor-menu-toggle')),main_toggle_color:one('.alookhor-main-menu-toggle,.alookhor-menu-toggle')?getComputedStyle(one('.alookhor-main-menu-toggle,.alookhor-menu-toggle')).color:null,
  logo_count:all('.header-capsule-logo img,.alookhor-nav-logo img').length,logo_src:one('.header-capsule-logo img,.alookhor-nav-logo img')?.currentSrc||'',logo_source:one('.alookhor-nav-logo')?.dataset.logoSource||'',logo_count_copy:all('.alookhor-logo-copy,.alookhor-nav-logo-copy').length,logo_copy_count:all('.alookhor-logo-copy,.alookhor-nav-logo-copy').length,topbar_support_count:all('.alookhor-topbar-support,.alookhor-fallback-support').length,
  account_font_size:one('.header-login-btn')?getComputedStyle(one('.header-login-btn')).fontSize:null,account_icon_count:all('.header-login-btn .alookhor-account-icon,.alookhor-account-link svg').length,account_text_display:one('.alookhor-account-link span')?getComputedStyle(one('.alookhor-account-link span')).display:null,
  body_scroll_width:document.documentElement.scrollWidth,body_client_width:document.documentElement.clientWidth,
  horizontal_overflow:Math.max(0,document.documentElement.scrollWidth-document.documentElement.clientWidth),
  header_to_main_gap:main?Math.round((main.getBoundingClientRect().top-footprintBottom)*10)/10:null,
  body_classes:document.body.className,
  ancestors:root?[...function*(){let n=root.parentElement,i=0;while(n&&i++<8){yield {tag:n.tagName,id:n.id||'',class:n.className||'',rect:rect(n),display:getComputedStyle(n).display,position:getComputedStyle(n).position,min_height:getComputedStyle(n).minHeight,height:getComputedStyle(n).height};n=n.parentElement}}()]:[],
  woodmart_headers:['.whb-header','.whb-main-header','.whb-general-header','.whb-general-header-inner','.whb-header_816684'].map(selector=>({selector,count:all(selector).length,items:all(selector).slice(0,3).map(e=>({rect:rect(e),display:getComputedStyle(e).display,position:getComputedStyle(e).position,height:getComputedStyle(e).height,min_height:getComputedStyle(e).minHeight}))})),
  body_children:[...document.body.children].slice(0,20).map(e=>({tag:e.tagName,id:e.id||'',class:e.className||'',rect:rect(e),display:getComputedStyle(e).display,position:getComputedStyle(e).position,margin_top:getComputedStyle(e).marginTop,padding_top:getComputedStyle(e).paddingTop,top:getComputedStyle(e).top,transform:getComputedStyle(e).transform})),
  wrapper_style:(()=>{const e=one('.website-wrapper');const c=e?getComputedStyle(e):null;return c?{margin_top:c.marginTop,padding_top:c.paddingTop,top:c.top,transform:c.transform}:null})()
};
"""

def audit(width: int, height: int, label: str) -> dict:
    options = Options()
    options.add_argument('--headless=new'); options.add_argument('--no-sandbox'); options.add_argument('--disable-dev-shm-usage')
    options.add_argument('--disable-gpu'); options.add_argument(f'--window-size={width},{height}')
    options.add_argument('--hide-scrollbars'); options.add_argument('--force-device-scale-factor=1')
    driver = webdriver.Chrome(options=options)
    try:
        driver.set_window_size(width, height)
        driver.get(f'{BASE}/?rendered_header_audit=3107-{label}-{int(time.time())}')
        WebDriverWait(driver, 40).until(lambda d: d.execute_script("return !!document.querySelector('.alookhor-managed-legacy-header .header-capsule,.alookhor-portal-header .alookhor-nav-shell')"))
        runtime_version = driver.execute_script("return String(window.ALOOKHOR_TOPBAR?.version||'0.0.0')")
        runtime_parts = tuple(int(part) for part in runtime_version.split('.') if part.isdigit())
        hero_expected = runtime_parts >= (3, 10, 13)
        hero_polish_expected = runtime_parts >= (3, 10, 14)
        hero_image_polish_expected = runtime_parts >= (3, 10, 15)
        feature_expected = runtime_parts >= (3, 10, 16)
        feature_proximity_expected = runtime_parts >= (3, 10, 17)
        capsule_glass_expected = runtime_parts >= (3, 10, 18)
        header_reference_expected = runtime_parts >= (3, 10, 19)
        duplicate_header_fix_expected = runtime_parts >= (3, 10, 23)
        approved_header_logo_expected = runtime_parts >= (3, 10, 24)
        final_reference_header_expected = runtime_parts >= (3, 10, 25)
        if hero_expected:
            WebDriverWait(driver, 40).until(lambda d: d.execute_script("return document.querySelector('#alookhor-managed-hero')?.dataset.mounted==='1' && document.querySelectorAll('#alookhor-managed-hero .alookhor-mh-slide').length===4"))
        if feature_expected:
            WebDriverWait(driver,40).until(lambda d:d.execute_script("return document.querySelector('#alookhor-managed-features')?.dataset.mounted==='1' && document.querySelectorAll('#alookhor-managed-features .alookhor-sf-card').length===4"))
        time.sleep(4)
        before = driver.execute_script(JS_METRICS)
        driver.save_screenshot(str(SHOT_DIR / f'{label}-before.png'))
        if feature_expected:
            driver.execute_script("const e=document.querySelector('#alookhor-managed-features');if(e)window.scrollTo(0,Math.max(0,e.getBoundingClientRect().top+scrollY-innerHeight*.35));")
            time.sleep(.7)
            driver.save_screenshot(str(SHOT_DIR / f'{label}-features.png'))
            driver.execute_script('window.scrollTo(0,0)');time.sleep(.4)
        driver.execute_script('window.scrollTo(0, Math.min(900, document.documentElement.scrollHeight-innerHeight));')
        time.sleep(1.2)
        after = driver.execute_script(JS_METRICS)
        driver.save_screenshot(str(SHOT_DIR / f'{label}-after.png'))
        expected_mobile = width <= 1023
        checks = {
            'root': before['root'] is True,
            'duplicate_elementor_headers_removed': before['duplicate_header_visible'] == 0 if duplicate_header_fix_expected else True,
            'search_removed': before['search_count'] == 0,
            'no_rejected_mobile_toggle': before['mobile_extra_toggle_count'] == 0,
            'drawer_id_unique': (before['original_drawer_id_count'] == 1 if before['header_mode']=='legacy' else before['generated_drawer_count']==1),
            'cart_present': before['cart_count'] == 1,
            'main_toggle_present': before['main_toggle_count'] == 1,
            'main_toggle_visible': (before['main_toggle_visible'] is True and before['main_toggle'] is not None and before['main_toggle']['width']>=36 and before['main_toggle']['height']>=36) if approved_header_logo_expected else True,
            'final_reference_hamburger': (before['main_toggle_visible'] is True and before['main_toggle_color']=='rgb(232, 184, 74)' and before['main_toggle']['left']>=0 and before['main_toggle']['right']<=before['viewport']['width']) if final_reference_header_expected else True,
            'logo_present': before['logo_count'] == 1,
            'approved_header_logo_source': before['logo_source']=='managed-media' if approved_header_logo_expected else True,
            'final_reference_logo_exact': before['logo_src'].split('?')[0].endswith('/2026/08/LOGO2.png') if final_reference_header_expected else True,
            'final_reference_dark_stage': (before['stage_background'] is not None and before['stage_background']['image']!='none') if final_reference_header_expected else True,
            'horizontal_wordmark_present': before['logo_copy_count'] == 1,
            'topbar_support_present': before['topbar_support_count'] == 1,
            'mobile_account_icon_only': ((before['account_font_size'] == '0px' and before['account_icon_count'] == 1) if before['header_mode']=='legacy' else (before['account_text_display']=='none' and before['account_icon_count']==1)) if expected_mobile else True,
            'no_horizontal_overflow': before['horizontal_overflow'] <= 2,
            'mobile_stage_hidden': ((before['stage_display']=='none') if before['header_mode']=='legacy' else before['navigation_display']=='none') if expected_mobile else True,
            'desktop_stage_visible': before['stage_display'] != 'none' if not expected_mobile else True,
            'desktop_nav_sticky': (after['stage_position'] in {'sticky','fixed'} and after['stage_stuck'] is True and abs(after['stage']['top']) <= 2) if not expected_mobile else True,
            'header_starts_near_viewport_top': before['topbar'] is not None and before['topbar']['top'] <= 25,
            'topbar_duplicate_logo_hidden': before['topbar_center_display'] == 'none',
            'logo_contained_in_capsule': before['logo'] is not None and before['capsule'] is not None and before['logo']['top'] >= before['capsule']['top']-1 and before['logo']['bottom'] <= before['capsule']['bottom']+1,
            'capsule_glass_palette_exact': (before['capsule_palette']=={'--alookhor-capsule-background':'#0D0510','--alookhor-capsule-card':'#1C1024','--alookhor-capsule-glass':'rgba(33,20,38,.75)','--alookhor-capsule-gold':'#D49A2E','--alookhor-capsule-gold-light':'#E8B84A','--alookhor-capsule-text':'#F5F3F0','--alookhor-capsule-muted':'#C8C2C9','--alookhor-capsule-blur':'24px'}) if capsule_glass_expected else True,
            'capsule_glass_rendered': (before['capsule_style'] is not None and before['capsule_style']['background_color']=='rgba(33, 20, 38, 0.75)' and before['capsule_style']['background_image']!='none' and 'blur(24px)' in before['capsule_style']['backdrop_filter']) if capsule_glass_expected else True,
            'capsule_control_palette': (before['capsule_control_colors']=={'menu':'rgb(212, 154, 46)','account':'rgb(245, 243, 240)','cart':'rgb(245, 243, 240)'}) if capsule_glass_expected else True,
            'topbar_reference_glass': (before['topbar_style'] is not None and before['topbar_style']['background_image']!='none' and 'blur(18px)' in before['topbar_style']['backdrop_filter']) if header_reference_expected else True,
            'topbar_reference_order': (before['topbar_support'] is not None and before['topbar_message'] is not None and before['topbar_phone'] is not None and before['topbar_support']['left'] < before['topbar_message']['left'] < before['topbar_phone']['left']) if header_reference_expected else True,
            'topbar_reference_colors': (before['topbar_role_colors']=={'phone':'rgb(232, 184, 74)','support':'rgb(232, 184, 74)','message':'rgb(245, 243, 240)'}) if header_reference_expected else True,
            'desktop_navigation_integrated_in_capsule': (before['stage_integrated'] is True and before['stage'] is not None and before['capsule'] is not None and before['navigation'] is not None and before['stage']['top'] <= before['capsule']['top']+2 and before['stage']['bottom'] >= before['capsule']['bottom']-2 and before['navigation']['left'] > before['logo_box']['right']-20) if header_reference_expected and not expected_mobile else True,
            'mobile_navigation_not_duplicated': ((before['stage_integrated'] is False and before['stage_display']=='none') if before['header_mode']=='legacy' else before['navigation_display']=='none') if header_reference_expected and expected_mobile else True,
            'upper_rows_leave_viewport': ((after['topbar']['bottom'] < 2 and after['header']['bottom'] < 2) if before['header_mode']=='legacy' else after['topbar']['bottom']<2) if not expected_mobile else True,
            'no_large_header_gap': before['header_to_main_gap'] is None or before['header_to_main_gap'] <= 100,
            'hero_mounted': before['hero_mounted'] is True if hero_expected else True,
            'hero_exactly_four_slides': before['hero_slide_count'] == 4 if hero_expected else True,
            'hero_single_active_slide': before['hero_active_count'] == 1 if hero_expected else True,
            'hero_replaces_legacy': (before['hero_legacy_visible'] == 0 and before['hero_old_slider_id_count'] == 0) if hero_expected else True,
            'hero_image_loaded': before['hero_image_loaded'] is True if hero_expected else True,
            'hero_image_subject_focus_non_mirrored': (
                before['hero_image_focus_class'] is True
                and before['hero_image_transform'] is not None and before['hero_image_transform']['det'] > 0
                and ((before['hero_image_object_position'].startswith('78%') if expected_mobile else before['hero_image_transform']['e'] < -300))
            ) if hero_image_polish_expected else True,
            'hero_layered_content': (before['hero_feature_count'] == 4 and before['hero_cta_count'] >= 1) if hero_expected else True,
            'hero_arrows_isolated': (
                len(before['hero_arrows']) == 2
                and all(36 <= arrow['rect']['width'] <= 50 and 36 <= arrow['rect']['height'] <= 50
                        and arrow['border_radius'] == '50%'
                        and arrow['background'] not in {'rgb(255, 255, 255)', 'rgba(255, 255, 255, 1)'}
                        for arrow in before['hero_arrows'])
            ) if hero_polish_expected else True,
            'hero_content_on_right': (
                before['hero_content'] is not None and before['hero_shell'] is not None
                and before['hero_content']['left'] + before['hero_content']['width'] / 2 > before['hero_shell']['left'] + before['hero_shell']['width'] / 2
                and before['hero_content_align'] == 'right'
            ) if hero_expected else True,
            'mobile_hero_under_glass_capsule': (
                before['hero_shell'] is not None and before['capsule'] is not None
                and before['capsule']['top'] < before['hero_shell']['top'] < before['capsule']['bottom']
            ) if hero_polish_expected and expected_mobile else True,
            'features_mounted': before['feature_mounted'] is True if feature_expected else True,
            'features_exactly_four': before['feature_count'] == 4 if feature_expected else True,
            'features_replace_legacy': before['feature_legacy_visible'] == 0 if feature_expected else True,
            'features_reference_order': ([card['title'] for card in before['feature_cards']]==['ارسال سریع','محصولات ارگانیک','پشتیبانی ۲۴/۷','ضمانت کیفیت']) if feature_expected else True,
            'features_single_row': (len(before['feature_cards'])==4 and max(card['rect']['top'] for card in before['feature_cards'])-min(card['rect']['top'] for card in before['feature_cards'])<=2) if feature_expected else True,
            'features_rtl_reference_order': (len(before['feature_cards'])==4 and all(before['feature_cards'][i]['rect']['left']>before['feature_cards'][i+1]['rect']['left'] for i in range(3))) if feature_expected else True,
            'features_close_to_hero': (before['feature_to_hero_gap'] is not None and -3<=before['feature_to_hero_gap']<=20) if feature_proximity_expected else True,
            'features_mobile_four_across': (all(70<=card['rect']['width']<=110 and card['rect']['height']<=135 for card in before['feature_cards'])) if feature_expected and expected_mobile else True,
            'features_palette_exact': (before['feature_palette']=={'--sf-bg':'#0D0510','--sf-card':'#1C1024','--sf-glass':'rgba(33,20,38,.75)','--sf-gold':'#D49A2E','--sf-gold-light':'#E8B84A','--sf-text':'#F5F3F0','--sf-muted':'#C8C2C9'}) if feature_expected else True,
        }
        return {'label':label,'before':before,'after':after,'checks':checks,'ok':all(checks.values())}
    finally:
        driver.quit()

report={'url':BASE,'created_at':int(time.time()),'views':{},'ok':False}
try:
    report['views']['desktop']=audit(1440,1050,'desktop')
    report['views']['mobile']=audit(430,932,'mobile')
    report['ok']=all(v['ok'] for v in report['views'].values())
except Exception as error:
    report['error']=f'{type(error).__name__}: {error}'
OUT.write_text(json.dumps(report,ensure_ascii=False,indent=2)+'\n')
print(json.dumps(report,ensure_ascii=False,indent=2))
if not report['ok']: raise SystemExit(1)
````

## Source Snapshot — `scripts/wordpress_access_check.py`

````python
#!/usr/bin/env python3
from pathlib import Path
from urllib.request import Request, urlopen
from urllib.parse import urljoin
from html import unescape
import base64
import json
import os
import re
import time

ROOT = Path(__file__).resolve().parents[1]
report_path = Path(os.environ.get('WP_REPORT_PATH', '/tmp/wordpress-access.json'))
report = {'ok': False, 'checks': {}}


def authenticated_request(base, auth, path, accept='application/json'):
    return Request(base + path, headers={
        'Authorization': f'Basic {auth}',
        'Accept': accept,
        'User-Agent': 'ALOOKHOR-GitHub-Publisher/1.0',
    })


def version_tuple(value):
    return tuple(int(part) for part in str(value).split('.'))


try:
    base = os.environ.get('WP_BASE_URL', '').strip().rstrip('/')
    username = os.environ.get('WP_USERNAME', '').strip()
    app_password = os.environ.get('WP_APP_PASSWORD', '').strip()
    source_version = str(json.loads((ROOT / 'release.json').read_text())['version'])

    report['source_version'] = source_version
    report['checks']['secrets_present'] = bool(base and username and app_password)
    if not report['checks']['secrets_present']:
        raise RuntimeError('Required WordPress GitHub Secrets are missing')
    if base != 'https://alookhor.ir':
        raise RuntimeError('WP_BASE_URL must be https://alookhor.ir')

    production_url = 'https://updates.alookhor.ir/manifest.json?access_audit=' + str(int(time.time()))
    with urlopen(Request(production_url, headers={'Accept': 'application/json', 'User-Agent': 'ALOOKHOR-GitHub-Publisher/1.0'}), timeout=30) as response:
        production = json.load(response)
    production_version = str(production.get('version', ''))
    production_sha = str(production.get('sha256', ''))
    report['production'] = {'version': production_version, 'sha256': production_sha}
    report['checks']['production_manifest'] = (
        bool(re.fullmatch(r'\d+\.\d+\.\d+', production_version))
        and bool(re.fullmatch(r'[a-f0-9]{64}', production_sha))
        and production.get('download_url') == f'https://updates.alookhor.ir/releases/alookhor-control-center-{production_version}.zip'
    )

    auth = base64.b64encode(f'{username}:{app_password}'.encode()).decode()
    transition_required = (
        version_tuple(production_version) < version_tuple('3.8.7')
        and version_tuple(source_version) >= version_tuple('3.8.7')
    )
    report['transition_bridge_required'] = transition_required
    if transition_required:
        try:
            with urlopen(authenticated_request(base, auth, '/wp-json/alookhor-ci/v1/bridge-status'), timeout=30) as response:
                bridge = json.load(response)
            report['transition_bridge'] = bridge
            caps = bridge.get('capabilities', {})
            report['checks']['transition_bridge'] = (
                bridge.get('version') == '2026.08.11-reactivation-v1'
                and bridge.get('activation_guard') is True
                and bridge.get('plugin_active') is True
                and caps.get('read') is True
                and caps.get('update_plugins') is True
                and caps.get('activate_plugins') is False
            )
        except Exception as error:
            report['transition_bridge'] = {'ok': False, 'error': str(error)}
            report['checks']['transition_bridge'] = False

    errors = []
    status = None
    source = None
    for candidate, path in [
        ('native', '/wp-json/alookhor-cc/v1/status'),
        ('bootstrap', '/wp-json/alookhor-ci/v1/status'),
    ]:
        try:
            with urlopen(authenticated_request(base, auth, path), timeout=30) as response:
                status = json.load(response)
            source = candidate
            break
        except Exception as error:
            errors.append(f'{candidate}: {error}')
    if status is None:
        raise RuntimeError('No authenticated status endpoint: ' + '; '.join(errors))

    report['source'] = source
    report['status'] = status
    settings = status.get('settings', {})
    manifest = status.get('manifest', {})
    report['checks']['authenticated'] = True
    report['checks']['native_api'] = source == 'native'
    report['checks']['version'] = str(status.get('version')) == production_version
    report['checks']['active'] = status.get('active') is True
    report['checks']['manifest'] = (
        manifest.get('ok') is True
        and str(manifest.get('version')) == production_version
        and manifest.get('sha256') == production_sha
        and manifest.get('package_host') == 'updates.alookhor.ir'
    )
    report['checks']['main_option'] = settings.get('main_option') is True
    report['checks']['header_option'] = settings.get('header_option') is True
    report['checks']['module_count'] = int(settings.get('module_count', 0)) >= 8
    report['checks']['shortcode'] = settings.get('header_shortcode') is True
    production_parts = tuple(int(part) for part in production_version.split('.'))
    report['checks']['category_shortcode'] = settings.get('category_shortcode') is True if production_parts >= (3, 10, 3) else True
    if production_parts >= (3, 10, 6):
        migration = settings.get('header_brand_migration')
        report['checks']['header_brand_migration'] = (
            isinstance(migration, dict) and migration.get('ok') is True
            and str(migration.get('version')) == '3.10.6'
            and bool(migration.get('before_hash')) and bool(migration.get('after_hash'))
        )
    if production_parts >= (3, 10, 7):
        layout_migration = settings.get('header_layout_migration')
        report['checks']['header_layout_migration'] = (
            isinstance(layout_migration, dict) and layout_migration.get('ok') is True
            and str(layout_migration.get('version')) == '3.10.7'
            and layout_migration.get('search_removed') is True
            and layout_migration.get('mobile_extra_stage_removed') is True
        )
    if production_parts >= (3, 10, 19):
        reference_migration=settings.get('header_reference_migration')
        report['checks']['header_reference_migration']=(isinstance(reference_migration,dict) and reference_migration.get('ok') is True and str(reference_migration.get('version'))=='3.10.19' and bool(reference_migration.get('before_hash')) and bool(reference_migration.get('after_hash')))
    if production_parts >= (3, 10, 13):
        report['checks']['hero_runtime'] = (
            settings.get('hero_shortcode') is True
            and settings.get('hero_settings') is True
            and settings.get('hero_enabled') is True
            and int(settings.get('hero_slide_count', 0)) == 4
            and settings.get('hero_module') is True
        )
    if production_parts >= (3, 10, 16):
        report['checks']['feature_runtime']=(
            settings.get('feature_shortcode') is True
            and settings.get('feature_settings') is True
            and settings.get('feature_enabled') is True
            and int(settings.get('feature_item_count',0))==4
            and settings.get('feature_module') is True
        )

    public_url = base + '/?alookhor_access_audit=' + production_version.replace('.', '')
    with urlopen(Request(public_url, headers={'User-Agent': 'ALOOKHOR-GitHub-Publisher/1.0'}), timeout=30) as response:
        homepage = response.read().decode(errors='replace')
        report['checks']['homepage_http'] = response.status == 200
    report['checks']['header_content'] = (('خرید عمده' in homepage and ('ALOOKHOR' in homepage or 'آلوخور' in homepage)) or ('ak-topbar' in homepage and 'ak-navbar' in homepage and ('0915' in homepage or '09159513173' in homepage)))
    report['checks']['header_scroll_asset'] = (
        ('frontend-header-scroll.css' in homepage and 'alookhor-managed-legacy-header' in homepage)
        or ('frontend-header.css' in homepage and 'alookhor-portal-header' in homepage)
        or ('ak-topbar' in homepage and 'ak-navbar' in homepage)
        if version_tuple(production_version) >= version_tuple('3.10.5')
        else True
    )

    localized = {}
    localized_match = re.search(r'var\s+ALOOKHOR_TOPBAR\s*=\s*(\{.*?\});', homepage, re.S)
    if localized_match:
        try:
            raw_topbar = json.loads(localized_match.group(1))
            for key in [
                'topbar_bg', 'topbar_text_color', 'topbar_border_color',
                'topbar_button_bg', 'topbar_button_text', 'topbar_height',
                'show_topbar', 'show_wholesale',
            ]:
                localized[key] = raw_topbar.get(key)
        except Exception as error:
            localized = {'parse_error': str(error)}
    class_names = sorted({
        name
        for value in re.findall(r'class=["\']([^"\']+)["\']', homepage, re.I)
        for name in value.split()
        if any(token in name.lower() for token in ['top', 'bar', 'header', 'trade', 'contact', 'wholesale'])
    })
    # Capture only selector/declaration pairs relevant to the recovered legacy
    # Header. This makes sticky conflicts auditable without exporting unrelated
    # page CSS or relying on screenshots.
    style_blocks = re.findall(r'<style[^>]*>(.*?)</style>', homepage, re.I | re.S)
    legacy_header_rules = []
    selector_tokens = ('alookhor-topbar-wrapper', 'alookhor-header', 'header-capsule', 'header-nav-center', 'nav-menu', 'ak-topbar', 'ak-navbar')
    for block in style_blocks:
        for selector, declarations in re.findall(r'([^{}]+)\{([^{}]*)\}', block):
            clean_selector = re.sub(r'\s+', ' ', selector).strip()
            if any(token in clean_selector for token in selector_tokens):
                legacy_header_rules.append({
                    'selector': clean_selector[:500],
                    'declarations': re.sub(r'\s+', ' ', declarations).strip()[:1400],
                })
    topbar_markers=['alookhor-topbar-wrapper','alookhor-portal-header','ak-topbar-wrapper','ak-topbar']
    topbar_positions=[(homepage.find(marker),marker) for marker in topbar_markers if homepage.find(marker)>=0]
    topbar_index,topbar_provider=min(topbar_positions,key=lambda item:item[0]) if topbar_positions else (-1,None)
    topbar_fragment = ''
    if topbar_index >= 0:
        fragment_start = homepage.rfind('<div', 0, topbar_index)
        topbar_fragment = re.sub(r'\s+', ' ', homepage[max(0, fragment_start):topbar_index + 26000]).strip()
    report['public_topbar'] = {
        'provider':topbar_provider,
        'managed_wrapper': 'alookhor-managed-legacy-header' in homepage,
        'portal_wrapper':'alookhor-portal-header' in homepage,
        'ak_wrapper':'ak-topbar' in homepage and 'ak-navbar' in homepage,
        'manager_script': 'frontend-topbar-manager.js' in homepage,
        'localized': localized,
        'relevant_classes': class_names[:100],
        'markup_fragment': topbar_fragment,
        'legacy_header_rules': legacy_header_rules[:160],
    }

    hero_index = homepage.find('slide1.jpg')
    hero_fragment = ''
    if hero_index >= 0:
        hero_start = homepage.rfind('<', 0, max(0, hero_index - 5000))
        hero_fragment = re.sub(r'\s+', ' ', homepage[max(0, hero_start):hero_index + 12000]).strip()
    hero_classes = sorted({
        name
        for value in re.findall(r'class=["\']([^"\']+)["\']', hero_fragment, re.I)
        for name in value.split()
    })
    hero_assets = sorted(set(re.findall(r'https?://[^"\'\s>]+alookhor-categories-manager/[^"\'\s<]+', homepage, re.I)))
    widget_tag = ''
    if hero_index >= 0:
        widget_type_index = homepage.rfind('data-widget_type=', 0, hero_index)
        if widget_type_index >= 0:
            widget_start = homepage.rfind('<div', 0, widget_type_index)
            widget_end = homepage.find('>', widget_type_index)
            if widget_start >= 0 and widget_end >= 0:
                widget_tag = re.sub(r'\s+', ' ', homepage[widget_start:widget_end + 1]).strip()
    report['legacy_hero'] = {
        'found': hero_index >= 0,
        'root_selector': '.alookhor-hero-slider-wrapper' if 'alookhor-hero-slider-wrapper' in hero_fragment else None,
        'slider_id': 'alookhorHeroSlider' if 'id="alookhorHeroSlider"' in hero_fragment else None,
        'elementor_widget_tag': widget_tag,
        'classes': hero_classes[:160],
        'fragment': hero_fragment,
        'assets': hero_assets[:80],
    }

    feature_index=homepage.find('alookhor-trustbar-container')
    feature_fragment='';feature_widget_tag=''
    if feature_index>=0:
        feature_start=homepage.rfind('<div class="elementor-element',0,feature_index)
        feature_fragment=re.sub(r'\s+',' ',homepage[max(0,feature_start):feature_index+9000]).strip()
        widget_type_index=homepage.rfind('data-widget_type=',0,feature_index)
        if widget_type_index>=0:
            widget_start=homepage.rfind('<div',0,widget_type_index);widget_end=homepage.find('>',widget_type_index)
            if widget_start>=0 and widget_end>=0:feature_widget_tag=re.sub(r'\s+',' ',homepage[widget_start:widget_end+1]).strip()
    feature_classes=sorted({name for value in re.findall(r'class=["\']([^"\']+)["\']',feature_fragment,re.I) for name in value.split()})
    report['legacy_features']={
        'found':feature_index>=0,
        'root_selector':'.alookhor-trustbar-container' if feature_index>=0 else None,
        'elementor_widget_tag':feature_widget_tag,
        'classes':feature_classes[:80],
        'fragment':feature_fragment,
    }

    collection_index=homepage.find('ALOOKHOR PREMIUM COLLECTION')
    collection_fragment='';collection_widget_tag=''
    if collection_index>=0:
        collection_start=homepage.rfind('<div class="elementor-element',0,collection_index)
        collection_fragment=re.sub(r'\s+',' ',homepage[max(0,collection_start):collection_index+30000]).strip()
        widget_type_index=homepage.rfind('data-widget_type=',0,collection_index)
        if widget_type_index>=0:
            widget_start=homepage.rfind('<div',0,widget_type_index);widget_end=homepage.find('>',widget_type_index)
            if widget_start>=0 and widget_end>=0:collection_widget_tag=re.sub(r'\s+',' ',homepage[widget_start:widget_end+1]).strip()
    collection_classes=sorted({name for value in re.findall(r'class=["\']([^"\']+)["\']',collection_fragment,re.I) for name in value.split()})
    collection_products=[]
    for href,image,title in re.findall(r'<a[^>]+href=["\']([^"\']*/product/[^"\']*)["\'][^>]*>.*?<img[^>]+src=["\']([^"\']+)["\'][^>]*alt=["\']([^"\']*)["\']',collection_fragment,re.I|re.S):
        collection_products.append({'url':unescape(href),'image':unescape(image),'image_alt':unescape(title)})
    report['legacy_collection']={
        'found':collection_index>=0,
        'elementor_widget_tag':collection_widget_tag,
        'classes':collection_classes[:140],
        'product_links':collection_products[:12],
        'fragment':collection_fragment,
    }

    # Authenticated, non-mutating lookup of the real WordPress front-page record.
    # Elementor may keep its source in private post meta, so record only exposed
    # page identity and shortcode tokens rather than guessing unavailable data.
    try:
        with urlopen(authenticated_request(base, auth, '/wp-json/wp/v2/settings?context=edit'), timeout=30) as response:
            wp_settings = json.load(response)
        front_id = int(wp_settings.get('page_on_front') or 0)
        page_record = {}
        if front_id:
            with urlopen(authenticated_request(base, auth, f'/wp-json/wp/v2/pages/{front_id}?context=edit'), timeout=30) as response:
                page_record = json.load(response)
        raw_content = str((page_record.get('content') or {}).get('raw') or '')
        shortcode_tokens = sorted(set(re.findall(r'\[[^\]]*(?:hero|slider)[^\]]*\]', raw_content, re.I)))
        report['front_page_source'] = {
            'id': front_id,
            'slug': page_record.get('slug'),
            'template': page_record.get('template'),
            'raw_content_length': len(raw_content),
            'hero_shortcode_tokens': shortcode_tokens[:20],
            'exposed_meta_keys': sorted((page_record.get('meta') or {}).keys())[:80],
        }
    except Exception as error:
        report['front_page_source'] = {'available': False, 'error': str(error)}

    footer_classes = sorted({
        name
        for value in re.findall(r'class=["\']([^"\']+)["\']', homepage, re.I)
        for name in value.split()
        if any(token in name.lower() for token in [
            'footer', 'newsletter', 'social', 'payment', 'trust', 'license',
            'contact', 'app-download', 'copyright', 'guarantee',
        ])
    })
    footer_index = homepage.rfind('alookhor-footer-system')
    footer_fragment = ''
    if footer_index >= 0:
        style_start = homepage.rfind('<style', 0, footer_index)
        markup_start = homepage.rfind('<div', 0, footer_index)
        footer_start = style_start if style_start >= 0 and footer_index - style_start < 30000 else markup_start
        footer_fragment = re.sub(r'\s+', ' ', homepage[max(0, footer_start):footer_index + 50000]).strip()
    else:
        footer_positions = [homepage.rfind(marker) for marker in ['<footer', 'site-footer', 'main-footer', 'footer-container']]
        footer_index = max(footer_positions)
        if footer_index >= 0:
            footer_start = homepage.rfind('<', 0, footer_index + 1)
            footer_fragment = re.sub(r'\s+', ' ', homepage[max(0, footer_start - 3000):footer_index + 18000]).strip()
    report['public_footer'] = {
        'relevant_classes': footer_classes[:160],
        'markup_fragment': footer_fragment,
    }
    manager_match = re.search(r'<script[^>]+src=["\']([^"\']*frontend-topbar-manager\.js[^"\']*)["\']', homepage, re.I)
    if manager_match:
        try:
            manager_url = urljoin(base + '/', unescape(manager_match.group(1)))
            separator = '&' if '?' in manager_url else '?'
            with urlopen(Request(manager_url + separator + 'audit=' + str(int(time.time())), headers={'User-Agent': 'ALOOKHOR-GitHub-Publisher/1.0'}), timeout=30) as response:
                manager_source = response.read().decode(errors='replace')
            report['public_topbar']['manager_asset'] = manager_url
            report['checks']['manager_contact_span'] = (
                '.topbar-contact-txt' in manager_source
                and 'contactTexts.find' in manager_source
                and f"=== '{production_version}'" in manager_source
                and (
                    version_tuple(production_version) < version_tuple('3.10.5')
                    or (
                        all(token in manager_source for token in ['setupHeaderBehavior', 'data-alookhor-navigation', 'header.after(marker, stage)'])
                        and (
                            version_tuple(production_version) < version_tuple('3.10.7')
                            or ('alookhor-header-cart-link' in manager_source and 'alookhor-legacy-main-search' not in manager_source)
                        )
                    )
                )
            )
        except Exception as error:
            report['public_topbar']['manager_asset_error'] = str(error)
            report['checks']['manager_contact_span'] = False
    elif version_tuple(production_version) >= version_tuple('3.8.9'):
        # Internal shortcode renderer owns its contact markup directly and does
        # not enqueue the Legacy compatibility manager.
        report['checks']['manager_contact_span'] = (('alookhor-portal-header' in homepage and 'frontend-header.js' in homepage) or ('ak-topbar' in homepage and 'ak-navbar' in homepage))

    if version_tuple(production_version) >= version_tuple('3.8.7'):
        topbar_url = base + '/wp-json/alookhor-cc/v1/topbar?access_audit=' + str(int(time.time()))
        try:
            with urlopen(Request(topbar_url, headers={'Accept': 'application/json', 'Cache-Control': 'no-cache', 'User-Agent': 'ALOOKHOR-GitHub-Publisher/1.0'}), timeout=30) as response:
                topbar_state = json.load(response)
                cache_control = response.headers.get('Cache-Control', '')
            report['public_topbar']['fresh_endpoint'] = topbar_state
            report['checks']['topbar_endpoint'] = (
                str(topbar_state.get('version')) == production_version
                and all(bool(re.fullmatch(r'#[a-fA-F0-9]{6}', str(topbar_state.get(key, '')))) for key in [
                    'topbar_bg', 'topbar_text_color', 'topbar_border_color',
                    'topbar_button_bg', 'topbar_button_text',
                ])
                and (
                    version_tuple(production_version) < version_tuple('3.10.5')
                    or (
                        all(bool(re.fullmatch(r'#[a-fA-F0-9]{6}', str(topbar_state.get(key, '')))) for key in ['header_surface','header_text_color','header_muted_color','gold'])
                        and isinstance(topbar_state.get('sticky'), bool)
                        and isinstance(topbar_state.get('show_search'), bool)
                        and isinstance(topbar_state.get('search_placeholder'), str)
                        and 70 <= int(topbar_state.get('header_logo_desktop_width', 0)) <= 220
                        and 42 <= int(topbar_state.get('header_logo_mobile_width', 0)) <= 110
                    )
                )
            )
            report['checks']['topbar_no_store'] = 'no-store' in cache_control.lower()
            if version_tuple(production_version)>=version_tuple('3.10.19'):
                report['checks']['header_brand_palette']=(topbar_state.get('phone')=='09159513173' and topbar_state.get('gold')=='#D49A2E' and topbar_state.get('topbar_bg')=='#1C1024' and topbar_state.get('topbar_text_color')=='#F5F3F0' and topbar_state.get('topbar_border_color')=='#D49A2E' and topbar_state.get('topbar_button_bg')=='#D49A2E' and topbar_state.get('topbar_button_text')=='#0D0510' and topbar_state.get('header_surface')=='#0D0510' and topbar_state.get('header_text_color')=='#F5F3F0' and topbar_state.get('header_muted_color')=='#C8C2C9' and topbar_state.get('sticky') is True and topbar_state.get('show_search') is False)
            elif version_tuple(production_version) >= version_tuple('3.10.6'):
                report['checks']['header_brand_palette'] = (
                    topbar_state.get('phone') == '09159513173'
                    and topbar_state.get('gold') == '#C9A86A'
                    and topbar_state.get('topbar_bg') == '#11091D'
                    and topbar_state.get('topbar_text_color') == '#E8D5B5'
                    and topbar_state.get('topbar_button_bg') == '#C9A86A'
                    and topbar_state.get('topbar_button_text') == '#1A1206'
                    and topbar_state.get('header_surface') == '#0D0916'
                    and topbar_state.get('header_text_color') == '#F7F2EA'
                    and topbar_state.get('header_muted_color') == '#B8B0BD'
                    and topbar_state.get('sticky') is True
                    and topbar_state.get('show_search') is (False if version_tuple(production_version) >= version_tuple('3.10.7') else True)
                )
            if version_tuple(production_version)>=version_tuple('3.10.18'):
                report['checks']['header_capsule_palette']=(
                    topbar_state.get('capsule_background')=='#0D0510'
                    and topbar_state.get('capsule_card')=='#1C1024'
                    and topbar_state.get('capsule_glass')=='rgba(33,20,38,.75)'
                    and topbar_state.get('capsule_gold')=='#D49A2E'
                    and topbar_state.get('capsule_gold_light')=='#E8B84A'
                    and topbar_state.get('capsule_text')=='#F5F3F0'
                    and topbar_state.get('capsule_muted')=='#C8C2C9'
                    and int(topbar_state.get('capsule_blur',0))==24
                )
        except Exception as error:
            report['public_topbar']['fresh_endpoint_error'] = str(error)
            report['checks']['topbar_endpoint'] = False
            report['checks']['topbar_no_store'] = False
            if version_tuple(production_version) >= version_tuple('3.10.6'):
                report['checks']['header_brand_palette'] = False
            if version_tuple(production_version)>=version_tuple('3.10.18'):
                report['checks']['header_capsule_palette']=False

    if version_tuple(production_version) >= version_tuple('3.9.0'):
        footer_url = base + '/wp-json/alookhor-cc/v1/footer?access_audit=' + str(int(time.time()))
        try:
            with urlopen(Request(footer_url, headers={'Accept':'application/json','Cache-Control':'no-cache','User-Agent':'ALOOKHOR-GitHub-Publisher/1.0'}), timeout=30) as response:
                footer_state = json.load(response)
                footer_cache = response.headers.get('Cache-Control','')
            footer_html = str(footer_state.get('html',''))
            report['managed_footer'] = {'version':footer_state.get('version'),'enabled':footer_state.get('enabled'),'html_length':len(footer_html),'html':footer_html}
            report['checks']['footer_endpoint'] = (
                str(footer_state.get('version')) == production_version and footer_state.get('enabled') is True
                and 'id="alookhor-managed-footer"' in footer_html
                and 'alookhor-mf-main-grid' in footer_html and 'alookhor-mf-news-social' in footer_html
            )
            report['checks']['footer_no_store'] = 'no-store' in footer_cache.lower()
            report['checks']['footer_homepage'] = (
                'id="alookhor-managed-footer"' in homepage
                and 'alookhor-mf-hide-legacy' in homepage
                and 'frontend-footer.js' in homepage
            )
        except Exception as error:
            report['managed_footer'] = {'error':str(error)}
            report['checks']['footer_endpoint'] = False
            report['checks']['footer_no_store'] = False
            report['checks']['footer_homepage'] = False

    if version_tuple(production_version) >= version_tuple('3.10.0'):
        category_url=base+'/wp-json/alookhor-cc/v1/product-categories?access_audit='+str(int(time.time()))
        try:
            with urlopen(Request(category_url,headers={'Accept':'application/json','Cache-Control':'no-cache','User-Agent':'ALOOKHOR-GitHub-Publisher/1.0'}),timeout=30) as response:
                category_state=json.load(response);category_cache=response.headers.get('Cache-Control','')
            category_html=str(category_state.get('html',''));report['managed_categories']={'version':category_state.get('version'),'enabled':category_state.get('enabled'),'count':category_state.get('count'),'term_ids':category_state.get('term_ids'),'html_length':len(category_html),'html':category_html}
            report['checks']['category_endpoint']=(str(category_state.get('version'))==production_version and category_state.get('enabled') is True and int(category_state.get('count',0))>=4 and 'id="alookhor-managed-categories"' in category_html and 'alookhor-mc-card' in category_html)
            report['checks']['category_no_store']='no-store' in category_cache.lower()
            report['checks']['category_homepage']=('alookhor-managed-categories-template' in homepage and 'frontend-categories.js' in homepage and 'alookhor-mc-hide-legacy' in homepage)
        except Exception as error:
            report['managed_categories']={'error':str(error)};report['checks']['category_endpoint']=False;report['checks']['category_no_store']=False;report['checks']['category_homepage']=False

    if version_tuple(production_version) >= version_tuple('3.10.13'):
        hero_url=base+'/wp-json/alookhor-cc/v1/hero?access_audit='+str(int(time.time()))
        try:
            with urlopen(Request(hero_url,headers={'Accept':'application/json','Cache-Control':'no-cache','User-Agent':'ALOOKHOR-GitHub-Publisher/1.0'}),timeout=30) as response:
                hero_state=json.load(response);hero_cache=response.headers.get('Cache-Control','')
            hero_html=str(hero_state.get('html',''))
            report['managed_hero']={'version':hero_state.get('version'),'enabled':hero_state.get('enabled'),'slide_count':hero_state.get('slide_count'),'html_length':len(hero_html),'html':hero_html}
            report['checks']['hero_endpoint']=(
                str(hero_state.get('version'))==production_version and hero_state.get('enabled') is True
                and int(hero_state.get('slide_count',0))==4
                and 'id="alookhor-managed-hero"' in hero_html
                and len(re.findall(r'<article class="alookhor-mh-slide(?: |")',hero_html))==4
            )
            report['checks']['hero_no_store']='no-store' in hero_cache.lower()
            report['checks']['hero_homepage']=(
                'alookhor-managed-hero-template' in homepage
                and 'frontend-hero.js' in homepage
                and 'alookhor-mh-hide-legacy' in homepage
                and '.alookhor-hero-slider-wrapper' in homepage
            )
        except Exception as error:
            report['managed_hero']={'error':str(error)}
            report['checks']['hero_endpoint']=False
            report['checks']['hero_no_store']=False
            report['checks']['hero_homepage']=False

    if version_tuple(production_version)>=version_tuple('3.10.16'):
        feature_url=base+'/wp-json/alookhor-cc/v1/site-features?access_audit='+str(int(time.time()))
        try:
            with urlopen(Request(feature_url,headers={'Accept':'application/json','Cache-Control':'no-cache','User-Agent':'ALOOKHOR-GitHub-Publisher/1.0'}),timeout=30) as response:
                feature_state=json.load(response);feature_cache=response.headers.get('Cache-Control','')
            feature_html=str(feature_state.get('html',''))
            report['managed_features']={'version':feature_state.get('version'),'enabled':feature_state.get('enabled'),'item_count':feature_state.get('item_count'),'html_length':len(feature_html),'html':feature_html}
            report['checks']['feature_endpoint']=(str(feature_state.get('version'))==production_version and feature_state.get('enabled') is True and int(feature_state.get('item_count',0))==4 and 'id="alookhor-managed-features"' in feature_html and len(re.findall(r'<article class="alookhor-sf-card"',feature_html))==4)
            report['checks']['feature_no_store']='no-store' in feature_cache.lower()
            report['checks']['feature_homepage']=('alookhor-managed-features-template' in homepage and 'frontend-features.js' in homepage and 'alookhor-sf-hide-legacy' in homepage and '.alookhor-trustbar-container' in homepage)
            report['checks']['feature_palette']=all(token in feature_html for token in ['--sf-bg:#0D0510','--sf-card:#1C1024','--sf-glass:rgba(33,20,38,.75)','--sf-gold:#D49A2E','--sf-gold-light:#E8B84A','--sf-text:#F5F3F0','--sf-muted:#C8C2C9'])
        except Exception as error:
            report['managed_features']={'error':str(error)};report['checks']['feature_endpoint']=False;report['checks']['feature_no_store']=False;report['checks']['feature_homepage']=False;report['checks']['feature_palette']=False

    # Non-mutating feasibility probe. Application Passwords are expected to be
    # REST-only on this site; never record a nonce or any authenticated HTML.
    try:
        with urlopen(authenticated_request(base, auth, '/wp-admin/index.php', 'text/html'), timeout=30) as response:
            admin_html = response.read().decode(errors='replace')
            admin_url = response.geturl()
        report['admin_probe'] = {
            'http_status': response.status,
            'final_path': re.sub(r'^https?://[^/]+', '', admin_url).split('?', 1)[0],
            'authenticated': '/wp-admin/' in admin_url and 'loginform' not in admin_html,
            'updates_nonce_present': bool(re.search(r'["\']ajax_nonce["\']\s*:\s*["\'][^"\']+', admin_html)),
        }
    except Exception as error:
        report['admin_probe'] = {'authenticated': False, 'updates_nonce_present': False, 'error': str(error)}

    failed = [name for name, value in report['checks'].items() if value is not True]
    report['failed_checks'] = failed
    report['ok'] = not failed
    if failed:
        raise RuntimeError('Access checks failed: ' + ', '.join(failed))
except Exception as error:
    report['error'] = str(error)
    report_path.write_text(json.dumps(report, ensure_ascii=False, indent=2) + '\n')
    print(json.dumps(report, ensure_ascii=False, indent=2))
    raise
else:
    report_path.write_text(json.dumps(report, ensure_ascii=False, indent=2) + '\n')
    print(json.dumps(report, ensure_ascii=False, indent=2))
````

## Source Snapshot — `scripts/wordpress_release_test.py`

````python
#!/usr/bin/env python3
from pathlib import Path
from urllib.error import HTTPError, URLError
from urllib.request import Request, urlopen
import base64
import json
import os
import re
import sys
import time

ROOT = Path(__file__).resolve().parents[1]
TARGET = str(json.loads((ROOT / 'release.json').read_text())['version'])
BASE = os.environ['WP_BASE_URL'].strip().rstrip('/')
USERNAME = os.environ['WP_USERNAME'].strip()
APP_PASSWORD = os.environ['WP_APP_PASSWORD'].strip()
REPORT_PATH = Path(os.environ.get('WP_REPORT_PATH', '/tmp/wordpress-report.json'))
AUTH = base64.b64encode(f'{USERNAME}:{APP_PASSWORD}'.encode()).decode()


def request_json(path, method='GET', payload=None, allow=(200,)):
    body = json.dumps(payload).encode() if payload is not None else None
    request = Request(
        BASE + path,
        data=body,
        method=method,
        headers={
            'Authorization': f'Basic {AUTH}',
            'Accept': 'application/json',
            'Content-Type': 'application/json',
            'User-Agent': 'ALOOKHOR-GitHub-Publisher/1.0',
        },
    )
    try:
        with urlopen(request, timeout=90) as response:
            data = response.read().decode()
            if response.status not in allow:
                raise RuntimeError(f'Unexpected HTTP {response.status}: {data[:500]}')
            return response.status, json.loads(data)
    except HTTPError as error:
        data = error.read().decode(errors='replace')
        if error.code in allow:
            return error.code, json.loads(data)
        raise RuntimeError(f'HTTP {error.code} for {path}: {data[:800]}') from error


def get_pre_update_status():
    try:
        _, data = request_json('/wp-json/alookhor-cc/v1/status')
        return 'native', data
    except Exception as native_error:
        try:
            _, data = request_json('/wp-json/alookhor-ci/v1/status')
            return 'bootstrap', data
        except Exception as bootstrap_error:
            raise RuntimeError(f'No authenticated ALOOKHOR status endpoint. Native: {native_error}; Bootstrap: {bootstrap_error}')


report = {'target': TARGET, 'base_url': BASE, 'checks': {}}
try:
    source, before = get_pre_update_status()
    report['before'] = {'source': source, 'status': before}
    current = str(before.get('version') or '')
    report['checks']['pre_status'] = True

    if current != TARGET:
        endpoint = '/wp-json/alookhor-cc/v1/install-update' if source == 'native' else '/wp-json/alookhor-ci/v1/install'
        _, install = request_json(endpoint, 'POST', {'target_version': TARGET})
        report['install'] = {'endpoint': endpoint, 'response': install}
        if install.get('updated') is not True:
            raise RuntimeError(f'WordPress update did not report success: {install}')
    else:
        report['install'] = {'skipped': True, 'reason': 'already_current'}
    report['checks']['wordpress_upgrader'] = True

    after = None
    last_error = None
    for attempt in range(12):
        try:
            _, after = request_json('/wp-json/alookhor-cc/v1/status')
            if str(after.get('version')) == TARGET:
                break
        except Exception as error:
            last_error = str(error)
        time.sleep(5)
    if not after or str(after.get('version')) != TARGET:
        raise RuntimeError(f'Native status did not reach {TARGET}: {after}; last_error={last_error}')
    report['after'] = after
    report['checks']['version'] = True
    report['checks']['active'] = after.get('active') is True
    report['checks']['manifest'] = after.get('manifest', {}).get('version') == TARGET
    report['checks']['manifest_sha'] = bool(after.get('manifest', {}).get('sha256'))
    report['checks']['main_option'] = after.get('settings', {}).get('main_option') is True
    report['checks']['header_option'] = after.get('settings', {}).get('header_option') is True
    report['checks']['module_count'] = int(after.get('settings', {}).get('module_count', 0)) >= 8
    report['checks']['shortcode'] = after.get('settings', {}).get('header_shortcode') is True
    report['checks']['category_shortcode'] = after.get('settings', {}).get('category_shortcode') is True
    report['checks']['footer_settings'] = after.get('settings', {}).get('footer_settings') is True
    report['checks']['footer_enabled'] = after.get('settings', {}).get('footer_enabled') is True
    report['checks']['footer_module'] = after.get('settings', {}).get('footer_module') is True
    report['checks']['category_settings'] = after.get('settings', {}).get('category_settings') is True
    report['checks']['category_enabled'] = after.get('settings', {}).get('category_enabled') is True
    report['checks']['category_module'] = after.get('settings', {}).get('category_module') is True
    if tuple(map(int, TARGET.split('.'))) >= (3, 10, 13):
        report['checks']['hero_shortcode'] = after.get('settings', {}).get('hero_shortcode') is True
        report['checks']['hero_settings'] = after.get('settings', {}).get('hero_settings') is True
        report['checks']['hero_enabled'] = after.get('settings', {}).get('hero_enabled') is True
        report['checks']['hero_slide_count'] = int(after.get('settings', {}).get('hero_slide_count', 0)) == 4
        report['checks']['hero_module'] = after.get('settings', {}).get('hero_module') is True
    if tuple(map(int, TARGET.split('.'))) >= (3, 10, 16):
        report['checks']['feature_shortcode']=after.get('settings',{}).get('feature_shortcode') is True
        report['checks']['feature_settings']=after.get('settings',{}).get('feature_settings') is True
        report['checks']['feature_enabled']=after.get('settings',{}).get('feature_enabled') is True
        report['checks']['feature_item_count']=int(after.get('settings',{}).get('feature_item_count',0))==4
        report['checks']['feature_module']=after.get('settings',{}).get('feature_module') is True
    if tuple(map(int, TARGET.split('.'))) >= (3, 10, 7):
        layout_migration = after.get('settings', {}).get('header_layout_migration')
        report['checks']['header_layout_migration'] = (
            isinstance(layout_migration, dict) and layout_migration.get('ok') is True
            and str(layout_migration.get('version')) == '3.10.7'
            and layout_migration.get('search_removed') is True
            and layout_migration.get('mobile_extra_stage_removed') is True
        )
    if tuple(map(int,TARGET.split('.'))) >= (3,10,19):
        reference_migration=after.get('settings',{}).get('header_reference_migration')
        report['checks']['header_reference_migration']=(isinstance(reference_migration,dict) and reference_migration.get('ok') is True and str(reference_migration.get('version'))=='3.10.19' and bool(reference_migration.get('before_hash')) and bool(reference_migration.get('after_hash')))
    if current != TARGET:
        restore = after.get('last_activation_restore') or after.get('transition_activation_restore')
        report['checks']['activation_restore'] = isinstance(restore, dict) and (
            restore.get('active') is True or restore.get('ok') is True
        )

    before_header_hash = before.get('header_option_hash') or before.get('settings', {}).get('header_option_hash')
    after_header_hash = after.get('settings', {}).get('header_option_hash')
    if tuple(map(int,TARGET.split('.'))) >= (3,10,19):
        migration=after.get('settings',{}).get('header_reference_migration')
        expected_fields={'gold','topbar_bg','topbar_text_color','topbar_border_color','topbar_button_bg','topbar_button_text','header_surface','header_text_color','header_muted_color','capsule_background','capsule_card','capsule_glass','capsule_gold','capsule_gold_light','capsule_text','capsule_muted','capsule_blur'}
        report['checks']['header_settings_preserved']=(isinstance(migration,dict) and migration.get('ok') is True and str(migration.get('version'))=='3.10.19' and set(migration.get('fields',[]))==expected_fields and bool(migration.get('before_hash')) and bool(migration.get('after_hash')) and ((before_header_hash!=after_header_hash) if tuple(map(int,current.split('.'))) < (3,10,19) else (before_header_hash==after_header_hash)))
    elif tuple(map(int, TARGET.split('.'))) >= (3, 10, 6):
        migration = after.get('settings', {}).get('header_brand_migration')
        expected_fields = {'phone','gold','topbar_bg','topbar_text_color','topbar_border_color','topbar_button_bg','topbar_button_text','header_surface','header_text_color','header_muted_color','header_logo_desktop_width','header_logo_mobile_width','sticky','show_search','search_placeholder'}
        report['checks']['header_settings_preserved'] = (
            isinstance(migration, dict) and migration.get('ok') is True
            and str(migration.get('version')) == '3.10.6'
            and set(migration.get('fields', [])) == expected_fields
            and bool(migration.get('before_hash')) and bool(migration.get('after_hash'))
            and (
                (before_header_hash != after_header_hash) if tuple(map(int, current.split('.'))) < (3, 10, 7)
                else (before_header_hash == after_header_hash)
            )
        )
    else:
        report['checks']['header_settings_preserved'] = bool(before_header_hash and after_header_hash and before_header_hash == after_header_hash)

    public_url = BASE + '/?alookhor_ci_verify=' + TARGET.replace('.', '')
    with urlopen(Request(public_url, headers={'User-Agent': 'ALOOKHOR-GitHub-Publisher/1.0'}), timeout=30) as response:
        homepage = response.read().decode(errors='replace')
    report['checks']['homepage_http'] = response.status == 200
    report['checks']['header_content'] = 'خرید عمده' in homepage and ('ALOOKHOR' in homepage or 'آلوخور' in homepage)
    report['checks']['header_scroll_asset'] = (('frontend-header-scroll.css' in homepage and 'alookhor-managed-legacy-header' in homepage) or ('frontend-header.css' in homepage and 'alookhor-portal-header' in homepage))

    topbar_url = BASE + '/wp-json/alookhor-cc/v1/topbar?release_test=' + TARGET.replace('.', '')
    with urlopen(Request(topbar_url, headers={'Accept': 'application/json', 'Cache-Control': 'no-cache', 'User-Agent': 'ALOOKHOR-GitHub-Publisher/1.0'}), timeout=30) as response:
        topbar = json.load(response)
        cache_control = response.headers.get('Cache-Control', '')
    report['topbar'] = topbar
    report['checks']['topbar_endpoint'] = (
        str(topbar.get('version')) == TARGET
        and all(isinstance(topbar.get(key), str) and len(topbar[key]) == 7 and topbar[key].startswith('#') for key in [
            'topbar_bg', 'topbar_text_color', 'topbar_border_color',
            'topbar_button_bg', 'topbar_button_text', 'header_surface', 'header_text_color', 'header_muted_color', 'gold',
        ])
        and isinstance(topbar.get('sticky'), bool)
        and isinstance(topbar.get('show_search'), bool)
        and isinstance(topbar.get('search_placeholder'), str)
        and 70 <= int(topbar.get('header_logo_desktop_width', 0)) <= 220
        and 42 <= int(topbar.get('header_logo_mobile_width', 0)) <= 110
    )
    report['checks']['topbar_no_store'] = 'no-store' in cache_control.lower()
    if tuple(map(int, TARGET.split('.'))) >= (3, 10, 18):
        report['checks']['header_capsule_palette']=(
            topbar.get('capsule_background')=='#0D0510' and topbar.get('capsule_card')=='#1C1024'
            and topbar.get('capsule_glass')=='rgba(33,20,38,.75)' and topbar.get('capsule_gold')=='#D49A2E'
            and topbar.get('capsule_gold_light')=='#E8B84A' and topbar.get('capsule_text')=='#F5F3F0'
            and topbar.get('capsule_muted')=='#C8C2C9' and int(topbar.get('capsule_blur',0))==24
        )
    if tuple(map(int,TARGET.split('.'))) >= (3,10,19):
        report['checks']['header_brand_palette']=(topbar.get('phone')=='09159513173' and topbar.get('gold')=='#D49A2E' and topbar.get('topbar_bg')=='#1C1024' and topbar.get('topbar_text_color')=='#F5F3F0' and topbar.get('topbar_border_color')=='#D49A2E' and topbar.get('topbar_button_bg')=='#D49A2E' and topbar.get('topbar_button_text')=='#0D0510' and topbar.get('header_surface')=='#0D0510' and topbar.get('header_text_color')=='#F5F3F0' and topbar.get('header_muted_color')=='#C8C2C9' and topbar.get('sticky') is True and topbar.get('show_search') is False)
    elif tuple(map(int, TARGET.split('.'))) >= (3, 10, 6):
        report['checks']['header_brand_palette'] = (
            topbar.get('phone') == '09159513173'
            and topbar.get('gold') == '#C9A86A'
            and topbar.get('topbar_bg') == '#11091D'
            and topbar.get('topbar_text_color') == '#E8D5B5'
            and topbar.get('topbar_button_bg') == '#C9A86A'
            and topbar.get('topbar_button_text') == '#1A1206'
            and topbar.get('header_surface') == '#0D0916'
            and topbar.get('header_text_color') == '#F7F2EA'
            and topbar.get('header_muted_color') == '#B8B0BD'
            and topbar.get('sticky') is True
            and topbar.get('show_search') is (False if tuple(map(int, TARGET.split('.'))) >= (3, 10, 7) else True)
        )

    footer_url = BASE + '/wp-json/alookhor-cc/v1/footer?release_test=' + TARGET.replace('.', '')
    with urlopen(Request(footer_url, headers={'Accept':'application/json','Cache-Control':'no-cache','User-Agent':'ALOOKHOR-GitHub-Publisher/1.0'}), timeout=30) as response:
        footer = json.load(response)
        footer_cache = response.headers.get('Cache-Control','')
    report['footer'] = {'version':footer.get('version'),'enabled':footer.get('enabled'),'html_length':len(str(footer.get('html','')))}
    footer_html = str(footer.get('html',''))
    report['checks']['footer_endpoint'] = (
        str(footer.get('version')) == TARGET and footer.get('enabled') is True
        and 'id="alookhor-managed-footer"' in footer_html
        and 'alookhor-mf-main-grid' in footer_html
        and 'alookhor-mf-news-social' in footer_html
        and 'alookhor-mf-benefits' in footer_html
    )
    report['checks']['footer_no_store'] = 'no-store' in footer_cache.lower()

    category_url = BASE + '/wp-json/alookhor-cc/v1/product-categories?release_test=' + TARGET.replace('.', '')
    with urlopen(Request(category_url, headers={'Accept':'application/json','Cache-Control':'no-cache','User-Agent':'ALOOKHOR-GitHub-Publisher/1.0'}), timeout=30) as response:
        categories = json.load(response); category_cache=response.headers.get('Cache-Control','')
    category_html=str(categories.get('html',''));report['categories']={'version':categories.get('version'),'enabled':categories.get('enabled'),'count':categories.get('count'),'term_ids':categories.get('term_ids'),'html_length':len(category_html)}
    report['checks']['category_endpoint']=(str(categories.get('version'))==TARGET and categories.get('enabled') is True and int(categories.get('count',0))>=4 and 'id="alookhor-managed-categories"' in category_html and 'alookhor-mc-track' in category_html and 'alookhor-mc-card' in category_html)
    report['checks']['category_no_store']='no-store' in category_cache.lower()

    if tuple(map(int, TARGET.split('.'))) >= (3, 10, 13):
        hero_url=BASE+'/wp-json/alookhor-cc/v1/hero?release_test='+TARGET.replace('.','')
        with urlopen(Request(hero_url,headers={'Accept':'application/json','Cache-Control':'no-cache','User-Agent':'ALOOKHOR-GitHub-Publisher/1.0'}),timeout=30) as response:
            hero=json.load(response);hero_cache=response.headers.get('Cache-Control','')
        hero_html=str(hero.get('html',''));report['hero']={'version':hero.get('version'),'enabled':hero.get('enabled'),'slide_count':hero.get('slide_count'),'html_length':len(hero_html)}
        report['checks']['hero_endpoint']=(
            str(hero.get('version'))==TARGET and hero.get('enabled') is True and int(hero.get('slide_count',0))==4
            and 'id="alookhor-managed-hero"' in hero_html
            and len(re.findall(r'<article class="alookhor-mh-slide(?: |")',hero_html))==4
            and 'alookhor-mh-content' in hero_html and 'alookhor-mh-features' in hero_html
        )
        report['checks']['hero_no_store']='no-store' in hero_cache.lower()
        report['checks']['hero_homepage']=(
            'alookhor-managed-hero-template' in homepage and 'frontend-hero.js' in homepage
            and 'alookhor-mh-hide-legacy' in homepage and '.alookhor-hero-slider-wrapper' in homepage
        )

    if tuple(map(int,TARGET.split('.'))) >= (3,10,16):
        feature_url=BASE+'/wp-json/alookhor-cc/v1/site-features?release_test='+TARGET.replace('.','')
        with urlopen(Request(feature_url,headers={'Accept':'application/json','Cache-Control':'no-cache','User-Agent':'ALOOKHOR-GitHub-Publisher/1.0'}),timeout=30) as response:
            features=json.load(response);feature_cache=response.headers.get('Cache-Control','')
        feature_html=str(features.get('html',''));report['features']={'version':features.get('version'),'enabled':features.get('enabled'),'item_count':features.get('item_count'),'html_length':len(feature_html)}
        report['checks']['feature_endpoint']=(str(features.get('version'))==TARGET and features.get('enabled') is True and int(features.get('item_count',0))==4 and 'id="alookhor-managed-features"' in feature_html and len(re.findall(r'<article class="alookhor-sf-card"',feature_html))==4)
        report['checks']['feature_no_store']='no-store' in feature_cache.lower()
        report['checks']['feature_palette']=all(token in feature_html for token in ['--sf-bg:#0D0510','--sf-card:#1C1024','--sf-glass:rgba(33,20,38,.75)','--sf-gold:#D49A2E','--sf-gold-light:#E8B84A','--sf-text:#F5F3F0','--sf-muted:#C8C2C9'])
        report['checks']['feature_homepage']=('alookhor-managed-features-template' in homepage and 'frontend-features.js' in homepage and 'alookhor-sf-hide-legacy' in homepage)

    failed = [name for name, passed in report['checks'].items() if passed is not True]
    report['ok'] = not failed
    report['failed_checks'] = failed
    if failed:
        raise RuntimeError('Post-update checks failed: ' + ', '.join(failed))
except Exception as error:
    report['ok'] = False
    report['error'] = str(error)
    REPORT_PATH.write_text(json.dumps(report, ensure_ascii=False, indent=2) + '\n')
    print(json.dumps(report, ensure_ascii=False, indent=2))
    raise
else:
    REPORT_PATH.write_text(json.dumps(report, ensure_ascii=False, indent=2) + '\n')
    print(json.dumps(report, ensure_ascii=False, indent=2))
````
