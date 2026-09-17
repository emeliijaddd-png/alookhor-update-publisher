<?php
/**
 * ALOOKHOR — shared template parts.
 *
 * Every page renders COMPLETE designed content even on a brand-new install:
 * - home sections have built-in versions (used when the Control Center
 *   plugin is off, or when its managed block renders empty);
 * - about / contact / cart layouts are dispatched from page.php by
 *   slug OR title (Persian or English), so pages are never empty.
 */

if (!defined('ABSPATH')) exit;

/* ------------------------------------------------------------------ */
/* Helpers                                                             */
/* ------------------------------------------------------------------ */

function alookhor_theme_url($path = '')
{
	return get_stylesheet_directory_uri() . '/' . ltrim($path, '/');
}

function alookhor_img($file)
{
	return alookhor_theme_url('assets/img/' . $file);
}

/** Contact info: from Control Center header settings when available. */
function alookhor_contact_info()
{
	$phone = '09159513173';
	$wa    = '989159513173';
	$email = get_option('admin_email') ?: 'info@alookhor.ir';
	if (defined('ALOOKHOR_CC_VERSION') && function_exists('alookhor_cc_front_header_settings')) {
		$h = alookhor_cc_front_header_settings();
		if (!empty($h['phone']))    $phone = $h['phone'];
		if (!empty($h['whatsapp'])) $wa    = $h['whatsapp'];
		if (!empty($h['email']))    $email = $h['email'];
	}
	return array(
		'phone'  => $phone,
		'wa'     => $wa,
		'wa_href' => alookhor_whatsapp_href($wa),
		'email'  => $email,
	);
}

/** What kind of page is this? by slug first, then title. */
function alookhor_page_kind($post = null)
{
	$post   = $post ? $post : get_post();
	$slug   = $post ? (string) $post->post_name : '';
	$title  = $post ? (string) $post->post_title : '';
	$slug_l = function_exists('mb_strtolower') ? mb_strtolower($slug) : strtolower($slug);

	if (in_array($slug_l, array('cart', 'checkout', 'sabd-kharid', 'sabd', 'سبد-خرید', 'سبد'), true)
		|| strpos($title, 'سبد') !== false || strpos($slug_l, 'cart') !== false) {
		return 'cart';
	}
	if (in_array($slug_l, array('contact', 'contact-us', 'tamas', 'tamas-ba-ma', 'تماس-با-ما', 'تماس'), true)
		|| strpos($title, 'تماس') !== false || strpos($slug_l, 'contact') !== false || strpos($slug_l, 'tamas') !== false) {
		return 'contact';
	}
	if (in_array($slug_l, array('about', 'about-us', 'darbare', 'darbare-ma', 'درباره-ما', 'درباره'), true)
		|| strpos($title, 'درباره') !== false || strpos($slug_l, 'about') !== false || strpos($slug_l, 'darbare') !== false) {
		return 'about';
	}
	return 'generic';
}

/** Is this a WooCommerce system page (shop/checkout/account/...)? */
function alookhor_is_wc_page()
{
	if (!class_exists('WooCommerce')) return false;
	return is_shop() || is_product() || is_product_category() || is_product_tag()
		|| (function_exists('is_cart') && is_cart())
		|| (function_exists('is_checkout') && is_checkout())
		|| (function_exists('is_account_page') && is_account_page())
		|| (function_exists('is_order_payment') && is_order_payment());
}

/** Render a managed shortcode; if the plugin is off or the output is
 *  essentially empty, render the built-in fallback instead. */
/**
 * Render a Control Center managed block, falling back to a built-in
 * section when the plugin is off, the block renders empty, or the output
 * references broken legacy assets (e.g. the old alookhor-categories-manager
 * image folder that does not exist on a fresh install).
 */
function alookhor_managed_or($shortcode, $fallback_fn, $reject_needle = '')
{
	if (defined('ALOOKHOR_CC_VERSION')) {
		$out  = do_shortcode($shortcode);
		$text = trim(wp_strip_all_tags($out));
		$bad  = '' !== $reject_needle && false !== strpos($out, $reject_needle);
		if (strlen($text) >= 40 && !$bad) {
			echo $out; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			return true;
		}
	}
	$fallback_fn();
	return false;
}

