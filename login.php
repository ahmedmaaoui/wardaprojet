
<?php
session_start();

if (isset($_POST["login"])) {
           $email = $_POST["email"];
           $password = $_POST["password"];
           $user_type = $_POST["user_type"];

            require_once "connexion.php" ;
            $sql = "SELECT * FROM users WHERE email = '$email'";
            $select_users = mysqli_query($conn, $sql);
      


 if(mysqli_num_rows($select_users) > 0){
      
      $row = mysqli_fetch_assoc($select_users);

      if($row['user_type'] == 'admin'){

         $_SESSION['admin_name'] = $row['name'];
         $_SESSION['admin_email'] = $row['email'];
         $_SESSION['admin_id'] = $row['id'];
         header('location:admin.php');

      }elseif($row['user_type'] == 'user'){

         $_SESSION['user_name'] = $row['name'];
         $_SESSION['user_email'] = $row['email'];
         $_SESSION['user_id'] = $row['id'];
         header('location:home.php');

      }else{
         $errors[] = 'no user found!';
      }

   }else{
      $errors[] = 'incorrect email or password!';
   }

}

        


?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>login</title>
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
   <link rel="stylesheet" href="style.css">

</head>
<body>

<?php
if(isset($errors)){
   foreach($errors as $error){
      echo '
      <div class="message">
         <span>'.$message.'</span>
         <i class="fas fa-times" onclick="this.parentElement.remove();"></i>
      </div>
      ';
   }
}
?>
   
<section class="form-container">

   <form action="" method="post">
      <h3>login now</h3>
      <input type="email" name="email" class="box" placeholder="enter your email" required>
      <input type="password" name="password" class="box" placeholder="enter your password" required>
      <input type="submit" class="btn" name="login" value="login now">
      <p>don't have an account? <a href="register.php">register now</a></p>
   </form>

</section>

</body>
</html>