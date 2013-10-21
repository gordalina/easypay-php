<?php

/*
 * This file is part of the easypay-php package.
 *
 * (c) Samuel Gordalina <https://github.com/gordalina/easypay-php>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Gordalina\Easypay;

use Buzz\Client\ClientInterface;
use Buzz\Client\Curl;
use Buzz\Client\FileGetContents;
use Buzz\Message\Request;
use Buzz\Message\Response;

use Gordalina\Easypay\Request\RequestInterface;

class Client
{
    const ENDPOINT_PRODUCTION = 'https://www.easypay.pt';
    const ENDPOINT_SANDBOX = 'http://test.easypay.pt';

    /**
     * @var Config
     */
    protected $config;

    /**
     * @var ClientInterface
     */
    protected $client;

    /**
     * @var boolean
     */
    protected $sandbox = false;

    /**
     * @param Config          $config
     * @param ClientInterface $client Buzz Client
     */
    public function __construct(Config $config, ClientInterface $client = null)
    {
        $this->config = $config;

        if ($client instanceof ClientInterface) {
            $this->client = $client;
        } elseif (extension_loaded('curl')) {
            $this->client = new Curl();
        } else {
            $this->client = new FileGetContents();
        }
    }

    /**
     * Enable communication to sandbox server
     *
     * @param  boolean $sandbox defaults to true
     * @return null
     */
    public function setSandbox($sandbox = true)
    {
        $this->sandbox = $sandbox;
    }

    /**
     * @return boolean
     */
    public function isSandbox()
    {
        return $this->sandbox;
    }

    /**
     * @param  string            $method
     * @param  array             $parameters
     * @return string            Content of server response
     * @throws \RuntimeException If response from API is invalid
     */
    public function request(RequestInterface $method)
    {
        $parameters = $method->handleRequest($this->config);

        $query = str_replace(' ', '+', http_build_query($parameters));
        $resource = sprintf('/_s/%s?%s', $method->getEndpoint(), $query);

        $response = new Response();
        $request = new Request('GET', $resource, $this->getEndpoint());

        $this->client->send($request, $response);

        if (!$response->isSuccessful()) {
            throw new \RuntimeException(sprintf("Response status code is invalid: %d", $response->getStatusCode()));
        }

        $content = static::decodeResponse($response->getContent());

        return $method->handleResponse($content);
    }

    /**
     * Server returns everything in XML within the automb tag so a simple
     * implementation to translate it to an array is enough
     *
     * Current implementation does not work with nested xml tags
     *
     * @static
     * @param  $content string
     * @return array
     */
    protected static function decodeResponse($content)
    {
        return (array) simplexml_load_string($content);
    }

    /**
     * Return production or sandbox endpoint depending on state
     *
     * @return string
     */
    protected function getEndpoint()
    {
        return !$this->sandbox ? static::ENDPOINT_PRODUCTION : static::ENDPOINT_SANDBOX;
    }
}
