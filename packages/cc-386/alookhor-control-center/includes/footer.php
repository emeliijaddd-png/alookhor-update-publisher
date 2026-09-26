<?php
/**
 * Managed luxury footer for ALOOKHOR.
 * Replaces the rendered legacy footer without editing Elementor/Code Snippets.
 */
if (!defined('ABSPATH')) exit;

function alookhor_cc_footer_defaults(){
    return [
        'enabled' => true,
        'hide_legacy' => true,
        'hide_old_newsletter' => true,
        'use_header_contact' => true,
        'logo_url' => content_url('/uploads/2026/08/LOGO2.png'),
        'logo_alt' => 'لوگوی رسمی آلوخور',
        'brand_name' => 'ALOOKHOR',
        'brand_subtitle' => 'PREMIUM PERSIAN DRIED PLUMS',
        'brand_kicker' => 'From Iranian Orchards to the World',
        'brand_description' => 'تأمین‌کننده مستقیم آلو خشک نیشابور با کیفیت ممتاز برای بازارهای داخلی و بین‌المللی',
        'cta_text' => 'درخواست قیمت عمده و صادراتی',
        'cta_url' => home_url('/#b2b'),
        'phone' => '',
        'email' => '',
        'whatsapp' => '',
        'address' => 'خراسان رضوی، خور نیشابور',
        'support_label' => 'تلفن پشتیبانی و سفارش عمده',
        'hours_week' => 'شنبه تا پنجشنبه: ۸ الی ۲۰',
        'hours_friday' => 'جمعه‌ها: ۹ الی ۱۴',
        'customer_title' => 'خدمات مشتریان',
        'customer_menu_id' => 0,
        'customer_links' => [
            ['title'=>'پرسش‌های متداول','url'=>home_url('/#faq')],
            ['title'=>'رویه‌های بازگرداندن کالا','url'=>home_url('/#returns')],
            ['title'=>'شرایط استفاده','url'=>home_url('/#terms')],
            ['title'=>'حریم خصوصی','url'=>home_url('/#privacy')],
            ['title'=>'گزارش مشکل','url'=>home_url('/#bug-report')],
        ],
        'order_title' => 'خرید و سفارش',
        'order_menu_id' => 0,
        'order_links' => [
            ['title'=>'نحوه ثبت سفارش','url'=>home_url('/#how-to-order')],
            ['title'=>'روش‌های پرداخت','url'=>home_url('/#payment-methods')],
            ['title'=>'روش‌های ارسال','url'=>home_url('/#shipping-policy')],
            ['title'=>'پیگیری سفارش','url'=>home_url('/my-account/orders/')],
            ['title'=>'سفارش عمده و صادراتی','url'=>home_url('/#b2b')],
        ],
        'about_title' => 'درباره آلوخور',
        'about_mobile_title' => 'راهنمای صادراتی',
        'about_menu_id' => 0,
        'about_links' => [
            ['title'=>'درباره ما','url'=>home_url('/درباره-ما/')],
            ['title'=>'فرآیند تولید','url'=>home_url('/#production')],
            ['title'=>'کشت و استانداردها','url'=>home_url('/#standards')],
            ['title'=>'چرا آلوخور؟','url'=>home_url('/#why-alookhor')],
            ['title'=>'مجوزها و افتخارات','url'=>home_url('/#licenses')],
            ['title'=>'تماس با ما','url'=>home_url('/تماس-با-ما/')],
        ],
        'instagram_url' => home_url('/#instagram'),
        'telegram_url' => home_url('/#telegram'),
        'whatsapp_url' => '',
        'social_title' => 'آلوخور را دنبال کنید',
        'social_desc' => 'آخرین محصولات، قیمت‌ها و اخبار صادراتی',
        'newsletter_enabled' => true,
        'newsletter_title' => 'عضویت در خبرنامه',
        'newsletter_desc' => 'برای دریافت آخرین محصولات، قیمت‌ها و تخفیف‌های ویژه عضو شوید.',
        'newsletter_placeholder' => 'ایمیل شما',
        'newsletter_button' => 'عضویت',
        'product_image_url' => ALOOKHOR_CC_URL . 'assets/images/footer-prunes.png',
        'enamad_title' => 'Enamad',
        'enamad_image_url' => '',
        'enamad_url' => '',
        'samandehi_title' => 'ساماندهی',
        'samandehi_image_url' => '',
        'samandehi_url' => '',
        'licenses_title' => 'مجوزها و نمادهای اعتماد',
        'licenses_desc' => 'خرید امن و قابل اعتماد',
        'payments_title' => 'روش‌های پرداخت امن',
        'copyright_text' => 'تمامی حقوق محفوظ است.',
        'copyright_en' => 'Premium Persian Dried Plums Exporter',
        'benefits' => [
            ['title'=>'تأمین مستقیم از باغداران','desc'=>'حمایت از کشاورزان ایرانی','icon'=>'leaf'],
            ['title'=>'قیمت‌های رقابتی','desc'=>'مستقیم از تولیدکننده','icon'=>'tag'],
            ['title'=>'ارسال سریع بین‌المللی','desc'=>'به بیش از ۲۰ کشور جهان','icon'=>'plane'],
            ['title'=>'بسته‌بندی استاندارد صادراتی','desc'=>'محافظت کامل از محصول','icon'=>'box'],
            ['title'=>'گارانتی کیفیت','desc'=>'بازگشت وجه در صورت عدم رضایت','icon'=>'shield'],
        ],
        'background' => '#070809',
        'surface' => '#0D0F10',
        'gold' => '#C89A3D',
        'gold_soft' => '#E3BD69',
        'text' => '#E9E5DF',
        'muted' => '#A7A39D',
        'border' => '#4A3820',
        'container_width' => 1280,
        'desktop_logo_width' => 210,
        'mobile_logo_width' => 190,
        'show_payments' => true,
        'show_benefits' => true,
        'show_product_image' => true,
    ];
}

