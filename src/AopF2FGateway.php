<?php

namespace Omnipay\Alipay;

use Omnipay\Alipay\Requests\TradePayRequest;
use Omnipay\Alipay\Requests\TradePreCreateRequest;

class AopF2FGateway extends AbstractAopGateway
{

    /**
     * Get gateway display name
     *
     * This can be used by carts to get the display name for each gateway.
     */
    public function getName()
    {
        return 'Alipay Face To Face Gateway';
    }


    /**
     * @param array $parameters
     *
     * @return TradePayRequest
     */
    public function capture(array $parameters = [])
    {
        return $this->createRequest(TradePayRequest::class, $parameters);
    }


    /**
     * @param array $parameters
     *
     * @return TradePreCreateRequest
     */
    public function purchase(array $parameters = [])
    {
        return $this->createRequest(TradePreCreateRequest::class, $parameters);
    }
}
