<?php
/**
 * ALOOKHOR — home page.
 * Complete by design: managed Control Center blocks when available,
 * built-in designed sections otherwise, so the page is never empty.
 */
get_header();
?>
<main id="al-main">
	<?php alookhor_render_home(); ?>
</main>
<?php
get_footer();
