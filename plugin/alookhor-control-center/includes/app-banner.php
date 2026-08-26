<?php
/** Managed app download banner — [alookhor_app_banner]. */
if (!defined('ABSPATH')) exit;
function alookhor_cc_app_banner_defaults(){return [
 'enabled'=>true,'title'=>'دانلود اپلیکیشن آلوخور','description'=>'خرید آسان، استعلام سریع قیمت عمده و دسترسی به تخفیف‌های ویژه صادرکنندگان خشکبار',
 'bazaar_url'=>'https://cafebazaar.ir/','myket_url'=>'https://myket.ir/','ios_url'=>'','more_url'=>'',
 'background'=>'#100A1B','surface'=>'#181022','gold'=>'#F2A900','text'=>'#FFFFFF','muted'=>'#B8B0BD','radius'=>24,
];}
function alookhor_cc_get_app_banner_settings(){
 $state=alookhor_cc_get_settings();$saved=is_array($state['modules']['app']??null)?$state['modules']['app']:[];
 return array_replace(alookhor_cc_app_banner_defaults(),$saved);
}
function alookhor_cc_app_banner_shortcode(){
 $s=alookhor_cc_get_app_banner_settings();if(empty($s['enabled']))return '';
 $c=[];foreach(['background','surface','gold','text','muted'] as $k)$c[$k]=sanitize_hex_color($s[$k]??'')?:alookhor_cc_app_banner_defaults()[$k];
 ob_start();static $style=false;if(!$style){$style=true;$f=ALOOKHOR_CC_DIR.'assets/css/frontend-app-banner.css';if(file_exists($f))echo '<style id="alookhor-app-banner-inline">'.file_get_contents($f).'</style>';}?>
<section class="alookhor-app-banner" dir="rtl" style="--aab-bg:<?php echo esc_attr($c['background']);?>;--aab-surface:<?php echo esc_attr($c['surface']);?>;--aab-gold:<?php echo esc_attr($c['gold']);?>;--aab-text:<?php echo esc_attr($c['text']);?>;--aab-muted:<?php echo esc_attr($c['muted']);?>;--aab-radius:<?php echo max(12,min(40,absint($s['radius']??24)));?>px">
 <div class="aab-inner"><div class="aab-copy"><span class="aab-icon" aria-hidden="true">☺</span><div><h2><?php echo esc_html($s['title']);?></h2><p><?php echo esc_html($s['description']);?></p></div></div><div class="aab-actions">
 <?php $links=[['bazaar_url','دریافت از','بازار','◆'],['myket_url','دریافت از','مایکت','◉'],['ios_url','نسخه iOS','سیب‌اپ','●'],['more_url','','بیشتر','•••']];foreach($links as [$key,$small,$name,$icon]):$url=trim((string)($s[$key]??''));if($url==='')continue;?><a href="<?php echo esc_url($url);?>" target="_blank" rel="noopener"><i><?php echo esc_html($icon);?></i><span><small><?php echo esc_html($small);?></small><b><?php echo esc_html($name);?></b></span></a><?php endforeach;?>
 </div></div>
</section><?php return ob_get_clean();}
add_shortcode('alookhor_app_banner','alookhor_cc_app_banner_shortcode');
add_action('wp_enqueue_scripts',function(){wp_enqueue_style('alookhor-cc-app-banner',ALOOKHOR_CC_URL.'assets/css/frontend-app-banner.css',[],ALOOKHOR_CC_BUILD);});
