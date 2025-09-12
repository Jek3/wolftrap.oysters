<?php
// Quick runtime checks for mysqli and db constants.
$checks = [
  'php_version' => PHP_VERSION,
  'sapi' => PHP_SAPI,
  'extension_dir' => ini_get('extension_dir'),
  'loaded_php_ini' => php_ini_loaded_file(),
  'additional_ini_files' => php_ini_scanned_files(),
  'mysqli_loaded' => extension_loaded('mysqli'),
  'mysqli_connect_exists' => function_exists('mysqli_connect'),
  'mysql_connect_exists' => function_exists('mysql_connect'),
  'wp_config_present' => file_exists(__DIR__ . DIRECTORY_SEPARATOR . 'wp-config.php'),
];

header('Content-Type: application/json');
echo json_encode($checks, JSON_PRETTY_PRINT);
