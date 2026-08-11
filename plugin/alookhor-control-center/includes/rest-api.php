<?php
/**
 * Authenticated CI/health endpoints for ALOOKHOR releases.
 * Authentication is provided by WordPress Application Passwords over HTTPS.
 */

if (!defined('ABSPATH')) exit;

function alookhor_cc_rest_update_permission(){
    if (!is_user_logged_in() || !current_user_can('update_plugins')) {
        return new WP_Error('alookhor_rest_forbidden', 'دسترسی مدیریت بروزرسانی لازم است.', ['status' => 403]);
    }
    return true;
}

function alookhor_cc_runtime_status(){
    $manifest = alookhor_cc_get_update_manifest(true);
    $manifest_data = is_wp_error($manifest) ? [
        'ok' => false,
        'error' => $manifest->get_error_code(),
        'message' => $manifest->get_error_message(),
    ] : [
        'ok' => true,
        'version' => $manifest['version'],
        'sha256' => $manifest['sha256'],
        'available' => version_compare($manifest['version'], ALOOKHOR_CC_VERSION, '>'),
        'package_host' => wp_parse_url($manifest['download_url'], PHP_URL_HOST),
    ];

    $settings = alookhor_cc_get_settings();
    $verified = get_site_transient('alookhor_cc_last_verified_package');
    return [
        'plugin' => 'alookhor-control-center',
        'version' => ALOOKHOR_CC_VERSION,
        'active' => true,
        'manifest_url' => alookhor_cc_update_manifest_url(),
        'manifest' => $manifest_data,
        'settings' => [
            'main_option' => is_array(get_option(ALOOKHOR_CC_OPTION, null)),
            'header_option' => is_array(get_option(ALOOKHOR_CC_HEADER_OPTION, null)),
            'main_option_hash' => hash('sha256', wp_json_encode(get_option(ALOOKHOR_CC_OPTION, null))),
            'header_option_hash' => hash('sha256', wp_json_encode(get_option(ALOOKHOR_CC_HEADER_OPTION, null))),
            'module_count' => is_array($settings['modules'] ?? null) ? count($settings['modules']) : 0,
            'header_shortcode' => shortcode_exists('alookhor_portal_header'),
        ],
        'last_verified_package' => is_array($verified) ? $verified : null,
        'last_activation_restore' => get_site_transient('alookhor_cc_last_activation_restore') ?: null,
        'transition_activation_restore' => get_site_transient('alookhor_ci_last_activation_restore') ?: null,
        'php' => PHP_VERSION,
        'wordpress' => get_bloginfo('version'),
        'rollback_supported' => version_compare(get_bloginfo('version'), '6.3', '>='),
        'checked_at' => current_time('mysql', true),
    ];
}

