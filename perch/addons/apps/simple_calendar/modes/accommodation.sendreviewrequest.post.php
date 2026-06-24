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
	    'title' => '&larr; Back to Calendar',
	    'link'  => '/addons/apps/simple_calendar/accommodation',
	]);
	
	$Smartbar->add_item([
	    'active' => false,
	    'title' => 'Edit Booking',
	    'link'  => '/addons/apps/simple_calendar/accommodation/booking/edit/?id='.$_GET['id'],
	]);
	
	$Smartbar->add_item([
	    'active' => false,
	    'title' => 'Send Confirmation',
	    'link'  => '/addons/apps/simple_calendar/accommodation/booking/send_confirmation/?id='.$_GET['id'],
	]);
	
	$Smartbar->add_item([
	    'active' => false,
	    'title' => 'Cancel Booking',
	    'link'  => '/addons/apps/simple_calendar/accommodation/booking/delete/?id='.$_GET['id'],
	]);
	
/*
	$Smartbar->add_item([
	    'active' => true,
	    'title' => 'Send Review Request',
	    'link'  => '/addons/apps/simple_calendar/accommodation/booking/send_reviewrequest/?id='.$_GET['id'],
	]);
*/
	
	echo $Smartbar->render();
    
    # Main panel
    echo $HTML->main_panel_start();
   
    include('_subnav.php');

    if (isset($message)){
	    echo $message;
	}else{
	    
	    echo $HTML->heading3('Send Confirmation');
	    
	    echo $Form->form_start();
	    
	    $customerData = $SimpleCalendar->customer($booking['customerID']);
	    $unitData = $SimpleCalendar->unit($booking['unitID'],'');
	    $memberDetails = json_decode($customerData['memberProperties'],true);
	    $emailData = $SimpleCalendar->getEmail(3);
	    
	    $arrivalDates = explode(" ",$booking['startTime']);
	    $arrivalDates = explode("-",$arrivalDates[0]);
	    $arrival = "$arrivalDates[2]/$arrivalDates[1]/$arrivalDates[0]";
	    
	    $departureDates = explode(" ",$booking['endTime']);
	    $departureDates = explode("-",$departureDates[0]);
	    $departure = "$departureDates[2]/$departureDates[1]/$departureDates[0]";
	    
	    $arrivalDates = explode(" ",$booking['startTime']);
	    $departureDates = explode(" ",$booking['endTime']);
	    
	    $diff = strtotime($departureDates[0]) - strtotime($arrivalDates[0]);
		$nights = $diff/86400;

		$placeHolders = array("{{unitName}}","{{bookingID}}","{{memberName}}","{{bookingArrival}}","{{bookingDeparture}}","{{bookingNights}}","{{bookingCost}}","{{bookingPaid}}");
		$emailContent = array($unitData['name'],"#".$booking['bookingID'],$memberDetails['first_name'],$arrival,$departure,$nights,$booking['cost'],$booking['paid']);

		$subject = str_replace(
		  $placeHolders,
		  $emailContent,
		  $emailData['subject']
		);
		
		$content = str_replace(
		  $placeHolders,
		  $emailContent,
		  $emailData['content']
		);
	
		echo $Form->text_field("subject","Subject",$subject);
		
		echo $Form->textarea_field("content","Content",$content);
		
		echo $Form->text_field("sendTo","Send To",$customerData['memberEmail']);
	
		echo $Form->hidden("send",'1');
	
		echo $Form->submit_field('btnSubmit', 'Send Confirmation', $API->app_path());
	
	    echo $Form->form_end();
	}

    
    echo $HTML->main_panel_end();
