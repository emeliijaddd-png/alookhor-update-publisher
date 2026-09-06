<?php
/** ALOOKHOR CART — v3.10.309: luxury cart exact per 101216 — fixed hero + no duplicate */
if(!defined('ABSPATH'))exit;

if(!function_exists('alookhor_cc_cart_icon')){
function alookhor_cc_cart_icon($name){
 $p=[
  'cart'=>'<path d="M6 6h15l-1.5 9h-13z"/><path d="M6 6L5 2H2"/><circle cx="9" cy="20" r="1.5"/><circle cx="18" cy="20" r="1.5"/>',
  'heart'=>'<path d="M19 14c1.49-1.46 3-3.21 3-5.5A5.5 5.5 0 0 0 16.5 3c-1.76 0-3 .5-4.5 2-1.5-1.5-2.74-2-4.5-2A5.5 5.5 0 0 0 2 8.5c0 2.3 1.5 4.05 3 5.5l7 7Z"/>',
  'trash'=>'<path d="M3 6h18"/><path d="M8 6V4h8v2"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6"/><path d="M10 11v6"/><path d="M14 11v6"/>',
  'share'=>'<circle cx="18" cy="5" r="2.5"/><circle cx="6" cy="12" r="2.5"/><circle cx="18" cy="19" r="2.5"/><path d="m8.2 10.8 7.6-4.5"/><path d="m8.2 13.2 7.6 4.5"/>',
  'plus'=>'<path d="M12 5v14"/><path d="M5 12h14"/>',
  'minus'=>'<path d="M5 12h14"/>',
  'chevr'=>'<path d="m9 18 6-6-6-6"/>',
  'arrowl'=>'<path d="M19 12H5"/><path d="M12 19l-7-7 7-7"/>',
  'leaf'=>'<path d="M12 2C7 2 3 6 3 11c0 5 4 9 9 9s9-4 9-9c0-5-4-9-9-9Z"/><path d="M12 2c0 0-3 3-3 7s3 7 3 7"/>',
  'truck'=>'<path d="M1 3h15v13H1z"/><path d="M16 8h4l3 6v3h-7V8z"/><circle cx="5.5" cy="18.5" r="2.5"/><circle cx="18.5" cy="18.5" r="2.5"/>',
  'shield'=>'<path d="M12 2L3 6v6c0 5 4 9 9 10 5-1 9-5 9-10V6l-9-4Z"/><path d="M9 12l2 2 4-4"/>',
  'return'=>'<path d="M3 7v6h6"/><path d="M21 17a9 9 0 0 0-9-9 9 9 0 0 0-6 2.3L3 13"/>',
  'headset'=>'<path d="M3 18v-6a9 9 0 0 1 18 0v6"/><path d="M21 19a2 2 0 0 1-2 2h-1a2 2 0 0 1-2-2v-3a2 2 0 0 1 2-2h3z"/><path d="M3 19a2 2 0 0 0 2 2h1a2 2 0 0 0 2-2v-3a2 2 0 0 0-2-2H3z"/>',
 ];
 $d=$p[$name]??'<circle cx="12" cy="12" r="8"/>';
 return '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round">'.$d.'</svg>';
}
}

