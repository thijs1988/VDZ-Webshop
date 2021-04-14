<?php

namespace _PhpScoper5f3e4b2e25c2b\Psr\Http\Client;

use _PhpScoper5f3e4b2e25c2b\Psr\Http\Message\RequestInterface;
/**
 * Thrown when the request cannot be completed because of network issues.
 *
 * There is no response object as this exception is thrown when no response has been received.
 *
 * Example: the target host name can not be resolved or the connection failed.
 */
interface NetworkExceptionInterface extends \_PhpScoper5f3e4b2e25c2b\Psr\Http\Client\ClientExceptionInterface
{
    /**
     * Returns the request.
     *
     * The request object MAY be a different object from the one passed to ClientInterface::sendRequest()
     *
     * @return RequestInterface
     */
    public function getRequest() : \_PhpScoper5f3e4b2e25c2b\Psr\Http\Message\RequestInterface;
}
