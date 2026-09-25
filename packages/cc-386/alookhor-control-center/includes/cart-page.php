<?php
/** ALOOKHOR Custom Cart Page — native WooCommerce session cart renderer. */
if (!defined('ABSPATH')) exit;

function alookhor_cc_cart_is_page(){ return function_exists('is_cart') && is_cart(); }

function alookhor_cc_register_cart_assets(){
    if (!alookhor_cc_cart_is_page()) return;
    wp_enqueue_style('alookhor-cc-cart', ALOOKHOR_CC_URL.'assets/css/frontend-cart.css', [], ALOOKHOR_CC_BUILD);
    wp_enqueue_script('alookhor-cc-cart', ALOOKHOR_CC_URL.'assets/js/frontend-cart.js', [], ALOOKHOR_CC_BUILD, true);
    wp_localize_script('alookhor-cc-cart', 'ALOOKHOR_CART_CONFIG', [
        'nonce' => wp_create_nonce('alookhor_cart'),
        'cartApi' => rest_url('alookhor-cart/v4/'),
        'cartUrl' => function_exists('wc_get_cart_url') ? wc_get_cart_url() : home_url('/cart/'),
        'shopUrl' => function_exists('wc_get_shop_page_permalink') ? wc_get_shop_page_permalink() : home_url('/shop/'),
        'checkoutUrl' => function_exists('wc_get_checkout_url') ? wc_get_checkout_url() : home_url('/checkout/'),
    ]);
}
add_action('wp_enqueue_scripts', 'alookhor_cc_register_cart_assets', 1005);

function alookhor_cc_cart_markup(){
    $checkout = function_exists('wc_get_checkout_url') ? wc_get_checkout_url() : home_url('/checkout/');
    $shop = function_exists('wc_get_shop_page_permalink') ? wc_get_shop_page_permalink() : home_url('/shop/');
    ob_start(); ?>
<section id="alookhor-cart" class="alookhor-cart-page" dir="rtl" aria-labelledby="alookhor-cart-title">
  <div class="cart-shell">
    <header class="cart-heading">
      <div>
        <span class="eyebrow">ALOOKHOR • LUXURY SHOPPING</span>
        <h1 id="alookhor-cart-title">سبد خرید</h1>
        <p class="cart-subtitle">محصولات انتخاب‌شده شما در اینجا نمایش داده می‌شوند.</p>
      </div>
      <a class="continue-shopping" href="<?php echo esc_url($shop); ?>">ادامه خرید</a>
    </header>

    <div class="cart-error" role="alert" hidden></div>
    <div class="cart-layout">
      <section class="cart-products" aria-labelledby="alookhor-cart-items-title">
        <div class="cart-list-head">
          <strong id="alookhor-cart-items-title">لیست خرید شما</strong>
          <span class="cart-items-count" aria-live="polite">در حال بارگذاری…</span>
        </div>
        <div class="cart-items" aria-live="polite">
          <div class="cart-loading">در حال بارگذاری سبد خرید…</div>
        </div>
      </section>

      <aside class="cart-summary" aria-label="خلاصه سفارش">
        <div class="summary-card">
          <h2>خلاصه سفارش</h2>
          <div class="summary-rows">
            <div class="summary-row"><span>جمع محصولات</span><span class="value">۰ تومان</span></div>
            <div class="summary-row"><span>تخفیف</span><span class="value">۰ تومان</span></div>
            <div class="summary-row"><span>ارسال</span><span class="value">رایگان</span></div>
          </div>
          <div class="summary-total"><span>مبلغ نهایی</span><strong class="value">۰ تومان</strong></div>
          <a class="checkout-btn" href="<?php echo esc_url($checkout); ?>">ادامه تا تسویه‌حساب</a>

          <div class="coupon-box">
            <label for="alookhor-cart-coupon">کد تخفیف</label>
            <div>
              <input id="alookhor-cart-coupon" type="text" autocomplete="off" inputmode="text" placeholder="کد تخفیف را وارد کنید">
              <button type="button">اعمال</button>
            </div>
          </div>
          <div class="shipping-note"><strong>ارسال امن</strong><span>هزینه و روش ارسال در مرحله پرداخت نهایی می‌شود.</span></div>
        </div>
      </aside>
    </div>

    <section class="cart-suggestions" aria-labelledby="alookhor-suggestions-title">
      <div class="suggestions-heading">
        <span class="eyebrow">CURATED FOR YOU</span>
        <h2 id="alookhor-suggestions-title">پیشنهادهای آلوخور</h2>
      </div>
      <div class="suggested-grid" aria-live="polite"></div>
    </section>

    <a class="mobile-checkout" href="<?php echo esc_url($checkout); ?>">ادامه تا تسویه‌حساب</a>
  </div>
</section>
<?php return ob_get_clean();
}
function alookhor_cc_replace_cart_content($content){ if(!alookhor_cc_cart_is_page() || is_admin()) return $content; return alookhor_cc_cart_markup(); }
add_filter('the_content','alookhor_cc_replace_cart_content',9999);

function alookhor_cc_remove_legacy_cart_wrappers(){
    if(!alookhor_cc_cart_is_page()) return;
    remove_action('woocommerce_before_cart','woocommerce_output_all_notices',10);
}
add_action('wp','alookhor_cc_remove_legacy_cart_wrappers',100);

/* ── 3.10.401: دو مسیر اجرای صفحهٔ سبد را یکجا پوشش می‌دهیم ──
 * قالب سایت برای رندر صفحهٔ سبد خرید از تابع جهانی `woocommerce_cart()` استفاده می‌کند
 * که در نسخه‌های جدید ووکامرس وجود ندارد → قالب به‌اشتباه پیام «ووکامرس نصب نیست» نشان می‌داد.
 * هم تابع جهانی می‌سازیم، هم همان شورت‌کد را دوباره به رندر سفارشی وصل می‌کنیم.
 */
if (!function_exists('woocommerce_cart')) {
    function woocommerce_cart() {
        if (function_exists('alookhor_cc_cart_markup')) {
            echo alookhor_cc_cart_markup();
        }
    }
}
if (function_exists('alookhor_cc_cart_markup')) {
    if (shortcode_exists('woocommerce_cart')) remove_shortcode('woocommerce_cart');
    add_shortcode('woocommerce_cart', function () { return alookhor_cc_cart_markup(); });
}
