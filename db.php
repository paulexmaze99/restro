<?php
session_start([
    'cookie_httponly' => true,
    'cookie_secure' => true,
    'cookie_samesite' => 'Strict',
]);
define('SITEURL', 'http://localhost/restro/');
$servername = "localhost";  // or "127.0.0.1"
$username = "root";
$password = "";             // default in XAMPP
$database = "Restaurant";       // make sure this matches your database name

// Create connection
$conn = mysqli_connect($servername, $username, $password, $database);

// Check connection
if (!$conn) {
    die("Database connection failed: " . mysqli_connect_error());
}
?>
