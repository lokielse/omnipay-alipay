<?php

namespace Omnipay\Alipay\Responses;

use Omnipay\Common\Message\AbstractResponse;

class NotifyVerifyResponse extends AbstractResponse
{

    /**
     * Is the response successful?
     *
     * @return boolean
     */
    public function isSuccessful()
    {
        return $this->data['result'] === 'true';
    }
}