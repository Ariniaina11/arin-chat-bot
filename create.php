<?php
    require("utils/autoload.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Creation</title>
    <link rel="shortcut icon" href="assets/images/arin-bot.ico" type="image/x-icon">
    <link rel="stylesheet" href="assets/styles/create.css">

    <!-- Google recaptcha JS API -->
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
</head>
<body>
    <!-- Popup -->
    <div id="popup">
        <h1 id="popup-text">Text</h1>
        <br>
        <button id="ok-btn">OK</button>
        <button id="ok-success-btn">OK</button>
    </div>

    <div class="box">
        <h1>Creation</h1>
        <div>
            <input type="text" class="credentials" name="pseudo" id="pseudo" placeholder="Your pseudo"><br>
            <input type="password" class="credentials" name="password" id="password" placeholder="Your password"><br>
            <input type="password" class="credentials" name="conf_password" id="conf_password" placeholder="Confirm password"><br>

            <!-- Google reCAPTCHA -->
            <div class="g-recaptcha" data-sitekey="<?= API::$CAPTCHA_SITE_KEY ?>"></div>

            <input type="submit" value="CREATE ACCOUNT" name="creation" id="creation">
        </div>
        <p>Already have an account ? <a href="login.php" class="a-login">Login now</a></p>
    </div>
</body>

<!-- Scripts -->
<script src="assets/scripts/jquery.js"></script>
<script src="assets/scripts/create.js"></script>

</html>