<?php
include('db.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <!-- Make website responsive -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Restro Website - Home</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS (optional) -->
    <link rel="stylesheet" href="../css/admin.css">
</head>

<body class="bg-light">

    <!-- Navigation Menu -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand fw-bold" href="home.php">Restro Admin</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarMenu"
                aria-controls="navbarMenu" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarMenu">
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                    <li class="nav-item"><a class="nav-link active" href="home.php">Home</a></li>
                    <li class="nav-item"><a class="nav-link" href="raph.admin.php">Admin</a></li>
                    <li class="nav-item"><a class="nav-link" href="raph.category.php">Category</a></li>
                    <li class="nav-item"><a class="nav-link" href="raph.food.php">Food</a></li>
                    <li class="nav-item"><a class="nav-link" href="raph.order.php">Order</a></li>
                    <li class="nav-item"><a class="nav-link text-danger" href="logout.php">Logout</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Page Content -->
    <section class="container py-5">
        <div class="text-center mb-5">
            <h1 class="fw-bold">Welcome to the Restaurant Admin Dashboard</h1>
            <p class="text-muted">Manage your restaurant's categories, food items, orders, and admins all in one place.</p>
        </div>

        <!-- Example Dashboard Cards -->
        <div class="row g-4">
            <div class="col-md-3">
                <div class="card shadow-sm border-0">
                    <div class="card-body text-center">
                        <h5 class="card-title">Admins</h5>
                        <p class="card-text text-muted">Manage admin accounts.</p>
                        <a href="raph.admin.php" class="btn btn-primary btn-sm">View</a>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card shadow-sm border-0">
                    <div class="card-body text-center">
                        <h5 class="card-title">Categories</h5>
                        <p class="card-text text-muted">Add or update food categories.</p>
                        <a href="raph.category.php" class="btn btn-primary btn-sm">View</a>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card shadow-sm border-0">
                    <div class="card-body text-center">
                        <h5 class="card-title">Food Menu</h5>
                        <p class="card-text text-muted">Add or edit menu items.</p>
                        <a href="raph.food.php" class="btn btn-primary btn-sm">View</a>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card shadow-sm border-0">
                    <div class="card-body text-center">
                        <h5 class="card-title">Orders</h5>
                        <p class="card-text text-muted">Track customer orders.</p>
                        <a href="raph.order.php" class="btn btn-primary btn-sm">View</a>
                    </div>
                </div>
            </div>
        </div>
    </section>


    <!-- JavaScript Files -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="./assets/js/ajaxWork.js"></script>
    <script src="./assets/js/script.js"></script>
</body>
</html>
