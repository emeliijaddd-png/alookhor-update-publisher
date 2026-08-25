<?php
/**
 * Purple glass slider — [alookhor_purple_slider]
 *
 * Settings live in the dedicated option `alookhor_cc_purple_slider` and can be
 * filtered with `alookhor_cc_purple_slider_settings`. Assets are scoped to
 * `.alookhor-ps` so Woodmart / Elementor remain untouched.
 */
if (!defined('ABSPATH')) exit;

if (!defined('ALOOKHOR_CC_PURPLE_SLIDER_OPTION')) {
    define('ALOOKHOR_CC_PURPLE_SLIDER_OPTION', 'alookhor_cc_purple_slider');
}

function alookhor_cc_purple_slider_asset($filename){
    return ALOOKHOR_CC_URL . 'assets/images/' . ltrim((string) $filename, '/');
}

function alookhor_cc_purple_slider_slide_defaults(){
    return [
        [
            'image_id' => 0,
            'image_url' => alookhor_cc_purple_slider_asset('category-plums.jpg'),
            'image_alt' => 'آلو بخارا ممتاز خراسان',
            'kicker' => 'محصول ممتاز خراسان',
            'title' => 'آلو بخارا',
            'highlight' => 'شیشه‌ای بنفش',
            'description' => 'طبیعی، سالم و بدون مواد افزودنی — سورت یکدست از باغ‌های خراسان.',
            'primary_text' => 'مشاهده محصولات',
            'primary_url' => home_url('/shop/'),
            'secondary_text' => 'استعلام قیمت',
            'secondary_url' => home_url('/#b2b'),
        ],
        [
            'image_id' => 0,
            'image_url' => alookhor_cc_purple_slider_asset('category-fruit-sheets.jpg'),
            'image_alt' => 'لواشک میوه‌ای آلوخور',
            'kicker' => 'طعم باغ‌های ایران',
            'title' => 'لواشک میوه‌ای',
            'highlight' => 'ترش و طبیعی',
            'description' => 'ورقه‌های میوه خالص با رنگ زنده و طعم اصیل، آماده سرو و هدیه.',
            'primary_text' => 'خرید لواشک',
            'primary_url' => home_url('/shop/'),
            'secondary_text' => 'مشاوره خرید',
            'secondary_url' => home_url('/تماس-با-ما/'),
        ],
        [
            'image_id' => 0,
            'image_url' => alookhor_cc_purple_slider_asset('category-natural-snacks.jpg'),
            'image_alt' => 'تنقلات طبیعی آلوخور',
            'kicker' => 'انتخاب سالم روزانه',
            'title' => 'تنقلات طبیعی',
            'highlight' => 'بدون افزودنی',
            'description' => 'میان‌وعده‌های سالم با فرآوری بهداشتی و بسته‌بندی مطمئن برای خانواده.',
            'primary_text' => 'مشاهده تنقلات',
            'primary_url' => home_url('/shop/'),
            'secondary_text' => 'تماس با ما',
            'secondary_url' => home_url('/تماس-با-ما/'),
        ],
        [
            'image_id' => 0,
            'image_url' => alookhor_cc_purple_slider_asset('category-nuts.jpg'),
            'image_alt' => 'آجیل و مغزهای آلوخور',
            'kicker' => 'سورت صادراتی',
            'title' => 'آجیل ممتاز',
            'highlight' => 'برای سفره و صادرات',
            'description' => 'مغزهای تازه، سورت دقیق و ظرفیت پایدار برای همکاری عمده و خرده‌فروشی.',
            'primary_text' => 'درخواست همکاری',
            'primary_url' => home_url('/#b2b'),
            'secondary_text' => 'دریافت مشاوره',
            'secondary_url' => home_url('/تماس-با-ما/'),
        ],
    ];
}

function alookhor_cc_purple_slider_defaults(){
    return [
        'autoplay' => 5500,
        'arrows' => true,
        'dots' => true,
        'slides' => alookhor_cc_purple_slider_slide_defaults(),
    ];
}

function alookhor_cc_normalize_purple_slider_autoplay($value, $fallback = 5500){
    $interval = absint($value);
    if ($interval < 1) $interval = absint($fallback) ?: 5500;
    return max(3000, min(15000, $interval));
}

