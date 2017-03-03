<?php
class Dealer extends DatabaseObject {
	protected static $table_name = "dealer";
	
	public $id;
	
	public $vehicle_id;
	
	public $user_id;
	
	public $name;
	
	public $address;
	
	public $city;
	
	public $state;
	
	public $zip;
	
	public $phone;
	
	public $salesman;
	
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
	
	public static function find_by_dealer_id($id, $user_id) {
		$sql  = "SELECT * FROM " . self::$table_name;
		$sql .= " WHERE id = {$id}";
		$sql .= " LIMIT 1";
		$results = self::find_by_sql($sql);
		return array_shift($results);
	}
	
	public static function find_by_vehicle_id($id, $user_id) {
		$sql  = "SELECT * FROM " . self::$table_name;
		$sql .= " WHERE vehicle_id = {$id}";
		$sql .= " LIMIT 1";
		$results = self::find_by_sql($sql);
		return array_shift($results);
	}
	
	public static function find_by_name($user_id) {
		$sql  = "SELECT * FROM " . self::$table_name;
		$sql .= " WHERE user_id = {$user_id}";
		$sql .= " ORDER BY name";
		return self::find_by_sql($sql);
	}
	
	public static function load_dealer() {
		$obj = new self;
		$obj->add_dealer();
	}
	
	private function add_dealer() {
		global $db;
		$obj = new self;
			$num = $obj->count_car();
		unset($obj);
		$code = "";
		$obj = new self;
		if ($num == 0 || !$num) {
			$obj->user_id = 1; $obj->name = $db->prevent_injection("Erick's Chevrolet"); $obj->vehicle_id = 1; $obj->address = "Hoffer"; $obj->city = "Kokomo"; $obj->state = "IN"; $obj->zip = "46902"; $obj->phone = "7655555555"; $obj->salesman = "Bob";
			if ($value = $obj->save()) {
				$code[$obj->name][$value] = "Dealer data has been loaded";
			} else {
				$code[$obj->model][$value] = "Dealer Save was rejected and NOT loaded";
			}
			unset($obj);
		} else {
			$code["Vehicle"][0] = "There is already data in table! I cannot load any more!";
		}
		$db->table_messages($code, "Dealer");
		unset($code);
	
	}
	
	private function count_dealer() {
		global $db;
		$sql = "SELECT COUNT(*) FROM " . self::$table_name;
		$result_set = $db->query($sql);
		$row = ($result_set) ? $db->fetch_array($result_set) : false;
		return ($row) ? array_shift($row) : false;
	}
	
	
}