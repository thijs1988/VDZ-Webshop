<?php

namespace _PhpScoper5f3e4b2e25c2b\GuzzleHttp\Exception;

use _PhpScoper5f3e4b2e25c2b\Psr\Http\Client\RequestExceptionInterface;
use _PhpScoper5f3e4b2e25c2b\Psr\Http\Message\RequestInterface;
use _PhpScoper5f3e4b2e25c2b\Psr\Http\Message\ResponseInterface;
use _PhpScoper5f3e4b2e25c2b\Psr\Http\Message\UriInterface;
/**
 * HTTP Request exception
 */
class RequestException extends \_PhpScoper5f3e4b2e25c2b\GuzzleHttp\Exception\TransferException implements \_PhpScoper5f3e4b2e25c2b\Psr\Http\Client\RequestExceptionInterface
{
    /**
     * @var RequestInterface
     */
    private $request;
    /**
     * @var ResponseInterface|null
     */
    private $response;
    /**
     * @var array
     */
    private $handlerContext;
    public function __construct(string $message, \_PhpScoper5f3e4b2e25c2b\Psr\Http\Message\RequestInterface $request, \_PhpScoper5f3e4b2e25c2b\Psr\Http\Message\ResponseInterface $response = null, \Throwable $previous = null, array $handlerContext = [])
    {
        // Set the code of the exception if the response is set and not future.
        $code = $response ? $response->getStatusCode() : 0;
        parent::__construct($message, $code, $previous);
        $this->request = $request;
        $this->response = $response;
        $this->handlerContext = $handlerContext;
    }
    /**
     * Wrap non-RequestExceptions with a RequestException
     */
    public static function wrapException(\_PhpScoper5f3e4b2e25c2b\Psr\Http\Message\RequestInterface $request, \Throwable $e) : \_PhpScoper5f3e4b2e25c2b\GuzzleHttp\Exception\RequestException
    {
        return $e instanceof \_PhpScoper5f3e4b2e25c2b\GuzzleHttp\Exception\RequestException ? $e : new \_PhpScoper5f3e4b2e25c2b\GuzzleHttp\Exception\RequestException($e->getMessage(), $request, null, $e);
    }
    /**
     * Factory method to create a new exception with a normalized error message
     *
     * @param RequestInterface  $request  Request
     * @param ResponseInterface $response Response received
     * @param \Throwable        $previous Previous exception
     * @param array             $ctx      Optional handler context.
     */
    public static function create(\_PhpScoper5f3e4b2e25c2b\Psr\Http\Message\RequestInterface $request, \_PhpScoper5f3e4b2e25c2b\Psr\Http\Message\ResponseInterface $response = null, \Throwable $previous = null, array $ctx = []) : self
    {
        if (!$response) {
            return new self('Error completing request', $request, null, $previous, $ctx);
        }
        $level = (int) \floor($response->getStatusCode() / 100);
        if ($level === 4) {
            $label = 'Client error';
            $className = \_PhpScoper5f3e4b2e25c2b\GuzzleHttp\Exception\ClientException::class;
        } elseif ($level === 5) {
            $label = 'Server error';
            $className = \_PhpScoper5f3e4b2e25c2b\GuzzleHttp\Exception\ServerException::class;
        } else {
            $label = 'Unsuccessful request';
            $className = __CLASS__;
        }
        $uri = $request->getUri();
        $uri = static::obfuscateUri($uri);
        // Client Error: `GET /` resulted in a `404 Not Found` response:
        // <html> ... (truncated)
        $message = \sprintf('%s: `%s %s` resulted in a `%s %s` response', $label, $request->getMethod(), $uri, $response->getStatusCode(), $response->getReasonPhrase());
        $summary = \_PhpScoper5f3e4b2e25c2b\GuzzleHttp\Psr7\get_message_body_summary($response);
        if ($summary !== null) {
            $message .= ":\n{$summary}\n";
        }
        return new $className($message, $request, $response, $previous, $ctx);
    }
    /**
     * Obfuscates URI if there is a username and a password present
     */
    private static function obfuscateUri(\_PhpScoper5f3e4b2e25c2b\Psr\Http\Message\UriInterface $uri) : \_PhpScoper5f3e4b2e25c2b\Psr\Http\Message\UriInterface
    {
        $userInfo = $uri->getUserInfo();
        if (\false !== ($pos = \strpos($userInfo, ':'))) {
            return $uri->withUserInfo(\substr($userInfo, 0, $pos), '***');
        }
        return $uri;
    }
    /**
     * Get the request that caused the exception
     */
    public function getRequest() : \_PhpScoper5f3e4b2e25c2b\Psr\Http\Message\RequestInterface
    {
        return $this->request;
    }
    /**
     * Get the associated response
     */
    public function getResponse() : ?\_PhpScoper5f3e4b2e25c2b\Psr\Http\Message\ResponseInterface
    {
        return $this->response;
    }
    /**
     * Check if a response was received
     */
    public function hasResponse() : bool
    {
        return $this->response !== null;
    }
    /**
     * Get contextual information about the error from the underlying handler.
     *
     * The contents of this array will vary depending on which handler you are
     * using. It may also be just an empty array. Relying on this data will
     * couple you to a specific handler, but can give more debug information
     * when needed.
     */
    public function getHandlerContext() : array
    {
        return $this->handlerContext;
    }
}