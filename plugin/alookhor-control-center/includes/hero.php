<?php
/**
 * Managed four-slide Hero for ALOOKHOR.
 *
 * The current Home page renders the legacy `.alookhor-hero-slider-wrapper`
 * inside an Elementor Shortcode widget. The managed runtime replaces that
 * exact node in place; no Elementor structure or unrelated content is moved.
 */
if (!defined('ABSPATH')) exit;

function alookhor_cc_hero_slide_defaults(){
    $legacy_base = plugins_url('alookhor-categories-manager/images/');
    return [
        [
            'image_id'=>0,
            'image_url'=>$legacy_base.'slide1.jpg',
            'flip_image'=>true,
            'image_alt'=>'آلو بخارا ممتاز خراسان',
            'kicker'=>'محصول ممتاز خراسان',
            'title'=>'آلو بخارا',
            'highlight'=>'ممتاز خراسان',
            'description'=>'طبیعی، سالم و بدون مواد افزودنی',
            'features'=>['۱۰۰٪ طبیعی','کیفیت صادراتی','ارسال سریع','ارسال به سراسر جهان'],
            'primary_text'=>'مشاهده محصولات',
            'primary_url'=>home_url('/shop/'),
            'secondary_text'=>'استعلام قیمت',
            'secondary_url'=>home_url('/#b2b'),
        ],
        [
            'image_id'=>0,
            'image_url'=>$legacy_base.'slide2.jpg',
            'flip_image'=>true,
            'image_alt'=>'آلو خشک طبیعی آلوخور',
            'kicker'=>'انتخابی از باغ‌های ایران',
            'title'=>'آلو خشک طبیعی',
            'highlight'=>'خوش‌طعم و سالم',
            'description'=>'سورت یکدست، فرآوری بهداشتی و طعم اصیل',
            'features'=>['بدون افزودنی','سورت ممتاز','بسته‌بندی مطمئن','تحویل سریع'],
            'primary_text'=>'خرید محصولات',
            'primary_url'=>home_url('/shop/'),
            'secondary_text'=>'مشاوره خرید',
            'secondary_url'=>home_url('/تماس-با-ما/'),
        ],
        [
            'image_id'=>0,
            'image_url'=>$legacy_base.'slide3.jpg',
            'flip_image'=>true,
            'image_alt'=>'بسته‌بندی صادراتی آلوخور',
            'kicker'=>'استاندارد بازارهای جهانی',
            'title'=>'بسته‌بندی حرفه‌ای',
            'highlight'=>'آماده صادرات',
            'description'=>'حفظ کیفیت محصول از باغ تا مقصد نهایی',
            'features'=>['کنترل کیفیت','سورت دقیق','بسته‌بندی صادراتی','ارسال بین‌المللی'],
            'primary_text'=>'خدمات صادرات',
            'primary_url'=>home_url('/#b2b'),
            'secondary_text'=>'تماس با ما',
            'secondary_url'=>home_url('/تماس-با-ما/'),
        ],
        [
            'image_id'=>0,
            'image_url'=>$legacy_base.'slide4.jpg',
            'flip_image'=>true,
            'image_alt'=>'سفارش عمده محصولات آلوخور',
            'kicker'=>'همکاری مطمئن و ماندگار',
            'title'=>'تأمین عمده آلو',
            'highlight'=>'برای کسب‌وکارها',
            'description'=>'ظرفیت پایدار، قیمت رقابتی و پشتیبانی تخصصی',
            'features'=>['تأمین پایدار','قیمت همکاری','کنترل سفارش','پشتیبانی مستقیم'],
            'primary_text'=>'درخواست همکاری',
            'primary_url'=>home_url('/#b2b'),
            'secondary_text'=>'دریافت مشاوره',
            'secondary_url'=>home_url('/تماس-با-ما/'),
        ],
    ];
}

