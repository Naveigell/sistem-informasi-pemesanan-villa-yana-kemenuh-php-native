<?php

require_once '../../../server.php';

$roomId = $_GET['room_id'];
$name   = $_POST['name'];

\App\Models\Facility::instance()->create([
    "room_id" => $roomId,
    "name"    => $name
]);

redirect($routes['admin.rooms.facilities.index'] . '?' . http_build_query($_GET));