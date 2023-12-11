<?php

include 'config.php';
session_start();

$user_id = $_SESSION['user_id'];

if(!isset($user_id))
{
    header('location:login.php');
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

     <link rel="stylesheet" href="css/style2.css">
</head>
<body>
    <?php include 'header.php'; ?>
    

    <section class="cart-imag">
    </section>

<section class="placed-orders">

   <h1 class="title" style="margin-top: 80px">Istoric comenzi</h1>

   <br>
        <hr class = "line">

        <br>
        <br>
        <br>

   <div class="box-container">

      <?php
         $order_query = mysqli_query($conn, "SELECT * FROM `orders` WHERE user_id = '$user_id'") or die('query failed');
         if(mysqli_num_rows($order_query) > 0){
            while($fetch_orders = mysqli_fetch_assoc($order_query)){
      ?>
      <div class="box">
         <p> plasată la: <span><?php echo $fetch_orders['placed_on']; ?></span> </p>
         <p> nume: <span><?php echo $fetch_orders['name']; ?></span> </p>
         <p> nr. tel: <span><?php echo $fetch_orders['number']; ?></span> </p>
         <p> email: <span><?php echo $fetch_orders['email']; ?></span> </p>
         <p> adresă: <span><?php echo $fetch_orders['address']; ?></span> </p>
         <p> metodă plată: <span><?php echo $fetch_orders['method']; ?></span> </p>
         <p> produse: <span><?php echo $fetch_orders['total_products']; ?></span> </p>
         <p> preț comandă: <span><?php echo $fetch_orders['total_price']; ?> RON</span> </p>
         <p> status plată: <span style="color:<?php if($fetch_orders['payment_status'] == 'pending'){ echo 'red'; }else{ echo 'green'; } ?>;"><?php echo $fetch_orders['payment_status']; ?></span> </p>
         </div>
      <?php
       }
      }else{
         echo '<p class="empty" style="margin-left:36%" >Nicio comandă plasată!</p>';
      }
      ?>
   </div>

</section>












    <?php include 'footer.php' ?>
    <script src="js/script.js"></script>
</body>
</html>