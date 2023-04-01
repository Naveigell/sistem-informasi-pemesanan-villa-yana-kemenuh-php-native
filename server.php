<?php

session_start();

const DOMAIN = "http://localhost:8000";

$routes = require_once 'public/routes.php';
require_once 'lib/helper.php';
require_once 'config.php';

spl_autoload_register(function ($classname) {
    include_once dirname(__FILE__) . "/" . str_replace("\\", "/", $classname) . '.php';
});