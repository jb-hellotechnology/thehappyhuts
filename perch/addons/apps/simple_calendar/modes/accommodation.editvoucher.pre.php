<?php
    
    $HTML = $API->get('HTML');
    
    $SimpleCalendar = new Simple_Calendars($API);

    $HTML     = $API->get('HTML');
    $Form     = $API->get('Form');
    $Text     = $API->get('Text');

    $SimpleCalendar->ensureVoucherUnitsColumn();

    if ($Form->submitted()) {
		
		$data = $_POST;
		$SimpleCalendar->voucherUpdate($data);	
		$message = $HTML->success_message('Gift Voucher updated');  
    	    
    }
    
    $voucher = $SimpleCalendar->giftvoucher($_GET['id']);

    $units = $SimpleCalendar->getAccUnit(0);
    $voucherUnits  = isset($voucher['units']) ? trim($voucher['units']) : 'all';
    $selectedUnits = ($voucherUnits=='' || strtolower($voucherUnits)=='all') ? array() : array_map('trim', explode(',', $voucherUnits));