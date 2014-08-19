<?php
class UserController extends AppController
{
	public function index()
	{
		$username=Param::get('login_name');
		$password=Param::get('login_pword');
		$registered_user= new User;

		
		if(!empty($username) AND !empty($password))
		{	
		
			$obj = $registered_user->userValidate($username, $password);
			$_SESSION['username'] = $obj->username;
			$_SESSION['password'] = $obj->user_pword;
			$this->set(get_defined_vars());
			header('Location: thread/index');
				
		}

	}
	public function registration()
	{
		$new_username=Param::get('username');
		$new_password=Param::get('pword');
		$new_fname=Param::get('fname');
		$new_lname=Param::get('lname');
		$new_email=Param::get('email');
        $reg = new Registration;
        
        $infos = array(
        	'username' => $new_username,
        	'user_pword' => $new_password,
        	'fname' => $new_fname,
        	'lname' => $new_lname,
        	'email' => $new_email,
        	);

        foreach ($infos as $field => $value) {
        	$infos['$field'] = $value;
        	// /echo $infos['$field'];
        }
		$user_info = $reg->userRegistration($infos);
		$this->set(get_defined_vars());	
    }
    
	

	
}