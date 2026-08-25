<?php
/**
 * ALOOKHOR Luxury Portal Header — [alookhor_portal_header]
 *
 * Premium purple/gold header (AKX design) with complete admin management.
 * All settings stored in ALOOKHOR_CC_HEADER_OPTION.
 * WordPress menus, cart, account links integrated.
 */

if (!defined('ABSPATH')) exit;

/**
 * Get header settings with comprehensive defaults.
 */
function alookhor_cc_front_header_settings() {
    $site = alookhor_cc_get_settings();
    $saved = get_option(ALOOKHOR_CC_HEADER_OPTION, array());
    if (!is_array($saved)) $saved = array();

    $defaults = array(
        'enabled'          => true,
        'logo_id'          => 0,
        'logo_url'         => '',
        'logo_width'       => 74,
        'logo_alt'         => get_bloginfo('name'),
        'wholesale_text'   => 'خرید عمده',
        'wholesale_url'    => '/wholesale/',
        'export_text'      => 'صادرات به بیش از ۵۰ کشور جهان',
        'export_url'       => '/export/',
        'whatsapp_number'  => '989159513173',
        'email'            => sanitize_email(get_option('admin_email')),
        'phone'            => '09159513173',
        'brand_name'       => 'آلوخور',
        'brand_subtitle'   => 'خشکبار طبیعی اصيل',
        'header_bg'        => '#17041f',
        'topbar_bg_grad_1' => '#1a0527',
        'topbar_bg_grad_2' => '#2d0d4a',
        'topbar_bg_grad_3' => '#1c0629',
        'mainbar_bg_grad_1'=> '#16031f',
        'mainbar_bg_grad_2'=> '#21072f',
        'mainbar_bg_grad_3'=> '#14021d',
        'gold_color'       => '#D4AF37',
        'gold_light'       => '#f1d468',
        'whatsapp_bg'      => 'rgba(7,47,29,.7)',
        'whatsapp_border'  => 'rgba(39,230,122,.42)',
        'whatsapp_color'   => '#27e67a',
        'capsule_border'   => 'rgba(212,175,55,.27)',
        'capsule_bg_1'     => 'rgba(91,41,110,.44)',
        'capsule_bg_2'     => 'rgba(34,12,49,.63)',
        'capsule_bg_3'     => 'rgba(24,7,37,.58)',
        'mega_bg_1'        => 'rgba(41,10,55,.95)',
        'mega_bg_2'        => 'rgba(12,4,20,.98)',
        'mega_border'      => 'rgba(212,175,55,.29)',
        'drawer_bg_1'      => '#150826',
        'drawer_bg_2'      => '#0d0218',
        'badge_bg_1'       => '#d32f2f',
        'badge_bg_2'       => '#ff5252',
        'logo_text'        => $site['header_settings']['logo_text'] ?? $site['site']['name'] ?? 'ALOOKHOR',
        'logo_sub'         => $site['header_settings']['logo_sub'] ?? $site['site']['subtitle'] ?? 'آلوخور',
        'logo_letter'      => $site['site']['logoLetter'] ?? 'A',
        'gold'             => $site['site']['goldAccent'] ?? '#D4AF37',
        'sticky'           => true,
        'show_search'      => false,
        'search_placeholder' => 'جستجوی محصول...',
        'show_topbar'      => true,
        'show_account'     => true,
        'show_contact'     => true,
        'show_phone'       => true,
        'show_email'       => true,
        'show_whatsapp'    => true,
        'show_export'      => true,
        'show_wholesale'   => true,
        'top_logo_alt'     => get_bloginfo('name'),
        'top_logo_link'    => home_url('/'),
        'account_text'     => 'ورود / ثبت نام',
        'primary_menu'     => 0,
        'topbar_height'    => 43,
        'header_logo_desktop_width' => 118,
        'header_logo_mobile_width' => 58,
    );

    $settings = wp_parse_args($saved, $defaults);
    return apply_filters('alookhor_cc_front_header_settings', $settings);
}

