<?php

define('APP_MODE', (getenv('APP_MODE') ?: 'development'));


// In the development mode the environment variables won't be provided,
// so they need to be set:
if (APP_MODE === 'development') {

	// Specify the path to your .env file
	$dot_env_file = dirname( __DIR__) . '/' . 'env/.env.development';

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
}

// Database configuration for PHP service (MySQL)
// Use environment variables for flexibility
define('DB_HOST', getenv('DB_HOST'));
define('DB_USER', getenv('DB_USER'));
define('DB_PASS', getenv('DB_PASS'));
define('DB_NAME', getenv('DB_NAME'));






// --- For Debugging ---

$debugging_information = [
		'path' => isset($_SERVER['PATH_INFO']) ? explode('/', trim($_SERVER['PATH_INFO'], '/')) : [],
		'dot_env_file' => '*** ' . (isset($dot_env_file) ? $dot_env_file : 'is not set') . ' ***',
		'CONSTANTS' => [
				'(env) APP_MODE'   => '*** ' . getenv('APP_MODE') . ' ***',
				'(env) DB_HOST'    => '*** ' . getenv('DB_HOST')  . ' ***',
				'(env) DB_NAME'    => getenv('DB_NAME'),
				'(env) DB_USER'    => getenv('DB_USER'),
				'(env) DB_PASS'    => '*** ' . getenv('DB_PASS')  . ' ***',
				'(env) MYSQL_PORT' => getenv('MYSQL_PORT'),
		]
];
// --- End of For Debugging ---


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
