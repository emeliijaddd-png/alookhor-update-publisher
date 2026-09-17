<?php
/**
 * ALOOKHOR — index / archive / search.
 */
get_header();
?>
<main id="al-main">
	<div class="al-page">
		<div class="al-container">
			<header class="al-page-head">
				<?php
				if (is_home() && !is_front_page()) :
					echo '<h1>' . esc_html(get_the_title(get_option('page_for_posts'))) . '</h1>';
				elseif (is_search()) :
					echo '<h1>نتایج جستجو برای «' . esc_html(get_search_query()) . '»</h1>';
				elseif (is_category() || is_tag()) :
					echo '<h1>' . esc_html(single_term_title('', false)) . '</h1>';
				else :
					echo '<h1>مطالب</h1>';
				endif;
				?>
			</header>

			<?php if (have_posts()) : ?>
				<div class="al-about-grid">
					<?php while (have_posts()) : the_post(); ?>
						<article class="al-card">
							<h3 class="al-card-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
							<p class="al-card-text"><?php the_excerpt(); ?></p>
							<a class="al-btn-outline" style="margin-top:14px;display:inline-block" href="<?php the_permalink(); ?>">ادامه‌ی مطلب</a>
						</article>
					<?php endwhile; ?>
				</div>
				<div class="al-home-more">
					<?php the_posts_pagination(); ?>
				</div>
			<?php else : ?>
				<div class="al-404">
					<h1>مطلبی پیدا نشد</h1>
					<p>هنوز مطلبی منتشر نشده است.</p>
					<a class="al-btn" href="<?php echo esc_url(home_url('/')); ?>">بازگشت به خانه</a>
				</div>
			<?php endif; ?>

		</div>
	</div>
</main>
<?php
get_footer();
