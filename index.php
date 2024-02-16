<?php
    require 'utils/autoload.php';

    // Utilisateur non connecté
    if(!isset($_SESSION['user_connected']))
        header('location:login.php');

    // $_SESSION['user_connected'] = 27;

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
    <!-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/prismjs@1.25.0/themes/prism.min.css" />
    <script src="https://cdn.jsdelivr.net/npm/prismjs@1.25.0"></script> -->
    <link href="https://cdn.jsdelivr.net/npm/prismjs@1.25.0/themes/prism.css" rel="stylesheet">
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
            <img src="assets/images/logout.png" alt="logout-img">
            <p>Logout</p>
        </div>

        <div class="utilisateur">
            <p>Arin - Bot</p>
        </div>

        <div class="api-choice">
            <img src="assets/images/openai.png" alt="infos">
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

            <button type="button" class="submit-msg-btn" id="vocal-btn">
                <img src="assets/images/vocal.png">
            </button>

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

            
            <button class="submit-msg-btn" id="send-btn">
                <img src="assets/images/send.png">
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
<script src="https://cdn.jsdelivr.net/npm/prismjs@1.25.0/prism.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        Prism.highlightAll();
    });

    // Copie dans la presse-papier
    function copyCode(copy_btn) {
        //  Obtenir l'élément <code>
        var codeElement = document.querySelector('code.language-javascript');
        if (codeElement) {
            // Créer un élément textarea pour contenir temporairement le texte
            var textarea = document.createElement('textarea');
            textarea.value = copy_btn.nextElementSibling.textContent;
            document.body.appendChild(textarea);
    
            // Sélectionnez le texte dans la zone de texte
            textarea.select();
            textarea.setSelectionRange(0, 99999); // Pour les appareils mobiles
    
            // Copier le texte dans le presse-papiers
            document.execCommand('copy');
    
            // Supprimer l’élément textarea
            document.body.removeChild(textarea);
    
            // Changer le texte sur le bouton
            copy_btn.textContent = "Copied !!";
            
        }
    }
</script>

<!-- Fonctions -->
<?php
    // Formattage de texte (Pour le code source, commande Linux, ...)
    function formatText($msg){
        $formattedCode = formatCode($msg);
        $formattedTerminal = formatTerminal($formattedCode);
        
        return $formattedTerminal;
    }

    // Pattern pour formatter les extraits du code
    function formatCode($msg){
        $pattern = '/```([a-zA-Z0-9_*]+)\s*([\s\S]+?)```/';
        $formattedText = preg_replace_callback($pattern, 'replaceCodeSnippet', $msg);

        return $formattedText;
    }

    // Pattern pour formatter les commandes Terminal
    function formatTerminal($msg){
        // Modèle 1
        $pattern = '/`(\$ \s*([\s\S]+?))`/';
        $formattedText = preg_replace_callback($pattern, 'replaceTerminalSnippet', $msg);

        // Modèle 2
        $pattern = '/```\s*([\s\S]+?)```/';
        $formattedText = preg_replace_callback($pattern, 'replaceTerminalSnippet', $formattedText);

        return $formattedText;
    }

    // ====================================== CALLBACKS ======================================

    // Fonction Callback pour le remplacement du code
    function replaceCodeSnippet($matches) {
        $code = htmlspecialchars($matches[2]); // Convertir des caractères spéciaux en entités HTML
        return '<button type="submit" class="copy" onclick="copyCode(this)">Copy</button>' .
                '<code class="language-javascript">' . $code . '</code>';
    }

    // Fonction Callback pour le remplacement des commandes sur Terminal
    function replaceTerminalSnippet($matches) {
        $code = htmlspecialchars($matches[1]); // Convertir des caractères spéciaux en entités HTML
        return '<button type="submit" class="copy" onclick="copyCode(this)">Copy</button>' .
                '<code class="language-javascript">' . $code . '</code>';
    }
?>

</body>
</html>