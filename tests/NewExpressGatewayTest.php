<?php

namespace Omnipay\Alipay\Tests;

use Omnipay\Alipay\Message\QueryOrderStatusResponse;
use Omnipay\Alipay\NewExpressGateway;
use Omnipay\Alipay\Responses\CreateOrderResponse;
use Omnipay\Alipay\Responses\RefundResponse;

class NewExpressGatewayTest extends AbstractGatewayTestCase
{

    /**
     * @var NewExpressGateway $gateway
     */
    protected $gateway;

    protected $options;


    public function setUp()
    {
        parent::setUp();
        $this->gateway = new NewExpressGateway($this->getHttpClient(), $this->getHttpRequest());
        $this->gateway->setPartner($this->partner);
        $this->gateway->setKey($this->key);
        $this->gateway->setSellerId($this->sellerId);
        $this->gateway->setNotifyUrl('https://www.example.com/notify');
        $this->gateway->setReturnUrl('https://www.example.com/return');
        $this->options = array (
            'out_trade_no' => '2014010122390001',
            'subject'      => 'test',
            'total_fee'    => '0.01',
        );
    }


    public function testPurchase()
    {
        /**
         * @var CreateOrderResponse $response
         */
        $response = $this->gateway->purchase($this->options)->send();
        $this->assertTrue($response->isSuccessful());
        $this->assertTrue($response->isRedirect());
        $this->assertNotEmpty($response->getRedirectUrl());
        die($response->getRedirectUrl());
        $redirectData = $response->getRedirectData();
        $this->assertSame('https://www.example.com/return', $redirectData['return_url']);
    }


    public function testRefund()
    {
        /**
         * @var RefundResponse $response
         */
        $response = $this->gateway->refund(
            array (
                'refund_items' => array(
                    array (
                        'out_trade_no' => '2016092021001003280286716852',
                        'amount'       => '1',
                        'reason'       => 'test',
                    )
                )
            )
        )->send();
        $this->assertTrue($response->isSuccessful());
        $this->assertTrue($response->isRedirect());
        $this->assertNotEmpty($response->getRedirectUrl());
        die($response->getRedirectUrl());
        $redirectData = $response->getRedirectData();
        $this->assertSame('https://www.example.com/return', $redirectData['return_url']);
    }

    public function testQueryOrderStatus()
    {
        /**
         * @var QueryOrderStatusResponse $response
         */
        $response = $this->gateway->queryOrderStatus(
            array (
                'out_trade_no'=>'2016092021001003280286716852'
            )
        )->send();
        $this->assertFalse($response->isSuccessful());
        $this->assertFalse($response->isRedirect());
    }
}
