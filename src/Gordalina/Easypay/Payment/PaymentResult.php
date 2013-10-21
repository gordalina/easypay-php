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

class PaymentResult
{
    /**
     * @var string
     */
    protected $entity;

    /**
     * @var string
     */
    protected $reference;

    /**
     * @var float
     */
    protected $value;

    /**
     * @var string
     */
    protected $authorizationKey;

    /**
     * @var string
     */
    protected $status;

    /**
     * @var string
     */
    protected $key;

    /**
     * @param string $entity
     * @param string $reference
     * @param float  $value
     * @param string $authorizationKey
     * @param string $status
     * @param string $key
     */
    public function __construct(
        $entity,
        $reference,
        $value,
        $authorizationKey,
        $status,
        $key
    ) {
        $this->entity = $entity;
        $this->reference = $reference;
        $this->value = (float) $value;
        $this->authorizationKey = $authorizationKey;
        $this->status = $status;
        $this->key = $key;
    }

    /**
     * Returns a PaymentResult instance from $_GET global
     *
     * @return PaymentResult
     */
    public static function fromGlobals()
    {
        return new static(
            $_GET['e'],
            $_GET['r'],
            $_GET['v'],
            $_GET['k'],
            $_GET['s'],
            $_GET['t_key']
        );
    }

    /**
     * Validate payment information is valid for API call
     *
     * @return boolean
     */
    public function isValid()
    {
        return $this->status === 'ok';
    }

    /**
     * @return string
     */
    public function getEntity()
    {
        return $this->entity;
    }

    /**
     * @return string
     */
    public function getReference()
    {
        return $this->reference;
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
    public function getAuthorizationKey()
    {
        return $this->authorizationKey;
    }

    /**
     * @return string
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @return string
     */
    public function getKey()
    {
        return $this->key;
    }

    /**
     * Return array representation
     *
     * @return array
     */
    public function toArray()
    {
        return array(
            'e' => $this->entity,
            'r' => $this->reference,
            'v' => $this->value,
            'k' => $this->authorizationKey,
            's' => $this->status,
            't_key' => $this->key,
        );
    }
}
