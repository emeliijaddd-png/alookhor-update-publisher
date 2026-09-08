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
 // Always render luxury cart - prevent duplicate via GLOBALS in filters, not here
 $GLOBALS['alookhor_cc_cart_rendered']=true;
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
            $rname=$rp->get_name();
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

// FIX: Use FULL custom template to ensure ONLY luxury, no old white - with footer fix JS
add_filter('template_include',function($template){
 if(function_exists('is_cart')&&is_cart()){
   $custom=ALOOKHOR_CC_DIR.'templates/cart.php';
   if(file_exists($custom)) return $custom;
   return $template;
 }
 return $template;
},PHP_INT_MAX);

// FORCE: Override page content on cart to luxury - prevents Elementor/Gutenberg old white cart - only once
add_filter('the_content',function($content){
 if(function_exists('is_cart')&&is_cart()&&!is_admin()&&in_the_loop()&&is_main_query()){
   if(!empty($GLOBALS['alookhor_cc_cart_rendered'])) return ''; // already rendered
   if(function_exists('alookhor_cc_cart_markup')){
     $m=alookhor_cc_cart_markup();
     if($m) return $m;
   }
 }
 return $content;
},PHP_INT_MAX);

// FORCE: Override WooCommerce Cart Block (Gutenberg) to luxury - only once
add_filter('render_block',function($block_content,$block){
 if(function_exists('is_cart')&&is_cart()){
   if(isset($block['blockName'])&&$block['blockName']==='woocommerce/cart'){
     if(!empty($GLOBALS['alookhor_cc_cart_rendered'])) return '';
     if(function_exists('alookhor_cc_cart_markup')){
       $m=alookhor_cc_cart_markup();
       if($m) return $m;
     }
   }
 }
 return $block_content;
},PHP_INT_MAX,2);

// FORCE: Override Elementor cart widget - only once, prevents 3 carts
add_filter('elementor/widget/render_content',function($content,$widget){
 if(function_exists('is_cart')&&is_cart()&&!is_admin()){
   if(!empty($GLOBALS['alookhor_cc_cart_rendered'])){
     // If already rendered, hide any other cart widgets
     if(is_object($widget)){
       $name=$widget->get_name();
       if(strpos($name,'cart')!==false) return '';
     }
     if(strpos($content,'جمع جزء')!==false || strpos($content,'دیگران خریده اند')!==false) return '';
     return $content;
   }
   if(is_object($widget)){
     $name=$widget->get_name();
     $cart_widgets=['woocommerce-cart','cart','wd_cart','wd_woocommerce_cart','wd_cart_table','wd_cart_totals','woocommerce_cart','cart_table','woocommerce-cart-totals','wd_woo_cart'];
     if(in_array($name,$cart_widgets) || strpos($name,'cart')!==false){
       if(function_exists('alookhor_cc_cart_markup')){
         $m=alookhor_cc_cart_markup();
         if($m) return $m;
       }
     }
   }
   if(strpos($content,'جمع جزء')!==false || strpos($content,'دیگران خریده اند')!==false || strpos($content,'ادامه جهت تسویه حساب')!==false){
     if(function_exists('alookhor_cc_cart_markup')){
       $m=alookhor_cc_cart_markup();
       if($m) return $m;
     }
   }
 }
 return $content;
},PHP_INT_MAX,2);

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
  // Remove Woodmart cart hooks that might render old cart
  remove_action('woocommerce_cart_collaterals','woocommerce_cross_sell_display');
  remove_action('woocommerce_cart_collaterals','woocommerce_cart_totals',10);
  // Woodmart specific
  if(function_exists('woodmart_woocommerce_cart_empty')){
    remove_action('woocommerce_cart_is_empty','woodmart_woocommerce_cart_empty',10);
  }
  // Remove any Woodmart cart template actions
  global $wp_filter;
  if(isset($wp_filter['woocommerce_after_cart'])){
    // keep it but ensure it doesn't output old cross-sells white
  }
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
// Samsung filter removed - show all products
// Extra JS FINAL v3.10.358 - hide EVERY white element outside luxury, including top white pill and big white rect
// Minimal white fix v3.10.362 - only hide white pill + checkout steps, keep cart visible
add_action('wp_footer',function(){
 if(!function_exists('is_cart')||!is_cart())return;
 echo '<script>
document.addEventListener("DOMContentLoaded",function(){
  var lux=document.getElementById("alookhor-cart");
  if(!lux){ console.log("ALOOKHOR cart not found"); return; }
  function hideWhite(){
    // hide only Woodmart white titles and checkout steps
    document.querySelectorAll(".wd-page-title,.whb-page-title,.wd-entities-title,.page-title,.entry-header,.wd-page-heading,.wd-checkout-steps,.wd-checkout-steps-wrapper").forEach(function(el){
      if(el.closest("#alookhor-cart")||el.closest("header")||el.closest("footer")||el.closest(".whb-header")) return;
      el.style.setProperty("display","none","important");
    });
    // hide small white pill with exact text سبد خرید
    document.querySelectorAll("div,section").forEach(function(el){
      if(el.closest("#alookhor-cart")||el.closest("header")||el.closest("footer")||el.closest(".whb-header")||el.id==="alookhor-cart") return;
      var t=(el.textContent||"").trim();
      if(t==="سبد خرید" && el.offsetWidth>100 && el.offsetWidth<600){
        el.style.setProperty("display","none","important");
      }
    });
    // ensure cart visible
    lux.style.setProperty("display","block","important");
    lux.style.setProperty("visibility","visible","important");
    lux.style.setProperty("opacity","1","important");
    document.body.style.background="#0d0510";
  }
  hideWhite();
  setTimeout(hideWhite,300);
  setTimeout(hideWhite,1000);
});
</script>';
},100);



