<?php
/** ALOOKHOR Custom Cart Page — native WooCommerce session cart renderer (SSR + live hydration). */
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

/* ── قالب‌بندی اعداد فارسی ── */
function alookhor_cc_cart_fa($n) {
    return alookhor_cc_cart_fp(number_format((float) $n, 0, '.', '٬'));
}
function alookhor_cc_cart_fp($s) {
    return strtr((string) $s, array('0'=>'۰','1'=>'۱','2'=>'۲','3'=>'۳','4'=>'۴','5'=>'۵','6'=>'۶','7'=>'۷','8'=>'۸','9'=>'۹'));
}

/* ── رندر server-side یک ردیف محصول (دقیقاً همان HTML کلاینت JS) ── */
function alookhor_cc_cart_items_html($items) {
    ob_start();
    foreach ((array) $items as $i) {
        $img   = isset($i['image']) ? (string) $i['image'] : '';
        $price = (float) (isset($i['price']) ? $i['price'] : 0);
        $line  = (float) (isset($i['line_total']) ? $i['line_total'] : 0);
        $key   = isset($i['key']) ? (string) $i['key'] : '';
        $name  = isset($i['name']) ? (string) $i['name'] : 'محصول';
        $qty   = max(1, (int) (isset($i['quantity']) ? $i['quantity'] : 1));
        $pid   = (int) (isset($i['id']) ? $i['id'] : 0);
        $desc  = isset($i['short_desc']) ? (string) $i['short_desc'] : '';
        $featured  = !empty($i['featured']);
        $on_sale   = !empty($i['on_sale']);
        $variant_values = array();
        if (!empty($i['variation']) && is_array($i['variation'])) {
            foreach ($i['variation'] as $v) { if (isset($v['value']) && $v['value'] !== '') $variant_values[] = $v['value']; }
        }
        $variant = $variant_values ? implode(' / ', $variant_values) : 'بسته استاندارد';
        $permalink = !empty($i['permalink']) ? (string) $i['permalink'] : '#';
        ?>
<article class="cart-row" data-key="<?php echo esc_attr($key); ?>">
  <div class="c-prod">
    <span class="c-thumb"><img src="<?php echo esc_url($img); ?>" alt="<?php echo esc_attr($name); ?>" loading="lazy" decoding="async"></span>
    <span class="c-meta">
      <a class="c-name" href="<?php echo esc_url($permalink); ?>"><?php echo esc_html($name); ?></a>
      <?php if ($desc !== ''): ?><small class="c-desc"><?php echo esc_html($desc); ?></small><?php endif; ?>
      <span class="c-badges">
        <?php if ($featured): ?><span class="c-badge c-badge-premium">♛ ممتاز</span><?php endif; ?>
        <?php if ($on_sale): ?><span class="c-badge c-badge-sale">تخفیف</span><?php endif; ?>
      </span>
    </span>
  </div>
  <span class="c-variant"><?php echo esc_html($variant); ?></span>
  <span class="c-price"><?php echo esc_html(alookhor_cc_cart_fa($price)); ?><small>تومان</small></span>
  <span class="c-qty"><button type="button" data-cart-qty="-" data-key="<?php echo esc_attr($key); ?>" aria-label="کاهش تعداد">−</button><b><?php echo esc_html(alookhor_cc_cart_fp($qty)); ?></b><button class="c-plus" type="button" data-cart-qty="+" data-key="<?php echo esc_attr($key); ?>" aria-label="افزایش تعداد">+</button></span>
  <span class="c-total"><?php echo esc_html(alookhor_cc_cart_fa($line)); ?><small>تومان</small></span>
  <span class="c-ops">
    <button type="button" class="c-op c-del" data-cart-remove="<?php echo esc_attr($key); ?>" aria-label="حذف <?php echo esc_attr($name); ?>"><svg viewBox="0 0 24 24" aria-hidden="true"><path d="M3 6h18M8 6V4a1 1 0 0 1 1-1h6a1 1 0 0 1 1 1v2m3 0v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6h13ZM10 11v6m4-6v6"/></svg></button>
    <button type="button" class="c-op c-wish" data-wish="<?php echo esc_attr($pid); ?>" aria-label="افزودن به علاقه‌مندی"><svg viewBox="0 0 24 24" aria-hidden="true"><path d="M12 21s-7.5-4.7-9.8-9C.7 9.2 2.3 5.5 5.8 4.7c2-.5 4 .3 5.2 1.9 1.2-1.6 3.2-2.4 5.2-1.9 3.5.8 5.1 4.5 3.6 7.3-2.3 4.3-9.8 9-9.8 9Z"/></svg></button>
  </span>
</article>
        <?php
    }
    return ob_get_clean();
}

