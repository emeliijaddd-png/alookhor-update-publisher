<?php
/**
 * ALOOKHOR - One-time setup wizard (one-shot deployment tool)
 *
 * How to use:
 *   1. Place this file in the site root (public_html) next to wp-load.php.
 *   2. Open https://your-domain/alookhor-setup.php in the browser.
 *   3. Fill in only the fields shown, click "Install".
 *   4. Click "Delete this file" when done.
 *
 * What it does automatically:
 *   - Writes DB credentials into wp-config.php (only if placeholders present)
 *   - Runs the WordPress installer (only if the database is empty)
 *   - Extracts hello-elementor.zip / alookhor-control-center-*.zip found next
 *     to this file into wp-content (only if not already present)
 *   - Activates Hello Elementor theme and alookhor-control-center plugin
 *   - Downloads & activates WooCommerce and Elementor from wordpress.org
 *     (only if missing; skippable)
 *   - Sets siteurl/home to the current domain, sets /%postname%/ permalinks
 *
 * SECURITY: this file has no authentication. It is meant for a fresh
 * deployment only. DELETE IT after setup (button below).
 */

set_time_limit(300);
ini_set('max_execution_time', '300');
error_reporting(E_ALL);
ini_set('display_errors', '1');
ob_implicit_flush(true);

$root = __DIR__ . '/';
$results = array();
$fatal = null;

function alookhor_log(&$results, $label, $ok, $note = '')
{
	$results[] = array('label' => $label, 'ok' => (bool) $ok, 'note' => $note);
	echo '<div class="step ' . ($ok ? 'ok' : 'bad') . '">' . ($ok ? '✔' : '✘') . ' '
		. htmlspecialchars($label)
		. ($note !== '' ? ' <span class="note">' . htmlspecialchars($note) . '</span>' : '')
		. '</div>' . "\n";
}

/* Recursively delete a directory tree (best effort). */
function alookhor_rmdir($dir)
{
	if (!is_dir($dir)) {
		return;
	}
	$items = @scandir($dir);
	if ($items === false) {
		return;
	}
	foreach ($items as $item) {
		if ($item === '.' || $item === '..') {
			continue;
		}
		$path = $dir . '/' . $item;
		if (is_dir($path) && !is_link($path)) {
			alookhor_rmdir($path);
		} else {
			@unlink($path);
		}
	}
	@rmdir($dir);
}

/*
 * Copy a theme/plugin zip into its final folder, robust to the zip's internal
 * layout. The archive may contain the theme at the archive root (flat), or
 * inside a top-level folder (any name). Locates style.css / the bootstrap
 * file to determine the real root, then copies into $target_dir.
 *
 * @param string $zip_path     Path to the .zip
 * @param string $target_dir   Destination directory (created if needed)
 * @param string $marker_file  File that must exist at the theme/plugin root
 * @return bool True when $target_dir/$marker_file exists afterwards.
 */
