<?php
/**
 * Header Manager — صفحه مدیریت کامل هدر حرفه‌ای در Control Center
 * تمام تنظیمات هدر (لوگو، نوار بالایی، رنگ‌ها، واتساپ، منوی موبایل)
 * از این صفحه قابل مدیریت است.
 */
if (!defined('ABSPATH')) exit;

// --- Submenu ---
add_action('admin_menu', function(){
    add_submenu_page(
        'alookhor-control-center',
        'مدیریت هدر حرفه‌ای',
        'هدر حرفه‌ای',
        'manage_options',
        'alookhor-cc-header-manager',
        'alookhor_cc_render_header_manager'
    );
}, 25);

/**
 * Render the header manager page.
 */
function alookhor_cc_render_header_manager() {
    if (!current_user_can('manage_options')) return;
    $h = get_option(ALOOKHOR_CC_HEADER_OPTION, array());
    if (!is_array($h)) $h = array();

    $enabled    = !empty($h['enabled']);
    $logo_id    = isset($h['logo_id']) ? (int)$h['logo_id'] : 0;
    $logo_url   = isset($h['logo_url']) ? $h['logo_url'] : '';
    $logo_w     = isset($h['logo_width']) ? $h['logo_width'] : 74;
    $ws_txt     = isset($h['wholesale_text']) ? $h['wholesale_text'] : 'خرید عمده';
    $ws_url     = isset($h['wholesale_url']) ? $h['wholesale_url'] : '/wholesale/';
    $exp_txt    = isset($h['export_text']) ? $h['export_text'] : 'صادرات به بیش از ۵۰ کشور جهان';
    $exp_url    = isset($h['export_url']) ? $h['export_url'] : '/export/';
    $wa_num     = isset($h['whatsapp_number']) ? $h['whatsapp_number'] : '989159513173';
    $email      = isset($h['email']) ? $h['email'] : '';
    $phone      = isset($h['phone']) ? $h['phone'] : '09159513173';
    $brand      = isset($h['brand_name']) ? $h['brand_name'] : 'آلوخور';
    $sub        = isset($h['brand_subtitle']) ? $h['brand_subtitle'] : 'خشکبار طبیعی اصيل';

    // Colors
    $header_bg = $h['header_bg'] ?? '#17041f';
    $gold_c    = $h['gold_color'] ?? '#D4AF37';
    $gold_l    = $h['gold_light'] ?? '#f1d468';
    $wa_clr    = $h['whatsapp_color'] ?? '#27e67a';
    $drw_1     = $h['drawer_bg_1'] ?? '#150826';
    $drw_2     = $h['drawer_bg_2'] ?? '#0d0218';

    // Logo preview
    $bg_preview = '';
    if ($logo_url) {
        $bg_preview = esc_url($logo_url);
    } elseif ($logo_id) {
        $src = wp_get_attachment_image_url($logo_id, 'full');
        if ($src) $bg_preview = $src;
    }
    ?>
    <div class="wrap" style="background:#070708; margin-left:-20px; padding:24px; color:#F5F1E9">
        <h1 style="color:#E8D5B5; font-family:serif">مدیریت هدر حرفه‌ای آلوخور</h1>
        <p style="color:#9A9590">تنظیمات هدر لوکس بنفش/طلایی شورت‌کد <code style="background:#111113; border:1px solid rgba(201,168,106,0.14); padding:4px 8px; border-radius:6px; color:#E8D5B5">[alookhor_portal_header]</code></p>
        <form id="alookhorHeaderMgrForm" style="max-width:1000px; background:rgba(255,255,255,0.03); border:1px solid rgba(201,168,106,0.14); border-radius:18px; padding:20px; display:grid; gap:16px">
            <?php wp_nonce_field('alookhor_cc_nonce','nonce'); ?>

            <section class="alookhor-settings-section">
                <div class="alookhor-section-head">
                    <div><b>وضعیت و لوگو</b><span>فعال‌سازی و تصویر لوگو</span></div><em>BRAND</em>
                </div>
                <label style="display:flex;align-items:center;gap:8px;background:rgba(255,255,255,.035);border:1px solid rgba(201,168,106,.14);border-radius:999px;padding:8px 12px;width:fit-content">
                    <input type="hidden" name="enabled" value="0">
                    <input type="checkbox" name="enabled" value="1" <?php checked($enabled); ?> style="accent-color:#C9A86A">
                    فعال بودن هدر حرفه‌ای
                </label>
                <div class="alookhor-fields-grid">
                    <label style="grid-column:span 2">لوگو
                        <span style="display:flex;gap:8px">
                            <input type="hidden" id="akxLogoId" name="logo_id" value="<?php echo esc_attr($logo_id); ?>">
                            <input id="akxLogoUrl" name="logo_url" value="<?php echo esc_attr($logo_url); ?>" class="alookhor-field" dir="ltr" placeholder="آدرس تصویر لوگو">
                            <button type="button" id="akxLogoSelect" class="alookhor-media-btn">انتخاب</button>
                        </span>
                        <img id="akxLogoPreview" src="<?php echo esc_url($bg_preview); ?>" alt="" style="margin-top:8px;max-width:120px;border-radius:10px;border:1px solid rgba(201,168,106,.25);<?php echo $bg_preview ? '' : 'display:none;'; ?>">
                    </label>
                    <label>عرض لوگو (px) <input type="number" min="40" max="180" name="logo_width" value="<?php echo esc_attr($logo_w); ?>" class="alookhor-field"></label>
                </div>
            </section>

            <section class="alookhor-settings-section">
                <div class="alookhor-section-head"><div><b>نوار بالایی</b><span>متن‌ها و لینک‌ها</span></div><em>TOPBAR</em></div>
                <div class="alookhor-fields-grid">
                    <label>متن خرید عمده <input name="wholesale_text" value="<?php echo esc_attr($ws_txt); ?>" class="alookhor-field"></label>
                    <label>لینک خرید عمده <input name="wholesale_url" value="<?php echo esc_attr($ws_url); ?>" class="alookhor-field" dir="ltr"></label>
                    <label>متن صادرات <input name="export_text" value="<?php echo esc_attr($exp_txt); ?>" class="alookhor-field"></label>
                    <label>لینک صادرات <input name="export_url" value="<?php echo esc_attr($exp_url); ?>" class="alookhor-field" dir="ltr"></label>
                    <label>واتساپ (9891...) <input name="whatsapp_number" value="<?php echo esc_attr($wa_num); ?>" class="alookhor-field" dir="ltr"></label>
                    <label>ایمیل <input type="email" name="email" value="<?php echo esc_attr($email); ?>" class="alookhor-field" dir="ltr"></label>
                    <label>تلفن <input name="phone" value="<?php echo esc_attr($phone); ?>" class="alookhor-field" dir="ltr"></label>
                </div>
            </section>

            <section class="alookhor-settings-section">
                <div class="alookhor-section-head"><div><b>رنگ‌ها</b><span>پالت بنفش/طلایی</span></div><em>STYLE</em></div>
                <div class="alookhor-fields-grid">
                    <label>پس‌زمینه کلی <input type="color" name="header_bg" value="<?php echo esc_attr($header_bg); ?>" class="alookhor-field alookhor-color-field"></label>
                    <label>طلایی اصلی <input type="color" name="gold_color" value="<?php echo esc_attr($gold_c); ?>" class="alookhor-field alookhor-color-field"></label>
                    <label>طلایی روشن <input type="color" name="gold_light" value="<?php echo esc_attr($gold_l); ?>" class="alookhor-field alookhor-color-field"></label>
                    <label>واتساپ <input type="color" name="whatsapp_color" value="<?php echo esc_attr($wa_clr); ?>" class="alookhor-field alookhor-color-field"></label>
                    <label>دراور ۱ <input type="color" name="drawer_bg_1" value="<?php echo esc_attr($drw_1); ?>" class="alookhor-field alookhor-color-field"></label>
                    <label>دراور ۲ <input type="color" name="drawer_bg_2" value="<?php echo esc_attr($drw_2); ?>" class="alookhor-field alookhor-color-field"></label>
                </div>
            </section>

            <section class="alookhor-settings-section">
                <div class="alookhor-section-head"><div><b>منوی موبایل</b><span>متن برند در دراور</span></div><em>MOBILE</em></div>
                <div class="alookhor-fields-grid">
                    <label>نام برند <input name="brand_name" value="<?php echo esc_attr($brand); ?>" class="alookhor-field"></label>
                    <label>زیرعنوان <input name="brand_subtitle" value="<?php echo esc_attr($sub); ?>" class="alookhor-field"></label>
                </div>
            </section>

            <button type="submit" style="background:linear-gradient(135deg,#C9A86A,#B8935A); color:#1A1206; border:0; padding:12px; border-radius:999px; font-weight:700; cursor:pointer">ذخیره تنظیمات هدر</button>
            <div id="akxHeaderMgrMsg" style="font-size:12px; color:#3DD68C; display:none">ذخیره شد ✓</div>
        </form>
        <style>
          #alookhorHeaderMgrForm label{color:#D8D0C7;font-size:12px;display:grid;gap:6px}
          #alookhorHeaderMgrForm .alookhor-field{width:100%;background:rgba(255,255,255,.04);border:1px solid rgba(201,168,106,.18);border-radius:9px;padding:9px 10px;color:#fff}
          .alookhor-settings-section{padding:16px;border:1px solid rgba(201,168,106,.13);border-radius:14px;background:rgba(0,0,0,.14);display:grid;gap:14px}
          .alookhor-section-head{display:flex;align-items:center;justify-content:space-between;gap:12px;padding-bottom:11px;border-bottom:1px solid rgba(201,168,106,.1)}
          .alookhor-section-head b{display:block;color:#E8D5B5;font-size:14px}.alookhor-section-head span{display:block;color:#8F8991;font-size:10px;margin-top:4px}.alookhor-section-head em{font:700 9px Arial;color:#C9A86A;border:1px solid rgba(201,168,106,.2);border-radius:999px;padding:4px 7px}
          .alookhor-fields-grid{display:grid;grid-template-columns:repeat(auto-fit,minmax(230px,1fr));gap:13px}
          #alookhorHeaderMgrForm .alookhor-color-field{height:42px;padding:4px}.alookhor-media-btn{white-space:nowrap;border:1px solid rgba(201,168,106,.3);border-radius:9px;background:rgba(201,168,106,.1);color:#E8D5B5;padding:8px 12px;cursor:pointer}
          @media(max-width:782px){.alookhor-fields-grid{grid-template-columns:1fr}}
        </style>
    </div>
    <script>
    jQuery(function($){
        var logoFrame;
        $('#akxLogoSelect').on('click', function(e){
            e.preventDefault();
            if(logoFrame){ logoFrame.open(); return; }
            logoFrame = wp.media({title:'انتخاب لوگوی هدر', button:{text:'استفاده'}, multiple:false});
            logoFrame.on('select', function(){
                var item = logoFrame.state().get('selection').first().toJSON();
                $('#akxLogoId').val(item.id);
                $('#akxLogoUrl').val(item.url).trigger('change');
                $('#akxLogoPreview').attr('src', item.url).show();
            });
            logoFrame.open();
        });
        $('#akxLogoUrl').on('change', function(){
            if($(this).val()){ $('#akxLogoPreview').attr('src', $(this).val()).show(); } else { $('#akxLogoPreview').hide(); }
        });
        $('#alookhorHeaderMgrForm').on('submit', function(e){
            e.preventDefault();
            var data = $(this).serializeArray();
            data.push({name:'action', value:'alookhor_save_header_manager'});
            $.post(ALOOKHOR_CC.ajax_url, data, function(res){
                if(res.success){ $('#akxHeaderMgrMsg').show().text('ذخیره شد ✓ — هدر بروز شد'); setTimeout(function(){ $('#akxHeaderMgrMsg').fadeOut(); }, 3000); }
                else alert(res.data||'خطا');
            });
        });
    });
    </script>
    <?php
}

// --- AJAX Save ---
add_action('wp_ajax_alookhor_save_header_manager', 'alookhor_ajax_save_header_manager');
function alookhor_ajax_save_header_manager() {
    alookhor_cc_check();
    $current = get_option(ALOOKHOR_CC_HEADER_OPTION, array());
    if (!is_array($current)) $current = array();

    $data = $current;
    $data['enabled']          = isset($_POST['enabled']) ? (bool)$_POST['enabled'] : false;
    $data['logo_id']          = absint($_POST['logo_id'] ?? 0);
    $data['logo_url']         = esc_url_raw(wp_unslash($_POST['logo_url'] ?? ''));
    $data['logo_width']       = max(40, min(180, absint($_POST['logo_width'] ?? 74)));
    $data['wholesale_text']   = sanitize_text_field(wp_unslash($_POST['wholesale_text'] ?? ''));
    $data['wholesale_url']    = esc_url_raw(wp_unslash($_POST['wholesale_url'] ?? ''));
    $data['export_text']      = sanitize_text_field(wp_unslash($_POST['export_text'] ?? ''));
    $data['export_url']       = esc_url_raw(wp_unslash($_POST['export_url'] ?? ''));
    $data['whatsapp_number']  = preg_replace('/[^0-9]/', '', wp_unslash($_POST['whatsapp_number'] ?? ''));
    $data['email']            = sanitize_email(wp_unslash($_POST['email'] ?? ''));
    $data['phone']            = sanitize_text_field(wp_unslash($_POST['phone'] ?? ''));
    $data['brand_name']       = sanitize_text_field(wp_unslash($_POST['brand_name'] ?? ''));
    $data['brand_subtitle']   = sanitize_text_field(wp_unslash($_POST['brand_subtitle'] ?? ''));

    $color_keys = array('header_bg', 'gold_color', 'gold_light', 'whatsapp_color', 'drawer_bg_1', 'drawer_bg_2');
    foreach ($color_keys as $key) {
        if (isset($_POST[$key])) {
            $data[$key] = sanitize_hex_color(wp_unslash($_POST[$key])) ?: ($data[$key] ?? '');
        }
    }

    update_option(ALOOKHOR_CC_HEADER_OPTION, $data);
    wp_send_json_success(array('message' => 'هدر با موفقیت ذخیره شد', 'data' => $data));
}
