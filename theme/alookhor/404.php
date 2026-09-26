<?php
/**
 * ALOOKHOR — 404.
 */
get_header();
?>
<main id="al-main">
	<div class="al-container">
		<div class="al-404">
			<div class="al-404-code">404</div>
			<h1>صفحه‌ای پیدا نشد</h1>
			<p>ممکن است آدرس اشتباه تایپ شده باشد یا صفحه جابه‌جا شده باشد.</p>
			<a class="al-btn" href="<?php echo esc_url(home_url('/')); ?>">بازگشت به صفحه‌ی اصلی</a>
		</div>
	</div>
</main>
<?php
get_footer();
