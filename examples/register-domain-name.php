<?php

require dirname(__DIR__) . '/vendor/autoload.php';

$client = new \Combell\Client(
    [
        'debug' => true,
        'base_uri' => 'https://api.combell.com',
        'combell_api_key' => 'XXXX',
        'combell_api_secret' => 'YYYY'
    ]
);

$body = [
    'domain_name' => 'domain-name-to-register.eu'
];

// Register domain name
$response = $client->post('/v2/domains/registrations', ['json' => $body]);

// Dump location header with link to provisioning job
var_dump(
    $response->getHeader('Location')
);