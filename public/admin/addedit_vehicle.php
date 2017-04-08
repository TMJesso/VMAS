<?php
require_once  '../../includes/path.php';
if (!$session->is_logged_in()) { redirect_to("login.php"); }
$get_car = true;
$adding_car = false;

if (isset($_GET["vid"])) {
	$get_car = false;
	$adding_car = true;
	$vid = $db->prevent_injection($_GET["vid"]);
	$state = "IN";
	
} elseif (isset($_POST["button_cars"])) {

	if (empty($_POST["select_car"])) {
		// Adding new car
		$get_car = false;
		$adding_car = true;
		$vid = 0;
		$state = "IN";
		$var_dealer = "";
		
		
	} else {
		$get_car = false;
		$adding_car = false;
		$vehicle = Vehicle::find_car_by_id($_POST["select_car"]);
		$vid = $vehicle->id;
		
	}
} elseif (isset($_POST["button_add_new"])) {
	if ($_POST["select_dealer"] == 0) { // adding new dealer
		$dealer_name = $db->prevent_injection(htmlentities($_POST["text_name"], ENT_QUOTES));
		$dealer_address = $db->prevent_injection($_POST["text_address"]);
		$dealer_city = $db->prevent_injection($_POST["text_city"]);
		$dealer_state = $_POST["select_state"];
		$dealer_zip = $db->prevent_injection($_POST["text_zip"]);
		$dealer_phone = $db->prevent_injection($_POST["text_phone"]);
		$dealer_salesman = $db->prevent_injection($_POST["text_salesman"]);
		$new_dealer = new Dealer();
		$new_dealer->user_id = $session->user_id;
		$new_dealer->name = $dealer_name;
		$new_dealer->address = $dealer_address;
		$new_dealer->city = $dealer_city;
		$new_dealer->state = $dealer_state;
		$new_dealer->zip = $dealer_zip;
		$new_dealer->phone = $dealer_phone;
		$new_dealer->salesman = $dealer_salesman;
		if ($new_dealer->save()) {
			$session->message("Dealer \"" . html_entity_decode($new_dealer->name, ENT_QUOTES) . "\" has been added!");
			$vid = $new_dealer->id;
			redirect_to("addedit_vehicle.php?vid={$vid}");
		}
	}
}
?>
		<?php include_layout_template('vmas_header.php')?>
<script src="<?php echo JS_PATH . "vendor/jquery.js"; ?>"></script>
<script>
	$(document).ready(function(){
		if ($("#select_dealer").val() == "0") {
			$("#select_dealer").attr("required", false);
			$("#show_edit_vehicle").css("display", "none");
			$("#add_new_dealer").css("display", "block");
			$("#text_name").attr("required", true);
			$("#text_address").attr("required", true);
			$("#text_city").attr("required", true);
			$("#select_state").attr("required", true);
			$("#text_zip").attr("required", true);
			$("#text_phone").attr("required", true);
			$("#text_salesman").attr("required", true);
		} else {
			$("#select_dealer").attr("required", true);
			$("#show_edit_vehicle").css("display", "block");
			$("#add_new_dealer").css("display", "none");
		}
	
		//$("#show_select_dealer").css("display", "block");
		//$("#show_edit_vehicle").css("display", "none");
		$("#select_dealer").change(function() {
			if ($("#select_dealer").val() == "0") {
				$("#select_dealer").attr("required", false);
				$("#show_select_dealer").css("display", "block");
				$("#add_new_dealer").css("display", "block");
				$("#text_name").attr("required", true);
				$("#text_address").attr("required", true);
				$("#text_city").attr("required", true);
				$("#select_state").attr("required", true);
				$("#text_zip").attr("required", true);
				$("#text_phone").attr("required", true);
				$("#text_salesman").attr("required", true);
				$("#show_space").css("display", "block");
				$("#show_edit_vehicle").css("display", "none");
			} else {
				$("#text_name").attr("required", false);
				$("#text_address").attr("required", false);
				$("#text_city").attr("required", false);
				$("#select_state").attr("required", false);
				$("#text_zip").attr("required", false);
				$("#text_phone").attr("required", false);
				$("#text_salesman").attr("required", false);
				$("#add_new_dealer").css("display", "none");
				$("#show_select_dealer").css("display", "block");
				$("#select_dealer").attr("required", true);
				$("#show_space").css("display", "none");
				$("#show_edit_vehicle").css("display", "block");
			}
		});
		$("#text_name").change(function() {
			$(".say_text_name").text($("#text_name").val());
		});
	});
