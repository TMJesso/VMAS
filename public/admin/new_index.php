<?php
require_once  '/wamp/www/vmas/includes/path.php';

$user = User::get_user_by_id(1); // this will change based on which user is logged in as of right now it is hard coded as 1

$admin = true;
//var_dump($session->is_logged_in($user->security));
$menu = Menu::find_menu_by_user_type($user->user_type);
$menus = Submenu::find_submenu_by_menu_id($menu->id);
?>
<!DOCTYPE html>
	<html>
		<head>
			<title>VMAS :: Theral</title>
			<link href="<?php echo "/vmas/public/css/foundation.css"; ?>" rel="stylesheet" type="text/css" />
			<link href="<?php echo "/vmas/public/css/app.css"; ?>" rel="stylesheet" type="text/css"/>
			<script src="/vmas/public/js/foundation.js"></script>
			<script src="/vmas/public/js/vendor/jquery.min.js"></script>
			<script src="/vmas/public/js/vendor/what-input.min.js"></script>
			<script src="/vmas/public/js/foundation.min.js"></script>
			<script src="/vmas/public/js/app.js"></script>
<!-- 			<script src="/vmas/public/js/jquery.js"></script> -->
		</head>
		<body>
		<h1 class="text-center"><strong>V</strong>ehicle <strong>M</strong>aintenance <strong>A</strong>nd <strong>S</strong>ervice<br/>log</h1>
<?php echo full_screen_foundation(12, 12, 12); ?>
<div class="top-bar" data-responsive-toggle="template" data-hide-for="large">
	<button class="menu-icon" type="button" data-toggle></button>
	<div class="title-bar-title">&nbsp;&nbsp;Menu</div>
</div>
<div class="top-bar" id="template">
	<div class="top-bar-left">
		<ul class="dropdown menu" data-dropdown-menu>
			<li class="menu-text" style="font-size: .83em;"><?php echo  "Admin"; ?></li>
		</ul>
	</div>
	<div class="top-bar-right">
		<ul class="menu" data-responsive-menu="drilldown medium-dropdown">
			<li class="has-submenu">
				<?php foreach($menus as $drop_menu): ?>
					<?php $submenu = Subsubmenu::get_subsubmenu($drop_menu->id, $user->clearance); ?>
					<?php if ($drop_menu->admin==0 || ($admin)) { ?>
						<?php if ($session->get_security() == 9) { ?>
							<li><a href="<?php echo $drop_menu->url; ?>" style="font-size: .83em;" class="button"><?php echo $drop_menu->link_text; ?></a>
								<?php if ($submenu) { ?>
									<ul class="submenu menu vertical" data-submenu>
										<?php foreach ($submenu as $nextmenu) { ?>
											<?php if ($nextmenu->admin==0 || ($admin)) { ?>
												<li><a href="<?php echo $nextmenu->url; ?>" style="font-size: .95em;"><?php echo $nextmenu->link_text; ?></a></li>
											<?php } ?>
										<?php } ?>
									</ul>
								<?php } ?>
							</li>
						<?php } else { ?>
							<li><a href="<?php echo $drop_menu->url; ?>" style="font-size: .83em;" class="button"><?php echo $drop_menu->link_text; ?></a>
							<?php if ($submenu) { ?>
								<ul class="submenu menu vertical" data-submenu>
									<?php foreach ($submenu as $nextmenu): ?>
										<?php if ($nextmenu->admin==0 || ($admin)) { ?>
											<li style="font-size: .95em;"><a href="<?php echo $nextmenu->url; ?>"><?php echo $nextmenu->link_text; ?></a></li>
										<?php } ?>
									<?php endforeach; ?>
								</ul>
							<?php } ?>
							</li>
						<?php } ?>
					<?php } ?>
				<?php endforeach; ?>
			</ul>
		</div>
	</div>
<?php echo end_screen_foundation(); ?>
	<script>
		$(document).foundation();
	</script>
	</body>


</html>


