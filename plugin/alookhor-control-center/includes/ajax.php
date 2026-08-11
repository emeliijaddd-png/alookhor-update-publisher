<?php
if (!defined('ABSPATH')) exit;

// ——— AJAX: ذخیره تنظیمات با آپدیت آنی (بدون رفرش) ———

add_action('wp_ajax_alookhor_save_settings', 'alookhor_ajax_save_settings');
add_action('wp_ajax_alookhor_toggle_module', 'alookhor_ajax_toggle_module');
add_action('wp_ajax_alookhor_save_header', 'alookhor_ajax_save_header_wp');
add_action('wp_ajax_alookhor_get_settings', 'alookhor_ajax_get_settings');

// nonce check helper
function alookhor_cc_check(){
    check_ajax_referer('alookhor_cc_nonce', 'nonce');
    if(!current_user_can('manage_options')) wp_send_json_error('دسترسی ندارید');
}

// State فقط شامل داده متنی/عددی/Boolean است؛ HTML اجرایی نباید در wp_options ذخیره شود.
function alookhor_cc_sanitize_state($value){
    if (is_array($value)) {
        $clean = [];
        foreach ($value as $key => $item) {
            $safe_key = is_int($key) ? $key : sanitize_key($key);
            $clean[$safe_key] = alookhor_cc_sanitize_state($item);
        }
        return $clean;
    }
    if (is_bool($value) || is_int($value) || is_float($value) || is_null($value)) return $value;
    return sanitize_textarea_field((string) $value);
}

function alookhor_ajax_get_settings(){
    alookhor_cc_check();
    $settings = alookhor_cc_get_settings();
    wp_send_json_success($settings);
}

