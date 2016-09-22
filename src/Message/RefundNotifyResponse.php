<?php

namespace Omnipay\Alipay\Message;

use Omnipay\Common\Message\AbstractResponse;

class RefundNotifyResponse extends AbstractResponse
{

    /**
     * @var ExpressCompletePurchaseRequest
     */
    protected $request;


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
    public function isVerifySuccess()
    {
        return $this->data['verify_success'];
    }
    
    
    /**
     * Is the response successful?
     *
     * @return boolean
     */
    public function isSuccessful()
    {
        return $this->isVerifySuccess();
    }
}
