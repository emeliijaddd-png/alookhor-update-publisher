<?php
/** ALOOKHOR luxury cart template — canonical managed shell, same channel as PDP. */
if(!defined('ABSPATH'))exit;

// Keep the existing cart renderer; only the page shell is changed so Cart uses the
// exact same canonical header/footer route as the managed single-product page.
$alookhor_cart_name_guard = null;
if(function_exists('alookhor_cc_cart_markup')){
    $alookhor_cart_name_guard = static function($name){
        return str_replace(['سامسونگ','گوشی'], ['سام‌سونگ','گوشی‌'], $name);
    };
    add_filter('woocommerce_product_get_name',$alookhor_cart_name_guard,PHP_INT_MAX,1);
    add_filter('woocommerce_product_variation_get_name',$alookhor_cart_name_guard,PHP_INT_MAX,1);
}
?><!doctype html>
<html <?php language_attributes(); ?>>
<head>
  <meta charset="<?php bloginfo('charset'); ?>">
  <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
  <?php wp_head(); ?>
  <style id="alookhor-managed-cart-shell">
    html,body{margin:0!important;padding:0!important;min-height:0!important;background:#0D0510!important}
    body.alookhor-managed-cart-page{overflow-x:hidden!important;background:#0D0510!important;color:#F5F3F0!important}
    /* Same page-shell strategy as the working managed PDP: theme wrappers never paint a white surface. */
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
    body.alookhor-managed-cart-page .wd-entry-content{
      background:transparent!important;
      border:0!important;
      box-shadow:none!important;
      min-height:0!important;
    }
    body.alookhor-managed-cart-page .main-page-wrapper,
    body.alookhor-managed-cart-page .site-content,
    body.alookhor-managed-cart-page .container-wrap,
    body.alookhor-managed-cart-page .wd-page-content,
    body.alookhor-managed-cart-page .content-area,
    body.alookhor-managed-cart-page .site-main,
    body.alookhor-managed-cart-page .wd-content-layout,
    body.alookhor-managed-cart-page .wd-entry-content{
      padding:0!important;margin:0!important;
    }
    body.alookhor-managed-cart-page #alookhor-cart-main{
      display:block!important;width:100%!important;max-width:none!important;
      margin:0!important;padding:0!important;background:#0D0510!important;
      border:0!important;box-shadow:none!important;min-height:0!important;
    }
    body.alookhor-managed-cart-page #alookhor-cart{
      display:block!important;width:100%!important;max-width:none!important;
      margin:0!important;border:0!important;outline:0!important;
      box-shadow:none!important;
    }
    /* Cart breadcrumb uses the exact visual language of the PDP breadcrumb. */
    body.alookhor-managed-cart-page .alookhor-cart-breadcrumb{
      width:min(1440px,calc(100% - 40px));
      margin:28px auto 0!important;
      padding:0!important;
      position:relative!important;
      z-index:20!important;
      direction:rtl!important;
    }
    body.alookhor-managed-cart-page .alookhor-cart-breadcrumb .breadcrumb-box{
      color:#fff!important;
      font-family:Dana,Vazirmatn,IRANSansX,Tahoma,sans-serif!important;
      font-size:19px!important;
      font-weight:700!important;
      line-height:1.9!important;
      padding:16px 0!important;
      opacity:1!important;
      visibility:visible!important;
    }
    body.alookhor-managed-cart-page .alookhor-cart-breadcrumb a,
    body.alookhor-managed-cart-page .alookhor-cart-breadcrumb span,
    body.alookhor-managed-cart-page .alookhor-cart-breadcrumb strong{
      color:#fff!important;
      font-family:Dana,Vazirmatn,IRANSansX,Tahoma,sans-serif!important;
      font-size:19px!important;
      font-weight:700!important;
      text-decoration:none!important;
    }
    body.alookhor-managed-cart-page .alookhor-cart-breadcrumb svg{color:#fff!important;stroke:#fff!important;width:18px!important;height:18px!important}
    body.alookhor-managed-cart-page footer,
    body.alookhor-managed-cart-page .footer-container{margin-top:0!important}
    body.alookhor-managed-cart-page footer:before,
    body.alookhor-managed-cart-page .footer-container:before{display:none!important}
    @media(max-width:767px){
      body.alookhor-managed-cart-page .alookhor-cart-breadcrumb{width:calc(100% - 24px);margin-top:16px!important}
      body.alookhor-managed-cart-page .alookhor-cart-breadcrumb .breadcrumb-box,
      body.alookhor-managed-cart-page .alookhor-cart-breadcrumb a,
      body.alookhor-managed-cart-page .alookhor-cart-breadcrumb span,
      body.alookhor-managed-cart-page .alookhor-cart-breadcrumb strong{font-size:16px!important;line-height:1.9!important}
      body.alookhor-managed-cart-page .alookhor-cart-breadcrumb .breadcrumb-box{padding:13px 0!important}
      body.alookhor-managed-cart-page .alookhor-cart-breadcrumb svg{width:15px!important;height:15px!important}
    }
  </style>
</head>
<body <?php body_class('alookhor-managed-cart-page'); ?>>
<?php wp_body_open(); ?>
<?php
/* Canonical Arena/AKX header — exactly the same entry point used by the managed PDP. */
if(function_exists('alookhor_cc_render_akx_header')) echo alookhor_cc_render_akx_header();
?>

<div class="alookhor-cart-breadcrumb" aria-label="موقعیت صفحه">
  <div class="breadcrumb-box">
    <a href="<?php echo esc_url(home_url('/')); ?>">خانه</a>
    <span aria-hidden="true"> / </span>
    <span>سبد خرید</span>
  </div>
</div>

<main id="alookhor-cart-main" class="alookhor-cart-main" role="main">
  <?php echo alookhor_cc_cart_markup(); ?>
</main>

<?php
if($alookhor_cart_name_guard){
    remove_filter('woocommerce_product_get_name',$alookhor_cart_name_guard,PHP_INT_MAX);
    remove_filter('woocommerce_product_variation_get_name',$alookhor_cart_name_guard,PHP_INT_MAX);
}
get_footer();
?>
</body>
</html>
