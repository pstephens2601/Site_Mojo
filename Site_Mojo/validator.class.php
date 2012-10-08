<?php
	
class validator
{
	public static function validate_name($data) 
	{
		if((preg_match("/^[a-zA-Z-]+$/", $data) === 0) || (strlen($data) <= 1))
		{
			$result = false;
		}
		else
		{
			$result = true;
		}
		return $result;
	}
	
	public static function validate_user($data) 
	{
		if((preg_match("/^[0-9a-zA-Z_]+$/", $data) === 0) || (strlen($data) <= 1))
		{
			$result = false;
		}
		else
		{
			$result = true;
		}
		return $result;
	}
	
	public static function validate_pass($data) 
	{
		if((preg_match("/^[0-9a-zA-Z_]+$/", $data) === 0) || (strlen($data) <= 1))
		{
			$result = false;
		}
		else
		{
			$result = true;
		}
		return $result;
	}
	
	
}

?>