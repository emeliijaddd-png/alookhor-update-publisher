<?php
/** ALOOKHOR cart recommendation REST endpoint. */
if (!defined('ABSPATH')) exit;

add_action('rest_api_init', function () {
    register_rest_route('alookhor-cart/v3', '/recommendations', [
        'methods' => 'GET',
        'permission_callback' => '__return_true',
        'callback' => function () {
            if (!function_exists('wc_get_products')) return rest_ensure_response([]);
            $products = wc_get_products([
                'status' => 'publish',
                'limit' => 8,
                'orderby' => 'popularity',
                'order' => 'DESC',
                'return' => 'objects',
            ]);
            $out = [];
            foreach ($products as $product) {
                if (!$product || !$product->is_purchasable() || !$product->is_in_stock()) continue;
                $out[] = [
                    'id' => (int) $product->get_id(),
                    'name' => $product->get_name(),
                    'price' => (float) wc_get_price_to_display($product),
                    'image' => wp_get_attachment_image_url($product->get_image_id(), 'woocommerce_thumbnail') ?: wc_placeholder_img_src(),
                    'on_sale' => $product->is_on_sale(),
                ];
                if (count($out) >= 4) break;
            }
            return rest_ensure_response($out);
        },
    ]);
});
