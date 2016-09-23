<?php

namespace Omnipay\Alipay\Requests;

use Omnipay\Alipay\Responses\TradePayResponse;
use Omnipay\Common\Exception\InvalidRequestException;
use Omnipay\Common\Message\ResponseInterface;

/**
 * Class TradePayRequest
 * @package Omnipay\Alipay\Requests
 * @link    https://doc.open.alipay.com/docs/api.htm?docType=4&apiId=850
 */
class TradePayRequest extends AbstractAopRequest
{
    protected $method = 'alipay.trade.pay';

    protected $notifiable = true;


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

        return $this->response = new TradePayResponse($this, $data);
    }


    public function validateParams()
    {
        parent::validateParams();

        $this->validateBizContent(
            'out_trade_no',
            'scene',
            'auth_code',
            'subject'
        );

        $this->validateBizContentOne(
            'total_amount',
            'discountable_amount',
            'undiscountable_amount'
        );
    }
}
