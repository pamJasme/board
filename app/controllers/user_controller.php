<?php
class UserController extends AppController
{
	public function index()
	{
		
		$username = Param::get('login_name');
		$password = Param::get('login_pword');

		if(!empty($username) AND !empty($password))
		{
			$registered_user = new User;
			  try {
	                $obj = $registered_user->userValidate($username, $password);   
	                $_SESSION['username'] = $obj->username;
					$_SESSION['password'] = $obj->password;
	                redirect('thread','index');
	            } catch (ValidationException $e) {
	                $status = notice($e->getMessage(),"error");
	                echo $status;
	            } catch (RecordNotFoundException $e) {
	                $status = notice($e->getMessage(),"error");                        
	                echo $status;
	            }
	    }
	    else
	    {
	    	$status = "";
	    }
		$this->set(get_defined_vars());
				

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
        try{
			$user_info = $reg->userRegistration($infos);
		}catch(IncompleteFieldsException $e) {
			$status = notice($e->getMessage(), "error");
			echo $status;
		}catch(ExistingUserException $e) {
			$status = notice($e->getMessage(), "error");
			echo $status;
		}catch(ValidationException $e) {
			$status = notice($e->getMessage(), "error");
			echo "$status";
		}

		
		$this->set(get_defined_vars());	
    }
    
}