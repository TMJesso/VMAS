<?php

class Vehicle extends DatabaseObject {
	protected static $table_name = "vehicle";
	
	public $id;
	
	public $user_id;
	
	public $name;
	
	public $make;
	
	public $model;
	
	public $year;
	
	public $color;
	
	public $vin;
	
	public $plate;
	
	public $state;
	
	public $purchased;
	
	public $cost;
	
	public $dealer_id;
	
	public $start_miles;
	
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
	
	public static function find_all_cars_by_user_id($id) {
		$sql  = "SELECT * FROM " . self::$table_name;
		$sql .= " WHERE user_id = {$id}";
		return self::find_by_sql($sql);
	}
	
	public static function find_car_by_id($id) {
		$sql  = "SELECT * FROM " . self::$table_name;
		$sql .= " WHERE id = {$id}";
		$results = self::find_by_sql($sql);
		return array_shift($results);
	}
	
	public static function find_car_by_vin($vin) {
		$sql  = "SELECT * FROM " . self::$table_name;
		$sql .= " WHERE vin = '{$vin}'";
		$sql .= " LIMIT 1";
		$results = self::find_by_sql($sql);
		return array_shift($results);
	}
	
	
	public static function load_car() {
		$new_obj = new self;
		$new_obj->add_car();
	}
	
	private function add_car() {
		global $db;
		$obj = new self;
		$num = $obj->count_car();
		unset($obj);
		$code = "";
		$obj = new self;
		if ($num == 0 || !$num) {
			$obj->user_id = 1; $obj->name = "Test"; $obj->make = "Chevrolet"; $obj->model = "Sonic"; $obj->year = 2012; $obj->color = "Red"; $obj->vin = "kasljaffjkdlsa"; $obj->plate = "RMA687"; $obj->state = "IN"; $obj->purchased = datetime_to_text("May 31, 2015 14:30:00"); $obj->cost = 7000.00; $obj->dealer_id = 1; $obj->start_miles = 114000;
			if ($value = $obj->save()) {
				$code[$obj->model][$value] = "Vehicle data has been loaded";
			} else {
				$code[$obj->model][$value] = "Vehicle Save was rejected and NOT loaded";
			}
			unset($obj);
		} else {
			$code["Vehicle"][0] = "There is already data in table! I cannot load any more!";
		}
		$db->table_messages($code, "Vehicle");
		unset($code);
	}
	
	private function count_car() {
		global $db;
		$sql = "SELECT COUNT(*) FROM " . self::$table_name;
		$result_set = $db->query($sql);
		$row = ($result_set) ? $db->fetch_array($result_set) : false;
		return ($row) ? array_shift($row) : false;
	}
}

?>