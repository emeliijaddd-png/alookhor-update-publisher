<?php
/**
 * ALOOKHOR Cart REST — native WooCommerce session bridge + recommendations.
 *
 * The Cart page must read/write the same WC()->cart session used by normal
 * WooCommerce add-to-cart buttons. This avoids a second, disconnected Store API
 * cart state on themes that also run Woodmart/Elementor cart fragments.
 */
if (!defined('ABSPATH')) exit;

function alookhor_cc_cart_bootstrap() {
    if (!function_exists('WC')) return false;
    if (function_exists('wc_load_cart') && (!WC()->cart || !WC()->session)) {
        wc_load_cart();
    }
    return WC()->cart instanceof WC_Cart;
}

if (!function_exists('alookhor_cc_variation_human_label')) {
    function alookhor_cc_variation_human_label($attr_key, $value, $product = null) {
        $tax = preg_replace('/^attribute_/', '', (string) $attr_key);
        $label = function_exists('wc_attribute_label') ? wc_attribute_label($tax, $product) : $tax;
        $val = (string) $value;
        if ($tax && function_exists('taxonomy_exists') && taxonomy_exists($tax) && function_exists('get_term_by')) {
            $t = get_term_by('slug', $val, $tax);
            if ($t && !is_wp_error($t) && !empty($t->name)) $val = $t->name;
        }
        return ['name' => $label, 'value' => $val];
    }
}

function alookhor_cc_cart_nonce_ok(WP_REST_Request $request) {
    $nonce = $request->get_header('X-ALOOKHOR-CART-NONCE');
    if (!$nonce) $nonce = $request->get_header('X-WP-Nonce');
    return $nonce && wp_verify_nonce($nonce, 'alookhor_cart');
}

function alookhor_cc_cart_payload() {
    if (!alookhor_cc_cart_bootstrap()) {
        return new WP_Error('cart_unavailable', 'WooCommerce cart is unavailable.', ['status' => 503]);
    }

    $items = [];
    foreach (WC()->cart->get_cart() as $key => $item) {
        $product = isset($item['data']) && $item['data'] instanceof WC_Product ? $item['data'] : null;
        if (!$product) continue;

        $variation = [];
        if (!empty($item['variation']) && is_array($item['variation'])) {
            foreach ($item['variation'] as $attr => $value) {
                $human = alookhor_cc_variation_human_label($attr, $value, $product);
                $variation[] = [
                    'name' => $human['name'],
                    'value' => $human['value'],
                ];
            }
        }

        $items[] = [
            'key' => (string) $key,
            'id' => (int) $product->get_id(),
            'variation_id' => !empty($item['variation_id']) ? (int) $item['variation_id'] : 0,
            'name' => $product->get_name(),
            'short_desc' => method_exists($product, 'get_short_description') ? wp_trim_words(wp_strip_all_tags((string) $product->get_short_description()), 16, '…') : '',
            'featured' => method_exists($product, 'is_featured') ? (bool) $product->is_featured() : false,
            'on_sale' => method_exists($product, 'is_on_sale') ? (bool) $product->is_on_sale() : false,
            'permalink' => $product->get_permalink($product->is_visible() ? [] : ['force_redirect' => true]),
            'quantity' => max(1, (int) ($item['quantity'] ?? 1)),
            'variation' => $variation,
            'variation_attributes' => !empty($item['variation']) && is_array($item['variation']) ? array_map('wc_clean', $item['variation']) : [],
            'image' => wp_get_attachment_image_url($product->get_image_id(), 'woocommerce_thumbnail') ?: wc_placeholder_img_src(),
            'price' => (float) wc_get_price_to_display($product),
            'line_total' => (float) wc_get_price_to_display($product, ['qty' => (int) ($item['quantity'] ?? 1)]),
        ];
    }

    $totals = WC()->cart->get_totals();
    return [
        'items' => $items,
        'count' => (int) WC()->cart->get_cart_contents_count(),
        'lines' => count($items),
        'coupons' => function_exists('WC') && WC()->cart ? array_values((array) WC()->cart->get_applied_coupons()) : [],
        'totals' => [
            'subtotal' => (float) ($totals['subtotal'] ?? 0),
            'discount_total' => (float) ($totals['discount_total'] ?? 0),
            'shipping_total' => (float) ($totals['shipping_total'] ?? 0),
            'fee_total' => (float) ($totals['fee_total'] ?? 0),
            'total' => (float) ($totals['total'] ?? 0),
            'currency' => get_woocommerce_currency(),
        ],
    ];
}

