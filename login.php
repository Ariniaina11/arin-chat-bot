<?php
    require('utils/autoload.php');

    // L'utilisateur est déjà connecté
    if(isset($_SESSION['user_connected'])) {
        header('location:index.php');
    }

    // Déconnexion
    if(isset($_GET['logout'])){
        unset($_SESSION['user_connected']);
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="assets/styles/login.css">

    <!-- Google recaptcha JS API -->
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>

    <script>
        function onSubmit(token) {
            document.getElementById("myForm").submit();
        }
    </script>
</head>
<body>
    <!-- Popup -->
    <div id="popup">
        <h1 id="popup-text">Text</h1>
        <br>
        <button id="ok-btn">OK</button>
    </div>
    <div class="box">
        <h1>Login</h1>
        <div>
            <input type="text" class="credentials" name="pseudo" id="pseudo" placeholder="Your pseudo"><br>
            <input type="password" class="credentials" name="password" id="password" placeholder="Your password"><br>

             <!-- Google reCAPTCHA -->
             <div class="g-recaptcha" data-sitekey="6Lf3gVwpAAAAAPGKhhGKiAx6N3nxggUNcZhHsuXP"></div>

            <input type="submit" value="CONNEXION" id="connexion" name="connexion">
        </div>
        <p>Not have account yet ? <a href="create.php" class="a-create">Create here</a></p>
    </div>
</body>

<!-- Scripts -->
<script src="assets/scripts/jquery.js"></script>
<script src="assets/scripts/login.js"></script>

</html>