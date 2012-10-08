<?php
	
	/* Session management class that provides static methods which can be used in any class
	 *
	 */
	class session
	{
	
		/* Checks to ensure that a session has been started and starts one if there is no active session.
		 *
		 */
		public static function make_active()
		{
			if (!isset($_SESSION))
			{
				session_start();
			}
		}
	}
	
?>