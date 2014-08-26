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
        $defaults = array(
                'username' => $username,
                'user_password' => $user_password,
                'fname' => $fname,
                'lname' => $lname,
                'email' => $email,
                'created' => date('Y-m-d H:i:s'),
                );
        
        $db = DB::conn();
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