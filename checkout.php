<?php

include 'config.php';
session_start();

$user_id = $_SESSION['user_id'];

if(!isset($user_id))
{
    header('location:login.php');
}


if(isset($_POST['order_btn'])){

    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $number = $_POST['number'];
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $method = mysqli_real_escape_string($conn, $_POST['method']);
    $address = mysqli_real_escape_string($conn, 'nr. '. $_POST['flat'].', '. $_POST['street'].', '. $_POST['city'].', '. $_POST['country'].' - '. $_POST['pin_code']);
    $placed_on = date('d-M-Y');
 
    $cart_total = 0;
    $cart_products[] = '';
 
    $cart_query = mysqli_query($conn, "SELECT * FROM `cart` WHERE user_id = '$user_id'") or die('query failed');
    if(mysqli_num_rows($cart_query) > 0){
       while($cart_item = mysqli_fetch_assoc($cart_query)){
          $cart_products[] = $cart_item['name'].' ('.$cart_item['quantity'].') ';
          $sub_total = ($cart_item['price'] * $cart_item['quantity']);
          $cart_total += $sub_total;
       }
    }
 
    $total_products = implode(', ',$cart_products);
 
    $order_query = mysqli_query($conn, "SELECT * FROM `orders` WHERE name = '$name' AND number = '$number' AND email = '$email' AND method = '$method' AND address = '$address' AND total_products = '$total_products' AND total_price = '$cart_total'") or die('query failed');
 
    if($cart_total == 0){
       $message[] = 'Coșul de cumpărături este gol';
    }else{
       if(mysqli_num_rows($order_query) > 0){
          $message[] = 'Comanda a fost plasată deja!'; 
       }else{
          mysqli_query($conn, "INSERT INTO `orders`(user_id, name, number, email, method, address, total_products, total_price, placed_on) VALUES('$user_id', '$name', '$number', '$email', '$method', '$address', '$total_products', '$cart_total', '$placed_on')") or die('query failed');

          /*scadem stocul pt fiecare produs cumparat*/
          $cart_query = mysqli_query($conn, "SELECT * FROM `cart` WHERE user_id = '$user_id'") or die('query failed');
          while ($cart_item = mysqli_fetch_assoc($cart_query)) {
            $product_name = mysqli_real_escape_string($conn, $cart_item['name']);
            $quantity = $cart_item['quantity'];
        
            /*echo "Product Name: $product_name, Quantity: $quantity<br>";*/
        
            
            $update_query = "UPDATE `products` SET stock = stock - '$quantity' WHERE name = '$product_name'";
            /*echo "Update Query: $update_query<br>";*/
        
            // Execute the update query
            mysqli_query($conn, $update_query) or die('query failed');
        }
          $message[] = 'Comandă plasată cu succes!';
          mysqli_query($conn, "DELETE FROM `cart` WHERE user_id = '$user_id'") or die('query failed');
       }
    }
    
 }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>checkout</title>

     <!--font awsome link-->
     <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

     <link rel="stylesheet" href="css/style2.css">
</head>
<body>
    <?php include 'header.php'; ?>
    
    <section class="contact-imag"></section>

    <section class="display-order">

   <?php  
      $grand_total = 0;
      $select_cart = mysqli_query($conn, "SELECT * FROM `cart` WHERE user_id = '$user_id'") or die('query failed');
      if(mysqli_num_rows($select_cart) > 0){
         while($fetch_cart = mysqli_fetch_assoc($select_cart)){
            $total_price = ($fetch_cart['price'] * $fetch_cart['quantity']);
            $grand_total += $total_price;
   ?>
   <p> <?php echo $fetch_cart['name']; ?> <span>(<?php echo $fetch_cart['price'].' RON'.' x '. $fetch_cart['quantity']; ?>)</span> </p>
   <?php
      }
   }else{
      echo '<p class="empty">coșul este gol!</p>';
   }
   ?>
   <div class="grand-total"> Total : <span><?php echo $grand_total; ?> RON</span> </div>

</section>


<section class="checkout">

   <form action="" method="post">
      <h3>Plasează comanda</h3>
      <div class="flex">
         <div class="inputBox">
            <span>Numele:</span>
            <input type="text" name="name" required placeholder="introduceți numele">
         </div>
         <div class="inputBox">
            <span>Nr. telefon:</span>
            <input type="number" name="number" required placeholder="introduceți nr. de tel">
         </div>
         <div class="inputBox">
            <span>Email:</span>
            <input type="email" name="email" required placeholder="introduceti adresa de mail">
         </div>
         <div class="inputBox">
            <span>Metodă de plată:</span>
            <select name="method">
               <option value="ramburs curier">ramburs curier</option>
               <option value="ridicare personală">ridicare personală</option>
            </select>
         </div>
         <div class="inputBox">
            <span>Adresă:</span>
            <input type="number" min="0" name="flat" required placeholder="ex. nr. apartament">
         </div>
         <div class="inputBox">
            <span>Strada:</span>
            <input type="text" name="street" required placeholder="ex. strada">
         </div>
         <div class="inputBox">
            <span>Oraș:</span>
            <input type="text" name="city" required placeholder="ex. Timișoara">
         </div>
         <div class="inputBox">
            <span>Județ:</span>
            <input type="text" name="state" required placeholder="ex. Timiș">
         </div>
         <div class="inputBox">
            <span>Țara:</span>
            <input type="text" name="country" required placeholder="ex. România">
         </div>
         <div class="inputBox">
            <span>Cod poștal:</span>
            <input type="number" min="0" name="pin_code" required placeholder="ex. 300223">
         </div>
      </div>
     <center> <input type="submit" value="Comandă acum" class="btn" name="order_btn" style="margin-top: 25px"></center>
   </form>

</section>









    <?php include 'footer.php' ?>
    <script src="js/script.js"></script>
</body>
</html>