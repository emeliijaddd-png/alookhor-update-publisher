<?php
/**
 * ALOOKHOR - One-shot pre-configured installer (new host)
 *
 * DB credentials for THIS host are built in below (from cPanel).
 * Place this file in public_html next to wp-load.php and open its URL.
 * It will: fix wp-config.php, install WordPress (empty database),
 * install + activate the theme/plugin zips found next to it,
 * download WooCommerce/Elementor if possible, set URLs/permalinks,
 * and show the admin login.
 *
 * SECURITY: contains the DB password - DELETE THE FILE AFTER SETUP (button below).
 */

set_time_limit(900);
ini_set('max_execution_time', '900');
error_reporting(E_ALL);
ini_set('display_errors', '1');
ob_implicit_flush(true);

/* ---------------- THIS HOST (from cPanel) ---------------- */
define('ALOOKHOR_DB_NAME', 'ocxqiiIt_alooshop');
define('ALOOKHOR_DB_USER', 'ocxqiiIt_hamidshop');
define('ALOOKHOR_DB_PASS', 'aI?uaad!xYuL-*iy');
define('ALOOKHOR_DB_HOST', 'localhost');
define('ALOOKHOR_PREFIX', 'wp_');

define('ALOOKHOR_ADMIN_USER', 'admin');
define('ALOOKHOR_ADMIN_PASS', 'Vt7#mKq2!xWp9@Az');
define('ALOOKHOR_ADMIN_EMAIL', 'admin@alookhor.ir');
define('ALOOKHOR_TITLE', 'ALOOKHOR');
/* ---------------------------------------------------------- */

$root = __DIR__ . '/';
$fatal = null;

function inst_log(&$results, $label, $ok, $note = '')
{
	$results[] = array('label' => $label, 'ok' => (bool) $ok, 'note' => $note);
	echo '<div class="step ' . ($ok ? 'ok' : 'bad') . '">' . ($ok ? '✔' : '✘') . ' '
		. htmlspecialchars($label)
		. ($note !== '' ? ' <span class="note">' . htmlspecialchars($note) . '</span>' : '')
		. '</div>' . "\n";
}

/* Recursively delete a directory tree (best effort). */
function inst_rmdir($dir)
{
	if (!is_dir($dir)) {
		return;
	}
	foreach (scandir($dir) ?: array() as $item) {
		if ($item === '.' || $item === '..') {
			continue;
		}
		$path = $dir . '/' . $item;
		if (is_dir($path) && !is_link($path)) {
			inst_rmdir($path);
		} else {
			@unlink($path);
		}
	}
	@rmdir($dir);
}

/* Robust zip -> folder copy (works for flat or nested zip layouts). */
function inst_extract_zip($zip_path, $target_dir, $marker_file)
{
	if (!class_exists('ZipArchive')) {
		return file_exists($target_dir . '/' . $marker_file);
	}
	$z = new ZipArchive();
	if ($z->open($zip_path) !== true) {
		return file_exists($target_dir . '/' . $marker_file);
	}
	$tmp = sys_get_temp_dir() . '/alookhor-' . md5($zip_path) . '-' . getmypid();
	@mkdir($tmp, 0755, true);
	$extracted = $z->extractTo($tmp);
	$z->close();
	if (!$extracted) {
		inst_rmdir($tmp);
		return false;
	}
	$src_root = $tmp;
	if (!file_exists($tmp . '/' . $marker_file)) {
		$src_root = null;
		foreach (glob($tmp . '/*', GLOB_ONLYDIR) ?: array() as $d) {
			if (file_exists($d . '/' . $marker_file)) {
				$src_root = $d;
				break;
			}
		}
		if ($src_root === null) {
			inst_rmdir($tmp);
			return false;
		}
	}
	if (!is_dir($target_dir)) {
		@mkdir($target_dir, 0755, true);
	}
	$iter = new RecursiveIteratorIterator(
		new RecursiveDirectoryIterator($src_root, FilesystemIterator::SKIP_DOTS),
		RecursiveIteratorIterator::SELF_FIRST
	);
	foreach ($iter as $file) {
		$dest = $target_dir . '/' . substr($file->getPathname(), strlen($src_root));
		if ($file->isDir()) {
			if (!is_dir($dest)) {
				@mkdir($dest, 0755, true);
			}
		} else {
			if (!is_dir(dirname($dest))) {
				@mkdir(dirname($dest), 0755, true);
			}
			@copy($file->getPathname(), $dest);
		}
	}
	inst_rmdir($tmp);
	return file_exists($target_dir . '/' . $marker_file);
}

