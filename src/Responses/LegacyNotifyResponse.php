<?php

namespace Omnipay\Alipay\Responses;

use Omnipay\Alipay\Requests\LegacyNotifyRequest;
use Omnipay\Common\Message\AbstractResponse;

class LegacyNotifyResponse extends AbstractResponse
{

    /**
     * @var LegacyNotifyRequest
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
    public function isSuccessful()
    {
        return true;
    }
}
