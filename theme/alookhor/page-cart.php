<?php
/**
 * ALOOKHOR — Cart page (auto-matched when the page slug is "cart").
 * Renders the WooCommerce cart when available.
 */
get_header();
?>
<main id="al-main">
	<div class="al-page">
		<div class="al-container">
			<?php if (class_exists('WooCommerce') && function_exists('woocommerce_cart')) : ?>
				<div class="al-page-head">
					<h1>سبد خرید</h1>
				</div>
				<?php woocommerce_cart(); ?>
				<div style="text-align:center;margin-top:28px">
					<a class="al-btn-outline" href="<?php echo esc_url(function_exists('wc_get_page_permalink') ? wc_get_page_permalink('shop') : home_url('/shop/')); ?>">ادامه‌ی خرید</a>
				</div>
			<?php else : ?>
				<div class="al-404">
					<div class="al-404-code">🛒</div>
					<h1>سبد خرید</h1>
					<p>برای فعال شدن سبد خرید، افزونه‌ی <b>WooCommerce</b> باید نصب و فعال باشد.<br>
					بعد از فعال‌سازی، همین صفحه سبد خرید را نمایش می‌دهد.</p>
					<a class="al-btn" href="<?php echo esc_url(home_url('/')); ?>">بازگشت به خانه</a>
				</div>
			<?php endif; ?>
		</div>
	</div>
</main>
<?php
get_footer();