/* ------------------------------------------------------------------ */
/* Home: built-in sections                                             */
/* ------------------------------------------------------------------ */

function alookhor_home_hero_builtin()
{
	$c = alookhor_contact_info();
	?>
	<section class="al-hero" id="al-hero">
		<div class="al-container al-hero-inner">
			<div class="al-hero-copy">
				<span class="al-hero-kicker">محصول ممتاز خراسان</span>
				<h1 class="al-hero-title">آلو بخارا <em>ممتاز خراسان</em></h1>
				<p class="al-hero-desc">طبیعی، سالم و بدون مواد افزودنی — از باغ تا سفره‌ی شما، با سورت دقیق و بسته‌بندی لوکس.</p>
				<ul class="al-hero-features">
					<li>۱۰۰٪ طبیعی</li>
					<li>کیفیت صادراتی</li>
					<li>ارسال سریع</li>
					<li>ارسال به سراسر جهان</li>
				</ul>
				<div class="al-hero-actions">
					<a class="al-btn" href="<?php echo esc_url(function_exists('wc_get_page_permalink') ? wc_get_page_permalink('shop') : home_url('/shop/')); ?>">مشاهده محصولات</a>
					<?php if ($c['wa_href']): ?>
						<a class="al-btn-outline" href="<?php echo esc_url($c['wa_href']); ?>" target="_blank" rel="noopener">استعلام قیمت</a>
					<?php endif; ?>
				</div>
			</div>
			<div class="al-hero-visual">
				<img src="<?php echo esc_url(alookhor_img('category-plums.jpg')); ?>" alt="آلو بخارا ممتاز خراسان">
			</div>
		</div>
	</section>
	<?php
}

function alookhor_home_categories_builtin()
{
	$shop_url = function_exists('wc_get_page_permalink') ? wc_get_page_permalink('shop') : home_url('/shop/');
	$cats = array(
		array('img' => 'category-plums.jpg', 'title' => 'آلو بخارا', 'desc' => 'آلو بخارا، مغزدار حسینی، کالیفرنیا و تن شوقان'),
		array('img' => 'category-fruit-sheets.jpg', 'title' => 'برگه و میوه‌های خشک', 'desc' => 'برگه زردآلو، هلو، قیسی و میوه‌های خشک ممتاز'),
		array('img' => 'category-natural-snacks.jpg', 'title' => 'تنقلات طبیعی', 'desc' => 'کشمش، توت خشک و تنقلات طبیعی بدون افزودنی'),
		array('img' => 'category-nuts.jpg', 'title' => 'گردو و مغزها', 'desc' => 'گردو و مغزهای ممتاز با کیفیت صادراتی'),
	);
	?>
	<section class="al-section" id="al-categories">
		<div class="al-container">
			<div class="al-section-head">
				<span class="al-section-eyebrow">دسته‌بندی محصولات</span>
				<h2 class="al-section-title">محصولات طبیعی، <em>کیفیت صادراتی</em></h2>
				<p class="al-section-sub">انتخاب مستقیم از باغ‌های خراسان، آماده ارسال به سراسر جهان</p>
			</div>
			<div class="al-cat-grid">
				<?php foreach ($cats as $cat): ?>
					<a class="al-cat-card" href="<?php echo esc_url($shop_url); ?>">
						<div class="al-cat-thumb"><img src="<?php echo esc_url(alookhor_img($cat['img'])); ?>" alt="<?php echo esc_attr($cat['title']); ?>"></div>
						<div class="al-cat-body">
							<h3 class="al-cat-title"><?php echo esc_html($cat['title']); ?></h3>
							<p class="al-cat-desc"><?php echo esc_html($cat['desc']); ?></p>
						</div>
					</a>
				<?php endforeach; ?>
			</div>
		</div>
	</section>
	<?php
}

