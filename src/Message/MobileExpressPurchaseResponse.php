<?php

namespace Omnipay\Alipay\Message;

use Omnipay\Common\Message\AbstractResponse;
use Omnipay\Common\Message\ResponseInterface;

class MobileExpressPurchaseResponse extends AbstractResponse implements ResponseInterface
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


    public function getRedirectData()
    {
        return $this->data;
    }


    public function getOrderString()
    {
        return $this->data['order_info_str'];
    }
}
