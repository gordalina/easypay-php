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

use Gordalina\Easypay\Client;
use Gordalina\Easypay\Config;

class IntegrationTestCase extends \PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        if (EASYPAY_RUN_INTEGRATION_TESTS === false) {
            $this->markTestSkipped('Integration tests are not enabled');
        }
    }

    protected function getClient()
    {
        $client = new Client($this->getConfig());
        $client->setSandbox(true);

        return $client;
    }

    protected function getConfig()
    {

        return new Config(
            EASYPAY_CONFIG_USER,
            EASYPAY_CONFIG_ENTITY,
            EASYPAY_CONFIG_CIN
        );
    }
}
