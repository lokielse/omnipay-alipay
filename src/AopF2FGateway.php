<?php

namespace Omnipay\Alipay;

use Omnipay\Alipay\Requests\AopTradePayRequest;
use Omnipay\Alipay\Requests\AopTradePreCreateRequest;
use Omnipay\Common\Message\AbstractRequest;
use Omnipay\Common\Message\RequestInterface;

/**
 * Class AopF2FGateway
 *
 * @package Omnipay\Alipay
 * @link    https://docs.open.alipay.com/194/105072
 * @method RequestInterface authorize(array $options = [])
 * @method RequestInterface completeAuthorize(array $options = [])
 * @method RequestInterface void(array $options = [])
 * @method RequestInterface createCard(array $options = [])
 * @method RequestInterface updateCard(array $options = [])
 * @method RequestInterface deleteCard(array $options = [])
 */
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
     * @return AopTradePayRequest|AbstractRequest
     */
    public function capture(array $parameters = [])
    {
        return $this->createRequest(AopTradePayRequest::class, $parameters);
    }


    /**
     * @param array $parameters
     *
     * @return AopTradePreCreateRequest|AbstractRequest
     */
    public function purchase(array $parameters = [])
    {
        return $this->createRequest(AopTradePreCreateRequest::class, $parameters);
    }
}
