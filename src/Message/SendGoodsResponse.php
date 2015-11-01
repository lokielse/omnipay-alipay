<?php

namespace Omnipay\Alipay\Message;

use Omnipay\Common\Message\AbstractResponse;
use Log;

class SendGoodsResponse extends AbstractResponse
{
    protected $request;

    public function isSuccessful()
    {
        return $this->data['success'];
    }
}