/**
 * Resolve logo URL from media library or stored URL.
 */
function alookhor_cc_resolve_logo_src($id, $url) {
    $id = absint($id);
    if ($id) {
        $src = wp_get_attachment_image_url($id, 'full');
        if ($src) return $src;
    }
    return esc_url_raw($url);
}

/**
 * Resolve primary menu from WordPress.
 */
function alookhor_cc_resolve_primary_menu($preferred = 0) {
    if ($preferred) {
        $menu = wp_get_nav_menu_object((int)$preferred);
        if ($menu && !is_wp_error($menu)) return $menu;
    }
    $locations = get_nav_menu_locations();
    $priority = array('primary', 'main-menu', 'main_menu', 'header-menu', 'header');
    foreach ($priority as $loc) {
        if (!empty($locations[$loc])) {
            $menu = wp_get_nav_menu_object($locations[$loc]);
            if ($menu && !is_wp_error($menu)) return $menu;
        }
    }
    foreach ($locations as $menu_id) {
        if (!$menu_id) continue;
        $menu = wp_get_nav_menu_object($menu_id);
        if ($menu && !is_wp_error($menu)) return $menu;
    }
    $menus = wp_get_nav_menus(array('orderby' => 'term_order'));
    return !empty($menus) ? $menus[0] : null;
}

/**
 * Get menu HTML markup.
 */
function alookhor_cc_menu_markup($menu, $class = 'akx-primary-menu', $depth = 3) {
    if (!$menu || is_wp_error($menu)) return '';
    return wp_nav_menu(array(
        'menu'        => $menu->term_id,
        'container'   => false,
        'menu_class'  => $class,
        'depth'       => $depth,
        'fallback_cb' => false,
        'echo'        => false,
    ));
}

/**
 * Phone href helper.
 */
function alookhor_cc_phone_href($phone){
    return preg_replace('/[^0-9+]/', '', (string) $phone);
}

/**
 * WhatsApp href helper.
 */
function alookhor_cc_whatsapp_href($number){
    $number = preg_replace('/\D+/', '', (string) $number);
    if (strpos($number, '0') === 0) $number = '98' . substr($number, 1);
    return $number ? 'https://wa.me/' . $number : '';
}

/**
 * Render the AKX luxury header.
 */
