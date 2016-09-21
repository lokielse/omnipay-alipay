<?php

namespace Omnipay\Alipay\Responses;

use Omnipay\Alipay\Requests\NotifyRequest;
use Omnipay\Common\Message\AbstractResponse;

class NotifyResponse extends AbstractResponse
{

    /**
     * @var NotifyRequest
     */
    protected $request;


    /**
     * Is the response successful?
     *
     * @return boolean
     */
    public function isSuccessful()
    {
        return true;
    }


    public function getResponseText()
    {
        if ($this->isSuccessful()) {
            return 'success';
        } else {
            return 'fail';
        }
    }
}