# ALOOKHOR — MASTER PROJECT CONTEXT

## Protocol status

- **Loaded:** 2026-08-13
- **Project:** ALOOKHOR | آلوخور
- **Mode:** continuation of the existing project; never rebuild from zero unless the user explicitly says «از صفر بساز».
- **Primary rule:** inspect and preserve the newest real source before changing anything.

## Source-of-truth order

1. Real repository/project files
2. Git history and current branch
3. Latest verified Production deployment
4. WordPress runtime/database
5. Latest user-approved result
6. Project documentation
7. Conversation memory

When sources disagree, the newer provable runtime/source wins. Missing source is identified explicitly and is never reconstructed as if it were historical code.

## Authoritative current state

- **Production runtime:** ALOOKHOR Control Center `3.10.18`
- **Current Production tag/source:** `v3.10.18` / `5e7d33a4a90f33f0e79a63a9a0f3a6e26dcdee7f`
- **Published package SHA-256:** `28fe044652db8ec0d359c6521fd555599dd70d53eac2b0503f9b476f771f4021`
- **Deployment run:** `31820525729` — ZIP/SHA, Manifest, native WordPress and exact capsule palette endpoint checks all passed.
- **Final rendered Chrome audit:** `31820882559` on 3.10.18 — WordPress, Desktop and Mobile passed every Header/Hero/Site-Features check; no failed checks.
- **Direct glass-capsule acceptance:** the same `.header-capsule` now renders `rgba(33,20,38,.75)` with 24px Blur, Burgundy/Card gradient, Gold border/highlights and approved control colors; Cart/Account/Logo/Hamburger geometry/order, Top Bar, Desktop Navigation, Hero underlap and zero overflow are preserved.
- **Production:** 3.10.18 active and fully verified.
- **Current source target:** `3.10.52` — Luxury Burgundy/Gold image-accurate header + mega-menu glass (professional) prepared for test/publication; Production remains 3.10.18 until tagged deployment succeeds.
- **3.10.52 candidate package SHA-256:** `69c3b98d3d39c9636d3126cb48227e32792cd12edec0d039c352362b71251cfe` (rebuilt 2026-08-21 — luxury Burgundy/Gold image-accurate header + mega-menu glass (professional, image.png), superseding cef28f36 and 351e78e7 candidates)
- **New active Header reference:** `uploads/image.png`.
- **Final glass evidence:** `automation/318-live2/visual-desktop-before.png`, `automation/318-live2/visual-mobile-before.png`.
- **New Header reference:** `uploads/Screenshot_۲۰۲۶-۰۸-۱۴-۰۶-۵۶-۵۲-۵۸۲_com.android.chrome-edit.jpg`.
- **Final feature evidence:** `automation/317-live/visual-desktop-features.png`, `automation/317-live/visual-mobile-before.png`, `automation/317-live/visual-mobile-features.png`.
- **New feature references:** `uploads/Screenshot_۲۰۲۶-۰۸-۱۴-۰۵-۳۸-۵۰-۵۳۲_com.android.chrome-edit.jpg` (current stacked cards) and `uploads/Screenshot_۲۰۲۶-۰۸-۱۴-۰۵-۴۰-۳۶-۰۵۰_com.miui.gallery-edit.jpg` (target four-across composition).
- **Final screenshot evidence:** `automation/315-live/visual-desktop-before.png`, `automation/315-live/visual-mobile-before.png`; authoritative reference: `uploads/Screenshot_۲۰۲۶-۰۸-۱۳-۲۳-۲۹-۲۰-۳۰۷_com.miui.gallery-edit.jpg`.
- **Repository:** `alookhor-update-publisher`
- **Update channel:** `https://updates.alookhor.ir/manifest.json`
- **Release pipeline:** Git push → GitHub Actions → deterministic ZIP/SHA → Explicit FTPS → remote verification → atomic Manifest → native WordPress updater → activation restoration → Production audit

## Active shortcodes

- `[alookhor_portal_header]` — managed/compatibility-preserving portal header.
- `[alookhor_managed_categories]` — real WooCommerce categories placed directly through an Elementor Shortcode widget.
- `[alookhor_managed_hero]` — managed four-slide Hero; automatic Home migration replaces the exact Legacy root without requiring a second Elementor widget.
- `[alookhor_managed_features]` — managed four-card Site Features; automatic Home migration replaces the real Legacy Trust Bar in the same Elementor HTML widget.
- `[alookhor_categories_carousel]` — external legacy shortcode owned by `alookhor-categories-manager`; its source is not in this repository and must not be guessed. It was replaced on the Home page by the managed shortcode.

Full metadata and complete source snapshots are generated in `docs/MASTER_CODE_REGISTRY.md`.

## Active managed architecture

