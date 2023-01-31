<?php

if (!function_exists('times')) {
    function times($number, callable $callback) {
        foreach (range(1, $number) as $num) {
            $callback();
        }
    }
}

if (!function_exists('str_random')) {
    function str_random(int $length = 25): string {
        $string = '';

        while (($len = strlen($string)) < $length) {
            $size = $length - $len;

            $bytes = random_bytes($size);

            $string .= substr(str_replace(['/', '+', '='], '', base64_encode($bytes)), 0, $size);
        }

        return $string;
    }
}