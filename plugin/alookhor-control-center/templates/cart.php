<?php
/** ALOOKHOR luxury cart template — permanent custom cart shell, independent from WoodMart. */
if(!defined('ABSPATH'))exit;

/* This file is the ONLY visual cart shell - no Samsung filter, show all products */

/* Prevent WooCommerce/WoodMart from rendering a second cart through hooks. */
if(function_exists('is_cart')&&is_cart()){
    remove_action('woocommerce_cart_collaterals','woocommerce_cross_sell_display');
    remove_action('woocommerce_cart_collaterals','woocommerce_cart_totals',10);
    remove_action('woocommerce_after_cart','woocommerce_cross_sell_display');
    remove_action('woocommerce_cart_is_empty','woocommerce_cart_is_empty',10);
    if(function_exists('woodmart_woocommerce_cart_empty')) remove_action('woocommerce_cart_is_empty','woodmart_woocommerce_cart_empty',10);
}

/* Dequeue only WooCommerce/cart presentation assets; the ALOOKHOR header/footer remain intact. */
add_action('wp_print_styles',static function(){
    if(!function_exists('is_cart')||!is_cart())return;
    global $wp_styles;
    if(!$wp_styles)return;
    foreach((array)$wp_styles->queue as $handle){
        $h=strtolower((string)$handle);
        if(str_contains($h,'woocommerce-cart')||str_contains($h,'wd-cart')||str_contains($h,'wd-woocommerce-cart')||str_contains($h,'woocommerce-smallscreen')){
            wp_dequeue_style($handle);
        }
    }
},PHP_INT_MAX);
?><!doctype html>
<html <?php language_attributes(); ?>>
<head>
  <meta charset="<?php bloginfo('charset'); ?>">
  <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
  <?php wp_head(); ?>
  <style id="alookhor-permanent-cart-shell">
    html,body{margin:0!important;padding:0!important;min-height:0!important;background:#0D0510!important}
    body.alookhor-managed-cart-page{overflow-x:hidden!important;background:#0D0510!important;color:#F5F3F0!important}
    /* Kill every theme surface/container around the custom cart. */
    body.alookhor-managed-cart-page #page,
    body.alookhor-managed-cart-page .page-wrapper,
    body.alookhor-managed-cart-page .main-page-wrapper,
    body.alookhor-managed-cart-page .site-content,
    body.alookhor-managed-cart-page .container-wrap,
    body.alookhor-managed-cart-page .wd-page-content,
    body.alookhor-managed-cart-page .wd-content-area,
    body.alookhor-managed-cart-page .content-area,
    body.alookhor-managed-cart-page .site-main,
    body.alookhor-managed-cart-page main#main,
    body.alookhor-managed-cart-page .entry-content,
    body.alookhor-managed-cart-page .woocommerce,
    body.alookhor-managed-cart-page .woocommerce-page,
    body.alookhor-managed-cart-page .woocommerce-cart,
    body.alookhor-managed-cart-page .woocommerce-cart-form,
    body.alookhor-managed-cart-page .wd-content-layout,
    body.alookhor-managed-cart-page .wd-entry-content,
    body.alookhor-managed-cart-page .wd-cart-content,
    body.alookhor-managed-cart-page .cart-collaterals,
    body.alookhor-managed-cart-page .shop_table{
      background:transparent!important;border:0!important;box-shadow:none!important;min-height:0!important;
    }
    body.alookhor-managed-cart-page .main-page-wrapper,
    body.alookhor-managed-cart-page .site-content,
    body.alookhor-managed-cart-page .container-wrap,
    body.alookhor-managed-cart-page .wd-page-content,
    body.alookhor-managed-cart-page .content-area,
    body.alookhor-managed-cart-page .site-main,
    body.alookhor-managed-cart-page .wd-content-layout,
    body.alookhor-managed-cart-page .wd-entry-content{padding:0!important;margin:0!important}
    body.alookhor-managed-cart-page #alookhor-cart-main{display:block!important;width:100%!important;max-width:none!important;margin:0!important;padding:0!important;background:#0D0510!important;border:0!important;box-shadow:none!important;min-height:0!important}
    body.alookhor-managed-cart-page #alookhor-cart{display:block!important;width:100%!important;max-width:none!important;margin:0!important;border:0!important;outline:0!important;box-shadow:none!important}
    body.alookhor-managed-cart-page .alookhor-cart-breadcrumb{width:min(1440px,calc(100% - 40px));margin:28px auto 0!important;padding:0!important;position:relative!important;z-index:20!important;direction:rtl!important}
    body.alookhor-managed-cart-page .alookhor-cart-breadcrumb .breadcrumb-box{color:#fff!important;font-family:Dana,Vazirmatn,IRANSansX,Tahoma,sans-serif!important;font-size:19px!important;font-weight:700!important;line-height:1.9!important;padding:16px 0!important;opacity:1!important;visibility:visible!important}
    body.alookhor-managed-cart-page .alookhor-cart-breadcrumb a,body.alookhor-managed-cart-page .alookhor-cart-breadcrumb span,body.alookhor-managed-cart-page .alookhor-cart-breadcrumb strong{color:#fff!important;font-family:Dana,Vazirmatn,IRANSansX,Tahoma,sans-serif!important;font-size:19px!important;font-weight:700!important;text-decoration:none!important}
    body.alookhor-managed-cart-page footer,body.alookhor-managed-cart-page .footer-container{margin-top:0!important}
    body.alookhor-managed-cart-page footer:before,body.alookhor-managed-cart-page .footer-container:before{display:none!important}
    @media(max-width:767px){
      body.alookhor-managed-cart-page .alookhor-cart-breadcrumb{width:calc(100% - 24px);margin-top:16px!important}
      body.alookhor-managed-cart-page .alookhor-cart-breadcrumb .breadcrumb-box,body.alookhor-managed-cart-page .alookhor-cart-breadcrumb a,body.alookhor-managed-cart-page .alookhor-cart-breadcrumb span,body.alookhor-managed-cart-page .alookhor-cart-breadcrumb strong{font-size:16px!important;line-height:1.9!important}
      body.alookhor-managed-cart-page .alookhor-cart-breadcrumb .breadcrumb-box{padding:13px 0!important}
    }
  </style>
</head>
<body <?php body_class('alookhor-managed-cart-page'); ?>>
<?php wp_body_open(); ?>
<?php if(function_exists('alookhor_cc_render_akx_header')) echo alookhor_cc_render_akx_header(); ?>
<div class="alookhor-cart-breadcrumb" aria-label="موقعیت صفحه"><div class="breadcrumb-box"><a href="<?php echo esc_url(home_url('/')); ?>">خانه</a><span aria-hidden="true"> / </span><span>سبد خرید</span></div></div>
<main id="alookhor-cart-main" class="alookhor-cart-main" role="main"><?php echo alookhor_cc_cart_markup(); ?></main>
<?php
get_footer();
?>
</body>
</html>