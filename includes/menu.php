<?php

class Menu extends DatabaseObject {
	protected static $table_name = "menu";
//	protected static $db_fields = array('id', 'link_text', 'find_text', 'url', 'visible', 'user_type');
	
	public $id;
	
	public $link_text;
	
	public $find_text;
	
	public $url;
	
	public $visible;
	
	public $user_type;
	
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
	
	public static function find_menu_by_user_type($user=9) {
		$sql  = "SELECT * FROM " . self::$table_name;
		$sql .= " WHERE user_type = {$user}";
		return self::find_by_sql($sql);

	}
	
	public static function load_menu() {
		global $db;
		$obj = new self;
		$num = $obj->count_menu();
		unset($obj);
		$code = "";
		$obj = new self;
		if ($num == 0 || !$num) {
			$obj->link_text = 'Admin';
			$obj->find_text = 'Admin';
			$obj->url = 'index.php';
			$obj->visible = 1;
			$obj->user_type = 0;
			if ($value = $obj->save()) {
				$code[$obj->find_text][$value] = "Admin has been loaded";
			} else {
				$code[$obj->find_text][$value] = "Admin Save was rejected and NOT loaded";
			}
			
			unset($obj);
			$obj = new self;
			$obj->link_text = 'Public';
			$obj->find_text = 'Public';
			$obj->url = 'index.php';
			$obj->visible = 1;
			$obj->user_type = 9;
			if ($value = $obj->save()) {
				$code[$obj->find_text][$value] = "Menu data has been loaded";
			} else {
				$code[$obj->find_text][$value] = "Menu Save was rejected and NOT loaded";
			}
			unset($obj);
		} else {
			$code["Menu"][0] = "There is already data in table! I cannot load any more!";
		}
		$db->table_messages($code, "Menu");
		unset($code);
	}
	
	private function count_menu() {
		global $db;
		$sql = "SELECT COUNT(*) FROM " . self::$table_name;
		$result_set = $db->query($sql);
		$row = ($result_set) ? $db->fetch_array($result_set) : false;
		return ($row) ? array_shift($row) : false;
	}
}

?>