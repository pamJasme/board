<?php
class User extends AppModel
{
	public function userValidate($username, $password)
	{
		$this->username = $username;
		$this->password = $password;
		$db=DB::conn();
		$row = $db->row('SELECT * FROM user_info WHERE username = ? AND user_pword = ?', array($username, $password));
		if(!$row) {
            throw new RecordNotFoundException("Username/Password is incorrect");
        }  
		return new self($row);
		

    }

	
}