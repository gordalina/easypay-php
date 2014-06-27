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
        $this->assertArrayNotHasKey('s_code', $params);
    }

    public function testCode()
    {
        $request = new FetchAllPayments();
        $params = $request->handleRequest($this->getConfig('code'));

        $this->assertTrue(is_array($params));
        $this->assertCount(6, $params);
        $this->assertSame('cin', $params['ep_cin']);
        $this->assertSame('user', $params['ep_user']);
        $this->assertSame('entity', $params['ep_entity']);
        $this->assertSame('language', $params['ep_language']);
        $this->assertSame('country', $params['ep_country']);
        $this->assertSame('code', $params['s_code']);
    }

    public function testFilter()
    {
        $request = new FetchAllPayments();
        $request->setFilter('date');
        $request->setStartDate('2013-01-01');
        $request->setEndDate('2014-01-01');

        $params = $request->handleRequest($this->getConfig());

        $this->assertTrue(is_array($params));
        $this->assertCount(8, $params);
        $this->assertSame('cin', $params['ep_cin']);
        $this->assertSame('user', $params['ep_user']);
        $this->assertSame('entity', $params['ep_entity']);
        $this->assertSame('language', $params['ep_language']);
        $this->assertSame('country', $params['ep_country']);
        $this->assertSame('2013-01-01', $params['o_ini']);
        $this->assertSame('2014-01-01', $params['o_last']);
        $this->assertSame('date', $params['ep_list_type']);
    }

    public function testHandleResponseNormal()
    {
        $request = new FetchAllPayments();
        $response = $request->handleResponse(array(
            'ep_status' => 'ok0',
            'ep_message' => 'message',
            'ep_num_records' => 1,
            'ref_detail' => array(
                'ref' => array(
                    array(
                        'ep_cin' => 'cin',
                        'ep_user' => 'user',
                        'ep_entity' => 'entity',
                        'ep_reference' => 'reference',
                        'ep_value' => '10.0',
                        't_key' => '10.0',
                        'ep_key' => '10.0',
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
                    ),
                ),
            ),
        ));

        $this->assertInstanceOf('Gordalina\Easypay\Response\FetchAllPayments', $response);
        $this->assertTrue($response->isValid());
        $this->assertSame('ok0', $response->getStatus());
        $this->assertSame('message', $response->getMessage());
        $this->assertSame(1, $response->getRecordCount());

        $payments = $response->getRecords();
        $this->assertTrue(is_array($payments));

        foreach ($payments as $payment) {
            $this->assertInstanceOf('Gordalina\Easypay\Payment\PaymentComplete', $payment);
            $this->assertSame('cin', $payment->getCin());
            $this->assertSame('user', $payment->getUser());
            $this->assertSame('entity', $payment->getEntity());
            $this->assertSame('reference', $payment->getReference());
            $this->assertSame(10.0, $payment->getValue());
            $this->assertSame('10.0', $payment->getKey());
            $this->assertSame(10, $payment->getEpKey());
            $this->assertSame('doc', $payment->getDoc());
            $this->assertSame('paymentType', $payment->getPaymentType());
            $this->assertSame('valueFixed', $payment->getValueFixed());
            $this->assertSame('valueVariable', $payment->getValueVariable());
            $this->assertSame('valueTax', $payment->getValueTax());
            $this->assertSame('valueTransfered', $payment->getValueTransfered());
            $this->assertSame('dateTransfered', $payment->getDateTransfered());
            $this->assertSame('dateRead', $payment->getDateRead());
            $this->assertSame('statusRead', $payment->getStatusRead());
            $this->assertSame('observations', $payment->getObservations());
            $this->assertSame('email', $payment->getEmail());
            $this->assertSame('mobile', $payment->getMobile());
            $this->assertSame('date', $payment->getDate());
        }
    }


    public function testHandleResponseNoPayments()
    {
        $request = new FetchAllPayments();
        $response = $request->handleResponse(array(
            'ep_status' => 'ok0',
            'ep_message' => 'message',
            'ep_num_records' => 0,
            'ref_detail' => array(
                'ref' => array()
            ),
        ));

        $this->assertInstanceOf('Gordalina\Easypay\Response\FetchAllPayments', $response);
        $this->assertTrue($response->isValid());
        $this->assertSame('ok0', $response->getStatus());
        $this->assertSame('message', $response->getMessage());
        $this->assertSame(0, $response->getRecordCount());

        $this->assertTrue(is_array($response->getRecords()));
        $this->assertCount(0, $response->getRecords());
    }

    public function getConfig($code = NULL)
    {
        return new Config('user', 'entity', 'cin', 'country', 'language', $code);
    }
}
