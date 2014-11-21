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
use Gordalina\Easypay\Payment\CustomerInfo;
use Gordalina\Easypay\Payment\Payment;
use Gordalina\Easypay\Request\CreatePayment;

class CreatePaymentTest extends \PHPUnit_Framework_TestCase
{
    public function testEndpoint()
    {
        $request = $this->getRequest();

        $this->assertSame(CreatePayment::ENDPOINT, $request->getEndpoint());
    }

    public function testNormal()
    {
        $request = $this->getRequest();
        $params = $request->handleRequest($this->getConfig());

        $this->assertTrue(is_array($params));
        $this->assertCount(8, $params);
        $this->assertSame('cin', $params['ep_cin']);
        $this->assertSame('user', $params['ep_user']);
        $this->assertSame('entity', $params['ep_entity']);
        $this->assertSame('language', $params['ep_language']);
        $this->assertSame('country', $params['ep_country']);
        $this->assertSame('auto', $params['ep_ref_type']);
        $this->assertSame('10', $params['t_value']);
        $this->assertSame(null, $params['t_key']);
        $this->assertArrayNotHasKey('s_code', $params);
    }

    public function testCode()
    {
        $request = $this->getRequest();
        $params = $request->handleRequest($this->getConfig('code'));

        $this->assertTrue(is_array($params));
        $this->assertCount(9, $params);
        $this->assertSame('cin', $params['ep_cin']);
        $this->assertSame('user', $params['ep_user']);
        $this->assertSame('entity', $params['ep_entity']);
        $this->assertSame('language', $params['ep_language']);
        $this->assertSame('country', $params['ep_country']);
        $this->assertSame('auto', $params['ep_ref_type']);
        $this->assertSame('10', $params['t_value']);
        $this->assertSame(null, $params['t_key']);
        $this->assertSame('code', $params['s_code']);
    }

