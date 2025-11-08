<?php
session_start();
include('db.php');

if (isset($_GET['id']) && isset($_GET['image_name'])) {
    $id = (int)$_GET['id'];
    $image_name = $_GET['image_name'];

    // Remove the physical image if available
    if ($image_name != "") {
        $path = "../category/" . $image_name; // Adjust path if necessary
        if (file_exists($path)) {
            $remove = unlink($path);
            if ($remove == false) {
                $_SESSION['remove'] = "<div class='alert alert-danger'>Failed to remove image.</div>";
                header('Location: raph.category.php');
                exit();
            }
        }
    }

    // Delete from database
    $sql = "DELETE FROM tbl_category WHERE id=$id";
    $res = mysqli_query($conn, $sql);

    if ($res == true) {
        $_SESSION['delete'] = "<div class='alert alert-success'>Category Deleted Successfully.</div>";
    } else {
        $_SESSION['delete'] = "<div class='alert alert-danger'>Failed to delete category.</div>";
    }

    header('Location: raph.category.php');
    exit();
} else {
    $_SESSION['invalid'] = "<div class='alert alert-warning'>Invalid Request: Missing ID or Image Name.</div>";
    header('Location: raph.category.php');
    exit();
}
?>
