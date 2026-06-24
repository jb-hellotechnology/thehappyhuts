<?php
    # Side panel
    echo $HTML->side_panel_start();
    
    echo $HTML->side_panel_end();
    
    echo $HTML->title_panel([
    'heading' => $Lang->get('Accommodation'),
    'button'  => [
            'text' => $Lang->get('Email'),
            'link' => $API->app_nav().'/accommodation/emails/add',
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
	    'active' => true,
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

    <table class="d">
        <thead>
            <tr>
                <th class="first last">Name</th>
            </tr>
        </thead>
        <tbody>
<?php
    foreach($emails as $Email) {
?>
            
            <tr>
                <td>
	                <a href="<?php echo $HTML->encode($API->app_path()); ?>/accommodation/emails/edit/?id=<?php echo $Email['emailID']; ?>"><?php echo $Email['subject']; ?></a>
	            </td>
            </tr>
            
<?php
	}
?>

		</tbody>
    </table>

<?php    

    echo $HTML->main_panel_end();

?>