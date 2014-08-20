<?php
class Registration extends AppModel
{

	public function userRegistration(array $infos)
	{
		
		extract($infos);
		foreach ($infos as $field => $value) {
			
			if(empty($infos['$field']))
			{
				throw new IncompleteFieldsException("Please fill up all fields");
			}
		}
		$now = new DATETIME('NOW');
		$f_now = $now->format('Y-m-d h:m:s');
		$db = DB::conn();
		$defaults = array(
			'username' => $username,
			'user_pword' => $user_pword,
			'fname' => $fname,
			'lname' => $lname,
			'email' => $email,
			'created' => $f_now,
			);
		$check_uname = validate_between($username,5,8);
		$check_pass = validate_between($user_pword,6,8);
		if(!$check_uname OR !ctype_alnum($username))
		{
			throw new ValidationException("Invalid Username : 6-8 Alphanumeric characters");
		}
		if(!$check_pass)
		{
			throw new ValidationException("Password: 6-8 characters");
		}
		if(!preg_match("/^[A-z](.*)@(.*)\.(.*)/", $email))
		{
			throw new ValidationException("Invalid Email Address");
		}
		$search = $db->rows("SELECT username, email FROM user_info WHERE username = '$username' AND email = '$email'");
		if($search)
		{
			throw new ExistingUserException("Username/Email already used");
			
		}

		$row = $db->insert('user_info',$defaults);
		
		
		unset($infos);
		
		
    }

	
}
?>