<?php

// Specify the path to your .env file
$dot_env_file = __DIR__ . '/../' . 'env/.env.development';

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

if (!LOCAL && (DB_PASS === '') ) {
	die("DB_PASS equals '' when !LOCAL is true");
}


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
