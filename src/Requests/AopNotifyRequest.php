<?php

namespace Omnipay\Alipay\Requests;

use Guzzle\Http\Client as HttpClient;
use Omnipay\Alipay\Common\Signer;
use Omnipay\Alipay\Responses\LegacyNotifyResponse;
use Omnipay\Alipay\Responses\VerifyNotifyIdResponse;
use Omnipay\Common\Exception\InvalidRequestException;
use Omnipay\Common\Message\ResponseInterface;
use Symfony\Component\HttpFoundation\ParameterBag;
use Symfony\Component\HttpFoundation\Request as HttpRequest;

class AopNotifyRequest extends AbstractAopRequest
{

    /**
     * @var ParameterBag
     */
    public $params;


    /**
     * Get the raw data array for this message. The format of this varies from gateway to
     * gateway, but will usually be either an associative array, or a SimpleXMLElement.
     * @return mixed
     * @throws InvalidRequestException
     */
    public function getData()
    {
        $this->initParams();

        $this->validateParams();

        return $this->params->all();
    }


    /**
     * @return array|mixed
     */
    private function initParams()
    {
        $params = $this->getParams();

        if (! $params) {
            $params = array_merge($_GET, $_POST);
        }

        $this->params = new ParameterBag($params);

        return $params;
    }


    /**
     * @return mixed
     */
    public function getParams()
    {
        return $this->getParameter('params');
    }


    /**
     * @param $value
     *
     * @return $this
     */
    public function setParams($value)
    {
        return $this->setParameter('params', $value);
    }


    public function validateParams()
    {
        if (empty($this->params->all())) {
            throw new InvalidRequestException('The request_params or $_REQUEST is empty');
        }

        if (! $this->params->has('sign_type')) {
            throw new InvalidRequestException('The sign_type is required');
        }

        if (! $this->params->has('sign')) {
            throw new InvalidRequestException('The sign is required');
        }
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

        if ($this->params->has('notify_id')) {
            $this->verifyNotifyId();
        }

        return $this->response = new LegacyNotifyResponse($this, $data);
    }


    protected function verifySignature()
    {
        if ($this->params->has('alipay_trade_app_pay_response')) {
            /**
             * App Return
             * @see https://doc.open.alipay.com/docs/doc.htm?treeId=193&articleId=105302&docType=1
             */
            $params  = $this->params->get('alipay_trade_app_pay_response');
            $content = json_encode($params);
        } else {
            /**
             * Common
             */
            $signer  = new Signer($this->params->all());
            $content = $signer->getContentToSign();
        }

        $sign = $this->params->get('sign');

        $match = (new Signer)->verifyWithRSA($content, $sign, $this->getAlipayPublicKey());

        if (! $match) {
            throw new InvalidRequestException('The sign is not matched');
        }
    }


    protected function verifyNotifyId()
    {
        $request = new VerifyNotifyIdRequest(new HttpClient, new HttpRequest());
        $request->setPartner($this->getPartner());
        $request->setNotifyId($this->params->get('notify_id'));

        /**
         * @var VerifyNotifyIdResponse $response
         */
        $response = $request->send();

        if (! $response->isSuccessful()) {
            throw new InvalidRequestException('The notify_id is not trusted');
        }
    }
}
