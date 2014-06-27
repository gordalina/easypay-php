<?php

/*
 * This file is part of the easypay-php package.
 *
 * (c) Samuel Gordalina <https://github.com/gordalina/easypay-php>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Gordalina\Easypay\Request;

use Gordalina\Easypay\Config;
use Gordalina\Easypay\Response\FetchAllPayments as FetchAllPaymentsResponse;

class FetchAllPayments implements RequestInterface
{
    const ENDPOINT = 'api_easypay_040BG1.php';

    /**
     * @var string
     */
    protected $filter;

    /**
     * @var string
     */
    protected $startDate;

    /**
     * @var string
     */
    protected $endDate;

    /**
     * Filter type, can be one of:
     *     - week (payments of a given week)
     *     - last (last X payments)
     *     - date (payments after this date)
     *
     * @param string $filter
     */
    public function setFilter($filter)
    {
        $this->filter = $filter;
    }

    /**
     * Start Date - the date will only be used if a filter is set
     *
     * Examples:
     *     filter=week, startDate=12/45 (week 45 of 2012)
     *     filter=last, startDate=10 (last 10 results)
     *     filter=date, startDate=2013-01-01 (payments since this date)
     *
     * @param string $date
     */
    public function setStartDate($date)
    {
        $this->startDate = $date;
    }

    /**
     * End Date
     *
     * @param string $date
     */
    public function setEndDate($date)
    {
        $this->endDate = $date;
    }

    /**
     * {@inheritdoc}
     */
    public function getEndpoint()
    {
        return static::ENDPOINT;
    }

    /**
     * {@inheritdoc}
     */
    public function handleRequest(Config $config)
    {
        $parameters = array(
            'ep_cin' => $config->getCin(),
            'ep_user' => $config->getUser(),
            'ep_entity' => $config->getEntity(),
            'ep_language' => $config->getLanguage(),
            'ep_country' => $config->getCountry(),

            // Optional authentication code
            's_code' => $config->getCode(),
        );

        if ($this->filter) {
            $parameters['ep_list_type'] = $this->filter;

            if ($this->startDate) {
                $parameters['o_ini'] = $this->startDate;
            }

            if ($this->endDate && $this->filter === 'date') {
                $parameters['o_last'] = $this->endDate;
            }
        }

        return $parameters;
    }

    /**
     * {@inheritdoc}
     */
    public function handleResponse($response)
    {
        return new FetchAllPaymentsResponse($response);
    }
}
