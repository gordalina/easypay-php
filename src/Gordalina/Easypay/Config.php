<?php

/*
 * This file is part of the easypay-php package.
 *
 * (c) Samuel Gordalina <https://github.com/gordalina/easypay-php>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Gordalina\Easypay;

class Config
{
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
    protected $cin;

    /**
     * @var string
     */
    protected $language;

    /**
     * @var string
     */
    protected $country;

    /**
     * @param string $user
     * @param string $entity
     * @param string $cin
     * @param string $country
     * @param string $language
     */
    public function __construct($user, $entity, $cin, $country = 'PT', $language = 'PT')
    {
        $this->user = $user;
        $this->entity = $entity;
        $this->cin = $cin;

        $this->country = $country;
        $this->language = $language;
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
    public function getCin()
    {
        return $this->cin;
    }

    /**
     * @return string
     */
    public function getLanguage()
    {
        return $this->language;
    }

    /**
     * @return string
     */
    public function getCountry()
    {
        return $this->country;
    }
}
