<?php
    // Session login
    if(!isset($_SESSION['login']))
        $_SESSION['login'] = "_";

    // Connexion à la BD
    $connexion = new PDO('mysql:host=localhost;dbname=chat', 'root', '');
    
    if(!$connexion){
        die('Connection failed : ' . $connexion->connect_error);
    }
?>