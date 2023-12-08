<?php
    require('../autoload.php');

    // CREATION DU COMPTE
    if(isset($_POST['creation'])){
        $pseudo = $_POST['pseudo'];
        $pass = $_POST['password'];
        $conf_pass = $_POST['conf_password'];

        $data = [
            'pseudo' => $pseudo,
            'password' => $pass,
            'conf_password' => $conf_pass
        ];

        // Nombre d'utilisateur portant ce pseudo
        $checking = checkingPseudo($pseudo, $connexion);

        if($checking > 0){
            echo 'pseudo_err';
        }
        else if($pass != $conf_pass){
            echo 'conf_pass_err';
        } 
        else {
            $user = new user($pseudo, $pass);
            insertData($user, $connexion);

            echo "success";
        }


        // header('location: ../../login.php');
    }
    else{
        header('location: ../../create.php');
    }


    // ------------------------------- FONCTIONS -------------------------------
    
    // Vérifier le pseudo
    function checkingPseudo($pseudo, $connexion){
        // Préparer la requête
        $stmt = $connexion->prepare('SELECT * FROM users WHERE pseudo = ?');

        // Binding 
        $stmt->bindParam(1, $pseudo);

        // Execution
        $stmt->execute();

        // Prendre les résultats
        $results = $stmt->fetchAll();

        // Retourner le nombre de résultat avec ce pseudo
        return count($results);
    }

    // Insérer dans la BD
    function insertData($user, $connexion){
        // Préparer la requête
        $stmt = $connexion->prepare('INSERT INTO users (pseudo, pass) VALUES (?, ?)');

        // Binding 
        $stmt->bindParam(1, $user->getPseudo());
        $stmt->bindParam(2, $user->getPassword());

        // Exécuter la requête
        $stmt->execute();
    }
?>