function alookhor_cc_hero_defaults(){
    return [
        'enabled'=>true,
        'hide_legacy'=>true,
        'autoplay'=>true,
        'autoplay_interval'=>5500,
        'pause_on_hover'=>true,
        'show_arrows'=>true,
        'show_dots'=>true,
        'ken_burns'=>true,
        'gold'=>'#D4AF37',
        'surface'=>'#09060D',
        'text'=>'#FFFFFF',
        'muted'=>'#D9D1DA',
        'radius'=>32,
        'panel_opacity'=>34,
        'panel_blur'=>20,
        'slides'=>alookhor_cc_hero_slide_defaults(),
    ];
}

function alookhor_cc_get_hero_settings(){
    $main = alookhor_cc_get_settings();
    $saved = is_array($main['hero_settings'] ?? null) ? $main['hero_settings'] : [];
    $settings = array_replace_recursive(alookhor_cc_hero_defaults(), $saved);
    $defaults = alookhor_cc_hero_slide_defaults();
    $slides = is_array($saved['slides'] ?? null) ? array_values($saved['slides']) : [];
    $normalized = [];
    for ($index=0; $index<4; $index++) {
        $candidate = is_array($slides[$index] ?? null) ? $slides[$index] : [];
        $normalized[$index] = array_replace_recursive($defaults[$index], $candidate);
        $features = is_array($candidate['features'] ?? null) ? array_values($candidate['features']) : [];
        $normalized[$index]['features'] = array_slice(array_pad($features, 4, ''), 0, 4);
        if (!$features) $normalized[$index]['features'] = $defaults[$index]['features'];
    }
    $settings['slides'] = $normalized;
    return apply_filters('alookhor_cc_hero_settings', $settings);
}

function alookhor_cc_hero_icon($index){
    $icons = [
        '<svg viewBox="0 0 48 48" aria-hidden="true"><path d="M24 41V19M24 30c-8 0-13-5-13-13 8 0 13 5 13 13Zm0-6c0-8 5-13 13-13 0 8-5 13-13 13Z"/></svg>',
        '<svg viewBox="0 0 48 48" aria-hidden="true"><circle cx="24" cy="20" r="12"/><path d="m17 31-2 11 9-5 9 5-2-11M20 20l3 3 6-7"/></svg>',
        '<svg viewBox="0 0 48 48" aria-hidden="true"><path d="M6 13h24v22H6zM30 21h7l5 7v7H30zM14 39a4 4 0 1 0 0-8 4 4 0 0 0 0 8Zm21 0a4 4 0 1 0 0-8 4 4 0 0 0 0 8Z"/></svg>',
        '<svg viewBox="0 0 48 48" aria-hidden="true"><circle cx="24" cy="24" r="18"/><path d="M6 24h36M24 6c6 5 9 11 9 18s-3 13-9 18c-6-5-9-11-9-18s3-13 9-18Z"/></svg>',
    ];
    return $icons[$index % 4];
}

function alookhor_cc_hero_image_url($slide){
    $attachment_id = absint($slide['image_id'] ?? 0);
    if ($attachment_id) {
        $attachment = wp_get_attachment_image_url($attachment_id, 'full');
        if ($attachment) return $attachment;
    }
    return esc_url_raw($slide['image_url'] ?? '');
}

