<?php
    require('../autoload.php');

    use Mgcodeur\SuperTranslator\GoogleTranslate;
    use Fakell\Bing\Bing;

    $user_connected = $_SESSION['user_connected'];

    if(isset($_POST['msg'])){
        // Donnée réçue du POST
        $content = $_POST['msg'];

        // // Message du client
        // $message = new Message();
        // $message->setUserId($user_connected);
        // $message->setContent($content);

        // //insertMessage($message, $connexion);

        // //
    
        // // Message du bot
        // $message = new Message();
        // $message->setReceiverId($user_connected);

        // $translated_text = translate($content, 'en', 'fr');
        // $message->setContent($translated_text);

        // //insertMessage($message, $connexion);

        // // Fermer la connexion
        // $connexion = null;

        // echo $translated_text;

        // $res = callPawanAPI($content);
        // $data = json_decode($res, true);
        // $msg = formatJsonData($data)['msg'];

        $data = callBingAPI($content);

        echo $data['text'];
    }

    // ================================== FONCTIONS ==================================

    // Appel de Bing + ChatGPT4 API 
    function callBingAPI($msg) {
        $bing = new Bing;

        // Envoyer la requête
        $data = $bing->ask($msg + '(Without source)');

        return $data;
    }

    // Appel de l'API de Pawan.Krd
    function callPawanAPI($msg){
        $apiKey = 'okQGzHNPqSQeNonkYyacLllCCXuWJJNvyUhsBCLujnvggxhH';

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
            'Authorization: Bearer pk-' . $apiKey,
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

    // Appel de l'API de chatGPT
    function callAPI($msg){
        $openai_endpoint = 'https://api-fakell.x10.mx/v1/chat/completions/';
    
        $data = array(
            'model' => 'gpt-3.5-turbo',
            'messages' => [
                array(
                    'role' => 'user',
                    'content' => $msg
                )
            ],
            'stream' => false
        );
    
        $header = array(
            'Content-Type: application/json'
        );
    
        $ch = curl_init();
    
        curl_setopt($ch, CURLOPT_URL, $openai_endpoint);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
    
        $response = curl_exec($ch);
    
        curl_close($ch);
    
        return $response;
    }

    // FOrmatter la réponse de l'API
    function formatJsonData($data){
        $formattedData = array(
            'msg' => $data['choices'][0]['message']['content']
        );

        return $formattedData;
    }

    // Insérer dans la BD
    function insertMessage($message, $connexion){
        // Préparer la requête
        $stmt = $connexion->prepare(
            'INSERT INTO messages (content, receiver_id, user_id) VALUES (?, ?, ?)'
        );

        // Binding 
        $stmt->bindParam(1, $message->getContent()); 
        $stmt->bindParam(2, $message->getReceiverId());
        $stmt->bindParam(3, $message->getUserId());

        // Exécuter la requête
        $stmt->execute();
    }

    // Traduire un texte
    function translate($text, $from, $to){
        $response = "";

        try {
            // $response = GoogleTranslate::translate($from, $to, $text);
            $response = GoogleTranslate::translateAuto($to, $text);
        }
        catch(Exception $e) {
            $response = "Error : " . $e;
        }

        return $response;
    }

    // Prendre la requête du client
    function getClientRequest($data){
        // Le mot clé (Au début du message)
        $key = strtoupper($data[0]);
        $request = array();

        switch ($key) {
            case 'DEF':
                $request = [
                    'key' => $key,
                    'content' => $data[1]
                ];
                break;
            case 'TRD':
                $request = [
                    'key' => $key,
                    'from' => $data[1],
                    'to' => $data[2]
                ];
                break;
            
            default:
                $request = [
                    'key' => 'unknown'
                ];
                break;
        }

        return $request;
    }

    // Convertir un string en array
    function convertTextToArray($text){
        return explode(" ", $text);
    }

    // Supprimer les espaces en ne laissant qu'une seule
    function removeMultipleSpace($text){
        return preg_replace('/\s+/', ' ', $text);
    }
?>