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
use Gordalina\Easypay\Request\FetchAllPayments;

class FetchAllPaymentsTest extends \PHPUnit_Framework_TestCase
{
    public function testEndpoint()
    {
        $request = new FetchAllPayments();

        $this->assertSame(FetchAllPayments::ENDPOINT, $request->getEndpoint());
    }

    public function testNormal()
    {
        $request = new FetchAllPayments();
        $params = $request->handleRequest($this->getConfig());

        $this->assertTrue(is_array($params));
        $this->assertCount(5, $params);
        $this->assertSame('cin', $params['ep_cin']);
        $this->assertSame('user', $params['ep_user']);
        $this->assertSame('entity', $params['ep_entity']);
        $this->assertSame('language', $params['ep_language']);
        $this->assertSame('country', $params['ep_country']);
    }

    public function testFilter()
    {
        $request = new FetchAllPayments();
        $request->setFilter('date');
        $request->setStartDate('2013-01-01');
        $request->setStartDate('2014-01-01');

        $params = $request->handleRequest($this->getConfig());

        $this->assertTrue(is_array($params));
        $this->assertCount(7, $params);
        $this->assertSame('cin', $params['ep_cin']);
        $this->assertSame('user', $params['ep_user']);
        $this->assertSame('entity', $params['ep_entity']);
        $this->assertSame('language', $params['ep_language']);
        $this->assertSame('country', $params['ep_country']);
    }

    public function testHandleResponseNormal()
    {
        $request = new FetchAllPayments();
        $response = $request->handleResponse(array(
            'ep_status' => 'ok',
            'ep_message' => 'message',
            'ep_cin' => 'cin',
            'ep_user' => 'user',
            'ep_entity' => 'entity',
            'ep_reference' => 'reference',
            'ep_value' => '10.0',
            't_key' => '10.0',
            'ep_key' => 'key',
            'ep_doc' => 'doc',
            'ep_payment_type' => 'paymentType',
            'ep_value_fixed' => 'valueFixed',
            'ep_value_var' => 'valueVariable',
            'ep_value_tax' => 'valueTax',
            'ep_value_transf' => 'valueTransfered',
            'ep_date_transf' => 'dateTransfered',
            'ep_date_read' => 'dateRead',
            'ep_status_read' => 'statusRead',
            'o_obs' => 'observations',
            'o_email' => 'email',
            'o_mobile' => 'mobile',
            'ep_date' => 'date',
        ));

        $this->assertInstanceOf('Gordalina\Easypay\Response\FetchAllPayments', $response);
        $this->assertSame('cin', $response->getCin());
        $this->assertSame('user', $response->getUser());
        $this->assertSame('entity', $response->getEntity());
        $this->assertSame('reference', $response->getReference());
        $this->assertSame(10.0, $response->getValue());
        $this->assertSame(10, $response->getKey());
        $this->assertSame('key', $response->getEpKey());
        $this->assertSame('doc', $response->getDoc());
        $this->assertSame('paymentType', $response->getPaymentType());
        $this->assertSame('valueFixed', $response->getValueFixed());
        $this->assertSame('valueVariable', $response->getValueVariable());
        $this->assertSame('valueTax', $response->getValueTax());
        $this->assertSame('valueTransfered', $response->getValueTransfered());
        $this->assertSame('dateTransfered', $response->getDateTransfered());
        $this->assertSame('dateRead', $response->getDateRead());
        $this->assertSame('statusRead', $response->getStatusRead());
        $this->assertSame('observations', $response->getObservations());
        $this->assertSame('email', $response->getEmail());
        $this->assertSame('mobile', $response->getMobile());
        $this->assertSame('date', $response->getDate());
        $this->assertSame('ok', $response->getStatus());
        $this->assertSame('message', $response->getMessage());
    }

    public function getConfig()
    {
        return new Config('user', 'entity', 'cin', 'country', 'language');
    }
}
