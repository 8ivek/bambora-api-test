<?php

namespace bambora;


class Bambora
{
    var $connection;

    function __construct($curlConnection,$data){
        $this->connection = $curlConnection;
        $this->connection->setData(json_encode($data));
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