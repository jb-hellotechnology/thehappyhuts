 <?php
    # Side panel
    echo $HTML->side_panel_start();
    
    echo $HTML->side_panel_end();
    
    echo $HTML->title_panel([
    'heading' => $Lang->get('Accommodation'),
    'button'  => [
            'text' => $Lang->get('Booking'),
            'link' => $API->app_nav().'/accommodation/booking',
            'icon' => 'core/plus',
        ],
    ], $CurrentUser);

    $Smartbar = new PerchSmartbar($CurrentUser, $HTML, $Lang);

	$Smartbar->add_item([
	    'active' => true,
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

?>
	
	<div id='calendar'></div>
	<script>
	$(document).ready(function() {
	
		var todayDate = moment().startOf('day');
		var YESTERDAY = todayDate.clone().subtract(1, 'day').format('YYYY-MM-DD');
		var TODAY = todayDate.format('YYYY-MM-DD');
		var TOMORROW = todayDate.clone().add(1, 'day').format('YYYY-MM-DD');
	
    if($(window).width()>767){
      var resourceW = 230;
    }else{
      resourceW = 100;
    }
    
		$('#calendar').fullCalendar({
			schedulerLicenseKey: 'CC-Attribution-NonCommercial-NoDerivatives',
			resourceAreaWidth: resourceW,
			editable: true,
			slotDuration: "24:00",
			scrollTime: '<?php echo date('Y-m-d'); ?>',
			header: {
				left: 'today prev,next',
				center: 'title',
				right: 'timelineMonth'
			},
			defaultView: 'timelineMonth',
			resourceLabelText: 'Accommodation',
			resources: [
				<?php
					$rows = $SimpleCalendar->getAccUnit(0);
					foreach($rows as $row){
						$name = str_replace("'","",$row['name']);
						echo "{ id: '$row[unitID]', title: '$name'},";
					}
				?>	
			],
			events: [
				<?php
					$bookings = $SimpleCalendar->getBookings();
					foreach($bookings as $Booking){
						$rows2 = $SimpleCalendar->getAccSingleUnit($Booking['unitID']);
						$customer = $SimpleCalendar->customer($Booking['customerID']);
						$customer = json_decode($customer['memberProperties']);
						$addons = $SimpleCalendar->getAddons();
						$addonsArray = json_decode($Booking['addons'],true);
						foreach($addons as $Addon){
							$addoncost = $addoncost+($addonsArray['addon_'.$Addon['addonID'].'_price']*$addonsArray['addon_'.$Addon['addonID']]);
					    }
						$balance = number_format(($Booking['cost']+$addoncost)-$Booking['paid'],2);
						
						if($balance == '0.00'){
							$color = 'green';
						}elseif($balance < ($Booking['cost']+$addoncost)){
							$color = 'orange';
						}else{
							$color = 'red';
						}
						
						if($Booking['owner']=='Yes'){
							$color = 'blue';
						}
						
						
							echo "{ id: '$Booking[bookingID]', resourceId: '$Booking[unitID]', start: \"$Booking[startTime]\", end: \"$Booking[endTime]\", title: '".addslashes($Booking['firstName'])." ".addslashes($Booking['lastName'])." • Balance: £$balance', url: \"booking/edit/?id=$Booking[bookingID]\", color: '$color' },\n";

						
						
						$addoncost = 0;
					}
				?>
			]
		});
	
	});
	
	// readjust sizing after font load
	$(window).ready(function() {
		$('#calendar').fullCalendar('render');
	});
	</script>
  <style>
    @media (max-width: 767px) {
      #calendar{
        position:relative;
        z-index:0;
      }
      #calendar table {
        border: 0; }
      #calendar table thead {
        display: table-header-group; }
      #calendar table tr {
        border-bottom: none;
        display: table-row;
        margin-bottom: 0px; }
      #calendar table td {
        border-bottom: none;
        display: table-cell;
        text-align: left; }
      #calendar table td:before {
        content: auto;
        float: none;
        font-weight: normal;
        text-transform: none; }
      #calendar table td:last-child {
        border-bottom: 0; } }
  </style>
<?php

    echo $HTML->main_panel_end();
