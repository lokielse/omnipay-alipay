<?php

namespace Omnipay\Alipay\Tests;

use Omnipay\Alipay\AopPosGateway;
use Omnipay\Alipay\Responses\DataServiceBillDownloadUrlQueryResponse;
use Omnipay\Alipay\Responses\TradePayResponse;
use Omnipay\Alipay\Responses\TradePreCreateResponse;
use Omnipay\Alipay\Responses\TradeQueryResponse;
use Omnipay\Alipay\Responses\TradeRefundQueryResponse;
use Omnipay\Alipay\Responses\TradeRefundResponse;

class AopPosGatewayTest extends AbstractGatewayTestCase
{

    /**
     * @var AopPosGateway $gateway
     */
    protected $gateway;

    protected $options;


    public function setUp()
    {
        parent::setUp();
        $this->gateway = new AopPosGateway($this->getHttpClient(), $this->getHttpRequest());
        $this->gateway->setAppId($this->appId);
        $this->gateway->setPrivateKey($this->appPrivateKey);
        $this->gateway->setEncryptKey($this->appEncryptKey);
        $this->gateway->setNotifyUrl('https://www.example.com/notify');
        //$this->gateway->sandbox();
    }


    public function testCapture()
    {
        /**
         * @var TradePayResponse $response
         */
        $response = $this->gateway->capture(
            [
                'biz_content' => [
                    'out_trade_no' => date('YmdHis') . mt_rand(1000, 9999),
                    'scene'        => 'bar_code',
                    'auth_code'    => '288412621343841260',
                    'subject'      => 'test',
                    'total_amount' => '0.01',
                ]
            ]
        )->send();

        $this->assertArrayHasKey('alipay_trade_pay_response', $response->getData());
        $this->assertFalse($response->isSuccessful());

    }


    public function testPurchase()
    {
        /**
         * @var TradePreCreateResponse $response
         */
        $response = $this->gateway->purchase(
            [
                'biz_content' => [
                    'out_trade_no' => date('YmdHis') . mt_rand(1000, 9999),
                    'subject'      => 'test',
                    'total_amount' => '0.01',
                ]
            ]
        )->send();

        $this->assertArrayHasKey('alipay_trade_precreate_response', $response->getData());
        $this->assertFalse($response->isSuccessful());
        $this->assertFalse($response->isRedirect());
    }


    public function testQuery()
    {
        /**
         * @var TradeQueryResponse $response
         */
        $response = $this->gateway->query(
            [
                'biz_content' => [
                    'out_trade_no' => '201609220542532413'
                ]
            ]
        )->send();

        $this->assertArrayHasKey('alipay_trade_query_response', $response->getData());
        $this->assertFalse($response->isSuccessful());
    }


    public function testRefund()
    {
        /**
         * @var TradeRefundResponse $response
         */
        $response = $this->gateway->refund(
            [
                'biz_content' => [
                    'refund_amount' => '10.01',
                    'out_trade_no'  => '201609220542532413'
                ]
            ]
        )->send();

        $this->assertArrayHasKey('alipay_trade_refund_response', $response->getData());
        $this->assertFalse($response->isSuccessful());
    }


    public function testQueryRefund()
    {
        /**
         * @var TradeRefundQueryResponse $response
         */
        $response = $this->gateway->refundQuery(
            [
                'biz_content' => [
                    'refund_amount'  => '10.01',
                    'out_trade_no'   => '201609220542532412',
                    'out_request_no' => '201609220542532412'
                ]
            ]
        )->send();

        $this->assertArrayHasKey('alipay_trade_fastpay_refund_query_response', $response->getData());
        $this->assertFalse($response->isSuccessful());
    }


    public function testSettle()
    {
        /**
         * @var TradeRefundQueryResponse $response
         */
        $response = $this->gateway->settle(
            [
                'biz_content' => [
                    'out_request_no'     => '201609220542532412',
                    'trade_no'           => '2014030411001007850000672009',
                    'royalty_parameters' => [
                        [
                            'trans_out' => '111111',
                            'trans_in'  => '222222',
                            'amount'    => '0.01',
                        ],
                        [
                            'trans_out' => '111111',
                            'trans_in'  => '333333',
                            'amount'    => '0.02',
                        ]
                    ]
                ]
            ]
        )->send();

        $this->assertArrayHasKey('alipay_trade_order_settle_response', $response->getData());
        $this->assertFalse($response->isSuccessful());
    }


    public function testQueryBillDownloadUrl()
    {
        /**
         * @var DataServiceBillDownloadUrlQueryResponse $response
         */
        $response = $this->gateway->queryBillDownloadUrl(
            [
                'biz_content' => [
                    'bill_type' => 'trade',
                    'bill_date' => '2016-04-05',
                ]
            ]
        )->send();

        $this->assertArrayHasKey('alipay_data_dataservice_bill_downloadurl_query_response', $response->getData());
        $this->assertFalse($response->isSuccessful());
    }
}
