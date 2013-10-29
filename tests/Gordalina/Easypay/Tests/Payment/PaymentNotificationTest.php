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

use Gordalina\Easypay\Payment\PaymentNotification;

class PaymentNotificationTest extends \PHPUnit_Framework_TestCase
{
    public function testConstructorGettersSetters()
    {
        $notification = new PaymentNotification('cin', 'user', 'doc', 'type');

        $this->assertSame('cin', $notification->getCin());
        $this->assertSame('user', $notification->getUser());
        $this->assertSame('doc', $notification->getDoc());
        $this->assertSame('type', $notification->getType());
    }

    public function testFromGlobals()
    {
        global $_GET;

        $_GET = array(
            'ep_cin' => 'cin',
            'ep_user' => 'user',
            'ep_doc' => 'doc',
            'ep_type' => 'type',
        );

        $notification = PaymentNotification::fromGlobals();

        $this->assertSame('cin', $notification->getCin());
        $this->assertSame('user', $notification->getUser());
        $this->assertSame('doc', $notification->getDoc());
        $this->assertSame('type', $notification->getType());
    }

    public function testXmlResponse()
    {
        $notification = new PaymentNotification('cin', 'user', 'doc', 'type');

        $expectedXml = <<<EOF
<!--?xml version="1.0" encoding="ISO-8859-1"?-->
<getautomb_key>
    <ep_status>ok0</ep_status>
    <ep_message>generated document</ep_message>
    <ep_cin>cin</ep_cin>
    <ep_user>user</ep_user>
    <ep_doc>doc</ep_doc>
    <ep_key>3</ep_key>
</getautomb_key>
EOF;
        $expectedXml = trim($expectedXml);
        $xml = $notification->getXmlResponse(3);
        $this->assertSame($expectedXml, $xml);
    }

    public function testXmlResponseValidity()
    {
        if (!extension_loaded('simplexml')) {
            $this->markTestSkipped('The SimpleXML extension is not available');
        }

        $notification = new PaymentNotification('cin', 'user', 'doc', 'type');
        $xml = $notification->getXmlResponse(3);

        $simpleXml = simplexml_load_string($xml);

        $this->assertSame(6, $simpleXml->count());
        $this->assertSame('getautomb_key', $simpleXml->getName());
        $this->assertSame('ok0', (string) $simpleXml->ep_status);
        $this->assertSame('generated document', (string) $simpleXml->ep_message);
        $this->assertSame('cin', (string) $simpleXml->ep_cin);
        $this->assertSame('user', (string) $simpleXml->ep_user);
        $this->assertSame('doc', (string) $simpleXml->ep_doc);
        $this->assertSame('3', (string) $simpleXml->ep_key);
    }
}
