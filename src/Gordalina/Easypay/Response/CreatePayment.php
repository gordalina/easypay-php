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

class CreatePayment implements ResponseInterface
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
    protected $link;

    /**
     * @var string
     */
    protected $boletoLink;

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
        $this->key = $content['t_key'];
        $this->link = $content['ep_link'];
        $this->status = $content['ep_status'];
        $this->message = $content['ep_message'];

        if (isset($content['ep_boleto_link'])) {
            $this->boletoLink = $content['ep_boleto_link'];
        }
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
    public function getLink()
    {
        return $this->link;
    }

    /**
     * @return string
     */
    public function getBoletoLink()
    {
        return $this->boletoLink;
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
    public function getMessage()
    {
        return $this->message;
    }
}
