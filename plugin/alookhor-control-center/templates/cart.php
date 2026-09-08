<?php
/** ALOOKHOR luxury cart template — minimal, only luxury cart, footer safe, no aggressive hide */
if(!defined('ABSPATH'))exit;
wp_enqueue_script('alookhor-cc-cart-guard',ALOOKHOR_CC_URL.'assets/js/cart-no-reload-guard.js',[],ALOOKHOR_CC_BUILD,true);
get_header();
echo alookhor_cc_cart_markup();
get_footer();
