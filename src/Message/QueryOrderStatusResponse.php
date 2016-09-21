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
        $data = $this->getData();

        return isset($data['is_success']) && $data['is_success'] == 'T';
    }
}
