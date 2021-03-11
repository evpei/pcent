<?php
namespace App\Core\Support;

class Str {
    public static function between($string, $start, $end) : ?string{
        $string = ' ' . $string;
        $ini = strpos($string, $start);
        if ($ini == 0) {
            return null;
        }

        $ini += strlen($start);
        $len = strpos($string, $end, $ini) - $ini;   

        return substr($string, $ini, $len);
    }
}