if(!function_exists('alookhor_cc_cart_data')){
function alookhor_cc_cart_data(){
 if(!function_exists('WC')||!WC()||!WC()->cart)return null;
 $cart=WC()->cart;
 $items=[];
 foreach($cart->get_cart() as $key=>$ci){
  $prod=$ci['data']; if(!$prod)continue;
  $pid=$ci['product_id']; $vid=$ci['variation_id']?:0;
  $name=$prod->get_name(); if(mb_strpos($name,'سامسونگ')!==false||mb_strpos($name,'گوشی')!==false)continue;
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
   'key'=>$key,'id'=>$pid,'vid'=>$vid,'name'=>$name,'img'=>$img,'qty'=>$qty,
   'price'=>$price,'regular'=>$regular,'subtotal'=>$subtotal,'weight'=>$weight_label,
   'permalink'=>get_permalink($pid),
  ];
 }
 $cur=get_woocommerce_currency();
 $toman_rate=$cur==='IRR'?10:($cur==='IRT'?1:0);
 $fa_th=function($n){return strtr(number_format((float)$n,0,'.','٬'),['0'=>'۰','1'=>'۱','2'=>'۲','3'=>'۳','4'=>'۴','5'=>'۵','6'=>'۶','7'=>'۷','8'=>'۸','9'=>'۹']);};
 $fmt=function($a) use($fa_th,$toman_rate){
  $a=(float)$a; if($a<=0)return '۰';
  if($toman_rate>0) return $fa_th((int)round($a/$toman_rate));
  return $fa_th($a);
 };
 $subtotal=(float)$cart->get_subtotal();
 $discount=(float)$cart->get_discount_total();
 $total=(float)$cart->get_total('edit');
 if($subtotal<=0){ foreach($items as $it) $subtotal+=$it['subtotal']; }
 if($total<=0) $total=$subtotal-$discount;
 return [
  'items'=>$items,
  'count'=>count($items),
  'subtotal'=>$subtotal,'discount'=>$discount,'total'=>$total,
  'fmt'=>$fmt,'fa_th'=>$fa_th,
  'shop'=>wc_get_page_permalink('shop'),
  'checkout'=>wc_get_checkout_url(),
  'cart_url'=>wc_get_cart_url(),
 ];
}
}

