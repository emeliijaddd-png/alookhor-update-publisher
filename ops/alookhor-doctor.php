<?php
/**
 * ALOOKHOR Doctor - one-shot diagnostic + safe repair tool
 *
 * How to use:
 *   1. Place this file in the site root (public_html) next to wp-load.php.
 *   2. Open https://your-domain/alookhor-doctor.php
 *   3. Read the report. Use the repair/test buttons as suggested.
 *   4. Click "Delete this file" when done.
 *
 * SECURITY: no authentication - DELETE after use.
 */

set_time_limit(300);
ini_set('max_execution_time', '300');
error_reporting(E_ALL);
ini_set('display_errors', '1');

$root = __DIR__ . '/';
if (!file_exists($root . 'wp-load.php')) {
	die('<meta charset="utf-8"><h2>WordPress root not found</h2><p>This file must sit directly in the site root (public_html), next to <code>wp-load.php</code>.</p>');
}

/* ---------------- helpers ---------------- */

function doctor_log(&$steps, $label, $ok, $note = '')
{
	$steps[] = array('label' => $label, 'ok' => (bool) $ok, 'note' => (string) $note);
	echo '<div class="step ' . ($ok ? 'ok' : 'bad') . '">' . ($ok ? '✔' : '✘') . ' '
		. htmlspecialchars($label)
		. ($note !== '' ? ' <span class="note">' . htmlspecialchars($note) . '</span>' : '')
		. '</div>' . "\n";
}

function doctor_count_files($dir, $cap = 5000)
{
	if (!is_dir($dir)) {
		return -1;
	}
	$n = 0;
	$it = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($dir, FilesystemIterator::SKIP_DOTS));
	foreach ($it as $f) {
		if ($f->isFile()) {
			$n++;
			if ($n >= $cap) {
				return $n;
			}
		}
	}
	return $n;
}

/* Fatal catcher: survives a PHP fatal so we can report it on the next load. */
$fatal_log = $root . '.alookhor-doctor-fatal.log';
register_shutdown_function(function () use ($fatal_log) {
	$e = error_get_last();
	if ($e && in_array($e['type'], array(E_ERROR, E_PARSE, E_CORE_ERROR, E_COMPILE_ERROR), true)) {
		$msg = $e['message'] . ' @ ' . $e['file'] . ':' . $e['line'];
		@file_put_contents($fatal_log, date('c') . ' ' . $msg . "\n", FILE_APPEND);
		// Show it right now too, so the user is not left with a blank page.
		echo '<div class="page" style="max-width:760px;margin:30px auto;padding:20px;background:#3a0d0d;border:1px solid #e74c3c;border-radius:10px;color:#fff;">'
			. '<h1 style="color:#ff9c9c;">&#10060; PHP fatal error (recorded)</h1>'
			. '<p style="direction:ltr;text-align:left;font-family:monospace;">' . htmlspecialchars($msg) . '</p>'
			. '<p>Reload this page to see the full diagnostic report with this error in the last section.</p>'
			. '</div>';
	}
});

/* Collect (and silence) errors during boot. */
$boot_errors = array();
set_error_handler(function ($no, $str, $file, $line) use (&$boot_errors) {
	if (error_reporting() & $no) {
		$boot_errors[] = $str . ' @ ' . basename((string) $file) . ':' . $line;
	}
	return true;
});

require $root . 'wp-load.php';
restore_error_handler();

global $wpdb;

$scheme = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off')
	|| (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] === 'https')
	? 'https' : 'http';
$host = isset($_SERVER['HTTP_HOST']) ? preg_replace('/:\d+$/', '', (string) $_SERVER['HTTP_HOST']) : 'unknown-host';
$base = $scheme . '://' . $host;

/* ---------------- actions ---------------- */

