<?php

@include 'connexion.php';

session_start();

$user_id = $_SESSION['user_id'];

if(!isset($user_id)){
   header('location:login.php');
};

if(isset($_POST['order'])){

    $name =  $_POST['name'];
    $number =  $_POST['number'];
    $email = $_POST['email'];
    $method = $_POST['method'];
    $address = mysqli_real_escape_string($conn, 'flat no. '. $_POST['flat'].', '. $_POST['street'].', '. $_POST['city'].', '. $_POST['country'].' - '. $_POST['pin_code']);
    $placed_on = date('d-M-Y');

    $cart_total = 0;
    $cart_products[] = '';

    $shop_query = mysqli_query($conn, "SELECT * FROM `buy` WHERE user_id = '$user_id'") or die('query failed');
    if(mysqli_num_rows($shop_query) > 0){
        while($shop_item = mysqli_fetch_assoc($shop_query)){
         $shop_products[] = $shop_item['name'].' ('.$shop_item['quantity'].') ';
            $sub_total = ($shop_item['price'] * $shop_item['quantity']);
            $shop_total += $sub_total;
        }
    }

    $total_products = implode(', ',$shop_products);

    $order_query = mysqli_query($conn, "SELECT * FROM `orders` WHERE name = '$name' AND number = '$number' AND email = '$email' AND methode = '$method' AND adress = '$address' AND total_products = '$total_products' AND total_price = '$shop_total'") or die('query failed');

    if($shop_total == 0){
        $message[] = 'your cart is empty!';
    }elseif(mysqli_num_rows($order_query) > 0){
        $message[] = 'order placed already!';
    }else{
        mysqli_query($conn, "INSERT INTO `orders`(user_id, name, number, email, methode, adress, total_products, total_price, placed_on) VALUES('$user_id', '$name', '$number', '$email', '$method', '$address', '$total_products', '$shop_total', '$placed_on')") or die('query failed');
        mysqli_query($conn, "DELETE FROM `buy` WHERE user_id = '$user_id'") or die('query failed');
        $message[] = 'order placed successfully!';
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
    <title>  checkout </title>
<link rel="stylesheet" href="style.css">
<style>

</style>
</head>
<body>
   
<?php @include 'header.php'; ?>

<div class ="bigshop">
    <h1> Checkout</h1>
</div>

<section class="display-order">
    <?php
        $grand_total = 0;
        $select_cart = mysqli_query($conn, "SELECT * FROM `buy` WHERE user_id = '$user_id'") or die('query failed');
        if(mysqli_num_rows($select_shop) > 0){
            while($fetch_shop = mysqli_fetch_assoc($select_shop)){
            $total_price = ($fetch_shop['price'] * $fetch_shop['quantity']);
            $grand_total += $total_price;
    ?>    
    <p> <?php echo $fetch_shop['name'] ?> <span>(<?php echo '$'.$fetch_shop['price'].'/-'.' x '.$fetch_shop['quantity']  ?>)</span> </p>
    <?php
        }
        }else{
            echo '<p class="empty">your cart is empty</p>';
        }
    ?>
    <div class="grand-total">grand total : <span>$<?php echo $grand_total; ?>/-</span></div>
</section>

<section class="checkout">

    <form action="" method="POST">

        <h3>place your order</h3>

        <div class="flex">
            <div class="inputBox">
                <span>your name :</span>
                <input type="text" name="name" placeholder="enter your name">
            </div>
            <div class="inputBox">
                <span>your number :</span>
                <input type="number" name="number" min="0" placeholder="enter your number">
            </div>
            <div class="inputBox">
                <span>your email :</span>
                <input type="email" name="email" placeholder="enter your email">
            </div>
            <div class="inputBox">
                <span>payment method :</span>
                <select name="method">
                    <option value="cash on delivery">cash on delivery</option>
                    <option value="credit card">credit card</option>
                </select>
            </div>
            <div class="inputBox">
                <span>address line 01 :</span>
                <input type="text" name="flat" placeholder="">
            </div>
            <div class="inputBox">
                <span>address line 02 :</span>
                <input type="text" name="street" placeholder="">
            </div>
            <div class="inputBox">
                <span>city :</span>
                <input type="text" name="city" placeholder="">
            </div>
            <div class="inputBox">
                <span>state :</span>
                <input type="text" name="state" placeholder="">
            </div>
            <div class="inputBox">
                <span>country :</span>
                <input type="text" name="country" placeholder="">
            </div>
            <div class="inputBox">
                <span>pin code :</span>
                <input type="number" min="0" name="pin_code" placeholder="">
            </div>
        </div>

        <input type="submit" name="order" value="order now" class="btn">

    </form>

</section>



<?php @include 'footer.php'; ?>

</body>
</html>