function alookhor_cc_get_footer_settings(){
    $main = alookhor_cc_get_settings();
    $saved = is_array($main['footer_settings'] ?? null) ? $main['footer_settings'] : [];
    $settings = array_replace_recursive(alookhor_cc_footer_defaults(), $saved);
    if (!empty($settings['use_header_contact'])) {
        $header = alookhor_cc_front_header_settings();
        $settings['phone'] = $header['phone'] ?? $settings['phone'];
        $settings['email'] = $header['email'] ?? $settings['email'];
        $settings['whatsapp'] = $header['whatsapp'] ?? $settings['whatsapp'];
        if (empty($settings['whatsapp_url']) && (!empty($settings['whatsapp']) || !empty($settings['phone']))) {
            $number = preg_replace('/\D+/', '', (string) (!empty($settings['whatsapp']) ? $settings['whatsapp'] : $settings['phone']));
            if (strpos($number, '0') === 0) $number = '98' . substr($number, 1);
            $settings['whatsapp_url'] = $number ? 'https://wa.me/' . $number : '';
        }
    }
    if (empty($settings['logo_url'])) {
        $logo_id = (int) get_theme_mod('custom_logo');
        if ($logo_id) $settings['logo_url'] = wp_get_attachment_image_url($logo_id, 'large') ?: '';
        if (empty($settings['logo_url'])) $settings['logo_url'] = get_site_icon_url(256);
    }
    return apply_filters('alookhor_cc_footer_settings', $settings);
}

