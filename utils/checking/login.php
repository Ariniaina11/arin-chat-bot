<?php
    require '../autoload.php';

    if(isset($_POST['connexion'])){
        $pseudo = $_POST['pseudo'];
        $pass = $_POST['password'];

        $data = [
            'pseudo' => $pseudo,
            'password' => $pass
        ];

        $checking = checkingData($data, $connexion);

        if($checking['checking']) {
            $_SESSION['user_connected'] = $checking['user_id'];

            echo "success";
        }
        else{
            echo "failed";
        }
    }
    else{
        header('location : ../../login.php');
    }

    // Vérifier les données
    function checkingData($data, $connexion){
        $checking_ok = false;

        // Préparer la requête
        $stmt = $connexion->prepare('SELECT * FROM users WHERE pseudo = ? AND pass = ?');

        // Binding
        $stmt->bindParam(1, $data['pseudo']);
        $stmt->bindParam(2, $data['password']);

        // Execution
        $stmt->execute();

        // Prendre le résultat
        $user = $stmt->fetch();

        if($user){
            $checking_ok = true;
        }

        return [ 
            'checking' => $checking_ok,
            'user_id' => $user['id']
        ];
    }

?>