<?php
/** Professional contact page V2 — [alookhor_contact_page]. */
if(!defined('ABSPATH'))exit;

function alookhor_cc_contact_url(){static $url=null;if($url!==null)return $url;$page=get_page_by_path('تماس-با-ما',OBJECT,'page');if(!$page)$page=get_page_by_title('تماس با ما',OBJECT,'page');$url=$page?get_permalink($page):home_url('/تماس-با-ما/');return $url;}

function alookhor_cc_contact_settings(){
 $header=function_exists('alookhor_cc_front_header_settings')?alookhor_cc_front_header_settings():[];
 $state=alookhor_cc_get_settings();$footer=(array)($state['footer_settings']??[]);
 $gold=(string)($header['gold']??'');if(!preg_match('/^#[0-9a-fA-F]{6}$/',$gold))$gold='#D4AF37';
 return ['phone'=>$header['phone']??'','email'=>$header['email']??get_option('admin_email'),'whatsapp'=>$header['whatsapp_number']??'','address'=>$footer['address']??'خراسان رضوی، خور نیشابور','hours_week'=>$footer['hours_week']??'شنبه تا پنجشنبه: ۸ الی ۲۰','hours_friday'=>$footer['hours_friday']??'جمعه‌ها: ۹ الی ۱۴','gold'=>$gold];
}

function alookhor_cc_contact_icon($name){$p=['phone'=>'<path d="M6.6 2.8 9.4 2c.6-.2 1.2.1 1.4.7L12 5.9c.2.5 0 1-.4 1.3L10 8.4c.9 1.9 2.5 3.5 4.4 4.4l1.2-1.6c.3-.4.8-.6 1.3-.4l3.2 1.2c.6.2.9.8.7 1.4l-.8 2.8c-.2.6-.7 1-1.4 1C10 17.2 4.8 11.9 4.8 4.2c0-.7.4-1.2 1.1-1.4Z"/>','email'=>'<path d="M3 5h18v14H3zM3 7l9 6 9-6"/>','pin'=>'<path d="M20 10c0 6-8 12-8 12S4 16 4 10a8 8 0 1 1 16 0Z"/><circle cx="12" cy="10" r="2.5"/>','clock'=>'<circle cx="12" cy="12" r="9"/><path d="M12 7v6l4 2"/>','whatsapp'=>'<circle cx="12" cy="12" r="9"/><path d="M8 18 5 19l1-3a7 7 0 1 1 2 2Z"/><path d="M9 9.5c.5 2.5 3 5 5.5 5.5l1-1.5-2-1-1 .5c-.8-.5-1.5-1.2-2-2l.5-1-1-2Z"/>','send'=>'<path d="m22 2-7 20-4-9-9-4 20-7Z"/><path d="M22 2 11 13"/>','shield'=>'<path d="M12 3 5 6v5c0 4.5 3 8.5 7 10 4-1.5 7-5.5 7-10V6l-7-3Z"/><path d="m9 12 2 2 4-4"/>','chat'=>'<path d="M21 12a8 8 0 0 1-8 8H4l2-3a8 8 0 1 1 15-5Z"/><path d="M9 11h6M9 14h4"/>','box'=>'<path d="m12 3 8 4.5v9L12 21l-8-4.5v-9L12 3Z"/><path d="M4 7.5 12 12l8-4.5M12 12v9"/>','globe'=>'<circle cx="12" cy="12" r="9"/><path d="M3 12h18M12 3c2.5 2.5 4 5.5 4 9s-1.5 6.5-4 9c-2.5-2.5-4-5.5-4-9s1.5-6.5 4-9Z"/>','chevron'=>'<path d="m6 9 6 6 6-6"/>','bolt'=>'<path d="M13 2 4 14h6l-1 8 9-12h-6l1-8Z"/>'];return '<svg viewBox="0 0 24 24" aria-hidden="true">'.($p[$name]??$p['send']).'</svg>';}

