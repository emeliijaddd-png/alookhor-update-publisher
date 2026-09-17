<?php
/**
 * ALOOKHOR — About page (auto-matched when the page slug is "about").
 * Content is themed here; edit texts via wp-admin > Pages > درباره ما or
 * Appearance > Theme File Editor if you prefer editing the file directly.
 */
get_header();
?>
<main id="al-main">
	<div class="al-page">
		<div class="al-container">

			<section class="al-about-intro">
				<div class="al-about-brand">ALOOKHOR</div>
				<h1>درباره <em style="font-style:normal;color:var(--al-gold)">آلوخور</em></h1>
				<p>بوتیک تخصصی آلو بخارا — از انتخاب دست‌چین میوه تا سورت، بسته‌بندی و صادرات؛ تجربه‌ای لوکس از طعم اصیل خراسان.</p>
				<a class="al-btn" href="<?php echo esc_url(function_exists('wc_get_page_permalink') ? wc_get_page_permalink('shop') : home_url('/shop/')); ?>">مشاهده محصولات</a>
			</section>

			<div class="al-stats-row">
				<div class="al-stat"><b>+۵</b><span>کشور صادرات</span></div>
				<div class="al-stat"><b>۲.۴ تن</b><span>ظرفیت سورت روزانه</span></div>
				<div class="al-stat"><b>۱۰۰٪</b><span>طبیعی و ارگانیک</span></div>
				<div class="al-stat"><b>۲۴/۷</b><span>پشتیبانی مشتریان</span></div>
			</div>

			<section class="al-section">
				<div class="al-story">
					<div>
						<h3>روایت ما</h3>
						<p>آلوخور از دل میوه‌های ممتاز خراسان شروع شد؛ جایی که انتخاب، سورت و بسته‌بندی یک حرفه است. ما هر شیره را دست‌چین می‌کنیم، در سورت‌های طلایی، اقتصادی و صادراتی مرتب می‌کنیم و با بسته‌بندی لوکس به دست شما می‌رسانیم.</p>
						<p>هدف ما ساده است: بهترین آلو بخارا، با شفافیت کامل از کیفیت تا قیمت — برای سفره‌ی خانه، میهمانی و صادرات.</p>
						<ul class="al-story-points">
							<li>دست‌چینی و کنترل کیفیت در هر مرحله</li>
							<li>خط سورت و بسته‌بندی اختصاصی</li>
							<li>صادرات به ۵ کشور جهان</li>
							<li>بسته‌بندی لوکس و استاندارد صادراتی</li>
						</ul>
					</div>
					<div class="al-story-visual">
						<span class="al-story-letter">A</span>
						<small>ALOOKHOR — LUXURY DRIED PLUMS</small>
					</div>
				</div>
			</section>

			<section class="al-section">
				<div class="al-section-head">
					<span class="al-section-eyebrow">چرا آلوخور؟</span>
					<h2 class="al-section-title">استانداردهای <em>کیفیت</em> ما</h2>
					<p class="al-section-sub">چهار تعهدی که در هر بسته‌ی آلوخور رعایت می‌شود</p>
				</div>
				<div class="al-about-grid">
					<div class="al-card">
						<div class="al-card-icon">
							<svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 3 4 6v6c0 5 3.4 8.4 8 9 4.6-.6 8-4 8-9V6l-8-3Z"/></svg>
						</div>
						<h3 class="al-card-title">ضمانت اصالت</h3>
						<p class="al-card-text">فقط میوه‌ی واقعی، بدون رنگ و افزودنی؛ با گواهی و ردیابی هر شیره.</p>
					</div>
					<div class="al-card">
						<div class="al-card-icon">
							<svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="9"/><path d="m9 12 2 2 4-4"/></svg>
						</div>
						<h3 class="al-card-title">سورت درجه یک</h3>
						<p class="al-card-text">سورت‌بندی دقیق طلایی، اقتصادی و صادراتی با کنترل اندازه و کیفیت.</p>
					</div>
					<div class="al-card">
						<div class="al-card-icon">
							<svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 7h13v10H3z"/><path d="M16 10h4l1 3v4h-5z"/><circle cx="7" cy="17" r="2"/><circle cx="18" cy="17" r="2"/></svg>
						</div>
						<h3 class="al-card-title">ارسال سریع</h3>
						<p class="al-card-text">بسته‌بندی فوری و ارسال در سریع‌ترین زمان ممکن به سراسر کشور.</p>
					</div>
					<div class="al-card">
						<div class="al-card-icon">
							<svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 19V5l8-2 8 2v14"/><path d="M8 8h8M8 12h8M8 16h5"/></svg>
						</div>
						<h3 class="al-card-title">مشتری‌های VIP</h3>
						<p class="al-card-text">پکیج‌های عمده و صادراتی با شرایط ویژه برای خریداران بزرگ.</p>
					</div>
					<div class="al-card">
						<div class="al-card-icon">
							<svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 3v18M5 8c2 3 12 3 14 0M5 16c2-3 12-3 14 0"/></svg>
						</div>
						<h3 class="al-card-title">قیمت‌گذاری شفاف</h3>
						<p class="al-card-text">قیمت دقیق برای هر سورت و هر وزن؛ بدون ابهام و پنهان‌کاری.</p>
					</div>
					<div class="al-card">
						<div class="al-card-icon">
							<svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 21s-7-4.6-9-9a5 5 0 0 1 9-3 5 5 0 0 1 9 3c-2 4.4-9 9-9 9Z"/></svg>
						</div>
						<h3 class="al-card-title">پشتیبانی ۲۴/۷</h3>
						<p class="al-card-text">پاسخگویی سریع در واتساپ و تلفن، قبل و بعد از خرید.</p>
					</div>
				</div>
			</section>

			<section class="al-section">
				<div class="al-section-head">
					<span class="al-section-eyebrow">فرآیند ما</span>
					<h2 class="al-section-title">از باغ تا <em>سفرة‌ی شما</em></h2>
				</div>
				<div class="al-steps">
					<div class="al-step">
						<h4>انتخاب و خرید میوه</h4>
						<p>خرید مستقیم از باغات ممتاز خراسان در اوج کیفیت.</p>
					</div>
					<div class="al-step">
						<h4>شست‌وشو و خشک‌کردن</h4>
						<p>خشک‌کردن کنترل‌شده با حفظ طعم، رنگ و ارزش غذایی.</p>
					</div>
					<div class="al-step">
						<h4>سورت و بسته‌بندی</h4>
						<p>سورت‌بندی طلایی/اقتصادی/صادراتی و بسته‌بندی لوکس.</p>
					</div>
					<div class="al-step">
						<h4>ارسال و صادرات</h4>
						<p>ارسال سریع داخل کشور و صادرات به ۵ کشور جهان.</p>
					</div>
				</div>
			</section>

			<?php if (get_post() && get_post()->post_content) : ?>
				<div class="al-prose">
					<?php the_content(); ?>
				</div>
			<?php endif; ?>

		</div>
	</div>
</main>
<?php
get_footer();
