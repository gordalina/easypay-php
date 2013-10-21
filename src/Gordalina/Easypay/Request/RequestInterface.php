<?php

/*
 * This file is part of the easypay-php package.
 *
 * (c) Samuel Gordalina <https://github.com/gordalina/easypay-php>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Gordalina\Easypay\Request;

use Gordalina\Easypay\Config;
use Gordalina\Easypay\Response\ResponseInterface;

interface RequestInterface
{
    /**
     * Returns the API path
     *
     * @return string
     */
    public function getEndpoint();

    /**
     * Creates the parameters to be used in API call
     *
     * @param  Config $config
     * @return array
     */
    public function handleRequest(Config $config);

    /**
     * Processes the return data into a ResponseInterface
     *
     * @param  string            $content
     * @return ResponseInterface
     */
    public function handleResponse($content);
}