if(!function_exists('alookhor_cc_cart_markup')){
function alookhor_cc_cart_markup(){
 $d=alookhor_cc_cart_data(); if(!$d)return '<div class="alookhor-cart-empty">سبد خرید خالی است</div>';
 $fmt=$d['fmt']; $fa_th=$d['fa_th'];
 $img=ALOOKHOR_CC_URL.'assets/images/';
 ob_start();
 $__css=file_get_contents(ALOOKHOR_CC_DIR.'assets/css/frontend-cart.css');
 if($__css) echo '<style id="alookhor-cart-inline">'.$__css.'</style>';
?>
<div id="alookhor-cart" dir="rtl">
  <div class="cart-hero">
    <img src="<?php echo esc_url($img.'bowl.jpg');?>" alt="" class="cart-hero-bg">
    <div class="cart-hero-content">
      <div class="cart-hero-left">
        <img src="<?php echo esc_url($img.'bowl.jpg');?>" alt="کاسه آلو">
        <div>
          <div class="breadcrumb"><a href="<?php echo esc_url(home_url('/'));?>">خانه</a><span>›</span><span>سبد خرید</span></div>
          <h1><span><?php echo alookhor_cc_cart_icon('cart');?></span> سبد خرید شما</h1>
          <p>محصولات منتخب شما در یک نگاه و با اطمینان خرید کنید</p>
        </div>
      </div>
      <div class="cart-hero-tagline"><span><?php echo alookhor_cc_cart_icon('leaf');?></span> طعم اصالت از دل طبیعت ایران</div>
    </div>
  </div>

  <div class="cart-main-grid">
    <div class="cart-products">
      <div class="cart-products-box">
        <div class="cart-products-header">
          <span>محصول</span><span>وزن / بسته‌بندی</span><span>قیمت واحد</span><span>تعداد</span><span>مبلغ کل</span><span>عملیات</span>
        </div>
        <div>
          <?php foreach($d['items'] as $it):?>
          <div class="cart-item">
            <div class="cart-item-prod">
              <img src="<?php echo esc_url($it['img']);?>" alt="<?php echo esc_attr($it['name']);?>">
              <div>
                <a href="<?php echo esc_url($it['permalink']);?>"><?php echo esc_html($it['name']);?></a>
                <span class="badge">بیشتر</span>
              </div>
            </div>
            <div><select><option><?php echo esc_html($it['weight']);?></option><option>۲۵۰ گرم</option><option>۵۰۰ گرم</option><option>۱ کیلوگرم</option></select></div>
            <div class="price"><?php echo $fmt($it['price']);?> تومان</div>
            <div><div class="cart-qty"><button type="button" data-cart-qty="-" data-key="<?php echo esc_attr($it['key']);?>"><span><?php echo alookhor_cc_cart_icon('minus');?></span></button><span><?php echo $fa_th($it['qty']);?></span><button type="button" data-cart-qty="+" data-key="<?php echo esc_attr($it['key']);?>"><span><?php echo alookhor_cc_cart_icon('plus');?></span></button></div></div>
            <div class="price-total"><?php echo $fmt($it['subtotal']);?> تومان</div>
            <div class="cart-actions"><button type="button" data-wishlist><span><?php echo alookhor_cc_cart_icon('heart');?></span></button><button type="button" data-cart-remove="<?php echo esc_attr($it['key']);?>"><span><?php echo alookhor_cc_cart_icon('trash');?></span></button></div>
          </div>
          <?php endforeach;?>
          <?php if(empty($d['items'])):?>
          <div style="padding:28px;text-align:center;color:#a48db8;font-size:13px">سبد خرید شما خالی است — <a href="<?php echo esc_url($d['shop']);?>" style="color:#f7b32b">رفتن به فروشگاه</a></div>
          <?php endif;?>
        </div>
        <div class="cart-products-footer">
          <a href="<?php echo esc_url($d['shop']);?>" class="btn-continue"><span><?php echo alookhor_cc_cart_icon('arrowl');?></span> ادامه خرید</a>
          <button type="button" class="btn-share"><span><?php echo alookhor_cc_cart_icon('share');?></span> سبد خرید را به اشتراک بگذارید</button>
        </div>
      </div>

      <div class="suggested">
        <h2><span><?php echo alookhor_cc_cart_icon('cart');?></span> پیشنهاد تکمیل خرید <small>این محصولات را هم امتحان کنید</small></h2>
        <div class="suggested-grid">
          <?php
          $related_ids=[];
          if(!empty($d['items'])){ $first_pid=$d['items'][0]['id']; $prod=wc_get_product($first_pid); if($prod){ $related_ids=wc_get_related_products($first_pid,4);} }
          if(empty($related_ids)){ $related_ids=wc_get_products(['limit'=>4,'return'=>'ids','status'=>'publish']); }
          foreach(array_slice($related_ids,0,4) as $rid){
            $rp=wc_get_product($rid); if(!$rp)continue;
            $ru=wp_get_attachment_image_url($rp->get_image_id(),'woocommerce_thumbnail'); $ru=$ru?:$img.'bowl.jpg';
            $rprice=(float)$rp->get_price(); if(!$rprice && $rp->is_type('variable')){ $rprice=(float)$rp->get_variation_price('min',true); if(!$rprice) $rprice=(float)$rp->get_variation_regular_price('min',true); }
            $rname=$rp->get_name(); if(mb_strpos($rname,'سامسونگ')!==false)continue;
          ?>
          <div class="suggested-card">
            <div class="img-wrap"><img src="<?php echo esc_url($ru);?>" alt="<?php echo esc_attr($rname);?>"><span class="heart"><span><?php echo alookhor_cc_cart_icon('heart');?></span></span><span class="discount">۱۰٪ تخفیف</span></div>
            <div class="info"><span class="name"><?php echo esc_html($rname);?></span><span class="price"><?php echo $fmt($rprice);?> تومان</span><button type="button" class="add-btn"><span><?php echo alookhor_cc_cart_icon('cart');?></span> افزودن</button></div>
          </div>
          <?php } ?>
        </div>
      </div>

      <div class="features">
        <div class="feature"><span class="icon"><span><?php echo alookhor_cc_cart_icon('truck');?></span></span><div>ارسال سریع<br><small>تحویل فوری</small></div></div>
        <div class="feature"><span class="icon"><span><?php echo alookhor_cc_cart_icon('shield');?></span></span><div>ضمانت اصالت کالا<br><small>تضمین کیفیت و اصالت</small></div></div>
        <div class="feature"><span class="icon"><span><?php echo alookhor_cc_cart_icon('return');?></span></span><div>ضمانت بازگشت کالا<br><small>۷ روز بدون قید و شرط</small></div></div>
        <div class="feature"><span class="icon"><span><?php echo alookhor_cc_cart_icon('headset');?></span></span><div>پشتیبانی ۲۴ ساعته<br><small>همیشه پاسخگوی شما هستیم</small></div></div>
      </div>

      <div class="faq">
        <h3><span>؟</span> سوالات متداول</h3>
        <details><summary>هزینه ارسال سفارشم چقدر است؟<span><?php echo alookhor_cc_cart_icon('chevr');?></span></summary><p>هزینه ارسال بر اساس وزن و مقصد محاسبه می‌شود و در خلاصه سفارش نمایش داده می‌شود. ارسال رایگان برای سفارش‌های بالای ۵۰۰ هزار تومان.</p></details>
        <details><summary>چطور می‌توانم سفارشم را دستم برسانم؟<span><?php echo alookhor_cc_cart_icon('chevr');?></span></summary><p>پس از ثبت سفارش، کد رهگیری برای شما پیامک می‌شود و می‌توانید وضعیت را در حساب کاربری پیگیری کنید.</p></details>
        <details><summary>آیا امکان بازگشت کالا وجود دارد؟<span><?php echo alookhor_cc_cart_icon('chevr');?></span></summary><p>بله، تا ۷ روز پس از تحویل امکان بازگشت کالا در صورت عدم رضایت وجود دارد.</p></details>
      </div>
    </div>

    <div class="cart-summary">
      <div>
        <div class="summary-title"><span class="icon">≡</span> خلاصه سفارش</div>
        <div class="summary-rows">
          <div class="summary-row"><span class="label">جمع مبلغ کالاها</span><span class="value"><?php echo $fmt($d['subtotal']);?> تومان</span></div>
          <div class="summary-row"><span class="label">تخفیف</span><span class="value mint"><?php echo $fmt($d['discount']);?> تومان</span></div>
          <div class="summary-row"><span class="label">هزینه ارسال</span><span class="value mint">رایگان</span></div>
          <div class="summary-divider"></div>
          <div class="summary-total"><span class="label">مبلغ قابل پرداخت</span><span class="value"><?php echo $fmt($d['total']);?> تومان</span></div>
        </div>
        <a href="<?php echo esc_url($d['checkout']);?>" class="btn-checkout"><span>ادامه و ثبت سفارش</span><span><?php echo alookhor_cc_cart_icon('arrowl');?></span></a>
        <div class="coupon-box"><div class="title"><span>٪</span> کد تخفیف دارید؟</div><div class="row"><input type="text" placeholder="کد تخفیف را وارد کنید ..."><button type="button">اعمال</button></div></div>
        <div class="shipping-info"><span class="icon"><span><?php echo alookhor_cc_cart_icon('truck');?></span></span><div><span style="display:block;font-weight:700;color:#fbf3e2;font-size:12px">ارسال به سراسر کشور</span><span style="display:block;font-size:11px;color:rgba(164,141,184,.70)">تحویل سریع و مطمئن در کمترین زمان</span></div></div>
      </div>
    </div>
  </div>
</div>
<script>
document.addEventListener('DOMContentLoaded',function(){
  document.querySelectorAll('[data-cart-qty]').forEach(function(btn){
    btn.addEventListener('click',function(){
      var key=this.getAttribute('data-key'); var dir=this.getAttribute('data-cart-qty');
      var span=this.parentElement.querySelector('span:nth-child(2)'); var cur=parseInt(span.textContent.replace(/[^0-9]/g,''))||1;
      if(dir==='+')cur=Math.min(99,cur+1); else cur=Math.max(1,cur-1);
      fetch('<?php echo esc_url(home_url('/?wc-ajax=update_cart'));?>',{method:'POST',headers:{'Content-Type':'application/x-www-form-urlencoded'},body:'cart['+encodeURIComponent(key)+'][qty]='+cur}).then(()=>location.reload());
    });
  });
  document.querySelectorAll('[data-cart-remove]').forEach(function(btn){
    btn.addEventListener('click',function(){
      var key=this.getAttribute('data-cart-remove');
      fetch('<?php echo esc_url(home_url('/?wc-ajax=remove_from_cart'));?>',{method:'POST',headers:{'Content-Type':'application/x-www-form-urlencoded'},body:'cart_key='+encodeURIComponent(key)}).then(()=>location.reload());
    });
  });
});
</script>
<?php
 return ob_get_clean();
}
}

