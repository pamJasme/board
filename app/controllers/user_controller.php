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
        $user = array(
            'username' => $username,
            'password' => $password,
            );

        if (!array_filter($user)) {
            $status = "";
        } else {
            try {
                foreach ($user as $key => $value) {
                    is_complete($value);
                }
                $login_info = $registered_user->authenticate($username, $password);
                $_SESSION['username'] = $login_info->username;

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
        $new_username = Param::get('username');
        $new_password = Param::get('pword');
        $new_password_match = Param::get('pword_match');
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
        
        //To check if all keys are null
        if (!array_filter($user_info)) {
            $status = "";
        } else {
            try {
                password_match($new_password, $new_password_match);
                foreach ($user_info as $key => $value) {
                    is_complete($value);
                }
                $info = $reg->userRegistration($user_info);
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