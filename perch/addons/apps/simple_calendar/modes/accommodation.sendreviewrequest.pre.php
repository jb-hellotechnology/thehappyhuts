<?php
    
    $HTML = $API->get('HTML');
    
    $SimpleCalendar = new Simple_Calendars($API);

    $HTML     = $API->get('HTML');
    $Form     = $API->get('Form');
    $Text     = $API->get('Text');
    $Template = $API->get('Template');
    
    $Settings = $API->get('Settings');
	$defaultEmail = $Settings->get('simple_calendar_DefaultEmail')->val();
    
    $id = $_GET['id'];
	
    $booking = $SimpleCalendar->booking($id, false);
    
    if ($Form->submitted()) {  
		
		$data = $_POST;
			
		$to = $data['sendTo'];
		$subject = $data['subject'];
		$message = nl2br($data['content']);

	    $headers = 'From: ' . $defaultEmail . "\r\n" .
	    'X-Mailer: PHP/' . phpversion(); $header .= "\r\n";
	    $headers .= 'MIME-Version: 1.0' . "\r\n";
	    $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
	    $headers .= 'Cc: info@baytownholidaycottages.co.uk' . "\r\n";
		
		mail($to, $subject, $message, $headers);
			
		$message = $HTML->success_message('Confirmation sent');
    	    
    }
