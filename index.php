<?php
/**
 * @note : Run this file, in your console go to this folder and then run following command
 * $ "php index.php"
 */

use bambora\CurlConnection;
use bambora\Bambora;

spl_autoload_register(function ($class) {
    $parts = explode('\\', $class);
    include 'lib/'.end($parts) . '.php';
});

include('config.php');

//Tokenize a card

// Your card information
$card = array(
    'number'        => '4030000010001234',
    'expiry_month'  => '12',
    'expiry_year'   => '20',
    'cvd'           => '123',
);

$token_url      =   BAMBORA_ROOT_URL.'scripts/tokenization/tokens';
$profile_url    =   BAMBORA_ROOT_URL.'v1/profiles';
$payment_url    =   BAMBORA_ROOT_URL.'v1/payments';

$curlConnection = new CurlConnection($token_url);
$bambora = new Bambora($curlConnection,$card,$bambora_merchant_id,$bambora_passcode);
$token = $bambora->getToken();
echo "Token Successfully Generated: $token\n";

unset($curlConnection);
unset($bambora);

// Do Payment (Token)
$order_number = bin2hex(random_bytes(22));
$amount = number_format((float)rand(5,100), 2, '.', '');
$name = 'Justin Trudeau';
$payment_data = array(
    'order_number'      => $order_number,
    'amount'            => $amount,
    'payment_method'    => 'token',
    'token'   => array(
        'name'      => $name,
        'code'      => $token,
        'complete'  => 'true'
    ),
);

$curlConnection = new CurlConnection($payment_url);
$bambora = new Bambora($curlConnection,$payment_data,$bambora_merchant_id,$bambora_passcode);
$payment_details = $bambora->doPayment();
echo "Successful Token Payment\n";
//print_r($payment_details);die();

unset($curlConnection);
unset($bambora);
unset($payment_details);
unset($payment_data);
unset($order_number);

// Do Payment (Card)
$order_number = bin2hex(random_bytes(22));
$payment_data = array(
    'order_number'      => $order_number,
    'amount'            => $amount,
    'payment_method'    => 'card',
    'card'   => array(
        "number" => $card['number'],
		"name" => $name,
		"expiry_month" => $card['expiry_month'],
		"expiry_year" => $card['expiry_year'],
		"cvd" => $card['cvd'],
		"complete" => "true"
    ),
    'billing'   => array(
        "name" => $name,
		"address_line1" => "1407 Graymalkin Lane",
		"address_line2" => "",
		"city" => "Toronto",
		"province" => "ON",
		"country" => "CAN",
		"postal_code" => "111 111",
		"phone_number" => "4165553333",
		"email_address" => "johndoe@yourmail.com",
    ),
);

$curlConnection = new CurlConnection($payment_url);
$bambora = new Bambora($curlConnection,$payment_data,$bambora_merchant_id,$bambora_passcode);
$payment_details = $bambora->doPayment();

echo "Successful Card Payment\n";
//print_r($payment_details);