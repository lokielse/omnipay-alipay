<?php

namespace Omnipay\Alipay\Responses;

use Omnipay\Alipay\Requests\TradeOrderSettleRequest;

class TradeOrderSettleResponse extends AbstractAopResponse
{

    protected $key = 'alipay_trade_order_settle_response';

    /**
     * @var TradeOrderSettleRequest
     */
    protected $request;
}
