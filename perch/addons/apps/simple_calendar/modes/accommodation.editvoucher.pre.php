<?php
    
    $HTML = $API->get('HTML');
    
    $SimpleCalendar = new Simple_Calendars($API);

    $HTML     = $API->get('HTML');
    $Form     = $API->get('Form');
    $Text     = $API->get('Text');
    
    if ($Form->submitted()) {  
		
		$data = $_POST;
		$SimpleCalendar->voucherUpdate($data);	
		$message = $HTML->success_message('Gift Voucher updated');  
    	    
    }
    
    $voucher = $SimpleCalendar->giftvoucher($_GET['id']);