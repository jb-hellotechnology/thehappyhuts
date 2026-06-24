<?php
    # Side panel
    echo $HTML->side_panel_start();
    
    echo $HTML->side_panel_end();

	echo $HTML->title_panel([
    'heading' => $Lang->get('Accommodation'),
    'button'  => [
            'text' => $Lang->get('Unit Pricing'),
            'link' => $API->app_nav().'/accommodation/units/unitpricing?id='.$id,
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

	    if (PerchUtil::count($unitPricing)) {

			echo $HTML->heading3('Edit Unit Pricing');
		
			echo $Form->form_start();
			
			echo $Form->date_field("startDate","Start Date",$unitPricing['startDate']);
			echo $Form->date_field("endDate","End Date",$unitPricing['endDate']);
/*
			echo $Form->text_field("freeText","Free Text",$unitPricing['freeText']);
			
			$staylist[] = array('label'=>"1", 'value'=>'1');
			$staylist[] = array('label'=>"2", 'value'=>'2');
			$staylist[] = array('label'=>"3", 'value'=>'3');
			$staylist[] = array('label'=>"4", 'value'=>'4');
			$staylist[] = array('label'=>"5", 'value'=>'5');
			$staylist[] = array('label'=>"6", 'value'=>'6');
			$staylist[] = array('label'=>"7", 'value'=>'7');
		    echo $Form->select_field('minStay','Min. Stay',$staylist,$unitPricing['minStay']);
		    
		    $changelist[] = array('label'=>"Sat - Sat", 'value'=>'Sat - Sat');
		    $changelist[] = array('label'=>"Fri - Fri", 'value'=>'Fri - Fri');
		    $changelist[] = array('label'=>"Fri/Mon", 'value'=>'Fri/Mon');
		    $changelist[] = array('label'=>"Any Day", 'value'=>'Any Day');
		    echo $Form->select_field('changeOver','Changeover',$changelist,$unitPricing['changeOver']);
        
        $strictlist[] = array('label'=>"No", 'value'=>'');
			  $strictlist[] = array('label'=>"Yes", 'value'=>'on');
        echo $Form->select_field('strict','Strict Changeover',$strictlist,$unitPricing['strict']);
*/
		    
		    echo $Form->text_field("onenight","Weekday Price",$unitPricing['onenight']);
		    echo $Form->text_field("twonights","Weekend Price",$unitPricing['twonights']);
/*
		    echo $Form->text_field("threenights","3 Night",$unitPricing['threenights']);
		    echo $Form->text_field("fournights","4 Night",$unitPricing['fournights']);
		    echo $Form->text_field("fivenights","5 Night",$unitPricing['fivenights']);
		    echo $Form->text_field("sixnights","6 Night",$unitPricing['sixnights']);
		    echo $Form->text_field("sevennights","7 Night",$unitPricing['sevennights']);
		    
		    $discountlist[] = array('label'=>"No", 'value'=>'');
			$discountlist[] = array('label'=>"Yes", 'value'=>'on');
			echo $Form->select_field('discount','Enable Min Group Size Discount',$discountlist,$unitPricing['discount']);
*/
			    
			echo $Form->submit_field('btnSubmit', 'Update Unit Pricing', $API->app_path());

      echo $Form->hidden('pricingID', $_GET['id']);
			
			echo $Form->form_end();
		
		}

	}
	
    
    echo $HTML->main_panel_end();
