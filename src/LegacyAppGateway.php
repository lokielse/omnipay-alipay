<?php

namespace Omnipay\Alipay;

use Omnipay\Alipay\Requests\LegacyAppPurchaseRequest;
use Omnipay\Alipay\Requests\LegacyRefundNoPwdRequest;
use Omnipay\Common\Message\AbstractRequest;
use Omnipay\Common\Message\RequestInterface;

/**
 * Class LegacyAppGateway
 *
 * @package Omnipay\Alipay
 * @link    https://docs.open.alipay.com/59/103563
 * @method RequestInterface authorize(array $options = [])
 * @method RequestInterface completeAuthorize(array $options = [])
 * @method RequestInterface capture(array $options = [])
 * @method RequestInterface void(array $options = [])
 * @method RequestInterface createCard(array $options = [])
 * @method RequestInterface updateCard(array $options = [])
 * @method RequestInterface deleteCard(array $options = [])
 */
class LegacyAppGateway extends AbstractLegacyGateway
{

    /**
     * Get gateway display name
     *
     * This can be used by carts to get the display name for each gateway.
     */
    public function getName()
    {
        return 'Alipay Legacy APP Gateway';
    }


    public function getDefaultParameters()
    {
        $data = parent::getDefaultParameters();

        $data['signType'] = 'RSA';

        return $data;
    }


    /**
     * @return mixed
     */
    public function getRnCheck()
    {
        return $this->getParameter('rn_check');
    }


    /**
     * @param $value
     *
     * @return $this
     */
    public function setRnCheck($value)
    {
        return $this->setParameter('rn_check', $value);
    }


    /**
     * @param array $parameters
     *
     * @return AbstractRequest
     */
    public function purchase(array $parameters = [])
    {
        return $this->createRequest(LegacyAppPurchaseRequest::class, $parameters);
    }


    /**
     * @param array $parameters
     *
     * @return LegacyRefundNoPwdRequest|AbstractRequest
     */
    public function refundNoPwd(array $parameters = [])
    {
        return $this->createRequest(LegacyRefundNoPwdRequest::class, $parameters);
    }
}
