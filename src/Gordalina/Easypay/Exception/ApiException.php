<?php

/*
 * This file is part of the easypay-php package.
 *
 * (c) Samuel Gordalina <https://github.com/gordalina/easypay-php>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Gordalina\Easypay\Exception;

class ApiException extends \Exception
{
    /**
     * @var string
     */
    protected $status;

    /**
     * @param string $message
     * @param string $status
     */
    public function __construct($message, $status)
    {
        parent::__construct($message);

        $this->status = $status;
    }

    /**
     * @return string
     */
    public function getStatus()
    {
        return $this->status;
    }
}
