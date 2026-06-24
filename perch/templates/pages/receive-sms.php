<?php
/*
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
*/

// Require the bundled autoload file - the path may need to change
// based on where you downloaded and unzipped the SDK
require '../../../twilio-php-main/src/Twilio/autoload.php';
use Twilio\TwiML\MessagingResponse;

$response = new MessagingResponse();
$response->message("This number is for booking notifications only. Please contact Jodie directly on +447557402652");
print $response;