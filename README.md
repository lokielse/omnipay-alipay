# Omnipay: Alipay

**Alipay driver for the Omnipay PHP payment processing library**

[![Build Status](https://img.shields.io/travis/lokielse/omnipay-alipay/master.svg)](https://travis-ci.org/lokielse/omnipay-alipay)
[![Latest Stable Version](https://img.shields.io/packagist/v/lokielse/omnipay-alipay.svg)](https://packagist.org/packages/lokielse/omnipay-alipay)
[![Total Downloads](https://img.shields.io/packagist/dt/lokielse/omnipay-alipay.svg)](https://packagist.org/packages/lokielse/omnipay-alipay)

[Omnipay](https://github.com/omnipay/omnipay) is a framework agnostic, multi-gateway payment
processing library for PHP 5.3+. This package implements Alipay support for Omnipay.

> Cross-border Alipay payment please use [`lokielse/omnipay-global-alipay`](https://github.com/lokielse/omnipay-global-alipay)

## Installation

Omnipay is installed via [Composer](http://getcomposer.org/). To install, simply add it to your `composer.json` file:

```json
{
    "require": {
        "lokielse/omnipay-alipay": "dev-legacy"
    }
}
```

And run composer to update your dependencies:

    $ curl -s http://getcomposer.org/installer | php
    $ php composer.phar update

## Basic Usage

The following gateways are provided by this package:


* Alipay_Express (Alipay Express Checkout) 支付宝即时到账接口
* Alipay_Secured (Alipay Secured Checkout) 支付宝担保交易接口
* Alipay_Dual (Alipay Dual Function Checkout) 支付宝双功能交易接口
* Alipay_WapExpress (Alipay Wap Express Checkout) 支付宝WAP客户端接口
* Alipay_MobileExpress (Alipay Mobile Express Checkout) 支付宝无线支付接口
* Alipay_Bank (Alipay Bank Checkout) 支付宝网银快捷接口

## Usage

### Purchase
```php
$gateway = Omnipay::create('Alipay_Express');
$gateway->setPartner('8888666622221111');
$gateway->setKey('your**key**here');
$gateway->setSellerEmail('merchant@example.com');
$gateway->setReturnUrl('http://www.example.com/return');
$gateway->setNotifyUrl('http://www.example.com/notify');

//For 'Alipay_MobileExpress', 'Alipay_WapExpress'
//$gateway->setPrivateKey('/such-as/private_key.pem');

$options = [
    'out_trade_no' => date('YmdHis') . mt_rand(1000,9999), //your site trade no, unique
    'subject'      => 'test', //order title
    'total_fee'    => '0.01', //order total fee
];

$response = $gateway->purchase($options)->send();

$response->getRedirectUrl();
$response->getRedirectData();

//For 'Alipay_MobileExpress'
//Use the order string with iOS or Android SDK
$response->getOrderString();
```

### Return/Notify [Doc](https://doc.open.alipay.com/docs/doc.htm?spm=a219a.7629140.0.0.m5IwYI&treeId=62&articleId=104743&docType=1#s2)
```php
$gateway = Omnipay::create('Alipay_Express');
$gateway->setPartner('8888666622221111');
$gateway->setKey('your**key**here');
$gateway->setSellerEmail('merchant@example.com');

//For 'Alipay_MobileExpress', 'Alipay_WapExpress'
//$gateway->setAlipayPublicKey('/such-as/alipay_public_key.pem');

$options = [
    'request_params'=> array_merge($_POST, $_GET), //Don't use $_REQUEST for may contain $_COOKIE
];

$response = $gateway->completePurchase($options)->send();

if ($response->isPaid()) {

   // Paid success, your statements go here.

   //For notify, response 'success' only please.
   //die('success');
} else {

   //For notify, response 'fail' only please.
   //die('fail');
}
```

### Refund [Doc](https://doc.open.alipay.com/docs/doc.htm?spm=a219a.7629140.0.0.hXJTAR&treeId=66&articleId=103600&docType=1)
```php
$gateway = Omnipay::create('Alipay_Express');
$gateway->setPartner('8888666622221111');
$gateway->setKey('your**key**here');
$gateway->setSellerEmail('merchant@example.com');
$gateway->setNotifyUrl('http://www.example.com/notify');

//For 'RSA' sign method
//$gateway->setPrivateKey('/such-as/private_key.pem');

$response = $gateway->refund([
    'refund_items' => [
        [
            'out_trade_no'=> '2016091921001004060289492441'
            'amount'      => '298.05'
            'reason'     => 'test1'
        ],
        [
            'out_trade_no'=> '2016091921001004060289492442'
            'amount'      => '298.00'
            'reason'     => 'test2'
        ]
    ],
    'refund_date'  => date('Y-m-d H:i:s'), //Optional
    'batch_no'     => date('Ymd').mt_rand(1000,9999), //Optional
])->send();

$response->getRedirectUrl();
$response->getRedirectData();
```


### Refund Notify [Doc](https://doc.open.alipay.com/docs/doc.htm?spm=a219a.7629140.0.0.zqHx6T&treeId=66&articleId=103601&docType=1)
```php
$gateway = Omnipay::create('Alipay_Express');
$gateway->setPartner('8888666622221111');
$gateway->setKey('your**key**here');
$gateway->setSellerEmail('merchant@example.com');

//For 'RSA' sign method
//$gateway->setAlipayPublicKey('/such-as/alipay_public_key.pem');

$options = [
    'request_params'=> $_POST
];

$response = $gateway->completeRefund($options)->send();

if ($response->isVerifySuccess()) {

   // request verified success, your statements go here.
   //use `batch_no`, `success_num`, `result_details`... in $_POST;

   //For notify, response 'success' only please.
   die('success');
} else {

   //For notify, response 'fail' only please.
   die('fail');
}
```


For general usage instructions, please see the main [Omnipay](https://github.com/omnipay/omnipay)
repository.

## Related

- [Laravel-Omnipay](https://github.com/ignited/laravel-omnipay)
- [Omnipay-GlobalAlipay](https://github.com/lokielse/omnipay-global-alipay)
- [Omnipay-WechatPay](https://github.com/lokielse/omnipay-wechatpay)
- [Omnipay-UnionPay](https://github.com/lokielse/omnipay-unionpay)

## Support

If you are having general issues with Omnipay, we suggest posting on
[Stack Overflow](http://stackoverflow.com/). Be sure to add the
[omnipay tag](http://stackoverflow.com/questions/tagged/omnipay) so it can be easily found.

If you want to keep up to date with release anouncements, discuss ideas for the project,
or ask more detailed questions, there is also a [mailing list](https://groups.google.com/forum/#!forum/omnipay) which
you can subscribe to.

If you believe you have found a bug, please report it using the [GitHub issue tracker](https://github.com/lokielse/omnipay-alipay/issues),
or better yet, fork the library and submit a pull request.
