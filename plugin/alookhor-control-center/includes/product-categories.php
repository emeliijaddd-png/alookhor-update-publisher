<?php
/** WooCommerce-backed managed product category showcase — desktop phase. */
if (!defined('ABSPATH')) exit;

function alookhor_cc_category_defaults(){
    return [
        'enabled'=>true,'hide_legacy'=>true,'hide_empty'=>false,'parent_only'=>true,
        'selected_ids'=>[38,39,40,41],'limit'=>8,'orderby'=>'include','order'=>'ASC',
        'kicker'=>'دسته‌بندی محصولات','title'=>'محصولات طبیعی، کیفیت صادراتی',
        'subtitle'=>'انتخاب مستقیم از باغ‌های خراسان، آماده ارسال به سراسر جهان',
        'button_text'=>'مشاهده محصولات','show_description'=>true,'show_count'=>false,
        'show_icons'=>true,'show_arrows'=>true,'show_dots'=>true,'autoplay'=>true,
        'autoplay_interval'=>5000,'desktop_cards'=>4,'desktop_gap'=>18,'image_height'=>285,
        'section_background'=>'#090610','card_background'=>'#0D0916','gold'=>'#D4A436',
        'text'=>'#F7F2EA','muted'=>'#B8B0BD','border'=>'#6F5426','button_background'=>'#120B1C',
        'overrides'=>[
            '38'=>['image_url'=>ALOOKHOR_CC_URL.'assets/images/category-plums.jpg','description'=>'آلو بخارا، مغزدار حسینی، کالیفرنیا و تن شوقان'],
            '39'=>['image_url'=>ALOOKHOR_CC_URL.'assets/images/category-fruit-sheets.jpg','description'=>'برگه زردآلو، هلو، قیسی و میوه‌های خشک ممتاز'],
            '40'=>['image_url'=>ALOOKHOR_CC_URL.'assets/images/category-natural-snacks.jpg','description'=>'کشمش، توت خشک و تنقلات طبیعی بدون افزودنی'],
            '41'=>['image_url'=>ALOOKHOR_CC_URL.'assets/images/category-nuts.jpg','description'=>'گردو و مغزهای ممتاز با کیفیت صادراتی'],
        ],
    ];
}

function alookhor_cc_get_category_settings(){
    $main=alookhor_cc_get_settings();
    $saved=is_array($main['category_settings']??null)?$main['category_settings']:[];
    return apply_filters('alookhor_cc_category_settings',array_replace_recursive(alookhor_cc_category_defaults(),$saved));
}

function alookhor_cc_category_terms($settings=null){
    $s=is_array($settings)?$settings:alookhor_cc_get_category_settings();
    if (!taxonomy_exists('product_cat')) return [];
    $selected=array_values(array_filter(array_map('absint',(array)($s['selected_ids']??[]))));
    $args=['taxonomy'=>'product_cat','hide_empty'=>!empty($s['hide_empty']),'number'=>max(1,min(24,absint($s['limit']??8))),'order'=>strtoupper($s['order']??'ASC')==='DESC'?'DESC':'ASC'];
    if (!empty($s['parent_only'])) $args['parent']=0;
    if ($selected){$args['include']=$selected;$args['orderby']='include';$args['number']=count($selected);} else {
        $allowed=['name','count','term_id','menu_order'];$orderby=(string)($s['orderby']??'name');$args['orderby']=in_array($orderby,$allowed,true)?$orderby:'name';
    }
    $terms=get_terms($args);return is_wp_error($terms)?[]:$terms;
}

function alookhor_cc_category_icon($slug){
    if (str_contains($slug,'maghz')||str_contains($slug,'nut')) return '<svg viewBox="0 0 48 48"><path d="M24 7c10 0 17 8 17 18S33 42 24 42 7 35 7 25 14 7 24 7Z"/><path d="M24 8c-5 7-4 13 0 18 4-5 5-11 0-18Zm0 18c-5 3-8 7-8 13m8-13c5 3 8 7 8 13"/></svg>';
    if (str_contains($slug,'barge')||str_contains($slug,'mive')) return '<svg viewBox="0 0 48 48"><path d="M14 15c6-8 15-8 20 0 7 10 1 25-10 25S7 25 14 15Z"/><path d="M24 15c0-5 3-8 8-9M24 16c-3-5-7-7-12-5"/></svg>';
    return '<svg viewBox="0 0 48 48"><path d="M13 17c5-9 17-9 22 0 6 10 0 24-11 24S7 27 13 17Z"/><path d="M24 16c0-6 4-10 10-10M20 9c4 0 7 2 8 6"/></svg>';
}

