<?php

namespace Omnipay\Alipay\Tests;

use Omnipay\Alipay\LegacyExpressGateway;
use Omnipay\Alipay\Responses\LegacyExpressPurchaseResponse;
use Omnipay\Alipay\Responses\LegacyQueryResponse;
use Omnipay\Alipay\Responses\LegacyRefundResponse;

class LegacyExpressGatewayTest extends AbstractGatewayTestCase
{

    /**
     * @var LegacyExpressGateway $gateway
     */
    protected $gateway;

    protected $options;


    public function setUp()
    {
        parent::setUp();
        $this->gateway = new LegacyExpressGateway($this->getHttpClient(), $this->getHttpRequest());
        $this->gateway->setPartner($this->partner);
        $this->gateway->setKey($this->key);
        $this->gateway->setSellerId($this->sellerId);
        $this->gateway->setNotifyUrl('https://www.example.com/notify');
        $this->gateway->setReturnUrl('https://www.example.com/return');
        $this->options = [
            'out_trade_no' => '2014010122390001',
            'subject'      => 'test',
            'total_fee'    => '0.01',
        ];
    }


    public function testPurchase()
    {
        /**
         * @var LegacyExpressPurchaseResponse $response
         */
        $response = $this->gateway->purchase($this->options)->send();
        $this->assertTrue($response->isSuccessful());
        $this->assertTrue($response->isRedirect());
        $this->assertNotEmpty($response->getRedirectUrl());
    }


    public function testRefund()
    {
        /**
         * @var LegacyRefundResponse $response
         */
        $response = $this->gateway->refund(
            [
                'refund_items' => [
                    [
                        'out_trade_no' => '2016092021001003280286716852',
                        'amount'       => '1',
                        'reason'       => 'test',
                    ]
                ]
            ]
        )->send();

        $this->assertTrue($response->isSuccessful());
        $this->assertTrue($response->isRedirect());
        $this->assertNotEmpty($response->getRedirectUrl());
    }


    public function testQuery()
    {
        /**
         * @var LegacyQueryResponse $response
         */
        $response = $this->gateway->query(
            [
                'out_trade_no' => '2016092021001003280286716850'
            ]
        )->send();

        $this->assertFalse($response->isSuccessful());
    }
}
