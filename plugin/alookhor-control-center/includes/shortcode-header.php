<?php
/**
 * ALOOKHOR Luxury Portal Header — [alookhor_portal_header]
 *
 * Premium purple/gold header (AKX design) — full admin management.
 * HTML structure mirrors the owner-approved reference exactly.
 * All settings come from ALOOKHOR_CC_HEADER_OPTION (not WP menus).
 */
if (!defined('ABSPATH')) exit;

/**
 * v3.10.392 — Render-time guarantee for the AKX glassy header assets.
 * The same two cache/branch races that once dropped portal CSS could
 * also drop frontend-header-akx.css; enqueue at render time so the
 * styled output no longer depends on which earlier path ran.
 */
function alookhor_cc_ensure_akx_header_assets(){
    if (!wp_style_is('alookhor-cc-akx-header', 'enqueued')) {
        wp_enqueue_style('alookhor-cc-akx-header', ALOOKHOR_CC_URL . 'assets/css/frontend-header-akx.css', [], ALOOKHOR_CC_BUILD);
    }
    if (!wp_script_is('alookhor-cc-akx-header', 'enqueued')) {
        wp_enqueue_script('alookhor-cc-akx-header', ALOOKHOR_CC_URL . 'assets/js/frontend-header-akx.js', [], ALOOKHOR_CC_BUILD, true);
    }
}

/*
 * Critical, duplicated icon-sizing rules (subset of frontend-header-akx.css),
 * printed inline beside the header markup at most once per page. With this
 * block alone the SVG glyphs can never render unbounded ("giant icons"),
 * even if the external stylesheet is cached-stale or absent.
 */
function alookhor_cc_akx_header_critical_css(){
    static $printed = false;
    if ($printed) return '';
    $printed = true;
    $css = 'body #akx-header svg{width:18px;height:18px;fill:none;stroke:currentColor;stroke-width:1.7;stroke-linecap:round;stroke-linejoin:round;display:block;max-width:100%}'
        . 'body #akx-header .akx-mini-icon svg{width:14px;height:14px}'
        . 'body #akx-header .akx-top-whatsapp svg{width:21px;height:21px;fill:currentColor;stroke:none}'
        . 'body #akx-header .akx-wholesale svg{width:14px;height:14px}'
        . 'body #akx-header .akx-export-link svg{width:16px;height:16px}'
        . 'body #akx-header .akx-nav > ul > li > a svg{width:13px;height:13px}'
        . 'body #akx-header .akx-circle-btn svg{width:17px;height:17px}'
        . '.akx-mob-close svg{width:18px;height:18px}'
        . '.akx-mob-search button svg{width:16px;height:16px;stroke:currentColor}';
    return '<style id="alookhor-cc-akx-critical">' . $css . '</style>' . "\n";
}

/**
 * Get header settings with comprehensive defaults.
 */
