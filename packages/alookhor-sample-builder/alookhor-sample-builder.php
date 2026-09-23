<?php
/**
 * Plugin Name: ALOOKHOR Sample Builder
 * Description: ایجاد ۵ محصول نمونه کامل فروشگاهی (دسته‌بندی سلسله‌مراتبی، ویژگی وزن و درجه، ۳۰ تنوع قیمت، گالری تصاویر، موجودی، تعداد فروش و نظرات نمونه) برای فروشگاه آلوخور.
 * Version: 1.2.0
 * Author: ALOOKHOR
 * License: GPLv2 or later
 * Text Domain: alookhor-sample-builder
 * Update URI: https://raw.githubusercontent.com/emeliijaddd-png/alookhor-update-publisher/arena/01a0a537-alookhor-update-publisher/packages/updates/update.json
 *
 * Requires at least: 5.8
 * WC requires at least: 5.0
 *
 * NOTE: This file intentionally contains no closing PHP tag.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'ASB_VERSION', '1.2.0' );
define( 'ASB_OPTION_CREATED', 'asb_created_data' );
define( 'ASB_OPTION_LOG', 'asb_last_log' );
define( 'ASB_OPTION_PENDING', 'asb_pending_build' );
define( 'ASB_SLUG', 'alookhor-sample-builder' );
define( 'ASB_BASENAME', plugin_basename( __FILE__ ) );
define( 'ASB_OPTION_VERSION', 'asb_version' );
define(
	'ASB_UPDATE_URL',
	'https://raw.githubusercontent.com/emeliijaddd-png/alookhor-update-publisher/arena/01a0a537-alookhor-update-publisher/packages/updates/update.json'
);

/* =========================================================================
 * 1) داده‌های محصولات (منبع واحد حقیقت)
 * ========================================================================= */

/**
 * ویژگی‌های سراسری محصولات.
 */
function asb_attribute_blueprint() {
	return array(
		'weight' => array(
			'label' => 'وزن بسته‌بندی',
			'terms' => array(
				'w5'  => '۵ کیلوگرم',
				'w10' => '۱۰ کیلوگرم',
				'w30' => '۳۰ کیلوگرم',
			),
			'kg' => array(
				'w5'  => 5,
				'w10' => 10,
				'w30' => 30,
			),
		),
		'grade' => array(
			'label' => 'درجه کیفیت',
			'terms' => array(
				'g1' => 'درجه یک',
				'g2' => 'درجه دو',
			),
			'factor' => array(
				'g1' => 1.00,
				'g2' => 0.88,
			),
		),
	);
}

/**
 * تخفیف حجمی بر اساس وزن.
 */
function asb_volume_discount() {
	return array(
		'w5'  => 0.94,
		'w10' => 0.91,
		'w30' => 0.87,
	);
}

/**
 * موجودی پایه برای هر ترکیب وزن/درجه.
 */
function asb_stock_matrix() {
	return array(
		'w5'  => array( 'g1' => 140, 'g2' => 95 ),
		'w10' => array( 'g1' => 78,  'g2' => 46 ),
		'w30' => array( 'g1' => 22,  'g2' => 12 ),
	);
}

/**
 * تعریف 5 محصول نمونه.
 */
