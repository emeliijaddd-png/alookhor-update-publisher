<?php
/**
 * ALOOKHOR Custom Cart Page
 * Single renderer: the WordPress cart page is replaced with the ALOOKHOR luxury cart.
 */
if (!defined('ABSPATH')) exit;

function alookhor_cc_cart_is_page() {
    return function_exists('is_cart') && is_cart();
}

function alookhor_cc_register_cart_assets() {
    if (!alookhor_cc_cart_is_page()) return;

    wp_enqueue_style(
        'alookhor-cc-cart',
        ALOOKHOR_CC_URL . 'assets/css/frontend-cart.css',
        [],
        ALOOKHOR_CC_BUILD
    );

    wp_enqueue_script(
        'alookhor-cc-cart',
        ALOOKHOR_CC_URL . 'assets/js/frontend-cart.js',
        [],
        ALOOKHOR_CC_BUILD,
        true
    );

    wp_localize_script('alookhor-cc-cart', 'ALOOKHOR_CART_CONFIG', [
        'nonce' => wp_create_nonce('wc_store_api'),
        'cartUrl' => function_exists('wc_get_cart_url') ? wc_get_cart_url() : home_url('/cart/'),
        'shopUrl' => function_exists('wc_get_shop_page_permalink') ? wc_get_shop_page_permalink() : home_url('/shop/'),
    ]);

    wp_add_inline_style('alookhor-cc-cart', '
        body.woocommerce-cart .woocommerce-cart-form,
        body.woocommerce-cart .cart-collaterals,
        body.woocommerce-cart .woocommerce > .cart-empty,
        body.woocommerce-cart .return-to-shop,
        body.woocommerce-cart .cross-sells,
        body.woocommerce-cart .wd-cart,
        body.woocommerce-cart .wd-empty-cart,
        body.woocommerce-cart .wd-cross-sells,
        body.woocommerce-cart .elementor-widget-woocommerce-cart,
        body.woocommerce-cart .elementor-widget-wd_products,
        body.woocommerce-cart .wd-products-element { display:none!important; }
        body.woocommerce-cart #alookhor-cart { display:block!important; visibility:visible!important; opacity:1!important; width:100%; position:relative; z-index:2; }
        body.woocommerce-cart #alookhor-cart + * { clear:both; }
    ');
}
add_action('wp_enqueue_scripts', 'alookhor_cc_register_cart_assets', 1005);

function alookhor_cc_cart_markup() {
    ob_start(); ?>
    <section id="alookhor-cart" class="alookhor-cart-page" dir="rtl" aria-labelledby="alookhor-cart-title">
        <div class="cart-shell">
            <header class="cart-heading">
                <div>
                    <span class="eyebrow">ALOOKHOR • LUXURY SHOPPING</span>
                    <h1 id="alookhor-cart-title">سبد خرید</h1>
                    <p class="cart-subtitle">محصولات انتخاب‌شده شما در اینجا نمایش داده می‌شوند.</p>
                </div>
                <a class="continue-shopping" href="<?php echo esc_url(function_exists('wc_get_shop_page_permalink') ? wc_get_shop_page_permalink() : home_url('/shop/')); ?>">ادامه خرید</a>
            </header>

            <div class="cart-error" role="alert" style="display:none"></div>
            <div class="cart-loading" aria-live="polite">در حال بارگذاری سبد خرید…</div>

            <div class="cart-layout">
                <div class="cart-products">
                    <div class="cart-list-head">
                        <strong>لیست خرید شما</strong>
                        <span class="cart-items-count" aria-live="polite"></span>
                    </div>
                    <div class="cart-items" aria-live="polite"></div>
                </div>

                <aside class="cart-summary" aria-label="خلاصه سفارش">
                    <div class="summary-card">
                        <h2>خلاصه سفارش</h2>
                        <div class="summary-rows">
                            <div class="summary-row"><span>جمع محصولات</span><span class="value">۰ تومان</span></div>
                            <div class="summary-row"><span>تخفیف</span><span class="value">۰ تومان</span></div>
                            <div class="summary-row"><span>ارسال</span><span class="value">رایگان</span></div>
                        </div>
                        <div class="summary-total"><span>مبلغ نهایی</span><strong class="value">۰ تومان</strong></div>
                        <a class="checkout-btn" href="<?php echo esc_url(function_exists('wc_get_checkout_url') ? wc_get_checkout_url() : home_url('/checkout/')); ?>">ادامه تا تسویه‌حساب</a>
                        <div class="coupon-box">
                            <label for="alookhor-cart-coupon">کد تخفیف</label>
                            <div><input id="alookhor-cart-coupon" type="text" autocomplete="off" placeholder="کد تخفیف را وارد کنید"><button type="button">اعمال</button></div>
                        </div>
                    </div>
                </aside>
            </div>

            <section class="cart-suggestions" aria-labelledby="alookhor-suggestions-title">
                <div class="suggestions-heading">
                    <div><span class="eyebrow">CURATED FOR YOU</span><h2 id="alookhor-suggestions-title">پیشنهادهای آلوخور</h2></div>
                </div>
                <div class="suggested-grid"></div>
            </section>
        </div>
    </section>
    <?php
    return ob_get_clean();
}

function alookhor_cc_replace_cart_content($content) {
    if (!alookhor_cc_cart_is_page() || is_admin()) return $content;
    return alookhor_cc_cart_markup();
}
add_filter('the_content', 'alookhor_cc_replace_cart_content', 9999);

function alookhor_cc_remove_legacy_cart_wrappers() {
    if (!alookhor_cc_cart_is_page()) return;
    // The content filter above prevents the WooCommerce cart shortcode from rendering.
    // These hooks cover themes/plugins that inject a second cart outside page content.
    remove_action('woocommerce_before_cart', 'woocommerce_output_all_notices', 10);
}
add_action('wp', 'alookhor_cc_remove_legacy_cart_wrappers', 100);
