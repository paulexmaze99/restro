<?php
session_start();
include('db.php');

if (isset($_GET['id'])) {
    $id = (int)$_GET['id'];

    $sql = "DELETE FROM tbl_order WHERE id=$id";
    if (mysqli_query($conn, $sql)) {
        $_SESSION['delete'] = "<div class='alert alert-success'>Order deleted successfully.</div>";
    } else {
        $_SESSION['delete'] = "<div class='alert alert-danger'>Failed to delete order.</div>";
    }

    header('Location: raph.order.php');
    exit();
} else {
    $_SESSION['invalid'] = "<div class='alert alert-warning'>Invalid request.</div>";
    header('Location: raph.order.php');
    exit();
}
?>
