<?php

namespace Omnipay\Alipay;

use Omnipay\Alipay\Requests\AopTradeAppPayRequest;
use Omnipay\Common\Message\AbstractRequest;
use Omnipay\Common\Message\RequestInterface;

/**
 * Class AopAppGateway
 *
 * @package Omnipay\Alipay
 * @link    https://docs.open.alipay.com/204/105051
 * @method RequestInterface authorize(array $options = [])
 * @method RequestInterface completeAuthorize(array $options = [])
 * @method RequestInterface capture(array $options = [])
 * @method RequestInterface void(array $options = [])
 * @method RequestInterface createCard(array $options = [])
 * @method RequestInterface updateCard(array $options = [])
 * @method RequestInterface deleteCard(array $options = [])
 */
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
     * @return AopTradeAppPayRequest|AbstractRequest
     */
    public function purchase(array $parameters = [])
    {
        return $this->createRequest(AopTradeAppPayRequest::class, $parameters);
    }
}
