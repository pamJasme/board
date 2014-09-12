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
        $user = new User;
        $login_info = array(
            'username' => $username,
            'password' => $password,
        );
        
        if (!array_filter($login_info)) {
            $status = "";
        } else {
            try {
                foreach ($login_info as $key => $value) {
                    if (!is_complete($value)) {
                        throw new ValidationException("Please fill up all fields");
                    }
                }

                $user_login = $user->authenticate($username, $password);
                $_SESSION['username'] = $user_login->username;
                $_SESSION['user_id'] = $user_login->user_id;
                redirect(url('thread/index'));
                } catch (ValidationException $e) {
                    $status = notice($e->getMessage(), "error");
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
        $username = Param::get('username');
        $password = Param::get('pword');
        $password_match = Param::get('pword_match');
        $fname = Param::get('fname');
        $lname = Param::get('lname');
        $email = Param::get('email');
        $registration = new Registration;
        
        $login_info = array(
            'username' => $username,
            'user_password' => $password,
            'fname' => $fname,
            'lname' => $lname,
            'email' => $email,
        );
        
        //To check if all keys are null
        if (!array_filter($login_info)) {
            $status = "";
        } else {
            try {
                foreach ($login_info as $key => $value) {
                    if (!is_complete($value)) {
                        throw new ValidationException("Please fill up all fields");
                    }
                }

                if(!is_password_match($password, $password_match)) {
                    throw new ValidationException("Password did not match");
                }

                $info = $registration->userRegistration($login_info);
                $status = notice("Registration Complete");
                } catch (ExistingUserException $e) {
                    $status = notice($e->getMessage(), "error");
                } catch (ValidationException $e) {
                    $status = notice($e->getMessage(), "error");
                }
            }
       $this->set(get_defined_vars());
    }
}

