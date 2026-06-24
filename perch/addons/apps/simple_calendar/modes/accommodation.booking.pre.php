<?php
	
	//ini_set('display_errors', 1);
	//ini_set('display_startup_errors', 1);
	//error_reporting(E_ALL);
    
    $HTML = $API->get('HTML');
    
    $SimpleCalendar = new Simple_Calendars($API);

    $HTML     = $API->get('HTML');
    $Form     = $API->get('Form');
    $Text     = $API->get('Text');
    $Template = $API->get('Template');

    if ($Form->submitted()) { 
	    
	    $data = $_POST;
	    
	    $arrival = "$data[start_year]-$data[start_month]-$data[start_day]";
	    $departure = "$data[end_year]-$data[end_month]-$data[end_day]";
	    
	    $nights = $SimpleCalendar->getNights($arrival,$departure);
	    $nights = $nights + 1;
	    
	    $dateData = $SimpleCalendar->getUnitPricingDate($arrival,$data['unitID']);
	    
	    $unitData = $SimpleCalendar->unit($data['unitID'],'');
	    
	    //check dates
/*
	    if($departure<=$arrival){
		    $message = $HTML->failure_message('Departure date must be greater than arrival date');
		    
		    $error = 1;  
	    }
*/
	    
	    /*
	    //check min stay requirement
	    if($nights<$dateData['minStay']){
		    $message = $HTML->failure_message('Does not meet minimum stay requirement');
		    
		    $error = 1;  
	    }
	    */
	    
	    //check for booking conflict
	    $conflicts = $SimpleCalendar->getConflicts("$arrival 09:30:00","$departure 23:00:00",$data['unitID']);
			
	    if($conflicts>0){
		    $message = $HTML->failure_message('There\'s a booking conflict');
		    
		    $error = 1;
	    }
	    
	    /*
	    //check arrival date
	    $arrivalDay = date("D", mktime(0, 0, 0, $data['start_month'], $data['start_day']+$night, $data['start_year']));
	    
	    if(($dateData['changeOver']=='Fri/Mon' AND $arrivalDay=='Fri') OR ($dateData['changeOver']=='Fri/Mon' AND $arrivalDay=='Mon') OR ($dateData['changeOver']=='Fri - Fri' AND $arrivalDay=='Fri') OR ($dateData['changeOver']=='Sat - Sat' AND $arrivalDay=='Sat') OR $dateData['changeOver']=='Any Day'){
		    
		    
	    }else{
		 
			$message = $HTML->failure_message('Booking cannot begin on this day');
		    
		    $error = 1;
		    
	    }
	    */
	    
	    //cycle through nights to calc price
	    if($nights == 1){ $nightVar = 'onenight'; }
	    if($nights == 2){ $nightVar = 'twonights'; }
	    if($nights == 3){ $nightVar = 'threenights'; }
	    if($nights == 4){ $nightVar = 'fournights'; }
	    if($nights == 5){ $nightVar = 'fivenights'; }
	    if($nights == 6){ $nightVar = 'sixnights'; }
	    if($nights >= 7){ $nightVar = 'sevennights'; }
	    
	    $nightVar = 'onenight';
	    
	    $night = 0;
	    
	    while($night<$nights){
		    
		    $date = date("Y-m-d", mktime(0, 0, 0, $data['start_month'], $data['start_day']+$night, $data['start_year']));
		    $day = date("D", mktime(0, 0, 0, $data['start_month'], $data['start_day']+$night, $data['start_year']));
		    $dateData = $SimpleCalendar->getUnitPricingDate($date,$data['unitID']);

			if($day=='Sat' OR $day=='Sun'){
				$thisPrice = $dateData['twonights'];
			}else{
				$thisPrice = $dateData['onenight'];
			}
		    
			$nightPrice = $thisPrice;		    
		    
		    $totalPrice = $totalPrice+$nightPrice;
        
        //echo "Night: $night - Price: $nightPrice - Total: $totalPrice<br />";
		    
		    $night++;
	    }
	    
	    $totalPrice = number_format(round($totalPrice), 2, '.', '');
	    
	    //generate add-on array
   	    $addonData = $SimpleCalendar->getAddons();
   	    $addons = array();
   	    foreach($addonData AS $addOn){
	   	    
	   	    $addonQTY = $data['addon_'.$addOn['addonID']];
	   		$addons['addon_'.$addOn['addonID']] = $addonQTY;
	   		$thisAddon = $SimpleCalendar->addon($addOn['addonID']);
	   		$addons['addon_'.$addOn['addonID'].'_price'] = $thisAddon['price'];
	   	    
   	    }
	    
	    if($error<>'1'){
		    
		    $booking = array();
		    $booking['firstName'] = $data['firstName'];
		    $booking['lastName'] = $data['lastName'];
		    $booking['emailAddress'] = $data['emailAddress'];
		    $booking['phone'] = $data['phone'];
		    $booking['startTime'] = "$arrival 09:30:00";
		    $booking['endTime'] = "$departure 23:00:00";
		    $booking['unitID'] = $data['unitID'];
		    $booking['cost'] = $totalPrice;
		    $booking['addons'] = json_encode($addons);
		    $booking['notes'] = $data['notes'];
		    $booking['owner'] = $data['owner'];
		    
		    $SimpleCalendar->bookingAdd($booking);
		    
		    $message = $HTML->success_message('Booking complete');
		    
	    }
    
	    

    }