function alookhor_home_features_builtin()
{
	$items = array(
		array('t' => 'ارسال سریع', 'd' => 'در سریع‌ترین زمان ممکن', 'icon' => '<svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 7h13v10H3z"/><path d="M16 10h4l1 3v4h-5z"/><circle cx="7" cy="17" r="2"/><circle cx="18" cy="17" r="2"/></svg>'),
		array('t' => 'محصولات ارگانیک', 'd' => '100٪ طبیعی و سالم', 'icon' => '<svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 3v18M5 8c2 3 12 3 14 0M5 16c2-3 12-3 14 0"/></svg>'),
		array('t' => 'پشتیبانی ۲۴/۷', 'd' => 'همیشه در کنار شما هستیم', 'icon' => '<svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 14v-2a8 8 0 0 1 16 0v2M4 14h3v6H4zM17 14h3v6h-3zM17 20c-1 2-3 3-6 3"/></svg>'),
		array('t' => 'ضمانت کیفیت', 'd' => 'تضمین اصالت و کیفیت کالا', 'icon' => '<svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 3 4 6v6c0 5 3.4 8.4 8 9 4.6-.6 8-4 8-9V6l-8-3Z"/></svg>'),
	);
	?>
	<section class="al-section al-section-tight" id="al-features">
		<div class="al-container">
			<div class="al-features-strip">
				<?php foreach ($items as $it): ?>
					<div class="al-card al-feature-card">
						<div class="al-card-icon"><?php echo $it['icon']; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></div>
						<h3 class="al-card-title"><?php echo esc_html($it['t']); ?></h3>
						<p class="al-card-text"><?php echo esc_html($it['d']); ?></p>
					</div>
				<?php endforeach; ?>
			</div>
		</div>
	</section>
	<?php
}

function alookhor_home_products()
{
	if (!class_exists('WooCommerce')) return;
	$products = new WP_Query(array(
		'post_type'      => 'product',
		'posts_per_page' => 8,
		'no_found_rows'  => true,
		'meta_key'       => 'total_sales',
		'orderby'        => array('meta_value_num' => 'DESC', 'date' => 'DESC'),
	));
	if (!$products->have_posts()) return;
	$shop_url = function_exists('wc_get_page_permalink') ? wc_get_page_permalink('shop') : home_url('/shop/');
	?>
	<section class="al-section" id="al-products">
		<div class="al-container">
			<div class="al-section-head">
				<span class="al-section-eyebrow">بوتیک آلوخور</span>
				<h2 class="al-section-title">پرفروش‌ترین <em>محصولات</em></h2>
				<p class="al-section-sub">انتخاب سورت‌بندی، بسته‌بندی و صادرات — با کیفیت درجه یک</p>
			</div>
			<div class="al-products-grid">
				<?php while ($products->have_posts()) : $products->the_post(); ?>
					<a class="al-product-card" href="<?php the_permalink(); ?>">
						<div class="al-product-thumb">
							<?php if (has_post_thumbnail()) : ?>
								<?php the_post_thumbnail('medium'); ?>
							<?php else: ?>
								<span class="al-product-placeholder">A</span>
							<?php endif; ?>
						</div>
						<div class="al-product-info">
							<p class="al-product-title"><?php the_title(); ?></p>
							<span class="al-product-price"><?php echo wc_price(get_post_meta(get_the_ID(), '_regular_price', true)); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></span>
						</div>
					</a>
				<?php endwhile; ?>
			</div>
			<div class="al-home-more">
				<a class="al-btn" href="<?php echo esc_url($shop_url); ?>">مشاهده همه محصولات</a>
			</div>
		</div>
	</section>
	<?php
	wp_reset_postdata();
}

function alookhor_home_about_teaser()
{
	$about_url = home_url('/');
	$found = get_pages(array('number' => 20));
	foreach ((array) $found as $p) {
		$slug = function_exists('mb_strtolower') ? mb_strtolower($p->post_name) : strtolower($p->post_name);
		if (in_array($slug, array('about', 'about-us', 'darbare', 'darbare-ma', 'درباره-ما', 'درباره'), true)
			|| strpos($p->post_title, 'درباره') !== false) {
			$about_url = get_permalink($p);
			break;
		}
	}
	?>
	<section class="al-section" id="al-about-teaser">
		<div class="al-container">
			<div class="al-about-intro" style="padding:44px 34px">
				<div class="al-about-brand">ALOOKHOR</div>
				<h2 style="font-size:24px;margin:0 0 10px">بوتیک تخصصی آلو بخارا — <em style="font-style:normal;color:var(--al-gold)">سورت، بسته‌بندی و صادرات</em></h2>
				<p>از انتخاب دست‌چین میوه تا سورت، بسته‌بندی لوکس و صادرات؛ تجربه‌ای متفاوت از طعم اصیل خراسان.</p>
				<a class="al-btn" href="<?php echo esc_url($about_url); ?>">درباره‌ی ما</a>
			</div>
		</div>
	</section>
	<?php
}

