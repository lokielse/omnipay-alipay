<?php

namespace Omnipay\Alipay\Requests;

use Guzzle\Http\Client as HttpClient;
use Omnipay\Alipay\Responses\LegacyNotifyResponse;
use Omnipay\Common\Exception\InvalidRequestException;
use Omnipay\Common\Message\ResponseInterface;
use Symfony\Component\HttpFoundation\Request as HttpRequest;

/**
 * Class VerifyAppPayReturnRequest
 * @package Omnipay\Alipay\Requests
 */
class VerifyAppPayReturnRequest extends AbstractAopRequest
{

    /**
     * Get the raw data array for this message. The format of this varies from gateway to
     * gateway, but will usually be either an associative array, or a SimpleXMLElement.
     * @return mixed
     * @throws InvalidRequestException
     */
    public function getData()
    {
        $this->validate();

        $result = $this->getResult();

        if (substr($result, 0, 3) == '{\"') {
            $result = stripslashes($result);
        }

        $data = json_decode($result, true);

        return $data;
    }


    /**
     * @throws InvalidRequestException
     */
    public function validate()
    {
        parent::validate(
            'result'
        );

        $result = $this->getResult();

        if (! is_string($result)) {
            throw new InvalidRequestException('The result should be string');
        }

        if (substr($result, 0, 3) == '{\"') {
            $result = stripslashes($result);
        }

        $data = json_decode($result, true);

        if (json_last_error() != JSON_ERROR_NONE) {
            throw new InvalidRequestException('The result should be a valid json string');
        }

        $key = 'alipay_trade_app_pay_response';

        if (! isset($data[$key])) {
            throw new InvalidRequestException("The result decode data should contain {$key}");
        }
    }


    /**
     * @return mixed
     */
    public function getResult()
    {
        return $this->getParameter('result');
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
        $request = new AopNotifyRequest(new HttpClient, new HttpRequest());
        $request->setParams($data);

        /**
         * @var LegacyNotifyResponse $response
         */
        $response = $request->send();

        return $response;
    }


    /**
     * @param $value
     *
     * @return $this
     */
    public function setResult($value)
    {
        return $this->setParameter('result', $value);
    }
}
