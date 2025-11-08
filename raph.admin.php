<?php 
include('db.php'); 
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Manage Admin | Restro</title>

  <!-- Bootstrap 5 -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
</head>
<body class="bg-light">

  <!-- Navbar -->
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow-sm">
    <div class="container">
      <a class="navbar-brand fw-bold" href="home.php">
        <i class="bi bi-egg-fried me-2"></i>Restro Admin
      </a>

      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarMenu" aria-controls="navbarMenu" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse" id="navbarMenu">
        <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
          <li class="nav-item"><a class="nav-link" href="home.php">Home</a></li>
          <li class="nav-item"><a class="nav-link active" href="raph.admin.php">Admin</a></li>
          <li class="nav-item"><a class="nav-link" href="raph.category.php">Category</a></li>
          <li class="nav-item"><a class="nav-link" href="raph.food.php">Food</a></li>
          <li class="nav-item"><a class="nav-link" href="raph.order.php">Order</a></li>
          <li class="nav-item"><a class="nav-link text-danger" href="logout.php">Logout</a></li>
        </ul>
      </div>
    </div>
  </nav>

  <!-- Main Content -->
  <div class="container my-5">
    <div class="card shadow-sm border-0">
      <div class="card-body">
        <div class="d-flex justify-content-between align-items-center mb-4">
          <h3 class="fw-bold mb-0"><i class="bi bi-person-fill-gear me-2 text-primary"></i>Manage Admin</h3>
          <a href="add.admin.php" class="btn btn-primary">
            <i class="bi bi-person-plus-fill me-1"></i> Add Admin
          </a>
        </div>

        <!-- Session Alerts -->
        <?php 
        $alerts = ['add', 'delete', 'update', 'user-not-found', 'password-not-match', 'change-pwd'];
        foreach ($alerts as $alert) {
          if (isset($_SESSION[$alert])) {
            echo '<div class="alert alert-info alert-dismissible fade show" role="alert">'
                 . $_SESSION[$alert] .
                 '<button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>';
            unset($_SESSION[$alert]);
          }
        }
        ?>

        <!-- Admin Table -->
        <div class="table-responsive">
          <table class="table table-striped table-hover align-middle">
            <thead class="table-dark">
              <tr>
                <th>#</th>
                <th>Full Name</th>
                <th>Username</th>
                <th>Actions</th>
              </tr>
            </thead>
            <tbody>
              <?php 
              $sql = "SELECT * FROM tbl_admin";
              $res = mysqli_query($conn, $sql);
              if ($res && mysqli_num_rows($res) > 0):
                $sn = 1;
                while ($row = mysqli_fetch_assoc($res)):
              ?>
              <tr>
                <td><?php echo $sn++; ?></td>
                <td><?php echo htmlspecialchars($row['full_name']); ?></td>
                <td><?php echo htmlspecialchars($row['username']); ?></td>
                <td>
                  <a href="update.password.php?id=<?php echo $row['id']; ?>" class="btn btn-warning btn-sm">
                    <i class="bi bi-lock-fill"></i> Password
                  </a>
                  <a href="update.admin.php?id=<?php echo $row['id']; ?>" class="btn btn-secondary btn-sm">
                    <i class="bi bi-pencil-square"></i> Edit
                  </a>
                  <a href="delete.admin.php?id=<?php echo $row['id']; ?>" onclick="return confirm('Delete this admin?')" class="btn btn-danger btn-sm">
                    <i class="bi bi-trash3-fill"></i> Delete
                  </a>
                </td>
              </tr>
              <?php 
                endwhile;
              else:
              ?>
              <tr>
                <td colspan="4" class="text-center text-muted py-4">
                  <i class="bi bi-info-circle"></i> No admin accounts found.
                </td>
              </tr>
              <?php endif; ?>
            </tbody>
          </table>
        </div>

      </div>
    </div>
  </div>

  <!-- Footer -->
  <footer class="bg-dark text-light text-center py-3 mt-auto">
    <p class="mb-0">&copy; <?php echo date("Y"); ?> Restro Admin. All rights reserved.</p>
  </footer>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
