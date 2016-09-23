<?php

namespace Omnipay\Alipay\Requests;

use Omnipay\Alipay\Responses\TradeCancelResponse;
use Omnipay\Common\Exception\InvalidRequestException;
use Omnipay\Common\Message\ResponseInterface;

/**
 * Class TradeCancelRequest
 * @package Omnipay\Alipay\Requests
 * @link    https://doc.open.alipay.com/doc2/apiDetail.htm?apiId=866&docType=4
 */
class TradeCancelRequest extends AbstractAopRequest
{
    protected $method = 'alipay.trade.cancel';


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

        return $this->response = new TradeCancelResponse($this, $data);
    }


    public function validateParams()
    {
        parent::validateParams();

        $this->validateBizContentOne(
            'out_trade_no',
            'trade_no'
        );
    }
}