function asb_products_blueprint() {

	$spec_table = '<table class="asb-spec"><tbody>'
		. '<tr><th>نوع بسته‌بندی</th><td>کارتن لمینتی چندلایه + لفاف زیپ‌دار</td></tr>'
		. '<tr><th>زمان آماده‌سازی</th><td>۱ تا ۲ روز کاری</td></tr>'
		. '<tr><th>ماندگاری</th><td>۱۲ ماه در شرایط استاندارد</td></tr>'
		. '<tr><th>گواهی‌ها</th><td>سیب سلامت، آنالیز آزمایشگاهی، تأییدیه قرنطینه برای صادرات</td></tr>'
		. '<tr><th>حداقل سفارش عمده</th><td>۲۰ کیلوگرم</td></tr>'
		. '<tr><th>ارسال</th><td>سراسر ایران و بیش از ۵۰ کشور جهان</td></tr>'
		. '</tbody></table>';

	return array(

		array(
			'code'      => 'ALB',
			'name'      => 'آلو بخارا ممتاز خراسان',
			'slug'      => 'aloo-bokhara-momtaz-khorasan',
			'sku'       => 'AKH-ALB',
			'cats'      => array(
				array( 'name' => 'خشکبار', 'slug' => 'khoshkbar', 'parent' => 0 ),
				array( 'name' => 'آلو خشکبار', 'slug' => 'aloo-khoshkbar', 'parent' => 'khoshkbar' ),
				array( 'name' => 'آلو بخارا', 'slug' => 'aloo-bokhara', 'parent' => 'aloo-khoshkbar' ),
			),
			'per_kg'    => 380000,
			'sales'     => 184,
			'featured'  => true,
			'tags'      => array( 'صادراتی', 'پرفروش', 'خورشتی' ),
			'short'     => 'آلو بخارای درشت و گوشتی خراسان با طعم متعادل شیرین‌ـ‌ترش، خشک‌شده در آفتاب و سورت‌شده در سه وزن ۵، ۱۰ و ۳۰ کیلوگرم. انتخاب اول صادرکنندگان و فروشگاه‌های خشکبار.',
			'desc'      =>
				'<h2>معرفی آلو بخارا ممتاز خراسان</h2>'
				. '<p>آلو بخارای ممتاز آلوخور از باغ‌های منتخب خراسان رضوی و شمالی برداشت می‌شود و پس از شست‌وشو و سورت اولیه، به روش سنتی و در آفتاب خشک می‌شود تا رنگ کهربایی و بافت گوشتی خود را به‌طور کامل حفظ کند. هر سری قبل از بسته‌بندی روی میز سورت نوری و دستی پایش می‌شود تا دانه‌های ریز، نارس یا آسیب‌دیده حذف شوند.</p>'
				. '<h3>ویژگی‌های شاخص</h3>'
				. '<ul>'
				. '<li>سایز درشت و یکدست با حداقل ۲۴ دانه در هر ۱۰۰ گرم</li>'
				. '<li>بدون افزودنی، بدون شکرک و بدون گوگرد</li>'
				. '<li>رطوبت کنترل‌شده بین ۱۸ تا ۲۲ درصد</li>'
				. '<li>مناسب خورشت آلو، فسنجان، لواشک و مصرف مستقیم</li>'
				. '<li>عرضه در دو درجه کیفی برای پاسخ به هر بودجه‌ای</li>'
				. '</ul>'
				. '<h3>راهنمای انتخاب درجه</h3>'
				. '<p><strong>درجه یک:</strong> دانه‌درشت، کاملاً یکدست، رنگ یکنواخت — مناسب صادرات و بسته‌بندی هدیه.<br>'
				. '<strong>درجه دو:</strong> سایز متوسط با رنگ‌بندی طبیعی متنوع — اقتصادی و مناسب مصارف صنعتی و خورشتی.</p>'
				. '<h3>مشخصات فنی و خدمات</h3>'
				. $spec_table
				. '<h3>روش نگهداری</h3>'
				. '<p>در جای خشک و خنک و دور از نور مستقیم خورشید نگهداری شود. پس از باز کردن بسته، محصول را در ظرف دربسته قرار دهید. در دمای زیر ۱۰ درجه ماندگاری تا ۱۸ ماه افزایش می‌یابد.</p>',
			'reviews'   => array(
				array( 'name' => 'رضا کریمی', 'rating' => 5, 'date' => '2026-08-12 11:20:00', 'text' => 'برای صادرات به عمان سفارش دادم. سورت واقعاً تمیز بود و دانه‌ها یکدست. بسته‌بندی کارتنی بدون له‌شدگی رسید.' ),
				array( 'name' => 'سمانه احمدی', 'rating' => 5, 'date' => '2026-08-19 17:45:00', 'text' => 'برای خورشت آلو عالی است. زود می‌پزد و طعم ترش طبیعی دارد، نیازی به شکر اضافه نیست.' ),
				array( 'name' => 'مجتبی رستمی', 'rating' => 4, 'date' => '2026-09-02 09:05:00', 'text' => 'کیفیت درجه دو هم برای کار ما مناسب بود. فقط ای کاش وزن ۳۰ کیلویی زودتر موجود می‌شد.' ),
			),
		),

		array(
			'code'      => 'GRD',
			'name'      => 'گردو کاغذی ممتاز تویسرکان',
			'slug'      => 'gerdu-kaghazi-momtaz-toyserkan',
			'sku'       => 'AKH-GRD',
			'cats'      => array(
				array( 'name' => 'خشکبار', 'slug' => 'khoshkbar', 'parent' => 0 ),
				array( 'name' => 'گردو', 'slug' => 'gerdu', 'parent' => 'khoshkbar' ),
			),
			'per_kg'    => 720000,
			'sales'     => 96,
			'featured'  => false,
			'tags'      => array( 'صادراتی', 'مغزها', 'اعلا' ),
			'short'     => 'گردو کاغذی پوست‌نازک تویسرکان با مغز سفید و درشت، چربی طبیعی بالا و طعم ملایم؛ عرضه در بسته‌های ۵، ۱۰ و ۳۰ کیلوگرم مخصوص همکاران و صادرکنندگان.',
			'desc'      =>
				'<h2>معرفی گردو کاغذی ممتاز تویسرکان</h2>'
				. '<p>گردوی کاغذی تویسرکان به‌دلیل پوست نازک و مغز درشت، یکی از باارزش‌ترین ارقام گردوی ایران است. محصول آلوخور از باغ‌های کهنسال منطقه تأمین می‌شود و پس از خشک‌کردن تدریجی در سایه، با دستگاه ضربه‌ای پوست‌گیری و سپس به‌صورت دستی سورت می‌شود تا درصد مغز سالم به حداکثر برسد.</p>'
				. '<h3>ویژگی‌های شاخص</h3>'
				. '<ul>'
				. '<li>نسبت مغز به پوست بالا و پوست کاغذی</li>'
				. '<li>رنگ مغز سفید تا کرم روشن، بدون تلخی</li>'
				. '<li>درصد شکستگی زیر ۳ درصد در درجه یک</li>'
				. '<li>بدون هیچ‌گونه سفیدکننده شیمیایی</li>'
				. '<li>بسته‌بندی وکیوم‌دار برای جلوگیری از اکسیداسیون</li>'
				. '</ul>'
				. '<h3>راهنمای انتخاب درجه</h3>'
				. '<p><strong>درجه یک:</strong> مغز کامل، درشت و سفید — مناسب بسته‌بندی هدیه و صادرات.<br>'
				. '<strong>درجه دو:</strong> مخلوط نیم‌مغز و مغز کامل — مناسب قنادی، شیرینی‌پزی و مصارف صنعتی.</p>'
				. '<h3>مشخصات فنی و خدمات</h3>'
				. $spec_table
				. '<h3>روش نگهداری</h3>'
				. '<p>به‌دلیل چربی بالا، گردو را در دمای خنک و ترجیحاً یخچال نگهداری کنید. دور از مواد بودار قرار گیرد چون به‌سرعت بو را جذب می‌کند.</p>',
			'reviews'   => array(
				array( 'name' => 'نرگس حیدری', 'rating' => 5, 'date' => '2026-08-08 14:10:00', 'text' => 'مغزها کاملاً سفید و درشت بود. برای شیرینی‌پزی استفاده کردم و هیچ تلخی نداشت.' ),
				array( 'name' => 'بهروز قاسمی', 'rating' => 5, 'date' => '2026-08-25 20:30:00', 'text' => 'بسته ۳۰ کیلویی برای عمده‌فروشی گرفتم. وکیوم بودن بسته‌ها خیالم را از بابت تازگی راحت کرد.' ),
				array( 'name' => 'الهام صادقی', 'rating' => 4, 'date' => '2026-09-05 08:15:00', 'text' => 'ارسال سریع بود و پوست‌ها واقعاً کاغذی است. فقط مقدار کمی نیم‌مغز هم داشت که برای من ایرادی نداشت.' ),
			),
		),

		array(
			'code'      => 'TOT',
			'name'      => 'توت خشک سفید ممتاز',
			'slug'      => 'toot-khoshk-sefid-momtaz',
			'sku'       => 'AKH-TOT',
			'cats'      => array(
				array( 'name' => 'خشکبار', 'slug' => 'khoshkbar', 'parent' => 0 ),
				array( 'name' => 'توت خشک', 'slug' => 'toot-khoshk', 'parent' => 'khoshkbar' ),
			),
			'per_kg'    => 460000,
			'sales'     => 210,
			'featured'  => true,
			'tags'      => array( 'پرفروش', 'بدون شکر', 'میان‌وعده' ),
			'short'     => 'توت خشک سفید طبیعی با شیرینی ملایم و بدون هیچ افزودنی یا شکرک؛ مناسب میان‌وعده، صبحانه و ترکیب‌های آجیلی در وزن‌های ۵، ۱۰ و ۳۰ کیلوگرم.',
			'desc'      =>
				'<h2>معرفی توت خشک سفید ممتاز</h2>'
				. '<p>توت سفید پس از برداشت دستی و شست‌وشو، در سایه و جریان هوای آزاد خشک می‌شود تا رنگ روشن و شیرینی طبیعی آن حفظ شود. این محصول هیچ شکر، روغن یا نگه‌دارنده‌ای ندارد و به همین دلیل برای رژیم‌های غذایی سالم و کودکان گزینه‌ای مطمئن است.</p>'
				. '<h3>ویژگی‌های شاخص</h3>'
				. '<ul>'
				. '<li>شیرینی صددرصد طبیعی و بدون شکر افزوده</li>'
				. '<li>رنگ یکنواخت کرم مایل به سفید</li>'
				. '<li>بافت نرم و قابل‌جویدن، مناسب سالمندان</li>'
				. '<li>منبع طبیعی آهن، کلسیم و ویتامین C</li>'
				. '<li>آماده ترکیب در آجیل و گرانولا</li>'
				. '</ul>'
				. '<h3>راهنمای انتخاب درجه</h3>'
				. '<p><strong>درجه یک:</strong> دانه کامل، رنگ روشن و بدون چسبندگی.<br>'
				. '<strong>درجه دو:</strong> رنگ‌بندی کمی تیره‌تر و دانه‌های ریزتر — اقتصادی برای شیرینی‌پزی و تولید صنعتی.</p>'
				. '<h3>مشخصات فنی و خدمات</h3>'
				. $spec_table
				. '<h3>روش نگهداری</h3>'
				. '<p>دور از رطوبت نگهداری شود؛ در صورت نرم‌شدن، چند دقیقه در فر با دمای پایین قرار دهید تا بافت اولیه بازگردد.</p>',
			'reviews'   => array(
				array( 'name' => 'فاطمه مرادی', 'rating' => 5, 'date' => '2026-08-15 10:02:00', 'text' => 'شیرینی طبیعی دارد و اصلاً شکرک ندارد. بچه‌ها خیلی دوست داشتند.' ),
				array( 'name' => 'حمیدرضا نوری', 'rating' => 5, 'date' => '2026-08-28 16:40:00', 'text' => 'برای ترکیب آجیل فروشگاهم گرفتم. یکدست و تمیز بود و مشتری راضی بود.' ),
				array( 'name' => 'زهرا عباسی', 'rating' => 5, 'date' => '2026-09-09 12:25:00', 'text' => 'بسته‌بندی زیپ‌دار خیلی کاربردی است. کیفیت نسبت به قیمت واقعاً بالاتر از انتظار بود.' ),
			),
		),

		array(
			'code'      => 'BRG',
			'name'      => 'برگه هلو خورشتی درجه یک',
			'slug'      => 'barge-holu-khoreshti',
			'sku'       => 'AKH-BRG',
			'cats'      => array(
				array( 'name' => 'خشکبار', 'slug' => 'khoshkbar', 'parent' => 0 ),
				array( 'name' => 'برگه هلو', 'slug' => 'barge-holu', 'parent' => 'khoshkbar' ),
			),
			'per_kg'    => 520000,
			'sales'     => 143,
			'featured'  => false,
			'tags'      => array( 'خورشتی', 'بدون گوگرد', 'خانگی' ),
			'short'     => 'برگه هلوی طبیعی و بدون گوگرد با رنگ کهربایی و عطر ملایم؛ مخصوص خورشت، دسر و کمپوت خانگی در بسته‌های عمده ۵، ۱۰ و ۳۰ کیلوگرم.',
			'desc'      =>
				'<h2>معرفی برگه هلو خورشتی</h2>'
				. '<p>برگه هلوی آلوخور از هلوهای رسیده و گوشتی تهیه و به‌صورت طبیعی خشک می‌شود، بدون استفاده از دود گوگرد. نتیجه محصولی با رنگ کهربایی تیره، عطر ملایم و بافتی است که در پخت به‌خوبی شکل خود را نگه می‌دارد.</p>'
				. '<h3>ویژگی‌های شاخص</h3>'
				. '<ul>'
				. '<li>بدون گوگرد و بدون رنگ‌افزا</li>'
				. '<li>ضخامت یکنواخت برای پخت یکدست</li>'
				. '<li>عطر طبیعی هلو پس از پخت</li>'
				. '<li>مناسب خورشت هلو، دسر، کمپوت و مربا</li>'
				. '<li>ماندگاری طولانی در بسته‌بندی دربسته</li>'
				. '</ul>'
				. '<h3>راهنمای انتخاب درجه</h3>'
				. '<p><strong>درجه یک:</strong> برگه‌های درشت و کامل با ضخامت یکسان.<br>'
				. '<strong>درجه دو:</strong> قطعات کوچک‌تر و برش‌های نامنظم — اقتصادی برای پوره و مصارف کارگاهی.</p>'
				. '<h3>مشخصات فنی و خدمات</h3>'
				. $spec_table
				. '<h3>روش نگهداری</h3>'
				. '<p>در ظرف دربسته و محیط خشک نگهداری شود. در صورت تمایل به نرم‌تر شدن، نیم ساعت پیش از مصرف در آب ولرم بخیسانید.</p>',
			'reviews'   => array(
				array( 'name' => 'پریسا سلیمانی', 'rating' => 5, 'date' => '2026-08-11 13:35:00', 'text' => 'بدون گوگرد بودن برایم مهم بود و واقعاً تفاوت طعم را حس کردم. برای خورشت هلو عالی شد.' ),
				array( 'name' => 'کامران وفایی', 'rating' => 4, 'date' => '2026-08-30 18:50:00', 'text' => 'برش‌ها یکدست است و زود می‌پزد. بسته‌بندی مناسب ارسال بود.' ),
				array( 'name' => 'مریم جهانی', 'rating' => 5, 'date' => '2026-09-11 09:30:00', 'text' => 'برای مربا و کمپوت استفاده کردم. عطر طبیعی هلو کاملاً حفظ شده بود.' ),
			),
		),

		array(
			'code'      => 'LVS',
			'name'      => 'لواشک خانگی چندمیوه ممتاز',
			'slug'      => 'lavashak-khanegi-chandmiveh',
			'sku'       => 'AKH-LVS',
			'cats'      => array(
				array( 'name' => 'خشکبار', 'slug' => 'khoshkbar', 'parent' => 0 ),
				array( 'name' => 'لواشک', 'slug' => 'lavashak', 'parent' => 'khoshkbar' ),
			),
			'per_kg'    => 395000,
			'sales'     => 268,
			'featured'  => true,
			'tags'      => array( 'پرفروش', 'بدون قند افزوده', 'میان‌وعده' ),
			'short'     => 'لواشک خانگی ترش‌ـ‌شیرین تهیه‌شده از میوه تازه بدون قند و نگه‌دارنده، با بافت یکنواخت و ماندگاری بالا؛ مناسب فروشگاه‌ها، کافه‌ها و سفارش‌های عمده.',
			'desc'      =>
				'<h2>معرفی لواشک خانگی چندمیوه</h2>'
				. '<p>لواشک آلوخور از پوره میوه‌های تازه فصل (آلو، زردآلو، سیب و انار ترش) و بدون افزودن قند، نمک زیاد یا نگه‌دارنده تهیه می‌شود. پوره روی سطوح استیل در دمای کنترل‌شده خشک و سپس به‌صورت رول یا ورق برش می‌خورد.</p>'
				. '<h3>ویژگی‌های شاخص</h3>'
				. '<ul>'
				. '<li>بدون قند افزوده و بدون رنگ مصنوعی</li>'
				. '<li>طعم ترش‌ـ‌شیرین متعادل و طبیعی</li>'
				. '<li>بافت یکنواخت بدون دانه و الیاف درشت</li>'
				. '<li>ماندگاری ۱۲ ماه در دمای محیط</li>'
				. '<li>مناسب فروشگاه، کافه، مدرسه و پذیرایی</li>'
				. '</ul>'
				. '<h3>راهنمای انتخاب درجه</h3>'
				. '<p><strong>درجه یک:</strong> ورق‌های کامل، ضخامت یکنواخت و رنگ شفاف.<br>'
				. '<strong>درجه دو:</strong> برش‌ها و کناره‌های ورق — اقتصادی برای بسته‌بندی فله و مصارف کارگاهی.</p>'
				. '<h3>مشخصات فنی و خدمات</h3>'
				. $spec_table
				. '<h3>روش نگهداری</h3>'
				. '<p>در جای خشک و خنک دور از نور خورشید نگهداری شود. پس از باز کردن بسته، در ظرف دربسته قرار دهید تا نرم نماند.</p>',
			'reviews'   => array(
				array( 'name' => 'سارا اکبری', 'rating' => 5, 'date' => '2026-08-06 15:12:00', 'text' => 'ترش و شیرینش کاملاً متعادل است و اصلاً شکر ندارد. برای بچه‌ها عالی است.' ),
				array( 'name' => 'علی محمودی', 'rating' => 5, 'date' => '2026-08-22 11:48:00', 'text' => 'برای کافه‌ام بسته ۱۰ کیلویی گرفتم. بسته‌بندی بهداشتی بود و مشتری‌ها دوباره سفارش دادند.' ),
				array( 'name' => 'شیما رضایی', 'rating' => 4, 'date' => '2026-09-07 19:22:00', 'text' => 'طعم واقعاً خانگی دارد. اگر تنوع میوه هم اضافه شود عالی می‌شود.' ),
			),
		),
	);
}

