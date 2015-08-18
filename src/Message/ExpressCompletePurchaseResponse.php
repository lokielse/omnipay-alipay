<?php

namespace Omnipay\Alipay\Message;

use Omnipay\Common\Message\AbstractResponse;

class ExpressCompletePurchaseResponse extends AbstractResponse
{

    /**
     * @var ExpressCompletePurchaseRequest
     */
    protected $request;


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
     * @deprecated use isPaid() instead
     *
     * @return bool
     */
    public function isTradeStatusOk()
    {
        return $this->isPaid();
    }


    public function isPaid()
    {
        return $this->data['is_paid'];
    }


    /**
     * Is the response successful?
     *
     * @return boolean
     */
    public function isSuccessful()
    {
        return $this->data['verify_success'];
    }
}
