<?php
/**
 * ALOOKHOR — footer.
 * The managed footer is rendered by the Control Center plugin on the
 * `get_footer` action. If the plugin is inactive, a minimal footer appears.
 */
?>
<?php if (!alookhor_cc_active()): ?>
	<footer class="al-fb-footer">
		<div class="al-container">
			<b><?php bloginfo('name'); ?></b>
			<p><?php bloginfo('description'); ?></p>
			<small>&copy; <?php echo esc_html(date_i18n('Y')); ?> ALOOKHOR — تمامی حقوق محفوظ است.</small>
		</div>
	</footer>
<?php endif; ?>
<?php wp_footer(); ?>
</body>
</html>
