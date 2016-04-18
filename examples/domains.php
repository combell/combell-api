<?php

require dirname(__DIR__) . '/vendor/autoload.php';

$client = new \Combell\Client(
    [
        'debug' => true,
        'base_uri' => 'http://public-api.staging02.intelligent.local',
        'combell_api_key' => '5a371886817b4baf8d1299c39da4202c',
        'combell_api_secret' => 'EDD80C13DD31D1EDCC117083AD044572C2D1D2119B7EED48EEDC82AB2074430C'
    ]
);

// Get all domains you manage
$response = $client->get('/api/domains');

// Dump response
var_dump(
    json_decode($response->getBody()->getContents())
);