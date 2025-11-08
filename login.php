<?php include('./constants.php'); ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>login system</title>
    <link rel="stylesheet" href="../css/admin.css">
</head>


    <?php 
     if(isset($_SESSION['login']))
     {
      echo $_SESSION['login'];
      unset($_SESSION['login']);
     }
     
     if(isset($_SESSION['no-login-message']))
     {
      echo $_SESSION['no-login-message'];
      unset($_SESSION['no-login-message']);
     }
    
     ?>
     <div class="form-container">
    
    <form action="" method="POST" class="text-center">
    <h1 class="text-center">Login</h1>
     <input type="text" name="username" placeholder="your username" class="box" required>
     <input type="password" name="password" placeholder="your password" class="box" required>
     <input type="email" name="email" placeholder="enter email" class="box" required>

     <input type="submit" name="submit" value="login" class="btn">

     <p>don't have an account? <a href="register.php">regiser now</a></p>
    </form>
  </div>

<body>
    
</body>
</html>

<?php

if(isset($_POST['submit']))
{
  $username = $_POST['username'];
  $password = ($_POST['password']);

  $sql = "SELECT * FROM tbl_admin WHERE username='$username' AND password='$password'";
  
  $res = mysqli_query($conn , $sql);

  $count = mysqli_num_rows($res);

  if($count==1)
  {
    $_SESSION['login'] = "<div class='sucess'>login Sucessfully.</div>";
    $_SESSION['user'] = $username; // to check if the user is logged on or not and logout will unset it


    header('Location:'.SITEURL. 'admin/');
  } 
  else
  {
    $_SESSION['login'] = "<div class='error text-center'>login Unsucessfully.</div>";

    header('Location:'.SITEURL. 'admin/login.php');
  }


}


?>