// ===== v3.10.366+ — ELEMENTOR SHORTCODES FOR CART PAGE BUILDER — ROBUST FOR ELEMENTOR =====
if(!function_exists('alookhor_cc_cart_icon_safe')){
function alookhor_cc_cart_icon_safe($name){
  if(function_exists('alookhor_cc_cart_icon')) return alookhor_cc_cart_icon($name);
  return '<span style="display:inline-block;width:20px;height:20px;background:#D49A2E;border-radius:4px"></span>';
}
}

if(!function_exists('alookhor_cc_cart_data_robust')){
function alookhor_cc_cart_data_robust(){
  // Try real cart
  if(function_exists('WC') && WC() && WC()->cart){
    $d = alookhor_cc_cart_data();
    if($d) return $d;
  }
  // Fallback dummy for Elementor preview / empty cart
  $fmt = function($a){ return number_format((float)$a,0,'.',','); };
  $fa_th = function($n){ return (string)$n; };
  $shop = function_exists('wc_get_page_permalink') ? wc_get_page_permalink('shop') : home_url('/shop/');
  $checkout = function_exists('wc_get_checkout_url') ? wc_get_checkout_url() : home_url('/checkout/');
  $cart_url = function_exists('wc_get_cart_url') ? wc_get_cart_url() : home_url('/cart/');
  return [
    'items'=>[
      ['key'=>'dummy1','id'=>1,'vid'=>0,'name'=>'آلو بخارا جنگلی ترش ارگانیک (نمایشی)','img'=>ALOOKHOR_CC_URL.'assets/images/bowl.jpg','qty'=>2,'price'=>420000,'regular'=>500000,'subtotal'=>840000,'weight'=>'۵۰۰ گرم','permalink'=>home_url('/')],
      ['key'=>'dummy2','id'=>2,'vid'=>0,'name'=>'گردو با پوست کاغذی (نمایشی)','img'=>ALOOKHOR_CC_URL.'assets/images/bowl.jpg','qty'=>1,'price'=>690000,'regular'=>750000,'subtotal'=>690000,'weight'=>'۱ کیلوگرم','permalink'=>home_url('/')],
    ],
    'count'=>2,
    'subtotal'=>1530000,
    'discount'=>0,
    'total'=>1530000,
    'fmt'=>$fmt,
    'fa_th'=>$fa_th,
    'shop'=>$shop,
    'checkout'=>$checkout,
    'cart_url'=>$cart_url,
  ];
}
}

