<?php
/** ALOOKHOR luxury cart template — canonical custom shell, no WoodMart page wrapper. */
if(!defined('ABSPATH'))exit;
?><!doctype html>
<html <?php language_attributes(); ?>>
<head>
  <meta charset="<?php bloginfo('charset'); ?>">
  <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
  <?php wp_head(); ?>
  <style id="alookhor-cart-shell-fix">
    html,body{margin:0!important;padding:0!important;min-height:0!important;background:#0d0510!important}
    body.alookhor-cart-page{overflow-x:hidden!important;background:#0d0510!important}
    body.alookhor-cart-page #page,
    body.alookhor-cart-page .page-wrapper,
    body.alookhor-cart-page .main-page-wrapper,
    body.alookhor-cart-page .site-content,
    body.alookhor-cart-page .container-wrap,
    body.alookhor-cart-page .wd-page-content,
    body.alookhor-cart-page .woocommerce-cart-form,
    body.alookhor-cart-page .woocommerce{background:transparent!important;border:0!important;box-shadow:none!important;min-height:0!important}
    body.alookhor-cart-page .main-page-wrapper{padding:0!important;margin:0!important}
    body.alookhor-cart-page .site-content{padding:0!important;margin:0!important}
    body.alookhor-cart-page #alookhor-cart{margin:0!important;border:0!important;outline:0!important;min-height:0!important}
    body.alookhor-cart-page #alookhor-cart + *{margin-top:0!important}
    body.alookhor-cart-page footer,
    body.alookhor-cart-page .footer-container{margin-top:0!important}
    @media(max-width:767px){
      body.alookhor-cart-page .main-page-wrapper,body.alookhor-cart-page .site-content{padding:0!important;margin:0!important}
      body.alookhor-cart-page #alookhor-cart{padding-bottom:24px!important}
    }
  </style>
</head>
<body <?php body_class('alookhor-cart-page'); ?>>
<?php
if(function_exists('wp_body_open')) wp_body_open();
if(function_exists('alookhor_cc_render_akx_header')){
    alookhor_cc_render_akx_header();
}
?>
<main id="alookhor-cart-main" class="alookhor-cart-main" role="main">
  <?php echo alookhor_cc_cart_markup(); ?>
</main>
<?php get_footer(); ?>
</body>
</html>
