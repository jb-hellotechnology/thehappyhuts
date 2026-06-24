<?php

/*
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
*/

include('../../../stripe-php-7.62.0/init.php');

$payload = @file_get_contents('php://input');
$event = null;

try {
    $event = \Stripe\Event::constructFrom(
        json_decode($payload, true)
    );
} catch(\UnexpectedValueException $e) {
    // Invalid payload
    http_response_code(400);
    exit();
}

$json = json_decode($payload, true);

$first_name = $json['data']['object']['metadata']['first_name'];
$last_name = $json['data']['object']['metadata']['last_name'];
$email = $json['data']['object']['metadata']['email'];
$telephone = $json['data']['object']['metadata']['telephone'];
$arrival = $json['data']['object']['metadata']['arrival'];
$nights = $json['data']['object']['metadata']['nights'];
$reference = $json['data']['object']['metadata']['reference'];
$unitID = $json['data']['object']['metadata']['unitID'];
$amount = $json['data']['object']['amount']/100;

$type = $json['type'];

$dates = explode("-",$arrival);
$departure = date("Y-m-d", mktime(0, 0, 0, $dates[1], $dates[2]+($nights-1), $dates[0]));

$arrival = "$arrival 09:30:00";
$departure = "$departure 23:00:00";

//mail('jack@jackbarber.co.uk','Stripe Webhook', $payload. "$first_name - $last_name - $email - $telephone - $arrival - $departure - $nights - $reference - $type");

if($type == 'payment_intent.succeeded'){
	checkBookingExists($first_name,$last_name,$email,$telephone,$arrival,$departure,$unitID,$amount);
}

http_response_code(200);

echo 'done';