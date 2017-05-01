<?php require_once  $_SERVER['DOCUMENT_ROOT'] . '/VMAS/includes/path.php';
if (!$session->is_logged_in("Admin")) { redirect_to("login.php"); }

?>
<?php include_layout_template('vmas_header.php')?>

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
<div class="row">
	<div class="large-3 medium-3 columns">
		&nbsp;
	</div>
	<div class="large-6 medium-6 columns">

<h1 class="text-center">T E M P L A T E</h1>
		<div class="text-center">
		</div>
	</div>
	<div class="large-3 medium-3 columns">
		&nbsp;
	</div>
</div>
<?php include_layout_template('vmas_footer.php'); ?>


