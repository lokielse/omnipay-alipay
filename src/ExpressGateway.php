<?php

namespace Omnipay\Alipay;

/**
 * Class ExpressGateway
 *
 * @package Omnipay\Alipay
 */
class ExpressGateway extends BaseAbstractGateway
{

    /**
     * Get gateway display name
     *
     * This can be used by carts to get the display name for each gateway.
     */
    public function getName()
    {
        return 'Alipay Express';
    }


    public function purchase(array $parameters = array())
    {
        return $this->createRequest('\Omnipay\Alipay\Message\ExpressPurchaseRequest', $parameters);
    }
}
