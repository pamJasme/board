<?php

/**
* class Registration
**/
class Registration extends AppModel
{
    /**
    * To validate user registration
    * @throws IncompleteFieldsException
    * @throws ValidationException
    * @throws ExistingUserException
    * @param $infos(array)
    */
    public function userRegistration(array $user_info)
    {
        
        extract($user_info);
        foreach ($user_info as $field => $value) {
            if(empty($user_info['$field'])){
                throw new IncompleteFieldsException("Please fill up all fields");
            }
        }
        $db = DB::conn();
        $defaults = array(
            'username' => $username,
            'user_pword' => $user_pword,
            'fname' => $fname,
            'lname' => $lname,
            'email' => $email,
            'created' => date('Y-m-d H:i:s'),
            );
        $check_uname = validate_between($username, 5, 12);
        $check_pass = validate_between($user_pword, 6, 8);
        
        if(!$check_uname OR !ctype_alnum($username)){
            throw new ValidationException("Invalid Username : 6-12 Alphanumeric characters");
        }

        if(!$check_pass){
            throw new ValidationException("Password: 6-8 characters");
        }

        if(!preg_match("/^[A-z](.*)@(.*)\.(.*)/", $email)){
            throw new ValidationException("Invalid Email Address");
        }
        $query = "SELECT username, email FROM user_info
                    WHERE username = ? OR email = ?";
        $params = array($username, $email);
        $search = $db->rows($query, $params);
        if($search){
            throw new ExistingUserException("Username/Email already used");
        }
        $row = $db->insert('user_info', $defaults);
        unset($user_info);
    }
}