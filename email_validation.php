<?php

include 'config.php';

if (isset($_POST['verify_code']) && isset($_POST['email'])) {
    $entered_code = mysqli_real_escape_string($conn, $_POST['verification_code']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $check_code = mysqli_query($conn, "SELECT * FROM `users` WHERE email = '$email' AND token_code = '$entered_code'") or die('query failed');

    if (mysqli_num_rows($check_code) == 0) {
        // Codul este corect, poți continua cu autentificarea sau alte acțiuni
        // Setează token_code la NULL sau șterge codul după verificare
        mysqli_query($conn, "UPDATE `users` SET token_code = NULL WHERE email = '$email'");

        // Redirect către pagina principală sau altă pagină dorită
        header('location: home.php');
    } else {
        $message[] = 'Cod de verificare incorect!';
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Conectare</title>

    <!-- Font Awesome link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- Custom CSS file link -->
    <link rel="stylesheet" href="css/style.css">

</head>

<body>

    <?php

    if (isset($message)) {
        foreach ($message as $message)
            echo '<div class="message">
                    <span>' . $message . '</span>
                    <i class="fas fa-times" onclick="this.parentElement.remove();"></i>
                </div>';
    }
    ?>

    <div class="form-container">

        <form action="" method="post">
            <h3>Validare email</h3>

            <input type="hidden" name="email" value="<?php echo isset($_POST['email']) ? $_POST['email'] : ''; ?>">
            <!-- Adaugă un câmp pentru introducerea codului de verificare -->
            <input type="text" name="verification_code" placeholder="Introduceți codul de verificare" required class="box">

            <!-- Adaugă un buton pentru a trimite formularul de verificare -->
            <input type="submit" name="verify_code" value="Verificare cod" class="btn">

            <p>Nu ai un cont? <a href="register.php">Înregistrare</a></p>
        </form>

    </div>

</body>

</html>
