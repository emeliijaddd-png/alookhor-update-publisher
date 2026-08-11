<?php
if (!defined('ABSPATH')) exit;

// ——— منوی مدیریت ———
add_action('admin_menu', function(){
    add_menu_page(
        'ALOOKHOR Control Center',
        'ALOOKHOR Center',
        'manage_options',
        'alookhor-control-center',
        'alookhor_cc_render_admin',
        'dashicons-star-filled', // آیکن لوکس
        2
    );
    add_submenu_page('alookhor-control-center', 'داشبورد', 'داشبورد', 'manage_options', 'alookhor-control-center', 'alookhor_cc_render_admin');
    add_submenu_page('alookhor-control-center', 'نوار بالای سایت و هدر', 'نوار بالای سایت و هدر', 'manage_options', 'alookhor-cc-header', 'alookhor_cc_render_header_settings');
});

// ——— لود استایل/اسکریپت فقط در صفحه کنترل سنتر ———
add_action('admin_enqueue_scripts', function($hook){
    if(strpos($hook, 'alookhor') === false) return;
    wp_enqueue_media();
    wp_enqueue_style('alookhor-cc-luxury', ALOOKHOR_CC_URL . 'assets/css/luxury.css', [], ALOOKHOR_CC_BUILD);
    wp_enqueue_style('alookhor-cc-admin', ALOOKHOR_CC_URL . 'assets/css/luxury.css', [], ALOOKHOR_CC_BUILD);
    // فونت لوکس
    wp_enqueue_style('alookhor-cc-fonts', 'https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@500;600;700&family=Inter:wght@400;500;600;700&display=swap', [], null);

    // NOTE: config.js is ES Module — DO NOT enqueue as regular script (caused SyntaxError: Unexpected token 'export')
    // It is imported via app.js as module: import { Config } from './core/config.js'
    // نصب از URL nonceدار Core Upgrader انجام می‌شود؛ مستقل از DOM صفحه Plugins.
    // admin-wp.js remains the bridge; app.js and its dependencies stay ES Modules.
    wp_enqueue_script('alookhor-cc-admin-js', ALOOKHOR_CC_URL . 'assets/js/admin-wp.js', ['jquery'], ALOOKHOR_CC_BUILD, true);
    wp_localize_script('alookhor-cc-admin-js', 'ALOOKHOR_CC', [
        'ajax_url' => admin_url('admin-ajax.php'),
        'nonce' => wp_create_nonce('alookhor_cc_nonce'),
        'site_json_url' => ALOOKHOR_CC_URL . 'config/site.json',
        'version' => ALOOKHOR_CC_VERSION,
        'plugin_file' => ALOOKHOR_CC_PLUGIN_BASENAME,
        'plugin_slug' => 'alookhor-control-center',
        'native_update_url' => wp_nonce_url(
            self_admin_url('update.php?action=upgrade-plugin&plugin=' . rawurlencode(ALOOKHOR_CC_PLUGIN_BASENAME)),
            'upgrade-plugin_' . ALOOKHOR_CC_PLUGIN_BASENAME
        ),
        'updater_configured' => (bool) alookhor_cc_update_manifest_url(),
        'header_shortcode' => '[alookhor_portal_header]',
    ]);
});