</script>
<!-- MENU -->
<div class="row">
	<div class="large-12 medium-12 columns">
		<?php echo $breadcrumbs; ?>
		<?php echo navigation(); ?>
	</div>
</div>
<!-- HEADER -->
<div class="row">
	<div class="large-3 medium-3 columns">
		&nbsp;
	</div>
	<div class="large-6 medium-6 columns">
		<?php echo output_errors($session->errors); ?>
		<?php echo output_message($session->message); ?>
		<h3 class="text-center"><?php echo ((isset($header)) ? $header : ""); ?></h3>
	</div>
	<div class="large-3 medium-3 columns">
		&nbsp;
	</div>
</div>
<!-- CONTENT -->
<?php if ($get_car && !$adding_car) { ?>
	<?php // Select a car or choose blank to add ?>
<?php $cars = Vehicle::find_all_cars_by_user_id($session->user_id); ?>
<div class="row">
	<div class="large-3 medium-3 columns">
		&nbsp;
	</div>
	<div class="large-6 medium-6 columns">
		<form data-abide novalidate action="addedit_vehicle.php" method="post">
			<div data-abide-error class="alert callout" style="display: none;">
				<p><i class="fi-alert"></i> There are some errors in your form.</p>
			</div>
<!-- Select Car -->
			<label>Choose a vehicle to <strong>Edit</strong> or leave blank to <strong>Add</strong>
				<select name="select_car">
					<option value="">Add New Vehicle</option>
					<?php foreach ($cars as $car) { ?>
						<option value="<?php echo $car->id; ?>"><?php echo $car->make . " " . $car->model . " " . $car->year;?></option>
					<?php } ?>
				</select>
			</label>
<!-- Button -->
			<div class="text-center">
				<input type="submit" name="button_cars" id="button_cars" class="button" value="Submit" />
			</div>
		</form>
	</div>
	<div class="large-3 medium-3 columns">
		&nbsp;
	</div>
</div>
<?php } elseif (!$get_car && $adding_car) { ?>
	<?php // add new car ?>
	<?php $dealers = Dealer::find_by_name($session->user_id); ?>
	<div class="row">
		<div class="row">
			<div class="large-3 medium-3 columns">
				&nbsp;
			</div>
			<div class="large-6 medium-6 columns">
				<!-- <h6 class="text-center">Adding Car</h6> -->
			</div>
			<div class="large-3 medium-6 columns">
				&nbsp;
			</div>
		</div>
		<div class="large-12 medium-12 columns">
		<form data-abide novalidate action="addedit_vehicle.php" method="post">
			<div data-abide-error class="alert callout" style="display: none;">
				<p><i class="fi-alert"></i> There are some errors in your form.</p>
			</div>
			<div class="large-6 medium-6 columns">
<!-- Select Dealer -->
				<fieldset class="callout" id="show_select_dealer">
					<legend>Dealer Information</legend>
					<label>
						<select name="select_dealer" id="select_dealer">
							<option value="0">Add a new dealer</option>
							<?php foreach ($dealers as $dealer) { ?>
								<option value="<?php echo $dealer->id; ?>" <?php if ($dealer->id == $vid) { ?> selected <?php } ?>><?php echo $dealer->name; ?></option>
							<?php } ?>
						</select>
					</label>
				</fieldset>
<!-- Add New Dealer -->
				<fieldset class="callout" id="add_new_dealer">
					<legend>New Dealer Information</legend>
<!-- Dealer Name -->
					<label for="text_name">Dealer Name
						<input type="text" name="text_name" id="text_name" maxlength="45" placeholder="McGonigle" />
						<span class="form-error">
							Please enter the name of the dealer ...
						</span>
						
					</label>
<!-- Dealer Address -->
					<label for="text_address">Address
						<input type="text" name="text_address" id="text_address" maxlength="35" placeholder="123 Homer Lane" />
						<span class="form-error">
							Please enter the address for <span class="say_text_name"></span> ...
						</span>
					</label>
<!-- City -->
					<label for="text_city"> City
						<input type="text" name="text_city" id="text_city" maxlength="25" placeholder="Kokomo" />
						<span class="form-error">
							Please enter the city for <span class="say_text_name"></span> ...
						</span>
					</label>
<!-- State -->
					<label for="select_state">State
						<select name="select_state" id="select_state" title="Select the State" >
							<option value="">Select State</option>
							<?php $states = get_states();
							foreach ($states as $key => $kstate) { ?>
								<option value="<?php echo $key; ?>" <?php if ($key==$state) { ?> selected <?php }?>><?php echo $kstate; ?></option>
							<?php } ?>
						</select>
						<span class="form-error">
							State is required for <span class="say_text_name"></span> ...
						</span>
					</label>
<!-- Zip Code -->
					<label for="text_zip">Zip Code
						<input type="text" name="text_zip" id="text_zip" maxlength="" placeholder="44444" />
						<span class="form-error">
							Please enter a Zip Code for <span class="say_text_name"></span> ...
						</span>
					</label>
<!-- Phone Number -->
					<label for="text_phone">Phone Number
						<input type="text" name="text_phone" id="text_phone" maxlength="" placeholder="9999999999" />
						<span class="form-error">
							Please enter the Phone Number for <span class="say_text_name"></span> ...
						</span>
					</label>
<!-- Salesman -->
					<label for="text_salesman">Salesman
						<input type="text" name="text_salesman" id="text_salesman" maxlength="" placeholder="Bob" />
						<span class="form-error">
							Please enter the Salesman for <span class="say_text_name"></span> ...
						</span>
					</label>
				</fieldset>
			</div>
			<div class="large-6 medium-6 columns">
<!-- When not showing contents show the space for placeholder sake -->
				<div id="show_space">
					&nbsp;
				</div>
<!-- Show Vehicle -->
				<fieldset class="callout" id="show_edit_vehicle">
					<legend>Vehicle Information</legend>
					
				</fieldset>
			</div>
<!-- Buttons -->
			<div class="large-12 medium-12 columns text-center">
				<input type="submit" name="button_add_new" id="button_" class="button" value="Submit" />
				<input type="reset" name="button_reset" id="button_reset" class="button" value="Reset" />
			</div>
		</form>
		</div>
	</div>
<?php } elseif (!$get_car && !$adding_car) { ?>
	<?php // edit car ?>
	<div class="row">
		<div class="large-3 medium-3 columns">
			&nbsp;Editing Car
		</div>
		<div class="large-6 medium-6 columns">
		
		</div>
		<div class="large-3 medium-3 columns">
			&nbsp;
		</div>
	</div>	
<?php } else { ?>
	<?php // none of the above are true ?>
	<div class="row">
		<div class="large-3 medium-3 columns">
			&nbsp;
		</div>
		<div class="large-6 medium-6 columns">
		<p class="alert callout">Invalid selection</p>
		</div>
		<div class="large-3 medium-3 columns">
			&nbsp;
		</div>
	</div>	
<?php } ?>
<?php include_layout_template('vmas_footer.php'); ?>

<?php 

	
?>