if(!function_exists('alookhor_cc_cart_hero_shortcode_final')){
function alookhor_cc_cart_hero_shortcode_final($atts=[]){
  $img = defined('ALOOKHOR_CC_URL') ? ALOOKHOR_CC_URL.'assets/images/' : '/wp-content/plugins/alookhor-control-center/assets/images/';
  ob_start();
  // Inline CSS for Elementor preview so it always visible
  echo '<style>.cart-hero{position:relative;overflow:hidden;border-radius:20px;background:#1C1024;border:1px solid rgba(212,154,46,.25);padding:24px;color:#F5F3F0} .cart-hero-bg{position:absolute;inset:0;width:100%;height:100%;object-fit:cover;opacity:.25} .cart-hero-content{position:relative;z-index:2;display:flex;justify-content:space-between;align-items:center;gap:16px} .cart-hero-left{display:flex;gap:16px;align-items:center} .cart-hero-left img{width:64px;height:64px;border-radius:12px;object-fit:cover} .cart-hero-left h1{font-size:22px;font-weight:900;margin:0} .cart-hero-tagline{background:rgba(212,154,46,.15);border:1px solid rgba(212,154,46,.25);padding:8px 14px;border-radius:999px;font-size:12px}</style>';
?>
<div id="alookhor-cart-hero" dir="rtl">
  <div class="cart-hero">
    <img src="<?php echo esc_url($img.'bowl.jpg');?>" alt="" class="cart-hero-bg">
    <div class="cart-hero-content">
      <div class="cart-hero-left">
        <img src="<?php echo esc_url($img.'bowl.jpg');?>" alt="کاسه آلو">
        <div>
          <div class="breadcrumb" style="font-size:12px;color:#C8C2C9"><a href="<?php echo esc_url(home_url('/'));?>" style="color:#E8B84A">خانه</a><span> › </span><span>سبد خرید</span></div>
          <h1><span><?php echo alookhor_cc_cart_icon_safe('cart');?></span> سبد خرید شما</h1>
          <p style="margin:4px 0 0;color:#C8C2C9;font-size:13px">محصولات منتخب شما در یک نگاه و با اطمینان خرید کنید</p>
        </div>
      </div>
      <div class="cart-hero-tagline"><span><?php echo alookhor_cc_cart_icon_safe('leaf');?></span> طعم اصالت از دل طبیعت ایران</div>
    </div>
  </div>
</div>
<?php
  return ob_get_clean();
}
}

if(!function_exists('alookhor_cc_cart_products_shortcode_final')){
function alookhor_cc_cart_products_shortcode_final(){
  $d = alookhor_cc_cart_data_robust();
  if(!$d) return '<div style="padding:20px;background:#1C1024;color:#F5F3F0;border-radius:12px">سبد خرید خالی است</div>';
  $fmt=$d['fmt']; $fa_th=$d['fa_th'];
  ob_start();
  echo '<style>.cart-products-box{background:#1C1024;border:1px solid rgba(212,154,46,.2);border-radius:16px;overflow:hidden} .cart-products-header{display:grid;grid-template-columns:2fr 1fr 1fr 1fr 1fr 1fr;gap:8px;padding:14px;background:rgba(212,154,46,.08);font-size:11px;color:#C8C2C9} .cart-item{display:grid;grid-template-columns:2fr 1fr 1fr 1fr 1fr 1fr;gap:8px;padding:14px;border-top:1px solid rgba(255,255,255,.06);align-items:center} .cart-item img{width:48px;height:48px;border-radius:8px;object-fit:cover} .price{color:#E8B84A;font-weight:700} .btn-continue{color:#F5F3F0;text-decoration:none;font-size:12px} .btn-share{background:transparent;border:1px solid rgba(212,154,46,.25);color:#E8B84A;padding:8px 12px;border-radius:8px;font-size:12px}</style>';
?>
<div id="alookhor-cart-products" dir="rtl">
  <div class="cart-products-box">
    <div class="cart-products-header">
      <span>محصول</span><span>وزن</span><span>قیمت واحد</span><span>تعداد</span><span>مبلغ کل</span><span>عملیات</span>
    </div>
    <div>
      <?php foreach($d['items'] as $it):?>
      <div class="cart-item">
        <div style="display:flex;gap:10px;align-items:center">
          <img src="<?php echo esc_url($it['img']);?>" alt="">
          <a href="<?php echo esc_url($it['permalink']);?>" style="color:#F5F3F0;text-decoration:none;font-size:13px"><?php echo esc_html($it['name']);?></a>
        </div>
        <div style="color:#C8C2C9;font-size:12px"><?php echo esc_html($it['weight']);?></div>
        <div class="price"><?php echo $fmt($it['price']);?> تومان</div>
        <div style="color:#F5F3F0"><?php echo $fa_th($it['qty']);?></div>
        <div class="price"><?php echo $fmt($it['subtotal']);?> تومان</div>
        <div><span style="color:#C8C2C9">🗑️</span></div>
      </div>
      <?php endforeach;?>
    </div>
    <div style="padding:12px;display:flex;justify-content:space-between">
      <a href="<?php echo esc_url($d['shop']);?>" class="btn-continue">← ادامه خرید</a>
      <button class="btn-share">اشتراک‌گذاری سبد</button>
    </div>
  </div>
</div>
<?php
  return ob_get_clean();
}
}

