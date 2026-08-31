<?php
/** Luxury single-product page — real WooCommerce data, premium RTL PDP. */
if(!defined('ABSPATH'))exit;

function alookhor_cc_pdp_icon($name){
 $p=[
  'star'=>'<path d="m12 3 2.7 5.7 6.3.8-4.6 4.3 1.2 6.2L12 17l-5.6 3 1.2-6.2L3 9.5l6.3-.8L12 3Z"/>',
  'star_half'=>'<path d="m12 3 2.7 5.7 6.3.8-4.6 4.3 1.2 6.2L12 17l-5.6 3 1.2-6.2L3 9.5l6.3-.8L12 3Z"/><path d="M12 3v14" stroke-width="2.4"/>',
  'heart'=>'<path d="M12 20s-7-4.5-9-9c-1.2-2.8.6-6 3.7-6C9 5 10.8 6.5 12 8c1.2-1.5 3-3 5.3-3 3.1 0 4.9 3.2 3.7 6-2 4.5-9 9-9 9Z"/>',
  'share'=>'<path d="M12 3v13"/><path d="m7 8 5-5 5 5"/><path d="M5 13v6a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2v-6"/>',
  'truck'=>'<path d="M3 6h11v10H3zM14 9h4l3 3v4h-7z"/><circle cx="7" cy="18" r="1.8"/><circle cx="17.5" cy="18" r="1.8"/>',
  'box'=>'<path d="m12 3 8 4.5v9L12 21l-8-4.5v-9L12 3Z"/><path d="M4 7.5 12 12l8-4.5M12 12v9"/>',
  'shield'=>'<path d="M12 3 5 6v5c0 4.5 3 8.5 7 10 4-1.5 7-5.5 7-10V6l-7-3Z"/><path d="m9 12 2 2 4-4"/>',
  'chat'=>'<path d="M21 12a8 8 0 0 1-8 8H4l2-3a8 8 0 1 1 15-5Z"/><path d="M9 11h6M9 14h4"/>',
  'pin'=>'<path d="M20 10c0 6-8 12-8 12S4 16 4 10a8 8 0 1 1 16 0Z"/><circle cx="12" cy="10" r="2.5"/>',
  'check'=>'<path d="m5 13 4 4L19 7"/>',
  'plus'=>'<path d="M12 5v14M5 12h14"/>',
  'minus'=>'<path d="M5 12h14"/>',
  'chev'=>'<path d="m6 9 6 6 6-6"/>',
  'zoom'=>'<circle cx="11" cy="11" r="7"/><path d="m21 21-4.5-4.5M8 11h6M11 8v6"/>',
  'expand'=>'<path d="M4 9V4h5M20 15v5h-5M15 4h5v5M9 20H4v-5"/>',
  'gift'=>'<path d="M4 11h16v10H4zM4 7h16v4H4zM12 7v14"/><path d="M12 7C10 7 7.5 6 7.5 4.5S9 3 9.8 3.6C10.8 4.3 12 7 12 7Zm0 0c2 0 4.5-1 4.5-2.5S15 3 14.2 3.6C13.2 4.3 12 7 12 7Z"/>',
  'card'=>'<rect x="3" y="6" width="18" height="13" rx="2"/><path d="M3 10h18M7 15h4"/>',
  'globe'=>'<circle cx="12" cy="12" r="9"/><path d="M3 12h18M12 3c2.5 2.5 4 5.5 4 9s-1.5 6.5-4 9c-2.5-2.5-4-5.5-4-9s1.5-6.5 4-9Z"/>',
  'leaf'=>'<path d="M5 19C5 9 11 4 21 3c0 10-5 16-15 16Z"/><path d="M5 19c3-5 7-8 11-10"/>',
  'gem'=>'<path d="M7 3h10l4 6-9 12L3 9l4-6Z"/><path d="M3 9h18M9.5 9 12 21 14.5 9 12 3 9.5 9Z"/>',
  'sprout'=>'<path d="M12 21v-8"/><path d="M12 13c0-4-3-6-8-6 0 5 3 7 8 6Z"/><path d="M12 13c0-4 3-6 8-6 0 5-3 7-8 6Z"/>',
  'sun'=>'<circle cx="12" cy="12" r="4"/><path d="M12 2v3M12 19v3M2 12h3M19 12h3M4.5 4.5l2.1 2.1M17.4 17.4l2.1 2.1M19.5 4.5l-2.1 2.1M6.6 17.4l-2.1 2.1"/>',
  'camera'=>'<path d="M4 8h3l2-3h6l2 3h3v12H4z"/><circle cx="12" cy="13" r="3.5"/>',
  'wallet'=>'<path d="M3 7h18v12H3z"/><path d="M3 7V5a2 2 0 0 1 2-2h12"/><circle cx="17" cy="13" r="1.4"/>',
  'sort'=>'<path d="M4 7h16M6 12h12M9 17h6"/>',
  'bag'=>'<path d="M6 8h12l-1 13H7L6 8Zm3 0V6a3 3 0 0 1 6 0v2"/>',
 ];
 return '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">'.($p[$name]??$p['star']).'</svg>';
}

