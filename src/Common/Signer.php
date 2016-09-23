<?php

namespace Omnipay\Alipay\Common;

/**
 * Sign Tool for Alipay
 * Class Signer
 * @package Omnipay\Alipay\Common
 */
class Signer
{
    protected $ignores = ['sign', 'sign_type'];

    /**
     * @var array
     */
    private $params;


    public function __construct(array $params = [])
    {
        $this->params = $params;
    }


    public function signWithMD5($key)
    {
        $content = $this->getContentToSign();

        return md5($content . $key);
    }


    public function getContentToSign()
    {
        $params = $this->getParamsToSign();

        return urldecode(http_build_query($params));
    }


    /**
     * @return mixed
     */
    public function getParamsToSign()
    {
        $params = $this->params;

        $this->unsetKeys($params);

        $params = $this->filter($params);

        $this->sort($params);

        return $params;
    }


    /**
     * @param $params
     */
    protected function unsetKeys(&$params)
    {
        foreach ($this->getIgnores() as $key) {
            unset($params[$key]);
        }
    }


    /**
     * @return array
     */
    public function getIgnores()
    {
        return $this->ignores;
    }


    /**
     * @param array $ignores
     *
     * @return $this
     */
    public function setIgnores($ignores)
    {
        $this->ignores = $ignores;

        return $this;
    }


    private function filter($params)
    {
        return array_filter($params, 'strlen');
    }


    /**
     * @param $params
     */
    protected function sort(&$params)
    {
        ksort($params);
    }


    public function signWithRSA($privateKey, $alg = OPENSSL_ALGO_SHA1)
    {
        $content = $this->getContentToSign();

        $sign = $this->signContentWithRSA($content, $privateKey, $alg);

        return $sign;
    }


    public function signContentWithRSA($content, $privateKey, $alg = OPENSSL_ALGO_SHA1)
    {
        $privateKey = $this->prefix($privateKey);
        $res        = openssl_pkey_get_private($privateKey);
        openssl_sign($content, $sign, $res, $alg);
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
    private function prefix($key)
    {
        if (strtoupper(substr(PHP_OS, 0, 3)) != 'WIN' && is_file($key) && substr($key, 0, 7) != 'file://') {
            $key = 'file://' . $key;
        }

        return $key;
    }


    public function verifyWithRSA($content, $sign, $publicKey, $alg = OPENSSL_ALGO_SHA1)
    {
        $publicKey = $this->prefix($publicKey);

        $res = openssl_pkey_get_public($publicKey);

        if (! $res) {
            throw new \Exception('The publicKey is invalid');
        }

        $result = (bool) openssl_verify($content, base64_decode($sign), $res, $alg);

        openssl_free_key($res);

        return $result;
    }
}
