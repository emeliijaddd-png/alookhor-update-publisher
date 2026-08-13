<?php
/**
 * ALOOKHOR Luxury Portal Header — [alookhor_portal_header]
 *
 * Recovery rules:
 * 1) Never override an older registered implementation of the shortcode.
 * 2) If no legacy provider exists, render the recovered two-level header.
 * 3) Menus come from WordPress automatically; no duplicated static nav data.
 */

if (!defined('ABSPATH')) exit;

function alookhor_cc_front_header_settings(){
    $site = alookhor_cc_get_settings();
    $saved = get_option(ALOOKHOR_CC_HEADER_OPTION, []);
    if (!is_array($saved)) $saved = [];

    $defaults = [
        'logo_text'       => $site['header_settings']['logo_text'] ?? $site['site']['name'] ?? 'ALOOKHOR',
        'logo_sub'        => $site['header_settings']['logo_sub'] ?? $site['site']['subtitle'] ?? 'آلوخور؛ طعم اصیل خراسان',
        'logo_letter'     => $site['site']['logoLetter'] ?? 'A',
        'gold'            => $site['site']['goldAccent'] ?? '#C9A86A',
        'header_surface'  => '#0D0916',
        'header_text_color' => '#F7F2EA',
        'header_muted_color' => '#B8B0BD',
        'header_logo_desktop_width' => 118,
        'header_logo_mobile_width' => 58,
        'sticky'          => true,
        'show_search'     => false,
        'search_placeholder' => 'جستجوی محصول…',
        'show_topbar'     => true,
        'show_account'    => true,
        'show_contact'    => true,
        'show_phone'      => true,
        'show_email'      => true,
        'show_whatsapp'   => true,
        'show_export'     => true,
        'show_wholesale'  => true,
        'email'           => sanitize_email(get_option('admin_email')),
        'phone'           => '09222942808',
        'whatsapp'        => '989222942808',
        'export_text'     => 'صادرات به ۵ کشور جهان',
        'export_url'      => '',
        'wholesale_text'  => 'خرید عمده آلو بخارا',
        'wholesale_url'   => home_url('/#b2b'),
        'wholesale_new_tab' => false,
        'top_logo_url'    => '',
        'top_logo_alt'    => get_bloginfo('name'),
        'top_logo_link'   => home_url('/'),
        'topbar_bg'       => '#11091D',
        'topbar_text_color' => '#E8D5B5',
        'topbar_border_color' => '#3A2C20',
        'topbar_button_bg' => '#C9A86A',
        'topbar_button_text' => '#1A1206',
        'topbar_height'   => 38,
        'top_logo_width'  => 96,
        'account_text'    => 'ورود / ثبت‌نام',
        'primary_menu'    => 0,
    ];

    $settings = wp_parse_args($saved, $defaults);
    return apply_filters('alookhor_cc_front_header_settings', $settings);
}

/**
 * Resolve the main menu automatically. A saved override is optional; otherwise
 * registered primary/header locations are preferred, then the first WP menu.
 */
function alookhor_cc_resolve_primary_menu($preferred = 0){
    if ($preferred) {
        $menu = wp_get_nav_menu_object((int) $preferred);
        if ($menu && !is_wp_error($menu)) return $menu;
    }

    $locations = get_nav_menu_locations();
    $priority_locations = [
        'primary', 'main-menu', 'main_menu', 'main-navigation',
        'header-menu', 'header', 'woodmart-main-menu', 'mobile-menu'
    ];
    foreach ($priority_locations as $location) {
        if (!empty($locations[$location])) {
            $menu = wp_get_nav_menu_object($locations[$location]);
            if ($menu && !is_wp_error($menu)) return $menu;
        }
    }

    foreach ($locations as $menu_id) {
        if (!$menu_id) continue;
        $menu = wp_get_nav_menu_object($menu_id);
        if ($menu && !is_wp_error($menu)) return $menu;
    }

    $menus = wp_get_nav_menus(['orderby' => 'term_order']);
    return !empty($menus) ? $menus[0] : null;
}

function alookhor_cc_menu_markup($menu, $class, $depth = 3){
    if (!$menu || is_wp_error($menu)) return '';
    return wp_nav_menu([
        'menu'        => $menu->term_id,
        'container'   => false,
        'menu_class'  => $class,
        'depth'       => $depth,
        'fallback_cb' => false,
        'echo'        => false,
    ]);
}

