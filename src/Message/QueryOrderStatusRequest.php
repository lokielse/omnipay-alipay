<?php

namespace Omnipay\Alipay\Message;

use Omnipay\Common\Exception\InvalidRequestException;
use Omnipay\Common\Message\ResponseInterface;

class QueryOrderStatusRequest extends BasePurchaseRequest
{

    protected $service = 'single_trade_query';

    protected $endpoint = 'http://mapi.alipay.com/gateway.do';

    protected $endpointHttps = 'https://mapi.alipay.com/gateway.do';


    /**
     * @return mixed
     * @throws \Exception
     */
    public function getData()
    {
        $this->validateData();

        $data = $this->getParamsToSign();

        $data['sign'] = $this->getParamsSignature($data);

        $data['sign_type'] = $this->getSignType();

        return $data;
    }


    protected function validateData()
    {
        $outTradeNo = $this->getOutTradeNo();
        $tradeNo    = $this->getTradeNo();

        if (! $outTradeNo && ! $tradeNo) {
            throw new InvalidRequestException('The `out_trade_no` and `trade_no` must provide one');
        }
    }


    private function getParamsToSign()
    {
        return array (
            "service"        => $this->service,
            "partner"        => $this->getPartner(),
            "trade_no"       => $this->getTradeNo(),
            "out_trade_no"   => $this->getOutTradeNo(),
            "_input_charset" => $this->getInputCharset()
        );
    }


    public function getTradeNo()
    {
        return $this->getParameter('trade_no');
    }


    public function setTradeNo($value)
    {
        $this->setParameter('trade_no', $value);
    }


    /**
     * Send the request with specified data
     *
     * @param  mixed $data The data to send
     *
     * @return ResponseInterface
     */
    public function sendData($data)
    {
        $url = sprintf('%s?%s', $this->getEndpoint(), http_build_query($this->getData()));

        $result = $this->getHttpResponseGET($url, $this->getCaCertPath());

        $xml  = simplexml_load_string($result);
        $json = json_encode($xml);
        $data = json_decode($json, true);

        return $this->response = new QueryOrderStatusResponse($this, $data);
    }


    protected function getHttpResponseGET($url, $caCertUrl)
    {
        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_HEADER, 0);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, true);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 2);
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($curl, CURLOPT_CAINFO, $caCertUrl);
        $responseText = curl_exec($curl);
        curl_close($curl);

        return $responseText;
    }


    public function getEndpoint()
    {
        if (strtolower($this->getTransport()) == 'http') {
            return $this->endpoint;
        } else {
            return $this->endpointHttps;
        }
    }


    public function getCaCertPath()
    {
        return $this->getParameter('ca_cert_path');
    }


    public function setCaCertPath($value)
    {
        $this->setParameter('ca_cert_path', $value);
    }
}
