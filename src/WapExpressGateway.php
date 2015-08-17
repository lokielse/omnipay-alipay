<?php

namespace Omnipay\Alipay;

/**
 * Class ExpressGateway
 *
 * @package Omnipay\Alipay
 */
class WapExpressGateway extends BaseAbstractGateway
{

    protected $service = 'alipay.wap.create.direct.pay.by.user';


    public function getDefaultParameters()
    {
        $params = parent::getDefaultParameters();

        $params['signType'] = 'RSA';

        return $params;
    }


    /**
     * Get gateway display name
     *
     * This can be used by carts to get the display name for each gateway.
     */
    public function getName()
    {
        return 'Alipay Wap Express';
    }


    public function getPrivateKey()
    {
        return $this->getParameter('private_key');
    }


    public function setPrivateKey($value)
    {
        $this->setParameter('private_key', $value);
    }


    public function purchase(array $parameters = array())
    {
        $this->setService($this->service);

        return $this->createRequest('\Omnipay\Alipay\Message\WapExpressPurchaseRequest', $parameters);
    }
}
