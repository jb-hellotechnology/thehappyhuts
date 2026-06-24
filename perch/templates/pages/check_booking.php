<?php

session_start();

$startTime = $_POST['arrival'].' 09:30:00';
$unitID = $_POST['unitID'];

$arrival = $_POST['arrival'].' 09:30:00';

$dates = explode("-",$_POST['arrival']);
$nights = $_POST['nights'];
$nights = $nights-1;
$departure = date("Y-m-d", mktime(0, 0, 0, $dates[1], $dates[2]+$nights, $dates[0]));
$endTime = $departure.' 23:00:00';

$data = conflictsC($unitID,$arrival,$departure,$_POST['reference']);
echo $data;

?>