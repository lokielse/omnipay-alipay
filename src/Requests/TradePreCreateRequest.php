<?php

namespace Omnipay\Alipay\Requests;

use Omnipay\Alipay\Responses\TradePreCreateResponse;
use Omnipay\Common\Exception\InvalidRequestException;
use Omnipay\Common\Message\ResponseInterface;

/**
 * Class TradePreCreateRequest
 * @package Omnipay\Alipay\Requests
 * @link    https://doc.open.alipay.com/docs/api.htm?docType=4&apiId=862
 */
class TradePreCreateRequest extends AbstractAopRequest
{
    protected $method = 'alipay.trade.precreate';


    /**
     * Send the request with specified data
     *
     * @param  mixed $data The data to send
     *
     * @return ResponseInterface
     * @throws InvalidRequestException
     */
    public function sendData($data)
    {
        $data = parent::sendData($data);

        return $this->response = new TradePreCreateResponse($this, $data);
    }


    public function validateParams()
    {
        parent::validateParams();

        $this->validateBizContent(
            'out_trade_no',
            'total_amount',
            'subject'
        );
    }
}
