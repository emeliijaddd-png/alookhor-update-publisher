<?php
/** Luxury about page — [alookhor_about_page]. */
if(!defined('ABSPATH'))exit;

function alookhor_cc_about_url(){static $url=null;if($url!==null)return $url;$id=(int)get_option('alookhor_about_page_id',0);$page=$id?get_post($id):null;if(!$page)$page=get_page_by_path('about',OBJECT,'page');if(!$page){$page=get_page_by_path('درباره-ما',OBJECT,'page');}if(!$page)$page=get_page_by_title('درباره ما',OBJECT,'page');$url=$page?get_permalink($page):home_url('/about/');return $url;}

function alookhor_cc_about_settings(){
 $header=function_exists('alookhor_cc_front_header_settings')?alookhor_cc_front_header_settings():[];
 $state=alookhor_cc_get_settings();$footer=(array)($state['footer_settings']??[]);
 $gold=(string)($header['gold']??'');if(!preg_match('/^#[0-9a-fA-F]{6}$/',$gold))$gold='#D4AF37';
 return ['address'=>$footer['address']??'خراسان رضوی، خور نیشابور','gold'=>$gold];
}

function alookhor_cc_about_icon($name){$p=['leaf'=>'<path d="M5 19C5 9 11 4 21 3c0 10-5 16-15 16Z"/><path d="M5 19c3-5 7-8 11-10"/>','star'=>'<path d="m12 3 2.7 5.7 6.3.8-4.6 4.3 1.2 6.2L12 17l-5.6 3 1.2-6.2L3 9.5l6.3-.8L12 3Z"/>','globe'=>'<circle cx="12" cy="12" r="9"/><path d="M3 12h18M12 3c2.5 2.5 4 5.5 4 9s-1.5 6.5-4 9c-2.5-2.5-4-5.5-4-9s1.5-6.5 4-9Z"/>','shield'=>'<path d="M12 3 5 6v5c0 4.5 3 8.5 7 10 4-1.5 7-5.5 7-10V6l-7-3Z"/><path d="m9 12 2 2 4-4"/>','gem'=>'<path d="M7 3h10l4 6-9 12L3 9l4-6Z"/><path d="M3 9h18M9.5 9 12 21 14.5 9 12 3 9.5 9Z"/>','sun'=>'<circle cx="12" cy="12" r="4"/><path d="M12 2v3M12 19v3M2 12h3M19 12h3M4.5 4.5 6.6 6.6M17.4 17.4l2.1 2.1M19.5 4.5 17.4 6.6M6.6 17.4l-2.1 2.1"/>','box'=>'<path d="m12 3 8 4.5v9L12 21l-8-4.5v-9L12 3Z"/><path d="M4 7.5 12 12l8-4.5M12 12v9"/>','truck'=>'<path d="M3 6h11v10H3zM14 9h4l3 3v4h-7z"/><circle cx="7" cy="18" r="1.8"/><circle cx="17.5" cy="18" r="1.8"/>','sprout'=>'<path d="M12 21v-8"/><path d="M12 13c0-4-3-6-8-6 0 5 3 7 8 6Z"/><path d="M12 13c0-4 3-6 8-6 0 5-3 7-8 6Z"/>','sort'=>'<path d="M4 7h16M6 12h12M9 17h6"/>','heart'=>'<path d="M12 20s-7-4.5-9-9c-1.2-2.8.6-6 3.7-6C9 5 10.8 6.5 12 8c1.2-1.5 3-3 5.3-3 3.1 0 4.9 3.2 3.7 6-2 4.5-9 9-9 9Z"/>','pin'=>'<path d="M20 10c0 6-8 12-8 12S4 16 4 10a8 8 0 1 1 16 0Z"/><circle cx="12" cy="10" r="2.5"/>','chevron'=>'<path d="m6 9 6 6 6-6"/>'];return '<svg viewBox="0 0 24 24" aria-hidden="true">'.($p[$name]??$p['star']).'</svg>';}

