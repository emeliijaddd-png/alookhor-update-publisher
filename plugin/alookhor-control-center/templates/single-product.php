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
    /* PDP breadcrumb: force a visible, responsive offset below the Arena header. */
    .alookhor-managed-product-page .alookhor-alp .breadcrumb-wrapper{
      position:relative!important;
      top:24px!important;
      margin-top:0!important;
      margin-bottom:44px!important;
      z-index:2!important;
    }
    .alookhor-managed-product-page .alookhor-alp .breadcrumb-box{
      color:#fff!important;
      font-family:Dana,Vazirmatn,IRANSansX,Tahoma,sans-serif!important;
      font-size:16px!important;
      font-weight:600!important;
      line-height:1.9!important;
      padding-top:14px!important;
      padding-bottom:14px!important;
    }
    .alookhor-managed-product-page .alookhor-alp .breadcrumb-box a,
    .alookhor-managed-product-page .alookhor-alp .breadcrumb-box span{
      color:#fff!important;
      font-family:Dana,Vazirmatn,IRANSansX,Tahoma,sans-serif!important;
      font-size:16px!important;
      font-weight:600!important;
    }
    .alookhor-managed-product-page .alookhor-alp .breadcrumb-box > span:last-child,
    .alookhor-managed-product-page .alookhor-alp .breadcrumb-box > span:last-child a{
      font-weight:800!important;
    }
    .alookhor-managed-product-page .alookhor-alp .breadcrumb-box svg{
      color:rgba(255,255,255,.58)!important;
      width:16px!important;
      height:16px!important;
      flex:none;
    }
    @media (max-width:767px){
      .alookhor-managed-product-page .alookhor-alp .breadcrumb-wrapper{
        top:14px!important;
        margin-top:0!important;
        margin-bottom:30px!important;
      }
      .alookhor-managed-product-page .alookhor-alp .breadcrumb-box{
        font-size:14px!important;
        line-height:1.85!important;
        padding:12px 12px!important;
      }
      .alookhor-managed-product-page .alookhor-alp .breadcrumb-box a,
      .alookhor-managed-product-page .alookhor-alp .breadcrumb-box span{
        font-size:14px!important;
      }
      .alookhor-managed-product-page .alookhor-alp .breadcrumb-box svg{
        width:14px!important;
        height:14px!important;
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