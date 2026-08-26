<?php
/**
 * Export banner settings — صفحه مدیریت «بنر صادراتی» در Control Center.
 *
 * نسخه مدیریتی ماژول [alookhor_export_banner]: فعال/غیرفعال، انتخاب تصویر
 * پس‌زمینه و لوگوی مرکزی از کتابخانه رسانه، متن‌ها، شماره‌ها و لینک‌های
 * واتساپ و تمام کنترل‌های رنگ/شفافیت/بلور. ذخیره از طریق admin-ajax با همان
 * قرارداد nonce امن کنترل سنتر انجام می‌شود و هیچ تنظیمات دیگری دست نمی‌خورد.
 */
if (!defined('ABSPATH')) exit;

// تنظیمات این ماژول از v3.10.85 داخل «مدیریت بوتیک ← بنر صادراتی» یکپارچه شده است.
// Renderer قدیمی برای سازگاری نگه داشته شده اما زیرمنوی تکراری دیگر ثبت نمی‌شود.

function alookhor_cc_render_export_banner_settings(){
    if(!current_user_can('manage_options')) return;
    $b = alookhor_cc_get_export_banner_settings();
    $bg_preview = alookhor_cc_export_banner_image_url($b['background_image_id'], $b['background_image_url']);
    $logo_preview = alookhor_cc_export_banner_image_url($b['logo_id'], $b['logo_url']);
    ?>
    <div class="wrap" style="background:#070708; margin-left:-20px; padding:24px; color:#F5F1E9">
        <h1 style="color:#E8D5B5; font-family:'Cormorant Garamond',serif">بنر صادراتی</h1>
        <p style="color:#9A9590">بنر لوکس سبز و طلایی صادرات — شورت‌کد <code dir="ltr" style="background:#111113; border:1px solid rgba(201,168,106,0.14); padding:4px 8px; border-radius:6px; color:#E8D5B5">[alookhor_export_banner]</code> را در هر صفحه یا ویجت Elementor قرار دهید؛ بدون هیچ اثری روی هدر، مگامنو، هیرو یا فوتر.</p>
        <form id="alookhorExportBannerForm" style="max-width:900px; background:rgba(255,255,255,0.03); border:1px solid rgba(201,168,106,0.14); border-radius:18px; padding:20px; display:grid; gap:16px">
            <?php wp_nonce_field('alookhor_cc_nonce','nonce'); ?>

            <section class="alookhor-settings-section">
                <div class="alookhor-section-head"><div><b>وضعیت و رسانه</b><span>فعال‌سازی، تصویر پس‌زمینه و لوگوی مرکزی از WordPress Media Library</span></div><em>MEDIA</em></div>
                <label style="display:flex;align-items:center;gap:8px;background:rgba(255,255,255,.035);border:1px solid rgba(201,168,106,.14);border-radius:999px;padding:8px 12px;width:fit-content">
                    <input type="hidden" name="enabled" value="0">
                    <input type="checkbox" name="enabled" value="1" <?php checked(!empty($b['enabled'])); ?> style="accent-color:#C9A86A">
                    نمایش بنر صادراتی در خروجی شورت‌کد
                </label>
                <div class="alookhor-fields-grid">
                    <label style="grid-column:span 2">تصویر Background (کامیون/کانتینر)
                        <span style="display:flex;gap:8px;align-items:center">
                            <input type="hidden" id="alookhorXbBgId" name="background_image_id" value="<?php echo esc_attr($b['background_image_id']); ?>">
                            <input id="alookhorXbBgUrl" name="background_image_url" value="<?php echo esc_attr($b['background_image_url']); ?>" class="alookhor-field" dir="ltr">
                            <button type="button" id="alookhorXbBgSelect" class="alookhor-media-btn">انتخاب تصویر</button>
                        </span>
                        <img id="alookhorXbBgPreview" src="<?php echo esc_url($bg_preview); ?>" alt="" style="margin-top:8px;max-width:260px;border-radius:10px;border:1px solid rgba(201,168,106,.25);<?php echo $bg_preview ? '' : 'display:none;'; ?>">
                    </label>
                    <label style="grid-column:span 2">لوگوی وسط بنر
                        <span style="display:flex;gap:8px;align-items:center">
                            <input type="hidden" id="alookhorXbLogoId" name="logo_id" value="<?php echo esc_attr($b['logo_id']); ?>">
                            <input id="alookhorXbLogoUrl" name="logo_url" value="<?php echo esc_attr($b['logo_url']); ?>" class="alookhor-field" dir="ltr">
                            <button type="button" id="alookhorXbLogoSelect" class="alookhor-media-btn">انتخاب لوگو</button>
                        </span>
                        <img id="alookhorXbLogoPreview" src="<?php echo esc_url($logo_preview); ?>" alt="" style="margin-top:8px;max-width:120px;border-radius:50%;border:1px solid rgba(201,168,106,.25);<?php echo $logo_preview ? '' : 'display:none;'; ?>">
                    </label>
                </div>
            </section>

            <section class="alookhor-settings-section">
                <div class="alookhor-section-head"><div><b>متن‌های بنر</b><span>عنوان اصلی، عنوان طلایی، متن کارت و وضعیت پاسخگویی</span></div><em>CONTENT</em></div>
                <div class="alookhor-fields-grid">
                    <label>عنوان اصلی <input name="title" value="<?php echo esc_attr($b['title']); ?>" class="alookhor-field"></label>
                    <label>عنوان طلایی <input name="title_gold" value="<?php echo esc_attr($b['title_gold']); ?>" class="alookhor-field"></label>
                    <label style="grid-column:span 2">متن کارت صادراتی <textarea name="card_text" rows="3" class="alookhor-field"><?php echo esc_textarea($b['card_text']); ?></textarea></label>
                    <label style="grid-column:span 2">متن وضعیت پاسخگویی <input name="status_text" value="<?php echo esc_attr($b['status_text']); ?>" class="alookhor-field"></label>
                </div>
            </section>

            <section class="alookhor-settings-section">
                <div class="alookhor-section-head"><div><b>دکمه‌های واتساپ</b><span>دو شماره به‌همراه لینک مستقیم wa.me</span></div><em>WHATSAPP</em></div>
                <div class="alookhor-fields-grid">
                    <label>شماره واتساپ اول <input name="whatsapp1_number" value="<?php echo esc_attr($b['whatsapp1_number']); ?>" class="alookhor-field" dir="ltr"></label>
                    <label>لینک واتساپ اول <input type="url" name="whatsapp1_link" value="<?php echo esc_attr($b['whatsapp1_link']); ?>" class="alookhor-field" dir="ltr" placeholder="https://wa.me/98..."></label>
                    <label>شماره واتساپ دوم <input name="whatsapp2_number" value="<?php echo esc_attr($b['whatsapp2_number']); ?>" class="alookhor-field" dir="ltr"></label>
                    <label>لینک واتساپ دوم <input type="url" name="whatsapp2_link" value="<?php echo esc_attr($b['whatsapp2_link']); ?>" class="alookhor-field" dir="ltr" placeholder="https://wa.me/98..."></label>
                </div>
            </section>

            <section class="alookhor-settings-section">
                <div class="alookhor-section-head"><div><b>ظاهر و جلوه‌ها</b><span>رنگ‌ها، شفافیت کارت و بنر و شدت Blur شیشه‌ای</span></div><em>STYLE</em></div>
                <div class="alookhor-color-grid">
                    <?php foreach ([
                        'bg_color' => 'رنگ پس‌زمینه (سبز تیره)',
                        'gold_color' => 'رنگ طلایی',
                        'whatsapp_color' => 'رنگ سبز واتساپ',
                    ] as $color_key => $color_label): ?>
                        <label><?php echo esc_html($color_label); ?><input type="color" name="<?php echo esc_attr($color_key); ?>" value="<?php echo esc_attr($b[$color_key]); ?>" class="alookhor-field alookhor-color-field"></label>
                    <?php endforeach; ?>
                </div>
                <div class="alookhor-fields-grid">
                    <label>شفافیت کارت (20–95٪ تیرگی) <input type="number" min="20" max="95" name="card_opacity" value="<?php echo esc_attr($b['card_opacity']); ?>" class="alookhor-field"></label>
                    <label>شفافیت بنر (0–95٪ تیرگی روکش) <input type="number" min="0" max="95" name="overlay_opacity" value="<?php echo esc_attr($b['overlay_opacity']); ?>" class="alookhor-field"></label>
                    <label>شدت Blur / Glass (0–40px) <input type="number" min="0" max="40" name="blur_strength" value="<?php echo esc_attr($b['blur_strength']); ?>" class="alookhor-field"></label>
                </div>
            </section>

            <button type="submit" style="background:linear-gradient(135deg,#C9A86A,#B8935A); color:#1A1206; border:0; padding:12px; border-radius:999px; font-weight:700; cursor:pointer">ذخیره تنظیمات بنر صادراتی</button>
            <div id="alookhorExportBannerMsg" style="font-size:12px; color:#3DD68C; display:none">ذخیره شد ✓</div>
        </form>
        <style>
          #alookhorExportBannerForm label{color:#D8D0C7;font-size:12px;display:grid;gap:6px}
          #alookhorExportBannerForm .alookhor-field{width:100%;max-width:none;background:rgba(255,255,255,.04);border:1px solid rgba(201,168,106,.18);border-radius:9px;padding:9px 10px;color:#fff}
          #alookhorExportBannerForm select.alookhor-field{background:#17131A}
          #alookhorExportBannerForm textarea.alookhor-field{resize:vertical}
          .alookhor-settings-section{padding:16px;border:1px solid rgba(201,168,106,.13);border-radius:14px;background:rgba(0,0,0,.14);display:grid;gap:14px}
          .alookhor-section-head{display:flex;align-items:center;justify-content:space-between;gap:12px;padding-bottom:11px;border-bottom:1px solid rgba(201,168,106,.1)}
          .alookhor-section-head b{display:block;color:#E8D5B5;font-size:14px}.alookhor-section-head span{display:block;color:#8F8991;font-size:10px;margin-top:4px}.alookhor-section-head em{font:700 9px Arial;color:#C9A86A;border:1px solid rgba(201,168,106,.2);border-radius:999px;padding:4px 7px}
          .alookhor-fields-grid{display:grid;grid-template-columns:repeat(auto-fit,minmax(230px,1fr));gap:13px}.alookhor-color-grid{display:grid;grid-template-columns:repeat(auto-fit,minmax(150px,1fr));gap:12px}
          #alookhorExportBannerForm .alookhor-color-field{height:42px;padding:4px}.alookhor-media-btn{white-space:nowrap;border:1px solid rgba(201,168,106,.3);border-radius:9px;background:rgba(201,168,106,.1);color:#E8D5B5;padding:8px 12px;cursor:pointer}
          @media(max-width:782px){.alookhor-fields-grid,.alookhor-color-grid{grid-template-columns:1fr}.alookhor-fields-grid label[style*="span 2"]{grid-column:auto!important}}
        </style>
        <p style="margin-top:14px; font-size:12px; color:#9A9590">شورت‌کد در المنتور: <code dir="ltr" style="background:#111113; border:1px solid rgba(201,168,106,0.14); padding:4px 8px; border-radius:6px; color:#E8D5B5">[alookhor_export_banner]</code></p>
    </div>
    <script>
    jQuery(function($){
        function bindMediaPicker(buttonId, idField, urlField, preview){
            let frame;
            $(buttonId).on('click', function(e){
                e.preventDefault();
                if(frame){ frame.open(); return; }
                frame = wp.media({title:'انتخاب تصویر', button:{text:'استفاده از این تصویر'}, multiple:false});
                frame.on('select', function(){
                    const item = frame.state().get('selection').first().toJSON();
                    $(idField).val(item.id);
                    $(urlField).val(item.url).trigger('change');
                    if(preview){ $(preview).attr('src', item.url).show(); }
                });
                frame.open();
            });
        }
        bindMediaPicker('#alookhorXbBgSelect', '#alookhorXbBgId', '#alookhorXbBgUrl', '#alookhorXbBgPreview');
        bindMediaPicker('#alookhorXbLogoSelect', '#alookhorXbLogoId', '#alookhorXbLogoUrl', '#alookhorXbLogoPreview');
        $('#alookhorXbBgUrl, #alookhorXbLogoUrl').on('change', function(){
            const preview = this.id === 'alookhorXbBgUrl' ? '#alookhorXbBgPreview' : '#alookhorXbLogoPreview';
            const value = $(this).val();
            if(value){ $(preview).attr('src', value).show(); } else { $(preview).hide(); }
        });
        $('#alookhorExportBannerForm').on('submit', function(e){
            e.preventDefault();
            const data = $(this).serializeArray();
            data.push({name:'action', value:'alookhor_save_export_banner'});
            $.post(ALOOKHOR_CC.ajax_url, data, function(res){
                if(res.success){ $('#alookhorExportBannerMsg').show().text('ذخیره شد ✓ — شورت‌کد [alookhor_export_banner] بروز شد'); setTimeout(()=>$('#alookhorExportBannerMsg').fadeOut(),3000); }
                else alert(res.data||'خطا');
            });
        });
    });
    </script>
    <?php
}

// ——— AJAX: ذخیره امن تنظیمات بنر صادراتی ———
add_action('wp_ajax_alookhor_save_export_banner', 'alookhor_ajax_save_export_banner');
function alookhor_ajax_save_export_banner(){
    alookhor_cc_check();
    $current = get_option(ALOOKHOR_CC_EXPORT_BANNER_OPTION, []);
    if (!is_array($current)) $current = [];
    $defaults = alookhor_cc_export_banner_defaults();
    $data = array_replace($defaults, $current);

    $data['enabled'] = isset($_POST['enabled']) ? rest_sanitize_boolean(wp_unslash($_POST['enabled'])) : !empty($current['enabled']);
    $data['background_image_id'] = absint($_POST['background_image_id'] ?? ($current['background_image_id'] ?? 0));
    $data['background_image_url'] = esc_url_raw(wp_unslash($_POST['background_image_url'] ?? ($current['background_image_url'] ?? $defaults['background_image_url'])));
    $data['logo_id'] = absint($_POST['logo_id'] ?? ($current['logo_id'] ?? 0));
    $data['logo_url'] = esc_url_raw(wp_unslash($_POST['logo_url'] ?? ($current['logo_url'] ?? '')));
    $data['title'] = sanitize_text_field(wp_unslash($_POST['title'] ?? ($current['title'] ?? $defaults['title'])));
    $data['title_gold'] = sanitize_text_field(wp_unslash($_POST['title_gold'] ?? ($current['title_gold'] ?? $defaults['title_gold'])));
    $data['card_text'] = sanitize_textarea_field(wp_unslash($_POST['card_text'] ?? ($current['card_text'] ?? $defaults['card_text'])));
    $data['status_text'] = sanitize_text_field(wp_unslash($_POST['status_text'] ?? ($current['status_text'] ?? $defaults['status_text'])));
    $data['whatsapp1_number'] = sanitize_text_field(wp_unslash($_POST['whatsapp1_number'] ?? ($current['whatsapp1_number'] ?? $defaults['whatsapp1_number'])));
    $data['whatsapp1_link'] = esc_url_raw(wp_unslash($_POST['whatsapp1_link'] ?? ($current['whatsapp1_link'] ?? $defaults['whatsapp1_link'])));
    $data['whatsapp2_number'] = sanitize_text_field(wp_unslash($_POST['whatsapp2_number'] ?? ($current['whatsapp2_number'] ?? $defaults['whatsapp2_number'])));
    $data['whatsapp2_link'] = esc_url_raw(wp_unslash($_POST['whatsapp2_link'] ?? ($current['whatsapp2_link'] ?? $defaults['whatsapp2_link'])));
    foreach (['bg_color', 'gold_color', 'whatsapp_color'] as $color_key) {
        $data[$color_key] = sanitize_hex_color(wp_unslash($_POST[$color_key] ?? ($current[$color_key] ?? $defaults[$color_key]))) ?: $defaults[$color_key];
    }
    $data['card_opacity'] = max(20, min(95, absint($_POST['card_opacity'] ?? ($current['card_opacity'] ?? $defaults['card_opacity']))));
    $data['overlay_opacity'] = max(0, min(95, absint($_POST['overlay_opacity'] ?? ($current['overlay_opacity'] ?? $defaults['overlay_opacity']))));
    $data['blur_strength'] = max(0, min(40, absint($_POST['blur_strength'] ?? ($current['blur_strength'] ?? $defaults['blur_strength']))));

    $data = alookhor_cc_export_banner_normalize($data);
    update_option(ALOOKHOR_CC_EXPORT_BANNER_OPTION, $data);

    wp_send_json_success(['message' => 'بنر صادراتی با موفقیت ذخیره شد — شورت‌کد [alookhor_export_banner] بروز شد', 'data' => $data]);
}
