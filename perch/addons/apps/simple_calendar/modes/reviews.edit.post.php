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
        echo $Form->text_field("rating","Rating (5 - 1)",$review['rating']);
        echo $Form->text_field("comments","Comments",$review['comments']);
        $published[] = array('label'=>"Yes", 'value'=>'yes');
		$published[] = array('label'=>"No", 'value'=>'');
	    echo $Form->select_field('published','Published?',$published,$review['published']);
        echo $Form->hidden('reviewID', $_GET['id']);
		echo $Form->submit_field('btnSubmit', 'Update', $API->app_path());
        echo $Form->form_end();
    }
    
    echo $HTML->main_panel_end();

?>