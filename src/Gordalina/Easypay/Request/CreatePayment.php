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
use Gordalina\Easypay\Payment\Payment;
use Gordalina\Easypay\Payment\CustomerInfo;
use Gordalina\Easypay\Response\CreatePayment as CreatePaymentResponse;

class CreatePayment implements RequestInterface
{
    const ENDPOINT = 'api_easypay_01BG.php';

    /**
     * @var Payment
     */
    protected $payment;

    /**
     * @param Payment $payment
     */
    public function __construct(Payment $payment)
    {
        if (!$payment->isValid()) {
            throw new \InvalidArgumentException("Payment is not valid");
        }

        $this->payment = $payment;
    }

    /**
     * @return Payment
     */
    public function getPayment()
    {
        return $this->payment;
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
            'ep_cin' => $config->getCin(),
            'ep_user' => $config->getUser(),
            'ep_entity' => $config->getEntity(),
            'ep_language' => $config->getLanguage(),
            'ep_country' => $config->getCountry(),

            // custom values
            'ep_ref_type' => 'auto',
            't_value' => strval($this->payment->getValue()),
            't_key' => $this->payment->getKey(),
        );
	
        if ($this->payment->getCustomerInfo() instanceof CustomerInfo) {
            $parameters = array_merge($parameters, $this->payment->getCustomerInfo()->toArray());
        }

        // Optional authentication code
        if ($config->getCode()) {
            $parameters['s_code'] = $config->getCode();
        }

        // Optional maximum date for payment acceptance
        if ($this->payment->getMaxDate()){
            $parameters['o_max_date'] = $this->payment->getMaxDate();
            $parameters['ep_partner'] = $config->getUser();
        }

        switch ($this->payment->getType()) {
            case Payment::TYPE_BOLETO:
            case Payment::TYPE_MOTO:
                $parameters['ep_type'] = $this->payment->getType();
            break;
        }

        return $parameters;
    }

    /**
     * {@inheritdoc}
     */
    public function handleResponse($response)
    {
        return new CreatePaymentResponse($response);
    }
}
