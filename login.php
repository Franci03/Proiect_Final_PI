<?php

include 'config.php';
session_start();

if(isset($_POST['submit']))
{
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $pass = mysqli_real_escape_string($conn, md5($_POST['password']));

    $select_user = mysqli_query($conn, "SELECT * FROM `users` WHERE email = '$email' AND password = '$pass'") or die('query failed');

    if(mysqli_num_rows($select_user) > 0)
    {
        $row = mysqli_fetch_assoc($select_user);

        if($row['user_type'] == 'admin')
        {
            $_SESSION['admin_name'] = $row['name'];
            $_SESSION['admin_email'] = $row['email'];
            $_SESSION['admin_id'] = $row['id'];
            header('location:admin_page.php');
        }

        elseif($row['user_type'] == 'user')
        {
            $_SESSION['user_name'] = $row['name'];
            $_SESSION['user_email'] = $row['email'];
            $_SESSION['user_id'] = $row['id'];
            header('location:home.php');
        }
        
    }
    else
    {
        $message[] = 'email sau parolă incorectă!';
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Conectare</title>

    <!--font awsome link-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- custom css file link -->
    <link rel = "stylesheet" href = "css/style.css">


</head>
<body>

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

    <div class = "form-container">
        
        <form action="" method = "post">
            <h3>Conectare</h3>
            <input type="email" name = "email" placeholder = "introduceți email-ul" required class = "box">
            <input type="password" name = "password" placeholder = "introduceți parola" required class = "box">
  
            <input type="submit" name = "submit" value = "conectare" class = "btn">
            <p>Nu ai cont? <a href = "register.php">Înregistrează-te</a></p>

        </form>

    </div>
    
</body>
</html>