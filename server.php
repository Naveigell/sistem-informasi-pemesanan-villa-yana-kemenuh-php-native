<?php

session_start();

$routes = require_once 'public/routes.php';
require_once 'lib/helper.php';
require_once 'config.php';

require_once 'loader.php';
require_once 'middleware.php';

define("DOMAIN", $_ENV['DOMAIN']);