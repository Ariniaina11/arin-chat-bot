<?php
    include_once "submit.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <!-- Add this to your HTML form -->
    <form action="submit.php" method="post">
        <!-- Your form fields go here -->
        <div class="g-recaptcha" data-sitekey="6Lf3gVwpAAAAAPGKhhGKiAx6N3nxggUNcZhHsuXP"></div>
        <input type="submit" name="submit"/>
    </form>

    <!-- Include reCAPTCHA script -->
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
</body>
</html>