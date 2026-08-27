<?php
/** Managed sorting and packaging center slider. */
if (!defined('ABSPATH')) exit;

function alookhor_cc_sort_center_defaults() {
    return [
        'enabled'=>true, 'autoplay'=>true, 'autoplay_interval'=>5000, 'show_arrows'=>true, 'show_dots'=>true,
        'eyebrow'=>'از باغ تا بسته‌بندی', 'title'=>'مرکز سورت و بسته‌بندی آلوخور',
        'description'=>'سورت دقیق، کنترل کیفیت و بسته‌بندی استاندارد محصولات با ظرفیت پایدار روزانه.',
        'capacity'=>'۲.۴ تن', 'today'=>'۱.۸ تن', 'button_text'=>'درخواست همکاری', 'button_url'=>'/#b2b',
        'background'=>'#0D0712', 'surface'=>'#1C1024', 'gold'=>'#D4AF37', 'text'=>'#FFFFFF', 'muted'=>'#C8C2C9', 'radius'=>26,
        'products'=>['آلو بخارا','آلو طرقبه','آلو شوقان','برگه زردآلو','گردو'],
        'products_title'=>'محصولات قابل عرضه:',
        'features'=>[
            ['icon'=>'link','title'=>'حذف واسطه','subtitle'=>'DIRECT'],
            ['icon'=>'shield','title'=>'تضمین کیفیت','subtitle'=>'PREMIUM'],
            ['icon'=>'tag','title'=>'قیمت مناسب','subtitle'=>'FAIR PRICE'],
            ['icon'=>'truck','title'=>'ارسال سریع','subtitle'=>'FAST SHIP'],
        ],
        'slides'=>[
            ['image_id'=>0,'image_url'=>'','image_alt'=>'مرکز سورت آلوخور','caption'=>'سورت دقیق محصولات'],
            ['image_id'=>0,'image_url'=>'','image_alt'=>'بسته‌بندی آلوخور','caption'=>'بسته‌بندی استاندارد'],
            ['image_id'=>0,'image_url'=>'','image_alt'=>'کنترل کیفیت آلوخور','caption'=>'کنترل کیفیت مستمر'],
        ],
    ];
}
function alookhor_cc_get_sort_center_settings() {
    $state=get_option(ALOOKHOR_CC_OPTION,[]); $saved=is_array($state['sort_center_settings']??null)?$state['sort_center_settings']:[];
    $settings=array_replace_recursive(alookhor_cc_sort_center_defaults(),$saved);
    $settings['slides']=array_values(array_filter((array)$settings['slides'],fn($s)=>is_array($s)&&!empty($s['image_url'])));
    return $settings;
}
function alookhor_cc_sort_icon($name){
    $paths=[
        'link'=>'<path d="M10 13a5 5 0 0 0 7.1.1l2-2a5 5 0 0 0-7.1-7.1l-1.1 1.1M14 11a5 5 0 0 0-7.1-.1l-2 2A5 5 0 0 0 12 20l1.1-1.1"/>',
        'shield'=>'<path d="M12 3 5 6v5c0 4.6 3 7.8 7 10 4-2.2 7-5.4 7-10V6l-7-3Z"/><path d="m9 12 2 2 4-4"/>',
        'tag'=>'<path d="M20 13 13 20l-9-9V4h7l9 9Z"/><circle cx="8.5" cy="8.5" r="1"/>',
        'truck'=>'<path d="M3 6h11v11H3zM14 10h4l3 3v4h-7z"/><circle cx="7" cy="18" r="2"/><circle cx="18" cy="18" r="2"/>',
    ];
    return '<svg viewBox="0 0 24 24" aria-hidden="true">'.($paths[$name]??$paths['shield']).'</svg>';
}
function alookhor_cc_sort_center_shortcode() {
    $s=alookhor_cc_get_sort_center_settings(); if(empty($s['enabled'])) return '';
    $colors=[]; foreach(['background','surface','gold','text','muted'] as $k)$colors[$k]=sanitize_hex_color($s[$k]??'')?:alookhor_cc_sort_center_defaults()[$k];
    $slides=(array)$s['slides'];
    ob_start();
    // Elementor Editor شورت‌کد را بعد از wp_head رندر می‌کند؛ CSS به‌صورت Scoped همراه خروجی باشد.
    static $inline_style_printed=false;
    if(!$inline_style_printed && alookhor_cc_should_inline_shortcode_css()){$inline_style_printed=true;$css_file=ALOOKHOR_CC_DIR.'assets/css/frontend-sort-center.css';if(file_exists($css_file))echo '<style id="alookhor-sort-center-inline">'.file_get_contents($css_file).'</style>';}
    ?>
<section class="alookhor-sort-center" dir="rtl" data-autoplay="<?php echo !empty($s['autoplay'])?'1':'0'; ?>" data-interval="<?php echo max(2500,min(15000,absint($s['autoplay_interval']))); ?>" style="--asc-bg:<?php echo esc_attr($colors['background']); ?>;--asc-surface:<?php echo esc_attr($colors['surface']); ?>;--asc-gold:<?php echo esc_attr($colors['gold']); ?>;--asc-text:<?php echo esc_attr($colors['text']); ?>;--asc-muted:<?php echo esc_attr($colors['muted']); ?>;--asc-radius:<?php echo max(10,min(40,absint($s['radius']))); ?>px">
 <div class="asc-inner">
 <div class="asc-slider"><div class="asc-track"><?php foreach($slides as $i=>$slide):?><figure class="asc-slide<?php echo $i===0?' is-active':'';?>"><img src="<?php echo esc_url($slide['image_url']);?>" alt="<?php echo esc_attr($slide['image_alt']??'');?>" loading="<?php echo $i===0?'eager':'lazy';?>"><figcaption><?php echo esc_html($slide['caption']??'');?></figcaption></figure><?php endforeach;?></div><?php if(empty($slides)):?><div class="asc-empty">تصاویر این بخش را از مدیریت بوتیک انتخاب کنید</div><?php endif;?><?php if(count($slides)>1&&!empty($s['show_arrows'])):?><button class="asc-prev" type="button" aria-label="قبلی">‹</button><button class="asc-next" type="button" aria-label="بعدی">›</button><?php endif;?><?php if(count($slides)>1&&!empty($s['show_dots'])):?><div class="asc-dots"><?php foreach($slides as $i=>$_):?><button type="button" class="<?php echo $i===0?'is-active':'';?>" data-index="<?php echo $i;?>" aria-label="اسلاید <?php echo $i+1;?>"></button><?php endforeach;?></div><?php endif;?></div>
 <div class="asc-content"><span class="asc-eyebrow"><?php echo esc_html($s['eyebrow']); ?></span><h2><?php echo esc_html($s['title']); ?></h2><p class="asc-description"><?php echo esc_html($s['description']); ?></p><div class="asc-products"><b><?php echo esc_html($s['products_title']??'محصولات قابل عرضه:'); ?></b><div><?php foreach((array)($s['products']??[]) as $product):if(trim($product)==='')continue;?><span>✦ <?php echo esc_html($product);?></span><?php endforeach;?></div></div><div class="asc-features"><?php foreach((array)($s['features']??[]) as $feature):?><article><i><?php echo alookhor_cc_sort_icon($feature['icon']??'shield');?></i><b><?php echo esc_html($feature['title']??'');?></b><small><?php echo esc_html($feature['subtitle']??'');?></small></article><?php endforeach;?></div><?php if(!empty($s['button_text'])):?><a class="asc-cta" href="<?php echo esc_url($s['button_url']); ?>"><?php echo esc_html($s['button_text']); ?></a><?php endif;?></div>
 </div>
</section><?php return ob_get_clean();
}
add_shortcode('alookhor_sort_center','alookhor_cc_sort_center_shortcode');
add_action('wp_enqueue_scripts',function(){wp_enqueue_style('alookhor-cc-sort-center',ALOOKHOR_CC_URL.'assets/css/frontend-sort-center.css',[],ALOOKHOR_CC_BUILD);wp_enqueue_script('alookhor-cc-sort-center',ALOOKHOR_CC_URL.'assets/js/frontend-sort-center.js',[],ALOOKHOR_CC_BUILD,true);});
