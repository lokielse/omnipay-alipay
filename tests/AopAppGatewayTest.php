<?php

namespace Omnipay\Alipay\Tests;

use Omnipay\Alipay\AopAppGateway;
use Omnipay\Alipay\AopWapGateway;
use Omnipay\Alipay\Responses\CreateOrderResponse;
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
        $str = '\U7528\U6237\U4e2d\U9014\U53d6\U6d88';

        /**
         * @var TradeAppPayResponse $response
         */
        $response = $this->gateway->purchase(
            array (
                'biz_content' => array (
                    'subject'      => 'test',
                    'out_trade_no' => date('YmdHis') . mt_rand(1000, 9999),
                    'total_amount' => 88.88,
                    'product_code' => 'QUICK_MSECURITY_PAY',
                )
            )
        )->send();

        $this->assertTrue($response->isSuccessful());
        $this->assertFalse($response->isRedirect());
        die($response->getOrderString());
    }
}
