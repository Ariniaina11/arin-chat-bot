<?php
    require('../utils/autoload.php');

    use LanguageDetection\Language;

    $ld = new Language;
 
    $result = $ld->detect('Salut ! Comment tu te sens ce matin ?');

    echo $result;
?>