// FIX: Return original theme template to keep footer at BOTTOM - luxury comes from wc_get_template override
// Custom template get_header()+get_footer() caused footer to appear ABOVE cart due to Woodmart wrapper structure
add_filter('template_include',function($template){
 if(function_exists('is_cart')&&is_cart()){
   // Always return original template (page.php) - Woodmart structure ensures footer after main content
   return $template;
 }
 return $template;
},PHP_INT_MAX);

add_action('wp_enqueue_scripts',function(){
 if(function_exists('is_cart')&&is_cart()){
  wp_enqueue_style('alookhor-cc-cart',ALOOKHOR_CC_URL.'assets/css/frontend-cart.css',[],ALOOKHOR_CC_BUILD);
 }
},20);

add_action('init',function(){
 if(shortcode_exists('woocommerce_cart')) remove_shortcode('woocommerce_cart');
 add_shortcode('woocommerce_cart',function(){ return alookhor_cc_cart_markup(); });
},20);

// Disable product categories showcase on cart page — prevents آلو خشکبار etc appearing
add_filter('alookhor_cc_category_settings',function($s){
 if(function_exists('is_cart')&&is_cart()){ $s['enabled']=false; }
 return $s;
},PHP_INT_MAX);
add_action('wp',function(){
 if(function_exists('is_cart')&&is_cart()){
  remove_action('wp_footer','alookhor_cc_category_template',2);
 }
},1);

