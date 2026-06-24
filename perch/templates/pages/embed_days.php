<?php perch_layout('embed_header'); ?>
<?php perch_content('Page Content'); ?>
<div class="text booking">
	<div class="restrict">
		<h2>Make Your Booking</h2>
        <p>
          Please complete the form below to make your booking.
        </p>
        <form method="post" action="/embed/book/checkout/<?php echo $_POST['unit']; ?>">
 		<?php
        
          //Get Data Required for Booking
          $unit = $_POST['unit'];
          $arrivalDate = $_POST['arrivalDate'];
          $unitData = getUnitBySlug($unit);
          $maxNights = getMaxNights($unit,$arrivalDate);
          
          if($maxNights==0){
	          
	          echo '<h2>Sorry, this date is no longer available</h2><p><a href="/embed/book">Click here to choose a different date</a></p>';
	          
          }else{
  
          $item = perch_collection('Huts', [
             'match' => 'eq',
             'filter' => 'slug',
             'value' => $unit,
             'count' => 1,
             'skip-template' => true,
          ]);
          
          $aD = explode("-",$arrivalDate);
          $arrivalDateH = "$aD[2]/$aD[1]/$aD[0]";
          
          echo "<input type=\"hidden\" name=\"unit\" value=\"$unit\" />";
          echo "<input type=\"hidden\" name=\"unitID\" value=\"$unitData[unitID]\" />";
          echo "<input type=\"hidden\" name=\"arrivalDate\" value=\"$arrivalDate\" />";

          PerchSystem::set_var('arrival', $arrivalDateH);
          perch_collection('Huts', [
			    "filter"   => "slug",
		        "match"    => "eq",
		        "value"    => perch_get('s'),
		        "template" => 'mini.html'
		    ]); 
          
          echo "<div class=\"form_section\" id=\"stay\">";
          echo "<h3>Your Booking</h3>";
          echo "<p><strong>Arrival Date:</strong> $arrivalDateH</p>";
          echo "<p>The maximum length of booking for your chosen arrival date is <strong>$maxNights days</strong> - please choose how many days you wish to stay.</p>";
          echo "<div class='form-input'>";
          echo "<label>Length of Stay</label>";
          echo "<select name=\"nights\" id=\"nights\">";
            $i = 1;
            $depDay = date("D", mktime(0, 0, 0, $aD[1], $aD[2]+$minNights, $aD[0]));
            while($i<=$maxNights){
              
              $add = $i;
              $date = date("m-d", mktime(0, 0, 0, $aD[1], $aD[2]+$add, $aD[0]));
              
              $thisDate = date("Y-m-d", mktime(0, 0, 0, $aD[1], $aD[2]+$add, $aD[0]));
              $unitPricing = getPricing($_POST['unit'],$thisDate);
              
              $depDate = date("l jS F Y", mktime(0, 0, 0, $aD[1], $aD[2]+$add, $aD[0]));
                
                echo "<option value=\"$i\">$i Day(s)</option>";  
                
              
              $i++;
              
            }
          echo "</select>";
          echo "<div class='form-input'>";
          echo "<label>Proceed</label>";
          echo "<p>Click below to secure your requested dates. They will be removed from the availability calendar and you will have 3 and a half minutes to complete your booking.</p>";
          echo "<input type='submit' value='Continue with Booking' />";
          echo "</div>";
          echo "</div>";
          echo "</div>";    
          }
        ?>
        </form>
        

	</div>
</div>
<?php perch_layout('embed_footer'); ?>