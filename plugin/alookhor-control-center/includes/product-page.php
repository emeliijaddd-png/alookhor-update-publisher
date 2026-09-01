<?php
/** Luxury glass PDP — v3.10.188: definitive render at template_redirect (+ exit) with template_include fallback; real WooCommerce data only. */
if(!defined('ABSPATH'))exit;

function alookhor_cc_pdp_icon($name){
 $p=[
  'star'=>'<path d="m12 3 2.7 5.7 6.3.8-4.6 4.3 1.2 6.2L12 17l-5.6 3 1.2-6.2L3 9.5l6.3-.8L12 3Z"/>',
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
  'card'=>'<rect x="3" y="6" width="18" height="13" rx="2"/><path d="M3 10h18M7 15h4"/>',
  'globe'=>'<circle cx="12" cy="12" r="9"/><path d="M3 12h18M12 3c2.5 2.5 4 5.5 4 9s-1.5 6.5-4 9c-2.5-2.5-4-5.5-4-9s1.5-6.5 4-9Z"/>',
  'leaf'=>'<path d="M5 19C5 9 11 4 21 3c0 10-5 16-15 16Z"/><path d="M5 19c3-5 7-8 11-10"/>',
  'gem'=>'<path d="M7 3h10l4 6-9 12L3 9l4-6Z"/><path d="M3 9h18M9.5 9 12 21 14.5 9 12 3 9.5 9Z"/>',
  'sort'=>'<path d="M4 7h16M6 12h12M9 17h6"/>',
  'sun'=>'<circle cx="12" cy="12" r="4"/><path d="M12 2v3M12 19v3M2 12h3M19 12h3M4.5 4.5l2.1 2.1M17.4 17.4l2.1 2.1M19.5 4.5l-2.1 2.1M6.6 17.4l-2.1 2.1"/>',
  'camera'=>'<path d="M4 8h3l2-3h6l2 3h3v12H4z"/><circle cx="12" cy="13" r="3.5"/>',
  'phone'=>'<path d="M6.6 2.8 9.4 2c.6-.2 1.2.1 1.4.7L12 5.9c.2.5 0 1-.4 1.3L10 8.4c.9 1.9 2.5 3.5 4.4 4.4l1.2-1.6c.3-.4.8-.6 1.3-.4l3.2 1.2c.6.2.9.8.7 1.4l-.8 2.8c-.2.6-.7 1-1.4 1C10 17.2 4.8 11.9 4.8 4.2c0-.7.4-1.2 1.1-1.4Z"/>',
  'bag'=>'<path d="M6 8h12l-1 13H7L6 8Zm3 0V6a3 3 0 0 1 6 0v2"/>',
  'sprout'=>'<path d="M12 21v-8"/><path d="M12 13c0-4-3-6-8-6 0 5 3 7 8 6Z"/><path d="M12 13c0-4 3-6 8-6 0 5-3 7-8 6Z"/>',
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
 $cats=[];$first_cat=['name'=>'','link'=>''];
 if(function_exists('wc_get_product_terms')){
  $terms=wc_get_product_terms($id,'product_cat');
  foreach($terms as $t){if($t&&!in_array($t->name,$cats,true))$cats[]=$t->name;}
  foreach($terms as $t){if($t&&!is_wp_error(get_term_link($t))){$first_cat=['name'=>$t->name,'link'=>(string)get_term_link($t)];break;}}
 }
 $main_id=(int)$product->get_image_id();
 $main=$main_id?wp_get_attachment_image_url($main_id,'woocommerce_single'):'';
 if(!$main)$main=$img.'category-plums.jpg';
 $gallery=[];
 foreach((array)$product->get_gallery_image_ids() as $gid){$u=wp_get_attachment_image_url((int)$gid,'woocommerce_single');if($u)$gallery[]=['src'=>$u,'label'=>'نمای نزدیک'];}
 $brand_shots=[['src'=>$img.'export-banner-bg.jpg','label'=>'مزرعه آلو'],['src'=>$img.'category-nuts.jpg','label'=>'بسته‌بندی و فرآوری']];
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
 if(function_exists('wc_get_related_products'))$related=wc_get_related_products($id,8);
 if(count($related)<4&&function_exists('wc_get_products')){
  $fill=wc_get_products(['status'=>'publish','limit'=>8,'exclude'=>[$id],'orderby'=>'rand']);
  foreach($fill as $f){if(count($related)>=6)break;if(!in_array((int)$f->get_id(),$related,true))$related[]=(int)$f->get_id();}
 }
 $related=array_slice($related,0,6);
 $faqs=[
  ['q'=>'آلو بخارا چگونه نگهداری شود؟','a'=>'در جای خشک و خنک و دور از نور مستقیم نگه دارید و بسته را پس از هر بار مصرف ببندید؛ شرایط دقیق هر محموله روی بسته‌بندی درج شده است.'],
  ['q'=>'ارسال سفارش چقدر زمان می‌برد؟','a'=>'زمان تحویل بر اساس شهر و آدرس گیرنده در مرحله سفارش محاسبه و اعلام می‌شود؛ از ثبت سفارش تا تحویل، پیگیری از طریق پشتیبانی آلوخور امکان‌پذیر است.'],
  ['q'=>'آیا امکان خرید عمده وجود دارد؟','a'=>'بله؛ سفارش‌های ۱۰، ۵۰ و ۱۰۰ کیلویی و سفارش‌های صادراتی مسیر اختصاصی دارند. از بخش «خرید عمده و صادرات» همین صفحه درخواست قیمت ثبت کنید.'],
  ['q'=>'آیا محصولات مستقیماً از تولیدکننده تهیه می‌شوند؟','a'=>'بله؛ زنجیره آلوخور از باغ‌های آلو در زبرخان خراسان رضوی تا انتخاب، فرآوری و بسته‌بندی توسط خود برند مدیریت می‌شود.'],
  ['q'=>'آیا امکان ارسال خارج از کشور وجود دارد؟','a'=>'بله؛ ارسال صادراتی به کشورهای مختلف انجام می‌شود. برای شرایط و مدارک لازم، درخواست «مشاوره صادرات» را ثبت کنید.'],
 ];
 $stock='out';
 if($product->is_in_stock())$stock=$product->managing_stock()&&$product->get_stock_quantity()!==''&&(int)$product->get_stock_quantity()>0&&(int)$product->get_stock_quantity()<=5?'low':'in';
 $dried=false;foreach($cats as $c){if(mb_strpos($c,'خشک')!==false||mb_strpos($c,'برگه')!==false)$dried=true;}
 $specs=[
  ['نوع محصول',$first_cat['name']?:'آلو بخارا'],
  ['منطقه تولید','زبرخان (خور)، خراسان'],
  ['نوع بسته‌بندی','اطلاعات محصول'],
  ['وزن',$weight?wc_format_weight((float)$weight):'قابل انتخاب'],
  ['شرایط نگهداری','جای خشک و خنک، دور از نور مستقیم'],
  ['ماندگاری','مطابق اطلاعات روی بسته‌بندی'],
  ['کشور تولیدکننده','ایران'],
 ];
 $feats=[
  ['pin','منشأ مشخص: زبرخان خراسان'],
  ['sort','انتخاب و سورت‌شده'],
  ['box','بسته‌بندی بهداشتی'],
  ['sun','مناسب مصرف روزانه'],
  ['gem','مناسب هدیه'],
 ];
 $why=[
  ['sprout','مستقیم از تولیدکننده','بدون واسطه، از باغ‌های آلو خراسان'],
  ['shield','کنترل کیفیت','بررسی و انتخاب محصول پیش از بسته‌بندی'],
  ['box','بسته‌بندی حرفه‌ای','مناسب مصرف، هدیه و ارسال'],
  ['truck','ارسال مطمئن','به سراسر کشور و سفارش‌های صادراتی'],
 ];
 $reviews=[];
 if(function_exists('get_comments')&&class_exists('WC_Comments')){
  $cs=get_comments(['post_id'=>$id,'status'=>'approve','number'=>3]);
  foreach($cs as $cm){
   $r=(int)get_comment_meta($cm->comment_ID,'rating',true);
   if($r<1||$r>5)continue;
   $verified=get_comment_meta($cm->comment_ID,'verified',true)==='1';
   $reviews[]=['name'=>$cm->comment_author?:'مشتری آلوخور','date'=>date_i18n('j F Y',strtotime($cm->comment_date)),'rating'=>$r,'text'=>wp_strip_all_tags($cm->comment_content),'verified'=>$verified];
  }
 }
 return [
  'id'=>$id,'name'=>$product->get_name(),'sku'=>$product->get_sku()?:'—',
  'price_html'=>$product->get_price_html()?$product->get_price_html():wc_price($price),
  'regular'=>$regular,'price'=>$price,'discount'=>$discount,'on_sale'=>$product->is_on_sale(),
  'in_stock'=>$product->is_in_stock(),'stock'=>$stock,
  'rating'=>(float)$product->get_average_rating(),'reviews'=>(int)$product->get_review_count(),
  'rating_counts'=>[5=>(int)$product->get_rating_count(5),4=>(int)$product->get_rating_count(4),3=>(int)$product->get_rating_count(3),2=>(int)$product->get_rating_count(2),1=>(int)$product->get_rating_count(1)],
  'short'=>$product->get_short_description()?:'','cats'=>$cats,'first_cat'=>$first_cat,
  'slides'=>$slides,'options'=>$options,'related'=>$related,'reviews_list'=>$reviews,
  'add_url'=>$product->add_to_cart_url(),'purchasable'=>$product->is_purchasable(),'featured'=>$product->is_featured(),
  'faqs'=>$faqs,'specs'=>$specs,'feats'=>$feats,'why'=>$why,'dried'=>$dried,
 ];
}

function alookhor_cc_pdp_card($pid){
 $p=function_exists('wc_get_product')?wc_get_product((int)$pid):null;if(!$p)return '';
 $u=wp_get_attachment_image_url((int)$p->get_image_id(),'woocommerce_thumbnail');
 $u=$u?:ALOOKHOR_CC_URL.'assets/images/category-plums.jpg';
 $r=(float)$p->get_average_rating();$rc=(int)$p->get_review_count();
 $out='<article class="alp-card"><a class="alp-card-img" href="'.esc_url(get_permalink($p->get_id())).'"><img src="'.esc_url($u).'" alt="'.esc_attr($p->get_name()).'" loading="lazy"></a><div class="alp-card-body"><h3><a href="'.esc_url(get_permalink($p->get_id())).'">'.esc_html($p->get_name()).'</a></h3>';
 if($rc>0)$out.='<span class="alp-card-rate">'.alookhor_cc_pdp_icon('star').number_format_i18n($r,1).' <small>('.number_format_i18n($rc).' دیدگاه)</small></span>';
 $out.='<span class="alp-card-price">'.wp_kses_post($p->get_price_html()).'</span>';
 if($p->is_purchasable()&&$p->is_in_stock())$out.='<a class="alp-card-add" href="'.esc_url($p->add_to_cart_url()).'">'.alookhor_cc_pdp_icon('bag').'<span>افزودن به سبد</span></a>';
 $out.='</div></article>';
 return $out;
}

function alookhor_cc_pdp_markup(){
 if(!empty($GLOBALS['alookhor_cc_pdp_done']))return '';
 $product=alookhor_cc_pdp_product();if(!$product)return '';
 $d=alookhor_cc_pdp_data($product);
 $header=function_exists('alookhor_cc_front_header_settings')?alookhor_cc_front_header_settings():[];
 $gold=(string)($header['gold']??'');if(!preg_match('/^#[0-9a-fA-F]{6}$/',$gold))$gold='#D4AF37';
 $img=ALOOKHOR_CC_URL.'assets/images/';
 $about=function_exists('alookhor_cc_about_url')?alookhor_cc_about_url():home_url('/about/');
 $contact=function_exists('alookhor_cc_contact_url')?alookhor_cc_contact_url():home_url('/تماس-با-ما/');
 $shop=function_exists('wc_get_page_permalink')?wc_get_page_permalink('shop'):home_url('/');
 $cart=function_exists('wc_get_cart_url')?wc_get_cart_url():home_url('/cart/');
 $wa='';$wa_phone=preg_replace('/\D+/','',(string)($header['phone']??''));if($wa_phone)$wa='https://wa.me/'.$wa_phone;
 $main_slide=$d['slides'][0];
 $stars=function($n,$active=true){$o='';for($i=1;$i<=5;$i++)$o.=alookhor_cc_pdp_icon('star');return $o;};
 ob_start();?>
<section id="alookhor-pdp" class="alookhor-alp" dir="rtl" data-cart="<?php echo esc_url($cart);?>" style="--alp-gold:<?php echo esc_attr($gold);?>">
 <div class="alp-inner">
  <nav class="alp-crumbs" aria-label="مسیر صفحه"><a href="<?php echo esc_url(home_url('/'));?>">خانه</a><i>/</i><a href="<?php echo esc_url($shop);?>">محصولات</a><?php if($d['first_cat']['name']):?><i>/</i><a href="<?php echo esc_url($d['first_cat']['link']);?>"><?php echo esc_html($d['first_cat']['name']);?></a><?php endif;?><i>/</i><span><?php echo esc_html($d['name']);?></span></nav>

  <div class="alp-hero">
   <div class="alp-info">
    <?php if($d['first_cat']['name']):?><span class="alp-cat-badge"><?php echo alookhor_cc_pdp_icon('leaf');?><b><?php echo esc_html($d['first_cat']['name']);?></b></span><?php endif;?>
    <h1><?php echo alookhor_cc_pdp_gold($d['name']);?></h1>
    <div class="alp-rate">
     <?php if($d['reviews']>0):?>
      <span class="alp-stars"><?php echo $stars(5);?></span><b><?php echo esc_html(number_format_i18n($d['rating'],1));?></b>
      <a href="#alookhor-reviews"><?php echo esc_html(number_format_i18n($d['reviews']));?> دیدگاه</a>
     <?php else:?>
      <span class="alp-stars alp-stars-off"><?php echo $stars(5,false);?></span>
      <a href="#alookhor-reviews">اولین دیدگاه را شما ثبت کنید</a>
     <?php endif;?>
    </div>
    <p class="alp-sub"><?php if($d['short']):?><?php echo esc_html(wp_strip_all_tags($d['short']));?><?php else:?><?php echo esc_html($d['name']);?> از آلوهای منتخب خراسان تهیه و پس از انتخاب، فرآوری و کنترل کیفیت، با بسته‌بندی مناسب مصرف خانگی و هدیه عرضه می‌شود.<?php endif;?></p>
    <ul class="alp-feats"><?php foreach($d['feats'] as $f):?><li><?php echo alookhor_cc_pdp_icon('check');?><span><?php echo esc_html($f[1]);?></span></li><?php endforeach;?></ul>

    <div class="alp-price">
     <span class="alp-price-t">قیمت نهایی</span>
     <div class="alp-price-row">
      <b class="alp-price-now" data-single="<?php echo esc_attr(wp_strip_all_tags($d['price_html']));?>"><?php echo wp_kses_post($d['price_html']);?></b>
      <?php if($d['on_sale']&&$d['regular']>0&&$d['price']>0):?><s><?php echo wp_kses_post(wc_price($d['regular']));?></s><em class="alp-off-b">٪<?php echo esc_html(number_format_i18n($d['discount']));?> تخفیف</em><?php endif;?>
     </div>
     <small>هزینه ارسال در مرحله سفارش محاسبه می‌شود</small>
    </div>

    <div class="alp-pick">
     <span class="alp-pick-t">وزن محصول</span>
     <div class="alp-weights" role="radiogroup" aria-label="انتخاب وزن"><?php foreach($d['options'] as $oi=>$o):?><button type="button" role="radio" aria-checked="<?php echo $oi===0?'true':'false';?>" class="<?php echo $oi===0?'is-on':'';?>" data-vid="<?php echo esc_attr($o['id']);?>" data-price="<?php echo esc_attr($o['price_html']);?>"><?php echo esc_html($o['label']);?></button><?php endforeach;?></div>
    </div>

    <p class="alp-stock alp-stock-<?php echo esc_attr($d['stock']);?>"><?php if($d['stock']==='in'):?><i></i><b>موجود در انبار</b><span>آماده ارسال</span><?php elseif($d['stock']==='low'):?><i></i><b>موجودی محدود</b><span>تعداد باقی‌مانده اندک است</span><?php else:?><i></i><b>ناموجود</b><span>برای زمان تأمین با پشتیبانی در تماس باشید</span><?php endif;?></p>

    <?php if($d['purchasable']&&$d['stock']!=='out'):?>
    <div class="alp-buy">
     <span class="alp-qty"><button type="button" data-q="-" aria-label="کاهش تعداد"><?php echo alookhor_cc_pdp_icon('minus');?></button><b id="alpQty">1</b><button type="button" data-q="+" aria-label="افزایش تعداد"><?php echo alookhor_cc_pdp_icon('plus');?></button></span>
     <a class="alp-cta" id="alpAdd" href="<?php echo esc_url($d['add_url']);?>" data-base="<?php echo esc_attr($d['add_url']);?>"><?php echo alookhor_cc_pdp_icon('bag');?><span>افزودن به سبد خرید</span></a>
    </div>
    <button type="button" class="alp-mini" data-wish><?php echo alookhor_cc_pdp_icon('heart');?><span>افزودن به علاقه‌مندی‌ها</span></button>
    <p class="alp-assure"><?php echo alookhor_cc_pdp_icon('shield');?><span>خرید شما با ضمانت اصالت و سلامت محصول انجام می‌شود.</span></p>
    <?php endif;?>
   </div>

   <figure class="alp-gallery" data-label="<?php echo esc_attr($main_slide['label']);?>">
    <div class="alp-stage">
     <img id="alpMain" src="<?php echo esc_url($main_slide['src']);?>" alt="<?php echo esc_attr($d['name']);?>">
     <span class="alp-frame" aria-hidden="true"></span>
     <?php if($d['on_sale']):?><span class="alp-flag"><?php echo alookhor_cc_pdp_icon('gem');?><b>پیشنهاد ویژه</b></span><?php elseif($d['featured']):?><span class="alp-flag"><?php echo alookhor_cc_pdp_icon('star');?><b>محصول منتخب</b></span><?php endif;?>
     <?php if($d['discount']>0):?><span class="alp-off">٪<?php echo esc_html(number_format_i18n($d['discount']));?>−</span><?php endif;?>
     <span class="alp-badge-shot"><?php echo alookhor_cc_pdp_icon('camera');?><b><?php echo esc_html($main_slide['label']);?></b></span>
     <span class="alp-float">
      <button type="button" data-wish aria-label="افزودن به علاقه‌مندی"><?php echo alookhor_cc_pdp_icon('heart');?></button>
      <button type="button" data-zoom aria-label="مشاهده بزرگ‌تر"><?php echo alookhor_cc_pdp_icon('zoom');?></button>
     </span>
    </div>
    <div class="alp-thumbs" role="tablist" aria-label="گالری تصاویر محصول"><?php foreach($d['slides'] as $si=>$s):?><button type="button" role="tab" class="<?php echo $si===0?'is-on':'';?>" data-src="<?php echo esc_url($s['src']);?>" data-label="<?php echo esc_attr($s['label']);?>" aria-label="<?php echo esc_attr($s['label']);?>"><img src="<?php echo esc_url($s['src']);?>" alt="<?php echo esc_attr($s['label']);?>" loading="lazy"></button><?php endforeach;?></div>
    <figcaption class="alp-gal-cap"><span data-gal-label><?php echo esc_html($main_slide['label']);?></span></figcaption>
   </figure>
  </div>

  <ul class="alp-trust">
   <li><?php echo alookhor_cc_pdp_icon('truck');?><b>ارسال سریع</b><span>ارسال به سراسر کشور</span></li>
   <li><?php echo alookhor_cc_pdp_icon('shield');?><b>ضمانت کیفیت</b><span>تضمین کیفیت محصول</span></li>
   <li><?php echo alookhor_cc_pdp_icon('box');?><b>بسته‌بندی مطمئن</b><span>بسته‌بندی استاندارد</span></li>
   <li><?php echo alookhor_cc_pdp_icon('phone');?><b>پشتیبانی</b><span>پاسخ‌گویی قبل و بعد از خرید</span></li>
  </ul>

  <section class="alp-story">
   <div class="alp-story-body">
    <span class="alp-kicker">EDITORIAL</span>
    <h2>درباره <?php echo esc_html($d['name']);?></h2>
    <p>این محصول از باغ‌های آلو در زبرخانِ خراسان رضوی برداشت می‌شود؛ همان خاکی که آلوخور از آن آموخته است کیفیت آلو را اول از همه درخت تعیین می‌کند و بعد از آن، دقت در انتخاب و فرآوری.</p>
    <p>پس از برداشت، محصول سورت، آماده‌سازی و در بسته‌بندی بهداشتی بسته می‌شود؛ مناسب مصرف روزانهٔ خانواده، مهمان‌نوازی و هدیه — و در حجم‌های بزرگ‌تر، آمادهٔ سفارش عمده و صادرات.</p>
    <ol class="alp-path-inline"><li>ایران</li><li>خراسان رضوی</li><li>زبرخان</li><li>آلوخور</li></ol>
    <a class="alp-btn alp-btn-ghost" href="<?php echo esc_url($about);?>">داستان کامل آلوخور</a>
   </div>
   <figure class="alp-story-img"><img src="<?php echo esc_url($img.'export-banner-bg.jpg');?>" alt="باغ آلو در خراسان" loading="lazy"><figcaption><?php echo alookhor_cc_pdp_icon('leaf');?><span>۱۰۰٪ طبیعی</span></figcaption></figure>
  </section>

  <div class="alp-cols">
   <section class="alp-specs">
    <h2>مشخصات محصول</h2>
    <table><tbody><?php foreach($d['specs'] as $s):?><tr><th><?php echo esc_html($s[0]);?></th><td><?php echo esc_html($s[1]);?></td></tr><?php endforeach;?></tbody></table>
   </section>
   <section class="alp-why">
    <h2>چرا آلوخور؟</h2>
    <ul><?php foreach($d['why'] as $w):?><li><i><?php echo alookhor_cc_pdp_icon($w[0]);?></i><b><?php echo esc_html($w[1]);?></b><span><?php echo esc_html($w[2]);?></span></li><?php endforeach;?></ul>
   </section>
  </div>
 </div>

 <section class="alp-band alp-moment">
  <div class="alp-inner"><span class="alp-dust" aria-hidden="true"></span><b>ALOOKHOR</b><h2>پایتخت آلوی ایران</h2><p>از باغ‌های آلو خراسان تا بستهٔ نهایی، با همان استاندارد.</p></div>
 </section>

 <div class="alp-inner">
  <?php if($d['related']):?>
  <section class="alp-rail-sec">
   <h2>محصولات پیشنهادی برای شما</h2>
   <div class="alp-rail"><?php foreach($d['related'] as $rid)echo alookhor_cc_pdp_card($rid);?></div>
  </section>
  <?php endif;?>

  <section class="alp-reviews" id="alookhor-reviews">
   <h2>نظر مشتریان آلوخور</h2>
   <?php if($d['reviews']>0):?>
    <div class="alp-rev-dash">
     <div class="alp-rev-score"><b><?php echo esc_html(number_format_i18n($d['rating'],1));?></b><span class="alp-stars"><?php echo $stars(5);?></span><small><?php echo esc_html(number_format_i18n($d['reviews']));?> دیدگاه</small><em><?php echo esc_html(number_format_i18n($d['rating'],1));?> از ۵</em></div>
     <div class="alp-rev-cats"><?php foreach([5,4,3,2,1] as $star):$cnt=$d['rating_counts'][$star];$pct=$d['reviews']>0?(int)round($cnt/$d['reviews']*100):0;?><div class="alp-rev-cat"><span><?php echo esc_html(number_format_i18n($star));?> ★</span><i><b style="width:<?php echo esc_attr($pct);?>%"></b></i><small><?php echo esc_html(number_format_i18n($cnt));?></small></div><?php endforeach;?></div>
    </div>
   <?php else:?>
    <div class="alp-rev-empty"><?php echo alookhor_cc_pdp_icon('chat');?><p>هنوز دیدگاهی برای این محصول ثبت نشده است. اگر این محصول را خریده‌اید، تجربهٔ خود را بنویسید تا انتخاب دیگران دقیق‌تر شود.</p></div>
   <?php endif;?>
   <?php if($d['reviews_list']):?><div class="alp-rev-list"><?php foreach($d['reviews_list'] as $rv):?><article class="alp-rev-card"><header><b><?php echo esc_html($rv['name']);?></b><?php if($rv['verified']):?><span class="alp-verified"><?php echo alookhor_cc_pdp_icon('check');?>خرید تأییدشده</span><?php endif;?></header><span class="alp-stars"><?php echo $stars(5);?></span><time><?php echo esc_html($rv['date']);?></time><p><?php echo esc_html($rv['text']);?></p></article><?php endforeach;?></div><?php endif;?>
   <div class="alp-rev-form"><h3>ثبت دیدگاه</h3>
   <?php if(function_exists('comment_form'))comment_form(['title_reply'=>'','title_reply_to'=>'پاسخ به %s','label_submit'=>'ثبت دیدگاه','comment_notes_before'=>'','comment_notes_after'=>''],$d['id']);?>
   </div>
  </section>

  <section class="alp-qa">
   <h2>سوالات متداول</h2>
   <?php foreach($d['faqs'] as $f):?><div class="alp-acc" data-acc><button type="button" class="alp-acc-t" data-acc-t><b><?php echo esc_html($f['q']);?></b><?php echo alookhor_cc_pdp_icon('chev');?></button><div class="alp-acc-b"><p><?php echo esc_html($f['a']);?></p></div></div><?php endforeach;?>
  </section>
 </div>

 <section class="alp-band alp-wholesale">
  <div class="alp-inner">
   <header><span class="alp-kicker">ALOOKHOR EXPORT</span><h2>خرید عمده و صادرات</h2><p>تأمین مستقیم محصولات آلوخور برای سفارش‌های عمده</p></header>
   <ul class="alp-volume"><li>۱۰ کیلو</li><li>۵۰ کیلو</li><li>۱۰۰ کیلو</li><li>سفارش صادراتی</li></ul>
   <div class="alp-ctas"><a class="alp-btn alp-btn-gold" href="<?php echo esc_url($contact);?>">درخواست قیمت عمده</a><?php if($wa):?><a class="alp-btn alp-btn-line" href="<?php echo esc_url($wa);?>" target="_blank" rel="noopener">مشاوره صادرات</a><?php endif;?></div>
  </div>
 </section>

 <section class="alp-band alp-final">
  <div class="alp-inner"><h2>طعم اصیل آلوهای خراسان را انتخاب کنید</h2><p>کیفیت انتخاب‌شده، بسته‌بندی حرفه‌ای و ارسال مطمئن از آلوخور</p><?php if($d['purchasable']&&$d['stock']!=='out'):?><a class="alp-btn alp-btn-gold" href="<?php echo esc_url($d['add_url']);?>" data-base="<?php echo esc_attr($d['add_url']);?>"><?php echo alookhor_cc_pdp_icon('bag');?><span>افزودن به سبد خرید</span></a><?php endif;?></div>
 </section>

 <div class="alp-lb" data-lb hidden><button type="button" data-lb-close aria-label="بستن">✕</button><img src="<?php echo esc_url($main_slide['src']);?>" alt="<?php echo esc_attr($d['name']);?>"></div>
</section>
<div class="alp-sticky" data-name="<?php echo esc_attr($d['name']);?>"><span class="alp-sticky-p"><?php echo wp_kses_post($d['price_html']);?></span><?php if($d['purchasable']&&$d['stock']!=='out'):?><a href="<?php echo esc_url($d['add_url']);?>" data-base="<?php echo esc_attr($d['add_url']);?>" class="alp-cta"><?php echo alookhor_cc_pdp_icon('bag');?><span>افزودن به سبد خرید</span></a><?php endif;?></div>
<script type="application/ld+json"><?php echo wp_json_encode(['@context'=>'https://schema.org','@type'=>'Product','name'=>$d['name'],'image'=>$main_slide['src'],'sku'=>$d['sku'],'offers'=>['@type'=>'Offer','price'=>$d['price'],'priceCurrency'=>(function_exists('get_woocommerce_currency')?get_woocommerce_currency():'IRR'),'availability'=>'https://schema.org/'.($d['in_stock']?'InStock':'OutOfStock')],'brand'=>['@type'=>'Brand','name'=>'ALOOKHOR']]);?></script>
<?php $GLOBALS['alookhor_cc_pdp_done']=true;
 return ob_get_clean();
}

/* Guaranteed path — render the ALOOKHOR PDP directly at template_redirect and exit,
   BEFORE any theme/builder template can load (v3.10.188). No old page, no duplication.
   v3.10.190: keep only the theme <head>+<body> (assets intact), drop the theme's own
   header markup (the extra dark Woodmart strip) and render the site's managed chrome:
   portal header (main menu) + PDP + managed footer. */
add_action('template_redirect',function(){
 if(($_SERVER['REQUEST_METHOD']??'')==='POST')return;
 if(isset($_GET['elementor-preview'])||(($_GET['action']??'')==='elementor'))return;
 if(isset($_GET['add-to-cart'])||isset($_GET['wc-ajax'])||isset($_GET['remove-item']))return;
 if(!function_exists('is_product')||!is_product()||!function_exists('wc_get_product'))return;
 $markup=alookhor_cc_pdp_markup();
 if($markup==='')return;
 nocache_headers();
 ob_start();
 get_header();
 $theme_head=ob_get_clean();
 if(is_string($theme_head)&&preg_match('/^(.*?<body[^>]*>)/s',$theme_head,$head_match)){echo $head_match[1];}
 elseif(is_string($theme_head)){echo $theme_head;}
 if(function_exists('alookhor_cc_render_akx_header'))echo alookhor_cc_render_akx_header();
 echo $markup;
 if(function_exists('alookhor_cc_footer_markup'))echo alookhor_cc_footer_markup();
 wp_footer();
 echo '</body></html>';
 exit;
},55);

/* Fallback path — if the direct render above ever gets bypassed, still force our template. */
add_filter('template_include',function($template){
 if(!function_exists('is_product')||!is_product()||!function_exists('wc_get_product'))return $template;
 if(isset($_GET['elementor-preview'])||(($_GET['action']??'')==='elementor'))return $template;
 if(!file_exists(ALOOKHOR_CC_DIR.'templates/single-product.php'))return $template;
 return ALOOKHOR_CC_DIR.'templates/single-product.php';
},PHP_INT_MAX);

add_filter('body_class',function($classes){
 if(function_exists('is_product')&&is_product())$classes[]='alookhor-pdp-body';
 return $classes;
});

add_action('wp_enqueue_scripts',function(){
 if(!function_exists('is_product')||!is_product())return;
 wp_enqueue_style('alookhor-cc-pdp',ALOOKHOR_CC_URL.'assets/css/frontend-product.css',[],ALOOKHOR_CC_BUILD);
 wp_enqueue_script('alookhor-cc-pdp',ALOOKHOR_CC_URL.'assets/js/frontend-product.js',[],ALOOKHOR_CC_BUILD,true);
});
