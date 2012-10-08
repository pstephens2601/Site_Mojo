<?php

	class db_object
	{
		protected $db;
		protected $login;
		protected $pass;
		protected $host;
		protected $table;
		
		public function setup_login($host, $login, $pass)
		{
			$this->login = $login;
			$this->pass = $pass;
			$this->host = $host;
		}
		
		public function set_db($db)
		{
			$this->db = $db;
		}
		
		protected function db_open() 
		{
			mysql_connect($this->host, $this->login, $this->pass);
			mysql_select_db($this->db) or die(mysql_error());
		}
		
		protected function db_query($query)
		{
			$result = mysql_query($query) or die(mysql_error());
			return $result;
		}
		
		protected function db_close() 
		{
			mysql_close();
		}
		
		public function set_table($table)
		{
			$this->table = $table;
		}
		public function strip($string) 
		{
			$string = str_replace("'", "\'", $string);
			$string = str_replace('"', '\"', $string);
			return $string;
		}
	}
?>