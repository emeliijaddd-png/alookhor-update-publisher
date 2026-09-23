<?php
/** ALOOKHOR luxury single-product template — canonical AKX/Arena header + managed PDP. */
if(!defined('ABSPATH'))exit;
?><!doctype html>
<html <?php language_attributes(); ?>>
<head>
  <meta charset="<?php bloginfo('charset'); ?>">
  <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
  <?php wp_head(); ?>
  <style id="alookhor-pdp-breadcrumb-refinement">
    /* PDP breadcrumb: direct selectors are intentional so the rule still applies when the PDP wrapper changes. */
    body.alookhor-managed-product-page .breadcrumb-wrapper{
      position:relative!important;
      top:0!important;
      margin-top:30px!important;
      margin-bottom:26px!important;
      z-index:5!important;
      transform:translateY(18px)!important;
    }
    body.alookhor-managed-product-page .breadcrumb-box{
      color:#fff!important;
      font-family:Dana,Vazirmatn,IRANSansX,Tahoma,sans-serif!important;
      font-size:19px!important;
      font-weight:700!important;
      line-height:1.9!important;
      padding:16px 0!important;
      opacity:1!important;
      visibility:visible!important;
    }
    body.alookhor-managed-product-page .breadcrumb-box a,
    body.alookhor-managed-product-page .breadcrumb-box span,
    body.alookhor-managed-product-page .breadcrumb-box strong{
      color:#fff!important;
      font-family:Dana,Vazirmatn,IRANSansX,Tahoma,sans-serif!important;
      font-size:19px!important;
      font-weight:700!important;
      opacity:1!important;
    }
    body.alookhor-managed-product-page .breadcrumb-box > span:last-child,
    body.alookhor-managed-product-page .breadcrumb-box > span:last-child a{
      font-weight:800!important;
    }
    body.alookhor-managed-product-page .breadcrumb-box svg{
      color:#fff!important;
      stroke:#fff!important;
      width:18px!important;
      height:18px!important;
      flex:none;
    }
    @media (max-width:767px){
      body.alookhor-managed-product-page .breadcrumb-wrapper{
        margin-top:18px!important;
        margin-bottom:20px!important;
        transform:translateY(12px)!important;
      }
      body.alookhor-managed-product-page .breadcrumb-box{
        font-size:16px!important;
        line-height:1.9!important;
        padding:13px 12px!important;
        white-space:normal!important;
      }
      body.alookhor-managed-product-page .breadcrumb-box a,
      body.alookhor-managed-product-page .breadcrumb-box span,
      body.alookhor-managed-product-page .breadcrumb-box strong{
        font-size:16px!important;
      }
      body.alookhor-managed-product-page .breadcrumb-box svg{
        width:15px!important;
        height:15px!important;
      }
    }
  </style>
</head>
<body <?php body_class('alookhor-managed-product-page'); ?>>
<?php wp_body_open(); ?>
<?php
/* Canonical Arena/AKX header only; the WoodMart theme header is intentionally bypassed. */
if(function_exists('alookhor_cc_render_akx_header')) echo alookhor_cc_render_akx_header();

$alookhor_pdp=alookhor_cc_pdp_markup();
echo $alookhor_pdp;

get_footer();