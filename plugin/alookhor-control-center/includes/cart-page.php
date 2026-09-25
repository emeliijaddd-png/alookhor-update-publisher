<?php
/** ALOOKHOR Cart — single custom renderer, WooCommerce Store API backed. */
if (!defined('ABSPATH')) exit;

function alookhor_cc407_cart_is_page(){ return function_exists('is_cart') && is_cart(); }

function alookhor_cc407_register_cart_assets(){
    if (!alookhor_cc407_cart_is_page()) return;
    wp_enqueue_style('alookhor-cc-cart', ALOOKHOR_CC_URL.'assets/css/frontend-cart.css', [], ALOOKHOR_CC_BUILD);
    wp_enqueue_script('alookhor-cc-cart', ALOOKHOR_CC_URL.'assets/js/frontend-cart.js', [], ALOOKHOR_CC_BUILD, true);
    wp_localize_script('alookhor-cc-cart', 'ALOOKHOR_CART_CONFIG', [
        'storeApi' => rest_url('wc/store/v1/'),
        'recommendationsApi' => rest_url('alookhor-cart/v4/recommendations'),
        'cartUrl' => function_exists('wc_get_cart_url') ? wc_get_cart_url() : home_url('/cart/'),
        'shopUrl' => function_exists('wc_get_shop_page_permalink') ? wc_get_shop_page_permalink() : home_url('/shop/'),
        'checkoutUrl' => function_exists('wc_get_checkout_url') ? wc_get_checkout_url() : home_url('/checkout/'),
    ]);
}
add_action('wp_enqueue_scripts', 'alookhor_cc407_register_cart_assets', 1005);

