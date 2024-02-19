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
            $withoutSpace = trim($pseudo);

            if(strlen($withoutSpace) == 0){
                echo 'empty';
            }
            else{
                $user = new User($pseudo, md5($pass));
                insertData($user, $connexion);

                //

                // L'utilisateur qui vient de créer son compte
                $userId = $connexion->lastInsertId();

                $message = new Message();
                $message->setContent("Hello <!-- REPLACE --><strong class='mypseudo'>". $pseudo . "</strong><!-- REPLACE --> ! Welcome to Arin-Bot, how can I help you ? &#128516;");
                $message->setReceiverId($userId);

                insertDefaultMsg($message, $connexion);
    
                echo "success";
            }
        }
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

    // Insérer l'utilisateur dans la BD
    function insertData($user, $connexion){
        // Préparer la requête
        $stmt = $connexion->prepare('INSERT INTO users (pseudo, pass) VALUES (:pseudo, :pass)');

        //
        $pseudo = $user->getPseudo();
        $pass = $user->getPassword();

        // Binding 
        $stmt->bindParam('pseudo', $pseudo);
        $stmt->bindParam('pass', $pass);

        // Exécuter la requête
        $stmt->execute();
    }

    // Insérer un message pour le compte nouveau créé
    function insertDefaultMsg($message, $connexion){
        // Préparer la requête
        $stmt = $connexion->prepare(
            'INSERT INTO messages (content, receiver_id, user_id) VALUES (:content, :receiver_id, :user_id)'
        );

        // 
        $content = $message->getContent();
        $receiver_id = $message->getReceiverId();
        $user_id = $message->getUserId();

        // Binding 
        $stmt->bindParam('content', $content); 
        $stmt->bindParam('receiver_id', $receiver_id);
        $stmt->bindParam('user_id', $user_id);

        // Exécuter la requête
        $stmt->execute();
    }
?>