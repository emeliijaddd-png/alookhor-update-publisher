<?php
/** Only for the throwaway CI site: emulate the real site's header shortcode.
 * The plugin replaces the cart page's full the_content at priority 9999, so
 * placing a header shortcode inside the page content does not render it.
 */
if (!defined('ABSPATH') || getenv('GITHUB_ACTIONS') !== 'true'
    || !getenv('WP_SMOKE_ROOT')
    || realpath(ABSPATH) !== realpath(getenv('WP_SMOKE_ROOT') . '/')) {
    return;
}
add_action('wp_footer', static function() {
    if (function_exists('is_cart') && is_cart() && shortcode_exists('alookhor_portal_header')) {
        echo do_shortcode('[alookhor_portal_header]');
    }
}, 1);
