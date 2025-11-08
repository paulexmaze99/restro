<?php
include('db.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Update Category - Admin Panel</title>

  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css"
        integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm"
        crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="../css/admin.css">
</head>
<body class="bg-light">

<div class="container mt-5 mb-5">
  <div class="card shadow-lg border-0">
    <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
      <h4 class="mb-0"><i class="fa fa-pencil-square-o mr-2"></i> Update Category</h4>
      <a href="raph.category.php" class="btn btn-light btn-sm">← Back</a>
    </div>

    <div class="card-body">

      <?php
      // check whether id is set or not
      if (isset($_GET['id'])) {
          $id = $_GET['id'];

          // get category details
          $sql = "SELECT * FROM tbl_category WHERE id=$id";
          $res = mysqli_query($conn, $sql);

          if (mysqli_num_rows($res) == 1) {
              $row = mysqli_fetch_assoc($res);
              $title = $row['title'];
              $current_image = $row['image_name'];
              $featured = $row['featured'];
              $active = $row['active'];
          } else {
              $_SESSION['no-category-found'] = "<div class='alert alert-danger'>Category not found.</div>";
              header('location:' . SITEURL . 'raph.category.php');
              exit();
          }
      } else {
          header('location:' . SITEURL . 'raph.category.php');
          exit();
      }
      ?>

      <form action="" method="POST" enctype="multipart/form-data">
        <div class="form-group">
          <label>Category Title</label>
          <input type="text" name="title" class="form-control" value="<?php echo $title; ?>" required>
        </div>

        <div class="form-group">
          <label>Current Image</label><br>
          <?php if ($current_image != ""): ?>
            <img src="../category/<?php echo $current_image; ?>" class="img-thumbnail mb-2" width="150">
          <?php else: ?>
            <div class="alert alert-warning">No image added.</div>
          <?php endif; ?>
        </div>

        <div class="form-group">
          <label>Upload New Image</label>
          <input type="file" name="image" class="form-control-file" accept="image/*">
        </div>

        <div class="form-group">
          <label>Featured</label><br>
          <div class="form-check form-check-inline">
            <input type="radio" name="featured" value="Yes" class="form-check-input" <?php if ($featured == "Yes") echo "checked"; ?>>
            <label class="form-check-label">Yes</label>
          </div>
          <div class="form-check form-check-inline">
            <input type="radio" name="featured" value="No" class="form-check-input" <?php if ($featured == "No") echo "checked"; ?>>
            <label class="form-check-label">No</label>
          </div>
        </div>

        <div class="form-group">
          <label>Active</label><br>
          <div class="form-check form-check-inline">
            <input type="radio" name="active" value="Yes" class="form-check-input" <?php if ($active == "Yes") echo "checked"; ?>>
            <label class="form-check-label">Yes</label>
          </div>
          <div class="form-check form-check-inline">
            <input type="radio" name="active" value="No" class="form-check-input" <?php if ($active == "No") echo "checked"; ?>>
            <label class="form-check-label">No</label>
          </div>
        </div>

        <input type="hidden" name="current_image" value="<?php echo $current_image; ?>">
        <input type="hidden" name="id" value="<?php echo $id; ?>">

        <button type="submit" name="submit" class="btn btn-success">
          <i class="fa fa-save mr-1"></i> Update Category
        </button>
      </form>

      <?php
      if (isset($_POST['submit'])) {
          $id = $_POST['id'];
          $title = $_POST['title'];
          $current_image = $_POST['current_image'];
          $featured = $_POST['featured'];
          $active = $_POST['active'];

          // Handle new image upload
          if (isset($_FILES['image']['name']) && $_FILES['image']['name'] != "") {
              $image_name = $_FILES['image']['name'];
              $ext = pathinfo($image_name, PATHINFO_EXTENSION);
              $image_name = "food_category_" . rand(000, 999) . '.' . $ext;
              $source_path = $_FILES['image']['tmp_name'];
              $destination_path = "./category/" . $image_name;

              if (move_uploaded_file($source_path, $destination_path)) {
                  // remove old image if exists
                  if ($current_image != "") {
                      $remove_path = "./category/" . $current_image;
                      @unlink($remove_path);
                  }
              } else {
                  $_SESSION['upload'] = "<div class='alert alert-danger'>Failed to upload image.</div>";
                  header('Location:' . SITEURL . 'raph.category.php');
                  exit();
              }
          } else {
              $image_name = $current_image;
          }

          // Update database
          $sql2 = "UPDATE tbl_category SET 
                      title='$title',
                      image_name='$image_name',
                      featured='$featured',
                      active='$active'
                   WHERE id=$id";

          $res2 = mysqli_query($conn, $sql2);

          if ($res2) {
              $_SESSION['update'] = "<div class='alert alert-success'>Category updated successfully.</div>";
          } else {
              $_SESSION['update'] = "<div class='alert alert-danger'>Failed to update category.</div>";
          }

          header('Location:' . SITEURL . 'raph.category.php');
          exit();
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