function alookhor_cc_about_markup(){
 $c=alookhor_cc_about_settings();$img=ALOOKHOR_CC_URL.'assets/images/';$contact=alookhor_cc_contact_url();
 ob_start();?>
<section id="alookhor-about-page" class="alookhor-ab" dir="rtl" style="--ab-gold:<?php echo esc_attr($c['gold']);?>">
 <div class="ab-inner">
  <header class="ab-hero">
   <span class="ab-kicker">ABOUT • ALOOKHOR</span>
   <h1>داستانِ <b>آلوخور</b></h1>
   <p>از باغ‌های آلو بخارا در خراسان تا میز خانواده‌ها در سراسر جهان؛ باور ساده‌ای که آلوخور از روز اول با آن ساخته شده است: طبیعتِ خور، سورتِ دقیق و اعتمادِ شما.</p>
   <ul class="ab-chips">
    <li><?php echo alookhor_cc_about_icon('pin');?><span>خور نیشابور، خراسان</span></li>
    <li><?php echo alookhor_cc_about_icon('star');?><span>کیفیت صادراتی</span></li>
    <li><?php echo alookhor_cc_about_icon('globe');?><span>ارسال به سراسر جهان</span></li>
   </ul>
  </header>
  <div class="ab-story">
   <figure class="ab-media ab-reveal" data-reveal>
    <span class="ab-ring" aria-hidden="true"></span>
    <img src="<?php echo esc_url($img.'category-plums.jpg');?>" alt="آلو بخارا ممتاز خراسان" loading="lazy">
    <figcaption class="ab-badge"><?php echo alookhor_cc_about_icon('leaf');?><span>۱۰۰٪ طبیعی</span></figcaption>
   </figure>
   <div class="ab-body ab-reveal" data-reveal>
    <span class="ab-kicker">OUR STORY</span>
    <h2>از خور نیشابور، برای جهان</h2>
    <p>آلوخور در سرزمین آلو بخارا متولد شد؛ جایی که خاک، آفتاب و دست‌های هنرمند خراسان میوه‌ای می‌سازند که طعمش را هیچ‌جا تکرار نمی‌کنند. ما همین موهبت طبیعی را، بدون هیچ افزودنی، با شما به اشتراک می‌گذاریم.</p>
    <p>هر محصول، از باغ انتخاب و پس از سورت دقیق، فرآوری و بسته‌بندی بهداشتی می‌شود تا همان کیفیتی که از باغ برمی‌داریم، دست‌نخورده به خانه شما برسد؛ از خرید خانگی تا تأمین عمده و صادرات.</p>
    <div class="ab-sign"><b>آلوخور</b><small>از خور به جهان</small></div>
   </div>
  </div>
  <div class="ab-stats">
   <div class="ab-stat ab-reveal" data-reveal><i><?php echo alookhor_cc_about_icon('leaf');?></i><b>۱۰۰٪ طبیعی</b><small>بدون مواد افزودنی</small></div>
   <div class="ab-stat ab-reveal" data-reveal><i><?php echo alookhor_cc_about_icon('gem');?></i><b>کیفیت صادراتی</b><small>استاندارد بازارهای جهانی</small></div>
   <div class="ab-stat ab-reveal" data-reveal><i><?php echo alookhor_cc_about_icon('globe');?></i><b>+۱۵۰ کشور</b><small>مقصد ارسال آلوخور</small></div>
   <div class="ab-stat ab-reveal" data-reveal><i><?php echo alookhor_cc_about_icon('shield');?></i><b>کنترل کیفیت</b><small>از باغ تا بسته‌بندی</small></div>
  </div>
  <section class="ab-journey">
   <header class="ab-reveal" data-reveal><span class="ab-kicker">JOURNEY</span><h2>از باغ تا خانه شما</h2></header>
   <ol class="ab-steps">
    <li class="ab-reveal" data-reveal><i><?php echo alookhor_cc_about_icon('sprout');?></i><b>برداشت از باغ</b><span>انتخاب میوه از باغ‌های خراسان در فصل برداشت</span></li>
    <li class="ab-reveal" data-reveal><i><?php echo alookhor_cc_about_icon('sort');?></i><b>سورت دقیق</b><span>پاک‌سازی و دسته‌بندی یکدست، فقط محصول ممتاز</span></li>
    <li class="ab-reveal" data-reveal><i><?php echo alookhor_cc_about_icon('box');?></i><b>بسته‌بندی بهداشتی</b><span>بسته‌بندی مطمئن، آماده ارسال خانگی و صادراتی</span></li>
    <li class="ab-reveal" data-reveal><i><?php echo alookhor_cc_about_icon('truck');?></i><b>ارسال به جهان</b><span>تحویل سریع به سراسر ایران و جهان</span></li>
   </ol>
  </section>
  <section class="ab-values">
   <header class="ab-reveal" data-reveal><span class="ab-kicker">VALUES</span><h2>ارزش‌هایی که آلوخور را می‌سازند</h2></header>
   <div class="ab-values-grid">
    <article class="ab-value ab-reveal" data-reveal><i><?php echo alookhor_cc_about_icon('gem');?></i><h3>اصالت</h3><p>طعم واقعی خشکبار خراسان، بدون تقلب و بدون افزودنی.</p></article>
    <article class="ab-value ab-reveal" data-reveal><i><?php echo alookhor_cc_about_icon('star');?></i><h3>کیفیت</h3><p>سخت‌گیری در هر مرحله؛ از انتخاب باغ تا بسته‌بندی نهایی.</p></article>
    <article class="ab-value ab-reveal" data-reveal><i><?php echo alookhor_cc_about_icon('shield');?></i><h3>شفافیت</h3><p>آنچه می‌بینید همان است که می‌خورید؛ صادقانه و بی‌واسطه.</p></article>
    <article class="ab-value ab-reveal" data-reveal><i><?php echo alookhor_cc_about_icon('heart');?></i><h3>اعتماد</h3><p>اعتماد شما سرمایه ماست و پایه هر سفارش، از خانه تا کسب‌وکار.</p></article>
   </div>
  </section>
  <section class="ab-export ab-reveal" data-reveal>
   <div class="ab-export-body">
    <span class="ab-kicker">WHOLESALE & EXPORT</span>
    <h2>همکار کسب‌وکارها هستید؟</h2>
    <p>تأمین پایدار، قیمت همکاری و بسته‌بندی صادراتی برای فروشگاه‌ها، برندها و بازرگانان؛ تیم بازرگانی آلوخور کنار شماست.</p>
    <div class="ab-ctas">
     <a class="ab-cta is-gold" href="<?php echo esc_url($contact);?>">درخواست همکاری</a>
     <a class="ab-cta" href="<?php echo esc_url(home_url('/shop/'));?>">مشاهده محصولات</a>
    </div>
   </div>
  </section>
  <footer class="ab-foot">
   <i><?php echo alookhor_cc_about_icon('pin');?></i>
   <p><?php echo esc_html($c['address']);?> — <b>از خور به جهان</b></p>
  </footer>
 </div>
</section>
<?php return ob_get_clean();}