/* =========================================================================
 * 2) ابزارهای کمکی
 * ========================================================================= */

function asb_log( $message ) {
	$log = get_option( ASB_OPTION_LOG, array() );
	if ( ! is_array( $log ) ) {
		$log = array();
	}
	$log[] = array( 'time' => current_time( 'mysql' ), 'msg' => $message );
	if ( count( $log ) > 300 ) {
		$log = array_slice( $log, -300 );
	}
	update_option( ASB_OPTION_LOG, $log, false );
}

function asb_has_woocommerce() {
	return class_exists( 'WooCommerce' ) && function_exists( 'wc_get_product' );
}

function asb_money( $value ) {
	$value = (float) $value;
	$rounded = round( $value / 5000 ) * 5000;
	return (int) $rounded;
}

function asb_created() {
	$data = get_option( ASB_OPTION_CREATED, array() );
	if ( ! is_array( $data ) ) {
		$data = array();
	}
	$defaults = array(
		'products'    => array(),
		'variations'  => array(),
		'attachments' => array(),
		'categories'  => array(),
		'terms'       => array(),
		'reviews'     => array(),
		'menu_items'  => array(),
		'attributes'  => array(),
	);
	return array_merge( $defaults, $data );
}

function asb_save_created( $data ) {
	update_option( ASB_OPTION_CREATED, $data, false );
}

function asb_record( $key, $ids ) {
	if ( empty( $ids ) ) {
		return;
	}
	$data = asb_created();
	if ( ! isset( $data[ $key ] ) || ! is_array( $data[ $key ] ) ) {
		$data[ $key ] = array();
	}
	foreach ( (array) $ids as $id ) {
		$id = (int) $id;
		if ( $id > 0 && ! in_array( $id, $data[ $key ], true ) ) {
			$data[ $key ][] = $id;
		}
	}
	asb_save_created( $data );
}

/* =========================================================================
 * 3) ویژگی‌های سراسری (وزن / درجه)
 * ========================================================================= */

function asb_ensure_attributes() {
	if ( ! function_exists( 'wc_create_attribute' ) ) {
		return new WP_Error( 'no_wc', 'ووکامرس فعال نیست.' );
	}

	$blueprint = asb_attribute_blueprint();
	$existing  = wc_get_attribute_taxonomies();
	$names     = array();
	foreach ( $existing as $attr ) {
		$names[] = $attr->attribute_name;
	}

	foreach ( $blueprint as $slug => $def ) {
		$taxonomy = wc_attribute_taxonomy_name( $slug ); // pa_weight / pa_grade

		if ( ! in_array( $slug, $names, true ) ) {
			$new_id = wc_create_attribute(
				array(
					'name'         => $def['label'],
					'slug'         => $slug,
					'type'         => 'select',
					'order_by'     => 'menu_order',
					'has_archives' => false,
				)
			);
			if ( is_wp_error( $new_id ) ) {
				asb_log( 'خطا در ایجاد ویژگی ' . $def['label'] . ': ' . $new_id->get_error_message() );
			} else {
				asb_record( 'attributes', array( $new_id ) );
				asb_log( 'ویژگی «' . $def['label'] . '» ایجاد شد.' );
			}
			delete_transient( 'wc_attribute_taxonomies' );
		}

		if ( ! taxonomy_exists( $taxonomy ) ) {
			register_taxonomy(
				$taxonomy,
				array( 'product' ),
				array(
					'hierarchical' => false,
					'show_ui'      => false,
					'query_var'    => true,
					'public'       => false,
					'rewrite'      => false,
				)
			);
		}

		foreach ( $def['terms'] as $term_slug => $term_name ) {
			if ( ! term_exists( $term_slug, $taxonomy ) ) {
				$result = wp_insert_term( $term_name, $taxonomy, array( 'slug' => $term_slug ) );
				if ( ! is_wp_error( $result ) && isset( $result['term_id'] ) ) {
					asb_record( 'terms', array( $result['term_id'] ) );
				}
			}
		}
	}

	return true;
}

/* =========================================================================
 * 4) دسته‌بندی‌ها (سلسله‌مراتبی)
 * ========================================================================= */

function asb_ensure_category( $name, $slug, $parent_slug ) {
	$parent_id = 0;

	if ( ! empty( $parent_slug ) ) {
		$parent = get_term_by( 'slug', $parent_slug, 'product_cat' );
		if ( $parent && ! is_wp_error( $parent ) ) {
			$parent_id = (int) $parent->term_id;
		}
	}

	$term = get_term_by( 'slug', $slug, 'product_cat' );
	if ( ! $term || is_wp_error( $term ) ) {
		$term = get_term_by( 'name', $name, 'product_cat' );
	}

	if ( $term && ! is_wp_error( $term ) ) {
		$term_id = (int) $term->term_id;
		if ( $parent_id > 0 && (int) $term->parent !== $parent_id ) {
			wp_update_term( $term_id, 'product_cat', array( 'parent' => $parent_id ) );
		}
		return $term_id;
	}

	$result = wp_insert_term(
		$name,
		'product_cat',
		array(
			'slug'   => $slug,
			'parent' => $parent_id,
		)
	);

	if ( is_wp_error( $result ) ) {
		asb_log( 'خطا در ایجاد دسته «' . $name . '»: ' . $result->get_error_message() );
		return 0;
	}

	asb_record( 'categories', array( $result['term_id'] ) );
	asb_log( 'دسته «' . $name . '» ایجاد شد.' );

	return (int) $result['term_id'];
}

/**
 * دسته‌های کامل مدل کسب‌وکار: آلو + زیرمجموعه‌ها و سایر دسته‌ها.
 */
function asb_ensure_all_categories() {
	$paths = array(
		array( 'name' => 'خشکبار', 'slug' => 'khoshkbar', 'parent' => '' ),
		array( 'name' => 'آلو خشکبار', 'slug' => 'aloo-khoshkbar', 'parent' => 'khoshkbar' ),
		array( 'name' => 'آلو بخارا', 'slug' => 'aloo-bokhara', 'parent' => 'aloo-khoshkbar' ),
		array( 'name' => 'آلو طرقبه', 'slug' => 'aloo-torghabeh', 'parent' => 'aloo-khoshkbar' ),
		array( 'name' => 'آلو حاج حسینی', 'slug' => 'aloo-haj-hosseini', 'parent' => 'aloo-khoshkbar' ),
		array( 'name' => 'آلو قطره', 'slug' => 'aloo-ghatreh', 'parent' => 'aloo-khoshkbar' ),
		array( 'name' => 'آلو طرقبه زرد', 'slug' => 'aloo-torghabeh-zard', 'parent' => 'aloo-khoshkbar' ),
		array( 'name' => 'گردو', 'slug' => 'gerdu', 'parent' => 'khoshkbar' ),
		array( 'name' => 'توت خشک', 'slug' => 'toot-khoshk', 'parent' => 'khoshkbar' ),
		array( 'name' => 'برگه هلو', 'slug' => 'barge-holu', 'parent' => 'khoshkbar' ),
		array( 'name' => 'لواشک', 'slug' => 'lavashak', 'parent' => 'khoshkbar' ),
	);

	$ids = array();
	foreach ( $paths as $path ) {
		$ids[ $path['slug'] ] = asb_ensure_category( $path['name'], $path['slug'], $path['parent'] );
	}

	// تصویر شاخص برای دسته‌ها (در صورت وجود تصویر منبع).
	return $ids;
}

