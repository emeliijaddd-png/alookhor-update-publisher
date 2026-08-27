<?php
if (!defined('ABSPATH')) exit;

// ——— منوی مدیریت ———
add_action('admin_menu', function(){
    add_menu_page(
        'ALOOKHOR Control Center',
        'ALOOKHOR Center',
        'manage_options',
        'alookhor-control-center',
        'alookhor_cc_render_admin',
        'dashicons-star-filled', // آیکن لوکس
        2
    );
    add_submenu_page('alookhor-control-center', 'داشبورد', 'داشبورد', 'manage_options', 'alookhor-control-center', 'alookhor_cc_render_admin');
    // v3.10.66: زیرمنوی قدیمی «نوار بالای سایت و هدر» حذف شد — تنظیمات هدر AKX
    // (۱۴ فیلد) داخل ALOOKHOR Center → مدیریت بوتیک → هدر مدیریت می‌شود.
});

// ——— لود استایل/اسکریپت فقط در صفحه کنترل سنتر ———
add_action('admin_enqueue_scripts', function($hook){
    if(strpos($hook, 'alookhor') === false) return;
    wp_enqueue_media();
    wp_enqueue_style('alookhor-cc-luxury', ALOOKHOR_CC_URL . 'assets/css/luxury.css', [], ALOOKHOR_CC_BUILD);
    wp_enqueue_style('alookhor-cc-admin', ALOOKHOR_CC_URL . 'assets/css/luxury.css', [], ALOOKHOR_CC_BUILD);
    // فونت لوکس
    wp_enqueue_style('alookhor-cc-fonts', 'https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@500;600;700&family=Inter:wght@400;500;600;700&display=swap', [], null);

    // NOTE: config.js is ES Module — DO NOT enqueue as regular script (caused SyntaxError: Unexpected token 'export')
    // It is imported via app.js as module: import { Config } from './core/config.js'
    // نصب از URL nonceدار Core Upgrader انجام می‌شود؛ مستقل از DOM صفحه Plugins.
    // admin-wp.js remains the bridge; app.js and its dependencies stay ES Modules.
    wp_enqueue_script('alookhor-cc-admin-js', ALOOKHOR_CC_URL . 'assets/js/admin-wp.js', ['jquery'], ALOOKHOR_CC_BUILD, true);
    $category_terms = taxonomy_exists('product_cat') ? get_terms(['taxonomy'=>'product_cat','hide_empty'=>false,'orderby'=>'name']) : [];
    if (is_wp_error($category_terms)) $category_terms=[];
    wp_localize_script('alookhor-cc-admin-js', 'ALOOKHOR_CC', [
        'ajax_url' => admin_url('admin-ajax.php'),
        'nonce' => wp_create_nonce('alookhor_cc_nonce'),
        'site_json_url' => ALOOKHOR_CC_URL . 'config/site.json',
        'version' => ALOOKHOR_CC_VERSION,
        'plugin_file' => ALOOKHOR_CC_PLUGIN_BASENAME,
        'plugin_slug' => 'alookhor-control-center',
        'native_update_url' => wp_nonce_url(
            self_admin_url('update.php?action=upgrade-plugin&plugin=' . rawurlencode(ALOOKHOR_CC_PLUGIN_BASENAME)),
            'upgrade-plugin_' . ALOOKHOR_CC_PLUGIN_BASENAME
        ),
        'updater_configured' => (bool) alookhor_cc_update_manifest_url(),
        'header_shortcode' => '[alookhor_portal_header]',
        'export_banner_shortcode' => '[alookhor_export_banner]',
        'export_banner_settings' => function_exists('alookhor_cc_get_export_banner_settings') ? alookhor_cc_get_export_banner_settings() : [],
        'hero_shortcode' => '[alookhor_managed_hero]',
        'feature_shortcode' => '[alookhor_managed_features]',
        'home_url' => home_url('/'),
        'footer_menus' => array_map(function($menu){
            return ['id' => (int) $menu->term_id, 'name' => $menu->name];
        }, wp_get_nav_menus(['orderby' => 'term_order'])),
        'wc_categories' => array_map(function($term){
            return ['id'=>(int)$term->term_id,'name'=>$term->name,'slug'=>$term->slug,'count'=>(int)$term->count,'parent'=>(int)$term->parent];
        }, $category_terms),
        'post_categories' => array_map(function($term){return ['id'=>(int)$term->term_id,'name'=>$term->name];},get_categories(['hide_empty'=>false])),
    ]);
});

// ——— رندر صفحه اصلی کنترل سنتر ———
function alookhor_cc_render_admin(){
    // چک دسترسی
    if(!current_user_can('manage_options')) return;
    $settings = alookhor_cc_get_settings();
    $header = alookhor_cc_get_header_settings();
    // یک صفحه فول‌اسکرین لوکس
    ?>
    <div class="wrap" style="margin:0; padding:0; background:#070708; margin-left:-20px; margin-top:-10px;">
        <style>
            #wpcontent{padding-left:0 !important; background:#070708}
            #wpfooter{display:none}
            .alookhor-wp-topbar{position:sticky; top:32px; z-index:10; background: linear-gradient(180deg, rgba(17,17,19,0.96), rgba(17,17,19,0.88)); border-bottom:1px solid rgba(201,168,106,0.14); backdrop-filter: blur(12px); padding:10px 20px; display:flex; align-items:center; gap:12px; color:#F5F1E9}
            @media(max-width:782px){.alookhor-wp-topbar{top:46px}}
            .alookhor-wp-topbar .dot{width:8px; height:8px; border-radius:50%; background:#3DD68C; box-shadow:0 0 0 4px rgba(61,214,140,0.15)}
        </style>
        <div class="alookhor-wp-topbar">
            <span class="dot"></span>
            <b style="letter-spacing:.06em; font-family:'Cormorant Garamond',serif">ALOOKHOR Control Center</b>
            <span style="opacity:.5">•</span>
            <span style="font-size:12px; color:#9A9590">v<?php echo esc_html(ALOOKHOR_CC_VERSION); ?> — نصب شده و فعال</span>
            <span style="margin-left:auto; display:flex; gap:8px; align-items:center">
                <code dir="ltr" style="background:rgba(255,255,255,0.06); border:1px solid rgba(201,168,106,0.14); padding:4px 8px; border-radius:8px; color:#E8D5B5; font-size:11px">[alookhor_portal_header]</code>
                <code dir="ltr" style="background:rgba(255,255,255,0.06); border:1px solid rgba(201,168,106,0.14); padding:4px 8px; border-radius:8px; color:#E8D5B5; font-size:11px">[alookhor_export_banner]</code>
                <span style="font-size:11px; color:#9A9590">هدر المنتوری شما</span>
                <a href="<?php echo esc_url(home_url('/')); ?>" target="_blank" style="background:linear-gradient(135deg,#C9A86A,#B8935A); color:#1A1206; padding:7px 12px; border-radius:999px; font-weight:700; font-size:12px; text-decoration:none">نمایش سایت</a>
            </span>
        </div>
        <?php
        // لود قالب کنترل سنتر (همون index.html اما با مسیرهای وردپرسی)
        $template = ALOOKHOR_CC_DIR . 'templates/admin-control-center.php';
        if(file_exists($template)) include $template;
        else echo '<div style="padding:40px; color:#fff">Template not found</div>';
        ?>
    </div>
    <?php
}
