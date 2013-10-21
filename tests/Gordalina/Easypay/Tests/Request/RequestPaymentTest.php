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
use Gordalina\Easypay\Payment\PaymentResult;
use Gordalina\Easypay\Request\RequestPayment;

class RequestPaymentTest extends \PHPUnit_Framework_TestCase
{
    public function testEndpoint()
    {
        $request = $this->getRequest();

        $this->assertSame(RequestPayment::ENDPOINT, $request->getEndpoint());
    }

    public function testConstructor()
    {
        $paymentResult = new PaymentResult(
            'entity',
            'reference',
            1.23,
            'authorizationKey',
            'ok',
            'key'
        );

        $request = new RequestPayment($paymentResult);
        $this->assertSame($paymentResult, $request->getPaymentResult());
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testInvalidConstructor()
    {
        $paymentResult = new PaymentResult(
            'entity',
            'reference',
            1.23,
            'authorizationKey',
            'err',
            'key'
        );

        $request = new RequestPayment($paymentResult);
    }

    public function testHandleRequest()
    {
        $request = $this->getRequest();
        $params = $request->handleRequest($this->getConfig());

        $this->assertTrue(is_array($params));
        $this->assertCount(4, $params);
        $this->assertSame('entity', $params['e']);
        $this->assertSame('reference', $params['r']);
        $this->assertSame(1.23, $params['v']);
        $this->assertSame('authorizationKey', $params['k']);
    }

    public function testHandleResponse()
    {
        $request = $this->getRequest();
        $response = $request->handleResponse(array(
            'ep_status' => 'ok',
            'ep_message' => 'message',
            'ep_entity' => 'entity',
            'ep_reference' => 'reference',
            'ep_value' => '10.0',
            'ep_key' => 'key',
        ));

        $this->assertInstanceOf('Gordalina\Easypay\Response\RequestPayment', $response);
        $this->assertSame('entity', $response->getEntity());
        $this->assertSame('reference', $response->getReference());
        $this->assertSame(10.0, $response->getValue());
        $this->assertSame('key', $response->getKey());
        $this->assertSame('ok', $response->getStatus());
        $this->assertSame('message', $response->getMessage());
    }

    public function getRequest()
    {
        $paymentResult = new PaymentResult(
            'entity',
            'reference',
            1.23,
            'authorizationKey',
            'ok',
            'key'
        );

        return new RequestPayment($paymentResult);
    }

    public function getConfig()
    {
        return new Config('user', 'entity', 'cin', 'country', 'language');
    }
}
