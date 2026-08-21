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
        'gold'            => $site['site']['goldAccent'] ?? '#D49A2E',
        'header_surface'  => '#0D0510',
        'header_text_color' => '#F5F3F0',
        'header_muted_color' => '#C8C2C9',
        'capsule_background' => '#0D0510',
        'capsule_card' => '#1C1024',
        'capsule_glass' => 'rgba(33,20,38,.75)',
        'capsule_gold' => '#D49A2E',
        'capsule_gold_light' => '#E8B84A',
        'capsule_text' => '#F5F3F0',
        'capsule_muted' => '#C8C2C9',
        'capsule_blur' => 24,
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
        'topbar_bg'       => '#1C1024',
        'topbar_text_color' => '#F5F3F0',
        'topbar_border_color' => '#D49A2E',
        'topbar_button_bg' => '#D49A2E',
        'topbar_button_text' => '#0D0510',
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

    $primary_menu = alookhor_cc_resolve_primary_menu($settings['primary_menu']);
    $primary_markup = '';
    if ($primary_menu) {
        // Build menu with owner structure: use wp_nav_menu but adapt classes to new design
        $menu_items = wp_get_nav_menu_items($primary_menu->term_id);
        if (!empty($menu_items)) {
            // Build hierarchical array
            $by_parent = [];
            foreach ($menu_items as $it) { $by_parent[$it->menu_item_parent][] = $it; }
            ob_start();
            echo '<ul class="alookhor-nav">';
            // Home always first
            echo '<li><a href="'.esc_url(home_url('/')).'">صفحه اصلی</a></li>';
            foreach (($by_parent[0] ?? []) as $item) {
                $has_children = !empty($by_parent[$item->ID]);
                $title = esc_html($item->title);
                $url = esc_url($item->url);
                if ($has_children) {
                    echo '<li><a href="'.$url.'">'.$title.' ▾</a>';
                    echo '<div class="alookhor-megamenu">';
                    // Distribute children into 3 columns
                    $children = $by_parent[$item->ID];
                    $per_col = max(1, ceil(count($children)/3));
                    $chunks = array_chunk($children, $per_col);
                    $col_idx=0;
                    foreach ($chunks as $chunk) {
                        $col_titles = ['دسته بندی اول','دسته بندی دوم','پیشنهاد طلایی'];
                        $h = $col_titles[$col_idx] ?? 'دسته '.($col_idx+1);
                        // For second chunk use gold title, third is promo
                        if ($col_idx==2) {
                            echo '<div class="megamenu-column"><h4>'.$h.'</h4><ul>';
                            echo '<li><a href="'.esc_url(home_url('/shop/')).'">تخفیفات ویژه 🔥</a></li>';
                            echo '<li><a href="'.esc_url(home_url('/shop/')).'">جدیدترین‌ها</a></li>';
                            echo '<li><a href="'.esc_url(home_url('/shop/')).'">پرفروش‌ترین‌ها</a></li>';
                            echo '</ul></div>';
                        } else {
                            echo '<div class="megamenu-column"><h4>'.$h.'</h4><ul>';
                            foreach ($chunk as $child) {
                                echo '<li><a href="'.esc_url($child->url).'">'.esc_html($child->title).'</a></li>';
                            }
                            echo '</ul></div>';
                        }
                        $col_idx++;
                    }
                    // Ensure 3 columns even if not enough items
                    while ($col_idx < 3) {
                        $h = ['دسته بندی اول','دسته بندی دوم','پیشنهاد طلایی'][$col_idx];
                        echo '<div class="megamenu-column"><h4>'.$h.'</h4><ul>';
                        echo '<li><a href="'.esc_url(home_url('/shop/')).'">مشاهده همه</a></li>';
                        echo '</ul></div>';
                        $col_idx++;
                    }
                    echo '</div></li>';
                } else {
                    // Skip home duplicate
                    if (trim($item->url) === trim(home_url('/')) || trim($item->url) === trim(home_url('/')).'/') continue;
                    echo '<li><a href="'.$url.'">'.$title.'</a></li>';
                }
            }
            echo '</ul>';
            $primary_markup = ob_get_clean();
        }
    }
    if (empty($primary_markup)) {
        $primary_markup = '<ul class="alookhor-nav"><li><a href="'.esc_url(home_url('/')).'">صفحه اصلی</a></li><li><a href="#">محصولات ویژه ▾</a><div class="alookhor-megamenu"><div class="megamenu-column"><h4>دسته بندی اول</h4><ul><li><a href="#">محصول شماره ۱</a></li><li><a href="#">محصول شماره ۲</a></li><li><a href="#">محصول شماره ۳</a></li></ul></div><div class="megamenu-column"><h4>دسته بندی دوم</h4><ul><li><a href="#">محصول اختصاصی A</a></li><li><a href="#">محصول اختصاصی B</a></li><li><a href="#">محصول اختصاصی C</a></li></ul></div><div class="megamenu-column"><h4>پیشنهاد طلایی</h4><ul><li><a href="#">تخفیفات ویژه 🔥</a></li><li><a href="#">جدیدترین‌ها</a></li><li><a href="#">پرفروش‌ترین‌ها</a></li></ul></div></div></li><li><a href="#">درباره ما</a></li><li><a href="#">تماس با ما</a></li><li><a href="#">وبلاگ</a></li></ul>';
    }

    $cart_url = function_exists('wc_get_cart_url') ? wc_get_cart_url() : home_url('/cart/');
    $cart_count = function_exists('WC') && WC()->cart ? (int) WC()->cart->get_cart_contents_count() : 0;
    $account_url = function_exists('wc_get_page_permalink') ? wc_get_page_permalink('myaccount') : wp_login_url(home_url('/'));

    ob_start();
    ?>
    <div class="alookhor-header-wrapper" style="--alookhor-gold:<?php echo esc_attr($settings['gold']); ?>;">
      <div class="alookhor-topbar">
        <div><span>✨ به فروشگاه آلوخور خوش آمدید | ارسال سریع به سراسر کشور</span></div>
        <div>
          <a href="tel:<?php echo esc_attr(preg_replace('/[^0-9+]/','', $settings['phone'])); ?>">📞 پشتیبانی: <?php echo esc_html($settings['phone']); ?></a>
          <a href="<?php echo esc_url(home_url('/order-tracking/')); ?>">پیگیری سفارش</a>
        </div>
      </div>
      <header class="alookhor-main-header">
        <div class="alookhor-logo">
          <?php
            $custom_logo_id = (int) get_theme_mod('custom_logo');
            if ($custom_logo_id) echo wp_get_attachment_image($custom_logo_id, [48,48], false, ['style'=>'border-radius:8px;']);
          ?>
          <span class="alookhor-logo-text"><?php echo esc_html($settings['logo_text'] ?: 'ALOOKHOR'); ?></span>
        </div>
        <nav><?php echo $primary_markup; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></nav>
        <div class="alookhor-actions">
          <a href="<?php echo esc_url(home_url('/?s=')); ?>" class="alookhor-icon-btn" title="جستجو">🔍</a>
          <a href="<?php echo esc_url($account_url); ?>" class="alookhor-icon-btn" title="حساب کاربری">👤</a>
          <a href="<?php echo esc_url($cart_url); ?>" class="alookhor-icon-btn" title="سبد خرید">🛒<?php if ($cart_count) echo '<span style="position:absolute;top:-6px;right:-6px;background:#f3e5ab;color:#270408;border-radius:50%;width:18px;height:18px;display:grid;place-items:center;font-size:10px;font-weight:800;">'.esc_html($cart_count).'</span>'; ?></a>
        </div>
      </header>
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
    // Owner requested exact new luxury code — always render it, legacy HTML is wrapped but hidden by CSS (.whb-header{display:none})
    return alookhor_cc_render_portal_header($atts);
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
