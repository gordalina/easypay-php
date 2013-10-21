<?php

/*
 * This file is part of the easypay-php package.
 *
 * (c) Samuel Gordalina <https://github.com/gordalina/easypay-php>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Gordalina\Easypay\Tests\Response;

use Gordalina\Easypay\Response\RequestPayment;

class RequestPaymentTest extends \PHPUnit_Framework_TestCase
{
    public function testGettersSetters()
    {
        $response = new RequestPayment(array(
            'ep_entity' => 'entity',
            'ep_reference' => 'reference',
            'ep_value' => '12.3',
            'ep_key' => 'key',
            'ep_status' => 'ok0',
            'ep_message' => 'message',
        ));

        $this->assertTrue($response->isValid());
        $this->assertSame('entity', $response->getEntity());
        $this->assertSame('reference', $response->getReference());
        $this->assertSame(12.3, $response->getValue());
        $this->assertSame('key', $response->getKey());
        $this->assertSame('ok0', $response->getStatus());
        $this->assertSame('message', $response->getMessage());
    }

    public function testInvalid()
    {
        $response = new RequestPayment(array(
            'ep_entity' => 'entity',
            'ep_reference' => 'reference',
            'ep_value' => '12.3',
            'ep_key' => 'key',
            'ep_status' => 'err',
            'ep_message' => 'message',
        ));

        $this->assertFalse($response->isValid());
    }
}