if(!function_exists('alookhor_cc_cart_summary_shortcode_final')){
function alookhor_cc_cart_summary_shortcode_final(){
  $d = alookhor_cc_cart_data_robust();
  if(!$d) return '';
  $fmt=$d['fmt'];
  ob_start();
  echo '<style>.cart-summary>div{background:#1C1024;border:1px solid rgba(212,154,46,.2);border-radius:16px;padding:18px;color:#F5F3F0} .summary-title{font-weight:900;margin-bottom:12px} .summary-row{display:flex;justify-content:space-between;padding:8px 0;font-size:13px;color:#C8C2C9} .summary-total{display:flex;justify-content:space-between;padding:12px 0;border-top:1px solid rgba(255,255,255,.1);font-weight:900;color:#E8B84A} .btn-checkout{display:block;background:linear-gradient(135deg,#D49A2E,#E8B84A);color:#0D0510;text-align:center;padding:14px;border-radius:12px;text-decoration:none;font-weight:900;margin:12px 0} .coupon-box{margin-top:12px} .coupon-box input{width:70%;padding:10px;border-radius:8px;border:1px solid rgba(255,255,255,.15);background:rgba(255,255,255,.06);color:#fff} .coupon-box button{width:28%;padding:10px;border-radius:8px;background:#D49A2E;border:none;color:#0D0510;font-weight:700}</style>';
?>
<div id="alookhor-cart-summary" dir="rtl">
  <div class="cart-summary">
    <div>
      <div class="summary-title">≡ خلاصه سفارش</div>
      <div class="summary-rows">
        <div class="summary-row"><span>جمع مبلغ کالاها</span><span><?php echo $fmt($d['subtotal']);?> تومان</span></div>
        <div class="summary-row"><span>تخفیف</span><span><?php echo $fmt($d['discount']);?> تومان</span></div>
        <div class="summary-row"><span>هزینه ارسال</span><span>رایگان</span></div>
        <div class="summary-total"><span>مبلغ قابل پرداخت</span><span><?php echo $fmt($d['total']);?> تومان</span></div>
      </div>
      <a href="<?php echo esc_url($d['checkout']);?>" class="btn-checkout">ادامه و ثبت سفارش</a>
      <div class="coupon-box"><div style="font-size:12px;margin-bottom:8px">٪ کد تخفیف دارید؟</div><div style="display:flex;gap:8px"><input type="text" placeholder="کد تخفیف..."><button>اعمال</button></div></div>
    </div>
  </div>
</div>
<?php
  return ob_get_clean();
}
}

