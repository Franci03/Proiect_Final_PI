<?php

include 'config.php';
session_start();

$user_id = $_SESSION['user_id'];

if(!isset($user_id))
{
    header('location:login.php');
}

if(isset($_POST['send'])){

    /*$name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);*/
    $name = $_SESSION['user_name'];
    $email = $_SESSION['user_email'];
    $number = $_POST['number'];
    $msg = mysqli_real_escape_string($conn, $_POST['message']);
 
    $select_message = mysqli_query($conn, "SELECT * FROM `message` WHERE name = '$name' AND email = '$email' AND number = '$number' AND message = '$msg'") or die('query failed');
 
    if(mysqli_num_rows($select_message) > 0){
       $message[] = 'mesajul a fost trimis deja!';
    }else{
       mysqli_query($conn, "INSERT INTO `message`(user_id, name, email, number, message) VALUES('$user_id', '$name', '$email', '$number', '$msg')") or die('query failed');
       $message[] = 'mesaj trimis cu succes!';
    }
 
 }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>contact</title>

     <!--font awsome link-->
     <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

     <link rel="stylesheet" href="css/style2.css">
</head>
<body>
    <?php include 'header.php'; ?>


    <section class="contact-imag"></section>





 <h1 class="title" style="margin-top: 80px">Detalii de contact</h1>
        <br>
        <hr class = "line">

        <br>
        <br>
        <br>

        <div class="detalii-contact">
            <h2 style="color: rgb(9, 11, 86); font-size: 2.5rem">Contactează-ne</h2>

            <div class="continut-contact">
                <div class="text">
                    <p>Locație:</p>
                    <div class="info">
                        Universitatea de Vest Timișoara,
                        
                    </div>
                    <div class="info">
                        Bd. Vasile Pârvan, nr. 4
                        
                    </div>
                </div>

                <div class="text">
                    <p>Telefon:</p>
                    <div class="info">
                        0256 592 111
                    </div>
                </div>

                <div class="text">
                    <p>Mail:</p>
                    <div class="info">
                        <a href="mailto:andreea.stanescu03@e-uvt.ro"> bibliophileboutique@gmail.com</a>
                    </div>
                </div>

            </div>
        </div>





        <div class="harta"><iframe src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d11136.803345262573!2d21.2316152!3d45.7471195!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x47455d84610655bf%3A0xfd169ff24d29f192!2sUniversitatea%20de%20Vest%20din%20Timi%C8%99oara!5e0!3m2!1sro!2sro!4v1685906272664!5m2!1sro!2sro" width="500" height="320" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe></div>
    
    <br>
    <br>
    <br>
    <hr class = "line">
    <br>
    <br>
    <br>
    <br>




<section class="contact">

   <form action="" method="post">
      <h3>Contactează-ne!</h3>
      <!--<input type="text" name="name" required placeholder="introduceți numele" class="box">
      <input type="email" name="email" required placeholder="introduceți email-ul" class="box">-->
      <input type="number" name="number" required placeholder="introduceți nr de telefon" class="box">
      <textarea name="message" class="box" placeholder="Mesajul dvs." id="" cols="30" rows="10"></textarea>
      <input type="submit" value="Trimite" name="send" class="btn">
   </form>

</section>








    <?php include 'footer.php' ?>
    <script src="js/script.js"></script>
</body>
</html>