- Main ALOOKHOR Control Center (`manage_options`)
- Header/Top Bar helper submenu using the same authoritative options
- Preserved two-level professional header and WordPress menus
- Real WooCommerce product categories module
- Managed four-slide responsive Hero with Media Library images and separate right-side overlay content
- Managed four-card Site Features with owner-approved Burgundy/Gold palette
- Responsive managed footer
- Public no-store state endpoints
- Authenticated private updater and rollback-capable native WordPress installation
- Main option: `alookhor_cc_settings`
- Header option: `alookhor_header_settings`

## Current Header behavior contract

This rule supersedes every earlier interpretation of full-header Sticky behavior:

1. At page start, Desktop shows two visual rows matching `uploads/image.png`: Glass Top Bar and one wide Main Capsule containing Cart/Account, horizontal Logo, the real WordPress Primary Navigation and the original Hamburger.
2. Top Bar and Main Header must never remain fixed/sticky while scrolling down; they leave the viewport with the page.
3. On Desktop, the existing WordPress-driven `.header-nav-center` remains a single Node inside its dedicated Stage; the non-stuck Stage is visually integrated over the Main Capsule without cloning or static links.
4. When the integrated Navigation reaches the viewport top, only that same Stage becomes the verified fixed Sticky rail. Top Bar/Main Capsule continue leaving normally.
5. The integrated Stage has zero net normal-flow footprint (90px relative offset plus -90px margin) and keeps its Marker at zero when fixed, preventing Layout Shift or an empty third row.
6. Scrolling back toward the page start naturally and smoothly returns the Main Header and Top Bar; at `scrollY=0` all rows are in their initial state.
7. Existing shortcode, menu nodes, Mega Menu, Drawer trigger, IDs, classes, and WordPress menu data are preserved.
8. Top Bar and Main Capsule use the owner-approved Burgundy/Gold glass treatment; the Sticky rail uses the same managed Header palette with restrained Blur.
9. Desktop and Mobile use the same transparent logo source; separate safe width controls are available in the main Boutique Header settings.
10. Rollback remains available through the existing `sticky` setting and versioned plugin release.
11. The owner-approved Header reference palette is now explicit for Top Bar, Capsule and Sticky Navigation: `#0D0510`, `#1C1024`, `rgba(33,20,38,.75)`, `#D49A2E`, `#E8B84A`, `#F5F3F0`, `#C8C2C9`; migration `header_reference_31019` records this scoped change.
12. The authoritative shared Header/Footer contact phone is `09159513173`; any ending in 3174 or 3179 is a regression.
13. Mobile has exactly two visible rows: Top Bar and one Main Capsule. No extra sticky Navigation row is rendered at `≤1023px`.
14. The Main Capsule layout is: original simple Hamburger/Drawer trigger on the right, a large horizontal transparent logo composition (symbol + «آلوخور» wordmark) in the center, and icon-only Account plus real WooCommerce Cart/Badge on the left.
15. Product Search is explicitly rejected and must not be rendered in Desktop or Mobile Header, nor exposed as a Boutique setting.
16. When Woodmart's native Header is hidden, its reserved Body offset and the Home main-content top padding must be collapsed only on pages containing `.alookhor-managed-legacy-header`; the live Top Bar should begin within 25px of the viewport top.
17. Visual acceptance requires rendered Chrome audits at 1440×1050 and 430×932, unique Drawer ID, no horizontal overflow, contained logo, hidden duplicate Top Bar logo, hidden Mobile nav stage, and a pinned Desktop navigation rail.
18. The existing second `.header-capsule` has its own scoped glass palette: Main `#0D0510`, Card `#1C1024`, Glass `rgba(33,20,38,.75)`, Gold `#D49A2E`, Light Gold `#E8B84A`, Text `#F5F3F0`, Muted `#C8C2C9`, Blur 24px. Cart/Account/Logo/Hamburger Nodes remain unchanged.
19. Top Bar physical order follows the new reference: Support at left, shipping/export Message at center, Phone at right. Desktop capsule expands to 1360px, Logo shifts left and the real menu occupies the right section; Mobile remains two rows with no separate Navigation.
20. The deep purple glass override block was removed from `frontend-header.css` during 3.10.19 preparation (owner decision, 2026-08-21). The approved Burgundy/Gold palette is the single Header palette for both the legacy bridge and the fallback renderer. Enforced by the header palette guard in `scripts/build_release.py`, which runs in every push and tag job: approved tokens must be present and purple tokens absent.
21. Mega menu scope (owner-approved, 2026-08-21): legacy dropdown/mega-menu markup is never rebuilt or re-registered; it receives the approved luxury Burgundy glass (`rgba(28,16,36,.97)` → `rgba(13,5,16,.98)`, 22px blur, gold border, 3-column grid) through plugin-scoped CSS only, and its palette stays managed in the Boutique Header panel.
22. Luxury text alignment (2026-08-21, owner image.png): Top Bar message is now `ارسال رایگان به بیش از ۱۵ کشور جهان`, logo wordmark `آلوخور` + subtitle `پایتخت تولید آلو خشک ایران`, phone `09159513173`; enforced by migration `header_luxury_text_31019` (prio 123) and defaults in `site.json` + `alookhor-control-center.php`.
26. True Full-Width Fix (2026-08-21): desktop footer is now edge-to-edge 100vw (`shell width:100% max-width:none border-radius:0`) with 24px inner breathing room — truly full-width, not centered boxed.
25. Full-Width Footer (2026-08-21): `.alookhor-mf` is now `16px 24px` outer + `1360px/48px` inner shell (desktop) and `12px 12px` + `500px` centered mobile — breathing room, not edge-stuck; mobile is 2-col pro with pill cards, full-width contact, 72px toolbar respect — scoped, no overflow.
24. Owner Burgundy & Gold exact code (2026-08-21, owner HTML/CSS): header is now exactly `alookhor-header-wrapper` with `#3b0910/#270408` and `#d4af37` palette, 650px 3-col mega, sticky wrapper — owner code is single source, WordPress menu injected, legacy HTML hidden.
23. No-gap sticky capsule + image-exact mega-menu (2026-08-21, owner samples 2-3): empty top gap removed via `:has()` resets, main capsule is now `position:sticky` (admin-bar aware), mega-menu is 920px `220px promo + 3 columns` with injected luxury promo card (image + title + gold button) — pure CSS/JS, no markup rebuild. Top Bar message is now `ارسال رایگان به بیش از ۱۵ کشور جهان`, logo wordmark `آلوخور` + subtitle `پایتخت تولید آلو خشک ایران`, phone `09159513173`; enforced by migration `header_luxury_text_31019` (prio 123) and defaults in `site.json` + `alookhor-control-center.php`.

