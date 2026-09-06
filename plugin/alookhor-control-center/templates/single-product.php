<?php
/** ALOOKHOR luxury single-product template — replaces the theme PDP with managed markup. */
if(!defined('ABSPATH'))exit;
get_header();
$alookhor_pdp=alookhor_cc_pdp_markup();
echo $alookhor_pdp;
get_footer();
