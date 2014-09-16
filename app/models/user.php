<?php

class User extends AppModel
{
    const USER_DISPLAY_LIMIT = 10;
    public $validation = array(
        'username' => array(
            'length' => array(
                'validate_between', MIN_VALUE, MAX_VALUE,
            ),
            'format' => array(
                'validate_username'
            ),
        ),

        'password' => array(
            'length' => array(
                'validate_between', MIN_VALUE, MAX_VALUE,
            ),
        ),
    );

    /**
    * validation for username and password
    * @throws RecordnotFoundException
    * @param $username
    * @param $password
    **/
    public function authenticate($username, $password)
    {
        $this->username = $username;
        $this->password = $password;
        if (!$this->validate()) {
            throw new ValidationException("Invalid Username/Password");
        }

        $db = DB::conn();
        $row = $db->row("SELECT * FROM user_info 
            WHERE username = ? AND user_password = ?", array($username, $password));
        if (!$row) {
            throw new RecordNotFoundException("Record not found");
        }  
        return new self($row);
    }

    /**
    * To get newly registered members
    **/
    public static function getNewMembers()
    {
        $members = array();
        $db = DB::conn();
        $row = $db->rows("SELECT username FROM user_info 
            ORDER BY created DESC LIMIT ". self::USER_DISPLAY_LIMIT);
        foreach ($row as $rows) {
            $members[] = new User($rows);
        }
        return $members;
    }

    /**
    * To get username
    * Function subject for modification (WORKING)
    **/
    public static function getUsername($id)
    {
        $db = DB::conn();
        $username = $db->value("SELECT username FROM user_info where user_id = ?", array($id));
        return $username;
    }
}
