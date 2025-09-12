<?php
// Minimal DB connectivity test that reads wp-config.php for DB_* constants
// WITHOUT loading WordPress. Remove after troubleshooting.
error_reporting(E_ALL);
ini_set('display_errors', 1);
header('Content-Type: text/plain');

$configPath = __DIR__ . DIRECTORY_SEPARATOR . 'wp-config.php';
if (!is_readable($configPath)) {
    echo "Cannot read wp-config.php at $configPath\n";
    exit(1);
}

$config = file_get_contents($configPath);
if ($config === false) {
    echo "Failed to load wp-config.php contents\n";
    exit(1);
}

function cfg($name, $config) {
    $pattern = "/define\\(\\s*'" . preg_quote($name, '/') . "'\\s*,\\s*'([^']*)'\\s*\\)\\s*;/";
    if (preg_match($pattern, $config, $m)) return $m[1];
    return null;
}

$DB_HOST = cfg('DB_HOST', $config) ?: 'localhost';
$DB_USER = cfg('DB_USER', $config) ?: '';
$DB_PASSWORD = cfg('DB_PASSWORD', $config) ?: '';
$DB_NAME = cfg('DB_NAME', $config) ?: '';

echo "Parsed from wp-config.php:\n";
echo "  DB_HOST=$DB_HOST\n";
echo "  DB_USER=$DB_USER\n";
echo "  DB_NAME=$DB_NAME\n";

$hasMysqli = function_exists('mysqli_connect');
echo "mysqli_connect available: " . ($hasMysqli ? 'yes' : 'no') . "\n";
if (!$hasMysqli) {
    echo "Enable the mysqli extension in your web server's php.ini and restart the server.\n";
    exit(2);
}

$mysqli = @mysqli_connect($DB_HOST, $DB_USER, $DB_PASSWORD, $DB_NAME);
if (!$mysqli) {
    echo "mysqli_connect error: " . mysqli_connect_errno() . " - " . mysqli_connect_error() . "\n";
    exit(3);
}

echo "Connected OK. Server info: " . mysqli_get_host_info($mysqli) . "\n";
$mysqli->close();
