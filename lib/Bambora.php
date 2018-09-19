<?php

namespace bambora;


class Bambora
{
    var $connection;
    var $mid; // Bambora MerchantID
    var $passcode; // Bambora Passcode

    function __construct($curlConnection,$data,$merchant_id,$passcode){

        $this->setMerchantId($merchant_id);
        $this->setPasscode($passcode);

        $this->connection = $curlConnection;
        $this->connection->setData(json_encode($data));
        $this->connection->setHeaders($this->mid,$this->passcode);
    }

    public function setMerchantId($mid){
        $this->mid = $mid;
    }

    public function setPasscode($passcode){
        $this->passcode = $passcode;
    }

    public function getToken(){
        list($content, $response) = $this->connection->post_to_url();
        $token = json_decode($content,true);

        if(!isset($token['token']) || $token['token']==''){
            die('\nError: Failed Tokenizing card: \nResponse Content: '.print_r($token,true)."\nResponse: ". print_r($response,true));
        }

        return $token['token'];
    }

    public function doPayment(){
        list($content, $response) = $this->connection->post_to_url();
        $payment_details = json_decode($content,true);

        if(!(isset($payment_details['approved']) && $payment_details['approved']==1 && isset($payment_details['message']) && $payment_details['message']=='Approved')){
            die("\nError: Failed performing payment: \nResponse Content: ".print_r($payment_details,true)."\nResponse: ". print_r($response,true));
        }

        return $payment_details;
    }
}