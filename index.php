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
    <title>Arin-bot</title>
    <link rel="shortcut icon" href="assets/images/arin-bot.ico" type="image/x-icon">
    <link rel="stylesheet" href="assets/styles/index.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/prismjs@1.25.0/themes/prism.min.css" />
    <script src="https://cdn.jsdelivr.net/npm/prismjs@1.25.0"></script>
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
            <img src="assets/images/left-chevron.svg" alt="logout-img">
            <p>Logout</p>
        </div>

        <div class="utilisateur">
            <p>Arin - Bot</p>
            <p>Active</p>
        </div>

        <div class="logos-call">
            <img src="assets/images/infos.svg" alt="infos">
            <!-- <img src="assets/images/video-camera.svg"> -->
        </div>
    </div>

    <div class="conversation" id="conversation">

        <!-- Une boucle affichant le message -->
        <?php foreach($messages as $msg): ?>

            <!-- Message du bot -->
            <?php if($msg['user_id'] == 0): ?>
                <div class="talk left">
                    <img src="assets/images/arin-bot.png" alt="arin-bot">
                    <p>
                        <?=  formatText($msg['content']) ?>
                    </p>
                </div>

            <!-- Message de l'utilisateur -->
            <?php else: ?>
                <div class="talk right" style="justify-content: flex-end;">
                    <p><?= $msg['content'] ?></p>
                    <img src="assets/images/user.png"  alt="user">
                </div>
            <?php endif; ?>
            
        <?php endforeach; ?>

    </div>

    <div class="chat-form">

        <div class="container-inputs-stuffs">

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
    // Formattage du texte
    function formatText($msg){
        // Modèle pour faire correspondre les extraits de code
        $pattern = '/```([a-zA-Z0-9_]+)\s*([\s\S]+?)```/';
        $formattedText = preg_replace_callback($pattern, 'replaceCodeSnippet', $msg);

        return $formattedText;
    }

    // Fonction Callback pour le remplacement
    function replaceCodeSnippet($matches) {
        $code = htmlspecialchars($matches[2]); // Convert special characters to HTML entities
        return '<code class="language-javascript">' . nl2br($code) . '</code>';
    }
?>

</body>
</html>