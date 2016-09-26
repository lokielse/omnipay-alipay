# Omnipay: Alipay

[![travis][ico-travis]][link-travis]
[![Latest Version on Packagist][ico-version]][link-packagist]
[![Total Downloads][ico-downloads]][link-downloads]
[![Code Coverage][ico-code-coverage]][link-code-coverage]
[![Software License][ico-license]](LICENSE)




**Alipay driver for the Omnipay PHP payment processing library**

[Omnipay](https://github.com/omnipay/omnipay) is a framework agnostic, multi-gateway payment
processing library for PHP. This package implements Alipay support for Omnipay.

> Cross-border Alipay payment please use [`lokielse/omnipay-global-alipay`](https://github.com/lokielse/omnipay-global-alipay)
 
> Legacy Version please use [`"lokielse/omnipay-alipay": "legacy"`](https://github.com/lokielse/omnipay-alipay/tree/legacy)

## Installation

Omnipay is installed via [Composer](http://getcomposer.org/). To install, simply add it to your `composer.json` file:

```json
{
    "require": {
        "lokielse/omnipay-alipay": "dev-master"
    }
}
```

And run composer to update your dependencies:

    $ curl -s http://getcomposer.org/installer | php
    $ php composer.phar update

## Basic Usage

The following gateways are provided by this package:

| Gateway       	    		|         Description             |说明                 | Links |
|:---------------	    	|:---------------------------     |:---------         |:----------:|
| Alipay_AopApp 	    		| Alipay APP Gateway              |APP支付 - new    | [Usage][link-wiki-aop-app] [Doc][link-doc-aop-app]       |
| Alipay_AopF2F 	    		| Alipay Face To Face Gateway     |当面付 - new         | [Usage][link-wiki-aop-f2f] [Doc][link-doc-aop-f2f]       |
| Alipay_AopWap 	    		| Alipay WAP Gateway              |手机网站支付 - new     | [Usage][link-wiki-aop-wap] [Doc][link-doc-aop-wap]       |
| Alipay_LegacyApp 	    	| Alipay Legacy APP Gateway       |APP支付      | [Usage][link-wiki-legacy-app] [Doc][link-doc-legacy-app]       |
| Alipay_LegacyExpress 		| Alipay Legacy Express Gateway   |即时到账    | [Usage][link-wiki-legacy-express] [Doc][link-doc-legacy-express]      |
| Alipay_LegacyWap      	| Alipay Legacy WAP Gateway   |手机网站支付     | [Usage][link-wiki-legacy-wap] [Doc][link-doc-legacy-wap]       |

## Usage

### Purchase (购买)

```php
/**
 * @var AopAppGateway $gateway
 */
$gateway = Omnipay::create('Alipay_AopApp');
$gateway->setAppId('the_app_id');
$gateway->setPrivateKey('the_app_private_key');
$gateway->setNotifyUrl('https://www.example.com/notify');

$request = $this->gateway->purchase();
$request->setBizContent([
    'subject'      => 'test',
    'out_trade_no' => date('YmdHis') . mt_rand(1000, 9999),
    'total_amount' => '0.01',
    'product_code' => 'QUICK_MSECURITY_PAY',
]);

/**
 * @var AopTradeAppPayResponse $response
 */
$response = $request->send();
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

[ico-version]: https://img.shields.io/packagist/v/lokielse/omnipay-alipay.svg
[ico-license]: https://img.shields.io/badge/license-MIT-brightgreen.svg
[ico-travis]: https://img.shields.io/travis/lokielse/omnipay-alipay/master.svg
[ico-scrutinizer]: https://img.shields.io/scrutinizer/coverage/g/lokielse/omnipay-alipay.svg
[ico-code-coverage]: https://img.shields.io/codecov/c/github/lokielse/omnipay-alipay/master.svg
[ico-code-quality]: https://img.shields.io/scrutinizer/g/lokielse/omnipay-alipay.svg
[ico-downloads]: https://img.shields.io/packagist/dt/lokielse/omnipay-alipay.svg



[link-packagist]: https://packagist.org/packages/lokielse/omnipay-alipay
[link-travis]: https://travis-ci.org/lokielse/omnipay-alipay
[link-scrutinizer]: https://scrutinizer-ci.com/g/lokielse/omnipay-alipay/code-structure
[link-code-coverage]: https://codecov.io/github/lokielse/omnipay-alipay?branch=master
[link-code-quality]: https://scrutinizer-ci.com/g/lokielse/omnipay-alipay
[link-downloads]: https://packagist.org/packages/lokielse/omnipay-alipay
[link-author]: https://github.com/lokielse
[link-contributors]: ../../contributors



[link-wiki-aop-app]: https://github.com/lokielse/omnipay-alipay/wiki/Aop-APP-Gateway
[link-wiki-aop-f2f]: https://github.com/lokielse/omnipay-alipay/wiki/Aop-Face-To-Face-Gateway
[link-wiki-aop-wap]: https://github.com/lokielse/omnipay-alipay/wiki/Aop-WAP-Gateway
[link-wiki-legacy-app]: https://github.com/lokielse/omnipay-alipay/wiki/Legacy-APP-Gateway
[link-wiki-legacy-express]: https://github.com/lokielse/omnipay-alipay/wiki/Legacy-Express-Gateway
[link-wiki-legacy-wap]: https://github.com/lokielse/omnipay-alipay/wiki/Legacy-WAP-Gateway
[link-doc-aop-app]: https://doc.open.alipay.com/docs/doc.htm?treeId=204&articleId=105051&docType=1
[link-doc-aop-f2f]: https://doc.open.alipay.com/docs/doc.htm?treeId=194&articleId=105072&docType=1
[link-doc-aop-wap]: https://doc.open.alipay.com/docs/doc.htm?treeId=203&articleId=105288&docType=1
[link-doc-legacy-app]: https://doc.open.alipay.com/doc2/detail?treeId=59&articleId=103563&docType=1
[link-doc-legacy-express]: https://doc.open.alipay.com/docs/doc.htm?treeId=108&articleId=103950&docType=1
[link-doc-legacy-wap]: https://doc.open.alipay.com/docs/doc.htm?treeId=60&articleId=103564&docType=1