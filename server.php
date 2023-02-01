<?php

session_start();

const DOMAIN = "http://localhost:8000";

require_once 'lib/helper.php';
$routes = require_once 'public/routes.php';

spl_autoload_register(function ($classname) {
    include_once dirname(__FILE__) . "/" . str_replace("\\", "/", $classname) . '.php';
});