<?php
include "db.php";

// ----------------------------
// 1️⃣ Access Control
// ----------------------------

// Check if user is logged in
if (!isset($_SESSION['user'])) {
    header("Location: login.php"); // redirect guests to login
    exit;
}

// Check if user is admin
if (!isset($_SESSION['user']['role']) || $_SESSION['user']['role'] !== 'admin') {
    header("HTTP/1.1 403 Forbidden"); // show forbidden error
    echo "<h1>403 - Forbidden</h1><p>You do not have permission to access this page.</p>";
    exit;
}

// ----------------------------
// 2️⃣ Handle user deletion
// ----------------------------
$message = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_user_id'])) {
    $delete_id = intval($_POST['delete_user_id']);

    // Prevent admin from deleting themselves
    if ($delete_id === $_SESSION['user_id']) {
        $message[] = "You cannot delete yourself!";
    } else {
        $stmt = $conn->prepare("DELETE FROM user_form WHERE id=?");
        $stmt->bind_param("i", $delete_id);
        $stmt->execute();
        $message[] = "User deleted successfully!";
    }
}

// ----------------------------
// 3️⃣ Get stats
// ----------------------------
$user_count_query = $conn->query("SELECT COUNT(*) as total FROM user_form");
$user_count = $user_count_query->fetch_assoc()['total'];

$online_count_query = $conn->query("SELECT COUNT(*) as online_count FROM user_form WHERE is_logged_in = 1");
$online_count = $online_count_query->fetch_assoc()['online_count'];

// Fetch all users
$users_query = $conn->query("SELECT * FROM user_form ORDER BY id DESC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Admin Dashboard</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="css/style.css">
</head>
<body class="bg-light">
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card shadow">
                <div class="card-body">
                    <h2 class="mb-4 text-center">Admin Dashboard</h2>

                    <!-- Flash messages -->
                    <?php if(!empty($message)) {
                        foreach($message as $msg){
                            echo '<div class="alert alert-info text-center">'.$msg.'</div>';
                        }
                    } ?>

                    <div class="row mb-4">
                        <div class="col-md-6">
                            <div class="alert alert-info mb-0">
                                <strong>Total Registered Users:</strong> <?php echo $user_count; ?>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="alert alert-success mb-0">
                                <strong>Users Currently Online:</strong> <?php echo $online_count; ?>
                            </div>
                        </div>
                    </div>

                    <table class="table table-bordered table-hover align-middle">
                        <thead class="table-dark">
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Role</th>
                                <th>Profile Image</th>
                                <th>Edit</th>
                                <th>Delete</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while($row = $users_query->fetch_assoc()): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($row['id']); ?></td>
                                <td><?php echo htmlspecialchars($row['name']); ?></td>
                                <td><?php echo htmlspecialchars($row['email']); ?></td>
                                <td><?php echo htmlspecialchars($row['role']); ?></td>
                                <td>
                                    <?php if($row['image']): ?>
                                        <img src="uploaded_img/<?php echo htmlspecialchars($row['image']); ?>" width="40" height="40" class="rounded-circle">
                                    <?php else: ?>
                                        <img src="images/default-avatar.png" width="40" height="40" class="rounded-circle">
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <a href="update_profile.php?user_id=<?php echo urlencode($row['id']); ?>" class="btn btn-sm btn-primary">Edit</a>
                                </td>
                                <td>
                                    <?php if($row['id'] !== $_SESSION['user_id']): ?>
                                    <form action="" method="post" onsubmit="return confirm('Are you sure you want to delete this user?');" style="display:inline;">
                                        <input type="hidden" name="delete_user_id" value="<?php echo $row['id']; ?>">
                                        <button type="submit" name="delete_user" class="btn btn-sm btn-danger">Delete</button>
                                    </form>
                                    <?php else: ?>
                                        <span class="text-muted">N/A</span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>

                    <a href="home.php" class="btn btn-secondary mt-3">Back to Home</a>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>