function alookhor_cc_phone_href($phone){
    return preg_replace('/[^0-9+]/', '', (string) $phone);
}

function alookhor_cc_whatsapp_href($number){
    $number = preg_replace('/\D+/', '', (string) $number);
    if (strpos($number, '0') === 0) $number = '98' . substr($number, 1);
    return $number ? 'https://wa.me/' . $number : '';
}

function alookhor_cc_render_portal_header($atts = []){
    $atts = shortcode_atts(['sticky' => '', 'menu' => ''], $atts, 'alookhor_portal_header');
    $settings = alookhor_cc_front_header_settings();
    if ($atts['sticky'] !== '') $settings['sticky'] = rest_sanitize_boolean($atts['sticky']);
    if ($atts['menu'] !== '') $settings['primary_menu'] = absint($atts['menu']);

    $instance = wp_unique_id('alookhor-header-');
    $drawer_id = $instance . '-drawer';
    $primary_menu = alookhor_cc_resolve_primary_menu($settings['primary_menu']);
    $all_menus = wp_get_nav_menus(['orderby' => 'term_order']);
    $primary_markup = alookhor_cc_menu_markup($primary_menu, 'alookhor-primary-menu', 3);

    $custom_logo_id = (int) get_theme_mod('custom_logo');
    if (!empty($settings['top_logo_url'])) {
        $custom_logo = sprintf(
            '<img class="alookhor-top-logo-image" src="%s" alt="%s" loading="eager">',
            esc_url($settings['top_logo_url']),
            esc_attr($settings['top_logo_alt'])
        );
    } else {
        $custom_logo = $custom_logo_id
            ? wp_get_attachment_image($custom_logo_id, 'medium', false, [
                'class' => 'alookhor-top-logo-image',
                'alt'   => $settings['top_logo_alt'] ?: get_bloginfo('name'),
                'loading' => 'eager',
            ])
            : '';
    }
    $site_icon = get_site_icon_url(96);
    if (!$site_icon && $custom_logo_id) $site_icon = wp_get_attachment_image_url($custom_logo_id, 'thumbnail');

    $account_url = function_exists('wc_get_page_permalink')
        ? wc_get_page_permalink('myaccount')
        : wp_login_url(home_url('/'));
    $cart_url = function_exists('wc_get_cart_url') ? wc_get_cart_url() : home_url('/cart/');
    $cart_count = function_exists('WC') && WC()->cart ? (int) WC()->cart->get_cart_contents_count() : 0;

    $phone_href = alookhor_cc_phone_href($settings['phone']);
    $whatsapp_href = alookhor_cc_whatsapp_href($settings['whatsapp']);
    $is_sticky = rest_sanitize_boolean($settings['sticky']);
    $show_topbar = rest_sanitize_boolean($settings['show_topbar']);
    $show_account = rest_sanitize_boolean($settings['show_account']);
    $show_contact = rest_sanitize_boolean($settings['show_contact']);
    $show_phone = rest_sanitize_boolean($settings['show_phone']);
    $show_email = rest_sanitize_boolean($settings['show_email']);
    $show_whatsapp = rest_sanitize_boolean($settings['show_whatsapp']);
    $show_export = rest_sanitize_boolean($settings['show_export']);
    $show_wholesale = rest_sanitize_boolean($settings['show_wholesale']);
    $wholesale_target = rest_sanitize_boolean($settings['wholesale_new_tab']) ? '_blank' : '_self';
    $topbar_height = max(30, min(60, absint($settings['topbar_height'])));
    $top_logo_width = max(50, min(180, absint($settings['top_logo_width'])));
    $topbar_bg = sanitize_hex_color($settings['topbar_bg']) ?: '#11091D';
    $topbar_text = sanitize_hex_color($settings['topbar_text_color']) ?: '#E8D5B5';
    $topbar_border = sanitize_hex_color($settings['topbar_border_color']) ?: '#3A2C20';
    $topbar_button_bg = sanitize_hex_color($settings['topbar_button_bg']) ?: '#C9A86A';
    $topbar_button_text = sanitize_hex_color($settings['topbar_button_text']) ?: '#1A1206';

    ob_start();
    ?>
    <div id="<?php echo esc_attr($instance); ?>" class="alookhor-portal-header<?php echo $is_sticky ? ' is-sticky' : ''; ?>" dir="rtl" style="--alookhor-gold:<?php echo esc_attr($settings['gold']); ?>;--alookhor-topbar-bg:<?php echo esc_attr($topbar_bg); ?>;--alookhor-topbar-text:<?php echo esc_attr($topbar_text); ?>;--alookhor-topbar-border:<?php echo esc_attr($topbar_border); ?>;--alookhor-topbar-button-bg:<?php echo esc_attr($topbar_button_bg); ?>;--alookhor-topbar-button-text:<?php echo esc_attr($topbar_button_text); ?>;--alookhor-topbar-height:<?php echo esc_attr($topbar_height); ?>px;--alookhor-top-logo-width:<?php echo esc_attr($top_logo_width); ?>px">
        <?php if ($show_topbar): ?>
        <div class="alookhor-topbar">
            <div class="alookhor-topbar-inner">
                <div class="alookhor-trade-meta">
                    <?php if ($show_wholesale): ?>
                    <a class="alookhor-wholesale" href="<?php echo esc_url($settings['wholesale_url']); ?>" target="<?php echo esc_attr($wholesale_target); ?>"<?php echo $wholesale_target === '_blank' ? ' rel="noopener"' : ''; ?>>
                        <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M3 6h18l-2 9H7L3 4H1M8 20a1 1 0 1 0 0-2 1 1 0 0 0 0 2Zm10 0a1 1 0 1 0 0-2 1 1 0 0 0 0 2Z"/></svg>
                        <span><?php echo esc_html($settings['wholesale_text']); ?></span>
                    </a>
                    <?php endif; ?>
                    <?php if ($show_export && !empty($settings['export_text'])): ?>
                        <?php if (!empty($settings['export_url'])): ?><a class="alookhor-export-note" href="<?php echo esc_url($settings['export_url']); ?>"><?php else: ?><span class="alookhor-export-note"><?php endif; ?>
                            <svg viewBox="0 0 24 24" aria-hidden="true"><circle cx="12" cy="12" r="9"/><path d="M3 12h18M12 3c3 3 4 6 4 9s-1 6-4 9c-3-3-4-6-4-9s1-6 4-9Z"/></svg>
                            <?php echo esc_html($settings['export_text']); ?>
                        <?php if (!empty($settings['export_url'])): ?></a><?php else: ?></span><?php endif; ?>
                    <?php endif; ?>
                </div>

                <a class="alookhor-top-logo" href="<?php echo esc_url($settings['top_logo_link']); ?>" aria-label="<?php echo esc_attr($settings['top_logo_alt']); ?>">
                    <?php if ($custom_logo): echo wp_kses_post($custom_logo); else: ?>
                        <span class="alookhor-top-logo-fallback"><?php echo esc_html($settings['logo_text']); ?></span>
                    <?php endif; ?>
                </a>

                <?php if ($show_contact): ?>
                <div class="alookhor-contact-meta" dir="ltr">
                    <?php if ($show_whatsapp && $whatsapp_href): ?>
                    <a class="alookhor-whatsapp" href="<?php echo esc_url($whatsapp_href); ?>" target="_blank" rel="noopener" aria-label="WhatsApp">
                        <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M20.5 3.5A11.8 11.8 0 0 0 12.1 0C5.6 0 .3 5.3.3 11.8c0 2.1.6 4.1 1.6 5.9L0 24l6.5-1.7a11.8 11.8 0 0 0 5.6 1.4h.1C18.7 23.7 24 18.4 24 11.9c0-3.2-1.2-6.1-3.5-8.4Zm-8.4 18.2c-1.8 0-3.5-.5-5-1.4l-.4-.2-3.8 1 1-3.7-.2-.4a9.8 9.8 0 1 1 8.4 4.7Zm5.4-7.3c-.3-.1-1.7-.8-2-.9-.3-.1-.5-.1-.7.2s-.8.9-1 1.1c-.2.2-.4.2-.7.1-1.8-.9-3-1.6-4.2-3.6-.3-.5.3-.5.9-1.7.1-.2 0-.4 0-.6l-.9-2.1c-.2-.5-.5-.5-.7-.5h-.6c-.2 0-.6.1-.9.4-.3.3-1.2 1.2-1.2 2.9s1.2 3.3 1.4 3.6c.2.2 2.4 3.7 5.9 5.2.8.4 1.5.6 2 .7.8.3 1.6.2 2.2.1.7-.1 1.7-.7 1.9-1.3.2-.7.2-1.2.2-1.3-.1-.1-.3-.2-.6-.3Z"/></svg>
                    </a>
                    <?php endif; ?>
                    <?php if ($show_email && !empty($settings['email'])): ?>
                    <a class="alookhor-contact-link" href="mailto:<?php echo esc_attr($settings['email']); ?>"><?php echo esc_html($settings['email']); ?></a>
                    <?php endif; ?>
                    <?php if ($show_phone && $phone_href): ?>
                    <?php if ($show_email && !empty($settings['email'])): ?><span class="alookhor-contact-separator"></span><?php endif; ?>
                    <a class="alookhor-contact-link" href="tel:<?php echo esc_attr($phone_href); ?>"><?php echo esc_html($settings['phone']); ?></a>
                    <?php endif; ?>
                </div>
                <?php endif; ?>
            </div>
        </div>
        <?php endif; ?>

        <div class="alookhor-nav-stage">
            <div class="alookhor-nav-shell">
                <a class="alookhor-nav-logo" href="<?php echo esc_url(home_url('/')); ?>">
                    <?php if ($site_icon): ?>
                        <img src="<?php echo esc_url($site_icon); ?>" alt="<?php echo esc_attr(get_bloginfo('name')); ?>" width="62" height="62" loading="eager">
                    <?php else: ?>
                        <span class="alookhor-nav-logo-mark"><?php echo esc_html($settings['logo_letter']); ?></span>
                    <?php endif; ?>
                    <span class="alookhor-nav-logo-copy"><b><?php echo esc_html($settings['logo_text']); ?></b><small><?php echo esc_html($settings['logo_sub']); ?></small></span>
                </a>

                <nav class="alookhor-desktop-nav" aria-label="<?php esc_attr_e('فهرست اصلی', 'alookhor-cc'); ?>">
                    <?php if ($primary_markup): ?>
                        <?php echo wp_kses_post($primary_markup); ?>
                    <?php else: ?>
                        <ul class="alookhor-primary-menu">
                            <li><a href="<?php echo esc_url(home_url('/')); ?>">صفحه نخست</a></li>
                            <?php if (function_exists('wc_get_page_permalink')): ?><li><a href="<?php echo esc_url(wc_get_page_permalink('shop')); ?>">فروشگاه</a></li><?php endif; ?>
                        </ul>
                    <?php endif; ?>
                </nav>

                <div class="alookhor-nav-spacer"></div>

                <div class="alookhor-nav-actions">
                    <?php if ($show_account): ?>
                    <a class="alookhor-account-link" href="<?php echo esc_url($account_url); ?>">
                        <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M12 12a4 4 0 1 0 0-8 4 4 0 0 0 0 8Zm7 8a7 7 0 0 0-14 0"/></svg>
                        <span><?php echo is_user_logged_in() ? esc_html__('حساب کاربری', 'alookhor-cc') : esc_html($settings['account_text']); ?></span>
                    </a>
                    <?php endif; ?>
                    <span class="alookhor-nav-divider" aria-hidden="true"></span>
                    <button class="alookhor-menu-toggle" type="button" aria-controls="<?php echo esc_attr($drawer_id); ?>" aria-expanded="false" aria-label="بازکردن منوی کامل">
                        <span></span><span></span><span></span>
                    </button>
                </div>
            </div>
        </div>

        <div class="alookhor-drawer-backdrop" data-alookhor-close></div>
        <aside id="<?php echo esc_attr($drawer_id); ?>" class="alookhor-menu-drawer" aria-hidden="true" aria-label="منوی کامل آلوخور">
            <div class="alookhor-drawer-head">
                <div class="alookhor-drawer-brand">
                    <?php if ($site_icon): ?><img src="<?php echo esc_url($site_icon); ?>" alt="" width="48" height="48"><?php else: ?><span><?php echo esc_html($settings['logo_letter']); ?></span><?php endif; ?>
                    <div><b><?php echo esc_html($settings['logo_text']); ?></b><small><?php echo esc_html($settings['logo_sub']); ?></small></div>
                </div>
                <button class="alookhor-drawer-close" type="button" data-alookhor-close aria-label="بستن منو">×</button>
            </div>

            <form class="alookhor-drawer-search" role="search" method="get" action="<?php echo esc_url(home_url('/')); ?>">
                <label class="screen-reader-text" for="<?php echo esc_attr($instance); ?>-search">جستجو</label>
                <input id="<?php echo esc_attr($instance); ?>-search" type="search" name="s" placeholder="جستجو در آلوخور...">
                <button type="submit" aria-label="جستجو"><svg viewBox="0 0 24 24" aria-hidden="true"><circle cx="11" cy="11" r="7"/><path d="m20 20-3.5-3.5"/></svg></button>
            </form>

            <div class="alookhor-drawer-menus">
                <?php if (!empty($all_menus)): ?>
                    <?php foreach ($all_menus as $index => $menu):
                        $menu_markup = alookhor_cc_menu_markup($menu, 'alookhor-drawer-menu', 4);
                        if (!$menu_markup) continue;
                        $panel_id = $instance . '-menu-' . (int) $menu->term_id;
                    ?>
                    <section class="alookhor-drawer-menu-group<?php echo $index === 0 ? ' is-open' : ''; ?>">
                        <button class="alookhor-drawer-menu-title" type="button" aria-expanded="<?php echo $index === 0 ? 'true' : 'false'; ?>" aria-controls="<?php echo esc_attr($panel_id); ?>">
                            <span><?php echo esc_html($menu->name); ?></span>
                            <svg viewBox="0 0 24 24" aria-hidden="true"><path d="m7 10 5 5 5-5"/></svg>
                        </button>
                        <div id="<?php echo esc_attr($panel_id); ?>" class="alookhor-drawer-menu-panel"<?php echo $index === 0 ? '' : ' hidden'; ?>><?php echo wp_kses_post($menu_markup); ?></div>
                    </section>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="alookhor-drawer-empty">هنوز فهرستی در WordPress ساخته نشده است.</div>
                <?php endif; ?>
            </div>

            <div class="alookhor-drawer-footer">
                <div class="alookhor-drawer-quick-actions">
                    <a href="<?php echo esc_url($account_url); ?>">حساب کاربری</a>
                    <a href="<?php echo esc_url($cart_url); ?>">سبد خرید<?php echo $cart_count ? ' (' . esc_html($cart_count) . ')' : ''; ?></a>
                </div>
                <a class="alookhor-drawer-wholesale" href="<?php echo esc_url($settings['wholesale_url']); ?>"><?php echo esc_html($settings['wholesale_text']); ?></a>
                <?php if ($whatsapp_href): ?><a class="alookhor-drawer-whatsapp" href="<?php echo esc_url($whatsapp_href); ?>" target="_blank" rel="noopener">گفتگو در WhatsApp</a><?php endif; ?>
            </div>
        </aside>
    </div>
    <?php
    return ob_get_clean();
}

