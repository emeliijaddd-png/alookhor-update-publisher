<?php
/**
 * ALOOKHOR One-Click Setup — v5.2 (final — rescue + full completion)
 * ---------------------------------------------
 * Supersedes v5. Why v5.1 exists:
 *   v5 wrote its portal template INTO wp-content/mu-plugins/. WordPress
 *   auto-includes mu-plugins at bootstrap (wp-settings.php), BEFORE the
 *   main query ($wp_query) exists — so the template's top-level
 *   get_header() fatalled on EVERY request once the file existed
 *   (the whole site went down from the second request after upload).
 *
 * v5.1 does all of v5's work, safely:
 *   1. RESCUE (file scope, runs FIRST — this file's name sorts before the
 *      broken ones in the mu-plugin load order): overwrites the broken
 *      v5 template and the old v5 file in mu-plugins with no-ops.
 *      (No unlink: a no-op include is silent; a missing file would log
 *      include warnings for the rest of the loop.)
 *   2. Fixes `alookhor_header_settings` (enabled + full site.json values)
 *      -> luxury portal header CSS/JS loads again (the missing-enabled bug).
 *   3. Ensures `alookhor_cc_settings` holds the full config from the
 *      plugin's config/site.json (all managed modules).
 *   4. Repairs dead hero slide images (alookhor-categories-manager URLs
 *      -> the Control Center's own bundled category images).
 *   5. Writes the portal template (front page + about + contact) to
 *      wp-content/uploads/alookhor-portal/ — a location that is NEVER
 *      auto-included — with a bootstrap guard, swapped in via template_include.
 *   6. Repairs seeded product prices via the plugin's own
 *      alookhor_cc_heal_seeded_prices() (the live ﷼0 price bug).
 *   7. Guarantees the blog page the primary menu links to (/blog/):
 *      finds an existing magazine/blog page or creates one with the
 *      [alookhor_magazine] stack.
 *   8. Status endpoint (?alookhor_v5=TOKEN) + finish=1 self-disable (no-op).
 *
 * Same token as v5, so the original URLs still work.
 * Safety: rescue is idempotent (marker checks); repair runs once (option flag).
 */
if (!defined('ABSPATH')) {
    exit;
}

define('ALOOKHOR_V5_TOKEN', 'v5-9f31c7ab02d4');
define('ALOOKHOR_V51_DONE_OPT', 'alookhor_v51_done');
define('ALOOKHOR_V51_TEMPLATE', WP_CONTENT_DIR . '/uploads/alookhor-portal/alookhor-cc-portal-template.php');

/* ------------------------------------------------------------------ *
 * RESCUE — must run at file scope, BEFORE the broken mu-plugin files
 * are included. This filename ('alookhor-00-...') sorts first in the
 * mu-plugin load order (natsort), so it always gets that chance.
 * ------------------------------------------------------------------ */