if (isset($_POST['action']) && $_POST['action'] === 'delete'
	&& isset($_POST['token']) && hash_equals('ALOOKHOR-DOCTOR-2026', (string) $_POST['token'])) {
	@unlink(__FILE__);
	@unlink($fatal_log);
	echo '<meta charset="utf-8"><h1>✔ Deleted</h1><p>The doctor file has been removed from the server.</p>';
	exit;
}

$steps = array();

/* Buffer action output; it is printed after the page header below. */
ob_start();

/* POST actions run BEFORE the report so the fresh state is shown. */
if (isset($_POST['action']) && $_POST['action'] === 'probe') {
	@unlink($fatal_log);
	ob_start();
	$screen_ok = false;
	if (file_exists(ABSPATH . 'wp-admin/includes/screen.php')) {
		@require_once ABSPATH . 'wp-admin/includes/screen.php';
		if (function_exists('set_current_screen')) {
			@set_current_screen('dashboard');
			$screen_ok = true;
		}
	}
	if (file_exists(ABSPATH . 'wp-admin/includes/admin.php')) {
		@require_once ABSPATH . 'wp-admin/includes/admin.php';
	}
	$probe_ok = false;
	if (function_exists('wp_common_admin')) {
		@wp_common_admin();
		@do_action('admin_enqueue_scripts', 'index.php');
		@do_action('admin_head', 'index.php');
		$probe_ok = true;
	}
	$head_out = ob_get_clean();
	if (is_file($fatal_log) && filesize($fatal_log) > 0) {
		doctor_log($steps, 'Admin page test', false, 'FATAL ERROR - saved to report (see last section)');
	} elseif ($probe_ok) {
		$links = substr_count((string) $head_out, '<link');
		$styles = substr_count((string) $head_out, '<style');
		doctor_log($steps, 'Admin page test (admin_head)', $links > 0,
			'<' . 'link tags printed: ' . $links . ' | <' . 'style: ' . $styles . ' | screen set: ' . ($screen_ok ? 'yes' : 'no'));
	} else {
		doctor_log($steps, 'Admin page test', false, 'wp-admin includes not found - core may be incomplete');
	}
	echo "<div class=\"warn\"><strong>Admin test finished.</strong> If you saw an error above it is already recorded - the report below (and the last section) shows it. You can now close this tab and reopen the doctor page.</div>\n";
}

