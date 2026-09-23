<?php
/**
 * ALOOKHOR Control Center — بنرهای اختصاصی اسلایدر صفحه اصلی.
 *
 * نسخه ۳.۱۰.۳۸۶: چهار بنر عریض (نسبت ۲.۴:۱) با ترکیب‌بندیِ
 * «سوژه در سمت چپ / فضای تاریک در سمت راست برای متن» جایگزین
 * تصاویر کوچک قبلی می‌شوند. تنظیمات قبلی در یک گزینه پشتیبان
 * نگه داشته می‌شود تا در صورت نیاز قابل بازگشت باشد.
 */

if (!defined('ABSPATH')) exit;

function alookhor_cc_hero_banner_set(){
    return [
        ['file' => 'slide-1-plums.jpg',       'alt' => 'آلو بخارا ممتاز خراسان - خشکبار صادراتی آلوخور'],
        ['file' => 'slide-2-dried-fruit.jpg', 'alt' => 'آلو خشک طبیعی و برگه میوه‌های خشک ممتاز آلوخور'],
        ['file' => 'slide-3-packaging.jpg',   'alt' => 'بسته‌بندی حرفه‌ای و صادراتی خشکبار آلوخور'],
        ['file' => 'slide-4-wholesale.jpg',   'alt' => 'تأمین عمده آلو و خشکبار برای کسب‌وکارها - آلوخور'],
    ];
}

/**
 * یک‌بار اجرا می‌شود و بنرهای جدید را روی اسلایدر می‌نشاند.
 */
function alookhor_cc_hero_banners_migrate(){

    if (get_option('alookhor_cc_hero_banners_386')) {
        return;
    }

    $settings = get_option(ALOOKHOR_CC_OPTION, []);
    if (!is_array($settings)) {
        $settings = [];
    }

    // پشتیبانِ تنظیمات برای امکان بازگشت
    if (false === get_option('alookhor_cc_settings_before_386', false)) {
        update_option('alookhor_cc_settings_before_386', $settings, false);
    }

    if (!isset($settings['hero_settings']) || !is_array($settings['hero_settings'])) {
        $settings['hero_settings'] = [];
    }
    if (!isset($settings['hero_settings']['slides']) || !is_array($settings['hero_settings']['slides'])) {
        $settings['hero_settings']['slides'] = [];
    }

    $base = ALOOKHOR_CC_URL . 'assets/images/hero/';

    foreach (alookhor_cc_hero_banner_set() as $index => $item) {
        if (!isset($settings['hero_settings']['slides'][$index]) || !is_array($settings['hero_settings']['slides'][$index])) {
            $settings['hero_settings']['slides'][$index] = [];
        }
        $settings['hero_settings']['slides'][$index]['image_id']   = 0;
        $settings['hero_settings']['slides'][$index]['image_url']  = $base . $item['file'];
        $settings['hero_settings']['slides'][$index]['image_alt']  = $item['alt'];
        $settings['hero_settings']['slides'][$index]['flip_image'] = false;
    }

    update_option(ALOOKHOR_CC_OPTION, $settings);
    update_option('alookhor_cc_hero_banners_386', 1, false);
}
add_action('admin_init', 'alookhor_cc_hero_banners_migrate');

/**
 * بازگرداندن تنظیمات به وضعیت قبل از نصب بنرها.
 */
function alookhor_cc_hero_banners_restore(){
    $backup = get_option('alookhor_cc_settings_before_386');

    if (!is_array($backup)) {
        return false;
    }

    update_option(ALOOKHOR_CC_OPTION, $backup);
    delete_option('alookhor_cc_hero_banners_386');
    delete_option('alookhor_cc_settings_before_386');

    return true;
}
