<?php

namespace Omnipay\Alipay\Message;

use Omnipay\Common\Message\AbstractResponse;

class CompleteRefundResponse extends AbstractResponse
{

    /**
     * @var CompleteRefundRequest
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

    public function isRefundStatusOk()
    {
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
