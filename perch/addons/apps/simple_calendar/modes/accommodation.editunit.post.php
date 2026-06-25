<?php
    # Side panel
    echo $HTML->side_panel_start();
    
    echo $HTML->side_panel_end();

	echo $HTML->title_panel([
    'heading' => $Lang->get('Accommodation'),
    'button'  => [
            'text' => $Lang->get('Unit Pricing'),
            'link' => $API->app_nav().'/accommodation/units/pricing?id='.$id,
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

    if (isset($message)) echo $message;

    if (PerchUtil::count($unit)) {
	    
	    echo $HTML->heading3('Unit Pricing');
	    
?>

	<table class="d">
        <thead>
            <tr>
                <th class="first">Start Date</th>  
                <th>End Date</th>
<!--                 <th>Free Text</th> -->
<!--
                <th>Min. Stay</th>
                <th>Changeover</th>
-->
                <th>Weekday Price</th> 
                <th>Weekend Price</th> 
<!--
                <th>3 Nights</th> 
                <th>4 Nights</th> 
                <th>5 Nights</th> 
                <th>6 Nights</th>  
                <th>7 Nights</th>
-->
<!--                 <th>Min Group Discount</th> -->
                <th class="action last">Delete</th>
            </tr>
        </thead>
        <tbody>
	        
<?php
	
	$unitPricing = $SimpleCalendar->getunitPricing($id);
	foreach($unitPricing as $price){

		$sDates = explode("-",$price['startDate']);
		$start = "$sDates[2]/$sDates[1]/$sDates[0]";
		
		$eDates = explode("-",$price['endDate']);
		$end = "$eDates[2]/$eDates[1]/$eDates[0]";

		echo "<tr>
				<td><a href=\"";
				echo $HTML->encode($API->app_path());
				echo "/accommodation/units/pricing/edit/?id=";
				echo $HTML->encode(urlencode($price['pricingID']));
				echo "&unit=";
				echo $HTML->encode(urlencode($_GET['id']));
				echo "\">$start</a></td>
				<td>$end</td>
<!--
				<td>$price[freeText]</td>
				<td>$price[minStay]</td>
				<td>$price[changeOver]";
    
    if($price['strict']=='on'){
      echo " (strict)";
    }
    
    echo "</td>
-->
				<td>$price[onenight]</td>
				<td>$price[twonights]</td>
<!--
				<td>$price[threenights]</td>
				<td>$price[fournights]</td>
				<td>$price[fivenights]</td>
				<td>$price[sixnights]</td>
				<td>$price[sevennights]</td>
				<td>$price[discount]</td>
-->
				<td><a href=\"";
				echo $HTML->encode($API->app_path());
				echo "/accommodation/units/pricing/delete/?id=";
				echo $HTML->encode(urlencode($price['pricingID']));
				echo "\" class=\"delete inline-delete\">Delete</a></td>
			</tr>";
		
	}
	
?>

        </tbody>
	</table>
	
<?php
	    
	    echo $HTML->heading3('Unit Details');
	
		echo $Form->form_start();
		
		echo $Form->text_field("name","Name",$unit['name']);
		
		echo $Form->text_field("slug","Slug",$unit['slug']);
		
		echo $Form->text_field("enableCalendar","Enable Calendar (yes/no)",$unit['enableCalendar']);
		
		echo $Form->text_field("dogFriendly","Dog Friendly? (i.e. 'Dog Friendly' or 'No Dogs')",$unit['dogFriendly']);
   
/*
      echo $Form->text_field("maxOccupants","Max Occupants",$unit['maxOccupants']);

	    
		$plusOne[] = array('label'=>"Yes", 'value'=>'yes');
		$plusOne[] = array('label'=>"No", 'value'=>'no');
    
    echo $Form->select_field('plusOne','Allow +1 Bookings',$plusOne,$unit['plusOne']);
    
    echo $Form->text_field("minDiscount","Discount For Minimum Group Size - How Many People?",$unit['minDiscount']);
    echo $Form->text_field("discountPercentage","Minimum Group Size Discount Percentage",$unit['discountPercentage']);
    
    echo $Form->text_field("maxPets","Max Pets",$unit['maxPets']);
*/
		    
		echo $Form->submit_field('btnSubmit', 'Update Unit', $API->app_path());
		
		echo $Form->hidden('unitID', $_GET['id']);
		
		echo $Form->form_end();

	}
    
    echo $HTML->main_panel_end();
