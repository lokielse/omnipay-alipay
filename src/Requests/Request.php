<?php

namespace Omnipay\Alipay\Requests;

use Guzzle\Http\ClientInterface;
use Omnipay\Common\Exception\InvalidRequestException;
use Omnipay\Common\Message\AbstractRequest;
use Symfony\Component\HttpFoundation\Request as HttpRequest;

abstract class Request extends AbstractRequest
{

    protected $endpoint = 'https://mapi.alipay.com/gateway.do';

    protected $service;

    protected $key;

    protected $signType;

    protected $privateKey;


    /**
     * @return string
     */
    public function getEndpoint()
    {
        return $this->endpoint;
    }


    /**
     * @return mixed
     */
    public function getPartner()
    {
        return $this->getParameter('partner');
    }


    /**
     * @param $value
     *
     * @return $this
     */
    public function setPartner($value)
    {
        return $this->setParameter('partner', $value);
    }


    /**
     * @return mixed
     */
    public function getInputCharset()
    {
        return $this->getParameter('_input_charset');
    }


    /**
     * @param $value
     *
     * @return $this
     */
    public function setInputCharset($value)
    {
        return $this->setParameter('_input_charset', $value);
    }


    /**
     * @return mixed
     */
    public function getSignType()
    {
        return $this->signType;
    }


    /**
     * @param $value
     *
     * @return $this
     * @throws InvalidRequestException
     */
    public function setSignType($value)
    {
        $this->signType = $value;

        return $this;
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
    public function getKey()
    {
        return $this->key;
    }


    /**
     * @param $value
     *
     * @return $this
     */
    public function setKey($value)
    {
        $this->key = $value;

        return $this;
    }


    protected function validateOne()
    {
        $keys = func_get_args();

        if ($keys && is_array($keys[0])) {
            $keys = $keys[0];
        }

        $allEmpty = true;

        foreach ($keys as $key) {
            $value = $this->parameters->get($key);

            if (! empty($value)) {
                $allEmpty = false;
                break;
            }
        }

        if ($allEmpty) {
            throw new InvalidRequestException(
                sprintf('The parameters (%s) must provide one at least', implode(',', $keys))
            );
        }
    }


    protected function sign($data, $signType)
    {
        unset($data['sign']);
        unset($data['sign_type']);

        ksort($data);
        reset($data);

        $query = http_build_query($data);
        $query = urldecode($query);

        $signType = strtoupper($signType);

        if ($signType == 'MD5') {
            $sign = $this->signWithMD5($query);
        } elseif ($signType == 'RSA') {
            $sign = $this->signWithRSA($query, $this->getPrivateKey());
        } else {
            throw new InvalidRequestException('The signType is not allowed');
        }

        return $sign;
    }


    protected function signWithMD5($query)
    {
        return md5($query . $this->getKey());
    }


    private function signWithRSA($data, $privateKey)
    {
        $privateKey = $this->prefixCertificateKeyPath($privateKey);
        $res        = openssl_pkey_get_private($privateKey);
        openssl_sign($data, $sign, $res);
        openssl_free_key($res);
        $sign = base64_encode($sign);

        return $sign;
    }


    /**
     * Prefix the key path with 'file://'
     *
     * @param $key
     *
     * @return string
     */
    private function prefixCertificateKeyPath($key)
    {
        if (strtoupper(substr(PHP_OS, 0, 3)) != 'WIN' && is_file($key) && substr($key, 0, 7) != 'file://') {
            $key = 'file://' . $key;
        }

        return $key;
    }


    protected function filter($data)
    {
        return array_filter($data, 'strlen');
    }
}