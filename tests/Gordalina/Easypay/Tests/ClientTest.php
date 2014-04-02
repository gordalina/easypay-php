<?php

/*
 * This file is part of the easypay-php package.
 *
 * (c) Samuel Gordalina <https://github.com/gordalina/easypay-php>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Gordalina\Easypay\Tests;

use Buzz\Client\FileGetContents;
use Buzz\Message\Response;

use Gordalina\Easypay\Client;
use Gordalina\Easypay\Config;

use Gordalina\Easypay\Tests\Stub\RequestStub;
use Gordalina\Easypay\Tests\Stub\ClientStub;

class ClientTest extends \PHPUnit_Framework_TestCase
{
    public function testConstants()
    {
        $this->assertSame(Client::ENDPOINT_PRODUCTION, 'https://www.easypay.pt');
        $this->assertSame(Client::ENDPOINT_SANDBOX, 'http://test.easypay.pt');
    }

    public function testDefaults()
    {
        $client = new Client($this->getConfig());
        $buzzClient = $this->getBuzzClient($client);

        $this->assertInstanceOf('Buzz\Client\ClientInterface', $buzzClient);
    }

    public function testInjectingClient()
    {
        $client = new Client($this->getConfig(), new FileGetContents());
        $buzzClient = $this->getBuzzClient($client);

        $this->assertInstanceOf('Buzz\Client\FileGetContents', $buzzClient);
    }

    public function testSandbox()
    {
        $client = new Client($this->getConfig());
        $this->assertFalse($client->isSandbox());

        $client->setSandbox(true);
        $this->assertTrue($client->isSandbox());
    }

    public function testNormalizeArray()
    {
        $client = new Client($this->getConfig());

        $rfl = new \ReflectionClass($client);
        $method = $rfl->getMethod('normalizeArray');
        $method->setAccessible(true);

        $xml = <<<EOF
<?xml version="1.0"?>
<root>
    <key>value</key>
    <empty></empty>
    <recursive>
        <key>value</key>
        <empty></empty>
    </recursive>
    <list>
        <item>
            <key>value</key>
        </item>
        <item>
            <key>value</key>
        </item>
    </list>
</root>
EOF;

        $array = (array) simplexml_load_string($xml);
        $array = $method->invoke($client, $array);
        $this->assertTrue(is_array($array));
        $this->assertCount(4, $array);
        $this->assertArrayHasKey('key', $array);
        $this->assertArrayHasKey('empty', $array);
        $this->assertArrayHasKey('recursive', $array);
        $this->assertArrayHasKey('list', $array);
        $this->assertSame('value', $array['key']);
        $this->assertNull($array['empty']);
        $this->assertTrue(is_array($array['recursive']));
        $this->assertTrue(is_array($array['list']));
        $this->assertFalse($array['recursive'] instanceof \SimpleXMLElement);
        $this->assertFalse($array['list'] instanceof \SimpleXMLElement);

        $recursive = $array['recursive'];
        $this->assertCount(2, $recursive);
        $this->assertArrayHasKey('key', $recursive);
        $this->assertArrayHasKey('empty', $recursive);
        $this->assertSame('value', $recursive['key']);
        $this->assertNull($recursive['empty']);

        $list = $array['list'];
        $this->assertCount(1, $list);
        $this->assertArrayHasKey('item', $list);
        $this->assertTrue(is_array($list['item']));
        $this->assertFalse($list['item'] instanceof \SimpleXMLElement);
        $this->assertCount(2, $list['item']);
        $this->assertArrayHasKey(0, $list['item']);
        $this->assertArrayHasKey(1, $list['item']);
        $this->assertTrue(is_array($list['item'][0]));
        $this->assertTrue(is_array($list['item'][1]));
        $this->assertArrayHasKey('key', $list['item'][0]);
        $this->assertArrayHasKey('key', $list['item'][1]);
        $this->assertSame('value', $list['item'][0]['key']);
        $this->assertSame('value', $list['item'][1]['key']);
    }

    public function testGetEndpoint()
    {
        $client = new Client($this->getConfig());

        $rfl = new \ReflectionClass($client);
        $method = $rfl->getMethod('getEndpoint');
        $method->setAccessible(true);

        $this->assertSame(Client::ENDPOINT_PRODUCTION, $method->invoke($client));

        $client->setSandbox(true);

        $this->assertSame(Client::ENDPOINT_SANDBOX, $method->invoke($client));
    }

    public function testRequest()
    {
        $stub = new ClientStub(function ($request, $response) {
            $response->setHeaders(array('HTTP/1.1 200 OK'));
            $response->setContent('<root><status>ok</status></root>');
        });

        $client = new Client($this->getConfig(), $stub);

        $request = new RequestStub();
        $response = $client->request($request);

        $protocolRequest = $stub->getRequest();
        $protocolResponse = $stub->getResponse();

        $this->assertSame('GET', $protocolRequest->getMethod());
        $this->assertSame('/_s/endpoint?param=value', $protocolRequest->getResource());
        $this->assertSame(Client::ENDPOINT_PRODUCTION, $protocolRequest->getHost());

        $this->assertSame(200, $protocolResponse->getStatusCode());
        $this->assertSame('<root><status>ok</status></root>', $protocolResponse->getContent());

        $this->assertTrue($response->isValid());
        $this->assertSame('ok', $response->getStatus());
    }

    public function testUnsuccessfulRequest()
    {
        $stub = new ClientStub(function ($request, $response) {
            $response->setHeaders(array('HTTP/1.1 500 Error'));
            $response->setContent('<root><status>ok</status></root>');
        });

        $client = new Client($this->getConfig(), $stub);

        $request = new RequestStub();
        $response = $client->request($request);

        $this->assertFalse($response);
    }

    public function testErrorRequest()
    {
        $stub = new ClientStub(function ($request, $response) {
            $response->setHeaders(array('HTTP/1.1 200 Ok'));
            $response->setContent('<root><status>err</status></root>');
        });

        $client = new Client($this->getConfig(), $stub);

        $request = new RequestStub();
        $response = $client->request($request);

        $this->assertInstanceOf('Gordalina\Easypay\Response\ResponseInterface', $response);
        $this->assertFalse($response->isValid());
        $this->assertSame('error', $response->getMessage());
    }

    protected function getBuzzClient(Client $client)
    {
        $rfl = new \ReflectionClass($client);
        $property = $rfl->getProperty('client');

        // property is protected, lets make it accessible for testing purposes
        $property->setAccessible(true);

        return $property->getValue($client);
    }

    protected function getConfig()
    {
        return new Config('user', 'entity', 'cin');
    }
}
