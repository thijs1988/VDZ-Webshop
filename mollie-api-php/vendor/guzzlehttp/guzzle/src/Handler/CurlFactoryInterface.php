<?php

namespace _PhpScoper5f3e4b2e25c2b\GuzzleHttp\Handler;

use _PhpScoper5f3e4b2e25c2b\Psr\Http\Message\RequestInterface;
interface CurlFactoryInterface
{
    /**
     * Creates a cURL handle resource.
     *
     * @param RequestInterface $request Request
     * @param array            $options Transfer options
     *
     * @throws \RuntimeException when an option cannot be applied
     */
    public function create(\_PhpScoper5f3e4b2e25c2b\Psr\Http\Message\RequestInterface $request, array $options) : \_PhpScoper5f3e4b2e25c2b\GuzzleHttp\Handler\EasyHandle;
    /**
     * Release an easy handle, allowing it to be reused or closed.
     *
     * This function must call unset on the easy handle's "handle" property.
     */
    public function release(\_PhpScoper5f3e4b2e25c2b\GuzzleHttp\Handler\EasyHandle $easy) : void;
}
