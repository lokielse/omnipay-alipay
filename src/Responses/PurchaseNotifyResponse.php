<?php

namespace Omnipay\Alipay\Responses;

use Omnipay\Alipay\Requests\PurchaseNotifyRequest;

class PurchaseNotifyResponse extends NotifyResponse
{

    /**
     * @var PurchaseNotifyRequest
     */
    public $request;


    /**
     * Is the response successful?
     *
     * @return boolean
     */
    public function isSuccessful()
    {
        return true;
    }


    public function isPaid()
    {
        $status = $this->request->requestParams->get('trade_status');

        return in_array($status, array ('TRADE_FINISHED', 'TRADE_SUCCESS'));
    }
}