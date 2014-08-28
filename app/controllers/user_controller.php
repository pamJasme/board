<?php
class UserController extends AppController
{
    const MIN_INPUT = 1;
    const MAX_INPUT = 20;
    
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
            $valid_username = validate_between($username, self::MIN_INPUT, self::MAX_INPUT);
            $valid_password = validate_between($password, self::MIN_INPUT, self::MAX_INPUT);
            if (!$valid_username || !$valid_password) {
                throw new ValidationException("Fill up all fields");
            }
            $login_info = $registered_user->authenticate($username, $password);   
            $_SESSION['username'] = $login_info->username;
            $_SESSION['password'] = $login_info->password;
            redirect(url('thread/index'));
            } catch (ValidationException $e) {
                $status = notice($e->getMessage(),"error");
            } catch (RecordNotFoundException $e) {
                $status = notice($e->getMessage(),"error");
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

        try {
            foreach ($user_info as $key => $value) {
                $valid = validate_between($value, self::MIN_INPUT, self::MAX_INPUT);
                if (!$valid) {
                    throw new ValidationException("Fill up all fields");
                }
            }
                $info = $reg->userRegistration($user_info);
                $status = notice("Registration Complete", "error");
            } catch (ExistingUserException $e) {
                $status = notice($e->getMessage(), "error");
            } catch (ValidationException $e) {
                $status = notice($e->getMessage(), "error");
            }
        $this->set(get_defined_vars());
    }
}