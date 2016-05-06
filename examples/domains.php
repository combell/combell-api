<?php

require dirname(__DIR__) . '/vendor/autoload.php';

$client = new \Combell\Client(
    [
        'debug' => true,
        'base_uri' => 'https://api.combell.com',
        'combell_api_key' => '61824f1976554711af80a9a1b344f59d',
        'combell_api_secret' => '823A4ACD6FB2B2B991AEA04120D38C5429D929C68F7799FEB5C1885FF0DFBC5E'
    ]
);

// Get all domains you manage
$response = $client->get('/v1/domains', [
    'query' => [
        'skip' => 0,
        'take' => 10
    ]
]);

// Dump response
var_dump(
    json_decode($response->getBody()->getContents())
);