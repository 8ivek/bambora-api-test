<?php

namespace bambora;

use bambora\Logger;

class CurlConnection
{
    var $url;
    var $timeout;
    var $headers;
    var $data;
    var $logger;

    public function __construct($url, $timeout = 10)
    {
        $this->url = str_replace( "&amp;", "&", urldecode(trim($url)) );
        $this->timeout = $timeout;
        $this->logger = new Logger(BAMBORA_LOG_FILE);
    }

    public function post_to_url(){
        //log request
        $this->logger->log("Request: ".print_r($this->data,true));

        $ch = curl_init();
        curl_setopt( $ch, CURLOPT_URL, $this->url );
        curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
        curl_setopt( $ch, CURLOPT_POST, true );
        curl_setopt( $ch, CURLOPT_SSL_VERIFYPEER, false );# required for https urls
        curl_setopt( $ch, CURLOPT_CONNECTTIMEOUT, $this->timeout );
        curl_setopt( $ch, CURLOPT_TIMEOUT, $this->timeout );
        curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $this->data);
        $content = curl_exec( $ch );
        $response = curl_getinfo( $ch );
        curl_close ( $ch );

        //log response
        $this->logger->log("Response: ".print_r($content,true));

        return array( $content, $response );
    }

    public function setData($data){
        $this->data=$data;
    }

    public function setHeaders($mid,$passcode){
        $this->headers = array(
            'Content-Type: application/json; charset=utf-8',
            'Authorization: Passcode '. base64_encode($mid.':'.$passcode),
        );
    }
}