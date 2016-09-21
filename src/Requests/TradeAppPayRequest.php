<?php

namespace Omnipay\Alipay\Requests;

use Omnipay\Alipay\Responses\TradeAppPayResponse;
use Omnipay\Common\Message\ResponseInterface;

class TradeAppPayRequest extends AopRequest
{

    protected $method = 'alipay.trade.app.pay';


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

        $data = $this->filter($data);
        ksort($data);
        $data['sign'] = $this->sign($data, $this->getSignType());

        return $data;
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
        $data['order_string'] = http_build_query($data);

        return $this->response = new TradeAppPayResponse($this, $data);
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

}