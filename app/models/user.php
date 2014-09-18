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

    public function updateAccount($username, $password, $match_password, $user_id)
    {
        $this->username = $username;
        $this->password = $password;
        $this->match_password = $match_password;
        if (!isset($username) || !isset($password) || !isset($match_password)) {
             return "";
        }
        if (!$this->validate()) {
            throw new ValidationException("Invalid Username/Password");
        }
        $db = DB::conn();
        $params = array (
            'username' => $username,
            'user_password' => $password,
        );
        $query = "SELECT username, email FROM user_info
                    WHERE username = ?";
        $search = $db->row($query, array($username));
        if ($search) {
            throw new ExistingUserException(notice("Username already used","error"));
        }

        $update = $db->update('user_info', $params, array('user_id' => $user_id));
        $db->update('comment', array('username' => $username), array('user_id' => $user_id));
        
        //returns 1;
        if (!$update) {
            return "success";
        }
        return "<span class='label label-success'>Successfully changed!</span>";
    }
}
