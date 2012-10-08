<?php

require_once('Site_Mojo/validator.class.php');

class email
{
	
	private $to;
	private $from;
	private $reply_to;
	private $return_path;
	private $header;
	private $subject;
	private $message;
	
	function __construct($to, $from, $subject, $message)
	{
		$email = $from;
		
		$this->to = $to;
		$this->subject = $subject;
		$this->message = $message;
		$this->from = "From: $email\r\n";
		$this->reply_to = "Reply-To: $email\r\n";
		$this->return_path = "Return-Path: $email\r\n";
    	$this->header = $from . $reply_to . $return_path;
    	
    }
    
    public send()
    {
    	mail($this->to, $this->subject, $this->message, $this->header);
    }
    
}

?>