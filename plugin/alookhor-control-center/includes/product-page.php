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
  'cart'=>'<circle cx="8" cy="21" r="1"/><circle cx="19" cy="21" r="1"/><path d="M2.05 2.05h2l2.66 12.42a2 2 0 0 0 2 1.58h9.78a2 2 0 0 0 1.95-1.57l1.65-7.43H5.12"/>',
  'chevl'=>'<path d="m15 18-6-6 6-6"/>',
  'chevr'=>'<path d="m9 18 6-6-6-6"/>',
  'expand'=>'<path d="M8 3H5a2 2 0 0 0-2 2v3"/><path d="M21 8V5a2 2 0 0 0-2-2h-3"/><path d="M3 16v3a2 2 0 0 0 2 2h3"/><path d="M16 21h3a2 2 0 0 0 2-2v-3"/>',
  'ret'=>'<path d="M3 12a9 9 0 1 0 9-9 9.75 9.75 0 0 0-6.74 2.74L3 8"/><path d="M3 3v5h5"/>',
  'headset'=>'<path d="M3 13a9 9 0 0 1 18 0"/><path d="M21 17a2 2 0 0 1-2 2h-1a2 2 0 0 1-2-2v-3a2 2 0 0 1 2-2h3v5Z"/><path d="M3 17a2 2 0 0 0 2 2h1a2 2 0 0 0 2-2v-3a2 2 0 0 0-2-2H3v5Z"/><path d="M21 17v1a3 3 0 0 1-3 3h-4"/>',
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
 $brand_shots=[['src'=>$img.'footer-prunes.png','label'=>'آلو خشک آلوخور'],['src'=>$img.'category-nuts.jpg','label'=>'بسته‌بندی و فرآوری']];
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
 $desc_html=trim((string)$product->get_description());
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
  'short'=>$product->get_short_description()?:'','desc'=>$desc_html?wp_kses_post(wpautop($desc_html)):'','cats'=>$cats,'first_cat'=>$first_cat,
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
 $fa_th=function($n){return strtr(number_format((float)$n,0,'.','٬'),['0'=>'۰','1'=>'۱','2'=>'۲','3'=>'۳','4'=>'۴','5'=>'۵','6'=>'۶','7'=>'۷','8'=>'۸','9'=>'۹']);};
 $cur=function_exists('get_woocommerce_currency')?get_woocommerce_currency():'';
 $toman_rate=$cur==='IRR'?10:($cur==='IRT'?1:0);
 $use_toman=$toman_rate>0&&!$product->is_type('variable')&&$d['price']>0;
 $price_now_html=$use_toman?$fa_th((int)round($d['price']/$toman_rate)).'<span class="alpm-cur">تومان</span>':wp_kses_post($d['price_html']);
 $price_old_html=($use_toman&&$d['regular']>0)?$fa_th((int)round($d['regular']/$toman_rate)).'<span class="alpm-cur">تومان</span>':wp_kses_post(wc_price($d['regular']));
 $price_single=$use_toman?wp_strip_all_tags($price_now_html):wp_strip_all_tags($d['price_html']);
 $show_weights=count($d['options'])>1||$product->is_type('variable')||!empty((float)$product->get_weight());
 $stars=function($n,$active=true){$o='';for($i=1;$i<=5;$i++)$o.=alookhor_cc_pdp_icon('star');return $o;};
 ob_start();?>