/* ---------------- delete action ---------------- */
if (isset($_POST['action']) && $_POST['action'] === 'delete'
	&& isset($_POST['token']) && hash_equals('ALOOKHOR-INSTALL-2026', (string) $_POST['token'])) {
	$removed = @unlink(__FILE__);
	echo '<meta charset="utf-8"><h1>' . ($removed ? '✔ File deleted' : 'Could not delete') . '</h1>'
		. ($removed ? '<p>The installer file has been removed.</p>' : '<p>Please delete <code>alookhor-install.php</code> manually from cPanel.</p>')
		. '</div>';
	exit;
}

if (!file_exists($root . 'wp-load.php')) {
	die('<meta charset="utf-8"><h2>WordPress root not found</h2><p>This file must be placed directly in the site root (public_html), next to <code>wp-load.php</code>.</p>');
}

/* ---------------- 1. core integrity ---------------- */
$results = array();
echo '<meta charset="utf-8"><div class="page"><h1>ALOOKHOR - یک‌مرحله‌ای نصب</h1>';

$fatal_core = array();
$warn_core = array();
foreach (array('wp-settings.php', 'wp-load.php', 'wp-login.php', 'wp-includes/version.php',
	'wp-includes/wp-db.php', 'wp-admin/includes/upgrade.php', 'wp-admin/includes/admin.php') as $f) {
	if (!file_exists($root . $f)) {
		$fatal_core[] = $f;
	}
}
foreach (array('wp-admin/css/colors/fresh.css', 'wp-includes/css/dashicons.min.css') as $f) {
	if (!file_exists($root . $f)) {
		$warn_core[] = $f;
	}
}
if ($fatal_core) {
	$fatal = 'Core files missing: ' . implode(', ', $fatal_core);
	inst_log($results, 'بررسی کامل بودن فایل‌های وردپرس', false, 'فایل‌های زیر گم هستند: ' . implode('، ', $fatal_core));
	echo '<h2 class="err">فایل‌های وردپرس کامل نیستند</h2>'
		. '<p>zip وردپرس به‌طور کامل extract نشده است. فایل وردپرس را دوباره دانلود/extract کنید (تمام پوشه‌ها، به‌خصوص <code>wp-admin</code> و <code>wp-includes</code>) و دوباره این صفحه را باز کنید.</p></div>';
	exit;
}
if ($warn_core) {
	inst_log($results, 'بررسی کامل بودن فایل‌های وردپرس', true, 'هسته کامل است؛ اما فایل CSS گم است: ' . implode('، ', $warn_core) . ' - ممکن است ظاهر بدون استایل بماند (قابل تعمیر با alookhor-doctor.php)');
} else {
	inst_log($results, 'بررسی کامل بودن فایل‌های وردپرس', true, 'core files OK');
}

