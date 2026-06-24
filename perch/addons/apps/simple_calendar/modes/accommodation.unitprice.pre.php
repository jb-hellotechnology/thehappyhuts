<?php
    
    $HTML = $API->get('HTML');
    
    $SimpleCalendar = new Simple_Calendars($API);

    $HTML     = $API->get('HTML');
    $Form     = $API->get('Form');
    $Text     = $API->get('Text');
    
    $id = $_GET['id'];
    
    $unit = $SimpleCalendar->unit($id, false);
    
    if ($Form->submitted()) {  
		
		$data = $_POST;
		$SimpleCalendar->unitPrice($data);	
		$message = $HTML->success_message('Unit pricing added');  
    	    
    }