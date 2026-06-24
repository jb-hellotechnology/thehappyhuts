<?php
	session_start();
    /*
        tdis file includes tde code called by tde site pages at runtime.
        If you app is admin-only tden don't include tdis file.
        
        Remember - try and be as lightweight at runtime as possble. Include only 
        what you need to, run only 100% necessary code. Make every database query
        count.
    */

/*
	ini_set('display_errors', 1);
	ini_set('display_startup_errors', 1);
	error_reporting(E_ALL);
*/

    # Include your class files as needed - up to you.
    include('Simple_Calendars.class.php');
    include('Simple_Calendar.class.php');

	function simple_calendar_unit_pricing($slug){
		
		$API = new Simple_Calendars($API);
		$SimpleCalendar = new Simple_Calendars($API);
		
		$unitData = $SimpleCalendar->unitbySlug($slug,'');
		
		echo '<table class="d">
					<tr>
						<td colspan="5">Date Period</td>
						<td colspan="7">Price/Nights</td>
					</tr>
		            <tr>
		                <td class="first">Start Date</td>  
		                <td>End Date</td>
		                <td></td>
		                <td>Min. Stay</td>
		                <td>Changeover</td>
		                <td>1 Night</td> 
		                <td>2 Nights</td> 
		                <td>3 Nights</td> 
		                <td>4 Nights</td> 
		                <td>5 Nights</td> 
		                <td>6 Nights</td>  
		                <td>7 Nights</td>
		            </tr>';
	
		$unitPricing = $SimpleCalendar->getunitPricing_Public($slug);
		foreach($unitPricing as $price){
	
			$sDates = explode("-",$price['startDate']);
			$start = "$sDates[2]/$sDates[1]/$sDates[0]";
			
			$eDates = explode("-",$price['endDate']);
			$end = "$eDates[2]/$eDates[1]/$eDates[0]";
	
			echo "<tr>
					<td>$start</td>
					<td>$end</td>
					<td>$price[freeText]</td>
					<td>$price[minStay]</td>
					<td>$price[changeOver]</td>
					<td>"; if($price['onenight']=='0.00'){echo "-";}else{echo $price['onenight'];} echo "</td>
					<td>"; if($price['twonights']=='0.00'){echo "-";}else{echo $price['twonights'];} echo "</td>
					<td>"; if($price['threenights']=='0.00'){echo "-";}else{echo $price['threenights'];} echo "</td>
					<td>"; if($price['fournights']=='0.00'){echo "-";}else{echo $price['fournights'];} echo "</td>
					<td>"; if($price['fivenights']=='0.00'){echo "-";}else{echo $price['fivenights'];} echo "</td>
					<td>"; if($price['sixnights']=='0.00'){echo "-";}else{echo $price['sixnights'];} echo "</td>
					<td>"; if($price['sevennights']=='0.00'){echo "-";}else{echo $price['sevennights'];} echo "</td>
				</tr>";
			
		}
	
		echo '
			</table>';

		if($unitData['minDiscount']>0){
			
			$discount = (100-$unitData['discountPercentage'])/100;
			
			echo "<h2>Discounted (-$unitData[discountPercentage]%) Pricing for Groups of $unitData[minDiscount] People or Fewer</h2>";
			
			echo '<table class="d">
					<tr>
						<td colspan="5">Date Period</td>
						<td colspan="7">Price/Nights</td>
					</tr>
		            <tr>
		                <td class="first">Start Date</td>  
		                <td>End Date</td>
		                <td></td>
		                <td>Min. Stay</td>
		                <td>Changeover</td>
		                <td>1 Night</td> 
		                <td>2 Nights</td> 
		                <td>3 Nights</td> 
		                <td>4 Nights</td> 
		                <td>5 Nights</td> 
		                <td>6 Nights</td>  
		                <td>7 Nights</td>
		            </tr>';
	
			$unitPricing = $SimpleCalendar->getunitPricing_Public($slug);
			foreach($unitPricing as $price){
		
				$sDates = explode("-",$price['startDate']);
				$start = "$sDates[2]/$sDates[1]/$sDates[0]";
				
				$eDates = explode("-",$price['endDate']);
				$end = "$eDates[2]/$eDates[1]/$eDates[0]";
				
				if($price['discount']=='on'){

					echo "<tr>
							<td>$start</td>
							<td>$end</td>
							<td>$price[freeText]</td>
							<td>$price[minStay]</td>
							<td>$price[changeOver]</td>
							<td>"; if($price['onenight']=='0.00'){echo "-";}else{echo number_format(floor($price['onenight'])*$discount,2);} echo "</td>
							<td>"; if($price['twonights']=='0.00'){echo "-";}else{echo number_format(floor($price['twonights'])*$discount,2);} echo "</td>
							<td>"; if($price['threenights']=='0.00'){echo "-";}else{echo number_format(floor($price['threenights'])*$discount,2);} echo "</td>
							<td>"; if($price['fournights']=='0.00'){echo "-";}else{echo number_format(floor($price['fournights'])*$discount,2);} echo "</td>
							<td>"; if($price['fivenights']=='0.00'){echo "-";}else{echo number_format(floor($price['fivenights'])*$discount,2);} echo "</td>
							<td>"; if($price['sixnights']=='0.00'){echo "-";}else{echo number_format(floor($price['sixnights'])*$discount,2);} echo "</td>
							<td>"; if($price['sevennights']=='0.00'){echo "-";}else{echo number_format(floor($price['sevennights'])*$discount,2);} echo "</td>
						</tr>";
						
				}else{
					
					echo "<tr>
							<td>$start</td>
							<td>$end</td>
							<td>$price[freeText]</td>
							<td>$price[minStay]</td>
							<td>$price[changeOver]</td>
							<td>"; if($price['onenight']=='0.00'){echo "-";}else{echo number_format(floor($price['onenight']),2);} echo "</td>
							<td>"; if($price['twonights']=='0.00'){echo "-";}else{echo number_format(floor($price['twonights']),2);} echo "</td>
							<td>"; if($price['threenights']=='0.00'){echo "-";}else{echo number_format(floor($price['threenights']),2);} echo "</td>
							<td>"; if($price['fournights']=='0.00'){echo "-";}else{echo number_format(floor($price['fournights']),2);} echo "</td>
							<td>"; if($price['fivenights']=='0.00'){echo "-";}else{echo number_format(floor($price['fivenights']),2);} echo "</td>
							<td>"; if($price['sixnights']=='0.00'){echo "-";}else{echo number_format(floor($price['sixnights']),2);} echo "</td>
							<td>"; if($price['sevennights']=='0.00'){echo "-";}else{echo number_format(floor($price['sevennights']),2);} echo "</td>
						</tr>";
						
				}
				
			}
		
			echo '
				</table>';
			
		}
		
	}

  function getPricing($unit,$arrival){
   		$API = new Simple_Calendars($API);
		$SimpleCalendar = new Simple_Calendars($API);
	    $unitData = $SimpleCalendar->unitbySlug($unit,'');
	    $dateData = $SimpleCalendar->getUnitPricingDate($arrival,$unitData['unitID']);
	    return $dateData;
  }
	
	function simple_calendar_monthly_calendar($unit,$year,$month){
		
		$API = new Simple_Calendars($API);
		$SimpleCalendar = new Simple_Calendars($API);
		
		if($year == ''){
			$year = date('Y');
		}
		
		if($month == ''){
			$month = date('n');
		}
		
		$lastMonth = $month-1;
		$nextMonth = $month+1;
		
		if($month == 1){
			$lastYear = $year-1;
			$lastMonth = 12;
			$nextYear = $year;
		}elseif($month == 12){
			$nextYear = $year+1;
			$nextMonth = 1;
		}else{
			$lastYear = $year;
			$nextYear = $year;
		}
		
		$tabs = "\n\t\t\t\t";
	    $w_days = array("S","S","M","T","W","T","F");
	    $stamp = mktime(0,0,0,$month,2,$year);
	    $maxday = date("t",$stamp);
	    $thismonth = getdate($stamp);
	    $startday = $thismonth['wday'];    
		$thisYear = $lastYear+1;
		
		echo "<table class='cal-table'>
		        <tr class='cal-month'>
		            <td colspan='7'>
		            	<a class='last' href='javascript:month(\"$lastYear\",\"$lastMonth\",\"$unit\");'><i class='fa fa-arrow-left' aria-hidden='true'></i>
						</a>"; 
						echo date("F",$stamp); echo " $year"; 
						echo "<a class='next' href='javascript:month(\"$nextYear\",\"$nextMonth\",\"$unit\");'><i class='fa fa-arrow-right' aria-hidden='true'></i>
						</a>
					</td>
		        </tr>
		        <tr class='cal-days'>";
		            foreach($w_days as $d) { echo "$tabs\t\t<td>$d</td>"; }
		    echo "</tr>";
				$curr_month = (date("F Y")==date("F Y",$stamp))? TRUE : FALSE; // if this calendar is displaying current month
			    $today = date("j"); 
			    for ($i=0; $i<($maxday+$startday); $i++) {
			        if(($i % 7) == 0 ) echo "$tabs\t<tr class='cal-date'>";
			        
			        $day = $i - $startday + 1;
			        $curDate = date("Y-m-d", mktime(0, 0, 0, $month, $day, $year));
					$curDate2 = date("m-d", mktime(0, 0, 0, $month, $day, $year));
			        $thisDay = date("D", mktime(0, 0, 0, $month, $day, $year));
			        
			        $limitDate = date("Y-m-d", mktime(0, 0, 0, date('m')+4, 1, date('Y')));
			        
			        $unitData = $SimpleCalendar->unitSlug($unit);
					$rows = $SimpleCalendar->bookingCheck($unitData['unitID'],$curDate);
					
					if($rows>0){
						$date_class = " class='un'";
						
						if($i < $startday) echo "$tabs\t\t<td></td>";
				        else echo "$tabs\t\t<td{$date_class}>". ($i - $startday + 1) . "</td>";
				        if(($i % 7) == 6 ) echo "$tabs\t</tr>\n";
						
					}else{
            
            $date_class = " class='av'";

            if($i < $startday){
              echo "$tabs\t\t<td></td>";
            }else{

              $isArrival = $SimpleCalendar->isArrival($unit,$curDate);

              if($isArrival==1 AND $curDate<=$limitDate){
                $date_class = " class='ar'";
                echo "$tabs\t\t
                <td{$date_class}>
                  <form method=\"post\" action=\"/booking?s=$unitData[slug]\">
                  <input type=\"hidden\" name=\"arrivalDate\" value=\"$curDate\" />
                  <input type=\"hidden\" name=\"unit\" value=\"$unit\" />
                  <input type=\"submit\" value=\"". ($i - $startday + 1) . "\" />
                  </form>
                </td>";
              }else{
                echo "$tabs\t\t<td{$date_class}>". ($i - $startday + 1) . "</td>";
              }

            }
            if(($i % 7) == 6 ){
              echo "$tabs\t</tr>\n";
            }
				        
					}
					
				}
				
			echo "$tabs</table>";
		
		echo "<table class='key'>
				<tr><td colspan='6'>Key</td></tr>
				<tr><td class='un'>1</td><td>Booked</td><td class='av'>1</td><td>Available</td><td class='ar'>1</td><td>Arrival</td></tr>
			</table>";
			
		echo '<script type="text/javascript">
			function month(year,month,unit){
				$( ".monthly-calendar" ).load( \'/perch/templates/simple_calendar/monthly-calendar.php?unit=\'+unit+\'&year=\'+year+\'&month=\'+month );	
			}
		</script>';	
		
	}

	function simple_calendar_monthly_calendar_all($unit,$year,$month){
		
		$API = new Simple_Calendars($API);
		$SimpleCalendar = new Simple_Calendars($API);
		
		if($year == ''){
			$year = date('Y');
		}
		
		if($month == ''){
			$month = date('n');
		}
		
		$lastMonth = $month-1;
		$nextMonth = $month+1;
		
		if($month == 1){
			$lastYear = $year-1;
			$lastMonth = 12;
			$nextYear = $year;
		}elseif($month == 12){
			$nextYear = $year+1;
			$nextMonth = 1;
		}else{
			$lastYear = $year;
			$nextYear = $year;
		}
		
		$tabs = "\n\t\t\t\t";
	    $w_days = array("S","S","M","T","W","T","F");
	    $stamp = mktime(0,0,0,$month,2,$year);
	    $maxday = date("t",$stamp);
	    $thismonth = getdate($stamp);
	    $startday = $thismonth['wday'];    
		$thisYear = $lastYear+1;

		$name = ucwords(str_replace("-"," ",$unit));
		
		$unitData = $SimpleCalendar->unitbySlug($unit,'');

		$dogFriendly = $unitData['dogFriendly'];
		
		if($unitData['enableCalendar']=='yes'){
    
		echo "<table class='cal-table'>
            <tr>
              <td colspan='7' class='larger'>$name | $dogFriendly</td>
            </tr>
		        <tr class='cal-month'>
		            <td colspan='7'>
		            	<a class='last' href='javascript:month(\"$lastYear\",\"$lastMonth\",\"$unit\");'><i class='fa fa-arrow-left' aria-hidden='true'></i>
						</a>"; 
						echo date("F",$stamp); echo " $year"; 
						echo "<a class='next' href='javascript:month(\"$nextYear\",\"$nextMonth\",\"$unit\");'><i class='fa fa-arrow-right' aria-hidden='true'></i>
						</a>
					</td>
		        </tr>
		        <tr class='cal-days'>";
		            foreach($w_days as $d) { echo "$tabs\t\t<td>$d</td>"; }
		    echo "</tr>";
				
				$curr_month = (date("F Y")==date("F Y",$stamp))? TRUE : FALSE; // if this calendar is displaying current month
			    $today = date("j"); 
			    for ($i=0; $i<($maxday+$startday); $i++) {
			        if(($i % 7) == 0 ) echo "$tabs\t<tr class='cal-date'>";
			        
			        $day = $i - $startday + 1;
			        $curDate = date("Y-m-d", mktime(0, 0, 0, $month, $day, $year));
					$curDate2 = date("m-d", mktime(0, 0, 0, $month, $day, $year));
			        $thisDay = date("D", mktime(0, 0, 0, $month, $day, $year));
			        
			        date_default_timezone_set('Europe/London');
			        
			        $limitDate = date("Y-m-d", mktime(0, 0, 0, date('m')+12, 0, date('Y')));
					$todayDate = date("Y-m-d 08:00:00");
			        
			        $unitData = $SimpleCalendar->unitSlug($unit);
					$rows = $SimpleCalendar->bookingCheck($unitData['unitID'],$curDate);
					
					if($rows>0){
						$date_class = " class='un'";
						
						if($i < $startday) echo "$tabs\t\t<td></td>";
				        else echo "$tabs\t\t<td{$date_class}>". ($i - $startday + 1) . "</td>";
				        if(($i % 7) == 6 ) echo "$tabs\t</tr>\n";
						
					}else{
            
            $date_class = " class='av'";

		    $monthText = date("F", mktime(0, 0, 0, $month, 1, 1997));
		    $availability = $SimpleCalendar->getAvailabilityMonth($monthText);

            if($i < $startday){
              echo "$tabs\t\t<td></td>";
            }elseif($curDate>$limitDate){
            	echo "$tabs\t\t<td class='un'>". ($i - $startday + 1) . "</td>";
            }elseif($curDate<$todayDate){
            	echo "$tabs\t\t<td class='un'>". ($i - $startday + 1) . "</td>";
            }elseif($availability=='closed'){
            	echo "$tabs\t\t<td class='un'>". ($i - $startday + 1) . "</td>";
            }elseif($availability=='weekends' AND ($thisDay<>'Sat' AND $thisDay<>'Sun')){
            	echo "$tabs\t\t<td class='un'>". ($i - $startday + 1) . "</td>";
            }else{

              $isArrival = 1;

              if($isArrival==1){
                $date_class = " class='ar'";
                echo "$tabs\t\t
                <td{$date_class}>";
            
                  echo "<form method=\"post\" action=\"/embed/book/days/$unit\" target=\"_blank\">
                  <input type=\"hidden\" name=\"arrivalDate\" value=\"$curDate\" />
                  <input type=\"hidden\" name=\"unit\" value=\"$unit\" />
                  <input type=\"submit\" value=\"". ($i - $startday + 1) . "\" />
                  </form>";

                echo "</td>";
              }else{
                echo "$tabs\t\t<td{$date_class}>". ($i - $startday + 1) . "</td>";
              }

            }
            if(($i % 7) == 6 ){
              echo "$tabs\t</tr>\n";
            }
				        
					}
					
				}
				
			echo "$tabs</table>";
			
		echo '<script type="text/javascript">
			function month(year,month,unit){
				$( ".monthly-calendar-all" ).load( \'/perch/templates/simple_calendar/monthly-calendar-all.php?unit=\'+unit+\'&year=\'+year+\'&month=\'+month );	
			}
		</script>';	
		
		}
		
	}
	
	function simple_calendar_yearly_calendar($unit,$year){
		
		$API = new Simple_Calendars($API);
		$SimpleCalendar = new Simple_Calendars($API);
		
		if($year == ''){
			$year = date('Y');
		}
		
		$lastYear = $year-1;
		$nextYear = $year+1;
			
		$month = 1;
		
		echo '<ul class="control">
				<li><a href="javascript:year('.$lastYear.',\''.$unit.'\');"><i class="fa fa-arrow-left" aria-hidden="true"></i></a></li>
				<li>'.$year.'</li>
				<li><a href="javascript:year('.$nextYear.',\''.$unit.'\');"><i class="fa fa-arrow-right" aria-hidden="true"></i></a></li>
			</ul>';
		
		while($month<=12){
			
			$tabs = "\n\t\t\t\t";
		    $w_days = array("S","S","M","T","W","T","F");
		    $stamp = mktime(0,0,0,$month,2,$year);
		    $maxday = date("t",$stamp);
		    $thismonth = getdate($stamp);
		    $startday = $thismonth['wday']; 
			
			echo "
			    <table class='cal-table'>
			        <tr class='cal-month'>
			            <td colspan='7'>";
							echo date("F",$stamp); echo " $year"; 
					echo "</td>
			        </tr>
			        <tr class='cal-days'>";
			            foreach($w_days as $d) { echo "$tabs\t\t<td>$d</td>"; }
			    echo "</tr>";
					
					$curr_month = (date("F Y")==date("F Y",$stamp))? TRUE : FALSE; // if this calendar is displaying current month
				    $today = date("j"); 
				    for ($i=0; $i<($maxday+$startday); $i++) {
				        if(($i % 7) == 0 ) echo "$tabs\t<tr class='cal-date'>";
				        
				        $day = $i - $startday + 1;
				        $curDate = date("Y-m-d", mktime(0, 0, 0, $month, $day, $year));
				        $thisDay = date("D", mktime(0, 0, 0, $month, $day, $year));
				        
				        $unitData = $SimpleCalendar->unitSlug($unit);
						$rows = $SimpleCalendar->bookingCheck($unitData['unitID'],$curDate);
						
						if($rows>0){
							$date_class = " class='un'";
							
							if($i < $startday) echo "$tabs\t\t<td></td>";
					        else echo "$tabs\t\t<td{$date_class}>". ($i - $startday + 1) . "</td>";
					        if(($i % 7) == 6 ) echo "$tabs\t</tr>\n";
							
						}else{
							$date_class = " class='av'";
							
							if($i < $startday) echo "$tabs\t\t<td></td>";
					        else echo "$tabs\t\t<td{$date_class}>". ($i - $startday + 1) . "</td>";
					        if(($i % 7) == 6 ) echo "$tabs\t</tr>\n";
					        
						}
						
					}
					
				echo "$tabs</table>";
		
			$month++;
		}
		
		echo "<table class='key'>
				<tr><td colspan='6'>Key</td></tr>
				<tr><td class='un'>1</td><td>Booked</td><td class='av'>1</td><td>Available</td></tr>
			</table>";
		
		echo '<script type="text/javascript">
			function year(year,unit){
				$( ".yearly-calendar" ).load( \'/perch/templates/simple_calendar/yearly-calendar.php?unit=\'+unit+\'&year=\'+year );	
			}
		</script>';
	}

  function getMaxNights($unit,$date){

    $API = new Simple_Calendars($API);
		$SimpleCalendar = new Simple_Calendars($API);
    
    $nights = $SimpleCalendar->getMaxNights($unit,$date);
    if($nights>14){
      $nights = 14;
    }
    
    return $nights;
    
  }

  function getMinNights($unit,$date){

    $API = new Simple_Calendars($API);
		$SimpleCalendar = new Simple_Calendars($API);
    
    $nights = $SimpleCalendar->getMinNights($unit,$date);
    
    return $nights;
    
  }

  function getMaxOccupants($unit){

    $API = new Simple_Calendars($API);
		$SimpleCalendar = new Simple_Calendars($API);
    
    $occupants = $SimpleCalendar->getMaxOccupants($unit);
    
    return $occupants;
    
  }

  function getUnitBySlug($unit){

    $API = new Simple_Calendars($API);
		$SimpleCalendar = new Simple_Calendars($API);
    
    $unitData = $SimpleCalendar->unitbySlug($unit,'');
    
    return $unitData;
    
  }

function getUnitByID($unitID){

    $API = new Simple_Calendars($API);
		$SimpleCalendar = new Simple_Calendars($API);
    
    $unitData = $SimpleCalendar->unit($unitID,'');
    
    return $unitData;
    
  }
  

function conflicts($unit,$arrival,$departure){
	$API = new Simple_Calendars($API);
	$SimpleCalendar = new Simple_Calendars($API);
	$conflicts = $SimpleCalendar->getConflicts("$arrival 09:30:00","$departure 23:00:00",$unit);
	if($conflicts>0){
		return 'conflict';
	}else{
		return 'available';
	}
}

function conflictsC($unit,$arrival,$departure,$reference){
	$API = new Simple_Calendars($API);
	$SimpleCalendar = new Simple_Calendars($API);
	$conflicts = $SimpleCalendar->getConflictsC($arrival,"$departure 23:00:00",$unit,$reference);
	if($conflicts>0){
		return 'conflict';
	}else{
		return 'available';
	}
}

function getPrice($nights,$unit,$arrival){

    $API = new Simple_Calendars($API);
    $SimpleCalendar = new Simple_Calendars($API);
  
    $arrivalDate = explode("-",$arrival);

    $unitData = $SimpleCalendar->unitbySlug($unit,'');

    $dateData = $SimpleCalendar->getUnitPricingDate($arrival,$unitData['unitID']);

    //check for booking conflict
    $conflicts = $SimpleCalendar->getConflicts("$arrival 09:30:00","$departure 23:00:00",$data['unitID']);

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

	  $day = date("D", mktime(0, 0, 0, $arrivalDate['1'], $arrivalDate['2']+$night, $arrivalDate['0']));
      $date = date("Y-m-d", mktime(0, 0, 0, $arrivalDate['1'], $arrivalDate['2']+$night, $arrivalDate['0']));
      $dateData = $SimpleCalendar->getUnitPricingDate($date,$unitData['unitID']);
      
      //print_r($dateData);

	  if($day=='Sat' OR $day=='Sun'){
      	$thisPrice = $dateData['twonights'];
      }else{
	      $thisPrice = $dateData['onenight'];
      }

      $nightPrice = $thisPrice;
      $totalPrice = $totalPrice+$nightPrice;

      if($nightPrice<='0'){
        $error = 1;
      }
      
      $nightPrice = number_format($nightPrice, 2, '.', '');
      
      //echo $nightPrice."<br/>";

      $night++;
    }
    
    // VOUCHER CODES
    $discount = 0;
    foreach($_SESSION['voucherCode'] AS $code){
	    $voucherCode = $SimpleCalendar->getVoucher($code);
	    if($voucherCode['voucherValue']>0){
	    	$discount = $discount+$voucherCode['voucherValue'];
	    }
	}
    
    $deposit = $totalPrice;
  
    $toPay = $deposit*100;
  
    if($error==1){
      
      $HTML .= "<p><strong>Woops! Sorry, it looks like we're missing some pricing information and can't give you a price online.</strong></p>";
      
    }else{
	    
	      $HTML .= "<h3>Booking Price</h3>";
	      $HTML .= "<p><strong>&pound;".number_format($totalPrice,2)."</strong></p>";
	      if($discount>0){
		      $toPay = $totalPrice-$discount;
		      if($toPay<0){
			      $toPay = 0;
		      }
		      $HTML .= "<p><strong>&pound;".number_format($discount,2)." voucher code discount applied</strong></p>";
		      $HTML .= "<p><strong>&pound;".number_format($toPay,2)." to pay</strong></p>";
		  }else{
			  $toPay = $totalPrice;
		  }
		  $HTML .= "</p>";
	     
	      $HTML .= "<input type=\"hidden\" name=\"cost\" value=\"$totalPrice\" />";
	      $HTML .= "<input type=\"hidden\" name=\"discount\" value=\"$discount\" />";
	      $HTML .= "<input type=\"hidden\" name=\"deposit\" value=\"$deposit\" />";
	      $HTML .= "<input type=\"hidden\" name=\"secret\" id=\"secret\" value=\"\" />";
	      $HTML .= "<h3>Terms &amp; Conditions</h3>";
	      $HTML .= "<div class='form-input'><label><input type=\"checkbox\" id=\"terms\" name=\"terms\" onclick=\"javascript:checkTerms();\" /> I agree to the <a href=\"/terms\" target=\"_blank\">terms and conditions</a> of booking</label></div>";
	      
	      if($toPay>0){
	      
	      $HTML .= '<br /><br /><div class="stripebutton" style="display:none;"><h3>Ready to Pay?</h3>';
	      $HTML .= '<div id="card-element"></div>
				  <div id="card-errors" role="alert"></div>
				  <button id="submit" class="button">Pay by Card</button></div>
				</form>';
		  $stripeDeposit = $toPay*100;
		  $HTML .= '
				<script>
				function checkTerms(){
	                  if (document.getElementById("terms").checked) {
	                   $(".stripebutton").show();
	                   paymentForm();
	                  } else {
	                   $(".stripebutton").hide();
	                  }
	                }
	             
	            function paymentForm(){
	            
		            var pEmail = $("#emailaddress").val();
		            var pPhone = $("#telephone").val();
		            var pFname = $("#firstname").val();
		            var pLname = $("#lastname").val();
		            var pName = pFname+" "+pLname;
		            var pArrival = $("#arrival").val();
		            var pNights = $("#nights").val();
		            var pReference = $("#reference").val();
		            var pUnit = $("#unitID").val();
					var response = fetch("/token.php?value='.$stripeDeposit.'&email="+pEmail+"&phone="+pPhone+"&name="+pName+"&first_name="+pFname+"&last_name="+pLname+"&arrival="+pArrival+"&nights="+pNights+"&reference="+pReference+"&unit="+pUnit).then(function(response) {
					  return response.json();
					}).then(function(responseJson) {
					  var clientSecret = responseJson.client_secret;
					  // Call stripe.confirmCardPayment() with the client secret.
					  
					  $("#secret").val(clientSecret);
					  var datastring = $("#payment-form").serialize();
					  $.ajax({
						    type: "POST",
						    url: "/embed/book/secret",
						    data: datastring
						});
											
											
					var stripe = Stripe(\''.getenv('STRIPE_PUBLISHABLE_KEY').'\');
					var elements = stripe.elements();
					
					var elements = stripe.elements();
					var style = {
					  base: {
					    color: "#000",
					  }
					};
					
					var card = elements.create("card", { 
						hidePostalCode: true, 
						style: { 
							base: {
							  lineHeight: \'40px\',
							  fontWeight: 300,
							  fontSize: \'15px\',
							  \'::placeholder\': {
							    color: \'#222\',
							   }, 
							}
						}
					});
					card.mount("#card-element");
					
					card.on("change", ({error}) => {
					  let displayError = document.getElementById("card-errors");
					  if (error) {
					    displayError.textContent = error.message;
					  } else {
					    displayError.textContent = "";
					  }
					});
					
					var form = document.getElementById(\'payment-form\');
		
					form.addEventListener(\'submit\', function(ev) {
						ev.preventDefault();
						var datastring = $("#payment-form").serialize();
						$.ajax({
						    type: "POST",
						    url: "/embed/book/check",
						    data: datastring,
						    success: function(data) {
						    	if(data==\'conflict\'){
							    	alert("Sorry, someone\'s beaten you to it! There\'s a booking conflict. Please go back and try different dates.");
							    }else{
								    $(\'#payment-form button\').prop("disabled", true);
									$(\'#payment-form button\').hide();
									stripe.confirmCardPayment(clientSecret, {
									payment_method: {
										card: card
									}
									}).then(function(result) {
										if (result.error) {
										  // Show error to your customer (e.g., insufficient funds)
										  $(\'#payment-form button\').prop("disabled", false);
										  $(\'#payment-form button\').show();
										} else {
										    var datastring = $("#payment-form").serialize();
											$.ajax({
											    type: "POST",
											    url: "/embed/book/process",
											    data: datastring,
											    success: function(data) {
											        window.location.replace("/embed/book/complete");
											    },
											    error: function(data) {
											        console.log("Error");
											    }
											});
										}
									});
								}   
						    }
						});
					  
					});
					});
				
				}
				</script>';
		}else{
			$HTML .= '<br /><br /><div class="stripebutton" style="display:none;"><h3>Nothing to Pay!</h3><a class="button" href="javascript:submitBooking();">Book</a>';
			$HTML .= '<script>
			function checkTerms(){
	                  if (document.getElementById("terms").checked) {
	                   $(".stripebutton").show();
	                  } else {
	                   $(".stripebutton").hide();
	                  }
	                }
						function submitBooking(){
							
							var datastring = $("#payment-form").serialize();
							$.ajax({
							    type: "POST",
							    url: "/embed/book/check",
							    data: datastring,
							    success: function(data) {
							    	if(data==\'conflict\'){
								    	alert("Sorry, someone\'s beaten you to it! There\'s a booking conflict. Please go back and try different dates.");
								    }else{
							
										var datastring = $("#payment-form").serialize();
										$.ajax({
										    type: "POST",
										    url: "/embed/book/process",
										    data: datastring,
										    success: function(data) {
										        window.location.replace("/embed/book/complete");
										    },
										    error: function(data) {
										        console.log("Error " + data);
										    }
										});
										
									}
								}
							});
							
						}
					</script>';
			$HTML .= '</div>';
		}
      
    }
  
    return $HTML;
}

function getPriceValue($nights,$unit,$arrival,$return){

    $API = new Simple_Calendars($API);
    $SimpleCalendar = new Simple_Calendars($API);
  
    $arrivalDate = explode("-",$arrival);

    $unitData = $SimpleCalendar->unitbySlug($unit,'');

    $dateData = $SimpleCalendar->getUnitPricingDate($arrival,$unitData['unitID']);

    //check for booking conflict
    $conflicts = $SimpleCalendar->getConflicts("$arrival 09:30:00","$departure 23:00:00",$data['unitID']);

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

	  $day = date("D", mktime(0, 0, 0, $arrivalDate['1'], $arrivalDate['2']+$night, $arrivalDate['0']));
      $date = date("Y-m-d", mktime(0, 0, 0, $arrivalDate['1'], $arrivalDate['2']+$night, $arrivalDate['0']));
      $dateData = $SimpleCalendar->getUnitPricingDate($date,$unitData['unitID']);
      
      //print_r($dateData);

	  if($day=='Sat' OR $day=='Sun'){
      	$thisPrice = $dateData['twonights'];
      }else{
	      $thisPrice = $dateData['onenight'];
      }

      $nightPrice = $thisPrice;
      $totalPrice = $totalPrice+$nightPrice;

      if($nightPrice<='0'){
        $error = 1;
      }
      
      $nightPrice = number_format($nightPrice, 2, '.', '');
      
      //echo $nightPrice."<br/>";

      $night++;
    }
    
    // VOUCHER CODES
    $discount = 0;
    foreach($_SESSION['voucherCode'] AS $code){
	    $voucherCode = $SimpleCalendar->getVoucher($code);
	    if($voucherCode['voucherValue']>0){
	    	$discount = $discount+$voucherCode['voucherValue'];
	    }
	}
    
    $deposit = $totalPrice-$discount;
  
    $toPay = $deposit*100;
    
    if($toPay<0){
	    $toPay = 0;
    }
  
	if($return){
		return $toPay;
	}else{
    	echo $toPay;
    }
}

function simple_calendar_progress_booking($startTime,$endTime,$unitID,$firstName,$lastName,$email,$phone,$cost,$paid,$discount,$reference){
  
  $API = new Simple_Calendars($API);
  $SimpleCalendar = new Simple_Calendars($API);
  
  $data = $SimpleCalendar->getConflictsC($startTime,$endTime,$unitID,$reference);
  
  if($data>0){
	  
	  header("location:/");
	  
  }else{
  
	  $SimpleCalendar->progressBooking($startTime,$endTime,$unitID,$firstName,$lastName,$email,$phone,$cost,$paid,$reference);
  
  }
  
}

function simple_calendar_make_booking($startTime,$endTime,$unitID,$firstName,$lastName,$email,$phone,$cost,$paid,$discount,$reference){
  
  $API = new Simple_Calendars($API);
  $SimpleCalendar = new Simple_Calendars($API);
  
  $data = $SimpleCalendar->getConflictsC($startTime,$endTime,$unitID,$reference);
  
  if($data>0){
	  
	  $to = 'office@thehappyhuts.co.uk';
	  $defaultEmail = 'no-reply@thehappyhuts.co.uk';
	
	  $headers = 'From: ' . $defaultEmail . "\r\n" .
	      'X-Mailer: PHP/' . phpversion(); $header .= "\r\n";
	  $headers .= 'MIME-Version: 1.0' . "\r\n";
	  $headers .= 'Cc: jack@jackbarber.co.uk'."\r\n";
	  $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
	  
	  $message = "<p><strong>Conflict - Please Refund</strong></p><ul><li>$firstName $lastName</li><li>$unitID</li><li>$startTime</li><li>$endTime</li><li>$email</li><li>$phone</li><li>$cost</li><li>$paid</li>";
	
	  mail($to, $subject, $message, $headers);
	  
	  $to = $email;
	
	  $headers = 'From: ' . $defaultEmail . "\r\n" .
	      'X-Mailer: PHP/' . phpversion(); $header .= "\r\n";
	  $headers .= 'MIME-Version: 1.0' . "\r\n";
	  $headers .= 'Cc: office@thehappyhuts.co.uk'."\r\n";
	  $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
	  
	  $message = "<p><strong>Booking Problem</strong></p><p>Hi $firstName,</p><p>We're very sorry, but there has been a problem with your booking - we are unable to complete the booking process. We will refund the amount paid as soon as possible. We apologise for the inconvenience.</p><p>The Happy Huts</p>";
	
	  mail($to, $subject, $message, $headers);
	  
  }else{
  
	  $SimpleCalendar->completeBooking($startTime,$endTime,$unitID,$firstName,$lastName,$email,$phone,$cost,$paid,$reference);
	
	  $arrivalDates = explode(" ",$startTime);
	  $arrivalDates = explode("-",$arrivalDates[0]);
	  $arrival = "$arrivalDates[2]/$arrivalDates[1]/$arrivalDates[0]";
	  
	  $arrivalFull = date("l jS \of F Y", mktime(0, 0, 0, $arrivalDates[1], $arrivalDates[2], $arrivalDates[0]));
	
	  $departureDates = explode(" ",$endTime);
	  $departureDates = explode("-",$departureDates[0]);
	  $departure = "$departureDates[2]/$departureDates[1]/$departureDates[0]";
	  
	  $departureFull = date("l jS \of F Y", mktime(0, 0, 0, $departureDates[1], $departureDates[2], $departureDates[0]));
	
	  $arrivalDates = explode(" ",$startTime);
	  $departureDates = explode(" ",$endTime);
	
	  $diff = strtotime($departureDates[0]) - strtotime($arrivalDates[0]);
	  $nights = $diff/86400;
	  
	  $booking = $SimpleCalendar->findBooking($email,$startTime,$endTime,$unitID);
	  $unitData = $SimpleCalendar->unit($unitID,'');
	  $emailData = $SimpleCalendar->getEmail(1);
	  
	  $nights = $nights+1;
	  
	  $bookingValue = $cost;
	  $discount = 0;
	  foreach($_SESSION['voucherCode'] AS $code){
		  $voucher = $SimpleCalendar->getVoucher($code);
		  if($voucher['voucherValue']<=$bookingValue){
			  $remainingBalance = 0;
			  $bookingValue = $bookingValue-$voucher['voucherValue'];
		  }else{
			  $remainingBalance = $voucher['voucherValue']-$bookingValue;
			  $bookingValue = 0;
		  }
		  $discount = $discount+$voucher['voucherValue'];
		  $SimpleCalendar->useVoucher($code,$email,$remainingBalance);
	  }
	
	  $placeHolders = array("{{unitName}}","{{bookingID}}","{{memberName}}","{{bookingArrival}}","{{bookingDeparture}}","{{bookingNights}}","{{bookingCost}}",
	  "{{bookingPaid}}","{{discount}}");
	  $emailContent = array($unitData['name'],"#".$booking['bookingID'],$firstName,$arrivalFull.' 09:30:00',$departureFull.' 23:00:00',$nights,$cost,$paid,$discount);
	
	  $subject = str_replace(
	    $placeHolders,
	    $emailContent,
	    $emailData['subject']
	  );
	
	  $message = nl2br(str_replace(
	    $placeHolders,
	    $emailContent,
	    $emailData['content']
	  ));
	
	  $defaultEmail = 'no-reply@thehappyhuts.co.uk';
	  
	  $to = $email;
	
	  $headers = 'From: ' . $defaultEmail . "\r\n" .
	      'X-Mailer: PHP/' . phpversion(); $header .= "\r\n";
	  $headers .= 'MIME-Version: 1.0' . "\r\n";
	  $headers .= 'Cc: office@thehappyhuts.co.uk'."\r\n";
	  $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
	
	  mail($to, $subject, $message, $headers);
	  
	  unset($_SESSION['voucherCode']);
  
  }
  
}

function simple_calendar_complete_booking($reference,$paid){
  
  $API = new Simple_Calendars($API);
  $SimpleCalendar = new Simple_Calendars($API);
  
  $booking = $SimpleCalendar->getByReference($reference);
  
  $startTime = $booking['startTime'];
  $endTime = $booking['endTime'];
  $unitID = $booking['unitID'];
  $firstName = $booking['firstName'];
  $lastName = $booking['lastName'];
  $email = $booking['emailAddress'];
  $phone = $booking['phone'];
  $cost = $booking['cost'];
  $vouchers = $booking['voucher'];
  
  $data = $SimpleCalendar->getConflictsC($startTime,$endTime,$unitID,$reference);
  
  if($data>0){
	  
	  $to = 'office@thehappyhuts.co.uk';
	  $defaultEmail = 'no-reply@thehappyhuts.co.uk';
	
	  $headers = 'From: ' . $defaultEmail . "\r\n" .
	      'X-Mailer: PHP/' . phpversion(); $header .= "\r\n";
	  $headers .= 'MIME-Version: 1.0' . "\r\n";
	  $headers .= 'Cc: jack@jackbarber.co.uk'."\r\n";
	  $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
	  
	  $message = "<p><strong>Conflict - Please Refund</strong></p><ul><li>$firstName $lastName</li><li>$unitID</li><li>$startTime</li><li>$endTime</li><li>$email</li><li>$phone</li><li>$cost</li><li>$paid</li>";
	
	  mail($to, $subject, $message, $headers);
	  
	  $to = $email;
	
	  $headers = 'From: ' . $defaultEmail . "\r\n" .
	      'X-Mailer: PHP/' . phpversion(); $header .= "\r\n";
	  $headers .= 'MIME-Version: 1.0' . "\r\n";
	  $headers .= 'Cc: office@thehappyhuts.co.uk'."\r\n";
	  $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
	  
	  $message = "<p><strong>Booking Problem</strong></p><p>Hi $firstName,</p><p>We're very sorry, but there has been a problem with your booking - we are unable to complete the booking process. We will refund the amount paid as soon as possible. We apologise for the inconvenience.</p><p>The Happy Huts</p>";
	
	  mail($to, $subject, $message, $headers);
	  
  }else{
  
	  $SimpleCalendar->completeBookingBarclays($reference,$paid);
	
	  $arrivalDates = explode(" ",$startTime);
	  $arrivalDates = explode("-",$arrivalDates[0]);
	  $arrival = "$arrivalDates[2]/$arrivalDates[1]/$arrivalDates[0]";
	  
	  $arrivalFull = date("l jS \of F Y", mktime(0, 0, 0, $arrivalDates[1], $arrivalDates[2], $arrivalDates[0]));
	
	  $departureDates = explode(" ",$endTime);
	  $departureDates = explode("-",$departureDates[0]);
	  $departure = "$departureDates[2]/$departureDates[1]/$departureDates[0]";
	  
	  $departureFull = date("l jS \of F Y", mktime(0, 0, 0, $departureDates[1], $departureDates[2], $departureDates[0]));
	
	  $arrivalDates = explode(" ",$startTime);
	  $departureDates = explode(" ",$endTime);
	
	  $diff = strtotime($departureDates[0]) - strtotime($arrivalDates[0]);
	  $nights = $diff/86400;
	  
	  $booking = $SimpleCalendar->findBooking($email,$startTime,$endTime,$unitID);
	  $unitData = $SimpleCalendar->unit($unitID,'');
	  $emailData = $SimpleCalendar->getEmail(1);
	  
	  $nights = $nights+1;
	  
	  $bookingValue = $cost;
	  $discount = 0;
	  $vouchers = explode(",",$vouchers);

	  foreach($vouchers AS $code){
		  $voucher = $SimpleCalendar->getVoucher($code);
		  if($voucher['voucherValue']<=$bookingValue){
			  $remainingBalance = 0;
			  $bookingValue = $bookingValue-$voucher['voucherValue'];
		  }else{
			  $remainingBalance = $voucher['voucherValue']-$bookingValue;
			  $bookingValue = 0;
		  }
		  $discount = $discount+$voucher['voucherValue'];
		  $SimpleCalendar->useVoucher($code,$email,$remainingBalance);
	  }
	
	  $placeHolders = array("{{unitName}}","{{bookingID}}","{{memberName}}","{{bookingArrival}}","{{bookingDeparture}}","{{bookingNights}}","{{bookingCost}}",
	  "{{bookingPaid}}","{{discount}}");
	  $emailContent = array($unitData['name'],"#".$booking['bookingID'],$firstName,$arrivalFull.' 09:30:00',$departureFull.' 23:00:00',$nights,$cost,number_format($paid,2),number_format($discount,2));
	
	  $subject = str_replace(
	    $placeHolders,
	    $emailContent,
	    $emailData['subject']
	  );
	
	  $message = nl2br(str_replace(
	    $placeHolders,
	    $emailContent,
	    $emailData['content']
	  ));
	
	  $defaultEmail = 'no-reply@thehappyhuts.co.uk';
	  
	  $to = $email;
	
	  $headers = 'From: ' . $defaultEmail . "\r\n" .
	      'X-Mailer: PHP/' . phpversion(); $header .= "\r\n";
	  $headers .= 'MIME-Version: 1.0' . "\r\n";
	  $headers .= 'Cc: office@thehappyhuts.co.uk'."\r\n";
	  $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
	
	  mail($to, $subject, $message, $headers);
	  
	  unset($_SESSION['voucherCode']);
  
  }
  
}

function simple_calendar_complete_booking_webhook($checkoutSession,$paid){
  
  $API = new Simple_Calendars($API);
  $SimpleCalendar = new Simple_Calendars($API);
  
  $booking = $SimpleCalendar->getByCheckoutSession($checkoutSession);
  
  $startTime = $booking['startTime'];
  $endTime = $booking['endTime'];
  $unitID = $booking['unitID'];
  $firstName = $booking['firstName'];
  $lastName = $booking['lastName'];
  $email = $booking['emailAddress'];
  $phone = $booking['phone'];
  $cost = $booking['cost'];
  $vouchers = $booking['voucher'];

  $data = $SimpleCalendar->getConflictsC($startTime,$endTime,$unitID,$booking['reference']);
  
  if($data>0){
	  
	  $to = 'office@thehappyhuts.co.uk';
	  $defaultEmail = 'no-reply@thehappyhuts.co.uk';
	
	  $headers = 'From: ' . $defaultEmail . "\r\n" .
	      'X-Mailer: PHP/' . phpversion(); $header .= "\r\n";
	  $headers .= 'MIME-Version: 1.0' . "\r\n";
	  $headers .= 'Cc: jack@jackbarber.co.uk'."\r\n";
	  $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
	  
	  $message = "<p><strong>Conflict - Please Refund</strong></p><ul><li>$firstName $lastName</li><li>$unitID</li><li>$startTime</li><li>$endTime</li><li>$email</li><li>$phone</li><li>$cost</li><li>$paid</li>";
	
	  mail($to, $subject, $message, $headers);
	  
	  $to = $email;
	
	  $headers = 'From: ' . $defaultEmail . "\r\n" .
	      'X-Mailer: PHP/' . phpversion(); $header .= "\r\n";
	  $headers .= 'MIME-Version: 1.0' . "\r\n";
	  $headers .= 'Cc: office@thehappyhuts.co.uk'."\r\n";
	  $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
	  
	  $message = "<p><strong>Booking Problem</strong></p><p>Hi $firstName,</p><p>We're very sorry, but there has been a problem with your booking - we are unable to complete the booking process. We will refund the amount paid as soon as possible. We apologise for the inconvenience.</p><p>The Happy Huts</p>";
	
	  mail($to, $subject, $message, $headers);
	  
  }else{
  
	  $SimpleCalendar->completeBookingStripeWebhook($checkoutSession,$paid);
	
	  $arrivalDates = explode(" ",$startTime);
	  $arrivalDates = explode("-",$arrivalDates[0]);
	  $arrival = "$arrivalDates[2]/$arrivalDates[1]/$arrivalDates[0]";
	  
	  $arrivalFull = date("l jS \of F Y", mktime(0, 0, 0, $arrivalDates[1], $arrivalDates[2], $arrivalDates[0]));
	
	  $departureDates = explode(" ",$endTime);
	  $departureDates = explode("-",$departureDates[0]);
	  $departure = "$departureDates[2]/$departureDates[1]/$departureDates[0]";
	  
	  $departureFull = date("l jS \of F Y", mktime(0, 0, 0, $departureDates[1], $departureDates[2], $departureDates[0]));
	
	  $arrivalDates = explode(" ",$startTime);
	  $departureDates = explode(" ",$endTime);
	
	  $diff = strtotime($departureDates[0]) - strtotime($arrivalDates[0]);
	  $nights = $diff/86400;
	  
	  $booking = $SimpleCalendar->findBooking($email,$startTime,$endTime,$unitID);
	  $unitData = $SimpleCalendar->unit($unitID,'');
	  $emailData = $SimpleCalendar->getEmail(1);
	  
	  $nights = $nights+1;
	  
	  $bookingValue = $cost;
	  $discount = 0;
	  $vouchers = explode(",",$vouchers);

	  foreach($vouchers AS $code){
		  $voucher = $SimpleCalendar->getVoucher($code);
		  if($voucher['voucherValue']<=$bookingValue){
			  $remainingBalance = 0;
			  $bookingValue = $bookingValue-$voucher['voucherValue'];
		  }else{
			  $remainingBalance = $voucher['voucherValue']-$bookingValue;
			  $bookingValue = 0;
		  }
		  $discount = $discount+$voucher['voucherValue'];
		  $SimpleCalendar->useVoucher($code,$email,$remainingBalance);
	  }
	
	  $placeHolders = array("{{unitName}}","{{bookingID}}","{{memberName}}","{{bookingArrival}}","{{bookingDeparture}}","{{bookingNights}}","{{bookingCost}}",
	  "{{bookingPaid}}","{{discount}}");
	  $emailContent = array($unitData['name'],"#".$booking['bookingID'],$booking['firstName'],$arrivalFull.' 09:30:00',$departureFull.' 23:00:00',$nights,$cost,number_format($paid,2),number_format($discount,2));
	
	  $subject = str_replace(
	    $placeHolders,
	    $emailContent,
	    $emailData['subject']
	  );
	
	  $message = nl2br(str_replace(
	    $placeHolders,
	    $emailContent,
	    $emailData['content']
	  ));
	
	  $defaultEmail = 'no-reply@thehappyhuts.co.uk';
	  
	  $to = $email;
	  
	  $config = Brevo\Client\Configuration::getDefaultConfiguration()->setApiKey('api-key', getenv('BREVO_API_KEY'));

	$apiInstance = new Brevo\Client\Api\TransactionalEmailsApi(
	    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
	    // This is optional, `GuzzleHttp\Client` will be used as default.
	    new GuzzleHttp\Client(),
	    $config
	);
	
	$sendSmtpEmail = new \Brevo\Client\Model\SendSmtpEmail([
		'subject' => $subject,
	    'sender' => ['name' => 'The Happy Huts', 'email' => 'office@thehappyhuts.co.uk'],
	    'replyTo' => ['name' => 'The Happy Huts', 'email' => 'office@thehappyhuts.co.uk'],
	    'to' => [[ 'name' => "$booking[firstName] $booking[lastName]", 'email' => "$email"],[ 'name' => "Happy Huts", 'email' => "office@thehappyhuts.co.uk"]],
	    'htmlContent' => $message
	]);
	
	try {
	    $result = $apiInstance->sendTransacEmail($sendSmtpEmail);
	    print_r($result);
	} catch (Exception $e) {
	    echo 'Exception when calling TransactionalEmailsApi->sendTransacEmail: ', $e->getMessage(), PHP_EOL;
	}
	
	unset($_SESSION['voucherCode']);
  
  }
  
}

function simple_calendar_set_secret($startTime,$endTime,$unitID,$firstName,$lastName,$email,$phone,$cost,$paid,$discount,$reference,$secret){
  
  $API = new Simple_Calendars($API);
  $SimpleCalendar = new Simple_Calendars($API);
  
  $SimpleCalendar->setSecret($reference,$secret);
  
}

function delete_expired_bookings(){
	$API = new Simple_Calendars($API);
  $SimpleCalendar = new Simple_Calendars($API);
  
  $SimpleCalendar->deleteExpiredBookings();
}

function simple_calendar_temp_booking($startTime,$endTime,$unitID,$cost){
  
  $API = new Simple_Calendars($API);
  $SimpleCalendar = new Simple_Calendars($API);
  
  $bookingID = $SimpleCalendar->tempBooking($startTime,$endTime,$unitID,$cost);
  
  return $bookingID;

}

function requestreviews(){
	
	$API = new Simple_Calendars($API);
	$SimpleCalendar = new Simple_Calendars($API);
	
	//GET ALL HOLIDAYS ENDING YESTERDAY
	$yesterday = date("Y-m-d", mktime(0, 0, 0, date('m'), date('d')-1, date('Y')));
	//$yesterday = '2021-01-10';
	$bookings = $SimpleCalendar->getBookingsReviews($yesterday);
	
	//LOOP THROUGH ALL HOLIDAYS AND CREATE RECORD IN REVIEWS TABLE - EMAIL GUEST BASED ON TEMPLATE
	foreach($bookings AS $booking){
		$customer = $booking['customerID'];
		$pos = strpos($booking['notes'], 'owner');
		if ($pos !== false) {
		    
		}else{
		    $unitData = $SimpleCalendar->unit($booking['unitID'],'');
		    $customerData = $SimpleCalendar->customer($customer);
		    $email = $customerData['memberEmail'];
		    //$email = 'jack@jackbarber.co.uk';

		    $json = json_decode($customerData['memberProperties'],true);
		    
		    $characters = '0123456789abcdefghijklmnopqrstuvwxyz'; 
		    $randomString = ''; 
		    $n = 255;
		  
		    for ($i = 0; $i < $n; $i++) { 
		        $index = rand(0, strlen($characters) - 1); 
		        $randomString .= $characters[$index]; 
		    } 
		    
		    $review['reviewCode'] = $randomString;
		    $review['emailAddress'] = $email;
		    $review['unitID'] = $booking['unitID'];
		    
		    $createReview = $SimpleCalendar->createReview($review);
		    
		    $emailData = $SimpleCalendar->getEmail(3);
		    
		    $placeHolders = array("{{unitName}}","{{bookingID}}","{{memberName}}","{{reviewcode}}");
			$emailContent = array($unitData['name'],"#".$booking['bookingID'],$json['first_name'],$randomString);
	
			$subject = str_replace(
			  $placeHolders,
			  $emailContent,
			  $emailData['subject']
			);
			
			$message = str_replace(
			  $placeHolders,
			  $emailContent,
			  $emailData['content']
			);
			
			$message = nl2br($message);
	
/*
		    $headers .= 'Return-Path: info@baytownholidaycottages.co.uk' ."\r\n";
			$headers .= 'From: Baytown Holiday Cottages <info@baytownholidaycottages.co.uk>' . "\r\n";
		    $headers .= 'X-Mailer: PHP/' . phpversion(); 
		    $headers .= "\r\n";
		    $headers .= 'MIME-Version: 1.0' . "\r\n";
		    $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

			mail($email, $subject, $message, $headers, "-f info@baytownholidaycottages.co.uk") or die ("Cannot sent email");
*/
		    	    
		}
	}
	
}

function reviewform($reviewcode){
	
	$API = new Simple_Calendars($API);
	$SimpleCalendar = new Simple_Calendars($API);
	
	$reviewData = $SimpleCalendar->getReviewData($reviewcode);
	$unit = $SimpleCalendar->unit($reviewData['unitID'],'');

	if($reviewData['rating']==NULL){
		echo '<h2>Leave Us a Review</h2>
				<form method="post" class="review">
				<label>Rating</label>
				<p>How would you rate your stay in <strong>'.$unit['name'].'</strong>?</p>
				<select name="rating">
					<option value="5">&#9734;&#9734;&#9734;&#9734;&#9734;</option>
					<option value="4">&#9734;&#9734;&#9734;&#9734;</option>
					<option value="3">&#9734;&#9734;&#9734;</option>
					<option value="2">&#9734;&#9734;</option>
					<option value="1">&#9734;</option>
				</select>
				<label>Comments</label>
				<p>Please tell us a bit about why you enjoyed your visit to Robin Hood&rsquo;s Bay so much.</p>
				<textarea name="comments"></textarea>
				<p>Click below to save your review - once you&rsquo;ve done this it cannot be altered.</p>
				<input type="submit" value="Submit Review" />
				</form>';
	}else{
		echo "<h2>Thanks for submitting your review!</h2>";
	}
	
}

function logreview($review){
	
	$API = new Simple_Calendars($API);
	$SimpleCalendar = new Simple_Calendars($API);
	
	$log = $SimpleCalendar->logReview($review);
	
}

function unitReviews($slug){
	
	$API = new Simple_Calendars($API);
	$SimpleCalendar = new Simple_Calendars($API);
	
	$unit = $SimpleCalendar->unitbySlug($slug,'');
	
	$reviews = $SimpleCalendar->getReviews($unit['unitID']);
	
	if(count($reviews)>0){
		echo '<div class="reviews-block"><h2>Reviews</h2>';
		
		foreach($reviews as $review){
			echo '<div class="review"><p class="rating">';
				if($review['rating']=='5'){
					echo '<i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i>';
				}elseif($review['rating']=='4'){
					echo '<i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i>';
				}elseif($review['rating']=='3'){
					echo '<i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i>';
				}elseif($review['rating']=='2'){
					echo '<i class="fa fa-star"></i><i class="fa fa-star"></i>';
				}elseif($review['rating']=='1'){
					echo '<i class="fa fa-star"></i>';
				}
			echo '</p><p>'.$review['comments'].'</p></div>';
		}
		
		echo '</div>';
	}
	
}

function apply_voucher_code($voucher,$reference){
	$API = new Simple_Calendars($API);
	$SimpleCalendar = new Simple_Calendars($API);
	$SimpleCalendar->applyVoucher($voucher,$reference);
}

function check_voucher_code($code){

	$API = new Simple_Calendars($API);
	$SimpleCalendar = new Simple_Calendars($API);	
	
	$voucherCode = $SimpleCalendar->getVoucher($code);
	return $voucherCode;
}

function smsContent(){
  $API = new Simple_Calendars($API);
  $SimpleCalendar = new Simple_Calendars($API);

  $smsData = $SimpleCalendar->getEmail(4);	
  return $smsData;
}

function smsContentArrival(){
  $API = new Simple_Calendars($API);
  $SimpleCalendar = new Simple_Calendars($API);

  $smsData = $SimpleCalendar->getEmail(5);	
  return $smsData;
}

function todayArrivals(){
	$API = new Simple_Calendars($API);
	$SimpleCalendar = new Simple_Calendars($API);		
	
	$arrivals = $SimpleCalendar->todayArrivals();
	return $arrivals;
	
}

function tomorrowArrivals(){
	$API = new Simple_Calendars($API);
	$SimpleCalendar = new Simple_Calendars($API);		
	
	$arrivals = $SimpleCalendar->tomorrowArrivals();
	return $arrivals;
	
}

function checkBookingExists($first_name,$last_name,$email,$telephone,$arrival,$departure,$unitID,$amount){
	$API = new Simple_Calendars($API);
	$SimpleCalendar = new Simple_Calendars($API);
	
	$SimpleCalendar->checkBookingExists($first_name,$last_name,$email,$telephone,$arrival,$departure,$unitID,$amount);
}

function simple_calendar_store_session_id($reference,$first_name,$last_name,$email_address,$phone,$cost,$session_id,$payment_intent){
	$API = new Simple_Calendars($API);
	$SimpleCalendar = new Simple_Calendars($API);
	
	$SimpleCalendar->storeSession($reference,$first_name,$last_name,$email_address,$phone,$cost,$session_id,$payment_intent);
}