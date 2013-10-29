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

class PaymentNotification
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
    protected $doc;

    /**
     * @var string
     */
    protected $type;

    /**
     * @param string $cin
     * @param string $user
     * @param string $doc
     * @param string $type
     */
    public function __construct($cin, $user, $doc, $type)
    {
        $this->cin = $cin;
        $this->user = $user;
        $this->doc = $doc;
        $this->type = $type;
    }

    /**
     * @return  string
     */
    public function getCin()
    {
        return $this->cin;
    }

    /**
     * @return  string
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @return  string
     */
    public function getDoc()
    {
        return $this->doc;
    }

    /**
     * @return  string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @return PaymentNotification
     */
    public static function fromGlobals()
    {
        return new static(
            $_GET['ep_cin'],
            $_GET['ep_user'],
            $_GET['ep_doc'],
            $_GET['ep_type']
        );
    }

    /**
     * @see https://docs.easypay.pt/?workflow=notification
     *
     * @param  integer $key
     * @return string
     */
    public function getXmlResponse($key)
    {
        $xml =<<<EOF
<!--?xml version="1.0" encoding="ISO-8859-1"?-->
<getautomb_key>
    <ep_status>ok0</ep_status>
    <ep_message>generated document</ep_message>
    <ep_cin>%s</ep_cin>
    <ep_user>%s</ep_user>
    <ep_doc>%s</ep_doc>
    <ep_key>%s</ep_key>
</getautomb_key>
EOF;

        return trim(sprintf($xml, $this->cin, $this->user, $this->doc, $key));
    }
}
