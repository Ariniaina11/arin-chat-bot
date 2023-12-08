<?php

require_once 'vendor/autoload.php';

use Fakell\Bing\Bing;

// Create an instance of the Bing class
$bing = new Bing;

// Enable debug mode (optional)
$bing->debug(true);

// Make a request to Bing AI
$data = $bing->ask("Qui est le président de Madagascar ?");

print_r($data);