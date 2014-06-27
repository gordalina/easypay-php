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
use Gordalina\Easypay\Payment\PaymentNotification;
use Gordalina\Easypay\Response\PaymentDetail as PaymentDetailResponse;

class PaymentDetail implements RequestInterface
{
    const ENDPOINT = 'api_easypay_03AG.php';

    /**
     * @var PaymentNotification
     */
    protected $paymentNotification;

    /**
     * @param PaymentNotification $paymentNotification
     */
    public function __construct(PaymentNotification $paymentNotification)
    {
        $this->paymentNotification = $paymentNotification;
    }

    /**
     * @return PaymentNotification
     */
    public function getPaymentNotification()
    {
        return $this->paymentNotification;
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
        $parameters = array(
            'ep_cin' => $this->paymentNotification->getCin(),
            'ep_user' => $this->paymentNotification->getUser(),
            'ep_doc' => $this->paymentNotification->getDoc(),
            'ep_type' => $this->paymentNotification->getType(),
        );

        // Optional authentication code
        if (!empty($config->getCode())) {
            $parameters['s_code'] = $config->getCode();
        }

        return $parameters;
    }

    /**
     * {@inheritdoc}
     */
    public function handleResponse($response)
    {
        return new PaymentDetailResponse($response);
    }
}
