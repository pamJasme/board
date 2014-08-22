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

		try{
				if(empty($username) OR empty($password)){
				throw new IncompleteFieldsException("Fill up all fields");
				}	
			}catch (IncompleteFieldsException $e){
				$status = notice($e->getMessage(), "error");
				echo $status;
				return;
			}
				
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
		$this->set(get_defined_vars());
				
	}

	/**
	* Function to register new user
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
        
        $infos = array(
        	'username' => $new_username,
        	'user_pword' => $new_password,
        	'fname' => $new_fname,
        	'lname' => $new_lname,
        	'email' => $new_email,
        	);

        foreach ($infos as $field => $value) {
        	$infos['$field'] = $value;
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
			echo $status;
		}
		
		$this->set(get_defined_vars());	
    }
    
}