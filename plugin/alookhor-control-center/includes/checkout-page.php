<?php
/** ALOOKHOR CHECKOUT — v3.10.371 luxury checkout exact per image */
if(!defined('ABSPATH')) exit;

if(!function_exists('alookhor_cc_checkout_icon')){
function alookhor_cc_checkout_icon($name){
 $icons=[
  'cart'=>'<path d="M6 6h15l-1.5 9h-13z"/><path d="M6 6L5 2H2"/><circle cx="9" cy="20" r="1.5"/><circle cx="18" cy="20" r="1.5"/>',
  'check'=>'<path d="M5 12l5 5l10-10"/>',
  'card'=>'<rect x="2" y="5" width="20" height="14" rx="2"/><path d="M2 10h20"/>',
  'user'=>'<path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/>',
  'truck'=>'<path d="M1 3h15v13H1z"/><path d="M16 8h4l3 6v3h-7V8z"/><circle cx="5.5" cy="18.5" r="2.5"/><circle cx="18.5" cy="18.5" r="2.5"/>',
  'box'=>'<path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"/><polyline points="3.27 6.96 12 12.01 20.73 6.96"/><line x1="12" y1="22.08" x2="12" y2="12"/>',
  'credit'=>'<rect x="1" y="4" width="22" height="16" rx="2"/><line x1="1" y1="10" x2="23" y2="10"/>',
  'money'=>'<rect x="2" y="6" width="20" height="12" rx="2"/><circle cx="12" cy="12" r="2"/><path d="M6 12h.01M18 12h.01"/>',
  'lock'=>'<rect x="3" y="11" width="18" height="11" rx="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/>',
  'shield'=>'<path d="M12 2L3 6v6c0 5 4 9 9 10 5-1 9-5 9-10V6l-9-4Z"/><path d="M9 12l2 2 4-4"/>',
  'return'=>'<path d="M3 7v6h6"/><path d="M21 17a9 9 0 0 0-9-9 9 9 0 0 0-6 2.3L3 13"/>',
  'headset'=>'<path d="M3 18v-6a9 9 0 0 1 18 0v6"/><path d="M21 19a2 2 0 0 1-2 2h-1a2 2 0 0 1-2-2v-3a2 2 0 0 1 2-2h3z"/><path d="M3 19a2 2 0 0 0 2 2h1a2 2 0 0 0 2-2v-3a2 2 0 0 0-2-2H3z"/>',
  'arrowl'=>'<path d="M19 12H5"/><path d="M12 19l-7-7 7-7"/>',
  'leaf'=>'<path d="M12 2C7 2 3 6 3 11c0 5 4 9 9 9s9-4 9-9c0-5-4-9-9-9Z"/><path d="M12 2c0 0-3 3-3 7s3 7 3 7"/>',
 ];
 $d=$icons[$name]??'<circle cx="12" cy="12" r="8"/>';
 return '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round">'.$d.'</svg>';
}
}

if(!function_exists('alookhor_cc_checkout_data')){
function alookhor_cc_checkout_data(){
 if(!function_exists('WC')||!WC()||!WC()->cart) return null;
 $cart=WC()->cart;
 $items=[];
 foreach($cart->get_cart() as $key=>$ci){
  $prod=$ci['data']; if(!$prod) continue;
  $pid=$ci['product_id'];
  $name=$prod->get_name();
  $img=wp_get_attachment_image_url($prod->get_image_id(),'woocommerce_thumbnail');
  $img=$img?:ALOOKHOR_CC_URL.'assets/images/bowl.jpg';
  $qty=(int)$ci['quantity'];
  $price=(float)$prod->get_price();
  $regular=(float)$prod->get_regular_price()?:$price;
  $subtotal=$price*$qty;
  $weight_label='';
  if(!empty($ci['variation'])){
   foreach($ci['variation'] as $k=>$v){
    if(strpos($k,'vazn')!==false||strpos($k,'weight')!==false){
     $term=get_term_by('slug',$v,'pa_vazn');
     $weight_label=$term&&!is_wp_error($term)?$term->name:$v;
     break;
    }
   }
   if(!$weight_label) $weight_label=implode(' / ',array_values($ci['variation']));
  }
  if(!$weight_label) $weight_label=$prod->get_weight()?wc_format_weight($prod->get_weight()):'بسته استاندارد';
  $items[]=[
   'key'=>$key,'id'=>$pid,'name'=>$name,'img'=>$img,'qty'=>$qty,
   'price'=>$price,'regular'=>$regular,'subtotal'=>$subtotal,'weight'=>$weight_label,
   'permalink'=>get_permalink($pid),
  ];
 }
 $cur=get_woocommerce_currency();
 $toman_rate=$cur==='IRR'?10:($cur==='IRT'?1:0);
 $fa_th=function($n){return strtr(number_format((float)$n,0,'.','٬'),['0'=>'۰','1'=>'۱','2'=>'۲','3'=>'۳','4'=>'۴','5'=>'۵','6'=>'۶','7'=>'۷','8'=>'۸','9'=>'۹']);};
 $fmt=function($a) use($fa_th,$toman_rate){
  $a=(float)$a; if($a<=0) return '۰';
  if($toman_rate>0) return $fa_th((int)round($a/$toman_rate));
  return $fa_th($a);
 };
 $subtotal=(float)$cart->get_subtotal();
 $discount=(float)$cart->get_discount_total();
 $total=(float)$cart->get_total('edit');
 $shipping_total=(float)$cart->get_shipping_total();
 if($subtotal<=0){ foreach($items as $it) $subtotal+=$it['subtotal']; }
 if($total<=0) $total=$subtotal-$discount+$shipping_total;
 return [
  'items'=>$items,
  'count'=>count($items),
  'subtotal'=>$subtotal,'discount'=>$discount,'shipping'=>$shipping_total,'total'=>$total,
  'fmt'=>$fmt,'fa_th'=>$fa_th,
  'shop'=>wc_get_page_permalink('shop'),
  'checkout'=>wc_get_checkout_url(),
  'cart_url'=>wc_get_cart_url(),
 ];
}
}

