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

class FetchAllPayments extends AbstractResponse implements ResponseInterface
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
     * @var string
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
     * @var string
     */
    protected $valueFixed;

    /**
     * @var string
     */
    protected $valueVariable;

    /**
     * @var string
     */
    protected $valueTax;

    /**
     * @var string
     */
    protected $valueTransfered;

    /**
     * @var string
     */
    protected $dateTransfered;

    /**
     * @var string
     */
    protected $dateRead;

    /**
     * @var string
     */
    protected $statusRead;

    /**
     * @var string
     */
    protected $observations;

    /**
     * @var string
     */
    protected $email;

    /**
     * @var string
     */
    protected $mobile;

    /**
     * @var string
     */
    protected $date;

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
        $this->parse($content, array(
            'ep_cin' => 'cin',
            'ep_user' => 'user',
            'ep_entity' => 'entity',
            'ep_reference' => 'reference',
            'ep_value' => array('value', function ($data) {
                return (float) $data;
            }),
            'ep_status' => 'status',
            'ep_message' => 'message',
            't_key' => array('key', function ($data) {
                return (int) $data;
            }),
            'ep_key' => 'epKey',
            'ep_doc' => 'doc',
            'ep_payment_type' => 'paymentType',
            'ep_value_fixed' => 'valueFixed',
            'ep_value_var' => 'valueVariable',
            'ep_value_tax' => 'valueTax',
            'ep_value_transf' => 'valueTransfered',
            'ep_date_transf' => 'dateTransfered',
            'ep_date_read' => 'dateRead',
            'ep_status_read' => 'statusRead',
            'o_obs' => 'observations',
            'o_email' => 'email',
            'o_mobile' => 'mobile',
            'ep_date' => 'date',
        ));
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
     * @return string
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
     * @return string
     */
    public function getValueFixed()
    {
        return $this->valueFixed;
    }

    /**
     * @return string
     */
    public function getValueVariable()
    {
        return $this->valueVariable;
    }

    /**
     * @return string
     */
    public function getValueTax()
    {
        return $this->valueTax;
    }

    /**
     * @return string
     */
    public function getValueTransfered()
    {
        return $this->valueTransfered;
    }

    /**
     * @return string
     */
    public function getDateTransfered()
    {
        return $this->dateTransfered;
    }

    /**
     * @return string
     */
    public function getDateRead()
    {
        return $this->dateRead;
    }

    /**
     * @return string
     */
    public function getStatusRead()
    {
        return $this->statusRead;
    }

    /**
     * @return string
     */
    public function getObservations()
    {
        return $this->observations;
    }

    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @return string
     */
    public function getMobile()
    {
        return $this->mobile;
    }

    /**
     * @return string
     */
    public function getDate()
    {
        return $this->date;
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
