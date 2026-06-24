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

    echo $Form->form_start();
    
    if ($message) {
        echo $message;
    }else{
        echo $HTML->warning_message('Are you sure you wish to delete this voucher?');
        echo $Form->form_start();
        echo $Form->hidden('voucherID', $_GET['id']);
		echo $Form->submit_field('btnSubmit', 'Delete', $API->app_path());
        echo $Form->form_end();
    }
    
    echo $HTML->main_panel_end();
