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

class RequestPayment extends AbstractResponse implements ResponseInterface
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
    protected $key;

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
            'ep_entity' => 'entity',
            'ep_reference' => 'reference',
            'ep_value' => array('value', function ($data) {
                return (float) $data;
            }),
            'ep_key' => 'key',
            'ep_status' => 'status',
            'ep_message' => 'message',
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
