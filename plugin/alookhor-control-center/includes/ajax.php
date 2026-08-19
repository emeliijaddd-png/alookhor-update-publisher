<?php
if (!defined('ABSPATH')) exit;

// ——— AJAX: ذخیره تنظیمات با آپدیت آنی (بدون رفرش) ———

add_action('wp_ajax_alookhor_save_settings', 'alookhor_ajax_save_settings');
add_action('wp_ajax_alookhor_toggle_module', 'alookhor_ajax_toggle_module');
add_action('wp_ajax_alookhor_save_header', 'alookhor_ajax_save_header_wp');
add_action('wp_ajax_alookhor_save_purple_slider', 'alookhor_ajax_save_purple_slider');
add_action('wp_ajax_alookhor_get_settings', 'alookhor_ajax_get_settings');

// nonce check helper
function alookhor_cc_check(){
    check_ajax_referer('alookhor_cc_nonce', 'nonce');
    if(!current_user_can('manage_options')) wp_send_json_error('دسترسی ندارید');
}

// State فقط شامل داده متنی/عددی/Boolean است؛ HTML اجرایی نباید در wp_options ذخیره شود.
function alookhor_cc_sanitize_state($value){
    if (is_array($value)) {
        $clean = [];
        foreach ($value as $key => $item) {
            $safe_key = is_int($key) ? $key : sanitize_key($key);
            $clean[$safe_key] = alookhor_cc_sanitize_state($item);
        }
        return $clean;
    }
    if (is_bool($value) || is_int($value) || is_float($value) || is_null($value)) return $value;
    return sanitize_textarea_field((string) $value);
}

function alookhor_ajax_get_settings(){
    alookhor_cc_check();
    $settings = alookhor_cc_get_settings();
    wp_send_json_success($settings);
}