if(!function_exists('alookhor_cc_checkout_markup')){
function alookhor_cc_checkout_markup(){
 $GLOBALS['alookhor_cc_checkout_rendered']=true;
 $d=alookhor_cc_checkout_data();
 if(!$d){
   // dummy for preview
   $fmt=function($a){return number_format($a,0,'.',',');};
   $fa_th=function($n){return (string)$n;};
   $d=[
     'items'=>[
       ['key'=>'1','id'=>1,'name'=>'الو بخارا','img'=>ALOOKHOR_CC_URL.'assets/images/bowl.jpg','qty'=>1,'price'=>1850000,'regular'=>2000000,'subtotal'=>1850000,'weight'=>'۱ کیلوگرم','permalink'=>home_url('/')],
       ['key'=>'2','id'=>2,'name'=>'الو بخارا ممتاز','img'=>ALOOKHOR_CC_URL.'assets/images/bowl.jpg','qty'=>1,'price'=>950000,'regular'=>1000000,'subtotal'=>950000,'weight'=>'۵۰۰ گرم','permalink'=>home_url('/')],
     ],
     'count'=>2,'subtotal'=>2800000,'discount'=>300000,'shipping'=>0,'total'=>2500000,'fmt'=>$fmt,'fa_th'=>$fa_th,
     'shop'=>home_url('/shop/'),'checkout'=>wc_get_checkout_url(),'cart_url'=>wc_get_cart_url(),
   ];
 }
 $fmt=$d['fmt']; $fa_th=$d['fa_th'];
 ob_start();
 $__css=@file_get_contents(ALOOKHOR_CC_DIR.'assets/css/frontend-checkout.css');
 if($__css) echo '<style id="alookhor-checkout-inline">'.$__css.'</style>';
?>
<div id="alookhor-checkout" dir="rtl">
  <!-- Steps -->
  <div class="checkout-steps">
    <div class="step done">
      <span class="icon"><span><?php echo alookhor_cc_checkout_icon('cart');?></span></span>
      <div>
        <div style="font-size:13px;font-weight:800;color:#F5F3F0">تکمیل خرید</div>
        <div style="font-size:11px;color:#8a7a94">ثبت موفق سفارش</div>
      </div>
    </div>
    <div class="line filled"></div>
    <div class="step active">
      <span class="icon"><span><?php echo alookhor_cc_checkout_icon('card');?></span></span>
      <div>
        <div style="font-size:13px;font-weight:800;color:#F5F3F0">تسویه حساب</div>
        <div style="font-size:11px;color:#C8C2C9">اطلاعات و پرداخت</div>
      </div>
    </div>
    <div class="line"></div>
    <div class="step">
      <span class="icon"><span><?php echo alookhor_cc_checkout_icon('cart');?></span></span>
      <div>
        <div style="font-size:13px;font-weight:700">سبد خرید</div>
        <div style="font-size:11px">بررسی محصولات</div>
      </div>
    </div>
  </div>

  <div class="checkout-main-grid">
    <!-- LEFT: Summary (in RTL visual left, but DOM first for mobile) -->
    <div class="checkout-summary">
      <div class="summary-title"><span class="icon"><span><?php echo alookhor_cc_checkout_icon('card');?></span></span> خلاصه سفارش</div>
      <div class="summary-products">
        <?php foreach($d['items'] as $it):?>
        <div class="summary-product">
          <img src="<?php echo esc_url($it['img']);?>" alt="">
          <div class="info">
            <span class="badge">پرفروش</span>
            <span class="name"><?php echo esc_html($it['name']);?></span>
            <span class="weight">وزن: <?php echo esc_html($it['weight']);?> <span class="qty">× <?php echo $fa_th($it['qty']);?></span></span>
            <span class="price"><?php echo $fmt($it['price']);?> تومان</span>
          </div>
        </div>
        <?php endforeach;?>
        <?php if(empty($d['items'])):?>
        <div style="padding:20px;text-align:center;color:#8a7a94;font-size:12px">سبد خالی است</div>
        <?php endif;?>
      </div>
      <div class="summary-rows">
        <div class="summary-row"><span class="label">جمع مبلغ کالاها</span><span class="value"><?php echo $fmt($d['subtotal']);?> تومان</span></div>
        <div class="summary-row"><span class="label">تخفیف</span><span class="value mint">- <?php echo $fmt($d['discount']);?> تومان</span></div>
        <div class="summary-row"><span class="label">هزینه ارسال</span><span class="value mint">رایگان</span></div>
        <div class="summary-total"><span class="label">مبلغ قابل پرداخت</span><span class="value"><?php echo $fmt($d['total']);?> تومان</span></div>
        <button class="btn-checkout"><span><?php echo alookhor_cc_checkout_icon('card');?></span> پرداخت و ثبت سفارش</button>

        <div class="coupon-box">
          <div class="title"><span>🎁</span> کد تخفیف دارید؟</div>
          <div class="row"><input type="text" placeholder="کد تخفیف را وارد کنید..."><button>اعمال</button></div>
        </div>

        <div class="shipping-info">
          <span class="icon"><span><?php echo alookhor_cc_checkout_icon('truck');?></span></span>
          <div>
            <div style="font-size:12px;font-weight:700;color:#F5F3F0">ارسال به سراسر کشور</div>
            <div style="font-size:11px;color:#8a7a94">تحویل سریع و مطمئن در کمترین زمان</div>
          </div>
        </div>
      </div>
    </div>

    <!-- RIGHT: Form -->
    <div class="checkout-form">
      <form name="checkout" method="post" class="checkout woocommerce-checkout" action="<?php echo esc_url(wc_get_checkout_url());?>" enctype="multipart/form-data">
        <div class="form-section">
          <h3 class="section-title">اطلاعات مشتری <span class="icon"><span><?php echo alookhor_cc_checkout_icon('user');?></span></span></h3>
          <div class="form-row">
            <label>نام و نام خانوادگی *</label>
            <input type="text" name="billing_first_name" placeholder="نام و نام خانوادگی" value="<?php echo esc_attr(WC()->customer?WC()->customer->get_first_name():'');?>" required>
          </div>
          <div class="form-row">
            <label>شماره موبایل *</label>
            <input type="tel" name="billing_phone" placeholder="شماره موبایل" value="<?php echo esc_attr(WC()->customer?WC()->customer->get_billing_phone():'');?>" required>
          </div>
          <div class="form-row">
            <label>آدرس کامل پستی *</label>
            <textarea name="billing_address_1" placeholder="استان، شهر، خیابان، پلاک، واحد و ..." required><?php echo esc_textarea(WC()->customer?WC()->customer->get_billing_address_1():'');?></textarea>
          </div>
          <?php wp_nonce_field('woocommerce-process_checkout','woocommerce-process-checkout-nonce'); ?>
        </div>

        <div class="form-section">
          <h3 class="section-title">روش ارسال <span class="icon"><span><?php echo alookhor_cc_checkout_icon('truck');?></span></span></h3>
          <div class="method-list">
            <label class="method-item selected">
              <div class="left">
                <span class="radio"></span>
                <div class="info">
                  <span class="name">پست پیشتاز</span>
                  <span class="desc">۲ تا ۴ روز کاری</span>
                </div>
              </div>
              <div style="display:flex;align-items:center;gap:10px">
                <span class="price">رایگان</span>
                <span class="icon"><span><?php echo alookhor_cc_checkout_icon('truck');?></span></span>
              </div>
              <input type="radio" name="shipping_method" value="free_shipping" checked style="display:none">
            </label>
            <label class="method-item">
              <div class="left">
                <span class="radio"></span>
                <div class="info">
                  <span class="name">تیپاکس</span>
                  <span class="desc">۱ تا ۲ روز کاری</span>
                </div>
              </div>
              <div style="display:flex;align-items:center;gap:10px">
                <span class="price muted">۳۰,۰۰۰ تومان</span>
                <span class="icon"><span><?php echo alookhor_cc_checkout_icon('box');?></span></span>
              </div>
              <input type="radio" name="shipping_method" value="flat_rate" style="display:none">
            </label>
          </div>
        </div>

        <div class="form-section">
          <h3 class="section-title">روش پرداخت <span class="icon"><span><?php echo alookhor_cc_checkout_icon('credit');?></span></span></h3>
          <div class="method-list">
            <label class="method-item selected">
              <div class="left">
                <span class="radio"></span>
                <div class="info">
                  <span class="name">پرداخت آنلاین (کارت به کارت)</span>
                  <span class="desc">پرداخت امن از طریق درگاه بانکی</span>
                </div>
              </div>
              <div style="display:flex;align-items:center;gap:10px">
                <span class="price">رایگان</span>
                <span class="icon"><span><?php echo alookhor_cc_checkout_icon('credit');?></span></span>
              </div>
              <input type="radio" name="payment_method" value="bacs" checked style="display:none">
            </label>
            <label class="method-item">
              <div class="left">
                <span class="radio"></span>
                <div class="info">
                  <span class="name">پرداخت در محل</span>
                  <span class="desc">پرداخت در زمان تحویل</span>
                </div>
              </div>
              <div style="display:flex;align-items:center;gap:10px">
                <span class="price muted">۳۰,۰۰۰ تومان</span>
                <span class="icon"><span><?php echo alookhor_cc_checkout_icon('money');?></span></span>
              </div>
              <input type="radio" name="payment_method" value="cod" style="display:none">
            </label>
          </div>

          <div class="security-box">
            <span class="icon"><span><?php echo alookhor_cc_checkout_icon('lock');?></span></span>
            <span>اطلاعات شما با بالاترین سطح امنیت محافظت می‌شود.</span>
          </div>

          <button type="submit" class="btn-place-order" name="woocommerce_checkout_place_order" value="پرداخت و تکمیل سفارش">
            <span><?php echo alookhor_cc_checkout_icon('card');?></span>
            پرداخت و تکمیل سفارش
            <span style="transform:rotate(180deg);display:inline-flex"><?php echo alookhor_cc_checkout_icon('arrowl');?></span>
          </button>
        </div>
      </form>
    </div>
  </div>

  <!-- Features -->
  <div class="checkout-features">
    <div class="feature">
      <span class="icon"><span><?php echo alookhor_cc_checkout_icon('headset');?></span></span>
      <div class="text">پشتیبانی ۲۴ ساعته<small>همیشه پاسخگوی شما هستیم</small></div>
    </div>
    <div class="feature">
      <span class="icon"><span><?php echo alookhor_cc_checkout_icon('return');?></span></span>
      <div class="text">ضمانت بازگشت کالا<small>تا ۷ روز بدون درنظر</small></div>
    </div>
    <div class="feature">
      <span class="icon"><span><?php echo alookhor_cc_checkout_icon('shield');?></span></span>
      <div class="text">ضمانت اصالت کالا<small>تضمین کیفیت و تازگی</small></div>
    </div>
    <div class="feature">
      <span class="icon"><span><?php echo alookhor_cc_checkout_icon('truck');?></span></span>
      <div class="text">ارسال سریع<small>به سراسر کشور</small></div>
    </div>
  </div>
</div>
<script>
document.addEventListener('DOMContentLoaded',function(){
  document.querySelectorAll('#alookhor-checkout .method-item').forEach(function(item){
    item.addEventListener('click',function(){
      var parent=this.closest('.method-list');
      parent.querySelectorAll('.method-item').forEach(function(i){i.classList.remove('selected')});
      this.classList.add('selected');
      var radio=this.querySelector('input[type=radio]');
      if(radio){ radio.checked=true; radio.dispatchEvent(new Event('change',{bubbles:true})); }
    });
  });
});
</script>
<?php
 return ob_get_clean();
}
}

