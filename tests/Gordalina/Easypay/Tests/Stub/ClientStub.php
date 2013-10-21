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
     * @var callable
     */
    protected $callback;

    public function __construct($callback)
    {
        $this->callback = $callback;
    }

    /**
     * {@inheritdoc}
     */
    public function send(RequestInterface $request, MessageInterface $response)
    {
        $this->request = $request;
        $this->response = $response;

        if (is_callable($this->callback)) {
            call_user_func($this->callback, $request, $response);
        }
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
