<?php

namespace Omnipay\Alipay\Tests;

use Omnipay\Alipay\AopAppGateway;
use Omnipay\Alipay\Responses\TradeAppPayResponse;

class AopAppGatewayTest extends AbstractGatewayTestCase
{

    /**
     * @var AopAppGateway $gateway
     */
    protected $gateway;

    protected $options;


    public function setUp()
    {
        parent::setUp();
        $this->gateway = new AopAppGateway($this->getHttpClient(), $this->getHttpRequest());
        $this->gateway->setAppId($this->appId);
        $this->gateway->setPrivateKey($this->appPrivateKey);
        $this->gateway->setEncryptKey($this->appEncryptKey);
        $this->gateway->setNotifyUrl('https://www.example.com/notify');
    }


    public function testPurchase()
    {
        /**
         * @var TradeAppPayResponse $response
         */
        $response = $this->gateway->purchase(
            [
                'biz_content' => [
                    'subject'      => 'test',
                    'out_trade_no' => date('YmdHis') . mt_rand(1000, 9999),
                    'total_amount' => '0.01',
                    'product_code' => 'QUICK_MSECURITY_PAY',
                ]
            ]
        )->send();

        $this->assertTrue($response->isSuccessful());
        $this->assertFalse($response->isRedirect());
        $this->assertNotEmpty($response->getOrderString());
    }
}
