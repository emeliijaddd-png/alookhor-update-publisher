<?php
/**
 * ALOOKHOR — home page.
 * Order: managed hero slider → managed category carousel → managed feature
 * strip → latest products (WooCommerce, when active).
 */
get_header();

$cc = alookhor_cc_active();
?>
<main id="al-main">

	<?php if ($cc): ?>
		<?php echo do_shortcode('[alookhor_managed_hero]'); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
		<?php echo do_shortcode('[alookhor_managed_categories]'); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
		<?php echo do_shortcode('[alookhor_managed_features]'); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
	<?php endif; ?>

	<?php if (class_exists('WooCommerce')): ?>
		<?php
		$al_products = new WP_Query(array(
			'post_type'      => 'product',
			'posts_per_page' => 8,
			'no_found_rows'  => true,
			'meta_key'       => 'total_sales',
			'orderby'        => array('meta_value_num' => 'DESC', 'date' => 'DESC'),
		));
		?>
		<?php if ($al_products->have_posts()): ?>
			<section class="al-section" id="al-products">
				<div class="al-container">
					<div class="al-section-head">
						<span class="al-section-eyebrow">بوتیک آلوخور</span>
						<h2 class="al-section-title">پرفروش‌ترین <em>محصولات</em></h2>
						<p class="al-section-sub">انتخاب سورت‌بندی، بسته‌بندی و صادرات — با کیفیت درجه یک</p>
					</div>
					<div class="al-products-grid">
						<?php while ($al_products->have_posts()) : $al_products->the_post(); ?>
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
						<a class="al-btn" href="<?php echo esc_url(function_exists('wc_get_page_permalink') ? wc_get_page_permalink('shop') : home_url('/shop/')); ?>">مشاهده همه محصولات</a>
					</div>
				</div>
			</section>
		<?php endif; ?>
		<?php wp_reset_postdata(); ?>
	<?php endif; ?>

</main>
<?php
get_footer();
