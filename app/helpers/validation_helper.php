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
    $username_length = strlen($username);
    $username_chars = ctype_alnum($username);

    if (!isset($username)) {
        return true;
    }
    if (!(MIN_VALUE <= $username_length && $username_length <= MAX_VALUE) OR !$username_chars) {
        throw new ValidationException('Username must contain 5 - 12 Alphanumeric Characters');
    }
    return;
}

/**
* To check user's password format
**/
function validate_password($password)
{
    $password_length = strlen($password);

    if (!isset($password)) {
        return true;
    }
    if (!(MIN_VALUE <= $password_length && $password_length <= MAX_VALUE) OR !$password_chars) {
        throw new ValidationException('Password must contain 5 - 12 Characters');
    }
    return;
}

/**
* To check user's email format
**/
function validate_email($email)
{
    if (!isset($email)) {
        return true;
    }
    if (!preg_match("/^[A-z](.*)@(.*)\.(.*)/", $email)) {
        throw new ValidationException("Invalid Email Address");
    }
    return;

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