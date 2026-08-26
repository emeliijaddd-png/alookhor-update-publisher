<?php
/**
 * Export banner — [alookhor_export_banner]
 *
 * Luxury dark-green export banner with gold frame, background image,
 * centered logo, glass contact card and two animated WhatsApp actions.
 *
 * Settings live in the dedicated option `alookhor_cc_export_banner` and can be
 * filtered with `alookhor_cc_export_banner_settings`. All assets are scoped to
 * `.alookhor-xb` so the Header, Mega Menu, Hero, Footer, Woodmart and
 * Elementor output remain untouched.
 */
if (!defined('ABSPATH')) exit;

if (!defined('ALOOKHOR_CC_EXPORT_BANNER_OPTION')) {
    define('ALOOKHOR_CC_EXPORT_BANNER_OPTION', 'alookhor_cc_export_banner');
}

function alookhor_cc_export_banner_asset($filename){
    return ALOOKHOR_CC_URL . 'assets/images/' . ltrim((string) $filename, '/');
}

function alookhor_cc_export_banner_defaults(){
    return [
        'enabled' => true,
        'background_image_id' => 0,
        'background_image_url' => alookhor_cc_export_banner_asset('export-banner-bg.jpg'),
        'logo_id' => 0,
        'logo_url' => '',
        'title' => 'صادرات آلو خشک ایران',
        'title_gold' => 'از باغ خراسان تا بندر جهان',
        'card_text' => 'ارسال مستقیم از مرکز سورت و بسته‌بندی آلوخور به بیش از ۱۵ کشور جهان — با بسته‌بندی صادراتی استاندارد، فاکتور رسمی و پیگیری لحظه‌ای مرسوله.',
        'status_text' => 'هم‌اکنون پاسخگو هستیم — پاسخ در کمتر از ۲ ساعت کاری',
        'whatsapp1_number' => '0915 951 3173',
        'whatsapp1_link' => 'https://wa.me/989159513173',
        'whatsapp2_number' => '0922 294 2808',
        'whatsapp2_link' => 'https://wa.me/989222942808',
        'bg_color' => '#0A2A1C',
        'gold_color' => '#D4AF37',
        'whatsapp_color' => '#1EBE5D',
        'card_opacity' => 78,
        'overlay_opacity' => 55,
        'blur_strength' => 14,
    ];
}

/** Convert a sanitized hex color to an "r,g,b" triplet for rgba() composition. */
function alookhor_cc_export_banner_hex_to_rgb($hex, $fallback){
    $hex = sanitize_hex_color($hex) ?: sanitize_hex_color($fallback) ?: '#0A2A1C';
    $hex = ltrim($hex, '#');
    if (strlen($hex) === 3) {
        $hex = $hex[0] . $hex[0] . $hex[1] . $hex[1] . $hex[2] . $hex[2];
    }
    return hexdec(substr($hex, 0, 2)) . ',' . hexdec(substr($hex, 2, 2)) . ',' . hexdec(substr($hex, 4, 2));
}

/** Shift a hex color lighter (positive amount) or darker (negative), clamped. */
function alookhor_cc_export_banner_shade($hex, $fallback, $amount){
    $rgb = alookhor_cc_export_banner_hex_to_rgb($hex, $fallback);
    $parts = array_map('intval', explode(',', $rgb));
    $shift = function($channel) use ($amount){
        return max(0, min(255, $channel + $amount));
    };
    return sprintf('#%02X%02X%02X', $shift($parts[0]), $shift($parts[1]), $shift($parts[2]));
}

function alookhor_cc_export_banner_normalize($incoming){
    $defaults = alookhor_cc_export_banner_defaults();
    $candidate = is_array($incoming) ? $incoming : [];
    $s = array_replace($defaults, $candidate);

    $s['enabled'] = rest_sanitize_boolean($s['enabled']);
    $s['background_image_id'] = absint($s['background_image_id']);
    $s['logo_id'] = absint($s['logo_id']);
    foreach (['background_image_url', 'logo_url', 'whatsapp1_link', 'whatsapp2_link'] as $key) {
        $s[$key] = esc_url_raw($s[$key]);
    }
    foreach (['title', 'title_gold', 'status_text', 'whatsapp1_number', 'whatsapp2_number'] as $key) {
        $s[$key] = sanitize_text_field($s[$key]);
    }
    $s['card_text'] = sanitize_textarea_field($s['card_text']);
    foreach (['bg_color' => $defaults['bg_color'], 'gold_color' => $defaults['gold_color'], 'whatsapp_color' => $defaults['whatsapp_color']] as $key => $fallback) {
        $s[$key] = sanitize_hex_color($s[$key]) ?: $fallback;
    }
    $s['card_opacity'] = max(20, min(95, absint($s['card_opacity'])));
    $s['overlay_opacity'] = max(0, min(95, absint($s['overlay_opacity'])));
    $s['blur_strength'] = max(0, min(40, absint($s['blur_strength'])));
    return $s;
}