function alookhor_cc_contact_faq(){return [['q'=>'چطور سفارش خود را ثبت کنم؟','a'=>'از طریق فرم همین صفحه، تماس تلفنی یا واتساپ با ما در ارتباط باشید؛ کافی است موضوع «خرید محصول» را انتخاب کنید تا کارشناسان آلوخور راهنمایی‌تان کنند.'],['q'=>'برای خرید عمده یا صادرات چه مسیری دارید؟','a'=>'در فرم، موضوع «سفارش عمده» یا «صادرات» را انتخاب کنید تا تیم بازرگانی آلوخور مستقیماً برای شرایط همکاری، قیمت و ظرفیت تأمین با شما صحبت کند.'],['q'=>'سفارشم را چطور پیگیری کنم؟','a'=>'موضوع «پیگیری سفارش» را انتخاب کنید و شماره تماس خود را بنویسید؛ وضعیت آماده‌سازی و ارسال سفارش شما در سریع‌ترین زمان اعلام می‌شود.'],['q'=>'پاسخ‌گویی در چه ساعاتی است؟','a'=>'در ساعات کاری ذکرشده در همین صفحه پاسخ می‌دهیم؛ پیام‌های ثبت‌شده خارج از ساعات کاری به‌ترتیب و در ابتدای روز کاری بعدی بررسی می‌شوند.'],['q'=>'با اطلاعاتی که در فرم وارد می‌کنم چه می‌شود؟','a'=>'اطلاعات شما فقط برای پاسخ‌گویی به همین درخواست استفاده می‌شود، در اختیار هیچ شخص ثالثی قرار نمی‌گیرد و پس از پایان مکالمه حذف می‌شود.']];}

