<?php

@include 'connexion.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if(!isset($admin_id)){
   header('location:login.php');
}
if (isset($_POST['logout'])){
    session_destroy() ;
    header('location:login.php') ;
}
if(isset($_POST['add_product'])){

   $name = mysqli_real_escape_string($conn, $_POST['name']);
   $price = mysqli_real_escape_string($conn, $_POST['price']);
$price_reduction = mysqli_real_escape_string($conn, $_POST['price_redux']);
  $details = mysqli_real_escape_string($conn, $_POST['detail']);
   $image = $_FILES['image']['name'];
   $image_size = $_FILES['image']['size'];
   $image_tmp_name = $_FILES['image']['tmp_name'];
   $image_folter = 'image/'.$image;

   $select_product_name = mysqli_query($conn, "SELECT name FROM `flowers` WHERE name = '$name'") or die('query failed');

   if(mysqli_num_rows($select_product_name) > 0){
      $message[] = 'product name already exist!';
   }else{
      $insert_product = mysqli_query($conn, "INSERT INTO `flowers`(name, detail, price, image ,price_redux) VALUES('$name', '$details', '$price', '$image' ,'$price_reduction')") or die('query failed');

      if($insert_product){
         if($image_size > 20000000){
            $message[] = 'image size is too large!';
         }else{
            move_uploaded_file($image_tmp_name, $image_folter);
            $message[] = 'product added successfully!';
         }
      }
   }
}
//    if(isset($_Get['delete'])){

//    $delete_id = $_Get['delete'];
//    $select_delete_image = mysqli_query($conn, "SELECT image FROM `flowers` WHERE id = '$delete_id'") or die('query failed');
//    $fetch_delete_image = mysqli_fetch_assoc($select_delete_image);
//    unlink('image/'.$fetch_delete_image['image']);
//    mysqli_query($conn, "DELETE FROM `flowers` WHERE id = '$delete_id'") or die('query failed');
//    header('location:admin_products.php');



// }

if(isset($_GET['delete'])){
   $delete_id = $_GET['delete'];
   mysqli_query($conn, "DELETE FROM `flowers` WHERE id = '$delete_id'") or die('query failed');
   header('location:admin_products.php');
}


?>


<!DOCTYPE html>
<html lang="en">
<head>
       <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
       <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    
  <link rel="stylesheet" href="admin_style.css">
  <?php @include 'admin_header.php'; ?>

<section class="add-products">

   <form action="" method="POST" enctype="multipart/form-data">
      <h3>add new product</h3>
      <input type="text" class="box" required placeholder="enter product name" name="name">
      <input type="number" min="0" class="box" required placeholder="enter product price" name="price">
      <input type="number" min="0" class="box" required placeholder="enter product reduction %" name="price_redux">
      <textarea name="detail" class="box" required placeholder="enter product details" cols="30" rows="10"></textarea>
      <input type="file" accept="image/jpg, image/jpeg, image/png" required class="box" name="image">
      <input type="submit" value="add product" name="add_product" class="btn">
   </form>

</section>
<section class="show-products">

   <div class="box-container-product">

      <?php
         $select_products = mysqli_query($conn, "SELECT * FROM `flowers`") or die('query failed');
         if(mysqli_num_rows($select_products) > 0){
            while($fetch_products = mysqli_fetch_assoc($select_products)){
      ?>
      <div class="box-flower">
         <div class="price"><?php echo $fetch_products['price']; ?> dt remise -<?php echo $fetch_products['price_redux']; ?> %</div>
         <img class="image" src="image/<?php echo $fetch_products['image']; ?>" alt="">
         <div class="name"><?php echo $fetch_products['name']; ?></div>
         <div class="detail"><?php echo $fetch_products['detail']; ?></div>
          <a href="update.php?update=<?php echo $fetch_products['id']; ?>" class="option-btn">update</a> 
         <a href="admin_products.php?delete=<?php echo $fetch_products['id']; ?>" class="delete-btn" >delete</a>
      </div>
      <?php
         }
      }else{
         echo '<p class="empty">no products added yet!</p>';
      }
      ?>
   </div>
   

</section>
<script src="script.js"></script>



