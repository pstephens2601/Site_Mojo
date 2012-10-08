<?php	

	require_once('session.class.php');
	
	class page_history 
	{
		/* Tracks the history of pages visited in a array stored in $_SESSION['page_history'] and provides functions to
		 * redirect to pages in that array.
		 * 
		 */
		
		function __construct() 
		{
			
		}
		
		/* 
		 *
		 */
		public static function get_page() 
		{
			$trace = debug_backtrace();
			$page_data = end($trace);
			$file = preg_split('/\//', $page_data['file']);
			return end($file);
		}
		
		public static function track_page() 
		{
			session::make_active();
			$file = self::get_page();
			$history = array();
			if (isset($_SESSION['SM_page_history'])) {
				$history = $_SESSION['SM_page_history'];
			}
			$history[] = $file;
			$_SESSION['SM_page_history'] = $history;
		}
		
		private static function get_last_page() 
		{
		 	$history = $_SESSION['SM_page_history'];
		 	end($history);
		 	$prev = prev($history);
			return $prev;
		}
		
		public static function return_to_last() 
		{
			$last = self::get_last_page();
			header("Location: $last");
		}
		
		public static function refresh_page() 
		{
			$page = end($_SESSION['SM_page_history']);
			header("Location: $page");
		}
		
		public static function get_history()
		{
			$history = $_SESSION['SM_page_history'];
			return $history;
		}
		
		public static function save_history($history)
		{
			$_SESSION['SM_page_history'] = $history;
		}
	}
?>