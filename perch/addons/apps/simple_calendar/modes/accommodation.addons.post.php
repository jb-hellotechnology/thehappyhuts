<?php
    # Side panel
    echo $HTML->side_panel_start();
    
    echo $HTML->side_panel_end();
    
    echo $HTML->title_panel([
    'heading' => $Lang->get('Accommodation'),
    'button'  => [
            'text' => $Lang->get('Add-on'),
            'link' => $API->app_nav().'/accommodation/addons/add',
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
	    'active' => false,
	    'title' => 'Emails',
	    'link'  => '/addons/apps/simple_calendar/accommodation/emails',
	]);
	
	$Smartbar->add_item([
	    'active' => true,
	    'title' => 'Add-Ons',
	    'link'  => '/addons/apps/simple_calendar/accommodation/addons',
	]);
	
	
	echo $Smartbar->render();
    
    # Main panel
    echo $HTML->main_panel_start();
   
    include('_subnav.php');
?>

    <table class="d">
        <thead>
            <tr>
                <th class="first">Name</th>
                <th>Description</th> 
                <th>Price</th>  
                <th class="action last">Delete</th>
            </tr>
        </thead>
        <tbody>
<?php
    foreach($addons as $Addon) {
?>
            <tr>
                <td>
	                <a href="<?php echo $HTML->encode($API->app_path()); ?>/accommodation/addons/edit/?id=<?php echo $Addon['addonID']; ?>"><?php echo $Addon['name']; ?></a>
	            </td>
	            <td>
	                <?php echo $Addon['description']; ?>
	            </td>
	            <td>
	                <?php echo $Addon['price']; ?>
	            </td>
                <td>
	                <a href="<?php echo $HTML->encode($API->app_path()); ?>/accommodation/addons/delete/?id=<?php echo $HTML->encode(urlencode($Addon['addonID'])); ?>" class="delete inline-delete"><?php echo $Lang->get('Delete'); ?></a>
	            </td>
            </tr>
<?php
	}
?>
	    </tbody>
    </table>

<?php    

    echo $HTML->main_panel_end();
