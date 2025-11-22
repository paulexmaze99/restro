<?php
session_start();
include 'db.php';

if(isset($_SESSION['user_id'])){
    $stmt = $conn->prepare("UPDATE user_form SET is_logged_in = 0 WHERE id=?");
    $stmt->bind_param("i", $_SESSION['user_id']);
    $stmt->execute();
}

session_destroy();
header("Location: login.php");
exit;
?>