/* ---------------- 2. write DB credentials into wp-config.php ---------------- */
$config_path = $root . 'wp-config.php';
$sample_path = $root . 'wp-config-sample.php';
$config_raw = @file_get_contents($config_path);
$config_missing = ($config_raw === false);
if ($config_missing) {
	$config_raw = @file_get_contents($sample_path);
	if ($config_raw === false) {
		$fatal = 'No wp-config.php';
		inst_log($results, 'ایجاد wp-config.php', false, 'نه wp-config.php نه wp-config-sample.php پیدا شد');
		echo '<h2 class="err">wp-config.php پیدا نشد</h2><p>فایل‌های وردپرس ناقص هستند - دوباره extract کنید.</p></div>';
		exit;
	}
}
$new = $config_raw;
$new = preg_replace('/define\s*\(\s*\'DB_NAME\'\s*,\s*\'[^\']*\'\s*\);?/', "define( 'DB_NAME', '" . ALOOKHOR_DB_NAME . "' );", $new, 1);
$new = preg_replace('/define\s*\(\s*\'DB_USER\'\s*,\s*\'[^\']*\'\s*\);?/', "define( 'DB_USER', '" . ALOOKHOR_DB_USER . "' );", $new, 1);
$new = preg_replace('/define\s*\(\s*\'DB_PASSWORD\'\s*,\s*\'[^\']*\'\s*\);?/', "define( 'DB_PASSWORD', '" . ALOOKHOR_DB_PASS . "' );", $new, 1);
$new = preg_replace('/define\s*\(\s*\'DB_HOST\'\s*,\s*\'[^\']*\'\s*\);?/', "define( 'DB_HOST', '" . ALOOKHOR_DB_HOST . "' );", $new, 1);
$new = preg_replace('/\$table_prefix\s*=\s*\'[^\']*\'\s*;/', '$table_prefix = \'' . ALOOKHOR_PREFIX . '\';', $new, 1);
if ($config_missing) {
	$new = preg_replace_callback("/'put your unique phrase here'/", function () {
		return "'" . bin2hex(random_bytes(16)) . "'";
	}, $new);
}
$written = @file_put_contents($config_path, $new);
inst_log($results, 'درج اطلاعات دیتابیس در wp-config.php', $written !== false, $written !== false ? 'دیتابیس: ' . ALOOKHOR_DB_NAME . ' / کاربر: ' . ALOOKHOR_DB_USER : 'نکوت - اجازه نوشتن فایل را چک کنید');
if ($written === false) {
	echo '<h2 class="err">نمی‌توان روی wp-config.php نوشت</h2><p>دسترسی نوشتن پوشه public_html را در cPanel چک کنید (permissions = 644 برای فایل، 755 برای پوشه).</p></div>';
	exit;
}
$config_raw = $new;

/* ---------------- 3. direct DB check ---------------- */
$alookhor_db_state = function (&$err) {
	$err = '';
	if (!class_exists('mysqli')) {
		$err = 'NO_MYSQLI';
		return null;
	}
	try {
		$m = new mysqli(ALOOKHOR_DB_HOST, ALOOKHOR_DB_USER, ALOOKHOR_DB_PASS, ALOOKHOR_DB_NAME);
	} catch (Exception $e) {
		$err = 'CONNECTION: ' . $e->getMessage();
		return null;
	}
	if ($m === false || $m->connect_errno) {
		$err = 'CONNECTION: ' . $m->connect_error;
		return null;
	}
	try {
		$like = $m->real_escape_string(ALOOKHOR_PREFIX . 'options');
		$res = $m->query("SHOW TABLES LIKE '$like'");
	} catch (Exception $e) {
		$err = 'QUERY: ' . $e->getMessage();
		$m->close();
		return null;
	}
	if ($res === false) {
		$err = 'QUERY: ' . $m->error;
		$m->close();
		return null;
	}
	$has = ($res->num_rows > 0);
	$m->close();
	return $has;
};
$db_err = '';
$has_tables = $alookhor_db_state($db_err);
if ($has_tables === null && strpos($db_err, 'CONNECTION') === 0) {
	inst_log($results, 'اتصال به دیتابیس', false, $db_err);
	echo '<h2 class="err">اتصال به دیتابیس ناموفق بود</h2><p><span dir="ltr">' . htmlspecialchars($db_err) . '</span></p>'
		. '<p>در cPanel &gt; MySQL Databases مطمئن شوید: (۱) دیتابیس <b>' . ALOOKHOR_DB_NAME . '</b> ساخته شده، (۲) کاربر <b>' . ALOOKHOR_DB_USER . '</b> با <b>ALL PRIVILEGES</b> به این دیتابیس Add شده (Add User To Database)، (۳) رمز کاربر دقیقاً همینه که در بالای این فایل درج شده.</p></div>';
	exit;
}
if ($has_tables === null) {
	inst_log($results, 'بررسی دیتابیس (مستقیم)', false, ($db_err !== 'NO_MYSQLI' ? $db_err : 'افزونه mysqli در دسترس نیست') . ' - در ادامه بررسی می‌شود');
} else {
	inst_log($results, 'اتصال به دیتابیس', true, $has_tables ? 'جداول وردپرس وجود دارد (نصب قبلی)' : 'دیتابیس خالی است - وردپرس نصب می‌شود');
}

