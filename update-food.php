<?php
include('db.php'); // Ensure database connection is included
?>

<?php 
if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $sql2 = "SELECT * FROM tbl_food WHERE id = $id";
    $res2 = mysqli_query($conn, $sql2);

    if ($res2 && mysqli_num_rows($res2) == 1) {
        $row2 = mysqli_fetch_assoc($res2);
        $title = $row2['title'];
        $description = $row2['description'];
        $price = $row2['price'];
        $current_image = $row2['image_name'];
        $current_category = $row2['category_id'];
        $featured = $row2['featured'];
        $active = $row2['active'];
    } else {
        $_SESSION['no-food-found'] = "<div class='alert alert-danger'>Food not found.</div>";
        header('location:' . SITEURL . 'raph.food.php');
        exit();
    }
} else {
    $_SESSION['unauthorized'] = "<div class='alert alert-warning'>Unauthorized access.</div>";
    header('location:' . SITEURL . 'raph.food.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Update Food</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="../css/admin.css">
</head>
<body>
<div class="container mt-5">
    <h2 class="mb-4">Update Food</h2>

    <?php 
    if(isset($_SESSION['upload'])) { echo $_SESSION['upload']; unset($_SESSION['upload']); }
    if(isset($_SESSION['failed-remove'])) { echo $_SESSION['failed-remove']; unset($_SESSION['failed-remove']); }
    if(isset($_SESSION['update'])) { echo $_SESSION['update']; unset($_SESSION['update']); }
    ?>

    <form action="" method="POST" enctype="multipart/form-data">
        <div class="form-group">
            <label>Title</label>
            <input type="text" name="title" value="<?php echo htmlspecialchars($title); ?>" class="form-control" required>
        </div>

        <div class="form-group">
            <label>Description</label>
            <textarea name="description" class="form-control" rows="4"><?php echo htmlspecialchars($description); ?></textarea>
        </div>

        <div class="form-group">
            <label>Price</label>
            <input type="number" name="price" value="<?php echo htmlspecialchars($price); ?>" class="form-control" step="0.01" required>
        </div>

        <div class="form-group">
            <label>Current Image</label><br>
            <?php 
            if ($current_image != "" && file_exists("./food/$current_image")) {
                echo "<img src='./food/$current_image' class='img-thumbnail mb-2' width='150'>";
            } else {
                echo "<div class='alert alert-warning'>Image Not Available.</div>";
            }
            ?>
        </div>

        <div class="form-group">
            <label>New Image</label>
            <input type="file" name="image" class="form-control-file">
        </div>

        <div class="form-group">
            <label>Category</label>
            <select name="category" class="form-control">
                <?php 
                $sql = "SELECT * FROM tbl_category WHERE active = 'Yes'";
                $res = mysqli_query($conn, $sql);

                if ($res && mysqli_num_rows($res) > 0) {
                    while ($row = mysqli_fetch_assoc($res)) {
                        $category_title = $row['title'];
                        $category_id = $row['id'];
                        $selected = ($current_category == $category_id) ? "selected" : "";
                        echo "<option value='$category_id' $selected>" . htmlspecialchars($category_title) . "</option>";
                    }
                } else {
                    echo "<option value='0'>No Category Available</option>";
                }
                ?>
            </select>
        </div>

        <div class="form-group">
            <label>Featured</label><br>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="featured" value="Yes" <?php if($featured=="Yes") echo "checked"; ?>>
                <label class="form-check-label">Yes</label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="featured" value="No" <?php if($featured=="No") echo "checked"; ?>>
                <label class="form-check-label">No</label>
            </div>
        </div>

        <div class="form-group">
            <label>Active</label><br>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="active" value="Yes" <?php if($active=="Yes") echo "checked"; ?>>
                <label class="form-check-label">Yes</label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="active" value="No" <?php if($active=="No") echo "checked"; ?>>
                <label class="form-check-label">No</label>
            </div>
        </div>

        <input type="hidden" name="id" value="<?php echo $id; ?>">
        <input type="hidden" name="current_image" value="<?php echo htmlspecialchars($current_image); ?>">

        <button type="submit" name="submit" class="btn btn-primary">Update Food</button>
        <a href="raph.food.php" class="btn btn-secondary">Cancel</a>
    </form>
</div>

<?php 
// Handle update logic
if (isset($_POST['submit'])) {
    $id = intval($_POST['id']);
    $title = mysqli_real_escape_string($conn, trim($_POST['title']));
    $description = mysqli_real_escape_string($conn, trim($_POST['description']));
    $price = floatval($_POST['price']);
    $current_image = $_POST['current_image'];
    $category = intval($_POST['category']);
    $featured = $_POST['featured'];
    $active = $_POST['active'];

    if (isset($_FILES['image']['name']) && $_FILES['image']['name'] != "") {
        $image_name = $_FILES['image']['name'];
        $ext = pathinfo($image_name, PATHINFO_EXTENSION);
        $image_name = "food-Name_" . rand(1000,9999) . '.' . $ext;
        $source_path = $_FILES['image']['tmp_name'];
        $destination_path = "./food/" . $image_name;

        if (!move_uploaded_file($source_path, $destination_path)) {
            $_SESSION['upload'] = "<div class='alert alert-danger'>Failed to upload image.</div>";
            header('location:' . SITEURL . 'raph.food.php');
            exit();
        }

        if ($current_image != "" && file_exists("./food/".$current_image)) {
            unlink("./food/".$current_image);
        }
    } else {
        $image_name = $current_image;
    }

    $sql3 = "UPDATE tbl_food SET
        title = '$title',
        description = '$description',
        price = $price,
        image_name = '$image_name',
        category_id = $category,
        featured = '$featured',
        active = '$active'
        WHERE id = $id";

    $res3 = mysqli_query($conn, $sql3);

    if ($res3 == true) {
        $_SESSION['update'] = "<div class='alert alert-success'>Food Updated Successfully.</div>";
    } else {
        $_SESSION['update'] = "<div class='alert alert-danger'>Failed to Update Food.</div>";
    }

    header('location:' . SITEURL . 'raph.food.php');
    exit();
}
?>

<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js"></script>
</body>
</html>
