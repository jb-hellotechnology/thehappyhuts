<?php 
	
	session_start();
	
	$unit = $_POST['unit'];
	$arrivalDate = $_POST['arrivalDate'];
	$nights = $_POST['nights'];
	$unitData = getUnitBySlug($unit);
	$maxNights = getMaxNights($unit,$arrivalDate);
	
	$extra = $nights - 1;
	$dates = explode("-",$arrivalDate);
	$departure = date("Y-m-d", mktime(0, 0, 0, $dates[1], $dates[2]+$extra, $dates[0]));
	
	$price = getPrice($_POST['nights'],$_POST['unit'],$_POST['arrivalDate'],$_POST['pay']);
	$priceValue = getPriceValue($_POST['nights'],$_POST['unit'],$_POST['arrivalDate'],true);
	
	$conflicts = conflicts($unitData['unitID'],$arrivalDate,$departure); 
	if($conflicts=='conflict'){
		header("location:/book/conflict");
	}else{
		$cost = $priceValue/100;
		$reference = simple_calendar_temp_booking("$arrivalDate 09:30:00","$departure 23:00:00",$unitData['unitID'],$cost);
	}
?>
<?php perch_layout('embed_header'); ?>
<?php perch_content('Page Content'); ?>
<div class="text booking">
	<div class="restrict">
		<script>
			function startTimer(duration, display) {
			    var timer = duration, minutes, seconds;
			    setInterval(function () {
			        minutes = parseInt(timer / 60, 10);
			        seconds = parseInt(timer % 60, 10);
			
			        minutes = minutes < 10 ? "0" + minutes : minutes;
			        seconds = seconds < 10 ? "0" + seconds : seconds;
			
			        display.textContent = minutes + ":" + seconds;
			
			        if (--timer < 0) {
			            window.location.replace('/embed/book/incomplete');
			        }
			    }, 1000);
			}
			
			window.onload = function () {
			    var time = 210,
			        display = document.querySelector('#time');
			    startTimer(time, display);
			};
		</script>

		<h2>Make Your Booking</h2>
        <p>
          Please complete the form below to make your booking.
        </p>
        <p class="timer">You've got <span id="time">03:30</span> left to complete the booking process.</p>
        <form method="post" id="payment-form" action="/stripe-checkout">
 				<?php
  
          $item = perch_collection('Huts', [
             'match' => 'eq',
             'filter' => 'slug',
             'value' => $unit,
             'count' => 1,
             'skip-template' => true,
          ]);
          
          $aD = explode("-",$arrivalDate);
          $arrivalDateH = "$aD[2]/$aD[1]/$aD[0]";
          
          echo "<input type=\"hidden\" name=\"unitID\" id=\"unitID\" value=\"$unitData[unitID]\" />";
          echo "<input type=\"hidden\" name=\"arrival\" id=\"arrival\" value=\"$arrivalDate\" />";
          echo "<input type=\"hidden\" name=\"reference\" id=\"reference\" value=\"$reference\" />";
          echo "<input type=\"hidden\" name=\"nights\" id=\"nights\" value=\"$nights\" />";
          
          $days = "day";
          
          if($nights>1){
	          $days = "days";
          }

          PerchSystem::set_var('arrival', $arrivalDateH);
          perch_collection('Huts', [
			    "filter"   => "slug",
		        "match"    => "eq",
		        "value"    => perch_get('s'),
		        "template" => 'mini.html'
		    ]);
          
          echo "<input type=\"hidden\" name=\"stripeDescription\" value=\"$unitData[name] - $arrivalDateH, $nights $days\" />";        
          
          //Create Booking Form
          echo "<div class=\"form_section form_grid\" id=\"you\">";
          echo "<h3>Your Details - All Required</h3>";
          echo "<div class='form-input'>";
          echo "<label>First Name</label>";
          echo "<input name=\"first_name\" type=\"text\" id=\"firstname\" onkeyup=\"javascript:validateDetails();\" required />";
          echo "</div>";
          echo "<div class='form-input'>";
          echo "<label>Last Name</label>";
          echo "<input name=\"last_name\" type=\"text\" id=\"lastname\" onkeyup=\"javascript:validateDetails();\" required />";
          echo "</div>";
          echo "<div class='form-input'>";
          echo "<label>Email Address</label>";
          echo "<input name=\"email\" type=\"email\" id=\"emailaddress\" onkeyup=\"javascript:validateDetails();\" required />";
          echo "</div>";
          echo "<div class='form-input'>";
          echo "<label>Mobile Number</label>";
          echo "<input name=\"mobile\" type=\"text\" id=\"telephone\" onkeyup=\"javascript:validateDetails();\" minlength=\"10\" />";
          echo "</div>";
          echo "</div>";     
          
          echo "<div class='proceed'>";
          
          echo ' <div id="voucher">
	        <h3>Voucher Code?</h3>
	        <p>Use this form to apply your voucher code to your booking.</p>
	        <div class="form-input">
		        <label>Voucher Code</label>
		        <input type="text" name="voucherCode" id="voucherCode" />
	        </div>
	        <div class="form-input">
		        <a class="button" onclick="javascript:applyVoucher();">Apply to Booking</a>
	        </div>
        </div> ';

        echo ' <div id="promo">
	        <h3>Promotional Code?</h3>
	        <p>Got a promotional code? Enter it here to apply your discount.</p>
	        <div class="form-input">
		        <label>Promo Code</label>
		        <input type="text" name="promoCode" id="promoCode" />
	        </div>
	        <div class="form-input">
		        <a class="button" onclick="javascript:applyPromo();">Apply to Booking</a>
	        </div>
        </div> ';
        
        echo "<div class=\"form_section\" id=\"stay\">";
          echo "<h3>Your Stay</h3>";
          echo "<p><strong>Arrival Date:</strong> $arrivalDateH</p>";
          echo "<p><strong>Days:</strong> $nights</p>";
          echo "<p><strong>Amount Due:</strong> &pound;<span id='customerAmount'>"; echo number_format($priceValue/100,2); echo "</span></p>";
          
          $orderID = rand();
         
