<?php

	require_once('session.class.php');
	
	/* status.class.php saves status messages, such as form errors, to an array in the $_SESSION super global and then pulls them out
	 * then allows the user to print them on the page.  Multiple status reports can be kept by calling multiple status objects and
	 * assigning each one a different key.
	 * Pre-condition:  Must have the session super global key passed to it upon instantiation and requires
	 * that the file session.class.php exists in the same folder.
	 */	
	class status
	{
		private $session_key;
		private $messages = array();
		
		function __construct($key)
		{
			session::make_active();
			$this->session_key = $key;
			$this->messages = $this->get_messages();
		}
		
		/* Retrieves the messages currently stored in the session variable at the corresponding key
		 * Pre-condition: requires an active session.
		 * Post-condition: returns the array containing the messages, and leaves the array intact in the session variable
		 */ 
		private function get_messages()
		{
			if (isset($_SESSION[$this->session_key]))
			{
				$messages = $_SESSION[$this->session_key];
				return $messages;
			}
		}
		
		/*	Adds a new message to the end of the array stored in the session variable
		 *	Pre-condition: requires that a status object has been created and passed a valid session key
		 *	Post-condition: overwrites the array stored at the key passed to the object with a new array that has the message appended at the end.
		 */
		public function add_message($message)
		{
			session::make_active();
			$messages = $this->messages;
			$this->messages[] = $message;
			$_SESSION[$this->session_key] = $this->messages;
		}
		
		/* Reloads the array of messages stored in the object's messages property back into the $_SESSION variable at the key stored in the object's properties
		 * useful restoring the messages when the current session has been destroyed. 
		 * Pre-condition: requires that a status object is created while there is still an active session and that it has been given the correct key of the messages to be reloaded
		 * Post-condition: A new session will have been created and the messages that are currently in the $messages property will have been placed back into $_SESSION at the
		 * same key location the were read from.
		 */
		public function reload_messages()
		{
			session::make_active();
			$_SESSION[$this->session_key] = $this->messages;
		}
		
		/* Outputs all of the messages stored in the messages property to the browser with a line break after each message.
		 * Pre-condition: requires that an object of the class has been instantiated with the correct key to where the desired messages are located.
		 * Post-condition: All of the existing messages will have been outputed to the browser.
		 * Note: For more formatting control use return_all() and print from outside the object.
		 */
		public function print_all()
		{
			foreach ($this->messages as $message)
			{
				echo "$message<br />";
			}
		}
		
		/* Prints only the last message stored in the array.
		 * Pre-condition: requires that an object of the class has been instantiated with the correct key to where the desired messages are located.
		 * Post-condition: The last message stored in the messages property will have been output to the browser.
		 */
		public function print_last()
		{
			$message = end($this->messages);
			echo $message;
		}
		
		/* Returns all of the messages stored in the messages property
		 * Pre-condition: requires that a status object has been created
		 * Post-condition: returns an array containing all of the messages in the messages property
		 */
		public function return_all()
		{
			return $this->messages;
		}
		
		/* Returns the last message stored in the messages property
		 * Pre-condition: requires that a status object has been created
		 * Post-condition: returns a string containing the last message stored in the messages property
		 */
		public function return_last()
		{
			return end($this->messages);
		}
		
		/* Erases all of the stored messages in the messages property and the session variable
		 * Pre-condition: requires that a status object has been created and passed the correct key of the $_SESSION variable
		 * Post-condition: All data will be removed from the messages property and the session variable at the key set will be unset
		 */
		public function clear_all()
		{
			session::make_active();
			$this->messages = null;
			unset($_SESSION[$this->session_key]);
		}
	}

?>