function alookhor_cc407_cart_markup(){
    $checkout = function_exists('wc_get_checkout_url') ? wc_get_checkout_url() : home_url('/checkout/');
    $shop = function_exists('wc_get_shop_page_permalink') ? wc_get_shop_page_permalink() : home_url('/shop/');
    ob_start(); ?>
<section id="alookhor-cart" class="alookhor-cart-page" dir="rtl" aria-labelledby="alookhor-cart-title">
  <div class="ac-hero">
    <div class="ac-hero-top">
      <nav class="ac-crumb" aria-label="مسیر صفحه"><a href="<?php echo esc_url(home_url('/')); ?>">خانه</a><span aria-hidden="true">‹</span><span>سبد خرید</span></nav>
      <span class="ac-chip">طعم اصالت از دل طبیعت ایران</span>
    </div>
    <h1 id="alookhor-cart-title">سبد خرید شما</h1>
    <p>محصولات منتخب شما در یک نگاه، با اطمینان خرید کنید.</p>
  </div>

  <div class="ac-wrap">
    <div class="cart-error" role="alert" aria-live="assertive" hidden></div>
    <div class="ac-grid">
      <section class="ac-products" aria-labelledby="ac-products-title">
        <div class="ac-products-head"><strong id="ac-products-title">محصولات شما <span class="cart-items-count">(۰ کالا)</span></strong><span>🛒</span></div>
        <div class="ac-thead" aria-hidden="true"><span>محصول</span><span>وزن / بسته‌بندی</span><span>قیمت واحد</span><span>تعداد</span><span>مبلغ کل</span><span>عملیات</span></div>
        <div class="cart-items" aria-live="polite"><div class="cart-loading">در حال بارگذاری سبد خرید…</div></div>
        <div class="ac-products-foot"><a class="ac-continue" href="<?php echo esc_url($shop); ?>">← ادامه خرید</a></div>
      </section>

      <aside class="ac-summary" aria-label="خلاصه سفارش">
        <strong class="sum-title">خلاصه سفارش</strong>
        <div class="sum-rows">
          <div class="sum-row"><span>جمع مبلغ کالاها</span><span class="value">۰ تومان</span></div>
          <div class="sum-row"><span>تخفیف</span><span class="value">۰ تومان</span></div>
          <div class="sum-row"><span>هزینه ارسال</span><span class="value">در حال محاسبه</span></div>
        </div>
        <div class="sum-total"><span>مبلغ قابل پرداخت</span><b class="value">۰ تومان</b></div>
        <a class="ac-checkout" href="<?php echo esc_url($checkout); ?>">ادامه و ثبت سفارش ←</a>
        <div class="ac-coupon">
          <label for="alookhor-cart-coupon">کد تخفیف دارید؟</label>
          <div class="ac-coupon-row"><input id="alookhor-cart-coupon" type="text" autocomplete="off" inputmode="text" placeholder="کد تخفیف را وارد کنید…"><button type="button">اعمال</button></div>
          <small class="coupon-feedback" aria-live="polite"></small>
        </div>
        <div class="ac-shipnote"><strong>هزینه ارسال</strong><span>بر اساس مقصد و روش ارسال در سبد/تسویه‌حساب محاسبه می‌شود.</span></div>
      </aside>
    </div>

    <section class="ac-suggest" aria-labelledby="ac-suggest-title">
      <header class="ac-sec-head"><strong id="ac-suggest-title">پیشنهاد تکمیل خرید</strong><small>محصولات مرتبط با انتخاب شما</small></header>
      <div class="suggested-grid" aria-live="polite"><div class="suggest-loading">در حال دریافت پیشنهادها…</div></div>
    </section>

    <section class="ac-trust" aria-label="مزیت‌های خرید">
      <div><strong>پشتیبانی ۲۴/۷</strong><small>پاسخگوی شما هستیم</small></div>
      <div><strong>ضمانت اصالت</strong><small>تضمین کیفیت محصول</small></div>
      <div><strong>ارسال مطمئن</strong><small>بسته‌بندی امن سفارش</small></div>
      <div><strong>خرید امن</strong><small>پرداخت در مسیر رسمی سایت</small></div>
    </section>

    <section class="ac-faq" aria-labelledby="ac-faq-title">
      <header class="ac-sec-head"><strong id="ac-faq-title">سوالات متداول</strong><small>پاسخ به پرسش‌های پرتکرار</small></header>
      <div class="faq-list">
        <div class="faq-item"><button type="button" class="faq-q">هزینه ارسال سفارش چقدر است؟ <span>＋</span></button><div class="faq-a"><p>هزینه ارسال بر اساس مقصد، وزن و روش ارسال محاسبه می‌شود و مبلغ نهایی در فرایند خرید نمایش داده خواهد شد.</p></div></div>
        <div class="faq-item"><button type="button" class="faq-q">آیا می‌توانم تعداد محصول را تغییر دهم؟ <span>＋</span></button><div class="faq-a"><p>بله. با دکمه‌های + و − تعداد را تغییر دهید؛ مبلغ سفارش بدون بارگذاری مجدد به‌روزرسانی می‌شود.</p></div></div>
        <div class="faq-item"><button type="button" class="faq-q">اگر محصول پیشنهادی گزینه داشته باشد چه کنم؟ <span>＋</span></button><div class="faq-a"><p>برای محصولات متغیر، دکمه «انتخاب گزینه‌ها» شما را به صفحه محصول می‌برد تا وزن و کیفیت را انتخاب کنید.</p></div></div>
      </div>
    </section>
  </div>
  <a class="mobile-checkout" href="<?php echo esc_url($checkout); ?>">ادامه و ثبت سفارش</a>
</section>
<?php return ob_get_clean();
}

function alookhor_cc407_replace_cart_content($content){
    if (!alookhor_cc407_cart_is_page() || is_admin()) return $content;
    return alookhor_cc407_cart_markup();
}
add_filter('the_content','alookhor_cc407_replace_cart_content',9999);

function alookhor_cc407_remove_legacy_cart_wrappers(){
    if (!alookhor_cc407_cart_is_page()) return;
    remove_action('woocommerce_before_cart','woocommerce_output_all_notices',10);
}
add_action('wp','alookhor_cc407_remove_legacy_cart_wrappers',100);