function alookhor_cc_hero_markup($settings=null){
    $s = is_array($settings) ? $settings : alookhor_cc_get_hero_settings();
    if (empty($s['enabled'])) return '';
    $slides = array_slice(array_values((array)($s['slides'] ?? [])), 0, 4);
    if (count($slides) !== 4) return '';
    $style = sprintf(
        '--mh-gold:%s;--mh-surface:%s;--mh-text:%s;--mh-muted:%s;--mh-radius:%dpx;--mh-panel-alpha:%.2F;--mh-panel-blur:%dpx',
        sanitize_hex_color($s['gold'] ?? '') ?: '#D4AF37',
        sanitize_hex_color($s['surface'] ?? '') ?: '#09060D',
        sanitize_hex_color($s['text'] ?? '') ?: '#FFFFFF',
        sanitize_hex_color($s['muted'] ?? '') ?: '#D9D1DA',
        max(16, min(40, absint($s['radius'] ?? 32))),
        max(10, min(85, absint($s['panel_opacity'] ?? 34))) / 100,
        max(0, min(40, absint($s['panel_blur'] ?? 20)))
    );
    ob_start(); ?>
    <section id="alookhor-managed-hero" class="alookhor-mh" dir="rtl" style="<?php echo esc_attr($style); ?>"
      data-version="<?php echo esc_attr(ALOOKHOR_CC_VERSION); ?>" data-slide-count="4"
      data-autoplay="<?php echo !empty($s['autoplay'])?'1':'0'; ?>"
      data-interval="<?php echo esc_attr(max(3000,min(15000,absint($s['autoplay_interval'] ?? 5500)))); ?>"
      data-pause-hover="<?php echo !empty($s['pause_on_hover'])?'1':'0'; ?>"
      data-ken-burns="<?php echo !empty($s['ken_burns'])?'1':'0'; ?>"
      aria-roledescription="carousel" aria-label="اسلایدر محصولات آلوخور">
      <div class="alookhor-mh-shell">
        <div class="alookhor-mh-slides" aria-live="off">
          <?php foreach($slides as $index=>$slide): $image=alookhor_cc_hero_image_url($slide); ?>
          <article class="alookhor-mh-slide<?php echo $index===0?' is-active':''; ?><?php echo !empty($slide['flip_image'])?' is-image-flipped':''; ?>" data-slide="<?php echo esc_attr($index); ?>" aria-hidden="<?php echo $index===0?'false':'true'; ?>">
            <div class="alookhor-mh-media">
              <?php if($image): ?><img src="<?php echo esc_url($image); ?>" alt="<?php echo esc_attr($slide['image_alt'] ?? ''); ?>" <?php echo $index===0?'fetchpriority="high"':'loading="lazy"'; ?> decoding="async"><?php endif; ?>
            </div>
            <div class="alookhor-mh-shade" aria-hidden="true"></div>
            <div class="alookhor-mh-content">
              <?php if(!empty($slide['kicker'])): ?><span class="alookhor-mh-kicker"><?php echo esc_html($slide['kicker']); ?></span><?php endif; ?>
              <h2><?php echo esc_html($slide['title'] ?? ''); ?><?php if(!empty($slide['highlight'])): ?><strong><?php echo esc_html($slide['highlight']); ?></strong><?php endif; ?></h2>
              <?php if(!empty($slide['description'])): ?><p class="alookhor-mh-description"><?php echo esc_html($slide['description']); ?></p><?php endif; ?>
              <div class="alookhor-mh-features">
                <?php foreach(array_slice(array_pad((array)($slide['features'] ?? []),4,''),0,4) as $feature_index=>$feature): if($feature==='')continue; ?>
                <span class="alookhor-mh-feature"><?php echo alookhor_cc_hero_icon($feature_index); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?><b><?php echo esc_html($feature); ?></b></span>
                <?php endforeach; ?>
              </div>
              <div class="alookhor-mh-actions">
                <?php if(!empty($slide['primary_text'])): ?><a class="alookhor-mh-cta is-primary" href="<?php echo esc_url($slide['primary_url'] ?? '#'); ?>"><span><?php echo esc_html($slide['primary_text']); ?></span><i aria-hidden="true">←</i></a><?php endif; ?>
                <?php if(!empty($slide['secondary_text'])): ?><a class="alookhor-mh-cta is-secondary" href="<?php echo esc_url($slide['secondary_url'] ?? '#'); ?>"><span><?php echo esc_html($slide['secondary_text']); ?></span></a><?php endif; ?>
              </div>
            </div>
          </article>
          <?php endforeach; ?>
        </div>
        <?php if(!empty($s['show_arrows'])): ?>
        <button type="button" class="alookhor-mh-arrow is-prev" aria-label="اسلاید قبلی"><svg viewBox="0 0 24 24" aria-hidden="true"><path d="m15 5-7 7 7 7"/></svg></button>
        <button type="button" class="alookhor-mh-arrow is-next" aria-label="اسلاید بعدی"><svg viewBox="0 0 24 24" aria-hidden="true"><path d="m9 5 7 7-7 7"/></svg></button>
        <?php endif; ?>
        <?php if(!empty($s['show_dots'])): ?><div class="alookhor-mh-dots" role="tablist" aria-label="انتخاب اسلاید"><?php for($i=0;$i<4;$i++): ?><button type="button" role="tab" data-slide="<?php echo esc_attr($i); ?>" class="<?php echo $i===0?'is-active':''; ?>" aria-selected="<?php echo $i===0?'true':'false'; ?>" aria-label="اسلاید <?php echo esc_attr($i+1); ?>"></button><?php endfor; ?></div><?php endif; ?>
        <span class="alookhor-mh-status screen-reader-text" aria-live="polite"></span>
      </div>
    </section>
    <?php return ob_get_clean();
}

