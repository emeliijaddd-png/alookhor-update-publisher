<?php
/**
 * Managed four-card site features strip.
 *
 * Production discovery (run 31739613682) proved that the current block is the
 * external `.alookhor-trustbar-container` inside Elementor HTML widget
 * `data-id="5abd566"` and parent container `data-id="f0598d3"`. The managed
 * runtime replaces that exact root in place and does not append a parallel row.
 */
if (!defined('ABSPATH')) exit;

function alookhor_cc_site_feature_defaults(){
    return [
        'enabled'=>true,
        'hide_legacy'=>true,
        'background'=>'#0D0510',
        'card'=>'#1C1024',
        'glass'=>'rgba(33,20,38,.75)',
        'gold'=>'#D49A2E',
        'gold_light'=>'#E8B84A',
        'text'=>'#F5F3F0',
        'muted'=>'#C8C2C9',
        'radius'=>20,
        'gap'=>8,
        'items'=>[
            ['icon'=>'truck','title'=>'ارسال سریع','description'=>'در سریع‌ترین زمان ممکن'],
            ['icon'=>'organic','title'=>'محصولات ارگانیک','description'=>'100% طبیعی و سالم'],
            ['icon'=>'headset','title'=>'پشتیبانی ۲۴/۷','description'=>'همیشه در کنار شما هستیم'],
            ['icon'=>'shield','title'=>'ضمانت کیفیت','description'=>'تضمین اصالت و کیفیت کالا'],
        ],
    ];
}

function alookhor_cc_get_site_feature_settings(){
    $main=alookhor_cc_get_settings();
    $saved=is_array($main['feature_settings']??null)?$main['feature_settings']:[];
    $settings=array_replace_recursive(alookhor_cc_site_feature_defaults(),$saved);
    $defaults=alookhor_cc_site_feature_defaults()['items'];
    $items=is_array($saved['items']??null)?array_values($saved['items']):[];
    $normalized=[];
    for($index=0;$index<4;$index++){
        $candidate=is_array($items[$index]??null)?$items[$index]:[];
        $normalized[$index]=array_replace($defaults[$index],$candidate);
    }
    $settings['items']=$normalized;
    return apply_filters('alookhor_cc_site_feature_settings',$settings);
}

function alookhor_cc_site_feature_icon($name){
    $icons=[
        'truck'=>'<svg viewBox="0 0 48 48" aria-hidden="true"><path d="M5 12h25v23H5zM30 21h7l6 8v6H30z"/><circle cx="14" cy="37" r="4"/><circle cx="36" cy="37" r="4"/><path d="M9 17h15"/></svg>',
        'organic'=>'<svg viewBox="0 0 48 48" aria-hidden="true"><circle cx="24" cy="24" r="18"/><path d="m14 24 7 7 14-15"/></svg>',
        'headset'=>'<svg viewBox="0 0 48 48" aria-hidden="true"><path d="M9 36V24a15 15 0 0 1 30 0v12M9 29h6v10H9zM33 29h6v10h-6z"/><path d="M33 39c-2 3-5 4-9 4"/></svg>',
        'shield'=>'<svg viewBox="0 0 48 48" aria-hidden="true"><path d="M24 5 39 11v12c0 10-6 16-15 21C15 39 9 33 9 23V11z"/><path d="m17 24 5 5 10-11"/></svg>',
    ];
    $key=sanitize_key($name);
    return $icons[$key]??$icons['shield'];
}

