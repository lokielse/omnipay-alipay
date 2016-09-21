<?php

namespace Omnipay\Alipay\Requests;

use Guzzle\Http\Client as HttpClient;
use Omnipay\Alipay\Common\Signer;
use Omnipay\Alipay\Responses\NotifyResponse;
use Omnipay\Alipay\Responses\NotifyVerifyResponse;
use Omnipay\Common\Exception\InvalidRequestException;
use Omnipay\Common\Message\ResponseInterface;
use Symfony\Component\HttpFoundation\ParameterBag;
use Symfony\Component\HttpFoundation\Request as HttpRequest;

class NotifyRequest extends Request
{

    /**
     * @var ParameterBag
     */
    public $requestParams;


    /**
     * Get the raw data array for this message. The format of this varies from gateway to
     * gateway, but will usually be either an associative array, or a SimpleXMLElement.
     * @return mixed
     * @throws InvalidRequestException
     */
    public function getData()
    {
        $this->initRequestParams();

        $this->validateRequestParams();

        return $this->requestParams->all();
    }


    /**
     * Send the request with specified data
     *
     * @param  mixed $data The data to send
     *
     * @return ResponseInterface
     * @throws InvalidRequestException
     */
    public function sendData($data)
    {
        $this->verifySignature();

        if ($this->requestParams->has('notify_id')) {
            $this->verifyNotifyId();
        }

        return $this->response = new NotifyResponse($this, $data);
    }


    /**
     * @return array|mixed
     */
    private function initRequestParams()
    {
        $data = $this->getParameter('request_params');

        if (! $data) {
            $data = array_merge($_GET, $_POST);
        }

        $this->requestParams = new ParameterBag($data);

        return $data;
    }


    public function validateRequestParams()
    {
        if (empty($this->requestParams->all())) {
            throw new InvalidRequestException('The request_params or $_REQUEST is empty');
        }

        if (! $this->requestParams->has('sign_type')) {
            throw new InvalidRequestException('The sign_type is required');
        }

        if (! $this->requestParams->has('sign')) {
            throw new InvalidRequestException('The sign is required');
        }
    }


    protected function verifyNotifyId()
    {
        $request = new NotifyVerifyRequest(new HttpClient, new HttpRequest());
        $request->setPartner($this->getPartner());
        $request->setNotifyId($this->requestParams->get('notify_id'));

        /**
         * @var NotifyVerifyResponse $response
         */
        $response = $request->send();

        if (! $response->isSuccessful()) {
            throw new InvalidRequestException('The notify_id is not trusted');
        }
    }


    protected function verifySignature()
    {
        $signer  = new Signer($this->requestParams->all());
        $content = $signer->getContentToSign();
        $sign    = $this->requestParams->get('sign');

        $match = $signer->verifyWithRSA($content, $sign, $this->getAlipayPublicKey());

        if (! $match) {
            throw new InvalidRequestException('The sign is not matched');
        }
    }
}