<?php
if (!defined('ABSPATH')) exit;

/**
 * ALOOKHOR Cart Probe v1 (3.10.397)
 * تشخیص دقیقِ «افزودن به سبد کار نمی‌کند» در یک درخواست واحد، بدون نیاز به کوکی:_
 * ۱) افزودن یک محصول واقعی به سبد (در حافظه) → ۲) شمارش در همان درخواست →
 * ۳) ذخیرهٔ جلسهٔ مهمان (save_data) → ۴) خواندن ردیف جلسه مستقیم از $wpdb →
 * ۵) گزارش خطای پایگاه‌داده (مثل «table is marked as crashed») → ۶) پاک‌سازی.
 * خروجی JSON: «session_row» باید ۱ باشد؛ ۰ یعنی جدول سشن ووکامرس خراب/ناهماهنگ است.
 */

add_action('rest_api_init', function () {
    register_rest_route('alookhor-cc/v1', '/cart-probe', [
        'methods' => 'GET',
        'permission_callback' => '__return_true',
        'callback' => 'alookhor_cc_cart_probe',
    ]);
});

function alookhor_cc_cart_probe() {
    $out = [
        'ok' => true,
        'version' => defined('ALOOKHOR_CC_VERSION') ? ALOOKHOR_CC_VERSION : '?',
        'stage' => 'start',
    ];

    if (!function_exists('WC') || !WC()) {
        return rest_ensure_response(['ok' => false, 'stage' => 'no-woocommerce']);
    }
    if (!function_exists('wc_load_cart')) {
        $out['stage'] = 'no-wc_load_cart';
        // try Woo's own loader
        add_action('wp_loaded', 'wc_load_cart', 5);
    }
    if (function_exists('wc_load_cart')) wc_load_cart();
    if (!WC()->cart) {
        return rest_ensure_response(['ok' => false, 'stage' => 'no-cart-object']);
    }
    if (!WC()->session) {
        return rest_ensure_response(['ok' => false, 'stage' => 'no-session-object']);
    }

    global $wpdb;

    // انتخاب یک محصول قابل‌خرید واقعی — ترجیحاً متغیر با روش همان فروشگاه
    $pick = wc_get_products([
        'status' => 'publish',
        'limit' => 10,
        'return' => 'ids',
        'orderby' => 'date',
        'order' => 'DESC',
    ]);
    $product_id = 0; $variation_id = 0; $attributes = [];
    foreach ((array)$pick as $cand) {
        $p = wc_get_product($cand);
        if (!$p || !$p->is_purchasable() || !$p->is_in_stock()) continue;
        if ($p->is_type('variable')) {
            $vars = $p->get_children();
            foreach ($vars as $vid) {
                $v = wc_get_product($vid);
                if ($v && $v->is_purchasable() && $v->is_in_stock()) {
                    $product_id = (int)$cand;
                    $variation_id = (int)$vid;
                    $attributes = (array)$v->get_variation_attributes();
                    break 2;
                }
            }
        } else {
            $product_id = (int)$cand;
            break;
        }
    }
    $out['product_id'] = $product_id;
    $out['variation_id'] = $variation_id;
    if (!$product_id) {
        return rest_ensure_response(['ok' => false, 'stage' => 'no-purchasable-product']);
    }

    // ۱) خالی‌سازی + افزودن
    WC()->cart->empty_cart(true);
    $cart_item_key = WC()->cart->add_to_cart($product_id, 1, $variation_id, $attributes);
    $out['added'] = (bool)$cart_item_key;
    $out['count_in_request'] = WC()->cart->get_cart_contents_count();
    $out['notices'] = function_exists('wc_get_notices') ? wc_get_notices() : [];

    // ۲) ذخیرهٔ جلسه
    if (method_exists(WC()->session, 'save_data')) WC()->session->save_data();
    $customer_id = WC()->session->get_customer_id();
    $out['customer_id_prefix'] = substr((string)$customer_id, 0, 8) . '…';
    $cookie_name = 'wp_woocommerce_session_' . (defined('COOKIEHASH') ? COOKIEHASH : '');
    $out['cookie_received_on_this_request'] = isset($_COOKIE[$cookie_name]);

    // ۳) خواندن مستقیم از جدول سشن‌ها (نشانهٔ کرش/عدم‌تطابق) — بدون SHOW TABLES (سازگار با همه درایورها)
    $table = $wpdb->prefix . 'woocommerce_sessions';
    $table_err = '';
    $row = $wpdb->get_var($wpdb->prepare("SELECT COUNT(*) FROM {$table} WHERE session_key = %s", $customer_id));
    $table_err = (string)$wpdb->last_error;
    $table_exists = ($row !== null && $table_err === '');
    $out['sessions_table'] = $table_exists ? 'exists' : 'missing';
    $row = (int)$row;
    $out['session_row_after_save'] = $row;
    $out['db_error'] = mb_substr(strip_tags((string)$table_err), 0, 300);

    // ۴) تشخیص کرش MyISAM
    $crashed = (stripos($table_err, 'crashed') !== false) || (stripos($table_err, 'marked as crashed') !== false);
    $out['diagnosis'] = !$out['added'] ? 'add-failed'
        : (!$table_exists ? 'sessions-table-missing'
        : ($crashed ? 'sessions-table-crashed'
        : ($row < 1 ? 'session-not-persisted' : 'healthy')));

    // ۵) پاک‌سازی تست
    WC()->cart->empty_cart(true);
    if (method_exists(WC()->session, 'save_data')) WC()->session->save_data();

    return rest_ensure_response($out);
}
