<?php
    // Clé du site : 6Lf3gVwpAAAAAPGKhhGKiAx6N3nxggUNcZhHsuXP
    // Clé secrète : 6Lf3gVwpAAAAANa0EzgvBfBEKIA1P7piHaaESOq3

    if(isset($_POST['submit'])){ 
        // Validate reCAPTCHA
        $recaptcha_secret = '6Lf3gVwpAAAAANa0EzgvBfBEKIA1P7piHaaESOq3'; // Replace with your Secret Key
        $response = $_POST['g-recaptcha-response'];

        $verify = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret={$recaptcha_secret}&response={$response}");
        $captcha_data = json_decode($verify);

        if ($captcha_data->success) {
            // reCAPTCHA verification passed
            // Continue with your form processing
            echo "Gooo";
        } else {
            // reCAPTCHA verification failed
            // Handle the error accordingly
            echo "reCAPTCHA verification failed.";
        }
    } 
?>