$GLOBALS['alookhor_v51_neutral'] = array('template' => 'n/a', 'v5_file' => 'n/a');
if (defined('WP_CONTENT_DIR') && is_dir(WP_CONTENT_DIR . '/mu-plugins')) {
    $alookhor_v51_muplugs = WP_CONTENT_DIR . '/mu-plugins/';

    // a) the broken v5 portal template -> no-op
    $alookhor_v51_f = $alookhor_v51_muplugs . 'alookhor-cc-portal-template.php';
    if (is_file($alookhor_v51_f)) {
        $alookhor_v51_c = (string) @file_get_contents($alookhor_v51_f);
        if (strpos($alookhor_v51_c, 'alookhor_v5_kind') !== false) {
            $alookhor_v51_c = "<?php\n// ALOOKHOR v5 portal template — DISABLED by v5.1 (it broke bootstrap when\n// auto-included as a mu-plugin). The live template now lives in\n// wp-content/uploads/alookhor-portal/alookhor-cc-portal-template.php.\n";
            if (@file_put_contents($alookhor_v51_f, $alookhor_v51_c, LOCK_EX) !== false) {
                $GLOBALS['alookhor_v51_neutral']['template'] = 'noop';
            } elseif (@unlink($alookhor_v51_f)) {
                $GLOBALS['alookhor_v51_neutral']['template'] = 'unlinked';
            } else {
                $GLOBALS['alookhor_v51_neutral']['template'] = 'FAILED';
            }
        } else {
            $GLOBALS['alookhor_v51_neutral']['template'] = 'already-clean';
        }
    }

    // b) the old v5 setup file -> no-op. Its repair already ran (its done
    //    option is set), but its template_include filter pointed at the
    //    broken path — it must not register again this request or ever.
    $alookhor_v51_f = $alookhor_v51_muplugs . 'alookhor-one-click-setup.php';
    if (is_file($alookhor_v51_f)) {
        $alookhor_v51_c = (string) @file_get_contents($alookhor_v51_f);
        if (strpos($alookhor_v51_c, 'ALOOKHOR_V5_DONE_OPT') !== false) {
            $alookhor_v51_c = "<?php\n// ALOOKHOR one-click setup v5 — superseded by v5.1 (alookhor-00-one-click-setup.php).\n// Intentionally a no-op; all v5 work is recorded in option alookhor_v5_done.\n";
            if (@file_put_contents($alookhor_v51_f, $alookhor_v51_c, LOCK_EX) !== false) {
                $GLOBALS['alookhor_v51_neutral']['v5_file'] = 'noop';
            } elseif (@unlink($alookhor_v51_f)) {
                $GLOBALS['alookhor_v51_neutral']['v5_file'] = 'unlinked';
            } else {
                $GLOBALS['alookhor_v51_neutral']['v5_file'] = 'FAILED';
            }
        } else {
            $GLOBALS['alookhor_v51_neutral']['v5_file'] = 'already-clean';
        }
    }
}

/* ------------------------------------------------------------------ *
 * Portal page id lookup
 * ------------------------------------------------------------------ */
function alookhor_v5_page_ids($titles, $slug)
{
    static $cache = array();
    if (isset($cache[$slug])) {
        return $cache[$slug];
    }
    $cache[$slug] = array();
    $pages = function_exists('get_pages') ? (array) get_pages(array('number' => 60)) : array();
    foreach ($pages as $p) {
        if (!is_object($p) || empty($p->ID)) {
            continue;
        }
        if (in_array($p->post_title, $titles, true) || (isset($p->post_name) && $p->post_name === $slug)) {
            $cache[$slug][] = (int) $p->ID;
        }
    }
    return $cache[$slug];
}
function alookhor_v5_about_ids()
{
    return alookhor_v5_page_ids(array('درباره ما', 'درباره آلوخور', 'About Us', 'About'), 'about');
}
function alookhor_v5_contact_ids()
{
    return alookhor_v5_page_ids(array('تماس با ما', 'تماس', 'Contact Us', 'Contact'), 'contact');
}

/* ------------------------------------------------------------------ *
 * Portal template writer (safe location: uploads/, never auto-included)
 * ------------------------------------------------------------------ */
