<?php
/**
 * Admin UI for the purple glass slider.
 * Submenu under ALOOKHOR Control Center — nonce + manage_options + media picker.
 */
if (!defined('ABSPATH')) exit;

add_action('admin_menu', function () {
    add_submenu_page(
        'alookhor-control-center',
        'اسلایدر بنفش شیشه‌ای',
        'اسلایدر بنفش شیشه‌ای',
        'manage_options',
        'alookhor-cc-purple-slider',
        'alookhor_cc_render_purple_slider_settings'
    );
}, 21);

function alookhor_cc_render_purple_slider_settings(){
    if (!current_user_can('manage_options')) return;
    $s = alookhor_cc_get_purple_slider_settings();
    $slides = is_array($s['slides'] ?? null) ? $s['slides'] : [];
    ?>
    <div class="wrap" style="background:#070708;margin-left:-20px;padding:24px;color:#F5F1E9">
        <h1 style="color:#E8D5B5;font-family:'Cormorant Garamond',serif">اسلایدر بنفش شیشه‌ای</h1>
        <p style="color:#9A9590">شورت‌کد <code dir="ltr" style="background:#111113;border:1px solid rgba(201,168,106,.14);padding:4px 8px;border-radius:6px;color:#E8D5B5">[alookhor_purple_slider]</code> — افزودن حداکثر ۶ اسلاید، حذف تا حداقل ۱ اسلاید، و کنترل Autoplay / Arrows / Dots.</p>
        <form id="alookhorPurpleSliderForm" style="max-width:980px;background:rgba(255,255,255,.03);border:1px solid rgba(201,168,106,.14);border-radius:18px;padding:20px;display:grid;gap:16px">
            <?php wp_nonce_field('alookhor_cc_nonce', 'nonce'); ?>
            <section class="alookhor-settings-section">
                <div class="alookhor-section-head"><div><b>رفتار اسلایدر</b><span>بازه Autoplay بین ۳۰۰۰ تا ۱۵۰۰۰ میلی‌ثانیه</span></div><em>PLAYBACK</em></div>
                <div class="alookhor-fields-grid">
                    <label>Autoplay (ms) <input type="number" min="3000" max="15000" step="100" name="autoplay" value="<?php echo esc_attr($s['autoplay']); ?>" class="alookhor-field"></label>
                </div>
                <div style="display:flex;gap:10px;flex-wrap:wrap">
                    <?php foreach (['arrows' => 'نمایش پیکان‌ها', 'dots' => 'نمایش نقطه‌ها'] as $key => $label): ?>
                    <label style="display:flex;align-items:center;gap:8px;background:rgba(255,255,255,.035);border:1px solid rgba(201,168,106,.14);border-radius:999px;padding:8px 12px">
                        <input type="hidden" name="<?php echo esc_attr($key); ?>" value="0">
                        <input type="checkbox" name="<?php echo esc_attr($key); ?>" value="1" <?php checked(!empty($s[$key])); ?> style="accent-color:#C9A86A">
                        <?php echo esc_html($label); ?>
                    </label>
                    <?php endforeach; ?>
                </div>
            </section>
            <div id="alookhorPurpleSlides" class="alookhor-ps-admin-list">
                <?php foreach ($slides as $index => $slide) echo alookhor_cc_purple_slider_admin_card($index, $slide); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
            </div>
            <div style="display:flex;gap:10px;flex-wrap:wrap;align-items:center">
                <button type="button" id="alookhorAddPurpleSlide" class="alookhor-media-btn">افزودن اسلاید</button>
                <span style="font-size:12px;color:#9A9590">حداکثر ۶ اسلاید — حداقل ۱ اسلاید باید باقی بماند.</span>
            </div>
            <button type="submit" style="background:linear-gradient(135deg,#C9A86A,#B8935A);color:#1A1206;border:0;padding:12px;border-radius:999px;font-weight:700;cursor:pointer">ذخیره اسلایدر بنفش</button>
            <div id="alookhorPurpleSliderMsg" style="font-size:12px;color:#3DD68C;display:none">ذخیره شد ✓</div>
        </form>
        <template id="alookhorPurpleSlideTemplate"><?php echo alookhor_cc_purple_slider_admin_card('__i__', [ // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
            'image_id' => 0,
            'image_url' => '',
            'image_alt' => '',
            'kicker' => '',
            'title' => '',
            'highlight' => '',
            'description' => '',
            'primary_text' => '',
            'primary_url' => '',
            'secondary_text' => '',
            'secondary_url' => '',
        ]); ?></template>
        <style>
          #alookhorPurpleSliderForm label{color:#D8D0C7;font-size:12px;display:grid;gap:6px}
          #alookhorPurpleSliderForm .alookhor-field{width:100%;max-width:none;background:rgba(255,255,255,.04);border:1px solid rgba(201,168,106,.18);border-radius:9px;padding:9px 10px;color:#fff}
          .alookhor-settings-section{padding:16px;border:1px solid rgba(201,168,106,.13);border-radius:14px;background:rgba(0,0,0,.14);display:grid;gap:14px}
          .alookhor-section-head{display:flex;align-items:center;justify-content:space-between;gap:12px;padding-bottom:11px;border-bottom:1px solid rgba(201,168,106,.1)}
          .alookhor-section-head b{display:block;color:#E8D5B5;font-size:14px}.alookhor-section-head span{display:block;color:#8F8991;font-size:10px;margin-top:4px}.alookhor-section-head em{font:700 9px Arial;color:#C9A86A;border:1px solid rgba(201,168,106,.2);border-radius:999px;padding:4px 7px}
          .alookhor-fields-grid{display:grid;grid-template-columns:repeat(auto-fit,minmax(230px,1fr));gap:13px}
          .alookhor-media-btn{white-space:nowrap;border:1px solid rgba(201,168,106,.3);border-radius:9px;background:rgba(201,168,106,.1);color:#E8D5B5;padding:8px 12px;cursor:pointer}
          .alookhor-ps-admin-card{display:grid;gap:14px;padding:16px;border:1px solid rgba(168,85,247,.22);border-radius:16px;background:rgba(42,18,64,.28)}
          .alookhor-ps-admin-preview{width:100%;height:120px;border-radius:12px;object-fit:cover;background:#1A0B28;border:1px solid rgba(199,155,255,.22)}
          .alookhor-ps-admin-preview.is-empty{display:grid;place-items:center;color:#9A9590;font-size:12px}
          @media(max-width:782px){.alookhor-fields-grid{grid-template-columns:1fr}}
        </style>
    </div>
    <script>
    jQuery(function($){
        const list = $('#alookhorPurpleSlides');
        const addBtn = $('#alookhorAddPurpleSlide');
        const template = $('#alookhorPurpleSlideTemplate').html();
        function reindex(){
            list.children('.alookhor-ps-admin-card').each(function(index){
                $(this).attr('data-index', index);
                $(this).find('[data-field]').each(function(){
                    const field = $(this).attr('data-field');
                    $(this).attr('name', 'slides[' + index + '][' + field + ']');
                });
                $(this).find('.alookhor-ps-admin-title').text('اسلاید ' + (index + 1));
            });
            const count = list.children('.alookhor-ps-admin-card').length;
            addBtn.prop('disabled', count >= 6);
            list.find('[data-remove-slide]').prop('disabled', count <= 1);
        }
        list.on('click', '[data-pick-media]', function(e){
            e.preventDefault();
            const card = $(this).closest('.alookhor-ps-admin-card');
            const frame = wp.media({title:'انتخاب تصویر اسلاید', button:{text:'استفاده از این تصویر'}, multiple:false});
            frame.on('select', function(){
                const item = frame.state().get('selection').first().toJSON();
                card.find('[data-field="image_url"]').val(item.url);
                card.find('[data-field="image_id"]').val(item.id || 0);
                if (!card.find('[data-field="image_alt"]').val()) card.find('[data-field="image_alt"]').val(item.alt || item.title || '');
                const preview = card.find('.alookhor-ps-admin-preview');
                if (preview.is('img')) preview.attr('src', item.url).removeClass('is-empty');
                else preview.replaceWith('<img class="alookhor-ps-admin-preview" src="'+item.url+'" alt="">');
            });
            frame.open();
        });
        list.on('click', '[data-remove-slide]', function(e){
            e.preventDefault();
            if (list.children('.alookhor-ps-admin-card').length <= 1) return;
            $(this).closest('.alookhor-ps-admin-card').remove();
            reindex();
        });
        addBtn.on('click', function(){
            if (list.children('.alookhor-ps-admin-card').length >= 6) return;
            list.append(template);
            reindex();
        });
        $('#alookhorPurpleSliderForm').on('submit', function(e){
            e.preventDefault();
            const data = $(this).serializeArray();
            data.push({name:'action', value:'alookhor_save_purple_slider'});
            $.post(ALOOKHOR_CC.ajax_url, data, function(res){
                if (res.success) {
                    $('#alookhorPurpleSliderMsg').show().text('ذخیره شد ✓ — شورت‌کد [alookhor_purple_slider] بروز شد');
                    setTimeout(()=>$('#alookhorPurpleSliderMsg').fadeOut(), 3000);
                } else {
                    alert(res.data || 'خطا');
                }
            });
        });
        reindex();
    });
    </script>
    <?php
}

function alookhor_cc_purple_slider_admin_card($index, $slide){
    $slide = is_array($slide) ? $slide : [];
    $image = esc_url($slide['image_url'] ?? '');
    ob_start(); ?>
    <section class="alookhor-ps-admin-card" data-index="<?php echo esc_attr($index); ?>">
        <div class="alookhor-section-head">
            <div><b class="alookhor-ps-admin-title">اسلاید</b><span>تصویر، نوشته‌ها و دو CTA</span></div>
            <button type="button" class="alookhor-media-btn" data-remove-slide>حذف</button>
        </div>
        <?php if ($image): ?>
            <img class="alookhor-ps-admin-preview" src="<?php echo $image; ?>" alt="">
        <?php else: ?>
            <div class="alookhor-ps-admin-preview is-empty">پیش‌نمایش تصویر</div>
        <?php endif; ?>
        <div class="alookhor-fields-grid">
            <label style="grid-column:span 2">آدرس تصویر
                <span style="display:flex;gap:8px">
                    <input data-field="image_url" name="slides[<?php echo esc_attr($index); ?>][image_url]" value="<?php echo esc_attr($slide['image_url'] ?? ''); ?>" class="alookhor-field" dir="ltr">
                    <button type="button" class="alookhor-media-btn" data-pick-media>انتخاب تصویر</button>
                </span>
            </label>
            <input type="hidden" data-field="image_id" name="slides[<?php echo esc_attr($index); ?>][image_id]" value="<?php echo esc_attr($slide['image_id'] ?? 0); ?>">
            <label>متن جایگزین <input data-field="image_alt" name="slides[<?php echo esc_attr($index); ?>][image_alt]" value="<?php echo esc_attr($slide['image_alt'] ?? ''); ?>" class="alookhor-field"></label>
            <label>Kicker <input data-field="kicker" name="slides[<?php echo esc_attr($index); ?>][kicker]" value="<?php echo esc_attr($slide['kicker'] ?? ''); ?>" class="alookhor-field"></label>
            <label>عنوان <input data-field="title" name="slides[<?php echo esc_attr($index); ?>][title]" value="<?php echo esc_attr($slide['title'] ?? ''); ?>" class="alookhor-field"></label>
            <label>Highlight <input data-field="highlight" name="slides[<?php echo esc_attr($index); ?>][highlight]" value="<?php echo esc_attr($slide['highlight'] ?? ''); ?>" class="alookhor-field"></label>
            <label style="grid-column:span 2">توضیح <textarea data-field="description" name="slides[<?php echo esc_attr($index); ?>][description]" class="alookhor-field" rows="3"><?php echo esc_textarea($slide['description'] ?? ''); ?></textarea></label>
            <label>متن CTA اول <input data-field="primary_text" name="slides[<?php echo esc_attr($index); ?>][primary_text]" value="<?php echo esc_attr($slide['primary_text'] ?? ''); ?>" class="alookhor-field"></label>
            <label>لینک CTA اول <input data-field="primary_url" name="slides[<?php echo esc_attr($index); ?>][primary_url]" value="<?php echo esc_attr($slide['primary_url'] ?? ''); ?>" class="alookhor-field" dir="ltr"></label>
            <label>متن CTA دوم <input data-field="secondary_text" name="slides[<?php echo esc_attr($index); ?>][secondary_text]" value="<?php echo esc_attr($slide['secondary_text'] ?? ''); ?>" class="alookhor-field"></label>
            <label>لینک CTA دوم <input data-field="secondary_url" name="slides[<?php echo esc_attr($index); ?>][secondary_url]" value="<?php echo esc_attr($slide['secondary_url'] ?? ''); ?>" class="alookhor-field" dir="ltr"></label>
        </div>
    </section>
    <?php
    return ob_get_clean();
}