function alookhor_ajax_save_settings(){
    alookhor_cc_check();
    $raw_payload = isset($_POST['payload']) ? wp_unslash($_POST['payload']) : '';
    $payload = json_decode($raw_payload, true);
    if(json_last_error() !== JSON_ERROR_NONE || empty($payload) || !is_array($payload)) {
        wp_send_json_error('payload نامعتبر');
    }
    $payload = alookhor_cc_sanitize_state($payload);

    // فیلدهای Top Bar در ذخیره پنل اصلی نیز باید با همان قرارداد فرم
    // تخصصی هدر نرمال شوند؛ Preview مرورگر منبع حقیقت نیست.
    if (!empty($payload['header_settings']) && is_array($payload['header_settings'])) {
        $header_current = get_option(ALOOKHOR_CC_HEADER_OPTION, []);
        if (!is_array($header_current)) $header_current = [];
        $header = $payload['header_settings'];
        foreach ([
            'topbar_bg' => '#11091D',
            'topbar_text_color' => '#E8D5B5',
            'topbar_border_color' => '#3A2C20',
            'topbar_button_bg' => '#C9A86A',
            'topbar_button_text' => '#1A1206',
        ] as $key => $fallback) {
            if (array_key_exists($key, $header)) {
                $header[$key] = sanitize_hex_color($header[$key]) ?: ($header_current[$key] ?? $fallback);
            }
        }
        foreach (['export_url', 'wholesale_url', 'top_logo_url', 'top_logo_link'] as $key) {
            if (array_key_exists($key, $header)) $header[$key] = esc_url_raw($header[$key]);
        }
        if (array_key_exists('email', $header)) $header['email'] = sanitize_email($header['email']);
        if (array_key_exists('whatsapp', $header)) $header['whatsapp'] = preg_replace('/\D+/', '', (string) $header['whatsapp']);
        if (array_key_exists('topbar_height', $header)) $header['topbar_height'] = max(30, min(60, absint($header['topbar_height'])));
        if (array_key_exists('top_logo_width', $header)) $header['top_logo_width'] = max(50, min(180, absint($header['top_logo_width'])));
        foreach (['sticky', 'show_topbar', 'show_contact', 'show_account', 'show_phone', 'show_email', 'show_whatsapp', 'show_export', 'show_wholesale', 'wholesale_new_tab'] as $key) {
            if (array_key_exists($key, $header)) $header[$key] = rest_sanitize_boolean($header[$key]);
        }
        $payload['header_settings'] = $header;
    }

    if (!empty($payload['footer_settings']) && is_array($payload['footer_settings'])) {
        $footer = $payload['footer_settings'];
        foreach (['background'=>'#070809','surface'=>'#0D0F10','gold'=>'#C89A3D','gold_soft'=>'#E3BD69','text'=>'#E9E5DF','muted'=>'#A7A39D','border'=>'#4A3820'] as $key=>$fallback) {
            if (array_key_exists($key,$footer)) $footer[$key] = sanitize_hex_color($footer[$key]) ?: $fallback;
        }
        foreach (['logo_url','cta_url','instagram_url','telegram_url','whatsapp_url','product_image_url','enamad_image_url','enamad_url','samandehi_image_url','samandehi_url'] as $key) {
            if (array_key_exists($key,$footer)) $footer[$key] = esc_url_raw($footer[$key]);
        }
        if (array_key_exists('email',$footer)) $footer['email'] = sanitize_email($footer['email']);
        foreach (['phone','whatsapp'] as $key) if (array_key_exists($key,$footer)) $footer[$key] = sanitize_text_field($footer[$key]);
        foreach (['enabled','hide_legacy','hide_old_newsletter','use_header_contact','newsletter_enabled','show_payments','show_benefits','show_product_image'] as $key) {
            if (array_key_exists($key,$footer)) $footer[$key] = rest_sanitize_boolean($footer[$key]);
        }
        foreach (['customer_menu_id','order_menu_id','about_menu_id'] as $key) if (array_key_exists($key,$footer)) $footer[$key] = absint($footer[$key]);
        if (array_key_exists('container_width',$footer)) $footer['container_width'] = max(960,min(1600,absint($footer['container_width'])));
        if (array_key_exists('desktop_logo_width',$footer)) $footer['desktop_logo_width'] = max(100,min(320,absint($footer['desktop_logo_width'])));
        if (array_key_exists('mobile_logo_width',$footer)) $footer['mobile_logo_width'] = max(100,min(280,absint($footer['mobile_logo_width'])));
        foreach (['customer_links','order_links','about_links'] as $group) {
            if (!isset($footer[$group]) || !is_array($footer[$group])) continue;
            $footer[$group] = array_values(array_filter(array_map(function($link){
                if (!is_array($link)) return null;
                $title = sanitize_text_field($link['title'] ?? '');
                if (!$title) return null;
                return ['title'=>$title,'url'=>esc_url_raw($link['url'] ?? '#')];
            }, $footer[$group])));
        }
        $payload['footer_settings'] = $footer;
    }

    // ذخیره کل تنظیمات
    $current = get_option(ALOOKHOR_CC_OPTION, []);
    $merged = array_replace_recursive(is_array($current) ? $current : [], $payload);
    $merged['updated_at'] = current_time('mysql');
    $merged['updated_by'] = wp_get_current_user()->user_login;
    update_option(ALOOKHOR_CC_OPTION, $merged);

    // اگر هدر داخل payload بود، فقط همان کلیدها Merge شوند؛ تنظیمات حرفه‌ای
    // Top Bar/Menu/Contact که در Option جدا هستند نباید حذف شوند.
    if(!empty($payload['header_settings']) && is_array($payload['header_settings'])){
        $header_current = get_option(ALOOKHOR_CC_HEADER_OPTION, []);
        if (!is_array($header_current)) $header_current = [];
        update_option(ALOOKHOR_CC_HEADER_OPTION, array_replace($header_current, $payload['header_settings']));
    }
    if(!empty($payload['site']['logoLetter'])){
        $h = get_option(ALOOKHOR_CC_HEADER_OPTION, []);
        if (!is_array($h)) $h = [];
        $h['logo_letter'] = $payload['site']['logoLetter'];
        update_option(ALOOKHOR_CC_HEADER_OPTION, $h);
    }

    $persisted_header = get_option(ALOOKHOR_CC_HEADER_OPTION, []);
    wp_send_json_success([
        'message' => 'ذخیره واقعی WordPress تأیید شد',
        'updated_at' => $merged['updated_at'],
        'header_settings' => is_array($persisted_header) ? [
            'phone' => $persisted_header['phone'] ?? null,
            'email' => $persisted_header['email'] ?? null,
            'whatsapp' => $persisted_header['whatsapp'] ?? null,
            'export_text' => $persisted_header['export_text'] ?? null,
            'wholesale_text' => $persisted_header['wholesale_text'] ?? null,
            'topbar_bg' => $persisted_header['topbar_bg'] ?? null,
            'topbar_text_color' => $persisted_header['topbar_text_color'] ?? null,
            'topbar_border_color' => $persisted_header['topbar_border_color'] ?? null,
            'topbar_button_bg' => $persisted_header['topbar_button_bg'] ?? null,
            'topbar_button_text' => $persisted_header['topbar_button_text'] ?? null,
            'topbar_height' => $persisted_header['topbar_height'] ?? null,
        ] : null,
        'footer_settings' => is_array($merged['footer_settings'] ?? null) ? [
            'enabled' => !empty($merged['footer_settings']['enabled']),
            'brand_name' => $merged['footer_settings']['brand_name'] ?? null,
            'phone' => $merged['footer_settings']['phone'] ?? null,
            'email' => $merged['footer_settings']['email'] ?? null,
            'background' => $merged['footer_settings']['background'] ?? null,
            'customer_menu_id' => $merged['footer_settings']['customer_menu_id'] ?? 0,
            'order_menu_id' => $merged['footer_settings']['order_menu_id'] ?? 0,
            'about_menu_id' => $merged['footer_settings']['about_menu_id'] ?? 0,
        ] : null,
    ]);
}

