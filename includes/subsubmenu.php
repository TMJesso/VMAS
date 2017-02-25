<?php

class Subsubmenu extends DatabaseObject {
	protected static $table_name = "subsubmenu";
// 	protected static $db_fields = array('id', 'submenu_id', 'link_text', 'find_text', 'url', 'position', 'visible', 'security', 'clearance', 'admin');

	public $id;

	public $submenu_id;

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
	
	public static function get_subsubmenu($menu_id=0, $clearance=9) {
		$sql  = "SELECT * FROM " . self::$table_name;
		$sql .= " WHERE submenu_id in ";
		$sql .= " (SELECT id FROM submenu";
		$sql .= " WHERE id = {$menu_id}";
		$sql .= " AND {$clearance} <= clearance)";
		$sql .= " AND visible";
		$sql .= " AND {$clearance} <= clearance";
		$sql .= " ORDER BY position";
		return self::find_by_sql($sql);
	}
	
	public static function find_subsubmenu_by_id($id=0) {
		$sql  = "SELECT * FROM " . self::$table_name;
		$sql .= " WHERE id = {$id}";
		$sql .= " LIMIT 1";
		$result = self::find_by_sql($sql);
		return array_shift($result);
	}
	
	public static function load_subsubmenu() {
		global $db, $code;
		$obj = new self;
		$num = $obj->count_subsubmenu();
		unset($obj);
		
		if ($num == 0 || !$num) {
			$obj = new self;
			$obj->submenu_id = 2; $obj->link_text = "Add / Edit Vehicle"; 		$obj->find_text = "AddCar"; 		$obj->url = "addedit_vehicle.php"; 		$obj->position = 0; $obj->visible = 1; $obj->security = 0; $obj->clearance = 0; $obj->admin = 0;
			$save[$obj->link_text] = $obj->save();
			unset($obj);
			
			$obj = new self;
			$obj->submenu_id = 2; $obj->link_text = "Add Gas"; 					$obj->find_text = "AddGas"; 		$obj->url = "add_gas.php"; 				$obj->position = 1; $obj->visible = 1; $obj->security = 0; $obj->clearance = 0; $obj->admin = 0;
			$save[$obj->link_text] = $obj->save();
			unset($obj);
			
			$obj = new self;
			$obj->submenu_id = 2; $obj->link_text = "Oil Change"; 				$obj->find_text = "OilChange"; 		$obj->url = "oil_change.php"; 			$obj->position = 2; $obj->visible = 1; $obj->security = 0; $obj->clearance = 0; $obj->admin = 0;
			$save[$obj->link_text] = $obj->save();
			unset($obj);
			
			$obj = new self;
			$obj->submenu_id = 2; $obj->link_text = "Repairs"; 					$obj->find_text = "Repairs"; 		$obj->url = "repairs.php"; 				$obj->position = 3; $obj->visible = 1; $obj->security = 0; $obj->clearance = 0; $obj->admin = 0;
			$save[$obj->link_text] = $obj->save();
			unset($obj);
			
			$obj = new self;
			$obj->submenu_id = 3; $obj->link_text = "Miscellaneous"; 			$obj->find_text = "Miscellaneous"; 	$obj->url = "misc.php"; 				$obj->position = 0; $obj->visible = 1; $obj->security = 0; $obj->clearance = 0; $obj->admin = 0;
			$save[$obj->link_text] = $obj->save();
			unset($obj);
			
			$obj = new self;
			$obj->submenu_id = 6; $obj->link_text = "Add / Edit Contacts"; 		$obj->find_text = "AddContacts"; 	$obj->url = "addedit_contact.php"; 		$obj->position = 0; $obj->visible = 1; $obj->security = 0; $obj->clearance = 0; $obj->admin = 0;
			$save[$obj->link_text] = $obj->save();
			unset($obj);
			
			$obj = new self;
			$obj->submenu_id = 7; $obj->link_text = "Backup Database"; 			$obj->find_text = "BackData"; 		$obj->url = "backup_data.php"; 			$obj->position = 0; $obj->visible = 1; $obj->security = 0; $obj->clearance = 0; $obj->admin = 0;
			$save[$obj->link_text] = $obj->save();
			unset($obj);
			
			$obj = new self;
			$obj->submenu_id = 7; $obj->link_text = "Add / Edit Users"; 		$obj->find_text = "AddUsers"; 		$obj->url = "addedit_users.php"; 		$obj->position = 1; $obj->visible = 1; $obj->security = 0; $obj->clearance = 0; $obj->admin = 0;
			$save[$obj->link_text] = $obj->save();
			unset($obj);
			
			$obj = new self;
			$obj->submenu_id = 7; $obj->link_text = "Reset User Passcode"; 		$obj->find_text = "ResetPasscode"; 	$obj->url = "Reset_passcode"; 			$obj->position = 1; $obj->visible = 1; $obj->security = 0; $obj->clearance = 0; $obj->admin = 0;
			$save[$obj->link_text] = $obj->save();
			unset($obj);
			
			$obj = new self;
			$obj->submenu_id = 5; $obj->link_text = "Add / Edit Event"; 		$obj->find_text = "AddEvent"; 		$obj->url = "addedit_event.php"; 		$obj->position = 0; $obj->visible = 1; $obj->security = 0; $obj->clearance = 0; $obj->admin = 0;
			$save[$obj->link_text] = $obj->save();
			unset($obj);
			
			$obj = new self;
			$obj->submenu_id = 5; $obj->link_text = "Show Scheduled Events"; 	$obj->find_text = "ShowEvent";		$obj->url = "show_event.php";			$obj->position = 1; $obj->visible = 1; $obj->security = 0; $obj->clearance = 0; $obj->admin = 0;
			$save[$obj->link_text] = $obj->save();
			unset($obj);
			
			$obj = new self;
			$obj->submenu_id = 4; $obj->link_text = "Vendor Report"; 			$obj->find_text = "VendReport";		$obj->url = "vend_report.php"; 			$obj->position = 1; $obj->visible = 1; $obj->security = 0; $obj->clearance = 0; $obj->admin = 0;
			$save[$obj->link_text] = $obj->save();
			unset($obj);
			
			$obj = new self;
			$obj->submenu_id = 4; $obj->link_text = "Add / Edit Vendors"; 		$obj->find_text = "AddVendors"; 	$obj->url = "addedit_vendors.php"; 		$obj->position = 0; $obj->visible = 1; $obj->security = 0; $obj->clearance = 0; $obj->admin = 0;
			$save[$obj->link_text] = $obj->save();
			unset($obj);
			
			foreach ($save as $item => $value) {
				if (!$value) {
					$code[strtolower($item)][($value) ? 1 : 0] = (($value) ? "{$item} was successfully Saved" : "There was an error saving {$item} submenu item");
				}
			}
		} else {
				$code['Subsubmenu_items'][0] = "Submenu table is already populated with data so I cannot add to it!";
			}
			$db->table_messages($code, "Subsubmenu");
	}
		
	private function count_subsubmenu() {
		global $db;
		$sql = "SELECT COUNT(*) FROM " . self::$table_name;
		$result_set = $db->query($sql);
		$row = ($result_set) ? $db->fetch_array($result_set) : false;
		return ($row) ? array_shift($row) : false;
	}
}
