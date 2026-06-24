<?php
    # Side panel
    echo $HTML->side_panel_start();
    
    echo $HTML->side_panel_end();
    
    echo $HTML->title_panel([
    'heading' => $Lang->get('Accommodation'),
    'button'  => [
            'text' => $Lang->get('Unit'),
            'link' => $API->app_nav().'/accommodation/units/add',
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
?>

    <table class="d">
        <thead>
            <tr>
                <th class="first">Name</th>  
                <th>Slug</th>  
                <th class="action last"></th>
            </tr>
        </thead>
        <tbody>
<?php
    foreach($units as $Unit) {
?>
            <tr>
                <td>
	                <a href="<?php echo $HTML->encode($API->app_path()); ?>/accommodation/units/edit?id=<?php echo $Unit['unitID']; ?>"><?php echo $Unit['name']; ?></a>
	            </td>
	            <td>
	                <?php echo $Unit['slug']; ?>
	            </td>
                <td>
	                <a href="<?php echo $HTML->encode($API->app_path()); ?>/accommodation/units/delete?id=<?php echo $HTML->encode(urlencode($Unit['unitID'])); ?>" class="delete inline-delete"><?php echo $Lang->get('Delete'); ?></a>
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