<?php
    
    $HTML = $API->get('HTML');
    
    $SimpleCalendar = new Simple_Calendars($API);

    $HTML     = $API->get('HTML');
    $Form     = $API->get('Form');
    $Text     = $API->get('Text');
    $Template = $API->get('Template');
    
    $id = $_GET['id'];
	
    $booking = $SimpleCalendar->booking($id, false);
    
    if ($Form->submitted()) { 
	    
	    $data = $_POST;
	    
	    $arrival = "$data[start_year]-$data[start_month]-$data[start_day]";
	    $departure = "$data[end_year]-$data[end_month]-$data[end_day]";
	    
	    $nights = $SimpleCalendar->getNights($arrival,$departure);
	    
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
	    $conflicts = $SimpleCalendar->getConflictsB("$arrival 09:30:00","$departure 23:00:00",$data['unitID'],$_GET['id']);
			
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
		
		$totalPrice = $data['cost'];
	    
	    $totalPrice = number_format($totalPrice, 2, '.', '');
	    
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
		    $booking['cost'] = $data['cost'];
		    $booking['paid'] = $data['paid'];
		    $booking['addons'] = json_encode($addons);
		    $booking['notes'] = $data['notes'];
		    $booking['owner'] = $data['owner'];
		    
		    $SimpleCalendar->bookingUpdate($booking,$_GET['id']);
		    
		    $message = $HTML->success_message('Booking updated');
		    
	    }
    
	    

    }
