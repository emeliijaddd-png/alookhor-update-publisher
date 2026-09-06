<?php
/**
 * ALOOKHOR Luxury Buy Box — Single Product Price & Purchase Panel
 *
 * صفر تا صد قاب قیمت محصول تکی (مطابق مرجع تصویری مالک):
 *  1) کارت قیمت: لیبل راست + نشان تخفیف صورتی چپ + قیمت طلایی بزرگ + قیمت قدیمی خط‌خورده
 *  2) انتخاب وزن با Pills (همگام با متغیرهای واقعی WooCommerce؛ Selectهای بومی حفظ می‌شوند)
 *  3) استپر تعداد (minus / value / plus) متصل به input.qty بومی
 *  4) ردیف اکشن: دکمه طلایی افزودن به سبد (بومی WooCommerce) + علاقه‌مندی/مقایسه/اشتراک
 *  5) ردیف وضعیت: موجودی انبار (نقطه سبز) + متن ارسال
 *
 * Safety rules:
 *  - Native WooCommerce form (.cart / .variations_form) هرگز حذف نمی‌شود؛ فقط Selectها
 *    به‌صورت Visually Hidden نگه داشته می‌شوند تا اسکریپت رسمی wc-add-to-cart-variation
 *    بدون هیچ تغییری کار کند (سازگار با AJAX add-to-cart و قوانین موجودی).
 *  - رندر دوباره‌بار ندارد (guard)؛ در صورت نبود WooCommerce یا محصول Simple/Variable،
 *    خروجی بومی دست‌نخورده می‌ماند و هیچ Takeoverای انجام نمی‌شود.
 *
 * Shortcode: [alookhor_buybox]
 */

if (!defined('ABSPATH')) exit;

// —————————————————————————————————————————————
// Settings
// —————————————————————————————————————————————
function alookhor_cc_buybox_settings(){
    $defaults = [
        'enabled'         => true,  // Takeover خودکار ناحیه قیمت+خرید در خلاصه محصول
        'label_price'     => 'قیمت محصول :',
        'label_attribute' => 'انتخاب %s :', // %s = برچسب خاصیت (مثل «وزن»)
        'label_qty'       => 'تعداد :',
        'sale_badge'      => '%d٪ تخفیف',
        'in_stock'        => 'موجود در انبار',
        'on_backorder'    => 'موجود با پیش‌خرید',
        'out_of_stock'    => 'ناموجود',
        'shipping_note'   => 'ارسال از ۱ روز کاری آینده',
        'show_share'      => true,
        'show_compare'    => true,
        'show_wishlist'   => true,
    ];
    $saved = get_option('alookhor_cc_buybox_settings', []);
    if (!is_array($saved)) $saved = [];
    $merged = array_merge($defaults, $saved);
    return apply_filters('alookhor_cc_buybox_settings', $merged);
}

/** تبدیل ارقام لاتین به فارسی — روی رشته نهاییِHTML-safe اعمال می‌شود */
function alookhor_cc_buybox_fa_digits($text){
    return str_replace(
        ['0','1','2','3','4','5','6','7','8','9'],
        ['۰','۱','۲','۳','۴','۵','۶','۷','۸','۹'],
        (string) $text
    );
}

/** قالب قیمت لوکس: «۱۸۵٬۰۰۰ تومان» — مستقل از افزونه‌های فارسی‌ساز، بدون دورخیز رقم لاتین */
function alookhor_cc_buybox_price_html($amount, $size = 'now'){
    if ($amount === '' || $amount === null) return '';
    $decimals = function_exists('wc_get_price_decimals') ? wc_get_price_decimals() : 0;
    $number = number_format((float) $amount, $decimals, '.', '٬');
    $number = alookhor_cc_buybox_fa_digits($number);
    $symbol = get_woocommerce_currency_symbol();
    return '<span class="alk-bb-amount alk-bb-amount--' . esc_attr($size) . '">'
         . '<bdi class="alk-bb-amount__num">' . esc_html($number) . '</bdi>'
         . ' <span class="alk-bb-amount__cur">' . esc_html($symbol) . '</span>'
         . '</span>';
}

/** درصد تخفیف از روی قیمت regular/sale */
function alookhor_cc_buybox_discount_percent($regular, $sale){
    $regular = (float) $regular; $sale = (float) $sale;
    if ($regular <= 0 || $sale <= 0 || $sale >= $regular) return 0;
    return (int) round((($regular - $sale) / $regular) * 100);
}

