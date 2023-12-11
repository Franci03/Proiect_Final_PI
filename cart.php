<?php

include 'config.php';
session_start();

$user_id = $_SESSION['user_id'];

if(!isset($user_id))
{
    header('location:login.php');
}


if(isset($_POST['update_cart'])){
    $cart_id = $_POST['cart_id'];
    $cart_quantity = $_POST['cart_quantity'];
    mysqli_query($conn, "UPDATE `cart` SET quantity = '$cart_quantity' WHERE id = '$cart_id'") or die('query failed');
    $message[] = 'Cantitate actualizată';
 }
 
 if(isset($_GET['delete'])){
    $delete_id = $_GET['delete'];
    mysqli_query($conn, "DELETE FROM `cart` WHERE id = '$delete_id'") or die('query failed');
    header('location:cart.php');
 }
 
 if(isset($_GET['delete_all'])){
    mysqli_query($conn, "DELETE FROM `cart` WHERE user_id = '$user_id'") or die('query failed');
    header('location:cart.php');
 }

 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>cart</title>

     <!--font awsome link-->
     <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

     <link rel="stylesheet" href="css/style2.css">
</head>
<body>
    <?php include 'header.php'; ?>
    


    <section class="cart-imag">
    </section>

    <h1 class="title" style="margin-top: 60px">Coșul tău de cumpărături</h1>
    <hr class = "line">


<section class="shopping-cart">

   <h1 class="title" style="font-size: 30px; margin-bottom: 20px">Produse</h1>

   <div class="box-container">
      <?php
         $grand_total = 0;
         $select_cart = mysqli_query($conn, "SELECT * FROM `cart` WHERE user_id = '$user_id'") or die('query failed');
         if(mysqli_num_rows($select_cart) > 0){
            while($fetch_cart = mysqli_fetch_assoc($select_cart)){   
      ?>
      <div class="box">
         <a href="cart.php?delete=<?php echo $fetch_cart['id']; ?>" class="fas fa-times" onclick="return confirm('Dorești să ștergi acest articol?');"></a>
         <img src="images/<?php echo $fetch_cart['image']; ?>" alt="">
         <div class="name"><?php echo $fetch_cart['name']; ?></div>
         <div class="price"><?php echo $fetch_cart['price']; ?> RON</div>
         <form action="" method="post">
            <input type="hidden" name="cart_id" value="<?php echo $fetch_cart['id']; ?>">
            <input type="number" min="1" name="cart_quantity" value="<?php echo $fetch_cart['quantity']; ?>">
            <input type="submit" name="update_cart" value="Actualizează" class="option-btn">
         </form>
         <div class="sub-total"> subtotal : <span><?php echo $sub_total = ($fetch_cart['quantity'] * $fetch_cart['price']); ?> RON</span> </div>
      </div>
      <?php
      $grand_total += $sub_total;
         }
      }else{
         echo '<p class="empty">Coșul de cumpărături este gol!</p>';
      }
      ?>
   </div>

   <div style="margin-top: 2rem; text-align:center;">
      <a href="cart.php?delete_all" class="delete-btn <?php echo ($grand_total > 1)?'':'disabled'; ?>" onclick="return confirm('Dorești să ștergi toate articolele?');">Șterge tot</a>
   </div>

   <div class="cart-total">
      <p>Total de plată: <span><?php echo $grand_total; ?> RON</span></p>
      <div class="flex">
         <a href="shop.php" class="option-btn">Continuă cumpărăturile</a>
         <a href="checkout.php" class="btn <?php echo ($grand_total > 1)?'':'disabled'; ?>">Finalizează cumpărăturile</a>
      </div>
   </div>

</section>





    <?php include 'footer.php' ?>
    <script src="js/script.js"></script>
</body>
</html>