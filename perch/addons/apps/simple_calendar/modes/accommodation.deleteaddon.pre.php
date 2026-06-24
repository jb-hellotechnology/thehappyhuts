<?php
    $SimpleCalendar = new Simple_Calendars($API);

    $HTML = $API->get('HTML');
    $Form = $API->get('Form');
    $Form->set_name('delete');
	
	$message = false;
	
	$id = $_GET['id'];
	
	$addon = $SimpleCalendar->addon($id, false);
	
	// if the confirmation of delete has been submitted this is a form post
    if ($Form->submitted()) {
	    
	    $SimpleCalendar->addonDelete($id);
	    
   		$message = $HTML->success_message('Add-on deleted.');
   		
    }
