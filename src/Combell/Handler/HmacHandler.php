<?php
namespace Combell\Handler;

use Psr\Http\Message\RequestInterface;

class HmacHandler
{
    protected $apiKey;
    protected $apiSecret;

    public function __construct($apiKey, $apiSecret)
    {
        $this->apiKey = $apiKey;
        $this->apiSecret = $apiSecret;
    }

    protected function sign(RequestInterface $request, $nonce)
    {
        $time = time();
        $valueToSign = $this->apiKey
            . strtolower($request->getMethod())
            . urlencode($request->getUri()->getPath())
            . $time
            . $nonce
            . $request->getBody()->getContents();
        $signedValue = hash_hmac('sha256', $valueToSign, $this->apiSecret, true);
        $signature = base64_encode($signedValue);
        
        return sprintf('hmac %s:%s:%s:%s', $this->apiKey, $signature, $nonce, $time);
    }

    public function __invoke(callable $handler)
    {
        return function (RequestInterface $request, array $options) use ($handler) {
            $request = $request->withHeader('Authorization', $this->sign($request, uniqid()));
            
            return $handler($request, $options);
        };
    }
}