add_action('rest_api_init', function(){
    register_rest_route('alookhor-cc/v1', '/status', [
        'methods' => WP_REST_Server::READABLE,
        'permission_callback' => 'alookhor_cc_rest_update_permission',
        'callback' => function(){
            return rest_ensure_response(alookhor_cc_runtime_status());
        },
    ]);

    register_rest_route('alookhor-cc/v1', '/check-update', [
        'methods' => WP_REST_Server::CREATABLE,
        'permission_callback' => 'alookhor_cc_rest_update_permission',
        'callback' => function(){
            delete_site_transient(ALOOKHOR_CC_UPDATE_CACHE_KEY);
            $manifest = alookhor_cc_get_update_manifest(true);
            if (is_wp_error($manifest)) return $manifest;

            $transient = get_site_transient('update_plugins');
            if (!is_object($transient)) $transient = new stdClass();
            $transient->last_checked = time();
            set_site_transient('update_plugins', alookhor_cc_apply_manifest_to_update_transient($transient, $manifest));
            return rest_ensure_response(alookhor_cc_runtime_status());
        },
    ]);

    register_rest_route('alookhor-cc/v1', '/install-update', [
        'methods' => WP_REST_Server::CREATABLE,
        'permission_callback' => 'alookhor_cc_rest_update_permission',
        'args' => [
            'target_version' => [
                'required' => true,
                'type' => 'string',
                'sanitize_callback' => 'sanitize_text_field',
                'validate_callback' => function($value){
                    return (bool) preg_match('/^\d+\.\d+\.\d+$/', (string) $value);
                },
            ],
        ],
        'callback' => function(WP_REST_Request $request){
            if (version_compare(get_bloginfo('version'), '6.3', '<')) {
                return new WP_Error('alookhor_rollback_unavailable', 'بروزرسانی خودکار به WordPress 6.3 یا جدیدتر برای Rollback نیاز دارد.', ['status' => 409]);
            }
            $user_id = get_current_user_id();
            $lock_key = 'alookhor_cc_rest_update_lock_' . $user_id;
            if (get_transient($lock_key)) {
                return new WP_Error('alookhor_update_locked', 'یک عملیات بروزرسانی دیگر در حال اجراست.', ['status' => 409]);
            }
            set_transient($lock_key, 1, 5 * MINUTE_IN_SECONDS);

            try {
                $manifest = alookhor_cc_get_update_manifest(true);
                if (is_wp_error($manifest)) return $manifest;
                $target = (string) $request->get_param('target_version');
                if (!hash_equals($manifest['version'], $target)) {
                    return new WP_Error('alookhor_target_mismatch', 'نسخه درخواستی با Manifest مطابقت ندارد.', ['status' => 409]);
                }
                if (!version_compare($target, ALOOKHOR_CC_VERSION, '>')) {
                    return rest_ensure_response(['updated' => false, 'reason' => 'already_current'] + alookhor_cc_runtime_status());
                }

                $transient = get_site_transient('update_plugins');
                if (!is_object($transient)) $transient = new stdClass();
                $transient->last_checked = time();
                set_site_transient('update_plugins', alookhor_cc_apply_manifest_to_update_transient($transient, $manifest));

                require_once ABSPATH . 'wp-admin/includes/plugin.php';
                require_once ABSPATH . 'wp-admin/includes/class-wp-upgrader.php';
                $was_active = is_plugin_active(ALOOKHOR_CC_PLUGIN_BASENAME);
                $was_network_active = is_multisite() && is_plugin_active_for_network(ALOOKHOR_CC_PLUGIN_BASENAME);
                $skin = new Automatic_Upgrader_Skin();
                $upgrader = new Plugin_Upgrader($skin);
                $result = $upgrader->upgrade(ALOOKHOR_CC_PLUGIN_BASENAME, [
                    'clear_update_cache' => true,
                ]);
                if (is_wp_error($result)) return $result;
                if (!$result) {
                    $errors = $skin->get_errors();
                    return is_wp_error($errors) && $errors->has_errors()
                        ? $errors
                        : new WP_Error('alookhor_update_failed', 'WordPress بروزرسانی افزونه را کامل نکرد.');
                }

                wp_clean_plugins_cache(true);
                $activation = alookhor_cc_restore_activation_state(
                    $was_active,
                    $was_network_active,
                    'rest_install_update'
                );
                if (is_wp_error($activation)) {
                    return new WP_Error(
                        'alookhor_reactivation_failed',
                        'فایل‌های بروزرسانی نصب شدند اما وضعیت فعال افزونه بازیابی نشد.',
                        ['status' => 500, 'cause' => $activation->get_error_code()]
                    );
                }
                $plugin_data = get_plugin_data(ALOOKHOR_CC_FILE, false, false);
                return rest_ensure_response([
                    'updated' => true,
                    'version' => $plugin_data['Version'] ?? $target,
                    'target' => $target,
                    'verified_package' => get_site_transient('alookhor_cc_last_verified_package'),
                    'activation' => $activation,
                    'active' => is_plugin_active(ALOOKHOR_CC_PLUGIN_BASENAME),
                ]);
            } finally {
                delete_transient($lock_key);
            }
        },
    ]);
});
