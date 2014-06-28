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

use Gordalina\Easypay\Config;

class ConfigTest extends \PHPUnit_Framework_TestCase
{
    public function testConstructor()
    {
        $config = new Config('user', 'entity', 'cin', 'ES', 'ES', 'code');

        $this->assertSame('user', $config->getUser());
        $this->assertSame('entity', $config->getEntity());
        $this->assertSame('cin', $config->getCin());
        $this->assertSame('ES', $config->getCountry());
        $this->assertSame('ES', $config->getLanguage());
        $this->assertSame('code', $config->getCode());
    }

    public function testDefaults()
    {
        $config = new Config('user', 'entity', 'cin');

        $this->assertSame('user', $config->getUser());
        $this->assertSame('entity', $config->getEntity());
        $this->assertSame('cin', $config->getCin());
        $this->assertSame('PT', $config->getCountry());
        $this->assertSame('PT', $config->getLanguage());
        $this->assertNull($config->getCode());
    }
}
