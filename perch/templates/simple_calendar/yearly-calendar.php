<?php if (!defined('PERCH_RUNWAY')) include($_SERVER['DOCUMENT_ROOT'].'/perch/runtime.php'); ?>
<?php
	
	$unit = strip_tags($_GET['unit']);
	$year = strip_tags($_GET['year']);
	
	simple_calendar_yearly_calendar($unit,$year);	
		
?>