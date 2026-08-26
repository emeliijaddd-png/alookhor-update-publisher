<?php
/** Reusable RTL storefront surface. Add [alookhor_storefront] to any page. */
if (!defined('ABSPATH')) exit;

function alookhor_cc_storefront_products(){
    $items = [
        ['slug'=>'aloo-bukhara','name'=>'آلو بخارا','desc'=>'طعم اصیل و بافت لطیف؛ مناسب مصرف روزانه و پذیرایی.','badge'=>'پرفروش'],
        ['slug'=>'aloo-haj-hassani','name'=>'آلو حاج حسنی','desc'=>'انتخابی ممتاز از محصولات خشکبار ایرانی.','badge'=>'ویژه'],
        ['slug'=>'aloo-kobraei','name'=>'آلو کبرایی','desc'=>'سورت‌شده و آماده برای سفارش خرده یا عمده.','badge'=>''],
        ['slug'=>'aloo-shoghan','name'=>'آلو شوغان','desc'=>'محصولی خوش‌طعم برای سبد خشکبار شما.','badge'=>'جدید'],
    ];
    if (function_exists('wc_get_products')) {
        $products = wc_get_products(['status'=>'publish','limit'=>4,'orderby'=>'date','order'=>'DESC']);
        if ($products) foreach ($products as $product) $items[] = ['slug'=>$product->get_slug(),'name'=>$product->get_name(),'desc'=>wp_strip_all_tags($product->get_short_description()),'badge'=>''];
    }
    return array_slice($items,0,4);
}
function alookhor_cc_storefront_shortcode($atts=[]){
    $atts=shortcode_atts(['view'=>'home'],$atts,'alookhor_storefront');
    $products=alookhor_cc_storefront_products(); $shop=function_exists('wc_get_page_permalink')?wc_get_page_permalink('shop'):home_url('/shop/');
    ob_start(); ?>
    <main class="alookhor-storefront" dir="rtl">
      <section class="alookhor-sf-hero"><div class="alookhor-sf-hero-copy"><span class="alookhor-eyebrow">پایتخت آلوی ایران</span><h1>طعم اصیل آلو،<br><em>از قلب ایران</em></h1><p>انتخابی از بهترین محصولات آلو و خشکبار، با نگاه حرفه‌ای به کیفیت، بسته‌بندی و همکاری صادراتی.</p><div class="alookhor-actions"><a class="alookhor-btn gold" href="<?php echo esc_url($shop); ?>">مشاهده محصولات</a><a class="alookhor-btn outline" href="<?php echo esc_url(home_url('/wholesale/')); ?>">خرید عمده</a></div></div><div class="alookhor-sf-hero-art" aria-label="محصولات آلوخور"><span>ALOOKHOR</span><strong>AL</strong></div></section>
      <section class="alookhor-intro"><span class="alookhor-eyebrow">انتخابی با دقت</span><h2>اصالت ایرانی، کیفیت قابل اعتماد</h2><p>آلوخور برای کسانی ساخته شده که میان طعم اصیل، انتخاب آگاهانه و تجربه‌ای شایسته از یک برند ایرانی تعادل می‌خواهند.</p></section>
      <section class="alookhor-products"><div class="alookhor-section-head"><div><span class="alookhor-eyebrow">انتخاب آلوخور</span><h2>محصولات منتخب</h2></div><a href="<?php echo esc_url($shop); ?>">مشاهده همه <span>←</span></a></div><div class="alookhor-product-grid"><?php foreach($products as $p): ?><article class="alookhor-product-card"><div class="alookhor-product-art"><span>AL</span><?php if($p['badge']): ?><b><?php echo esc_html($p['badge']); ?></b><?php endif; ?></div><div class="alookhor-product-copy"><h3><?php echo esc_html($p['name']); ?></h3><p><?php echo esc_html($p['desc']); ?></p><a href="<?php echo esc_url(function_exists('wc_get_page_permalink')?$shop.'?s='.rawurlencode($p['name']):home_url('/product/'.$p['slug'].'/')); ?>">مشاهده جزئیات <span>←</span></a></div></article><?php endforeach; ?></div></section>
      <section class="alookhor-trust"><div><span class="alookhor-eyebrow">برای همکاری</span><h2>از خرید روزانه تا بازارهای جهانی</h2><p>برای سفارش عمده، درخواست نمونه یا گفت‌وگوی صادراتی، مسیر همکاری خود را انتخاب کنید.</p></div><div class="alookhor-trust-links"><a href="<?php echo esc_url(home_url('/export/')); ?>"><b>همکاری صادراتی</b><span>شروع گفت‌وگو ←</span></a><a href="<?php echo esc_url(home_url('/wholesale/')); ?>"><b>فروش عمده</b><span>درخواست همکاری ←</span></a></div></section>
      <section class="alookhor-newsletter"><div><span class="alookhor-eyebrow">همراه آلوخور</span><h2>عضو خانواده آلوخور شوید</h2><p>برای خبرهای محصول و پیشنهادهای تازه ایمیل خود را ثبت کنید.</p></div><form><label class="screen-reader-text" for="alookhor-email">ایمیل شما</label><input id="alookhor-email" type="email" placeholder="ایمیل شما" required><button class="alookhor-btn gold" type="submit">عضویت</button></form></section>
    </main><?php return ob_get_clean();
}
add_shortcode('alookhor_storefront','alookhor_cc_storefront_shortcode');
