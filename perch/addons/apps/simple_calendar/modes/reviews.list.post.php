<?php
    # Side panel
    echo $HTML->side_panel_start();
    
    echo $HTML->side_panel_end();
    
    echo $HTML->title_panel([
    'heading' => $Lang->get('Reviews'),
    ], $CurrentUser);
    
    # Main panel
    echo $HTML->main_panel_start();
   
    include('_subnav.php');
?>

    <table class="d">
        <thead>
            <tr>
                <th class="first">Review ID</th>  
                <th>Email</th>
                <th>Rating</th>  
				<th>Published?</th>
                <th class="action last">Delete</th>
            </tr>
        </thead>
        <tbody>
<?php
    foreach($reviews as $Review) {
?>
            <tr>
                <td>
	                <a href="<?php echo $HTML->encode($API->app_path()); ?>/reviews/edit?id=<?php echo $Review['reviewID']; ?>"><?php echo $Review['reviewID']; ?></a>
	            </td>
	            <td>
		            <a href="<?php echo $HTML->encode($API->app_path()); ?>/reviews/edit?id=<?php echo $Review['reviewID']; ?>"><?php echo $Review['emailAddress']; ?></a>
	            </td>
	            <td>
	                <?php echo $Review['rating']; ?>
	            </td>
	            <td>
	                <?php echo $Review['published']; ?>
	            </td>
                <td>
	                <a href="<?php echo $HTML->encode($API->app_path()); ?>/reviews/delete?id=<?php echo $HTML->encode(urlencode($Review['reviewID'])); ?>" class="delete inline-delete"><?php echo $Lang->get('Delete'); ?></a>
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