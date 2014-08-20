<?php
class Registration extends AppModel
{
	/*public function userExists($new_username, $new_email)
	{
		$this->username = $new_username;
		$this->email = $new_email;

		$db = DB::conn();
		$row = $db->rows("SELECT username, email from new_user where username='$new_username' OR email='$new_email'");
		if($row)
		{
			die("Your username or email address is not available");
		}
		else
		{
			return;
		}
	}*/
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
		$search = $db->rows("SELECT username, email FROM user_info WHERE username = '$username' AND email = '$email'");
		if($search)
		{
			throw new ExistingUserException("Username/Email already used");
			
		}
		$row = $db->insert('user_info',$defaults);
		//$row =$db->insert('')*/
		if($row)
		{
			unset($infos);
			echo notice("Successful.");
		}
		else
		{
			echo "Try again";
		}
		
    }

	
}
?>