function alookhor_cc_pdp_gold($text){return function_exists('alookhor_cc_goldify')?alookhor_cc_goldify($text):esc_html($text);}

/** @return WC_Product|null */
function alookhor_cc_pdp_product($slug=''){
 if(!function_exists('wc_get_product'))return null;
 if($slug){$post=get_page_by_path(sanitize_title($slug),OBJECT,'product');if($post)return wc_get_product($post->ID);}
 if(function_exists('is_product')&&is_product()){$p=wc_get_product((int)get_queried_object_id());if($p)return $p;}
 $posts=get_posts(['post_type'=>'product','post_status'=>'publish','numberposts'=>1,'orderby'=>'date','order'=>'DESC','fields'=>'ids']);
 return $posts?wc_get_product((int)$posts[0]):null;
}

function alookhor_cc_pdp_data($product){
 $img=ALOOKHOR_CC_URL.'assets/images/';
 $id=$product->get_id();
 $cats=[];
 $first_cat=['name'=>'','link'=>''];
 if(function_exists('wc_get_product_terms')){$terms=wc_get_product_terms($id,'product_cat');foreach($terms as $t){if($t&&!in_array($t->name,$cats,true))$cats[]=$t->name;}
  foreach($terms as $t){if($t&&!is_wp_error(get_term_link($t))){$first_cat=['name'=>$t->name,'link'=>(string)get_term_link($t)];break;}}}
 $main_id=(int)$product->get_image_id();
 $main=$main_id?wp_get_attachment_image_url($main_id,'woocommerce_single'):'';
 if(!$main)$main=$img.'category-plums.jpg';
 $gallery=[];
 foreach((array)$product->get_gallery_image_ids() as $gid){$u=wp_get_attachment_image_url((int)$gid,'woocommerce_single');if($u)$gallery[]=['src'=>$u,'label'=>'نمای نزدیک'];}
 $brand_shots=[['src'=>$img.'export-banner-bg.jpg','label'=>'مزرعه آلو'],['src'=>$img.'category-nuts.jpg','label'=>'آماده‌سازی و بسته‌بندی']];
 $slides=array_merge([['src'=>$main,'label'=>'محصول']],$gallery,$brand_shots);
 $regular=(float)$product->get_regular_price();$price=(float)$product->get_price();
 $discount=($regular>0&&$price>0&&$price<$regular)?(int)round((1-$price/$regular)*100):0;
 $weight=$product->get_weight();
 $options=[];
 if($product->is_type('variable')){
  foreach($product->get_available_variations() as $v){if(empty($v['variation_is_active']))continue;$options[]=['id'=>(int)$v['variation_id'],'label'=>implode(' / ',array_filter(array_map('trim',array_values((array)($v['attributes']??[]))))),'price_html'=>wp_strip_all_tags((string)($v['price_html']??''))];}
 }
 if(!$options)$options[]=['id'=>0,'label'=>$weight?wc_format_weight((float)$weight):'بستهٔ استاندارد','price_html'=>''];
 $related=[];
 if(function_exists('wc_get_related_products')){$related=wc_get_related_products($id,8);}
 if(count($related)<4&&function_exists('wc_get_products')){
  $fill=wc_get_products(['status'=>'publish','limit'=>8,'exclude'=>[$id],'orderby'=>'rand']);
  foreach($fill as $f){if(count($related)>=6)break;if(!in_array((int)$f->get_id(),$related,true))$related[]=(int)$f->get_id();}
 }
 $related=array_slice($related,0,6);
 $faqs=[
  ['q'=>'آیا امکان خرید عمده وجود دارد؟','a'=>'بله؛ سفارش‌های عمده و صادراتی مسیر اختصاصی آلوخور را دارند و از بخش «خرید عمده و صادرات» همین صفحه قابل ثبت است.'],
  ['q'=>'شرایط نگهداری محصول چگونه است؟','a'=>'محصول را در جای خشک و خنک، دور از نور مستقیم و در بستهٔ بسته‌شده نگه دارید؛ شرایط دقیق هر محموله روی بسته‌بندی درج می‌شود.'],
  ['q'=>'آیا امکان ارسال خارج از کشور وجود دارد؟','a'=>'بله؛ ارسال صادراتی به کشورهای مختلف انجام می‌شود. برای جزئیات، از بخش «عمده و صادرات» درخواست خود را ثبت کنید.'],
  ['q'=>'آیا این محصول هسته دارد؟','a'=>'برای اطلاعات دقیق همین محموله (هسته‌دار یا بی‌هسته)، با پشتیبانی آلوخور در ارتباط باشید تا اطلاعات روز محصول را دریافت کنید.'],
 ];
 $stock='out';
 if($product->is_in_stock())$stock=$product->managing_stock()&&$product->get_stock_quantity()!==''&&(int)$product->get_stock_quantity()>0&&(int)$product->get_stock_quantity()<=5?'low':'in';
 $dried=false;foreach($cats as $c){if(mb_strpos($c,'خشک')!==false||mb_strpos($c,'برگه')!==false)$dried=true;}
 $specs=[
  ['نوع محصول',$cats[0]??'اطلاعات محصول'],
  ['وزن',$weight?wc_format_weight((float)$weight):'اطلاعات محصول'],
  ['منطقه تولید','زبرخان (خور)، خراسان'],
  ['استان','خراسان رضوی'],
  ['کشور','ایران'],
  ['نوع فرآوری',$dried?'خشک‌شده':'اطلاعات محصول'],
  ['بسته‌بندی','اطلاعات محصول'],
  ['شرایط نگهداری','اطلاعات محصول'],
  ['ماندگاری','اطلاعات محصول'],
 ];
 $highlights=[
  ['leaf','محصول منتخب','دستهٔ '.($cats[0]??'خشکبار آلوخور')],
  ['pin','زبرخان، خراسان رضوی','منشأ مشخص محصول'],
  ['box','بسته‌بندی استاندارد','مناسب مصرف و ارسال'],
  ['globe','تولید ایران','از باغ تا بستهٔ آلوخور'],
  ['bag','سفارش عمده','امکان تأمین حجم بالا'],
 ];
 $journey=[['ایران','سرزمین آلو و خشکبار'],['خراسان رضوی','قلب تولید آلو'],['زبرخان','باغ‌های آلوخور'],['تولیدکننده','انتخاب و آماده‌سازی'],['آلوخور','بسته‌بندی و ارسال']];
 $quality=[['sprout','انتخاب محصول','برداشت از باغ‌های منتخب'],['gem','کنترل کیفیت','بررسی دستی و انتخاب'],['sort','آماده‌سازی','پاک‌سازی و فرآوری'],['box','بسته‌بندی','بستهٔ نهایی آلوخور']];
 return [
  'id'=>$id,'name'=>$product->get_name(),'sku'=>$product->get_sku()?:'—',
  'price_html'=>$product->get_price_html()?$product->get_price_html():wc_price($price),
  'regular'=>$regular,'price'=>$price,'discount'=>$discount,'on_sale'=>$product->is_on_sale(),
  'in_stock'=>$product->is_in_stock(),'stock'=>$stock,
  'rating'=>(float)$product->get_average_rating(),'reviews'=>(int)$product->get_review_count(),
  'rating_counts'=>[5=>(int)$product->get_rating_count(5),4=>(int)$product->get_rating_count(4),3=>(int)$product->get_rating_count(3),2=>(int)$product->get_rating_count(2),1=>(int)$product->get_rating_count(1)],
  'short'=>$product->get_short_description()?:'','desc'=>$product->get_description()?:'',
  'cats'=>$cats,'first_cat'=>$first_cat,'slides'=>$slides,'options'=>$options,'related'=>$related,
  'add_url'=>$product->add_to_cart_url(),'purchasable'=>$product->is_purchasable(),
  'faqs'=>$faqs,'specs'=>$specs,'highlights'=>$highlights,'journey'=>$journey,'quality'=>$quality,
 ];
}

