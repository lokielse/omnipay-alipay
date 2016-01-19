<?php

namespace Omnipay\Alipay\Message;


class SendGoodsRequest extends BasePurchaseRequest
{
    public $sendGoodsResponse;

    /**
     * Get the raw data array for this message. The format of this varies from gateway to
     * gateway, but will usually be either an associative array, or a SimpleXMLElement.
     *
     * @return mixed
     */
    public function getData()
    {
        $this->validateData();

        $data = array(
            "service"           => $this->getService(),
            "partner"           => $this->getPartner(),
            "trade_no"          => $this->getTradeNo(),
            "logistics_name"    => $this->getLogisticsName(),
            "transport_type"    => $this->getTransportType(),
            "_input_charset"    => $this->getInputCharset()
        );

        $data              = array_filter($data);
        $data['sign']      = $this->getParamsSignature($data);
        $data['sign_type'] = $this->getSignType();

        return $data;
    }

    protected function getSendGoodsResponse($data)
    {
        $endpoint = $this->getEndpoint();

        $url = "{$endpoint}?";

        foreach ($data as $key => $value) {
            $url .= $key . '=' . $value . '&';
        }

        $responseTxt = $this->getHttpResponseGET($url);

        return $responseTxt;
    }

    protected function getHttpResponseGET($url)
    {
        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_HEADER, 0);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, true);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 2);
        $responseText = curl_exec($curl);
        curl_close($curl);

        return $responseText;
    }

    public function sendData($data)
    {
        $this->sendGoodsResponse = $this->getSendGoodsResponse($data);
        $data['success'] = $this->getParameter('is_success') == 'T';

        return $this->response = new SendGoodsResponse($this, $data);
    }

    protected function validateData()
    {
        $this->validate(
            'service',
            'partner',
            'key',
            'seller_email',
            'trade_no',
            'logistics_name',
            'transport_type',
            'input_charset'
        );
    }

    public function getTradeNo()
    {
        return $this->getParameter('trade_no');
    }

    public function setTradeNo($trade_no)
    {
        return $this->setParameter('trade_no', $trade_no);
    }

    public function getLogisticsName()
    {
        return $this->getParameter('logistics_name');
    }

    public function setLogisticsName($logistics_name)
    {
        return $this->setParameter('logistics_name', $logistics_name);
    }

    public function getInvoiceNo()
    {
        return $this->getParameter('invoice_no');
    }

    public function setInvoiceNo($invoice_no)
    {
        return $this->setParameter('invoice_no', $invoice_no);
    }

    public function getTransportType()
    {
        return $this->getParameter('transport_type');
    }

    public function setTransportType($transport_type)
    {
        return $this->setParameter('transport_type', $transport_type);
    }

    public function getCreateTransportType()
    {
        return $this->getParameter('create_transport_type');
    }

    public function setCreateTransportType($create_transport_type)
    {
        return $this->setParameter('create_transport_type', $create_transport_type);
    }

    public function getSellerIp()
    {
        return $this->getParameter('seller_ip');
    }

    public function setSellerIp($seller_ip)
    {
        return $this->setParameter('seller_ip', $seller_ip);
    }
}
