<?php
include('db.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Update Order - Admin Panel</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="../css/admin.css">
</head>
<body>

<div class="container mt-5">
  <h2 class="text-center mb-4">Update Order</h2>

  <?php
  if (isset($_GET['id'])) {
      $id = $_GET['id'];

      $sql = "SELECT * FROM tbl_order WHERE id=$id";
      $res = mysqli_query($conn, $sql);

      if (mysqli_num_rows($res) == 1) {
          $row = mysqli_fetch_assoc($res);

          $food = $row['food'];
          $price = $row['price'];
          $qty = $row['qty'];
          $status = $row['status'];
          $customer_name = $row['customer_name'];
          $customer_contact = $row['customer_contact'];
          $customer_email = $row['customer_email'];
          $customer_address = $row['customer_address'];
      } else {
          echo "<div class='alert alert-danger'>Order Not Found.</div>";
          exit;
      }
  } else {
      echo "<div class='alert alert-warning'>No order ID provided.</div>";
      exit;
  }
  ?>

  <form action="" method="POST" class="bg-light p-4 rounded shadow-sm">
    <div class="mb-3">
      <label class="form-label">Food</label>
      <input type="text" class="form-control" value="<?= htmlspecialchars($food) ?>" disabled>
    </div>

    <div class="mb-3">
      <label class="form-label">Price</label>
      <input type="text" class="form-control" value="<?= htmlspecialchars($price) ?>" disabled>
    </div>

    <div class="mb-3">
      <label class="form-label">Quantity</label>
      <input type="number" name="qty" value="<?= htmlspecialchars($qty) ?>" class="form-control" required>
    </div>

    <div class="mb-3">
      <label class="form-label">Status</label>
      <select name="status" class="form-select">
        <option value="Ordered" <?= $status == "Ordered" ? "selected" : "" ?>>Ordered</option>
        <option value="On Delivery" <?= $status == "On Delivery" ? "selected" : "" ?>>On Delivery</option>
        <option value="Delivered" <?= $status == "Delivered" ? "selected" : "" ?>>Delivered</option>
        <option value="Cancelled" <?= $status == "Cancelled" ? "selected" : "" ?>>Cancelled</option>
      </select>
    </div>

    <div class="mb-3">
      <label class="form-label">Customer Name</label>
      <input type="text" name="customer_name" value="<?= htmlspecialchars($customer_name) ?>" class="form-control" required>
    </div>

    <div class="mb-3">
      <label class="form-label">Customer Contact</label>
      <input type="text" name="customer_contact" value="<?= htmlspecialchars($customer_contact) ?>" class="form-control" required>
    </div>

    <div class="mb-3">
      <label class="form-label">Customer Email</label>
      <input type="email" name="customer_email" value="<?= htmlspecialchars($customer_email) ?>" class="form-control" required>
    </div>

    <div class="mb-3">
      <label class="form-label">Customer Address</label>
      <textarea name="customer_address" class="form-control" rows="3"><?= htmlspecialchars($customer_address) ?></textarea>
    </div>

    <input type="hidden" name="id" value="<?= $id ?>">
    <input type="hidden" name="price" value="<?= $price ?>">

    <button type="submit" name="submit" class="btn btn-primary">Update Order</button>
    <a href="raph.order.php" class="btn btn-secondary">Cancel</a>
  </form>

  <?php
  if (isset($_POST['submit'])) {
      $id = $_POST['id'];
      $price = $_POST['price'];
      $qty = $_POST['qty'];
      $total = $price * $qty;
      $status = $_POST['status'];
      $customer_name = $_POST['customer_name'];
      $customer_contact = $_POST['customer_contact'];
      $customer_email = $_POST['customer_email'];
      $customer_address = $_POST['customer_address'];

      $sql2 = "UPDATE tbl_order SET 
                qty = '$qty',
                total = '$total',
                status = '$status',
                customer_name = '$customer_name',
                customer_contact = '$customer_contact',
                customer_email = '$customer_email',
                customer_address = '$customer_address'
                WHERE id=$id";

      $res2 = mysqli_query($conn, $sql2);

      if ($res2) {
          echo "<div class='alert alert-success mt-3'>Order Updated Successfully!</div>";
      } else {
          echo "<div class='alert alert-danger mt-3'>Failed to Update Order.</div>";
      }
  }
  ?>
</div>

</body>
</html>
