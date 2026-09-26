<?php
/** Local-only router for PHP's built-in server during the GitHub Actions smoke test. */
$root = getenv('WP_SMOKE_ROOT');
if (!$root || !is_file($root . '/wp-load.php')) {
    http_response_code(503);
    exit;
}
$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
if (is_file($root . $path)) return false;
$_SERVER['SCRIPT_NAME'] = '/index.php';
require $root . '/index.php';
