<?php

namespace Omnipay\Alipay\Message;


class RefundNotifyRequest extends ExpressCompletePurchaseRequest
{

    /**
     * Get the raw data array for this message. The format of this varies from gateway to
     * gateway, but will usually be either an associative array, or a SimpleXMLElement.
     *
     * @return mixed
     */
    public function getData()
    {
        $this->validate('request_params', 'transport', 'partner', 'sign_type');
        $this->validateRequestParams('batch_no', 'success_num');

        return $this->getParameters();
    }

    public function sendData($data)
    {
        $this->verifyResponse   = $this->getVerifyResponse($this->getNotifyId());
        $data['verify_success'] = $this->isSignMatch();

        return $this->response = new RefundNotifyResponse($this, $data);
    }
}
