# Arin-chat-bot

## _A bot app using openAI API_

It is an automated conversation application utilizing the OpenAI API (through a reverse proxy).


## Steps

Create a new database. 

Import the file _chat.sql_

Edit the credentials on /utils/objects/api.php

```php

// Clé de l'API de openAI by Pawan ("pk-...")
public static $OPENAI_KEY = "YOUR_API_KEY";

// Clé du site reCAPTCHA
public static $CAPTCHA_SITE_KEY = "YOUR_CAPTCHA_SITE_KEY";

// Clé secrète du Google reCAPCTHA
public static $CAPTCHA_SECRET = "YOUR_CAPTCHA_SECRET";

```

## Pawan.Krd reverse proxy
https://github.com/PawanOsman/ChatGPT