function alookhor_home_contact_cta()
{
	$c = alookhor_contact_info();
	$contact_url = home_url('/');
	$found = get_pages(array('number' => 20));
	foreach ((array) $found as $p) {
		$slug = function_exists('mb_strtolower') ? mb_strtolower($p->post_name) : strtolower($p->post_name);
		if (in_array($slug, array('contact', 'contact-us', 'tamas', 'tamas-ba-ma', 'تماس-با-ما', 'تماس'), true)
			|| strpos($p->post_title, 'تماس') !== false) {
			$contact_url = get_permalink($p);
			break;
		}
	}
	?>
	<section class="al-section" id="al-contact-cta">
		<div class="al-container">
			<div class="al-cta-band">
				<div>
					<h2 class="al-section-title" style="margin-bottom:6px">سوالی دارید؟ <em>همین الان صحبت کنیم</em></h2>
					<p class="al-section-sub" style="margin-bottom:0">تلفن: <span dir="ltr"><?php echo esc_html($c['phone']); ?></span> &nbsp;|&nbsp; ایمیل: <span dir="ltr"><?php echo esc_html($c['email']); ?></span></p>
				</div>
				<div class="al-cta-actions">
					<a class="al-btn" href="<?php echo esc_url($contact_url); ?>">تماس با ما</a>
					<?php if ($c['wa_href']): ?>
						<a class="al-btn-outline" href="<?php echo esc_url($c['wa_href']); ?>" target="_blank" rel="noopener">واتساپ</a>
					<?php endif; ?>
				</div>
			</div>
		</div>
	</section>
	<?php
}

/** Full home content (used by front-page.php AND by the blog front page). */
function alookhor_render_home()
{
	$cc = defined('ALOOKHOR_CC_VERSION');
	if ($cc) {
		/* The plugin's default hero images live in the old
		 * alookhor-categories-manager folder — dead links on a fresh
		 * install. Until real hero images are set in the Control Center,
		 * use the built-in hero (bundled images). */
		alookhor_managed_or('[alookhor_managed_hero]', 'alookhor_home_hero_builtin', 'alookhor-categories-manager');
		alookhor_managed_or('[alookhor_managed_categories]', 'alookhor_home_categories_builtin');
	} else {
		alookhor_home_hero_builtin();
		alookhor_home_categories_builtin();
	}
	alookhor_home_features_builtin();
	alookhor_home_products();
	alookhor_home_about_teaser();
	alookhor_home_contact_cta();
}

/* ------------------------------------------------------------------ */
/* Page layouts (dispatched from page.php) */
/* ------------------------------------------------------------------ */

