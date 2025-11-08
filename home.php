<?php
include('db.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Restro Admin Dashboard</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="../css/admin.css">
</head>

<body class="bg-light">

   <!-- Navbar / Menu -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow-sm">
  <div class="container">
    <a class="navbar-brand fw-bold" href="home.php">
      <i class="fa fa-cutlery me-2"></i>Restro Admin
    </a>

    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarMenu"
      aria-controls="navbarMenu" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarMenu">
      <ul class="navbar-nav ms-auto mb-2 mb-lg-0">

        <!-- Home -->
        <li class="nav-item">
          <a class="nav-link active" href="home.php"><i class="fa fa-home me-1"></i> Home</a>
        </li>

        <!-- Management Dropdown -->
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="manageDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            <i class="fa fa-cogs me-1"></i> Manage
          </a>
          <ul class="dropdown-menu dropdown-menu-dark" aria-labelledby="manageDropdown">
            <li><a class="dropdown-item" href="raph.admin.php"><i class="fa fa-user-shield me-2"></i> Admin</a></li>
            <li><a class="dropdown-item" href="raph.category.php"><i class="fa fa-tags me-2"></i> Categories</a></li>
            <li><a class="dropdown-item" href="raph.food.php"><i class="fa fa-utensils me-2"></i> Foods</a></li>
            <li><a class="dropdown-item" href="raph.order.php"><i class="fa fa-shopping-cart me-2"></i> Orders</a></li>
          </ul>
        </li>

        <!-- Profile Dropdown -->
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="accountDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            <i class="fa fa-user-circle me-1"></i> Account
          </a>
          <ul class="dropdown-menu dropdown-menu-dark" aria-labelledby="accountDropdown">
            <li><a class="dropdown-item" href="profile.php"><i class="fa fa-id-badge me-2"></i> Profile</a></li>
            <li><a class="dropdown-item text-danger" href="logout.php"><i class="fa fa-sign-out me-2"></i> Logout</a></li>
          </ul>
        </li>

      </ul>
    </div>
  </div>
</nav>


    <!-- Dashboard Section -->
    <section class="container py-5">
        <?php if(isset($_SESSION['login'])): ?>
            <div class="alert alert-success text-center fw-bold">
                <?php 
                    echo $_SESSION['login']; 
                    unset($_SESSION['login']); 
                ?>
            </div>
        <?php endif; ?>

        <div class="text-center mb-5">
            <h1 class="fw-bold">Welcome to the Admin Dashboard</h1>
            <p class="text-muted">Monitor categories, food items, orders, and revenue in one place.</p>
        </div>

        <div class="row g-4">

            <!-- Categories -->
            <div class="col-md-3">
                <div class="card shadow-sm border-0 text-center">
                    <div class="card-body">
                        <i class="fa fa-list fa-3x mb-3 text-primary"></i>
                        <?php
                        $sql = "SELECT * FROM tbl_category";
                        $res = mysqli_query($conn, $sql);
                        $count = $res ? mysqli_num_rows($res) : 0;
                        ?>
                        <h2><?php echo $count; ?></h2>
                        <p class="text-muted">Categories</p>
                    </div>
                </div>
            </div>

            <!-- Food Items -->
            <div class="col-md-3">
                <div class="card shadow-sm border-0 text-center">
                    <div class="card-body">
                        <i class="fa fa-burger fa-3x mb-3 text-success"></i>
                        <?php
                        $sql2 = "SELECT * FROM tbl_food";
                        $res2 = mysqli_query($conn, $sql2);
                        $count2 = $res2 ? mysqli_num_rows($res2) : 0;
                        ?>
                        <h2><?php echo $count2; ?></h2>
                        <p class="text-muted">Food Items</p>
                    </div>
                </div>
            </div>

            <!-- Orders -->
            <div class="col-md-3">
                <div class="card shadow-sm border-0 text-center">
                    <div class="card-body">
                        <i class="fa fa-shopping-cart fa-3x mb-3 text-warning"></i>
                        <?php
                        $sql3 = "SELECT * FROM tbl_order";
                        $res3 = mysqli_query($conn, $sql3);
                        $count3 = $res3 ? mysqli_num_rows($res3) : 0;
                        ?>
                        <h2><?php echo $count3; ?></h2>
                        <p class="text-muted">Total Orders</p>
                    </div>
                </div>
            </div>

            <!-- Revenue -->
            <div class="col-md-3">
                <div class="card shadow-sm border-0 text-center">
                    <div class="card-body">
                        <i class="fa fa-dollar-sign fa-3x mb-3 text-info"></i>
                        <?php
                        $sql4 = "SELECT SUM(total) AS Total FROM tbl_order WHERE status='Delivered'";
                        $res4 = mysqli_query($conn, $sql4);
                        $row4 = mysqli_fetch_assoc($res4);
                        $total_revenue = $row4['Total'] ?? 0;
                        ?>
                        <h2>$<?php echo number_format($total_revenue, 2); ?></h2>
                        <p class="text-muted">Revenue Generated</p>
                    </div>
                </div>
            </div>

        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-dark text-light text-center py-3 mt-5">
        <p class="mb-0">&copy; <?php echo date('Y'); ?> Restro Admin. All Rights Reserved.</p>
    </footer>

    <!-- JS Files -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="./assets/js/script.js"></script>
</body>
</html>