function alookhor_cc_contact_markup(){
 $c=alookhor_cc_contact_settings();$phone_href=preg_replace('/[^0-9+]/','',(string)$c['phone']);$wa=preg_replace('/\D+/','',(string)$c['whatsapp']);
 ob_start();?>
<section id="alookhor-contact-page" class="alookhor-acp" dir="rtl" style="--acp-gold:<?php echo esc_attr($c['gold']);?>">
 <div class="acp-inner">
  <header class="acp-hero">
   <span class="acp-kicker">CONTACT • ALOOKHOR</span>
   <h1>با <b>آلوخور</b> در ارتباط باشید</h1>
   <p>برای خرید محصول، سفارش عمده، صادرات یا پشتیبانی پیام بفرستید؛ تیم آلوخور در سریع‌ترین زمان پاسخ می‌دهد.</p>
   <ul class="acp-chips">
    <li><?php echo alookhor_cc_contact_icon('chat');?><span>پشتیبانی تلفنی و واتساپ</span></li>
    <li><?php echo alookhor_cc_contact_icon('clock');?><span>پاسخ‌گویی در ساعات کاری</span></li>
    <li><?php echo alookhor_cc_contact_icon('globe');?><span>ارسال به سراسر جهان</span></li>
   </ul>
  </header>
  <div class="acp-quick">
   <?php if($c['phone']):?><a class="acp-qcard" href="tel:<?php echo esc_attr($phone_href);?>"><i><?php echo alookhor_cc_contact_icon('phone');?></i><span><small>تماس مستقیم</small><b dir="ltr"><?php echo esc_html($c['phone']);?></b></span></a><?php endif;?>
   <?php if($wa):?><a class="acp-qcard" href="https://wa.me/<?php echo esc_attr($wa);?>" target="_blank" rel="noopener"><i class="is-wa"><?php echo alookhor_cc_contact_icon('whatsapp');?></i><span><small>گفت‌وگوی فوری</small><b>واتساپ آلوخور</b></span></a><?php endif;?>
   <?php if($c['email']):?><a class="acp-qcard" href="mailto:<?php echo esc_attr($c['email']);?>"><i><?php echo alookhor_cc_contact_icon('email');?></i><span><small>ایمیل</small><b dir="ltr"><?php echo esc_html($c['email']);?></b></span></a><?php endif;?>
   <div class="acp-qcard"><i><?php echo alookhor_cc_contact_icon('pin');?></i><span><small>نشانی</small><b><?php echo esc_html($c['address']);?></b></span></div>
  </div>
  <div class="acp-layout">
   <aside class="acp-info">
    <div class="acp-brand"><b>آلوخور</b><small>از خور به جهان</small></div>
    <h2>راه‌های ارتباط مستقیم</h2>
    <p>برای دریافت مشاوره تخصصی، استعلام قیمت و پیگیری سفارش، مسیر مناسب را انتخاب کنید.</p>
    <ul class="acp-hours">
     <li><i><?php echo alookhor_cc_contact_icon('clock');?></i><span><small>ساعت پاسخ‌گویی</small><b><?php echo esc_html($c['hours_week']);?></b></span></li>
     <li><i><?php echo alookhor_cc_contact_icon('bolt');?></i><span><small>جمعه‌ها</small><b><?php echo esc_html($c['hours_friday']);?></b></span></li>
     <li><i><?php echo alookhor_cc_contact_icon('box');?></i><span><small>حوزه فعالیت</small><b>تولید، بسته‌بندی و صادرات خشکبار</b></span></li>
    </ul>
    <?php if($wa):?><a class="acp-wa" href="https://wa.me/<?php echo esc_attr($wa);?>" target="_blank" rel="noopener"><?php echo alookhor_cc_contact_icon('whatsapp');?><span>شروع گفت‌وگو در واتساپ</span></a><?php endif;?>
    <p class="acp-privacy"><?php echo alookhor_cc_contact_icon('shield');?><span>اطلاعات شما محفوظ است و فقط برای پاسخ‌گویی به درخواست استفاده می‌شود.</span></p>
   </aside>
   <form class="alookhor-acp-form acp-form" novalidate>
    <div class="acp-form-head"><span>ارسال پیام</span><h2>چطور می‌توانیم کمک کنیم؟</h2><p>فرم زیر را کامل کنید؛ کارشناسان آلوخور با شما تماس می‌گیرند.</p></div>
    <div class="acp-grid">
     <label>نام و نام خانوادگی<abbr aria-hidden="true">*</abbr><input name="name" required minlength="2" autocomplete="name" placeholder="نام شما"></label>
     <label>شماره تماس<abbr aria-hidden="true">*</abbr><input name="phone" required inputmode="tel" autocomplete="tel" dir="ltr" placeholder="09xxxxxxxxx"></label>
     <label>ایمیل<input name="email" type="email" autocomplete="email" dir="ltr" placeholder="name@example.com"></label>
     <label>موضوع<abbr aria-hidden="true">*</abbr><select name="subject" required><option value="">انتخاب کنید</option><option>خرید محصول</option><option>سفارش عمده</option><option>صادرات</option><option>پیگیری سفارش</option><option>پشتیبانی</option></select></label>
     <label class="acp-full">پیام شما<abbr aria-hidden="true">*</abbr><textarea name="message" required minlength="10" rows="5" placeholder="لطفاً درخواست خود را کامل بنویسید…"></textarea></label>
    </div>
    <input class="acp-hp" name="website" tabindex="-1" autocomplete="off" aria-hidden="true">
    <label class="acp-consent"><input type="checkbox" required> با ثبت فرم، با پردازش اطلاعات برای پاسخ‌گویی موافقم.</label>
    <button type="submit"><i class="acp-spin" aria-hidden="true"></i><?php echo alookhor_cc_contact_icon('send');?><span>ارسال پیام</span></button>
    <p class="acp-msg" role="status" aria-live="polite"></p>
    <input type="hidden" name="nonce" value="<?php echo esc_attr(wp_create_nonce('alookhor_contact'));?>">
   </form>
  </div>
  <section class="alookhor-acp-faq acp-faq">
   <header><span>FAQ</span><h2>پرسش‌های پرتکرار</h2></header>
   <div class="acp-faq-list">
    <?php foreach(alookhor_cc_contact_faq() as $i=>$item):?><details class="acp-faq-item"<?php echo $i===0?' open':'';?>><summary><span><?php echo esc_html($item['q']);?></span><?php echo alookhor_cc_contact_icon('chevron');?></summary><p><?php echo esc_html($item['a']);?></p></details><?php endforeach;?>
   </div>
  </section>
  <footer class="acp-foot"><span><?php echo alookhor_cc_contact_icon('chat');?></span><p>تیم آلوخور آماده پاسخ‌گویی به شماست.</p></footer>
 </div>
</section>
<?php return ob_get_clean();}