function alookhor_layout_about()
{
	$shop_url = function_exists('wc_get_page_permalink') ? wc_get_page_permalink('shop') : home_url('/shop/');
	?>
	<div class="al-about-intro">
		<div class="al-about-brand">ALOOKHOR</div>
		<h1>درباره <em style="font-style:normal;color:var(--al-gold)">آلوخور</em></h1>
		<p>بوتیک تخصصی آلو بخارا — از انتخاب دست‌چین میوه تا سورت، بسته‌بندی و صادرات؛ تجربه‌ای لوکس از طعم اصیل خراسان.</p>
		<a class="al-btn" href="<?php echo esc_url($shop_url); ?>">مشاهده محصولات</a>
	</div>

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
				<div class="al-card-icon"><svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 3 4 6v6c0 5 3.4 8.4 8 9 4.6-.6 8-4 8-9V6l-8-3Z"/></svg></div>
				<h3 class="al-card-title">ضمانت اصالت</h3>
				<p class="al-card-text">فقط میوه‌ی واقعی، بدون رنگ و افزودنی؛ با گواهی و ردیابی هر شیره.</p>
			</div>
			<div class="al-card">
				<div class="al-card-icon"><svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="9"/><path d="m9 12 2 2 4-4"/></svg></div>
				<h3 class="al-card-title">سورت درجه یک</h3>
				<p class="al-card-text">سورت‌بندی دقیق طلایی، اقتصادی و صادراتی با کنترل اندازه و کیفیت.</p>
			</div>
			<div class="al-card">
				<div class="al-card-icon"><svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 7h13v10H3z"/><path d="M16 10h4l1 3v4h-5z"/><circle cx="7" cy="17" r="2"/><circle cx="18" cy="17" r="2"/></svg></div>
				<h3 class="al-card-title">ارسال سریع</h3>
				<p class="al-card-text">بسته‌بندی فوری و ارسال در سریع‌ترین زمان ممکن به سراسر کشور.</p>
			</div>
			<div class="al-card">
				<div class="al-card-icon"><svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 19V5l8-2 8 2v14"/><path d="M8 8h8M8 12h8M8 16h5"/></svg></div>
				<h3 class="al-card-title">مشتری‌های VIP</h3>
				<p class="al-card-text">پکیج‌های عمده و صادراتی با شرایط ویژه برای خریداران بزرگ.</p>
			</div>
			<div class="al-card">
				<div class="al-card-icon"><svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 3v18M5 8c2 3 12 3 14 0M5 16c2-3 12-3 14 0"/></svg></div>
				<h3 class="al-card-title">قیمت‌گذاری شفاف</h3>
				<p class="al-card-text">قیمت دقیق برای هر سورت و هر وزن؛ بدون ابهام و پنهان‌کاری.</p>
			</div>
			<div class="al-card">
				<div class="al-card-icon"><svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 21s-7-4.6-9-9a5 5 0 0 1 9-3 5 5 0 0 1 9 3c-2 4.4-9 9-9 9Z"/></svg></div>
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
			<div class="al-step"><h4>انتخاب و خرید میوه</h4><p>خرید مستقیم از باغات ممتاز خراسان در اوج کیفیت.</p></div>
			<div class="al-step"><h4>شست‌وشو و خشک‌کردن</h4><p>خشک‌کردن کنترل‌شده با حفظ طعم، رنگ و ارزش غذایی.</p></div>
			<div class="al-step"><h4>سورت و بسته‌بندی</h4><p>سورت‌بندی طلایی/اقتصادی/صادراتی و بسته‌بندی لوکس.</p></div>
			<div class="al-step"><h4>ارسال و صادرات</h4><p>ارسال سریع داخل کشور و صادرات به ۵ کشور جهان.</p></div>
		</div>
	</section>

	<?php $p = get_post(); if ($p && !empty($p->post_content)) : ?>
		<div class="al-prose"><?php echo $p->post_content; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></div>
	<?php endif; ?>
	<?php
}

