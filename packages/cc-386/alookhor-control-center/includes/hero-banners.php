<?php
/**
 * بازگردانی وضعیت صفحه اصلی به حالت قبل از نسخه ۳.۱۰.۳۸۶  (نسخه ۳.۱۰.۳۹۰)
 *
 * این ماژول یک‌بار اجرا می‌شود:
 *  ۱) تنظیمات اسلایدر را از پشتیبان گرفته‌شده قبل از ۳۸۶ بازمی‌گرداند
 *     (تصاویر قبلی، چرخش، متن‌های قبلی).
 *  ۲) اگر برخی مقادیر سربرگ (واتساپ، ایمیل، لینک عمده) در نسخه‌های ۳۸۶ تا
 *     ۳۸۹ خالی شده‌اند، همان مقادیر قبلی را پر می‌کند — فقط جاهای خالی.
 *  ۳) حافظه‌های موقت مدیریت را پاک می‌کند تا رندر بعدی تازه شود.
 */

if (!defined('ABSPATH')) exit;

function alookhor_cc_restore_home_390(){

    if (get_option('alookhor_cc_restore_390')) {
        return;
    }

    // ۱) بازگرداندن کامل تنظیمات از پشتیبان قبل از ۳۸۶
    $backup = get_option('alookhor_cc_settings_before_386');
    if (is_array($backup)) {
        update_option(ALOOKHOR_CC_OPTION, $backup);
    }
    delete_option('alookhor_cc_settings_before_386');
    delete_option('alookhor_cc_hero_banners_386');

    // ۲) پر کردن مقادیر خالی سربرگ با مقادیر قبلی سایت
    $header = get_option(ALOOKHOR_CC_HEADER_OPTION, []);
    if (!is_array($header)) {
        $header = [];
    }
    $originals = [
        'whatsapp'       => '989222942808',
        'email'          => 'hamyarline@gmail.com',
        'phone'          => '09159513173',
        'wholesale_url'  => home_url('/#b2b'),
        'wholesale_text' => 'خرید عمده آلو بخارا',
        'export_text'    => 'ارسال رایگان به بیش از ۱۵ کشور جهان',
        'support_text'   => 'پشتیبانی ۲۴/۷',
    ];
    $changed = false;
    foreach ($originals as $key => $value) {
        if (empty($header[$key])) {
            $header[$key] = $value;
            $changed = true;
        }
    }
    if ($changed) {
        update_option(ALOOKHOR_CC_HEADER_OPTION, $header);
    }

    // ۳) پاک‌سازی حافظه‌های موقت رندر
    if (function_exists('delete_site_transient')) {
        delete_site_transient('alookhor_cc_update_manifest_v1');
    }
    delete_transient('alookhor_cc_hero_settings_cache');
    delete_transient('alookhor_cc_settings_cache');

    update_option('alookhor_cc_restore_390', 1, false);
}
add_action('admin_init', 'alookhor_cc_restore_home_390');