/* =========================================================================
 * 5) تصاویر (کپی از فایل‌های موجود روی همان هاست - بدون نیاز به اینترنت)
 * ========================================================================= */

function asb_find_source_images() {
	$dirs = array(
		WP_CONTENT_DIR . '/uploads',
		WP_PLUGIN_DIR . '/alookhor-control-center/assets/images',
		get_template_directory() . '/assets/img',
	);

	$found = array();

	foreach ( $dirs as $dir ) {
		if ( ! is_dir( $dir ) ) {
			continue;
		}
		try {
			$iterator = new RecursiveIteratorIterator(
				new RecursiveDirectoryIterator( $dir, FilesystemIterator::SKIP_DOTS ),
				RecursiveIteratorIterator::SELF_FIRST
			);
			foreach ( $iterator as $file ) {
				if ( ! $file->isFile() ) {
					continue;
				}
				$ext = strtolower( $file->getExtension() );
				if ( ! in_array( $ext, array( 'jpg', 'jpeg', 'png', 'webp' ), true ) ) {
					continue;
				}
				$name = $file->getFilename();
				if ( strpos( $name, 'asb-' ) === 0 ) {
					continue;
				}
				if ( preg_match( '/-\d+x\d+\.(jpg|jpeg|png|webp)$/i', $name ) ) {
					continue; // تصاویر کوچک‌شده
				}
				if ( $file->getSize() < 15000 ) {
					continue;
				}
				$found[] = $file->getPathname();
				if ( count( $found ) >= 200 ) {
					break 2;
				}
			}
		} catch ( Exception $e ) {
			asb_log( 'پوشه تصاویر قابل خواندن نبود: ' . $dir );
		}
	}

	$found = array_values( array_unique( $found ) );
	sort( $found );

	return $found;
}

function asb_attachment_from_file( $src_path, $title, $latin_stem, $parent_id ) {
	if ( ! file_exists( $src_path ) || ! is_readable( $src_path ) ) {
		return 0;
	}

	require_once ABSPATH . 'wp-admin/includes/image.php';
	require_once ABSPATH . 'wp-admin/includes/file.php';
	require_once ABSPATH . 'wp-admin/includes/media.php';

	$uploads = wp_upload_dir();
	if ( ! empty( $uploads['error'] ) ) {
		return 0;
	}

	$ext      = strtolower( pathinfo( $src_path, PATHINFO_EXTENSION ) );
	$filename = 'asb-' . $latin_stem . '-' . wp_generate_password( 6, false, false ) . '.' . $ext;
	$dest     = trailingslashit( $uploads['path'] ) . $filename;

	if ( ! @copy( $src_path, $dest ) ) {
		return 0;
	}

	$filetype = wp_check_filetype( $dest, null );

	$attachment = array(
		'guid'           => trailingslashit( $uploads['url'] ) . $filename,
		'post_mime_type' => $filetype['type'] ? $filetype['type'] : 'image/jpeg',
		'post_title'     => $title,
		'post_content'   => '',
		'post_excerpt'   => '',
		'post_status'    => 'inherit',
	);

	$attach_id = wp_insert_attachment( $attachment, $dest, $parent_id );
	if ( is_wp_error( $attach_id ) || ! $attach_id ) {
		@unlink( $dest );
		return 0;
	}

	update_post_meta( $attach_id, '_wp_attachment_image_alt', $title );

	$metadata = wp_generate_attachment_metadata( $attach_id, $dest );
	if ( ! empty( $metadata ) ) {
		wp_update_attachment_metadata( $attach_id, $metadata );
	}

	asb_record( 'attachments', array( $attach_id ) );

	return (int) $attach_id;
}

/* =========================================================================
 * 6) ساخت محصولات
 * ========================================================================= */

function asb_build_products() {
	if ( ! asb_has_woocommerce() ) {
		return new WP_Error( 'no_wc', 'ووکامرس فعال نیست. ابتدا افزونه ووکامرس را فعال کنید.' );
	}

	$attrs        = asb_ensure_attributes();
	if ( is_wp_error( $attrs ) ) {
		return $attrs;
	}

	$cat_ids      = asb_ensure_all_categories();
	$blueprint    = asb_attribute_blueprint();
	$discount     = asb_volume_discount();
	$stock_matrix = asb_stock_matrix();
	$weight_slugs = array( 'w5', 'w10', 'w30' );
	$grade_slugs  = array( 'g1', 'g2' );
	$sources      = asb_find_source_images();

	asb_log( 'تعداد تصاویر منبع یافت‌شده روی هاست: ' . count( $sources ) );

	$created_products = array();
	$cursor           = 0;

	foreach ( asb_products_blueprint() as $index => $spec ) {

		$existing = get_page_by_path( $spec['slug'], OBJECT, 'product' );
		if ( $existing ) {
			asb_log( 'محصول «' . $spec['name'] . '» از قبل وجود دارد؛ رد شد.' );
			$created_products[] = (int) $existing->ID;
			continue;
		}

		$product_id = wp_insert_post(
			array(
				'post_title'   => $spec['name'],
				'post_name'    => $spec['slug'],
				'post_content' => $spec['desc'],
				'post_excerpt' => $spec['short'],
				'post_status'  => 'publish',
				'post_type'    => 'product',
				'post_author'  => get_current_user_id() ? get_current_user_id() : 1,
			),
			true
		);

		if ( is_wp_error( $product_id ) ) {
			asb_log( 'خطا در ایجاد محصول «' . $spec['name'] . '»: ' . $product_id->get_error_message() );
			continue;
		}

		$product_id = (int) $product_id;

		// نوع محصول: متغیر
		wp_set_object_terms( $product_id, 'variable', 'product_type' );

		// دسته‌ها
		$term_ids = array();
		foreach ( $spec['cats'] as $cat ) {
			if ( isset( $cat_ids[ $cat['slug'] ] ) && $cat_ids[ $cat['slug'] ] > 0 ) {
				$term_ids[] = (int) $cat_ids[ $cat['slug'] ];
			}
		}
		if ( ! empty( $term_ids ) ) {
			wp_set_object_terms( $product_id, $term_ids, 'product_cat' );
		}

		// برچسب‌ها
		if ( ! empty( $spec['tags'] ) ) {
			wp_set_object_terms( $product_id, $spec['tags'], 'product_tag' );
		}

		// تصویر شاخص + گالری
		$image_id = 0;
		$gallery  = array();
		if ( ! empty( $sources ) ) {
			$total  = count( $sources );
			$main_i = ( $index * 4 ) % $total;
			$image_id = asb_attachment_from_file(
				$sources[ $main_i ],
				$spec['name'],
				strtolower( $spec['code'] ) . '-main',
				$product_id
			);
			for ( $g = 1; $g <= 3; $g++ ) {
				$src_i = ( $main_i + $g ) % $total;
				$gid   = asb_attachment_from_file(
					$sources[ $src_i ],
					$spec['name'] . ' - تصویر ' . ( $g + 1 ),
					strtolower( $spec['code'] ) . '-gal' . $g,
					$product_id
				);
				if ( $gid > 0 ) {
					$gallery[] = $gid;
				}
			}
			$cursor++;
		}

		if ( $image_id > 0 ) {
			set_post_thumbnail( $product_id, $image_id );
		}
		if ( ! empty( $gallery ) ) {
			update_post_meta( $product_id, '_product_image_gallery', implode( ',', $gallery ) );
		}

		// ویژگی‌های متغیر
		update_post_meta(
			$product_id,
			'_product_attributes',
			array(
				'pa_weight' => array(
					'name'         => 'pa_weight',
					'value'        => '',
					'position'     => 0,
					'is_visible'   => 1,
					'is_variation' => 1,
					'is_taxonomy'  => 1,
				),
				'pa_grade' => array(
					'name'         => 'pa_grade',
					'value'        => '',
					'position'     => 1,
					'is_visible'   => 1,
					'is_variation' => 1,
					'is_taxonomy'  => 1,
				),
			)
		);

		$weight_term_ids = array();
		$grade_term_ids  = array();
		foreach ( $weight_slugs as $wslug ) {
			$t = get_term_by( 'slug', $wslug, 'pa_weight' );
			if ( $t ) {
				$weight_term_ids[] = (int) $t->term_id;
			}
		}
		foreach ( $grade_slugs as $gslug ) {
			$t = get_term_by( 'slug', $gslug, 'pa_grade' );
			if ( $t ) {
				$grade_term_ids[] = (int) $t->term_id;
			}
		}
		if ( ! empty( $weight_term_ids ) ) {
			wp_set_object_terms( $product_id, $weight_term_ids, 'pa_weight' );
		}
		if ( ! empty( $grade_term_ids ) ) {
			wp_set_object_terms( $product_id, $grade_term_ids, 'pa_grade' );
		}

		// پیش‌فرض‌ها
		update_post_meta(
			$product_id,
			'_default_attributes',
			array(
				'pa_weight' => 'w5',
				'pa_grade'  => 'g1',
			)
		);

		// تنوع‌ها: ۳ وزن × ۲ درجه
		$min_price  = 0;
		$max_price  = 0;
		$order      = 1;
		$var_count  = 0;

		foreach ( $weight_slugs as $wslug ) {
			$kg = $blueprint['weight']['kg'][ $wslug ];
			foreach ( $grade_slugs as $gslug ) {

				$regular = asb_money( $spec['per_kg'] * $kg * $blueprint['grade']['factor'][ $gslug ] );
				$sale    = asb_money( $regular * $discount[ $wslug ] );
				$stock   = (int) $stock_matrix[ $wslug ][ $gslug ];

				$variation_id = wp_insert_post(
					array(
						'post_title'   => $spec['name'] . ' — ' . $blueprint['weight']['terms'][ $wslug ] . ' — ' . $blueprint['grade']['terms'][ $gslug ],
						'post_name'    => 'product-' . $product_id . '-variation-' . $order,
						'post_status'  => 'publish',
						'post_parent'  => $product_id,
						'post_type'    => 'product_variation',
						'menu_order'   => $order,
						'post_content' => '',
						'post_excerpt' => '',
					),
					true
				);

				if ( is_wp_error( $variation_id ) ) {
					asb_log( 'خطا در ایجاد تنوع: ' . $variation_id->get_error_message() );
					$order++;
					continue;
				}

				$variation_id = (int) $variation_id;

				update_post_meta( $variation_id, 'attribute_pa_weight', $wslug );
				update_post_meta( $variation_id, 'attribute_pa_grade', $gslug );

				update_post_meta( $variation_id, '_sku', $spec['sku'] . '-' . strtoupper( $wslug ) . '-' . strtoupper( $gslug ) );
				update_post_meta( $variation_id, '_regular_price', $regular );
				update_post_meta( $variation_id, '_sale_price', $sale );
				update_post_meta( $variation_id, '_price', $sale );
				update_post_meta( $variation_id, '_manage_stock', 'yes' );
				update_post_meta( $variation_id, '_stock', $stock );
				update_post_meta( $variation_id, '_stock_status', 'instock' );
				update_post_meta( $variation_id, '_backorders', 'no' );
				update_post_meta( $variation_id, '_weight', $kg );
				update_post_meta( $variation_id, '_virtual', 'no' );
				update_post_meta( $variation_id, '_downloadable', 'no' );

				$wterm = get_term_by( 'slug', $wslug, 'pa_weight' );
				$gterm = get_term_by( 'slug', $gslug, 'pa_grade' );
				if ( $wterm ) {
					wp_set_object_terms( $variation_id, (int) $wterm->term_id, 'pa_weight' );
				}
				if ( $gterm ) {
					wp_set_object_terms( $variation_id, (int) $gterm->term_id, 'pa_grade' );
				}

				asb_record( 'variations', array( $variation_id ) );
				$var_count++;

				if ( 0 === $min_price || $sale < $min_price ) {
					$min_price = $sale;
				}
				if ( $sale > $max_price ) {
					$max_price = $sale;
				}

				$order++;
			}
		}

		// متاهای کلی محصول
		update_post_meta( $product_id, '_sku', $spec['sku'] );
		update_post_meta( $product_id, '_stock_status', 'instock' );
		update_post_meta( $product_id, '_manage_stock', 'no' );
		update_post_meta( $product_id, '_backorders', 'no' );
		update_post_meta( $product_id, '_sold_individually', 'no' );
		update_post_meta( $product_id, '_reviews_allowed', 'yes' );
		update_post_meta( $product_id, '_featured', ! empty( $spec['featured'] ) ? 'yes' : 'no' );
		update_post_meta( $product_id, '_virtual', 'no' );
		update_post_meta( $product_id, '_downloadable', 'no' );
		update_post_meta( $product_id, 'total_sales', (int) $spec['sales'] );
		update_post_meta( $product_id, '_price', $min_price );
		update_post_meta( $product_id, '_min_variation_price', $min_price );
		update_post_meta( $product_id, '_max_variation_price', $max_price );
		update_post_meta( $product_id, '_min_variation_sale_price', $min_price );
		update_post_meta( $product_id, '_max_variation_sale_price', $max_price );
		update_post_meta( $product_id, '_min_variation_regular_price', asb_money( $spec['per_kg'] * 5 ) );
		update_post_meta( $product_id, '_max_variation_regular_price', asb_money( $spec['per_kg'] * 30 ) );
		update_post_meta( $product_id, '_thumbnail_id', $image_id );

		// همگام‌سازی قیمت‌های متغیر
		$product = wc_get_product( $product_id );
		if ( $product && method_exists( $product, 'sync' ) ) {
			$product->sync( $product_id );
		}
		if ( function_exists( 'wc_delete_product_transients' ) ) {
			wc_delete_product_transients( $product_id );
		}

		asb_record( 'products', array( $product_id ) );
		$created_products[] = $product_id;
		asb_log( 'محصول «' . $spec['name'] . '» با ' . $var_count . ' تنوع ایجاد شد.' );
	}

	delete_transient( 'wc_attribute_taxonomies' );
	return $created_products;
}

