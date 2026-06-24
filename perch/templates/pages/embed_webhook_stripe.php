<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once('../../../vendor/autoload.php');

$stripe = new \Stripe\StripeClient(
  getenv('STRIPE_SECRET_KEY')
);

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

// Handle the event
switch ($event->type) {
    case 'checkout.session.completed':
        $checkoutSession = $event->data->object->id;
        $amount = $event->data->object->amount_total;
        $paid = number_format($amount/100,2);
        simple_calendar_complete_booking_webhook($checkoutSession,$paid);
        http_response_code(200);
        break;
    default:
	    http_response_code(200);
}