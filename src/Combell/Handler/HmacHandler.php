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

        $path = (string) $request->getUri()->getPath();
        $query = (string) $request->getUri()->getQuery();
        $body = (string) $request->getBody();

        if ($query !== '') {
            $path .= '?' . $query;
        }

        if ($body !== '') {
            $body = base64_encode(md5($body, true));
        }

        $valueToSign = $this->apiKey
            . strtolower($request->getMethod())
            . urlencode($path)
            . $time
            . $nonce
            . $body;
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