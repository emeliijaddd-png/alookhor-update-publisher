<?php
if (!function_exists('alookhor_cc_rest_route_url')) {
    /* rest_url به $wp_rewrite وابسته است که تا قبل از init ساخته نشده است (Fatal در آپایتر).
     * این همپر درون plugins_loaded هم امن است. */
    function alookhor_cc_rest_route_url($route) {
        $route = '/' . ltrim((string) $route, '/');
        global $wp_rewrite;
        if (defined('ABSPATH') && function_exists('rest_url') && $wp_rewrite instanceof WP_Rewrite) {
            return rest_url(ltrim($route, '/'));
        }
        return home_url('/wp-json' . $route);
    }
}

if (!defined('ABSPATH')) exit;

/**
 * ALOOKHOR Commerce Cache Shield v2 (3.10.415)
 * منعِ کش شدنِ صفحات تجاری (سبد خرید، تسویه حساب، حساب کاربری، درخواست‌های add-to-cart)
 * در برابر LiteSpeed/Cloudflare و هر کش لبه‌ای — منشأِ خرابی «محصول اضافه می‌شود
 * ولی سبد خالی دیده می‌شود» و «صفحه ادمین به مهمان نشان داده می‌شود».
 * چون سرور شما PHP را پشت لایه کش اجرا می‌کند؛ با هدرهای استاندارد لایه‌های پایین‌دست
 * از ذخیره کردن این پاسخ‌ها جلوگیری می‌کنیم.
 */

function alookhor_cc_commerce_page_is_sensitive() {
    $uri = isset($_SERVER['REQUEST_URI']) ? (string)$_SERVER['REQUEST_URI'] : '';
    $q   = isset($_GET) ? $_GET : [];

    // درخواست افزودن به سبد (GET) و wc-ajax همیشه حساس است
    if (isset($q['add-to-cart']) || isset($q['remove_item']) || isset($q['undo_item'])) return true;
    if (isset($q['wc-ajax'])) return true;

    // مسیرهای تجاری استاندارد
    $paths = ['/cart', '/checkout', '/my-account', '/سبد-خرید', '/تسویه-حساب', '/حساب-کاربری'];
    foreach ($paths as $p) {
        if (strpos($uri, $p) !== false) return true;
    }

    // product / shop: هم از هوک‌های ووکامرس استفاده کن، هم مسیر خام
    if (function_exists('is_product') && (is_product() || is_cart() || is_checkout() || is_account_page())) return true;
    if (strpos($uri, '/product/') !== false || strpos($uri, '/product-category/') !== false) return true;

    // اگر کوکی سشن/آیتم ووکامرس هست، مرورگر کاربر دارد کاربر واقعی است — کش عمومی ممنوع
    foreach ((array)$_COOKIE as $name => $_v) {
        if (strpos($name, 'wp_woocommerce_session_') === 0 && !empty($_v)) return true;
        if (strpos($name, 'woocommerce_items_in_cart') === 0 && (string)$_v === '1') return true;
    }

    return false;
}

add_action('init', function () {
    if (!alookhor_cc_commerce_page_is_sensitive()) return;

    if (!defined('DONOTCACHEPAGE')) define('DONOTCACHEPAGE', true);
    if (!defined('DONOTCACHEDB'))  define('DONOTCACHEDB', true);
    if (!defined('DONOTMINIFY'))   define('DONOTMINIFY', true);

    if (!headers_sent()) {
        nocache_headers();
        header('X-LiteSpeed-Cache-Control: no-cache');
        header('Cache-Control: no-store, no-cache, must-revalidate, max-age=0', false);
        header('CDN-Cache-Control: no-store');
        header('Cloudflare-CDN-Cache-Control: no-store');
        header('Vary: Cookie', false);
    }
}, 1);

// هدر را برای پاسخ‌های REST مربوط به سبد هم بفرست
add_filter('rest_post_dispatch', function ($response) {
    if (!($response instanceof WP_REST_Response)) return $response;
    $route = isset($_SERVER['REQUEST_URI']) ? (string)$_SERVER['REQUEST_URI'] : '';
    if (strpos($route, '/alookhor-') === false) return $response;
    $response->header('Cache-Control', 'no-store, no-cache, must-revalidate, max-age=0');
    $response->header('X-LiteSpeed-Cache-Control', 'no-cache');
    /* 3.10.414: تگ اختصاصی برای پاکسازی هدفمند کش LiteSpeed */
    if (class_exists('LiteSpeed_Cache_API') && method_exists('LiteSpeed_Cache_API','tag_add')) {
        try { LiteSpeed_Cache_API::tag_add(array('ALOOKHOR_CART')); } catch (Throwable $e) {}
    }
    $response->header('X-LiteSpeed-Tag', 'ALOOKHOR_CART');
    return $response;
}, 5, 1);

/* ── 3.10.414: پیدایش واقعی روی لایو — کش سرور رشتهٔ کوئری را نادیده می‌گرفت و
 *  GET /wp-json/alookhor-… و لینک‌های ?add-to-cart=… را از روی کپیٔ کش‌شده سرو می‌کرد؛
 *  نتیجه: آیتم‌ها «بعد چند ثانیه» با پاسخ کش‌شدهٔ «سبد خالی» جایگزین می‌شدند.
 *  در اینجا (الف) مسیرهای ما از لیست کش LiteSpeed خارج می‌شوند، (ب) پارامترهای حیاتی
 *  از کش کوئری مستثنا می‌شوند — فقط اگر افزونهٔ LiteSpeed Cache فعال و API موجود باشد. */
