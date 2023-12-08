<?php

// pk-okQGzHNPqSQeNonkYyacLllCCXuWJJNvyUhsBCLujnvggxhH

$apiKey = 'okQGzHNPqSQeNonkYyacLllCCXuWJJNvyUhsBCLujnvggxhH';

$data = [
  'model' => 'pai-001-light-beta',
  'max_tokens' => 100,
  'messages' => [
    [
      'role' => 'user',
      'content' => 'Salama tompoko !'
    ]
  ]
];

$json = json_encode($data);

$curl = curl_init();
curl_setopt($curl, CURLOPT_URL, 'https://api.pawan.krd/v1/chat/completions');
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
curl_setopt($curl, CURLOPT_HTTPHEADER, [
  'Authorization: Bearer pk-' . $apiKey,
  'Content-Type: application/json'
]);
curl_setopt($curl, CURLOPT_POSTFIELDS, $json);

$response = curl_exec($curl);
curl_close($curl);

echo $response;


