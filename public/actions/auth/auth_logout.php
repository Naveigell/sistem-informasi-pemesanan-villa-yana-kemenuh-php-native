<?php

require_once '../../../server.php';

session_destroy();

redirect($routes['home.index']);