// ——— رندر صفحه اصلی کنترل سنتر ———
function alookhor_cc_render_admin(){
    // چک دسترسی
    if(!current_user_can('manage_options')) return;
    $settings = alookhor_cc_get_settings();
    $header = alookhor_cc_get_header_settings();
    // یک صفحه فول‌اسکرین لوکس
    ?>
    <div class="wrap" style="margin:0; padding:0; background:#070708; margin-left:-20px; margin-top:-10px;">
        <style>
            #wpcontent{padding-left:0 !important; background:#070708}
            #wpfooter{display:none}
            .alookhor-wp-topbar{position:sticky; top:32px; z-index:10; background: linear-gradient(180deg, rgba(17,17,19,0.96), rgba(17,17,19,0.88)); border-bottom:1px solid rgba(201,168,106,0.14); backdrop-filter: blur(12px); padding:10px 20px; display:flex; align-items:center; gap:12px; color:#F5F1E9}
            @media(max-width:782px){.alookhor-wp-topbar{top:46px}}
            .alookhor-wp-topbar .dot{width:8px; height:8px; border-radius:50%; background:#3DD68C; box-shadow:0 0 0 4px rgba(61,214,140,0.15)}
        </style>
        <div class="alookhor-wp-topbar">
            <span class="dot"></span>
            <b style="letter-spacing:.06em; font-family:'Cormorant Garamond',serif">ALOOKHOR Control Center</b>
            <span style="opacity:.5">•</span>
            <span style="font-size:12px; color:#9A9590">v<?php echo esc_html(ALOOKHOR_CC_VERSION); ?> — نصب شده و فعال</span>
            <span style="margin-left:auto; display:flex; gap:8px; align-items:center">
                <code dir="ltr" style="background:rgba(255,255,255,0.06); border:1px solid rgba(201,168,106,0.14); padding:4px 8px; border-radius:8px; color:#E8D5B5; font-size:11px">[alookhor_portal_header]</code>
                <span style="font-size:11px; color:#9A9590">هدر المنتوری شما</span>
                <a href="<?php echo esc_url(home_url('/')); ?>" target="_blank" style="background:linear-gradient(135deg,#C9A86A,#B8935A); color:#1A1206; padding:7px 12px; border-radius:999px; font-weight:700; font-size:12px; text-decoration:none">نمایش سایت</a>
            </span>
        </div>
        <?php
        // لود قالب کنترل سنتر (همون index.html اما با مسیرهای وردپرسی)
        $template = ALOOKHOR_CC_DIR . 'templates/admin-control-center.php';
        if(file_exists($template)) include $template;
        else echo '<div style="padding:40px; color:#fff">Template not found</div>';
        ?>
    </div>
    <?php
}

function alookhor_cc_render_header_settings(){
    $h = alookhor_cc_get_header_settings();
    ?>
    <div class="wrap" style="background:#070708; margin-left:-20px; padding:24px; color:#F5F1E9">
        <h1 style="color:#E8D5B5; font-family:'Cormorant Garamond',serif">مدیریت نوار بالای سایت و هدر</h1>
        <p style="color:#9A9590">تمام گزینه‌های Top Bar و هدر حرفه‌ای شورت‌کد [alookhor_portal_header] — بدون نیاز به ویرایش Elementor یا Code Snippets.</p>
        <?php $menus = wp_get_nav_menus(['orderby' => 'term_order']); ?>
        <form id="alookhorHeaderForm" style="max-width:900px; background:rgba(255,255,255,0.03); border:1px solid rgba(201,168,106,0.14); border-radius:18px; padding:20px; display:grid; gap:16px">
            <?php wp_nonce_field('alookhor_cc_nonce','nonce'); ?>
            <section class="alookhor-settings-section">
                <div class="alookhor-section-head"><div><b>نوار بالای سایت (Top Bar)</b><span>تمام متن‌ها، لینک‌ها و آیتم‌های قابل‌مشاهده</span></div><em>LIVE OPTIONS</em></div>
                <div class="alookhor-fields-grid">
                    <label>شماره تلفن <input name="phone" value="<?php echo esc_attr($h['phone']); ?>" class="alookhor-field" dir="ltr"></label>
                    <label>ایمیل <input type="email" name="email" value="<?php echo esc_attr($h['email']); ?>" class="alookhor-field" dir="ltr"></label>
                    <label>شماره WhatsApp <input name="whatsapp" value="<?php echo esc_attr($h['whatsapp']); ?>" class="alookhor-field" dir="ltr"></label>
                    <label>متن صادرات <input name="export_text" value="<?php echo esc_attr($h['export_text']); ?>" class="alookhor-field"></label>
                    <label>لینک متن صادرات <input type="url" name="export_url" value="<?php echo esc_attr($h['export_url']); ?>" class="alookhor-field" dir="ltr" placeholder="اختیاری"></label>
                    <label>متن دکمه خرید عمده <input name="wholesale_text" value="<?php echo esc_attr($h['wholesale_text']); ?>" class="alookhor-field"></label>
                    <label>لینک خرید عمده <input type="url" name="wholesale_url" value="<?php echo esc_attr($h['wholesale_url']); ?>" class="alookhor-field" dir="ltr"></label>
                </div>
            </section>

            <section class="alookhor-settings-section">
                <div class="alookhor-section-head"><div><b>لوگوی مرکزی Top Bar</b><span>انتخاب از کتابخانه رسانه WordPress</span></div><em>MEDIA</em></div>
                <div class="alookhor-fields-grid">
                    <label style="grid-column:span 2">آدرس لوگو
                        <span style="display:flex;gap:8px"><input id="alookhorTopLogoUrl" name="top_logo_url" value="<?php echo esc_attr($h['top_logo_url']); ?>" class="alookhor-field" dir="ltr"><button type="button" id="alookhorSelectTopLogo" class="alookhor-media-btn">انتخاب تصویر</button></span>
                    </label>
                    <label>متن جایگزین لوگو <input name="top_logo_alt" value="<?php echo esc_attr($h['top_logo_alt']); ?>" class="alookhor-field"></label>
                    <label>لینک لوگو <input type="url" name="top_logo_link" value="<?php echo esc_attr($h['top_logo_link']); ?>" class="alookhor-field" dir="ltr"></label>
                    <label>عرض لوگو (50–180px) <input type="number" min="50" max="180" name="top_logo_width" value="<?php echo esc_attr($h['top_logo_width']); ?>" class="alookhor-field"></label>
                </div>
            </section>

            <section class="alookhor-settings-section">
                <div class="alookhor-section-head"><div><b>ظاهر Top Bar</b><span>رنگ، ارتفاع، حاشیه و دکمه CTA</span></div><em>STYLE</em></div>
                <div class="alookhor-color-grid">
                    <?php foreach ([
                        'topbar_bg' => 'پس‌زمینه نوار',
                        'topbar_text_color' => 'رنگ متن',
                        'topbar_border_color' => 'رنگ خط پایین',
                        'topbar_button_bg' => 'رنگ دکمه عمده',
                        'topbar_button_text' => 'متن دکمه عمده',
                        'gold' => 'طلایی اصلی هدر'
                    ] as $color_key => $color_label): ?>
                        <label><?php echo esc_html($color_label); ?><input type="color" name="<?php echo esc_attr($color_key); ?>" value="<?php echo esc_attr($h[$color_key]); ?>" class="alookhor-field alookhor-color-field"></label>
                    <?php endforeach; ?>
                    <label>ارتفاع نوار (30–60px)<input type="number" min="30" max="60" name="topbar_height" value="<?php echo esc_attr($h['topbar_height']); ?>" class="alookhor-field"></label>
                </div>
            </section>

            <section class="alookhor-settings-section">
                <div class="alookhor-section-head"><div><b>هویت و منوی اصلی</b><span>لوگوی اصلی، حساب کاربری و اتصال فهرست‌ها</span></div><em>HEADER</em></div>
                <div class="alookhor-fields-grid">
                    <label>متن لوگو <input name="logo_text" value="<?php echo esc_attr($h['logo_text']); ?>" class="alookhor-field"></label>
                    <label>زیرعنوان <input name="logo_sub" value="<?php echo esc_attr($h['logo_sub']); ?>" class="alookhor-field"></label>
                    <label>حرف لوگو <input name="logo_letter" value="<?php echo esc_attr($h['logo_letter']); ?>" maxlength="2" class="alookhor-field"></label>
                    <label>متن ورود <input name="account_text" value="<?php echo esc_attr($h['account_text']); ?>" class="alookhor-field"></label>
                    <label>فهرست اصلی
                        <select name="primary_menu" class="alookhor-field">
                            <option value="0">تشخیص خودکار از WordPress</option>
                            <?php foreach ($menus as $menu): ?>
                                <option value="<?php echo esc_attr($menu->term_id); ?>" <?php selected((int)$h['primary_menu'], (int)$menu->term_id); ?>><?php echo esc_html($menu->name); ?></option>
                            <?php endforeach; ?>
                        </select>
                    </label>
                </div>
            </section>
            <div style="display:flex;gap:10px;flex-wrap:wrap">
                <?php foreach ([
                    'sticky' => 'هدر Sticky',
                    'show_topbar' => 'نمایش Top Bar',
                    'show_phone' => 'نمایش تلفن',
                    'show_email' => 'نمایش ایمیل',
                    'show_whatsapp' => 'نمایش WhatsApp',
                    'show_export' => 'نمایش متن صادرات',
                    'show_wholesale' => 'نمایش دکمه عمده',
                    'wholesale_new_tab' => 'بازشدن عمده در تب جدید',
                    'show_contact' => 'نمایش گروه تماس',
                    'show_account' => 'نمایش ورود/حساب'
                ] as $key => $label): ?>
                    <label style="display:flex;align-items:center;gap:8px;background:rgba(255,255,255,.035);border:1px solid rgba(201,168,106,.14);border-radius:999px;padding:8px 12px">
                        <input type="hidden" name="<?php echo esc_attr($key); ?>" value="0">
                        <input type="checkbox" name="<?php echo esc_attr($key); ?>" value="1" <?php checked(!empty($h[$key])); ?> style="accent-color:#C9A86A">
                        <?php echo esc_html($label); ?>
                    </label>
                <?php endforeach; ?>
            </div>
            <div style="padding:12px;border:1px dashed rgba(201,168,106,.2);border-radius:12px;color:#B9B0A6;font-size:12px;line-height:1.8">
                فهرست اصلی به‌صورت خودکار از جایگاه Primary/Header وردپرس خوانده می‌شود. منوی Hamburger تمام فهرست‌های ساخته‌شده در «نمایش ← فهرست‌ها» را گروه‌بندی می‌کند.
            </div>
            <button type="submit" style="background:linear-gradient(135deg,#C9A86A,#B8935A); color:#1A1206; border:0; padding:12px; border-radius:999px; font-weight:700; cursor:pointer">ذخیره تنظیمات هدر حرفه‌ای</button>
            <div id="alookhorHeaderMsg" style="font-size:12px; color:#3DD68C; display:none">ذخیره شد ✓</div>
        </form>
        <style>
          #alookhorHeaderForm label{color:#D8D0C7;font-size:12px;display:grid;gap:6px}
          #alookhorHeaderForm .alookhor-field{width:100%;max-width:none;background:rgba(255,255,255,.04);border:1px solid rgba(201,168,106,.18);border-radius:9px;padding:9px 10px;color:#fff}
          #alookhorHeaderForm select.alookhor-field{background:#17131A}
          .alookhor-settings-section{padding:16px;border:1px solid rgba(201,168,106,.13);border-radius:14px;background:rgba(0,0,0,.14);display:grid;gap:14px}
          .alookhor-section-head{display:flex;align-items:center;justify-content:space-between;gap:12px;padding-bottom:11px;border-bottom:1px solid rgba(201,168,106,.1)}
          .alookhor-section-head b{display:block;color:#E8D5B5;font-size:14px}.alookhor-section-head span{display:block;color:#8F8991;font-size:10px;margin-top:4px}.alookhor-section-head em{font:700 9px Arial;color:#C9A86A;border:1px solid rgba(201,168,106,.2);border-radius:999px;padding:4px 7px}
          .alookhor-fields-grid{display:grid;grid-template-columns:repeat(auto-fit,minmax(230px,1fr));gap:13px}.alookhor-color-grid{display:grid;grid-template-columns:repeat(auto-fit,minmax(150px,1fr));gap:12px}
          #alookhorHeaderForm .alookhor-color-field{height:42px;padding:4px}.alookhor-media-btn{white-space:nowrap;border:1px solid rgba(201,168,106,.3);border-radius:9px;background:rgba(201,168,106,.1);color:#E8D5B5;padding:8px 12px;cursor:pointer}
          @media(max-width:782px){.alookhor-fields-grid,.alookhor-color-grid{grid-template-columns:1fr}.alookhor-fields-grid label[style*="span 2"]{grid-column:auto!important}}
        </style>
        <p style="margin-top:14px; font-size:12px; color:#9A9590">شورت‌کد در المنتور: <code dir="ltr" style="background:#111113; border:1px solid rgba(201,168,106,0.14); padding:4px 8px; border-radius:6px; color:#E8D5B5">[alookhor_portal_header]</code></p>
    </div>
    <script>
    jQuery(function($){
        let topLogoFrame;
        $('#alookhorSelectTopLogo').on('click', function(e){
            e.preventDefault();
            if(topLogoFrame){ topLogoFrame.open(); return; }
            topLogoFrame = wp.media({title:'انتخاب لوگوی Top Bar', button:{text:'استفاده از این تصویر'}, multiple:false});
            topLogoFrame.on('select', function(){
                const item = topLogoFrame.state().get('selection').first().toJSON();
                $('#alookhorTopLogoUrl').val(item.url).trigger('change');
            });
            topLogoFrame.open();
        });
        $('#alookhorHeaderForm').on('submit', function(e){
            e.preventDefault();
            const data = $(this).serializeArray();
            data.push({name:'action', value:'alookhor_save_header'});
            $.post(ALOOKHOR_CC.ajax_url, data, function(res){
                if(res.success){ $('#alookhorHeaderMsg').show().text('ذخیره شد ✓ — هدر حرفه‌ای و فهرست‌های WordPress بروز شدند'); setTimeout(()=>$('#alookhorHeaderMsg').fadeOut(),3000); }
                else alert(res.data||'خطا');
            });
        });
    });
    </script>
    <?php
}
