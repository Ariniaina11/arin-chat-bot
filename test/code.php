<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/prismjs@1.25.0/themes/prism.min.css" />
    <script src="https://cdn.jsdelivr.net/npm/prismjs@1.25.0"></script>
</head>
<body>
    <pre>
        <code class="language-javascript" style="width:100px;">
            Console.Write("Hello, World");
        </code>
    </pre>
    <?php
        // Original dynamic content with code snippet
        $dynamicContent = 'Some text before the code ```c++ cout << Hihi;``` Some text after the code';

        // Pattern to match code snippets
        $pattern = '/```([a-zA-Z0-9_]+)\s*([\s\S]+?)```/';

        // Callback function for replacement
        function replaceCodeSnippet($matches) {
            $code = htmlspecialchars($matches[2]); // Convert special characters to HTML entities
            return '<code class="language-javascript">' . $code . '</code>';
        }

        // Perform the replacement using preg_replace_callback
        $newContent = preg_replace_callback($pattern, 'replaceCodeSnippet', $dynamicContent);

        // Output the result
        echo $newContent;
    ?>


</body>
</html>