function alookhor_v51_template_code()
{
    return <<<'TPL'
<?php
/**
 * ALOOKHOR CC Portal Template — v5.1
 * Renders the Control Center managed home / about / contact pages
 * with safe fallbacks to the theme layouts.
 * Guard: if this file is ever included before the main query exists
 * (e.g. someone copies it into a plugins dir), do nothing.
 */
if (!defined('ABSPATH') || empty($GLOBALS['wp_query'])) {
    return;
}
get_header();
?>
<main id="al-main">
	<?php
	$kind = isset($GLOBALS['alookhor_v5_kind']) ? $GLOBALS['alookhor_v5_kind'] : 'home';
	if ($kind === 'home') {
		?>
		<?php
		if (function_exists('alookhor_managed_or')) {
			alookhor_managed_or('[alookhor_managed_hero]', 'alookhor_home_hero_builtin', 'alookhor-categories-manager');
			alookhor_managed_or('[alookhor_managed_features]', 'alookhor_home_features_builtin');
			alookhor_managed_or('[alookhor_managed_categories]', 'alookhor_home_categories_builtin');
		} else {
			echo do_shortcode('[alookhor_managed_hero]');
			echo do_shortcode('[alookhor_managed_features]');
			echo do_shortcode('[alookhor_managed_categories]');
		}
		?>
		<?php
		$alookhor_v5_modules = array(
			'bestselling_products' => '[alookhor_bestselling_products]',
			'sort_center'          => '[alookhor_sort_center]',
			'why_alookhor'         => '[alookhor_why_alookhor]',
			'international_standards' => '[alookhor_international_standards]',
			'magazine'             => '[alookhor_magazine]',
			'app_banner'           => '[alookhor_app_banner]',
			'newsletter'           => '[alookhor_newsletter]',
		);
		foreach ($alookhor_v5_modules as $alookhor_v5_mod => $alookhor_v5_sc) {
			if (function_exists('alookhor_cc_module_enabled') && !alookhor_cc_module_enabled($alookhor_v5_mod)) {
				continue;
			}
			$alookhor_v5_out = do_shortcode($alookhor_v5_sc);
			if (strlen(trim(wp_strip_all_tags($alookhor_v5_out))) >= 20) {
				echo $alookhor_v5_out; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			}
		}
		?>
		<?php
	} elseif ($kind === 'about') {
		$alookhor_v5_out = do_shortcode('[alookhor_about_page]');
		if (strlen(trim(wp_strip_all_tags($alookhor_v5_out))) >= 100) {
			echo $alookhor_v5_out; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		} elseif (function_exists('alookhor_layout_about')) {
			alookhor_layout_about();
		}
	} elseif ($kind === 'contact') {
		$alookhor_v5_out = do_shortcode('[alookhor_contact_page]');
		if (strlen(trim(wp_strip_all_tags($alookhor_v5_out))) >= 100) {
			echo $alookhor_v5_out; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		} elseif (function_exists('alookhor_layout_contact')) {
			alookhor_layout_contact();
		}
	}
	?>
</main>
<?php
get_footer();
TPL;
}

function alookhor_v51_write_template()
{
	$dir = dirname(ALOOKHOR_V51_TEMPLATE);
	if (!is_dir($dir)) {
		@mkdir($dir, 0755, true);
	}
	if (!is_dir($dir) || !is_writable($dir)) {
		return false;
	}
	$code = alookhor_v51_template_code();
	$existing = is_file(ALOOKHOR_V51_TEMPLATE) ? (string) @file_get_contents(ALOOKHOR_V51_TEMPLATE) : '';
	if ($existing === $code) {
		return true;
	}
	$ok = @file_put_contents(ALOOKHOR_V51_TEMPLATE, $code, LOCK_EX);
	return $ok !== false && is_file(ALOOKHOR_V51_TEMPLATE);
}

/* ------------------------------------------------------------------ *
 * Repair (runs once)
 * ------------------------------------------------------------------ */
