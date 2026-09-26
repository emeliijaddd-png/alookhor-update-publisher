<?php
/**
 * ALOOKHOR — single post / page content.
 */
get_header();
?>
<main id="al-main">
	<div class="al-page">
		<div class="al-container">
			<?php while (have_posts()) : the_post(); ?>
				<div class="al-page-head">
					<h1><?php the_title(); ?></h1>
				</div>
				<div class="al-prose">
					<?php the_content(); ?>
				</div>
			<?php endwhile; ?>
		</div>
	</div>
</main>
<?php
get_footer();
