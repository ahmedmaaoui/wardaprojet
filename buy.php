<?php

@include 'connexion.php';

session_start();

$user_id = $_SESSION['user_id'];

if(!isset($user_id)){
   header('location:login.php');
};

if(isset($_GET['delete'])){
    $delete_id = $_GET['delete'];
    mysqli_query($conn, "DELETE FROM `buy` WHERE id = '$delete_id'") or die('query failed');
    header('location:buy.php');
}

if(isset($_GET['delete_all'])){
    mysqli_query($conn, "DELETE FROM `buy` WHERE user_id = '$user_id'") or die('query failed');
    header('location:buy.php');
};

if(isset($_POST['update_quantity'])){
    $shop_id = $_POST['shop_id'];
    $shop_quantity = $_POST['shop_quantity'];
    mysqli_query($conn, "UPDATE `buy` SET quantity = '$shop_quantity' WHERE id = '$shop_id'") or die('query failed');
    $message[] = 'cart quantity updated!';
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
         $select_shop = mysqli_query($conn, "SELECT * FROM `buy` WHERE user_id='$user_id' ") or die('query failed');
         if(mysqli_num_rows($select_shop) > 0){
            while($fetch_shop = mysqli_fetch_assoc($select_shop)){
      ?>   
       <div  class="box">
        <a href="buy.php?delete=<?php echo $fetch_shop['id']; ?>" class="fa fa-times" ></a>
        <img src="image/<?php echo $fetch_shop['image']; ?>" alt="" class="image">
        <div class="name"><?php echo $fetch_shop['name']; ?></div>
        <div class="price">dinar<?php echo $fetch_shop['price']; ?>/-</div>
        <form action="" method="post">
            <input type="hidden" value="<?php echo $fetch_shop['id']; ?>" name="shop_id">
        
            <input type="number" min="1" value="<?php echo $fetch_shop['quantity']; ?>" name="shop_quantity" class="qty">
            <input type="submit" value="update" class="option-btn" name="update_quantity">
            
        </form>
        <div class="sub-total"> 
            sub-total : <span><?php echo $sub_total = ($fetch_shop['price'] * $fetch_shop['quantity']); ?></span> </div>
    </div>
    <?php
    $grand_total += $sub_total;
        }
    }else{
        echo '<p class="empty">your shop  is empty</p>';
    }
    ?>
    </div>

    <div class="more-btn">
        <a href="buy.php?delete_all" class="delete-btn <?php echo ($grand_total > 1)?'':'disabled' ?>" onclick="return confirm('delete all from shop?');">delete all</a>
    </div>

    <div class="cart-total">
        <p>grand total : <span>$<?php echo $grand_total; ?>/-</span></p>
        <a href="shop.php" class="option-btn">continue shopping</a>
        <a href="checkout.php" class="btn  <?php echo ($grand_total > 1)?'':'disabled' ?>">proceed to checkout</a>
    </div>

</section>


       <script src="script.js"></script>
      

<?php @include 'footer.php'; ?>
</body>
</html>