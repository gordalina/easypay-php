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

class CreateRecurringPayment extends CreatePayment implements ResponseInterface
{
    /**
     * @var string
     */
    protected $creditCardLink;

    /**
     * @var string
     */
    protected $directDebitLink;

    /**
     * @var string
     */
    protected $k1;

    /**
     * @var string
     */
    protected $frequency;

    /**
     * @param array $content
     */
    public function __construct(array $content)
    {
        parent::__construct($content);

        $this->creditCardLink = $content['ep_link_rp_cc'];
        $this->directDebitLink = $content['ep_link_rp_dd'];
        $this->k1 = $content['ep_k1'];
        $this->frequency = $content['ep_periodicity'];
    }

    /**
     * @return string
     */
    public function getCreditCardLink()
    {
        return $this->creditCardLink;
    }

    /**
     * @return string
     */
    public function getDirectDebitLink()
    {
        return $this->directDebitLink;
    }

    /**
     * @return string
     */
    public function getK1()
    {
        return $this->k1;
    }

    /**
     * @return string
     */
    public function getFrequency()
    {
        return $this->frequency;
    }
}
