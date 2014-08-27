<?php

function eh($string)
{
    if (!isset($string)) return;
    echo htmlspecialchars($string, ENT_QUOTES);
}

function readable_text($s)
{
    $s = htmlspecialchars($s, ENT_QUOTES);
    $s = nl2br($s);
    return $s;
}
function notice($text, $notice_type = NULL)
{
    $msg = "<center>";
    if ($notice_type == 'error') {
        return $msg .= "<font color=red size=2>" . $text . "</font></center>";
    }

    return $msg .= "<font color=green size=2>" . $text . "</font></center>";
}