function alookhor_cc_cart_response() {
    $payload = alookhor_cc_cart_payload();
    return is_wp_error($payload) ? $payload : rest_ensure_response($payload);
}

/* ── 3.10.404: پاسخ‌های REST سبد هرگز نباید کش شوند ──
 * LiteSpeed/کش‌های میانی گاهی GET /alookhor-cart/v4/cart را برای مهمان کش می‌کردند
 * و در نتیجه JS پس از چند ثانیه «سبد خالی» کش‌شده را جایگزین لیست واقعی می‌کرد.
 */
add_filter('rest_post_dispatch', function ($response, $server, $request) {
    $route = $request->get_route();
    if (strpos($route, '/alookhor-cart/v4/') === 0) {
        if (function_exists('nocache_headers')) nocache_headers();
        if ($response instanceof WP_REST_Response) {
            $response->header('Cache-Control', 'no-store, no-cache, must-revalidate, max-age=0');
            $response->header('Pragma', 'no-cache');
            $response->header('Expires', 'Wed, 11 Jan 1984 05:00:00 GMT');
            $response->header('X-LiteSpeed-Cache-Control', 'no-cache');
            $response->header('X-Accel-Expires', '0');
            $response->header('Vary', 'Cookie');
        }
    }
    return $response;
}, 10, 3);

/* ── 3.10.404: تعدادِ انتخابی در صفحهٔ محصول از مسیر GET از دست نرود ──
 * صفحهٔ محصول آلوخور دکمهٔ افزودن را به‌صورت لینک ?add-to-cart=…‌&quantity=N می‌سازد،
 * ولی هستهٔ ووکامرس quantity را فقط از $_POST برمی‌دارد → عملاً همیشه ۱ ثبت می‌شد.
 * وقتی quantity>1 در URL هست، قبل از هندلر ووکامرس خودمان سالم ثبت و سپس ریدایرکت می‌کنیم.
 */
add_action('wp_loaded', function () {
    if (is_admin() || !isset($_GET['add-to-cart']) || isset($_POST['quantity'])) return;
    $qty = isset($_GET['quantity']) ? max(1, absint($_GET['quantity'])) : 1;
    if ($qty < 2) return; // مسیر بومی ووکامرس برای qty=1 دست‌نخورده می‌ماند
    if (!function_exists('WC') || !WC()->cart) return;
    $pid = absint($_GET['add-to-cart']);
    if (!$pid) return;
    $variation_id = !empty($_GET['variation_id']) ? absint($_GET['variation_id']) : 0;
    $attrs = array();
    foreach ((array) $_GET as $k => $v) {
        if (strpos($k, 'attribute_') === 0 && $v !== '') $attrs[$k] = function_exists('wc_clean') ? wc_clean($v) : sanitize_text_field($v);
    }
    $added = WC()->cart->add_to_cart($pid, $qty, $variation_id, $attrs);
    if (!$added) return; // بگذار مسیر بومی تصمیم بگیرد
    unset($_GET['add-to-cart'], $_REQUEST['add-to-cart']); // جلوگیری از ثبتِ دوباره توسط WC
    if (function_exists('wc_add_notice')) wc_add_notice(sprintf(__('«%s» به سبد خرید شما افزوده شد.', 'woocommerce'), function_exists('wc_get_product') && wc_get_product($pid) ? wc_get_product($pid)->get_name() : ''), 'success');
    $target = (get_option('woocommerce_cart_redirect_after_add') === 'yes' && function_exists('wc_get_cart_url')) ? wc_get_cart_url() : (wp_get_referer() ? wp_get_referer() : (function_exists('wc_get_cart_url') ? wc_get_cart_url() : home_url('/')));
    wp_safe_redirect($target);
    exit;
}, 9);

function alookhor_cc_cart_mutation_guard(WP_REST_Request $request) {
    if (!alookhor_cc_cart_nonce_ok($request)) {
        return new WP_Error('invalid_cart_nonce', 'درخواست سبد خرید معتبر نیست. صفحه را تازه‌سازی کنید.', ['status' => 403]);
    }
    return true;
}

