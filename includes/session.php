<?php

/**
 *  a class to help work with Sessions
 *  
 *  in our case, primarily to manage logging users in and out
 *  
 *   keep in mind when working with sessions that it is generally
 *   
 *   inadvisable to store DB-related objects in sessions
 *  
 */

class Session {
	
	private $logged_in = false;
	
	public $user_id;
	
	private $name;
	
	/**
	 * 0 - Tier 0 (Sun)
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
	private $security = 9;
	
	/**
	 * used to set clearance level access to menus and
	 * 
	 * certain functionality within the system
	 * 
	 * 0 - Owner
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
	 * 9 - Individual
	 *
	 * @var integer size 1
	 * @default 9
	 */
	private $clearance = 9;
	
	private $admin = false;
	
	public $message;
	
	public $errors;
	
	/**
	 * Session start
	 * 
	 * check_messages()
	 * 
	 * check_errors()
	 * 
	 * check_login()
	 * 
	 */
	function __construct() {
		session_start();
		$this->check_message();
		$this->check_errors();
		$this->check_login();
		

		/*
		if ($this->logged_in) {
			// actions to take right away if user is logged in
		} else {
			// actions to take right away if user is not logged in
		}
		*/
	}
	
	/** check to see if the user is logged in
	 * 
	 * @return boolean
	 */
	public function is_logged_in() {
// 		if (isset($this->user_id)) {
// 				if ($this->logged_in) {
// 					$this->message("You have been logged out!");
// 				}
// 				$this->logout();
// 		}
		get_breadcrumb();
		return $this->logged_in;
	}
	
	public function fullname($obj) {
		return "{$obj->fname} {$obj->lname}";
	}
	
	/** Session find_clearance method
	 * 
	 * Allows access to the session clearance variable
	 * 
	 * returns values between 0 and 9
	 * 
	 * @return integer size 1
	 */
	public function find_clearance() {
		if (isset($this->clearance)) {
			return $this->clearance;
		} else {
			return 9;
		}
	}
	
	public function get_name() {
		if (isset($this->name)) {
			return $this->name;
		} else {
			return "";
		}
	}
	
	public function get_security() {
		if (isset($this->security)) {
			return $this->security;
		} else {
			return 9;
		}
	}
	
	public function is_master() {
		return $this->admin;
	}
	
	/**
	 * This is used to get the clearance string value for users logged in
	 * 
	 * it's primary use is for adding to the user_log table;
	 * 
	 * @param integer $sheblon size 1
	 * @return string
	 */
	public function convert_clerance_to_string($sheblon) {
		switch ($sheblon) {
			case 0:
				$menu = "Owner";
				break;
			case 1:
				$menu = "Board";
				break;
			case 2:
				$menu = "President";
				break;
			case 3:
				$menu = "Finance";
				break;
			case 4:
				$menu = "Marketing";
				break;
			case 5:
				$menu = "Human Resources";
				break;
			case 6:
				$menu = "Accounting";
				break;
			case 7:
				$menu = "IT";
				break;
			case 8:
				$menu = "Department";
				break;
			case 9:
				$menu = "Individual";
				break;
			default :
				$menu = "Public";
				break;
		}
		return $menu;
	}
	
	public function login($user) {
		// database should find user based on username/password
		if ($user) {
			$this->user_id = $_SESSION['user_id'] = (int)$user->id;
			$this->name = $_SESSION['name'] = $this->fullname($user);
			$this->security = $_SESSION['security'] = (int) $user->security;
			$this->clearance = $_SESSION['clearance'] = (int)$user->clearance;
			if(isset($user->master)) {
				$_SESSION['admin'] = $user->master;
				$this->admin = ($_SESSION['admin']  == 1) ? true : false;
			} else {
				$this->admin = $_SESSION['admin'] = false;
			}
			$activity  = ($this->admin) ? "" : "User ID: " . $this->user_id . " ";
			$activity .= ($this->admin) ? "" : $this->convert_clerance_to_string($sheblon) . " ";
			$activity  .= ($this->admin) ? "Admin Master Login" : "User Login";
			Activity::user_log($user->id, $activity, $this->convert_clerance_to_string($sheblon));
			$this->logged_in = true;
		} else {
			$this->logged_in = false;
		}
	}
	