if(!function_exists('alookhor_cc_cart_suggested_shortcode_final')){
function alookhor_cc_cart_suggested_shortcode_final(){
  $d = alookhor_cc_cart_data_robust();
  if(!$d) return '';
  $fmt=$d['fmt']; $img=defined('ALOOKHOR_CC_URL')?ALOOKHOR_CC_URL.'assets/images/':'/wp-content/plugins/alookhor-control-center/assets/images/';
  ob_start();
  echo '<style>.suggested{background:#1C1024;border:1px solid rgba(212,154,46,.2);border-radius:16px;padding:18px} .suggested h2{font-size:16px;font-weight:900;color:#F5F3F0;margin:0 0 14px} .suggested-grid{display:grid;grid-template-columns:repeat(4,1fr);gap:12px} .suggested-card{background:rgba(255,255,255,.04);border:1px solid rgba(255,255,255,.08);border-radius:12px;overflow:hidden} .suggested-card .img-wrap{position:relative} .suggested-card img{width:100%;height:160px;object-fit:cover} .suggested-card .info{padding:10px} .suggested-card .name{font-size:12px;color:#F5F3F0;display:block;margin-bottom:6px} .suggested-card .price{font-size:12px;color:#E8B84A;font-weight:700} .add-btn{width:100%;margin-top:8px;background:#D49A2E;border:none;padding:8px;border-radius:8px;color:#0D0510;font-weight:700;font-size:12px}</style>';
?>
<div id="alookhor-cart-suggested" dir="rtl">
  <div class="suggested">
    <h2>🛒 پیشنهاد تکمیل خرید <small style="color:#C8C2C9;font-weight:400;font-size:12px">این محصولات را هم امتحان کنید</small></h2>
    <div class="suggested-grid">
      <?php
      $related_ids=[];
      if(function_exists('wc_get_products')){
        $related_ids=wc_get_products(['limit'=>4,'return'=>'ids','status'=>'publish']);
      }
      if(empty($related_ids)) $related_ids=[1,2,3,4];
      foreach(array_slice($related_ids,0,4) as $rid){
        if(function_exists('wc_get_product')){
          $rp=wc_get_product($rid); if(!$rp) continue;
          $ru=wp_get_attachment_image_url($rp->get_image_id(),'woocommerce_thumbnail'); $ru=$ru?:$img.'bowl.jpg';
          $rprice=(float)$rp->get_price(); if(!$rprice && $rp->is_type('variable')){ $rprice=(float)$rp->get_variation_price('min',true); }
          $rname=$rp->get_name();
        } else {
          $ru=$img.'bowl.jpg'; $rprice=420000; $rname='آلو بخارا نمونه';
        }
      ?>
      <div class="suggested-card">
        <div class="img-wrap"><img src="<?php echo esc_url($ru);?>" alt=""><span style="position:absolute;top:8px;right:8px;background:#E93D5A;color:#fff;padding:2px 6px;border-radius:4px;font-size:10px">۱۰٪ تخفیف</span></div>
        <div class="info"><span class="name"><?php echo esc_html($rname);?></span><span class="price"><?php echo $fmt($rprice);?> تومان</span><button class="add-btn">افزودن</button></div>
      </div>
      <?php } ?>
    </div>
  </div>
</div>
<?php
  return ob_get_clean();
}
}

if(!function_exists('alookhor_cc_cart_features_shortcode_final')){
function alookhor_cc_cart_features_shortcode_final(){
  ob_start();
  echo '<style>.features{display:grid;grid-template-columns:repeat(4,1fr);gap:12px} .feature{background:#1C1024;border:1px solid rgba(212,154,46,.15);border-radius:12px;padding:14px;display:flex;gap:10px;align-items:center;color:#F5F3F0;font-size:13px} .feature small{color:#C8C2C9;font-size:11px}</style>';
?>
<div id="alookhor-cart-features" dir="rtl">
  <div class="features">
    <div class="feature">🚚<div>ارسال سریع<br><small>تحویل فوری</small></div></div>
    <div class="feature">🛡️<div>ضمانت اصالت کالا<br><small>تضمین کیفیت و اصالت</small></div></div>
    <div class="feature">↩️<div>ضمانت بازگشت کالا<br><small>۷ روز بدون قید و شرط</small></div></div>
    <div class="feature">🎧<div>پشتیبانی ۲۴ ساعته<br><small>همیشه پاسخگوی شما هستیم</small></div></div>
  </div>
</div>
<?php
  return ob_get_clean();
}
}

