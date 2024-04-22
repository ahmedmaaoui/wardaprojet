<?php




if (isset($_POST["submit"])) {
         
           $name = $_POST["name"];
           $email = $_POST["email"];
           $password = $_POST["password"];
           $passwordRepeat = $_POST["repeat_password"] ;
           
           $errors = array();
           
           if (empty($name)  OR empty($email) OR empty($password) OR empty($passwordRepeat)) {
            array_push($errors,"All fields are required");
           }
         
           if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            array_push($errors, "Email is not valid");
           
           }
         

           if ($password!==$passwordRepeat) {
            array_push($errors,"Password is not valid");
           }
           require_once "connexion.php";

       $sql = "SELECT * FROM users WHERE email = '$email'";
       $resultat=mysqli_query($conn,$sql) ;
       $rows=mysqli_num_rows($resultat) ;
       if($rows>0){
        array_push($errors ," Email already exists" ) ;
       }
if(count( $errors)>0) {
    foreach ($errors as $error) {
             array_push($error,"problem");
}
}
else {
    $sql = "INSERT INTO users (name , email, password ) VALUES(?,?,? )";
             $stmt = mysqli_stmt_init($conn);
              $prepareStmt = mysqli_stmt_prepare($stmt,$sql);
              if ($prepareStmt) {
             mysqli_stmt_bind_param($stmt,"sss",$name, $email, $password );
                mysqli_stmt_execute($stmt);
                 echo "<div class='alert alert-success'>You are registered successfully.</div>";
             
              }else{
             die("Something went wrong");
              }
           
             }     


            }            
?>


<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>register</title>
   
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
   <link rel="stylesheet" href="style.css">

</head>
<body>
<section class="form-container">

   <form action="" method="post">
      <h3>register now</h3>
      <input type="text" name="name" class="box" placeholder="enter your name" required>
      <input type="email" name="email" class="box" placeholder="enter your email" required>
      <input type="password" name="password" class="box" placeholder="enter your password" required>
      <input type="password" name="repeat_password" class="box" placeholder="confirm your password" required>
      <input type="submit" class="btn" name="submit" value="register now">
      <p>already have an account? <a href="login.php">login now</a></p>
   </form>

</section>

</body>
</html>
