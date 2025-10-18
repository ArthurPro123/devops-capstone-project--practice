<?php

// Database configuration for PHP service (MySQL)
// Use environment variables for flexibility
define('DB_HOST', getenv('DB_HOST') ?: 'localhost');
define('DB_USER', getenv('DB_USER') ?: 'root');
define('DB_PASS', getenv('DB_PASS') ?: '');
define('DB_NAME', getenv('DB_NAME') ?: 'account_microservice_db');


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