function alookhor_cc_contact_shortcode(){return alookhor_cc_contact_markup();}
add_shortcode('alookhor_contact_page','alookhor_cc_contact_shortcode');

add_action('wp_ajax_alookhor_contact_submit','alookhor_cc_contact_submit');
add_action('wp_ajax_nopriv_alookhor_contact_submit','alookhor_cc_contact_submit');
function alookhor_cc_contact_submit(){check_ajax_referer('alookhor_contact','nonce');if(!empty($_POST['website']))wp_send_json_success(['message'=>'پیام ثبت شد.']);$ip=sanitize_text_field($_SERVER['REMOTE_ADDR']??'unknown');$rate='alookhor_contact_'.md5($ip);if(get_transient($rate))wp_send_json_error(['message'=>'لطفاً کمی بعد دوباره تلاش کنید.'],429);$name=sanitize_text_field(wp_unslash($_POST['name']??''));$phone=sanitize_text_field(wp_unslash($_POST['phone']??''));$email=sanitize_email(wp_unslash($_POST['email']??''));$subject=sanitize_text_field(wp_unslash($_POST['subject']??''));$message=sanitize_textarea_field(wp_unslash($_POST['message']??''));if(strlen($name)<2||!preg_match('/^[+0-9۰-۹\s-]{10,20}$/u',$phone)||strlen($message)<10)wp_send_json_error(['message'=>'نام، تلفن و متن پیام را صحیح وارد کنید.'],422);$id=wp_insert_post(['post_type'=>'alookhor_contact','post_status'=>'private','post_title'=>$subject.' — '.$name,'post_content'=>$message],true);if(is_wp_error($id))wp_send_json_error(['message'=>'ثبت پیام انجام نشد؛ دوباره تلاش کنید.'],500);update_post_meta($id,'contact_name',$name);update_post_meta($id,'contact_phone',$phone);update_post_meta($id,'contact_email',$email);update_post_meta($id,'contact_subject',$subject);set_transient($rate,1,MINUTE_IN_SECONDS);wp_mail(get_option('admin_email'),'پیام جدید سایت آلوخور: '.$subject,"نام: $name\nتلفن: $phone\nایمیل: $email\n\n$message");wp_send_json_success(['message'=>'پیام شما با موفقیت ثبت شد. به‌زودی با شما تماس می‌گیریم.']);}

add_action('init',function(){register_post_type('alookhor_contact',['labels'=>['name'=>'پیام‌های تماس','singular_name'=>'پیام تماس'],'public'=>false,'show_ui'=>true,'show_in_menu'=>'alookhor-control-center','supports'=>['title','editor'],'capability_type'=>'post']);});

function alookhor_cc_is_contact_page(){if(!function_exists('is_page')||!is_page())return false;$id=(int)get_queried_object_id();if(!$id)return false;$ids=array_filter([(int)get_option('alookhor_contact_page_id',0),(int)get_option('alookhor_contact_legacy_page_id',0)]);$slug=get_post_field('post_name',$id);return in_array($id,$ids,true)||in_array($slug,['تماس-با-ما','contact'],true);}

/**
 * Schema v2 — professional Persian contact page everywhere.
 * 1) Main Persian page carries the managed shortcode (content forced, Elementor demo data removed).
 * 2) The obsolete Japanese/legacy demo page (/contact/) is captured with a reversible backup and
 *    replaced by the managed shortcode, so every uncached render is Persian; template_redirect
 *    keeps the 301 to the canonical Persian page.
 * 3) The Woodmart "دمو کلاسیک" leftover site title is restored to the brand name.
 */
