<?php

include 'config.php';
session_start();

$admin_id = $_SESSION['admin_id'];

if(!isset($admin_id))
{
    header('location:login.php');
}

if(isset($_POST['update_order']))
{
    $order_update_id = $_POST['order_id'];
    $update_payment = $_POST['update_payment'];
    mysqli_query($conn, "UPDATE `orders` SET payment_status = '$update_payment' WHERE id = '$order_update_id'") or die('query failed');
    $message[] = 'Statusul de plată a fost actualizat!';
}

if(isset($_GET['delete'])){
    $delete_id = $_GET['delete'];
    mysqli_query($conn, "DELETE FROM `orders` WHERE id = '$delete_id'") or die('query failed');
    header('location:admin_orders.php');
 }
 

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>orders</title>

     <!--font awsome link-->
     <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

     <!--custom admin css link-->
     <link rel="stylesheet" href="css/admin_style.css">

</head>
<body>
    <?php
     include 'admin_header.php';
    ?>
    <section class="orders">
        <h2>~bliophile boutique~</h2>
        <h1 class="title">Comenzi</h1>

        <div class="box-container">
            <?php
                $select_orders = mysqli_query($conn, "SELECT * FROM `orders`") or die('query failed');

                if(mysqli_num_rows($select_orders) > 0)
                {
                    while($fetch_orders = mysqli_fetch_assoc($select_orders))
                    {       
            ?>
            <div class="box">
                <p>id utilizator: <span><?php echo $fetch_orders['user_id'];?></span></p>
                <p>plasare comandă: <span><?php echo $fetch_orders['placed_on'];?></span></p>
                <p>nume: <span><?php echo $fetch_orders['name'];?></span></p>
                <p>număr tel.: <span><?php echo $fetch_orders['number'];?></span></p>
                <p>adresă: <span><?php echo $fetch_orders['address'];?></span></p>
                <p>produse: <span><?php echo $fetch_orders['total_products'];?></span></p>
                <p>preț total: <span><?php echo $fetch_orders['total_price'];?></span></p>
                <p>metodă de plată: <span><?php echo $fetch_orders['method'];?></span></p>

                <form action="" method="POST">
                    <input type="hidden"  name="order_id" id="" value="<?php echo $fetch_orders['id'];?>">
                    <select name="update_payment" id="">
                        <option value="" disabled selected><?php echo $fetch_orders['payment_status'];?></option>
                        <option value="pending">în așteptare</option>
                        <option value="completed">complet</option>
                    </select>
                    <input type="submit" value="actualizare" name="update_order" class="option-btn">
                    <a href="admin_orders.php?delete=<?php echo $fetch_orders['id'];?>" onclick="return confirm('dorești să ștergi această comandă?');" class="delete-btn">ștergere</a>
                </form>

            </div>
            <?php
                    }
                }
                else
                {
                    echo '<p class="empty">nu există comenzi plasate încă!</p>';
                }
            ?>
        </div>
        
        
    </section>











<!-- custom admin js fule link-->
<script src="js/admin_script.js"></script>
</body>
</html>