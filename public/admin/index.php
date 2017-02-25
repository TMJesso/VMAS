<?php
require_once  '/wamp/www/vmas/includes/path.php';

// assume I am logged in as admin
// when user login is functioning this will be generated by the session
$security = 0;
//$session->logout();
$user = User::get_user_by_id(1); // this will change based on which user is logged in as of right now it is hard coded as 1
$session->login(attempt_login($user->username, "8F2017-farms", $user), $user->security);
$session->is_logged_in($user->security);
//var_dump($session->is_logged_in($user->security));
$menus = Menu::find_menu_by_user_type($user->user_type);

?>
		<?php include_layout_template('vmas_header.php')?>
		<div class="row">
			<div class="large-12 medium-12 small-12 columns">
				<h1 class="text-center"><vmas>V M A S</vmas></h1>
				<h4 class="text-center"><strong>V</strong>ehicle <strong>M</strong>aintenance and <strong>A</strong>nnual <strong>S</strong>ummary Log</h4>
				
			</div>
		</div>

<!-- MENU -->
<div class="row">
	<div class="large-12 medium-12 small-12 columns">
		<?php echo navigation($menus, $user, $session); ?>
	</div>
</div>
<div class="row">
	<div class="large-3 medium-3 small-2 columns">
		&nbsp;
	</div>
	<div class="large-6 medium-6 small-8 columns">
		<?php echo output_errors($session->errors); ?>
		<?php echo output_message($session->message); ?>
		<h3 class="text-center">Home</h3>
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
		<div class="text-center">



		</div>
	</div>
	<div class="large-3 medium-3 small-2 columns">
		&nbsp;
	</div>
</div>
<?php include_layout_template('vmas_footer.php'); ?>

<?php 

	
	function call_sample() {
		//#0d5e13
		#e9fb68
	}
?>