/** متن نشان تخفیف با ارقام فارسی — %d نباید رشته فارسی بگیرد (جلوگیری از cast به صفر) */
function alookhor_cc_buybox_badge_text($template, $percent){
    $template = str_replace(['%d','%1$d','%1$s'], '%s', (string) $template);
    return sprintf($template, alookhor_cc_buybox_fa_digits($percent));
}

/** وضعیت موجودی محصول/متغیر → [متن، کلاس] */
function alookhor_cc_buybox_stock_state($product, $settings){
    if (!$product) return [$settings['out_of_stock'], 'out'];
    if ($product->is_on_backorder()) return [$settings['on_backorder'], 'backorder'];
    if ($product->is_in_stock())    return [$settings['in_stock'], 'in'];
    return [$settings['out_of_stock'], 'out'];
}

// —————————————————————————————————————————————
// Takeover bootstrap — فقط در صفحه تکی محصول و فقط برای Simple/Variable
// —————————————————————————————————————————————
add_action('template_redirect', function(){
    if (!function_exists('is_product') || !is_product()) return;

    $product = wc_get_product(get_the_ID());
    if (!$product || !$product->is_type(['simple', 'variable'])) return;

    $settings = alookhor_cc_buybox_settings();
    if (empty($settings['enabled'])) return; // غیرفعال = صفر تماس با DOM/هوک‌های صفحه محصول

    // خروجی بومی «قیمت» و «افزودن به سبد» از خلاصه برداشته می‌شود و قاب لوکس جایگزین می‌گردد.
    remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_price', 10);
    remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_add_to_cart', 30);
    add_action('woocommerce_single_product_summary', 'alookhor_cc_buybox_hook_output', 10);

    // استپر تعداد + آیکون‌های اکشن، داخل خودِ فرم بومی WooCommerce تزریق می‌شوند.
    add_action('woocommerce_before_add_to_cart_quantity', 'alookhor_cc_buybox_before_qty');
    add_action('woocommerce_after_add_to_cart_quantity', 'alookhor_cc_buybox_after_qty');
    add_action('woocommerce_after_add_to_cart_button', 'alookhor_cc_buybox_after_button');
});

function alookhor_cc_buybox_hook_output(){
    alookhor_cc_buybox_render();
}

add_shortcode('alookhor_buybox', function(){
    // جلوگیری از رندر دوبل اگر هم هوک و هم شورت‌کد در یک صفحه باشند
    if (!empty($GLOBALS['alookhor_cc_buybox_rendered'])) return '';
    return alookhor_cc_buybox_render(true);
});

