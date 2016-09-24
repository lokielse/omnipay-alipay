<?php

namespace Omnipay\Alipay;

use Omnipay\Alipay\Requests\AopTradeAppPayRequest;

class AopAppGateway extends AbstractAopGateway
{

    /**
     * Get gateway display name
     *
     * This can be used by carts to get the display name for each gateway.
     */
    public function getName()
    {
        return 'Alipay APP Gateway';
    }


    /**
     * @param array $parameters
     *
     * @return AopTradeAppPayRequest
     */
    public function purchase(array $parameters = [])
    {
        return $this->createRequest(AopTradeAppPayRequest::class, $parameters);
    }
}
