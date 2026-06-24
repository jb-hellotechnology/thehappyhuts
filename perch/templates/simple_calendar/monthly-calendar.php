<?php if (!defined('PERCH_RUNWAY')) include($_SERVER['DOCUMENT_ROOT'].'/perch/runtime.php'); ?>
<?php
	
	$unit = strip_tags($_GET['unit']);
	$year = strip_tags($_GET['year']);
	$month = strip_tags($_GET['month']);
	
	simple_calendar_monthly_calendar($unit,$year,$month);
		
?>