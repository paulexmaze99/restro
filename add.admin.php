<?php
include('db.php');

// Handle form submission
if (isset($_POST['submit'])) {
    $full_name = mysqli_real_escape_string($conn, $_POST['full_name']);
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = md5($_POST['password']);

    // Check if username exists
    $check = mysqli_query($conn, "SELECT * FROM tbl_admin WHERE username='$username'");
    if (mysqli_num_rows($check) > 0) {
        $_SESSION['add'] = "<div class='alert alert-warning'>Username already exists.</div>";
    } else {
        $sql = "INSERT INTO tbl_admin (full_name, username, password) VALUES ('$full_name', '$username', '$password')";
        $res = mysqli_query($conn, $sql);

        $_SESSION['add'] = $res
            ? "<div class='alert alert-success'>Admin added successfully.</div>"
            : "<div class='alert alert-danger'>Failed to add admin.</div>";

        header('location: raph.admin.php');
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Add Admin | Restro Admin</title>
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

<div class="container my-5">
  <div class="card shadow-sm border-0">
    <div class="card-body">
      <h3 class="fw-bold mb-4 text-primary"><i class="bi bi-person-plus-fill me-2"></i>Add Admin</h3>

      <?php 
      if (isset($_SESSION['add'])) {
          echo $_SESSION['add'];
          unset($_SESSION['add']);
      }
      ?>

      <form method="POST">
        <div class="mb-3">
          <label class="form-label">Full Name</label>
          <input type="text" name="full_name" class="form-control" placeholder="Enter full name" required>
        </div>

        <div class="mb-3">
          <label class="form-label">Username</label>
          <input type="text" name="username" class="form-control" placeholder="Enter username" required>
        </div>

        <div class="mb-3">
          <label class="form-label">Password</label>
          <input type="password" name="password" class="form-control" placeholder="Enter password" required>
        </div>

        <button type="submit" name="submit" class="btn btn-primary">
          <i class="bi bi-check-circle me-1"></i> Add Admin
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