// Override template
add_filter('template_include',function($template){
 if(function_exists('is_checkout')&&is_checkout()&&!is_wc_endpoint_url('order-received')){
   $custom=ALOOKHOR_CC_DIR.'templates/checkout.php';
   if(file_exists($custom)) return $custom;
 }
 return $template;
},PHP_INT_MAX);

add_filter('the_content',function($content){
 if(function_exists('is_checkout')&&is_checkout()&&!is_admin()&&in_the_loop()&&is_main_query()&&!is_wc_endpoint_url('order-received')){
   if(!empty($GLOBALS['alookhor_cc_checkout_rendered'])) return '';
   if(function_exists('alookhor_cc_checkout_markup')){
     $m=alookhor_cc_checkout_markup();
     if($m) return $m;
   }
 }
 return $content;
},PHP_INT_MAX);

add_filter('wc_get_template',function($template,$template_name,$args,$template_path,$default_path){
 if(in_array($template_name,['checkout/form-checkout.php','checkout/form-billing.php','checkout/form-shipping.php'])){
  $custom=ALOOKHOR_CC_DIR.'templates/checkout-partial.php';
  if(!file_exists($custom)){
   file_put_contents($custom,'<?php if(!defined("ABSPATH"))exit; echo function_exists("alookhor_cc_checkout_markup")?alookhor_cc_checkout_markup():""; ?>');
  }
  return $custom;
 }
 return $template;
},PHP_INT_MAX,5);

