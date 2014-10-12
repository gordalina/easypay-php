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
use Gordalina\Easypay\Payment\PaymentComplete;

class FetchAllPayments extends AbstractResponse implements ResponseInterface
{

    /**
     * @var string
     */
    protected $status;

    /**
     * @var string
     */
    protected $message;

    /**
     * @var int
     */
    protected $recordCount;

    /**
     * @var array|PaymentComplete[]
     */
    protected $records;

    /**
     * @param array $content
     */
    public function __construct(array $content)
    {
        $this->parse($content, array(
            'ep_status' => 'status',
            'ep_message' => 'message',
            'ep_num_records' => 'recordCount',
            'ref_detail' => array('records', function (array $payments) use ($content) {
                return FetchAllPayments::normalizePayments($content['ep_num_records'] == 1 ? array($payments) : $payments);
            })
        ));
    }

    /**
     * @static
     * @param  array  $payments
     * @return array|PaymentComplete[]
     */
    public static function normalizePayments(array $payments)
    {
        if (!isset($payments['ref']) || empty($payments['ref'])) {
            return array();
        }

        return array_map(
            array('Gordalina\Easypay\Payment\PaymentComplete', 'fromArray'),
            $payments['ref']
        );
    }

    /**
     * {@inheritdoc}
     */
    public function isValid()
    {
        return $this->status == 'ok0';
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

    /**
     * @return int
     */
    public function getRecordCount()
    {
        return $this->recordCount;
    }

    /**
     * @return array|PaymentComplete[]
     */
    public function getRecords()
    {
        return $this->records;
    }
}
