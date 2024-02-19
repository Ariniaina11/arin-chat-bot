<?php

class Static_Method
{
    // QUELQUES METHODES UTILES //

    // Formattage de texte (Pour le code source, commande Linux, ...)
    public static function formatText($msg){
        $formattedCode = self::formatCode($msg);
        $formattedTerminal = self::formatTerminal($formattedCode);
        $formattedTag = self::formatTag($formattedTerminal);
        $nomalizeTag = self::normalizeCodeTag($formattedTag);
        
        return $nomalizeTag;
    }

    // Normaliser les tags
    private static function normalizeCodeTag($msg){
        // Nom d'utilisateur
        $newText = str_replace(
            array(
                "&lt;!-- REPLACE --&gt;&lt;strong class='mypseudo'&gt;", 
                "&lt;/strong&gt;&lt;!-- REPLACE --&gt;"
            ), 
            array(
                "<strong class='mypseudo'>", 
                "</strong>"
            ), 
            $msg 
        );

        // Bouton Copy
        $newText = str_replace(
            '&lt;!-- REPLACE --&gt;&lt;button type="submit" class="copy" onclick="copyCode(this)"&gt;Copy&lt;/button&gt;&lt;!-- REPLACE --&gt;', 
            '<button type="submit" class="copy" onclick="copyCode(this)">Copy</button>', 
            $newText
        );

        // Code
        $newText = str_replace("&lt;/code&gt;&lt;!-- REPLACE --&gt;", "</code>", $newText);
        $newText = str_replace('&lt;!-- REPLACE --&gt;&lt;code class="language-javascript"&gt;', '<code class="language-javascript">', $newText);

        return $newText;
    }

    // Pattern pour les balises
    private static function formatTag($msg){
        $patterns = array('/</', '/>/', '/<\//');
        $replacements = array('&lt;', '&gt;', '&lt;/');
        $newText = preg_replace($patterns, $replacements, $msg);

        return $newText;
    }

    // Pattern pour formatter les extraits du code
    private static function formatCode($msg){
        $pattern = '/```([a-zA-Z0-9_*]+)\s*([\s\S]+?)```/';
        $formattedText = preg_replace_callback($pattern, array('Static_Method', 'replaceCodeSnippet'), $msg);

        return $formattedText;
    }

    // Pattern pour formatter les commandes Terminal
    private static function formatTerminal($msg){
        // Modèle 1
        $pattern = '/`(\$ \s*([\s\S]+?))`/';
        $formattedText = preg_replace_callback($pattern, array('Static_Method', 'replaceTerminalSnippet'), $msg);

        // Modèle 2
        $pattern = '/```\s*([\s\S]+?)```/';
        $formattedText = preg_replace_callback($pattern, array('Static_Method', 'replaceTerminalSnippet'), $formattedText);

        return $formattedText;
    }

    // ====================================== CALLBACKS ======================================

    // Fonction Callback pour le remplacement du code
    private static function replaceCodeSnippet($matches) {
        $code = htmlspecialchars($matches[2]); // Convertir des caractères spéciaux en entités HTML
        return '<!-- REPLACE --><button type="submit" class="copy" onclick="copyCode(this)">Copy</button><!-- REPLACE -->' .
                '<!-- REPLACE --><code class="language-javascript">' . $code . '</code><!-- REPLACE -->';
    }

    // Fonction Callback pour le remplacement des commandes sur Terminal
    private static function replaceTerminalSnippet($matches) {
        $code = htmlspecialchars($matches[1]); // Convertir des caractères spéciaux en entités HTML
        return '<button type="submit" class="copy" onclick="copyCode(this)">Copy</button>' .
                '<code class="language-javascript">' . $code . '</code>';
    }
}