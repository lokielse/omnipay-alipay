<?php

namespace Omnipay\Alipay;

/**
 * Class DualGateway
 *
 * @package Omnipay\Alipay
 */
class DualGateway extends SecuredGateway
{

    protected $serviceName = 'trade_create_by_buyer';


    /**
     * Get gateway display name
     *
     * This can be used by carts to get the display name for each gateway.
     */
    public function getName()
    {
        return 'AliPay Dual Func';
    }


    public function purchase(array $parameters = array())
    {
        $this->setService($this->serviceName);

        return $this->createRequest('\Omnipay\Alipay\Message\SecuredPurchaseRequest', $parameters);
    }
}