/* ── رندر server-side کارت‌های پیشنهاد تکمیل خرید ── */
function alookhor_cc_cart_suggestions_html($recs, $wish_ids = array()) {
    ob_start();
    foreach ((array) $recs as $p) {
        $id = (int) (isset($p['id']) ? $p['id'] : 0);
        $name = isset($p['name']) ? (string) $p['name'] : '';
        $img = isset($p['image']) ? (string) $p['image'] : '';
        $price = (float) (isset($p['price']) ? $p['price'] : 0);
        $regular = (float) (isset($p['regular_price']) ? $p['regular_price'] : 0);
        $on_sale = !empty($p['on_sale']);
        $percent = (int) (isset($p['percent']) ? $p['percent'] : 0);
        $attrs_label = isset($p['variations_label']) && is_array($p['variations_label']) ? $p['variations_label'] : array();
        if ($attrs_label) {
            $attr_txt = implode(' · ', array_map(function($k,$v){
                return $k.': '.$v;
            }, array_keys($attrs_label), array_values($attrs_label)));
        } else {
            $attrs = isset($p['variations']) && is_array($p['variations']) ? $p['variations'] : array();
            $attr_txt = implode(' · ', array_map(function($k,$v){
                $lab = function_exists('wc_attribute_label') ? wc_attribute_label($k) : preg_replace('/^attribute_/','',(string)$k);
                return $lab.': '.$v;
            }, array_keys($attrs), array_values($attrs)));
        }
        ?>
<article class="sg-card">
  <span class="sg-img">
    <img src="<?php echo esc_url($img); ?>" alt="<?php echo esc_attr($name); ?>" loading="lazy" decoding="async">
    <?php if ($on_sale && $percent > 0): ?><span class="sg-badge sg-badge-sale">٪<?php echo esc_html(alookhor_cc_cart_fp($percent)); ?> تخفیف</span>
    <?php else: ?><span class="sg-badge sg-badge-special">پیشنهاد ویژه</span><?php endif; ?>
    <button type="button" class="c-op c-wish sg-wish" data-wish="<?php echo esc_attr($id); ?>" aria-label="افزودن به علاقه‌مندی"><svg viewBox="0 0 24 24" aria-hidden="true"><path d="M12 21s-7.5-4.7-9.8-9C.7 9.2 2.3 5.5 5.8 4.7c2-.5 4 .3 5.2 1.9 1.2-1.6 3.2-2.4 5.2-1.9 3.5.8 5.1 4.5 3.6 7.3-2.3 4.3-9.8 9-9.8 9Z"/></svg></button>
  </span>
  <strong class="sg-name"><?php echo esc_html($name); ?></strong>
  <?php if ($attr_txt): ?><span class="sg-attrs"><?php echo esc_html($attr_txt); ?></span><?php endif; ?>
  <span class="sg-price"><?php if ($on_sale && $regular > 0 && $regular > $price): ?><del><?php echo esc_html(alookhor_cc_cart_fa($regular)); ?></del><?php endif; ?><?php echo esc_html(alookhor_cc_cart_fa($price)); ?><small>تومان</small></span>
  <button type="button" class="sg-add" data-add-id="<?php echo esc_attr($id); ?>" <?php $vid = (int) (isset($p['variation_id']) ? $p['variation_id'] : 0); echo $vid ? 'data-add-variation="' . esc_attr($vid) . '"' : ''; ?>><svg viewBox="0 0 24 24" aria-hidden="true"><path d="M3 3h2l2.4 12.2A2 2 0 0 0 9.4 17H18a2 2 0 0 0 2-1.6L21.6 8H6"/><circle cx="10" cy="21" r="1.4"/><circle cx="18" cy="21" r="1.4"/></svg> افزودن</button>
</article>
        <?php
    }
    return ob_get_clean();
}