/* =========================================================================
 * 7) نظرات نمونه
 * ========================================================================= */

function asb_build_reviews() {
	$count  = 0;
	$emails = array( 'gmail.com', 'yahoo.com', 'outlook.com' );

	foreach ( asb_products_blueprint() as $spec ) {
		$product_id = 0;

		$page = get_page_by_path( $spec['slug'], OBJECT, 'product' );
		if ( $page ) {
			$product_id = (int) $page->ID;
		}

		if ( ! $product_id ) {
			continue;
		}

		foreach ( $spec['reviews'] as $i => $review ) {
			$email = 'customer' . $product_id . $i . '@' . $emails[ $i % count( $emails ) ];

			$comment_id = wp_insert_comment(
				array(
					'comment_post_ID'      => $product_id,
					'comment_author'       => $review['name'],
					'comment_author_email' => $email,
					'comment_author_url'   => '',
					'comment_content'      => $review['text'],
					'comment_type'         => 'review',
					'comment_parent'       => 0,
					'user_id'              => 0,
					'comment_author_IP'    => '127.0.0.1',
					'comment_agent'        => 'ALOOKHOR Sample Builder',
					'comment_date'         => $review['date'],
					'comment_approved'     => 1,
				)
			);

			if ( ! $comment_id ) {
				continue;
			}

			update_comment_meta( $comment_id, 'rating', (int) $review['rating'] );
			update_comment_meta( $comment_id, 'verified', 1 );
			asb_record( 'reviews', array( $comment_id ) );
			$count++;
		}

		// به‌روزرسانی میانگین امتیاز
		if ( function_exists( 'wc_update_product_rating_counts' ) && function_exists( 'wc_update_product_review_count' ) ) {
			$product = wc_get_product( $product_id );
			if ( $product ) {
				$args  = array( 'post_id' => $product_id, 'type' => 'review', 'status' => 'approve' );
				$coms  = get_comments( $args );
				if ( ! empty( $coms ) ) {
					$sum   = 0;
					$total = 0;
					foreach ( $coms as $c ) {
						$r = (int) get_comment_meta( $c->comment_ID, 'rating', true );
						if ( $r > 0 ) {
							$sum  += $r;
							$total++;
						}
					}
					if ( $total > 0 ) {
						update_post_meta( $product_id, '_wc_average_rating', round( $sum / $total, 2 ) );
						update_post_meta( $product_id, '_wc_review_count', $total );
					}
				}
			}
		}

		if ( function_exists( 'wc_delete_product_transients' ) ) {
			wc_delete_product_transients( $product_id );
		}
	}

	asb_log( 'تعداد نظرات نمونه ایجادشده: ' . $count );

	return $count;
}

/* =========================================================================
 * 8) اتصال دسته‌ها به منوی اصلی
 * ========================================================================= */

function asb_build_menu() {
	$locations = get_nav_menu_locations();
	$menu_id   = 0;

	foreach ( array( 'primary', 'main-menu', 'main_menu', 'header', 'primary-menu' ) as $key ) {
		if ( ! empty( $locations[ $key ] ) ) {
			$menu_id = (int) $locations[ $key ];
			break;
		}
	}

	if ( ! $menu_id ) {
		$menus = wp_get_nav_menus();
		if ( ! empty( $menus ) ) {
			$menu_id = (int) $menus[0]->term_id;
		}
	}

	if ( ! $menu_id ) {
		$menu_id = wp_create_nav_menu( 'منوی اصلی آلوخور' );
		if ( is_wp_error( $menu_id ) ) {
			return 0;
		}
		$menu_id = (int) $menu_id;
	}

	// پیدا کردن آیتم «محصولات» برای قرار دادن زیرمجموعه‌ها زیر آن
	$parent_item = 0;
	$items       = wp_get_nav_menu_items( $menu_id, array( 'post_status' => 'publish' ) );
	if ( ! empty( $items ) ) {
		foreach ( $items as $item ) {
			if ( false !== strpos( $item->title, 'محصول' ) ) {
				$parent_item = (int) $item->ID;
				break;
			}
		}
	}

	$slugs = array(
		'khoshkbar'            => 'خشکبار',
		'aloo-khoshkbar'       => 'آلو خشکبار',
		'aloo-bokhara'         => 'آلو بخارا',
		'aloo-torghabeh'       => 'آلو طرقبه',
		'aloo-haj-hosseini'    => 'آلو حاج حسینی',
		'aloo-ghatreh'         => 'آلو قطره',
		'aloo-torghabeh-zard'  => 'آلو طرقبه زرد',
		'gerdu'                => 'گردو',
		'toot-khoshk'          => 'توت خشک',
		'barge-holu'           => 'برگه هلو',
		'lavashak'             => 'لواشک',
	);

	$added   = array();
	$top_ids = array();

	foreach ( $slugs as $slug => $name ) {
		$term = get_term_by( 'slug', $slug, 'product_cat' );
		if ( ! $term || is_wp_error( $term ) ) {
			continue;
		}

		$already = false;
		if ( ! empty( $items ) ) {
			foreach ( $items as $item ) {
				if ( 'taxonomy' === $item->type && 'product_cat' === $item->object && (int) $item->object_id === (int) $term->term_id ) {
					$already = true;
					break;
				}
			}
		}
		if ( $already ) {
			continue;
		}

		$is_top_level = in_array( $slug, array( 'khoshkbar' ), true );
		$item_parent  = $is_top_level ? $parent_item : 0;

		$new_item = wp_update_nav_menu_item(
			$menu_id,
			0,
			array(
				'menu-item-title'     => $name,
				'menu-item-object'    => 'product_cat',
				'menu-item-object-id' => (int) $term->term_id,
				'menu-item-type'      => 'taxonomy',
				'menu-item-status'    => 'publish',
				'menu-item-parent-id' => $item_parent,
			)
		);

		if ( ! is_wp_error( $new_item ) && $new_item ) {
			$added[] = $new_item;
			$top_ids[ $slug ] = (int) $new_item;
		}
	}

	// اتصال زیرمجموعه‌های آلو به آیتم «آلو خشکبار»
	if ( ! empty( $top_ids['aloo-khoshkbar'] ) ) {
		$children = array( 'aloo-bokhara', 'aloo-torghabeh', 'aloo-haj-hosseini', 'aloo-ghatreh', 'aloo-torghabeh-zard' );
		foreach ( $children as $child ) {
			if ( empty( $top_ids[ $child ] ) ) {
				continue;
			}
			$item_obj = get_post( $top_ids[ $child ] );
			if ( ! $item_obj ) {
				continue;
			}
			update_post_meta( $top_ids[ $child ], '_menu_item_menu_item_parent', (int) $top_ids['aloo-khoshkbar'] );
		}
	}

	asb_record( 'menu_items', $added );
	asb_log( 'تعداد آیتم‌های منو اضافه‌شده: ' . count( $added ) );

	return count( $added );
}

