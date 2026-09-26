<?php
/** Real WP/Woo updater hook regression in the temporary CI installation.
 * Mocks both HTTPS downloads and never invokes Plugin_Upgrader or a live URL.
 */
if (!defined('WP_CLI') || !WP_CLI || !defined('ABSPATH') || !defined('ALOOKHOR_CC_PLUGIN_BASENAME')) {
    throw new RuntimeException('Only the isolated WP-CLI plugin installation is supported.');
}
$package = 'https://raw.githubusercontent.com/emeliijaddd-png/alookhor-update-publisher/0123456789abcdef0123456789abcdef01234567/packages/cc-release/alookhor-control-center.zip';
$manifest_url = alookhor_cc_update_manifest_url();
$manifest = array(
    'version' => '3.10.414',
    'download_url' => $package,
    'sha256' => hash('sha256', 'expected trusted ZIP'),
);
$downloaded = null;
$seen = array();
add_filter('pre_http_request', function ($pre, $args, $url) use ($manifest_url, $package, $manifest, &$downloaded, &$seen) {
    $seen[] = $url;
    if ($url !== $manifest_url && $url !== $package) {
        return new WP_Error('no_network_in_smoke', 'Unrecognized HTTP destination in local updater smoke.');
    }
    if ($url === $package) {
        // WordPress download_url() streams into this temp path. No real request.
        $downloaded = $args['filename'] ?? null;
        if (!$downloaded || file_put_contents($downloaded, 'TAMPERED ZIP') === false) {
            throw new RuntimeException('Unable to fake the temporary ZIP download.');
        }
    }
    return array(
        'headers' => array(),
        'body' => $url === $manifest_url ? wp_json_encode($manifest) : '',
        'response' => array('code' => 200, 'message' => 'OK'),
        'cookies' => array(),
        'filename' => $downloaded,
    );
}, 10, 3);

$bad_host = apply_filters('upgrader_pre_download', false,
    'https://evil.example/alookhor-control-center.zip', null,
    array('plugin' => ALOOKHOR_CC_PLUGIN_BASENAME));
if (!is_wp_error($bad_host) || $bad_host->get_error_code() !== 'alookhor_untrusted_package_host') {
    throw new RuntimeException('Updater did not reject the untrusted package host.');
}
$result = apply_filters('upgrader_pre_download', false, $package, null,
    array('plugin' => ALOOKHOR_CC_PLUGIN_BASENAME));
if (!is_wp_error($result) || $result->get_error_code() !== 'alookhor_sha256_mismatch') {
    throw new RuntimeException('Real WordPress pre-download hook accepted a corrupt ZIP.');
}
if (!$downloaded || file_exists($downloaded) || $seen !== array($manifest_url, $package)) {
    throw new RuntimeException('Unexpected real network call or leftover tampered temp file.');
}
echo "REAL WORDPRESS UPDATER SHA HOOK: GREEN (all downloads mocked; no install).\n";