/* ---------------- 4. boot WordPress ---------------- */
if ($has_tables !== true) {
	if (!defined('WP_INSTALLING')) {
		define('WP_INSTALLING', true);
	}
}
require $root . 'wp-load.php';
inst_log($results, 'بوت وردپرس', true, 'WP ' . $wp_version);

global $wpdb;
if ($has_tables === null) {
	$has_tables = (bool) $wpdb->get_var($wpdb->prepare('SHOW TABLES LIKE %s', $wpdb->prefix . 'options'));
	inst_log($results, 'بررسی دیتابیس', true, $has_tables ? 'جداول وردپرس موجود' : 'دیتابیس خالی - نصب می‌شود');
}

/* ---------------- 5. install (only on empty database) ---------------- */
$ran_install = false;
if (!$has_tables) {
	require_once ABSPATH . 'wp-admin/includes/upgrade.php';
	$installed = @wp_install(ALOOKHOR_TITLE, ALOOKHOR_ADMIN_USER, ALOOKHOR_ADMIN_EMAIL, true, '', ALOOKHOR_ADMIN_PASS);
	$ok = is_array($installed);
	inst_log($results, 'نصب وردپرس (دیتابیس خالی)', $ok, $ok ? ('کاربر مدیریت: ' . ALOOKHOR_ADMIN_USER) : 'نصب ناموفق بود');
	$ran_install = $ok;
	if (!$ok) {
		echo '<h2 class="err">نصب وردپرس ناموفق بود</h2><p>اطلاعات دیتابیس و دسترسی‌ها (ALL PRIVILEGES) را در cPanel چک کنید و دوباره این صفحه را باز کنید.</p></div>';
		exit;
	}
} else {
	inst_log($results, 'سایت موجود پیدا شد', true, 'داده‌های قبلی دست‌نخورده ماند');
}

/* ---------------- 6. .htaccess rewrite block ---------------- */
$ht = $root . '.htaccess';
$ht_raw = @file_get_contents($ht);
if ($ht_raw === false || strpos($ht_raw, 'RewriteEngine On') === false) {
	$block = "# BEGIN WordPress\n<IfModule mod_rewrite.c>\nRewriteEngine On\nRewriteBase /\nRewriteRule ^index\\.php$ - [L]\nRewriteCond %{REQUEST_FILENAME} !-f\nRewriteCond %{REQUEST_FILENAME} !-d\nRewriteRule . /index.php [L]\n</IfModule>\n# END WordPress\n";
	$w = $ht_raw === false ? @file_put_contents($ht, $block) : @file_put_contents($ht, $block . "\n" . $ht_raw);
	inst_log($results, 'تنظیم .htaccess (permalinks)', $w !== false, $w !== false ? 'بلوک وردپرس اضافه شد' : 'نکوت شد');
} else {
	inst_log($results, 'تنظیم .htaccess (permalinks)', true, 'بلوک وردپرس موجود است');
}

/* ---------------- 7. theme + plugin zips ---------------- */
$theme_dir = $root . 'wp-content/themes/hello-elementor';
$theme_zip = $root . 'hello-elementor.zip';
if (file_exists($theme_zip) && !file_exists($theme_dir . '/style.css')) {
	$good = inst_extract_zip($theme_zip, $theme_dir, 'style.css');
	inst_log($results, 'نصب تم Hello Elementor', $good, $good ? '' : 'ساختار zip انتظار نمی‌رفت');
} else {
	$good = file_exists($theme_dir . '/style.css');
	inst_log($results, 'تم Hello Elementor', $good, $good ? 'موجود است' : 'فایل hello-elementor.zip کنار این فایل نیست - آن را آپلود کنید');
}

