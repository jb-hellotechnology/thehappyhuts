<?php
	unset($_SESSION['voucherCode']);
?>
<?php perch_layout('embed_header_no_image'); ?>
<?php perch_content('Page Content'); ?>
<div class="calendars">
	<div class="monthly-calendar-all"></div>
	<script type="text/javascript">
	$(document).ready(function(){
		$( ".monthly-calendar-all" ).load( '/perch/templates/simple_calendar/monthly-calendar-all.php' );
	});
	</script>
</div>
<?php perch_layout('embed_footer_no_image'); ?>