add_filter('woocommerce_locate_template',function($template,$template_name,$template_path){
 if(in_array($template_name,['checkout/form-checkout.php'])){
  $custom=ALOOKHOR_CC_DIR.'templates/checkout-partial.php';
  if(file_exists($custom)) return $custom;
 }
 return $template;
},PHP_INT_MAX,3);

// Prevent WooCommerce redirect to cart when empty for preview
add_action('template_redirect',function(){
 if(function_exists('is_checkout')&&is_checkout()&&!is_wc_endpoint_url('order-received')){
  $is_preview = isset($_GET['preview']) || isset($_GET['alookhor_preview']) || isset($_GET['elementor']) || (defined('ELEMENTOR_VERSION'));
  if($is_preview || (function_exists('WC') && WC()->cart && WC()->cart->is_empty())){
    // Allow our luxury template to show dummy data even when cart empty
    add_filter('woocommerce_checkout_redirect_empty_cart','__return_false');
    // Remove WC's own redirect
    remove_action('template_redirect','wc_template_redirect',20);
  }
 }
},1);

add_action('wp_enqueue_scripts',function(){
 if(function_exists('is_checkout')&&is_checkout()&&!is_wc_endpoint_url('order-received')){
  wp_enqueue_style('alookhor-cc-checkout',ALOOKHOR_CC_URL.'assets/css/frontend-checkout.css',[],ALOOKHOR_CC_BUILD);
 }
},20);

