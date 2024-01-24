<?php
    include_once "submit.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <!-- Google recaptcha JS API -->
    <script src="https://google.com/recaptcha/api.js"></script>

    <script>
        function onSubmit(token) {
            document.getElementById("myForm").submit();
        }
    </script>
</head>
<body>
    <form id="myForm" method="post" action="">
        <input type="text" name="username" id="username" placeholder="username">
        <input type="mail" name="email" id="email" placeholder="email">

        <input type="hidden" name="submit_frm" value="1">

        <button
            class="g-recaptcha"
            data-sitekey="6LdEcVspAAAAAJHI90sREa0LhLoEHH1H3cr7cUke"
            data-callback="onSubmit"
            data-action="submit"
        >
            Submit
        </button>
    </form>
</body>
</html>