function alookhor_cc_footer_icon($name){
    $icons = [
        'phone'=>'<path d="M22 16.92v3a2 2 0 0 1-2.18 2A19.8 19.8 0 0 1 3.1 5.18 2 2 0 0 1 5.09 3h3a2 2 0 0 1 2 1.72c.12.9.33 1.79.62 2.64a2 2 0 0 1-.45 2.11L9 10.74a16 16 0 0 0 4.26 4.26l1.27-1.27a2 2 0 0 1 2.11-.45c.85.29 1.74.5 2.64.62A2 2 0 0 1 22 16.92Z"/>',
        'mail'=>'<rect x="3" y="5" width="18" height="14" rx="2"/><path d="m3 7 9 6 9-6"/>',
        'pin'=>'<path d="M20 10c0 5-8 12-8 12S4 15 4 10a8 8 0 1 1 16 0Z"/><circle cx="12" cy="10" r="2.5"/>',
        'clock'=>'<circle cx="12" cy="12" r="9"/><path d="M12 7v5l3 2"/>',
        'headset'=>'<path d="M4 14v-2a8 8 0 0 1 16 0v2"/><path d="M4 14h3v6H5a1 1 0 0 1-1-1v-5Zm16 0h-3v6h2a1 1 0 0 0 1-1v-5Z"/>',
        'bag'=>'<path d="M5 8h14l-1 13H6L5 8Z"/><path d="M9 8a3 3 0 0 1 6 0"/>',
        'globe'=>'<circle cx="12" cy="12" r="9"/><path d="M3 12h18M12 3c3 3 4 6 4 9s-1 6-4 9c-3-3-4-6-4-9s1-6 4-9Z"/>',
        'shield'=>'<path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10Z"/><path d="m9 12 2 2 4-5"/>',
        'box'=>'<path d="m3 7 9-4 9 4-9 4-9-4Z"/><path d="m3 7 9 4v10l-9-4V7Zm18 0-9 4v10l9-4V7Z"/>',
        'leaf'=>'<path d="M20 4C12 4 6 8 6 15c0 3 2 5 5 5 7 0 9-8 9-16Z"/><path d="M4 21c3-6 7-9 13-13"/>',
        'tag'=>'<path d="M20 13 13 20 4 11V4h7l9 9Z"/><circle cx="8.5" cy="8.5" r="1.2"/>',
        'plane'=>'<path d="m22 2-7 20-4-9-9-4 20-7Z"/><path d="m22 2-11 11"/>',
        'instagram'=>'<rect x="3" y="3" width="18" height="18" rx="5"/><circle cx="12" cy="12" r="4"/><circle cx="17.5" cy="6.5" r="1"/>',
        'telegram'=>'<path d="m22 2-7 20-4-9-9-4 20-7Z"/><path d="m22 2-11 11"/>',
        'whatsapp'=>'<path d="M20 11.5a8 8 0 0 1-11.8 7L3 20l1.5-5.1A8 8 0 1 1 20 11.5Z"/><path d="M9 8c.5 3 2 4.5 5 5"/>',
    ];
    return '<svg viewBox="0 0 24 24" aria-hidden="true">' . ($icons[$name] ?? $icons['shield']) . '</svg>';
}

function alookhor_cc_footer_links($settings, $key){
    $menu_id = absint($settings[$key . '_menu_id'] ?? 0);
    if ($menu_id) {
        $menu = wp_nav_menu(['menu'=>$menu_id,'container'=>false,'menu_class'=>'alookhor-mf-links','depth'=>1,'fallback_cb'=>false,'echo'=>false]);
        if ($menu) return $menu;
    }
    $links = is_array($settings[$key . '_links'] ?? null) ? $settings[$key . '_links'] : [];
    $html = '<ul class="alookhor-mf-links">';
    foreach ($links as $link) {
        if (!is_array($link) || empty($link['title'])) continue;
        $html .= '<li><a href="' . esc_url($link['url'] ?? '#') . '"><span>' . esc_html($link['title']) . '</span></a></li>';
    }
    return $html . '</ul>';
}

function alookhor_cc_footer_badge($title, $image, $url, $fallback){
    $content = $image
        ? '<img src="' . esc_url($image) . '" alt="' . esc_attr($title) . '">'
        : '<span class="alookhor-mf-badge-fallback">' . esc_html($fallback) . '</span>';
    $inner = '<span class="alookhor-mf-badge-media">' . $content . '</span><span>' . esc_html($title) . '</span>';
    return $url ? '<a class="alookhor-mf-badge" href="' . esc_url($url) . '" target="_blank" rel="noopener">' . $inner . '</a>' : '<span class="alookhor-mf-badge">' . $inner . '</span>';
}

