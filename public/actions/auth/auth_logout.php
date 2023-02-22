<?php

require_once '../../../server.php';

session_start();
session_destroy();

redirect($routes['home.index']);