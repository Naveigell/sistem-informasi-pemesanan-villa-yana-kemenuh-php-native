<?php

function exception_error_handler($errno, $errstr, $errfile, $errline ) {
    throw new ErrorException($errstr, $errno, 0, $errfile, $errline);
}
// enable the error if file not found
set_error_handler("exception_error_handler");

try {
    require_once 'vendor/autoload.php';
} catch (Exception $e) {
    die("Please install composer or running 'composer install'");
}

$dotenv = new Symfony\Component\Dotenv\Dotenv();
$dotenv->load(__DIR__.'/.env');

spl_autoload_register(function ($classname) {
    include_once dirname(__FILE__) . "/" . str_replace("\\", "/", $classname) . '.php';
});

// disable the error again
set_error_handler(fn() => true);

