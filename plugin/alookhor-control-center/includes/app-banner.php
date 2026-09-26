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
function alookhor_cc_app_store_icon($store){
 $icons=[
  'bazaar'=>'<svg viewBox="0 0 24 24" aria-hidden="true"><path fill="#20C36A" d="m12 2 8 6.2-8 13.8L4 8.2 12 2Z"/><path fill="#fff" d="M9.2 8.2h5.6v7.6H9.2z"/></svg>',
  'myket'=>'<svg viewBox="0 0 24 24" aria-hidden="true"><circle cx="12" cy="12" r="9" fill="none" stroke="#2867F0" stroke-width="2"/><circle cx="9" cy="9" r="1.4" fill="#2867F0"/><circle cx="15" cy="9" r="1.4" fill="#2867F0"/><circle cx="9" cy="15" r="1.4" fill="#2867F0"/><circle cx="15" cy="15" r="1.4" fill="#2867F0"/></svg>',
  'ios'=>'<svg viewBox="0 0 24 24" aria-hidden="true"><path fill="#111" d="M17.1 12.6c0-2.7 2.2-4 2.3-4.1a5 5 0 0 0-3.9-2.1c-1.7-.2-3.2 1-4 1-1 0-2.4-1-3.8-1-2 0-3.8 1.1-4.8 2.8-2.1 3.6-.5 8.9 1.5 11.8 1 1.4 2.1 3 3.6 2.9 1.4-.1 2-1 3.8-1s2.3 1 3.8 1c1.6 0 2.6-1.4 3.5-2.9 1.1-1.6 1.6-3.2 1.6-3.3-.1 0-3.6-1.4-3.6-5.1ZM14.4 4.7A4.9 4.9 0 0 0 15.5 1a5 5 0 0 0-3.3 1.7 4.7 4.7 0 0 0-1.2 3.5c1.2.1 2.5-.5 3.4-1.5Z"/></svg>',
  'more'=>'<svg viewBox="0 0 24 24" aria-hidden="true"><circle cx="5" cy="12" r="2"/><circle cx="12" cy="12" r="2"/><circle cx="19" cy="12" r="2"/></svg>',
 ];return $icons[$store]??$icons['more'];
}
function alookhor_cc_app_banner_shortcode(){
 $s=alookhor_cc_get_app_banner_settings();if(empty($s['enabled']))return '';
 $c=[];foreach(['background','surface','gold','text','muted'] as $k)$c[$k]=sanitize_hex_color($s[$k]??'')?:alookhor_cc_app_banner_defaults()[$k];
 ob_start();static $style=false;if(!$style && alookhor_cc_should_inline_shortcode_css()){$style=true;$f=ALOOKHOR_CC_DIR.'assets/css/frontend-app-banner.css';if(file_exists($f))echo '<style id="alookhor-app-banner-inline">'.file_get_contents($f).'</style>';}?>
<section class="alookhor-app-banner" dir="rtl" style="--aab-bg:<?php echo esc_attr($c['background']);?>;--aab-surface:<?php echo esc_attr($c['surface']);?>;--aab-gold:<?php echo esc_attr($c['gold']);?>;--aab-text:<?php echo esc_attr($c['text']);?>;--aab-muted:<?php echo esc_attr($c['muted']);?>;--aab-radius:<?php echo max(12,min(40,absint($s['radius']??24)));?>px">
 <div class="aab-inner"><div class="aab-copy"><span class="aab-icon" aria-hidden="true"><svg viewBox="0 0 24 24"><rect x="4" y="6" width="16" height="15" rx="5"/><path d="M9 6V5a3 3 0 0 1 6 0v1M8.5 13.5c1.8 2.2 5.2 2.2 7 0"/><circle cx="9" cy="11" r=".7"/><circle cx="15" cy="11" r=".7"/></svg></span><div><h2><?php echo esc_html($s['title']);?></h2><p><?php echo esc_html($s['description']);?></p></div></div><div class="aab-actions">
 <?php $links=[['bazaar_url','دریافت از','بازار','bazaar'],['myket_url','دریافت از','مایکت','myket'],['ios_url','نسخه iOS','سیب‌اپ','ios'],['more_url','','بیشتر','more']];foreach($links as [$key,$small,$name,$icon]):$url=trim((string)($s[$key]??''));if($url==='')continue;?><a class="is-<?php echo esc_attr($icon);?>" href="<?php echo esc_url($url);?>" target="_blank" rel="noopener"><i><?php echo alookhor_cc_app_store_icon($icon); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></i><span><small><?php echo esc_html($small);?></small><b><?php echo esc_html($name);?></b></span></a><?php endforeach;?>
 </div></div>
</section><?php return ob_get_clean();}
add_shortcode('alookhor_app_banner','alookhor_cc_app_banner_shortcode');
add_action('wp_enqueue_scripts',function(){wp_enqueue_style('alookhor-cc-app-banner',ALOOKHOR_CC_URL.'assets/css/frontend-app-banner.css',[],ALOOKHOR_CC_BUILD);});