function alookhor_cc_get_export_banner_settings(){
    $saved = get_option(ALOOKHOR_CC_EXPORT_BANNER_OPTION, []);
    if (!is_array($saved)) $saved = [];
    return apply_filters('alookhor_cc_export_banner_settings', alookhor_cc_export_banner_normalize($saved));
}

/** Resolve a media-library attachment first, falling back to the stored URL. */
function alookhor_cc_export_banner_image_url($attachment_id, $stored_url){
    $attachment_id = absint($attachment_id);
    if ($attachment_id) {
        $attachment = wp_get_attachment_image_url($attachment_id, 'full');
        if ($attachment) return $attachment;
    }
    return esc_url_raw($stored_url);
}

function alookhor_cc_export_banner_markup($settings = null){
    $s = is_array($settings) ? alookhor_cc_export_banner_normalize($settings) : alookhor_cc_get_export_banner_settings();
    if (empty($s['enabled'])) return '';

    $background = alookhor_cc_export_banner_image_url($s['background_image_id'], $s['background_image_url']);
    $logo = alookhor_cc_export_banner_image_url($s['logo_id'], $s['logo_url']);

    $site = function_exists('alookhor_cc_get_settings') ? alookhor_cc_get_settings() : [];
    $logo_letter = is_array($site['site'] ?? null) && !empty($site['site']['logoLetter']) ? $site['site']['logoLetter'] : 'آ';

    $bg_rgb = alookhor_cc_export_banner_hex_to_rgb($s['bg_color'], '#0A2A1C');
    $gold_light = alookhor_cc_export_banner_shade($s['gold_color'], '#D4AF37', 28);
    $wa_dark = alookhor_cc_export_banner_shade($s['whatsapp_color'], '#1EBE5D', -34);

    $style_vars = [
        '--akx-bg:' . $s['bg_color'],
        '--akx-bg-rgb:' . $bg_rgb,
        '--akx-gold:' . $s['gold_color'],
        '--akx-gold-light:' . $gold_light,
        '--akx-wa:' . $s['whatsapp_color'],
        '--akx-wa-dark:' . $wa_dark,
        '--akx-card-alpha:' . number_format($s['card_opacity'] / 100, 2, '.', ''),
        '--akx-overlay:' . number_format($s['overlay_opacity'] / 100, 2, '.', ''),
        '--akx-blur:' . $s['blur_strength'] . 'px',
        '--akx-image:' . ($background ? "url('" . esc_url($background) . "')" : 'none'),
    ];

    ob_start();
    // Elementor Editor ممکن است شورت‌کد را بعد از wp_head رندر کند؛ استایل Scoped همراه خروجی تضمین می‌شود.
    static $inline_style_printed = false;
    if (!$inline_style_printed) {
        $inline_style_printed = true;
        $css_file = ALOOKHOR_CC_DIR . 'assets/css/frontend-export-banner.css';
        if (file_exists($css_file)) echo '<style id="alookhor-export-banner-inline">' . file_get_contents($css_file) . '</style>';
    }
    ?>
    <section class="alookhor-xb" dir="rtl" data-version="<?php echo esc_attr(ALOOKHOR_CC_VERSION); ?>" style="<?php echo esc_attr(implode(';', $style_vars)); ?>" aria-label="بنر صادراتی آلوخور">
      <div class="alookhor-xb-bg" aria-hidden="true"></div>
      <div class="alookhor-xb-inner">
        <div class="alookhor-xb-grid">
          <div class="alookhor-xb-content">
            <?php if ($s['title'] !== '' || $s['title_gold'] !== ''): ?>
            <h2 class="alookhor-xb-title"><?php echo esc_html($s['title']); ?><?php if ($s['title_gold'] !== ''): ?> <strong><?php echo esc_html($s['title_gold']); ?></strong><?php endif; ?></h2>
            <?php endif; ?>
            <span class="alookhor-xb-rule" aria-hidden="true"></span>
          </div>
          <div class="alookhor-xb-logo">
            <span class="alookhor-xb-logo-ring" aria-hidden="true">
              <?php if ($logo): ?>
              <img src="<?php echo esc_url($logo); ?>" alt="<?php echo esc_attr(get_bloginfo('name')); ?>" loading="lazy" decoding="async" draggable="false">
              <?php else: ?>
              <span class="alookhor-xb-logo-letter"><?php echo esc_html($logo_letter); ?></span>
              <?php endif; ?>
            </span>
          </div>
          <aside class="alookhor-xb-card">
            <?php if ($s['card_text'] !== ''): ?><p class="alookhor-xb-card-text"><?php echo esc_html($s['card_text']); ?></p><?php endif; ?>
            <?php if ($s['status_text'] !== ''): ?><p class="alookhor-xb-status"><span class="alookhor-xb-pulse" aria-hidden="true"></span><?php echo esc_html($s['status_text']); ?></p><?php endif; ?>
            <div class="alookhor-xb-actions">
              <?php foreach ([1, 2] as $slot):
                  $number = trim((string) $s['whatsapp' . $slot . '_number']);
                  $link = trim((string) $s['whatsapp' . $slot . '_link']);
                  if ($number === '') continue;
                  $href = $link !== '' ? $link : 'https://wa.me/' . preg_replace('/\D+/', '', $number);
              ?>
              <a class="alookhor-xb-wa<?php echo $slot === 2 ? ' is-alt' : ''; ?>" href="<?php echo esc_url($href); ?>" target="_blank" rel="noopener nofollow">
                <svg viewBox="0 0 24 24" aria-hidden="true" focusable="false"><path d="M12.04 2a9.9 9.9 0 0 0-8.5 14.96L2 22l5.2-1.5A9.92 9.92 0 1 0 12.04 2Zm0 1.82a8.1 8.1 0 1 1-4.13 15.06l-.3-.18-3.07.88.9-2.99-.2-.31a8.1 8.1 0 0 1 6.8-12.46Zm-3.1 4.12c-.17 0-.45.06-.68.32-.23.26-.9.88-.9 2.14s.92 2.48 1.05 2.65c.13.17 1.8 2.88 4.44 3.92 2.2.87 2.65.7 3.12.65.48-.04 1.54-.63 1.76-1.24.22-.6.22-1.13.15-1.24-.06-.1-.24-.17-.5-.3-.27-.13-1.55-.76-1.79-.85-.24-.09-.42-.13-.6.13-.17.26-.68.85-.84 1.02-.15.17-.3.2-.57.07a7.4 7.4 0 0 1-2.2-1.36 8.24 8.24 0 0 1-1.52-1.9c-.16-.26-.02-.4.12-.53.12-.12.26-.3.4-.46.13-.16.17-.27.26-.46.09-.19.04-.35-.02-.5-.07-.14-.6-1.44-.84-1.97-.2-.47-.41-.47-.58-.48l-.87-.01Z"/></svg>
                <span><?php echo esc_html($number); ?></span>
              </a>
              <?php endforeach; ?>
            </div>
          </aside>
        </div>
      </div>
    </section>
    <?php
    return ob_get_clean();
}

function alookhor_cc_export_banner_shortcode($atts = []){
    $settings = alookhor_cc_get_export_banner_settings();
    $atts = shortcode_atts([
        'enabled' => !empty($settings['enabled']) ? '1' : '0',
    ], $atts, 'alookhor_export_banner');
    $settings['enabled'] = rest_sanitize_boolean($atts['enabled']);
    return alookhor_cc_export_banner_markup($settings);
}
add_shortcode('alookhor_export_banner', 'alookhor_cc_export_banner_shortcode');

// ——— Frontend assets — کاملاً Scoped به .alookhor-xb ———
add_action('wp_enqueue_scripts', function(){
    $settings = alookhor_cc_get_export_banner_settings();
    if (empty($settings['enabled'])) return;
    wp_enqueue_style('alookhor-cc-export-banner', ALOOKHOR_CC_URL . 'assets/css/frontend-export-banner.css', [], ALOOKHOR_CC_BUILD);
    wp_enqueue_script('alookhor-cc-export-banner', ALOOKHOR_CC_URL . 'assets/js/frontend-export-banner.js', [], ALOOKHOR_CC_BUILD, true);
}, 31);
