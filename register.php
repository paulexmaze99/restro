<?php
include 'db.php';

$message = [];

if(isset($_POST['submit'])){

   $name  = mysqli_real_escape_string($conn, $_POST['name']);
   $email = mysqli_real_escape_string($conn, $_POST['email']);
   $pass  = $_POST['password'];
   $cpass = $_POST['cpassword'];

   // Check if email exists
   $check = $conn->prepare("SELECT id FROM user_form WHERE email=?");
   $check->bind_param("s", $email);
   $check->execute();
   $check->store_result();

   if($check->num_rows > 0){
      $message[] = "User already exists!";
   } else {

      if($pass !== $cpass){
         $message[] = "Passwords do not match!";
      } else {
         
         // SECURE PASSWORD HASHING
         $hashedPass = password_hash($pass, PASSWORD_DEFAULT);

         $stmt = $conn->prepare("INSERT INTO user_form(name, email, password, role) VALUES(?,?,?, 'user')");
         $stmt->bind_param("sss", $name, $email, $hashedPass);
         $stmt->execute();

         $message[] = "Registered successfully!";
         header("Location: login.php");
         exit;
      }
   }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <title>Register</title>
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
         if(document.body.classList.contains('dark-mode')) {
            icon.classList.remove('bi-moon');
            icon.classList.add('bi-sun');
         } else {
            icon.classList.remove('bi-sun');
            icon.classList.add('bi-moon');
         }
      }
      window.onload = function() {
         const icon = document.getElementById('darkModeIcon');
         if(localStorage.getItem('darkMode') === 'true') {
            document.body.classList.add('dark-mode');
            icon.classList.remove('bi-moon');
            icon.classList.add('bi-sun');
         } else {
            icon.classList.remove('bi-sun');
            icon.classList.add('bi-moon');
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
               <form action="" method="post">
                  <h3 class="mb-4 text-center">Register</h3>
                  <?php if(isset($message)) foreach($message as $msg) echo '<div class="alert alert-info">'.$msg.'</div>'; ?>
                  <div class="mb-3">
                     <label class="form-label">Name</label>
                     <input type="text" name="name" class="form-control" required>
                  </div>
                  <div class="mb-3">
                     <label class="form-label">Email</label>
                     <input type="email" name="email" class="form-control" required>
                  </div>
                  <div class="mb-3">
                     <label class="form-label">Password</label>
                     <input type="password" name="password" class="form-control" required>
                  </div>
                  <div class="mb-3">
                     <label class="form-label">Confirm Password</label>
                     <input type="password" name="cpassword" class="form-control" required>
                  </div>
                  <input type="submit" name="submit" value="Register" class="btn btn-primary w-100">
                  <p class="mt-3 text-center">Already have an account? <a href="login.php">Login</a></p>
               </form>
            </div>
         </div>
      </div>
   </div>
</div>
</body>
</html>