if(!function_exists('alookhor_cc_cart_faq_shortcode_final')){
function alookhor_cc_cart_faq_shortcode_final(){
  ob_start();
  echo '<style>.faq{background:#1C1024;border:1px solid rgba(212,154,46,.15);border-radius:16px;padding:18px;color:#F5F3F0} .faq h3{font-size:15px;font-weight:900;margin:0 0 14px} .faq details{padding:12px 0;border-bottom:1px solid rgba(255,255,255,.06)} .faq summary{cursor:pointer;font-size:13px;font-weight:700}</style>';
?>
<div id="alookhor-cart-faq" dir="rtl">
  <div class="faq">
    <h3>؟ سوالات متداول</h3>
    <details><summary>هزینه ارسال سفارشم چقدر است؟</summary><p style="color:#C8C2C9;font-size:12px;margin:8px 0 0">هزینه ارسال بر اساس وزن و مقصد محاسبه می‌شود و در خلاصه سفارش نمایش داده می‌شود.</p></details>
    <details><summary>چطور می‌توانم سفارشم را پیگیری کنم؟</summary><p style="color:#C8C2C9;font-size:12px;margin:8px 0 0">پس از ثبت سفارش، کد رهگیری پیامک می‌شود.</p></details>
    <details><summary>آیا امکان بازگشت کالا وجود دارد؟</summary><p style="color:#C8C2C9;font-size:12px;margin:8px 0 0">بله، تا ۷ روز پس از تحویل.</p></details>
  </div>
</div>
<?php
  return ob_get_clean();
}
}

// Register final robust shortcodes
add_action('init', function(){
  add_shortcode('alookhor_cart_hero', 'alookhor_cc_cart_hero_shortcode_final');
  add_shortcode('alookhor_cart_products', 'alookhor_cc_cart_products_shortcode_final');
  add_shortcode('alookhor_cart_items', 'alookhor_cc_cart_products_shortcode_final');
  add_shortcode('alookhor_cart_summary', 'alookhor_cc_cart_summary_shortcode_final');
  add_shortcode('alookhor_cart_suggested', 'alookhor_cc_cart_suggested_shortcode_final');
  add_shortcode('alookhor_cart_features', 'alookhor_cc_cart_features_shortcode_final');
  add_shortcode('alookhor_cart_faq', 'alookhor_cc_cart_faq_shortcode_final');
  add_shortcode('alookhor_cart', function(){ return function_exists('alookhor_cc_cart_markup')?alookhor_cc_cart_markup():'<div>سبد خالی</div>'; });
  add_shortcode('alookhor_cart_full', function(){ return function_exists('alookhor_cc_cart_markup')?alookhor_cc_cart_markup():'<div>سبد خالی</div>'; });
  // Test shortcode
  add_shortcode('alookhor_cart_test', function(){ return '<div style="padding:20px;background:#1C1024;color:#E8B84A;border:2px solid #D49A2E;border-radius:12px;text-align:center">✅ شورت‌کد کار می‌کند! ALOOKHOR Cart Test OK</div>'; });
}, 5);

// Ensure cart CSS loaded on all pages for Elementor preview
add_action('wp_enqueue_scripts', function(){
  // Load on cart, checkout, and Elementor preview
  $load = false;
  if(function_exists('is_cart') && is_cart()) $load=true;
  if(function_exists('is_checkout') && is_checkout()) $load=true;
  if(isset($_GET['elementor_library']) || isset($_GET['elementor'])) $load=true;
  if(defined('ELEMENTOR_VERSION')) $load=true;
  if($load){
    wp_enqueue_style('alookhor-cc-cart', ALOOKHOR_CC_URL.'assets/css/frontend-cart.css', [], defined('ALOOKHOR_CC_BUILD')?ALOOKHOR_CC_BUILD:time());
  }
}, 20);
