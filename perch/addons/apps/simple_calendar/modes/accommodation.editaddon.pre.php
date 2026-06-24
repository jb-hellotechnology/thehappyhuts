<?php
    
    $HTML = $API->get('HTML');
    
    $SimpleCalendar = new Simple_Calendars($API);

    $HTML     = $API->get('HTML');
    $Form     = $API->get('Form');
    $Text     = $API->get('Text');
    
    if ($Form->submitted()) {  
		
		$data = $_POST;
		$SimpleCalendar->addonUpdate($data);	
		$message = $HTML->success_message('Accommodation add-on updated');  
    	    
    }
    
    $addon = $SimpleCalendar->addon($_GET['id']);