add_action('init',function(){
 if(get_option('alookhor_contact_page_schema')==='2')return;
 $backup=function($page,$extra=[]){if(!$page||get_post_meta($page->ID,'_alookhor_contact_backup',true))return;update_post_meta($page->ID,'_alookhor_contact_backup',array_merge(['content'=>$page->post_content,'title'=>$page->post_title,'slug'=>$page->post_name,'elementor_data'=>get_post_meta($page->ID,'_elementor_data',true),'saved_at'=>current_time('mysql')],$extra));};
 $strip=function($page){delete_post_meta($page->ID,'_elementor_data');delete_post_meta($page->ID,'_elementor_edit_mode');delete_post_meta($page->ID,'_elementor_template_type');delete_post_meta($page->ID,'_elementor_version');};
 $adopt=function($page)use($backup,$strip){$backup($page);wp_update_post(['ID'=>$page->ID,'post_content'=>'[alookhor_contact_page]']);$strip($page);return $page;};
 $page=get_page_by_path('تماس-با-ما',OBJECT,'page');if(!$page)$page=get_page_by_title('تماس با ما',OBJECT,'page');
 if(!$page){$id=wp_insert_post(['post_type'=>'page','post_status'=>'publish','post_title'=>'تماس با ما','post_name'=>'تماس-با-ما','post_content'=>'[alookhor_contact_page]']);$page=$id?get_post($id):null;}
 if($page){$adopt($page);wp_update_post(['ID'=>$page->ID,'post_title'=>'تماس با ما']);update_option('alookhor_contact_page_id',(int)$page->ID,false);}
 $legacy=get_page_by_path('contact',OBJECT,'page');
 if(!$legacy)foreach(['お問い合わせ','Contact','تماس با ما']as $t){$legacy=get_page_by_title($t,OBJECT,'page');if($legacy)break;}
 if($legacy&&(!$page||$legacy->ID!==$page->ID)){
  $backup($legacy,['kind'=>'legacy_contact']);
  wp_update_post(['ID'=>$legacy->ID,'post_content'=>'[alookhor_contact_page]']);
  $strip($legacy);
  update_option('alookhor_contact_legacy_page_id',(int)$legacy->ID,false);
 }
 if(trim((string)get_option('blogname'))==='دمو کلاسیک')update_option('blogname','آلوخور');
 update_option('alookhor_contact_page_schema','2',false);
},40);

add_filter('nav_menu_link_attributes',function($atts,$item){$label=wp_strip_all_tags($item->title??'');$href=(string)($atts['href']??'');if(str_contains($label,'تماس با ما')||str_contains($label,'お問い合わせ')||preg_match('~/contact/?$~i',$href)||str_contains($href,'تماس-با-ما'))$atts['href']=alookhor_cc_contact_url();return $atts;},20,2);

add_action('template_redirect',function(){if(is_admin())return;$path=trim((string)wp_parse_url($_SERVER['REQUEST_URI']??'/',PHP_URL_PATH),'/');if($path!==''&&preg_match('~^contact/?$~i',$path)){wp_safe_redirect(alookhor_cc_contact_url(),301);exit;}});

add_filter('pre_get_document_title',function($title){return alookhor_cc_is_contact_page()?'تماس با ما | آلوخور':$title;},20);
add_filter('document_title_parts',function($parts){if(!alookhor_cc_is_contact_page())return $parts;$parts['title']='تماس با ما';$parts['site']='آلوخور';unset($parts['tagline'],$parts['page']);return $parts;},20);

add_action('wp_head',function(){if(!alookhor_cc_is_contact_page())return;$d='تماس با آلوخور — تلفن، واتساپ، ایمیل، نشانی و فرم پیام برای خرید محصول، سفارش عمده و صادرات خشکبار.';echo '<meta name="description" content="'.esc_attr($d).'">'."\n".'<meta property="og:title" content="تماس با ما | آلوخور">'."\n".'<meta property="og:description" content="'.esc_attr($d).'">'."\n".'<meta property="og:type" content="website">'."\n".'<meta property="og:url" content="'.esc_url(alookhor_cc_contact_url()).'">'."\n";},5);

add_filter('body_class',function($classes){if(alookhor_cc_is_contact_page())$classes[]='alookhor-contact-body';return $classes;});

add_action('wp_enqueue_scripts',function(){wp_enqueue_style('alookhor-cc-contact',ALOOKHOR_CC_URL.'assets/css/frontend-contact-page.css',[],ALOOKHOR_CC_BUILD);wp_enqueue_script('alookhor-cc-contact',ALOOKHOR_CC_URL.'assets/js/frontend-contact-page.js',[],ALOOKHOR_CC_BUILD,true);wp_localize_script('alookhor-cc-contact','ALOOKHOR_CONTACT',['ajax_url'=>admin_url('admin-ajax.php'),'contact_url'=>alookhor_cc_contact_url()]);});
