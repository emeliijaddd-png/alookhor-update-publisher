<?php
/**
 * ALOOKHOR Control Center — WordPress-native private updater.
 *
 * The release endpoint is intentionally configurable so private package URLs
 * and credentials never have to be committed to the plugin archive.
 *
 * Expected manifest (JSON):
 * {
 *   "version": "3.8.7",
 *   "download_url": "https://updates.alookhor.ir/releases/alookhor-control-center-3.8.7.zip",
 *   "details_url": "https://example.com/changelog",
 *   "requires": "6.0",
 *   "tested": "6.6",
 *   "requires_php": "8.0",
 *   "changelog": [
 *     {"tag":"FIX", "title":"Title", "desc":"Description"}
 *   ]
 * }
 */

if (!defined('ABSPATH')) exit;

const ALOOKHOR_CC_UPDATE_CACHE_KEY = 'alookhor_cc_update_manifest_v1';

/**
 * Return the private release manifest URL.
 *
 * Production default: https://updates.alookhor.ir/manifest.json
 *
 * The endpoint can still be overridden from wp-config.php or a filter:
 * define('ALOOKHOR_CC_UPDATE_MANIFEST_URL', 'https://another-host/manifest.json');
 * add_filter('alookhor_cc_update_manifest_url', fn() => 'https://another-host/manifest.json');
 */
function alookhor_cc_update_manifest_url(){
    $url = defined('ALOOKHOR_CC_UPDATE_MANIFEST_URL')
        ? (string) ALOOKHOR_CC_UPDATE_MANIFEST_URL
        : 'https://updates.alookhor.ir/manifest.json';

    $url = (string) apply_filters('alookhor_cc_update_manifest_url', $url);
    return esc_url_raw(trim($url));
}

/**
 * Normalize and validate a remote manifest before WordPress can consume it.
 */
function alookhor_cc_normalize_update_manifest($payload){
    if (!is_array($payload)) {
        return new WP_Error('alookhor_invalid_manifest', 'پاسخ سرور آپدیت JSON معتبر نیست.');
    }

    $version = sanitize_text_field($payload['version'] ?? '');
    if (!$version || !preg_match('/^\d+\.\d+\.\d+(?:[-+][0-9A-Za-z.-]+)?$/', $version)) {
        return new WP_Error('alookhor_invalid_version', 'نسخه موجود در Manifest معتبر نیست.');
    }

    $download_url = esc_url_raw($payload['download_url'] ?? $payload['package'] ?? '');
    $details_url  = esc_url_raw($payload['details_url'] ?? $payload['url'] ?? '');

    $changelog = [];
    if (!empty($payload['changelog']) && is_array($payload['changelog'])) {
        foreach ($payload['changelog'] as $entry) {
            if (!is_array($entry)) continue;
            $changelog[] = [
                'tag'   => sanitize_text_field($entry['tag'] ?? 'UPDATE'),
                'title' => sanitize_text_field($entry['title'] ?? ('v' . $version)),
                'desc'  => sanitize_textarea_field($entry['desc'] ?? $entry['description'] ?? ''),
            ];
        }
    } elseif (!empty($payload['changelog']) && is_string($payload['changelog'])) {
        $changelog[] = [
            'tag'   => 'UPDATE',
            'title' => 'نسخه ' . $version,
            'desc'  => sanitize_textarea_field(wp_strip_all_tags($payload['changelog'])),
        ];
    }

    return [
        'version'      => $version,
        'download_url' => $download_url,
        'details_url'  => $details_url ?: 'https://alookhor.ir',
        'requires'     => sanitize_text_field($payload['requires'] ?? '6.0'),
        'tested'       => sanitize_text_field($payload['tested'] ?? ''),
        'requires_php' => sanitize_text_field($payload['requires_php'] ?? '8.0'),
        'name'         => sanitize_text_field($payload['name'] ?? 'ALOOKHOR Control Center'),
        'author'       => wp_kses_post($payload['author'] ?? 'ALOOKHOR Team'),
        'description'  => wp_kses_post($payload['description'] ?? 'کنترل سنتر لوکس و ماژولار ALOOKHOR'),
        'changelog'    => $changelog,
    ];
}

/**
 * Fetch and cache the private manifest. wp_safe_remote_get prevents unsafe
 * redirects/hosts and WordPress handles TLS verification.
 */
function alookhor_cc_get_update_manifest($force = false){
    $url = alookhor_cc_update_manifest_url();
    if (!$url) {
        return new WP_Error('alookhor_updater_not_configured', 'آدرس Manifest سیستم آپدیت تنظیم نشده است.');
    }

    if (!$force) {
        $cached = get_site_transient(ALOOKHOR_CC_UPDATE_CACHE_KEY);
        if (is_array($cached) && !empty($cached['version'])) return $cached;
    }

    $response = wp_safe_remote_get($url, [
        'timeout'     => 12,
        'redirection' => 3,
        'headers'     => [
            'Accept'     => 'application/json',
            'User-Agent' => 'ALOOKHOR-Control-Center/' . ALOOKHOR_CC_VERSION . '; ' . home_url('/'),
        ],
    ]);

    if (is_wp_error($response)) return $response;

    $status = (int) wp_remote_retrieve_response_code($response);
    if ($status !== 200) {
        return new WP_Error('alookhor_update_http_error', sprintf('سرور آپدیت کد HTTP %d برگرداند.', $status));
    }

    $decoded = json_decode(wp_remote_retrieve_body($response), true);
    $manifest = alookhor_cc_normalize_update_manifest($decoded);
    if (is_wp_error($manifest)) return $manifest;

    set_site_transient(ALOOKHOR_CC_UPDATE_CACHE_KEY, $manifest, 6 * HOUR_IN_SECONDS);
    return $manifest;
}