	function logged_in() {
		return isset($this->user_id);
	}
	
	function confirm_logged_in() {
		if (!logged_in()) {
			redirect_to("login.php");
		}
	}
	
	
	public function logout() {
		if (isset($this->user_id)) {
			$activity = ($this->admin) ? "" : "User ID: " . $this->user_id . " ";
			$activity .= ($this->admin) ? "Admin Master" : $this->convert_clerance_to_string($this->security);
			$activity .= " Logged Out";
			Activity::user_log($this->user_id, $activity, $this->convert_clerance_to_string($this->security));
		}
		unset($_SESSION['user_id']);
		unset($this->user_id);
		unset($this->name);
		unset($this->security);
		unset($this->clearance);
		unset($this->logged_in);
		unset($_SESSION['admin']);
		$this->admin = false;
		$this->logged_in = false;
		$this->clearance = 9;
		$this->security = 9;
	}
	
	public function message($msg="") {
		if (!empty($msg)) {
			// then this is "set message"
			// make sure you understand why $this->message=$msg wouldn't work
			$_SESSION["message"] = $msg;
		} else {
			// then this is "get message"
			return $this->message;
		}
	}
	
	public function errors($err=array()) {
		if (!empty($err)) {
			// then this is "set error"
			$_SESSION["errors"] = $err;
		} else {
			return $this->errors;
		}
	}
	
	/**
	 * if user data is in the $_SESSION then set the class variables
	 * 
	 * 		Set the user id, name, security, clearance, and admin values
	 * 
	 * 		
	 */
	private function check_login() {
		if (isset($_SESSION['user_id'])) {
			$this->user_id = $_SESSION['user_id'];
			if (isset($_SESSION['name'])) {
				$this->name = $_SESSION['name'];
			}
			if (isset($_SESSION['security'])) {
				$this->security = $_SESSION['security'];
			}
			if (isset($_SESSION['clearance'])){
				$this->clearance = $_SESSION['clearance'];
			}
			if (isset($_SESSION['admin'])) {
				$this->admin = ($_SESSION['admin'] == 1) ? true : false;
			}
			
			$this->logged_in = true;
		} else {
			unset($this->user_id);
			unset($this->name);
			unset($this->security);
			unset($this->clearance);
			$this->security = 9;
			$this->clearance = 9;
			$this->name = "";
			$this->admin = false;
			$this->logged_in = false;
		}
	}
	
	private function check_message() {
		// is there a message stored in the session?
		if (isset($_SESSION['message'])) {
			// add it as an attribute and erase the stored version
			$this->message = htmlentities($_SESSION['message']);
			unset($_SESSION['message']);
		} else {
			$this->message = "";
		}
	}
	
	private function check_errors() {
		// is there an error stored in the session?
		if (isset($_SESSION["errors"])) {
			// add it as an attribute and erase the stored version
			$this->errors = $this->form_errors($_SESSION["errors"]);
			unset($_SESSION["errors"]);
		} else {
			$this->errors = "";
		}
	}
	
	private function form_errors($errors=array()) {
		$output = "";
		if (!empty($errors)) {
			$output .= "<div class=\"alert callout\">";
			//if ()
			//$output .= "Possible errors or notices:";
			$output .= "<ul>";
			foreach ($errors as $key => $error) {
				$output .= "<li class=\"text-center\">{$key}. {$error}</li>";
			}
			$output .= "</ul>";
			$output .= "</div>";
		}
		return $output;
	}
	
}

$session = new Session();
$message = $session->message();
$errors = $session->errors();

?>
