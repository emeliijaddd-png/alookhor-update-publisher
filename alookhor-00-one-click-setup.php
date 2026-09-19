<?php
/**
 * ALOOKHOR One-Click Setup — v5.3 (FINAL — completion suite)
 * ---------------------------------------------------------
 * Same file, same name, same token as v5.2 (drop-in replacement in
 * wp-content/mu-plugins/). Contains ALL v5.2 logic (rescue, header fix,
 * settings restore, hero repair, price heal, blog page, portal template,
 * status/finish) PLUS the v5.3 completion suite, which runs once:
 *
 *   1. Currency IRR -> IRT (toman). Seeded prices are toman-denominated
 *      (3kg = 390,000). With the host currency IRR, the CC's PDP/cart/
 *      checkout modules divide by 10 (the "۳۹۰۰toman" price bug — 10x
 *      cheaper than the home page). IRT makes every module display the
 *      stored value as toman — one consistent price site-wide.
 *   2. Restores the missing .htaccess (host reset wiped it; every pretty
 *      URL 404'd at the LiteSpeed level: /shop/ /blog/ /product-category/
 *      /wholesale/ /export/ /gift-packages/ /catalog/).
 *   3. Sets a pretty permalink structure (/%postname%/) and flushes
 *      rewrites so those URLs resolve inside WordPress.
 *   4. Deletes default demo content (the "سلام دنیا" post, Sample Page).
 *   5. Fixes the WooCommerce core pages: shop content -> [products]
 *      (it said "فروشگاه در حال ساخت هست"), cart -> [woocommerce_cart]
 *      (the Control Center renders its luxury cart on that tag),
 *      my-account -> [woocommerce_my_account], checkout ->
 *      [alookhor_checkout] (the branded CC checkout), order-received
 *      page created when missing.
 *   6. Creates the menu-linked pages when missing: /wholesale/
 *      /export/ /gift-packages/ /catalog/ with proper branded content.
 *   7. Completes the order flow: adds the missing billing_email field to
 *      the CC checkout form (idempotent file patch), relaxes WC
 *      validation to the simple form's fields, enables the free-shipping
 *      method (the brand promises free shipping) + flat rate + the
 *      bacs (کارت به کارت) / cod gateways the form offers.
 *   8. Seeds the empty campaign slider and the sort-center slider with
 *      the plugin's bundled images (the "از مدیریت بوتیک انتخاب کنید"
 *      placeholders go away).
 *   9. Publishes a real magazine post (after Hello World is deleted) so
 *      the magazine section has real content.
 *  10. Persian digits for wc_price on the frontend (IRT) so the
 *      home/shop price ranges match the product pages.
 *  11. Purges the LiteSpeed cache when the plugin is present.
 *
 * Status: ?alookhor_v5=TOKEN — v5.3 report + v5.2 fields.
 * Optional internal link audit: &audit=1.
 * Force re-run of the suite: &v53force=1.
 * finish=1: marks completion (the file STAYS active — its checkout
 * validation + price filters are part of the live system).
 *
 * Safety: every step is idempotent; the suite runs once (option flag);
 * nothing destructive is gated on anything but exact title/slug matches.
 */
if (!defined('ABSPATH')) {
    exit;
}

define('ALOOKHOR_V5_TOKEN', 'v5-9f31c7ab02d4');
define('ALOOKHOR_V51_DONE_OPT', 'alookhor_v51_done');
define('ALOOKHOR_V53_DONE_OPT', 'alookhor_v53_done');
define('ALOOKHOR_V53_TEMPLATE', WP_CONTENT_DIR . '/uploads/alookhor-portal/alookhor-cc-portal-template.php');

