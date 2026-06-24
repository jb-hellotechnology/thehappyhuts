<?php
    
    $HTML = $API->get('HTML');
    
    $SimpleCalendar = new Simple_Calendars($API);

    $HTML     = $API->get('HTML');
    $Form     = $API->get('Form');
    $Text     = $API->get('Text');

    $SimpleCalendar->ensureVoucherUnitsColumn();
    $units = $SimpleCalendar->getAccUnit(0);

    if ($Form->submitted()) {
		
		$data = $_POST;
		$SimpleCalendar->voucherAdd($data);	
		$message = $HTML->success_message('Voucher added');  
    	    
    }