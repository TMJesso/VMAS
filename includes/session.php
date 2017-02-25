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
	
	/** Session security
	 * This sets a security code for which each user is 
	 * 
	 * assigned a security code
	 * 
	 * 0 = admin
	 * 
	 * 1 = teacher
	 * 
	 * 2 = student
	 * 
	 * 3 = judges
	 * 
	 * 9 = general public (default)
	 * 
	 * @var int size 1
	 */
	private $security = 99;
	
	/** Session clearance
	 * 
	 * This is the clearance level of the user 
	 * 
	 * and will affect how the menus are displayed to the user
	 * 
	 * especially for the admin user. The users, like teacher and student
	 * 
	 * won't be affected that much
	 * 
	 * @var int size 1
	 */
	private $clearance = 99;
	
	private $admin_master = false;
	
	public $message;
	
	public $errors;
	
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
	public function is_logged_in($sheblon=9) {
		if (isset($this->security)) {
			if ($sheblon != $this->security) {
				if ($this->logged_in) {
					$this->message("You have been logged out!");
				}
				$this->logout();
			}
		}
		return $this->logged_in;
	}
	
	public function fullname($obj) {
		return "{$obj->fname} {$obj->lname}";
	}
	
	/** Session find_clearance method
	 * 
	 * Since the clearance value is private to session
	 * 
	 * it can only be accessed by this method.
	 * 
	 * This method gives access to retrieve its value of the user 
	 * 
	 * and will affect how the menus are displayed to the user
	 * 
	 * especially for the admin user. The users, like teacher, student 
	 * 
	 * and judge won't be affected that much
	 * 
	 * @return integer
	 */
	public function find_clearance() {
		if (isset($this->clearance)) {
			return $this->clearance;
		} else {
			return 99;
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
		return $this->admin_master;
	}
	
	
	public function get_clearance($sheblon) {
		switch ($sheblon) {
			case 0:
				$menu = "Admin";
				break;
			case 1:
				$menu = "Teacher";
				break;
			case 2:
				$menu = "Student";
				break;
			case 3:
				$menu = "Judge";
				break;
			default :
				$menu = "Public";
				break;
		}
		return $menu;
	}
	
	public function login($user, $sheblon) {
		// database should find user based on username/password
		if ($user) {
			$this->user_id = $_SESSION['user_id'] = (int)$user->id;
			$this->name = $_SESSION['name'] = $this->fullname($user);
			$this->security = $_SESSION['security'] = $sheblon;
			$this->clearance = $_SESSION['clearance'] = (int)$user->clearance;
			if(isset($user->master)) {
				$_SESSION['admin_master'] = $user->master;
				$this->admin_master = ($_SESSION['admin_master']  == 1) ? true : false;
			} else {
				$this->admin_master = $_SESSION['admin_master'] = false;
			}
			$activity  = ($this->admin_master) ? "" : "User ID: " . $this->user_id . " ";
			$activity .= ($this->admin_master) ? "" : $this->get_clearance($sheblon) . " ";
			$activity  .= ($this->admin_master) ? "Admin Master Login" : "Non-Master Login";
			Activity::user_log($user->id, $activity, $this->get_clearance($sheblon));
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
			$activity = ($this->admin_master) ? "" : "User ID: " . $this->user_id . " ";
			$activity .= ($this->admin_master) ? "Admin Master" : $this->get_clearance($this->security);
			$activity .= " Logged Out";
			Activity::user_log($this->user_id, $activity, $this->get_clearance($this->security));
		}
		unset($_SESSION['user_id']);
		unset($this->user_id);
		unset($this->name);
		unset($this->security);
		unset($this->clearance);
		//unset($this->data);
		unset($this->logged_in);
		unset($_SESSION['admin_master']);
		$this->admin_master = false;
		$this->logged_in = false;
		//$this->security = 9;
		$this->clearance = 9;
		//$this->data = array();
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
			if (isset($_SESSION['data'])) {
				$this->data = $_SESSION['data'];
			}
			if (isset($_SESSION['admin_master'])) {
				$this->admin_master = ($_SESSION['admin_master'] == 1) ? true : false;
			}
			
			$this->logged_in = true;
		} else {
			unset($this->user_id);
			unset($this->name);
			unset($this->security);
			unset($this->clearance);
			unset($this->data);
			$this->security = 9;
			$this->clearance = 9;
			$this->name = "";
			$this->data = array();
			$this->admin_master = false;
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
