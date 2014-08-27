<?php
class UserController extends AppController
{
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
        
        if (!isset($username) OR !isset($password)) {
            $status = " ";
        } elseif (empty($username) OR empty($password)) {
            $status = notice("All fields are required", "error");
        } else {            
            try {
                $login_info = $registered_user->userValidate($username, $password);   
                $_SESSION['username'] = $login_info->username;
                $_SESSION['password'] = $login_info->password;
                redirect('thread','index');
            } catch (ValidationException $e) {
                $status = notice($e->getMessage(),"error");
            } catch (RecordNotFoundException $e) {
                $status = notice($e->getMessage(),"error");
            }
        }
        $this->set(get_defined_vars());           
    }

    /**
    * To register new user
    * Subject for validations (e.g username length)
    **/
    public function registration()
    {
        unset($user_info);
        $new_username = Param::get('username');
        $new_password = Param::get('pword');
        $new_fname = Param::get('fname');
        $new_lname = Param::get('lname');
        $new_email = Param::get('email');
        $empty_field = 0;
        $reg = new Registration;
        
        $user_info = array(
            'username' => $new_username,
            'user_password' => $new_password,
            'fname' => $new_fname,
            'lname' => $new_lname,
            'email' => $new_email,
            );

        foreach ($user_info as $field => $value) {
            if (!$value) {
                $empty_field++;
            } else {
                $user_info['$field'] = $value;
            }
        }

        if ($empty_field === 0){
            try {
                $info = $reg->userRegistration($user_info);
                $status = notice("Registration Complete", "error");
            } catch (ExistingUserException $e) {
                $status = notice($e->getMessage(), "error");
            } catch (ValidationException $e) {
                $status = notice($e->getMessage(), "error");
            }
        } else {
            $status = notice("Please fill up all fields",'error');
        }
        $this->set(get_defined_vars());
    }
}