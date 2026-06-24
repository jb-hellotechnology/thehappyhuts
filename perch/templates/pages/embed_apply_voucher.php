<?php
session_start();
$voucherCode = strip_tags($_POST['voucherCode']);
$codes = '';

$voucherCodeCheck = check_voucher_code($voucherCode);

if($voucherCodeCheck['usedDate']=='0000-00-00 00:00:00' AND $voucherCodeCheck['voucherValue']>0){
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
	apply_voucher_code($_SESSION['voucherCode'],$_POST['reference']);
	echo 'Voucher applied';
}else{
	echo 'Voucher not valid';
}
?>