function alookhor_cc_about_shortcode(){return alookhor_cc_about_markup();}
add_shortcode('alookhor_about_page','alookhor_cc_about_shortcode');

function alookhor_cc_is_about_page(){if(!function_exists('is_page')||!is_page())return false;$id=(int)get_queried_object_id();if(!$id)return false;$ids=array_filter([(int)get_option('alookhor_about_page_id',0)]);$slug=get_post_field('post_name',$id);return in_array($id,$ids,true)||in_array($slug,['about','درباره-ما'],true);}

/**
 * Schema v1 — the luxury managed about page.
 * The menu already links to /about/ which 404s in WordPress; a published page is guaranteed at slug
 * `about` carrying the managed shortcode. Existing demo/draft pages holding the slug or the Persian
 * title are captured with a reversible backup, adopted and stripped of Elementor demo data.
 */
add_action('init',function(){
 if(get_option('alookhor_about_page_schema')==='1')return;
 $backup=function($page,$extra=[]){if(!$page||get_post_meta($page->ID,'_alookhor_about_backup',true))return;update_post_meta($page->ID,'_alookhor_about_backup',array_merge(['content'=>$page->post_content,'title'=>$page->post_title,'slug'=>$page->post_name,'elementor_data'=>get_post_meta($page->ID,'_elementor_data',true),'saved_at'=>current_time('mysql')],$extra));};
 $strip=function($page){delete_post_meta($page->ID,'_elementor_data');delete_post_meta($page->ID,'_elementor_edit_mode');delete_post_meta($page->ID,'_elementor_template_type');delete_post_meta($page->ID,'_elementor_version');};
 $adopt=function($page)use($backup,$strip){$backup($page);wp_update_post(['ID'=>$page->ID,'post_status'=>'publish','post_title'=>'درباره ما','post_content'=>'[alookhor_about_page]']);$strip($page);return $page;};
 $page=get_page_by_path('about',OBJECT,'page');
 if(!$page){
  $holders=get_posts(['post_type'=>'page','post_name__in'=>['about','درباره-ما'],'numberposts'=>1]);
  $page=$holders?$holders[0]:null;
 }
 if(!$page)$page=get_page_by_title('درباره ما',OBJECT,'page');
 if(!$page){
  foreach(['关于我们','About Us','About']as $t){$page=get_page_by_title($t,OBJECT,'page');if($page)break;}
 }
 if(!$page){$id=wp_insert_post(['post_type'=>'page','post_status'=>'publish','post_title'=>'درباره ما','post_name'=>'about','post_content'=>'[alookhor_about_page]']);$page=$id?get_post($id):null;}
 if($page){$adopt($page);update_option('alookhor_about_page_id',(int)$page->ID,false);update_option('rewrite_rules','');}
 /* adopt any other stray about-titled page so it never shows demo content */
 foreach(get_posts(['post_type'=>'page','s'=>'درباره ما','post_status'=>'any','numberposts'=>5,'fields'=>'ids'])as $sid){$sp=get_post($sid);if($sp&&$sp->ID!==(int)get_option('alookhor_about_page_id',0)&&!get_post_meta($sp->ID,'_alookhor_about_backup',true)){$backup($sp,['kind'=>'stray_about']);wp_update_post(['ID'=>$sp->ID,'post_content'=>'[alookhor_about_page]']);$strip($sp);}}
 if(function_exists('rocket_clean_domain'))rocket_clean_domain();
 if(function_exists('w3tc_flush_all'))w3tc_flush_all();
 if(function_exists('wp_cache_clear_cache'))wp_cache_clear_cache();
 if(function_exists('sg_cachepress_purge_everything'))sg_cachepress_purge_everything();
 if(defined('LSCWP_DIR'))do_action('litespeed_purge_all');
 update_option('alookhor_about_page_schema','1',false);
},40);

