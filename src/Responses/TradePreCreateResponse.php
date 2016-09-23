<?php

namespace Omnipay\Alipay\Responses;

use Omnipay\Alipay\Requests\TradePayRequest;

class TradePreCreateResponse extends AbstractAopResponse
{
    protected $key = 'alipay_trade_pay_response';

    /**
     * @var TradePayRequest
     */
    protected $request;
}