function alookhor_cc_footer_markup($settings = null){
    $s = is_array($settings) ? $settings : alookhor_cc_get_footer_settings();
    if (empty($s['enabled'])) return '';
    $phone_href = preg_replace('/[^0-9+]/', '', (string) $s['phone']);
    $year = wp_date('Y');
    $style = sprintf(
        '--mf-bg:%s;--mf-surface:%s;--mf-gold:%s;--mf-gold-soft:%s;--mf-text:%s;--mf-muted:%s;--mf-border:%s;--mf-width:%dpx;--mf-logo:%dpx;--mf-logo-mobile:%dpx',
        sanitize_hex_color($s['background']) ?: '#070809', sanitize_hex_color($s['surface']) ?: '#0D0F10',
        sanitize_hex_color($s['gold']) ?: '#C89A3D', sanitize_hex_color($s['gold_soft']) ?: '#E3BD69',
        sanitize_hex_color($s['text']) ?: '#E9E5DF', sanitize_hex_color($s['muted']) ?: '#A7A39D',
        sanitize_hex_color($s['border']) ?: '#4A3820', max(960,min(1600,absint($s['container_width']))),
        max(100,min(320,absint($s['desktop_logo_width']))), max(100,min(280,absint($s['mobile_logo_width'])))
    );
    ob_start(); ?>
    <footer id="alookhor-managed-footer" class="alookhor-mf" dir="rtl" style="<?php echo esc_attr($style); ?>" data-version="<?php echo esc_attr(ALOOKHOR_CC_VERSION); ?>">
      <div class="alookhor-mf-shell">
        <div class="alookhor-mf-main-grid">
          <section class="alookhor-mf-brand" aria-label="معرفی آلوخور">
            <?php if (!empty($s['logo_url'])): ?><a class="alookhor-mf-logo" href="<?php echo esc_url(home_url('/')); ?>"><img src="<?php echo esc_url($s['logo_url']); ?>" alt="<?php echo esc_attr($s['logo_alt']); ?>"></a><?php endif; ?>
            <strong class="alookhor-mf-brand-name"><?php echo esc_html($s['brand_name']); ?></strong>
            <span class="alookhor-mf-brand-sub"><?php echo esc_html($s['brand_subtitle']); ?></span>
            <span class="alookhor-mf-kicker"><?php echo esc_html($s['brand_kicker']); ?></span>
            <p><?php echo esc_html($s['brand_description']); ?></p>
            <div class="alookhor-mf-brand-trust">
              <span><?php echo alookhor_cc_footer_icon('shield'); ?><b>کیفیت تضمین‌شده</b><small>و استانداردها</small></span>
              <span><?php echo alookhor_cc_footer_icon('box'); ?><b>بسته‌بندی صادراتی</b><small>ایمن و حرفه‌ای</small></span>
              <span><?php echo alookhor_cc_footer_icon('globe'); ?><b>ارسال بین‌المللی</b><small>سریع و مطمئن</small></span>
              <span><?php echo alookhor_cc_footer_icon('leaf'); ?><b>محصول مستقیم</b><small>از باغداران</small></span>
            </div>
            <a class="alookhor-mf-cta" href="<?php echo esc_url($s['cta_url']); ?>"><?php echo alookhor_cc_footer_icon('headset'); ?><span><?php echo esc_html($s['cta_text']); ?></span></a>
          </section>

          <section class="alookhor-mf-menu-card alookhor-mf-customer"><h3><?php echo alookhor_cc_footer_icon('headset'); ?><span><?php echo esc_html($s['customer_title']); ?></span></h3><?php echo wp_kses_post(alookhor_cc_footer_links($s,'customer')); ?></section>
          <section class="alookhor-mf-menu-card alookhor-mf-order"><h3><?php echo alookhor_cc_footer_icon('bag'); ?><span><?php echo esc_html($s['order_title']); ?></span></h3><?php echo wp_kses_post(alookhor_cc_footer_links($s,'order')); ?></section>
          <section class="alookhor-mf-menu-card alookhor-mf-about"><h3><?php echo alookhor_cc_footer_icon('globe'); ?><span class="alookhor-mf-about-desktop"><?php echo esc_html($s['about_title']); ?></span><span class="alookhor-mf-about-mobile"><?php echo esc_html($s['about_mobile_title']); ?></span></h3><?php echo wp_kses_post(alookhor_cc_footer_links($s,'about')); ?></section>

          <section class="alookhor-mf-contact"><h3><?php echo alookhor_cc_footer_icon('phone'); ?><span>اطلاعات تماس</span></h3>
            <div class="alookhor-mf-contact-list">
              <a href="tel:<?php echo esc_attr($phone_href); ?>"><i><?php echo alookhor_cc_footer_icon('phone'); ?></i><span><small><?php echo esc_html($s['support_label']); ?></small><b dir="ltr"><?php echo esc_html($s['phone']); ?></b></span></a>
              <a href="mailto:<?php echo esc_attr($s['email']); ?>"><i><?php echo alookhor_cc_footer_icon('mail'); ?></i><span><small>ایمیل</small><b dir="ltr"><?php echo esc_html($s['email']); ?></b></span></a>
              <div><i><?php echo alookhor_cc_footer_icon('pin'); ?></i><span><small>آدرس</small><b><?php echo esc_html($s['address']); ?></b></span></div>
              <div><i><?php echo alookhor_cc_footer_icon('clock'); ?></i><span><small>ساعات پاسخ‌گویی</small><b><?php echo esc_html($s['hours_week']); ?><br><?php echo esc_html($s['hours_friday']); ?></b></span></div>
            </div>
            <a class="alookhor-mf-contact-cta" href="<?php echo esc_url($s['cta_url']); ?>"><?php echo alookhor_cc_footer_icon('headset'); ?><span>مشاوره رایگان سفارش عمده</span></a>
          </section>

          <section class="alookhor-mf-license-card"><h3><?php echo alookhor_cc_footer_icon('shield'); ?><span><?php echo esc_html($s['licenses_title']); ?></span></h3><div class="alookhor-mf-badges"><?php echo alookhor_cc_footer_badge($s['enamad_title'],$s['enamad_image_url'],$s['enamad_url'],'e'); ?><?php echo alookhor_cc_footer_badge($s['samandehi_title'],$s['samandehi_image_url'],$s['samandehi_url'],'۲'); ?></div><p><?php echo esc_html($s['licenses_desc']); ?></p></section>
        </div>

        <section class="alookhor-mf-news-social">
          <div class="alookhor-mf-social"><h3><?php echo esc_html($s['social_title']); ?></h3><p><?php echo esc_html($s['social_desc']); ?></p><div>
            <?php foreach ([['instagram','instagram_url','اینستاگرام'],['telegram','telegram_url','تلگرام'],['whatsapp','whatsapp_url','واتساپ']] as $social): if (empty($s[$social[1]])) continue; ?><a href="<?php echo esc_url($s[$social[1]]); ?>" target="_blank" rel="noopener" aria-label="<?php echo esc_attr($social[2]); ?>"><?php echo alookhor_cc_footer_icon($social[0]); ?></a><?php endforeach; ?>
          </div></div>
          <?php if (!empty($s['newsletter_enabled'])): ?><div class="alookhor-mf-newsletter"><h3><?php echo esc_html($s['newsletter_title']); ?></h3><p><?php echo esc_html($s['newsletter_desc']); ?></p><form class="alookhor-mf-newsletter-form"><input type="email" name="email" placeholder="<?php echo esc_attr($s['newsletter_placeholder']); ?>" required><input type="text" name="company" tabindex="-1" autocomplete="off" class="alookhor-mf-hp"><button type="submit"><?php echo esc_html($s['newsletter_button']); ?></button></form><small class="alookhor-mf-form-msg" aria-live="polite"></small></div><?php endif; ?>
          <?php if (!empty($s['show_product_image']) && !empty($s['product_image_url'])): ?><img class="alookhor-mf-product" src="<?php echo esc_url($s['product_image_url']); ?>" alt="آلو خشک ممتاز آلوخور" loading="lazy"><?php endif; ?>
        </section>

        <section class="alookhor-mf-assurance">
          <div class="alookhor-mf-license-desktop"><h4><?php echo esc_html($s['licenses_title']); ?></h4><div class="alookhor-mf-badges"><?php echo alookhor_cc_footer_badge($s['enamad_title'],$s['enamad_image_url'],$s['enamad_url'],'e'); ?><?php echo alookhor_cc_footer_badge($s['samandehi_title'],$s['samandehi_image_url'],$s['samandehi_url'],'۲'); ?></div></div>
          <?php if (!empty($s['show_payments'])): ?><div class="alookhor-mf-payments"><h4><?php echo esc_html($s['payments_title']); ?></h4><div><span>VISA</span><span>●●</span><span>زرین‌پال</span><span>شتاب</span></div></div><?php endif; ?>
          <div class="alookhor-mf-copy"><b><?php echo esc_html($s['copyright_text']); ?></b><span>© <?php echo esc_html($year); ?> ALOOKHOR</span><small><?php echo esc_html($s['copyright_en']); ?></small></div>
        </section>

        <?php if (!empty($s['show_benefits'])): ?><section class="alookhor-mf-benefits"><?php foreach ((array)$s['benefits'] as $benefit): if (!is_array($benefit)) continue; ?><span><?php echo alookhor_cc_footer_icon($benefit['icon'] ?? 'shield'); ?><b><?php echo esc_html($benefit['title'] ?? ''); ?></b><small><?php echo esc_html($benefit['desc'] ?? ''); ?></small></span><?php endforeach; ?></section><?php endif; ?>
      </div>
    </footer>
    <?php return ob_get_clean();
}

