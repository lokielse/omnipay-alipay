<?php

namespace Omnipay\Alipay\Requests;

use Omnipay\Alipay\Responses\TradeCancelResponse;
use Omnipay\Alipay\Responses\TradePayResponse;
use Omnipay\Alipay\Responses\TradeQueryResponse;
use Omnipay\Common\Exception\InvalidRequestException;

/**
 * Class TradePayRequest
 * @package Omnipay\Alipay\Requests
 *
 * @link    https://doc.open.alipay.com/docs/api.htm?docType=4&apiId=850
 */
class TradePayRequest extends AbstractAopRequest
{

    protected $method = 'alipay.trade.pay';

    protected $notifiable = true;

    protected $polling = true;

    protected $pollingWait = 3;

    protected $pollingAttempts = 10;

    /**
     * @var TradePayResponse|TradeQueryResponse|TradeCancelResponse
     */
    protected $response;


    /**
     * Send the request with specified data
     *
     * @param  mixed $data The data to send
     *
     * @return TradePayResponse|TradeQueryResponse
     * @throws InvalidRequestException
     */
    public function sendData($data)
    {
        $data = parent::sendData($data);

        $this->response = new TradePayResponse($this, $data);

        if ($this->response->isWaitPay() && $this->polling) {
            $this->polling();
        }

        return $this->response;
    }


    /**
     * @link https://img.alicdn.com/top/i1/LB14VRALXXXXXcnXXXXXXXXXXXX
     */
    protected function polling()
    {
        $currentAttempt = 0;

        while ($currentAttempt++ < $this->pollingAttempts) {
            /**
             * Query Order Trade Status
             */
            $this->query();

            if ($this->response->getCode() >= 40000) {
                break;
            } elseif ($this->response->isPaid()) {
                break;
            } elseif ($this->response->isClosed()) {
                break;
            }

            sleep($this->pollingWait);
        }

        /**
         * Close Order
         */
        if ($this->response->isWaitPay()) {
            $this->cancel();
        }
    }


    protected function query()
    {
        $request = new TradeQueryRequest($this->httpClient, $this->httpRequest);
        $request->initialize($this->parameters->all());
        $request->setEndpoint($this->getEndpoint());
        $request->setPrivateKey($this->getPrivateKey());
        $request->setBizContent(
            ['out_trade_no' => $this->getBizData('out_trade_no')]
        );

        $this->response = $request->send();
    }


    protected function cancel()
    {
        $request = new TradeCancelRequest($this->httpClient, $this->httpRequest);
        $request->initialize($this->parameters->all());
        $request->setEndpoint($this->getEndpoint());
        $request->setPrivateKey($this->getPrivateKey());
        $request->setBizContent(
            ['out_trade_no' => $this->getBizData('out_trade_no')]
        );

        $this->response = $request->send();
    }


    public function validateParams()
    {
        parent::validateParams();

        $this->validateBizContent(
            'out_trade_no',
            'scene',
            'auth_code',
            'subject'
        );

        $this->validateBizContentOne(
            'total_amount',
            'discountable_amount',
            'undiscountable_amount'
        );
    }


    /**
     * @param boolean $polling
     *
     * @return TradePayRequest
     */
    public function setPolling($polling)
    {
        $this->polling = $polling;

        return $this;
    }


    /**
     * @param int $pollingWait
     *
     * @return TradePayRequest
     */
    public function setPollingWait($pollingWait)
    {
        $this->pollingWait = $pollingWait;

        return $this;
    }


    /**
     * @param int $pollingAttempts
     *
     * @return TradePayRequest
     */
    public function setPollingAttempts($pollingAttempts)
    {
        $this->pollingAttempts = $pollingAttempts;

        return $this;
    }
}
