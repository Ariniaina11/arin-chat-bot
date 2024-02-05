<?php
    require('../autoload.php');

    use LanguageDetection\Language;

    $user_connected = $_SESSION['user_connected'];

    if(isset($_POST['msg'])){
        // Donnée réçue du POST
        $content = $_POST['msg'];

        // Message du client
        $message = new Message();
        $message->setUserId($user_connected);
        $message->setContent($content);

        insertMessage($message, $connexion);

        try{
            // Message du bot
            $res = callPawanAPI($content);
            $data = json_decode($res, true);
            $msg = formatJsonData($data)['msg'];
        }
        catch(Exception $e){
            $msg = "";
        }

        if($msg != ""){
            $message = new Message();
            $message->setReceiverId($user_connected);
            $message->setContent($msg);

            insertMessage($message, $connexion);
        }
        
        // Fermer la connexion
        $connexion = null;
        
        // Les données de la réponse
        $data = array(
            "response" => formatText($msg),
            "lang" => detectLang($msg)
        );

        // Contenu de la réponse en format "json"
        header("Content-Type: application/json");

        // Encoder l'array en tant que json et afficher
        echo json_encode($data);
    }

    // ================================== FONCTIONS ==================================

    // Appel de l'API de Pawan.Krd
    function callPawanAPI($msg){
        $data = array(
            'model' => 'pai-001-light-beta',
            'messages' => [
                [
                'role' => 'user',
                'content' => $msg
                ]
            ]
        );

        $headers = array(
            'Authorization: Bearer ' . API::$OPENAI_KEY,
            'Content-Type: application/json'
        );

        $json = json_encode($data);

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, 'https://api.pawan.krd/v1/chat/completions');
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $json);

        $response = curl_exec($curl);
        curl_close($curl);

        return $response;
    }

    
    // FOrmatter la réponse de l'API
    function formatJsonData($data){
        $formattedData = array(
            'msg' => isset($data) && is_array($data) && isset($data['choices']) ? $data['choices'][0]['message']['content'] : ''
        );

        return $formattedData;
    }

    // Formattage du texte
    function formatText($msg){
        // Pattern to match code snippets
        $pattern = '/```([a-zA-Z0-9_]+)\s*([\s\S]+?)```/';

        // Perform the replacement using preg_replace_callback
        $formattedText = preg_replace_callback($pattern, 'replaceCodeSnippet', $msg);

        return $formattedText;
    }

    // Fonction Callback pour le remplacement
    function replaceCodeSnippet($matches) {
        $code = htmlspecialchars($matches[2]); // Convert special characters to HTML entities
        return '<code class="language-javascript">' . $code . '</code>';
    }

    // 

    // Insérer dans la BD
    function insertMessage($message, $connexion){
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

    // Détéction de la langue
    function detectLang($text) {
        $lang = new Language;

        return $lang->detect($text);
    }
?>