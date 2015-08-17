<?php

namespace Omnipay\Alipay\Message;

class WapExpressPurchaseRequest extends BasePurchaseRequest
{

    /**
     * Get the raw data array for this message. The format of this varies from gateway to
     * gateway, but will usually be either an associative array, or a SimpleXMLElement.
     *
     * @return mixed
     */
    public function getData()
    {
        $this->validateData();

        $data = array(
            "service"        => $this->getService(),
            "partner"        => $this->getPartner(),
            "seller_id"      => $this->getPartner(),
            "payment_type"   => $this->getPaymentType(),
            "notify_url"     => $this->getNotifyUrl(),
            "return_url"     => $this->getReturnUrl(),
            "out_trade_no"   => $this->getOutTradeNo(),
            "subject"        => $this->getSubject(),
            "total_fee"      => $this->getTotalFee(),
            "show_url"       => $this->getShowUrl(),
            "body"           => $this->getBody(),
            "it_b_pay"       => $this->getItBPay(),
            "extern_token"   => $this->getToken(),
            "_input_charset" => $this->getInputCharset(),
        );

        $data              = array_filter($data);
        $data['sign']      = $this->getParamsSignature($data);
        $data['sign_type'] = $this->getSignType();

        return $data;
    }


    protected function validateData()
    {
        parent::validateData();
        $this->validate('total_fee');
    }


    public function getPayMethod()
    {
        return $this->getParameter('pay_method');
    }


    public function getDefaultBank()
    {
        return $this->getParameter('default_bank');
    }


    public function setDefaultBank($value)
    {
        $this->setParameter('default_bank', $value);
    }


    public function setPayMethod($value)
    {
        $this->setParameter('pay_method', $value);
    }
}
