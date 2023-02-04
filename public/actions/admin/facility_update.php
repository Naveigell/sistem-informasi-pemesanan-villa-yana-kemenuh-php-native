<?php

require_once '../../../server.php';

$roomId = $_GET['room_id'];
$name   = $_POST['name'];

\App\Models\Facility::instance()->raw("UPDATE facilities SET name = ? WHERE id = ?", [$name, $_GET['id']]);

redirect($routes['admin.rooms.facilities.index'] . '?' . http_build_query(["room_id" => $roomId]));