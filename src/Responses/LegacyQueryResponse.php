<?php

namespace Omnipay\Alipay\Responses;

class LegacyQueryResponse extends AbstractLegacyResponse
{

    /**
     * Is the response successful?
     *
     * @return boolean
     */
    public function isSuccessful()
    {
        return $this->data['is_success'] === 'T';
    }
}
