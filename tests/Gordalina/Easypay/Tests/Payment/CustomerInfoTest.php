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

class CustomerInfoTest extends \PHPUnit_Framework_TestCase
{
    public function testToArray()
    {
        $customerInfo = new CustomerInfo();
        $customerInfo->setName('John Doe')
                     ->setDescription('Payment #1')
                     ->setObservation('test')
                     ->setMobile('800600600')
                     ->setEmail('john@doe.com');

        $marshall = $customerInfo->toArray();

        $this->assertTrue(is_array($marshall));
        $this->assertCount(5, array_values($marshall));

        $this->assertEquals('John Doe', $customerInfo->getName());
        $this->assertEquals('John Doe', $marshall['o_name']);

        $this->assertEquals('Payment #1', $customerInfo->getDescription());
        $this->assertEquals('Payment #1', $marshall['o_description']);

        $this->assertEquals('test', $customerInfo->getObservation());
        $this->assertEquals('test', $marshall['o_obs']);

        $this->assertEquals('800600600', $customerInfo->getMobile());
        $this->assertEquals('800600600', $marshall['o_mobile']);

        $this->assertEquals('john@doe.com', $customerInfo->getEmail());
        $this->assertEquals('john@doe.com', $marshall['o_email']);
    }
}
