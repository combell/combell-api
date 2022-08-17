<?php
$domain_name = "combell.com";

require dirname(__DIR__) . '/vendor/autoload.php';

$client = new \Combell\Client(
    [
        'debug' => true,
        'base_uri' => 'https://api.combell.com',
        'combell_api_key' => 'XXXX',
        'combell_api_secret' => 'YYYY'
    ]
);

$response = $client->get('/v2/dns/'.$domain_name.'/records', [
    'query' => [
        'skip' => 0,
        'take' => 10
    ]
]);

var_dump(
    json_decode($response->getBody()->getContents())
);