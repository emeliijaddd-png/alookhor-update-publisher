<?php
/** ALOOKHOR luxury cart template — simple + aggressive white hide, footer safe */
if(!defined('ABSPATH'))exit;
get_header();
?>
<style id="alookhor-cart-white-fix">
/* v3.10.361 — hide Woodmart white bars ONLY on cart page, keep luxury cart + footer safe */
body.woocommerce-cart,
body.alookhor-managed-cart-page,
html body.woocommerce-cart,
html body.alookhor-managed-cart-page {
  background:#0d0510!important;
  background-color:#0d0510!important;
}
/* Hide white titles and checkout steps - scoped to cart but also global for safety */
.wd-page-title,
.whb-page-title,
.wd-entities-title,
.wd-page-title.wd-style-default,
.wd-page-title.wd-style-centered,
.whb-page-title .container,
.wd-page-title .container,
.page-title,
.entry-header,
.wd-page-heading,
.page-heading,
.title-design-default,
.title-design-centered,
.wd-checkout-steps,
.wd-checkout-steps-wrapper,
.woocommerce-breadcrumb,
.wd-breadcrumbs,
.breadcrumbs,
.wd-title,
[class*="page-title"],
[class*="wd-entities"],
.container > .wd-page-title,
.main-page-wrapper > .wd-page-title,
.site-content > .wd-page-title,
.whb-header + .wd-page-title,
.whb-header + .main-page-wrapper .wd-page-title {
  display:none!important;
  visibility:hidden!important;
  height:0!important;
  overflow:hidden!important;
  margin:0!important;
  padding:0!important;
  opacity:0!important;
  pointer-events:none!important;
  border:none!important;
  background:transparent!important;
}
/* Also hide via body class for higher specificity */
body.woocommerce-cart .wd-page-title,
body.woocommerce-cart .whb-page-title,
body.woocommerce-cart .wd-entities-title,
body.woocommerce-cart .page-title,
body.woocommerce-cart .entry-header,
body.woocommerce-cart .wd-page-heading,
body.woocommerce-cart .wd-checkout-steps,
body.woocommerce-cart .wd-checkout-steps-wrapper {
  display:none!important;
}
body.woocommerce-cart .main-page-wrapper,
body.woocommerce-cart .site-content,
body.woocommerce-cart .wd-page-content,
body.woocommerce-cart .wd-content-area,
body.woocommerce-cart .container {
  background:transparent!important;
}
body.woocommerce-cart #alookhor-cart,
body.woocommerce-cart #alookhor-cart-main,
#alookhor-cart,
#alookhor-cart-main {
  display:block!important;
  visibility:visible!important;
  opacity:1!important;
  width:100%!important;
  max-width:none!important;
}
body.woocommerce-cart footer,
body.woocommerce-cart .site-footer,
body.woocommerce-cart .whb-footer,
body.woocommerce-cart .wd-footer,
body.woocommerce-cart .footer-container,
footer,
.site-footer,
.whb-footer,
.wd-footer,
.footer-container {
  display:block!important;
  visibility:visible!important;
  opacity:1!important;
}
</style>
<?php
echo alookhor_cc_cart_markup();
get_footer();
