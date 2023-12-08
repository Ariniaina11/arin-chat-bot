<?php

if(isset($_POST['audio'])){
    // Le texte
    $txt = $_POST['text'];
    $txt = htmlspecialchars($txt);
    $txt = rawurlencode($txt); // 'Hi friend' to 'Hi%20friend'

    // API
    // https://translate.google.com/translate_tts?ie=UTF-8&client=gtx&q=' . $txt . '&tl=en-IN
    $url = file_get_contents('https://translate.google.com/translate_tts?ie=UTF-8&client=gtx&q=' . $txt . '&tl=fr-FR');
    
    echo "<audio controls='controls' autoplay>" +
            "<source src='data:audio/mpeg;base64,". base64_encode($url) . ">" +
        "</audio>";
}