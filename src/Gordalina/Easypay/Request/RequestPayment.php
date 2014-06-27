<?php

/*
 * This file is part of the easypay-php package.
 *
 * (c) Samuel Gordalina <https://github.com/gordalina/easypay-php>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Gordalina\Easypay\Request;

use Gordalina\Easypay\Config;
use Gordalina\Easypay\Payment\PaymentResult;
use Gordalina\Easypay\Response\RequestPayment as RequestPaymentResponse;

class RequestPayment implements RequestInterface
{
    const ENDPOINT = 'api_easypay_05AG.php';

    /**
     * @var PaymentResult
     */
    protected $paymentResult;

    /**
     * @param PaymentResult $paymentResult
     */
    public function __construct(PaymentResult $paymentResult)
    {
        if (!$paymentResult->isValid()) {
            throw new \InvalidArgumentException("PaymentResult is not valid");
        }

        $this->paymentResult = $paymentResult;
    }

    /**
     * @return PaymentResult
     */
    public function getPaymentResult()
    {
        return $this->paymentResult;
    }

    /**
     * {@inheritdoc}
     */
    public function getEndpoint()
    {
        return static::ENDPOINT;
    }

    /**
     * {@inheritdoc}
     */
    public function handleRequest(Config $config)
    {
        $validParameters = array('e', 'r', 'v', 'k');
        $parameters = $this->paymentResult->toArray();

        foreach ($parameters as $key => $value) {
            if (!in_array($key, $validParameters)) {
                unset($parameters[$key]);
            }
        }

        // Optional authentication code
        $parameters['s_code'] = $config->getCode();

        return $parameters;
    }

    /**
     * {@inheritdoc}
     */
    public function handleResponse($response)
    {
        return new RequestPaymentResponse($response);
    }
}
