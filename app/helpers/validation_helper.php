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
