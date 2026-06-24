 <?php
    # Side panel
    echo $HTML->side_panel_start();
    
    echo $HTML->side_panel_end();
    
    echo $HTML->title_panel([
    'heading' => 'Bookings',
    ], $CurrentUser);
    
    # Main panel
    echo $HTML->main_panel_start();
   
    include('_subnav.php');
   
?>

	    <table class="d">
        <thead>
            <tr>
                <th class="first">Name</th>
                <th>Email</th>  
                <th>Arrival Time</th>
                <th>Departure Time</th> 
                <th>Hut</th>
                <th class="action last">Edit</th>
            </tr>
        </thead>
        <tbody>
<?php
    foreach($bookings as $Booking) {
?>
            <tr>
                <td>
	                <?php echo $Booking['firstName'].' '.$Booking['lastName']; ?>
	            </td>
	            <td>
	                <?php echo $Booking['emailAddress']; ?>
	            </td>
	            <td>
	                <?php echo $Booking['startTime']; ?>
	            </td>
	            <td>
	                <?php echo $Booking['endTime']; ?>
	            </td>
	            <td>
	                <?php $unit = $SimpleCalendar->unit($Booking['unitID'],$object); echo $unit['name']; ?>
	            </td>
                <td>
	                <a href="<?php echo $HTML->encode($API->app_path()); ?>/accommodation/booking/edit/?id=<?php echo $HTML->encode(urlencode($Booking['bookingID'])); ?>"><?php echo $Lang->get('View'); ?></a>
	            </td>
            </tr>
<?php
	}
?>
	    </tbody>
    </table>
<?php
    echo $HTML->main_panel_end();