/**
 * Merge a validated ALOOKHOR release into WordPress' update_plugins transient.
 */
function alookhor_cc_apply_manifest_to_update_transient($transient, $manifest){
    if (!is_object($transient)) $transient = new stdClass();

    $plugin = ALOOKHOR_CC_PLUGIN_BASENAME;
    if (!isset($transient->checked) || !is_array($transient->checked)) $transient->checked = [];
    if (!isset($transient->response) || !is_array($transient->response)) $transient->response = [];
    if (!isset($transient->no_update) || !is_array($transient->no_update)) $transient->no_update = [];
    $transient->checked[$plugin] = ALOOKHOR_CC_VERSION;

    $item = (object) [
        'id'           => 'alookhor-control-center',
        'slug'         => 'alookhor-control-center',
        'plugin'       => $plugin,
        'new_version'  => $manifest['version'],
        'url'          => $manifest['details_url'],
        'package'      => $manifest['download_url'],
        'requires'     => $manifest['requires'],
        'tested'       => $manifest['tested'],
        'requires_php' => $manifest['requires_php'],
    ];

    if (version_compare($manifest['version'], ALOOKHOR_CC_VERSION, '>')) {
        $transient->response[$plugin] = $item;
        unset($transient->no_update[$plugin]);
    } else {
        $transient->no_update[$plugin] = $item;
        unset($transient->response[$plugin]);
    }

    return $transient;
}

/**
 * Register a private release in WordPress' native plugin update transient.
 */
add_filter('pre_set_site_transient_update_plugins', function($transient){
    if (!alookhor_cc_update_manifest_url()) return $transient;

    $manifest = alookhor_cc_get_update_manifest(false);
    if (is_wp_error($manifest)) return $transient;

    return alookhor_cc_apply_manifest_to_update_transient($transient, $manifest);
});

/**
 * Supply the details modal used by WordPress' Plugins screen.
 */
add_filter('plugins_api', function($result, $action, $args){
    if ($action !== 'plugin_information' || empty($args->slug) || $args->slug !== 'alookhor-control-center') {
        return $result;
    }

    $manifest = alookhor_cc_get_update_manifest(false);
    if (is_wp_error($manifest)) return $result;

    $changelog_html = '';
    foreach ($manifest['changelog'] as $entry) {
        $changelog_html .= '<h4>' . esc_html($entry['title']) . '</h4><p>' . nl2br(esc_html($entry['desc'])) . '</p>';
    }

    return (object) [
        'name'          => $manifest['name'],
        'slug'          => 'alookhor-control-center',
        'version'       => $manifest['version'],
        'author'        => $manifest['author'],
        'homepage'      => $manifest['details_url'],
        'requires'      => $manifest['requires'],
        'tested'        => $manifest['tested'],
        'requires_php'  => $manifest['requires_php'],
        'download_link' => $manifest['download_url'],
        'sections'      => [
            'description' => $manifest['description'],
            'changelog'   => $changelog_html ?: '<p>جزئیات این نسخه در دسترس نیست.</p>',
        ],
    ];
}, 20, 3);

/**
 * Update Center AJAX bridge. It reports truthful native WordPress state;
 * installation itself is delegated to wp.updates.updatePlugin in admin JS.
 */
add_action('wp_ajax_alookhor_check_updates', function(){
    alookhor_cc_check();

    $force = !empty($_POST['force']) && rest_sanitize_boolean(wp_unslash($_POST['force']));
    if ($force) delete_site_transient(ALOOKHOR_CC_UPDATE_CACHE_KEY);

    $manifest = alookhor_cc_get_update_manifest($force);
    if (is_wp_error($manifest)) {
        $not_configured = $manifest->get_error_code() === 'alookhor_updater_not_configured';
        wp_send_json_success([
            'configured' => !$not_configured,
            'available'  => false,
            'installable'=> false,
            'current'    => ALOOKHOR_CC_VERSION,
            'latest'     => ALOOKHOR_CC_VERSION,
            'message'    => $manifest->get_error_message(),
            'error_code' => $manifest->get_error_code(),
            'changelog'  => [],
        ]);
    }

    $available = version_compare($manifest['version'], ALOOKHOR_CC_VERSION, '>');

    // Make the same release immediately available to WordPress' core
    // `update-plugin` AJAX action used by wp.updates.updatePlugin.
    $native_transient = get_site_transient('update_plugins');
    if (!is_object($native_transient)) $native_transient = new stdClass();
    $native_transient->last_checked = time();
    $native_transient = alookhor_cc_apply_manifest_to_update_transient($native_transient, $manifest);
    set_site_transient('update_plugins', $native_transient);

    wp_send_json_success([
        'configured'  => true,
        'available'   => $available,
        'installable' => $available && !empty($manifest['download_url']),
        'current'     => ALOOKHOR_CC_VERSION,
        'latest'      => $manifest['version'],
        'details_url' => $manifest['details_url'],
        'message'     => $available ? 'نسخه جدید آماده نصب است.' : 'افزونه به‌روز است.',
        'changelog'   => $manifest['changelog'],
    ]);
});

add_action('upgrader_process_complete', function($upgrader, $options){
    if (($options['action'] ?? '') === 'update' && ($options['type'] ?? '') === 'plugin') {
        delete_site_transient(ALOOKHOR_CC_UPDATE_CACHE_KEY);
    }
}, 10, 2);
