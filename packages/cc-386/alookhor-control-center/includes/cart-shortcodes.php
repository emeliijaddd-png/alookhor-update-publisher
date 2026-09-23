<?php
/**
 * ALOOKHOR Cart — independent Elementor shortcodes.
 * Each shortcode renders one cart section only.
 */
if (!defined('ABSPATH')) exit;

if (!function_exists('alookhor_cc_cart_shortcode_preview')) {
    function alookhor_cc_cart_shortcode_preview($title, $text = 'این بخش در ویرایشگر Elementor آماده است و در صفحه زنده به اطلاعات سبد خرید متصل می‌شود.') {
        return '<div class="alookhor-cart-shortcode-preview" dir="rtl" style="padding:20px;background:#1C1024;border:1px solid rgba(212,154,46,.28);border-radius:14px;color:#F5F3F0;text-align:right"><strong style="display:block;color:#E8B84A;margin-bottom:6px">'.esc_html($title).'</strong><span style="font-size:12px;color:#C8C2C9">'.esc_html($text).'</span></div>';
    }
}

if (!function_exists('alookhor_cc_cart_shortcode_data')) {
    function alookhor_cc_cart_shortcode_data() {
        if (function_exists('alookhor_cc_cart_data_robust')) {
            $data = alookhor_cc_cart_data_robust();
            if ($data) return $data;
        }
        if (function_exists('alookhor_cc_cart_data')) {
            $data = alookhor_cc_cart_data();
            if ($data) return $data;
        }
        return null;
    }
}

if (!function_exists('alookhor_cc_cart_shortcode_items')) {
    function alookhor_cc_cart_shortcode_items() {
        if (function_exists('alookhor_cc_cart_products_shortcode_final')) {
            $out = alookhor_cc_cart_products_shortcode_final();
            if ($out !== '') return $out;
        }
        $d = alookhor_cc_cart_shortcode_data();
        if (!$d) return alookhor_cc_cart_shortcode_preview('محصولات سبد خرید');
        return '<div class="alookhor-cart-items" dir="rtl"><p>سبد خرید شما خالی است.</p></div>';
    }
}

if (!function_exists('alookhor_cc_cart_shortcode_summary')) {
    function alookhor_cc_cart_shortcode_summary() {
        if (function_exists('alookhor_cc_cart_summary_shortcode_final')) {
            $out = alookhor_cc_cart_summary_shortcode_final();
            if ($out !== '') return $out;
        }
        $d = alookhor_cc_cart_shortcode_data();
        if (!$d) return alookhor_cc_cart_shortcode_preview('خلاصه سفارش');
        $fmt = $d['fmt'];
        return '<div class="cart-summary" dir="rtl"><div><div class="summary-title">خلاصه سفارش</div><div class="summary-row"><span>جمع سبد</span><strong>'.$fmt($d['subtotal']).' تومان</strong></div><div class="summary-row"><span>تخفیف</span><strong>'.$fmt($d['discount']).' تومان</strong></div><div class="summary-total"><span>مبلغ نهایی</span><strong>'.$fmt($d['total']).' تومان</strong></div></div></div>';
    }
}

if (!function_exists('alookhor_cc_cart_shortcode_coupon')) {
    function alookhor_cc_cart_shortcode_coupon() {
        return '<div class="alookhor-cart-coupon" dir="rtl" style="background:#1C1024;border:1px solid rgba(212,154,46,.2);border-radius:16px;padding:16px"><label style="display:block;color:#F5F3F0;font-weight:800;margin-bottom:9px">کد تخفیف</label><form class="woocommerce-cart-form" action="'.esc_url(wc_get_cart_url()).'" method="post" style="display:flex;gap:8px"><input type="text" name="coupon_code" placeholder="کد تخفیف را وارد کنید" style="flex:1;min-width:0;padding:11px;border-radius:9px;border:1px solid rgba(255,255,255,.12);background:rgba(255,255,255,.05);color:#fff"><button type="submit" name="apply_coupon" value="1" style="padding:11px 18px;border:0;border-radius:9px;background:#D49A2E;color:#0D0510;font-weight:800">اعمال</button></form></div>';
    }
}

if (!function_exists('alookhor_cc_cart_shortcode_shipping')) {
    function alookhor_cc_cart_shortcode_shipping() {
        $d = alookhor_cc_cart_shortcode_data();
        $text = $d ? 'هزینه و روش ارسال در مرحله تسویه بر اساس مقصد محاسبه می‌شود.' : 'انتخاب شهر و محاسبه ارسال در صفحه زنده فعال می‌شود.';
        return '<div class="alookhor-cart-shipping" dir="rtl" style="background:#1C1024;border:1px solid rgba(212,154,46,.2);border-radius:16px;padding:16px;color:#F5F3F0"><strong style="display:block;color:#E8B84A;margin-bottom:7px">ارسال و تحویل</strong><span style="font-size:12px;color:#C8C2C9">'.esc_html($text).'</span></div>';
    }
}

if (!function_exists('alookhor_cc_cart_shortcode_cross_sell')) {
    function alookhor_cc_cart_shortcode_cross_sell() {
        if (function_exists('alookhor_cc_cart_suggested_shortcode_final')) {
            $out = alookhor_cc_cart_suggested_shortcode_final();
            if ($out !== '') return $out;
        }
        return alookhor_cc_cart_shortcode_preview('پیشنهادهای تکمیل خرید');
    }
}

if (!function_exists('alookhor_cc_cart_shortcode_actions')) {
    function alookhor_cc_cart_shortcode_actions() {
        $shop = function_exists('wc_get_page_permalink') ? wc_get_page_permalink('shop') : home_url('/');
        $checkout = function_exists('wc_get_checkout_url') ? wc_get_checkout_url() : home_url('/checkout/');
        return '<div class="alookhor-cart-actions" dir="rtl" style="display:flex;gap:10px;flex-wrap:wrap"><a href="'.esc_url($shop).'" style="display:inline-flex;align-items:center;justify-content:center;padding:13px 18px;border:1px solid rgba(212,154,46,.35);border-radius:11px;color:#E8B84A;text-decoration:none;font-weight:800">ادامه خرید</a><a href="'.esc_url($checkout).'" style="display:inline-flex;align-items:center;justify-content:center;padding:13px 22px;border-radius:11px;background:linear-gradient(135deg,#D49A2E,#E8B84A);color:#0D0510;text-decoration:none;font-weight:900">ادامه و پرداخت</a></div>';
    }
}

add_action('init', function () {
    add_shortcode('alookhor_cart_items', 'alookhor_cc_cart_shortcode_items');
    add_shortcode('alookhor_cart_summary', 'alookhor_cc_cart_shortcode_summary');
    add_shortcode('alookhor_cart_coupon', 'alookhor_cc_cart_shortcode_coupon');
    add_shortcode('alookhor_cart_shipping', 'alookhor_cc_cart_shortcode_shipping');
    add_shortcode('alookhor_cart_cross_sell', 'alookhor_cc_cart_shortcode_cross_sell');
    add_shortcode('alookhor_cart_actions', 'alookhor_cc_cart_shortcode_actions');
}, 99);
