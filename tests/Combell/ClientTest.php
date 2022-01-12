<?php

namespace Combell\Tests;

use Combell\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;

class ClientTest extends TestCase
{
    public function testGetDomains()
    {
        $payload = [
            [
                'domainName' => 'test.be',
                'expirationDate' => '2017-04-18T07:45:21.187Z',
                'willRenew' => true,
            ]
        ];

        $mock = new MockHandler([
            new Response(
                200,
                [
                    'Content-Type' => 'application/json; charset=utf-8',
                    'X-Ratelimit-Limit' => 10,
                    'X-Ratelimit-Usage' => 1,
                    'X-Paging-Skipped' => 0,
                    'X-Paging-Size' => 1,
                    'X-Paging-TotalResults' => 1
                ],
                json_encode($payload)
            ),
        ]);

        $handler = HandlerStack::create($mock);

        $client = new Client([
            'handler_stack' => $handler,
            'combell_api_key' => 'xyz',
            'combell_api_secret' => '123'
        ]);

        $response = $client->get('/');
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals('application/json; charset=utf-8', $response->getHeaderLine('Content-Type'));
        $this->assertEquals(10, $response->getHeaderLine('X-Ratelimit-Limit'));
        $this->assertEquals(1, $response->getHeaderLine('X-Ratelimit-Usage'));
        $this->assertEquals(0, $response->getHeaderLine('X-Paging-Skipped'));
        $this->assertEquals(1, $response->getHeaderLine('X-Paging-Size'));
        $this->assertEquals(1, $response->getHeaderLine('X-Paging-TotalResults'));
        $this->assertEquals(json_encode($payload), $response->getBody()->getContents());
    }
}