function alookhor_ajax_toggle_module(){
    alookhor_cc_check();
    $key = sanitize_key(wp_unslash($_POST['module'] ?? ''));
    $enabled_raw = isset($_POST['enabled']) ? wp_unslash($_POST['enabled']) : false;
    $enabled = rest_sanitize_boolean($enabled_raw);
    if(!$key) wp_send_json_error('module نامشخص');

    $settings = alookhor_cc_get_settings();
    if(!isset($settings['modules'][$key])) wp_send_json_error('ماژول یافت نشد');

    $settings['modules'][$key]['enabled'] = $enabled;
    $settings['updated_at'] = current_time('mysql');
    update_option(ALOOKHOR_CC_OPTION, $settings);

    wp_send_json_success(['message'=> $enabled ? 'ماژول فعال شد' : 'ماژول غیرفعال شد', 'enabled'=>$enabled]);
}

function alookhor_ajax_save_header_wp(){
    alookhor_cc_check();
    $current = get_option(ALOOKHOR_CC_HEADER_OPTION, []);
    if (!is_array($current)) $current = [];

    // فقط فیلدهای ارسال‌شده تغییر می‌کنند؛ sticky/search/CTA و رنگ قبلی حذف نمی‌شوند.
    $data = $current;
    $data['logo_text'] = sanitize_text_field(wp_unslash($_POST['logo_text'] ?? ($current['logo_text'] ?? 'ALOOKHOR')));
    $data['logo_sub'] = sanitize_text_field(wp_unslash($_POST['logo_sub'] ?? ($current['logo_sub'] ?? 'Control Center • Luxury')));
    $data['logo_letter'] = sanitize_text_field(wp_unslash($_POST['logo_letter'] ?? ($current['logo_letter'] ?? 'A')));
    if (isset($_POST['gold'])) {
        $data['gold'] = sanitize_hex_color(wp_unslash($_POST['gold'])) ?: ($current['gold'] ?? '#C9A86A');
    } elseif (empty($data['gold'])) {
        $data['gold'] = '#C9A86A';
    }

    $data['phone'] = sanitize_text_field(wp_unslash($_POST['phone'] ?? ($current['phone'] ?? '')));
    $data['email'] = sanitize_email(wp_unslash($_POST['email'] ?? ($current['email'] ?? get_option('admin_email'))));
    $data['whatsapp'] = preg_replace('/\D+/', '', (string) wp_unslash($_POST['whatsapp'] ?? ($current['whatsapp'] ?? '')));
    $data['export_text'] = sanitize_text_field(wp_unslash($_POST['export_text'] ?? ($current['export_text'] ?? '')));
    $data['export_url'] = esc_url_raw(wp_unslash($_POST['export_url'] ?? ($current['export_url'] ?? '')));
    $data['wholesale_text'] = sanitize_text_field(wp_unslash($_POST['wholesale_text'] ?? ($current['wholesale_text'] ?? '')));
    $data['wholesale_url'] = esc_url_raw(wp_unslash($_POST['wholesale_url'] ?? ($current['wholesale_url'] ?? home_url('/#b2b'))));
    $data['top_logo_url'] = esc_url_raw(wp_unslash($_POST['top_logo_url'] ?? ($current['top_logo_url'] ?? '')));
    $data['top_logo_alt'] = sanitize_text_field(wp_unslash($_POST['top_logo_alt'] ?? ($current['top_logo_alt'] ?? get_bloginfo('name'))));
    $data['top_logo_link'] = esc_url_raw(wp_unslash($_POST['top_logo_link'] ?? ($current['top_logo_link'] ?? home_url('/'))));
    foreach ([
        'topbar_bg' => '#11091D',
        'topbar_text_color' => '#E8D5B5',
        'topbar_border_color' => '#3A2C20',
        'topbar_button_bg' => '#C9A86A',
        'topbar_button_text' => '#1A1206',
    ] as $color_key => $color_default) {
        $data[$color_key] = sanitize_hex_color(wp_unslash($_POST[$color_key] ?? ($current[$color_key] ?? $color_default))) ?: $color_default;
    }
    $data['topbar_height'] = max(30, min(60, absint($_POST['topbar_height'] ?? ($current['topbar_height'] ?? 38))));
    $data['top_logo_width'] = max(50, min(180, absint($_POST['top_logo_width'] ?? ($current['top_logo_width'] ?? 96))));
    $data['account_text'] = sanitize_text_field(wp_unslash($_POST['account_text'] ?? ($current['account_text'] ?? 'ورود / ثبت‌نام')));
    $data['primary_menu'] = absint($_POST['primary_menu'] ?? ($current['primary_menu'] ?? 0));
    foreach (['sticky', 'show_topbar', 'show_contact', 'show_account', 'show_phone', 'show_email', 'show_whatsapp', 'show_export', 'show_wholesale', 'wholesale_new_tab'] as $flag) {
        $data[$flag] = isset($_POST[$flag]) ? rest_sanitize_boolean(wp_unslash($_POST[$flag])) : !empty($current[$flag]);
    }

    update_option(ALOOKHOR_CC_HEADER_OPTION, $data);

    // همگام‌سازی با settings اصلی
    $settings = alookhor_cc_get_settings();
    $settings['header_settings']['logo_text'] = $data['logo_text'];
    $settings['header_settings']['logo_sub'] = $data['logo_sub'];
    $settings['site']['logoLetter'] = $data['logo_letter'];
    $settings['site']['goldAccent'] = $data['gold'];
    $settings['updated_at'] = current_time('mysql');
    update_option(ALOOKHOR_CC_OPTION, $settings);

    wp_send_json_success(['message'=>'هدر با موفقیت ذخیره شد — شورت‌کد [alookhor_portal_header] بروز شد','data'=>$data]);
}
