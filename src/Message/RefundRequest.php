<?php

namespace Omnipay\Alipay\Message;

use Omnipay\Common\Exception\InvalidRequestException;
use Omnipay\Common\Message\ResponseInterface;

class RefundRequest extends BasePurchaseRequest
{

    protected $service = 'refund_fastpay_by_platform_pwd';


    /**
     * @return mixed
     * @throws \Exception
     */
    public function getData()
    {
        $this->validateData();

        $data = $this->getParamsToSign();

        $data['sign'] = $this->getParamsSignature($data);

        $data['sign_type'] = $this->getSignType();

        return $data;
    }


    protected function validateData()
    {
        $this->validate('refund_items');
    }


    private function getParamsToSign()
    {
        $refundDate = $this->getRefundDate() ?: date('Y-m-d H:i:s');
        $batchNo    = $this->getBatchNo() ?: (date('Ymd') . mt_rand(1000, 9999));

        return array (
            "service"        => $this->service,
            "partner"        => $this->getPartner(),
            "notify_url"     => $this->getNotifyUrl(),
            "seller_user_id" => $this->getPartner(),
            "refund_date"    => $refundDate,
            "batch_no"       => $batchNo,
            "batch_num"      => $this->getBatchNum(),
            "detail_data"    => $this->getDetailData(),
            "_input_charset" => $this->getInputCharset()
        );
    }


    public function getRefundDate()
    {
        return $this->getParameter('refund_date');
    }


    public function getBatchNo()
    {
        return $this->getParameter('batch_no');
    }


    protected function getBatchNum()
    {
        return count($this->getRefundItems());
    }


    public function getRefundItems()
    {
        return $this->getParameter('refund_items');
    }


    protected function getDetailData()
    {
        $strings = array();

        foreach ($this->getRefundItems() as $item) {
            $item = (array) $item;

            if (! isset($item['out_trade_no'])) {
                throw new InvalidRequestException('The field `out_trade_no` is not exist in item');
            }

            if (! isset($item['amount'])) {
                throw new InvalidRequestException('The field `amount` is not exist in item');
            }

            if (! isset($item['reason'])) {
                throw new InvalidRequestException('The field `reason` is not exist in item');
            }

            $strings[] = implode('^', array ($item['out_trade_no'], $item['amount'], $item['reason']));
        }

        return implode('#', $strings);
    }


    public function setRefundDate($value)
    {
        if (! preg_match('#^\d{4}-\d{2}-\d{2} \d{2}:\d{2}:\d{2}$#', $value)) {
            throw new InvalidRequestException("The refund_date($value) is invalid, format: YYYY-MM-DD hh:mm::ss");
        }

        $this->setParameter('refund_date', $value);
    }


    public function setBatchNo($value)
    {
        $format = '当天日期[8位]+序列号[3至24位], 如：201603081000001';

        if (! preg_match('#^20\d{6}\d{3,24}$#', $value)) {
            throw new InvalidRequestException(
                "The batch_no($value) is not exists, format: {$format}"
            );
        }

        $this->setParameter('batch_no', $value);
    }


    public function setRefundItems($value)
    {
        $this->setParameter('refund_items', $value);
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
        return $this->response = new RefundResponse($this, $data);
    }
}
