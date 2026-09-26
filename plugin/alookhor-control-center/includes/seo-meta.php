<?php
/**
 * ALOOKHOR Technical SEO — v3.10.220 (SEO SPRINT 1)
 * ۱) Organization + WebSite (SearchAction) فقط وقتی Yoast غایب است — بدون دادهٔ جعلی.
 * ۲) alt خودکار برای تصاویر محصولات بدون متن جایگزین (نام واقعی محصول).
 * ۳) لاگ سبک ۴۰۴ برای یافتن مسیرهای شکسته/باقی‌مانده (حداکثر ۱۵۰ مسیر، در ابزار پاک‌سازی SEO نمایش داده می‌شود).
 */
if(!defined('ABSPATH')){exit;}

/* ---------- ۱) اسکیمای سازمانی فقط اگر Yoast فعال نیست ---------- */
add_action('wp_footer',function(){
 if(is_admin()||defined('WPSEO_VERSION'))return;
 $org=['@type'=>'Organization','@id'=>home_url('/#organization'),'name'=>get_bloginfo('name')?:'آلوخور','url'=>home_url('/')];
 $icon=function_exists('get_site_icon_url')?get_site_icon_url(512):'';
 if(is_string($icon)&&$icon!==''){$org['logo']=['@type'=>'ImageObject','url'=>$icon];}
 $data=['@context'=>'https://schema.org','@graph'=>[
  $org,
  ['@type'=>'WebSite','@id'=>home_url('/#website'),'url'=>home_url('/'),'name'=>get_bloginfo('name')?:'آلوخور','inLanguage'=>'fa-IR',
   'publisher'=>['@id'=>home_url('/#organization')],
   'potentialAction'=>['@type'=>'SearchAction','target'=>['@type'=>'EntryPoint','urlTemplate'=>home_url('/?s={search_term_string}')],'query-input'=>'required name=search_term_string'],
  ],
 ]];
 echo '<script type="application/ld+json" id="alookhor-org-schema">'.wp_json_encode($data,JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_UNICODE).'</script>';
},3);

/* ---------- ۲) alt خودکار تصاویر محصولات ---------- */
add_filter('post_thumbnail_html',function($html,$post_id){
 if(!is_string($html)||$html===''||get_post_type($post_id)!=='product')return $html;
 $title=esc_attr(get_the_title($post_id));
 if(preg_match('/\salt=""/',$html)){return preg_replace('/\salt=""/','alt="'.$title.'"',$html);}
 if(strpos($html,'alt=')===false){return preg_replace('/<img /','<img alt="'.$title.'" ',$html,1);}
 return $html;
},12,2);

/* ---------- ۳) لاگ ۴۰۴ (سبک، بدون autoload، باتوجه به امنیت: فقط مسیر) ---------- */
add_action('template_redirect',function(){
 if(!is_404())return;
 $path=isset($_SERVER['REQUEST_URI'])?(string)parse_url(esc_url_raw(wp_unslash($_SERVER['REQUEST_URI'])),PHP_URL_PATH):'';
 if($path===''||$path==='/'||strlen($path)>150)return;
 if(preg_match('#^/item/\d+/?$#',$path))return;
 $log=get_option('acc_404_log');if(!is_array($log))$log=[];
 if(isset($log[$path])){$log[$path]['c']++;$log[$path]['t']=time();}else{$log[$path]=['c'=>1,'t'=>time()];}
 if(count($log)>150){uasort($log,function($a,$b){return (int)$b['c']<=>(int)$a['c'];});$log=array_slice($log,0,150,true);}
 update_option('acc_404_log',$log,false);
},99);
