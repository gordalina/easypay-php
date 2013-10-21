<?php

/*
 * This file is part of the easypay-php package.
 *
 * (c) Samuel Gordalina <https://github.com/gordalina/easypay-php>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Gordalina\Easypay\Tests\Stub;

use Buzz\Client\AbstractClient;
use Buzz\Message\MessageInterface;
use Buzz\Message\RequestInterface;

class ClientStub extends AbstractClient
{
    /**
     * @var RequestInterface
     */
    protected $request;

    /**
     * @var MessageInterface
     */
    protected $response;

    /**
     * {@inheritdoc}
     */
    public function send(RequestInterface $request, MessageInterface $response)
    {
        $this->request = $request;
        $this->response = $response;

        $response->setHeaders(array('HTTP/1.1 200 OK'));
        $response->setContent('<root><status>ok</status></root>');
    }

    /**
     * @return RequestInterface
     */
    public function getRequest()
    {
        return $this->request;
    }

    /**
     * @return MessageInterface
     */
    public function getResponse()
    {
        return $this->response;
    }
}