function alookhor_cc_normalize_purple_slider_slides($incoming){
    $defaults = alookhor_cc_purple_slider_slide_defaults();
    $rows = is_array($incoming) ? array_values($incoming) : $defaults;
    if (!$rows) $rows = $defaults;
    $count = max(1, min(6, count($rows)));
    $normalized = [];
    for ($index = 0; $index < $count; $index++) {
        $candidate = is_array($rows[$index] ?? null) ? $rows[$index] : [];
        $fallback = $defaults[$index] ?? $defaults[0];
        $slide = array_replace($fallback, $candidate);
        $image_id = absint($slide['image_id'] ?? 0);
        $image_url = esc_url_raw($slide['image_url'] ?? '');
        if ($image_id) {
            $attachment = wp_get_attachment_image_url($image_id, 'full');
            if ($attachment) $image_url = $attachment;
        }
        $normalized[] = [
            'image_id' => $image_id,
            'image_url' => $image_url,
            'image_alt' => sanitize_text_field($slide['image_alt'] ?? ''),
            'kicker' => sanitize_text_field($slide['kicker'] ?? ''),
            'title' => sanitize_text_field($slide['title'] ?? ''),
            'highlight' => sanitize_text_field($slide['highlight'] ?? ''),
            'description' => sanitize_textarea_field($slide['description'] ?? ''),
            'primary_text' => sanitize_text_field($slide['primary_text'] ?? ''),
            'primary_url' => esc_url_raw($slide['primary_url'] ?? ''),
            'secondary_text' => sanitize_text_field($slide['secondary_text'] ?? ''),
            'secondary_url' => esc_url_raw($slide['secondary_url'] ?? ''),
        ];
    }
    return $normalized;
}

function alookhor_cc_get_purple_slider_settings(){
    $saved = get_option(ALOOKHOR_CC_PURPLE_SLIDER_OPTION, []);
    if (!is_array($saved)) $saved = [];
    $defaults = alookhor_cc_purple_slider_defaults();
    $settings = array_replace($defaults, $saved);
    $settings['autoplay'] = alookhor_cc_normalize_purple_slider_autoplay($settings['autoplay'] ?? $defaults['autoplay']);
    $settings['arrows'] = rest_sanitize_boolean($settings['arrows'] ?? true);
    $settings['dots'] = rest_sanitize_boolean($settings['dots'] ?? true);
    $settings['slides'] = alookhor_cc_normalize_purple_slider_slides($saved['slides'] ?? $defaults['slides']);
    return apply_filters('alookhor_cc_purple_slider_settings', $settings);
}

function alookhor_cc_purple_slider_image_url($slide){
    $attachment_id = absint($slide['image_id'] ?? 0);
    if ($attachment_id) {
        $attachment = wp_get_attachment_image_url($attachment_id, 'full');
        if ($attachment) return $attachment;
    }
    return esc_url_raw($slide['image_url'] ?? '');
}