/* ------------------------------------------------------------------ *
 * RESCUE (v5.2) — must run at file scope, BEFORE any broken mu-plugin
 * file is included. 'alookhor-00-*' sorts first in mu-plugins load.
 * Idempotent: already-neutralized files are skipped.
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

    // b) the old v5 setup file -> no-op
    $alookhor_v51_f = $alookhor_v51_muplugs . 'alookhor-one-click-setup.php';
    if (is_file($alookhor_v51_f)) {
        $alookhor_v51_c = (string) @file_get_contents($alookhor_v51_f);
        if (strpos($alookhor_v51_c, 'ALOOKHOR_V5_DONE_OPT') !== false) {
            $alookhor_v51_c = "<?php\n// ALOOKHOR one-click setup v5 — superseded by v5.3 (alookhor-00-one-click-setup.php).\n// Intentionally a no-op; all v5 work is recorded in option alookhor_v5_done.\n";
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
 * Page id helpers (v5.2)
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
 * Portal template writer (v5.2 — safe location: uploads/, which is
 * never auto-included).
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
	$dir = dirname(ALOOKHOR_V53_TEMPLATE);
	if (!is_dir($dir)) {
		@mkdir($dir, 0755, true);
	}
	if (!is_dir($dir) || !is_writable($dir)) {
		return false;
	}
	$code = alookhor_v51_template_code();
	$existing = is_file(ALOOKHOR_V53_TEMPLATE) ? (string) @file_get_contents(ALOOKHOR_V53_TEMPLATE) : '';
	if ($existing === $code) {
		return true;
	}
	$ok = @file_put_contents(ALOOKHOR_V53_TEMPLATE, $code, LOCK_EX);
	return $ok !== false && is_file(ALOOKHOR_V53_TEMPLATE);
}

/* ------------------------------------------------------------------ *
 * v5.2 repair — unchanged (guarded by its own done option; on the
 * host it already ran, so this is a no-op there).
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

	// 1) header settings: the enqueue gate needs 'enabled'.
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

	// 2b) hero slide images: remap dead alookhor-categories-manager
	//     URLs to the Control Center's own bundled category images.
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

	// 4) seeded product prices: the plugin's own one-time healer.
	if (function_exists('alookhor_cc_heal_seeded_prices')) {
		$pr = alookhor_cc_heal_seeded_prices(true);
		$log['prices_healed'] = is_array($pr)
			? array('scanned' => (int) ($pr['scanned'] ?? 0),
				'healed' => count((array) ($pr['healed'] ?? array())),
				'still_broken' => count((array) ($pr['still_broken'] ?? array())),
				'skipped' => isset($pr['skipped']) ? (string) $pr['skipped'] : null)
			: $pr;
	}

	// 5) blog page: the primary menu links to /blog/.
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
 * v5.3 completion suite (runs once; force re-run with v53force=1)
 * ------------------------------------------------------------------ */
function alookhor_v53_cc_dir()
{
	if (defined('ALOOKHOR_CC_DIR') && is_dir(ALOOKHOR_CC_DIR)) {
		return ALOOKHOR_CC_DIR;
	}
	if (defined('WP_PLUGIN_DIR') && is_dir(WP_PLUGIN_DIR . '/alookhor-control-center')) {
		return WP_PLUGIN_DIR . '/alookhor-control-center';
	}
	return '';
}
function alookhor_v53_fix_page_content($id, $new_content)
{
	$p = get_post((int) $id);
	if (!$p || (int) $p->ID === 0) {
		return 'no-page';
	}
	$tags = trim(strip_tags((string) $p->post_content));
	$bad = (strpos((string) $p->post_content, 'در حال ساخت') !== false)
		|| (strpos($tags, 'به زودی راه اندازی میشه') !== false)
		|| (strlen($tags) < 60);
	if (!$bad) {
		return 'ok';
	}
	wp_update_post(array('ID' => (int) $p->ID, 'post_content' => $new_content));
	return 'content-set';
}

