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
		$SimpleCalendar->unitUpdate($data);	
		$message = $HTML->success_message('Unit updated');  
    	    
    }
            
    // Install only if $things is false. 
    // This will run the code in activate.php so should only ever happen on first run - silently installing the app.
    if ($unit == false) {

        $message = $HTML->warning_message('Could not find that unit');        

    }
