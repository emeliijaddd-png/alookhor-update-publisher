<?php
/** ALOOKHOR luxury single-product template — canonical AKX/Arena header + managed PDP. */
if(!defined('ABSPATH'))exit;
?><!doctype html>
<html <?php language_attributes(); ?>>
<head>
  <meta charset="<?php bloginfo('charset'); ?>">
  <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
  <?php wp_head(); ?>
</head>
<body <?php body_class('alookhor-managed-product-page'); ?>>
<?php wp_body_open(); ?>
<?php
/* Do not call get_header(): that would reintroduce WoodMart's theme header. */
if(function_exists('alookhor_cc_render_akx_header')) echo alookhor_cc_render_akx_header();

$alookhor_pdp=alookhor_cc_pdp_markup();
echo $alookhor_pdp;

get_footer();
