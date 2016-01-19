<?php

namespace Omnipay\Alipay\Message;

class ExpressPurchaseRequest extends BasePurchaseRequest
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
        $data              = array(
            "service"            => $this->getService(),
            "partner"            => $this->getPartner(),
            "payment_type"       => $this->getPaymentType(),
            "notify_url"         => $this->getNotifyUrl(),
            "return_url"         => $this->getReturnUrl(),
            "seller_email"       => $this->getSellerEmail(),
            "out_trade_no"       => $this->getOutTradeNo(),
            "subject"            => $this->getSubject(),
            "total_fee"          => $this->getTotalFee(),
            "currency"           => $this->getCurrency(),
            "body"               => $this->getBody(),
            "show_url"           => $this->getShowUrl(),
            "anti_phishing_key"  => $this->getAntiPhishingKey(),
            "exter_invoke_ip"    => $this->getExterInvokeIp(),
            "paymethod"          => $this->getPayMethod(),
            "defaultbank"        => $this->getDefaultBank(),
            "_input_charset"     => $this->getInputCharset(),
            "extra_common_param" => $this->getExtraCommonParam(),
            "extend_param"       => $this->getExtendParam(),
        );
        $data              = array_filter($data);
        $data['sign']      = $this->getParamsSignature($data);
        $data['sign_type'] = $this->getSignType();

        return $data;
    }


    public function getAntiPhishingKey()
    {
        return $this->getParameter('anti_phishing_key');
    }


    public function getExterInvokeIp()
    {
        return $this->getParameter('exter_invoke_ip');
    }


    public function getPayMethod()
    {
        return $this->getParameter('pay_method');
    }


    public function getDefaultBank()
    {
        return $this->getParameter('default_bank');
    }


    public function getItBPay()
    {
        return $this->getParameter('it_b_pay');
    }

    public function setDefaultBank($value)
    {
        $this->setParameter('default_bank', $value);
    }


    public function setPayMethod($value)
    {
        $this->setParameter('pay_method', $value);
    }


    public function setAntiPhishingKey($value)
    {
        $this->setParameter('anti_phishing_key', $value);
    }


    public function setExterInvokeIp($value)
    {
        $this->setParameter('exter_invoke_ip', $value);
    }
    
    
    public function setItBPay($value)
    {
        $this->setParameter('it_b_pay', $value);
    }
}
