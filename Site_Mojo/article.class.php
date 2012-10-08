<?php

	require_once('content.class.php');
	

	class article extends text_content 
	{
	
			private $text_col;
			private $title_col;
			private $id_col;
			private $article_ID;
			private $article_text;
			private $article_title;
		
		function __construct($table, $text_col, $title_col, $id_col, $article_ID)
		{
			$this->table = $table;
			$this->text_col = $text_col;
			$this->title_col = $title_col;
			$this->id_col = $id_col;
			$this->article_ID = $article_ID;
	
		}
		
		/* Outputs the article to the web page
		 *
		 */
		
		public function get_article()
		{
			$this->db_open();
			
			$query = "SELECT " . $this->title_col . ", " . $this->text_col . " FROM " . $this->table . " WHERE " . $this->id_col . " = " . "'" . $this->article_ID . "'";
			
			$result = mysql_query($query) or die(mysql_error());
			
			while($article = mysql_fetch_assoc($result))
			{
				$this->article_text = $article[$this->text_col];
				$this->article_title = $article[$this->title_col];
			}
		}
		
		public function print_body()
		{

			echo nl2br(htmlspecialchars($this->article_text, ENT_QUOTES));
			
		}
		
		public function print_title()
		{
			
			echo $this->article_title;
			
		}
		
		public function update_article($body, $title)
		{
			$this->db_open();
			
			$body = $this->strip($body);
			$title = $this->strip($title);
			
			$check_db_query = "SELECT * FROM " . $this->table . " WHERE " . $this->id_col . " = '" . $this->article_ID . "'";
			
			$check_db_result = mysql_query($check_db_query) or die(mysql_error());
			$num = mysql_num_rows($check_db_result);
			
			$insert_query = "INSERT INTO " . $this->table . " ( " . $this->text_col . ", " . $this->title_col . ", " . $this->id_col . ") VALUES ( '$body', '$title', '" . $this->article_ID . "')";
			$update_query = "UPDATE " . $this->table . " SET " . $this->text_col . "= '$body', " . $this->title_col . "= '$title' WHERE " . $this->id_col ."= '" . $this->article_ID . "'";
			
			if ($num > 0) {
				mysql_query($update_query) or die(mysql_error());
			}
			else {
				mysql_query($insert_query) or die(mysql_error());
			}
		}
		
		public function edit_form($action, $method)
		{
		
			echo "<form action=\"$action\" method=\"$method\">";
			echo "<input type=\"text\" name=\"article_title\" value=\"" . htmlspecialchars($this->article_title, ENT_QUOTES) . "\" placeholder=\"Title\">";
			echo "<br />";
			echo "<br />";
			echo "<textarea name=\"article_body\">" . $this->article_text . "</textarea>";
			echo "<br />";
			echo "<br />";
			echo "<input type=\"submit\" name=\"article_" . $this->article_ID . "\" value=\"Update Article\">";
			echo "</form>";
			
		}
	}

?>