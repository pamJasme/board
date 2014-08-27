<?php
const MIN_VALUE = 5;
const MAX_VALUE = 12;

/**
* To set variable ranges
**/
function validate_between($check, $min, $max)
{
   $n = mb_strlen($check);
   return $min <= $n && $n <= $max;
}

/**
* To redirect to some other pages
**/
function redirect($controller, $view, array $url_query = null)
{
    $url = "/$controller/$view";
    if ($url_query) {
        foreach ($url_query as $key => $value) {
            $url .= "?$key=$value";
        }
    }
    header("location: {$url}");
}

/**
* To check if there is a running session
**/
function check_if_logged_out()
{
    if (!isset($_SESSION['username'])) {
        redirect('user', 'index');
    }
}

/**
* To check user's username format
**/
function validate_username($username)
{
     return !((preg_match('/[^a-zA-Z0-9_]/', $username)) || (preg_match('/_{2}/', $username)));
}

/**
* To check user's email format
**/
function validate_email($email)
{
    return (preg_match("/^[A-z](.*)@(.*)\.(.*)/", $email));
}

/**
* To check user's name format
**/
function letters_only($name)
{
    if (!isset($name)) {
        return true;
    }

    if (!preg_match("/[A-Za-z]/", $name)) {
        throw new ValidationException("Your first/last name contains invalid characters.");
    }
}

function is_complete($username, $password)
{
    if(!isset($username) OR !isset($password))
    {
        return true;
    }
    if (empty($username) OR empty($password)){
        throw new IncompleteFieldsException("Fill up all fields");
    }
}
