<?php

namespace Omnipay\Alipay\Requests;

use Omnipay\Alipay\Responses\NotifyVerifyResponse;
use Omnipay\Common\Message\ResponseInterface;

/**
 * https://doc.open.alipay.com/docs/doc.htm?spm=a219a.7386797.0.0.YLb8ix&treeId=58&articleId=103597&docType=1
 * Class NotifyVerifyRequest
 * @package Omnipay\Alipay\Requests
 */
class NotifyVerifyRequest extends Request
{

    protected $service = 'notify_verify';


    /**
     * Get the raw data array for this message. The format of this varies from gateway to
     * gateway, but will usually be either an associative array, or a SimpleXMLElement.
     *
     * @return mixed
     */
    public function getData()
    {
        $this->validate(
            'partner',
            'notify_id'
        );

        $data = $this->parameters->all();

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
        $url = sprintf('%s?%s', $this->getEndpoint(), http_build_query($data));

        $response = $this->httpClient->get($url)->send()->getBody();

        $data = array (
            'result' => $response
        );

        return $this->response = new NotifyVerifyResponse($this, $data);
    }


    /**
     * @return mixed
     */
    public function getNotifyId()
    {
        return $this->getParameter('notify_id');
    }


    /**
     * @param $value
     *
     * @return $this
     */
    public function setNotifyId($value)
    {
        return $this->setParameter('notify_id', $value);
    }
}