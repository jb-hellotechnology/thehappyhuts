<?php
    # Side panel
    echo $HTML->side_panel_start();
    
    echo $HTML->side_panel_end();
    
    echo $HTML->title_panel([
    'heading' => $Lang->get('Accommodation'),
    ], $CurrentUser);

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
	    'title' => 'Availability',
	    'link'  => '/addons/apps/simple_calendar/accommodation/availability',
	]);
	
/*
	$Smartbar->add_item([
	    'active' => false,
	    'title' => 'Add-Ons',
	    'link'  => '/addons/apps/simple_calendar/accommodation/addons',
	]);
*/
	
	echo $Smartbar->render();
    
    # Main panel
    echo $HTML->main_panel_start();
   
    include('_subnav.php');
    
    if (isset($message)){ 
	    
	    echo $message;

	}else{
		
		echo $Form->form_start();
		
	    echo $HTML->heading3('Availability');
	    
		$options[] = array('label'=>'Available', 'value'=>'available');
		$options[] = array('label'=>'Weekends Only', 'value'=>'weekends');
		$options[] = array('label'=>'Closed', 'value'=>'closed');
	    
	    echo $Form->select_field('january','January',$options,$data['january']);
	    echo $Form->select_field('february','February',$options,$data['february']);
	    echo $Form->select_field('march','March',$options,$data['march']);
	    echo $Form->select_field('april','April',$options,$data['april']);
	    echo $Form->select_field('may','May',$options,$data['may']);
	    echo $Form->select_field('june','June',$options,$data['june']);
	    echo $Form->select_field('july','July',$options,$data['july']);
	    echo $Form->select_field('august','August',$options,$data['august']);
	    echo $Form->select_field('september','September',$options,$data['september']);
	    echo $Form->select_field('october','October',$options,$data['october']);
	    echo $Form->select_field('november','November',$options,$data['november']);
	    echo $Form->select_field('december','December',$options,$data['december']);
	    
		echo $Form->submit_field('btnSubmit', 'Update Availability', $API->app_path());
	
	    echo $Form->form_end();
	
	}  

    echo $HTML->main_panel_end();
