# BING AI API

Welcome to the Bing AI API, an open-source project designed for reverse engineering Bing AI without relying on cookie usage. This initiative aims to provide a transparent and privacy-conscious approach to interact with Bing AI's functionalities.

## Latest Stable Version and Downloads

[![Latest Stable Version](http://poser.pugx.org/fakellyh/bing-api-php/v)](https://packagist.org/packages/fakellyh/bing-api-php) [![Total Downloads](http://poser.pugx.org/fakellyh/bing-api-php/downloads)](https://packagist.org/packages/fakellyh/bing-api-php) [![Latest Unstable Version](http://poser.pugx.org/fakellyh/bing-api-php/v/unstable)](https://packagist.org/packages/fakellyh/bing-api-php) [![License](http://poser.pugx.org/fakellyh/bing-api-php/license)](https://packagist.org/packages/fakellyh/bing-api-php) [![PHP Version Require](http://poser.pugx.org/fakellyh/bing-api-php/require/php)](https://packagist.org/packages/fakellyh/bing-api-php)

## Installation

For seamless integration, we recommend using Composer:

```bash
composer require fakellyh/bing-api-php
```

## Usage

To get started, add the autoloader to your project:

```php
require_once __DIR__.'/vendor/autoload.php';
```

Now, let's demonstrate how to use the Bing AI API with a simple example. Add the following PHP code to your project:

```php
use Fakell\Bing\Bing;

// Include the Composer autoloader
require __DIR__ . "/vendor/autoload.php";

// Create an instance of the Bing class
$bing = new Bing;

// Enable debug mode (optional)
$bing->debug(true);

// Make a request to Bing AI
$data = $bing->ask("Hello world!");

// Display the response data
print_r($data);
```

## Support

If you encounter any issues or believe there is a problem with this library, please feel free to [open an issue](https://github.com/fakellgit/bing-api-php/issues/new) if one doesn't already exist.

## Author

Nombana Fahendrena FIOMBONANTSOA

- Email: [fakellyh@gmail.com](mailto:fakellyh@gmail.com)
- Facebook: [fakellyh](https://www.facebook.com/fakellyh)

## License

This project is licensed under the MIT License.