function alookhor_ajax_save_settings(){
    alookhor_cc_check();
    $raw_payload = isset($_POST['payload']) ? wp_unslash($_POST['payload']) : '';
    $payload = json_decode($raw_payload, true);
    if(json_last_error() !== JSON_ERROR_NONE || empty($payload) || !is_array($payload)) {
        wp_send_json_error('payload نامعتبر');
    }
    $payload = alookhor_cc_sanitize_state($payload);

    // فیلدهای Top Bar در ذخیره پنل اصلی نیز باید با همان قرارداد فرم
    // تخصصی هدر نرمال شوند؛ Preview مرورگر منبع حقیقت نیست.
    if (!empty($payload['header_settings']) && is_array($payload['header_settings'])) {
        $header_current = get_option(ALOOKHOR_CC_HEADER_OPTION, []);
        if (!is_array($header_current)) $header_current = [];
        $header = $payload['header_settings'];
        foreach ([
            'topbar_bg' => '#1C1024',
            'topbar_text_color' => '#F5F3F0',
            'topbar_border_color' => '#D49A2E',
            'topbar_button_bg' => '#D49A2E',
            'topbar_button_text' => '#0D0510',
            'header_surface' => '#0D0510',
            'header_text_color' => '#F5F3F0',
            'header_muted_color' => '#C8C2C9',
            'capsule_background' => '#0D0510',
            'capsule_card' => '#1C1024',
            'capsule_gold' => '#D49A2E',
            'capsule_gold_light' => '#E8B84A',
            'capsule_text' => '#F5F3F0',
            'capsule_muted' => '#C8C2C9',
        ] as $key => $fallback) {
            if (array_key_exists($key, $header)) {
                $header[$key] = sanitize_hex_color($header[$key]) ?: ($header_current[$key] ?? $fallback);
            }
        }
        if(array_key_exists('capsule_glass',$header)){
            $capsule_glass=sanitize_text_field($header['capsule_glass']);
            $header['capsule_glass']=preg_match('/^rgba?\(\s*\d{1,3}\s*,\s*\d{1,3}\s*,\s*\d{1,3}(?:\s*,\s*(?:0|1|0?\.\d+))?\s*\)$/',$capsule_glass)?$capsule_glass:($header_current['capsule_glass']??'rgba(33,20,38,.75)');
        }
        if(array_key_exists('capsule_blur',$header))$header['capsule_blur']=max(10,min(36,absint($header['capsule_blur'])));
        foreach (['export_url', 'wholesale_url', 'top_logo_url', 'top_logo_link', 'mega_cta_url'] as $key) {
            if (array_key_exists($key, $header)) $header[$key] = esc_url_raw($header[$key]);
        }
        if (array_key_exists('mega_cta_label', $header)) {
            $header['mega_cta_label'] = sanitize_text_field($header['mega_cta_label']);
        }
        if (array_key_exists('email', $header)) $header['email'] = sanitize_email($header['email']);
        if (array_key_exists('whatsapp', $header)) $header['whatsapp'] = preg_replace('/\D+/', '', (string) $header['whatsapp']);
        if (array_key_exists('topbar_height', $header)) $header['topbar_height'] = max(30, min(60, absint($header['topbar_height'])));
        if (array_key_exists('top_logo_width', $header)) $header['top_logo_width'] = max(50, min(180, absint($header['top_logo_width'])));
        if (array_key_exists('header_logo_desktop_width', $header)) $header['header_logo_desktop_width'] = max(70, min(220, absint($header['header_logo_desktop_width'])));
        if (array_key_exists('header_logo_mobile_width', $header)) $header['header_logo_mobile_width'] = max(42, min(110, absint($header['header_logo_mobile_width'])));
        foreach (['sticky', 'show_search', 'show_topbar', 'show_contact', 'show_account', 'show_phone', 'show_email', 'show_whatsapp', 'show_export', 'show_wholesale', 'wholesale_new_tab', 'mega_menu'] as $key) {
            if (array_key_exists($key, $header)) $header[$key] = rest_sanitize_boolean($header[$key]);
        }
        $payload['header_settings'] = $header;
    }

    if (!empty($payload['footer_settings']) && is_array($payload['footer_settings'])) {
        $footer = $payload['footer_settings'];
        foreach (['background'=>'#070809','surface'=>'#0D0F10','gold'=>'#C89A3D','gold_soft'=>'#E3BD69','text'=>'#E9E5DF','muted'=>'#A7A39D','border'=>'#4A3820'] as $key=>$fallback) {
            if (array_key_exists($key,$footer)) $footer[$key] = sanitize_hex_color($footer[$key]) ?: $fallback;
        }
        foreach (['logo_url','cta_url','instagram_url','telegram_url','whatsapp_url','product_image_url','enamad_image_url','enamad_url','samandehi_image_url','samandehi_url'] as $key) {
            if (array_key_exists($key,$footer)) $footer[$key] = esc_url_raw($footer[$key]);
        }
        if (array_key_exists('email',$footer)) $footer['email'] = sanitize_email($footer['email']);
        foreach (['phone','whatsapp'] as $key) if (array_key_exists($key,$footer)) $footer[$key] = sanitize_text_field($footer[$key]);
        foreach (['enabled','hide_legacy','hide_old_newsletter','use_header_contact','newsletter_enabled','show_payments','show_benefits','show_product_image'] as $key) {
            if (array_key_exists($key,$footer)) $footer[$key] = rest_sanitize_boolean($footer[$key]);
        }
        foreach (['customer_menu_id','order_menu_id','about_menu_id'] as $key) if (array_key_exists($key,$footer)) $footer[$key] = absint($footer[$key]);
        if (array_key_exists('container_width',$footer)) $footer['container_width'] = max(960,min(1600,absint($footer['container_width'])));
        if (array_key_exists('desktop_logo_width',$footer)) $footer['desktop_logo_width'] = max(100,min(320,absint($footer['desktop_logo_width'])));
        if (array_key_exists('mobile_logo_width',$footer)) $footer['mobile_logo_width'] = max(100,min(280,absint($footer['mobile_logo_width'])));
        foreach (['customer_links','order_links','about_links'] as $group) {
            if (!isset($footer[$group]) || !is_array($footer[$group])) continue;
            $footer[$group] = array_values(array_filter(array_map(function($link){
                if (!is_array($link)) return null;
                $title = sanitize_text_field($link['title'] ?? '');
                if (!$title) return null;
                return ['title'=>$title,'url'=>esc_url_raw($link['url'] ?? '#')];
            }, $footer[$group])));
        }
        $payload['footer_settings'] = $footer;
    }

    if (!empty($payload['category_settings']) && is_array($payload['category_settings'])) {
        $category = $payload['category_settings'];
        foreach (['section_background'=>'#090610','card_background'=>'#0D0916','gold'=>'#D4A436','text'=>'#F7F2EA','muted'=>'#B8B0BD','border'=>'#6F5426','button_background'=>'#120B1C'] as $key=>$fallback) {
            if (array_key_exists($key,$category)) $category[$key]=sanitize_hex_color($category[$key])?:$fallback;
        }
        foreach (['enabled','hide_legacy','hide_empty','parent_only','show_description','show_count','show_icons','show_arrows','show_dots','autoplay'] as $key) {
            if (array_key_exists($key,$category)) $category[$key]=rest_sanitize_boolean($category[$key]);
        }
        $category['selected_ids']=array_values(array_unique(array_filter(array_map('absint',(array)($category['selected_ids']??[])))));
        $category['limit']=max(1,min(24,absint($category['limit']??8)));
        $category['desktop_cards']=max(2,min(6,absint($category['desktop_cards']??4)));
        $category['desktop_gap']=max(8,min(40,absint($category['desktop_gap']??18)));
        $category['image_height']=max(180,min(430,absint($category['image_height']??285)));
        $category['mobile_card_width']=max(72,min(94,absint($category['mobile_card_width']??84)));
        $category['mobile_peek']=max(3,min(14,absint($category['mobile_peek']??8)));
        $category['mobile_image_height']=max(170,min(330,absint($category['mobile_image_height']??225)));
        $category['mobile_gap']=max(8,min(28,absint($category['mobile_gap']??14)));
        $category['mobile_radius']=max(10,min(32,absint($category['mobile_radius']??18)));
        $category['autoplay_interval']=max(2500,min(15000,absint($category['autoplay_interval']??5000)));
        $category['orderby']=in_array(($category['orderby']??''),['include','name','count','term_id','menu_order'],true)?$category['orderby']:'include';
        $category['order']=strtoupper($category['order']??'ASC')==='DESC'?'DESC':'ASC';
        if (isset($category['overrides'])&&is_array($category['overrides'])) {
            $clean=[];foreach($category['overrides'] as $id=>$override){$id=absint($id);if(!$id||!is_array($override))continue;$clean[(string)$id]=['image_url'=>esc_url_raw($override['image_url']??''),'description'=>sanitize_text_field($override['description']??'')];}$category['overrides']=$clean;
        }
        $payload['category_settings']=$category;
    }

    if (!empty($payload['hero_settings']) && is_array($payload['hero_settings'])) {
        $hero = $payload['hero_settings'];
        foreach (['gold'=>'#D4AF37','surface'=>'#09060D','text'=>'#FFFFFF','muted'=>'#D9D1DA'] as $key=>$fallback) {
            if (array_key_exists($key,$hero)) $hero[$key]=sanitize_hex_color($hero[$key])?:$fallback;
        }
        foreach (['enabled','hide_legacy','autoplay','pause_on_hover','show_arrows','show_dots','ken_burns'] as $key) {
            if (array_key_exists($key,$hero)) $hero[$key]=rest_sanitize_boolean($hero[$key]);
        }
        $hero['autoplay_interval']=max(3000,min(15000,absint($hero['autoplay_interval']??5500)));
        $hero['radius']=max(16,min(40,absint($hero['radius']??32)));
        $slide_defaults=function_exists('alookhor_cc_hero_slide_defaults')?alookhor_cc_hero_slide_defaults():array_fill(0,4,[]);
        $incoming=is_array($hero['slides']??null)?array_values($hero['slides']):[];
        $clean_slides=[];
        for($index=0;$index<4;$index++){
            $slide=is_array($incoming[$index]??null)?$incoming[$index]:[];
            $default=is_array($slide_defaults[$index]??null)?$slide_defaults[$index]:[];
            $slide=array_replace($default,$slide);
            $features=is_array($slide['features']??null)?array_values($slide['features']):[];
            $features=array_slice(array_pad(array_map('sanitize_text_field',$features),4,''),0,4);
            $clean_slides[]=[
                'image_id'=>absint($slide['image_id']??0),
                'flip_image'=>rest_sanitize_boolean($slide['flip_image']??false),
                'image_url'=>esc_url_raw($slide['image_url']??''),
                'image_alt'=>sanitize_text_field($slide['image_alt']??''),
                'kicker'=>sanitize_text_field($slide['kicker']??''),
                'title'=>sanitize_text_field($slide['title']??''),
                'highlight'=>sanitize_text_field($slide['highlight']??''),
                'description'=>sanitize_textarea_field($slide['description']??''),
                'features'=>$features,
                'primary_text'=>sanitize_text_field($slide['primary_text']??''),
                'primary_url'=>esc_url_raw($slide['primary_url']??''),
                'secondary_text'=>sanitize_text_field($slide['secondary_text']??''),
                'secondary_url'=>esc_url_raw($slide['secondary_url']??''),
            ];
        }
        $hero['slides']=$clean_slides;
        $payload['hero_settings']=$hero;
        if(isset($payload['modules']['hero'])&&is_array($payload['modules']['hero'])){
            $payload['modules']['hero']['slides']=4;
            $payload['modules']['hero']['autoplay']=!empty($hero['autoplay']);
        }
    }

    if (!empty($payload['feature_settings']) && is_array($payload['feature_settings'])) {
        $features=$payload['feature_settings'];
        foreach (['background'=>'#0D0510','card'=>'#1C1024','gold'=>'#D49A2E','gold_light'=>'#E8B84A','text'=>'#F5F3F0','muted'=>'#C8C2C9'] as $key=>$fallback) {
            if(array_key_exists($key,$features))$features[$key]=sanitize_hex_color($features[$key])?:$fallback;
        }
        foreach(['enabled','hide_legacy'] as $key)if(array_key_exists($key,$features))$features[$key]=rest_sanitize_boolean($features[$key]);
        $glass=sanitize_text_field($features['glass']??'rgba(33,20,38,.75)');
        $features['glass']=preg_match('/^rgba?\(\s*\d{1,3}\s*,\s*\d{1,3}\s*,\s*\d{1,3}(?:\s*,\s*(?:0|1|0?\.\d+))?\s*\)$/',$glass)?$glass:'rgba(33,20,38,.75)';
        $features['radius']=max(10,min(30,absint($features['radius']??20)));
        $features['gap']=max(0,min(20,absint($features['gap']??8)));
        $defaults=function_exists('alookhor_cc_site_feature_defaults')?alookhor_cc_site_feature_defaults()['items']:array_fill(0,4,[]);
        $incoming=is_array($features['items']??null)?array_values($features['items']):[];
        $allowed_icons=['truck','organic','headset','shield'];$clean_items=[];
        for($index=0;$index<4;$index++){
            $item=is_array($incoming[$index]??null)?$incoming[$index]:[];
            $default=is_array($defaults[$index]??null)?$defaults[$index]:[];
            $item=array_replace($default,$item);$icon=sanitize_key($item['icon']??'shield');
            $clean_items[]=['icon'=>in_array($icon,$allowed_icons,true)?$icon:'shield','title'=>sanitize_text_field($item['title']??''),'description'=>sanitize_text_field($item['description']??'')];
        }
        $features['items']=$clean_items;$payload['feature_settings']=$features;
    }

    // ذخیره کل تنظیمات
    $current = get_option(ALOOKHOR_CC_OPTION, []);
    $merged = array_replace_recursive(is_array($current) ? $current : [], $payload);
    $merged['updated_at'] = current_time('mysql');
    $merged['updated_by'] = wp_get_current_user()->user_login;
    update_option(ALOOKHOR_CC_OPTION, $merged);

    // اگر هدر داخل payload بود، فقط همان کلیدها Merge شوند؛ تنظیمات حرفه‌ای
    // Top Bar/Menu/Contact که در Option جدا هستند نباید حذف شوند.
    if(!empty($payload['header_settings']) && is_array($payload['header_settings'])){
        $header_current = get_option(ALOOKHOR_CC_HEADER_OPTION, []);
        if (!is_array($header_current)) $header_current = [];
        update_option(ALOOKHOR_CC_HEADER_OPTION, array_replace($header_current, $payload['header_settings']));
    }
    if(!empty($payload['site']['logoLetter'])){
        $h = get_option(ALOOKHOR_CC_HEADER_OPTION, []);
        if (!is_array($h)) $h = [];
        $h['logo_letter'] = $payload['site']['logoLetter'];
        update_option(ALOOKHOR_CC_HEADER_OPTION, $h);
    }

    $persisted_header = get_option(ALOOKHOR_CC_HEADER_OPTION, []);
    wp_send_json_success([
        'message' => 'ذخیره واقعی WordPress تأیید شد',
        'updated_at' => $merged['updated_at'],
        'header_settings' => is_array($persisted_header) ? [
            'phone' => $persisted_header['phone'] ?? null,
            'email' => $persisted_header['email'] ?? null,
            'whatsapp' => $persisted_header['whatsapp'] ?? null,
            'export_text' => $persisted_header['export_text'] ?? null,
            'wholesale_text' => $persisted_header['wholesale_text'] ?? null,
            'topbar_bg' => $persisted_header['topbar_bg'] ?? null,
            'topbar_text_color' => $persisted_header['topbar_text_color'] ?? null,
            'topbar_border_color' => $persisted_header['topbar_border_color'] ?? null,
            'topbar_button_bg' => $persisted_header['topbar_button_bg'] ?? null,
            'topbar_button_text' => $persisted_header['topbar_button_text'] ?? null,
            'header_surface' => $persisted_header['header_surface'] ?? null,
            'header_text_color' => $persisted_header['header_text_color'] ?? null,
            'header_muted_color' => $persisted_header['header_muted_color'] ?? null,
            'capsule_background' => $persisted_header['capsule_background'] ?? null,
            'capsule_card' => $persisted_header['capsule_card'] ?? null,
            'capsule_glass' => $persisted_header['capsule_glass'] ?? null,
            'capsule_gold' => $persisted_header['capsule_gold'] ?? null,
            'capsule_gold_light' => $persisted_header['capsule_gold_light'] ?? null,
            'capsule_text' => $persisted_header['capsule_text'] ?? null,
            'capsule_muted' => $persisted_header['capsule_muted'] ?? null,
            'capsule_blur' => $persisted_header['capsule_blur'] ?? null,
            'header_logo_desktop_width' => $persisted_header['header_logo_desktop_width'] ?? null,
            'header_logo_mobile_width' => $persisted_header['header_logo_mobile_width'] ?? null,
            'sticky' => $persisted_header['sticky'] ?? null,
            'topbar_height' => $persisted_header['topbar_height'] ?? null,
        ] : null,
        'footer_settings' => is_array($merged['footer_settings'] ?? null) ? [
            'enabled' => !empty($merged['footer_settings']['enabled']),
            'brand_name' => $merged['footer_settings']['brand_name'] ?? null,
            'phone' => $merged['footer_settings']['phone'] ?? null,
            'email' => $merged['footer_settings']['email'] ?? null,
            'background' => $merged['footer_settings']['background'] ?? null,
            'customer_menu_id' => $merged['footer_settings']['customer_menu_id'] ?? 0,
            'order_menu_id' => $merged['footer_settings']['order_menu_id'] ?? 0,
            'about_menu_id' => $merged['footer_settings']['about_menu_id'] ?? 0,
        ] : null,
        'category_settings' => is_array($merged['category_settings'] ?? null) ? [
            'enabled'=>!empty($merged['category_settings']['enabled']),
            'selected_ids'=>array_values((array)($merged['category_settings']['selected_ids']??[])),
            'desktop_cards'=>$merged['category_settings']['desktop_cards']??4,
            'title'=>$merged['category_settings']['title']??null,
            'gold'=>$merged['category_settings']['gold']??null,
        ] : null,
        'hero_settings' => is_array($merged['hero_settings'] ?? null) ? [
            'enabled'=>!empty($merged['hero_settings']['enabled']),
            'slide_count'=>count((array)($merged['hero_settings']['slides']??[])),
            'autoplay'=>!empty($merged['hero_settings']['autoplay']),
            'gold'=>$merged['hero_settings']['gold']??null,
        ] : null,
        'feature_settings' => is_array($merged['feature_settings'] ?? null) ? [
            'enabled'=>!empty($merged['feature_settings']['enabled']),
            'item_count'=>count((array)($merged['feature_settings']['items']??[])),
            'background'=>$merged['feature_settings']['background']??null,
            'card'=>$merged['feature_settings']['card']??null,
            'gold'=>$merged['feature_settings']['gold']??null,
        ] : null,
    ]);
}

