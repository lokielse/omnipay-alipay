<?php

namespace Omnipay\Alipay\Requests;

use Omnipay\Alipay\Common\Signer;
use Omnipay\Common\Exception\InvalidRequestException;
use Omnipay\Common\Message\AbstractRequest;

abstract class AopRequest extends AbstractRequest
{

    protected $method;

    protected $privateKey;

    protected $encryptKey;

    protected $endpoint = 'https://openapi.alipay.com/gateway.do';


    /**
     * @return mixed
     */
    public function getAppId()
    {
        return $this->getParameter('app_id');
    }


    /**
     * @param $value
     *
     * @return $this
     */
    public function setAppId($value)
    {
        return $this->setParameter('app_id', $value);
    }


    /**
     * @return mixed
     */
    public function getFormat()
    {
        return $this->getParameter('format');
    }


    /**
     * @param $value
     *
     * @return $this
     */
    public function setFormat($value)
    {
        return $this->setParameter('format', $value);
    }


    /**
     * @return mixed
     */
    public function getCharset()
    {
        return $this->getParameter('charset');
    }


    /**
     * @param $value
     *
     * @return $this
     */
    public function setCharset($value)
    {
        return $this->setParameter('charset', $value);
    }


    /**
     * @return mixed
     */
    public function getSignType()
    {
        return $this->getParameter('sign_type');
    }


    /**
     * @param $value
     *
     * @return $this
     */
    public function setSignType($value)
    {
        return $this->setParameter('sign_type', $value);
    }


    /**
     * @return mixed
     */
    public function getTimestamp()
    {
        return $this->getParameter('timestamp');
    }


    /**
     * @param $value
     *
     * @return $this
     */
    public function setTimestamp($value)
    {
        return $this->setParameter('timestamp', $value);
    }


    /**
     * @return mixed
     */
    public function getBizContent()
    {
        return $this->getParameter('biz_content');
    }


    /**
     * @param $value
     *
     * @return $this
     */
    public function setBizContent($value)
    {
        return $this->setParameter('biz_content', $value);
    }


    /**
     * @return mixed
     */
    public function getPrivateKey()
    {
        return $this->privateKey;
    }


    /**
     * @param $value
     *
     * @return $this
     */
    public function setPrivateKey($value)
    {
        $this->privateKey = $value;

        return $this;
    }


    /**
     * @return mixed
     */
    public function getEncryptKey()
    {
        return $this->encryptKey;
    }


    /**
     * @param $value
     *
     * @return $this
     */
    public function setEncryptKey($value)
    {
        $this->encryptKey = $value;

        return $this;
    }


    /**
     * @return mixed
     */
    public function getEndpoint()
    {
        return $this->endpoint;
    }


    /**
     * @param $value
     *
     * @return $this
     */
    public function setEndpoint($value)
    {
        $this->endpoint = $value;

        return $this;
    }


    /**
     * @return mixed
     */
    public function getVersion()
    {
        return $this->getParameter('version');
    }


    /**
     * @param $value
     *
     * @return $this
     */
    public function setVersion($value)
    {
        return $this->setParameter('version', $value);
    }


    public function filter($data)
    {
        return array_filter($data, 'strlen');
    }


    protected function sign($params, $signType)
    {
        $signer = new Signer($params);
        $signer->setIgnores(array ('sign'));

        $signType = strtoupper($signType);

        if ($signType == 'RSA') {
            $sign = $signer->signWithRSA($this->getPrivateKey());
        } elseif ($signType == 'RSA2') {
            $sign = $signer->signWithRSA($this->getPrivateKey(), OPENSSL_ALGO_SHA256);
        } else {
            throw new InvalidRequestException('The signType is not allowed');
        }

        return $sign;
    }
}