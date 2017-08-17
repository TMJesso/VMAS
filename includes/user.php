<?php
require_once LIB_PATH . 'org.php';
class User EXTENDS DatabaseObject {
	protected static $table_name = "user";
	
	public $id;
	
	public $fname;
	
	public $lname;
	
	public $username;
	
	public $passcode;
	
	public $email;
	
	/** user types
	 * 
	 * 0 - Admin
	 * 
	 * 1 - General Manager
	 * 
	 * 2 - Human Resources
	 * 
	 * 3 - Department Manager
	 * 
	 * 4 - Floor Supervisor
	 * 
	 * 5 - Line Lead
	 * 
	 * 6 - Station
	 * 
	 * 7 - Reserved
	 * 
	 * 8 - Reserved
	 * 
	 * 9 - General Public (LOWEST SECURITY CLEARANCE)
	 * @var integer size 1 
	 * @default 9
	 */
	public $user_type = 9;
	
	public $org_id;
	
	/**
	 * 
	 * @var boolean size 1
	 * @default 0
	 */
	public $master = 0;
	
	/**
	 * 0 - Tier 0 (Sun) - (HIGHEST SECURITY CLEARANCE)
	 * 
	 * 1 - Tier 1 (Stellar)
	 * 
	 * 2 - Tier 2 (Orbital)
	 * 
	 * 3 - Tier 3 (Heavens)
	 * 
	 * 4 - Tier 4 (Atmosphereic)
	 * 
	 * 5 - Tier 5 (Stratis)
	 * 
	 * 6 - Tier 6 (Accumulas)
	 * 
	 * 7 - Tier 7 (National)
	 * 
	 * 8 - Tier 8 (Regional)
	 * 
	 * 9 - Tier 9 (Station) - (LOWEST SECURITY CLEARANCE)
	 * 
	 * @var integer size 1
	 * @default 9
	 */
	public $security = 9;
	
	/** Within the security clearance there are 10 clearance 
	 * 
	 * levels that could be used
	 * 
	 * 0 - Owner (Highest Clearance Level)
	 * 
	 * 1 - Board
	 * 
	 * 2 - President
	 * 
	 * 3 - Finanace
	 * 
	 * 4 - Marketing
	 * 
	 * 5 - Human Resources
	 * 
	 * 6 - Accounting
	 * 
	 * 7 - IT
	 * 
	 * 8 - Department
	 * 
	 * 9 - Individual (Lowest Clearance Level)
	 * 
	 * @var integer size 1
	 * @default 9
	 */
	public $clearance = 9;
	
	/** reset passcode option 
	 * 
	 * true or false
	 * 
	 * @var boolean size 1
	 */
	public $reset = 0;
	
	/** 
	 * true or false
	 * 
	 * @var boolean size 1
	 */
	public $confirm = 0;
	
	/**
	 * When was this user confirmed
	 * 
	 * @var datetime
	 */
	public $confirmed;
	
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
	
	public static function get_user_by_username($username="") {
		$sql  = "SELECT * FROM " . self::$table_name;
		$sql .= " WHERE BINARY username = '{$username}'";
		$sql .= " LIMIT 1";
		$row = self::find_by_sql($sql);
		return array_shift($row);
	}
	
	public static function get_user_by_id($id) {
		$sql  = "SELECT * FROM " . self::$table_name;
		$sql .= " WHERE id = {$id}";
		$sql .= " LIMIT 1";
		$row = self:: find_by_sql($sql);
		return array_shift($row);
	}
	
	public static function get_user_by_name($fname="", $lname="") {
		$sql  = "SELECT * FROM " . self::$table_name;
		$sql .= " WHERE fname = '{$fname}' AND lname = '{$lname}'";
		$row = self::find_by_sql($sql);
		if (count($row) == 1) {
			return array_shift($row);
		}
		return $row;
	}
	
	public static function get_user_by_email($email="") {
		$sql  = "SELECT * FROM " . self::$table_name;
		$sql .= " WHERE email = '{$email}'";
		$row = self::find_by_sql($sql);
		return array_shift($row);
	}
	
	public static function generate_master_admin() {
		$obj = new self;
		$obj->load_master_admin();
		$obj->load_public_user();
	}
	
	private function load_master_admin() {
		$org = new Org();
		$name = $org->get_organization_by_name("Development Team");
		global $db;
		$obj = new self;
		$obj->fname = "Theral";
		$obj->lname = "Jessop";
		$obj->username = "TheraLjEssop";
		$obj->passcode = password_encrypt("8F2017-farms", $obj->username);
		$obj->email = "Jess_Hort_Farms@mail.com";
		$obj->master = 1;
		$obj->user_type = 0;
		$obj->org_id = $name->id;
		$obj->security = 0;
		$obj->clearance = 0;
		$obj->reset = 0;
		unset($name);
		unset($org);
		if ($obj->save()) {
			$codes['Master'][1] = "Master Admin has been created!";
		} else {
			$codes['Master'][0] = "Master Admin is already loaded!";
		}
		$db->table_messages($codes, "User");
	}
	
	private function load_public_user() {
		$org = new Org();
		$name = $org->get_organization_by_name("Development Team");
		
		global $db;
		$obj = new self;
		$obj->fname = "Public";
		$obj->lname = "Access";
		$obj->username = "PublicAccess";
		$obj->passcode = password_encrypt("2C2017-access", $obj->username);
		$obj->email = "none@host.com";
		$obj->master = 0;
		$obj->user_type = 9;
		$obj->org_id = $name->id;
		$obj->security = 0;
		$obj->clearance = 0;
		$obj->reset = 0;
		unset($name);
		unset($org);
		if ($obj->save()) {
			$codes["Public"][1] = "Public user has been created!";
		} else {
			$codes["Public"][0] = "Public user is already loaded!";
		}
		$db->table_messages($codes, "User");
	}
	
}
?>