function alookhor_cc_render_akx_header() {
    $h = alookhor_cc_front_header_settings();
    if (empty($h['enabled'])) return '';

    $logo_img = alookhor_cc_resolve_logo_src($h['logo_id'], $h['logo_url']);
    $logo_w   = max(40, min(180, (int)$h['logo_width']));
    $ws_txt   = esc_html($h['wholesale_text']);
    $ws_url   = esc_url($h['wholesale_url']);
    $exp_txt  = esc_html($h['export_text']);
    $exp_url  = esc_url($h['export_url']);
    $wa_num   = preg_replace('/[^0-9]+/', '', (string)$h['whatsapp_number']);
    $wa_url   = $wa_num ? 'https://wa.me/' . $wa_num : '';
    $email    = esc_attr($h['email']);
    $phone_raw = $h['phone'];
    $phone    = esc_attr($phone_raw);
    $phone_url = preg_replace('/[^0-9+]/', '', $phone_raw);
    $brand    = esc_html($h['brand_name']);
    $sub_title = esc_html($h['brand_subtitle']);
    $site_nm  = esc_attr(get_bloginfo('name'));
    $home_url = esc_url(home_url('/'));

    $cart_count = function_exists('WC') && WC()->cart ? (int) WC()->cart->get_cart_contents_count() : 0;
    $cart_url   = function_exists('wc_get_cart_url') ? esc_url(wc_get_cart_url()) : $home_url . 'cart/';
    $account_url = function_exists('wc_get_page_permalink') ? esc_url(wc_get_page_permalink('myaccount')) : $home_url . 'my-account/';

    $primary_menu = alookhor_cc_resolve_primary_menu((int)$h['primary_menu']);
    $menu_html    = alookhor_cc_menu_markup($primary_menu, 'akx-primary-menu');

    $instance_id = 'akx-' . wp_unique_id();

    ob_start();
    ?>
<div id="<?php echo $instance_id; ?>" class="akx-header alookhor-portal-header" dir="rtl" style="--akx-gold: <?php echo esc_attr($h['gold_color']); ?>; --akx-gold-light: <?php echo esc_attr($h['gold_light']); ?>;">
  <!-- ===== TOPBAR ===== -->
  <div class="akx-topbar">
    <div class="akx-wrap akx-topbar-inner">
      <div class="akx-topbar-right">
        <a class="akx-wholesale" href="<?php echo $ws_url; ?>">
          <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M3 6h18M5 6l1 14h12l1-14M9 10v6M15 10v6"/></svg>
          <span><?php echo $ws_txt; ?></span>
        </a>
        <a class="akx-export-link" href="<?php echo $exp_url; ?>">
          <svg viewBox="0 0 24 24" aria-hidden="true"><circle cx="12" cy="12" r="9"/><path d="M3 12h18M12 3c3 3 3 15 0 18M12 3c-3 3-3 15 0 18"/></svg>
          <span><?php echo $exp_txt; ?></span>
        </a>
      </div>
      <div class="akx-topbar-left">
        <?php if ($wa_url): ?>
        <a class="akx-top-whatsapp" href="<?php echo $wa_url; ?>" target="_blank" rel="noopener" aria-label="واتساپ">
          <svg viewBox="0 0 24 24"><path d="M20.5 3.5A11.7 11.7 0 0 0 12.1 0C5.6 0 .3 5.2.3 11.7c0 2.1.6 4.1 1.6 5.9L.2 24l6.6-1.7a11.8 11.8 0 0 0 5.3 1.3h.1c6.5 0 11.8-5.3 11.8-11.8 0-3.2-1.3-6.1-3.5-8.3ZM12.1 21.5c-1.7 0-3.4-.5-4.9-1.4l-.4-.2-3.9 1 1-3.8-.3-.4a9.5 9.5 0 0 1-1.5-5.1c0-5.3 4.3-9.6 9.6-9.6 2.6 0 5 .9 6.8 2.8a9.5 9.5 0 0 1 2.8 6.8c0 5.3-4.3 9.6-9.6 9.6h.4Z"/><path d="M17.4 14.3c-.3-.2-1.8-.9-2.1-1-.3-.1-.5-.2-.7.2s-.8 1-.9 1.2c-.2.2-.3.2-.6.1-1.8-.9-3-2.1-3.8-3.8-.2-.3 0-.5.1-.6.1-.1.3-.3.4-.5.1-.2.2-.3.3-.5.1-.2 0-.4 0-.5-.1-.1-.7-1.7-.9-2.3-.3-.7-.6-.6-.8-.6h-.7c-.2 0-.5.1-.8.4-.3.3-1 1-1 2.5 0 1.5 1.1 3 1.2 3.2.1.2 2.2 3.4 5.3 4.7.7.3 1.3.5 1.8.6.8.3 1.5.2 2.1.1.6-.1 1.8-.8 2.1-1.5.2-.7.2-1.3.2-1.5-.1-.2-.3-.3-.6-.5Z"/></svg>
        </a>
        <?php endif; ?>
        <?php if ($email): ?>
        <a href="mailto:<?php echo $email; ?>"><?php echo $email; ?></a>
        <?php endif; ?>
        <?php if ($phone): ?>
        <a class="akx-phone" href="tel:<?php echo $phone_url; ?>"><?php echo $phone; ?></a>
        <?php endif; ?>
      </div>
    </div>
  </div>

  <!-- ===== MAIN BAR ===== -->
  <div class="akx-mainbar">
    <div class="akx-wrap akx-main-inner">

      <!-- Logo -->
      <a class="akx-logo" href="<?php echo $home_url; ?>" aria-label="<?php echo $site_nm; ?>">
        <?php if ($logo_img): ?>
        <img src="<?php echo $logo_img; ?>" alt="<?php echo $site_nm; ?>" style="width:<?php echo $logo_w; ?>px;max-height:61px;object-fit:contain;" loading="eager">
        <?php else: ?>
        <span class="akx-logo-text"><?php echo esc_html($h['logo_text']); ?></span>
        <?php endif; ?>
      </a>

      <!-- Navigation Capsule -->
      <div class="akx-nav-capsule">
        <button class="akx-menu-button" type="button" aria-label="باز کردن منو" aria-expanded="false">
          <span>منو</span>
          <i><b></b><b></b><b></b></i>
        </button>

        <nav class="akx-nav" aria-label="منوی اصلی">
          <?php if ($menu_html): ?>
          <?php echo $menu_html; ?>
          <?php else: ?>
          <ul>
            <li><a href="<?php echo $home_url; ?>">صفحه اصلی</a></li>
            <li><a href="/shop/">محصولات</a></li>
            <li><a href="/blog/">مجله</a></li>
            <li><a href="/about/">درباره ما</a></li>
            <li><a href="/contact/">تماس با ما</a></li>
          </ul>
          <?php endif; ?>
        </nav>

        <div class="akx-tools">
          <button class="akx-circle-btn akx-search-button" type="button" aria-label="جستجو">
            <svg viewBox="0 0 24 24"><circle cx="11" cy="11" r="6"/><path d="m16 16 5 5"/></svg>
          </button>
          <a class="akx-circle-btn" href="<?php echo $cart_url; ?>" aria-label="سبد خرید">
            <svg viewBox="0 0 24 24"><path d="M3 4h2l2.2 11.2a2 2 0 0 0 2 1.6h8.8a2 2 0 0 0 2-1.6L21 8H6"/><circle cx="10" cy="21" r="1"/><circle cx="18" cy="21" r="1"/></svg>
            <em><?php echo $cart_count; ?></em>
          </a>
          <a class="akx-circle-btn" href="<?php echo $account_url; ?>" aria-label="حساب کاربری">
            <svg viewBox="0 0 24 24"><circle cx="12" cy="8" r="4"/><path d="M4.5 21c.8-4 3.6-6 7.5-6s6.7 2 7.5 6"/></svg>
          </a>
        </div>
      </div>

      <!-- Search Panel -->
      <form class="akx-search-panel" action="<?php echo $home_url; ?>" method="get">
        <input type="search" name="s" placeholder="<?php echo esc_attr($h['search_placeholder']); ?>">
        <button type="submit">جستجو</button>
      </form>

      <!-- ===== MOBILE DRAWER ===== -->
      <div class="akx-mob-backdrop" data-akx-close></div>
      <div class="akx-mob-drawer">
        <div class="akx-mob-drawer-head">
          <button type="button" class="akx-mob-close" data-akx-close aria-label="بستن">
            <svg viewBox="0 0 24 24"><path d="M18 6L6 18M6 6l12 12" stroke="currentColor" stroke-width="2" stroke-linecap="round"/></svg>
          </button>
          <div class="akx-mob-brand">
            <div class="akx-mob-brand-text">
              <strong><?php echo $brand; ?></strong>
              <span><?php echo $sub_title; ?></span>
            </div>
            <div class="akx-mob-brand-badge">🌿</div>
          </div>
        </div>

        <div class="akx-mob-search">
          <form action="<?php echo $home_url; ?>" method="get">
            <input type="search" name="s" placeholder="جستجو در منو...">
            <button type="submit" aria-label="جستجو">
              <svg viewBox="0 0 24 24"><circle cx="11" cy="11" r="6" stroke="currentColor" stroke-width="2" fill="none"/><path d="m16 16 5 5" stroke="currentColor" stroke-width="2"/></svg>
            </button>
          </form>
        </div>

        <div class="akx-mob-label">دسترسی سریع</div>
        <div class="akx-mob-scroll">
          <ul class="akx-mob-list">
            <li><a href="<?php echo $home_url; ?>"><div class="akx-mob-item-main"><span class="akx-mob-icon">🏠</span><span class="akx-mob-title">صفحه اصلی</span></div></a></li>
            <li class="akx-mob-has-sub">
              <a href="/shop/" class="akx-mob-toggle"><div class="akx-mob-item-main"><span class="akx-mob-icon">🛍️</span><span class="akx-mob-title">محصولات</span></div><span class="akx-mob-arrow">‹</span></a>
              <ul class="akx-mob-sub">
                <li><a href="/product-category/dried-plums/">آلو خشكبار</a></li>
                <li><a href="/product-category/dried-fruits/">برگه ميوه‌ها</a></li>
                <li><a href="/product-category/snacks/">تنقلات طبيعي</a></li>
              </ul>
            </li>
            <li><a href="/gift-packages/"><div class="akx-mob-item-main"><span class="akx-mob-icon">🎁</span><span class="akx-mob-title">بسته‌هاي هديه</span></div></a></li>
            <li><a href="/blog/"><div class="akx-mob-item-main"><span class="akx-mob-icon">📰</span><span class="akx-mob-title">مجله</span></div></a></li>
            <li><a href="/about/"><div class="akx-mob-item-main"><span class="akx-mob-icon">🏢</span><span class="akx-mob-title">درباره ما</span></div></a></li>
            <li><a href="/contact/"><div class="akx-mob-item-main"><span class="akx-mob-icon">📞</span><span class="akx-mob-title">تماس با ما</span></div></a></li>
          </ul>
        </div>

        <div class="akx-mob-footer">
          <a href="<?php echo $account_url; ?>"><span class="akx-foot-ic">👤</span><span>حساب من</span></a>
          <a href="<?php echo $cart_url; ?>"><span class="akx-foot-ic">🛒</span><span>سبد خريد</span></a>
        </div>
      </div>
    </div>
  </div>
</div>
    <?php
    return ob_get_clean();
}


