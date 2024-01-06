<?php
    require 'utils/autoload.php';

    // Utilisateur non connecté
    if(!isset($_SESSION['user_connected']))
        header('location:login.php');

    // Préparer la requête
    $stmt = $connexion->prepare('SELECT * FROM messages WHERE user_id = ? OR receiver_id = ?');

    // Bindings
    $stmt->bindParam(1, $_SESSION['user_connected']);
    $stmt->bindParam(2, $_SESSION['user_connected']);

    // Execution
    $stmt->execute();

    // Prendre les résultats
    $messages = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chat</title>
    <link rel="stylesheet" href="assets/styles/index.css">
</head>
<body>

<!-- Popup - Logout -->
<div id="popup">
    <h1>Did you like to logout ?</h1>
    <br>
    <button id="no-btn">No</button>
    <button id="yes-btn">Yes</button>
</div>
   
<div class="chat-global">
    <div class="nav-top">
        <div class="location" id="logout">
            <img src="assets/images/left-chevron.svg">
            <p>Logout</p>
        </div>

        <div class="utilisateur">
            <p>Arin - Bot</p>
            <p>Active</p>
        </div>

        <div class="logos-call">
            <img src="assets/images/infos.svg">
            <!-- <img src="assets/images/video-camera.svg"> -->
        </div>
    </div>

    <div class="conversation" id="conversation">
        <div class="talk left">
            <img src="assets/images/arin-bot.png">
            <p>Bonjour ! Qu'est ce que je peux faire pour vous  &#128516; ?</p>
        </div>

        <!-- Une boucle affichant le message -->
        <?php foreach($messages as $msg): ?>

            <!-- Message du bot -->
            <?php if($msg['user_id'] == 0): ?>
                <div class="talk left">
                    <img src="assets/images/arin-bot.png">
                    <p><?= $msg['content'] ?></p>
                </div>

            <!-- Message de l'utilisateur -->
            <?php else: ?>
                <div class="talk right" style="justify-content: flex-end;">
                    <p><?= normalize($msg['content'], 50) ?></p>
                    <img src="assets/images/user.png">
                </div>
            <?php endif; ?>
            
        <?php endforeach; ?>
    </div>

    <div class="chat-form">

        <div class="container-inputs-stuffs">

            <div class="files-logo-cont">
                <img src="assets/images/paperclip.svg">
            </div>

            <!-- Vocal ou non -->
            <input type="hidden" id="vocalHidden" value="0">

            <div class="group-inp">
                <textarea placeholder="Enter your message here" minlength="1" maxlength="1500" id="msg"></textarea>
            </div>

            <!-- Loading -->
            <div class="loading submit-msg-btn">
                <span style="--i:1;"></span>
                <span style="--i:2;"></span>
                <span style="--i:3;"></span>
                <span style="--i:4;"></span>
                <span style="--i:5;"></span>
                <span style="--i:6;"></span>
                <span style="--i:7;"></span>
                <span style="--i:8;"></span>
            </div>

            <button class="submit-msg-btn" id="vocal-btn">
                <img src="assets/images/vocal.png">
            </button>
            <button class="submit-msg-btn" id="send-btn">
                <img src="assets/images/send.svg">
            </button>
        </div>
    </div>
</div>

<!-- Scripts -->
<script src="assets/scripts/jquery.js"></script>
<script src="assets/scripts/index.js"></script>
<!-- <script src="https://code.responsivevoice.org/responsivevoice.js?key=5yuiVGtS"></script> -->
<script src="assets/scripts/speech.js"></script>
<script src="assets/scripts/languages.js"></script>

<!-- Fonctions -->
<?php
    // Ajouter un 'à la ligne' à chaque $chars caractères
    function normalize($text, $chars){
        $result = "";
        $count = 0;
        // $text = htmlspecialchars($text);

        for ($i = 0; $i < strlen($text); $i++){
            $result .= htmlspecialchars($text[$i]);
            $count++;

            if($count >= $chars){
                $result .= '<br>';
                $count = 0;
            }
        }

        return $result;
    }
?>

</body>
</html>