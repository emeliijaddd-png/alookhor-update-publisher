<?php
/**
 * Isolated WordPress Core Plugin_Upgrader transition from the pinned 405 ZIP
 * to the release ZIP. HTTP is mocked at WordPress's transport boundary: the
 * updater, SHA hook, unzip and filesystem replacement are real.
 * Never run against a production site or a production database.
 */
if (getenv('GITHUB_ACTIONS') !== 'true'
    || !getenv('WP_SMOKE_ROOT')
    || realpath(ABSPATH) !== realpath(getenv('WP_SMOKE_ROOT') . '/')) {
    throw new RuntimeException('The plugin upgrader test requires the isolated CI WordPress installation.');
}
require_once ABSPATH . 'wp-admin/includes/plugin.php';
require_once ABSPATH . 'wp-admin/includes/class-wp-upgrader.php';

$plugin = 'alookhor-control-center/alookhor-control-center.php';
$installed = WP_PLUGIN_DIR . '/' . $plugin;
$zip = getenv('WP_SMOKE_CANDIDATE_ZIP');
$manifest_file = getenv('WP_SMOKE_CANDIDATE_MANIFEST');
$manifest = json_decode((string) file_get_contents($manifest_file), true);
if (!is_array($manifest) || !is_file($zip)
    || !preg_match('~^https://updates\.alookhor\.ir/releases/alookhor-control-center-3\.10\.413\.zip$~', $manifest['download_url'] ?? '')
    || !hash_equals($manifest['sha256'] ?? '', hash_file('sha256', $zip))
    || !is_plugin_active($plugin)
    || get_file_data($installed, ['Version' => 'Version'])['Version'] !== '3.10.405') {
    throw new RuntimeException('The isolated 405 installation or 413 release manifest is invalid.');
}

$manifest_url = 'https://updates.alookhor.ir/manifest.json';
$package_url = $manifest['download_url'];
$served_files = [];
$sha_hook_codes = [];
$serve_corrupt = true;
$unexpected_http = false;

// The installed 405 updater has a SHA check for updates.alookhor.ir. Prove
// that it rejects changed bytes *before* Core Upgrader touches the old plugin.
add_filter('alookhor_cc_update_manifest_url', static fn() => $manifest_url);
add_filter('alookhor_cc_update_manifest_fallback_url', static fn() => '');
add_filter('pre_http_request', static function($pre, $args, $url) use (
    $manifest_url, $package_url, $manifest, $zip, &$serve_corrupt, &$served_files, &$unexpected_http
) {
    if ($url === $manifest_url) {
        return [
            'headers' => ['content-type' => 'application/json'],
            'body' => wp_json_encode($manifest),
            'response' => ['code' => 200, 'message' => 'OK'],
            'cookies' => [],
        ];
    }
    if ($url === $package_url) {
        if (empty($args['stream']) || empty($args['filename'])) {
            throw new RuntimeException('The real WordPress download_url() stream was not used.');
        }
        $filename = $args['filename'];
        $bytes = $serve_corrupt
            ? file_put_contents($filename, 'intentionally corrupt upgrade archive')
            : (copy($zip, $filename) ? filesize($zip) : false);
        if ($bytes === false) throw new RuntimeException('Could not stream the isolated release archive.');
        $served_files[] = $filename;
        return [
            'headers' => ['content-type' => 'application/zip'],
            'body' => '',
            'response' => ['code' => 200, 'message' => 'OK'],
            'cookies' => [],
            'filename' => $filename,
        ];
    }
    if (str_starts_with($url, 'https://updates.alookhor.ir/')) {
        $unexpected_http = true;
        return new WP_Error('wp_smoke_unexpected_http', 'Unexpected update-channel request in CI.');
    }
    return $pre;
}, 1, 3);
// Core Plugin_Upgrader::upgrade() can return NULL when its download fails,
// even though the actual pre-download filter returned a precise WP_Error.
// Inspect that real hook result rather than mistaking NULL for no SHA check.
add_filter('upgrader_pre_download', static function($reply, $package) use ($package_url, &$sha_hook_codes) {
    if ($package === $package_url) {
        $sha_hook_codes[] = is_wp_error($reply) ? $reply->get_error_code()
            : (is_string($reply) && is_file($reply) ? 'verified_file' : gettype($reply));
    }
    return $reply;
}, PHP_INT_MAX, 2);

$item = (object) [
    'id' => 'alookhor-control-center',
    'slug' => 'alookhor-control-center',
    'plugin' => $plugin,
    'new_version' => $manifest['version'],
    'url' => 'https://alookhor.ir',
    'package' => $package_url,
];
add_filter('pre_site_transient_update_plugins', static fn() => (object) [
    'last_checked' => time(),
    'checked' => [$plugin => '3.10.405'],
    'response' => [$plugin => $item],
    'no_update' => [],
]);

$upgrader = new Plugin_Upgrader(new Automatic_Upgrader_Skin());
$rejected = $upgrader->upgrade($plugin);
if ($sha_hook_codes !== ['alookhor_sha256_mismatch']
    || ($rejected !== null && !is_wp_error($rejected))
    || count($served_files) !== 1 || file_exists($served_files[0])
    || get_file_data($installed, ['Version' => 'Version'])['Version'] !== '3.10.405') {
    $result_code = is_wp_error($rejected) ? $rejected->get_error_code() : gettype($rejected);
    $current_version = get_file_data($installed, ['Version' => 'Version'])['Version'] ?? 'missing';
    throw new RuntimeException(sprintf(
        '405 corrupt-ZIP guard failed: result=%s hook=%s downloads=%d temp_exists=%s installed=%s',
        $result_code, implode(',', $sha_hook_codes), count($served_files),
        isset($served_files[0]) && file_exists($served_files[0]) ? 'yes' : 'no', $current_version
    ));
}
echo "Installed 405 rejected the corrupt ZIP; original plugin is unchanged.\n";

$serve_corrupt = false;
$upgrader = new Plugin_Upgrader(new Automatic_Upgrader_Skin());
$success = $upgrader->upgrade($plugin);
if ($success !== true || $unexpected_http || count($served_files) !== 2
    || $sha_hook_codes !== ['alookhor_sha256_mismatch', 'verified_file']
    || get_file_data($installed, ['Version' => 'Version'])['Version'] !== '3.10.413'
    || !is_plugin_active($plugin)
    || is_file(WP_PLUGIN_DIR . '/alookhor-control-center/includes/cart-probe.php')) {
    $reason = is_wp_error($success) ? $success->get_error_code() : var_export($success, true);
    throw new RuntimeException('WordPress Plugin_Upgrader failed the complete 405 to 413 transition: ' . $reason);
}
echo "Real WordPress Plugin_Upgrader installed 413 from 405; active plugin retained, dangerous probe removed.\n";
