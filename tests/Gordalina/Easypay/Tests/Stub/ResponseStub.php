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

use Gordalina\Easypay\Response\ResponseInterface;

class ResponseStub implements ResponseInterface
{
    /**
     * @var string
     */
    protected $status;

    /**
     * @param array $content
     */
    public function __construct(array $content)
    {
        $this->status = $content['status'];
    }

    /**
     * {@inheritdoc}
     */
    public function isValid()
    {
        return $this->status === 'ok';
    }

    /**
     * {@inheritdoc}
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * {@inheritdoc}
     */
    public function getMessage()
    {
        return 'error';
    }
}
