<?php
/**
 * ALOOKHOR SEO Cleanup — v3.10.218 (SEO SPRINT 0)
 *
 * ۱) صفحات هرزنامهٔ قدیمی /item/<id> پاسخ 410 Gone می‌گیرند (حذف سریع‌تر از ایندکس گوگل).
 * ۲) اگر robots.txt مجازی وردپرس سرو شود، خطوط Sitemap آسیب‌دیده حذف می‌شود.
 * ۳) ابزار ادمین «پاک‌سازی SEO»: پیدا کردن نقشه‌های هرزنامهٔ روی دیسک + حذف امن آن‌ها،
 *    گزارش محصولات دمو + انتقال به زبالت‌دان (برگشت‌پذیر)، گزارش محصولات بدون تصویر.
 * هیچ داده‌ای بدون تأیید ادمین حذف نمی‌شود.
 */
if(!defined('ABSPATH')){exit;}

/* ---------- ۱) 410 برای هرزنامهٔ قدیمی (سریع و سبک، بدون بارگذاری قالب) ---------- */
add_action('template_redirect',function(){
 $uri=isset($_SERVER['REQUEST_URI'])?esc_url_raw(wp_unslash($_SERVER['REQUEST_URI'])):'';
 $path=parse_url($uri,PHP_URL_PATH);
 if(is_string($path)&&preg_match('#^/item/\d+/?$#',$path)){
  status_header(410);
  header('Content-Type: text/html; charset=utf-8');
  header('X-Robots-Tag: noindex, noarchive',false);
  echo '<!doctype html><html lang="fa" dir="rtl"><head><meta charset="utf-8"><meta name="robots" content="noindex"><meta name="viewport" content="width=device-width,initial-scale=1"><title>صفحه دیگر وجود ندارد — آلوخور</title></head><body style="font-family:Tahoma,Arial,sans-serif;direction:rtl;text-align:center;padding:60px 20px;color:#3a2458"><h1 style="font-size:22px">این صفحه دیگر وجود ندارد</h1><p style="font-size:14px"><a style="color:#823c99" href="'.esc_url(home_url('/')).'">بازگشت به فروشگاه آلوخور</a></p></body></html>';
  exit;
 }
},1);

/* ---------- ۲) robots.txt مجازی: حذف خطوط Sitemap آلوده/نادرست ---------- */
add_filter('robots_txt',function($out){
 $lines=preg_split('/\r\n|\r|\n/',(string)$out);$keep=[];
 foreach($lines as $l){
  $t=trim($l);
  if($t!==''&&stripos($t,'sitemap:')===0){
   $low=strtolower($t);
   /* نقشهٔ آلودهٔ /item/ هرگز تبلیغ نشود؛ نقشه‌های سالم یواست/هسته را نگه دار */
   if(strpos($low,'/sitemap.xml')!==false||strpos($low,'/sitemap_0.xml')!==false){continue;}
  }
  $keep[]=$l;
 }
 return implode("\n",$keep);
},999);

