<?php
if(!defined('ABSPATH')) exit;

/**
 * ALOOKHOR Cart v4 - REST API for recommendations and cart helpers
 * Endpoint: /wp-json/alookhor-cart/v3/recommendations
 */

add_action('rest_api_init', function(){
    register_rest_route('alookhor-cart/v3', '/recommendations', [
        'methods' => 'GET',
        'permission_callback' => '__return_true',
        'callback' => 'alookhor_cc_cart_rest_recommendations',
        'args' => [
            'exclude' => [
                'type' => 'string',
                'required' => false,
            ],
            'limit' => [
                'type' => 'integer',
                'required' => false,
                'default' => 4,
            ],
        ],
    ]);

    register_rest_route('alookhor-cart/v3', '/cart-data', [
        'methods' => 'GET',
        'permission_callback' => '__return_true',
        'callback' => 'alookhor_cc_cart_rest_cart_data',
    ]);
});

function alookhor_cc_cart_rest_recommendations($request){
    $exclude_param = $request->get_param('exclude');
    $exclude_ids = [];
    if($exclude_param){
        $exclude_ids = array_map('intval', explode(',', $exclude_param));
    }
    // Also exclude current cart items
    if(function_exists('WC') && WC()->cart){
        foreach(WC()->cart->get_cart() as $ci){
            $exclude_ids[] = $ci['product_id'];
            if($ci['variation_id']) $exclude_ids[] = $ci['variation_id'];
        }
    }
    $exclude_ids = array_unique(array_filter($exclude_ids));

    $limit = (int)($request->get_param('limit') ?: 4);
    $limit = max(1, min(8, $limit));

    // Try to get related products from cart first item
    $related_ids = [];
    if(!empty($exclude_ids) && function_exists('wc_get_related_products')){
        $first_id = $exclude_ids[0] ?? 0;
        if($first_id){
            $related_ids = wc_get_related_products($first_id, 20);
        }
    }

    // Filter out Samsung and excluded
    $filtered = [];
    $check_product = function($pid) use ($exclude_ids){
        if(in_array($pid, $exclude_ids)) return false;
        $p = wc_get_product($pid);
        if(!$p) return false;
        if(!$p->is_purchasable() || $p->get_status() !== 'publish') return false;
        $name = $p->get_name();
        // Filter Samsung / phone demo products
        if(strpos($name, 'سامسونگ')!==false || strpos($name, 'گوشی')!==false || stripos($name, 'samsung')!==false || stripos($name, 'phone')!==false) return false;
        return true;
    };

    if(!empty($related_ids)){
        foreach($related_ids as $fid){
            if($check_product($fid)){
                $filtered[] = $fid;
                if(count($filtered) >= $limit) break;
            }
        }
    }

    // Fallback to bestsellers / recent
    if(count($filtered) < $limit){
        $fallback = wc_get_products([
            'limit' => 30,
            'return' => 'ids',
            'status' => 'publish',
            'orderby' => 'popularity',
            'order' => 'DESC',
        ]);
        foreach($fallback as $fid){
            if(count($filtered) >= $limit) break;
            if(in_array($fid, $filtered)) continue;
            if($check_product($fid)){
                $filtered[] = $fid;
            }
        }
    }

    // Fallback to any products
    if(count($filtered) < $limit){
        $any = wc_get_products([
            'limit' => 30,
            'return' => 'ids',
            'status' => 'publish',
            'orderby' => 'date',
            'order' => 'DESC',
        ]);
        foreach($any as $fid){
            if(count($filtered) >= $limit) break;
            if(in_array($fid, $filtered)) continue;
            if($check_product($fid)){
                $filtered[] = $fid;
            }
        }
    }

    $result = [];
    foreach(array_slice($filtered, 0, $limit) as $pid){
        $prod = wc_get_product($pid);
        if(!$prod) continue;
        $img = wp_get_attachment_image_url($prod->get_image_id(), 'woocommerce_thumbnail');
        if(!$img) $img = wp_get_attachment_image_url($prod->get_image_id(), 'full');
        if(!$img) {
            $gallery = $prod->get_gallery_image_ids();
            if(!empty($gallery)){
                $img = wp_get_attachment_image_url($gallery[0], 'woocommerce_thumbnail');
            }
        }
        $price = (float)$prod->get_price();
        $regular = (float)$prod->get_regular_price();
        if(!$price && $prod->is_type('variable')){
            $price = (float)$prod->get_variation_price('min', true);
            $regular = (float)$prod->get_variation_regular_price('min', true);
        }
        $on_sale = $prod->is_on_sale();
        $discount_percent = 0;
        if($on_sale && $regular > 0 && $price < $regular){
            $discount_percent = (int)round((($regular - $price) / $regular) * 100);
        }

        $variations = [];
        if($prod->is_type('variable')){
            $available_vars = $prod->get_available_variations();
            foreach(array_slice($available_vars, 0, 10) as $var){
                $var_id = $var['variation_id'];
                $var_prod = wc_get_product($var_id);
                if(!$var_prod) continue;
                $v_price = (float)$var_prod->get_price();
                $v_regular = (float)$var_prod->get_regular_price();
                $v_stock = $var_prod->get_stock_status();
                $v_purchasable = $var_prod->is_purchasable() && $var_prod->is_in_stock();
                $attrs = [];
                foreach($var['attributes'] as $k=>$v){
                    $attrs[$k] = $v;
                }
                $variations[] = [
                    'id' => $var_id,
                    'attributes' => $attrs,
                    'price' => $v_price,
                    'regular_price' => $v_regular,
                    'sale_price' => $v_price,
                    'stock_status' => $v_stock,
                    'purchasable' => $v_purchasable,
                    'is_purchasable' => $v_purchasable,
                ];
            }
        }

        $result[] = [
            'id' => $prod->get_id(),
            'name' => $prod->get_name(),
            'permalink' => get_permalink($prod->get_id()),
            'image' => $img ?: ALOOKHOR_CC_URL.'assets/images/bowl.jpg',
            'type' => $prod->get_type(),
            'sku' => $prod->get_sku(),
            'price' => $price,
            'regular_price' => $regular ?: $price,
            'sale_price' => $price,
            'on_sale' => $on_sale,
            'discount_percent' => $discount_percent,
            'stock_status' => $prod->get_stock_status(),
            'purchasable' => $prod->is_purchasable(),
            'is_purchasable' => $prod->is_purchasable() && $prod->is_in_stock(),
            'variations' => $variations,
        ];
    }

    return rest_ensure_response($result);
}

function alookhor_cc_cart_rest_cart_data($request){
    if(!function_exists('WC') || !WC() || !WC()->cart){
        return rest_ensure_response(['items'=>[], 'count'=>0, 'totals'=>[]]);
    }
    $cart = WC()->cart;
    $items = [];
    foreach($cart->get_cart() as $key=>$ci){
        $prod = $ci['data'];
        if(!$prod) continue;
        $items[] = [
            'key' => $key,
            'id' => $ci['product_id'],
            'variation_id' => $ci['variation_id'],
            'name' => $prod->get_name(),
            'quantity' => $ci['quantity'],
            'price' => (float)$prod->get_price(),
            'regular_price' => (float)$prod->get_regular_price(),
            'image' => wp_get_attachment_image_url($prod->get_image_id(), 'thumbnail'),
            'permalink' => get_permalink($ci['product_id']),
            'variation' => $ci['variation'],
        ];
    }
    return rest_ensure_response([
        'items' => $items,
        'count' => $cart->get_cart_contents_count(),
        'subtotal' => $cart->get_subtotal(),
        'total' => $cart->get_total('edit'),
        'coupons' => $cart->get_applied_coupons(),
    ]);
}
