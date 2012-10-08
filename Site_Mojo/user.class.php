<?php
	
	require_once('db_object.class.php');
	require_once('page_history.class.php');
	require_once('validator.class.php');
 	require_once('session.class.php');
 	
	class user extends db_object
	{
		
		public $session_key = 'mojo_ID'; //This is the session variable where the user id is kept after a user has been logged in
		public $access_level_key = 'mojo_Access';
		public $access = 1;
		public $confirmed;
		protected $db_table;
		protected $db_user_col;
		protected $db_pass_col;
		protected $db_ID_col;
		
		public $first_name;
		public $last_name;
		private $access_level;
		private $db_fname_col;
		private $db_lname_col;
		private $db_email_col;
		private $db_phone_col;

		
		
		/* Checks to see if a user is already logged in by checking to see if $_SESSION['$session_key'] is set
		 * Pre-condition: 
		 * Post-condition: $confirmed is set to false if the user is not logged in, or true if they are
		 */
		function __construct() {
			session::make_active();
			$this->confirmed = $this->check_login_status($this->session_key);
		}
		
		private function check_login_status($session_key) {
			if(isset($_SESSION[$session_key])) {
				return true;
			}
			else {
				return false;
			}
		}
		
		/* Checks the login information entered by the user
		 * Pre-condition:
		 * Post-condition:
		 */
		public function check_login_form($user_key, $pass_key) {
			if ((isset($_POST[$user_key])) && (isset($_POST[$pass_key]))) {	
				if ((validator::validate_user($user_key, 'user') === true) && (validator::validate_user($pass_key, 'pass') === true)) {
					$this->db_open();
				
					$user = $this->strip($_POST[$user_key]);
					$pass = $this->strip(md5($_POST[$pass_key]));
					
					$query = "SELECT * FROM " . $this->db_table . " WHERE ". $this->db_user_col . " = '$user' AND " . $this->db_pass_col . " = '$pass'";
		
					$result = $this->db_query($query);
					$num = mysql_num_rows($result);
					if ($num == 1) {
						$user = mysql_fetch_assoc($result) or die(mysql_error());
						$ID = $user[$this->db_ID_col];
						$this->login_user($ID);
						$this->db_close();
						return true;
					}
					else {
						$this->db_close();
						return false;
					}
				}
				else {
					echo 'Here I am!';
					//$this->return_error('Invalid input please try again.');
				}
			}
		}
		
		public function table_info($table, $user_col, $pass_col, $ID_col) {
			$this->db_table = $table;
			$this->db_user_col = $user_col; //the user column refers to the column that stores the user name used for login.
			$this->db_pass_col = $pass_col;
			$this->db_ID_col = $ID_col;
		}
		
		private function login_user($ID) {
			session_regenerate_id();
			$_SESSION[$this->session_key] = $ID;
			page_history::return_to_last();
		}
		
		public function get_access_level($column) {

			$this->db_open();
			
			$query = "SELECT " . $column . " FROM " . $this->db_table . " WHERE " . $this->db_ID_col . " = '" . $_SESSION[$this->session_key] . "'";
			
			$result = mysql_query($query) or die(mysql_error());
			$result_array = mysql_fetch_assoc($result);
			$level = $result_array[$column];
			
			$this->access = $level;
			$_SESSION[$this->access_level_key] = $level;
			
			$this->db_close();
		}
		
		public function log_out() {
			//setcookie("recipe_q", "", time()-60*60*24*365, "/");
			//setcookie("recipe_t", "", time()-60*60*24*365, "/");
			unset($_SESSION[$this->session_key]);
			session_destroy();
		}

		public function get_name($first_col, $last_col) {
			$this->db_open();
			
			$query = "SELECT " . $first_col . ", " . $last_col . " FROM " . $this->db_table . " WHERE " . $this->db_ID_col . " = '" . $_SESSION[$this->session_key] . "'";
		
			$result = mysql_query($query) or die(mysql_error());
			$name = mysql_fetch_assoc($result);
			
			$this->first_name = $name[$first_col];
			$this->last_name = $name[$last_col];
			
			$this->db_close();
		}
		
		public function full_name() {
			return $this->first_name . " " . $this->last_name;
		}
		
		public function add_user() {
		
		}

	}
	

?>