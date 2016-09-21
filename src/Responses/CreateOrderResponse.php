<?php

namespace Omnipay\Alipay\Responses;

use Omnipay\Alipay\Requests\CreateOrderRequest;
use Omnipay\Common\Message\AbstractResponse;
use Omnipay\Common\Message\RedirectResponseInterface;

class CreateOrderResponse extends AbstractResponse implements RedirectResponseInterface
{

    /**
     * Is the response successful?
     *
     * @return boolean
     */
    public function isSuccessful()
    {
        return true;
    }


    public function isRedirect()
    {
        return true;
    }


    public function getRedirectUrl()
    {
        /**
         * @var CreateOrderRequest $request
         */
        $request = $this->getRequest();

        return $request->getEndpoint() . '?' . http_build_query($this->getRedirectData());
    }


    /**
     * Gets the redirect form data array, if the redirect method is POST.
     */
    public function getRedirectData()
    {
        return $this->data;
    }


    /**
     * Get the required redirect method (either GET or POST).
     */
    public function getRedirectMethod()
    {
        return 'GET';
    }
}