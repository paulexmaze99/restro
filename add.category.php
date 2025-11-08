<?php
include('db.php')
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Add Category - Restro Admin</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="../css/admin.css">
</head>
<body class="bg-light">

<div class="container mt-5">
  <div class="card shadow-lg border-0">
    <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
      <h4 class="mb-0">Add New Category</h4>
      <a href="raph.category.php" class="btn btn-light btn-sm">Back to Categories</a>
    </div>

    <div class="card-body">
      <?php 
      if (isset($_SESSION['add'])) {
          echo "<div class='alert alert-info'>{$_SESSION['add']}</div>";
          unset($_SESSION['add']);
      }
      if (isset($_SESSION['upload'])) {
          echo "<div class='alert alert-warning'>{$_SESSION['upload']}</div>";
          unset($_SESSION['upload']);
      }
      ?>

      <form action="" method="POST" enctype="multipart/form-data">
        <div class="form-group">
          <label for="title">Category Title</label>
          <input type="text" name="title" class="form-control" id="title" placeholder="Enter category name" required>
        </div>

        <div class="form-group">
          <label for="image">Select Image</label>
          <input type="file" name="image" class="form-control-file" id="image" accept="image/*">
        </div>

        <div class="form-group">
          <label>Featured</label><br>
          <div class="form-check form-check-inline">
            <input type="radio" name="featured" value="Yes" class="form-check-input" id="featuredYes">
            <label for="featuredYes" class="form-check-label">Yes</label>
          </div>
          <div class="form-check form-check-inline">
            <input type="radio" name="featured" value="No" class="form-check-input" id="featuredNo" checked>
            <label for="featuredNo" class="form-check-label">No</label>
          </div>
        </div>

        <div class="form-group">
          <label>Active</label><br>
          <div class="form-check form-check-inline">
            <input type="radio" name="active" value="Yes" class="form-check-input" id="activeYes">
            <label for="activeYes" class="form-check-label">Yes</label>
          </div>
          <div class="form-check form-check-inline">
            <input type="radio" name="active" value="No" class="form-check-input" id="activeNo" checked>
            <label for="activeNo" class="form-check-label">No</label>
          </div>
        </div>

        <button type="submit" name="submit" class="btn btn-success">Add Category</button>
      </form>

      <hr>

      <?php 
      if (isset($_POST['submit'])) {
          // Sanitize inputs
          $title = htmlspecialchars(trim($_POST['title']));
          $featured = isset($_POST['featured']) ? $_POST['featured'] : "No";
          $active = isset($_POST['active']) ? $_POST['active'] : "No";

          $image_name = "";
          if (isset($_FILES['image']['name']) && $_FILES['image']['name'] != "") {
              $image_name = $_FILES['image']['name'];
              $ext = pathinfo($image_name, PATHINFO_EXTENSION);
              $allowed_extensions = ['jpg', 'jpeg', 'png', 'gif'];

              if (!in_array(strtolower($ext), $allowed_extensions)) {
                  echo "<div class='alert alert-danger mt-3'>Invalid file type. Only JPG, JPEG, PNG, and GIF are allowed.</div>";
                  $image_name = "";
              } else {
                  $image_name = "food_category_" . rand(000, 999) . '.' . $ext;
                  $source_path = $_FILES['image']['tmp_name'];
                  $destination_path = "../category/" . $image_name;

                  if (!move_uploaded_file($source_path, $destination_path)) {
                      echo "<div class='alert alert-danger mt-3'>Failed to upload image.</div>";
                      $image_name = "";
                  }
              }
          }

          // Insert with prepared statement
          $stmt = $conn->prepare("INSERT INTO tbl_category (title, image_name, featured, active) VALUES (?, ?, ?, ?)");
          $stmt->bind_param("ssss", $title, $image_name, $featured, $active);

          if ($stmt->execute()) {
              echo "<div class='alert alert-success mt-3'>Category added successfully.</div>";
          } else {
              echo "<div class='alert alert-danger mt-3'>Failed to add category.</div>";
          }

          $stmt->close();
      }
      ?>
    </div>
  </div>
</div>

<script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js"></script>
</body>
</html>
