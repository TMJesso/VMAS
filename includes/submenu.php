<?php

class Submenu extends DatabaseObject {
	protected static $table_name = "submenu";
// 	protected static $db_fields = array('id', 'menu_id', 'link_text', 'find_text', 'url', 'position', 'visible', 'security', 'clearance', 'admin');
	
	public $id;
	
	public $menu_id;
	
	public $link_text;
	
	public $find_text;
	
	public $url;
	
	public $position;
	
	public $visible;
	
	public $security;
	
	public $clearance;
	
	public $admin;
	
	function __construct() {
		global $db;
		$sql  = "SELECT * FROM " . self::$table_name;
		$sql .= " LIMIT 1";
		$result_set = $db->query($sql);
		$fields = $db->fetch_fields($result_set);
		foreach ($fields as $field) {
			static::$db_fields[] = "{$field->name}";
		}
		
	}
	
	public static function find_submenu_by_menu_id($id, $admin=9) {
		$sql  = "SELECT * FROM " . self::$table_name;
		$sql .= " WHERE menu_id = {$id}";
		if ($admin != 9) {
			if ($admin) {
				$sql .= " AND admin < 2";
			} else {
				$sql .= " AND NOT admin";
			}
		}
		return self::find_by_sql($sql);
	}
	
	public static function find_submenu_by_id($id) {
		$sql  = "SELECT * FROM " . self::$table_name;
		$sql .= " WHERE id = {$id}";
		$results = self::find_by_sql($sql);
		return array_shift($results);
	}
	
	public static function find_submenu_by_url($url) {
		$sql  = "SELECT * FROM " . self::$table_name;
		$sql .= " WHERE url = '{$url}'";
		$results = self::find_by_sql($sql);
		return array_shift($results);
	}
	
	public static function load_submenu() {
		$new_obj = new self;
		$new_obj->add_submenu_items();
	}
	
	private function add_submenu_items() {
		global $db, $code;
		
		$obj = new self;
		$num = $obj->count_submenu();
		unset($obj);
		
		//TODO consider changing the url for the submenus to # except for Home, Logout
		if ($num == 0 || !$num) {
			$obj = new self;
			$obj->link_text = 'Home'; $obj->menu_id = 1; $obj->find_text = 'Home';	$obj->url = 'index.php'; $obj->position = 0; $obj->visible = 1;	$obj->security = 9; $obj->clearance = 0; $obj->admin = 0;
			$save[$obj->find_text] = $obj->save();
// 			$obj->url .= "?m={$obj->menu_id}&s={$obj->id}";
// 			$obj->save();
			unset($obj);
			
			$obj = new self;
			$obj->link_text = 'Vehicle'; $obj->menu_id = 1; $obj->find_text = 'Car';	$obj->url = 'car.php'; $obj->position = 1; $obj->visible = 1; $obj->security = 0; $obj->clearance = 1; $obj->admin = 0;
			$save[$obj->find_text] = $obj->save();
// 			$obj->url .= "?m={$obj->menu_id}&s={$obj->id}";
// 			$obj->save();
			unset($obj);

			$obj = new self;
			$obj->link_text = 'Other Expenses'; $obj->menu_id = 1; $obj->find_text = 'OE';	$obj->url = 'expenses.php'; $obj->position = 2; $obj->visible = 1; $obj->security = 0; $obj->clearance = 1; $obj->admin = 0;
			$save[$obj->find_text] = $obj->save();
// 			$obj->url .= "?m={$obj->menu_id}&s={$obj->id}";
// 			$obj->save();
			unset($obj);

			$obj = new self;
			$obj->link_text = 'Vendors'; $obj->menu_id = 1; $obj->find_text = 'Vendors';	$obj->url = 'vendors.php'; $obj->position = 3; $obj->visible = 1; $obj->security = 0; $obj->clearance = 1; $obj->admin = 0;
			$save[$obj->find_text] = $obj->save();
// 			$obj->url .= "?m={$obj->menu_id}&s={$obj->id}";
// 			$obj->save();
			unset($obj);

			$obj = new self;
			$obj->link_text = 'Events'; $obj->menu_id = 1; $obj->find_text = 'Events';	$obj->url = 'events.php'; $obj->position = 4; $obj->visible = 1; $obj->security = 0; $obj->clearance = 1; $obj->admin = 0;
			$save[$obj->find_text] = $obj->save();
// 			$obj->url .= "?m={$obj->menu_id}&s={$obj->id}";
// 			$obj->save();
			unset($obj);
			
			$obj = new self;
			$obj->link_text = 'Contacts'; $obj->menu_id = 1; $obj->find_text = 'Contacts';	$obj->url = 'contacts.php'; $obj->position = 5; $obj->visible = 1; $obj->security = 0; $obj->clearance = 1; $obj->admin = 0;
			$save[$obj->find_text] = $obj->save();
// 			$obj->url .= "?m={$obj->menu_id}&s={$obj->id}";
// 			$obj->save();
			unset($obj);
			
			$obj = new self;
			$obj->link_text = "System"; $obj->menu_id = 1; $obj->find_text = "System"; $obj->url = "system.php"; $obj->position = 6; $obj->visible = 1; $obj->security = 0; $obj->clearance = 0; $obj->admin = 1;
			$save[$obj->find_text] = $obj->save();
// 			$obj->url .= "?m={$obj->menu_id}&s={$obj->id}";
// 			$obj->save();
			unset($obj);
			
			$obj = new self;
			$obj->link_text = 'Logout'; $obj->menu_id = 1; $obj->find_text = 'Logout';	$obj->url = 'logout.php'; $obj->position = 9; $obj->visible = 1; $obj->security = 0; $obj->clearance = 9; $obj->admin = 0;
			$save[$obj->find_text] = $obj->save();
			unset($obj);

			$obj = new self;
			$obj->link_text = 'Home'; $obj->menu_id = 2; $obj->find_text = 'Index';	$obj->url = 'public/index.php'; $obj->position = 0; $obj->visible = 1; $obj->security = 0; $obj->clearance = 0; $obj->admin = 0;
			$save[$obj->find_text] = $obj->save();
// 			$obj->url .= "?m={$obj->menu_id}&s={$obj->id}";
// 			$obj->save();
			unset($obj);

			$obj = new self;
			$obj->link_text = 'Login'; $obj->menu_id = 2; $obj->find_text = 'Login';	$obj->url = 'public/login.php'; $obj->position = 1; $obj->visible = 1; $obj->security = 0; $obj->clearance = 0; $obj->admin = 0;
			$save[$obj->find_text] = $obj->save();
			unset($obj);
			
			foreach ($save as $item => $value) {
				if (!$value) {
					$code[strtolower($item)][($value) ? 1 : 0] = (($value) ? "{$item} was successfully Saved" : "There was an error saving {$item} submenu item");
				}
			}
		} else {
			$code['Submenu_items'][0] = "Submenu table is already populated with data so I cannot add to it!";
		}
		$db->table_messages($code, "Submenu");
	}
	
	private function count_submenu() {
		global $db;
		$sql = "SELECT COUNT(*) FROM " . self::$table_name;
		$result_set = $db->query($sql);
		$row = ($result_set) ? $db->fetch_array($result_set) : false;
		return ($row) ? array_shift($row) : false;
	}
}

?>