$plugin_dir = $root . 'wp-content/plugins/alookhor-control-center';
$plugin_zip = null;
foreach (glob($root . 'alookhor-control-center-*.zip') ?: array() as $candidate) {
	$plugin_zip = $candidate;
}
if (!$plugin_zip) {
	$plugin_zip = $root . 'alookhor-control-center.zip';
}
if (file_exists($plugin_dir . '/alookhor-control-center.php')) {
	inst_log($results, 'افزونه alookhor-control-center', true, 'موجود است');
} elseif ($plugin_zip && file_exists($plugin_zip)) {
	$good = inst_extract_zip($plugin_zip, $plugin_dir, 'alookhor-control-center.php');
	inst_log($results, 'نصب افزونه alookhor-control-center', $good, $good ? '' : 'ساختار zip انتظار نمی‌رفت');
} else {
	inst_log($results, 'افزونه alookhor-control-center', false, 'zip این افزونه کنار این فایل نیست - آن را آپلود کنید');
}

/* ---------------- 8. activate theme + plugin ---------------- */
@switch_theme('hello-elementor');
inst_log($results, 'فعال‌سازی تم Hello Elementor', file_exists($theme_dir . '/style.css'));

$plugin_file = 'alookhor-control-center/alookhor-control-center.php';
if (file_exists($root . 'wp-content/plugins/' . $plugin_file)) {
	$activated = @activate_plugin($plugin_file);
	inst_log($results, 'فعال‌سازی alookhor-control-center', !is_wp_error($activated), is_wp_error($activated) ? $activated->get_error_message() : '');
} else {
	inst_log($results, 'فعال‌سازی alookhor-control-center', false, 'فایل افزونه موجود نیست');
}

/* ---------------- 9. WooCommerce + Elementor (best effort) ---------------- */
$ensure_remote_plugin = function ($slug, $file, $label) use ($root, &$results) {
	if (file_exists($root . 'wp-content/plugins/' . $file)) {
		$activated = @activate_plugin($file);
		inst_log($results, $label, !is_wp_error($activated), is_wp_error($activated) ? $activated->get_error_message() : 'موجود است - فعال شد');
		return;
	}
	if (!function_exists('wp_remote_get')) {
		inst_log($results, $label, false, 'از wp-admin &gt; Plugins به‌صورت دستی نصب کنید');
		return;
	}
	$api = 'https://api.wordpress.org/plugins/info/1.2/?action=plugin_information&request[slug]=' . rawurlencode($slug)
		. '&request[fields][sections]=false&request[fields][ratings]=false';
	$res = @wp_remote_get($api, array('timeout' => 30, 'sslverify' => false));
	$info = json_decode((string) wp_remote_retrieve_body($res), true);
	$url = is_array($info) && !empty($info['download_link']) ? $info['download_link'] : '';
	if ($url === '') {
		inst_log($results, $label, false, 'سرور به wordpress.org دسترسی ندارد - از wp-admin &gt; Plugins به‌صورت دستی نصب کنید');
		return;
	}
	$res2 = @wp_remote_get($url, array('timeout' => 600, 'sslverify' => false));
	$code = wp_remote_retrieve_response_code($res2);
	if ($code !== 200) {
		inst_log($results, $label, false, 'دانلود ناموفق (HTTP ' . $code . ') - از wp-admin &gt; Plugins به‌صورت دستی نصب کنید');
		return;
	}
	$tmp = tempnam(sys_get_temp_dir(), 'alookhor-plugin');
	if ($tmp === false || file_put_contents($tmp, wp_remote_retrieve_body($res2)) === false) {
		inst_log($results, $label, false, 'نوشتن فایل موقت ناموفق بود');
		return;
	}
	if (!class_exists('ZipArchive')) {
		inst_log($results, $label, false, 'افزونه zip در سرور نیست - از wp-admin &gt; Plugins به‌صورت دستی نصب کنید');
		return;
	}
	$z = new ZipArchive();
	$ok = false;
	if ($z->open($tmp) === true) {
		$z->extractTo($root . 'wp-content/plugins/');
		$z->close();
		$ok = file_exists($root . 'wp-content/plugins/' . $file);
	}
	@unlink($tmp);
	if (!$ok) {
		inst_log($results, $label, false, 'extract ناموفق - از wp-admin &gt; Plugins به‌صورت دستی نصب کنید');
		return;
	}
	$activated = @activate_plugin($file);
	inst_log($results, $label, !is_wp_error($activated), is_wp_error($activated) ? $activated->get_error_message() : '');
};
$ensure_remote_plugin('woocommerce', 'woocommerce/woocommerce.php', 'نصب و فعال‌سازی WooCommerce (از wordpress.org)');
$ensure_remote_plugin('elementor', 'elementor/elementor.php', 'نصب و فعال‌سازی Elementor (از wordpress.org)');

