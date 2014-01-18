<?php

/*
 * This file is part of the easypay-php package.
 *
 * (c) Samuel Gordalina <https://github.com/gordalina/easypay-php>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Gordalina\Easypay\Response;

abstract class AbstractResponse
{
    /**
     * @param  array  $input
     * @param  array  $scheme
     * @return null
     */
    protected function parse(array $input, array $scheme)
    {
        foreach ($scheme as $key => $value) {
            if (!isset($input[$key])) {
                continue;
            }

            if (is_array($value)) {
                list($property, $processor) = $value;
                $this->{$property} = $processor($input[$key]);
            } else {
                $this->{$value} = $input[$key];
            }
        }
    }
}
