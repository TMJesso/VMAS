<?php
require_once(LIB_PATH.DS.'database.php');
class Activity extends DatabaseObject {
	protected static $table_name = "user_log";
//	protected static $db_fields = array('id', 'user_id', 'user_type', 'date_stamp', 'activity');
	
	public $id;
	public $user_id;
	public $user_type;
	public $date_stamp;
	public $activity;
	
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
	
	// user defined methods
	
	public static function find_by_user_id($id) {
		$sql  = "SELECT * FROM " . self::$table_name;
		$sql .= " WHERE user_id = {$id}";
	}
	
	public static function user_log($id, $activity, $user_type) {
		$obj = new self;
		$obj->user_id = $id;
		$obj->activity = $activity;
		$obj->user_type = $user_type;
		$obj->date_stamp = strftime("%Y-%m-%d %H:%M:%S", strtotime($obj->now(), time()));
		$obj->save();
	}
	
	private function now() {
		return date($this->now_format());
	}
	
	private function now_format() {
		//     "m-d-Y H:i:s"
		//m - month
		//d - day
		//Y - year
		//H - 24 hour
		//i - minutes
		//s - seconds
		return "Y-m-d H:i:s";
	}
	
	// class methods
	
// 	public static function find_by_sql($sql="") {
// 		global $conndb;
// 		$result_set = $conndb->query($sql);
// 		$object_array = array();
// 		while ($row = $conndb->fetch_array($result_set)) {
// 			$object_array[] = self::instantiate($row);
// 		}
// 		return $object_array;
// 	}
	
// 	private static function instantiate($record) {
// 		$object = new self;
// 		// More dynamic, short-form approach:
// 		foreach($record as $attribute=>$value){
// 			if($object->has_attribute($attribute)) {
// 				$object->$attribute = $value;
// 			}
// 		}
// 		return $object;
// 	}
	
// 	private function has_attribute($attribute) {
// 		// We don't care about the value, we just want to know if the key exists
// 		// Will return true or false
// 		return array_key_exists($attribute, $this->attributes());
// 	}
	
// 	protected function attributes() {
// 		// return an array of attribute names and their values
// 		$attributes = array();
// 		foreach(self::$db_fields as $field) {
// 			if(property_exists($this, $field)) {
// 				$attributes[$field] = $this->$field;
// 			}
// 		}
// 		return $attributes;
// 	}
	
// 	protected function sanitized_attributes() {
// 		global $conndb;
// 		$clean_attributes = array();
// 		// sanitize the values before submitting
// 		// Note: does not alter the actual value of each attribute
// 		foreach($this->attributes() as $key => $value){
// 			$clean_attributes[$key] = $conndb->prevent_injection($value);
// 		}
// 		return $clean_attributes;
// 	}
	
// 	public function save() {
// 		// A new record won't have an id yet.
// 		return isset($this->id) ? $this->update() : $this->create();
// 	}
	
// 	public function create() {
// 		global $conndb;
// 		// Don't forget your SQL syntax and good habits:
// 		// - INSERT INTO table (key, key) VALUES ('value', 'value')
// 		// - single-quotes around all values
// 		// - escape all values to prevent SQL injection
// 		$attributes = $this->sanitized_attributes();
// 		$sql = "INSERT INTO ".self::$table_name." (";
// 		$sql .= join(", ", array_keys($attributes));
// 		$sql .= ") VALUES ('";
// 		$sql .= join("', '", array_values($attributes));
// 		$sql .= "')";
// 		if($conndb->query($sql)) {
// 			$this->id = $conndb->insert_id();
// 			return true;
// 		} else {
// 			return false;
// 		}
// 	}
	
// 	public function update() {
// 		global $conndb;
// 		// Don't forget your SQL syntax and good habits:
// 		// - UPDATE table SET key='value', key='value' WHERE condition
// 		// - single-quotes around all values
// 		// - escape all values to prevent SQL injection
// 		$attributes = $this->sanitized_attributes();
// 		$attribute_pairs = array();
// 		foreach($attributes as $key => $value) {
// 			$attribute_pairs[] = "{$key}='{$value}'";
// 		}
// 		$sql = "UPDATE ".self::$table_name." SET ";
// 		$sql .= join(", ", $attribute_pairs);
// 		$sql .= " WHERE id=". $conndb->prevent_injection($this->id);
// 		$conndb->query($sql);
// 		return ($conndb->affected_rows() == 1) ? true : false;
// 	}
	
// 	public function delete() {
// 		global $conndb;
// 		// Don't forget your SQL syntax and good habits:
// 		// - DELETE FROM table WHERE condition LIMIT 1
// 		// - escape all values to prevent SQL injection
// 		// - use LIMIT 1
// 		$sql  = "DELETE FROM ".self::$table_name;
// 		$sql .= " WHERE id=". $conndb->prevent_injection($this->id);
// 		$sql .= " LIMIT 1";
// 		$conndb->query($sql);
// 		return ($conndb->affected_rows() == 1) ? true : false;
	
// 		// NB: After deleting, the instance of User still
// 		// exists, even though the database entry does not.
// 		// This can be useful, as in:
// 		//   echo $user->first_name . " was deleted";
// 		// but, for example, we can't call $user->update()
// 		// after calling $user->delete().
// 	}
	
	
	
	
	
	
	
}
	
	
	