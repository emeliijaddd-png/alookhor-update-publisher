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
            'category_shortcode' => shortcode_exists('alookhor_managed_categories'),
            'footer_settings' => is_array($settings['footer_settings'] ?? null),
            'footer_enabled' => !empty($settings['footer_settings']['enabled']),
            'footer_module' => !empty($settings['modules']['footer']['enabled']),
            'category_settings' => is_array($settings['category_settings'] ?? null),
            'category_enabled' => !empty($settings['category_settings']['enabled']),
            'category_module' => !empty($settings['modules']['product_categories']['enabled']),
            'header_brand_migration' => is_array($settings['_migrations']['header_brand_3106'] ?? null)
                ? $settings['_migrations']['header_brand_3106']
                : null,
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
    // Public read-only Top Bar state. These values are already rendered on the
    // public page; serving them separately lets cached pages refresh managed
    // colors/content without exposing admin settings or accepting writes.
    register_rest_route('alookhor-cc/v1', '/topbar', [
        'methods' => WP_REST_Server::READABLE,
        'permission_callback' => '__return_true',
        'callback' => function(){
            $settings = alookhor_cc_front_header_settings();
            $response = rest_ensure_response([
                'version' => ALOOKHOR_CC_VERSION,
                'home_url' => home_url('/'),
                'logo_text' => sanitize_text_field($settings['logo_text'] ?? 'ALOOKHOR'),
                'gold' => sanitize_hex_color($settings['gold'] ?? '') ?: '#C9A86A',
                'sticky' => rest_sanitize_boolean($settings['sticky'] ?? true),
                'show_search' => rest_sanitize_boolean($settings['show_search'] ?? true),
                'search_placeholder' => sanitize_text_field($settings['search_placeholder'] ?? 'جستجوی محصول…'),
                'header_surface' => sanitize_hex_color($settings['header_surface'] ?? '') ?: '#0D0916',
                'header_text_color' => sanitize_hex_color($settings['header_text_color'] ?? '') ?: '#F7F2EA',
                'header_muted_color' => sanitize_hex_color($settings['header_muted_color'] ?? '') ?: '#B8B0BD',
                'header_logo_desktop_width' => max(70, min(220, absint($settings['header_logo_desktop_width'] ?? 118))),
                'header_logo_mobile_width' => max(42, min(110, absint($settings['header_logo_mobile_width'] ?? 58))),
                'phone' => sanitize_text_field($settings['phone'] ?? ''),
                'email' => sanitize_email($settings['email'] ?? ''),
                'whatsapp' => preg_replace('/\D+/', '', (string) ($settings['whatsapp'] ?? '')),
                'export_text' => sanitize_text_field($settings['export_text'] ?? ''),
                'export_url' => esc_url_raw($settings['export_url'] ?? ''),
                'wholesale_text' => sanitize_text_field($settings['wholesale_text'] ?? ''),
                'wholesale_url' => esc_url_raw($settings['wholesale_url'] ?? ''),
                'wholesale_new_tab' => rest_sanitize_boolean($settings['wholesale_new_tab'] ?? false),
                'top_logo_url' => esc_url_raw($settings['top_logo_url'] ?? ''),
                'top_logo_alt' => sanitize_text_field($settings['top_logo_alt'] ?? ''),
                'top_logo_link' => esc_url_raw($settings['top_logo_link'] ?? ''),
                'topbar_bg' => sanitize_hex_color($settings['topbar_bg'] ?? '') ?: '#11091D',
                'topbar_text_color' => sanitize_hex_color($settings['topbar_text_color'] ?? '') ?: '#E8D5B5',
                'topbar_border_color' => sanitize_hex_color($settings['topbar_border_color'] ?? '') ?: '#3A2C20',
                'topbar_button_bg' => sanitize_hex_color($settings['topbar_button_bg'] ?? '') ?: '#C9A86A',
                'topbar_button_text' => sanitize_hex_color($settings['topbar_button_text'] ?? '') ?: '#1A1206',
                'topbar_height' => max(30, min(60, absint($settings['topbar_height'] ?? 38))),
                'top_logo_width' => max(50, min(180, absint($settings['top_logo_width'] ?? 96))),
                'show_topbar' => rest_sanitize_boolean($settings['show_topbar'] ?? true),
                'show_phone' => rest_sanitize_boolean($settings['show_phone'] ?? true),
                'show_email' => rest_sanitize_boolean($settings['show_email'] ?? true),
                'show_whatsapp' => rest_sanitize_boolean($settings['show_whatsapp'] ?? true),
                'show_export' => rest_sanitize_boolean($settings['show_export'] ?? true),
                'show_wholesale' => rest_sanitize_boolean($settings['show_wholesale'] ?? true),
            ]);
            $response->header('Cache-Control', 'no-store, no-cache, must-revalidate, max-age=0');
            return $response;
        },
    ]);

    register_rest_route('alookhor-cc/v1', '/footer', [
        'methods' => WP_REST_Server::READABLE,
        'permission_callback' => '__return_true',
        'callback' => function(){
            $settings = alookhor_cc_get_footer_settings();
            $response = rest_ensure_response([
                'version' => ALOOKHOR_CC_VERSION,
                'enabled' => !empty($settings['enabled']),
                'html' => alookhor_cc_footer_markup($settings),
            ]);
            $response->header('Cache-Control', 'no-store, no-cache, must-revalidate, max-age=0');
            return $response;
        },
    ]);

    register_rest_route('alookhor-cc/v1', '/product-categories', [
        'methods' => WP_REST_Server::READABLE,
        'permission_callback' => '__return_true',
        'callback' => function(){
            $settings=alookhor_cc_get_category_settings();$terms=alookhor_cc_category_terms($settings);
            $response=rest_ensure_response(['version'=>ALOOKHOR_CC_VERSION,'enabled'=>!empty($settings['enabled']),'count'=>count($terms),'term_ids'=>array_map(fn($term)=>(int)$term->term_id,$terms),'html'=>alookhor_cc_category_markup($settings)]);
            $response->header('Cache-Control','no-store, no-cache, must-revalidate, max-age=0');return $response;
        },
    ]);

    register_rest_route('alookhor-cc/v1', '/footer-subscribe', [
        'methods' => WP_REST_Server::CREATABLE,
        'permission_callback' => '__return_true',
        'args' => [
            'email' => ['required'=>true,'type'=>'string','sanitize_callback'=>'sanitize_email'],
            'company' => ['required'=>false,'type'=>'string','sanitize_callback'=>'sanitize_text_field'],
        ],
        'callback' => function(WP_REST_Request $request){
            if ((string)$request->get_param('company') !== '') return rest_ensure_response(['message'=>'عضویت ثبت شد.']);
            $email = sanitize_email((string)$request->get_param('email'));
            if (!$email || !is_email($email)) return new WP_Error('alookhor_footer_email_invalid','ایمیل معتبر وارد کنید.',['status'=>400]);
            $ip = sanitize_text_field($_SERVER['REMOTE_ADDR'] ?? 'unknown');
            $rate_key = 'alookhor_footer_sub_' . substr(hash_hmac('sha256',$ip,wp_salt('nonce')),0,24);
            if (get_transient($rate_key)) return new WP_Error('alookhor_footer_rate_limit','لطفاً یک دقیقه بعد دوباره تلاش کنید.',['status'=>429]);
            set_transient($rate_key,1,MINUTE_IN_SECONDS);
            $subscribers = get_option('alookhor_footer_subscribers',[]);
            if (!is_array($subscribers)) $subscribers=[];
            $key = hash('sha256',strtolower($email));
            $subscribers[$key] = ['email'=>$email,'created_at'=>current_time('mysql',true)];
            if (count($subscribers)>5000) $subscribers=array_slice($subscribers,-5000,null,true);
            update_option('alookhor_footer_subscribers',$subscribers,false);
            return rest_ensure_response(['message'=>'عضویت شما با موفقیت ثبت شد.']);
        },
    ]);

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