if (isset($_POST['action']) && $_POST['action'] === 'repair') {
	/* 1. .htaccess: make sure the WordPress rewrite block exists (Apache). */
	$ht = $root . '.htaccess';
	$ht_raw = @file_get_contents($ht);
	$has_wp_block = ($ht_raw !== false)
		&& (strpos($ht_raw, '# BEGIN WordPress') !== false || strpos($ht_raw, 'RewriteEngine On') !== false);
	if (!$has_wp_block) {
		$block = "# BEGIN WordPress\n"
			. "<IfModule mod_rewrite.c>\n"
			. "RewriteEngine On\n"
			. "RewriteBase /\n"
			. "RewriteRule ^index\\.php$ - [L]\n"
			. "RewriteCond %{REQUEST_FILENAME} !-f\n"
			. "RewriteCond %{REQUEST_FILENAME} !-d\n"
			. "RewriteRule . /index.php [L]\n"
			. "</IfModule>\n"
			. "# END WordPress\n";
		$written = $ht_raw === false ? @file_put_contents($ht, $block) : @file_put_contents($ht, $block . "\n" . $ht_raw);
		doctor_log($steps, 'Repair: write WordPress .htaccess block', $written !== false, $written !== false ? $block === '' ? '' : 'block added' : 'write failed - check public_html permissions');
	} else {
		doctor_log($steps, 'Repair: .htaccess', true, 'WordPress block already present - untouched');
	}

	/* 2. Theme: files + active option. */
	$theme_dir = $root . 'wp-content/themes/hello-elementor';
	$theme_zip = $root . 'hello-elementor.zip';
	$theme_files_ok = file_exists($theme_dir . '/style.css');
	if (!$theme_files_ok && file_exists($theme_zip) && class_exists('ZipArchive')) {
		/* same robust extraction as the setup wizard */
		$z = new ZipArchive();
		if ($z->open($theme_zip) === true) {
			$tmp = sys_get_temp_dir() . '/alookhor-doc-' . getmypid();
			@mkdir($tmp, 0755, true);
			if ($z->extractTo($tmp) !== false) {
				$tr = file_exists($tmp . '/style.css') ? $tmp : null;
				if ($tr === null) {
					foreach (glob($tmp . '/*', GLOB_ONLYDIR) as $d) {
						if (file_exists($d . '/style.css')) {
							$tr = $d;
							break;
						}
					}
				}
				if ($tr !== null) {
					@mkdir($theme_dir, 0755, true);
					$it = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($tr, FilesystemIterator::SKIP_DOTS), RecursiveIteratorIterator::SELF_FIRST);
					foreach ($it as $f) {
						$dest = $theme_dir . '/' . substr($f->getPathname(), strlen($tr));
						if ($f->isDir()) {
							if (!is_dir($dest)) {
								@mkdir($dest, 0755, true);
							}
						} else {
							if (!is_dir(dirname($dest))) {
								@mkdir(dirname($dest), 0755, true);
							}
							@copy($f->getPathname(), $dest);
						}
					}
				}
				$rr = function ($d) use (&$rr) {
					foreach (scandir($d) ?: array() as $i) {
						if ($i === '.' || $i === '..') {
							continue;
						}
						$p = $d . '/' . $i;
						is_dir($p) && !is_link($p) ? $rr($p) : @unlink($p);
					}
					@rmdir($d);
				};
				$rr($tmp);
			}
			$z->close();
		}
	}
	if (file_exists($theme_dir . '/style.css')) {
		if (function_exists('switch_theme')) {
			@switch_theme('hello-elementor');
		}
		doctor_log($steps, 'Repair: Hello Elementor theme', true, $theme_files_ok ? 'files present - re-activated' : 'extracted from hello-elementor.zip - activated');
	} else {
		doctor_log($steps, 'Repair: Hello Elementor theme', false, 'theme files missing and no usable hello-elementor.zip next to this file');
	}

	/* 3. siteurl / home. */
	if (function_exists('update_option')) {
		$cur = (string) get_option('siteurl');
		if ($cur !== $base) {
			@update_option('siteurl', $base);
			@update_option('home', $base);
			doctor_log($steps, 'Repair: siteurl/home', true, "was '{$cur}' -> now {$base}");
		} else {
			doctor_log($steps, 'Repair: siteurl/home', true, "already {$base}");
		}
		if (isset($GLOBALS['wp_rewrite']) && is_object($GLOBALS['wp_rewrite']) && method_exists($GLOBALS['wp_rewrite'], 'flush_rules')) {
			$GLOBALS['wp_rewrite']->flush_rules();
		}
	}
}

if (isset($_POST['action']) && $_POST['action'] === 'deactivate_others') {
	if (function_exists('update_option')) {
		$all = (array) get_option('active_plugins', array());
		$kept = array();
		foreach ($all as $pl) {
			if (strpos($pl, 'alookhor-control-center/') === 0) {
				$kept[] = $pl;
			}
		}
		@update_option('active_plugins', $kept);
		doctor_log($steps, 'TEST: deactivate all plugins except ALOOKHOR Center', true,
			count($all) - count($kept) . ' plugins deactivated for this test (no data is changed)');
	}
}

if (isset($_POST['action']) && $_POST['action'] === 'restore_plugins') {
	if (function_exists('update_option') && isset($_POST['prev_plugins'])) {
		$list = array_filter(explode("\n", (string) $_POST['prev_plugins']));
		@update_option('active_plugins', $list);
		doctor_log($steps, 'Plugins restored', true, count($list) . ' active plugins restored');
	}
}

