<?php
    // Clé du site : 6LdEcVspAAAAAJHI90sREa0LhLoEHH1H3cr7cUke
    // Clé secrète : 6LdEcVspAAAAAIYINp_UYGF6GR7_cOKLcfAT8Yo1

    // Le secret de l'API Google recaptcha
    $secret_key = "6LdEcVspAAAAAIYINp_UYGF6GR7_cOKLcfAT8Yo1";

    // Email
    $email = "rabesonmamitiana@gmail.com";

    // Valeurs par défaut
    $postData = $valErr = $statutMsg = "";
    $status = "error";

    // Si le form est submité
    if(isset($_POST['submit_frm'])){
        if(isset($_POST['g-recaptcha-response']) && !empty($_POST['g-recaptcha-response'])){
            // captcha verification
            $api_url = "https://www.google.com/recaptcha/api/siteverify";
            $resq_data = array(
                'secret' => $secret_key,
                'response' => $_POST['g-recaptcha-response'],
                'remoteip' => $_SERVER['REMOTE_ADDR']
            );

            $curlConfig = array(
                CURLOPT_URL => $api_url,
                CURLOPT_POST => true,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_POSTFIELDS => $resq_data
            );

            $ch = curl_init();
            curl_setopt_array($ch, $curlConfig);
            $response = curl_exec($ch);
            curl_close($ch);

            $responseData = json_decode($response);

            // captcha validé
            if($responseData->success){
                header("location:/arin-chat-bot");
            }
            else{
                $statutMsg = "La vérification est échouée !";
            }
        }
    }
?>