<?php
    # Side panel
    echo $HTML->side_panel_start();
    
    echo $HTML->side_panel_end();
    
    echo $HTML->title_panel([
    'heading' => $Lang->get('Gift Vouchers'),
    ], $CurrentUser);

/*
    $Smartbar = new PerchSmartbar($CurrentUser, $HTML, $Lang);

	$Smartbar->add_item([
	    'active' => false,
	    'title' => 'Calendar',
	    'link'  => '/addons/apps/simple_calendar/accommodation',
	]);
	
	$Smartbar->add_item([
	    'active' => false,
	    'title' => 'Units',
	    'link'  => '/addons/apps/simple_calendar/accommodation/units',
	]);
	
	$Smartbar->add_item([
	    'active' => false,
	    'title' => 'Emails',
	    'link'  => '/addons/apps/simple_calendar/accommodation/emails',
	]);
	
	$Smartbar->add_item([
	    'active' => true,
	    'title' => 'Add-Ons',
	    'link'  => '/addons/apps/simple_calendar/accommodation/addons',
	]);
	
	echo $Smartbar->render();
*/
    
    # Main panel
    echo $HTML->main_panel_start();
   
    include('_subnav.php');
    
    if (isset($message)){ 
	    
	    echo $message;
	    
	}else{
	
		echo $HTML->heading3('Add a Gift Voucher');
		
		echo $Form->form_start();
		
		echo $Form->text_field("voucherCode","Voucher Code (letters and numbers only)",'');
		
		echo $Form->text_field("voucherValue","Voucher Value (no £ sign)",'0.00');
		    
		echo $Form->submit_field('btnSubmit', 'Add Gift Voucher', $API->app_path());
		
		echo $Form->form_end();
	
	}

    echo $HTML->main_panel_end();