if (isset($_POST['action']) && $_POST['action'] === 'upload_core') {
	if (!isset($_FILES['core_zip']) || $_FILES['core_zip']['error'] !== UPLOAD_ERR_OK) {
		$err = isset($_FILES['core_zip']) ? upload_error((int) $_FILES['core_zip']['error']) : 'no file received';
		doctor_log($steps, 'Upload WordPress zip', false, $err . ' - check cPanel upload limits (upload_max_filesize / post_max_size)');
	} else {
		$name = basename((string) $_FILES['core_zip']['name']);
		if (!preg_match('/\.zip$/i', $name)) {
			doctor_log($steps, 'Upload WordPress zip', false, 'the file must be a .zip');
		} else {
			$dest = $root . 'alookhor-core-upload.zip';
			$ok = @move_uploaded_file($_FILES['core_zip']['tmp_name'], $dest);
			doctor_log($steps, 'Upload WordPress zip', $ok, $ok ? $name . ' (' . round(filesize($dest) / 1048576, 1) . ' MB) saved as alookhor-core-upload.zip' : 'move failed - check public_html permissions');
		}
	}
}

/*
 * Restore MISSING WordPress core files from a core zip.
 * Never overwrites existing files. Never touches wp-content/, wp-config*, .htaccess.
 */
if (isset($_POST['action']) && $_POST['action'] === 'restore_core') {
	$zip = null;
	foreach (array('alookhor-core-upload.zip', 'alookhor-core-download.zip') as $cand) {
		if (is_file($root . $cand)) {
			$zip = $root . $cand;
			break;
		}
	}
	if (!$zip) {
		foreach (glob($root . 'wordpress-*.zip') ?: array() as $g) {
			$zip = $g;
			break;
		}
	}

	/* No local zip: try downloading the exact version from wordpress.org. */
	$wp_version = '?';
	$vp = @file_get_contents(ABSPATH . 'wp-includes/version.php');
	if ($vp && preg_match("/wp_version\s*=\s*'([^']+)'/", $vp, $m)) {
		$wp_version = $m[1];
	}
	if (!$zip && $wp_version !== '?' && function_exists('wp_remote_get')) {
		$api = 'https://api.wordpress.org/core/download/1.2/?download[version]=' . rawurlencode($wp_version) . '&download[locale]=en_US';
		$res = @wp_remote_get($api, array('timeout' => 30, 'sslverify' => false));
		$url = trim((string) (is_array($res) ? @wp_remote_retrieve_body($res) : ''));
		if ($url !== '' && preg_match('#^https?://#', $url)) {
			$zip = $root . 'alookhor-core-download.zip';
			$dl_ok = false;
			$fh = @fopen($zip, 'wb');
			if ($fh) {
				$res2 = @wp_remote_get($url, array('timeout' => 900, 'sslverify' => false, 'stream' => $fh));
				fclose($fh);
				$dl_ok = is_array($res2) && is_file($zip) && filesize($zip) > 5000000;
			}
			if ($dl_ok) {
				doctor_log($steps, 'Core zip: download from wordpress.org', true, $url);
			} else {
				@unlink($zip);
				$zip = null;
				doctor_log($steps, 'Core zip: download from wordpress.org', false, 'server could not download ' . $url . ' - upload the zip manually instead (form below)');
			}
		} else {
			doctor_log($steps, 'Core zip: resolve download URL', false, 'api.wordpress.org not reachable from this server - upload the zip manually instead');
		}
	}

	if (!$zip) {
		doctor_log($steps, 'Restore core files', false, 'no core zip available: upload wordpress-' . $wp_version . '.zip (from wordpress.org) with the form below, or place any wordpress-*.zip into public_html, then press again');
	} elseif (!class_exists('ZipArchive')) {
		doctor_log($steps, 'Restore core files', false, 'ZipArchive extension missing on this server');
	} else {
		$z = new ZipArchive();
		if ($z->open($zip) !== true) {
			doctor_log($steps, 'Restore core files', false, 'cannot open ' . basename($zip) . ' - file may be corrupted or the upload was cut short');
		} else {
			$tmp = sys_get_temp_dir() . '/alookhor-core-' . getmypid();
			@mkdir($tmp, 0755, true);
			if ($z->extractTo($tmp) !== false) {
				$z->close();
				/* locate the WordPress root inside the extraction (may be prefixed wordpress/) */
				$wp_root = file_exists($tmp . '/wp-settings.php') ? $tmp : null;
				if ($wp_root === null) {
					foreach (glob($tmp . '/*', GLOB_ONLYDIR) ?: array() as $d) {
						if (file_exists($d . '/wp-settings.php')) {
							$wp_root = $d;
							break;
						}
					}
				}
				if ($wp_root === null) {
					doctor_log($steps, 'Restore core files', false, 'the zip does not contain a WordPress install (no wp-settings.php)');
				} else {
					$restored = 0;
					$kept = 0;
					$it = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($wp_root, FilesystemIterator::SKIP_DOTS), RecursiveIteratorIterator::SELF_FIRST);
					foreach ($it as $f) {
						$rel = substr($f->getPathname(), strlen($wp_root) + 1);
						if ($rel === '') {
							continue;
						}
						if (strpos($rel, 'wp-content/') === 0 || preg_match('#^(wp-config(#|\.)|\.htaccess)$#', $rel)) {
							$kept++;
							continue;
						}
						$target = $root . $rel;
						if ($f->isDir()) {
							if (!is_dir($target)) {
								@mkdir($target, 0755, true);
							}
							continue;
						}
						if (file_exists($target) && filesize($target) > 0) {
							$kept++;
							continue;
						}
						if (!is_dir(dirname($target))) {
							@mkdir(dirname($target), 0755, true);
						}
						if (@copy($f->getPathname(), $target)) {
							$restored++;
						}
					}
					$rr = function ($d) use (&$rr) {
						foreach (scandir($d) ?: array() as $i) {
							if ($i === '.' || $i === '..') {
								continue;
							}
							$p = $d . '/' . $i;
							is_dir($p) && !is_link($p) ? $rr($p) : @unlink($p);
						}
						@rmdir($d);
					};
					$rr($tmp);
					doctor_log($steps, 'Restore core files', $restored > 0, $restored . ' missing files restored | ' . $kept . ' untouched (already present / wp-content / config). Reload the report to verify.');
				}
			} else {
				$z->close();
				doctor_log($steps, 'Restore core files', false, 'zip extraction failed (not enough temp space?)');
			}
		}
	}
}

