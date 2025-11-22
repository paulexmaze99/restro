<?php
include 'db.php';

$message = [];

if(isset($_POST['submit'])) {

    $email = trim($_POST['email']);
    $password = $_POST['password'];

    // Fetch the user
    $stmt = $conn->prepare("SELECT * FROM user_form WHERE email=? LIMIT 1");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if($result->num_rows === 0){
        $message[] = "Incorrect email or password!";
    } else {

        $row = $result->fetch_assoc();

        $dbPass = $row['password'];

        // --- CASE 1: NEW HASH PASSWORD ---
        if(password_verify($password, $dbPass)) {
            $verified = true;

        // --- CASE 2: OLD USERS WITH MD5 ---
        } elseif($dbPass === md5($password)) {

            $verified = true;

            // AUTO-UPDATE MD5 → password_hash()
            $newHash = password_hash($password, PASSWORD_DEFAULT);

            $up = $conn->prepare("UPDATE user_form SET password=? WHERE id=?");
            $up->bind_param("si", $newHash, $row['id']);
            $up->execute();
        }
        else {
            $verified = false;
        }

        if(!$verified){
            $message[] = "Incorrect email or password!";
        }
        elseif($row['role'] !== "admin") {
            $message[] = "Only admins can log in here.";
        }
        else {
            // LOGIN OK
            $_SESSION['user'] = $row;
            $_SESSION['user_id'] = $row['id'];

            // Update logged_in status
            $stmt2 = $conn->prepare("UPDATE user_form SET is_logged_in = 1 WHERE id=?");
            $stmt2->bind_param("i", $row['id']);
            $stmt2->execute();

            header("Location: profile.php");
            exit;
        }
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Admin Login</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
<style>
body.dark-mode { background-color: #181a1b !important; color: #f8f9fa !important; }
</style>
<script>
function toggleDarkMode() {
    document.body.classList.toggle('dark-mode');
    localStorage.setItem('darkMode', document.body.classList.contains('dark-mode'));
    const icon = document.getElementById('darkModeIcon');
    icon.classList.toggle('bi-moon');
    icon.classList.toggle('bi-sun');
}

window.onload = function() {
    const icon = document.getElementById('darkModeIcon');
    if(localStorage.getItem('darkMode') === 'true') {
        document.body.classList.add('dark-mode');
        icon.classList.replace('bi-moon', 'bi-sun');
    }
}
</script>
</head>
<body class="bg-light">
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-5">
            <div class="card shadow">
                <div class="card-body">
                    <div class="text-end mb-3">
                        <button class="btn btn-secondary btn-sm" onclick="toggleDarkMode()" type="button">
                            <span id="darkModeIcon" class="bi bi-moon"></span>
                        </button>
                    </div>
                    <form method="post">
                        <h3 class="mb-4 text-center">Admin Login</h3>

                        <?php
                        if(!empty($message)){
                            foreach($message as $msg){
                                echo '<div class="alert alert-danger text-center">'.$msg.'</div>';
                            }
                        }
                        ?>

                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" name="email" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Password</label>
                            <input type="password" name="password" class="form-control" required>
                        </div>
                        <input type="submit" name="submit" value="Login" class="btn btn-primary w-100">
                        <p class="mt-3 text-center">Don't have an account? <a href="register.php">Register</a></p>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
