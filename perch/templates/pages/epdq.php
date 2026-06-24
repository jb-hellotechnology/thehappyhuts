<?php
/*
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
*/

$firstName = strip_tags($_POST['first_name']);
$lastName = strip_tags($_POST['last_name']);
$phone = strip_tags($_POST['mobile']);
$email = strip_tags($_POST['email']);

$reference = strip_tags($_POST['ORDERID']);

$startTime = $_POST['arrival'].' 09:30:00';
$unitID = $_POST['unitID'];
$cost = $_POST['cost']/100;
$paid = $cost;
$discount = $_POST['discount'];

$dates = explode("-",$_POST['arrival']);
$nights = $_POST['nights'];
$nights = $nights-1;
$departure = date("Y-m-d", mktime(0, 0, 0, $dates[1], $dates[2]+$nights, $dates[0]));
$endTime = $departure.' 23:00:00';

simple_calendar_progress_booking($startTime,$endTime,$unitID,$firstName,$lastName,$email,$phone,$cost,$paid,$discount,$reference);

$string = 'ACCEPTURL=https://thehappyhuts.co.uk/book/completebesidetheseaside22!AMOUNT='.$_POST['AMOUNT'].'besidetheseaside22!BGCOLOR=#ffffffbesidetheseaside22!BUTTONBGCOLOR=#4e9dc6besidetheseaside22!BUTTONTXTCOLOR=#ffffffbesidetheseaside22!CANCELURL=https://thehappyhuts.co.ukbesidetheseaside22!CN=Jack Barberbesidetheseaside22!CURRENCY=GBPbesidetheseaside22!DECLINEURL=https://thehappyhuts.co.ukbesidetheseaside22!EMAIL=jack@jackbarber.co.ukbesidetheseaside22!EXCEPTIONURL=https://thehappyhuts.co.ukbesidetheseaside22!LANGUAGE=en_USbesidetheseaside22!LOGO=logo.pngbesidetheseaside22!ORDERID='.$_POST['ORDERID'].'besidetheseaside22!PSPID=epdq1604592besidetheseaside22!RTIMEOUT=30besidetheseaside22!TBLBGCOLOR=#ffffffbesidetheseaside22!TBLTXTCOLOR=#4e9dc6besidetheseaside22!TITLE=The Happy Hutsbesidetheseaside22!TXTCOLOR=#4e9dc6besidetheseaside22!';

$hash = sha1($string);

unset($_SESSION['voucherCode']);
?>

<form method="post" action="https://mdepayments.epdq.co.uk/ncol/test/orderstandard_utf8.asp" id="barclaycard" name="form1" style="display:none;">

<!-- general parameters: see Form parameters -->

<input type="hidden" name="PSPID" value="epdq1604592">

<input type="hidden" name="ORDERID" value="<?php echo $_POST['ORDERID']; ?>">

<input type="hidden" name="AMOUNT" value="<?php echo $_POST['AMOUNT']; ?>" id="">

<input type="hidden" name="CURRENCY" value="GBP">

<input type="hidden" name="LANGUAGE" value="en_US">

<input type="hidden" name="CN" value="<?php echo $_POST['CN']; ?>" />

<input type="hidden" name="EMAIL" value="<?php echo $_POST['EMAIL']; ?>" />

<input type="hidden" name="OWNERZIP" value="">

<input type="hidden" name="OWNERADDRESS" value="">

<input type="hidden" name="OWNERCTY" value="">

<input type="hidden" name="OWNERTOWN" value="">

<input type="hidden" name="OWNERTELNO" value="">

<input type="hidden" name="RTIMEOUT" value="30">



<!-- check before the payment: see Security: Check before the payment -->

<input type="hidden" name="SHASIGN" value="<?php echo $hash; ?>">

<!-- layout information: see Look and feel of the payment page -->

<input type="hidden" name="TITLE" value="The Happy Huts">

<input type="hidden" name="BGCOLOR" value="#ffffff">

<input type="hidden" name="TXTCOLOR" value="#4e9dc6">

<input type="hidden" name="TBLBGCOLOR" value="#ffffff">

<input type="hidden" name="TBLTXTCOLOR" value="#4e9dc6">

<input type="hidden" name="BUTTONBGCOLOR" value="#4e9dc6">

<input type="hidden" name="BUTTONTXTCOLOR" value="#ffffff">

<input type="hidden" name="LOGO" value="logo.png">

<input type="hidden" name="FONTTYPE" value="">



<!-- post payment redirection: see Transaction feedback to the customer -->

<input type="hidden" name="ACCEPTURL" value="https://thehappyhuts.co.uk/book/complete">

<input type="hidden" name="DECLINEURL" value="https://thehappyhuts.co.uk">

<input type="hidden" name="EXCEPTIONURL" value="https://thehappyhuts.co.uk">

<input type="hidden" name="CANCELURL" value="https://thehappyhuts.co.uk">

<input type="submit" value="Proceed to Payment" id="submit2" name="submit2">

</form>

<script>
	document.getElementById("barclaycard").submit(); 
</script>