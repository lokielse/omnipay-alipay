<?php

namespace Omnipay\Alipay\Responses;

use Omnipay\Alipay\Requests\TradeRefundRequest;

class TradeRefundResponse extends AbstractAopResponse
{
    protected $key = 'alipay_trade_refund_response';

    /**
     * @var TradeRefundRequest
     */
    protected $request;
}
