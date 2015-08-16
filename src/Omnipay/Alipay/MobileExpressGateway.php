<?php

namespace Omnipay\Alipay;

/**
 * Class MobileExpressGateway
 *
 * @package Omnipay\Alipay
 */
class MobileExpressGateway extends BaseAbstractGateway
{

    /**
     * Get gateway display name
     *
     * This can be used by carts to get the display name for each gateway.
     */
    public function getName()
    {
        return 'Alipay Mobile Express';
    }


    public function getPrivateKey()
    {
        return $this->getParameter('private_key');
    }


    public function setPrivateKey($value)
    {
        $this->setParameter('private_key', $value);
    }


    public function purchase(array $parameters = [ ])
    {
        return $this->createRequest('\Omnipay\Alipay\Message\MobileExpressPurchaseRequest', $parameters);
    }

}