function alookhor_cc_category_markup($settings=null){
    $s=is_array($settings)?$settings:alookhor_cc_get_category_settings();if(empty($s['enabled']))return '';
    $terms=alookhor_cc_category_terms($s);if(!$terms)return '';
    $style=sprintf('--mc-bg:%s;--mc-card:%s;--mc-gold:%s;--mc-text:%s;--mc-muted:%s;--mc-border:%s;--mc-btn:%s;--mc-cards:%d;--mc-gap:%dpx;--mc-image:%dpx',
        sanitize_hex_color($s['section_background'])?:'#090610',sanitize_hex_color($s['card_background'])?:'#0D0916',sanitize_hex_color($s['gold'])?:'#D4A436',sanitize_hex_color($s['text'])?:'#F7F2EA',sanitize_hex_color($s['muted'])?:'#B8B0BD',sanitize_hex_color($s['border'])?:'#6F5426',sanitize_hex_color($s['button_background'])?:'#120B1C',max(2,min(6,absint($s['desktop_cards']))),max(8,min(40,absint($s['desktop_gap']))),max(180,min(430,absint($s['image_height']))));
    $count=count($terms);$pages=(int)ceil($count/max(1,absint($s['desktop_cards'])));
    ob_start(); ?>
    <section id="alookhor-managed-categories" class="alookhor-mc" dir="rtl" style="<?php echo esc_attr($style); ?>" data-version="<?php echo esc_attr(ALOOKHOR_CC_VERSION); ?>" data-autoplay="<?php echo !empty($s['autoplay'])?'1':'0'; ?>" data-interval="<?php echo esc_attr(max(2500,min(15000,absint($s['autoplay_interval'])))); ?>">
      <div class="alookhor-mc-shell">
        <header class="alookhor-mc-head"><span class="alookhor-mc-kicker"><i></i><b>◆</b><?php echo esc_html($s['kicker']); ?><b>◆</b><i></i></span><h2><?php echo esc_html($s['title']); ?></h2><p><?php echo esc_html($s['subtitle']); ?></p><span class="alookhor-mc-divider"><i></i><b>◆</b><i></i></span></header>
        <div class="alookhor-mc-stage">
          <div class="alookhor-mc-viewport"><div class="alookhor-mc-track">
          <?php foreach($terms as $term): $id=(string)$term->term_id;$override=is_array($s['overrides'][$id]??null)?$s['overrides'][$id]:[];$thumb=absint(get_term_meta($term->term_id,'thumbnail_id',true));$image=$thumb?wp_get_attachment_image_url($thumb,'large'):'';if(empty($image))$image=esc_url_raw($override['image_url']??'');$description=sanitize_text_field($override['description']??'');if(!$description)$description=wp_trim_words(wp_strip_all_tags($term->description),14,'…');if(!$description)$description=sprintf('%d محصول منتخب',absint($term->count));$url=get_term_link($term);if(is_wp_error($url))$url=home_url('/shop/'); ?>
            <article class="alookhor-mc-card" data-term="<?php echo esc_attr($term->term_id); ?>">
              <a class="alookhor-mc-image" href="<?php echo esc_url($url); ?>"><?php if($image):?><img src="<?php echo esc_url($image); ?>" alt="<?php echo esc_attr($term->name); ?>" loading="lazy"><?php endif;?><?php if(!empty($s['show_icons'])):?><span class="alookhor-mc-icon"><?php echo alookhor_cc_category_icon($term->slug); // phpcs:ignore ?></span><?php endif;?></a>
              <div class="alookhor-mc-body"><h3><a href="<?php echo esc_url($url); ?>"><?php echo esc_html($term->name); ?></a></h3><?php if(!empty($s['show_description'])):?><p><?php echo esc_html($description); ?></p><?php endif;?><?php if(!empty($s['show_count'])):?><small><?php echo esc_html(number_format_i18n($term->count)); ?> محصول</small><?php endif;?><a class="alookhor-mc-button" href="<?php echo esc_url($url); ?>"><b>◆</b><span><?php echo esc_html($s['button_text']); ?></span><i>←</i></a></div>
            </article>
          <?php endforeach; ?>
          </div></div>
          <?php if(!empty($s['show_arrows'])&&$count>1):?><button class="alookhor-mc-arrow alookhor-mc-prev" type="button" aria-label="قبلی">‹</button><button class="alookhor-mc-arrow alookhor-mc-next" type="button" aria-label="بعدی">›</button><?php endif;?>
        </div>
        <?php if(!empty($s['show_dots'])):?><div class="alookhor-mc-dots" role="tablist"><?php for($i=0;$i<max(1,$pages);$i++):?><button type="button" data-page="<?php echo esc_attr($i); ?>" class="<?php echo $i===0?'is-active':''; ?>" aria-label="صفحه <?php echo esc_attr($i+1); ?>"></button><?php endfor;?></div><?php endif;?>
      </div>
    </section>
    <?php return ob_get_clean();
}

function alookhor_cc_category_template(){static $done=false;if($done||is_admin())return;$s=alookhor_cc_get_category_settings();if(empty($s['enabled']))return;$done=true;echo '<template id="alookhor-managed-categories-template">'.alookhor_cc_category_markup($s).'</template><noscript><style>.category-carousel-section{display:block!important}</style></noscript>';}
add_action('wp_footer','alookhor_cc_category_template',2);
add_filter('body_class',function($classes){$s=alookhor_cc_get_category_settings();if(!empty($s['enabled']))$classes[]='alookhor-mc-enabled';if(!empty($s['enabled'])&&!empty($s['hide_legacy']))$classes[]='alookhor-mc-hide-legacy';return array_values(array_unique($classes));});
add_action('wp_enqueue_scripts',function(){ $s=alookhor_cc_get_category_settings();if(empty($s['enabled']))return;wp_enqueue_style('alookhor-cc-managed-categories',ALOOKHOR_CC_URL.'assets/css/frontend-categories.css',[],ALOOKHOR_CC_BUILD);wp_enqueue_script('alookhor-cc-managed-categories',ALOOKHOR_CC_URL.'assets/js/frontend-categories.js',[],ALOOKHOR_CC_BUILD,true);wp_localize_script('alookhor-cc-managed-categories','ALOOKHOR_CATEGORIES',['endpoint'=>rest_url('alookhor-cc/v1/product-categories'),'version'=>ALOOKHOR_CC_VERSION,'hide_legacy'=>!empty($s['hide_legacy'])]);},31);
