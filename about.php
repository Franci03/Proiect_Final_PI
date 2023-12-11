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
    <title>about</title>

     <!--font awsome link-->
     <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

     <link rel="stylesheet" href="css/style2.css">
</head>
<body>
    <?php include 'header.php'; ?>
    
    <section class="contact-imag"></section>

    <h1 class="title" style="margin-top: 80px">~<span style="color: #c70039">B</span>ibliophile <span style="color: #c70039">B</span>outique~</h1>
    <h1 class="title" style="tex-transform: lowercase">Despre noi</h1>
        <br>
        <hr class = "line">

        <br>
        <br>
        <br>



  

        <center><div class="descriere" style="text-align: center">
            
            
            <p>Bibliophile Boutique este mai mult decât un magazin online
                 - este o oază virtuală pentru iubitorii de cărți, 
                 unde pasiunea pentru literatură se îmbină armonios 
                 cu dorința de a crea o experiență memorabilă. 
                 Cu inima plină de devotament față de minunatul 
                 univers al cărților, ne propunem să aducem bucuria 
                 lecturii direct în casele iubitorilor de literatură din 
                 întreaga lume.</p> 

            <br>
            <p>Bun venit la Bibliophile Boutique,
            destinatia ta preferată pentru explorarea fascinantă a
            lumii cărților! </p>
        </div></center>

        <br>
        <br>
        <br>
        <br>

        <div class="citate" style="display: flex;justify-content: space-between;">
            <div class="descriere" style="width: 33%; margin-left: 14%; text-align: center; height: 280px">
                <p>"Când citim, trăim mii de vieți înainte să murim. Persoana care nu citește trăiește doar o singură viață."  </p>
                <p >~George R.R. Martin~</p>
            </div>
            <div class="descriere" style="width: 33%; margin-right: 14%;text-align: center;height: 280px">
                <p>„Știi că ai citit o carte bună atunci când întorci ultima pagină și te simți ca și cum ai fi pierdut un prieten.”</p>
                <p>~Paul Sweeney~</p>
            </div>
        </div>

        <br>
        <hr class = "line" style="margin-top: 80px">

        <br>
        <br>
        <br>


        <section class="home-contact" style="backgroumd-color: #576CBC">

            <div class="content">
            <h3>Ai întrebări?</h3>
            <p>Cum am putea îmbunătăți platforma noastră? </p>
            <p>Opinia ta este importantă pentru noi!</p>
            <a href="contact.php" class="white-btn">Contactează-ne</a>
            </div>

        </section>




    <?php include 'footer.php' ?>
    <script src="js/script.js"></script>
</body>
</html>