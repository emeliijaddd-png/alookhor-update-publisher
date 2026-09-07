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
    /* PDP breadcrumb: visually separated from the Arena header, larger and white. */
    .alookhor-managed-product-page .alookhor-alp .alp-crumbs{
      margin-top:16px;
      padding:13px 6px 20px;
      color:#fff!important;
      font-family:Dana,Vazirmatn,IRANSansX,Tahoma,sans-serif!important;
      font-size:15px!important;
      font-weight:600;
      line-height:1.9;
    }
    .alookhor-managed-product-page .alookhor-alp .alp-crumbs a{
      color:#fff!important;
      font-size:15px!important;
      font-weight:600;
    }
    .alookhor-managed-product-page .alookhor-alp .alp-crumbs span{
      color:#fff!important;
      font-size:15px!important;
      font-weight:800;
    }
    .alookhor-managed-product-page .alookhor-alp .alp-crumbs i{
      color:rgba(255,255,255,.58)!important;
    }
    @media (max-width:767px){
      .alookhor-managed-product-page .alookhor-alp .alp-crumbs{
        margin-top:11px;
        padding:11px 8px 17px;
        font-size:14px!important;
        line-height:1.85;
      }
      .alookhor-managed-product-page .alookhor-alp .alp-crumbs a,
      .alookhor-managed-product-page .alookhor-alp .alp-crumbs span{
        font-size:14px!important;
      }
    }
  </style>
</head>
<body <?php body_class('alookhor-managed-product-page'); ?>>
<?php wp_body_open(); ?>
<?php
/* Do not call get_header(): that would reintroduce WoodMart's theme header. */
if(function_exists('alookhor_cc_render_akx_header')) echo alookhor_cc_render_akx_header();

$alookhor_pdp=alookhor_cc_pdp_markup();
echo $alookhor_pdp;

get_footer();