<?php
	
	//ini_set('display_errors', 1);
	//ini_set('display_startup_errors', 1);
	//error_reporting(E_ALL);
    
    $HTML = $API->get('HTML');
    
    $SimpleCalendar = new Simple_Calendars($API);

    $HTML     = $API->get('HTML');
    $Form     = $API->get('Form');
    $Text     = $API->get('Text');
    $Template = $API->get('Template');

    if ($Form->submitted()) { 
	    
	    $form = $_POST;
	    
	    $SimpleCalendar->updateAvailability($form);
	    
	    $message = $HTML->success_message('Availability Updated');

    }
    
    $data = $SimpleCalendar->getAvailability();