add_action('init', function () {
    if (!class_exists('LiteSpeed_Cache_API')) return;
    if (!method_exists('LiteSpeed_Cache_API', 'conf_append')) return;
    try {
        LiteSpeed_Cache_API::conf_append('cache-uri_exc', '/alookhor-');
        LiteSpeed_Cache_API::conf_append('cache-qs_exc', 'add-to-cart');
        LiteSpeed_Cache_API::conf_append('cache-qs_exc', 'quantity');
        LiteSpeed_Cache_API::conf_append('cache-qs_exc', 'variation_id');
    } catch (Throwable $e) {}
}, 998);

/**
 * 3.10.420: پاکسازی خودکار و قطعی بلافاصله بعد از هر بروزرسانی پلاگین.
 * مشکل لایو: مدخل‌های کش‌شدهٔ قدیمی (مثل «سبد خالی/دو محصول» یا صفحهٔ اصلیِ
 * مسموم‌شده با ?add-to-cart) بدون اجرای PHP سرو می‌شدند؛ هدر/مستثنی‌سازی فقط
 * از کشِ «آینده» جلوگیری می‌کند و مدخل قدیمی را پاک نمی‌کند. با هر تغییر نسخه،
 * یک‌بار و دقیقاً یک‌بار purge_all می‌زنیم و صفحهٔ اصلی و سبد را هم تکی پرژ می‌کنیم.
 */
add_action('plugins_loaded', function () {
    if (!defined('ALOOKHOR_CC_VERSION')) return;
    $seen = (string)get_option('alookhor_cc_cache_busted_ver', '');
    if ($seen === ALOOKHOR_CC_VERSION) return;
    update_option('alookhor_cc_cache_busted_ver', ALOOKHOR_CC_VERSION, false);
    update_option('alookhor_cc_ls_purge_ts', time(), false);
    if (class_exists('LiteSpeed_Cache_API') && method_exists('LiteSpeed_Cache_API', 'purge_all')) {
        try { LiteSpeed_Cache_API::purge_all(); } catch (Throwable $e) {}
    }
    do_action('litespeed_purge_all');
    foreach ([home_url('/'), rtrim(home_url('/'), '/')] as $u) {
        do_action('litespeed_purge_url', $u);
    }
    if (function_exists('rest_url')) {
        do_action('litespeed_purge_url', alookhor_cc_rest_route_url('alookhor-cart/v4/cart'));
    }
}, 3);

/**
 * 3.10.420: پاسخ هر تغییر سبد (add/update/remove/coupon) دستور پرژ مدخل‌های
 * مرتبط را هم به سرور لایسسپید بدهد — حتی اگر ابزار purge API در دسترس نباشد.
 */
add_filter('rest_post_dispatch', function ($response) {
    if (!($response instanceof WP_REST_Response)) return $response;
    $route = isset($_SERVER['REQUEST_URI']) ? (string)$_SERVER['REQUEST_URI'] : '';
    if (strpos($route, '/alookhor-cart/') === false) return $response;
    $method = isset($_SERVER['REQUEST_METHOD']) ? $_SERVER['REQUEST_METHOD'] : 'GET';
    if ($method !== 'GET' && $method !== 'HEAD' && !headers_sent()) {
        header('X-LiteSpeed-Purge: ' . home_url('/cart/') . ',/,*ALOOKHOR_CART*', false);
    }
    return $response;
}, 6, 1);

/**
 * دفاع فعال: هر ساعت، نسخه‌های کش‌شدهٔ صفحات حساس را از LiteSpeed پاک می‌کنیم.
 * علت: هدرهای ضدکش فقط وقتی اعمال می‌شوند که PHP اجرا شود؛ نسخهٔ قدیمیِ کش‌شده
 * بدون اجرای PHP سرو می‌شد و همه «سبد خالیِ قدیمی» را می‌دیدند.
 */
add_action('init', function () {
    $last = (int)get_option('alookhor_cc_ls_purge_ts', 0);
    if (time() - $last < 3600) return;
    update_option('alookhor_cc_ls_purge_ts', time(), false);
    if (!function_exists('do_action')) return;
    $urls = [];
    if (function_exists('wc_get_cart_url'))      $urls[] = wc_get_cart_url();
    if (function_exists('wc_get_checkout_url'))  $urls[] = wc_get_checkout_url();
    if (function_exists('wc_get_page_permalink')) {
        $urls[] = wc_get_page_permalink('myaccount');
    }
    $urls[] = home_url('/cart/');
    $urls[] = home_url('/checkout/');
    $urls[] = home_url('/my-account/');
    /* 3.10.414: مسیرهای REST سبد هم از کش LiteSpeed پاک شوند (کپیٔ قدیمی «سبد خالی») */
    $urls[] = alookhor_cc_rest_route_url('alookhor-cart/v4/cart');
    $urls[] = alookhor_cc_rest_route_url('alookhor-cart/v4/recommendations');
    $urls   = array_unique(array_filter($urls));
    foreach ($urls as $u) {
        do_action('litespeed_purge_url', $u);
    }
    do_action('litespeed_purge_all_esi');
    /* پاکسازی با تگ اختصاصی هم (اگر API افزونهٔ LiteSpeed موجود باشد) */
    if (class_exists('LiteSpeed_Cache_API') && method_exists('LiteSpeed_Cache_API','purge_tag')) {
        try { LiteSpeed_Cache_API::purge_tag('ALOOKHOR_CART'); } catch (Throwable $e) {}
    }
}, 999);
