<?php
if(!defined('ABSPATH')) exit;

/**
 * ALOOKHOR Product Seeder v3.10.251
 * Creates 5 full-featured WooCommerce variable products with 3 weights (3/5/10 kg)
 * - کشمش پلویی طلایی ممتاز
 * - آلو بخارایی آفتابی نیشابور شیرین
 * - لواشک خانگی چند میوه ممتاز
 * - گردو با پوست کاغذی تویسرکان ممتاز
 * - آلو بخارا جنگلی ترش ارگانیک
 * Each with short/long desc, attributes, variations, prices, stock, images, categories, tags, upsells, etc.
 */

if(!function_exists('alookhor_cc_ensure_product_category')){
function alookhor_cc_ensure_product_category($name, $slug, $parent=0){
    $term = term_exists($slug, 'product_cat');
    if($term){
        $tid = is_array($term) ? (int)$term['term_id'] : (int)$term;
        return $tid;
    }
    $res = wp_insert_term($name, 'product_cat', ['slug'=>$slug, 'parent'=>$parent]);
    if(is_wp_error($res)) return 0;
    return (int)$res['term_id'];
}
}

if(!function_exists('alookhor_cc_ensure_product_attribute')){
function alookhor_cc_ensure_product_attribute($label, $name){
    // $name without pa_ prefix, e.g., 'vazn'
    $slug = 'pa_'.$name;
    if(function_exists('wc_get_attribute_taxonomies')){
        $taxonomies = wc_get_attribute_taxonomies();
        foreach($taxonomies as $tax){
            if($tax->attribute_name === $name){
                // ensure taxonomy exists
                if(!taxonomy_exists($slug)){
                    register_taxonomy($slug, ['product'], ['label'=>$label, 'hierarchical'=>false, 'public'=>false]);
                }
                return $slug;
            }
        }
        // create new attribute
        if(function_exists('wc_create_attribute')){
            $args = [
                'name'=>$label,
                'slug'=>$name,
                'type'=>'select',
                'order_by'=>'menu_order',
                'has_archives'=>false,
            ];
            $id = wc_create_attribute($args);
            if(is_wp_error($id)){
                // fallback: direct insert
            } else {
                // register taxonomy
                register_taxonomy($slug, ['product'], ['label'=>$label, 'hierarchical'=>false]);
                // flush
                delete_transient('wc_attribute_taxonomies');
                // create table entry if needed via WC
                if(function_exists('wc_delete_attribute_transients')) wc_delete_attribute_transients();
            }
        }
    }
    if(!taxonomy_exists($slug)){
        register_taxonomy($slug, ['product'], ['label'=>$label, 'hierarchical'=>false, 'public'=>false, 'show_ui'=>false]);
    }
    return $slug;
}
}

if(!function_exists('alookhor_cc_ensure_attribute_terms')){
function alookhor_cc_ensure_attribute_terms($taxonomy, $terms){
    // $terms = ['3 کیلویی' => '3-kg', ...] or simple array
    $ids = [];
    foreach($terms as $name => $slug){
        if(is_int($name)){
            $name = $slug;
            $slug = sanitize_title($name);
        }
        $term = term_exists($name, $taxonomy);
        if(!$term){
            $term = term_exists($slug, $taxonomy);
        }
        if($term){
            $tid = is_array($term) ? (int)$term['term_id'] : (int)$term;
            $ids[$name] = $tid;
            continue;
        }
        $res = wp_insert_term($name, $taxonomy, ['slug'=>$slug]);
        if(is_wp_error($res)){
            // try get again
            $term2 = term_exists($name, $taxonomy);
            if($term2){
                $tid = is_array($term2) ? (int)$term2['term_id'] : (int)$term2;
                $ids[$name] = $tid;
            }
            continue;
        }
        $ids[$name] = (int)$res['term_id'];
    }
    return $ids;
}
}

if(!function_exists('alookhor_cc_sideload_image_from_assets')){
function alookhor_cc_sideload_image_from_assets($filename, $product_id=0){
    $src = ALOOKHOR_CC_DIR . 'assets/images/' . $filename;
    if(!file_exists($src)){
        // try other locations
        $alt = WP_CONTENT_DIR . '/uploads/2026/08/' . $filename;
        if(file_exists($alt)) $src = $alt;
        else return 0;
    }
    $upload = wp_upload_dir();
    $dest_filename = wp_unique_filename($upload['path'], $filename);
    $dest = $upload['path'] . '/' . $dest_filename;
    if(!@copy($src, $dest)){
        return 0;
    }
    $filetype = wp_check_filetype($dest_filename, null);
    $attachment = [
        'post_mime_type' => $filetype['type'],
        'post_title' => sanitize_file_name(pathinfo($dest_filename, PATHINFO_FILENAME)),
        'post_content' => '',
        'post_status' => 'inherit',
    ];
    $attach_id = wp_insert_attachment($attachment, $dest, $product_id);
    if(is_wp_error($attach_id) || !$attach_id){
        return 0;
    }
    require_once ABSPATH . 'wp-admin/includes/image.php';
    $attach_data = wp_generate_attachment_metadata($attach_id, $dest);
    wp_update_attachment_metadata($attach_id, $attach_data);
    return (int)$attach_id;
}
}

