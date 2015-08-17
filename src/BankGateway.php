<?php

namespace Omnipay\Alipay;

use Omnipay\Common\Exception\InvalidRequestException;

/**
 * Class BankGateway
 *
 * @package Omnipay\Alipay
 */
class BankGateway extends ExpressGateway
{

    protected $service = 'create_direct_pay_by_user';


    /**
     * Get gateway display name
     *
     * This can be used by carts to get the display name for each gateway.
     */
    public function getName()
    {
        return 'Alipay Bank';
    }


    public function purchase(array $parameters = array())
    {
        $this->setService($this->service);
        $this->setParameter('paymethod', 'bankPay');

        if ($this->getParameter('default_bank') === null) {
            throw new InvalidRequestException("The setDefaultBank(x) method is not called.");
        }

        return $this->createRequest('\Omnipay\Alipay\Message\ExpressPurchaseRequest', $parameters);
    }
}
