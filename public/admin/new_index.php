<?php require_once  $_SERVER['DOCUMENT_ROOT'] . '/includes/path.php';

$user = User::get_user_by_id(1); // this will change based on which user is logged in as of right now it is hard coded as 1

$admin = true;
//var_dump($session->is_logged_in($user->security));
$menus = Menu::find_menu_by_user_type($user->user_type);
//$menus = Submenu::find_submenu_by_menu_id($menu->id);
?>
<!DOCTYPE html>
	<html>
		<head>
			<title>VMAS :: Theral</title>
			<link href="<?php echo CSS_PATH . "foundation.css"; ?>" rel="stylesheet" type="text/css" />
			<link href="<?php echo CSS_PATH . "app.css"; ?>" rel="stylesheet" type="text/css"/>
<!-- 			<script src="/vmas/public/js/jquery.js"></script> -->
		</head>
		<body>
		<h1 class="text-center"><strong>V</strong>ehicle <strong>M</strong>aintenance <strong>A</strong>nd <strong>S</strong>ervice<br/>log</h1>
<?php echo full_screen_foundation(12, 12, 12); ?>
<?php echo navigation($menus, $user, $session)?>
<?php echo end_screen_foundation(); ?>
	<script src="<?php echo JS_PATH; ?>vendor/jquery.js"></script>
	<script src="<?php echo JS_PATH; ?>vendor/what-input.min.js"></script>
	<script src="<?php echo JS_PATH; ?>vendor/foundation.js"></script>
	<script src="<?php echo JS_PATH; ?>app.js"></script>
	<script>
		$(document).foundation();
	</script>
	</body>


</html>


