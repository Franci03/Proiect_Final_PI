<?php
if(isset($message))
    {
        foreach($message as $message)
            echo '<div class="message">
                    <span>'.$message.'</span>
                    <i class="fas fa-times" onclick="this.parentElement.remove();"></i>
                </div>';
    }
    ?>
<header class="header">

    <div class="flex">
        <a href="admin_page.php" class="logo">Admin<span>Panel</span></a>

        <nav class="navbar">
            <a href="admin_page.php">acasă</a>
            <a href="admin_products.php">produse</a>
            <a href="admin_orders.php">comenzi</a>
            <a href="admin_users.php">utilizatori</a>
            <a href="admin_contacts.php">mesaje</a>
        </nav>

        <div class="icons">
            <div id="menu-btn" class="fas fa-bars"></div>
            <div id="user-btn" class="fas fa-user"></div>
        </div>

        <div class="account-box">
            <p>utilizator: <span><?php echo $_SESSION['admin_name']; ?></span></p>
            <p>email: <span><?php echo $_SESSION['admin_email']; ?></span></p>
            <a href="logout.php" class="delete-btn">deconectare</a>
        </div>

    </div>

</header>