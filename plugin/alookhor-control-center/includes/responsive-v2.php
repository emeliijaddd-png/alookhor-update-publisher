<?php
/**
 * ALOOKHOR Responsive v2 loader.
 * Also hard-disables WoodMart's XTS Single Product template renderer on real
 * WooCommerce product requests so the managed ALOOKHOR PDP is the sole renderer.
 */
if(!defined('ABSPATH')){exit;}

add_action('wp_enqueue_scripts',function(){
 if(is_admin())return;
 wp_enqueue_style('alookhor-cc-r2',ALOOKHOR_CC_URL.'assets/css/frontend-responsive-v2.css',[],ALOOKHOR_CC_BUILD);
},9999);

/**
 * Remove WoodMart's Single Product template callback before template_include
 * executes. WoodMart registers an instance method, so the exact priority is
 * not stable enough to hard-code; inspect the registered WP_Hook callbacks
 * and remove only XTS Single_Product::override_template.
 */
add_filter('template_include',function($template){
 if(isset($_GET['elementor-preview']) || (($_GET['action']??'')==='elementor')) return $template;
 if(!function_exists('is_product') || !is_product()) return $template;
 global $wp_filter;
 $hook=$wp_filter['template_include']??null;
 if($hook && isset($hook->callbacks) && is_array($hook->callbacks)){
  foreach($hook->callbacks as $priority=>$callbacks){
   foreach($callbacks as $entry){
    $cb=$entry['function']??null;
    if(!is_array($cb) || count($cb)!==2 || !is_object($cb[0]) || $cb[1]!=='override_template') continue;
    $class=get_class($cb[0]);
    if($class==='XTS\\Modules\\Layouts\\Single_Product'){
     remove_filter('template_include',$cb,(int)$priority);
    }
   }
  }
 }
 if(defined('ALOOKHOR_CC_DIR') && file_exists(ALOOKHOR_CC_DIR.'templates/single-product.php')){
  return ALOOKHOR_CC_DIR.'templates/single-product.php';
 }
 return $template;
},0);
