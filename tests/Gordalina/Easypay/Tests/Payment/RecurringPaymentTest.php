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

use Gordalina\Easypay\Payment\RecurringPayment;

class RecurringPaymentTest extends \PHPUnit_Framework_TestCase
{
    public function testConstants()
    {
        $this->assertSame('1D', RecurringPayment::DAILY);
        $this->assertSame('1W', RecurringPayment::WEEKLY);
        $this->assertSame('2W', RecurringPayment::SEMIMONTHLY);
        $this->assertSame('1M', RecurringPayment::MONTHLY);
        $this->assertSame('2M', RecurringPayment::BIMONTHLY);
        $this->assertSame('3M', RecurringPayment::QUATERLY);
        $this->assertSame('4M', RecurringPayment::EVERY_4_MONTHS);
        $this->assertSame('6M', RecurringPayment::SEMIANNUAL);
        $this->assertSame('1Y', RecurringPayment::ANNUAL);
    }

    public function testAllowedFrequencies()
    {
        $payment = new RecurringPayment();

        $rfl = new \ReflectionClass($payment);
        $method = $rfl->getMethod('getAllowedPaymentFrequencies');

        // method is protected, lets make it accessible for testing purposes
        $method->setAccessible(true);

        $types = $method->invoke($payment);

        $this->assertTrue(is_array($types));
        $this->assertCount(9, $types);
        $this->assertSame($types, array(
            RecurringPayment::DAILY,
            RecurringPayment::WEEKLY,
            RecurringPayment::SEMIMONTHLY,
            RecurringPayment::MONTHLY,
            RecurringPayment::BIMONTHLY,
            RecurringPayment::QUATERLY,
            RecurringPayment::EVERY_4_MONTHS,
            RecurringPayment::SEMIANNUAL,
            RecurringPayment::ANNUAL,
        ));
    }

    public function testValidFrequency()
    {
        $payment = new RecurringPayment();
        $payment->setFrequency(RecurringPayment::DAILY);

        $this->assertSame(RecurringPayment::DAILY, $payment->getFrequency());
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testInvalidFrequency()
    {
        $payment = new RecurringPayment();
        $payment->setFrequency('invalid');
    }

    public function testNotValid()
    {
        $payment = new RecurringPayment();
        $this->assertFalse($payment->isValid());
    }

    public function testValid()
    {
        $payment = new RecurringPayment();
        $payment->setValue(10);
        $payment->setFrequency(RecurringPayment::DAILY);

        $this->assertTrue($payment->isValid());
    }
}
