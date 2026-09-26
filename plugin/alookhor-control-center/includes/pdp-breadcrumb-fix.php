<?php
if (!defined('ABSPATH')) exit;

/**
 * Canonical PDP breadcrumb correction — v3.10.365: higher, above image, slightly below header.
 */
add_action('wp_enqueue_scripts', function(){
    if (!function_exists('is_product') || !is_product()) return;

    $css = <<<'CSS'
/* ALOOKHOR PDP — breadcrumb fix v3.10.365: above image, slightly below header */
body.alookhor-managed-product-page .alookhor-alp > .breadcrumb-wrapper,
body.alookhor-pdp-body .alookhor-alp > .breadcrumb-wrapper,
.alookhor-alp > .breadcrumb-wrapper{
  position:relative!important;
  z-index:80!important;
  transform:translateY(16px)!important;
  margin-top:12px!important;
  margin-bottom:20px!important;
  padding-left:16px!important;
  padding-right:16px!important;
}
body.alookhor-managed-product-page .breadcrumb-box,
body.alookhor-pdp-body .breadcrumb-box,
.alookhor-alp .breadcrumb-box{
  color:#fff!important;
  font-family:Dana,Vazirmatn,IRANSansX,Tahoma,sans-serif!important;
  font-size:20px!important;
  font-weight:800!important;
  line-height:1.9!important;
  min-height:58px!important;
  display:flex!important;
  align-items:center!important;
  gap:.6rem!important;
  padding:15px 20px!important;
  opacity:1!important;
  visibility:visible!important;
  background:rgba(35,14,49,.82)!important;
  border:1px solid rgba(212,175,55,.22)!important;
  border-radius:18px!important;
  box-shadow:0 16px 38px rgba(0,0,0,.28)!important;
  backdrop-filter:blur(14px)!important;
  -webkit-backdrop-filter:blur(14px)!important;
}
body.alookhor-managed-product-page .breadcrumb-box a,
body.alookhor-managed-product-page .breadcrumb-box span,
body.alookhor-managed-product-page .breadcrumb-box strong,
body.alookhor-pdp-body .breadcrumb-box a,
body.alookhor-pdp-body .breadcrumb-box span,
body.alookhor-pdp-body .breadcrumb-box strong,
.alookhor-alp .breadcrumb-box a,
.alookhor-alp .breadcrumb-box span,
.alookhor-alp .breadcrumb-box strong{
  color:#fff!important;
  font-family:Dana,Vazirmatn,IRANSansX,Tahoma,sans-serif!important;
  font-size:20px!important;
  font-weight:800!important;
  line-height:1.9!important;
  opacity:1!important;
}
.alookhor-alp .breadcrumb-box > span:last-child,
.alookhor-alp .breadcrumb-box > span:last-child a{
  font-weight:900!important;
}
.alookhor-alp .breadcrumb-box svg{
  color:#fff!important;
  stroke:#fff!important;
  width:19px!important;
  height:19px!important;
  flex:none!important;
}
@media (max-width:767px){
  body.alookhor-managed-product-page .alookhor-alp > .breadcrumb-wrapper,
  body.alookhor-pdp-body .alookhor-alp > .breadcrumb-wrapper,
  .alookhor-alp > .breadcrumb-wrapper{
    transform:translateY(8px)!important;
    margin-top:8px!important;
    margin-bottom:14px!important;
    padding-left:10px!important;
    padding-right:10px!important;
  }
  body.alookhor-managed-product-page .breadcrumb-box,
  body.alookhor-pdp-body .breadcrumb-box,
  .alookhor-alp .breadcrumb-box{
    min-height:50px!important;
    padding:11px 12px!important;
    border-radius:15px!important;
    font-size:16px!important;
    line-height:1.9!important;
    gap:.35rem!important;
  }
  body.alookhor-managed-product-page .breadcrumb-box a,
  body.alookhor-managed-product-page .breadcrumb-box span,
  body.alookhor-managed-product-page .breadcrumb-box strong,
  body.alookhor-pdp-body .breadcrumb-box a,
  body.alookhor-pdp-body .breadcrumb-box span,
  body.alookhor-pdp-body .breadcrumb-box strong,
  .alookhor-alp .breadcrumb-box a,
  .alookhor-alp .breadcrumb-box span,
  .alookhor-alp .breadcrumb-box strong{
    font-size:16px!important;
  }
  .alookhor-alp .breadcrumb-box svg{width:15px!important;height:15px!important}
}
CSS;

    if (wp_style_is('alookhor-cc-pdp', 'enqueued')) {
        wp_add_inline_style('alookhor-cc-pdp', $css);
    } else {
        wp_enqueue_style('alookhor-cc-pdp', ALOOKHOR_CC_URL.'assets/css/frontend-product.css', [], ALOOKHOR_CC_BUILD);
        wp_add_inline_style('alookhor-cc-pdp', $css);
    }

    wp_enqueue_script('alookhor-cc-pdp-smart-zoom', ALOOKHOR_CC_URL.'assets/js/pdp-smart-zoom.js', [], ALOOKHOR_CC_BUILD, true);
}, 10000);