function alookhor_ajax_toggle_module(){
    alookhor_cc_check();
    $key = sanitize_key(wp_unslash($_POST['module'] ?? ''));
    $enabled_raw = isset($_POST['enabled']) ? wp_unslash($_POST['enabled']) : false;
    $enabled = rest_sanitize_boolean($enabled_raw);
    if(!$key) wp_send_json_error('module نامشخص');

    $settings = alookhor_cc_get_settings();
    if(!isset($settings['modules'][$key])) wp_send_json_error('ماژول یافت نشد');

    $settings['modules'][$key]['enabled'] = $enabled;
    $settings['updated_at'] = current_time('mysql');
    update_option(ALOOKHOR_CC_OPTION, $settings);

    wp_send_json_success(['message'=> $enabled ? 'ماژول فعال شد' : 'ماژول غیرفعال شد', 'enabled'=>$enabled]);
}

function alookhor_ajax_save_header_wp(){
    alookhor_cc_check();
    $current = get_option(ALOOKHOR_CC_HEADER_OPTION, []);
    if (!is_array($current)) $current = [];

    // فقط فیلدهای ارسال‌شده تغییر می‌کنند؛ sticky/search/CTA و رنگ قبلی حذف نمی‌شوند.
    $data = $current;
    $data['logo_text'] = sanitize_text_field(wp_unslash($_POST['logo_text'] ?? ($current['logo_text'] ?? 'ALOOKHOR')));
    $data['logo_sub'] = sanitize_text_field(wp_unslash($_POST['logo_sub'] ?? ($current['logo_sub'] ?? 'Control Center • Luxury')));
    $data['logo_letter'] = sanitize_text_field(wp_unslash($_POST['logo_letter'] ?? ($current['logo_letter'] ?? 'A')));
    $data['search_placeholder'] = sanitize_text_field(wp_unslash($_POST['search_placeholder'] ?? ($current['search_placeholder'] ?? 'جستجوی محصول…')));
    if (isset($_POST['gold'])) {
        $data['gold'] = sanitize_hex_color(wp_unslash($_POST['gold'])) ?: ($current['gold'] ?? '#D49A2E');
    } elseif (empty($data['gold'])) {
        $data['gold'] = '#D49A2E';
    }

    $data['phone'] = sanitize_text_field(wp_unslash($_POST['phone'] ?? ($current['phone'] ?? '')));
    $data['email'] = sanitize_email(wp_unslash($_POST['email'] ?? ($current['email'] ?? get_option('admin_email'))));
    $data['whatsapp'] = preg_replace('/\D+/', '', (string) wp_unslash($_POST['whatsapp'] ?? ($current['whatsapp'] ?? '')));
    $data['export_text'] = sanitize_text_field(wp_unslash($_POST['export_text'] ?? ($current['export_text'] ?? '')));
    $data['export_url'] = esc_url_raw(wp_unslash($_POST['export_url'] ?? ($current['export_url'] ?? '')));
    $data['wholesale_text'] = sanitize_text_field(wp_unslash($_POST['wholesale_text'] ?? ($current['wholesale_text'] ?? '')));
    $data['wholesale_url'] = esc_url_raw(wp_unslash($_POST['wholesale_url'] ?? ($current['wholesale_url'] ?? home_url('/#b2b'))));
    $data['top_logo_url'] = esc_url_raw(wp_unslash($_POST['top_logo_url'] ?? ($current['top_logo_url'] ?? '')));
    $data['top_logo_alt'] = sanitize_text_field(wp_unslash($_POST['top_logo_alt'] ?? ($current['top_logo_alt'] ?? get_bloginfo('name'))));
    $data['top_logo_link'] = esc_url_raw(wp_unslash($_POST['top_logo_link'] ?? ($current['top_logo_link'] ?? home_url('/'))));
    foreach ([
        'topbar_bg' => '#1C1024',
        'topbar_text_color' => '#F5F3F0',
        'topbar_border_color' => '#D49A2E',
        'topbar_button_bg' => '#D49A2E',
        'topbar_button_text' => '#0D0510',
        'header_surface' => '#0D0510',
        'header_text_color' => '#F5F3F0',
        'header_muted_color' => '#C8C2C9',
        'capsule_background' => '#0D0510',
        'capsule_card' => '#1C1024',
        'capsule_gold' => '#D49A2E',
        'capsule_gold_light' => '#E8B84A',
        'capsule_text' => '#F5F3F0',
        'capsule_muted' => '#C8C2C9',
    ] as $color_key => $color_default) {
        $data[$color_key] = sanitize_hex_color(wp_unslash($_POST[$color_key] ?? ($current[$color_key] ?? $color_default))) ?: $color_default;
    }
    $capsule_glass=sanitize_text_field(wp_unslash($_POST['capsule_glass']??($current['capsule_glass']??'rgba(33,20,38,.75)')));
    $data['capsule_glass']=preg_match('/^rgba?\(\s*\d{1,3}\s*,\s*\d{1,3}\s*,\s*\d{1,3}(?:\s*,\s*(?:0|1|0?\.\d+))?\s*\)$/',$capsule_glass)?$capsule_glass:'rgba(33,20,38,.75)';
    $data['capsule_blur']=max(10,min(36,absint($_POST['capsule_blur']??($current['capsule_blur']??24))));
    $data['topbar_height'] = max(30, min(60, absint($_POST['topbar_height'] ?? ($current['topbar_height'] ?? 38))));
    $data['top_logo_width'] = max(50, min(180, absint($_POST['top_logo_width'] ?? ($current['top_logo_width'] ?? 96))));
    $data['header_logo_desktop_width'] = max(70, min(220, absint($_POST['header_logo_desktop_width'] ?? ($current['header_logo_desktop_width'] ?? 118))));
    $data['header_logo_mobile_width'] = max(42, min(110, absint($_POST['header_logo_mobile_width'] ?? ($current['header_logo_mobile_width'] ?? 58))));
    $data['account_text'] = sanitize_text_field(wp_unslash($_POST['account_text'] ?? ($current['account_text'] ?? 'ورود / ثبت‌نام')));
    $data['primary_menu'] = absint($_POST['primary_menu'] ?? ($current['primary_menu'] ?? 0));
    $data['mega_cta_label'] = sanitize_text_field(wp_unslash($_POST['mega_cta_label'] ?? ($current['mega_cta_label'] ?? 'مشاهده همه محصولات')));
    $data['mega_cta_url'] = esc_url_raw(wp_unslash($_POST['mega_cta_url'] ?? ($current['mega_cta_url'] ?? home_url('/shop/'))));
    foreach (['sticky', 'show_search', 'show_topbar', 'show_contact', 'show_account', 'show_phone', 'show_email', 'show_whatsapp', 'show_export', 'show_wholesale', 'wholesale_new_tab', 'mega_menu'] as $flag) {
        $data[$flag] = isset($_POST[$flag]) ? rest_sanitize_boolean(wp_unslash($_POST[$flag])) : !empty($current[$flag]);
    }

    update_option(ALOOKHOR_CC_HEADER_OPTION, $data);

    // همگام‌سازی با settings اصلی
    $settings = alookhor_cc_get_settings();
    $settings['header_settings']['logo_text'] = $data['logo_text'];
    $settings['header_settings']['logo_sub'] = $data['logo_sub'];
    $settings['site']['logoLetter'] = $data['logo_letter'];
    $settings['site']['goldAccent'] = $data['gold'];
    $settings['updated_at'] = current_time('mysql');
    update_option(ALOOKHOR_CC_OPTION, $settings);

    wp_send_json_success(['message'=>'هدر با موفقیت ذخیره شد — شورت‌کد [alookhor_portal_header] بروز شد','data'=>$data]);
}