function alookhor_cc_render_managed_footer(){
    static $rendered = false;
    if ($rendered || is_admin() || wp_doing_ajax()) return;
    $settings = alookhor_cc_get_footer_settings();
    if (empty($settings['enabled'])) return;
    $rendered = true;
    echo alookhor_cc_footer_markup($settings); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
}
add_action('get_footer', 'alookhor_cc_render_managed_footer', 1);
add_action('wp_footer', 'alookhor_cc_render_managed_footer', 1);
add_filter('body_class', function($classes){
    $settings = alookhor_cc_get_footer_settings();
    if (!empty($settings['enabled'])) $classes[]='alookhor-mf-enabled';
    if (!empty($settings['enabled']) && !empty($settings['hide_legacy'])) $classes[]='alookhor-mf-hide-legacy';
    if (!empty($settings['enabled']) && !empty($settings['hide_old_newsletter'])) $classes[]='alookhor-mf-hide-old-sections';
    return array_values(array_unique($classes));
});

add_action('wp_enqueue_scripts', function(){
    $settings = alookhor_cc_get_footer_settings();
    if (empty($settings['enabled'])) return;
    wp_enqueue_style('alookhor-cc-managed-footer', ALOOKHOR_CC_URL . 'assets/css/frontend-footer.css', [], ALOOKHOR_CC_BUILD);
    wp_enqueue_script('alookhor-cc-managed-footer', ALOOKHOR_CC_URL . 'assets/js/frontend-footer.js', [], ALOOKHOR_CC_BUILD, true);
    wp_localize_script('alookhor-cc-managed-footer', 'ALOOKHOR_FOOTER', [
        'endpoint' => rest_url('alookhor-cc/v1/footer'),
        'subscribe_endpoint' => rest_url('alookhor-cc/v1/footer-subscribe'),
        'version' => ALOOKHOR_CC_VERSION,
        'hide_legacy' => !empty($settings['hide_legacy']),
        'hide_old_newsletter' => !empty($settings['hide_old_newsletter']),
    ]);
}, 30);
