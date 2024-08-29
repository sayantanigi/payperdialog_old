<div class="page-wrapper">
	<div class="content container-fluid">
		<div class="row">
			<div class="col-xl-12">
				<div class="page-header">
					<div class="row">
						<div class="col-sm-12">
							<h3 class="page-title"><?php echo $heading?></h3>
						</div>
					</div>
				</div>
				<div class="card">
					<div class="card-body">
	            		<?php if($button=='Update') { ?>
	        			<form  action="<?php echo admin_url('subscription/update_action'); ?>" method="post" enctype="multipart/form-data">
	            		<?php } else { ?>
	    				<form class="forms-sample" action="<?php echo admin_url('Subscription/create_action'); ?>" method="post" enctype="multipart/form-data">
	            		<?php } ?>
							<div class="form-group">
								<label>Subscription Name</label>
								<input class="form-control" type="text" placeholder="Example: Basic" name="subscription_name" value="<?= $subscription_name;?>" required>
							</div>
							<div class="form-group">
								<label>Subscription Plan for Specific User Type</label>
								<select class="form-control" name="subscription_user_type" id="subscription_user_type" required>
									<option value="">Choose an option</option>
									<option value="Employee" <?php if($subscription_user_type == 'Employee') { echo "selected"; } ?>>Employee</option>
									<option value="Employer" <?php if($subscription_user_type == 'Employer') { echo "selected"; } ?>>Employer</option>
									<option value="Expert" <?php if($subscription_user_type == 'Expert') { echo "selected"; } ?>>Expert</option>
								</select>
							</div>
							<div class="form-group subscription_type">
								<label>Subscription Type</label>
								<select class="form-control" name="subscription_type" id="subscription_type" required onclick="showHideDiv()">
									<option value="">Choose an option</option>
									<option value="free" <?php if($subscription_type == 'free') { echo "selected"; } ?>>Free</option>
									<option value="paid" <?php if($subscription_type == 'paid') { echo "selected"; } ?>>Paid</option>
								</select>
							</div>
							<input type="hidden" name="subscription_country" id="subscription_country" value="Global">
							<div class="form-group showSubPrice" >
								<label>Subscription Amount ($)</label>
								<input class="form-control" type="text" placeholder="Example: 100 USD" id="subscription_amount" name="subscription_amount" value="<?= $subscription_amount;?>" required  onkeypress="only_number(event)">
							</div>
							<div class="form-group showProdKey" >
								<label>Product ID (Stripe Product Key)</label>
								<input class="form-control" type="text" placeholder="Example: prod_XXXXXXXXXXXXXX" id="product_key" name="product_key" value="<?= $product_key;?>">
							</div>
							<div class="form-group showPriceKey" >
								<label>Price ID (Stripe Price Key)</label>
								<input class="form-control" type="text" placeholder="Example: price_XXXXXXXXXXXXXXXXXXXXXXXX" id="price_key" name="price_key" value="<?= $price_key;?>">
							</div>
							<div class="form-group showPaystackField" >
								<label>Plan Code (Pay Stack Plan Code)</label>
								<input class="form-control" type="text" placeholder="Example: PLN_XXXXXXXXXXXXXXX" id="plan_code" name="plan_code" value="<?= $plan_code;?>">
							</div>
							<div class="form-group subscription_duration">
								<label>Subscription Duration (in days)</label>
								<input class="form-control" type="text" placeholder="Example: 30" name="subscription_duration" value="<?= $subscription_duration;?>" required onkeypress="only_numbers(event)">
							</div>
							<div class="form-group">
								<label>Subscription Description</label>
								<textarea class="form-control" name="subscription_description" id="subscription_description"><?= @$subscription_description ?></textarea>
							</div>
							<input type="hidden" name="id" value="<?php echo $id; ?>">
							<input type="hidden" name="button" value="<?php echo $button; ?>">
							<div class="mt-4">
								<button class="btn btn-primary" type="submit">Submit</button>
								<a href="<?= admin_url('subscription')?>" class="btn btn-link">Cancel</a>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<style>
.showSubPrice {display: none;}
.showProdKey {display: none;}
.showPriceKey {display: none;}
.showPaystackField {display: none;}
</style>
<script src="https://cdn.ckeditor.com/4.16.2/standard/ckeditor.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
<script>
	CKEDITOR.replace('subscription_description');
