<?php include('db.php'); ?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Add Food - Restro Admin</title>

  <!-- Bootstrap CSS -->
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
        <li class="nav-item"><a class="nav-link" href="raph.order.php">Order</a></li>
        <li class="nav-item"><a class="nav-link text-danger" href="logout.php">Logout</a></li>
      </ul>
    </div>
  </div>
</nav>

<!-- Add Food Form -->
<div class="container mt-5">
  <div class="card shadow-lg">
    <div class="card-header bg-success text-white">
      <h4 class="mb-0">Add New Food Item</h4>
    </div>
    <div class="card-body">
      <form action="process_add_food.php" method="POST" enctype="multipart/form-data">
        <div class="mb-3">
          <label for="title" class="form-label">Food Title</label>
          <input type="text" name="title" id="title" class="form-control" placeholder="Enter Food Title" required>
        </div>

        <div class="mb-3">
          <label class="form-label">Description</label>
          <textarea name="description" rows="3" class="form-control" placeholder="Enter food description" required></textarea>
        </div>

        <div class="mb-3">
          <label class="form-label">Price ($)</label>
          <input type="number" name="price" step="0.01" class="form-control" placeholder="Enter price" required>
        </div>

        <div class="mb-3">
          <label class="form-label">Select Image</label>
          <input type="file" name="image" class="form-control">
        </div>

        <div class="mb-3">
          <label class="form-label">Category</label>
          <select name="category_id" class="form-select" required>
            <option value="">Select Category</option>
            <?php
              $res = mysqli_query($con, "SELECT id, title FROM tbl_category WHERE active='Yes'");
              while($row = mysqli_fetch_assoc($res)) {
                echo "<option value='{$row['id']}'>{$row['title']}</option>";
              }
            ?>
          </select>
        </div>

        <div class="mb-3">
          <label class="form-label">Featured</label><br>
          <div class="form-check form-check-inline">
            <input type="radio" name="featured" value="Yes" class="form-check-input" checked>
            <label class="form-check-label">Yes</label>
          </div>
          <div class="form-check form-check-inline">
            <input type="radio" name="featured" value="No" class="form-check-input">
            <label class="form-check-label">No</label>
          </div>
        </div>

        <div class="mb-3">
          <label class="form-label">Active</label><br>
          <div class="form-check form-check-inline">
            <input type="radio" name="active" value="Yes" class="form-check-input" checked>
            <label class="form-check-label">Yes</label>
          </div>
          <div class="form-check form-check-inline">
            <input type="radio" name="active" value="No" class="form-check-input">
            <label class="form-check-label">No</label>
          </div>
        </div>

        <button type="submit" name="submit" class="btn btn-primary w-100">Add Food</button>
      </form>
    </div>
  </div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
