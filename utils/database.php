<?php
    // Session login
    if(!isset($_SESSION['login']))
        $_SESSION['login'] = "_";

    $db_name = 'DB_NAME';
    $username = 'DB_USERNAME';
    $pass = 'USER_PASSWORD';

    // Connexion à la BD
    $connexion = new PDO('mysql:host=localhost;dbname='. $db_name, $username, $pass);
    
    if(!$connexion){
        die('Connection failed : ' . $connexion->connect_error);
    }
?>