// Shortcodes for Elementor
add_action('init',function(){
 add_shortcode('alookhor_checkout',function(){return function_exists('alookhor_cc_checkout_markup')?alookhor_cc_checkout_markup():'';});
 add_shortcode('alookhor_checkout_steps',function(){
   ob_start();
   echo '<div id="alookhor-checkout" dir="rtl"><div class="checkout-steps" style="display:flex;justify-content:space-between;background:#1C1024;border:1px solid rgba(212,154,46,.25);border-radius:16px;padding:18px 28px"><div style="color:#4CAF50">● تکمیل خرید</div><div style="color:#E8B84A">● تسویه حساب</div><div style="color:#8a7a94">● سبد خرید</div></div></div>';
   return ob_get_clean();
 });
 add_shortcode('alookhor_checkout_summary',function(){
   $d=alookhor_cc_checkout_data();
   if(!$d) return '';
   $fmt=$d['fmt'];
   ob_start();
   echo '<div style="background:#1C1024;border:1px solid rgba(212,154,46,.2);border-radius:16px;padding:16px;color:#F5F3F0"><div style="font-weight:900;margin-bottom:12px">خلاصه سفارش</div>';
   foreach($d['items'] as $it){ echo '<div style="display:flex;gap:10px;margin-bottom:10px"><img src="'.esc_url($it['img']).'" style="width:48px;height:48px;border-radius:8px"><div><div style="font-size:12px">'.esc_html($it['name']).'</div><div style="font-size:11px;color:#E8B84A">'.$fmt($it['price']).' تومان</div></div></div>'; }
   echo '<div style="border-top:1px solid rgba(255,255,255,.1);padding-top:12px;margin-top:12px;display:flex;justify-content:space-between"><span>مبلغ قابل پرداخت</span><span style="color:#E8B84A;font-weight:900">'.$fmt($d['total']).' تومان</span></div></div>';
   return ob_get_clean();
 });
},5);
