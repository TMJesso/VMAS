<?php 

function attempt_login($username, $password, $found_user) {
	if ($found_user) {
		// found user, now check password
		if (password_check($password, $found_user->passcode)) {
			// password matches
			return $found_user;
		} else {
			// password does not match
			return false;
		}
	} else {
		// user not found
		return false;
	}
}

function password_check($password, $existing_hash) {
	// existing hash contains format and salt at start
	$hash = crypt($password, $existing_hash);
	if ($hash === $existing_hash) {
		return true;
	} else {
		return false;
	}
}
function new_row_foundation() {
	?>
<div class="row">
<?php 
}

function full_screen_foundation($large, $medium, $small) {
	?>
	<div class="large-<?php echo $large; ?> medium-<?php echo $medium; ?> small-<?php echo $small;?>">
	
	<?php 
}

function end_screen_foundation() {
	?>
	</div>
</div>
<?php 
}

function end_single_foundation() {
	?>
	</div>
<?php 
}

function strip_zeros_from_date( $marked_string = "") {
	// first remove the marked zeros
	$no_zeros = str_replace('*-', '', $marked_string);
	// then remove any remaining marks
	$cleaned_string = str_replace('*', '', $no_zeros);
	return $cleaned_string;
}

function redirect_to($location = null) {
	if ($location != null) {
		header("Location: {$location}");
		exit;
	}
}

function output_message($message="") {
	if (!empty($message)) {
		return "<br/><div class=\"success callout text-center\"><h4>{$message}</h4></div>";
	} else {
		return "";
	}
}

function output_errors($errors="") {
	if (!empty($errors)) {
		return "<br/><div class=\"alert callout text-center\"><h4>{$errors}</h4></div>";
	} else {
		return "";
	}
}

function __autoload($class_name) {
	$class_name = strtolower($class_name);
	switch ($class_name) {
		case "user":
			$path = LIB_PATH.DS."{$class_name}.php";
			path_exists($path, $class_name);
			break;
		
		case "menu":
			$path = LIB_PATH.DS."{$class_name}.php";
			path_exists($path, $class_name);
			break;
			
		case "subject":
			$path = LIB_PATH.DS."{$class_name}s.php";
			path_exists($path, $class_name);
			break;
			
		case "page":
			$path = LIB_PATH.DS."{$class_name}s.php";
			path_exists($path, $class_name);
			break;
			
		case "photo":
			$path = LIB_PATH.DS."{$class_name}.php";
			path_exists($path, $class_name);
			break;
		
		case "database_object":
			$path = LIB_PATH.DS."{$class_name}.php";
			path_exists($path, $class_name);
			break;
				
	}
}

function path_exists($path, $class) {
	if (file_exists($path)) {
		require_once($path);
	} else {
		die("The file {$class}.php could not be found.");
	}
	return;
}

function include_layout_template($template="") {
	//
	//

	include(LIB_LAYOUT.$template);
}

function log_action($action, $message="") {
	$logfile = SITE_ROOT.DS.'logs'.DS.'log.txt';
	$new = file_exists($logfile) ? false : true;
	if ($handle = fopen($logfile, 'a')) { // append
		$timestamp = strftime("%Y-%m-%d %H:%M:%S", time());
		$content = "{$timestamp} | {$action}: {$message}\n";
		fwrite($handle, $content);
		fclose($handle);
		if ($new) { chmod($logfile, 0755); }
	} else {
		echo "Could not open log file for writing.";
	}
}

function datetime_to_text($datetime="") {
	$unixdatetime = strtotime($datetime);
	return strftime("%B %d, %Y at %I:%M %p", $unixdatetime);
}

function oldbreadcrumb($subject_array, $page_array, $subject, $pages, $visible) {
	global $breadcum;
	$menus = $subject->find_all_subjects($visible);
	if (isset($_GET["m"]) ) {
		$breadcrum = "<ul class=\"breadcrumbs\"><li><a href=\"index.php\">Admin</a></li> <li class=\"disabled\">Content</li>";
	} else {
		$breadcrum = "<ul class=\"breadcrumbs\">";
		if (is_null($subject_array) && is_null($page_array)) {
			$breadcrum .= "<li class=\"disabled\">Admin</li>";
		}
	}
	foreach ($menus as $menu):
		if ($subject_array && $menu->id == $subject_array->id) {
			$breadcrum .= "<li><a href=\"index.php\">Admin</a></li>  <li><a href=\"manage_content.php?m=1\">Content</a></li>  <li class=\"disabled\">{$menu->menu_name}</li>";
		}
		$selected_pages = $pages->find_pages_for_subject($menu->id);
		foreach ($selected_pages as $page):
		if ($page_array && $page->id == $page_array->id) {
			$breadcrum .= "<li><a href=\"index.php\">Admin</a></li> <li><a href=\"manage_content.php?m=1\">Content</a></li> <li><a href=\"{$menu->loc}\">{$menu->menu_name}</a></li> <li class=\"disabled\">{$page->menu_name}</li>";
		}
		endforeach;
	endforeach;
	$breadcrum .= " </ul>";
	return $breadcrum;
}

