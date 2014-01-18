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

class PaymentDetail extends AbstractResponse implements ResponseInterface
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
        $this->parse($content, array(
            'ep_cin' => 'cin',
            'ep_user' => 'user',
            'ep_entity' => 'entity',
            'ep_reference' => 'reference',
            'ep_value' => array('value', function ($data) {
                return (float) $data;
            }),
            't_key' => array('key', function ($data) {
                return (int) $data;
            }),
            'ep_status' => 'status',
            'ep_message' => 'message',

            'ep_key' => 'epKey',
            'ep_doc' => 'doc',
            'ep_payment_type' => 'paymentType',
            'ep_value_fixed' => array('valueFixed', function ($data) {
                return (float) $data;
            }),
            'ep_value_var' => array('valueVariable', function ($data) {
                return (float) $data;
            }),
            'ep_value_tax' => array('valueTax', function ($data) {
                return (float) $data;
            }),
            'ep_value_transf' => array('valueTransfered', function ($data) {
                return (float) $data;
            }),
            'ep_date_transf' => array('dateTransfered', function ($data) {
                return new \DateTime($data);
            }),
            'ep_date_read' => array('dateRead', function ($data) {
                return new \DateTime($data);
            }),
            'ep_date' => array('date', function ($data) {
                return new \DateTime($data);
            }),
            'ep_status_read' => 'statusRead',
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
