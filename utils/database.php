<?php
    // Session login
    if(!isset($_SESSION['login']))
        $_SESSION['login'] = "_";

    $db_name = 'chat';
    $username = 'root';
    $pass = '';

    // Connexion à la BD
    $connexion = new PDO('mysql:host=localhost;dbname='. $db_name, $username, $pass);
    
    if(!$connexion){
        die('Connection failed : ' . $connexion->connect_error);
    }
?>