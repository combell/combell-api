<?php
namespace Combell\Tests\Handler;

use Combell\Handler\HmacHandler;
use GuzzleHttp\Psr7\Request;
use PHPUnit\Framework\TestCase;

class HmacHandlerTest extends TestCase
{
    public function testSign()
    {
        $apiKey = 'xyz';
        $apiSecret = 'abc';

        $hmacHandler = new HmacHandler($apiKey, $apiSecret);
        $request = new Request('get', '/');
        $nonce = uniqid();
        $time = time();
        $hmac = $this->invokeMethod($hmacHandler, 'sign', [$request, $nonce]);

        $body = (string) $request->getBody()->getContents();

        if ($body !== '') {
            $body = base64_encode(md5($body, true));
        }

        $valueToSign = $apiKey
            . strtolower($request->getMethod())
            . urlencode($request->getUri()->getPath())
            . $time
            . $nonce
            . $body;
        $signedValue = hash_hmac('sha256', $valueToSign, $apiSecret, true);
        $signature = base64_encode($signedValue);

        $this->assertEquals('hmac ' . $apiKey . ':' . $signature . ':' . $nonce . ':' . $time, $hmac);
    }

    protected function invokeMethod(&$object, $methodName, array $parameters = [])
    {
        $reflection = new \ReflectionClass(get_class($object));
        $method = $reflection->getMethod($methodName);
        $method->setAccessible(true);

        return $method->invokeArgs($object, $parameters);
    }
}