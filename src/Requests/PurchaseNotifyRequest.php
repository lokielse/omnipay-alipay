<?php

namespace Omnipay\Alipay\Requests;

use Omnipay\Alipay\Responses\PurchaseNotifyResponse;

class PurchaseNotifyRequest extends NotifyRequest
{

    public function sendData($data)
    {
        parent::sendData($data);

        return $this->response = new PurchaseNotifyResponse($this, $data);
    }

}