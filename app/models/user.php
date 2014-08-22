<?php

class User extends AppModel
{
    /**
    * validation for username and password
    * @throws RecordnotFoundException
    * @param $username
    * @param $password
    **/
    public function userValidate($username, $password)
    {
        $db=DB::conn();
        $query = "SELECT * FROM user_info WHERE username = ? AND user_pword = ?";
        $params = array($username, $password);
        $row = $db->row($query, $params);
        if(!$row) {
            throw new RecordNotFoundException("Username/Password is incorrect");
        }  
        return new self($row);
    }
}