/**
 * Keep the exact legacy header output, but wrap it with a neutral `display:contents`
 * management boundary. The compatibility manager updates Top Bar values without
 * rebuilding or removing the old professional menu/mega-menu implementation.
 */
function alookhor_cc_render_managed_legacy_header($atts = [], $content = null, $tag = ''){
    $provider = $GLOBALS['alookhor_cc_legacy_header_provider'] ?? null;
    if (!$provider || !is_callable($provider)) return alookhor_cc_render_portal_header($atts);

    $html = call_user_func($provider, $atts, $content, $tag ?: 'alookhor_portal_header');
    if (!is_string($html)) $html = '';
    return '<div class="alookhor-managed-legacy-header" data-alookhor-managed="3.10.7" style="display:contents">' . $html . '</div>';
}

/**
 * Register late. A legacy provider remains the renderer and is never redesigned;
 * only its Top Bar receives the optional management compatibility layer.
 */
function alookhor_cc_register_portal_header_shortcode(){
    global $shortcode_tags;
    $existing = $shortcode_tags['alookhor_portal_header'] ?? null;
    $our_callbacks = ['alookhor_cc_render_portal_header', 'alookhor_cc_render_managed_legacy_header'];
    if ($existing && !in_array($existing, $our_callbacks, true)) {
        $GLOBALS['alookhor_cc_legacy_header_provider'] = $existing;
        remove_shortcode('alookhor_portal_header');
        add_shortcode('alookhor_portal_header', 'alookhor_cc_render_managed_legacy_header');
        do_action('alookhor_cc_legacy_header_preserved', $existing);
        return;
    }
    $GLOBALS['alookhor_cc_legacy_header_provider'] = false;
    add_shortcode('alookhor_portal_header', 'alookhor_cc_render_portal_header');
}
add_action('init', 'alookhor_cc_register_portal_header_shortcode', 100);
