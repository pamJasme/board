<?php

class User extends AppModel
{
    const MIN_VALUE = 5;
    const MAX_VALUE = 12;

    public $validation =array(

        'username' => array(
            'length' => array(
                'validate_between', self::MIN_VALUE, self::MAX_VALUE,
                ),
            'format' => array(
                'validate_username'
            ),
        ),

        'password' => array(
            'length' => array(
                'validate_between', self::MIN_VALUE, self::MAX_VALUE,
                ),
            ),
    );

    /**
    * validation for username and password
    * @throws RecordnotFoundException
    * @param $username
    * @param $password
    **/
    public function userValidate($username, $password)
    {
        $this->username = $username;
        $this->password = $password;
        if (!$this->validate()) {
            throw new ValidationException("Invalid Username/Password");
        }

        $db=DB::conn();
        $row = $db->row("SELECT * FROM user_info 
            WHERE username = ? AND user_password = ?", array($username, $password));
        if(!$row) {
            throw new RecordNotFoundException("Record not found");
        }  
        return new self($row);
    }
}