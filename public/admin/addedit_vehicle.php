<?php
require_once  '../../includes/path.php';
if (!$session->is_logged_in()) { redirect_to("login.php"); }

?>
		<?php include_layout_template('vmas_header.php')?>

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
				<select name="select_car" >
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
<?php include_layout_template('vmas_footer.php'); ?>

<?php 

	
?>
