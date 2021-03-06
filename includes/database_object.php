<?php
// if it's going to need the database, it's
// probably smart to require it before we start.
require_once(LIB_PATH.DS.'database.php');

class DatabaseObject {
	// common database methods
	protected static $db_fields;
	// late static bindings
	
	// http://www.php.net/lsb
	public static function find_by_sql($sql="") {
		global $db;
		$result_set = $db->query($sql);
		$object_array = array();
		while ($row = $db->fetch_array($result_set)) {
			$object_array[] = static::instantiate($row);
		}
		return $object_array;
	}
	
	protected static function instantiate($record) {
		$object = new static;
		// More dynamic, short-form approach:
		foreach($record as $attribute=>$value){
			if($object->has_attribute($attribute)) {
				$object->$attribute = $value;
			}
		}
		return $object;
	}
	
	protected function has_attribute($attribute) {
		// We don't care about the value, we just want to know if the key exists
		// Will return true or false
		return array_key_exists($attribute, $this->attributes());
	}
	
	protected function attributes() {
		// return an array of attribute names and their values
		$attributes = array();
		foreach(static::$db_fields as $field) {
			if(property_exists($this, $field)) {
				$attributes[$field] = $this->$field;
			}
		}
		return $attributes;
	}
	
	protected function sanitized_attributes() {
		global $db;
		$clean_attributes = array();
		// sanitize the values before submitting
		// Note: does not alter the actual value of each attribute
		foreach($this->attributes() as $key => $value) {
			$clean_attributes[$key] = $db->prevent_injection($value);
		}
		return $clean_attributes;
	}
	
	public function save() {
		// A new record won't have an id yet.
		if (!isset($this->year)) {
			$this->year = (int) strftime("%Y",time());
		}
		return isset($this->id) ? $this->update() : $this->create();
	}
	
	public function create() {
		global $db;
		// Don't forget your SQL syntax and good habits:
		// - INSERT INTO table (key, key) VALUES ('value', 'value')
		// - single-quotes around all values
		// - escape all values to prevent SQL injection
		$attributes = $this->sanitized_attributes();
		$sql = "INSERT IGNORE INTO ". static::$table_name." (";
		$sql .= join(", ", array_keys($attributes));
		$sql .= ") VALUES ('";
		$sql .= join("', '", array_values($attributes));
		$sql .= "')";
		if($db->query($sql)) {
			$this->id = $db->insert_id();
			return true;
		} else {
			return false;
		}
	}
	
	public function update() {
		global $db;
		// Don't forget your SQL syntax and good habits:
		// - UPDATE table SET key='value', key='value' WHERE condition
		// - single-quotes around all values
		// - escape all values to prevent SQL injection
		$attributes = $this->sanitized_attributes();
		$attribute_pairs = array();
		foreach($attributes as $key => $value) {
			$attribute_pairs[] = "{$key}='{$value}'";
		}
		$sql = "UPDATE IGNORE ". static::$table_name." SET ";
		$sql .= join(", ", $attribute_pairs);
		$sql .= " WHERE id = ". $db->prevent_injection($this->id);
		$db->query($sql);
		return ($db->affected_rows() == 1) ? true : false;
	}
	
	public function delete() {
		global $db;
		// Don't forget your SQL syntax and good habits:
		// - DELETE FROM table WHERE condition LIMIT 1
		// - escape all values to prevent SQL injection
		// - use LIMIT 1
		$sql  = "DELETE FROM ". static::$table_name;
		$sql .= " WHERE id=". $db->prevent_injection($this->id);
		$sql .= " LIMIT 1";
		$db->query($sql);
		return ($db->affected_rows() == 1) ? true : false;
	
		// NB: After deleting, the instance of User still
		// exists, even though the database entry does not.
		// This can be useful, as in:
		//   echo $user->first_name . " was deleted";
		// but, for example, we can't call $user->update()
		// after calling $user->delete().
	}
	
	
}

?>
