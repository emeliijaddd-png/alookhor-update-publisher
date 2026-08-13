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

- **Production runtime:** ALOOKHOR Control Center `3.10.14`
- **Current Production tag/source:** `v3.10.14` / `f4619e99349b49fdd3961f56099d6d6ced4fd188`
- **Published package SHA-256:** `71716cd46a199b785ead7463e686f9fa4590fb91a95ae4f84edb978aff277a36`
- **Deployment run:** `31743643662` — ZIP/SHA, Manifest and native WordPress checks all passed.
- **Latest rendered Chrome audit:** `31743997644` on 3.10.14 passed every encoded Desktop/Mobile check. Direct reference comparison confirmed Mobile underlap and circular arrows, but found remaining baked Legacy copy/badge artwork in the Desktop image.
- **Production:** 3.10.14 active; automated checks pass, direct visual acceptance is withheld for the Desktop image cleanup.
- **Current source target:** `3.10.15` — non-mirrored 36% Desktop subject focus plus bottom mask prepared for final test/publication.
- **3.10.15 candidate package SHA-256:** `eccc55fae826e7d09af75651b1944d156bb46e0802254c033ae54266a1eb9cd3`
- **Repository:** `alookhor-update-publisher`
- **Update channel:** `https://updates.alookhor.ir/manifest.json`
- **Release pipeline:** Git push → GitHub Actions → deterministic ZIP/SHA → Explicit FTPS → remote verification → atomic Manifest → native WordPress updater → activation restoration → Production audit

## Active shortcodes

- `[alookhor_portal_header]` — managed/compatibility-preserving portal header.
- `[alookhor_managed_categories]` — real WooCommerce categories placed directly through an Elementor Shortcode widget.
- `[alookhor_managed_hero]` — managed four-slide Hero; automatic Home migration replaces the exact Legacy root without requiring a second Elementor widget.
- `[alookhor_categories_carousel]` — external legacy shortcode owned by `alookhor-categories-manager`; its source is not in this repository and must not be guessed. It was replaced on the Home page by the managed shortcode.

Full metadata and complete source snapshots are generated in `docs/MASTER_CODE_REGISTRY.md`.

## Active managed architecture

- Main ALOOKHOR Control Center (`manage_options`)
- Header/Top Bar helper submenu using the same authoritative options
- Preserved two-level professional header and WordPress menus
- Real WooCommerce product categories module
- Managed four-slide responsive Hero with Media Library images and separate right-side overlay content
- Responsive managed footer
- Public no-store state endpoints
- Authenticated private updater and rollback-capable native WordPress installation
- Main option: `alookhor_cc_settings`
- Header option: `alookhor_header_settings`

## Current Header behavior contract

This rule supersedes every earlier interpretation of full-header Sticky behavior:

1. At page start, all three rows are visible in normal document flow: Top Bar, Main Header, and Primary Navigation.
2. Top Bar and Main Header must never remain fixed/sticky while scrolling down; they leave the viewport with the page.
3. On Desktop, the existing WordPress-driven `.header-nav-center` is moved intact—not rebuilt—into a dedicated Navigation stage immediately after the Main Header.
4. Only that Desktop Primary Navigation stage remains pinned at the top. Because the live Elementor container constrains native `position:sticky`, Production uses an equivalent fixed rail only after crossing its marker.
5. The zero-height marker expands to the exact Stage height while the rail is fixed, preserving the normal-flow footprint and preventing Layout Shift.
6. Scrolling back toward the page start naturally and smoothly returns the Main Header and Top Bar; at `scrollY=0` all rows are in their initial state.
7. Existing shortcode, menu nodes, Mega Menu, Drawer trigger, IDs, classes, and WordPress menu data are preserved.
8. Visual treatment uses current ALOOKHOR Black/Gold settings with restrained glass/blur only when Navigation is stuck.
9. Desktop and Mobile use the same transparent logo source; separate safe width controls are available in the main Boutique Header settings.
10. Rollback remains available through the existing `sticky` setting and versioned plugin release.
11. The approved Header palette is the site’s own Black/Gold state—not the orange/green colors in the structural reference: `#11091D`, `#0D0916`, `#C9A86A`, `#E8D5B5`, `#F7F2EA`, and `#B8B0BD`.
12. The authoritative shared Header/Footer contact phone is `09159513173`; any ending in 3174 or 3179 is a regression.
13. Mobile has exactly two visible rows: Top Bar and one Main Capsule. No extra sticky Navigation row is rendered at `≤1023px`.
14. The Main Capsule layout is: original simple Hamburger/Drawer trigger on the right, a large horizontal transparent logo composition (symbol + «آلوخور» wordmark) in the center, and icon-only Account plus real WooCommerce Cart/Badge on the left.
15. Product Search is explicitly rejected and must not be rendered in Desktop or Mobile Header, nor exposed as a Boutique setting.
16. When Woodmart's native Header is hidden, its reserved Body offset and the Home main-content top padding must be collapsed only on pages containing `.alookhor-managed-legacy-header`; the live Top Bar should begin within 25px of the viewport top.
17. Visual acceptance requires rendered Chrome audits at 1440×1050 and 430×932, unique Drawer ID, no horizontal overflow, contained logo, hidden duplicate Top Bar logo, hidden Mobile nav stage, and a pinned Desktop navigation rail.

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
