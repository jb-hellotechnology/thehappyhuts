<?php
	$html = '';
	foreach ($_GET as $key => $value) {
	    $html .= "Field ".htmlspecialchars($key)." is ".htmlspecialchars($value)."<br>";
	}
	//mail('jack@jackbarber.co.uk','test',$html);
	
	$reference = strip_tags($_GET['orderID']);
	$paid = strip_tags($_GET['amount']);
	
	simple_calendar_complete_booking($reference,$paid);

?>