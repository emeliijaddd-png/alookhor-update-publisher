<?php
/**
 * ALOOKHOR — custom lightweight theme.
 *
 * Design blocks (header / hero / categories / features / footer) are rendered
 * and managed by the ALOOKHOR Control Center plugin. This theme only provides
 * the page skeleton, base design, and the static pages (about / contact / cart).
 * No Elementor, no Woodmart, no page-builder bloat.
 */

if (!defined('ABSPATH')) exit;

define('ALOOKHOR_THEME_VERSION', '1.0.0');

/* ---------------- setup ---------------- */
function alookhor_theme_setup()
{
	add_theme_support('title-tag');
	add_theme_support('post-thumbnails');
	add_theme_support('custom-logo');
	add_theme_support('html5', array('search-form', 'comment-form', 'comment-list', 'gallery', 'caption', 'style', 'script'));
	add_theme_support('woocommerce');
	add_theme_support('wc-product-gallery-zoom');
	add_theme_support('wc-product-gallery-lightbox');
	add_theme_support('wc-product-gallery-slider');

	register_nav_menus(array(
		'primary' => 'منوی اصلی (هدر)',
	));

	load_theme_textdomain('alookhor', get_template_directory() . '/languages');

	$GLOBALS['content_width'] = isset($GLOBALS['content_width']) ? $GLOBALS['content_width'] : 1200;
}
add_action('after_setup_theme', 'alookhor_theme_setup');

/* ---------------- assets ---------------- */
function alookhor_assets()
{
	// Persian + luxury display fonts (loaded on the visitor side via Google CDN).
	wp_enqueue_style('alookhor-fonts',
		'https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@500;600;700&family=Vazirmatn:wght@400;500;700;800&display=swap',
		array(), null);

	wp_enqueue_style('alookhor-base', get_stylesheet_uri(), array(), ALOOKHOR_THEME_VERSION);
}
add_action('wp_enqueue_scripts', 'alookhor_assets', 5);

/* ---------------- WordPress bloat removal (speed) ---------------- */
function alookhor_remove_bloat()
{
	// Emojis
	remove_action('wp_head', 'print_emoji_detection_script', 7);
	remove_action('wp_print_styles', 'print_emoji_styles');
	remove_action('admin_print_scripts', 'print_emoji_detection_script');
	remove_action('admin_print_styles', 'print_emoji_styles');

	// oEmbed / discovery / manifest / shortlink
	wp_deregister_script('wp-embed');
	remove_action('wp_head', 'wp_oembed_add_discovery_links');
	remove_action('wp_head', 'wp_oembed_add_host_js');
	remove_action('wp_head', 'wlwmanifest_link');
	remove_action('wp_head', 'rsd_link');
	remove_action('wp_head', 'wp_shortlink_wp_head');
	remove_action('wp_head', 'feed_links_extra', 3);
	remove_action('wp_head', 'feed_links', 2);

	// Generator + version
	remove_action('wp_head', 'wp_generator');
}
add_action('init', 'alookhor_remove_bloat');

/* Hide the theme version from the stylesheet link (tiny hardening). */
add_filter('style_loader_tag', function ($tag, $handle, $href) {
	return str_replace(array('/?v=' . wp_get_theme()->get('Version'), '?v=' . ALOOKHOR_THEME_VERSION), '', $tag);
}, 10, 3);

add_filter('the_generator', '__return_false');

/* Dashicons only in the admin bar, never for regular visitors. */
add_action('wp_print_styles', function () {
	if (!is_admin() && !current_user_can('view_posts')) {
		wp_dequeue_style('dashicons');
	}
}, 100);

/* ---------------- small helpers ---------------- */
function alookhor_cc_active()
{
	return defined('ALOOKHOR_CC_VERSION');
}

function alookhor_whatsapp_href($number)
{
	$number = preg_replace('/\D+/', '', (string) $number);
	if (strpos($number, '0') === 0) $number = '98' . substr($number, 1);
	return $number ? 'https://wa.me/' . $number : '';
}

function alookhor_phone_href($phone)
{
	return 'tel:' . preg_replace('/[^0-9+]/', '', (string) $phone);
}

/** Fallback menu for the minimal header: link to existing pages. */
function alookhor_fb_menu()
{
	$pages = get_pages(array('number' => 6, 'sort_column' => 'menu_order,post_title'));
	if (!$pages) return;
	echo '<ul>';
	foreach ($pages as $page) {
		echo '<li><a href="' . esc_url(get_permalink($page)) . '">' . esc_html($page->post_title) . '</a></li>';
	}
	echo '</ul>';
}