// —————————————————————————————————————————————
// Main renderer
// —————————————————————————————————————————————
function alookhor_cc_buybox_render($return = false){
    if (!empty($GLOBALS['alookhor_cc_buybox_rendered'])) return $return ? '' : null;
    if (!function_exists('wc_get_product')) return $return ? '' : null;

    $product = wc_get_product(get_the_ID());
    if (!$product || !$product->is_type(['simple', 'variable'])) return $return ? '' : null;

    $GLOBALS['alookhor_cc_buybox_rendered'] = true;
    $settings = alookhor_cc_buybox_settings();

    // ——— داده‌های اولیه قیمت/موجودی (برای محصول متغیر: متغیر پیش‌فرض اگر انتخاب شده باشد) ———
    $variation  = null;
    $is_variable = $product->is_type('variable');
    if ($is_variable){
        $defaults = $product->get_default_attributes();
        if (!empty($defaults)){
            $found = (new \WC_Product_Data_Store_CPT())->find_matching_product_variation($product, $defaults);
            if ($found) $variation = wc_get_product($found);
        }
    }
    $src = $variation ?: $product; // منبع قیمت و موجودی برای رندر اولیه

    $regular     = (float) $src->get_regular_price();
    $current     = (float) $src->get_price();
    $has_range   = $is_variable && !$variation;
    $percent     = $has_range ? 0 : alookhor_cc_buybox_discount_percent($regular, $current);
    [$stock_text, $stock_class] = alookhor_cc_buybox_stock_state($src, $settings);

    ob_start();
    ?>
    <div class="alk-bb" id="alk-bb" data-product-id="<?php echo (int) $product->get_id(); ?>" data-alk-state="<?php echo $has_range ? 'pending' : 'ready'; ?>">

        <!-- ۱) کارت قیمت -->
        <div class="alk-bb-price-card">
            <div class="alk-bb-price-head">
                <span class="alk-bb-label"><?php echo esc_html($settings['label_price']); ?></span>
                <span class="alk-bb-sale-badge" <?php echo $percent ? '' : 'hidden'; ?>><?php echo esc_html(alookhor_cc_buybox_badge_text($settings['sale_badge'], $percent)); ?></span>
            </div>
            <div class="alk-bb-price-body">
                <div class="alk-bb-price-stack">
                    <div class="alk-bb-price-now">
                        <?php
                        if ($has_range){
                            // تا انتخاب وزن: بازه قیمت بومی — با انتخاب معتبر توسط JS به قیمت دقیق تبدیل می‌شود
                            echo '<span class="alk-bb-price-range">' . wp_kses_post($product->get_price_html()) . '</span>';
                        } else {
                            echo alookhor_cc_buybox_price_html($current, 'now'); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
                        }
                        ?>
                    </div>
                    <div class="alk-bb-price-old" <?php echo (!$has_range && $percent) ? '' : 'hidden'; ?>>
                        <del><?php echo alookhor_cc_buybox_price_html($regular, 'old'); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></del>
                    </div>
                </div>
            </div>
        </div>

        <?php
        // ——— ۲) Pills انتخاب وزن (متغیر) ———
        if ($is_variable){
            $variation_attributes = $product->get_variation_attributes();
            foreach ($variation_attributes as $attribute_name => $options){
                $attr_label = wc_attribute_label($attribute_name, $product);
                $selected   = $product->get_variation_default_attribute($attribute_name);
                $input_name = 'attribute_' . sanitize_title($attribute_name);
                if (isset($_REQUEST['attribute_' . sanitize_title($attribute_name)])){
                    $selected = wc_clean( wp_unslash( $_REQUEST['attribute_' . sanitize_title($attribute_name)] ) );
                }
                echo '<div class="alk-bb-attr" data-attribute-name="' . esc_attr($input_name) . '">';
                echo '<span class="alk-bb-label">' . esc_html(sprintf($settings['label_attribute'], $attr_label)) . '</span>';
                echo '<div class="alk-bb-pills" role="group" aria-label="' . esc_attr($attr_label) . '">';
                foreach ($options as $option){
                    $term_name = $option;
                    if (taxonomy_exists($attribute_name)){
                        $term = get_term_by('slug', $option, $attribute_name);
                        if ($term && !is_wp_error($term)) $term_name = $term->name;
                    }
                    $is_on = ($selected !== '' && $selected === $option);
                    printf(
                        '<button type="button" class="alk-bb-pill%1$s" data-attribute="%2$s" data-value="%3$s" aria-pressed="%4$s">%5$s</button>',
                        $is_on ? ' is-active' : '',
                        esc_attr($input_name),
                        esc_attr($option),
                        $is_on ? 'true' : 'false',
                        esc_html(alookhor_cc_buybox_fa_digits($term_name))
                    );
                }
                echo '</div></div>';
            }
        }
        ?>

        <!-- ۳و۴) فرم بومی خرید WooCommerce: Selectها پنهان، استپر/دکمه/آیکون‌ها استایل می‌شوند -->
        <div class="alk-bb-form" data-label-qty="<?php echo esc_attr($settings['label_qty']); ?>">
            <?php
            ob_start();
            woocommerce_template_single_add_to_cart();
            echo ob_get_clean(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
            ?>
        </div>

        <!-- ۵) ردیف وضعیت: مطابق مرجع — ارسال راست، موجودی چپ با نقطه سبز در انتهای متن -->
        <div class="alk-bb-status">
            <?php if (!empty($settings['shipping_note'])): ?>
                <span class="alk-bb-ship"><?php echo esc_html($settings['shipping_note']); ?></span>
            <?php endif; ?>
            <span class="alk-bb-stock alk-bb-stock--<?php echo esc_attr($stock_class); ?>">
                <span class="alk-bb-stock__text"><?php echo esc_html($stock_text); ?></span>
                <i class="alk-bb-stock__dot" aria-hidden="true"></i>
            </span>
        </div>
    </div>
    <?php
    $html = ob_get_clean();
    if ($return) return $html;
    echo $html; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
    return null;
}

// —————————————————————————————————————————————
// Injected pieces داخل فرم بومی (هوک‌های رسمی WooCommerce)
// —————————————————————————————————————————————
// یک‌بار رندر در هر صفحه — جلوگیری از تکثیر در فرم‌های دوم (مثل Sticky Add-to-Cart وودمارت)
function alookhor_cc_buybox_before_qty(){
    static $done = false; if ($done) return; $done = true;
    $settings = alookhor_cc_buybox_settings();
    echo '<span class="alk-bb-qty-label alk-bb-label">' . esc_html($settings['label_qty']) . '</span>';
    echo '<button type="button" class="alk-bb-qbtn alk-bb-qbtn--minus" aria-label="' . esc_attr__('کاهش تعداد', 'alookhor-cc') . '">−</button>';
}

