<?php

/*
 * This file is part of the easypay-php package.
 *
 * (c) Samuel Gordalina <https://github.com/gordalina/easypay-php>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Gordalina\Easypay\Tests\Request;

use Gordalina\Easypay\Config;
use Gordalina\Easypay\Payment\Payment;
use Gordalina\Easypay\Payment\CustomerInfo;
use Gordalina\Easypay\Payment\RecurringPayment;
use Gordalina\Easypay\Request\CreateRecurringPayment;

class CreateRecurringPaymentTest extends \PHPUnit_Framework_TestCase
{
    public function testEndpoint()
    {
        $request = $this->getRequest();

        $this->assertSame(CreateRecurringPayment::ENDPOINT, $request->getEndpoint());
    }

    public function testReturnUrl()
    {
        $payment = new RecurringPayment();
        $payment->setValue(10);
        $payment->setFrequency(RecurringPayment::DAILY);

        $request = new CreateRecurringPayment($payment, 'url');

        $this->assertSame('url', $request->getReturnUrl());
    }

    public function testNormal()
    {
        $request = $this->getRequest();
        $params = $request->handleRequest($this->getConfig());

        $this->assertTrue(is_array($params));
        $this->assertCount(10, $params);
        $this->assertSame('cin', $params['ep_cin']);
        $this->assertSame('user', $params['ep_user']);
        $this->assertSame('entity', $params['ep_entity']);
        $this->assertSame('language', $params['ep_language']);
        $this->assertSame('country', $params['ep_country']);
        $this->assertSame('auto', $params['ep_ref_type']);
        $this->assertSame('10', $params['t_value']);
        $this->assertSame('yes', $params['ep_rec']);
        $this->assertSame('1D', $params['ep_rec_freq']);
        $this->assertSame(null, $params['t_key']);
    }

    public function testNormalWithReturnUrl()
    {
        $payment = new RecurringPayment();
        $payment->setValue(10);
        $payment->setFrequency(RecurringPayment::DAILY);

        $request = new CreateRecurringPayment($payment, 'url');
        $params = $request->handleRequest($this->getConfig());

        $this->assertTrue(is_array($params));
        $this->assertCount(11, $params);
        $this->assertSame('cin', $params['ep_cin']);
        $this->assertSame('user', $params['ep_user']);
        $this->assertSame('entity', $params['ep_entity']);
        $this->assertSame('language', $params['ep_language']);
        $this->assertSame('country', $params['ep_country']);
        $this->assertSame('auto', $params['ep_ref_type']);
        $this->assertSame('10', $params['t_value']);
        $this->assertSame('yes', $params['ep_rec']);
        $this->assertSame('1D', $params['ep_rec_freq']);
        $this->assertSame('url', $params['ep_rec_url']);
        $this->assertSame(null, $params['t_key']);
    }

    public function testRecurringBoleto()
    {
        $payment = new RecurringPayment();
        $payment->setValue(10);
        $payment->setFrequency(RecurringPayment::DAILY);
        $payment->setType(Payment::TYPE_BOLETO);

        $request = new CreateRecurringPayment($payment, 'url');
        $params = $request->handleRequest($this->getConfig());

        $this->assertTrue(is_array($params));
        $this->assertCount(11, $params);
        $this->assertSame('cin', $params['ep_cin']);
        $this->assertSame('user', $params['ep_user']);
        $this->assertSame('entity', $params['ep_entity']);
        $this->assertSame('language', $params['ep_language']);
        $this->assertSame('country', $params['ep_country']);
        $this->assertSame('auto', $params['ep_ref_type']);
        $this->assertSame('10', $params['t_value']);
        $this->assertSame('yes', $params['ep_rec']);
        $this->assertSame('1D', $params['ep_rec_freq']);
        $this->assertSame('url', $params['ep_rec_url']);
        $this->assertSame(null, $params['t_key']);
    }

    public function testValidPayment()
    {
        $payment = new RecurringPayment();
        $payment->setValue(10);
        $payment->setFrequency(RecurringPayment::DAILY);

        $request = new CreateRecurringPayment($payment);

        $this->assertSame($payment, $request->getPayment());
    }

    public function testKey()
    {
        $payment = new RecurringPayment();
        $payment->setValue(10);
        $payment->setFrequency(RecurringPayment::DAILY);
        $payment->setKey('key');

        $request = new CreateRecurringPayment($payment);
        $params = $request->handleRequest($this->getConfig());

        $this->assertTrue(is_array($params));
        $this->assertCount(10, $params);
        $this->assertSame('cin', $params['ep_cin']);
        $this->assertSame('user', $params['ep_user']);
        $this->assertSame('entity', $params['ep_entity']);
        $this->assertSame('language', $params['ep_language']);
        $this->assertSame('country', $params['ep_country']);
        $this->assertSame('auto', $params['ep_ref_type']);
        $this->assertSame('10', $params['t_value']);
        $this->assertSame('key', $params['t_key']);
        $this->assertSame('yes', $params['ep_rec']);
        $this->assertSame('1D', $params['ep_rec_freq']);
    }

    public function testCustomerInfo()
    {
        $customerInfo = new CustomerInfo();
        $customerInfo->setName('John Doe')
                     ->setDescription('Payment #1')
                     ->setObservation('test')
                     ->setMobile('800600600')
                     ->setEmail('john@doe.com');

        $payment = new RecurringPayment();
        $payment->setValue(10);
        $payment->setFrequency(RecurringPayment::DAILY);
        $payment->setKey('key');
        $payment->setCustomerInfo($customerInfo);

        $request = new CreateRecurringPayment($payment);
        $params = $request->handleRequest($this->getConfig());

        $this->assertTrue(is_array($params));
        $this->assertCount(15, $params);
        $this->assertSame('cin', $params['ep_cin']);
        $this->assertSame('user', $params['ep_user']);
        $this->assertSame('entity', $params['ep_entity']);
        $this->assertSame('language', $params['ep_language']);
        $this->assertSame('country', $params['ep_country']);
        $this->assertSame('auto', $params['ep_ref_type']);
        $this->assertSame('10', $params['t_value']);
        $this->assertSame('key', $params['t_key']);
        $this->assertSame('yes', $params['ep_rec']);
        $this->assertSame('1D', $params['ep_rec_freq']);
        $this->assertSame('John Doe', $params['o_name']);
        $this->assertSame('Payment #1', $params['o_description']);
        $this->assertSame('test', $params['o_obs']);
        $this->assertSame('800600600', $params['o_mobile']);
        $this->assertSame('john@doe.com', $params['o_email']);
    }

    public function getRequest()
    {
        $payment = new RecurringPayment();
        $payment->setFrequency(RecurringPayment::DAILY);
        $payment->setValue(10);

        return new CreateRecurringPayment($payment);
    }

    public function getConfig()
    {
        return new Config('user', 'entity', 'cin', 'country', 'language');
    }
}