/* =========================================================================
 * 9) حذف کامل داده‌های ساخته‌شده
 * ========================================================================= */

function asb_delete_all() {
	$data = asb_created();

	require_once ABSPATH . 'wp-admin/includes/image.php';

	foreach ( $data['reviews'] as $cid ) {
		wp_delete_comment( (int) $cid, true );
	}

	foreach ( $data['menu_items'] as $item_id ) {
		wp_delete_post( (int) $item_id, true );
	}

	foreach ( $data['variations'] as $vid ) {
		wp_delete_post( (int) $vid, true );
	}

	foreach ( $data['products'] as $pid ) {
		$attachments = get_posts(
			array(
				'post_type'      => 'attachment',
				'post_parent'    => (int) $pid,
				'posts_per_page' => -1,
				'fields'         => 'ids',
			)
		);
		foreach ( $attachments as $aid ) {
			wp_delete_attachment( (int) $aid, true );
		}
		wp_delete_post( (int) $pid, true );
	}

	foreach ( $data['attachments'] as $aid ) {
		wp_delete_attachment( (int) $aid, true );
	}

	foreach ( $data['categories'] as $tid ) {
		$term = get_term( (int) $tid, 'product_cat' );
		if ( $term && ! is_wp_error( $term ) ) {
			wp_delete_term( (int) $tid, 'product_cat' );
		}
	}

	foreach ( $data['terms'] as $tid ) {
		foreach ( array( 'pa_weight', 'pa_grade' ) as $tax ) {
			$term = get_term( (int) $tid, $tax );
			if ( $term && ! is_wp_error( $term ) ) {
				wp_delete_term( (int) $tid, $tax );
			}
		}
	}

	foreach ( $data['attributes'] as $attr_id ) {
		if ( function_exists( 'wc_delete_attribute' ) ) {
			wc_delete_attribute( (int) $attr_id );
		}
	}

	delete_option( ASB_OPTION_CREATED );
	asb_log( 'همه داده‌های ساخته‌شده حذف شدند.' );

	return true;
}

/* =========================================================================
 * 10) رابط مدیریت
 * ========================================================================= */

function asb_admin_menu() {
	add_menu_page(
		'داده‌های نمونه آلوخور',
		'داده‌های نمونه آلوخور',
		'manage_woocommerce',
		'alookhor-sample-builder',
		'asb_render_admin_page',
		'dashicons-cart',
		57
	);
}
add_action( 'admin_menu', 'asb_admin_menu' );

