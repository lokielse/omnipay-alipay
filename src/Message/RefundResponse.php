<?php

namespace Omnipay\Alipay\Message;

class RefundResponse extends AbstractResponse{


    public function isSuccessful(){

        return false;
    }

    public function isRedirect(){
        
        return true;
    }

    public function getRedirectData(){

        return $this->data;
    }
   
    public function getLiveEndPoint(){
        
        return $this->liveEndPoint;
    }

    public function getRedirectUrl(){
    
        return $this->getRequest()->getLiveEndPoint() . '?' . http_build_query( $this->getRedirectData() ); 
    }
}