    public function testValidPayment()
    {
        $payment = new Payment();
        $payment->setValue(10);

        $request = new CreatePayment($payment);

        $this->assertSame($payment, $request->getPayment());
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testInvalidPayment()
    {
        $request = new CreatePayment(new Payment());
    }

    public function testKey()
    {
        $payment = new Payment();
        $payment->setValue(10);
        $payment->setKey('key');

        $request = new CreatePayment($payment);
        $params = $request->handleRequest($this->getConfig());

        $this->assertTrue(is_array($params));
        $this->assertCount(8, $params);
        $this->assertSame('cin', $params['ep_cin']);
        $this->assertSame('user', $params['ep_user']);
        $this->assertSame('entity', $params['ep_entity']);
        $this->assertSame('language', $params['ep_language']);
        $this->assertSame('country', $params['ep_country']);
        $this->assertSame('auto', $params['ep_ref_type']);
        $this->assertSame('10', $params['t_value']);
        $this->assertSame('key', $params['t_key']);
    }

    public function testMaxDate()
    {
        $payment = new Payment();
        $payment->setValue(10);
        $payment->setKey('key');
        $payment->setMaxDate('2014-11-21');

        $request = new CreatePayment($payment);
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
        $this->assertSame('2014-11-21', $params['o_max_date']);
        $this->assertSame('user', $params['ep_partner']);
    }

    public function testCustomerInfo()
    {
        $customerInfo = new CustomerInfo();
        $customerInfo->setName('John Doe')
                     ->setDescription('Payment #1')
                     ->setObservation('test')
                     ->setMobile('800600600')
                     ->setEmail('john@doe.com');

        $payment = new Payment();
        $payment->setValue(10);
        $payment->setKey('key');
        $payment->setCustomerInfo($customerInfo);

        $request = new CreatePayment($payment);
        $params = $request->handleRequest($this->getConfig());

        $this->assertTrue(is_array($params));
        $this->assertCount(13, $params);
        $this->assertSame('cin', $params['ep_cin']);
        $this->assertSame('user', $params['ep_user']);
        $this->assertSame('entity', $params['ep_entity']);
        $this->assertSame('language', $params['ep_language']);
        $this->assertSame('country', $params['ep_country']);
        $this->assertSame('auto', $params['ep_ref_type']);
        $this->assertSame('10', $params['t_value']);
        $this->assertSame('key', $params['t_key']);
        $this->assertSame('John Doe', $params['o_name']);
        $this->assertSame('Payment #1', $params['o_description']);
        $this->assertSame('test', $params['o_obs']);
        $this->assertSame('800600600', $params['o_mobile']);
        $this->assertSame('john@doe.com', $params['o_email']);
    }

    public function testBoletoPayment()
    {
        $payment = new Payment();
        $payment->setType(Payment::TYPE_BOLETO);
        $payment->setValue(10);
        $payment->setKey('key');

        $request = new CreatePayment($payment);
        $params = $request->handleRequest($this->getConfig());

        $this->assertTrue(is_array($params));
        $this->assertCount(9, $params);
        $this->assertSame('cin', $params['ep_cin']);
        $this->assertSame('user', $params['ep_user']);
        $this->assertSame('entity', $params['ep_entity']);
        $this->assertSame('language', $params['ep_language']);
        $this->assertSame('country', $params['ep_country']);
        $this->assertSame('auto', $params['ep_ref_type']);
        $this->assertSame('boleto', $params['ep_type']);
        $this->assertSame('10', $params['t_value']);
        $this->assertSame('key', $params['t_key']);
    }

    public function testMotoPayment()
    {
        $payment = new Payment();
        $payment->setType(Payment::TYPE_MOTO);
        $payment->setValue(10);
        $payment->setKey('key');

        $request = new CreatePayment($payment);
        $params = $request->handleRequest($this->getConfig());

        $this->assertTrue(is_array($params));
        $this->assertCount(9, $params);
        $this->assertSame('cin', $params['ep_cin']);
        $this->assertSame('user', $params['ep_user']);
        $this->assertSame('entity', $params['ep_entity']);
        $this->assertSame('language', $params['ep_language']);
        $this->assertSame('country', $params['ep_country']);
        $this->assertSame('auto', $params['ep_ref_type']);
        $this->assertSame('moto', $params['ep_type']);
        $this->assertSame('10', $params['t_value']);
        $this->assertSame('key', $params['t_key']);
    }

    public function testHandleResponseNormal()
    {
        $request = $this->getRequest();
        $response = $request->handleResponse(array(
            'ep_status' => 'ok',
            'ep_message' => 'message',
            'ep_cin' => 'cin',
            'ep_user' => 'user',
            'ep_entity' => 'entity',
            'ep_reference' => 'reference',
            'ep_value' => '10.0',
            't_key' => 'key',
            'ep_link' => 'link',
        ));

        $this->assertInstanceOf('Gordalina\Easypay\Response\CreatePayment', $response);
        $this->assertSame('cin', $response->getCin());
        $this->assertSame('user', $response->getUser());
        $this->assertSame('entity', $response->getEntity());
        $this->assertSame('reference', $response->getReference());
        $this->assertSame(10.0, $response->getValue());
        $this->assertSame('key', $response->getKey());
        $this->assertSame('link', $response->getLink());
        $this->assertSame('ok', $response->getStatus());
        $this->assertSame('message', $response->getMessage());
    }

    public function testHandleResponseBoleto()
    {
        $request = $this->getRequest();
        $response = $request->handleResponse(array(
            'ep_status' => 'ok',
            'ep_message' => 'message',
            'ep_cin' => 'cin',
            'ep_user' => 'user',
            'ep_entity' => 'entity',
            'ep_reference' => 'reference',
            'ep_value' => '10.0',
            't_key' => 'key',
            'ep_link' => 'link',
            'ep_boleto' => 'link2',
        ));

        $this->assertInstanceOf('Gordalina\Easypay\Response\CreatePayment', $response);
        $this->assertSame('cin', $response->getCin());
        $this->assertSame('user', $response->getUser());
        $this->assertSame('entity', $response->getEntity());
        $this->assertSame('reference', $response->getReference());
        $this->assertSame(10.0, $response->getValue());
        $this->assertSame('key', $response->getKey());
        $this->assertSame('link', $response->getLink());
        $this->assertSame('link2', $response->getBoletoLink());
        $this->assertSame('ok', $response->getStatus());
        $this->assertSame('message', $response->getMessage());
    }

    public function getRequest()
    {
        $payment = new Payment();
        $payment->setValue(10);

        return new CreatePayment($payment);
    }

    public function getConfig($code = NULL)
    {
        return new Config('user', 'entity', 'cin', 'country', 'language', $code);
    }
}
