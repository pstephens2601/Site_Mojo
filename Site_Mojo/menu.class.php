<?php

	require_once('page_history.class.php');

	class menu {
		
		/* 
		 * This class creates a unordered list of menu items that can then be formatted using a CSS style sheet
		 * 
		 * - Several different types of menus can be created utilizing this class by changing the $menu_type property
		 *		Accepted types include:
		 *			bar - creates a basic menu of links
		 *			sitemap - creates a menu with multiple columns
		 *			combo - creates a menu of links with added javascript events
		 *			hover - creates a layered combo menu.  
		 * the menu class defaults to "menu" unless declared when the object is created or using set_class()
		 * menu type defaults to a basic link menu unless declared when the object is created or using set_type()
		 */
		
		private $css_class = 'menu'; 
		private $menu_type = 'bar';
		private $layer = false;
		private $layer_id = 'sub';
		private $menu_items = array();
		private $columns = array();
		private $drop_down_items = array();
		private $drop_down_menus = array();
		
		function __construct() {
			$this->file = page_history::get_page();
		}
		
		/* 
		 * changes the default CSS class to a user defined class
		 * pre-condition: a menu object must have been created
		 * post-condition: the menu will have a new CSS class
		 * WARNING: it is recommended that separate class names are used for multiple menu objects
		 */
		public function set_class($class) {
			$this->css_class = $class;
		}
		
		/* Sets the menu type to a user specified type
		 * 
		 *
		 */
		public function set_type($type) {
			$this->menu_type = $type;
		}
		
		public function add_columns() {
			$num_args = func_num_args();
			$count = 0;
			
			for ($i = 0; $i < $num_args; $i++) {
				$this->columns[] = func_get_arg($i);
			}	
		}
		
		/* 
		 * adds an item to the menu
		 * pre-condition: requires that a menu object has been created
		 * post-condition: the menu item array will contain the added item as a nested array
		 */
		public function add_item() {
		
			$args = func_num_args();

			$item = array('caption' => func_get_arg(0), 'link' => func_get_arg(1));
			
			if ($args == 3) {
				$item['column'] = func_get_arg(2);
			}
			
			if (($args == 4) || ($args == 6)) {
				$item['first_event'] = func_get_arg(2);
				$item['first_js'] = func_get_arg(3);
			}
			
			if ($args == 6) {
				$item['second_event'] = func_get_arg(4);
				$item['second_js'] = func_get_arg(5);
			}
			
			$this->menu_items[] = $item;
		}
		
		/*	creates a 
		 *
		 *
		 */
		public function add_layer($ID) {
			$this->layer = true;
			$this->layer_id = $ID;
		}
		
		/* outputs the html code for the menu
		 * pre-condition: requires that the menu has been given a type, at least 1 item, and a CSS class
		 * post-condition: the html code for the menu has been output
		 */
		public function output_menu() {
			$type = $this->menu_type;
			
			if ($type == 'bar') {
				$this->output_bar_menu();
			}
			elseif ($type == 'sitemap') {
				$this->output_sitemap();
			}
			
		}
		
		/*
		 * outputs the items for a ul menu
		 * pre-condition: requires that there is at least one item contained in $menu_items
		 * post-condition: the html for individual items will have been printed
		 */
		private function output_bar_menu() {
			$class = $this->css_class;
			echo "<ul class=\"$class\" id=\"$class\">\n";
				$this->list_items();
			echo "</ul>\n";
				$this->build_drop_downs();
		}
		
		/* Builds a sitemap with columns of links
		 * pre-condition:
		 * post-condition: 
		 */
		private function output_sitemap() {
			$columns = $this->columns;
			$items = $this->menu_items;
			$class = $this->css_class;
			
			foreach ($columns as $column) {
				echo "<div class=\"$class\">\n";
					echo "<h3>$column</h3>";
					echo "<ul class=\"$class\">\n";
						foreach ($items as $item) {
							if ($item['column'] == $column) {
								echo "<li class=\"$class\"><a href=\"" . $item['link'] . "\" class=\"$class\">" . $item['caption'] . "</a></li>\n";
							}
						}
					echo "</ul>\n";
					echo "</div>\n";
			}
			echo "<div style=\"clear: both;\"></div>";
		}
		
		private function build_drop_downs() {
			foreach ($this->drop_down_menus as $drop_down) {
				echo "<div class=\"" . $this->css_class . "Dd\" id=\"" . $this->css_class . "Dd_" . $drop_down['num'] . "\" onmouseover=\"showDropDown('" . $this->css_class . "_" . $drop_down['num'] . "', '". $this->css_class . "Dd_" . $drop_down['num'] . "')\" onmouseout=\"hideDropDown('". $this->css_class . "Dd_" . $drop_down['num'] . "')\">\n";
				echo "<ul class=\"" . $this->css_class . "Dd\">\n";
					foreach ($this->menu_items as $item) {
						if (isset($item['column'])) {
							if($item['column'] == $drop_down['caption']) {
								echo "<li class=\"" . $this->css_class . "Dd\"><a href=\"" . $item['link'] . "\" class=\"" . $this->css_class . "Dd\">" . $item['caption'] . "</a></li>\n";
							}
						}
					}
				echo "</ul>\n";
				echo "</div>\n";
			}
		}
		
		/* Outputs the individual menu items
		 *
		 *
		 */
		private function list_items() {
			$count = 0;
			$class = $this->css_class;
			
			foreach ($this->menu_items as $item) {
				if (($this->file != $item['link']) && (!isset($item['column']))) {
					echo "<li id=\"" . $class . "_" . $count . "\" class=\"$class\"><a href=\"";
						if ($item['link'] != 'drop_down') {
					 		echo $item['link'] . "\" ";
					 	}
					 	else {
					 		echo "\" ";
					 	}
					 echo  "class=\"$class\" ";
					if (array_key_exists('first_event', $item)) {
						echo $item['first_event'] . "=\"" . $item['first_js'];
						if ($item['link'] == 'drop_down') {
							echo "; showDropDown('" . $class . "_" . $count . "', '". $class . "Dd_" . $count . "')";
						}
						echo "\" ";
					}
					if (array_key_exists('second_event', $item)) {
						echo $item['second_event'] . "=\"" . $item['second_js'];
						if ($item['link'] == 'drop_down') {
							echo "; hideDropDown('" . $class . "Dd_" . $count . "')";
						}
						echo "\"";
					}
					echo ">" . $item['caption'] . "</a></li>\n";
				}
				if ($item['link'] == 'drop_down') {
					$item['num'] = $count;
					$this->drop_down_menus[] = $item;
				}
				if (isset($item['column'])) {
 					$this->drop_down_items[] = $item;
				}
				$count++;
			}
		}
	}
?>