if(!function_exists('alookhor_cc_seed_products')){
function alookhor_cc_seed_products($force=false){
    if(!function_exists('wc_get_product') || !function_exists('wc_create_attribute')){
        return ['error'=>'WooCommerce not active'];
    }
    if(!$force && get_option('alookhor_cc_products_seeded_v251')){
        return ['skipped'=>'already seeded, use force'];
    }

    // Ensure categories
    $cat_khoshkbar = alookhor_cc_ensure_product_category('خشکبار', 'khoshkbar');
    $cat_keshmesh = alookhor_cc_ensure_product_category('کشمش', 'keshmesh', $cat_khoshkbar);
    $cat_aloo = alookhor_cc_ensure_product_category('آلو خشکبار', 'aloo-khoshkbar', $cat_khoshkbar);
    $cat_aloo_bokhara = alookhor_cc_ensure_product_category('آلو بخارا', 'aloo-bokhara', $cat_aloo);
    $cat_lavashak = alookhor_cc_ensure_product_category('لواشک', 'lavashak', $cat_khoshkbar);
    $cat_gerdu = alookhor_cc_ensure_product_category('گردو', 'gerdu', $cat_khoshkbar);
    $cat_tanabolat = alookhor_cc_ensure_product_category('تنقلات طبیعی', 'tanabolat-tabiei');

    // Ensure attribute pa_vazn
    $attr_vazn_tax = alookhor_cc_ensure_product_attribute('وزن', 'vazn');
    // Ensure terms for vazn
    $vazn_terms = [
        '3 کیلویی' => '3-kg',
        '5 کیلویی' => '5-kg',
        '10 کیلویی' => '10-kg',
    ];
    $vazn_term_ids = alookhor_cc_ensure_attribute_terms($attr_vazn_tax, $vazn_terms);
    // Additional attributes: ta'm, mantaghe, bastebandi, mandegari
    $attr_tam_tax = alookhor_cc_ensure_product_attribute('طعم', 'tam');
    $attr_mantaghe_tax = alookhor_cc_ensure_product_attribute('منطقه تولید', 'mantaghe');
    $attr_baste_tax = alookhor_cc_ensure_product_attribute('نوع بسته‌بندی', 'bastebandi');
    $attr_mandegari_tax = alookhor_cc_ensure_product_attribute('ماندگاری', 'mandegari');

    alookhor_cc_ensure_attribute_terms($attr_tam_tax, ['شیرین'=>'shirin', 'ترش و شیرین'=>'torsh-shirin', 'ترش'=>'torsh', 'ملس'=>'males']);
    alookhor_cc_ensure_attribute_terms($attr_mantaghe_tax, ['خراسان'=>'khorasan', 'نیشابور'=>'neishabur', 'تویسرکان'=>'toyserkan', 'شمال ایران'=>'shomal-iran', 'زبرخان'=>'zebarkhan']);
    alookhor_cc_ensure_attribute_terms($attr_baste_tax, ['پاکت زیپ‌دار بهداشتی'=>'zip-bag', 'کارتن صادراتی'=>'carton-export', 'ظرف پت بهداشتی'=>'pet-container']);
    alookhor_cc_ensure_attribute_terms($attr_mandegari_tax, ['12 ماه'=>'12-mah', '18 ماه'=>'18-mah']);

    // Product definitions
    $products = [
        [
            'name'=>'کشمش پلویی طلایی ممتاز',
            'slug'=>'keshmesh-poloei-talaei-momtaz',
            'sku_base'=>'AKH-KESH-001',
            'cats'=>[$cat_keshmesh, $cat_khoshkbar],
            'tags'=>['کشمش','پلویی','طلایی','ممتاز','طبیعی','خشکبار','صادراتی'],
            'image'=>'bowl.jpg',
            'gallery'=>['category-nuts.jpg','assortment.jpg'],
            'short'=>'کشمش پلویی طلایی ممتاز آلوخور، از بهترین انگورهای بی‌دانه خراسان، با رنگ طلایی درخشان و طعم شیرین طبیعی، مناسب برای پلو، شیرینی، دسر و میان‌وعده سالم. بدون مواد نگهدارنده و شکر افزوده.',
            'long'=>'
<h2>درباره کشمش پلویی طلایی ممتاز</h2>
<p>کشمش پلویی طلایی ممتاز آلوخور از انگورهای بی‌دانه و شیرین باغات خراسان تهیه شده است. دانه‌های یکدست، نرم و طلایی با عطر طبیعی انگور تازه، این محصول را به انتخابی ممتاز برای آشپزی ایرانی و پذیرایی تبدیل کرده است.</p>
<p>ما در آلوخور، خوشه‌های رسیده را در آفتاب ملایم خشک می‌کنیم تا رنگ طلایی طبیعی و بافت نرم حفظ شود. هیچ گوگرد اضافی یا شکر افزوده‌ای استفاده نمی‌شود؛ فقط طعم اصیل انگور.</p>
<h3>ویژگی‌های کشمش پلویی آلوخور</h3>
<ul>
<li>۱۰۰٪ طبیعی، بدون مواد نگهدارنده و بدون روغن</li>
<li>دانه‌های درشت، یکدست و بی‌دانه</li>
<li>رنگ طلایی طبیعی و طعم شیرین ملس</li>
<li>مناسب پلو، عدس‌پلو، شیرینی، کیک و دسر</li>
<li>سرشار از آهن، فیبر و انرژی طبیعی</li>
</ul>
<h3>ارزش غذایی در هر 100 گرم</h3>
<p>انرژی 299 کیلوکالری، کربوهیدرات 79 گرم، فیبر 3.7 گرم، آهن 1.8 میلی‌گرم، پتاسیم 749 میلی‌گرم.</p>
<h3>روش نگهداری</h3>
<p>در جای خشک و خنک، دور از نور مستقیم نگهداری کنید. پس از باز کردن درب پاکت را کامل ببندید. برای ماندگاری بیشتر می‌توانید در یخچال نگهداری کنید.</p>
<h3>روش مصرف پیشنهادی</h3>
<p>به عنوان میان‌وعده همراه با گردو و بادام، در پلوهای مجلسی، در تهیه شله‌زرد، کیک کشمشی و کوکی.</p>
',
            'attrs'=>[
                $attr_tam_tax=>'شیرین',
                $attr_mantaghe_tax=>'خراسان',
                $attr_baste_tax=>'پاکت زیپ‌دار بهداشتی',
                $attr_mandegari_tax=>'12 ماه',
            ],
            'variations'=>[
                ['vazn'=>'3 کیلویی','weight'=>3,'regular'=>450000,'sale'=>390000,'stock'=>120],
                ['vazn'=>'5 کیلویی','weight'=>5,'regular'=>720000,'sale'=>650000,'stock'=>85],
                ['vazn'=>'10 کیلویی','weight'=>10,'regular'=>1380000,'sale'=>1250000,'stock'=>50],
            ],
            'weight'=>3,
            'featured'=>true,
        ],
        [
            'name'=>'آلو بخارایی آفتابی نیشابور شیرین',
            'slug'=>'aloo-bokharai-aftabi-neishabur-shirin',
            'sku_base'=>'AKH-ALOO-002',
            'cats'=>[$cat_aloo_bokhara, $cat_aloo],
            'tags'=>['آلو بخارایی','نیشابور','آفتابی','شیرین','خشکبار','ممتاز'],
            'image'=>'about.jpg',
            'gallery'=>['single.jpg','bowl.jpg'],
            'short'=>'آلو بخارایی آفتابی نیشابور، شیرین و ملس با بافت نرم و گوشتی، خشک‌شده در آفتاب ملایم خراسان، بدون شکر افزوده و مواد نگهدارنده. انتخابی عالی برای میان‌وعده، دسر و پذیرایی مجلسی.',
            'long'=>'
<h2>درباره آلو بخارایی آفتابی نیشابور</h2>
<p>آلو بخارایی آفتابی نیشابور از ارقام کمیاب و خوش‌طعم منطقه نیشابور است که به دلیل طعم شیرین، بافت ملس و گوشت فراوان، محبوب‌ترین آلو برای پذیرایی و آشپزی محسوب می‌شود.</p>
<p>آلوها پس از برداشت دستی، در سایه و آفتاب ملایم خشک می‌شوند تا رنگ قهوه‌ای روشن و عطر طبیعی حفظ شود. هیچ رنگ یا اسانس مصنوعی افزوده نمی‌شود.</p>
<h3>ویژگی‌های آلو بخارایی آلوخور</h3>
<ul>
<li>بافت نرم، گوشتی و ملس با طعم شیرین طبیعی</li>
<li>خشک‌شده به روش آفتابی، بدون دود و گوگرد</li>
<li>سرشار از فیبر، پتاسیم و آنتی‌اکسیدان</li>
<li>مناسب برای خورشت آلو، دسر، ترشی و میان‌وعده</li>
<li>بسته‌بندی بهداشتی زیپ‌دار و کارتن صادراتی</li>
</ul>
<h3>روش مصرف</h3>
<p>به عنوان میان‌وعده سالم، در تهیه خورشت مرغ و آلو، در دسرها و کیک‌ها، یا همراه با چای به عنوان شیرینی طبیعی.</p>
<h3>شرایط نگهداری</h3>
<p>در جای خشک و خنک، دور از نور مستقیم. پس از باز کردن، درب را محکم ببندید. برای ماندگاری 12 ماهه در یخچال نگهداری کنید.</p>
',
            'attrs'=>[
                $attr_tam_tax=>'شیرین',
                $attr_mantaghe_tax=>'نیشابور',
                $attr_baste_tax=>'کارتن صادراتی',
                $attr_mandegari_tax=>'12 ماه',
            ],
            'variations'=>[
                ['vazn'=>'3 کیلویی','weight'=>3,'regular'=>520000,'sale'=>450000,'stock'=>100],
                ['vazn'=>'5 کیلویی','weight'=>5,'regular'=>850000,'sale'=>760000,'stock'=>70],
                ['vazn'=>'10 کیلویی','weight'=>10,'regular'=>1650000,'sale'=>1480000,'stock'=>40],
            ],
            'weight'=>3,
            'featured'=>true,
        ],
        [
            'name'=>'لواشک خانگی چند میوه ممتاز ترش و شیرین',
            'slug'=>'lavashak-khanegi-chand-miveh-momtaz',
            'sku_base'=>'AKH-LAVA-003',
            'cats'=>[$cat_lavashak, $cat_tanabolat],
            'tags'=>['لواشک','خانگی','چند میوه','ترش و شیرین','طبیعی','تنقلات'],
            'image'=>'sack.jpg',
            'gallery'=>['assortment.jpg','bowl.jpg'],
            'short'=>'لواشک خانگی چند میوه ممتاز آلوخور، ترکیبی از آلو، زردآلو، سیب و انار با طعم ترش و شیرین متعادل، ورقه‌های نازک و بافت نرم، بدون رنگ و اسانس مصنوعی. نوستالژی اصیل ایرانی.',
            'long'=>'
<h2>درباره لواشک خانگی چند میوه</h2>
<p>لواشک خانگی چند میوه آلوخور با دستور سنتی و از میوه‌های تازه فصل تهیه می‌شود. ترکیبی از آلوچه، زردآلو، سیب، انار و کمی آلو بخارا که طعمی ترش و شیرین و بسیار خوشایند ایجاد می‌کند.</p>
<p>ورقه‌های لواشک به صورت نازک پهن و در خشک‌کن بهداشتی با دمای کنترل‌شده خشک می‌شوند تا ویتامین‌ها و رنگ طبیعی میوه حفظ شود.</p>
<h3>ویژگی‌های لواشک آلوخور</h3>
<ul>
<li>تهیه شده از میوه‌های تازه و طبیعی، بدون رنگ مصنوعی</li>
<li>بافت نرم، ورقه‌ای و به راحتی قابل جدا شدن</li>
<li>طعم ترش و شیرین متعادل، مناسب تمام سنین</li>
<li>بسته‌بندی بهداشتی سلفونی و پاکت زیپ‌دار</li>
<li>بدون شکر افزوده زیاد، شیرینی طبیعی میوه</li>
</ul>
<h3>ارزش غذایی</h3>
<p>سرشار از فیبر، ویتامین C، پتاسیم و آنتی‌اکسیدان‌های طبیعی میوه.</p>
<h3>روش نگهداری و مصرف</h3>
<p>در جای خنک و خشک نگهداری شود. پس از باز کردن در یخچال قرار دهید. به عنوان تنقلات، همراه با آجیل یا به صورت رول شده سرو کنید.</p>
',
            'attrs'=>[
                $attr_tam_tax=>'ترش و شیرین',
                $attr_mantaghe_tax=>'شمال ایران',
                $attr_baste_tax=>'ظرف پت بهداشتی',
                $attr_mandegari_tax=>'12 ماه',
            ],
            'variations'=>[
                ['vazn'=>'3 کیلویی','weight'=>3,'regular'=>380000,'sale'=>320000,'stock'=>150],
                ['vazn'=>'5 کیلویی','weight'=>5,'regular'=>600000,'sale'=>520000,'stock'=>90],
                ['vazn'=>'10 کیلویی','weight'=>10,'regular'=>1150000,'sale'=>980000,'stock'=>60],
            ],
            'weight'=>3,
            'featured'=>false,
        ],
        [
            'name'=>'گردو با پوست کاغذی تویسرکان ممتاز',
            'slug'=>'gerdu-kaghazi-toyserkan-momtaz',
            'sku_base'=>'AKH-GERD-004',
            'cats'=>[$cat_gerdu, $cat_khoshkbar],
            'tags'=>['گردو','کاغذی','تویسرکان','ممتاز','خشکبار','مغز سفید'],
            'image'=>'category-nuts.jpg',
            'gallery'=>['footer-prunes.png','bowl.jpg'],
            'short'=>'گردو با پوست کاغذی تویسرکان، با مغز سفید، چرب و خوش‌طعم، پوست نازک به راحتی قابل شکستن، برداشت امسال، سورت شده و درجه یک صادراتی. سرشار از امگا 3 و انرژی.',
            'long'=>'
<h2>درباره گردو کاغذی تویسرکان</h2>
<p>گردو کاغذی تویسرکان به دلیل پوست نازک، مغز درشت و سفید و طعم کره‌ای خود، مشهورترین گردو ایران است. باغات تویسرکان در ارتفاعات زاگرس، بهترین شرایط برای تولید گردوی ارگانیک و با کیفیت را دارند.</p>
<p>گردوهای آلوخور پس از برداشت، پوست‌گیری، شستشو و خشک‌شدن در سایه، به صورت دستی سورت می‌شوند تا فقط گردوهای سالم، درشت و بدون لک بسته‌بندی شوند.</p>
<h3>ویژگی‌های گردو آلوخور</h3>
<ul>
<li>پوست کاغذی نازک، به راحتی با دست قابل شکستن</li>
<li>مغز سفید، درشت، چرب و خوش‌طعم</li>
<li>برداشت امسال، تازه و بدون بوی کهنگی</li>
<li>سرشار از امگا 3، پروتئین، فیبر و آنتی‌اکسیدان</li>
<li>مناسب مصرف روزانه، آجیل، شیرینی و روغن‌گیری</li>
</ul>
<h3>ارزش غذایی در هر 100 گرم مغز</h3>
<p>انرژی 654 کیلوکالری، چربی 65 گرم (امگا 3 فراوان)، پروتئین 15 گرم، فیبر 7 گرم.</p>
<h3>روش نگهداری</h3>
<p>در جای خشک و خنک و دور از نور مستقیم نگهداری کنید. برای ماندگاری 12 تا 18 ماهه، در یخچال یا فریزر در ظرف دربسته نگهداری شود.</p>
',
            'attrs'=>[
                $attr_tam_tax=>'ملس',
                $attr_mantaghe_tax=>'تویسرکان',
                $attr_baste_tax=>'کارتن صادراتی',
                $attr_mandegari_tax=>'12 ماه',
            ],
            'variations'=>[
                ['vazn'=>'3 کیلویی','weight'=>3,'regular'=>780000,'sale'=>690000,'stock'=>80],
                ['vazn'=>'5 کیلویی','weight'=>5,'regular'=>1250000,'sale'=>1100000,'stock'=>55],
                ['vazn'=>'10 کیلویی','weight'=>10,'regular'=>2400000,'sale'=>2150000,'stock'=>30],
            ],
            'weight'=>3,
            'featured'=>true,
        ],
        [
            'name'=>'آلو بخارا جنگلی ترش ارگانیک',
            'slug'=>'aloo-bokhara-jangali-torsh-organic',
            'sku_base'=>'AKH-ALOO-005',
            'cats'=>[$cat_aloo_bokhara, $cat_aloo],
            'tags'=>['آلو بخارا','جنگلی','ترش','ارگانیک','طبیعی','خشکبار'],
            'image'=>'assortment.jpg',
            'gallery'=>['about.jpg','single.jpg'],
            'short'=>'آلو بخارا جنگلی ترش ارگانیک، از جنگل‌های شمال ایران، با طعم ترش اصیل و بافت سفت و گوشتی، بدون سم و کود شیمیایی، مناسب برای خورشت، لواشک و ترشیجات طبیعی.',
            'long'=>'
<h2>درباره آلو بخارا جنگلی ترش</h2>
<p>آلو بخارا جنگلی از درختان خودرو در جنگل‌های هیرکانی شمال ایران برداشت می‌شود. به دلیل رشد طبیعی بدون دخالت انسان، کاملاً ارگانیک و عاری از سموم شیمیایی است. طعم ترش قوی و عطر جنگلی آن، این آلو را برای خورشت‌های ترش و ترشیجات بسیار محبوب کرده است.</p>
<p>آلوها به روش سنتی در آفتاب خشک می‌شوند تا رنگ تیره و طعم ترش آن حفظ شود. هیچ شکر یا افزودنی ندارد.</p>
<h3>ویژگی‌های آلو جنگلی آلوخور</h3>
<ul>
<li>100٪ ارگانیک، بدون سم و کود شیمیایی</li>
<li>طعم ترش اصیل و عطر جنگلی طبیعی</li>
<li>بافت سفت و گوشتی، مناسب پخت طولانی</li>
<li>سرشار از فیبر، آهن و ویتامین‌های گروه B</li>
<li>مناسب برای خورشت آلو، فسنجان، لواشک ترش و دمنوش</li>
</ul>
<h3>روش مصرف پیشنهادی</h3>
<p>برای خورشت‌ها از شب قبل خیس کنید. به عنوان چاشنی ترش در خوراک‌ها، یا به صورت دمنوش ترش همراه با عسل.</p>
<h3>شرایط نگهداری</h3>
<p>در جای خشک و خنک و دور از رطوبت نگهداری شود. ماندگاری 12 ماه در بسته‌بندی زیپ‌دار.</p>
',
            'attrs'=>[
                $attr_tam_tax=>'ترش',
                $attr_mantaghe_tax=>'شمال ایران',
                $attr_baste_tax=>'پاکت زیپ‌دار بهداشتی',
                $attr_mandegari_tax=>'12 ماه',
            ],
            'variations'=>[
                ['vazn'=>'3 کیلویی','weight'=>3,'regular'=>480000,'sale'=>420000,'stock'=>110],
                ['vazn'=>'5 کیلویی','weight'=>5,'regular'=>770000,'sale'=>680000,'stock'=>75],
                ['vazn'=>'10 کیلویی','weight'=>10,'regular'=>1480000,'sale'=>1320000,'stock'=>45],
            ],
            'weight'=>3,
            'featured'=>false,
        ],
    ];

    $created = [];
    $updated = [];

    foreach($products as $p){
        // Check if product exists by slug
        $existing = get_page_by_path($p['slug'], OBJECT, 'product');
        $product_id = 0;
        $is_new = true;
        if($existing){
            $product_id = (int)$existing->ID;
            $is_new = false;
        }

        // Create/update product post
        $post_data = [
            'post_title'=>$p['name'],
            'post_name'=>$p['slug'],
            'post_content'=>$p['long'],
            'post_excerpt'=>$p['short'],
            'post_status'=>'publish',
            'post_type'=>'product',
        ];
        if($product_id){
            $post_data['ID'] = $product_id;
            $res = wp_update_post($post_data, true);
            if(is_wp_error($res)) continue;
        } else {
            $product_id = wp_insert_post($post_data, true);
            if(is_wp_error($product_id) || !$product_id) continue;
        }

        // Set product type to variable
        wp_set_object_terms($product_id, 'variable', 'product_type');

        // Set categories
        if(!empty($p['cats'])){
            wp_set_object_terms($product_id, array_map('intval', $p['cats']), 'product_cat');
        }
        // Set tags
        if(!empty($p['tags'])){
            wp_set_object_terms($product_id, $p['tags'], 'product_tag');
        }

        // Handle images
        $thumb_id = 0;
        if(!empty($p['image'])){
            // Check if already has thumbnail and we are updating, keep existing unless forced
            $existing_thumb = get_post_thumbnail_id($product_id);
            if(!$existing_thumb || $force){
                $thumb_id = alookhor_cc_sideload_image_from_assets($p['image'], $product_id);
                if($thumb_id){
                    set_post_thumbnail($product_id, $thumb_id);
                }
            } else {
                $thumb_id = $existing_thumb;
            }
        }
        $gallery_ids = [];
        if(!empty($p['gallery'])){
            foreach($p['gallery'] as $gimg){
                $gid = alookhor_cc_sideload_image_from_assets($gimg, $product_id);
                if($gid) $gallery_ids[] = $gid;
            }
            if($gallery_ids){
                update_post_meta($product_id, '_product_image_gallery', implode(',', $gallery_ids));
            }
        }

        // Set product attributes for variable
        $product_attributes = [];

        // pa_vazn - used for variations
        $product_attributes[$attr_vazn_tax] = [
            'name'=>$attr_vazn_tax,
            'value'=>'',
            'position'=>0,
            'is_visible'=>1,
            'is_variation'=>1,
            'is_taxonomy'=>1,
        ];

        $pos = 1;
        foreach($p['attrs'] as $tax => $val){
            $product_attributes[$tax] = [
                'name'=>$tax,
                'value'=>'',
                'position'=>$pos++,
                'is_visible'=>1,
                'is_variation'=>0,
                'is_taxonomy'=>1,
            ];
            // set term for product
            wp_set_object_terms($product_id, [$val], $tax, true);
        }
        // Also set vazn terms for product
        $vazn_names = array_keys($vazn_terms); // 3 کیلویی etc.
        wp_set_object_terms($product_id, $vazn_names, $attr_vazn_tax, false);

        update_post_meta($product_id, '_product_attributes', $product_attributes);

        // Set other meta for variable product
        update_post_meta($product_id, '_visibility', 'visible');
        update_post_meta($product_id, '_stock_status', 'instock');
        update_post_meta($product_id, '_manage_stock', 'no');
        update_post_meta($product_id, '_featured', $p['featured'] ? 'yes' : 'no');
        update_post_meta($product_id, '_weight', '');
        update_post_meta($product_id, '_length', '');
        update_post_meta($product_id, '_width', '');
        update_post_meta($product_id, '_height', '');
        update_post_meta($product_id, '_sku', $p['sku_base']);
        update_post_meta($product_id, '_regular_price', '');
        update_post_meta($product_id, '_sale_price', '');
        update_post_meta($product_id, '_price', '');
        // SEO - Yoast/RankMath
        update_post_meta($product_id, '_yoast_wpseo_title', $p['name'] . ' - خرید عمده و خرده - آلوخور');
        update_post_meta($product_id, '_yoast_wpseo_metadesc', mb_substr($p['short'],0,155));
        update_post_meta($product_id, 'rank_math_title', $p['name'] . ' | آلوخور');
        update_post_meta($product_id, 'rank_math_description', mb_substr($p['short'],0,160));

        // Create variations
        // First delete existing variations if force
        if($force){
            $existing_vars = get_children(['post_parent'=>$product_id, 'post_type'=>'product_variation', 'post_status'=>['publish','private']]);
            foreach($existing_vars as $ev){
                wp_delete_post($ev->ID, true);
            }
        }

        // Get existing variations to avoid duplicates if not force
        $existing_variations = [];
        if(!$force){
            $vars = get_children(['post_parent'=>$product_id, 'post_type'=>'product_variation']);
            foreach($vars as $v){
                $existing_variations[] = get_post_meta($v->ID, 'attribute_'.$attr_vazn_tax, true);
            }
        }

        foreach($p['variations'] as $var){
            $term_slug = $vazn_terms[$var['vazn']] ?? sanitize_title($var['vazn']);
            $term_name = $var['vazn'];
            // Check if already exists
            if(in_array($term_slug, $existing_variations, true) && !$force){
                continue;
            }
            $variation_post = [
                'post_title'=>'Variation for '.$product_id.' - '.$term_name,
                'post_name'=>'product-'.$product_id.'-variation-'.$term_slug,
                'post_status'=>'publish',
                'post_parent'=>$product_id,
                'post_type'=>'product_variation',
                'menu_order'=>0,
            ];
            $var_id = wp_insert_post($variation_post);
            if(is_wp_error($var_id) || !$var_id) continue;

            // Set variation attributes
            update_post_meta($var_id, 'attribute_'.$attr_vazn_tax, $term_slug);

            // Prices - WooCommerce stores prices as string, in base currency (probably IRR, but we use toman-like numbers)
            // We use numbers as given, WooCommerce will handle
            update_post_meta($var_id, '_regular_price', (string)$var['regular']);
            update_post_meta($var_id, '_sale_price', (string)$var['sale']);
            update_post_meta($var_id, '_price', (string)$var['sale']); // current price is sale
            update_post_meta($var_id, '_sku', $p['sku_base'].'-'.strtoupper($term_slug));
            update_post_meta($var_id, '_stock_status', 'instock');
            update_post_meta($var_id, '_manage_stock', 'yes');
            update_post_meta($var_id, '_stock', (string)$var['stock']);
            update_post_meta($var_id, '_weight', (string)$var['weight']);
            update_post_meta($var_id, '_virtual', 'no');
            update_post_meta($var_id, '_downloadable', 'no');

            // Set variation image if available (use thumb)
            if($thumb_id){
                update_post_meta($var_id, '_thumbnail_id', $thumb_id);
            }
        }

        // Set default attributes (first variation)
        $default_attrs = [
            $attr_vazn_tax => $vazn_terms[$p['variations'][0]['vazn']] ?? '3-kg',
        ];
        update_post_meta($product_id, '_default_attributes', $default_attrs);

        // Sync variable product prices (min/max)
        if(function_exists('WC_Product_Variable')){
            $product_obj = wc_get_product($product_id);
            if($product_obj){
                // This will sync
                WC_Product_Variable::sync($product_id);
            }
        }

        if($is_new) $created[] = $product_id;
        else $updated[] = $product_id;
    }

    update_option('alookhor_cc_products_seeded_v251', time());
    return ['created'=>$created, 'updated'=>$updated, 'count'=>count($created)+count($updated)];
}
}