## Managed Hero contract

1. The source-backed Legacy root is `.alookhor-hero-slider-wrapper` / `#alookhorHeroSlider`, rendered by external `alookhor-categories-manager` inside Elementor Shortcode widget `data-id="3c367e2"` (`shortcode.default`), verified in Production audit `31741626734`.
2. Managed runtime replaces that exact root in place with `#alookhor-managed-hero`; it must never append a second Slider beside or below it.
3. Exactly four records are enforced under `alookhor_cc_settings.hero_settings.slides` and in REST/rendered output.
4. Every record supports WordPress Media Library attachment ID/URL, Alt, Kicker, white Title, Gold Highlight, Description, four Feature labels, and two CTA label/URL pairs.
5. Overlay writing remains separate from the image and is positioned on the right side.
6. Desktop/Mobile read the same WordPress state; CSS is responsive rather than maintaining a second Mobile data set.
7. Mobile Hero rises beneath the existing second glass Main Header capsule while the first Top Bar and all approved Header controls remain unchanged and above it.
8. Public `GET /wp-json/alookhor-cc/v1/hero` is read-only/no-store; cached Home HTML refreshes without exposing private settings or accepting writes.
9. Slider behavior includes Arrow/Dots, Swipe, Keyboard, Autoplay/Pause, Ken Burns, and Reduced Motion handling.
10. Acceptance requires Chrome Desktop/Mobile screenshots plus geometry for four slides, one active slide, loaded image, right-side content, Legacy replacement, no overflow, and Mobile underlap.

## Managed Site Features contract

1. The source-backed Legacy root is `.alookhor-trustbar-container` inside Elementor HTML widget `data-id="5abd566"`, parent container `data-id="f0598d3"`; independently reconfirmed in Production audit `31764796144`; current classes include `.trustbar-grid`, `.trust-card`, `.trust-card-icon`, `.trust-card-title`, and `.trust-card-desc`.
2. Managed runtime replaces that exact root in place with `#alookhor-managed-features`; it must never append a second trust/feature block.
3. Exactly four records are enforced under `alookhor_cc_settings.feature_settings.items`: ارسال سریع، محصولات ارگانیک، پشتیبانی ۲۴/۷، ضمانت کیفیت.
4. Desktop and Mobile must both show all four cards in one horizontal row; Mobile stacking and horizontal overflow are rejected.
5. The approved scoped palette is: Main `#0D0510`, Card `#1C1024`, Glass `rgba(33,20,38,.75)`, Gold `#D49A2E`, Light Gold `#E8B84A`, Text `#F5F3F0`, Muted `#C8C2C9`. This does not silently recolor Header, Hero, Footer or unrelated modules.
6. Icon enum, title, description, colors, Radius, Gap and enabled/replacement state remain inside the main ALOOKHOR Control Center.
7. Public `GET /wp-json/alookhor-cc/v1/site-features` is read-only/no-store; writes remain Nonce/capability-protected AJAX.
8. The strip attaches closely below Hero while preserving Header underlap, WooCommerce content, Footer and Woodmart Mobile toolbar.
9. Acceptance requires fresh 1440×1050 and 430×932 Chrome screenshots plus checks for four items, reference order, exact palette, Legacy removal, one-row geometry and no overflow.

