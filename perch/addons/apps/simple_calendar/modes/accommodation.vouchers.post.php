<?php
    # Side panel
    echo $HTML->side_panel_start();
    
    echo $HTML->side_panel_end();
    
    echo $HTML->title_panel([
    'heading' => $Lang->get('Gift Vouchers'),
    'button'  => [
            'text' => $Lang->get('Gift Voucher'),
            'link' => $API->app_nav().'/giftvouchers/add',
            'icon' => 'core/plus',
        ],
    ], $CurrentUser);

/*
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
*/
    
    # Main panel
    echo $HTML->main_panel_start();
   
    include('_subnav.php');
?>

    <table class="d">
        <thead>
            <tr>
                <th class="first">Date Created</th>
                <th>Voucher Code</th> 
                <th>Voucher Value</th>
                <th>Huts</th>
                <th>Used Date</th>
                <th>Used By</th> 
                <th class="action last">Delete</th>
            </tr>
        </thead>
        <tbody>
<?php
    foreach($vouchers as $Voucher) {
?>
            <tr>
                <td>
	                <a href="<?php echo $HTML->encode($API->app_path()); ?>/giftvouchers/edit/?id=<?php echo $Voucher['voucherID']; ?>"><?php echo $Voucher['createdDate']; ?></a>
	            </td>
	            <td>
	                <a href="<?php echo $HTML->encode($API->app_path()); ?>/giftvouchers/edit/?id=<?php echo $Voucher['voucherID']; ?>"><?php echo $Voucher['voucherCode']; ?></a>
	            </td>
	            <td>
	                <?php echo $Voucher['voucherValue']; ?>
	            </td>
	            <td>
<?php
	                $vu = isset($Voucher['units']) ? trim($Voucher['units']) : 'all';
	                if($vu=='' || strtolower($vu)=='all'){
	                    $vuLabel = 'All huts';
	                }else{
	                    $names = array();
	                    foreach(explode(',', $vu) as $id){ $id = trim($id); $names[] = isset($unitNames[$id]) ? $unitNames[$id] : ('#'.$id); }
	                    $vuLabel = implode(', ', $names);
	                }
?>
	                <?php echo $HTML->encode($vuLabel); ?>
	            </td>
	            <td>
	                <?php echo $Voucher['usedDate']; ?>
	            </td>
	            <td>
	                <?php echo $Voucher['usedBy']; ?>
	            </td>
                <td>
	                <a href="<?php echo $HTML->encode($API->app_path()); ?>/giftvouchers/delete/?id=<?php echo $HTML->encode(urlencode($Voucher['voucherID'])); ?>" class="delete inline-delete"><?php echo $Lang->get('Delete'); ?></a>
	            </td>
            </tr>
<?php
	}
?>
	    </tbody>
    </table>

<?php    

    echo $HTML->main_panel_end();