// ===== FALLBACK RENDERER (old portal header, used when AKX is disabled) =====
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
    // Main capsule must use the approved Header logo source, not the generic
    // WordPress Site Icon (which can be an unrelated shop/app glyph).
    $nav_logo_url = !empty($settings['top_logo_url']) ? esc_url_raw($settings['top_logo_url']) : '';
    if (!$nav_logo_url && $custom_logo_id) $nav_logo_url = wp_get_attachment_image_url($custom_logo_id, 'full');
    if (!$nav_logo_url) $nav_logo_url = $site_icon;
    $nav_brand_text = apply_filters('alookhor_cc_header_brand_text', 'آلوخور');
    $nav_brand_sub = apply_filters('alookhor_cc_header_brand_subtitle', 'پایتخت آلوی ایران');

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
    $topbar_bg = sanitize_hex_color($settings['topbar_bg']) ?: '#1C1024';
    $topbar_text = sanitize_hex_color($settings['topbar_text_color']) ?: '#F5F3F0';
    $topbar_border = sanitize_hex_color($settings['topbar_border_color']) ?: '#D49A2E';
    $topbar_button_bg = sanitize_hex_color($settings['topbar_button_bg']) ?: '#D49A2E';
    $topbar_button_text = sanitize_hex_color($settings['topbar_button_text']) ?: '#0D0510';
    $capsule_background=sanitize_hex_color($settings['capsule_background']??'')?:'#0D0510';
    $capsule_card=sanitize_hex_color($settings['capsule_card']??'')?:'#1C1024';
    $capsule_glass=preg_match('/^rgba?\([^)]*\)$/',(string)($settings['capsule_glass']??''))?(string)$settings['capsule_glass']:'rgba(33,20,38,.75)';
    $capsule_gold=sanitize_hex_color($settings['capsule_gold']??'')?:'#D49A2E';
    $capsule_gold_light=sanitize_hex_color($settings['capsule_gold_light']??'')?:'#E8B84A';
    $capsule_text=sanitize_hex_color($settings['capsule_text']??'')?:'#F5F3F0';
    $capsule_muted=sanitize_hex_color($settings['capsule_muted']??'')?:'#C8C2C9';
    $capsule_blur=max(10,min(36,absint($settings['capsule_blur']??24)));

    ob_start();
    ?>
    <div id="<?php echo esc_attr($instance); ?>" class="alookhor-portal-header<?php echo $is_sticky ? ' is-sticky' : ''; ?>" dir="rtl" style="--alookhor-gold:<?php echo esc_attr($settings['gold']); ?>;--alookhor-topbar-bg:<?php echo esc_attr($topbar_bg); ?>;--alookhor-topbar-text:<?php echo esc_attr($topbar_text); ?>;--alookhor-topbar-border:<?php echo esc_attr($topbar_border); ?>;--alookhor-topbar-button-bg:<?php echo esc_attr($topbar_button_bg); ?>;--alookhor-topbar-button-text:<?php echo esc_attr($topbar_button_text); ?>;--alookhor-topbar-height:<?php echo esc_attr($topbar_height); ?>px;--alookhor-top-logo-width:<?php echo esc_attr($top_logo_width); ?>px;--alookhor-capsule-background:<?php echo esc_attr($capsule_background); ?>;--alookhor-capsule-card:<?php echo esc_attr($capsule_card); ?>;--alookhor-capsule-glass:<?php echo esc_attr($capsule_glass); ?>;--alookhor-capsule-gold:<?php echo esc_attr($capsule_gold); ?>;--alookhor-capsule-gold-light:<?php echo esc_attr($capsule_gold_light); ?>;--alookhor-capsule-text:<?php echo esc_attr($capsule_text); ?>;--alookhor-capsule-muted:<?php echo esc_attr($capsule_muted); ?>;--alookhor-capsule-blur:<?php echo esc_attr($capsule_blur); ?>px">
        <?php if ($show_topbar): ?>
        <div class="alookhor-topbar">
            <div class="alookhor-topbar-inner">
                <div class="alookhor-fallback-support"><svg viewBox="0 0 24 24" aria-hidden="true"><path d="M4 14v-2a8 8 0 0 1 16 0v2M4 14h3v6H4zM17 14h3v6h-3zM17 20c-1 2-3 3-6 3"/></svg><b>پشتیبانی ۲۴/۷</b></div>
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
                <a class="alookhor-nav-logo" href="<?php echo esc_url(home_url('/')); ?>" data-logo-source="<?php echo !empty($settings['top_logo_url']) ? 'managed-media' : ($custom_logo_id ? 'custom-logo' : 'site-icon'); ?>">
                    <?php if ($nav_logo_url): ?>
                        <img src="<?php echo esc_url($nav_logo_url); ?>" alt="<?php echo esc_attr($settings['top_logo_alt'] ?: get_bloginfo('name')); ?>" width="62" height="62" loading="eager">
                    <?php else: ?>
                        <span class="alookhor-nav-logo-mark"><?php echo esc_html($settings['logo_letter']); ?></span>
                    <?php endif; ?>
                    <span class="alookhor-nav-logo-copy"><b><?php echo esc_html($nav_brand_text); ?></b><small><?php echo esc_html($nav_brand_sub); ?></small></span>
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
                    <a class="alookhor-fallback-cart" href="<?php echo esc_url($cart_url); ?>" aria-label="سبد خرید"><svg viewBox="0 0 24 24" aria-hidden="true"><path d="M3 4h2l2 11h10l3-8H6M9 20a1 1 0 1 0 0-2 1 1 0 0 0 0 2Zm8 0a1 1 0 1 0 0-2 1 1 0 0 0 0 2Z"/></svg><span><?php echo esc_html($cart_count); ?></span></a>
                    <?php if ($show_account): ?>
                    <a class="alookhor-account-link" href="<?php echo esc_url($account_url); ?>">
                        <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M12 12a4 4 0 1 0 0-8 4 4 0 0 0 0 8Zm7 8a7 7 0 0 0-14 0"/></svg>
                        <span><?php echo is_user_logged_in() ? esc_html__('حساب کاربری', 'alookhor-cc') : esc_html($settings['account_text']); ?></span>
                    </a>
                    <?php endif; ?>
                </div>
                <button class="alookhor-menu-toggle" type="button" aria-controls="<?php echo esc_attr($drawer_id); ?>" aria-expanded="false" aria-label="بازکردن منوی کامل">
                    <span></span><span></span><span></span>
                </button>
            </div>
        </div>

        <div class="alookhor-drawer-backdrop" data-alookhor-close></div>
        <aside id="<?php echo esc_attr($drawer_id); ?>" class="alookhor-menu-drawer" aria-hidden="true" aria-label="منوی کامل آلوخور">
            <div class="alookhor-drawer-head">
                <div class="alookhor-drawer-brand">
                    <?php if ($nav_logo_url): ?><img src="<?php echo esc_url($nav_logo_url); ?>" alt="" width="48" height="48"><?php else: ?><span><?php echo esc_html($settings['logo_letter']); ?></span><?php endif; ?>
                    <div><b><?php echo esc_html($nav_brand_text); ?></b><small><?php echo esc_html($nav_brand_sub); ?></small></div>
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

