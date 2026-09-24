<?php
/**
 * بازگردانی وضعیت صفحه اصلی به حالت قبل از نسخه ۳.۱۰.۳۸۶
 * (نسخه ۳.۱۰.۳۹۱ — بازنویسی کامل مکانیزم اجرا)
 *
 * چرا بازنویسی شد؟ در نسخه ۳۹۰ این کار فقط روی admin_init اجرا می‌شد و چون
 * بعد از نصب افزونه هیچ صفحه‌ای از پیشخوان باز نشد، بازیابی هرگز انجام نگرفت.
 *
 * اکنون سه تریگر مستقل دارد:
 *   ۱) init (دیرهنگام، ۹۹۹) — هم فرانت‌اند هم پیشخوان؛ اولین درخواست بعد از نصب اجرایش می‌کند.
 *   ۲) admin_init — برای اطمینان بیشتر در محیط مدیریت.
 *   ۳) upgrader_process_complete — بلافاصله بعد از پایان به‌روزرسانی افزونه.
 *
 * خودترمیمی: پرچم done فقط زمانی مانع اجرای مجدد است که واقعاً وضعیت سالم
 * باشد (فیلدهای سربرگ پر باشند). اگر اجرای قبلی ناقص بوده، دوباره اجرا می‌شود.
 *
 * کارها:
 *  ۱) بازگردانی تنظیمات از پشتیبان قبل از ۳۸۶ (اگر وجود داشته باشد).
 *  ۲) بازنشانی اسلایدهای هیرو به پیش‌فرض‌های قدیمی (تصاویر categories-manager)
 *     اگر تصاویر فعلی بنرهای معرفی‌شده در ۳۸۶ باشند.
 *  ۳) پر کردن فقط فیلدهای خالی سربرگ با مقادیر اصلی سایت.
 *  ۴) پاک‌سازی حافظه‌های موقت رندر.
 */

if (!defined('ABSPATH')) exit;

/**
 * استخراج مسیر فعلیِ سالم اسلایدها — همان چیزی که کاربر «مثل قبل» یادش می‌آید:
 * تصاویر category-* داخل خود افزونه (روی لایو همین‌ها قبل از ۳۸۶ کار می‌کردند).
 */
function alookhor_cc_hero_good_slide_images(){
    // تصاویر اصلی اسلایدر: 1600×656 (۲.۴:۱) پرکیفیت و تمام‌عرض،
    // بسته‌بندی‌شده داخل خود افزونه — همیشه در دسترس.
    return [
        'https://alookhor.ir/wp-content/plugins/alookhor-control-center/assets/images/hero/slide-1-plums.jpg',
        'https://alookhor.ir/wp-content/plugins/alookhor-control-center/assets/images/hero/slide-2-dried-fruit.jpg',
        'https://alookhor.ir/wp-content/plugins/alookhor-control-center/assets/images/hero/slide-3-packaging.jpg',
        'https://alookhor.ir/wp-content/plugins/alookhor-control-center/assets/images/hero/slide-4-wholesale.jpg',
    ];
}

/**
 * آیا نشانی تصویر اسلاید «خراب/قفل‌شده» است؟ (اعم از بنرهای ۳۸۶ یا محتویات حذف‌شده categories-manager)
 */
function alookhor_cc_slide_image_is_broken($url){
    $url = (string)$url;
    if ($url === '') return false;
    // منبع حذف‌شدهٔ قدیمی (categories-manager)
    if (strpos($url, 'wp-content/plugins/alookhor-categories-manager/') !== false) return true;
    // هر نشانی hero داخل همین افزونه که فایلش روی دیسک نیست (مثل slide-1.jpgِ قدیمی)
    if (strpos($url, 'wp-content/plugins/alookhor-control-center/assets/images/hero/') !== false) {
        $rel = substr($url, strpos($url, 'assets/images/hero/'));
        $local = ALOOKHOR_CC_DIR . $rel;
        return !file_exists($local);
    }
    return false;
}

/**
 * آیا تنظیمات هیرو تصاویر خراب/مرده دارد؟
 */
function alookhor_cc_hero_has_386_banners($hero_settings){
    if (!is_array($hero_settings) || empty($hero_settings['slides']) || !is_array($hero_settings['slides'])) {
        return false;
    }
    foreach ($hero_settings['slides'] as $slide) {
        if (is_array($slide) && alookhor_cc_slide_image_is_broken($slide['image_url'] ?? '')) {
            return true;
        }
    }
    return false;
}

/**
 * بازگرداندن نشانی‌های سالم به اسلایدهای موجود؛ متن‌ها و ترتیب دست‌نخورده می‌مانند.
 */
function alookhor_cc_repair_hero_slide_images(array $hero_settings){
    if (empty($hero_settings['slides']) || !is_array($hero_settings['slides'])) return $hero_settings;
    $good = alookhor_cc_hero_good_slide_images();
    foreach ($hero_settings['slides'] as $i => $slide) {
        if (!is_array($slide)) continue;
        $url = (string)($slide['image_url'] ?? '');
        if (alookhor_cc_slide_image_is_broken($url)) {
            $hero_settings['slides'][$i]['image_url'] = $good[$i] ?? $good[0];
            $hero_settings['slides'][$i]['image_id']  = 0;
        }
    }
    return $hero_settings;
}

/**
 * آیا بازیابی قبلاً با موفقیت کامل شد؟
 */
