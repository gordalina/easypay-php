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

use Gordalina\Easypay\Payment\Payment;
use Gordalina\Easypay\Request\CreatePayment;

class CreatePaymentTest extends IntegrationTestCase
{
    /**
     * @group integration
     */
    public function testCreatePaymentNormal()
    {
        $payment = new Payment();
        $payment->setValue(12);

        $request = new CreatePayment($payment);
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
    }

    /**
     * @group integration
     */
    public function testCreatePaymentBoleto()
    {
        $payment = new Payment();
        $payment->setType(Payment::TYPE_BOLETO);
        $payment->setValue(12);

        $request = new CreatePayment($payment);
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
        $this->assertRegExp('#https?://(test\.|www\.)?easypay.pt/_s/.*#', $response->getBoletoLink());
    }

    /**
     * @group integration
     */
    public function testCreatePaymentMoto()
    {
        $payment = new Payment();
        $payment->setType(Payment::TYPE_MOTO);
        $payment->setValue(12);

        $request = new CreatePayment($payment);
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
    }

    /**
     * @group integration
     */
    public function testCreatePaymentWithKey()
    {
        $payment = new Payment();
        $payment->setValue(12);
        $payment->setKey('secret');

        $request = new CreatePayment($payment);
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
        $this->assertSame($payment->getKey(), $response->getKey());
    }
}
