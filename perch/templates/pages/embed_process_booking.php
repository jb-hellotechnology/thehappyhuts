<?php
session_start();

//GET DATA
$firstName = strip_tags($_POST['first_name']);
$lastName = strip_tags($_POST['last_name']);
$phone = strip_tags($_POST['mobile']);
$email = strip_tags($_POST['email']);

$reference = strip_tags($_POST['reference']);

$startTime = $_POST['arrival'].' 09:30:00';
$unitID = $_POST['unitID'];
$cost = $_POST['cost'];
$paid = $cost;
$discount = $_POST['discount'];

$dates = explode("-",$_POST['arrival']);
$nights = $_POST['nights'];
$nights = $nights-1;
$departure = date("Y-m-d", mktime(0, 0, 0, $dates[1], $dates[2]+$nights, $dates[0]));
$endTime = $departure.' 23:00:00';

$data = implode(",",$_POST);

simple_calendar_make_booking($startTime,$endTime,$unitID,$firstName,$lastName,$email,$phone,$cost,$paid,$discount,$reference);

?>