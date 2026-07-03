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

	$reviewContent = reviewContent();
	$review = nl2br($reviewContent['content']);
	$departures = reviewDepatures();

	foreach($departures as $departure){
		
		$firstName = addslashes($departure['firstName']);
		
		$placeHolders = array("{{memberName}}");
		$emailContent = array($departure['firstName']);
		
		$message = str_replace(
			$placeHolders,
			$emailContent,
			$review
		);

		$sendSmtpEmail = new \Brevo\Client\Model\SendSmtpEmail([
			'subject' => 'The Happy Huts - Review Us',
		    'sender' => ['name' => 'The Happy Huts', 'email' => 'office@thehappyhuts.co.uk'],
		    'replyTo' => ['name' => 'The Happy Huts', 'email' => 'office@thehappyhuts.co.uk'],
		    'to' => [[ 'name' => "$arrival[firstName]", 'email' => "$departure[emailAddress]"]],
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