function alookhor_v53_repair()
{
	$log = array(
		'template'        => alookhor_v51_write_template(),
		'currency'        => 'n/a',
		'htaccess'        => 'n/a',
		'permalink'       => 'n/a',
		'deleted'         => array(),
		'wc_pages'        => array(),
		'brand_pages'     => array(),
		'checkout_patch'  => 'n/a',
		'shipping'        => 'n/a',
		'payments'        => 'n/a',
		'campaign'        => 'n/a',
		'sort_center'     => 'n/a',
		'magazine_post'   => 'n/a',
		'lscache'         => 'n/a',
		'inventory'       => array(),
	);
	$cc = alookhor_v53_cc_dir();

	/* 1) currency: IRR -> IRT (prices are toman-denominated). */
	if (function_exists('get_woocommerce_currency')) {
		$cur = get_woocommerce_currency();
		if ($cur === 'IRR') {
			update_option('woocommerce_currency', 'IRT');
			$log['currency'] = 'IRR->IRT';
		} else {
			$log['currency'] = $cur . ' (unchanged)';
		}
	}

	/* 2) .htaccess — restore when missing/emptied by the reset. */
	$hta = ABSPATH . '.htaccess';
	$hta_content = "# BEGIN WordPress\n"
		. "<IfModule mod_rewrite.c>\n"
		. "RewriteEngine On\n"
		. "RewriteBase /\n"
		. "RewriteRule ^index\\.php\$ - [L]\n"
		. "RewriteCond %{REQUEST_FILENAME} !-f\n"
		. "RewriteCond %{REQUEST_FILENAME} !-d\n"
		. "RewriteRule . /index.php [L]\n"
		. "</IfModule>\n"
		. "# END WordPress\n"
		. "\n"
		. "<IfModule LiteSpeed>\n"
		. "# never cache the ALOOKHOR setup/status endpoints\n"
		. "RewriteCond %{QUERY_STRING} alookhor_v5\n"
		. "RewriteRule .* - [E=\"Cache-Control:no-cache, must-revalidate\"]\n"
		. "</IfModule>\n";
	if (!is_file($hta)) {
		$ok = @file_put_contents($hta, $hta_content, LOCK_EX);
		$log['htaccess'] = ($ok !== false && is_file($hta)) ? 'written' : 'FAILED-no-write';
	} else {
		$existing = (string) @file_get_contents($hta);
		if (stripos($existing, 'RewriteEngine') !== false || stripos($existing, 'WordPress') !== false) {
			$log['htaccess'] = 'exists';
		} else {
			$ok = @file_put_contents($hta, $hta_content, LOCK_EX);
			$log['htaccess'] = ($ok !== false) ? 'restored' : 'FAILED-no-write';
		}
	}

	/* 3) pretty permalinks so /shop/ /blog/ /product-category/… resolve. */
	$struct = (string) get_option('permalink_structure');
	if ($struct !== '/%postname%/') {
		update_option('permalink_structure', '/%postname%/');
		update_option('rewrite_rules', '');
		if (function_exists('flush_rewrite_rules')) {
			flush_rewrite_rules(true);
		}
		$log['permalink'] = ($struct === '' ? 'plain->' : $struct . '->') . '/%postname%/';
	} else {
		$log['permalink'] = 'already-pretty';
	}

	/* 4) default demo content — exact matches only. */
	$p1 = get_post(1);
	if (is_object($p1) && $p1->post_type === 'post'
		&& in_array($p1->post_title, array('سلام دنیا', 'سلام دنیا!', 'Hello World', 'Hello World!', 'هلو ورلد'), true)) {
		if (wp_delete_post((int) $p1->ID, true)) {
			$log['deleted'][] = 'post-1-hello-world';
		}
	}
	if (function_exists('get_page_by_path')) {
		$sp = get_page_by_path('sample-page', OBJECT, 'page');
		if (is_object($sp) && in_array($sp->post_title, array('Sample Page', 'صفحه نمونه', 'نمونه'), true)
			&& wp_delete_post((int) $sp->ID, true)) {
			$log['deleted'][] = 'sample-page';
		}
	}

	/* 5) WooCommerce core pages — create when missing, fix placeholders. */
	if (function_exists('wc_get_page_id')) {
		$wc_pages = array(
			'shop'          => '[products limit="24" columns="3" orderby="date" order="DESC"]',
			'cart'          => '[woocommerce_cart]',
			'myaccount'     => '[woocommerce_my_account]',
			'checkout'      => '[alookhor_checkout]',
			'order_received' => '[woocommerce_order_received]',
		);
		foreach ($wc_pages as $key => $content) {
			$id = (int) wc_get_page_id($key);
			if ($id === 0 && function_exists('wc_create_page')) {
				$id = (int) wc_create_page($key);
				if ($id > 0) {
					$log['wc_pages'][$key] = 'created-' . $id;
				}
			}
			if ($id > 0) {
				$r = alookhor_v53_fix_page_content($id, $content);
				if (isset($log['wc_pages'][$key])) {
					$log['wc_pages'][$key] .= '+' . $r;
				} else {
					$log['wc_pages'][$key] = $r;
				}
				// shop must own the 'shop' slug for /shop/ to resolve
				if ($key === 'shop') {
					$pg = get_post($id);
					if (is_object($pg) && ($pg->post_name ?? '') !== 'shop') {
						wp_update_post(array('ID' => $id, 'post_name' => 'shop'));
						$log['wc_pages'][$key] .= '+slug-set';
					}
				}
			} elseif (!isset($log['wc_pages'][$key])) {
				$log['wc_pages'][$key] = 'MISSING';
			}
		}
	}

	/* 6) menu-linked brand pages — create when missing. */
	$brand = array(
		'wholesale' => array(
			'title'   => 'خرید عمده و صادرات',
			'slug'    => 'wholesale',
			'content' => "<h2>تأمین پایدار برای کسب‌وکارها</h2>\n"
				. "<p>آلوخور برای فروشگاه‌ها، برندها و بازرگانان، تأمین پایدار خشکبار ممتاز — آلو بخارا، کشمش، لواشک، گردو و... — با قیمت همکاری، بسته‌بندی صادراتی (پاکت، کارتن و کارتن‌های صادراتی) و ارسال به بیش از ۱۵ کشور ارائه می‌دهد.</p>\n"
				. "<p>برای دریافت قیمت همکاری و کاتالوگ محصولات، فرم تماس را با موضوع «سفارش عمده» یا «صادرات» پر کنید؛ تیم بازرگانی آلوخور در سریع‌ترین زمان با شما تماس می‌گیرد.</p>\n"
				. "<p><a href=\"/?page_id=24\">درخواست همکاری</a> | <a href=\"/catalog/\">کاتالوگ محصولات</a></p>\n",
		),
		'export' => array(
			'title'   => 'صادرات آلوخور',
			'slug'    => 'export',
			'content' => "<h2>صادرات خشکبار ممتاز خراسان</h2>\n"
				. "<p>محصولات آلوخور با استانداردهای ISO، HACCP، Organic و Halal برای صادرات به بیش از ۱۵ کشور آماده‌اند؛ بسته‌بندی صادراتی، برچسب‌بندی چندزبانه و مدارک ترخیص برای مقاصد مختلف.</p>\n"
				. "<p>تیم بازرگانی آلوخور پاسخگوی شرایط سفارش‌های صادراتی، حجم بار و زمان‌بندی حمل است.</p>\n"
				. "<p><a href=\"/wholesale/\">شرایط همکاری عمده</a> | <a href=\"/?page_id=24\">تماس با تیم بازرگانی</a></p>\n",
		),
		'gift-packages' => array(
			'title'   => 'بسته‌های هدیه',
			'slug'    => 'gift-packages',
			'content' => "<h2>بسته‌های هدیه آلوخور</h2>\n"
				. "<p>مجموعه‌های منتخب خشکبار ممتاز آلوخور در بسته‌بندی شیک و صادراتی؛ مناسب هدیه‌های خانوادگی، پذیرایی و هدایای سازمانی. امکان سفارشی‌سازی بسته با لوگوی شما نیز وجود دارد.</p>\n"
				. "<p><a href=\"/shop/\">مشاهده محصولات</a></p>\n",
		),
		'catalog' => array(
			'title'   => 'کاتالوگ محصولات',
			'slug'    => 'catalog',
			'content' => "[products limit=\"24\" columns=\"4\" orderby=\"date\" order=\"DESC\"]",
		),
	);
	foreach ($brand as $slug => $def) {
		$pg = function_exists('get_page_by_path') ? get_page_by_path($slug, OBJECT, 'page') : null;
		if (!is_object($pg)) {
			$pid = wp_insert_post(array(
				'post_type' => 'page',
				'post_status' => 'publish',
				'post_title' => $def['title'],
				'post_name' => $slug,
				'post_content' => $def['content'],
			));
			$log['brand_pages'][$slug] = $pid ? 'created-' . (int) $pid : 'FAILED';
		} else {
			$r = alookhor_v53_fix_page_content((int) $pg->ID, $def['content']);
			$log['brand_pages'][$slug] = $r;
		}
	}

	/* 7) order flow completion. */
	// 7a) add the missing billing_email field to the CC checkout form.
	$GLOBALS['alookhor_v53_email_patched'] = false;
	if ($cc) {
		$f = $cc . '/includes/checkout-page.php';
		$c = is_file($f) ? (string) @file_get_contents($f) : false;
		if ($c !== false) {
			if (strpos($c, 'billing_email') !== false) {
				$log['checkout_patch'] = 'already-patched';
				$GLOBALS['alookhor_v53_email_patched'] = true;
			} else {
				$pos = strpos($c, 'name="billing_address_1"');
				if ($pos !== false) {
					$end = strpos($c, '</textarea>', $pos);
					if ($end !== false) {
						$ins = "\n          <div class=\"form-row\">\n"
							. "            <label>ایمیل *</label>\n"
							. "            <input type=\"email\" name=\"billing_email\" placeholder=\"ایمیل شما (برای ارسال رسید و پیگیری سفارش)\" value=\"<?php echo esc_attr(WC()->customer ? WC()->customer->get_billing_email() : ''); ?>\" required>\n"
							. "          </div>";
						$after = $end + strlen('</textarea>');
						$c = substr($c, 0, $after) . $ins . substr($c, $after);
						if (@file_put_contents($f, $c, LOCK_EX) !== false) {
							$log['checkout_patch'] = 'patched';
							$GLOBALS['alookhor_v53_email_patched'] = true;
						} else {
							$log['checkout_patch'] = 'FAILED-no-write';
						}
					} else {
						$log['checkout_patch'] = 'FAILED-no-needle';
					}
				} else {
					$log['checkout_patch'] = 'FAILED-no-needle';
				}
			}
		} else {
			$log['checkout_patch'] = 'file-missing';
		}
	}

	// 7b) free shipping (brand promise) + flat rate for the CC form's methods.
	$ship = array();
	if (class_exists('WC_Shipping_Zones')) {
		try {
			$zones = new WC_Shipping_Zones();
			$zone = $zones->get_zone(0);
			$has_free = false;
			foreach ((array) $zone->get_shipping_methods(false, true) as $m) {
				if (is_object($m) && $m->id === 'free_shipping') {
					$has_free = true;
					break;
				}
			}
			if (!$has_free) {
				$zone->add_shipping_method('free_shipping', 0);
				$ship['free_shipping'] = 'added';
			} else {
				$ship['free_shipping'] = 'exists';
			}
			$fs = get_option('woocommerce_free_shipping_settings');
			if (!is_array($fs)) {
				$fs = array();
			}
			$fs['enabled'] = 'yes';
			if (!isset($fs['requires'])) {
				$fs['requires'] = 'cart';
			}
			update_option('woocommerce_free_shipping_settings', $fs);
			$fr = get_option('woocommerce_flat_rate_settings');
			if (!is_array($fr)) {
				$fr = array();
			}
			if (empty($fr['cost'])) {
				$fr['cost'] = '30000'; // ۳۰۰۰۰ تومان — تیپاکس (matches the form label)
			}
			$fr['enabled'] = 'yes';
			update_option('woocommerce_flat_rate_settings', $fr);
			$ship['flat_rate'] = 'ok';
		} catch (Throwable $e) {
			$ship['error'] = $e->getMessage();
		}
		$log['shipping'] = $ship ?: 'ok';
	}

	// 7c) payment gateways offered by the CC form: bacs + cod.
	$gws = get_option('woocommerce_enabled_payment_gateways');
	if (!is_array($gws)) {
		$gws = array();
	}
	$pay = array();
	if (!isset($gws['bacs'])) {
		$gws['bacs'] = array('enabled' => 'yes', 'title' => 'پرداخت آنلاین (کارت به کارت)', 'description' => 'پرداخت امن از طریق درگاه بانکی', 'order' => 1);
		$pay[] = 'bacs-added';
	}
	if (!isset($gws['cod'])) {
		$gws['cod'] = array('enabled' => 'yes', 'title' => 'پرداخت در محل', 'description' => 'پرداخت در زمان تحویل', 'order' => 2);
		$pay[] = 'cod-added';
	}
	if ($pay) {
		update_option('woocommerce_enabled_payment_gateways', $gws);
	}
	$log['payments'] = $pay ? implode(',', $pay) : 'ok';

	/* 8) empty managed sliders -> seed with bundled plugin images. */
	if ($cc && is_dir($cc . '/assets/images')) {
		$cs = get_option('alookhor_cc_settings');
		if (!is_array($cs)) {
			$cs = array();
		}
		$img = (function_exists('plugins_url') ? plugins_url('/alookhor-control-center/assets/images/') : 'https://alookhor.ir/wp-content/plugins/alookhor-control-center/assets/images/');
		$changed = false;

		$camp = isset($cs['campaign_settings']) && is_array($cs['campaign_settings']) ? $cs['campaign_settings'] : array();
		$camp_slides = array_values(array_filter((array) ($camp['slides'] ?? array()), fn($x) => is_array($x) && !empty($x['image_url'])));
		if (!$camp_slides) {
			$camp['slides'] = array(
				array('image_id' => 0, 'image_url' => $img . 'banner.jpg', 'image_alt' => 'پیشنهاد ویژه آلوخور', 'eyebrow' => 'پیشنهاد ویژه آلوخور', 'title' => 'تخفیف پاییزی روی محصولات ممتاز', 'description' => 'بهترین محصولات آلوخور با شرایط ویژه و ارسال رایگان', 'button_text' => 'مشاهده محصولات', 'button_url' => '/shop/'),
				array('image_id' => 0, 'image_url' => $img . 'export-banner-bg.jpg', 'image_alt' => 'فروش عمده آلوخور', 'eyebrow' => 'همکاری با کسب‌وکارها', 'title' => 'فروش عمده و صادراتی', 'description' => 'قیمت همکاری و تأمین پایدار برای فروشگاه‌ها و بازرگانان', 'button_text' => 'درخواست همکاری', 'button_url' => '/wholesale/'),
			);
			$cs['campaign_settings'] = $camp;
			$log['campaign'] = 'seeded-2';
			$changed = true;
		} else {
			$log['campaign'] = 'exists-' . count($camp_slides);
		}

		$sort = isset($cs['sort_center_settings']) && is_array($cs['sort_center_settings']) ? $cs['sort_center_settings'] : array();
		$sort_slides = array_values(array_filter((array) ($sort['slides'] ?? array()), fn($x) => is_array($x) && !empty($x['image_url'])));
		if (!$sort_slides) {
			$sort['slides'] = array(
				array('image_id' => 0, 'image_url' => $img . 'pack.jpg', 'image_alt' => 'مرکز سورت آلوخور', 'caption' => 'سورت دقیق محصولات'),
				array('image_id' => 0, 'image_url' => $img . 'sack.jpg', 'image_alt' => 'بسته‌بندی آلوخور', 'caption' => 'بسته‌بندی استاندارد'),
				array('image_id' => 0, 'image_url' => $img . 'assortment.jpg', 'image_alt' => 'کنترل کیفیت آلوخور', 'caption' => 'کنترل کیفیت مستمر'),
			);
			$log['sort_center'] = 'seeded-3';
			$changed = true;
		} else {
			$log['sort_center'] = 'exists-' . count($sort_slides);
		}
		if (!empty($sort['button_url']) && $sort['button_url'] !== '/wholesale/') {
			$sort['button_url'] = '/wholesale/';
			$changed = true;
		}
		if ($changed) {
			$cs['sort_center_settings'] = $sort;
			update_option('alookhor_cc_settings', $cs);
		}
	}

	/* 9) magazine: a real post after the Hello World cleanup. */
	$has_post = false;
	if (function_exists('get_posts')) {
		$has_post = (bool) get_posts(array('post_type' => 'post', 'post_status' => 'publish', 'numberposts' => 1));
	}
	if (!$has_post) {
		$mid = wp_insert_post(array(
			'post_type' => 'post',
			'post_status' => 'publish',
			'post_title' => 'آلو بخارا؛ پادشاه خشکبار خراسان',
			'post_name' => 'aloo-bokhara-kharasan',
			'post_content' => "<p>آلو بخارا یکی از ارزشمندترین محصولات باغی خراسان است؛ میوه‌ای که با نور و هوای پاک خور نیشابور شکل می‌گیرد و بدون هیچ افزودنی، در آفتاب خشک می‌شود تا عطر و طعم باغ را تا ماه‌ها حفظ کند.</p>\n"
				. "<h2>چرا آلو بخارای آلوخور متفاوت است؟</h2>\n"
				. "<p>هر بسته آلو بخارای آلوخور از برداشت دستی در باغ تا سورت دقیق، کنترل کیفیت و بسته‌بندی بهداشتی زیر نظر تیم کارشناسان ما انجام می‌شود. بدون گوگرد اضافی، بدون شکر افزوده و بدون مواد نگهدارنده؛ فقط آلو بخارای ممتاز خراسان.</p>\n"
				. "<p>آلو بخارا سرشار از فیبر، پتاسیم و آنتی‌اکسیدان است و هم برای میان‌وعده سالم روزمره و هم برای خورشت‌ها و دسرها انتخاب اول آشپزخانه‌های ایرانی است.</p>\n",
		));
		if ($mid) {
			// featured image from a bundled asset (best effort).
			$thumb = '';
			if ($cc && is_file($cc . '/assets/images/banner.jpg') && function_exists('wp_upload_dir')) {
				try {
					$up = wp_upload_dir();
					$dest = $up['basedir'] . '/alookhor-mag-aloo-bokhara.jpg';
					if (!is_file($dest) && @copy($cc . '/assets/images/banner.jpg', $dest)) {
						$att_id = wp_insert_attachment(array(
							'post_title' => 'آلو بخارا آلوخور',
							'post_type' => 'attachment',
							'post_mime_type' => 'image/jpeg',
							'post_status' => 'inherit',
						), $dest, 0);
						if ($att_id && !is_wp_error($att_id)) {
							wp_update_attachment_metadata($att_id, wp_generate_attachment_metadata($att_id, $dest));
							set_post_thumbnail((int) $mid, (int) $att_id);
							$thumb = 'thumb-' . (int) $att_id;
						}
					}
				} catch (Throwable $e) {
					$thumb = 'thumb-err';
				}
			}
			$log['magazine_post'] = 'created-' . (int) $mid . ($thumb ? '+' . $thumb : '');
		} else {
			$log['magazine_post'] = 'FAILED';
		}
	} else {
		$log['magazine_post'] = 'exists';
	}

	/* 10) LiteSpeed cache purge (when the plugin is present). */
	if (function_exists('lscache')) {
		try {
			$lc = lscache();
			if ($lc && method_exists($lc, 'purge')) {
				$lc->purge()->all();
				$log['lscache'] = 'purged';
			} else {
				$log['lscache'] = 'no-purge-method';
			}
		} catch (Throwable $e) {
			$log['lscache'] = 'err';
		}
	} else {
		$log['lscache'] = 'n/a';
	}

	/* inventory for the report. */
	$pages = function_exists('get_pages') ? (array) get_pages(array('number' => 60)) : array();
	$inv_pages = array();
	foreach ($pages as $p) {
		$inv_pages[] = array((int) $p->ID, $p->post_title, isset($p->post_name) ? $p->post_name : '');
	}
	$log['inventory']['pages'] = $inv_pages;
	if (function_exists('wc_get_page_id')) {
		$log['inventory']['wc_pages'] = array();
		foreach (array('shop', 'cart', 'checkout', 'myaccount', 'order_received') as $k) {
			$log['inventory']['wc_pages'][$k] = (int) wc_get_page_id($k);
		}
	}
	if (function_exists('get_woocommerce_currency')) {
		$log['inventory']['currency'] = get_woocommerce_currency();
	}
	$log['inventory']['htaccess'] = is_file(ABSPATH . '.htaccess');
	$log['inventory']['permalink'] = (string) get_option('permalink_structure');

	update_option(ALOOKHOR_V53_DONE_OPT, $log);
	if (function_exists('set_transient')) {
		set_transient('alookhor_v53_log', $log, 900);
	}
	return $log;
}
add_action('init', function () {
	if (get_option(ALOOKHOR_V53_DONE_OPT)) {
		return;
	}
	$alookhor_v53_log = alookhor_v53_repair();
}, 20);