if(is_admin()){
add_action('admin_menu',function(){
 add_submenu_page('acc-admin','پاک‌سازی SEO','🧹 پاک‌سازی SEO','manage_options','alookhor-seo-clean','alookhor_seo_cleaner_page');
},99);

function alookhor_seo_cleaner_probe(){
 $out=[];
 $ht=ABSPATH.'.htaccess';
 if(is_file($ht)){
  $c=@file_get_contents($ht);$sus=[];
  if(is_string($c)){foreach(preg_split('/\r\n|\r|\n/',$c) as $i=>$ln){
   if(preg_match('/(base64_decode|gzinflate|eval\(|str_rot13)|((rewritecond|rewriterule).*(item|base64|googlebot|referer|user-agent|https?:))/i',$ln)){ $sus[]=($i+1).': '.$ln; }
  }}
  $out[]=['.htaccess','آخرین تغییر: '.date_i18n('Y-m-d H:i:s',@filemtime($ht)),$sus?'🚨 خطوط مشکوک:\n'.implode("\n",$sus):'✅ خط مشکوکی دیده نشد'];
 }else{$out[]=['.htaccess','یافت نشد','سرور شما شاید NGINX است؛ این فایل ندارد'];}
 foreach(['index.php','wp-config.php','wp-settings.php','wp-load.php'] as $core){
  if(is_file(ABSPATH.$core)){$out[]=['فایل هسته: '.$core,'آخرین تغییر: '.date_i18n('Y-m-d H:i:s',@filemtime(ABSPATH.$core)),'⚠ اگر این تاریخ بدون به‌روزرسانی وردپرس جدید است، احتمال دست‌کاری بالاست'];}
 }
 $mu=ABSPATH.'wp-content/mu-plugins';
 if(is_dir($mu)){foreach(glob($mu.'/*.php')?:[] as $ff){$out[]=['mu-plugin: '.basename($ff),'آخرین تغییر: '.date_i18n('Y-m-d H:i:s',@filemtime($ff)),'🚨 mu-plugin بدون ریس انجام می‌شود؛ اگر نمی‌شناسید فوراً حذف کنید'];}}
 try{
  $bad=[];$rii=new RecursiveIteratorIterator(new RecursiveDirectoryIterator(ABSPATH.'wp-content/uploads',FilesystemIterator::SKIP_DOTS));
  foreach($rii as $fi){ if($fi->isFile()&&strtolower($fi->getExtension())==='php'){$bad[]=$fi->getPathname().' ('.date_i18n('Y-m-d',@filemtime($fi->getPathname())).')'; if(count($bad)>=30){$bad[]='…';break;}} }
  $out[]=['فایل‌های PHP داخل uploads', $bad?'یافت شد: '.count($bad):'هیچ‌کدام', $bad?'🚨 '.implode(" | ",$bad):'✅ سالم — هیچ فایل PHP در uploads نیست'];
 }catch(Throwable $e){$out[]=['فایل‌های PHP داخل uploads','خطا در اسکن','⚠ صرف‌نظر شد'];}
 return $out;
}

function alookhor_seo_cleaner_scan_files(){
 $hits=[];
 $cands=[ABSPATH.'robots.txt',ABSPATH.'sitemap.xml',ABSPATH.'sitemap_index.xml'];
 foreach(glob(ABSPATH.'sitemap_*.xml')?:[] as $f){$cands[]=$f;}
 foreach($cands as $f){
  if(!is_file($f)){continue;}
  $head=@file_get_contents($f,false,null,0,200000);
  $hits[]=[
   'name'=>basename($f),
   'size'=>@filesize($f),
   'spam'=>(is_string($head)&&strpos($head,'/item/')!==false)?1:0,
  ];
 }
 return $hits;
}

function alookhor_seo_cleaner_page(){
 if(!current_user_can('manage_options')){wp_die('عدم دسترسی');}
 $acted='';
 if($_SERVER['REQUEST_METHOD']==='POST'&&isset($_POST['acc_seo_ok'],$_POST['_wpnonce'])&&wp_verify_nonce(sanitize_text_field(wp_unslash($_POST['_wpnonce'])),'acc_seo_clean')){
  $act=sanitize_key($_POST['acc_seo_ok']);
  if($act==='delrobots'&&is_file(ABSPATH.'robots.txt')){
   $acted=@unlink(ABSPATH.'robots.txt')?'✅ فایل robots.txt حذف شد (وردپرس حالا نسخهٔ مجازی سالم سرو می‌کند).':'❌ حذف ناموفق بود؛ از فایل‌منیجر هاست حذف کنید.';
  }elseif($act==='delsmap'&&!empty($_POST['file'])){
   $file=basename(sanitize_file_name(wp_unslash($_POST['file'])));
   if(in_array($file,['sitemap.xml','sitemap_index.xml'],true)||preg_match('/^sitemap_\d+\.xml$/',$file)){
    $full=ABSPATH.$file;
    $head=is_file($full)?@file_get_contents($full,false,null,0,200000):'';
    if(is_string($head)&&strpos($head,'/item/')!==false){
     $acted=@unlink($full)?'✅ '.$file.' حذف شد.':'❌ حذف '.$file.' ناموفق بود.';
    }else{$acted='⛔ فقط فایل‌های دارای امضای آلودگی /item/ حذف می‌شوند.';}
   }else{$acted='⛔ نام فایل مجاز نیست.';}
  }elseif($act==='delsmaps'){
   $n=0;$fail=[];
   foreach(glob(ABSPATH.'sitemap*.xml')?:[] as $f){
    $base=basename($f);
    if(!($base==='sitemap.xml'||$base==='sitemap_index.xml'||preg_match('/^sitemap_\d+\.xml$/',$base))){continue;}
    $head=@file_get_contents($f,false,null,0,200000);
    if(is_string($head)&&strpos($head,'/item/')!==false){ if(@unlink($f)){$n++;}else{$fail[]=$base;} }
   }
   $acted=$n?'✅ '.$n.' نقشهٔ آلوده حذف شد.'.($fail?' (ناموفق: '.implode('، ',$fail).')':''):'ℹ️ نقشهٔ آلوده‌ای پیدا نشد.';
  }elseif($act==='trashdemo'){
   $ids=get_posts(['post_type'=>'product','post_status'=>['publish','draft'],'posts_per_page'=>-1,'fields'=>'ids','s'=>'گوشی سامسونگ']);
   $n=0;foreach($ids as $id){if(wp_trash_post($id)){$n++;}}
   $acted=$n?'✅ '.$n.' محصول دمو به زبالت‌دان رفت (قابل بازیابی از پیشخوان وردپرس).':'ℹ️ محصول دموی «گوشی سامسونگ» پیدا نشد.';
  }
 }
 $files=alookhor_seo_cleaner_scan_files();
 $demo=get_posts(['post_type'=>'product','post_status'=>'publish','posts_per_page'=>100,'s'=>'گوشی سامسونگ']);
 $noimg=get_posts(['post_type'=>'product','post_status'=>'publish','posts_per_page'=>200,'meta_query'=>[['key'=>'_thumbnail_id','compare'=>'NOT EXISTS']]]);
 echo '<div class="wrap" dir="rtl"><h1 style="color:#731651">🧹 پاک‌سازی SEO — آلوخور</h1>';
 if($acted!==''){echo '<div class="notice notice-info"><p>'.esc_html($acted).'</p></div>';}
 echo '<h2>۱) نقشه‌های سایت روی سرور</h2><table class="widefat striped"><thead><tr><th>فایل</th><th>حجم</th><th>نشانهٔ آلودگی /item/</th></tr></thead><tbody>';
 foreach($files as $f){
  echo '<tr><td dir="ltr">'.esc_html($f['name']).'</td><td>'.esc_html(number_format($f['size'])).' B</td><td>'.($f['spam']?'<b style="color:#b94a48">🚨 آلوده</b>':'<span style="color:#2e7d32">سالم</span>').'</td></tr>';
 }
 if(!$files){echo '<tr><td colspan="3">✅ هیچ نقشهٔ فیزیکی نخواه‌دیده‌ای روی ریشهٔ سایت پیدا نشد.</td></tr>';}
 echo '</tbody></table>';
 echo '<form method="post" style="margin:12px 0">'.wp_nonce_field('acc_seo_clean','_wpnonce',true,false).'
  <button class="button button-primary" name="acc_seo_ok" value="delsmaps" onclick="return confirm(\'همه نقشه‌های آلوده حذف شوند؟\')">🗑 حذف همهٔ نقشه‌های آلوده</button>
  <button class="button" name="acc_seo_ok" value="delrobots" onclick="return confirm(\'robots.txt فیزیکی حذف شود؟\')">🗑 حذف robots.txt فیزیکی</button></form>';
 echo '<h2>۲) محصولات دمو قالب ('.count($demo).')</h2>';
 if($demo){echo '<ol>';foreach($demo as $p){echo '<li>#'.intval($p->ID).' — '.esc_html($p->post_title).'</li>';}echo '</ol>';
  echo '<form method="post">'.wp_nonce_field('acc_seo_clean','_wpnonce',true,false).'<button class="button button-primary" name="acc_seo_ok" value="trashdemo" onclick="return confirm(\'محصولات دمو به زبالت‌دان بروند؟\')">🗑 انتقال محصولات دمو به زبالت‌دان (برگشت‌پذیر)</button></form>';}
 else{echo '<p style="color:#2e7d32">✅ محصول دموی «گوشی سامسونگ» پیدا نشد.</p>';}
 echo '<h2>۳) محصولات بدون تصویر ('.count($noimg).' از حداکثر ۲۰۰)</h2>';
 if($noimg){echo '<ol>';foreach($noimg as $p){echo '<li><a href="'.esc_url(get_permalink($p->ID)).'" target="_blank">'.esc_html($p->post_title).'</a></li>';}echo '</ol><p>⚠ این محصولات با تصویر پیش‌فرض ووکامرس در نتایج جست‌وجو دیده می‌شوند؛ تصویر واقعی برایشان بارگذاری کنید.</p>';}
 else{echo '<p style="color:#2e7d32">✅ همهٔ محصولات تصویر دارند.</p>';}
 echo '<h2>۴) پایش نفوذ سرور 🛡 (فقط خواندنی)</h2><table class="widefat striped"><thead><tr><th>مورد</th><th>وضعیت</th><th>جزئیات</th></tr></thead><tbody>';
 foreach(alookhor_seo_cleaner_probe() as $row){
  echo '<tr><td>'.esc_html($row[0]).'</td><td>'.esc_html($row[1]).'</td><td style="white-space:pre-wrap;font-size:11px">'.esc_html($row[2]).'</td></tr>';
 }
 echo '</tbody></table><p style="color:#b94a48;font-weight:700">⚠ اگر هر جا 🚨 دیدید، اسکرین‌شات این بخش را برای عامل بفرستید و خودتان هیچ فایلی را دستی حذف نکنید تا شواهد از بین نرود.</p>';
 echo '<h2>۵) اقدامات دستی پیشنهادی به ترتیب اولویت</h2><ol>
  <li><b>اول:</b> اسکن امنیتی کامل با افزونهٔ Wordfence (نسخهٔ رایگان کافی است) یا درخواست اسکن بدافزار از پشتیبانی هاست.</li>
  <li>رمزهای پیشخوان وردپرس، cPanel، FTP و دیتابیس را عوض کنید و کاربران ناشناس را حذف کنید.</li>
  <li>محصولات دمو «گوشی سامسونگ…» با دکمهٔ بالا به زبالت‌دان بروند؛ دسته‌های دمو (تبلت/لپتاپ/جوراب/…) را پاک کنید.</li>
  <li>بنر «جشواره فروش اپل» + متون لورم ایپسوم را از صفحهٔ فروشگاه حذف کنید.</li>
  <li>بعد از پاک شدن بدافزار: نقشه‌های آلودهٔ بالا را با دکمه حذف کنید؛ در گوگل Search Console بخش Removals پیشوند <code>alookhor.ir/item/</code> را ثبت کنید؛ نقشهٔ سالم Yoast را ثبت کنید.</li></ol>
 <p style="color:#666;font-size:12px">این ابزار هیچ داده‌ای را بدون تأیید شما تغییر نمی‌دهد؛ انتقال به زبالت‌دان قابل بازگشت است.</p></div>';
}
}
