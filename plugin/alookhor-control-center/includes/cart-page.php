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


// ===== v3.10.366 — ELEMENTOR SHORTCODES FOR CART PAGE BUILDER =====
if(!function_exists('alookhor_cc_cart_hero_shortcode')){
function alookhor_cc_cart_hero_shortcode(){
 $d=function_exists('alookhor_cc_cart_data_fallback')?alookhor_cc_cart_data_fallback():alookhor_cc_cart_data(); if(!$d) return '';
 $img=ALOOKHOR_CC_URL.'assets/images/';
 ob_start();
?>
<div id="alookhor-cart-hero" dir="rtl">
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
</div>
<?php
 return ob_get_clean();
}
add_shortcode('alookhor_cart_hero','alookhor_cc_cart_hero_shortcode');
}

if(!function_exists('alookhor_cc_cart_products_shortcode')){
function alookhor_cc_cart_products_shortcode(){
 $d=function_exists('alookhor_cc_cart_data_fallback')?alookhor_cc_cart_data_fallback():alookhor_cc_cart_data(); if(!$d) return '<div class="alookhor-cart-empty">سبد خرید خالی است</div>';
 $fmt=$d['fmt']; $fa_th=$d['fa_th']; $img=ALOOKHOR_CC_URL.'assets/images/'; ob_start();
?>
<div id="alookhor-cart-products" dir="rtl">
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
</div>
<?php
 return ob_get_clean();
}
add_shortcode('alookhor_cart_products','alookhor_cc_cart_products_shortcode');
add_shortcode('alookhor_cart_items','alookhor_cc_cart_products_shortcode');
}

if(!function_exists('alookhor_cc_cart_summary_shortcode')){
function alookhor_cc_cart_summary_shortcode(){
 $d=function_exists('alookhor_cc_cart_data_fallback')?alookhor_cc_cart_data_fallback():alookhor_cc_cart_data(); if(!$d) return '';
 $fmt=$d['fmt']; ob_start();
?>
<div id="alookhor-cart-summary" dir="rtl">
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
<?php
 return ob_get_clean();
}
add_shortcode('alookhor_cart_summary','alookhor_cc_cart_summary_shortcode');
}

if(!function_exists('alookhor_cc_cart_suggested_shortcode')){
function alookhor_cc_cart_suggested_shortcode(){
 $d=function_exists('alookhor_cc_cart_data_fallback')?alookhor_cc_cart_data_fallback():alookhor_cc_cart_data(); if(!$d) return '';
 $fmt=$d['fmt']; $img=ALOOKHOR_CC_URL.'assets/images/'; ob_start();
?>
<div id="alookhor-cart-suggested" dir="rtl">
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
</div>
<?php
 return ob_get_clean();
}
add_shortcode('alookhor_cart_suggested','alookhor_cc_cart_suggested_shortcode');
}

if(!function_exists('alookhor_cc_cart_features_shortcode')){
function alookhor_cc_cart_features_shortcode(){
 ob_start();
?>
<div id="alookhor-cart-features" dir="rtl">
  <div class="features">
    <div class="feature"><span class="icon"><span><?php echo alookhor_cc_cart_icon('truck');?></span></span><div>ارسال سریع<br><small>تحویل فوری</small></div></div>
    <div class="feature"><span class="icon"><span><?php echo alookhor_cc_cart_icon('shield');?></span></span><div>ضمانت اصالت کالا<br><small>تضمین کیفیت و اصالت</small></div></div>
    <div class="feature"><span class="icon"><span><?php echo alookhor_cc_cart_icon('return');?></span></span><div>ضمانت بازگشت کالا<br><small>۷ روز بدون قید و شرط</small></div></div>
    <div class="feature"><span class="icon"><span><?php echo alookhor_cc_cart_icon('headset');?></span></span><div>پشتیبانی ۲۴ ساعته<br><small>همیشه پاسخگوی شما هستیم</small></div></div>
  </div>
</div>
<?php
 return ob_get_clean();
}
add_shortcode('alookhor_cart_features','alookhor_cc_cart_features_shortcode');
}

if(!function_exists('alookhor_cc_cart_faq_shortcode')){
function alookhor_cc_cart_faq_shortcode(){
 ob_start();
?>
<div id="alookhor-cart-faq" dir="rtl">
  <div class="faq">
    <h3><span>؟</span> سوالات متداول</h3>
    <details><summary>هزینه ارسال سفارشم چقدر است؟<span><?php echo alookhor_cc_cart_icon('chevr');?></span></summary><p>هزینه ارسال بر اساس وزن و مقصد محاسبه می‌شود و در خلاصه سفارش نمایش داده می‌شود. ارسال رایگان برای سفارش‌های بالای ۵۰۰ هزار تومان.</p></details>
    <details><summary>چطور می‌توانم سفارشم را دستم برسانم؟<span><?php echo alookhor_cc_cart_icon('chevr');?></span></summary><p>پس از ثبت سفارش، کد رهگیری برای شما پیامک می‌شود و می‌توانید وضعیت را در حساب کاربری پیگیری کنید.</p></details>
    <details><summary>آیا امکان بازگشت کالا وجود دارد؟<span><?php echo alookhor_cc_cart_icon('chevr');?></span></summary><p>بله، تا ۷ روز پس از تحویل امکان بازگشت کالا در صورت عدم رضایت وجود دارد.</p></details>
  </div>
</div>
<?php
 return ob_get_clean();
}
add_shortcode('alookhor_cart_faq','alookhor_cc_cart_faq_shortcode');
}

