<?php

namespace Omnipay\Alipay\Responses;

use Guzzle\Http\Client as HttpClient;
use Omnipay\Alipay\Requests\TradePayRequest;
use Omnipay\Alipay\Requests\TradeQueryRequest;
use Symfony\Component\HttpFoundation\Request as HttpRequest;

class TradePayResponse extends AbstractAopResponse
{
    protected $key = 'alipay_trade_pay_response';

    /**
     * @var TradePayRequest
     */
    protected $request;


    public function isPayFailed()
    {
        return $this->getCode() == '40004';
    }


    public function handle($onSuccess, $onFail)
    {
        if ($this->isPaid()) {
            call_user_func($onSuccess, $this->getData());
        } elseif ($this->isWaitPay()) {
            /**
             * Loop Query
             */
            $loop      = true;
            $loopCount = 5;

            while ($loop) {
                $request = new TradeQueryRequest(new HttpClient, new HttpRequest());
                $request->setBizContent(
                    ['out_trade_no' => $this->request->getBizContent()['out_trade_no']]
                );
                /**
                 * @var TradeQueryResponse $response
                 */
                $response = $request->send();

                if ($response->isPaid()) {
                    $loop = true;
                    call_user_func($onSuccess, $this->getData());
                } else {
                    if ($loopCount == 0) {
                        $loop = false;
                    } else {
                        sleep(5);
                        $loopCount--;
                    }
                }
            }
        } elseif ($this->isUnknownException()) {
            call_user_func($onFail, $this->getData());
        }
    }


    public function isPaid()
    {
        return $this->getCode() == '10000';
    }


    public function isWaitPay()
    {
        return $this->getCode() == '10003';
    }


    public function isUnknownException()
    {
        return $this->getCode() == '20000';
    }
}