/* ---------------- report (GET or after action) ---------------- */

$action_out = ob_get_clean();

echo '<meta charset="utf-8"><div class="page"><h1>ALOOKHOR Doctor - Diagnostic Report</h1>';
echo '<p class="sub">This page checks the WordPress installation on THIS server and offers safe repairs. Read the ✘ lines.</p>';
if ($action_out !== '') {
	echo $action_out;
}

/* 1. environment */
$wp_version = '?';
$vp = @file_get_contents(ABSPATH . 'wp-includes/version.php');
if ($vp && preg_match("/wp_version\s*=\s*'([^']+)'/", $vp, $m)) {
	$wp_version = $m[1];
}
doctor_log($steps, 'PHP version', true, PHP_VERSION);
doctor_log($steps, 'WordPress version', $wp_version !== '?', $wp_version . ($wp_version === '?' ? ' (wp-includes/version.php missing!)' : ''));
doctor_log($steps, 'mysqli extension', class_exists('mysqli'));
doctor_log($steps, 'ZipArchive extension', class_exists('ZipArchive'));

/* 2. URLs */
$siteurl = function_exists('get_option') ? (string) get_option('siteurl') : '';
$home = function_exists('get_option') ? (string) get_option('home') : '';
doctor_log($steps, 'siteurl', $siteurl === $base || rtrim($siteurl, '/') === $base, $siteurl !== '' ? $siteurl : 'EMPTY - set it!');
doctor_log($steps, 'home', $home === $base || rtrim($home, '/') === $base, $home !== '' ? $home : 'EMPTY - set it!');
doctor_log($steps, 'Current request URL', true, $base);

