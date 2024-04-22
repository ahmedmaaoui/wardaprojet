<?php

@include 'connexion.php';

session_start();

$user_id = $_SESSION['user_id'];

if(!isset($user_id)){
   header('location:login.php');
}

if(isset($_POST['add_to_buy'])){

   $product_id = $_POST['product_id'];
   $product_name = $_POST['product_name'];
   $product_price = $_POST['product_price'];
   $product_image = $_POST['product_image'];

   $check_cart_numbers = mysqli_query($conn, "SELECT * FROM `buy` WHERE name = '$product_name' AND user_id = '$user_id'") or die('query failed');

   if(mysqli_num_rows($check_cart_numbers) > 0){
       $message[] = 'already added to shop';
   }else{
       mysqli_query($conn, "INSERT INTO `buy`(user_id, pid, name, price, quantity, image) VALUES('$user_id', '$product_id', '$product_name', '$product_price', '$product_quantity', '$product_image')") or die('query failed');
       $message[] = 'product added to shop';
   }

}
if(isset($_GET['delete'])){
    $delete_id = $_GET['delete'];
    mysqli_query($conn, "DELETE FROM `belike` WHERE id = '$delete_id'") or die('query failed');
    header('location:belike.php');
}

if(isset($_GET['delete_all'])){
    mysqli_query($conn, "DELETE FROM `belike` WHERE user_id = '$user_id'") or die('query failed');
    header('location:belike.php');
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
 <div class ="bigshop">
    <h1> I'LIKE</h1>
</div>

<section class="like">

   <h1 class="title">flowers added in like</h1>

   <div class="box-container">

      <?php
      $grand_total=0 ;
         $select_like = mysqli_query($conn, "SELECT * FROM `belike` WHERE user_id='$user_id' ") or die('query failed');
         if(mysqli_num_rows($select_like) > 0){
            while($fetch_like = mysqli_fetch_assoc($select_like)){
      ?>
      <form action="" method="POST" class="box">
        <div class ="icon">
            <a href="belike.php?delete=<?php echo $fetch_like['id'] ;?>" class="fa fa-times"></a>
         <div class="price"><?php echo $fetch_like['price']; ?> /-</div> 
         <img src="image/<?php echo $fetch_like['image']; ?>" alt="" class="image">
         <div class="name"><?php echo $fetch_like['name']; ?></div>
         <input type="hidden" name="product_id" value="<?php echo $fetch_like['id']; ?>">
         <input type="hidden" name="product_name" value="<?php echo $fetch_like['name']; ?>">
         <input type="hidden" name="product_price" value="<?php echo $fetch_like['price']; ?>">
         <input type="hidden" name="product_image" value="<?php echo $fetch_like['image']; ?>">
           <button type="submit" name="add_to_buy" class="btn"> add to shop <i class="fa fa-shopping-cart"></i></button>
            </div>
      </form>
      <?php
       $grand_total += $fetch_like['price'];
        }
    }else{
        echo '<p class="empty">your like is empty</p>';
    }
    ?>
    </div>

    <div class="like-total">
        <p>grand total : <span>dinar<?php echo $grand_total; ?>/-</span></p>
        <a href="shop.php" class="option-btn">continue shopping</a>
        <a href="belike.php?delete_all" class="btn <?php echo ($grand_total > 1)?'':'disabled' ?>" onclick="return confirm('delete all from like?');">delete all</a>
    </div>

   

</section>

      
       <script src="script.js"></script>
      

<?php @include 'footer.php'; ?>
</body>
</html>