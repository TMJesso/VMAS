<?php
require_once  '../../includes/path.php';
if (!$session->is_logged_in()) { redirect_to("login.php"); }
$get_car = true;
$adding_car = false;

if (isset($_POST["button_cars"])) {
	if (empty($_POST["select_car"])) {
		// Adding new car
		$get_car = false;
		$adding_car = true;
		$vid ="";
		
	} else {
		$get_car = false;
		$adding_car = false;
		$vid = Vehicle::find_car_by_id($_POST["select_car"]);
	}
}
?>
		<?php include_layout_template('vmas_header.php')?>

<script>
	$(document).ready(function(){
		$("#select_dealer").attr("required", true);
		$("#select_dealer").change(function() {
			if ($(this).val() == "0") {
				$("#select_dealer").attr("required", false);
				$("#select_dealer").css("display", "none");
				$("#add_new_dealer").css("display", "block");
				$("#add_new_dealer").attr("required", true);
			} else {
				$("#add_new_dealer").attr("required", false);
				$("#add_new_delaer").css("display", "none");
				$("#select_dealer").css("display", "block");
				$("#select_dealer").attr("required", true);
			}
		});
	});
</script>
<!-- MENU -->
<div class="row">
	<div class="large-12 medium-12 small-12 columns">
		<?php echo $breadcrumbs; ?>
		<?php echo navigation(); ?>
	</div>
</div>
<!-- HEADER -->
<div class="row">
	<div class="large-3 medium-3 small-2 columns">
		&nbsp;
	</div>
	<div class="large-6 medium-6 small-8 columns">
		<?php echo output_errors($session->errors); ?>
		<?php echo output_message($session->message); ?>
		<h3 class="text-center"><?php echo ((isset($header)) ? $header : ""); ?></h3>
	</div>
	<div class="large-3 medium-3 small-2 columns">
		&nbsp;
	</div>
</div>
<!-- CONTENT -->
<?php if ($get_car && !$adding_car) { ?>
	<?php // Select a car or choose blank to add ?>
<?php $cars = Vehicle::find_all_cars_by_user_id($session->user_id); ?>
<div class="row">
	<div class="large-3 medium-3 small-2 columns">
		&nbsp;
	</div>
	<div class="large-6 medium-6 small-8 columns">
		<form data-abide novalidate action="addedit_vehicle.php" method="post">
			<div data-abide-error class="alert callout" style="display: none;">
				<p><i class="fi-alert"></i> There are some errors in your form.</p>
			</div>
			<label>Choose a vehicle to <strong>Edit</strong> or leave blank to <strong>Add</strong>
				<select name="select_car">
					<option value=""></option>
					<?php foreach ($cars as $car) { ?>
						<option value="<?php echo $car->id; ?>"><?php echo $car->make . " " . $car->model . " " . $car->year;?></option>
					<?php } ?>
				</select>
			</label>
		
			<div class="text-center">
				<input type="submit" name="button_cars" id="button_cars" class="button" value="Submit" />
			</div>
		</form>
	</div>
	<div class="large-3 medium-3 small-2 columns">
		&nbsp;
	</div>
</div>
<?php } elseif (!$get_car && $adding_car) { ?>
	<?php // add new car ?>
	<?php $dealers = Dealer::find_by_name($session->user_id); ?>
	<div class="row">
		<div class="large-12 medium-12 small-12 columns">
		<form data-abide novalidate action="addedit_vehicle.php?vid=<?php echo $vid;?>" method="post">
			<div data-abide-error class="alert callout" style="display: none;">
				<p><i class="fi-alert"></i> There are some errors in your form.</p>
			</div>
			<div class="large-6 medium-6 small-6 columns">
				<fieldset class="callout" id="select_dealer">
					<legend>Dealer Information</legend>
					<label>
						<select name="select_dealer">
							<option value="0">Add a new dealer</option>
							<?php foreach ($dealers as $dealer) { ?>
								<option value="<?php echo $dealer->id; ?>"><?php echo $dealer->name; ?></option>
							<?php } ?>
						</select>
					</label>
				
				
				
				</fieldset>
				<fieldset class="callout" id="add_new_dealer">
					<legend>New Dealer Information</legend>
<!-- Dealer Name -->
					<label for="text_name">Dealer Name
						<input type="text" name="text_name" id="text_name" maxlength="45" placeholder="McGonigle" required />
						<span class="form-error">
							Please enter the name of the dealer ...
						</span>
						
					</label>
					
					<label for="text_address">
						<input type="text" name="text_address" id="text_address" maxlength="35" placeholder="123 Homer Lane" required />
						<span class="form-error">
							Please enter the address for <script>$(document).ready(function(){ $("#text-name").val();});</script> ...
						</span>
					</label>
				</fieldset>
			</div>
			<div class="large-6 medium-6 small-6 columns">
				<fieldset class="callout" id="edit_vehicle">
					<legend>Vehicle Information</legend>
					
				</fieldset>
			</div>
			<div class="large-12 medium-12 small-12 columns text-center">
				<input type="submit" name="button_" id="button_" class="button" value="Submit" />
				<input type="reset" name="button__reset" id="button__reset" class="button" value="Reset" />
			</div>
		</form>
		</div>
	</div>
<?php } elseif (!$get_car && !$adding_car) { ?>
	<?php // edit car ?>
	<div class="row">
		<div class="large-3 medium-3 small-2 columns">
			&nbsp;
		</div>
		<div class="large-6 medium-6 small-8 columns">
		
		</div>
		<div class="large-3 medium-3 small-2 columns">
			&nbsp;
		</div>
	</div>	
<?php } else { ?>
	<?php // none of the above are true ?>
	<div class="row">
		<div class="large-3 medium-3 small-2 columns">
			&nbsp;
		</div>
		<div class="large-6 medium-6 small-8 columns">
		
		</div>
		<div class="large-3 medium-3 small-2 columns">
			&nbsp;
		</div>
	</div>	
<?php } ?>
<?php include_layout_template('vmas_footer.php'); ?>

<?php 

	
?>