function alookhor_layout_contact()
{
	$c = alookhor_contact_info();
	?>
	<div class="al-contact-grid">
		<div>
			<div class="al-card" style="display:block">
				<div class="al-contact-card" style="margin-bottom:0">
					<div class="al-card-icon"><svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M5 4h4l2 5-3 2a12 12 0 0 0 5 5l2-3 5 2v4a2 2 0 0 1-2 2A16 16 0 0 1 3 6a2 2 0 0 1 2-2Z"/></svg></div>
					<div><b>تلفن / موبایل</b><span><a href="<?php echo esc_url(alookhor_phone_href($c['phone'])); ?>" dir="ltr"><?php echo esc_html($c['phone']); ?></a></span></div>
				</div>
			</div>
			<div class="al-card" style="display:block;margin-top:14px">
				<div class="al-contact-card" style="margin-bottom:0">
					<div class="al-card-icon"><svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 3a9 9 0 0 0-8 13l-1 5 5-1a9 9 0 1 0 4-17Z"/><path d="M9 9c0 4 2 6 6 6"/></svg></div>
					<div><b>واتساپ</b><?php if ($c['wa_href']): ?><span><a href="<?php echo esc_url($c['wa_href']); ?>" target="_blank" rel="noopener">گفتگوی فوری در واتساپ</a></span><?php endif; ?></div>
				</div>
			</div>
			<div class="al-card" style="display:block;margin-top:14px">
				<div class="al-contact-card" style="margin-bottom:0">
					<div class="al-card-icon"><svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="5" width="18" height="14" rx="2"/><path d="m3 7 9 6 9-6"/></svg></div>
					<div><b>ایمیل</b><span><a href="mailto:<?php echo esc_attr($c['email']); ?>" dir="ltr"><?php echo esc_html($c['email']); ?></a></span></div>
				</div>
			</div>
			<div class="al-card" style="display:block;margin-top:14px">
				<div class="al-contact-card" style="margin-bottom:0">
					<div class="al-card-icon"><svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="9"/><path d="M12 7v5l3 3"/></svg></div>
					<div><b>ساعات پاسخگویی</b><span>هر روز — ۹ صبح تا ۹ شب</span></div>
				</div>
			</div>
			<?php if ($c['wa_href']): ?>
				<div style="margin-top:20px"><a class="al-btn" href="<?php echo esc_url($c['wa_href']); ?>" target="_blank" rel="noopener">شروع گفتگو در واتساپ</a></div>
			<?php endif; ?>
		</div>

		<form class="al-form">
			<h3>پیام بفرستید</h3>
			<label>نام و نام خانوادگی</label>
			<input type="text" name="al_name" required>
			<label>شماره تماس</label>
			<input type="text" name="al_phone" dir="ltr" style="text-align:right">
			<label>پیام شما</label>
			<textarea name="al_message" rows="6" required></textarea>
			<button class="al-btn" type="button"
				onclick="var m=document.querySelector('.al-form textarea').value;var n=document.querySelector('.al-form [name=al_name]').value;var p=document.querySelector('.al-form [name=al_phone]').value;var s=encodeURIComponent('پیام از سایت آلوخور');var b=encodeURIComponent('نام: '+n+'\\nتلفن: '+p+'\\n\\n'+m);window.open('mailto:<?php echo esc_js($c['email']); ?>?subject='+s+'&body='+b,'_self');">
				ارسال پیام
			</button>
			<p class="al-form-note">با زدن دکمه‌ی ارسال، برنامه‌ی ایمیل شما باز می‌شود و پیام به <?php echo esc_html($c['email']); ?> فرستاده می‌شود. برای پاسخ سریع‌تر از واتساپ استفاده کنید.</p>
		</form>
	</div>

	<?php $p = get_post(); if ($p && !empty($p->post_content)) : ?>
		<div class="al-prose" style="margin-top:40px"><?php echo $p->post_content; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></div>
	<?php endif; ?>
	<?php
}

function alookhor_layout_cart()
{
	if (class_exists('WooCommerce') && function_exists('woocommerce_cart')) {
		woocommerce_cart();
		$shop_url = function_exists('wc_get_page_permalink') ? wc_get_page_permalink('shop') : home_url('/shop/');
		echo '<div style="text-align:center;margin-top:28px"><a class="al-btn-outline" href="' . esc_url($shop_url) . '">ادامه‌ی خرید</a></div>';
	} else {
		?>
		<div class="al-404" style="padding:60px 20px">
			<div class="al-404-code">🛒</div>
			<h1>سبد خرید</h1>
			<p>برای فعال شدن سبد خرید، افزونه‌ی <b>WooCommerce</b> باید نصب و فعال باشد.<br>
			بعد از فعال‌سازی، همین صفحه سبد خرید را نمایش می‌دهد.</p>
			<a class="al-btn" href="<?php echo esc_url(home_url('/')); ?>">بازگشت به خانه</a>
		</div>
		<?php
	}
}

function alookhor_layout_generic_empty_hint()
{
	?>
	<div class="al-prose" style="text-align:center;padding:30px 0">
		<p style="font-size:16px">این صفحه هنوز محتوا ندارد. از پیشخوان وردپرس می‌توانید برای این صفحه متن بنویسید — قالب ظاهر آن را خودش می‌سازد.</p>
		<p><a class="al-btn-outline" href="<?php echo esc_url(home_url('/')); ?>">بازگشت به صفحه‌ی اصلی</a></p>
	</div>
	<?php
}
