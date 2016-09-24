<?php

namespace Omnipay\Alipay\Responses;

use Omnipay\Alipay\Requests\TradePreCreateRequest;

class TradePreCreateResponse extends AbstractAopResponse
{

    protected $key = 'alipay_trade_precreate_response';

    /**
     * @var TradePreCreateRequest
     */
    protected $request;


    public function getQrCode()
    {
        return $this->getAlipayResponse('qr_code');
    }
}
