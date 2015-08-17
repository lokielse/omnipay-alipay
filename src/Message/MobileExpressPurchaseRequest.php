<?php

namespace Omnipay\Alipay\Message;

use Omnipay\Common\Message\ResponseInterface;

class MobileExpressPurchaseRequest extends BasePurchaseRequest
{

    protected $service = 'mobile.securitypay.pay';


    /**
     * @return mixed
     * @throws \Exception
     */
    public function getData()
    {
        $this->validateData();

        $data = $this->getParamsToSign();

        $orderInfoStr = $this->getOrderString($data);

        $signature = $this->signWithRSA($orderInfoStr, $this->getPrivateKey());

        if ($this->getSignType() != 'RSA') {
            throw new \Exception(
                sprintf(
                    'Alipay_MobileExpress gateway support RSA only, not support %s.',
                    $this->getSignType()
                )
            );
        }

        $resp['order_info_str'] = sprintf('%s&sign="%s"&sign_type="RSA"', $orderInfoStr, urlencode($signature));

        return $resp;
    }


    protected function validateData()
    {
        $this->validate('partner', 'out_trade_no', 'subject', 'total_fee', 'notify_url', 'private_key');
    }


    private function getParamsToSign()
    {
        return array(
            'partner'        => $this->getPartner(),
            'seller_id'      => $this->getPartner(),
            'out_trade_no'   => $this->getOutTradeNo(),
            'subject'        => $this->getSubject(),
            'body'           => $this->getBody(),
            'total_fee'      => $this->getTotalFee(),
            'notify_url'     => $this->getNotifyUrl(),
            'service'        => $this->service,
            '_input_charset' => $this->getInputCharset(),
            'payment_type'   => $this->getPaymentType(),
            'it_b_pay'       => $this->getItBPay(),
        );
    }


    private function getOrderString($data)
    {
        $str = http_build_query($data);
        $str = str_replace('&', '"&', $str);
        $str = str_replace('=', '="', $str) . '"';
        $str = urldecode($str);

        return $str;
    }


    /**
     * Send the request with specified data
     *
     * @param  mixed $data The data to send
     *
     * @return ResponseInterface
     */
    public function sendData($data)
    {
        return $this->response = new MobileExpressPurchaseResponse($this, $data);
    }
}
