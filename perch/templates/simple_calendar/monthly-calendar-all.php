<?php if (!defined('PERCH_RUNWAY')) include($_SERVER['DOCUMENT_ROOT'].'/perch/runtime.php'); ?>
<?php
	$unit = strip_tags($_GET['unit']);
	$year = strip_tags($_GET['year']);
	$month = strip_tags($_GET['month']);

  $data = perch_collection('Huts', [
      'skip-template'=>true,
      'paginate'=>false,
      'count'=>200
    ]);
    
    delete_expired_bookings();

  echo "<div class=\"all-calendars\">";

  foreach($data as $Hut){
	
    if($Hut['hide']<>'true'){
      echo "<div class=\"monthly-calendar\">";
  	  simple_calendar_monthly_calendar_all($Hut['slug'],$year,$month);
      echo "</div>";
    }
    
  }
		
  echo "</div>";

echo "<div class=\"monthly-calendar\">
        <table class='key'>
          <tr><td colspan='6'>Key</td></tr>
          <tr><td class='un'>1</td><td>Booked</td><td class='ar'>1</td><td>Available</td></tr>
        </table>
       </div>";

?>