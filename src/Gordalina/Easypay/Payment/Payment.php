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

class Payment
{
    const TYPE_NORMAL = 'normal';
    const TYPE_BOLETO = 'boleto';
    const TYPE_MOTO = 'moto';

    /**
     * @var float
     */
    protected $value;

    /**
     * @var string
     */
    protected $key;

    /**
     * @var string
     */
    protected $type = self::TYPE_NORMAL;

    /**
     * @var CustomerInfo
     */
    protected $customerInfo;

    /**
     * Validate payment information is valid for API call
     *
     * @return boolean
     */
    public function isValid()
    {
        return $this->value !== null
                && $this->type !== null;
    }

    /**
     * @param string $key
     */
    public function setKey($key)
    {
        $this->key = $key;
    }

    /**
     * @param float $value
     */
    public function setValue($value)
    {
        $value = (float) $value;

        if ($value <= 0.0) {
            throw new \InvalidArgumentException("Value must be greater than 0.0");
        }

        $this->value = $value;
    }

    /**
     * @param  string                    $type
     * @throws \InvalidArgumentException If type is not one of:
     *                                      Payment::TYPE_NORMAL
     *                                      Payment::TYPE_BOLETO
     *                                      Payment::TYPE_MOTO
     */
    public function setType($type)
    {
        $allowedTypes = $this->getAllowedPaymentTypes();

        if (!in_array($type, $allowedTypes)) {
            throw new \InvalidArgumentException(
                sprintf("Type is not one of %s", implode(', ', $allowedTypes))
            );
        }

        $this->type = $type;
    }

    /**
     * @param CustomerInfo $customerInfo
     */
    public function setCustomerInfo(CustomerInfo $customerInfo)
    {
        $this->customerInfo = $customerInfo;
    }

    /**
     * @return float
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @return string
     */
    public function getKey()
    {
        return $this->key;
    }

    /**
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @return CustomerInfo
     */
    public function getCustomerInfo()
    {
        return $this->customerInfo;
    }

    /**
     * Returns an array of valid payment references types
     *
     * @return array
     */
    protected function getAllowedPaymentTypes()
    {
        return array(
            static::TYPE_NORMAL,
            static::TYPE_BOLETO,
            static::TYPE_MOTO,
        );
    }
}
