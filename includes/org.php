<?php
class Org extends DatabaseObject {
	protected static $table_name = 'organization';
	
	public $id;
	
	public $name;
	
	public $address;
	
	public $city;
	
	public $state;
	
	public $zip;
	
	public $phone;
	
	public $contact_name;
	
	
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
	
	public function get_organization_by_id($id) {
		$sql  = "SELECT * FROM " . self::$table_name;
		$sql .= " WHERE id = {$id}";
		$row = self::find_by_sql($sql);
		return array_shift($row);
	}
	
	public function get_organization_by_name($name) {
		$sql  = "SELECT * FROM " . self::$table_name;
		$sql .= " WHERE name = '{$name}'";
		$sql .= " LIMIT 1";
		$row = self::find_by_sql($sql);
		return array_shift($row);
	}
	
	public static function load_organization() {
		$obj = new self;
		$obj->generate_organization();
	}
	
	private function generate_organization() {
		global $db, $code;
		
		$obj = new self;
		$num = $obj->count_org();
		unset($obj);
		
		if ($num == 0 || !$num) {
			$obj = new self;
			$obj->name = "Development Team";
			$obj->address = "Somewhere 123 Drive";
			$obj->city = "Kokomo";
			$obj->state = "IN";
			$obj->zip = "46901";
			$obj->phone = "5555555555";
			$obj->contact_name = "Theral Jessop";
			$save[$obj->name] = $obj->save();
			
			foreach ($save as $item => $value) {
				if (!$value) {
					$code[strtolower($item)][($value) ? 1 : 0] = (($value) ? "{$item} was successfully Saved" : "There was an error saving {$item} submenu item");
				}
			}
		} else {
			$code['Organization'][0] = "Organization table is already populated with data so I cannot add to it!";
		}
		$db->table_messages($code, "Org");
		
		}
	
	private function count_org() {
		global $db;
		$sql = "SELECT COUNT(*) FROM " . self::$table_name;
		$result_set = $db->query($sql);
		$row = ($result_set) ? $db->fetch_array($result_set) : false;
		return ($row) ? array_shift($row) : false;
	}
}
?>