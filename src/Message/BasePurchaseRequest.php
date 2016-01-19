<?php
/**
 * https://doc.open.alipay.com/doc2/detail?treeId=62&articleId=103740&docType=1
 */
namespace Omnipay\Alipay\Message;

use Omnipay\Common\Message\ResponseInterface;

abstract class BasePurchaseRequest extends BaseAbstractRequest
{

    protected $liveEndpoint = 'https://mapi.alipay.com/gateway.do';


    protected function validateData()
    {
        $this->validate(
            'service',
            'partner',
            'key',
            'seller_email',
            'notify_url',
            'return_url',
            'out_trade_no',
            'subject',
            'input_charset',
            'total_fee'
        );
    }


    public function getService()
    {
        return $this->getParameter('service');
    }


    public function setService($value)
    {
        $this->setParameter('service', $value);
    }


    public function getOutTradeNo()
    {
        return $this->getParameter('out_trade_no');
    }


    public function setOutTradeNo($value)
    {
        $this->setParameter('out_trade_no', $value);
    }


    public function getTransport()
    {
        return $this->getParameter('transport');
    }


    public function setTransport($value)
    {
        $this->setParameter('transport', $value);
    }


    public function getBody()
    {
        return $this->getParameter('body');
    }


    public function setBody($value)
    {
        $this->setParameter('body', $value);
    }


    public function getPartner()
    {
        return $this->getParameter('partner');
    }


    public function setPartner($value)
    {
        $this->setParameter('partner', $value);
    }


    public function getShowUrl()
    {
        return $this->getParameter('show_url');
    }


    public function setShowUrl($value)
    {
        $this->setParameter('show_url', $value);
    }


    public function getNotifyUrl()
    {
        return $this->getParameter('notify_url');
    }


    public function setNotifyUrl($value)
    {
        $this->setParameter('notify_url', $value);
    }


    public function getReturnUrl()
    {
        return $this->getParameter('return_url');
    }


    public function setReturnUrl($value)
    {
        $this->setParameter('return_url', $value);
    }


    public function getInputCharset()
    {
        return $this->getParameter('input_charset');
    }


    public function setInputCharset($value)
    {
        $this->setParameter('input_charset', $value);
    }


    public function getSellerEmail()
    {
        return $this->getParameter('seller_email');
    }


    public function setSellerEmail($value)
    {
        $this->setParameter('seller_email', $value);
    }


    public function getSubject()
    {
        return $this->getParameter('subject');
    }


    public function setSubject($value)
    {
        $this->setParameter('subject', $value);
    }


    public function setItBPay($value)
    {
        $this->setParameter('it_b_pay', $value);
    }


    public function getItBPay()
    {
        return $this->getParameter('it_b_pay');
    }


    public function getPaymentType()
    {
        return $this->getParameter('payment_type');
    }


    public function setPaymentType($value)
    {
        $this->setParameter('payment_type', $value);
    }


    public function getTotalFee()
    {
        return $this->getParameter('total_fee');
    }


    public function setTotalFee($value)
    {
        $this->setParameter('total_fee', $value);
    }

    public function setExtraCommonParam($value)
    {
        $this->setParameter('extra_common_param', $value);
    }

    public function getExtraCommonParam()
    {
        return $this->getParameter('extra_common_param');
    }

    public function setExtendParam($value)
    {
        $this->setParameter('extend_param', $value);
    }

    public function getExtendParam()
    {
        return $this->getParameter('extend_param');
    }

    public function getEndpoint()
    {
        return $this->liveEndpoint;
    }


    /**
     * Send the request with specified data
     *
     * @param  mixed $data The data to send
     *
     * @return ResponseInterface
     */
    public function sendData($data)
    {
        return $this->response = new PurchaseResponse($this, $data);
    }
}
