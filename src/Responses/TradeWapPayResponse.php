<?php

namespace Omnipay\Alipay\Responses;

use Omnipay\Common\Message\AbstractResponse;

class TradeWapPayResponse extends AbstractResponse
{

    /**
     * Is the response successful?
     *
     * @return boolean
     */
    public function isSuccessful()
    {
        return true;
    }


    public function getHtml()
    {
        return $this->data['html'];
    }
}