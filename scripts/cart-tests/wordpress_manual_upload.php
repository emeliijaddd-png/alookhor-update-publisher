<?php
/**
 * Test WordPress's "Upload Plugin > Replace current with uploaded" installation
 * path on the isolated runner. A local ZIP has no update-channel manifest and
 * must not be described as a working native Update button.
 */
if (getenv('GITHUB_ACTIONS') !== 'true'
    || !getenv('WP_SMOKE_ROOT')
    || realpath(ABSPATH) !== realpath(getenv('WP_SMOKE_ROOT') . '/')) {
    throw new RuntimeException('The manual upload test requires the isolated CI WordPress installation.');
}
require_once ABSPATH . 'wp-admin/includes/plugin.php';
require_once ABSPATH . 'wp-admin/includes/class-wp-upgrader.php';

$plugin = 'alookhor-control-center/alookhor-control-center.php';
$installed = WP_PLUGIN_DIR . '/' . $plugin;
$zip = getenv('WP_SMOKE_CANDIDATE_ZIP');
$manifest = json_decode((string) file_get_contents(getenv('WP_SMOKE_CANDIDATE_MANIFEST')), true);
if (!is_array($manifest) || !is_file($zip)
    || !hash_equals($manifest['sha256'] ?? '', hash_file('sha256', $zip))
    || !is_plugin_active($plugin)
    || get_file_data($installed, ['Version' => 'Version'])['Version'] !== '3.10.405') {
    throw new RuntimeException('The manual upload fixture is not the pinned active 405 plugin and verified candidate ZIP.');
}

// WordPress uses Plugin_Upgrader::install(overwrite_package=true) for the
// explicit owner-confirmed plugin replacement; no remote URL is configured.
$upgrader = new Plugin_Upgrader(new Automatic_Upgrader_Skin());
$result = $upgrader->install($zip, ['overwrite_package' => true]);
if ($result !== true
    || !is_plugin_active($plugin)
    || get_file_data($installed, ['Version' => 'Version'])['Version'] !== '3.10.412'
    || is_file(WP_PLUGIN_DIR . '/alookhor-control-center/includes/cart-probe.php')) {
    $reason = is_wp_error($result) ? $result->get_error_code() : gettype($result);
    throw new RuntimeException('Manual uploaded ZIP did not replace 405 cleanly: ' . $reason);
}
echo "WordPress local ZIP replacement installed 412 from active 405.\n";
