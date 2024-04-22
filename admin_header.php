<header class="header">

    <div class="flex">

       <a href="admin.php" ><img class="logo" src="img/Wardalogo.svg" alt=""></a>
      <!-- <a href="admin.php" class ="logo" >Admin</a> -->

        <nav class="navbar">
            <ul>
                <li><a href="admin.php">home</a></li>
                <li><a href="admin_products.php">products</a></li>
                <li><a href="admin_users.php">users</a></li>
                <li><a href="admin_orders.php">orders</a></li>
                <li><a href="admin_messages.php">messages</a></li>
           
            </ul>
        </nav>

        <div class="icons">
            <i id="menu-btn" class="fa fa-bars"></i>
         <i id="user-btn" class="fa fa-user"></i>

        </div>

      <div class="account-box">
         <p>username : <span><?php echo $_SESSION['admin_name']; ?></span></p>
         <p>email : <span><?php echo $_SESSION['admin_email']; ?></span></p>
         <form method ="post" class="logout">
                <button name="logout" class="logout-btn"> logout </button>
         </form>

        </div>

    </div>
</header>