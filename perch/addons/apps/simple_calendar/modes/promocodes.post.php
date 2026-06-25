<?php
    # Side panel
    echo $HTML->side_panel_start();

    echo $HTML->side_panel_end();

    echo $HTML->title_panel([
    'heading' => $Lang->get('Promotional Codes'),
    'button'  => [
            'text' => $Lang->get('Promotional Code'),
            'link' => $API->app_nav().'/promocodes/add',
            'icon' => 'core/plus',
        ],
    ], $CurrentUser);

    # Main panel
    echo $HTML->main_panel_start();

    include('_subnav.php');
?>

    <table class="d">
        <thead>
            <tr>
                <th class="first">Date Created</th>
                <th>Code</th>
                <th>Discount</th>
                <th>Huts</th>
                <th class="action last">Delete</th>
            </tr>
        </thead>
        <tbody>
<?php
    foreach($promos as $Promo) {
?>
            <tr>
                <td>
	                <a href="<?php echo $HTML->encode($API->app_path()); ?>/promocodes/edit/?id=<?php echo $Promo['promoID']; ?>"><?php echo $Promo['createdDate']; ?></a>
	            </td>
	            <td>
	                <a href="<?php echo $HTML->encode($API->app_path()); ?>/promocodes/edit/?id=<?php echo $Promo['promoID']; ?>"><?php echo $HTML->encode($Promo['name']); ?></a>
	            </td>
	            <td>
	                <?php echo (float)$Promo['percentage']; ?>%
	            </td>
	            <td>
<?php
	                $pu = isset($Promo['units']) ? trim($Promo['units']) : 'all';
	                if($pu=='' || strtolower($pu)=='all'){
	                    $puLabel = 'All huts';
	                }else{
	                    $names = array();
	                    foreach(explode(',', $pu) as $id){ $id = trim($id); $names[] = isset($unitNames[$id]) ? $unitNames[$id] : ('#'.$id); }
	                    $puLabel = implode(', ', $names);
	                }
?>
	                <?php echo $HTML->encode($puLabel); ?>
	            </td>
                <td>
	                <a href="<?php echo $HTML->encode($API->app_path()); ?>/promocodes/delete/?id=<?php echo $HTML->encode(urlencode($Promo['promoID'])); ?>" class="delete inline-delete"><?php echo $Lang->get('Delete'); ?></a>
	            </td>
            </tr>
<?php
	}
?>
	    </tbody>
    </table>

<?php

    echo $HTML->main_panel_end();
