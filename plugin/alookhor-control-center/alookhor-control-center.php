<?php
/**
 * Plugin Name: ALOOKHOR Control Center
 * Plugin URI: https://alookhor.ir
 * Description: کنترل سنتر لوکس و ماژولار آلوخور — مدیریت کامل سایت (هدر، اسلایدر، سورت، محصولات، مشتریان VIP، مالی، آنالیتیکس) با آپدیت آنی بدون رفرش. تمام تنظیمات چت قبلی + شورت‌کد [alookhor_portal_header] اینجا مدیریت می‌شود.
 * Version: 3.10.209
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

define('ALOOKHOR_CC_VERSION', '3.10.209');
define('ALOOKHOR_CC_BUILD', '3.10.209');
define('ALOOKHOR_CC_FILE', __FILE__);
define('ALOOKHOR_CC_DIR', plugin_dir_path(__FILE__));
define('ALOOKHOR_CC_URL', plugin_dir_url(__FILE__));
define('ALOOKHOR_CC_OPTION', 'alookhor_cc_settings');
define('ALOOKHOR_CC_HEADER_OPTION', 'alookhor_header_settings');
define('ALOOKHOR_CC_PLUGIN_BASENAME', plugin_basename(__FILE__));

/**
 * Inline CSS is useful in normal shortcode output, but Elementor renders many
 * widgets inside one admin-ajax request. Repeating full stylesheets there can
 * exhaust response/memory limits and cause HTTP 500 while saving.
 */
function alookhor_cc_should_inline_shortcode_css(){
    if (is_admin() || wp_doing_ajax()) return false;
    if (isset($_REQUEST['action']) && str_contains(sanitize_key(wp_unslash($_REQUEST['action'])), 'elementor')) return false;
    return true;
}

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
require_once ALOOKHOR_CC_DIR . 'includes/shortcode-export-banner.php';
require_once ALOOKHOR_CC_DIR . 'includes/admin-export-banner.php';

/* v3.10.183 — hide the WP admin bar on the frontend (owner: unwanted near-black bar on top, mobile+desktop).
   The dashboard stays fully reachable via wp-admin; only the frontend strip is removed. */
add_filter('show_admin_bar', '__return_false');
add_action('wp_head', function(){echo '<style id="alookhor-hide-adminbar">html{margin-top:0!important;padding-top:0!important}#wpadminbar{display:none!important}</style>'."\n";}, 5);
// v3.10.66: admin-header-manager.php حذف شد — تنظیمات هدر AKX داخل مدیریت بوتیک است.

// حذف فاصله‌های سفید رزروشده Elementor فقط برای کانتینرهای میزبان شورت‌کدهای مدیریت‌شده.
add_action('wp_enqueue_scripts',function(){
    wp_enqueue_style('alookhor-cc-managed-layout',ALOOKHOR_CC_URL.'assets/css/frontend-managed-layout.css',[],ALOOKHOR_CC_BUILD);
    wp_enqueue_script('alookhor-cc-managed-layout',ALOOKHOR_CC_URL.'assets/js/frontend-managed-layout.js',[],ALOOKHOR_CC_BUILD,true);
},99);

// MASTER DESIGN DIRECTIVE — لایه نهایی و مرکزی پالت/ریتم تمام ماژول‌های فرانت.
add_action('wp_enqueue_scripts',function(){
    wp_enqueue_style('alookhor-cc-design-system',ALOOKHOR_CC_URL.'assets/css/frontend-design-system.css',['alookhor-cc-managed-layout'],ALOOKHOR_CC_BUILD);
},999);

