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

    wp_send_json_success(['message'=>'ذخیره شد — بدون رفرش اعمال شد','updated_at'=> $merged['updated_at']]);
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
