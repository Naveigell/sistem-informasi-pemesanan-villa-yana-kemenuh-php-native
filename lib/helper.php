<?php

if (!function_exists('times')) {
    function times($number, callable $callback) {
        foreach (range(1, $number) as $num) {
            $callback();
        }
    }
}