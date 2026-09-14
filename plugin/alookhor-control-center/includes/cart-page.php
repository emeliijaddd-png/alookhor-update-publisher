<?php
/** ALOOKHOR Custom Cart Page — single cart renderer. */
if (!defined('ABSPATH')) exit;
function alookhor_cc_cart_is_page(){ return function_exists('is_cart') && is_cart(); }
function alookhor_cc_register_cart_assets(){
    if(!alookhor_cc_cart_is_page()) return;
    wp_enqueue_style('alookhor-cc-cart',ALOOKHOR_CC_URL.'assets/css/frontend-cart.css',[],ALOOKHOR_CC_BUILD);
    wp_enqueue_script('alookhor-cc-cart',ALOOKHOR_CC_URL.'assets/js/frontend-cart.js',[],ALOOKHOR_CC_BUILD,true);
    wp_localize_script('alookhor-cc-cart','ALOOKHOR_CART_CONFIG',[
        'nonce'=>wp_create_nonce('wc_store_api'),
        'cartUrl'=>function_exists('wc_get_cart_url')?wc_get_cart_url():home_url('/cart/'),
        'shopUrl'=>function_exists('wc_get_shop_page_permalink')?wc_get_shop_page_permalink():home_url('/shop/'),
    ]);
    wp_add_inline_style('alookhor-cc-cart','
      body.woocommerce-cart .woocommerce-cart-form,body.woocommerce-cart .cart-collaterals,body.woocommerce-cart .woocommerce > .cart-empty,body.woocommerce-cart .return-to-shop,body.woocommerce-cart .cross-sells,body.woocommerce-cart .wd-cart,body.woocommerce-cart .wd-empty-cart,body.woocommerce-cart .wd-cross-sells,body.woocommerce-cart .elementor-widget-woocommerce-cart,body.woocommerce-cart .elementor-widget-wd_products,body.woocommerce-cart .wd-products-element{display:none!important}
      body.woocommerce-cart #alookhor-cart{display:block!important;visibility:visible!important;opacity:1!important;width:100%;position:relative;z-index:2}
      #alookhor-cart .cart-shell{width:min(1440px,100%);margin:0 auto;padding:10px 0 40px}
      #alookhor-cart .cart-heading{display:flex;align-items:center;justify-content:space-between;gap:24px;padding:22px 26px;margin:0 0 18px;border:1px solid rgba(212,154,46,.18);border-radius:22px;background:linear-gradient(135deg,rgba(28,16,36,.96),rgba(13,5,16,.92));box-shadow:0 18px 55px rgba(0,0,0,.28)}
      #alookhor-cart .eyebrow{display:block;color:#D49A2E;font:700 10px/1.4 Arial,sans-serif;letter-spacing:.16em;margin-bottom:7px}
      #alookhor-cart h1,#alookhor-cart h2{margin:0;color:#F5F3F0}#alookhor-cart h1{font-size:30px}#alookhor-cart h2{font-size:20px}
      #alookhor-cart .cart-subtitle{margin:7px 0 0;color:#C8C2C9;font-size:13px}
      #alookhor-cart .continue-shopping{display:inline-flex;align-items:center;justify-content:center;min-height:44px;padding:0 18px;border:1px solid rgba(212,154,46,.45);border-radius:12px;color:#E8B84A;text-decoration:none;white-space:nowrap}
      #alookhor-cart .cart-layout{display:grid;grid-template-columns:minmax(0,1fr) 360px;gap:20px;align-items:start}
      #alookhor-cart .cart-products,#alookhor-cart .summary-card,#alookhor-cart .cart-suggestions{border:1px solid rgba(255,255,255,.09);border-radius:20px;background:rgba(24,12,32,.78);box-shadow:0 18px 55px rgba(0,0,0,.22);overflow:hidden}
      #alookhor-cart .cart-list-head{display:flex;justify-content:space-between;align-items:center;padding:18px 22px;border-bottom:1px solid rgba(255,255,255,.08);color:#F5F3F0}
      #alookhor-cart .cart-items{min-height:100px}.alookhor-cart-empty{padding:48px 20px;text-align:center;color:#C8C2C9}.alookhor-cart-empty strong{display:block;color:#F5F3F0;font-size:18px}.alookhor-cart-empty p{margin:8px 0 18px}.alookhor-cart-empty a{color:#E8B84A;text-decoration:none}
      #alookhor-cart .cart-summary{position:sticky;top:20px}.alookhor-cart-active #alookhor-cart .summary-card{padding:22px}.alookhor-cart-active #alookhor-cart .summary-card h2{margin-bottom:18px}
      #alookhor-cart .summary-row,#alookhor-cart .summary-total{display:flex;justify-content:space-between;gap:12px;padding:10px 0;color:#C8C2C9}.alookhor-cart-active #alookhor-cart .summary-total{margin-top:8px;padding-top:16px;border-top:1px solid rgba(255,255,255,.09);color:#F5F3F0}.alookhor-cart-active #alookhor-cart .summary-total strong{color:#E8B84A;font-size:18px}
      #alookhor-cart .checkout-btn{display:flex;align-items:center;justify-content:center;min-height:48px;margin-top:16px;border-radius:13px;background:linear-gradient(135deg,#D49A2E,#E8B84A);color:#0D0510;text-decoration:none;font-weight:800}
      #alookhor-cart .coupon-box{margin-top:18px}.alookhor-cart-active #alookhor-cart .coupon-box label{display:block;color:#C8C2C9;font-size:12px;margin-bottom:7px}.alookhor-cart-active #alookhor-cart .coupon-box>div{display:flex;gap:7px}.alookhor-cart-active #alookhor-cart .coupon-box input{min-width:0;flex:1;background:#0D0510!important;border:1px solid rgba(255,255,255,.12)!important;color:#F5F3F0!important;border-radius:10px;padding:11px}.alookhor-cart-active #alookhor-cart .coupon-box button{border:1px solid #D49A2E;background:transparent;color:#E8B84A;border-radius:10px;padding:0 14px;cursor:pointer}
      #alookhor-cart .cart-error{margin:0 0 12px;padding:12px 16px;border-radius:12px;background:rgba(160,40,60,.16);color:#ffb7c4}.cart-loading{display:none;color:#C8C2C9;text-align:center;padding:15px}
      #alookhor-cart .cart-suggestions{margin-top:20px;padding:22px}.alookhor-cart-active #alookhor-cart .suggestions-heading{margin-bottom:15px}.alookhor-cart-active #alookhor-cart .suggested-grid{display:grid;grid-template-columns:repeat(4,minmax(0,1fr));gap:14px}.alookhor-cart-active #alookhor-cart .suggested-card{min-width:0;border:1px solid rgba(255,255,255,.08);border-radius:16px;overflow:hidden;background:rgba(13,5,16,.72)}.alookhor-cart-active #alookhor-cart .suggested-card .img-wrap{aspect-ratio:1/1;position:relative}.alookhor-cart-active #alookhor-cart .suggested-card img{width:100%;height:100%;object-fit:cover}.alookhor-cart-active #alookhor-cart .suggested-card .info{padding:12px}.alookhor-cart-active #alookhor-cart .suggested-card .name{display:block;color:#F5F3F0;white-space:nowrap;overflow:hidden;text-overflow:ellipsis}.alookhor-cart-active #alookhor-cart .suggested-card .price{display:block;color:#E8B84A;margin:6px 0}.alookhor-cart-active #alookhor-cart .add-btn{width:100%;min-height:38px;border:1px solid rgba(212,154,46,.5);border-radius:9px;background:transparent;color:#E8B84A;cursor:pointer}
      @media(max-width:900px){#alookhor-cart .cart-layout{grid-template-columns:1fr}#alookhor-cart .cart-summary{position:relative;top:auto}.alookhor-cart-active #alookhor-cart .suggested-grid{grid-template-columns:repeat(2,minmax(0,1fr))}}
      @media(max-width:600px){#alookhor-cart{padding:12px 10px 28px!important}#alookhor-cart .cart-heading{padding:18px 16px;display:block}#alookhor-cart h1{font-size:25px}#alookhor-cart .continue-shopping{width:100%;margin-top:14px}.alookhor-cart-active #alookhor-cart .suggested-grid{grid-template-columns:1fr 1fr}#alookhor-cart .cart-suggestions{padding:15px}.alookhor-cart-active #alookhor-cart .summary-card{padding:17px}}
    ');
}
add_action('wp_enqueue_scripts','alookhor_cc_register_cart_assets',1005);

function alookhor_cc_cart_markup(){ob_start(); ?>
<section id="alookhor-cart" class="alookhor-cart-page" dir="rtl" aria-labelledby="alookhor-cart-title"><div class="cart-shell">
<header class="cart-heading"><div><span class="eyebrow">ALOOKHOR • LUXURY SHOPPING</span><h1 id="alookhor-cart-title">سبد خرید</h1><p class="cart-subtitle">محصولات انتخاب‌شده شما در اینجا نمایش داده می‌شوند.</p></div><a class="continue-shopping" href="<?php echo esc_url(function_exists('wc_get_shop_page_permalink')?wc_get_shop_page_permalink():home_url('/shop/')); ?>">ادامه خرید</a></header>
<div class="cart-error" role="alert" style="display:none"></div><div class="cart-loading" aria-live="polite">در حال بارگذاری سبد خرید…</div>
<div class="cart-layout"><div class="cart-products"><div class="cart-list-head"><strong>لیست خرید شما</strong><span class="cart-items-count" aria-live="polite"></span></div><div class="cart-items" aria-live="polite"></div></div>
<aside class="cart-summary" aria-label="خلاصه سفارش"><div class="summary-card"><h2>خلاصه سفارش</h2><div class="summary-rows"><div class="summary-row"><span>جمع محصولات</span><span class="value">۰ تومان</span></div><div class="summary-row"><span>تخفیف</span><span class="value">۰ تومان</span></div><div class="summary-row"><span>ارسال</span><span class="value">رایگان</span></div></div><div class="summary-total"><span>مبلغ نهایی</span><strong class="value">۰ تومان</strong></div><a class="checkout-btn" href="<?php echo esc_url(function_exists('wc_get_checkout_url')?wc_get_checkout_url():home_url('/checkout/')); ?>">ادامه تا تسویه‌حساب</a><div class="coupon-box"><label for="alookhor-cart-coupon">کد تخفیف</label><div><input id="alookhor-cart-coupon" type="text" autocomplete="off" placeholder="کد تخفیف را وارد کنید"><button type="button">اعمال</button></div></div></div></aside></div>
<section class="cart-suggestions" aria-labelledby="alookhor-suggestions-title"><div class="suggestions-heading"><span class="eyebrow">CURATED FOR YOU</span><h2 id="alookhor-suggestions-title">پیشنهادهای آلوخور</h2></div><div class="suggested-grid"></div></section>
</div></section>
<?php return ob_get_clean();}
function alookhor_cc_replace_cart_content($content){if(!alookhor_cc_cart_is_page()||is_admin())return $content;return alookhor_cc_cart_markup();}
add_filter('the_content','alookhor_cc_replace_cart_content',9999);
function alookhor_cc_remove_legacy_cart_wrappers(){if(!alookhor_cc_cart_is_page())return;remove_action('woocommerce_before_cart','woocommerce_output_all_notices',10);}
add_action('wp','alookhor_cc_remove_legacy_cart_wrappers',100);