function alookhor_cc_hero_shortcode(){
    if(!empty($GLOBALS['alookhor_cc_hero_shortcode_rendered'])) return '';
    $settings = alookhor_cc_get_hero_settings();
    if(empty($settings['enabled'])) return '';
    $GLOBALS['alookhor_cc_hero_shortcode_rendered'] = true;
    return alookhor_cc_hero_markup($settings);
}
add_shortcode('alookhor_managed_hero','alookhor_cc_hero_shortcode');

/**
 * قرارداد واحد Hero: شورت‌کد قدیمی افزونه VIP نباید اسلایدر موازی بسازد.
 * در اولویت انتهایی ثبت می‌شود تا مستقل از ترتیب بارگذاری افزونه‌ها باشد.
 */
function alookhor_cc_retire_legacy_vip_slider_shortcode() {
    remove_shortcode('alookhor_vip_slider');
    add_shortcode('alookhor_vip_slider', '__return_empty_string');
}
add_action('init', 'alookhor_cc_retire_legacy_vip_slider_shortcode', 999);

function alookhor_cc_hero_template(){
    static $done=false;
    if($done || is_admin() || !is_front_page() || !empty($GLOBALS['alookhor_cc_hero_shortcode_rendered'])) return;
    $settings=alookhor_cc_get_hero_settings();
    if(empty($settings['enabled'])) return;
    $done=true;
    echo '<template id="alookhor-managed-hero-template">'.alookhor_cc_hero_markup($settings).'</template>';
    echo '<noscript><style>body.alookhor-mh-hide-legacy .alookhor-hero-slider-wrapper{display:block!important}</style></noscript>';
}
add_action('wp_footer','alookhor_cc_hero_template',1);

add_filter('body_class',function($classes){
    $settings=alookhor_cc_get_hero_settings();
    if(!empty($settings['enabled'])) $classes[]='alookhor-mh-enabled';
    if(!empty($settings['enabled'])&&!empty($settings['hide_legacy'])) $classes[]='alookhor-mh-hide-legacy';
    return array_values(array_unique($classes));
});

add_action('wp_enqueue_scripts',function(){
    if(!is_front_page()) return;
    $settings=alookhor_cc_get_hero_settings();
    if(empty($settings['enabled'])) return;
    wp_enqueue_style('alookhor-cc-managed-hero',ALOOKHOR_CC_URL.'assets/css/frontend-hero.css',[],ALOOKHOR_CC_BUILD);
    wp_enqueue_script('alookhor-cc-managed-hero',ALOOKHOR_CC_URL.'assets/js/frontend-hero.js',[],ALOOKHOR_CC_BUILD,true);
    wp_localize_script('alookhor-cc-managed-hero','ALOOKHOR_HERO',[
        'endpoint'=>rest_url('alookhor-cc/v1/hero'),
        'version'=>ALOOKHOR_CC_VERSION,
        'hide_legacy'=>!empty($settings['hide_legacy']),
        'legacy_selector'=>'.alookhor-hero-slider-wrapper',
    ]);
},30);