function alookhor_cc_purple_slider_markup($settings = null){
    $s = is_array($settings) ? $settings : alookhor_cc_get_purple_slider_settings();
    $slides = alookhor_cc_normalize_purple_slider_slides($s['slides'] ?? []);
    if (!$slides) return '';
    $autoplay = alookhor_cc_normalize_purple_slider_autoplay($s['autoplay'] ?? 5500);
    $arrows = !empty($s['arrows']);
    $dots = !empty($s['dots']);
    $count = count($slides);
    ob_start(); ?>
    <section class="alookhor-ps" dir="rtl"
      data-version="<?php echo esc_attr(ALOOKHOR_CC_VERSION); ?>"
      data-slide-count="<?php echo esc_attr($count); ?>"
      data-autoplay="<?php echo esc_attr($autoplay); ?>"
      data-arrows="<?php echo $arrows ? '1' : '0'; ?>"
      data-dots="<?php echo $dots ? '1' : '0'; ?>"
      aria-roledescription="carousel"
      aria-label="اسلایدر بنفش شیشه‌ای آلوخور">
      <div class="alookhor-ps-shell">
        <div class="alookhor-ps-track" aria-live="off">
          <?php foreach ($slides as $index => $slide): $image = alookhor_cc_purple_slider_image_url($slide); ?>
          <article class="alookhor-ps-slide<?php echo $index === 0 ? ' is-active' : ''; ?>" data-slide="<?php echo esc_attr($index); ?>" aria-hidden="<?php echo $index === 0 ? 'false' : 'true'; ?>">
            <div class="alookhor-ps-media">
              <?php if ($image): ?><img src="<?php echo esc_url($image); ?>" alt="<?php echo esc_attr($slide['image_alt'] ?? ''); ?>" <?php echo $index === 0 ? 'fetchpriority="high"' : 'loading="lazy"'; ?> decoding="async" draggable="false"><?php endif; ?>
            </div>
            <div class="alookhor-ps-shade" aria-hidden="true"></div>
            <div class="alookhor-ps-content">
              <?php if (!empty($slide['kicker'])): ?><span class="alookhor-ps-kicker"><?php echo esc_html($slide['kicker']); ?></span><?php endif; ?>
              <h2><?php echo esc_html($slide['title'] ?? ''); ?><?php if (!empty($slide['highlight'])): ?> <strong><?php echo esc_html($slide['highlight']); ?></strong><?php endif; ?></h2>
              <?php if (!empty($slide['description'])): ?><p class="alookhor-ps-desc"><?php echo esc_html($slide['description']); ?></p><?php endif; ?>
              <div class="alookhor-ps-actions">
                <?php if (!empty($slide['primary_text'])): ?><a class="alookhor-ps-cta is-primary" href="<?php echo esc_url($slide['primary_url'] ?? '#'); ?>"><span><?php echo esc_html($slide['primary_text']); ?></span></a><?php endif; ?>
                <?php if (!empty($slide['secondary_text'])): ?><a class="alookhor-ps-cta is-secondary" href="<?php echo esc_url($slide['secondary_url'] ?? '#'); ?>"><span><?php echo esc_html($slide['secondary_text']); ?></span></a><?php endif; ?>
              </div>
            </div>
          </article>
          <?php endforeach; ?>
        </div>
        <?php if ($arrows && $count > 1): ?>
        <button type="button" class="alookhor-ps-arrow is-prev" aria-label="اسلاید قبلی"><svg viewBox="0 0 24 24" aria-hidden="true"><path d="m15 5-7 7 7 7"/></svg></button>
        <button type="button" class="alookhor-ps-arrow is-next" aria-label="اسلاید بعدی"><svg viewBox="0 0 24 24" aria-hidden="true"><path d="m9 5 7 7-7 7"/></svg></button>
        <?php endif; ?>
        <?php if ($dots && $count > 1): ?>
        <div class="alookhor-ps-dots" role="tablist" aria-label="انتخاب اسلاید">
          <?php for ($i = 0; $i < $count; $i++): ?>
          <button type="button" role="tab" data-slide="<?php echo esc_attr($i); ?>" class="<?php echo $i === 0 ? 'is-active' : ''; ?>" aria-selected="<?php echo $i === 0 ? 'true' : 'false'; ?>" aria-label="اسلاید <?php echo esc_attr($i + 1); ?>"></button>
          <?php endfor; ?>
        </div>
        <?php endif; ?>
        <span class="alookhor-ps-status screen-reader-text" aria-live="polite"></span>
      </div>
    </section>
    <?php
    return ob_get_clean();
}

function alookhor_cc_purple_slider_shortcode($atts = []){
    $settings = alookhor_cc_get_purple_slider_settings();
    $atts = shortcode_atts([
        'autoplay' => (string) $settings['autoplay'],
        'arrows' => !empty($settings['arrows']) ? '1' : '0',
        'dots' => !empty($settings['dots']) ? '1' : '0',
    ], $atts, 'alookhor_purple_slider');

    $settings['autoplay'] = alookhor_cc_normalize_purple_slider_autoplay($atts['autoplay'], $settings['autoplay']);
    $settings['arrows'] = rest_sanitize_boolean($atts['arrows']);
    $settings['dots'] = rest_sanitize_boolean($atts['dots']);
    return alookhor_cc_purple_slider_markup($settings);
}
add_shortcode('alookhor_purple_slider', 'alookhor_cc_purple_slider_shortcode');
