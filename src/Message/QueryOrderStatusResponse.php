<?php

namespace Omnipay\Alipay\Message;

use Omnipay\Common\Message\AbstractResponse;

/**
 * QueryOrderStatusResponse
 */
class QueryOrderStatusResponse extends AbstractResponse
{

    public function isSuccessful()
    {
        return $this->getData()['is_success'] == 'T';
    }


    public function isRedirect()
    {
        return false;
    }
}