</script>
<script >
$(document).ready(function(){
	var selectedOption = $('#subscription_type').val();
	var selectedcountry = $('#subscription_country').val();
	if(selectedOption == 'free') {
		if(selectedcountry == 'Nigeria') {
			$('.showSubPrice').show();
			$('.showSubPrice label').text('Subscription Amount (₦)');
			$('#subscription_amount').attr('placeholder', 'Example: 100 NGN');
			$('#subscription_amount').val('0.00');
			$('#subscription_amount').prop('readonly', true);
			$('.showProdKey').hide();
			$('.showPriceKey').hide();
			$('.showPaystackField').hide();
		} else if(selectedcountry == '') {
			$('.showSubPrice').hide();
			$('#subscription_amount').val('');
			$('.showProdKey').hide();
			$('.showPriceKey').hide();
			$('.showPaystackField').hide();
		} else {
			$('.showSubPrice').show();
			$('.showSubPrice label').text('Subscription Amount ($)');
			$('#subscription_amount').attr('placeholder', 'Example: 100 USD');
			$('#subscription_amount').val('0.00');
			$('#subscription_amount').prop('readonly', true);
			$('.showProdKey').hide();
			$('.showPriceKey').hide();
			$('.showPaystackField').hide();
		}
	} else if(selectedOption == 'paid'){
		if(selectedcountry == 'Nigeria') {
			$('.showSubPrice').show();
			$('.showSubPrice label').text('Subscription Amount (₦)');
			$('#subscription_amount').attr('placeholder', 'Example: 100 NGN');
			$('.showProdKey').hide();
			$('.showPriceKey').hide();
			$('.showPaystackField').show();
			$('#plan_code').prop('required',true);
		} else if(selectedcountry == '') {
			$('.showSubPrice').hide();
			$('.showProdKey').hide();
			$('.showPriceKey').hide();
			$('.showPaystackField').hide();
			$('#plan_code').prop('required',false);
		} else {
			$('.showSubPrice').show();
			$('.showSubPrice label').text('Subscription Amount ($)');
			$('#subscription_amount').attr('placeholder', 'Example: 100 USD');
			$('.showProdKey').show();
			$('.showPriceKey').show();
			$('.showPaystackField').hide();
			$('#product_key').prop('required',true);
			$('#price_key').prop('required',true);
		}
	} else {
		$('.showSubPrice').hide();
		$('.showProdKey').hide();
		$('.showPriceKey').hide();
		$('.showPaystackField').hide();
		$('#product_key').prop('required',false);
		$('#price_key').prop('required',false);
		$('#plan_code').prop('required',false);
	}

	$("#subscription_amount").on("keypress keyup blur", function (event) {
 		var patt = new RegExp(/(?<=\.\d\d).+/i);
     	$(this).val($(this).val().replace(patt, ''));
     	if ((event.which != 46 || $(this).val().indexOf('.') != -1) && (event.which < 48 || event.which > 57)) {
        	event.preventDefault();
     	}
 	});
})

function showHideDiv() {
	var selectedOption = $('#subscription_type').val();
	var selectedcountry = $('#subscription_country').val();
	if(selectedOption == 'free') {
		if(selectedcountry == 'Nigeria') {
			$('.showSubPrice').show();
			$('.showSubPrice label').text('Subscription Amount (₦)');
			$('#subscription_amount').attr('placeholder', 'Example: 100 NGN');
			$('#subscription_amount').val('0.00');
			$('#subscription_amount').prop('readonly', true);
			$('.showProdKey').hide();
			$('.showPriceKey').hide();
			$('.showPaystackField').hide();
		} else if(selectedcountry == '') {
			$('.showSubPrice').hide();
			$('#subscription_amount').val('');
			$('.showProdKey').hide();
			$('.showPriceKey').hide();
			$('.showPaystackField').hide();
		} else {
			$('.showSubPrice').show();
			$('.showSubPrice label').text('Subscription Amount ($)');
			$('#subscription_amount').attr('placeholder', 'Example: 100 USD');
			$('#subscription_amount').val('0.00');
			$('#subscription_amount').prop('readonly', true);
			$('.showProdKey').hide();
			$('.showPriceKey').hide();
			$('.showPaystackField').hide();
		}
	} else if(selectedOption == 'paid'){
		if(selectedcountry == 'Nigeria') {
			$('.showSubPrice').show();
			$('.showSubPrice label').text('Subscription Amount (₦)');
			$('#subscription_amount').attr('placeholder', 'Example: 100 NGN');
			$('#subscription_amount').prop('readonly', false);
			$('#subscription_amount').val('');
			$('.showProdKey').hide();
			$('.showPriceKey').hide();
			$('.showPaystackField').show();
			$('#plan_code').prop('required',true);
		} else if(selectedcountry == '') {
			$('.showSubPrice').hide();
			$('.showProdKey').hide();
			$('.showPriceKey').hide();
			$('.showPaystackField').hide();
			$('#plan_code').prop('required',false);
		} else {
			$('.showSubPrice').show();
			$('.showSubPrice label').text('Subscription Amount ($)');
			$('#subscription_amount').attr('placeholder', 'Example: 100 USD');
			$('#subscription_amount').prop('readonly', false);
			$('#subscription_amount').val('');
			$('.showProdKey').show();
			$('.showPriceKey').show();
			$('.showPaystackField').hide();
			$('#product_key').prop('required',true);
			$('#price_key').prop('required',true);
		}
	} else {
		$('.showSubPrice').hide();
		$('.showProdKey').hide();
		$('.showPriceKey').hide();
		$('.showPaystackField').hide();
		$('#product_key').prop('required',false);
		$('#price_key').prop('required',false);
		$('#plan_code').prop('required',false);
	}
}

