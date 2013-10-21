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

use Gordalina\Easypay\Response\CreatePayment;

class CreatePaymentTest extends \PHPUnit_Framework_TestCase
{
    public function testGettersSetters()
    {
        $response = new CreatePayment(array(
            'ep_cin' => 'cin',
            'ep_user' => 'user',
            'ep_entity' => 'entity',
            'ep_reference' => 'reference',
            'ep_value' => '12.3',
            't_key' => 'key',
            'ep_link' => 'link',
            'ep_boleto_link' => 'boleto_link',
            'ep_status' => 'ok0',
            'ep_message' => 'message',
        ));

        $this->assertTrue($response->isValid());
        $this->assertSame('cin', $response->getCin());
        $this->assertSame('user', $response->getUser());
        $this->assertSame('entity', $response->getEntity());
        $this->assertSame('reference', $response->getReference());
        $this->assertSame(12.3, $response->getValue());
        $this->assertSame('key', $response->getKey());
        $this->assertSame('link', $response->getLink());
        $this->assertSame('boleto_link', $response->getBoletoLink());
        $this->assertSame('ok0', $response->getStatus());
        $this->assertSame('message', $response->getMessage());
    }

    public function testInvalid()
    {
        $response = new CreatePayment(array(
            'ep_cin' => 'cin',
            'ep_user' => 'user',
            'ep_entity' => 'entity',
            'ep_reference' => 'reference',
            'ep_value' => '12.3',
            't_key' => 'key',
            'ep_link' => 'link',
            'ep_boleto_link' => 'boleto_link',
            'ep_status' => 'err',
            'ep_message' => 'message',
        ));

        $this->assertFalse($response->isValid());
    }
}
