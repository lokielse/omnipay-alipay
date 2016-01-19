<?php

namespace Omnipay\Alipay\Message;

use Omnipay\Common\Exception\InvalidRequestException;

class ExpressCompletePurchaseRequest extends BasePurchaseRequest
{

    public $verifyResponse;

    protected $endpoint = 'http://notify.alipay.com/trade/notify_query.do?';

    protected $endpointHttps = 'https://mapi.alipay.com/gateway.do?service=notify_verify&';


    /**
     * Get the raw data array for this message. The format of this varies from gateway to
     * gateway, but will usually be either an associative array, or a SimpleXMLElement.
     *
     * @return mixed
     */
    public function getData()
    {
        $this->validate('request_params', 'transport', 'partner', 'sign_type', 'key');
        $this->validateRequestParams('trade_status', 'out_trade_no', 'trade_no', 'sign');

        return $this->getParameters();
    }


    public function validateRequestParams()
    {
        foreach (func_get_args() as $key) {
            $value = $this->getRequestParam($key);
            if (is_null($value)) {
                throw new InvalidRequestException("The request_params.$key parameter is required");
            }
        }
    }


    public function getRequestParam($key)
    {
        $params = $this->getRequestParams();
        if (isset($params[$key])) {
            return $params[$key];
        } else {
            return null;
        }
    }


    /**
     * The parameters alipay callback to server
     * @return mixed
     */
    public function getRequestParams()
    {
        return $this->getParameter('request_params');
    }


    public function setRequestParams($value)
    {
        return $this->setParameter('request_params', $value);
    }


    public function getInputCharset()
    {
        return $this->getParameter('input_charset');
    }


    public function setInputCharset($value)
    {
        return $this->setParameter('input_charset', $value);
    }


    public function setTransport($value)
    {
        return $this->setParameter('transport', $value);
    }


    public function setPartner($value)
    {
        return $this->setParameter('partner', $value);
    }


    public function setNotifyId($value)
    {
        return $this->setRequestParam('notify_id', $value);
    }


    public function setRequestParam($key, $value)
    {
        $params       = $this->getRequestParams();
        $params[$key] = $value;

        return $this;
    }


    /**
     * @deprecated use getAlipayPublicKey instead
     * @return mixed
     */
    public function getAliPublicKey()
    {
        return $this->getParameter('alipay_public_key');
    }


    /**
     * @deprecated use setAlipayPublicKey instead
     *
     * @param $value
     *
     * @return $this
     */
    public function setAliPublicKey($value)
    {
        return $this->setParameter('alipay_public_key', $value);
    }


    public function setAlipayPublicKey($value)
    {
        return $this->setParameter('alipay_public_key', $value);
    }


    public function getTradeStatus()
    {
        return $this->getRequestParam('trade_status');
    }


    public function setTradeStatus($value)
    {
        return $this->setRequestParam('trade_status', $value);
    }


    public function setCaCertPath($value)
    {
        if (! is_file($value)) {
            throw new InvalidRequestException("The ca_cert_path($value) is not exists");
        }

        return $this->setParameter('ca_cert_path', $value);
    }


    public function getCaCertPath()
    {
        return $this->getParameter('ca_cert_path');
    }


    public function getNotifyId()
    {
        return $this->getRequestParam('notify_id');
    }


    public function getPartner()
    {
        return $this->getParameter('partner');
    }


    public function getTransport()
    {
        return $this->getParameter('transport');
    }

    public function setExtraCommonParam($value)
    {
        $this->setParameter('extra_common_param', $value);
    }

    public function getExtraCommonParam()
    {
        return $this->getParameter('extra_common_param');
    }

    public function setExtendParam($value)
    {
        $this->setParameter('extend_param', $value);
    }

    public function getExtendParam()
    {
        return $this->getParameter('extend_param');
    }

    public function sendData($data)
    {
        $notifyId = $this->getNotifyId();

        if ($notifyId) {
            $this->verifyResponse   = $this->getVerifyResponse($notifyId);
            $data['verify_success'] = $this->isSignMatch();
            $status                 = $this->getTradeStatus();
            $statusOk               = $status == 'TRADE_FINISHED' || $status == 'TRADE_SUCCESS';
            $data['is_paid']        = $data['verify_success'] && $this->isNotifyVerifiedOK() && $statusOk;
        } else {
            $status                 = $this->getTradeStatus();
            $statusOk               = $status == 'TRADE_FINISHED' || $status == 'TRADE_SUCCESS';
            $data['verify_success'] = $this->isSignMatch();
            $data['is_paid']        = $data['verify_success'] && $statusOk;
        }

        return $this->response = new ExpressCompletePurchaseResponse($this, $data);
    }


    protected function getVerifyResponse($notifyId)
    {
        $partner  = $this->getPartner();
        $endpoint = $this->getEndpoint();

        $url = "{$endpoint}partner={$partner}&notify_id={$notifyId}";

        $responseTxt = $this->getHttpResponseGET($url, $this->getCacertPath());

        return $responseTxt;
    }


    public function getAlipayPublicKey()
    {
        return $this->getParameter('alipay_public_key');
    }


    protected function getHttpResponseGET($url, $caCertUrl)
    {
        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_HEADER, 0);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, true);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 2);
        curl_setopt($curl, CURLOPT_CAINFO, $caCertUrl);
        $responseText = curl_exec($curl);
        curl_close($curl);

        return $responseText;
    }


    protected function isSignMatch()
    {
        $requestSign = $this->getRequestParam('sign');

        $queryString = http_build_query($this->getParamsToSign());
        $queryString = urldecode($queryString);

        $signType = strtoupper($this->getSignType());

        if ($signType == 'MD5') {
            return $requestSign === md5($queryString . $this->getKey());
        } elseif ($signType == 'RSA' || $signType == '0001') {
            $publicKey = $this->getAlipayPublicKey();
            $result    = $this->verifyWithRSA($queryString, trim($publicKey), $requestSign);

            return $result;
        } else {
            return false;
        }
    }


    protected function getParamsToSign()
    {
        $params = $this->getRequestParams();
        unset($params['sign']);
        unset($params['sign_type']);
        ksort($params);
        reset($params);

        return $params;
    }


    protected function verifyWithRSA($data, $publicKey, $sign)
    {
        $publicKey = $this->prefixCertificateKeyPath($publicKey);
        $res       = openssl_pkey_get_public($publicKey);
        $result    = (bool) openssl_verify($data, base64_decode($sign), $res);
        openssl_free_key($res);

        return $result;
    }


    protected function isNotifyVerifiedOK()
    {
        if (preg_match("/true$/i", $this->verifyResponse)) {
            return true;
        } else {
            return false;
        }
    }


    public function getEndpoint()
    {
        if (strtolower($this->getTransport()) == 'http') {
            return $this->endpoint;
        } else {
            return $this->endpointHttps;
        }
    }
}
