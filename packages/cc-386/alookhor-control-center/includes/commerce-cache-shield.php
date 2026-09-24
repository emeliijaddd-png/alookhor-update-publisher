<?php
if (!defined('ABSPATH')) exit;

/**
 * ALOOKHOR Commerce Cache Shield v1 (3.10.398)
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
    return $response;
}, 5, 1);
