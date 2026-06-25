<?php
session_start();
$promoCode = strip_tags($_POST['promoCode']);
$reference = strip_tags($_POST['reference']);

$promo = check_promo_code($promoCode);

// Is this code allowed for the hut being booked? ('all'/blank = any hut).
// Reuses the same unit-restriction helper as gift vouchers.
$units       = isset($promo['units']) ? $promo['units'] : 'all';
$unitAllowed = voucher_unit_allowed($units, $reference);

if($promo && $promo['percentage']>0 && $unitAllowed){
	// Promotional codes are reusable, so there's no consumption — we just record
	// the applied code in the session (one promo per booking) and on the booking.
	$_SESSION['promoCode'] = $promoCode;
	apply_promo_code($promoCode, $reference);
	echo 'Promo code applied - '.(float)$promo['percentage'].'% discount';
}elseif($promo && $promo['percentage']>0 && !$unitAllowed){
	echo 'Sorry, this promo code can only be used for selected huts.';
}else{
	echo 'Promo code not valid';
}
?>
