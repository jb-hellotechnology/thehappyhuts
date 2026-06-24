<?php
    
    $HTML = $API->get('HTML');
    
    $SimpleCalendar = new Simple_Calendars($API);

    $HTML     = $API->get('HTML');
    $Form     = $API->get('Form');
    $Text     = $API->get('Text');
    $Template = $API->get('Template');
    
    $Template->set('simple_calendar/unit_add.html', 'simple');
    
    if ($Form->submitted()) {  
		
		$data = $_POST;
		$SimpleCalendar->unitAdd($data);	
		$message = $HTML->success_message('Accommodation added');  
    	    
    }

	$units = $SimpleCalendar->getAccUnit(0);