<?php
// Router for PHP built-in server to run WordPress nicely.
// Usage:
//   php -S localhost:8000 -t C:\git\wolftrap.oysters C:\git\wolftrap.oysters\router.php
// - Serves static files directly
// - Routes everything else to index.php

$uri = urldecode(parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH));
$path = __DIR__ . $uri;

if ($uri !== '/' && file_exists($path) && !is_dir($path)) {
    // Let the built-in server handle existing files
    return false;
}

require __DIR__ . '/index.php';
