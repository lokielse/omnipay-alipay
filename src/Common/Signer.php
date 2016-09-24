<?php

namespace Omnipay\Alipay\Common;

/**
 * Sign Tool for Alipay
 * Class Signer
 * @package Omnipay\Alipay\Common
 */
class Signer
{

    const ENCODE_POLICY_QUERY = 'QUERY';
    const ENCODE_POLICY_JSON = 'JSON';

    protected $ignores = ['sign', 'sign_type'];

    protected $sort = true;

    protected $encodePolicy = self::ENCODE_POLICY_QUERY;

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

        if ($this->encodePolicy == self::ENCODE_POLICY_QUERY) {
            return urldecode(http_build_query($params));
        } elseif ($this->encodePolicy == self::ENCODE_POLICY_JSON) {
            return json_encode($params);
        } else {
            return null;
        }
    }


    /**
     * @return mixed
     */
    public function getParamsToSign()
    {
        $params = $this->params;

        $this->unsetKeys($params);

        $params = $this->filter($params);

        if ($this->sort) {
            $this->sort($params);
        }

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


    public function verifyWithMD5($content, $sign, $key)
    {
        return md5($content . $key) == $sign;
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


    /**
     * @param boolean $sort
     *
     * @return Signer
     */
    public function setSort($sort)
    {
        $this->sort = $sort;

        return $this;
    }


    /**
     * @param int $encodePolicy
     *
     * @return Signer
     */
    public function setEncodePolicy($encodePolicy)
    {
        $this->encodePolicy = $encodePolicy;

        return $this;
    }
}
