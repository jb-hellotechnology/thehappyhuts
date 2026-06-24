<?php
session_start();
$voucherCode = strip_tags($_POST['voucherCode']);
$reference   = strip_tags($_POST['reference']);
$codes = '';

$voucherCodeCheck = check_voucher_code($voucherCode);

// Is this voucher allowed for the hut being booked? ('all'/blank = any hut)
$voucherUnits = isset($voucherCodeCheck['units']) ? $voucherCodeCheck['units'] : 'all';
$unitAllowed  = voucher_unit_allowed($voucherUnits, $reference);

if($voucherCodeCheck['usedDate']=='0000-00-00 00:00:00' AND $voucherCodeCheck['voucherValue']>0 AND $unitAllowed){
	if(!isset($_SESSION['voucherCode'])){
		$_SESSION['voucherCode'] = array();
		$_SESSION['voucherCode'][0] = $voucherCode;
	}else{
		$match = false;
		foreach($_SESSION['voucherCode'] AS $code){
			if($code==$voucherCode){
				$match = true;
			}
		}
		if(!$match){
			array_push($_SESSION['voucherCode'], $voucherCode);
		}
	}
	apply_voucher_code($_SESSION['voucherCode'],$reference);
	echo 'Voucher applied';
}elseif($voucherCodeCheck['usedDate']=='0000-00-00 00:00:00' AND $voucherCodeCheck['voucherValue']>0 AND !$unitAllowed){
	echo 'Sorry, this voucher can only be used for selected huts.';
}else{
	echo 'Voucher not valid';
}
?>
