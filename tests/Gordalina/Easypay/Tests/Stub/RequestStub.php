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

use Gordalina\Easypay\Config;
use Gordalina\Easypay\Request\RequestInterface;

class RequestStub implements RequestInterface
{
    /**
     * {@inheritdoc}
     */
    public function getEndpoint()
    {
        return 'endpoint';
    }

    /**
     * {@inheritdoc}
     */
    public function handleRequest(Config $config)
    {
        return array(
            'param' => 'value'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function handleResponse($content)
    {
        return new ResponseStub($content);
    }
}