function showpaystackField() {
	var selectedcountry = $('#subscription_country').val();
	var selectedOption = $('#subscription_type').val();
	if(selectedcountry == 'Nigeria') {
		if (selectedOption == 'free') {
			$('.showSubPrice').show();
			$('.showSubPrice label').text('Subscription Amount (₦)');
			$('#subscription_amount').attr('placeholder', 'Example: 100 NGN');
			$('#subscription_amount').val('0.00');
			$('#subscription_amount').prop('readonly', true);
			$('.showProdKey').hide();
			$('.showPriceKey').hide();
			$('.showPaystackField').hide();
		} else if(selectedOption == 'paid') {
			$('.showSubPrice').show();
			$('.showSubPrice label').text('Subscription Amount (₦)');
			$('#subscription_amount').attr('placeholder', 'Example: 100 NGN');
			$('.showProdKey').hide();
			$('.showPriceKey').hide();
			$('.showPaystackField').show();
			$('#plan_code').prop('required',true);
		} else {
			$('.showSubPrice').hide();
			$('.showProdKey').hide();
			$('.showPriceKey').hide();
			$('.showPaystackField').hide();
			$('#product_key').prop('required',false);
			$('#price_key').prop('required',false);
			$('#plan_code').prop('required',false);
		}
	} else if (selectedcountry == '') {
		$('.showSubPrice').hide();
		$('.showProdKey').hide();
		$('.showPriceKey').hide();
		$('.showPaystackField').hide();
		$('#product_key').prop('required',false);
		$('#price_key').prop('required',false);
		$('#plan_code').prop('required',false);
	} else {
		if (selectedOption == 'free') {
			$('.showSubPrice').show();
			$('.showSubPrice label').text('Subscription Amount ($)');
			$('#subscription_amount').attr('placeholder', 'Example: 100 USD');
			$('#subscription_amount').val('0.00');
			$('#subscription_amount').prop('readonly', true);
			$('.showProdKey').hide();
			$('.showPriceKey').hide();
			$('.showPaystackField').hide();
		}  else if(selectedOption == 'paid') {
			$('.showSubPrice').show();
			$('.showSubPrice label').text('Subscription Amount ($)');
			$('#subscription_amount').attr('placeholder', 'Example: 100 USD');
			$('.showProdKey').show();
			$('.showPriceKey').show();
			$('.showPaystackField').hide();
			$('#product_key').prop('required',true);
			$('#price_key').prop('required',true);
		} else {
			$('.showSubPrice').hide();
			$('.showProdKey').hide();
			$('.showPriceKey').hide();
			$('.showPaystackField').hide();
			$('#product_key').prop('required',false);
			$('#price_key').prop('required',false);
			$('#plan_code').prop('required',false);
		}
	}
}

function only_number(event) {
    var x = event.which || event.keyCode;
    console.log(x);
    if((x >= 48 ) && (x <= 57 ) || x == 8 | x == 9 || x == 13 || x == 46) {
        return;
    } else {
        event.preventDefault();
    }
}

function only_numbers(event) {
    var x = event.which || event.keyCode;
    console.log(x);
    if((x >= 48 ) && (x <= 57 ) || x == 8 | x == 9 || x == 13) {
        return;
    } else {
        event.preventDefault();
    }
}
</script>
