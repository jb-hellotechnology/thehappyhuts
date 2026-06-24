<?php
    
    $HTML = $API->get('HTML');
    
    $SimpleCalendar = new Simple_Calendars($API);

    $HTML     = $API->get('HTML');
    $Form     = $API->get('Form');
    $Text     = $API->get('Text');
    $Template = $API->get('Template');

	$message = false;
	
	$id = $_GET['id'];
	
	// if the confirmation of delete has been submitted this is a form post
    if ($Form->submitted()) {
	    
	    $SimpleCalendar->deleteReview($id);
	    
   		$message = $HTML->success_message('Review deleted.');
   		
    }