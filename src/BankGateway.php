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

    /**
     * Get gateway display name
     *
     * This can be used by carts to get the display name for each gateway.
     */
    public function getName()
    {
        return 'Alipay Bank';
    }


    public function purchase(array $parameters = array ())
    {
        $this->setParameter('paymethod', 'bankPay');

        if ($this->getParameter('default_bank') === null) {
            throw new InvalidRequestException("The setDefaultBank(x) method is not called.");
        }

        return $this->createRequest('\Omnipay\Alipay\Message\ExpressPurchaseRequest', $parameters);
    }
}
