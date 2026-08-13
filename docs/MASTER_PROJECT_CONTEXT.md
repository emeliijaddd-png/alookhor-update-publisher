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

- **Runtime/plugin:** ALOOKHOR Control Center `3.10.3`
- **Tag/source:** `v3.10.3` / `a9c83f86c3bab177ca9bc29e7324efb885ad1bcd`
- **Published package SHA-256:** `8bbf920b818967a1c37bdd3d1ecb974b0b30489d429a0a9e8bcdb5d3a72fc2bf`
- **Deployment run:** `31709755816`
- **Independent audit run:** `31710030121`
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