/* ── دادهٔ مشترک پیشنهادها (REST + SSR) ── */
function alookhor_cc_cart_recommendations($limit = 4) {
    if (!function_exists('wc_get_products')) return array();
    $products = wc_get_products(array(
        'status' => 'publish',
        'limit' => max(8, $limit * 2),
        'orderby' => 'popularity',
        'order' => 'DESC',
        'return' => 'objects',
    ));
    $out = array();
    foreach ($products as $product) {
        if (!is_object($product) && function_exists('wc_get_product')) $product = wc_get_product($product);
        if (!$product || !is_object($product)) continue;
        /* 3.10.413: محصول متغیر خودش قابل‌افزودن نیست — بهترین ورییشن قابل‌خرید را resolve می‌کنیم */
        $parent_id = (int) $product->get_id();
        $variation_id = 0; $variation_attrs = array();
        if (method_exists($product, 'is_type') && $product->is_type('variable')) {
            $children = method_exists($product, 'get_children') ? (array) $product->get_children() : array();
            foreach ($children as $vid) {
                $ch = function_exists('wc_get_product') ? wc_get_product($vid) : null;
                if ($ch && is_object($ch) && $ch->is_purchasable() && $ch->is_in_stock()) { $variation_id = (int) $vid; $product = $ch; break; }
            }
            if (!$variation_id) continue;
            if (method_exists($product, 'get_variation_attributes')) $variation_attrs = (array) $product->get_variation_attributes();
            $variation_labels = array();
            foreach ($variation_attrs as $ak => $av) {
                $human = alookhor_cc_variation_human_label($ak, $av, $product);
                $variation_labels[$human['name']] = $human['value'];
            }
        }
        if (method_exists($product, 'is_purchasable') && !$product->is_purchasable()) continue;
        if (method_exists($product, 'is_in_stock') && !$product->is_in_stock()) continue;
        $img = function_exists('wp_get_attachment_image_url') ? wp_get_attachment_image_url($product->get_image_id(), 'woocommerce_thumbnail') : '';
        if (!$img && function_exists('wc_placeholder_img_src')) $img = wc_placeholder_img_src();
        $regular = method_exists($product, 'get_regular_price') ? (float) $product->get_regular_price() : 0;
        $sale = method_exists($product, 'get_sale_price') ? (float) $product->get_sale_price() : 0;
        $on_sale = method_exists($product, 'is_on_sale') ? (bool) $product->is_on_sale() : ($sale > 0 && $regular > $sale);
        $percent = ($on_sale && $regular > 0) ? (int) round((($regular - $sale) / $regular) * 100) : 0;
        $out[] = array(
            'id' => $parent_id,
            'variation_id' => $variation_id,
            'variations' => $variation_attrs,
            'variations_label' => $variation_labels,
            'type' => method_exists($product, 'get_type') ? (string) $product->get_type() : 'simple',
            'name' => $product->get_name(),
            'price' => (float) (function_exists('wc_get_price_to_display') ? wc_get_price_to_display($product) : $product->get_price()),
            'regular_price' => $regular,
            'sale_price' => $sale,
            'percent' => $percent,
            'image' => $img,
            'on_sale' => $on_sale,
        );
        if (count($out) >= $limit) break;
    }
    return $out;
}

