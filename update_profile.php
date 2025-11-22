<?php

include 'db.php';


// Allow admin to edit any user via ?user_id=ID, otherwise edit self
if (isset($_GET['user_id'])) {
    $edit_user_id = intval($_GET['user_id']);
} else {
    $edit_user_id = $_SESSION['user_id'];
}

// Fetch user data for the form
$select = mysqli_query($conn, "SELECT * FROM `user_form` WHERE id = '$edit_user_id'") or die('query failed');
if(mysqli_num_rows($select) > 0){
    $fetch = mysqli_fetch_assoc($select);
} else {
    die('User not found.');
}

if(isset($_POST['update_profile'])){

   $update_name = mysqli_real_escape_string($conn, $_POST['update_name']);
   $update_email = mysqli_real_escape_string($conn, $_POST['update_email']);

   mysqli_query($conn, "UPDATE `user_form` SET name = '$update_name', email = '$update_email' WHERE id = '$edit_user_id'") or die('query failed');

   $old_pass = $_POST['old_pass'];
   $update_pass = mysqli_real_escape_string($conn, md5($_POST['update_pass']));
   $new_pass = mysqli_real_escape_string($conn, md5($_POST['new_pass']));
   $confirm_pass = mysqli_real_escape_string($conn, md5($_POST['confirm_pass']));

   if(!empty($update_pass) || !empty($new_pass) || !empty($confirm_pass)){
      if($update_pass != $old_pass){
         $message[] = 'old password not matched!';
      }elseif($new_pass != $confirm_pass){
         $message[] = 'confirm password not matched!';
      }else{
         mysqli_query($conn, "UPDATE `user_form` SET password = '$confirm_pass' WHERE id = '$edit_user_id'") or die('query failed');
         $message[] = 'password updated successfully!';
      }
   }

   $update_image = $_FILES['update_image']['name'];
   $update_image_size = $_FILES['update_image']['size'];
   $update_image_tmp_name = $_FILES['update_image']['tmp_name'];
   $update_image_folder = 'uploaded_img/'.$update_image;

   // Ensure the upload directory exists
   if (!is_dir('uploaded_img')) {
      mkdir('uploaded_img', 0777, true);
   }

   if(!empty($update_image)){
      if($update_image_size > 2000000){
         $message[] = 'image is too large';
      }else{
         $image_update_query = mysqli_query($conn, "UPDATE `user_form` SET image = '$update_image' WHERE id = '$edit_user_id'") or die('query failed');
         if($image_update_query){
            move_uploaded_file($update_image_tmp_name, $update_image_folder);
         }
         $message[] = 'image updated succssfully!';
      }
   }

   // Redirect: always go back to dashboard after update
   header('Location: profile.php');
   exit;
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Update Profile</title>
   <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
   <link rel="stylesheet" href="css/style.css">
</head>
<body class="bg-light">
<div class="container py-5">
   <div class="row justify-content-center">
      <div class="col-md-8">
         <div class="card shadow">
            <div class="card-body">
               <h2 class="mb-4 text-center">Update Profile</h2>
               <form action="" method="post" enctype="multipart/form-data">
                  <div class="text-center mb-4">
                     <?php
                        if($fetch['image'] == ''){
                           echo '<img src="images/default-avatar.png" class="rounded-circle mb-2" width="120" height="120">';
                        }else{
                           echo '<img src="uploaded_img/'.$fetch['image'].'" class="rounded-circle mb-2" width="120" height="120">';
                        }
                        if(isset($message)){
                           foreach($message as $msg){
                              echo '<div class="alert alert-info text-center">'.$msg.'</div>';
                           }
                        }
                     ?>
                  </div>
                  <div class="row">
                     <div class="col-md-6">
                        <div class="mb-3">
                           <label class="form-label">Username</label>
                           <input type="text" name="update_name" value="<?php echo htmlspecialchars($fetch['name']); ?>" class="form-control" required>
                        </div>
                        <div class="mb-3">
                           <label class="form-label">Your Email</label>
                           <input type="email" name="update_email" value="<?php echo htmlspecialchars($fetch['email']); ?>" class="form-control" required>
                        </div>
                        <div class="mb-3">
                           <label class="form-label">Update your pic</label>
                           <input type="file" name="update_image" accept="image/jpg, image/jpeg, image/png" class="form-control">
                        </div>
                     </div>
                     <div class="col-md-6">
                        <input type="hidden" name="old_pass" value="<?php echo $fetch['password']; ?>">
                        <div class="mb-3">
                           <label class="form-label">Old Password</label>
                           <input type="password" name="update_pass" placeholder="Enter previous password" class="form-control">
                        </div>
                        <div class="mb-3">
                           <label class="form-label">New Password</label>
                           <input type="password" name="new_pass" placeholder="Enter new password" class="form-control">
                        </div>
                        <div class="mb-3">
                           <label class="form-label">Confirm Password</label>
                           <input type="password" name="confirm_pass" placeholder="Confirm new password" class="form-control">
                        </div>
                     </div>
                  </div>
                  <div class="d-flex justify-content-between">
                     <input type="submit" value="Update Profile" name="update_profile" class="btn btn-primary">
                     <?php if (isset($_GET['user_id'])): ?>
                        <a href="profile.php" class="btn btn-danger">Go Back</a>
                     <?php else: ?>
                        <a href="home.php" class="btn btn-danger">Go Back</a>
                     <?php endif; ?>
                  </div>
               </form>
            </div>
         </div>
      </div>
   </div>
</div>
</body>
</html>