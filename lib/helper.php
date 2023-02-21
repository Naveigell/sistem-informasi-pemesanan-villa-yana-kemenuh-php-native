<?php

if (!function_exists('times')) {
    function times($number, callable $callback) {
        foreach (range(0, $number - 1) as $index) {
            $callback($index);
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

if (!function_exists('redirect_with_javascript')) {
    function redirect_with_javascript($url) {
        echo "<script>window.location.href = {$url}</script>";
    }
}

if (!function_exists('redirect')) {
    function redirect($path) {
        header("Location: " . DOMAIN . "/" . $path);
    }
}

if (!function_exists('format_currency')) {
    function format_currency($price, $currency = 'Rp.', $decimal = 0, $decimalSeparator = ',', $thousandSeparator = '.') {
        return $currency . ' ' . number_format($price, $decimal, $decimalSeparator, $thousandSeparator);
    }
}

if (!function_exists('route')) {
    function route(string $name) {
        global $routes;

        if (array_key_exists($name, $routes)) {
            return DOMAIN . DIRECTORY_SEPARATOR . $routes[$name];
        }

        return '';
    }
}

if (!function_exists('dump')) {
    function dump() {
        echo "<pre>";
        var_dump(func_get_args());
        echo "</pre>";
    }
}

if (!function_exists('asset')) {
    function asset($path) {
        return DOMAIN . DIRECTORY_SEPARATOR . trim($path, DIRECTORY_SEPARATOR);
    }
}