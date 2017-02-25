<?php
require_once(LIB_PATH.DS.'config.php');
require_once(LIB_PATH.DS.'initialize.php');
class DbConnect extends DatabaseObject {
	private $my_sql_connect;
	
	function __construct() {
		$this->open_connection();
		$this->create_tables(false);
	}
	
	public function open_connection() {
		//$this->my_sql_connection = mysqli_connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME);
		$this->my_sql_connect = mysqli_connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME);
		if (mysqli_connect_errno()) {
			die ("Database connection failed: " . mysqli_connect_error() . " (" . mysqli_connect_errno() . ")" );
		}
	}
	
	public function close_connection() {
		if (isset($this->my_sql_connect)) {
			mysqli_close($this->my_sql_connect);
			unset($this->my_sql_connect);
		}
	}
	
	public function query($sql) {
		$result = mysqli_query( $this->my_sql_connect, $sql);
		// test if there was a query error
		// $this->confirm_query($result);
		return ($result) ? $result : false;
		// return $result;
	}
	
	private function confirm_query($result) {
		if (!$result) {
			die( "Database query failed.");
		}
	}
	
	public function prevent_injection($string) {
		$escaped_string = mysqli_real_escape_string($this->my_sql_connect, $string);
		return $escaped_string;
	}
	
	// "database neutral" functions
	public function fetch_array($result_set) {
		return mysqli_fetch_array($result_set);
	}
	
	public function fetch_assoc_array($result_set) {
		return mysqli_fetch_assoc($result_set);
	}
	
	public function fetch_fields($results) {
		return mysqli_fetch_fields($results);
	}
	public function num_rows($result_set) {
		return mysqli_num_rows($result_set);
	}
	
	public function insert_id() {
		// get the last id inserted over the current db connection
		return mysqli_insert_id($this->my_sql_connect);
	}
	
	public function affected_rows() {
		return mysqli_affected_rows($this->my_sql_connect);
	}
	
	public function secure_access($items=array()) {
		if (!empty($items)) {
			for ($x = 0; $x < count($items); $x++) {
				if ($items[$x] == "drop") {
					$this->access_drop_table(true);
				}
				if ($items[$x] == "menu") {
					Menu::load_menu();
				}
				if ($items[$x] == "submenu") {
						Submenu::load_submenu(); 
				}
				if ($items[$x] == "subsubmenu") {
						Subsubmenu::load_subsubmenu();
				}
				if ($items[$x] == "master") {
						User::generate_master_admin();
				}
			}
		}
				
	}
	
	private function create_tables($show) {
		// thesse have to be created in this order
		$this->create_user($show);
		$this->create_merchant($show);
		$this->create_msg($show);
		$this->create_vehicle($show);
		$this->create_record($show);
		$this->create_menu($show);
		$this->create_submenu($show);
		$this->create_subsubmenu($show);
		$this->create_contact($show);
		$this->create_userlog($show);
	}
	
	private function create_user($show) {
		$sql  = 'CREATE TABLE IF NOT EXISTS user ( ';
		$sql .= 'id int(11) NOT NULL AUTO_INCREMENT, ';
		$sql .= 'fname varchar(15) NOT NULL, ';
		$sql .= 'lname varchar(15) NOT NULL, ';
		$sql .= 'username varchar(16) NOT NULL, ';
		$sql .= 'passcode varchar(72) NOT NULL, ';
		$sql .= 'email varchar(45) NOT NULL, ';
		$sql .= 'user_type int(1) NOT NULL, ';
		$sql .= 'master tinyint(1) NOT NULL, ';
		$sql .= 'security int(1) NOT NULL, ';
		$sql .= 'clearance int(1) NOT NULL, ';
		$sql .= 'reset int(1) NOT NULL, ';
		$sql .= 'PRIMARY KEY (id), ';
		$sql .= 'UNIQUE KEY email (email), ';
		$sql .= 'UNIQUE KEY username (username))';
		if ($this->query($sql)) {
			if ($show) {
				echo "<span style=\"color: green;\">" . substr($sql, 0, strpos($sql, "(")) . " <strong>EXECUTED</strong>!</span><br/>";
			}
		}
	}
	
	private function create_merchant($show) {	
		$sql  = 'CREATE TABLE IF NOT EXISTS merchant (';
		$sql .= 'id INT(11) NOT NULL AUTO_INCREMENT, ';
		$sql .= 'user_id INT(11) NOT NULL, ';
		$sql .= 'name VARCHAR(30) NOT NULL, ';
		$sql .= 'address VARCHAR(40) NOT NULL, ';
		$sql .= 'city VARCHAR(30) NOT NULL, ';
		$sql .= 'state VARCHAR(2) NOT NULL, ';
		$sql .= 'zip VARCHAR(10) NOT NULL, ';
		$sql .= 'phone VARCHAR(14) NULL, ';
		$sql .= 'descrip VARCHAR(100) NULL, ';
		$sql .= 'PRIMARY KEY (id), ';
		$sql .= 'UNIQUE KEY (name), ';
		$sql .= 'FOREIGN KEY user_id (user_id) REFERENCES user (id))';
		if ($this->query($sql)) {
			if ($show) {
				echo "<span style=\"color: green;\">" . substr($sql, 0, strpos($sql, "(")) . " <strong>EXECUTED</strong>!</span><br/>";
			}
		}
	}
	
	private function create_msg($show) {
		$sql  = 'CREATE TABLE IF NOT EXISTS mpg ( ';
		$sql .= 'id INT(11) NOT NULL AUTO_INCREMENT, ';
		$sql .= 'merchant_id INT(11) NOT NULL, ';
		$sql .= 'vechicle_id INT(11) NOT NULL, ';
		$sql .= 'cost FLOAT(10,2) NULL, ';
		$sql .= 'price FLOAT(10,3) NULL, ';
		$sql .= 'gallons FLOAT(10,4) NULL, ';
		$sql .= 'odometer FLOAT(10,3) NOT NULL, ';
		$sql .= 'PRIMARY KEY (id), ';
		$sql .= 'FOREIGN KEY merchant_id (merchant_id) REFERENCES merchant (id))';
		if ($this->query($sql)) {
			if ($show) {
				echo "<span style=\"color: green;\">" . substr($sql, 0, strpos($sql, "(")) . " <strong>EXECUTED</strong>!</span><br/>";
			}
		}
	}
	
	private function create_vehicle($show) {
		$sql  = 'CREATE TABLE IF NOT EXISTS vehicle ( ';
		$sql .= 'id INT(11) NOT NULL AUTO_INCREMENT, ';
		$sql .= 'user_id INT(11) NOT NULL, ';
		$sql .= 'name VARCHAR(20) NOT NULL, ';
		$sql .= 'make VARCHAR(20) NOT NULL, ';
		$sql .= 'model VARCHAR(30) NOT NULL, ';
		$sql .= 'year INT(4) NOT NULL, ';
		$sql .= 'color VARCHAR(15) NOT NULL, ';
		$sql .= 'vin VARCHAR(30) NOT NULL, ';
		$sql .= 'plate VARCHAR(10) NOT NULL, ';
		$sql .= 'state VARCHAR(2) NOT NULL, ';
		$sql .= 'purchased DATETIME NOT NULL, ';
		$sql .= 'cost FLOAT(10,2) NOT NULL, ';
		$sql .= 'dealer VARCHAR(45) NOT NULL, ';
		$sql .= 'start_miles int(7) NOT NULL, ';
		$sql .= 'PRIMARY KEY (id), ';
		$sql .= 'FOREIGN KEY user_id (user_id) REFERENCES user (id))';
		if ($this->query($sql)) {
			if ($show) {
				echo "<span style=\"color: green;\">" . substr($sql, 0, strpos($sql, "(")) . " <strong>EXECUTED</strong>!</span><br/>";
			}
		}
	}
	
	private function create_record($show) {
		$sql  = 'CREATE TABLE IF NOT EXISTS record ( ';
		$sql .= 'id INT(11) NOT NULL AUTO_INCREMENT, ';
		$sql .= 'vehicle_id INT(11) NOT NULL, ';
		$sql .= 'merchant_id INT(11) NOT NULL, ';
// 		$sql .= 'exp_date DATETIME NOT NULL, ';
// 		$sql .= 'odometer FLOAT(10,2) NOT NULL, ';
		$sql .= 'description VARCHAR(150) NOT NULL, ';
		$sql .= 'repairs FLOAT(10,2) NULL, ';
		$sql .= 'supplies FLOAT(10,2) NULL, ';
// 		$sql .= 'service FLOAT(10,2) NULL, ';
// 		$sql .= 'oil float(10,2) NULL, ';
// 		$sql .= 'air_filter float(10,2) NULL, ';
// 		$sql .= 'oil_filter float(10,2) NULL, ';
		$sql .= 'other_notes VARCHAR(50) NULL, ';
		$sql .= 'other_EXP FLOAT(10,2) NULL, ';
		$sql .= 'PRIMARY KEY (id), ';
		$sql .= 'FOREIGN KEY vehicle_id (vehicle_id) REFERENCES vehicle (id)) ';
		if ($this->query($sql)) {
			if ($show) {
				echo "<span style=\"color: green;\">" . substr($sql, 0, strpos($sql, "(")) . " <strong>EXECUTED</strong>!</span><br/>";
			}
		}
	}
	
	private function create_oilchange($show) {
		$sql  = "CREATE TABLE IF NOT EXISTS oil_change ( ";
		$sql .= "id int(11) NOT NULL AUTO_INCREMENT, ";
		$sql .= "record_id int(11) NOT NULL, ";
		$sql .= "odometer float(7) NOT NULL, ";
		$sql .= "service_date datetime NOT NULL, ";
		$sql .= "service_expense float(6,2) NOT NULL, ";
		$sql .= "oil_expense float(6,2) NOT NULL, ";
		$sql .= "oil_filter_expense float(6,2) NOT NULL, ";
		$sql .= "air_filter_expense float(6,2) NOT NULL, ";
		$sql .= "notes text NULL, ";
		
	}
	
	private function create_menu($show) {
		$sql  = "CREATE TABLE IF NOT EXISTS menu ( ";
		$sql .= "id int(11) NOT NULL AUTO_INCREMENT, ";
		$sql .= "link_text varchar(25) NOT NULL, ";
		$sql .= "find_text varchar(25) NOT NULL, ";
		$sql .= "url varchar(50) NOT NULL, ";
// 		$sql .= "position int(2) NOT NULL, ";
		$sql .= "visible tinyint(1) NOT NULL, ";
		$sql .= "user_type int(1) NOT NULL, ";
		$sql .= "PRIMARY KEY (id), ";
		$sql .= "UNIQUE KEY user_type (user_type), ";
		$sql .= "UNIQUE KEY link_text (link_text))";
		if ($this->query($sql)) {
			if ($show) {
				echo "<span style=\"color: green;\">" . substr($sql, 0, strpos($sql, "(")) . " <strong>EXECUTED</strong>!</span><br/>";
			}
		}
	}
	
	private function create_submenu($show) {
		$sql  = "CREATE TABLE IF NOT EXISTS submenu ( ";
		$sql .= "id int(11) NOT NULL AUTO_INCREMENT, ";
		$sql .= "menu_id int(11) NOT NULL, ";
		$sql .= "link_text varchar(25) NOT NULL, ";
		$sql .= "find_text varchar(25) NOT NULL, ";
		$sql .= "url varchar(50) NOT NULL, ";
		$sql .= "position int(2) NOT NULL, ";
		$sql .= "visible tinyint(1) NOT NULL, ";
		$sql .= "security int(1) NOT NULL, ";
		$sql .= "clearance int(1) NOT NULL, ";
		$sql .= "admin tinyint(1) NOT NULL, ";
		$sql .= "PRIMARY KEY (id), ";
		$sql .= "UNIQUE KEY find_text (find_text), ";
		$sql .= "KEY menu_id (menu_id), ";
		$sql .= "FOREIGN KEY (menu_id) REFERENCES menu (id))";
		if ($this->query($sql)) {
			if ($show) {
				echo "<span style=\"color: green;\">" . substr($sql, 0, strpos($sql, "(")) . " <strong>EXECUTED</strong>!</span><br/>";
			}
		}
	}
	
	private function create_subsubmenu($show) {
		$sql  = "CREATE TABLE IF NOT EXISTS subsubmenu ( ";
		$sql .= "id int(11) NOT NULL AUTO_INCREMENT, ";
		$sql .= "submenu_id int(11) NOT NULL, ";
		$sql .= "link_text varchar(25) NOT NULL, ";
		$sql .= "find_text varchar(25) NOT NULL, ";
		$sql .= "url varchar(50) NOT NULL, ";
		$sql .= "position int(2) NOT NULL, ";
		$sql .= "visible tinyint(1) NOT NULL, ";
		$sql .= "security int(1) NOT NULL, ";
		$sql .= "clearance int(1) NOT NULL, ";
		$sql .= "admin tinyint(1) NOT NULL, ";
		$sql .= "PRIMARY KEY (id), ";
		$sql .= "UNIQUE KEY find_text (find_text), ";
		$sql .= "KEY submenu_id (submenu_id), ";
		$sql .= "FOREIGN KEY (submenu_id) REFERENCES submenu (id))";
		if ($this->query($sql)) {
			if ($show) {
				echo "<span style=\"color: green;\">" . substr($sql, 0, strpos($sql, "(")) . " <strong>EXECUTED</strong>!</span><br/>";
			}
		}
	}
	
	private function create_contact($show) {
		$sql  = "CREATE TABLE IF NOT EXISTS contact_info ( ";
		$sql .= " id int(11) NOT NULL AUTO_INCREMENT, ";
		$sql .= " user_id int(11) NOT NULL, ";
		$sql .= " address varchar(50) NOT NULL, ";
		$sql .= " secondary varchar(30) NULL, ";
		$sql .= " city varchar(40) NOT NULL, ";
		$sql .= " state varchar(2) NOT NULL, ";
		$sql .= " zip varchar(10) NOT NULL, ";
		$sql .= " mobile varchar(10) NULL, ";
		$sql .= " home varchar(10) NULL, ";
		$sql .= " work varchar(10) NULL, ";
		$sql .= " comments text NULL, ";
		$sql .= " PRIMARY KEY (id),";
		$sql .= " FOREIGN KEY user_id (user_id) REFERENCES user (id))";
		if ($this->query($sql)) {
			if ($show) {
				echo "<span style=\"color: green;\">" . substr($sql, 0, strpos($sql, "(")) . " <strong>EXECUTED</strong>!</span><br/>";
			}
		}
	}
	
	private function create_userlog($show) {
		$sql  = 'CREATE TABLE IF NOT EXISTS user_log ( ';
		$sql .= 'id int(11) NOT NULL AUTO_INCREMENT, ';
		$sql .= 'user_id int(11) NOT NULL, ';
		$sql .= 'user_type varchar(15) NOT NULL, ';
		$sql .= 'date_stamp datetime DEFAULT NOW() ON UPDATE NOW() NOT NULL, ';
		$sql .= 'activity text NULL, ';
		$sql .= 'PRIMARY KEY (id), ';
		$sql .= 'INDEX user_id (user_id)) ';
		if ($this->query($sql)) {
			if ($show) {
				echo "<span style=\"color: green;\">" . substr($sql, 0, strpos($sql, "(")) . " <strong>EXECUTED</strong>!</span><br/>";
			}
		}
		
	}
				
	public function backuptables() {
		$tables = array(0=>'subsubmenu', 1=>'submenu', 2=>'menu', 3=>'record', 4=>'vehicle', 5=>'mpg', 6=>'merchant', 7=>'user');
		$path = "../backup/";
		$ext = ".txt";
		foreach ($tables as $table => $name) {
			$filename = $path . $name . $ext;
			$sql = "SELECT * INTO OUTFILE '{$filename}' FIELDS TERMINATED BY ',' OPTIONALLY ENCLODED BY '\"' FROM {$name}";
			$this->query($sql);
		}
	}
	
	/**
	 * errors are code 0 (alert)
	 * 
	 * success is code 1 (success)
	 * 
	 * 
	 * @param array $codes
	 * @return string
	 */
	public function table_messages($codes, $class) {
		if (count($codes) == 0) {
			$codes['Tables'][1] = "There were no errors or messages generated"; 
		}
		echo "<table><caption>Table Message and Errors for <span style=\"color: green;\">{$class}</span></caption><tr>";
		echo "<th>Table</th><th><span class=\"alert callout\">Error</span> or <span class=\"success callout\">Success</span></th>";
		foreach ($codes as $code=>$value) {
			foreach ($value as $table=>$message) {
				// if code is 1 then it is an error
				// if code is 0 then it is a success
				if ($table == 0) { 
					echo "<tr class=\"alert callout\">";
				} else { 
					echo "<tr class=\"success callout\">";
				}
				echo "<td>".$code."</td><td>".$message."</td></tr>";
			}
		}
		echo "</table>";
	}
	
	public function access_drop_table($show) {
		$this->drop_all_tables($show);
	}
	
	private function drop_all_tables($show) {
		$tables = array('subsubmenu'=>'drop', 'submenu'=>'drop', 'menu'=>'drop', 'record'=>'drop', 'vehicle'=>'drop', 'mpg'=>'drop', 'merchant'=>'drop', 'contact_info'=>'drop', 'user'=>'drop', 'user_log'=>'nodrop');
		foreach ($tables as $table => $command) {
			if ($command == 'drop') {
				$sql  = strtoupper($command) . " TABLE IF EXISTS " . $table;
				if ($this->query($sql)) {
					echo "<span style=\"color: green;\">" . $sql . " <strong>EXECUTED</strong>!</span><br/>";
				}
			} elseif ($command == 'nodrop') {
				$sql = "TABLE " . $table . " was NOT dropped";
				echo "<span style=\"color: green;\">" . $sql . " <strong>EXECUTED</strong>!</span><br/>";
			}
		}
		echo "<br/><br/>";
		$this->create_tables($show);
		echo "<br/>";
	}
	
}

$db = new DbConnect();

?>
