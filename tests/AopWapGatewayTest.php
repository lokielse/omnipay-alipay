<?php

namespace Omnipay\Alipay\Tests;

use Omnipay\Alipay\AopAppGateway;
use Omnipay\Alipay\AopWapGateway;
use Omnipay\Alipay\Responses\CreateOrderResponse;
use Omnipay\Alipay\Responses\TradeAppPayResponse;
use Omnipay\Alipay\Responses\TradeWapPayResponse;

class NewWapGatewayTest extends AbstractGatewayTestCase
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
        //$this->gateway->setEncryptKey($this->appEncryptKey);
        //$this->gateway->setNotifyUrl('https://www.example.com/notify');
        //$this->gateway->setReturnUrl('https://www.example.com/notify');
        $this->gateway->setEndpoint('https://openapi.alipaydev.com/gateway.do');
    }


    public function testPurchase()
    {
        /**
         * @var TradeWapPayResponse $response
         */
        $response = $this->gateway->purchase(
            array (
                'biz_content' => array (
                    'out_trade_no' => date('YmdHis') . mt_rand(1000, 9999),
                    'total_amount' => 88.88,
                    'subject'      => 'test',
                    'product_code' => 'QUICK_MSECURITY_PAY',
                )
            )
        )->send();

        $this->assertTrue($response->isSuccessful());
        $this->assertFalse($response->isRedirect());

        die($response->getHtml());
    }
}