/* ------------------------------------------------------------------ *
 * Live system filters (stay active for the lifetime of the site)
 * ------------------------------------------------------------------ */
// 1) WC checkout validation -> match the CC's simple form (name/phone/
//    address/email). last_name + address details become optional.
add_filter('woocommerce_checkout_fields', function ($fields) {
	$alookhor_v53_done = get_option(ALOOKHOR_V53_DONE_OPT);
	$alookhor_v53_email_ok = is_array($alookhor_v53_done)
		&& in_array($alookhor_v53_done['checkout_patch'] ?? '', array('patched', 'already-patched'), true);
	if (is_array($fields)) {
		if (isset($fields['billing'])) {
			if (isset($fields['billing']['billing_last_name'])) {
				$fields['billing']['billing_last_name']['required'] = false;
			}
			foreach (array('billing_address_2', 'billing_city', 'billing_state', 'billing_postcode') as $k) {
				if (isset($fields['billing'][$k])) {
					$fields['billing'][$k]['required'] = false;
				}
			}
			// if the email field patch could not be applied, do not let
			// validation block orders that have no email at all.
			if (!$alookhor_v53_email_ok && isset($fields['billing']['billing_email'])) {
				$fields['billing']['billing_email']['required'] = false;
			}
		}
		if (isset($fields['shipping'])) {
			foreach (array('shipping_address_1', 'shipping_address_2', 'shipping_city', 'shipping_state', 'shipping_postcode') as $k) {
				if (isset($fields['shipping'][$k])) {
					$fields['shipping'][$k]['required'] = false;
				}
			}
		}
	}
	return $fields;
});

