<?php
/** Shared managed-pages settings — editable from ALOOKHOR Center → مدیریت برگه‌ها. */
if(!defined('ABSPATH'))exit;

function alookhor_cc_pages_defaults(){
 $u=ALOOKHOR_CC_URL.'assets/images/';
 return [
  'contact'=>[
   'kicker'=>'CONTACT • ALOOKHOR',
   'title'=>'با آلوخور در ارتباط باشید',
   'intro'=>'برای خرید محصول، سفارش عمده، صادرات یا پشتیبانی پیام بفرستید؛ تیم آلوخور در سریع‌ترین زمان پاسخ می‌دهد.',
   'faqs'=>[
    ['q'=>'چطور سفارش خود را ثبت کنم؟','a'=>'از طریق فرم همین صفحه، تماس تلفنی یا واتساپ با ما در ارتباط باشید؛ کافی است موضوع «خرید محصول» را انتخاب کنید تا کارشناسان آلوخور راهنمایی‌تان کنند.'],
    ['q'=>'برای خرید عمده یا صادرات چه مسیری دارید؟','a'=>'در فرم، موضوع «سفارش عمده» یا «صادرات» را انتخاب کنید تا تیم بازرگانی آلوخور مستقیماً برای شرایط همکاری، قیمت و ظرفیت تأمین با شما صحبت کند.'],
    ['q'=>'سفارشم را چطور پیگیری کنم؟','a'=>'موضوع «پیگیری سفارش» را انتخاب کنید و شماره تماس خود را بنویسید؛ وضعیت آماده‌سازی و ارسال سفارش شما در سریع‌ترین زمان اعلام می‌شود.'],
    ['q'=>'پاسخ‌گویی در چه ساعاتی است؟','a'=>'در ساعات کاری ذکرشده در همین صفحه پاسخ می‌دهیم؛ پیام‌های ثبت‌شده خارج از ساعات کاری به‌ترتیب و در ابتدای روز کاری بعدی بررسی می‌شوند.'],
    ['q'=>'با اطلاعاتی که در فرم وارد می‌کنم چه می‌شود؟','a'=>'اطلاعات شما فقط برای پاسخ‌گویی به همین درخواست استفاده می‌شود، در اختیار هیچ شخص ثالثی قرار نمی‌گیرد و پس از پایان مکالمه حذف می‌شود.'],
   ],
  ],
  'about'=>[
   'kicker'=>'ABOUT • ALOOKHOR',
   'title'=>'داستانِ آلوخور',
   'intro'=>'از باغ‌های آلو بخارا در خراسان تا میز خانواده‌ها در سراسر جهان؛ باور ساده‌ای که آلوخور از روز اول با آن ساخته شده است: طبیعتِ خور، سورتِ دقیق و اعتمادِ شما.',
   'story_kicker'=>'OUR STORY',
   'story_title'=>'از خور نیشابور، برای جهان',
   'story_p1'=>'آلوخور در سرزمین آلو بخارا متولد شد؛ جایی که خاک، آفتاب و دست‌های هنرمند خراسان میوه‌ای می‌سازند که طعمش را هیچ‌جا تکرار نمی‌کنند. ما همین موهبت طبیعی را، بدون هیچ افزودنی، با شما به اشتراک می‌گذاریم.',
   'story_p2'=>'هر محصول، از باغ انتخاب و پس از سورت دقیق، فرآوری و بسته‌بندی بهداشتی می‌شود تا همان کیفیتی که از باغ برمی‌داریم، دست‌نخورده به خانه شما برسد؛ از خرید خانگی تا تأمین عمده و صادرات.',
   'story_image'=>$u.'category-plums.jpg',
   'stats'=>[
    ['b'=>'۱۰۰٪ طبیعی','small'=>'بدون مواد افزودنی'],
    ['b'=>'کیفیت صادراتی','small'=>'استاندارد بازارهای جهانی'],
    ['b'=>'+۱۵۰ کشور','small'=>'مقصد ارسال آلوخور'],
    ['b'=>'کنترل کیفیت','small'=>'از باغ تا بسته‌بندی'],
   ],
   'journey_kicker'=>'JOURNEY',
   'journey_title'=>'از باغ تا خانه شما',
   'steps'=>[
    ['b'=>'برداشت از باغ','span'=>'انتخاب میوه از باغ‌های خراسان در فصل برداشت'],
    ['b'=>'سورت دقیق','span'=>'پاک‌سازی و دسته‌بندی یکدست، فقط محصول ممتاز'],
    ['b'=>'بسته‌بندی بهداشتی','span'=>'بسته‌بندی مطمئن، آماده ارسال خانگی و صادراتی'],
    ['b'=>'ارسال به جهان','span'=>'تحویل سریع به سراسر ایران و جهان'],
   ],
   'step_images'=>[$u.'category-plums.jpg',$u.'category-nuts.jpg',$u.'category-fruit-sheets.jpg',$u.'export-banner-bg.jpg'],
   'values_kicker'=>'VALUES',
   'values_title'=>'ارزش‌هایی که آلوخور را می‌سازند',
   'values'=>[
    ['h'=>'اصالت','p'=>'طعم واقعی خشکبار خراسان، بدون تقلب و بدون افزودنی.'],
    ['h'=>'کیفیت','p'=>'سخت‌گیری در هر مرحله؛ از انتخاب باغ تا بسته‌بندی نهایی.'],
    ['h'=>'شفافیت','p'=>'آنچه می‌بینید همان است که می‌خورید؛ صادقانه و بی‌واسطه.'],
    ['h'=>'اعتماد','p'=>'اعتماد شما سرمایه ماست و پایه هر سفارش، از خانه تا کسب‌وکار.'],
   ],
   'export_kicker'=>'WHOLESALE & EXPORT',
   'export_title'=>'همکار کسب‌وکارها هستید؟',
   'export_text'=>'تأمین پایدار، قیمت همکاری و بسته‌بندی صادراتی برای فروشگاه‌ها، برندها و بازرگانان؛ تیم بازرگانی آلوخور کنار شماست.',
   'export_cta'=>'درخواست همکاری',
   'export_cta2'=>'مشاهده محصولات',
   'sign_small'=>'از خور به جهان',
  ],
 ];
}

