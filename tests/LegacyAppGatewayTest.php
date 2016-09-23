<?php

namespace Omnipay\Alipay\Tests;

use Omnipay\Alipay\LegacyAppGateway;
use Omnipay\Alipay\Responses\LegacyAppPurchaseResponse;

class LegacyAppGatewayTest extends AbstractGatewayTestCase
{

    /**
     * @var LegacyAppGateway $gateway
     */
    protected $gateway;

    protected $options;


    public function setUp()
    {
        parent::setUp();

        $this->gateway = new LegacyAppGateway($this->getHttpClient(), $this->getHttpRequest());
    }


    public function testCreateOrder()
    {
        $partner    = '123456789';
        $privateKey = ALIPAY_ASSET_DIR . '/dist/common/rsa_private_key.pem';

        //$partner    = ALIPAY_PARTNER;
        //$privateKey = ALIPAY_ASSET_DIR . '/dist/common/rsa_private_key.pem';

        $this->assertFileExists($privateKey);

        $this->gateway = new LegacyAppGateway($this->getHttpClient(), $this->getHttpRequest());
        $this->gateway->setPartner($partner);
        $this->gateway->setSellerId($partner);
        $this->gateway->setPrivateKey($privateKey);
        $this->gateway->setNotifyUrl('https://www.example.com/notify');

        $this->options = [
            'out_trade_no' => '2014010122390001',
            'subject'      => 'test',
            'total_fee'    => '0.01',
        ];

        /**
         * @var LegacyAppPurchaseResponse $response
         */
        $response = $this->gateway->purchase($this->options)->send();

        $this->assertEquals('4aa4efe85e1d7f305536b6fe996e8e34', md5($response->getOrderString()));
    }
}
