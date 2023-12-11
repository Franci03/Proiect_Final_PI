<?php

include 'config.php';
session_start();

$admin_id = $_SESSION['admin_id'];

if(!isset($admin_id))
{
    header('location:login.php');
}

if(isset($_GET['delete'])){
    $delete_id = $_GET['delete'];
    mysqli_query($conn, "DELETE FROM `message` WHERE id = '$delete_id'") or die('query failed');
    header('location:admin_contacts.php');
 }
 

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>messages</title>

     <!--font awsome link-->
     <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

     <!--custom admin css link-->
     <link rel="stylesheet" href="css/admin_style.css">

</head>
<body>
    <?php
     include 'admin_header.php';
    ?>

<section class="messages">
<h2>~bliophile boutique~</h2>
<h1 class="title"> mesaje </h1>

<div class="box-container">
<?php
   $select_message = mysqli_query($conn, "SELECT * FROM `message`") or die('query failed');
   if(mysqli_num_rows($select_message) > 0){
      while($fetch_message = mysqli_fetch_assoc($select_message)){
   
?>
<div class="box">
   <p> id utilizator : <span><?php echo $fetch_message['user_id']; ?></span> </p>
   <p> nume: <span><?php echo $fetch_message['name']; ?></span> </p>
   <p> număr tel: <span><?php echo $fetch_message['number']; ?></span> </p>
   <p> email: <span style="display: block;
            overflow: hidden;
            white-space: nowrap;
            text-overflow: ellipsis;
            max-width: 100%; "><?php echo $fetch_message['email']; ?></span> </p>
   <p> mesaj: <span><?php echo $fetch_message['message']; ?></span> </p>
   <a href="admin_contacts.php?delete=<?php echo $fetch_message['id']; ?>" onclick="return confirm('ștergi acest mesaj?');" class="delete-btn">delete message</a>
</div>
<?php
   };
}else{
   echo '<p class="empty">nu exista mesaje!</p>';
}
?>
</div>

</section>











<!-- custom admin js fule link-->
<script src="js/admin_script.js"></script>
</body>
</html>