// Admin trigger via ?alookhor_seed_products=1
add_action('admin_init', function(){
    if(!current_user_can('manage_options')) return;
    if(!isset($_GET['alookhor_seed_products'])) return;
    if(!wp_verify_nonce($_GET['_wpnonce'] ?? '', 'alookhor_seed')){
        wp_die('Nonce invalid');
    }
    $force = !empty($_GET['force']);
    $res = alookhor_cc_seed_products($force);
    // Redirect with message
    $url = admin_url('admin.php?page=alookhor-control-center&seeded=1');
    if(!empty($res['created'])) $url .= '&created='.count($res['created']);
    if(!empty($res['updated'])) $url .= '&updated='.count($res['updated']);
    wp_redirect($url);
    exit;
});

// AJAX trigger for control center
add_action('wp_ajax_alookhor_cc_seed_products', function(){
    if(!current_user_can('manage_options')) wp_send_json_error(['message'=>'دسترسی ندارید']);
    check_ajax_referer('alookhor_cc_seed','nonce');
    $force = !empty($_POST['force']);
    $res = alookhor_cc_seed_products($force);
    wp_send_json_success($res);
});

// Auto-seed on first load after deploy (if not seeded) - runs on init with lock to avoid race
add_action('init', function(){
    if(get_option('alookhor_cc_products_seeded_v251')) return;
    if(!function_exists('wc_get_product')) return;
    // Only auto-seed on admin or REST or cron to avoid frontend performance hit, but also allow one frontend hit after deploy
    // Use transient lock 60s
    if(get_transient('alookhor_cc_seeding_lock')) return;
    // Check if we are in a context where seeding makes sense (admin, REST, or ?alookhor_auto_seed=1)
    $is_auto_context = is_admin() || (defined('REST_REQUEST') && REST_REQUEST) || defined('DOING_CRON') || isset($_GET['alookhor_auto_seed']);
    // Also allow one-time frontend seeding after deploy if ?seed query present or first 24h after version bump
    // For simplicity, allow any init within 5 minutes after plugin version change
    $last_version = get_option('alookhor_cc_last_version');
    if($last_version !== ALOOKHOR_CC_VERSION){
        update_option('alookhor_cc_last_version', ALOOKHOR_CC_VERSION);
        $is_auto_context = true; // force on version change
    }
    if(!$is_auto_context) return;
    set_transient('alookhor_cc_seeding_lock', 1, 120);
    // Don't block request, schedule async if possible, else run directly
    if(function_exists('wp_schedule_single_event') && !wp_next_scheduled('alookhor_cc_async_seed')){
        wp_schedule_single_event(time()+5, 'alookhor_cc_async_seed');
    } else {
        // fallback direct
        alookhor_cc_seed_products(false);
    }
}, 100);

