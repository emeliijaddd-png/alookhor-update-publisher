<?php
/** ALOOKHOR Checkout Luxury Template */
if(!defined('ABSPATH')) exit;
get_header();
echo function_exists('alookhor_cc_checkout_markup')?alookhor_cc_checkout_markup():'<div style="padding:40px;text-align:center">تسویه حساب</div>';
get_footer();
