<?php

/*
 * This file is part of the easypay-php package.
 *
 * (c) Samuel Gordalina <https://github.com/gordalina/easypay-php>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Gordalina\Easypay\Tests\Integration;

use Gordalina\Easypay\Payment\RecurringPayment;
use Gordalina\Easypay\Request\CreateRecurringPayment;

class CreateRecurringPaymentTest extends IntegrationTestCase
{
    /**
     * @group integration
     */
    public function testCreatePayment()
    {
        $payment = new RecurringPayment();
        $payment->setValue(12);
        $payment->setFrequency(RecurringPayment::DAILY);

        $request = new CreateRecurringPayment($payment);
        $response = $this->getClient()->request($request);

        $this->assertTrue($response->isValid());

        $this->assertSame('ok0', $response->getStatus());
        $this->assertStringStartsWith('ep_country and ep_entity and ep_user and ep_cin ok', $response->getMessage());
        $this->assertSame($this->getConfig()->getCin(), $response->getCin());
        $this->assertSame($this->getConfig()->getUser(), $response->getUser());
        $this->assertSame($this->getConfig()->getEntity(), $response->getEntity());
        $this->assertTrue($response->getReference() != null);
        $this->assertSame($payment->getValue(), $response->getValue());
        $this->assertSame($payment->getKey(), $response->getKey());
        $this->assertRegExp('#https?://(test\.|www\.)?easypay.pt/_s/.*#', $response->getLink());
        $this->assertRegExp('#https?://(test\.|www\.)?easypay.pt/_s/.*#', $response->getCreditCardLink());
        $this->assertRegExp('#https?://(test\.|www\.)?easypay.pt/_s/.*#', $response->getDirectDebitLink());
        $this->assertSame($payment->getFrequency(), $response->getFrequency());
        $this->assertRegExp('/[A-F0-9]+/', $response->getK1());
    }
}
