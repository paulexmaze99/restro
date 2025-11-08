<?php
include('db.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Food</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

</head>
<body>
   <!-- Navbar -->
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow-sm">
    <div class="container">
      <a class="navbar-brand fw-bold" href="home.php"><i class="fa fa-utensils me-2"></i>Restro Admin</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarMenu">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarMenu">
        <ul class="navbar-nav ms-auto">
          <li class="nav-item"><a class="nav-link" href="home.php">Home</a></li>
          <li class="nav-item"><a class="nav-link active" href="raph.category.php">Category</a></li>
          <li class="nav-item"><a class="nav-link" href="raph.food.php">Food</a></li>
          <li class="nav-item"><a class="nav-link" href="raph.order.php">Orders</a></li>
          <li class="nav-item"><a class="nav-link text-danger" href="logout.php">Logout</a></li>
        </ul>
      </div>
    </div>
  </nav>

<div class="container mt-5">
    <h1 class="mb-4">Manage Food</h1>

    <!-- Session Messages -->
    <?php
    $messages = ['add', 'delete', 'upload', 'unauthorize', 'update', 'no-food-found', 'invalid', 'failed-remove'];
    foreach ($messages as $msg) {
        if (isset($_SESSION[$msg])) {
            echo $_SESSION[$msg];
            unset($_SESSION[$msg]);
        }
    }
    ?>

    <a href="add.food.php" class="btn btn-primary mb-3"><i class="fa fa-plus"></i> Add Food</a>

    <table class="table table-bordered table-hover">
        <thead class="thead-dark">
            <tr>
                <th>S.N.</th>
                <th>Title</th>
                <th>Image</th>
                <th>Price</th>
                <th>Featured</th>
                <th>Active</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
        <?php
        $sql = "SELECT * FROM tbl_food";
        $res = mysqli_query($conn, $sql);
        $sn = 1;

        if (mysqli_num_rows($res) > 0) {
            while ($row = mysqli_fetch_assoc($res)) {
                $id = $row['id'];
                $title = $row['title'];
                $image_name = $row['image_name'];
                $price = $row['price'];
                $featured = $row['featured'];
                $active = $row['active'];
                ?>
                <tr>
                    <td><?php echo $sn++; ?></td>
                    <td><?php echo htmlspecialchars($title); ?></td>
                    <td>
                        <?php
                        if ($image_name != "" && file_exists("./food/$image_name")) {
                            echo "<img src='./food/$image_name' width='100px'>";
                        } else {
                            echo "<div class='text-danger'>Image not added</div>";
                        }
                        ?>
                    </td>
                    <td><?php echo $price; ?></td>
                    <td><?php echo $featured; ?></td>
                    <td><?php echo $active; ?></td>
                    <td>
                        <a href="update-food.php?id=<?php echo $id; ?>" class="btn btn-secondary btn-sm mb-1">
                            <i class="fa fa-pencil"></i> Update
                        </a>
                        <a href="delete-food.php?id=<?php echo $id; ?>&image_name=<?php echo $image_name; ?>" 
                           class="btn btn-danger btn-sm mb-1" onclick="return confirm('Are you sure you want to delete this food?');">
                           <i class="fa fa-trash"></i> Delete
                        </a>
                    </td>
                </tr>
                <?php
            }
        } else {
            echo "<tr><td colspan='7' class='text-center text-danger'>No Food Added.</td></tr>";
        }
        ?>
        </tbody>
    </table>
</div>

<script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js"></script>
</body>
</html>
