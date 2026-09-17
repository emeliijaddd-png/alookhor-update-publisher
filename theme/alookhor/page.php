<?php
/**
 * ALOOKHOR — generic page.
 * WooCommerce pages (shop / checkout / account / …) render full-width so
 * their default layouts work; regular pages use the prose layout.
 */

function alookhor_is_wc_page()
{
	if (!class_exists('WooCommerce')) return false;
	return is_shop() || is_product() || is_product_category() || is_product_tag()
		|| (function_exists('is_cart') && is_cart())
		|| (function_exists('is_checkout') && is_checkout())
		|| (function_exists('is_account_page') && is_account_page())
		|| (function_exists('is_order_payment') && is_order_payment());
}

get_header();
?>
<main id="al-main">
	<div class="al-page">
		<div class="al-container">
			<?php while (have_posts()) : the_post(); ?>
				<?php if (!alookhor_is_wc_page()) : ?>
					<div class="al-page-head">
						<h1><?php the_title(); ?></h1>
						<?php if (has_excerpt()) : ?><p><?php the_excerpt(); ?></p><?php endif; ?>
					</div>
					<div class="al-prose">
						<?php the_content(); ?>
					</div>
				<?php else : ?>
					<div class="al-wc-content"><?php the_content(); ?></div>
				<?php endif; ?>
			<?php endwhile; ?>
		</div>
	</div>
</main>
<?php
get_footer();
