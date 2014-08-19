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
			header('Location: thread/index');
			
		}
	}

	/*public function register()
	{
		$reg = new Registration;


	}*/ //proposed user registration
}
	