function alookhor_ajax_save_purple_slider(){
    alookhor_cc_check();
    if (!function_exists('alookhor_cc_normalize_purple_slider_slides')) {
        wp_send_json_error('ماژول اسلایدر بنفش در دسترس نیست');
    }
    $current = get_option(defined('ALOOKHOR_CC_PURPLE_SLIDER_OPTION') ? ALOOKHOR_CC_PURPLE_SLIDER_OPTION : 'alookhor_cc_purple_slider', []);
    if (!is_array($current)) $current = [];

    $incoming_slides = [];
    if (isset($_POST['payload'])) {
        $payload = json_decode(wp_unslash($_POST['payload']), true);
        if (is_array($payload)) {
            if (isset($payload['slides'])) $incoming_slides = $payload['slides'];
            if (array_key_exists('autoplay', $payload)) $_POST['autoplay'] = $payload['autoplay'];
            if (array_key_exists('arrows', $payload)) $_POST['arrows'] = $payload['arrows'];
            if (array_key_exists('dots', $payload)) $_POST['dots'] = $payload['dots'];
        }
    }
    if (!$incoming_slides && isset($_POST['slides']) && is_array($_POST['slides'])) {
        $incoming_slides = wp_unslash($_POST['slides']);
    }

    $slides = alookhor_cc_normalize_purple_slider_slides($incoming_slides);
    if (!$slides) wp_send_json_error('حداقل یک اسلاید لازم است');
    if (count($slides) > 6) $slides = array_slice($slides, 0, 6);

    $data = [
        'autoplay' => alookhor_cc_normalize_purple_slider_autoplay($_POST['autoplay'] ?? ($current['autoplay'] ?? 5500)),
        'arrows' => isset($_POST['arrows']) ? rest_sanitize_boolean(wp_unslash($_POST['arrows'])) : !empty($current['arrows']),
        'dots' => isset($_POST['dots']) ? rest_sanitize_boolean(wp_unslash($_POST['dots'])) : !empty($current['dots']),
        'slides' => $slides,
    ];
    $option = defined('ALOOKHOR_CC_PURPLE_SLIDER_OPTION') ? ALOOKHOR_CC_PURPLE_SLIDER_OPTION : 'alookhor_cc_purple_slider';
    update_option($option, $data);
    wp_send_json_success([
        'message' => 'اسلایدر بنفش ذخیره شد — شورت‌کد [alookhor_purple_slider] بروز شد',
        'slide_count' => count($slides),
        'data' => $data,
    ]);
}
