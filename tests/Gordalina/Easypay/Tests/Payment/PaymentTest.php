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

use Gordalina\Easypay\Payment\CustomerInfo;
use Gordalina\Easypay\Payment\Payment;

class PaymentTest extends \PHPUnit_Framework_TestCase
{
    public function testConstants()
    {
        $this->assertSame('normal', Payment::TYPE_NORMAL);
        $this->assertSame('boleto', Payment::TYPE_BOLETO);
        $this->assertSame('moto', Payment::TYPE_MOTO);
    }

    public function testDefaultType()
    {
        $payment = new Payment();

        $this->assertSame(Payment::TYPE_NORMAL, $payment->getType());
    }

    public function testAllowedPaymentTypes()
    {
        $payment = new Payment();

        $rfl = new \ReflectionClass($payment);
        $method = $rfl->getMethod('getAllowedPaymentTypes');

        // method is protected, lets make it accessible for testing purposes
        $method->setAccessible(true);

        $types = $method->invoke($payment);

        $this->assertTrue(is_array($types));
        $this->assertCount(3, $types);
        $this->assertSame($types, array(
            Payment::TYPE_NORMAL,
            Payment::TYPE_BOLETO,
            Payment::TYPE_MOTO,
        ));
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testInvalidType()
    {
        $payment = new Payment();
        $payment->setType('invalid');
    }

    public function testValueType()
    {
        $payment = new Payment();
        $payment->setValue("1.23");

        $this->assertSame(1.23, $payment->getValue());
    }

    public function testMaxValueType()
    {
        $payment = new Payment();
        $payment->setMaxDate("4");

        $this->assertSame(4, $payment->getMaxDate());
    }

    public function testGettersSetters()
    {
        $customerInfo = new CustomerInfo();

        $payment = new Payment();
        $payment->setValue(1.23);
        $payment->setKey('secret');
        $payment->setMaxDate(3);
        $payment->setCustomerInfo($customerInfo);

        $this->assertSame(1.23, $payment->getValue());
        $this->assertSame('secret', $payment->getKey());
        $this->assertSame(3, $payment->getMaxDate());
        $this->assertSame($customerInfo, $payment->getCustomerInfo());
    }

    public function testNoValue()
    {
        $payment = new Payment();

        $this->assertFalse($payment->isValid());
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testNegativeValue()
    {
        $payment = new Payment();
        $payment->setValue(-10);
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testZeroValue()
    {
        $payment = new Payment();
        $payment->setValue(0);
    }

    public function testValidity()
    {
        $payment = new Payment();
        $payment->setValue(10);

        $this->assertTrue($payment->isValid());
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testNegativeMaxDate()
    {
        $payment = new Payment();
        $payment->setMaxDate(-1);
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testZeroMaxDate()
    {
        $payment = new Payment();
        $payment->setMaxDate(0);
    }
}
