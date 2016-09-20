# Combell public API

[![Build Status](https://travis-ci.org/combell/combell-api.svg?branch=master)](https://travis-ci.org/combell/combell-api)
[![Coverage Status](https://coveralls.io/repos/github/combell/combell-api/badge.svg?branch=master)](https://coveralls.io/github/combell/combell-api?branch=master)

The *Combell public API project* wraps around [Guzzle](http://docs.guzzlephp.org/en/latest/) and offers *HMAC authentication*. You can use the client to easily connect to the Combell public API endpoint.

To learn more about the **Combell public API**, go to [https://api.combell.com/](https://api.combell.com/).

## Install

```
composer require combell/combell-api
```


## Example

The code example below creates a new hosting account called **identifier.be** on our hosting environment.

```php
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

$body = new \stdClass();
$body->servicepack_id = '0';
$body->identifier = 'identifier.be';
$body->password = 'password';

// Create hosting account
$response = $client->post('/v1/hostingaccounts', ['json' => $body]);

// Dump response
var_dump(
    json_decode($response->getBody()->getContents())
);
```

Go to the [examples](examples) folder to see more examples.