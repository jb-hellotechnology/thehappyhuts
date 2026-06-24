<?php
    # Side panel
    echo $HTML->side_panel_start();
    
    echo $HTML->side_panel_end();
    
    echo $HTML->title_panel([
    'heading' => $Lang->get('Accommodation'),
    'button'  => [
            'text' => $Lang->get('Unit'),
            'link' => $API->app_nav().'/accommodation/units/add',
            'icon' => 'core/plus',
        ],
    ], $CurrentUser);

    $Smartbar = new PerchSmartbar($CurrentUser, $HTML, $Lang);

	$Smartbar->add_item([
	    'active' => false,
	    'title' => 'Calendar',
	    'link'  => '/addons/apps/simple_calendar/accommodation',
	]);
	
	$Smartbar->add_item([
	    'active' => true,
	    'title' => 'Units',
	    'link'  => '/addons/apps/simple_calendar/accommodation/units',
	]);
	
	$Smartbar->add_item([
	    'active' => false,
	    'title' => 'Emails',
	    'link'  => '/addons/apps/simple_calendar/accommodation/emails',
	]);
	
	$Smartbar->add_item([
	    'active' => false,
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
	
	echo $HTML->heading3('Add a Unit');
	
	echo $Form->form_start();
	
	echo $Form->text_field("name","Name",'');
	
	echo $Form->text_field("slug","Slug",'');
    
/*
	$plusOne[] = array('label'=>"Yes", 'value'=>'yes');
	$plusOne[] = array('label'=>"No", 'value'=>'no');
    
    echo $Form->select_field('plusOne','Allow +1 Bookings',$plusOne);
*/
	    
	echo $Form->submit_field('btnSubmit', 'Add Type', $API->app_path());
	
	echo $Form->form_end();
	
	}

    echo $HTML->main_panel_end();
