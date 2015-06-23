<?php
/**
 * Created by sqiu.
 * CreateTime: 14-1-2 下午11:29
 *
 */
namespace Omnipay\Alipay\Message;

use DOMDocument;

class WapExpressCompletePurchaseRequest extends ExpressCompletePurchaseRequest
{

    /**
     * Get the raw data array for this message. The format of this varies from gateway to
     * gateway, but will usually be either an associative array, or a SimpleXMLElement.
     *
     * @return mixed
     */
    public function getData()
    {
        $this->validate('request_params', 'partner', 'private_key');
        $this->validateRequestParams('notify_data', 'service', 'v', 'sec_id');

        return $this->getParameters();
    }

    public function getPrivateKey()
    {
        return $this->getParameter('private_key');
    }

    public function setPrivateKey($value)
    {
        return $this->setParameter('private_key', $value);
    }

    public function getNotifyData()
    {
        return $this->getRequestParam('notify_data');
    }

    public function setNotifyData($value)
    {
        return $this->setRequestParam('notify_data', $value);
    }

    public function getOutTradeNo()
    {
        return $this->getRequestParam('out_trade_no');
    }

    public function setOutTradeNO($value)
    {
        return $this->setRequestParam('out_trade_no', $value);
    }

    public function getTradeNo()
    {
        return $this->getRequestParam('trade_no');
    }

    public function setTradeNO($value)
    {
        return $this->setRequestParam('trade_no', $value);
    }

    protected function rsaDecrypt($content, $private_key)
    {
        $res = openssl_pkey_get_private($private_key);
        $content = base64_decode($content);
        $result = '';
        for ($i = 0; $i < strlen($content) / 128; $i++) {
            $data = substr($content, $i * 128, 128);
            openssl_private_decrypt($data, $decrypt, $res);
            $result .= $decrypt;
        }
        openssl_free_key($res);

        return $result;
    }

    protected function decrypt($str)
    {
        return $this->rsaDecrypt($str, $this->getPrivateKey());
    }

    private function parseDataFromXML()
    {
        $notifyData = $this->decrypt($this->getNotifyData());
        $doc = new DOMDocument();
        $doc->loadXML($notifyData);
        if (!empty($doc->getElementsByTagName('notify')->item(0)->nodeValue)) {
            $outTradeNo = $doc->getElementsByTagName('out_trade_no')->item(0)->nodeValue;
            $tradeNo = $doc->getElementsByTagName('trade_no')->item(0)->nodeValue;
            $tradeStatus = $doc->getElementsByTagName('trade_status')->item(0)->nodeValue;
            $this->setOutTradeNO($outTradeNo);
            $this->setTradeNO($tradeNo);
            $this->setTradeStatus($tradeStatus);
        }
    }

    public function sendData($data)
    {
        if ($this->isSignMatch()) {
            $data['verify_success'] = true;
            $this->parseDataFromXML();
            $data['trade_status'] = $this->getTradeStatus();
        } else {
            $data['verify_success'] = false;
        }

        return $this->response = new ExpressCompletePurchaseResponse($this, $data);
    }

    protected function getParamsToSign($para)
    {
        $params['service'] = $this->getRequestParam('service');
        $params['v'] = $this->getRequestParam('v');
        $params['sec_id'] = $this->getRequestParam('sec_id');
        $params['notify_data'] = $this->getRequestParam('notify_data');

        return $params;
    }
}
