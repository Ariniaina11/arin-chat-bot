# Arin-chat-bot

## _A bot app using openAI API_

It is an automated conversation application utilizing the OpenAI API (through a reverse proxy).


## Steps

Clone this repository

```git
git clone https://github.com/Ariniaina11/arin-chat-bot/
```

Create a new database. 

Import the file _chat.sql_

Edit the credentials on /utils/database.php
```php

$db_name = 'DB_NAME';
$username = 'DB_USERNAME';
$pass = 'USER_PASSWORD';

```
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

## Language detection for PHP
https://github.com/patrickschur/language-detection
