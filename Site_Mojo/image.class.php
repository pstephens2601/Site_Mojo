<?php
	
	require_once('db_object.class.php');
	
	class image extends db_object {
		
		private $url;
		private $ID_col;
		private $url_col;
		private $align;
		
		
		function __construct()
		{
			$num = func_num_args();
			
			if ($num == 3)
			{
				$this->table = func_get_arg(0);
				$this->ID_col = func_get_arg(1);
				$this->url_col = func_get_arg(2);
			}
		}
		
		public function set_ID_col($ID_col)
		{
			$this->ID_col = $ID_col;
		}
		
		public function set_user_col($url_col)
		{
			$this->url_col = $url_col;
		}
		
		public function get_url($ID)
		{
			$this->db_open();
			
			$ID_col = $this->ID_col;
			$url_col = $this->url_col;
			$table = $this->table;
			
			$query = "SELECT $url_col FROM $table WHERE $ID_col = '$ID'";
			
			$result = db_query($query);
			$rsult = mysql_fetch_assoc($result);
			$url = $result[$url_col];
			
			return $url;
			
			$this->db_close();
		}
		
		
	
	}
?>