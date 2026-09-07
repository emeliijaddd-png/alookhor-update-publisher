<?php
/**
 * ALOOKHOR Responsive v2 loader — v3.10.354
 * Loads frontend-responsive-v2.css LAST (priority 9999) so its tablet-band +
 * overflow armor wins over every module stylesheet without editing them.
 */
if(!defined('ABSPATH')){exit;}
add_action('wp_enqueue_scripts',function(){
 if(is_admin())return;
 wp_enqueue_style('alookhor-cc-r2',ALOOKHOR_CC_URL.'assets/css/frontend-responsive-v2.css',[],ALOOKHOR_CC_BUILD);
},9999);

/**
 * PDP render lock — v3.10.354.
 *
 * WoodMart's Single Product Builder registers XTS\\Modules\\Layouts\\Single_Product::override_template
 * on WordPress' template selection pipeline. Our PDP already owns the complete product
 * document, so allowing that callback to run would render the WoodMart product layout
 * alongside/around the managed ALOOKHOR PDP. Remove only that renderer on product requests;
 * leave WoodMart's other layouts untouched.
 *
 * WordPress documents template_include as the proper point to replace a template, and
 * WoodMart's own Single Product Builder uses the same template_include pipeline.
 */
add_action('template_redirect',function(){
 if(is_admin() || !function_exists('is_product') || !is_product())return;
 global $wp_filter;
 foreach(['template_include','single_template'] as $hook_name){
  if(empty($wp_filter[$hook_name]) || empty($wp_filter[$hook_name]->callbacks))continue;
  foreach($wp_filter[$hook_name]->callbacks as $priority=>$callbacks){
   foreach($callbacks as $callback){
    $fn=$callback['function']??null;
    if(!is_array($fn) || count($fn)!==2 || !is_object($fn[0]))continue;
    $method=(string)$fn[1];
    if($method!=='override_template')continue;
    $class=get_class($fn[0]);
    if($class==='XTS\\Modules\\Layouts\\Single_Product' || is_a($fn[0],'XTS\\Modules\\Layouts\\Single_Product')){
     remove_filter($hook_name,$fn,(int)$priority);
    }
   }
  }
 }
},1);

/**
 * One-time same-build delivery bridge.
 *
 * The live site is already on 3.10.354. This source-only renderer fix therefore
 * needs to be deliverable without inventing a second public version number. The
 * bridge exposes the exact current build once, installs the package, then disables
 * itself permanently. Future releases continue to use the normal version comparison.
 */
add_filter('pre_set_site_transient_update_plugins',function($transient){
 if(!is_object($transient) || !defined('ALOOKHOR_CC_PLUGIN_BASENAME'))return $transient;
 if(get_option('alookhor_cc_pdp_render_lock_applied',false))return $transient;
 $plugin=ALOOKHOR_CC_PLUGIN_BASENAME;
 if(empty($transient->checked[$plugin]))return $transient;
 if(!function_exists('alookhor_cc_get_update_manifest'))return $transient;
 $manifest=alookhor_cc_get_update_manifest(false);
 if(is_wp_error($manifest) || empty($manifest['version']) || empty($manifest['download_url']))return $transient;
 if((string)$manifest['version']!==(string)ALOOKHOR_CC_VERSION)return $transient;
 if(!isset($transient->response) || !is_array($transient->response))$transient->response=[];
 if(!isset($transient->no_update) || !is_array($transient->no_update))$transient->no_update=[];
 $item=(object)[
  'id'=>'alookhor-control-center',
  'slug'=>'alookhor-control-center',
  'plugin'=>$plugin,
  'new_version'=>$manifest['version'],
  'url'=>$manifest['details_url']??home_url('/'),
  'package'=>$manifest['download_url'],
  'requires'=>$manifest['requires']??'6.0',
  'tested'=>$manifest['tested']??'',
  'requires_php'=>$manifest['requires_php']??'8.0',
 ];
 $transient->response[$plugin]=$item;
 unset($transient->no_update[$plugin]);
 return $transient;
},999,1);

add_action('upgrader_process_complete',function($upgrader,$hook_extra){
 if(!is_array($hook_extra) || ($hook_extra['action']??'')!=='update' || ($hook_extra['type']??'')!=='plugin')return;
 $plugin=ALOOKHOR_CC_PLUGIN_BASENAME;
 $targets=[];
 if(!empty($hook_extra['plugin']))$targets[]=$hook_extra['plugin'];
 if(!empty($hook_extra['plugins']) && is_array($hook_extra['plugins']))$targets=array_merge($targets,$hook_extra['plugins']);
 if(!in_array($plugin,$targets,true))return;
 update_option('alookhor_cc_pdp_render_lock_applied',true,false);
 delete_site_transient('alookhor_cc_update_manifest_v1');
 delete_site_transient('update_plugins');
},999,2);
