# Easypay-PHP

[![Build Status](https://img.shields.io/travis/gordalina/easypay-php.svg)](https://travis-ci.org/gordalina/easypay-php)
[![Scrutinizer Quality Score](https://img.shields.io/scrutinizer/g/gordalina/easypay-php.svg)](https://scrutinizer-ci.com/g/gordalina/easypay-php/)
[![Code Coverage](https://img.shields.io/scrutinizer/coverage/g/gordalina/easypay-php.svg)](https://scrutinizer-ci.com/g/gordalina/easypay-php/)
[![SensioLabs Insight](https://img.shields.io/sensiolabs/i/51d49507-e75e-48e3-8e33-0c161212e830.svg)](https://insight.sensiolabs.com/projects/51d49507-e75e-48e3-8e33-0c161212e830)
[![Codacy Badge](https://img.shields.io/codacy/5c388aedeea8ce7fd9b67c6f371ac1ad.svg)](https://www.codacy.com/public/gordalina/easypayphp)

This library provides a simple API to communicate with [Easypay](http://easypay.pt/)

# Installing via Composer

The recommended way to install is through [Composer](http://composer.org).

```sh
# Install Composer
$ curl -sS https://getcomposer.org/installer | php

# Add easypay-php as a dependency
$ php composer.phar require gordalina/easypay-php:~1.0
```

After installing, you need to require Composer's autoloader:

```php
require 'vendor/autoload.php';
```

# Testing

This library uses [PHPUnit](https://github.com/sebastianbergmann/phpunit).
In order to run the unit tests, you'll first need to install the development
dependencies of the project using Composer:

```sh
$ php composer.phar install --dev
```

You can then run the tests using phpunit

```sh
$ bin/phpunit
```

If you want to run integration tests you have to copy `phpunit.xml.dist` to
`phpunit.xml` then insert your credentials and set `EASYPAY_RUN_INTEGRATION_TESTS`
to `true`.

Then run phpunit

```sh
$ bin/phpunit --exclude-group none
```

# License

This library is under the MIT License, see the complete license [here](LICENSE)
