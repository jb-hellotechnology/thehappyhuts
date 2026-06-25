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

    if (isset($message)) echo $message;

    echo $HTML->heading3('Update Promotional Code');

	echo $Form->form_start();

	echo $Form->text_field("name","Code (letters and numbers only, e.g. WELCOME10)",$promo['name']);

	echo $Form->text_field("percentage","Percentage Off (number only, e.g. 10)",$promo['percentage']);

	// Unit restriction: none ticked = valid for all huts
	echo '<div style="margin:1rem 0;">';
	echo '<label class="label" style="display:block;font-weight:bold;margin-bottom:.25rem;">Restrict to Specific Huts</label>';
	echo '<p style="margin:.25rem 0 .75rem;">Leave all unticked to allow this code on <strong>any</strong> hut, or tick one or more huts to limit it to those only.</p>';
	foreach($units as $unit){
		$checked = in_array((string)$unit['unitID'], $selectedUnits) ? ' checked="checked"' : '';
		echo '<label style="display:block;margin:.3rem 0;font-weight:normal;"><input type="checkbox" name="units[]" value="'.(int)$unit['unitID'].'"'.$checked.' /> '.$HTML->encode($unit['name']).'</label>';
	}
	echo '</div>';

	echo $Form->submit_field('btnSubmit', 'Update Promotional Code', $API->app_path());

	echo $Form->hidden('promoID', $_GET['id']);

	echo $Form->form_end();

    echo $HTML->main_panel_end();
