<?php

class page
{
	
	private $stylesheets = array();
	private $js_files = array();
	private $meta_description;
	private $site_title;
	private $page_title;
	
	
	public function set_stylesheet($style_sheet)
	{
		$this->stylesheets[] = $style_sheet;
	}
	
	public function load_jquery()
	{
		$this->js_files[] = "Site_Mojo/jquery/jquery.js";
	}
	
	public function set_js_file($js_file)
	{
		$this->js_files[] = $js_file;
	}
	
	public function set_site_title($title)
	{
		$this->site_title = $title;
	}
	
	public function set_page_title($title)
	{
		$this->page_title = $title;
	}
	
	public function print_doc_type($type) 
	{
		if (isset($type)) 
		{
			if ($type == 'xhtml') 
			{
				echo "<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional//EN\"\"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\">\n";
			}
			elseif ($type == 'html 5')
			{
				echo "<!DOCTYPE html>";
			}
			elseif ($type == 'html 4')
			{
				echo "<!DOCTYPE HTML PUBLIC \"-//W3C//DTD HTML 4.01 Transitional//EN\" \"http://www.w3.org/TR/html4/loose.dtd\">";
			}
			else
			{
				exit;
			}
		}
		else 
		{
			
		}
	}
	
		public function print_head() {
			echo "<head>\n";
			echo "<title>" . $this->site_title;
			if ($this->page_title != '') {
				echo " - " . $this->page_title; 
			}
			echo "</title>\n";
			foreach ($this->stylesheets as $stylesheet)
			{
				echo "<link rel=\"stylesheet\" href=\"" . $stylesheet . "\" type=\"text/css\">\n";
			}
			foreach ($this->js_files as $js_file)
			{
				echo "<script type=\"text/javascript\" src=\"$js_file\"></script>\n";
			}
			echo "</head>\n";
		}
}

?>