function asb_render_admin_page() {

	if ( ! current_user_can( 'manage_woocommerce' ) ) {
		wp_die( 'دسترسی کافی ندارید.' );
	}

	$notice = '';
	$type   = 'info';

	if ( isset( $_POST['asb_action'] ) && isset( $_POST['asb_nonce'] ) && wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['asb_nonce'] ) ), 'asb_do_action' ) ) {

		$action = sanitize_key( wp_unslash( $_POST['asb_action'] ) );

		if ( 'build' === $action ) {
			$result = asb_build_products();
			if ( is_wp_error( $result ) ) {
				$notice = 'خطا: ' . $result->get_error_message();
				$type   = 'error';
			} else {
				$notice = 'ساخت محصولات انجام شد. تعداد محصول: ' . count( $result );
				$type   = 'success';
			}
		} elseif ( 'reviews' === $action ) {
			$count  = asb_build_reviews();
			$notice = 'تعداد ' . (int) $count . ' نظر نمونه ایجاد شد.';
			$type   = 'success';
		} elseif ( 'menu' === $action ) {
			$count  = asb_build_menu();
			$notice = 'تعداد ' . (int) $count . ' آیتم به منو اضافه شد.';
			$type   = 'success';
		} elseif ( 'delete' === $action ) {
			asb_delete_all();
			$notice = 'همه داده‌های ساخته‌شده حذف شدند.';
			$type   = 'success';
		} elseif ( 'fxoff' === $action ) {
			update_option( 'asb_frontend_fix', '0', false );
			$notice = 'اصلاح‌های ظاهری غیرفعال شد.';
			$type   = 'success';
		} elseif ( 'fxon' === $action ) {
			update_option( 'asb_frontend_fix', '1', false );
			$notice = 'اصلاح‌های ظاهری فعال شد.';
			$type   = 'success';
		} elseif ( 'checkupdate' === $action ) {
			delete_site_transient( 'update_plugins' );
			if ( function_exists( 'wp_update_plugins' ) ) {
				wp_update_plugins();
			}
			$remote = asb_fetch_manifest();
			if ( is_wp_error( $remote ) ) {
				$notice = 'بررسی به‌روزرسانی ناموفق بود: ' . $remote->get_error_message();
				$type   = 'error';
			} elseif ( version_compare( ASB_VERSION, $remote->version, '<' ) ) {
				$notice = 'نسخه جدید ' . $remote->version . ' موجود است. به صفحه «افزونه‌ها» بروید و روی «به‌روزرسانی حالا» بزنید.';
				$type   = 'success';
			} else {
				$notice = 'شما از آخرین نسخه استفاده می‌کنید (' . ASB_VERSION . '). تغییر جدیدی منتشر نشده است.';
				$type   = 'success';
			}
		} elseif ( 'clearlog' === $action ) {
			delete_option( ASB_OPTION_LOG );
			$notice = 'گزارش پاک شد.';
			$type   = 'success';
		}
	}

	$data   = asb_created();
	$log    = get_option( ASB_OPTION_LOG, array() );
	$counts = array(
		'products'    => count( $data['products'] ),
		'variations'  => count( $data['variations'] ),
		'attachments' => count( $data['attachments'] ),
		'categories'  => count( $data['categories'] ),
		'reviews'     => count( $data['reviews'] ),
		'menu_items'  => count( $data['menu_items'] ),
	);

	echo '<div class="wrap" dir="rtl">';
	echo '<h1 style="font-weight:700;">داده‌های نمونه فروشگاه آلوخور</h1>';
	echo '<p style="color:#646970;">نسخه نصب‌شده: <strong>' . esc_html( ASB_VERSION ) . '</strong>'
		. ' &nbsp;|&nbsp; روش به‌روزرسانی: <strong>پیشخوان › افزونه‌ها › به‌روزرسانی حالا</strong></p>';

	if ( $notice ) {
		$bg = 'success' === $type ? '#edfaef' : ( 'error' === $type ? '#fbeaea' : '#eef6ff' );
		$bc = 'success' === $type ? '#00a32a' : ( 'error' === $type ? '#d63638' : '#2271b1' );
		echo '<div style="background:' . esc_attr( $bg ) . ';border-right:4px solid ' . esc_attr( $bc ) . ';padding:12px 16px;margin:16px 0;font-weight:600;">' . esc_html( $notice ) . '</div>';
	}

	if ( ! asb_has_woocommerce() ) {
		echo '<div style="background:#fbeaea;border-right:4px solid #d63638;padding:12px 16px;margin:16px 0;font-weight:600;">ووکامرس فعال نیست. ابتدا افزونه ووکامرس را نصب و فعال کنید.</div>';
		echo '</div>';
		return;
	}

	echo '<p style="max-width:760px;line-height:2;">این ابزار ۵ محصول نمونه و کامل را همراه با <strong>دسته‌بندی سلسله‌مراتبی</strong>، '
		. '<strong>ویژگی وزن (۵، ۱۰، ۳۰ کیلوگرم)</strong>، <strong>ویژگی درجه (یک و دو)</strong>، '
		. '<strong>۶ تنوع برای هر محصول</strong>، <strong>قیمت اصلی و قیمت تخفیف‌خورده</strong>، '
		. '<strong>موجودی و تعداد فروش</strong>، <strong>تصویر شاخص و گالری تصاویر</strong> و '
		. '<strong>توضیحات کوتاه و بلند حرفه‌ای</strong> ایجاد می‌کند تا الگوی شما برای ساخت بقیه محصولات باشد.</p>';

	echo '<div style="display:flex;flex-wrap:wrap;gap:12px;margin:20px 0;">';
	foreach ( $counts as $label_key => $value ) {
		$labels = array(
			'products'    => 'محصول',
			'variations'  => 'تنوع قیمت',
			'attachments' => 'تصویر',
			'categories'  => 'دسته جدید',
			'reviews'     => 'نظر نمونه',
			'menu_items'  => 'آیتم منو',
		);
		echo '<div style="background:#fff;border:1px solid #dcdcde;border-radius:8px;padding:14px 20px;min-width:130px;">';
		echo '<div style="font-size:22px;font-weight:700;color:#1d2327;">' . esc_html( (string) $value ) . '</div>';
		echo '<div style="color:#646970;">' . esc_html( $labels[ $label_key ] ) . '</div>';
		echo '</div>';
	}
	echo '</div>';

	$nonce = wp_create_nonce( 'asb_do_action' );

	$buttons = array(
		array( 'key' => 'build', 'label' => 'ایجاد ۵ محصول نمونه کامل', 'style' => 'primary', 'desc' => 'دسته‌بندی، ویژگی‌ها، ۳۰ تنوع قیمت، تصاویر، موجودی و تعداد فروش' ),
		array( 'key' => 'reviews', 'label' => 'ایجاد نظرات نمونه خریداران', 'style' => 'secondary', 'desc' => '۱۵ نظر نمونه با امتیاز — پیش از انتشار با نظرات واقعی جایگزین کنید' ),
		array( 'key' => 'menu', 'label' => 'افزودن دسته‌ها به منوی اصلی', 'style' => 'secondary', 'desc' => 'دسته‌های آلو، گردو، توت خشک، برگه هلو و لواشک' ),
		array( 'key' => 'delete', 'label' => 'حذف همه داده‌های ساخته‌شده', 'style' => 'link-delete', 'desc' => 'فقط مواردی که این ابزار ساخته است حذف می‌شوند' ),
		array( 'key' => ( asb_frontend_fix_enabled() ? 'fxoff' : 'fxon' ), 'label' => ( asb_frontend_fix_enabled() ? 'غیرفعال کردن اصلاح‌های ظاهری' : 'فعال کردن اصلاح‌های ظاهری' ), 'style' => 'secondary', 'desc' => 'هم‌ترازی قاب اسلایدر و پوشش کامل تصویر در صفحه اصلی' ),
		array( 'key' => 'checkupdate', 'label' => 'بررسی فوری به‌روزرسانی', 'style' => 'secondary', 'desc' => 'نسخه جدید را همین الان از مخزن بررسی کن (بدون انتظار ۱۲ ساعته)' ),
	);

	echo '<div style="display:flex;flex-direction:column;gap:12px;max-width:760px;margin-top:24px;">';
	foreach ( $buttons as $btn ) {
		$bg      = 'primary' === $btn['style'] ? '#2271b1' : ( 'link-delete' === $btn['style'] ? '#b32d2e' : '#f6f7f7' );
		$color   = 'primary' === $btn['style'] || 'link-delete' === $btn['style'] ? '#fff' : '#1d2327';
		$border  = 'secondary' === $btn['style'] ? '1px solid #dcdcde' : '1px solid transparent';
		echo '<form method="post" style="background:#fff;border:' . esc_attr( $border ) . ';border-radius:8px;padding:16px 20px;display:flex;align-items:center;justify-content:space-between;gap:16px;flex-wrap:wrap;">';
		echo '<input type="hidden" name="asb_nonce" value="' . esc_attr( $nonce ) . '">';
		echo '<input type="hidden" name="asb_action" value="' . esc_attr( $btn['key'] ) . '">';
		echo '<div><div style="font-weight:700;font-size:15px;">' . esc_html( $btn['label'] ) . '</div>';
		echo '<div style="color:#646970;font-size:13px;margin-top:4px;">' . esc_html( $btn['desc'] ) . '</div></div>';
		echo '<button type="submit" class="button" style="background:' . esc_attr( $bg ) . ';color:' . esc_attr( $color ) . ';border:none;padding:8px 20px;height:auto;font-weight:700;border-radius:6px;cursor:pointer;">' . esc_html( $btn['label'] ) . '</button>';
		echo '</form>';
	}
	echo '</div>';

	$csv_url = wp_nonce_url( admin_url( 'admin-post.php?action=asb_csv' ), 'asb_csv' );
	echo '<div style="background:#fff;border:1px solid #dcdcde;border-radius:8px;padding:16px 20px;max-width:760px;margin-top:12px;display:flex;align-items:center;justify-content:space-between;gap:16px;flex-wrap:wrap;">';
	echo '<div><div style="font-weight:700;font-size:15px;">دانلود فایل CSV الگو</div>';
	echo '<div style="color:#646970;font-size:13px;margin-top:4px;">همین ۵ محصول به‌صورت فایل درون‌ریز ووکامرس — آن را در اکسل باز کنید، ردیف‌ها را کپی کنید و محصولات بعدی را با همین ساختار بسازید.</div></div>';
	echo '<a href="' . esc_url( $csv_url ) . '" class="button" style="background:#2271b1;color:#fff;border:none;padding:8px 20px;height:auto;font-weight:700;border-radius:6px;text-decoration:none;">دانلود CSV</a>';
	echo '</div>';

	if ( ! empty( $log ) ) {
		echo '<h2 style="margin-top:36px;">گزارش عملیات</h2>';
		echo '<div style="background:#1d2327;color:#f0f0f1;padding:16px;border-radius:8px;max-height:320px;overflow:auto;direction:rtl;text-align:right;font-family:monospace;font-size:12px;line-height:2;">';
		foreach ( array_reverse( $log ) as $entry ) {
			echo '<div>' . esc_html( $entry['time'] ) . ' — ' . esc_html( $entry['msg'] ) . '</div>';
		}
		echo '</div>';
		echo '<form method="post" style="margin-top:12px;">';
		echo '<input type="hidden" name="asb_nonce" value="' . esc_attr( $nonce ) . '">';
		echo '<input type="hidden" name="asb_action" value="clearlog">';
		echo '<button type="submit" class="button">پاک کردن گزارش</button>';
		echo '</form>';
	}

	echo '</div>';
}

/* =========================================================================
/* =========================================================================
 * 11) به‌روزرسانی خودکار افزونه (از طریق دکمه «به‌روزرسانی» در پیشخوان)
 * ========================================================================= */

/**
 * دریافت فایل معرف نسخه از مخزن.
 */
function asb_fetch_manifest() {
	$response = wp_remote_get(
		ASB_UPDATE_URL,
		array(
			'timeout' => 20,
			'headers' => array( 'Accept' => 'application/json' ),
		)
	);

	if ( is_wp_error( $response ) ) {
		return $response;
	}

	$code = (int) wp_remote_retrieve_response_code( $response );
	if ( 200 !== $code ) {
		return new WP_Error( 'asb_http', 'کد پاسخ سرور: ' . $code );
	}

	$body = wp_remote_retrieve_body( $response );
	$data = json_decode( $body );

	if ( ! $data || empty( $data->version ) || empty( $data->package ) ) {
		return new WP_Error( 'asb_json', 'فایل معرف نسخه معتبر نبود.' );
	}

	return $data;
}

/**
 * تزریق نسخه جدید به بررسی به‌روزرسانی‌های وردپرس.
 */
function asb_update_transient( $transient ) {
	if ( ! is_object( $transient ) ) {
		return $transient;
	}

	$remote = asb_fetch_manifest();
	if ( is_wp_error( $remote ) ) {
		return $transient;
	}

	if ( version_compare( ASB_VERSION, $remote->version, '<' ) ) {
		$item = array(
			'id'          => ASB_SLUG,
			'slug'        => ASB_SLUG,
			'plugin'      => ASB_BASENAME,
			'new_version' => $remote->version,
			'url'         => isset( $remote->homepage ) ? $remote->homepage : '',
			'package'     => $remote->package,
			'tested'      => isset( $remote->tested ) ? $remote->tested : '',
			'requires'    => isset( $remote->requires ) ? $remote->requires : '',
			'icons'       => array(),
			'banners'     => array(),
		);
		$transient->response[ ASB_BASENAME ] = (object) $item;
	} elseif ( isset( $transient->response[ ASB_BASENAME ] ) ) {
		unset( $transient->response[ ASB_BASENAME ] );
	}

	return $transient;
}
add_filter( 'site_transient_update_plugins', 'asb_update_transient' );

/**
 * پشتیبانی از مسیر Update URI در وردپرس ۵.۸ به بالا.
 */
function asb_update_by_hostname( $update, $plugin_data, $plugin_file ) {
	if ( ASB_BASENAME !== $plugin_file ) {
		return $update;
	}

	$remote = asb_fetch_manifest();
	if ( is_wp_error( $remote ) ) {
		return $update;
	}

	if ( version_compare( ASB_VERSION, $remote->version, '<' ) ) {
		return array(
			'id'          => ASB_SLUG,
			'slug'        => ASB_SLUG,
			'plugin'      => ASB_BASENAME,
			'new_version' => $remote->version,
			'url'         => isset( $remote->homepage ) ? $remote->homepage : '',
			'package'     => $remote->package,
		);
	}

	return $update;
}

$asb_manifest_host = wp_parse_url( ASB_UPDATE_URL, PHP_URL_HOST );
if ( ! empty( $asb_manifest_host ) ) {
	add_filter( 'update_plugins_' . $asb_manifest_host, 'asb_update_by_hostname', 10, 3 );
}

/**
 * نمایش توضیحات در پنجره «نمایش جزئیات».
 */