function get_breadcrumb() {
	$filename = $_SERVER["SCRIPT_NAME"];
	$menu_id = $submenu_id = $subsubmenu_id = null;
	$new_name = true;
	while ($new_name ) {
		if ((strpos($filename, "/") > -1)) {
		} else {
			$new_name = false;
			continue;
		}
		$filename = substr($filename, (strpos($filename, "/"))+1);
	}
	$menu = Menu::find_menu_by_url($filename);
	if (!$menu) {
	$submenu = Submenu::find_submenu_by_url($filename);
	if (!$submenu) {
		$subsubmenu = Subsubmenu::find_subsubmenu_by_url($filename);
		$submenu_id = null;
		if (!$subsubmenu) {
			$subsubmenu = null;
		} else {
			$submenu = Submenu::find_submenu_by_id($subsubmenu->submenu_id);
			$menu = Menu::find_menu_by_id($submenu->menu_id);
			$subsubmenu_id = $subsubmenu->id;
			$submenu_id = $submenu->id;
			$menu_id = $menu->id;
		}
	} else {
		$menu = Menu::find_menu_by_id($submenu->menu_id);
		$submenu_id = $submenu->id;
		$menu_id = $menu->id;
	}
	} else {
		$menu_id = $menu->id;
		$submenu_id = null;
		$subsubmenu_id = null;
	}
	breadcrumbs($menu_id, $submenu_id, $subsubmenu_id, $filename);
}

function breadcrumbs($menu_id=null, $submenu_id=null, $subsubmenu_id=null, $filename="") {
	global $breadcrumbs, $db, $header;
	

	
	//$header = "Menu: {$menu_id} Submenu: {$submenu_id} Subsubmenu: {$subsubmenu_id} File: " . $filename;
	//return;
	$safe_menu_id = $db->prevent_injection($menu_id);
	$safe_submenu_id = $db->prevent_injection($submenu_id);
	$safe_subsubmenu_id = $db->prevent_injection($subsubmenu_id);
	$breadcrumbs = "<ul class=\"breadcrumbs\">";
	if (!is_null($menu_id)) {
		$menu = Menu::find_menu_by_id($safe_menu_id);
		if (is_null($submenu_id)) {
			$breadcrumbs .= "<li class=\"disabled\">{$menu->link_text}</li>";
			$header = $menu->link_text;
		} else {
			$breadcrumbs .= "<li><a href=\"{$menu->url}\">{$menu->link_text}</a></li>";
		}
		if (!is_null($submenu_id)) {
			$submenu = Submenu::find_submenu_by_id($safe_submenu_id);
			if (is_null($subsubmenu_id)) {
				$breadcrumbs .= "<li class=\"disabled\">{$submenu->link_text}</li>";
				$header = $submenu->link_text;
			} else {
				$breadcrumbs .= "<li><a href=\"{$submenu->url}\">{$submenu->link_text}</a></li>";
			}
			if (!is_null($subsubmenu_id)) {
				$subsubmenu = Subsubmenu::find_subsubmenu_by_id($safe_subsubmenu_id);
				$breadcrumbs .= "<li class=\"disabled\">{$subsubmenu->link_text}</li>";
				$header = $subsubmenu->link_text;
			}
		}
	} else {
		$breadcrumbs .= "";
	}
	$breadcrumbs .= "</ul>";
}