function alookhor_cc_front_header_settings() {
    $saved = get_option(ALOOKHOR_CC_HEADER_OPTION, array());
    if (!is_array($saved)) $saved = array();

    $defaults = array(
        'enabled'              => true,
        'logo_id'              => 0,
        'logo_url'             => '',
        'logo_width'           => 74,
        'wholesale_text'       => 'خرید عمده',
        'wholesale_url'        => '/wholesale/',
        'export_text'          => 'صادرات به بیش از ۵۰ کشور جهان',
        'export_url'           => '/export/',
        'whatsapp_number'      => '989159513173',
        'email'                => sanitize_email(get_option('admin_email')),
        'phone'                => '09159513173',
        'brand_name'           => 'آلوخور',
        'brand_subtitle'       => 'خشکبار طبیعی اصیل',
        'search_placeholder'   => 'جستجوی محصول، مقاله و ...',
        'header_logo_desktop_width' => 118,
        'header_logo_mobile_width' => 58,
        'mainbar_glass_enabled' => true,
        'mainbar_opacity'       => 72,
        'capsule_blur'          => 18,
        'topbar_bg'             => '#1C0629',
        'topbar_text_color'     => '#F5F3F0',
        'topbar_border_color'   => '#D4AF37',
        'topbar_button_bg'      => '#D4AF37',
        'topbar_button_text'    => '#210A2C',
        'header_surface'        => '#21072F',
        'header_text_color'     => '#FFFFFF',
        'header_muted_color'    => '#C8C2C9',
        'capsule_background'    => '#16031F',
        'capsule_card'          => '#2D0D4A',
        'capsule_gold'          => '#D4AF37',
        'capsule_gold_light'    => '#F1D468',
        'capsule_text'          => '#FFFFFF',
        'capsule_muted'         => '#C8C2C9',
    );
    $settings = wp_parse_args($saved, $defaults);
    // v3.10.392: کلیدهای ذخیره‌شده با نام‌های متفاوتِ نسخه‌های بعدی هم دیده شوند.
    if (empty($settings['whatsapp_number']) && !empty($saved['whatsapp'])) {
        $settings['whatsapp_number'] = preg_replace('/\D+/', '', (string) $saved['whatsapp']);
    }
    if (empty($settings['whatsapp_number']) && !empty($settings['whatsapp'])) {
        $settings['whatsapp_number'] = preg_replace('/\D+/', '', (string) $settings['whatsapp']);
    }
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
 * Render the AKX luxury header using the exact reference HTML.
 * Markup uses id="akx-header" so the CSS can scope by ID and work
 * regardless of any wrapper element.
 */
function alookhor_cc_render_akx_header() {
    $h = alookhor_cc_front_header_settings();
    if (empty($h['enabled'])) return '';
    alookhor_cc_ensure_akx_header_assets();

    // لوگوی اصلی AKX؛ اگر فیلد اختصاصی خالی باشد از لوگوی رسمی Topbar استفاده می‌شود.
    $logo_img   = alookhor_cc_resolve_logo_src($h['logo_id'], $h['logo_url']);
    if (!$logo_img && !empty($h['top_logo_url'])) $logo_img = esc_url_raw($h['top_logo_url']);
    $logo_w     = max(40, min(180, (int)$h['logo_width']));
    $ws_txt     = esc_html($h['wholesale_text']);
    $ws_url     = esc_url($h['wholesale_url']);
    $exp_txt    = esc_html($h['export_text']);
    $exp_url    = esc_url($h['export_url']);
    $wa_raw     = preg_replace('/\D+/', '', (string)$h['whatsapp_number']);
    $wa_url     = $wa_raw ? 'https://wa.me/' . $wa_raw : '';
    $email      = esc_attr($h['email']);
    $phone_raw  = $h['phone'];
    $phone      = esc_attr($phone_raw);
    $phone_href = preg_replace('/[^0-9+]/', '', $phone_raw);
    $brand      = esc_html($h['brand_name']);
    $sub        = esc_html($h['brand_subtitle']);
    $search_ph  = esc_attr($h['search_placeholder']);

    $home_url    = esc_url(home_url('/'));
    $cart_count  = function_exists('WC') && WC()->cart ? (int) count((array) WC()->cart->get_cart()) : 0;
    $cart_url    = function_exists('wc_get_cart_url') ? esc_url(wc_get_cart_url()) : $home_url . 'cart/';
    $account_url = function_exists('wc_get_page_permalink') ? esc_url(wc_get_page_permalink('myaccount')) : $home_url . 'my-account/';

    // Render-time unique IDs (one shortcode per page is supported).
    $instance_id = 'akx-header';
    $drawer_id   = 'akxMobDrawer';
    $close_id    = 'akxMobClose';
    $back_id     = 'akxMobBackdrop';

    // v3.10.70: نشانه‌گذاری هدر واقعی که خود شورت‌کد رندر کرده (در برابر کپی‌های Static داخل صفحه)
    $live_flag = 'data-akx-live="1" data-akx-ver="' . esc_attr(ALOOKHOR_CC_VERSION) . '"';

    // متغیرهای ظاهری فقط از مقادیر امن ساخته می‌شوند تا فرم بوتیک مستقیماً هدر را کنترل کند.
    $color = static function ($key, $fallback) use ($h) {
        return sanitize_hex_color($h[$key] ?? '') ?: $fallback;
    };
    $opacity = max(10, min(100, (int) ($h['mainbar_opacity'] ?? 72))) / 100;
    $hex_to_rgba = static function ($hex, $alpha) {
        $hex = ltrim($hex, '#');
        return sprintf('rgba(%d,%d,%d,%.2F)', hexdec(substr($hex, 0, 2)), hexdec(substr($hex, 2, 2)), hexdec(substr($hex, 4, 2)), $alpha);
    };
    $surface = $color('header_surface', '#21072F');
    $capsule = $color('capsule_background', '#16031F');
    $style_vars = implode(';', array(
        '--akx-topbar-bg:' . $color('topbar_bg', '#1C0629'),
        '--akx-topbar-text:' . $color('topbar_text_color', '#F5F3F0'),
        '--akx-topbar-border:' . $color('topbar_border_color', '#D4AF37'),
        '--akx-topbar-button:' . $color('topbar_button_bg', '#D4AF37'),
        '--akx-topbar-button-text:' . $color('topbar_button_text', '#210A2C'),
        '--akx-surface:' . $surface,
        '--akx-surface-glass:' . $hex_to_rgba($surface, $opacity),
        '--akx-text:' . $color('header_text_color', '#FFFFFF'),
        '--akx-muted:' . $color('header_muted_color', '#C8C2C9'),
        '--akx-capsule:' . $capsule,
        '--akx-capsule-glass:' . $hex_to_rgba($capsule, $opacity),
        '--akx-card:' . $color('capsule_card', '#2D0D4A'),
        '--akx-gold:' . $color('capsule_gold', '#D4AF37'),
        '--akx-gold-light:' . $color('capsule_gold_light', '#F1D468'),
        '--akx-capsule-text:' . $color('capsule_text', '#FFFFFF'),
        '--akx-capsule-muted:' . $color('capsule_muted', '#C8C2C9'),
        '--akx-blur:' . max(0, min(36, (int) ($h['capsule_blur'] ?? 18))) . 'px',
    ));
    $glass_class = !empty($h['mainbar_glass_enabled']) ? ' akx-glass-enabled' : '';

    ob_start();
    echo alookhor_cc_akx_header_critical_css();
    ?>
<div id="<?php echo $instance_id; ?>" class="akx-header<?php echo esc_attr($glass_class); ?>" dir="rtl" style="<?php echo esc_attr($style_vars); ?>" <?php echo $live_flag; ?>>

  <!-- نوار بالایی -->
  <div class="akx-topbar">
    <div class="akx-wrap akx-topbar-inner">

      <div class="akx-topbar-right">
        <a class="akx-wholesale" href="<?php echo $ws_url; ?>">
          <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M3 6h18M5 6l1 14h12l1-14M9 10v6M15 10v6"></path></svg>
          <span><?php echo $ws_txt; ?></span>
        </a>
        <a class="akx-export-link" href="<?php echo $exp_url; ?>">
          <svg viewBox="0 0 24 24" aria-hidden="true"><circle cx="12" cy="12" r="9"></circle><path d="M3 12h18M12 3c3 3 3 15 0 18M12 3c-3 3-3 15 0 18"></path></svg>
          <span><?php echo $exp_txt; ?></span>
        </a>
      </div>

      <div class="akx-topbar-left">
        <?php if ($wa_url): ?>
        <a class="akx-top-whatsapp" href="<?php echo $wa_url; ?>" target="_blank" rel="noopener" aria-label="واتساپ">
          <svg viewBox="0 0 24 24" aria-hidden="true">
            <path d="M20.5 3.5A11.7 11.7 0 0 0 12.1 0C5.6 0 .3 5.2.3 11.7c0 2.1.6 4.1 1.6 5.9L.2 24l6.6-1.7a11.8 11.8 0 0 0 5.3 1.3h.1c6.5 0 11.8-5.3 11.8-11.8 0-3.2-1.3-6.1-3.5-8.3ZM12.1 21.5c-1.7 0-3.4-.5-4.9-1.4l-.4-.2-3.9 1 1-3.8-.3-.4a9.5 9.5 0 0 1-1.5-5.1c0-5.3 4.3-9.6 9.6-9.6 2.6 0 5 .9 6.8 2.8a9.5 9.5 0 0 1 2.8 6.8c0 5.3-4.3 9.6-9.6 9.6h.4Z"></path>
            <path d="M17.4 14.3c-.3-.2-1.8-.9-2.1-1-.3-.1-.5-.2-.7.2s-.8 1-.9 1.2c-.2.2-.3.2-.6.1-1.8-.9-3-2.1-3.8-3.8-.2-.3 0-.5.1-.6.1-.1.3-.3.4-.5.1-.2.2-.3.3-.5.1-.2 0-.4 0-.5-.1-.1-.7-1.7-.9-2.3-.3-.7-.6-.6-.8-.6h-.7c-.2 0-.5.1-.8.4-.3.3-1 1-1 2.5 0 1.5 1.1 3 1.2 3.2.1.2 2.2 3.4 5.3 4.7.7.3 1.3.5 1.8.6.8.3 1.5.2 2.1.1.6-.1 1.8-.8 2.1-1.5.2-.7.2-1.3.2-1.5-.1-.2-.3-.3-.6-.5Z"></path>
          </svg>
        </a>
        <?php endif; ?>
        <?php if ($email): ?>
        <a href="mailto:<?php echo $email; ?>"><?php echo $email; ?></a>
        <?php endif; ?>
        <span class="akx-mini-icon">
          <svg viewBox="0 0 24 24"><path d="M3 5h18v14H3zM3 7l9 6 9-6"></path></svg>
        </span>
        <span class="akx-divider"></span>
        <a class="akx-phone" href="tel:<?php echo $phone_href; ?>"><?php echo $phone; ?></a>
        <span class="akx-mini-icon">
          <svg viewBox="0 0 24 24"><path d="M6.6 2.8 9.4 2c.6-.2 1.2.1 1.4.7l1.2 3.2c.2.5 0 1-.4 1.3L10 8.4c.9 1.9 2.5 3.5 4.4 4.4l1.2-1.6c.3-.4.8-.6 1.3-.4l3.2 1.2c.6.2.9.8.7 1.4l-.8 2.8c-.2.6-.7 1-1.4 1C10.1 17.2 4.8 11.9 4.8 4.2c0-.7.4-1.2 1.1-1.4Z"></path></svg>
        </span>
      </div>

    </div>
  </div>

  <!-- نوار اصلی -->
  <div class="akx-mainbar">
    <div class="akx-wrap akx-main-inner">

      <!-- کپسول شیشه‌ای یکپارچه: لوگو، همبرگری، منو و ابزارها -->
      <div class="akx-nav-capsule">

        <a class="akx-logo" href="<?php echo $home_url; ?>" aria-label="آلوخور">
          <?php if ($logo_img): ?>
          <img src="<?php echo $logo_img; ?>" alt="آلوخور" style="width:<?php echo $logo_w; ?>px;max-height:67px;object-fit:contain">
          <?php endif; ?>
        </a>

        <button class="akx-menu-button" type="button" aria-label="باز کردن منو" aria-expanded="false" aria-controls="<?php echo esc_attr($drawer_id); ?>">
          <span>منو</span>
          <i><b></b><b></b><b></b></i>
        </button>

        <nav class="akx-nav" aria-label="منوی اصلی">
          <ul>
            <li class="akx-active"><a href="<?php echo $home_url; ?>">صفحه اصلی</a></li>

            <li class="akx-has-mega">
              <a href="/shop/">
                محصولات
                <svg viewBox="0 0 24 24"><path d="m7 10 5 5 5-5"></path></svg>
              </a>

              <!-- مگامنو -->
              <div class="akx-mega-menu">

                <div class="akx-mega-col">
                  <h4>آلو خشکبار <span>◉</span></h4>
                  <a href="/product-category/dried-plums/">آلو حاج حسینی</a>
                  <a href="/product-category/dried-plums/">آلو بخارا ممتاز</a>
                  <a href="/product-category/dried-plums/">آلو حاج حسنی</a>
                  <a href="/product-category/dried-plums/">آلو کبرایی</a>
                </div>

                <div class="akx-mega-col">
                  <h4>برگه میوه‌ها <span>◉</span></h4>
                  <a href="/product-category/dried-fruits/">آلبالو خشک</a>
                  <a href="/product-category/dried-fruits/">برگه زردآلو</a>
                  <a href="/product-category/dried-fruits/">برگه هلو</a>
                </div>

                <div class="akx-mega-col">
                  <h4>تنقلات طبیعی <span>◉</span></h4>
                  <a href="/product-category/snacks/">لواشک طبیعی</a>
                  <a href="/product-category/snacks/">میوه خشک مخلوط</a>
                  <a href="/product-category/snacks/">آلوچه خشک</a>
                </div>

                <div class="akx-promo-card">
                  <div class="akx-promo-image"></div>
                  <h4>بسته‌بندی‌های لوکس صادراتی</h4>
                  <p>پک‌های چوبی و مکمل اعلا، مناسب سوغات شیک و هدیه سازمانی.</p>
                  <a href="/gift-packages/">مشاهده طرح‌ها</a>
                </div>

              </div>
            </li>

            <li><a href="/gift-packages/">بسته‌های هدیه</a></li>
            <li><a href="/blog/">مجله</a></li>
            <li><a href="/about/">درباره ما</a></li>
            <li><a href="/contact/">تماس با ما</a></li>
          </ul>
        </nav>

        <div class="akx-tools">

          <button class="akx-circle-btn akx-search-button" type="button" aria-label="جستجو">
            <svg viewBox="0 0 24 24">
              <circle cx="11" cy="11" r="6"></circle>
              <path d="m16 16 5 5"></path>
            </svg>
          </button>

          <a class="akx-circle-btn" href="<?php echo $cart_url; ?>" aria-label="سبد خرید">
            <svg viewBox="0 0 24 24">
              <path d="M3 4h2l2.2 11.2a2 2 0 0 0 2 1.6h8.8a2 2 0 0 0 2-1.6L21 8H6"></path>
              <circle cx="10" cy="21" r="1"></circle>
              <circle cx="18" cy="21" r="1"></circle>
            </svg>
            <em class="ak-cart-badge" <?php echo $cart_count ? '' : 'style="display:none"'; ?>><?php echo strtr((string) $cart_count, array('0'=>'۰','1'=>'۱','2'=>'۲','3'=>'۳','4'=>'۴','5'=>'۵','6'=>'۶','7'=>'۷','8'=>'۸','9'=>'۹')); ?></em>
          </a>

          <a class="akx-circle-btn" href="<?php echo $account_url; ?>" aria-label="حساب کاربری">
            <svg viewBox="0 0 24 24">
              <circle cx="12" cy="8" r="4"></circle>
              <path d="M4.5 21c.8-4 3.6-6 7.5-6s6.7 2 7.5 6"></path>
            </svg>
          </a>

        </div>
      </div>

      <!-- جستجو -->
      <form class="akx-search-panel" action="<?php echo $home_url; ?>" method="get">
        <input type="search" name="s" placeholder="<?php echo $search_ph; ?>">
        <button type="submit">جستجو</button>
      </form>

      <!-- منوی کشویی موبایل App-Like -->
      <div class="akx-mob-backdrop" id="<?php echo $back_id; ?>" aria-hidden="true"></div>
      <div class="akx-mob-drawer" id="<?php echo $drawer_id; ?>" role="dialog" aria-modal="true" aria-label="منوی موبایل آلوخور" aria-hidden="true" tabindex="-1">

        <div class="akx-mob-drawer-head">
          <button type="button" class="akx-mob-close" id="<?php echo $close_id; ?>" aria-label="بستن">
            <svg viewBox="0 0 24 24"><path d="M18 6L6 18M6 6l12 12" stroke="currentColor" stroke-width="2" stroke-linecap="round"/></svg>
          </button>
          <div class="akx-mob-brand">
            <div class="akx-mob-brand-text">
              <strong><?php echo $brand; ?></strong>
              <span><?php echo $sub; ?></span>
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
              <a href="/shop/" class="akx-mob-toggle" role="button" aria-expanded="false"><div class="akx-mob-item-main"><span class="akx-mob-icon">🛍️</span><span class="akx-mob-title">محصولات</span></div><span class="akx-mob-arrow">‹</span></a>
              <ul class="akx-mob-sub">
                <li><a href="/product-category/dried-plums/">آلو خشکبار</a></li>
                <li><a href="/product-category/dried-fruits/">برگه میوه‌ها</a></li>
                <li><a href="/product-category/snacks/">تنقلات طبیعی</a></li>
              </ul>
            </li>
            <li><a href="/gift-packages/"><div class="akx-mob-item-main"><span class="akx-mob-icon">🎁</span><span class="akx-mob-title">بسته‌های هدیه</span></div></a></li>
            <li><a href="/blog/"><div class="akx-mob-item-main"><span class="akx-mob-icon">📰</span><span class="akx-mob-title">مجله</span></div></a></li>
            <li><a href="/about/"><div class="akx-mob-item-main"><span class="akx-mob-icon">🏢</span><span class="akx-mob-title">درباره ما</span></div></a></li>
            <li><a href="/contact/"><div class="akx-mob-item-main"><span class="akx-mob-icon">📞</span><span class="akx-mob-title">تماس با ما</span></div></a></li>
          </ul>
        </div>

        <div class="akx-mob-footer">
          <a href="<?php echo $account_url; ?>"><span class="akx-foot-ic">👤</span><span>حساب من</span></a>
          <a href="<?php echo $cart_url; ?>"><span class="akx-foot-ic">🛒</span><span>سبد خرید</span></a>
          <?php if (is_user_logged_in()) : ?>
          <a class="akx-mob-auth is-logout" href="<?php echo esc_url(wp_logout_url($home_url)); ?>"><span class="akx-foot-ic akx-foot-ic-svg" aria-hidden="true"><svg viewBox="0 0 24 24"><path d="M15 4h3a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2h-3"/><path d="m10 17-5-5 5-5"/><path d="M5 12h11"/></svg></span><span>خروج از حساب</span></a>
          <?php else : ?>
          <a class="akx-mob-auth is-login" href="<?php echo $account_url; ?>"><span class="akx-foot-ic akx-foot-ic-svg" aria-hidden="true"><svg viewBox="0 0 24 24"><path d="M15 4h3a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2h-3"/><path d="m10 7 5 5-5 5"/><path d="M15 12H4"/></svg></span><span>ورود به حساب</span></a>
          <?php endif; ?>
        </div>

      </div>

    </div>
  </div>
</div>
    <?php
    return ob_get_clean();
}

// ===== SHORTCODE =====
add_action('init', function() {
    remove_shortcode('alookhor_portal_header');
    add_shortcode('alookhor_portal_header', 'alookhor_cc_render_akx_header');
}, 100);

// ===== FRONTEND ASSETS =====
add_action('wp_enqueue_scripts', function() {
    // v3.10.392: با مقادیر Resolve‌شده تصمیم بگیر (پیش‌فرض enabled=true هم پوشش داده شود).
    $h = alookhor_cc_front_header_settings();
    if (empty($h['enabled'])) return;
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
});
