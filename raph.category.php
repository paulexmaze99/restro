<?php
include('db.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Manage Category - Restro Admin</title>

  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

  <!-- Custom CSS -->
  <link rel="stylesheet" href="../css/admin.css">
</head>

<body class="bg-light">

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

  <!-- Main Content -->
  <div class="container py-5">

    <div class="d-flex justify-content-between align-items-center mb-4">
      <h2 class="fw-bold mb-0"><i class="fa fa-list"></i> Manage Categories</h2>
      <a href="./add.category.php" class="btn btn-primary">
        <i class="fa fa-plus"></i> Add Category
      </a>
    </div>

    <!-- Session Messages -->
    <?php 
    $session_msgs = [
      'add', 'remove', 'delete', 'no-category-found', 'update', 'upload', 'failed-remove'
    ];
    foreach ($session_msgs as $msg) {
      if (isset($_SESSION[$msg])) {
        echo "<div class='alert alert-info alert-dismissible fade show' role='alert'>
                {$_SESSION[$msg]}
                <button type='button' class='btn-close' data-bs-dismiss='alert'></button>
              </div>";
        unset($_SESSION[$msg]);
      }
    }
    ?>

    <!-- Category Table -->
    <div class="card shadow-sm border-0">
      <div class="card-body">
        <div class="table-responsive">
          <table class="table table-striped align-middle table-bordered">
            <thead class="table-dark">
              <tr class="text-center">
                <th width="5%">S.N</th>
                <th>Title</th>
                <th>Image</th>
                <th>Featured</th>
                <th>Active</th>
                <th width="20%">Actions</th>
              </tr>
            </thead>
            <tbody>
              <?php 
              $sql = "SELECT * FROM tbl_category";
              $res = mysqli_query($conn, $sql);
              $count = mysqli_num_rows($res);
              $sn = 1;

              if ($count > 0) {
                while ($row = mysqli_fetch_assoc($res)) {
                  $id = $row['id'];
                  $title = $row['title'];
                  $image_name = $row['image_name'];
                  $featured = $row['featured'];
                  $active = $row['active'];
              ?>
                  <tr class="text-center">
                    <td><?php echo $sn++; ?></td>
                    <td class="fw-semibold"><?php echo htmlspecialchars($title); ?></td>
                    <td>
                      <?php if ($image_name == ""): ?>
                        <span class="badge bg-danger">No Image</span>
                      <?php else: ?>
                        <img src="./category/<?php echo $image_name; ?>" alt="<?php echo $title; ?>" class="img-thumbnail" style="width: 80px;">
                      <?php endif; ?>
                    </td>
                    <td>
                      <span class="badge <?php echo ($featured == 'Yes') ? 'bg-success' : 'bg-secondary'; ?>">
                        <?php echo $featured; ?>
                      </span>
                    </td>
                    <td>
                      <span class="badge <?php echo ($active == 'Yes') ? 'bg-success' : 'bg-secondary'; ?>">
                        <?php echo $active; ?>
                      </span>
                    </td>
                    <td>
                      <a href="<?php echo SITEURL; ?>update-category.php?id=<?php echo $id; ?>" class="btn btn-sm btn-warning">
                        <i class="fa fa-edit"></i> Update
                      </a>
                      <a href="<?php echo SITEURL; ?>delete.category.php?id=<?php echo $id; ?>&image_name=<?php echo $image_name; ?>" 
                         class="btn btn-sm btn-danger" 
                         onclick="return confirm('Are you sure you want to delete this category?');">
                        <i class="fa fa-trash"></i> Delete
                      </a>
                    </td>
                  </tr>
              <?php
                }
              } else {
                echo "<tr><td colspan='6' class='text-center text-muted py-4'>No Categories Found</td></tr>";
              }
              ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>

  </div>

  <!-- Footer -->
  <footer class="bg-dark text-light text-center py-3 mt-5">
    <p class="mb-0">&copy; <?php echo date('Y'); ?> Restro Admin | All Rights Reserved</p>
  </footer>

  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