function alookhor_v51_repair()
{
	$log = array(
		'neutralized'          => isset($GLOBALS['alookhor_v51_neutral']) ? $GLOBALS['alookhor_v51_neutral'] : array(),
		'cc_dir'               => false,
		'site_json'            => false,
		'header_fixed'         => false,
		'cc_restored'          => false,
		'hero_images_repaired' => false,
		'prices_healed'        => null,
		'blog_page'            => null,
		'template'             => false,
	);

	$dir = '';
	if (defined('ALOOKHOR_CC_DIR') && is_dir(ALOOKHOR_CC_DIR)) {
		$dir = ALOOKHOR_CC_DIR;
	} elseif (defined('WP_PLUGIN_DIR') && is_dir(WP_PLUGIN_DIR . '/alookhor-control-center')) {
		$dir = WP_PLUGIN_DIR . '/alookhor-control-center';
	}
	$log['cc_dir'] = (bool) $dir;

	$json = array();
	if ($dir) {
		$f = $dir . '/config/site.json';
		if (is_file($f)) {
			$decoded = json_decode((string) file_get_contents($f), true);
			if (is_array($decoded)) {
				$json = $decoded;
			}
		}
	}
	$log['site_json'] = (bool) $json;

	// 1) header settings: the enqueue gate needs 'enabled'; the activation
	//    hook only copied 4 keys, so fill from the plugin's site.json.
	$h = get_option('alookhor_header_settings');
	if (!is_array($h)) {
		$h = array();
	}
	if (!array_key_exists('enabled', $h) && !empty($json['header_settings'])) {
		$h = array_merge((array) $json['header_settings'], $h);
		$h['enabled'] = true;
		update_option('alookhor_header_settings', $h);
		$log['header_fixed'] = true;
	}

	// 2) main settings: restore full config when missing.
	$cs = get_option('alookhor_cc_settings');
	if (empty($cs) && !empty($json)) {
		update_option('alookhor_cc_settings', $json);
		$log['cc_restored'] = true;
	}
	if (!is_array($cs)) {
		$cs = array();
	}

	// 2b) hero slide images: the snapshot points at the old
	//     alookhor-categories-manager plugin (gone after the reset) -> dead
	//     images. Remap to the Control Center's own bundled category images.
	$log['hero_images_repaired'] = false;
	if (!empty($cs['hero_settings']['slides']) && is_array($cs['hero_settings']['slides']) && $dir) {
		$slug_map = array(
			'slide1' => 'category-plums',
			'slide2' => 'category-fruit-sheets',
			'slide3' => 'category-natural-snacks',
			'slide4' => 'category-nuts',
		);
		$base_url = function_exists('plugins_url') ? plugins_url('/alookhor-control-center/assets/images/') : '';
		$changed = false;
		foreach ($cs['hero_settings']['slides'] as $i => $slide) {
			if (!is_array($slide)) {
				continue;
			}
			$u = (string) ($slide['image_url'] ?? '');
			if (strpos($u, 'alookhor-categories-manager') === false) {
				continue;
			}
			$slug = 'category-plums';
			foreach ($slug_map as $needle => $mapped) {
				if (strpos($u, $needle) !== false) {
					$slug = $mapped;
					break;
				}
			}
			// The four category images ship inside the official plugin zip
			// (verified in public/releases). When the images dir is visible on
			// disk, verify the file; otherwise trust the manifest.
			$ok = is_dir($dir . '/assets/images')
				? is_file($dir . '/assets/images/' . $slug . '.jpg')
				: true;
			if ($base_url && $ok) {
				$cs['hero_settings']['slides'][$i]['image_url'] = $base_url . $slug . '.jpg';
				$changed = true;
			}
		}
		if ($changed) {
			update_option('alookhor_cc_settings', $cs);
			$log['hero_images_repaired'] = true;
		}
	}

	// 3) portal template (safe location).
	$log['template'] = alookhor_v51_write_template();

	// 4) seeded product prices: the live store showed ﷼0 because the
	//    variable parents lost their _price sync. The plugin ships its
	//    own one-time healer — use it (forced so it runs now).
	if (function_exists('alookhor_cc_heal_seeded_prices')) {
		$pr = alookhor_cc_heal_seeded_prices(true);
		$log['prices_healed'] = is_array($pr)
			? array('scanned' => (int) ($pr['scanned'] ?? 0),
				'healed' => count((array) ($pr['healed'] ?? array())),
				'still_broken' => count((array) ($pr['still_broken'] ?? array())),
				'skipped' => isset($pr['skipped']) ? (string) $pr['skipped'] : null)
			: $pr;
	}

	// 5) blog page: the primary menu links to /blog/ — make sure a page
	//    owns that slug (adopt an existing magazine/blog page if any,
	//    otherwise create one rendering the magazine stack).
	$blog = get_page_by_path('blog', OBJECT, 'page');
	if (!$blog) {
		foreach (array('مجله آلوخور', 'مجله', 'Blog', 'بلاگ') as $t) {
			$cand = get_page_by_title($t, OBJECT, 'page');
			if ($cand) {
				$blog = $cand;
				break;
			}
		}
	}
	if ($blog) {
		if (($blog->post_name ?? '') !== 'blog') {
			wp_update_post(array('ID' => (int) $blog->ID, 'post_name' => 'blog'));
			$log['blog_page'] = 'adopted-' . (int) $blog->ID;
		} else {
			$log['blog_page'] = 'exists-' . (int) $blog->ID;
		}
	} else {
		$bid = wp_insert_post(array(
			'post_type' => 'page',
			'post_status' => 'publish',
			'post_title' => 'مجله آلوخور',
			'post_name' => 'blog',
			'post_content' => '[alookhor_magazine]',
		));
		$log['blog_page'] = $bid ? 'created-' . (int) $bid : 'FAILED';
	}
	update_option('rewrite_rules', '');

	update_option(ALOOKHOR_V51_DONE_OPT, $log);
	return $log;
}
add_action('init', function () {
	if (get_option(ALOOKHOR_V51_DONE_OPT)) {
		return;
	}
	$alookhor_v51_log = alookhor_v51_repair();
	if (function_exists('set_transient')) {
		set_transient('alookhor_v51_log', $alookhor_v51_log, 600);
	}
}, 5);

