<?php
/**
 * Plugin Name: ALOOKHOR Control Center
 * Plugin URI: https://alookhor.ir
 * Description: کنترل سنتر لوکس و ماژولار آلوخور.
 * Version: 3.10.407
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

define('ALOOKHOR_CC_VERSION', '3.10.407');
define('ALOOKHOR_CC_BUILD', '3.10.407');
define('ALOOKHOR_CC_FILE', __FILE__);
define('ALOOKHOR_CC_DIR', plugin_dir_path(__FILE__));
define('ALOOKHOR_CC_URL', plugin_dir_url(__FILE__));
define('ALOOKHOR_CC_OPTION', 'alookhor_cc_settings');
define('ALOOKHOR_CC_HEADER_OPTION', 'alookhor_header_settings');
define('ALOOKHOR_CC_PLUGIN_BASENAME', plugin_basename(__FILE__));

register_activation_hook(__FILE__, function(){
    $file = ALOOKHOR_CC_DIR . 'config/site.json';
    if (file_exists($file)) {
        $json = json_decode(file_get_contents($file), true);
        if (is_array($json) && $json) {
            if (!get_option(ALOOKHOR_CC_OPTION)) update_option(ALOOKHOR_CC_OPTION, $json);
            if (!get_option(ALOOKHOR_CC_HEADER_OPTION) && !empty($json['header_settings'])) update_option(ALOOKHOR_CC_HEADER_OPTION, $json['header_settings']);
        }
    }
    flush_rewrite_rules();
});

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
    $settings = array_replace_recursive($defaults, $saved);
    foreach (['site','modules','system','ai_assistant','header_settings','footer_settings','category_settings','hero_settings','feature_settings','sort_center_settings','featured_product_settings','campaign_settings','bestseller_settings','newsletter_settings','magazine_settings','why_settings','standards_settings'] as $key) {
        if (!isset($settings[$key]) || !is_array($settings[$key])) $settings[$key] = (isset($defaults[$key]) && is_array($defaults[$key])) ? $defaults[$key] : [];
    }
    $settings['version'] = ALOOKHOR_CC_VERSION;
    if ($settings !== $saved) update_option(ALOOKHOR_CC_OPTION, $settings);
    return $settings;
}

function alookhor_cc_get_header_settings(){
    $s = alookhor_cc_get_settings();
    $saved = get_option(ALOOKHOR_CC_HEADER_OPTION, []);
    if (!is_array($saved)) $saved = [];
    $defaults = [
        'logo_text' => $s['header_settings']['logo_text'] ?? 'آلوخور',
        'logo_sub' => $s['header_settings']['logo_sub'] ?? 'پایتخت تولید آلو خشک ایران',
        'logo_letter' => 'آ',
        'gold' => '#D49A2E',
        'header_surface' => '#0D0510', 'header_text_color' => '#F5F3F0', 'header_muted_color' => '#C8C2C9',
        'capsule_background' => '#0D0510', 'capsule_card' => '#1C1024', 'capsule_glass' => 'rgba(33,20,38,.75)',
        'capsule_gold' => '#D49A2E', 'capsule_gold_light' => '#E8B84A', 'capsule_text' => '#F5F3F0', 'capsule_muted' => '#C8C2C9', 'capsule_blur' => 24,
        'header_logo_desktop_width' => 118, 'header_logo_mobile_width' => 58, 'sticky' => true, 'show_search' => false,
        'search_placeholder' => 'جستجوی محصول…', 'show_topbar' => true, 'show_account' => true, 'show_contact' => true,
        'show_phone' => true, 'show_email' => true, 'show_whatsapp' => true, 'show_export' => true, 'show_wholesale' => true,
        'email' => sanitize_email(get_option('admin_email')), 'phone' => '09159513173', 'whatsapp' => '989222942808',
        'export_text' => 'ارسال رایگان به بیش از ۱۵ کشور جهان', 'export_url' => '', 'wholesale_text' => 'خرید عمده آلو بخارا',
        'wholesale_url' => home_url('/#b2b'), 'wholesale_new_tab' => false, 'top_logo_url' => '', 'top_logo_alt' => get_bloginfo('name'),
        'top_logo_link' => home_url('/'), 'topbar_bg' => '#1C1024', 'topbar_text_color' => '#F5F3F0', 'topbar_border_color' => '#D49A2E',
        'topbar_button_bg' => '#D49A2E', 'topbar_button_text' => '#0D0510', 'topbar_height' => 38, 'top_logo_width' => 96,
        'account_text' => 'ورود / ثبت‌نام', 'primary_menu' => 0,
    ];
    return wp_parse_args($saved, wp_parse_args($s['header_settings'] ?? [], $defaults));
}

function alookhor_cc_front_header_settings(){ return alookhor_cc_get_header_settings(); }
function alookhor_cc_should_inline_shortcode_css(){ return !is_admin() && !wp_doing_ajax(); }

require_once ALOOKHOR_CC_DIR . 'includes/admin.php';
require_once ALOOKHOR_CC_DIR . 'includes/ajax.php';
require_once ALOOKHOR_CC_DIR . 'includes/updater.php';
require_once ALOOKHOR_CC_DIR . 'includes/rest-api.php';
require_once ALOOKHOR_CC_DIR . 'includes/shortcode-header.php';
require_once ALOOKHOR_CC_DIR . 'includes/footer.php';
require_once ALOOKHOR_CC_DIR . 'includes/product-categories.php';
require_once ALOOKHOR_CC_DIR . 'includes/hero.php';
require_once ALOOKHOR_CC_DIR . 'includes/site-features.php';
require_once ALOOKHOR_CC_DIR . 'includes/sort-center.php';
require_once ALOOKHOR_CC_DIR . 'includes/app-banner.php';
require_once ALOOKHOR_CC_DIR . 'includes/featured-products.php';
require_once ALOOKHOR_CC_DIR . 'includes/campaign-slider.php';
require_once ALOOKHOR_CC_DIR . 'includes/bestselling-products.php';
require_once ALOOKHOR_CC_DIR . 'includes/newsletter.php';
require_once ALOOKHOR_CC_DIR . 'includes/magazine.php';
require_once ALOOKHOR_CC_DIR . 'includes/why-alookhor.php';
require_once ALOOKHOR_CC_DIR . 'includes/international-standards.php';
require_once ALOOKHOR_CC_DIR . 'includes/contact-page.php';
require_once ALOOKHOR_CC_DIR . 'includes/about-page.php';
require_once ALOOKHOR_CC_DIR . 'includes/pages-settings.php';
require_once ALOOKHOR_CC_DIR . 'includes/admin-pages.php';
require_once ALOOKHOR_CC_DIR . 'includes/product-page.php';
require_once ALOOKHOR_CC_DIR . 'includes/cart-page.php';
require_once ALOOKHOR_CC_DIR . 'includes/cart-rest.php';
require_once ALOOKHOR_CC_DIR . 'includes/checkout-page.php';
require_once ALOOKHOR_CC_DIR . 'includes/product-seeder.php';
require_once ALOOKHOR_CC_DIR . 'includes/shortcode-export-banner.php';
require_once ALOOKHOR_CC_DIR . 'includes/admin-export-banner.php';
require_once ALOOKHOR_CC_DIR . 'includes/seo-cleaner.php';
require_once ALOOKHOR_CC_DIR . 'includes/seo-meta.php';
require_once ALOOKHOR_CC_DIR . 'includes/responsive-v2.php';
require_once ALOOKHOR_CC_DIR . 'includes/pdp-breadcrumb-fix.php';

add_filter('show_admin_bar', '__return_false');
add_action('wp_head', function(){ echo '<style id="alookhor-hide-adminbar">html{margin-top:0!important;padding-top:0!important}#wpadminbar{display:none!important}</style>'; }, 5);
add_action('wp_enqueue_scripts', function(){
    wp_enqueue_style('alookhor-cc-managed-layout', ALOOKHOR_CC_URL.'assets/css/frontend-managed-layout.css', [], ALOOKHOR_CC_BUILD);
    wp_enqueue_script('alookhor-cc-managed-layout', ALOOKHOR_CC_URL.'assets/js/frontend-managed-layout.js', [], ALOOKHOR_CC_BUILD, true);
    wp_enqueue_style('alookhor-cc-design-system', ALOOKHOR_CC_URL.'assets/css/frontend-design-system.css', ['alookhor-cc-managed-layout'], ALOOKHOR_CC_BUILD);
}, 99);
add_action('wp_enqueue_scripts', function(){
    $h = alookhor_cc_front_header_settings();
    wp_enqueue_style('alookhor-cc-front', ALOOKHOR_CC_URL.'assets/css/frontend-header.css', [], ALOOKHOR_CC_BUILD);
    wp_enqueue_style('alookhor-cc-luxury-new', ALOOKHOR_CC_URL.'assets/css/frontend-header-luxury-new.css', [], ALOOKHOR_CC_BUILD);
    wp_enqueue_script('alookhor-cc-front-header', ALOOKHOR_CC_URL.'assets/js/frontend-header.js', [], ALOOKHOR_CC_BUILD, true);
    wp_localize_script('alookhor-cc-front-header', 'ALOOKHOR_TOPBAR', ['endpoint'=>rest_url('alookhor-cc/v1/topbar'),'version'=>ALOOKHOR_CC_VERSION,'home_url'=>home_url('/'),'cart_url'=>function_exists('wc_get_cart_url')?wc_get_cart_url():home_url('/cart/'),'cart_count'=>function_exists('WC')&&WC()->cart?(int)WC()->cart->get_cart_contents_count():0] + $h);
}, 99);
