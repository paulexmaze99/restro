<?php 
include('db.php'); 

// Get Admin ID
if (isset($_GET['id'])) {
    $id = $_GET['id'];
} else {
    header('location: raph.admin.php');
    exit;
}

// Handle form submission
if (isset($_POST['submit'])) {
    $id = $_POST['id'];
    $current_password = md5($_POST['current_password']);
    $new_password = md5($_POST['new_password']);
    $confirm_password = md5($_POST['confirm_password']);

    $sql = "SELECT * FROM tbl_admin WHERE id=$id AND password='$current_password'";
    $res = mysqli_query($conn, $sql);

    if ($res && mysqli_num_rows($res) == 1) {
        if ($new_password == $confirm_password) {
            $sql2 = "UPDATE tbl_admin SET password='$new_password' WHERE id=$id";
            $res2 = mysqli_query($conn, $sql2);

            $_SESSION['change-pwd'] = $res2 
                ? "<div class='alert alert-success'>Password Changed Successfully.</div>"
                : "<div class='alert alert-danger'>Failed to Change Password.</div>";
        } else {
            $_SESSION['password-not-match'] = "<div class='alert alert-warning'>Passwords Do Not Match.</div>";
        }
    } else {
        $_SESSION['user-not-found'] = "<div class='alert alert-danger'>Current Password is Incorrect.</div>";
    }

    header('location: raph.admin.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Change Password | Restro Admin</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
</head>
<body class="bg-light">

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow-sm">
  <div class="container">
    <a class="navbar-brand fw-bold" href="home.php"><i class="bi bi-egg-fried me-2"></i>Restro Admin</a>
  </div>
</nav>

<!-- Main -->
<div class="container my-5">
  <div class="card shadow-sm border-0">
    <div class="card-body">
      <h3 class="fw-bold mb-4 text-primary"><i class="bi bi-lock-fill me-2"></i>Change Password</h3>

      <form method="POST">
        <input type="hidden" name="id" value="<?php echo $id; ?>">

        <div class="mb-3">
          <label class="form-label">Current Password</label>
          <input type="password" name="current_password" class="form-control" placeholder="Enter current password" required>
        </div>

        <div class="mb-3">
          <label class="form-label">New Password</label>
          <input type="password" name="new_password" class="form-control" placeholder="Enter new password" required>
        </div>

        <div class="mb-3">
          <label class="form-label">Confirm Password</label>
          <input type="password" name="confirm_password" class="form-control" placeholder="Re-enter new password" required>
        </div>

        <button type="submit" name="submit" class="btn btn-primary">
          <i class="bi bi-check-circle me-1"></i> Update Password
        </button>
        <a href="raph.admin.php" class="btn btn-secondary ms-2">
          <i class="bi bi-arrow-left me-1"></i> Cancel
        </a>
      </form>
    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