## Current categories contract

- Production terms: `38, 39, 40, 41`
- Desktop: up to four simultaneous cards; arrows/dots are hidden when only one logical page exists.
- Mobile: 84% card, 8% symmetric Peek, 14px gap, 225px image, 18px radius.
- Mobile arrows: completely hidden and removed from keyboard/accessibility state.
- Mobile pagination: horizontal; active gold pill 33×10px and inactive gray circles 10×10px.
- Swipe, Drag, Autoplay, and infinite clone loop remain active.

## Brand/UI preservation

- Brand: ALOOKHOR / آلوخور
- Positioning: premium Iranian dried-fruit/export brand; «پایتخت آلوی ایران»
- Direction: Luxury, Premium, Export, Professional, Modern, Minimal, Elegant
- Core appearance: Black + Gold
- Brand reference supplied by user: `#D4AF37`
- **Do not automatically replace current component colors:** actual current modules use existing saved WordPress values and source defaults (including `#D4A436` and `#C9A86A`). Palette changes require an explicit scoped request and dependency review.
- Preserve the approved logo, Header, Footer, Elementor/Woodmart behavior, spacing, responsive rules, IDs, classes, functions, hooks, endpoints, and shortcodes unless the requested change requires otherwise.

## Mandatory change protocol

1. Recover current state.
2. Identify exact files, dependencies, shortcode/hook/class/ID, Desktop/Tablet/Mobile impact.
3. Change only the requested scope.
4. Run syntax, contract, responsive/runtime, and release-integrity tests.
5. Regenerate documentation with `python3 scripts/generate_code_registry.py`.
6. Enforce freshness with `python3 scripts/generate_code_registry.py --check`.
7. Record version impact. Do not bump the runtime version without a functional/release reason.
8. Commit logically.
9. Publish only through the established tagged pipeline when Production behavior changes.
10. Verify Production independently.

Process: **CODE → TEST → DOCUMENT → VERSION**.

## Security/deployment constraints

- Never request or expose passwords, API keys, tokens, private keys, FTP credentials, Application Passwords, or equivalent secrets in chat.
- Use GitHub Secrets/OAuth/Credential Manager.
- Explicit FTPS only, with certificate and hostname verification.
- Never disable TLS verification.
- Manifest replacement is the final publication step after remote ZIP/SHA verification.
- Never request manual ZIP upload, File Manager replacement, manual Manifest edits, or deletion/re-upload of the active plugin.

## Elementor rule

Every user action must identify the exact surface: Page/Template, Container, Widget, CSS Class, CSS ID, Custom CSS, HTML, or Shortcode. Unknown Elementor internal IDs/template exports are reported as unavailable rather than invented.

Current Legacy/managed Hero placement:

```text
WordPress → Pages → Home (front page) → Elementor Shortcode widget
Legacy root: .alookhor-hero-slider-wrapper
Legacy ID: #alookhorHeroSlider
Elementor widget: Shortcode (`data-id="3c367e2"`, `data-widget_type="shortcode.default"`) — verified from Production audit run 31741626734
Managed replacement: #alookhor-managed-hero
Optional managed shortcode: [alookhor_managed_hero]
Movement: retain the existing widget/container; automatic replacement preserves its position
```

Current Legacy/managed Site Features placement:

```text
WordPress → Pages → Home (front page) → Elementor HTML widget
Legacy root: .alookhor-trustbar-container
Elementor widget: HTML (`data-id="5abd566"`, `data-widget_type="html.default"`)
Parent container: `data-id="f0598d3"`
Managed replacement: #alookhor-managed-features
Optional managed shortcode: [alookhor_managed_features]
Movement: retain the existing widget/container; automatic replacement preserves its position
```

Current managed categories placement:

```text
WordPress → Pages → Home → Edit with Elementor
Widget: Shortcode
Shortcode: [alookhor_managed_categories]
Movement: drag the Shortcode widget or its parent Container in Navigator
```

## Known source gaps

- Exact Elementor Template export/internal element IDs are not stored in this repository.
- Historical Code Snippets source is not available in this repository.
- Full source of external plugin shortcode `[alookhor_categories_carousel]` is unavailable here.

These gaps must remain explicit until their real sources are exported or inspected. They must not be filled with guessed historical code.