function alookhor_cc_pdp_card($pid,$quick=true){
 $p=function_exists('wc_get_product')?wc_get_product((int)$pid):null;if(!$p)return '';
 $u=wp_get_attachment_image_url((int)$p->get_image_id(),'woocommerce_thumbnail');
 $u=$u?:ALOOKHOR_CC_URL.'assets/images/category-plums.jpg';
 $r=(float)$p->get_average_rating();$rc=(int)$p->get_review_count();
 $out='<article class="alp-card"><a class="alp-card-img" href="'.esc_url(get_permalink($p->get_id())).'"><img src="'.esc_url($u).'" alt="'.esc_attr($p->get_name()).'" loading="lazy"></a><div class="alp-card-body"><h3><a href="'.esc_url(get_permalink($p->get_id())).'">'.esc_html($p->get_name()).'</a></h3>';
 if($rc>0)$out.='<span class="alp-card-rate">'.alookhor_cc_pdp_icon('star').number_format_i18n($r,1).' <small>('.number_format_i18n($rc).' دیدگاه)</small></span>';
 $out.='<span class="alp-card-price">'.wp_kses_post($p->get_price_html()).'</span>';
 if($quick&&$p->is_purchasable())$out.='<a class="alp-card-add" href="'.esc_url($p->add_to_cart_url()).'">'.alookhor_cc_pdp_icon('bag').'<span>افزودن سریع</span></a>';
 $out.='</div></article>';
 return $out;
}

