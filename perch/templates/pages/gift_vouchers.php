<?php perch_layout('header'); ?>
<?php perch_content('Page Content'); ?>
<?php $sales = perch_content('Stop Sales',true); ?>
<?php
	if($sales == 'on'){
?>
<div class="text">
	<div class="restrict">
		<h2>Buy a Voucher</h2>
		<?php
			echo '<form id="payment-form">
				<div class="form-section">
				 	<h3>Name</h3>
					<div class="form-input">
						<label>First Name</label>
						<input type="text" name="firstname" id="firstname" />
					</div>
					<div class="form-input">
						<label>Last Name</label>
						<input type="text" name="lastname" id="lastname" />
					</div>
					<h3>Gift Voucher Note</h3>
					<div class="form-input">
						<label>Optional - Add A Note To Include With The Voucher</label>
						<input type="text" name="note" id="note" />
					</div>
					<h3>Delivery Address</h3>
					<div class="form-input">
						<label>Address 1</label>
						<input type="text" name="adddress1" id="address1" />
					</div>
					<div class="form-input">
						<label>Address 2</label>
						<input type="text" name="adddress2" id="address2" />
					</div>
					<div class="form-input">
						<label>Town</label>
						<input type="text" name="town" id="town" />
					</div>
					<div class="form-input">
						<label>County</label>
						<input type="text" name="county" id="county" />
					</div>
					<div class="form-input">
						<label>Post Code</label>
						<input type="text" name="postcode" id="postcode" />
					</div>
					<h3>Contact Details</h3>
					<div class="form-input">
						<label>Email Address</label>
						<input type="text" name="emailaddress" id="emailaddress" />
					</div>
					<div class="form-input">
						<label>Telephone</label>
						<input type="text" name="telephone" id="telephone" />
					</div>
					<h3>Payment Details</h3>
					<div class="form-input">
						<label>Gift Voucher Value</label>
						<select name="voucher" id="voucher" autocomplete="off">
							<option>Please Select</option>
							<option value="2600">£25.00 + £1 Shipping & Handling</option>
							<option value="3100">£30.00 + £1 Shipping & Handling</option>
							<option value="5100">£50.00 + £1 Shipping & Handling</option>
							<option value="6100">£60.00 + £1 Shipping & Handling</option>
						</select>
					</div>
					<div class="form-input">
						<label>Card Details</label>
						<div id="card-element">
							<!-- Elements will create input elements here -->
						</div>
						<!-- We\'ll put the error messages in this element -->
						<div id="card-errors" role="alert"></div>
					</div>
					<div class="form-input">
						<button id="submit">Pay</button>
					</div>
				</div>
			</form>
			<script>
			var stripe = Stripe(\''.getenv('STRIPE_PUBLISHABLE_KEY').'\');
				var elements = stripe.elements();
			$("#voucher").change(function(){
				var stripeValue = $("#voucher").val();
				var response = fetch("/token.php?value="+stripeValue).then(function(response) {
				  return response.json();
				}).then(function(responseJson) {
				  var clientSecret = responseJson.client_secret;
				  console.log(clientSecret);
				  // Call stripe.confirmCardPayment() with the client secret.
				var style = {
				  base: {
				    color: "#000",
				  }
				};
				
				var card = elements.create("card", { 
					hidePostalCode: true, 
					style: { 
						base: {
						  lineHeight: \'40px\',
						  fontWeight: 300,
						  fontSize: \'15px\',
						  \'::placeholder\': {
						    color: \'#222\',
						   }, 
						}
					}
				});
				card.mount("#card-element");
				
				card.on("change", ({error}) => {
				  let displayError = document.getElementById("card-errors");
				  if (error) {
				    displayError.textContent = error.message;
				  } else {
				    displayError.textContent = "";
				  }
				});
	
			
			var form = document.getElementById(\'payment-form\');

			form.addEventListener(\'submit\', function(ev) {
				
			  ev.preventDefault();
			  
			  $(\'#payment-form button\').prop("disabled", true);
			  $(\'#payment-form button\').hide();
			  var title = $(\'#title\').val();
			  var firstname = $(\'#firstname\').val();
			  var lastname = $(\'#lastname\').val();
			  var address1 = $(\'#address1\').val();
			  var address2 = $(\'#address2\').val();
			  var town = $(\'#town\').val();
			  var county = $(\'#county\').val();
			  var postcode = $(\'#postcode\').val();
			  var emailaddress = $(\'#emailaddress\').val();
			  var telephone = $(\'#telephone\').val();
			  var note = $(\'#note\').val();
			  
			  var emailaddress = emailaddress.trim();
			  
			  if(firstname==\'\' || lastname==\'\' || emailaddress==\'\' || telephone==\'\' || address1==\'\' || town==\'\' || county==\'\' || postcode==\'\'){
				  alert(\'Please complete all the required fields\');
				  $(\'#payment-form button\').prop("disabled", false);
				  $(\'#payment-form button\').show();
			  }else{
				  
				  stripe.confirmCardPayment(clientSecret, {
				    payment_method: {
				      card: card,
				      billing_details: {
				        name: title+\' \'+firstname+\' \'+lastname,
				        email: emailaddress,
				        phone: telephone,
				        address: {
					      line1: address1
					    }
				      }
				    }
				  }).then(function(result) {
				    if (result.error) {
				      // Show error to your customer (e.g., insufficient funds)
				      $(\'#payment-form button\').prop("disabled", false);
				      $(\'#payment-form button\').show();
				    } else {
				      // The payment has been processed!
				      if (result.paymentIntent.status === \'succeeded\') {
				        // Show a success message to your customer
				        $(\'#payment-form\').hide();
				        $.post("/gift-vouchers/process-voucher", { pFirstname: firstname, pLastname: lastname, pEmail: emailaddress, pPhone: telephone, pAddress1: address1, 
				        pAddress2: address2, pTown: town, pCounty: county, pPostcode: postcode, pValue: stripeValue, pNote: note }, function(){
					       window.location.replace("/gift-vouchers/complete"); 
					    });
				      }
				    }
				  });
			  
			  }
			});
			});
			});
			</script>';
		?>
	</div>
</div>
<?php
	}
?>
<?php perch_layout('footer'); ?>