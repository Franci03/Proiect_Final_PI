<?php

include 'config.php';
session_start();

$user_id = $_SESSION['user_id'];

if(!isset($user_id))
{
    header('location:login.php');
};

if(isset($_POST['add_to_cart'])) {
   $product_name = $_POST['product_name'];
   $product_price = $_POST['product_price'];
   $product_image = $_POST['product_image'];
   $product_quantity = $_POST['product_quantity'];

   // Verifică dacă cantitatea este mai mică sau egală cu stocul disponibil
   $check_cart_numbers = mysqli_query($conn, "SELECT * FROM `cart` WHERE name = '$product_name' AND user_id = '$user_id'") or die('query failed');
   
   if ($fetch_products = mysqli_fetch_assoc($check_cart_numbers)) {
       // Produsul există în coș
       $existing_quantity = $fetch_products['quantity'];
       
       // Verifică dacă adăugarea cantității depășește stocul disponibil
       if (($existing_quantity + $product_quantity) > $fetch_products['stock']) {
           $message[] = 'Stocul insuficient!';
       } else {
           // Actualizează cantitatea în coș
           mysqli_query($conn, "UPDATE `cart` SET quantity = quantity + '$product_quantity' WHERE name = '$product_name' AND user_id = '$user_id'") or die('query failed');
           $message[] = 'Cantitate actualizată în coș';
       }
   } else {
       // Produsul nu există în coș
       // Verifică dacă cantitatea depășește stocul disponibil

       $check_product_stock = mysqli_query($conn, "SELECT stock FROM `products` WHERE name = '$product_name'") or die('query failed');
       $fetch_product_stock = mysqli_fetch_assoc($check_product_stock);
   
       if ($product_quantity > $fetch_product_stock['stock']) {
           $message[] = 'Stocul insuficient!';
       } else {
           // Adaugă produsul în coș
           mysqli_query($conn, "INSERT INTO `cart`(user_id, name, price, quantity, image) VALUES('$user_id', '$product_name', '$product_price', '$product_quantity', '$product_image')") or die('query failed');
           $message[] = 'Produs adăugat în coș';
       }
   }
}

 

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>search</title>

     <!--font awsome link-->
     <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

     <link rel="stylesheet" href="css/style2.css">
</head>
<body>
    <?php include 'header.php'; ?>

    <section class="contact-imag"></section>

    <h1 class="title" style="margin-top: 80px">Pagină de căutare</h1>
        <br>
        <hr class = "line">

        <br>
        <br>
        <br>


<section class="search-form">
   <form action="" method="post">
      <input type="text" name="search" placeholder="caută produse..." class="box">
      <input type="submit" name="submit" value="caută" class="btn">
   </form>
</section>

<section class="products" style="padding-top: 0;">

   <div class="box-container">
   <?php
      if(isset($_POST['submit'])){
         $search_item = $_POST['search'];
         $select_products = mysqli_query($conn, "SELECT * FROM `products` WHERE name LIKE '%{$search_item}%'") or die('query failed');
         if(mysqli_num_rows($select_products) > 0){
         while($fetch_product = mysqli_fetch_assoc($select_products)){
   ?>
   <form action="" method="post" class="box">
      <img src="images/<?php echo $fetch_product['image']; ?>" alt="" class="image">
      <div class="name"><?php echo $fetch_product['name']; ?></div>
      <div class="price"><?php echo $fetch_product['price']; ?> RON</div>
      <input type="number"  class="qty" name="product_quantity" min="1" value="1">
      <input type="hidden" name="product_name" value="<?php echo $fetch_product['name']; ?>">
      <input type="hidden" name="product_price" value="<?php echo $fetch_product['price']; ?>">
      <input type="hidden" name="product_image" value="<?php echo $fetch_product['image']; ?>">
      <input type="submit" class="btn" value="Adaugă în coș" name="add_to_cart">
   </form>
   <?php
            }
         }else{
            echo '<p class="empty">Nu există rezultate!</p>';
         }
      }else{
         echo '<p class="empty">Caută ce dorești!</p>';
      }
   ?>
   </div>
  

</section>









    <?php include 'footer.php' ?>
    <script src="js/script.js"></script>
</body>
</html>