add_filter('nav_menu_link_attributes',function($atts,$item){$label=wp_strip_all_tags($item->title??'');$href=(string)($atts['href']??'');$path=trim((string)wp_parse_url($href,PHP_URL_PATH),'/');if(str_contains($label,'درباره ما')||str_contains($label,'درباره آلوخور')||$path==='about'||$path==='درباره-ما')$atts['href']=alookhor_cc_about_url();return $atts;},20,2);

/**
 * Schema v2 — canonical slug `about` (the menu target), loop-safe redirects.
 * v1 adopted the demo page but its slug stayed «درباره-ما», so /about/ (the menu link) kept 404ing.
 * The managed page is now forced onto slug `about`: any other page holding the slug is captured
 * with a versioned option backup and removed first. Both legacy paths redirect loop-safely.
 */
add_action('init',function(){
 if(get_option('alookhor_about_page_schema')==='2')return;
 $page_id=(int)get_option('alookhor_about_page_id',0);
 $page=$page_id?get_post($page_id):null;
 if(!$page)$page=get_page_by_path('about',OBJECT,'page');
 if(!$page)$page=get_page_by_path('درباره-ما',OBJECT,'page');
 if(!$page)$page=get_page_by_title('درباره ما',OBJECT,'page');
 if(!$page){$id=wp_insert_post(['post_type'=>'page','post_status'=>'publish','post_title'=>'درباره ما','post_name'=>'about','post_content'=>'[alookhor_about_page]']);$page=$id?get_post($id):null;}
 if(!$page)return;
 /* free the `about` slug if a different page holds it */
 $holder=get_page_by_path('about',OBJECT,'page');
 if($holder&&$holder->ID!==$page->ID){
  update_option('alookhor_about_slug_holder',['id'=>$holder->ID,'title'=>$holder->post_title,'slug'=>$holder->post_name,'content'=>$holder->post_content,'elementor_data'=>get_post_meta($holder->ID,'_elementor_data',true),'saved_at'=>current_time('mysql')],false);
  wp_delete_post($holder->ID,true);
 }
 $update=['ID'=>$page->ID,'post_status'=>'publish','post_title'=>'درباره ما','post_content'=>'[alookhor_about_page]'];
 if($page->post_name!=='about'){$update['post_name']='about';update_option('rewrite_rules','');}
 wp_update_post($update);
 delete_post_meta($page->ID,'_elementor_data');delete_post_meta($page->ID,'_elementor_edit_mode');delete_post_meta($page->ID,'_elementor_template_type');delete_post_meta($page->ID,'_elementor_version');
 update_option('alookhor_about_page_id',(int)$page->ID,false);
 if(function_exists('rocket_clean_domain'))rocket_clean_domain();
 if(function_exists('w3tc_flush_all'))w3tc_flush_all();
 if(function_exists('wp_cache_clear_cache'))wp_cache_clear_cache();
 if(function_exists('sg_cachepress_purge_everything'))sg_cachepress_purge_everything();
 if(defined('LSCWP_DIR'))do_action('litespeed_purge_all');
 update_option('alookhor_about_page_schema','2',false);
},41);