<section id="alookhor-pdp" class="alookhor-alp" dir="rtl" data-cart="<?php echo esc_url($cart);?>" style="--alp-gold:<?php echo esc_attr($gold);?>">
 <div class="alpm"><div class="alpm-wrap">
  <div class="alpm-grid">

   <section class="alpm-panel">
    <nav class="alpm-crumbs" aria-label="مسیر صفحه"><a href="<?php echo esc_url(home_url('/'));?>">خانه</a><?php echo alookhor_cc_pdp_icon('chevl');?><a href="<?php echo esc_url($shop);?>">محصولات</a><?php if($d['first_cat']['name']):?><?php echo alookhor_cc_pdp_icon('chevl');?><a href="<?php echo esc_url($d['first_cat']['link']);?>"><?php echo esc_html($d['first_cat']['name']);?></a><?php endif;?><?php echo alookhor_cc_pdp_icon('chevl');?><span><?php echo esc_html($d['name']);?></span></nav>

    <div class="alpm-head">
     <h1 class="alpm-title"><?php echo esc_html($d['name']);?></h1>
     <p class="alpm-tag">طعم اصیل، سلامتی طبیعی</p>
     <p class="alpm-desc"><?php if($d['short']):?><?php echo esc_html(wp_strip_all_tags($d['short']));?><?php else:?><?php echo esc_html($d['name']);?> آلوخور، انتخابی بی‌نظیر از باغات ایران، با طعمی دلنشین و کیفیتی ممتاز. مناسب برای مصرف روزانه، آشپزی و پذیرایی؛ بدون هیچ افزودنی، رنگ یا شکر افزوده.<?php endif;?></p>
    </div>

    <div class="alpm-rate">
     <?php if($d['reviews']>0):$rate_pct=max(0,min(100,(int)round($d['rating']/5*100)));?>
      <span class="alpm-stars" aria-label="امتیاز <?php echo esc_attr(number_format_i18n($d['rating'],1));?> از ۵"><span class="alpm-stars-bg" aria-hidden="true"><?php for($i=0;$i<5;$i++)echo alookhor_cc_pdp_icon('star');?></span><span class="alpm-stars-fg" style="width:<?php echo esc_attr($rate_pct);?>%" aria-hidden="true"><?php for($i=0;$i<5;$i++)echo alookhor_cc_pdp_icon('star');?></span></span>
      <b class="alpm-rscore"><?php echo esc_html(number_format_i18n($d['rating'],1));?> از ۵</b>
      <span class="alpm-rcount">(<?php echo esc_html(number_format_i18n($d['reviews']));?> نظر)</span>
     <?php else:?>
      <span class="alpm-stars alpm-stars-offline" aria-hidden="true"><span class="alpm-stars-bg"><?php for($i=0;$i<5;$i++)echo alookhor_cc_pdp_icon('star');?></span></span>
      <a class="alpm-rfirst" href="#alookhor-reviews">اولین دیدگاه را شما ثبت کنید</a>
     <?php endif;?>
     <i class="alpm-rdiv" aria-hidden="true"></i>
     <button type="button" class="alpm-wish" data-wish aria-pressed="false" aria-label="افزودن به علاقه‌مندی‌ها"><?php echo alookhor_cc_pdp_icon('heart');?><span data-wish-label>افزودن به علاقه‌مندی‌ها</span></button>
    </div>

    <div class="alpm-feats">
     <div class="alpm-feat"><?php echo alookhor_cc_pdp_icon('truck');?><b>ارسال سریع</b><span>به سراسر کشور</span></div>
     <div class="alpm-feat"><?php echo alookhor_cc_pdp_icon('shield');?><b>محصول ایرانی</b><span>حمایت از کشاورزان</span></div>
     <div class="alpm-feat"><?php echo alookhor_cc_pdp_icon('gem');?><b>کیفیت ممتاز</b><span>درجه یک صادراتی</span></div>
     <div class="alpm-feat"><?php echo alookhor_cc_pdp_icon('leaf');?><b>۱۰۰٪ طبیعی</b><span>بدون مواد افزودنی</span></div>
    </div>

    <div class="alpm-pricebox">
     <div class="alpm-prow"><span class="alpm-plabel">قیمت محصول :</span><?php if($d['discount']>0):?><em class="alpm-poff">٪<?php echo esc_html(strtr((string)$d['discount'],['0'=>'۰','1'=>'۱','2'=>'۲','3'=>'۳','4'=>'۴','5'=>'۵','6'=>'۶','7'=>'۷','8'=>'۸','9'=>'۹']));?> تخفیف</em><?php endif;?></div>
     <div class="alpm-prow2">
      <?php if($d['on_sale']&&$d['regular']>0&&$d['price']>0&&$d['price']<$d['regular']):?><s class="alpm-pold"><?php echo $price_old_html;?></s><?php endif;?>
      <b class="alpm-pnow alp-price-now" data-single="<?php echo esc_attr($price_single);?>"><?php echo $price_now_html;?></b>
     </div>
    </div>

    <?php if($show_weights):?>
    <div class="alpm-opt">
     <span class="alpm-olabel">وزن محصول :</span>
     <div class="alpm-wchips" role="radiogroup" aria-label="انتخاب وزن"><?php foreach($d['options'] as $oi=>$o):?><button type="button" role="radio" aria-checked="<?php echo $oi===0?'true':'false';?>" class="<?php echo $oi===0?'is-on':'';?>" data-vid="<?php echo esc_attr($o['id']);?>" data-price="<?php echo esc_attr($o['price_html']);?>"><?php echo esc_html($o['label']);?></button><?php endforeach;?></div>
    </div>
    <?php endif;?>

    <?php if($d['purchasable']&&$d['stock']!=='out'):?>
    <div class="alpm-qtyrow">
     <span class="alpm-olabel">تعداد :</span>
     <span class="alpm-qty"><button type="button" data-q="+" aria-label="افزایش تعداد"><?php echo alookhor_cc_pdp_icon('plus');?></button><b id="alpQty">۱</b><button type="button" data-q="-" aria-label="کاهش تعداد"><?php echo alookhor_cc_pdp_icon('minus');?></button></span>
    </div>

    <a class="alpm-cta" id="alpAdd" href="<?php echo esc_url($d['add_url']);?>" data-base="<?php echo esc_attr($d['add_url']);?>"><?php echo alookhor_cc_pdp_icon('cart');?><span>افزودن به سبد خرید</span></a>
    <?php endif;?>

    <div class="alpm-meta">
     <span class="alpm-ship">ارسال از ۱ روز کاری آینده</span>
     <?php if($d['stock']==='in'):?><span class="alpm-stock alpm-stock-in"><i class="alpm-pulse" aria-hidden="true"></i>موجود در انبار</span><?php elseif($d['stock']==='low'):?><span class="alpm-stock alpm-stock-low"><i class="alpm-pulse" aria-hidden="true"></i>موجودی محدود</span><?php else:?><span class="alpm-stock alpm-stock-out"><i aria-hidden="true"></i>ناموجود</span><?php endif;?>
    </div>

    <div class="alpm-guars">
     <div class="alpm-guar"><?php echo alookhor_cc_pdp_icon('shield');?><span>ضمانت اصالت کالا</span></div>
     <div class="alpm-guar"><?php echo alookhor_cc_pdp_icon('ret');?><span>۷ روز ضمانت بازگشت</span></div>
     <div class="alpm-guar"><?php echo alookhor_cc_pdp_icon('headset');?><span>پشتیبانی آنلاین</span></div>
    </div>
   </section>

   <div class="alpm-side">
    <figure class="alpm-gallery">
     <div class="alpm-stage" data-stage>
      <img id="alpMain" src="<?php echo esc_url($main_slide['src']);?>" alt="<?php echo esc_attr($d['name']);?>">
      <span class="alpm-ribbon"><?php echo alookhor_cc_pdp_icon('leaf');?><b>۱۰۰٪ طبیعی</b></span>
      <div class="alpm-script" aria-hidden="true"><p>طعم اصیل<br>سلامتی طبیعی</p><svg viewBox="0 0 160 12" fill="none"><path d="M2 8c40-6 90-6 156-2" stroke="currentColor" stroke-width="3" stroke-linecap="round"/></svg></div>
      <span class="alpm-count"><b data-gal-num>۱</b> / <?php echo esc_html(strtr((string)count($d['slides']),['0'=>'۰','1'=>'۱','2'=>'۲','3'=>'۳','4'=>'۴','5'=>'۵','6'=>'۶','7'=>'۷','8'=>'۸','9'=>'۹']));?></span>
      <button type="button" class="alpm-arr alpm-arr-prev" data-gal-prev aria-label="تصویر قبلی"><?php echo alookhor_cc_pdp_icon('chevr');?></button>
      <button type="button" class="alpm-arr alpm-arr-next" data-gal-next aria-label="تصویر بعدی"><?php echo alookhor_cc_pdp_icon('chevl');?></button>
      <button type="button" class="alpm-fs" data-fs aria-label="نمایش تمام‌صفحه"><?php echo alookhor_cc_pdp_icon('expand');?></button>
     </div>
     <div class="alpm-thumbs" role="tablist" aria-label="گالری تصاویر محصول"><?php foreach($d['slides'] as $si=>$s):?><button type="button" role="tab" class="<?php echo $si===0?'is-on':'';?>" data-src="<?php echo esc_url($s['src']);?>" aria-label="<?php echo esc_attr($s['label']);?>"><img src="<?php echo esc_url($s['src']);?>" alt="<?php echo esc_attr($s['label']);?>" loading="lazy"></button><?php endforeach;?></div>
    </figure>

    <div class="alpm-banner">
     <img class="alpm-banner-bg" src="<?php echo esc_url($img.'footer-prunes.png');?>" alt="" aria-hidden="true" loading="lazy">
     <span class="alpm-banner-ov" aria-hidden="true"></span>
     <div class="alpm-banner-c">
      <div class="alpm-banner-t"><h2>خوشمزه‌تر زندگی کن...</h2><p>با محصولات طبیعی الخور</p></div>
      <a class="alpm-banner-btn" href="<?php echo esc_url($shop);?>"><?php echo alookhor_cc_pdp_icon('chevl');?><span>مشاهده همه محصولات</span></a>
     </div>
    </div>
   </div>

  </div>
 </div></div>

 <div class="alp-inner">
  <ul class="alp-trust">
   <li><?php echo alookhor_cc_pdp_icon('truck');?><b>ارسال سریع</b><span>ارسال به سراسر کشور</span></li>
   <li><?php echo alookhor_cc_pdp_icon('shield');?><b>ضمانت کیفیت</b><span>تضمین کیفیت محصول</span></li>
   <li><?php echo alookhor_cc_pdp_icon('box');?><b>بسته‌بندی مطمئن</b><span>بسته‌بندی استاندارد</span></li>
   <li><?php echo alookhor_cc_pdp_icon('phone');?><b>پشتیبانی</b><span>پاسخ‌گویی قبل و بعد از خرید</span></li>
  </ul>
 </div>

 <div class="alp-dk alp-dk-main">
  <div class="alp-inner">
  <section class="alp-desc" id="alp-desc">
   <header class="alp-shead"><span class="alp-eyebrow">معرفی محصول</span><h2>توضیحات محصول</h2></header>
   <p class="alp-dk-sub">هر آنچه باید پیش از انتخاب این محصول آلوخور بدانید، از باغ تا بسته‌بندی.</p>
   <div class="alp-desc-grid">
    <div class="alp-desc-body">
     <?php if($d['desc']):?>
      <?php echo $d['desc'];?>
     <?php else:?>
      <p>این محصول از باغ‌های آلو در زبرخانِ خراسان رضوی برداشت می‌شود؛ همان خاکی که آلوخور از آن آموخته است کیفیت آلو را اول از همه درخت تعیین می‌کند و بعد از آن، دقت در انتخاب و فرآوری.</p>
      <p>پس از برداشت، محصول سورت، آماده‌سازی و در بسته‌بندی بهداشتی بسته می‌شود؛ مناسب مصرف روزانهٔ خانواده، مهمان‌نوازی و هدیه — و در حجم‌های بزرگ‌تر، آمادهٔ سفارش عمده و صادرات.</p>
     <?php endif;?>
     <ol class="alp-path-inline"><li>ایران</li><li>خراسان رضوی</li><li>زبرخان</li><li>آلوخور</li></ol>
     <a class="alp-btn alp-btn-royal" href="<?php echo esc_url($about);?>">داستان کامل آلوخور</a>
    </div>
    <figure class="alp-story-img"><img src="<?php echo esc_url($img.'export-banner-bg.jpg');?>" alt="باغ آلو در خراسان" loading="lazy"><figcaption><?php echo alookhor_cc_pdp_icon('leaf');?><span>۱۰۰٪ طبیعی</span></figcaption></figure>
   </div>
  </section>

  <div class="alp-cols">
   <section class="alp-specs" id="alp-specs">
    <header class="alp-shead"><span class="alp-eyebrow">جزئیات</span><h2>مشخصات محصول</h2></header>
    <table><tbody><?php foreach($d['specs'] as $s):?><tr><th><?php echo esc_html($s[0]);?></th><td><?php echo esc_html($s[1]);?></td></tr><?php endforeach;?></tbody></table>
   </section>
   <section class="alp-why">
    <header class="alp-shead"><span class="alp-eyebrow">مزیت‌ها</span><h2>چرا آلوخور؟</h2></header>
    <ul><?php foreach($d['why'] as $w):?><li><i><?php echo alookhor_cc_pdp_icon($w[0]);?></i><b><?php echo esc_html($w[1]);?></b><span><?php echo esc_html($w[2]);?></span></li><?php endforeach;?></ul>
   </section>
  </div>
 </div>
 </div>

 <section class="alp-band alp-moment">
  <div class="alp-inner"><span class="alp-dust" aria-hidden="true"></span><b>ALOOKHOR</b><h2>پایتخت آلوی ایران</h2><p>از باغ‌های آلو خراسان تا بستهٔ نهایی، با همان استاندارد.</p></div>
 </section>

 <div class="alp-dk alp-dk-rail">
  <div class="alp-inner">
  <?php if($d['related']):?>
  <section class="alp-rail-sec">
   <header class="alp-shead alp-rail-head"><span class="alp-eyebrow">پیشنهاد آلوخور</span><h2>محصولات <b>پیشنهادی</b> برای شما</h2><a class="alp-all" href="<?php echo esc_url($shop);?>">مشاهده همه محصولات</a></header>
   <div class="alp-rail"><?php foreach($d['related'] as $rid)echo alookhor_cc_pdp_card($rid);?></div>
   <div class="alp-rail-cta"><a class="alp-btn alp-btn-royal" href="<?php echo esc_url($shop);?>">مشاهده همه محصولات</a></div>
  </section>
  <?php endif;?>
  </div>
 </div>

 <div class="alp-inner">

  <section class="alp-reviews" id="alookhor-reviews">
   <header class="alp-shead"><span class="alp-eyebrow">تجربهٔ مشتریان</span><h2>نظر مشتریان آلوخور</h2></header>
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
 </div>

 <div class="alp-dk alp-dk-qa">
  <div class="alp-inner">
  <section class="alp-qa" id="alp-qa">
   <p class="alp-dk-sub">پاسخ پرتکرارترین پرسش‌ها دربارهٔ خرید، ارسال و نگهداری محصول آلوخور.</p>
   <div class="alp-qa-grid">
    <aside class="alp-qa-side">
     <header class="alp-shead"><span class="alp-eyebrow">پرسش و پاسخ</span><h2>سوالات متداول</h2></header>
     <a class="alp-btn alp-btn-gold" href="<?php echo esc_url($contact);?>">تماس با پشتیبانی</a>
    </aside>
    <div class="alp-qa-list">
     <?php foreach($d['faqs'] as $f):?><div class="alp-acc" data-acc><button type="button" class="alp-acc-t" data-acc-t><b><?php echo esc_html($f['q']);?></b><?php echo alookhor_cc_pdp_icon('chev');?></button><div class="alp-acc-b"><p><?php echo esc_html($f['a']);?></p></div></div><?php endforeach;?>
    </div>
   </div>
  </section>
  </div>
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

 <div class="alpm-toast" data-toast hidden><div class="alpm-toast-in"><span class="alpm-toast-ic"><?php echo alookhor_cc_pdp_icon('check');?></span><span data-toast-msg></span></div></div>
</section>
<div class="alp-sticky" data-name="<?php echo esc_attr($d['name']);?>"><span class="alp-sticky-p"><?php echo $price_now_html;?></span><?php if($d['purchasable']&&$d['stock']!=='out'):?><a href="<?php echo esc_url($d['add_url']);?>" data-base="<?php echo esc_attr($d['add_url']);?>" class="alp-cta"><?php echo alookhor_cc_pdp_icon('bag');?><span>افزودن به سبد خرید</span></a><?php endif;?></div>
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
 echo "\n<!-- ALOOKHOR-PDP v".esc_html(ALOOKHOR_CC_VERSION)." -->\n";
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