?>	<button class="button" id="stripeSubmit">Pay by Card</button>
	<input type="hidden" name="cost" value="<?php echo $priceValue; ?>" id="AMOUNT" />
	<input type="hidden" name="ORDERID" value="<?php echo $reference; ?>" />
        </form>
        <a href="javascript:submitBooking();" class="button" id="nothingToPay" style="display:none;">Complete Booking</a>
<!--
<form method="post" action="/stripe-checkout" id="barclaycard" name="form1" style="display:none;">

<input type="hidden" name="ORDERID" value="<?php echo $reference; ?>">

<input type="hidden" name="AMOUNT" value="<?php echo $priceValue; ?>">

<input type="hidden" name="SHASIGN" value="<?php echo $hash; ?>">

<input type="text" name="first_name" />

<input type="text" name="last_name" />

<input type="text" name="mobile" />

<input type="text" name="email" />

<input type="text" name="arrival" value="<?php echo $arrivalDate; ?>" />

<input type="text" name="unitID" value="<?php echo $unit; ?>" />



<input type="text" name="nights" value="<?php echo $nights; ?>" />

<input type="submit" value="Stripe Checkout" id="stripeSubmit" />

<a href="javascript:submitBooking3();" style="display:none;" id="nothingToPay">NOTHING TO PAY</a>

</form> 
-->
        </div>
        </div>
          <script type="text/javascript">
	          
	          function setAmount(){
		          $.post( "/embed/book/get-price-value?r=" + Math.random(), { unit: "<?php echo $unit; ?>", arrival: "<?php echo $arrivalDate; ?>", nights: <?php echo $nights; ?> }).done(function( data ) {
			        var amount = parseInt(data);
		            var amount = amount/100;
		            var amount = amount.toFixed(2);
	                $('#customerAmount').text(amount);
	                $('#AMOUNT,#cost').val(data);
	              });
	          }
	          
	          //setAmount();
	          
	          function applyPromo(){
		      	var pPromoCode = $('#promoCode').val();
		      	var pReference = $('#reference').val();
		      	$.post( "/embed/book/apply-promo-code?" + Math.random(), { promoCode: pPromoCode, reference: pReference }).done(function( data ) {
	            	alert(data);
	            	setAmount();
	            });
	          }
	          function applyVoucher(){
		      	var pVoucherCode = $('#voucherCode').val();
		      	var pReference = $('#reference').val();
		      	$.post( "/embed/book/apply-voucher-code?" + Math.random(), { voucherCode: pVoucherCode, reference: pReference }).done(function( data ) {
	            	alert(data);
	            	getPrice();
	            	setAmount();
	            });
	          }
	          
	          function getPrice(){
		          
	          var firstname = $('#firstname').val();
			  var lastname = $('#lastname').val();
			  var emailaddress = $('#emailaddress').val();
			  var telephone = $('#telephone').val();
			  
			  var emailaddress = emailaddress.trim();
			  
			  if(firstname=='' || lastname=='' || emailaddress=='' || telephone==''){
				  alert('Please complete all the required fields');
			  }else{
	              pNights = $('#nights').val();
	              var pPay = 'on';
	              $.post( "/embed/book/get-price-value?r=" + Math.random(), { unit: "<?php echo $unit; ?>", arrival: "<?php echo $arrivalDate; ?>", nights: <?php echo $nights; ?> }).done(function( data ) {
		            var amount = parseInt(data);
		            var amount = amount/100;
		            var amount = amount.toFixed(2);
	                $('#customerAmount').text(amount);
	                $('#AMOUNT').val(data);
	                if(data==0){
		                $('#stripeSubmit,#nothingToPay').toggle();
	                }
	              });
				  }
	          }
	          
	          function validateDetails(){
		          
	          var firstname = $('#firstname').val();
			  var lastname = $('#lastname').val();
			  var emailaddress = $('#emailaddress').val();
			  var telephone = $('#telephone').val();
			  
			  var emailaddress = emailaddress.trim();
			  
			  $('#customerName').val(firstname+' '+lastname);
			  $('#customerEmail').val(emailaddress);
			  
			  if(firstname=='' || lastname=='' || emailaddress=='' || telephone==''){
				  $('.proceed').removeClass('show');
			  }else{
	              $('.proceed').addClass('show');
	          }
	          
	          }
          </script>
        </form>
		<script>
			
			function submitBooking(){
									
				var datastring = $("#payment-form").serialize();
				$.ajax({
				    type: "POST",
				    url: "/embed/book/check",
				    data: datastring,
				    success: function(data) {
				    	if(data=='conflict'){
					    	alert("Sorry, someone\'s beaten you to it! There\'s a booking conflict. Please go back and try different dates.");
					    }else{
				
							var datastring = $("#payment-form").serialize();
							$.ajax({
							    type: "POST",
							    url: "/embed/book/process",
							    data: datastring,
							    success: function(data) {
							        window.location.replace("/book/complete");
							    },
							    error: function(data) {
							        console.log("Error " + data);
							    }
							});
							
						}
					}
				});
			}
			
		</script>
	</div>
</div>
<?php perch_layout('embed_footer'); ?>