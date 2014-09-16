<?php

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
function redirect($url) 
{
   header("Location: ".$url);
}

/**
* To check if there is a running session
**/
function is_logged_in()
{
    if (isset($_SESSION['user_id'])) {
        return true;
    }
    return false;
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
* To check if fields are complete
**/
function is_complete($value)
{
    $check_if_complete = validate_between($value, NULL, NULL);
    if ($check_if_complete) {
        return false;
    }
    return true;
}

/**
* To check if password match
**/
function is_password_match($password_a, $password_b)
{
    if ($password_a === $password_b) {
        return true;
    }
    return false;
}

/**
* To check if names are valid
**/
function validate_name($name)
{
    if (ctype_alpha($name)) {
        return true;
    }
    return false;
}
