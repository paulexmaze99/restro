<?php include('db.php'); ?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Manage Orders - Restro Admin</title>

  <!-- Bootstrap -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container-fluid">
    <a class="navbar-brand" href="home.php">Restro Admin</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav ms-auto">
        <li class="nav-item"><a class="nav-link" href="home.php">Home</a></li>
        <li class="nav-item"><a class="nav-link" href="raph.admin.php">Admin</a></li>
        <li class="nav-item"><a class="nav-link" href="raph.category.php">Category</a></li>
        <li class="nav-item"><a class="nav-link" href="raph.food.php">Food</a></li>
        <li class="nav-item"><a class="nav-link active" href="raph.order.php">Order</a></li>
        <li class="nav-item"><a class="nav-link text-danger" href="logout.php">Logout</a></li>
      </ul>
    </div>
  </div>
</nav>

<!-- Orders Table -->
<div class="container mt-5">
  <h3 class="text-primary mb-3">Manage Orders</h3>

  <div class="card shadow">
    <div class="card-body">
      <table class="table table-bordered table-striped align-middle">
        <thead class="table-dark">
          <tr>
            <th>#</th>
            <th>Food</th>
            <th>Price</th>
            <th>Qty</th>
            <th>Total</th>
            <th>Order Date</th>
            <th>Status</th>
            <th>Customer</th>
            <th>Contact</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          <?php
            $sql = "SELECT * FROM tbl_order ORDER BY id DESC";
            $res = mysqli_query($conn, $sql);
            $sn = 1;

            if (mysqli_num_rows($res) > 0) {
              while ($row = mysqli_fetch_assoc($res)) {
                $statusClass = match($row['status']) {
                  'Delivered' => 'success',
                  'Cancelled' => 'danger',
                  'On Delivery' => 'warning',
                  default => 'secondary'
                };
                ?>
                <tr>
                  <td><?= $sn++ ?></td>
                  <td><?= htmlspecialchars($row['food']) ?></td>
                  <td>$<?= number_format($row['price'], 2) ?></td>
                  <td><?= $row['qty'] ?></td>
                  <td>$<?= number_format($row['total'], 2) ?></td>
                  <td><?= $row['order_date'] ?></td>
                  <td><span class="badge bg-<?= $statusClass ?>"><?= $row['status'] ?></span></td>
                  <td><?= htmlspecialchars($row['customer_name']) ?></td>
                  <td><?= htmlspecialchars($row['customer_contact']) ?></td>
                  <td>
                    <a href="update-order.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-warning">Update</a>
                  </td>
                </tr>
                <?php
              }
            } else {
              echo "<tr><td colspan='10' class='text-center text-muted'>No orders available.</td></tr>";
            }
          ?>
        </tbody>
      </table>
    </div>
  </div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