function alookhor_cc_cart_markup(){
    $checkout = function_exists('wc_get_checkout_url') ? wc_get_checkout_url() : home_url('/checkout/');
    $shop = function_exists('wc_get_shop_page_permalink') ? wc_get_shop_page_permalink() : home_url('/shop/');
    $home = home_url('/');
    $hero_img = ALOOKHOR_CC_URL . 'assets/images/category-plums.jpg';

    // Snapshot سرور-ساید از سبد (در صورت در دسترس بودن نشست ووکامرس)
    $initial = null;
    if (function_exists('alookhor_cc_cart_payload')) {
        $payload = alookhor_cc_cart_payload();
        if (is_array($payload) && isset($payload['items']) && isset($payload['totals'])) $initial = $payload;
    }
    $items  = $initial ? (array) $initial['items'] : array();
    $lines  = $initial ? (int) (isset($initial['lines']) ? $initial['lines'] : count($items)) : 0;
    $totals = $initial ? (array) $initial['totals'] : array('subtotal'=>0,'discount_total'=>0,'shipping_total'=>0,'total'=>0);
    $val = function ($k) use ($totals) { return isset($totals[$k]) ? (float) $totals[$k] : 0; };
    $recs = alookhor_cc_cart_recommendations(4);
    ob_start(); ?>

<section id="alookhor-cart" class="alookhor-cart-page" dir="rtl" aria-labelledby="alookhor-cart-title" data-ac-build="<?php echo esc_attr(ALOOKHOR_CC_BUILD); ?>">
  <div class="ac-hero" style="background-image:linear-gradient(270deg,rgba(22,8,38,.94) 18%,rgba(22,8,38,.72) 55%,rgba(22,8,38,.55)),url('<?php echo esc_url($hero_img); ?>')">
    <div class="ac-hero-top">
      <nav class="ac-crumb" aria-label="مسیر صفحه"><a href="<?php echo esc_url($home); ?>">خانه</a><svg viewBox="0 0 24 24" aria-hidden="true"><path d="m14 6-6 6 6 6"/></svg><span>سبد خرید</span></nav>
      <span class="ac-chip"><svg viewBox="0 0 24 24" aria-hidden="true"><path d="M20 4C12 4 6 8 6 15c0 3 2 5 5 5 7 0 9-8 9-16Z"/><path d="M4 21c3-6 7-9 13-13"/></svg> طعم اصالت از دل طبیعت ایران</span>
    </div>
    <h1 id="alookhor-cart-title"><svg class="ac-title-ico" viewBox="0 0 24 24" aria-hidden="true"><path d="M6 6h15l-1.5 9.5a2 2 0 0 1-2 1.5H9.7a2 2 0 0 1-2-1.6L6 3H3"/><circle cx="10" cy="21" r="1.4"/><circle cx="18" cy="21" r="1.4"/></svg> سبد خرید شما</h1>
    <p>محصولات منتخب شما در یک نگاه، با اطمینان خرید کنید.</p>
  </div>

  <div class="ac-wrap">
    <nav class="ac-steps" aria-label="مراحل خرید"><span class="ac-step is-active"><b>۱</b><span>سبد خرید</span></span><i aria-hidden="true"></i><span class="ac-step"><b>۲</b><span>ثبت سفارش</span></span><i aria-hidden="true"></i><span class="ac-step"><b>۳</b><span>پرداخت</span></span></nav>
    <div class="cart-error" role="alert" aria-live="assertive" hidden></div>

    <div class="ac-grid">
      <section class="ac-products" aria-labelledby="ac-products-title">
        <div class="ac-products-head">
          <strong id="ac-products-title">محصولات شما <span class="cart-items-count">(<?php echo $initial === null ? '…' : esc_html(alookhor_cc_cart_fp($lines) . ' کالا'); ?>)</span></strong>
          <span class="ac-head-ico"><svg viewBox="0 0 24 24" aria-hidden="true"><path d="M6 7h12l1 14H5L6 7Zm3 0a3 3 0 0 1 6 0"/></svg></span>
        </div>
        <div class="ac-thead" aria-hidden="true">
          <span>محصول</span><span>وزن / بسته‌بندی</span><span>قیمت واحد</span><span>تعداد</span><span>مبلغ کل</span><span>عملیات</span>
        </div>
        <div class="cart-items" aria-live="polite">
          <?php if ($initial === null): ?>
          <div class="cart-loading">در حال بارگذاری سبد خرید…</div>
          <?php elseif (!$items): ?>
          <div class="alookhor-cart-empty"><span class="ace-ico"><svg viewBox="0 0 24 24" aria-hidden="true"><path d="M6 6h15l-1.5 9.5a2 2 0 0 1-2 1.5H9.7a2 2 0 0 1-2-1.6L6 3H3"/><circle cx="10" cy="21" r="1.4"/><circle cx="18" cy="21" r="1.4"/></svg></span><strong>سبد خرید شما خالی است</strong><p>محصول موردنظر خود را از فروشگاه انتخاب کنید.</p><a href="<?php echo esc_url($shop); ?>">رفتن به فروشگاه</a></div>
          <?php else: echo alookhor_cc_cart_items_html($items); endif; ?>
        </div>
        <div class="ac-undo" hidden role="status" aria-live="polite"><span><strong>محصول حذف شد.</strong> می‌توانید آن را برگردانید.</span><button type="button" data-cart-undo>بازگردانی</button></div>
        <div class="ac-products-foot">
          <button type="button" class="ac-share" data-ac-share><svg viewBox="0 0 24 24" aria-hidden="true"><circle cx="6" cy="12" r="2.4"/><circle cx="18" cy="6" r="2.4"/><circle cx="18" cy="18" r="2.4"/><path d="m8.2 10.8 7.6-3.6m-7.6 6 7.6 3.6"/></svg> سبد خرید را به اشتراک بگذارید</button>
          <a class="ac-continue" href="<?php echo esc_url($shop); ?>"><svg viewBox="0 0 24 24" aria-hidden="true"><path d="M19 12H5m6-6-6 6 6 6"/></svg> ادامه خرید</a>
        </div>
      </section>

      <aside class="ac-summary" aria-label="خلاصه سفارش">
        <strong class="sum-title">خلاصه سفارش <svg viewBox="0 0 24 24" aria-hidden="true"><rect x="5" y="3" width="14" height="18" rx="2"/><path d="M9 8h6M9 12h6M9 16h4"/></svg></strong>
        <div class="sum-rows">
          <div class="sum-row sr-sub"><span>جمع مبلغ کالاها</span><span class="value"><?php echo esc_html(alookhor_cc_cart_fa($val('subtotal'))); ?> تومان</span></div>
          <div class="sum-row sr-disc"><span>تخفیف</span><span class="value"><?php $d=$val('discount_total'); echo $d ? esc_html('−' . alookhor_cc_cart_fa($d) . ' تومان') : '۰ تومان'; ?></span></div>
          <div class="sum-row sr-ship"><span><svg viewBox="0 0 24 24" aria-hidden="true"><path d="M5 12h9v6H5zM14 14h3.2L20 17v1h-6z"/><circle cx="8" cy="19" r="1.6"/><circle cx="17" cy="19" r="1.6"/></svg> هزینه ارسال</span><span class="value"><?php echo $val('shipping_total') ? esc_html(alookhor_cc_cart_fa($val('shipping_total')) . ' تومان') : 'رایگان'; ?></span></div>
        </div>
        <div class="sum-total sr-total"><span>مبلغ قابل پرداخت</span><b class="value"><?php echo esc_html(alookhor_cc_cart_fa($val('total'))); ?> تومان</b></div>
        <small class="sum-reassure">مبلغ نهایی پس از انتخاب روش ارسال و آدرس در تسویه‌حساب قطعی می‌شود.</small>
        <a class="ac-checkout" href="<?php echo esc_url($checkout); ?>">ادامه و ثبت سفارش <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M19 12H5m6-6-6 6 6 6"/></svg></a>

        <div class="ac-coupon">
          <label for="alookhor-cart-coupon"><svg viewBox="0 0 24 24" aria-hidden="true"><path d="m9 15 6-6M9.5 9.5h.01m5 5h.01M4 7a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v2.5a1.5 1.5 0 0 0 0 3V15a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2v-2.5a1.5 1.5 0 0 0 0-3V7Z"/></svg> کد تخفیف دارید؟</label>
          <div class="ac-coupon-row">
            <input id="alookhor-cart-coupon" type="text" autocomplete="off" inputmode="text" placeholder="کد تخفیف را وارد کنید …">
            <button type="button" disabled>اعمال</button>
          </div>
        </div>

        <div class="ac-shipnote">
          <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M5 12h9v6H5zM14 14h3.2L20 17v1h-6z"/><circle cx="8" cy="19" r="1.6"/><circle cx="17" cy="19" r="1.6"/></svg>
          <span><strong>ارسال به سراسر کشور</strong>تحویل سریع و مطمئن در کمترین زمان</span>
        </div>
      </aside>
    </div>

    <section class="ac-suggest" aria-labelledby="ac-suggest-title">
      <header class="ac-sec-head">
        <span class="ac-sec-ico"><svg viewBox="0 0 24 24" aria-hidden="true"><path d="M3 3h2l2.4 12.2A2 2 0 0 0 9.4 17H18a2 2 0 0 0 2-1.6L21.6 8H6"/><circle cx="10" cy="21" r="1.4"/><circle cx="18" cy="21" r="1.4"/></svg></span>
        <span><strong id="ac-suggest-title">پیشنهاد تکمیل خرید</strong><small>این محصولات را هم امتحان کنید</small></span>
      </header>
      <div class="suggested-grid" aria-live="polite"><?php echo $recs ? alookhor_cc_cart_suggestions_html($recs) : ''; ?></div>
    </section>

    <section class="ac-trust" aria-label="مزیت‌های خرید">
      <div class="tr-chip"><svg viewBox="0 0 24 24" aria-hidden="true"><path d="M4 13a8 8 0 0 1 16 0v3a2 2 0 0 1-2 2h-1v-5h3m-16 3h3v5H6a2 2 0 0 1-2-2v-3Z"/></svg><span><strong>پشتیبانی ۲۴ ساعته</strong><small>همیشه پاسخگوی شما هستیم</small></span></div>
      <div class="tr-chip"><svg viewBox="0 0 24 24" aria-hidden="true"><path d="M3 12a9 9 0 1 0 3-6.7M3 4v5h5"/></svg><span><strong>ضمانت بازگشت کالا</strong><small>تا ۷ روز، بدون قید و شرط</small></span></div>
      <div class="tr-chip"><svg viewBox="0 0 24 24" aria-hidden="true"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10Z"/><path d="m9 12 2 2 4-5"/></svg><span><strong>ضمانت اصالت کالا</strong><small>تضمین کیفیت و تازگی</small></span></div>
      <div class="tr-chip"><svg viewBox="0 0 24 24" aria-hidden="true"><path d="M5 12h9v6H5zM14 14h3.2L20 17v1h-6z"/><circle cx="8" cy="19" r="1.6"/><circle cx="17" cy="19" r="1.6"/></svg><span><strong>ارسال سریع</strong><small>به سراسر کشور</small></span></div>
    </section>

    <section class="ac-faq" aria-labelledby="ac-faq-title">
      <header class="ac-sec-head">
        <span class="ac-sec-ico"><svg viewBox="0 0 24 24" aria-hidden="true"><circle cx="12" cy="12" r="9"/><path d="M9.6 9.2a2.7 2.7 0 1 1 3.9 2.4c-.9.5-1.5 1-1.5 2v.3M12 17h.01"/></svg></span>
        <span><strong id="ac-faq-title">سوالات متداول</strong><small>پاسخ به پرتکرارترین سوالات شما</small></span>
      </header>
      <div class="faq-list">
        <div class="faq-item">
          <button type="button" class="faq-q">هزینه ارسال سفارش چقدر است؟<svg viewBox="0 0 24 24" aria-hidden="true"><path d="m6 9 6 6 6-6"/></svg></button>
          <div class="faq-a"><p>ارسال برای سفارش‌های بالای <b>۱٬۰۰۰٬۰۰۰ تومان</b> کاملاً رایگان است. برای سفارش‌های کمتر، هزینه ارسال بر اساس شهر مقصد و وزن بسته در مرحلهٔ تسویه‌حساب دقیق محاسبه و نمایش داده می‌شود.</p></div>
        </div>
        <div class="faq-item">
          <button type="button" class="faq-q">چقدر طول می‌کشد تا سفارشم به دستم برسد؟<svg viewBox="0 0 24 24" aria-hidden="true"><path d="m6 9 6 6 6-6"/></svg></button>
          <div class="faq-a"><p>سفارش‌ها حداکثر ۲۴ ساعت پس از ثبت پرداخت بسته‌بندی و تحویل پست/تیپاکس می‌شوند و معمولاً <b>۲ تا ۵ روز کاری</b> بعد به دست شما می‌رسند. کد رهگیری مرسوله بلافاصله برای‌تان پیامک می‌شود.</p></div>
        </div>
        <div class="faq-item">
          <button type="button" class="faq-q">آیا امکان بازگشت کالا وجود دارد؟<svg viewBox="0 0 24 24" aria-hidden="true"><path d="m6 9 6 6 6-6"/></svg></button>
          <div class="faq-a"><p>بله؛ تا <b>۷ روز</b> پس از تحویل، اگر از کیفیت یا تازگی محصول راضی نبودید، بدون هیچ قید و شرطی کالا مرجوع و وجه شما کامل بازگردانده می‌شود. کافی است با پشتیبانی تماس بگیرید.</p></div>
        </div>
      </div>
    </section>
    <div class="ac-mobile-checkout" aria-label="ثبت سفارش در موبایل"><div><small>قابل پرداخت</small><strong class="mobile-total"><?php echo esc_html(alookhor_cc_cart_fa($val('total'))); ?> تومان</strong></div><a class="mobile-checkout-btn" href="<?php echo esc_url($checkout); ?>" aria-label="ادامه و ثبت سفارش">ثبت سفارش <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M19 12H5m6-6-6 6"/></svg></a></div>
  </div>
</section>
<?php if ($initial !== null) echo '<script id="alookhor-cart-initial" type="application/json">' . wp_json_encode($initial, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) . '</script>'; ?>
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