/* ---------------- 10. URLs + permalinks + title ---------------- */
$scheme = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off')
	|| (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] === 'https')
	? 'https' : 'http';
$host = isset($_SERVER['HTTP_HOST']) ? preg_replace('/:\d+$/', '', (string) $_SERVER['HTTP_HOST']) : 'alookhor.ir';
$siteurl = $scheme . '://' . $host;
update_option('siteurl', $siteurl);
update_option('home', $siteurl);
inst_log($results, 'تنظیم آدرس سایت', true, $siteurl);

if (!$has_tables) {
	/* fresh install: set the shop title */
}
update_option('blogname', ALOOKHOR_TITLE);
$wp_rewrite = $GLOBALS['wp_rewrite'];
$wp_rewrite->set_permalink_structure('/%postname%/');
$wp_rewrite->flush_rules();
inst_log($results, 'تنظیم permalinks /%postname%/', true);
wp_cache_flush();
inst_log($results, 'پایان', true);

/* ---------------- done ---------------- */
echo '<div class="warn"><strong>ورود به پیشخوان (حتماً ذخیره کنید):</strong><br>'
	. 'نام کاربری: <code>' . htmlspecialchars(ALOOKHOR_ADMIN_USER) . '</code> &nbsp; رمز عبور: <code>' . htmlspecialchars(ALOOKHOR_ADMIN_PASS) . '</code><br>'
	. 'بعد از ورود می‌توانید رمز را از wp-admin &gt; Users عوض کنید.</div>';
echo '<p><strong>حالا این‌ها را باز کنید:</strong> <a href="' . htmlspecialchars($siteurl) . '" target="_blank">سایت</a> | <a href="' . htmlspecialchars($siteurl . '/wp-admin/') . '" target="_blank">پیشخوان</a></p>';
echo '<p class="sub">اگر سایت یا پیشخوان بدون استایل بود: فایل‌های هسته ناقص هستند - alookhor-doctor.php را اجرا کنید (بخش Restore core).<br>اگر WooCommerce یا Elementor ✘ شد: از wp-admin &gt; Plugins &gt; Add New به‌صورت دستی نصب و فعال کنید.</p>';
echo '<form method="post" style="margin-top:18px;">'
	. '<input type="hidden" name="action" value="delete">'
	. '<input type="hidden" name="token" value="ALOOKHOR-INSTALL-2026">'
	. '<button class="btn danger" type="submit" onclick="return confirm(\'حالا این فایل را از سرور حذف کنم؟\')">⚠ حذف این فایل از سرور (حتماً بزنید)</button> '
	. '</form>';
echo '</div>';
echo '<style>
 body { font-family: Tahoma, Arial, sans-serif; background: #0D0510; color: #F5F3F0; margin: 0; direction: rtl; }
 .page { max-width: 700px; margin: 30px auto; padding: 24px; background: #1C1024; border: 1px solid #D49A2E55; border-radius: 10px; }
 h1 { color: #D49A2E; font-size: 20px; }
 h2.err { color: #ff7b7b; }
 .btn { margin-top: 10px; padding: 11px 26px; border-radius: 6px; border: 0; background: #a33; color: #fff; font-size: 15px; font-weight: bold; cursor: pointer; }
 .hint, .sub { font-size: 12px; color: #C8C2C9; margin-top: 8px; line-height: 1.8; }
 .step { padding: 7px 10px; margin: 5px 0; border-radius: 6px; font-size: 13px; background: #0D0510; border: 1px solid #ffffff22; }
 .step.ok { border-left: 4px solid #2ecc71; }
 .step.bad { border-left: 4px solid #e74c3c; }
 .note { color: #C8C2C9; font-size: 12px; }
 .warn { background: #33200a; border: 1px solid #D49A2E88; padding: 10px; border-radius: 6px; font-size: 13px; margin: 10px 0; line-height: 1.9; }
</style>';