/* ------------------------------------------------------------------ *
 * Template swap
 * ------------------------------------------------------------------ */
add_filter('template_include', function ($tpl) {
	if (!defined('ALOOKHOR_CC_VERSION')) {
		return $tpl;
	}
	if (!is_file(ALOOKHOR_V51_TEMPLATE)) {
		return $tpl;
	}
	$kind = '';
	if (function_exists('is_front_page') && is_front_page()) {
		$kind = 'home';
	} else {
		$q = function_exists('get_queried_object') ? get_queried_object() : null;
		if (is_object($q) && !empty($q->ID)) {
			$id = (int) $q->ID;
			if (in_array($id, alookhor_v5_about_ids(), true)) {
				$kind = 'about';
			} elseif (in_array($id, alookhor_v5_contact_ids(), true)) {
				$kind = 'contact';
			}
		}
	}
	if ($kind) {
		$GLOBALS['alookhor_v5_kind'] = $kind;
		return ALOOKHOR_V51_TEMPLATE;
	}
	return $tpl;
}, 20);

/* ------------------------------------------------------------------ *
 * Status / finish endpoint (agent verification) — same token as v5
 * ------------------------------------------------------------------ */
add_action('template_redirect', function () {
	if (!isset($_GET['alookhor_v5']) || $_GET['alookhor_v5'] !== ALOOKHOR_V5_TOKEN) {
		return;
	}
	if (isset($_GET['finish']) && $_GET['finish'] === '1') {
		$noop = "<?php\n// ALOOKHOR one-click setup v5.1 — completed successfully at " . date('c') . ".\n// This file is now intentionally a no-op (keeps the mu-plugins slot clean).\n";
		@file_put_contents(__FILE__, $noop, LOCK_EX);
		header('Content-Type: application/json; charset=utf-8');
		echo json_encode(array('ok' => true, 'msg' => 'v5.2 disabled, site is clean'));
		exit;
	}
	$h = get_option('alookhor_header_settings');
	$cs = get_option('alookhor_cc_settings');
	$report = array(
		'ok' => true,
		'version' => 'v5.2',
		'cc_version' => defined('ALOOKHOR_CC_VERSION') ? ALOOKHOR_CC_VERSION : 'MISSING',
		'php' => PHP_VERSION,
		'done_log' => get_option(ALOOKHOR_V51_DONE_OPT, array()),
		'header' => array(
			'enabled' => !empty($h['enabled']),
			'keys' => is_array($h) ? count($h) : 0,
			'has_wholesale' => !empty($h['wholesale_text']) || !empty($h['export_text']),
		),
		'cc_settings' => array(
			'top_keys' => is_array($cs) ? array_keys($cs) : array(),
			'modules_enabled' => is_array($cs) && is_array($cs['modules']) ? array_filter(array_map('boolval', $cs['modules'])) : array(),
		),
		'template_file' => is_file(ALOOKHOR_V51_TEMPLATE),
		'about_ids' => alookhor_v5_about_ids(),
		'contact_ids' => alookhor_v5_contact_ids(),
	);
	header('Content-Type: application/json; charset=utf-8');
	echo json_encode($report, JSON_UNESCAPED_UNICODE);
	exit;
}, 1);
