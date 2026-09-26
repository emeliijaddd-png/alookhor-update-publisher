<?php
/**
 * ALOOKHOR — header.
 * The custom header (topbar + mega menu + drawer) is rendered by the
 * ALOOKHOR Control Center plugin via [alookhor_portal_header].
 * If the plugin is inactive, a minimal built-in header keeps the site usable.
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo('charset'); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<?php if (alookhor_cc_active()): ?>
	<?php echo do_shortcode('[alookhor_portal_header]'); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
<?php else: ?>
	<header class="al-fb-header">
		<div class="al-fb-inner">
			<a class="al-fb-brand" href="<?php echo esc_url(home_url('/')); ?>">
				<span class="al-fb-mark"><?php $al_name = get_bloginfo('name'); echo esc_html($al_name ? (function_exists('mb_substr') ? mb_substr($al_name, 0, 1) : substr($al_name, 0, 1)) : 'A'); ?></span>
				<span><b><?php bloginfo('name'); ?></b><small><?php bloginfo('description'); ?></small></span>
			</a>
			<nav class="al-fb-nav">
				<?php
				wp_nav_menu(array(
					'theme_location' => 'primary',
					'container'      => false,
					'menu_class'     => '',
					'depth'          => 2,
					'fallback_cb'    => 'alookhor_fb_menu',
				));
				?>
			</nav>
			<?php if (function_exists('wc_get_cart_url')): ?>
				<a class="al-fb-cart" href="<?php echo esc_url(wc_get_cart_url()); ?>">
					سبد خرید<?php echo WC()->cart ? ' (' . WC()->cart->get_cart_contents_count() . ')' : ''; ?>
				</a>
			<?php endif; ?>
		</div>
	</header>
<?php endif; ?>