/* 3. theme */
$tpl = function_exists('get_option') ? (string) get_option('template') : '';
$sty = function_exists('get_option') ? (string) get_option('stylesheet') : '';
$theme_ok = file_exists($root . 'wp-content/themes/hello-elementor/style.css');
doctor_log($steps, 'Active theme (option)', $tpl === 'hello-elementor', "template={$tpl} stylesheet={$sty}");
doctor_log($steps, 'Hello Elementor files on disk', $theme_ok, $theme_ok ? 'wp-content/themes/hello-elementor/style.css exists' : 'MISSING');

/* 4. core file integrity */
$core_files = array(
	'wp-settings.php',
	'wp-load.php',
	'wp-login.php',
	'wp-includes/version.php',
	'wp-includes/wp-db.php',
	'wp-includes/script-loader.php',
	'wp-includes/css/dashicons.min.css',
	'wp-includes/css/dist/block-library/style.min.css',
	'wp-admin/index.php',
	'wp-admin/admin-header.php',
	'wp-admin/includes/admin.php',
	'wp-admin/includes/screen.php',
	'wp-admin/css/colors/fresh.css',
	'wp-admin/css/colors/fresh-rtl.css',
	'wp-admin/css/common.css',
	'wp-admin/css/admin-menu.css',
	'wp-admin/css/login.css',
	'wp-admin/css/fonts.css',
	'wp-admin/js/common.js',
	'wp-admin/js/admin-bar.js',
);
$missing = array();
foreach ($core_files as $cf) {
	if (!file_exists($root . $cf) || filesize($root . $cf) === 0) {
		$missing[] = $cf;
	}
}
$css_count = doctor_count_files(ABSPATH . 'wp-admin/css');
$inc_css_count = doctor_count_files(ABSPATH . 'wp-includes/css');
$js_count = doctor_count_files(ABSPATH . 'wp-admin/js');
$inc_js_count = doctor_count_files(ABSPATH . 'wp-includes/js');
doctor_log($steps, 'Core files check (' . count($core_files) . ' key files)', empty($missing),
	empty($missing)
		? 'all present'
		: 'MISSING: ' . implode(', ', $missing));
doctor_log($steps, 'Core asset directories', $css_count > 50 && $inc_css_count > 10 && $js_count > 20,
	'wp-admin/css: ' . ($css_count < 0 ? 'MISSING' : $css_count . ' files')
	. ' | wp-includes/css: ' . ($inc_css_count < 0 ? 'MISSING' : $inc_css_count . ' files')
	. ' | wp-admin/js: ' . ($js_count < 0 ? 'MISSING' : $js_count . ' files')
	. ' | wp-includes/js: ' . ($inc_js_count < 0 ? 'MISSING' : $inc_js_count . ' files')
	. ($css_count < 50 ? '  <-- TOO FEW: WordPress core is incomplete!' : ''));

/* 5. HTTP self-checks: can the server serve its own CSS? */
$check_url = function ($url) {
	if (!function_exists('wp_remote_get')) {
		return 'HTTP API unavailable';
	}
	$res = @wp_remote_get($url, array('timeout' => 15, 'sslverify' => false));
	$code = is_array($res) ? (int) wp_remote_retrieve_response_code($res) : 0;
	if (is_object($res) && method_exists($res, 'get_error_message')) {
		return $res->get_error_message();
	}
	return $code === 0 ? 'no response' : 'HTTP ' . $code;
};
$r1 = $check_url($base . '/wp-admin/css/colors/fresh.css');
$r2 = $check_url($base . '/wp-includes/css/dist/block-library/style.min.css');
doctor_log($steps, 'Serve own admin CSS (over HTTP)', strpos($r1, '200') === 0, $r1);
doctor_log($steps, 'Serve own block CSS (over HTTP)', strpos($r2, '200') === 0, $r2);

