<?php
/**
 * ALOOKHOR — Contact page (auto-matched when the page slug is "contact").
 * Contact values come from the Control Center header settings when available.
 */
get_header();

$phone = '09222942808';
$email = get_option('admin_email');
$wa    = '989222942808';
if (alookhor_cc_active() && function_exists('alookhor_cc_front_header_settings')) {
	$h = alookhor_cc_front_header_settings();
	if (!empty($h['phone']))    $phone = $h['phone'];
	if (!empty($h['whatsapp'])) $wa    = $h['whatsapp'];
	if (!empty($h['email']))    $email = $h['email'];
}
$wa_href = alookhor_whatsapp_href($wa);
?>
<main id="al-main">
	<div class="al-page">
		<div class="al-container">
			<div class="al-page-head">
				<span class="al-section-eyebrow">در ارتباط بمانید</span>
				<h1>تماس با ما</h1>
				<p>سوالی درباره‌ی سورت، قیمت عمده یا صادرات دارید؟ همین الان پیام بدهید.</p>
			</div>

			<div class="al-contact-grid">
				<div>
					<div class="al-card" style="display:block">
						<div class="al-contact-card" style="margin-bottom:0">
							<div class="al-card-icon">
								<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M5 4h4l2 5-3 2a12 12 0 0 0 5 5l2-3 5 2v4a2 2 0 0 1-2 2A16 16 0 0 1 3 6a2 2 0 0 1 2-2Z"/></svg>
							</div>
							<div><b>تلفن / موبایل</b><span><a href="<?php echo esc_url(alookhor_phone_href($phone)); ?>"><?php echo esc_html($phone); ?></a></span></div>
						</div>
					</div>
					<div class="al-card" style="display:block;margin-top:14px">
						<div class="al-contact-card" style="margin-bottom:0">
							<div class="al-card-icon">
								<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 3a9 9 0 0 0-8 13l-1 5 5-1a9 9 0 1 0 4-17Z"/><path d="M9 9c0 4 2 6 6 6"/></svg>
							</div>
							<div><b>واتساپ</b><?php if ($wa_href): ?><span><a href="<?php echo esc_url($wa_href); ?>" target="_blank" rel="noopener">گفتگوی فوری در واتساپ</a></span><?php endif; ?></div>
						</div>
					</div>
					<div class="al-card" style="display:block;margin-top:14px">
						<div class="al-contact-card" style="margin-bottom:0">
							<div class="al-card-icon">
								<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="5" width="18" height="14" rx="2"/><path d="m3 7 9 6 9-6"/></svg>
							</div>
							<div><b>ایمیل</b><span><a href="mailto:<?php echo esc_attr($email); ?>"><?php echo esc_html($email); ?></a></span></div>
						</div>
					</div>
					<div class="al-card" style="display:block;margin-top:14px">
						<div class="al-contact-card" style="margin-bottom:0">
							<div class="al-card-icon">
								<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="9"/><path d="M12 7v5l3 3"/></svg>
							</div>
							<div><b>ساعات پاسخگویی</b><span>هر روز — ۹ صبح تا ۹ شب</span></div>
						</div>
					</div>
					<?php if ($wa_href): ?>
						<div style="margin-top:20px"><a class="al-btn" href="<?php echo esc_url($wa_href); ?>" target="_blank" rel="noopener">شروع گفتگو در واتساپ</a></div>
					<?php endif; ?>
				</div>

				<form class="al-form">
					<h3>پیام بفرستید</h3>
					<?php /* Dependency-free contact form: opens the visitor's
					   email client via mailto (no server-side handler needed). */ ?>
					<label>نام و نام خانوادگی</label>
					<input type="text" name="al_name" required>
					<label>شماره تماس</label>
					<input type="text" name="al_phone" dir="ltr" style="text-align:right">
					<label>پیام شما</label>
					<textarea name="al_message" rows="6" required></textarea>
					<button class="al-btn" type="button"
						onclick="var m=document.querySelector('.al-form textarea').value;var n=document.querySelector('.al-form [name=al_name]').value;var p=document.querySelector('.al-form [name=al_phone]').value;var s=encodeURIComponent('پیام از سایت آلوخور');var b=encodeURIComponent('نام: '+n+'\\nتلفن: '+p+'\\n\\n'+m);window.open('mailto:<?php echo esc_js($email); ?>?subject='+s+'&body='+b,'_self');">
						ارسال پیام
					</button>
					<p class="al-form-note">با زدن دکمه‌ی ارسال، برنامه‌ی ایمیل شما باز می‌شود و پیام به <?php echo esc_html($email); ?> فرستاده می‌شود. برای پاسخ سریع‌تر از واتساپ استفاده کنید.</p>
				</form>
			</div>

			<?php if (get_post() && get_post()->post_content) : ?>
				<div class="al-prose" style="margin-top:40px">
					<?php the_content(); ?>
				</div>
			<?php endif; ?>

		</div>
	</div>
</main>
<?php
get_footer();
