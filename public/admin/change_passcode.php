<?php
require_once  $_SERVER['DOCUMENT_ROOT'] . '/VMAS/includes/path.php';
if (!$session->is_logged_in("Admin")) { redirect_to("login.php"); }
if (isset($_POST['btn_submit'])) {
	$passcode = ((isset($_POST['txt_passcode'])) ? $db->prevent_injection(htmlentities($_POST['txt_passcode'])) : null);
	if (is_null($passcode)) {
		$errors['passcode'] = "You have not entered a valid passcode!";
		$session->errors($errors);
		redirect_to('change_passcode.php');
	} else {
		$user = User::get_user_by_id($session->get_user_id());
		$user->passcode = password_encrypt($passcode, $user->username);
		if ($user->save()) {
			$session->message("Your passcode has been changed!");
			redirect_to('index.php');
		} else {
			$errors['passcode'] = "Your passcode was not saved due to some unforseen error!";
			$session->errors($errors);
			redirect_to('change_passcode.php');
		}
	}
}
?>
<?php include_layout_template('vmas_header.php')?>
<div class="row">
	<div class="large-3 medium-3 columns">
		&nbsp;
	</div>
	<div class="large-6 medium-6 columns text-center">
		<?php echo output_errors($session->errors); ?>
		<?php echo output_message($session->message); ?>
		<h3 class="text-center"><?php echo ((isset($header)) ? $header : ""); ?></h3>
	</div>
	<div class="large-3 medium-3 columns">
		&nbsp;
	</div>
</div>
<div class="row">
	<div class="large-3 medium-3 columns">
		&nbsp;
	</div>
	<div class="large-6 medium-6 columns">
		<form data-abide novalidate method="post" action="change_passcode.php">
			<div data-abide-error class="alert callout" style="display: none;">
				<p><i class="fi-alert"></i> There are some errors in your form.</p>
			</div>
			<label for="txt_passcode">Enter your passcode
				<input type="password" name="txt_passcode" id="txt_passcode" title="At least one number, one uppercase, one lowercase, and at least 8 characters long" placeholder="Number, upper, lower and must be at least 8 characters e.g. Ab1cdefg" aria-describedby="passcode_help_text" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" required />
				<span class="form-error">
					Must contain at least one number, one uppercase letter, one lowercase letter, and be at least 8 characters!
				</span> 
			</label>
			<p class="help-text" id="passcode_help_text">Passcode is case sensitive.</p>
			<label for="verify_passcode">Verify your passcode
				<input type="password" id="verify_passcode" title="At least one number, one uppercase, one lowercase, and at least 8 characters long" placeholder="Number, upper, lower and must be at least 8 characters e.g. Ab1cdefg" aria-describedby="verify_help_text" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" required data-equalto="txt_passcode" />
				<span class="form-error">
					Passcodes must match and must contain at least one number, one uppercase letter, one lowercase letter, and be at least 8 characters!
				</span>
			</label>
			<p class="help-text" id="verify_help_text">Passcodes must match and are case sensitive</p>
			<div class="text-center">
				<input type="submit" class="button" name="btn_submit" id="btn_submit" value="Submit" />
			</div>
		</form>
	</div>
	<div class="large-3 medium-3 columns">
		&nbsp;
	</div>
</div>




<?php include_layout_template('vmas_footer.php'); ?>