function alookhor_cc_pdp_markup(){
 $product=alookhor_cc_pdp_product();if(!$product)return '';
 $d=alookhor_cc_pdp_data($product);
 $header=function_exists('alookhor_cc_front_header_settings')?alookhor_cc_front_header_settings():[];
 $gold=(string)($header['gold']??'');if(!preg_match('/^#[0-9a-fA-F]{6}$/',$gold))$gold='#D4AF37';
 $img=ALOOKHOR_CC_URL.'assets/images/';
 $about=function_exists('alookhor_cc_about_url')?alookhor_cc_about_url():home_url('/about/');
 $contact=function_exists('alookhor_cc_contact_url')?alookhor_cc_contact_url():home_url('/تماس-با-ما/');
 $shop=function_exists('wc_get_page_permalink')?wc_get_page_permalink('shop'):home_url('/');
 $cart=function_exists('wc_get_cart_url')?wc_get_cart_url():home_url('/cart/');
 $wa='';$phone=preg_replace('/\D+/','',(string)($header['whatsapp_number']??''));if($phone)$wa='https://wa.me/'.$phone;
 $main_slide=$d['slides'][0];
 ob_start();?>
<section id="alookhor-pdp" class="alookhor-alp" dir="rtl" data-cart="<?php echo esc_url($cart);?>" style="--alp-gold:<?php echo esc_attr($gold);?>">
 <div class="alp-inner">
  <nav class="alp-crumbs" aria-label="مسیر صفحه"><a href="<?php echo esc_url(home_url('/'));?>">خانه</a><i>/</i><a href="<?php echo esc_url($shop);?>">محصولات</a><?php if($d['first_cat']['name']):?><i>/</i><a href="<?php echo esc_url($d['first_cat']['link']);?>"><?php echo esc_html($d['first_cat']['name']);?></a><?php endif;?><i>/</i><span><?php echo esc_html($d['name']);?></span></nav>

  <div class="alp-hero">
   <figure class="alp-gallery" data-label="<?php echo esc_attr($main_slide['label']);?>">
    <div class="alp-stage">
     <img id="alpMain" src="<?php echo esc_url($main_slide['src']);?>" alt="<?php echo esc_attr($d['name']);?>">
     <span class="alp-badge-shot"><?php echo alookhor_cc_pdp_icon('camera');?><b><?php echo esc_html($main_slide['label']);?></b></span>
     <button type="button" class="alp-zoom" data-zoom aria-label="بزرگ‌نمایی تصویر"><?php echo alookhor_cc_pdp_icon('zoom');?></button>
     <button type="button" class="alp-full" data-zoom aria-label="نمایش تمام‌صفحه"><?php echo alookhor_cc_pdp_icon('expand');?></button>
     <?php if($d['discount']>0):?><span class="alp-off">٪<?php echo esc_html(number_format_i18n($d['discount']));?>−</span><?php endif;?>
    </div>
    <div class="alp-thumbs" role="tablist" aria-label="گالری تصاویر محصول"><?php foreach($d['slides'] as $si=>$s):?><button type="button" role="tab" class="<?php echo $si===0?'is-on':'';?>" data-src="<?php echo esc_url($s['src']);?>" data-label="<?php echo esc_attr($s['label']);?>" aria-label="<?php echo esc_attr($s['label']);?>"><img src="<?php echo esc_url($s['src']);?>" alt="<?php echo esc_attr($s['label']);?>" loading="lazy"></button><?php endforeach;?></div>
   </figure>

   <div class="alp-info">
    <span class="alp-brand">ALOOKHOR</span>
    <h1><?php echo alookhor_cc_pdp_gold($d['name']);?></h1>
    <?php if($d['short']):?><p class="alp-sub"><?php echo esc_html(wp_strip_all_tags($d['short']));?></p>
    <?php else:?><p class="alp-sub">انتخاب‌شده از محصولات آلوخور با بسته‌بندی مناسب مصرف و سفارش عمده</p><?php endif;?>

    <div class="alp-rate" id="alookhor-rate">
     <?php if($d['reviews']>0):?>
      <b><?php echo esc_html(number_format_i18n($d['rating'],1));?></b>
      <span class="alp-stars" aria-label="امتیاز <?php echo esc_attr(number_format_i18n($d['rating'],1));?> از ۵"><?php for($i=1;$i<=5;$i++)echo alookhor_cc_pdp_icon($i<=round($d['rating'])?'star':'star');?></span>
      <a href="#alookhor-reviews">بررسی‌های مشتریان (<?php echo esc_html(number_format_i18n($d['reviews']));?>)</a>
     <?php else:?>
      <span class="alp-stars alp-stars-off"><?php for($i=1;$i<=5;$i++)echo alookhor_cc_pdp_icon('star');?></span>
      <a href="#alookhor-reviews">هنوز امتیازی ثبت نشده — اولین دیدگاه را شما ثبت کنید</a>
     <?php endif;?>
    </div>

    <ul class="alp-chips"><?php foreach($d['highlights'] as $h):?><li><?php echo alookhor_cc_pdp_icon($h[0]);?><span><b><?php echo esc_html($h[1]);?></b><small><?php echo esc_html($h[2]);?></small></span></li><?php endforeach;?></ul>

    <div class="alp-pick">
     <span class="alp-pick-t">انتخاب وزن</span>
     <div class="alp-weights" role="radiogroup" aria-label="انتخاب وزن"><?php foreach($d['options'] as $oi=>$o):?><button type="button" role="radio" aria-checked="<?php echo $oi===0?'true':'false';?>" class="<?php echo $oi===0?'is-on':'';?>" data-vid="<?php echo esc_attr($o['id']);?>" data-price="<?php echo esc_attr($o['price_html']);?>"><?php echo esc_html($o['label']);?></button><?php endforeach;?></div>
     <small class="alp-pick-note">وزن و بسته‌بندی نهایی مطابق اطلاعات محصول در مرحله سفارش اعمال می‌شود.</small>
    </div>

    <div class="alp-price">
     <span class="alp-price-t">قیمت نهایی</span>
     <div class="alp-price-row">
      <b class="alp-price-now" data-single="<?php echo esc_attr(wp_strip_all_tags($d['price_html']));?>"><?php echo wp_kses_post($d['price_html']);?></b>
      <?php if($d['on_sale']&&$d['regular']>0&&$d['price']>0):?><s><?php echo wp_kses_post(wc_price($d['regular']));?></s><em class="alp-off-inline">٪<?php echo esc_html(number_format_i18n($d['discount']));?> تخفیف</em><?php endif;?>
     </div>
    </div>

    <p class="alp-stock alp-stock-<?php echo esc_attr($d['stock']);?>"><?php if($d['stock']==='in'):?><?php echo alookhor_cc_pdp_icon('check');?><b>موجود</b><span>آماده ارسال از آلوخور</span><?php elseif($d['stock']==='low'):?><?php echo alookhor_cc_pdp_icon('box');?><b>موجودی محدود</b><span>تعداد باقی‌مانده اندک است</span><?php else:?><?php echo alookhor_cc_pdp_icon('chat');?><b>ناموجود</b><span>برای زمان تأمین با پشتیبانی در ارتباط باشید</span><?php endif;?></p>

    <?php if($d['purchasable']&&$d['stock']!=='out'):?>
    <div class="alp-buy">
     <span class="alp-qty"><button type="button" data-q="-" aria-label="کاهش تعداد"><?php echo alookhor_cc_pdp_icon('minus');?></button><b id="alpQty">1</b><button type="button" data-q="+" aria-label="افزایش تعداد"><?php echo alookhor_cc_pdp_icon('plus');?></button></span>
     <label class="alp-qty-t">تعداد</label>
     <a class="alp-cta" id="alpAdd" href="<?php echo esc_url($d['add_url']);?>" data-base="<?php echo esc_url($d['add_url']);?>"><?php echo alookhor_cc_pdp_icon('bag');?><span>افزودن به سبد خرید</span></a>
    </div>
    <div class="alp-after">
     <button type="button" class="alp-mini" data-wish><?php echo alookhor_cc_pdp_icon('heart');?><span>افزودن به علاقه‌مندی</span></button>
     <button type="button" class="alp-mini" data-share data-name="<?php echo esc_attr($d['name']);?>" data-url="<?php echo esc_url(get_permalink($d['id']));?>"><?php echo alookhor_cc_pdp_icon('share');?><span>اشتراک‌گذاری</span></button>
    </div>
    <?php endif;?>

    <div class="alp-ship">
     <h2><?php echo alookhor_cc_pdp_icon('truck');?><span>ارسال و تحویل</span></h2>
     <ul>
      <li><i><?php echo alookhor_cc_pdp_icon('pin');?></i><span><b>ارسال به:</b> انتخاب شهر در مرحله سفارش</span></li>
      <li><i><?php echo alookhor_cc_pdp_icon('truck');?></i><span><b>زمان تحویل:</b> محاسبه بر اساس آدرس</span></li>
      <li><i><?php echo alookhor_cc_pdp_icon('box');?></i><span><b>هزینه ارسال:</b> محاسبه در مرحله سفارش</span></li>
     </ul>
     <a href="<?php echo esc_url($contact);?>">مشاهده جزئیات ارسال</a>
    </div>

    <ul class="alp-trust">
     <li><?php echo alookhor_cc_pdp_icon('shield');?><span>ضمانت سلامت فیزیکی</span></li>
     <li><?php echo alookhor_cc_pdp_icon('card');?><span>پرداخت امن</span></li>
     <li><?php echo alookhor_cc_pdp_icon('truck');?><span>ارسال مطمئن</span></li>
     <li><?php echo alookhor_cc_pdp_icon('chat');?><span>پشتیبانی آلوخور</span></li>
    </ul>
   </div>
  </div>

  <section class="alp-why">
   <h2>چرا این محصول؟</h2>
   <div class="alp-why-grid">
    <article><?php echo alookhor_cc_pdp_icon('gem');?><h3>کیفیت انتخاب‌شده</h3><p>محصول پس از بررسی دستی، برای بستهٔ آلوخور انتخاب می‌شود.</p></article>
    <article><?php echo alookhor_cc_pdp_icon('box');?><h3>بسته‌بندی حرفه‌ای</h3><p>مناسب مصرف خانگی، مهمانی و ارسال هدیه.</p></article>
    <article><?php echo alookhor_cc_pdp_icon('pin');?><h3>منشأ مشخص</h3><p>از باغ‌های آلو در زبرخان، خراسان رضوی.</p></article>
    <article><?php echo alookhor_cc_pdp_icon('sun');?><h3>مناسب مصرف خانگی</h3><p>گزینه‌ای مطمئن برای میوهٔ خشک خانه و مهمان‌نوازی.</p></article>
    <article><?php echo alookhor_cc_pdp_icon('globe');?><h3>مناسب سفارش عمده</h3><p>امکان تأمین حجم بالا برای مغازه و صادرات.</p></article>
   </div>
  </section>
 </div>

 <section class="alp-band alp-origin">
  <div class="alp-inner">
   <header><span class="alp-kicker">منشأ محصول</span><h2>از باغ تا بسته <?php echo esc_html('آلوخور');?></h2></header>
   <ol class="alp-path"><?php foreach($d['journey'] as $ji=>$j):?><li><b><?php echo esc_html($j[0]);?></b><span><?php echo esc_html($j[1]);?></span><?php if($ji<count($d['journey'])-1):?><i aria-hidden="true">↓</i><?php endif;?></li><?php endforeach;?></ol>
   <figure class="alp-origin-img"><img src="<?php echo esc_url($img.'export-banner-bg.jpg');?>" alt="باغ آلو در خراسان" loading="lazy"></figure>
  </div>
 </section>

 <div class="alp-inner">
  <section class="alp-story">
   <figure><img src="<?php echo esc_url($img.'category-plums.jpg');?>" alt="آلو خشک آلوخور" loading="lazy"><figcaption><?php echo alookhor_cc_pdp_icon('leaf');?><span>۱۰۰٪ طبیعی</span></figcaption></figure>
   <div>
    <span class="alp-kicker">داستان این محصول</span>
    <h2>مسیر یک آلو، از باغ تا سفرهٔ شما</h2>
    <p>این محصول از باغ‌های آلو در زبرخان خراسان برداشت و پس از انتخاب، آماده‌سازی و بسته‌بندی در آلوخور، برای مصرف خانگی و سفارش‌های عمده آماده می‌شود؛ همان مسیری که آلوخور برای همهٔ محصولاتش قدم به قدم رعایت می‌کند.</p>
    <div class="alp-story-ctas"><a class="alp-btn" href="<?php echo esc_url($about);?>">مشاهده داستان کامل</a></div>
   </div>
  </section>

  <section class="alp-quality">
   <header><span class="alp-kicker">کیفیت</span><h2>انتخاب کیفیت، از اولین مرحله</h2></header>
   <div class="alp-quality-grid"><?php foreach($d['quality'] as $qi=>$q):?><article style="background-image:url('<?php echo esc_url($img.['category-plums.jpg','category-nuts.jpg','category-fruit-sheets.jpg','export-banner-bg.jpg'][$qi]);?>')"><span>۰<?php echo esc_html(number_format_i18n($qi+1));?></span><i><?php echo alookhor_cc_pdp_icon($q[0]);?></i><h3><?php echo esc_html($q[1]);?></h3><p><?php echo esc_html($q[2]);?></p></article><?php endforeach;?></div>
  </section>

  <div class="alp-cols">
   <section class="alp-specs">
    <h2>مشخصات محصول</h2>
    <table><tbody><?php foreach($d['specs'] as $si=>$s):?><tr class="<?php echo $si%2?'':'is-alt';?>"><th><?php echo esc_html($s[0]);?></th><td><?php echo esc_html($s[1]);?></td></tr><?php endforeach;?></tbody></table>
   </section>
   <section class="alp-desc">
    <h2>معرفی محصول</h2>
    <?php if(trim(wp_strip_all_tags($d['desc']))||trim(wp_strip_all_tags($d['short']))):?><p><?php echo esc_html(wp_trim_words(wp_strip_all_tags($d['short']?:$d['desc']),40,'…'));?></p>
     <?php if(trim(wp_strip_all_tags($d['desc']))):?><div class="alp-acc" data-acc><button type="button" class="alp-acc-t" data-acc-t>ادامه معرفی محصول <?php echo alookhor_cc_pdp_icon('chev');?></button><div class="alp-acc-b"><?php echo wp_kses_post(wpautop($d['desc']));?></div></div><?php endif;?>
    <?php else:?><p>معرفی کامل این محصول به‌زودی تکمیل می‌شود؛ برای پرسش دقیق، با پشتیبانی آلوخور در ارتباط باشید.</p><a class="alp-btn alp-btn-ghost" href="<?php echo esc_url($contact);?>">پرسش از پشتیبانی</a><?php endif;?>
   </section>
  </div>

  <div class="alp-cols2">
   <div class="alp-acc" data-acc><button type="button" class="alp-acc-t is-open" data-acc-t><?php echo alookhor_cc_pdp_icon('truck');?><b>روش‌های ارسال</b><?php echo alookhor_cc_pdp_icon('chev');?></button><div class="alp-acc-b is-open"><ul class="alp-mini-list"><li><span>اطلاعات ارسال</span><small>پس از ثبت آدرس در مرحله سفارش</small></li><li><span>هزینه ارسال</span><small>محاسبه در مرحله سفارش</small></li><li><span>زمان تحویل</span><small>بر اساس شهر و آدرس گیرنده</small></li></ul></div></div>
   <div class="alp-acc" data-acc><button type="button" class="alp-acc-t" data-acc-t><?php echo alookhor_cc_pdp_icon('share');?><b>شرایط بازگشت</b><?php echo alookhor_cc_pdp_icon('chev');?></button><div class="alp-acc-b"><ul class="alp-mini-list"><li><span>سلامت کالا</span><small>بستهٔ رسیده را هنگام تحویل بررسی کنید</small></li><li><span>بازگشت</span><small>برای موارد دارای مشکل، با پشتیبانی در ارتباط باشید</small></li><li><span>پیگیری سفارش</span><small>از طریق تماس و واتساپ آلوخور</small></li></ul></div></div>
  </div>

  <section class="alp-gift">
   <figure><img src="<?php echo esc_url($img.'footer-prunes.png');?>" alt="بستهٔ هدیه آلوخور" loading="lazy"></figure>
   <div>
    <h2>این محصول را هدیه می‌خرید؟</h2>
    <p>گزینه‌های هدیه را در همین صفحه انتخاب کنید؛ درخواست شما همراه سفارش ثبت می‌شود.</p>
    <ul class="alp-gift-opts">
     <li><button type="button" class="alp-opt" data-opt><?php echo alookhor_cc_pdp_icon('gift');?><span>بسته‌بندی هدیه</span><i></i></button></li>
     <li><button type="button" class="alp-opt" data-opt><?php echo alookhor_cc_pdp_icon('card');?><span>کارت تبریک</span><i></i></button></li>
     <li><button type="button" class="alp-opt" data-opt><?php echo alookhor_cc_pdp_icon('truck');?><span>ارسال مستقیم برای گیرنده</span><i></i></button></li>
    </ul>
   </div>
  </section>
 </div>

 <section class="alp-band alp-wholesale">
  <div class="alp-inner">
   <header><span class="alp-kicker">ALOOKHOR EXPORT</span><h2>خرید عمده و صادرات</h2><p>تأمین مستقیم محصولات آلوخور برای سفارش‌های عمده</p></header>
   <ul class="alp-volume"><li>۱۰ کیلو</li><li>۵۰ کیلو</li><li>۱۰۰ کیلو</li><li>سفارش صادراتی</li></ul>
   <div class="alp-ctas"><a class="alp-btn alp-btn-gold" href="<?php echo esc_url($contact);?>">درخواست قیمت عمده</a><?php if($wa):?><a class="alp-btn alp-btn-line" href="<?php echo esc_url($wa);?>" target="_blank" rel="noopener">مشاوره صادرات</a><?php endif;?></div>
  </div>
 </section>

 <div class="alp-inner">
  <section class="alp-qa">
   <h2>پرسش‌های کاربران</h2>
   <?php foreach($d['faqs'] as $f):?><div class="alp-acc" data-acc><button type="button" class="alp-acc-t" data-acc-t><?php echo esc_html($f['q']);?><?php echo alookhor_cc_pdp_icon('chev');?></button><div class="alp-acc-b"><p><?php echo esc_html($f['a']);?></p></div></div><?php endforeach;?>
   <a class="alp-btn alp-btn-ghost" href="<?php echo esc_url($contact);?>">ثبت پرسش</a>
  </section>

  <section class="alp-reviews" id="alookhor-reviews">
   <h2>دیدگاه مشتریان</h2>
   <?php if($d['reviews']>0):?>
    <div class="alp-rev-dash">
     <div class="alp-rev-score"><b><?php echo esc_html(number_format_i18n($d['rating'],1));?></b><span class="alp-stars"><?php for($i=1;$i<=5;$i++)echo alookhor_cc_pdp_icon('star');?></span><small>از <?php echo esc_html(number_format_i18n($d['reviews']));?> دیدگاه</small></div>
     <div class="alp-rev-cats"><?php foreach([5,4,3,2,1] as $star):$cnt=$d['rating_counts'][$star];$pct=$d['reviews']>0?(int)round($cnt/$d['reviews']*100):0;?><div class="alp-rev-cat"><span><?php echo esc_html(number_format_i18n($star));?> ستاره</span><i><b style="width:<?php echo esc_attr($pct);?>%"></b></i><small><?php echo esc_html(number_format_i18n($cnt));?></small></div><?php endforeach;?></div>
    </div>
   <?php else:?>
    <div class="alp-rev-empty"><?php echo alookhor_cc_pdp_icon('chat');?><p>هنوز دیدگاهی برای این محصول ثبت نشده است. اگر این محصول را خریده‌اید، تجربهٔ خود را بنویسید تا انتخاب دیگران دقیق‌تر شود.</p></div>
   <?php endif;?>
   <div class="alp-rev-form"><h3>ثبت دیدگاه</h3><?php comments_template();?></div>
  </section>

  <section class="alp-ugc">
   <h2>آلوخور از نگاه مشتریان</h2>
   <div class="alp-ugc-grid"><?php for($i=0;$i<4;$i++):?><span class="alp-ugc-ph"><?php echo alookhor_cc_pdp_icon('camera');?><small>جای تصویر شما</small></span><?php endfor;?></div>
   <p class="alp-ugc-note">تصاویر مشتریان پس از ثبت دیدگاه‌های تصویری، همین‌جا نمایش داده می‌شود.</p>
  </section>

  <?php if($d['related']):?>
  <section class="alp-rail-sec">
   <h2>محصولات مشابه</h2>
   <div class="alp-rail"><?php foreach($d['related'] as $rid)echo alookhor_cc_pdp_card($rid);?></div>
  </section>

  <section class="alp-bundle" data-cart="<?php echo esc_url($cart);?>">
   <h2>همراه این محصول پیشنهاد می‌شود</h2>
   <div class="alp-bundle-row">
    <?php $bundle=array_slice(array_merge([$d['id']],$d['related']),0,3);$ids=[];$total=0;foreach($bundle as $bi=>$bid):$bp=wc_get_product((int)$bid);if(!$bp)continue;$ids[]=$bid;$total+=(float)$bp->get_price();$bu=wp_get_attachment_image_url((int)$bp->get_image_id(),'woocommerce_thumbnail');$bu=$bu?:$img.'category-plums.jpg';?>
     <article class="alp-b-item" data-id="<?php echo esc_attr($bid);?>"><?php if($bi>0):?><b class="alp-plus">+</b><?php endif;?><img src="<?php echo esc_url($bu);?>" alt="<?php echo esc_attr($bp->get_name());?>" loading="lazy"><a href="<?php echo esc_url(get_permalink($bid));?>"><?php echo esc_html($bp->get_name());?></a><span><?php echo wp_kses_post($bp->get_price_html());?></span></article>
    <?php endforeach;?>
   </div>
   <div class="alp-bundle-foot"><span>مجموع پیشنهادی: <b><?php echo wp_kses_post(wc_price($total));?></b></span><button type="button" class="alp-btn alp-btn-gold" data-addall='<?php echo esc_attr(json_encode($ids));?>'>افزودن همه به سبد</button></div>
  </section>
  <?php endif;?>

  <section class="alp-viewed" id="alpViewed" hidden><h2>اخیراً مشاهده کرده‌اید</h2><div class="alp-rail" id="alpViewedRail"></div></section>
 </div>

 <section class="alp-band alp-brandband">
  <div class="alp-inner">
   <figure><img src="<?php echo esc_url($img.'export-banner-bg.jpg');?>" alt="باغ آلو خراسان" loading="lazy"></figure>
   <div><span class="alp-kicker">ALOOKHOR</span><h2>آلوخور؛ پایتخت آلو ایران</h2><p>از باغ‌های آلو زبرخان تا بستهٔ نهایی، آلوخور همان مسیر را با وسواس طی می‌کند: انتخاب، کنترل، بسته‌بندی و ارسال مطمئن.</p><a class="alp-btn alp-btn-gold" href="<?php echo esc_url($about);?>">درباره آلوخور</a></div>
  </div>
 </section>

 <div class="alp-lb" data-lb hidden><button type="button" data-lb-close aria-label="بستن">✕</button><img src="<?php echo esc_url($main_slide['src']);?>" alt="<?php echo esc_attr($d['name']);?>"></div>
</section>
<div class="alp-sticky" data-name="<?php echo esc_attr($d['name']);?>"><span class="alp-sticky-p"><?php echo wp_kses_post($d['price_html']);?></span><?php if($d['purchasable']&&$d['stock']!=='out'):$sticky_base=$d['add_url'];?><a href="<?php echo esc_url($sticky_base);?>" data-base="<?php echo esc_attr($sticky_base);?>" class="alp-cta"><?php echo alookhor_cc_pdp_icon('bag');?><span>افزودن به سبد</span></a><?php endif;?></div>
<script type="application/ld+json"><?php echo wp_json_encode(['@context'=>'https://schema.org','@type'=>'Product','name'=>$d['name'],'image'=>$main_slide['src'],'sku'=>$d['sku'],'offers'=>['@type'=>'Offer','price'=>$d['price'],'priceCurrency'=>(function_exists('get_woocommerce_currency')?get_woocommerce_currency():'IRR'),'availability'=>'https://schema.org/'.($d['in_stock']?'InStock':'OutOfStock')],'brand'=>['@type'=>'Brand','name'=>'ALOOKHOR']]);?></script>
<?php return ob_get_clean();
}

add_filter('template_include',function($template){
 if(!function_exists('is_product')||!is_product()||!function_exists('wc_get_product'))return $template;
 return ALOOKHOR_CC_DIR.'templates/single-product.php';
},999);

add_filter('body_class',function($classes){
 if(function_exists('is_product')&&is_product())$classes[]='alookhor-pdp-body';
 return $classes;
});

add_action('wp_enqueue_scripts',function(){
 if(!function_exists('is_product')||!is_product())return;
 wp_enqueue_style('alookhor-cc-pdp',ALOOKHOR_CC_URL.'assets/css/frontend-product.css',[],ALOOKHOR_CC_BUILD);
 wp_enqueue_script('alookhor-cc-pdp',ALOOKHOR_CC_URL.'assets/js/frontend-product.js',[],ALOOKHOR_CC_BUILD,true);
});
