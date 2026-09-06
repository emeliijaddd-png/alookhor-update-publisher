<?php
/**
 * ALOOKHOR Responsive v2 loader — v3.10.222
 * Loads frontend-responsive-v2.css LAST (priority 9999) so its tablet-band +
 * overflow armor wins over every module stylesheet without editing them.
 */
if(!defined('ABSPATH')){exit;}
add_action('wp_enqueue_scripts',function(){
 if(is_admin())return;
 wp_enqueue_style('alookhor-cc-r2',ALOOKHOR_CC_URL.'assets/css/frontend-responsive-v2.css',[],ALOOKHOR_CC_BUILD);
},9999);