function navigation() {
	global $session;
	$user = User::get_user_by_id($session->user_id);
	$menus = Menu::find_menu_by_user_type($user->user_type);
	$admin = $session->is_master();
	$output = "<div class=\"top-bar\" data-responsive-toggle=\"main-menu\" data-hide-for=\"large\">";
	$output .= "<button class=\"menu-icon\" type=\"button\" data-toggle></button>";
	$output .= "<div class=\"title-bar-title\">&nbsp;&nbsp;Menu</div>";
	$output .= "</div>";
	$output .= "<div class=\"top-bar\" id=\"main-menu\">";
	foreach ($menus as $menu) {
		$submenus =  Submenu::find_submenu_by_menu_id($menu->id);
		$output .= "<div class=\"top-bar-left\">";
		$output .= "<ul class=\"dropdown menu\" data-dropdown-menu>";
		$output .= "<li class=\"menu-text\" style=\"font-size: .83em;\"><span style=\"font-size: 175%; color: #004000;\">V M A S</span> : {$menu->link_text}</li>";
		$output .= "</ul></div>";
		$output .= "<div class=\"top-bar-right\">";
		$output .= "<ul class=\"menu\" data-responsive-menu=\"drilldown medium-dropdown\">";
		$output .= "<li class=\"has-submenu\">";
		foreach($submenus as $drop_menu) {
			$subsubmenu = Subsubmenu::get_subsubmenu($drop_menu->id, $user->clearance);
			if ($drop_menu->admin==0 || ($admin)) {
				if ($session->get_security() == 9) {
					$output .= "<li><a href=\"{$drop_menu->url}\" style=\"font-size: .83em;\" class=\"button\">{$drop_menu->link_text}</a>";
					if ($subsubmenu) {
						$output .= "<ul class=\"submenu menu vertical\" data-submenu>";
						foreach ($subsubmenu as $nextmenu) {
							if ($nextmenu->admin==0 || ($admin)) {
								$output .= "<li><a href=\"{$nextmenu->url}\" style=\"font-size: .95em;\">{$nextmenu->link_text}</a></li>";
							}
						}
						$output .= "</ul>";
					}
					$output .= "</li>";
				} else {
					$output .= "<li><a href=\"{$drop_menu->url}\" style=\"font-size: .83em;\" class=\"button\">{$drop_menu->link_text}</a>";
					if ($subsubmenu) {
						$output .= "<ul class=\"submenu menu vertical\" data-submenu>";
						foreach ($subsubmenu as $nextmenu) {
							if ($nextmenu->admin==0 || ($admin)) {
								$output .= "<li style=\"font-size: .95em;\"><a href=\"{$nextmenu->url}\">{$nextmenu->link_text}</a></li>";
							}
						}
						$output .= "</ul>";
					}
					$output .= "</li>";
				}
			}
		}
		$output .= "</ul></div>";
	}
	$output .= "</div>";
	return $output;
}

/** navigation takes 2 arguments
 * 
 * - the current subject array or null
 * 
 * - the current page array or null
 */
 function old_navigation($subject_array, $page_array, $subject, $pag_es, $visible) {
	
	$output  = "<ul class=\"subjects\">";
	$menus = $subject->find_all_subjects($visible);
	foreach ($menus as $menu):
		if ($menu->level == 2) {
			$output .= "<br/>";
		}
		$output .= "<li";
		/* Don't need this because of style in the <a> tag on line 168
		if ($subject_array && $menu->id == $subject_array->id) {
			$output .= " style=\"color: red;\""; // 
		}
		*/
		$output .= ">"; 
		
		$output .= "<a href=\"manage_content.php?subject=";
		$output .= urlencode($menu->id);
		$output .= "\"";
		if ($subject_array && $menu->id == $subject_array->id) { 
			$output .= " style=\"color: red; background-color: yellow;\""; // 
		}
		$output .= ">";
		if ($subject_array && $menu->id == $subject_array->id) {
			$output .= "&NestedLessLess; {$menu->menu_name} &NestedGreaterGreater;"; 
		} else {
			$output .= $menu->menu_name;
		}
		$output .= "</a></li>";
		$pages = $pag_es->find_pages_for_subject($menu->id);
		$output .= "<ul class=\"pages\">";
		foreach ($pages as $page):
			if ($page->level == 2) {
				$output .= "<br/>";
			}
			$output .= "<li";
			if ($page_array && $page->id == $page_array->id) {
				$output .= " class=\"selected\"";
			}
			$output .= ">";
			$output .= "<a href=\"manage_content.php?page=";
			$output .= urldecode($page->id);
			$output .= "\"";
			if ($page_array && $page->id == $page_array->id) {
				$output .= " style=\"color: red; background-color: yellow; font-size: 0.80em;\""; 
			}
			$output .= ">";
			if ($page_array && $page->id == $page_array->id) {
				$output .= "&NestedLessLess; {$page->menu_name} &NestedGreaterGreater;"; 
			} else {
				$output .= "{$page->menu_name}"; 
			} 
			$output .= "</a></li>";
		endforeach;
		$output .= "</ul>";
	endforeach;
	$output .= "</ul>";
	return $output;
}

function password_encrypt($password) {
	$hash_format = "$2y$10$";   // Tells PHP to use Blowfish with a "cost" of 10
	$salt_length = 22; 					// Blowfish salts should be 22-characters or more
	$salt = generate_salt($salt_length);
	$format_and_salt = $hash_format . $salt;
	$hash = crypt($password, $format_and_salt);
	return $hash;
}

function generate_salt($length) {
	// Not 100% unique, not 100% random, but good enough for a salt
	// MD5 returns 32 characters
	$unique_random_string = md5(uniqid(mt_rand(), true));

	// Valid characters for a salt are [a-zA-Z0-9./]
	$base64_string = base64_encode($unique_random_string);

	// But not '+' which is valid in base64 encoding
	$modified_base64_string = str_replace('+', '.', $base64_string);

	// Truncate string to the correct length
	$salt = substr($modified_base64_string, 0, $length);

	return $salt;
}

?>