function alookhor_cc_restore_needed_391(){
    // فیلدهای کلیدی سربرگ خالی/غیرفعال‌اند؟
    $header = get_option(ALOOKHOR_CC_HEADER_OPTION, []);
    $header_broken = !is_array($header)
        || empty($header['whatsapp'])
        || empty($header['email'])
        || empty($header['wholesale_url'])
        || empty($header['enabled']); // هدر شیشه‌ای AKX فقط با enabled فعال رندر می‌شود

    // اسلایدها هنوز بنرهای ۳۸۶ هستند؟
    $saved = get_option(ALOOKHOR_CC_OPTION, []);
    $hero_broken = is_array($saved) && alookhor_cc_hero_has_386_banners($saved['hero_settings'] ?? null);

    // پشتیبان منتظر بازیابی است؟
    $backup_pending = is_array(get_option('alookhor_cc_settings_before_386'));

    return $header_broken || $hero_broken || $backup_pending;
}

function alookhor_cc_restore_home_391(){

    // بهینه‌سازی: اگر پرچم قبلی خورده و همه‌چیز سالم است، هیچ کاری نکن.
    if (get_option('alookhor_cc_restore_391') && !alookhor_cc_restore_needed_391()) {
        return;
    }
    if (!alookhor_cc_restore_needed_391()) {
        update_option('alookhor_cc_restore_391', 1, false);
        return;
    }

    // ۱) بازگرداندن کامل تنظیمات از پشتیبان قبل از ۳۸۶
    $backup = get_option('alookhor_cc_settings_before_386');
    if (is_array($backup)) {
        update_option(ALOOKHOR_CC_OPTION, $backup);
    }
    delete_option('alookhor_cc_settings_before_386');
    delete_option('alookhor_cc_hero_banners_386');

    // ۲) بازنشانی اسلایدهای هیرو به پیش‌فرض‌های قبل از ۳۸۶ اگر بنرهای ۳۸۶ مانده‌اند
    $saved = get_option(ALOOKHOR_CC_OPTION, []);
    if (!is_array($saved)) $saved = [];
    if (alookhor_cc_hero_has_386_banners($saved['hero_settings'] ?? null)) {
        if (isset($saved['hero_settings']) && is_array($saved['hero_settings'])) {
            $saved['hero_settings'] = alookhor_cc_repair_hero_slide_images($saved['hero_settings']);
        }
        // همچنین پیش‌فرض‌های ماژول را روی نشانی‌های درست بازنشانی کن تا
        // هیچ لایه‌ای دیگر نشانی‌های مرده را تزریق نکند.
        $defaults = function_exists('alookhor_cc_get_default_settings')
            ? alookhor_cc_get_default_settings()
            : [];
        if (is_array($defaults) && !empty($defaults['hero_settings']) && is_array($defaults['hero_settings'])) {
            $repaired_defaults = alookhor_cc_repair_hero_slide_images($defaults['hero_settings']);
            // فقط جاهای خالی/ناموجود را با پیش‌فرض ترمیم‌کن:
            foreach ($repaired_defaults as $dk => $dv) {
                if (!isset($saved['hero_settings'][$dk])) {
                    $saved['hero_settings'][$dk] = $dv;
                }
            }
        }
        update_option(ALOOKHOR_CC_OPTION, $saved);
    }

    // ۳) پر کردن مقادیر خالی سربرگ با مقادیر اصلی سایت (فقط جاهای خالی)
    $header = get_option(ALOOKHOR_CC_HEADER_OPTION, []);
    if (!is_array($header)) $header = [];
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
    // v3.10.392: هدر شیشه‌ای اصلی AKX فقط با enabled فعال رندر می‌شود؛
    // مرجع ظاهری کاربر همین هدر است و باید همیشه روشن باشد.
    if (empty($header['enabled'])) {
        $header['enabled'] = true;
        $changed = true;
    }
    // مپ کردن شماره واتساپ به کلید AKX تا دایرکت در هدر شیشه‌ای نمایش داده شود.
    if (empty($header['whatsapp_number']) && !empty($header['whatsapp'])) {
        $header['whatsapp_number'] = preg_replace('/\D+/', '', (string) $header['whatsapp']);
        $changed = true;
    }
    if ($changed) update_option(ALOOKHOR_CC_HEADER_OPTION, $header);

    // ۴) پاک‌سازی حافظه‌های موقت
    if (function_exists('delete_site_transient')) {
        delete_site_transient('alookhor_cc_update_manifest_v1');
    }
    delete_transient('alookhor_cc_hero_settings_cache');
    delete_transient('alookhor_cc_settings_cache');

    update_option('alookhor_cc_restore_391', 1, false);
    // پرچم قدیمی ۳۹۰ را نیز پاک می‌کنیم تا وضعیت مبهم باقی نماند.
    delete_option('alookhor_cc_restore_390');
}

// تریگر ۱: دیرهنگام روی init — در فرانت‌اند و پیشخوان.
add_action('init', 'alookhor_cc_restore_home_391', 999);
// تریگر ۲: admin_init برای اطمینان بیشتر.
add_action('admin_init', 'alookhor_cc_restore_home_391');
// تریگر ۳: بلافاصله بعد از به‌روزرسانی افزونه.
add_action('upgrader_process_complete', function ($upgrader, $hook_extra){
    if (!is_array($hook_extra) || ($hook_extra['type'] ?? '') !== 'plugin') return;
    $plugins = (array)($hook_extra['plugins'] ?? [$hook_extra['plugin'] ?? '']);
    foreach ($plugins as $p) {
        if (strpos((string)$p, 'alookhor-control-center') !== false) {
            alookhor_cc_restore_home_391();
        }
    }
}, 999, 2);
