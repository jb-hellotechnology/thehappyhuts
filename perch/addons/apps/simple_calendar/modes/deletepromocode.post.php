<?php
    # Side panel
    echo $HTML->side_panel_start();

    echo $HTML->side_panel_end();

    echo $HTML->title_panel([
    'heading' => $Lang->get('Promotional Codes'),
    ], $CurrentUser);

    # Main panel
    echo $HTML->main_panel_start();

    include('_subnav.php');

    echo $Form->form_start();

    if ($message) {
        echo $message;
    }else{
        echo $HTML->warning_message('Are you sure you wish to delete this promotional code?');
        echo $Form->form_start();
        echo $Form->hidden('promoID', $_GET['id']);
		echo $Form->submit_field('btnSubmit', 'Delete', $API->app_path());
        echo $Form->form_end();
    }

    echo $HTML->main_panel_end();
