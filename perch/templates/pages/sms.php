<?php
/*
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
*/

require_once('../../../vendor/autoload.php');

// Configure API key authorization: api-key
$config = Brevo\Client\Configuration::getDefaultConfiguration()->setApiKey('api-key', getenv('BREVO_API_KEY'));

$apiInstance = new Brevo\Client\Api\TransactionalEmailsApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);

if($_GET['p']=='saltyseadog'){
	
	if($_GET['t']=='arrival'){
		$smsContent = smsContentArrival();
		$sms = nl2br($smsContent['content']);
		$arrivals = todayArrivals();
	}else{
		$smsContent = smsContent();	
		$sms = nl2br($smsContent['content']);
		$arrivals = tomorrowArrivals();
	}
	
	foreach($arrivals as $arrival){
		
		$firstName = addslashes($arrival['firstName']);
		$number = $arrival['phone'];
		$unit = getUnitByID($arrival['unitID']);
		$unitName = str_replace("'","&rsquo;",$unit['name']);
		
		$arrivalDates = explode(" ",$arrival['startTime']);
	    $arrivalDates = explode("-",$arrivalDates[0]);
	    $arrivalDate = "$arrivalDates[2]/$arrivalDates[1]/$arrivalDates[0]";
      
		$arrivalFull = date("l jS \of F Y", mktime(0, 0, 0, $arrivalDates[1], $arrivalDates[2], $arrivalDates[0]));
	    
	    $departureDates = explode(" ",$arrival['endTime']);
	    $departureDates2 = explode("-",$departureDates[0]);
	    $departureDate = "$departureDates2[2]/$departureDates2[1]/$departureDates2[0]";
		
		$departureFull = date("l jS \of F Y", mktime(0, 0, 0, $departureDates2[1], $departureDates2[2], $departureDates2[0]));
	    $arrivalDates = explode(" ",$arrival['startTime']);
	    $departureDates = explode(" ",$arrival['endTime']);
	    
	    $diff = strtotime($departureDates[0]) - strtotime($arrivalDates[0]);
		$nights = $diff/86400;
		$nights = $nights+1;
		
		$placeHolders = array("{{unitName}}","{{bookingID}}","{{memberName}}","{{bookingArrival}}","{{bookingDeparture}}","{{bookingNights}}","{{bookingCost}}","{{bookingPaid}}");
		$emailContent = array($unitName,"#".$arrival['bookingID'],$arrival['firstName'],$arrivalFull,$departureFull,$nights,$arrival['cost'],$arrival['paid']);
		
		$message = str_replace(
			$placeHolders,
			$emailContent,
			$sms
		);

		$sendSmtpEmail = new \Brevo\Client\Model\SendSmtpEmail([
			'subject' => 'Beach Hut Details',
		    'sender' => ['name' => 'The Happy Huts', 'email' => 'office@thehappyhuts.co.uk'],
		    'replyTo' => ['name' => 'The Happy Huts', 'email' => 'office@thehappyhuts.co.uk'],
		    'to' => [[ 'name' => "$arrival[firstName]", 'email' => "$arrival[emailAddress]"]],
		    'htmlContent' => $message
		]);
		
		try {
		    $result = $apiInstance->sendTransacEmail($sendSmtpEmail);
		    print_r($result);
		} catch (Exception $e) {
		    echo 'Exception when calling TransactionalEmailsApi->sendTransacEmail: ', $e->getMessage(), PHP_EOL;
		}
	
	}
	
	echo 'Sent';

}else{
	echo 'Fail';
}