<?php

namespace Omnipay\Alipay\Tests;

use Omnipay\Alipay\AopWapGateway;
use Omnipay\Alipay\Common\Signer;
use Omnipay\Alipay\Responses\AopCompletePurchaseResponse;
use Omnipay\Alipay\Responses\AopCompleteRefundResponse;
use Omnipay\Alipay\Responses\AopTradeWapPayResponse;

class AopWapGatewayTest extends AbstractGatewayTestCase
{

    /**
     * @var AopWapGateway $gateway
     */
    protected $gateway;

    protected $options;


    public function setUp()
    {
        parent::setUp();
        $this->gateway = new AopWapGateway($this->getHttpClient(), $this->getHttpRequest());
        $this->gateway->setAppId($this->appId);
        $this->gateway->setPrivateKey($this->appPrivateKey);
        $this->gateway->setNotifyUrl('https://www.example.com/notify');
        $this->gateway->setReturnUrl('https://www.example.com/return');
    }


    public function testPurchase()
    {
        /**
         * @var AopTradeWapPayResponse $response
         */
        $response = $this->gateway->purchase(
            [
                'biz_content' => [
                    'out_trade_no' => date('YmdHis') . mt_rand(1000, 9999),
                    'total_amount' => 0.01,
                    'subject'      => 'test',
                    'product_code' => 'QUICK_MSECURITY_PAY',
                ]
            ]
        )->send();

        $this->assertTrue($response->isSuccessful());
        $this->assertTrue($response->isRedirect());
        $this->assertNotEmpty($response->getRedirectUrl());
    }
}
