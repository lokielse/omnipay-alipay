<?php

namespace Omnipay\Alipay;

use Omnipay\Alipay\Requests\TradeAppPayRequest;

class AopAppGateway extends AbstractAopGateway
{

    /**
     * Get gateway display name
     *
     * This can be used by carts to get the display name for each gateway.
     */
    public function getName()
    {
        return 'Alipay App Gateway';
    }


    /**
     * @param array $parameters
     *
     * @return TradeAppPayRequest
     */
    public function purchase(array $parameters = [])
    {
        return $this->createRequest(TradeAppPayRequest::class, $parameters);
    }
}
