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
use Gordalina\Easypay\Payment\RecurringPayment;

class CreateRecurringPayment extends CreatePayment
{
    const ENDPOINT = 'api_easypay_01BG.php';

    /**
     * @var string
     */
    protected $returnUrl;

    /**
     * @param RecurringPayment $payment
     * @param string           $returnUrl defaults to null
     */
    public function __construct(RecurringPayment $payment, $returnUrl = null)
    {
        parent::__construct($payment);

        $this->returnUrl = $returnUrl;
    }

    /**
     * @return string
     */
    public function getReturnUrl()
    {
        return $this->returnUrl;
    }

    /**
     * {@inheritdoc}
     */
    public function handleRequest(Config $config)
    {
        $parameters = parent::handleRequest($config);

        // If payment is of type boleto, lets unset it
        if ($this->payment->getType() === Payment::TYPE_BOLETO) {
            unset($parameters['ep_type']);
        }

        $parameters = array_merge($parameters, array(
            'ep_rec' => 'yes',
            'ep_rec_freq' => $this->payment->getFrequency(),
        ));

        if ($this->returnUrl) {
            $parameters['ep_rec_url'] = $this->returnUrl;
        }

        return $parameters;
    }
}