// ——— Enqueue برای فرانت (هدر لوکس، کاملاً Scoped) ———
// فایل کامل luxury.css مخصوص کنترل سنتر است و نباید body/theme فرانت را override کند.
add_action('wp_enqueue_scripts', function(){
    // اگر هدر حرفه‌ای AKX فعال است، از لود فایل‌های قدیمی صرف‌نظر می‌کنیم
    $akx_h = get_option(ALOOKHOR_CC_HEADER_OPTION, []);
    if (!empty($akx_h['enabled'])) {
        return;
    }

    if (!empty($GLOBALS['alookhor_cc_legacy_header_provider'])) {
        // خروجی و CSS هدر قدیمی دست‌نخورده می‌ماند؛ فقط مقادیر Top Bar مدیریت می‌شوند.
        $h = alookhor_cc_front_header_settings();
        // Load in <head>: the observer can hide stale legacy markup before the
        // browser paints it, then reveal only freshly synchronized Top Bar data.
        wp_enqueue_style('alookhor-cc-legacy-header-scroll', ALOOKHOR_CC_URL . 'assets/css/frontend-header-scroll.css', [], ALOOKHOR_CC_BUILD);
        wp_enqueue_style('alookhor-cc-luxury-new', ALOOKHOR_CC_URL . 'assets/css/frontend-header-luxury-new.css', [], ALOOKHOR_CC_BUILD);
        wp_enqueue_script('alookhor-cc-legacy-topbar-manager', ALOOKHOR_CC_URL . 'assets/js/frontend-topbar-manager.js', [], ALOOKHOR_CC_BUILD, false);
        wp_localize_script('alookhor-cc-legacy-topbar-manager', 'ALOOKHOR_TOPBAR', [
            'endpoint' => rest_url('alookhor-cc/v1/topbar'),
            'version' => ALOOKHOR_CC_VERSION,
            'home_url' => home_url('/'),
            'cart_url' => function_exists('wc_get_cart_url') ? wc_get_cart_url() : home_url('/cart/'),
            'cart_count' => function_exists('WC') && WC()->cart ? (int) WC()->cart->get_cart_contents_count() : 0,
            'logo_text' => $h['logo_text'],
            'gold' => $h['gold'],
            'sticky' => (bool) $h['sticky'],
            'show_search' => (bool) $h['show_search'],
            'search_placeholder' => $h['search_placeholder'],
            'header_surface' => $h['header_surface'],
            'header_text_color' => $h['header_text_color'],
            'header_muted_color' => $h['header_muted_color'],
            'capsule_background' => $h['capsule_background'],
            'capsule_card' => $h['capsule_card'],
            'capsule_glass' => $h['capsule_glass'],
            'capsule_gold' => $h['capsule_gold'],
            'capsule_gold_light' => $h['capsule_gold_light'],
            'capsule_text' => $h['capsule_text'],
            'capsule_muted' => $h['capsule_muted'],
            'capsule_blur' => (int) $h['capsule_blur'],
            'header_logo_desktop_width' => (int) $h['header_logo_desktop_width'],
            'header_logo_mobile_width' => (int) $h['header_logo_mobile_width'],
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
    wp_enqueue_style('alookhor-cc-luxury-new', ALOOKHOR_CC_URL . 'assets/css/frontend-header-luxury-new.css', [], ALOOKHOR_CC_BUILD);
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

    foreach (['site', 'modules', 'system', 'ai_assistant', 'header_settings', 'footer_settings', 'category_settings', 'hero_settings', 'feature_settings', 'sort_center_settings', 'featured_product_settings', 'campaign_settings', 'bestseller_settings', 'newsletter_settings', 'magazine_settings', 'why_settings', 'standards_settings'] as $required_key) {
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
    if (function_exists('alookhor_cc_footer_defaults')) {
        $footer_saved = is_array($saved['footer_settings'] ?? null) ? $saved['footer_settings'] : [];
        $settings['footer_settings'] = array_replace_recursive(alookhor_cc_footer_defaults(), $footer_saved);
        if (!empty($settings['footer_settings']['use_header_contact']) && is_array($header_saved)) {
            foreach (['phone','email','whatsapp'] as $contact_key) {
                if (array_key_exists($contact_key,$header_saved)) $settings['footer_settings'][$contact_key]=$header_saved[$contact_key];
            }
        }
    }
    if (function_exists('alookhor_cc_category_defaults')) {
        $category_saved = is_array($saved['category_settings'] ?? null) ? $saved['category_settings'] : [];
        $settings['category_settings'] = array_replace_recursive(alookhor_cc_category_defaults(), $category_saved);
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
        'gold' => $s['site']['goldAccent'] ?? '#D49A2E',
        'header_surface' => '#0D0510',
        'header_text_color' => '#F5F3F0',
        'header_muted_color' => '#C8C2C9',
        'capsule_background' => '#0D0510',
        'capsule_card' => '#1C1024',
        'capsule_glass' => 'rgba(33,20,38,.75)',
        'capsule_gold' => '#D49A2E',
        'capsule_gold_light' => '#E8B84A',
        'capsule_text' => '#F5F3F0',
        'capsule_muted' => '#C8C2C9',
        'capsule_blur' => 24,
        'header_logo_desktop_width' => 118,
        'header_logo_mobile_width' => 58,
        'sticky' => true,
        'show_search' => false,
        'search_placeholder' => 'جستجوی محصول…',
        'show_topbar' => true,
        'show_account' => true,
        'show_contact' => true,
        'show_phone' => true,
        'show_email' => true,
        'show_whatsapp' => true,
        'show_export' => true,
        'show_wholesale' => true,
        'email' => sanitize_email(get_option('admin_email')),
        'phone' => '09159513173',
        'whatsapp' => '989222942808',
        'export_text' => 'ارسال رایگان به بیش از ۱۵ کشور جهان',
        'export_url' => '',
        'wholesale_text' => 'خرید عمده آلو بخارا',
        'wholesale_url' => home_url('/#b2b'),
        'wholesale_new_tab' => false,
        'top_logo_url' => '',
        'top_logo_alt' => get_bloginfo('name'),
        'top_logo_link' => home_url('/'),
        'topbar_bg' => '#1C1024',
        'topbar_text_color' => '#F5F3F0',
        'topbar_border_color' => '#D49A2E',
        'topbar_button_bg' => '#D49A2E',
        'topbar_button_text' => '#0D0510',
        'topbar_height' => 38,
        'top_logo_width' => 96,
        'account_text' => 'ورود / ثبت‌نام',
        'primary_menu' => 0,
    ];
    return wp_parse_args($h, $defaults);
}

/**
 * One-time 3.10.12 migration requested by the site owner: restore the verified
 * ALOOKHOR Black/Gold Header palette (not the orange/green reference colors)
 * and the authoritative contact phone ending in 3173. Every unrelated Header
 * value remains untouched.
 */
function alookhor_cc_migrate_header_brand_3106(){
    $main = get_option(ALOOKHOR_CC_OPTION, []);
    if (!is_array($main)) $main = [];
    if (!empty($main['_migrations']['header_brand_3106']['ok'])) return;

    $header = get_option(ALOOKHOR_CC_HEADER_OPTION, []);
    if (!is_array($header)) $header = [];
    $before_hash = hash('sha256', wp_json_encode($header));
    $target = [
        'phone' => '09159513173',
        'gold' => '#C9A86A',
        'topbar_bg' => '#11091D',
        'topbar_text_color' => '#E8D5B5',
        'topbar_border_color' => '#3A2C20',
        'topbar_button_bg' => '#C9A86A',
        'topbar_button_text' => '#1A1206',
        'header_surface' => '#0D0916',
        'header_text_color' => '#F7F2EA',
        'header_muted_color' => '#B8B0BD',
        'header_logo_desktop_width' => 118,
        'header_logo_mobile_width' => 58,
        'sticky' => true,
        'show_search' => true,
        'search_placeholder' => 'جستجوی محصول…',
    ];
    $header = array_replace($header, $target);
    update_option(ALOOKHOR_CC_HEADER_OPTION, $header);

    $main_header = is_array($main['header_settings'] ?? null) ? $main['header_settings'] : [];
    $main['header_settings'] = array_replace($main_header, $target);
    $main['_migrations']['header_brand_3106'] = [
        'ok' => true,
        'version' => '3.10.6',
        'fields' => array_keys($target),
        'before_hash' => $before_hash,
        'after_hash' => hash('sha256', wp_json_encode($header)),
        'checked_at' => time(),
    ];
    update_option(ALOOKHOR_CC_OPTION, $main);
}
add_action('init', 'alookhor_cc_migrate_header_brand_3106', 120);

/** Remove the rejected Header search and record the Mobile layout correction. */
function alookhor_cc_migrate_header_layout_3107(){
    $main = get_option(ALOOKHOR_CC_OPTION, []);
    if (!is_array($main)) $main = [];
    if (!empty($main['_migrations']['header_layout_3107']['ok'])) return;
    $header = get_option(ALOOKHOR_CC_HEADER_OPTION, []);
    if (!is_array($header)) $header = [];
    $header['show_search'] = false;
    update_option(ALOOKHOR_CC_HEADER_OPTION, $header);
    $main_header = is_array($main['header_settings'] ?? null) ? $main['header_settings'] : [];
    $main_header['show_search'] = false;
    $main['header_settings'] = $main_header;
    $main['_migrations']['header_layout_3107'] = [
        'ok' => true,
        'version' => '3.10.7',
        'search_removed' => true,
        'mobile_extra_stage_removed' => true,
        'checked_at' => time(),
    ];
    update_option(ALOOKHOR_CC_OPTION, $main);
}
add_action('init', 'alookhor_cc_migrate_header_layout_3107', 121);

/**
 * One-time 3.10.19 owner-approved Header reference migration. Only palette
 * fields belonging to Top Bar, the second capsule and sticky Navigation are
 * updated; phone, logo, menu IDs, visibility and every unrelated option remain.
 */
function alookhor_cc_migrate_header_reference_31019(){
    $main=get_option(ALOOKHOR_CC_OPTION,[]);if(!is_array($main))$main=[];
    if(!empty($main['_migrations']['header_reference_31019']['ok']))return;
    $header=get_option(ALOOKHOR_CC_HEADER_OPTION,[]);if(!is_array($header))$header=[];
    $before_hash=hash('sha256',wp_json_encode($header));
    $target=[
        'gold'=>'#D49A2E','topbar_bg'=>'#1C1024','topbar_text_color'=>'#F5F3F0','topbar_border_color'=>'#D49A2E',
        'topbar_button_bg'=>'#D49A2E','topbar_button_text'=>'#0D0510','header_surface'=>'#0D0510',
        'header_text_color'=>'#F5F3F0','header_muted_color'=>'#C8C2C9','capsule_background'=>'#0D0510',
        'capsule_card'=>'#1C1024','capsule_glass'=>'rgba(33,20,38,.75)','capsule_gold'=>'#D49A2E',
        'capsule_gold_light'=>'#E8B84A','capsule_text'=>'#F5F3F0','capsule_muted'=>'#C8C2C9','capsule_blur'=>24,
    ];
    $header=array_replace($header,$target);update_option(ALOOKHOR_CC_HEADER_OPTION,$header);
    $main_header=is_array($main['header_settings']??null)?$main['header_settings']:[];
    $main['header_settings']=array_replace($main_header,$target);
    if(!is_array($main['site']??null))$main['site']=[];
    $main['site']['goldAccent']='#D49A2E';
    $main['_migrations']['header_reference_31019']=['ok'=>true,'version'=>'3.10.19','fields'=>array_keys($target),'before_hash'=>$before_hash,'after_hash'=>hash('sha256',wp_json_encode($header)),'checked_at'=>time()];
    update_option(ALOOKHOR_CC_OPTION,$main);
}
add_action('init','alookhor_cc_migrate_header_reference_31019',122);

/**
 * Luxury image-accurate text migration — 3.10.19 — aligns Top Bar message and logo
 * to the owner-approved image.png (free shipping >15 countries, Persian wordmark).
 * Only text fields are touched; palette/visibility remain from previous migrations.
 */
function alookhor_cc_migrate_header_luxury_text_31019(){
    $main=get_option(ALOOKHOR_CC_OPTION,[]);if(!is_array($main))$main=[];
    if(!empty($main['_migrations']['header_luxury_text_31019']['ok']))return;
    $header=get_option(ALOOKHOR_CC_HEADER_OPTION,[]);if(!is_array($header))$header=[];
    $before_hash=hash('sha256',wp_json_encode($header));
    $target=[
        'phone'=>'09159513173',
        'export_text'=>'ارسال رایگان به بیش از ۱۵ کشور جهان',
        'logo_text'=>'آلوخور',
        'logo_sub'=>'پایتخت تولید آلو خشک ایران',
    ];
    $header=array_replace($header,$target);update_option(ALOOKHOR_CC_HEADER_OPTION,$header);
    $main_header=is_array($main['header_settings']??null)?$main['header_settings']:[];
    $main['header_settings']=array_replace($main_header,$target);
    if(!is_array($main['site']??null))$main['site']=[];
    $main['site']['name']='آلوخور';
    $main['site']['subtitle']='پایتخت تولید آلو خشک ایران';
    $main['site']['logoLetter']='آ';
    $main['site']['goldAccent']='#D49A2E';
    $main['_migrations']['header_luxury_text_31019']=['ok'=>true,'version'=>'3.10.19','fields'=>array_keys($target),'before_hash'=>$before_hash,'after_hash'=>hash('sha256',wp_json_encode($header)),'checked_at'=>time()];
    update_option(ALOOKHOR_CC_OPTION,$main);
}
add_action('init','alookhor_cc_migrate_header_luxury_text_31019',123);
