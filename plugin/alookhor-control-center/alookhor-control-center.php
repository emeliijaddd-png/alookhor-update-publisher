<?php
/**
 * Plugin Name: ALOOKHOR Control Center
 * Plugin URI: https://alookhor.ir
 * Description: کنترل سنتر لوکس و ماژولار آلوخور — مدیریت کامل سایت (هدر، اسلایدر، سورت، محصولات، مشتریان VIP، مالی، آنالیتیکس) با آپدیت آنی بدون رفرش. تمام تنظیمات چت قبلی + شورت‌کد [alookhor_portal_header] اینجا مدیریت می‌شود.
 * Version: 3.8.7
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

define('ALOOKHOR_CC_VERSION', '3.8.7');
define('ALOOKHOR_CC_BUILD', '3.8.7');
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

// ——— Enqueue برای فرانت (هدر لوکس، کاملاً Scoped) ———
// فایل کامل luxury.css مخصوص کنترل سنتر است و نباید body/theme فرانت را override کند.
add_action('wp_enqueue_scripts', function(){
    if (!empty($GLOBALS['alookhor_cc_legacy_header_provider'])) {
        // خروجی و CSS هدر قدیمی دست‌نخورده می‌ماند؛ فقط مقادیر Top Bar مدیریت می‌شوند.
        $h = alookhor_cc_front_header_settings();
        wp_enqueue_script('alookhor-cc-legacy-topbar-manager', ALOOKHOR_CC_URL . 'assets/js/frontend-topbar-manager.js', [], ALOOKHOR_CC_BUILD, true);
        wp_localize_script('alookhor-cc-legacy-topbar-manager', 'ALOOKHOR_TOPBAR', [
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

    foreach (['site', 'modules', 'system', 'ai_assistant', 'header_settings'] as $required_key) {
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
        'gold' => $s['site']['goldAccent'] ?? '#C9A86A',
        'sticky' => true,
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
        'topbar_bg' => '#11091D',
        'topbar_text_color' => '#E8D5B5',
        'topbar_border_color' => '#3A2C20',
        'topbar_button_bg' => '#C9A86A',
        'topbar_button_text' => '#1A1206',
        'topbar_height' => 38,
        'top_logo_width' => 96,
        'account_text' => 'ورود / ثبت‌نام',
        'primary_menu' => 0,
    ];
    return wp_parse_args($h, $defaults);
}
