<?php
include('db.php');

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Delete admin
    $sql = "DELETE FROM tbl_admin WHERE id=$id";
    $res = mysqli_query($conn, $sql);

    $_SESSION['delete'] = $res
        ? "<div class='alert alert-success'>Admin deleted successfully.</div>"
        : "<div class='alert alert-danger'>Failed to delete admin.</div>";

    header('location: raph.admin.php');
    exit;
} else {
    $_SESSION['delete'] = "<div class='alert alert-warning'>No admin selected.</div>";
    header('location: raph.admin.php');
    exit;
}
?>
