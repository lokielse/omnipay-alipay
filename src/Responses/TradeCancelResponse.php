<?php

namespace Omnipay\Alipay\Responses;

use Omnipay\Alipay\Requests\TradeRefundRequest;

class TradeCancelResponse extends AbstractAopResponse
{

    protected $key = 'alipay_trade_cancel_response';

    /**
     * @var TradeRefundRequest
     */
    protected $request;
}
