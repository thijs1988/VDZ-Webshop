<?php

namespace _PhpScoper5f3e4b2e25c2b\GuzzleHttp\Exception;

use _PhpScoper5f3e4b2e25c2b\Psr\Http\Message\RequestInterface;
use _PhpScoper5f3e4b2e25c2b\Psr\Http\Message\ResponseInterface;
/**
 * Exception when an HTTP error occurs (4xx or 5xx error)
 */
class BadResponseException extends \_PhpScoper5f3e4b2e25c2b\GuzzleHttp\Exception\RequestException
{
    public function __construct(string $message, \_PhpScoper5f3e4b2e25c2b\Psr\Http\Message\RequestInterface $request, \_PhpScoper5f3e4b2e25c2b\Psr\Http\Message\ResponseInterface $response, \Throwable $previous = null, array $handlerContext = [])
    {
        parent::__construct($message, $request, $response, $previous, $handlerContext);
    }
    /**
     * Current exception and the ones that extend it will always have a response.
     */
    public function hasResponse() : bool
    {
        return \true;
    }
    /**
     * This function narrows the return type from the parent class and does not allow it to be nullable.
     */
    public function getResponse() : \_PhpScoper5f3e4b2e25c2b\Psr\Http\Message\ResponseInterface
    {
        /** @var ResponseInterface */
        return parent::getResponse();
    }
}
