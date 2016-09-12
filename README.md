# Combell API

The Combell API project wraps around [Guzzle](http://docs.guzzlephp.org/en/latest/) and offers HMAC authentication. You can use the client to easily connect to the Combell public API endpoint.

To learn more about the Combell public API, go to [https://api.combell.com/](https://api.combell.com/).

[Combell]https://combell.com, your host on the internet.

## Example

The code example below creates a new hosting account called *identifier.be* on our hosting environment.

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
$response = $client->post('/v1/hostingaccounts', array('json' => $body));

// Dump response
var_dump(
    json_decode($response->getBody()->getContents())
);
```

Go to the [examples](../blob/master/examples) folder to see more examples.