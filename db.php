<?php
session_start([
    'cookie_httponly' => true,
    'cookie_secure' => isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on',
    'cookie_samesite' => 'Strict',
]);

// Detect local host properly
$host = $_SERVER['HTTP_HOST'] ?? '';

$isLocal = (
    strpos($host, 'localhost') !== false ||
    strpos($host, '127.0.0.1') !== false ||
    $host === '::1'
);

if ($isLocal) {
    // LOCAL (XAMPP)
    define('SITEURL', 'http://localhost/restro/');
    $db_server = "localhost";
    $db_username = "root";
    $db_password = "";
    $db_name = "Restaurant"; // ensure this DB exists in phpMyAdmin
} else {
    // LIVE SERVER (InfinityFree)
    define('SITEURL', 'https://yourliveurl.com/');
    $db_server = "your_live_server";
    $db_username = "your_live_username";
    $db_password = "your_live_password";
    $db_name = "your_live_database";
}

// CONNECT
$conn = mysqli_connect($db_server, $db_username, $db_password, $db_name);

// CHECK CONNECTION
if (!$conn) {
    die("Database connection failed: " . mysqli_connect_error());
}
?>
