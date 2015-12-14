<?php

namespace Omnipay\Alipay\Message;

class RefundRequest extends BasePurchaseRequest
{
    protected $liveEndPoint = 'https://mapi.alipay.com/gateway.do';

    public function validateData(){
        
        $this->validate(
            'service',
            'partner',
            '_input_charset',
            'sign_type',
            'seller_email',
            'seller_user_id',
            'refund_date',
            'batch_no',
            'batch_num',
            'detail_data'
        );
    }

    public function getData(){
        
        $this->validateData();
        $data = array(
            'service'           => $this->getService(),
            'partner'           => $this->getPartner(),
            'notify_url'        => $this->getNotifyUrl(),
            '_input_charset'    => $this->getInputCharset(),
            'seller_email'      => $this->getSellerEmail(),
            'seller_user_id'    => $this->getSellerUserId(),
            'refund_date'       => $this->getRefundDate(),
            'batch_no'          => $this->getBatchNo(),
            'batch_num'         => $this->getBatchNum(),
            'detail_data'       => $this->getDetailDataFormativeString()
        );

        $data               = array_filter( $data );
        $data['sign']       = $this->getParamsSignature( $data );
        $data['sign_type']  = $this->getSignType();

        return $data;
    }

    public function sendData($data){

        return $this->response = new RefundResponse( $this, $data );
    }

    public function getLiveEndPoint(){

        return $this->liveEndPoint;
    }
    
    public function setInputCharset( $value ){

        return $this->setParameter( '_input_charset', $value );
    }

    public function getInputCharset(){

        return $this->getParameter( '_input_charset' );
    }
    
    public function setSellerUserId( $value ){

        return $this->setParameter( 'seller_user_id', $value );
    }

    public function getSellerUserId(){
        
        return $this->getParameter( 'seller_user_id' );
    }

    public function setRefundDate( $value ){

        return $this->setParameter( 'refund_date', $value );
    }

    public function getRefundDate(){

        return $this->getParameter( 'refund_date' );
    }

    public function setBatchNo( $value ){

        return $this->setParameter( 'batch_no', $value );
    }

    public function getBatchNo(){

        return $this->getParameter( 'batch_no' );
    }

    public function setBatchNum( $value ){

        return $this->setParameter( 'batch_num', $value );
    }

    public function getBatchNum(){

        return $this->getParameter( 'batch_num' );
    }

    public function setDetailData( $value ){

        return $this->setParameter( 'detail_data', $value );
    }

    public function getDetailData(){

        return $this->getParameter( 'detail_data' );
    }

    public function addDetailDataArray( array $new_details ){
        
        $detail_data = $this->getDetailData();
        
        if ( empty( $detail_data ) ){ 
            
            return $this->setDetailData( $new_details );
        }
        else{
            
            return $this->setDetailData( array_merge( $detail_data, $new_details ) );
        }
    }
    
    public function addDetailData( $out_tarde_no, $total_refund_fee, $reason ){
        
        $detail_data = $this->getDetailData();

        $new_detail = array( $out_tarde_no, $total_refund_fee, $reason );

        if ( empty( $detail_data ) ){
        
            return $this->setDetailData( array( $new_detail ) );
        }
        else{
           
            return $this->setDetailData( array_push( $detail_data, $new_detail ) );
        }
    }

    public function getDetailDataFormativeString(){
       
        $details = $this->getDetailData();

        $formatvie_details = array();
        
        foreach ( $details as $detail ){
             array_push( $formatvie_details, implode( '^', $detail ) ); 
        }
        
        return implode( '#', $formatvie_details );
    }
}
