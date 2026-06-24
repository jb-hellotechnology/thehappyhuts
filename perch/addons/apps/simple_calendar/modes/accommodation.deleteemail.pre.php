<?php
    
    $HTML = $API->get('HTML');
    
    $SimpleCalendar = new Simple_Calendars($API);

    $HTML     = $API->get('HTML');
    $Form     = $API->get('Form');
    $Text     = $API->get('Text');
    
    if ($Form->submitted()) {  
		
		$data = $_POST;
		$SimpleCalendar->emailDelete($data);	
		$message = $HTML->success_message('Email deleted');  
    	    
    }

	$email = $SimpleCalendar->getEmail($_GET['id']);