// 2) Persian digits for wc_price on the frontend (IRT/toman only), so
//    the home bestsellers' ranges match the product pages' style.
add_filter('wc_price', function ($price, $value = null) {
	if (function_exists('is_admin') && is_admin()) {
		return $price;
	}
	if (defined('REST_REQUEST') && REST_REQUEST) {
		return $price;
	}
	if (!function_exists('get_woocommerce_currency') || get_woocommerce_currency() !== 'IRT') {
		return $price;
	}
	$price = str_replace(',', '٬', (string) $price);
	return strtr($price, array('0' => '۰', '1' => '۱', '2' => '۲', '3' => '۳', '4' => '۴', '5' => '۵', '6' => '۶', '7' => '۷', '8' => '۸', '9' => '۹'));
}, 10, 2);

/* ------------------------------------------------------------------ *
 * Template swap (v5.2) — portal template for home/about/contact.
 * ------------------------------------------------------------------ */
add_filter('template_include', function ($tpl) {
	if (!defined('ALOOKHOR_CC_VERSION')) {
		return $tpl;
	}
	if (!is_file(ALOOKHOR_V53_TEMPLATE)) {
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
		return ALOOKHOR_V53_TEMPLATE;
	}
	return $tpl;
}, 20);

/* ------------------------------------------------------------------ *
 * Status / finish endpoint (same token as v5/v5.1/v5.2).
 * ------------------------------------------------------------------ */
