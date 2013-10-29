<?php

/*
 * This file is part of the easypay-php package.
 *
 * (c) Samuel Gordalina <https://github.com/gordalina/easypay-php>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Gordalina\Easypay\Tests\Response;

use Gordalina\Easypay\Response\PaymentDetail;

class PaymentDetailTest extends \PHPUnit_Framework_TestCase
{
    public function testGettersSetters()
    {
        $response = new PaymentDetail(array(
            'ep_cin' => '9999',
            'ep_user' => 'USER010101',
            'ep_entity' => '10611',
            'ep_reference' => '999907994',
            'ep_value' => '15.25',
            't_key' => '3',
            'ep_key' => '5',
            'ep_doc' => 'TESTE2515860102158412061588102125',
            'ep_payment_type' => 'MB',
            'ep_value_fixed' => '0.30',
            'ep_value_var' => '3.4',
            'ep_value_tax' => '2.03',
            'ep_value_transf' => '10',
            'ep_date_transf' => '2012-01-02',
            'ep_date_read' => '2012-01-01 14:00:00',
            'ep_status_read' => 'verified',
            'ep_date' => '2012-01-01 10:00:00',
            'ep_status' => 'ok0',
            'ep_message' => 'message',
        ));

        $this->assertTrue($response->isValid());
        $this->assertSame('9999', $response->getCin());
        $this->assertSame('USER010101', $response->getUser());
        $this->assertSame('10611', $response->getEntity());
        $this->assertSame('999907994', $response->getReference());
        $this->assertSame(15.25, $response->getValue());
        $this->assertSame(3, $response->getKey());
        $this->assertSame('5', $response->getEpKey());
        $this->assertSame('TESTE2515860102158412061588102125', $response->getDoc());
        $this->assertSame('MB', $response->getPaymentType());
        $this->assertSame(0.30, $response->getValueFixed());
        $this->assertSame(3.4, $response->getValueVariable());
        $this->assertSame(2.03, $response->getValueTax());
        $this->assertSame(10.0, $response->getValueTransfered());
        $this->assertSame('2012-01-02', $response->getDateTransfered()->format('Y-m-d'));
        $this->assertSame('2012-01-01 14:00:00', $response->getDateRead()->format('Y-m-d H:i:s'));
        $this->assertSame('verified', $response->getStatusRead());
        $this->assertSame('2012-01-01 10:00:00', $response->getDate()->format('Y-m-d H:i:s'));
        $this->assertSame('ok0', $response->getStatus());
        $this->assertSame('message', $response->getMessage());
    }

    public function testInvalid()
    {
        $response = new PaymentDetail(array(
            'ep_cin' => '9999',
            'ep_user' => 'USER010101',
            'ep_entity' => '10611',
            'ep_reference' => '999907994',
            'ep_value' => '15.25',
            't_key' => '3',
            'ep_key' => '5',
            'ep_doc' => 'TESTE2515860102158412061588102125',
            'ep_payment_type' => 'MB',
            'ep_value_fixed' => '0.30',
            'ep_value_var' => '3.4',
            'ep_value_tax' => '2.03',
            'ep_value_transf' => '10',
            'ep_date_transf' => '2012-01-02',
            'ep_date_read' => '2012-01-01 14:00:00',
            'ep_status_read' => 'verified',
            'ep_date' => '2012-01-01 10:00:00',
            'ep_status' => 'err',
            'ep_message' => 'message',
        ));

        $this->assertFalse($response->isValid());
    }
}
