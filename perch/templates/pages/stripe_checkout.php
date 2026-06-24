<?php
/*
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
*/

$first_name = strip_tags(addslashes($_POST['first_name']));
$last_name = strip_tags(addslashes($_POST['last_name']));
$email_address = strip_tags(addslashes($_POST['email']));
$phone = strip_tags(addslashes($_POST['mobile']));
$voucher = $_SESSION['voucherCode'];

require_once('../../../vendor/autoload.php');

$stripe = new \Stripe\StripeClient(
  getenv('STRIPE_SECRET_KEY')
);

$productName = strip_tags(addslashes($_POST['stripeDescription']));

$price = $stripe->prices->create([
  'currency' => 'gbp',
  'unit_amount' => $_POST['cost'],
  'product_data' => ['name' => $productName],
]);

$checkout_session = $stripe->checkout->sessions->create([
  'success_url' => 'https://app.thehappyhuts.com/embed/book/complete',
  'cancel_url' => 'https://app.thehappyhuts.com/embed/book/incomplete',
  'line_items' => [
    [
      'price' => $price->id,
      'quantity' => 1
    ],
  ],
  'payment_intent_data' => ['description' => "$productName"],
  'mode' => 'payment',
  'customer_email' => $email_address,
  'metadata' => ['name' => "$first_name $last_name", "phone" => "$phone"]
]);

//print_r($checkout_session);

$cost = strip_tags($_POST['cost']/100);

//** STORE CHECKOUT SESSION DETAILS **//
$session_id = $checkout_session->id;
$payment_intent = $checkout_session->payment_intent;
$session = "$id".","."$intent";

simple_calendar_store_session_id($_POST['ORDERID'],$first_name,$last_name,$email_address,$phone,$cost,$session_id,$payment_intent);

header("HTTP/1.1 303 See Other");
header("Location: " . $checkout_session->url);