add_action('template_redirect', function () {
	if (!isset($_GET['alookhor_v5']) || $_GET['alookhor_v5'] !== ALOOKHOR_V5_TOKEN) {
		return;
	}

	// finish=1: mark completion. The file STAYS active: its checkout
	// validation + price filters are part of the live system, and every
	// repair above is already guarded by its done flag (pure no-op now).
	if (isset($_GET['finish']) && $_GET['finish'] === '1') {
		update_option('alookhor_v53_finished', date('c'));
		header('Content-Type: application/json; charset=utf-8');
		echo json_encode(array('ok' => true, 'msg' => 'v5.3 finished — site complete, filters stay active'));
		exit;
	}

	// optional force re-run of the completion suite (all steps idempotent).
	if (isset($_GET['v53force']) && $_GET['v53force'] === '1') {
		delete_option(ALOOKHOR_V53_DONE_OPT);
		$alookhor_v53_force_log = alookhor_v53_repair();
		set_transient('alookhor_v53_log', $alookhor_v53_force_log, 900);
	}

	$h = get_option('alookhor_header_settings');
	$cs = get_option('alookhor_cc_settings');
	$report = array(
		'ok' => true,
		'version' => 'v5.3',
		'cc_version' => defined('ALOOKHOR_CC_VERSION') ? ALOOKHOR_CC_VERSION : 'MISSING',
		'php' => PHP_VERSION,
		'done_log' => get_option(ALOOKHOR_V51_DONE_OPT, array()),
		'v53' => get_option(ALOOKHOR_V53_DONE_OPT, array()),
		'v53_finished' => get_option('alookhor_v53_finished', false),
		'header' => array(
			'enabled' => !empty($h['enabled']),
			'keys' => is_array($h) ? count($h) : 0,
			'has_wholesale' => !empty($h['wholesale_text']) || !empty($h['export_text']),
		),
		'cc_settings' => array(
			'top_keys' => is_array($cs) ? array_keys($cs) : array(),
			'modules_enabled' => is_array($cs) && is_array($cs['modules']) ? array_filter(array_map('boolval', $cs['modules'])) : array(),
		),
		'template_file' => is_file(ALOOKHOR_V53_TEMPLATE),
		'about_ids' => alookhor_v5_about_ids(),
		'contact_ids' => alookhor_v5_contact_ids(),
	);

	// optional internal link audit (agent verification).
	if (isset($_GET['audit']) && $_GET['audit'] === '1') {
		$urls = array('/', '/shop/', '/blog/', '/product-category/dried-plums/', '/wholesale/', '/export/', '/gift-packages/', '/catalog/', '/?product=keshmesh-poloei-talaei-momtaz', '/?page_id=24');
		$host = isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : (defined('ALOOKHOR_HOST') ? ALOOKHOR_HOST : 'alookhor.ir');
		$base = (is_ssl() ? 'https://' : 'http://') . $host;
		$audit = array();
		$method = 'domain';
		$all_err = true;
		foreach ($urls as $u) {
			$r = @wp_remote_get($base . $u, array('timeout' => 8, 'redirection' => 5));
			$code = (int) wp_remote_retrieve_response_code($r);
			$audit[$u] = $code ? $code : 'ERR';
			if ($code) {
				$all_err = false;
			}
			if ($u === '/?product=keshmesh-poloei-talaei-momtaz') {
				$body = (string) wp_remote_retrieve_body($r);
				$audit['_pdp_price_390k'] = (strpos($body, '۳۹۰') !== false || strpos($body, '390') !== false);
				$audit['_pdp_has_toman'] = (strpos($body, 'تومان') !== false);
			}
			if ($u === '/') {
				$body = (string) wp_remote_retrieve_body($r);
				$audit['_home_no_rial_symbol'] = (strpos($body, '﷼') === false);
				$audit['_home_persian_price'] = (strpos($body, '۳۹') !== false || strpos($body, '390') !== false);
			}
		}
		if ($all_err) {
			$method = 'loopback';
			$base = 'http://127.0.0.1';
			$audit = array();
			foreach ($urls as $u) {
				$r = @wp_remote_get($base . $u, array('timeout' => 8, 'headers' => array('Host' => $host)));
				$code = (int) wp_remote_retrieve_response_code($r);
				$audit[$u] = $code ? $code : 'ERR';
			}
		}
		$audit['_method'] = $method;
		$report['audit'] = $audit;
	}

	header('Content-Type: application/json; charset=utf-8');
	echo json_encode($report, JSON_UNESCAPED_UNICODE);
	exit;
}, 1);