add_action('alookhor_cc_async_seed', function(){
    alookhor_cc_seed_products(false);
    delete_transient('alookhor_cc_seeding_lock');
});

// REST endpoint to trigger seeding externally (authenticated)
add_action('rest_api_init', function(){
    register_rest_route('alookhor-cc/v1', '/seed-products', [
        'methods'=>'POST',
        'permission_callback'=>function(){ return current_user_can('manage_options'); },
        'callback'=>function($request){
            $force = (bool)$request->get_param('force');
            $res = alookhor_cc_seed_products($force);
            return rest_ensure_response(['ok'=>true,'version'=>ALOOKHOR_CC_VERSION,'result'=>$res]);
        }
    ]);
});

// Add button in admin bar? We'll add via filter in control center page
add_action('alookhor_cc_after_settings', function(){
    $seed_url = wp_nonce_url(admin_url('?alookhor_seed_products=1&force=1'), 'alookhor_seed');
    echo '<div style="margin:20px 0;padding:16px;border:1px solid rgba(247,179,43,.3);border-radius:12px;background:rgba(47,26,63,.5);">';
    echo '<h3 style="color:#fbf3e2;margin:0 0 8px;">🌿 ایجاد 5 محصول نمونه کامل (کشمش، آلو بخارا، لواشک، گردو)</h3>';
    echo '<p style="color:#c7b3da;font-size:13px;margin:0 0 12px;">این ابزار 5 محصول متغیر با وزن‌های 3/5/10 کیلویی، قیمت عادی و شگفت‌انگیز، توضیحات کوتاه و بلند، ویژگی‌ها، دسته‌بندی، برچسب، تصاویر، موجودی و تمام قابلیت‌های ووکامرس را به صورت خودکار ایجاد می‌کند. بعد از ایجاد می‌توانید از روی آن‌ها سایر محصولات را بسازید.</p>';
    echo '<a href="'.esc_url($seed_url).'" class="button button-primary" style="background:#f7b32b;border-color:#f7b32b;color:#170a20;font-weight:900;">ایجاد 5 محصول نمونه (Force)</a> ';
    $seed_url2 = wp_nonce_url(admin_url('?alookhor_seed_products=1'), 'alookhor_seed');
    echo '<a href="'.esc_url($seed_url2).'" class="button" style="margin-right:8px;">ایجاد اگر وجود ندارد</a>';
    echo '</div>';
});