/* 6. .htaccess */
$ht_raw = @file_get_contents($root . '.htaccess');
if ($ht_raw === false) {
	doctor_log($steps, '.htaccess', false, 'MISSING - pretty permalinks will not work');
} else {
	$ok_ht = (strpos($ht_raw, 'RewriteEngine On') !== false);
	doctor_log($steps, '.htaccess', $ok_ht, $ok_ht ? 'contains rewrite rules' : 'no WordPress rewrite block');
	echo '<details class="ht"><summary>.htaccess content</summary><pre>' . htmlspecialchars(substr((string) $ht_raw, 0, 1500)) . '</pre></details>';
}

/* 7. active plugins (name + version, straight from files) */
$active = function_exists('get_option') ? (array) get_option('active_plugins', array()) : array();
doctor_log($steps, 'Active plugins', true, count($active) . ' active');
foreach ($active as $pl) {
	$pf = $root . 'wp-content/plugins/' . $pl;
	$nm = '?';
	$vv = '?';
	$head = @file_get_contents($pf, false, null, 0, 8192);
	if ($head !== false) {
		if (preg_match('/Plugin Name:\s*(.+)/i', $head, $m)) {
			$nm = trim($m[1]);
		}
		if (preg_match('/Version:\s*([0-9][^ \r\n]*)/i', $head, $m)) {
			$vv = trim($m[1]);
		}
	}
	doctor_log($steps, '  - ' . $nm, file_exists($pf), 'v' . $vv . ' (' . $pl . ')');
}

/* 7b. database content (explains empty site / 404s) */
$db_content = 'unknown';
$db_content_ok = false;
if (isset($wpdb) && is_object($wpdb) && isset($wpdb->prefix) && method_exists($wpdb, 'table_exists')) {
	if ($wpdb->table_exists($wpdb->prefix . 'posts')) {
		$cnt = (int) $wpdb->get_var("SELECT COUNT(*) FROM `" . $wpdb->prefix . "posts`");
		$db_content = $cnt . ' posts/pages in database';
		$db_content_ok = $cnt > 0;
	}
}
doctor_log($steps, 'Database content', $db_content_ok, $db_content . ($db_content_ok ? '' : '  <-- the database is EMPTY: the site has no content yet, 404 pages are expected. Old shop data can only come back from a database backup.'));

/* 8. boot errors captured while loading WordPress */
if ($boot_errors) {
	doctor_log($steps, 'PHP messages during WordPress boot', false, count($boot_errors) . ' messages; first: ' . $boot_errors[0]);
	echo '<details class="ht"><summary>All boot messages</summary><pre>' . htmlspecialchars(implode("\n", array_slice($boot_errors, 0, 40))) . '</pre></details>';
} else {
	doctor_log($steps, 'PHP messages during WordPress boot', true, 'none');
}

/* 9. fatal log from previous probe run */
if (is_file($fatal_log) && filesize($fatal_log) > 0) {
	doctor_log($steps, 'FATAL ERROR recorded from previous test', false, 'see details below');
	echo '<details class="ht" open><summary>Fatal error log</summary><pre>' . htmlspecialchars((string) @file_get_contents($fatal_log)) . '</pre></details>';
}

/* ---------------- action buttons ---------------- */