function alookhor_cc_get_pages_settings(){
 static $cache=null;if($cache!==null)return $cache;
 $saved=get_option('alookhor_pages_settings',[]);
 if(!is_array($saved))$saved=[];
 $d=alookhor_cc_pages_defaults();
 $out=[];
 foreach(['contact','about'] as $group){
  $grp=isset($saved[$group])&&is_array($saved[$group])?$saved[$group]:[];
  $out[$group]=array_merge($d[$group],array_filter($grp,'is_scalar'));
 }
 $fix=function($key,$count)use(&$saved,&$d,&$out){
  $rows=[];
  for($i=0;$i<$count;$i++){
   $src=($saved['about'][$key][$i]??null);
   $base=$d['about'][$key][$i];
   if(is_array($src))$rows[$i]=array_merge($base,array_filter($src,'is_scalar'));
   else $rows[$i]=$base;
  }
  $out['about'][$key]=$rows;
 };
 $fix('stats',4);$fix('steps',4);$fix('values',4);
 $faqs=[];
 for($i=0;$i<5;$i++){
  $src=($saved['contact']['faqs'][$i]??null);
  $base=$d['contact']['faqs'][$i];
  $faqs[$i]=is_array($src)?array_merge($base,array_filter($src,'is_scalar')):$base;
 }
 $out['contact']['faqs']=$faqs;
 $imgs=[];
 for($i=0;$i<4;$i++){$imgs[$i]=esc_url_raw((string)($saved['about']['step_images'][$i]??$d['about']['step_images'][$i]))?:$d['about']['step_images'][$i];}
 $out['about']['step_images']=$imgs;
 $out['about']['story_image']=esc_url_raw((string)$out['about']['story_image'])?:$d['about']['story_image'];
 $cache=$out;return $out;
}

/** Escapes plain text then highlights the brand word in gold (keeps the luxury look for owner-edited titles). */
function alookhor_cc_goldify($text){
 $safe=esc_html((string)$text);
 $pos=mb_strpos($safe,'آلوخور');
 if($pos===false)return $safe;
 return mb_substr($safe,0,$pos).'<b>'.mb_substr($safe,$pos,5).'</b>'.mb_substr($safe,$pos+5);
}
