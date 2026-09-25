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
                $variation[] = [
                    'name' => wc_attribute_label(str_replace('attribute_', '', $attr), $product),
                    'value' => wc_clean($value),
                ];
            }
        }

        $items[] = [
            'key' => (string) $key,
            'id' => (int) $product->get_id(),
            'variation_id' => !empty($item['variation_id']) ? (int) $item['variation_id'] : 0,
            'name' => $product->get_name(),
            'permalink' => $product->get_permalink($product->is_visible() ? [] : ['force_redirect' => true]),
            'quantity' => max(1, (int) ($item['quantity'] ?? 1)),
            'variation' => $variation,
            'image' => wp_get_attachment_image_url($product->get_image_id(), 'woocommerce_thumbnail') ?: wc_placeholder_img_src(),
            'price' => (float) wc_get_price_to_display($product),
            'line_total' => (float) wc_get_price_to_display($product, ['qty' => (int) ($item['quantity'] ?? 1)]),
        ];
    }

    $totals = WC()->cart->get_totals();
    return [
        'items' => $items,
        'count' => (int) WC()->cart->get_cart_contents_count(),
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
    if (is_wp_error($payload)) return $payload;
    $response = rest_ensure_response($payload);
    if ($response instanceof WP_REST_Response) {
        $response->header('Cache-Control', 'private, no-store, no-cache, must-revalidate, max-age=0');
        $response->header('Pragma', 'no-cache');
        $response->header('Vary', 'Cookie');
    }
    return $response;
}

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

    register_rest_route('alookhor-cart/v4', '/recommendations', [
        'methods' => 'GET',
        'permission_callback' => '__return_true',
        'callback' => function () {
            if (!function_exists('wc_get_products')) return rest_ensure_response([]);
            $cart_ids = [];
            $terms = [];
            if (function_exists('WC') && WC()->cart) {
                foreach (WC()->cart->get_cart() as $item) {
                    $pid = !empty($item['product_id']) ? (int) $item['product_id'] : 0;
                    $vid = !empty($item['variation_id']) ? (int) $item['variation_id'] : 0;
                    if ($pid) $cart_ids[] = $pid;
                    if ($vid) $cart_ids[] = $vid;
                    foreach (['product_cat','product_tag'] as $tax) {
                        if ($pid) $terms = array_merge($terms, wp_get_post_terms($pid, $tax, ['fields'=>'ids']));
                    }
                }
            }
            $cart_ids = array_values(array_unique(array_map('absint',$cart_ids)));
            $terms = array_values(array_unique(array_map('absint',$terms)));
            $args = [
                'status'=>'publish','limit'=>12,'exclude'=>$cart_ids,'orderby'=>'date','order'=>'DESC','return'=>'objects',
            ];
            if ($terms) $args['category'] = implode(',', $terms);
            $products = wc_get_products($args);
            if (count($products) < 4) {
                $fallback = wc_get_products([
                    'status'=>'publish','limit'=>12,'exclude'=>$cart_ids,'orderby'=>'popularity','order'=>'DESC','return'=>'objects'
                ]);
                $seen = array_fill_keys(array_map(fn($p)=>(int)$p->get_id(),$products),true);
                foreach ($fallback as $p) {
                    if (!isset($seen[$p->get_id()])) {$products[]=$p;$seen[$p->get_id()]=true;}
                    if (count($products)>=8) break;
                }
            }
            $out=[];
            foreach($products as $product){
                if(!$product || !$product->is_visible() || !$product->is_in_stock()) continue;
                $type=$product->get_type();
                $has_options=!in_array($type,['simple','external'],true);
                $out[]=[
                    'id'=>(int)$product->get_id(),
                    'name'=>$product->get_name(),
                    'price'=>(float)wc_get_price_to_display($product),
                    'image'=>wp_get_attachment_image_url($product->get_image_id(),'woocommerce_thumbnail') ?: wc_placeholder_img_src(),
                    'on_sale'=>$product->is_on_sale(),
                    'has_options'=>$has_options,
                    'type'=>$type,
                    'permalink'=>$product->get_permalink(),
                ];
                if(count($out)>=4) break;
            }
            return rest_ensure_response($out);
        },
    ]
