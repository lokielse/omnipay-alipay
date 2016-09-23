<?php

namespace Omnipay\Alipay;

use Omnipay\Alipay\Requests\AopNotifyRequest;
use Omnipay\Alipay\Requests\TradePayRequest;
use Omnipay\Alipay\Requests\TradePreCreateRequest;

class AopPosGateway extends AbstractAopGateway
{

    /**
     * Get gateway display name
     *
     * This can be used by carts to get the display name for each gateway.
     */
    public function getName()
    {
        return 'Alipay POS Gateway';
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
     * @return TradePayRequest
     */
    public function purchase(array $parameters = [])
    {
        return $this->createRequest(TradePreCreateRequest::class, $parameters);
    }


    /**
     * @param array $parameters
     *
     * @return AopNotifyRequest
     */
    public function completePurchase(array $parameters = [])
    {
        return $this->createRequest(AopNotifyRequest::class, $parameters);
    }
}
