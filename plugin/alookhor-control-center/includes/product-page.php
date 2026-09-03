<?php
/** ALOOKHOR PDP — v3.10.225: exact port of owner React design (convert-content zip) — plum/gold/berry/mint, gallery vertical rail, banner, below sections. */
if(!defined('ABSPATH'))exit;

if(!function_exists('alookhor_cc_pdp_icon')){
function alookhor_cc_pdp_icon($name){
 $p=[
  'star'=>'<path d="M12 2l2.92 6.26 6.58.57-5 4.4 1.5 6.47L12 16.9 5.99 19.7l1.5-6.47-5-4.4 6.6-.57L12 2z"/>',
  'heart'=>'<path d="M19 14c1.49-1.46 3-3.21 3-5.5A5.5 5.5 0 0 0 16.5 3c-1.76 0-3 .5-4.5 2-1.5-1.5-2.74-2-4.5-2A5.5 5.5 0 0 0 2 8.5c0 2.3 1.5 4.05 3 5.5l7 7Z"/>',
  'share'=>'<circle cx="18" cy="5" r="2.5"/><circle cx="6" cy="12" r="2.5"/><circle cx="18" cy="19" r="2.5"/><path d="m8.2 10.8 7.6-4.5"/><path d="m8.2 13.2 7.6 4.5"/>',
  'truck'=>'<path d="M14 18V6a2 2 0 0 0-2-2H4a2 2 0 0 0-2 2v11a1 1 0 0 0 1 1h2"/><path d="M15 18H9"/><path d="M19 18h2a1 1 0 0 0 1-1v-3.65a1 1 0 0 0-.22-.62l-3.48-4.35A1 1 0 0 0 17.52 8H14"/><circle cx="17" cy="18" r="2"/><circle cx="7" cy="18" r="2"/>',
  'box'=>'<path d="m21 8-9 5-9-5 9-5 9 5Z"/><path d="M3 8v8l9 5 9-5V8"/><path d="M12 13v8"/>',
  'compare'=>'<path d="M3 7a2 2 0 0 1 4 0v5a2 2 0 0 1-4 0V7Z"/><path d="M17 7a2 2 0 0 1 4 0v5a2 2 0 0 1-4 0V7Z"/><path d="M12 3v18"/><path d="M2 10h6"/><path d="M16 10h6"/>',
  'shield'=>'<path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/>',
  'shield-check'=>'<path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/><path d="m9 12 2 2 4-4"/>',
  'check'=>'<path d="m4 12.5 5 5L20 6.5"/>',
  'plus'=>'<path d="M5 12h14"/><path d="M12 5v14"/>',
  'minus'=>'<path d="M5 12h14"/>',
  'chevl'=>'<path d="m15 18-6-6 6-6"/>',
  'chevr'=>'<path d="m9 18 6-6-6-6"/>',
  'expand'=>'<path d="M8 3H5a2 2 0 0 0-2 2v3"/><path d="M21 8V5a2 2 0 0 0-2-2h-3"/><path d="M3 16v3a2 2 0 0 0 2 2h3"/><path d="M16 21h3a2 2 0 0 0 2-2v-3"/>',
  'leaf'=>'<path d="M11 20A7 7 0 0 1 9.8 6.1C15.5 5 17 4.48 19 2c1 2 2 4.18 2 8 0 5.5-4.78 10-10 10Z"/><path d="M2 21c0-3 1.85-5.36 5.08-6C9.5 14.52 12 13 13 12"/>',
  'gem'=>'<path d="M6 3h12l4 6-10 13L2 9Z"/><path d="M11 3 8 9l4 13 4-13-3-6"/><path d="M2 9h20"/>',
  'clock'=>'<circle cx="12" cy="12" r="9"/><path d="M12 7v5l3 2"/>',
  'cart'=>'<circle cx="8" cy="21" r="1"/><circle cx="19" cy="21" r="1"/><path d="M2.05 2.05h2l2.66 12.42a2 2 0 0 0 2 1.58h9.78a2 2 0 0 0 1.95-1.57l1.65-7.43H5.12"/>',
  'play'=>'<path d="M8 5.14v13.72a1 1 0 0 0 1.5.86l11-6.86a1 1 0 0 0 0-1.72l-11-6.86a1 1 0 0 0-1.5.86Z"/>',
  'return'=>'<path d="M3 12a9 9 0 1 0 9-9 9.75 9.75 0 0 0-6.74 2.74L3 8"/><path d="M3 3v5h5"/>',
  'headset'=>'<path d="M3 13a9 9 0 0 1 18 0"/><path d="M21 17a2 2 0 0 1-2 2h-1a2 2 0 0 1-2-2v-3a2 2 0 0 1 2-2h3v5Z"/><path d="M3 17a2 2 0 0 0 2 2h1a2 2 0 0 0 2-2v-3a2 2 0 0 0-2-2H3v5Z"/><path d="M21 17v1a3 3 0 0 1-3 3h-4"/>',
  'mail'=>'<rect x="2" y="4" width="20" height="16" rx="2"/><path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"/>',
  'bag'=>'<path d="M6 8h12l-1 13H7L6 8Zm3 0V6a3 3 0 0 1 6 0v2"/>',
  'sprout'=>'<path d="M12 21v-8"/><path d="M12 13c0-4-3-6-8-6 0 5 3 7 8 6Z"/><path d="M12 13c0-4 3-6 8-6 0 5-3 7-8 6Z"/>',
  'pin'=>'<path d="M20 10c0 6-8 12-8 12s-8-6-8-12a8 8 0 1 1 16 0Z"/><circle cx="12" cy="10" r="3"/>',
  'phone'=>'<path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72c.13.96.36 1.9.7 2.81a2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45c.91.34 1.85.57 2.81.7A2 2 0 0 1 22 16.92z"/>',
 ];
 $svg = $p[$name] ?? $p['star'];
 $fill = ($name==='star'||$name==='play') ? 'fill="currentColor" stroke="none"' : 'fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"';
 if($name==='check') $fill='fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"';
 if($name==='heart') $fill='fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"';
 return '<svg viewBox="0 0 24 24" '.$fill.' aria-hidden="true">'.$svg.'</svg>';
}
}


if(!function_exists('alookhor_cc_pdp_gold')){
function alookhor_cc_pdp_gold($text){return function_exists('alookhor_cc_goldify')?alookhor_cc_goldify($text):esc_html($text);}
}


