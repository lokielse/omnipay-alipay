<?php

namespace Omnipay\Alipay;

use Omnipay\Alipay\Requests\AopNotifyRequest;
use Omnipay\Alipay\Requests\TradeAppPayRequest;
use Omnipay\Alipay\Requests\VerifyAppPayReturnRequest;

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


    /**
     * @param array $parameters
     * @param bool  $isReturn
     *
     * @return TradeAppPayRequest|AopNotifyRequest
     */
    public function completePurchase(array $parameters = [], $isReturn = false)
    {
        if ($isReturn) {
            return $this->createRequest(VerifyAppPayReturnRequest::class, $parameters);
        } else {
            return $this->createRequest(AopNotifyRequest::class, $parameters);
        }
    }
}