/**
 * Main shortcode handler — dispatches to AKX or legacy renderer.
 */
function alookhor_cc_render_header_shortcode($atts = []) {
    $h = alookhor_cc_front_header_settings();
    if (!empty($h['enabled'])) {
        return alookhor_cc_render_akx_header($atts);
    }
    return alookhor_cc_render_portal_header($atts);
}

// ===== SHORTCODE =====
add_action('init', function() {
    remove_shortcode('alookhor_portal_header');
    add_shortcode('alookhor_portal_header', 'alookhor_cc_render_header_shortcode');
}, 100);

// ===== FRONTEND ASSETS =====
add_action('wp_enqueue_scripts', function() {
    $h = get_option(ALOOKHOR_CC_HEADER_OPTION, array());
    if (!is_array($h) || empty($h['enabled'])) return;
    wp_enqueue_style('alookhor-cc-akx-header',
        ALOOKHOR_CC_URL . 'assets/css/frontend-header-akx.css',
        array(),
        ALOOKHOR_CC_BUILD
    );
    wp_enqueue_script('alookhor-cc-akx-header',
        ALOOKHOR_CC_URL . 'assets/js/frontend-header-akx.js',
        array(),
        ALOOKHOR_CC_BUILD,
        true
    );
    $localize = array(
        'ajax_url' => admin_url('admin-ajax.php'),
        'nonce'    => wp_create_nonce('alookhor_cc_nonce'),
        'home_url' => home_url('/'),
        'cart_url' => function_exists('wc_get_cart_url') ? wc_get_cart_url() : home_url('/cart/'),
        'account_url' => function_exists('wc_get_page_permalink') ? wc_get_page_permalink('myaccount') : home_url('/my-account/'),
    );
    if (function_exists('WC') && WC()->cart) {
        $localize['cart_count'] = (int) WC()->cart->get_cart_contents_count();
    }
    wp_localize_script('alookhor-cc-akx-header', 'ALOOKHOR_AKX', $localize);
});
