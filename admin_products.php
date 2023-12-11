<?php

include 'config.php';
session_start();

$admin_id = $_SESSION['admin_id'];

if(!isset($admin_id))
{
    header('location:login.php');
};

if(isset($_POST['add_product'])){

    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $price = $_POST['price'];
    $stock = $_POST['stock'];
    $image = $_FILES['image']['name'];
    $image_size = $_FILES['image']['size'];
    $image_tmp_name = $_FILES['image']['tmp_name'];
    $image_folder = 'images/'.$image;

    $select_product_name = mysqli_query($conn, "SELECT name FROM `products` WHERE name = '$name'" ) or die('query failed');


    if(mysqli_num_rows($select_product_name) > 0 )
    {
        $message[] = 'produs existent';
    }
    else
    {
        $add_product_query = mysqli_query($conn, "INSERT INTO `products` (name, price, image, stock) VALUES('$name', '$price', '$image', '$stock' )") or die('query failed');
        
        if($add_product_query)
        {
            if($image_size > 2000000)
            {
                $message[] = 'imaginea are dimensiunea prea mare';
            }
            else
            {
                move_uploaded_file($image_tmp_name, $image_folder);
                $message[] = 'produs adăugat cu succes!';
            }
        }
        else
        {
            $message[] = 'nu s-a adăudat produsul!';
        }
    }

}

if(isset($_GET['delete']))
{
    $delete_id = $_GET['delete'];
    $delete_image_query = mysqli_query($conn, "SELECT image FROM `products` WHERE id = '$delete_id'" ) or die('query failed');
    $fetch_delete_image = mysqli_fetch_assoc($delete_image_query);
    unlink('images/'.$fetch_delete_image['image']);
    mysqli_query($conn, "DELETE FROM `products` WHERE id = '$delete_id' ") or die('query failed');
    header('location:admin_products.php');
}

if(isset($_POST['update_product']))
{
    $update_p_id = $_POST['update_p_id'];
    $update_name = $_POST['update_name'];
    $update_price = $_POST['update_price'];
    $update_stock = $_POST['update_stock'];

    mysqli_query($conn, "UPDATE `products` SET name = '$update_name', price = '$update_price', stock = '$update_stock' WHERE id = '$update_p_id'" ) or die('query failed');

    $update_image= $_FILES['update_image']['name'];
    $update_image_tmp_name= $_FILES['update_image']['tmp_name'];
    $update_image_size= $_FILES['update_image']['size'];
    $update_folder= 'images'.$update_image;
    $update_old_image = $_POST['update_old_image'];

    if(!empty($update_image))
    {
        if($update_image_size > 2000000)
        {
            $message[] = 'dimensiunea imaginii este prea mare';
        }
        else
        {
            mysqli_query($conn, "UPDATE `products` SET image = '$update_image' WHERE id = '$update_p_id'") or die('query failed');
            move_uploaded_file($update_image_tmp_name, $update_folder);
            unlink('images/'.$update_old_image);

        }
    }
    header('location:admin_products.php');
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>products</title>

     <!--font awsome link-->
     <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

     <!--custom admin css link-->
     <link rel="stylesheet" href="css/admin_style.css">

</head>
<body>
    <?php
     include 'admin_header.php';
    ?>

    <section class="add-products">

        <h2 class="denumire">~bliophile boutique~</h2>
        <h1 class="title">Produse</h1>
        
        <form action="" method="POST" enctype="multipart/form-data">
            <h3>Adăugare produs</h3>
            <input type="text" name="name" class="box" placeholder="introduceți numele produsului" required>
            <input type="number" min="0" name="price" class="box" placeholder="introduceți prețul produsului" required>
            <input type="number" min="0" name="stock" class="box" placeholder="introduceți cantitatea" required>
            <input type="file"  name="image" accept="image/jpg, image/png, image/jpeg" class="box" required>
            <input type="submit" value="adaugă" name="add_product" class="btn">
        </form>
    </section>

<!-- afisare produse-->
<section class="show-products">

    <div class="box-container">

        <?php
            $select_products = mysqli_query($conn, "SELECT * FROM `products` ") or die('query failed');
            if(mysqli_num_rows($select_products) > 0)
            {
                while($fetch_products = mysqli_fetch_assoc($select_products))
                {    
        ?>
        <div class="box">
            <img src="images/<?php echo $fetch_products['image'];?>" alt="">

            <div class="name"><?php echo $fetch_products['name'];?></div>
            <div class="price"><?php echo $fetch_products['price'];?> RON</div>
            <div class="stock" 
                style = "position: relative;
                        margin-bottom: 1rem;
                        margin-right: 15px;
                        width: 10px
                        left: 1rem;
                        border-radius: .5rem;
                        font-size: 2rem;
                        color: #ccc;
                        background-color: #19376D;" >
                        <?php echo $fetch_products['stock']; ?> buc
            </div>
            <a href="admin_products.php?update=<?php echo $fetch_products['id'];?>" class="option-btn">actualizare</a>
            <a href="admin_products.php?delete=<?php echo $fetch_products['id'];?>" class="delete-btn" onclick="return confirm('dorești să ștergi acest produs?');">ștergere</a>

            
        </div>

        <?php
            }
        }
            else
            {
                echo '<p class="empty">niciun produs adăugat încă!</p>';
            }
        ?>
    </div>

</section>

<section class="edit-product-form">

   <?php
      if(isset($_GET['update'])){
         $update_id = $_GET['update'];
         $update_query = mysqli_query($conn, "SELECT * FROM `products` WHERE id = '$update_id'") or die('query failed');
         if(mysqli_num_rows($update_query) > 0){
            while($fetch_update = mysqli_fetch_assoc($update_query)){
   ?>
   <form action="" method="post" enctype="multipart/form-data">
      <input type="hidden" name="update_p_id" value="<?php echo $fetch_update['id']; ?>">
      <input type="hidden" name="update_old_image" value="<?php echo $fetch_update['image']; ?>">
      <img src="images/<?php echo $fetch_update['image']; ?>" alt="">
      <input type="text" name="update_name" value="<?php echo $fetch_update['name']; ?>" class="box" required placeholder="introduceți numele produsului">
      <input type="number" name="update_price" value="<?php echo $fetch_update['price']; ?>" min="0" class="box" required placeholder="introduceți prețul produsului">
      <input type="number" name="update_stock" value="<?php echo $fetch_update['stock']; ?>" min="0" class="box" required placeholder="introduceți cantitatea">
      <input type="file" class="box" name="update_image" accept="image/jpg, image/jpeg, image/png">
      <input type="submit" value="update" name="update_product" class="btn">
      <input type="reset" value="cancel" id="close-update" class="option-btn">
   </form>
   <?php
         }
      }
      }else{
         echo '<script>document.querySelector(".edit-product-form").style.display = "none";</script>';
      }
   ?>

</section>







<!-- custom admin js file link-->
<script src="js/admin_script.js"></script>
</body>
</html>