$all_plugins_str = implode("\n", $active);
?>
<div class="actions">
<form method="post" style="display:inline;"><input type="hidden" name="action" value="repair"><button class="btn">🔧 Run safe repairs (theme + .htaccess + siteurl)</button></form>
<form method="post" style="display:inline;"><input type="hidden" name="action" value="probe"><button class="btn warn">🩺 Test the admin page rendering (may show an error - it gets recorded)</button></form>
</div>
<div class="actions">
<form method="post" style="display:inline;">
<input type="hidden" name="action" value="restore_core">
<button class="btn danger">📦 Restore MISSING core files (from a core zip - never overwrites anything)</button>
</form>
</div>
<div class="actions">
<form method="post" enctype="multipart/form-data" style="display:inline;">
<input type="hidden" name="action" value="upload_core">
<input type="file" name="core_zip" accept=".zip">
<button class="btn">⬆ Upload the WordPress zip (from wordpress.org, version above)</button>
</form>
</div>
<div class="hint">
<strong>How to read this:</strong><br>
• If <em>Core files check</em> or <em>Serve own admin CSS</em> is ✘ (404): the WordPress CORE on this server is incomplete. Fix: download <span dir="ltr">https://wordpress.org/wordpress-VERSION.zip</span> (VERSION = the number in the <em>WordPress version</em> line above) in your browser, upload it to <code>public_html</code> via cPanel (or use the ⬆ form), then press <strong>📦 Restore MISSING core files</strong>. It copies ONLY the missing files and never touches your wp-content, wp-config or existing files. If the big zip cannot be uploaded, tell me and we use the server's own internet or a backup instead.<br>
• If core files are all ✔ and CSS serves 200, but wp-admin still has no style: run the 🩺 test - if it records a FATAL ERROR, one of the (old) plugins is breaking the admin page; then run the 🧪 test and open wp-admin - if it becomes styled, plugins are the cause and we reactivate them one by one.<br>
• If <em>Database content</em> says the database is empty: the site has no content yet (404 pages are normal). The old shop data can only come back from a database backup - tell me if you want that.<br>
• If everything here is ✔: clear your browser cache / open wp-admin in an incognito window (Ctrl+Shift+N).
</div>
<div class="actions" style="margin-top:14px;">
<form method="post" style="display:inline;">
<input type="hidden" name="action" value="deactivate_others">
<button class="btn warn">🧪 TEST ONLY: deactivate all plugins except ALOOKHOR Center</button>
</form>
<form method="post" style="display:inline;">
<input type="hidden" name="action" value="restore_plugins">
<input type="hidden" name="prev_plugins" value="<?php echo htmlspecialchars($all_plugins_str); ?>">
<button class="btn">↩ Restore all plugins</button>
</form>
</div>
<form method="post" style="margin-top:18px;">
<input type="hidden" name="action" value="delete">
<input type="hidden" name="token" value="ALOOKHOR-DOCTOR-2026">
<button class="btn danger" type="submit" onclick="return confirm('Delete the doctor file from the server?')">⚠ Delete this file from the server</button>
</form>
</div>
<style>
 body { font-family: Tahoma, Arial, sans-serif; background: #0D0510; color: #F5F3F0; margin: 0; }
 .page { max-width: 760px; margin: 30px auto; padding: 24px; background: #1C1024; border: 1px solid #D49A2E55; border-radius: 10px; }
 h1 { color: #D49A2E; font-size: 20px; }
 .sub { color: #C8C2C9; font-size: 13px; }
 .btn { margin: 6px 6px 6px 0; padding: 10px 20px; border-radius: 6px; border: 0; background: #D49A2E; color: #0D0510; font-size: 14px; font-weight: bold; cursor: pointer; }
 .btn.warn { background: #7a5cff; color: #fff; }
 .btn.danger { background: #a33; color: #fff; }
 .hint { font-size: 12px; color: #C8C2C9; margin-top: 14px; line-height: 1.8; }
 .step { padding: 7px 10px; margin: 5px 0; border-radius: 6px; font-size: 13px; background: #0D0510; border: 1px solid #ffffff22; word-break: break-all; }
 .step.ok { border-right: 4px solid #2ecc71; }
 .step.bad { border-right: 4px solid #e74c3c; }
 .note { color: #C8C2C9; font-size: 12px; }
 .ht { margin: 8px 0; font-size: 12px; }
 .ht summary { color: #D49A2E; cursor: pointer; }
 .ht pre { background: #0D0510; border: 1px solid #ffffff22; padding: 8px; overflow: auto; max-height: 260px; direction: ltr; text-align: left; }
 .actions { margin: 10px 0; }
</style>
