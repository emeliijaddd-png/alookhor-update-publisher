<?php
/**
 * WP-CLI fixture for an isolated WordPress/WooCommerce CI installation.
 * Never run against a live store. No orders or customers are created.
 */
if (!defined('WP_CLI') || !WP_CLI || !defined('ABSPATH') || !class_exists('WC_Product_Simple')) {
    throw new RuntimeException('Isolated WP-CLI + WooCommerce are required.');
}
$ids_path = getenv('WP_SMOKE_IDS');
if (!$ids_path || !str_starts_with($ids_path, sys_get_temp_dir() . '/')) {
    throw new RuntimeException('WP_SMOKE_IDS must be a temporary local file.');
}

// The stock Woo install may set a Cart block; our custom cart renderer uses is_cart().
$cart_page = wc_get_page_id('cart');
if ($cart_page <= 0) {
    $cart_page = wp_insert_post(array(
        'post_title' => 'Cart', 'post_name' => 'cart', 'post_status' => 'publish',
        'post_type' => 'page', 'post_content' => '[woocommerce_cart]',
    ));
} else {
    wp_update_post(array('ID' => $cart_page, 'post_status' => 'publish', 'post_content' => '[woocommerce_cart]'));
}
if (!$cart_page || is_wp_error($cart_page)) throw new RuntimeException('Cart page setup failed.');
update_option('woocommerce_cart_page_id', $cart_page);

$simples = array();
for ($n = 1; $n <= 3; $n++) {
    $product = new WC_Product_Simple();
    $product->set_name('CI simple ' . $n);
    $product->set_status('publish');
    $product->set_regular_price((string) (10000 * $n));
    $product->set_stock_status('instock');
    $simples[] = $product->save();
}
$attribute = new WC_Product_Attribute();
$attribute->set_id(0);
$attribute->set_name('weight');
$attribute->set_options(array('500g'));
$attribute->set_visible(true);
$attribute->set_variation(true);
$parent = new WC_Product_Variable();
$parent->set_name('CI variable 500g');
$parent->set_status('publish');
$parent->set_stock_status('instock');
$parent->set_attributes(array($attribute));
$parent_id = $parent->save();
$variant = new WC_Product_Variation();
$variant->set_parent_id($parent_id);
$variant->set_status('publish');
$variant->set_stock_status('instock');
$variant->set_regular_price('45000');
$variant->set_attributes(array('weight' => '500g'));
$variant_id = $variant->save();
WC_Product_Variable::sync($parent_id);
$parent = wc_get_product($parent_id);
$parent->set_total_sales(99999); // ensure the fixture is among the four popular suggestions
$parent->save();
if (!$parent_id || !$variant_id || in_array(0, $simples, true)) {
    throw new RuntimeException('Woo product fixtures could not be saved.');
}
file_put_contents($ids_path, wp_json_encode(array(
    'simple' => $simples, 'parent' => $parent_id, 'variation' => $variant_id,
)));
echo "CI fixtures created: three simple products and one purchasable variable product.\n";