if(!function_exists('alookhor_cc_cart_full_shortcode')){
function alookhor_cc_cart_full_shortcode(){ return alookhor_cc_cart_markup(); }
add_shortcode('alookhor_cart','alookhor_cc_cart_full_shortcode');
add_shortcode('alookhor_cart_full','alookhor_cc_cart_full_shortcode');
}

// ===== v3.10.367 — FIX SHORTCODE REGISTRATION FOR ELEMENTOR =====
add_action('init', function(){
  // Ensure all cart shortcodes are registered on init for Elementor
  if(function_exists('alookhor_cc_cart_hero_shortcode')) add_shortcode('alookhor_cart_hero','alookhor_cc_cart_hero_shortcode');
  if(function_exists('alookhor_cc_cart_products_shortcode')) {
    add_shortcode('alookhor_cart_products','alookhor_cc_cart_products_shortcode');
    add_shortcode('alookhor_cart_items','alookhor_cc_cart_products_shortcode');
  }
  if(function_exists('alookhor_cc_cart_summary_shortcode')) add_shortcode('alookhor_cart_summary','alookhor_cc_cart_summary_shortcode');
  if(function_exists('alookhor_cc_cart_suggested_shortcode')) add_shortcode('alookhor_cart_suggested','alookhor_cc_cart_suggested_shortcode');
  if(function_exists('alookhor_cc_cart_features_shortcode')) add_shortcode('alookhor_cart_features','alookhor_cc_cart_features_shortcode');
  if(function_exists('alookhor_cc_cart_faq_shortcode')) add_shortcode('alookhor_cart_faq','alookhor_cc_cart_faq_shortcode');
  if(function_exists('alookhor_cc_cart_full_shortcode')) {
    add_shortcode('alookhor_cart','alookhor_cc_cart_full_shortcode');
    add_shortcode('alookhor_cart_full','alookhor_cc_cart_full_shortcode');
  }
  // Also ensure woocommerce_cart override
  if(function_exists('alookhor_cc_cart_markup')){
    if(shortcode_exists('woocommerce_cart')) remove_shortcode('woocommerce_cart');
    add_shortcode('woocommerce_cart', function(){ return alookhor_cc_cart_markup(); });
  }
}, 20);

// Fix cart data to return dummy in Elementor preview when WC cart not available
if(!function_exists('alookhor_cc_cart_data_fallback')){
function alookhor_cc_cart_data_fallback(){
  $is_elementor = (isset($_GET['elementor_library']) || isset($_POST['action']) && $_POST['action']==='elementor_ajax' || (defined('ELEMENTOR_VERSION')) && (\Elementor\Plugin::$instance->editor->is_edit_mode() ?? false));
  // Try real cart first
  $real = null;
  if(function_exists('WC') && WC() && WC()->cart){
    $real = alookhor_cc_cart_data();
    if($real && !empty($real['items'])) return $real;
  }
  // If in Elementor or cart empty, return dummy for preview
  if($is_elementor || (isset($_GET['action']) && $_GET['action']==='elementor') || (defined('DOING_AJAX') && DOING_AJAX)){
    $fmt = function($a){ return number_format((float)$a,0,'.',','); };
    $fa_th = function($n){ return (string)$n; };
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
      'shop'=>wc_get_page_permalink('shop') ?: home_url('/shop/'),
      'checkout'=>wc_get_checkout_url() ?: home_url('/checkout/'),
      'cart_url'=>wc_get_cart_url() ?: home_url('/cart/'),
    ];
  }
  return $real;
}
}

// Override shortcodes to use fallback data for Elementor preview
if(!function_exists('alookhor_cc_cart_hero_shortcode_v2')){
function alookhor_cc_cart_hero_shortcode_v2(){
  // Always return hero even without cart data
  $img=ALOOKHOR_CC_URL.'assets/images/';
  ob_start();
?>
<div id="alookhor-cart-hero" dir="rtl">
  <div class="cart-hero">
    <img src="<?php echo esc_url($img.'bowl.jpg');?>" alt="" class="cart-hero-bg">
    <div class="cart-hero-content">
      <div class="cart-hero-left">
        <img src="<?php echo esc_url($img.'bowl.jpg');?>" alt="کاسه آلو">
        <div>
          <div class="breadcrumb"><a href="<?php echo esc_url(home_url('/'));?>">خانه</a><span>›</span><span>سبد خرید</span></div>
          <h1><span><?php echo function_exists('alookhor_cc_cart_icon')?alookhor_cc_cart_icon('cart'):'';?></span> سبد خرید شما</h1>
          <p>محصولات منتخب شما در یک نگاه و با اطمینان خرید کنید</p>
        </div>
      </div>
      <div class="cart-hero-tagline"><span><?php echo function_exists('alookhor_cc_cart_icon')?alookhor_cc_cart_icon('leaf'):'';?></span> طعم اصالت از دل طبیعت ایران</div>
    </div>
  </div>
</div>
<?php
  return ob_get_clean();
}
add_shortcode('alookhor_cart_hero','alookhor_cc_cart_hero_shortcode_v2');
}

