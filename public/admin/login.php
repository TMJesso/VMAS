<?php
require_once  "../../includes/path.php";


if (isset($_POST["submit"])) {
	$username = $db->prevent_injection(trim($_POST["username"]));
	$password = $db->prevent_injection(trim($_POST["passcode"]));
	
	$user = User::get_user_by_username($username);
	$founduser = attempt_login($username, $password, $user);
	
	if ($founduser) {
		$loggedin = $session->login($founduser);
		if (!$founduser->confirm && $loggedin) {
			$founduser->confirm = 1;
			$founduser->save();
		}
		//TODO make it redirect to change passcode page
		redirect_to('index.php');
	} else {
		$errors['Login'] = "Username and/or password combination incorrect... please try again!";
		$session->errors($errors);
		redirect_to("login.php");
	}
}
?>

<?php include_layout_template('vmas_header.php'); ?>
<div class="row">
	<div class="large-3 medium-3 small-2 columns">
		&nbsp;
	</div>
	<div class="large-6 medium-6 small-8 columns">
		<?php echo output_errors($session->errors); ?>
		<?php echo output_message($session->message); ?>
	</div>
	<div class="large-3 medium-3 small-2 columns">
		&nbsp;
	</div>
</div>
<div class="row">
	<div class="large-3 medium-3 small-2 columns">
		&nbsp;
	</div>
	<div class="large-6 medium-6 small-8 columns">
		<form data-abide novalidate method="post" action="login.php">
			<div data-abide-error class="alert callout" style="display: none;">
				<p><i class="fi-alert"></i> There are some errors in your form.</p>
			</div>
			<label for="username">Username
				<input type="text" name="username" id="username" value="" placeholder="Appleseed (username is case sensitive)">
				<span class="form-error">
					You must enter a username!
				</span>
			</label>
			<label for="passcode">Password
				<input type="password" name="passcode" id="passcode" 
				pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" 
				title="At least one number, one uppercase, one lowercase, and at least 8 characters long"
				placeholder="Number, upper, lower and must be at least 8 characters e.g. Ab1cdefg" aria-describedby="desc_passcode">
				<span class="form-error">
					Must contain at least one number, one uppercase letter, one lowercase letter, and be at least 8 characters!
				</span>
			</label>
			<p class="help-text text-center" id="desc_passcode">At least one uppercase, lowercase, one number, and at least 8 characters long!</p>
			<!-- pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="Must contain at least one number and one uppercase and lowercase letter, and at least 8 or more characters" -->
			<!--submit form or clear form-->
			
			<div class="text-center">
				<input type="submit" name="submit" value="Submit" class="button round" />
			</div>
		</form>
		<br/>
		<br/>
	</div>
	<div class="large-3 medium-3 small-2 columns">
		&nbsp;
	</div>
</div>

<?php include_layout_template('vmas_footer.php'); ?>
