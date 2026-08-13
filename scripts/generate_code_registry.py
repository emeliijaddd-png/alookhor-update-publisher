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
GENERATED_DATE = '2026-08-13'


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
    add('- ACTIVE SHORTCODES: `[alookhor_portal_header]`, `[alookhor_managed_categories]`.')
    add('- ACTIVE PANELS: Main ALOOKHOR Control Center and Header/Top Bar submenu.')
    add('- ACTIVE COMPONENTS: Header/Top Bar manager, WooCommerce categories, managed footer, private native updater.')
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
        ('SC-EXT-001','External shortcode','`[alookhor_categories_carousel]`','External plugin source unavailable','Former Home showcase', 'External','Replaced on Home / do not reconstruct'),
        ('PN-001','Admin panel','ALOOKHOR Control Center','`includes/admin.php`','WP Admin top-level menu',version,'Active'),
        ('PN-002','Admin panel','Header & Top Bar','`includes/admin.php`','WP Admin submenu',version,'Active mirror'),
        ('MOD-001','Managed module','WooCommerce Categories','`includes/product-categories.php`','Home / Elementor / REST',version,'Active'),
        ('MOD-002','Managed module','Responsive Footer','`includes/footer.php`','Frontend footer / REST',version,'Active'),
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
    add('- **REST:** authenticated status/check/install plus public Top Bar/Footer/Categories state.')
    add('- **Database:** `alookhor_cc_settings`, `alookhor_header_settings`, `alookhor_footer_subscribers`.')
    add('- **Managed shortcodes:** `[alookhor_portal_header]`, `[alookhor_managed_categories]`.')
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
    add('- **Public/no-store:** `/topbar`, `/footer`, `/product-categories`; newsletter POST is rate-limited.')
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
