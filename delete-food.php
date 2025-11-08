<?php
session_start();
include('db.php');

if (isset($_GET['id'])) {
    $id = (int)$_GET['id'];
    $image_name = $_GET['image_name'] ?? ''; // use empty string if not passed

    // Remove image if it exists
    if ($image_name != "" && file_exists("./food/$image_name")) {
        unlink("./food/$image_name");
    }

    // Delete from database
    $sql = "DELETE FROM tbl_food WHERE id=$id";
    if (mysqli_query($conn, $sql)) {
        $_SESSION['delete'] = "<div class='alert alert-success'>Food item deleted successfully.</div>";
    } else {
        $_SESSION['delete'] = "<div class='alert alert-danger'>Failed to delete food item.</div>";
    }

    header('Location: raph.food.php');
    exit();
} else {
    $_SESSION['invalid'] = "<div class='alert alert-warning'>Invalid request.</div>";
    header('Location: raph.food.php');
    exit();
}
?>
