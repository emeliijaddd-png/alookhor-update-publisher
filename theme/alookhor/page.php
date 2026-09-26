<?php
/**
 * ALOOKHOR — generic page dispatcher.
 *
 * The layout is chosen by page slug OR title (Persian/English), so the
 * designed About / Contact / Cart pages work even if the page was created
 * with a Persian slug like "تماس-با-ما".
 */

get_header();
?>
<main id="al-main">
	<div class="al-page">
		<div class="al-container">
			<?php while (have_posts()) : the_post();
				if (alookhor_is_wc_page()) {
					// WooCommerce shop/checkout/account: full-width default layout
					echo '<div class="al-wc-content">'; the_content(); echo '</div>';
					continue;
				}
				$kind = alookhor_page_kind(get_post());
				?>
				<div class="al-page-head">
					<h1>
						<?php
						if ($kind === 'about')   echo 'درباره <em style="font-style:normal;color:var(--al-gold)">ما</em>';
						elseif ($kind === 'contact') echo 'تماس با <em style="font-style:normal;color:var(--al-gold)">ما</em>';
						elseif ($kind === 'cart') echo 'سبد خرید';
						else the_title();
						?>
					</h1>
				</div>
				<?php
				if ($kind === 'about') {
					alookhor_layout_about();
				} elseif ($kind === 'contact') {
					alookhor_layout_contact();
				} elseif ($kind === 'cart') {
					alookhor_layout_cart();
				} elseif (!empty(get_post()->post_content)) {
					echo '<div class="al-prose">'; the_content(); echo '</div>';
				} else {
					alookhor_layout_generic_empty_hint();
				}
				?>
			<?php endwhile; ?>
		</div>
	</div>
</main>
<?php
get_footer();
