<?php

/*
 * This file is part of the easypay-php package.
 *
 * (c) Samuel Gordalina <https://github.com/gordalina/easypay-php>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Gordalina\Easypay\Response;

class PaymentDetail implements ResponseInterface
{
    /**
     * @var string
     */
    protected $cin;

    /**
     * @var string
     */
    protected $user;

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
    protected $key;

    /**
     * @var integer
     */
    protected $epKey;

    /**
     * @var string
     */
    protected $doc;

    /**
     * @var string
     */
    protected $paymentType;

    /**
     * @var float
     */
    protected $valueFixed;

    /**
     * @var float
     */
    protected $valueVariable;

    /**
     * @var float
     */
    protected $valueTax;

    /**
     * @var float
     */
    protected $valueTransfered;

    /**
     * @var \DateTime
     */
    protected $dateTransfered;

    /**
     * @var \DateTime
     */
    protected $dateRead;

    /**
     * @var \DateTime
     */
    protected $date;

    /**
     * @var string
     */
    protected $statusRead;

    /**
     * @var string
     */
    protected $status;

    /**
     * @var string
     */
    protected $message;

    /**
     * @param array $content
     */
    public function __construct(array $content)
    {
        $this->cin = $content['ep_cin'];
        $this->user = $content['ep_user'];
        $this->entity = $content['ep_entity'];
        $this->reference = $content['ep_reference'];
        $this->value = (float) $content['ep_value'];
        $this->key = (int) $content['t_key'];
        $this->status = $content['ep_status'];
        $this->message = $content['ep_message'];

        $this->epKey = $content['ep_key'];
        $this->doc = $content['ep_doc'];
        $this->paymentType = $content['ep_payment_type'];
        $this->valueFixed = (float) $content['ep_value_fixed'];
        $this->valueVariable = (float) $content['ep_value_var'];
        $this->valueTax = (float) $content['ep_value_tax'];
        $this->valueTransfered = (float) $content['ep_value_transf'];
        $this->dateTransfered = new \DateTime($content['ep_date_transf']);
        $this->dateRead = new \DateTime($content['ep_date_read']);
        $this->date = new \DateTime($content['ep_date']);
        $this->statusRead = $content['ep_status_read'];
    }

    /**
     * {@inheritdoc}
     */
    public function isValid()
    {
        return $this->status == 'ok0';
    }

    /**
     * @return string
     */
    public function getCin()
    {
        return $this->cin;
    }

    /**
     * @return string
     */
    public function getUser()
    {
        return $this->user;
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
    public function getKey()
    {
        return $this->key;
    }

    /**
     * @return integer
     */
    public function getEpKey()
    {
        return $this->epKey;
    }

    /**
     * @return string
     */
    public function getDoc()
    {
        return $this->doc;
    }

    /**
     * @return string
     */
    public function getPaymentType()
    {
        return $this->paymentType;
    }

    /**
     * @return float
     */
    public function getValueFixed()
    {
        return $this->valueFixed;
    }

    /**
     * @return float
     */
    public function getValueVariable()
    {
        return $this->valueVariable;
    }

    /**
     * @return float
     */
    public function getValueTax()
    {
        return $this->valueTax;
    }

    /**
     * @return float
     */
    public function getValueTransfered()
    {
        return $this->valueTransfered;
    }

    /**
     * @return \DateTime
     */
    public function getDateTransfered()
    {
        return $this->dateTransfered;
    }

    /**
     * @return \DateTime
     */
    public function getDateRead()
    {
        return $this->dateRead;
    }

    /**
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * @return string
     */
    public function getStatusRead()
    {
        return $this->statusRead;
    }

    /**
     * {@inheritdoc}
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * {@inheritdoc}
     */
    public function getMessage()
    {
        return $this->message;
    }
}
