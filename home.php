<?php

@include 'connexion.php';

session_start();

$user_id = $_SESSION['user_id'];

if(!isset($user_id)){
   header('location:login.php');
   
   if (isset($_POST['logout'])){
    session_destroy() ;
    header('location:login.php') ;
}
}
if(isset($_POST['add_to_like'])){

   $product_id = $_POST['product_id'];
   $product_name = $_POST['product_name'];
   $product_price = $_POST['product_price'];
   $product_image = $_POST['product_image'];
   
   
   $check_wishlist_numbers = mysqli_query($conn, "SELECT * FROM `belike` WHERE name = '$product_name' AND user_id = '$user_id'") or die('query failed');

   $check_cart_numbers = mysqli_query($conn, "SELECT * FROM `buy` WHERE name = '$product_name' AND user_id = '$user_id'") or die('query failed');

   if(mysqli_num_rows($check_wishlist_numbers) > 0){
       $message[] = 'already added to wishlist';
   }elseif(mysqli_num_rows($check_cart_numbers) > 0){
       $message[] = 'already added to cart';
   }else{
       mysqli_query($conn, "INSERT INTO `belike`(user_id, pid, name, price, image) VALUES('$user_id', '$product_id', '$product_name', '$product_price', '$product_image')") or die('query failed');
       $message[] = 'product added to wishlist';
   }

}
if(isset($_POST['add_to_buy'])){

   $product_id = $_POST['product_id'];
   $product_name = $_POST['product_name'];
   $product_price = $_POST['product_price'];
   $product_image = $_POST['product_image'];
 $product_quantity = $_POST['product_quantity'];
   $check_cart_numbers = mysqli_query($conn, "SELECT * FROM `buy` WHERE name = '$product_name' AND user_id = '$user_id'") or die('query failed');

   if(mysqli_num_rows($check_cart_numbers) > 0){
       $message[] = 'already added to shop';
   }else{
       mysqli_query($conn, "INSERT INTO `buy`(user_id, pid, name, price, quantity, image) VALUES('$user_id', '$product_id', '$product_name', '$product_price', '$product_quantity', '$product_image')") or die('query failed');
       $message[] = 'product added to shop';
   }

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
    <title>  home  </title>
<link rel="stylesheet" href="style.css">
<style>

</style>
    
</head>
<body>
 
 <?php @include 'header.php'; ?>
<section class="header_user_box">
 
   <div class="content">
   
      <h1 >The Gift of Flowers </h1>
      <a href="shop.php" class="btn" >discover more</a>
   </div>
</section>
<div class ="mix">
   <div class ="max">
      <div class ="min">
         <span> 40 % OFF TODAY </span>
         <h1> simple & elegent </h1>
         <a href ="shop.php">shop now </a>
      </div>
   </div>
   <div class ="max">
      <div class ="min">
         <span> 40 % OFF TODAY </span>
         <h1> simple & elegent </h1>
         <a href ="shop.php">shop now </a>
      </div>
   </div>
   <div class ="max">
      <div class ="min">
         <span> 40 % OFF TODAY </span>
         <h1> simple & elegent </h1>
         <a href ="shop.php">shop now </a>
      </div>
   </div>
</div>
<div class="categories">
   <h1 class ="title">TOP CATEGORIES </h1>
   <div class="left">  
   <div class="box">
         <img src="image/birdhday.jpg">
         <span>birthday</span>
      </div>
      <div class="box">
         <img src="image/wedding.jpg">
         <span>wedding</span>
      </div>
      <div class="box">
         <img src="image/firstmeeting.jpg">
         <span>first meeting</span>
      </div>
      <div class="box">
         <img src="image/sympathy.jpg">
         <span>sympathy</span>
      </div>
      <div class="box">
         <img src="image/house.jpg">
         <span>house</span>
      </div>
</div>
</div>
<section class="products">

   <h1 class="title">latest products</h1>

   <div class="box-container">

      <?php
         $select_products = mysqli_query($conn, "SELECT * FROM `flowers` LIMIT 6") or die('query failed');
         if(mysqli_num_rows($select_products) > 0){
            while($fetch_products = mysqli_fetch_assoc($select_products)){
      ?>
      <form action="" method="POST" class="box">
        <div class="price"><?php echo $fetch_products['price']; ?> dt remise -<?php echo $fetch_products['price_redux']; ?> %</div>
         <img src="image/<?php echo $fetch_products['image']; ?>" alt="" class="image">
         <div class="name"><?php echo $fetch_products['name']; ?></div>
         <input type="hidden" name="product_id" value="<?php echo $fetch_products['id']; ?>">
         <input type="hidden" name="product_name" value="<?php echo $fetch_products['name']; ?>">
         <input type="hidden" name="product_price" value="<?php echo $fetch_products['price']; ?>">
          <input type="hidden" name="product_quantity" value="1" min="0">
         <input type="hidden" name="product_image" value="<?php echo $fetch_products['image']; ?>">
        <div class="icon">
         <button type="submit" name="add_to_like" class="fa fa-heart"></button>
           <button type="submit" name="add_to_buy" class="fa fa-shopping-cart"></button>
            </div>
      </form>
      <?php
         }
      }else{
         echo '<p class="empty">no products added yet!</p>';
      }
      ?>

   </div>

   <div class="more-btn">
      <a href="shop.php" class="option-btn">load more</a>
      <i class="fa fa-arrow-down"></i>
   </div>

</section>

      
       <script src="script.js"></script>
      

<?php @include 'footer.php'; ?>
</body>
</html>