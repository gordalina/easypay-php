<?php

/*
 * This file is part of the easypay-php package.
 *
 * (c) Samuel Gordalina <https://github.com/gordalina/easypay-php>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Gordalina\Easypay\Tests\Payment;

use Gordalina\Easypay\Payment\PaymentResult;

class PaymentResultTest extends \PHPUnit_Framework_TestCase
{
    public function testConstructorGettersSetters()
    {
        $result = new PaymentResult(
            'entity',
            'reference',
            1.23,
            'authorizationKey',
            'ok',
            'key'
        );

        $this->assertSame('entity', $result->getEntity());
        $this->assertSame('reference', $result->getReference());
        $this->assertSame(1.23, $result->getValue());
        $this->assertSame('authorizationKey', $result->getAuthorizationKey());
        $this->assertSame('ok', $result->getStatus());
        $this->assertSame('key', $result->getKey());
    }

    public function testFromGlobals()
    {
        global $_GET;

        $_GET = array(
            'e' => 'entity',
            'r' => 'reference',
            'v' => '1.23',
            'k' => 'authorizationKey',
            's' => 'ok',
            't_key' => 'key'
        );

        $result = PaymentResult::fromGlobals();

        $this->assertSame('entity', $result->getEntity());
        $this->assertSame('reference', $result->getReference());
        $this->assertSame(1.23, $result->getValue());
        $this->assertSame('authorizationKey', $result->getAuthorizationKey());
        $this->assertSame('ok', $result->getStatus());
        $this->assertSame('key', $result->getKey());
    }

    public function testValueType()
    {
        $result = $this->getPaymentResult();

        $this->assertSame(1.23, $result->getValue());
    }

    public function testValid()
    {
        $result = $this->getPaymentResult();

        $this->assertTrue($result->isValid());
    }

    public function testNotValid()
    {
        $result = new PaymentResult(
            'entity',
            'reference',
            '1.23',
            'authorizationKey',
            'err',
            'key'
        );

        $this->assertFalse($result->isValid());
    }

    public function testToArray()
    {
        $result = $this->getPaymentResult();

        $array = $result->toArray();

        $this->assertTrue(is_array($array));
        $this->assertCount(6, $array);
        $this->assertSame($array, array(
            'e' => 'entity',
            'r' => 'reference',
            'v' => 1.23,
            'k' => 'authorizationKey',
            's' => 'ok',
            't_key' => 'key'
        ));
    }

    protected function getPaymentResult()
    {
        return new PaymentResult(
            'entity',
            'reference',
            '1.23',
            'authorizationKey',
            'ok',
            'key'
        );
    }
}
