<?php

namespace Omnipay\Alipay;

use Omnipay\Alipay\Requests\CreateOrderRequest;
use Omnipay\Alipay\Requests\NotifyRequest;
use Omnipay\Alipay\Requests\QueryOrderStatusRequest;
use Omnipay\Alipay\Requests\RefundRequest;
use Omnipay\Common\AbstractGateway;

class NewExpressGateway extends AbstractGateway
{

    /**
     * Get gateway display name
     *
     * This can be used by carts to get the display name for each gateway.
     */
    public function getName()
    {
        return 'Alipay Express Gateway';
    }


    public function getDefaultParameters()
    {
        return array (
            'input_charset' => 'UTF-8',
            'sign_type'     => 'MD5',
            'payment_type'  => '1',
        );
    }


    /**
     * @return mixed
     */
    public function getPartner()
    {
        return $this->getParameter('partner');
    }


    /**
     * @param $value
     *
     * @return $this
     */
    public function setPartner($value)
    {
        return $this->setParameter('partner', $value);
    }


    /**
     * @return mixed
     */
    public function getSignType()
    {
        return $this->getParameter('sign_type');
    }


    /**
     * @param $value
     *
     * @return $this
     */
    public function setSignType($value)
    {
        return $this->setParameter('sign_type', $value);
    }


    /**
     * @return mixed
     */
    public function getPaymentType()
    {
        return $this->getParameter('payment_type');
    }


    /**
     * @param $value
     *
     * @return $this
     */
    public function setPaymentType($value)
    {
        return $this->setParameter('payment_type', $value);
    }


    /**
     * @return mixed
     */
    public function getKey()
    {
        return $this->getParameter('key');
    }


    /**
     * @param $value
     *
     * @return $this
     */
    public function setKey($value)
    {
        return $this->setParameter('key', $value);
    }


    /**
     * @return mixed
     */
    public function getPrivateKey()
    {
        return $this->getParameter('private_key');
    }


    /**
     * @param $value
     *
     * @return $this
     */
    public function setPrivateKey($value)
    {
        return $this->setParameter('private_key', $value);
    }


    /**
     * @return mixed
     */
    public function getSellerId()
    {
        return $this->getParameter('seller_id');
    }


    /**
     * @param $value
     *
     * @return $this
     */
    public function setSellerId($value)
    {
        return $this->setParameter('seller_id', $value);
    }


    /**
     * @return mixed
     */
    public function getSellerEmail()
    {
        return $this->getParameter('seller_email');
    }


    /**
     * @param $value
     *
     * @return $this
     */
    public function setSellerEmail($value)
    {
        return $this->setParameter('seller_email', $value);
    }


    /**
     * @return mixed
     */
    public function getSellerAccountName()
    {
        return $this->getParameter('seller_account_name');
    }


    /**
     * @param $value
     *
     * @return $this
     */
    public function setSellerAccountName($value)
    {
        return $this->setParameter('seller_account_name', $value);
    }


    /**
     * @return mixed
     */
    public function getNotifyUrl()
    {
        return $this->getParameter('notify_url');
    }


    /**
     * @param $value
     *
     * @return $this
     */
    public function setNotifyUrl($value)
    {
        return $this->setParameter('notify_url', $value);
    }


    /**
     * @return mixed
     */
    public function getReturnUrl()
    {
        return $this->getParameter('return_url');
    }


    /**
     * @param $value
     *
     * @return $this
     */
    public function setReturnUrl($value)
    {
        return $this->setParameter('return_url', $value);
    }


    /**
     * @return mixed
     */
    public function getInputCharset()
    {
        return $this->getParameter('_input_charset');
    }


    /**
     * @param $value
     *
     * @return $this
     */
    public function setInputCharset($value)
    {
        return $this->setParameter('_input_charset', $value);
    }


    public function purchase(array $parameters = array ())
    {
        return $this->createRequest(CreateOrderRequest::class, $parameters);
    }


    public function completePurchase(array $parameters = array ())
    {
        return $this->createRequest(NotifyRequest::class, $parameters);
    }


    public function refund(array $parameters = array ())
    {
        return $this->createRequest(RefundRequest::class, $parameters);
    }


    public function queryOrderStatus(array $parameters = array ())
    {
        return $this->createRequest(QueryOrderStatusRequest::class, $parameters);
    }
}