// Also override empty cart template to prevent Woodmart categories showing
// Override BOTH cart and cart-empty to use our luxury markup - prevents old Woodmart cart
add_filter('wc_get_template',function($template,$template_name,$args,$template_path,$default_path){
 if(in_array($template_name,['cart/cart.php','cart/cart-empty.php'])){
  $custom=ALOOKHOR_CC_DIR.'templates/cart-partial.php';
  if(!file_exists($custom)){
   file_put_contents($custom,'<?php if(!defined("ABSPATH"))exit; echo function_exists("alookhor_cc_cart_markup")?alookhor_cc_cart_markup():""; ?>');
  }
  return $custom;
 }
 return $template;
},PHP_INT_MAX,5);

// Also override woocommerce_locate_template for extra safety
add_filter('woocommerce_locate_template',function($template,$template_name,$template_path){
 if(in_array($template_name,['cart/cart.php','cart/cart-empty.php'])){
  $custom=ALOOKHOR_CC_DIR.'templates/cart-partial.php';
  if(file_exists($custom)) return $custom;
 }
 return $template;
},PHP_INT_MAX,3);
// Filter Samsung out of cart display
add_filter('woocommerce_cart_item_name',function($name,$cart_item,$cart_item_key){
 if(mb_strpos($name,'سامسونگ')!==false||mb_strpos($name,'گوشی')!==false) return '';
 return $name;
},10,3);
// Extra JS to hide old Woodmart white cart if it appears above
add_action('wp_footer',function(){
 if(!function_exists('is_cart')||!is_cart())return;
 echo '<script>document.addEventListener("DOMContentLoaded",function(){var lux=document.getElementById("alookhor-cart");if(!lux)return;document.querySelectorAll(".woocommerce-cart-form, .cart-collaterals, .woocommerce-notices-wrapper, .wd-empty-cart, .wd-cart, .shop_table, .woocommerce-cart .woocommerce").forEach(function(el){if(!lux.contains(el)&&!el.contains(lux)){var txt=el.textContent||"";if(txt.indexOf("جمع جزء")>-1||txt.indexOf("تکمیل خرید")>-1||txt.indexOf("دیگران خریده")>-1){el.style.display="none";}}});});</script>';
},100);
