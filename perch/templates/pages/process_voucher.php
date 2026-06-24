<?php

//GET DATA
$firstName = strip_tags(addslashes($_POST['pFirstname']));
$lastName = strip_tags(addslashes($_POST['pLastname']));
$address1 = strip_tags(addslashes($_POST['pAddress1']));
$address2 = strip_tags(addslashes($_POST['pAddress2']));
$town = strip_tags(addslashes($_POST['pTown']));
$county = strip_tags(addslashes($_POST['pCounty']));
$postcode = strip_tags(addslashes($_POST['pPostcode']));
$phone = strip_tags($_POST['pPhone']);
$email = trim(strip_tags($_POST['pEmail']));
$value = strip_tags($_POST['pValue']);
$note = strip_tags(addslashes($_POST['pNote']));

$paid = $value/100;
$voucherValue = ($value-100)/100;

if($voucherValue>0){

	//SEND CONFIRMATION
	$to = $email;
	
	$subject = 'The Happy Huts Gift Voucher Order';
	
	$headers = "From:  no-reply@thehappyhuts.co.uk\r\n";
	$headers .= "Reply-To: thehappyhut128@gmail.com\r\n";
	$headers .= "MIME-Version: 1.0\r\n";
	$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
	
	$message = '<html><body>';
	$message .= '<h1>The Happy Huts Gift Voucher Order</h1>';
	$message .= '<p>Thank you for your order. Your payment has been processed and we have received your order details, as follows:</p>';
	$message .= '<ul>';
	$message .= '<li><strong>Name:</strong><br />'.$firstName.' '.$lastName.'</li>';
	$message .= '<li><strong>Delivery Address:</strong><br />'.$address1.'<br />'.$address2.'<br />'.$town.'<br />'.$county.'<br />'.$postcode.'</li>';
	$message .= '<li><strong>Contact Details:</strong><br />'.$email.'<br />'.$phone.'</li>';
	$message .= '<li><strong>Amount Paid:</strong><br />&pound;'.$paid.'</li>';
	$message .= '<li><strong>Gift Voucher Value:</strong><br />&pound;'.$voucherValue.'</li>';
	$message .= '<li><strong>Gift Voucher Note:</strong><br />'.$note.'</li>';
	$message .= '</ul>';
	$message .= '<p>If you have any questions or queries about your order please reply to this email.</p>';
	$message .= '<p>Thanks,<br />Jodie at The Happy Huts</p>';
	$message .= '</body></html>';
	
	mail($to, $subject, $message, $headers);
	
	//SEND SALES ORDER TO JODIE
	$to = 'thehappyhut128@gmail.com';
	
	$subject = 'The Happy Huts Gift Voucher Order';
	
	$headers = "From:  no-reply@thehappyhuts.co.uk\r\n";
	$headers .= "Reply-To: thehappyhut128@gmail.com\r\n";
	$headers .= "MIME-Version: 1.0\r\n";
	$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
	
	$message = '<html><body>';
	$message .= '<h1>The Happy Huts Gift Voucher Order</h1>';
	$message .= '<p>You\'ve had an order, as follows:</p>';
	$message .= '<ul>';
	$message .= '<li><strong>Name:</strong><br />'.$firstName.' '.$lastName.'</li>';
	$message .= '<li><strong>Delivery Address:</strong><br />'.$address1.'<br />'.$address2.'<br />'.$town.'<br />'.$county.'<br />'.$postcode.'</li>';
	$message .= '<li><strong>Contact Details:</strong><br />'.$email.'<br />'.$phone.'</li>';
	$message .= '<li><strong>Gift Voucher Value</strong><br />&pound;'.$voucherValue.'</li>';
	$message .= '<li><strong>Gift Voucher Note:</strong><br />'.$note.'</li>';
	$message .= '</ul>';
	$message .= '</body></html>';
	
	mail($to, $subject, $message, $headers);

}
?>