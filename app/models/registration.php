<?php

/**
* class Registration
**/
class Registration extends AppModel
{
    
    public $validation =array(

        "username" => array(
            "length" => array(
                "validate_between", MIN_VALUE, MAX_VALUE,
                ),
            "format" => array(
                'validate_username', "Invalid Username"
            )
        ),

        "password" => array(
            "length" => array(
                "validate_between", MIN_VALUE, MAX_VALUE,
                ),
            ),

        "email" => array(
            "format" => array(
                "validate_email", "Invalid Email Address"
                )
            ),
        );
    /**
    * To validate user registration
    * @throws IncompleteFieldsException, ValidationException, ExistingUserException
    * @param $infos(array)
    */
    public function userRegistration(array $user_info)
    {
        extract($user_info);
        $defaults = array(
                'username' => $username,
                'user_password' => $user_password,
                'fname' => $fname,
                'lname' => $lname,
                'email' => $email,
                'created' => date('Y-m-d H:i:s'),
                );
        $this->username = $username;
        $this->password = $user_password;
        $this->email = $email;
        if (!$this->validate()) {
            throw new ValidationException("Invalid Username/Password");
            return;
        }
        $db = DB::conn();
        $query = "SELECT username, email FROM user_info
                    WHERE username = ? OR email = ?";
        $params = array($username, $email);
        $search = $db->row($query, $params);
        if($search){
            throw new ExistingUserException(notice("Username/Email already used","error"));
        }
        $row = $db->insert('user_info', $defaults);
    }
}