function alookhor_cc_site_feature_markup($settings=null){
    $s=is_array($settings)?$settings:alookhor_cc_get_site_feature_settings();
    if(empty($s['enabled']))return '';
    $items=array_slice(array_values((array)($s['items']??[])),0,4);
    if(count($items)!==4)return '';
    $glass=preg_match('/^rgba?\([^)]*\)$/',(string)($s['glass']??''))?(string)$s['glass']:'rgba(33,20,38,.75)';
    $style=sprintf(
        '--sf-bg:%s;--sf-card:%s;--sf-glass:%s;--sf-gold:%s;--sf-gold-light:%s;--sf-text:%s;--sf-muted:%s;--sf-radius:%dpx;--sf-gap:%dpx',
        sanitize_hex_color($s['background']??'')?:'#0D0510',
        sanitize_hex_color($s['card']??'')?:'#1C1024',
        $glass,
        sanitize_hex_color($s['gold']??'')?:'#D49A2E',
        sanitize_hex_color($s['gold_light']??'')?:'#E8B84A',
        sanitize_hex_color($s['text']??'')?:'#F5F3F0',
        sanitize_hex_color($s['muted']??'')?:'#C8C2C9',
        max(10,min(30,absint($s['radius']??20))),
        max(0,min(20,absint($s['gap']??8)))
    );
    ob_start();
    // نمایش صحیح داخل Elementor Editor حتی وقتی شورت‌کد پس از wp_head رندر می‌شود.
    static $inline_style_printed=false;
    if(!$inline_style_printed){$inline_style_printed=true;$css_file=ALOOKHOR_CC_DIR.'assets/css/frontend-features.css';if(file_exists($css_file))echo '<style id="alookhor-features-inline">'.file_get_contents($css_file).'</style>';}
    ?>
    <section id="alookhor-managed-features" class="alookhor-sf" dir="rtl" style="<?php echo esc_attr($style); ?>" data-version="<?php echo esc_attr(ALOOKHOR_CC_VERSION); ?>" data-item-count="4" aria-label="ویژگی‌های آلوخور">
      <div class="alookhor-sf-shell">
        <div class="alookhor-sf-grid">
          <?php foreach($items as $index=>$item): ?>
          <article class="alookhor-sf-card" data-feature="<?php echo esc_attr($index); ?>">
            <span class="alookhor-sf-icon"><?php echo alookhor_cc_site_feature_icon($item['icon']??'shield'); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></span>
            <div class="alookhor-sf-copy"><h3><?php echo esc_html($item['title']??''); ?></h3><p><?php echo esc_html($item['description']??''); ?></p></div>
          </article>
          <?php endforeach; ?>
        </div>
      </div>
    </section>
    <?php return ob_get_clean();
}

function alookhor_cc_site_feature_shortcode(){
    if(!empty($GLOBALS['alookhor_cc_site_feature_shortcode_rendered']))return '';
    $settings=alookhor_cc_get_site_feature_settings();
    if(empty($settings['enabled']))return '';
    $GLOBALS['alookhor_cc_site_feature_shortcode_rendered']=true;
    return alookhor_cc_site_feature_markup($settings);
}
add_shortcode('alookhor_managed_features','alookhor_cc_site_feature_shortcode');

function alookhor_cc_site_feature_template(){
    static $done=false;
    if($done||is_admin()||!is_front_page()||!empty($GLOBALS['alookhor_cc_site_feature_shortcode_rendered']))return;
    $settings=alookhor_cc_get_site_feature_settings();
    if(empty($settings['enabled']))return;
    $done=true;
    echo '<template id="alookhor-managed-features-template">'.alookhor_cc_site_feature_markup($settings).'</template>';
    echo '<noscript><style>body.alookhor-sf-hide-legacy .alookhor-trustbar-container{display:block!important}</style></noscript>';
}
add_action('wp_footer','alookhor_cc_site_feature_template',2);

add_filter('body_class',function($classes){
    $settings=alookhor_cc_get_site_feature_settings();
    if(!empty($settings['enabled']))$classes[]='alookhor-sf-enabled';
    if(!empty($settings['enabled'])&&!empty($settings['hide_legacy']))$classes[]='alookhor-sf-hide-legacy';
    return array_values(array_unique($classes));
});

add_action('wp_enqueue_scripts',function(){
    if(!is_front_page())return;
    $settings=alookhor_cc_get_site_feature_settings();
    if(empty($settings['enabled']))return;
    wp_enqueue_style('alookhor-cc-managed-features',ALOOKHOR_CC_URL.'assets/css/frontend-features.css',[],ALOOKHOR_CC_BUILD);
    wp_enqueue_script('alookhor-cc-managed-features',ALOOKHOR_CC_URL.'assets/js/frontend-features.js',[],ALOOKHOR_CC_BUILD,true);
    wp_localize_script('alookhor-cc-managed-features','ALOOKHOR_FEATURES',[
        'endpoint'=>rest_url('alookhor-cc/v1/site-features'),
        'version'=>ALOOKHOR_CC_VERSION,
        'hide_legacy'=>!empty($settings['hide_legacy']),
        'legacy_selector'=>'.alookhor-trustbar-container',
    ]);
},31);
