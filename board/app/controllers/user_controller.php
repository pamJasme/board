<?php
session_start();
class UserController extends AppController
{
	public function index()
	{
		$username=Param::get('login_name');
		$password=Param::get('login_pword');
		$registered_user= new User;

		if (empty($username) || empty($password)) {
           
           echo"<script>alert('Please fill up all fields');</script>";
        }
		else
		{	
			$obj = $registered_user->userValidate($username, $password);
			$_SESSION['username'] = $obj->username;
			header('location: thread/index');
			
		}
	}
}
	/*public function userValidation()
	{
		if(ctype_alnum($username))
		{
			//wait lang
			
		}
		else
		{
			echo"<script>alert('Username format: Alphanumeric.');</script>";
		}
	}*/

