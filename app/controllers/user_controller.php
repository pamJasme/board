<?php
class UserController extends AppController
{
    const MIN_VALUE = 5;
    const MAX_VALUE = 12;

    /**
    * To check if username is valid and existing
    * To check if username and password matched
    * Validation to proceed to Thread page
    **/
    public function index()
    {
        $username = Param::get('login_name');
        $password = Param::get('login_pword');
        $registered_user = new User;

        try {
            if (empty($username) OR empty($password)){
                throw new IncompleteFieldsException("Fill up all fields");
            }
        }catch (IncompleteFieldsException $e) {
                $status = notice($e->getMessage(), "error");
                echo $status;
                return;
            }

        try {
                $obj = $registered_user->userValidate($username, $password);   
                $_SESSION['username'] = $obj->username;
                $_SESSION['password'] = $obj->password;
                redirect('thread','index');
            }catch (ValidationException $e) {
                $status = notice($e->getMessage(),"error");
                echo $status;
            }catch (RecordNotFoundException $e) {
                $status = notice($e->getMessage(),"error");
                echo $status;
            }
            
        $this->set(get_defined_vars());           
    }

    /**
    * To register new user
    * Subject for validations (e.g username length)
    **/
    public function registration()
    {
        $new_username = Param::get('username');
        $new_password = Param::get('pword');
        $new_fname = Param::get('fname');
        $new_lname = Param::get('lname');
        $new_email = Param::get('email');
        $reg = new Registration;
        
        $user_info = array(
            'username' => $new_username,
            'user_password' => $new_password,
            'fname' => $new_fname,
            'lname' => $new_lname,
            'email' => $new_email,
            );

        try {
            validate_username($new_username);
            validate_password($new_password);
            letters_only($new_fname);
            letters_only($new_lname);
            validate_email($new_email);
        }catch (ValidationException $e) {
               $status = notice($e->getMessage(), "error");
               echo $status;
            }

        foreach ($user_info as $field => $value) {
            $user_info['$field'] = $value;
        }

        try {
            foreach ($user_info as $field => $value) {
                if(is_null($value)){
                    throw new IncompleteFieldsException("All fields are required");
                }
            }
            $info = $reg->userRegistration($user_info);
        }catch (IncompleteFieldsException $e) {
            $status = notice($e->getMessage(), "error");
            echo $status;
        }catch (ExistingUserException $e) {
            $status = notice($e->getMessage(), "error");
            echo $status;
        }catch (ValidationException $e) {
            $status = notice($e->getMessage(), "error");
            echo $status;
        }
        
        $this->set(get_defined_vars());
        unset($user_info);
    }
}