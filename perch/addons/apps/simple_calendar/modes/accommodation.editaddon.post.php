<?php
    # Side panel
    echo $HTML->side_panel_start();
    
    echo $HTML->side_panel_end();
    
    echo $HTML->title_panel([
    'heading' => $Lang->get('Accommodation'),
    'button'  => [
            'text' => $Lang->get('Add-on'),
            'link' => $API->app_nav().'/accommodation/addon',
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
    
    # Main panel
    echo $HTML->main_panel_start();
   
    include('_subnav.php');

    if (isset($message)) echo $message;
	    
    echo $HTML->heading3('Update Add-on');

	echo $Form->form_start();
	
	echo $Form->text_field("name","Name",$addon['name']);
	echo $Form->text_field("description","Description",$addon['description']);
	echo $Form->text_field("price","Price (no £ sign)",$addon['price']);
	    
	echo $Form->submit_field('btnSubmit', 'Update Add-on', $API->app_path());
	
	echo $Form->hidden('addonID', $_GET['id']);
	
	echo $Form->form_end();

    echo $HTML->main_panel_end();
