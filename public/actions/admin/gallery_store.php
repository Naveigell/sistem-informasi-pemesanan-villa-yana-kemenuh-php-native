<?php

require_once '../../../server.php';

$image = $_FILES['image'];
$filename = str_random(40) . ".jpg";

if ($image['name']) {
    move_uploaded_file($image['tmp_name'], "../../uploads/images/rooms/" . $filename);

    \App\Models\RoomImage::instance()->create(["name" => $filename, "is_main" => 0, "room_id" => $_GET["room_id"]]);
}

redirect($routes['admin.rooms.galleries.index'] . '?' . http_build_query($_GET));