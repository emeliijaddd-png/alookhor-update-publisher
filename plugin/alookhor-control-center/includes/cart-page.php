<?php
/** ALOOKHOR CART — v3.10.265: exact per Screenshot 2026-09-06 101216.png — luxury cart page with summary, products, suggestions, features, FAQ */
if(!defined('ABSPATH'))exit;

if(!function_exists('alookhor_cc_cart_icon')){
function alookhor_cc_cart_icon($name){
 $p=[
  'cart'=>'<path d="M6 6h15l-1.5 9h-13z"/><path d="M6 6L5 2H2"/><circle cx="9" cy="20" r="1.5"/><circle cx="18" cy="20" r="1.5"/>',
  'heart'=>'<path d="M19 14c1.49-1.46 3-3.21 3-5.5A5.5 5.5 0 0 0 16.5 3c-1.76 0-3 .5-4.5 2-1.5-1.5-2.74-2-4.5-2A5.5 5.5 0 0 0 2 8.5c0 2.3 1.5 4.05 3 5.5l7 7Z"/>',
  'trash'=>'<path d="M3 6h18"/><path d="M8 6V4h8v2"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6"/><path d="M10 11v6"/><path d="M14 11v6"/>',
  'share'=>'<circle cx="18" cy="5" r="2.5"/><circle cx="6" cy="12" r="2.5"/><circle cx="18" cy="19" r="2.5"/><path d="m8.2 10.8 7.6-4.5"/><path d="m8.2 13.2 7.6 4.5"/>',
  'compare'=>'<path d="M7 7h10"/><path d="M7 12h10"/><path d="M7 17h10"/><path d="M12 7l-3-3 3-3"/><path d="M12 17l3 3-3 3"/>',
  'plus'=>'<path d="M12 5v14"/><path d="M5 12h14"/>',
  'minus'=>'<path d="M5 12h14"/>',
  'chevr'=>'<path d="m9 18 6-6-6-6"/>',
  'chevl'=>'<path d="m15 18-6-6 6-6"/>',
  'arrowl'=>'<path d="M19 12H5"/><path d="M12 19l-7-7 7-7"/>',
  'leaf'=>'<path d="M12 2C7 2 3 6 3 11c0 5 4 9 9 9s9-4 9-9c0-5-4-9-9-9Z"/><path d="M12 2c0 0-3 3-3 7s3 7 3 7"/>',
  'truck'=>'<path d="M1 3h15v13H1z"/><path d="M16 8h4l3 6v3h-7V8z"/><circle cx="5.5" cy="18.5" r="2.5"/><circle cx="18.5" cy="18.5" r="2.5"/>',
  'shield'=>'<path d="M12 2L3 6v6c0 5 4 9 9 10 5-1 9-5 9-10V6l-9-4Z"/><path d="M9 12l2 2 4-4"/>',
  'return'=>'<path d="M3 7v6h6"/><path d="M21 17a9 9 0 0 0-9-9 9 9 0 0 0-6 2.3L3 13"/>',
  'headset'=>'<path d="M3 18v-6a9 9 0 0 1 18 0v6"/><path d="M21 19a2 2 0 0 1-2 2h-1a2 2 0 0 1-2-2v-3a2 2 0 0 1 2-2h3z"/><path d="M3 19a2 2 0 0 0 2 2h1a2 2 0 0 0 2-2v-3a2 2 0 0 0-2-2H3z"/>',
  'bag'=>'<path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"/><path d="M3 6h18"/><path d="M16 10a4 4 0 0 1-8 0"/>',
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
 // Fallback totals if empty
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
?>
<div id="alookhor-cart" class="alookhor-alp app-bg min-h-screen" dir="rtl">
  <!-- HERO BANNER -->
  <div class="cart-hero relative overflow-hidden rounded-2xl border border-white/10 bg-plum-900/60 p-4 mb-6">
    <img src="<?php echo esc_url($img.'bowl.jpg');?>" alt="آلو خشک" class="absolute inset-0 h-full w-full object-cover opacity-20">
    <div class="relative flex items-center justify-between gap-4">
      <div class="flex items-center gap-3">
        <img src="<?php echo esc_url($img.'bowl.jpg');?>" alt="کاسه آلو" class="h-16 w-16 rounded-xl object-cover border border-white/10">
        <div>
          <div class="flex items-center gap-2 text-xs text-lav"><a href="<?php echo esc_url(home_url('/'));?>" class="hover:text-gold-300">خانه</a><span>›</span><span>سبد خرید</span></div>
          <h1 class="mt-1 flex items-center gap-2 text-xl font-black text-cream sm:text-2xl"><span class="h-6 w-6 text-gold-400"><?php echo alookhor_cc_cart_icon('cart');?></span> سبد خرید شما</h1>
          <p class="mt-1 text-xs text-lav">محصولات منتخب شما در یک نگاه و با اطمینان خرید کنید</p>
        </div>
      </div>
      <div class="hidden sm:flex items-center gap-2 text-xs font-bold text-gold-300"><span class="h-4 w-4"><?php echo alookhor_cc_cart_icon('leaf');?></span> طعم اصالت از دل طبیعت ایران</div>
    </div>
  </div>

  <div class="cart-main-grid grid gap-6 lg:grid-cols-[1fr_360px]">
    <!-- PRODUCTS LIST (right side in RTL) -->
    <div class="cart-products">
      <div class="cart-products-box rounded-2xl border border-white/10 bg-plum-900/50 backdrop-blur-sm overflow-hidden">
        <div class="hidden sm:grid grid-cols-[2fr_1fr_1fr_1fr_1fr_80px] gap-2 border-b border-white/10 bg-plum-950/50 px-4 py-3 text-[11px] font-bold text-lav">
          <span>محصول</span><span>وزن / بسته‌بندی</span><span>قیمت واحد</span><span>تعداد</span><span>مبلغ کل</span><span>عملیات</span>
        </div>
        <div class="divide-y divide-white/5">
          <?php foreach($d['items'] as $it):?>
          <div class="cart-item grid gap-3 px-4 py-4 sm:grid-cols-[2fr_1fr_1fr_1fr_1fr_80px] sm:items-center">
            <div class="flex items-center gap-3">
              <img src="<?php echo esc_url($it['img']);?>" alt="<?php echo esc_attr($it['name']);?>" class="h-16 w-16 rounded-xl object-cover border border-white/10">
              <div>
                <a href="<?php echo esc_url($it['permalink']);?>" class="block text-sm font-bold text-cream hover:text-gold-300"><?php echo esc_html($it['name']);?></a>
                <span class="mt-1 inline-flex rounded bg-gold-400/20 px-2 py-0.5 text-[10px] font-bold text-gold-300">بیشتر</span>
              </div>
            </div>
            <div>
              <select class="w-full rounded-lg border border-white/10 bg-plum-950/70 px-2 py-1.5 text-xs text-cream">
                <option><?php echo esc_html($it['weight']);?></option>
                <option>۲۵۰ گرم</option>
                <option>۵۰۰ گرم</option>
                <option>۱ کیلوگرم</option>
              </select>
            </div>
            <div class="text-xs font-bold text-cream"><span class="sm:hidden text-lav">قیمت: </span><?php echo $fmt($it['price']);?> تومان</div>
            <div class="flex items-center gap-1">
              <div class="flex items-center gap-1 rounded-full border border-white/10 bg-plum-950/70 p-1">
                <button type="button" data-cart-qty="+" data-key="<?php echo esc_attr($it['key']);?>" class="grid h-6 w-6 place-items-center rounded-full text-cream hover:bg-white/10"><span class="h-3 w-3"><?php echo alookhor_cc_cart_icon('plus');?></span></button>
                <span class="w-6 text-center text-xs font-black text-cream"><?php echo $fa_th($it['qty']);?></span>
                <button type="button" data-cart-qty="-" data-key="<?php echo esc_attr($it['key']);?>" class="grid h-6 w-6 place-items-center rounded-full text-cream hover:bg-white/10"><span class="h-3 w-3"><?php echo alookhor_cc_cart_icon('minus');?></span></button>
              </div>
            </div>
            <div class="text-xs font-black text-gold-300"><span class="sm:hidden text-lav">جمع: </span><?php echo $fmt($it['subtotal']);?> تومان</div>
            <div class="flex items-center gap-1.5">
              <button type="button" class="grid h-8 w-8 place-items-center rounded-lg border border-white/10 bg-plum-950/50 text-lav hover:text-berry" data-wishlist><span class="h-4 w-4"><?php echo alookhor_cc_cart_icon('heart');?></span></button>
              <button type="button" class="grid h-8 w-8 place-items-center rounded-lg border border-white/10 bg-plum-950/50 text-lav hover:text-red-400" data-cart-remove="<?php echo esc_attr($it['key']);?>"><span class="h-4 w-4"><?php echo alookhor_cc_cart_icon('trash');?></span></button>
            </div>
          </div>
          <?php endforeach;?>
          <?php if(empty($d['items'])):?>
          <div class="p-8 text-center text-lav">سبد خرید شما خالی است — <a href="<?php echo esc_url($d['shop']);?>" class="text-gold-300 underline">رفتن به فروشگاه</a></div>
          <?php endif;?>
        </div>
        <div class="flex flex-wrap items-center justify-between gap-3 border-t border-white/10 bg-plum-950/30 px-4 py-3">
          <a href="<?php echo esc_url($d['shop']);?>" class="inline-flex items-center gap-1.5 rounded-xl border border-white/10 bg-plum-900/60 px-4 py-2 text-xs font-bold text-cream hover:border-gold-400/40"><span class="h-4 w-4"><?php echo alookhor_cc_cart_icon('arrowl');?></span> ادامه خرید</a>
          <button type="button" class="inline-flex items-center gap-1.5 text-xs font-bold text-gold-300 hover:text-gold-200"><span class="h-4 w-4"><?php echo alookhor_cc_cart_icon('share');?></span> سبد خرید را به اشتراک بگذارید</button>
        </div>
      </div>

      <!-- SUGGESTED COMPLETE PURCHASE -->
      <div class="mt-6 rounded-2xl border border-white/10 bg-plum-900/40 p-4">
        <h2 class="flex items-center gap-2 text-sm font-black text-cream"><span class="h-5 w-5 text-gold-400"><?php echo alookhor_cc_cart_icon('cart');?></span> پیشنهاد تکمیل خرید <span class="text-xs font-normal text-lav">این محصولات را هم امتحان کنید</span></h2>
        <div class="mt-4 grid grid-cols-2 gap-3 sm:grid-cols-4">
          <?php
          $related_ids = [];
          if(!empty($d['items'])){
            $first_pid = $d['items'][0]['id'];
            $prod = wc_get_product($first_pid);
            if($prod){
              $related_ids = wc_get_related_products($first_pid, 4);
            }
          }
          if(empty($related_ids)){
            $related_ids = wc_get_products(['limit'=>4,'return'=>'ids','status'=>'publish']);
          }
          foreach(array_slice($related_ids,0,4) as $rid){
            $rp = wc_get_product($rid); if(!$rp)continue;
            $ru = wp_get_attachment_image_url($rp->get_image_id(),'woocommerce_thumbnail');
            $ru = $ru ?: $img.'bowl.jpg';
            $rprice = (float)$rp->get_price();
            $rname = $rp->get_name(); if(mb_strpos($rname,'سامسونگ')!==false)continue;
          ?>
          <div class="group rounded-xl border border-white/10 bg-plum-950/60 overflow-hidden hover:border-gold-400/30 transition">
            <div class="relative aspect-square overflow-hidden bg-plum-900">
              <img src="<?php echo esc_url($ru);?>" alt="<?php echo esc_attr($rname);?>" class="h-full w-full object-cover group-hover:scale-105 transition duration-300">
              <span class="absolute top-2 left-2 grid h-6 w-6 place-items-center rounded-full bg-plum-950/70 text-cream border border-white/10"><span class="h-3 w-3"><?php echo alookhor_cc_cart_icon('heart');?></span></span>
              <span class="absolute top-2 right-2 rounded bg-[#e42a68] px-2 py-0.5 text-[9px] font-black text-white">۱۰٪ تخفیف</span>
            </div>
            <div class="p-2.5">
              <span class="block text-[11px] font-bold text-cream line-clamp-1"><?php echo esc_html($rname);?></span>
              <span class="mt-1 block text-[11px] font-black text-gold-300"><?php echo $fmt($rprice);?> تومان</span>
              <button type="button" class="mt-2 flex w-full items-center justify-center gap-1 rounded-lg bg-gold-400 py-1.5 text-[11px] font-black text-plum-950 hover:brightness-110"><span class="h-3 w-3"><?php echo alookhor_cc_cart_icon('cart');?></span> افزودن</button>
            </div>
          </div>
          <?php } ?>
        </div>
      </div>

      <!-- FEATURES + FAQ -->
      <div class="mt-6 grid gap-6">
        <div class="grid grid-cols-2 gap-3 rounded-2xl border border-white/10 bg-plum-900/30 p-3 sm:grid-cols-4">
          <div class="flex items-center gap-2 text-[11px] font-bold text-lav"><span class="grid h-8 w-8 place-items-center rounded-full bg-plum-950/70 text-gold-400 border border-white/10"><span class="h-4 w-4"><?php echo alookhor_cc_cart_icon('truck');?></span></span> ارسال سریع<br><small class="text-[9px] text-lav/60">تحویل فوری</small></div>
          <div class="flex items-center gap-2 text-[11px] font-bold text-lav"><span class="grid h-8 w-8 place-items-center rounded-full bg-plum-950/70 text-gold-400 border border-white/10"><span class="h-4 w-4"><?php echo alookhor_cc_cart_icon('shield');?></span></span> ضمانت اصالت کالا<br><small class="text-[9px] text-lav/60">تضمین کیفیت و اصالت</small></div>
          <div class="flex items-center gap-2 text-[11px] font-bold text-lav"><span class="grid h-8 w-8 place-items-center rounded-full bg-plum-950/70 text-gold-400 border border-white/10"><span class="h-4 w-4"><?php echo alookhor_cc_cart_icon('return');?></span></span> ضمانت بازگشت کالا<br><small class="text-[9px] text-lav/60">۷ روز بدون قید و شرط</small></div>
          <div class="flex items-center gap-2 text-[11px] font-bold text-lav"><span class="grid h-8 w-8 place-items-center rounded-full bg-plum-950/70 text-gold-400 border border-white/10"><span class="h-4 w-4"><?php echo alookhor_cc_cart_icon('headset');?></span></span> پشتیبانی ۲۴ ساعته<br><small class="text-[9px] text-lav/60">همیشه پاسخگوی شما هستیم</small></div>
        </div>
        <div class="rounded-2xl border border-white/10 bg-plum-900/30 p-4">
          <h3 class="flex items-center gap-2 text-sm font-black text-cream"><span class="h-4 w-4 text-gold-400">؟</span> سوالات متداول</h3>
          <div class="mt-3 divide-y divide-white/5">
            <details class="py-2"><summary class="flex cursor-pointer items-center justify-between text-xs font-bold text-cream">هزینه ارسال سفارشم چقدر است؟<span class="h-4 w-4 text-lav"><?php echo alookhor_cc_cart_icon('chevr');?></span></summary><p class="mt-2 text-[11px] text-lav">هزینه ارسال بر اساس وزن و مقصد محاسبه می‌شود و در خلاصه سفارش نمایش داده می‌شود. ارسال رایگان برای سفارش‌های بالای ۵۰۰ هزار تومان.</p></details>
            <details class="py-2"><summary class="flex cursor-pointer items-center justify-between text-xs font-bold text-cream">چطور می‌توانم سفارشم را دستم برسانم؟<span class="h-4 w-4 text-lav"><?php echo alookhor_cc_cart_icon('chevr');?></span></summary><p class="mt-2 text-[11px] text-lav">پس از ثبت سفارش، کد رهگیری برای شما پیامک می‌شود و می‌توانید وضعیت را در حساب کاربری پیگیری کنید.</p></details>
            <details class="py-2"><summary class="flex cursor-pointer items-center justify-between text-xs font-bold text-cream">آیا امکان بازگشت کالا وجود دارد؟<span class="h-4 w-4 text-lav"><?php echo alookhor_cc_cart_icon('chevr');?></span></summary><p class="mt-2 text-[11px] text-lav">بله، تا ۷ روز پس از تحویل امکان بازگشت کالا در صورت عدم رضایت وجود دارد.</p></details>
          </div>
        </div>
      </div>
    </div>

    <!-- SUMMARY SIDEBAR (left side in RTL) -->
    <div class="cart-summary">
      <div class="rounded-2xl border border-white/10 bg-plum-900/60 backdrop-blur-sm p-4 sticky top-4">
        <h2 class="flex items-center gap-2 text-sm font-black text-cream"><span class="h-5 w-5 rounded bg-gold-400/20 text-gold-300 grid place-items-center">≡</span> خلاصه سفارش</h2>
        <div class="mt-4 space-y-2.5 text-xs">
          <div class="flex justify-between"><span class="text-lav">جمع مبلغ کالاها</span><span class="font-bold text-cream"><?php echo $fmt($d['subtotal']);?> تومان</span></div>
          <div class="flex justify-between"><span class="text-lav">تخفیف</span><span class="font-bold text-mint"><?php echo $fmt($d['discount']);?> تومان</span></div>
          <div class="flex justify-between"><span class="text-lav">هزینه ارسال</span><span class="font-bold text-mint">رایگان</span></div>
          <div class="my-3 h-px bg-white/10"></div>
          <div class="flex justify-between text-sm"><span class="font-bold text-cream">مبلغ قابل پرداخت</span><span class="font-black text-gold-300"><?php echo $fmt($d['total']);?> تومان</span></div>
        </div>
        <a href="<?php echo esc_url($d['checkout']);?>" class="mt-4 flex w-full items-center justify-center gap-2 rounded-xl bg-gradient-to-l from-gold-300 to-gold-500 py-3 text-sm font-black text-plum-950 shadow-[0_10px_30px_-10px_rgba(247,179,43,0.6)] hover:brightness-110"><span>ادامه و ثبت سفارش</span><span class="h-4 w-4"><?php echo alookhor_cc_cart_icon('arrowl');?></span></a>

        <div class="mt-5 rounded-xl border border-white/10 bg-plum-950/50 p-3">
          <span class="flex items-center gap-1.5 text-xs font-bold text-cream"><span class="h-4 w-4 text-gold-400">٪</span> کد تخفیف دارید؟</span>
          <div class="mt-2 flex gap-2">
            <input type="text" placeholder="کد تخفیف را وارد کنید ..." class="flex-1 rounded-lg border border-white/10 bg-plum-900/60 px-3 py-2 text-xs text-cream placeholder:text-lav/50">
            <button type="button" class="rounded-lg border border-white/10 bg-plum-900/80 px-4 py-2 text-xs font-black text-cream hover:border-gold-400/40">اعمال</button>
          </div>
        </div>

        <div class="mt-4 flex items-center gap-2 rounded-xl border border-white/10 bg-plum-950/40 p-3 text-xs">
          <span class="grid h-8 w-8 place-items-center rounded-full bg-plum-900/70 text-gold-400 border border-white/10"><span class="h-4 w-4"><?php echo alookhor_cc_cart_icon('truck');?></span></span>
          <div><span class="block font-bold text-cream">ارسال به سراسر کشور</span><span class="block text-[11px] text-lav/70">تحویل سریع و مطمئن در کمترین زمان</span></div>
        </div>
      </div>
    </div>
  </div>
</div>

<script>
document.addEventListener('DOMContentLoaded',function(){
  // qty +/- for cart
  document.querySelectorAll('[data-cart-qty]').forEach(function(btn){
    btn.addEventListener('click',function(){
      var key=this.getAttribute('data-key');
      var dir=this.getAttribute('data-cart-qty');
      var input=this.parentElement.querySelector('span');
      var cur=parseInt(input.textContent.replace(/[^0-9]/g,''))||1;
      if(dir==='+')cur=Math.min(99,cur+1); else cur=Math.max(1,cur-1);
      // update via wc-ajax
      fetch('<?php echo esc_url(home_url('/?wc-ajax=update_cart'));?>',{method:'POST',headers:{'Content-Type':'application/x-www-form-urlencoded'},body:'cart['+encodeURIComponent(key)+'][qty]='+cur})
        .then(()=>location.reload());
    });
  });
  document.querySelectorAll('[data-cart-remove]').forEach(function(btn){
    btn.addEventListener('click',function(){
      var key=this.getAttribute('data-cart-remove');
      fetch('<?php echo esc_url(home_url('/?wc-ajax=remove_from_cart'));?>',{method:'POST',headers:{'Content-Type':'application/x-www-form-urlencoded'},body:'cart_key='+encodeURIComponent(key)})
        .then(()=>location.reload());
    });
  });
});
</script>
<?php
 return ob_get_clean();
}
}

// Template override for is_cart
add_filter('template_include',function($template){
 if(function_exists('is_cart')&&is_cart()){
  if(file_exists(ALOOKHOR_CC_DIR.'templates/cart.php')) return ALOOKHOR_CC_DIR.'templates/cart.php';
 }
 return $template;
},PHP_INT_MAX);

add_action('wp_enqueue_scripts',function(){
 if(function_exists('is_cart')&&is_cart()){
  wp_enqueue_style('alookhor-cc-cart',ALOOKHOR_CC_URL.'assets/css/frontend-cart.css',[],ALOOKHOR_CC_BUILD);
  wp_enqueue_script('alookhor-cc-cart',ALOOKHOR_CC_URL.'assets/js/frontend-cart.js',[],ALOOKHOR_CC_BUILD,true);
 }
});

// woocommerce_locate_template override removed - use template_include only for is_cart

// Override WooCommerce cart shortcode to use our luxury markup
add_action('init',function(){
 if(function_exists('is_cart')){
  // Remove default shortcode and add ours
  if(shortcode_exists('woocommerce_cart')){
   remove_shortcode('woocommerce_cart');
  }
  add_shortcode('woocommerce_cart',function(){
   return alookhor_cc_cart_markup();
  });
 }
},20);
