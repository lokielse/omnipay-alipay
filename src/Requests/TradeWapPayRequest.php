<?php

namespace Omnipay\Alipay\Requests;

use Omnipay\Alipay\Responses\TradeWapPayResponse;
use Omnipay\Common\Exception\InvalidRequestException;
use Omnipay\Common\Message\ResponseInterface;

class TradeWapPayRequest extends AopRequest
{

    protected $method = 'alipay.trade.wap.pay';


    /**
     * Get the raw data array for this message. The format of this varies from gateway to
     * gateway, but will usually be either an associative array, or a SimpleXMLElement.
     *
     * @return mixed
     */
    public function getData()
    {
        if (! $this->getTimestamp()) {
            $this->setTimestamp(date('Y-m-d H:i:s'));
        }

        $data           = $this->parameters->all();
        $data['method'] = $this->method;

        if (is_array($data['biz_content'])) {
            $data['biz_content'] = json_encode($data['biz_content']);
        }

        $data              = $this->filter($data);
        $data['sign']      = $this->sign($data, $this->getSignType());
        $data['sign_type'] = $this->getSignType();

        return $data;
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
        $queryParams = $data;
        unset($queryParams['biz_content']);
        ksort($queryParams);

        $url = sprintf('%s?%s', $this->getEndpoint(), http_build_query($queryParams));

        $params = array (
            'biz_content' => json_encode($this->getBizContent())
        );

        $html = $this->httpClient->post($url)->setBody(
            http_build_query($params),
            'application/x-www-form-urlencoded'
        )->send()->getBody();

        if (strpos($html, 'invalid-signature') !== false) {
            throw new InvalidRequestException('The signature is invalid, check your private key');
        } elseif (strpos($html, 'insufficient-isv-permissions') !== false) {
            throw new InvalidRequestException('insufficient-isv-permissions');
        }

        $data = array (
            'html' => $html
        );

        return $this->response = new TradeWapPayResponse($this, $data);
    }


    /**
     * @return mixed
     */
    public function getNotifyUrl()
    {
        return $this->getParameter('notify_url');
    }


    /**
     * @param $value
     *
     * @return $this
     */
    public function setNotifyUrl($value)
    {
        return $this->setParameter('notify_url', $value);
    }


    /**
     * @return mixed
     */
    public function getReturnUrl()
    {
        return $this->getParameter('return_url');
    }


    /**
     * @param $value
     *
     * @return $this
     */
    public function setReturnUrl($value)
    {
        return $this->setParameter('return_url', $value);
    }

}