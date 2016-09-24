<?php

namespace Omnipay\Alipay\Responses;

use Omnipay\Alipay\Requests\TradeRefundQueryRequest;

class TradeRefundQueryResponse extends AbstractAopResponse
{

    protected $key = 'alipay_trade_fastpay_refund_query_response';

    /**
     * @var TradeRefundQueryRequest
     */
    protected $request;
}
