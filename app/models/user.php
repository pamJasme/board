<?php
class User extends AppModel
{
	public function userValidate($username, $password)
	{
		$this->username = $username;
		$this->password = $password;
		$db = DB::conn();
        $row = $db->row("SELECT * FROM user_info WHERE username=? AND user_pword=?", array($username, $password));
        
        return new self($row); //para maging obj
    }

	
}