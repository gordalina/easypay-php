<?php

/*
 * This file is part of the easypay-php package.
 *
 * (c) Samuel Gordalina <https://github.com/gordalina/easypay-php>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Gordalina\Easypay\Payment;

class RecurringPayment extends Payment
{
    const DAILY = '1D';
    const WEEKLY = '1W';
    const SEMIMONTHLY = '2W';
    const MONTHLY = '1M';
    const BIMONTHLY = '2M';
    const QUATERLY = '3M';
    const EVERY_4_MONTHS = '4M';
    const SEMIANNUAL = '6M';
    const ANNUAL = '1Y';

    /**
     * @var string
     */
    protected $frequency;

    /**
     * @return string
     */
    public function getFrequency()
    {
        return $this->frequency;
    }

    /**
     * @param  string                   $frequency
     * @throws InvalidArgumentException If frequency is not one of:
     *                                      RecurringPayment::DAILY
     *                                      RecurringPayment::WEEKLY
     *                                      RecurringPayment::SEMIMONTHLY
     *                                      RecurringPayment::MONTHLY
     *                                      RecurringPayment::BIMONTHLY
     *                                      RecurringPayment::QUATERLY
     *                                      RecurringPayment::EVERY_4_MONTHS
     *                                      RecurringPayment::SEMIANNUAL
     *                                      RecurringPayment::ANNUAL
     */
    public function setFrequency($frequency)
    {
        $allowedFrequencies = $this->getAllowedPaymentFrequencies();

        if (!in_array($frequency, $allowedFrequencies)) {
            throw new \InvalidArgumentException(
                sprintf("Type is not one of %s", implode(', ', $allowedFrequencies))
            );
        }

        $this->frequency = $frequency;
    }

    /**
     * {@inheritdoc}
     */
    public function isValid()
    {
        return !is_null($this->frequency) && parent::isValid();
    }

    /**
     * Returns an array of valid payment frequencies
     *
     * @return array
     */
    protected function getAllowedPaymentFrequencies()
    {
        return array(
            static::DAILY,
            static::WEEKLY,
            static::SEMIMONTHLY,
            static::MONTHLY,
            static::BIMONTHLY,
            static::QUATERLY,
            static::EVERY_4_MONTHS,
            static::SEMIANNUAL,
            static::ANNUAL,
        );
    }
}
