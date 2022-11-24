<?php

if (!function_exists('cleanString')) {

    // handling sql injection
    function cleanString($string): string
    {
        $string = trim($string);
        $string = stripslashes($string);
        return htmlspecialchars($string);
    }
}