function alookhor_cc_buybox_after_qty(){
    static $done = false; if ($done) return; $done = true;
    echo '<button type="button" class="alk-bb-qbtn alk-bb-qbtn--plus" aria-label="' . esc_attr__('افزایش تعداد', 'alookhor-cc') . '">+</button>';
}

function alookhor_cc_buybox_after_button(){
    static $done = false; if ($done) return; $done = true;
    $settings  = alookhor_cc_buybox_settings();
    $product_id = get_the_ID();
    $svg = function($path){
        return '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">' . $path . '</svg>';
    };
    echo '<span class="alk-bb-actions">';

    if (!empty($settings['show_wishlist'])){
        printf(
            '<button type="button" class="alk-bb-iconbtn alk-bb-iconbtn--wishlist" data-product-id="%1$d" aria-label="%2$s" aria-pressed="false">%3$s</button>',
            (int) $product_id,
            esc_attr__('افزودن به علاقه‌مندی‌ها', 'alookhor-cc'),
            $svg('<path d="M19 14c1.49-1.46 3-3.21 3-5.5A5.5 5.5 0 0 0 16.5 3c-1.76 0-3 .5-4.5 2-1.5-1.5-2.74-2-4.5-2A5.5 5.5 0 0 0 2 8.5c0 2.3 1.5 4.05 3 5.5l7 7Z"/>') // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
        );
    }
    if (!empty($settings['show_compare'])){
        printf(
            '<button type="button" class="alk-bb-iconbtn alk-bb-iconbtn--compare" data-product-id="%1$d" aria-label="%2$s" aria-pressed="false">%3$s</button>',
            (int) $product_id,
            esc_attr__('افزودن به مقایسه', 'alookhor-cc'),
            $svg('<path d="M8 3 4 7l4 4"/><path d="M4 7h16"/><path d="m16 21 4-4-4-4"/><path d="M20 17H4"/>') // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
        );
    }
    if (!empty($settings['show_share'])){
        printf(
            '<button type="button" class="alk-bb-iconbtn alk-bb-iconbtn--share" aria-label="%1$s">%2$s</button>',
            esc_attr__('اشتراک‌گذاری محصول', 'alookhor-cc'),
            $svg('<circle cx="18" cy="5" r="3"/><circle cx="6" cy="12" r="3"/><circle cx="18" cy="19" r="3"/><line x1="8.59" y1="13.51" x2="15.42" y2="17.49"/><line x1="15.41" y1="6.51" x2="8.59" y2="10.49"/>') // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
        );
    }
    echo '</span>';
}

// —————————————————————————————————————————————
// Assets — فقط صفحه تکی محصول
// —————————————————————————————————————————————
add_action('wp_enqueue_scripts', function(){
    if (!function_exists('is_product') || !is_product()) return;

    wp_enqueue_style('alookhor-cc-buybox', ALOOKHOR_CC_URL . 'assets/css/frontend-buybox.css', [], ALOOKHOR_CC_BUILD);
    wp_enqueue_script('alookhor-cc-buybox', ALOOKHOR_CC_URL . 'assets/js/frontend-buybox.js', ['jquery'], ALOOKHOR_CC_BUILD, true);

    wp_localize_script('alookhor-cc-buybox', 'ALOOKHOR_BUYBOX', [
        'currency'     => get_woocommerce_currency_symbol(),
        'decimals'     => function_exists('wc_get_price_decimals') ? wc_get_price_decimals() : 0,
        'thousand_sep' => '٬',
        'sale_badge'   => alookhor_cc_buybox_settings()['sale_badge'] ?? '%d٪ تخفیف',
        'i18n'         => [
            'in_stock'      => alookhor_cc_buybox_settings()['in_stock'],
            'on_backorder'  => alookhor_cc_buybox_settings()['on_backorder'],
            'out_of_stock'  => alookhor_cc_buybox_settings()['out_of_stock'],
            'wishlist_on'   => __('به علاقه‌مندی‌ها اضافه شد', 'alookhor-cc'),
            'wishlist_off'  => __('از علاقه‌مندی‌ها حذف شد', 'alookhor-cc'),
            'compare_on'    => __('به مقایسه اضافه شد', 'alookhor-cc'),
            'compare_off'   => __('از مقایسه حذف شد', 'alookhor-cc'),
            'link_copied'   => __('لینک محصول کپی شد', 'alookhor-cc'),
            'select_attr'   => __('لطفاً ابتدا گزینه را انتخاب کنید', 'alookhor-cc'),
        ],
    ]);
}, 25);
