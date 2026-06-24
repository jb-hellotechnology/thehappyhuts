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
    
    if ($message) {
        echo $message;
    }else{
	    echo $Form->form_start();
        echo $HTML->warning_message('Are you sure you wish to delete this review?');
        echo $Form->form_start();
        echo $Form->hidden('reviewID', $_GET['id']);
		echo $Form->submit_field('btnSubmit', 'Delete', $API->app_path());
        echo $Form->form_end();
    }
    
    echo $HTML->main_panel_end();

?>