add_action('rest_api_init', function () {
    register_rest_route('alookhor-cart/v4', '/cart', [
        'methods' => 'GET',
        'permission_callback' => '__return_true',
        'callback' => 'alookhor_cc_cart_response',
    ]);

    register_rest_route('alookhor-cart/v4', '/cart/update', [
        'methods' => 'POST',
        'permission_callback' => 'alookhor_cc_cart_mutation_guard',
        'callback' => function (WP_REST_Request $request) {
            if (!alookhor_cc_cart_bootstrap()) return new WP_Error('cart_unavailable', 'WooCommerce cart is unavailable.', ['status' => 503]);
            $key = sanitize_text_field((string) $request->get_param('key'));
            $qty = max(0, absint($request->get_param('quantity')));
            if (!$key) return new WP_Error('missing_key', 'شناسه محصول سبد خرید نامعتبر است.', ['status' => 400]);
            if (!WC()->cart->get_cart_item($key)) return new WP_Error('item_not_found', 'محصول در سبد خرید پیدا نشد.', ['status' => 404]);
            if ($qty === 0) WC()->cart->remove_cart_item($key);
            else if (!WC()->cart->set_quantity($key, $qty, true)) return new WP_Error('quantity_failed', 'تغییر تعداد محصول انجام نشد.', ['status' => 400]);
            WC()->cart->calculate_totals();
            WC()->cart->set_session();
            return alookhor_cc_cart_response();
        },
    ]);

    register_rest_route('alookhor-cart/v4', '/cart/remove', [
        'methods' => 'POST',
        'permission_callback' => 'alookhor_cc_cart_mutation_guard',
        'callback' => function (WP_REST_Request $request) {
            if (!alookhor_cc_cart_bootstrap()) return new WP_Error('cart_unavailable', 'WooCommerce cart is unavailable.', ['status' => 503]);
            $key = sanitize_text_field((string) $request->get_param('key'));
            if (!$key || !WC()->cart->get_cart_item($key)) return new WP_Error('item_not_found', 'محصول در سبد خرید پیدا نشد.', ['status' => 404]);
            WC()->cart->remove_cart_item($key);
            WC()->cart->calculate_totals();
            WC()->cart->set_session();
            return alookhor_cc_cart_response();
        },
    ]);

    register_rest_route('alookhor-cart/v4', '/cart/add', [
        'methods' => 'POST',
        'permission_callback' => 'alookhor_cc_cart_mutation_guard',
        'callback' => function (WP_REST_Request $request) {
            if (!alookhor_cc_cart_bootstrap()) return new WP_Error('cart_unavailable', 'WooCommerce cart is unavailable.', ['status' => 503]);
            $product_id = absint($request->get_param('product_id'));
            $quantity = max(1, absint($request->get_param('quantity') ?: 1));
            $variation_id = absint($request->get_param('variation_id'));
            $variation = $request->get_param('variation');
            $variation = is_array($variation) ? array_map('wc_clean', $variation) : [];

            if (!$product_id) return new WP_Error('missing_product', 'محصول نامعتبر است.', ['status' => 400]);

            /* ── 3.10.413: پیشنهادهای سبد روی لایو «محصول متغیر» هستند؛ اگر variation_id
             * نیامده باشد خودمان بهترین ورییشن موجود را انتخاب می‌کنیم تا «افزودن» کار کند. */
            if (!$variation_id) {
                $parent = wc_get_product($product_id);
                if ($parent && method_exists($parent, 'is_type') && $parent->is_type('variable')) {
                    $children = method_exists($parent, 'get_children') ? (array) $parent->get_children() : array();
                    foreach ($children as $vid) {
                        $ch = wc_get_product($vid);
                        if ($ch && $ch->is_purchasable() && $ch->is_in_stock()) { $variation_id = (int) $vid; break; }
                    }
                    if (!$variation_id) {
                        return new WP_Error('product_unavailable', 'این محصول در حال حاضر قابل خرید نیست.', ['status' => 400]);
                    }
                    $vprod0 = wc_get_product($variation_id);
                    if ($vprod0 && method_exists($vprod0, 'get_variation_attributes')) $variation = (array) $vprod0->get_variation_attributes();
                }
            }

            /* ── 3.10.418: اگر variation_id آمد ولی نقشهٔ ویژگی خالی بود (مثل دکمهٔ «افزودن»
             * کارت پیشنهاد)، از روی خود ورییشن پرش می‌کنیم وگرنه در ردیف سبد گزینه‌اش
             * «بسته استاندارد» نمایش داده می‌شد. */
            if ($variation_id && empty($variation)) {
                $vp_fill = wc_get_product($variation_id);
                if ($vp_fill && method_exists($vp_fill, 'get_variation_attributes')) {
                    $variation = (array) $vp_fill->get_variation_attributes();
                }
            }

            $product = wc_get_product($variation_id ?: $product_id);
            if (!$product || !$product->is_purchasable() || !$product->is_in_stock()) {
                return new WP_Error('product_unavailable', 'این محصول در حال حاضر قابل خرید نیست.', ['status' => 400]);
            }

            $added_key = WC()->cart->add_to_cart($product_id, $quantity, $variation_id, $variation);
            if (!$added_key) return new WP_Error('add_failed', 'افزودن محصول به سبد خرید انجام نشد.', ['status' => 400]);

            WC()->cart->calculate_totals();
            WC()->cart->set_session();
            return alookhor_cc_cart_response();
        },
    ]);

    register_rest_route('alookhor-cart/v4', '/cart/coupon', [
        'methods' => 'POST',
        'permission_callback' => 'alookhor_cc_cart_mutation_guard',
        'callback' => function (WP_REST_Request $request) {
            if (!alookhor_cc_cart_bootstrap()) return new WP_Error('cart_unavailable', 'WooCommerce cart is unavailable.', ['status' => 503]);
            $code = wc_format_coupon_code((string) $request->get_param('code'));
            if (!$code) return new WP_Error('missing_coupon', 'کد تخفیف را وارد کنید.', ['status' => 400]);
            $result = WC()->cart->apply_coupon($code);
            if (!$result) {
                $messages = wc_get_notices('error');
                wc_clear_notices();
                return new WP_Error('coupon_failed', !empty($messages[0]['notice']) ? wp_strip_all_tags($messages[0]['notice']) : 'کد تخفیف قابل اعمال نیست.', ['status' => 400]);
            }
            WC()->cart->calculate_totals();
            WC()->cart->set_session();
            wc_clear_notices();
            return alookhor_cc_cart_response();
        },
    ]);

    register_rest_route('alookhor-cart/v4', '/cart/coupon/remove', [
        'methods' => 'POST',
        'permission_callback' => 'alookhor_cc_cart_mutation_guard',
        'callback' => function () {
            if (!alookhor_cc_cart_bootstrap()) return new WP_Error('cart_unavailable', 'WooCommerce cart is unavailable.', ['status' => 503]);
            foreach ((array) WC()->cart->get_applied_coupons() as $coupon) WC()->cart->remove_coupon($coupon);
            WC()->cart->calculate_totals();
            WC()->cart->set_session();
            wc_clear_notices();
            return alookhor_cc_cart_response();
        },
    ]);

    /* ── 3.10.418: اندپوینت تشخیص موقت — برای یافتنِ علت «محصول در سبد پیدا نشد» روی لایو
     *  کاربر با همان مرورگر خودش بازش می‌کند؛ نشان می‌دهد REST با همان کوکی چه می‌بیند. */
    register_rest_route('alookhor-cart/v4', '/diagnose', [
        'methods' => 'GET',
        'permission_callback' => function () {
            return !empty($_GET['alookhor-diag']) || current_user_can('manage_options');
        },
        'callback' => function () {
            alookhor_cc_cart_bootstrap();
            $cart = WC()->cart ? WC()->cart->get_cart() : array();
            return rest_ensure_response(array(
                'session_id' => method_exists(WC()->session, 'get_customer_id') ? WC()->session->get_customer_id() : null,
                'cookie_keys' => array_keys((array)$_COOKIE),
                'woo_session_cookie' => isset($_COOKIE['wp_woocommerce_session_'.COOKIEHASH]) ? substr((string)$_COOKIE['wp_woocommerce_session_'.COOKIEHASH], 0, 20).'…' : null,
                'logged_in' => is_user_logged_in(),
                'cart_items' => count($cart),
                'cart_keys' => array_keys($cart),
                'plugin' => defined('ALOOKHOR_CC_VERSION') ? ALOOKHOR_CC_VERSION : '?',
            ));
        },
    ]);

    register_rest_route('alookhor-cart/v4', '/recommendations', [
        'methods' => 'GET',
        'permission_callback' => '__return_true',
        'callback' => function () {
            $out = function_exists('alookhor_cc_cart_recommendations') ? alookhor_cc_cart_recommendations(4) : [];
            return rest_ensure_response($out);
        },
    ]);
});
