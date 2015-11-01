<?php

namespace Omnipay\Alipay;

/**
 * Class SecuredGateway
 *
 * @package Omnipay\Alipay
 */
class SecuredGateway extends BaseAbstractGateway
{

    /**
     * LOGISTIC_TYPE
     */
    const LOGISTIC_TYPE_EXPRESS = 'EXPRESS';

    const LOGISTIC_TYPE_POST = 'POST';

    const LOGISTIC_TYPE_EMS = 'EMS';

    /**
     * LOGISTIC_PAYMENT
     */
    const LOGISTIC_PAYMENT_SELLER_PAY = 'SELLER_PAY';

    const LOGISTIC_PAYMENT_BUYER_PAY = 'BUYER_PAY';

    protected $serviceName = 'create_partner_trade_by_buyer';


    /**
     * Get gateway display name
     *
     * This can be used by carts to get the display name for each gateway.
     */
    public function getName()
    {
        return 'Alipay Secured';
    }


    public function setLogisticsInfo($fee, $type, $payment)
    {
        $this->setLogisticsFee($fee);
        $this->setLogisticsType($type);
        $this->setLogisticsPayment($payment);
    }


    public function setLogisticsFee($value)
    {
        $this->setParameter('logistics_fee', $value);
    }


    public function setLogisticsType($value)
    {
        $this->setParameter('logistics_type', $value);
    }


    public function setLogisticsPayment($value)
    {
        $this->setParameter('logistics_payment', $value);
    }


    public function getLogisticsFee()
    {
        return $this->getParameter('logistics_fee');
    }


    public function getLogisticsType()
    {
        return $this->getParameter('logistics_type');
    }


    public function getLogisticsPayment()
    {
        return $this->getParameter('logistics_payment');
    }


    public function setReceiveInfo($name, $address, $zip, $phone, $mobile)
    {
        $this->setReceiveName($name);
        $this->setReceiveAddress($address);
        $this->setReceiveZip($zip);
        $this->setReceivePhone($phone);
        $this->setReceiveMobile($mobile);
    }


    public function setReceiveName($value)
    {
        $this->setParameter('receive_name', $value);
    }


    public function setReceiveAddress($value)
    {
        $this->setParameter('receive_address', $value);
    }


    public function setReceiveZip($value)
    {
        $this->setParameter('receive_zip', $value);
    }


    public function setReceivePhone($value)
    {
        $this->setParameter('receive_phone', $value);
    }


    public function setReceiveMobile($value)
    {
        $this->setParameter('receive_mobile', $value);
    }


    public function getReceiveName()
    {
        return $this->getParameter('receive_name');
    }


    public function getReceiveAddress()
    {
        return $this->getParameter('receive_address');
    }


    public function getReceiveZip()
    {
        return $this->getParameter('receive_zip');
    }


    public function getReceivePhone()
    {
        return $this->getParameter('receive_phone');
    }


    public function getReceiveMobile()
    {
        return $this->getParameter('receive_mobile');
    }


    public function purchase(array $parameters = array())
    {
        $this->setService($this->serviceName);

        return $this->createRequest('\Omnipay\Alipay\Message\SecuredPurchaseRequest', $parameters);
    }

    public function sendGoods(array $parameters = array())
    {
        $this->setService('send_goods_confirm_by_platform');

        return $this->createRequest('\Omnipay\Alipay\Message\SendGoodsRequest', $parameters);
    }
}