if(!function_exists('alookhor_cc_pdp_product')){
function alookhor_cc_pdp_product($slug=''){
 if(!function_exists('wc_get_product'))return null;
 if($slug){$post=get_page_by_path(sanitize_title($slug),OBJECT,'product');if($post)return wc_get_product($post->ID);}
 if(function_exists('is_product')&&is_product()){$p=wc_get_product((int)get_queried_object_id());if($p)return $p;}
 $posts=get_posts(['post_type'=>'product','post_status'=>'publish','numberposts'=>1,'orderby'=>'date','order'=>'DESC','fields'=>'ids']);
 return $posts?wc_get_product((int)$posts[0]):null;
}
}


if(!function_exists('alookhor_cc_pdp_data')){
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
 if(!$main)$main=$img.'bowl.jpg';
 $gallery=[];
 foreach((array)$product->get_gallery_image_ids() as $gid){$u=wp_get_attachment_image_url((int)$gid,'woocommerce_single');if($u)$gallery[]=['src'=>$u,'label'=>'نمای نزدیک'];}
 // brand shots from real assets
 $brand_shots=[['src'=>$img.'footer-prunes.png','label'=>'آلو خشک آلوخور'],['src'=>$img.'category-nuts.jpg','label'=>'بسته‌بندی و فرآوری']];
 $slides=array_merge([['src'=>$main,'label'=>'محصول']],$gallery,$brand_shots);
 // ensure at least 5 slides for design
 while(count($slides)<5){$slides[]=['src'=>$img.'bowl.jpg','label'=>'محصول'];}
 $regular=(float)$product->get_regular_price();$price=(float)$product->get_price();
 $discount=($regular>0&&$price>0&&$price<$regular)?(int)round((1-$price/$regular)*100):0;
 $weight=$product->get_weight();
 $options=[];
 if($product->is_type('variable')){
  foreach($product->get_available_variations() as $v){if(empty($v['variation_is_active']))continue;$label=implode(' / ',array_filter(array_map('trim',array_values((array)($v['attributes']??[]))))); if(!$label)$label='وزن '.count($options)+1; $options[]=['id'=>(int)$v['variation_id'],'label'=>$label,'price_html'=>wp_strip_all_tags((string)($v['price_html']??''))];}
 }
 if(!$options){
  // try to parse weight attribute
  if($weight)$options[]=['id'=>0,'label'=>wc_format_weight((float)$weight),'price_html'=>''];
  else $options[]=['id'=>0,'label'=>'بستهٔ استاندارد','price_html'=>''];
 }
 // related — filter demo products
 $demo_ids=[67,94,111,128,145,162,179,196,197,198,1368,1369,1370];
 $related=[];
 if(function_exists('wc_get_related_products'))$related=wc_get_related_products($id,12);
 $related=array_values(array_filter($related,function($rid) use($demo_ids){if(in_array((int)$rid,$demo_ids,true))return false; $p=wc_get_product((int)$rid); if(!$p)return false; $name=$p->get_name(); if(mb_strpos($name,'سامسونگ')!==false||mb_strpos($name,'گوشی')!==false)return false; return true;}));
 if(count($related)<4&&function_exists('wc_get_products')){
  $fill=wc_get_products(['status'=>'publish','limit'=>20,'exclude'=>array_merge([$id],$demo_ids),'orderby'=>'rand']);
  foreach($fill as $f){if(count($related)>=8)break; $fid=(int)$f->get_id(); if(in_array($fid,$demo_ids,true))continue; $fname=$f->get_name(); if(mb_strpos($fname,'سامسونگ')!==false||mb_strpos($fname,'گوشی')!==false)continue; if(!in_array($fid,$related,true))$related[]=$fid;}
 }
 $related=array_slice($related,0,6);
 // real products for suggested if still empty
 if(count($related)<2&&function_exists('wc_get_products')){
  $all=wc_get_products(['status'=>'publish','limit'=>20,'exclude'=>array_merge([$id],$demo_ids),'orderby'=>'date','order'=>'DESC']);
  foreach($all as $f){$fid=(int)$f->get_id(); if(in_array($fid,$demo_ids,true))continue; $fname=$f->get_name(); if(mb_strpos($fname,'سامسونگ')!==false||mb_strpos($fname,'گوشی')!==false)continue; if(!in_array($fid,$related,true))$related[]=$fid; if(count($related)>=6)break;}
 }
 $faqs=[
  ['q'=>'آیا آلو بخارایی الخور بدون مواد افزودنی است؟','a'=>'بله. محصول با آلوهای سالم باغات ایران تهیه شده و هیچ رنگ، شکر افزوده یا نگهدارنده‌ای ندارد.'],
  ['q'=>'چطور آلوها را تازه و خوش‌طعم نگه دارم؟','a'=>'بسته را پس از هر بار مصرف کامل ببندید و در جای خشک و خنک، دور از نور مستقیم نگهداری کنید. برای نگهداری طولانی‌تر، یخچال بهترین انتخاب است.'],
  ['q'=>'سفارش من چه زمانی ارسال می‌شود؟','a'=>'سفارش‌ها در اولین روز کاری بعد از ثبت، بسته‌بندی و تحویل شرکت حمل‌ونقل می‌شوند. کد رهگیری برای شما پیامک خواهد شد.'],
  ['q'=>'آیا امکان مرجوع کردن محصول وجود دارد؟','a'=>'اگر محصول آسیب‌دیده یا مغایر سفارش به دست شما برسد، تا هفت روز فرصت دارید با پشتیبانی الخور تماس بگیرید.'],
  ['q'=>'آیا امکان خرید عمده وجود دارد؟','a'=>'بله؛ سفارش‌های ۱۰، ۵۰ و ۱۰۰ کیلویی و سفارش‌های صادراتی مسیر اختصاصی دارند. از بخش «خرید عمده و صادرات» همین صفحه درخواست قیمت ثبت کنید.'],
 ];
 $stock='out';
 if($product->is_in_stock())$stock=$product->managing_stock()&&$product->get_stock_quantity()!==''&&(int)$product->get_stock_quantity()>0&&(int)$product->get_stock_quantity()<=5?'low':'in';
 $dried=false;foreach($cats as $c){if(mb_strpos($c,'خشک')!==false||mb_strpos($c,'برگه')!==false)$dried=true;}
 $desc_html=trim((string)$product->get_description());
 $specs=[
  ['نوع محصول',$first_cat['name']?:'برگه میوه‌ها'],
  ['منطقه تولید','زبرخان (خور)، خراسان'],
  ['نوع بسته‌بندی','پاکت زیپ‌دار بهداشتی'],
  ['وزن',$weight?wc_format_weight((float)$weight):'قابل انتخاب'],
  ['شرایط نگهداری','جای خشک و خنک، دور از نور مستقیم'],
  ['ماندگاری','۱۲ ماه پس از تولید'],
  ['کشور تولیدکننده','ایران'],
 ];
 $feats=[
  ['leaf','۱۰۰٪ طبیعی','بدون مواد افزودنی'],
  ['gem','کیفیت ممتاز','درجه یک صادراتی'],
  ['shield','محصول ایرانی','حمایت از کشاورزان'],
  ['truck','ارسال سریع','به سراسر کشور'],
  ['box','بسته‌بندی مطمئن','بسته‌بندی استاندارد'],
 ];
 $why=[
  ['sprout','مستقیم از تولیدکننده','بدون واسطه، از باغ‌های آلو خراسان'],
  ['shield-check','کنترل کیفیت','بررسی و انتخاب محصول پیش از بسته‌بندی'],
  ['box','بسته‌بندی حرفه‌ای','مناسب مصرف، هدیه و ارسال'],
  ['truck','ارسال مطمئن','به سراسر کشور و سفارش‌های صادراتی'],
 ];
 $reviews=[];
 if(function_exists('get_comments')&&class_exists('WC_Comments')){
  $cs=get_comments(['post_id'=>$id,'status'=>'approve','number'=>5]);
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
}


if(!function_exists('alookhor_cc_pdp_card')){
function alookhor_cc_pdp_card($pid){
 $p=function_exists('wc_get_product')?wc_get_product((int)$pid):null;if(!$p)return '';
 $u=wp_get_attachment_image_url((int)$p->get_image_id(),'woocommerce_thumbnail');
 $u=$u?:ALOOKHOR_CC_URL.'assets/images/bowl.jpg';
 $r=(float)$p->get_average_rating();$rc=(int)$p->get_review_count();
 $price_html = $p->get_price_html();
 // filter out demo check again
 $name=$p->get_name(); if(mb_strpos($name,'سامسونگ')!==false||mb_strpos($name,'گوشی')!==false)return '';
 $out='<article class="suggested-product group"><button onclick="window.location.href=\''.esc_url(get_permalink($p->get_id())).'\'" class="suggested-image" aria-label="مشاهده '.esc_attr($name).'"><img src="'.esc_url($u).'" alt="'.esc_attr($name).'" loading="lazy"><span class="product-tag">پیشنهاد الخور</span><span class="suggested-heart">'.alookhor_cc_pdp_icon('heart').'</span></button><div class="suggested-body"><div class="flex items-center justify-between gap-2"><span class="text-[10px] text-lav">'.esc_html($p->get_attribute('pa_brand')?:'خشکبار').'</span><span class="flex items-center gap-0.5 text-gold-400">'.str_repeat(alookhor_cc_pdp_icon('star'),5).'</span></div><h3>'.esc_html($name).'</h3><div class="suggested-footer"><span>'.wp_kses_post($price_html).'</span><button onclick="window.location.href=\''.esc_url($p->add_to_cart_url()).'\'" aria-label="افزودن '.esc_attr($name).'" class="suggested-cart">'.alookhor_cc_pdp_icon('cart').'</button></div></div></article>';
 return $out;
}
}


if(!function_exists('alookhor_cc_pdp_markup')){
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
 $fa_th=function($n){return strtr(number_format((float)$n,0,'.','٬'),['0'=>'۰','1'=>'۱','2'=>'۲','3'=>'۳','4'=>'۴','5'=>'۵','6'=>'۶','7'=>'۷','8'=>'۸','9'=>'۹']);};
 $cur=function_exists('get_woocommerce_currency')?get_woocommerce_currency():'';
 $toman_rate=$cur==='IRR'?10:($cur==='IRT'?1:0);
 $use_toman=$toman_rate>0&&!$product->is_type('variable')&&$d['price']>0;
 $price_now_html=$use_toman?$fa_th((int)round($d['price']/$toman_rate)).'<span class="alpm-cur">تومان</span>':wp_kses_post($d['price_html']);
 $price_old_html=($use_toman&&$d['regular']>0)?$fa_th((int)round($d['regular']/$toman_rate)).'<span class="alpm-cur">تومان</span>':wp_kses_post(wc_price($d['regular']));
 $price_single=$use_toman?wp_strip_all_tags($price_now_html):wp_strip_all_tags($d['price_html']);
 $show_weights=count($d['options'])>1||$product->is_type('variable')||!empty((float)$product->get_weight());
 $faNum = function($v){ $fa='۰۱۲۳۴۵۶۷۸۹'; return strtr((string)$v, ['0'=>'۰','1'=>'۱','2'=>'۲','3'=>'۳','4'=>'۴','5'=>'۵','6'=>'۶','7'=>'۷','8'=>'۸','9'=>'۹']); };
 ob_start();
?>
<section id="alookhor-pdp" class="alookhor-alp app-bg min-h-screen" dir="rtl" data-cart="<?php echo esc_url($cart);?>" style="--alp-gold:<?php echo esc_attr($gold);?>">
<div class="breadcrumb-wrapper mx-auto max-w-[1440px] px-4 lg:px-8 mb-6">
  <nav aria-label="مسیر صفحه" class="breadcrumb-box flex flex-wrap items-center gap-1.5 rounded-2xl border border-white/8 bg-plum-900/50 px-5 py-3 text-xs font-medium text-lav shadow-[0_10px_30px_-15px_rgba(0,0,0,0.5)] backdrop-blur-sm">
    <span class="flex items-center gap-1.5"><a href="<?php echo esc_url(home_url('/'));?>" class="transition hover:text-gold-300">خانه</a><?php echo alookhor_cc_pdp_icon('chevl');?></span>
    <span class="flex items-center gap-1.5"><a href="<?php echo esc_url($shop);?>" class="transition hover:text-gold-300">محصولات</a><?php echo alookhor_cc_pdp_icon('chevl');?></span>
    <?php if($d['first_cat']['name']):?><span class="flex items-center gap-1.5"><a href="<?php echo esc_url($d['first_cat']['link']);?>" class="transition hover:text-gold-300"><?php echo esc_html($d['first_cat']['name']);?></a><?php echo alookhor_cc_pdp_icon('chevl');?></span><?php endif;?>
    <span class="font-bold text-gold-300"><?php echo esc_html($d['name']);?></span>
  </nav>
</div>
 <main dir="ltr" class="product-page-main mx-auto grid max-w-[1440px] gap-6 px-4 py-6 xl:grid-cols-[1.22fr_0.95fr] xl:items-start xl:px-8 xl:py-8">
  <div dir="rtl" class="left-col order-1 xl:col-start-1 xl:flex xl:min-h-[720px] xl:h-full xl:w-full xl:flex-col xl:gap-5">
   <div class="gallery-slot">
    <div class="product-gallery flex gap-3 sm:gap-4">
     <div class="gallery-frame group relative aspect-[4/3] min-w-0 flex-1 overflow-hidden rounded-3xl border border-white/10 bg-plum-900 shadow-[0_25px_60px_-25px_rgba(0,0,0,0.9)] sm:aspect-[16/10] lg:aspect-auto lg:min-h-[560px]" data-stage>
      <img id="alpMain" src="<?php echo esc_url($d['slides'][0]['src']);?>" alt="<?php echo esc_attr($d['name']);?>" class="animate-slide-fade h-full w-full object-cover">
      <div class="absolute left-5 top-5 flex -rotate-3 items-center gap-2 rounded-xl bg-gradient-to-l from-gold-600 via-gold-500 to-[#8a5a2b] px-4 py-2.5 shadow-lg shadow-black/40 ring-1 ring-gold-300/60">
       <?php echo alookhor_cc_pdp_icon('leaf');?><span class="text-sm font-black text-cream">۱۰۰٪ طبیعی</span>
      </div>
      <div class="gallery-copy pointer-events-none absolute bottom-6 left-6 max-w-[60%]">
       <p class="font-script text-xl text-cream drop-shadow-[0_2px_10px_rgba(0,0,0,0.8)] sm:text-2xl">طعم اصیل<br>سلامتی طبیعی</p>
       <svg viewBox="0 0 160 12" class="mt-1 h-3 w-36 text-gold-400" fill="none"><path d="M2 8c40-6 90-6 156-2" stroke="currentColor" stroke-width="3" stroke-linecap="round"/></svg>
      </div>
      <span class="gallery-counter absolute right-4 top-4 rounded-full bg-plum-950/70 px-3 py-1 text-xs font-bold text-cream backdrop-blur-sm"><b data-gal-num>۱</b> / <?php echo esc_html($faNum(count($d['slides'])));?></span>
      <button type="button" data-gal-prev aria-label="تصویر قبلی" class="absolute right-4 top-1/2 grid h-11 w-11 -translate-y-1/2 place-items-center rounded-full border border-white/25 bg-plum-950/45 text-cream backdrop-blur-sm transition hover:border-gold-400 hover:bg-gold-400 hover:text-plum-950"><?php echo alookhor_cc_pdp_icon('chevr');?></button>
      <button type="button" data-gal-next aria-label="تصویر بعدی" class="absolute left-4 top-1/2 grid h-11 w-11 -translate-y-1/2 place-items-center rounded-full border border-white/25 bg-plum-950/45 text-cream backdrop-blur-sm transition hover:border-gold-400 hover:bg-gold-400 hover:text-plum-950"><?php echo alookhor_cc_pdp_icon('chevl');?></button>
      <button type="button" data-fs aria-label="نمایش تمام‌صفحه" class="gallery-expand absolute bottom-4 right-4 grid h-10 w-10 place-items-center rounded-xl border border-white/25 bg-plum-950/45 text-cream backdrop-blur-sm transition hover:border-gold-400 hover:text-gold-300"><?php echo alookhor_cc_pdp_icon('expand');?></button>
     </div>
     <div class="gallery-thumbs flex w-16 shrink-0 flex-col gap-3 sm:w-24" role="tablist" aria-label="گالری تصاویر محصول">
      <?php foreach($d['slides'] as $si=>$s):?><button type="button" role="tab" aria-label="<?php echo esc_attr($s['label']);?>" class="gallery-thumb relative aspect-square w-full overflow-hidden rounded-xl border-2 transition <?php echo $si===0?'border-gold-400 shadow-[0_0_0_3px_rgba(247,179,43,0.25)]':'border-white/10 opacity-70 hover:opacity-100';?>" data-src="<?php echo esc_url($s['src']);?>"><img src="<?php echo esc_url($s['src']);?>" alt="<?php echo esc_attr($s['label']);?>" class="h-full w-full object-cover" loading="lazy"></button><?php endforeach;?>
     </div>
    </div>
   </div>
   <div class="guarantees-glass-slot">
    <div class="guarantees-glass rounded-2xl border border-gold-400/20 bg-plum-900/70 p-4 backdrop-blur-md shadow-[0_20px_50px_-15px_rgba(0,0,0,0.8),0_0_30px_-10px_rgba(247,179,43,0.15)]">
      <div class="guarantees grid grid-cols-2 gap-3 sm:grid-cols-4">
        <div class="guarantee-item flex items-center justify-center gap-2.5 rounded-xl border border-white/10 bg-plum-950/70 px-4 py-4 text-xs font-black text-cream transition hover:border-gold-400/50 hover:bg-plum-900/80"><span class="h-6 w-6 shrink-0 text-gold-400"><?php echo alookhor_cc_pdp_icon('shield-check');?></span>ضمانت اصالت</div>
        <div class="guarantee-item flex items-center justify-center gap-2.5 rounded-xl border border-white/10 bg-plum-950/70 px-4 py-4 text-xs font-black text-cream transition hover:border-gold-400/50 hover:bg-plum-900/80"><span class="h-6 w-6 shrink-0 text-gold-400"><?php echo alookhor_cc_pdp_icon('box');?></span>بسته‌بندی بهداشتی</div>
        <div class="guarantee-item flex items-center justify-center gap-2.5 rounded-xl border border-white/10 bg-plum-950/70 px-4 py-4 text-xs font-black text-cream transition hover:border-gold-400/50 hover:bg-plum-900/80"><span class="h-6 w-6 shrink-0 text-gold-400"><?php echo alookhor_cc_pdp_icon('return');?></span>۷ روز ضمانت بازگشت</div>
        <div class="guarantee-item flex items-center justify-center gap-2.5 rounded-xl border border-white/10 bg-plum-950/70 px-4 py-4 text-xs font-black text-cream transition hover:border-gold-400/50 hover:bg-plum-900/80"><span class="h-6 w-6 shrink-0 text-gold-400"><?php echo alookhor_cc_pdp_icon('headset');?></span>پشتیبانی همیشگی</div>
      </div>
    </div>
   </div>
   <div class="banner-slot">
    <section class="promo-banner relative overflow-hidden rounded-3xl border border-gold-400/25 shadow-[0_25px_60px_-30px_rgba(0,0,0,0.9)]">
     <img src="<?php echo esc_url($img.'banner.jpg');?>" alt="آلو بخارایی طبیعی الخور" class="absolute inset-0 h-full w-full object-cover">
     <div class="absolute inset-0 bg-gradient-to-l from-plum-950/95 via-plum-950/70 to-plum-950/20"></div>
     <div class="relative flex flex-col gap-6 p-7 sm:flex-row sm:items-center sm:justify-between sm:p-9">
      <div><h2 class="text-2xl font-black text-cream sm:text-3xl">خوشمزه‌تر زندگی کن...</h2><p class="mt-2 text-sm font-medium text-lav sm:text-base">با محصولات طبیعی الخور</p></div>
      <a href="<?php echo esc_url($shop);?>" class="flex shrink-0 items-center gap-2 rounded-xl bg-gradient-to-l from-gold-300 via-gold-400 to-gold-500 px-6 py-3.5 text-sm font-black text-plum-950 shadow-[0_12px_30px_-10px_rgba(247,179,43,0.7)] transition hover:brightness-110 active:scale-[0.98]"><?php echo alookhor_cc_pdp_icon('chevl');?><span>مشاهده همه محصولات</span></a>
     </div>

    </section>
   </div>
  </div>
  <div dir="rtl" class="panel-slot order-2 xl:col-start-2 xl:row-start-1 xl:flex xl:min-h-[720px] xl:h-full xl:w-full xl:flex-col">
   <section class="product-panel alpm-panel flex flex-col gap-4 rounded-3xl border border-white/8 bg-gradient-to-b from-plum-700/70 to-plum-800/60 p-5 shadow-[0_30px_80px_-40px_rgba(0,0,0,0.9)] sm:p-6">
    <div class="product-heading">
     <button onclick="window.location.href='<?php echo esc_url($shop);?>'" class="mobile-category-badge hidden items-center gap-1.5 rounded-full border border-gold-400/30 bg-plum-900/70 px-3 py-1.5 text-xs font-black text-gold-300"><?php echo alookhor_cc_pdp_icon('leaf');?>آلو خشکبار</button>
     <div class="product-title-copy"><h1 class="text-3xl font-black text-cream sm:text-4xl"><?php echo esc_html($d['name']);?></h1><p class="mt-2 text-lg font-bold text-gold-400">طعم اصیل، سلامتی طبیعی</p></div>
     <p class="mt-4 text-sm leading-7 text-lav"><?php if($d['short']) echo esc_html(wp_strip_all_tags($d['short'])); else echo esc_html($d['name']).' آلوخور، انتخابی بی‌نظیر از باغات ایران، با طعمی دلنشین و کیفیتی ممتاز. مناسب برای مصرف روزانه، آشپزی و پذیرایی؛ بدون هیچ افزودنی، رنگ یا شکر افزوده.';?></p>
    </div>
    <div class="rating-row flex flex-col gap-2">
     <div class="flex flex-nowrap items-center gap-3">
      <div class="rating-summary flex items-center gap-1.5 shrink-0">
       <span class="flex items-center gap-0.5" aria-label="امتیاز ۴.۸ از ۵">
        <?php for($i=0;$i<5;$i++):?><span class="relative inline-block h-4.5 w-4.5"><span class="absolute inset-0 text-plum-500"><?php echo alookhor_cc_pdp_icon('star');?></span><span class="absolute inset-0 overflow-hidden" style="width:<?php echo $i<4?'100%':'80%';?>"><span class="text-gold-400"><?php echo alookhor_cc_pdp_icon('star');?></span></span></span><?php endfor;?>
       </span>
       <span class="text-sm font-black text-cream">۴٫۸ از ۵</span><span class="text-xs text-lav">(<?php echo esc_html($faNum($d['reviews']>0?$d['reviews']:133));?> نظر)</span>
      </div>
      <span class="rating-divider h-5 w-px bg-white/15 shrink-0"></span>
      <button type="button" class="favorite-action flex items-center gap-1.5 text-xs font-bold text-lav transition hover:text-berry shrink-0" data-wish aria-pressed="false"><span class="h-4.5 w-4.5"><?php echo alookhor_cc_pdp_icon('heart');?></span><span data-wish-label>افزودن به علاقه‌مندی‌ها</span></button>
     </div>
     <button type="button" class="share-action flex items-center gap-1.5 text-xs font-bold text-lav transition hover:text-gold-300 self-start" data-share data-name="<?php echo esc_attr($d['name']);?>" data-url="<?php echo esc_url(get_permalink($d['id']));?>"><span class="h-4.5 w-4.5"><?php echo alookhor_cc_pdp_icon('share');?></span>اشتراک‌گذاری</button>
    </div>
    <div class="product-features grid grid-cols-2 gap-3 xl:grid-cols-4">
     <?php foreach(array_slice($d['feats'],0,4) as $f):?><div class="feature-item flex flex-col items-center gap-1.5 rounded-2xl border border-white/8 bg-plum-900/50 px-2 py-4 text-center transition hover:border-gold-400/40 hover:bg-plum-900"><span class="h-6 w-6 text-gold-400"><?php echo alookhor_cc_pdp_icon($f[0]);?></span><span class="text-sm font-black text-cream"><?php echo esc_html($f[1]);?></span><span class="text-[11px] text-lav"><?php echo esc_html($f[2]);?></span></div><?php endforeach;?>
    </div>
    <div class="price-box rounded-2xl border border-white/8 bg-plum-950/50 p-4 text-center">
     <div class="flex items-center justify-between gap-3"><span class="text-xs font-bold text-lav">قیمت محصول:</span><?php if($d['discount']>0):?><span class="rounded-full bg-[#e42a68] px-3 py-1 text-[11px] font-black text-white shadow-[0_4px_12px_rgba(228,42,104,.35)]"><?php echo esc_html($faNum($d['discount']));?>٪ تخفیف</span><?php endif;?></div>
     <div class="mt-3 flex flex-col items-center justify-center gap-1">
      <?php if($d['discount']>0):?><span class="text-[12px] text-lav/60 line-through"><?php echo $price_old_html;?></span><?php endif;?>
      <span class="text-2xl sm:text-[28px] font-black text-gold-400 drop-shadow-[0_0_18px_rgba(247,179,43,0.65)] alp-price-now luminous-gold leading-tight" data-single="<?php echo esc_attr($price_single);?>"><?php echo $price_now_html;?></span>
     </div>
    </div>
    <?php if($show_weights):?>
    <div class="weight-qty-box rounded-2xl border border-white/8 bg-plum-900/50 p-3 backdrop-blur-sm">
      <div class="weight-picker">
        <span class="mb-2.5 block text-xs font-bold text-lav">انتخاب وزن:</span>
        <div class="weight-options grid grid-cols-3 gap-2" role="radiogroup" aria-label="انتخاب وزن">
          <?php foreach($d['options'] as $oi=>$o):?><button type="button" role="radio" aria-checked="<?php echo $oi===0?'true':'false';?>" class="weight-option flex flex-col items-center justify-center gap-1 rounded-xl border px-2 py-2.5 text-center transition <?php echo $oi===0?'border-gold-400 bg-gold-400/10 text-gold-300 shadow-[0_0_0_3px_rgba(247,179,43,0.15)]':'border-white/10 bg-plum-950/60 text-lav hover:border-white/25 hover:text-cream';?>" data-vid="<?php echo esc_attr($o['id']);?>" data-price="<?php echo esc_attr($o['price_html']?:$price_now_html);?>">
            <span class="text-[11px] font-black leading-tight"><?php echo esc_html($o['label']);?></span>
            <span class="text-[9px] font-bold text-lav/70"><?php echo $o['price_html']?wp_strip_all_tags($o['price_html']):wp_strip_all_tags($price_now_html);?></span>
          </button><?php endforeach;?>
        </div>
      </div>
    </div>
    <?php endif;?>
    <?php if($d['purchasable']&&$d['stock']!=='out'):?>
    <div class="purchase-actions flex flex-col gap-2.5 rounded-2xl border border-white/8 bg-plum-900/30 p-3">
      <div class="flex flex-wrap items-center gap-2">
        <div class="quantity-row flex items-center gap-2 shrink-0">
          <span class="quantity-label text-xs font-bold text-lav">تعداد:</span>
          <div class="quantity-control flex items-center gap-1 rounded-full border border-white/10 bg-plum-950/70 p-1">
            <button type="button" data-q="-" aria-label="کاهش تعداد" class="grid h-7 w-7 place-items-center rounded-full text-cream transition hover:bg-white/10 hover:text-gold-300"><span class="h-3 w-3"><?php echo alookhor_cc_pdp_icon('minus');?></span></button>
            <span class="w-7 text-center text-sm font-black text-cream" id="alpQty">۱</span>
            <button type="button" data-q="+" aria-label="افزایش تعداد" class="grid h-7 w-7 place-items-center rounded-full text-cream transition hover:bg-white/10 hover:text-gold-300"><span class="h-3 w-3"><?php echo alookhor_cc_pdp_icon('plus');?></span></button>
          </div>
        </div>
        <a id="alpAdd" href="<?php echo esc_url($d['add_url']);?>" data-base="<?php echo esc_attr($d['add_url']);?>" class="add-button flex h-10 flex-1 max-w-[200px] items-center justify-center gap-2 rounded-xl bg-gradient-to-l from-gold-300 via-gold-400 to-gold-500 text-[13px] font-black text-plum-950 shadow-[0_10px_30px_-10px_rgba(247,179,43,0.65)] transition hover:brightness-110 active:scale-[0.98]"><span>افزودن به سبد خرید</span><span class="h-4.5 w-4.5"><?php echo alookhor_cc_pdp_icon('cart');?></span></a>
        <div class="flex items-center gap-1.5 shrink-0">
          <button type="button" class="share-btn grid h-10 w-10 place-items-center rounded-xl border border-white/10 bg-plum-950/70 text-lav transition hover:border-gold-400/40 hover:text-gold-300" data-share data-name="<?php echo esc_attr($d['name']);?>" data-url="<?php echo esc_url(get_permalink($d['id']));?>" aria-label="اشتراک‌گذاری"><span class="h-4 w-4"><?php echo alookhor_cc_pdp_icon('share');?></span></button>
          <button type="button" class="compare-btn grid h-10 w-10 place-items-center rounded-xl border border-white/10 bg-plum-950/70 text-lav transition hover:border-gold-400/40 hover:text-gold-300" data-compare aria-label="مقایسه"><span class="h-4 w-4"><?php echo alookhor_cc_pdp_icon('compare');?></span></button>
          <button type="button" class="wishlist-btn grid h-10 w-10 place-items-center rounded-xl border border-white/10 bg-plum-950/70 text-lav transition hover:border-berry/40 hover:text-berry" data-wish aria-pressed="false" aria-label="علاقه‌مندی"><span class="h-4 w-4"><?php echo alookhor_cc_pdp_icon('heart');?></span></button>
        </div>
      </div>
      <div class="shipping-line flex flex-wrap items-center justify-between gap-2 text-[11px] font-bold"><span class="flex items-center gap-1.5 text-mint"><span class="relative flex h-2 w-2"><span class="absolute inline-flex h-full w-full animate-ping rounded-full bg-mint opacity-60"></span><span class="relative inline-flex h-2 w-2 rounded-full bg-mint"></span></span>موجود در انبار</span><span class="text-lav/70">ارسال از ۱ روز کاری آینده</span></div>
    </div>
    <?php endif;?>
    </section>
  </div>
 </main>

 <div class="below-product mx-auto max-w-[1440px] px-4 lg:px-8">
  <section id="story" class="below-section about-story scroll-mt-28">
   <div class="about-story-media"><img src="<?php echo esc_url($img.'about.jpg');?>" alt="آلوهای طبیعی الخور در کاسه چوبی" loading="lazy"><div class="about-story-badge"><span class="h-6 w-6"><?php echo alookhor_cc_pdp_icon('leaf');?></span><strong>۱۰۰٪ خالص</strong><span>از باغ تا خانه شما</span></div></div>
   <div class="about-story-copy"><span class="section-kicker">از دل باغ‌های ایران</span><h2>درباره ما؛ الخور، انتخاب خانواده‌ها</h2><p>ما در الخور باور داریم طعم واقعی، نیازی به پنهان شدن پشت افزودنی‌ها ندارد. آلوها را از باغدارهای مورد اعتماد شمال ایران تهیه می‌کنیم و با دقتی که شایسته سفره شماست، آماده می‌کنیم.</p><p>هر بسته الخور حاصل همراهی کشاورز، تجربه نسل‌ها و کنترل کیفیت دقیق است؛ تا هر بار که در بسته را باز می‌کنید، عطر یک محصول اصیل ایرانی را حس کنید.</p><ul class="about-checks"><li><span class="h-4 w-4 text-gold-400"><?php echo alookhor_cc_pdp_icon('check');?></span> خرید مستقیم از کشاورز</li><li><span class="h-4 w-4 text-gold-400"><?php echo alookhor_cc_pdp_icon('check');?></span> دست‌چین و سورت‌شده</li><li><span class="h-4 w-4 text-gold-400"><?php echo alookhor_cc_pdp_icon('check');?></span> ارسال تازه و بهداشتی</li></ul><a href="<?php echo esc_url($about);?>" class="outline-gold-button">داستان الخور <span class="h-4 w-4"><?php echo alookhor_cc_pdp_icon('chevl');?></span></a></div>
  </section>

  <section class="below-section specs-section"><div class="below-section-title flex items-end justify-between gap-4"><div><span class="mb-2 block text-xs font-black tracking-wide text-gold-400">اصالت را لمس کنید</span><h2 class="text-xl font-black text-cream sm:text-2xl">مشخصات محصول</h2></div></div><div class="specs-layout"><div class="specs-visual"><img src="<?php echo esc_url($img.'assortment.jpg');?>" alt="خشکبار و میوه خشک الخور" loading="lazy"><div class="specs-visual-caption"><span>انتخاب الخور</span><strong>طبیعی، تازه، قابل اعتماد</strong></div></div><div class="specs-grid"><?php foreach(array_slice($d['specs'],0,6) as $spec):?><div class="spec-item"><span class="h-6 w-6 text-gold-400"><?php echo alookhor_cc_pdp_icon($spec[0]==='نوع محصول'?'leaf':($spec[0]==='نوع بسته‌بندی'?'box':($spec[0]==='ماندگاری'?'clock':($spec[0]==='ارسال'?'truck':'gem'))));?></span><div><span><?php echo esc_html($spec[0]);?></span><strong><?php echo esc_html($spec[1]);?></strong></div></div><?php endforeach;?></div></div></section>

  <section class="below-section"><div class="slider-glass"><div class="below-section-title flex items-end justify-between gap-4"><div><span class="mb-2 block text-xs font-black tracking-wide text-gold-400">پیشنهادهای خوش‌طعم الخور</span><h2 class="text-xl font-black text-cream sm:text-2xl">گزیده‌ای از بهترین آلو بخارایی</h2></div></div><div class="slider-shell"><div class="slider-controls"><button type="button" class="slider-control slider-control-prev" data-hprev><span class="h-4 w-4"><?php echo alookhor_cc_pdp_icon('chevr');?></span></button><button type="button" class="slider-control slider-control-next" data-hnext><span class="h-4 w-4"><?php echo alookhor_cc_pdp_icon('chevl');?></span></button></div><div class="highlight-track horizontal-track" data-htrack><?php $highlights=[['title'=>'آلو بخارایی','sub'=>'ترش و شیرین','image'=>$img.'about.jpg'],['title'=>'قیسی آفتابی','sub'=>'نرم و طلایی','image'=>$img.'single.jpg'],['title'=>'برگه زردآلو','sub'=>'طبیعی و خوش‌عطر','image'=>$img.'sack.jpg'],['title'=>'خشکبار مجلسی','sub'=>'برای پذیرایی','image'=>$img.'assortment.jpg']]; foreach($highlights as $h):?><a href="<?php echo esc_url($shop);?>" class="highlight-card group"><div class="highlight-image"><img src="<?php echo esc_url($h['image']);?>" alt="<?php echo esc_attr($h['title']);?>" loading="lazy"><span class="highlight-arrow"><span class="h-4 w-4"><?php echo alookhor_cc_pdp_icon('chevl');?></span></span></div><span class="mt-3 block text-sm font-black text-cream"><?php echo esc_html($h['title']);?></span><span class="mt-1 block text-xs text-lav"><?php echo esc_html($h['sub']);?></span></a><?php endforeach;?></div></div></div></section>

  <?php if(!empty($d['related'])):?>
  <section class="below-section"><div class="slider-glass"><div class="below-section-title flex items-end justify-between gap-4"><div><span class="mb-2 block text-xs font-black tracking-wide text-gold-400">برای شما آماده کرده‌ایم</span><h2 class="text-xl font-black text-cream sm:text-2xl">محصولات پیشنهادی برای شما</h2></div></div><div class="slider-shell"><div class="slider-controls"><button type="button" class="slider-control slider-control-prev" data-pprev><span class="h-4 w-4"><?php echo alookhor_cc_pdp_icon('chevr');?></span></button><button type="button" class="slider-control slider-control-next" data-pnext><span class="h-4 w-4"><?php echo alookhor_cc_pdp_icon('chevl');?></span></button></div><div class="products-track horizontal-track" data-ptrack><?php foreach($d['related'] as $rid) echo alookhor_cc_pdp_card($rid);?></div></div></div></section>
  <?php endif;?>

  <section class="below-section faq-section"><div class="below-section-title flex items-end justify-between gap-4"><div><span class="mb-2 block text-xs font-black tracking-wide text-gold-400">پاسخ پرسش‌های شما</span><h2 class="text-xl font-black text-cream sm:text-2xl">سوالات متداول</h2></div></div><div class="faq-list"><?php foreach($d['faqs'] as $fi=>$faq):?><div class="faq-item" data-faq><button type="button" aria-expanded="false"><span><?php echo esc_html($faq['q']);?></span><span class="faq-icon"><span class="h-4 w-4 icon-plus"><?php echo alookhor_cc_pdp_icon('plus');?></span><span class="h-4 w-4 icon-minus hidden"><?php echo alookhor_cc_pdp_icon('minus');?></span></span></button><div class="faq-answer"><p><?php echo esc_html($faq['a']);?></p></div></div><?php endforeach;?></div></section>

  <section class="below-section reviews-section"><div class="reviews-glass"><div class="reviews-heading-row"><div class="below-section-title flex items-end justify-between gap-4"><div><span class="mb-2 block text-xs font-black tracking-wide text-gold-400">تجربه خرید واقعی</span><h2 class="text-xl font-black text-cream sm:text-2xl">نظرات مشتریان</h2></div></div><button type="button" class="review-cta" data-review-cta>نوشتن نظر <span class="h-4 w-4"><?php echo alookhor_cc_pdp_icon('chevl');?></span></button></div><div class="reviews-content-row"><div class="reviews-summary"><strong>۴٫۹</strong><span class="flex items-center gap-0.5 text-gold-400"><?php echo str_repeat(alookhor_cc_pdp_icon('star'),5);?></span><span>از مجموع <?php echo esc_html($faNum(132));?> نظر ثبت‌شده</span></div><div class="slider-shell reviews-slider-shell"><div class="slider-controls"><button type="button" class="slider-control slider-control-prev" data-rprev><span class="h-4 w-4"><?php echo alookhor_cc_pdp_icon('chevr');?></span></button><button type="button" class="slider-control slider-control-next" data-rnext><span class="h-4 w-4"><?php echo alookhor_cc_pdp_icon('chevl');?></span></button></div><div class="reviews-track horizontal-track" data-rtrack><?php $mock_reviews=[['name'=>'مریم رضایی','city'=>'تهران','avatar'=>'م','text'=>'بسته‌بندی خیلی تمیز بود و خود آلوها طعم طبیعی و بافت نرمی داشتند. دوباره سفارش می‌دهم.'],['name'=>'علی احمدی','city'=>'رشت','avatar'=>'ع','text'=>'کیفیتش نسبت به نمونه‌هایی که قبلاً خریده بودم واقعاً بهتر بود؛ نه زیادی شیرین و نه خشک و سفت.'],['name'=>'نسترن کریمی','city'=>'اصفهان','avatar'=>'ن','text'=>'برای پذیرایی سفارش دادم و همه از طعمش تعریف کردند. ارسال هم سریع‌تر از چیزی بود که انتظار داشتم.']]; $all_reviews = !empty($d['reviews_list']) ? $d['reviews_list'] : $mock_reviews; foreach($all_reviews as $rv):?><article class="review-card"><div class="review-head"><div class="review-avatar"><?php echo esc_html($rv['avatar']??mb_substr($rv['name'],0,1));?></div><div><strong><?php echo esc_html($rv['name']);?></strong><span><?php echo esc_html($rv['city']??$rv['date']??''); ?></span></div><span class="flex items-center gap-0.5 text-gold-400"><?php echo str_repeat(alookhor_cc_pdp_icon('star'),5);?></span></div><p>«<?php echo esc_html($rv['text']);?>»</p><?php if(!empty($rv['verified'])): ?><span class="review-verified"><span class="h-3 w-3"><?php echo alookhor_cc_pdp_icon('check');?></span> خرید تأییدشده</span><?php else: ?><span class="review-verified"><span class="h-3 w-3"><?php echo alookhor_cc_pdp_icon('check');?></span> خرید تأییدشده</span><?php endif;?></article><?php endforeach;?></div></div></div></div></section>

  <section class="newsletter-section"><img src="<?php echo esc_url($img.'newsletter.jpg');?>" alt="آلوهای تازه الخور" loading="lazy"><div class="newsletter-overlay"></div><div class="newsletter-content"><span class="section-kicker">همیشه یک طعم تازه</span><h2>در خبرنامه الخور عضو شوید</h2><p>از تخفیف‌ها، محصولات تازه و قصه‌های باغ‌های ایران زودتر باخبر شوید.</p><form class="newsletter-form" data-newsletter><div><span class="h-4.5 w-4.5 text-gold-400"><?php echo alookhor_cc_pdp_icon('mail');?></span><input type="email" placeholder="ایمیل شما" aria-label="ایمیل شما" required></div><button type="submit">عضویت</button></form></div></section>
 </div>

 <div class="pointer-events-none fixed inset-x-0 bottom-6 z-[60] flex justify-center px-4" data-toast hidden><div class="flex items-center gap-3 rounded-full border border-gold-400/40 bg-plum-800/95 px-6 py-3.5 text-sm font-bold text-cream shadow-2xl shadow-black/60 backdrop-blur-md"><span class="grid h-6 w-6 shrink-0 place-items-center rounded-full bg-gold-400 text-plum-950"><span class="h-3.5 w-3.5"><?php echo alookhor_cc_pdp_icon('check');?></span></span><span data-toast-msg></span></div></div>
</section>

<div class="alp-sticky" data-name="<?php echo esc_attr($d['name']);?>"><span class="alp-sticky-p"><?php echo $price_now_html;?></span><?php if($d['purchasable']&&$d['stock']!=='out'):?><a href="<?php echo esc_url($d['add_url']);?>" data-base="<?php echo esc_attr($d['add_url']);?>" class="alp-cta"><?php echo alookhor_cc_pdp_icon('bag');?><span>افزودن به سبد خرید</span></a><?php endif;?></div>

<script type="application/ld+json"><?php
 $ld=['@context'=>'https://schema.org','@type'=>'Product','name'=>$d['name'],'image'=>$d['slides'][0]['src'],'sku'=>$d['sku'],'inLanguage'=>'fa-IR','brand'=>['@type'=>'Brand','name'=>'ALOOKHOR'],'offers'=>['@type'=>'Offer','price'=>$d['price'],'priceCurrency'=>(function_exists('get_woocommerce_currency')?get_woocommerce_currency():'IRR'),'availability'=>'https://schema.org/'.($d['in_stock']?'InStock':'OutOfStock'),'url'=>get_permalink($product->get_id()),'itemCondition'=>'https://schema.org/NewCondition']];
 if(!empty($d['short'])){$ld['description']=wp_trim_words(wp_strip_all_tags($d['short']),30,'…');}
 if(!empty($d['rating'])&&(float)$d['rating']>0&&!empty($d['reviews'])&&(int)$d['reviews']>0){$ld['aggregateRating']=['@type'=>'AggregateRating','ratingValue'=>(string)$d['rating'],'reviewCount'=>(string)(int)$d['reviews'],'bestRating'=>'5','worstRating'=>'1'];}
 echo wp_json_encode($ld,JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_UNICODE);
?></script>
<?php
 $GLOBALS['alookhor_cc_pdp_done']=true;
 return ob_get_clean();
}
}


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
 if(function_exists('alookhor_cc_footer_markup')){
  echo alookhor_cc_footer_markup();
  $GLOBALS['alookhor_cc_footer_shortcode_rendered']=true;
  $GLOBALS['alookhor_cc_footer_done']=true;
 }
 if(function_exists('WC')&&WC()&&isset(WC()->structured_data)&&is_object(WC()->structured_data)){
  remove_action('wp_footer',[WC()->structured_data,'output_structured_data_json']);
  remove_action('wp_footer',[WC()->structured_data,'output_structured_data'],40);
 }
 wp_footer();
 echo '</body></html>';
 exit;
},55);

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
 wp_enqueue_style('alookhor-cc-pdp-react',ALOOKHOR_CC_URL.'assets/css/frontend-product-react.css',[],ALOOKHOR_CC_BUILD);
 wp_enqueue_style('alookhor-cc-pdp',ALOOKHOR_CC_URL.'assets/css/frontend-product.css',[],ALOOKHOR_CC_BUILD);
 wp_enqueue_script('alookhor-cc-pdp',ALOOKHOR_CC_URL.'assets/js/frontend-product.js',[],ALOOKHOR_CC_BUILD,true);
 wp_enqueue_style('alookhor-cc-nastaliq','https://fonts.googleapis.com/css2?family=Noto+Nastaliq+Arabic:wght@600&family=Vazirmatn:wght@300;400;500;700;800;900&display=swap',[],null);
});