function asb_plugins_api( $result, $action, $args ) {
	if ( 'plugin_information' !== $action ) {
		return $result;
	}
	if ( empty( $args->slug ) || ASB_SLUG !== $args->slug ) {
		return $result;
	}

	$remote = asb_fetch_manifest();
	if ( is_wp_error( $remote ) ) {
		return $result;
	}

	$info              = new stdClass();
	$info->name        = 'ALOOKHOR Sample Builder';
	$info->slug        = ASB_SLUG;
	$info->version     = $remote->version;
	$info->requires    = isset( $remote->requires ) ? $remote->requires : '';
	$info->tested      = isset( $remote->tested ) ? $remote->tested : '';
	$info->download_link = $remote->package;
	$info->homepage    = isset( $remote->homepage ) ? $remote->homepage : '';
	$info->sections    = array(
		'description' => 'سازنده داده‌های نمونه فروشگاه آلوخور. این افزونه از طریق مخزن گیت‌هاب به‌روزرسانی می‌شود.',
		'changelog'   => isset( $remote->changelog ) ? $remote->changelog : 'تغییرات اعلام نشده است.',
	);

	return $info;
}
add_filter( 'plugins_api', 'asb_plugins_api', 20, 3 );

/**
 * پاک کردن حافظه نهان پس از نصب نسخه جدید.
 */
function asb_after_upgrade( $upgrader, $options ) {
	if ( empty( $options['type'] ) || 'plugin' !== $options['type'] ) {
		return;
	}
	if ( empty( $options['action'] ) || 'update' !== $options['action'] ) {
		return;
	}
	if ( empty( $options['plugins'] ) ) {
		return;
	}
	foreach ( (array) $options['plugins'] as $plugin ) {
		if ( ASB_BASENAME === $plugin ) {
			delete_site_transient( 'update_plugins' );
		}
	}
}
add_action( 'upgrader_process_complete', 'asb_after_upgrade', 10, 2 );

/**
 * اجرای تغییرات داده‌ای هر نسخه پس از به‌روزرسانی.
 */
function asb_maybe_upgrade() {
	$installed = (string) get_option( ASB_OPTION_VERSION, '0' );

	if ( version_compare( $installed, ASB_VERSION, '>=' ) ) {
		return;
	}

	asb_log( 'نسخه افزونه از ' . $installed . ' به ' . ASB_VERSION . ' ارتقا یافت.' );
	update_option( ASB_OPTION_VERSION, ASB_VERSION, false );
}
add_action( 'admin_init', 'asb_maybe_upgrade' );

/* =========================================================================
/* =========================================================================
 * 12) بهبودهای ظاهری صفحه اصلی (قابل خاموش کردن)
 * ========================================================================= */

function asb_frontend_fix_enabled() {
	return '1' === (string) get_option( 'asb_frontend_fix', '1' );
}

/**
 * اصلاح دو ایراد واقعیِ اسلایدر صفحه اصلی:
 *  ۱) عرض 100vw باعث می‌شد قاب هیرو با بقیه بخش‌ها هم‌تراز نباشد و کناره‌هایش
 *     بریده شود (چون 100vw عرض نوار اسکرول را هم حساب می‌کند).
 *  ۲) جابجایی افقی تصویر (translateX) در اسلایدهای برگردانده‌شده باعث می‌شد
 *     حدود ۳۰٪ سمت راست قاب خالی بماند و تصویر تمامِ عرض قاب را نگیرد.
 */
function asb_frontend_fix_css() {
	if ( is_admin() || ! asb_frontend_fix_enabled() ) {
		return;
	}

	$css = <<<'CSS'
.alookhor-mh{width:100%!important;max-width:100%!important;margin-left:0!important;margin-right:0!important}
.alookhor-mh-media{overflow:hidden!important}
.alookhor-mh-media img{display:block!important;width:100%!important;height:100%!important;min-width:100%!important;min-height:100%!important;max-width:none!important;object-fit:cover!important}
.alookhor-mh-slide.is-image-flipped .alookhor-mh-media img{transform:scale(1.02)!important}
.alookhor-mh[data-ken-burns="1"] .alookhor-mh-slide.is-active .alookhor-mh-media img{transform:scale(1.06)!important}
.alookhor-mh[data-ken-burns="1"] .alookhor-mh-slide.is-active.is-image-flipped .alookhor-mh-media img{transform:scale(1.06)!important}
@media(prefers-reduced-motion:reduce){.alookhor-mh-media img{transform:none!important}}
CSS;

	echo "\n" . '<style id="asb-frontend-fix">' . "\n" . $css . "\n" . '</style>' . "\n";
}
add_action( 'wp_head', 'asb_frontend_fix_css', 999 );

/* =========================================================================
 * 13) خروجی CSV الگو (برای ساخت سریع بقیه محصولات)
 * ========================================================================= */

/**
 * ساخت ردیف‌های CSV با فرمت استاندارد درون‌ریز ووکامرس.
 */
function asb_build_csv_rows() {
	$blueprint = asb_attribute_blueprint();
	$discount  = asb_volume_discount();
	$stock     = asb_stock_matrix();

	$header = array(
		'ID', 'Type', 'SKU', 'Name', 'Published', 'Is featured?', 'Visibility in catalog',
		'Short description', 'Description', 'Tax status', 'Tax class', 'In stock?', 'Stock',
		'Backorders allowed?', 'Sold individually?', 'Weight (kg)', 'Allow customer reviews?',
		'Sale price', 'Regular price', 'Categories', 'Tags', 'Images',
		'Parent', 'Position',
		'Attribute 1 name', 'Attribute 1 value(s)', 'Attribute 1 visible', 'Attribute 1 global',
		'Attribute 2 name', 'Attribute 2 value(s)', 'Attribute 2 visible', 'Attribute 2 global',
	);

	$rows = array( $header );

	foreach ( asb_products_blueprint() as $spec ) {

		$cats = array();
		foreach ( $spec['cats'] as $c ) {
			$cats[] = $c['name'];
		}

		$rows[] = array(
			'', 'variable', $spec['sku'], $spec['name'], '1',
			! empty( $spec['featured'] ) ? '1' : '0',
			'visible',
			$spec['short'],
			$spec['desc'],
			'taxable', '', '1', '', '0', '0', '', '1',
			'', '',
			implode( ' > ', $cats ),
			implode( ', ', $spec['tags'] ),
			'',
			'', '0',
			'وزن بسته‌بندی',
			implode( ', ', $blueprint['weight']['terms'] ),
			'1', '1',
			'درجه کیفیت',
			implode( ', ', $blueprint['grade']['terms'] ),
			'1', '1',
		);

		$position = 1;
		foreach ( array( 'w5', 'w10', 'w30' ) as $wslug ) {
			$kg = $blueprint['weight']['kg'][ $wslug ];
			foreach ( array( 'g1', 'g2' ) as $gslug ) {
				$regular = asb_money( $spec['per_kg'] * $kg * $blueprint['grade']['factor'][ $gslug ] );
				$sale    = asb_money( $regular * $discount[ $wslug ] );

				$rows[] = array(
					'', 'variation', $spec['sku'] . '-' . strtoupper( $wslug ) . '-' . strtoupper( $gslug ),
					$spec['name'] . ' - ' . $blueprint['weight']['terms'][ $wslug ] . ' - ' . $blueprint['grade']['terms'][ $gslug ],
					'1', '0', 'visible',
					'', '', 'taxable', '', '1', (string) $stock[ $wslug ][ $gslug ], '0', '0',
					(string) $kg, '1',
					(string) $sale, (string) $regular,
					'', '', '',
					'sku:' . $spec['sku'], (string) $position,
					'وزن بسته‌بندی', $blueprint['weight']['terms'][ $wslug ], '1', '1',
					'درجه کیفیت', $blueprint['grade']['terms'][ $gslug ], '1', '1',
				);
				$position++;
			}
		}
	}

	return $rows;
}

function asb_export_csv() {
	if ( ! current_user_can( 'manage_woocommerce' ) ) {
		wp_die( 'دسترسی کافی ندارید.' );
	}
	check_admin_referer( 'asb_csv' );

	$filename = 'alookhor-products-template-' . gmdate( 'Y-m-d' ) . '.csv';

	nocache_headers();
	header( 'Content-Type: text/csv; charset=UTF-8' );
	header( 'Content-Disposition: attachment; filename="' . $filename . '"' );

	$handle = fopen( 'php://output', 'w' );
	fwrite( $handle, "\xEF\xBB\xBF" ); // BOM برای اکسل

	foreach ( asb_build_csv_rows() as $row ) {
		fputcsv( $handle, $row );
	}

	fclose( $handle );
	exit;
}
add_action( 'admin_post_asb_csv', 'asb_export_csv' );

/* =========================================================================
 * 14) فعال‌سازی خودکار
 * ========================================================================= */

function asb_activate() {
	if ( ! asb_has_woocommerce() ) {
		update_option( ASB_OPTION_PENDING, 1, false );
		return;
	}
	update_option( ASB_OPTION_VERSION, ASB_VERSION, false );
	$result = asb_build_products();
	if ( is_wp_error( $result ) ) {
		asb_log( 'خطا در فعال‌سازی: ' . $result->get_error_message() );
	} else {
		asb_log( 'فعال‌سازی خودکار: ' . count( $result ) . ' محصول ایجاد شد.' );
	}
}
register_activation_hook( __FILE__, 'asb_activate' );

function asb_pending_notice() {
	if ( ! current_user_can( 'manage_woocommerce' ) ) {
		return;
	}
	if ( get_option( ASB_OPTION_PENDING ) && asb_has_woocommerce() ) {
		delete_option( ASB_OPTION_PENDING );
		$result = asb_build_products();
		if ( ! is_wp_error( $result ) ) {
			echo '<div class="notice notice-success is-dismissible"><p dir="rtl">داده‌های نمونه آلوخور با موفقیت ایجاد شد. '
				. 'برای مشاهده به منوی <strong>داده‌های نمونه آلوخور</strong> بروید.</p></div>';
		}
	}
}
add_action( 'admin_notices', 'asb_pending_notice' );
