<header class="header">

    <div class="flex">

       <a href="home.php" ><img class="logo" src="img/Wardalogo.svg" alt=""></a>
     

        <nav class="navi">
            <ul>
                <li><a href="home.php">home</a></li>
                <li><a href="shop.php">shop</a></li>
                <li><a href="contact.php">contact</a></li>
                <li><a href="orders.php">orders</a></li>
            
           
            </ul>
        </nav>



        <div class="icons">
            
         <i id="user-btn" class="fa fa-user"></i>
         <?php
                $select_like = mysqli_query($conn, "SELECT * FROM `belike` WHERE user_id = '$user_id'") or die('query failed');
                $like_num_rows = mysqli_num_rows($select_like);
            ?>
            <a href="belike.php"><i class="fa fa-heart"></i><span>(<?php echo $like_num_rows; ?>)</span></a>
            <?php
                $select_shop = mysqli_query($conn, "SELECT * FROM `buy` WHERE user_id = '$user_id'") or die('query failed');
                $shop_num_rows = mysqli_num_rows($select_shop);
            ?>
            <a href="buy.php"><i class="fa fa-shopping-cart"></i><span>(<?php echo $shop_num_rows; ?>)</span></a>
            
      
        </div>
        </div>

       <div class="account-box">
         <p>name : <span><?php echo $_SESSION['admin_name']; ?></span></p>
         <p>email : <span><?php echo $_SESSION['admin_email']; ?></span></p>
         <form method ="post" class="logout">
                <button name="logout" class="logout-btn"> logout </button>
         </form>

        </div>  

    </div>
</header>