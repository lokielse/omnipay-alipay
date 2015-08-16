<?php

namespace Omnipay\Alipay\Message;

use Omnipay\Common\Message\AbstractResponse;

class ExpressCompletePurchaseResponse extends AbstractResponse
{

    /**
     * @var ExpressCompletePurchaseRequest
     */
    protected $request;


    public function isTradeStatusOk()
    {
        $status = $this->request->getTradeStatus();

        return ( $status == 'TRADE_FINISHED' || $status == 'TRADE_SUCCESS' );
    }


    public function getTradeStatus()
    {
        return $this->request->getTradeStatus();
    }


    public function getResponseText()
    {
        if ($this->isSuccessful()) {
            return 'success';
        } else {
            return 'fail';
        }
    }


    /**
     * Is the response successful?
     *
     * @return boolean
     */
    public function isSuccessful()
    {
        if ($this->data['verify_success']) {
            return true;
        } else {
            return false;
        }
    }
}