add_action('init',function(){if(is_admin()||(defined('REST_REQUEST')&&REST_REQUEST)||defined('DOING_CRON'))return;$path=trim((string)wp_parse_url(rawurldecode((string)($_SERVER['REQUEST_URI']??'/')),PHP_URL_PATH),'/');if($path!=='about'&&$path!=='درباره-ما')return;$target=alookhor_cc_about_url();$target_path=trim((string)wp_parse_url($target,PHP_URL_PATH),'/');if($target_path===''||$target_path===$path)return;nocache_headers();wp_safe_redirect($target,301);exit;},1);

add_filter('pre_get_document_title',function($title){return alookhor_cc_is_about_page()?'درباره ما | آلوخور':$title;},20);
add_filter('document_title_parts',function($parts){if(!alookhor_cc_is_about_page())return $parts;$parts['title']='درباره ما';$parts['site']='آلوخور';unset($parts['tagline'],$parts['page']);return $parts;},20);

add_action('wp_head',function(){if(!alookhor_cc_is_about_page())return;$d='داستان آلوخور — از باغ‌های آلو بخارا در خور نیشابور تا ارسال خشکبار طبیعی به سراسر جهان.';echo '<meta name="description" content="'.esc_attr($d).'">'."\n".'<meta property="og:title" content="درباره ما | آلوخور">'."\n".'<meta property="og:description" content="'.esc_attr($d).'">'."\n".'<meta property="og:type" content="website">'."\n".'<meta property="og:url" content="'.esc_url(alookhor_cc_about_url()).'">'."\n";},5);

add_filter('body_class',function($classes){if(alookhor_cc_is_about_page())$classes[]='alookhor-about-body';return $classes;});

add_action('wp_enqueue_scripts',function(){wp_enqueue_style('alookhor-cc-about',ALOOKHOR_CC_URL.'assets/css/frontend-about-page.css',[],ALOOKHOR_CC_BUILD);wp_enqueue_script('alookhor-cc-about',ALOOKHOR_CC_URL.'assets/js/frontend-about-page.js',[],ALOOKHOR_CC_BUILD,true);wp_localize_script('alookhor-cc-about','ALOOKHOR_ABOUT',['about_url'=>alookhor_cc_about_url()]);});
