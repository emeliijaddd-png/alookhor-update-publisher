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

- **Production runtime:** ALOOKHOR Control Center `3.10.4`
- **Current source target:** `3.10.5` — Navigation-only Sticky Header; pending tagged deployment and verification.
- **Last Production tag/source:** `v3.10.4` / `71c3f8483d56495c3ed2212498d26e835ecaa079`
- **Last published package SHA-256:** `8c8906e76e0fbed96dec51808a9b7be4cb61553e886b1ea1104465426d491dc3`
- **Deployment run:** `31713677974`
- **Independent audit run:** `31713982075`
- **Production:** active and verified
- **Repository:** `alookhor-update-publisher`
- **Update channel:** `https://updates.alookhor.ir/manifest.json`
- **Release pipeline:** Git push → GitHub Actions → deterministic ZIP/SHA → Explicit FTPS → remote verification → atomic Manifest → native WordPress updater → activation restoration → Production audit

## Active shortcodes

- `[alookhor_portal_header]` — managed/compatibility-preserving portal header.
- `[alookhor_managed_categories]` — real WooCommerce categories placed directly through an Elementor Shortcode widget.
- `[alookhor_categories_carousel]` — external legacy shortcode owned by `alookhor-categories-manager`; its source is not in this repository and must not be guessed. It was replaced on the Home page by the managed shortcode.

Full metadata and complete source snapshots are generated in `docs/MASTER_CODE_REGISTRY.md`.

## Active managed architecture

- Main ALOOKHOR Control Center (`manage_options`)
- Header/Top Bar helper submenu using the same authoritative options
- Preserved two-level professional header and WordPress menus
- Real WooCommerce product categories module
- Responsive managed footer
- Public no-store state endpoints
- Authenticated private updater and rollback-capable native WordPress installation
- Main option: `alookhor_cc_settings`
- Header option: `alookhor_header_settings`

## Current Header behavior contract

This rule supersedes every earlier interpretation of full-header Sticky behavior:

1. At page start, all three rows are visible in normal document flow: Top Bar, Main Header, and Primary Navigation.
2. Top Bar and Main Header must never remain fixed/sticky while scrolling down; they leave the viewport with the page.
3. The existing WordPress-driven `.header-nav-center` is moved intact—not rebuilt—into a dedicated Navigation stage immediately after the Main Header.
4. Only that Primary Navigation stage may use `position: sticky` and remain usable at the top of the viewport.
5. The sticky stage retains its normal-flow footprint and does not change height when stuck, preventing Layout Shift.
6. Scrolling back toward the page start naturally and smoothly returns the Main Header and Top Bar; at `scrollY=0` all rows are in their initial state.
7. Existing shortcode, menu nodes, Mega Menu, Drawer trigger, IDs, classes, and WordPress menu data are preserved.
8. Visual treatment uses current ALOOKHOR Black/Gold settings with restrained glass/blur only when Navigation is stuck.
9. Desktop and Mobile use the same transparent logo source; separate safe width controls are available in the main Boutique Header settings.
10. Rollback remains available through the existing `sticky` setting and versioned plugin release.

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