function alookhor_extract_zip($zip_path, $target_dir, $marker_file)
{
	$z = new ZipArchive();
	if ($z->open($zip_path) !== true) {
		return file_exists($target_dir . '/' . $marker_file);
	}
	$tmp = sys_get_temp_dir() . '/alookhor-' . md5($zip_path) . '-' . getmypid();
	@mkdir($tmp, 0755, true);
	$extracted = $z->extractTo($tmp);
	$z->close();
	if (!$extracted) {
		alookhor_rmdir($tmp);
		return false;
	}
	// Find the directory that actually contains the marker file.
	$root = $tmp;
	if (!file_exists($tmp . '/' . $marker_file)) {
		$root = null;
		$sub = @glob($tmp . '/*', GLOB_ONLYDIR);
		if (is_array($sub)) {
			foreach ($sub as $d) {
				if (file_exists($d . '/' . $marker_file)) {
					$root = $d;
					break;
				}
			}
		}
		if ($root === null) {
			alookhor_rmdir($tmp);
			return false;
		}
	}
	// Copy the located root into the target directory.
	if (!is_dir($target_dir)) {
		@mkdir($target_dir, 0755, true);
	}
	$iter = new RecursiveIteratorIterator(
		new RecursiveDirectoryIterator($root, FilesystemIterator::SKIP_DOTS),
		RecursiveIteratorIterator::SELF_FIRST
	);
	foreach ($iter as $file) {
		$dest = $target_dir . '/' . substr($file->getPathname(), strlen($root));
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
	alookhor_rmdir($tmp);
	return file_exists($target_dir . '/' . $marker_file);
}

/* ------------------------------------------------------------------ */
/* Safety: this file must live in a WordPress root.                   */
/* ------------------------------------------------------------------ */
if (!file_exists($root . 'wp-load.php')) {
	die('<meta charset="utf-8"><h2>WordPress root not found</h2>'
		. '<p>This file must be placed directly in the site root (public_html), next to <code>wp-load.php</code>.</p>');
}

$config_path = $root . 'wp-config.php';
$sample_path = $root . 'wp-config-sample.php';
$config_raw = @file_get_contents($config_path);
$config_missing = ($config_raw === false);
if ($config_missing) {
	$config_raw = @file_get_contents($sample_path);
	if ($config_raw === false) {
		die('<meta charset="utf-8"><h2>wp-config.php not found</h2><p>Neither <code>wp-config.php</code> nor <code>wp-config-sample.php</code> exists in the site root - extract WordPress properly (the files must sit next to this one), then reopen this page.</p>');
	}
}
$has_placeholders = !$config_missing
	&& ((strpos($config_raw, 'ALOOKHOR_DB_NAME') !== false)
		|| (strpos($config_raw, 'ALOOKHOR_DB_USER') !== false)
		|| (strpos($config_raw, 'ALOOKHOR_DB_PASSWORD') !== false));

/* ------------------------------------------------------------------ */
/* Helpers: direct database inspection (no WordPress boot required)    */
/* ------------------------------------------------------------------ */
$alookhor_db_creds = function () use (&$config_raw) {
	$cb = function ($const) use (&$config_raw) {
		if (preg_match("/define\(\s*'{$const}'\s*,\s*'([^']*)'\s*\)/", $config_raw, $m)) {
			return $m[1];
		}
		return '';
	};
	$prefix = 'wp_';
	if (preg_match("/\\\$table_prefix\s*=\s*'([^']*)';/", $config_raw, $m)) {
		$prefix = $m[1];
	}
	return array(
		'name'   => $cb('DB_NAME'),
		'user'   => $cb('DB_USER'),
		'pass'   => $cb('DB_PASSWORD'),
		'host'   => ($cb('DB_HOST') !== '' ? $cb('DB_HOST') : 'localhost'),
		'prefix' => $prefix,
	);
};

/*
 * Returns true/false when it can determine whether the WordPress tables
 * exist, or null when it cannot. $err is set to 'NO_MYSQLI' when the
 * mysqli extension is unavailable, or to the connection error message.
 */
$alookhor_db_state = function (array $creds, &$err) {
	$err = '';
	if (!class_exists('mysqli')) {
		$err = 'NO_MYSQLI';
		return null;
	}
	try {
		$m = new mysqli($creds['host'], $creds['user'], $creds['pass'], $creds['name']);
	} catch (Exception $e) {
		$err = 'CONNECTION: ' . $e->getMessage();
		return null;
	}
	if ($m === false || $m->connect_errno) {
		$err = 'CONNECTION: ' . $m->connect_error;
		return null;
	}
	try {
		$like = $m->real_escape_string($creds['prefix'] . 'options');
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

/* ------------------------------------------------------------------ */
/* Delete action                                                       */
/* ------------------------------------------------------------------ */
if (isset($_POST['action']) && $_POST['action'] === 'delete'
	&& isset($_POST['token']) && hash_equals('ALOOKHOR-DELETE-2026', (string) $_POST['token'])) {
	$removed = @unlink(__FILE__);
	if ($removed) {
		echo '<meta charset="utf-8"><div class="page"><h1>✔ File deleted</h1>'
			. '<p>The setup file has been removed from the server.</p></div>';
	} else {
		echo '<meta charset="utf-8"><div class="page"><h1>Could not delete</h1>'
			. '<p>Please delete <code>alookhor-setup.php</code> manually from cPanel File Manager.</p></div>';
	}
	exit;
}

/* ------------------------------------------------------------------ */
/* Install action                                                      */
/* ------------------------------------------------------------------ */
if (isset($_POST['action']) && $_POST['action'] === 'install') {
	$p = function ($k) { return isset($_POST[$k]) ? trim((string) $_POST[$k]) : ''; };

	// Buffer all progress output until the WordPress phase has finished so
	// wp_install()/wp_setcookie() can still send HTTP headers cleanly.
	ob_implicit_flush(false);
	ob_start();

	$finish = function () {
		$html = ob_get_clean();
		echo $html;
		exit;
	};

	echo '<meta charset="utf-8"><div class="page"><h1>ALOOKHOR - Setup in progress</h1>';

	/* Step 1: write DB credentials into wp-config.php (or create it from the sample). */
	if ($has_placeholders || $config_missing) {
		$db_name = $p('db_name');
		$db_user = $p('db_user');
		$db_pass = $p('db_password');
		$db_prefix = $p('db_prefix') !== '' ? $p('db_prefix') : 'wp_';
		if ($db_name === '' || $db_user === '' || $db_pass === '') {
			$fatal = 'Database name, user and password are required.';
			alookhor_log($results, 'Write database credentials to wp-config.php', false, 'Missing values.');
			echo '<h2 class="err">Fatal</h2><p>' . htmlspecialchars($fatal) . '</p></div>';
			$finish();
		}
		$new = $config_raw;
		$new = preg_replace("/define\\(\\s*'DB_NAME'\\s*,\\s*'[^']*'\\s*\\);?/", "define( 'DB_NAME', '" . addslashes($db_name) . "' );", $new, 1);
		$new = preg_replace("/define\\(\\s*'DB_USER'\\s*,\\s*'[^']*'\\s*\\);?/", "define( 'DB_USER', '" . addslashes($db_user) . "' );", $new, 1);
		$new = preg_replace("/define\\(\\s*'DB_PASSWORD'\\s*,\\s*'[^']*'\\s*\\);?/", "define( 'DB_PASSWORD', '" . addslashes($db_pass) . "' );", $new, 1);
		$new = preg_replace("/\\\$table_prefix\\s*=\\s*'[^']*';/", '$table_prefix = \'' . addslashes($db_prefix) . '\';', $new, 1);
		if ($config_missing) {
			// Generate fresh, random keys/salts from the sample placeholders.
			$new = preg_replace_callback("/'put your unique phrase here'/", function () {
				return "'" . bin2hex(random_bytes(16)) . "'";
			}, $new);
		}
		$written = @file_put_contents($config_path, $new);
		alookhor_log($results, $config_missing ? 'Create wp-config.php from wp-config-sample.php' : 'Write database credentials to wp-config.php', $written !== false);
		$config_raw = $new;
	} else {
		alookhor_log($results, 'Database credentials', true, 'Already present in wp-config.php.');
	}

	/* Step 2: inspect the database directly, BEFORE booting WordPress.
	 * On an empty database the core bootstrap (wp_not_installed() in
	 * wp-settings.php) would redirect to wp-admin/install.php and exit,
	 * killing this script before the installer could run. */
	$creds = $alookhor_db_creds();
	$db_state_err = '';
	$has_tables = $alookhor_db_state($creds, $db_state_err);
	if ($has_tables === null && strpos($db_state_err, 'CONNECTION') === 0) {
		alookhor_log($results, 'Check database', false, $db_state_err);
		echo '<h2 class="err">Could not connect to the database</h2>'
			. '<p>' . htmlspecialchars($db_state_err) . '</p>'
			. '<p>Check the database name, user and password in <code>wp-config.php</code>, and make sure the database user has full privileges on the database (cPanel &gt; MySQL Databases &gt; Add User To Database), then reopen this page.</p></div>';
		$finish();
	}
	if ($has_tables === null) {
		alookhor_log($results, 'Check database (direct)', false, ($db_state_err !== 'NO_MYSQLI' ? $db_state_err : 'mysqli not available') . ' - will check during WordPress boot');
	} else {
		alookhor_log($results, 'Check database', true, $has_tables ? 'existing WordPress tables found' : 'empty database - the WordPress installer will run');
	}

	/* Step 3: boot WordPress. Defining WP_INSTALLING (the same way
	 * wp-admin/install.php does) tells the core bootstrap that we ARE the
	 * installer, so it does not hand off to the web installer on an empty
	 * database. Also defined when the direct check was not possible. */
	if ($has_tables !== true) {
		if (!defined('WP_INSTALLING')) {
			define('WP_INSTALLING', true);
		}
	}
	require $root . 'wp-load.php';
	alookhor_log($results, 'Boot WordPress', true, 'WP ' . $wp_version);

	global $wpdb;
	if ($has_tables === null) {
		$has_tables = (bool) $wpdb->get_var($wpdb->prepare('SHOW TABLES LIKE %s', $wpdb->prefix . 'options'));
		alookhor_log($results, 'Check database', true, $has_tables ? 'existing WordPress tables found' : 'empty database - the WordPress installer will run');
	}

	/* Step 4: run the installer only when the database is empty. */
	$admin_user = '';
	$admin_pass = '';
	$auto_pass  = '';
	if (!$has_tables) {
		$admin_user  = $p('admin_user') !== '' ? $p('admin_user') : 'admin';
		$admin_email = $p('admin_email') !== '' ? $p('admin_email') : 'admin@' . (isset($_SERVER['HTTP_HOST']) ? preg_replace('/:\d+$/', '', (string) $_SERVER['HTTP_HOST']) : 'example.com');
		$auto_pass = '';
		$admin_pass = $p('admin_password');
		if ($admin_pass === '') {
			// No password typed: generate a strong one and show it at the end.
			$admin_pass = function_exists('wp_generate_password') ? wp_generate_password(16, true, true) : 'Alukhor#2026';
			$auto_pass = $admin_pass;
		}
		$blog_title = $p('blog_title') !== '' ? $p('blog_title') : 'ALOOKHOR';

		require_once ABSPATH . 'wp-admin/includes/upgrade.php';
		$installed = @wp_install($blog_title, $admin_user, $admin_email, true, '', $admin_pass);
		$ok = is_array($installed);
		alookhor_log($results, 'Run WordPress installer (fresh database)', $ok, $ok ? ('admin user: ' . $admin_user) : 'Install failed.');
		if (!$ok) {
			echo '<h2 class="err">Install failed</h2><p>Check the database credentials and that the user has full privileges, then reopen this page.</p></div>';
			$finish();
		}
	} else {
		alookhor_log($results, 'Database already contains a WordPress site', true, 'Existing data preserved.');
	}

	/* Step 5: extract theme + plugin zips when present next to this file.
	 * Handles both zip layouts (theme at archive root or in a top folder). */
	if (class_exists('ZipArchive')) {
		$theme_dir = $root . 'wp-content/themes/hello-elementor';
		$theme_zip = $root . 'hello-elementor.zip';
		if (file_exists($theme_zip) && !file_exists($theme_dir . '/style.css')) {
			$good = alookhor_extract_zip($theme_zip, $theme_dir, 'style.css');
			alookhor_log($results, 'Extract hello-elementor theme', $good, $good ? '' : 'zip structure unexpected');
		} else {
			$good = file_exists($theme_dir . '/style.css');
			alookhor_log($results, 'Hello Elementor theme files', $good, $good ? 'already present' : 'missing and no zip found');
		}

		$plugin_dir = $root . 'wp-content/plugins/alookhor-control-center';
		$plugin_zip = null;
		foreach (glob($root . 'alookhor-control-center-*.zip') as $candidate) {
			$plugin_zip = $candidate;
		}
		if (!$plugin_zip) {
			$plugin_zip = $root . 'alookhor-control-center.zip';
		}
		if (file_exists($plugin_dir . '/alookhor-control-center.php')) {
			alookhor_log($results, 'alookhor-control-center plugin files', true, 'already present');
		} elseif ($plugin_zip && file_exists($plugin_zip)) {
			$good = alookhor_extract_zip($plugin_zip, $plugin_dir, 'alookhor-control-center.php');
			alookhor_log($results, 'Extract alookhor-control-center plugin', $good, $good ? '' : 'zip structure unexpected');
		} else {
			alookhor_log($results, 'alookhor-control-center plugin files', false, 'missing and no zip found');
		}
	} else {
		alookhor_log($results, 'ZipArchive extension', false, 'missing - extract the two zips manually into wp-content');
	}

	/* Step 6: activate theme + plugin. */
	$theme_ok = @switch_theme('hello-elementor');
	alookhor_log($results, 'Activate Hello Elementor theme', file_exists($root . 'wp-content/themes/hello-elementor/style.css'));

	$plugin_file = 'alookhor-control-center/alookhor-control-center.php';
	if (file_exists($root . 'wp-content/plugins/' . $plugin_file)) {
		$activated = @activate_plugin($plugin_file);
		alookhor_log($results, 'Activate alookhor-control-center', is_wp_error($activated) ? false : true,
			is_wp_error($activated) ? $activated->get_error_message() : '');
	} else {
		alookhor_log($results, 'Activate alookhor-control-center', false, 'plugin files missing');
	}

	/* Step 7: optional plugins from wordpress.org (WooCommerce, Elementor). */
	$install_woo = (isset($_POST['install_woo']) && $_POST['install_woo'] === '1') || !isset($_POST['install_woo']);
	$install_elementor = (isset($_POST['install_elementor']) && $_POST['install_elementor'] === '1') || !isset($_POST['install_elementor']);

	$ensure_remote_plugin = function ($slug, $file, $label) use ($root, &$results) {
		if (file_exists($root . 'wp-content/plugins/' . $file)) {
			$activated = @activate_plugin($file);
			alookhor_log($results, $label, is_wp_error($activated) ? false : true,
				is_wp_error($activated) ? $activated->get_error_message() : 'already present - activated');
			return;
		}
		$api = 'https://api.wordpress.org/plugins/info/1.2/?action=plugin_information&request[slug]=' . rawurlencode($slug)
			. '&request[fields][sections]=false&request[fields][ratings]=false';
		$res = wp_remote_get($api, array('timeout' => 30));
		$body = wp_remote_retrieve_body($res);
		$info = json_decode($body, true);
		$url = is_array($info) && !empty($info['download_link']) ? $info['download_link'] : '';
		if ($url === '') {
			alookhor_log($results, $label, false, 'could not resolve download link (wordpress.org API) - install manually from wp-admin');
			return;
		}
		$res2 = wp_remote_get($url, array('timeout' => 300));
		$code = wp_remote_retrieve_response_code($res2);
		if ($code !== 200) {
			alookhor_log($results, $label, false, 'download failed (HTTP ' . $code . ') - install manually from wp-admin');
			return;
		}
		$tmp = tempnam(sys_get_temp_dir(), 'alookhor-plugin');
		if ($tmp === false || file_put_contents($tmp, wp_remote_retrieve_body($res2)) === false) {
			alookhor_log($results, $label, false, 'could not write temp file');
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
			alookhor_log($results, $label, false, 'extraction failed - install manually from wp-admin');
			return;
		}
		$activated = @activate_plugin($file);
		alookhor_log($results, $label, is_wp_error($activated) ? false : true,
			is_wp_error($activated) ? $activated->get_error_message() : '');
	};

	if ($install_woo) {
		$ensure_remote_plugin('woocommerce', 'woocommerce/woocommerce.php', 'Install & activate WooCommerce (from wordpress.org)');
	}
	if ($install_elementor) {
		$ensure_remote_plugin('elementor', 'elementor/elementor.php', 'Install & activate Elementor (from wordpress.org)');
	}

	/* Step 8: URLs, permalinks, titles. */
	$scheme = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') || (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] === 'https') ? 'https' : 'http';
	$host = isset($_SERVER['HTTP_HOST']) ? preg_replace('/:\d+$/', '', (string) $_SERVER['HTTP_HOST']) : 'alookhor.ir';
	$siteurl = $scheme . '://' . $host;
	update_option('siteurl', $siteurl);
	update_option('home', $siteurl);
	alookhor_log($results, 'Set siteurl/home', true, $siteurl);

	if ($has_tables) {
		$old_title = get_option('blogname');
		if (!$old_title || strtolower($old_title) !== 'alookhor') {
			update_option('blogname', 'ALOOKHOR');
			update_option('blogdescription', '');
		}
	}

	$wp_rewrite = $GLOBALS['wp_rewrite'];
	$wp_rewrite->set_permalink_structure('/%postname%/');
	$wp_rewrite->flush_rules();
	alookhor_log($results, 'Set pretty permalinks /%postname%/', true);

	wp_cache_flush();
	alookhor_log($results, 'Done', true);

	if ($auto_pass !== '') {
		echo '<div class="warn"><strong>Admin login (save this):</strong><br>'
			. 'Username: <code>' . htmlspecialchars($admin_user) . '</code> &nbsp; Password: <code>' . htmlspecialchars($auto_pass) . '</code><br>'
			. 'You can change it later in wp-admin &gt; Users.</div>';
	}
	echo '<p><strong>Summary:</strong> open <a href="' . htmlspecialchars($siteurl) . '" target="_blank">' . htmlspecialchars($siteurl) . '</a> '
		. 'and <a href="' . htmlspecialchars($siteurl . '/wp-admin/') . '" target="_blank">wp-admin</a>.</p>';
	echo '<form method="post" style="margin-top:18px;">'
		. '<input type="hidden" name="action" value="delete">'
		. '<input type="hidden" name="token" value="ALOOKHOR-DELETE-2026">'
		. '<button class="btn danger" type="submit" onclick="return confirm(\'Delete the setup file from the server?\')">⚠ Delete this file from the server</button> '
		. '</form>';
	echo '</div>';
	$finish();
}

/* ------------------------------------------------------------------ */
/* Show the form (GET)                                                 */
/* ------------------------------------------------------------------ */
$need_db = $has_placeholders || $config_missing;
$need_admin = false;
$note = '';
if (!$need_db) {
	/* Inspect the database directly (no boot): booting an empty site would
	 * trigger core's redirect to wp-admin/install.php before the form could
	 * render. */
	$creds = $alookhor_db_creds();
	$db_state_err = '';
	$has_tables = $alookhor_db_state($creds, $db_state_err);
	if ($has_tables === null && strpos($db_state_err, 'CONNECTION') !== 0) {
		// Direct check not possible (no mysqli, or query failed) - ask the
		// core boot instead (WP_INSTALLING keeps it from redirecting away).
		define('WP_INSTALLING', true);
		require $root . 'wp-load.php';
		global $wpdb;
		$has_tables = (bool) $wpdb->get_var($wpdb->prepare('SHOW TABLES LIKE %s', $wpdb->prefix . 'options'));
	}
	if ($has_tables === null) {
		$need_admin = true;
		$note = 'Could not check the database (' . $db_state_err . ') - if the database is empty, the WordPress installer will run during setup.';
	} elseif (!$has_tables) {
		$need_admin = true;
		$note = 'The database is empty - the WordPress installer will run and create the admin account from the fields below.';
	} else {
		$note = 'An existing WordPress site was found in the database - all previous data will be preserved.';
	}
} elseif ($config_missing) {
	$need_admin = true;
	$note = 'wp-config.php was not found - it will be created automatically from wp-config-sample.php using the values you enter. If the database is empty, the admin account will also be created from the admin fields below.';
}
?>
<!doctype html>
<html lang="fa" dir="rtl">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>ALOOKHOR - One-time setup</title>
<style>
 body { font-family: Tahoma, Arial, sans-serif; background: #0D0510; color: #F5F3F0; margin: 0; }
 .page { max-width: 640px; margin: 40px auto; padding: 24px; background: #1C1024; border: 1px solid #D49A2E55; border-radius: 10px; }
 h1 { color: #D49A2E; font-size: 20px; }
 h2.err { color: #ff7b7b; }
 label { display: block; margin: 12px 0 4px; font-size: 13px; color: #C8C2C9; }
 input[type=text], input[type=password], input[type=email] { width: 100%; box-sizing: border-box; padding: 9px; border-radius: 6px; border: 1px solid #D49A2E55; background: #0D0510; color: #F5F3F0; font-size: 14px; direction: ltr; text-align: left; }
 .row { display: flex; gap: 10px; } .row > div { flex: 1; }
 .btn { margin-top: 22px; padding: 11px 26px; border-radius: 6px; border: 0; background: #D49A2E; color: #0D0510; font-size: 15px; font-weight: bold; cursor: pointer; }
 .btn.danger { background: #a33; color: #fff; }
 .hint { font-size: 12px; color: #C8C2C9; margin-top: 6px; line-height: 1.7; }
 .step { padding: 7px 10px; margin: 5px 0; border-radius: 6px; font-size: 13px; background: #0D0510; border: 1px solid #ffffff22; }
 .step.ok { border-right: 4px solid #2ecc71; }
 .step.bad { border-right: 4px solid #e74c3c; }
 .note { color: #C8C2C9; font-size: 12px; }
 .warn { background: #33200a; border: 1px solid #D49A2E88; padding: 10px; border-radius: 6px; font-size: 13px; margin: 10px 0; line-height: 1.8; }
</style>
</head>
<body>
<div class="page">
<h1>ALOOKHOR - One-time setup</h1>
<?php if ($note !== ''): ?><div class="warn"><?php echo htmlspecialchars($note); ?></div><?php endif; ?>
<div class="warn">
After a successful setup, <strong>be sure to delete this file</strong> (the button at the end).<br>
مطمئن شوید این فایل در کنار <code>wp-load.php</code> (یعنی ریشه‌ی public_html) قرار دارد.
</div>
<form method="post">
<input type="hidden" name="action" value="install">
<?php if ($need_db): ?>
	<label>Database name (نام دیتابیس)</label>
	<input type="text" name="db_name" required placeholder="cpanel123_alookhor">
	<div class="row">
		<div><label>Database user (کاربر دیتابیس)</label><input type="text" name="db_user" required></div>
		<div><label>Table prefix (پیشوند جدول‌ها)</label><input type="text" name="db_prefix" value="wp_"></div>
	</div>
	<label>Database password (رمز دیتابیس)</label>
	<input type="password" name="db_password" required>
	<div class="hint">Values can be found under cPanel &gt; MySQL Databases. If the old database still exists, enter its values (with the correct prefix) and all previous data will be preserved.</div>
<?php endif; ?>
<?php if ($need_admin): ?>
	<div class="row">
		<div><label>Admin username</label><input type="text" name="admin_user" value="admin"></div>
		<div><label>Admin email</label><input type="email" name="admin_email" value="admin@alookhor.ir"></div>
	</div>
	<label>Admin password (leave empty to auto-generate - shown at the end)</label>
	<input type="password" name="admin_password" placeholder="e.g. MyStrongPass123">
	<label>Site title</label>
	<input type="text" name="blog_title" value="ALOOKHOR">
<?php endif; ?>
<div class="hint" style="margin-top:14px;">
	<label style="display:inline;"><input type="checkbox" name="install_woo" value="1" checked style="width:auto"> Install & activate WooCommerce (from wordpress.org, if missing)</label><br>
	<label style="display:inline;"><input type="checkbox" name="install_elementor" value="1" checked style="width:auto"> Install & activate Elementor (from wordpress.org, if missing)</label>
</div>
<button class="btn" type="submit">Start installation</button>
</form>
</div>
</body>
</html>
