<?php

// Specify the path to your .env file
$dot_env_file = dirname( __DIR__) . '/' 
	. 'env/.env.' . (getenv('APP_MODE') ?: 'development');

// Check if the file exists
if (file_exists($dot_env_file)) {
    // Read the file line by line
    $lines = file($dot_env_file, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

    foreach ($lines as $line) {
        // Remove comments and trim whitespace
        $line = trim(explode('#', $line)[0]);

        // If it's a valid line, set the environment variable
        if (!empty($line)) {
            list($key, $value) = explode('=', $line, 2);
            putenv(trim($key) . '=' . trim($value));
        }
    }
}

// Database configuration for PHP service (MySQL)
// Use environment variables for flexibility
define('DB_HOST', getenv('DB_HOST'));
define('DB_USER', getenv('DB_USER'));
define('DB_PASS', getenv('DB_PASS'));
define('DB_NAME', getenv('DB_NAME'));


## echo "DB_USER: " . getenv('DB_USER'); exit;


$host = substr($_SERVER['HTTP_HOST'], 0, 5);
if (in_array($host, array('local', '127.0', '192.1'))) {
	DEFINE('LOCAL', true);
} else {
	DEFINE('LOCAL', false);
}


// --- Debugging ---
header("Content-Type: application/json");

$path1 = isset($_SERVER['PATH_INFO']) ? explode('/', trim($_SERVER['PATH_INFO'], '/')) : [];
$raw = $_GET['request'] ?? '';
$path2 = $raw ? explode('/', trim($raw, '/')) : [];
$allow_empty_root_password_value = defined('MYSQL_ALLOW_EMPTY_ROOT_PASSWORD') ? 'yes' : 'no';

echo json_encode([
		'path1' => $path1,
		'path2' => $path2,
		'APP_MODE' => getenv('APP_MODE'),
		'dot_env_file' => $dot_env_file,
		'CONSTANTS' => [
				'DB_HOST' => DB_HOST,
				'DB_NAME' => DB_NAME,
				'DB_USER' => DB_USER,
				'DB_PASS' => DB_PASS,
				'MYSQL_PORT' => getenv('MYSQL_PORT'),
				'MYSQL_ALLOW_EMPTY_ROOT_PASSWORD' => $allow_empty_root_password_value,
		]
]);
exit;
// --- End of Debugging ---

// Create connection
function getDBConnection() {
    $conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    return $conn;
}
?>
